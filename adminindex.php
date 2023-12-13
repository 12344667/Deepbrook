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


include "header.php";

include "investors_query.php";

?>
