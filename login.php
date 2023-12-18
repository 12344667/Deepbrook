<?php
session_start();

include "config/db.php";
include "config/config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;

$email_err = $password_err = "";
$email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["email"])) {
        $email_err = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        }
    }

    if (empty($_POST["password"])) {
        $password_err = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
        // check if name only contains letters and whitespace
    }

    $email = $link->real_escape_string($_POST['email']);
    $password = $link->real_escape_string($_POST['password']);
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($email == "" || $password == "") {
        $msg = "Email or Password fields cannot be empty!";
    } else {
        $sql = $link->query("SELECT id,username,email, password, 2fa FROM users WHERE email='$email' AND password= '$password'");
        if ($sql->num_rows > 0) {
            $data = $sql->fetch_array();

            if ($data['2fa'] == 1) {
                // ... (your existing session and variable assignments)

                header("location:userdashboard.html"); // Redirect to user dashboard
            } else {
                if ($sql1 = "SELECT * FROM users WHERE email='$email'  AND password='$password'") {

                    $result1 = $link->query($sql1);
                    if (mysqli_num_rows($result1) > 0) {
                        $row = mysqli_fetch_array($result1);

                        $_SESSION['email'] = $_POST['email'];
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['refcode'] = $row['refcode'];
                        $_SESSION['referred'] = $row['referred'];
                        $_SESSION['uid'] = $row['id'];
                        $_SESSION['profit'] = $row['profit'];
                        $_SESSION['refbonus'] = $row['refbonus'];
                        $_SESSION['walletbalance'] = $row['walletbalance'];
                        $_SESSION['session'] = $row['session'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['verify'] = $row['verify'];
                        $_SESSION['package'] = $row['package'];

                        $_SESSION['pm'] = $row['pm'];
                        $_SESSION['eth'] = $row['eth'];
                        $_SESSION['btc'] = $row['btc'];

                        $_SESSION['2fa'] = $row['2fa'];
                        $username = $_SESSION['username'];
                        $emails = $_SESSION['email'];
                        $refcode = $_SESSION['refcode'];
                        $phone = $_SESSION['phone']  = $row['phone'];
                        $country = $_SESSION['country'] =  $row['country'];
                        $address = $_SESSION['address'] = $row['address'];

                        $date = date("Y/m/d");
                        header("location:user/");

                        //send email
                        require_once "PHPMailer/PHPMailer.php";
                        require_once 'PHPMailer/Exception.php';

                        //PHPMailer Object
                        $mail = new PHPMailer;

                        //From email address and name
                        $mail->setFrom($emaila);
                        $mail->FromName = $name;

                        //To address and name
                        $mail->addAddress($email, $fname);
                        $mail->addAddress("$email"); //Recipient name is optional

                        //Address to which recipient will reply

                        //Send HTML or Plain Text email
                        $mail->isHTML(true);

                        $mail->Subject = "Account Details";

                        // Include the IP address and login timestamp in the success message
                        $loginMessage = "Your account was logged in from " . "(IP: $ip) on " . date("F j, Y, g:i a") . ".";
                        $mail->Body = "
                        <div style='background: #f5f7f8;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;' class='be_container'>
                            <div style='background:#fff;max-width: 600px;margin: 0px auto;padding: 30px;' class='be_inner_containr'> 
                                <div class='be_header'>
                                    <div class='be_logo' style='float: left;'> 
                                        <img src='https://$bankurl/admin/c2wad/logo/$logo'> 
                                    </div>
                                    <div class='be_user' style='float: right'> 
                                        <p>Dear: $username</p> 
                                    </div>
                                    <div style='clear: both;'></div>
                                    <div class='be_bluebar' style='background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;'>
                                        <h1>Thank you for choosing $name</h1>
                                    </div> 
                                </div>
                                <div class='be_body' style='padding: 20px;'> 
                                    <p style='line-height: 25px; color:#000;'>
                                        $loginMessage
                                    </p>
                                </div>
                                <div class='be_footer'>
                                    <div style='border-bottom: 1px solid #ccc;'></div>
                                    <div class='be_bluebar' style='background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;'>
                                        <p> Please do not reply to this email. Emails sent to this address will not be answered. Copyright ©2010 $name. </p> 
                                        <div class='be_logo' style=' width:60px;height:40px;float: right;'> </div> 
                                    </div> 
                                </div> 
                            </div>
                        </div>";

                        if ($mail->send()) {
                            $msg = "Message has been sent successfully!";
                        } else {
                            $msg = "Something went wrong. Please try again later!";
                        }
                    } else {
                        $msg = "Cannot Send!";
                    }
                }
            }
        } else {
            $msg = "Email or Password incorrect!";
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
