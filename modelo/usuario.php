<?php
require_once 'bd/conexion.php';

class usuarios{
    static public function obtener(){
        $conexion = new conexion;
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE estado='A'");
        $consulta->execute();
        $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $conexion = null;
        echo json_encode($resultado);
        return $resultado;
    }
    
    static public function agregar(array $data){
        $conexion = new conexion;
        switch ($data['opcion']) {
            case 'cantidad':
                $consulta = $conexion->prepare("SELECT COUNT(id) cantidad FROM usuario WHERE estado='A' ORDER BY id desc");
                $resultado = $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $conexion = null;
                echo $resultado[0]['cantidad'];
                return $resultado[0]['cantidad'];                
                break;                
            case 'verificarCorreo':
                $data = $data['datos'];
                $correo = trim(ucwords(strtolower($data['correo'])));
                $contrasena = trim(ucwords(strtolower($data['contrasena'])));
                $contrasena = crypt($data['contrasena'],'$2a$07$aflkdsjncsbnchblaslp$');
                $consulta = $conexion->prepare("SELECT * FROM usuario WHERE correo='$correo' AND contrasena='$contrasena'");
                $resultado = $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                if($resultado != null){
                    $conexion = null;
                    echo true;
                    return true;
                }else{
                    $conexion = null;
                    echo 'false';
                    return 'false';
                }
                break;                
            case 'crear':               
                $data = $data['datos'];
                $codigo = trim(ucwords(strtolower($data['codigo'])));
                $nombre = trim(ucwords(strtolower($data['nombre'])));
                $detalle = trim(ucwords(strtolower($data['detalle'])));
                $proveedor = trim(ucwords(strtolower($data['proveedor'])));
                $cantidad = $data['cantidad'];
                $valor = trim(ucwords(strtolower($data['valor'])));
                $estado = "A";
                $consulta = $conexion->prepare("INSERT INTO usuario(codigo,nombre,detalle,proveedor,cantidad,valor,estado) VALUES ('$codigo','$nombre','$detalle','$proveedor','$cantidad','$valor','$estado')");
                $consulta->execute();
                $conexion = null;
                return "Proceso creado exitosamente";
                break;
            case 'informacionTotal':
                $numeroDePagina = intval($data['numeroDePagina']);
                $numeroElementosPorPagina = intval($data['numeroElementosPorPagina']);                
                if($numeroDePagina<1) $numeroDePagina =1;
                $limiteInicial = ($numeroDePagina-1)*$numeroElementosPorPagina;      
                $texto = "%".$data['texto']."%";
                $consulta = $conexion->prepare("SELECT * FROM usuario WHERE  ( nombre LIKE '$texto' or detalle LIKE '$texto')  AND estado='A' ORDER BY id desc LIMIT $numeroElementosPorPagina OFFSET $limiteInicial");
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
                $consulta = $conexion->prepare("SELECT * FROM usuario WHERE estado='A' ORDER BY id desc LIMIT $numeroElementosPorPagina OFFSET $limiteInicial");
                $consulta->execute();
                $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
                $conexion = null;    
                echo $resultado; 
                return $resultado;       
                break;
            case 'cantidadDePaginas':
                $numeroElementosPorPagina = intval($data['numeroElementosPorPagina']);    
                $texto = "%".$data['texto']."%";
                $consulta = $conexion->prepare("SELECT count(id) as cantidad FROM usuario WHERE ( nombre LIKE '$texto' or detalle LIKE '$texto') AND estado='A'");
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
        $data = $data['cliente'];
        $ciudad = trim(ucwords(strtolower($data['ciudad'])));
        $nombre = trim(ucwords(strtolower($data['nombre'])));
        $contrasena = trim(ucwords(strtolower($data['contrasena'])));
        $contrasena = crypt($data['contrasena'],'$2a$07$aflkdsjncsbnchblaslp$');
        $correo = trim(ucwords(strtolower($data['correo'])));
        $direccion = trim(ucwords(strtolower($data['direccion'])));
        $numeroDocumento = trim(ucwords(strtolower($data['numeroDocumento'])));
        $tipoIdentificacion = trim(ucwords(strtolower($data['tipoIdentificacion'])));

        $consulta = $conexion->prepare("UPDATE usuario SET ciudad='$ciudad' , nombre='$nombre' , contrasena='$contrasena' , correo='$correo' , direccion='$direccion' , numeroDocumento='$numeroDocumento' , tipoIndentificacion='$tipoIdentificacion' WHERE id=1");
        $consulta->execute();
        $conexion = null;
        return "Proceso creado exitosamente";

    }
    static public function borrar(array $data){

        $conexion = new conexion;
        
        $id = $data['id'];

        $consulta = $conexion->prepare("UPDATE usuario SET borrado=true WHERE id='$id'");
        $consulta->execute();
        $conexion=null;

    }
}
?>