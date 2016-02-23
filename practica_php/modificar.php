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
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
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
                        echo "<table><tr><td rowspan='3'><img src='img_ava/" . $avatar."'></td>";
                        echo "<td><h3>Benvingut $username</h3></td></tr><td>";
                        echo "<a href='panel.php'>Panel de Control</a></tr><td><a href='logout.php'>Logout</a></p></td></tdr></table>";
                  }
                ?>
            </div>
        </div>
        <div id="buscador">
            <form id="busca" name="busca" method="get" action"">
                <p><input type="text" name="" /><input type="submit" name="Cerca" id="Cerca" value="Cerca" /></p>
            </form>
        </div>
        <div id="principal">
            <div id="modificar">
            <?php
                error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
                $link = mysql_connect('127.0.0.1', 'root', '');

                if (!$link) {
                header ("Location: index.php?tablerror=1");
                }

                $db_selected = mysql_select_db('imagepag', $link);
                if (!$db_selected) {
                    header ("Location: index.php?tablerror=1");
                }

                        if (isset($_POST['bnou'])) {
                                            $nnom = $_POST['nom'];
                                            $nmail = $_POST['mail'];
                                            $npassword = $_POST['password'];
                                            $sql = "update usuaris set nom='" . $nnom . "', mail='" . $nmail . "', password='" . $npassword . "' where id='" . $login . "'";
                                            $resultado2 = mysql_query($sql);
                                            if (!$resultado2) {
                                                            die('Consulta no válida: ' . mysql_error());
                                            }
                        header ("Location: panel.php");
                        }

if (isset($_POST["button"])) {
                unlink ("img_ava/" . $avatar . "");
              $myId = mysql_insert_id();
		      $src = $_FILES['fileField']['tmp_name'];
		      $dst = ".\\img_ava\\" . $login . $_FILES['fileField']['name'];
		      $dst2 = $login . $_FILES['fileField']['name'];
		
		      move_uploaded_file ($src, $dst);
		
		      $sql = "update usuaris set avatar='" . $dst2 . "' where id = $login;";
    
                $_SESSION['avatar'] = $dst2;
		
		      $result = mysql_query($sql);
		      if (!$result) {
		                  echo "<p>Hi ha hagut un problema amb la base de dades</p>";
		          }
	           }

                        $sql = "SELECT nom, password, mail, avatar FROM usuaris where id=$login;";

                        $result = mysql_query($sql);
                        if (!$result) {
                                die('Consulta no válida: ' . mysql_error());
                        }

                        if (!$fila = mysql_fetch_assoc($result)) {
                                    header ("Location: index.php");
                        }

                mysql_free_result($result);
                mysql_close($link);
            ?>
            <form id="form1" name="form1" method="post" action="modificar.php">
            <p>Nom complet: 
            <label for="val"></label>
            <input type="text" name="nom" id="nom" value="<?php echo $fila['nom']; ?>" />
            </p>
            <p>Password: 
            <label for="password"></label>
            <input type="text" name="password" id="password" value="<?php echo $fila['password']; ?>" />
            </p>
            <p>Correu: 
            <label for="mail"></label>
            <input type="text" name="mail" id="mail" value="<?php echo $fila['mail']; ?>" />
            </p>
            <p>Username: <?php echo "$username"; ?></p>
            <p>
            <input type="submit" name="bnou" id="bnou" value="Afegir" />
            </p>
            </form>
            <form name="f2" action="modificar.php" method="post" enctype="multipart/form-data">
            <p>Aqui pots pujar un avatar. Recorda que si pujes una imatge molt gran podria no quedar com penses. La mesura indicada es de 100px o menos.</p>
            <p><label for="fileField"></label>Imatge: <input type="file" name="fileField" id="fileField" /></p>
            <p><input type="submit" name="button" id="" value="Enviar" /></p>
            </form>
            </div>
        </div>
        <div id="footer">
            <p>Víctor Domínguez Guerra - 2015</p>
        </div>
    </div>
</body>
</html>