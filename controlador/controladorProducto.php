<?php
class controladorProducto{
    private $_metodo;
    private $_datos;
    function __construct($metodo,$datos)
    {
        $this->_metodo = $metodo;
        $this->_datos = $datos != 0 ? $datos : ""; 
    }
    public function index(){
        switch ($this->_metodo){
            case 'GET':                
                $miProducto = producto::obtener();
                return $miProducto;                    
            break;
            case 'POST':
                $miProducto = producto::agregar($this->_datos);
                return $miProducto;
            break;   
            case 'PUT':
                $miProducto = producto::editar($this->_datos);
                $json = array(
                    "response" => "Usuario actualizado correctamente"
                );                
                echo json_encode($json,true);
                return;
            break;   
            case 'DELETE':
                $miProducto = producto::borrar($this->_datos);
                $json = array(
                    "response" => "Usuario borrado correctamente"
                );                
                echo json_encode($json,true);
                return;
            break;                
            default:
                    $json = array(
                        "ruta:"=>"El metodo no ha sido encontrado"
                    );
                    echo json_encode($json,true);
            return;
        }
    }
}

?>