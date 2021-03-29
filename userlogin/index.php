<?php

//import for php mail
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


error_reporting(0);
require_once '../admin/includes/access.inc.php';

if (!userIsLoggedIn()){ 
    include 'login.html.php'; 
    exit();
} 
customer();

if (!userHasRole('User'))
{
    $error='Only signed up users may access this page.';
    include '../admin/accessdenied.html.php'; 
    exit(); 
}



/*****************************************************/
//Add new Idea

if(isset($_GET['add']))
{
    $pageTitle = 'New Idea';
    $action = 'addform';
    $text='';
    $AuthorID='';
    $ID='';
    $button='Add Idea';
    
    include '../admin/includes/db.inc.php';
    
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row){
    $authors[]= array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}

//build list of departments    
     try
    {
        $result= $pdo->query('SELECT ID, Name FROM Department');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of department';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $departments[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => FALSE );
}

    
//build list of categories    
     try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => FALSE );
}

include 'form.html.php';
exit();


}



/*****************************************************/
//Insert idea

if(isset($_GET['addform']))
{
    include '../admin/includes/db.inc.php';
    
    if($_POST['Author']=='' || $_POST['text']=='' || $_POST['Email']=='')
    {
        $error='You must choose an author or enter text for this idea, Click back and try again';
        include 'error.html.php';
        exit();
    }

    /*****************************************************/
    //Insert documents

    // date time
    $date = new DateTime();
    $datetime = $date->format('-Y-m-d H:i:s');

    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];

    // destination of the file on the server
    $destination = '../documents/';

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    $filename =  str_replace('.'.$extension, '', $filename);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];

    //new file name with date
    $Document= $filename.$datetime.'.'.$extension;

    try
    {
    move_uploaded_file($file, $destination.$Document);
    
    require_once '../admin/includes/HTMLPurifier.standalone.php';
    $purifier = new HTMLPurifier();
    $clean=$purifier->purify($_POST['text']);
            
            
        $sql = 'INSERT INTO Idea SET
        IdeaText=:IdeaText,
        IdeaDate=CURDATE(),
        AuthorID=:AuthorID,
        Document=:Document';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':IdeaText', $clean);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->bindvalue(':Document', $Document);
        $s->execute();
    }
    
        catch (PDOException $e)
{
    $error = 'Error adding submitted idea';
    include 'error.html.php';
    exit();
}

$IdeaID = $pdo->lastInsertId();


/*****************************************************/
//Insert record into ideacategory table --category

if(isset($_POST['categories']))
{
    try
    {
        $sql = 'INSERT INTO IdeaCategory SET
        IdeaID=:IdeaID,
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':IdeaID', $IdeaID);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
catch (PDOException $e)
{
    $error = 'Error inserting idea into selected categories';
    include 'error.html.php';
    exit();
}
}

/*****************************************************/
//Insert record into ideadepartment table --department

if(isset($_POST['departments']))
{
    try
    {
        $sql = 'INSERT INTO IdeaDepartment SET
        IdeaID=:IdeaID,
        DepartmentID=:DepartmentID';
        $s =$pdo->prepare($sql);

        foreach ($_POST['departments'] as $DepartmentID)
        {
            $s->bindvalue(':IdeaID', $IdeaID);
            $s->bindvalue(':DepartmentID', $DepartmentID);
            $s->execute();
        }
    }
catch (PDOException $e)
{
    $error = 'Error inserting idea into selected departments';
    include 'error.html.php';
    exit();
}
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
        $mail->AddAddress($_POST['Email']);

        //Set the subject line
        $mail->Subject = "New Idea From ". ($_SESSION['Email']);

        //Replace the plain text body with one created manually
        $mail->Body    = "Approve or Dissaprove the idea. The idea of the user is: \n" . ($_POST['text']);


        //Send the message, check for errors
        if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
        } else {

        echo '<script language="javascript">';
        echo 'alert("The idea has been posted")';
        echo '</script>';

        if (isset($_POST['OK']))
        {
            header('Location: .');
            exit();
        }


        
        }

    

}

/*****************************************************/
//edit idea button been clicked

if(isset($_POST['action']) and $_POST['action']=='Edit')
{
    include '../admin/includes/db.inc.php';
try
{
    $sql = 'SELECT ID, IdeaText, AuthorID FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching idea details';
    include 'error.html.php';
    exit();
}
    
$row = $s->fetch();
    $pageTitle='Edit Idea';
    $action='editform';
    $text=$row['IdeaText'];
    $AuthorID=$row['AuthorID'];
    $ID=$row['ID'];
    $button='Update Idea';
    
    //build list of authors
    try
    {
        $result= $pdo->query('SELECT Author_ID, Name FROM Author');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of authors';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name'] );
}

