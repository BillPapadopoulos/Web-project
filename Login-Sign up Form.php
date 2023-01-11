<?php include('login.php') ?>
<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login / Sign up Form</title>
    <link rel="stylesheet" href="Login Sign up.css">
  </head>

  <body>

    <div class="container">
      <form class="form" action="Login-Sign up Form.php" method="post" id="login">
        <h1 class="form__title">Login</h1>
        <div
        <?php if (isset($name_error)): ?>
          class="form__message form__message--error"
        <?php endif ?>  
        >
          <?php if (isset($name_error)): ?>
            <span><?php echo $name_error; ?></span>
          <?php endif ?>  
        </div>
        <div class="form__input-group">
          <input type="text" id="loginUsername" class="form__input" autofocus placeholder="Username" name="loginUsername"> 
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input type="password" id="loginPassword" class="form__input" autofocus placeholder="Password" name="loginPassword">
          <div class="form__input-error-message"></div>
        </div>
        <button class="form__button" type="submit" name="login" value="login">Log in</button>
        <p class="form__text">
          <a href="#" class="form__link">Forgot your password?</a>
        </p>

        <p class="form__text">
          <a  class="form__link" href="./" id="linkCreateAccount">Don't have an account? Create one</a>
        </p>
      </form>

      <form class="form form--hidden" action="sign up.php" method="post"  id="createAccount">
        <h1 class="form__title">Create Account</h1>
        <div class="form__message form__message--error"></div>
        <div class="error-text"></div>
        <div class="form__input-group">
          <input type="text" id="signupUsername" class="form__input" autofocus placeholder="Username" name="signupUsername">
          <div class="form__input-error-message"></div>
          <p>Error message</p>
        </div>
        <div class="form__input-group">
          <input type="text" id="email" class="form__input" autofocus placeholder="Email Address" name="email"> 
          <div class="form__input-error-message"></div>
          <p>Error message</p>
        </div>
        <div class="form__input-group">
          <input type="password" id="signupPassword" class="form__input" autofocus placeholder="Password" name="signupPassword">
          <div class="form__input-error-message"></div>
          <p>Error message</p>
        </div>
        <div class="form__input-group">
          <input type="password" id="signupPassword2" class="form__input2" autofocus placeholder="Confirm password">
          <div class="form__input-error-message2"></div>
          <p>Error message</p>
        </div>
        <button class="form__button" type="submit" name="register" value="register">Sign up</button>
        
        <p class="form__text">
          <a  class="form__link" href="./" id="linkLogin">Already have an account? Sign in</a>
        </p>
      </form>

   </div>

   <script src="Login Sign up.js"> </script>
   

 

  </body>
</html>