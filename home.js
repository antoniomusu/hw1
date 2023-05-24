function onJsonEvent(json){
    console.log(json);
    const content = document.querySelector(".content");
    for(e of json){
        const animeLink = document.createElement("a");
        animeLink.href = "anime.php?animeID="+e.animeID;
        animeLink.textContent = e.title; 
        const eventText = document.createElement("p");
        switch (e.type){
            case 0:
                eventText.textContent = "Hai aggiunto ai preferiti ";
                break;
            case 1: 
                eventText.textContent = "Hai rimosso dai preferiti ";
                break;
            case 2:
                eventText.textContent = "Hai lasciato un commento a ";
                break;
            default: break;      
        }
        const eventTime = document.createElement('div');
        eventTime.classList.add("time");
        eventTime.textContent = e.time;
        content.appendChild(eventText);
        eventText.appendChild(animeLink);
        eventText.appendChild(eventTime);
        
    }
}

function onResponse(response){
    return response.json();
}

fetch("restoreEvents.php").then(onResponse).then(onJsonEvent);
