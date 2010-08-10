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
nitobi.lang.defineNs("nitobi.tabstrip");

if (false)
{
	/**
	 * @namespace The namespace for classes that make up the Nitobi Tabstrip component.
	 * @constructor
	 */
	nitobi.tabstrip = function(){};
}

/**
 * Creates a Nitobi Tabstrip.  Note: Some operations require that you call {@link #render} after changing 
 * some properties.  This is due to the expense of changing them and rendering them individually.
 * @class The base class for the Nitobi Tabstrip component.  You can create a Tabstrip through script or using the declaration.
 * A tabstrip declaration takes this form:
 * <pre class="code">
 * &lt;ntb:tabstrip id="SimpleTabstrip" width="800px" height="600px"&gt;
 * 	&lt;ntb:tabs height="" align="center" overlap="15"&gt;
 * 		&lt;ntb:tab width="190px" tooltip="Welcome." label="IFrame Tab" source="http://www.nitobi.com" containertype="iframe"&gt;&lt;/ntb:tab&gt;
 * 		&lt;ntb:tab width="190px" tooltip="Welcome." label="DOM Tab" source="tab2"&gt;&lt;/ntb:tab&gt;
 * 		&lt;ntb:tab width="190px" tooltip="Welcome." label="Ajax Tab" source="tab3.html" loadondemandenabled="true"&gt;&lt;/ntb:tab&gt;
 * 	&lt;/ntb:tabs&gt;
 * &lt;/ntb:tabstrip&gt;
 * &lt;div id="tab2"&gt;
 * 	&lt;h1&gt;DOM Tab&lt;/h1&gt;
 * 	&lt;img src="images/nitobi.jpg" /&gt;
 * &lt;/div&gt;
 * </pre>
 * @constructor
 * @example
 * var t1 = new nitobi.tabstrip.TabStrip("aUniqueId");
 * t1.setWidth("900px");
 * t1.setHeight("600px");
 * var tabs = new nitobi.tabstrip.Tabs();
 * var tab = new nitobi.tabstrip.Tab();
 * tab.setWidth("200px");
 * tab.setLabel("Nitobi");
 * tab.setContainerType("iframe");
 * tab.setSource("http://nitobi.com");
 * tabs.add(tab);
 * t1.setTabs(tabs);
 * t1.setContainer(container);
 * t1.render();
 * @param {String} [id] The id of the control. If you do not specify an id, one is created for you.
 * @extends nitobi.ui.Element
 */
nitobi.tabstrip.TabStrip = function(id) 
{
	nitobi.tabstrip.TabStrip.baseConstructor.call(this,id);
	this.renderer.setTemplate(nitobi.tabstrip.tabstripProc);
	
	
	/**
	 * Fired on click. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onClick = new nitobi.base.Event("click");
	this.eventMap["click"] = this.onClick;
	/**
	 * Fired on mouse out. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onMouseOut = new nitobi.base.Event("mouseout");
	this.eventMap["mouseout"] = this.onMouseOut;
	/**
	 * Fired on mouse over. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onMouseOver = new nitobi.base.Event("mouseover");
	this.eventMap["mouseover"] = this.onMouseOver;
	
	this.subscribeDeclarationEvents();
	
	/**
	 * @private
	 */
	this.renderTimes = 0;
	/**
	 * The version number.
	 * @private
	 * @type String
	 */
	this.version = "0.8";
	this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
}

nitobi.lang.extend(nitobi.tabstrip.TabStrip,nitobi.ui.Element);

/**
 * Information about the tabstrip class.
 * @private
 * @type nitobi.base.Profile
 */
nitobi.tabstrip.TabStrip.profile = new nitobi.base.Profile("nitobi.tabstrip.TabStrip",null,false,"ntb:tabstrip");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.TabStrip.profile);

/**
 * Returns the list of tabs for this tabstrip component.
 * @example
 * &#102;unction changeLabel()
 * {
 * 	var tabstrip = nitobi.getComponent('tabstrip1');
 * 	var tabs = tabstrip.getTabs();
 * 	var tab = tabs.get(0);
 * 	tab.setLabel("A new label for the 1st tab");
 * }
 * @type nitobi.tabstrip.Tabs
 */
nitobi.tabstrip.TabStrip.prototype.getTabs = function()
{
	return this.getObject(nitobi.tabstrip.Tabs.profile);
}

/**
 * Sets the tab collection for the Tabstrip object.
 * @example
 * var tabstrip = nitobi.getComponent("myTabstrip");
 * var tabs = new nitobi.tabstrip.Tabs();
 * var tab = new nitobi.tabstrip.Tab();
 * tab.setWidth("200px");
 * tab.setLabel("Nitobi");
 * tab.setContainerType("iframe");
 * tab.setSource("http://www.nitobi.com");
 * tabs.add(tab);
 * tabstrip.setTabs(tabs);
 * tabstrip.render();
 * @param {nitobi.tabstrip.Tabs} tabs The list of tabs.
 */
nitobi.tabstrip.TabStrip.prototype.setTabs = function(tabs)
{
	return this.setObject(tabs);
}


/**
 * Correctly fits the inside containers to the outside container. If 
 * you perform an operation on the outside container that modifies
 * its dimensions, you may need to call this function.
 * @see #setWidth
 * @see #setHeight
 * @see #render
 */
nitobi.tabstrip.TabStrip.prototype.fitContainers = function()
{
	try
	{
		var primary = this.getHtmlNode();
		if (primary)
		{
			var secondary = this.getHtmlNode("secondarycontainer");
			if (secondary)
			{
				
				var box = nitobi.html.getBox(primary);
				secondary.style.height = box.height + "px";
				secondary.style.width = box.width + "px";
			}
		}
	}
	catch(err)
	{
		//	nitobi.error.throwError(nitobi.error.Unexpected + " fitContainers failed",err)
	}
}

/**
 * Renders the tabstrip.  The first time the tabstrip is rendered, both the tabs and their 
 * body containers are rendered. On subsequent render calls, unless tabs are added and removed,
 * only the tabs are rendered. This prevents the user losing data in a tab body.
 */
nitobi.tabstrip.TabStrip.prototype.render = function()
{
	this.onBeforeRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
	if (this.renderTimes==0)
	{
		nitobi.tabstrip.TabStrip.base.render.call(this);
		var tabs = this.getTabs();
		this.onRender.subscribe(tabs.handleRender,tabs)
		tabs.loadTabs();
		var node = this.getHtmlNode();
		if (nitobi.browser.IE)
		{
			nitobi.html.attachEvent(node,"resize",this.fitContainers,this);
			nitobi.html.attachEvent(node,"resize",tabs.handleResize,tabs);
		}
		else
		{
			nitobi.html.attachEvent(window,"resize",this.fitContainers,this);
			nitobi.html.attachEvent(window,"resize",tabs.handleResize,tabs);
		}
	}
	else
	{
		var tabs = this.getTabs();
		tabs.render();
	}
	this.renderTimes++;
	this.onRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
	this.fitContainers();
	if (node) node.jsObject = this;
}

