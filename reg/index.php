
<?php
    //import for php mail
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    include 'form.html.php'; 

    if (isset($_POST['submit'])) {
        $Name = $_POST['Name'];
        $secretKey = "6LeE-OEUAAAAAAr3WTE8jt9EcyPU1MVOAwAh7UZ3";
        $responseKey = $_POST['g-recaptcha-response'];
        $userIP = $_SERVER['REMOTE_ADDR'];

        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
        $response = file_get_contents($url);
        $response = json_decode($response);
        if ($response->success)
            echo "Verification success.";
                if ($response->success)
        {
            include  '../admin/includes/db.inc.php';

            try
            {
                $sql = 'INSERT INTO Author SET Name = :Name, Email = :Email, Password= :Password';
                $s = $pdo->prepare($sql);
                $s->bindvalue(':Name', $_POST['Name']);
                $s->bindvalue(':Email', $_POST['Email']);
                $s->bindvalue(':Password', md5($_POST['Password'].'ijdb'));
                $s->execute();
            }
            catch (PDOException $e)
            {
                $error = 'Error adding submitted Author.';
                include 'error.html.php';
                exit();
            }

            $AuthorID = $pdo->lastInsertId();
                try {
                    $sql = 'INSERT INTO AuthorRole SET AuthorID= :AuthorID, RoleID= :RoleID'; 
                    $s = $pdo->prepare($sql); 
                    $s->bindValue(':AuthorID', $AuthorID); 
                    $s->bindValue(':RoleID', 'User'); 
                    $s->execute(); 
                } 
            catch (PDOException $e)
            {
                $error = 'Error assigning selected role to author.'; 
                include 'error.html.php'; 
                exit(); 
            }

        include 'welcome.html.php';
        }

        else
            echo "Verification failed!";
        
        $Email=$_POST['Email'];


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
        $mail->AddAddress($_POST['Email'], $_POST['Name']);

        //Set the subject line
        $mail->Subject = 'Register Successful';

        //Replace the plain text body with one created manually
        $mail->Body    = "Your account has been registered. Thank you for registering";


        //Send the message, check for errors
        if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
        echo "Message sent!";
        }

    }
?>