<?php

namespace Controllers;

use Lib\Pages;
use Lib\ResponseHttp;
use Lib\Security;
use Models\Usuario;
use utils\utils;

class UsuarioController{
    private Pages $pages;

    public function __construct(){
        $this->pages = new Pages();
    }

    public function crearUsuario(){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (!empty($_POST['data']['nombre']) && !empty($_POST['data']['apellidos']) && !empty($_POST['data']['email']) && !empty($_POST['data']['password'])) {
                if ($_POST['data']){
                    $registro = $_POST['data'];
                    $registro['password'] = password_hash($registro['password'], PASSWORD_BCRYPT, ['cost' => 4]);
                    $token=Security::crearToken(Security::claveSecreta(),["email"=>$registro['email']]);
                    $registro['token_exp']=date("Y-m-d H:i:s",time()+3600);
                    $registro['token']=$token;
                    $usuario=Usuario::fromArray($registro);
                    if ($usuario->create()){
                        EmailController::enviarCorreo($usuario->getEmail(),$usuario->getToken());
                    }else{
                        $_SESSION["register"]="Error al crearlo";
                    }
                }else{
                    $_SESSION["register"]="Error";
                }
            }else{
                $_SESSION["register"]="Error: datos vacios";
            }
        }
        header("Location:".BASE_URL."Usuario/registro/");
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['data'])) {

                $inicioSesion = $_POST['data'];
                $usuario = Usuario::fromArray($inicioSesion);
                $identity = $usuario->login();

                if ($identity) {
                    $usuario=Usuario::fromArray($identity);
                    if ($usuario->isConfirmado()) {
                        $_SESSION['identity'] = $identity;
                        header("Location:".BASE_URL);
                    }else {
                        $tokenNuevo = Security::crearToken(Security::clavesecreta(), ["email"=>$inicioSesion['email']]);
                        $arrayUsuarioEmail=$usuario->buscaMail($inicioSesion['email']);
                        $arrayUsuarioEmail['token']=$tokenNuevo;
                        $arrayUsuarioEmail['token_exp']=date("Y-m-d H:i:s", time()+3600);
                        $usuario=Usuario::fromArray($arrayUsuarioEmail);
                        if ($usuario->update()){
                            EmailController::enviarCorreo($inicioSesion['email'], $tokenNuevo);
                            $_SESSION['login'] = 'Su correo no esta confirmado, se le a enviado una confirmacion a su correo';
                        }else{
                            $_SESSION['login']="No se a podido modificar los datos en la base de datos";
                        }
                    }
                } else {
                    $_SESSION['login'] = 'Log In failed';
                }
            }
        }
        header("Location:".BASE_URL."Usuario/identificarse");
    }
    public function validarToken(){
        $tokenValidado =Security::validateToken();
        if($tokenValidado){
            return true;
        }
        else{
            return false;
        }
    }
    public function generarNuevoToken(){
        if(isset($_SESSION['identity'])){
            $email=$_SESSION['identity']['email'];
            $tokenSesion = Security::crearToken(Security::clavesecreta(), ["email"=>$email]);
            $_SESSION['identity']['token']=$tokenSesion;
            $_SESSION['identity']['token_exp']=date("Y-m-d H:i:s",time()+3600);
            $usuario=Usuario::fromArray($_SESSION['identity']);
            if($usuario->update()){
                $_SESSION['generarToken']="Su toekn a sido generado perfectamente: ".$usuario->getToken();
                header("Location:".BASE_URL."Apiponente/documentacion/");
            }
        }
    }
    public function confirmarGmail(){
        try {
            $data= Security::validateToken();

            if($data){
                $mensaje=$data['data'];
                $usuario=Usuario::fromArray([]);
                $usuarioEmail=$usuario->buscaMail($mensaje->data->email);

                if($usuarioEmail){

                    if ($usuarioEmail['token']==$data['token']){
                        $usuarioEmail['confirmado']=true;
                        $usuarioEmail['token']='';
                        $usuarioEmail['token_exp']=date("Y-m-d H:i:s", time()-1);
                        $usuario=Usuario::fromArray($usuarioEmail);
                        if ($usuario->update()){
                            echo ResponseHttp::statusMEssage(202,"Su usuario a sido confirmado","");
                        }else{
                            echo ResponseHttp::statusMEssage(202,"Su usuario no se a podido actualizar","");
                        }
                    }else{

                        echo ResponseHttp::statusMEssage(404,"Ese token no existe",$data['token']);
                    }
                }else{
                    echo ResponseHttp::statusMEssage(404,"Ese correo no existe en nuestra Base de datos",'');
                }
            }
        } catch (Exception $e) {
            echo "Error al confirmar el registro: " . $e->getMessage();
        }
    }


    public function identificarse(){
        $this->pages->render('usuario/login');
    }
    public function registro(){
        $this->pages->render('usuario/registro');
    }
    public function logout(){
        utils::deleteSession('identity');
        header("Location:".BASE_URL);
    }

}