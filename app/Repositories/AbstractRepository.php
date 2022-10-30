<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{

    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAtributosEscolhidos($atributosEscolhidos)
    {
        $this->model = $this->model->selectRaw($atributosEscolhidos);
    }

    public function selectAtributosRelacionadosEscolhidos($atributosEscolhidos)
    {
        $this->model = $this->model->with($atributosEscolhidos);
    }

    public function aplicarFiltros($filtros)
    {
        $filtros = explode(";", $filtros);
        foreach ($filtros as $filtro) {
            [$campo, $operador, $valor] = explode(":", $filtro);
            $this->model = $this->model->where($campo, $operador, $valor);
        }
    }

    public function getResultado() {
        return $this->model->get();
    }
}
