function initTagRevealer() {
    const btn = document.querySelector('.show-tags');
    const btn_text = document.querySelector('.show-tags .btn-text');
    const btn_chev = document.querySelector('.show-tags .btn-chev');
    const tags = document.querySelector('.all-tags');
    const container = document.querySelector('.all-tag-container');

    if(!btn) {
        return;
    }

    btn.addEventListener('click', () => {
        if(container.classList.contains('exposed')) {
            btn_text.innerHTML = "Show All Tags";
            btn_chev.style.transform = "scale(1,1)";
            tags.style.display = "none";
            return container.classList.remove('exposed');
        }

        btn_text.innerHTML = "Hide Tags";
        btn_chev.style.transform = "scale(1,-1)";
        tags.style.display = "flex";
        return container.classList.add('exposed');
    })
}

export {initTagRevealer};