/**
 * Returns the width of the tabstrip e.g "500px"
 * @type String
 */
nitobi.tabstrip.TabStrip.prototype.getWidth = function()
{
	return this.getAttribute("width");
}

/**
 * Set the width of the tabstrip.  This change takes effect immediately; no
 * render is required. You may need to call fitContainers.
 * @example
 * &#102;unction changeWidth()
 * {
 * 	var tabstrip = nitobi.getComponent('tabstrip1');
 * 	tabstrip.setWidth("400px");
 * 	tabstrip.fitContainers();
 * }
 * @see #fitContainers
 * @param {String} width Any html measurement (in 'px' or '%').
 */
nitobi.tabstrip.TabStrip.prototype.setWidth = function(width)
{
	this.setAttribute("width",width);
	this.setStyle("width",width);	
}

/**
 * Returns the height of the tabstrip e.g "500px"
 * @type String
 */
nitobi.tabstrip.TabStrip.prototype.getHeight = function()
{
	return this.getAttribute("height");
}

/**
 * Set the height of the tabstrip. This change takes effect immediately; no
 * render is required. You may need to call {@link #fitContainers}.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code>
 * &#102;unction changeHeight()
 * {
 * 	var tabstrip = nitobi.getComponent('tabstrip1');
 * 	tabstrip.setHeight("400px");
 * 	tabstrip.fitContainers();
 * }
 * </code></pre>
 * </div>
 * @param {String} height Any html measurement.
 */
nitobi.tabstrip.TabStrip.prototype.setHeight = function(height)
{
	this.setAttribute("height",height);
	this.setStyle("height",height);	
}

/**
 * Returns the cssclass of the tabstrip.  Should use {@link #getTheme}.
 * @type String
 */
nitobi.tabstrip.TabStrip.prototype.getCssClass = function()
{
	return this.getAttribute("cssclass");
}

/**
 * Returns the theme of the tabstrip.
 * @type String
 */
nitobi.tabstrip.TabStrip.prototype.getTheme = function()
{
	return this.getAttribute("theme");
}

/**
 * Set the cssclass of the tabstrip. This change takes effect immediately; no
 * render is required. You may need to call fitContainers.
 * @see #fitContainers
 * @param {String} cssclass The classname.
 */
nitobi.tabstrip.TabStrip.prototype.setCssClass = function(cssclass)
{
	this.setAttribute("cssclass",cssclass);
	var node = this.getHtmlNode();
	if (node)
	{
		node.className = cssclass;
	}
}

/**
 * Set the theme of the tabstrip (same as setCssClass, added for clarity). This change takes effect immediately; no
 * render is required. You may need to call fitContainers.
 * @see #fitContainers
 * @param {String} theme The theme name.
 */
nitobi.tabstrip.TabStrip.prototype.setTheme = function(theme)
{
	this.setAttribute("theme",theme);
	var node = this.getHtmlNode();
	if (node)
	{
		node.className = theme;
	}
}

/**
 * Returns the css style of the tabstrip.  The css style is defined on the &lt;ntb:tabstrip&gt; tag to define some 
 * in line styling.
 * @type String
 */
nitobi.tabstrip.TabStrip.prototype.getCssStyle = function()
{
	return this.getAttribute("cssstyle");
}

/**
 * Set the css style of the tabstrip.
 * @param {String} cssstyle The style.
 */
nitobi.tabstrip.TabStrip.prototype.setCssStyle = function(cssstyle)
{
	this.setAttribute("cssstyle",cssstyle);
}

/**
 * Returns the tab index of the tabstrip.
 * @type Number
 */
nitobi.tabstrip.TabStrip.prototype.getTabIndex = function()
{
	return this.getAttribute("tabindex");
}

/**
 * @private
 */
nitobi.tabstrip.TabStrip.handleEvent = function(id, event, targetId, cancelBubble)
{
	try
	{
		var tabstrip = $ntb(id);
		if (tabstrip == null)
		{
			nitobi.lang.throwError("The tabstrip event could not find the component object.  The element with the specified id could not be found on the page.");
		}
		tabstrip = tabstrip.jsObject;
	    tabstrip.notify(event,targetId,null,cancelBubble);	
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected,err);
	}
}

/**
 * Precaches images found in the tabstrip's stylesheets.  Calling this function before loading
 * a tabstrip component will ensure that all the tabstrip's images are loaded before the tabstrip is rendered.
 * @param {String} url an optional url for your own tabstrip css file (just the filename)
 * @private
 */
nitobi.tabstrip.TabStrip.precacheImages = function(url)
{
	var url = url || 'tabstrip.css';
	var sheets = nitobi.html.Css.getStyleSheetsByName(url);
	for (var i = 0; i < sheets.length; i++)
	{
		nitobi.html.Css.precacheImages(sheets[i]);
	}
};

/**
 * @ignore
 */
nitobi.TabStrip = nitobi.tabstrip.TabStrip;

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.tabstrip");

/**
 * Creates a tab.  A tab object belongs to a {@link nitobi.tabstrip.Tabs} collection.
 * @class The Tab class defines the properties associated with a specific tab contained with the Tabstrip component.
 * To access a tab object from a given Tabstrip object, you can do the following:
 * <pre class="code">
 * var tabstrip = nitobi.getComponent("myTabstrip");
 * var tabs = tabstrip.getTabs();
 * var firstTab = tabs.get(0);
 * </pre>
 * @constructor
 * @param {XmlNode} [node] If you want to create a tab and deserialize it from the node. 
 * @extends nitobi.ui.Element
 */
