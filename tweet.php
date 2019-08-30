<?php
   class Tweet extends Base{
       function __construct($pdo){
          $this->pdo = $pdo;
       }

       public function tweets($user_id){
          // Your code here ...
          // Fetch tweets authored by user_id. Sorted by newest first.
          // (You will need to do a JOIN query on users and tweets tables)
          // Store the results in $tweets

          $stmt = $this->pdo->prepare("SELECT * FROM tweets, users WHERE (tweetBy = user_id AND user_id = :user_id) OR (tweetBy = user_id AND tweetBy IN(SELECT receiver FROM follow WHERE sender = :user_id)) ORDER BY tweetId DESC");
          $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
          $stmt->execute();
          $tweets = $stmt->fetchAll(PDO::FETCH_OBJ);

          foreach($tweets as $tweet){
              echo '<div class="all-tweet">

            <div class="t-show-wrap">  

             <div class="t-show-inner">

              <div class="t-show-popup">

                <div class="t-show-head">

                  <div class="t-show-img">

                    <img src="'. $tweet->profileImage .'"/>

                  </div>

                  <div class="t-s-head-content">

                    <div class="t-h-c-name">

                      <span><a href="profile.php?username='. $tweet->username .'">'. $tweet->fullname .'</a></span>

                      <span>@'. $tweet->username .'</span>

                      <span>'. $tweet->postedOn .'</span>

                    </div>

                    <div class="t-h-c-dis">

                      '. $tweet->status .'

                    </div>

                  </div>

                </div>

              </div>

              <div class="t-show-footer">

                <div class="t-s-f-right">

                  <ul> 

                    <li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>

                    <li><button><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></button></li>

                      <li>

                      <a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>

                    </li>

                  </ul>

                </div>

              </div>

            </div>

            </div>

          </div>';

      }

    }

    public function countTweets($user_id) {
      // Your code here ... 
      // echo count of number of tweets by user_id.
        
      $stmt = $this->pdo->prepare("SELECT COUNT(tweetId) AS totalTweets FROM tweets where tweetBy = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
      $count = $stmt->fetch(PDO::FETCH_OBJ);
      echo $count->totalTweets;
    }

    public function getUserTweets($usr_id){
      $stmt = $this->pdo->prepare("SELECT * FROM tweets, users where tweetBy = user_id AND user_id = :user_id");
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $stmt->execute();
       
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  }
?>
