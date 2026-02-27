<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Venta;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class ExportPDFController extends Controller
{
    /**
     * Exportar en formato PDF el comprobante de venta
     */
    public function exportPdfComprobanteVenta(Request $request): Response
    {
        $id = Crypt::decrypt($request->id);

        $venta = Venta::findOrfail($id);
        $empresa = Empresa::first();

        $pdf = Pdf::loadView('pdf.comprobante-venta', [
            'venta' => $venta,
            'empresa' => $empresa
        ]);

        return $pdf->stream('venta-' . $venta->id);
    }

    public function exportPdfCotizacion(Request $request): Response
    {
        // No need to decrypt if we pass ID directly, but for consistency let's see. 
        // Venta uses Crypt, let's stick to simple ID for now unless user needs security.
        // Actually, let's follow the pattern if possible, but for now standard ID.
        $cotizacion = Cotizacion::with(['cliente.persona', 'user', 'productos'])->findOrfail($request->id);
        $empresa = Empresa::first();

        $pdf = Pdf::loadView('pdf.cotizacion', compact('cotizacion', 'empresa'));

        return $pdf->stream('cotizacion-' . $cotizacion->id . '.pdf');
    }
}
