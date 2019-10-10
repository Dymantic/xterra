import Flickity from "flickity";



function awaitImages(images) {
    return Promise.all([...images].map(image => {
        return new Promise((resolve, reject) => {
            image.addEventListener('load', resolve);
        });
    }));
}

function initSlideShow() {
    if(!document.querySelector('.slideshow')) {
        return;
    }

    const images = document.querySelectorAll('.slideshow-slide > img');

    awaitImages(images)
        .then(() => [...images].forEach(i => i.style.opacity = "1"))
        .then(() => window.slideShow = new Flickity('.slide-container', {
            setGallerySize: false,
            selectedAttraction: 0.03,
            autoPlay: 6000,
        }));
}

export {initSlideShow};