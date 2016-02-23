<?php
$username = $_POST['username'];
error_reporting(E_COMPILE_ERROR|E_ERROR|E_CORE_ERROR);
$link = mysql_connect('127.0.0.1', 'root', '');

    if (!$link) {
    header ("Location: index.php?error=2");
    }

    $db_selected = mysql_select_db('imagepag', $link);
    if (!$db_selected) {
        header ("Location: index.php?error=2");
    }

    $result = mysql_query("SELECT * FROM usuaris WHERE username like '$username'");
    if (!$result) {
            header ("Location: index.php?error=3");
    }

    $row = mysql_fetch_assoc($result);

    if ($username == $row['username']) {
        header ("Location: register.php?bad=1");
    }
    else {
        mysql_free_result($result);
        $password = $_POST['password'];
        $mailer = $_POST['mail'];
        $random = rand(10,9999);
        $sql = "insert into usuaris values (NULL, NULL, '" . $mailer . "', '" . $password . "', '" . $username . "', NULL, '" . $random . "', 9);";
        $result = mysql_query($sql);
        if (!$result) {
            header ("Location: index.php?error=3");
        }
        
        require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'imagepag0000@gmail.com';                 // SMTP username
$mail->Password = 'lamadrequetepario';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom("imagepag0000@gmail.com", 'Mailer');
$mail->addAddress($mailer);     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Benvingut a ImagePag';
$mail->Body    = "<p>Benvingut, et passem les teves dades. Recorda finalitzar el teu registre.</p><p>Usuari: '" . $username ."' Contrasenya: '" . $password . "'</p><p><a href='http://127.0.0.1/practica_php/activate.php?token=" . $random . "'>Fes click aquí per acabar el teu registre</a></p>";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
    header ("Location: index.php");
}
        
        //header ("Location: index.php");
    }
mysql_free_result($result);
mysql_close($link);
?>