function controlSubmit(event){
    
    console.log("Ricevuto");
    
    if( form.username.value.lenght == 0 || form.password.value.length == 0){
            alert("Hai lasciato campi vuoti!");
            event.preventDefault();
            const error=document.querySelector("h1");
            error.textContent= "Non puoi lasciare campi vuoti!";
           
        }
}

const form = document.forms['access_form'];
form.addEventListener('submit', controlSubmit);