/*****************************************************/   
//get list of categories containing this idea
    
try
{
    $sql = 'SELECT CategoryID FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $ID);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching lists of selected categories';
    include 'error.html.php';
    exit();
}
    
foreach ($s as $row)
{
    $selectedCategories[]=$row['CategoryID'];
}


//build list of categories  

    try
    {
        $result= $pdo->query('SELECT ID, Name FROM Category');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of categories';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => in_array($row['ID'], $selectedCategories));
}

/*****************************************************/   
//get list of departments containing this idea
    
try
{
    $sql = 'SELECT DepartmentID FROM IdeaDepartment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $ID);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching lists of selected Departments';
    include 'error.html.php';
    exit();
}
    
foreach ($s as $row)
{
    $selectedDepartments[]=$row['DepartmentID'];
}


//build list of Departments  

    try
    {
        $result= $pdo->query('SELECT ID, Name FROM Department');
    }
    
    catch (PDOException $e)
{
    $error = 'Error fetching list of Departments';
    include 'error.html.php';
    exit();
}
    
foreach ($result as $row)
{
    $departments[]=array('ID' => $row['ID'], 'Name'=>$row['Name'], 'selected' => in_array($row['ID'], $selectedDepartments));
}


//show the edit idea version of the form
include 'form.html.php';
exit();
}
    
/*****************************************************/
//update the edited idea

if(isset($_GET['editform']))
{
    include '../admin/includes/db.inc.php';
    
    if($_POST['Author'] == '')
    {
        $error='You must choose an author for this idea, Click back and try again';
        include 'error.html.php';
        exit();
    }
    
    try
    {
        $sql = 'UPDATE Idea SET
        IdeaText=:IdeaText,
        AuthorID=:AuthorID
        WHERE ID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->bindvalue(':IdeaText', $_POST['text']);
        $s->bindvalue(':AuthorID', $_POST['Author']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error updating submitted idea';
    include 'error.html.php';
    exit();
}
//****// Category
 try
    {
        $sql = 'DELETE FROM IdeaCategory WHERE IdeaID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error removing obsolete idea category entries';
    include 'error.html.php';
    exit();
}
if(isset($_POST['categories']))
{    
try
    {
        $sql = 'INSERT INTO IdeaCategory SET 
        IdeaID= :IdeaID, 
        CategoryID=:CategoryID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['categories'] as $CategoryID)
        {
            $s->bindvalue(':IdeaID', $_POST['ID']);
            $s->bindvalue(':CategoryID', $CategoryID);
            $s->execute();
        }
    }
    
    catch (PDOException $e)
{
    $error = 'Error inserting idea into selected categories';
    include 'error.html.php';
    exit();
}
}

//****/// Department
 try
    {
        $sql = 'DELETE FROM IdeaDepartment WHERE IdeaID=:ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_POST['ID']);
        $s->execute();
    }
    
    catch (PDOException $e)
{
    $error = 'Error removing obsolete idea Department entries';
    include 'error.html.php';
    exit();
}

if(isset($_POST['departments']))
{    
try
    {
        $sql = 'INSERT INTO IdeaDepartment SET 
        IdeaID= :IdeaID, 
        DepartmentID=:DepartmentID';
        $s =$pdo->prepare($sql);
        foreach ($_POST['departments'] as $DepartmentID)
        {
            $s->bindvalue(':IdeaID', $_POST['ID']);
            $s->bindvalue(':DepartmentID', $DepartmentID);
            $s->execute();
        }
    }
    
    catch (PDOException $e)
{
    $error = 'Error inserting idea into selected Department';
    include 'error.html.php';
    exit();
}
}
    
header('Location: .');
exit();
}


/*****************************************************/
//delete the idea

