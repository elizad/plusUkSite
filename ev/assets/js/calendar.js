"use strict";

// Variable
var n_thisDate = 1;
var n_today = new Date();
var n_todaysDay = n_today.getDay() + 1;
var n_todaysDate = n_today.getDate();
var n_todaysMonth = n_today.getMonth() + 1;
var n_todaysYear = n_today.getFullYear();

var n_firstDate;
var n_firstDay;
var n_lastDate;
var n_numbDays;
var n_numevents = 0;
var n_daycounter = 0;
var n_calendarString = "";

var n_monthNum_full = n_todaysMonth;
var n_yearNum_full = n_todaysYear;
var n_monthNum_compact = n_todaysMonth;
var n_yearNum_compact = n_todaysYear;

var n_tiva_events = [];
var n_order_num = 0;

// Config variable
var n_wordDay;
var n_date_start;

function n_getShortText(text, num) {
	if(text) {
		// Get num of word
		var textArray = text.split(" ");
		if (textArray.length > num) {
			return textArray.slice(0, num).join(" ") + " ...";
		}
		return text;
	}
	return "";
}

function n_sortEventsByDate(a,b) {
	if (a.date < b.date) {
		return -1;
	} else if (a.date > b.date) {
		return 1;
	} else {
		return 0;
	}
}

function n_sortEventsByUpcoming(a,b) {
	var today_date = new Date(n_todaysYear, n_todaysMonth - 1, n_todaysDate);
	if (Math.abs(a.date - today_date.getTime()) < Math.abs(b.date - today_date.getTime())) {
		return -1;
	} else if (Math.abs(a.date - today_date.getTime()) > Math.abs(b.date - today_date.getTime())) {
		return 1;
	} else {
		return 0;
	}
}

function n_getEventsByTime(type) {
	var events = [];
	var today_date = new Date(n_todaysYear, n_todaysMonth - 1, n_todaysDate);
	for (var i = 0; i < n_tiva_events.length; i++) {
		if (type == 'upcoming') {
			if (n_tiva_events[i].date >= today_date.getTime()) {
				events.push(n_tiva_events[i]);
			}
		} else {
			if (n_tiva_events[i].date < today_date.getTime()) {
				events.push(n_tiva_events[i]);
			}
		}
	}
	return events;
}

// Change month or year on calendar
function n_changedate(btn, layout) {
	if (btn == "prevyr") {
		eval("n_yearNum_" + layout + "--;");
	} else if (btn == "nextyr") {
		eval("n_yearNum_" + layout + "++;");
	} else if (btn == "prevmo") {
		eval("n_monthNum_" + layout + "--;");
	} else if (btn == "nextmo") {
		eval("n_monthNum_" + layout + "++;");
	} else if (btn == "current") {
		eval("n_monthNum_" + layout + " = n_todaysMonth;");
		eval("n_yearNum_" + layout + " = n_todaysYear;");
	}

	if (n_monthNum_full == 0) {
		n_monthNum_full = 12;
		n_yearNum_full--;
	} else if (n_monthNum_full == 13) {
		n_monthNum_full = 1;
		n_yearNum_full++
	}

	if (n_monthNum_compact == 0) {
		n_monthNum_compact = 12;
		n_yearNum_compact--;
	} else if (n_monthNum_compact == 13) {
		n_monthNum_compact = 1;
		n_yearNum_compact++
	}

	// Get first day and number days of month
	eval("n_firstDate = new Date(n_yearNum_" + layout + ", n_monthNum_" + layout + " - 1, 1);");
	if (n_date_start == 'sunday') {
		n_firstDay = n_firstDate.getDay() + 1;
	} else {
		n_firstDay = (n_firstDate.getDay() == 0) ? 7 : n_firstDate.getDay();
	}
	eval("n_lastDate = new Date(n_yearNum_" + layout + ", n_monthNum_" + layout + ", 0);");
	n_numbDays = n_lastDate.getDate();

	// Create calendar
	eval("n_createCalendar(layout, n_firstDay, n_numbDays, n_monthNum_" + layout + ", n_yearNum_" + layout + ");");

	return;
}

