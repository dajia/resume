(function($) {
	$.fn.responsiveScrollable = function(width, interval) {

		function _resize($scrollable, width) {
			var h = 0;
			if (width == 'auto') width = $scrollable.width();
			$('.items blockquote', $scrollable).each(function() {
				var $slide = $(this);
				if (width !== 'css') $slide.outerWidth(width);
				h = Math.max(h, $slide.outerHeight());
			});
			$scrollable.height(h);
		}

		return this.each(function() {
			var $scrollable = $(this);
			_resize($scrollable, width);
			$scrollable.scrollable({circular:true}).autoscroll({autoplay:true,autopause:true,interval:interval});
			if (width == 'auto') {
				$(window).resize(function() {
					_resize($scrollable, width);
					var api = $scrollable.data('scrollable');
					api.seekTo(api.getIndex(), 50);
				});
			}
		});
	}
})(jQuery);

jQuery(document).ready(function($) {
	$('.linkedin .scrollable').each(function() {
		var $this = $(this);
		$this.responsiveScrollable($this.data('width'), $this.data('interval'));
	});
});