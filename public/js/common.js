var Common = function () {

    /**
     * BACK TO TOP
     */
    var backToTop = function () {
        // SHOW/HIDDEN button
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('.backtotop').fadeIn();
            } else {
                $('.backtotop').fadeOut();
            }
        });

        $('#backtotop').click(function () {
            $('html body').animate({scrollTop: 0}, 1000);
        });
    };

    /**
     * SEARCH
     */
    var search = function () {
        $('.hbtn-submit').click(function (e) {
            var _search_query = $('.hi-search-content').val();
            if ($.trim(_search_query).length === 0) {
                e.preventDefault();
                return false;
            }
        });
    };

    return {
        init: function () {
            backToTop();
            search();
        }
    };
}();