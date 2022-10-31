<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Http\Requests\StoreCarroRequest;
use App\Http\Requests\UpdateCarroRequest;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;

class CarroController extends Controller
{

    private $carro;

    public function __construct(Carro $carro)
    {
        $this->carro = $carro; 
        $this->xxx = "teste";   
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);
        
        //atributos
        if($request->has("atributos")) {
            $atributos = $request->get("atributos");
            $carroRepository->selectAtributosEscolhidos($atributos);
        }
        
        //atributos modelo
        if($request->has("atributos_modelo")) {
            $atributos_modelo = $request->get("atributos_modelo");
            $carroRepository->selectAtributosRelacionadosEscolhidos("modelo:$atributos_modelo");
        }else{    
            $carroRepository->selectAtributosRelacionadosEscolhidos("modelo");
        }

        //atributos locacoes
        if($request->has("atributos_locacao")) {
            $atributos_modelo = $request->get("atributos_locacao");
            $carroRepository->selectAtributosRelacionadosEscolhidos("locacoes:$atributos_modelo");
        }else{    
            $carroRepository->selectAtributosRelacionadosEscolhidos("locacoes");
        }

        //filtros
        if($request->has("filtros")) {
            $filtros = $request->get("filtros");
            $carroRepository->aplicarFiltros($filtros);
        }
        
        return response()->json($carroRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCarroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCarroRequest $request)
    {
        $carro = $this->carro->create($request->all());
        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with("modelo", "locacoes")->find($id);

        if(empty($carro)) {
            return response()->json(["msg" => "Registo não encontrado no sistema"], 404);
        }

        return response()->json($carro, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCarroRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCarroRequest $request, $id)
    {
        $c = $this->carro->find($id);

        if(empty($c)) {
            return response()->json(["msg" => "Registo não encontrado no sistema"], 404);
        }

        $c->update($request->all());
        return response()->json($c, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = $this->carro->find($id);

        if(empty($carro)) {
            return response()->json(["msg" => "Registo não encontrado no sistema"], 404);
        }

        $carro->delete();
        
        return response()->json(["msg" => "Carro eliminado com sucesso!"], 200);
        
    }
}