// Create calendar
function n_createCalendar(layout, n_firstDay, n_numbDays, n_monthNum, n_yearNum) {
	n_calendarString = '';
	n_daycounter = 0;

	n_calendarString += '<table class=\"calendar-table table table-bordered\">';
	n_calendarString += '<tbody>';
	n_calendarString += '<tr>';
	if (layout == 'full') {
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'prevyr\', \'full\')\">« ' + n_prev_year + '<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'prevmo\', \'full\')\">« ' + n_prev_month + '<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-title\" colspan=\"3\"><i class=\"fa fa-calendar\"><\/i>' + n_wordMonth[n_monthNum - 1] + '&nbsp;' + n_yearNum + '<\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'nextmo\', \'full\')\">' + n_next_month + ' »<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'nextyr\', \'full\')\">' + n_next_year + ' »<\/a><\/th>';
	} else {
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'prevyr\', \'compact\')\">«<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'prevmo\', \'compact\')\">«<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-title\" colspan=\"3\">' + n_wordMonth[n_monthNum - 1] + '&nbsp;' + n_yearNum + '<\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'nextmo\', \'compact\')\">»<\/a><\/th>';
		n_calendarString += '<th class=\"calendar-btn\"><a onClick=\"n_changedate(\'nextyr\', \'compact\')\">»<\/a><\/th>';
	}
	n_calendarString += '<\/tr>';

	n_calendarString += '<tr class="day">';
	for (var m = 0; m < n_wordDay.length; m++) {
		n_calendarString += '<td>' + n_wordDay[m].substring(0, 3) + '<\/td>';
	}
	n_calendarString += '<\/tr>';

	n_thisDate == 1;
	var n_daycounter_s = '';

	for (var i = 1; i <= 6; i++) {
		var k = (i - 1) * 7 + 1;
		if (k < (n_firstDay + n_numbDays)) {
			n_calendarString += '<tr>';
			for (var x = 1; x <= 7; x++) {
				n_daycounter = (n_thisDate - n_firstDay) + 1;
				n_thisDate++;
				if ((n_daycounter > n_numbDays) || (n_daycounter < 1)) {
					n_calendarString += '<td class=\"calendar-day-blank\">&nbsp;<\/td>';
				} else {
					// Saturday or Sunday
					if (n_date_start == 'sunday') {
						if ((x == 1) || (x == 7)) {
							n_daycounter_s = '<span class=\"calendar-day-weekend\">' + n_daycounter + '</span>';
						} else {
							n_daycounter_s = n_daycounter;
						}
					} else {
						if ((x == 6) || (x == 7)) {
							n_daycounter_s = '<span class=\"calendar-day-weekend\">' + n_daycounter + '</span>';
						} else {
							n_daycounter_s = n_daycounter;
						}
					}

					if ((n_todaysDate == n_daycounter) && (n_todaysMonth == n_monthNum)) {
						n_calendarString += '<td class=\"calendar-day-normal calendar-day-today\">';
					} else {
						n_calendarString += '<td class=\"calendar-day-normal\">';
					}
						if (n_checkEvents(n_daycounter, n_monthNum, n_yearNum)) {
							if (layout == 'full') {
								n_calendarString += '<div class=\"calendar-day-event\">';
							} else {
								n_calendarString += '<div class=\"calendar-day-event\" onmouseover=\"n_showTooltip(0, \'compact\', ' + n_daycounter + ', ' + n_monthNum + ', ' + n_yearNum + ', this)\" onmouseout=\"n_clearTooltip(\'compact\', this)\" onclick=\"n_showEventDetail(0, \'compact\', '  + n_daycounter + ', ' + n_monthNum + ', ' + n_yearNum + ')\">';
							}
								n_calendarString += n_daycounter_s;

								// Get events of day
								if (layout == 'full') {
									var events = n_getEvents(n_daycounter, n_monthNum, n_yearNum);
									for (var t = 0; t < events.length; t++) {
										if (typeof events[t] != "undefined") {
											var color = events[t].id % 4 + 1;
											var event_class = "one-day";
											if (events[t].first_day && !events[t].last_day) {
												event_class = "first-day";
											} else if (events[t].last_day && !events[t].first_day) {
												event_class = "last-day";
											} else if (!events[t].first_day && !events[t].last_day) {
												event_class = "middle-day";
											}

											n_calendarString += '<div class=\"calendar-event-name ' + event_class + ' color-' + color + '\" id=\"' + events[t].id + '\" onmouseover=\"n_showTooltip(' + events[t].id + ', \'full\', ' + n_daycounter + ', ' + n_monthNum + ', ' + n_yearNum + ', this)\" onmouseout=\"n_clearTooltip(\'full\', this)\" onclick=\"n_showEventDetail(' + events[t].id + ', \'full\', ' + n_daycounter + ', ' + n_monthNum + ', ' + n_yearNum + ')\"><span class="event-name">' + n_getShortText(events[t].name, 2) + '</span><\/div>';
										} else {
											var event_fake;
											if (typeof events[t+1] != "undefined") {
												if (typeof n_tiva_events[events[t+1].id - 1] != "undefined") {
													event_fake = n_getShortText(n_tiva_events[events[t+1].id - 1].name, 2);
												} else {
													event_fake = "no-name";
												}
											} else {
												event_fake = "no-name";
											}
											n_calendarString += '<div class=\"calendar-event-name no-name\">' + event_fake + '</div>';
										}
									}
								} else {
									n_calendarString += '<span class="calendar-event-mark"></span>';
								}

								// Tooltip
								n_calendarString += '<div class=\"tiva-event-tooltip\"><\/div>';
							n_calendarString += '<\/div>';
						} else {
							n_calendarString += n_daycounter_s;
						}
					n_calendarString += '<\/td>';
				}
			}
			n_calendarString += '<\/tr>';
		}
	}
	n_calendarString += '</tbody>';
	n_calendarString += '</table>';

	if (layout == 'full') {
		jQuery('.tiva-calendar-full').html(n_calendarString);
	} else {
		jQuery('.tiva-calendar-compact').html(n_calendarString);
	}
	n_thisDate = 1;
}

