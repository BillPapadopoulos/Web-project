function setFormMessage(formElement, type, message) {
  const messageElement = formElement.querySelector(".form__message");

  messageElement.textContent = message;
  messageElement.classList.remove("form__message--success", "form__message--error");
  messageElement.classList.add(`form__message--${type}`);
}

function setInputError(inputElement, message) {
  inputElement.classList.add("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
  inputElement.classList.remove("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}

function setMatchingError(inputElement, message){
  inputElement.classList.add("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message2").textContent = message;
}

function clearMatchingError(inputElement) {
  inputElement.classList.remove("form__input--error");
  inputElement.parentElement.querySelector(".form__input-error-message2").textContent = "";
}

document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.querySelector("#login");
  const createAccountForm = document.querySelector("#createAccount");
  const username = document.getElementById("signupUsername");
  const email = document.getElementById("email");
  const password = document.getElementById("signupPassword");
  const password2= document.getElementById("signupPassword2");
  const validationLength=1;
  const validationMatch=1;
  const validationNumber=1;
  const validationSymbol=1;
  const validationCapital=1;

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

  createAccountForm.addEventListener("submit", e => {

    if(validationLength==0 && validationCapital==0 && validationMatch==0 && validationNumber==0 && validationSymbol==0){
      e.preventDefault();
    
    
      alert("PEOS");
    }
    
    
  });
  
  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.length > 0 && e.target.value.length < 8) {
          setInputError(inputElement, "Password must be at least 8 characters in length");
          validationLength=0;
        }   
      });   

    inputElement.addEventListener("input", e => {
      clearInputError(inputElement);
    });
  
  });

  document.querySelectorAll(".form__input2").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if(password2.value.length == 0){

        setMatchingError(inputElement, "Please enter the password again");

      }
      else if (password.value != password2.value) {

        setMatchingError(inputElement, "Passwords don't match");
        validationMatch=0;
        
        }  
      });

    inputElement.addEventListener("input", e => {
      clearMatchingError(inputElement);
      });

  });

  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.search(/[0-9]/) == -1) {
          setInputError(inputElement, "Password must contain at least one number");
          validationNumber=0;
        }   
      }); 

    inputElement.addEventListener("input", e => {
        clearInputError(inputElement);
      });

  });

  document.querySelectorAll(".form__input").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if (e.target.id === "signupPassword" && e.target.value.search(/[!\@\#\$\%\^\&\*\+\-\?\.\,\=\(\)\_]/) == -1) {
        setInputError(inputElement, "Password must contain at least one special character");
        validationSymbol=0;
      }   
    }); 

    inputElement.addEventListener("input", e => {
      clearInputError(inputElement);
    });
  
  });

  document.querySelectorAll(".form__input").forEach(inputElement => {
      inputElement.addEventListener("blur", e => {
        if (e.target.id === "signupPassword" && e.target.value.search(/[A-Z]/) == -1) {
          setInputError(inputElement, "Password must contain at least one upper case letter");
          validationCapital=0;
        }   
      }); 

    inputElement.addEventListener("input", e => {
        clearInputError(inputElement);
      });
    
  });



});