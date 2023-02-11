<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminControler {

    public static function index(Router $router){

        validarSesion();
        isAdmin();

        $fecha =  $_GET['fecha'] ?? date('Y-m-d');
        $fechaBuscada = explode('-', $fecha); // separo la fecha


        if(!checkdate($fechaBuscada[1], $fechaBuscada[2], $fechaBuscada[0])){
            header("location: /404");
        }

        // consultar DB
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente,";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM `citas` ";
        $consulta .= "LEFT OUTER JOIN `usuarios` ON citas.usuario_id = usuarios.id LEFT OUTER JOIN `citas_servicios` ON ";
        $consulta .= "citas_servicios.cita_id = citas.id LEFT OUTER JOIN `servicios` ON servicios.id = citas_servicios.servicio_id";
        $consulta .= " WHERE `fecha` = '${fecha}' ";
        // debuguear($consulta);
        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}