nitobi.tabstrip.Tab = function(node) 
{
	nitobi.tabstrip.Tab.baseConstructor.call(this,node);
	this.onEventNotify.subscribe(this.handleEventNotify,this);
	
	/**
	 * Fired on click. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onClick = new nitobi.base.Event("click");
	this.eventMap["click"] = this.onClick;
	/**
	 * Fired on mouse out. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onMouseOut = new nitobi.base.Event("mouseout");
	this.eventMap["mouseout"] = this.onMouseOut;
	/**
	 * Fired on mouse over. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onMouseOver = new nitobi.base.Event("mouseover");
	this.eventMap["mouseover"] = this.onMouseOver;
	/**
	 * Fired on focus. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onFocus = new nitobi.base.Event("focus");
	this.eventMap["focus"] = this.onFocus;
	/**
	 * Fired on blur. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onBlur = new nitobi.base.Event("blur");
	this.eventMap["blur"] = this.onBlur;
	
	/**
	 * Fired when the tab is activated. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onActivate = new nitobi.base.Event("activate");
	this.eventMap["activate"] = this.onActivate;
	/**
	 * Fired when the tab is deactivated. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onDeactivate = new nitobi.base.Event("deactivate");
	this.eventMap["deactivate"] = this.onDeactivate;
	/**
	 * Fired when content finishes loading in the tab. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onLoad = new nitobi.base.Event("load");
	this.eventMap["load"] = this.onLoad;
	
	/**
	 * @private
	 */
	this.callback=null;
	/**
	 * @private
	 */	
	this.contentLoaded = false;
	this.subscribeDeclarationEvents();
	this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
}


nitobi.lang.extend(nitobi.tabstrip.Tab,nitobi.ui.Element);

/**
 * Information out the tabstrip class.
 * @private
 * @type nitobi.base.Profile
 */
nitobi.tabstrip.Tab.profile = new nitobi.base.Profile("nitobi.tabstrip.Tab",null,false,"ntb:tab");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.Tab.profile);

/**
 * Show the tab and make it active.
 * @private
 */
nitobi.tabstrip.Tab.prototype.show = function(effect)
{
	var el = this.getBodyHtmlNode();
	if (effect)
	{
		nitobi.html.Css.setOpacity(el, 0);	
	}
	el.style.height="100%";
	el.style.width="100%";
	el.style.position="";	
	el.style.display = "";
	el.className = "ntb-tab-active";
	
	var el = this.getHtmlNode("activetabclassdiv");
	el.className = "ntb-tab-active";
	if (effect)
	{
		
	}
	else
	{
		this.onActivate.notify(new nitobi.ui.ElementEventArgs(this));
	}
	//nitobi.ui.Effects.fade(this.getBodyHtmlNode(),100,400,nitobi.lang.close(this, this.activate));
}

/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.hide = function(effect)
{
	try
	{
		if (effect)
		{
			var el = this.getHtmlNode("activetabclassdiv");
			el.className = "ntb-tab-inactive";
			nitobi.ui.Effects.fade(this.getBodyHtmlNode(),0,400,nitobi.lang.close(this, this.handleHide));
		}
		else
		{
			this.handleHide();
		}
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected + " The tab could not be hidden.",err);	
	}
}

/**
 * Starts the tab pulsing. Call stopPulse to stop it.
 */
nitobi.tabstrip.Tab.prototype.pulse = function()
{
	this.pulseEnabled = true;
	for (var i = 0; i < this.nodelist.length ; i++)
	{
		this.nodelist[i].style.visibility = "visible";
	}
	this.pulseNext(this.nodelist);
	
}

/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.pulseNext = function(nodelist)
{
	var opac = nitobi.html.Css.getOpacity(nodelist[0]);
	if (this.pulseEnabled || opac > 1)
	{
		nitobi.ui.Effects.fade(nodelist,(opac == 0 ? 100 : 0),1400,nitobi.lang.close(this, this.pulseNext,[nodelist]),nitobi.ui.Effects.cube);
	}
	else if (this.pulseEnabled == false)
	{
		for (var i = 0; i < this.nodelist.length ; i++)
		{
			this.nodelist[i].style.visibility = "hidden";
		}
	}
}

/**
 * Stops the tab from pulsing.
 */
nitobi.tabstrip.Tab.prototype.stopPulse = function()
{
	this.pulseEnabled = false;
}

/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.handleHide = function()
{
	var el = this.getHtmlNode("activetabclassdiv");
	el.className = "ntb-tab-inactive";
	el = this.getBodyHtmlNode();
	el.className = "ntb-tab-inactive";

	el.style.width="1px";
	el.style.height="1px";
	el.style.position="absolute";			
	el.style.top="-5000px";
	el.style.left="-5000px";

	try
	{
		this.onDeactivate.notify(new nitobi.ui.ElementEventArgs(this));
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected + " onDeactivate notification contains an error.",err);	
	}
}

/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.handleEventNotify = function(eventArgs)
{
	var event = eventArgs.htmlEvent;
	var idInfo = nitobi.ui.Element.parseId(eventArgs.targetId);
	var returnResult = true;
	switch(event.type)
	{
		case("load"):
		{
			this.handleOnLoad();
			break;
		}
		case("click"):
		{
			returnResult = this.isEnabled();
			break;
		}
	}
	return returnResult;
}


/**
 * Loads content into the tab. If the container type is an IFrame, then the source
 * is treated as an accessible URL. If the container type is not an iframe, the source
 * is first treated as an element on the page, or the id of an element on the page.  If none
 * of these conditions are true, the source is treated as an URL from which content is to be loaded. 
 * Note: in the last case, the URL must be on the same domain as the tabstrip; browsers prohibit cross domain AJAX.
 * If there are Nitobi components in the contents of the tab, the time of their initialization can
 * be controlled.  If you use the onloaddemandenabled attribute, initialization of Nitobi components will 
 * be automatically delayed until the tab is first loaded.   You can handle
 * errors to this call with the usual try,catch procedures. As with all asynchronous calls and events
 * you can also subscribe to {@link nitobi.error.onError} to handle errors when the load completes.
 * @see nitobi.tabstrip.Tab#setSource 
 * @see nitobi.tabstrip.Tab#getSource
 * @param {String} [value] A source (either an html element or a url). The object's source
 * property is used if this argument is not supplied.
 */
