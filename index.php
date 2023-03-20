<?php

require_once 'controlador/ruta.php';
require_once 'controlador/controladorProducto.php';
require_once 'modelo/producto.php';
require_once 'controlador/controladorStock.php';
require_once 'modelo/stock.php';
require_once 'controlador/controladorUsuario.php';
require_once 'modelo/usuario.php';

//include 'autoCargador.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$mis_rutas = new controladorRuta();  
$mis_rutas->index();  


?>