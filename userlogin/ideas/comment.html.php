<?php
    ////import for php mail
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

include '../../admin/includes/db.inc.php';


session_start(); 
$AuthorID= $_SESSION['aid'];

$ID = $_POST['ID'];

    try
    {

    $sql = 'SELECT *, Author.Name, Idea.IdeaText FROM Comment INNER JOIN Author ON Comment.AuthorID = Author.Author_ID INNER JOIN Idea ON Comment.IdeaID = Idea.ID WHERE Idea.ID = :ID;';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
    }

        catch (PDOException $e)
    {
        $error = 'Error getting Comment';
        include 'error.html.php';
        exit();
    }


    foreach ($s as $row)
    {

    $comments[]=array('ID' => $row['ID'], 'Comment'=>$row['Comment'], 'Name'=>$row['Name']);
    
    }

            ////Send email notification to original author

    include '../../admin/includes/db.inc.php';

    try
    {

    $sql = 'SELECT Author_ID, Email FROM Author WHERE Author_ID = :ID;';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['AuthorID']);
    $s->execute();
    }

        catch (PDOException $e)
    {
        $error = 'Error getting  Author';
        include 'error.html.php';
        exit();
    }

        foreach ($s as $row)
    {

    $Email = $row['Email'];
    
    }



/////////****//////
    if (isset($_POST['Comment'])) {

    try
    {

    $sql = 'INSERT INTO Comment SET Comment = :Comment, IdeaID= :IdeaID, AuthorID= :AuthorID;';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':Comment', $_POST['Comment']);
    $s->bindvalue(':IdeaID', $_POST['ID']);
    $s->bindvalue(':AuthorID', $AuthorID);
    $s->execute();
    }

        catch (PDOException $e)
    {
        $error = 'Error inserting Comment';
        include 'error.html.php';
        exit();
    }



            //Send Mail Function

    
    require '../../phpmailer/PHPMailer.php';
    require '../../phpmailer/Exception.php';
    require '../../phpmailer/SMTP.php';


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
        $mail->AddAddress ($_POST['Email']);

        //Set the subject line
        $mail->Subject = 'New Comment On Your Post';

        //Replace the plain text body with one created manually
        $mail->Body    = "The New Comment is: \n".$_POST['Comment'];


        //Send the message, check for errors
        if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        } 
        else {
        echo "Message sent!";
        
        }



header('Location: .');
exit();

}

/////////****//////


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comments</title>
</head>
<body>

<?php if (isset($comments)): ?>
        <table border="1px">
            <tr><th>Comments</th><th>Comment From</th></tr>
            <?php foreach ($comments as $Comment): ?>
            <tr>
            <td><center><?php echo($Comment['Comment']);?></center></td>
            <td><center><?php echo($Comment['Name']);?></center></td>
            </tr>
            <?php endforeach;?>
        </table>
<?php endif; ?>  

    <form method="post" action="?">
    <br>
    <label for="text">Type your Comment here:</label><br/>
    <textarea id="Comment" name="Comment" rows="10" cols="40"></textarea>


    <input type="hidden" name="ID" value="<?php echo($ID); ?>">
    <input type="hidden" name="Email" value="<?php echo($Email); ?>">
    <input type="submit" name="submit" value="Send" />
    </form>
    
<p><a href="../../">Return to CMS home</a></p>
    


</body>
</html>


