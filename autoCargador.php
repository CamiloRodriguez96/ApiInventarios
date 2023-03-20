<?php

function autoCargador($clase){
    $miControlador = substr($clase,0,11);
    if($miControlador=='controlador'){
        $miClase = substr($clase,11);
        include 'controlador/' . $miClase.'.php';
    }else{        
        include 'modelo/' . $clase.'.php';
    }    
}

spl_autoload_register('autoCargador');

?>