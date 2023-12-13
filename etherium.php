
<?php

session_start();


include "../../config/db.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;

$username=$_GET['username'];
$email=$_GET['email'];


if(isset($_POST['submit'])){




$eth =$link->real_escape_string( $_POST['eth']);
$usd =$link->real_escape_string( $_POST['usd']);
$btctnx =$link->real_escape_string($_POST['btctnx']);
$email =$link->real_escape_string($_POST['email']);
$status =$link->real_escape_string($_POST['status']);

$tnx = uniqid('tnx');


if($eth == "" || $usd == "" ||  $btctnx == "" ){
			$msg = "No Field should be left empty!";

	}else{


$sql = "INSERT INTO btc (eth,usd,btctnx,email,status,tnxid)
VALUES ('$eth','$usd','$btctnx','$email','$status','$tnx')";

if (mysqli_query($link, $sql)) {

  include_once "PHPMailer/PHPMailer.php";

  $mail= new PHPMailer();
  $mail->setFrom('info@killocoin.com');
  $mail->addAddress($email, $username);
  $mail->Subject = "email verification";
  $mail->isHTML(true);
  $mail->Body = "

  <div style='background-color:#fff; color:black;'>
  <h2>Thank you for investing on coin2wealth</h2>
  </br>
<p>Your order of $usd USD worth of $eth  ETH has been sent, your transaction ID is $tnx , you  will be credited once your order is confirmed</p>
</div>";
  if($mail->send()){

    $msg= " Your order of $usd USD worth of $eth  ETH has been sent, your transaction ID is $tnx , you  will be credited once your order is confirmed ";
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
include "header.php";
include "etherium.html";

    ?>
