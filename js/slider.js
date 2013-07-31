window.addEvent('domready', function() {
	var status = {
		'true': 'open',
		'false': 'close'
	};
	
	// Slide togglers
	
	if (window.document.getElementById('infocontainer') != null) {
		var infoSlide = new Fx.Slide('infocontainer', {
			mode: 'vertical',
			transition: 'pow:out',
			duration: 500
		}).hide();
	
		$('infotoggler').addEvent('click', function(e){
			e.stop();
			infoSlide.toggle();
		});
	}
	
	if (window.document.getElementById('buildcontainer') != null) {
		var buildSlide = new Fx.Slide('buildcontainer', {
			mode: 'vertical',
			transition: 'pow:out',
			duration: 500
		}).hide();
		
		$('buildtoggler').addEvent('click', function(e){
			e.stop();
			buildSlide.toggle();
		});
	}
	
	if (window.document.getElementById('dropcontainer') != null) {
		var dropSlide = new Fx.Slide('dropcontainer', {
			mode: 'vertical',
			transition: 'pow:out',
			duration: 500
		}).hide();
		
		$('droptoggler').addEvent('click', function(e){
			e.stop();
			dropSlide.toggle();
		});
	}
	
	if (window.document.getElementById('usedincontainer') != null) {
		var usedinSlide = new Fx.Slide('usedincontainer', {
			mode: 'vertical',
			transition: 'pow:out',
			duration: 500
		}).hide();
		
		$('usedintoggler').addEvent('click', function(e){
			e.stop();
			usedinSlide.toggle();
		});
	}	
	
	// This is used if you only want one info window to slide out at a time
	/*var TheAccordion = new Fx.Accordion(toggler, element, {
		alwaysHide: true, 
		height: true
		});*/
	
	});