<?php
try
{
    $pdo= new PDO('mysql:host=sql100.epizy.com;dbname=epiz_27789899_cw', 'epiz_27789899', '7lpVK8kGkxOi');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('SET NAMES "utf8"');
}
catch(PDOException $e)
{
    $error= 'Unable to connect to database server:' . $e->getMessage();
    //$error= 'Unable to connect to database server:';
    include 'error.html.php';
    exit();
}
?>