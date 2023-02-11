<?php

namespace Model;

class Usuario extends ActiveRecord {
    
    // mismos atributos DB
    protected static $tabla = 'usuarios';
    /*
        para normalizar los datos, itera sobre 
        los registros
    */
    protected static $columnasDB = ['id', 'nombre', 'apellido',
    'email', 'password','telefono', 'admin', 'confirmado', 'token']; // esta referencia se mantiene en memoria

    // public -- accedemos a estos atributos en la clase y el objeto instanciado
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        /*
            cada vez que instancio un nuevo objeto
            creo los atributos
        */
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? ''; // si no esta presente el valor, string vacio
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    // validamos creacion de usuarios
    public function validarNuevaCuenta(){
        
        if(!$this->nombre){
            // el primer campo de alertas ['error'] es el tipo de mensaje
            // el otro campo es el mensaje como tal
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        // validamos longitud del password
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password  debe contener 6 caracteres como minimo';
        }

        return self::$alertas;
    }

    // revisar si usuario ya existe
    public function existeusuario(){
       
        $query = "SELECT * FROM `" .static::$tabla ."` WHERE `email` = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        
        if($resultado->num_rows){ // si ya existe ese usuario
            self::$alertas['error'][] = 'El usuario ya esta registrado';
        }

        return $resultado;
    }

    public function validarEmail(){

        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        return self::$alertas;
    }

    public function hashPassword(){

        // accedo al atributo public de mi modelo y lo hasheo
        // y lo asigna en el mismo atributo
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){

        $this->token = uniqid(); // funcion que retorma un id unico
    }

    // metodo para validar login
    public function validarLogin(){

        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function comprobarPasswordAndVerificado($password){
        
        $resultado = password_verify($password, $this->password);
        if(!$resultado || !$this->confirmado){
            self::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        }
        else{
            return true;
        }
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][] = 'Ingresa el nuevo password';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }
        return self::$alertas;
    }
}