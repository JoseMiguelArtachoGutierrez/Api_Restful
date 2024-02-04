<?php

namespace Models;

use Lib\BaseDatos;
use PDO;
class Ponente{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $imagen;
    private string $tags;
    private string $redes;
    private BaseDatos $db;

    /**
     * @param string|null $id
     * @param string $nombre
     * @param string $apellidos
     * @param string $imagen
     * @param string $tags
     * @param string $redes
     */
    public function __construct(?string $id, string $nombre, string $apellidos, string $imagen, string $tags, string $redes)
    {
        $this->db= new BaseDatos();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->imagen = $imagen;
        $this->tags = $tags;
        $this->redes = $redes;
    }
    public static function fromArray($data): Ponente{
        return new Ponente(
            $data->id ?? null,
            $data->nombre ?? '',
            $data->apellidos ?? '',
            $data->imagen ?? '',
            $data->tags ?? '',
            $data->redes ?? '',
        );
    }
    public function create(){
        $nombre=$this->getNombre();
        $apellidos=$this->getApellidos();
        $imagen=$this->getImagen();
        $tags=$this->getTags();
        $redes=$this->getRedes();
        try{
            $ins=$this->db->preparada("INSERT INTO ponentes VALUES(null,:nombre,:apellidos,:imagen,:tags,:redes)");
            $ins->bindValue(':nombre',$nombre);
            $ins->bindValue(':apellidos',$apellidos);
            $ins->bindValue(':imagen',$imagen);
            $ins->bindValue(':tags',$tags);
            $ins->bindValue(':redes',$redes);
            $ins->execute();
            $result=true;
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function update(){
        $id=$this->getId();
        $nombre=$this->getNombre();
        $apellidos=$this->getApellidos();
        $imagen=$this->getImagen();
        $tags=$this->getTags();
        $redes=$this->getRedes();
        try{
            $ins=$this->db->preparada("update ponentes set nombre=:nombre, apellidos=:apellidos, imagen=:imagen, tags=:tags, redes=:redes where id=:id");
            $ins->bindValue(':id',$id);
            $ins->bindValue(':nombre',$nombre);
            $ins->bindValue(':apellidos',$apellidos);
            $ins->bindValue(':imagen',$imagen);
            $ins->bindValue(':tags',$tags);
            $ins->bindValue(':redes',$redes);
            $ins->execute();
            $result=true;
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function delete(){
        $sqlQuery = "DELETE FROM ponentes WHERE id = :id";
        $id=$this->getId();
        try{
            $ins=$this->db->preparada($sqlQuery);
            $ins->bindValue(':id',$id);
            $ins->execute();
            $result=true;
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }

    public function find($id){
        $resultado=false;
        try {
            $cons=$this->db->preparada("SELECT * FROM ponentes WHERE id=:id");
            $cons->bindValue(':id',$id);
            $cons->execute();
            $resultado=$cons->fetch(PDO::FETCH_OBJ);
        }catch (\PDOException $e){

        }
        return $resultado;

    }

    public function getAll(){
        $this->db->consulta("select * from ponentes");
        $ponentes=$this->db->extraer_todos();
        $this->db->cierraConexion();
        return $ponentes;
    }


    /* GETTERS Y SETTERS */
    public function getId(): ?string{
        return $this->id;
    }
    public function setId(?string $id): void{
        $this->id = $id;
    }
    public function getNombre(): string{
        return $this->nombre;
    }
    public function setNombre(string $nombre): void{
        $this->nombre = $nombre;
    }
    public function getApellidos(): string{
        return $this->apellidos;
    }
    public function setApellidos(string $apellidos): void{
        $this->apellidos = $apellidos;
    }
    public function getImagen(): string{
        return $this->imagen;
    }
    public function setImagen(string $imagen): void{
        $this->imagen = $imagen;
    }
    public function getTags(): string{
        return $this->tags;
    }
    public function setTags(string $tags): void{
        $this->tags = $tags;
    }
    public function getRedes(): string{
        return $this->redes;
    }
    public function setRedes(string $redes): void{
        $this->redes = $redes;
    }



}