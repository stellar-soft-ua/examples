import Swiper from 'swiper/dist/js/swiper.min';
import 'swiper/dist/css/swiper.css';

new Swiper('.swiper-container-header', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    speed: 1400,
    autoplay: {
        delay: 7000
    },
    grabCursor: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    }
});

new Swiper('.swiper-container-theme', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
    speed: 1400,
    autoplay: {
        delay: 7000
    },
    grabCursor: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    }
});
