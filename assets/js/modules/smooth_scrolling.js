const $ = require('jquery');

$(document).ready(function () {
    $('a.nav-link').click(function (e) {
        e.preventDefault();
        let target = e.target.getAttribute('href');

        $('html, body').animate({
            scrollTop: $(target).offset().top - 25
        }, 1500);
    });
});


