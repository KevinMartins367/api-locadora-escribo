<?php

namespace App\Controllers;

use App\Models\Client;


class ClientController 
{
    public $clients;

    public function __construct()
    {
        $this->clients = new Client;
    }
    
    public function index() {

        $data = $this->clients->all();

		$payload = json_encode($data);

        return $payload;
    }

    public function find($id)
    {
        $data = $this->clients->find($id);

		$payload = json_encode($data);

        return $payload;
    }

    public function create($dados)
    {
        $clients = new Client;
        $clients->name =  $dados['name'];
        $clients->cpf =  preg_replace( '/[^0-9]/', '', $dados['cpf']);
        $clients->phone =  '55' . preg_replace( '/[^0-9]/', '', $dados['phone']);
        $clients->email =  $dados['email'];
        $clients->gender =  $dados['gender'];
        $clients->save();
		$payload = json_encode($clients);

        return $payload;
    }

    public function update($dados, $id)
    {
        $infos = json_decode($dados, true);
        $client = $this->clients
        ->where('id', $id)
        ->update($infos);

		$payload = json_encode($this->clients->find($id));

        return $payload;
    }

    public function delete($id)
    {
        $clients = $this->clients->where('id', $id)->get()->each->delete();
		$payload = json_encode($clients);

        return $payload;
    }
}