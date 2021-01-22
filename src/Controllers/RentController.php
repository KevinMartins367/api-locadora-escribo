<?php

namespace App\Controllers;

use App\Models\Rent;


class RentController 
{
    public $rents;

    public function __construct()
    {
        $this->rents = new Rent;
    }
    
    public function index() {

        $data = $this->rents
        ->select('rents.id',"clients.id as client_id","clients.name","clients.phone","clients.email", "clients.gender","clients.cpf","veiculos.id as veiculo_id","veiculos.modelo","type_veiculos.name as tipo","veiculos.placa","veiculos.ano","veiculos.cor","veiculos.status","veiculos.placa","rents.note","rents.payment","rents.time_start","rents.time_end")
        ->join('clients', 'rents.client_id', '=', 'clients.id')
        ->join('veiculos', 'rents.veiculo_id', '=', 'veiculos.id')
        ->join('type_veiculos', 'veiculos.type', '=', 'type_veiculos.id')
        ->get();

		$payload = json_encode($data);

        return $payload;
    }

    public function find($id)
    {
        $data = $this->rents->find($id);

		$payload = json_encode($data);

        return $payload;
    }

    public function create($dados)
    {
        $rents = new Rent;
        $rents->name =  $dados['name'];
        $rents->cpf =  $dados['cpf'];
        $rents->phone =  $dados['phone'];
        $rents->email =  $dados['email'];
        $rents->gender =  $dados['gender'];
        $rents->save();
		$payload = json_encode($rents);

        return $payload;
    }

    public function update($dados, $id)
    {
        $infos = json_decode($dados, true);
        $client = $this->rents
        ->where('id', $id)
        ->update($infos);

		$payload = json_encode($this->rents->find($id));

        return $payload;
    }

    public function delete($id)
    {
        $rents = $this->rents->where('id', $id)->get()->each->delete();
		$payload = json_encode($rents);

        return $payload;
    }
}