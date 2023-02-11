<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

/*
    ESTE CONTROLADOR NO REQUIERE EL ROUTER YA QUE RETORNA JSON Y LA VISTA ESTA
    SEPARADA DEL BACK-END
*/
class APIControler {

    public static function index(){

        $servicio = Servicio::all(); // modelo de servicios
        echo json_encode($servicio);
    }

    public static function guardar(){

        // ALMACENA LA CITA Y DEVUELVE EL ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar(); 
        $id = $resultado['id'];
        
        // Separo los ids de los servicios y los almacena con el id de la cita
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio){
            // itera cada uno de los servicios (seleccionados en la cita)
            $args = [
                'cita_id' => $id,
                'servicio_id' => $idServicio
            ];
            // creamos nueva instancia de este objeto
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar(); // los guarda con referencia a la cita creada
        }

        // retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar(){
       
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           
            $id = $_POST['id'];            
            $cita = Cita::find($id); // encontre la cita
            $cita->eliminar();

            header('location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}