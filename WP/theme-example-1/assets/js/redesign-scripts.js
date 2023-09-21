window.addEventListener('DOMContentLoaded', () => {
    let paged = pagedTmpl;
    let tooltips = tooltipArr;
    let excuteCb = false;

    const tooltip = (arr) => {
        let toolTipdata = arr;

        if (toolTipdata.length > 0) {
            let tooltipTitles = document.querySelectorAll('.tooltip');
            let tooltipBody = document.getElementById('tooltiptext');
            let formFilter = document.getElementById('form-filter');
            let filterWrap = document.querySelector('.form-filter-wrap');

            function getOffset(element) {
                let rect = element.getBoundingClientRect();
                return {
                  left: rect.left,
                  top: rect.top
                };
            };

            function removeTooltip() {
                tooltipBody.dataset.tooltip = '';
                tooltipBody.firstElementChild.textContent = '';
                tooltipBody.classList.remove('active');
                tooltipBody.style = null;
            };
              
            tooltipTitles.forEach(element => {
                element.addEventListener('mouseover', () => {
                    toolTipdata.map(key => {
                        if (element.dataset.id == key.id) {
                            tooltipBody.dataset.tooltip = key.id;
                            tooltipBody.firstElementChild.insertAdjacentHTML('afterbegin', key.cont);
                            tooltipBody.classList.add('active');

                            if (window.innerWidth > 1439) {
                                tooltipBody.style.cssText = `
                                    top: ${getOffset(element).top - ((tooltipBody.scrollHeight - element.scrollHeight) / 2)}px;
                                    left: ${getOffset(element).left + (element.scrollWidth * 2)}px;
                                `;
                            };
                        };
                    });

                    window.addEventListener('resize', () => {
                        if (window.innerWidth > 1439 &&  tooltipBody.classList.contains('active')) {
                            tooltipBody.style.cssText = `
                                top: ${getOffset(element).top - ((tooltipBody.scrollHeight - element.scrollHeight) / 2)}px;
                                left: ${getOffset(element).left + 30}px;
                            `;
                        } else if (window.innerWidth < 1440 &&  tooltipBody.classList.contains('active')) {
                            tooltipBody.style = null;
                            filterWrap.classList.add('active');
                        };
                    });
                });

                element.addEventListener('mouseout', removeTooltip);
            });

            formFilter.addEventListener('scroll', removeTooltip);
            window.addEventListener('scroll', () => {
                if (window.innerWidth > 1439) {
                    removeTooltip();
                };
            });
        }
    };

    const radioBtn = (selector) => {
        radioWrap = document.querySelector(selector);
        let filterForm = document.querySelector('#form-filter');

        if (radioWrap) {
            let radioButtons = radioWrap.querySelectorAll('.filter-label');

            for (let i = 0; i < radioButtons.length; i++) {
                radioButtons[i].onmouseup = () => {
                    let radioInput = radioButtons[i].querySelector('input');

                    if (radioInput.checked) {
                            function removeChecked() {
                                radioInput.checked = false;
                            };
                            window.setTimeout(() => {
                            removeChecked();
                            if (window.innerWidth > 1439) {
                                filterForm.dispatchEvent(new Event('change'));
                            };
                        }, 5);
                    };
                };
            };
        };
    };

    const filterSelect = (select) => {
        let sel = document.querySelector(select);

        if (sel) {
            let selectHead = sel.querySelector('.select-filter-head');
            let selectBody = sel.querySelector('.select-filter-body');
            let selectBodyItem = sel.querySelectorAll('.select-filter-body-text');
            let filterForm = document.querySelector('#form-filter');
            let filterOpt = document.querySelectorAll('.filter-option');
            let filterSelect = document.querySelector('.filter-select');

            selectHead.addEventListener('click', () => {
                if (sel.classList.contains('active')) {
                    sel.classList.remove('active');
                    selectBody.removeAttribute('style');
                } else {
                    sel.classList.add('active');
                    selectBody.style.height = selectBody.scrollHeight + 'px'; 
                }
            });

            for (let i = 0; i < selectBodyItem.length; i++) {
                selectBodyItem[i].onclick = () => {
                    let selHeader = selectHead.querySelector('#selected');

                    selectBodyItem.forEach(element => {
                        element.classList.remove('active');
                    });

                    selectBodyItem[i].classList.add('active');

                    selHeader.dataset.selected = selectBodyItem[i].dataset.select;

                    selHeader.innerText = selectBodyItem[i].textContent;

                    filterOpt.forEach(element => {
                        element.removeAttribute('selected');

                        if (element.dataset.option == selHeader.dataset.selected) {
                            element.selected = true;
                            if (window.innerWidth > 1439) {
                                filterForm.dispatchEvent(new Event('change'));
                            } else {
                                filterSelect.dispatchEvent(new Event('change'));
                            };
                        };
                    });

                    sel.classList.remove('active');

                    selectBody.removeAttribute('style'); 
                };
            };
        };
    };

    const filterScroll = (selector) => {
        let filterDesc = document.querySelector(selector);

        if (filterDesc) {
            window.addEventListener('scroll', () => {
                if (window.innerWidth > 1439) {
                    if (window.pageYOffset > 0) {
                        filterDesc.classList.add('scrolled');
                    } else {
                        filterDesc.classList.remove('scrolled');
                    };
                };
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth < 1440) {
                    filterDesc.classList.remove('scrolled');
                } else {
                    if (window.pageYOffset > 0) {
                        filterDesc.classList.add('scrolled');
                    };
                };
            });
        };
    };

    const formSearch = (selector) => {
        let fS = document.querySelector(selector);
        
        if (fS) {
            let inputSearch = fS.querySelector('#search-input');
            let searchResult = fS.querySelector('.search-results');
            let blockResult = fS.querySelector('.search-results-body');
            let clearBtn = fS.querySelector('.btn-search-clear');
            let submitBtnTop = fS.querySelector('.website-search-page-submit');
            let submitBtnBottom = fS.querySelector('.search-results-btn');
            let footerTxt = fS.querySelector('.search-results-footer-text span');
            let iputPost = fS.querySelector('#iput-post-type');
            let resultWrap = fS.querySelector('.result-num-wrap');
            let resultNum = fS.querySelector('.result-num');
            let postWrap = document.querySelector('.posts-archive-body-wrap');
            let loadMoreWrap = document.querySelector('#load-more');
            let filterForm = document.querySelector('#form-filter');
            let applyBtn = document.querySelector('#apply-btn');
            let cB = document.querySelector('#filter-block-choosed');
            let cBHead = cB.querySelector('#filter-block-choosed-head');
            let cBBody = cB.querySelector('#filter-block-choosed-body');
            let resetSearchBtn = document.querySelector('.btn-search-reset');
            let limitResult = 4;
            let fullResults = -1;
            let inputResult;

            const resetFiltes = () => {
                filterForm.reset();
                $('.asterisk').remove();

                if (cBHead.hasChildNodes()) {
                    cBHead.removeChild(cBHead.firstChild);
                    excuteCb = false;
                };

                if (cBBody.hasChildNodes()) {
                    while (cBBody.firstChild) {
                        cBBody.removeChild(cBBody.firstChild);
                    };
                };
            };

            const clearResult = () => {
                while (blockResult.firstChild) {
                    blockResult.removeChild(blockResult.firstChild);
                };
            };

            const clearfooterTxt = () => {
                footerTxt.dataset.search = '';
                footerTxt.innerText = '';
                resultNum.innerText = '';
                resultNum.dataset.result = ''
                resultWrap.classList.remove('active');
            };

            const showFullResults = e => {
                e.preventDefault();
                resetFiltes();

                if (inputSearch.value.length > 2 && inputResult.max > 0) {
                    $.ajax({
                        type: 'GET',
                        url: ajaxUrl,
                        data: {
                            action: 'show_search_result',
                            request: inputSearch.value,
                            post: iputPost.value,
                            num: fullResults
                        },
                        success: function (data) {
                            let result = JSON.parse(data); 

                            if (postWrap.hasChildNodes()) {
                                while (postWrap.firstChild) {
                                    postWrap.removeChild(postWrap.firstChild);
                                };
                            };

                            searchResult.classList.remove('active');
                            clearResult();
                            clearfooterTxt();
                            clearBtn.classList.remove('active');
                            loadMoreWrap.style.display = 'none';
                            resetSearchBtn.classList.add('active');
    
                            postWrap.insertAdjacentHTML('afterbegin', result.html);
                        }
                    });
                };
            };

            submitBtnTop.addEventListener('click', showFullResults);
            submitBtnBottom.addEventListener('click', showFullResults);
            fS.addEventListener('submit', showFullResults);

            resetSearchBtn.addEventListener('click', function() {
                this.classList.remove('active');

                if (!clearBtn.classList.contains('active')) {
                    fS.reset();
                };

                if (window.innerWidth > 1439) {
                    filterForm.dispatchEvent(new Event('change'));
                } else {
                    applyBtn.dispatchEvent(new Event('click'));
                };
            });

            inputSearch.addEventListener('input', function () {
                if (this.value.length > 2) {
                    searchResult.classList.add('active');
                    clearBtn.classList.add('active');
                    let searchRequest = this.value;

                    footerTxt.dataset.search = searchRequest;
                    footerTxt.innerText = footerTxt.dataset.search;

                    $.ajax({
                        type: 'GET',
                        url: ajaxUrl,
                        data: {
                            action: 'show_search_result',
                            request: searchRequest,
                            post: iputPost.value,
                            num: limitResult
                        },
                        success: function (data) {
                            inputResult = JSON.parse(data); 

                            clearResult();

                            resultNum.dataset.result = inputResult.max;
                            resultNum.innerText = resultNum.dataset.result;
                            resultWrap.classList.add('active');

                            let note = document.querySelector('.asterisk-search') ? document.querySelector('.asterisk-search') : '';

                            if (inputResult.max < 1) {
                                if (!note) {
                                    let span = document.createElement('span');
                                    span.innerHTML = 'Oops! We don’t have anything exactly like what you’re looking for. You can request content be created based on what you are looking for <a href="#" onclick="elementorProFrontend.modules.popup.showPopup( { id: jQuery(\'#popup-id\').data(\'id-popup\') } )">here.</a>';
                                    span.className = 'asterisk-search';
                                    blockResult.append(span);
                                };
                            } else {
                                blockResult.insertAdjacentHTML('afterbegin', inputResult.html);
                            };
                        }
                    });
                } else if (this.value.length < 1) {
                    searchResult.classList.remove('active');
                    clearResult();
                    clearfooterTxt();
                    clearBtn.classList.remove('active');
                };
            });

            clearBtn.addEventListener('click', function() {
                fS.reset();
                clearResult();
                clearfooterTxt();
                this.classList.remove('active');
                searchResult.classList.remove('active');
                resultNum.innerText = '';
                resultNum.dataset.result = ''
                resultWrap.classList.remove('active');
            });
        };
    };

    const showFilterMob = (selector) => {
        let filterWrap = document.querySelector(selector);

        if (filterWrap) {
            let filterBtn = document.querySelector('#btn-filter');
            let closeBtn = filterWrap.querySelector('#filter-close-btn');
            let applyBtn = filterWrap.querySelector('#apply-btn');

            const onClickOutside = (e) => {
                if (e.target.className.includes('form-filter-wrap')) {
                    filterWrap.classList.remove('active');
                };
            };

            const removeActiveWrap = () => {
                filterWrap.classList.remove('active');
            };

            filterBtn.addEventListener('click', () => {
                filterWrap.classList.add('active');
            });

            closeBtn.addEventListener('click', removeActiveWrap);
            applyBtn.addEventListener('click', removeActiveWrap);

            document.addEventListener('keydown', event => {
                if (window.innerWidth < 1440 && event.key === "Escape") {
                    removeActiveWrap();
                };
            });

            window.addEventListener('click', onClickOutside);
        };
    };

    const filterAccordion = (selector) => {
        let fA = document.querySelectorAll(selector);

        if (fA.length > 0) {
            for (let i = 0; i < fA.length; i++) {
                let filterHead = fA[i].querySelector('.filter-block-accordion-head');
                let filterbody = fA[i].querySelector('.filter-block-accordion-body-wrap');

                filterHead.onclick = () => {
                    fA[i].classList.toggle('active');

                    if (fA[i].classList.contains('active')) {
                        filterbody.style.height = filterbody.scrollHeight + 'px';
                    } else {
                        filterbody.removeAttribute('style');
                    };
                };
            };
        };
    };

    const choosedBlock = (selector) => {
        let cB = document.querySelector(selector);

        if (cB) {
            let cBHead = cB.querySelector('#filter-block-choosed-head');
            let cBBody = cB.querySelector('#filter-block-choosed-body');
            let clearbtnHtml = '<button class="filter-block-choosed-title" id="clear-choosed" type="button">Clear all filters</button>'
            let checkbox = document.querySelectorAll('.filter-label input[type="checkbox"]');
            let filterForm = document.querySelector('#form-filter');
            let applyBtn = filterForm.querySelector('#apply-btn');
        
            function clearBtnAppend() {
                if (!excuteCb) {
                    excuteCb = true;
                    cBHead.insertAdjacentHTML('beforeend', clearbtnHtml);
                };
            };

            for (let i = 0; i < checkbox.length; i++) {

                checkbox[i].onchange = () => {
                    $('.asterisk').remove();
                    let checkedNum = 0;
                    if(checkbox[i].checked == true) {
                        let chossedBtn =`<span class="block-choosed" data-choosed="${checkbox[i].dataset.checkbox}">
                                            <span class="block-choosed-text">${checkbox[i].dataset.checkbox}</span>
                                            <button class="btn-choosed-clear" type="button" aria-label="Remove choosed value">
                                                <span>.</span>
                                            </button>
                                        </span>`;

                        clearBtnAppend();
                        cBBody.insertAdjacentHTML('beforeend', chossedBtn);
                    } else {
                        let chossedBtn = cB.querySelector(`.block-choosed[data-choosed="${checkbox[i].dataset.checkbox}"]`);

                        chossedBtn.remove();
                    };

                    checkbox.forEach(element => {
                        if (element.checked == true) {
                            checkedNum++;
                        };
                    });

                    if (checkedNum < 1) {
                        excuteCb = false;
                        cBHead.removeChild(cBHead.firstChild);
                    };
                };
            };

            window.onclick = e => {
                if (e.target.classList.contains('filter-block-choosed-title')) {
                    $('.asterisk').remove();
                    let tg = e.target;
                    checkbox.forEach(element => {
                        if (element.checked == true) {
                            element.checked = false;
                            while (cBBody.firstChild) {
                                cBBody.removeChild(cBBody.firstChild);
                            };
                            excuteCb = false;
                        };
                    });

                    if (window.innerWidth > 1439) {
                        filterForm.dispatchEvent(new Event('change'));
                    } else {
                        applyBtn.dispatchEvent(new Event('click'));
                    };
                    
                    tg.remove();
                } else if (e.target.classList.contains('btn-choosed-clear')) {
                    let tg = e.target;
                    let parentCheckbox = document.querySelector(`.filter-label input[data-checkbox="${tg.parentElement.dataset.choosed}"]`);
                    
                    parentCheckbox.checked = false;
                    tg.parentElement.remove();

                    if (window.innerWidth > 1439) {
                        filterForm.dispatchEvent(new Event('change'));
                    } else {
                        applyBtn.dispatchEvent(new Event('click'));
                    };

                    if (cBBody.children.length < 1) {
                        excuteCb = false;
                        cBHead.removeChild(cBHead.firstChild);
                    };
                };
            };
        };
    };

    const loadMore = (selector) => {
        let lM = document.querySelector(selector);

        if (lM) {
            let lMBtn = lM.querySelector('.load-more');
            let postWrap = document.querySelector('.posts-archive-body-wrap');
            let maxPages = maxPagesTmpl ? maxPagesTmpl : 0;

            if (maxPages < 2) {
                lM.style.display = 'none';
            };

            lMBtn.addEventListener('click', () => {
                let form = document.querySelector('#form-filter');
                let data = Object.fromEntries(new FormData(form).entries());

                paged++;

                $.ajax({
                    type: 'GET',
                    url: ajaxUrl,
                    data: {
                        action: 'show_posts',
                        form_data: data,
                        paged: paged,
                    },
                    success: function (data) {
                        let result = JSON.parse(data); 
                        postWrap.insertAdjacentHTML('beforeend', result.html);

                        if (paged < result.max_pages) {
                            lM.removeAttribute('style');
                        } else {
                            lM.style.display = 'none';
                        };
                    }
                });
            });
        };
    };

    const filtersRequest = (selector) => {
        let fR = document.querySelector(selector);

        if (fR) {
            let applyBtn = fR.querySelector('#apply-btn');
            let loadMoreWrap = document.querySelector('#load-more');
            let postWrap = document.querySelector('.posts-archive-body-wrap');
            let filterSelect = document.querySelector('.filter-select');
            let resetSearchBtn = document.querySelector('.btn-search-reset');

            function formDataRequest() {
                let data = Object.fromEntries(new FormData(fR).entries());
                AjaxRequest(data, loadMoreWrap);
            };

            applyBtn.addEventListener('click', () => {
                if (window.innerWidth < 1440) {
                    formDataRequest();
                };
            });

            filterSelect.addEventListener('change', () => {
                if (window.innerWidth < 1440) {
                    formDataRequest();
                };
            });

            fR.addEventListener('change', () => {
                if (window.innerWidth > 1439) {
                    formDataRequest();
                };
            });

            function AjaxRequest(data, loadMoreWrap) {
                paged = 1;

                $.ajax({
                    type: 'GET',
                    url: ajaxUrl,
                    data: {
                        action: 'show_posts',
                        paged: paged,
                        form_data: data,
                    },
                    success: function (data) {
                        let result = JSON.parse(data);

                        if (postWrap.hasChildNodes()) {
                            while (postWrap.firstChild) {
                                postWrap.removeChild(postWrap.firstChild);
                            };
                        };

                        postWrap.insertAdjacentHTML('afterbegin', result.html);

                        resetSearchBtn.classList.remove('active');

                        if (paged < result.max_pages) {
                            loadMoreWrap.removeAttribute('style');
                        } else if (result.max_pages < 2) {
                            loadMoreWrap.style.display = 'none';
                        };

                        let note = document.querySelector('.asterisk') ? document.querySelector('.asterisk') : '';
                        if(!result.html.length) {
                            if (!note) {
                                let span = document.createElement('span');
                                span.innerHTML = 'Oops! We don’t have anything exactly like what you’re looking for. You can request content be created based on what you are looking for <a href="#" onclick="elementorProFrontend.modules.popup.showPopup( { id: jQuery(\'#popup-id\').data(\'id-popup\') } )">here.</a>';
                                span.className = 'asterisk';
                                postWrap.parentNode.insertBefore(span, postWrap);
                            };
                        } else {
                            if (note) {
                                postWrap.parentNode.removeChild(note);
                            };
                        };
                    }
                });
            };
        };
    };

    tooltip(tooltips);
    filterScroll('#form-filter');
    radioBtn('.radio-btn-wrap');
    filterSelect('#select-filter');
    formSearch('#searchform-posts');
    showFilterMob('#form-filter-wrap');
    filterAccordion('.filter-block-accordion');
    choosedBlock('#filter-block-choosed');
    loadMore('#load-more');
    filtersRequest('#form-filter');
});