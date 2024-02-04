<?php

namespace Lib;

use Controllers\EmailController;
use Controllers\UsuarioController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Models\Usuario;
class Security{
    final public static function  claveSecreta(): string{
        return $_ENV['SECRET_KEY'];
    }
    final public static function encriptarPassw(string $passw): string{
        $passw=password_hash($passw,PASSWORD_DEFAULT);
        return $passw;
    }
    final  public static function validarPassw(string $passw, string $passwHash): bool{
        return password_verify($passw,$passwHash);
    }
    final public static function crearToken(string $key,array $data):string{
        $time=strtotime("now");
        $token = array(
            "iat"=>$time,
            "exp"=>$time +3600,
            "data"=>$data
        );
        return  JWT::encode($token,$key,"HS256");
    }
    final public static function getToken(){
        $headers = apache_request_headers(); // recoger las cabeceras en el servidor Apache
        if(!isset($headers['Authorization'])) { // comprobamos que existe la cabecera authoritation
            return $response['message'] = json_decode( ResponseHttp::statusMessage( 403, 'Acceso denegado', "No hay token"));
        }
        try{
            $authorizationArr = explode(' ', $headers['Authorization']);
            $token= $authorizationArr[1];
            return ["data"=>JWT::decode($token, new Key (Security::clavesecreta(), 'HS256')),"token"=>$token];
        }catch (\Exception $exception){
            return $response['message']= json_decode(ResponseHttp::statusMessage (401,  'Token expirado o invalido', $token));
        }
    }
    final public static function validateToken()
    {
        $data=self::getToken();
        $info = $data['data'];
        if (isset($info->status) && $info->status == "Unauthorized") {
            $usuario = Usuario::fromArray([]);
            $usuarioExiste = $usuario->buscarUsuarioPorToken($info->token);
            if ($usuarioExiste) {
                $nuevoToken = Security::crearToken(Security::clavesecreta(), ["email" => $usuarioExiste[0]["email"]]);
                $usuarioExiste[0]["token"] = $nuevoToken;
                $usuario = Usuario::fromArray($usuarioExiste[0]);
                if ($usuario->update()) {
                    EmailController::enviarCorreo($usuario->getEmail(), $usuario->getToken());
                }
            }
            json_decode(ResponseHttp::statusMEssage(401,"Su token ha expirado o es invalido, se le ha enviado uno nuevo a su correo",""));
            return false;
        } else if (isset($info->status) && $info->status == "Forbidden") {
            json_decode(ResponseHttp::statusMEssage(403,"Error en la autorización",""));
            return false;
        } else {
            return $data;
        }
    }
}