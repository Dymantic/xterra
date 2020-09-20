function getYoutubeIFrame(video_id) {
    return `<iframe class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/${video_id}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
}

export { getYoutubeIFrame };
