<?php
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
$enlace =  mysql_connect('127.0.0.1', 'root', '');
if (!$enlace) {
    die('No pudo conectarse: ' . mysql_error());
}

$bd_seleccionada = mysql_select_db('imagepag', $enlace);
if (!$bd_seleccionada) {
    die ('No se puede usar foo : ' . mysql_error());
}


if (isset($_GET['codi'])) {
  $val = $_GET['codi'];
    $sql = "select * from usuaris where id = $val";
  $resultado2 = mysql_query($sql);
  if (!$resultado2) {
      die('Consulta no válida: ' . mysql_error());
  }
    $fila = mysql_fetch_assoc($resultado2);
    $dirav = $fila['avatar'];
    if ($dirav != NULL){
            unlink ("img_ava/" . $dirav . "");
    }
    mysql_free_result($resultado2);
  $sql = "delete from usuaris where id=$val;";
  $resultado2 = mysql_query($sql);
  if (!$resultado2) {
      die('Consulta no válida: ' . mysql_error());
  }
    mysql_free_result($resultado2);
    $sql = "select * from imatges where id_usu = $val";
    $resultado2 = mysql_query($sql);
    if (!$resultado2) {
        die('Consulta no válida: ' . mysql_error());
    }
    while ($fila = mysql_fetch_assoc($resultado2)) {
        $imatge = $fila['nom'];
        unlink ("img/" . $imatge . "");
    }
    
    mysql_free_result($resultado2);
    $sql = "delete from imatges where id_usu =$val;";
    $resultado2 = mysql_query($sql);
    if (!$resultado2) {
        die('Consulta no válida: ' . mysql_error());
    }
    
    }
    

header ("Location: root_users.php");
mysql_free_result($resultado2);
mysql_close($enlace);
?>