nitobi.tabstrip.Tab.prototype.load = function(value)
{
	this.nodelist = new Array();
	this.nodelist[0] = this.getHtmlNode("leftpulse");
	nitobi.html.setOpacity(this.nodelist[0],0);
	this.nodelist[1] = this.getHtmlNode("bodypulse");
	this.nodelist[2] = this.getHtmlNode("rightpulse");
	var box = nitobi.html.getBox(this.getHtmlNode("labeltable"));
	this.nodelist[1].style.width = box.width + "px";
	
	if (value == null)
	{
		value = this.getSource();
	}
	if (value == null)
	{
		return;
	}
	this.setActivityIndicatorVisible(true);
	var iframeNode = this.getIframeHtmlNode();
	var el = $ntb(value);
	if (iframeNode != null)
	{
		// IFrame target requested.
		try
		{
			iframeNode.src = value;
		}
		catch(err)
		{
			nitobi.lang.throwError("Could not load iframe with src " + value);
		}
	}
	else if (el != null)
	{
		// Another node on the page targeted.
		var node = this.getNodeFrameHtmlNode();
		node.appendChild(el);
		nitobi.component.loadComponentsFromNode(node);
		nitobi.html.Css.removeClass(el, "ntb-tab-domnode");
		this.handleOnLoad();
	} 
	else
	{
		try
		{
			// Load an html fragment from the server.
			var nodeframe = this.getNodeFrameHtmlNode();
			this.setActivityIndicatorVisible(true);
			var pool = nitobi.ajax.HttpRequestPool.getInstance();
			this.callback = pool.reserve();
			this.callback.handler = value;
			this.callback.context = this;
			this.callback.params = this.callback;
			this.callback.onGetComplete.subscribe(this.handleOnLoad,this);
			this.callback.responseType = "text";
			this.callback.get();
		} 
		catch(err)
		{
			nitobi.lang.throwError("The HTTP request for tab could not be performed. Is the website accessible by client script? Cross domain scriping is not permitted. Use IFrame for this purpose.",err);
		}
	}
}

/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.handleOnLoad = function(eventArgs)
{
	try
	{
		if (eventArgs != null && eventArgs.params != null)
		{
			var node = this.getNodeFrameHtmlNode();
			if (nitobi.ajax.HttpRequest.isError(eventArgs.status))
			{
				node.innerHTML = '<div style="margin-left:20px;margin-right:20px"><h1 style="font-family:arial;font-size:14pt;">Error</h1><p style="font-family:tahoma;font-size:10pt;">The tab could not be opened because the location of the tab content could not be found.</p><ul style="font-family:tahoma;font-size:10pt;"><li>The server may be busy or not responding</li><li>The address of the tab content may be incorrect.</li><li>The address may be that of an HTML Element that was not on the page</li></ul><p style="font-family:tahoma;font-size:10pt;">Try again later. If the problem persists, contact your local administrator.</p><p style="font-family:tahoma;font-size:10pt;">The faulty source was ' + this.getSource() + '. The server return code was <b>'+eventArgs.status+' ('+eventArgs.statusText+').</b> The server response follows:</p><hr/><p>'+eventArgs.response+'</p></div>';
				nitobi.error.onError.notify(new nitobi.error.ErrorEventArgs(this,nitobi.error.HttpRequestError + "\n\n OR \n\n " + nitobi.error.NoHtmlNode,nitobi.tabstrip.Tab.profile.className));
			}
			else
			{
				node.innerHTML = eventArgs.response;
				if (this.isScriptEvaluationEnabled())
				{
					nitobi.html.evalScriptBlocks(node);
				}
				nitobi.component.loadComponentsFromNode(node);
			}
			var pool = nitobi.ajax.HttpRequestPool.getInstance();
			pool.release(eventArgs.params); 
		}
		this.setContentLoaded(true);
		this.setActivityIndicatorVisible(false);
		this.onLoad.notify(new nitobi.ui.ElementEventArgs(this));
	}
	catch(err)
	{
		
		nitobi.error.onError.notify(new nitobi.error.ErrorEventArgs(this,"The tab encountered an error while trying to parse the response from load. There may be an error in the onLoad event.",nitobi.tabstrip.Tab.profile.className));
	}
}

/**
 * Specifies whether or not the activity indicator is visible.
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.isActivityIndicatorVisible = function()
{
	return (this.getActivityIndicatorHtmlNode().style.display != "none");
}

/**
 * Specifies whether or not the activity indicator is visible.  This change takes 
 * effect immediately; you do not have to call render.
 * @param {Boolean} value true to show the indicator, and false otherwise.
 */
nitobi.tabstrip.Tab.prototype.setActivityIndicatorVisible = function(value)
{
	if (value == null || typeof(value) != "boolean") 
	{
		nitobi.lang.throwError(nitobi.error.BadArgType);	
	}
	this.getActivityIndicatorHtmlNode().style.display = (value ? "" : "none");
		
}

/**
 * Sets the activity indicator according to the current state of the load operation. This change takes 
 * effect immediately; you do not have to call render.
 */
nitobi.tabstrip.Tab.prototype.autoSetActivityIndicator = function()
{
	if (this.getContainerType() == "iframe")
	{
		var iframeNode = this.getIframeHtmlNode();
		if (iframeNode != null)
		{
			// readyState property is IE only.
			if (nitobi.browser.IE)
			{
				this.setActivityIndicatorVisible(iframeNode.readyState != "complete");
			}
			else
			{
				if (this.contentLoaded == true) 
				{
					this.setActivityIndicatorVisible(false);
				} 
				else if (this.getLoadOnDemandEnabled() == true)
				{
					this.setActivityIndicatorVisible(false);
				} 
			}				
		} else if (this.callback != null)
		{
			this.setActivityIndicatorVisible(this.callback.readyState != 4);
		}
	}		
}

/**
 * Returns the HTML node for the indicator.  The activity indicator is invoked automatically when the tab is loading 
 * content.
 * @type HTMLElement
 */
nitobi.tabstrip.Tab.prototype.getActivityIndicatorHtmlNode = function()
{
	return this.getHtmlNode("activityindicator");
}

/**
 * Returns the HTML node for the iframe, if one is used.
 * @type HTMLElement
 */
nitobi.tabstrip.Tab.prototype.getIframeHtmlNode = function()
{
	return this.getHtmlNode("tabiframe");
}

/**
 * Returns the HTML node for the container if no iframe is used.
 * @type HTMLElement
 */
nitobi.tabstrip.Tab.prototype.getNodeFrameHtmlNode = function()
{
	return this.getHtmlNode("tabnodeframe");
}

/**
 * Returns true if this tab has a body in the html or not.
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.isBodyHtmlNodeAvail = function()
{
	return (this.getHtmlNode("tabbody") != null);
}

/**
 * Returns the HTML node for the body of a tab.
 * @type HTMLElement
 */
nitobi.tabstrip.Tab.prototype.getBodyHtmlNode = function()
{
	var node = this.getHtmlNode("tabbody");
	if (node==null)
	{
		nitobi.lang.throwError(nitobi.error.NoHtmlNode + " The body of the tab could not be found. Is a body defined for this tab?");
	}
	return node;	
}


/**
 * @private
 */
nitobi.tabstrip.Tab.prototype.destroyHtml = function()
{
	if (this.isBodyHtmlNodeAvail())
	{
		var node = this.getBodyHtmlNode();
		node.parentNode.removeChild(node);
	}
	var node = this.getHtmlNode();
	if (node!=null)
	{
		node.parentNode.removeChild(node);
	}
}

