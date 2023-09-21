import baguetteBox from 'baguettebox.js';

baguetteBox.run('.gallery, .swiper-container-theme .swiper-wrapper, .image-wrapper, a[rel="noopener"]', {
    noScrollbars: true,
    async: true,
    titleTag: true
});
