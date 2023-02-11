<?php

namespace Controllers;
use MVC\Router;

class CitaControler {
   
    public static function index(Router $router){       

       // paso los datos de la sesion a la vista
       validarSesion();

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}