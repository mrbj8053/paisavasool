"use strict";
$(document).ready(function() {
    // $('.theme-loader').addClass('loaded');
    $('.theme-loader').animate({
        'opacity': '0',
    }, 1200);
    setTimeout(function() {
        $('.theme-loader').remove();
    }, 500);
    // $('.pcoded').addClass('loaded');
});
