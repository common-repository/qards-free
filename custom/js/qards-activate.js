jQuery(function() {

    if(jQuery('#qards-activate').length && jQuery('#post-body-content').length && jQuery('#qards-activate').hasClass('can-move'))
        jQuery('#post-body-content').prepend(jQuery('#qards-activate'));

    jQuery('.right-button', '#qards-activate').on('click', function(e) {
        e.preventDefault();

        jQuery(this).closest('.button-holder').find('.drop-down').toggleClass('open');
    });

    jQuery('body').on('click', function(e) {
        if(!jQuery(e.target).closest('.right-button', '#qards-activate').length) {
            jQuery('.drop-down', '#qards-activate').removeClass('open');
        }
    });
});
