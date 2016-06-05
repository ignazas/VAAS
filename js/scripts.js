function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
window._ = {
    toArray: function(obj) {
	if ($.isArray(obj)) //object to array
	    return obj;
	else if ($.isPlainObject(obj)) //object to array
	    return $.map(obj, function(el) { return el; });
	else if (obj)
	    return [obj];
	else
	    return [];
    }
};
window.flightEntity = {
    rows: function(form) {
	return $('.line', form);
    }
    ,isEmpty: function(row) {
	return !$('input[name^=price]', row).filter(function() { return $(this).val(); }).length;
    }
    , addRow: function(form, options) {
	var addElement = function(c, el, className) {
	    c.append(el.attr('name', className + '[' + window.flightEntity.rows(form).length + ']')).addClass(className);
	    return el;
	};
	var addCell = function(r, el, className) {
	    var cell = $('<td></td>');
	    addElement(cell, el, className);
	    r.append(cell);
	    return cell;
	};

	var row = $('<tr></tr>').addClass('line');

	//date
	var dates = $('table tbody tr td.date input[type=date]', form);
	var date = null;
	if (dates.length > 0)
	    date = new Date(dates.last().val());
	else {
	    date = new Date();
	    date.setDate(date.getDate());
	}
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear();
	if (month < 10) month = "0" + month;
	if (day < 10) day = "0" + day;
	var today = year + "-" + month + "-" + day;
	var date = $('<input type="date" />').val(today);
	addCell(row, date, 'date').attr('rowspan', 2);
	options && options.date && date.val(options.date);

	//service
	var selectService = $('<select />').addClass('service').append($('<option value=""></option>'));
	$.each(window.flightEntity.getServices(), function(i, service) {
	    if (service['is_flight'])
		selectService.append($('<option></option>').val(service['id']).text(service['title']))
	});
	var cell = addCell(row, selectService, 'service_id').attr('rowspan', 2);
	var selectUnitAmount = addElement(cell, $('<input type="number" />'), 'amount_unit').addClass('amount_unit');
	cell.append($('<span></span>').addClass('service_unit').html(''));
	var updateService = function(el) {
	    var thisCell = $(el).parent('td')[0];
	    var elements = $.grep(window.flightEntity.getServices(), function(el) { return el.id == selectService.val(); });
	    if (elements.length > 0 && elements[0].amount_unit) {
		selectUnitAmount.show();
		$('span.service_unit', thisCell).html(' * ' + elements[0].unit).show();
	    } else {
		selectUnitAmount.hide();
		$('span.service_unit', thisCell).html('').hide();
	    }
	};
	options && options.service_id && selectService.val(options.service_id);
	options && options.amount_unit && selectUnitAmount.val(options.amount_unit);
	selectService.change(updateService);
	updateService(selectService);

	//student
	var selectStudent = $('<select />').addClass('user').append($('<option value=""></option>'));
	$.each(window.flightEntity.getUsers(), function(id, user) { selectStudent.append($('<option></option>').val(user['id']).text(user['name'])) });
	var cell = addCell(row, selectStudent, 'payer');
	options && options.payer && selectStudent.val(options.payer);

	//glider
	var selectGlider = $('<select />').addClass('glider').append($('<option value=""></option>'));
	$.each(window.flightEntity.getAircrafts(), function(i, glider) { selectGlider.append($('<option></option>').val(glider['id']).text(glider['name'])) });
	addCell(row, selectGlider, 'airplane_id').attr('colspan', 2);
	options && options.airplane_id && selectGlider.val(options.airplane_id);

	//price
	var price = $('<input type="number" />');
	addCell(row, price, 'price');
	options && options.price && price.val(options.price);

	var row2 = $('<tr></tr>').addClass('line line-2');

	//practices
	//var selectPractice = $('<select />').addClass('practice').append($('<option value=""></option>'));
	//$.each(window.flightEntity.getPractices(), function(i, practice) { selectPractice.append($('<option></option>').val(practice['id']).text(practice['name'])) });
	//addCell(row2, selectPractice, 'practice');
	//options && options.practice && selectPractice.val(options.practice);

	//instructor
	var selectPilot = $('<select />').addClass('user').append($('<option value=""></option>'));
	var instructors = $.grep(window.flightEntity.getUsers(), function(u) { return u.instructor == 1; });
	$.each(instructors, function(id, user) { selectPilot.append($('<option></option>').val(user['id']).text(user['name'])) });
	addCell(row2, selectPilot, 'instructor');
	options && options.instructor && selectPilot.val(options.instructor);

	//qty
	var qty = $('<input type="number" />').addClass('quantity');
	cell = addCell(row2, qty.val(1), 'amount');
	options && options.amount && qty.val(options.amount);

	//time
	var time = $('<input type="text" />').addClass('quantity');
	addCell(row2, time, 'time');
	options && options.time && time.val(options.time);

	//actions
	addCell(row2, $('<a href="#"></a>').addClass('btn btn-xs btn-danger remove').text('Pašalinti'), '');

	$('table tbody', form).append(row);
	$('table tbody', form).append(row2);

	jQuery($('select', form)).chosen({placeholder_text_single: 'Pasirinkite...', no_results_text: 'Nėra rezultatų', allow_single_deselect: true, search_contains: true});
	jQuery(selectService.add(qty).add(selectStudent).add(selectUnitAmount).add(time)).on('change keyup', function() {
	    var elements = $.grep(window.flightEntity.getServices(), function(el) { return el.id == selectService.val(); });
	    var user = selectStudent.val() && $.grep(window.flightEntity.getUsers(), function(el) { return el.id == selectStudent.val(); })[0];
	    if (elements.length > 0) {
		if (elements[0].default_duration) {
		    if (!time.val() || $(this)[0] == qty[0] || $(this)[0] == selectService[0]) {
			var t = (qty.val() || 1) * elements[0].default_duration;
			var head = Math.floor(t);
			var tail = t - head;
			t = head + ':' + ("00" + Math.round(tail * 60)).substr(-2, 2);
			time.val(t);
		    }
		}
		var amount = elements[0].is_price_for_duration
		    ? window.flightEntity.getTimeAsFloat(time.val())
		    : (qty.val() || 1);

		price.val(
		    Math.ceil(
			       amount *
			       ((elements[0].amount || 0) *
				((!elements[0].is_discount || elements[0].is_discount == '0') || !user ? 1 : (100 + parseInt(user['discount'])) / 100) +
				(elements[0].amount_unit || 0) *
				(selectUnitAmount.is(':visible') && selectUnitAmount.val() || 0))
			      ));
	    }
	});
    }
    , deleteRow: function(form, row) {
	$(row).prev().remove();
	$(row).remove();
	window.flightEntity.updateNames(form);
    }
    , updateNames: function(form) {
	$('.line', form).each(function(i, el){
	    $('[name]', el).each(function(_i, _el) {
		$(_el).attr('name', $(_el).attr('name').replace(/\[\d+\]$/, '[' + i + ']'));
	    });
	    $('[name]', $(el).next()).each(function(_i, _el) {
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
		    window.flightEntity._users = window._.toArray($.parseJSON(resp)).sort(function(a, b) {return a.name > b.name ? 1 : a.name < b.name ? -1 : 0; });
		}
	    });
	}
	return window.flightEntity._users;
    }
    , getPractices: function() {
	if (!window.flightEntity._practices) {
	    $.ajax({
		'url': 'index.php?action=ajax&method=practices',
		'data': {},
		'type': 'POST',
		async: false,
		'success': function (resp) {
		    window.flightEntity._practices = window._.toArray($.parseJSON(resp)).sort(function(a, b) {return a.name > b.name ? 1 : a.name < b.name ? -1 : 0; });
		}
	    });
	}
	return window.flightEntity._practices;
    }
    , getServices: function() {
	if (!window.flightEntity._services) {
	    $.ajax({
		'url': 'index.php?action=ajax&method=services',
		'data': {},
		'type': 'POST',
		async: false,
		'success': function (resp) {
		    window.flightEntity._services = window._.toArray($.parseJSON(resp)).sort(function(a, b) {return a.title > b.title ? 1 : a.title < b.title ? -1 : 0; });
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
		    window.flightEntity._aircrafts = window._.toArray($.parseJSON(resp)).sort(function(a, b) {return a.name > b.name ? 1 : a.name < b.name ? -1 : 0; });
		}
	    });
	}
	return window.flightEntity._aircrafts;
    }
    , getTimeAsFloat: function(time) {
	var t = time.replace(',', '.').replace(':', '.') || 0;
	var parts = (t + '').split('.');
	var value = parseInt(parts[parts.length - 1]) / 60;
	if (parts.length == 2)
	    value += parseInt(parts[0]);
	return value;
    }
};

