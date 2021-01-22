<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

use App\Models\Bootstrap;
use App\Controllers\VeiculosController;
use App\Controllers\ClientController;
use App\Controllers\RentController;

return function (App $app) {

    Bootstrap::load($app);

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        
        $response->getBody()->write('teste');
        return $response;
    });

    $app->group('/vehicles', function (Group $group) {
        // get all veiculos
        $group->get('', function(Request $request, Response $response){
            $dados = (new VeiculosController())->index();
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // get unique veiculos
        $group->get('/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // create veiculos
        $group->post('', function(Request $request, Response $response){
            $dados = (new VeiculosController())->create($request->getParsedBody());
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // update veiculos
        $group->put('/{id}', function(Request $request, Response $response, $id){
            $data = $request->getBody()->getContents();
            $dados = (new VeiculosController())->update($data, $id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // alugar veiculos
        $group->put('/rent/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->rent($id);
            $response->getbody()->write($dados);         
            return $response;  
        });
        // devolver veiculos
        $group->put('/refund/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->refund($id);
            $response->getbody()->write($dados);         
            return $response;  
        });
        // maintenance veiculos
        $group->put('/maintenance/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->maintenance($id);
            $response->getbody()->write($dados);         
            return $response;  
        });
        // delete veiculos
        $group->delete('/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->delete($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
    });
    
    $app->group('/clients', function (Group $group) {
        // get all clients
        $group->get('', function(Request $request, Response $response){
            $dados = (new ClientController())->index();
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // get unique clients
        $group->get('/{id}', function(Request $request, Response $response, $id){
            $dados = (new ClientController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // create clients
        $group->post('', function(Request $request, Response $response){
            $dados = (new ClientController())->create($request->getParsedBody());
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // update clients
        $group->put('/{id}', function(Request $request, Response $response, $id){
            $data = $request->getBody()->getContents();
            $dados = (new ClientController())->update($data, $id);
            $response->withHeader('Content-Type', 'application/json')->getbody()->write($dados);         
            return $response;
            
        });
        // delete clients
        $group->delete('/{id}', function(Request $request, Response $response, $id){
            $dados = (new ClientController())->delete($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
    });
    
    $app->group('/rents', function (Group $group) {
        // get all clients
        $group->get('', function(Request $request, Response $response){
            $dados = (new RentController())->index();
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // get unique clients
        $group->get('/{id}', function(Request $request, Response $response, $id){
            $dados = (new RentController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // create clients
        $group->post('', function(Request $request, Response $response){
            $dados = (new RentController())->create($request->getParsedBody());
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // update clients
        $group->put('/{id}', function(Request $request, Response $response, $id){
            $data = $request->getBody()->getContents();
            $dados = (new RentController())->update($data, $id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        // delete clients
        $group->delete('/{id}', function(Request $request, Response $response, $id){
            $dados = (new RentController())->delete($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
    });
};
