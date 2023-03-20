<?php
class controladorStock{
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
                $miStock = stock::obtener();
                return $miStock;                    
            break;
            case 'POST':
                $miStock = stock::agregar($this->_datos);
                return $miStock;
            break;   
            case 'PUT':
                $miStock = stock::editar($this->_datos);
                $json = array(
                    "response" => "Usuario actualizado correctamente"
                );                
                echo json_encode($json,true);
                return;
            break;   
            case 'DELETE':
                $miStock = stock::borrar($this->_datos);
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