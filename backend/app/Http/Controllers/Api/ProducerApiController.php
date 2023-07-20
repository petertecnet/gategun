<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Producer;

class ProducerApiController extends Controller
{
    /**
     * Retorna uma lista de todos os Produceros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Producers = Producer::all();
        return response()->json($Producers);
    }

    /**
     * Exibe os detalhes de um Producero específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Producer = Producer::findOrFail($id);
        return response()->json($Producer);
    }

    /**
     * Cria um novo Producer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Producer = Producer::create($request->all());
        return response()->json($Producer, 201);
    }
}
