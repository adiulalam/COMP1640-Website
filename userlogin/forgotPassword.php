<!DOCTYPE html>
<html lang="en">
<head>
<!--NEW CODE-->
<ul>
  <li><a href="../../#home">Home</a></li>
  <li><a href="../../user/aboutus/">About Us</a></li>
  <li style="float:right"><a href="../../user/adminmail/">Contact Us</a></li>
  <li><a href="../../reg">Register<br></a><li>
  <li><a href="../../userlogin">Login<br></a><li>
</ul>
<style> 
body {
  font-family: Arial, Helvetica, sans-serif;
  font-color: black;
}
   /* styling for navigation bar */
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}
li {
  float: left;
  border-right:2px solid #fafcff;
}
li:last-child {
  border-right: none;
}
li a {
  display: block;
  color: white;
  text-align: center;
  padding: 23px 36px;
  text-decoration: none;
}
li a:hover:not(.active) {
  background-color: #5983ff;
}
.active {
  background-color: #a1c0ff;
}

#home {
  left: 0px;
  width: 46px;
  background: url('img_navsprites.gif') 0 0;
}
/*footer styling*/
footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #e3ecff;
   color: #8d9ab8;
   text-align: center;
}

/*p {
  text-align: center;
  margin: 150px;
}*/

/* styling for table */
table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {background-color: #f2f2f2;}

/* styling for form */
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
 background-color: #5983ff;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
  font-size: 20px;
}
input[type=submit]:hover {
  opacity:15;
}


div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}

</style>

	<meta charset="UTF-8">
	<title>Forgot Password</title>
    <h1>Forgotten Password</h1>
</head>
<p> To recover your password, please enter the email address associated with your account:</p>
	<body>
		<form method="post">
             
			<input type="text" name="Email">
			<input type="submit" name="submit">
		</form>
       <!-- <p><a href="../">Return to CMS home</a></p> -->
       <footer>Created by greforum &copy; Copyright 2020</footer> 
	</body>
</html>

<?php
    //import for php mail
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

if(isset($_POST['submit'])) 
{

include '../admin/includes/db.inc.php';
$Email=$_POST['Email'];
    try
  {
    $sql = 'SELECT Password FROM Author
        WHERE Email = :Email';
    $s = $pdo->prepare($sql);
    $s->bindValue(':Email', $Email);
    $s->execute();
  }
  catch (PDOException $e)
  {
    $error = 'Error searching for Email.';
    include 'error.html.php';
    exit();
  }
  $row = $s->fetch();
  $Password = md5($row['Password']);
    
  $Pass = md5(md5($row['Password']).'ijdb');
    
    try
    {
        $sql = 'UPDATE Author SET
        Password=:Password
        WHERE Email=:Email';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':Email', $Email);
        $s->bindvalue(':Password', $Pass);
        $s->execute();
    }
    catch (PDOException $e)
    {  
        $error = 'Error updating password';
        include 'error.html.php';
        exit();
    }


        //Send Mail Function

    
    require '../phpmailer/PHPMailer.php';
    require '../phpmailer/Exception.php';
    require '../phpmailer/SMTP.php';


        date_default_timezone_set('Etc/UTC');


        //Create a new PHPMailer instance
        $mail = new PHPMailer();
        //Tell PHPMailer to use SMTP
        $mail->IsSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug  = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host       = 'smtp.gmail.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port       = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth   = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username   = "greforum3@gmail.com";
        //Password to use for SMTP authentication
        $mail->Password   = "P@ssword0";
        //Set who the message is to be sent from
        $mail->SetFrom('greforum3@gmail.com', 'Greenwich Forum');
        //Set an alternative reply-to address
        $mail->AddReplyTo('greforum3@gmail.com','Greenwich Forum');

        //Set who the message is to be sent to
        $mail->AddAddress($Email);

        //Set the subject line
        $mail->Subject = 'Password Reset';

        //Replace the plain text body with one created manually
        $mail->Body    = 'Your password is '.$Password;


        //Send the message, check for errors
        if(!$mail->Send()) {
            //Mailer Error: 
        echo "" . $mail->ErrorInfo;
        } else {
        echo "Email sent!";
        }

 }


