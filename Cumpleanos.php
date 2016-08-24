 
<?php 
ethrgerwefrgrge
include("class.phpmailer.php");
include("class.smtp.php"); 

$dbconn3 = pg_connect("host=192.168.40.244 port=5432 dbname=swcapital_lv user=postgres password=");


$html='
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body style="margin: 10; padding: 10;">
  <center><img src="http://www.masivocapital.co/images/TARJETA_CUMPLEANOS_2.jpg" width="600" height="800" border="0"></center>
</body>
</html>
';


$sqlC = 
"select 
emp_correo, emp_nombre, emp_nombre2
from sw_empleados
where extract(month from emp_fecha_nacimiento) = extract(month from current_timestamp) and 
      extract(day from emp_fecha_nacimiento) = extract(day from current_timestamp)
      and emp_estado='0'";

                  $RESC = pg_query($dbconn3, $sqlC); 
                  $correos = array(); 

 									while ($arr = pg_fetch_array($RESC)) {
                                                   array_push($correos , $arr[0]);

$nombre1 = $arr[1];
$nombre2 = $arr[2]; 
$mensaje = 'TE DESEAMOS UN FELIZ CUMPLEAÑOS';
$Subject = $nombre1.' '.$nombre2 .' '.$mensaje;
                                     
                                                                
$mail = new PHPMailer();
$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "server.masivocapital.co";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "juancarlos.medina@masivocapital.co";  // SMTP username
$mail->Password = "Juan2016"; // SMTP password
$mail->Port = 587;  
$mail->From = "comunicaciones@masivocapital.co";
$mail->FromName = "comunicaciones@masivocapital.co";
$mail->AddAddress($arr[0]);
$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->IsHTML(true);                                  // set email format to HTML
$mail->Subject = $Subject; 
$mail->Body    = $html;
$mail->CharSet = 'UTF-8';

if(!$mail->Send())
{
  echo "Message could not be sent. <p>";  
  echo "Mailer Error: " . $mail->ErrorInfo; 
  exit;
}
echo $html;
}

?>