// Check day has events or not
function n_checkEvents(day, month, year) {
	n_numevents = 0;
	var date_check = new Date(year, Number(month) - 1, day);
	for (var i = 0; i < n_tiva_events.length; i++) {
		var start_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, n_tiva_events[i].day);
		var end_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, Number(n_tiva_events[i].day) + Number(n_tiva_events[i].duration) - 1);
		if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
			n_numevents++;
		}
	}

	if (n_numevents == 0) {
		return false;
	} else {
		return true;
	}
}

function n_getOrderNumber(id, day, month, year) {
	var date_check = new Date(year, Number(month) - 1, day);
	var events = [];
	for (var i = 0; i < n_tiva_events.length; i++) {
		var start_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, n_tiva_events[i].day);
		var end_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, Number(n_tiva_events[i].day) + Number(n_tiva_events[i].duration) - 1);
		if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
			var first_day = (start_date.getTime() == date_check.getTime()) ? true : false;
			var event = {id:n_tiva_events[i].id, name:n_tiva_events[i].name, day:n_tiva_events[i].day, month:n_tiva_events[i].month, year:n_tiva_events[i].year, first_day:first_day};
			events.push(event);
		}
	}

	if (events.length) {
		if (events[0].id == id) {
			var num = n_order_num;
			n_order_num = 0;
			return num;
		} else {
			n_order_num++;
			for (var j = 0; j < events.length; j++) {
				if (events[j].id == id) {
					return n_getOrderNumber(events[j-1].id, events[j-1].day, events[j-1].month, events[j-1].year);
				}
			}

		}
	}

	return 0;
}

// Get events of day
function n_getEvents(day, month, year) {
	var n = 0;
	var date_check = new Date(year, Number(month) - 1, day);
	var events = [];
	for (var i = 0; i < n_tiva_events.length; i++) {
		var start_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, n_tiva_events[i].day);
		var end_date = new Date(n_tiva_events[i].year, Number(n_tiva_events[i].month) - 1, Number(n_tiva_events[i].day) + Number(n_tiva_events[i].duration) - 1);
		if ((start_date.getTime() <= date_check.getTime()) && (date_check.getTime() <= end_date.getTime())) {
			var first_day = (start_date.getTime() == date_check.getTime()) ? true : false;
			var last_day = (end_date.getTime() == date_check.getTime()) ? true : false;
			var event = {id:n_tiva_events[i].id, name:n_tiva_events[i].name, first_day:first_day, last_day:last_day};

			if (!first_day) {
				n = n_getOrderNumber(n_tiva_events[i].id, n_tiva_events[i].day, n_tiva_events[i].month, n_tiva_events[i].year);
			}

			events[n] = event;
			n++;
		}
	}

	return events;
}

