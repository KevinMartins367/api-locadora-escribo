<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

use App\Models\Bootstrap;
use App\Controllers\VeiculosController;

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
        $group->get('', function(Request $request, Response $response){
            $dados = (new VeiculosController())->index();
            $response->getbody()->write($dados);         
            return $response;
            
        });
        $group->get('/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        $group->post('', function(Request $request, Response $response){
            $dados = (new VeiculosController())->create($request->getParsedBody());
            $response->getbody()->write($dados);         
            return $response;
            
        });
        $group->put('/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
        $group->delete('/{id}', function(Request $request, Response $response, $id){
            $dados = (new VeiculosController())->find($id);
            $response->getbody()->write($dados);         
            return $response;
            
        });
    });
};
