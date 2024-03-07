if (document.querySelector('.custom-page-text-wrapper__text-btn')){
    document.querySelectorAll('.custom-page-text-wrapper__text-btn').forEach(btn=>{
        btn.addEventListener('click', function(){
            btn.closest('.custom-page-text-outer').classList.toggle('custom-page-text-outer--open');
        });
    });
}