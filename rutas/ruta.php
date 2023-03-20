<?php
$miArreglo = explode("/", $_SERVER['REQUEST_URI']);

if(count(array_filter($miArreglo))<3){
    $json = array(
        "ruta:"=>"La ruta no ha sido encontrada, favor validar"
    );
    echo json_encode($json,true);
    return;
}else{
    $endPoint = array_filter($miArreglo)[3];
    $metodo = $_SERVER['REQUEST_METHOD'];  
    
    (array)$data = json_decode(file_get_contents('php://input'),true);

    switch ($endPoint){
        case 'producto':
            $objeto = new controladorProducto($metodo,$data);
            $objeto->index();
            break;
        case 'stock':
            $objeto = new controladorStock($metodo,$data);
            $objeto->index();
            break;
        case 'usuarios':
            $objeto = new controladorUsuario($metodo,$data);
            $objeto->index();
            break;
        default:
            $json = array(
                "rutas" => "La ruta no ha sido encontrada, favor validar"
            );
            echo json_encode($json);
            return false;
        return;
    }
}
?>