// Show tooltip when mouse over
function n_showTooltip(id, layout, day, month, year, el) {
	if (layout == 'full') {
		// Image
		if (n_tiva_events[id].image) {
			var event_image = '<img src="' + n_tiva_events[id].image + '" alt="' + n_tiva_events[id].name + '" />';
		} else {
			var event_image = '';
		}

		// Time
		if (n_tiva_events[id].time || n_tiva_events[id].end_time) {
			var event_time = '<div class="event-time">';
				event_time += n_tiva_events[id].time;
				if (n_tiva_events[id].end_time) {
					event_time += ' - ' + n_tiva_events[id].end_time;
				}
			event_time += '</div>';
		} else {
			var event_time = '';
		}

		// Change position of tooltip
		var index = jQuery(el).parent().find('.calendar-event-name').index(el);
		var count = jQuery(el).parent().find('.calendar-event-name').length;
		var bottom = 32 + ((count - index - 1) * 25);
		jQuery(el).parent().find('.tiva-event-tooltip').css('bottom', bottom + 'px');

		jQuery(el).parent().find('.tiva-event-tooltip').html('<div class="event-tooltip-item">'
																	+ event_time
																	+ '<div class="event-name">' + n_tiva_events[id].name + '</div>'
																	+ '<div class="event-image">' + event_image + '</div>'
																	+ '<div class="event-desc">' + n_getShortText(n_tiva_events[id].intro, 10) + '</div>'
																+ '</div>');
		jQuery(el).parent().find('.tiva-event-tooltip').css('opacity', '1');
		jQuery(el).parent().find('.tiva-event-tooltip').css('-webkit-transform', 'translate3d(0,0,0) rotate3d(0,0,0,0)');
		jQuery(el).parent().find('.tiva-event-tooltip').css('transform', 'translate3d(0,0,0) rotate3d(0,0,0,0)');
	} else {
		jQuery(el).find('.tiva-event-tooltip').html('');
		var events = n_getEvents(day, month, year);
		for (var i = 0; i < events.length; i++) {
			if (typeof events[i] != "undefined") {
				// Image
				if (n_tiva_events[events[i].id].image) {
					var event_image = '<img src="' + n_tiva_events[events[i].id].image + '" alt="' + n_tiva_events[events[i].id].name + '" />';
				} else {
					var event_image = '';
				}

				// Time
				if (n_tiva_events[events[i].id].time || n_tiva_events[events[i].id].end_time) {
					var event_time = '<div class="event-time">';
						event_time += n_tiva_events[events[i].id].time;
						if (n_tiva_events[events[i].id].end_time) {
							event_time += ' - ' + n_tiva_events[events[i].id].end_time;
						}
					event_time += '</div>';
				} else {
					var event_time = '';
				}

				jQuery(el).find('.tiva-event-tooltip').append('<div class="event-tooltip-item">'
																	+ event_time
																	+ '<div class="event-name">' + n_tiva_events[events[i].id].name + '</div>'
																	+ '<div class="event-image">' + event_image + '</div>'
																	+ '<div class="event-desc">' + n_getShortText(n_tiva_events[events[i].id].intro, 10) + '</div>'
																+ '</div>');
			}
		}
		jQuery(el).find('.tiva-event-tooltip').css('opacity', '1');
		jQuery(el).find('.tiva-event-tooltip').css('-webkit-transform', 'translate3d(0,0,0) rotate3d(0,0,0,0)');
		jQuery(el).find('.tiva-event-tooltip').css('transform', 'translate3d(0,0,0) rotate3d(0,0,0,0)');
	}
}

// Clear tooltip when mouse out
function n_clearTooltip(layout, el) {
	if (layout == 'full') {
		jQuery(el).parent().find('.tiva-event-tooltip').css('opacity', '0');
		jQuery(el).parent().find('.tiva-event-tooltip').css('-webkit-transform', 'translate3d(0,-10px,0)');
		jQuery(el).parent().find('.tiva-event-tooltip').css('transform', 'translate3d(0,-10px,0)');
	} else {
		jQuery(el).find('.tiva-event-tooltip').css('opacity', '0');
		jQuery(el).find('.tiva-event-tooltip').css('-webkit-transform', 'translate3d(0,-10px,0)');
		jQuery(el).find('.tiva-event-tooltip').css('transform', 'translate3d(0,-10px,0)');
	}
}

