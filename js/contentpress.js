jQuery.noConflict();
jQuery(document).ready(function($) {
	var $container = $('#xpblog-category');
	$container.masonry({
		// options
		itemSelector: '.xpblog-item',
		isAnimated: true
	});
	$container.imagesLoaded(function() {
		$container.masonry('reload');
	});
});