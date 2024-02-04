<?php

namespace Models;

use Lib\Security;
use PDO;
use PDOException;
use Lib\BaseDatos;

class Usuario{
    private string|null $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $password;
    private string $rol;
    private bool $confirmado;
    private string $token;
    private string $token_exp;

    private BaseDatos $db;

    /**
     * @param string|null $id
     * @param string $nombre
     * @param string $apellidos
     * @param string $email
     * @param string $password
     * @param string $rol
     * @param string $confirmado
     * @param string $token
     * @param string $token_exp
     */
    public function __construct(string|null $id, string $nombre, string $apellidos, string $email, string $password, string $rol, bool $confirmado, string $token, string $token_exp){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = $password;
        $this->rol = $rol;
        $this->confirmado = $confirmado;
        $this->token = $token;
        $this->token_exp = $token_exp;
        $this->db=new BaseDatos();
    }
    public static function fromArray(array $data): Usuario {
        return new Usuario(
            $data['id']?? null,
            $data['nombre']?? '',
            $data['apellidos']?? '',
            $data['email']?? '',
            $data['password']?? '',
            $data['rol']?? 'user',
            $data['confirmado']?? false,
            $data['token']?? '',
            $data['token_exp']?? '',
        );
    }
    public function desconecta(){
        $this->db->cierraConexion();
    }
    public function create(){
        $id=$this->getId();
        $nombre=$this->getNombre();
        $apellidos=$this->getApellidos();
        $email=$this->getEmail();
        $password=$this->getPassword();
        $rol=$this->getRol();
        $confirmado=$this->isConfirmado();
        $token=$this->getToken();
        $token_exp=$this->getTokenExp();
        /*
        var_dump($id);
        echo "<br>";
        echo $nombre."<br>";
        echo $apellidos."<br>";
        echo $email."<br>";
        echo $password."<br>";
        echo $rol."<br>";
        var_dump($confirmado);
        echo "<br>";
        echo $token."<br>";
        echo $token_exp."<br>";
        die();
        */
        try {

            $hola=$this->db->preparada("insert into usuarios values(:id,:nombre,:apellidos,:email,:password,:rol,:confirmado,:token,:token_exp)");
            $hola->bindValue(":id",$id);
            $hola->bindValue(":nombre",$nombre);
            $hola->bindValue(":apellidos",$apellidos);
            $hola->bindValue(":email",$email);
            $hola->bindValue(":password",$password);
            $hola->bindValue(":rol",$rol);
            $hola->bindValue(":confirmado",$confirmado);
            $hola->bindValue(":token",$token);
            $hola->bindValue(":token_exp",$token_exp);
            $hola->execute();

            $resultado=true;
        }catch (\PDOException $e){
            var_dump($e);
            die();
            $resultado=false;
        }
        return $resultado;
    }
    public function update():bool {
        $id=$this->getId();
        $nombre = $this->getNombre();
        $apellidos = $this->getApellidos();
        $email = $this->getEmail();
        $password = $this->getPassword();
        $rol = $this->getRol();
        $confirmado = $this->isConfirmado();
        $token = $this->getToken();
        $token_exp = $this->getTokenExp();

        try {
            $upd = $this->db->preparada("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol, confirmado = :confirmado, token = :token, token_exp = :token_exp WHERE id = :id");
            $upd->bindValue(':id', $id);
            $upd->bindValue(':nombre',$nombre);
            $upd->bindValue(':apellidos',$apellidos);
            $upd->bindValue(':email',$email);
            $upd->bindValue(':password',$password);
            $upd->bindValue(':rol', $rol);
            $upd->bindValue(':confirmado', $confirmado);
            $upd->bindValue(':token', $token);
            $upd->bindValue(':token_exp', $token_exp);

            $upd->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function login(){
        $result=false;
        $email = $this->getEmail();
        $password=$this->getPassword();
        $usuario=$this->buscaMail($email);

        if ($usuario !=false){

            $verify=password_verify($password,$usuario['password']);
            if ($verify){
                return $usuario;
            }
        }

    }
    public function buscaMail($email){
        try{
            $cons=$this->db->preparada("SELECT * FROM usuarios WHERE email=:email");
            $cons->bindValue(':email',$email,PDO::PARAM_STR);
            $cons->execute();
            if ($cons && $cons->rowCount()==1){
                $result=$cons->fetch(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function buscarUsuarioPorToken($token) {
        $result=false;
        try{
            $cons=$this->db->preparada("SELECT * FROM usuarios WHERE token = :token");
            $cons->bindValue(':token',$token,PDO::PARAM_STR);
            $cons->execute();
            if ($cons && $cons->rowCount()==1){
                $result=$cons->fetch(PDO::FETCH_OBJ);
            }
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function getAll(){
        $this->db->consulta("select * from usuarios");
        $usuarios=$this->db->extraer_todos();
        $this->db->cierraConexion();
        return $usuarios;
    }


    /* GETTERS Y SETTERS */
    public function getId(): string|null{
        return $this->id;
    }
    public function setId(string $id): void{
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
    public function getEmail(): string{
        return $this->email;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }
    public function getPassword(): string{
        return $this->password;
    }
    public function setPassword(string $password): void{
        $this->password = $password;
    }
    public function getRol(): string{
        return $this->rol;
    }
    public function setRol(string $rol): void{
        $this->rol = $rol;
    }
    public function isConfirmado(): bool{
        return $this->confirmado;
    }
    public function setConfirmado(bool $confirmado): void{
        $this->confirmado = $confirmado;
    }
    public function getToken(): string{
        return $this->token;
    }
    public function setToken(string $token): void{
        $this->token = $token;
    }
    public function getTokenExp(): string{
        return $this->token_exp;
    }
    public function setTokenExp(string $token_exp): void{
        $this->token_exp = $token_exp;
    }


}