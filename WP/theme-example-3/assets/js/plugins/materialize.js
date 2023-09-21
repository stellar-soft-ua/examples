import 'materialize-css'

document.addEventListener('DOMContentLoaded', function () {
    // Forms inputs
    // M.FormSelect.init(document.querySelectorAll('select'))

    // Sidenav
    // M.Sidenav.init(document.querySelectorAll('.sidenav'));

    // Dropdown
    // M.Dropdown.init(document.querySelectorAll('.dropdown-trigger'));

    // Datepicker
    M.Datepicker.init(document.querySelectorAll('.datepicker'), {
        yearRange: 100
    })
})
