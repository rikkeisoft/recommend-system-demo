var Common = function () {

    var url = $('body').attr('d-url'),
            _token = $('meta[name=csrf-token]').attr("content");
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

    /**
     * Process ratting
     * 
     * @returns {undefined}
     */
    var ratting = function () {
        $('input.star').click(function () {
            var _self = $(this),
                    _bookId = _self.parents('#frm-rate').attr('d-book'),
                    _point = _self.val();

            $.ajax({
                url: url + '/ajax/rate/' + _bookId,
                headers: {'X-CSRF-TOKEN': _token},
                type: 'POST',
                async: false,
                data: {point: _point},
                success: function (response) {
                    if (!response.status && typeof (response.error) !== "undefined" &&
                            response.error.code === 401) {
                        return window.location.href = url + '/login';
                    }

                    $('label.star').removeClass('active bad');
                    var _attrId = _self.attr('id'),
                            _clsActive = 'active';
                    if (_attrId === 'star-1-2') {
                        _clsActive = 'active bad';
                    }
                    _self.siblings('input.star:checked ~ label.star').addClass(_clsActive);

                    $('.yb-rate-value').text(response.rate_avg ? response.rate_avg : 0);
                }
            });
        });
    };

    return {
        init: function () {
            backToTop();
            search();
            ratting();
        }
    };
}();