jQuery(document).ready(function($) {
    $("a[rel='popover']").popover({});

    $('.practice .approve').click(function(event) {
	var el = $(this);
        $.ajax({
	    'url': 'index.php?action=practice&view=Approve&json=1&value=' + (el.is(':checked') ? 1 : 0) + '&id=' + el.attr('pid'),
	    'data': '',
	    'type': 'GET',
	    'success': function (resp) {
		if (resp) {
		} else {
		    if (el.is(':checked'))
			el.removeAttr('checked');
		    else
			el.attr('checked', true);
		    alert('Negalima pakeisti patvirtinimo');
		}
	    }
        });
    });

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

    var bPopupDefaultOptions = {
	modalClose: true,
	opacity: 0.6,
	positionStyle: 'fixed', //'fixed' or 'absolute'
	fadeSpeed: 'fast', //can be a string ('slow'/'fast') or int
	followSpeed: 'fast', //can be a string ('slow'/'fast') or int
	loadCallback: function(status) { if (status == 'error') window.location.reload(true); }
    };

    $('#dienos,.flight-plan')
	.on('click', 'a.add', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#registruotis').addClass('popup').bPopup(
		$.extend({loadUrl: 'calendar/event_add.php'+data}, bPopupDefaultOptions)
		, function() { $("a[rel='popover']", this).popover({}); }
	    );
	});

    $('#dienos,.flight-plan')
	.on('click', 'a.registracija, a.talka, a.šventė, a.svečiai, a.kita', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#registracija').addClass('popup').bPopup(
		$.extend({loadUrl: 'calendar/event.php'+data}, bPopupDefaultOptions)
		, function() { $("a[rel='popover']", this).popover({}); }
	    );
	});

    $('#dienos,.flight-plan')
	.on('click', 'a.add_day', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#addDay').addClass('popup').bPopup(
		$.extend({loadUrl: 'calendar/day_add.php'+data}, bPopupDefaultOptions)
		, function() { $("a[rel='popover']", this).popover({}); }
	    );
	});

    $('#dienos,.flight-plan')
	.on('click', 'a.show_day', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();
	    var data = $(this).attr('href');

            // Triggering bPopup when click event is fired
            $('#report').addClass('popup').bPopup(
		$.extend({loadUrl: 'calendar/day.php'+data}, bPopupDefaultOptions)
		, function() { $("a[rel='popover']", this).popover({}); }
	    );

	});

    $('#knopkes')
	.on('click', '#addAircraft', function(event) {
            // Prevents the default action to be triggered.
            event.stopPropagation();
    	    event.preventDefault();

            // Triggering bPopup when click event is fired
            $('#addAircraftDialog').addClass('popup').bPopup(
		$.extend({loadUrl: 'views/aircrafts/add_aircraft.php'}, bPopupDefaultOptions)
		, function() { $("a[rel='popover']", this).popover({}); }
	    );
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

    jQuery('select').chosen({placeholder_text_single: 'Pasirinkite...', no_results_text: 'Nėra rezultatų', allow_single_deselect: true, search_contains: true});


    jQuery('form#flight-edit select#service, form#flight-edit select#payer, form#flight-edit #amount, form#flight-edit .amount_unit, form#flight-edit .time').on('change keyup', function() {
	var row = $(this).closest('#flight-edit')[0];
	var selectService = $('select.service', row);
	var selectStudent = $('select.user', row);
	var price = $('.price input', row);
	var time = $('.time input', row);
	var qty = $('.amount input', row);
	var selectUnitAmount = $('.amount_unit input', row);

	var elements = $.grep(window.flightEntity.getServices(), function(el) { return el.id == selectService.val(); });
	var user = selectStudent.val() && $.grep(window.flightEntity.getUsers(), function(el) { return el.id == selectStudent.val(); })[0];
	if (elements.length > 0) {
	    if (elements[0].default_duration) {
		if (!time.val() || $(this)[0] == qty[0] || $(this)[0] == selectService[0]) {
		    var t = (qty.val() || 1) * elements[0].default_duration;
		    var head = Math.floor(t);
		    var tail = t - head;
		    t = head + ':' + ("00" + Math.round(tail * 60)).substr(-2, 2);
		    time.val(t);
		}
	    }
	    var amount = elements[0].is_price_for_duration
		? window.flightEntity.getTimeAsFloat(time.val())
		: (qty.val() || 1);
	    
	    price.val(
		Math.ceil(
			   amount *
			   ((elements[0].amount || 0) *
			    ((!elements[0].is_discount || elements[0].is_discount == '0') || !user ? 1 : (100 + parseInt(user['discount'])) / 100) +
			    (elements[0].amount_unit || 0) *
			    (selectUnitAmount.is(':visible') && selectUnitAmount.val() || 0))
			  ));
	}
    });

    jQuery('#practice-edit #practice_id, #practice-edit #count').change(function(){
	//var length = $(this).find(':selected').attr('data-length-string');
	var length = jQuery('#practice-edit #practice_id').find(':selected').attr('data-length-float');
	var count = jQuery('#practice-edit #count').val() || 1;
	if (length) {
	    var s = count * length;
	    var full = Math.round(s);
	    var rest = s - full;
	    length = full + ':' + ("00" + Math.round(rest * 60)).substr(-2, 2) ;
	    $('#practice-edit #time').val(length);
	}
    });
});