// Show event detail
function n_showEventList(layout, filter, max_events, show_title) {
	jQuery('.tiva-event-list-' + layout).html('');

	var time_filter;
	if (filter == 'upcoming') {
		time_filter = new Array('upcoming');
	} else if (filter == 'past') {
		time_filter = new Array('past');
	} else {
		time_filter = new Array('upcoming', 'past');
	}

	var count = 1;
	for (var t = 0; t < time_filter.length; t++) {
		var title = (time_filter[t] == 'upcoming') ? 'Upcoming events' : 'Past events';

		var tiva_list_events = n_getEventsByTime(time_filter[t]);
		tiva_list_events.sort(n_sortEventsByUpcoming);

		if (show_title == 'show') {
			jQuery('.tiva-event-list-' + layout).append('<div class="list-title ' + filter + ' ' + time_filter[t] + '">' + title + '</div>');
		}

		for (var i = 0; i < tiva_list_events.length; i++) {
			if (count <= max_events) {
				// Image
				if (tiva_list_events[i].image) {
					var event_image = '<img src="' + tiva_list_events[i].image + '" alt="' + tiva_list_events[i].name + '" />';
				} else {
					var event_image = '';
				}

				// Start date
				var event_start_date = tiva_list_events[i].start_date;

				// End date
				var event_end_date = '';
				if (tiva_list_events[i].duration > 1) {
					event_end_date = ' - ' + tiva_list_events[i].end_date;
				}

				// Time
				var event_time = '';
				if (tiva_list_events[i].time || tiva_list_events[i].end_time) {
					event_time += '<i class="fa fa-clock-o"></i>';
					if (tiva_list_events[i].end_time) {
						event_time += tiva_list_events[i].time + ' - ' + tiva_list_events[i].end_time;
					} else {
						event_time += tiva_list_events[i].time;
					}
				}

				if (layout == 'full') {
					jQuery('.tiva-event-list-full').append('<div class="event-item">'
																+ '<div class="event-item-left pull-left">'
																	+ '<div class="event-image link" onclick="n_showEventDetail(' + tiva_list_events[i].id + ', \'full\', 0, 0, 0)">' + event_image + '</div>'
																+ '</div>'
																+ '<div class="event-item-right pull-left">'
																	+ '<div class="event-name link" onclick="n_showEventDetail(' + tiva_list_events[i].id + ', \'full\', 0, 0, 0)">' + tiva_list_events[i].name + '</div>'
																	+ '<div class="event-date"><i class="fa fa-calendar"></i>' + event_start_date + event_end_date + '</div>'
																	+ '<div class="event-time">' + event_time + '</div>'
																	+ '<div class="event-desc">' + n_getShortText(tiva_list_events[i].intro, 25) + '</div>'
																+ '</div>'
															+ '</div>'
															+ '<div class="cleardiv"></div>');
				} else {
					jQuery('.tiva-event-list-compact').append('<div class="event-item">'
																	+ '<div class="event-image link" onclick="n_showEventDetail(' + tiva_list_events[i].id + ', \'compact\', 0, 0, 0)">' + event_image + '</div>'
																	+ '<div class="event-name link" onclick="n_showEventDetail(' + tiva_list_events[i].id + ', \'compact\', 0, 0, 0)">' + tiva_list_events[i].name + '</div>'
																	+ '<div class="event-date"><i class="fa fa-calendar"></i>' + event_start_date + event_end_date + '</div>'
																	+ '<div class="event-time">' + event_time + '</div>'
																	+ '<div class="event-desc">' + n_getShortText(tiva_list_events[i].intro, 15) + '</div>'
																+ '</div>'
																+ '<div class="cleardiv"></div>');
				}

				count++;
			}
		}
	}
}

