<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LibrarySummaryExport;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Exportar resumen de la biblioteca en formato Excel.
     *
     * Solo usuarios con rol "directivo" pueden realizar esta acción.
     *
     * @authenticated
     *
     * @response 200 file excel Respuesta con el archivo Excel para descargar.
     *
     * @response 403 {
     *   "error": "No autorizado."
     * }
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\JsonResponse
     */
    public function export(Request $request)
    {
        if (auth()->user()->role !== 'directivo') {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return Excel::download(new LibrarySummaryExport, 'resumen_biblioteca.xlsx');
    }
}
