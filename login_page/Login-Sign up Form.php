<?php 
//we include the login php file 
include('login.php') 
?>
<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login / Sign up Form</title>
    <link rel="stylesheet" href="Login Sign up.css">

    <style>
    .form__input-group {
      position: relative;
    }

    .form__input-group input {
      padding-right: 35px; /* Χώρος από τα δεξιά για το κουμπί */
    }

    .form__input-group button {
      height: 22px;
      position: absolute;
      top: 50%;
      right: 10px; /*αποσταση απο δεξια*/
      transform: translateY(-50%);
      
    }

    .form__input-group button img {
      height: 18px;
      width: 18px;
    }

    .form__input-group .form__input-error-message {
    position: static;
    bottom: -10px; /* Ρυθμίζει την απόσταση από το πεδίο κωδικού */
    left: 0;
    color: red; /* Ρυθμίζει το χρώμα του μηνύματος */
    font-size: 14px; /* Ρυθμίζει το μέγεθος του μηνύματος */
    }

  </style>

  </head>

  <body>
    <div class="container">
       <!-- after we include the php file, we add action option with the entire php/html file because we saw that on a video :p--> 
      <form class="form" action="Login-Sign up Form.php" method="post" id="login">
        <h1 class="form__title">Login</h1>
        <div
        <?php if (isset($name_error)): 
        /*this class appears only when there is invalid username/password combination
          here the message gets styled by css  
        */?>
          class="form__message form__message--error"
        <?php endif ?>  
        >
          <?php if (isset($name_error)): /*here the message get printed from php*/?>
            <span><?php echo $name_error; ?></span>
          <?php endif ?>  
        </div>
        <!-- this is the first form used for the Login page --> 
        <div class="form__input-group">
          <input type="text" id="loginUsername" class="form__input" autofocus placeholder="Username" name="loginUsername"> 
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input type="password" id="loginPassword" class="form__input" autofocus placeholder="Password" name="loginPassword">
          <button type="button" id="toggleLoginPassword">
          <img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />
          </button>
          <div class="form__input-error-message"></div>
        </div>
         <!-- we add value to the button to be able to check if it is used in js file --> 
        <button class="form__button" type="submit" name="login" value="login">Log in</button>

        <p class="form__text">
          <a  class="form__link" href="./" id="linkCreateAccount">Don't have an account? Create one</a>
        </p>
      </form>
      <!-- this is the second form used for the Signup page --> 
      <!-- With form--hidden we hide the second page in order for the first page to show using js -->

      <form class="form form--hidden" action="sign up.php" method="post"  id="createAccount">
        <h1 class="form__title">Create Account</h1>
        <div class="form__message form__message--error"></div>
        <div class="error-text"></div>
        <div class="form__input-group">
          <input type="text" required id="signupUsername" class="form__input" autofocus placeholder="Username" name="signupUsername">
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
           <!-- we use a pattern option equaled to a regular expression to check if the email address input is valid --> 
          <input type="text" pattern="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$" required id="email" class="form__input" autofocus placeholder="Email Address" name="email"> 
          <div class="form__input-error-message"></div>
        </div> 
        <div class="form__input-group">
          <input type="password" required id="signupPassword" class="form__input" autofocus placeholder="Password" name="signupPassword">
          <button type="button" id="toggleSignupPassword">
          <img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />
          </button>
          <div class="form__input-error-message"></div>
        </div>
        <div class="form__input-group">
          <input type="password" required id="signupPassword2" class="form__input2" autofocus placeholder="Confirm password">
          <button type="button" id="toggleSignupPassword2">
          <img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />
          </button>
          <div class="form__message form__message--error" id="passwordMismatchError"></div>
        </div>
         <!-- we add 'required' option to every input field of the sign up form. this prevents the user from submitting an empty field.--> 
         <!-- we add value to the button to be able to check if it is used in js file --> 
        <button class="form__button" type="submit" id="button" name="register" value="register">Sign up</button>
        
        <p class="form__text">
          <a  class="form__link" href="./" id="linkLogin">Already have an account? Sign in</a>
        </p>
      </form>

   </div>
             <!-- import the js file --> 
             <script src="Login Sign up.js"> </script>

             <script>
            // Συνάρτηση για toggle εμφάνισης/απόκρυψης του κωδικού
             function togglePasswordVisibility() {
             const passwordInput = document.getElementById('loginPassword');
             const toggleButton = document.getElementById('toggleLoginPassword');

               if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.innerHTML = '<img src="/web_database/map/user_settings/show_pass.png" alt="Toggle Password" />';
              } else {
                passwordInput.type = 'password';
                toggleButton.innerHTML = '<img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />';
              }
             }

            // Συνδέστε την συνάρτηση togglePasswordVisibility με το κουμπί
                const toggleButton = document.getElementById('toggleLoginPassword');
                toggleButton.addEventListener('click', togglePasswordVisibility);
            </script>

<script>
    function togglePasswordVisibilityS() {
        const passwordInput = document.getElementById('signupPassword');
        const toggleButton = document.getElementById('toggleSignupPassword');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '<img src="/web_database/map/user_settings/show_pass.png" alt="Toggle Password" />';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '<img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />';
        }
    }

    const toggleButtonS = document.getElementById('toggleSignupPassword');
    toggleButtonS.addEventListener('click', togglePasswordVisibilityS);
</script>

<script>
    function togglePasswordVisibilityS2() {
        const passwordInput = document.getElementById('signupPassword2');
        const toggleButton = document.getElementById('toggleSignupPassword2');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleButton.innerHTML = '<img src="/web_database/map/user_settings/show_pass.png" alt="Toggle Password" />';
        } else {
            passwordInput.type = 'password';
            toggleButton.innerHTML = '<img src="/web_database/map/user_settings/hide_pass.png" alt="Toggle Password" />';
        }
    }

    const toggleButtonS2 = document.getElementById('toggleSignupPassword2');
    toggleButtonS2.addEventListener('click', togglePasswordVisibilityS2);
</script>

             <script>
        // JavaScript for handling the form submission for signup form
        document.addEventListener("DOMContentLoaded", () => {
            const createAccountForm = document.getElementById("createAccount");
            const password = document.getElementById("signupPassword");
            const confirmPassword = document.getElementById("signupPassword2");
            const passwordMismatchError = document.getElementById("passwordMismatchError");

            createAccountForm.addEventListener("submit", e => {
                // Check if passwords match, if not, display an error message and prevent form submission
                if (password.value !== confirmPassword.value) {
                    passwordMismatchError.textContent = "Passwords do not match!";
                    e.preventDefault(); // Prevent form submission
                } else {
                    // If passwords match, clear the error message and allow form submission
                    passwordMismatchError.textContent = "";
                }
            });
        });
    </script>
             
  
   

 

  </body>
</html>