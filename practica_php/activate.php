<?php
    $token = $_GET['token'];
    error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
    $link = mysql_connect('127.0.0.1', 'root', '');

    if (!$link) {
    header ("Location: index.php?error=2");
    }

    $db_selected = mysql_select_db('imagepag', $link);
    if (!$db_selected) {
        header ("Location: index.php?error=2");
    }

    $result = mysql_query("SELECT * FROM usuaris WHERE token = $token");
    if (!$result) {
            header ("Location: index.php?error=3");
    }
    $row = mysql_fetch_assoc($result);
    $id = $row['id'];
    if ($token == $row['token']) {
        mysql_free_result($result);
        $result = mysql_query("update usuaris set role = 1 where id = $id;");
        if (!$result) {
            header ("Location: index.php?error=3");
        }
    }
    
    header ("Location: index.php");
    
mysql_free_result($result);
mysql_close($link);
?>