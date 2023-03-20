<?php
class conexion extends PDO {
    
    private $tipo_de_base = 'mysql';
    private $host = 'proyectotodo.mysql.database.azure.com';
    private $nombre_de_base = 'proyecto_todo';
    private $usuario = 'todo';
    private $contrasena = 'GroupIndustrial123';
    
    public function __construct()
    {  
        try {
            parent::__construct("{$this->tipo_de_base}:host={$this->host};port=3306;dbname={$this->nombre_de_base};charset=utf8",
            $this->usuario, $this->contrasena);
        } catch(PDOException $e) {
            echo "Ha surgido un error y no se puede detalle " . $e->getMessage();
        }
    }
}
?>

