// testing jenkins

window.dmTemplateInit = window.dmTemplateInit || {};

window.dmTemplateInit['cover'] = function(component, edit) {
	function resizeCover() {
		// var parentWindowWidth = $('body').data('parent-window-width');
		// var currentWindowWidth = $(document).width();

		component.find('.cover').each(function(){
			var cmp = $(this),
				content = cmp.find('.content'),
				contentHeight = content.outerHeight(true),
				paddingTop = 0,
				paddingBottom = 0;
			// if(content.length && typeof content[0].getBoundingClientRect == 'function')
			// 	contentHeight = content[0].getBoundingClientRect().height;
			if (cmp.find('.container').length && cmp.find('.holder').length) {
				paddingTop = cmp.find('.holder').css('padding-top').replace('px', '');
				paddingBottom = cmp.find('.holder').css('padding-bottom').replace('px', '');
				if ($('body.spaceforsticky').exists()) paddingTop = parseFloat(paddingTop) + 61;
			}
			var calculatedMinHeight = parseInt(contentHeight) + (parseInt(paddingTop) + parseInt(paddingBottom));
			var heightVal = Math.max(calculatedMinHeight, window.innerHeight);
			
			cmp.css({minHeight: heightVal, maxHeight: heightVal });

		});
		/*if (component.find('.container').length) {
			var paddingTop = component.find('.holder').css('padding-top').replace('px', '');
			if ($('body.spaceforsticky').exists()) paddingTop = parseFloat(paddingTop) + 61;
		}
		var contentHeight = component.find('.content').outerHeight();
		component.find('.cover').css({minHeight: contentHeight + (paddingTop * 2)});*/
	}

	if (component.find('.cover').exists()) {
		//resize covers
		resizeCover();
		$(window).on('load blur resizeEnd', function() {
			resizeCover();
		});
		$('body').on('keyup', '[contenteditable]', function() {
			resizeCover();
		});
		//if it's not edit mode
		if (!edit) {
			//VIDEO BG
			var backgroundHolder = component.find('.cover.video.youtube .background');

			backgroundHolder.YTPlayer();
			// EFFECTS FOR COVER
			if (!window.isMobile) {
				if (component.find('.cover.parallax:not(.video)').exists()) {
					//prepare
					component.find('.background').wrap('<div class="background-wrapper"/>')
					var once = 0;
					$(window).on('scroll load', function() {
						component.find('.parallax').each(function(index, element) {

							var elementsPosition = $(element).offset();
							var scrollTop = $(document).scrollTop(); if (scrollTop < 0) scrollTop = 0;
							var windowHeight = $(window).height();
							var scale = (scrollTop - elementsPosition.top) / windowHeight;
							var propotion = windowHeight / 10;
							var contentElement = $(element).find('.content');

							if ((scale > -1) && (scale < 1)) {
								//paralax effect on scroll
								var textPosition = (propotion * (scrollTop - elementsPosition.top) / windowHeight);
								$(contentElement).css('-webkit-transform', 'translateY(' + textPosition + 'px)')
									.css('-moz-transform', 'translateY(' + textPosition + 'px)')
									.css('-ms-transform', 'translateY(' + textPosition + 'px)')
									.css('-o-transform', 'translateY(' + textPosition + 'px)')
									.css('transform', 'translateY(' + textPosition + 'px)')
									.css('opacity', 1 - scale * 0.5);

								if (scale > 0) {
									var endOpacity = Math.abs(scale - 1) + 0.2;
									if (endOpacity > 1) endOpacity = 1;
									$(element).find('.background-wrapper').css('opacity', endOpacity);
									$(contentElement).css('opacity', Math.abs(scale - 1));
								} else {
									var endOpacity = 1 - Math.abs(scale) + 0.2;
									if (endOpacity > 1) endOpacity = 1;
									$(element).find('.background-wrapper').css('opacity', endOpacity);
									$(contentElement).css('opacity', 1 - Math.abs(scale));
								}
							}

						});
					});
				}
			}
		} else {
			var backgroundHolder = component.find('.cover.video.youtube .background');

			if(component.hasClass('custom-block')) {
				backgroundHolder.YTPlayer();
				backgroundHolder.on("YTPStart", function(e){
					backgroundHolder.pauseYTP();
				});
			}
		}
	}

    if (component.find('.dm-cover-ng').exists()) {

        var backgroundHolder = component.find('.dm-cover-ng.video.youtube .dm-background-video');
        if (window.isMobile) {
            if(component.hasClass('custom-block')) {
                backgroundHolder.YTPlayer();
                backgroundHolder.on("YTPStart", function(e){
                    backgroundHolder.pauseYTP();
                });
            }
		}else
			backgroundHolder.YTPlayer();

        if (!edit) {
            $('.button-subscribe', component).on('click', function(e) {
                e.preventDefault();

                var $this = $(this),
                    subscribe = $this.closest('.dm-cover-ng-subscribe'),
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
	}
};
