<?php

namespace Controllers;

use Lib\Pages;
use Lib\ResponseHttp;
use Lib\Security;
use Models\Ponente;
use Models\Usuario;

class ApiponenteController{
    private Pages $pages;

    /**
     * @param Pages $pages
     */
    public function __construct(){
        $this->pages = new Pages();
    }
    public function create(){
        ResponseHttp::setHeader();
        if ($this->validarToken()){
            $data= json_decode(file_get_contents("php://input"));
            if (!empty($data->nombre) && !empty($data->apellidos) &&
                !empty($data->imagen) && !empty($data->tags) && !empty($data->redes)){
                $ponente=Ponente::fromArray($data);
                if ($ponente->create()){
                    http_response_code(201);
                    echo json_encode(array("massage"=>"Ponente creado con exito"));
                }else{
                    http_response_code(503);
                    echo json_encode(array("message"=>"No se ha podido añadir un nuevo Ponente"));
                }

            }else{
                http_response_code(400);
                echo json_encode(array("message"=>"No se ha podido crear. Datos incompletos"));
            }
        }
    }
    public function update($id){
        ResponseHttp::setHeader();
        if ($this->validarToken()){
            $data = (object) json_decode(file_get_contents('php://input'),TRUE);
            if (!empty($data->nombre) && !empty($data->apellidos) && !empty($data->imagen)
                && !empty($data->tags) && !empty($data->redes)){
                $ponente=Ponente::fromArray($data);
                $result = $ponente->find($id);

                if (!$result){
                    http_response_code(404);
                    echo json_encode(array("message"=>"Ponente no encontrado"));
                }else{
                    $ponente->setId($id);
                    if ($ponente->update()){
                        http_response_code(200);
                        echo json_encode(array(["message"=>"Ponente ha sido modificado con exito"]));
                    }else{
                        http_response_code(503);
                        echo json_encode(array("message"=>"No se ha podido modificar los datos del Ponente."));
                    }

                }
            }else{
                http_response_code(400);
                echo json_encode(array("message"=>"No se ha podido crear. Datos incompletos","body"=>$data));
            }
        }

    }

    public  function delete($id){
        ResponseHttp::setHeader();
        if ($this->validarToken()){
            $data = (array) json_decode(file_get_contents('php://input'),TRUE);

            $ponente=Ponente::fromArray($data);
            $result = $ponente->find($id);
            $ponente=Ponente::fromArray($result);

            if (!$result){
                http_response_code(404);
                echo json_encode(array("message"=>"Ponente no encontrado"));
            }else{
                if ($ponente->delete()){
                    http_response_code(200);
                    echo json_encode(array(["message"=>"Ponente ha sido eliminado con exito"]));
                }else{
                    http_response_code(503);
                    echo json_encode(array("message"=>"No se ha podido eliminar los datos del Ponente."));
                }

            }

        }
    }
    public function validarToken(){
        $data =Security::validateToken();
        $resultado=false;
        if($data){
            $mensaje=$data['data'];
            $usuario=Usuario::fromArray([]);
            $usuarioEmail=$usuario->buscaMail($mensaje->data->email);
            if($usuarioEmail){
                if ($usuarioEmail['token']==$data['token']){
                    $resultado=true;
                }else{
                    echo ResponseHttp::statusMEssage(404,"Ese token no existe",$data['token']);
                }
            }else{
                echo ResponseHttp::statusMEssage(404,"Ese correo no existe en nuestra Base de datos",'');
            }
        }
        return $resultado ;
    }
    public function  todosLosPonentes():void{
        ResponseHttp::setHeader();
        if($this->validarToken()){
            $ponente =Ponente::fromArray([]);
            $ponente = $ponente->getAll();
            if ($ponente){
                $ponenteArr = array();
                $ponenteArr["ponente"] = array();
                foreach ($ponente as $fila) {
                    array_push($ponenteArr["ponente"], $fila);
                }
                http_response_code(202);
                echo json_encode($ponenteArr);
            }else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "No hay Ponentes"));
            }
        }
    }
    public function unPonente($id): void{

        ResponseHttp::setHeader();

        if($this->validarToken()){
            $ponente = Ponente::fromArray([]);
            $result = $ponente->find($id);
            if ($result) {
                http_response_code(200);
                echo json_encode(["message" => "Ponente encontrado.", "ponente" => $result]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Ponente no encontrado."]);
            }
        }
    }
    public function documentacion(){
        $this->pages->render('apiponente/documentacion');
    }


}