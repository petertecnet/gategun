<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // Listar todos os itens
  public function index()
{
    // Obtém o usuário autenticado
    $user = Auth::user();

    // Obtém todos os itens não usados do usuário
    $items = Item::where('user_id', $user->id)
        ->where('is_used', false)
        ->get();

    // Retorna o JSON dos itens não usados
    return response()->json($items);
}

    // Mostrar um item específico
    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }
        return response()->json($item);
    }

    // Criar um novo item
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'eventid' => 'required',
            'type' => 'required',
            'description' => 'required',
            'cart_id' => 'required|integer',
            'is_used' => 'boolean',
            'user_id' => 'required|integer',
        ]);

        $item = Item::create($request->all());
        return response()->json($item, 201);
    }

    // Atualizar um item existente
    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }

        $request->validate([
            'name' => 'required',
            'quantity' => 'required|integer',
            'eventid' => 'required',
            'type' => 'required',
            'description' => 'required',
            'cart_id' => 'required|integer',
            'is_used' => 'boolean',
            'user_id' => 'required|integer',
        ]);

        $item->update($request->all());
        return response()->json($item, 200);
    }

    // Excluir um item
    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json(['message' => 'Item não encontrado'], 404);
        }
        $item->delete();
        return response()->json(['message' => 'Item excluído com sucesso'], 200);
    }
}
