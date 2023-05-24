const form = document.forms['registration_form'];
form.addEventListener('submit', controlRegistrationSubmit);
const button = document.querySelector("#modal-logout button");
button.addEventListener('click', returnLogin);

const letter = document.getElementById("letter");
const capital = document.getElementById("capital");
const number = document.getElementById("number");
const length = document.getElementById("length");
let isPasswordValid = false;

function returnLogin(event){
  console.log("ricevuto");
  event.stopPropagation();
  window.location = "login.php";
}

function controlRegistrationSubmit(event){
    
    const fieldsEmpty= form.username.value.length == 0 || form.password.value.length == 0 || form.mail.value.length == 0||form.dataNascita.value.length== 0;
    const passwordDifferent = form.password.value !== form.cpassword.value;
    
    if(fieldsEmpty){
        alert("Hai lasciato campi vuoti!");
        event.preventDefault();
    }
    else if(passwordDifferent){
        alert("Le password non coincidono!");
        event.preventDefault();
        form.cpassword.focus();
    }
    else if(!isPasswordValid){
      alert("Password non conforme!");
      event.preventDefault();
      form.password.focus();
    }

}

form.password.onfocus = function() {
  document.querySelector("#message").classList.remove("hidden");
}

form.password.onblur = function(){
  document.querySelector("#message").classList.add("hidden");
}

// When the user starts to type something inside the password field
form.password.onkeyup = function() {
  const input = form.password.value;
  let hasLowerCaseLetters = input.match(/[a-z]/g);
  let hasUpperCaseLetters = input.match(/[A-Z]/g);
  let hasNumbers = input.match(/[0-9]/g);
  let isLongEnough = input.length > 8;
  // Validate lowercase letters
  if(hasLowerCaseLetters) {

    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }

  // Validate capital letters
  if(hasUpperCaseLetters) {
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  if(hasNumbers) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }

  // Validate length
  if(isLongEnough) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }

  isPasswordValid = hasLowerCaseLetters && hasUpperCaseLetters && hasNumbers && isLongEnough;
}



