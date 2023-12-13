<?php
// Include config file
include "config/db.php";
include "config/config.php";

$msg = "";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Define variables and initialize with empty values
$lname = $fname =$username = $email = $password = $cpassword = $phone = "";
$lname_err = $fname_err = $username_err = $email_err = $password_err = $cpassword_err = $phone_err =  "";



if(isset($_GET['refcode'])){

    $refcode = $_GET['refcode'];

}else {
    $refcode='';
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){


    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }


      // Validate email
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

	 // Validate name
	 if(empty(trim($_POST["fname"]))){
        $fname_err = "Please enter first name.";
    }else{
        $fname = trim($_POST["fname"]);
    }
	if(empty(trim($_POST["lname"]))){
        $lname_err = "Please enter last name.";
    }else{
        $lname = trim($_POST["lname"]);
    }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["cpassword"]))){
        $cpassword_err = "Please confirm password.";
    } else{
        $cpassword = trim($_POST["cpassword"]);
        if(empty($password_err) && ($password != $cpassword)){
            $cpassword_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($fname_err) && empty($lname_err) && empty($cpassword_err)){


         $phone= $_POST['phone'];

            $referred = $_POST['referred'];
            $bonus = $_POST['bonus'];
        $token ='kllcabcdg19etsfjhdshdsh35678gwyjerehuhb/>()[]{}|\dTSGSAWQUJHDCSMNBVCBNRTPZXMCBVN1234567890';
            $token = str_shuffle($token);
             $token= substr($token,0, 10);



             $refcode ='kllcabcdg19etsfjhdshdsh35678gwyjerehuhbdTSGSAWQUJHDCSMNBVCBNRTPZXMCBVN1234567890';
                $refcode = str_shuffle($refcode);
                 $refcode= substr($refcode,0, 10);
        // Prepare an insert statement
        $sql = "INSERT INTO users (fname, lname, username, email, password, token, refcode, referred, walletbalance, phone ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssssss", $param_fname, $param_lname, $param_username, $param_email, $param_password, $param_token, $param_refcode, $param_referred, $param_bonus, $param_phone );

            // Set parameters
			$param_fname = $fname;
			$param_lname = $lname;
            $param_username = $username;
            $param_email = $email;
            $param_password = $password;
             $param_token = $token;
            $param_refcode = $refcode;
            $param_referred = $referred;
            $param_bonus = $bonus;
            $param_phone  = $phone;


            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

require_once "PHPMailer/PHPMailer.php";
require_once 'PHPMailer/Exception.php';


//PHPMailer Object
$mail = new PHPMailer;

    //From email address and name
        $mail->setFrom($emaila);
   $mail->FromName = $name;


$mail->addAddress("$email"); //Recipient name is optional

//Address to which recipient will reply

//Send HTML or Plain Text email
$mail->isHTML(true);

$mail->Subject = "Welcome Message";
$mail->Body = '

               <div style="background: #f5f7f8;width: 100%;height: 100%; font-family: sans-serif; font-weight: 100;" class="be_container">

<div style="background:#fff;max-width: 600px;margin: 0px auto;padding: 30px;"class="be_inner_containr"> <div class="be_header">


<div class="be_logo" style="float: left;"> <img src="https://'.$bankurl.'/admin/c2wad/logo/'.$logo.'" alt="navbar brand"
					style="height:40px;width:100px; margin-top:15px;"> </div>

<div class="be_user" style="float: right"> <p>Dear: '.$username.'</p> </div>

<div style="clear: both;"></div>

<div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

<h1>Thank you for Registering on  '.$name.'</h1>

</div> </div>

<div class="be_body" style="padding: 20px;"> <p style="line-height: 25px; color:#000;">
Welcome to Cryptoelite.online, we are happy to have you as a new member. This is a platform that helps its users acquire various cryptocurrecy. We provide incredible investment plans that is budget friendly and suites you!</p>
</br><br/>
 Please click on the button below to verify your email address
  <center>
                                          <a href="http://cryptoelite.online/login.php?tkn='.$token.'" style="font-size:21px;line-height:22px;text-decoration:none;color:#ffffff;font-weight:bold;border-radius:2px;background-color:#62688F;padding:5px;" target="_blank">Verify Now</a>
                                    </center>

        </p>

<div class="be_footer">
<div style="border-bottom: 1px solid #ccc;"></div>


<div class="be_bluebar" style="background: #1976d2; padding: 20px; color: #fff;margin-top: 10px;">

<p> Please do not reply to this email. Emails sent to this address will not be answered.
Copyright ©2020 '.$name.'. </p> <div class="be_logo" style=" width:60px;height:40px;float: right;"> </div> </div> </div> </div></div>



';


if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    $msg =  "Please verify your email address to login.";
}
           echo "<script>
           window.location.href='login.php?success';
           </script>";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);

}

?>
