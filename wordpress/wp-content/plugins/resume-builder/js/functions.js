//document ready functions
jQuery(document).ready(function($) {
	
	$('.rb-experience-rating').each(function(){
		var $this = $(this);
		var readOnly = $this.data('read-only');
		var score = $this.data('score');

		$this.raty({
			starType: 'i',
			readOnly: readOnly,
			score: score
		});
	});
	
});