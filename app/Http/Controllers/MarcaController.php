<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    private $marca; 

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas,200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$marca = Marca::create($request->all());

        $request->validate($this->marca->regras(), $this->marca->mensagens());

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);        
    }

    //o cliente precisa de dizer previamente que sabe lidar com retorno de application\json

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if(empty($marca)) {
            return response()->json(["msg" => "Registo não encontrado no sistema"], 404);
        }

        return response()->json($marca,200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if(empty($marca)) {
            return response()->json(["msg" => "Registo não encontrado no sistema!"], 404);
        }

        $marca->update($request->all());
        return response()->json($marca,200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if(empty($marca)) {
            return response()->json(["msg" => "Registo não encontrado no sistema!"], 404);
        }
        $marca->delete();
        return response()->json(["msg" => "Marca removida com sucesso"], 200);
    }
}
