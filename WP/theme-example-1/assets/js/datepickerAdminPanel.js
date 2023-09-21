(function(){
    var $ = jQuery;
    cleanDatepicker();
    $('#cmt_webinar_date').datetimepicker({
        showSecond:false,
        showMillisec:false,
        showMicrosec:false,
        showTimezone: true,
        timeFormat: 'hh:mm tt z'
    });
})();

function cleanDatepicker() {
    let old_fn = $.datepicker._updateDatepicker;
    $.datepicker._updateDatepicker = function(inst) {
        old_fn.call(this, inst);
        let buttonPane = $(this).datepicker("widget").find(".ui-datepicker-buttonpane");
        $("<button type='button' class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all'>Delete</button>").appendTo(buttonPane).click(function(ev) {
            $.datepicker._clearDate(inst.input);
        }) ;
    }
}
