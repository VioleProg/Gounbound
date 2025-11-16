/* FX.Slide */
/* toggle window for the login section */
/* Works with mootools-release-1.2 */
/* more info at http://demos.mootools.net/Fx.Slide */

window.addEvent('domready', function(){
		$('login').setStyle('height','auto');
	var mySlide = new Fx.Slide('login');  //starts the panel in closed state  

    $('toggleMenu').addEvent('click', function(e){
		e = new Event(e);
		mySlide.toggle();
		e.stop();
	});

    $('closeMenu').addEvent('click', function(e){
		e = new Event(e);
		mySlide.slideOut();
		e.stop();
	});
});