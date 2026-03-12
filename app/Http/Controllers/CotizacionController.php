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

        $stats = [
            'total_sent'      => $cotizaciones->whereNotNull('enviado_at')->count(),
            'amount_sent'     => $cotizaciones->whereNotNull('enviado_at')->sum('total'),
            'total_pending'   => $cotizaciones->where('estado', 1)->count(),
            'amount_pending'  => $cotizaciones->where('estado', 1)->sum('total'),
            'total_expired'   => $cotizaciones->where('estado', 1)->where('fecha_validez', '<', now()->format('Y-m-d'))->count(),
            'amount_expired'  => $cotizaciones->where('estado', 1)->where('fecha_validez', '<', now()->format('Y-m-d'))->sum('total'),
            'total_approved'  => $cotizaciones->where('estado', 2)->count(),
            'amount_approved' => $cotizaciones->where('estado', 2)->sum('total'),
            'total_rejected'  => $cotizaciones->where('estado', 3)->count(),
            'amount_rejected' => $cotizaciones->where('estado', 3)->sum('total'),
        ];

        return view('cotizacion.index', compact('cotizaciones', 'stats'));
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
        if (empty($cotizacion->cliente->persona->email)) {
            return redirect()->back()->with('error', 'El cliente no tiene un correo electrónico registrado.');
        }

        try {
            $empresa = $this->empresaService->obtenerEmpresa();

            \Illuminate\Support\Facades\Config::set('mail.from.name', $empresa->nombre ?? 'Punto de Venta');

            if ($empresa->mail_host && $empresa->mail_username && $empresa->mail_password) {
                \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.host', $empresa->mail_host);
                \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.port', $empresa->mail_port ?? 587);
                \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.username', $empresa->mail_username);
                \Illuminate\Support\Facades\Config::set('mail.mailers.smtp.password', $empresa->mail_password);
                \Illuminate\Support\Facades\Config::set('mail.from.address', $empresa->mail_username);
            }

            // SIN app()->forgetInstances()

            Mail::to($cotizacion->cliente->persona->email)
                ->send(new CotizacionMail($cotizacion, $empresa));

            $cotizacion->update(['enviado_at' => now()]);

            return redirect()->back()->with('success', 'Cotización enviada por correo');

        } catch (Exception $e) {
            Log::error('Error al enviar cotización', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'No se pudo enviar: ' . $e->getMessage());
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

    public function edit(Cotizacion $cotizacion)
    {
        $clientes    = Cliente::with('persona')->get();
        $productos   = Producto::where('estado', 1)->get();
        $empresa     = $this->empresaService->obtenerEmpresa();
        return view('cotizacion.edit', compact('cotizacion', 'clientes', 'productos', 'empresa'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {

        if ($cotizacion->estado != 1) {
            return back()->with('error', 'Solo se pueden editar cotizaciones pendientes.');
        }
        
        try {
            DB::beginTransaction();
            $cotizacion->update([
                'fecha_validez'   => $request->fecha_validez,
                'impuesto'        => $request->impuesto ?? 0,
                'total'           => $request->total,
                'aplicar_iva'     => $request->boolean('aplicar_iva'),
                'descuento_global' => $request->descuento_global ?? 0,
                'observaciones'   => $request->observaciones,
                'cliente_id'      => $request->cliente_id,
            ]);

            $arrayidproducto = $request->arrayidproducto;
            $arraycantidad = $request->arraycantidad;
            $arrayprecioventa = $request->arrayprecioventa;
            $arraydescuento = $request->arraydescuento;
            $arraydescripcion = $request->arraydescripcion;

            $syncData = [];
            foreach ($arrayidproducto as $index => $id) {
                $syncData[$id] = [
                    'cantidad'    => $arraycantidad[$index],
                    'precio'      => $arrayprecioventa[$index],
                    'descuento'   => $arraydescuento[$index] ?? 0,
                    'descripcion' => $arraydescripcion[$index] ?? null,
                ];
            }
            $cotizacion->productos()->sync($syncData);

            DB::commit();
            return redirect()->route('cotizaciones.show', $cotizacion)
                ->with('success', 'Cotización actualizada');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al editar cotización', ['error' => $e->getMessage()]);
            return back()->with('error', 'Error al actualizar la cotización');
        }
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
