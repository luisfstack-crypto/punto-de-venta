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
use Illuminate\Support\Facades\Mail;
use App\Mail\CotizacionMail;

class CotizacionController extends Controller
{
    protected EmpresaService $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->middleware('auth')->except(['publica', 'responder']);
        $this->empresaService = $empresaService;
    }

    public function index()
    {
        $cotizaciones = Cotizacion::with(['cliente.persona', 'user'])->latest()->get();
        return view('cotizacion.index', compact('cotizaciones'));
    }

    public function create()
    {
        $productos = Producto::where('estado', 1)->get();
        $clientes  = Cliente::with('persona')->get();
        $empresa   = $this->empresaService->obtenerEmpresa();
        return view('cotizacion.create', compact('productos', 'clientes', 'empresa'));
    }

    public function store(StoreCotizacionRequest $request)
    {
        try {
            DB::beginTransaction();

            $cotizacion = Cotizacion::create([
                'fecha_hora'      => now(),
                'fecha_validez'   => $request->fecha_validez,
                'impuesto'        => $request->impuesto ?? 0,
                'total'           => $request->total,
                'aplicar_iva'     => $request->boolean('aplicar_iva'),
                'descuento_global' => $request->descuento_global ?? 0,
                'estado'          => 1,
                'cliente_id'      => $request->cliente_id,
                'user_id'         => Auth::id(),
                'observaciones'   => $request->observaciones,
            ]);

            $arrayidproducto = $request->arrayidproducto;
            $arraycantidad = $request->arraycantidad;
            $arrayprecioventa = $request->arrayprecioventa;
            $arraydescuento = $request->arraydescuento;
            $arraydescripcion = $request->arraydescripcion;

            foreach ($arrayidproducto as $index => $id) {
                $cotizacion->productos()->attach($id, [
                    'cantidad'    => $arraycantidad[$index],
                    'precio'      => $arrayprecioventa[$index],
                    'descuento'   => $arraydescuento[$index] ?? 0,
                    'descripcion' => $arraydescripcion[$index] ?? null,
                ]);
            }

            DB::commit();
            return redirect()->route('cotizaciones.show', $cotizacion)
                ->with('success', 'Cotización registrada');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al crear cotización', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al registrar la cotización');
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
            Mail::to($cotizacion->cliente->persona->email)
                ->send(new CotizacionMail($cotizacion));

            $cotizacion->update(['enviado_at' => now()]);

            return redirect()->back()->with('success', 'Cotización enviada por correo');
        } catch (Exception $e) {
            Log::error('Error al enviar cotización', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'No se pudo enviar el correo');
        }
    }

    public function renew(Request $request, Cotizacion $cotizacion)
    {
        $request->validate(['fecha_validez' => 'required|date|after:today']);
        $cotizacion->update(['fecha_validez' => $request->fecha_validez]);
        return redirect()->back()->with('success', 'Vigencia actualizada');
    }

    public function updateStatus(Request $request, Cotizacion $cotizacion)
    {
        $request->validate(['estado' => 'required|in:1,2,3']);
        $cotizacion->update(['estado' => $request->estado]);
        return redirect()->back()->with('success', 'Estado actualizado');
    }

    /**
     * Vista pública — sin login requerido
     */
    public function publica(string $token)
    {
        $cotizacion = Cotizacion::where('token_publico', $token)
            ->with(['cliente.persona', 'productos', 'user'])
            ->firstOrFail();

        $empresa = $this->empresaService->obtenerEmpresa();

        return view('cotizacion.publica', compact('cotizacion', 'empresa'));
    }

    /**
     * El cliente acepta o rechaza desde la vista pública
     */
    public function responder(Request $request, string $token)
    {
        $request->validate(['decision' => 'required|in:aceptar,rechazar']);

        $cotizacion = Cotizacion::where('token_publico', $token)->firstOrFail();

        if ($cotizacion->estado != 1) {
            return redirect()->route('cotizaciones.publica', $token)
                ->with('info', 'Esta cotización ya fue procesada.');
        }

        $cotizacion->update([
            'estado' => $request->decision === 'aceptar' ? 2 : 3,
        ]);

        $mensaje = $request->decision === 'aceptar'
            ? 'Cotización aceptada exitosamente.'
            : '❌ Cotización rechazada.';

        return redirect()->route('cotizaciones.publica', $token)->with('success', $mensaje);
    }
}
