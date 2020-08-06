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
    const first_images = document.querySelector('.slideshow-slide:first-child').querySelectorAll('img');
    [...first_images].forEach(i => i.style.opacity = "1");

    awaitImages(images)
        .then(() => [...images].forEach(i => i.style.opacity = "1"))
        .then(() => window.slideShow = new Flickity('.slide-container', {
            setGallerySize: false,
            selectedAttraction: 0.03,
            autoPlay: 6000,
            arrowShape: 'M33.79 49.99l38.08 38.09h-5.66L28.13 49.99l38.08-38.08h5.66L33.79 49.99z',
        }));
}

export {initSlideShow};
