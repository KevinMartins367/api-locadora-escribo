<?php

namespace App\Controllers;

use App\Models\Veiculo;


class VeiculosController 
{
    public $veiculos;

    public function __construct()
    {
        $this->veiculos = new Veiculo;
    }

    public function index() {

        $data = $this->veiculos::all();

		$payload = json_encode($data);

        return $payload;
    }

    public function find($id)
    {
        $data = $this->veiculos::find($id);

		$payload = json_encode($data);

        return $payload;
    }

    public function create($dados)
    {
        $veiculos = new Veiculo;
        $veiculos->modelo =  $dados['modelo'];
        $veiculos->placa =  $dados['placa'];
        $veiculos->type =  $dados['type'];
        $veiculos->status =  $dados['status'];
        $veiculos->cor =  $dados['cor'];
        $veiculos->ano =  $dados['ano'];
        $veiculos->save();
		$payload = json_encode($veiculos);

        return $payload;
    }
}