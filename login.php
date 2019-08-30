<?php 
  if(isset($_POST['login']) && !empty($_POST['login'])){
      $email = $_POST['email'];
      $password = $_POST['password'];
 
      if(!empty($email) || !empty($password)){
          $email = $getFromU->checkInput($email);
          $password = $getFromU->checkInput($password);

          if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
              $error = "Invalid email format";
          }else{
              if($getFromU->login($email, $password) === false){
                  $error = "The email or password is incorrect";
              }
          }
      }else{
          $error = "Please enter email and password";
      }
  }
?>
<div class="login-div">
<h3>Login</h3>
<form method="post"> 
	<ul>
		<li>
		  <input type="text" name="email" placeholder="Email"/>
		</li>
		<li>
		  <input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="submit" name="login" value="Login"/>
		</li>
	
	<?php 
		if (isset($error)) {
			echo '<li class="error-li">
	  				<div class="span-fp-error">' . $error . '</div>
	 			</li>';
		}
	?>
	 </ul>
	</form>
</div>
