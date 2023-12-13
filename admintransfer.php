<?php
session_start();
include "../../config/db.php";
$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
$email=$_GET['email'];
$username=$_GET['username'];

if(isset($_SESSION['email'])){



}
else{


  header("location:../form/signin.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST"){

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $msg=  "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg=  "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $msg=  "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $msg=  "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    $msg=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   $msg=  "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  $email =$link->real_escape_string($_POST['email']);
  $status =$link->real_escape_string($_POST['status']);
  $tnx = uniqid('tnx');
   $fileToUpload = $_FILES["fileToUpload"]["name"];

   $sql = "INSERT INTO btc (image,email,status,tnxid) VALUES ('$fileToUpload','$email','$status','$tnx')";



	  mysqli_query($link, $sql) or die(mysqli_error($link));

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg= "Your proof of payment  ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded you will be credited once order is confirmed.";
    } else {
        $msg= "Sorry, there was an error uploading your file.";
    }
}

}


include "header.php";
include "admintransfer.html";
?>
