window.dmTemplateInit = window.dmTemplateInit || {};

window.dmTemplateInit['image'] = function(component, edit) {
	//add loaded
	component.find('img').each(function(index, el) {
		(function(sel){
		  if (sel.complete) {
		    $(sel).parents('.image').addClass('loaded');
		  } else {
		    var loadFunc = function() {
		      $(sel).parents('.image').addClass('loaded');
		    };
		    $(sel).load = loadFunc;
		    $(sel).on('load', loadFunc);
		  }
		})(el);
	});

	//if it's not edit mode
	if (!edit) {
		component.find('.image.small .image-wrapper img').filter(function(){
		  return $(this).parent().is(":not(a)");
		}).each(function(index, el) {
		  var $this = $(this),
		      $dmTemplate = $this.closest('.dm-template'),
		      $body = $('body'),
		      $html = $('html'),
		      maxWidth = 734;

		  $this.off('click').on('click', function() {
		    if (!$('#image-popup').exists()){
		      $body.append('<div id="image-popup" class="image-popup"><div id="image-popup-inner" class="image-popup-inner"><a id="image-popup-close" class="image-popup-close" href="#">Close</a><div id="image-preview" class="image-preview"></div></div></div>');
		    }

		    if($this[0].naturalWidth <= maxWidth) {
		      return false;
		    }

		    $('#image-preview').empty().prepend('<img src="' + $this.attr('src') + '" alt="" />');

		    var colorThief = new ColorThief();
		    var color = colorThief.getColor($this[0]);

		    $('#image-popup-inner').css({
		      'background-color': 'rgba(' + color + ', 0.2)'
		    });

		    $body.addClass('show-image-popup');
		    $html.addClass('noscroll');

		    $('#image-popup-close').off('click').on('click', function(e) {
		      e.preventDefault();
		      $body.removeClass('show-image-popup');
		      $html.removeClass('noscroll');
		    })
		  })
		});
	}
};
