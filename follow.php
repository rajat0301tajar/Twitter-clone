<?php
   class Follow extends Base{
      function __construct($pdo){
         $this->pdo = $pdo;
      }

      public function checkFollow($user_id, $profileId){
          $stmt = $this->pdo->prepare("SELECT * FROM follow WHERE sender = :user_id AND receiver = :profileId");
          $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
          $stmt->bindParam(":profileId", $profileId, PDO::PARAM_INT);
          $stmt->execute();
          $count = $stmt->rowCount();
          if($count > 0){
             return true;
          }else{
             return false;
          }
      } 
  
      public function displayBtn($user_id, $profileId){
         if($user_id == $profileId){
             echo "";
         }elseif($this->checkFollow($user_id,$profileId) === true){
             // unfollow
             echo '<span>You are following this user. </span>';
             echo '<input type="submit" style="color": #FFFFFF; font-weight: bold; background-color: #d10000 name="unfollow" value="Unfollow"/>';
         }
         else{
             // follow
             echo '<input type="submit" style="color: #FFFFFF; font-weight: bold; background-color: #006eb7" name="follow" value="Follow"/>';
         }
      }

      public function follow($user_id, $profileId){
         $this->create('follow', array('sender' => $user_id, 'receiver' => $profileId));
         $this->addFollowCount($user_id, $profileId);
      }

      public function addFollowCount($user_id , $profileId){
         $stmt = $this->pdo->prepare("UPDATE users SET following = following + 1 WHERE user_id = :user_id; UPDATE users SET followers = followers + 1 WHERE user_id = :profileId;");
         $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
         $stmt->bindParam(":profileId", $profileId, PDO::PARAM_INT);
         $stmt->execute();
      }

      public function unfollow($user_id, $profileId){
         $this->delete('follow', array('sender' => $user_id, 'receiver' => $profileId));
         $this->removeFollowCount($user_id, $profileId);
      }

      public function removeFollowCount($user_id, $profileId){
         $stmt = $this->pdo->prepare("UPDATE users SET following = following - 1 WHERE user_id = :user_id; UPDATE users SET followers = followers - 1 WHERE user_id = :profileId;");
         $stmt->bindParam(":user_id",$user_id, PDO::PARAM_INT);
         $stmt->bindParam(":profileId", $profileId, PDO::PARAM_INT);
         $stmt->execute();
      }
}
        
?>
