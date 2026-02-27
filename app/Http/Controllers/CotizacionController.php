<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCotizacionRequest;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\Producto;
use App\Services\EmpresaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionMail;

class CotizacionController extends Controller
{
    protected EmpresaService $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->middleware('auth');
        $this->empresaService = $empresaService;
    }

    public function index()
    {
        $cotizaciones = Cotizacion::with(['cliente.persona', 'user'])
            ->latest()
            ->get();

        // Calculate Stats
        $stats = [
            'total_sent' => $cotizaciones->whereNotNull('enviado_at')->count(),
            'amount_sent' => $cotizaciones->whereNotNull('enviado_at')->sum('total'),
            
            'total_pending' => $cotizaciones->where('estado', 1)->where('fecha_validez', '>=', now()->format('Y-m-d'))->count(),
            'amount_pending' => $cotizaciones->where('estado', 1)->where('fecha_validez', '>=', now()->format('Y-m-d'))->sum('total'),

            'total_approved' => $cotizaciones->where('estado', 2)->count(),
            'amount_approved' => $cotizaciones->where('estado', 2)->sum('total'),

            'total_rejected' => $cotizaciones->where('estado', 0)->count(),
            'amount_rejected' => $cotizaciones->where('estado', 0)->sum('total'),

            'total_expired' => $cotizaciones->where('estado', 1)->where('fecha_validez', '<', now()->format('Y-m-d'))->count(),
            'amount_expired' => $cotizaciones->where('estado', 1)->where('fecha_validez', '<', now()->format('Y-m-d'))->sum('total'),
        ];

        return view('cotizacion.index', compact('cotizaciones', 'stats'));
    }

    public function create()
    {
        $productos = Producto::join('inventario as i', function ($join) {
            $join->on('i.producto_id', '=', 'productos.id');
        })
            ->join('presentaciones as p', function ($join) {
                $join->on('p.id', '=', 'productos.presentacione_id');
            })
            ->select(
                'p.sigla',
                'productos.nombre',
                'productos.codigo',
                'productos.id',
                'i.cantidad',
                'productos.precio'
            )
            ->where('productos.estado', 1)
            ->get();

        $clientes = Cliente::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();

        $empresa = $this->empresaService->obtenerEmpresa();

        return view('cotizacion.create', compact('productos', 'clientes', 'empresa'));
    }

    public function store(StoreCotizacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $cotizacion = Cotizacion::create([
                'fecha_hora' => now(),
                'fecha_validez' => $request->fecha_validez,
                'impuesto' => $request->impuesto,
                'total' => $request->total,
                'estado' => 1, // Pendiente
                'cliente_id' => $request->cliente_id,
                'user_id' => Auth::id(),
                'observaciones' => $request->observaciones,
            ]);

            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioVenta = $request->get('arrayprecioventa');

            $siseArray = count($arrayProducto_id);
            $cont = 0;

            while ($cont < $siseArray) {
                $cotizacion->productos()->attach($arrayProducto_id[$cont], [
                    'cantidad' => $arrayCantidad[$cont],
                    'precio' => $arrayPrecioVenta[$cont],
                    'descuento' => 0 // Default 0 for now
                ]);
                $cont++;
            }

            DB::commit();

            return redirect()->route('cotizaciones.index')->with('success', 'Cotización registrada exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creando cotización: ' . $e->getMessage());
            return redirect()->route('cotizaciones.index')->with('error', 'Ocurrió un error al registrar la cotización');
        }
    }

    public function show(Cotizacion $cotizacion)
    {
        $empresa = $this->empresaService->obtenerEmpresa();
        return view('cotizacion.show', compact('cotizacion', 'empresa'));
    }

    public function sendEmail(Cotizacion $cotizacion)
    {
        try {
            $empresa = $this->empresaService->obtenerEmpresa();
            Mail::to($cotizacion->cliente->persona->email ?? $cotizacion->cliente->email ?? 'test@example.com') // Fallback if no email
                ->send(new CotizacionMail($cotizacion, $empresa));
            
            $cotizacion->update(['enviado_at' => now()]);
                
            return back()->with('success', 'Correo enviado exitosamente');
        } catch (Exception $e) {
            Log::error('Error enviando correo cotización: ' . $e->getMessage());
            return back()->with('error', 'Error al enviar el correo: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Cotizacion $cotizacion)
    {
        try {
            $cotizacion->update(['estado' => $request->estado]);
            return back()->with('success', 'Estado actualizado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error actualizando estado');
        }
    }

    public function duplicate(Cotizacion $cotizacion)
    {
        try {
            DB::beginTransaction();

            $newCotizacion = $cotizacion->replicate();
            $newCotizacion->fecha_hora = now();
            // Keep validity or reset? User didn't specify, let's keep logic simple: maybe +7 days from now?
            // Or just keep original validity? Original might be expired. Let's set to now + 7 days default?
            // Or just replicate. Replicating keeps expired date. Let's reset date to now and validity +15 days default.
            $newCotizacion->fecha_hora = now();
            $newCotizacion->fecha_validez = now()->addDays(15);
            $newCotizacion->estado = 1; // Pending
            $newCotizacion->enviado_at = null;
            $newCotizacion->save();

            foreach ($cotizacion->productos as $product) {
                $newCotizacion->productos()->attach($product->id, [
                    'cantidad' => $product->pivot->cantidad,
                    'precio' => $product->pivot->precio,
                    'descuento' => $product->pivot->descuento
                ]);
            }

            DB::commit();
            return redirect()->route('cotizaciones.index')->with('success', 'Cotización duplicada exitosamente');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error duplicando cotización: '. $e->getMessage());
            return back()->with('error', 'Error al duplicar cotización');
        }
    }
    public function renew(Request $request, Cotizacion $cotizacion)
    {
        try {
            $request->validate(['fecha_validez' => 'required|date|after:today']);
            
            $cotizacion->update([
                'fecha_validez' => $request->fecha_validez
            ]);

            return back()->with('success', 'Vigencia de cotización renovada correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error al renovar vigencia: ' . $e->getMessage());
        }
    }
}
