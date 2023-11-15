<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

include("../../bd/conexion.php");
$db = DataBase::connect();
date_default_timezone_set("America/Guayaquil");

$cor = $_POST['correo'];
$query = "SELECT * from usuarios WHERE correo = '$cor' AND estado=1";
$result = $db->query($query);
$row = $result->fetch_assoc();

if($result->num_rows > 0){
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'shirleyrojasponce@hotmail.com';                     //SMTP username
        $mail->Password   = 'Jenniffer14';                               //SMTP password
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('shirleyrojasponce@hotmail.com', 'Shirley Rojas Ponce');
        $mail->addAddress($cor);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Recuperar Clave';
        $mail->Body    = 'Hola, este es un correo generado para solicitar tu recuperación de contraseña, 
        por favor, visita la página <a href="http://localhost/03.11.2023-Proyecto/TodoAgro/pages/UI/cambiar_contrasenia.php?id='.$row['id_usu'].'">Recuperar Clave</a>';
        
        $mail->send();
        header("Location: ../../login-todoagro.php?message=ok");
    } catch (Exception $e) {

        header("Location: ../../login-todoagro.php?message=error");
    }

}else{
    header("Location: ../../login-todoagro.php?message=not_found");
    exit();
}


?>