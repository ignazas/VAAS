function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
window.flightEntity = {
    rows: function(form) {
	return $('.line', form);
    }
    ,isEmpty: function(row) {
	return !$('input[name^=price]', row).filter(function() { return $(this).val(); }).length;
    }
    , addRow: function(form, options) {
	var addCell = function(r, el, className) {
	    r.append(
		$('<td></td>').append(el.attr('name', className + '[' + window.flightEntity.rows(form).length + ']')).addClass(className)
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
	var date = $('<input type="date" />').val(today);
	addCell(row, date, 'date');
	options && options.date && date.val(options.date);

	//service
	var selectService = $('<select />').addClass('service').append($('<option value=""></option>'));
	$.each(window.flightEntity.getServices(), function(i, service) { selectService.append($('<option></option>').val(service['id']).text(service['title'])) });
	addCell(row, selectService, 'service_id');
	options && options.service_id && selectService.val(options.service_id);

	//student
	var selectStudent = $('<select />').addClass('user').append($('<option value=""></option>'));
	$.each(window.flightEntity.getUsers(), function(id, user) { selectStudent.append($('<option></option>').val(id).text(user['name'])) });
	addCell(row, selectStudent, 'payer');
	options && options.payer && selectStudent.val(options.payer);

	//pilot
	var selectPilot = $('<select />').addClass('user').append($('<option value=""></option>'));
	$.each(window.flightEntity.getUsers(), function(id, user) { selectPilot.append($('<option></option>').val(id).text(user['name'])) });
	addCell(row, selectPilot, 'pilot');
	options && options.pilot && selectPilot.val(options.pilot);

	//glider
	var selectGlider = $('<select />').addClass('glider').append($('<option value=""></option>'));
	$.each(window.flightEntity.getAircrafts(), function(i, glider) { selectGlider.append($('<option></option>').val(glider['callsign']).text(glider['model'])) });
	addCell(row, selectGlider, 'airplane_registration');
	options && options.airplane_registration && selectGlider.val(options.airplane_registration);

	//qty
	var qty = $('<input type="number" />').addClass('quantity');
	addCell(row, qty.val(1), 'amount');
	options && options.amount && qty.val(options.amount);

	//price
	var price = $('<input type="number" />');
	addCell(row, price, 'price');
	options && options.price && price.val(options.price);

	//actions
	addCell(row, $('<a href="#"></a>').addClass('btn btn-xs btn-danger remove').text('Pašalinti'), '');

	$('table tbody', form).append(row);

	jQuery($('select', form)).chosen({placeholder_text_single: 'Pasirinkite...', no_results_text: 'Nėra rezultatų', allow_single_deselect: true});
	jQuery(selectService.add(qty).add(selectStudent)).on('change keyup', function() {
	    var elements = $.grep(window.flightEntity.getServices(), function(el) { return el.id == selectService.val(); });
	    var user = selectStudent.val() && window.flightEntity.getUsers()[selectStudent.val()];
	    if (elements.length > 0) {
		price.val((elements[0].amount || 0) * (qty.val() || 1) * ((elements[0].discount_disabled && elements[0].discount_disabled != '0') || !user ? 1 : (100 - user['discount']) / 100));
	    }
	});
    }
    , deleteRow: function(form, row) {
	row.remove();
	window.flightEntity.updateNames(form);
    }
    , updateNames: function(form) {
	$('.line', form).each(function(i, el){
	    $('[name]', el).each(function(_i, _el) {
		$(_el).attr('name', $(_el).attr('name').replace(/\[\d+\]$/, '[' + i + ']'));
	    });
	});
    }
    , getUsers: function() {
	if (!window.flightEntity._users) {
	    $.ajax({
		'url': 'index.php?action=ajax&method=members',
		'data': {},
		'type': 'POST',
		async: false,
		'success': function (resp) {
		    window.flightEntity._users = $.parseJSON(resp);
		}
	    });
	}
	return window.flightEntity._users;
    }
    , getServices: function() {
	if (!window.flightEntity._services) {
	    $.ajax({
		'url': 'index.php?action=ajax&method=services',
		'data': {},
		'type': 'POST',
		async: false,
		'success': function (resp) {
		    window.flightEntity._services = $.parseJSON(resp);
		}
	    });
	}
	return window.flightEntity._services;
    }
    , getAircrafts: function() {
	if (!window.flightEntity._aircrafts) {
	    $.ajax({
		'url': 'index.php?action=ajax&method=aircrafts',
		'data': {},
		'type': 'POST',
		async: false,
		'success': function (resp) {
		    window.flightEntity._aircrafts = $.parseJSON(resp);
		}
	    });
	}
	return window.flightEntity._aircrafts;
    }
};

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

    $('form#flight-add')
    /* Auto add last line
	.on('change keyup', 'input', function() {
	    var form = $('form#flight-add');
	    var length = window.flightEntity.rows(form).length;

	    if (length > 0 &&
		!window.flightEntity.isEmpty(window.flightEntity.rows(form).last()))
		window.flightEntity.addRow(form);
	})
    */
	.on('click', '.add', function(event) {
	    var form = $('form#flight-add');
	    window.flightEntity.addRow(form);
	    event.preventDefault();
	})
	.on('click', '.remove', function(event) {
	    var form = $('form#flight-add');
	    window.flightEntity.deleteRow(form, $(this).parents('.line')[0]);
	    event.preventDefault();
	});

    jQuery($('select')).chosen({placeholder_text_single: 'Pasirinkite...', no_results_text: 'Nėra rezultatų', allow_single_deselect: true});


	jQuery('form#flight-edit select#service, form#flight-edit select#payer, form#flight-edit #amount').on('change keyup', function() {
	    var elements = $('form#flight-edit select#service_id option:selected');
	    var user = $('form#flight-edit select#payer option:selected');
	    var qty = $('form#flight-edit #amount');
	    if (elements.length && user.length && qty.length) {
		$('form#flight-edit #price').val((elements.attr('amount') || 0) * (qty.val() || 1) * ((elements.attr('discount_disabled') && elements.attr('discount_disabled') != '0') || !user.val() ? 1 : (100 - user.attr('discount')) / 100));
	    }
	});
});
