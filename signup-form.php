<?php 
  if(isset($_POST['signup'])){
     $fullname = $_POST['fullname'];
     $username = $_POST['username'];
     $password = $_POST['password'];
     $email = $_POST['email'];
     $signupError = "";

     if(empty($fullname) || empty($username) || empty($password) || empty($email)){
        $signupError = 'All fields are required';
     }else{
        $email = $getFromU->checkInput($email);
        $fullname = $getFromU->checkInput($fullname);
        $username = $getFromU->checkInput($username);
        $password = $getFromU->checkInput($password);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $signupError = "Invalid email";
        }elseif(strlen($fullname) > 20){
            $signupError = "Name must be between 6-20 characters";
        }elseif(strlen($username) > 20){
            $signupError = "Username must be between 4-20 characters";
        }else{
            if($getFromU->checkEmail($email) == true){
                $signupError = "Email already registered";
            }else if($getFromU->checkUsername($username) == true){
                $signupError = "Username already exists";
            }
            else{
               $user_id = $getFromU->create('users',array('email' => $email , 'password' => md5($password), 'fullname' => $fullname , 'username' => $username, 'profileImage' => 'assets/images/defaultprofile1.png'));
               $_SESSION['user_id'] = $user_id;
               header('Location: home.php');
            }
        }
     }
  }
?>
<form method="post" autocomplete="off">
<div class="signup-div"> 
	<h3>New user? Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="fullname" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="text" name="username" placeholder="Username"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="signup" Value="Signup">
		</li>
	<?php  
		if (isset($signupError)) {
			echo '<li class="error-li">
	  		<div class="span-fp-error">' . $signupError . '</div>
			 </li>';
		}
	?>
	</ul> 
	
</div>
</form>
