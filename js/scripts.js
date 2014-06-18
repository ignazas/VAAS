jQuery( document ).ready(function( $ ) {
    $('#reminder').click(function(event){
	event.preventDefault();
	
	var username = $('input[name=username]').val();
	
	if (username) {
            $.ajax({
		'url': 'index.php?action=ajax&method=login',
		'data': 'action=reset&username=' + username,
		'type': 'POST',
		'success': function (resp) {
                    alert(resp);
		}
            });
	} else {
            alert('Neįvestas vartotojo vardas');
	}
    });


    $('#dienos,.flight-plan')
	.on('click', 'a.add', function(event) {
            // Prevents the default action to be triggered. 
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');
        
            // Triggering bPopup when click event is fired
            $('#registruotis').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/event_add.php'+data, //Uses jQuery.load()
            });		
	
	})
	.on('click', 'a.registracija, a.talka, a.šventė, a.svečiai, a.kita', function(event) {
            // Prevents the default action to be triggered. 
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');
        
            // Triggering bPopup when click event is fired
            $('#registracija').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/event.php'+data, //Uses jQuery.load()
            });		
	})
	.on('click', 'a.add_day', function(event) {
            // Prevents the default action to be triggered. 
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');
        
            // Triggering bPopup when click event is fired
            $('#addDay').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/day_add.php'+data, //Uses jQuery.load()
            });
	})
	.on('click', 'a.show_day', function(event) {
            // Prevents the default action to be triggered. 
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');
        
            // Triggering bPopup when click event is fired
            $('#report').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/day.php'+data, //Uses jQuery.load()
            });				

	});

    $('#knopkes')
	.on('click', '#addAircraft', function(event) {
            // Prevents the default action to be triggered. 
            event.stopPropagation();
    	    event.preventDefault();
	    
            // Triggering bPopup when click event is fired
            $('#addAircraftDialog').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'views/aircrafts/add_aircraft.php', //Uses jQuery.load()
            });				

	});
});
