<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class servicioControler {

    public static function index(Router $router){
        
        validarSesion();
        isAdmin();

        $servicios = Servicio::all(); // obtengo todos los servicios, luego los paso a la vista

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);

    }

    public static function crear(Router $router){
        
        validarSesion();
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];

        $servicios = Servicio::all();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header('location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas,
            'servicios' => $servicios
        ]);
    }

    public static function actualizar(Router $router){
        
        validarSesion();
        isAdmin();

        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $servicio->sincronizar($_POST);
             $alertas = $servicio->validar();

             if(empty($alertas)){
                $servicio->guardar();
                header('location: /servicios');
             }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        
        validarSesion();
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('location: /servicios');
        }
    }
}