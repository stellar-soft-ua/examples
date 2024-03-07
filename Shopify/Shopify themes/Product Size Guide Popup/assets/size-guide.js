const body = document.body;
const closeSizeGuideBtn = document.querySelector('.size-guide__header-close');
const openSizeGuideBtn = document.querySelectorAll('.open-size-guide');
const tabBtn = document.querySelectorAll('[data-guide-tab]');
const guideTable = document.querySelectorAll('[data-guide-table]');
const sizeGuide = document.querySelector('.size-guide');
const sizeGuideContainer = document.querySelector('.size-guide .container');

const switchSizeGuide = () => {
  tabBtn.forEach((btn) => {
    btn.addEventListener('click', function () {
      tabBtn.forEach((clearActive) => {clearActive.classList.remove('active');})
      this.classList.add('active');
      guideTable.forEach((table) => {
        table.classList.remove('active');
        if(this.dataset.guideTab === table.dataset.guideTable) {
          table.classList.add('active');
        }
      })
    })
  })
}

const openSizeGuide = () => {
  openSizeGuideBtn.forEach(btn=>{
    btn.addEventListener('click', () => {
      sizeGuide.style.display = 'block';
      body.style.overflow = 'hidden';
    })
  })
}

const closeSizeGuide = (e) => {
  closeSizeGuideBtn.addEventListener('click', () => {
    sizeGuide.style.display = 'none';
    body.style.overflow = 'visible';
  })

  window.addEventListener('mouseup', (event) => {
      if(event.target == sizeGuide || event.target == sizeGuideContainer ){
        sizeGuide.style.display = "none";
        body.style.overflow = "visible";
      } 
  })
}


(() =>{
  closeSizeGuide();
  openSizeGuide();
  switchSizeGuide();
})();