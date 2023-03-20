<?php
require_once 'bd/conexion.php';

class stock{
    static public function obtener(){
        $conexion = new conexion;
        $consulta = $conexion->prepare("SELECT * FROM stock WHERE estado='A'");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        return $resultado;
    }    
    static public function agregar(array $data){
        $conexion = new conexion;
        switch ($data['opcion']) {
            case 'cantidad':
                $consulta = $conexion->prepare("SELECT COUNT(id) cantidad FROM stock WHERE estado='A' ORDER BY id desc");
                $resultado = $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $conexion = null;
                echo $resultado[0]['cantidad'];
                return $resultado[0]['cantidad'];                
                break;                
            case 'crear':               
                $data = $data['datos'];
                $producto = trim(ucwords(strtolower($data['producto'])));
                $estado = "A";
                $consulta = $conexion->prepare("SELECT id FROM stock WHERE producto='$producto'");
                $resultado = $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);

                if($resultado == null){
                    $consulta = $conexion->prepare("SELECT cantidad FROM producto WHERE nombre='$producto'");
                    $resultado = $consulta->execute();
                    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $cantidadEnviada = $data['cantidad'];

                    $resultado = ($resultado[0]['cantidad']);
                    if($data['movimiento'] == 'Salida'){
                        $cantidadEnviada = $cantidadEnviada * -1;
                    }
                    $total = $resultado + $cantidadEnviada;
                    echo $total;
                    $consulta = $conexion->prepare("INSERT INTO stock(producto,cantidad,estado) VALUES ('$producto','$total','$estado')");
                    $consulta->execute();
                    return;
                }
                else{
                    $consulta = $conexion->prepare("SELECT cantidad FROM stock WHERE producto='$producto'");
                    $resultado = $consulta->execute();
                    $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                    $resultado = ($resultado[0]['cantidad']);
                    $cantidadEnviada = $data['cantidad'];
                    if($data['movimiento'] == 'Salida'){
                        $cantidadEnviada = $cantidadEnviada * -1;
                    }
                    $total = $resultado + $cantidadEnviada;
                    $consulta = $conexion->prepare("UPDATE stock SET cantidad='$total' WHERE producto='$producto'");
                    $consulta->execute();
                    return;
                }
                return;
                break;
            case 'informacionTotal':
                $numeroDePagina = intval($data['numeroDePagina']);
                $numeroElementosPorPagina = intval($data['numeroElementosPorPagina']);                
                if($numeroDePagina<1) $numeroDePagina =1;
                $limiteInicial = ($numeroDePagina-1)*$numeroElementosPorPagina;      
                $texto = "%".$data['texto']."%";
                $consulta = $conexion->prepare("SELECT * FROM stock WHERE  ( producto LIKE '$texto')  AND estado='A' ORDER BY id desc LIMIT $numeroElementosPorPagina OFFSET $limiteInicial");
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $conexion = null;     
                echo json_encode($resultado);
                return $resultado;       
                break;
            case 'informacionPorPagina':
                $numeroDePagina = intval($data['numeroDePagina']);
                $numeroElementosPorPagina = intval($data['numeroElementosPorPagina']);                
                if($numeroDePagina<1) $numeroDePagina =1;
                $limiteInicial = ($numeroDePagina-1)*$numeroElementosPorPagina;                
                $consulta = $conexion->prepare("SELECT * FROM stock WHERE estado='A' ORDER BY id desc LIMIT $numeroElementosPorPagina OFFSET $limiteInicial");
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $conexion = null;    
                echo $resultado; 
                return $resultado;       
                break;
            case 'cantidadDePaginas':
                $numeroElementosPorPagina = intval($data['numeroElementosPorPagina']);    
                $texto = "%".$data['texto']."%";
                $consulta = $conexion->prepare("SELECT count(id) as cantidad FROM stock WHERE ( producto LIKE '$texto') AND estado='A'");
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $resultado = ceil($resultado[0]['cantidad']/$numeroElementosPorPagina);
                $conexion = null;    
                echo $resultado;
                return $resultado;       
                break; 
            break;
            default:
                break;
        }
    }

    static public function editar(array $data){

        $conexion = new conexion;
        
        $id = $data['id'];
        $cedula = trim(ucwords(strtolower($data['cedula'])));
        $nombre = trim(ucwords(strtolower($data['nombre'])));
        $apellido = trim(ucwords(strtolower($data['apellido'])));
        $proceso = trim(ucwords(strtolower($data['proceso'])));
        $cargo = trim(ucwords(strtolower($data['cargo'])));
        $correo = trim(ucwords(strtolower($data['correo'])));
        $rol = trim(ucwords(strtolower($data['rol'])));
        $contrasena = trim(ucwords(strtolower($data['contrasena'])));

        $consulta = $conexion->prepare("UPDATE usuario_cliente SET cedula='$cedula',nombre='$nombre',apellido='$apellido',proceso='$proceso',cargo='$cargo',correo='$correo',rol='$rol',contrasena='$contrasena' WHERE id='$id'");
        $consulta->execute();
        $conexion=null;

    }
    static public function borrar(array $data){

        $conexion = new conexion;
        
        $id = $data['id'];

        $consulta = $conexion->prepare("UPDATE usuario_cliente SET borrado=true WHERE id='$id'");
        $consulta->execute();
        $conexion=null;

    }
}
?>