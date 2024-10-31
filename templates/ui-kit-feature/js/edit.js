window.dmTemplateInit = window.dmTemplateInit || {};

window.dmTemplateInit['feature'] = function(component, edit) {
	component.find('img').each(function(index, el) {
		var $el = $(el);
		if (el.complete) {
			$(el).addClass('loaded');
		} else {
			$(el).load(function() {
				$(this).addClass('loaded');
			});
		}
	});
};
