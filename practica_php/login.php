<?php
    session_start();
    $user = $_POST['user'];
    $pass = $_POST['pass'];
	
    $link = mysql_connect('127.0.0.1', 'root', '');

    if (!$link) {
    header ("Location: index.php?error=2");
    }

    $db_selected = mysql_select_db('imagepag', $link);
    if (!$db_selected) {
        header ("Location: index.php?error=2");
    }

    $result = mysql_query("SELECT * FROM usuaris WHERE username like '$user'");
    if (!$result) {
            header ("Location: index.php?error=3");
    }

    $row = mysql_fetch_assoc($result);
    
    if ($row['role'] == 9) {
        header ("Location: index.php?error=3");
    }
    
	if ($pass == $row['password']) {
    $_SESSION['login_id'] = $row['id'];
    $_SESSION['login_user'] = $row['username'];
    $_SESSION['avatar'] = $row['avatar'];
    $_SESSION['role'] = $row['role'];
		header ("Location: panel.php");
	}
	else {
		header ("Location: index.php?error=1");
	}
  mysql_free_result($result);
  mysql_close($link);
?>