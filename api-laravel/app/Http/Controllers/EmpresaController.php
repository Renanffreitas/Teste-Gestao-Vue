<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function index() {
        return Empresa::all();
    }

    public function show($codigo) {
        return Empresa::where('codigo', $codigo)->firstOrFail();
    }

    public function store(Request $request) {
        $request->validate([
            'codigo' => 'required|numeric|unique:empresas,codigo',
            'empresa' => 'required|numeric',
            'sigla' => 'nullable|string|max:40',
            'razao_social' => 'nullable|string|max:255',
        ]);

        return Empresa::create($request->all());
    }

    public function update(Request $request, $codigo) {
        $empresa = Empresa::where('codigo', $codigo)->firstOrFail();
        $empresa->update($request->all());
        return $empresa;
    }

    public function destroy($codigo) {
        Empresa::where('codigo', $codigo)->delete();
        return response()->json(null, 204);
    }
}

