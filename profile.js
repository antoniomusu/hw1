
function changeImage(event){
    const box = event.currentTarget;
    imageURL=box.firstChild.src;
    if(imageURL!==undefined||imageURL!==null){
        fetch("changeImage.php/?avatar="+imageURL);
        profileImage.src = imageURL;
    }
        
}

function onJsonImage(json){
    console.log(json);
    const container = document.querySelector("#change-image");
    container.innerHTML="";
    for(let i =0; i<12; i++){
        const imageBox = document.createElement("div");
        const img = document.createElement("img");
        img.src = json.files[i];
        imageBox.appendChild(img);
        imageBox.addEventListener("click", changeImage);
        container.appendChild(imageBox);
        container.classList.remove("hidden");
        document.onclick = function(){
            document.querySelector("#change-image").classList.add("hidden");
            window.scrollTo({top: 0, behavior: "smooth"});
        }
    }

}

function onResponse(response){
    return response.json();
}

function searchImage(event){
    event.stopPropagation();
    fetch("changeImage.php").then(onResponse).then(onJsonImage);

}

function modificaBio(event){
    event.preventDefault();
    event.stopPropagation();
    const data = new FormData(bioForm);
    fetch("updateBio.php", {   
        method: "POST",
        body: data
    })
}

function onJsonAnime(json){
    console.log(json);
    const favorites = document.querySelector("#container")
    for(let anime of json){
        const imageBox = document.createElement("div");
        const title = document.createElement("h3");
        const img = document.createElement("img");
        imageBox.id = anime.animeID;
        img.src = anime.image;
        title.textContent = anime.title;
        imageBox.appendChild(img);
        imageBox.appendChild(title);
        imageBox.addEventListener("click", (event)=>{location.href = "anime.php?animeID="+event.currentTarget.id;});
        favorites.appendChild(imageBox);
    }
}

const profileImage = document.querySelector("#profileImage"); 
if(profileImage!==null)
    profileImage.addEventListener('click', searchImage);

const bioForm = document.querySelector(".content form");
if(bioForm!==null)
    bioForm.addEventListener('submit', modificaBio);

fetch("savedAnime.php/"+window.location.search).then(onResponse).then(onJsonAnime);