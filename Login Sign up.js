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
  const password = document.getElementById("signupPassword");
  const password2= document.getElementById("signupPassword2");

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

  loginForm.addEventListener("submit", e => {
    e.preventDefault();

    //AJAX OR NODE CONNECTION

    setFormMessage(loginForm, "error", "Invalid username/password combination");
  });

  createAccountForm.addEventListener("submit",e => {
    e.preventDefault();

    //AJAX OR NODE CONNECTION 

    setFormMessage(createAccountForm, "error", "Cannot leave blanks");
  });

  document.querySelectorAll(".form__input").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 10) {
        setInputError(inputElement, "Username must be at least 10 characters in length");
      }
    });
  });

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

  document.querySelectorAll(".form__input2").forEach(inputElement => {
    inputElement.addEventListener("blur", e => {
      if (password.value != password2.value) {

        setMatchingError(inputElement, "Passwords must be the same");
        
        }  
      });

    inputElement.addEventListener("input", e => {
      clearMatchingError(inputElement);
      });

    });


});