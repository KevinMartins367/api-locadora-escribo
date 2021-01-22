<?php

namespace App\Controllers;

use App\Models\Rent;
use Carbon\Carbon;


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
        $data = $this->rents
        ->select('rents.id',"clients.id as client_id","clients.name","clients.phone","clients.email", "clients.gender","clients.cpf","veiculos.id as veiculo_id","veiculos.modelo","type_veiculos.name as tipo","veiculos.placa","veiculos.ano","veiculos.cor","veiculos.status","veiculos.placa","rents.note","rents.payment","rents.time_start","rents.time_end")
        ->join('clients', 'rents.client_id', '=', 'clients.id')
        ->join('veiculos', 'rents.veiculo_id', '=', 'veiculos.id')
        ->join('type_veiculos', 'veiculos.type', '=', 'type_veiculos.id')
        ->where('rents.id', $id)
        ->get();

		$payload = json_encode($data);

        return $payload;
    }

    public function create($dados)
    {
        $rents = new Rent;
        $rents->veiculo_id =  $dados['veiculo_id'];
        $rents->client_id =  $dados['client_id'];
        $rents->time_start =  (isset($dados['time_start'])) ? Carbon::createFromFormat('d/m/Y H:i:s', $dados['time_start']) : Carbon::now();
        $rents->note = $dados['note'];
        $rents->payment = $dados['payment'];
        $rents->save();
		$payload = json_encode($rents);

        return $payload;
    }

    public function update($dados, $id)
    {
        $infos = json_decode($dados, true);
        $client = $this->rents
        ->where('id', $id)
        ->update([
            "veiculo_id"    => $infos['veiculo_id'],
            "client_id"     => $infos['client_id'],
            "time_start"    => Carbon::createFromFormat('d/m/Y H:i:s', $infos['time_start']),
            "time_end"      => (isset($infos['time_end'])) ? Carbon::createFromFormat('d/m/Y H:i:s', $infos['time_end']) : null,
            "note"          => $infos['note'],
            "payment"       => $infos['payment']
        ]);

		$payload = json_encode($this->rents->find($id));

        return $payload;
    }

    public function updateNote($dados, $id)
    {
        $infos = json_decode($dados, true);
        $client = $this->rents
        ->where('id', $id)
        ->update([
            'note' => $infos['note']
        ]);

		$payload = json_encode($this->rents->find($id));

        return $payload;
    }

    public function updateTime_end($id)
    {
        $client = $this->rents
        ->where('id', $id)
        ->update([
            'time_end' => Carbon::createFromFormat('d/m/Y H:i:s', Carbon::now()->format('d/m/Y H:i:s'))
        ]);

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