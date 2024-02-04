<?php

namespace Routes;

use Controllers\ApiponenteController;
use Controllers\AuthController;
use Controllers\DashBoardController;
use Controllers\ErrorController;
use Controllers\UsuarioController;
use Lib\Router;

class Routes
{
    public static function index(){
        // INICIO
        Router::add('GET','/',function (){
            return (new DashBoardController())->index();
        });

        // Ponente
        Router::add('POST','/Apiponente/create/',function (){
            return (new ApiponenteController())->create();
        });
        Router::add('PUT','/Apiponente/update/:id',function ($id){
            return (new ApiponenteController())->update($id);
        });
        Router::add('DELETE','/Apiponente/delete/:id',function ($id){
            return (new ApiponenteController())->delete($id);
        });
        Router::add('GET','/Apiponente/todosLosPonentes/',function (){
            return (new ApiponenteController())->todosLosPonentes();
        });
        Router::add('GET','/Apiponente/unPonente/:id',function ($id){
            return (new ApiponenteController())->unPonente($id);
        });
        Router::add('GET','/Apiponente/documentacion/',function (){
            return (new ApiponenteController())->documentacion();
        });
        // Usuario
        Router::add('POST','/Usuario/crearUusario/',function (){
            return (new UsuarioController())->crearUsuario();
        });
        Router::add('POST','/Usuario/login/',function (){
            return (new UsuarioController())->login();
        });
        Router::add('GET','/Usuario/crearUsuario/',function (){
            return (new UsuarioController())->crearUsuario();
        });
        Router::add('POST','/Usuario/confirmarGmail',function (){
            return (new UsuarioController())->confirmarGmail();
        });
        Router::add('GET','/Usuario/generarNuevoToken/',function (){
            return (new UsuarioController())->generarNuevoToken();
        });
        Router::add('GET','/Usuario/identificarse/',function (){
            return (new UsuarioController())->identificarse();
        });
        Router::add('GET','/Usuario/logout/',function (){
            return (new UsuarioController())->logout();
        });
        Router::add('GET','/Usuario/registro/',function (){
            return (new UsuarioController())->registro();
        });
        // ERROR
        Router::add('GET','/Error/error/', function (){
            return (new ErrorController())->error404();
        });


        Router::dispatch();
    }
}