/**
 * Whether or not the tab is enabled or not and can be clicked on. This change takes 
 * effect immediately; you do not have to call render.
 * @param {Boolean} enabled true if the tab is enabled and false otherwise.
 */
nitobi.tabstrip.Tab.prototype.setEnabled = function(enabled)
{
	if (enabled == null || typeof(enabled) != "boolean") 
	{
		nitobi.lang.throwError(nitobi.error.BadArgType);	
	}
	nitobi.tabstrip.Tab.base.setEnabled.call(this,enabled);
	this.setBoolAttribute("enabled",enabled)
	var el = this.getHtmlNode("activetabclassdiv");
	if (el)
	{
		if (el.className != "ntb-tab-disabled" && !enabled)
		{
			el.className = "ntb-tab-disabled";
		}
	}
}

/**
 * Whether or not the tab is enabled or not and can be clicked on.
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.isEnabled = function()
{
	return this.getBoolAttribute("enabled");
}

/**
 * Returns the width of the tab. Note: this is not the width of the content.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getWidth = function()
{
	return this.getAttribute("width");
}

/**
 * Set the width of the tab. This change takes 
 * effect immediately; you do not have to call render.
 * @see nitobi.tabstrip.Tabs#setHeight
 * @param {String} width Any html measurement.
 */
nitobi.tabstrip.Tab.prototype.setWidth = function(width)
{
	this.setAttribute("width",width);
	this.setStyle("width",width);	
}

/**
 * Returns the tooltip.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getTooltip = function()
{
	return this.getAttribute("tooltip");
}

/**
 * The tooltip. This change takes 
 * effect immediately; you do not have to call render.
 * @param {String} value The value of the tooltip to be set on the tab.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.setTooltip = function(value)
{
	this.setAttribute("tooltip",value);
	var el = this.getHtmlNode();
	if (el)
	{
		el.title = value;
	}
}

/**
 * Returns the icon used in the header for this tab.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getIcon = function()
{
	return this.getAttribute("icon");
}

/**
 * The Icon. This change takes 
 * effect immediately; you do not have to call render.
 * @param {String} value The HREF of the icon.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.setIcon = function(value)
{
	this.setAttribute("icon",value);
	var node = this.getHtmlNode("icon");
	if (value == null || value == "")
	{
		if (node)
		{
			nitobi.html.Css.setStyle(node, "display","none");
		}
	}
	else
	{
		if (node)
		{
			nitobi.html.Css.setStyle(node, "display","inline");
		}
	}
	if (node)
	{
		node.src=value;
	}
}

/**
 * Returns the source that defines the body for this tab.  For example, if an iframe is used, it will return
 * the url for the tab.  If the body is defined as a domnode, it will return the id of the node.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getSource = function()
{
	return this.getAttribute("source");
}

/**
 * The source. See {@link nitobi.tabstrip.Tab#load} to see how this value is used. load must
 * also be called for this change to take effect.
 * @param {String} value The source. Either a DOM node or (if an AJAX or IFRAME tab is used) the URL of the fragment/page.
 */
nitobi.tabstrip.Tab.prototype.setSource = function(value)
{
	this.setAttribute("source",value);
}

/**
 * Determines whether or not script blocks are recursively evaluated when
 * HTML is loaded in a tab without an iframe. The default is true.
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.isScriptEvaluationEnabled = function()
{
	var val = this.getAttribute("scriptevaluationenabled");
	if (null == val)
	{
		return true;
	}
	else
	{
		return this.getBoolAttribute("scriptevaluationenabled");
	}
}

/**
 * Determines whether or not script blocks are recursively evaluated when
 * HTML is loaded in a tab without an iframe. The default is true.
 * @param {Boolean} value true if script should be evaluated.
 */
nitobi.tabstrip.Tab.prototype.setScriptEvaluationEnabled = function(value)
{
	this.setBoolAttribute("scriptevaluationenabled",value);
}

/**
 * Returns the label for this tab.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getLabel = function()
{
	return this.getAttribute("label");
}

/**
 * The label. The label may include HTML. This change takes 
 * effect immediately; you do not have to call render.
  @param {String} value The label text.
 */
nitobi.tabstrip.Tab.prototype.setLabel = function(value)
{
	this.setAttribute("label",value);
	var node = this.getHtmlNode("label");
	if (node)
	{
		node.innerHTML = value;
	}
}

/**
 * The type of container for the tab body. It can be iframe, or if the string is empty, it is a domnode.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getContainerType = function()
{
	return this.getAttribute("containertype");
}

/**
 * The type of container for the tab body. It can be iframe, or if the string is empty, it is a domnode.
 * Once the tab has been rendered, this is immutable. To change it, remove the container, by removing
 * its HTML node (with standard Javascript DHTML), and re-render.  Alternatively, you can remove the 
 * tab, and create a new one with a different container type.
 * @param {String} value The container type. Either 'iframe' or ''.
 */
nitobi.tabstrip.Tab.prototype.setContainerType = function(value)
{
	if (value != '' && value != 'iframe')
	{
		nitobi.lang.throwError(nitobi.error.BadArg + " Valid values are 'iframe' or ''");
	}
	this.setAttribute("containertype",value);
}

/**
 * The cssclass of the tab.
 * @type String
 */
nitobi.tabstrip.Tab.prototype.getCssClass = function()
{
	return this.getAttribute("cssclass");
}

/**
 * Set the cssclass of the tab. This change takes 
 * effect immediately; you do not have to call render.
 * @param {String} cssclass The class.
 */
nitobi.tabstrip.Tab.prototype.setCssClass = function(cssclass)
{
	this.setAttribute("cssclass",cssclass);
	var node = this.getHtmlNode("customcss");
	if (node)
	{
		this.className = cssclass;
	}
}

/**
 * Determines whether to load the tab's contents when the tabstrip is first
 * rendered or when the tab is first set as the active tab.
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.getLoadOnDemandEnabled = function()
{
	if (this.getBoolAttribute("loadondemandenabled") != null) {
		return this.getBoolAttribute("loadondemandenabled");
	} else {
		return false;
	}
}

/**
 * The loadondemandenabled attribute is used to determine whether to load
 * a tab when the tabstrip is first rendered or to wait until the first time
 * the tab is set as the active tab.  If set to true, the tab will not
 * load until it is set as the active tab--i.e. until it is clicked on.  
 * In the case of IFRAME and AJAX tabs, this means 
 * that a server request won't be made until the tab is first
 * set to active.  However, if the tab's source is a DOM node, this attribute is ignored
 * and its content will be loaded when the tabstrip renders.
 * @param {Boolean} loadondemandenabled Either true or false
 */
