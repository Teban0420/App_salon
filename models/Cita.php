<?php

namespace Model;

class Cita extends ActiveRecord {
    // Base de datos

    protected static $tabla = 'citas';
    // creamos el objeto con los atributos de la DB y lo sanitizamos
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuario_id'];

    public $id;
    public $fecha;
    public $hora;
    public $usuario_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuario_id = $args['usuario_id'] ?? '';
    }

}