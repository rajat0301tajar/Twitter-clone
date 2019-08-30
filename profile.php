
<!-- profile.php -->
<?php  
    if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
        include 'core/init.php';
        $username = $getFromU->checkInput($_GET['username']);
        $profileId = $getFromU->userIdByUsername($username);
        $profileData = $getFromU->userData($profileId);
        $tweets = $getFromT->getUserTweets($profileId);
        $user_id = $_SESSION['user_id'];
        $user = $getFromU->userData($user_id);
 
        if(!$profileData || ($getFromU->loggedIn() === false)) {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }
    if(isset($_POST['follow'])){
        $getFromF->follow($user_id, $profileId);
        header("Refresh:0");
    }
    if(isset($_POST['unfollow'])){
        $getFromF->unfollow($user_id, $profileId);
        header("Refresh:0");
    }
    if(isset($_POST['search'])){
        $searchUserURL = $getFromU->searchByUsername($_POST['searchUsername']);
        header('Location: '. $searchUserURL);
    }

   
?>
<!doctype html>
<html>
	<head>
		<title>Twitter Clone</title>
		<meta charset="UTF-8" />
 		<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
   			<link rel="stylesheet" href="./assets/css/font/css/font-awesome.css"/>
		<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>

    </head>

<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li>
					<form method="post">
					<input type="text" id="searchText" placeholder="Search" name="searchUsername" class="search"/>
					<i class="fa fa-search" aria-hidden="true"><button type="submit" name="search" style="display: none"></button></i>
					</form>
				</li>

				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileImage; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="profile.php?username=<?php echo $user->username; ?>"><?php echo $user->username; ?></a></li>
							<li><a href="<?php echo BASE_URL; ?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->
<!--Profile cover-->
<div class="profile-cover-wrap">
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<!-- PROFILE-COVER -->
		<img src="<?php echo BASE_URL; ?>assets/images/defaultCoverImage.png"/>
	</div>
</div>
<div class="profile-nav">
 <div class="profile-navigation">
	<ul>
		<li>
		<div class="n-head">
			TWEETS
		</div>
		<div class="n-bottom">
		  <?php $getFromT->countTweets($profileId); ?>
		</div>
		</li>
		<li>

				<div class="n-head">
					FOLLOWING
				</div>
				<div class="n-bottom">
					<span class="count-following"><?php echo $profileData->following; ?></span>
				</div>
			</a>
		</li>
		<li>
				<div class="n-head">
					FOLLOWERS
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profileData->followers; ?></span>
				</div>
			</a>
		</li>
	</ul>
	<div class="edit-button">
		<form method="post">
			<?php $getFromF->displayBtn($user_id, $profileId); ?>
		</form>
	</div>
    </div>
</div>
</div><!--Profile Cover End-->

<!---Inner wrapper-->
<div class="in-wrapper">
 <div class="in-full-wrap">
   <div class="in-left">
     <div class="in-left-wrap">
	<!--PROFILE INFO WRAPPER END-->
	<div class="profile-info-wrap">
	 <div class="profile-info-inner">
	 <!-- PROFILE-IMAGE -->
		<div class="profile-img">
			<img src="<?php echo BASE_URL.$profileData->profileImage; ?>"/>
		</div>

		<div class="profile-name-wrap">
			<div class="profile-name">
				<?php echo $profileData->fullname; ?>
			</div>
			<div class="profile-tname">
				@<span class="username"><?php echo $profileData->username; ?></span>
			</div>
		</div>

	 </div>
	<!--PROFILE INFO INNER END-->

	</div>
	<!--PROFILE INFO WRAPPER END-->

	</div>
	<!-- in left wrap-->

  </div>
	<!-- in left end-->

 <div class="in-center">
	<div class="in-center-wrap">
		<?php
			$tweets = $getFromT->getUserTweets($profileId);
			foreach ($tweets as $tweet) {
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
											<span><a href=""'. $tweet->username .'">'. $tweet->fullname .'</a></span>
											<span>@'. $tweet->username .'</span>
											<span>'. $tweet->postedOn .'</span>
										</div>
										<div class="t-h-c-dis">
											'. $tweet->status .'
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
					</div>';
			}

		?>
	</div in left wrap
  <div class="popupTweet"></div>
</div>
 <!-- in center end  -->
</div>
<!--in full wrap end-->
</div>
<!-- in wrappper ends-->
</div>
 <!-- ends wrapper -->
</body>
</html>

