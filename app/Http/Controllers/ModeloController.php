<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModeloRequest;
use App\Http\Requests\UpdateModeloRequest;
use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    private $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modelos = $this->modelo;

        if($request->has("atributos")) {
            $atributos = $request->get("atributos");
            $modelos = $modelos->selectRaw($atributos);
        }

        if($request->has("atributos_marca")) {
            $atributos_marca = $request->get("atributos_marca");
            $modelos = $modelos->with("marca:$atributos_marca");
        }else{
            $modelos = $modelos->with("marca");
        }

        if($request->has("filtros")) {
            $filtros = explode(";", $request->get("filtros"));

            foreach($filtros as $filtro) {
                [$campo, $operador, $pesquisa] = explode(":", $filtro);
                $modelos = $modelos->where($campo, $operador, $pesquisa);
            }
        }

        return response()->json($modelos->get(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModeloRequest $request)
    {
        
        //gravar imagem disco
        $imagem = $request->imagem;
        $imagem_urn = $imagem->store("imagens/modelos", "public");

        $modelo = $this->modelo->create([
            "marca_id" => $request->marca_id,
            "nome" => $request->nome,
            "imagem" => $imagem_urn,
            "numero_portas" => $request->numero_portas,
            "lugares" => $request->lugares,
            "airbag" => $request->airbag,
            "abs" => $request->abs,
        ]);

        return response()->json(["msg" => "Modelo criado com sucesso", "modelo" => $modelo], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $modelo = $this->modelo->with("marca")->find($id);

        if(empty($modelo)) {
            return response()->json(["msg" => "Modelo nao encontrado"], 404);
        }

        return $modelo;        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModeloRequest $request, $id)
    {
        $modelo = $this->modelo->find($id);

        if(empty($modelo)) {
            return response()->json(["msg" => "Modelo nao encontrado"], 404);
        }

        $imagem_urn = $modelo->imagem;
        if($request->file("imagem")) {
            Storage::disk("public")->delete($modelo->imagem);
            $imagem = $request->imagem;
            $imagem_urn = $imagem->store("imagens/modelos", "public");
        }

 
        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;
        $modelo->save();

        return response()->json($modelo,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if(empty($modelo)) {
            return response()->json(["msg" => "Modelo nao encontrado"], 404);
        }

        Storage::disk("public")->delete($modelo->imagem);

        $modelo->delete();

        return response()->json(["msg" => "Registo eliminado com sucesso!"], 200);
    }
}
