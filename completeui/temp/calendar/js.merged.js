/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
if (typeof(nitobi) == "undefined" || typeof(nitobi.lang) == "undefined")
{
	alert("The Nitobi framework source could not be found. Is it included before any other Nitobi components?");
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.calendar');

/**
 * Creates the calendar portion of the DatePicker.
 * @class The calendar portion of the DatePicker allows users to choose a date visually from a rendered calendar.
 * To render, you must first instantiate a {@link nitobi.calendar.DatePicker} object.
 * @constructor
 * @example
 * var dp = new nitobi.calendar.DatePicker("myUniqueId");
 * var cal = new nitobi.calendar.Calendar();
 * dp.setTheme("flex");
 * dp.setObject(cal);
 * dp.render;
 * @param {Node} [element] The ntb:calendar node from the component declaration.  If you are creating the component
 * from script, this parameter is optional.
 * @extends nitobi.ui.Element
 */
nitobi.calendar.Calendar = function(element) 
{
	nitobi.calendar.Calendar.baseConstructor.call(this, element);
	
	/**
	 * The date that is currently selected in the Calendar.  Not necessarily the same
	 * as the selectedDate of the DatePicker.
	 * @private
	 */
	this.selectedDate;

	/**
	 * The rendering class for Calendar.
	 * @type nitobi.calendar.Renderer()
	 * @private
	 */
	this.renderer = new nitobi.calendar.CalRenderer();
	
	/**
	 * Fires when the Calendar's visibility is toggled to hidden.
	 * @see #hide
	 * @type nitobi.base.Event
	 */
	this.onHide = new nitobi.base.Event();
	this.eventMap["hide"] = this.onHide;
	
	/**
	 * Fires when the Calendar's visibility is toggled to visible.
	 * @see #show
	 * @type nitobi.base.Event
	 */
	this.onShow = new nitobi.base.Event();
	this.eventMap["show"] = this.onShow;
	
	/**
	 * Fires when a date in the Calendar is clicked.
	 * @type nitobi.base.Event
	 */
	this.onDateClicked = new nitobi.base.Event();
	this.eventMap["dateclicked"] = this.onDateClicked;
	
	/**
	 * Fires when the month is changed, either by the user clicking the "next" button
	 * or via the quick nav panel.
	 * @type nitobi.base.Event
	 */
	this.onMonthChanged = new nitobi.base.Event();
	this.eventMap["monthchanged"] = this.onMonthChanged;
	
	/**
	 * Fires when the year is changed, either by the user clicking the "next" button
	 * or via the quick nav panel.
	 * @type nitobi.base.Event
	 */
	this.onYearChanged = new nitobi.base.Event();
	this.eventMap["yearchanged"] = this.onYearChanged;
	
	/**
	 * Fires when the Calendar is done rendering.
	 * @see #render
	 * @type nitobi.base.Event
	 */
	this.onRenderComplete = new nitobi.base.Event();
	
	this.onSetVisible.subscribe(this.handleToggle, this);
	
	/**
	 * The effect class to use when showing the Calendar.
	 * Default: {@link nitobi.effects.ShadeDown}
	 * @see nitobi.effects.families
	 * @type Class
	 */
	this.showEffect = (this.isEffectEnabled()?nitobi.effects.families["shade"].show:null);
	/**
	 * The effect class to use when hiding the Calendar.
	 * Default: {@link nitobi.effects.ShadeUp}
	 * @see nitobi.effects.families
	 * @type Class
	 */
	this.hideEffect = (this.isEffectEnabled()?nitobi.effects.families["shade"].hide:null);
	
	/**
	 * Use this to keep track of events we've attached to html elements so we can properly 
	 * detach them.
	 * @private
	 */
	this.htmlEvents = {'body': [], 'nav': [], 'navconfirm': [], 'navcancel': [], 'navpanel': [], 'nextmonth': [], 'prevmonth': []};
	
	this.subscribeDeclarationEvents();
}

nitobi.lang.extend(nitobi.calendar.Calendar, nitobi.ui.Element);

nitobi.calendar.Calendar.profile = new nitobi.base.Profile("nitobi.calendar.Calendar",null,false,"ntb:calendar");
nitobi.base.Registry.getInstance().register(nitobi.calendar.Calendar.profile);

/**
 * Renders the Calendar portion of the component only.
 */
nitobi.calendar.Calendar.prototype.render = function()
{
	this.detachEvents();
	
	this.setContainer(this.getHtmlNode());
	nitobi.calendar.Calendar.base.render.call(this);
	
	this.selectedDate = this.getParentObject().getSelectedDate();
	var he = this.htmlEvents;
	var H = nitobi.html;
	
	// Attach Body events
	var calBody = this.getHtmlNode("body");
	H.attachEvent(calBody,"click", this.handleBodyClick, this);
	H.attachEvent(calBody, "mousedown", this.handleMouseDown, this);
	
	he.body.push({type: "click", handler: this.handleBodyClick});
	he.body.push({type: "mousedown", handle: this.handleMouseDown});
	
	// Attach quick nav panel events
	var nav = this.getHtmlNode("nav");
	var navConfirm = this.getHtmlNode("navconfirm");
	var navCancel = this.getHtmlNode("navcancel");
	H.attachEvent(nav, "click", this.showNav, this);
	H.attachEvent(navCancel, "click", this.handleNavCancel, this);
	H.attachEvent(navConfirm, "click", this.handleNavConfirm, this);
	H.attachEvent(this.getHtmlNode("navpanel"), "keypress", this.handleNavKey, this);
	
	he.nav.push({type: "click", handler: this.showNav});
	he.navcancel.push({type: "click", handler: this.handleNavCancel});
	he.navconfirm.push({type: "click", handler: this.handleNavConfirm});
	he.navpanel.push({type: "keypress", handler: this.handleNavKey});
	
	// Attach next/prev events
	H.attachEvent(this.getHtmlNode("nextmonth"),"click",this.nextMonth,this);
	H.attachEvent(this.getHtmlNode("prevmonth"),"click",this.prevMonth,this);
	
	he.nextmonth.push({type: "click", handler: this.nextMonth});
	he.prevmonth.push({type: "click", handler: this.prevMonth});
	
	var calNode = this.getHtmlNode();
	var shim = this.getHtmlNode("shim");
	var Css = nitobi.html.Css;
	// If we are in IE 6 or FF 2 on Mac, we need an iframe backer so that scrollbars underneath
	// the Calendar are hidden properly.
	if (shim)
	{
		var hidden = Css.hasClass(calNode, "nitobi-hide");
		if (hidden)
		{
			Css.removeClass(calNode, "nitobi-hide");
			calNode.style.top = "-1000px";
		}
		var width = calNode.offsetWidth;
		var height = calNode.offsetHeight;
		shim.style.height = height + "px";
		shim.style.width = width - 1 + "px";
		if (hidden)
		{
			Css.addClass(calNode, "nitobi-hide");
			calNode.style.top = "";
		}
	}
	
	this.onRenderComplete.notify(new nitobi.ui.ElementEventArgs(this, this.onRenderComplete));
}

/**
 * Detachs html events from the Calendar.
 * @private
 */
nitobi.calendar.Calendar.prototype.detachEvents = function()
{
	var he = this.htmlEvents;
	for (var name in he)
	{
		var events = he[name];
		var node = this.getHtmlNode(name);
		nitobi.html.detachEvents(node, events);
	}
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.handleMouseDown = function(event)
{
	var datePicker = this.getParentObject();
	var activeDate = this.findActiveDate(event.srcElement);
	if (activeDate && nitobi.html.Css.hasClass(activeDate, "ntb-calendar-thismonth"))
		datePicker.blurInput = false;
	else
		datePicker.blurInput = true;
}

/**
 * Handles the case where the user clicks on a date in the Calendar.
 * @private
 */
nitobi.calendar.Calendar.prototype.handleBodyClick = function(event)
{
	var activeDate = this.findActiveDate(event.srcElement);
	if (!activeDate || nitobi.html.Css.hasClass(activeDate, "ntb-calendar-lastmonth") || nitobi.html.Css.hasClass(activeDate, "ntb-calendar-nextmonth"))
		return;
	var datePicker = this.getParentObject();
	
	var day = activeDate.getAttribute("ebadate");
	var month = activeDate.getAttribute("ebamonth");
	var year = activeDate.getAttribute("ebayear");
	var date = new Date(year, month, day);

	var eventsManager = datePicker.getEventsManager();
	if (eventsManager.isDisabled(date))
		return;

	datePicker._setSelectedDate(date);
	this.onDateClicked.notify(new nitobi.ui.ElementEventArgs(this, this.onDateClicked));
	this.toggle();
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.handleNavKey = function(e)
{
	var code = e.keyCode;
	if (code == 27)
		this.handleNavCancel();
	if (code == 13)
		this.handleNavConfirm();
}

/**
 * Handles the calendar toggling when the calendar button is clicked.
 * @private
 */
nitobi.calendar.Calendar.prototype.handleToggleClick = function(e)
{
	this.toggle();
}

/**
 * Clears the currently highlighted date.  This only removes the visual highlight.  The parent
 * DatePicker will still have a selected date set.
 */
nitobi.calendar.Calendar.prototype.clearHighlight = function()
{
	if (this.selectedDate)
	{
		var dateCell = this.findDateElement(this.selectedDate);
		if (dateCell)
			nitobi.html.Css.removeClass(dateCell, "ntb-calendar-currentday");
		this.selectedDate = null;
	}
}

/**
 * Highlight a date in the Calendar.  Applies the ntb-calendar-currentday style to that date.
 * @param {Date} date The date to highlight.
 */
nitobi.calendar.Calendar.prototype.highlight = function(date)
{
	this.selectedDate = date;
	var dateCell = this.findDateElement(date);
	if (dateCell)
		nitobi.html.Css.addClass(dateCell, "ntb-calendar-currentday");
}

/**
 * Returns the html element in the Calendar corresponding to a given date.  Returns null
 * if that date is not currently rendered.
 * @param {Date} date The date to search for.
 * @type HTMLElement
 */
nitobi.calendar.Calendar.prototype.findDateElement = function(date)
{
	var table = this.getHtmlNode(date.getMonth() + "." + date.getFullYear());
	var dm = nitobi.base.DateMath;
	if (table)
	{
		var startDate = dm.getMonthStart(dm.clone(date));
		startDate = dm.subtract(startDate,'d',startDate.getDay());
		var days = dm.getNumberOfDays(startDate, date) - 1;
		if (days >=0 && days < 42)
		{
			var row = 1 + Math.floor(days / 7);
			var col = days % 7;
			var dateCell = nitobi.html.getFirstChild(table.rows[row].cells[col])
			return dateCell;
		}
	}
	return null;
}

/**
 * Shows the quick nav panel.
 */
nitobi.calendar.Calendar.prototype.showNav = function()
{
	var datePicker = this.getParentObject();
	var startDate = datePicker.getStartDate();
	var monthsSelect = this.getHtmlNode("months");
	monthsSelect.selectedIndex = startDate.getMonth();
	this.getHtmlNode("year").value = startDate.getFullYear();
	this.getHtmlNode("warning").style.display = "none";
	var overlay = this.getHtmlNode("overlay");
	var panel = this.getHtmlNode("navpanel");
	
	var effect = new nitobi.effects.BlindDown(panel, {duration: 0.3});
	var alignTarget = this.getHtmlNode("nav");
	this.fitOverlay();
	overlay.style.display = "block";
	var D = nitobi.drawing;
	D.align(panel, alignTarget, D.align.ALIGNMIDDLEHORIZ);
	D.align(panel, this.getHtmlNode("body"), D.align.ALIGNTOP);
	D.align(overlay, this.getHtmlNode("body"), D.align.ALIGNTOP | D.align.ALIGNLEFT);
	effect.callback = 
		function() 
		{
			monthsSelect.focus();
		};
	effect.start();
}

/**
 * Hides the quick nav panel.
 */
nitobi.calendar.Calendar.prototype.hideNav = function(callback)
{
	var panel = this.getHtmlNode("navpanel");
	var effect = new nitobi.effects.BlindUp(panel, {duration: 0.2});
	effect.callback = callback || nitobi.lang.noop();
	effect.start();
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.hideOverlay = function()
{
	var overlay = this.getHtmlNode("overlay");
	overlay.style.display = "none";
}

/**
 * Fits the overlay used to obscure the Calendar to the Calendar container.
 * @private
 */
nitobi.calendar.Calendar.prototype.fitOverlay = function()
{
	var calNode = this.getHtmlNode("body");
	var overlay = this.getHtmlNode("overlay");
	var width = calNode.offsetWidth;
	var height = calNode.offsetHeight;
	overlay.style.height = height + "px";
	overlay.style.width = width + "px";
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.handleNavConfirm = function(event)
{
	var datePicker = this.getParentObject();
	
	var monthsList = this.getHtmlNode("months");
	var month = monthsList.options[monthsList.selectedIndex].value;
	var year = this.getHtmlNode("year").value;
	
	if (isNaN(year))
	{
		var warning = this.getHtmlNode("warning");
		warning.style.display = "block";
		warning.innerHTML = datePicker.getNavInvalidYearText();
		return;
	}
	year = parseInt(year);
	var newDate = new Date(year, month, 1);
	if (datePicker.isOutOfRange(newDate))
	{
		var warning = this.getHtmlNode("warning");
		warning.style.display = "block";
		warning.innerHTML = datePicker.getNavOutOfRangeText();
		return;
	}
	var startDate = datePicker.getStartDate();
	var monthChanged = false;
	var yearChanged = false;
	if (year != startDate.getFullYear()) yearChanged = true;
	if (parseInt(month) != startDate.getMonth()) monthChanged = true;
	datePicker.setStartDate(newDate);
	var callback = nitobi.lang.close(this, this.render);
	this.onRenderComplete.subscribeOnce(nitobi.lang.close(this, 
		function() {
			if (monthChanged) this.onMonthChanged.notify(new nitobi.ui.ElementEventArgs(this, this.onMonthChanged));
			if (yearChanged) this.onYearChanged.notify(new nitobi.ui.ElementEventArgs(this, this.onYearChanged));
		}
	));
	this.hideNav(callback);
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.handleNavCancel = function(event)
{
	var callback = nitobi.lang.close(this, this.hideOverlay);
	this.hideNav(callback);
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.findActiveDate = function(element)
{
	var breakOut = 5;
	for (var i = 0; i < breakOut && element.getAttribute; i++) 
	{
		var t = element.getAttribute('ebatype');
		if (t == 'date') return element;
		element = element.parentNode;
	}
	return null;
}

/**
 * Used to plug into the toolkit rendering framework.
 * @private
 */
nitobi.calendar.Calendar.prototype.getState = function()
{
	return this;
}

/**
 * Moves the start month of the Calendar forward by one month.
 */
nitobi.calendar.Calendar.prototype.nextMonth = function()
{
	var datePicker = this.getParentObject();
	if (!datePicker.disNext)
	{
		var totalMonths = this.getMonthColumns() * this.getMonthRows();
		this.changeMonth(totalMonths);
	}
}

/**
 * Moves the start month of the Calendar back by one month.
 */
nitobi.calendar.Calendar.prototype.prevMonth = function()
{
	if (!this.getParentObject().disPrev)
	{
		var totalMonths = this.getMonthColumns() * this.getMonthRows();
		this.changeMonth(0 - totalMonths);
	}
}

/**
 * Changes the start month of the Calendar.
 * @param {Number} unit The number of months so change the start month by.  Negative numbers goes back in time,
 * positive number go forward.
 */
nitobi.calendar.Calendar.prototype.changeMonth = function(unit)
{
	var datePicker = this.getParentObject();
	var date = datePicker.getStartDate();
	var dm = nitobi.base.DateMath;
	date = dm._add(dm.clone(date), 'm', unit);
	var startDate = datePicker.getStartDate();
	var yearChanged = false;
	if (startDate.getFullYear() != date.getFullYear())
		yearChanged = true;
	datePicker.setStartDate(date);
	this.render();
	
	this.onMonthChanged.notify(new nitobi.ui.ElementEventArgs(this, this.onMonthChanged));
	if (yearChanged) this.onYearChanged.notify(new nitobi.ui.ElementEventArgs(this, this.onYearChanged));
}

/**
 * Toggles the visibility of the Calendar.
 * @param {Function} callback The function to call after the toggling has completed.
 */
nitobi.calendar.Calendar.prototype.toggle = function(callback)
{
	var datePicker = this.getParentObject();
	if (datePicker.getInput())
		this.setVisible(!this.isVisible(), (this.isVisible()?this.hideEffect:this.showEffect), callback, {duration: 0.3});
}

/**
 * Shows the Calendar.
 * @param {Function} callback The function to call after the toggling has completed.
 */
nitobi.calendar.Calendar.prototype.show = function(callback)
{
	var datePicker = this.getParentObject();
	if (datePicker.getInput())
		this.setVisible(true, this.showEffect, callback, {duration: 0.3});
}

/**
 * Hides the Calendar.
 * @param {Function} callback The function to call after the toggling has completed.
 */
nitobi.calendar.Calendar.prototype.hide = function(callback)
{
	var datePicker = this.getParentObject();
	if (datePicker.getInput())
		this.setVisible(false, this.hideEffect, callback, {duration: 0.3});
}

/**
 * @private
 */
nitobi.calendar.Calendar.prototype.handleToggle = function()
{
	if (this.isVisible())
		this.onShow.notify(new nitobi.ui.ElementEventArgs(this, this.onShow));
	else
		this.onHide.notify(new nitobi.ui.ElementEventArgs(this, this.onHide));
}

/**
 * Returns the number of month columns to render.  Together with {@link #getMonthRows} it
 * defines the number of calendars to render in total.
 * @type Number
 */
nitobi.calendar.Calendar.prototype.getMonthColumns = function()
{
	return this.getIntAttribute("monthcolumns", 1);
}

/**
 * Sets the number of month columns to render.
 * @param {Number} columns The number of month columns.
 */
nitobi.calendar.Calendar.prototype.setMonthColumns = function(columns)
{
	this.setAttribute("monthcolumns", columns);
}

/**
 * Returns the number of month rows to render.  Together with {@link #getMonthColumns} it
 * defines the number of calendars to render in total.
 * @type Number
 */
nitobi.calendar.Calendar.prototype.getMonthRows = function()
{
	return this.getIntAttribute("monthrows", 1);
}

/**
 * Sets the number of month rows to render.
 * @param {Number} rows The number of month rows.
 */
nitobi.calendar.Calendar.prototype.setMonthRows = function(rows)
{
	this.setAttribute("monthrows", rows);
}

/**
 * Returns true if the Calendar has effects enabled, false otherwise.
 * @type Boolean
 */
nitobi.calendar.Calendar.prototype.isEffectEnabled = function()
{
	return this.getBoolAttribute("effectenabled", true);
}

/**
 * Sets whether or not to use an effect when showing/hiding the Calendar.
 * @param {Boolean} enableEffect Use true to enable effects, false to disable.
 */
nitobi.calendar.Calendar.prototype.setEffectEnabled = function(enableEffect)
{
	this.setAttribute("effectenabled", isEffectEnabled);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.calendar');

if (false)
{
	/**
	 * @namespace namespace for classes that make up the Nitobi Calendar component.
	 * @constructor
	 */
	nitobi.calendar = {};
}

/**
 * Normally, you'd instantiate it 
 * using the declaration tag (ntb:datepicker), but you can optionally instantiate it through javascript.
 * To properly initialize the the component, you need to also instantiate a {@link nitobi.calendar.Calendar} object
 * and/or a {@link nitobi.calendar.DateInput} object and reference either of these in the instantiated DatePicker object.
 * @class The DatePicker class is the base class for the Nitobi Calendar component.  
 * @constructor
 * @param {String} [id] The id of the control's declaration, or an xml node that describes the Calendar. 
 * If you do not specify an id, one is created for you.
 * @example
 * var dp = new nitobi.calendar.DatePicker("someUniqueId");
 * var cal = new nitobi.calendar.Calendar();
 * dp.setObject(cal);
 * dp.setTheme("flex");
 * dp.setContainer(document.getElementById("id_of_container_to_render_in"));
 * dp.render();
 * @extends nitobi.ui.Element
 */
nitobi.calendar.DatePicker = function(id) 
{
	nitobi.calendar.DatePicker.baseConstructor.call(this, id);
	
	this.renderer.setTemplate(nitobi.calendar.datePickerTemplate);
	
	/**
	 * Used to properly handle blurring on the input.
	 * @private
	 */
	this.blurInput = true;
	
	/**
	 * Fires when a date is selected.
	 * @type nitobi.base.Event
	 */
	this.onDateSelected = new nitobi.base.Event();
	this.eventMap["dateselected"] = this.onDateSelected;
	
	/**
	 * Fires when the user attempts to set an invalid date as the selected date.
	 * @type nitobi.base.Event
	 */
	this.onSetInvalidDate = new nitobi.base.Event();
	this.eventMap["setinvaliddate"] = this.onSetInvalidDate;
	
	/**
	 * Fires when the user attempts to set a date that is specified as disabled as the selected date.
	 * @type nitobi.base.Event
	 */
	this.onSetDisabledDate = new nitobi.base.Event();
	this.eventMap["setdisableddate"] = this.onSetDisabledDate;
	
	/**
	 * Fires when the user attempts to set a date beyond the range defined by the mindate/maxdate attributes
	 * as the selected date.
	 * @type nitobi.base.Event
	 */
	this.onSetOutOfRangeDate = new nitobi.base.Event();
	this.eventMap["setoutofrangedate"] = this.onSetOutOfRangeDate;
	
	/**
	 * Fires when the user selects a date with event information.
	 * @type nitobi.base.Event
	 */
	this.onEventDateSelected = new nitobi.base.Event();
	this.eventMap["eventdateselected"] = this.onEventDateSelected;

	/**
	 * The Events Manager encapsulates special days (i.e. days with events or disabled days).
	 * @private
	 */
	this.eventsManager = new nitobi.calendar.EventsManager(this.getEventsUrl());
	this.eventsManager.onDataReady.subscribe(this.renderChildren, this);
	
	var selectedDate = this.getSelectedDate();
	// If the selected date is within range, and is a valid date, we can use it, otherwise we need to clear
	// it out and set the mindate and startdate properly
	if (selectedDate && !this.isOutOfRange(selectedDate) && !nitobi.base.DateMath.invalid(selectedDate))
	{
		this.setStartDate(nitobi.base.DateMath.getMonthStart(selectedDate));
	}
	else
	{
		this.setDateAttribute("selecteddate", null);
		var minDate = this.getMinDate();
		var start;
		if (minDate)
			start = minDate;
		else
			start = new Date();
		this.setStartDate(nitobi.base.DateMath.getMonthStart(start));
	}
	this.subscribeDeclarationEvents();
};

nitobi.lang.extend(nitobi.calendar.DatePicker, nitobi.ui.Element);

nitobi.base.Registry.getInstance().register(
		new nitobi.base.Profile("nitobi.calendar.DatePicker",null,false,"ntb:datepicker")
);

/**
 * Render the calendar into the container specified either by the location of the declaration, or
 * by {@link nitobi.calendar.Datepicker#setContainer}. Call render after changing the currently
 * selected date with {@link nitobi.calendar.DatePicker#setDate}.
 */
nitobi.calendar.DatePicker.prototype.render = function()
{
	var input = this.getInput();
	if (input)
		input.detachEvents();
	nitobi.calendar.DatePicker.base.render.call(this);
	if (input)
		input.attachEvents();
	if (nitobi.browser.IE && input)
	{
		// Total hack.  IE renders two extra pixels in the height, AS IF FROM NOWHERE.
		var inputNode = input.getHtmlNode("input");
		var height = nitobi.html.Css.getStyle(inputNode, "height");
		nitobi.html.Css.setStyle(inputNode, "height", parseInt(height) - 2 + "px");
	}
	if (this.eventsManager)
		this.eventsManager.getFromServer();
	else
		this.renderChildren();
};

/**
 * Finishes the render of the control.  If the calendar is databound, we delay 
 * rendering the calendar until after we get a response from the server.
 * @private
 */
nitobi.calendar.DatePicker.prototype.renderChildren = function()
{
	var cal = this.getCalendar();
	var input = this.getInput();
	if (cal)
	{
		cal.render();
		if (!input)
		{
			// If there is no input, we need to set the width explicitly on the calendar container because it is no
			// longer absolutely positioned.
			var C = nitobi.html.Css;
			var calNode = cal.getHtmlNode();
			var body = cal.getHtmlNode("body");
			C.swapClass(calNode, "nitobi-hide", NTB_CSS_SMALL);
			cal.getHtmlNode().style.width = body.offsetWidth + "px";
			C.removeClass(calNode, NTB_CSS_SMALL);
		}
	}
	
	if (this.getSelectedDate() && input)
	{
		input.setValue(this.formatDate(this.getSelectedDate(), input.getDisplayMask()));
	}
	if (this.getSelectedDate())
	{
		var hidden = this.getHtmlNode('value');
		if (hidden) hidden.value = this.formatDate(this.getSelectedDate(), this.getSubmitMask());
	}
	
	this.enableButton();
}

/**
 * Returns the Calendar of the DatePicker component.
 * @example
 * var dp = nitobi.getComponent("myDatePicker");
 * var cal = dp.getCalendar();
 * cal.show();
 * @type nitobi.calendar.Calendar
 */
nitobi.calendar.DatePicker.prototype.getCalendar = function()
{
	return this.getObject(nitobi.calendar.Calendar.profile);
}

/**
 * Returns the Input of the DatePicker component.
 * @example
 * var dp = nitobi.getComponent("myDatePicker");
 * var input = dp.getInput();
 * input.setEditable(false);
 * @type nitobi.calendar.DateInput
 */
nitobi.calendar.DatePicker.prototype.getInput = function()
{
	return this.getObject(nitobi.calendar.DateInput.profile);
}

/**
 * Returns the selected date.
 * @type Date
 */
nitobi.calendar.DatePicker.prototype.getSelectedDate = function()
{
	return this.getDateAttr("selecteddate");	
}

/**
 * Gets the date value from an attribute and parses the date if need be.
 * @param {String} attr The name of the attribute
 * @type Date
 * @private
 */
nitobi.calendar.DatePicker.prototype.getDateAttr = function(attr)
{
	var dateAttr = this.getAttribute(attr, null);
	if (dateAttr)
	{
		if (typeof(dateAttr) == "string")
			return this.parseLanguage(dateAttr);
		else
			return new Date(dateAttr);
	}
	return null;
}

/**
 * Set the selected date. Call {@link nitobi.calendar.Calendar#render} for the visible calendar to be updated.
 * @param {Date} date The new selected date - <code>date</code> can be also be any string that <code>Date.parse()</code> accepts
 */
nitobi.calendar.DatePicker.prototype.setSelectedDate = function(date)
{
	// TODO: Should parse the date first...
	if (typeof(date) != "object")
		date = new Date(date);
	if (this.validate(date))
		this._setSelectedDate(date);
}

/**
 * Sets the selected date.
 * @param {Date} date The date to set as the selected date.
 * @type Boolean
 * @private
 */
nitobi.calendar.DatePicker.prototype._setSelectedDate = function(date, forceRender)
{
	this.setDateAttribute("selecteddate", date); 
	
	var hidden = this.getHtmlNode('value');
	if (hidden) hidden.value = this.formatDate(date, this.getSubmitMask());
	
	var input = this.getInput();
	if (input)
	{
		var inputMask = input.getDisplayMask();
		var inputValue = this.formatDate(date, inputMask);
		input.setValue(inputValue);
		input.setInvalidStyle(false);
	}
	
	// Set the highlighted date for the calendar now
	var calendar = this.getCalendar();
	if (calendar)
	{
		calendar.clearHighlight(date);
		var dm = nitobi.base.DateMath;
		var startDate = dm.getMonthStart(this.getStartDate());
		var months = calendar.getMonthColumns() * calendar.getMonthRows() - 1;
		var endDate = dm.getMonthEnd(dm.add(dm.clone(startDate), 'm', months));
		if (dm.between(date, startDate, endDate))
		{
			calendar.highlight(date);
		}
		if (forceRender)
		{
			this.setStartDate(dm.getMonthStart(dm.clone(date)));
			calendar.render();
		}
	}
	
	var eventsManager = this.getEventsManager();
	if (eventsManager.isEvent(date))
	{
		var startDate = eventsManager.eventsCache[date.valueOf()];
		var eventInfo = this.eventsManager.getEventInfo(startDate);
		this.onEventDateSelected.notify({events: eventInfo});
	}
	this.onDateSelected.notify(new nitobi.ui.ElementEventArgs(this, this.onDateSelected));
}

/**
 * Validates the date and fires the appropriate events if it isn't valid.  Returns true if the date is valid,
 * false otherwise.
 * @param {Date} date The date to validate against.
 * @type Boolean
 * @private
 */
nitobi.calendar.DatePicker.prototype.validate = function(newDate)
{
	var E = nitobi.ui.ElementEventArgs;
	if (nitobi.base.DateMath.invalid(newDate))
	{
		this.onSetInvalidDate.notify(new E(this, this.onSetInvalidDate));
		return false;
	}
	if (this.isOutOfRange(newDate))
	{
		this.onSetOutOfRangeDate.notify(new E(this, this.onSetOutOfRangeDate));
		return false;
	}
	if (this.isDisabled(newDate))
	{
		this.onSetDisabledDate.notify(new E(this, this.onSetDisabledDate));
		return false;
	}
	return true;
}

/**
 * Returns true if the given date is disabled, false otherwise.  Disabled dates are defined by the data
 * returned from the eventsurl.
 * @see #getEventsUrl
 * @param {Date} date The date to check.
 */
nitobi.calendar.DatePicker.prototype.isDisabled = function(date)
{
	return this.getEventsManager().isDisabled(date);
}

/**
 * Disables the calendar toggling button.
 */
nitobi.calendar.DatePicker.prototype.disableButton = function()
{
	var button = this.getHtmlNode("button");
	var cal = this.getCalendar();
	if (button)
	{
		nitobi.html.Css.swapClass(button, "ntb-calendar-button", "ntb-calendar-button-disabled");
		nitobi.html.detachEvent(button, "click", cal.handleToggleClick, cal);
	}
}

/**
 * Enables the calendar toggling button.
 */
nitobi.calendar.DatePicker.prototype.enableButton = function()
{
	var button = this.getHtmlNode("button");
	var cal = this.getCalendar();
	if (button)
	{
		nitobi.html.Css.swapClass(button, "ntb-calendar-button-disabled", "ntb-calendar-button");
		nitobi.html.attachEvent(button, "click", cal.handleToggleClick, cal);
	}
}

/**
 * Returns true if the given date is within the range specified by the mindate and maxdate attributes.
 * @param {Date} date The date to check.
 */
nitobi.calendar.DatePicker.prototype.isOutOfRange = function(date)
{
	var dm = nitobi.base.DateMath;
	var minDate = this.getMinDate();
	var maxDate = this.getMaxDate();
	var isOutOfRange = false;
	if (minDate && maxDate) isOutOfRange = !dm.between(date, minDate, maxDate);
	else if (minDate && maxDate == null) isOutOfRange = dm.before(date, minDate);
	else if (minDate == null && maxDate) isOutOfRange = dm.after(date, maxDate);
	return isOutOfRange;
}

/**
 * Clears the DatePicker.  After clearing, the DatePicker no longer has a selected date and the
 * hidden input is cleared.
 */
nitobi.calendar.DatePicker.prototype.clear = function()
{
	// Clear value from hidden input
	var hidden = this.getHtmlNode('value')
	if (hidden) hidden.value = "";
	
	// Clear selected date from xml
	this.setDateAttribute("selecteddate", null);
}

/**
 * Returns the theme used by the DatePicker.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getTheme = function()
{
	return this.getAttribute("theme", "");
}

/**
 * Returns the mask used by the DatePicker to format dates for the hidden field available for use in a form.  If you include
 * the DatePicker in a form, you can optionally use this hidden input as the actual submit value (as opposed to the value that is
 * displayed in the visible input field).  The hidden input has the same name as the id given to the DatePicker component.
 * @see #setSubmitMask
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getSubmitMask = function()
{
	return this.getAttribute("submitmask", "yyyy-MM-dd");
}

/**
 * Sets the submit mask for the DatePicker.
 * <br/>
 * Date masking syntax is as follows (for the sample date January 30, 2009):
 * 	<ul>
 * 		<li>yyyy - 2009</li>
 * 		<li>yy - 09</li>
 * 		<li>M - 1</li>
 * 		<li>MM - 01</li>
 * 		<li>MMM - January</li>
 *		<li>NNN - Jan</li>
 * 		<li>d - 30</li>
 * 		<li>dd - 30</li>
 * 		<li>EE - Friday</li>
 * 		<li>E - Fri</li>
 * 	</ul>
 * @param {String} mask The mask to apply to the hidden field.
 */
nitobi.calendar.DatePicker.prototype.setSubmitMask = function(mask)
{
	this.setAttribute("submitmask", mask);
}

/**
 * Sets the startdate attribute.
 * @private
 */
nitobi.calendar.DatePicker.prototype.getStartDate = function()
{
	return this.getDateAttribute("startdate");
}

/**
 * @private
 */
nitobi.calendar.DatePicker.prototype.setStartDate = function(date)
{
	this.setDateAttribute("startdate", date);
}

/**
 * Returns the eventsurl from the DatePicker.  The eventsurl defines the server location where the DatePicker
 * can get information on events and disabled dates.  When the component loads initially, it fetches data from the eventsurl
 * and stores it in a {@link nitobi.calendar.EventsManager}.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getEventsUrl = function()
{
	return this.getAttribute("eventsurl", "");
}

/**
 * Sets the eventsurl.  Call render to rebind the DatePicker to the new eventsurl.
 * @param {String} url The url to set as the eventsurl.
 */
nitobi.calendar.DatePicker.prototype.setEventsUrl = function(url)
{
	this.setAttribute("eventsurl", url);
}

/**
 * Returns the EventsManager for the DatePicker.  The events manager is responsible for handling
 * dates that are defined as disabled or defined to have event information associated with it.  Defining
 * which dates are disabled or special is done through the eventsurl defined as an attribute on the &lt;ntb:datepicker&gt; tag.
 * @see #getEventsUrl
 * @type nitobi.calendar.EventsManager
 */
nitobi.calendar.DatePicker.prototype.getEventsManager = function()
{
	return this.eventsManager;
}

/**
 * Returns true if the shimenabled attribute is set to true AND if the browser is FF 2 on Mac or IE 6.
 * The shim is used to smoothly show/hide the calendar.
 * @type Boolean
 */
nitobi.calendar.DatePicker.prototype.isShimEnabled = function()
{
	return this.getBoolAttribute("shimenabled", false);
}

/**
 * Returns the earliest selectable date for the DatePicker.
 * @type Date
 */
nitobi.calendar.DatePicker.prototype.getMinDate = function()
{
	return this.getDateAttr("mindate");
}

/**
 * Sets the earliest selectable date in the DatePicker.  
 * @param {String} minDate The date to set as the min date.  Some natural language dates are acceptable:
 * yesterday, today, tomorrow, lastweek, nextweek, lastmonth, nextmonth, lastyear, and nextyear.
 */
nitobi.calendar.DatePicker.prototype.setMinDate = function(minDate)
{
	this.setAttribute("mindate", minDate);
}

/**
 * Returns the latest selected date in the DatePicker.
 * @type Date
 */
nitobi.calendar.DatePicker.prototype.getMaxDate = function()
{
	return this.getDateAttr("maxdate");
}

/**
 * Sets the latest selectable date in the DatePicker.
 * @param {String} maxDate The date to set as the max date.  Some natural language dates are acceptable:
 * yesterday, today, tomorrow, lastweek, nextweek, lastmonth, nextmonth, lastyear, and nextyear.
 */
nitobi.calendar.DatePicker.prototype.setMaxDate = function(maxDate)
{
	 this.setAttribute("maxdate", maxDate);
}

/**
 * Parses a natural language expression and returns a the corresponding date.
 * Allowable expressions include: yesterday, today, tomorrow, lastweek, nextweek, lastmonth, nextmonth, lastyear, and nextyear.
 * @type Date
 * @private
 */
nitobi.calendar.DatePicker.prototype.parseLanguage = function(date)
{
	var dm = nitobi.base.DateMath;
	var parsedDate = Date.parse(date);
	if (parsedDate && typeof(parsedDate) == "object" && !isNaN(parsedDate) && !dm.invalid(parsedDate))
	{
		// Then there is some sort of date lib included in the page.
		return parsedDate;
	}
	if (date == "" || date == null)
		return null;

	date = date.toLowerCase();
	var today = dm.resetTime(new Date());
	switch (date)
	{
		case "today":
			date = today;
			break;
		case "tomorrow":
			date = dm.add(today, 'd', 1);
			break;
		case "yesterday":
			date = dm.subtract(today, 'd', 1);
			break;
		case "last week":
			date = dm.subtract(today, 'd', 7);
			break;
		case "next week":
			date = dm.add(today, 'd', 7);
			break;
		case "last year":
			date = dm.subtract(today, 'y', 1);
			break;
		case "last month":
			date = dm.subtract(today, 'm', 1);
			break;
		case "next month":
			date = dm.add(today, 'm', 1);
			break;
		case "next year":
			date = dm.add(today, 'y', 1);
			break;
		default:
			date = dm.resetTime(new Date(date));
			break;
	}
	if (dm.invalid(date))
		return null;
	else
		return date;
}

/**
 * An array defining the long names for days of the week, e.g "Sunday", "Monday", "Tuesday", etc.
 * You can use this static value to localize all the Calendar components on a page.
 * @example
 * nitobi.calendar.DatePicker.longDayNames = ["Dimanche", "Lundi", "Mardi", "Mecredi", "Jeudi", "Vendredi", "Samedi"];
 * nitobi.loadComponent("myFrenchCalendar");
 * @type Array
 * @static
 */
nitobi.calendar.DatePicker.longDayNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
/**
 * An array defining the abbreviated names for days of the week, e.g "Sun", "Mon", "Tue", etc.
 * You can use this static value to localize all the Calendar components on a page.
 * @example
 * nitobi.calendar.DatePicker.shortDayNames = ["Dim", "Lun", "Mar", "Mec", "Jeu", "Ven", "Sam"];
 * nitobi.loadComponent("myFrenchCalendar");
 * @type Array
 * @static
 */
nitobi.calendar.DatePicker.shortDayNames = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
/**
 * An array defining the shortest names for days of the week, e.g "S", "M", "T", etc.
 * You can use this static value to localize all the Calendar components on a page.
 * @example
 * nitobi.calendar.DatePicker.minDayNames = ["D", "L", "M", "M", "J", "V", "S"];
 * nitobi.loadComponent("myFrenchCalendar");
 * @type Array
 * @static
 */
nitobi.calendar.DatePicker.minDayNames = ["S", "M", "T", "W", "T", "F", "S"];

/**
 * An array defining the full names of months, e.g "January", "February", "March", etc.
 * You can use this static value to localize all the Calendar components on a page.
 * @example
 * nitobi.calendar.DatePicker.longMonthNames = ["Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Julliet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre"];
 * nitobi.loadComponent("myFrenchCalendar");
 * @type Array
 * @static
 */
nitobi.calendar.DatePicker.longMonthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
/**
 * An array defining the abbreviated names of months, e.g "Jan", "Feb", "Mar", etc.
 * You can use this static value to localize all the Calendar components on a page.
 * @example
 * nitobi.calendar.DatePicker.shortMonthNames = ["Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"];
 * nitobi.loadComponent("myFrenchCalendar");
 * @type Array
 * @static
 */
nitobi.calendar.DatePicker.shortMonthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

/**
 * The text shown in the quick nav panel to confirm the date.
 * Use this static value to localize the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navConfirmText = "OK";
/**
 * The text shown in the quick nav panel to cancel and hide the panel.
 * Use this static value to localize the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navCancelText = "Cancel";

/**
 * The error message displayed when the user attempts to use the quick nav panel to change the 
 * month beyond the limits defined by the mindate and maxdate of the component.
 * Use this static value to localize the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navOutOfRangeText = "That date is out of range.";
/**
 * The error message displayed when the user enters an invalid year.
 * Use this static value to localize the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navInvalidYearText = "You must enter a valid year.";

/**
 * The tooltip displayed when the user places her/his mouse over the month header of the Calendar.
 * Use this static value to localize the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.quickNavTooltip = "Click to change month and/or year";

/**
 * The text label applied to the month field in the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navSelectMonthText = "Choose Month";

/**
 * The text label applied to the month field in the quick nav panel.
 * @type String
 * @static
 */
nitobi.calendar.DatePicker.navSelectYearText = "Enter Year";

/**
 * Returns the text for the quick nav tooltip.
 * Can be localized using either the <code>quicknavtooltip</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.quicknavtooltip} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getQuickNavTooltip = function()
{
	return this.initLocaleAttr("quickNavTooltip");
}

/** 
 * Returns an array of mimimized day names, e.g S, M, T, W, T, F, S.
 * Can be localized using either the <code>mindaynames</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.minDayNames} static member.
 * @type Array
 */
nitobi.calendar.DatePicker.prototype.getMinDayNames = function()
{
	return this.initJsAttr("minDayNames");
}

/**
 * Returns an array of full day names e.g Sunday, Monday, etc.
 * Can be localized using either the <code>longdaynames</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.longDayNames} static member.
 * @type Array
 */
nitobi.calendar.DatePicker.prototype.getLongDayNames = function()
{
	return this.initJsAttr("longDayNames");
}

/**
 * Returns an array of abbreviated day names, e.g Sun, Mon, Tue, etc.
 * Can be localized using either the <code>shortdaynames</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.shortDayNames} static member.
 * @type Array
 */
nitobi.calendar.DatePicker.prototype.getShortDayNames = function()
{
	return this.initJsAttr("shortDayNames");
}

/**
 * Returns an array of full month names, e.g Januaray, February, March, etc.
 * Can be localized using either the <code>longmonthnames</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.longMonthNames} static member.
 * @type Array
 */
nitobi.calendar.DatePicker.prototype.getLongMonthNames = function()
{
	return this.initJsAttr("longMonthNames");
}

/**
 * Returns an array of abbreviated month names, e.g Jan, Feb, Mar, etc.
 * Can be localized using either the <code>shortmonthnames</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.shortMonthNames} static member.
 */
nitobi.calendar.DatePicker.prototype.getShortMonthNames = function()
{
	return this.initJsAttr("shortMonthNames");
}

/**
 * Returns the text for the confirm button on the quick nav panel.
 * Can be localized using either the <code>navconfirmtext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navConfirmText} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavConfirmText = function()
{
	return this.initLocaleAttr("navConfirmText");
}

/**
 * Returns the text for the cancel button on the quick nav panel.
 * Can be localized using either the <code>navcanceltext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navCancelText} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavCancelText = function()
{
	return this.initLocaleAttr("navCancelText");
}

/**
 * Returns the text for the date out of range error for the quick nav panel.
 * Can be localized using either the <code>navoutofrangetext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navOutOfRangeText} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavOutOfRangeText = function()
{
	return this.initLocaleAttr("navOutOfRangeText");
}

/**
 * Returns the text for the invalid year error for the quick nav panel.
 * Can be localized using either the <code>navinvalidyeartext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navInvalidYear} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavInvalidYearText = function()
{
	return this.initLocaleAttr("navInvalidYearText");
}

/**
 * Returns the text label applied to the month field in the quick nav panel.
 * Can be localized using either the <code>navselectmonthtext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navSelectMonthText} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavSelectMonthText = function()
{
	return this.initLocaleAttr("navSelectMonthText");
}

/**
 * Returns the text label applied to the year field in the quick nav panel.
 * Can be localized using either the <code>navselectyeartext</code> attribute or using the
 * {@link nitobi.calendar.DatePicker.navSelectYearText} static member.
 * @type String
 */
nitobi.calendar.DatePicker.prototype.getNavSelectYearText = function()
{
	return this.initLocaleAttr("navSelectYearText");
}

/**
 * Initializes an attribute that is either a reference to a js object or a json string.
 * @param {String} jsName The name of the attribute, camel-cased.  E.g. "shortMonthNames"
 * @private
 */
nitobi.calendar.DatePicker.prototype.initJsAttr = function(jsName)
{
	if (this[jsName])
		return this[jsName];
		
	var attr = this.getAttribute(jsName.toLowerCase(), "");
	if (attr != "")
	{
		attr = eval('(' + attr + ')');
		return this[jsName] = attr;
	}
	return this[jsName] = nitobi.calendar.DatePicker[jsName];
}

/**
 * Initializes a locale attribute and either returns the value from that attribute or a default value.
 * @param {String} jsName The name of the attribute to initialize.
 * @private
 */
nitobi.calendar.DatePicker.prototype.initLocaleAttr = function(jsName)
{
	if (this[jsName])
		return this[jsName];
	
	var text = this.getAttribute(jsName.toLowerCase(), "");
	if (text != "")
		return this[jsName] = text;
	else
		return this[jsName] = nitobi.calendar.DatePicker[jsName];
}

/**
 * @private
 */
nitobi.calendar.DatePicker.prototype.parseDate = function(date, mask)
{
	var parsedValues = {};
	while (mask.length > 0)
	{
		var c = mask.charAt(0);
		var testExp = new RegExp(c + "+");
		var format = testExp.exec(mask)[0];
		if (c != "d" && c != "y" && c != "M" && c != "N" && c != "E")
		{
			mask = mask.substring(format.length);
			date = date.substring(format.length);
		}
		else
		{
			var separator = mask.charAt(format.length);
			var currentValue = (separator == ""?date:date.substring(0, date.indexOf(separator)));
			var validatedDate = this.validateFormat(currentValue, format);
			if (validatedDate.valid)
			{
				parsedValues[validatedDate.unit] = validatedDate.value;
			}
			else
			{
				return null;
			}
			mask = mask.substring(format.length);
			date = date.substring(currentValue.length);
		}
	}
	var date = new Date(parsedValues.y, parsedValues.m, parsedValues.d);
	return date;
}

/**
 * @private
 */
nitobi.calendar.DatePicker.prototype.validateFormat = function(value, format)
{
	var validated = {valid: false, unit: "", value: ""};
	switch (format)
	{
		case "d":
		case "dd":
			var parsedValue = parseInt(value);
			var isValid;
			if (format == "d") isValid = !isNaN(value) && value.charAt(0) != "0" && value.length <= 2;
			else isValid = !isNaN(value) && value.length == 2
			if (isValid)
			{
				validated.valid = true;
				validated.unit = 'd';
				validated.value = value;
			}
			else
			{
				validated.valid = false;
			}
			break;
		case "y":
		case "yyyy":
			if (isNaN(value))
			{
				validated.valid = false;
			}
			else
			{
				validated.valid = true;
				validated.unit = 'y';
				validated.value = value;
			}
			break;
		case "M":
		case "MM":
			var parsedValue = parseInt(value, 10);
			var isValid;
			if (format == "M") isValid = !isNaN(value) && value.charAt(0) != "0" && value.length <= 2 && parsedValue >= 1 && parsedValue <= 12;
			else isValid = !isNaN(value) & value.length == 2 && parsedValue >= 1 && parsedValue <= 12;
			
			if (isValid)
			{
				validated.valid = true;
				validated.unit = 'm';
				validated.value = parsedValue - 1;
			}
			else
			{
				validated.valid = false;
			}
			break;
		case "MMM":
		case "NNN":
		case "E":
		case "EE":
			var names;
			if (format == "MMM") names = this.getLongMonthNames();
			else if (format == "NNN") names = this.getShortMonthNames();
			else if (format == "E") names = this.getShortDayNames();
			else names = this.getLongDayNames();
			var i;
			for (i = 0; i < names.length; i++)
			{
				var dateName = names[i];
				if (value.toLowerCase() == dateName.toLowerCase())
					break;
			}
			if (i < names.length)
			{
				validated.valid = true;
				if (format == "MMM" || format == "NNN") validated.unit = 'm';
				else validated.unit = 'dl';
				validated.value = i;
			}
			else
			{
				validated.valid = false;
			}
			break;
	}
	return validated;
}

/**
 * @private
 */
nitobi.calendar.DatePicker.prototype.formatDate = function(date, mask)
{
	var parsedMask = {};	
	var year = date.getFullYear() + "";
	var month = date.getMonth() + 1 + "";
	var numDate = date.getDate() + "";
	var day = date.getDay();
	
	parsedMask["y"] = parsedMask["yyyy"] = year;
	parsedMask["yy"] = year.substring(2,4);
	
	parsedMask["M"] = month + "";
	parsedMask["MM"] = nitobi.lang.padZeros(month,2);
	parsedMask["MMM"] = this.getLongMonthNames()[month - 1];
	parsedMask["NNN"] = this.getShortMonthNames()[month - 1];
	
	parsedMask["d"] = numDate;
	parsedMask["dd"] = nitobi.lang.padZeros(numDate,2);
	
	parsedMask["EE"] =  this.getLongDayNames()[day];
	parsedMask["E"] = this.getShortDayNames()[day];
	
	var formattedDate = "";
	while (mask.length > 0)
	{
		var c = mask.charAt(0);
		var testExp = new RegExp(c + "+");
		// No check because we're guaranteed to get a result
		var currentMask = testExp.exec(mask)[0];
		formattedDate += parsedMask[currentMask] || currentMask;
		mask = mask.substring(currentMask.length);
	}
	return formattedDate;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.calendar');

/**
 * Creates the input portion of the DatePicker.
 * @class The input portion of the DatePicker allows the user the input dates directly.
 * To render, you must first instantiate a {@link nitobi.calendar.DatePicker} object.
 * @constructor
 * @example
 * var dp = new nitobi.calendar.DatePicker("myUniqueId");
 * var input = new nitobi.calendar.DateInput();
 * dp.setTheme("flex");
 * dp.setObject(input);
 * dp.render;
 * @param {Node} [element] The ntb:dateinput node from the component declaration.  If you are creating the component
 * from script, this parameter is optional.
 * @extends nitobi.ui.Element
 * @see nitobi.calendar.DatePicker
 */
nitobi.calendar.DateInput = function(element) 
{
	nitobi.calendar.DateInput.baseConstructor.call(this, element);
	
	/**
	 * Fires when the input if blurred.
	 * @type nitobi.base.Event
	 */
	this.onBlur = new nitobi.base.Event();
	this.eventMap["blur"] = this.onBlur;
	
	/**
	 * Fires when the input if focussed.
	 * @type nitobi.base.Event
	 */
	this.onFocus = new nitobi.base.Event();
	this.eventMap["focus"] = this.onFocus;
	
	/**
	 * Used to attach/detach html events.
	 * @private
	 */
	this.htmlEvents = [];
	
	this.subscribeDeclarationEvents();
}

nitobi.lang.extend(nitobi.calendar.DateInput, nitobi.ui.Element);

nitobi.calendar.DateInput.profile = new nitobi.base.Profile("nitobi.calendar.DateInput",null,false,"ntb:dateinput");
nitobi.base.Registry.getInstance().register(nitobi.calendar.DateInput.profile);

/**
 * Attachs the necessary html events to the input.
 * @private
 */
nitobi.calendar.DateInput.prototype.attachEvents = function()
{
	var he = this.htmlEvents;
	he.push({type: "focus", handler: this.handleOnFocus});
	he.push({type: "blur", handler: this.handleOnBlur});
	he.push({type: "keydown", handler: this.handleOnKeyDown});
	nitobi.html.attachEvents(this.getHtmlNode("input"), he, this);
}

/**
 * Detaches all html events from the input element.
 * @private
 */
nitobi.calendar.DateInput.prototype.detachEvents = function()
{
	nitobi.html.detachEvents(this.getHtmlNode("input"), this.htmlEvents);
}

/**
 * Sets the text value of the input.  Setting the input value this way will not
 * select a date.  You must use {@link nitobi.calendar.DatePicker#setSelectedDate} to both
 * set the date and update the input field.
 * @param {String} value The value to set for the input.
 */
nitobi.calendar.DateInput.prototype.setValue = function(value)
{
	var inputNode = this.getHtmlNode("input");
	inputNode.value = value;
}

/**
 * Returns the value of the input.  If you want the value of the input as a date,
 * use {@link nitobi.calendar.DatePicker#getSelectedDate}
 * @type String
 */
nitobi.calendar.DateInput.prototype.getValue = function()
{
	var inputNode = this.getHtmlNode("input");
	return inputNode.value;
}

/**
 * @private
 */
nitobi.calendar.DateInput.prototype.handleOnFocus = function()
{
	var inputMask = this.getEditMask();
	var datePicker = this.getParentObject();
	var selectedDate = datePicker.getSelectedDate();
	if (selectedDate)
	{
		var value = datePicker.formatDate(selectedDate, inputMask);
		this.setValue(value);
		var datePicker = this.getParentObject();
		datePicker.blurInput = true;
	}
	this.onFocus.notify(new nitobi.ui.ElementEventArgs(this, this.onFocus));
}

/**
 * @private
 */
nitobi.calendar.DateInput.prototype.handleOnBlur = function()
{
	var datePicker = this.getParentObject();
	var calendar = datePicker.getCalendar();
	if (datePicker.blurInput)
	{
		var editMask = this.getEditMask();
		var newDate = this.getValue();
		newDate = datePicker.parseDate(newDate, editMask);
		if (datePicker.validate(newDate))
		{
			datePicker._setSelectedDate(newDate, true);
			if (calendar)
				calendar.hide();
		}
		else
		{
			if (calendar)
				calendar.clearHighlight();
			datePicker.clear();
			this.setInvalidStyle(true);
		}
	}
	this.onBlur.notify(new nitobi.ui.ElementEventArgs(this, this.onBlur));
}

/**
 * Just to allow the user to hit "enter" to set the new date.
 * @private
 */
nitobi.calendar.DateInput.prototype.handleOnKeyDown = function(event)
{
	var key = event.keyCode;
	if (key == 13)
	{
		this.getHtmlNode("input").blur();
	}
}

/**
 * Sets the input to the invalid style.
 * @param {Boolean} isInvalid true to set the input to the invalid style, false to return the input to the normal style.
 */
nitobi.calendar.DateInput.prototype.setInvalidStyle = function(isInvalid)
{
	var Css = nitobi.html.Css;
	var container = this.getHtmlNode("container");
	if (isInvalid)
		Css.swapClass(container, "ntb-inputcontainer", "ntb-invalid");
	else
		Css.swapClass(this.getHtmlNode("container"), "ntb-invalid", "ntb-inputcontainer");

	var bgColor = Css.getStyle(container, "backgroundColor");
	var input = this.getHtmlNode("input");
	Css.setStyle(input, "backgroundColor", bgColor);
}

/**
 * Return the edit mask for the DateInput.  The edit mask is applied to the value in the input field when
 * the input if focussed.  This is to make date entry easier for the user.  Will default to the value of the display mask.
 * @see #setEditMask
 * @type String
 */
nitobi.calendar.DateInput.prototype.getEditMask = function()
{
	return this.getAttribute("editmask", this.getDisplayMask());
}

/**
 * Sets the edit mask.
 * <br/>
 * Date masking syntax is as follows (for the sample date January 30, 2009):
 * 	<ul>
 * 		<li>yyyy - 2009</li>
 * 		<li>yy - 09</li>
 * 		<li>M - 1</li>
 * 		<li>MM - 01</li>
 * 		<li>MMM - January</li>
 *		<li>NNN - Jan</li>
 * 		<li>d - 30</li>
 * 		<li>dd - 30</li>
 * 		<li>EE - Friday</li>
 * 		<li>E - Fri</li>
 * 	</ul>
 * @param {String} mask The edit mask to set.
 */
nitobi.calendar.DateInput.prototype.setEditMask = function(mask)
{
	this.setAttribute("editmask", mask);
}

/**
 * Returns the display mask for the DateInput.  The display mask is used to make the date in the input
 * more human readable.  Defaults to "MMM dd yyyy", e.g. "June 24 2008".
 * @see #setDisplayMask
 * @type String
 */
nitobi.calendar.DateInput.prototype.getDisplayMask = function()
{
	return this.getAttribute("displaymask", "MMM dd yyyy");
}

/**
 * Sets the display mask.
 * <br/>
 * Date masking syntax is as follows (for the sample date January 30, 2009):
 * 	<ul>
 * 		<li>yyyy - 2009</li>
 * 		<li>yy - 09</li>
 * 		<li>M - 1</li>
 * 		<li>MM - 01</li>
 * 		<li>MMM - January</li>
 *		<li>NNN - Jan</li>
 * 		<li>d - 30</li>
 * 		<li>dd - 30</li>
 * 		<li>EE - Friday</li>
 * 		<li>E - Fri</li>
 * 	</ul>
 * @param {String} mask The display mask to set.
 */
nitobi.calendar.DateInput.prototype.setDisplayMask = function(mask)
{
	this.setAttribute("displaymask", mask);
}

/**
 * Returns true if the input editing is disabled, false otherwise.
 * @type Boolean
 */
nitobi.calendar.DateInput.prototype.isEditable = function()
{
	this.getBoolAttribute("editable", true);
}

/**
 * Sets the the Input to either be editable or non-ediatble.
 * @param {String} editable True to have the input be editable, false otherwise.
 */
nitobi.calendar.DateInput.prototype.setEditable = function(dis)
{
	this.setBoolAttribute("editable", dis);
	this.getHtmlNode("input").disabled = dis;
}

/**
 * Returns the width of the input.  This can be defined either in the declaration or via css.  
 * The appropriate css selector is <code>ntb-dateinput</code>
 * @type Number
 */
nitobi.calendar.DateInput.prototype.getWidth = function()
{
	this.getIntAttribute("width");
}

/**
 * Sets the width of the input.  You must call {@link nitobi.calendar.DatePicker#render} to have
 * the change be visible.
 * @example
 * var dp = nitobi.getComponent("myDatePicker");
 * var input = dp.getInput();
 * input.setWidth("150px");
 * @param {String} width The width of the Input in px.
 */
nitobi.calendar.DateInput.prototype.setWidth = function(width)
{
	this.setAttribute("width", width);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.calendar");

/**
 * Creates a a renderer for the Calendar class.
 * @class This class provides the renderToString function necessary to render 
 * the DatePicker.  The renderer expects its datePicker to return itself (<code>this</code>) 
 * from the <code>getState</code> function.
 * @private
 * @constructor
 * @extends nitobi.html.IRenderer
 */
nitobi.calendar.CalRenderer = function()
{
	nitobi.html.IRenderer.call(this);
};

nitobi.lang.implement(nitobi.calendar.CalRenderer, nitobi.html.IRenderer);

/**
 * Transform the given data with the template.
 * @param {XMLDocument|String} data the data to transform.
 * @return The result of the transformation as a string.
 * @type String
 */
nitobi.calendar.CalRenderer.prototype.renderToString = function(calendar)
{
	var datePicker = calendar.getParentObject();
	var eventsManager = datePicker.getEventsManager();
	
	var dm = nitobi.base.DateMath;
	var sb = new nitobi.lang.StringBuilder();
	var id = calendar.getId();
	
	var monthColumns = calendar.getMonthColumns();
	var monthRows = calendar.getMonthRows();
	
	var isMultiMonth = monthColumns > 1 || monthRows > 1;
	
	// Reset time so it is easier to compare date values directly
	var startDate = dm.resetTime(dm.clone(datePicker.getStartDate()));
	var selectedDate = datePicker.getSelectedDate();
	if (selectedDate != null)
		selectedDate = dm.resetTime(datePicker.getSelectedDate());
	var today = dm.resetTime(new Date());
	var minDate = datePicker.getMinDate();
	var maxDate = datePicker.getMaxDate();
	
	var lastMonth = dm.subtract(dm.clone(startDate), 'd', 1);
	var nextMonth = dm.add(dm.clone(startDate), 'm', monthColumns * monthRows);
	
	datePicker.disPrev = (minDate && dm.before(lastMonth, minDate)?true:false);
	datePicker.disNext = (maxDate && dm.after(nextMonth, maxDate)?true:false);
	
	var monthNames = datePicker.getLongMonthNames();
	var dayNames = datePicker.getLongDayNames();
	var weekDays = datePicker.getMinDayNames();
	
	var monthTooltip = datePicker.getQuickNavTooltip();
	
	// Enable shim only for FF2 on Mac and IE6
	var enableShim = (((nitobi.browser.MOZ && !document.getElementsByClassName && navigator.platform.indexOf("Mac") >= 0) || nitobi.browser.IE6) && datePicker.isShimEnabled())?true:false;
	if (enableShim)
		sb.append("<iframe id=\"" + id + ".shim\" style='position:absolute;top:0px;z-index:19999;'><!-- dummy --></iframe>");
	sb.append("<div id=\"" + id + ".calendar\" style=\"" + (enableShim?"position:relative;z-index:20000;":"") + "\">");
	
	sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
		if (isMultiMonth)
		{
			sb.append("<tr id=\"" + id + ".header\"><td>");
			var startMonth = monthNames[startDate.getMonth()];
			var startYear = startDate.getFullYear();
			var endDate = dm.add(dm.clone(startDate), 'm', (monthColumns * monthRows) - 1);
			var endMonth = monthNames[endDate.getMonth()];
			var endYear = endDate.getFullYear();
			sb.append("<div class=\"ntb-calendar-header\">");
				sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"height:100%;width:100%;\"><tbody>");
				sb.append("<tr><td><a id=\"" + id + ".prevmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-prev" + (datePicker.disPrev?" ntb-calendar-prevdis":"") + "\"></a</td>");
				sb.append("<td style=\"width:70%;\"><span class=\"ntb-calendar-title\" title=\"" + monthTooltip + "\" id=\"" + id + ".nav\">" + startMonth + " " + startYear + " - " + endMonth + " " + endYear + "</span></td>");
				sb.append("<td><a id=\"" + id + ".nextmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-next" + (datePicker.disNext?" ntb-calendar-nextdis":"") + "\"></a></td></tr>");
				sb.append("</tbody></table></div></td></tr>")
		}
		
		sb.append("<tr id=\"" + id + ".body\"><td>");
		sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
		for (var i = 0; i < monthRows; i++)
		{
			sb.append("<tr>");
			for (var j = 0; j < monthColumns; j++)
			{
				var calDate = dm.subtract(dm.clone(startDate), 'd', startDate.getDay());
				var currentMonth = startDate.getMonth();
				var currentYear = startDate.getFullYear();
				
				sb.append("<td>");
				sb.append("<div class=\"ntb-calendar\">");
					sb.append("<div><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:100%;\"><tbody>");
						sb.append("<tr class=\"ntb-calendar-monthheader\">");
							if (!isMultiMonth)
								sb.append("<td><a id=\"" + id + ".prevmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-prev" + (datePicker.disPrev?" ntb-calendar-prevdis":"") + "\"></a></td>");
							sb.append("<td style=\"width:70%;\"><span title=\"" + monthTooltip + "\" " + (!isMultiMonth?"id=\"" + id + ".nav\"":"") + "><a onclick=\"return false;\" href=\"#\" style=\"" + (isMultiMonth?"cursor:default;":"") + "\" class=\"ntb-calendar-month\">" + monthNames[currentMonth] + "</a>");
							sb.append("<a onclick=\"return false;\" href=\"#\" style=\"" + (isMultiMonth?"cursor:default;":"") + "\" class=\"ntb-calendar-year\">" + " " + currentYear + "</a></span></td>");
							if (!isMultiMonth)
								sb.append("<td><a id=\"" + id + ".nextmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-next" + (datePicker.disNext?" ntb-calendar-nextdis":"") + "\"></a></td>");
					sb.append("</tbody></table></div>");
					sb.append("<div><table id=\"" + id + "." + currentMonth + "." + currentYear + "\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width: 100%;\"><tbody>");
					sb.append("<tr>");
					for (var k = 0; k < 7; k++)
					{
						sb.append("<th class=\"ntb-calendar-dayheader\">" + weekDays[k] + "</th>");
					}
					sb.append("</tr>");
					for (var m = 0; m < 6; m++)
					{
						sb.append("<tr>");
						for (var n = 0; n < 7; n++)
						{
							sb.append("<td>");
							var title = dayNames[calDate.getDay()] + ", " + monthNames[calDate.getMonth()] + " " + calDate.getDate() + ", " + calDate.getFullYear();
							var dayEvents = null;
							var extraStyle = "";
							if(eventsManager && calDate.getMonth() == startDate.getMonth())
							{
								var dayEvents = eventsManager.dates.events[calDate.valueOf()];
								if(dayEvents != null)
								{
									var nt = "";
									for(var p = 0; p < dayEvents.length; p++)
									{
										if(dayEvents[p].tooltip != null)
											nt+=dayEvents[p].tooltip + "\n";
										else if(dayEvents[p].location != null)
										{
											nt+=dayEvents[p].location +  "\n";
											if(dayEvents[p].description != null)
												nt+= dayEvents[p].description;
										}
										if(dayEvents[p].cssStyle != null)
											extraStyle+=dayEvents[p].cssStyle;
									}
									if(nt.length != 0)
										title = nt;		
								}
							}
							
							sb.append("<a ebatype=\"date\" ebamonth=\"" + calDate.getMonth() + "\" ebadate=\"" + calDate.getDate() + "\" ebayear=\"" + calDate.getFullYear() + "\" title=\"" + title + "\" href=\"#\" onclick=\"return false;\" style=\"display:block;text-decoration:none;" + extraStyle + "\" class=\"");
							if (selectedDate && calDate.valueOf() == selectedDate.valueOf() && calDate.getMonth() == startDate.getMonth())
								sb.append("ntb-calendar-currentday ");
							
							if (calDate.getMonth() < startDate.getMonth() || (minDate && calDate.valueOf() < minDate.valueOf())) sb.append("ntb-calendar-lastmonth ");
							else if (calDate.getMonth() > startDate.getMonth() || (maxDate && calDate.valueOf() > maxDate.valueOf())) sb.append("ntb-calendar-nextmonth ");
							else if (calDate.getMonth() == startDate.getMonth()) sb.append("ntb-calendar-thismonth ");
							
							if (eventsManager && eventsManager.isDisabled(calDate) && calDate.getMonth() == startDate.getMonth())
							{	
								sb.append("ntb-calendar-disabled ");
							}
							else if (eventsManager && eventsManager.isEvent(calDate) && calDate.getMonth() == startDate.getMonth())
							{
								sb.append("ntb-calendar-event ");	
							}
							
							if (today.valueOf() == calDate.valueOf())
								sb.append("ntb-calendar-today");
							
							sb.append(" ntb-calendar-day");
							
							// Why are we looping through the events again?
							if(dayEvents != null)
								for(var p = 0; p < dayEvents.length; p++)
									if(dayEvents[p].cssClass != null)
										sb.append(" " + dayEvents[p].cssClass + " ");

							sb.append("\">"+calDate.getDate()+"</a></td>");
							
							calDate = dm.add(calDate, 'd', 1);
						}
						sb.append("</tr>"); 
					}
					sb.append("</tbody></table></div></div></td>");
				
				startDate = dm.resetTime(dm.add(startDate, 'm', 1));
			}
			sb.append("</tr>");
		}
		sb.append("</tbody></table></td></tr></tbody></table></div></div>");
	sb.append("</tbody><colgroup span=\"7\" style=\"width:17%\"></colgroup></table></div>");
	sb.append("<div id=\"" + id + ".overlay\" class=\"ntb-calendar-overlay\" style=\"" + (enableShim?"z-index:20001;":"") + "top:0px;left:0px;display:none;position:absolute;background-color:gray;filter:alpha(opacity=40);-moz-opacity:.50;opacity:.50;\"></div>");
	sb.append(this.renderNavPanel(calendar));
	sb.append("</div></div>");
	return sb.toString();
}

/**
 * Renders the quick nav panel.
 * @param {nitobi.calendar.Calendar} calendar The Calendar object that the nav panel is bound to.
 */
nitobi.calendar.CalRenderer.prototype.renderNavPanel = function(calendar)
{
	var sb = new nitobi.lang.StringBuilder();
	var datePicker = calendar.getParentObject();

	var monthNames = datePicker.getLongMonthNames();
	var id = calendar.getId();
	var enableShim = (nitobi.browser.MOZ && !nitobi.browser.MOZ3) || (nitobi.browser.IE6 && !nitobi.browser.IE7)?true:false;
	
	sb.append("<div id=\"" + id + ".navpanel\" style=\"" + (enableShim?"z-index:20002;":"") + "position:absolute;top:0px;left:0px;overflow:hidden;\" class=\"ntb-calendar-navcontainer nitobi-hide\">");
		sb.append("<div class=\"ntb-calendar-monthcontainer\">");
			sb.append("<label style=\"display:block;\" for=\"" + id + ".months\">" + datePicker.getNavSelectMonthText() + "</label>");
			sb.append("<select id=\"" + id + ".months\" class=\"ntb-calendar-navms\" style=\"\" tabindex=\"1\">");
			for (var i = 0; i < monthNames.length; i++)
			{
				sb.append("<option value=\"" + i + "\">" + monthNames[i] + "</option>");
			}
			sb.append("</select>");
		sb.append("</div>");
		sb.append("<div class=\"ntb-calendar-yearcontainer\">");
			sb.append("<label style=\"display:block;\" for=\"" + id + ".year\">" + datePicker.getNavSelectYearText() + "</label>");
			sb.append("<input size=\"4\" maxlength=\"4\" id=\"" + id + ".year\" class=\"ntb-calendar-navinput\" style=\"-moz-user-select: normal;\" tabindex=\"2\"/>");
		sb.append("</div>");
		sb.append("<div class=\"ntb-calendar-controls\">");
			sb.append("<button id=\"" + id + ".navconfirm\" type=\"button\">" + datePicker.getNavConfirmText() + "</button>");
			sb.append("<button id=\"" + id + ".navcancel\" type=\"button\">" + datePicker.getNavCancelText() + "</button>");
		sb.append("</div>");
		sb.append("<div id=\"" + id + ".warning\" style=\"display:none;\" class=\"ntb-calendar-navwarning\">You must enter a valid year.</div>");
	sb.append("</div>");
	return sb.toString();
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.calendar');

/**
 * Creates the EventsManager used by the {@link nitobi.calendar.DatePicker} to manage all events dates and disabled dates.
 * @class The EventsManager allows the DatePicker to easily manage which dates have related event information
 * and which dates are disabled.  When the DatePicker is rendered, it uses the EventsManager to issue and XHR to the
 * server before rendering.
 * @constructor
 * @param {String} url The url that supplies the EventsManager with its event and disabled date information.
 * @see nitobi.calendar.DatePicker
 */
nitobi.calendar.EventsManager = function(url)
{
	/**
	 * Manages the xhr requests.
	 * @type nitobi.data.UrlConnector
	 */
	this.connector = new nitobi.data.UrlConnector(url);
	/**
	 * Fired when the data has been retrieved from the server.
	 * @type nitobi.base.Event
	 */
	this.onDataReady = new nitobi.base.Event();
	
	/**
	 * @private
	 */
	this.dates = {events: {}, disabled: {}};
	/**
	 * @private
	 */
	this.eventsCache = {};
	/**
	 * @private
	 */
	this.disabledCache = {};
}

/**
 * Returns true if the date has event information.
 * @param {Date} date The date to check for event information.
 * @type Boolean
 */
nitobi.calendar.EventsManager.prototype.isEvent = function(date)
{
	return (this.eventsCache[date.valueOf()]?true:false);
}

/**
 * Returns true if the date is disabled.
 * @param {Date} date The date to check if it's disabled.
 * @type Boolean
 */
nitobi.calendar.EventsManager.prototype.isDisabled = function(date)
{
	return (this.disabledCache[date.valueOf()]?true:false);
}

/**
 * Issues the XHR to the server.  If the EventsManager isn't connected to a url,
 * it simply notifies its onDataReady event.
 * @private
 */
nitobi.calendar.EventsManager.prototype.getFromServer = function()
{
	if (this.connector.url != null)
		this.connector.get({}, nitobi.lang.close(this, this.getComplete));
	else
		this.onDataReady.notify();	
}

/**
 * Parses the response from the server.
 * @private
 */
nitobi.calendar.EventsManager.prototype.getComplete = function(eventArgs)
{
	var data = eventArgs.result;
	var dm = nitobi.base.DateMath;
	var root = data.documentElement;
	var dates = nitobi.xml.getChildNodes(root);
	for (var i = 0; i < dates.length; i++)
	{
		var dateNode = dates[i];
		var type = dateNode.getAttribute("e");
		var parsedDate = {};
		if (type == "event")
		{
			var startDate = dateNode.getAttribute("a");
			startDate = dm.parseIso8601(startDate);
			parsedDate.startDate = startDate;
			var endDate = dateNode.getAttribute("b");
			if (endDate)
				endDate = dm.parseIso8601(endDate);
			else
				endDate = null;
			parsedDate.endDate = endDate;
			parsedDate.location = dateNode.getAttribute("c");
			parsedDate.description = dateNode.getAttribute("d");
			parsedDate.tooltip = dateNode.getAttribute("f");
			parsedDate.cssClass = dateNode.getAttribute("g");
			parsedDate.cssStyle = dateNode.getAttribute("h");

			var datesObj = this.dates.events[dm.resetTime(dm.clone(startDate)).valueOf()];
			if (datesObj)
			{
				datesObj.push(parsedDate);
			}
			else
			{
				datesObj = [parsedDate];
				this.dates.events[dm.resetTime(dm.clone(startDate)).valueOf()] = datesObj;
			}
			
			this.addEventDate(startDate, endDate);
		}
		else
		{
			var startDate = dm.parseIso8601(dateNode.getAttribute("a"))
			parsedDate.date = startDate;
			this.addDisabledDate(dm.clone(startDate));
		}
	}
	this.onDataReady.notify();
}

/**
 * Adds event information about a date.
 * @private
 */
nitobi.calendar.EventsManager.prototype.addEventDate = function(start, end)
{
	var dm = nitobi.base.DateMath;
	var startDate = dm.clone(start);
	startDate = dm.resetTime(startDate);
	if (!end)
		return this.eventsCache[startDate.valueOf()] = start;
	end = dm.clone(end);
	end = dm.resetTime(end);
	
	while (startDate.valueOf() <= end.valueOf())
	{
		this.eventsCache[startDate.valueOf()] = start;
		startDate = dm.add(startDate, 'd', 1);
	}
}

/**
 * Adds a date to disable.
 * @private
 */
nitobi.calendar.EventsManager.prototype.addDisabledDate = function(date)
{
	date = nitobi.base.DateMath.resetTime(date);
	return this.disabledCache[date.valueOf()] = true;
}

/**
 * Returns information about an event for some date.
 * @param {Date} date The date for which we'd like some event information.
 * @type Object
 */
nitobi.calendar.EventsManager.prototype.getEventInfo = function(date)
{
	var dm = nitobi.base.DateMath;
	var events = this.dates.events;
	date = dm.resetTime(date);
	return events[date.valueOf()];
}
