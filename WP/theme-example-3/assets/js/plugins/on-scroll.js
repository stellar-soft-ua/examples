let bodyScrolled = false;
const bodyScrolledThreshold = 75;

function onScrollHandler() {
    if (window.scrollY >= bodyScrolledThreshold && !bodyScrolled) {
        bodyScrolled = true;
        document.body.classList.add('scrolled');
        document.body.querySelector('nav').classList.add('navbar-small');
    } else if (window.scrollY < bodyScrolledThreshold && bodyScrolled) {
        bodyScrolled = false;
        document.body.classList.remove('scrolled');
        document.body.querySelector('nav').classList.remove('navbar-small');
    }
}

window.addEventListener('scroll', onScrollHandler);
onScrollHandler();
