<?php session_start();?>

<?php

if (isset($_POST['send']) && $_SERVER['REQUEST_METHOD'] == "POST"){

if (isset($_POST['name'])) {$from_whom = $_POST['name']; if ($from_whom == '') {unset($from_whom);}}

if (isset($_POST['mail'])) {$postal_address = $_POST['mail']; if ($postal_address == '') {unset($postal_address);}}

if (isset($_POST['msg'])) {$the_message = $_POST['msg']; if ($the_message == '') {unset($the_message);}}

if (isset($_POST['tema'])) {$tema = $_POST['tema']; if ($tema == '') {unset($tema);}}

$date=date("d.m.Y");

$time=date("H:i");

if(isset($from_whom) && isset($postal_address)  && isset($the_message)){

$from_whom = htmlspecialchars(trim($from_whom));

$postal_address = htmlspecialchars(trim($postal_address));

$the_message = htmlspecialchars(trim($the_message));

$tema = htmlspecialchars(trim($tema));

$_SESSION['name'] = $from_whom;

$_SESSION['mail'] = $postal_address;

$_SESSION['msg'] = $the_message;



$address = "cinema@vn.ua,igor@info.cci.vn.ua,natalia.budyak@gmail.com,diduk.d@gmail.com"; 

$sub = "Повідомлення зі сайту cinema.vn.ua";

$message = "Від: $from_whom \n E-mail: $postal_address \n Дата відправлення: $date \n Тема повідомлення: $tema\n Повідомлення: \n $the_message";

if(mail ($address,$sub,$message,"Content-type:text/plain; charset = UTF-8\r\nFrom:$from_whom")){  

        $_SESSION['respon']="yes";

        unset($_SESSION['name']);

        unset($_SESSION['mail']);       

        unset($_SESSION['msg']);

        header("Location:http://".$_SERVER['SERVER_NAME']."/kontakti");       

      }else{

        $_SESSION['errorka']="yes";

        header("Location:http://".$_SERVER['SERVER_NAME']."/kontakti");   

      }

      }else{

        $_SESSION['facking_send']="yes";

        header("Location:http://".$_SERVER['SERVER_NAME']."/kontakti");

     }

}

if (isset($_POST['send_calback']) && $_SERVER['REQUEST_METHOD'] == "POST"){
if (isset($_POST['name_user'])) {$from_whom = $_POST['name_user']; if ($from_whom == '') {unset($from_whom);}}
if (isset($_POST['phone_user'])) {$phone_user = $_POST['phone_user']; if ($phone_user == '') {unset($phone_user);}}
if (isset($_POST['ip_address'])) {$ip_address = $_POST['ip_address']; if ($ip_address == '') {unset($ip_address);}}
$date=date("d.m.Y");
$time=date("H:i");
if(isset($from_whom) && isset($phone_user)){
$from_whom = htmlspecialchars(trim($from_whom));
$phone_user = htmlspecialchars(trim($phone_user));
$ip_address = htmlspecialchars(trim($ip_address));
$address = "cinema@vn.ua,diduk.d@gmail.com,natalia.budyak@gmail.com,aleksandra.tsymbal@gmail.com,diduk.d@gmail.com"; 
$sub = "Повідомлення зі сайту cinema.vn.ua";
$message = "Від: $from_whom \n Телефон: $phone_user \n Дата відправлення: $date \n Час: $time\n  IP користувача: \n $ip_address";
if(mail($address,$sub,$message,"Content-type:text/plain; charset = UTF-8\r\nFrom:$from_whom")){  
        header("Location:http://".$_SERVER['SERVER_NAME']."#cinema");       
      }else{     
        header("Location:http://".$_SERVER['SERVER_NAME']."#cinema");   
      }
      }else{    
        header("Location:http://".$_SERVER['SERVER_NAME']."#cinema");
     }
}
?>