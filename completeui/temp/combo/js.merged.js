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
/**
 * @namespace The namespace for helper functions used by ComboBox
 * for cross browser compatibility.
 * @private
 * @constructor
 */
nitobi.Browser = function(){};

/**
 * The width of the scrollbar in pixels.  An alias for {@link nitobi.html.getScrollBarWidth}.
 */
nitobi.Browser.GetScrollBarWidth = nitobi.html.getScrollBarWidth;

/**
 * Returns the browser. Current only returns Browser.nitobi.Browser.IE or Browser.nitobi.Browser.UNKNOWN.</summary>
 */
nitobi.Browser.GetBrowserType = function ()
{
	return (navigator.appName == "Microsoft Internet Explorer" ? this.nitobi.Browser.IE : this.nitobi.Browser.UNKNOWN);
};

/**
 * Depending on the browser, this returns an object with detailed information. 
 * Browser specific. For IE it returns a clientInformation Object.
 */
nitobi.Browser.GetBrowserDetails = function ()
{
	return (this.GetBrowserType() == this.nitobi.Browser.IE ? window.clientInformation : null);
};

/**
 * Returns true if the object is visible to the user [AND at the top of the container] and false otherwise.
 * @param {Object} Object The object that you want to check.
 * @param {Object} Container The container in which the object resides.
 * @param {Boolean} Top If true, then check for in view AND at the top.
 * @param {Boolean} IgnoreHorizontal If true, then ignore check in the horizontal direction.
*/
nitobi.Browser.IsObjectInView = function(Object, Container, Top, IgnoreHorizontal){
	// The object is in view if its top left and bottom right are within
	// the bounds of the container.
	var objectRect = nitobi.html.getBoundingClientRect(Object);
	var containerRect = nitobi.html.getBoundingClientRect(Container);
	if(nitobi.browser.MOZ){
		containerRect.top += Container.scrollTop;
		containerRect.bottom += Container.scrollTop;
		containerRect.left += Container.scrollLeft;
		containerRect.right += Container.scrollLeft;
	}
	var inView = ( ( true==Top ? (objectRect.top == containerRect.top)
					: (objectRect.top >= containerRect.top) && (objectRect.bottom <= containerRect.bottom) ) &&
				 ( IgnoreHorizontal ? true : (objectRect.right <= containerRect.right) &&
					(objectRect.left >= containerRect.left) ) );

	return inView;
};

/**
 * @private
 */
nitobi.Browser.VAdjust = function (Object, Container)
{
	// AddPage() causes <table>...page1...</table> to become:
	// <table>...page1...</table><table>...page2...</table>
	// subsequent AddPage() calls append more tables;
	// therefore, getting Object.offsetTop is obviously not enough;
	// also need to add back the difference between the current table's
	// offsetTop and the first row's table's offsetTop
	
	var v = (Object.offsetParent ? Object.offsetParent.offsetTop : 0);
	var id = Object.id;
	var fid = id.substring(0, 1 + id.lastIndexOf("_")) + "0";
	
	// ownerDocument is in the w3c spec but ie5 doesn't support it.
	// < ie6 we need to use document.
	var ownerDocument = Container.ownerDocument;
	if (null == ownerDocument)
	{
		ownerDocument = Container.document;
	}

	
	var oF = ownerDocument.getElementById(fid);

	return v - (oF.offsetParent ? oF.offsetParent.offsetTop : 0);
};

/**
 * @private
 */
nitobi.Browser.WheelUntil = function(bool, inc, list, idx, last, container){
	var min = (inc ? -1 : 0);
	var max = (inc ? last : last + 1);
	while(idx > min && idx < max){
		if(inc)
			idx++;
		else
			idx--;
		var r = list.GetRow(idx);
		var test = this.IsObjectInView(r,container,false,true);
		if(test == bool)
			return idx;
	}
	return idx;
};

/**
 * Scrolls the container up so that the first row not in view comes into view.
 * Because onmousehweel currently only works in IE, code below will only be IE-specific for now
 * @param {Object} List ComboBox's list object.
 */
nitobi.Browser.WheelUp = function(List){
	var top = List.GetRow(0);
	var last = List.GetXmlDataSource().GetNumberRows() - 1;
	var bottom = List.GetRow(last);
	var container = List.GetSectionHTMLTagObject(EBAComboBoxListBody);
	// initial "guess-timate"
	var i = parseInt(container.scrollTop / top.offsetHeight);
	var r = (i > last ? bottom : List.GetRow(i));
	var delta = r.offsetTop - container.scrollTop + nitobi.Browser.VAdjust(r,container);
	if(this.IsObjectInView(r,container,false,true)){
		i = this.WheelUntil(false, false, List, i, last, container);
	}else{
		if(delta < 0){
			i = this.WheelUntil(true, true, List, i, last, container);
			i--;
		}
		else{
			i = this.WheelUntil(true, false, List, i, last, container);
			i = this.WheelUntil(false, false, List, i, last, container);
		}
	}
	this.ScrollIntoView(List.GetRow(i), container, true, false);
};

/**
 * Scrolls the container down so that the first row not in view comes into view.
 * Because onmousehweel currently only works in IE, code below will only be IE-specific for now
 * @param {Object} Container The container in which the list resides.
 * @param {Object} Top Top row in the container.
 */
nitobi.Browser.WheelDown = function(List)
{
	var top = List.GetRow(0);
	var last = List.GetXmlDataSource().GetNumberRows() - 1;
	var bottom = List.GetRow(last);
	var container = List.GetSectionHTMLTagObject(EBAComboBoxListBody);
	// initial "guess-timate"
	var i = parseInt(container.scrollTop / top.offsetHeight);
	var r = (i > last ? bottom : List.GetRow(i));
	
	var delta = r.offsetTop - container.scrollTop + nitobi.Browser.VAdjust(r,container);
	if(this.IsObjectInView(r,container,false,true))
	{
		i = 1 + this.WheelUntil(false, false, List, i, last, container);
	}
	else
	{
		if(delta < 0)
		{
			i = this.WheelUntil(true, true, List, i, last, container);
		}
		else
		{
			i = this.WheelUntil(true, false, List, i, last, container);
			i = 1 + this.WheelUntil(false, false, List, i, last, container);
		}
	}
	r = List.GetRow(i);
	delta = r.offsetTop - container.scrollTop + nitobi.Browser.VAdjust(r,container);
	if(0==delta && i!=last)
	{
		r = List.GetRow(1 + i);
	}
	
	this.ScrollIntoView(r, container, true, false);
};

/**
 * Moves the object into the user's view.
 * @param {Object} Object The object you want to view.
 * @param {Object} Container The container in which the object resides.
 * @param {Boolean} Top If true, then Object is scrolled to the top of the Container. Or else, just scrolls Object into Container's view.
 * @param {Boolean} Bottom If true, then Object is scrolled to the bottom of the Container. Or else, just scrolls Object into Container's view.
 */
nitobi.Browser.ScrollIntoView = function(Object, Container, Top, Bottom){
	// TODO: due to time constraints, the Bottom param was added as a quickie workaround;
	// it's VERY ugly! when there's time, please pretty it up the interface
	var objectRect = nitobi.html.getBoundingClientRect(Object);
	var containerRect = nitobi.html.getBoundingClientRect(Container);
	var topDelta = Object.offsetTop - Container.scrollTop;
	var v = nitobi.Browser.VAdjust(Object, Container);
	topDelta += v;
	var leftDelta = Object.offsetLeft - Container.scrollLeft;
	var rightDelta = leftDelta + Object.offsetWidth - Container.offsetWidth;
	var bottomDelta = topDelta + Object.offsetHeight - Container.offsetHeight;
	var rightScrollBarAdjustment = 0;
	var bottomScrollBarAdjustment = 0;
	var scrollbarSize=this.GetScrollBarWidth(Container);
	// we decided to take out horizontal scrolling (i.e overflow hidden)
//		if(this.GetHorizontalScrollBarStatus(Container)==true)
//			bottomScrollBarAdjustment=scrollbarSize;
	if(this.GetVerticalScrollBarStatus(Container)==true)
		rightScrollBarAdjustment=scrollbarSize;
	if (leftDelta < 0){
		//alert("too far left");
		Container.scrollLeft += leftDelta;
	}else{
		if (rightDelta > 0){
			//The object is too far right. Scroll but don't push the left corner out of view.
			if (objectRect.left - rightDelta > containerRect.left){
				Container.scrollLeft+=rightDelta + rightScrollBarAdjustment;
				//alert("Too far right: ");
			}else{
				// The width of the object is greater than the container so only
				// move as much as we can while still exposing the top left corner
				// of the object.
				Container.scrollLeft+=leftDelta;
				//alert("too far right but too big");
			}
		}
	}
	if ((topDelta < 0 || true==Top) && true!=Bottom){
		Container.scrollTop += topDelta;
		//alert("too far up");
	}else{
		if (bottomDelta > 0 || true==Bottom){
			// The object is too far down. Scoll but don't push the top out of view.
			if (objectRect.top - bottomDelta > containerRect.top || true==Bottom){
				Container.scrollTop += bottomDelta + bottomScrollBarAdjustment;
				//alert("Too far down:" + bottomScrollBarAdjustment);
			}else{
				// The height of the object is greater than the height of the container so only
				// move as much as we can while still exposing the top left corner of the object.
				Container.scrollTop += topDelta;
				//alert("too far down but too big");
			}
		}
	}
};

/**
 * Returns the status of the vertical scrollbars in a container.
 * @param {Object} Container The element whose vertical scrollbars status we want.
 */
nitobi.Browser.GetVerticalScrollBarStatus = function(Container){
	return this.GetScrollBarWidth(Container) > 0;
};

/**
 * Returns the status of the horizontal scrollbars.
 * @param {Object} Container The element whose horizontal scrollbars status we want.
 */
nitobi.Browser.GetHorizontalScrollBarStatus = function(Container){
	return (Container.scrollWidth > Container.offsetWidth - this.GetScrollBarWidth(Container));
};

/**
 * Given a string that has been encoded with HTMLEncode, returns the string unencoded.
 * @param {String} EncodedString The encoded string.
 */
nitobi.Browser.HTMLUnencode = function(EncodedString)
{
	var unencodedString = EncodedString;
	// Regular expression to match encodings for various special
	// charachters.
	var searches = new Array(/&amp;/g, /&lt;/g, /&quot;/g, /&gt;/g, /&nbsp;/g);
	var replacements = new Array("&","<","\"",">"," ");
	
	// Search for each string using the regular expression and replace it.
	for (var i = 0; i < searches.length; i++)
	{
		unencodedString = unencodedString.replace(searches[i],replacements[i]);
	}
	return (unencodedString);
};


/**
 * Looks within the attributes of a string represented tag markup, and encodes angle brackets as &lt; and &gt;
 * Returns the markup with the brackets inside the atts encoded.
 * @param {String} str Tag markup
 * @type String
 */
nitobi.Browser.EncodeAngleBracketsInTagAttributes = function(str)
{
	//TODO: The Combo ptr should be replaced when the new debug system is installed.
	// Careful, the DOM will replace "&quote;" with '"'. Reverse this behaviour.
	str=str.replace(/'"'/g,"\"&quot;\"");
	var vals = str.match(/".*?"/g);
	if (vals)
	{
		for (var i =0;i<vals.length;i++)
		{
			val = vals[i];
			val = val.replace(/</g,"&lt;");
			val = val.replace(/>/g,"&gt;");
			str=str.replace(vals[i],val);
		}
	}
	return str;
};

/**
 * Returns a page from an URL syncronously.  The contents of the page.
 * @param {String} Url The url from which to retrieve data.
 * @type String
 */
nitobi.Browser.LoadPageFromUrl = function(Url,RequestMethod)
{
	if (RequestMethod == null) RequestMethod = "GET";
	var httpRequest=new nitobi.ajax.HttpRequest();
	httpRequest.responseType = "text";
	httpRequest.abort();
	httpRequest.open(RequestMethod, Url, false, "", "");
	httpRequest.send("EBA Combo Box Get Page Request");
	return (httpRequest.responseText);
};

/**
 * Given an HTML measurement type such as 100px or 100% returns px or %.
 * Returns % or px or another html measurement type
 * @param {String} Unit The unit such as 100px.
 * @type String
 */
nitobi.Browser.GetMeasurementUnitType = function(Unit)
{
	if (Unit==null || Unit=="") return "";
	var index = Unit.search(/\D/g);
	var mType = Unit.substring(index);
	return (mType);
};


/**
 * Given an HTML measurement type such as 100px or 100% returns 100.
 * @param {String} Unit The unit such as 100px
 * @type String 
 */
nitobi.Browser.GetMeasurementUnitValue = function(Unit)
{
	var index = Unit.search(/\D/g);
	var mValue = Unit.substring(0,index);
	return Number(mValue);
};


/**
 * Returns the actual width of an html element in px.
 * @parm {Object} Element The html element whose size you want.
 * @type Number
 */
nitobi.Browser.GetElementWidth = function(Element)
{
	if (Element==null) throw ("Element in GetElementWidth is null");
	var estyle = Element.style;
	var top = estyle.top;
	var display = estyle.display;
	var position = estyle.position;
	var visibility = estyle.visibility;
	
	var cVisibility = nitobi.html.Css.getStyle(Element,"visibility");
	var cDisplay = nitobi.html.Css.getStyle(Element,"display");
	var fudge = 0;
	if (cDisplay=="none" || cVisibility=="hidden")
	{
		estyle.position = "absolute";
		estyle.top = -1000;
		estyle.display="inline";
		estyle.visibility="visible";
	}
	var width = nitobi.html.getWidth(Element);
	if (estyle.display=="inline")
	{
		estyle.position = position;
		estyle.top = top;
		estyle.display=display;	
		estyle.visibility=visibility;
	}
	

	return parseInt(width);
};

/**
 * Returns the actual Height of an html element in px.
 * @param {Object} Element The html element whose size you want.
 * @type Number
 */
nitobi.Browser.GetElementHeight = function(Element)
{
	if (Element==null) throw ("Element in GetElementHeight is null");
	var estyle = Element.style;
	var top = estyle.top;
	var display = estyle.display;
	var position = estyle.position;
	var visibility = estyle.visibility;
	if (estyle.display=="none" || estyle.visibility!="visible")
	{
		estyle.position = "absolute";
		estyle.top = "-1000px";
		estyle.display="inline";
		estyle.visibility="visible";
	}
	var height = nitobi.html.getHeight(Element);
	
	if (estyle.display=="inline")
	{
		estyle.position = position;
		estyle.top = top;
		estyle.display=display;	
		estyle.visibility=visibility;
	}
	return parseInt(height);
};

/**
 * Searches through the parent hierarchy to find an element with the specified tagname.
 * @param {HTMLElement} Element The element whose parent you want to find.
 * @param {String} TagName The name of the tag.
 * @type Object
 */
nitobi.Browser.GetParentElementByTagName = function(Element, TagName)
{
	TagName=TagName.toLowerCase();
	var currentTag;
	do 
	{
		Element=Element.parentElement;
		if (Element!=null)
		{
			currentTag=Element.tagName.toLowerCase();
		}
		
	} while((currentTag!=TagName) && (Element!=null))
	return Element;
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.drawing");

nitobi.drawing.rgb = function(r,g,b) 
{
  	return "#"+((r*65536)+(g*256)+b).toString(16);
}

/**
 * Aligns two DOM nodes on in the web browser.
 * @param {HtmlElement} source
 * @param {HtmlElement} target
 * @param {BitMask} align
 * @param {Number} oh The height offset for the target HtmlElement.
 * @param {Number} ow The width offset for the target HtmlElement.
 * @param {Number} oy The left offset for the target HtmlElement.
 * @param {Number} ox The top offset for the target HtmlElement.
 */
nitobi.drawing.align = function(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox,show)
{
	oh=oh || 0;
	ow=ow || 0;
	oy=oy || 0;
	ox=ox || 0;
	var a=AlignBit_HWTBLRCM;
	var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;

//CROSS BROWSER
	if (true)
	{
		//	this is for IE
		td=target.getBoundingClientRect();
		sd=source.getBoundingClientRect();
		tt=td.top;
		tb=td.bottom;
		tl=td.left;
		tr=td.right;
		th=Math.abs(tb-tt);
		tw=Math.abs(tr-tl);
		st=sd.top;
		sb=sd.bottom;
		sl=sd.left;
		sr=sd.right;
		sh=Math.abs(sb-st);
		sw=Math.abs(sr-sl);
	}/*
	if (nitobi.browser.MOZ)
	{
		//	this is for Mozilla
		td = document.getBoxObjectFor(target);
		sd = document.getBoxObjectFor(source);

		tt = td.y;
		tl = td.x;
//		tt=td.screenY;
//		tl=td.screenX;
		tw = td.width;
		th = td.height;

//		st=sd.screenY;
//		sl=sd.screenX;
		st = sd.y;
		sl = sd.x;
		sw = sd.width;
		sh = sd.height;
	} */

	if (a&0x10000000) source.style.height=th+oh; // make same height
	if (a&0x01000000) source.style.width=tw+ow; // make same width
	if (a&0x00100000) source.style.top = nitobi.html.getStyleTop(source)+tt-st+oy; // align top
	if (a&0x00010000) source.style.top = nitobi.html.getStyleTop(source)+tt-st+th-sh+oy; // align bottom
	if (a&0x00001000) source.style.left = nitobi.html.getStyleLeft(source)-sl+tl+ox; // align left
	if (a&0x00000100) source.style.left = nitobi.html.getStyleLeft(source)-sl+tl+tw-sw+ox; // align right
	if (a&0x00000010) source.style.top = nitobi.html.getStyleTop(source)+tt-st+oy+Math.floor((th-sh)/2); // align middle vertically
	if (a&0x00000001) source.style.left = nitobi.html.getStyleLeft(source)-sl+tl+ox+Math.floor((tw-sw)/2); // align middle horizontally

	if (show) {
		src.style.top=st-2;
		src.style.left=sl-2;
		src.style.height=sh;
		src.style.width=sw;
		tgt.style.top=tt-2;
		tgt.style.left=tl-2;
		tgt.style.height=th;
		tgt.style.width=tw;

		if (document.getBoundingClientRect) { 
			sd=source.getBoundingClientRect();
			st=sd.top;
			sb=sd.bottom;
			sl=sd.left;
			sr=sd.right;
			sh=Math.abs(sb-st);
			sw=Math.abs(sr-sl);
		}
		if (document.getBoxObjectFor) { 
			sd = document.getBoxObjectFor(source); 
	//		st=sd.y;
	//		sl=sd.x;
			st=sd.screenY;
			sl=sd.screenX;
			sw=sd.width;
			sh=sd.height;
		}  

		src2.style.top=st-2;
		src2.style.left=sl-2;
		src2.style.height=sh;
		src2.style.width=sw;
	}
}

/**
 * Bit mask for aligning two HtmlElements with the same height.
 */
nitobi.drawing.align.SAMEHEIGHT				=0x10000000;
/**
 * Bit mask for aligning two HtmlElements with the same width.
 */
nitobi.drawing.align.SAMEWIDTH				=0x01000000;
/**
 * Bit mask for aligning two HtmlElements to the same top edge.
 */
nitobi.drawing.align.ALIGNTOP				=0x00100000;
/**
 * Bit mask for aligning two HtmlElements to the same bottom edge.
 */
nitobi.drawing.align.ALIGNBOTTOM			=0x00010000;
/**
 * Bit mask for aligning two HtmlElements to the same left edge.
 */
nitobi.drawing.align.ALIGNLEFT				=0x00001000;
/**
 * Bit mask for aligning two HtmlElements to the same right edge.
 */
nitobi.drawing.align.ALIGNRIGHT				=0x00000100;
/**
 * Bit mask for aligning two HtmlElements to the same height.
 */
nitobi.drawing.align.ALIGNMIDDLEVERT		=0x00000010;
nitobi.drawing.align.ALIGNMIDDLEHORIZ		=0x00000001;

nitobi.drawing.alignOuterBox = function(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox,show)
{
	oh=oh || 0;
	ow=ow || 0;
	oy=oy || 0;
	ox=ox || 0;
/*
	if (nitobi.browser.MOZ)
	{
		//	this is for Mozilla
		td = document.getBoxObjectFor(target);
		sd = document.getBoxObjectFor(source);

		var borderLeftTarget = parseInt(document.defaultView.getComputedStyle(target, '').getPropertyValue('border-left-width'));
		var borderTopTarget = parseInt(document.defaultView.getComputedStyle(target, '').getPropertyValue('border-top-width'));

		var borderTop = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-top-width'));
		var borderBottom = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-bottom-width'));

		var borderLeft = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-left-width'));
		var borderRight = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-right-width'));

		oy = oy + borderTop - borderTopTarget;
		ox = ox + borderLeft - borderLeftTarget;
	}
*/
	nitobi.drawing.align(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox,show);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");

/**
 * The combo's button.
 * @class The button that is rendered for the ComboBox.
 * @constructor
 * @param {Object} userTag The HTML object that represents Button
 * @param {Object} comboObject The parent {@link nitobi.combo.Combo} object.
 * @see nitobi.combo.Combo
 */
nitobi.combo.Button = function(userTag, comboObject)
{
	try{

		var DEFAULTCLASSNAME="ntb-combobox-button";
		var DEFAULTPRESSEDCLASSNAME="ntb-combobox-button-pressed";
		var DEFAULTWIDTH="";
		var DEFAULTHEIGHT="";
		this.SetCombo(comboObject);

		var width=(userTag ? userTag.getAttribute("Width") : null);
		((null == width) || (width == ""))
			? this.SetWidth(DEFAULTWIDTH)
			: this.SetWidth(width);

		var height=(userTag ? userTag.getAttribute("Height") : null);
		((null == height) || (height == ""))
			? this.SetHeight(DEFAULTHEIGHT)
			: this.SetHeight(height);

		var dccn=(userTag ? userTag.getAttribute("DefaultCSSClassName") : null);
		((null == dccn) || (dccn == ""))
			? this.SetDefaultCSSClassName(DEFAULTCLASSNAME)
			: this.SetDefaultCSSClassName(dccn);

		var pccn=(userTag ? userTag.getAttribute("PressedCSSClassName") : null);
		((null == pccn) || (pccn == ""))
			? this.SetPressedCSSClassName(DEFAULTPRESSEDCLASSNAME)
			: this.SetPressedCSSClassName(pccn);

		this.SetCSSClassName(this.GetDefaultCSSClassName());
		/**
		 * @private
		 */
		this.m_userTag = userTag;
		/**
		 * @private
		 */
		this.m_prevImgClass = "ntb-combobox-button-img";

	}catch(err){


	}
}

/**
 * @private
 * @ignore
 */
nitobi.combo.Button.prototype.Unload = function()
{}

/**
 * The name of the CSS class that defines the combo's button in the normal position. Does not include the dot in the class name.
 * @type String
 */
nitobi.combo.Button.prototype.GetDefaultCSSClassName = function()
{
	return this.m_DefaultCSSClassName;
}

/**
 * Sets the name of the CSS class that defines the combo's button in the normal position.
 * If this is left as an empty string, then the 'ComboBoxButton' class is used.  Refer to the CSS file 
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can 
 * include a custom class by using the HTML style tags or by using a stylesheet.
 * @param {String} DefaultCSSClassName The name of the CSS class that defines the combo's button. Do not include the dot in the class name.
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see nitobi.combo.List#SetCSSClassName
 * @see nitobi.combo.TextBox#GetCSSClassName
 * @see #GetDefaultCSSClassName
 * @see #SetPressedCSSClassName
 */
nitobi.combo.Button.prototype.SetDefaultCSSClassName = function(DefaultCSSClassName)
{
	this.m_DefaultCSSClassName = DefaultCSSClassName;
}

/**
 * The name of the CSS class that defines the combo's button in the pressed position.
 * If this is left as an empty string, then the 'ComboBoxButtonPressed' class is used.  Refer to the CSS file 
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can 
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @type String
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see nitobi.combo.List#SetCSSClassName
 * @see nitobi.combo.TextBox#GetCSSClassName
 * @see #GetDefaultCSSClassName
 * @see #SetPressedCSSClassName
 */
nitobi.combo.Button.prototype.GetPressedCSSClassName = function()
{	
	return this.m_PressedCSSClassName;
}

/**
 * Sets the name of the CSS class that defines the combo's button in the pressed position. 
 * If this is left as an empty string, then the 'ComboBoxButtonPressed' class is used.  Refer to the CSS file 
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can 
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @param {String} PressedCSSClassName The name of the CSS class that defines the combo's button in the pressed position. Do not include the dot in the class name.
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see nitobi.combo.List#SetCSSClassName
 * @see nitobi.combo.TextBox#GetCSSClassName
 * @see #GetDefaultCSSClassName
 * @see #SetPressedCSSClassName
 */
nitobi.combo.Button.prototype.SetPressedCSSClassName = function(PressedCSSClassName)
{
	this.m_PressedCSSClassName = PressedCSSClassName;
}

/**
 * Returns the button's height in HTML units, e.g. 16px.
 * @type String
 * @see #SetHeight
 * @see #SetWidth
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.TextBox#GetHeight
 * @see nitobi.combo.List#GetHeight
 */
nitobi.combo.Button.prototype.GetHeight = function()
{
	return (null == this.m_HTMLTagObject ? this.m_Height : this.m_HTMLTagObject.style.height);
}

/**
 * Sets the button's height in HTML units, e.g. 16px.
 * This will not stretch the button image.
 * @param {String} Height The button's height in HTML units, e.g. 16px.
 * @see #SetHeight
 * @see #SetWidth
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.TextBox#GetHeight
 * @see nitobi.combo.List#GetHeight
 */
nitobi.combo.Button.prototype.SetHeight = function (Height)
{
	if(null==this.m_HTMLTagObject)
		this.m_Height = Height;
	else
		this.m_HTMLTagObject.style.height = Height;
}

/**
 * Returns the button's width in HTML units, e.g. 16px.
 * @type String
 * @see #SetHeight
 * @see #SetWidth
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.TextBox#GetHeight
 * @see nitobi.combo.List#GetHeight
 */
nitobi.combo.Button.prototype.GetWidth = function ()
{
	if(null==this.m_HTMLTagObject)
		return this.m_Width;
	else
		return this.m_HTMLTagObject.style.width;
}

/**
 * Sets the button's width in HTML units, e.g. 16px.
 * This will not stretch the button image.
 * @param {String} Width The button's width in HTML units, e.g. 16px.
 * @see #SetHeight
 * @see #SetWidth
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.TextBox#GetHeight
 * @see nitobi.combo.List#GetHeight
 */
nitobi.combo.Button.prototype.SetWidth = function (Width)
{
	if(null==this.m_HTMLTagObject)
		this.m_Width = Width;
	else
		this.m_HTMLTagObject.style.width = Width;
}

/**
 * Returns the HTML tag. Only available after initialize has been called.
 * @type Object
 * @private
 */
nitobi.combo.Button.prototype.GetHTMLTagObject = function ()
{
	return this.m_HTMLTagObject;
}

/**
 * Sets the HTML tag.  Only available after initialize has been called.
 * @param {Object} HTMLTagObject The HTML Object
 * @private
 */
nitobi.combo.Button.prototype.SetHTMLTagObject = function (HTMLTagObject)
{
	this.m_HTMLTagObject = HTMLTagObject;
}

/**
 * Returns the combo object that owns this button.
 * This is equivalent to the statement: document.getElementById("ComboID").jsObject.
 * @type nitobi.combo.Combo
 */
nitobi.combo.Button.prototype.GetCombo = function ()
{
	return this.m_Combo;
}

/**
 * Sets the combo object that owns this one.
 * @param {nitobi.combo.Combo} Combo The combo object that is to be the new owner of this button
 * @private
 */
nitobi.combo.Button.prototype.SetCombo = function(Combo)
{
	this.m_Combo = Combo;
}

/**
 * Returns the class currently being used draw the button.
 * This property has been deprecated.  It is equivalent to GetDefaultCSSClassName.
 * @type String
 * @see #GetDefaultCSSClassName
 * @deprecated
 */
nitobi.combo.Button.prototype.GetCSSClassName = function ()
{
	return (null == this.m_HTMLTagObject ? this.m_CSSClassName : this.m_HTMLTagObject.className);
}

/**
 * Sets the class currently being used draw the button.
 * This property has been deprecated.  It is equivalent to SetDefaultCSSClassName.
 * @param {String} CSSClassName The CSS class to apply to the button
 * @see #SetDefaultCSSClassName
 * @deprecated
 */
nitobi.combo.Button.prototype.SetCSSClassName = function (CSSClassName)
{
	if(null==this.m_HTMLTagObject)
		this.m_CSSClassName = CSSClassName;
	else
		this.m_HTMLTagObject.className = CSSClassName;
}

/**
 * Handles the mouse over event for the button
 * @param {Object} TheImg The button's IMG element being moused over.
 * @param {Boolean} firstTime Whether or not to subsequently call the textbox's OnMouseOver.
 * @private
 */
nitobi.combo.Button.prototype.OnMouseOver = function (TheImg, firstTime)
{
	if (this.GetCombo().GetEnabled())
	{
		if(null==TheImg)
			TheImg=this.m_Img;
		this.m_prevImgClass = "ntb-combobox-button-img-over";
		TheImg.className = this.m_prevImgClass;
		if(firstTime)
			this.GetCombo().GetTextBox().OnMouseOver(false);
	}
}

/**
 * Handles the mouse out event for the button
 * @param {Object} TheImg The button's IMG element being moused over.
 * @param {Boolean} firstTime Whether or not to subsequently call the textbox's OnMouseOver.
 * @private
 */
nitobi.combo.Button.prototype.OnMouseOut = function (TheImg, firstTime)
{
	if(null==TheImg)
		TheImg=this.m_Img;
	this.m_prevImgClass = "ntb-combobox-button-img";
	TheImg.className=this.m_prevImgClass;
	if(firstTime)
		this.GetCombo().GetTextBox().OnMouseOut(false);
}

/**
 * Handles the mouse down event for the button
 * @param {Object} TheImg The button's IMG element being moused over.
 * @private
 */
nitobi.combo.Button.prototype.OnMouseDown = function (TheImg)
{
	if (this.GetCombo().GetEnabled())
	{
		if(null != TheImg)
			TheImg.className="ntb-combobox-button-img-pressed";
		this.OnClick();
	}
}

/**
 * Handles the mouse up event for the button
 * @param {Object} TheImg The button's IMG element being moused over.
 * @private
 */
nitobi.combo.Button.prototype.OnMouseUp = function (TheImg)
{
	if (this.GetCombo().GetEnabled())
	{
		if(null != TheImg)
			TheImg.className=this.m_prevImgClass;
	}
}

/**
 * Handles the mouse click event for the button
 * @private
 */
nitobi.combo.Button.prototype.OnClick = function ()
{
	var combo = this.GetCombo();
	// hide dropdowns for all other lists
	var allcombos = document.getElementsByTagName((!nitobi.browser.IE)?"ntb:Combo":"combo");
	for (var i=0; i<allcombos.length; i++){
		var other = allcombos[i].object;
		try
		{
			if (combo.GetId() != other.GetId())
				other.GetList().Hide();
		}
		catch(err)
		{
			// Do nothing. The list may not have been rendered yet.
		}
	}
	var l = combo.GetList();
	l.Toggle();
	var t = combo.GetTextBox();
	var tb = t.GetHTMLTagObject();
	if(t.focused)
		t.m_skipFocusOnce=true;
	tb.focus();
}

/**
 * Returns the HTML that is used to render the object.
 * @private
 */
nitobi.combo.Button.prototype.GetHTMLRenderString = function ()
{
	var comboId = this.GetCombo().GetId();
	var uid = this.GetCombo().GetUniqueId();
	// three notes:
	// - align=nitobi.browser.MOZ?"absbottom":"absmiddle" is very important to lining up the IMG w/ the textbox
	// - keeping <input type="text"></input><img></img> on the same line w/o any spaces, breaks, etc.
	// is important to ensuring that no gap appears between the two elements so do NOT put an
	// "\n" before/after this html bit
	// - of course, the <nobr></nobr> is necessary to keep the two together also (nobr is not
	// written in this context... see parent context)
	var w = this.GetWidth();
	var h = this.GetHeight();

	// In IE, if the ComboBox is on a page using SSL, it will prompt the user with a "This page is using
	// both secure and unsecure items" alert.  The cause is the src attribute of the image tag.
	if( (!nitobi.browser.IE) ) {
		var html =	"<span id='EBAComboBoxButton" + uid + "' " +
				"class='" + this.GetDefaultCSSClassName() + "' " +
				"style='" + (null!=w && ""!=w ? "width:"+w+";" : "") + (null!=h && ""!=h ? "height:"+h+";" : "") + "'>" +
				// Note: the img tag has a default src that may not exist; we replace it in initialize.
				"<img src='javascript:void(0);' class='ntb-combobox-button-img' id='EBAComboBoxButtonImg" + uid + "' " +
				"onmouseover='$ntb(\"" + comboId + "\").object.GetButton().OnMouseOver(this, true)' "+
				"onmouseout='$ntb(\"" + comboId + "\").object.GetButton().OnMouseOut(this, true)' "+
				// use onmousedown now: solves button image dragging bug (i.e. list stays open on blur)
				"onmousedown='$ntb(\"" + comboId + "\").object.GetButton().OnMouseDown(this);return false;' "+
				"onmouseup='$ntb(\"" + comboId + "\").object.GetButton().OnMouseUp(this)' "+
				"onmousemove='return false;' "+
				"></img></span>";
	} else {
		var html =	"<span id='EBAComboBoxButton" + uid + "' " +
					"class='" + this.GetDefaultCSSClassName() + "' " +
					"style='" + (null!=w && ""!=w ? "width:"+w+";" : "") + (null!=h && ""!=h ? "height:"+h+";" : "") + "'>" +
					// Note: the img tag has a default src that may not exist; we replace it in initialize.
					"<img class='ntb-combobox-button-img' id='EBAComboBoxButtonImg" + uid + "' " +
					"onmouseover='$ntb(\"" + comboId + "\").object.GetButton().OnMouseOver(this, true)' "+
					"onmouseout='$ntb(\"" + comboId + "\").object.GetButton().OnMouseOut(this, true)' "+
					// use onmousedown now: solves button image dragging bug (i.e. list stays open on blur)
					"onmousedown='$ntb(\"" + comboId + "\").object.GetButton().OnMouseDown(this);return false;' "+
					"onmouseup='$ntb(\"" + comboId + "\").object.GetButton().OnMouseUp(this)' "+
					"onmousemove='return false;' "+
					"></img></span>";
	}
	return html;
}

/**
 * Initializes the object after creation.
 * @private
 */
nitobi.combo.Button.prototype.Initialize = function ()
{
	var combo = this.GetCombo();
	var uid = combo.GetUniqueId();
	this.SetHTMLTagObject($ntb("EBAComboBoxButton" + uid));
	var img = $ntb("EBAComboBoxButtonImg" + uid);

	// The browser requires that every img tag has a src.  We use the backgound-image
	// in the CSS to display the button.gif. However, this causes an image not found
	// icon in the browser because img.src is null. Here we replace img.src with
	// blank.gif, found in the same directory as button.gif
	// Start by getting the button.gif url.
	var blankImgPath = nitobi.html.Css.getStyle(img,"background-image");
	// Replace button.gif with blank.gif, and remove url,(", and ") chars.
	blankImgPath = blankImgPath.replace(/button\.gif/g,"blank.gif");
	if (nitobi.browser.IE || nitobi.browser.MOZ)
	{
		blankImgPath = blankImgPath.substr(5,blankImgPath.length-7);
	}
	else
	{
		blankImgPath = blankImgPath.substr(4,blankImgPath.length-5);
		// Replace \( with (. Moz adds the \ for some reason.
		blankImgPath = blankImgPath.replace(/\\\(/g,"(");
		// Replace \) with )
		blankImgPath = blankImgPath.replace(/\\\)/g,")");
	}
	img.src=blankImgPath;

	this.m_Img = img;
	this._onmouseover=img.onmouseover;
	this._onmouseout=img.onmouseout;
	this._onclick=img.onclick;
	this._onmousedown=img.onmousedown;
	this._onmouseup=img.onmouseup;
	if(!this.GetCombo().GetEnabled())
		this.Disable();
	// Don't user this after init. Use the proper accessors.
	this.m_userTag = null;
}

/**
 * Disables the button from user interaction.
 * @private
 */
nitobi.combo.Button.prototype.Disable = function ()
{
	var img = this.m_Img;
	img.onmouseover=null;
	img.onmouseout=null;
	img.onclick=null;
	img.onmousedown=null;
	img.onmouseup=null;
	img.className = "ntb-combobox-button-img-disabled";
}

/** 
 * Enables the button for user interaction.
 * @private
 */
nitobi.combo.Button.prototype.Enable = function ()
{
	var img = this.m_Img;
	img.onmouseover=this._onmouseover;
	img.onmouseout=this._onmouseout;
	img.onclick=this._onclick;
	img.onmousedown=this._onmousedown;
	img.onmouseup=this._onmouseup;
	img.className = "ntb-combobox-button-img";
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");

if (nitobi.combo == null) {
	/**
	 * @namespace The namespace for classes that make up 
	 * the Nitobi ComboBox component.
	 * @constructor
	 */
	nitobi.combo = function(){};
}

// Constants

// Number of combos left to load in loading sequence.
/**
 * @private
 */
nitobi.combo.numCombosToLoad = 0;
// Number of combos to load before the rest of the page loads.
/**
 * @private
 */
nitobi.combo.numCombosToLoadInitially=4;
// A multiplier that delays the combo loading, allowing others to load before it.
// Used to load top combos before bottom. In milliseconds.
/**
 * @private
 */
nitobi.combo.loadDelayMultiplier=10;

/**
 * Returns the element corresponding to the combobox with the supplied id.
 * To get the combobox javascript object, you can do the following:
 * @deprecated Use {@link nitobi#getComponent}
 * @param {String} id The id of the combobox.
 * @type HTMLElement
 */
nitobi.getCombo = function(id)
{
	return $ntb(id).jsObject;
}

/**
 * @private
 */
nitobi.combo.initBase = function()
{
	if (nitobi.combo.initBase.done == false)
	{
		// Before we do anything, hide all the panels.
		var panels = [];
		var ebaPanels = document.getElementsByTagName((!nitobi.browser.IE)?"eba:ComboPanel":"combopanel");
		var ntbPanels = ((!nitobi.browser.IE)?document.getElementsByTagName("ntb:ComboPanel"):[]);
		for (var i=0;i<ntbPanels.length;i++)
		{
			panels.push(ntbPanels[i]);
		}
		for (var i=0;i<ebaPanels.length;i++)
		{
			panels.push(ebaPanels[i]);
		}
		for(var i=0; i<panels.length; i++)
		{
			panels[i].style.display = "none";
		}
			
		nitobi.combo.createLanguagePack();
			
		// Create an iframe that we'll use to show the list over
		// option boxes.  This is a fix for an ie bug whereby
		// the option control has a greater z-index than any 
		// other control. A note: it is not that much more expensive
		// to just create one iframe than check to see if
		// there are option boxes on the page.
		if (nitobi.browser.IE)
		{
			nitobi.combo.iframeBacker = document.createElement("IFRAME");
			nitobi.combo.iframeBacker.style.position="absolute";
			nitobi.combo.iframeBacker.style.zindex="1000";
			nitobi.combo.iframeBacker.style.visibility="hidden";
			nitobi.combo.iframeBacker.name="nitobi.combo.iframeBacker_Id";
			nitobi.combo.iframeBacker.id="nitobi.combo.iframeBacker_Id";
			nitobi.combo.iframeBacker.frameBorder=0;
			nitobi.combo.iframeBacker.src="javascript:true";
			// Insert the iframe after the body tag to avoid creating space at the bottom of the page.
			nitobi.html.insertAdjacentElement(document.body,"afterBegin",nitobi.combo.iframeBacker);
		}
		nitobi.combo.initBase.done = true;
	}
}

nitobi.combo.initBase.done = false;

/**
 * Initializies a combobox
 * @param {String/HTMLElement} el Either the id of the combobox or its declaration
 * @deprecated You should use {@link nitobi#loadComponent}
 */
nitobi.initCombo = function(el)
{
	nitobi.combo.initBase();
	var tag;
	if (typeof(el) == "string")
	{
		tag = $ntb(el);
	}
	else
	{
		tag = el;
	}
	tag.object = new nitobi.combo.Combo(tag);
	tag.object.Initialize();
	tag.object.GetList().Render();
	return tag.object;
}

/**
 * Initializes all comboboxes on the page
 * @deprecated You should use {@link nitobi#loadComponent}
 */
nitobi.initCombos = function()
{
	nitobi.combo.initBase();
	var combos = [];
	var ebaCombos = document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
	var ntbCombos = ((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
	for (var i=0;i<ntbCombos.length;i++)
	{
		combos.push(ntbCombos[i]);
	}
	for (var i=0;i<ebaCombos.length;i++)
	{
		combos.push(ebaCombos[i]);
	}
	if(0==document.styleSheets.length)
		alert("You are missing a link to the Web ComboBoxes' style sheet.");
	else
	{
		nitobi.combo.numCombosToLoad=combos.length;
		for(var i=0; i<combos.length; i++)
		{
		try
		{
			if (i>=nitobi.combo.numCombosToLoadInitially)
			{
				var delay=i*nitobi.combo.loadDelayMultiplier;
				window.setTimeout("try{$ntb('"+combos[i].id+"').object = new nitobi.combo.Combo($ntb('"+combos[i].id+"'));$ntb('"+combos[i].id+"').object.Initialize();}catch(err){alert(err.message);}",delay);
				
			}
			else
			{
				nitobi.initCombo(combos[i]);				
			}
			}catch(err)
			{alert(err.message)};
		}
		
	}	
}

function InitializeEbaCombos()
{
	nitobi.initCombos();
}

/**
 * @private
 */
nitobi.combo.finishInit = function()
{
	nitobi.combo.resize();
	nitobi.html.attachEvent(window, "resize", nitobi.combo.resize);
	
	// Hook the unload event so that we have an opportunity to unload all
	// of our stuff.
	if( window.addEventListener )
	{
    	window.addEventListener( 'unload', nitobi.combo.unloadAll, false );
	} else if( document.addEventListener )
	{
		document.addEventListener( 'unload', nitobi.combo.unloadAll, false );
	} else if( window.attachEvent )
	{
		window.attachEvent( 'onunload', nitobi.combo.unloadAll );
	} else
	{
		if( window.onunload )
		{
			window.XTRonunload = window.onunload;
		}
		window.onunload = nitobi.combo.unloadAll;
	}
	try
	{
		eval("try{OnAfterIntializeEbaCombos()} catch(err){}");
	}catch(err){}




}

// Actively unload the combos. This is an effort to prevent mem leaks.
/**
 * @private
 */
nitobi.combo.unloadAll = function()
{
	var combos = [];
	var ebaCombos = document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
	var ntbCombos = ((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
	for (var i=0;i<ntbCombos.length;i++)
	{
		combos.push(ntbCombos[i]);
	}
	for (var i=0;i<ebaCombos.length;i++)
	{
		combos.push(ebaCombos[i]);
	}

	if (combos)
	{
		for(var i=0; i<combos.length; i++)
		{


			if ((combos[i]) && (combos[i].object))
			{
				combos[i].object.Unload();
				combos[i].object = null;
			}
		}
		combos = null;
	}
	
	if (nitobi.browser.IE)
	{
		if (nitobi.combo.iframeBacker)
		{
			delete nitobi.combo.iframeBacker;
			nitobi.combo.iframeBacker=null;
		}
	}
}

// *****************************************************************************
// * nitobi.combo.resize
// *****************************************************************************
/**
 * @private
 */
nitobi.combo.resize = function()
{
	var combos = [];
	var ebaCombos = document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
	var ntbCombos = ((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
	for (var i=0;i<ntbCombos.length;i++)
	{
		combos.push(ntbCombos[i]);
	}
	for (var i=0;i<ebaCombos.length;i++)
	{
		combos.push(ebaCombos[i]);
	}
	for(var i=0; i<combos.length; i++)
	{
		var combo = combos[i].object;
		if ("smartlist" != combo.mode)
		{
			// This is only used when the combo container has dimensions. If the combo doesn't
			// the user is using the textbox dimensions.
			if (combo.GetWidth() != null)
			{
				var uniqueId = combo.GetUniqueId();

				// Resize the combo to be 100% of the containing span.
				var textbox = combo.GetTextBox();
				var list = combo.GetList();
				
				var container = $ntb(combo.GetId());
				var containerWidth = parseInt(combo.GetWidth());
				if ((!nitobi.browser.IE) && nitobi.Browser.GetMeasurementUnitType(combo.GetWidth()) == "px")
				{
					// Moz doesn't respect the container being set to a px. Therefore, 
					// in this case, we need to get the desired combo width.
					containerWidth = parseInt(combo.GetWidth());
				}
				
				var buttonTag = $ntb("EBAComboBoxButtonImg" + uniqueId);

				var buttonWidth;
				if (null != buttonTag)
				{
					buttonWidth = nitobi.html.getWidth(buttonTag);
				}
				else
				{
					buttonWidth=0;
				}

				textbox.SetWidth((containerWidth-buttonWidth)+"px");
				list.OnWindowResized();
			}
		}
	}
}

/**
 * Creates a nitobi combobox.
 * @class This is the base class for the Nitobi ComboBox component.  Normally, you will instantiate the component
 * using the custom tags.  Here is a sample ComboBox declaration:
 * <pre class="code">
 * &lt;ntb:Combo id="myCombo" Mode="unbound" &gt;
 * 	&lt;ntb:ComboTextBox  DataFieldIndex=0 &gt;&lt;/ntb:ComboTextBox&gt;
 * 	&lt;ntb:ComboList Width="200px" AllowPaging="false" Height="180px" &gt;
 * 		&lt;ntb:ComboColumnDefinition Width="100px" DataFieldIndex=0&gt;&lt;/ntb:ComboColumnDefinition&gt;
 * 		&lt;ntb:ComboColumnDefinition Width="70px" DataFieldIndex=1&gt;&lt;/ntb:ComboColumnDefinition&gt;
 * 	&lt;/ntb:ComboList&gt;
 * 	&lt;ntb:ComboValues fields="City|Population"&gt;
 * 		&lt;ntb:ComboValue a="Vancouver" b="3,000,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Toronto" b="4,500,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Ottawa" b="1,000,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Halifax" b="900,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Calgary" b="1,500,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Red Deer" b="100,000" &gt;&lt;/ntb:ComboValue&gt;
 * 		&lt;ntb:ComboValue a="Prince George" b="200,000" &gt;&lt;/ntb:ComboValue&gt;
 * 	&lt;/ntb:ComboValues&gt;
 * &lt;/ntb:Combo&gt;
 * </pre>
 * Calling <code>nitobi.loadComponent('combo1');</code> will render a ComboBox at the location of that XML 
 * declaration in your web page. To access this API you get the combo object from its node in the HTML 
 * document. We can, for example, get the nitobi.combo.List object of the combobox:
 * <pre class="code">
 * var combo = nitobi.getComponent('combo1');
 * var list = combo.GetList();
 * </pre>
 * @constructor
 * @param {HTMLNode} userTag The HTML object that represents Combo
 */
nitobi.combo.Combo = function(userTag)
{
	var DEFAULTINITIALSEARCH=""; 
	var DEFAULTREQUESTMETHOD="GET";
	
	var ERROR_NOID="You must specify an Id for the combo box";
	var ERROR_NOXML="ntb:Combo could not correctly transform XML data. Do you have the MS XML libraries installed? These are typically installed with your browser and are freely available from Microsoft.";

	/**
	 * @private
	 */
	this.Version = "3.5";
	((null==userTag.id) || (""==userTag.id))
		? alert(ERROR_NOID)
		: this.SetId(userTag.id);
	
	var xmlDataSourceTag=null;
	var listTag=null;
	var buttonTag=null;
	var textboxTag=null;
	userTag.object=this;
	userTag.jsObject = this;
	/**
	 * @private
	 */
	this.m_userTag=userTag;
	var unboundComboValues=null;

	// TODO: Finish this implemenatino. Out of time.
	//this.m_StateMgr = new EbaStateManager;
	//this.m_StateMgr.SetOnChangeState(nitobi.components.combo.stateFocus,nitobi.components.combo.stateFocus_FOCUS,nitobi.components.combo.stateFocus_NOFOCUS,this.OnBlurEvent);
	
	// Enable warnings in the combo. This should be moved to debug, see the note below.
	this.BuildWarningList();
	var disabledWarnings = this.m_userTag.getAttribute("DisabledWarningMessages");
	if (!((null == disabledWarnings) || ("" == disabledWarnings)))
	{
		this.SetDisabledWarningMessages(disabledWarnings);
	}
	// See if the user wants debug messages turned on.
	var errorLevel=this.m_userTag.getAttribute("ErrorLevel");
	((null == errorLevel) || ("" == errorLevel))
		? this.SetErrorLevel("")
		: this.SetErrorLevel(errorLevel);

	// need to strip out whitespaces or else a space can appear before and/or after the combobox
	userTag.innerHTML=userTag.innerHTML.replace(/>\s+</g,"><").replace(/^\s+</,"<").replace(/>\s+$/,">");

	// Check to see if the user is building a quick combobox with one column
	// and key/value pairs.  Use one or the other.
	var dtf=userTag.getAttribute("DataTextField");
	var dvf=userTag.getAttribute("DataValueField");
	if((null==dtf) || (""==dtf))
	{
		dtf=dvf;
		userTag.setAttribute("DataTextField",dtf);
	}
	this.SetDataTextField(dtf);
	this.SetDataValueField(dvf);
	if((null != dtf) && ("" != dtf))
	{
		// See if there is a value field and if not, use the text field as value.
		if((null==dvf) || (""==dvf))
			dvf=dtf;
		this.SetDataValueField(dvf);
	}
	// Iterate through all the child tags and create the appropriate objects.
	for(var i=0; i < userTag.childNodes.length; i++)
	{
		var childTag = userTag.childNodes[i];
		var n = childTag.tagName;
		if(n)
		{
			// toLowerCase comparsion to eliminate IE/Moz case differences
			// remove ntb: namespace for Moz
			n = n.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"");
			switch(n)
			{
				case "combobutton":
				{
					buttonTag=childTag;
					break;
				}
				case "combotextbox":
				{
					textboxTag=childTag;
					break;
				}
				case "combolist":
				{
					listTag=childTag;
					break;
				}
				case "xmldatasource":
				{
					// We want to try and minimize user confusion. Therefore, the XmlDatasource tag
					// is a child of the combo tag even though in our internal architecture it makes
					// more sense to have it as owned by the list. Additionally, we should wait until
					// all the list object is created.
					xmlDataSourceTag=childTag;
					break;
				}
				case "combovalues":
				{
					unboundComboValues=childTag;
				}
			}
		}
	}

	var DEFAULTMODE="default";


	var mode=this.m_userTag.getAttribute("Mode");
	if(null!=mode)
		mode=mode.toLowerCase();
	// note, we've changed "DEFAULT" to "CLASSIC" but code below still works
	// so internally, it's still referred to as "default" mode
	switch(mode)
	{
		case "smartsearch":
		case "smartlist":
		case "compact":
		case "filter":
		case "unbound":
			this.mode = mode;
			break;
		default:
			this.mode = DEFAULTMODE;
	}

	var durl = (listTag==null ? null : listTag.getAttribute("DatasourceUrl"));
	// if SMARTSEARCH, SMARTLIST, FILTER, it is absolutely necessary for the user
	// to specify a DatasourceURL or else, we'll default back to CLASSIC mode;
	// also, can't work w/ local dataset only (i.e. ComboValues) so default back
	// to CLASSIC mode
	if((unboundComboValues==null && durl==null) && this.mode!="compact")
	{
		this.mode=DEFAULTMODE;
	}
	// defaults to 25 if none specified
	var pagesize = 25;
	if(null!=listTag)
	{
		var ps = listTag.getAttribute("PageSize");
		if(ps!=null && ps!="")
			pagesize=ps;
	}

	var initsearch = userTag.getAttribute("InitialSearch");
	/**
	 * @private
	 */
	this.m_InitialSearch = "";
	if ((null == initsearch) || ("" == initsearch))
	{
		this.m_InitialSearch = DEFAULTINITIALSEARCH;
	}
	else
	{
		this.m_InitialSearch = initsearch;
	}
	 
	var rt=userTag.getAttribute("HttpRequestMethod");
	((null == rt) || ("" == rt))
		? this.SetHttpRequestMethod(DEFAULTREQUESTMETHOD)
		: this.SetHttpRequestMethod(rt);

	// this automatically takes care of the XmlDataSource tag for the user if
	// they've specified a DatasourceURL but neglected to specify an XmlDatasource
	// tag; previously, would crash
	/**
	 * @private
	 */
	this.m_NoDataIsland = unboundComboValues==null && durl!=null && xmlDataSourceTag==null;
	if(this.m_NoDataIsland)
	{
		// TODO: refactor this... xbrowser.js/XmlDataIslands() uses similar code
		var id = userTag.id + "XmlDataSource";
		// reuse listTag since we ONLY need to access the XmlId attribute
		listTag.setAttribute("XmlId", id);
		xmlDataSourceTag = listTag;
		durl += (durl.indexOf("?") == -1 ? "?" : "&");
		durl += "PageSize=" + pagesize;
		durl += "&StartingRecordIndex=0"  +  "&ComboId="+encodeURI(this.GetId())+"&LastString=";
	
		if (this.m_InitialSearch != null && this.m_InitialSearch!="")
		{
			durl += "&SearchSubstring=" + encodeURI(this.m_InitialSearch);
		}
		// Careful here. If there is anything before the XML declaration in an xml document, such as the 
		// junk that MS adds for their ASP debugging, then xml.load will fail. Instead, we have to 
		// manually load the data from the url, strip out anything that comes before <?xml.
		var loadedXml = nitobi.Browser.LoadPageFromUrl(durl, this.GetHttpRequestMethod());
		var declaredXmlIndex = loadedXml.indexOf("<?xml");
		if (declaredXmlIndex != -1)
			loadedXml =(loadedXml.substr(declaredXmlIndex));
		var d = nitobi.xml.createXmlDoc(loadedXml);
		d.async=false;

		var d2 = nitobi.xml.createXmlDoc(d.xml.replace(/>\s+</g,"><"));
		d2 = xbClipXml(d2, "root", "e", pagesize);
		document[id]=d2;
	}
	var modeIsDef = (this.mode==DEFAULTMODE || this.mode=="unbound");
	// only create button in CLASSIC (default) mode
	if(modeIsDef)
	{
		this.SetButton(new nitobi.combo.Button(buttonTag, this));
	}
	
	this.SetList(new nitobi.combo.List(listTag, xmlDataSourceTag, unboundComboValues, this));
	// in CLASSIC (default) mode, we don't need to have the right border (taken
	// care of by the button); whereas in the other modes, leave the right border
	// because there's no button
	this.SetTextBox(new nitobi.combo.TextBox(textboxTag, this, modeIsDef));
	// The mouse is not over the list.
	/**
	 * @private
	 */
	this.m_Over=false;
}

/**
 * Builds a list of all combo warning messages.
 * This should be moved to the debug class. However, since this is not shipped, this requires more work than time permits.
 * @private
 */
nitobi.combo.Combo.prototype.BuildWarningList = function ()
{
	this.m_WarningMessagesEnabled = new Array();
	this.m_DisableAllWarnings=false;
	this.m_WarningMessages = new Array();
	this.m_WarningMessages["cw001"]="The combo tried to search the server datasource for data.  " +
									"The server returned data, but no match was found within this data by the combo. The most "+
									"likely cause for this warning is that the combo mode does not match the gethandler SQL query type: "+
									"the sql query is not matching in the same way the combo is. Consult the documentation to see what " +
									"matches to use given the combo's mode.";
	this.m_WarningMessages["cw002"]="The combo tried to load XML data from the page. However, it encountered a tag attribute of the form <tag att='___'/> instead" +
									" of the form <tag att=\"___\"/>. A possible reason for this is encoding ' as &apos;. To fix this error correct the tag to use " +
									"<tag att=\"__'___\"/>. If you are manually encoding data, eg. for an unbound combo, do not encode ' as &apos; and do not use ' as your string literal. If you believe, "+
									"this warning was generated in error, you can disable it.";
	this.m_WarningMessages["cw003"]="The combo failed to load and parse the XML sent by the gethandler. Check your gethandler to ensure that it is delivering valid XML.";
}

/**
 * Disables warning messages issued by the combo. This is a comma separates list of ids or, to disable all warnings, set this to *.
 * @param {String} WraningIds A list of warning ids separated by commas. To prevent all warnings use only *
 * @example
 * HTML: &lt;... DisabledWarningMessages='cw001,cw002' ...&gt;
 * JAVASCRIPT: Combo.SetDisabledWarningMessages('cw001,cw002');
 * @see #SetErrorLevel
 * @private
 */
nitobi.combo.Combo.prototype.SetDisabledWarningMessages = function (WarningIds)
{
	if (WarningIds=="*")
	{
		this.m_DisableAllWarnings=true;
	}
	else
	{
		this.m_DisableAllWarnings=false;
		WarningIds = WarningIds.toLowerCase();
		WarningIds = WarningIds.split(",");
		for (var i=0;i<WarningIds.length;i++)
		{
			this.m_WarningMessagesEnabled[WarningIds[i]] = false;
		}
	}
}

/**
 * Returns true if a particular warning is enabled.
 * @param {String} WarningId The id of the warning.
 * @return True if the warning is enabled.
 * @type Boolean
 * @private
 */
nitobi.combo.Combo.prototype.IsWarningEnabled = function (WarningId)
{
	if (this.m_ErrorLevel=="")
	{
		return;
	}
	else
	{
		if (this.m_WarningMessagesEnabled[WarningId] == null)
		{
			this.m_WarningMessagesEnabled[WarningId] = true;
		}
		return this.m_WarningMessagesEnabled[WarningId] && this.m_DisableAllWarnings==false;
	}
}

/**
 * Set this to EBAERROR_LEVEL_DEBUG if you want to see debug messages.
 * If no value is supplied, no debug messages are shown.  To disable certain warning messages see DisabledWarningMessages.
 * @param {String} Value The error level.
 * @private
 */ 
nitobi.combo.Combo.prototype.SetErrorLevel = function (Value)
{
	this.m_ErrorLevel = Value.toLowerCase();
}

/**
 * Returns the width of the combo in html units, eg 100px or 100%.
 * If you use this property, TextBox.Width is ignored.  This does not set the width of 
 * the list: use {@link nitobi.combo.List#SetWidth} 
 * @type String
 * @see #GetHeight
 */
nitobi.combo.Combo.prototype.GetWidth = function ()
{
	return this.m_Width;
}

/**
 * Sets the width of the combo in html units, e.g. 100px or 100%.
 * If you use this property, TextBox.Width is ignored.  This does not set the width of 
 * the list: use {@link nitobi.combo.List#SetWidth} 
 * @param {String} Value The width in px or other HTML measurement type.
 * @see #GetWidth
 * @see #SetHeight
 */
nitobi.combo.Combo.prototype.SetWidth = function (Value)
{
	this.m_Width = Value;
}

/**
 * Returns the height of the combo in html units, e.g. 100px or 100%.
 * If you use this property, {@link nitobi.combo.TextBox#Height} is ignored. This property is only used when the 
 * mode is set to SmartList.  In all other modes, the height of the component
 * is defined in css.
 * @type String
 * @see #GetWidth
 * @see nitobi.combo.TextBox#SetHeight
 */
nitobi.combo.Combo.prototype.GetHeight = function ()
{
	return this.m_Height;
}

/**
 * Sets the height of the combo in html units, e.g. 100px or 100%.
 * If you use this property, {@link nitobi.combo.TextBox#Height} is ignored. This property is only used when the 
 * mode is set to SmartList.
 * @param {String} Value The Height in px or other measurement type.
 * @see #GetHeight
 * @see #SetWidth
 */
nitobi.combo.Combo.prototype.SetHeight = function (Value)
{
	this.m_Height = Value;
}

/**
 * @private
 */
function _EBAMemScrub(p_element)
{
    for(var l_member in p_element)    
    {        
        if ((l_member.indexOf("m_") == 0) || 
            (l_member.indexOf("$") == 0))
        {
            // Break the potential circular reference
            p_element[l_member] = null;
        }        
    }
}

/**
 * Actively unloads the object, and destroys owned objects.
 * @private
 */
nitobi.combo.Combo.prototype.Unload = function ()
{
	if (this.m_Callback)
	{
		delete this.m_Callback;
		this.m_Callback = null;
	}
	if (this.m_TextBox)
	{
		this.m_TextBox.Unload();
		delete this.m_TextBox;
		this.m_TextBox = null;
	}
	if (this.m_List)
	{
		this.m_List.Unload();
		delete this.m_List;
		this.m_List = null;
	}
	if (this.m_Button)
	{
		this.m_Button.Unload();
		delete m_Button;
	}
	var htmlTag = this.GetHTMLTagObject();
	_EBAMemScrub(this);
	_EBAMemScrub(htmlTag);

}

/**
 * Returns the kind of server request is used when requesting data, GET or POST. The default is GET.
 * In some cases a POST is useful because certain form fields are posted with the request.
 * @type String
 */
nitobi.combo.Combo.prototype.GetHttpRequestMethod = function ()
{
	return this.m_HttpRequestMethod;
}

/**
 * Sets the kind of server request is used when requesting data, GET or POST. The default is GET.
 * In some cases a POST is useful because certain form fields are posted with the request.
 * @param {String} HttpRequestMethod The request method.  Valid values are "GET" and "POST"
 * @see #GetHttpRequestMethod
 */
nitobi.combo.Combo.prototype.SetHttpRequestMethod = function (HttpRequestMethod)
{
	if(null == this.m_HTMLTagObject)
		this.m_HttpRequestMethod = HttpRequestMethod;
	else
		this.m_HTMLTagObject.className = HttpRequestMethod;
}

/**
 * Returns the name of a custom CSS class to associate with the entire combo box. 
 * If this is left as an empty string, then the 'ComboBox' class is used.  Refer to the CSS file 
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can 
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @example
 * &lt;ntb:Combo id="combo1" CSSClassName="customClass"&gt;&lt;/ntb:Combo&gt;
 * &lt;ntb:Combo id="combo2"&gt;&lt;/ntb:Combo&gt;
 * 
 * nitobi.getComponent("combo1").GetCSSClassName();  // Will return "customClass"
 * nitobi.getComponent("combo2").GetCSSClassName();  // Will return "ComboBox"
 * @type String
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 */
nitobi.combo.Combo.prototype.GetCSSClassName = function ()
{
	return (null == this.m_HTMLTagObject ? this.m_CSSClassName : this.m_HTMLTagObject.className);
}

/**
 * Sets the name of a custom CSS class to associate with the entire combo box. 
 * If this is left as an empty string, then the 'ComboBox' class is used.  You can 
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @param {String} CSSClassName The combo's CSS class name.  Do not include the dot in the class name.
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 */
nitobi.combo.Combo.prototype.SetCSSClassName = function (CSSClassName)
{
	if(null == this.m_HTMLTagObject)
		this.m_CSSClassName = CSSClassName;
	else
		this.m_HTMLTagObject.className = CSSClassName;
}

/**
 * Returns the initial value to search for and select in the dataset. Only in bound search modes.
 * When the combo is bound to a datasource, you can use this property to make the combo search the datasource 
 * at load time.
 * @type String
 * @see #SetInitialSearch
 */
nitobi.combo.Combo.prototype.GetInitialSearch = function ()
{
	return this.m_InitialSearch;
}

/**
 * Sets the initial value to search for and select in the dataset. Only in bound search modes.
 * When the combo is bound to a datasource, you can use this property make the combo search the datasource 
 * at load time.
 * @param {String} insch The initial search string
 * @see #GetInitialSearch
 */
nitobi.combo.Combo.prototype.SetInitialSearch = function (insch)
{
	this.m_InitialSearch = insch;
}

/**
 * Returns an integer specifying the order of combo lists on the page along the Z axis.
 * @type Number
 * @see #SetListZIndex
 */
nitobi.combo.Combo.prototype.GetListZIndex = function ()
{
	return this.m_ListZIndex;
}

/**
 * Sets the order of combo lists on the page along the Z axis.
 * @param {Number} zindex The zindex of the ComboBox
 * @see #GetListZIndex
 */
nitobi.combo.Combo.prototype.SetListZIndex = function (zindex)
{
	this.m_ListZIndex = zindex;
}

/**
 * Returns the search and render mode of this combo.
 * It can be one of 
 * <ul>
 * 	<li>classic</li>
 * 	<li>compact</li>
 * 	<li>filter</li>
 * 	<li>smartlist</li>
 * 	<li>smartsearch</li>
 * 	<li>unbound</li>
 * </ul>
 * @type String
 */
nitobi.combo.Combo.prototype.GetMode = function ()
{
	return this.mode;
}

/**
 * Gets the javascript that is run when the textbox of the combo loses focus.
 * This event fires when the combo loses focus. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnBlurEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * combo object.
 * @type String
 * @see #SetOnBlurEvent
 */
nitobi.combo.Combo.prototype.GetOnBlurEvent = function ()
{
	return this.m_OnBlurEvent;
}

/**
 * Sets the javascript that is run when the textbox of the combo loses focus.
 * This event fires when the combo loses focus. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnBlurEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * combo object.
 * @param {String} OnBlurEvent Valid javascript to run when OnBlur fires.
 * @see #GetOnBlurEvent
 */
nitobi.combo.Combo.prototype.SetOnBlurEvent = function(OnBlurEvent)
{
	this.m_OnBlurEvent = OnBlurEvent;
}

/**
 * @private
 */
nitobi.combo.Combo.prototype.OnBlurEvent = function()
{
}

/**
 * Sets the focus in the combo.
 * Once the combo has focus, the user has full control of it via 
 * the keyboard.  When the combo gains focus the OnFocusEvent is called.
 * @see #SetOnFocusEvent
 */
nitobi.combo.Combo.prototype.SetFocus = function()
{
	this.GetTextBox().m_HTMLTagObject.focus();
}

/**
 * Returns the valid javascript that is run when the textbox of the combo gains focus.
 * If the combo does not have focus, you can force focus and fire this event using Combo.SetFocus. 
 * You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnFocusEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * combo object. You can then use this.GetCombo() to get the Combo object.
 * @type String
 * @see #SetOnFocusEvent
 * @see #SetFocus
 */
nitobi.combo.Combo.prototype.GetOnFocusEvent = function()
{
	return this.m_OnFocusEvent;
}

/**
 * Sets the valid javascript that is run when the textbox of the combo gains focus.
 * If the combo does not have focus, you can force focus and fire this event using Combo.SetFocus. 
 * You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnFocusEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * combo object. You can then use this.GetCombo() to get the Combo object.
 * @param {String} OnFocusEvent Valid javascript that runs when the OnFocusEvent fires.
 * @see #GetOnFocusEvent
 * @see #SetFocus
 */
nitobi.combo.Combo.prototype.SetOnFocusEvent = function(OnFocusEvent)
{
	this.m_OnFocusEvent = OnFocusEvent;
}

/**
 * Returns the Valid javascript that is run when the combo loads on the page.
 * This function is called after you call {@link nitobi#loadComponent}. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the combo object, for example, in the 
 * Combo html tag you can set it to: <code>OnLoadEvent="MyFunction(this)"</code>.  'this' will refer to the combo object. 
 * @type String
 * @see #SetOnLoadEvent
 */
nitobi.combo.Combo.prototype.GetOnLoadEvent = function()
{
	if("void"==this.m_OnLoadEvent)
		return "";
	return this.m_OnLoadEvent;
}

/**
 * Sets the Valid javascript that is run when the combo loads on the page.
 * This function is called after you call {@link nitobi#loadComponent}. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for the combo object, for example, in the 
 * Combo html tag you can set it to: <code>OnLoadEvent="MyFunction(this)"</code>.  'this' will refer to the combo object. 
 * @param {String} OnLoadEvent Valid javascript that is run when the OnLoadEvent fires.
 * @see #GetOnLoadEvent
 * @private
 */
nitobi.combo.Combo.prototype.SetOnLoadEvent = function(OnLoadEvent)
{
	this.m_OnLoadEvent = OnLoadEvent;
}

/**
 * Returns the valid javascript that is run when the user makes a selection.
 * This function is called when the user makes a selection. This can occur if they select something from the list, or type a value and press enter.  
 * You can set this property to be any valid javascript.  You can also set this property to return the 'this' pointer 
 * for either the list or textbox object, for example, in the Combo html tag you can set it to: <code>OnSelectEvent="MyFunction(this)"</code>.  
 * 'this' will refer to either list or the textbox object. However, both support the GetCombo function; use this to get the Combo object 
 * and be sure of what kind of reference you have.
 * @type String
 * @see #SetOnSelectEvent
 * @see #GetOnBeforeSelectEvent
 */
nitobi.combo.Combo.prototype.GetOnSelectEvent = function()
{
	if("void"==this.m_OnSelectEvent)
		return "";
	return this.m_OnSelectEvent;
}

/**
 * Sets the valid javascript that is run when the user makes a selection.
 * This function is called when the user makes a selection. This can occur if they select something from the list, or type a value and press enter.  
 * You can set this property to be any valid javascript.  You can also set this property to return the 'this' pointer 
 * for either the list or textbox object, for example, in the Combo html tag you can set it to: <code>OnSelectEvent="MyFunction(this)"</code>.  
 * 'this' will refer to either list or the textbox object. However, both support the GetCombo function; use this to get the Combo object 
 * and be sure of what kind of reference you have.
 * @param {String} OnSelectEvent Valid javascript that is run when the OnSelectEvent fires.
 * @see #GetOnSelectEvent
 * @see #SetOnBeforeSelectEvent
 */ 
nitobi.combo.Combo.prototype.SetOnSelectEvent = function(OnSelectEvent)
{
	this.m_OnSelectEvent = OnSelectEvent;
}

/**
 * Gets the valid javascript that is run just before the user makes a selection.
 * This function is called just before user makes a selection. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for either the list or textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnBeforeSelectEvent="MyFunction(this)"</code>.  'this' will refer to either 
 * list or the textbox object. However, both support the GetCombo function; use this to get the Combo object 
 * and be sure of what kind of reference you have.
 * @type String
 * @see #SetOnBeforeSelectEvent
 */ 
nitobi.combo.Combo.prototype.GetOnBeforeSelectEvent = function()
{
	if("void"==this.m_OnBeforeSelectEvent)
		return "";
	return this.m_OnBeforeSelectEvent;
}
/**
 * Sets the valid javascript that is run just before the user makes a selection.
 * This function is called just before user makes a selection. You can set this property to be any valid javascript.  
 * You can also set this property to return the 'this' pointer for either the list or textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnBeforeSelectEvent="MyFunction(this)"</code>.  'this' will refer to either 
 * list or the textbox object. However, both support the GetCombo function; use this to get the Combo object 
 * and be sure of what kind of reference you have.
 * @param {String} OnBeforeSelectEvent Valid javascript that is run when the OnBeforeSelectEvent fires.
 * @see #GetOnBeforeSelectEvent
 */ 
nitobi.combo.Combo.prototype.SetOnBeforeSelectEvent = function(OnBeforeSelectEvent)
{
	this.m_OnBeforeSelectEvent = OnBeforeSelectEvent;
}

/**
 * Gets the tag that represents the combo.
 * @type HTMLElement
 * @private
 */
nitobi.combo.Combo.prototype.GetHTMLTagObject = function()
{
	return this.m_HTMLTagObject;
}

/**
 * Sets the tag that represents the combo.
 * @param {HTMLElement} The HTML element of the ComboBox
 * @private
 */
nitobi.combo.Combo.prototype.SetHTMLTagObject = function(HTMLTagObject)
{
	this.m_HTMLTagObject = HTMLTagObject;
}

/**
 * Returns the combo's unique id generated by the browser.
 * @type String
 * @private
 */
nitobi.combo.Combo.prototype.GetUniqueId = function()
{
	return this.m_UniqueId;
}

/**
 * Seturns the combo's unique id generated by the browser.
 * @param {String} UniqueId The unique id for the ComboBox
 * @private
 */
nitobi.combo.Combo.prototype.SetUniqueId = function(UniqueId)
{
	this.m_UniqueId = UniqueId;
}

/**
 * Returns the id of the combo on the HTML page. This id must be unique.
 * You can use this Id to get a reference to the combo on the page.
 * @type String
 */
nitobi.combo.Combo.prototype.GetId = function()
{
	return this.m_Id;
}

/**
 * Sets the id of the combo on the HTML page. This id must be unique.
 * @param {String} Id The id of the combo
 * @private
 */
nitobi.combo.Combo.prototype.SetId = function(Id)
{
	this.m_Id = Id;
}

/**
 * Returns the object that handles the button on the combo.
 * @type nitobi.combo.Button
 */
nitobi.combo.Combo.prototype.GetButton = function()
{
	return this.m_Button;
}

/**
 * Sets the object that handles the button on the combo.
 * @param {nitobi.combo.Button} Button The value of the property you want to set.
 * @private
 */
nitobi.combo.Combo.prototype.SetButton = function(Button)
{
	this.m_Button = Button;
}


/**
 * Returns the object that handles the list on the combo.  
 * @example
 * &#102;unction addParam(param, value)
 * {
 * 	var list = nitobi.getComponent('combo1').GetList();
 * 	var currentDatasourceUrl = list.GetDatasourceUrl();
 * 	list.SetDatasourceUrl(currentDatasourceUrl + "?" + param + "=" + value);
 * }
 * @type nitobi.combo.List
 */
nitobi.combo.Combo.prototype.GetList = function()
{
	return this.m_List;
}

/**
 * Sets the object that handles the list on the combo.
 * @param {nitobi.combo.List} List
 * @private
 */
nitobi.combo.Combo.prototype.SetList = function(List)
{
	this.m_List = List;
}

/**
 * Returns the object that handles the textbox on the combo.  
 * @example
 * &#102;unction toggleInput(editable)
 * {
 * 	var textbox = nitobi.getComponent('combo1').GetTextBox();
 * 	textbox.SetEditable(editable);
 * }
 * @type nitobi.combo.TextBox
 */
nitobi.combo.Combo.prototype.GetTextBox = function()
{
	return this.m_TextBox;
}

/**
 * Sets the object that handles the textbox on the combo.
 * @param {nitobi.combo.TextBox} TextBox
 * @private
 */
nitobi.combo.Combo.prototype.SetTextBox = function(TextBox)
{
	this.m_TextBox = TextBox;
}

/**
 * Returns the value inside the textbox.
 * This is equivalent to {@link nitobi.combo.TextBox#GetValue}.
 * Note that the value in the TextBox does not necessarily mean
 * a row from the List was selected.
 * @type String
 * @see #SetTextValue
 */ 
nitobi.combo.Combo.prototype.GetTextValue = function()
{
	return this.GetTextBox().GetValue();
}

/**
 * Sets the value inside the textbox.
 * This is equivalent to {@link nitobi.combo.TextBox#SetValue}.
 * @param {String} TextValue The value inside the textbox
 * @see #GetTextValue
 */
nitobi.combo.Combo.prototype.SetTextValue = function(TextValue)
{
	this.GetTextBox().SetValue(TextValue);
}

/**
 * Returns the values selected by the user when they click an item in the list.
 * This returns all values in the row that was selected including values not displayed in the list, but
 * returned in the response from the datasourceurl. 
 * Use {@link #GetSelectedRowIndex} to see if the user actually clicked a row, as opposed to simply typing 
 * a custom value in the list.  If you want to programmatically select an item in the list, 
 * use {@link nitobi.combo.List#SetSelectedRow}.
 * @type Array
 * @see #SetSelectedRowValues
 * @see #SetSelectedRowIndex
 */
nitobi.combo.Combo.prototype.GetSelectedRowValues = function()
{
	return this.GetList().GetSelectedRowValues();
}

/**
 * Sets the values selected by the user when they click an item in the list.
 * @param {Array} SelectedRowValues
 * @see #GetSelectedRowValues
 * @see #GetSelectedRowIndex
 * @see nitobi.combo.List#SetSelectedRow
 * @see nitobi.combo.XmlDataSource#GetRow
 */
nitobi.combo.Combo.prototype.SetSelectedRowValues = function(SelectedRowValues)
{
	this.GetList().SetSelectedRowValues(SelectedRowValues);
}

/**
 * Returns the index of the selected row number.
 * The index of the selected row is set when the user makes a selection from the list.  
 * If no selection is made or the user types a custom value in the textbox, then this value is -1. The selected 
 * row index also corresponds to the same index of the selected values row in the XmlDataSource. Note: when 
 * a row is selected, this is only one of two properties set, SelectedRowIndex, and SelectedRowValues. To set a 
 * selected row manually, use {@link nitobi.combo.List#SetSelectedRow}
 * @example
 * var combo = nitobi.getComponent('combo1');
 * if (combo.GetSelectedRowIndex() == combo.GetList().GetXmlDataSource().GetRow())
 * {
 * 	alert('They're the same!');
 * }
 * @type Number
 * @see nitobi.combo.List#SetSelectedRow
 * @see nitobi.combo.XmlDataSource#GetRow
 * @see #SetSelectedRowIndex
 */
nitobi.combo.Combo.prototype.GetSelectedRowIndex = function()
{
	return this.GetList().GetSelectedRowIndex();
}

/**
 * Sets the index of the selected row number.
 * The index of the selected row is set when the user makes a selection from the list.  
 * If no selection is made or the user types a custom value in the textbox, then this value is -1. The selected 
 * row index also corresponds to the same index of the selected values row in the XmlDataSource. Note: when 
 * a row is selected, this is only one of two properties set, SelectedRowIndex, and SelectedRowValues. To set a 
 * selected row manually, use {@link nitobi.combo.List#SetSelectedRow}
 * @param {Number} SelectedRowIndex The index of the row that was clicked
 * @see nitobi.combo.List#SetSelectedRow
 * @see nitobi.combo.TextBox#GetValue
 * @see nitobi.combo.XmlDataSource#GetRow
 * @see #SetSelectedRowIndex
 * @see #GetTextValue
 */
nitobi.combo.Combo.prototype.SetSelectedRowIndex = function(SelectedRowIndex)
{
	this.GetList().SetSelectedRowIndex(SelectedRowIndex);
}

/**
 * Returns the name of the field in the dataset that provides text for the list to display.
 * If you want a combo that displays key/value pairs, use this property. The DataTextField 
 * is the field used as a display value, and the DataValueField is used as a key value, and is the 
 * value returned when using GetSelectedItem.  If you only specify 
 * one of these it is used as both the TextField and the ValueField.
 * @type String
 * @see #GetSelectedItem
 * @see nitobi.combo.TextBox#GetDataFieldIndex
 */
nitobi.combo.Combo.prototype.GetDataTextField = function()
{
	return this.m_DataTextField;
}

/**
 * Sets the name of the field in the dataset that provides text for the list to display.  
 * Use this if you only want one column, and you don't want to use the ListColumnDefinition tags.
 * If you want a combo that displays key/value pairs, use this property. The DataTextField 
 * is the field used as a display value, and the DataValueField is used as a key value, and is the 
 * value returned when using GetSelectedItem.  If you only specify 
 * one of these it is used as both the TextField and the ValueField.
 * @param {String} DataTextField The name of the data field to use as a display field
 * @private
 */
nitobi.combo.Combo.prototype.SetDataTextField = function(DataTextField)
{
	this.m_DataTextField = DataTextField;
	var hiddenField = $ntb(this.GetId() + "DataTextFieldIndex");
	if (null != hiddenField)
	{
		var index = this.GetList().GetXmlDataSource().GetColumnIndex(DataTextField);
		hiddenField.value = index;
	}
}

/**
 * Returns the name of the field in the dataset that provides data for the list. Use this
 * if you only want one column, and you don't want to use the ListColumnDefinition tag.
 * If you want a combo that displays key/value pairs, use this property. The DataTextField 
 * is the field used as a display value, and the DataValueField is used as a key value, and is the 
 * value returned when using GetSelectedItem.  If you only specify 
 * one of these it is used as both the TextField and the ValueField.
 * @type String
 * @see #GetDataTextField
 * @see #GetDataFieldIndex
 * @see nitobi.combo.TextBox#GetDataFieldIndex
 */
nitobi.combo.Combo.prototype.GetDataValueField = function()
{
	return this.m_DataValueField;
}

/**
 * Sets the name of the field in the dataset that provides data for the list. Use this if you only want one column, and you don't want to use the
 * ListColumnDefinition tag.
 * @param {String} DataValueField The value of the property you want to set
 * @private
 */
nitobi.combo.Combo.prototype.SetDataValueField = function(DataValueField)
{
	this.m_DataValueField = DataValueField;
	// I don't think there is support to switch DataValueField midstream, but i put it
	// here for future use.
	var hiddenField = $ntb(this.GetId() + "DataValueFieldIndex");
	if (null != hiddenField)
	{
		var index = this.GetList().GetXmlDataSource().GetColumnIndex(DataValueField);
		hiddenField.value = index;
	}
}

/**
 * Returns the selected list item.
 * Used only in conjunction with the DataValueField
 * and DataTextField properties. Check SelectedRowIndex to see if an item was actually selected from
 * the list as opposed to a custom value being entered; if so, use {@link #GetTextValue}
 * Retrieve the text and value as follows: 
 * @example
 * SelectedItem.Text;
 * SelectedItem.Value;
 * 
 * @type Object
 */
nitobi.combo.Combo.prototype.GetSelectedItem = function()
{
// better to default to col 0 (i.e. GetColumnIndex(null) now returns 0) than to fail and throw a fit
//		if ((null == this.GetDataValueField()) || (null == this.GetDataTextField())){
//			alert(this.GetId() + " Error: You must define a DataValueField and a DataTextField to use this function.");

//			return;
//		}
	var ListItem=new Object;
	ListItem.Value=null;
	ListItem.Text=null;
	var rowIndex = this.GetList().GetSelectedRowIndex();
	if (-1 != rowIndex)
	{
		var dataSource=this.GetList().GetXmlDataSource();
		var row = dataSource.GetRow(rowIndex);
		var colIndex = dataSource.GetColumnIndex(this.GetDataValueField());
		if (-1 != colIndex)
			ListItem.Value = row[colIndex];
		colIndex = dataSource.GetColumnIndex(this.GetDataTextField());
		if (-1 != colIndex)
			ListItem.Text = row[colIndex];
	}

	return ListItem;
}

/**
 * Returns the javascript that is run when the list is hidden.
 * You can set this property to be any valid javascript. You can also hide the list
 * and fire this event by using the {@link nitobi.combo.List#Hide} function.
 * Set this property to return the 'this' pointer for the list object, for example, in the 
 * Combo html tag you can set it to: <code>OnHideEvent="MyFunction(this)"</code>.  'this' will refer to the
 * list object. You can then use this.GetCombo() to get the Combo object.
 * @type String
 * @see #SetOnHideEvent
 * @see nitobi.combo.List#Hide
 */
nitobi.combo.Combo.prototype.GetOnHideEvent = function()
{
	return this.GetList().GetOnHideEvent();
}

/**
 * Sets the javascript that is run when the list is hidden.
 * You can set this property to be any valid javascript. You can also hide the list
 * and fire this event by using the {@link nitobi.combo.List#Hide} function.
 * Set this property to return the 'this' pointer for the list object, for example, in the 
 * Combo html tag you can set it to: <code>OnHideEvent="MyFunction(this)"</code>.  'this' will refer to the
 * list object. You can then use this.GetCombo() to get the Combo object.
 * @param {String} OnHideEvent Valid javascript that runs when the OnHideEvent fires.
 * @see #GetOnHideEvent
 * @see nitobi.combo.List#Hide
 */
nitobi.combo.Combo.prototype.SetOnHideEvent = function(OnHideEvent)
{
	this.GetList().SetOnHideEvent(OnHideEvent);
}

/**
 * Returns the javascript that is run when the user tabs out of the combo.
 * The OnBlurEvent will also fire when this event fires.
 * You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnTabEvent="MyFunction(this)"</code>.  'this' will refer to the
 * textbox object. You can then use this.GetCombo() to get the Combo object.  For additional information about the
 * object, including how to check for the shift key, see GetEventObject.
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction OnTab(textbox)
 * {
 *  	var combo = textbox.GetCombo();
 *  	if (combo.GetEventObject().shiftKey)
 *  	{
 *  		AddEventLog("OnShiftTab");
 *  	}
 *  	else
 *  	{
 *  		AddEventLog("OnTab");
 *  	}
 *  }
 * </code></pre>
 * </div>
 * @type String
 * @see #SetOnTabEvent
 * @see #GetEventObject
 * @see #GetOnBlurEvent
 */
nitobi.combo.Combo.prototype.GetOnTabEvent = function()
{
	return this.m_OnTabEvent;
}

/**
 * Sets the javascript that is run when the user tabs out of the combo.
 * The OnBlurEvent will also fire when this event fires.
 * You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * Combo html tag you can set it to: <code>OnTabEvent="MyFunction(this)"</code>.  'this' will refer to the
 * textbox object. You can then use this.GetCombo() to get the Combo object.  For additional information about the
 * object, including how to check for the shift key, see GetEventObject.
 * @param {String} OnTabEvent Valid javascript that is run when the user tabs out of the combo
 * @see #GetOnTabEvent
 * @see #GetEventObject
 * @see #SetOnBlurEvent
 */
nitobi.combo.Combo.prototype.SetOnTabEvent = function(OnTabEvent)
{
	this.m_OnTabEvent = OnTabEvent;
}


/**
 * Returns the javascript event object that describes more information about a certain event.
 * This is not available in all events.  For futher documentation regarding this object, see
 * <a href="http://msdn.microsoft.com/workshop/author/dhtml/reference/objects/obj_event.asp">MSDN</a>.
 * @type Object
 * @private
 */
nitobi.combo.Combo.prototype.GetEventObject = function()
{
	return this.m_EventObject;
}

/**
 * @private
 */
nitobi.combo.Combo.prototype.SetEventObject = function(EventObject)
{
	this.m_EventObject = EventObject;
}


/**
 * Returns the character used to separate selected list records, in SmartList mode. The default value is "," (comma).
 * You should try to pick a value that will not appear in your datasource.
 * @type String
 * @see #SetSmartListSeparator
 */
nitobi.combo.Combo.prototype.GetSmartListSeparator = function()
{
	return this.SmartListSeparator;
}

/**
 * Sets the character used to separate selected list records, in SmartList mode. The default value is "," (comma).
 * You should try to pick a value that will not appear in your datasource.
 * @param {String} slstsep The character used to separate the values in textbox when in smartlist mode
 * @see #GetSmartListSeparator
 */
nitobi.combo.Combo.prototype.SetSmartListSeparator = function(slstsep)
{
	this.SmartListSeparator = slstsep;
}

/**
 * Returns the HTML tab index of the combo box.
 * @type Number
 * @see #SetTabIndex
 */
nitobi.combo.Combo.prototype.GetTabIndex = function()
{
	return this.m_TabIndex;
}

/**
 * Sets the HTML tab index of the combo box.
 * his should be a unique number. Combos with the same tab index will conflict.
 * @param {Number} TabIndex The tab index of the combo
 * @see #GetTabIndex
 */
nitobi.combo.Combo.prototype.SetTabIndex = function(TabIndex)
{
	this.m_TabIndex = TabIndex;
}

/**
 * Determines whether the combo is enabled for user interaction.  Note
 * that the enabled/disabled distinction is different from the editable/non-editable
 * distinction.  When the ComboBox is disabled, both the textbox and list are disabled
 * whereas if the ComboBox is non-editable, the list is still accessible while the textbox
 * is disabled.
 * @example
 * if(nitobi.getComponent('combo1').GetEnabled() == true)
 * {
 * 	// Check if the ComboBox is enabled before programatically setting
 * 	// the value in the TextBox
 * 	nitobi.getComponent('combo1').SetTextValue("We're enabled!");
 * }
 * @type Boolean
 * @see #SetEnabled
 * @see #GetEditable
 */
nitobi.combo.Combo.prototype.GetEnabled = function()
{
	return this.m_Enabled;
}

/**
 * Sets whether the combo is enabled for user interaction.
 * @param {Boolean} Enabled true if the combo is enabled and false otherwise
 * @see #GetEnabled
 * @see #SetEditable
 */
nitobi.combo.Combo.prototype.SetEnabled = function(Enabled)
{
	this.m_Enabled = Enabled;
	var t = this.GetTextBox();
	if(null!=t.GetHTMLTagObject())
	{
		if(Enabled)
		{
			t.Enable();
		}
		else
		{
			t.Disable();
		}

	}
	var b = this.GetButton();
	if(null!=b && null!=b.m_Img)
	{
		if(Enabled)
		{
			b.Enable();
		}
		else
		{
			b.Disable();
		}
	}
}


/**
 * Initialize the combo. This draws the combo and binds each EBA object to its corresponding HTML tag.
 * @private
 */
nitobi.combo.Combo.prototype.Initialize = function()
{
	var DEFAULTCLASSNAME="ComboBox";
	var DEFAULTTHEME="outlook";
	
	var DEFAULTONSELECTEVENT="";
	var DEFAULTONLOADEVENT="";
	var DEFAULTONBEFORESELECTEVENT="";
	var DEFAULTONBLUR="";
	var DEFAULTONFOCUS="";
	var DEFAULTONTAB="";
	
	var DEFAULTTABINDEX="0";
	var DEFAULTENABLED=true;
	var DEFAULTMODE="default";
	var DEFAULTLISTZINDEX=1000;
	var DEFAULTSMARTLISTSEPARATOR=",";
	var DEFAULTONSHOWEVENT="";
	var DEFAULTONHHIDEEVENT="";

	var listZIndex = this.m_userTag.getAttribute("ListZIndex");
	((null == listZIndex) || ("" == listZIndex))
		? this.SetListZIndex(DEFAULTLISTZINDEX)
		: this.SetListZIndex(listZIndex);

	this.SetWidth(this.m_userTag.getAttribute("Width"));
	this.SetHeight(this.m_userTag.getAttribute("Height"));
	
	this.theme = this.m_userTag.getAttribute("theme");
	if ((this.theme == null) || ("" == this.theme))
	{
		this.theme = DEFAULTTHEME;
	}
	

	var sls=this.m_userTag.getAttribute("SmartListSeparator");
	((null == sls) || ("" == sls))
		? this.SetSmartListSeparator(DEFAULTSMARTLISTSEPARATOR)
		: this.SetSmartListSeparator(sls);

	var enabled=this.m_userTag.getAttribute("Enabled");
	((null == enabled) || ("" == enabled))
		? this.SetEnabled(DEFAULTENABLED)
		: this.SetEnabled("true"==enabled.toLowerCase());

	var tabidx=this.m_userTag.getAttribute("TabIndex");
	((null == tabidx) || ("" == tabidx))
		? this.SetTabIndex(DEFAULTTABINDEX)
		: this.SetTabIndex(tabidx);

	var ontab=this.m_userTag.getAttribute("OnTabEvent");
	((null == ontab) || ("" == ontab))
		? this.SetOnTabEvent(DEFAULTONTAB)
		: this.SetOnTabEvent(ontab);
	
	this.SetEventObject(null);

	var onfocus=this.m_userTag.getAttribute("OnFocusEvent");
	((null == onfocus) || ("" == onfocus))
		? this.SetOnFocusEvent(DEFAULTONFOCUS)
		: this.SetOnFocusEvent(onfocus);

	var onblur=this.m_userTag.getAttribute("OnBlurEvent");
	((null == onblur) || ("" == onblur))
		? this.SetOnBlurEvent(DEFAULTONBLUR)
		: this.SetOnBlurEvent(onblur);

	var ose=this.m_userTag.getAttribute("OnSelectEvent");
	((null == ose) || ("" == ose))
		? this.SetOnSelectEvent(DEFAULTONSELECTEVENT)
		: this.SetOnSelectEvent(ose);
		
	var ole=this.m_userTag.getAttribute("OnLoadEvent");
	((null == ole) || ("" == ole))
		? this.SetOnLoadEvent(DEFAULTONLOADEVENT)
		: this.SetOnLoadEvent(ole);

	var obse=this.m_userTag.getAttribute("OnBeforeSelectEvent");
	((null == obse) || ("" == obse))
		? this.SetOnBeforeSelectEvent(DEFAULTONBEFORESELECTEVENT)
		: this.SetOnBeforeSelectEvent(obse);
		
	

	var css=this.m_userTag.getAttribute("CSSClassName");
	((null == css) || ("" == css))
		? this.SetCSSClassName(DEFAULTCLASSNAME)
		: this.SetCSSClassName(css);

	var uniqueId = this.m_userTag.uniqueID;
	this.SetUniqueId(uniqueId);

	// If we're using the Combo width properties instead of textbox, resize the container.
	// The container will define the height and width, and the textbox will resize to match it.
	if (this.GetWidth() != null)
	{
		if ("smartlist" == this.mode)
		{
			this.m_TextBox.SetWidth(this.GetWidth());
			this.m_TextBox.SetHeight(this.GetHeight());
		}

		// We need to make the container block if the unit type is %.
		// Otherwise, the containing span tag, doesn't resize when the browser window resizes.
		if (nitobi.Browser.GetMeasurementUnitType(this.GetWidth()) == "%")
		{
			this.m_userTag.style.display = "block";
		}
		else
		{
			this.m_userTag.style.display = "inline";
		}

		// In smartlist, we let the textbox govern the size of the combo.
		// It has a height where input type=text does not. It must
		// also not hide any overflow, as the textarea border get's cut off.
		if ("smartlist" == this.mode)
		{
			this.m_userTag.style.height = this.GetHeight();
		}
		else
		{
			this.m_userTag.style.overflow = "hidden";
		}
	}

	// note:
	// - keeping <input type="text"></input><img></img> on the same line w/o any spaces, breaks, etc.
	// is important to ensuring that no gap appears between the two elements so do NOT put an
	// "\n" before/after this <nobr>...</nobr> html bit


	// Insert all the required HTML and then allow the object to set its HTML OBJECT.
	var html = "<span id='EBAComboBox" + uniqueId + "' class='ntb-combo-reset " + this.GetCSSClassName() + "' "
		+ "onMouseOver='$ntb(\"" + this.GetId() + "\").object.m_Over=true' "
		+ "onMouseOut='$ntb(\"" + this.GetId() + "\").object.m_Over=false'>"
		+ "<span id='EBAComboBoxTextAndButton" + uniqueId + "' class='ComboBoxTextAndButton'><nobr>";

	// Write out the hidden fields that display the "key" values.
	var id="";
	var comboId = this.GetId();
	for (var i=0, n = this.GetList().GetXmlDataSource().GetNumberColumns(); i < n; i++)
	{
		id = comboId + "SelectedValue" + i;
		// Name and id are the same for .net purposes.
		html+="<input type='HIDDEN' id='" + id + "' name='" + id + "'></input>";
	}
	id = comboId + "SelectedRowIndex";
	html += "<input type='HIDDEN' id='" + id + "' name='" + id + "' value='" + this.GetSelectedRowIndex() + "'></input>";

	// Insert the hidden fields that map the DataValueField to its ordinal field position in
	// the table of xml data.
	var dataTextField = this.GetDataTextField();
	// better to default to col 0 (i.e. GetColumnIndex(null) now returns 0) than to fail and throw a fit
	id = comboId + "DataTextFieldIndex";
	var index = this.GetList().m_XmlDataSource.GetColumnIndex(dataTextField);
	html+="<input type='HIDDEN' id='" + id + "' name='" + id + "' value='" + index + "'></input>";
	id = comboId + "DataValueFieldIndex";
	var dataValueField = this.GetDataValueField();
	index = this.GetList().m_XmlDataSource.GetColumnIndex(dataValueField);
	html+="<input type='HIDDEN' id='" + id + "' name='" + id + "' value='" + index + "'></input>";

	html += "<div class=\" ntb-combo-reset "+ this.theme +"\">"
	html += this.GetTextBox().GetHTMLRenderString();
	var modeIsDef = (this.mode=="default" || this.mode=="unbound");
	if(modeIsDef)
		html += this.GetButton().GetHTMLRenderString();
		
	html += "<div style=\"overflow: hidden; display: block; clear: both; float: none; height: 0px; width: auto;\"><!-- --></div>";
	// Might be missing a div here...
	html += "</div>"
	
	html += "</nobr></span></span>";
	// It would be nice to have only one inserthtml, but for some reason,
	// the list prefers to be in the body.
			/*+this.GetList().GetHTMLRenderString()*/;

	nitobi.html.insertAdjacentHTML(this.m_userTag,'beforeEnd',html);

	this.SetHTMLTagObject($ntb('EBAComboBox'+uniqueId));

	// Now that we have tags for the html object initialize the EBA object.

	this.GetTextBox().Initialize();

	if(modeIsDef)
		this.GetButton().Initialize();

	// Check to see if we need to setup the combo with an initial search.
	var is = this.m_InitialSearch;
	if(null!=is && ""!=is)
	{
		this.InitialSearch(is);		
	}

	eval(this.GetOnLoadEvent());

	// Don't user this after init. Use the proper accessors.
	this.m_userTag=null;

	nitobi.combo.numCombosToLoad--;
	if (nitobi.combo.numCombosToLoad == 0)
	{
		nitobi.combo.finishInit();
	}
}

/**
 * @private
 */
nitobi.combo.Combo.prototype.InitialSearch = function(SearchTerm)
{
	var list=this.GetList();
	var tb = this.GetTextBox();
	var dfi = tb.GetDataFieldIndex();
	list.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_EXPIRED);
	list.InitialSearchOnce=true;
	
	this.m_Callback=_EbaComboCallback;
	list.Search(SearchTerm, dfi,this.m_Callback,this.m_NoDataIsland);
}

/**
 * @private
 */
function _EbaComboCallback(searchResult, list)
{
	if(searchResult >= 0)
	{
		var tb = list.GetCombo().GetTextBox();
		var row = list.GetRow(searchResult);
		list.SetActiveRow(row);
		list.SetSelectedRow(searchResult);
		tb.SetValue(list.GetSelectedRowValues()[ tb.GetDataFieldIndex()]);
		list.scrollOnce=true;
		list.InitialSearchOnce=false;
	}
	else
	{
		var combo = list.GetCombo();
		combo.SetTextValue(combo.GetInitialSearch());
	}
	
}

/**
 * Returns the active value given a field name.
 * <b>The active row is not the selected row.</b> It is the row that has been
 * activated either because the user has the mouse over it, or because the text in the
 * textbox makes a match on a row given the mode's search scheme.
 * @param {String} fieldname The field name of the column in the active row to get.
 * @type String
 * @see #GetSelectedRowValues
 * @see #GetSelectedRowIndex
 */
nitobi.combo.Combo.prototype.GetFieldFromActiveRow = function(fieldname)
{
	var l = this.GetList();
	if(null!=l)
	{

		var r = l.GetActiveRow();
		if(null!=r)
		{
			var y = l.GetRowIndex(r);
			var d = l.GetXmlDataSource();
			var x = d.GetColumnIndex(fieldname);
			return d.GetRowCol(y,x);
		}
	}
	return null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// 2005.04.18 - changed all // (xml comments) to // (normal comments)
// no need to create documentation (for now) for this file

// *****************************************************************************
// *****************************************************************************
// * Iframe
// *****************************************************************************
// <class name='Iframe' access='private'>
// <summary>


// </summary>
// *****************************************************************************
// * Iframe Constructor
// *****************************************************************************
// NOTE: DOUBLE SLASHED COMMENTS SO THAT CSHARP GEN DOESN'T CREATE TWO CTORS
// <function name='Iframe' access="private">
// <summary>Constructor for Iframe, a (cross-browser) object that encapsulates an absolutely positioned IFRAME.</summary>
// <returns type="void"></returns></function>
// createAttribute(), createDocumentFragment(), createElement(),
// createTextNode(), getElementById(), etc.: REMEMBER to call these from
// Iframe.document vs. document because this IFRAME is a different (new) document
// parameters:
// - attachee (required) - HTMLElement to attach this IFRAME to
// - h (optional) - height of IFRAME, defaults to 0 if not specified
// - w (optional) - width of IFRAME, defaults to offsetWidth of attachee if not specified
/**
 * @private
 * @ignore
 */
function Iframe(attachee,h,w, ComboHtmlTagObject)
{
	if(!attachee){
		var msg="Iframe constructor: attachee is null!";
		alert(msg);
		throw msg;
	}
	var d=document;
	var oIF=d.createElement("IFRAME");
	var s=oIF.style;
	// attach() depends on this.oIFStyle so set this before calling
	// attach() depends on this.attachee so set this before calling
	this.oIFStyle=s;
	this.attachee=attachee;
	this.attach();
	s.position="absolute";
	w = w || attachee.offsetWidth;
	s.width=w;
	s.height = h || 0;
	s.display="none";
	s.overflow="hidden";
	// .name is needed to use frames[name]; .id is not enough
	var name="IFRAME"+oIF.uniqueID;
	oIF.name=name;
	oIF.id=name;
	oIF.frameBorder=0;
	// Keeps IE from complaining about unsecure items when in secure site
	oIF.src="javascript:true";
	
	// Insert the iframe just before the form end if possible.
	// This is done to keep the iframe in any form the combo might be in
	// If this is not done, the list causes the webpage to resize.
	var hostTag = Browser_GetParentElementByTagName(ComboHtmlTagObject,"form");
	if (null==hostTag)
	{
		hostTag = d.body;
	}
	hostTag.appendChild(oIF);
	
	var oF=window.frames[name];
	var oD=oF.document;
	oD.open();
	// - oD.write(...) is needed to create a body for oD; remember to access oD.body AFTER oD.write(...);
	// - margin-* all need to be set to 0 or we'd get some default margin space;
	// - background-color:white; needed for Mozilla to show w/o bleeding as in IE;
	// - float:left; needed for Mozilla or else SPAN won't show;
	// - need to put border in SPAN (vs. in IFRAME) or we'd get minor bleeding w/ SELECT elements in IE;
	// - bodySpan's width and height are reduced by 2 pixels for Mozilla to show the same as in IE
	//		because IE's width/height include borders whereas Mozilla's don't; so if user needs to change
	//		border width to 0 (i.e. Iframe.bodySpan.style.border) then please adjust the width/height
	//		according for Moz (i.e. add border pixels back); similarly, adjustments to width/height should
	//		take into account the borders for Moz (i.e. minus border pixels);
	// - note that inline styles below will not be overriden by css (i.e. assignment to .className);
	//		IF it's necessary to override, then do it through DOM (i.e. Iframe.bodySpan.style.*);
	//		user may want to override the border color, width, style (see previous note on this for Moz)
	// BUG: TEXTAREA's cursor still bleeds through IFRAME in IE;
	oD.write("<html><head></head><body style=\"margin:0;background-color:white;\"><span id=\"bodySpan\" class=\"ntb-combobox-list-outer-border\" style=\"overflow:hidden;float:left;border-width:1px;border-style:solid;width:"+(w-(nitobi.browser.MOZ?2:0))+";height:"+(h-(nitobi.browser.MOZ?2:0))+";\"></span></body></html>");
//	oD.write("<html><head></head><body style=\"margin:0;background-color:white;\"><span id=\"bodySpan\" style=\"overflow:hidden;float:left;border:0px solid black;width:"+w+";height:0;\"></span></body></html>");
	oD.close();
	// because this IFRAME is a new document, need to import window.document's
	// stylesheets or else they won't be available to this IFRAME
	var dss=d.styleSheets;
	var ss=oD.createElement("LINK");
	for(var i=0,n=dss.length; i<n; i++){
		// cloneNode() is faster than createElement()
		var ss2=ss.cloneNode(true);
		ss2.rel=(nitobi.browser.IE ? dss[i].owningElement.rel : dss[i].ownerNode.rel);
		ss2.type="text/css";
		ss2.href=dss[i].href;
		ss2.title=dss[i].title;
		oD.body.appendChild(ss2);
	}
	// only one HEAD tag written above so [0] is our desired element
	var head=oD.getElementsByTagName("head")[0];
	// - because this IFRAME is a new document, need to import window.document's
	//		scripts or else they won't be available to this IFRAME;
	// - document.scripts is only in IE; need to grab SCRIPT tags in Moz;
	var ds=(d.scripts?d.scripts:d.getElementsByTagName("script"));
	var st=oD.createElement("SCRIPT");
	var src=null;
	for(var i=0,n=ds.length; i<n; i++){
		src=ds[i].src;
		if(""!=src)
		{
			// cloneNode() is faster than createElement()
			var st2=st.cloneNode(true);
			st2.language=ds[i].language;
			st2.src=src;
			head.appendChild(st2);
		}
	}
	this.oIF=oIF;
	this.oF=oF;
	this.d=oD;
	this.bodySpan=oD.getElementById("bodySpan");
	this.bodySpanStyle=this.bodySpan.style;
	if(window.addEventListener){
		// Moz way of moving IFRAME on body resize; onresize in Moz is called
		// once after the user releases the mouse after resizing
		window.addEventListener('resize',this,false);
	}else if(window.attachEvent){
		if(!window.g_Iframe_oIFs){
			window.g_Iframe_oIFs=new Array;
			window.g_Iframe_onresize=window.onresize;
			Iframe_oResize();
			window.onresize=window.oResize.check1;
		}
		window.g_Iframe_oIFs[name]=this;
	}
}

// *****************************************************************************
// * Unload
// *****************************************************************************
/// <function name='Unload' access='private' obfuscate='no'><summary>
/// Actively unloads the object, and destroys owned objects.
/// </summary></function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.Unload = Iframe_Unload;
/**
 * @private
 * @ignore
 */
function Iframe_Unload()
{
	if (this.oIF)
	{
		delete this.oIF;
	}	
}

// the IE solution to Moz's handleEvent
// TODO: perhaps find a way to do this w/o injecting global variables?
/**
 * @private
 * @ignore
 */
var g_Iframe_oIFs=null;
/**
 * @private
 * @ignore
 */
var g_Iframe_onresize=null;
/**
 * @private
 * @ignore
 */
function Iframe_onafterresize(){
	for(var f in window.g_Iframe_oIFs){
		var oIF=window.g_Iframe_oIFs[f];
		oIF.attach();
	}
	if(window.g_Iframe_onresize)
		window.g_Iframe_onresize();
}
/**
 * @private
 * @ignore
 */
function Iframe_dfxWinXY(w){
	var b,d,x,y;
	x=y=0;
	var d=window.document;
	if(d.body){
		b = d.documentElement.clientWidth ? d.documentElement : d.body;
		x=b.clientWidth||0;
		y=b.clientHeight||0;
	}
	return {x:x,y:y};
}
/**
 * @private
 * @ignore
 */
function Iframe_oResize(){
	window.oResize={
		CHECKTIME:500,
		oldXY:Iframe_dfxWinXY(window),
		timerId:0,
		check1:function(){window.oResize.check2()},
		check2:function(){
			if(this.timerId)
				window.clearTimeout(this.timerId);
			this.timerId = setTimeout("window.oResize.check3()",this.CHECKTIME);
		},
		check3:function(){
			var newXY = Iframe_dfxWinXY(window);
			this.timerId = 0;
			if((newXY.x != this.oldXY.x) || (newXY.y != this.oldXY.y)){
				this.oldXY = newXY;
				Iframe_onafterresize();
			}
		}
	}
}

// *****************************************************************************
// * handleEvent
// *****************************************************************************
// <function name="handleEvent" access="private">
// <summary>Internal function for handling events in the context of this Iframe object.</summary>
// </function>
// works for Moz only
/**
 * @private
 * @ignore
 */
Iframe.prototype.handleEvent=Iframe_handleEvent;
/**
 * @private
 * @ignore
 */
function Iframe_handleEvent(evt){
	switch(evt.type){
		case 'resize':{
			if(this.isVisible())
				this.attach();
			break;
		}
	}
}

// *****************************************************************************
// * offset
// *****************************************************************************
// <function name="offset" access="private">
// <summary>Calculates the offset(Left|Top) of an object on a page.</summary>
// </function>
// parameters:
// o = object to find offset*
// attr = either "offsetLeft" or "offsetTop"
// a = true if absolute positioning, false otherwise
/**
 * @private
 * @ignore
 */
Iframe.prototype.offset=Iframe_offset;
/**
 * @private
 * @ignore
 */
function Iframe_offset(o, attr, a){
// for absolutely positioned 'o', only take its offset* and add
// table border pixels back in;
// for relatively positioned 'o', also add in its ancestor's offset*
	var x = (a ? o[attr] : 0);
	var _o = o;
	while(o){
		x += (a ? 0 : o[attr]);

		// seems to fix a bug in IE where if the element is inside a TABLE
		// with a border != 0, the offset* is off by one
		if(nitobi.browser.IE && "TABLE"==o.tagName && "0"!=o.border && ""!=o.border){
			x++;
		}
		o=o.offsetParent;
	}
// no longer necessary because we've fixed the textbox+button position issues;
// but leave here just in case; comments get stripped out at build-time anyway
//	// IE hack-like code to deal w/ TR's w/ VALIGN of 'middle' and 'bottom',
//	// which mess up the offsetTop calculated for the object 'o'
//	if(nitobi.browser.IE && "offsetTop"==attr){
//		o=_o;
//		while(o){
//			if("TR"==o.tagName && "TD"==_o.tagName){
//				// either "middle" or "" (because default is "middle")
//				// NOTE: known bug: the minus one is there to round down (in case
//				// the difference is odd); most of the time, this is the desired
//				// behavior; some other times, the top is off by one (i.e. didn't
//				// subtract enough); however, not subtract enough (by one pixel) is
//				// better than subtracting by too much (by one pixel); so the final
//				// decision is to leave it as minus one to always round down
//				if("middle"==o.vAlign)
//					x -= (_o.clientHeight - _o.scrollHeight - 1) / 2;
//				else if("bottom"==o.vAlign)
//					x -= _o.clientHeight - _o.scrollHeight;
//			}
//			// save previous element in chain
//			_o=o;
//			o=o.parentElement;
//		}
//	}
	return x;
}

// *****************************************************************************
// * setHeight
// *****************************************************************************
// <function name="setHeight" access="private">
// <summary>Sets the height of the IFRAME</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.setHeight=Iframe_setHeight;
/**
 * @private
 * @ignore
 */
function Iframe_setHeight(h,workaround){
	h=parseInt(h);
	this.oIFStyle.height=h;
	// bodySpan's height is reduced by ? border pixels for Mozilla to show the same as in IE
	//	because IE's width/height include borders whereas Mozilla's don't
	if(workaround!=true){
		this.bodySpanStyle.height =
			(h-(nitobi.browser.MOZ ? parseInt(this.bodySpanStyle.borderTopWidth) + parseInt(this.bodySpanStyle.borderBottomWidth) : 0));
	}
}

// *****************************************************************************
// * setWidth
// *****************************************************************************
// <function name="setWidth" access="private">
// <summary>Sets the width of the IFRAME</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.setWidth=Iframe_setWidth;
/**
 * @private
 * @ignore
 */
function Iframe_setWidth(w){
	w=parseInt(w);
	this.oIFStyle.width=w;
	// bodySpan's width is reduced by ? border pixels for Mozilla to show the same as in IE
	//	because IE's width/height include borders whereas Mozilla's don't
	this.bodySpanStyle.width =
		(w-(nitobi.browser.MOZ ? parseInt(this.bodySpanStyle.borderLeftWidth) + parseInt(this.bodySpanStyle.borderRightWidth) : 0));
}

// *****************************************************************************
// * show
// *****************************************************************************
// <function name="show" access="private">
// <summary>Shows the IFRAME</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.show=Iframe_show;
/**
 * @private
 * @ignore
 */
function Iframe_show(){
// in Moz & IE, resizing window when IFRAME is not shown and then
// showing the IFRAME can cause the IFRAME to be off, position-wise; solve by
// calling attach() every time show() is called
	this.attach();
	this.oIFStyle.display="inline";
}

// *****************************************************************************
// * hide
// *****************************************************************************
// <function name="hide" access="private">
// <summary>Hides the IFRAME</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.hide=Iframe_hide;
/**
 * @private
 * @ignore
 */
function Iframe_hide(){
	this.oIFStyle.display="none";
}

// *****************************************************************************
// * toggle
// *****************************************************************************
// <function name="toggle" access="private">
// <summary>Shows the IFRAME if hidden; hides the IFRAME if shown</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.toggle=Iframe_toggle;
/**
 * @private
 * @ignore
 */
function Iframe_toggle(){
	if(this.isVisible())
		this.hide();
	else
		this.show();
}

// *****************************************************************************
// * isVisible
// *****************************************************************************
// <function name="isVisible" access="private">
// <summary>Returns whether or not the IFRAME if visible</summary>
// </function>
/**
 * @private
 * @ignore
 */
Iframe.prototype.isVisible=Iframe_isVisible;
/**
 * @private
 * @ignore
 */
function Iframe_isVisible(){
	return "inline"==this.oIFStyle.display;
}

// *****************************************************************************
// * attach
// *****************************************************************************
// <function name="attach" access="private">
// <summary>Attaches this IFRAME to the bottom of 'attachee', matching its left border.</summary>
// </function>
// attach() depends on this.oIFSytle so set this before calling attach()
// attach() depends on this.attachee so set this before calling attach()
/**
 * @private
 * @ignore
 */
Iframe.prototype.attach=Iframe_attach;
/**
 * @private
 * @ignore
 */
function Iframe_attach(){
	var attachee=this.attachee;
	var a = (attachee.offsetParent && "absolute"==attachee.offsetParent.style.position);
	// oIF.style.top: minus 1 to match f's top border w/ attachee's bottom border
	// attachees w/ absolutely positioned parents need to be handled differently
	this.oIFStyle.top = this.offset(attachee, "offsetTop", a) + attachee.offsetHeight - 1 + (a ? parseInt(attachee.offsetParent.style.top) : 0);
	this.oIFStyle.left = this.offset(attachee, "offsetLeft", a) + (a ? parseInt(attachee.offsetParent.style.left) : 0);
}
// </class>
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
var EbaComboUiServerError=0;
var EbaComboUiNoRecords=1;
var EbaComboUiEndOfRecords=2;
var EbaComboUiNumRecords=3;
var EbaComboUiPleaseWait=4;

/**
 * @private
 */
nitobi.combo.createLanguagePack = function()
{
	try
	{
		if ( typeof ( EbaComboUi ) == "undefined" )
		{
			EbaComboUi = new Array();
			EbaComboUi[EbaComboUiServerError]="The ComboBox tried to retrieve information from the server, but an error occured. Please try again later.";
			EbaComboUi[EbaComboUiNoRecords]="No new records.";
			EbaComboUi[EbaComboUiEndOfRecords]="End of records.";
			EbaComboUi[EbaComboUiNumRecords]=" records.";
			EbaComboUi[EbaComboUiPleaseWait]="Please Wait...";
		}
	}
	catch(err)
	{
		alert("The default language pack could not be loaded.  " + err.message);
	}
}





/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");

/// Constants
EBAComboBoxListHeader=0;
EBAComboBoxListBody=1;
EBAComboBoxListFooter=2;
EBAComboBoxListBodyTable=3;
EBAComboBoxListNumSections=4;
EBAComboBoxList=5;
// Timeout Constants
EBADatabaseSearchTimeoutStatus_WAIT=0;
EBADatabaseSearchTimeoutStatus_EXPIRED=1;
EBADatabaseSearchTimeoutStatus_NONE=2;
EBADatabaseSearchTimeoutWait=200;
// Action Key constants
EBAMoveAction_UP = 0;
EBAMoveAction_DOWN = 1;
// scroll to constants
EBAScrollToNone = 0;
EBAScrollToTop = 1;
EBAScrollToBottom = 2;
EBAScrollToNewTop = 3;
EBAScrollToTypeAhead = 4;
EBAScrollToNewBottom = 5;

// Search constants
EBAComboSearchNoRecords=0;
EBAComboSearchNewRecords=1;

// Moz default scroll bar size
EBADefaultScrollbarSize=18;

/**
 * Creates a List object to be associated with a {@link nitobi.combo.Combo} object.
 * @class List manages the list portion of the Nitobi ComboBox.  Normally, you wouldn't instantiate it
 * manually, but rather, you can get a reference to one using {@link nitobi.combo.Combo#GetList}
 * @example
 * var combo = nitobi.getComponent("myCombo");
 * var list = combo.GetList();
 * @constructor
 * @param {HTMLElement} userTag
 * @param {XMLElement} xmlUserTag
 * @param {HTMLElement} unboundComboValuesTag
 * @param {nitobi.combo.Combo} comboObject The owner combobox of this list
 * @see nitobi.combo.Combo
 */
nitobi.combo.List = function (userTag, xmlUserTag, unboundComboValuesTag, comboObject){

	/**
	 * @private
	 */
	this.m_Rendered=false;
	var DEFAULTCLASSNAME="ntb-combobox-button";
	var DEFAULTWIDTH="150px";
	var DEFAULTSECTIONHEIGHTS = new Array("50px","100px","50px");
	var DEFAULTSECTIONCLASSNAMES = new Array("ntb-combobox-list-header","ntb-combobox-list-body","ntb-combobox-list-footer","ntb-combobox-list-body-table");
	var DEFAULTHIGHLIGHTCSSCLASSNAME = "ntb-combobox-list-body-table-row-highlighted";
	var DEFAULTBACKGROUNDHIGHLIGHTCOLOR = "highlight";
	var DEFAULTFOREGROUNDHIGHLIGHTCOLOR = "highlighttext";
	var DEFAULTCUSTOMHTMLDEFINITION = "";
	var DEFAULTSELECTEDROWINDEX = -1;
	var DEFAULTALLOWPAGING=comboObject.mode=="default";
	var DEFAULTOVERFLOWY = "hidden";
	var DEFAULTFuzzySearchEnabled = false;
	var DEFAULTENABLEDATABASESEARCH=comboObject.mode!="default";
	var DEFAULTPAGESIZE;
	if (comboObject.mode != "classic")
	{
		DEFAULTPAGESIZE=10;
	}
	else
	{
		DEFAULTPAGESIZE=25;
	}
	var DEFAULTONHIDEEVENT="";
	var DEFAULTONSHOWEVENT="";
	var DEFAULTONBEFORESEARCH="";
	var DEFAULTONAFTERSEARCH="";
	var DEFAULTOFFSETX=0;
	var DEFAULTOFFSETY=0;
	var ERROR_NOXML="EBA:Combo could not correctly transform XML data. Do you have the MS XML libraries installed? These are typically installed with your browser and are freely available from Microsoft.";
	var CONVERTCOMBOVALUETOCOMPRESSEDXML=
			"<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\" xmlns:eba=\"http://developer.ebusiness-apps.com\" xmlns:ntb=\"http://www.nitobi.com\" exclude-result-prefixes=\"eba ntb\">"+
			"<xsl:output method=\"xml\" version=\"4.0\" omit-xml-declaration=\"yes\" />"+
			"<xsl:template match=\"/\">" +
			"<xsl:apply-templates select=\"eba:ComboValues|ntb:ComboValues\"/>" +
			"</xsl:template>" +
			"<xsl:template match=\"/eba:ComboValues|ntb:ComboValues\">"+
			"<root>"+
			"<xsl:attribute name=\"fields\"><xsl:value-of select=\"@fields\" /></xsl:attribute>" +
			"	<xsl:apply-templates/>"+
			"</root>"+
			"</xsl:template>" +
			"<xsl:template match=\"eba:ComboValue|eba:combovalue|ntb:ComboValue|ntb:combovalue\">"+
			"	<e><xsl:for-each select=\"@*\"><xsl:attribute name=\"{name()}\"><xsl:value-of select=\".\"/></xsl:attribute></xsl:for-each></e>"+
			"</xsl:template>"+
			"</xsl:stylesheet>";
	this.SetCombo(comboObject);
	
	var ps=(userTag ? userTag.getAttribute("PageSize") : null);
	((null == ps) || ("" == ps))
		? this.SetPageSize(DEFAULTPAGESIZE)
		: this.SetPageSize(parseInt(ps));

	// list clipping logic
	// only clip if SMARTSEARCH, SMARTLIST, or FILTER
	/**
	 * @private
	 */
	this.clip = (comboObject.mode=="smartsearch" || comboObject.mode=="smartlist" || comboObject.mode=="filter");

	var clpLen = (userTag ? userTag.getAttribute("ClipLength") : null);
	((null == clpLen) || ("" == clpLen))
		? this.SetClipLength(this.GetPageSize())
		: this.SetClipLength(clpLen);

	var ds = new nitobi.combo.XmlDataSource();



	if (xmlUserTag != null)
	{
		ds.combo = comboObject;
		var x=(xmlUserTag ? xmlUserTag.getAttribute("XmlId") : "");
		ds.SetXmlId(x);
		var dataIsland = document.getElementById(x);
		if (!nitobi.browser.IE || null == dataIsland)
		{
			nitobi.Browser.ConvertXmlDataIsland(x,comboObject.GetHttpRequestMethod());
			ds.SetXmlObject(document[x], this.clip, this.clipLength);
		}
		else
			ds.SetXmlObject(dataIsland);
		// Set the page size to number of rows we receive initially.
		// Here we assume that the initial data we receive is like a page
		// get.  We don't actually do a page get because we don't want
		// to copy our initial xml datasource.
		ds.SetLastPageSize(ds.GetNumberRows());

		/// <property name="m_Dirty" type="bool" access="private" default="false" readwrite="readwrite">
		/// <summary>If this is true, this local browser xml cache is considered dirty and out of date.</summary></property>
		ds.m_Dirty=false;
	}

	this.SetXmlDataSource(ds);

	// Create this to enable GetPage.
	/**
	 * @private
	 */
	this.m_httpRequest=new nitobi.ajax.HttpRequest();
	this.m_httpRequest.responseType = "text";
	this.m_httpRequest.onRequestComplete.subscribe(this.onGetComplete, this);

	// Is this an XML Datasource or an unbound datasource.  If its unbound to the local XML
	// and defined by html, we need to create the xml object.
	/**
	 * @private
	 */
	this.unboundMode=false;
	if(!xmlUserTag)
	{
		this.unboundMode=true;
		// This is a statically defined datasource using ComboValue tags.
		var xmlObect=null;
		var unboundXml = "<eba:ComboValues fields='" + unboundComboValuesTag.getAttribute("fields") + "' xmlns:eba='http://developer.ebusiness-apps.com' xmlns:ntb='http://www.nitobi.com'>";
		// 31 refers to the end of the bad IE namespace tag.
		//unboundXml += unboundComboValuesTag.innerHTML.substr(nitobi.browser.IE ? 31 : 0) + "</eba:ComboValues>";
		if (nitobi.browser.IE)
		{
			var comboValues = unboundComboValuesTag.innerHTML.match(/<\?xml:namespace.*?\/>(.*)/);
			unboundXml += comboValues[1] + "</eba:ComboValues>";
		}
		else
		{
			unboundXml += unboundComboValuesTag.innerHTML + "</eba:ComboValues>";
		}
		
		
		
		
		
		// NOTE: we replace &nbsp; w/ %a0 here because &nbsp; is an unknown entity reference;
		// in Moz, we could properly declare the entity ref but we couldn't do this in IE;
		// also, replacing &nbsp; w/ &#160; doesn't work because when creating the DOM doc, this
		// gets converted back to &nbsp; and when we transform, the unknown entity ref comes into
		// play again and again, we could declare it in Moz but not IE
		// TODO: declaring the entity ref and leaving &nbsp; is ideal; figure it out for IE if we have time in the future
		// for now do it here via Javascript; also, we didn't do it above in the for-loop on the
		// attributes because we couldn't get the regex to recognize the nonbreaking space char; put it
		// there if we figure out
		// NOTE: need to parse out whitespace (i.e. between xml tags) like IE
		// Angle brackets (< and >) must be encoded. The HTML DOM unencodes them. Additionally, &nbsp; is not an xml entity
		// and must be converted to &#160;. Careful though, sometimes the HTML DOM converts the 160 back to nbsp. 
		// Need to parse out whitespace (i.e. between xml tags) like IE
		unboundXml = nitobi.Browser.EncodeAngleBracketsInTagAttributes(unboundXml,comboObject).replace(/&nbsp;/g,"&#160;").replace(/>\s+</g,"><");
		// Transform the html tags into regular EBA XML for the datasource.
		try
		{
			var oXSL=nitobi.xml.createXmlDoc(CONVERTCOMBOVALUETOCOMPRESSEDXML);
			tmp=nitobi.xml.createXmlDoc(unboundXml);
			xmlObject=nitobi.xml.transformToXml(tmp, oXSL);
			this.GetXmlDataSource().SetXmlObject(xmlObject);
			this.GetXmlDataSource().m_Dirty=false;
		}
		catch(err)
		{
			alert(ERROR_NOXML);
		}
	}

	/**
	 * @private
	 */
	this.m_SectionHTMLTagObjects = new Array;
	/**
	 * @private
	 */
	this.m_SectionCSSClassNames = new Array;
	/**
	 * @private
	 */
	this.m_SectionHeights = new Array;
	/**
	 * @private
	 */
	this.m_ListColumnDefinitions = new Array;

	// Get the list column definition tags.
	var child=null;
	var numColDefs=0;
	var unboundComboValues=null;
	var dataTextField = this.GetCombo().GetDataTextField();
	var tried=false;
	var unresolved=true;
	while(unresolved){
		if(dataTextField != null || tried==true){
			// The column defs have to be built from the simple DataValueField and DataTextFieldProperties
			var newListColumn = new Object;
			// Set the display field.
			newListColumn.DataFieldIndex = this.GetXmlDataSource().GetColumnIndex(dataTextField);
			newListColumn.DataValueIndex = this.GetXmlDataSource().GetColumnIndex(comboObject.GetDataValueField());
			newListColumn.HeaderLabel="";
			newListColumn.Width="100%";
			/**
			 * @private
			 */
			this.m_ListColumnDefinitions[0] = new nitobi.combo.ListColumnDefinition(newListColumn);
			unresolved=false;
		}else{
			// The ComboColumnDefinition can be in either the list tag or the combo tag.
			// Check for the list tag first, and if they are not there, check in the combo tag.
			var tagWithDefs=userTag;
			if ((null==userTag) || (0==userTag.childNodes.length))
				tagWithDefs = comboObject.m_userTag;

			// Build the list column defs based on the tags.
			var tagName=null;
			for (var i=0; i < tagWithDefs.childNodes.length; i++){
				child = tagWithDefs.childNodes[i];
				tagName = child.tagName;
				if(tagName){
					// toLowerCase comparsion to eliminate IE/Moz case differences
					// remove ntb: namespace for Moz
					tagName = tagName.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"");
					if (tagName == "combocolumndefinition"){
						/**
						 * @private
	 					 */
						this.m_ListColumnDefinitions[numColDefs] = new nitobi.combo.ListColumnDefinition(child);
						numColDefs++;
						unresolved=false;
					}
				}
			}
			tried=true;
		}
	}
	var width=(userTag ? userTag.getAttribute("Width") : null);
	((null == width) || ("" == width))
		? this.SetWidth(DEFAULTWIDTH)
		: this.SetWidth(width);

	var overflowy=(userTag ? userTag.getAttribute("Overflow-y") : null);
	/**
	 * @private
	 */
	this.m_overflowy = ((null == overflowy) || ("" == overflowy))
		? DEFAULTOVERFLOWY
		: overflowy;

	var chh=(userTag ? userTag.getAttribute("CustomHTMLHeader") : null);
	((null == chh) || ("" == chh))
		? this.SetCustomHTMLHeader("")
		: this.SetCustomHTMLHeader(chh);

	// Set the defaults for the section CSS Classnames.
	for (var i=0; i < EBAComboBoxListNumSections; i++){
		this.SetSectionCSSClassName(i, DEFAULTSECTIONCLASSNAMES[i]);
	}

	// TODO: User defined values.
	// Set the defaults for the section heights.
	for (var i=0; i <= EBAComboBoxListFooter; i++){
		this.SetSectionHeight(i, DEFAULTSECTIONHEIGHTS[i]);
	}

	// Start with the list. Do the header and the footer later. TODO.
	var height=(userTag ? userTag.getAttribute("Height") : null);
	((null == height) || ("" == height))
		? null
		: this.SetHeight(parseInt(height));

	var hccn=(userTag ? userTag.getAttribute("HighlightCSSClassName") : null);
	if ((null == hccn) || ("" == hccn)){
		this.SetHighlightCSSClassName(DEFAULTHIGHLIGHTCSSCLASSNAME);
		/**
		 * @private
		 */
		this.m_UseHighlightClass=false;
	}else{
		this.SetHighlightCSSClassName(hccn);
		/**
	 	 * @private
		 */
		this.m_UseHighlightClass=true;
	}

	var bhc=(userTag ? userTag.getAttribute("BackgroundHighlightColor") : null);
	((null == bhc) || ("" == bhc))
		? this.SetBackgroundHighlightColor(DEFAULTBACKGROUNDHIGHLIGHTCOLOR)
		: this.SetBackgroundHighlightColor(bhc);

	var ohe=(userTag ? userTag.getAttribute("OnHideEvent") : null);
	((null == ohe) || ("" == ohe))
		? this.SetOnHideEvent(DEFAULTONHIDEEVENT)
		: this.SetOnHideEvent(ohe);

	var ose=(userTag ? userTag.getAttribute("OnShowEvent") : null);
	((null == ose) || ("" == ose))
		? this.SetOnShowEvent(DEFAULTONSHOWEVENT)
		: this.SetOnShowEvent(ose);

	var onbs=(userTag ? userTag.getAttribute("OnBeforeSearchEvent") : null);
	((null == onbs) || ("" == onbs))
		? this.SetOnBeforeSearchEvent(DEFAULTONBEFORESEARCH)
		: this.SetOnBeforeSearchEvent(onbs);

	var onas=(userTag ? userTag.getAttribute("OnAfterSearchEvent") : null);
	((null == onas) || ("" == onas))
		? this.SetOnAfterSearchEvent(DEFAULTONAFTERSEARCH)
		: this.SetOnAfterSearchEvent(onas);

	var fhc=(userTag ? userTag.getAttribute("ForegroundHighlightColor") : null);
	((null == fhc) || ("" == fhc))
		? this.SetForegroundHighlightColor(DEFAULTFOREGROUNDHIGHLIGHTCOLOR)
		: this.SetForegroundHighlightColor(fhc);

	var offx=(userTag ? userTag.getAttribute("OffsetX") : null);
	((null == offx) || ("" == offx))
		? this.SetOffsetX(DEFAULTOFFSETX)
		: this.SetOffsetX(offx);

	var offy=(userTag ? userTag.getAttribute("OffsetY") : null);
	((null == offy) || ("" == offy))
		? this.SetOffsetY(DEFAULTOFFSETY)
		: this.SetOffsetY(offy);

	// Get the SelectedRowIndex out of the combo. It really belongs here,
	// but for end user side it makes more sense.
	var sri=(userTag ? userTag.parentNode.getAttribute("SelectedRowIndex") : null);
	((null == sri) || ("" == sri))
		? this.SetSelectedRowIndex(DEFAULTSELECTEDROWINDEX)
		: this.SetSelectedRowIndex(parseInt(sri));

	var chd=(userTag ? userTag.getAttribute("CustomHTMLDefinition") : null);
	((null == chd) || ("" == chd))
		? this.SetCustomHTMLDefinition(DEFAULTCUSTOMHTMLDEFINITION)
		: this.SetCustomHTMLDefinition(chd);

	var ap=(userTag ? userTag.getAttribute("AllowPaging") : null);
	((null == ap) || ("" == ap))
		? this.SetAllowPaging(DEFAULTALLOWPAGING)
		: this.SetAllowPaging(ap.toLowerCase()=="true");
		
	var fz=(userTag ? userTag.getAttribute("FuzzySearchEnabled") : null);
	((null == fz) || ("" == fz))
		? this.SetFuzzySearchEnabled(DEFAULTFuzzySearchEnabled)
		: this.SetFuzzySearchEnabled(fz.toLowerCase()=="true");

	var eds=(userTag ? userTag.getAttribute("EnableDatabaseSearch") : null);
	((null == eds) || ("" == eds))
		? this.SetEnableDatabaseSearch(this.unboundMode==false && DEFAULTENABLEDATABASESEARCH)
		: this.SetEnableDatabaseSearch(this.unboundMode==false && eds.toLowerCase()=="true");


	if(comboObject.mode=="default" && this.GetAllowPaging()==true){
		this.SetClipLength(this.GetPageSize());
		this.clip=true;
	}

	/**
	 * @private
	 */
	this.widestColumn = new Array(this.m_ListColumnDefinitions.length);
	for (var i=0;i<this.widestColumn.length;i++)
	{
		this.widestColumn[i]=0;
	}

	// We're not yet doing any database lookups.
	this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_NONE);

	var durl=(userTag ? userTag.getAttribute("DatasourceUrl") : null);
	if((null == durl) || ("" == durl) || this.unboundMode==true){
		this.SetDatasourceUrl(document.location.toString());
		this.SetEnableDatabaseSearch(false);
		this.unboundMode=true;
	}else{
		this.SetDatasourceUrl(durl);
		this.SetEnableDatabaseSearch(true);
	}

	/**
	 * @private
	 */
	this.m_httpRequestReady=true;
	this.SetNumPagesLoaded(0);
	/**
	 * @private
	 */
	this.m_userTag = userTag;
}

/**
 * Actively unloads the object, and destroys owned objects.
 * @private
 */
nitobi.combo.List.prototype.Unload = function()
{
	if (this.IF)
	{
		this.IF.Unload();
		delete this.IF;
	}
	_EBAMemScrub(this);
}


/**
 * Sets the length of clipping used in SmartList, SmartSearch and Filter modes.
 * When the combo is in SmartList, SmartSearch or Filter mode, any page of records is 
 * reduced in size to equal ClipLength. This setting is independent of PageSize.
 * @param {Number} clpLength The size to reduce an XML page once it is returned from the server
 * @see #SetPageSize
 */
nitobi.combo.List.prototype.SetClipLength = function(clpLength)
{
	this.clipLength = clpLength
}

/**
 * The HTML tag that is bound to this object. Only available after the combo has inserted the tags and called initialize.
 * @type HTMLElement
 * @private
 */
nitobi.combo.List.prototype.GetHTMLTagObject = function()
{
	this.Render();
	return this.m_HTMLTagObject;
}

/**
 * The HTML tag that is bound to this object. Only available after the combo has inserted the tags and called initialize.
 * @param {HTMLElement} HTMLTagObject The HTML element to associate with the list
 * @private
 */
nitobi.combo.List.prototype.SetHTMLTagObject = function(HTMLTagObject)
{
	this.m_HTMLTagObject = HTMLTagObject;
}

/**
 * Returns the CSS style applied to the row when the user highlights it.
 * Use BackgroundHighlightColor for better performance. The default CSS class that all
 * combos use is ComboBoxListBodyTableRowHighlighted, which is stored in the CSS file. If you want to 
 * modify all combos on the page, you can modify this class. If you only want to affect one combo
 * you can copy this class and then set HighlightCSSClassName to the copy.
 * @type String
 * @see #SetHighlightCSSClassName
 * @see #GetBackgroundHighlightColor
 */
nitobi.combo.List.prototype.GetHighlightCSSClassName = function()
{
	return this.m_HighlightCSSClassName;
}

/**
 * Sets the CSS style applied to the row when the user highlights it.
 * Use BackgroundHighlightColor for better performance. The default CSS class that all
 * combos use is ComboBoxListBodyTableRowHighlighted, which is stored in the CSS file. If you want to 
 * modify all combos on the page, you can modify this class. If you only want to affect one combo
 * you can copy this class and then set HighlightCSSClassName to the copy.
 * @param {String} HighlightCSSClassName The name of the custom CSS class.  Do not include the dot 
 * @see #GetHighlightCSSClassName
 * @see #SetBackgroundHighlightColor
 */
nitobi.combo.List.prototype.SetHighlightCSSClassName = function(HighlightCSSClassName)
{
	this.m_HighlightCSSClassName = HighlightCSSClassName;
}

/**
 * Returns all {@link nitobi.combo.ListColumnDefinition} that define how the list columns look and behave.
 * These are not used if CustomHTMLDefinition is used.
 * <p>
 * So, if our List declaration looked like this:
 * </p>
 * <pre class="code">
 * &lt;ntb:ComboList Width="370px" Height="205px" DatasourceUrl="get.asp" PageSize="11"&gt;
 * 	&lt;ntb:ComboColumnDefinition Width="130px" HeaderLabel="Customer List" DataFieldIndex=0&gt;&lt;/ntb:ComboColumnDefinition&gt;
 * 	&lt;ntb:ComboColumnDefinition Width="200px" DataFieldIndex=1&gt;&lt;/ntb:ComboColumnDefinition&gt;
 * &lt;/ntb:ComboList&gt;
 * </pre>
 * <p>
 * Then,
 * </p>
 * <pre class="code">
 * var list = nitobi.getComponent('combo1').GetList();
 * list.GetListColumnDefinitions()[0].GetWidth();  // Is "130px"
 * </pre>
 * @type Array
 * @see #GetCustomHTMLDefinition
 */
nitobi.combo.List.prototype.GetListColumnDefinitions = function()
{
	return this.m_ListColumnDefinitions;
}

/**
 * The objects that define how the list columns look and behave. 
 * @param {Array} ListColumnDefinitions An array of ListColumnDefinition objects
 * @private
 */
nitobi.combo.List.prototype.SetListColumnDefinitions = function(ListColumnDefinitions)
{
	this.m_ListColumnDefinitions = ListColumnDefinitions;
}

/**
 * Returns a custom HTML definition for each row.  DataTextFields are specified inside the definition as such: ${0} for field 0, ${1} for
 * field 1 and so on. E.g. '&lt;b&gt;${0}&lt;/b&gt;'.
 * You can have more records in your datasource than are displayed using this property. This enables
 * you to hide key values from the user, but still have them returned once they make a selection. 
 * If this is used, the ListColumnDefinitions are ignored. If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new CustomHTMLDefinition,
 * but already rendered records will not change. If you want to re-render the list, you will have to first
 * use {@link #Clear} and the {@link nitobi.combo.XmlDataSource#Clear} methods
 * @type String
 * @see #SetHTMLSuffix
 * @see #SetHTMLPrefix
 * @see #SetCustomHTMLDefinition
 * @see nitobi.combo.ListColumnDefinition#SetHTMLSuffix
 * @see nitobi.combo.ListColumnDefinition#GetHTMLSuffix
 */
nitobi.combo.List.prototype.GetCustomHTMLDefinition = function()
{
	return this.m_CustomHTMLDefinition;
}

/**
 * Sets a custom HTML definition for each row.  DataTextFields are specified inside the definition as such: ${0} for field 0, ${1} for
 * field 1 and so on. E.g. '&lt;b&gt;${0}&lt;/b&gt;'.
 * You can have more records in your datasource than are displayed using this property. This enables
 * you to hide key values from the user, but still have them returned once they make a selection. 
 * If this is used, the ListColumnDefinitions are ignored. If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new CustomHTMLDefinition,
 * but already rendered records will not change. If you want to re-render the list, you will have to first
 * use {@link #Clear} and the {@link nitobi.combo.XmlDataSource#Clear} methods
 * @param {String} CustomHTMLDefinition The custom HTML definition used to records records in the list
 * @see #SetHTMLSuffix
 * @see #SetHTMLPrefix
 * @see #GetCustomHTMLDefinition
 */
nitobi.combo.List.prototype.SetCustomHTMLDefinition = function(CustomHTMLDefinition)
{
	this.m_CustomHTMLDefinition = CustomHTMLDefinition;
}

/**
 * Returns the custom HTML definition for the list header. If this is used,
 * the HeaderLabels from the ListColumnDefinition tag will not be used.
 * This is the text display as a header at the top of the list and is a simple HTML string.  It applies to all columns.
 * @type String
 * @see nitobi.combo.ListColumnDefinition#GetHeaderLabel
 */
nitobi.combo.List.prototype.GetCustomHTMLHeader = function()
{
	return this.m_CustomHTMLHeader;
}

/**
 * Specify a custom HTML definition for the list header. If this is used,
 * the HeaderLabels from the ListColumnDefinitions are not used.
 * @param {String} CustomHTMLHeader The value of the property you want to set.
 * @private
 */
nitobi.combo.List.prototype.SetCustomHTMLHeader = function(CustomHTMLHeader)
{
	this.m_CustomHTMLHeader = CustomHTMLHeader;
}

/**
 * Returns the parent combo object.
 * This returns a handle to the Combo that owns the list.  
 * This is equivalent to the statement: <code>$ntb("ComboID").jsObject</code>.
 * @type nitobi.combo.Combo
 */  
nitobi.combo.List.prototype.GetCombo = function()
{
	return this.m_Combo;
}

/**
 * @private
 */
nitobi.combo.List.prototype.SetCombo = function(Combo)
{
	this.m_Combo = Combo;
}

/**
 * Returns the list's XmlDataSource object
 * Returns a handle to the XmlDataSource object that the list is bound to.  
 * The XmlDataSource is in turn bound to the server's datasource.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * var xmlDataSource = list.GetXmlDataSource();
 * var xmlDoc = xmlDataSource.GetXmlObject();
 * // Gives us the xml node with xk equal to 47858
 * var node = xmlDoc.selectSingleNode('//e[&amp;xk=47858]');
 * node.setAttribute('a', 'London Calling');
 * @type nitobi.combo.XmlDataSource
 */
nitobi.combo.List.prototype.GetXmlDataSource = function()
{
	return this.m_XmlDataSource;
}

/**
 * Sets the xml datasource
 * Returns a handle to the XmlDataSource object that the list is bound to.  The XmlDataSource is in turn bound to the server's datasource.
 * @param {nitobi.combo.XmlDataSource} XmlDataSource The xml datasource for the list
 * @private
 */
nitobi.combo.List.prototype.SetXmlDataSource = function(XmlDataSource)
{
	this.m_XmlDataSource = XmlDataSource;
}

/**
 * Returns the width of the list in pixels or percent, e.g., 100px or 100% as specified
 * in the Width attribute of the List element.
 * This is not the same as the combo width.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * if (list.GetWidth() != list.GetActualPixelWidth())
 * {
 * 	alert('They are not the same');
 * }
 * @type String
 * @see nitobi.combo.Combo#GetWidth
 * @see #SetWidth
 * @see #GetActualPixelWidth
 */
nitobi.combo.List.prototype.GetWidth = function()
{
	return this.m_Width;
}

/**
 * Sets the width of the list in either pixels or percent, e.g., 100px or 100%.
 * This is not the same as the combo width.
 * @param {String} Width A string determining the width of the list in px or %
 * @see nitobi.combo.Combo#GetWidth
 * @see #GetWidth
 */
nitobi.combo.List.prototype.SetWidth = function(Width)
{
	this.m_Width = Width;
	if(this.m_Rendered)
	{
		this.GetHTMLTagObject().style.width = this.GetDesiredPixelWidth();
	
		// Set the inner sections to the same width except the table
		for(var i=0; i <= EBAComboBoxListFooter; i++)
		{
			if (i != EBAComboBoxListBodyTable)
			{
				var section = this.GetSectionHTMLTagObject(i);
				if (section != null)
				{
					section.style.width = this.GetDesiredPixelWidth();
				}
			}
		}
	
		this.GenerateCss();
	}
}


/**
 * Calculates the desired with of the list. The user may specify % or px, and
 * we always want it in px.
 * @private
 */
nitobi.combo.List.prototype.GetDesiredPixelWidth = function()
{
	var combo = this.GetCombo();
	var container = document.getElementById(combo.GetId());
	var containerWidth = nitobi.html.getWidth(container);
	var width = this.GetWidth();
	if (nitobi.Browser.GetMeasurementUnitType(width) == "%")
	{
		var w = (combo.GetWidth()==null?combo.GetTextBox().GetWidth():combo.GetWidth());
		var adjust = 1 / (parseInt(w)/100);
		var width = parseInt(width)/100;

		return(Math.floor(containerWidth * adjust * width - 2)+"px");
	}
	else
	{
		return width;
	}
}


/**
 * Returns the rendered width of the List.
 * @type Number
 */
nitobi.combo.List.prototype.GetActualPixelWidth = function()
{
	var tag = this.GetHTMLTagObject();
	if (null == tag)
	{
		return this.GetDesiredPixelWidth();
	}
	else
	{
		return nitobi.Browser.GetElementWidth(tag);
	}
}

/**
 * Returns the name of a custom CSS class to associate with the entire list.
 * If this is left as an empty string, then the 'ComboBoxList' class is used.  Refer to the CSS file
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @type String
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetCSSClassName
 */
nitobi.combo.List.prototype.GetCSSClassName = function()
{
	return (null == this.m_HTMLTagObject ? this.m_CSSClassName : this.GetHTMLTagObject().className);
}

/**
 * Sets the name of a custom CSS class to associate with the entire list. 
 * If this is left as an empty string, then the 'ComboBoxList' class is used.  Refer to the CSS file
 * for details on this class, and which CSS attributes you must supply to use a custom class.  You can
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @param {String} CSSClassName The CSS class to associate with the list.  Do not include the dot in the class name.
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 */
nitobi.combo.List.prototype.SetCSSClassName = function(CSSClassName)
{
	if(null==this.m_HTMLTagObject)
		this.m_CSSClassName = CSSClassName;
	else
		this.GetHTMLTagObject().className = CSSClassName;
}

/**
 * Get or set a section of the list. Valid list sections are:
 * EBAComboBoxListHeader, EBAComboBoxListBody, EBAComboBoxListBodyTable, EBAComboBoxListFooter.
 * @param {Number} Section The section.
 * @private
 */
nitobi.combo.List.prototype.GetSectionHTMLTagObject = function(Section)
{
	this.Render();
	// TODO: there was previously the following assert ... not sure why
	// Section != EBAComboBoxListBodyTable
	return this.m_SectionHTMLTagObjects[Section];
}

nitobi.combo.List.prototype.SetSectionHTMLTagObject = List_SetSectionHTMLTagObject;
/**
 * Get or set a section of the list. Valid list sections are:
 * EBAComboBoxListHeader, EBAComboBoxListBody, EBAComboBoxListBodyTable, EBAComboBoxListFooter.
 * @param {Number} Section The section.
 * @private
 */
function List_SetSectionHTMLTagObject(Section, SectionHTMLTagObject)
{
	this.m_SectionHTMLTagObjects[Section] = SectionHTMLTagObject;
}

/**
 * Returns the name of the class that defines the section styles.
 * When the list is rendered it is broken up into distinct sections.
 * The sections are: ComboBoxListHeader, ComboBoxListBody, ComboBoxListFooter, 
 * and ComboBoxListBodyTable. Refer to the CSS file for details on these classes, 
 * and which CSS attributes you must supply to use a custom class.  You can
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @param {Number} Section The section name.  This is a constant integer, not a string. 
 * Valid section names are EBAComboBoxListHeader, EBAComboBoxListBody, EBAComboBoxListBodyTable, EBAComboBoxListFooter
 * @type String
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 */
nitobi.combo.List.prototype.GetSectionCSSClassName = function(Section)
{
	return (null == this.m_HTMLTagObject ? this.m_SectionCSSClassNames[Section] : this.GetSectionHTMLTagObject(Section).className);
}

/**
 * Sets the name of the class that defines the section styles.
 * When the list is rendered it is broken up into distinct sections. This function modifies how those sections are drawn.
 * If this function is not used, then the default classes are used. They are:
 * ComboBoxListHeader, ComboBoxListBody, ComboBoxListFooter, and ComboBoxListBodyTable. Refer to the CSS file
 * for details on these classes, and which CSS attributes you must supply to use a custom class.  You can
 * include a custom class by using the HTML style tags or by using a stylesheet. 
 * @example
 * var list = nitobi.getComponent('myCombo').GetList();
 * list.SetSectionCSSClassName(EBAComboBoxListHeader, newHeaderCssClass);
 * @param {Number} Section The section name.  This is a constant integer, not a string. Valid section names are EBAComboBoxListHeader, EBAComboBoxListBody, EBAComboBoxListBodyTable, EBAComboBoxListFooter
 * @param {String} SectionCSSClassName The custom CSS class name for the section. Do not include the dot
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see #SetCSSClassName
 * @see nitobi.combo.TextBox#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 */
nitobi.combo.List.prototype.SetSectionCSSClassName = function(Section, SectionCSSClassName)
{
	if(null==this.m_HTMLTagObject)
		this.m_SectionCSSClassNames[Section]=SectionCSSClassName;
	else
		this.GetSectionHTMLTagObject(Section).className = SectionCSSClassName;
}

/**
 * Returns the height of one of the list sections.
 * When the list is rendered it is broken up into distinct sections.
 * The sections are: ComboBoxListHeader, ComboBoxListBody, ComboBoxListFooter, 
 * and ComboBoxListBodyTable.  For certain modes, not all sections of the list
 * will be drawn (e.g. no header or footer in smartsearch mode).  In these
 * cases where the section doesn't exist, null will be returned.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * if (list.GetSectionHeight(EBAComboBoxList) == list.GetActualHeight())
 * {
 * 	alert('They are the same!');
 * }
 * @param {Number} Section The section name.  This is a constant integer, not a string. 
 * Valid section names are EBAComboBoxListHeader, EBAComboBoxListBody, 
 * EBAComboBoxListBodyTable, EBAComboBoxListFooter
 * @type Number
 * @see #SetSectionHeight
 * @see #SetSectionCSSClassName
 */ 
nitobi.combo.List.prototype.GetSectionHeight = function(Section)
{
	if (this.m_HTMLTagObject == null)
	{
		return parseInt(this.m_SectionHeights[Section]);
	}
	else
	{
		// The list has display set to none so we can't get the dimensions
		// of any list section unless we change that.
		var estyle = this.m_HTMLTagObject.style;
		var top = estyle.top;
		var display = estyle.display;
		var position = estyle.position;
		var visibility = estyle.visibility;
		if (estyle.display=="none" || estyle.visibility!="visible")
		{
			estyle.position = "absolute";
			estyle.top = "-1000px";
			estyle.display="inline";
		}
		var height = null;
		if (this.m_SectionHTMLTagObjects[Section] != null)
		{
			height = nitobi.html.getHeight(this.m_SectionHTMLTagObjects[Section]);
		}
		
		if (estyle.display=="inline")
		{
			estyle.position = position;
			estyle.display=display;	
			estyle.top = top;
		}
		return height;
	}
}

/**
 * Sets the height of one of the list sections.
 * When the list is rendered it is broken up into distinct sections:  Header, Body, Table, Footer.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * list.SetSectionHeight(EBAComboBoxListBody, parseInt("400px"));
 * @param {Number} Section The section name.  This is a constant integer, not a string. Valid section names are EBAComboBoxListHeader, EBAComboBoxListBody, EBAComboBoxListBodyTable, EBAComboBoxListFooter
 * @param {Number} SectionHeight The height of the section
 * @see #GetSectionHeight
 * @see #SetSectionCSSClassName
 */
nitobi.combo.List.prototype.SetSectionHeight = function(Section, SectionHeight)
{
	if(null==this.m_HTMLTagObject)
		this.m_SectionHeights[Section] = SectionHeight;
	else
		this.GetSectionHTMLTagObject(Section).style.height=SectionHeight;
}

/**
 * Returns the index of the selected row number.
 * This is equivalent to {@link nitobi.combo.Combo#GetSelectedRowIndex}.  The index of the selected row is set when the user 
 * makes a selection from the list.
 * If no selection is made or the user types a custom value in the textbox, then this value is -1. The selected
 * row index also corresponds to the same index of the selected values row in the XmlDataSource. Note: when 
 * a row is selected, this is only one of two properties set, SelectedRowIndex, and SelectedRowValues. To set a 
 * selected row manually, use {@link #SetSelectedRow}. 
 * @type Number
 */
nitobi.combo.List.prototype.GetSelectedRowIndex = function()
{
	if(null==this.m_HTMLTagObject)
		return parseInt(this.m_SelectedRowIndex);
	else
		return parseInt(document.getElementById(this.GetCombo().GetId() + "SelectedRowIndex").value);
}

/**
 * The index of the selected row is set when the user makes a selection from the list.
 * If no selection is made or the user types a custom value in the textbox, then this value is -1. The selected
 * row index also corresponds to the same index of the selected values row in the XmlDataSource. Note: when 
 * a row is selected, this is only one of two properties set, SelectedRowIndex, and SelectedRowValues. To set a 
 * selected row manually, use List.SetSelectedRow.
 * @param {Number} SelectedRowIndex The index of the selected row. Indexed from 0. -1 if no row is selected.
 * @private
 */
nitobi.combo.List.prototype.SetSelectedRowIndex = function(SelectedRowIndex)
{
	if(null==this.m_HTMLTagObject)
		this.m_SelectedRowIndex = SelectedRowIndex;
	else
		document.getElementById(this.GetCombo().GetId() + "SelectedRowIndex").value = SelectedRowIndex;
}

/**
 * Returns true if paging is allowed, false otherwise.
 * Only classic mode supports paging.  If you enable paging, the gethandler attached to the 
 * datasource must be setup to deliver data one page at a time. See the tutorials for detailed information.
 * @type Boolean
 * @see #GetPageSize
 * @see #SetAllowPaging
 */ 
nitobi.combo.List.prototype.GetAllowPaging = function()
{
	return this.m_AllowPaging;
}

/**
 * Sets whether or not paging is allowed.  If set to true, the list draws a paging button that lets the user retrieve one page of data at a time. 
 * You must also set PageSize if you want to use this feature.
 * Only classic mode supports paging.  If you enable paging, the gethandler attached to the 
 * datasource must be setup to deliver data one page at a time. See the tutorials for detailed information.
 * @param {Boolean} AllowPaging If set to true, the list draws a paging button that lets the user retrieve one page of data at a time. 
 * You must also set PageSize if you want to use this feature.
 * @see #SetPageSize
 * @see #GetAllowPaging
 */
nitobi.combo.List.prototype.SetAllowPaging = function(AllowPaging)
{
	if (this.m_HTMLTagObject != null)
	{
		if (AllowPaging)
		{
			this.ShowFooter();
		}
		else
		{
			this.HideFooter();
		}
	}
	this.m_AllowPaging = AllowPaging;
}

/**
 * Returns true if fuzzy search is enabled, false otherwise
 * When the combo requests data from the server with a search substring, the search type
 * depends on the mode. Smartsearch and smartlist modes perform substring matching, while other 
 * modes perform prefix matching.  When the data returns to the client, the combo
 * performs a local search in order to highlight search strings, and select the correct default row. 
 * If it cannot match the string on the client-side and FuzzySearch is not enabled, then the behaviour
 * is unpredictable.  If FuzzySearch is enabled, then no client side matching is attempted, then
 * combo simply displays the search results.
 * @type Boolean
 * @see #SetFuzzySearchEnabled
 */
nitobi.combo.List.prototype.IsFuzzySearchEnabled = function()
{
	return this.m_FuzzySearchEnabled;
}

/**
 * Sets whether or not to allow fuzzy searching.  If set to true, the get handler can return anything from a search result, even if it does not match
 * the search type for the mode.
 * When the combo requests data from the server with a search substring, the search type
 * depends on the mode. Smartsearch and smartlist modes perform substring matching, while other 
 * modes perform prefix matching.  When the data returns to the client, the combo
 * performs a local search in order to highlight search strings, and select the correct default row. 
 * If it cannot match the string on the client-side and FuzzySearch is not enabled, then the behaviour
 * is unpredictable.  If FuzzySearch is enabled, then no client side matching is attempted, then
 * combo simply displays the search results.
 * @param {Boolean} FuzzySearchEnabled true in order to enable a fuzzy search and false otherwise
 * @see #GetFuzzySearchEnabled
 */
nitobi.combo.List.prototype.SetFuzzySearchEnabled = function(FuzzySearchEnabled)
{
	this.m_FuzzySearchEnabled = FuzzySearchEnabled;
}

/**
 * Returns the number of records retrieved at a time from the server.
 * If clipping is turned on (according to the mode used),
 * then the value returned may not actually correspond with the displayed pagesize
 * because the record set that is returned from the server is clipped according 
 * to the clip length.
 * <pre class="code">
 * &lt;ntb:ComboList Width="370px" Height="205px" DatasourceUrl="get.asp" PageSize="11" ClipLength="5"&gt;
 * </pre>
 * <p>
 * consider the following:
 * </p>
 * <pre class="code">
 * var list = nitobi.getComponent('combo1').GetList();
 * list.GetPageSize();  // Will be 11
 * </pre>
 * @type Number
 * @see #SetClipLength
 * @see #SetPageSize
 * @see #GetAllowPaging
 */
nitobi.combo.List.prototype.GetPageSize = function()
{
	return this.m_PageSize;
}

/**
 * Sets the number of records retrieved at a time from the server.
 * Only used if AllowPaging is set to true.  If clipping is turned on (according to the mode used),
 * then the record set that is returned from the server is clipped according to the clip length. 
 * @param {Number} PageSize The number of records returned at one time from the server
 * @see #SetClipLength
 * @see #GetPageSize
 * @see #SetAllowPaging
 */
nitobi.combo.List.prototype.SetPageSize = function(PageSize)
{
	this.m_PageSize = PageSize;
}

/** 
 * The number of pages currently loaded.
 * @type Number
 * @private
 */
nitobi.combo.List.prototype.GetNumPagesLoaded = function()
{
	return this.m_NumPagesLoaded;
}

/**
 * The number of pages currently loaded.
 * @param {Number} NumPagesLoaded The value of the property you want to set.
 * @private
 */
nitobi.combo.List.prototype.SetNumPagesLoaded = function(NumPagesLoaded)
{
	this.m_NumPagesLoaded = NumPagesLoaded;
}

/**
 * Returns the row that is currently active.
 * @type HTMLNode
 * @private
 */
nitobi.combo.List.prototype.GetActiveRow = function()
{
	return this.m_ActiveRow;
}

/**
 * The row that is currently active.
 * @type HTMLNode
 * @private
 */
nitobi.combo.List.prototype.SetActiveRow = function(ActiveRow)
{
	var containerTable;
	if(null != this.m_ActiveRow){
		containerTable = document.getElementById("ContainingTableFor"+this.m_ActiveRow.id);
		if(this.m_UseHighlightClass)
			containerTable.className = this.m_OriginalRowClass;
		else{
			containerTable.style.backgroundColor = this.m_OriginalBackgroundHighlightColor;
			containerTable.style.color = this.m_OriginalForegroundHighlightColor;

		}
		var colDefs = this.GetListColumnDefinitions();
		for(var i=0,n=colDefs.length;i<n;i++){
			var containerSpan = document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id+"_"+i);
			if(containerSpan!=null){
				containerSpan.style.color=containerSpan.savedColor;
				containerSpan.style.backgroundColor=containerSpan.savedBackgroundColor;
			}
		}
	}
	this.m_ActiveRow = ActiveRow;
	if(null != ActiveRow)
	{
		// In compact mode, we set the selectedrow values all the time.
		// This is becuase there is no list for the user to make a
		// selection. This may not be the best place to do this,
		// but onblur doesn't fire if you immediately click the submit button.
		if ("compact" == this.GetCombo().mode && ActiveRow != null)
		{
				var rowNum = this.GetRowIndex(ActiveRow);
				this.SetSelectedRow(rowNum);
		}

		containerTable = document.getElementById("ContainingTableFor"+ActiveRow.id);
		containerSpan = document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id);

		if(this.m_UseHighlightClass){
			this.m_OriginalRowClass = containerTable.className;
			containerTable.className = this.GetHighlightCSSClassName();
		}else{
			this.m_OriginalBackgroundHighlightColor = containerTable.style.backgroundColor;
			this.m_OriginalForegroundHighlightColor = containerTable.style.color;
			containerTable.style.backgroundColor = this.m_BackgroundHighlightColor;
			containerTable.style.color = this.m_ForegroundHighlightColor;
		}
		var colDefs = this.GetListColumnDefinitions();
		for(var i=0,n=colDefs.length;i<n;i++){
			var containerSpan = document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id+"_"+i);
			if(containerSpan!=null){
				containerSpan.savedColor=containerSpan.style.color;
				containerSpan.savedBackgroundColor=containerSpan.style.backgroundColor;
				containerSpan.style.color=containerTable.style.color;
				containerSpan.style.backgroundColor=containerTable.style.backgroundColor;
			}
		}
	}
}

/**
 * The values the user selects when they click a row.
 * @type Array
 * @private
 */
nitobi.combo.List.prototype.GetSelectedRowValues = function()
{
	var rowValues = new Array;
	for (var i=0; i < this.GetXmlDataSource().GetNumberColumns(); i++)
		rowValues[i] = document.getElementById(this.GetCombo().GetId() + "SelectedValue" + i).value;
	return rowValues;
}

/** 
 * The values the user selects when they click a row.
 * @param {HTMLNode} [Row] The row object. Values will be extracted from here.
 * @private
 */
nitobi.combo.List.prototype.SetSelectedRowValues = function(SelectedRowValues, Row)
{
	this.m_SelectedRowValues = SelectedRowValues;
	var comboId = this.GetCombo().GetId();
	var numCols = this.GetXmlDataSource().GetNumberColumns();
	if ((null==SelectedRowValues) && (null==Row)){
		// Empty the values.
		for(var i=0;i<numCols;i++)
			document.getElementById(comboId + "SelectedValue" + i).value="";
	}else{
		if (null==Row){
			// Argument is an array. Populate hidden fields.
			for(var i=0;i<numCols;i++)
				document.getElementById(comboId + "SelectedValue" + i).value=SelectedRowValues[i];
		}else{
			// Argument is a row object.
			var uniqueId = this.GetCombo().GetUniqueId();
			// Get the row number.
			var rowNum = this.GetRowIndex(Row);
			// Get the values from the datasource and call this function again.
			var values = this.GetXmlDataSource().GetRow(rowNum);
			this.SetSelectedRowValues(values, null);
		}
	}
}

/**
 * Enables searching the database. If searching the local cache fails, the server is asked to get the records the user is looking for.
 * @type Boolean
 * @private
 */
nitobi.combo.List.prototype.GetEnableDatabaseSearch = function()
{
	return this.m_EnableDatabaseSearch;
}

/**
 * Sets whether or not to search the database.  If searching the local cache fails, the server
 * is asked to get the records the user is looking for.
 * @param {Boolean} EnableDatabaseSearch true if you want to enabled database searching, false otherwise
 * @deprecated enabledatabasesearch is no longer a valid attribute on ComboBox
 */
nitobi.combo.List.prototype.SetEnableDatabaseSearch = function(EnableDatabaseSearch)
{
	this.m_EnableDatabaseSearch = EnableDatabaseSearch;
}

/**
 * Returns the HTML in the footer.
 * @private
 */
nitobi.combo.List.prototype.GetFooterText = function()
{
	if(null==this.m_HTMLTagObject)
		return this.m_FooterText;
	else{
		var footerButton = document.getElementById("EBAComboBoxListFooterPageNextButton" + this.GetCombo().GetUniqueId());
		return (null!=footerButton ? footerButton.innerHTML : "");
	}
}

/**
 * Sets the HTML in the footer
 * @param {String} FooterText The HTML in the footer
 * @private
 */
nitobi.combo.List.prototype.SetFooterText = function(FooterText)
{
	if(null==this.m_HTMLTagObject)
		this.m_FooterText = FooterText;
	else{
		var footerButton = this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
		if(null!=footerButton){
			footerButton = document.getElementById("EBAComboBoxListFooterPageNextButton" + this.GetCombo().GetUniqueId());
			if(null!=footerButton)
				footerButton.innerHTML=FooterText;
		}
	}
}

/**
 * Indicates what the status is for the wait on the db lookup. The Search function
 * will only do a lookup until after the user has paused typing. Valid values for
 * this property are: EBADatabaseSearchTimeoutStatus_WAIT,
 * EBADatabaseSearchTimeoutStatus_EXPIRED,
 * EBADatabaseSearchTimeoutStatus_NONE.
 * @type Number
 * @private
 */
nitobi.combo.List.prototype.GetDatabaseSearchTimeoutStatus = function()
{
	return this.m_DatabaseSearchTimeoutStatus;
}

/**
 * Indicates what the status is for the wait on the db lookup. The Search function
 * will only do a lookup until after the user has paused typing. Valid values for
 * this property are: EBADatabaseSearchTimeoutStatus_WAIT,
 * EBADatabaseSearchTimeoutStatus_EXPIRED,
 * EBADatabaseSearchTimeoutStatus_NONE.
 * @param {Number} DatabaseSearchTimeoutStatus The value of the property you want to set.
 * @private
 */
nitobi.combo.List.prototype.SetDatabaseSearchTimeoutStatus = function(DatabaseSearchTimeoutStatus)
{
	this.m_DatabaseSearchTimeoutStatus = DatabaseSearchTimeoutStatus;
}

/**
 * The id returned by window.setTimeout.
 * @type String
 * @private
 */
nitobi.combo.List.prototype.GetDatabaseSearchTimeoutId = function()
{
	return this.m_DatabaseSearchTimeoutId;
}

/**
 * The id returned by window.setTimeout.
 * @param {String} DatabaseSearchTimeoutId The value of the property you want to set.
 * @private
 */
nitobi.combo.List.prototype.SetDatabaseSearchTimeoutId = function(DatabaseSearchTimeoutId)
{
		this.m_DatabaseSearchTimeoutId = DatabaseSearchTimeoutId;
}

/**
 * Returns the height of the list body. This must be an HTML measurement, e.g., 100px.
 * The list body is the list excluding headers and footers.  This is equivalent to GetSectionHeight(EBAComboBoxListBody); 
 * To get the height of the entire list use GetActualPixelHeight.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * var bodyHeight = list.GetHeight();  // A string like "205px"
 * var listHeight = list.GetActualPixelHeight();  // A number like 250
 * if (parseInt(bodyHeight) != listHeight)
 * {
 * 	alert('They are not equal!');
 * }
 * @type String
 * @see #GetSectionHeight
 * @see #SetHeight
 * @see #GetActualPixelHeight
 */
nitobi.combo.List.prototype.GetHeight = function()
{
	return this.GetSectionHeight(EBAComboBoxListBody);
}

/**
 * Sets the height of the list body. This must be an HTML measurement, e.g., 100px.
 * The list body is the list excluding headers and footers.  This is equivalent to GetSectionHeight(EBAComboBoxListBody); 
 * To get the height of the entire list use GetActualPixelHeight.
 * @param {String} Height The height of the list body in HTML units.
 * @see #SetSectionHeight
 * @see #GetHeight
 */
nitobi.combo.List.prototype.SetHeight = function(Height)
{
	this.SetSectionHeight(EBAComboBoxListBody, parseInt(Height));
}

/**
 * Returns the combined heights of the list's header, body, and footer.
 * @type Number
 */
nitobi.combo.List.prototype.GetActualHeight = function()
{
	var uid = this.GetCombo().GetUniqueId();
	var tag = this.GetHTMLTagObject();
	var height = nitobi.Browser.GetElementHeight(tag);

	return height;
}

/**
 * Returns the combined heights of the list's header, body, and footer.
 * @type Number
 * @private
 */
nitobi.combo.List.prototype.GetActualPixelHeight = nitobi.combo.List.prototype.GetActualHeight;

/**
 * Returns the HTML color that the background of a row changes to when highlighted, e.g., #FFFFFF or red, etc.
 * You can also use HighlightCSSClassName for more control but setting only the color yields better performance.  The default is 'highlight'.
 * @type String
 * @see #GetHighlightCSSClassName
 * @see #SetBackgroundHighlightColor
 * @see #SetForegroundHighlightColor
 */
nitobi.combo.List.prototype.GetBackgroundHighlightColor = function()
{
	return this.m_BackgroundHighlightColor;
}

/**
 * Sets the HTML color that the background of a row changes to when highlighted, e.g., #FFFFFF or red, etc.
 * You can also use HighlightCSSClassName for more control but setting only the color yields better performance.  The default is 'highlight'.
 * @param {String} BackgroundHighlightColor An HTML color
 * @see #SetHighlightCSSClassName
 * @see #GetBackgroundHighlightColor
 * @see #GetForegroundHighlightColor
 */
nitobi.combo.List.prototype.SetBackgroundHighlightColor = function(BackgroundHighlightColor)
{
	this.m_BackgroundHighlightColor = BackgroundHighlightColor;
}

/**
 * Returns the HTML color that the foreground (text) of a row changes to when highlighted, e.g., #FFFFFF or red, etc.
 * You can also use HighlightCSSClassName for more control but setting only the color yields better performance.  The default is 'highlight'.
 * @type String
 * @see #GetHighlightCSSClassName
 * @see #SetBackgroundHighlightColor
 * @see #SetForegroundHighlightColor
 */
nitobi.combo.List.prototype.GetForegroundHighlightColor = function()
{
	return this.m_ForegroundHighlightColor;
}

/**
 * Sets the HTML color that the foreground (text) of a row changes to when highlighted, e.g., #FFFFFF or red, etc.
 * You can also use HighlightCSSClassName for more control but setting only the color yields better performance.  The default is 'highlight'.
 * @param {String} ForegroundHighlightColor An HTML color
 * @see #SetHighlightCSSClassName
 * @see #GetBackgroundHighlightColor
 * @see #GetForegroundHighlightColor
 */
nitobi.combo.List.prototype.SetForegroundHighlightColor = function(ForegroundHighlightColor)
{
	this.m_ForegroundHighlightColor = ForegroundHighlightColor;
}

/**
 * Returns the URL to a page that returns data from a datasource. 
 * This is used for populating the ComboBox as well as for paging and lookup.  When the combo requires a page of data, it calls this URL and gives
 * it the following arguments:
 * <ul>
 * <li>StartingRecordIndex - The next record in the data subset that the combo wants.</li>
 * <li>PageSize - Size of the page.</li>
 * <li>SearchSubstring - [Optional] The string the user is looking for.</li>
 * <li>ComboId - The Id of the combo making the request.</li>
 * <li>LastString - The last string searched for.</li></ul>
 * You can use this in conjunction with List.GetPage to add records to the combo.
 * @type String
 * @see #GetPageSize
 * @see #GetPage
 * @see #GetAllowPaging
 * @see #SetDatasourceUrl
 */
nitobi.combo.List.prototype.GetDatasourceUrl = function()
{
	return this.m_DatasourceUrl;
}

/**
 * Sets the URL to a page that returns data from a datasource. 
 * This is used for populating the ComboBox as well as for paging and lookup.  When the combo requires a page of data, it calls this URL and gives
 * it the following arguments:
 * <ul>
 * <li>StartingRecordIndex - The next record in the data subset that the combo wants.</li>
 * <li>PageSize - Size of the page.</li>
 * <li>SearchSubstring - [Optional] The string the user is looking for.</li>
 * <li>ComboId - The Id of the combo making the request.</li>
 * <li>LastString - The last string searched for.</li></ul>
 * You can use this in conjunction with List.GetPage to add records to the combo.
 * <p>
 * <b>Example</b>:  Adding query string parameters to the List's DatasourceUrl
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction addParam(param, value)
 * {
 * 	var list = nitobi.getComponent('combo1').GetList();
 * 	var currentDatasourceUrl = list.GetDatasourceUrl();
 * 	list.SetDatasourceUrl(currentDatasourceUrl + "?" + param + "=" + value);
 * }
 * </code></pre>
 * </div>
 * @param {String} DatasourceUrl The URL that returns data to the ComboBox
 * @see #SetPageSize
 * @see #GetPage
 * @see #SetAllowPaging
 * @see #GetDatasourceUrl
 */
nitobi.combo.List.prototype.SetDatasourceUrl = function(DatasourceUrl)
{
	this.m_DatasourceUrl = DatasourceUrl;
}

/**
 * Returns the javascript that is run when the list is hidden.
 * You can set this property to be any valid javascript.
 * Set this property to return the 'this' pointer for the list object, for example, in the 
 * Combo html tag you can set it to: <code>OnHideEvent="MyFunction(this)"</code>.  'this' will refer to the
 * list object. You can then use this.GetCombo() to get the Combo object.
 * @type String
 * @see #SetOnHideEvent
 * @see #GetOnShowEvent
 * @see #GetCombo
 */
nitobi.combo.List.prototype.GetOnHideEvent = function()
{
	return this.m_OnHideEvent;
}

/**
 * Sets the javascript that is run when the list is hidden.
 * You can set this property to be any valid javascript.
 * Set this property to return the 'this' pointer for the list object, for example, in the 
 * Combo html tag you can set it to: <code>OnHideEvent="MyFunction(this)"</code>.  'this' will refer to the
 * list object. You can then use this.GetCombo() to get the Combo object.
 * @param {String} OnHideEvent Valid javascript that runs when the OnHideEvent fires.
 * @see #GetOnHideEvent
 * @see #GetCombo
 * @see #SetOnShowEvent
 */
nitobi.combo.List.prototype.SetOnHideEvent = function(OnHideEvent)
{
	this.m_OnHideEvent = OnHideEvent;
}

/**
 * Returns the javascript that is run when the list is shown.
 * This function is called when the list is shown. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnShowEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @type String
 * @see #GetOnHideEvent
 * @see #GetCombo
 * @see #SetOnShowEvent
 */
nitobi.combo.List.prototype.GetOnShowEvent = function()
{
	return this.m_OnShowEvent;
}

/**
 * Sets the javascript that is run when the list is shown.
 * This function is called when the list is shown. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnShowEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @param {String} OnShowEvent Valid javascript that is run when the OnShowEvent fires
 * @see #SetOnHideEvent
 * @see #GetCombo
 * @see #GetOnShowEvent
 */
nitobi.combo.List.prototype.SetOnShowEvent = function(OnShowEvent)
{
	this.m_OnShowEvent = OnShowEvent;
}

/**
 * Returns the javascript that is run just before the combo makes a search.
 * This function is called just before the combo makes a search. This is usually triggered by
 * the user typing something in the textbox.  The combo first searches it's local cache
 * (the XmlDataSource object) and if no hit is made there it searches the server. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnBeforeSearchEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @type String
 * @see #GetOnAfterSearchEvent
 * @see #SetOnBeforeSearchEvent
 * @see #GetCombo
 */
nitobi.combo.List.prototype.GetOnBeforeSearchEvent = function()
{
	return this.m_OnBeforeSearchEvent;
}

/**
 * Sets the javascript that is run just before the combo makes a search.
 * This function is called just before the combo makes a search. This is usually triggered by
 * the user typing something in the textbox.  The combo first searches it's local cache
 * (the XmlDataSource object) and if no hit is made there it searches the server. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnBeforeSearchEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @param {String} OnBeforeSearchEvent Valid javascript that is run just before the search if performed
 * @see #GetOnAfterSearchEvent
 * @see #GetOnBeforeSearchEvent
 * @see #GetCombo
 */
nitobi.combo.List.prototype.SetOnBeforeSearchEvent = function(OnBeforeSearchEvent)
{
	this.m_OnBeforeSearchEvent = OnBeforeSearchEvent;
}

/**
 * Returns the javascript that is run after the combo makes a search.
 * This function is called after the combo makes a search. This is usually triggered by
 * the user typing something in the textbox.  The combo first searches it's local cache
 * (the XmlDataSource object) and if no hit is made there it searches the server. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnAfterSearchEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @type String
 * @see #SetOnAfterSearchEvent
 * @see #GetOnBeforeSearchEvent
 * @see #GetCombo
 */
nitobi.combo.List.prototype.GetOnAfterSearchEvent = function()
{
	return this.m_OnAfterSearchEvent;
}

/**
 * Sets the javascript that is run after the combo makes a search.
 * This function is called after the combo makes a search. This is usually triggered by
 * the user typing something in the textbox.  The combo first searches it's local cache
 * (the XmlDataSource object) and if no hit is made there it searches the server. You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the list object, for example, in the 
 * List html tag you can set it to: <code>OnAfterSearchEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * list object. You can then use List.GetCombo to retrieve a handle to the combo object.
 * @param {String} OnAfterSearchEvent Valid javascript that is run after the search if performed
 * @see #GetOnAfterSearchEvent
 * @see #SetOnBeforeSearchEvent
 * @see #GetCombo
 */
nitobi.combo.List.prototype.SetOnAfterSearchEvent = function(OnAfterSearchEvent)
{
	this.m_OnAfterSearchEvent = OnAfterSearchEvent;
}

/**
 * @private
 */
nitobi.combo.List.prototype.GetOffsetX = function()
{
	return this.m_OffsetX;
}

/**
 * @private
 */
nitobi.combo.List.prototype.SetOffsetX = function(OffsetX)
{
	this.m_OffsetX = parseInt(OffsetX);
}

/**
 * @private
 */
nitobi.combo.List.prototype.GetOffsetY = function()
{
	return this.m_OffsetY;
}

/**
 * @private
 */
nitobi.combo.List.prototype.SetOffsetY = function(OffsetY)
{
	this.m_OffsetY = parseInt(OffsetY);
}

/**
 * @private
 */
nitobi.combo.List.prototype.AdjustSize = function()
{
	var list = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
	var tag = this.GetHTMLTagObject();
	var listStyle = tag.style;
	var listWidth = "";
	// Check for (vertical) scrollbar and adjust width if its present.
	if (true == nitobi.Browser.GetVerticalScrollBarStatus(list))
	{
		if (nitobi.Browser.GetMeasurementUnitType(this.GetWidth()) != "%")
		{
			// TODO: Why are there two lines here?
			// TODO: Why is this being assigned to a global?
			listWidth = parseInt(this.GetWidth()) + nitobi.html.getScrollBarWidth(list)  - (nitobi.browser.MOZ ? EBADefaultScrollbarSize : 0);
			listWidth = this.GetDesiredPixelWidth();
		}
		else
		{
			listWidth = this.GetDesiredPixelWidth();
		}
		
		list.style.width = listWidth;
		var header = this.GetSectionHTMLTagObject(EBAComboBoxListHeader);
		var footer = this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
		if (header != null) header.style.width = listWidth;
		if (footer != null) footer.style.width = listWidth;

		// NOTE: all of the above works and is necessary (or else the vertical
		// bar being present will force the presence of the horizontal bar
		// whether or not it is necessary);
		// - however, some points should be explained:
		// - EBAComboBoxList.style.overflow:visible must be set (or no overflow can be set
		// as overflow defaults to visible)
		// - this permits EBAComboBoxList to grow as its header, body, footer grows
		// - the problem is that EBAComboBoxList "should" grow forever as Show() is
		// called over and over - when looking at the above code initially
		// - this does NOT (which is the correct behavior) happen because of the following:
		// - this.GetWidth() depends on m_HTMLObjectTag.style.width (m_HTMLTagObject is EBAComboBoxList)
		// - even though EBAComboBoxList grows (because of style:visible), its style.width
		// does NOT grow (EBAComboBoxList's width adjusts but we're not changing its style.width)
		// - so, the next time Show() is called, GetWidth() returns the same value and
		// the whole container only grows by the width of the scrollbar if necessary
		// - so, the forever growing problem is nonexistent and everything works

		listStyle.width=(listWidth);
		if (nitobi.browser.IE)
		{
			var iframeStyle=nitobi.combo.iframeBacker.style;
			iframeStyle.width=listStyle.width;
		}
	}

	if (nitobi.browser.IE)
	{
		var iframeStyle=nitobi.combo.iframeBacker.style;
		iframeStyle.height=listStyle.height;
	}
}

/**
 * @private
 */
nitobi.combo.List.prototype.IsVisible = function()
{
	if (!this.m_Rendered)
	{
		return false;
	}
	var tag = this.GetHTMLTagObject();
	var listStyle = tag.style;
	return(listStyle.visibility=="visible");
}

/**
 * Shows the list.
 * If the list is hidden when this is called, then the OnShowEvent is triggered.
 * @example
 * &lt;a href='javascript:nitobi.getComponent('combo1').GetList().Show()'&gt;Show the list&lt;/a&gt;
 * </code></pre>

 * @see #SetOnShowEvent
 * @see #SetX
 * @see #SetY
 * @see #SetFrameX
 * @see #SetFrameY
 */
nitobi.combo.List.prototype.Show = function()
{
	var combo = this.GetCombo();
	var mode = combo.mode;

	this.Render();
	
	if(!this.m_HTMLTagObject || this.IsVisible() || mode=="compact" || this.GetXmlDataSource().GetNumberRows()==0 || ((mode!="default" && mode!="unbound") && combo.GetTextBox().m_HTMLTagObject.value==""))
	{
		// in case user click button, which calls this function before List has initialized fully
		// also, no need to show if list is already shown

		return;
	}

	var tag = this.GetHTMLTagObject();
	var textbox=combo.GetTextBox().GetHTMLContainerObject();
	var listStyle = tag.style;
	

	// TODO: What is this for exactly?
	// We can't call #AdjustSize until the list is visible because in 
	// #GenerateCss, we try to get the list's offsetWidth which is 0 if the 
	// list is not visible.
	//this.AdjustSize();
	
	var textboxHeight = nitobi.html.getHeight(textbox);

	var top = nitobi.html.getCoords(textbox).y + textboxHeight;
	var left = nitobi.html.getCoords(textbox).x;
	
	var height = parseInt(this.GetActualPixelHeight()); 
	var width = parseInt(this.GetActualPixelWidth()); 
	
	listStyle.top = top + "px"; 
	listStyle.left = left + "px";
	listStyle.zIndex = combo.m_ListZIndex;		
	var windowWidth = nitobi.html.getBodyArea().clientWidth;
	var windowHeight = nitobi.html.getBodyArea().clientHeight;   		
	var docScrollTop = (document.body.scrollTop=="" || parseInt(document.documentElement.scrollTop==0) ? 0 : parseInt(document.body.scrollTop));
	var docScrollLeft = (document.body.scrollLeft=="" || parseInt(document.documentElement.scrollLeft==0) ? 0 : parseInt(document.body.scrollLeft));
	
	// Put the list on top if it can't fit on the bottom.
	if (parseInt(top) - docScrollTop + height > windowHeight)
	{
		var newTop = parseInt(listStyle.top) -  height - textboxHeight;
		if (newTop >= 0) 
		{
			listStyle.top = newTop + "px";
		}
	}
	
	// Move the list left if it doesn't fit on the right.
	if (parseInt(left)-parseInt(docScrollLeft) + width > windowWidth)
	{
		var container = document.getElementById(combo.GetId());
		var containerWidth = nitobi.html.getWidth(container);
		
		if (width > containerWidth)
		{
			var delta = width - containerWidth;	
			var newLeft = left - delta; 
			if (newLeft >= 0) 
			{
				listStyle.left = newLeft + "px";
			}
		}
		
	}
	
	listStyle.position = "absolute";
	listStyle.display="inline";
	this.AdjustSize();
	this.GenerateCss();
	listStyle.visibility="visible";
	
	this.SetIFrameDimensions();
	this.ShowIFrame();
	// TODO: Convert this to use our toolkit event code
	eval(this.GetOnShowEvent());
}

/**
 * Set the X coordinate of the list.
 * You can use this in the OnShowEvent.  The Show method always tries to position
 * the list correctly under the list. However, due to bugs in both IE and Firefox, and depending on 
 * the HTML structure of you page, the x,y coordinates of the textbox are not always reported
 * correctly by browsers. This method enables you to move the list if you find it positioned incorrectly.
 * In IE, due to the fact that listboxes have a greater zindex than any other control, an empty
 * iframe is positioned behind the list. This prevents listboxes from showing through the
 * list.  You will also need to position this element correctly in IE.
 * @param {String} x The X coordinate of the list
 * @see #SetOnShowEvent
 * @see #SetY
 * @see #SetFrameX
 * @see #SetFrameY
 * @see #GetFrame
 * @private
 */
nitobi.combo.List.prototype.SetX = function(x)
{
	var tag = this.GetHTMLTagObject();
	tag.style.left = x;
}

/**
 * Returns the X position of the list
 * @type Number
 */
nitobi.combo.List.prototype.GetX = function()
{
	var combo = this.GetCombo();
	var coords = nitobi.html.getCoords(combo.GetHTMLTagObject());
	return coords.x;
}

/**
 * Set the Y coordinate of the list.
 * You can use this in the OnShowEvent.  The Show method always tries to position
 * the list correctly under the list. However, due to bugs in both IE and Firefox, and depending on 
 * the HTML structure of you page, the x,y coordinates of the textbox are not always reported
 * correctly by browsers. This method enables you to move the list if you find it positioned incorrectly.
 * In IE, due to the fact that listboxes have a greater zindex than any other control, an empty
 * iframe is positioned behind the list. This prevents listboxes from showing through the
 * list.  You will also need to position this element correctly in IE.
 * @param {String} y The Y coordinate of the list
 * @see #SetOnShowEvent
 * @see #SetX
 * @see #GetY
 * @see #SetFrameX
 * @see #GetFrame
 * @private
 */
nitobi.combo.List.prototype.SetY = function(y)
{
	var tag = this.GetHTMLTagObject();
	tag.style.top = y;
}

/**
 * Returns the Y position of the list
 * @type Number
 */
nitobi.combo.List.prototype.GetY = function()
{
	var textbox = this.GetCombo().GetTextBox().GetHTMLContainerObject();
	var textboxHeight = nitobi.html.getHeight(textbox);
	var y = nitobi.html.getCoords(textbox).y + textboxHeight;
	return y;
}

/**
 * Set the X coordinate of the list's iframe. This has no effect in Mozilla.
 * You can use this in the OnShowEvent.  The Show method always tries to position
 * the list correctly under the list. However, due to bugs in both IE and Firefox, and depending on 
 * the HTML structure of you page, the x,y coordinates of the textbox are not always reported
 * correctly by browsers. This method enables you to move the list if you find it positioned incorrectly.
 * In IE, due to the fact that listboxes have a greater zindex than any other control, an empty
 * iframe is positioned behind the list. This prevents listboxes from showing through the
 * list.  You will also need to position this element correctly in IE.
 * @param {String} x The x coordinate of the list's iframe
 * @see #SetOnShowEvent
 * @see #SetX
 * @see #SetY
 * @see #SetFrameY
 * @see #GetFrame
 */
nitobi.combo.List.prototype.SetFrameX = function(x)
{
	if (nitobi.browser.IE)
	{
		nitobi.combo.iframeBacker.style.left = x;
	}
}

/**
 * Set the Y coordinate of the list's iframe. This has no effect in Mozilla.
 * You can use this in the OnShowEvent.  The Show method always tries to position
 * the list correctly under the list. However, due to bugs in both IE and Firefox, and depending on 
 * the HTML structure of you page, the x,y coordinates of the textbox are not always reported
 * correctly by browsers. This method enables you to move the list if you find it positioned incorrectly.
 * In IE, due to the fact that listboxes have a greater zindex than any other control, an empty
 * iframe is positioned behind the list. This prevents listboxes from showing through the
 * list.  You will also need to position this element correctly in IE.
 * @param {String} y The y coordinate of the list's iframe
 * @see #SetOnShowEvent
 * @see #SetX
 * @see #SetY
 * @see #SetFrameX
 * @see #GetFrame
 */
nitobi.combo.List.prototype.SetFrameY = function(y)
{
	if (nitobi.browser.IE)
	{
		nitobi.combo.iframeBacker.style.top = y;
	}
}

/**
 * Returns the list's iframe. This returns null in Mozilla.
 * In IE, due to the fact that listboxes have a greater zindex than any other control, an empty
 * iframe is positioned behind the list. This prevents listboxes from showing through the
 * list.  This gives you access to the only iframe (shared by all combos) on the page used
 * for this purpose.
 * @type HTMLElement
 * @see #SetOnShowEvent
 * @see #SetX
 * @see #SetY
 * @see #SetFrameX
 * @see #SetFrameY
 */
nitobi.combo.List.prototype.GetFrame = function()
{
	if (nitobi.browser.IE)
	{
		return nitobi.combo.iframeBacker;
	}
	else
	{
		return null;
	}
}

/**
 * @private
 */
nitobi.combo.List.prototype.ShowIFrame = function()
{
	if (nitobi.browser.IE)
	{
					
		var iframeStyle=nitobi.combo.iframeBacker.style;
		iframeStyle.visibility="visible";
	}
}

/**
 * @private
 */
nitobi.combo.List.prototype.SetIFrameDimensions = function()
{
	if (nitobi.browser.IE)
	{
		var tag = this.GetHTMLTagObject();
		var iframeStyle=nitobi.combo.iframeBacker.style;
		var listStyle = tag.style;
		iframeStyle.top= listStyle.top;
		iframeStyle.left= listStyle.left;
		iframeStyle.width = nitobi.Browser.GetElementWidth(tag); 
		iframeStyle.height = nitobi.Browser.GetElementHeight(tag);

		// Ensure the iframe sits underneath the list.
		iframeStyle.zIndex = (isNaN(parseInt(listStyle.zIndex))?0:parseInt(listStyle.zIndex)-1);
	}
}


/**
 * Hides the list.
 * If the list is visible when this is called, then the OnHideEvent is triggered.
 * @see #SetOnHideEvent
 */
nitobi.combo.List.prototype.Hide = function()
{
	if (!this.m_Rendered)
	{
		return false;
	}
	var tag = this.GetHTMLTagObject();
	var	listStyle = tag.style;
	listStyle.visibility="hidden";
	if ((!nitobi.browser.IE))
	{
		listStyle.display="none";
	}
	if (nitobi.browser.IE)
	{
		var iframeStyle=nitobi.combo.iframeBacker.style;
		iframeStyle.visibility="hidden";
	}
	// TODO: use toolkit event firing
	eval(this.GetOnHideEvent());
}

/**
 * @private
 */
nitobi.combo.List.prototype.Toggle = function()
{
	if(this.IsVisible()){
		this.Hide();
		this.GetCombo().GetTextBox().ToggleHidden();
		
	}
	else{
		this.Show();
		this.GetCombo().GetTextBox().ToggleShow();
		
	}
}


/**
 * Sets the active row as the selected row.
 * @private
 */
nitobi.combo.List.prototype.SetActiveRowAsSelected = function()
{
	var combo = this.GetCombo();
	var t = combo.GetTextBox();
	
	// 2005.04.27
	// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
	
	// Match the hidden fields with the row fields.
	var row=null;
	row=this.GetActiveRow();
	if(null!=row)
	{
		eval(combo.GetOnBeforeSelectEvent());
	}
	if (row!=null)
	{
		this.SetSelectedRow(this.GetRowIndex(row));
		// Copy the value into the textbox.
		if(combo.mode!="smartlist")
		{
			t.SetValue(this.GetSelectedRowValues()[t.GetDataFieldIndex()]);
		}
	}
}


/**
 * Sets a row as selected given its index.
 * This sets the SelectedRowIndex as well as the selected row values.  
 * It is equivalent to calling {@link nitobi.combo.Combo#SetSelectedRowValues} and {@link nitobi.combo.Combo#SetSelectedRowIndex}.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * list.SetSelectedRow(3);  // Selects the 4th row (zero indexed)
 * @param Number RowIndex The number of the row you want to select. Indexed from zero.
 * @see nitobi.combo.Combo#GetSelectedRowIndex
 * @see nitobi.combo.Combo#GetSelectedRowValues
 */
nitobi.combo.List.prototype.SetSelectedRow = function(RowIndex)
{
	//TODO: this will be used for onclick as well as initialize to set the selectedrow.
	// OnClick should be modified to accomadate this,ie, some duplicate lines now.

	// Keep track of which row number was pressed.
	// NOTE: This is based from zero for javascript consistency. XSL indexes from 1.
	this.SetSelectedRowIndex(RowIndex);

	var values = this.GetXmlDataSource().GetRow(RowIndex);
	this.SetSelectedRowValues(values, null);
}

/**
 * Called when the user clicks the list.
 * @private
 */
nitobi.combo.List.prototype.OnClick = function(Row)
{
	eval(this.GetCombo().GetOnBeforeSelectEvent());
	var rowNum = this.GetRowIndex(Row);

	// Keep track of which row number was pressed.
	// NOTE: This is based from zero for javascript consistency. XSL indexes from 1.
	this.SetSelectedRowIndex(rowNum);

	var values = this.GetXmlDataSource().GetRow(rowNum);
	this.SetSelectedRowValues(values, null);

	var combo=this.GetCombo();
	var tb = combo.GetTextBox();
	var textboxDataFieldIndex = tb.GetDataFieldIndex();
	if (values.length <= textboxDataFieldIndex){
		alert("You have bound the textbox to a column that does not exist.\nThe textboxDataFieldIndex is " +
		textboxDataFieldIndex +
		".\nThe number of values in the selected row is " + values.length + "." );
	}
	else
		tb.SetValue(values[textboxDataFieldIndex], combo.mode=="smartlist");

	this.Hide();
	eval(combo.GetOnSelectEvent());
	
	// manually blur combo because it's not auto detected for some reason
	// TODO: figure why? or... stick w/ this workaround
	/*combo.m_Over=false;
	tb.OnBlur();*/
}

/**
 * Called when the user scrolls the list with the mouse wheel.
 * @private
 */
nitobi.combo.List.prototype.OnMouseWheel = function(evt)
{
	if(nitobi.browser.IE){
		var b = nitobi.Browser;
		var lb = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
		var top = this.GetRow(0);
		var bot = this.GetRow(this.GetXmlDataSource().GetNumberRows() - 1);
		if(null!=top){
			if(evt.wheelDelta >= 120)
				b.WheelUp(this);
			else if(evt.wheelDelta <= -120)
				b.WheelDown(this);
			evt.cancelBubble = true;
			evt.returnValue = false;
		}
	}
}

/**
 * @private
 */
nitobi.combo.List.prototype.Render = function()
{
	// Delay rendering until needed. Speeds up load time.
	if (!this.m_Rendered)
	{
		this.m_Rendered=true;
		var combo = this.GetCombo();
		var hostTag = document.body;
		// Insert the element in the beginning so that it doesn't create extra space at the bottom.
		var x = nitobi.html.insertAdjacentHTML(hostTag,'afterBegin',this.GetHTMLRenderString());
		this.Initialize(document.getElementById('EBAComboBoxText'+combo.GetId()));
		this.OnWindowResized();
		this.GenerateCss();
	}
}

/**
 * Returns the HTML that is used to render the object.
 * @private
 */
nitobi.combo.List.prototype.GetHTMLRenderString = function()
{
	var combo = this.GetCombo();
	var theme = 'outlook';

	var uniqueId = combo.GetUniqueId();
	var comboId = combo.GetId();

	var listWidth = parseInt(this.GetDesiredPixelWidth());
	
	var colDefHeadingsVisible=false;
	var rowHTML="";
	if (this.m_XmlDataSource.GetXmlObject())
	{
		var xml = null;
		if(combo.mode=="default" || combo.mode=="unbound")
			xml = this.m_XmlDataSource.GetXmlObject().xml;
		else
			xml = "<root></root>";
		rowHTML=this.GetRowHTML(xml);
	}

	var colDefs = this.GetListColumnDefinitions();

	var s="";
	// Insert the main span. The m_Over is used to keep the list open while keeping the focus
	// in the textbox.
	s="<span class=\"ntb-combo-reset "+ combo.theme +"\"><span id=\"EBAComboBoxList" + uniqueId + "\" class=\"ntb-combobox-list" + "\" style=\"width: " + listWidth + "px;\" " +
			"onMouseOver=\"document.getElementById('" + this.GetCombo().GetId() + "').object.m_Over=true\" " +
			"onMouseOut=\"document.getElementById('" + this.GetCombo().GetId() + "').object.m_Over=false\" " +
			"onClick=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnFocus()\">\n";
	
	// NOTE: above onClick is a fix for Mozilla - not necessary for but compatible w/ IE

	// Write out all the panels.
	var tag = this.m_userTag;
	var childNodes = tag.childNodes;
	var menus="<span class='ntb-combobox-combo-menus ComboListWidth"+uniqueId+"'>";
	var menusExist=false;
	for (var i = 0; i < childNodes.length; i++)
	{
		if (childNodes[i].nodeName.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"") == "combopanel")
		{
			s+=childNodes[i].innerHTML;
		}
		
		if (childNodes[i].nodeName.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"") == "combomenu")
		{
			menusExist = true;
			var icon = childNodes[i].getAttribute("icon");
			menus += "<div style='"+(nitobi.browser.MOZ && i ==0?/*"padding-top:10px"*/"":"")+";' class='ntb-combobox-combo-menu ComboListWidth"+uniqueId+"' onMouseOver=\"this.className='ntb-combobox-combo-menu-highlight ComboListWidth"+uniqueId+"'\" onmouseout=\"this.className='ntb-combobox-combo-menu ComboListWidth"+uniqueId+"'\" onclick=\""+childNodes[i].getAttribute("OnClickEvent")+"\">";
			if (icon != "")
			{
				menus += "<img class='ntb-combobox-combo-menu-icon' align='absmiddle' src='" + icon + "'>";
			}
			menus+=childNodes[i].getAttribute("text")+"</div>";	
		}
	}
	menus+="</span>";

	// List header.
	// Check to see that there are col def headings to display because if not, we wont
	// display them.
	if(combo.mode=="default" || combo.mode=="filter" || combo.mode=="unbound")
	{
		for (var i = 0; i < colDefs.length ; i++)
		{
			if (colDefs[i].GetHeaderLabel() != "")
				colDefHeadingsVisible=true;
		}
		var customHTMLHeader = this.GetCustomHTMLHeader();
		if ((colDefHeadingsVisible==true) || (customHTMLHeader!="")){
			//listWidth="100%";
			s+="<span id='EBAComboBoxListHeader" + uniqueId + "' class='ntb-combobox-list-header' style='padding:0px; margin:0px; width: " + listWidth + "px;' >\n";
			if (customHTMLHeader != "")
				s+=customHTMLHeader;
			else
			{
				/* table-layout:fixed; */
				s+="<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;' class='ComboHeader"+uniqueId+"'>\n";
				s+="<tr style='width:100%' id='EBAComboBoxColumnLabels" + uniqueId + "' class='ntb-combobox-column-labels'>\n";
				var attributes="";
				var wildcardInList=false;
				for (var i = 0; i < colDefs.length ; i++)
				{
					var colWidth = colDefs[i].GetWidth();
					
					attributes="";
					if (colDefs[i].GetColumnType().toLowerCase() == "hidden"){
						attributes += "style='display: none;'";
						colDefs[i].SetWidth("0%");
					}
					var className = "comboColumn_" + i + "_" + uniqueId;
					// The list itself doesn't have any padding. This corrects the header so it looks the same as the list.
					var padding = (i > 0?"style='padding-left:0px'":"");
					s+="<td " + padding + " align='" + colDefs[i].GetAlign() + "' class='ntb-combobox-column-label "+className+"' " + attributes + ">";
					s += "<div class='" + className + " ntb-combobox-column-label-text'>" +  colDefs[i].GetHeaderLabel() + "</div>";
					//s += colDefs[i].GetHeaderLabel();
					s += "</td>\n";
				}
				s+="</tr>\n";
				s+="</table>\n";
			}
//2005.04.21				s+="</span><br>\n";
			s+="</span><br>\n";
		}
	}


	if (menusExist)
	{
		s+=menus;
	}
	
	// List body.
	s+="<span id='EBAComboBoxListBody" + uniqueId + "' class='ntb-combobox-list-body" + "' style='width:" + listWidth  + "px;" + (combo.mode=="default" || combo.mode=="unbound" || (combo.mode=="smartsearch" && this.GetAllowPaging()) ? "height: "+this.GetSectionHeight(EBAComboBoxListBody) + "px" + (this.m_overflowy == "auto" ? ";_overflow-y:;_overflow:auto": "") : "overflow:visible") + ";' onscroll=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetTextBox().GetHTMLTagObject().focus()\" "+
		"onmousewheel=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnMouseWheel(event)\" "+
		"onfocus=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnFocus()\">\n";

	// Add the 1st table.
	s+=rowHTML +
		"</table>" + // This is a huge hack cause the rowHTML is outputting a self closing emtpy table tag when ther are no rows
		"</span>\n";

	// List footer.
	// TODO List footer text.
//		var allowPaging = this.GetAllowPaging();
//		if ((combo.mode=="default" || combo.mode=="smartsearch") && true == allowPaging){
//2005.04.21			s+="<span id='EBAComboBoxListFooter" + uniqueId + "' style='width:"+ listWidth  +"' class='ntb-combobox-list-footer' >\n";
		s+="<br><span id='EBAComboBoxListFooter" + uniqueId + "' style='width:"+ listWidth  + "px; display:" + (this.GetAllowPaging()?"inline":"none") + "' class='ntb-combobox-list-footer'>\n";
		s+="<span id=\"EBAComboBoxListFooterPageNextButton" + uniqueId + "\" style=\"width:100%\"" +
				" class=\"ntb-combobox-list-footer-page-next-button\" "+
				"onMouseOver='this.className=\"ntb-combobox-list-footer-page-next-button-highlight\"' "+
				"onMouseOut='this.className=\"ntb-combobox-list-footer-page-next-button\"' " +
				"onClick=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnGetNextPage(null, true);\"></span>\n";

		s+="</span>\n"+
			"</span>\n";
	//}
	s+="</span>\n";
	
	s=s.replace(/\#<\#/g,"<").replace(/\#\>\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#EQ\#/g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&");

	return s;
}

/**
 * Initializes the object after construction.  Must be called after the object's HTML tags are placed on the page.
 * @param {Object} attachee HTML element to attach this list to (i.e. an INPUT element).
 * @private
 */
nitobi.combo.List.prototype.Initialize = function(attachee)
{
	this.attachee=attachee;
	
	var c = this.GetCombo();
	var d = document;
	var uniqueId = c.GetUniqueId();
	this.SetHTMLTagObject(d.getElementById("EBAComboBoxList" + uniqueId));
	this.SetSectionHTMLTagObject(EBAComboBoxListHeader,d.getElementById("EBAComboBoxListHeader" + uniqueId));
	this.SetSectionHTMLTagObject(EBAComboBoxListBody,d.getElementById("EBAComboBoxListBody" + uniqueId));
	this.SetSectionHTMLTagObject(EBAComboBoxListFooter,d.getElementById("EBAComboBoxListFooter" + uniqueId));
	this.SetSectionHTMLTagObject(EBAComboBoxListBodyTable,d.getElementById("EBAComboBoxListBodyTable" + uniqueId));
	this.SetSectionHTMLTagObject(EBAComboBoxList,d.getElementById("EBAComboBoxList" + uniqueId));
	if (c.mode=="default" && true==this.GetAllowPaging())
		this.SetFooterText(this.GetXmlDataSource().GetNumberRows() + EbaComboUi[EbaComboUiNumRecords]);

	this.Hide();
}


/**
 * Called when the user mouses over the list.
 * @param {Object} Row
 * @private
 */
nitobi.combo.List.prototype.OnMouseOver = function(Row)
{
	this.SetActiveRow(Row);
}

/**
 * Called when the user mouses out of the list.
 * @private
 */
nitobi.combo.List.prototype.OnMouseOut = function(Row)
{
	this.SetActiveRow(null);
}

/**
 * Called when the list gains focus.
 * @private
 */
nitobi.combo.List.prototype.OnFocus = function()
{
	var t = this.GetCombo().GetTextBox();
	t.m_skipFocusOnce=true;
	t.m_HTMLTagObject.focus();
}

/**
 * Fires when the users wants another page.
 * @private
 */
nitobi.combo.List.prototype.OnGetNextPage = function(ScrollTo, workaround)
{
	if (this.m_httpRequestReady)
	{
		var dataSource = this.GetXmlDataSource();
		var last = null;
		if(workaround==true)
		{
			var n = dataSource.GetNumberRows();
			if(n>0)
			{
				last = dataSource.GetRowCol(n - 1, this.GetCombo().GetTextBox().GetDataFieldIndex());
			}
		}
		// This makes an async call that calls addpage on list and xmldatasource.
		this.GetPage(dataSource.GetNumberRows(), this.GetPageSize(), this.GetCombo().GetTextBox().GetIndexSearchTerm(), ScrollTo, last);
		// Make sure that the textbox retains focus so that blur works.
		this.GetCombo().GetTextBox().GetHTMLTagObject().focus();
	}
}


/**
 * @private
 */
nitobi.combo.List.prototype.OnWindowResized = function()
{
	if (!this.m_Rendered) return;
	if (nitobi.Browser.GetMeasurementUnitType(this.GetWidth()) == "%")
	{
		// TODO: Clearly needs correction.
		this.SetWidth(this.GetWidth());
	}
}

/**
 * @private
 */
nitobi.combo.List.prototype.GenerateCss = function()
{
	var colDefs = this.GetListColumnDefinitions();
	var uid = this.GetCombo().GetUniqueId();
	var cssText = "";

	var wildCardIndex=-1;
	var list = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
	var sb = nitobi.html.getScrollBarWidth(list);
	var fudge = (nitobi.browser.MOZ?6:0);
	
	var width=0;
	// TODO: This all needs to be cleaned up.  What is this.widestColumn
	// even used for?
	for (var i=0;i<this.widestColumn.length;i++)
	{
		width+=this.widestColumn[i];
	}
	if (width < parseInt(this.GetDesiredPixelWidth()))
	{
		width = parseInt(this.GetDesiredPixelWidth());
	}
	
	// TODO: The width value should be the sum of each column width, not the List width.
	var remainingSpace = width - sb - fudge;
	var availSpace = width - sb - fudge;
	var addRule = nitobi.html.Css.addRule;
	if (this.stylesheet == null)
		this.stylesheet = nitobi.html.Css.createStyleSheet();
	var ss = this.stylesheet.sheet;
	if (nitobi.browser.SAFARI || nitobi.browser.CHROME) {
		addRule(ss, ".ComboRow" + uid, "width:"+(width - sb)+"px;}");
		addRule(ss, ".ComboHeader" + uid, "width:"+(width - sb + 3)+"px;}");
		addRule(ss, ".ComboListWidth" + uid, "width:"+(width)+"px;");
	} else {
		cssText += ".ComboRow" + uid + "{width:"+(width - sb)+"px;}";
		cssText += ".ComboHeader" + uid + "{width:"+(width - sb + 3)+"px;}";
		cssText += ".ComboListWidth" + uid + "{width:"+(width)+"px;}";
	}

	for (var i = 0; i < colDefs.length; i++)
	{
		var colWidth = colDefs[i].GetWidth();
		if (nitobi.Browser.GetMeasurementUnitType(colWidth) == "%" && colWidth != "*")
		{
			colWidth = Math.floor((parseInt(colWidth)/100) * availSpace);
		}
		else if (colWidth != "*")
		{
			colWidth = parseInt(colWidth);
		}
		if(colWidth=="*" || (i == colDefs.length-1 && wildCardIndex==-1))
		{
			wildCardIndex = i;
		}
		else
		{
			if (colWidth < this.widestColumn[i])
				colWidth = this.widestColumn[i];
			remainingSpace -= parseInt(colWidth);
			if (nitobi.browser.SAFARI || nitobi.browser.CHROME)
				addRule(ss, ".comboColumn_" + i + "_" + uid, "width:"+(colWidth)+"px;");
			else
				cssText += ".comboColumn_" + i + "_" + uid + "{ width: " + (colWidth) + "px;}";
		}
	}
	if (wildCardIndex!=-1)
	{
		if (nitobi.browser.SAFARI || nitobi.browser.CHROME)
			addRule(ss, ".comboColumn_" + wildCardIndex + "_" + uid, "width:"+remainingSpace+"px;");
		else
			cssText += ".comboColumn_" + wildCardIndex + "_" + uid + "{ width: " + remainingSpace + "px;}";
	}
	nitobi.html.Css.setStyleSheetValue(this.stylesheet, cssText);
}

/**
 * @private
 */
nitobi.combo.List.prototype.ClearCss = function()
{
	if (this.stylesheet == null) 
	{
		this.stylesheet = document.createStyleSheet();
	}
	this.stylesheet.cssText = "";
}

/**
 * Given some XML, return formatted HTML code that can be inserted into the list.
 * @param {String} XML The XML rows that will be transformed into HTML.
 * @param {String} [SearchSubstring] Search substring to bold (i.e. in "smart" search modes).
 * @private
 */
nitobi.combo.List.prototype.GetRowHTML = function(XML, SearchSubstring)
{
	var combo = this.GetCombo();
	var comboId = combo.GetId();
	var uniqueId = combo.GetUniqueId();
	var colDefs = this.GetListColumnDefinitions();
	// important to parseInt() because GetWidth() currently returns with "px"
	var listWidth = parseInt(this.GetWidth());
			
	// XSL For the table entries.
	var xsl="<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\"  >";

// changed from method='html' to 'xml' to prevent a0: name qualifier from being prepended to tags in Moz
	xsl += "<xsl:output method=\"xml\" version=\"4.0\" omit-xml-declaration=\"yes\" />\n"+
			"<xsl:template match=\"/\">"+
			"<table cellspacing=\"0\" cellpadding=\"0\" id=\"EBAComboBoxListBodyTable" + uniqueId + "_" + this.GetNumPagesLoaded() + "\" class=\"ntb-combobox-list-body-table ComboRow" + uniqueId +"\">\n"+
			"<xsl:apply-templates />"+
			"</table>"+
			"</xsl:template>";

	// Template for table entries.
	xsl += "<xsl:template match=\"e\">";

	xsl += "<tr onclick=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnClick(this)\" " +
			"onmouseover=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnMouseOver(this)\" " +
			"onmouseout=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnMouseOut(this)\">";

	xsl += "<xsl:attribute name=\"id\">";

	// The rows are number linearly through all the tables. Calculate the starting
	// row number for this page of data. Note the -1: xsl indexes from 1, and we
	// want to index from 0.
	var rowNumberXsl = "position()+" + (this.GetXmlDataSource().GetNumberRows() - this.GetXmlDataSource().GetLastPageSize()) + "-1";
	var rowIdXsl = "EBAComboBoxRow" + uniqueId + "_<xsl:value-of select=\"" + rowNumberXsl + "\"/>";
	xsl += rowIdXsl+
			"</xsl:attribute>"+
			// The row is put in a table so that we can apply styles per row. Some styles can't be applied to tr tags.
			"<td class='ComboRowContainerParent'><table cellspacing='0' cellpadding='0' class='ntb-combobox-list-body-table-row "+"ComboRow" + uniqueId +"' style=\"width:"+(nitobi.browser.SAFARI || nitobi.browser.CHROME?this.GetWidth():"100%")+";table-layout:fixed;\"><tbody>"+
			// Set the id of the containing table.
			"<xsl:attribute name=\"id\">"+
			"ContainingTableFor" + rowIdXsl+
			"</xsl:attribute>"+
			"<tr class='ComboRowContainer'>";

	var customHTMLDefinition = this.GetCustomHTMLDefinition();
	var dataFieldIndex;

	var colgroup = "";

	if ("" == customHTMLDefinition){
		// Draw regular columns.
		for (var i = 0; i < colDefs.length; i++){
			var attributes = "";
			var colType = colDefs[i].GetColumnType().toLowerCase();
			if (colType == "hidden")
				attributes += "style='display: none;'";

			var widthClass = "comboColumn_" + i + "_" + uniqueId;

			colgroup += "<col class=\""+widthClass+"\" style=\"width:"+colDefs[i].GetWidth()+"\" />"

			xsl += "<td align='" + colDefs[i].GetAlign() + "' class='" + widthClass + " " + colDefs[i].GetCSSClassName() + "' " + attributes + " style=\"width:"+colDefs[i].GetWidth()+"\">";
			//Write a span tag to contain the data.
//				xsl += "<span class='"+colDefs[i].GetCSSClassName()+"' style='width:" + colDefs[i].GetWidth() + ";color:" + colDefs[i].GetTextColor() + ";' onfocus='document.c.GetList().OnFocus()' onmouseover='document.c.GetList().OnFocus()'>";
// 2005.04.26 - class attr seems like a duplication AND it seems to be the cause of a FireFox bug
// (SetActiveRow causes a flicker); somewhat tested and everything seems to work well w/o this class attr here on the span
				xsl += "<div class=\"" + (nitobi.browser.IE||nitobi.browser.SAFARI||nitobi.browser.CHROME?widthClass + " ":"") + colDefs[i].GetCSSClassName() + "Cell\" style=\"color:" + colDefs[i].GetTextColor() + ";overflow:hidden;\" onfocus=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnFocus()\""+
							" onmouseover=\"document.getElementById('" + this.GetCombo().GetId() + "').object.GetList().OnFocus()\">";
			
			xsl += "<xsl:attribute name=\"id\">"+
					"ContainingSpanFor" + rowIdXsl + "_" + i+
					"</xsl:attribute>"+
					"<xsl:text disable-output-escaping=\"yes\">" +
						"<![CDATA[" +
						colDefs[i].GetHTMLPrefix() +  "" +
						"]]>" +
					"</xsl:text>";

			// The datafield index. If one doesn't exist, use the column position.
			dataFieldIndex = colDefs[i].GetDataFieldIndex();
			if (null == dataFieldIndex)
				dataFieldIndex=i;
			dataFieldIndex=parseInt(dataFieldIndex);
			// If the column is images write the first part of the image tag out.
			var imageHandlerURL="";
			if (colType == "image")
			{
				imageHandlerURL = colDefs[i].GetImageHandlerURL();
				imageHandlerURL.indexOf("?") == -1 ? imageHandlerURL += "?" :  imageHandlerURL += "&";
				imageHandlerURL += "image=";
				
				xsl += "<img> <xsl:attribute name=\"align\"><xsl:value-of  select=\"absmiddle\"/></xsl:attribute>"
						+ "<xsl:attribute name=\"src\"><xsl:value-of select=\"concat('"+(colDefs[i].ImageUrlFromData ? "" : imageHandlerURL) + "',"
						+ "@" + String.fromCharCode(97 + dataFieldIndex) + ")\"/></xsl:attribute>" 
						+ "</img>";
			}

			// Print the value, and bold it if appropriate.
			if((SearchSubstring!=null) && (colType != "image")) {
				 xsl += '<xsl:call-template name="bold"><xsl:with-param name="string">';
			}
			// The value
			if (colType != "image")
			{
				xsl += '<xsl:value-of select="@' + String.fromCharCode(97 + dataFieldIndex) + '"></xsl:value-of>';
			}
			
			if((SearchSubstring!=null) && (colType != "image")) 
			{
				xsl += "</xsl:with-param><xsl:with-param name=\"pattern\" select=\"" + nitobi.xml.constructValidXpathQuery(SearchSubstring,true) + "\"></xsl:with-param></xsl:call-template>";
			}
			

			// Draw the HTMLSuffix.
			xsl += "<xsl:text disable-output-escaping=\"yes\">" +
					"<![CDATA[" +
					colDefs[i].GetHTMLSuffix() +  "" +
					"]]>" +
					"</xsl:text>";

			xsl += "</div>";

			xsl += "</td>";
		}
	}else{
		// Draw HTML that is defined by the user.
		xsl += "<td width='100%'>";
		var done = false;
		var nextOpeningBracket=0;
		var nextClosingBracket=0;
		var prevClosingBracket=0;
		var colNum;


		// Loop through the HTML definition and pick out the columns replacing them
		// with references to the correct XML data.
		while (!done){
			nextOpeningBracket = customHTMLDefinition.indexOf("${",nextClosingBracket);

			if (nextOpeningBracket != -1){
				nextClosingBracket = customHTMLDefinition.indexOf("}",nextOpeningBracket);

				colNum = customHTMLDefinition.substr(nextOpeningBracket+2, nextClosingBracket-nextOpeningBracket-2);


				xsl += "<xsl:text disable-output-escaping=\"yes\">" +
					"<![CDATA[" +
						customHTMLDefinition.substr(prevClosingBracket,nextOpeningBracket-prevClosingBracket) +
					"]]>" +
					"</xsl:text>";
				// The value
 				xsl += '<xsl:value-of select="@' + String.fromCharCode(parseInt(colNum) + 97) + '"></xsl:value-of>';
				prevClosingBracket = nextClosingBracket+1;
			}else{
				xsl += "<xsl:text disable-output-escaping=\"yes\">" +
					"<![CDATA["+
					customHTMLDefinition.substr(prevClosingBracket)+
					"]]>" +
					"</xsl:text>";
				done = true;
			}
		}
		xsl += "</td>";
	}

	// Note: One row per line.
	xsl += "</tr></tbody><colgroup>"+colgroup+"</colgroup></table></td></tr>\n"+
			"</xsl:template>";
	if(SearchSubstring!=null)
	{																																																																																																																																																																																																																																																										
		xsl+="<xsl:template name=\"bold\">"+
			"<xsl:param name=\"string\" select=\"''\" /><xsl:param name=\"pattern\" select=\"''\" /><xsl:param name=\"carryover\" select=\"''\" />";

		xsl+="<xsl:variable name=\"lcstring\" select=\"translate($string,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')\"/>"+
			 "<xsl:variable name=\"lcpattern\" select=\"translate($pattern,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')\"/>";
			
		xsl+="<xsl:choose>"+
			"<xsl:when test=\"$pattern != '' and $string != '' and contains($lcstring,$lcpattern)\">"+
				"<xsl:variable name=\"newpattern\" select=\"substring($string,string-length(substring-before($lcstring,$lcpattern)) + 1, string-length($pattern))\"/>"+
				"<xsl:variable name=\"before\" select=\"substring-before($string, $newpattern)\" />"+
				"<xsl:variable name=\"len\" select=\"string-length($before)\" />"+
				"<xsl:variable name=\"newcarryover\" select=\"boolean($len&gt;0 and contains(substring($before,$len,1),'%'))\" />"+
				"<xsl:value-of select=\"$before\" />"+
					"<xsl:choose>"+
					"<xsl:when test=\"($len=0 and $carryover) or $newcarryover or ($len&gt;1 and contains(substring($before,$len - 1,1),'%'))\">"+
						"<xsl:copy-of select=\"$newpattern\" />"+
					"</xsl:when>"+
				"<xsl:otherwise>"+
					"<b><xsl:copy-of select=\"$newpattern\" /></b>"+
				"</xsl:otherwise></xsl:choose>"+
				"<xsl:call-template name=\"bold\">"+
					"<xsl:with-param name=\"string\" select=\"substring-after($string, $newpattern)\" />"+
					"<xsl:with-param name=\"pattern\" select=\"$pattern\" />"+
					"<xsl:with-param name=\"carryover\" select=\"$newcarryover\" />"+
				"</xsl:call-template>"+
			"</xsl:when>"+
			"<xsl:otherwise>"+
				"<xsl:value-of select=\"$string\" />"+
			"</xsl:otherwise>"+
		"</xsl:choose>"+
		"</xsl:template>";
	}
	xsl += "</xsl:stylesheet>";

	oXSL=nitobi.xml.createXmlDoc(xsl);
	// Moz treats whitespace nodes differently from IE; to be safe, parse
	// out whitespace between xml tags for Moz & IE;
	// if we don't parse out the whitespace, rows may not be numbered
	// properly
	tmp=nitobi.xml.createXmlDoc(XML.replace(/>\s+</g,"><"));
	// TODO: This should just use transformToString but the output type is XML and there may be a reason for that.
	var html = nitobi.xml.serialize(nitobi.xml.transformToXml(tmp, oXSL));
	html = html.replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#\&eq\;\#/g,"=").replace(/\#\&quot\;\#/g,"\"").replace(/\#\&amp\;\#/g,"&");
	return html;
}

/**
 * Scrolls a row into view.
 * @param {HTMLNode} Row The row to scroll into view.
 * @param {Boolean} Top If true, scroll into view if Row not at the top. If false, scroll into view if Row not in list container's view.
 * @param {Boolean} IgnoreHorizontal If true, then ignore check in the horizontal direction.
 * @private
 */
nitobi.combo.List.prototype.ScrollIntoView = function(Row,Top,IgnoreHorizontal)
{
	if(Row && this.GetCombo().mode!="compact")
	{
		var container = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
		if(nitobi.Browser.IsObjectInView(Row,container,Top,IgnoreHorizontal)==false){
			nitobi.Browser.ScrollIntoView(Row,container,Top);
		}
	}
}

/**
 * Returns the index of a row given the tr row object.</summary>
 * @param {HTMLNode} Row The row whose index you want to get.
 * @private
 */
nitobi.combo.List.prototype.GetRowIndex = function(Row)
{
	// Get the row number
	var vals = Row.id.split("_");
	var rowNum = vals[vals.length-1];
	return rowNum;
}


EBAComboListDatasourceAccessStatus_BUSY=0;
EBAComboListDatasourceAccessStatus_READY=1;

/**
 * Returns the status of the search mechanism as either EBAComboListDatasourceAccessStatus_BUSY (0) or
 * EBAComboListDatasourceAccessStatus_READY (1).  If the status is busy, a search or GetPage is in progress.
 * Calling GetPage while Busy will cancel the current GetPage or search.  This is primarily used when you want to do multiple GetPage requests.
 * @type Number
 * @see #GetPage
 */
nitobi.combo.List.prototype.GetDatasourceAccessStatus = function()
{
	if (this.m_httpRequestReady)
		return EBAComboListDatasourceAccessStatus_READY;
	else
		return EBAComboListDatasourceAccessStatus_BUSY;
}

// In some contexts, users put the this ptr in their event handling code
// However, sometimes eval is called when the this pointer is null, because
// it is not this object calling eval. This fixing this problem.
/**
 * @private
 */
nitobi.combo.List.prototype.Eval = function(Expression)
{
	eval(Expression);
}

/**
 * Gets a new page of data from the server, adds it to the local cache, and updates the list display.  Uses the DatasourceUrl property.
 * When you do multiple GetPage requests, newer requests cancel older requests. If you do not want this
 * to occur, use {@link #GetDatasourceAccessStatus} to check the status of the Datasource before calling newer pages.
 * You can clear the list by using {@link #Clear} you can clear the XmlDataSource cache by using {@link nitobi.combo.XmlDataSource#Clear}.
 * When GetPage is used to perform a search by using the SearchSubstring parameter, the mode of the combo determines the local search algorithm.
 * For instance, Classic, Compact, and Unbound modes search by string prefix, that is, it only the tries to match the front of the string; SmartList,
 * SmartSearch, and Filter try to match anywhere in the string.
 * @param {Number} StartingRecordIndex The record index which defines the start of the page
 * @param {Number} PageSize The number of records to be retrieved
 * @param {String} SearchSubstring The search substring the user has typed into the textbox. The type of search is determined by the mode
 * @param {Number} ScrollTo Action to take after paging. It can be one of EBAScrollToNone (0), EBAScrollToTop (1), EBAScrollToBottom (2), EBAScrollToNewTop (3), EBAScrollToTypeAhead (4), EBAScrollToNewBottom (5)
 * @param {String} LastString The last string that was searched for.
 * @param {Object} GetPageCallback A function reference that is called with the a GetPageResult argument. It may be EBAComboSearchNoRecords=0 or EBAComboSearchNewRecords=1
 * @see #GetDatasourceAccessStatus
 * @see nitobi.combo.XmlDataSource#Clear
 * @see #Clear
 * @see #AddRow
 */
nitobi.combo.List.prototype.GetPage = function( StartingRecordIndex, PageSize, SearchSubstring, ScrollTo , LastString, GetPageCallback, SearchColumnIndex, SearchCallback)
{
	var requestTime = new Date().getTime();
	
	this.SetFooterText(EbaComboUi[EbaComboUiPleaseWait]);

	if (LastString == null)
	{
		LastString = "";
	}

	this.m_httpRequest = new nitobi.ajax.HttpRequest();
	this.m_httpRequest.responseType = "text";
	this.m_httpRequest.onRequestComplete.subscribe(this.onGetComplete, this);
	this.lastHttpRequestTime = requestTime;

	// Abort any other searches in favour of this one.
	// this.m_httpRequest.abort();

	if(null==ScrollTo)
		ScrollTo=EBAScrollToNone;

	// Save this value so that we can check it against what the gethandler returned to us.
	this.m_OriginalSearchSubstring=SearchSubstring;
	// Get the current page URL and add args to it.
	var pageUrl = this.GetDatasourceUrl();
	pageUrl.indexOf("?") == -1 ? pageUrl += "?" :  pageUrl += "&";
	// Note: Use encodeURI to be compatible with foreign text.
	pageUrl += "StartingRecordIndex=" + StartingRecordIndex + "&PageSize=" + PageSize + "&SearchSubstring=" + encodeURIComponent(SearchSubstring) + "&ComboId="+encodeURI(this.GetCombo().GetId())+"&LastString="+encodeURIComponent(LastString);
	// Set up the post.
	this.m_httpRequest.open(this.GetCombo().GetHttpRequestMethod(), pageUrl, true, "", "");

	// Send the request.
	this.m_httpRequestReady=false;
	this.m_httpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	this.m_httpRequest.params = {
		StartingRecordIndex:StartingRecordIndex, 
		SearchSubstring:SearchSubstring, 
		ScrollTo:ScrollTo, 
		GetPageCallback:GetPageCallback, 
		SearchColumnIndex:SearchColumnIndex, 
		SearchCallback:SearchCallback,
		RequestTime:requestTime
	};
	

	// Attempt to locate ASP.Net viewstate
	var vs = document.getElementsByName("__VIEWSTATE");
	if ((vs != null) && (vs["__VIEWSTATE"] != null))
	{
		// get the viewstate from the page and URL encode '+' chars
		var viewState = "__VIEWSTATE=" + encodeURI(vs["__VIEWSTATE"].value).replace(/\+/g, '%2B');
		var target = "__EVENTTARGET=" + encodeURI(this.GetCombo().GetId());
		var args = "__EVENTARGUMENT=GetPage";
		var httpRequestBody = target + "&" + args + "&" + viewState;
		this.m_httpRequest.send(httpRequestBody);
	}
	else
	{
		// Handle non-ASP.Net requests
		this.m_httpRequest.send("EBA Combo Box Get Page Request");
	}
	return true;
}

/**
 * Handler that is called when the data is retrieved from the server.
 * @private
 * @param {Object} evtArgs
 */
nitobi.combo.List.prototype.onGetComplete = function(evtArgs){
	
		var params = evtArgs.params;
		if (this.lastHttpRequestTime != params.RequestTime) return;

		var co = this.GetCombo();
		var t = co.GetTextBox();
		var list = co.GetList();

		if (list == null) 
			alert(EbaComboUi[EbaComboUiServerError]);

		var newXml = evtArgs.response;

		// Careful here. If there is anything before the XML declaration in an xml document, such as the 
		// junk that MS adds for their ASP debugging, then xml.load will fail. Instead, we have to 
		// manually load the data from the url, strip out anything that comes before <?xml.
		//TODO: The whole xmlhttprequest needs a better wrapper than xbdom.
		var declaredXmlIndex = newXml.indexOf("<?xml");
		if (declaredXmlIndex != -1) {
			newXml = newXml.substr(declaredXmlIndex);
		}

		var datasource = list.GetXmlDataSource();
		var numOldRecords = datasource.GetNumberRows();
		var tmp=nitobi.xml.createXmlDoc(newXml);
		if (true == list.clip) {
			tmp = xbClipXml(tmp, "root", "e", list.clipLength);
			newXml = tmp.xml;
		}
		
		var numNewRecords = tmp.selectNodes("//e").length;
		
		// If we're starting from the beginning and we get
		// xml back, clear the list. Don't clear the list if allow paging is on in smartsearch.
		var filter = co.mode != "default" && !(co.mode == "smartsearch" && list.GetAllowPaging());
		if ((numNewRecords > 0) && (params.StartingRecordIndex == 0) || filter) {
			list.Clear();
			datasource.Clear();
		}
		if (numNewRecords == 0 && filter) {
			list.Hide();
		}
		if (numNewRecords > 0) {
			datasource.AddPage(newXml);
			var ss = null;
			if (co.mode == "smartsearch" || co.mode == "smartlist") 
				ss = list.searchSubstring;
			list.AddPage(newXml, ss);
			if ((params.StartingRecordIndex == 0) && (list.GetCombo().GetTextBox().GetSearchTerm() != "")) {
				// The user is searching for something. We have records starting with the
				// first match. So match it client side.
				list.SetActiveRow(list.GetRow(0));
			}
			
			var mismatchedDataBinding = false;
			try {
				if (!list.IsFuzzySearchEnabled()) {
					// Analyse the search to see if the gethandler returned what we were searching for,
					// otherwise the combo goes into an infinite loop.
					var index = datasource.Search(list.m_OriginalSearchSubstring, t.GetDataFieldIndex(), co.mode == "smartsearch" || co.mode == "smartlist");
					mismatchedDataBinding = (index == -1);
				// If the server claims to have found a match, but we don't, raise a warning.
				//co.ShowWarning(index!=-1,"cw001");
				}
			} 
			catch (err) {
				// Drop this error. Its better to try the search rather than issue an error
				// about failed search analysis.

			}
			
			var isVisible = list.IsVisible();
			
			if (EBAScrollToBottom == params.ScrollTo) {
				var r = list.GetRow(numOldRecords - 1);
				list.SetActiveRow(r);
				list.ScrollIntoView(r, false);
			}
			else {
				if (EBAScrollToNewTop == params.ScrollTo || EBAScrollToNewBottom == params.ScrollTo) {
					var r = list.GetRow(numOldRecords);
					list.SetActiveRow(r);
					list.ScrollIntoView(r, EBAScrollToNewTop == params.ScrollTo);
					var tb = t.m_HTMLTagObject;
					tb.value = list.GetXmlDataSource().GetRowCol(numOldRecords, t.GetDataFieldIndex());
					nitobi.html.setCursor(tb, tb.value.length);
					t.Paging = false;
				}
				else 
					if (isVisible) {
						list.ScrollIntoView(list.GetActiveRow(), true);
					}
			}
			try {
				// If the binding is mismatched, ie, classic hooked up to smartsearch gethandler, don't do any callbacks.
				if (!mismatchedDataBinding && params.GetPageCallback) {
					params.GetPageCallback(EBAComboSearchNewRecords, list, params.SearchSubstring, params.SearchColumnIndex, params.SearchCallback);
				}
			} 
			catch (err) {

			}
		}
		else {
			try {
				if (params.GetPageCallback) {
					// result, list, SearchSubstring, SearchColumnIndex, SearchCallback
					params.GetPageCallback(EBAComboSearchNoRecords, list, params.SearchSubstring, params.SearchColumnIndex, params.SearchCallback);
				}
			} 
			catch (err) {

			}
			
			// Tell the user what happened. No new records found.
			list.SetFooterText(EbaComboUi[EbaComboUiNoRecords]);
			
			// Don't highlight any row if we can't find anything.
			list.SetActiveRow(null);
			
		}
		if (list.InitialSearchOnce == true && numNewRecords > 0) {
			list.InitialSearchOnce = false;
			var row = list.GetRow(0);
			list.SetActiveRow(row);
			list.SetSelectedRowValues(null, row);
			list.SetSelectedRowIndex(0);
			var tb = co.GetTextBox();
			tb.SetValue(list.GetSelectedRowValues()[tb.GetDataFieldIndex()]);
		}

		list.m_httpRequestReady = true;
		// Set paging to false so that the textbox can continue using keys.
		// This is not a good solution. See bug 943.
		t.Paging = false;
}

/**
 * Searches the list and returns the matching record index in the searchcallback. It first searches
 * the local cache if the cache is not dirty. If nothing is found in the local cache, it tries to retrieve data from the server.
 * @param {String} SearchSubString The string used to match.
 * @param {Int} SearchColumnIndex The column we search on.
 * @private
 */
nitobi.combo.List.prototype.Search = function(SearchSubstring, SearchColumnIndex, SearchCallback, CacheOnly)
{
	var combo = this.GetCombo();
	var xmlDatasource = this.GetXmlDataSource();
	if(combo.mode!="default" && SearchSubstring=="")
	{
		this.Hide();
		return;
	}
	if (null == CacheOnly)
	{
		CacheOnly =	false;
	}
	eval(this.GetOnBeforeSearchEvent());
	var index = -1;

	// Search the cache if its clean.
	// All modes use the cache. Some modes are stricter than others at
	// what they consider to be a dirty cache. For instance, smartsearch
	// always updates the cache for each search.
	// Unbound mode should never declare cache to be dirty.
	// A dirty cache is searched if db lookups are disabled.
	// This assert is true. TODO. For now, we always search unbound cache.

	if (!this.GetEnableDatabaseSearch() || !xmlDatasource.m_Dirty || combo.mode == "unbound")
	{
		index = xmlDatasource.Search(SearchSubstring, SearchColumnIndex, combo.mode=="smartsearch" || combo.mode=="smartlist");
		// workaround: when list goes blank (in filter mode) due to a previous non-match and then
		// the user types something that results in match(es), then list won't be shown; below
		// fixes this
		if(index > -1 && this.InitialSearchOnce!=true)
		{
			this.Show();
		}
		if (-1 != index)
		{
			if (SearchCallback)
			{
				try
				{
					// We found something, so callback with the result.
					SearchCallback(index,this);
				}
				catch(err)
				{

				}
			}	
			// If we've found something, then this Event is called for sure.
			eval(this.GetOnAfterSearchEvent());
		}
		if (-1 == index && (false == this.GetEnableDatabaseSearch() || CacheOnly))
		{
			if (SearchCallback)
			{
				try
				{
					// We found something, so callback with the result.
					SearchCallback(index,this);
				}
				catch(err)
				{

				}
			}
			// If we've found nothing, and we wont do a db search then this Event is called for sure.
			eval(this.GetOnAfterSearchEvent());
		}
	}
	// save search substring for text bolding
	this.searchSubstring = SearchSubstring;
	if ((-1 == index) && (this.GetEnableDatabaseSearch()==true && (CacheOnly == false)))
	{
		var timeoutStatus=this.GetDatabaseSearchTimeoutStatus();
		var timeoutCode =	"var list = document.getElementById('" + combo.GetId() + "').object.GetList(); " +
							"list.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_EXPIRED);" +
							"var textbox = document.getElementById('" + combo.GetId() + "').object.GetTextBox();"+
							"list.Search(textbox.GetSearchTerm(),textbox.GetDataFieldIndex(),textbox.m_Callback);";
		var timeoutId = this.GetDatabaseSearchTimeoutId();

		// Since we're now going to hit the database, and since the record starting point is
		// based on the search substring, save this term.
		combo.GetTextBox().SetIndexSearchTerm(SearchSubstring);

		// We don't want to do a db search immediately. Rather, since we may get multiple search calls,
		// lets wait until a certain time after the last call.
		switch(timeoutStatus){
			case(EBADatabaseSearchTimeoutStatus_EXPIRED):
			{
				// Do the search now. The wait period has expired.
				if (timeoutId != null)
					window.clearTimeout(timeoutId);
				this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_NONE);
				// Try get the page from the server. Because we want to get
				// the first page, we blow away the list.

				// This callback is for getpage. GetPage does an asynchronous fetch,
				// This is the callback to deal with the result.
				var callback=_ListGetPageCallback; 
				// Don't do this. It creates mem leaks.
				/*function(result, list)
					{
   
						if ((combo == null))
						{
							alert(EbaComboUi[EbaComboUiServerError]);
						}
						var list = combo.GetList();
						if (result==EBAComboSearchNewRecords)
						{
							// If the callback was successful, then the cache is now clean.
							// Search again. This will search the cache.
							list.Search(SearchSubstring, SearchColumnIndex, SearchCallback);
						}
						else
						{
							// No records were found, so use the search callback to tell the originator
							// of the search that nothing was found.
							SearchCallback(-1,list);
							// When no new records are found, the search has ended.
							list.Eval(list.GetOnAfterSearchEvent());
						}
					};*/
				
				this.GetPage(0, this.GetPageSize(), SearchSubstring, EBAScrollToTypeAhead,null,callback,SearchColumnIndex,SearchCallback);
				// I don't belive this is required anymore. GetPage always returns true.
				/*if(false==this.GetPage(0, this.GetPageSize(), SearchSubstring, EBAScrollToTypeAhead,null,callback,SearchColumnIndex,SearchCallback))
				{
					// httprequest still busy - settimeout as if new search came just in case this is the last search
					// or else last search won't go through
					this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_WAIT);
					var timeoutId = window.setTimeout(timeoutCode,EBADatabaseSearchTimeoutWait);
					this.SetDatabaseSearchTimeoutId(timeoutId);
				}*/


				break;
			}
			case(EBADatabaseSearchTimeoutStatus_WAIT):
			{
				// Keep waiting. A search request came before the timeout expired.

				// Keep waiting until the user finishes typing.
				if (timeoutId != null)
					window.clearTimeout(timeoutId);
				var timeoutId = window.setTimeout(timeoutCode,EBADatabaseSearchTimeoutWait);
				this.SetDatabaseSearchTimeoutId(timeoutId);
			}
			case(EBADatabaseSearchTimeoutStatus_NONE):
			{
//("Starting wait on " +  SearchSubstring);
				// This is a brand new search request. Wait for a little bit to
				// try and catch other more recent search requests.
				this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_WAIT);
				var timeoutId = window.setTimeout(timeoutCode,EBADatabaseSearchTimeoutWait);
				this.SetDatabaseSearchTimeoutId(timeoutId);
			}
		}
	}
}

/**
 * @private
 */
function _ListGetPageCallback(result, list, SearchSubstring, SearchColumnIndex, SearchCallback)
{
	if ((list == null))
	{
		alert(EbaComboUi[EbaComboUiServerError]);
	}

	if (result==EBAComboSearchNewRecords)
	{
		if (!list.IsFuzzySearchEnabled())
		{
			// If the callback was successful, then the cache is now clean.
			// Search again. This will search the cache.
			// Don't search if fuzzy search is on, because likely, no match will be made.
			list.Search(SearchSubstring, SearchColumnIndex, SearchCallback);
		}
		else
		{
			list.Show();
		}
	}
	else
	{

		// No records were found, so use the search callback to tell the originator
		// of the search that nothing was found.
		SearchCallback(-1,list);
		// When no new records are found, the search has ended.
		list.Eval(list.GetOnAfterSearchEvent());
	}
}

/**
 * Deletes all the items in the list.
 * This clears all items in the list, and sets the SelectedRowIndex to -1. 
 * It does not clear all items in the XmlDataSource cache. Use XmlDataSource.Clear to do this.
 * @see nitobi.combo.XmlDataSource#Clear
 * @see #GetPage
 */
nitobi.combo.List.prototype.Clear = function()
{
	var listBody = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
	listBody.innerHTML="";
	this.SetSelectedRowIndex(-1);
	this.SetSelectedRowValues(null);
}

/**
 * reserved for stretching the list. not currently used.
 * @private
 */
nitobi.combo.List.prototype.FitContent = function()
{
	var listBody = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
	var lastTable = listBody.childNodes[listBody.childNodes.length-1];
	var row=lastTable;
	while (row.childNodes[0] !=null && row.childNodes[0].className.indexOf("ComboBoxListColumnDefinition") == -1)
	{
		row = row.childNodes[0];
	}
	
	for (var i=0;i<row.childNodes.length;i++)
	{
		var width = nitobi.html.getWidth(row.childNodes[0]);
		if (this.widestColumn[i] < width)
		{
			this.widestColumn[i] = width;
		}
	}
}


/**
 * Adds a page to the list given some xml.
 * @param {String} PageXml The XML for the new page.
 * @private
 */
nitobi.combo.List.prototype.AddPage = function(PageXml, SearchSubstring)
{
	var datasource = this.GetXmlDataSource();
	var tmp=nitobi.xml.createXmlDoc(PageXml);
	var numNewRecords = tmp.selectNodes("//e").length;
	
	if (numNewRecords > 0)
	{
		var html = this.GetRowHTML(PageXml, SearchSubstring);
		var listBody = this.GetSectionHTMLTagObject(EBAComboBoxListBody);
		nitobi.html.insertAdjacentHTML(listBody,'beforeEnd',html,true);
		this.GenerateCss();
	}
	
	var numRecordsRetrieved = datasource.GetLastPageSize();
	// If the last page retrieved is smaller than the page size
	// hide the entire footer.
	if (0 == numNewRecords)
		this.SetFooterText(EbaComboUi[EbaComboUiEndOfRecords]);
	else
		this.SetFooterText(datasource.GetNumberRows() + EbaComboUi[EbaComboUiNumRecords]);
	
	this.AdjustSize();
	this.SetIFrameDimensions();
}

/**
 * Hides the footer section of the list.
 * @see #HideFooter
 */
nitobi.combo.List.prototype.HideFooter = function()
{
	var footer = this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
	var footerStyle = footer.style;
	//footerStyle.visibility = "hidden";
	footerStyle.display = "none";
}

/**
 * Shows the footer section of the list.
 */
nitobi.combo.List.prototype.ShowFooter = function()
{
	var footer = this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
	var footerStyle = footer.style;
	//footerStyle.visibility = "visible";
	footerStyle.display = "inline";
}

/**
 * Adds a row to the list.
 * This is equivalent to returning one row from the server datasource. This function
 * transforms the array into XML and adds the records to both the list (in order to display them) and also
 * to the XmlDataSource.  The array's length must equal the number of columns in the datasource. Note: This includes
 * values that aren't displayed in the list.
 * @param {Array} Values An array of values in the order that that the columns are defined
 * @see nitobi.combo.XmlDataSource#Clear
 * @see #Clear
 */
nitobi.combo.List.prototype.AddRow = function(Values)
{
	var xml="<root><e ";
	for (var i = 0; i < Values.length; i++)
	{
		xml += String.fromCharCode(i + 97) + "='" + nitobi.xml.encode(Values[i]) + "' ";
	}
	xml +=  "/></root>";
	this.GetXmlDataSource().AddPage(xml);
	this.AddPage(xml);
}

/**
 * Move up or down the list.
 * @param {Number} Action The key action you want to perform. It can be one of EBAMoveAction_UP or EBAMoveAction_DOWN.
 * @private
 */
nitobi.combo.List.prototype.Move = function(Action)
{
	var combo = this.GetCombo();
	var mode = combo.mode;

	// Some modes shouldn't drop down the list when you move. Only classic and unbound allow scrolling.
	// Additionally, if there is nothing in the textbox, smartsearch, smartlist, filter won't respond.
	if(mode=="compact" || this.GetXmlDataSource().GetNumberRows()==0 || (mode!="default" && mode!="unbound" && combo.GetTextBox().m_HTMLTagObject.value=="")) return false;
	var activeRow = this.GetActiveRow();
	this.Show();
	if (null == activeRow)
	{
		activeRow = this.GetRow(0,null);
	}
	else
	{
		var index = this.GetRowIndex(this.GetActiveRow());
		switch(Action){
			case(EBAMoveAction_UP):
			{
				index--;
				break;
			}
			case(EBAMoveAction_DOWN):
			{
				index++;
				break;
			}
			default:
			{

			}
		}
		if ((index >= 0) && (index < this.GetXmlDataSource().GetNumberRows()))
			activeRow = this.GetRow(index,null);
	}

	this.SetActiveRow(activeRow);
	this.ScrollIntoView(activeRow,false,true);
	return true;
}

/**
 * Returns a row given its index or id.
 * @param {Number} [Index] Set to null if not used. The index of the row.
 * @param {String} [Id] Set to null if not used. The id of the row.
 * @private
 */
nitobi.combo.List.prototype.GetRow = function(Index, Id)
{
	if (null != Index)
	{
		return document.getElementById("EBAComboBoxRow" + this.GetCombo().GetUniqueId() + "_" + Index);
	}
	if (null != Id)
		return document.getElementById(Id);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");
/**
 * Defines a column of the list
 * @class Describes the appearance and functioning of a column in the combo list.
 * @constructor
 * @param {HTMLElement} oNewListColumn The HTML object that represents ListColumnDefinition
 * @see nitobi.combo.Combo
 */
nitobi.combo.ListColumnDefinition = function(oNewListColumn)
{
	// in case we're passing in a user created oNewListColumn object vs. a HTML tag
	if(!oNewListColumn.getAttribute)
		oNewListColumn.getAttribute=function(a){return this[a];};

	var DEFAULTWIDTH="50px";
	var DEFAULTCSSCLASSNAME="ntb-combobox-list-column-definition";
	var DEFAULTCOLUMNTYPE="text";
	var DEFAULTIMAGEHANDLERURL="";
	var DEFAULTALIGN="left";
	var DEFAULTTEXTCOLOR="#000";


	var textcolor=(oNewListColumn ? oNewListColumn.getAttribute("TextColor") : null);
	((null == textcolor) || ("" == textcolor))
		? this.SetTextColor(DEFAULTTEXTCOLOR)
		: this.SetTextColor(textcolor);

	var align=(oNewListColumn ? oNewListColumn.getAttribute("Align") : null);
	((null == align) || ("" == align))
		? this.SetAlign(DEFAULTALIGN)
		: this.SetAlign(align);

	var width=(oNewListColumn ? oNewListColumn.getAttribute("Width") : null);
	((null == width) || ("" == width))
		? this.SetWidth(DEFAULTWIDTH)
		: this.SetWidth(width);

	var ihu=(oNewListColumn ? oNewListColumn.getAttribute("ImageHandlerURL") : null);
	((null == ihu) || ("" == ihu))
		? this.SetImageHandlerURL(DEFAULTIMAGEHANDLERURL)
		: this.SetImageHandlerURL(ihu);

	var ct=(oNewListColumn ? oNewListColumn.getAttribute("ColumnType") : null);
	((null == ct) || ("" == ct))
		? this.SetColumnType(DEFAULTCOLUMNTYPE)
		: this.SetColumnType(ct.toLowerCase());

//		if ((this.GetColumnType() == "image") && ((null == ihu) || ("" == ihu)))
//			alert("EBA Combo Error: You cannot have an image column without specifying the ImageHandlerURL");
	/**
	 * @private
	 */
	this.ImageUrlFromData = ((this.GetColumnType() == "image") && ((null == ihu) || ("" == ihu)));

	var ccn=(oNewListColumn ? oNewListColumn.getAttribute("CSSClassName") : null);
	((null == ccn) || ("" == ccn))
		? this.SetCSSClassName(DEFAULTCSSCLASSNAME)
		: this.SetCSSClassName(ccn);

	var hp=(oNewListColumn ? oNewListColumn.getAttribute("HTMLPrefix") : null);
	((null == hp) || ("" == hp))
		? this.SetHTMLPrefix("")
		: this.SetHTMLPrefix(hp);

	var hs=(oNewListColumn ? oNewListColumn.getAttribute("HTMLSuffix") : null);
	((null == hs) || ("" == hs))
		? this.SetHTMLSuffix("")
		: this.SetHTMLSuffix(hs);

	var hl=(oNewListColumn ? oNewListColumn.getAttribute("HeaderLabel") : null);
	((null == hl) || ("" == hl))
		? this.SetHeaderLabel("")
		: this.SetHeaderLabel(hl);

	var dfi=(oNewListColumn ? oNewListColumn.getAttribute("DataFieldIndex") : null);
	((null == dfi) || ("" == dfi))
		? this.SetDataFieldIndex(0)
		: this.SetDataFieldIndex(dfi);
}

/**
 * Returns the alignment of text in this column as one of left, right, or center.
 * <p>
 * If this property is changed after the Combo has loaded its records, future records will be
 * rendered according to the new ListColumnDefinition, but already rendered records will not change. 
 * </p>
 * If you want to re-render the list, you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * @type String
 * @see #SetAlign
 */
nitobi.combo.ListColumnDefinition.prototype.GetAlign = function(){
	return this.m_Align;
}

/**
 * Sets the alignment of text in this column as one of left, right, or center.
 * If this property is changed after the Combo has loaded its records, future records will be
 * rendered according to the new ListColumnDefinition, but already rendered records will not change. 
 * If you want to re-render the list, you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * @param {String} Align Alignment of text in this column. It can be one of left, right, or center.
 * @see #GetAlign
 */
nitobi.combo.ListColumnDefinition.prototype.SetAlign = function(Align){
	Align = Align.toLowerCase();
	if("right"!=Align && "left"!=Align && "center"!=Align)
		Align="left";
	this.m_Align = Align;
}

/**
 * Returns the color of the text in this column.
 * @type String
 */
nitobi.combo.ListColumnDefinition.prototype.GetTextColor = function(){
	return this.m_TextColor;
}

/**
 * Sets the color of the text in this column.
 * <p>
 * The default is #000; this can be any valid HTML color. If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new value,
 * but already rendered records will not change. 
 * </p>
 * <p>
 * If you want to re-render the list, you will have to first
 * clear the List and the XmlDatasource using the Clear methods.
 * </p>
 * @param {String} TextColor Any valid HTML color.
 */
nitobi.combo.ListColumnDefinition.prototype.SetTextColor = function(TextColor){
	this.m_TextColor = TextColor;
}

/**
 * Returns the HTML code that will be added after each row value in this column.
 * <p>
 * This is HTML code that is added after each value in each row of this column. This
 * can include any valid HTML code including closing tags that were written using the HTMLPrefix
 * property. 
 * </p>
 * If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new value,
 * but already rendered records will not change. If you want to re-render the list, 
 * you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * @type String
 * @see #GetHTMLPrefix
 * @see #SetHTMLSuffix
 * @see nitobi.combo.List.GetCustomHTMLDefinition
 */
nitobi.combo.ListColumnDefinition.prototype.GetHTMLSuffix = function(){
	return this.m_HTMLSuffix;
}

/**
 * Sets the HTML code that will be added after each row value in this column.
 * <p>
 * This is HTML code that is added after each value in each row of this column. This
 * can include any valid HTML code including closing tags that were written using the HTMLPrefix
 * property. 
 * </p>
 * <p>If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new value,
 * but already rendered records will not change. 
 * <br/>If you want to re-render the list, 
 * you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * </p>
 * @param {String} HTMLSuffix The HTML code that will be added after each row value in this column
 * @see #SetHTMLPrefix
 * @see #GetHTMLSuffix
 * @see nitobi.combo.List#GetCustomHTMLDefinition
 */
nitobi.combo.ListColumnDefinition.prototype.SetHTMLSuffix = function(HTMLSuffix){
	this.m_HTMLSuffix = HTMLSuffix;
}

/**
 * Returns the HTML code that will be added before each row value in this column.
 * <p>
 * This is HTML code that is added before each value in each row of this column. This
 * can include any valid HTML code including closing tags that were written using the HTMLSuffix
 * property. 
 * </p>
 * If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new value,
 * but already rendered records will not change. If you want to re-render the list, 
 * you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * @type String
 * @see #SetHTMLPrefix
 * @see #GetHTMLSuffix
 * @see nitobi.combo.List.GetCustomHTMLDefinition
 */
nitobi.combo.ListColumnDefinition.prototype.GetHTMLPrefix = function(){
	return this.m_HTMLPrefix;
}

/**
 * Sets the HTML code that will be added before each row value in this column.
 * This is HTML code that is added before each value in each row of this column. This
 * can include any valid HTML code including closing tags that were written using the HTMLSuffix
 * property. If this property is changed after the
 * Combo has loaded its records, future records will be rendered according to the new value,
 * but already rendered records will not change. If you want to re-render the list, 
 * you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * @param {String} HTMLPrefix Any valid HTML code
 * @see #GetHTMLPrefix
 * @see #SetHTMLSuffix
 * @see nitobi.combo.List.SetCustomHTMLDefinition
 */
nitobi.combo.ListColumnDefinition.prototype.SetHTMLPrefix = function(HTMLPrefix){
	this.m_HTMLPrefix = HTMLPrefix;
}

/**
 * Returns the name of the CSS class that defines the style for this column.
 * <p>
 * The default CSS class that all ListColumnDefinitions in all Combos is ComboBoxListColumnDefinition, which is stored in the CSS file. 
 * If you want to modify all combos on the page, you can modify this class. If you only want to affect one combo
 * you can copy this class and then set CSSClassName to the copy.
 * </p>
 * @type String
 * @see #SetCSSClassName
 */
nitobi.combo.ListColumnDefinition.prototype.GetCSSClassName = function(){
	return this.m_CSSClassName;
}

/**
 * Sets the name of the CSS class that defines the style for this column.
 * <p>
 * The default CSS class that all ListColumnDefinitions in all Combos is ComboBoxListColumnDefinition, which is stored in the CSS file. '
 * </p>
 * <p>
 * If you want to modify all combos on the page, you can modify this class. 
 * <br/>If you only want to affect one combo
 * you can copy this class and then set CSSClassName to the copy.  
 * <br/>If this property is changed after the Combo has loaded its records, future records will be
 * rendered according to the new ListColumnDefinition, but already rendered records will not change. 
 * <br/>If you want to re-render the list, 
 * you will have to call the {@link nitobi.combo.List#Clear} and the {@link nitobi.combo.XmlDatasource#Clear} methods.
 * </p>
 * @param {String} CSSClassName The name of the CSS class that defines the style for this column. Do not include the dot
 * @see #GetCSSClassName
 */
nitobi.combo.ListColumnDefinition.prototype.SetCSSClassName = function(CSSClassName){
	this.m_CSSClassName = CSSClassName;
}

/** 
 * Returns the type of the column. It can be one of TEXT or IMAGE.
 * If IMAGE is used, you must also specify the ImageHandlerURL property.
 * @type String
 * @see #GetImageHandlerURL
 * @see #SetColumnType
 */
nitobi.combo.ListColumnDefinition.prototype.GetColumnType = function(){
	return this.m_ColumnType;
}

/** 
 * Sets the type of the column. It can be one of TEXT or IMAGE.
 * If IMAGE is used, you must also specify the ImageHandlerURL property.
 * @param {String} ColumnType The type of the column. It can be one of 'TEXT' or 'IMAGE'
 * @see #SetImageHandlerURL
 * @see #GetColumnType
 */
nitobi.combo.ListColumnDefinition.prototype.SetColumnType = function(ColumnType){
	this.m_ColumnType = ColumnType;
}

/**
 * Returns the string displayed as the header for this column.
 * This allows you define headers for each column of data in the list. Use CustomHTMLHeader if you only want one header that spans all columns.
 * @type String
 * @see #SetHeaderLabel
 * @see nitobi.combo.List#GetCustomHTMLHeader
 */
nitobi.combo.ListColumnDefinition.prototype.GetHeaderLabel = function(){
	return this.m_HeaderLabel;
}

/**
 * Sets the string displayed as the header for this column.
 * This allows you define headers for each column of data in the list. Use CustomHTMLHeader if you only want one header that spans all columns.
 * @param {String} HeaderLabel The string displayed as the header for this column
 * @see #GetHeaderLabel
 */
nitobi.combo.ListColumnDefinition.prototype.SetHeaderLabel = function(HeaderLabel){
	this.m_HeaderLabel = HeaderLabel;
}

/**
 * Returns the width of the column. This can be an absolute pixel value, e.g., 15px or a percentage of the list width, e.g., 50%.
 * Wrapping is determined by the CSS class used to render the column. If you set this value to
 * a px value, you should ensure that the list width will be big enough to fit it.
 * @type String
 * @see #SetWidth
 * @see #GetCSSClassName
 * @see nitobi.combo.List#GetWidth
 */
nitobi.combo.ListColumnDefinition.prototype.GetWidth = function(){
	return this.m_Width;
}

/**
 * Sets the width of the column. This can be an absolute pixel value, e.g., 15px or a percentage of the list width, e.g., 50%.
 * Wrapping is determined by the CSS class used to render the column. If you set this value to
 * a px value, you should ensure that the list width will be big enough to fit it.
 * @param {String} Width The width of the column in HTML units
 * @see #GetWidth
 * @see #SetCSSClassName
 * @see nitobi.combo.List#SetWidth
 */
nitobi.combo.ListColumnDefinition.prototype.SetWidth = function(Width){
	this.m_Width = Width;
}

/**
 * Returns the index of the data field that populates this column. If you leave this field
 * empty, it will use the ordinal position of the ListColumnDefinition within the List.ListColumnDefinitions collection.
 * @type Number
 * @see #SetDataFieldIndex
 * @see nitobi.combo.Combo#GetDataTextField
 * @see nitobi.combo.Combo#GetDataValueField
 * @see nitobi.combo.TextBox#GetDataFieldIndex
 */
nitobi.combo.ListColumnDefinition.prototype.GetDataFieldIndex = function(){
	return this.m_DataFieldIndex;
}

/**
 * Sets the index of the data field that populates this column. If you leave this field
 * empty, it will use the ordinal position of the ListColumnDefinition within the List.ListColumnDefinitions collection.
 * @param {Number} DataFieldIndex The index of the data field that populates this column
 * @see #GetDataFieldIndex
 * @see nitobi.combo.TextBox#SetDataFieldIndex
 */
nitobi.combo.ListColumnDefinition.prototype.SetDataFieldIndex = function(DataFieldIndex){
	this.m_DataFieldIndex = DataFieldIndex;
}

/**
 * Returns the image url of the column.
 * <p>
 * If the ColumnType is IMAGE this property must be specfied. It contains the URL of a page that will serve up an image given an argument.
 * </p>
 * <p> 
 * The database column will contain image identifiers; this identifier will be used as an argument to the page, e.g. if the URL is
 * http://localhost/ImageServer.aspx?, then  combo will call it as follows http://localhost/ImageServer.aspx?Image=DataFromColumn.  
 * </p>
 * <p>
 * It will expect a binary image to be written out by the page. For example, the values in this column could be the id's of people
 * stored in the database.  When the combo is loaded the row value sends a request to the 
 * image handler, e.g. by calling http://localhost/ImageServer.aspx?Image=shiggens.  
 * <br/>
 * ImageServer.aspx
 * will check if shiggens is online, and, if so, send back an image specifying so.
 * </p>
 * @type String 
 * @see #GetColumnType
 * @see #SetImageHandlerURL
 */
nitobi.combo.ListColumnDefinition.prototype.GetImageHandlerURL = function(){
	return this.m_ImageHandlerURL;
}

/**
 * Sets the image url of the column.
 * <p>
 * If the ColumnType is IMAGE this property must be specfied. It contains the URL of a page that will serve up an image given an argument. 
 * The database column will contain image identifiers; this identifier will be used as an argument to the page, e.g. if the URL is
 * http://localhost/ImageServer.aspx?, then  combo will call it as follows http://localhost/ImageServer.aspx?Image=DataFromColumn.  
 * It will expect a binary image to be written out by the page. For example, the values in this column could be the id's of people
 * stored in the database.  
 * </p>
 * <p>
 * When the combo is loaded the row value sends a request to the 
 * image handler, e.g. by calling http://localhost/ImageServer.aspx?Image=shiggens.  ImageServer.aspx
 * will check if shiggens is online, and, if so, send back an image specifying so.
 * </p>
 * @param {String} ImageHandlerURL A URL to a page that supplies images
 * @see #SetColumnType
 * @see #GetImageHandlerURL
 */
nitobi.combo.ListColumnDefinition.prototype.SetImageHandlerURL = function(ImageHandlerURL){
	this.m_ImageHandlerURL = ImageHandlerURL;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");
 
/**
 * Creates a TextBox object to be associated with a parent {@link nitobi.combo.Combo}.
 * @class The textbox is the class that manages the text input part of the Nitobi ComboBox.  You shouldn't
 * have to instantiate this class from script, rather you can get a reference to one using {@link nitobi.combo.Combo#GetTextBox}
 * @constructor
 * @param {HTMLElement} userTag The HTML object that represents TextBox
 * @param {nitobi.combo.Combo} comboObject The combo object that is the owner of the textbox
 * @param {Boolean} hasButton true if the textbox has a button associated with it, false otherwise
 */
nitobi.combo.TextBox = function(userTag, comboObject, hasButton)
{
	var DEFAULTCLASSNAME = "";
	if (nitobi.browser.IE)
	{
		DEFAULTCLASSNAME="ntb-combobox-text-ie";
	}
	else
	{
		DEFAULTCLASSNAME="ntb-combobox-text-moz";
	}
	var DEFAULTWIDTH="100px";
	var DEFAULTHEIGHT="";
	var DEFAULTEDITABLE=true;
	var DEFAULTVALUE="";
	var DEFAULTDATAFIELDINDEX=0;
	var DEFAULTSEARCHTERM="";
	var DEFAULTONEDITKEYUP="";
	this.SetCombo(comboObject);
	
	var oeku=(userTag ? userTag.getAttribute("OnEditKeyUpEvent") : null);
	((null == oeku) || ("" == oeku))
		? this.SetOnEditKeyUpEvent(DEFAULTONEDITKEYUP)
		: this.SetOnEditKeyUpEvent(oeku);

	var width=(userTag ? userTag.getAttribute("Width") : null);
	((null == width) || ("" == width))
		? this.SetWidth(DEFAULTWIDTH)
		: this.SetWidth(width);

	var height=(userTag ? userTag.getAttribute("Height") : null);
	((null == height) || ("" == height))
		? this.SetHeight(DEFAULTHEIGHT)
		: this.SetHeight(height);

	var ccn=(userTag ? userTag.getAttribute("CSSClassName") : null);
	((null == ccn) || ("" == ccn))
		? this.SetCSSClassName(DEFAULTCLASSNAME)
		: this.SetCSSClassName(ccn);

	var editable=(userTag ? userTag.getAttribute("Editable") : null);
	((null == editable) || ("" == editable))
		? this.SetEditable(DEFAULTEDITABLE)
		: this.SetEditable(editable);

	var value=(userTag ? userTag.getAttribute("Value") : null);
	((null == value) || ("" == value))
		? this.SetValue(DEFAULTVALUE)
		: this.SetValue(value);

	var dataTextField = comboObject.GetDataTextField();
	if (dataTextField != null)
		this.SetDataFieldIndex(comboObject.GetList().GetXmlDataSource().GetColumnIndex(dataTextField));
	else{
		var dfi=(userTag ? userTag.getAttribute("DataFieldIndex") : null);
		((null == dfi) || ("" == dfi))
			? this.SetDataFieldIndex(DEFAULTDATAFIELDINDEX)
			: this.SetDataFieldIndex(dfi);
	}

	var st=(userTag ? userTag.getAttribute("SearchTerm") : null);
	if ((null == st) || ("" == st)){
		this.SetSearchTerm(DEFAULTSEARCHTERM);
		this.SetIndexSearchTerm(DEFAULTSEARCHTERM);
	}else{
		this.SetSearchTerm(st);
		this.SetIndexSearchTerm(st);
	}
	/**
	 * @private
	 * @ignore
	 */
	this.hasButton = hasButton;
	/**
	 * @private
	 * @ignore
	 */
	this.m_userTag = userTag;
}

/**
 * Actively unloads the object, and destroys owned objects.
 * @private
 */
nitobi.combo.TextBox.prototype.Unload = function()
{
	if (this.m_List)
	{
		delete this.m_List;
		this.m_List = null;
	}
	if (this.m_Callback)
	{
		delete this.m_Callback;
		this.m_Callback = null;
	}
	_EBAMemScrub(this);
}

/**
 * Returns the name of a custom CSS class to associate with the textbox. 
 * <p>
 * If this is left as an empty string, then the 'ComboBoxText' class is used.  
 * Refer to the CSS file for details on these classes, and which CSS attributes 
 * you must supply to use custom classes.  You can include custom classes by using 
 * the HTML style tags or by using a stylesheet.
 * </p>
 * @type String
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 * @see #SetCSSClassName
 */
nitobi.combo.TextBox.prototype.GetCSSClassName = function()
{
	return (null==this.m_HTMLTagObject ? this.m_CSSClassName : this.m_HTMLTagObject.className);
}

/**
 * Sets the name of a custom CSS class to associate with the textbox. 
 * If this is left as an empty string, then the 'ComboBoxText ComboBoxTextDynamic' classes are used.  
 * Refer to the CSS file for details on these classes, and which CSS attributes you must supply to use custom classes.  You can
 * include custom classes by using the HTML style tags or by using a stylesheet.
 * @example
 * &#102;unction swapTextBoxClass(comboId, newClass)
 * {
 * 	var textbox = nitobi.getComponent(comboId).GetTextBox();
 * 	textbox.SetCSSClassName(newClass);
 * }
 * @param {String} CSSClassName The name of a custom CSS class to associate with the textbox. Do not include the dot in the class name
 * @see nitobi.combo.Combo#SetCSSClassName
 * @see nitobi.combo.Button#SetDefaultCSSClassName
 * @see #GetCSSClassName
 */
nitobi.combo.TextBox.prototype.SetCSSClassName = function(CSSClassName)
{
	if(null==this.m_HTMLTagObject)
		this.m_CSSClassName = CSSClassName;
	else
		this.m_HTMLTagObject.className = CSSClassName;
}

/**
 * Returns the height of the text box in HTML units, e.g., 50px.
 * In classic mode, if you increase the height of the textbox, you should also increase the height
 * of the button. In all modes except smartlist, if you increase the height of the textbox, you should also
 * increase the size of the font in the CSS file.
 * @type String
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.List#GetHeight
 * @see nitobi.combo.Button#SetHeight
 * @see #SetHeight
 * @see #GetWidth
 */
nitobi.combo.TextBox.prototype.GetHeight = function()
{
	return (null == this.m_HTMLTagObject ? this.m_Height : nitobi.html.Css.getStyle(this.m_HTMLTagObject, "height"));
}

/**
 * Sets the height of the text box in HTML units, e.g., 50px.
 * In classic mode, if you increase the height of the textbox, you should also increase the height
 * of the button. In all modes except smartlist, if you increase the height of the textbox, you should also
 * increase the size of the font in the CSS file.
 * @param {String} Height The height of the text box in HTML units, e.g., 50px
 * @see nitobi.combo.Combo#GetHeight
 * @see nitobi.combo.List#GetHeight
 * @see nitobi.combo.Button#SetHeight
 * @see #GetHeight
 * @see #SetWidth
 */
nitobi.combo.TextBox.prototype.SetHeight = function(Height)
{
	if(null==this.m_HTMLTagObject)
		this.m_Height = Height;
	else
		this.m_HTMLTagObject.style.height = Height;
}

/**
 * Returns the width of the text box in HTML units.
 * If the combo is in smartlist mode, then this width is the width of the textbox.
 * When in smartlist mode, you can also set the width to a percentage. In this mode, however, this is equivalent to 
 * {@link nitobi.combo.Combo#GetWidth}.
 * @type String
 * @see nitobi.combo.Combo#GetWidth
 * @see nitobi.combo.List#GetWidth
 * @see nitobi.combo.Button#GetWidth
 * @see #SetWidth
 * @see #GetHeight
 */
nitobi.combo.TextBox.prototype.GetWidth = function()
{
	if(null==this.m_HTMLTagObject)
		return this.m_Width;
	else
		return nitobi.html.Css.getStyle(this.GetHTMLContainerObject(), "width");
}

/**
 * Sets the width of the text box in HTML units.
 * If the combo is in smartlist mode, then this width is the width of the textbox.
 * When in smartlist mode, you can also set the width to a percentage. In this mode, however, this is equivalent to 
 * {@link nitobi.combo.Combo#GetWidth}.
 * @param {String} Width The width of the text box in HTML units
 * @see nitobi.combo.Combo#GetWidth
 * @see nitobi.combo.List#SetWidth
 * @see nitobi.combo.Button#SetWidth
 * @see #GetWidth
 * @see #SetHeight
 */
nitobi.combo.TextBox.prototype.SetWidth = function(Width)
{
	this.m_Width = Width;
	if(null!=this.m_HTMLTagObject)
	{
		this.m_HTMLTagObject.style.width = Width;
	}
}

/**
 * The tag associated with the button. Only available after initialize.
 * @type HTMLNode
 * @private
 */
nitobi.combo.TextBox.prototype.GetHTMLTagObject = function()
{
	return this.m_HTMLTagObject;
}

/**
 * The tag associated with the button. Only available after initialize.
 * @param {HTMLNode} HTMLTagObject The value of the property you want to set.
 * @private
 */
nitobi.combo.TextBox.prototype.SetHTMLTagObject = function(HTMLTagObject)
{
	this.m_HTMLTagObject = HTMLTagObject;
}

/**
 * Returns the div containing the input field of the ComboBox
 * @type HTMLElement
 */
nitobi.combo.TextBox.prototype.GetHTMLContainerObject = function()
{
	return document.getElementById("EBAComboBoxTextContainer" + this.GetCombo().GetUniqueId());
}

/**
 * Returns true if the user can type in the textbox and false otherwise.
 * The rest of the combo is still navigable when this property is false, and a value will be displayed
 * in it once the user makes a selection.  Use this if you want the user to select a value from the list, and not type a custom value.
 * @type String
 * @see #SetEditable
 * @see nitobi.combo.Combo#GetEnabled
 */
nitobi.combo.TextBox.prototype.GetEditable = function()
{
	if(null==this.m_HTMLTagObject)
		return this.m_Editable;
	else
		return this.m_HTMLTagObject.getAttribute("readonly");
}

/** 
 * Sets the editable property of the textbox.
 * The rest of the combo is still navigable when this property is false, and a value will be displayed
 * in it once the user makes a selection.  Use this if you want the user to select a value from the list, and not type a custom value.
 * @param {Boolean} Editable true if the user can type in the textbox and false otherwise
 * @see #GetEditable
 * @see nitobi.combo.Combo#GetEnabled
 */
nitobi.combo.TextBox.prototype.SetEditable = function(Editable)
{
	if(null==this.m_HTMLTagObject)
	{
		this.m_Editable = Editable;
	}
	else
	{
		if (Editable == true)
		{
			this.m_HTMLTagObject.removeAttribute("readonly");
		}
		else
		{
			this.m_HTMLTagObject.setAttribute("readonly", "true");
		}
	}
}

/**
 * Returns the text value in the textbox.
 * This can be a custom value that the user has typed.  Setting this value does not
 * mean a specific list item will be selected. To check if the user has selected something
 * from the list, use {@link nitobi.combo.Combo#GetSelectedRowIndex}. To set a specific item from the list as selection, use
 * {@link nitobi.combo.List#SetSelectedRow} in conjunction with this property.
 * @type String
 * @see nitobi.combo.XmlDataSource#GetRow
 * @see #SetValue
 */
nitobi.combo.TextBox.prototype.GetValue = function()
{
	if(null==this.m_HTMLTagObject)
		return this.m_Value;
	else
		return this.m_HTMLTagObject.value;
}

/**
 * Sets the text value in the textbox.
 * Setting this value does not mean a specific list item will be selected. 
 * To check if the user has selected something
 * from the list, use {@link nitobi.combo.Combo#GetSelectedRowIndex}. To set 
 * a specific item from the list as selection, use
 * {@link nitobi.combo.List#SelectedRow} in conjunction with this property.
 * @param {String} Value The text value in the textbox
 * @param {Boolean} PutSmartListSeparator In smartlist mode, set this to true if you want the smartlist separator added to the end of the selection
 * @see nitobi.combo.XmlDataSource#GetRow
 * @see #GetValue
 */
nitobi.combo.TextBox.prototype.SetValue = function(Value, PutSmartListSeparator)
{
	if(null==this.m_HTMLTagObject)
	{
		this.m_Value = Value;
	}
	else
	{
		if(this.GetCombo().mode=="smartlist")
		{
			this.SmartSetValue(Value, PutSmartListSeparator);
		}
		else
		{
			this.m_HTMLTagObject.value = Value;
			// Set the hidden field for posting purposes.
			this.m_TextValueTag.value = Value;
		}
	}
}

/**
 * @private
 */
nitobi.combo.TextBox.prototype.SmartSetValue = function(Value, PutSmartListSeparator)
{
	var t = this.m_HTMLTagObject;
	var combo = this.GetCombo();
	var lio = t.value.lastIndexOf(combo.SmartListSeparator);
	if(lio > -1)
	{
		Value = t.value.substring(0,lio) + combo.SmartListSeparator + " " + Value;
	}
	if(PutSmartListSeparator)
	{
		Value += combo.SmartListSeparator + " ";
	}
	t.value = Value;
	this.m_TextValueTag.value = Value;
}

/**
 * Returns the index of the datafield (data column) to use as a datasource for the textbox.
 * When the user types in the textbox, the combo will search this column for a match. Similarly, when the
 * user clicks a row, this column's value will be entered into the textbox.
 * @type Number
 * @see #SetDataFieldIndex
 * @see nitobi.combo.ListColumnDefinition#GetDataFieldIndex
 * @see nitobi.combo.Combo#GetDataTextField
 * @see nitobi.combo.Combo#GetDataValueField
 */
nitobi.combo.TextBox.prototype.GetDataFieldIndex = function()
{
	return this.m_DataFieldIndex;
}

/**
 * Sets the index of the datafield (data column) to use as a datasource for the textbox.
 * When the user types in the textbox, the combo will search this column for a match. Similarly, when the
 * user clicks a row, this column's value will be entered into the textbox.
 * @param {Number} DataFieldIndex The index of the datafield (data column) to use as a datasource for the textbox
 * @see #GetDataFieldIndex
 * @see nitobi.combo.ListColumnDefinition#SetDataFieldIndex
 * @see nitobi.combo.Combo#GetDataTextField
 * @see nitobi.combo.Combo#GetDataValueField
 */
nitobi.combo.TextBox.prototype.SetDataFieldIndex = function(DataFieldIndex)
{
	this.m_DataFieldIndex = parseInt(DataFieldIndex);
}

/**
 * Returns the parent combo object.
 * This returns a handle to the Combo that owns the textbox.  
 * This is equivalent to the statement: <code>$ntb("ComboID").jsObject</code>.
 * @type nitobi.combo.Combo
 */
nitobi.combo.TextBox.prototype.GetCombo = function()
{
	return this.m_Combo;
}

/**
 * Set the parent Combo object.
 * @param {nitobi.combo.Combo} Combo The combo object to set as the parent.
 * @private
 */
nitobi.combo.TextBox.prototype.SetCombo = function(Combo)
{
	this.m_Combo = Combo;
}

/**
 * Returns the substring the user has typed in the combo box and is currently being used
 * to populate the list.
 * @type String 
 * @private
 */
nitobi.combo.TextBox.prototype.GetSearchTerm = function()
{
	return this.m_SearchTerm;
}

/**
 * The substring the user has typed in the combo box and is currently being used
 * to populate the list.
 * @param {String} SearchTerm The value of the property you want to set.
 * @private
 */
nitobi.combo.TextBox.prototype.SetSearchTerm = function(SearchTerm)
{
	this.m_SearchTerm = SearchTerm;
}

/**
 * This is the search term that was sent to the gethandler for the initial page
 * either when the combo is loaded or when the user searched for something that
 * was not in the local cache. It only changes when the combo does a db hit.
 * @type
 * @private
 */
nitobi.combo.TextBox.prototype.GetIndexSearchTerm = function()
{
	return this.m_IndexSearchTerm;
}

/**
 * This is the search term that was sent to the gethandler for the initial page
 * either when the combo is loaded or when the user searched for something that
 * was not in the local cache. It only changes when the combo does a db hit.
 * @param {String} IndexSearchTerm The value of the property you want to set.
 * @private
 */
nitobi.combo.TextBox.prototype.SetIndexSearchTerm = function(IndexSearchTerm)
{
	this.m_IndexSearchTerm = IndexSearchTerm;
}

/**
 * Fires when the user changes the text in the text box.
 * @param {Object} e An event object.
 * @private
 */
nitobi.combo.TextBox.prototype.OnChanged = function(e)
{
	this.m_skipBlur=true;
	var combo = this.GetCombo();
	var list = combo.GetList();
	list.SetActiveRow(null);
	var searchValue = this.GetValue();
	this.m_TextValueTag.value = searchValue;
	var previousSearchTerm = this.GetSearchTerm();
	
	if (combo.mode=="smartsearch" || combo.mode=="smartlist" || combo.mode=="filter" || combo.mode=="compact")
	{
		list.GetXmlDataSource().m_Dirty=true;
	}		

	if(combo.mode=="smartlist")
	{
		var lio = searchValue.lastIndexOf(combo.SmartListSeparator);
		if(lio > -1)
			searchValue = searchValue.substring(lio + combo.SmartListSeparator.length).replace(/^\s+/,"");
	}

	// Check to see if the user is widening their search. Eg. if the original
	// string was Joel Gerard, and they have search now for Joel,
	// we must hit the db since the cache might hit, but not hit all
	// instances of Joel.

	if ((previousSearchTerm.indexOf(searchValue) == 0 && previousSearchTerm != searchValue))
	{
		list.GetXmlDataSource().m_Dirty=true;
	}
	this.SetSearchTerm(searchValue);
	if(e!=null)
		this.prevKeyCode = e.keyCode;

	// Search the list and find a matching row.
	// Search based on the column we display in the textbox.
	var dfi = this.GetDataFieldIndex();
	var This = this;
	var currentKeyCode = (e != null ? e.keyCode : 0);
	this.m_CurrentKeyCode = currentKeyCode;
	this.m_List = list;
	
	this.m_Event = e;
	this.m_Callback= _TextboxCallback;
	this.m_skipBlur = false;
	// Don't do this. It creates mem leaks.
		/*function(searchResult, list)
		{
			try
			{
				// Reset the previously selected values.
				list.SetSelectedRowValues(null);
				list.SetSelectedRowIndex(-1);
				var row = null;
				if (searchResult > -1)
				{
					var rowId = "EBAComboBoxRow" + combo.GetUniqueId() + "_" + searchResult;
					row=list.ifd.getElementById(rowId);
					// 46 = del, 8 = backspace
					if(""!=searchValue && (null==e || (currentKeyCode!=46 && currentKeyCode!=8)) && (null!=e || (This.prevKeyCode!=46 && This.prevKeyCode!=8)) && combo.mode!="smartlist" && combo.mode!="smartsearch")
					{
						This.TypeAhead(list.GetXmlDataSource().GetRowCol(searchResult,dfi),This.GetSearchTerm().length,This.GetSearchTerm());
					}
					list.SetActiveRow(row);
				}
				if(e!=null && searchResult > -1 && list.InitialSearchOnce!=true)
				{
					list.Show();
					list.ScrollIntoView(row,true);
				}
				This.m_skipBlur=false;
			}
			catch(err)
			{

			}
		};*/
	this.m_List.Search(searchValue,dfi,this.m_Callback);
}

/**
 * @private
 */
function _TextboxCallback(searchResult, list)
{
	var combo = list.GetCombo();

	
	var tb = combo.GetTextBox();

	var e = tb.m_Event;

	var currentKeyCode = tb.m_CurrentKeyCode;
	
	// Reset the previously selected values.
	list.SetSelectedRowValues(null);
	list.SetSelectedRowIndex(-1);
	var searchValue = tb.GetSearchTerm();
	
	var tb = list.GetCombo().GetTextBox();
	var row = null;
	if (searchResult > -1)
	{
		var rowId = "EBAComboBoxRow" + combo.GetUniqueId() + "_" + searchResult;
		row=document.getElementById(rowId);
		// 46 = del, 8 = backspace
		if(""!=tb.searchValue && (null==e || (currentKeyCode!=46 && currentKeyCode!=8)) && (null!=e || (tb.prevKeyCode!=46 && tb.prevKeyCode!=8)) && combo.mode!="smartlist" && combo.mode!="smartsearch")
		{
			tb.TypeAhead(list.GetXmlDataSource().GetRowCol(searchResult,tb.GetDataFieldIndex()),tb.GetSearchTerm().length,tb.GetSearchTerm());
			list.SetSelectedRow(searchResult);
		}
		list.SetActiveRow(row);
	}
	if(e!=null && searchResult > -1 && list.InitialSearchOnce!=true)
	{
		list.Show();
		list.ScrollIntoView(row,true);
	}
	tb.m_skipBlur=false;
}

/**
 * @private
 */
nitobi.combo.TextBox.prototype.TypeAhead = function(txt)
{
	var t = this.m_HTMLTagObject;
	var x = nitobi.html.getCursor(t);

	// Some explanation required here:
	// This is a temporary thing. If you remove this, you will notice another
	// search thread will replace the value of the textbox, just before
	// setting the value given by the variable txt. Apparently,
	// the abort function in getpage doesn't do enough in cancelling
	// old search threads in favour of new.There maybe something wrong there.
	// This quick fix was due to 
	// time constraint. It is not ideal. It simply ignores older
	// search threads. These threads should be cancelled somehow though.
	// TODO: this is important.
	if (txt.toLowerCase().indexOf(t.value.toLowerCase()) != 0)
	{
		// This is an old search thread. Don't do anything more.
		return;
	}
	
	// IMPORTANT NOTE (raised by Alexei):
	// currently, we replace the user's input with the type-ahead text so
	// this kills any casing; this behavior is similar to Google Suggest;
	// ok for now (and perhaps even desirable);
	// IF there's a need to change this, simply take the user's
	// current input and append a substring of the type-ahead text instead
	this.SetValue(txt);
	nitobi.html.highlight(t,x);
}

/**
 * @private
 */
nitobi.combo.TextBox.prototype.OnMouseOver = function(firstTime)
{
	if (this.GetCombo().GetEnabled())
	{
		// Don't change the classname if height is 100%. 
		// IE BUG.	
		if (this.GetHeight() != "100%")
		{
			nitobi.html.Css.swapClass(this.GetHTMLContainerObject(), "ntb-combobox-text-dynamic", "ntb-combobox-text-dynamic-over");
			nitobi.html.Css.addClass(this.m_HTMLTagObject, "ntb-combobox-input-dynamic");
		}
		if(firstTime)
		{
			var b = this.GetCombo().GetButton();
			if(null!=b)
				b.OnMouseOver(null, false);
		}
	}
}

/**
 * @private
 */
nitobi.combo.TextBox.prototype.OnMouseOut = function(firstTime)
{
	if (this.GetCombo().GetEnabled())
	{
		// Don't change the classname if height is 100%. 
		// IE BUG.
		if (this.GetHeight() != "100%")
		{
			nitobi.html.Css.swapClass(this.GetHTMLContainerObject(), "ntb-combobox-text-dynamic-over", "ntb-combobox-text-dynamic");
			nitobi.html.Css.removeClass(this.m_HTMLTagObject, "ntb-combobox-input-dynamic");
		}
		if(firstTime)
		{
			var b = this.GetCombo().GetButton();
			if(null!=b)
			{
				b.OnMouseOut(null, false);
			}
		}
	}
}

/**
 * workaround: tells textbox not to call the user defined onfocus fnc in the next OnFocus()
 * @private
 */
nitobi.combo.TextBox.prototype.ToggleHidden = function()
{
	this.m_ToggleHidden = true;
}

/**
 * workaround: tells textbox to call the user defined onfocus fnc in the next OnFocus()
 * @private
 */
nitobi.combo.TextBox.prototype.ToggleShow = function()
{
	this.m_ToggleShow = true;
}

/**
 * Returns the HTML that is used to render the object.
 * @private
 */
nitobi.combo.TextBox.prototype.GetHTMLRenderString = function()
{
	// HTML For the textbox. Note that we only call blur if the mouse is not over the list.
	// Otherwise the blur cancels the onclick event for some reason.
	// keyup is used for the textbox.onchanged. this is better than the dhtml onchange.
	var c = this.GetCombo();
	var comboId = c.GetId();
	// Encode ' and " because they break the textbox rendering.
	var value = this.GetValue().replace(/\'/g,"&#39;").replace(/\"/g,"&quot;");
	// note:
	// - keeping <input type="text"></input><img></img> on the same line w/o any spaces, breaks, etc.
	// is important to ensuring that no gap appears between the two elements so do NOT put an
	// "\n" before/after this html bit
	// - of course, the <nobr></nobr> is necessary to keep the two together also (nobr is not
	// written in this context... see parent context)
	var w = this.GetWidth();
	var h = this.GetHeight();
	var smartlist = c.mode=="smartlist";
	var html="";

	// The style of the textbox.
	var textStyle;

	textStyle = (null!=w && ""!=w ? "width:"+w+";" : "")
				+ (null!=h && ""!=h ? "height:"+h+";" : "");

	// TextArea has a bug in IE whereby the width changes when set to a 100% when you type.
	// We have to wrap it in a span tag to control the width and height.
	
	html += "<div id=\"EBAComboBoxTextContainer" + this.GetCombo().GetUniqueId()+ "\" class=\"ntb-combobox-text-container ntb-combobox-text-dynamic\" style=\"" + (this.hasButton?"border-right:0px solid white;" : "") + (smartlist && nitobi.browser.IE?"width:" + w + ";":"") + "\">";
	if (smartlist && nitobi.browser.IE)
	{
		html+="<span style='" + textStyle + "'>";
		// Redefine the textarea style to fill the span.
		textStyle="width:100%;height:"+h+";overflow-y:auto;";
	}
	html+="<" + (smartlist==true ? "textarea" : "input") + " id=\"EBAComboBoxText" + comboId + "\" name=\"EBAComboBoxText" + comboId + "\" type=\"TEXT\" class='"
		+ this.GetCSSClassName() + "' " +(this.GetEditable().toString().toLowerCase()=="true" ? "" : "readonly='true'") + " AUTOCOMPLETE='OFF' value='"
		+ value + "'  "
		+ "style=\"" + textStyle + "\" "
		+ "onblur='var combo=document.getElementById(\""+comboId+"\").object; if(!(combo.m_Over || combo.GetList().m_skipBlur)) document.getElementById(\"" + comboId + "\").object.GetTextBox().OnBlur(event)' "
		+ "onkeyup='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnKeyOperation(event,0)' "
		+ "onkeypress='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnKeyOperation(event,1)' "
		+ "onkeydown='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnKeyOperation(event,2)' "
		+ "onmouseover='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnMouseOver(true)' "
		+ "onmouseout='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnMouseOut(true)' "
		+ "onpaste='window.setTimeout(\"document.getElementById(\\\"" + comboId + "\\\").object.GetTextBox().OnChanged()\",0)' "
		+ "oninput='window.setTimeout(\"document.getElementById(\\\"" + comboId + "\\\").object.GetTextBox().OnChanged()\",0)' "
		+ "onfocus='document.getElementById(\"" + comboId + "\").object.GetTextBox().OnFocus()' "
		// I removed the closing "</input>" to IE 7 from losing focus and then editing the listbox table itself.
		+ "tabindex='" + c.GetTabIndex() + "'>" + (smartlist==true ? value : "") + (smartlist==true ? "</textarea>" : "")
		// Create a hidden field for posting purposes. When the textbox is disabled
		// it doesn't post.
		+ "<input id=\"EBAComboBoxTextValue" + comboId + "\" name=\""+comboId+"\" type=\"HIDDEN\" value=\""+value+"\">";
	
	html += "</div>";
	if(smartlist && nitobi.browser.IE)
	{
		html+="</span>";
	}
	return html;
}

/**
 * Initializes the object after creation.
 * @private
 */
nitobi.combo.TextBox.prototype.Initialize = function()
{
	this.m_ToggleHidden=false;
	this.m_ToggleShow=false;
	this.focused=false;
	this.m_skipBlur=false;
	this.m_skipFocusOnce=false;
	this.prevKeyCode = -1;
	this.skipKeyUp=false;
	this.SetHTMLTagObject(document.getElementById("EBAComboBoxText" + this.GetCombo().GetId()));

	/// <property name="m_TextValueTag" type="object" access="private" default="" readwrite="readwrite">
	/// <summary>
	/// This is a handle to the hidden field that is used to post the textbox value.
	/// </summary>
	/// </property>
	this.m_TextValueTag = document.getElementById("EBAComboBoxTextValue"+this.GetCombo().GetId());

	if(!this.GetCombo().GetEnabled())
	{
		this.Disable();
	}
	// Don't user this after init. Use the proper accessors.
	this.m_userTag = null;
}

/**
 * Disables user interaction with the textbox.
 * @private
 */
nitobi.combo.TextBox.prototype.Disable = function()
{
	nitobi.html.Css.swapClass(this.GetHTMLContainerObject(), "ntb-combobox-text-container", "ntb-combobox-text-container-disabled");
	nitobi.html.Css.addClass(this.m_HTMLTagObject, "ntb-combobox-input-disabled");
	this.m_HTMLTagObject.disabled = true;
}

/**
 * Enables user interaction with the textbox.
 * @private
 */
nitobi.combo.TextBox.prototype.Enable = function()
{
	nitobi.html.Css.swapClass(this.GetHTMLContainerObject(), "ntb-combobox-text-container-disabled", "ntb-combobox-text-container");
	nitobi.html.Css.removeClass(this.m_HTMLTagObject, "ntb-combobox-input-disabled");
	this.m_HTMLTagObject.disabled = false;
}

/**
 * Fires when the textbox loses focus.
 * @private
 */
nitobi.combo.TextBox.prototype.OnBlur = function(e)
{
	var combo = this.GetCombo();
	var list = combo.GetList();
	if(this.m_skipBlur || combo.m_Over) return;
	this.focused=false;
	list.Hide();
	eval(combo.GetOnBlurEvent());
}

/**
 * Fires when the textbox gains focus.
 * @private
 */
nitobi.combo.TextBox.prototype.OnFocus = function(){
	//TODO:
	//combo = this.GetCombo();
	//combo.m_StateMgr.SetState(nitobi.components.combo.stateFocus, nitobi.components.combo.stateFocus_FOCUS);
	if(this.m_skipBlur || this.m_skipFocusOnce){
		this.m_skipFocusOnce=false;
		return;

	}
	this.focused=true;
	var isVisible;
	isVisible=this.GetCombo().GetList().IsVisible();
	if(!isVisible || this.m_ToggleShow){
		this.m_ToggleShow=false;
		if(this.m_ToggleHidden)
			this.m_ToggleHidden=false;
		else
			eval(this.GetCombo().GetOnFocusEvent());
	}
}

/**
 * Sets the javascript that is run when a pressed key is released
 * This function is called a key that modifies the contents of the textbox is released.
 * You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * TextBox html tag you can set it to: <code>OnEditKeyUpEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * TextBox object. You can then use {@link #GetCombo} to retrieve a handle to the combo object.
 * @param {String} eventHandler Valid javascript that is run when a pressed key is released
 * @see #GetOnEditKeyUpEvent
 */
nitobi.combo.TextBox.prototype.SetOnEditKeyUpEvent = function(eventHandler)
{
	this.m_OnEditKeyUpEvent=eventHandler;
}

/**
 * Returns the javascript that is run when a pressed key is released
 * This function is called a key that modifies the contents of the textbox is released.
 * You can set this property to be any valid javascript.
 * You can also set this property to return the 'this' pointer for the textbox object, for example, in the 
 * TextBox html tag you can set it to: <code>OnEditKeyUpEvent="MyFunction(this)"</code>.  'this' will refer to the 
 * TextBox object. You can then use {@link #GetCombo} to retrieve a handle to the combo object.
 * @type String
 * @see #SetOnEditKeyUpEvent
 */
nitobi.combo.TextBox.prototype.GetOnEditKeyUpEvent = function()
{
	return this.m_OnEditKeyUpEvent;
}

/**
 * Called when some kind of key event is fired.
 * @param {Object} e Either an event object in Mozilla or null in IE, in which case window.event will be used.
 * @param {Number} EventType The type of key event.
 * @private
 */
nitobi.combo.TextBox.prototype.OnKeyOperation = function(e,EventType)
{
	if (this.GetEditable() == "false")
	{
		return;
	}
	// in Moz, e!=null, in IE e==null
	e = e ? e : window.event;

	// Types of events this function is linked to.
	var EVENT_KEYUP=0;
	var EVENT_KEYPRESS=1;
	var EVENT_KEYDOWN=2;
	// Various keys on the keyboard. Not ASCII.
	var KEY_ENTER = 13;
	var KEY_ESC = 27;
	var KEY_TAB = 9;
	var KEY_a = 65;
	var KEY_z = 90;
	var KEY_0 = 48;
	var KEY_9 = 57;
	var KEY_DOWN = 40;
	var KEY_UP = 38;
	var KEY_DEL = 46;
	var KEY_BACKSPACE = 8;
	var KEY_SPACE = 32;
	var KEY_NUMPAD0 = 96;
	var KEY_NUMPAD9 = 105;
	var KEY_HOME = 36;
	var KEY_END = 35;
	var KEY_LEFT = 37;
	var KEY_RIGHT = 39;
	var KEY_F1 = 112;
	var KEY_F12 = 123;
	var KEY_SHIFT = 16;
	var KEY_CTRL = 17;
	var KEY_ALT = 18;
	var KEY_PGUP = 33;
	var KEY_PGDN = 34;
	
	var t=this.m_HTMLTagObject;
	var combo = this.GetCombo();
	var list = combo.GetList();

	var keyCode = e.keyCode;
	combo.SetEventObject(e);
	var dfi = this.GetDataFieldIndex();

	// Separate the events. We'll deal with keys in one specific event only.
	switch(EventType){
		case(EVENT_KEYUP):
		{
			if(KEY_ENTER != keyCode && KEY_ESC != keyCode && KEY_TAB != keyCode
				&& (keyCode < KEY_PGUP || keyCode > KEY_DOWN)
				&& (keyCode < KEY_F1 || keyCode > KEY_F12)
				&& (keyCode < KEY_SHIFT || keyCode > KEY_ALT))
			{
				// In smartsearch, the cache is always considered dirty because
				// it searches anywhere inside a string.
				// IS THIS TRUE? I don't think so!. TODO: look at this issue. it seems to
				// me that the same widening rules apply. If you search for dog anywhere in
				// the string, then hits for og and do will be in the cache. The one problem
				// is that the page get may not be big enough. hmmmm...Does smartsearch support
				// paging? We may be able to optimise here.
				if (combo.mode=="smartsearch" || combo.mode=="smartlist" || combo.mode=="filter" || combo.mode=="compact")
				{
					list.GetXmlDataSource().m_Dirty=true;
				}
				this.OnChanged(e);
				eval(this.GetOnEditKeyUpEvent());
			}
			if(keyCode==KEY_UP || keyCode==KEY_DOWN || keyCode==KEY_PGUP || keyCode==KEY_PGDN || keyCode==KEY_ENTER){
				if(this.smartlistWA==true)
					this.smartlistWA=false;
				else
				{
				// 2005.04.26
				// code below doesn't work for IE; but since we're going to be at the end of the line
				// anyways, let's use the t.value=t.value hack (moves cursor to the end of the line)
					if(nitobi.browser.IE)
						t.value=t.value;
					else
						nitobi.html.setCursor(t,t.value.length);
				}
			}
			if(combo.mode=="smartlist" && keyCode==KEY_ENTER && list.GetActiveRow()!=null)
			{
				this.SetValue(list.GetSelectedRowValues()[this.GetDataFieldIndex()], true);
				list.SetActiveRow(null);
			}
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
			if(combo.mode=="smartlist"){
				var lio = t.value.lastIndexOf(combo.SmartListSeparator);
				if(this.lio != lio)
					list.Hide();
				this.lio = lio;
			}
			break;
		}
		case(EVENT_KEYDOWN):
		{
			switch(keyCode){
				case(KEY_ENTER):
				{
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
					if(combo.mode=="smartlist"){
						var lio = t.value.lastIndexOf(combo.SmartListSeparator);
						if(lio != this.lio){
							list.Hide();
							break;
						}
					}
					this.m_skipBlur=true;
					list.SetActiveRowAsSelected();

					list.Hide();
					t.focus();
					
					// Always call this when the user has pressed enter.
					eval(combo.GetOnSelectEvent());
					// Since this function is called by multiple different events,
					// only trigger this code on keydown.
					nitobi.html.cancelEvent(e);
					this.m_skipBlur=false;
					break;
				}
				case(KEY_TAB):
				{
					list.Hide();
					eval(combo.GetOnTabEvent());
					
					
					// Check to see if the conditions that prevent blurring 
					// are true. If so, set them to false.
					// Otherwise, in some cases ontab is called but onblur is not.
					// This is most noticeable when the mouse is over the list and tab is pressed.
					if (this.m_skipBlur || combo.m_Over)
					{
						this.m_skipBlur = false;
						combo.m_Over = false;
					}
					list.SetActiveRowAsSelected();
					eval(combo.GetOnSelectEvent());
					break;
				}
				case(KEY_ESC):
				{
					// Since this function is called by multiple different events,
					// only trigger this code on keydown.
					list.Hide();
					break;
				}
				case(KEY_UP):
				{
					if(this.Paging==true)
						break;
					var isVisible;
					isVisible=list.IsVisible();
					if(combo.mode=="smartlist" && ! isVisible){
						this.smartlistWA=true;
						break;
					}
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
					if(combo.mode=="smartlist"){
						var lio = t.value.lastIndexOf(combo.SmartListSeparator);
						if(lio != this.lio){
							list.Hide();
							break;
						}
					}
					this.m_skipBlur=true;
					this.cursor=nitobi.html.getCursor(t);
					if(true==list.Move(EBAMoveAction_UP)){
						t.focus();
						this.SetValue(list.GetXmlDataSource().GetRowCol(list.GetRowIndex(list.GetActiveRow()),dfi));
					}
					this.m_skipBlur=false;
					break;
				}
				case(KEY_DOWN):
				{
					if(this.Paging==true)
						break;
					var isVisible;
					isVisible=list.IsVisible();
					if(combo.mode=="smartlist" && ! isVisible){
						this.smartlistWA=true;
						break;
					}
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
					if(combo.mode=="smartlist"){
						var lio = t.value.lastIndexOf(combo.SmartListSeparator);
						if(lio != this.lio){
							list.Hide();
							break;
						}
					}
					this.m_skipBlur=true;
					this.cursor=nitobi.html.getCursor(t);
					var r = list.GetActiveRow();
					if(null!=r && list.GetRowIndex(r)==list.GetXmlDataSource().GetNumberRows()-1 && true==list.GetAllowPaging() && combo.mode=="default"){
						// need to clear the current active row NOW
						// or else if cleared after paging, a visual artifact appears in FireFox
						list.SetActiveRow(null);
						// this.Paging is needed to prevent user from cursoring thru the list
						// while paging is occuring (otherwise visual artifacts can appear)
						this.Paging=true;
						list.OnGetNextPage(EBAScrollToNewBottom, true);
					}
					else if(true==list.Move(EBAMoveAction_DOWN)){
						t.focus();
						this.SetValue(list.GetXmlDataSource().GetRowCol(list.GetRowIndex(list.GetActiveRow()),dfi));
					}
					this.m_skipBlur=false;
					break;
				}
				case(KEY_PGUP):
				{
					if(this.Paging==true)
						break;
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
					if(combo.mode=="smartlist"){
						var lio = t.value.lastIndexOf(combo.SmartListSeparator);
						if(lio != this.lio){
							list.Hide();
							break;
						}
					}
					this.m_skipBlur=true;
					var b = nitobi.Browser;
					var lb = list.GetSectionHTMLTagObject(EBAComboBoxListBody);
					var isVisible;
					isVisible=list.IsVisible();
					if(isVisible){
						var r = list.GetActiveRow() || list.GetRow(0);
						if(null!=r){
							var idx = list.GetRowIndex(r);
							while(0!=idx){
								r = list.GetRow(--idx);
								if(! b.IsObjectInView(r,lb))
									break;
							}
							b.ScrollIntoView(r,lb,false,true);
							list.SetActiveRow(r);
							this.SetValue(list.GetXmlDataSource().GetRowCol(idx,dfi));
						}
					}
					this.m_skipBlur=false;
					break;
				}
				case(KEY_PGDN):
				{
					if(this.Paging==true)
						break;
// 2005.04.27
// due to time constraints, we had to settle w/ this workaround - please fix if you think it's necessary
					if(combo.mode=="smartlist"){
						var lio = t.value.lastIndexOf(combo.SmartListSeparator);
						if(lio != this.lio){
							list.Hide();
							break;
						}
					}
					var isVisible;
					isVisible=list.IsVisible();
					if(!isVisible){
						if(combo.mode!="smartlist")
							list.Show();
					}
					else{
						this.m_skipBlur=true;
						var b = nitobi.Browser;
						var lb = list.GetSectionHTMLTagObject(EBAComboBoxListBody);
						var r = list.GetActiveRow() || list.GetRow(0);
						var idx = list.GetRowIndex(r);
						var end = list.GetXmlDataSource().GetNumberRows() - 1;
						while(idx!=end){
							r=list.GetRow(++idx);
							if(! b.IsObjectInView(r,lb))
								break;
						}
						if(idx==end && true==list.GetAllowPaging() && combo.mode=="default"){
							// need to clear the current active row NOW
							// or else if cleared after paging, a visual artifact appears in FireFox
							list.SetActiveRow(null);
							// this.Paging is needed to prevent user from cursoring thru the list
							// while paging is occuring (otherwise visual artifacts can appear)
							this.Paging=true;
							list.OnGetNextPage(EBAScrollToNewTop, true);
						}else{
							b.ScrollIntoView(r,lb,true,false);
							list.SetActiveRow(r);
							this.SetValue(list.GetXmlDataSource().GetRowCol(idx,dfi));
						}
						this.m_skipBlur=false;
					}
					break;
				}
				default:
				{

				}
			}
			break;
		}
		case(EVENT_KEYPRESS):
		{
			// to prevent artifacts in FireFox where a vertical scrollbar appears briefly
			// as the cursor moves to the next line due to ENTER before we actually
			// move the cursor back to the current line; unnecessary to have ENTER
			// key bubbled up anyways
			if(keyCode==KEY_ENTER)
				nitobi.html.cancelEvent(e);
			break;
		}
		default:
		{
		}
	}
	combo.SetEventObject(null);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */


nitobi.lang.defineNs("nitobi.browser");

// extend Document to mimic IE's loadXML()
if(!nitobi.browser.IE){
	/**
	 * @private
	 * @ignore
	 */
	Document.prototype.readyState=0;
	/**
	 * @private
	 * @ignore
	 */
	Document.prototype.__load__=Document.prototype.load;
	/**
	 * @private
	 * @ignore
	 */
	Document.prototype.load=_Document_load;
	/**
	 * @private
	 * @ignore
	 */
	Document.prototype.onreadystatechange=null;
	// mimic IE's .uniqueID
	/**
	 * @private
	 * @ignore
	 */
	Node.prototype._uniqueID=null;
	/**
	 * @private
	 * @ignore
	 */
	Node.prototype.__defineGetter__("uniqueID",_Node_getUniqueID);
}

// <function name="_Document_load" access="private">
// <summary>Wraps Document.load() with cross browser code</summary>
// </function>
/**
 * @private
 * @ignore
 */
function _Document_load(strURL){

	changeReadyState(this,1);
	try{
		this.__load__(strURL);
	}catch(e){
		changeReadyState(this,4);
	}
}

// <function name="changeReadyState" access="private">
// <summary>Mimics IE's ready state</summary>
// </function>
/**
 * @private
 * @ignore
 */
function changeReadyState(oDOM,iReadyState){ 
	// 0 = uninitialized
	// 1 = loading
	// 4 = completed
    oDOM.readyState=iReadyState;
    // fire event
    if (oDOM.onreadystatechange!=null && (typeof oDOM.onreadystatechange)=="function")
        oDOM.onreadystatechange();
}

// <function name="_Node_getUniqueID" access="private">
// <summary>Document's extended uniqueID property, to mimic IE</summary>
// </function>
/**
 * @private
 * @ignore
 */
_Node_getUniqueID.i = 1;
/**
 * @private
 * @ignore
 */
function _Node_getUniqueID(){
	if (null==this._uniqueID)
		this._uniqueID="mz__id"+_Node_getUniqueID.i++;
	return this._uniqueID;
}

/**
 * @private
 * @ignore
 */
function XmlDataIslands()
{
	// This function does nothing. It should not be called. It is only here becuase
	// it was put in a lot of sample for V3, but was a bad idea.
}

// xml clipping stuff
/**
 * @private
 * @ignore
 */
function xbClipXml(oXml, parent, child, clipLength){
	var xsl = "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:template match=\""+parent+"\"><xsl:copy><xsl:copy-of select=\"@*\"></xsl:copy-of><xsl:apply-templates select=\""+child+"\"></xsl:apply-templates></xsl:copy></xsl:template><xsl:template match=\""+child+"\"><xsl:choose><xsl:when test=\"position()&lt;="+clipLength+"\"><xsl:copy-of select=\".\"></xsl:copy-of></xsl:when></xsl:choose></xsl:template></xsl:stylesheet>";
	var x = nitobi.xml.createXmlDoc(xsl);
	return nitobi.xml.transformToXml(oXml, x);
}

nitobi.Browser.ConvertXmlDataIsland = function (XmlId, method /* See EncodeAngleBrackets above for an exp of combo object param*/)
{
	if (null != XmlId && "" != XmlId)
	{
		var xmls = document.getElementById(XmlId);


		if (null != xmls)
		{
			var id = xmls.getAttribute("id");
			var src = xmls.getAttribute("src");
			var d;
			if(null==src)
			{
				// parse out whitespace between xml tags
				d = nitobi.xml.createXmlDoc(this.EncodeAngleBracketsInTagAttributes(xmls.innerHTML.replace(/>\s+</g,"><")));
			}
			else
			{
				// Load the document and remove any junk before the XML declaration.
				var loadedXml = nitobi.Browser.LoadPageFromUrl(src,method);
				var declaredXmlIndex = loadedXml.indexOf("<?xml");
				if (declaredXmlIndex != -1)
					loadedXml = (loadedXml.substr(declaredXmlIndex));
				d = nitobi.xml.createXmlDoc(loadedXml);
				var d2 = nitobi.xml.createXmlDoc(this.EncodeAngleBracketsInTagAttributes(d.xml.replace(/>\s+</g,"><")));
				d = d2;
			}

			// xml data island's tags will no longer be a part of the doc
		//		xmls.parentNode.removeChild(xmls);
			// instead, "xml data island" now accessible via document.id;
			// just specifying id by itself won't resolve because .id was added
			// to document via dom rather than it being a tag in doc
			document[id]=d;
			// removeChild() above seems to remove EVERYTHING on i=0; probably
			// because in Moz, it takes a greedy approach and assumes the last
			// </xml> ends this current <xml>...</xml>; below, everything should
			// be removed on the first iteration anyway; but we leave code like
			// it is below because if the above scenario is true, then xmls.length
			// == 0 on the i=1 anyway
			var p = (xmls.parentNode ? xmls.parentNode : xmls.parentElement);
			p.removeChild(xmls);
		}
	}
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.combo");

/**
 * The XML data source manages the local XML cache.  It doesn't have anything to do
 * with any other datasource.  It is used directly by the list to manage the
 * client side data. The XML stored in this object is compressed EBA XML in the form:
 * <pre class="code">
 * 	&lt;e xk="1" a="The Clash" b="London Calling"/&gt;
 * 	&lt;e xk="2" a="Elvis Costello" b="Armed Forces"/&gt;
 * 	&lt;e xk="3" a="XTC" b="Black Sea"/&gt;
 * &lt;/root&gt;
 * </pre>
 * @class The client side data source for the List
 * @constructor
 * @param {HTMLElement} userTag The HTML object that represents ListColumnDefinition
 * @param {Boolean} clip Whether or not to clip list
 * @param {Number} clipLength The clip length to use to clip the list
 * @param {nitobi.combo.Combo} comboObject The owner combo object
 */
nitobi.combo.XmlDataSource = function()
{
	/**
	 * @private
	 */
	this.combo = null;
	/**
	 * @private
	 */
	this.m_Dirty = true;

	this.SetLastPageSize(0);
	this.SetNumberColumns(0);
}

/**
 * Returns the ID of the XML data-island on the page.
 * Typically, the XML data is stored on the HTML page itself in what is referred to 
 * as an XML data island, that is, XML enclosed by XML tags.  This is the ID of that dataisland.
 * @type String
 */
nitobi.combo.XmlDataSource.prototype.GetXmlId = function()
{
	return this.m_XmlId;
}

/**
 * Sets the ID of the XML data-island on the page.
 * Typically, the XML data is stored on the HTML page itself in what is referred to 
 * as an XML data island, that is, XML enclosed by XML tags.  This is the ID of that dataisland.
 * @param {String} XmlId The id of the xml data island
 * @private
 */
nitobi.combo.XmlDataSource.prototype.SetXmlId = function(XmlId)
{
	this.m_XmlId = XmlId;
}

/**
 * Returns the XML DOM object.
 * The type of this object changes depending on the type of the browser.
 * In Internet Explorer it is the latest version (up to version 4) of the Microsoft XML DOM, e.g.,
 * Msxml4.DOMDocument. For Mozilla based browsers, this is the standard XML doc document. Note: Some
 * text in the document is escaped.
 * @example
 * var list = nitobi.getComponent('combo1').GetList();
 * var xmlDataSource = list.GetXmlDataSource();
 * var xmlDoc = xmlDataSource.GetXmlObject();
 * // Gives us the xml node with xk equal to 47858
 * var node = xmlDoc.selectSingleNode('//e[&amp;xk=47858]');
 * node.setAttribute('a', 'London Calling');
 * @type XMLDocument
 * @see nitobi.combo.XmlDataSource#.GetRow
 */
nitobi.combo.XmlDataSource.prototype.GetXmlObject = function()
{
	return this.m_XmlObject;
}

// TODO: This function is private until AddPage is public.
/**
 * Sets the XML DOM object.
 * The type of this object changes depending on the type of the browser.
 * In Internet Explorer it is the latest version (up to version 4) of the Microsoft XML DOM, e.g.,
 * Msxml4.DOMDocument. For Mozilla based browsers, this is the standard XML doc document. Note: Some
 * text in the document is escaped.
 * @param {XMLDocument} XmlObject The XML document
 * @param {Number} clip Whether or not to clip list
 * @param {Boolean} clipLength The clip length to use to clip the list
 * @private
 */
nitobi.combo.XmlDataSource.prototype.SetXmlObject = function(XmlObject, clip, clipLength)
{
	if(null==XmlObject.documentElement) return;
	if(clip==true)
		XmlObject = xbClipXml(XmlObject, "root", "e", clipLength);
	this.m_XmlObject = XmlObject;
	// Since the whole object was blown away, treat this like a getpage.
	// Set the page size to number of rows we receive initially.
	// Here we assume that the initial data we receive is like a page
	// get.  We don't actually do a page get because we don't want
	// to copy our initial xml datasource.
	this.SetLastPageSize(this.GetNumberRows());

	var fields = XmlObject.documentElement.getAttribute("fields");
	if (null==fields){
		// TODO: How are we going to deal with exceptions in dontnet.
//			alert( "You must have at least one field in your dataset.  The root's 'fields' attribute was not set.");
	}else{
		var colNames = fields.split("|");
		this.SetColumnNames(colNames);
		this.SetNumberColumns(colNames.length);
	}
}

/**
 * Returns the number of rows currently in the dataset.
 * @type Number
 * @see #GetRow
 * @see #GetNumberColumns
 */
nitobi.combo.XmlDataSource.prototype.GetNumberRows = function()
{
	return this.GetXmlObject().selectNodes("//e").length;
}

/** 
 * Returns the size of the last page retrieved.
 * @type Number
 * @private
 */
nitobi.combo.XmlDataSource.prototype.GetLastPageSize = function()
{
	return this.m_LastPageSize;
}

/** 
 * Sets the size of the last page retrieved.
 * @param {Number} LastPageSize The size of the last page retrieved
 * @private
 */
nitobi.combo.XmlDataSource.prototype.SetLastPageSize = function(LastPageSize)
{
	this.m_LastPageSize = LastPageSize;
}

/**
 * Returns the number of columns in the dataset.
 * @type Number
 * @see #GetNumberRows
 */
nitobi.combo.XmlDataSource.prototype.GetNumberColumns = function()
{
	return this.m_NumberColumns;
}

/**
 * Sets the number of columns in the dataset.
 * @param {Number} NumberColumns The number of columns of the dataset
 * @private
 */
nitobi.combo.XmlDataSource.prototype.SetNumberColumns = function(NumberColumns)
{
	this.m_NumberColumns = parseInt(NumberColumns);
}

/**
 * Contains the list of column names.
 * @type Array
 * @private
 */
nitobi.combo.XmlDataSource.prototype.GetColumnNames = function()
{
	return this.m_ColumnNames;
}

/**
 * Contains the list of column names.
 * @param {Array} ColumnNames The value of the property you want to set.
 * @private
 */
nitobi.combo.XmlDataSource.prototype.SetColumnNames = function(ColumnNames)
{
	this.m_ColumnNames = ColumnNames;
}

/**
 * Searches the list and returns the ordinal value of the first matched row. Searches the local cache only.
 * @param {String} Value The value to match.
 * @param {Int} ColumnIndex The column to search on.
 * @param {Boolean} Smart Whether or not this is a "smart" mode search.
 */
nitobi.combo.XmlDataSource.prototype.Search = function(Value, ColumnIndex, Smart){

	Value = Value.toLowerCase();
	Value=nitobi.xml.constructValidXpathQuery(Value,true);

	// ** A few notes on this Search mechanism. **//
	// ** There is only one central xml datasource object. IE searches this datasource object using XSL. 
	// ** The XSL calls the js toLowerCase() function in order to do case-insensitive search.
	// ** Netscape has no such facility. For netscape, we must mirror the xml object and make a lower case version of it.
	// ** This is not done for IE because it is more error prone. I'm trying to minimize the risk here. Sometimes, people
	// ** modify the xml directly.
	var xsl="<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\">";
	xsl+="<xsl:output method=\"text\" />";
	xsl+="<xsl:template match=\"/\"><xsl:apply-templates select=\"//e[" + (Smart==true ? "contains" : "starts-with") + "(@"+String.fromCharCode(97 + parseInt(ColumnIndex))+"," + Value + ")][1]\"/></xsl:template>";
	xsl+="<xsl:template match=\"e\">";
	// Note this needs to be indexing from 0 not 1.
	xsl+="<xsl:value-of select=\"count(preceding-sibling::e)\" />";
	xsl+="</xsl:template>";
	xsl+="</xsl:stylesheet>";

	var oXSL=nitobi.xml.createXslProcessor(xsl);
	var searchXml = nitobi.xml.createXmlDoc(this.GetXmlObject().xml.replace(/>\s+</g,"><").toLowerCase());
	var index = nitobi.xml.transformToString(searchXml, oXSL);

	if("" == index)
		index = -1;
	return parseInt(index);
}

/**
 * Adds a page of XML to the local datasource.
 * @param {String} XML The xml page including the root tags.
 * @private
 */
nitobi.combo.XmlDataSource.prototype.AddPage = function(XML)
{
	// Got rid of the lower case XML crap for Netscape
	
	// Copy the XML into our local datasource.
	var tmp=nitobi.xml.createXmlDoc(XML);
	var newNodes = tmp.selectNodes("//e");
	var root = this.GetXmlObject().documentElement;
	// In the future we may support different page sizes. For now
	// this should be the same as the specified preset page size.
	this.SetLastPageSize(tmp.selectNodes("//e").length);
	for(var i=0; i<newNodes.length; i++)
	{
		// removed some lower case XML crap here
  		root.appendChild(newNodes[i].cloneNode(true));
  	}
  	
  	this.m_Dirty=false;
}

/**
 * Deletes all records in the XML cache.
 * This does not clear the rendered list. Use 
 * {@link nitobi.combo.List#Clear} to clear the rendered
 * list.
 * @example
 * &#102;unction clearCombo()
 * {
 * 	var combo = nitobi.getComponent('combo1');
 * 	combo.GetList().GetXmlDataSource().Clear();
 * 	combo.GetList().Clear();
 * }
 * @see nitobi.combo.List#AddRow
 */
nitobi.combo.XmlDataSource.prototype.Clear = function()
{
	// Removed stuff here to do with lower casing the XML for Firefox case sensitivity
	nitobi.xml.loadXml(this.GetXmlObject(), "<root/>", true);
}

/**
 * Returns a row from the dataset.
 * This returns a row from the XML cache. The ordinal position of the row
 * corresponds to the ordinal position of the row displayed in the list. If you want 
 * to get all rows, i.e., the entire dataset, you should use {@link #GetXmlObject}.
 * @example
 * var datasource = nitobi.getComponent('combo1').GetList().GetXmlDataSource();
 * var row = datasource.GetRow(0);
 * alert('The 3rd column of data: ' + row[2]);
 * @param {Number} Index The index of the row you want to retrieve. Indexed from zero
 * @type Array
 */
nitobi.combo.XmlDataSource.prototype.GetRow = function(Index)
{
	Index = parseInt(Index);
	var row = this.GetXmlObject().documentElement.childNodes.item(Index);
	var values = new Array;
	for (var i = 0; i < this.GetNumberColumns(); i++){
		values[i] = row.getAttribute(String.fromCharCode(97+i));
	}
	return values;
}

/**
 * Returns a value from a column from a row.
 * @param {Number} Row The index of the row you want to retrieve. Indexed from zero.
 * @param {Number} Col The index of the col you want to retrieve. Indexed from zero.
 * @private
 */
nitobi.combo.XmlDataSource.prototype.GetRowCol = function(Row,Col)
{
	var row = this.GetXmlObject().documentElement.childNodes.item(parseInt(Row));
	var val = row.getAttribute(String.fromCharCode(97+parseInt(Col)));
	return val;
}

/**
 * Returns a column index given its name.
 * @param {String} Name The name of the column whose index you want to find.
 * @private
 */
nitobi.combo.XmlDataSource.prototype.GetColumnIndex = function(Name)
{
	// better to default to col 0 (i.e. GetColumnIndex(null) now returns 0) than to fail and throw a fit
	if(Name==null)
		return 0;
		
	Name=Name.toLowerCase();
	var colNames = this.GetColumnNames();
	
	if (colNames != null){
		for (var i = 0 ; i < colNames.length ; i++){
			if (Name == colNames[i].toLowerCase()){
				return parseInt(i);
			}
		}
	}
	return -1;
}
