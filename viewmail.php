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

// delete investor
if(isset($_POST['delete'])){

	$msgid = $_POST['msgid'];

$sql = "DELETE FROM message WHERE msgid='$msgid'";

if (mysqli_query($link, $sql)) {
    $msg = "Message deleted successfully!";
} else {
    $msg = "Message not deleted! ";
}
}
// verify investor

if(isset($_POST['read'])){

	$msgid = $_POST['msgid'];

$sql = "UPDATE messageadmin SET status = '1'  WHERE msgid='$msgid'";

if (mysqli_query($link, $sql)) {
    $msg = "Message marked as read!";
} else {
    $msg = "Message not marked  ";
}
}


include 'header.php';


?>
