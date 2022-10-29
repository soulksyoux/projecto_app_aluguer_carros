<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function index(Request $request)
    {
        $marcas = $this->marca;

        //atributos
        if($request->has("atributos")) {
            $atributos = $request->get("atributos");
            $marcas = $this->marca->selectRaw($atributos);
        }

        //atributos do modelo
        if($request->has("atributos_modelo")) {
            $atributos_modelo = $request->get("atributos_modelo");
            $marcas = $marcas->with("modelos:$atributos_modelo");
        }else{
            $marcas = $marcas->with("modelos");
        }

        //filtros
        if($request->has("filtros")) {
            $filtros = explode(";", $request->get("filtros"));
            foreach($filtros as $filtro) {
                [$campo, $operador, $valor] = explode(":", $filtro);
                $marcas = $marcas->where($campo, $operador, $valor);
            }
        }

  
        return response()->json($marcas->get(),200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
    public function store(Request $request)
    {
        //$marca = Marca::create($request->all());

        $request->validate($this->marca->regras(), $this->marca->mensagens());

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 201);        
    }
    */


    public function store(StoreMarcaRequest $request)
    {
        //$marca = Marca::create($request->all());

        //$request->validate($this->marca->regras(), $this->marca->mensagens());
        //$request->validate();

        $imagem = $request->imagem;
        $imagem_urn = $imagem->store("imagens", "public");
        
        $marca = $this->marca->create([
            "nome" => $request->nome,
            "imagem" => $imagem_urn,
        ]);

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
        $marca = $this->marca->with("modelos")->find($id);
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
    /*
    public function update(Request $request, $id)
    {

        $marca = $this->marca->find($id);
        if(empty($marca)) {
            return response()->json(["msg" => "Registo não encontrado no sistema!"], 404);
        }

        $regras_dinamicas = [];

        foreach($marca->regras() as $input => $regras) {
            if(array_key_exists($input, $request->all())) {
                $regras_dinamicas[$input] = $regras;
            }
        }


        $request->validate($regras_dinamicas, $marca->mensagens());

        $marca->update($request->all());
        return response()->json($marca,200);

    }
    */


    public function update(UpdateMarcaRequest $request, $id)
    {
        
        $marca = $this->marca->find($id);
        if(empty($marca)) {
            return response()->json(["msg" => "Registo não encontrado no sistema!"], 404);
        }


        /*
        $regras_dinamicas = [];

        foreach($marca->regras() as $input => $regras) {
            if(array_key_exists($input, $request->all())) {
                $regras_dinamicas[$input] = $regras;
            }
        }
        */


        //$request->validate($regras_dinamicas, $marca->mensagens());


        $imagem_urn = $marca->imagem;

        if($request->file('imagem')) {
            Storage::disk("public")->delete($marca->imagem);
            $imagem = $request->imagem;
            $imagem_urn = $imagem->store("imagens", "public");
        }

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();
        
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

        Storage::disk("public")->delete($marca->imagem);

        $marca->delete();
        return response()->json(["msg" => "Marca removida com sucesso"], 200);
    }
}
