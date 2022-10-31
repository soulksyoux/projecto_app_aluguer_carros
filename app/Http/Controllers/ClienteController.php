<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    private $cliente;

    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;   
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        //atributos Cliente
        if($request->has("atributos")) {
            $atributos = $request->get("atributos");
            $clienteRepository->selectAtributosEscolhidos($atributos);    
        }

        //atributos locacoes
        if($request->has("atributos_locacoes")) {
            $atributos_locacoes = $request->get("atributos_locacoes");
            $clienteRepository->selectAtributosRelacionadosEscolhidos("locacoes:" . $atributos_locacoes);    
        }else{
            $clienteRepository->selectAtributosRelacionadosEscolhidos("locacoes");    
        }

        //filtros
        if($request->has("filtros")) {
            $filtros = $request->get("filtros");
            $clienteRepository->aplicarFiltros($filtros);
        }

        return response()->json($clienteRepository->getResultado(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClienteRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = $this->cliente->create($request->all());

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->with("locacoes")->find($id);

        if(empty($cliente)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        return response()->json($cliente, 200);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClienteRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClienteRequest $request, $id)
    {
        $cliente = $this->cliente->find($id);

        if(empty($cliente)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        $cliente->update($request->all());

        return response()->json($cliente, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if(empty($cliente)) {
            return response()->json(["msg" => "Registo não encontrado"], 404);
        }

        $cliente->delete();

        return response()->json(["msg" => "Cliente eliminado com sucesso!"], 200);
    }
}
