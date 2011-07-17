(function(){

	function hideAddressBar(){
		setTimeout(function(){
			window.scrollTo(0, 1);
		}, 100);
	}


	function preventAutoscale(){
	  var viewportmeta = document.querySelector('meta[name="viewport"]');
	  if (viewportmeta) {
	    viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0';
	    document.body.addEventListener('gesturestart', function() {
	      viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
	    }, false);
	  }
	}



	if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
		hideAddressBar();
		preventAutoscale();
	}

})();

/**
*	Custom Javascript functions
*
*/


$(function($){





});
