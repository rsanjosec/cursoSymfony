<?php

namespace Jazzyweb\AulasMentor\AlimentosBundle\Model;

/**
 * Description of Model
 *
 * @author cirus
 */
class Model {
    protected $conexion;
    public function __construct($dbname,$dbuser,$dbpass,$dbhost) {
        $mvc_bd_conexion = mysql_connect($dbhost, $dbuser, $dbpass);
        if (!$mvc_bd_conexion) {
           die('No ha sido posible realizar la conexión con la base de datos: '
            . mysql_error());
       }
       mysql_select_db($dbname, $mvc_bd_conexion);
       mysql_set_charset('utf8');
       $this->conexion = $mvc_bd_conexion;
    }
    
    public function dameAlimentos(){
        $sql = "SELECT * FROM alimentos ORDER BY energia DESC";
        $result = mysql_query($sql,  $this->conexion);
        $alimentos = array();
        while ($row = mysql_fetch_assoc($result)){
            $alimentos[] = $row;
        }    
        return $alimentos;     
    }
    
    public function buscarAlimentosPorNombre($n){
        $n = htmlspecialchars($n);
        $sql = "SELECT * FROM alimentos WHERE nombre LIKE '".$n."%' ORDER BY energia DESC";
        $result = mysql_query($sql, $this->conexion);
        $alimentos = array();
        while($row = mysql_fetch_assoc($result)){
            $alimentos[] = $row;
        }
        return $alimentos;
    }
    
    public function buscarAlimentosPorEnergia($operador,$energia){
        $energia = htmlspecialchars($energia);       
        $sql = "SELECT * FROM alimentos WHERE energia $operador  '$energia' ORDER BY energia";        
        $result = mysql_query($sql, $this->conexion);
        $alimentos = array();        
        
        if (!$result) {                        
            $alimentos[] = array("error" => "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>con la consulta:<br>\n$sql\n<br>");
        }else{
            $numResult = mysql_num_rows($result);
            if($numResult > 0){
               while($row = mysql_fetch_assoc($result)){               
                   $alimentos[] = $row;                   
               }
            }else{
                $alimentos[] = array("error" => "No se han encontrado resultador bajo los criterios de búsqueda seleccionados.");                            
            }      
            
        }        
        return $alimentos;
    }
    
    
    public function buscarAlimentosPorCombinada($operador, $nombre, $energia){
        $n = htmlspecialchars($nombre);
        $e = htmlspecialchars($energia);
        $sql = "SELECT * FROM alimentos WHERE nombre LIKE '".$n."%' AND energia $operador '$e' ORDER BY energia";        
        $result = mysql_query($sql, $this->conexion);
        $alimentos = array();
        if (!$result) {                        
            $alimentos[] = array("error" => "MySQL error ".mysql_errno().": ".mysql_error()."\n<br>con la consulta:<br>\n$sql\n<br>");
        }else{
            $numResult = mysql_num_rows($result);
            if($numResult > 0){
               while($row = mysql_fetch_assoc($result)){               
                   $alimentos[] = $row;                   
               }
            }else{
                $alimentos[] = array("error" => "No se han encontrado resultador bajo los criterios de búsqueda seleccionados.");                            
            }      
            
        }        
        return $alimentos;
    }
    
    public function insertarAlimentos($n, $e, $p, $h, $f, $g){
        $n = htmlspecialchars($n);
        $e = htmlspecialchars($e);
        $p = htmlspecialchars($p);        
        $h = htmlspecialchars($h);
        $f = htmlspecialchars($f);
        $g = htmlspecialchars($g);      
  
        $sql = "insert into alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal)
                values('".$n."',".$e.",".$p.",".$h.",".$f.",".$g.")";
        
        $result = mysql_query($sql, $this->conexion);
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        return $result;        
    }
    
    public function dameAlimento($id){
        $id = htmlspecialchars($id);
        $sql = "select * from alimentos where id=$id";
        $result = mysql_query($sql, $this->conexion);
        $row = mysql_fetch_assoc($result);
        if (!$result) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            $message .= 'Whole query: ' . $sql;
            die($message);
        }
        return $row;
    }
    
    public function validarDatos($n, $e, $p, $h, $f, $g){
        return (is_string($n) &
                is_numeric($e) &
                is_numeric($p) &
                is_numeric($h) &
                is_numeric($f) &
                is_numeric($g));     
    }
}

?>