// Show event detail
function n_showEventDetail(id, layout, day, month, year) {
	jQuery('.facebook-events-calendar.' + layout + ' .back-calendar').show();
	jQuery('.facebook-events-calendar.' + layout + ' .tiva-calendar').hide();
	jQuery('.facebook-events-calendar.' + layout + ' .tiva-event-list').hide();
	jQuery('.facebook-events-calendar.' + layout + ' .tiva-event-detail').fadeIn(1500);

	jQuery('.facebook-events-calendar.' + layout + ' .list-view').removeClass('active');
	jQuery('.facebook-events-calendar.' + layout + ' .calendar-view').removeClass('active');

	if (layout == 'full') {
		// Image
		if (n_tiva_events[id].image) {
			var event_image = '<img src="' + n_tiva_events[id].image + '" alt="' + n_tiva_events[id].name + '" />';
		} else {
			var event_image = '';
		}

		// Start date
		var event_start_date = n_tiva_events[id].start_date;

		// End date
		var event_end_date = '';
		if (n_tiva_events[id].duration > 1) {
			event_end_date = ' - ' + n_tiva_events[id].end_date;
		}

		// Time
		var event_time = '';
		if (n_tiva_events[id].time || n_tiva_events[id].end_time) {
			event_time += '<i class="fa fa-clock-o"></i>';
			if (n_tiva_events[id].end_time) {
				event_time += n_tiva_events[id].time + ' - ' + n_tiva_events[id].end_time;
			} else {
				event_time += n_tiva_events[id].time;
			}
		}

		// Location
		if (n_tiva_events[id].location) {
			var event_location = '<i class="fa fa-map-marker"></i>' + n_tiva_events[id].location;
		} else {
			var event_location = '';
		}

		// Description
		if (n_tiva_events[id].description) {
			var event_desc = '<div class="event-desc">' + n_tiva_events[id].description + '</div>';
		} else {
			var event_desc = '';
		}

		// Map
		if (n_tiva_events[id].latitude && n_tiva_events[id].longitude) {
			var event_map = '<div class="event-map"><iframe width="100%" height="300px" frameborder="0" src="https://maps.google.com/maps?q=' + n_tiva_events[id].latitude + ',' + n_tiva_events[id].longitude + '&hl=es;z=18&amp;output=embed"></iframe></div>';
		} else {
			var event_map = '';
		}

		jQuery('.tiva-event-detail-full').html('<div class="event-item">'
													+ '<div class="event-image">' + event_image + '</div>'
													+ '<div class="event-name">' + n_tiva_events[id].name + '</div>'
													+ '<div class="event-date"><i class="fa fa-calendar"></i>' + event_start_date + event_end_date + '</div>'
													+ '<div class="event-time">' + event_time + '</div>'
													+ '<div class="event-location">' + event_location + '</div>'
													+ event_desc
													+ '<div class="event-link"><a class="btn btn-primary" href="https://www.facebook.com/events/' + n_tiva_events[id].event_id + '" target="_blank"><i class="fa fa-eye"></i>' + view_on_facebook + '</a></div>'
													+ event_map
												+ '</div>');
	} else {
		jQuery('.tiva-event-detail-compact').html('');
		if (day && month && year) {
			var events = n_getEvents(day, month, year);
		} else {
			var events = [{id:id}];
		}
		for (var i = 0; i < events.length; i++) {
			if (typeof events[i] != "undefined") {
				// Image
				if (n_tiva_events[events[i].id].image) {
					var event_image = '<img src="' + n_tiva_events[events[i].id].image + '" alt="' + n_tiva_events[events[i].id].name + '" />';
				} else {
					var event_image = '';
				}

				// Start date
				var event_start_date = n_tiva_events[events[i].id].start_date;

				// End date
				var event_end_date = '';
				if (n_tiva_events[id].duration > 1) {
					event_end_date = ' - ' + n_tiva_events[events[i].id].end_date;
				}

				// Time
				var event_time = '';
				if (n_tiva_events[events[i].id].time || n_tiva_events[events[i].id].end_time) {
					event_time += '<i class="fa fa-clock-o"></i>';
					if (n_tiva_events[events[i].id].end_time) {
						event_time += n_tiva_events[events[i].id].time + ' - ' + n_tiva_events[events[i].id].end_time;
					} else {
						event_time += n_tiva_events[events[i].id].time;
					}
				}

				// Location
				if (n_tiva_events[events[i].id].location) {
					var event_location = '<i class="fa fa-map-marker"></i>' + n_tiva_events[events[i].id].location;
				} else {
					var event_location = '';
				}

				// Description
				if (n_tiva_events[events[i].id].description) {
					var event_desc = '<div class="event-desc">' + n_tiva_events[events[i].id].description + '</div>';
				} else {
					var event_desc = '';
				}

				// Map
				if (n_tiva_events[events[i].id].latitude && n_tiva_events[events[i].id].longitude) {
					var event_map = '<div class="event-map"><iframe width="100%" height="300px" frameborder="0" src="https://maps.google.com/maps?q=' + n_tiva_events[events[i].id].latitude + ',' + n_tiva_events[events[i].id].longitude + '&hl=es;z=18&amp;output=embed"></iframe></div>';
				} else {
					var event_map = '';
				}

				jQuery('.tiva-event-detail-compact').append('<div class="event-item">'
																	+ '<div class="event-image">' + event_image + '</div>'
																	+ '<div class="event-name">' + n_tiva_events[events[i].id].name + '</div>'
																	+ '<div class="event-date"><i class="fa fa-calendar"></i>' + event_start_date + event_end_date + '</div>'
																	+ '<div class="event-time">' + event_time + '</div>'
																	+ '<div class="event-location">' + event_location + '</div>'
																	+ event_desc
																	+ '<div class="event-link"><a href="https://www.facebook.com/events/' + n_tiva_events[events[i].id].event_id + '" target="_blank"><i class="fa fa-eye"></i>' + view_on_facebook + '</a></div>'
																	+ event_map
																+ '</div>');
			}
		}
	}
}

