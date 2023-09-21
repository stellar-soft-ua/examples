import ImagesLoaded from 'imagesloaded';
import Masonry from 'masonry-layout';

const masonrySelector = '.galleria';
let mansory = null

function initMansory() {
    mansory = new Masonry(masonrySelector, {
        itemSelector: '.galleria-item'
    });
}

function rerender() {
    if(!mansory) {
        return
    }
    mansory.layout();
}

if (document.querySelector(masonrySelector) !== null) {
    ImagesLoaded(masonrySelector, initMansory);
}

document.addEventListener('lazyloaded', function(e){
    rerender()
});