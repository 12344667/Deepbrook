<?php


session_start();



include "userbnb.html";
include "../config/db.php";
include "../config/config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



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
$refcode = $row1['refcode'];
$referred = $row1['referred'];
$username = $row1['username'];
}

$sql211= "SELECT SUM(moni) as total_value FROM wbtc WHERE email= '$email' and status= 'completed'";
$result211 = mysqli_query($link,$sql211);
$row11 = mysqli_fetch_assoc($result211);
if($row11['total_value'] != ""){
$wbtc1 = $row11['total_value'];
}else{
$wbtc1 = 0;
}

if(isset($_POST['submit'])){




    $usd =$link->real_escape_string( $_POST['usd']);
    $btctnx =$link->real_escape_string($_POST['btctnx']);
    $urefcode =$link->real_escape_string($_POST['refcode']);
    $ureferred =$link->real_escape_string($_POST['referred']);

    $tnx = uniqid('tnx');


    if($usd == "" ||  $btctnx == "" ){
                $msg = "No Field should be left empty!";

        }else{


    $sql = "INSERT INTO btc (usd,btctnx,email,status,tnxid,refcode,referred)
    VALUES ('$usd','$btctnx','$email','pending','$tnx','$urefcode','$ureferred')";

    if (mysqli_query($link, $sql)) {

      include_once "../PHPMailer/PHPMailer.php";
      require_once '../PHPMailer/Exception.php';

      $mail= new PHPMailer();
      $mail->setFrom($emaila);
       $mail->FromName = $name;
      $mail->addAddress($email);
      $mail->Subject = "Deposit Alert!";
      $mail->isHTML(true);
      $mail->Body = '
    <div style="background: #f5f7f8;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container">

    <div style="background:#fff;max-width: 600px;margin: 0px auto;padding: 30px;"class="be_inner_containr"> <div class="be_header">

    <div class="be_logo" style="float: left;"> <img src="https://'.$bankurl.'/admin/c2wad/logo/'.$logo.'"> </div>

    <div class="be_user" style="float: right"> <p>Dear: '.$username.'</p> </div>

    <div style="clear: both;"></div>

    <div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

    <h1>Thank you for investing on '.$name.'</h1>

    </div> </div>

    <div class="be_body" style="padding: 20px;"> <p style="line-height: 25px; color:#000;">

    Your deposit of '.$usd.' USD worth of '.$btc.'  BTC is currently under review, your transaction ID is '.$tnx.' , your balance will be credited once your deposit is confirmed.


    </p>

    <div class="be_footer">
    <div style="border-bottom: 1px solid #ccc;"></div>


    <div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

    <p> Please do not reply to this email. Emails sent to this address will not be answered.
    Copyright ©2010 '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>' ;



      if($mail->send()){

        $msg= " Your deposit of $usd USD worth of $btc  BTC is currently under reviews, your transaction ID is $tnx , your balance will be credited once your deposit is confirmed. ";
      }





    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
    }

    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

?>
