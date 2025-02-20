<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../PHPMailer/Exception.php';
    require '../PHPMailer/PHPMailer.php';
    require '../PHPMailer/SMTP.php';

    class GenerarClave{

        public function enviarNuevaClave($identificacion, $email){
            $f = null;

            $objConexion = new Conexion;
            $conexion = $objConexion->get_conexion();
            
            $consultar = "SELECT * FROM users WHERE identificacion=:identificacion AND email=:email";
            $result = $conexion->prepare($consultar);

            $result->bindParam(":identificacion", $identificacion);
            $result->bindParam(":email", $email);

            $result->execute();

            $f = $result->fetch();

            if ($f) {
                // Generamos la nueva clave a partir de un codigo aleatorio
                $caracteres = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $longitud = 8;
                $newPass = substr(str_shuffle($caracteres),0,$longitud);                

                $claveMd = md5($newPass);

                $actualizarClave = "UPDATE users SET clave=:claveMd WHERE identificacion=:identificacion";
                $result = $conexion->prepare($actualizarClave);

                $result->bindParam(":identificacion", $identificacion);
                $result->bindParam(":claveMd", $claveMd);

                $result->execute();

                               
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'user@example.com';                     //SMTP username
                    $mail->Password   = 'secret';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    // Emisor
                    $mail->setFrom('from@example.com', 'Soporte Coding Now');
                    // Receptor
                    $emailFor = $f['email'];

                    $mail->addAddress($emailFor);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);
                    $mail->CharSet = 'UTF-8';                                 //Set email format to HTML
                    $mail->Subject = 'REASIGNACIÓN DE CONTRASEÑA';
                    $mail->Body    = '
                    
                            <h1 style="font-size:50px;color: #2396bd; text-align:center">Hola Usuario</h1>
                            <p style="text-align:center; color: #999; font-size: 22px">Su nueva contraseña se ha generado éxitosamente, úsela para acceder al sistema</p>
                            <p style="font-size: 60px; color:#2396bd; text-aling:center">'.$newPass.'</p>
                    
                    ';
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo '<script>alert("Mensaje Enviado")</script>';
                    echo "<script> location.href='../Views/Extras/page-login.html' </script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }


            }
            else{
                echo '<script>alert("Los datos de usuario no se encuentran en el sistema")</script>';
                echo "<script> location.href='../Views/Extras/page-login.html' </script>";
            }

        }

    }

?>