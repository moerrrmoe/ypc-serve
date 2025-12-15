<?php
require 'vendor/autoload.php';
require_once 'controller/comic-controller.php';
require_once 'helper/jsonEncode.php';
require_once __DIR__.'/controller/member-controller.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->setBasePath("/ypc server");

$app->get('/', function ($request, $response) {
    $response->getBody()->write('Hello Slim!');
    return $response;
});

$app->get('/comics',function(Request $request, Response $response, $args){
    $controller = new comicController();
    $comics = $controller->getAllComics();
    $rc = $controller->getRecommend();
    if($comics){
        jsonEncode(["status"=>"success","data"=>$comics,"recommend"=>$rc],200);
    }
    else{
        jsonEncode(["message"=>"No comics found"],404);
    }
});

$app->get('/comics/{id}',function(Request $request, Response $response, $args){
    $id = $args['id'];
    $controller = new comicController();
    $comic = $controller->getComicById($id);
    if($comic){
        jsonEncode(["status"=>"success","data"=>$comic],200);
    }
    else{
        jsonEncode(["message"=>"not found"],404);
    }
});

$app->get('/members/count',function(Request $request,Response $response,$args){
    $controller = new memberController();
    $count = $controller->memberCount();
    if($count){
        jsonEncode(["status"=>"success","count"=>$count]);
    }else{
        jsonEncode(["status"=>"error","count"=>"An unknown error occured",404]);
    }
});

$app->get('/members/{id}',function(Request $request, Response $response, $args){
    $id = $args['id'];
    
    $controller = new memberController();
    $member = $controller->getMemberById($id);
    
    if($member){
        $isepx = new DateTime($member->exp) <= new DateTime();
        jsonEncode(["status"=>"success","data"=>$member,"isexp"=>$isepx],200);
    }
    else{
        jsonEncode(["status"=>"error","message"=>"not found"],404);
    }
});

$app->get('/ypcbk',function(Request $request, Response $response, $args){
   include_once __DIR__ . '/views/index.php';
   return $response->withStatus(200);
});

$app->get('/ypcbk/{id}',function(Request $request, Response $response, $args){
    $id = (int) $args['id'];
    $controller = new comicController();
    $comic = $controller->getComicById($id);
    include_once __DIR__ . '/views/comic.php';
    return $response->withStatus(200);
});


$app->run();
?>