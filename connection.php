<!-- connection.php -->
<?php
   
   $dsn = 'mysql:host=localhost; dbname=twitter'; // database name
   $user = 'root';
   $pass = '';

   try{
     $pdo = new PDO($dsn, $user, $pass);
   }catch(PDOException $e){
     echo 'Connection error! '. $e->getMessage();
   }
?>
