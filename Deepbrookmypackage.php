<?php


session_start();

require'Deepbrookmypackage.html';
?>


include "../config/db.php";
include "../config/config.php";
include 'Deepbrookmypackage.html';

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



if(isset($_POST['switch'])){

    $profit = $_POST['profit'];




	 $sql = "UPDATE users SET activate = '0',pdate = '0',walletbalance= walletbalance + $profit  WHERE email='$email'";


  if(mysqli_query($link, $sql)){

$msg = "Package Ended with profit of $profit you can now switch or enjoy a new package !";

  }else{

      $msg = "Package cannot be ended/switched!";
  }
}


if(isset($_POST['activate'])){



    $usd = $_POST['usd'];
    $cdate = date('Y-m-d H:i:s');


    $sql22= "SELECT * FROM users WHERE email= '$email'";
    $result22 = mysqli_query($link,$sql22);
    if(mysqli_num_rows($result22) > 0){
     $row22 = mysqli_fetch_assoc($result22);
     $row22['walletbalance'];
     $row22['activate'];
     $from = $row22['froms'];
     $bonus = $row22['bonus'];
     $pname1 = $row22['pname'];


      $sql1 = "UPDATE users SET activate = '1',pdate='$cdate',usd='$usd',walletbalance= walletbalance + $bonus  WHERE email='$email'";







    if(isset($row22['activate']) &&  $row22['activate'] == '1'){

      $msg = "Package is already active!";

    }else{

  if(isset($row22['walletbalance']) && isset($row22['froms']) && $row22['walletbalance'] >= $from && $row22['walletbalance'] >= $usd && $usd >= $from){


    mysqli_query($link, $sql1);

    $msg = "Your package is successfully activated!";

    include_once "../PHPMailer/PHPMailer.php";
      require_once '../PHPMailer/Exception.php';

      $mail= new PHPMailer();
       $mail->setFrom($emaila);
     $mail->FromName = $name;
      $mail->addAddress($email, $username);
      $mail->Subject = "Package Activated";
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

  Your package of '.$pname1.'  has been activated successfully. Thank you for investing in us!

  </p>

  <div class="be_footer">
  <div style="border-bottom: 1px solid #ccc;"></div>


  <div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

  <p> Please do not reply to this email. Emails sent to this address will not be answered.
  Copyright ©2010 '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>';


      if($mail->send()){


      }

  }else{


      $msg = "Package cannot be activated, insufficient balance or amount less than package minimum value ! ";
  }
      }
    }

  }


if(isset($row['pdate']) &&  $row['pdate'] != '0' && isset($row['duration'])  && isset($row['increase'])  && isset($row['usd']) ){

    $endpackage = new DateTime($pdate);
    $endpackage->modify( '+ '.$duration. 'day');
$Date2 = $endpackage->format('Y-m-d');
$current=date("Y/m/d");

$diff = abs(strtotime($Date2) - strtotime($current));
$one = 1;

    $date3 = new DateTime($Date2);
     $date3->modify( '+'. $one.'day');
     $date4 = $date3->format('Y-m-d');

$days=floor($diff / (60*60*24));


$daily = $duration - $days;
$percentage = ($increase/100) * $daily * $usd;











$one = 1;
$f = date('Y-m-d', strtotime($Date2 . ' + '. $one.'day'));

if(isset($days) && $days == 0 || $Date2 == (date("Y/m/d"))  ){

 $pp =   $percentage;


$sql = "UPDATE users SET activate = '0',pdate = '0',walletbalance= walletbalance + $pp, profit = profit + $pp  WHERE email='$email'";


if(mysqli_query($link, $sql)){

$percentage = $pp = 0;

$Date2 = 0;
$current = 0;
$duration = 0;

$days = 'package completed &nbsp;&nbsp;<i style="color:green; font-size:20px;" class="fa  fa-check" ></i>';
$days = 0;
$Date2 = 0;
$current = 0;
$duration = 0;

}
}else{
$_SESSION['pprofit'] = $percentage;
}






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
    session_destroy($_SESSION['pprofit']);
    $profit = "";
  }

?>