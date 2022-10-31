<?php

namespace App\Http\Controllers;

use App\Models\Locacao;
use App\Http\Requests\StoreLocacaoRequest;
use App\Http\Requests\UpdateLocacaoRequest;
use App\Repositories\LocacaoRepository;
use Illuminate\Http\Request;

class LocacaoController extends Controller
{
    
    private $locacao;

    public function __construct(Locacao $locacao)
    {
        $this->locacao = $locacao;
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locacaoRepository = new LocacaoRepository($this->locacao);

        //atributos locacao
        if($request->has("atributos")) {
            $atributos = $request->get("atributos");
            $locacaoRepository->selectAtributosEscolhidos($atributos);
        }

        //atributos cliente
        if($request->has("atributos_cliente")) {
            $atributos_cliente = $request->get("atributos_cliente");
            $locacaoRepository->selectAtributosRelacionadosEscolhidos("cliente:" . $atributos_cliente);
        }else{
            $locacaoRepository->selectAtributosRelacionadosEscolhidos("cliente");
        }

        //atributos carro
        if($request->has("atributos_carro")) {
            $atributos_carro = $request->get("atributos_carro");
            $locacaoRepository->selectAtributosRelacionadosEscolhidos("carro:" . $atributos_carro);
        }else{
            $locacaoRepository->selectAtributosRelacionadosEscolhidos("carro");
        }

        //filtros
        if($request->has("filtros")) {
            $filtros = $request->get("filtros");
            $locacaoRepository->aplicarFiltros($filtros);
        }

        return response()->json($locacaoRepository->getResultado(), 200);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocacaoRequest $request)
    {
        $locacao = $this->locacao->create($request->all());
        return response()->json($locacao, 201);
    }   

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locacao = $this->locacao->with("cliente", "carro")->find($id);
        if(empty($locacao)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        return response()->json($locacao, 200);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLocacaoRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocacaoRequest $request, $id)
    {
        $locacao = $this->locacao->find($id);
        if(empty($locacao)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        $locacao->update($request->all());
        return response()->json($locacao, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locacao = $this->locacao->find($id);
        if(empty($locacao)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        $locacao->delete();
        return response()->json(["msg" => "Locacao eliminada com suceso"], 200);
    }
}