nitobi.tabstrip.Tab.prototype.setLoadOnDemandEnabled = function(loadondemandenabled)
{
	this.setBoolAttribute("loadondemandenabled", loadondemandenabled);
}

/**
 * Used to determine if the tab's contents have been loaded.
 * If the tab's contents have been loaded, this will return true.
 * @see nitobi.tabstrip.Tab#setLoadOnDemandEnabled
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.getContentLoaded = function()
{
	return this.contentLoaded;
}

/**
 * Used to determine if the tab's contents have been loaded.
 * @see nitobi.tabstrip.Tab#setLoadOnDemandEnabled
 * @param {Boolean} contentloaded True if the content of the tab has been loaded
 */
nitobi.tabstrip.Tab.prototype.setContentLoaded = function(contentloaded)
{
	this.contentLoaded = contentloaded;
}

/**
 * Returns true if the tab has the hideoverflowenabled property set to true
 * @see #setHideOverflowEnabled
 * @type Boolean
 */
nitobi.tabstrip.Tab.prototype.getHideOverflowEnabled = function()
{
	if (this.getBoolAttribute("hideoverflowenabled") != null) 
	{
		return this.getBoolAttribute("hideoverflowenabled");
	} 
	else 
	{
		return false;
	}
}

/**
 * The hideoverflowenabled attribute can be used to set the overflow style of the tab's
 * body to hidden.  It is auto by default.
 * @see #getHideOverflowEnabled
 * @param {Boolean} hideoverflowenabled True to hide the overflow of the tab body, false to have overflow set to auto
 */
nitobi.tabstrip.Tab.prototype.setHideOverflowEnabled = function(hideoverflowenabled)
{
	this.setBoolAttribute("hideoverflowenabled", hideoverflowenabled);
	var node = this.getHtmlNode("tabbody");
	if (hideoverflowenabled == true)
	{
		node.style.overflow = "hidden";
	} else
	{
		node.style.overflow = "auto";
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.tabstrip");

/**
 * Creates a tabs collection.  The tabs collection is a container for individual tabs.
 * @class This class allows for modifications of certain shared tab attributes. 
 * It allows you to re-order, add, and remove the tabs from the collection. If you modify the tab 
 * collection by calling add and remove, call {@link nitobi.tabstrip.TabStrip#render} for
 * the changes to take effect.
 * <br/>
 * To obtain a reference to a specific tab in the collection use 
 * {@link nitobi.ui.Container#get}
 * @constructor
 * @see nitobi.tabstrip.TabStrip
 * @see nitobi.tabstrip.Tab
 * @param {XmlNode} [node] If you want to create a tabs list and deserialize it from the node. 
 * @extends nitobi.ui.Container
 * @implements nitobi.ui.IScrollable
 */
nitobi.tabstrip.Tabs = function(node) 
{
	nitobi.tabstrip.Tabs.baseConstructor.call(this,node);
	nitobi.ui.IScrollable.call(this);
	
	/**
	 * Fired on click. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onClick = new nitobi.base.Event("click");
	this.eventMap["click"] = this.onClick;
	
	/**
	 * Fired on mouse out. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onMouseOut = new nitobi.base.Event("mouseout");
	this.eventMap["mouseout"] = this.onMouseOut;
	
	/**
	 * Fired on mouse over. {@link nitobi.ui.ElementEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onMouseOver = new nitobi.base.Event("mouseover");
	this.eventMap["mouseover"] = this.onMouseOver;
	
	
	this.onEventNotify.subscribe(this.handleEventNotify,this);
	this.onBeforeEventNotify.subscribe(this.handleBeforeEventNotify,this);
	
	/**
	 * Fired before the tabs change. If the event returns false, nothing will happen.
	 * {@link nitobi.tabstrip.TabChangeEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onBeforeTabChange = new nitobi.base.Event("beforetabchange");
	this.eventMap["beforetabchange"] = this.onBeforeTabChange;

	/**
	 * Fired after the tabs have changed. {@link nitobi.tabstrip.TabChangeEventArgs} are passed to the event handler.
	 * @type nitobi.base.Event
	 */
	this.onTabChange = new nitobi.base.Event("tabchange");
	this.eventMap["tabchange"] = this.onTabChange;
	
	this.subscribeDeclarationEvents();
	
	this.renderer.setTemplate(nitobi.tabstrip.tabstripProc);
	this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
}

nitobi.lang.extend(nitobi.tabstrip.Tabs,nitobi.ui.Container);
nitobi.lang.implement(nitobi.tabstrip.Tabs,nitobi.ui.IScrollable);

/**
 * Information out the tabs class.
 * @private
 * @type nitobi.base.Profile
 */
nitobi.tabstrip.Tabs.profile = new nitobi.base.Profile("nitobi.tabstrip.Tabs",null,false,"ntb:tabs");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.Tabs.profile);

/**
 * @private
 * Load all the tabs that don't use IFRAMEs.
 */
nitobi.tabstrip.Tabs.prototype.loadTabs = function()
{	
	// We load the tab set as active, regardless of its loadondemandenabled attribute
	var tab = this.get(this.getActiveTabIndex());
	if (tab == null) {
		return;
	} else {
		tab.load();
	}

	// Now go through the rest of the tabs and load only the ones that have loadondemandenabled=false
	var nodes = this.getXmlNode().selectNodes("ntb:tab[@loadondemandenabled!='true' or not(@loadondemandenabled) and not(@id='"+tab.getId()+"')]");
	for (var i = 0; i < nodes.length; i++ ) {
		var index = nitobi.xml.indexOfChildNode(this.getXmlNode(), nodes[i]);
		var tab = this.get(index);
		tab.load();
	} 
}


/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.handleRender = function()
{
	this.handleResize();
}

/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.handleResize = function()
{
	this.setScrollableElement(this.getHtmlNode("container"));
	this.setScrollButtonsVisible(this.isOverflowed());
}

/**
 * Fired when a tab is clicked.
 * @private
 */
nitobi.tabstrip.Tabs.prototype.handleTabClick = function(tab)
{
	if (typeof(tab) == "object")
	{
		index = this.indexOf(tab);
	}
	else
	{
		index = tab;
		tab = this.get(index);
	}
		
	tab.onClick.notify(new nitobi.ui.ElementEventArgs(this));
	this.setActiveTab(tab);
}

/**
 * Displays or hides the tabs' scroll buttons. 
 * @param {Boolean} value True if the buttons should be visible.
 */
nitobi.tabstrip.Tabs.prototype.setScrollButtonsVisible = function(value)
{
	if (value != null && typeof(value) != "boolean") 
	{
		nitobi.lang.throwError(nitobi.error.BadArgType);
	}
	var el = this.getHtmlNode("scrollerbuttoncontainer");
	nitobi.html.Css.setStyle(el, "display",(value ? "" : "none"));
}

/**
 * Returns the index of the active tab. To set the active tab, use setActiveTab.
 * @see nitobi.tabstrip.Tabs#getActiveTab
 * @see nitobi.tabstrip.Tabs#setActiveTab
 * @type Number
 */
nitobi.tabstrip.Tabs.prototype.getActiveTabIndex = function()
{
	return this.getIntAttribute("activetabindex");
}

/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.setActiveTabIndex = function(index)
{
	this.setIntAttribute("activetabindex",index)
}

/**
 * Renders the tabs.
 * @private
 */
nitobi.tabstrip.Tabs.prototype.render = function()
{
	this.onBeforeRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
	this.setContainer(this.getHtmlNode().parentNode);
	this.renderer.setParameters({'apply-template':'tabs'});
	nitobi.tabstrip.Tabs.base.render.call(this,null,this.getXmlNode().ownerDocument);	
	
	// If we render again, we don't want to destroy all the containers.
	// Loop through them, and add ones that we don't have.
	var lastTab = null;
	var len = this.getLength();
	for (var i=0;i < len;i++)
	{
		var tab = this.get(i);
		
		// The bodypulse div is set to width: 100% from the xsl transform.
		// This is corrected when tab.load() is called, but we need to do it
		// here because not all tabs will have load() called on them.
		var box = nitobi.html.getBox(tab.getHtmlNode("labeltable"));
		tab.getHtmlNode("bodypulse").style.width = box.width + "px";
		
		if (!tab.isBodyHtmlNodeAvail())
		{
			this.renderer.setParameters({'apply-template':'body'});
			this.renderer.setParameters({'apply-id':(i+1)});
			if (lastTab == null)
			{
				this.renderer.renderIn(this.getBodiesContainerHtmlNode(),this.getState().ownerDocument);
			}
			else
			{
				this.renderer.renderAfter(lastTab,this.getState().ownerDocument);
			}

			tab.load();

		}
		else
		{
			tab.autoSetActivityIndicator();
			lastTab = tab.getBodyHtmlNode();
		}
		
	}
	if (len > 0) 
	{
		this.getActiveTab().show();
	}
	this.onRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
}

/**
 * Returns the HTML element that contains all the tabs' bodies.
 * @type HTMLElement
 */
nitobi.tabstrip.Tabs.prototype.getBodiesContainerHtmlNode = function()
{
	if (this.bodiesContainerHtmlNode)
	{
		return this.bodiesContainerHtmlNode;
	}
	else
	{
		// TODO: Huh? Getting the tabstrip to get this is wrong. Needs to be id'd according to the tabs. 
		var node = this.getParentObject().getHtmlNode("tabbodiescontainer");
		if (node==null)
		{
			nitobi.lang.throwError(nitobi.error.NoHtmlNode + " The bodiesContainer html element could not be found.");
		}
		this.bodiesContainerHtmlNode=node;
		return node;	
	}
}

/**
 * Returns the active tab.
 * @see nitobi.tabstrip.Tabs#getActiveTabIndex
 * @see nitobi.tabstrip.Tabs#setActiveTab
 * @type nitobi.tabstrip.Tab
 */
nitobi.tabstrip.Tabs.prototype.getActiveTab = function()
{
	return this.get(this.getActiveTabIndex());
}

/**
 * Sets the active tab. The tab must be a part of the tabstrip's collection
 * of tabs.
 * @param {nitobi.tabstrip.Tab/Number} tab The tab to make active or the index of the tab to make active.
 */
nitobi.tabstrip.Tabs.prototype.setActiveTab = function(tab)
{
	if (null == tab)
	{
		nitobi.lang.throwError(nitobi.error.BadArgType);
	}
	try
	{
		var index;
		var activeTab = this.getActiveTab();
	
		if (typeof(tab) == "object")
		{
			index = this.indexOf(tab);
		}
		else
		{
			index = tab;
			tab = this.get(index);
		}
		if (index == this.getActiveTabIndex())
		{
			return;
		}
		var args = new nitobi.tabstrip.TabChangeEventArgs(this, null, this.getId(), activeTab, tab);
		if(this.onBeforeTabChange.notify(args))
		{
			if (this.getActivateEffect() == "fade")
			{
				nitobi.tabstrip.Tabs.transition(this,activeTab,tab);			
			}
			else
			{
				activeTab.hide();
				if (tab.getContentLoaded() == false) {
					tab.load();
				} 
				tab.show();	
			}
			this.setActiveTabIndex(index);
			this.onTabChange.notify(args);
		}
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected + " The active tab could not be set.",err);	
	}
}

