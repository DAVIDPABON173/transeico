<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as Exception;
require '../vendor/autoload.php';

//DATOS DE CONTACTO
$correo = $_POST['email'];
$nombre = $_POST['nombre'];
$mensaje = $_POST['mensaje'];

//CONFIGURACION Y ENVIO DE CORREO NUEVO CONTACTO
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Host = 'mail.transeicosas.com';
$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->Username = 'informacion@transeicosas.com';
$mail->Password = 'infoTsas2019';
$mail->SMTPSecure = 'tls';  
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->setFrom('informacion@transeicosas.com', 'INFORMACION TRANSEICO SAS');
$mail->addAddress($correo, 'Receiver Name');
$mail->Subject = 'NUEVO CONTACTO! - LANDING PAGE'; 

$html = file_get_contents('../mensaje.html');
$html = str_replace('{{nombre}}', $nombre, $html);
$html = str_replace('{{correo}}', $correo, $html);
$html = str_replace('{{mensaje}}', $mensaje, $html);

$mail->isHTML(true);  // Set email format to HTML
$mail->Body    = $html;

//$mail->msgHTML(file_get_contents('../mensaje.html'), __DIR__);
//$mail->isHTML(PHPMailer_isHTML);
//$mail->AltBody = 'This is a plain text message body';
//$mail->addAttachment('test.txt');
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	//CONFIGURACION Y ENVIO DE CORREO CONFIRMACION AL CONTACTO
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = 'mail.transeicosas.com';
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = 'informacion@transeicosas.com';
	$mail->Password = 'infoTsas2019';
	$mail->SMTPSecure = 'tls';  
	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);
	$mail->setFrom('informacion@transeicosas.com', 'INFORMACION TRANSEICO SAS');
	$mail->addAddress($correo, 'Receiver Name');
	$mail->Subject = 'TRANSEICO SAS - CONFIRMACIÒN DE CORREO'; 

	$html = file_get_contents('../confirmacion.html');
	$html = str_replace('{{nombre}}', $nombre, $html);
	
	$mail->isHTML(true);  // Set email format to HTML
	$mail->Body    = $html;
	$mail->send();
	echo'<script type="text/javascript">
	    alert("*** INFORMACION ENVIADA ***");
	    window.location.href="../index.html";
	    </script>';
	//header('Location: /index.html');
}


