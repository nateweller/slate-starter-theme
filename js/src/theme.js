(function ($) {

    console.log('HI!');

    // primary menu toggle
    $(document).on('click', '.site-header__nav-toggle', function() {
        $('.site-header__mobile-nav').toggleClass('site-header__mobile-nav--open');
    });

}(jQuery));