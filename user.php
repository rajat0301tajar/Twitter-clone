<?php
  class User extends Base{
     function __construct($pdo){
        $this->pdo = $pdo;
     }

     public function checkInput($var){
        $var = htmlspecialchars($var);
        $var = trim($var);
        $var = stripslashes($var);
        return $var;
     }

     public function login($email, $password){
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $hash = md5($password);
        $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();

        if($count > 0){
           $_SESSION['user_id'] = $user->user_id;
           header('Location: home.php');
        }else{
           return false;
        }
     }

     public function checkEmail($email){
        $stmt = $this->pdo->prepare("SELECT email FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
 
        $count = $stmt->rowCount();
        if($count > 0){
            return true;
        }else{
            return false; 
        }
     }
  
     public function checkUsername($username){
        $stmt = $this->pdo->prepare("SELECT username FROM users WHERE username = :username");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->rowCount();
        if($count > 0){
            return true;
        }else{
            return false;
        }
     }

     public function userData($user_id){
       $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :user_id"); 
       $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
       $stmt->execute();
       return $stmt->fetch(PDO::FETCH_OBJ);
     }

     public function logout(){
         session_destroy();
         header('Location: '. BASE_URL . 'index.php');
     }

     public function loggedIn(){
         if(isset($_SESSION['user_id'])){
            return true;
         }
         return false;
     }

     public function userIdByUsername($username){
         $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE username = :username");
         $stmt->bindParam(":username", $username, PDO::PARAM_STR);
         $stmt->execute();
         $user = $stmt->fetch(PDO::FETCH_OBJ);
         return $user->user_id;
     }

     public function searchByUsername($username){
         return BASE_URL.'profile.php?username='.$username;
     }
  }
?>
