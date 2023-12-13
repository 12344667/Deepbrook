<?php

session_start();


include "../../config/db.php";
include "password.html";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;


if(isset($_POST['submit'])){


$opassword =$link->real_escape_string($_POST['opassword']);
$cpassword =$link->real_escape_string($_POST['cpassword']);
$password =$link->real_escape_string($_POST['password']);
$email =$link->real_escape_string($_POST['email']);


if ( $opassword == $cpassword){


$sql = "UPDATE admin SET password='$password' WHERE email='$email'";


  mysqli_query($link, $sql);



    $msg= " Password changed successfully";


 }

 else{


 $msg= "Wrong Old Password! ";
}


}


include "header.php";
include "password.html";

    ?>
