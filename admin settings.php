<?php
session_start();


include "../../config/db.php";
include "../../config/config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_SESSION['uid'])){




}
else{


	header("location:../c2wadmin/signin.php");
}


if(isset($_POST['set'])){

  $ids = $_POST['id'];
 $sname = $_POST['sname'];
  $wl = $_POST['wl'];
    $rb = $_POST['rb'];
   $currency = $_POST['currency'];
   $branch = $_POST['branch'];
   $bname = $_POST['bname'];
   $baddress = $_POST['baddress'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $title = $_POST['title'];
   $logo = $_FILES['logo']['name'];
   $target = "logo/".basename($logo);
   $scy = $_POST['cy'];

   $sql = "SELECT email FROM settings WHERE id = '$ids'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
    $msg = 'Settings already added.';

}else{

  if($logo!=""){
   $sql = "INSERT INTO settings (sname, wl, rb, currency, branch, bname, baddress, email, phone, title, logo, cy) VALUES ('$sname','$wl','$rb','$currency','$branch','$bname','$baddress','$email','$phone','$title','$logo','$scy')";
   }else{
   $sql = "INSERT INTO settings (sname, wl, rb, currency, branch, bname, baddress, email, phone, title, cy) VALUES ('$sname','$wl','$rb','$currency','$branch','$bname','$baddress','$email','$phone','$title','$scy')";
   }
   if(mysqli_query($link, $sql)){

  if($logo!=""){
    move_uploaded_file($_FILES['logo']['tmp_name'], $target);
			}

			$msg = "Settings Added!";
		}else{

			$msg = "Settings Not Added!";
		}
}

}




if(isset($_POST['uset'])){

  $ids = $_POST['id'];
  $sname = $_POST['sname'];
    $wl = $_POST['wl'];
    $rb = $_POST['rb'];
    $currency = $_POST['currency'];
    $branch = $_POST['branch'];
    $bname = $_POST['bname'];
    $baddress = $_POST['baddress'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $title = $_POST['title'];
    $logo = $_FILES['logo']['name'];
    $target = "logo/".basename($logo);
    $scy = $_POST['cy'];

 if($logo!=""){
    $sql = "UPDATE settings SET  sname='$sname', wl='$wl', rb='$rb', currency='$currency', branch='$branch', bname='$bname', baddress='$baddress', email='$email', phone='$phone', title='$title', logo='$logo', cy='$scy' WHERE id = '$ids' ";
    }else{
    $sql = "UPDATE settings SET  sname='$sname', wl='$wl', rb='$rb', currency='$currency', branch='$branch', bname='$bname', baddress='$baddress', email='$email', phone='$phone', title='$title', cy='$scy' WHERE id = '$ids' ";
    }

    if(mysqli_query($link, $sql)){
 if($logo!=""){
     move_uploaded_file($_FILES['logo']['tmp_name'], $target);
       }
       $msg = "Settings Updated!";
     }else{

       $msg = "Settings Not Updated!";
     }
 }



include "header.php";
include "admin settings.html";

    ?>
