;(function ($, window, undefined) {
	$(function() {
		$(document).foundation();

		if (!Modernizr.svg) {
			$('object[data*="svg"]').each(function(i, val) {
				var src = val.data('img-fallback'), img = $('<img>');
				img.attr({
					src: src,
					'class': val.attr('class'),
					id: val.attr('id')
				});
				val.replaceWith(img);
				img.removeAttr("height width");
			});
		}
	});
})(jQuery, this);
