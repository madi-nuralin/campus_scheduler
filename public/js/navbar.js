/* navbar.js
 */

$(document).ready(function() {
    $(document).scroll(function () {
        var scroll = $(this).scrollTop();
        var topDist = $("#nav-container").position();
        if (scroll > topDist.top) {
            $('ul').css({"position":"fixed","top":"0"});
        } else {
            $('ul').css({"position":"static","top":"auto"});
        }
    });
});