import $ from 'jquery';
import 'jquery.mmenu';
import 'jquery.mmenu/dist/jquery.mmenu.css';

document.addEventListener('DOMContentLoaded', () => {
    const template = document.querySelector('#mmenu-template').innerHTML;

    $('#thememmenu').mmenu({
        'extensions': [
            'fx-listitems-fade',
            'border-offset',
            'pagedim-black',
            'theme-black'
        ],
        'navbars': [
            {
                'position': 'bottom',
                'content': [template]
            }
        ]
    });

});
