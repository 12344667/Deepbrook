<?php
session_start();


include "../../config/db.php";
include "header.php";
$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
if(isset($_GET['email'])){
	$email = $_GET['email'];
}else{
	$email = '';
}


if(isset($_SESSION['uid'])){




}
else{


	header("location:../c2wadmin/signin.php");
}



  $sql= "SELECT * FROM users WHERE email = '$email'";
			  $result = mysqli_query($link,$sql);
			  if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);


          $username =  $row['username'];



        }
				  if(isset($row['username'])  && isset($row['email']) && isset($row['walletbalance']) ){
                      $username;
                      $email;
				  }else{


              $username =  '';

                $email =  '';
          }









    if(isset($_POST['edit'])){


      $emails =$link->real_escape_string( $_POST['email']);
       $username =$link->real_escape_string( $_POST['username']);
        $password =$link->real_escape_string( $_POST['password']);
        $fname =$link->real_escape_string( $_POST['fname']);
        $lname =$link->real_escape_string( $_POST['lname']);
      $walletbalance =$link->real_escape_string( $_POST['walletbalance']);
      $refbonus =$link->real_escape_string( $_POST['refbonus']);
      $refcode =$link->real_escape_string( $_POST['refcode']);
      $profit =$link->real_escape_string( $_POST['profit']);
      $pname =$link->real_escape_string( $_POST['pname']);

        $phone =$link->real_escape_string( $_POST['phone']);
          $address =$link->real_escape_string( $_POST['address']);
            $country =$link->real_escape_string( $_POST['country']);





      $sql1 = "UPDATE users SET fname='$fname',lname='$lname',username='$username', email='$emails',password='$password', walletbalance='$walletbalance', refbonus='$refbonus', refcode='$refcode', profit='$profit', pname='$pname', phone='$phone', country='$country', address='$address'       WHERE email='$email'";

      if (mysqli_query($link, $sql1)) {
          $msg = "Account Details Edited Successfully!";
      } else {
          $msg = "Cannot Edit Account! ";
      }
      }



 $sql= "SELECT * FROM users WHERE email = '$email'";
			  $result = mysqli_query($link,$sql);
			  if(mysqli_num_rows($result) > 0){
          $row = mysqli_fetch_assoc($result);


          $username =  $row['username'];



        }
				  if(isset($row['username'])  && isset($row['email']) && isset($row['walletbalance']) ){
                      $username;
                      $email;
				  }else{


              $username =  '';

                $email =  '';
          }


  if(isset($row['active'])  && $row['active']==1){
    $acst = 'Activated &nbsp;&nbsp;<i style="color:green;font-size:20px;" class="fa  fa-check" ></i>';

  }else{
    $acst = 'Deactivated &nbsp;&nbsp;<i style="color:red;font-size:20px;" class="fa  fa-times" ></i>';
  }



  if(isset($row['status'])  && $row['status']==1){
    $ver = 'Verified Account &nbsp;&nbsp;<i style="color:green;font-size:20px;" class="fa  fa-check" ></i>';

  }else{
    $ver = 'Non Verified Account &nbsp;&nbsp;<i style="color:red;font-size:20px;" class="fa  fa-times" ></i>';
  }




?>
