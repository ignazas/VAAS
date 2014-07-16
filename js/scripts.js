function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

jQuery(document).ready(function($) {
    $("a[rel='popover']").popover({});

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
            $('#registruotis').addClass('popup').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/event_add.php'+data //Uses jQuery.load()
            }, function() { $("a[rel='popover']", this).popover({}); });

	});

    $('#dienos,.flight-plan')
	.on('click', 'a.registracija, a.talka, a.šventė, a.svečiai, a.kita', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#registracija').addClass('popup').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/event.php'+data //Uses jQuery.load()
            }, function() { $("a[rel='popover']", this).popover({}); });
	});

    $('#dienos,.flight-plan')
	.on('click', 'a.add_day', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#addDay').addClass('popup').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/day_add.php'+data //Uses jQuery.load()
            }, function() { $("a[rel='popover']", this).popover({}); });
	});

    $('#dienos,.flight-plan')
	.on('click', 'a.show_day', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#report').addClass('popup').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'calendar/day.php'+data //Uses jQuery.load()
            }, function() { $("a[rel='popover']", this).popover({}); });

	});

    $('#knopkes')
	.on('click', '#addAircraft', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();

            // Triggering bPopup when click event is fired
            $('#addAircraftDialog').addClass('popup').bPopup({
		modalClose: true,
		opacity: 0.6,
		positionStyle: 'fixed', //'fixed' or 'absolute'
		fadeSpeed: 'slow', //can be a string ('slow'/'fast') or int
		followSpeed: 'slow', //can be a string ('slow'/'fast') or int
		loadUrl: 'views/aircrafts/add_aircraft.php' //Uses jQuery.load()
            }, function() { $("a[rel='popover']", this).popover({}); });

	});

    var flightEntity = {
	rows: function(form) {
	    return $('.line', form);
	}
	,isEmpty: function(row) {
	    return !$('input[name^=price]', row).filter(function() { return $(this).val(); }).length;
	}
	, addRow: function(form) {
	    var addCell = function(r, el, className) {
		r.append(
		    $('<td></td>').append(el.attr('name', className + '[' + flightEntity.rows(form).length + ']')).addClass(className)
		);
	    };

	    var row = $('<tr></tr>').addClass('line');

	    //date
	    var date = new Date();
	    var day = date.getDate();
	    var month = date.getMonth() + 1;
	    var year = date.getFullYear();
	    if (month < 10) month = "0" + month;
	    if (day < 10) day = "0" + day;
	    var today = year + "-" + month + "-" + day;
	    addCell(row, $('<input type="date" />').val(today), 'date');

	    //service
	    var selectService = $('<select />').append($('<option value=""></option>'));
	    $.each(flightEntity.getServices(), function(i, service) { selectService.append($('<option></option>').val(service['id']).text(service['title'])) });
	    addCell(row, selectService, 'service');

	    //pilot
	    var selectPilot = $('<select />').append($('<option value=""></option>'));
	    $.each(flightEntity.getUsers(), function(id, user) { selectPilot.append($('<option></option>').val(id).text(user['name'])) });
	    addCell(row, selectPilot, 'user instructor');

	    //student
	    var selectStudent = $('<select />').append($('<option value=""></option>'));
	    $.each(flightEntity.getUsers(), function(id, user) { selectStudent.append($('<option></option>').val(id).text(user['name'])) });
	    addCell(row, selectStudent, 'user student');

	    //glider
	    var selectGlider = $('<select />').append($('<option value=""></option>'));
	    $.each(flightEntity.getAircrafts(), function(i, glider) { selectGlider.append($('<option></option>').val(glider['callsign']).text(glider['model'])) });
	    addCell(row, selectGlider, 'glider');

	    //qty
	    var qty = $('<input type="number" />');
	    addCell(row, qty.val(1), 'quantity');

	    //price
	    var price = $('<input type="number" />');
	    addCell(row, price, 'price');

	    //actions
	    addCell(row, $('<a href="#"></a>').addClass('btn btn-xs btn-danger remove').text('Pašalinti'), '');

	    $('table tbody', form).append(row);

	    jQuery($('select', form)).chosen({placeholder_text_single: 'Pasirinkite...', no_results_text: 'Nėra rezultatų', allow_single_deselect: true});
	    jQuery(selectService.add(qty).add(selectStudent)).on('change keyup', function() {
		var elements = $.grep(flightEntity.getServices(), function(el) { return el.id == selectService.val(); });
		var user = selectStudent.val() && flightEntity.getUsers()[selectStudent.val()];
		if (elements.length > 0) {
		    price.val((elements[0].amount || 0) * (qty.val() || 1) * ((elements[0].discount_disabled && elements[0].discount_disabled != '0') || !user ? 1 : (100 - user['discount']) / 100) / 100);
		}
	    });
	}
	, deleteRow: function(form, row) {
	    row.remove();
	    flightEntity.updateNames(form);
	}
	, updateNames: function(form) {
	    $('.line', form).each(function(i, el){
		$('[name]', el).each(function(_i, _el) {
		    $(_el).attr('name', $(_el).attr('name').replace(/\[\d+\]$/, '[' + i + ']'));
		});
	    });
	}
	, getUsers: function() {
	    if (!flightEntity._users) {
		$.ajax({
		    'url': 'index.php?action=ajax&method=members',
		    'data': {},
		    'type': 'POST',
		    async: false,
		    'success': function (resp) {
			flightEntity._users = $.parseJSON(resp);
		    }
		});
	    }
	    return flightEntity._users;
	}
	, getServices: function() {
	    if (!flightEntity._services) {
		$.ajax({
		    'url': 'index.php?action=ajax&method=services',
		    'data': {},
		    'type': 'POST',
		    async: false,
		    'success': function (resp) {
			flightEntity._services = $.parseJSON(resp);
		    }
		});
	    }
	    return flightEntity._services;
	}
	, getAircrafts: function() {
	    if (!flightEntity._aircrafts) {
		$.ajax({
		    'url': 'index.php?action=ajax&method=aircrafts',
		    'data': {},
		    'type': 'POST',
		    async: false,
		    'success': function (resp) {
			flightEntity._aircrafts = $.parseJSON(resp);
		    }
		});
	    }
	    return flightEntity._aircrafts;
	}
    };
    $('form#flight-add')
    /* Auto add last line
	.on('change keyup', 'input', function() {
	    var form = $('form#flight-add');
	    var length = flightEntity.rows(form).length;

	    if (length > 0 &&
		!flightEntity.isEmpty(flightEntity.rows(form).last()))
		flightEntity.addRow(form);
	})
    */
	.on('click', '.add', function(event) {
	    var form = $('form#flight-add');
	    flightEntity.addRow(form);
	    event.preventDefault();
	})
	.on('click', '.remove', function(event) {
	    var form = $('form#flight-add');
	    flightEntity.deleteRow(form, $(this).parents('.line')[0]);
	    event.preventDefault();
	});

    if ($('form#flight-add').length && !flightEntity.rows($('form#flight-add')).length)
	flightEntity.addRow($('form#flight-add'));
});
