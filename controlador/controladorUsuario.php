<?php
class controladorUsuario{
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
                $miUsuario = usuarios::obtener();
                return $miUsuario;                    
            break;
            case 'POST':
                $miUsuario = usuarios::agregar($this->_datos);
                return $miUsuario;
            break;   
            case 'PUT':
                $miUsuario = usuarios::editar($this->_datos);
                $json = array(
                    "response" => "Usuario actualizado correctamente"
                );                
                echo json_encode($json,true);
                return;
            break;   
            case 'DELETE':
                $miUsuario = usuarios::borrar($this->_datos);
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