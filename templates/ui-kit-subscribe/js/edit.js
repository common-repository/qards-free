window.dmTemplateInit = window.dmTemplateInit || {};

window.dmTemplateInit['subscribe'] = function(component, edit) {
    if (!edit) {
        $('.button-subscribe', component).on('click', function(e) {
            e.preventDefault();

            var $this = $(this),
                subscribe = $this.closest('.subscribe'),
                email = $('.email-subscribe', subscribe).val();
                fname = $('.fname-subscribe', subscribe).val();
                lname = $('.lname-subscribe', subscribe).val();
                junk  = $('[name="b_1917b7e769315ab2386044c6e_9ea1866f94"]', subscribe).val();

            subscribe.removeClass('error done');
            subscribe.addClass('loading');

            $.ajax({
                url: ajaxurl,
                method: 'POST',
                data: {
                    action: 'dm_api',
                    method: 'subscriber.add',
                    params: {
                        email: email,
                        fname: fname,
                        lname: lname,
                        junk: junk
                    }
                },
                dataType: 'json',
                success: function(response) {
                    subscribe.removeClass('loading');

                    if ('result' in response) {
                        subscribe.addClass('done');
                    } else if ('error' in response) {
                        subscribe.addClass('error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("API failed: " + textStatus + ": " + errorThrown);
                    subscribe.removeClass('loading error done');
                }
            });
        })
    }
};
