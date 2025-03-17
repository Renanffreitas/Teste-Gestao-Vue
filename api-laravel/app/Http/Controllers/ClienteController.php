<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index() {
        return Cliente::all();
    }

    public function show($empresa, $codigo) {
        // Buscar pelo cliente utilizando ambos os parâmetros
        return Cliente::where('empresa', $empresa)->where('codigo', $codigo)->firstOrFail();
    }

    public function store(Request $request)
    {
        // Remover caracteres especiais do campo cpf_cnpj
        $cpf_cnpj = preg_replace('/[^0-9]/', '', $request->cpf_cnpj);

        // Validação
        $request->validate([
            'empresa' => 'required|integer',
            'codigo' => 'required|numeric|unique:clientes',
            'razao_social' => 'required|string|max:255',
            'tipo' => 'required|in:PJ,PF',
            'cpf_cnpj' => 'required|string',
        ]);

        // Validar CPF/CNPJ
        if (($request->tipo === 'PF' && strlen($cpf_cnpj) !== 11) ||
            ($request->tipo === 'PJ' && strlen($cpf_cnpj) !== 14)) {
            return response()->json([
                'message' => 'O CPF deve ter 11 dígitos e o CNPJ deve ter 14 dígitos.'
            ], 422);
        }

        // Criar cliente
        $cliente = Cliente::create([
            'empresa' => $request->empresa,
            'codigo' => $request->codigo,
            'razao_social' => $request->razao_social,
            'tipo' => $request->tipo,
            'cpf_cnpj' => $cpf_cnpj,
        ]);

        return response()->json($cliente, 201);
    }

    public function update(Request $request, $empresa, $codigo)
    {
        // Remover caracteres especiais do campo cpf_cnpj
        $cpf_cnpj = preg_replace('/[^0-9]/', '', $request->cpf_cnpj);

        // Validação
        $request->validate([
            'razao_social' => 'required|string|max:255',
            'tipo' => 'required|in:PJ,PF',
            'cpf_cnpj' => 'required|string',
        ]);

        // Validar CPF/CNPJ
        if (($request->tipo === 'PF' && strlen($cpf_cnpj) !== 11) ||
            ($request->tipo === 'PJ' && strlen($cpf_cnpj) !== 14)) {
            return response()->json([
                'message' => 'O CPF deve ter 11 dígitos e o CNPJ deve ter 14 dígitos.'
            ], 422);
        }

        // Buscar o cliente usando a chave composta
        $cliente = Cliente::where('empresa', $empresa)->where('codigo', $codigo)->firstOrFail();

        // Atualizar o cliente
        $cliente->update([
            'razao_social' => $request->razao_social,
            'tipo' => $request->tipo,
            'cpf_cnpj' => $cpf_cnpj,
        ]);

        return response()->json(['message' => 'Cliente atualizado com sucesso!']);
    }

    // Deletar um cliente
    public function destroy($empresa, $codigo)
    {
        // Buscar o cliente usando a chave composta
        $cliente = Cliente::where('empresa', $empresa)->where('codigo', $codigo)->firstOrFail();

        // Deletar o cliente
        $cliente->delete();

        return response()->json(['message' => 'Cliente deletado com sucesso!'], 204);
    }
}

