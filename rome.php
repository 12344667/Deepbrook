<?php

session_start();


include "../../config/db.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_SESSION['uid'])){




}
else{


	header("location:../c2wadmin/signin.php");
}


if(isset($_POST['bank'])){



$email =$link->real_escape_string( $_POST['email']);
$ewallet =$link->real_escape_string( $_POST['ewallet']);
$bwallet =$link->real_escape_string( $_POST['bwallet']);
$pm =$link->real_escape_string($_POST['pm']);




    $sql = "UPDATE admin SET ewallet='$ewallet', bwallet='$bwallet',pm='$pm' WHERE email='$email'";



	if (mysqli_query($link, $sql)) {


               $msg= " Details has been successfully added";

                           } else {
                        $msg= " Details was not added ";
                         }

}


if(isset($_POST['ubank'])){



$email =$link->real_escape_string( $_POST['email']);
$ewallet =$link->real_escape_string( $_POST['ewallet']);
$bwallet =$link->real_escape_string( $_POST['bwallet']);
$pm =$link->real_escape_string($_POST['pm']);




    $sql = "UPDATE admin SET ewallet='$ewallet', bwallet='$bwallet',pm='$pm' WHERE email='$email'";



	if (mysqli_query($link, $sql)) {


               $msg= " Details has been successfully Updated";

                           } else {
                        $msg= " Details was not Updated ";
                         }

}




include "header.html";


    ?>





 <div class="content-wrapper">



  <!-- Main content -->
  <section class="content">








<div class="col-md-12 col-sm-12 col-sx-12">
          <div class="box box-default">
            <div class="box-header with-border">

          <h4 align="center"><i class="fa fa-plus"></i> WALLET MANAGEMENT</h4>
</br>






          <hr></hr>



            <div class="box-header with-border">

            <?php if($msg != "") echo "<div style='padding:20px;background-color:#dce8f7;color:black'> $msg</div class='btn btn-success'>" ."</br></br>";  ?>
          </br>


            <?php
        $sql1= "SELECT * FROM admin";
  $result1 = mysqli_query($link,$sql1);
  if(mysqli_num_rows($result1) > 0){
  $row = mysqli_fetch_assoc($result1);

    if(isset($row['ewallet']) && isset($row['bwallet'])  && isset($row['pm'])){
  $ew = $row['ewallet'];
  $bw = $row['bwallet'];
  $an = $row['pm'];

}else{
  $ew="cant find wallet";
   $bw="cant find wallet";
    $an="cant find wallet";

}
}
          ?>
