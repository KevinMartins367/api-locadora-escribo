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

        $data = $this->veiculos
            ->select('veiculos.id',"veiculos.modelo","veiculos.placa","veiculos.status", "veiculos.ano","veiculos.cor","veiculos.updated_at","veiculos.created_at","type_veiculos.name as tipo")
            ->join('type_veiculos', 'veiculos.type', '=', 'type_veiculos.id')
            ->get();

		$payload = json_encode($data);

        return $payload;
    }

    public function find($id)
    {
        $data = $this->veiculos
        ->select('veiculos.id',"veiculos.modelo","veiculos.placa","veiculos.status", "veiculos.ano","veiculos.cor","veiculos.updated_at","veiculos.created_at","type_veiculos.name as tipo")
        ->join('type_veiculos', 'veiculos.type', '=', 'type_veiculos.id')
        ->where('veiculos.id', $id)
        ->get();

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

    public function update($dados, $id)
    {
        $infos = json_decode($dados, true);
        $client = $this->veiculos
        ->where('id', $id)
        ->update($infos);

		$payload = json_encode($this->veiculos->find($id));

        return $payload;
    }

    public function rent($id)
    {
        $veiculos = $this->veiculos
        ->where('id', $id)
        ->update([
            'status' => 1
        ]);

		$payload = json_encode($this->veiculos->find($id));
        return $payload;
    }

    public function refund($id)
    {
        $veiculos = $this->veiculos
        ->where('id', $id)
        ->update([
            'status' => 0
        ]);

		$payload = json_encode($this->veiculos->find($id));
        return $payload;
    }

    public function maintenance($id)
    {
        $veiculos = $this->veiculos
        ->where('id', $id)
        ->update([
            'status' => 2
        ]);

		$payload = json_encode($this->veiculos->find($id));
        return $payload;
    }

    public function delete($id)
    {
        $veiculos = $this->veiculos->where('id', $id)->get()->each->delete();
		$payload = json_encode($veiculos);

        return $payload;
    }
}