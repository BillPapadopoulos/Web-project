//the video used for some javascript functions and patterns is this:https://www.youtube.com/watch?v=3GsKEtBcGTk

function setFormMessage(formElement, type, message) {
  const messageElement = formElement.querySelector(".form__message");

  messageElement.textContent = message;
  messageElement.classList.remove("form__message--success", "form__message--error");
  messageElement.classList.add(`form__message--${type}`);
  //it was used in loginForm.addEventListener("submit", e =  .......
}
//function that prints error in the below if statements
function setInputError(inputElement, message) {
  inputElement.classList.add("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}
//clear the input error messages
function clearInputError(inputElement) {
  inputElement.classList.remove("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}
//function that prints the error when lthe passwords do not match
function setMatchingError(inputElement, message){
  inputElement.classList.add("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message2").textContent = message;
}
//clear the particular error message
function clearMatchingError(inputElement) {
  inputElement.classList.remove("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message2").textContent = "";
}
//
document.addEventListener("DOMContentLoaded", () => {
  //constant variable assignment
  const loginForm = document.querySelector("#login");
  const createAccountForm = document.querySelector("#createAccount");
  const username = document.getElementById("signupUsername");
  const email = document.getElementById("email");
  const password = document.getElementById("signupPassword");
  const password2= document.getElementById("signupPassword2");
  
  //this is where the forms alternate with click event
  document.querySelector("#linkCreateAccount").addEventListener("click", e => {
    e.preventDefault();
    loginForm.classList.add("form--hidden");
    createAccountForm.classList.remove("form--hidden");
  });

  document.querySelector("#linkLogin").addEventListener("click", e => {
    e.preventDefault();
    loginForm.classList.remove("form--hidden");
    createAccountForm.classList.add("form--hidden");
  });

  /*loginForm.addEventListener("submit", e => {
    e.preventDefault();
    //AJAX OR NODE CONNECTION
    setFormMessage(loginForm, "error", "Invalid username/password combination");
  });*/

  //checks for 8 chars in password
  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.length > 0 && e.target.value.length < 8) {
          setInputError(inputElement, "Password must be at least 8 characters in length");
        }   
      });   

    inputElement.addEventListener("input", e => {
      clearInputError(inputElement);
    });
  
  });

  //checks if the confirmation password is blank, and if it's not then it checks if the confirmation password matches the password
  document.querySelectorAll(".form__input2").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if(password2.value.length == 0){
        setMatchingError(inputElement, "Please enter the password again");
      }
      else if (password.value != password2.value) {
        setMatchingError(inputElement, "Passwords don't match");
        //document.getElementById("button").disabled = false;
        //need to fix error with successful submit 
      }  
    });

    inputElement.addEventListener("input", e => {
      clearMatchingError(inputElement);
    });

  });
  //checks if the passwords contains one number
  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.search(/[0-9]/) == -1) {
          setInputError(inputElement, "Password must contain at least one number");
        }   
      }); 

    inputElement.addEventListener("input", e => {
        clearInputError(inputElement);
      });

  });
  //checks if the passwords contains one special character
  document.querySelectorAll(".form__input").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if (e.target.id === "signupPassword" && e.target.value.search(/[!\@\#\$\%\^\&\*\+\-\?\.\,\=\(\)\_]/) == -1) {
        setInputError(inputElement, "Password must contain at least one special character");
      }   
    }); 

    inputElement.addEventListener("input", e => {
      clearInputError(inputElement);
    });
  
  });
  //checks if the passwords contains one upper case letter
  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.search(/[A-Z]/) == -1) {
          setInputError(inputElement, "Password must contain at least one upper case letter");
        }   
      }); 

    inputElement.addEventListener("input", e => {
        clearInputError(inputElement);
      });
    
  });
  //if the password field is clicked and then the user clicks somewhere else, we print this message. if this check does not exist, we had problems with if hierarchy
  document.querySelectorAll(".form__input").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if(e.target.id === "signupPassword" && e.target.value.length == 0){
        setInputError(inputElement, "Please enter the password");
      }
    });
    inputElement.addEventListener("input", e => {
      clearInputError(inputElement);
    });
  });


});