/**
 * @private
 */
nitobi.tabstrip.Tabs.transition = function(tabs,tabToHide,tabToShow)
{
	var hideEl = tabToHide.getBodyHtmlNode();
	var showEl = tabToShow.getBodyHtmlNode();
	var hideIndex = nitobi.html.indexOfChildNode(hideEl.parentNode,hideEl);
	var showIndex = nitobi.html.indexOfChildNode(showEl.parentNode,showEl);

	var elToMove, elToKeep;
	
	if (showIndex > hideIndex)
	{
		elToMove = showEl;
		elToKeep = hideEl;
	}
	else
	{
		elToMove = hideEl;
		elToKeep = showEl;
	}
	
	nitobi.html.Css.setOpacity(hideEl, 100);
	
	var index = nitobi.html.indexOfChildNode(hideEl.parentNode,hideEl);
	var box = nitobi.html.getBox(hideEl);

	if (hideIndex < showIndex)
	{
		//	TODO: The "effect" argument is here is a place holder for a real effect.
		tabToShow.show("effect");
	}
	
	var container = tabs.getParentObject().getHtmlNode("tabbodiesdivcontainer");
	container.style.height = nitobi.html.getBox(container).height + "px";
	var top = -1 * nitobi.html.getBox(hideEl).height;
	var disp = elToMove.style.display;
	elToMove.style.display = "none";
	elToMove.style.top = top + "px";
	elToMove.style.left="0px";
	elToMove.style.left = "0px";
	elToMove.style.position = "relative";
	elToMove.style.height = box.height + "px";
	elToKeep.style.height = box.height + "px";
	
	container.style.height = "100%";

	elToMove.style.display = disp;	
	tabToHide.hide("effect");
	if (hideIndex > showIndex)
	{
		tabToShow.show("effect");
	}
	nitobi.ui.Effects.fade(showEl,100,400,nitobi.lang.close(tabToShow, tabToShow.show));
}

/**
 * The alignment of the tabs. Valid values are left, right, and center.
 * @type String
 */
