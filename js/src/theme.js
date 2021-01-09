(function ($) {

    console.log(':-)');

    // primary menu toggle
    $('.site-header__nav-toggle > .menu-toggle').click(function() {
        $(this).toggleClass('menu-toggle--active');
        $('.site-header__mobile-nav').slideToggle();
    });
    
}(jQuery));