jQuery(document).ready(function() {
	// Set compact layout on mobile
	if (screen.width <= 480) {
		if (jQuery('.facebook-events-calendar.full').length) {
			jQuery('.facebook-events-calendar.full').attr('class', 'facebook-events-calendar compact');
		}
	}

	// Init calendar full
	if (jQuery('.facebook-events-calendar.full').length) {
		jQuery('.facebook-events-calendar.full').html('<div class="events-calendar-bar">'
															+ '<span class="btn calendar-view active"><i class="fa fa-calendar"></i>' + n_calendar_view + '</span>'
															+ '<span class="btn list-view"><i class="fa fa-list"></i>' + n_list_view + '</span>'
															+ '<span class="btn back-calendar pull-right active"><i class="fa fa-caret-left"></i>' + n_back + '</span>'
														+ '</div>'
														+ '<div class="cleardiv"></div>'
														+ '<div class="facebook-events-calendar-wrap">'
															+ '<div class="tiva-calendar-full tiva-calendar"></div>'
															+ '<div class="tiva-event-list-full tiva-event-list"></div>'
															+ '<div class="tiva-event-detail-full tiva-event-detail"></div>'
														+ '</div>');
	}

	// Init calendar compact
	if (jQuery('.facebook-events-calendar.compact').length) {
		jQuery('.facebook-events-calendar.compact').html('<div class="events-calendar-bar">'
															+ '<span class="btn calendar-view active"><i class="fa fa-calendar"></i>' + n_calendar_view + '</span>'
															+ '<span class="btn list-view"><i class="fa fa-list"></i>' + n_list_view + '</span>'
															+ '<span class="btn back-calendar pull-right active"><i class="fa fa-caret-left"></i>' + n_back + '</span>'
														+ '</div>'
														+ '<div class="cleardiv"></div>'
														+ '<div class="facebook-events-calendar-wrap">'
															+ '<div class="tiva-calendar-compact tiva-calendar"></div>'
															+ '<div class="tiva-event-list-compact tiva-event-list"></div>'
															+ '<div class="tiva-event-detail-compact tiva-event-detail"></div>'
														+ '</div>');
	}

	// Show - Hide view
	jQuery('.facebook-events-calendar .back-calendar').hide();
	jQuery('.tiva-event-list').hide();
	jQuery('.tiva-event-detail').hide();

	jQuery('.facebook-events-calendar').each(function(index) {
		// Hide switch button
		var switch_button = (typeof jQuery(this).attr('data-switch') != "undefined") ? jQuery(this).attr('data-switch') : 'show';
		if (switch_button == 'hide') {
			jQuery(this).find('.calendar-view').hide();
			jQuery(this).find('.list-view').hide();

			// Change css of button back
			jQuery(this).find('.events-calendar-bar').css('position', 'relative');
			jQuery(this).find('.back-calendar').css({"position": "absolute", "margin-top": "15px", "right": "15px"});
			jQuery(this).find('.tiva-event-detail').css('padding-top', '60px');
		}
	});

	// Set n_wordDay
	n_date_start = (typeof jQuery('.facebook-events-calendar').attr('data-start') != "undefined") ? jQuery('.facebook-events-calendar').attr('data-start') : 'sunday';
	if (n_date_start == 'sunday') {
		n_wordDay = new Array(n_wordDay_sun, n_wordDay_mon, n_wordDay_tue, n_wordDay_wed, n_wordDay_thu, n_wordDay_fri, n_wordDay_sat);
	} else { // Start with Monday
		n_wordDay = new Array(n_wordDay_mon, n_wordDay_tue, n_wordDay_wed, n_wordDay_thu, n_wordDay_fri, n_wordDay_sat, n_wordDay_sun);
	}

	var time_format = jQuery('.facebook-events-calendar').attr('data-time') ? jQuery('.facebook-events-calendar').attr('data-time') : '24';
	var date_format = jQuery('.facebook-events-calendar').attr('data-date') ? jQuery('.facebook-events-calendar').attr('data-date') : 'l, d F Y';

	// Get events
	jQuery.ajax({
		url: 'events.php',
		dataType: 'json',
		type: 'post',
		data: {
			time_format:time_format,
			date_format:date_format
		},
		beforeSend : function(){
			jQuery('.tiva-calendar').html('<div class="loading"><img src="assets/images/loading.gif" /></div>');
		},
		success: function(data) {
			for (var i = 0; i < data.length; i++) {
				var event_date = new Date(data[i].year, Number(data[i].month) - 1, data[i].day);
				data[i].date = event_date.getTime();
				n_tiva_events.push(data[i]);
			}

			// Sort events by date
			n_tiva_events.sort(n_sortEventsByDate);

			for (var j = 0; j < n_tiva_events.length; j++) {
				n_tiva_events[j].id = j;
				if (!n_tiva_events[j].duration) {
					n_tiva_events[j].duration = 1;
				}
			}

			// Create calendar
			n_changedate('current', 'full');
			n_changedate('current', 'compact');

			jQuery('.facebook-events-calendar').each(function(index) {
				// Initial view
				var initial_view = (typeof jQuery(this).attr('data-view') != "undefined") ? jQuery(this).attr('data-view') : 'calendar';
				if (initial_view == 'list') {
					jQuery(this).find('.list-view').click();
				}
			});
		}
	});

	// Click - Calendar view btn
	jQuery('.facebook-events-calendar .calendar-view').on('click', function(e) {
		jQuery(this).closest('.facebook-events-calendar').find('.back-calendar').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-list').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-detail').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-calendar').fadeIn(1500);

		jQuery(this).closest('.facebook-events-calendar').find('.list-view').removeClass('active');
		jQuery(this).closest('.facebook-events-calendar').find('.calendar-view').addClass('active');
	});

	// Click - List view btn
	jQuery('.facebook-events-calendar .list-view').on('click', function(e) {
		jQuery(this).closest('.facebook-events-calendar').find('.back-calendar').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-calendar').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-detail').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-list').fadeIn(1500);

		jQuery(this).closest('.facebook-events-calendar').find('.calendar-view').removeClass('active');
		jQuery(this).closest('.facebook-events-calendar').find('.list-view').addClass('active');

		var layout = jQuery(this).closest('.facebook-events-calendar').attr('class');
		var filter = jQuery(this).closest('.facebook-events-calendar').attr('data-list') ? jQuery(this).closest('.facebook-events-calendar').attr('data-list') : 'all';
		var max_events = jQuery(this).closest('.facebook-events-calendar').attr('data-events') ? jQuery(this).closest('.facebook-events-calendar').attr('data-events') : 1000;
		var show_title = jQuery(this).closest('.facebook-events-calendar').attr('data-title') ? jQuery(this).closest('.facebook-events-calendar').attr('data-title') : 'show';

		if (layout.indexOf('full') != -1){
			n_showEventList('full', filter, max_events, show_title);
		} else {
			n_showEventList('compact', filter, max_events, show_title);
		}
	});

	// Click - Back calendar btn
	jQuery('.facebook-events-calendar .back-calendar').on('click', function(e) {
		jQuery(this).closest('.facebook-events-calendar').find('.back-calendar').hide();
		jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-detail').hide();

		var initial_view = (typeof jQuery(this).closest('.facebook-events-calendar').attr('data-view') != "undefined") ? jQuery(this).closest('.facebook-events-calendar').attr('data-view') : 'calendar';
		if (initial_view == 'calendar') {
			jQuery(this).closest('.facebook-events-calendar').find('.tiva-calendar').fadeIn(1500);

			jQuery(this).closest('.facebook-events-calendar').find('.list-view').removeClass('active');
			jQuery(this).closest('.facebook-events-calendar').find('.calendar-view').addClass('active');
		} else {
			jQuery(this).closest('.facebook-events-calendar').find('.tiva-event-list').fadeIn(1500);

			jQuery(this).closest('.facebook-events-calendar').find('.calendar-view').removeClass('active');
			jQuery(this).closest('.facebook-events-calendar').find('.list-view').addClass('active');
		}
	});
});
