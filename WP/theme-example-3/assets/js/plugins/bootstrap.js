import $ from 'jquery';
import 'popper.js';
import 'bootstrap';
import 'bootstrap-select';


$(() => {
    $.fn.selectpicker.Constructor.BootstrapVersion = '4';

    $('.selectpicker').selectpicker();
});
