<?php 
define('server','mysql:host=localhost;dbname=vision');
define('user','root');
define('password','');
try{
    $connection = new PDO(server,user,password);
}
catch
    (PDOException $e)
{
    echo $e->getMessage();
}
?>