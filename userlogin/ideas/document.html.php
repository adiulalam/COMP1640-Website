<?php

error_reporting(0);
require_once '../../admin/includes/access.inc.php';



if (!userIsLoggedIn()){ 
    include '../login.html.php'; 
    exit();
} 
customer();

if (!userHasRole('User'))
{
    $error='Only signed up users may access this page.';
    include '../../admin/accessdenied.html.php'; 
    exit(); 
}

if(isset($_POST['action']) and $_POST['action']=='Download')
    {

        include '../../admin/includes/db.inc.php';

        try{
            $sql = 'SELECT Document FROM Idea Where ID = :ID';
            $s =$pdo->prepare($sql);
            $s->bindvalue(':ID', $_POST['ID']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $error = 'Error fetching authors from the database';
            include 'error.html.php';
            exit();
        }


        foreach ($s as $row)
        {
            $Document= $row['Document'];
        }

        $filepath = '../../documents/' . $Document;

        if ($Document == ''){
            echo '<script language="javascript">';
            echo 'alert("There is no document"); history.go(-1);';
            echo '</script>';
        }
        else {
            
                if (file_exists($filepath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . basename($filepath));
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize('../../documents/' . $Document));
                    readfile('../../documents/' . $Document);

                    header('Location: .');
                    exit;
                    }

                    else {
                            echo '<script language="javascript">';
                            echo 'alert("No file exists"); history.go(-1);';
                            echo '</script>';


                    }


        }

        



    }

?>