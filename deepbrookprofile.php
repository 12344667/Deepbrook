<?php


session_start();




include "../config/db.php";
include "../config/config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;



if(isset($_SESSION['email'])){

    $email = $_SESSION['email'];
		 $sql = "UPDATE users SET session='1' WHERE email='$email'";

	  mysqli_query($link, $sql) or die(mysqli_error($link));


	}
else{


	header("location:../login.php");
}




$pdbalance = 0;
$pdprofit = 0;
$percentage = 0;
$wbtc1 = 0;




$sql2= "SELECT * FROM users WHERE email= '$email'";
$result2 = mysqli_query($link,$sql2);
if(mysqli_num_rows($result2) > 0){
 $row = mysqli_fetch_assoc($result2);
 $pdate = $row['pdate'];
 $duration = $row['duration'];
 $increase = $row['increase'];
 $usd = $row['usd'];
}

$sql2= "SELECT * FROM users WHERE email= '$email'";
$result2 = mysqli_query($link,$sql2);
if(mysqli_num_rows($result2) > 0){
 $row = mysqli_fetch_assoc($result2);
 $pdate = $row['pdate'];
 $duration = $row['duration'];
 $increase = $row['increase'];
 $usd = $row['usd'];
}


        if(isset($row['pdate']) &&  $row['pdate'] != '0' && isset($row['duration'])  && isset($row['increase'])  && isset($row['usd']) ){

          $endpackage = new DateTime($pdate);
          $endpackage->modify( '+ '.$duration. 'day');
 $Date2 = $endpackage->format('Y-m-d');
 $current=date("Y/m/d");

 $diff = abs(strtotime($Date2) - strtotime($current));

 $days=floor($diff / (60*60*24));
$daily = $duration - $days;
$percentage = ($increase/100) * $daily * $usd;
$_SESSION['pprofit'] = $percentage;



$add="days";

 }else {
   $daily ="";
   $percentage ="";
   $Date = "0";
   $days ="No active days";
   $diff = "";
   $Date2 = 'No active date';
 }
if(isset($_SESSION['pprofit'])){

  $profit = $_SESSION['pprofit'];
}else{
  $profit = "0";
  $_SESSION['pprofit'] = "0";
}








$sql21= "SELECT * FROM users WHERE email= '$email'";
$result21 = mysqli_query($link,$sql21);
if(mysqli_num_rows($result21) > 0){
$row1 = mysqli_fetch_assoc($result21);
$pdbalance = $row1['walletbalance'];
$pdprofit = $row1['profit'];
$fname = $row1['fname'];
$lname = $row1['lname'];
$reg_date = $row1['date'];
$phoneu = $row1['phone'];
}

$sql211= "SELECT SUM(moni) as total_value FROM wbtc WHERE email= '$email' and status= 'completed'";
$result211 = mysqli_query($link,$sql211);
$row11 = mysqli_fetch_assoc($result211);
if($row11['total_value'] != ""){
$wbtc1 = $row11['total_value'];
}else{
$wbtc1 = 0;
}

$fname_err = $lname_err = $phone_err = $password_err = "";

if(isset($_POST['submit'])){






  // Validate name
  if(empty(trim($_POST["fname"]))){
    $fname_err = "Please enter first name.";
}else{
    $ufname =$link->real_escape_string( $_POST['fname']);
}
if(empty(trim($_POST["lname"]))){
    $lname_err = "Please enter last name.";
}else{
    $ulname =$link->real_escape_string( $_POST['lname']);
}
if(empty(trim($_POST["phone"]))){
    $phone_err = "Please enter phone number.";
}else{
    $uphone =$link->real_escape_string( $_POST['phone']);
}
if(empty(trim($_POST["password"]))){
    $password_err = "Please enter password.";
}else{
    $upassword =$link->real_escape_string( $_POST['password']);
}

if(empty($fname_err) && empty($lname_err) && empty($password_err) && empty($phone_err)){

    $sqlpas= "SELECT * FROM users WHERE email= '$email'";
$resultpas = mysqli_query($link,$sqlpas);
if(mysqli_num_rows($resultpas) > 0){
 $rowpas = mysqli_fetch_assoc($resultpas);
 $rowpass = $rowpas['password'];
}

    if($rowpass == $upassword){
$sql = "UPDATE users SET fname ='$ufname', lname='$ulname', phone='$uphone' WHERE email='$email' AND password = '$upassword'";
  echo "UPDATE users SET fname ='$ufname', lname='$ulname', phone='$uphone' WHERE email='$email' AND password = '$upassword'";
                    if (mysqli_query($link, $sql)) {


                 $msg= " Your details has been successfully updated ";

                             }
    }else {
        $password_err = "Please enter a correct password.";
                           }
                          }
                        }







?>
