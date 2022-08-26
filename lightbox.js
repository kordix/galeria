/* const images = document.querySelectorAll('.grid > img') */
let galleryindex = 0;

async function dupa(){
await new Promise(r => setTimeout(r, 2000));
}

dupa().then((res)=>{
const grid = document.querySelector(".galeria");
const lightbox = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightbox-img");
let galleryimages =  app.$root.files;

let currentsrc = '';


grid.addEventListener("click", (e) => {
    if (e.target.nodeName == 'BUTTON'){
        return;
    }

    lightbox.classList.add("active");
    lightboxImg.src = e.target.src;
    galleryindex = parseInt(e.target.getAttribute('num'));


    document.onkeydown = function (evt) {
        evt = evt || window.event;
        if (evt.key === "Escape" || evt.key === "Esc") {
            lightbox.classList.remove("active");

        }
    };
});


lightbox.addEventListener("click", (e) => {
    if (e.target !== e.currentTarget) return;
    lightbox.classList.remove("active");
    return;
});

document.querySelector('#gallerynextbutton').addEventListener('click', function () {
    // let currentindex = galleryimages.findIndex(el => el == lightboxImg.src.replace(window.location.origin, '')) + 1;
    
    console.log(galleryindex);
    galleryindex = parseInt(galleryindex) + 1;
    // console.log(window.location.origin);
    // console.log(lightboxImg.src.replace(window.location.origin, ''));

    if (galleryindex >= galleryimages.length) {
        galleryindex = 0;
    }
    console.log(galleryindex);
    console.log(galleryimages[1]);
    lightboxImg.src = '/uploads/journeys/'+galleryimages[galleryindex];



})



function generateGallery() {
    document.querySelector('#galeria').innerHTML = '';
    if (galleryimages) {
        for (let i = 0; i < galleryimages.length; i++) {
            let elem = galleryimages[i];
            document.querySelector('#galeria').innerHTML += /*html*/`<img src="${elem}" class="galleryelem" num="${i}" alt="">`
            document.querySelector('#galeria').innerHTML += /*html*/`<button onclick="removePhoto(${i})" class="btn-sm btn-danger">x</button>`

        }
    }
}


})