<?php
  session_start();
if (isset ($_SESSION['login_id'])){
  $login = $_SESSION['login_id'];
  $username = $_SESSION['login_user'];
  $avatar = $_SESSION['avatar'];
  $role = $_SESSION['role'];
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="main.css" type="css/text"/>
<title>ImagePag</title>
</head>
<body>
	<div id="contenidor">
    	<div id="frontal">
        	<div id="title">
                <h1><a href="index.php">ImagePag</a></h1>
                <h2>You are going to WRYYYY like it.</h2>
            </div>
            <div id="login">
                <?php
                  if (!isset ($login)){
                            if (isset ($_GET['error'])) {
                                $error = $_GET['error'];
                                if ($error == 1) {
                                    echo "<p>La contrasenya no es correcta</p>";
                                }
                                else if ($error == 3) {
                                    echo "<p>L'usuari que dius, no existeix</p>";
                                }
                                else {
                                    echo "<p>Hi ha un problema amb la base de dades</p>";
                                }
                            }
                            echo "<form id='form1' name='form1' method='post' action='login.php'>";
                            echo "<table><tr><td>Username:</td><td>";
                            echo "<label for='user'></label>";
                            echo "<input type='text' name='user' id='user' /></td></tr>";
                            echo "<tr><td>Password:</td><td>";
                            echo "<label for='pass'></label>";
                            echo "<input type='text' name='pass' id='pass' /></td></tr>";
                            echo "<tr><td><input type='submit' name='Enviar' id='Enviar' value='Enviar' /></td><td><a href='register.php'>Registra una nova compta</a></td></tr></table></form>";
                  }
                  else {
                        if ($avatar == NULL) {
                        echo "<table><tr><td rowspan='3'><img src='img_ava/default.png'></td>";
                        }
                        else {
                        echo "<table><tr><td rowspan='3'><img src='img_ava/" . $avatar."'></td>";
                        }
                        echo "<td><h3>Benvingut $username</h3></td></tr><td>";
                        echo "<a href='panel.php'>Panel de Control</a></tr><td><a href='logout.php'>Logout</a></p></td></tdr></table>";
                  }
                ?>
            </div>
        </div>
        <div id="buscador">
            <form id="busca" name="busca" method="post" action="search.php">
                <p><select id="category" name="category">
				<option id="memes" value="memes">Memes</option>
				<option id="general" value="general">General</option>
                <option id="gracioses" value="gracioses">Gracioses</option>
                <option id="jojo" value="jojo">Jojo</option>
			</select><input type="submit" name="Cerca" id="Cerca" value="Cerca" /></p>
            </form>
        </div>
        <div id="principal">
            <?php
                $category = $_POST['category'];
                error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
                $link = mysql_connect('127.0.0.1', 'root', '');

                if (!$link) {
                header ("Location: index.php?tablerror=1");
                }

                $db_selected = mysql_select_db('imagepag', $link);
                if (!$db_selected) {
                    header ("Location: index.php?tablerror=1");
                }

                $result = mysql_query("SELECT * FROM imatges WHERE categoria like '" . $category . "'");
                if (!$result) {
                        header ("Location: index.php?tablerror=1");
                }
                if (isset ($_GET['tablerror'])) {
                        echo "<p>Hi ha un problema amb la base de dades</p>";
                }
                else {
                        echo "<h1>Imatges de la categoria '" . $category . "'</h1>";
                        while ($fila = mysql_fetch_assoc($result)) {
                        $img = $fila['nom'];
                        $imgid = $fila['id'];
                        echo "<a href='imatge.php?imatge=". $imgid ."'><img src='img/" . $img ."'></a>";
                        }
                }

                mysql_free_result($result);
                mysql_close($link);
            ?>
        </div>
        <div id="footer">
            <p>Víctor Domínguez Guerra - 2015</p>
        </div>
    </div>
</body>
</html>