nitobi.tabstrip.Tabs.prototype.getAlign = function()
{
	return this.getAttribute("align");
}

/**
 * The alignment of the tabs. 
 * Call {@link nitobi.tabstrip.TabStrip#render} after setting the alignment.
 * @param {String} value The alignment.  Valid values are left, right, and center.
 */
nitobi.tabstrip.Tabs.prototype.setAlign = function(value)
{
	if (value != "left" && value !="right" && value!="center")
	{
		nitobi.lang.throwError(nitobi.error.BadArg);
	}
	this.setAttribute("align",value);
}

/**
 * Determines what effect is applied when the tab is activated. Valid values
 * are 'none', and 'fade'.
 * @type String
 */
nitobi.tabstrip.Tabs.prototype.getActivateEffect = function()
{
	return this.getAttribute("activateeffect");
}

/**
 * Determines what effect is applied when the tab is activated.
 * @param {String} value The effect.  Valid values are 'none', and 'fade'.
 */
nitobi.tabstrip.Tabs.prototype.setActivateEffect = function(value)
{
	if (value != "" && value !="fade")	
	{
		nitobi.lang.throwError(nitobi.error.BadArg);
	}
	this.setAttribute("activateeffect",value);
}

/**
 * The height of the tabs.
 * @type String
 */
nitobi.tabstrip.Tabs.prototype.getHeight = function()
{
	return this.getAttribute("height");
}

/**
 * The height of the tabs. Call {@link nitobi.tabstrip.TabStrip#render} after setting the height.
 * @param {String} value The height.
 */
nitobi.tabstrip.Tabs.prototype.setHeight = function(value)
{
	this.setAttribute("height",value);
}

/**
 * The overlap of the tabs.
 * @type Number
 */
nitobi.tabstrip.Tabs.prototype.getOverlap = function()
{
	return this.getIntAttribute("overlap");
}

/**
 * The overlap of the tabs. If you want the tabs to be aligned next to each other set this to zero.
 * If you want more space in between the tabs, set this value to a negative value.
 * Call {@link nitobi.tabstrip.TabStrip#render} after setting the overlap.
 * @param {Number} value The overlap.
 */
nitobi.tabstrip.Tabs.prototype.setOverlap = function(value)
{
	this.setIntAttribute("overlap",value);
}

/**
 * Removes a tab. Call {@link nitobi.tabstrip.TabStrip#render} after adding or removing tabs.
 * @param {nitobi.tabstrip.Tab} The tab or the index of the tab to remove.
 */
nitobi.tabstrip.Tabs.prototype.remove = function(value)
{
	if (value == null)
	{
		nitobi.lang.throwError(nitobi.error.BadArg);
	}
	var i;
	// TODO: Wrap this indexing stuff up somewhere else.
	if (typeof(value) != "number")
	{
		i = this.indexOf(value);
	}
	else
	{
		i = value;
	}
	if (i == -1)
	{
		nitobi.lang.throwError(nitobi.error.BadArg + " The tab could not be found.");
	}

	var tab = this.get(i);
	var activeI = this.getActiveTabIndex();
	if (this.getLength() == 1)
	{
		activeI = -1;
	}
	else if (activeI > i)
	{
		activeI--;	
	} 
	else if (activeI == i)
	{
		if (!(activeI == 0 && i == 0))
		{
			activeI--;	
		}
	}
	
	this.setActiveTabIndex(activeI);
	tab.destroyHtml();
	nitobi.tabstrip.Tabs.base.remove.call(this,value);
}


/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.handleBeforeEventNotify = function(eventArgs)
{
	var event = eventArgs.htmlEvent;
	var idInfo = nitobi.ui.Element.parseId(eventArgs.targetId);
	if (event.type == "click")
	{
		// Ignore the click if the tab is disabled.
		var tab = this.getById(idInfo.id);
		if (null == tab)
		{
			return false;
		}
		else
		{
			return tab.isEnabled();
		}
	}
}

/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.handleEventNotify = function(eventArgs)
{
	var event = eventArgs.htmlEvent;
	var idInfo = nitobi.ui.Element.parseId(eventArgs.targetId);
	switch(event.type)
	{
		case "click":
		{
			try
			{
				if (idInfo.localName!="scrollleft" && idInfo.localName!="scrollright")
				{
					var tab = this.getById(idInfo.id);
					this.setActiveTab(tab);
				}
			}
			catch(err)
			{
				nitobi.lang.throwError("The Tabs object encountered an error handling the click event.",err);
			}
			break;
		}
		case "mousedown":
		{
			var closure;
			switch(idInfo.localName)
			{
				case "scrollleft":
				{
					this.scrollLeft();
					closure = nitobi.lang.close(this,this.scrollLeft,[]);		
					break;
				}
				case "scrollright":
				{
					this.scrollRight();
					closure = nitobi.lang.close(this,this.scrollRight,[]);
					break;
				}
			}
			this.stopScrolling();
			this.scrollerEventId = window.setInterval(closure,100);
			nitobi.html.attachEvent(document.body,"mouseup",this.stopScrolling,this);
			break;
		}
		case "mouseup":
		{
			this.stopScrolling();
			break;
		}
		
	}
}


/**
 * @private
 */
nitobi.tabstrip.Tabs.prototype.stopScrolling = function()
{
	window.clearInterval(this.scrollerEventId);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * Creates a TabChangeEventArgs object.  An instance of this class is passed to the function handling events
 * relating to tab changes.
 * @constructor
 * @class Used to supply arguments when changing tabs.
 * @extends nitobi.ui.ElementEventArgs
 * @param {Object} source The object that fired the event.
 * @param {nitobi.base.Event} event The event that is being fired.
 * @param {String} targetId The id of the event target.
 * @param {nitobi.tabstrip.Tab} activeTab The tab that is active.
 * @param {nitobi.tabstrip.Tab} tab The tab that is about to become active.
 */
nitobi.tabstrip.TabChangeEventArgs = function(source, event, targetId, activeTab, tab)
{
	nitobi.tabstrip.TabChangeEventArgs.baseConstructor.apply(this,arguments);
	
	/**
	 * The tab that is active.
	 * @type nitobi.tabstrip.Tab
	 */
	this.activeTab = activeTab || null;
	/**
	 * The tab that is about to become active.
	 * @type nitobi.tabstrip.Tab
	 */
	this.tab = tab || null;
}

nitobi.lang.extend(nitobi.tabstrip.TabChangeEventArgs,nitobi.ui.ElementEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.tabstrip.error');

/**
 * @ignore
 */
nitobi.tabstrip.error.TabActiveTabErr = "The active tab could not be set.";
