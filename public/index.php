<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminControler;
use Controllers\APIControler;
use Controllers\CitaControler;
use Controllers\LoginControler;
use Controllers\servicioControler;

use MVC\Router;
$router = new Router();

// Rutas para login
$router->get('/', [LoginControler::class, 'login']);
$router->post('/', [LoginControler::class, 'login']);
$router->get('/logout', [LoginControler::class, 'logout']);

// Rutas -- olvide mi contraseña
$router->get('/olvide', [LoginControler::class, 'olvide']);
$router->post('/olvide', [LoginControler::class, 'olvide']);
$router->get('/recuperar', [LoginControler::class, 'recuperar']);
$router->post('/recuperar', [LoginControler::class, 'recuperar']);

// Rutas para crear cuentas
$router->get('/crear', [LoginControler::class, 'crear']);
$router->post('/crear', [LoginControler::class, 'crear']);

// Rutas para confirmar cuentas
$router->get('/confirmar-cuenta', [LoginControler::class, 'confirmar']);
$router->get('/mensaje', [LoginControler::class, 'mensaje']);

// API DE CITAS
$router->get('/api/servicios', [APIControler::class, 'index']);
$router->post('/api/servicios', [APIControler::class, 'index']);
$router->post('/api/citas', [APIControler::class, 'guardar']);
$router->post('/api/eliminar', [APIControler::class, 'eliminar']);

// AREA PRIVADA
$router->get('/cita', [CitaControler::class, 'index']);
$router->get('/admin', [AdminControler::class, 'index']);

// CRUD DE SERVICIOS
$router->get('/servicios', [servicioControler::class, 'index']);
$router->get('/servicios/crear', [servicioControler::class, 'crear']);
$router->post('/servicios/crear', [servicioControler::class, 'crear']);
$router->get('/servicios/actualizar', [servicioControler::class, 'actualizar']);
$router->post('/servicios/actualizar', [servicioControler::class, 'actualizar']);
$router->post('/servicios/eliminar', [servicioControler::class, 'eliminar']);





// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();