if(isset($_POST['action']) and $_POST['action']=='Delete')
{
    include '../admin/includes/db.inc.php';
try
{
    $sql = 'SELECT IdeaID FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea from categories';
    include 'error.html.php';
    exit();
}
    
//delete the idea
try
{
    $sql = 'SELECT ID, IdeaText FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error fetching idea';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    $IdeaText=$row['IdeaText'];
    $ID=$row['ID'];
    
include 'confirm_delete.html.php';
exit();
}
//delete the idea

if(isset($_POST['action']) and $_POST['action']=='Yes')
{
    include '../admin/includes/db.inc.php';

//delete the idea category
try
{
    $sql = 'DELETE FROM IdeaCategory WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing idea from categories';
    include 'error.html.php';
    exit();
}

//delete the idea department
try
{
    $sql = 'DELETE FROM IdeaDepartment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error removing idea from categories';
    include 'error.html.php';
    exit();
}
    
//delete the idea
try
{
    $sql = 'DELETE FROM Idea WHERE ID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea';
    include 'error.html.php';
    exit();
}

//delete the Comment
try
{
    $sql = 'DELETE FROM Comment WHERE IdeaID= :ID';
    $s =$pdo->prepare($sql);
    $s->bindvalue(':ID', $_POST['ID']);
    $s->execute();
}
catch (PDOException $e)
{
    $error = 'Error deleting idea';
    include 'error.html.php';
    exit();
}

header('Location: .');
exit();
}


/*****************************************************/


if(isset($_GET['action']) and $_GET['action']=='search')
{
    include '../admin/includes/db.inc.php';
    
$select = 'SELECT *, Author.Name FROM';
$from = ' Idea INNER JOIN Author ON Idea.AuthorID = Author.Author_ID';
$where = ' WHERE TRUE';
$placeholders = array();
    
if ($_GET['Author'] != '')
{
    $where .=" AND AuthorID = :AuthorID";
    $placeholders[':AuthorID']=$_GET['Author'];
}

if ($_GET['Category'] != '')
{
    $from .= ' INNER JOIN IdeaCategory ON ID= IdeaID';
    $where .= " AND CategoryID = :CategoryID";
    $placeholders[':CategoryID']=$_GET['Category'];
}
    
if ($_GET['text'] != '')
{
    $where .= " AND IdeaText LIKE :IdeaText";
    $placeholders[':IdeaText']= '%' . $_GET['text'] . '%';
}
    
try
{
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s->execute($placeholders);
}
catch (PDOException $e)
{
    $error = 'Error fetching ideas';
    include 'error.html.php';
    exit();
}
foreach ($s as $row)
{
    $ideas[]=array('ID' => $row['ID'], 'text'=>$row['IdeaText'], 'Image'=>$row['Image'], 'IdeaDate'=>$row['IdeaDate'], 'Name'=>$row['Name'], 'Vote'=>$row['Vote'], 'AuthorID' => $row['AuthorID']);
}

include 'ideas.html.php';
exit();
}

include '../admin/includes/db.inc.php';
try{
    $result= $pdo->query('SELECT Author_ID, Name FROM Author');
}
catch (PDOException $e)
{
    $error = 'Error fetching authors from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $authors[]=array('ID' => $row['Author_ID'], 'Name'=>$row['Name']);
   }

try{
    $result= $pdo->query('SELECT ID, Name FROM Category');
}
catch (PDOException $e)
{
    $error = 'Error fetching categories from the database';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
   {
       $categories[]=array('ID' => $row['ID'], 'Name'=>$row['Name']);
   }

include 'searchform.html.php';

//********************

//time stamp
    try
    {
        $sql='SELECT LoginTime FROM Author WHERE Author_ID = :ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':ID', $_SESSION['aid']);
        $s->execute();
    }
    
    catch (PDOException $e)
    {
    $error = 'Error fetching login time from authors';
    include 'error.html.php';
    exit();
    }
    
foreach ($s as $row){
    $logintime= $row['LoginTime'];
}

$timestamp = date('Y-m-d H:i:s');

if(! $logintime) {
    echo "<p>Welcome To Your First Login</p>";

    try
    {
        $sql='UPDATE Author SET LoginTime = :LoginTime WHERE Author_ID = :ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':LoginTime', $timestamp);
        $s->bindvalue(':ID', $_SESSION['aid']);
        $s->execute();
    }
    
    catch (PDOException $e)
    {
        $error = 'Error fetching login time from authors';
        include 'error.html.php';
        exit();
    }
    

} 
else {
    echo '<p>Last Login: ' .$logintime. '</p>';

    try
    {
        $sql='UPDATE Author SET LoginTime = :LoginTime WHERE Author_ID = :ID';
        $s =$pdo->prepare($sql);
        $s->bindvalue(':LoginTime', $timestamp);
        $s->bindvalue(':ID', $_SESSION['aid']);
        $s->execute();
    }
    
    catch (PDOException $e)
    {
        $error = 'Error fetching login time from authors';
        include 'error.html.php';
        exit();
    }
}


?>