<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginControler {

    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                // comprobar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){
                    // verificar el password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        // autenticar al usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre ." ".$usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        
                        // redireccionamos al usuario
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header("location: /admin");
                        }
                        else{
                            header("location: /cita");
                        }
                        
                    }
                }
                else{
                    Usuario::setAlerta('error', 'Usuario no registrado');
                }

            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('/auth/login', [
            'alertas' => $alertas            
        ]);        
    }

    public static function logout(){
        session_start(); // inicio sesion
        
        $_SESSION = [];
        
        header("location: /");
    }
    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    
                    // generamos un token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    // enviar email
                    // instanciamos un objeto de la clase email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');
                }
                else{
                    // set para agregar alertas y get para obtenerlas
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide_password', [
            'alertas' => $alertas            
        ]);
       
    }
    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;

        // leo el token desde la url
        $token = s($_GET['token']);
        
        //buscamos usuario por su token en DB
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;            
        }
            
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // leer nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            
            if(empty($alertas)){
                //elimino el password actual del usuario
                $usuario->password = null;

                // asigno el nuevo password ingresado por el usuario
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null; // elimino el token

                $resultado = $usuario->guardar(); // guardo nuevo password en DB

                if($resultado){
                    header("location: /");
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router){

        $usuario = new Usuario; // instancio el objeto
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           
            $usuario->sincronizar($_POST); 
            $alertas = $usuario->validarNuevaCuenta();
            
            // revisamos que alertas este vacio
            if(empty($alertas)){
                // verificar que usuario no este registrado
                 $resultado = $usuario->existeusuario();

                 if($resultado->num_rows){
                    // si existe usuario vuelvo a crear alertas
                    // luego envio esa alerta a la vista
                    $alertas = Usuario::getAlertas(); 
                 }else{
                    // no esta registrado el usuario
                    // hashear password
                    $usuario->hashPassword();

                    // generar un token unico
                    $usuario->crearToken();

                    // instancio el objeto email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    
                    //enviar mail de confirmacion
                    $email->enviarConfirmacion();

                    // crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header("location: /mensaje");
                    }
                    // debuguear($usuario);
                 }
            }
        }
        $router->render('auth/crear', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);        
    }

    public static function mensaje(Router $router){

        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){

        $alertas = [];
        // leemos el token enviado en la url
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // mostrar mensaje de error
            Usuario::setAlerta('error', 'token no válido');
        }
        else{
            // modificar en DB a usuario confirmado
            $usuario->confirmado = 1; // accedo al atributo de mi objeto y modifico el valor a 1
            
            // luego elimino el token
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');
        }

        //obtener alertas
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}