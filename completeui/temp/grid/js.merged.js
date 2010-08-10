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
nitobi.lang.defineNs("nitobi.ui");

nitobi.ui.Scrollbar = function() 
{
	this.uid = "scroll" + nitobi.base.getUid();
}


nitobi.ui.Scrollbar.prototype.render = function()
{
	//Render the scrollbar
}
nitobi.ui.Scrollbar.prototype.attachToParent = function(UiContainer,element,surface)
{
	this.UiContainer = UiContainer;
	this.element = element || nitobi.html.getFirstChild(this.UiContainer);
	if (this.element == null) this.render();
	this.surface = surface || nitobi.html.getFirstChild(this.element);

	// Attach events
	this.element.onclick="";
	this.element.onmouseover="";
	this.element.onmouseout="";
	this.element.onscroll="";

//	var _this = this;
//	this.element.onscroll=function() {_this.scrollByUser()};
//	this.attach("onscroll",this.scrollByUser,this.element};
	nitobi.html.attachEvent(this.element, "scroll", this.scrollByUser, this);
}
nitobi.ui.Scrollbar.prototype.align = function()
{
	var vs = document.getElementById("vscroll"+this.uid);

	var dx = -1;
	if (nitobi.browser.MOZ)
	{
		dx = -3
	}
	nitobi.drawing.align(vs,this.UiContainer.childNodes[0],0x10100100,-42,0,24,dx,false);
}
nitobi.ui.Scrollbar.prototype.scrollByUser = function()
{
	this.fire("ScrollByUser",this.getScrollPercent());
}
nitobi.ui.Scrollbar.prototype.setScroll = function(position)
{
}
nitobi.ui.Scrollbar.prototype.getScrollPercent = function()
{
}

/**
 * @param size A percent value between 0 and 1.
 */
nitobi.ui.Scrollbar.prototype.setRange = function(size)
{
}

/**
 * Returns the horizontal thickness of the scrollbar
 */ 
nitobi.ui.Scrollbar.prototype.getWidth = function()
{
	return nitobi.html.getScrollBarWidth();
}
/**
 * Returns the vertical thickness of the scrollbar
 */ 
nitobi.ui.Scrollbar.prototype.getHeight = function()
{
	return nitobi.html.getScrollBarWidth();
}


nitobi.ui.Scrollbar.prototype.fire= function(evt,args)  {
	return nitobi.event.notify(evt+this.uid,args);
  }
nitobi.ui.Scrollbar.prototype.subscribe= function(evt,func,context)  {
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @ignore
 * @private
 */
nitobi.ui.VerticalScrollbar = function() 
{
	this.uid = "vscroll"+nitobi.base.getUid();
}

nitobi.lang.extend(nitobi.ui.VerticalScrollbar, nitobi.ui.Scrollbar);

/**
 * @ignore
 * @private
 */
nitobi.ui.VerticalScrollbar.prototype.setScrollPercent = function(percent)
{
	this.element.scrollTop=(this.surface.offsetHeight-this.element.offsetHeight)*percent;
	return false;
}

/**
 * @ignore
 * @private
 */
nitobi.ui.VerticalScrollbar.prototype.getScrollPercent = function()
{
	return (this.element.scrollTop/(this.surface.offsetHeight-this.element.offsetHeight));
}

/**
 * @ignore
 * @private
 * @param size A percent value between 0 and 1.
 */ 
nitobi.ui.VerticalScrollbar.prototype.setRange = function(size)
{
	var st=this.element.scrollTop;
	this.surface.style.height = Math.floor(this.element.offsetHeight / size) + "px";
	this.element.scrollTop=st;
	// This looks stupid but it is necessary to rejig the scroll position. (IE Only) (Of course)
	this.element.scrollTop = this.element.scrollTop;

	
	
/*
	var origHeight = this.surface.clientHeight;
	this.surface.style.height = Math.floor(this.element.clientHeight / size);
	var pctChg = this.surface.clientHeight/origHeight;
	alert(pctChg)
	this.element.scrollTop=Math.floor(this.element.scrollTop/pctChg); // This keeps the absolute (not percentage) scroll position the same when the range changes
*/
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ui");

/**
 * @private
 * @ignore
 */
nitobi.ui.HorizontalScrollbar = function() 
{
	this.uid = "hscroll"+nitobi.base.getUid();
}

nitobi.lang.extend(nitobi.ui.HorizontalScrollbar, nitobi.ui.Scrollbar);

/**
 * @private
 * @ignore
 */
nitobi.ui.HorizontalScrollbar.prototype.getScrollPercent = function()
{
	return (this.element.scrollLeft/(this.surface.clientWidth-this.element.clientWidth));
}

/**
 * @private
 * @ignore
 */
nitobi.ui.HorizontalScrollbar.prototype.setScrollPercent = function(percent)
{
	this.element.scrollLeft=(this.surface.clientWidth-this.element.clientWidth)*percent;
	return false;
}

/**
 * @private
 * @ignore
 * @param size A percent value between 0 and 1.
 */ 
nitobi.ui.HorizontalScrollbar.prototype.setRange = function(size)
{
	this.surface.style.width = Math.floor(this.element.offsetWidth / size) + "px";
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
 * Constructor for IDataBoundList
 * @class A UI control that is bound to a data source.  Used primarily by {@link nitobi.form.Lookup} to manage it's
 * remote data.  The data it manages is columnar.  Like an html list control, you can define which fields are visible in the
 * control (the display fields) and which fields relate to the value (value field).
 * @constructor
 */
nitobi.ui.IDataBoundList = function()
{
}

/**
 * Returns the gethandler name.  The gethandler is the url that returns data to the list.
 * @type String
 */
nitobi.ui.IDataBoundList.prototype.getGetHandler = function()
{
	return this.getHandler;
}

/**
 * Sets the gethandler url for the list.
 * @param {String} getHandler The url that returns data to the list.
 */
nitobi.ui.IDataBoundList.prototype.setGetHandler = function(getHandler)
{
	this.column.getModel().setAttribute("GetHandler", getHandler);
	this.getHandler = getHandler;
}

/**
 * Returns the id of the datasource used to manage the list's data.
 * @type String
 */
nitobi.ui.IDataBoundList.prototype.getDataSourceId = function()
{
	return this.datasourceId;
}

/**
 * Sets the id for the datasource.
 * @param {String} dataSourceId The id to use.
 */
nitobi.ui.IDataBoundList.prototype.setDataSourceId = function(dataSourceId)
{
	this.column.getModel().setAttribute("DatasourceId", dataSourceId);
	this.datasourceId = dataSourceId;
}

/**
 * Returns the display fields for the list.
 * @type String
 */
nitobi.ui.IDataBoundList.prototype.getDisplayFields = function()
{
	return this.displayFields;
}

/**
 * Sets the display fields for the list.
 * @param {String} displayFields The display fields to set.
 */
nitobi.ui.IDataBoundList.prototype.setDisplayFields = function(displayFields)
{
	this.column.getModel().setAttribute("DisplayFields", displayFields);
	this.displayFields = displayFields;
}

/**
 * Returns the value field for the list.
 * @type String
 */
nitobi.ui.IDataBoundList.prototype.getValueField = function()
{
	return this.valueField;
}

/**
 * Sets the value field for the list.
 * @param {String} valueField The field to set as the value field.
 */
nitobi.ui.IDataBoundList.prototype.setValueField = function(valueField)
{
	this.column.getModel().setAttribute("ValueField", valueField);
	this.valueField = valueField;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.collections');

/**
 * nitobi.collections.CacheMap represents a doubly linked list of CacheNode objects.
 * It is used to keep track of ranges. The next and prev properties provide
 * access to the respective nodes in the linked list.
 * @constructor
 * @class
 */
nitobi.collections.CacheMap = function()
{
	this.tail = null;
	this.debug = new Array();
}

/**
 * Insert will create and insert a new CacheNode into the CacheMap at the appropriate position.
 * If the range specified by the low and high overlaps any existing CacheNodes those
 * nodes will be expanded and/or merged.
 * @param {Number} low The low argument is the low end of the range to insert (inclusive)
 * @param {Number} high The high argument is the high end of the range to insert (inclusive)
 */
nitobi.collections.CacheMap.prototype.insert = function(low,high)
{
	low = Number(low);
	high = Number(high);
	this.debug.push("insert("+low+","+high+")");
	var newNode = new nitobi.collections.CacheNode(low,high);
	if (this.head==null){
		this.debug.push("empty cache, adding first node");
		this.head = newNode;
		this.tail = newNode;
	}
	else
	{
		// Handle adding at beginning or end as special
		// case due to the fact that ranges are quite
		// often prepended or appended to the list.
		var n = this.head;
		// find the node that will come after the new one.
		while (n != null && low>n.high+1)
		{
			n = n.next;
		}
		if (n==null) {
			this.debug.push("appending node to end");
			this.tail.next = newNode;
			newNode.prev = this.tail;
			this.tail = newNode;
		}
		else
		{
			this.debug.push("inserting new node before " + n.toString());
			if (n.prev != null)
			{
				newNode.prev = n.prev;
				n.prev.next = newNode;
			}
			newNode.next = n;
			n.prev = newNode;

			while(newNode.mergeNext())
			{
			}

			if (newNode.prev==null)
			{
				this.head = newNode;
			}
			if (newNode.next==null)
			{
				this.tail = newNode;
			}
		}
	}
}

/**
 * Remove will remove a the specified range from the CacheMap.
 * If the range specified by the low and high arguments overlaps any existing CacheNodes those
 * nodes will be reduced in size or removed completely.
 * @param {Number} low The low argument is the low end of the range to remove (inclusive)
 * @param {Number} high The high argument is the high end of the range to remove (inclusive)
 */
nitobi.collections.CacheMap.prototype.remove = function(low, high)
{
	low = Number(low);
	high = Number(high);
	this.debug.push("insert("+low+","+high+")");
	if (this.head==null){
	}
	else
	{	
	    if (high < this.head.low || low > this.tail.high)
	        return;

		// Handle adding at beginning or end as special
		// case due to the fact that ranges are quite
		// often prepended or appended to the list.
		var start = this.head;

		while (start != null && low > start.high)
		{
			start = start.next;
		}

		if (start==null)
		{
			this.debug.push("the range was not found");
		}
		else
		{
			var end = start;
			var temp = null;

			while (end != null && high > end.high)
    		{
    		    if ((end.next != null && high < end.next.low) || end.next == null)
    		        break;
				temp = end.next;
				if (end != start)
			    {
					this.removeNode(end);
				}
				end = temp;
			}

            if (start != end)
            {
                if (high >= end.high)
                {
                    //    that means the entire end node is to be removed
                    this.removeNode(end);
                }

                if (low <= start.low)
                {
                    //    that means the entire start node is to be removed
                    this.removeNode(start);
                }
            }
            //    start and end are the same ...
            //    only thing left here is if we are removing the exact node
            else if (start.low >= low && start.high <= high)
            {
                this.removeNode(start);
                return;
            }
            //    otherwise we need to create a node cause we are removing a range
            //    that is smaller than the single node.
            else if (low > start.low && high < start.high)
            {
                var origLow = start.low;
                var origHigh = start.high;
                this.removeNode(start);
                this.insert(origLow, low-1);
                this.insert(high+1, origHigh);
                return;
            }

            if (end != null && high < end.high)
            {
                //    that means that the end node is not the start and it will have to made smaller
                end.low = high+1;
            }

            if (start != null && low > start.low)
            {
                //    that means we have to shorten the start range since low is somewhere in it
                start.high = low-1;
            }
		}
	}		
}

/**
 * The gaps method will return an array containing the gaps in the CacheMap 
 * that exist in the specified range.
 * @param {Number} low The low argument is the low end of the range to check for gaps in (inclusive)
 * @param {Number} high The high argument is the high end of the range to check for gaps in (inclusive)
 * @type Array
 */
nitobi.collections.CacheMap.prototype.gaps = function(low,high)
{
	// Could this search be executed faster in XPath???
	var g = new Array();
	var n = this.head;

	if (n==null || n.low>high || this.tail.high<low)
	{
		// our search range lies entirely outside our cache
		g.push(new nitobi.collections.Range(low,high));
		return g;
	}

	//	This loops through all the nodes in our cacheMap until
	//	a node high value is greater than the low end of our range

	//TODO: change this to a binary search???
	var minLow = 0;
	while (n != null && n.high < low) // shouldn't overlap???
	{
		minLow = n.high+1;
		n = n.next;
	}

	if (n!=null)
	{
		do
		{
			if (g.length == 0) // if this is the first gap.
			{
				if (low < n.low) {
//						g.push(new nitobi.collections.Range(low,Math.min(n.low-1,high)));
					g.push(new nitobi.collections.Range(Math.max(low,minLow),Math.min(n.low-1,high))); // Need to consider the case where the previous high overlaps the inserted range's low
				}
			}
			if (high > n.high)
			{
				if (n.next == null || n.next.low > high) // Need to consider the case where the inserted range's high overlaps the next range's low
				{
					g.push(new nitobi.collections.Range(n.high+1, high));
				}
				else
				{
					g.push(new nitobi.collections.Range(n.high+1, n.next.low-1));
				}
			}
			n = n.next;
		} while (n != null && n.high < high)
	}
	else
	{
		g.push(new nitobi.collections.Range(this.tail.high+1,high));
	}
	return g;
}

/**
 * The gaps method will return an array containing the gaps in the CacheMap 
 * that exist in the specified range.
 * @param {Number} low The low argument is the low end of the range to check for gaps in (inclusive)
 * @param {Number} high The high argument is the high end of the range to check for gaps in (inclusive)
 * @type Array
 */
nitobi.collections.CacheMap.prototype.ranges = function(low,high)
{
	// TODO: Could this search be executed faster in XPath???
	var g = new Array();
	var n = this.head;

	if (n==null || n.low>high || this.tail.high<low)
	{
		// our search range lies entirely outside our cache
		return g;
	}

	//	This loops through all the nodes in our cacheMap until
	//	a node high value is greater than the low end of our range

	//TODO: change this to a binary search???
	while (n != null && n.high < low) // shouldn't overlap???
	{
		minLow = n.high+1;
		n = n.next;
	}
	if (n!=null)
	{
		do
		{
			g.push(new nitobi.collections.Range(n.low,n.high));
			n = n.next; 
		} while (n != null && n.high < high)
	}
	return g;
}

/**
 * @private
 */
nitobi.collections.CacheMap.prototype.gapsString = function(low,high)
{
	var gs = this.gaps(low,high);
	var a = new Array();
	for (var i = 0; i < gs.length; i++) {
		a.push(gs[i].toString());
	}
	return a.join(",");
}

/**
 * @private
 */
nitobi.collections.CacheMap.prototype.removeNode = function(node)
{
	if (node.prev != null)
	{
		node.prev.next = node.next;
	}
	else
	{
		this.head = node.next;
	}

	if (node.next != null)
	{
		node.next.prev = node.prev;
	}
	else
	{
		this.tail = node.prev;
	}

	node = null;
}

/**
 * Returns the cache map as a comma separated string
 * @type String
 */
nitobi.collections.CacheMap.prototype.toString = function()
{
	var n = this.head;
	var s = new Array();
	while (n != null) {
		s.push(n.toString());
		n = n.next;			
	}

/*		var t = this.tail;
		var a = new Array();
		while (t != null) {
			a.push(t.toString());
			t = t.prev;			
		}
*/
	return s.join(",");// + ' :: ' + a.join(",");
}

/**
 * Empties the cache map.
 */
nitobi.collections.CacheMap.prototype.flush = function()
{
	var node = this.head;
	while(Boolean(node))
	{
		var next = node.next;
		delete(node);
		node = next;
	}
	this.head=null;
	this.tail=null;
}

/**
* Inserts a single entry into the map. If the entry exists within a
* range, then the ranges are updated. If the entry does not exist within
* any range, then the entry is added.
* @param {Number} index The index of the entry to add.
*/
nitobi.collections.CacheMap.prototype.insertIntoRange = function(index)
{
	var n = this.head;
	var inc = 0;
	while (n != null) 
	{
		if (index >= n.low && index <= n.high)
		{
			inc = 1;
			n.high += inc;
		}
		else
		{
			n.low += inc;
			n.high += inc;
		}
		n = n.next;
	}
	// Check to see if we found anything at all.
	if (inc == 0)
	{
		this.insert(index,index);
	}
}

/**
* Deletes a single entry from the map. If the range in which the 
* entry resides is of length == 1, then the whole entry is removed.
* All subsequent ranges are updated.
* @param {Number} index The index of the entry to delete.
*/
nitobi.collections.CacheMap.prototype.removeFromRange = function(index)
{
	var n = this.head;
	var inc = 0;
	while (n != null) 
	{
		if (index >= n.low && index <= n.high)
		{
			inc = -1;
			if (n.low == n.high)
			{
				this.remove(index,index);	
			}
			else
			{
				n.high += inc;
			}
		}
		else
		{
			n.low += inc;
			n.high += inc;
		}
		n = n.next;
	}
	ntbAssert(inc!=0,"Tried to remove something from a range where the range does not exist");
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.collections");

/**
 * Creates a BlockMap object.
 * @class nitobi.collections.BlockMap is similar to {@link nitobi.collections.CacheMap} except that adjacent blocks
 * are not collapsed into a single block
 * @constructor
 * @extends nitobi.collections.CacheMap
 */
nitobi.collections.BlockMap = function() 
{
	this.head = null;
	this.tail = null;
	this.debug = new Array();
}

nitobi.lang.extend(nitobi.collections.BlockMap, nitobi.collections.CacheMap);

/**
 * Inserts a block into the blockmap.
 * @param {Number} low The low end of the block range.
 * @param {Number} high The high end of the block range.
 */
nitobi.collections.BlockMap.prototype.insert = function(low,high) 
{
	low = Number(low);
	high = Number(high);
	this.debug.push("insert("+low+","+high+")");
	if (this.head==null){
		var newNode = new nitobi.collections.CacheNode(low,high);
		this.debug.push("empty cache, adding first node");
		this.head = newNode;
		this.tail = newNode;
	}
	else
	{
		// Handle adding at beginning or end as special
		// case due to the fact that ranges are quite
		// often prepended or appended to the list.
		var n = this.head;
		// find the node that will come after the new one.
		// 1.              [44,46] 
		// 2.                      [54,66] 
		// 3.                           [64,76] 
		//    [10,10] [30,40] ^ [50,60]    ^
		// Slide right comparing the inserted low to each existing high until the inserted low is greater than the exisiting high
		// This will give you ...
		// Case 1:(Inserted low is in a node)    - the node that would contain the low - this will become the "nextNode" for the inserted node
		// Case 2:(Inserted low is in a gap)     - the node that would follow the gap  - this will become the "nextNode" for the inserted node
		// Case 3:(Inserted low higher than all) - NULL                                - Inserted node takes over as the new "tail"
		// Case 4:(No existing nodes-see above)  - NULL - impossible cuz head!=null    - Inserted node becomes the "head" (and "tail")
		while (n != null && low>n.high) 
		{
			n = n.next;
		}
		if (n==null) {
			var newNode = new nitobi.collections.CacheNode(low,high);
			this.debug.push("appending node to end");
			this.tail.next = newNode;
			newNode.prev = this.tail;
			this.tail = newNode;
		}
		else
		{
			this.debug.push("inserting new node into or before " + n.toString());
			// Case 1 or 2
			// Case 1:(Inserted low is in a node) 
			//         - the newNode will follow the insertion point node "n" (assuming its not completely contained)
			//         - the newNode's low is n.high+1
			//         - the newNode's high ... is min(newNode.high,next.low-1) ( high could overlap several blocks - chop at first one)
			// Case 2:(Inserted low is in a gap) 
			//         - the newNode will preceed the insertion point node "n"
			//         - the newNode's low is unchanged
			//         - the newNode's high ... is min(newNode.high,next.low-1) ( high could overlap several blocks - chop at first one)
			if (low<n.low || high>n.high) // inserting into a gap
			{
				if (low<n.low)
				{
					var newNode = new nitobi.collections.CacheNode(low,high);
					newNode.prev = n.prev;
					newNode.next = n;
					if (n.prev != null) {
						n.prev.next = newNode;
					}
					n.prev = newNode;
					newNode.high = Math.min(newNode.high,n.low-1);
				} else {
					var newNode = new nitobi.collections.CacheNode(n.high+1,high);
					newNode.prev = n;
					newNode.next = n.next;
					if (n.next!=null) {
						n.next.prev = newNode;
						newNode.high = Math.min(high,newNode.next.low-1);
					}
					n.next = newNode;
				}
				if (newNode.prev==null)
				{
					this.head = newNode;
				}
				if (newNode.next==null)
				{
					this.tail = newNode;
				}
			}
		}
	}
}


/**
 * Searches the blockmap for all blocks that intersect the specified range.
 * @param low {Number} The low end of the block range.
 * @param high {Number} The high end of the block range.
 */
nitobi.collections.BlockMap.prototype.blocks = function(low,high) 
{
	var g = new Array();
	var n = this.head;

	if (n==null || n.low>high || this.tail.high<low)
	{
		// our search range lies entirely outside our cache
		g.push(new nitobi.collections.Range(low,high));
		return g;
	}

	//	This loops through all the nodes in our cacheMap until
	//	a node high value is greater than the low end of our range

	//TODO: change this to a binary search???
	var minLow = 0;
	while (n != null && n.high < low) // shouldn't overlap???
	{
		minLow = n.high+1;
		n = n.next;
	}

	if (n!=null)
	{
		do
		{
			if (g.length == 0) // if this is the first gap.
			{
				if (low < n.low) {
					g.push(new nitobi.collections.Range(Math.max(low,minLow),Math.min(n.low-1,high))); // Need to consider the case where the previous high overlaps the inserted range's low
				}
			}
			if (high > n.high)
			{
				if (n.next == null || n.next.low > high) // Need to consider the case where the inserted range's high overlaps the next range's low
				{
					g.push(new nitobi.collections.Range(n.high+1, high));
				}
				else
				{
					g.push(new nitobi.collections.Range(n.high+1, n.next.low-1));
				}
			}
			n = n.next;
		} while (n != null && n.high < high)
	}
	else
	{
		g.push(new nitobi.collections.Range(this.tail.high+1,high));
	}
	return g;
}

// nitobi.collections.BlockMap.prototype.dispose = function() - Inherits from CacheMap
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.collections");

/**
 * Creates a CellSet object to manage a contiguous set of "cell" data.
 * @class nitobi.collections.CellSet is a contiguous set of cells. The endpoints can be specified in any fashion, 
 * but the set will be addressed from top left to botom right.
 * @constructor
 * @param {nitobi.grid.Grid} owner  The nitobi.grid.Grid object on whose cells the set sits. 
 * (Note: owner must implement getCellObject(x,y))
 * @param {Number} startRow The row index of the start cell of the set.
 * @param {Number} startColumn The column index of the start column of the set.
 * @param {Number} endRow The row index of the end cell of the set.
 * @param {Number} endColumn The column index of the end cell of the set.
 */
nitobi.collections.CellSet = function(owner, startRow, startColumn, endRow, endColumn)
{
	this.owner = owner;
	if (startRow != null && startColumn != null && endRow != null && endColumn != null)
	{
		this.setRange(startRow, startColumn, endRow, endColumn);
	}
	else
	{
		this.setRange(0,0,0,0);
	}
};

/**
 * Converts the CellSet into a string of the form "[0,1][0,4]"
 * @type String
 */
nitobi.collections.CellSet.prototype.toString = function()
{
	var str = "";
	for (var i = this._topRow; i <= this._bottomRow; i++)
	{
		str += "["
		for (var j = this._leftColumn; j <= this._rightColumn; j++)
		{
			str += "("+i+","+j+")";
		}
		str += "]";
	}
	return str;
};

/**
 * Sets the endpoints of the set of cells on the grid to which the cellset refers.
 * @param {Number} startRow The row index of the start cell of the set.
 * @param {Number} startColumn The column index of the start column of the set.
 * @param {Number} endRow The row index of the end cell of the set.
 * @param {Number} endColumn The column index of the end cell of the set.
 */
nitobi.collections.CellSet.prototype.setRange = function(startRow, startColumn, endRow, endColumn)
{
	ntbAssert(startRow != null && startColumn != null && endRow != null && endColumn != null, "nitobi.collections.CellSet.setRange requires startRow, startColumn, endRow, endColumn as integers",null,EBA_THROW);
	this._startRow = startRow;
	this._startColumn = startColumn;
	this._endRow = endRow;
	this._endColumn = endColumn;
	
	this._leftColumn = Math.min(startColumn, endColumn);
	this._rightColumn = Math.max(startColumn, endColumn);
	this._topRow = Math.min(startRow, endRow);
	this._bottomRow = Math.max(startRow, endRow);
};

/**
 * Increases or decreases the size of the CellSet by changing the location of the starting cell.
 * @param {Number} startRow The row index of the start cell of the set.
 * @param {Number} startColumn The column index of the start cell of the set.
 */
nitobi.collections.CellSet.prototype.changeStartCell = function(startRow, startColumn)
{
	this._startRow = startRow;
	this._startColumn = startColumn;
	
	this._leftColumn = Math.min(startColumn, this._endColumn);
	this._rightColumn = Math.max(startColumn, this._endColumn);
	this._topRow = Math.min(startRow, this._endRow);
	this._bottomRow = Math.max(startRow, this._endRow);
};

/**
 * Increases or decreases the size of the CellSet by changing the location of the ending cell.
 * @param {Number} startRow The row index of the end cell of the set.
 * @param {Number} startColumn The column index of the end cell of the set.
 */
nitobi.collections.CellSet.prototype.changeEndCell = function(endRow, endColumn)
{
	this._endRow = endRow;
	this._endColumn = endColumn;
	
	this._leftColumn = Math.min(endColumn, this._startColumn);
	this._rightColumn = Math.max(endColumn, this._startColumn);
	this._topRow = Math.min(endRow, this._startRow);
	this._bottomRow = Math.max(endRow, this._startRow);
};


/**
 * Returns the number of rows in the CellSet
 * @type Number
 */
nitobi.collections.CellSet.prototype.getRowCount = function()
{
	return this._bottomRow - this._topRow + 1;
};

/**
 * Returns the number of columns in the CellSet
 * @type Number
 */
nitobi.collections.CellSet.prototype.getColumnCount = function()
{
	return this._rightColumn - this._leftColumn +1 ;
};

/**
 * An inline object where object.top is the nitobi.drawing.Point object for the top left cell and object.bottom 
 * is the nitobi.drawing.Point object for the bottom right cell
 * @type Object
 * @see nitobi.drawing.Point
 */
nitobi.collections.CellSet.prototype.getCoords = function()
{
	return {'top':new nitobi.drawing.Point(this._leftColumn,this._topRow), 'bottom':new nitobi.drawing.Point(this._rightColumn,this._bottomRow)};
};

/**
 * Returns the cell object at a position in the container offset from the top left cell in the CellSet
 * @param {Number} relRow  The row index (indexed from 0 at the top of the CellSet) of the desired cell.
 * @param {Number} relColumn The column index (indexed from 0 at the leftmost column in the CellSet) of the desired cell.
 * @type nitobi.grid.Cell
 */
nitobi.collections.CellSet.prototype.getCellObjectByOffset = function(relRow, relColumn)
{
	return this.owner.getCellObject(this._topRow+relRow, this._leftColumn + relColumn);
};

///**
// * Clears the contents of the cells in the CellSet
// */
//nitobi.collections.CellSet.prototype.clear = function()
//{
//	// Out of scope for 2006-06-09 sprint http://portal:8090/cgi-bin/trac.cgi/milestone/Grid%203.1%20-%20Copy%20%26%20Paste%20Sprint
//}
//
///**
// * Fills the cells in the cellset with a specified value
// * @param {String} fillString The string that each cell in the CellSet will contain when fill() completes
// */
//nitobi.collections.CellSet.prototype.fill = function(fillString)
//{
//	// Out of scope for 2006-06-09 sprint http://portal:8090/cgi-bin/trac.cgi/milestone/Grid%203.1%20-%20Copy%20%26%20Paste%20Sprint
//}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.collections');

/**
 * Creates a CacheNode object that maintains a value range.
 * @constructor
 * @class
 * nitobi.collections.CacheNode is a node in a nitobi.collections.CacheMap object.
 * It is characterised by references to a previous and next node 
 * as well as a high and low value.
 * @param {Number} low The low argument is the low end of the nitobi.collections.CacheNode range (inclusive)
 * @param {Number} high The high argument is the high end of the nitobi.collections.CacheNode range (inclusive)
 */
nitobi.collections.CacheNode = function(low,high)
{
	this.low = low;
	this.high = high;
	this.next = null;
	this.prev = null;
}

/**
 * Used to check to see if a value is in a given nitobi.collections.CacheNode.
 * @param {Number} val The value which is to be checked if exists in the nitobi.collections.CacheNode.
 */
nitobi.collections.CacheNode.prototype.isIn = function(val)
{
	return ((val >= this.low) && (val <= this.high));
}

/**
 * Merges this node with it's next neighbour if necessary.
 * ie. if this node is [0,10] and next is [11,20] or [4,20], 
 * we will make a [0,20] node.
 * @type {Boolean}
 */
nitobi.collections.CacheNode.prototype.mergeNext = function()
{
	var next = this.next;
	if (next!=null && next.low<=this.high+1)
	{
		this.high = Math.max(this.high,next.high);
		this.low  = Math.min(this.low, next.low );
		var nextNext = next.next;
		this.next = nextNext; // this.next.next may be null, that's fine.
		if (nextNext != null)
		{
			nextNext.prev = this;
		}
		next.clear();
		return true;
	}
	else {
		return false;
	}
}

/**
 * Sets both the next and previous pointers to null.
 */
// TODO: This might need to be checked - should be checked in unit tests
nitobi.collections.CacheNode.prototype.clear = function()
{
	this.next = null;
	this.prev = null;
}

/**
 * Serializes the node to string in the [low,high] format.
 * @type String
 */
nitobi.collections.CacheNode.prototype.toString = function()
{
	return "[" + this.low + "," + this.high + "]";
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.collections');

nitobi.collections.Range = function(low,high)
{
	this.low=low;
	this.high=high;
}

nitobi.collections.Range.prototype.isIn = function(val)
{
  	return ((val>=this.low) && (val<=this.high));
}

nitobi.collections.Range.prototype.toString = function()
{
  	return "[" + this.low + "," + this.high + "]";
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.grid");

if (false)
{
	/**
	 * @namespace The namespace for classes that make up 
	 * the Nitobi Grid component.
	 * The most commonly used classes are {@link nitobi.grid.Grid}, {@link nitobi.grid.Cell},
	 * and {@link nitobi.grid.Column}
	 * @constructor
	 */
	nitobi.grid = function(){};
}

/**
 * Static property used to create a non-paging Grid.
 */
nitobi.grid.PAGINGMODE_NONE="none";
/**
 * Static property used to create a standard paging Grid.
 */
nitobi.grid.PAGINGMODE_STANDARD="standard";
/**
 * Static property used to create a live scrolling Grid.
 */
nitobi.grid.PAGINGMODE_LIVESCROLLING="livescrolling";

/*
standard - remote standard paging (no caching)
livescrolling - remote livescrolling (with caching)
localpaging - local paging
nonpaging - local or remote data with no paging
smartpaging - remote standard paging (with caching)
locallivescrolling - local livescrolling
*/

/**
 * Creates a new Grid component.
 * @class The nitobi.grid.Grid class is used to create Grid components. More often than not, you'll be instantiating a Grid via a declaration.
 * For example, a databound grid declaration might look like this:
 * <pre class="code">
 * &lt;ntb:grid id="DataboundGrid" gethandler="get.do" savehandler="save.do" mode="livescrolling"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * A grid that uses locally defined data might declared like so:
 * </p>
 * <pre class="code">
 * &lt;ntb:grid id="SimpleGrid" width="350" height="300" mode="locallivescrolling" datasourceid="data" toolbarenabled="true"&gt;
 * 	&lt;ntb:datasources&gt;
 *		&lt;ntb:datasource id="data"&gt;
 *			&lt;ntb:datasourcestructure FieldNames="Name|FavColor|FavAnimal"&nbsp;&nbsp;&gt;&lt;/ntb:datasourcestructure&gt;
 *			&lt;ntb:data&gt;
 *				&lt;ntb:e xi="1" a="Tammara Farley" b="blue" c="cat" &gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="2" a="Dwana Barton" b="red" c="dog"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="3" a="Lucas Blake" b="green" c="ferret"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="4" a="Lilli Bender" b="grey" c="squirrel"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="5" a="Emilia Foster" b="orange" c="pig"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="7" a="Crystal House" b="brown" c="horse"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="8" a="Lindsay Cohen" b="cyan" c="cow"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="12" a="Lindsay Bender" b="grey" c="squirrel"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="13" a="Emilia Foster" b="orange" c="pig"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="14" a="Dwana Irwin" b="beige" c="crocodile"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="15" a="Steve Lilli" b="brown" c="horse"&gt;&lt;/ntb:e&gt;
 *				&lt;ntb:e xi="16" a="Lindsay Dwana" b="cyan" c="cow"&gt;&lt;/ntb:e&gt;
 *			&lt;/ntb:data&gt;
 *		&lt;/ntb:datasource&gt;								
 *	&lt;/ntb:datasources&gt;
 * &lt;/ntb:grid&gt;
 * </pre>
 * The <code>mode</code> attribute on the <code>ntb:grid</code> declaration defines what sort of Grid to instantiate such as
 * LiveScrolling, LocalPaging, NonPaging, or Standard.
 * To instantiate through script a specific version of the Grid class should be instantiated such as: 
 * <pre class="code">
 * var myGrid = new nitobi.grid.GridLiveScrolling();
 * myGrid.setPagingMode(nitobi.grid.PAGINGMODE_LIVESCROLLING);
 * myGrid.setDataMode(nitobi.data.DATAMODE_CACHING);
 * myGrid.setGetHandler("data.xml");
 * myGrid.attachToParentDomElement(document.getElementById("myGrid"));
 * myGrid.bind();
 * </pre>
 * @constructor
 * @param {String} uid The unique ID of the Grid. 
 * @see nitobi.grid.GridLiveScrolling
 * @see nitobi.grid.GridNonpaging
 * @see nitobi.grid.GridLocalPage
 * @see nitobi.grid.GridStandard
 */
nitobi.grid.Grid = function(uid) {
	nitobi.prepare();
	// pre-compile accessors (if necessary)
	/**
	 * @private
	 */
	EBAAutoRender=false;

	/**
	 * @private
	 */
	this.disposal = [];

	/**
	 * @private
	 */
	this.uid = uid || nitobi.base.getUid();

	// TODO: Move this into a base class
	/**
	 * @private
	 * This is a hash of named attributes to XML DOM nodes (attributes or elements) in the Grid model.
	 */
	this.modelNodes = {};
	/**
	 * @private
	 * This is a hash of Grid Cell objects indexed by row_col.
	 */
	this.cachedCells = {};

	this.configureDefaults();

	//	First thing is to register the dispose method onunload.
	//	We do not use he regular unload mechanism since it will not get call
	//	cause it will be detached by the global nitobi unload cleanup method.
	//	This will add the disposed method to a custom list that will also be called on global unload
	if (nitobi.browser.IE6) {
		nitobi.html.addUnload(nitobi.lang.close(this, this.dispose));
	}

	// Attach event handlers
	this.subscribe("AttachToParent",this.initialize);
	this.subscribe("DataReady",this.layout);

	this.subscribe("AfterCellEdit",this.autoSave);
	this.subscribe("AfterRowInsert",this.autoSave);
	this.subscribe("AfterRowDelete",this.autoSave);
	this.subscribe("AfterPaste",this.autoSave);
	this.subscribe("AfterPaste",this.focus);

	// We need to check if the horizontal scroll bar needs to be drawn after it's
	// rendered and everytime the grid is resized.
	this.subscribeOnce("HtmlReady", this.adjustHorizontalScrollBars);
	this.subscribe("AfterGridResize", this.adjustHorizontalScrollBars)

	/**
	 * Various events that are attached to the root of the Grid HTML.
	 * @type Array
	 * @private
	 */
	this.events = [];

	/**
	 * Various events that are attached to the Grid scroller element that contains both the data and header.
	 * @type Array
	 * @private
	 */
	this.scrollerEvents = [];

	/**
	 * Various events that are attached to the Grid data element, which contains the rendered data cells.
	 * @type Array
	 * @private
	 */
	this.cellEvents = [];

	/**
	 * Various events that are attached to the Grid header element, which contains the column headers.
	 * @type Array
	 * @private
	 */
	this.headerEvents = [];

	/**
	 * Various key events that are attached to the Grid key navigator element.
	 * @type Array
	 * @private
	 */
	this.keyEvents = [];
}

nitobi.lang.implement(nitobi.grid.Grid, nitobi.Object);

var ntb_gridp = nitobi.grid.Grid.prototype;

nitobi.grid.Grid.prototype.properties = {
	// JS properties
	id:{n:"ID",t:"",d:"",p:"j"},
	selection:{n:"Selection",t:"",d:null,p:"j"},
	bound:{n:"Bound",t:"",d:false,p:"j"},
	registeredto:{n:"RegisteredTo",t:"",d:true,p:"j"},
	licensekey:{n:"LicenseKey",t:"",d:true,p:"j"},
	columns:{n:"Columns",t:"",d:true,p:"j"},
	columnsdefined:{n:"ColumnsDefined",t:"",d:false,p:"j"},
	declaration:{n:"Declaration",t:"",d:"",p:"j"},
	datasource:{n:"Datasource",t:"",d:true,p:"j"},
	keygenerator:{n:"KeyGenerator",t:"",d:"",p:"j"},
	version:{n:"Version",t:"",d:3.01,p:"j"},
	cellclicked:{n:"CellClicked",t:"",d:false,p:"j"},

		// XML properties
	uid:{n:"uid",t:"s",d:"",p:"x"},
	datasourceid:{n:"DatasourceId",t:"s",d:"",p:"x"},
	currentpageindex:{n:"CurrentPageIndex",t:"i",d:0,p:"x"},
	columnindicatorsenabled:{n:"ColumnIndicatorsEnabled",t:"b",d:true,p:"x"},
	rowindicatorsenabled:{n:"RowIndicatorsEnabled",t:"b",d:false,p:"x"},
	toolbarenabled:{n:"ToolbarEnabled",t:"b",d:true,p:"x"},
	toolbarheight:{n:"ToolbarHeight",t:"i",d:25,p:"x"},
	rowhighlightenabled:{n:"RowHighlightEnabled",t:"b",d:false,p:"x"},
	rowselectenabled:{n:"RowSelectEnabled",t:"b",d:false,p:"x"},
	gridresizeenabled:{n:"GridResizeEnabled",t:"b",d:false,p:"x"},
	widthfixed:{n:"WidthFixed",t:"b",d:false,p:"x"},
	heightfixed:{n:"HeightFixed",t:"b",d:false,p:"x"},
	minwidth:{n:"MinWidth",t:"i",d:20,p:"x"},
	minheight:{n:"MinHeight",t:"i",d:0,p:"x"},
	singleclickeditenabled:{n:"SingleClickEditEnabled",t:"b",d:false,p:"x"},
	autokeyenabled:{n:"AutoKeyEnabled",t:"b",d:false,p:"x"},
	tooltipsenabled:{n:"ToolTipsEnabled",t:"b",d:false,p:"x"},
	entertab:{n:"EnterTab",t:"s",d:"down",p:"x"},
	hscrollbarenabled:{n:"HScrollbarEnabled",t:"b",d:true,p:"x"},
	vscrollbarenabled:{n:"VScrollbarEnabled",t:"b",d:true,p:"x"},
	rowheight:{n:"RowHeight",t:"i",d:23,p:"x"},
	headerheight:{n:"HeaderHeight",t:"i",d:23,p:"x"},
	top:{n:"top",t:"i",d:0,p:"x"},
	left:{n:"left",t:"i",d:0,p:"x"},
	scrollbarwidth:{n:"scrollbarWidth",t:"i",d:22,p:"x"},
	scrollbarheight:{n:"scrollbarHeight",t:"i",d:22,p:"x"},
	freezetop:{n:"freezetop",t:"i",d:0,p:"x"},
	frozenleftcolumncount:{n:"FrozenLeftColumnCount",t:"i",d:0,p:"x"},
	rowinsertenabled:{n:"RowInsertEnabled",t:"b",d:true,p:"x"},
	rowdeleteenabled:{n:"RowDeleteEnabled",t:"b",d:true,p:"x"},
	asynchronous:{n:"Asynchronous",t:"b",d:true,p:"x"},
	autosaveenabled:{n:"AutoSaveEnabled",t:"b",d:false,p:"x"},
	columncount:{n:"ColumnCount",t:"i",d:0,p:"x"},
	rowsperpage:{n:"RowsPerPage",t:"i",d:20,p:"x"},
	forcevalidate:{n:"ForceValidate",t:"b",d:false,p:"x"},
	height:{n:"Height",t:"i",d:100,p:"x"},
	lasterror:{n:"LastError",t:"s",d:"",p:"x"},
	multirowselectenabled:{n:"MultiRowSelectEnabled",t:"b",d:false,p:"x"},
	multirowselectfield:{n:"MultiRowSelectField",t:"s",d:"",p:"x"},
	multirowselectattr:{n:"MultiRowSelectAttr",t:"s",d:"",p:"x"},
	gethandler:{n:"GetHandler",t:"s",d:"",p:"x"},
	savehandler:{n:"SaveHandler",t:"s",d:"",p:"x"},
	width:{n:"Width",t:"i",d:"",p:"x"},
	pagingmode:{n:"PagingMode",t:"s",d:"LiveScrolling",p:"x"},
	datamode:{n:"DataMode",t:"s",d:"Caching",p:"x"},
	rendermode:{n:"RenderMode",t:"s",d:"",p:"x"},
	copyenabled:{n:"CopyEnabled",t:"b",d:true,p:"x"},
	pasteenabled:{n:"PasteEnabled",t:"b",d:true,p:"x"},
	sortenabled:{n:"SortEnabled",t:"b",d:true,p:"x"},
	sortmode:{n:"SortMode",t:"s",d:"default",p:"x"},
	editmode:{n:"EditMode",t:"b",d:false,p:"x"},
	expanding:{n:"Expanding",t:"b",d:false,p:"x"},
	theme:{n:"Theme",t:"s",d:"nitobi",p:"x"},
	cellborder:{n:"CellBorder",t:"i",d:0,p:"x"},
	cellborderheight:{n:"CellBorderHeight",t:"i",d:0,p:"x"},
	innercellborder:{n:"InnerCellBorder",t:"i",d:0,p:"x"},
	dragfillenabled:{n:"DragFillEnabled",t:"b",d:true,p:"x"},
	
		// Events
	oncellclickevent:{n:"OnCellClickEvent",t:"",p:"e"},
	onbeforecellclickevent:{n:"OnBeforeCellClickEvent",t:"",p:"e"},
	oncelldblclickevent:{n:"OnCellDblClickEvent",t:"",p:"e"},
	ondatareadyevent:{n:"OnDataReadyEvent",t:"",p:"e"},
	onhtmlreadyevent:{n:"OnHtmlReadyEvent",t:"",p:"e"},
	ondatarenderedevent:{n:"OnDataRenderedEvent",t:"",p:"e"},
	oncelldoubleclickevent:{n:"OnCellDoubleClickEvent",t:"",p:"e"},
	onafterloaddatapageevent:{n:"OnAfterLoadDataPageEvent",t:"",p:"e"},
	onbeforeloaddatapageevent:{n:"OnBeforeLoadDataPageEvent",t:"",p:"e"},
	onafterloadpreviouspageevent:{n:"OnAfterLoadPreviousPageEvent",t:"",p:"e"},
	onbeforeloadpreviouspageevent:{n:"OnBeforeLoadPreviousPageEvent",t:"",p:"e"},
	onafterloadnextpageevent:{n:"OnAfterLoadNextPageEvent",t:"",p:"e"},
	onbeforeloadnextpageevent:{n:"OnBeforeLoadNextPageEvent",t:"",p:"e"},
	onbeforecelleditevent:{n:"OnBeforeCellEditEvent",t:"",p:"e"},
	onaftercelleditevent:{n:"OnAfterCellEditEvent",t:"",p:"e"},
	onbeforerowinsertevent:{n:"OnBeforeRowInsertEvent",t:"",p:"e"},
	onafterrowinsertevent:{n:"OnAfterRowInsertEvent",t:"",p:"e"},
	onbeforesortevent:{n:"OnBeforeSortEvent",t:"",p:"e"},
	onaftersortevent:{n:"OnAfterSortEvent",t:"",p:"e"},
	onbeforerefreshevent:{n:"OnBeforeRefreshEvent",t:"",p:"e"},
	onafterrefreshevent:{n:"OnAfterRefreshEvent",t:"",p:"e"},
	onbeforesaveevent:{n:"OnBeforeSaveEvent",t:"",p:"e"},
	onaftersaveevent:{n:"OnAfterSaveEvent",t:"",p:"e"},
	onhandlererrorevent:{n:"OnHandlerErrorEvent",t:"",p:"e"},
	onrowblurevent:{n:"OnRowBlurEvent",t:"",p:"e"},
	oncellfocusevent:{n:"OnCellFocusEvent",t:"",p:"e"},
	onfocusevent:{n:"OnFocusEvent",t:"",p:"e"},
	oncellblurevent:{n:"OnCellBlurEvent",t:"",p:"e"},
	onafterrowdeleteevent:{n:"OnAfterRowDeleteEvent",t:"",p:"e"},
	onbeforerowdeleteevent:{n:"OnBeforeRowDeleteEvent",t:"",p:"e"},
	oncellupdateevent:{n:"OnCellUpdateEvent",t:"",p:"e"},
	onrowfocusevent:{n:"OnRowFocusEvent",t:"",p:"e"},
	onbeforecopyevent:{n:"OnBeforeCopyEvent",t:"",p:"e"},
	onaftercopyevent:{n:"OnAfterCopyEvent",t:"",p:"e"},
	onbeforepasteevent:{n:"OnBeforePasteEvent",t:"",p:"e"},
	onafterpasteevent:{n:"OnAfterPasteEvent",t:"",p:"e"},
	onerrorevent:{n:"OnErrorEvent",t:"",p:"e"},
	oncontextmenuevent:{n:"OnContextMenuEvent",t:"",p:"e"},
	oncellvalidateevent:{n:"OnCellValidateEvent",t:"",p:"e"},
	onkeydownevent:{n:"OnKeyDownEvent",t:"",p:"e"},
	onkeyupevent:{n:"OnKeyUpEvent",t:"",p:"e"},
	onkeypressevent:{n:"OnKeyPressEvent",t:"",p:"e"},
	onmouseoverevent:{n:"OnMouseOverEvent",t:"",p:"e"},
	onmouseoutevent:{n:"OnMouseOutEvent",t:"",p:"e"},
	onmousemoveevent:{n:"OnMouseMoveEvent",t:"",p:"e"},
	onhitrowendevent:{n:"OnHitRowEndEvent",t:"",p:"e"},
	onhitrowstartevent:{n:"OnHitRowStartEvent",t:"",p:"e"},
	onafterdragfillevent:{n:"OnAfterDragFillEvent",t:"",p:"e"},
	onbeforedragfillevent:{n:"OnBeforeDragFillEvent",t:"",p:"e"},
	onafterresizeevent:{n:"OnAfterResizeEvent",t:"",p:"e"},
	onbeforeresizeevent:{n:"OnBeforeResizeEvent",t:"",p:"e"}
};

// This is a temporary thing to map lowercase attribute names to uppercase ones
nitobi.grid.Grid.prototype.xColumnProperties = {
	column: {
		align:{n:"Align",t:"s",d:"left"},
		classname:{n:"ClassName",t:"s",d:""},
		cssstyle:{n:"CssStyle",t:"s",d:""},
		columnname:{n:"ColumnName",t:"s",d:""},
		type:{n:"Type",t:"s",d:"text"},
		datatype:{n:"DataType",t:"s",d:"text"},
		editable:{n:"Editable",t:"b",d:true},
		initial:{n:"Initial",t:"s",d:""},
		label:{n:"Label",t:"s",d:""},
		gethandler:{n:"GetHandler",t:"s",d:""},
		datasource:{n:"DataSource",t:"s",d:""},
		template:{n:"Template",t:"s",d:""},
		templateurl:{n:"TemplateUrl",t:"s",d:""},
		maxlength:{n:"MaxLength",t:"i",d:255},
		sortdirection:{n:"SortDirection",t:"s",d:"Desc"},
		sortenabled:{n:"SortEnabled",t:"b",d:true},
		width:{n:"Width",t:"i",d:100},
		visible:{n:"Visible",t:"b",d:true},
		xdatafld:{n:"xdatafld",t:"s",d:""},
		value:{n:"Value",t:"s",d:""},
		xi:{n:"xi",t:"i",d:100},
		oncellclickevent:{n:"OnCellClickEvent"},
		onbeforecellclickevent:{n:"OnBeforeCellClickEvent"},
		oncelldblclickevent:{n:"OnCellDblClickEvent"},
		onheaderdoubleclickevent:{n:"OnHeaderDoubleClickEvent"},
		onheaderclickevent:{n:"OnHeaderClickEvent"},
		onbeforeresizeevent:{n:"OnBeforeResizeEvent"},
		onafterresizeevent:{n:"OnAfterResizeEvent"},
		oncellvalidateevent:{n:"OnCellValidateEvent"},
		onbeforecelleditevent:{n:"OnBeforeCellEditEvent"},
		onaftercelleditevent:{n:"OnAfterCellEditEvent"},
		oncellblurevent:{n:"OnCellBlurEvent"},
		oncellfocusevent:{n:"OnCellFocusEvent"},
		onbeforesortevent:{n:"OnBeforeSortEvent"},
		onaftersortevent:{n:"OnAfterSortEvent"},
		oncellupdateevent:{n:"OnCellUpdateEvent"},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	textcolumn: {
	},
	numbercolumn: {
		align:{n:"Align",t:"s",d:"right"},
		mask:{n:"Mask",t:"s",d:"#,###.00"},
		negativemask:{n:"NegativeMask",t:"s",d:""},
		groupingseparator:{n:"GroupingSeparator",t:"s",d:","},
		decimalseparator:{n:"DecimalSeparator",t:"s",d:"."},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	datecolumn: {
		mask:{n:"Mask",t:"s",d:"M/d/yyyy"},
		calendarenabled:{n:"CalendarEnabled",t:"b",d:true}
	},
	listboxeditor: {
		datasourceid:{n:"DatasourceId",t:"s",d:""},
		datasource:{n:"Datasource",t:"s",d:""},
		gethandler:{n:"GetHandler",t:"s",d:""},
		displayfields:{n:"DisplayFields",t:"s",d:""},
		valuefield:{n:"ValueField",t:"s",d:""},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	lookupeditor: {
		datasourceid:{n:"DatasourceId",t:"s",d:""},
		datasource:{n:"Datasource",t:"s",d:""},
		gethandler:{n:"GetHandler",t:"s",d:""},
		displayfields:{n:"DisplayFields",t:"s",d:""},
		valuefield:{n:"ValueField",t:"s",d:""},
		delay:{n:"Delay",t:"s",d:""},
		size:{n:"Size",t:"s",d:6},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"},
		forcevalidoption:{n:"ForceValidOption",t:"b",d:false},
		autocomplete:{n:"AutoComplete",t:"b",d:true},
		autoclear:{n:"AutoClear",t:"b",d:false},
		getonenter:{n:"GetOnEnter",t:"b",d:false},
		referencecolumn:{n:"ReferenceColumn",t:"s",d:""}
	},
	checkboxeditor: {
		datasourceid:{n:"DatasourceId",t:"s",d:""},
		datasource:{n:"Datasource",t:"s",d:""},
		gethandler:{n:"GetHandler",t:"s",d:""},
		displayfields:{n:"DisplayFields",t:"s",d:""},
		valuefield:{n:"ValueField",t:"s",d:""},
		checkedvalue:{n:"CheckedValue",t:"s",d:""},
		uncheckedvalue:{n:"UnCheckedValue",t:"s",d:""}
	},
	linkeditor: {
		openwindow:{n:"OpenWindow",t:"b",d:true}
	},
	texteditor: {
		maxlength:{n:"MaxLength",t:"i",d:255},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	numbereditor: {
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	textareaeditor: {
		maxlength:{n:"MaxLength",t:"i",d:255},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	dateeditor: {
		mask:{n:"Mask",t:"s",d:"M/d/yyyy"},
		calendarenabled:{n:"CalendarEnabled",t:"b",d:true},
		onkeydownevent:{n:"OnKeyDownEvent"},
		onkeyupevent:{n:"OnKeyUpEvent"},
		onkeypressevent:{n:"OnKeyPressEvent"},
		onchangeevent:{n:"OnChangeEvent"}
	},
	imageeditor: {
		imageurl:{n:"ImageUrl",t:"s",d:""}
	},
	passwordeditor: {
	}
};

nitobi.grid.Grid.prototype.typeAccessorCreators = {
	s:function() {}, //string
	b:function() {}, //bool
	i:function() {}, //integer
	n:function() {} //number
	};

nitobi.grid.Grid.prototype.createAccessors = function(name) {
	var item = nitobi.grid.Grid.prototype.properties[name];
	nitobi.grid.Grid.prototype["set"+item.n] = function() {this[item.p+item.t+"SET"](item.n, arguments)};
	nitobi.grid.Grid.prototype["get"+item.n] = function() {return this[item.p+item.t+"GET"](item.n, arguments)};
	nitobi.grid.Grid.prototype["is"+item.n] = function() {return this[item.p+item.t+"GET"](item.n, arguments)};
	nitobi.grid.Grid.prototype[item.n] = item.d;
}

//ntb_gridp.properties
for (var name in nitobi.grid.Grid.prototype.properties)
{
	nitobi.grid.Grid.prototype.createAccessors(name);
}

/**#@+
   @memberOf nitobi.grid.Grid
*/
/**
 * Initializes the component and creates all children objects of the component. This method is called implicitly 
 * when the component is attached to a DOM element in the web page. This is primarily for use by component developers
 */
nitobi.grid.Grid.prototype.initialize= function() 
{
	// Called when parent.addChild() occurs 
	this.fire("Preinitialize");
	this.initializeFromCss();
	this.createChildren(); // Each subclass overrides this method to create its own children
	this.fire("AfterInitialize");
	this.fire("CreationComplete");
}


/**
 * Initializes properties such as header height and row height from CSS classes.
 * @private
 */
nitobi.grid.Grid.prototype.initializeFromCss = function()
{
	this.CellHoverColor = this.getThemedStyle("ntb-cell-hover", "backgroundColor") || "#C0C0FF";
	this.RowHoverColor = this.getThemedStyle("ntb-row-hover", "backgroundColor") || "#FFFFC0";
	this.CellActiveColor = this.getThemedStyle("ntb-cell-active", "backgroundColor") || "#F0C0FF";
	this.RowActiveColor = this.getThemedStyle("ntb-row-active", "backgroundColor") || "#FFC0FF";

	var rowHeight = this.getThemedStyle("ntb-row", "height");
	if (rowHeight != null && rowHeight != "")
		this.setRowHeight(parseInt(rowHeight));

	var headerHeight = this.getThemedStyle("ntb-grid-header", "height");
	if (headerHeight != null && headerHeight != "")
		this.setHeaderHeight(parseInt(headerHeight));

	if (nitobi.browser.IE && nitobi.lang.isStandards()) {
		// We need to get the cell padding values
		var cellBorder = this.getThemedClass("ntb-cell-border");
		if (cellBorder != null)
			this.setCellBorder(parseInt(cellBorder.borderLeftWidth+0) + parseInt(cellBorder.borderRightWidth+0) + parseInt(cellBorder.paddingLeft+0) + parseInt(cellBorder.paddingRight+0));
	}
	
	var cellBorder = this.getThemedClass("ntb-cell-border");
		if (cellBorder != null)
			this.setCellBorder(parseInt(cellBorder.borderTopWidth+0) + parseInt(cellBorder.borderBottomWidth+0) + parseInt(cellBorder.paddingTop+0) + parseInt(cellBorder.paddingBottom+0));

	// In Firefox 3 we need to get the padding of the DIV inside the cell and subtract it
	// from the desired column width then set the width of the data so that overflow will be respected
	if (nitobi.browser.MOZ) {
		var cellBorder = this.getThemedClass("ntb-cell");
		if (cellBorder != null)
			this.setInnerCellBorder(parseInt(cellBorder.borderLeftWidth+0) + parseInt(cellBorder.borderRightWidth+0) + parseInt(cellBorder.paddingLeft+0) + parseInt(cellBorder.paddingRight+0));
	}
/*
	// TODO:
	// In IE standards mode we need to do some rowHeight and headerHeight adjustments for padding ...
	// Maybe in Firefox too ...
	var cellClass = nitobi.html.Css.getClass(".ntb-cell");
	var rowClass = nitobi.html.Css.getClass(".ntb-row"+this.uid);
	rowClass.height = parseInt(rowClass.height) - (parseInt(cellClass.paddingTop) + parseInt(cellClass.paddingTop));
*/
}

nitobi.grid.Grid.prototype.getThemedClass = function(clazz)
{
	var C=nitobi.html.Css;
	var r = C.getRule("." + this.getTheme() + " ." + clazz) || C.getRule("."+clazz);
	var ret = null;
	if (r != null && r.style != null)
		ret = r.style;
	return ret;
}


nitobi.grid.Grid.prototype.getThemedStyle = function(clazz, style)
{
	return nitobi.html.Css.getClassStyle("." + this.getTheme() + " ." + clazz, style);
}

/**
 * Sets the xmlDataSource property of the various renderers associated with the Grid. This method is called from connectToDataSet.
 * @private
 * @param {nitobi.data.DataSet} dataSet The DataSet to connect the renders to.
 * @see #connectToDataSet
 */
nitobi.grid.Grid.prototype.connectRenderersToDataSet= function(dataset) 
{
	this.TopLeftRenderer.xmlDataSource = dataset;
	this.TopCenterRenderer.xmlDataSource = dataset;
	this.MidLeftRenderer.xmlDataSource = dataset;
	this.MidCenterRenderer.xmlDataSource = dataset;
}

/**
 * Connects the component to a nitobi.data.DataTable in a nitobi.data.DataSet. 
 * If the DataTable is specified then this will also call conntectToDataTable(). 
 * Before a Grid can render any data it must be connected to a DataSet.
 * @param {nitobi.data.DataSet} dataSet The DataSet to connect the component to.
 * @param {nitobi.data.DataTable} dataTable The nitobi.data.DataSet to connect the component to.
 * @see #connectToDataSet
 * @private
 */
nitobi.grid.Grid.prototype.connectToDataSet= function(dataset,table) 
{
	this.data = dataset;
	// TODO: why is this here and when is it used?
	if (this.TopLeftRenderer) {

		this.connectRenderersToDataSet(dataset);
	}
	this.connectToTable(table);
}

/**
 * Connects a Grid to a table as specified by the table argument. If there is 
 * no table argument it will attempt to connect a table with the id '_default'. 
 * If no table can be found it will return false.  This is also called from 
 * conntectToDataSet if the second argument is used when calling that function.<br><br>
 * The component subscribes to the following events from the 
 * nitobi.data.DataTable:
 * &lt;ul&gt;
 * &lt;li&gt;RowCountChanged - nitobi.grid.Grid.setRowCount()&lt;/li&gt;
 * &lt;li&gt;RowCountKnown - nitobi.grid.Grid.setRowCount()&lt;/li&gt;
 * &lt;li&gt;StructureChanged - nitobigrid..Grid.updateStructure()&lt;/li&gt;
 * &lt;li&gt;ColumnsInitialized - nitobi.grid.Grid.updateStructure()&lt;/li&gt;
 * &lt;/ul&gt;
 * After the DataTable is connected, the OnTableConnectedEvent will fire.
 * @param {String} table The table to which the Grid should connect.
 * @type Boolean
 */
nitobi.grid.Grid.prototype.connectToTable= function(table) 
{
	// Use the table as the table id if it is a string
	if (typeof(table) == "string")
		this.datatable = this.data.getTable(table);
	// Use the table itself if it's an object
	else if (typeof(table) == "object")
		this.datatable = table;
	// Use the default table if it exists
	else if (this.data.getTable('_default')+'' != 'undefined')
		this.datatable = this.data.getTable('_default');
	// Otherwise we have problems
	else
		return false;

	this.connected=true;
	this.updateStructure();

	var dt = this.datatable;
	var L = nitobi.lang;

	dt.subscribe("DataReady",L.close(this,this.handleHandlerError));
	dt.subscribe("DataReady",L.close(this,this.syncWithData));
	dt.subscribe("DataSorted",L.close(this,this.syncWithData));
	dt.subscribe("RowInserted",L.close(this,this.syncWithData));
	dt.subscribe("RowDeleted",L.close(this,this.syncWithData));
	dt.subscribe("RowCountChanged",L.close(this,this.setRowCount));
	dt.subscribe("PastEndOfData",L.close(this,this.adjustRowCount));
	dt.subscribe("RowCountKnown",L.close(this,this.finalizeRowCount));
	dt.subscribe("StructureChanged",L.close(this,this.updateStructure));
	dt.subscribe("ColumnsInitialized",L.close(this,this.updateStructure));

	this.dataTableId = this.datatable.id;
	this.datatable.setOnGenerateKey(this.getKeyGenerator());

	this.fire('TableConnected', this.datatable);

	return true;
}

/**
 * Ensures that the Grid is connected to a DataTable. If there is no connected 
 * DataTable it will create a new DataTable with ID "_default" and use the 
 * GetHandler, SaveHandler and DataMode properties on the Grid.
 */
nitobi.grid.Grid.prototype.ensureConnected = function() 
{
	// Case: nodataSet has been been defined
	if (this.data == null) {
		this.data = new nitobi.data.DataSet();
		this.data.initialize();

		this.datatable = new nitobi.data.DataTable(this.getDataMode(), this.getPagingMode() == nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()},this.isAutoKeyEnabled());
		this.datatable.initialize("_default",this.getGetHandler(),this.getSaveHandler());
		this.data.add(this.datatable);
		this.connectToDataSet(this.data);
	}
	// Case: no dataTable has been defined
	// TODO: this only works with remote datasources ...
	// this is grid mode dependent.
	if (this.datatable == null) {
		this.datatable=this.data.getTable("_default");
		if (this.datatable == null) {
			this.datatable = new nitobi.data.DataTable(this.getDataMode(), this.getPagingMode() == nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()}, this.isAutoKeyEnabled());
			this.datatable.initialize("_default",this.getGetHandler(),this.getSaveHandler());
			this.data.add(this.datatable);
		}
		this.connectToDataSet(this.data);
	}
	this.connected=true;
}

/**
 * Updates the component with information about a connected DataTable. This will be called when the OnStructureChangedEvent 
 * or OnColumnsInitializedEvent is fired from the DataTable.
 * @private
 */
nitobi.grid.Grid.prototype.updateStructure = function() 
{
	if (this.inferredColumns) {
		this.defineColumns(this.datatable);
	}
	this.mapColumns();

	if (this.TopLeftRenderer)
	{
		this.defineColumnBindings();
		this.defineColumnsFinalize();
//		this.makeXSL();
	}
}

/**
 * Sets the <code>fieldMap</code> property of the Grid to match that of the connected DataTable. This is called from <code>updateStructure()</code>.
 * @private
 */
nitobi.grid.Grid.prototype.mapColumns= function() 
{
	// TODO: This seems a bit sketchy to keep in sync if we ever use this.fieldMap
	// if so we should be using a setter and preferably creating the connection between the two properties
	this.fieldMap = this.datatable.fieldMap;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.configureDefaults= function() 
{
	// Note: properties should be assigned before components are attached or initialized (to avoid duplicate code execution)
	// Assume that accessors expect that sub-components haven't been created yet.
	// Make settings quickly - defer work until validation

	this.initializeModel();
	this.displayedFirstRow=0;
	this.displayedRowCount=0;
	this.localFilter=null;
	this.columns = [];
	this.fieldMap = {};
	this.frameRendered = false;
	this.connected=false;
	this.inferredColumns=true;
	this.selectedRows = [];

	this.minHeight=20;
	this.minWidth=20;

	this.setRowCount(0);
	this.layoutValid=false;

	//	This is a hack for backwards compat
	//	It is set in the bind method by looking at the data format returned from the server
	this.oldVersion = false;

	// create XSL Processors
	this.frameCssXslProc = nitobi.grid.frameCssXslProc;
	this.frameXslProc = nitobi.grid.frameXslProc;
}

/**
 * Attaches any events to the component DOM elements after the intial render. Common DOM events attached here include KeyPress, SelectStart and ContextMenu.
 * @private
 * @align
 */
nitobi.grid.Grid.prototype.attachDomEvents= function()
{
	// The only way to attach the selection-prevention event in an XHTML compliant way.
	// This is only used (and will only work) for IE - for Moz/others we have CSS that handles it.
	ntbAssert(this.UiContainer!=null && nitobi.html.getFirstChild(this.UiContainer)!=null,'The Grid has not been attached to the DOM yet using attachToDom method. Therefore, attachDomEvents cannot proceed.',null,EBA_THROW);

	var dGridElement = this.getGridContainer();

	// Header specific events
	var he = this.headerEvents;
	he.push({type:'mousedown', handler:this.handleHeaderMouseDown});
	he.push({type:'mouseup', handler:this.handleHeaderMouseUp});
	he.push({type:'mousemove', handler:this.handleHeaderMouseMove});

	nitobi.html.attachEvents(this.getHeaderContainer(), he, this);

	// Data or cell specific events
	var ce = this.cellEvents;
	ce.push({type:'mousedown', handler:this.handleCellMouseDown});
	ce.push({type:'mousemove', handler:this.handleCellMouseMove});

	nitobi.html.attachEvents(this.getDataContainer(), ce, this);

	// Scroller specific (ie Header + Data) events
	//var se = this.scrollerEvents;
	//se.push({type:"selectstart", handler:function(evt) { return false; }});

	//nitobi.html.attachEvents(this.getScrollerContainer(), se, this);

	// Global Grid events
	var ge = this.events;
	ge.push({type:'contextmenu', handler:this.handleContextMenu});
	ge.push({type:'mousedown', handler:this.handleMouseDown});
	ge.push({type:'mouseup', handler:this.handleMouseUp});
	ge.push({type:'mousemove', handler:this.handleMouseMove});
	ge.push({type:'mouseout', handler:this.handleMouseOut});
	ge.push({type:'mouseover', handler:this.handleMouseOver});

	// TODO: decode these sorts of registrations in the event manager.
	if (!nitobi.browser.MOZ)
	{
		ge.push({type:'mousewheel', handler:this.handleMouseWheel});
	}
	else // MOZ
	{
		// Not sure this actually works since in the scorllhoriz and vert methods we focus again.
		nitobi.html.attachEvent($ntb("vscrollclip"+this.uid), "mousedown", this.focus, this);
		nitobi.html.attachEvent($ntb("hscrollclip"+this.uid), "mousedown", this.focus, this);

		// This one needs to be tested still ...
		ge.push({type:'DOMMouseScroll', handler:this.handleMouseWheel});
	}

	nitobi.html.attachEvents(dGridElement, ge, this, false);

	// For IE if we are selecting either the select box or a cell then return false.
	if (nitobi.browser.IE)
		dGridElement.onselectstart = function() {var id =window.event.srcElement.id;if (id.indexOf('selectbox') == 0 || id.indexOf('cell') == 0) return false;};

	// If it is IE we choose the entire grid to be the keyNav focused element 
	// otherwise we use a special hidden element for Firefox for foucs performance reason
	if (nitobi.browser.IE)
		this.keyNav = this.getScrollerContainer();
	else
		this.keyNav = $ntb("ntb-grid-keynav"+this.uid);

	this.keyEvents = [
		{type:'keydown', handler:this.handleKey},
		{type:'keyup', handler:this.handleKeyUp},
		{type:'keypress', handler:this.handleKeyPress}];

	nitobi.html.attachEvents(this.keyNav, this.keyEvents, this);

	// Attach the DOM events for grid resizing
	var rightGrabby = $ntb("ntb-grid-resizeright" + this.uid);
	var btmGrabby = $ntb("ntb-grid-resizebottom" + this.uid);
	if (rightGrabby != null)
	{
		nitobi.html.attachEvent(rightGrabby, "mousedown", this.beforeResize, this);
		nitobi.html.attachEvent(btmGrabby, "mousedown", this.beforeResize, this);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.hoverCell=function(cell) 
{
	// This will check if the BG color is the expected BG color
	// and only apply the hover if it is
	var h = this.hovered;
	if (h) {
		var hs = h.style;
		if (hs.backgroundColor == this.CellHoverColor)
			hs.backgroundColor = this.hoveredbg;
	}
	if (cell==null || cell==this.activeCell) return;
	var cs = cell.style;
	this.hoveredbg=cs.backgroundColor;
	this.hovered=cell;
	cs.backgroundColor = this.CellHoverColor;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.hoverRow=function(row) 
{
	if (!this.isRowHighlightEnabled()) return;

	var C = nitobi.html.Css;
	if (this.leftrowhovered && this.leftrowhovered!=this.leftActiveRow) {
		this.leftrowhovered.style.backgroundColor = this.leftrowhoveredbg;
		//C.removeClass(this.leftrowhovered, "ntb-row-hover", true);
	}
	if (this.midrowhovered && this.midrowhovered!=this.midActiveRow) {
		this.midrowhovered.style.backgroundColor = this.midrowhoveredbg;
		//C.removeClass(this.midrowhovered, "ntb-row-hover", true);
	}
	if (row==this.activeRow || row==null) return;

	var offset=-1;

	var rowCell = nitobi.html.getFirstChild(row);

	var rowNumber = nitobi.grid.Row.getRowNumber(row);
	var rowNodes = nitobi.grid.Row.getRowElements(this, rowNumber);

	if (rowNodes.left!=null && rowNodes.left!=this.leftActiveRow) {
		this.leftrowhoveredbg=rowNodes.left.style.backgroundColor;
		this.leftrowhovered=rowNodes.left;
		rowNodes.left.style.backgroundColor = this.RowHoverColor;
		//C.addClass(rowNodes.left, "ntb-row-hover", true);
	}

	if (rowNodes.mid!=null && rowNodes.mid!=this.midActiveRow) {
		this.midrowhoveredbg=rowNodes.mid.style.backgroundColor;
		this.midrowhovered=rowNodes.mid;
		rowNodes.mid.style.backgroundColor = this.RowHoverColor;
		//C.addClass(rowNodes.mid, "ntb-row-hover", true);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.clearHover = function()
{
	// Clear hover
	this.hoverCell();
	this.hoverRow();
}

/**
 * Event handler for the mouseover event.
 * @param {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleMouseOver = function(evt)
{
	this.fire("MouseOver", evt);
}

/**
 * Event handler for the mouseout event.
 * @param {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleMouseOut = function(evt)
{
	this.clearHover();
	this.fire("MouseOut", evt);
}

/**
 * Event handler for the mouse wheel event.
 * @param {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleMouseDown = function(evt)
{
	// check if grid is in edit mode - if so, validate input first
	//if (this.isEditMode())
		//if (!this.cellEditor.checkValidity(evt)) return;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.handleHeaderMouseDown=function(evt)
{
	var cell  = this.findActiveCell(evt.srcElement);
	if (cell==null) return;

	var colNumber = nitobi.grid.Cell.getColumnNumber(cell);

	if (this.headerResizeHover(evt, cell))
	{
		var col = this.getColumnObject(colNumber);
		var beforeColumnResizeEventArgs = new nitobi.grid.OnBeforeColumnResizeEventArgs(this, col);
		if (!nitobi.event.evaluate(col.getOnBeforeResizeEvent(), beforeColumnResizeEventArgs)) return;

		this.columnResizer.startResize(this, colNumber, cell, evt);

		return false;
	}
	else
	{
		this.headerClicked(colNumber);
		this.fire("HeaderDown", colNumber);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.handleCellMouseDown=function(evt)
{
	// At this point the srcElement could either be the selection or the cell
	var cell  = this.findActiveCell(evt.srcElement) || this.activeCell;
	if (cell==null) return;

	//	Check if the shift key is not pressed and if not then start selecting
	if (!evt.shiftKey)
	{
		// Fire the beforecellclick event on the grid and column
		var activeColumn = this.getSelectedColumnObject();
		var clickEventArgs = new nitobi.grid.OnCellClickEventArgs(this, this.getSelectedCellObject());
		if (!this.fire("BeforeCellClick", clickEventArgs) || (!!activeColumn && !nitobi.event.evaluate(activeColumn.getOnBeforeCellClickEvent(), clickEventArgs))) return;

		//Becomes the order of mouseup/mousedown events can get reversed in firefox, we need to make sure the mouseup
		//doesnt activate cell highlighting before mousedown completes.  All references to waitt are about controlling
		//this.  Without this fix, FireFox can start a cell highlight select process, especially if there are event handlers
		//hooked onto the mouse down processing.
		this.waitt = true;

		// Set the state variable indicating that we are have started a click...
		// This may turn into drag in cellMouseMove
		this.setCellClicked(true);

		// SetActiveCell will collapse the selection onto the specified cell
		this.setActiveCell(cell, evt.ctrlKey || evt.metaKey);

		if(this.waitt == true)
			this.selection.selecting=true;

		// Fire the cellclick event on the grid and column
		var activeColumn = this.getSelectedColumnObject();
		var clickEventArgs = new nitobi.grid.OnCellClickEventArgs(this, this.getSelectedCellObject());
		this.fire("CellClick", clickEventArgs);
		if (!!activeColumn) nitobi.event.evaluate(activeColumn.getOnCellClickEvent(), clickEventArgs);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.handleMouseUp = function(evtObj)
{
	// This mouseup may be due to a selection expansion - so lets just pass 
	// this on to the selection mouseup handler to where it will deal with it if we are in expanding mode.
	if (this.selection.selected()) {
		this.getSelection().handleSelectionMouseUp(evtObj);
	}
}

/**
 * MouseUp event handler for the Grid header.
 * @private
 */
nitobi.grid.Grid.prototype.handleHeaderMouseUp = function(evt)
{
	var domMouseUpCell = this.findActiveCell(evt.srcElement);
	if (!domMouseUpCell) 
	{
		this.focus();
		return;
	}
	var columnNumber = parseInt(domMouseUpCell.getAttribute("xi"));
	this.fire("HeaderUp",columnNumber);
}

/**
 * @private
 * Event handler for the mouse move event.
 */
nitobi.grid.Grid.prototype.handleMouseMove = function(evt) 
{
	this.fire("MouseMove", evt);
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.handleHeaderMouseMove=function(evt) {
	var cell=this.findActiveCell(evt.srcElement);
	if (cell == null) return;

	if (this.headerResizeHover(evt, cell)) {
		cell.style.cursor = "w-resize";
	} else {
		(nitobi.browser.IE?cell.style.cursor = "hand":cell.style.cursor = "pointer");
	}
}

/**
 * Calculates if the mouse if near the resize grabby
 * TODO: need to get rid of this and put in a DOM node for this 
 * @private
 * @param {Object} evt
 * @param {Object} cell
 */
nitobi.grid.Grid.prototype.headerResizeHover = function(evt, cell)
{
	var x = evt.clientX;
	var rect = nitobi.html.getBoundingClientRect(cell,0, (nitobi.grid.Cell.getColumnNumber(cell)>this.getFrozenLeftColumnCount()?this.scroller.getScrollLeft():0));
	return (x < rect.right && x > rect.right-10 );
}

/**
 * Manages the application of hover classes to column headers
 * @private
 */
nitobi.grid.Grid.prototype.handleHeaderMouseOver = function(e)
{
	// nitobi.html.Css.addClass(e, "ntb-hover", true); // one day we can use this ... when no one uses IE anymore
	e.className = e.className.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(){
		return arguments[1] + arguments[2] + "hover ";
	});
}

/**
 * Manages the application of hover classes to column headers
 * @private
 */
nitobi.grid.Grid.prototype.handleHeaderMouseOut = function(e)
{
	// nitobi.html.Css.removeClass(e, "ntb-hover", true);
	e.className = e.className.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(){
		return arguments[0].replace("hover", "");
	});
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.handleCellMouseMove=function(evt) {

	// Clear a possible cell clicked state
	this.setCellClicked(false);

	var cell=this.findActiveCell(evt.srcElement);
	if (cell == null) return;

	var sel = this.selection;
	if (sel.selecting)
	{
		var button = evt.button;
	
		var coords = nitobi.html.getEventCoords(evt);
		var x = coords.x, y = coords.y;
		if (nitobi.browser.IE)
			x = evt.clientX, y = evt.clientY;

		//	TODO: known bug with Mozilla - evt.button is ALWAYS 0 after the button is pressed!
		if (button == 1 || (button == 0 && !nitobi.browser.IE)) 
		{
			if (!sel.expanding) {
				sel.redraw(cell);
			} else {
				// If we are expanding we need to calculate which dir to expand - either horiz or vert.
				var selStartCoords = sel.expandStartCoords;
				// figure out which direction we are furthest from the original selection in terms of 1/2 cells
				var normEvtX = 0;
				if (x > selStartCoords.right)
					normEvtX = Math.abs(x - selStartCoords.right);
				else if (x < selStartCoords.left)
					normEvtX = Math.abs(x - selStartCoords.left);

				var normEvtY = 0;
				if (y > selStartCoords.bottom)
					normEvtY = Math.abs(y - selStartCoords.bottom);
				else if (y < selStartCoords.top)
					normEvtY = Math.abs(y - selStartCoords.top);

				if (normEvtY > normEvtX)
					expandDir = "vert";
				else
					expandDir = "horiz";

				sel.expand(cell, expandDir);
			}
			this.ensureCellInView(cell);
		}
		else
		{
			this.selection.selecting = false;
		}
	}
	else
	{
		this.hoverCell(cell);
		this.hoverRow(cell.parentNode);
		// TODO: onMouseOver event to be fired.
		//this.onMouseOver.notify();
	}
}

/**
 * Event handler for the mouse wheel event.
 * @param {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleMouseWheel = function(evtObj)
{
	this.focus() // blurs active cell; see ticket 871
	var delta = 0;
	if (evtObj.wheelDelta)
	{
		// IE
		delta = evtObj.wheelDelta/120;
	}
	else if (evtObj.detail)
	{
		// Mozilla
		delta = -evtObj.detail/3;
	}
	this.scrollVerticalRelative(-20*delta);
	nitobi.html.cancelEvent(evtObj);
}

/**
 * Sets the active cell of the Grid to the specified cell.
 * @param {HTMLElement} cell The HTML element for the cell to be made active.
 * @param {Boolean} multi Indicates whether multi-row select should be used.
 * @see #selectCellByCoords
 */
nitobi.grid.Grid.prototype.setActiveCell=function(cell,multi) 
{
	// At this point if cell is null we can't do the activation of the cell
	if (!cell) return;

	this.blurActiveCell(this.activeCell);

	// Focus the grid if it is not already focused
	// TODO: should this focus occur when this is done through the API?
	this.focus();

	// Update the active cell to the provided cell
	this.activateCell(cell);
	var activeColumnObject = this.activeColumnObject;

	// Setup the cell selection and ensure that the cell is in view.
	this.selection.collapse(this.activeCell);

	// Check if we are in a click process - if so then we need to wait to ensure cell in view 
	// otherwise it can cause the selection to go into select mode.
	if (!this.isCellClicked()) {
		this.ensureCellInView(this.activeCell);
		this.setCellClicked(false);
	}

	// Now set the active row
	var row = cell.parentNode;
	this.setActiveRow(row,multi);

	// Finally focus on the cell 
	// NOTE: The cell is focused after the row is focused and the cell is blurred before the row is blurred ...
	var focusEventArgs = new nitobi.grid.OnCellFocusEventArgs(this, this.getSelectedCellObject());
	this.fire("CellFocus", focusEventArgs);
	if (!!activeColumnObject) nitobi.event.evaluate(activeColumnObject.getOnCellFocusEvent(), focusEventArgs);
}

/**
 * @private 
 * Sets Grid properties activeCell, activeCellObject and activeColumnObject for the new active cell.
 * @param {HTMLElement} activeCell The new active cell in the Grid.
 */
nitobi.grid.Grid.prototype.activateCell = function(cell)
{
	this.activeCell = cell;
	this.activeCellObject = new nitobi.grid.Cell(this, cell);
	this.activeColumnObject = this.getSelectedColumnObject();
}


/**
 * @private
 * Blurs the currently active cell.
 * @param {HTMLElement} oldCell The previously selected cell. When bluring the entire grid 
 * one may want to set oldCell to be null. 
 */
nitobi.grid.Grid.prototype.blurActiveCell = function(oldCell) {
	// Setup the oldCell property which can be null if we are clearing the grid or the new activeCell otherwise
	this.oldCell = oldCell;
	// First do the blur stuff since this can happen if cell is null
	var oldColumn = this.activeColumnObject;
	var blurEventArgs = new nitobi.grid.OnCellBlurEventArgs(this, this.getSelectedCellObject());
	if (!!oldColumn)
		if(!this.fire("CellBlur", blurEventArgs) || !nitobi.event.evaluate(oldColumn.getOnCellBlurEvent(), blurEventArgs)) return;
	
}

/**
 * @deprecated
 * @private
 */
nitobi.grid.Grid.prototype.getRowNodes = function(row)
{
	return nitobi.grid.Row.getRowElements(this, nitobi.grid.Row.getRowNumber(row));
}

/**
 * Sets the active row of the Grid to the specified row.
 * @param {HTMLElement} row The HTML element for the row to be made active.
 * @param {Boolean} multi Indicates whether multi-row select should be used.
 */
nitobi.grid.Grid.prototype.setActiveRow=function(row,multi) 
{
	var Row = nitobi.grid.Row;

	var newRowNum = Row.getRowNumber(row);
	var oldRowNum = -1;

	// If there is an old row selected then gets its row number
	if (this.oldCell != null)
		oldRowNum = Row.getRowNumber(this.oldCell)
	if (this.selectedRows[0] != null)
		oldRowNum = Row.getRowNumber(this.selectedRows[0]);

	if (!multi || !this.isMultiRowSelectEnabled())
	{
		// Check if the old and newly selected / clicked rows are the same or not
		if (newRowNum != oldRowNum && oldRowNum != -1) {
			var blurEventArgs = new nitobi.grid.OnRowBlurEventArgs(this,this.getRowObject(oldRowNum));
			if (!this.fire("RowBlur", blurEventArgs) || !nitobi.event.evaluate(this.getOnRowBlurEvent(), blurEventArgs)) return;
		}
		this.clearActiveRows();
	}

	if (this.isRowSelectEnabled())
	{
		var rowNodes = Row.getRowElements(this, newRowNum);

		this.midActiveRow = rowNodes.mid;
		this.leftActiveRow = rowNodes.left;
		if (row.getAttribute("select")=="1") {
			this.clearActiveRow(row);
			for(var i =0;i<this.selectedRows.length;i++) {
				if (this.selectedRows[i] == row) {
					this.selectedRows.splice(i,1);
					break;
				}
			}
		} else {
			this.selectedRows.push(row);
			if (this.leftActiveRow!=null) {
				this.leftActiveRow.setAttribute("select","1");
				this.applyRowStyle(this.leftActiveRow);
			}
			if (this.midActiveRow!=null) {
				this.midActiveRow.setAttribute("select","1");
				this.applyRowStyle(this.midActiveRow);
			}
		}
	}
	if (newRowNum != oldRowNum) {
		var focusEventArgs = new nitobi.grid.OnRowFocusEventArgs(this,this.getRowObject(newRowNum));
		this.fire("RowFocus", focusEventArgs);
		nitobi.event.evaluate(this.getOnRowFocusEvent(), focusEventArgs);
	}
}

/**
 * Returns an Array of the currently selected rows in the Grid.  This is
 * particularly useful if your grid has multiselect enabled..
 * @example
 * // Iterate through the rows that have been selected and change
 * // the value of the cell at column index 'col' to "New Value!"
 * &#102;unction setDefault(col)
 * {
 * 	var grid = nitobi.getGrid('grid1');
 * 	var selectedRows = grid.getSelectedRows();
 * 
 * 	for( var i = 0; i < selectedRows.length; i++ ) 
 * 	{
 * 	var xi = selectedRows[i].getAttribute("xi");
 * 	var celly = grid.getCellObject(xi, col);
 * 	celly.setValue("New Value!");
 * 	}
 * }
 * @type Array
 * @see #getCellObject
 */
nitobi.grid.Grid.prototype.getSelectedRows=function() 
{
	return this.selectedRows;
}
/**
 * @private
 */
nitobi.grid.Grid.prototype.clearActiveRows=function() 
{
	for (var i=0;i<this.selectedRows.length;i++) {
		var row=this.selectedRows[i];
		this.clearActiveRow(row);
	}
	this.selectedRows = [];
}

/**
 * Selects all the rows in the Grid.
 * <p>
 * <b>N.B.</b>:  The grid must have multiselect enabled
 * </p>
 * @type Array
 */
nitobi.grid.Grid.prototype.selectAllRows=function() 
{
	this.clearActiveRows();
	for (var i=0;i<this.getDisplayedRowCount() ;i++ )
	{
		var cell = this.getCellElement(i,0);
		if (cell!=null)
		{
			var row = cell.parentNode
			this.setActiveRow(row,true);
		}
	}
	return this.selectedRows;
}
/**
 * Clears any active rows in the Grid.
 * @param {nitobi.grid.Row} row The currently active row to clear.
 */
nitobi.grid.Grid.prototype.clearActiveRow=function(row) 
{
	var rowNumber = nitobi.grid.Row.getRowNumber(row)
	var rowNodes = nitobi.grid.Row.getRowElements(this,rowNumber);

	if (rowNodes.left!=null) {
		rowNodes.left.removeAttribute("select");
		this.removeRowStyle(rowNodes.left);
	}
	if (rowNodes.mid!=null) {
		rowNodes.mid.removeAttribute("select");
		this.removeRowStyle(rowNodes.mid);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.applyCellStyle=function(cell) {
	if (cell==null) return;
	cell.style.background=this.CellActiveColor;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.removeCellStyle=function(cell) {
	if (cell==null) return;
	cell.style.background="";
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.applyRowStyle=function(row) {
	if (row==null) return;
	row.style.background=this.RowActiveColor;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.removeRowStyle=function(row) {
	if (row==null) return;
	row.style.background="";
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.findActiveCell = function(domSrcElem)
{
	var breakOut = 5;
	domSrcElem == null;
	for (var i=0; i<breakOut && domSrcElem.getAttribute; i++) 
	{
		var t=domSrcElem.getAttribute('ebatype');
		if (t=='cell' || t=='columnheader') return domSrcElem;
		domSrcElem = domSrcElem.parentNode;
	}
	return null;
}

/**
 * Attaches a component to the HTML DOM. If a component is created using 
 * script, this is an important method to use as 
 * it will cause the render of all unbound elements of the user-interface. 
 * This is primarily for use by component developers.
 * @param {HTMLElement} parentElement The HTML DOM element where the component 
 * will be rendered.
 */
nitobi.grid.Grid.prototype.attachToParentDomElement= function(parentElement) 
{
	this.UiContainer=parentElement;
	// This event key is created in the constructor and connected to initialize
	this.fire("AttachToParent");
}

/**
 * Returns all the toolbars currently being used in the grid.  The grid has two 
 * toolbars named standardToolbar and pagingToolbar. The pagingToolbar is only available
 * if the grid is set to standard mode.
 * @type nitobi.ui.Toolbars
 */
nitobi.grid.Grid.prototype.getToolbars = function()
{
	return this.toolbars;
}

/**
 * Checks if the horizontal scroll bar needs to be drawn and makes the proper adjustments
 * to the viewable area of the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.adjustHorizontalScrollBars = function()
{
	var viewableWidth = this.calculateWidth();
	var hScrollbarContainer = $ntb("ntb-grid-hscrollshow" + this.uid);
	
	var C = nitobi.html.Css;
	var viewport_Width = parseInt(C.getStyle(this.getScrollSurface(), "width"));
	
	if ((viewableWidth <= viewport_Width))
	{
		hScrollbarContainer.style.display = "none";
	}
	else
	{
		hScrollbarContainer.style.display = "block";
		this.resizeScroller();
		var pctW = viewport_Width/viewableWidth;
		this.hScrollbar.setRange(pctW);
	}
}

/**
 * Creats all children objects of the component. These can be visual or non-visual aspects of the component such as 
 * panels, toolbars or managers.
 * @private
 */
nitobi.grid.Grid.prototype.createChildren= function()
{
	var L = nitobi.lang;

	// *** OVERRIDE IN THIS FUNCTION IN INHERITED GRIDS BASED ON MODE ***

	// Creating children here streamlines startup performance
	// Give sub-classes first-crack at definining sub-components
	// Possibly call super.createChildren()
	// Defer creating dynamic and data-driven components to commitProperties()

	// Rules for adding children: 
	// 	1. Containers must contain only UIComponents
	//	2. UIComponents must go inside other UIComponents
	//	3. UIComponents can contain anything 
	ntbAssert((this.UiContainer!=null),"Grid must have a UI Container");

	if (this.UiContainer != null && this.getGridContainer() == null) {
		this.renderFrame();			// UI children need ui containers
	}

	this.generateFrameCss(); 	// *** BAD - genCss depends on Scroller - this shouldn't be so

	// Moved this to the createChildren method since it is a child of the Grid.
	// To fix the loading screen aligment problem it needs to be attached the grid tag - not the body

	var ls = this.loadingScreen = new nitobi.grid.LoadingScreen(this);
	this.subscribe("Preinitialize", L.close(ls,ls.show));
	this.subscribe("HtmlReady", L.close(ls,ls.hide));
	this.subscribe("AfterGridResize", L.close(ls,ls.resize));
	ls.initialize();
	
	// This is for the IE7 z-index bug!
	if(nitobi.browser.IE7 && nitobi.lang.isStandards())
	{
		ls.attachToElement($ntb("grid" + this.uid));
	}
	else
	{
		ls.attachToElement($ntb("ntb-grid-overlay" + this.uid));
	}
	
	ls.show();

//	nitobi.html.setBgImage($ntb("ntb-frozenshadow"+this.uid));

	// TODO: these resizers should be inheriting from one resizer base class to reduce code.
	/**
	 * The object that is responsible for managing runtime resizing of Grid Columns.
	 * @type nitobi.grid.ColumnResizer
	 * @private
	 */
	var cr = new nitobi.grid.ColumnResizer(this);
	cr.onAfterResize.subscribe(L.close(this, this.afterColumnResize));
	this.columnResizer = cr;

	/**
	 * The object that is responsible for managing runtime resizing of the Grid.
	 * @type nitobi.grid.GridResizer
	 * @private
	 */
	var gr = new nitobi.grid.GridResizer(this);
	gr.widthFixed = this.isWidthFixed();
	gr.heightFixed = this.isHeightFixed();
	gr.minWidth = this.getMinWidth();
	gr.minHeight = Math.max(this.getMinHeight(), (this.getHeaderHeight()+this.getscrollbarHeight()));
	gr.onAfterResize.subscribe(L.close(this, this.afterResize));
	this.gridResizer = gr;

	// TODO: Scroller is deprecated
	var sc = this.Scroller = this.scroller = new nitobi.grid.Scroller3x3(this, this.getHeight(), this.getDisplayedRowCount(), this.getColumnCount(), this.getfreezetop(), this.getFrozenLeftColumnCount());
	sc.setRowHeight(this.getRowHeight());
	sc.setHeaderHeight(this.getHeaderHeight());

	// Set up default key handlers - eventually move these out into editor factory
//	var kh = function(k) {if ((k > 64 && k < 91) || (k > 47 && k < 58) || (k > 95 && k < 111) || (k > 188 && k < 191) || (k == 113) ) {_this.edit();}};
//	var gh = function(k) {if (k==32) {var group =  _this.activeCell.getAttribute("xig");_this.toggleGroup(group);}}; 
//	this.keyHandlerFunc={"TEXT":kh,"PASSWORD":kh,"TEXTAREA":kh,"NUMBER":kh,"IMAGE":kh,"DATE":kh,"LISTBOX":kh,"LOOKUP":kh,"CHECKBOX":kh,"LINK":kh};

	// Subscribe to the HtmlReady event for things like afterrowinsert etc
	sc.onHtmlReady.subscribe(this.handleHtmlReady, this);
	// only connect the scrolled setDataTable method to the tableconnected event
	// once we know the scroller is defined.
	this.subscribe('TableConnected', L.close(sc, sc.setDataTable));
	// Since we may already have connected a datatable to the grid we need to explicitly
	// connect update the scroller when we create it
	// TODO: should this be a constructor / initialize argument instead? 
	sc.setDataTable(this.datatable);

	this.initializeSelection();

	this.createRenderers();

	// Attach renderers to Scroller views
	var sv = this.Scroller.view;
	sv.midleft.rowRenderer = this.MidLeftRenderer;
	sv.midcenter.rowRenderer = this.MidCenterRenderer;
	sv.topleft.rowRenderer=this.TopLeftRenderer;
	sv.topcenter.rowRenderer=this.TopCenterRenderer;


	this.mapToHtml();			// Children need dom references

	// Logic for features:
	// 	Paging Mode
	//		Overrides toolbars, scrollbars
	//	Toolbars
	//	Scrollbars

	// create Scrollbars
	var vs = this.vScrollbar = new nitobi.ui.VerticalScrollbar();
	vs.attachToParent(this.element, $ntb("vscroll"+this.uid));
	vs.subscribe("ScrollByUser",L.close(this,this.scrollVertical));
	this.subscribe("PercentHeightChanged",L.close(vs, vs.setRange)); // I had to do it this way ... context wasn't being passed properly
	this.subscribe("ScrollVertical",L.close(vs, vs.setScrollPercent)); 
	this.setscrollbarWidth(vs.getWidth());

//	this.subscribe("PercentHeightChanged",nitobi.lang.close(this,this.vScrollbar.setRange));
//	this.subscribe("PercentHeightChanged",this.vScrollbar.setRange,this);

	var hs = this.hScrollbar = new nitobi.ui.HorizontalScrollbar();
	hs.attachToParent(this.element, $ntb("hscroll"+this.uid));
	hs.subscribe("ScrollByUser",L.close(this,this.scrollHorizontal));
	this.subscribe("PercentWidthChanged",L.close(hs, hs.setRange)); // I had to do it this way ... context wasn't being passed properly
	this.subscribe("ScrollHorizontal",L.close(hs, hs.setScrollPercent));
	this.setscrollbarHeight(hs.getHeight());
}

/**
 * Creates the toolbars collection. Toolbars are always there in case
 * the programmer calls setToolbarEnabled(true).
 * 
 * @param {nitobi.ui.Toolbars.VisibleToolbars} visibleToolbars A bitmask representing which toolbars are being shown.
 * @private
 */
nitobi.grid.Grid.prototype.createToolbars = function(visibleToolbars)
{
	var tb = this.toolbars = new nitobi.ui.Toolbars(this, (this.isToolbarEnabled() ? visibleToolbars : 0) );
	var TBContainer = document.getElementById("toolbarContainer"+this.uid);
	tb.setWidth(this.getWidth());
	tb.setHeight(this.getToolbarHeight());
	tb.setRowInsertEnabled(this.isRowInsertEnabled());
	tb.setRowDeleteEnabled(this.isRowDeleteEnabled());
	tb.attachToParent(TBContainer); 



	var L = nitobi.lang;

	tb.subscribe("InsertRow",L.close(this,this.insertAfterCurrentRow));
	tb.subscribe("DeleteRow",L.close(this,this.deleteCurrentRow));
	tb.subscribe("Save",L.close(this,this.save));
	tb.subscribe("Refresh",L.close(this,this.refresh));

	this.subscribe("AfterGridResize", L.close(this,this.resizeToolbars));
}

/**
 * Called on the <code>AfterGridResize</code> event.
 * @private
 */
nitobi.grid.Grid.prototype.resizeToolbars = function()
{
	this.toolbars.setWidth(this.getWidth());
	this.toolbars.resize();
}

/**
 * Vertically scrolls the Grid relative to the current vertical scroll 
 * position.
 * <p>
 * If the Grid is in livescrolling mode, use of this method may cause
 * an asynchronous request to the server if more data is required to be
 * rendered--i.e. the behaviour is the same if you scroll programatically
 * or scroll using the mouse
 * </p>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.scrollVerticalRelative(150);
 * grid.scrollVerticalRelative(100);	// Moves the grid 250 pixels down
 * @param {Number} offset The amount by which to scroll the Grid with respect to its current vertical scroll value.
 */
nitobi.grid.Grid.prototype.scrollVerticalRelative= function(offset)
{
	var st = this.scroller.getScrollTop()+offset;

	var mc = this.Scroller.view.midcenter;
	percent = st /(mc.container.offsetHeight-mc.element.offsetHeight);

	this.scrollVertical(percent);
}

/**
 * Vertically scrolls the Grid to the position specfied by the percent 
 * argument. This will fire the OnScrollVerticalEvent 
 * and the OnScrollHitBottomEvent or OnScrollHitTopEvent if the scrollbar 
 * is with 1% of the bottom or top of the data respectively.
 * <p>
 * If the Grid is in livescrolling mode, use of this method may cause
 * an asynchronous request to the server if more data is required to be
 * rendered--i.e. the behaviour is the same if you scroll programatically
 * or scroll using the mouse
 * </p>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.scrollVertical(0.3);	// Scrolls the grid a third of the way to the bottom
 * grid.scrollVertical(0.5);	// Scrolls the grid half way to the bottom (not 80%)
 * @param {decimal} percent A value between 0 and 1 that specifies how far to vertically scroll, 0 being left and 1 being right.
 */
nitobi.grid.Grid.prototype.scrollVertical= function(percent)
{
	this.focus();
	this.clearHover();
	var origPct = this.scroller.getScrollTopPercent();
	this.scroller.setScrollTopPercent(percent);
	this.fire("ScrollVertical",percent);
	if (percent > .99 && origPct < .99) {
		this.fire("ScrollHitBottom",percent);
	}
	if (percent < .01) {
		this.fire("ScrollHitTop",percent);
	}
}

/**
 * Horizontally scrolls the Grid relative to the current horizontal scroll 
 * position.
 * <p>
 * Note that this differs from {@link #scrollHorizontal} in two ways.  One,
 * it takes an offset representing the number of pixels to scroll as opposed
 * to a percantage.  Two, this method will scroll relative to the current
 * position and not absolutely
 * </p>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.scrollHorizontalRelative(150);
 * grid.scrollHorizontalRelative(100);	// Moves the grid 250 pixels to the right
 * @param {Number} offset The pixel amount by which to scroll the Grid with 
 * respect to its current horizontal scroll value.
 */
nitobi.grid.Grid.prototype.scrollHorizontalRelative= function(offset)
{
	var sl = this.scroller.getScrollLeft()+offset;
	var mc = this.scroller.view.midcenter;
	percent = sl / (mc.container.offsetWidth-mc.element.offsetWidth);
	this.scrollHorizontal(percent);
}

/**
 * Horizontally scrolls the Grid to the position specfied by the percent 
 * argument. This will fire the <code>OnScrollHorizontalEvent</code> 
 * and the <code>OnScrollHitLeftEvent</code> or 
 * <code>OnScrollHitRightEvent</code> if the scrollbar is with 1% of the 
 * left or right of the data respectively.
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.scrollHorizontal(0.3);	// Scrolls the grid a third of the way to the right
 * grid.scrollHorizontal(0.5);	// Scrolls the grid half way to the right (not 80%)
 * @param {decimal} percent A value between 0 and 1 that specifies how far to horizontally scroll, 0 being left and 1 being right.
 */
nitobi.grid.Grid.prototype.scrollHorizontal= function(percent)
{
	this.focus();
	this.clearHover();
	this.scroller.setScrollLeftPercent(percent);
	this.fire("ScrollHorizontal",percent);
	if (percent > .99) {
		this.fire("ScrollHitRight",percent);
	}
	if (percent < .01) {
		this.fire("ScrollHitLeft",percent);
	}
}
/**
 * Gets a reference to the midcenter HTML element which is the main grid surface. This is commonly
 * used to get the scrollTop and scrollLeft values for the grid.
 * @private
 */
nitobi.grid.Grid.prototype.getScrollSurface = function()
{
	if (this.Scroller != null)
	{
		return this.Scroller.view.midcenter.element;
	}
}

/**
 * @private
 * @type nitobi.grid.Viewport
 */
nitobi.grid.Grid.prototype.getActiveView = function()
{
	var C = nitobi.grid.Cell;
	return this.Scroller.getViewportByCoords(
		C.getRowNumber(this.activeCell), 
		C.getColumnNumber(this.activeCell));
}

/**
 * Scrolls the Grid such that the specified cell is visible. 
 * If the cell argument is specified then it will scroll to make 
 * the provide cell visible.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction scrollToCell(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var cellElement = grid.getCellElement(row, col);
 * 	grid.ensureCellInView(cellElement);
 * }
 * </code></pre>
 * </div>
 * @param {HTMLElement} cell The cell that is to be in view.
 */
nitobi.grid.Grid.prototype.ensureCellInView=function(cell)
{
	var SS = this.getScrollSurface();

	var AC = cell || this.activeCell;
	if (AC == null) return;

	//	TODO: this is a big hack for Mozilla
	var sct=0;
	var scl=0;
	if (!nitobi.browser.IE) {
		sct = SS.scrollTop;
		scl = SS.scrollLeft;
	}

	var R1 = nitobi.html.getBoundingClientRect(AC);
	var R2 = nitobi.html.getBoundingClientRect(SS);

	var B = EBA_SELECTION_BUFFER || 0;

	var up=R1.top-R2.top-B-sct;
	var down=R1.bottom-R2.bottom+B-sct;
	var left=R1.left-R2.left-B-scl;
	var right=R1.right-R2.right+B-scl;

	if (up<0) this.scrollVerticalRelative(up);
	if (down>0) this.scrollVerticalRelative(down);

	if (nitobi.grid.Cell.getColumnNumber(AC) > this.getFrozenLeftColumnCount()-1) {
		if (left<0) this.scrollHorizontalRelative(left);
		if (right>0) this.scrollHorizontalRelative(right);
	}

	this.fire("CellCoordsChanged",R1);
}

/**
 * If the Grid is rendered, the Grid is updated to reflect the number of rows in the Grid DataTable. The change in data rows is 
 * also propagated to child object.
 * @private
 */
nitobi.grid.Grid.prototype.updateCellRanges= function() 
{
	if(this.frameRendered) {
		var rows = this.getRowCount();
		this.Scroller.updateCellRanges(this.getColumnCount(),rows,this.getFrozenLeftColumnCount(),this.getfreezetop());

		this.measure();
		this.resizeScroller();
		
		var height = this.isToolbarEnabled()?this.getHeight()-this.getToolbarHeight():this.getHeight();
		var hScrollbarContainer = $ntb("ntb-grid-hscrollshow" + this.uid);
		height = height - hScrollbarContainer.clientHeight;
		this.fire("PercentHeightChanged",(height)/this.calculateHeight());
		this.fire("PercentWidthChanged",this.getWidth()/this.calculateWidth());
	}
}

/**
 * Re-calculates the dimensions of the component.
 * @private
 */
nitobi.grid.Grid.prototype.measure= function() {
	// Invoked by the framework when a components invalidateSize is called
	// Components calculate their natural size based on content and layout rules
	// Implicitly invoked when component children change size
	// Don't count on it: Framework should optimize away calls to measure
	// Start by explicitly sizing component and implement measure() later.

/*	
	this.toolbarbox.measure();
	this.hscrollbarbox.measure();
	this.vscrollbarbox.measure();
	this.Scroller.measure();
*/

	this.measureViews();
	this.sizeValid=true;
}

/**
 * Calls both <code>measureColumns</code> and <code>measureRows</code>.
 * @private
 */
nitobi.grid.Grid.prototype.measureViews= function() {
	this.measureRows();
	this.measureColumns();	
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.measureColumns= function() {
	var fL=this.getFrozenLeftColumnCount();
	var wL = 0;
	var wT = 0;
	var colDefs = this.getColumnDefinitions();
	var cols = colDefs.length;
	for (var i=0; i<cols;i++) {
		if (colDefs[i].getAttribute("Visible") == "1" || colDefs[i].getAttribute("visible") == "1")
		{
			var w = Number(colDefs[i].getAttribute("Width"));
			wT+=w;
			if (i<fL) wL+=w;
		}
	}
	this.setleft(wL);
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.measureRows= function()
{
	var hdrH = this.isColumnIndicatorsEnabled()?this.getHeaderHeight():0;
	this.settop(this.calculateHeight(0,this.getfreezetop()-1) + hdrH); // should compute because heights may vary
}

/**
 * Resizes the scroller dimensions.
 * @private
 */
nitobi.grid.Grid.prototype.resizeScroller = function()
{
	var C = nitobi.html.Css;
	var viewport_Height = parseInt(C.getStyle(this.getScrollSurface(), "height"));
	
	// TODO: refactor, the toolbars should not be taken into account .... that should all alredy be set in the this.getHeight property 
	var tbDelta=(this.getToolbars() != null && this.isToolbarEnabled() ? this.getToolbarHeight() : 0);
	var hdrH = this.isColumnIndicatorsEnabled()?this.getHeaderHeight():0;
	var hScrollbarContainer = $ntb("ntb-grid-hscrollshow" + this.uid);
	var horizontalScrollBarHeight =  hScrollbarContainer.clientHeight;

	var scr_height = this.getHeight()-tbDelta-hdrH-horizontalScrollBarHeight;
	this.Scroller.resize(scr_height);
}
/**
 * Resizes the grid to the specified width and height. The size specified is the outermost container size
 * of the grid including toolbars, scrollbars and borders. 
 * @param {Number} width The width (in pixels) of the grid.
 * @param {Number} height The height (in pixels) of the grid.
 * @type Boolean
 */
nitobi.grid.Grid.prototype.resize= function(width, height) 
{
	this.setWidth(width);
	this.setHeight(height);

	// Just generate the CSS
	this.generateCss();

	// Then fix the toolbar
	this.fire("AfterGridResize", {source:this,width:width,height:height});
}

/**
 * Executes before a user initiated resize event occurs.
 * @param {Object} evt Event arguments 
 * @private
 */
nitobi.grid.Grid.prototype.beforeResize = function(evt)
{
	var beforeResizeEventArgs = new nitobi.base.EventArgs(this);
	if (!nitobi.event.evaluate(this.getOnBeforeResizeEvent(), beforeResizeEventArgs)) return;
	
	this.gridResizer.startResize(this, evt);
}

/**
 * Executes after a user initiated resize event occurs.
 * @private
 */
nitobi.grid.Grid.prototype.afterResize = function()
{
	this.resize(this.gridResizer.newWidth, this.gridResizer.newHeight);
	this.syncWithData();
}

/**
 * Executes after a user initiated column resize event occurs.
 * @param {Object} resizer Event arguments 
 * @private
 */
nitobi.grid.Grid.prototype.afterColumnResize = function(resizer)
{
	var col = this.getColumnObject(resizer.column);
	var prevWidth = col.getWidth();
	this.columnResize(col, prevWidth + resizer.dx);
}

/**
 * Resizes the grid column to the specified width. 
 * @param {Number} width The width (in pixels) of the column.
 * @param {Number|nitobi.grid.Column} column The index of the column to resize or the Column object.
 */
nitobi.grid.Grid.prototype.columnResize= function(column, width) 
{
	if (isNaN(width)) return;

	column = (typeof column == "object"?column:this.getColumnObject(column));
	var prevWidth = column.getWidth();
	column.setWidth(width);

	//	TODO: this is a hack to fix a problem with the fixed column header not resizing.
	// This was causing some hacky code to be added in EBASelection.collapse 
	// see the following - tix for details.
	// http://portal:8090/cgi-bin/trac.cgi/ticket/522
	this.updateCellRanges();

	/*
	 * This is absolutely stupid!  Not only does IE7 have issues with properly generating CSS, 
	 * but Firefox can't find style descriptors for styles that have both an ID and a style!
	 * 
	 * TODO: File a bug in Bugzilla and remove this check when 3.1 comes out?
	 * 
	 * Gecko FAIL!
	 */
	if (nitobi.browser.IE7 || nitobi.browser.FF3)
	{
		this.generateCss();
	}
	else
	{
		var columnIndex = column.column;
		var dx = width - prevWidth;
		var C = nitobi.html.Css;
		// Things are different if we are resizing a frozen or unfrozen column
		if (columnIndex < this.getFrozenLeftColumnCount())
		{
			var leftStyle = C.getClass(".ntb-grid-leftwidth"+this.uid);
			leftStyle.width = (parseInt(leftStyle.width) + dx) + "px";
			var centerStyle = C.getClass(".ntb-grid-centerwidth"+this.uid);
			centerStyle.width = (parseInt(centerStyle.width) - dx) + "px";
		}
		else
		{
			var surfaceStyle = C.getClass(".ntb-grid-surfacewidth"+this.uid);
			surfaceStyle.width = (parseInt(surfaceStyle.width) + dx) + "px";
		}
	
		// No matter what do the column class itself
		var columnStyle = C.getClass(".ntb-column"+this.uid+"_"+(columnIndex+1));
		columnStyle.width = (parseInt(columnStyle.width) + dx) + "px";
	
		this.adjustHorizontalScrollBars();
	}

	this.Selection.collapse(this.activeCell);

	var afterColumnResizeEventArgs = new nitobi.grid.OnAfterColumnResizeEventArgs(this, column);
	nitobi.event.evaluate(column.getOnAfterResizeEvent(), afterColumnResizeEventArgs);
}


/**
 * Loads the Grid Model from XML. The Model is essentially a serialization of the Grid state which contains all the property values and 
 * child object information.
 * @private
 */
nitobi.grid.Grid.prototype.initializeModel= function()
{
	this.model = nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.modelDoc));

	this.modelNode = this.model.documentElement.selectSingleNode("//nitobi.grid.Grid");

	// Setup the scrollbar width / height that depends on the Windows style that is used
	var scrollBarHeight = nitobi.html.getScrollBarWidth();
	if (scrollBarHeight)
	{
		this.setscrollbarWidth(scrollBarHeight);
		this.setscrollbarHeight(scrollBarHeight);
	}

	// Set up column definitions - Do this in XSL
	var xDec = this.model.selectSingleNode("state/nitobi.grid.Columns");
	if (xDec==null) {
		var xDec=this.model.createElement("nitobi.grid.Columns");		
		this.model.documentElement.appendChild(nitobi.xml.importNode(this.model, xDec, true));
	}

	var cols = this.getColumnCount();

	if (cols > 0)
	{
		// Generate column definitions
		this.defineColumns(cols);
	}
	else
	{
		this.columnsDefined=false;
		this.inferredColumns=true;		
	}

	this.model.documentElement.setAttribute("ID",this.uid);
	this.model.documentElement.setAttribute("uniqueID",this.uid);
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.clearDefaultData= function(rows) {
	// Set up default rows - Do this in XSL
	for (var i=0; i<rows;i++){
		var e=this.model.createElement("e");
		e.setAttribute("xi",i+1);
		xDec.appendChild(e);
	}
}

/**
 * Creates the renderers for the nine possilbe Viewports of the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.createRenderers= function() {
	var uniqueId = this.uid;
	var rowHeight = this.getRowHeight();
	var renderers = ["TopLeftRenderer","TopCenterRenderer","MidLeftRenderer","MidCenterRenderer"];
	for (var i=0; i<4; i++) {
		this[renderers[i]] = new nitobi.grid.RowRenderer(this.data,null,rowHeight,null,null,uniqueId);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.bind=function()
{
	//	bind() should do two things:
	//	1) look at all the columns and get any data for external datasources before grid rendering takes place
	//	2) get the actual grid datasource
	//	Columns can bind to datasources defined in the data that is returned from the server for the grid itself.
	//	They can also bind to a custom getHandler if they desire or even an inline datasource

	// If we are already bound to a datasource then we need to clear things out
	// to get ready for the the newly bound datatable.
	if (this.isBound())
	{
		this.clear();
		// TODO: Here temporarily. It should be in datatable.flush.
		// See that todo.
		this.datatable.descriptor.reset();
	}
}

/**
 * Connects the component to a DataTable. 
 * <p>If the data is located on a 
 * remote server then the GetHandler property is required to retrieve the 
 * data asynchronously from the remote server otherwise a DatasourceId is 
 * required if the data is already on the client. If the component was 
 * initialized using a declaration that contained column definitions these 
 * will be mapped to the columns in the data source using the 
 * &lt;ntb:datastructure ... /&gt; element returned from the remote data 
 * source. If there are no columns defined through either JavaScript or a 
 * declaration then the columns will be autogenerated from the data 
 * returned from the remote data source according to the 
 * &lt;ntb:datastructure ... /&gt; element.
 * </p>
 * @example
 * &#102;unction customRequest(gridId)
 * {
 * 	var grid = nitobi.getComponent(gridId);
 * 	var datatable = grid.getDataSource();
 * 	datatable.setGetHandlerParameter("param1", "value1");
 * 	grid.dataBind();
 * }
 * @see #getDataSource
 * @see nitobi.data.DataTable#setGetHandlerParameter
 */
nitobi.grid.Grid.prototype.dataBind = function()
{
	this.bind();
}

/**
 * Returns the DataTable with the specified id.
 * <p>
 * The DataTable represents the Grid's client side, XML based, data source.
 * </p>
 * @example
 * &#102;unction customRequest(gridId)
 * {
 * 	var grid = nitobi.getComponent(gridId);
 * 	var datatable = grid.getDataSource();
 * 	datatable.setGetHandlerParameter("param1", "value1");
 * 	grid.dataBind();
 * }
 * @param {String} paramTableId The id of the DataTable to return. If no table ID is specified 
 * the Grid DataTable is returned. Optional. 
 * @type nitobi.data.DataTable
 * @see nitobi.data.DataTable#setGetHandlerParameter
 * @see #dataBind
 */
nitobi.grid.Grid.prototype.getDataSource=function(paramTableId)
{
	var tableID = this.dataTableId || "_default";
	if(paramTableId)
		tableID = paramTableId;
	return this.data.getTable(tableID);
}

/**
 * Returns the change log from the specified DataTable. 
 * The change log records the rows that have been edited (insert/remove/edit).  The change log is used
 * to determine what rows to save.
 * <p>
 * <b>Example</b>:  Format of change log
 * </p>
 * <pre class="code">
 * &lt;ntb:grid xmlns:ntb="http://www.nitobi.com"&gt;
 * 	&lt;ntb:datasources id="id"&gt;
 * 		&lt;ntb:datasource id="_default"&gt;
 * 			&lt;ntb:datasourcestructure /&gt;
 * 			&lt;ntb:data id="_default"&gt;
 * 				&lt;ntb:e xi="0" xid="id0x04922bc02ntbcmp_0" a="CIA" b="Adhesive" c="4021010" d="4.66" e="24 - 250 g pkgs" f="20896" xac="u" /&gt;
 * 			&lt;/ntb:data&gt;
 * 		&lt;/ntb:datasource&gt;
 * 	&lt;/ntb:datasources&gt;
 * &lt;/ntb:grid&gt;
 * </pre>
 * @param {String} [paramTableId] The ID of the DataTable to retrieve the XML log for.  Can
 * be null if the grid is not using local data.
 * @type XMLDocument
 */
nitobi.grid.Grid.prototype.getChangeLogXmlDoc=function(paramTableId)
{
	return this.getDataSource(paramTableId).getChangeLogXmlDoc();
}

/**
 * Fired when a remote server call returns. This is the callback function used when for the server request made from the bind() method.
 * @param {nitobi.data.GetCompleteEventArgs}
 * @private
 */
nitobi.grid.Grid.prototype.getComplete=function(evtArgs) 
{
	// This is ok here, but we should use the error handlers in table data source.
	if(null == evtArgs.dataSource.xmlDoc)
	{
		ebaErrorReport("evtArgs.dataSource.xmlDoc is null or not defined. Likely the gethandler failed use fiddler to check the response","",EBA_ERROR);
		this.fire("LoadingError");
		return;
	}

	var dataSource = evtArgs.dataSource.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+evtArgs.dataSource.id+'\']');
	ntbAssert((null != dataSource), 'Datasource is not avialable in bindComplete handler.\n');
}

/**
 * Fired when binding - to either a local or remote datasource - is complete. 
 * At this point the the data is rendered and the Grid is ready for use.
 */
nitobi.grid.Grid.prototype.bindComplete=function()
{
	// If columns haven't been defined yet then define them
	// This is the case where the columns are defined by the data
	if (this.inferredColumns && !this.columnsDefined)
	{
		this.defineColumns(this.datatable);
	}
	
	// TODO: this setRowCount should not be here ...
	// TODO: But this is in conflict with grouping grid / block rendering mechanism so I am leaving it.  
	this.setRowCount(this.datatable.getRemoteRowCount());
	// The bound property indicates that events from the datasource to which
	// we are bound will now be able to cause re-renders of our interface
	this.setBound(true);

	this.syncWithData();
}
/**
 * Keeps the Grid UI surfaces in sync with the data in the connected DataTable.
 * @params {Object} [eventArgs]
 */
nitobi.grid.Grid.prototype.syncWithData=function(eventArgs)
{

	// Only if we are in the "Bound" state do we want to actually render changes to the data.
	if (this.isBound())
	{
		this.Scroller.render(true);
		this.fire("DataReady", {"source":this});
	}
}

/**
 * Sets RowCountKnown to true and sets the RowCount to the rows argument value. 
 * This method is subscribed to the OnRowCountKnownEvent event on the DataTable.
 * @param {Number} rows
 * @see #OnRowCountKnownEvent
 * @private
 */
nitobi.grid.Grid.prototype.finalizeRowCount= function(rows) 
{
	this.rowCountKnown=true;
	this.setRowCount(rows);
}
/**
 * Calls scrollVertical() with the pct argument. This method is subscribed to OnPastEndOfDataEvent of the DataTable.
 * @private
 * @param {Number} pct The percentage that the vertical scroll should be set to.
 * @see #OnPastEndOfData
 */
nitobi.grid.Grid.prototype.adjustRowCount= function(pct) 
{
//	alert("Past End-of-data "+ pct+" : "+this.rowCount)
	this.scrollVertical(pct);
//	this.setRowCount(scrollVertical)
}
/**
 * Sets the number of rows in the Grid
 * @private
 */
nitobi.grid.Grid.prototype.setRowCount= function(rows) 
{
	this.xSET("RowCount",arguments);
	if (this.getPagingMode() == nitobi.grid.PAGINGMODE_STANDARD) 
	{
		if (this.getDataMode() == nitobi.data.DATAMODE_LOCAL)
			this.setDisplayedRowCount(this.getRowsPerPage());
	} else {
		this.setDisplayedRowCount(rows);
	}
	this.rowCount=rows;

	//this.Scroller.setRowCount(); // maybe do this instead of updateCellRanges (more lightweight)
	this.updateCellRanges();
}

/**
 * Returns the number of rows in the Grid.
 * @type Number
 */
nitobi.grid.Grid.prototype.getRowCount= function() 
{
	return this.rowCount
}
/**
 * Applies all measurements that were calculated in <code>measure()</code> and adjusts layout or re-renders things that need to be re-rendered.
 * @private
 */
nitobi.grid.Grid.prototype.layout= function(columns) 
{
	if (this.prevHeight!=this.getHeight() || this.prevWidth!=this.getWidth()) {
		this.prevHeight=this.getHeight();
		this.prevWidth=this.getWidth();
		this.layoutValid=false;
	}
	if (!this.layoutValid && this.frameRendered) {
		this.layoutFrame();
		this.generateFrameCss();
		this.layoutValid=true;
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.layoutFrame= function(columns) 
{
	if (!this.frameRendered) return;		//Exit if frameRendered is not true
	if (!this.Scroller) return;				//Exit if Scroller not initialized
	
	this.minHeight=this.getMinHeight();
	this.minWidth=this.getMinWidth();

	var colScale = false;
	var rowScale = false;
	var tbH = this.getToolbarHeight(); 		// Height of toolbar;
	var rowH = this.getRowHeight(); 		// Height of a single row;
	var colW = 20; 							// Width = of a single column;
	var sbH = this.getscrollbarHeight(); 	// Height of Scrollbar;
	var sbW = this.getscrollbarWidth(); 	// Width of scrollbar;
	var hdrH = this.getHeaderHeight(); 	// Height of the header;

// TODO: is tbH really the height or is it the delta.
	tbH = this.isToolbarEnabled()?tbH:0;	// If toolbar is not visible, make its height value 0
	hdrH = this.isColumnIndicatorsEnabled?hdrH:0;

	var minH = Math.max(this.minHeight,tbH+rowH+sbH+hdrH);	// Note: need to calculate this value if width is a percent of container
	var maxH = this.Height;	// Note: need to calculate this value if height is a percent of container
	var minW = Math.max(this.minWidth,colW+sbW);
	var maxW = this.Width;

	// If columns can scale then use min and max surface widths, otherwise surface width is fixed
	if (colScale) {
		var minSW = this.Scroller.minSurfaceWidth;
		var maxSW = this.Scroller.maxSurfaceWidth;
	} else {
		var minSW = this.Scroller.SurfaceWidth;
		var maxSW = minSW;
	}
	// If rows can scale(not likely) then use min and max surface heights, otherwise surface height is fixed
	if (rowScale) {
		var minSH = this.Scroller.minSurfaceHeight;
		var maxSH = this.Scroller.maxSurfaceHeight;
	} else {
		var minSH = this.Scroller.SurfaceHeight;
		var maxSH = minSH;
	}

	// Calculate total height that would be required for vertical elements (without scrolling or scaling)
	var totalH = minSH + (tbH) + (hdrH); // Not including scrollbar
	// Calculate total that that would be required for horizontal elements (without scrolling or scaling)
	var totalW = minSW; // Not including scrollbar
	
	var VSvisible = (totalH > maxH); // This says scrollbar is required when the rows can't be scaled smaller and the  grid can't be scaled taller
	var HSvisible = (totalW > maxW); // This says scrollbar is required when the columns can't be scaled smaller andhe  grid can't be scaled wider

	var VSvisible = (HSvisible && ((totalH+20)>maxH)) || VSvisible; // Secondary check in case the additional height of the hscrollbar makes a vscrollbar necessary
	var HSvisible = (VSvisible && ((totalW+20)>maxW)) || HSvisible; // Secondary check in case the additional width of the vscrollbar makes a hscrollbar necessary

	sbH = HSvisible?sbH:0;	// If scrollbar is not visible, make its height value 0
	sbV = VSvisible?sbV:0;	// If scrollbar is not visible, make its width value 0

	// Now we have enough info to calculate 2 width dimensions and 4 height dimensions for the frame (looks like a 2x4 table)
		// Width dimensions
			// 1. Width of viewport (vpW)- calcutated
			// 2. Width of scrollbar (sbW)
		// Height dimenions
			// 1. Header height (hdrH)
			// 2. Height of visible rows (vpH) - calculated 
			// 3. Height of scrollbar (sbH)
			// 4. Height of toolbar (tbH)

	var vpH = totalH - hdrH - tbH - sbH;
	var vpW = totalW - sbW;

	// TODO: FROM GROUPING GRID
	this.resize();
}

/**
 * Defines the columns to be displayed in the Grid. Depending on the type of the columns argument different methods are dispatched to initialize the list of columns. 
 * As a String this property must be a bar ("|") seperated list of the column names in the nitobi.data.DataTable to which the Grid will connect. The XmlElement must 
 * contain a list column definitions as children XML nodes. Like the String type, the Array type specifies the column names in the nitobi.data.DataTable to which the 
 * Grid will connect. If an nitobi.data.DataTable is provided as the columns argument the columns in the nitobi.data.DataTable will define the columns in the Grid. 
 * Finally, if the columns argumnet is an integer it will prepare that number of columns to be defined at a later stage. OnBeforeColumnsDefinedEvent and OnAfterColumnsDefinedEvent 
 * are fired before and after this method is executed. This method is called from various places such as updateStructure(), commitProperties(), initializeModel(), and bindComplete().
 * @param {String | XmlElement | Array | nitobi.data.DataTable | Number} columns This is the description of the columns from which the Grid can determine the list of columns.
 * @see #OnAfterColumnsDefinedEvent
 * @see #OnBeforeColumnsDefinedEvent
 * @type XMLElement
 * @private
 */
nitobi.grid.Grid.prototype.defineColumns= function(columns) 
{
	this.fire("BeforeColumnsDefined"); // Everything other than the frame should be cleared
	this.resetColumns();

	//	get all the column defs
	var colDefs = null;
	var colType = nitobi.lang.typeOf(columns);

	this.inferredColumns=false;

	switch (colType)
	{
		case "string":
			colDefs = this.defineColumnsFromString(columns);
			break;
		case nitobi.lang.type.XMLNODE:
		case nitobi.lang.type.XMLDOC:
		case nitobi.lang.type.HTMLNODE:
			colDefs = this.defineColumnsFromXml(columns);
			break;
		case nitobi.lang.type.ARRAY:
			colDefs = this.defineColumnsFromArray(columns);
			break;
		case "object":
			this.inferredColumns=true;
			colDefs = this.defineColumnsFromData(columns);
			break;
		case "number":
			colDefs = this.defineColumnsCollection(columns);
			break;
		default:
	}

	this.fire("AfterColumnsDefined");
	this.defineColumnsFinalize();

	return colDefs;
}

/**
 * Defines the columns to be displayed in the Grid. The XMLElement must contain 
 * a list column definitions as children XML nodes and follow the Grid tag reference for the &lt;ntb:columns&gt; element.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnsFromXml= function(columns) 
{
	if (columns == null || columns.childNodes.length == 0)
	{
		return this.defineColumnsCollection(0);
	}

	// If we are using the old-style column definitions
	// then convert them to new-style defs
	if (columns.childNodes[0].nodeName == nitobi.xml.nsPrefix+'columndefinition')
	{
		var xslDoc = nitobi.grid.declarationConverterXslProc;
		columns = nitobi.xml.transformToXml(columns, xslDoc);
	}

	var wL = 0, wT = 0, wR = 0;
	var defaultColumnDef = this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column");

	// get the original list of columns from the model
	var originalCols = this.getColumnDefinitions().length;

	var cols = columns.childNodes.length;

	var xDec = this.model.selectSingleNode("state/nitobi.grid.Columns");

	ntbAssert((columns && columns.xml != ''), 'There are either no column definitions defined in the HTML declaration or they could not be parsed as valid XML.', "", EBA_DEBUG);

		var columnDefinitionsArray = columns.childNodes;

	//	TODO: these are set in intitializeModelFromDeclaration but maybe they should not be ...
	//	intitializeModelFromDeclaration is called immediately prior to this method
		var fL=this.getFrozenLeftColumnCount();

		// If the state of the grid has not been saved, we should have 0 columns 
		// in the model and go off the declaration.
		if (originalCols == 0) 
		{
			var cols = columnDefinitionsArray.length;
			for (var i=0; i<cols;i++) 
			{
				var col = columnDefinitionsArray[i];

				var columnDataType = '';
				var columnNodeName = col.nodeName;

				var editorNode = col.selectSingleNode("ntb:texteditor|ntb:numbereditor|ntb:textareaeditor|ntb:imageeditor|ntb:linkeditor|ntb:dateeditor|ntb:lookupeditor|ntb:listboxeditor|ntb:checkboxeditor|ntb:passwordeditor");
				var columnEditor = "TEXT";

				// Get the column datat type from the column node name
				var columnNames = {"ntb:textcolumn":"EBATextColumn",
								"ntb:numbercolumn":"EBANumberColumn",
								"ntb:datecolumn":"EBADateColumn"};
				var columnDataType = columnNames[columnNodeName].replace('EBA','').replace('Column','').toLowerCase();

				// Column editor name shows up in the column def as "type" and "editor"
				var columnEditorNames = {
								"ntb:numbereditor":"EBANumberEditor", 
								"ntb:textareaeditor":"EBATextareaEditor", 
								"ntb:imageeditor":"EBAImageEditor", 
								"ntb:linkeditor":"EBALinkEditor", 
								"ntb:dateeditor":"EBADateEditor", 
								"ntb:lookupeditor":"EBALookupEditor", 
								"ntb:listboxeditor":"EBAListboxEditor", 
								"ntb:passwordeditor":"EBAPasswordEditor", 
								"ntb:checkboxeditor":"EBACheckboxEditor"};

				if (editorNode != null) {
					// If there is an editor element defined then use it
					columnEditor = columnEditorNames[editorNode.nodeName] || columnEditor;
				} else {
					// If there is no editor element then use editor for the column data type
					columnEditor = columnNames[columnNodeName] || columnEditor;
				}
				columnEditor = columnEditor.replace('EBA','').replace('Editor','').replace('Column','').toUpperCase();

				var e = this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column[@DataType='"+(columnDataType)+"' and @type='"+columnEditor+"' and @editor='"+columnEditor+"']").cloneNode(true);

				this.setModelValues(e, col);

				var sColumnType = columnNames[col.nodeName] || "EBATextColumn";

				// Looks for Datasource attributes on the column and parses it
				// into a real datatable object.
 				this.defineColumnDatasource(e); 

				// By now ALL attributes are set.
				//	Except for maybe the DatasourceId
				this.defineColumnBinding(e);

				// This adds the column def to the grid's state.
				xDec.appendChild(e);

				// Adding gethandler data table.
				var gethandler = e.getAttribute('GetHandler');
				if (gethandler)
				{
					//	Careful, other objects have a handle to this one. If a new this.data is created, a copy is made
					//	since the old this.data is still in memory due to live handles.
					var datasourceId = e.getAttribute("DatasourceId");
					if (!datasourceId || datasourceId == '')
					{
						datasourceId = "columnDatasource_"+i+"_"+this.uid;
						e.setAttribute("DatasourceId", datasourceId);
					}

				
					var dt = new nitobi.data.DataTable('local', this.getPagingMode() == nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()}, this.isAutoKeyEnabled());
					dt.initialize(datasourceId, gethandler, null);
					dt.async = false;

					this.data.add(dt);

					var params = [];
					params[0] = e;

					// Do differnent things depending on the type of editor we are getting data for ...
					var sEditor = e.getAttribute("editor")
					var firstRow = null;
					var lastRow = null;
					// If this i a lookup we just want 1 record - or even none - just for the schema information 
					if (e.getAttribute("editor") == "LOOKUP")
					{
						// Get the first row of the data just to do the field mapping.
						firstRow = 0;
						lastRow = 1;
						dt.async = true;
					}

					// TODO: This is currently synchronous since we need the fieldMap information to render the column.
					dt.get(firstRow, lastRow, this, nitobi.lang.close(this, this.editorDataReady, [e]), function()
					{
						ntbAssert(false,'Datasource for '+e.getAttribute('ColumnName'),'',EBA_WARN);
					});
//					this.editorDataReady(e)
				}
			}

//			TODO: We should be doing something with measure ...
			this.measureColumns();

			this.setColumnCount(cols);

		}

		// This is where old-style datasources will be found
		var oldEditorDatasources;

		oldEditorDatasources = columns.selectSingleNode("/"+nitobi.xml.nsPrefix+"grid/"+nitobi.xml.nsPrefix+"datasources");

		if (oldEditorDatasources)
		{
			this.Declaration.datasources = nitobi.xml.createXmlDoc(oldEditorDatasources.xml);
		}

	// We use '//' in our xpath because the old columns will be enclosed in an ntb:grid 
	// object, but our new columns will be in an ntb:columns object.
	return xDec;
}
/**
 * Updates objects that are affected by changes to column structure.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnsFinalize = function()
{
	this.setColumnsDefined(true);
	if (this.connected) {
		if (this.frameRendered) {
			this.makeXSL(); //renderColumns depends on makeXSL
			this.generateColumnCss();
			this.renderHeaders();
		}
	}
}

/**
 * Parses a datasource from a column that could be defined either
 * from a Datasource attribute or a Datasource child declaration node.
 * This could also be extended to check for the DatasourceId property
 * or the getHandler property that are both defined elsewhere for the moment.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnDatasource = function(xColumnModel)
{
	var val = xColumnModel.getAttribute('Datasource');
	if (val != null)
	{
		var ds = new Array();
		// a datasource has been specified
		try
		{
			ds = eval(val);
		}
		catch(e)
		{
			// The datasource could not be parsed as a JavaScript array ... now what.
			var aNameValue = val.split(',');
			if (aNameValue.length >0)
			{
				for (var i=0; i<aNameValue.length; i++)
				{
					var item = aNameValue[i];
					ds[i] = {text:item.split(':')[0],display:item.split(':')[1]};
				}
			}
			return
		}
		if (typeof(ds) == "object" && ds.length > 0)
		{
			// it could be a JavaScript array datasource
			// in this case loop through the array and create a datasource
			var oDataTable = new nitobi.data.DataTable('unbound', this.getPagingMode() == nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()}, this.isAutoKeyEnabled());
			var sTableId = 'columnDatasource'+new Date().getTime();
			oDataTable.initialize(sTableId);
			xColumnModel.setAttribute('DatasourceId', sTableId);

			var sFields = '';
			// first look at one item in the array and get the fields list out of it
			for (var item in ds[0])
			{
				sFields += item + '|';
			}
			sFields = sFields.substring(0, sFields.length-1);

			// now init the datatable with our list of fields.
			oDataTable.initializeColumns(sFields);

			for (var i=0; i<ds.length; i++)
			{
				// create a record in the datatable
				oDataTable.createRecord(null, i);
				for (var item in ds[i])
				{
					oDataTable.updateRecord(i, item, ds[i][item]);
				}
			}
			this.data.add(oDataTable);

			this.editorDataReady(xColumnModel);
		}
	}
}

/**
 * @private
 */
/*
nitobi.grid.Grid.prototype.defineColumnEditor = function(xColumnModel, xColumnDeclaration)
{
	var len = xColumnDeclaration.childNodes.length; 
	if (len > 0)
	{
		var xEditorNode = xColumnDeclaration.selectSingleNode("ntb:texteditor|ntb:numbereditor|ntb:textareaeditor|ntb:imageeditor|ntb:linkeditor|ntb:dateeditor|ntb:lookupeditor|ntb:listboxeditor|ntb:checkboxeditor|ntb:passwordeditor");
		if (xEditorNode != null)
		{
			var sEditor = 'EBATextEditor';
			var sNodeName = xEditorNode.nodeName;

			if (sNodeName.indexOf("numbereditor") != -1) {
				sEditor = 'EBANumberEditor';
			} else if (sNodeName.indexOf("textareaeditor") != -1) {
				sEditor = 'EBATextareaEditor';
			} else if (sNodeName.indexOf("imageeditor") != -1) {
				sEditor = 'EBAImageEditor';
			} else if (sNodeName.indexOf("linkeditor") != -1) {
				sEditor = 'EBALinkEditor';
			} else if (sNodeName.indexOf("dateeditor") != -1) {
				sEditor = 'EBADateEditor';
			} else if (sNodeName.indexOf("lookupeditor") != -1) { 
				sEditor = 'EBALookupEditor';
			} else if (sNodeName.indexOf("listboxeditor") != -1) {
				sEditor = 'EBAListboxEditor';
			} else if (sNodeName.indexOf("passwordeditor") != -1) {
				sEditor = 'EBAPasswordEditor';
			} else if (sNodeName.indexOf("checkboxeditor") != -1) {
				sEditor = 'EBACheckboxEditor';
			}

			this.setModelDefaults(xColumnModel, xEditorNode, "interfaces/interface[@name='"+sEditor+"']/properties/property");
			this.setModelDefaults(xColumnModel, xEditorNode, "interfaces/interface[@name='"+sEditor+"']/events/event");
	
			xColumnModel.setAttribute("type", sNodeName.substring(4,sNodeName.indexOf("editor")).toUpperCase());
			xColumnModel.setAttribute("editor", sNodeName.substring(4,sNodeName.indexOf("editor")).toUpperCase());
		}
	}
	else
	{
		var columnNode = xColumnDeclaration;
		var sEditor = '';
		var sNodeName = columnNode.nodeName;

		if (sNodeName.indexOf("numbercolumn")) {
			sEditor = 'EBANumberEditor';
		} else if (columnNode.nodeName.indexOf("dateeditor")) {
			sEditor = 'EBADateEditor';
		}

		this.setModelDefaults(xColumnModel, columnNode, "interfaces/interface[@name='"+sEditor+"']/properties/property");
		this.setModelDefaults(xColumnModel, columnNode, "interfaces/interface[@name='"+sEditor+"']/events/event");

		xColumnModel.setAttribute("type", sNodeName.substring(4, sNodeName.indexOf("column")).toUpperCase());
	}
}
*/

/**
 * Defines the Grid columns from the information in a nitobi.data.DataTable. This can be used to infer the columns in a grid based on the columns that exist in the DataTable.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnsFromData= function(datatable) 
{
	if (datatable == null)
	{
		datatable = this.datatable;
	}
	// TODO: Explicit XPath statement
	var structureNode = datatable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasourcestructure');

	if (structureNode==null) {
		return this.defineColumnsCollection(0);
	}
	var fields = structureNode.getAttribute('FieldNames');
	if (fields.length==0) {
		return this.defineColumnsCollection(0);
	}

	var defaults = structureNode.getAttribute('defaults');

	var colDefs = this.defineColumnsFromString(fields);

	// Overlay type and width aspects (good place to infer editors)
	for (var i=0; i < colDefs.length; i++)
	{
		if (defaults && i<defaults.length) {
			colDefs[i].setAttribute("initial", defaults[i]||"");
		}
		colDefs[i].setAttribute("width", 100);
	}
	this.inferredColumns=true;

	return colDefs;
}

/**
 * Defines the Grid columns from a bar ("|") separated list of columns. The string value for each column is used for the label as well as the xdatafld binding property.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnsFromString= function(columns) 
{
	return this.defineColumnsFromArray(columns.split("|"));	
}
/**
 * Defines the Grid columns from an array of either string values or nitobi.components.grid.Column objects. 
 * It will also accept structs with the same field names that are in the nitobi.components.grid.Column class such as name, label, width, columntype, editortype, mask, initial.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnsFromArray= function(columns) 
{
	var cols = columns.length;
	var colDefs = this.defineColumnsCollection(cols);
	for (var i=0;i<cols;i++) {
		var col = colDefs[i];
		if (typeof(columns[i])=="string") {
			// Set the proper name of the column - this is the friendly database field name
			col.setAttribute("ColumnName",columns[i]);
			// Set the original xdatafld attribute - this just indicates at later stages
			// that this column has already had the xdatafld value converted
			col.setAttribute("xdatafld_orig",columns[i]);
			col.setAttribute("DataField_orig",columns[i]);
			col.setAttribute("Label",columns[i]);
			// Now set the xdatafld value to the actual fieldMap value
			if (typeof(this.fieldMap[columns[i]])!="undefined") {
				col.setAttribute("xdatafld", this.fieldMap[columns[i]]); // May have to use fieldMap
				col.setAttribute("DataField", this.fieldMap[columns[i]]); // May have to use fieldMap
			} else {
				col.setAttribute("xdatafld","unbound"); // Hack - should be able to omit - XSL requires a value here
				col.setAttribute("DataField","unbound"); // Hack - should be able to omit - XSL requires a value here
			}
		} else {
			if (columns[i].name != '_xk') // ???
			{
				// Set model values to those of the JS Array
				col.setAttribute("ColumnName", col.name);
				col.setAttribute("xdatafld_orig", col.name);
				col.setAttribute("DataField_orig", col.name);
				col.setAttribute("xdatafld", this.fieldMap[columns[i].name]);
				col.setAttribute("DataField", this.fieldMap[columns[i].name]);
				col.setAttribute("Width", col.width);
				col.setAttribute("Label", col.label);
				col.setAttribute("Initial", col.initial);
				col.setAttribute("Mask", col.mask);
			}
		}
	}
	this.setColumnCount(cols);
	return colDefs;	
}

/**
 * Binds the columns in the Grid to columns in the connected DataTable. This involves mapping the xdatafld property of each column to the corresponding
 * XPath query in the DataTable for the column with that name.
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnBindings = function() 
{
	//	If the columns are defined in the declaration we need to loop through and set
	//	the mappings from friendly column names like "ProductName" to @a etc.
	//	This can only be done once the data is ready
	var xslt = nitobi.grid.rowXslProc.stylesheet;
	var cols = this.getColumnDefinitions();
	for (var i=0; i<cols.length;i++) {
		var e = cols[i];
		//	Keep track of the actual database column name
		this.defineColumnBinding(e, xslt);
		e.setAttribute("xi",i);
	}
	nitobi.grid.rowXslProc = nitobi.xml.createXslProcessor(xslt);
}
/**
 * Method to set any special values on column definition for data binding
 * @private
 */
nitobi.grid.Grid.prototype.defineColumnBinding = function(element, xslt)
{
	if (this.fieldMap == null)
	{
		return;
	}
	var sFieldName = element.getAttribute("xdatafld");
	var sFieldNameOrig = element.getAttribute("xdatafld_orig");
	if (sFieldNameOrig == null || sFieldNameOrig == "")
	{
		element.setAttribute("xdatafld_orig", sFieldName);
		element.setAttribute("DataField_orig", sFieldName);
	} else {
		// Now get the original field name and set the column to that once more.
		// TODO: Not sure that I need this statement ...
		sFieldName = element.getAttribute("xdatafld_orig");
	}

	element.setAttribute("ColumnName", sFieldName);

	// Using the FieldName we now lookup the actual xpath from the fieldmap.
	var mappedName = this.fieldMap[sFieldName];
	if (typeof(mappedName) != "undefined")
	{
		element.setAttribute("xdatafld", mappedName);
		element.setAttribute("DataField", mappedName);
	}

	this.formatBinding(element, 'CssStyle', xslt);
	this.formatBinding(element, 'ClassName', xslt);
	this.formatBinding(element, 'Value', xslt);

//	else
//	{
//		element.setAttribute("xdatafld", 'unbound'); // hack here - it should never be unbound ...
//	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.formatBinding = function(element, attName, xslt)
{
	var attValue = element.getAttribute(attName);
	var attValueOrig = element.getAttribute(attName+"_orig");

	if (attValue == null || attValue == "")
		return;

	if (attValueOrig == null || attValueOrig == "")
		element.setAttribute(attName+"_orig", attValue);

	attValue = element.getAttribute(attName+"_orig");

	var re = new RegExp('\\{.[^\}]*}', 'gi');
	var exprMatches = attValue.match(re);

	if (exprMatches == null)
		return;

	for (var i=0; i<exprMatches.length; i++)
	{
		var origExpr = exprMatches[i];
		var newExpr = origExpr;

		var fieldRegex = new RegExp('\\$.*?[^0-9a-zA-Z\_]', 'gi');
		var fieldMatches = newExpr.match(fieldRegex);
		for (var j=0; j<fieldMatches.length; j++)
		{
			var fieldMatch = fieldMatches[j];
			var fieldExpr = fieldMatch.substring(0, fieldMatch.length-1);
			var dataField = fieldExpr.substring(1);
			var realField = this.fieldMap[dataField]+"";
//			if (realField != null) {
				newExpr = newExpr.replace(fieldExpr, realField.substring(1) || "");
//			} else
//				newExpr = newExpr.replace(fieldExpr, "");
		}
		newExpr = newExpr.substring(1,newExpr.length-1);
		//	newExpr = '&lt;xsl:value-of select="'+newExpr.substring(1,newExpr.length-1)+'"/&gt;';
		attValue = attValue.replace(origExpr, newExpr).replace(/\{\}/g, '');
	}
	element.setAttribute(attName, attValue);
}


/**
 * Defines the default columns based on the number of columns as specified by the cols argument.
 * @private
 * @param {Number} cols The number of columns that are going to be defined.
 */
nitobi.grid.Grid.prototype.defineColumnsCollection= function(cols) 
{
	// Get the existing columns collection
	var xDec = this.model.selectSingleNode("state/nitobi.grid.Columns");

	var colDefs = xDec.childNodes;
	var defaultColumnDef = this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column");
	// All columns are unbound by default (i.e. no xdatafld)
	for (var i=0; i<cols;i++) {
		var e = defaultColumnDef.cloneNode(true);
		xDec.appendChild(e);
		e.setAttribute("xi",i);
	//		e.setAttribute("xdatafld","@" +(i>25?String.fromCharCode(Math.floor(i/26)+97):"")+(String.fromCharCode(i%26+97)));
		e.setAttribute("title",(i>25?String.fromCharCode(Math.floor(i/26)+65):"")+(String.fromCharCode(i%26+65)));
	}
	this.setColumnCount(cols);
	var colDefs = xDec.selectNodes("*");
	return colDefs;
}

/**
 * Removes all the column definitions from the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.resetColumns=function() 
{
	// Delete existing cols
	this.fire("BeforeClearColumns");
	this.inferredColumns=true;
	this.columnsDefined=false;
	var Existing = this.model.selectSingleNode("state/nitobi.grid.Columns");

	//Create columns based upon #of columns
	var xDec=this.model.createElement("nitobi.grid.Columns");
	if (Existing==null) {
		this.model.documentElement.appendChild(xDec);
	} else {
		this.model.documentElement.replaceChild(xDec,Existing);
	}
	this.setColumnCount(0);
	this.fire("AfterClearColumns");
}

/**
 * If there are columns defined, renders the header of each column in the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.renderHeaders=function() 
{
	// If there are no column definitions then dont even try and render the columns...
	if (this.getColumnDefinitions().length > 0)
	{
		// Clear the header
		this.Scroller.clearSurfaces(false,true);

		// Top Left Corner
		var startRow = 0;
		endRow = this.getfreezetop()-1;

		// Top Left
		var tl = this.Scroller.view.topleft;
		// TODO: DONT NEED TO SET ELEMENT.INNERHTML = ""
		//tl.surface.element.innerHTML="";
		tl.top=this.getHeaderHeight();
		tl.left=0;
		tl.renderGap(startRow, endRow, false, '*');

		// Top Center
		var tc = this.Scroller.view.topcenter;
		// TODO: DONT NEED TO SET ELEMENT.INNERHTML = ""
		//tc.surface.element.innerHTML="";
		tc.top=this.getHeaderHeight();
		tc.left=0;
		tc.renderGap(startRow, endRow, false);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.initializeSelection = function() 
{
	var sel = new nitobi.grid.Selection(this, this.isDragFillEnabled());
	sel.setRowHeight(this.getRowHeight());
	sel.onAfterExpand.subscribe(this.afterExpandSelection, this);
	sel.onBeforeExpand.subscribe(this.beforeExpandSelection, this);
	sel.onMouseUp.subscribe(this.handleSelectionMouseUp, this);
	// this.Selection is for backwards compat
	this.selection = this.Selection = sel;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.beforeExpandSelection = function(evt)
{
	this.setExpanding(true);
	this.fire("BeforeDragFill", new nitobi.base.EventArgs(this, evt));
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.afterExpandSelection = function(evt)
{
	// Get the selection start and end size ...
	var sel = this.selection;

	var coords = sel.getCoords();

	var selectionTopRow = coords.top.y;
	var selectionBottomRow = coords.bottom.y;

	var selectionLeftColumn = coords.top.x;
	var selectionRightColumn = coords.bottom.x;

	var origData = this.getTableForSelection({top:{x:sel.expandStartLeftColumn,y:sel.expandStartTopRow},bottom:{x:sel.expandStartRightColumn,y:sel.expandStartBottomRow}});

	// Take the data in the start size and repeat it as many times as it can to generate some paste data
	// When we have selected up paste the start row we copy the data backwards up ..

	var data = "", pasteClipBoard = this.getClipboard();

	if (sel.expandingVertical) {
		if (sel.expandStartBottomRow > selectionBottomRow && selectionTopRow >= sel.expandStartTopRow) {
			// This is the case that we are reducing the size of the selection so clear any now unselected cells
			// Loop through columns that were initially selected and the rows that are now unselected and clear the values
			for (var i=sel.expandStartLeftColumn; i<=sel.expandStartRightColumn; i++)
			{
				for (var j=selectionBottomRow+1; j<sel.expandStartBottomRow+1; j++)
					this.getCellObject(j, i).setValue("");
			}
		} else {
			// Vertical expansion case ... just repeat rows
			var expandDown = (sel.expandStartBottomRow < selectionBottomRow);
			var expandUp = (sel.expandStartTopRow > selectionTopRow);
			var expand = (expandDown || expandUp);
			if (expand) {
				// Strip off the final newline character
				if (origData.lastIndexOf("\n") == origData.length-1)
					origData = origData.substring(0, origData.length-1);
	
				var rep = (Math.floor((sel.getHeight() - !expand) / sel.expandStartHeight))
				for (var i=0; i<rep; i++)
					data += origData + (!nitobi.browser.IE?"\n":"");
				origDataArr = origData.split("\n");
				var mod = (sel.getHeight() - !expand) % sel.expandStartHeight;
	
				var val = "";

				if (expandDown) {
					// Remove the extra data from the mod value to the end
					origDataArr.splice(mod, origDataArr.length - mod);
					// Concat the original + repeated data with the mod'ed data
					val = data + origDataArr.join("\n") + (origDataArr.length > 0?"\n":"");
				} else{
					// Remove the extra data from the mod value to the end
					origDataArr.splice(0, origDataArr.length - mod);
					// Concat the original + repeated data with the mod'ed data
					val = origDataArr.join("\n") + (origDataArr.length > 0?"\n":"") + data;
				}

				pasteClipBoard.value = val;
	
				this.pasteDataReady(pasteClipBoard);
			}
		}
	} else {
		if (sel.expandStartRightColumn > selectionRightColumn && selectionLeftColumn >= sel.expandStartLeftColumn)
		{
			// This is the case that we are reducing the size of the selection so clear any now unselected cells
			// Loop through rows that were initially selected and the columns that are now unselected and clear the values
			for (var i=selectionLeftColumn+1; i<=sel.expandStartRightColumn+1; i++)
			{
				for (var j=sel.expandStartTopRow; j<sel.expandStartBottomRow; j++)
					this.getCellObject(j, i).setValue("");
			}
		} else {
			// Horizontal expansion case ...
			var expandRight = sel.expandStartRightColumn < selectionRightColumn;
			var expandLeft = sel.expandStartLeftColumn > selectionLeftColumn;
			var expand = (expandRight || expandLeft);
			if (expand) {

				// Get the number of cells that are being expanded that are a fraction of a repeat block
				var mod = (sel.getWidth() - !expand) % sel.expandStartWidth;
	
				var newline = (!nitobi.browser.IE?"\n":"\r\n");
				// Strip off the final newline character
				if (origData.lastIndexOf(newline) == origData.length-newline.length)
					origData = origData.substring(0, origData.length-newline.length);
	
				// Get rid of any \r characters
				var origDataArr = origData.replace(/\r/g,"").split("\n");
				var data = new Array(origDataArr.length);
				var rep = (Math.floor((sel.getWidth() - !expand) / sel.expandStartWidth));
	
				// Iterate over each row in the original data and build the output
				for (var i=0; i<origDataArr.length; i++)
				{
					// Now append on any data beyond the end from the mod
					var origDataLineArr = origDataArr[i].split("\t");
	
					// Iterate over the number of times the full selection is repeated
					for (var j=0; j<rep; j++) {
						// The output data for a row is just the already generated data plus the the original data for that row again.
						data[i] = (data[i]==null?[]:data[i]).concat(origDataLineArr);
					}
	
					if (mod != 0) {
						// If we are expanding right
						if (expandRight) {
							data[i] = data[i].concat(origDataLineArr.splice(0, mod));
							// TODO: need to do something special here depending on Left or Right xpand
						} else {
							data[i] = origDataLineArr.splice(mod, origDataLineArr.length - mod).concat(data[i]);
						}
					}
					data[i] = data[i].join("\t");
				}
	
				pasteClipBoard.value = data.join("\n") + "\n";
				this.pasteDataReady(pasteClipBoard);
			}
		}
	}
	this.setExpanding(false);
	this.fire("AfterDragFill", new nitobi.base.EventArgs(this, evt));
	// TODO: support dragging to a smaller area ...
}

/**
 * Calculates the height of the rows in the Grid. If the start and end 
 * arguments are defined then it will calculate the height of those rows only.
 * @param {Number} start The zero based start row index.
 * @param {Number} end The end row index.
 * @type Number
 * @private
 */
nitobi.grid.Grid.prototype.calculateHeight = function(start, end) 
{
	start = (start != null)?start:0;
	var numRows = this.getDisplayedRowCount();
	end = (end != null)?end:numRows - 1;
	return (end - start + 1) * this.getRowHeight();
}

/**
 * Calculates the width of the columns in the Grid. If the start and end 
 * arguments are defined then it will calculate the width of those columns only.
 * @param {Number} start The zero based start column index.
 * @param {Number} end The end column index.
 * @type Number
 * @private
 */
nitobi.grid.Grid.prototype.calculateWidth= function(start, end) 
{
	var colDefs = this.getColumnDefinitions();
	var cols = colDefs.length;
	start = start || 0;
	end = (end != null)?Math.min(end,cols):cols;
	var wT = 0;
	for (var i=start; i<end;i++) {
		if (colDefs[i].getAttribute("Visible") == "1" || colDefs[i].getAttribute("visible") == "1") {
			wT+=Number(colDefs[i].getAttribute("Width"));
		}
	}
	return (wT);
}

/**
 * Resizes grid to size of container div
 */
nitobi.grid.Grid.prototype.maximize = function()
{
	// TODO: this should probably be parentNode rather than offsetParent?
 	var x,y;
	var off_p = this.element.offsetParent;
	
	x = off_p.clientWidth;
	y = off_p.clientHeight;
	
	this.resize(x,y);
}

//	Now that we have created the datasource we need to set the ValueField and DisplayFields from the old declaration ... or inline datasource maybe ...
/**
 * Connects column editors to datasources. The datsources can be local (specified with a DatasourceId or JSON array) or remote (specified with a GetHandler).
 * @param {XMLElement} column XML column node from declaration / state.
 * @private
 */
nitobi.grid.Grid.prototype.editorDataReady= function(column)
{
	//	TODO: all of these sorts of things should be done through an EBA API that checks if the attribute exists first etc.
	var displayFields = column.getAttribute('DisplayFields').split('|');
	var valueField = column.getAttribute("ValueField");

	//	Get the datasource for the column we are concerned with.
	var dataTable = this.data.getTable(column.getAttribute('DatasourceId'));

	var initial = column.getAttribute("Initial");
	if (initial == "")
	{
		var editorType = column.getAttribute("type").toLowerCase();
		switch (editorType)
		{
			case "checkbox":
			case "listbox":
			{
				var valueFieldAtt = dataTable.fieldMap[valueField].substring(1);
				var data = dataTable.getDataXmlDoc();
				if (data != null)
				{
					var val = data.selectSingleNode("//"+nitobi.xml.nsPrefix + "e[@" + valueFieldAtt + "='"+initial+"']");
					if (val == null)
					{
						var firstRow = data.selectSingleNode("//"+nitobi.xml.nsPrefix + "e");
						if (firstRow != null)
						{
							initial = firstRow.getAttribute(valueFieldAtt);
						}
					}
				}
				break;
			}
		}
		column.setAttribute("Initial", initial);
	}	

//	ntbAssert((displayFields.length != 1 && displayFields[0] != ''), 'There is no display field defined for a column of type lookup or listbox');

	if ((displayFields.length == 1 && displayFields[0] == '') && (valueField == null || valueField == ''))
	{
		//	This just gets the first item in the fieldMap hash if the displayFields have not been defined
		for (var item in dataTable.fieldMap)
		{
			displayFields[0] = dataTable.fieldMap[item].substring(1);
			break;
		}
	}
	else
	{
		//	Need to loop through the display fields to convert them to eba type attribute values
		for (var i=0; i<displayFields.length; i++)
		{
			displayFields[i] = dataTable.fieldMap[displayFields[i]].substring(1);
		}
	}
	var displayFieldsString = displayFields.join('|');

//	ntbAssert((valueField != null && valueField != ''), 'There is no value field defined for a column of type lookup or listbox');

	if (valueField == null || valueField == '')
	{
		//	Since there is no sign of the valueField then just set it the same as the displayField
		valueField = displayFields[0];
	}
	else
	{
		valueField = dataTable.fieldMap[valueField].substring(1);
	}

	column.setAttribute("DisplayFields", displayFieldsString);
	column.setAttribute("ValueField", valueField);
}
/*
nitobi.grid.Grid.prototype.calcForumlas = function(cell)
{
	//	Now we need to re-calculate all the formulas for this row ...
	var cols = this.columns;
	var len = cols.length;

	//	Loop through each column and see if it is of type formula ... if so we need to re-calc it
	for (var i=0; i<len; i++)
	{
		if (cols[i].type == "FORMULA")
		{
			//	re-calculate the formula ...
			var f = cols[i].xdatafld;
			var re = /$\{(.*?)\}/gi;
			var reBG = f.match(re);
			if (reBG != null)
			{
				var BGL = reBG.length;
				for (var j=0; j<BGL; j++)
				{
					var curfld = reBG[j].replace(re,"$1");
					var stp = 'this.GetXMLDataField("'+curfld+'", '+curRow+')';
					f = f.replace(reBG[j],stp);
				}

				var newValue = eval(f)*1;
				var val=0;

				if (_getBoolean(cols[i].showSummary))
				{
					var msk = cols[i].mask || '###,##0.00';
					var sumCell = document.getElementById(i + '_Column_Sum' + this.element.uniqueID);

					//	Get the old cell value
					var cellPrevValue = this.getCellValue(curRow, i);
					//	Get the old summary value
					var colPrevSummary = maskedToNumber(sumCell.innerText, this.decimalSeparator);

					val = formatNumber(colPrevSummary - cellPrevValue + newValue, msk, this.decimalSeparator, this.groupingSeparator);
					if (val=="false") continue;
					//	Set the new summary value
					sumCell.innerHTML = val;
				}

				val = formatNumber(newValue, msk, this.decimalSeparator, this.groupingSeparator);

				//	Set this flag so that setCell will not attempt to call calcFormulas again and create a loop ...
				cell.calculate = false;
				cell.setValue(val);
				cell.calculate = false;
			}
		}
	}
}


/// <function name="calcSummary" access="private">
/// <summary>Calculates the summary values for any FORMULA and NUMBER columns.</summary>
/// </function>
function _gridlist.prototype.calcSummary()
{
	var uniqueID = this.element.uniqueID;
	var cols = this.columns;
	var clen = cols.length;

	var iRows = this.rowCount();

	var oRows = document.getElementById("rows"+uniqueID);
	var oFreezeRows = document.getElementById("freezerows"+uniqueID);

	//	This is for summary rows on formula columns that cannot be calculated in the xsl
	for (var m=0; m<clen; m++)
	{
		if (cols[m].type == "FORMULA" || cols[m].type == "NUMBER")
		{
			//	bSummary tells if we are showing the summary for THIS column or not
			var bSummary = _getBoolean(cols[m].showSummary);
			var curfld = cols[m].xdatafld;
			var sum = 0;
			var oCell = null;

			for (var i=0; i<iRows; i++)
			{
				var xVal = this.getCellValue(i,m);

				//	First we need to do a data update for the formula columns so that the values will be in the xml
				if (cols[m].type == "FORMULA")
				{
					var xslfld = this.fieldmap[curfld]+"";
					if (xVal != null && !gEsc) 
					{
						var xk = this.getKey(i);
						xNode = this.oXML.documentElement.selectSingleNode("*[@xk = '"+xk+"']");
						if (xNode != null) {
							xVal = maskedToNumber(xVal, this.decimalSeparator)+"";
							xNode.setAttribute(xslfld.substr(1),xVal);
						}
					}
				}

				//	Then we sum the values if we are in a summary column
				if (bSummary)
					sum += xVal*1;
			}

			//	Also need to set the summary cell for this column as the sum value ...
			if (bSummary)
			{
				var msk = cols[m].mask || '###,##0.00';
				var val = formatNumber(sum, msk, this.decimalSeparator, this.groupingSeparator);

				if (val=="false") return;

				//	Get a handle to the summary cell for the current column
				var sumCell = document.getElementById(m + '_Column_Sum' + uniqueID);
				sumCell.innerHTML = val;
			}
		}
	}
}
*/

/**
 * Handles clicks on the header by the user.
 * @param {Number} nColumn The header number clicked on.
 * @private
 */
nitobi.grid.Grid.prototype.headerClicked= function(nColumn)
{
	var column = this.getColumnObject(nColumn);
	var headerClickEventArgs = new nitobi.grid.OnHeaderClickEventArgs(this, column);

	// TODO: here is not actually a headerclick even on the Grid itself ...
	if (!this.fire("HeaderClick", headerClickEventArgs) || !nitobi.event.evaluate(column.getOnHeaderClickEvent(), headerClickEventArgs)) return;

	this.sort(nColumn);
}

/**
 * Adds a filter to apply to the Grid data. A filter consits of a field, comparator, and value that can be used
 * to reduce the set of data rendered in the Grid. By default there are no filters applied.
 * @private
 */
nitobi.grid.Grid.prototype.addFilter= function() 
{
	this.dataTable.addFilter(arguments);
}
/**
 * Clears exisitng filters on the grid data.
 * @private
 */
nitobi.grid.Grid.prototype.clearFilter=function() 
{
	this.dataTable.clearFilter();
}

/**
 * Sets the sort style on the sorted column or clears the currently sorted column style.
 * @private
 */
nitobi.grid.Grid.prototype.setSortStyle = function(sortCol, sortDir, unset)
{
	var headerColumn = this.getColumnObject(sortCol);
	if (unset)
	{
		this.sortColumn = null;
		this.sortColumnCell = null;
		this.Scroller.setSort(sortCol,"");
		this.setColumnSortOrder(sortCol,"");
	}
	else
	{
		//	Set the sort direction on the header and assign the current sorted column properties of the Grid
		headerColumn.setSortDirection(sortDir);
		this.setColumnSortOrder(sortCol,sortDir);
		this.sortColumn = headerColumn;
		this.sortColumnCell = headerColumn.getHeaderElement();
		this.Scroller.setSort(sortCol,sortDir);
	}
};

/**
 * Re-sorts the grid data by the specified column.
 * By default the data is sorted in ascending order first. When sort is 
 * called on a column a second time, the data is sorted in descending 
 * order. Column sorting is alphabetical unless the data type for the 
 * column is NUMBER or DATE.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="">
 * &lt;a href="javascript:nitobi.getComponent('grid1').sort(0, 'Asc')"&gt;Sort First Column&lt;/a&gt;
 * </code></pre>
 * </div>
 * @param {Number} sortCol The index of the column to sort on, starting at 0.
 * @param {String} sortDir The direction to sort the column by. Values are "Asc" and "Desc".
 */
nitobi.grid.Grid.prototype.sort=function(sortCol,sortDir) 
{
	ntbAssert(typeof(sortCol)!="undefined","No column to sort.");

	var headerColumn = this.getColumnObject(sortCol);
	if (headerColumn == null || !headerColumn.isSortEnabled() || (!this.isSortEnabled())) return;

	var beforeSortEventArgs = new nitobi.grid.OnBeforeSortEventArgs(this, headerColumn);
	if (!this.fire("BeforeSort", beforeSortEventArgs) || !nitobi.event.evaluate(headerColumn.getOnBeforeSortEvent(), beforeSortEventArgs)) return;

	if (sortDir == null || typeof(sortDir) == "undefined")
		sortDir = (headerColumn.getSortDirection()=="Asc")?"Desc":"Asc";

	this.setSortStyle(sortCol,sortDir);

	var colName = headerColumn.getColumnName();
	var dataType = headerColumn.getDataType();

	var sortLocal = this.getSortMode() == 'local' || (this.getDataMode() == 'local' && this.getSortMode() != 'remote');
	this.datatable.sort(colName,sortDir,dataType,sortLocal);

	if(!sortLocal) {
		this.datatable.flush();
	}

	this.clearSurfaces();

	// Scrollvertical actually causes a render to take place ...
	this.scrollVertical(0);

	// TODO: Obviously belongs in the subclass.
	if (!sortLocal)
	{
		this.loadDataPage(0);
	}

	// TODO: Reselect Row or at least just select SOME row!

	this.subscribeOnce("HtmlReady", this.handleAfterSort, this, [headerColumn]);
}

/**
 * Event handler that is fired after the data in the Grid is sorted. Fires the <code>AfterSort</code> event.
 * @param {nitobi.grid.Column} headerColumn The column that was sorted.
 * @private
 */
nitobi.grid.Grid.prototype.handleAfterSort = function(headerColumn)
{
	var afterSortEventArgs = new nitobi.grid.OnAfterSortEventArgs(this, headerColumn);
	this.fire("AfterSort", afterSortEventArgs);
	nitobi.event.evaluate(headerColumn.getOnAfterSortEvent(), afterSortEventArgs);
}
/**
 * Handles double click events on cells. Fires the <code>CellDblClick</code> event
 * @param {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleDblClick = function(evt)
{
	// TODO: pass the cell that was clicked on ... 
	var cell = this.activeCellObject;
	var col = this.activeColumnObject;
	var dblClickEventArgs = new nitobi.grid.OnCellDblClickEventArgs(this, cell);
	return this.fire("CellDblClick", dblClickEventArgs) && nitobi.event.evaluate(col.getOnCellDblClickEvent(), dblClickEventArgs);
}
/**
 * Clears the data from the connected DataTable if the DataMode is not local.
 * This is used in server side data sources (LiveScrolling and Standard paging)
 * to cause a re-GET of the data from the server. 
 * @private
 */
nitobi.grid.Grid.prototype.clearData = function()
{
	if(this.getDataMode()!="local") 
	{
		this.datatable.flush();
	}
}
/**
 * Clears the sort CSS styling of the currently sorted column in the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.clearColumnHeaderSortOrder= function()
{
	if (this.sortColumn) {
		var headerColumn = this.sortColumn;//this.getColumnObject(this.sortColumn);
		var headerCell = headerColumn.getHeaderElement();
		var css = headerCell.className;
		css = css.replace(/ascending/gi,"").replace(/descending/gi,"");
		headerCell.className = css;
		this.sortColumn=null;
	}
}

/**
 * Sets the CSS styling of the column at colIndex in the direction specified by sortDir.
 * @param {Number} colIndex
 * @param {String} sortDir
 * @private
 */
nitobi.grid.Grid.prototype.setColumnSortOrder= function(colIndex,sortDir)
{
	this.clearColumnHeaderSortOrder();

	//	TODO: This does not need to be called in the case of sorting on the server
	//	since the entire grid is refiltered and the sort column stuff gets rendered in the XSLT
	var headerColumn = this.getColumnObject(colIndex);
	var headerCell = headerColumn.getHeaderElement();
	var C = nitobi.html.Css;

	var css = headerCell.className;
	if (sortDir == "")
	{
		// If sortDir is nothing then just clear out the class
		//C.removeClass(headerCell, ["ntb-ascending", "ntb-descending"], true);
		headerCell.className = css.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,"") + " ntb-column-indicator-border";
		sortDir="Desc";
	}
	else
	{
		//var clazz = (sortDir=="Desc" ? "ntb-descending" : "ntb-ascending");
		//C.addClass(headerCell, clazz, true);
		headerCell.className = css.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(m)
		{
			var repl = (sortDir=="Desc" ? "descending" : "ascending");
			return (m.indexOf("hover") > 0 ? m.replace("hover", repl+"hover") : m + repl);
		});
	}

	headerColumn.setSortDirection(sortDir);

	this.sortColumn = headerColumn;
	this.sortColumnCell = headerCell;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.initializeState= function() {
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.mapToHtml= function(oNode)
{
	// Put all DOM node reference mapping here (if possible)
	if (oNode==null) {
		oNode = this.UiContainer;
	}
	this.Scroller.mapToHtml(oNode);

	this.element = document.getElementById("grid"+this.uid);
	this.element.jsObject = this;
}

/**
 * Generates the component CSS based on the current state of the component. 
 * This can be important to do such that changes to layout properties 
 * (such as positioning and sizing) take effect.
 * <p>
 * <b>Example:</b>  Dynamically resize the Grid
 * </p>
 * <div class="code">
 * <pre><code class="">
 * &#102;unction resizeGrid(width, height)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.setWidth(width);
 * 	grid.setHeight(height);
 * 	grid.generateCss();
 * }
 * </code></pre>
 * </div>
 * @see #setWidth
 * @see #setHeight
 * @private
 */
nitobi.grid.Grid.prototype.generateCss= function() 
{
	this.generateFrameCss();
//	this.generateColumnCss();
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.generateColumnCss= function() 
{
	this.generateCss(); // Remove this once the real generateColumnCss code has been written
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.generateFrameCss= function()
{
	// Simple caching of the Model XML so that we don't gen CSS too often
	var oldModel = nitobi.xml.serialize(this.model);
	if (this.oldModel == oldModel)
		return;
	this.oldModel = nitobi.xml.serialize(this.model)

	if (nitobi.browser.IE && document.compatMode == "CSS1Compat")
		this.frameCssXslProc.addParameter("IE", "true", "");

	// Extended the HTMLStyleElement object to have the cssText property
	var newCss = nitobi.xml.transformToString(this.model, this.frameCssXslProc);

	if (!nitobi.browser.SAFARI && !nitobi.browser.CHROME && this.stylesheet == null)
		this.stylesheet = nitobi.html.Css.createStyleSheet();

	var ss = this.getScrollSurface(); // Viewport. (id= gridviewport*)
	var scrollTop = 0;
	var scrollLeft = 0;
	if (ss != null)
	{
		scrollTop = ss.scrollTop;
		scrollLeft = ss.scrollLeft;
	}

	if (this.oldFrameCss != newCss)
	{
		this.oldFrameCss = newCss;

		if (nitobi.browser.SAFARI || nitobi.browser.CHROME) 
		{
			this.generateFrameCssSafari();
		}
		else
		{
			// TODO: Figure out why it crashes here with multiple grids in IE 6
			try {
				this.stylesheet.cssText = newCss;
			} catch (e) {}

			if (ss != null)
			{
				if (nitobi.browser.MOZ)
				{
					// TODO: figure out what the problem is here...
					// When in Moz, the scrollbar moves to the top in live scrolling leaping ...
					this.scrollVerticalRelative(scrollTop);
					this.scrollHorizontalRelative(scrollLeft);
				}
				ss.style.top = '0px';
				ss.style.left = '0px';
			}
		}
	}


}

nitobi.grid.Grid.prototype.generateFrameCssSafari = function() 
{
	// TODO: This needs to be one way in all browsers. I think we can do the normal XSLT way in Safari.
	var ss = document.styleSheets[0];

	var u = this.uid;
	var t = this.getTheme();
	var width = this.getWidth();
	var height = this.getHeight();
	var showvscroll = (this.isVScrollbarEnabled()?1:0);
	var showhscroll = (this.isHScrollbarEnabled()?1:0);
	var showtoolbar = (this.isToolbarEnabled()?1:0);
	var frozenColumnsWidth = this.calculateWidth(0, this.getFrozenLeftColumnCount());
	var unfrozenColumnsWidth = this.calculateWidth(this.getFrozenLeftColumnCount(), this.getColumnCount());

	var totalColumnsWidth = frozenColumnsWidth + unfrozenColumnsWidth;
	var scrollerHeight = height-this.getscrollbarHeight()*showhscroll-this.getToolbarHeight()*showtoolbar;
	var scrollerWidth = width-this.getscrollbarWidth()*showvscroll;

	var midHeight = scrollerHeight-this.gettop();

	var addRule = nitobi.html.Css.addRule;
	var p = "ntb-grid-";

	if (this.rules == null)
	{
		this.rules = {};

		// Static private styles - only set them once and no need to store them for later.
		this.rules[".ntb-grid-datablock"] = addRule(ss, ".ntb-grid-datablock", "table-layout:fixed;width:100%;");
		this.rules[".ntb-grid-headerblock"] = addRule(ss, ".ntb-grid-headerblock", "table-layout:fixed;width:100%;");
		addRule(ss, "."+p+"overlay"+u, "position:relative;z-index:1000;top:0px;left:0px;");
		addRule(ss, "."+p+"scroller"+u, "overflow:hidden;text-align:left;");
		addRule(ss, ".ntb-grid", "padding:0px;margin:0px;border:1px solid #cccccc;");
		addRule(ss, ".ntb-scroller", "padding:0px;");
		addRule(ss, ".ntb-scrollcorner", "padding:0px;");
		addRule(ss, ".ntb-input-border", "table-layout:fixed;overflow:hidden;position:absolute;z-index:2000;top:-2000px;left:-2000px;;");
		addRule(ss, ".ntb-column-resize-surface", "filter:alpha(opacity=1);background-color:white;position:absolute;visibility:hidden;top:0;left:0;width:100;height:100;z-index:800;");
		addRule(ss, ".ntb-column-indicator", "overflow:hidden;white-space: nowrap;");
	} 
	this.rules["#grid"+u] = addRule(ss, "#grid"+u, "overflow:hidden;text-align:left;-moz-user-select: none;-khtml-user-select: none;user-select: none;"+(nitobi.browser.IE?"position:relative;":""));
	this.rules["#grid"+u].style.height = height + "px";
	this.rules["#grid"+u].style.width = width + "px";
	addRule(ss, ".hScrollbarRange"+u, "width:"+totalColumnsWidth+"px;");
	addRule(ss, ".vScrollbarRange"+u, "");
	addRule(ss, "."+t+" .ntb-cell", "overflow:hidden;white-space:nowrap;");
	addRule(ss, "."+t+" .ntb-cell-border", "overflow:hidden;white-space:nowrap;"+(nitobi.browser.IE?"height:auto;":"")+";");
	addRule(ss, ".ntb-grid-headershow"+u, "padding:0px;"+(this.isColumnIndicatorsEnabled()?"display:none;":"")+"");
	addRule(ss, ".ntb-grid-vscrollshow"+u, "padding:0px;"+(showvscroll?"":"display:none;")+"");
	addRule(ss, "#ntb-grid-hscrollshow"+u, "padding:0px;"+(showhscroll?"":"display:none;")+"");
	addRule(ss, ".ntb-grid-toolbarshow"+u, ""+(showtoolbar?"":"display:none;")+"");
	addRule(ss, ".ntb-grid-height"+u, "height:"+height+"px;overflow:hidden;");
	addRule(ss, ".ntb-grid-width"+u, "width:"+width+"px;overflow:hidden;");
	addRule(ss, ".ntb-grid-overlay"+u, "position:relative;z-index:1000;top:0px;left:0px;");
	addRule(ss, ".ntb-grid-scroller"+u, "overflow:hidden;text-align:left;");
	addRule(ss, ".ntb-grid-scrollerheight"+u, "height:"+(totalColumnsWidth > width?scrollerHeight:scrollerHeight + this.getscrollbarHeight())+"px;");
	addRule(ss, ".ntb-grid-scrollerwidth"+u, "width:"+scrollerWidth+"px;");
	addRule(ss, ".ntb-grid-topheight"+u, "height:"+this.gettop()+"px;overflow:hidden;"+(this.gettop()==0?"display:none;":"")+"");
	addRule(ss, ".ntb-grid-midheight"+u, "overflow:hidden;height:"+(totalColumnsWidth > width?midHeight:midHeight+this.getscrollbarHeight())+"px;");
	addRule(ss, ".ntb-grid-leftwidth"+u, "width:"+this.getleft()+"px;overflow:hidden;text-align:left;");
	addRule(ss, ".ntb-grid-centerwidth"+u, "width:"+(width-this.getleft()-this.getscrollbarWidth()*showvscroll)+"px;");
	addRule(ss, ".ntb-grid-scrollbarheight"+u, "height:"+this.getscrollbarHeight()+"px;");
	addRule(ss, ".ntb-grid-scrollbarwidth"+u, "width:"+this.getscrollbarWidth()+"px;");
	addRule(ss, ".ntb-grid-toolbarheight"+u, "height:"+this.getToolbarHeight()+"px;");
	addRule(ss, ".ntb-grid-surfacewidth"+u, "width:"+unfrozenColumnsWidth+"px;");
	addRule(ss, ".ntb-grid-surfaceheight"+u, "height:100px;");
	addRule(ss, ".ntb-hscrollbar"+u, (totalColumnsWidth > width?"display:block;":"display:none;"));
	addRule(ss, ".ntb-row"+u, "height:"+this.getRowHeight()+"px;margin:0px;line-height:"+this.getRowHeight()+"px;");
	addRule(ss, ".ntb-header-row"+u, "height:"+this.getHeaderHeight()+"px;");

	var cols = this.getColumnDefinitions();
 	for (var i=1; i<=cols.length; i++)
 	{
 		var col = cols[i-1];
 		var colRule = this.rules[".ntb-column"+u+"_"+(i)];
 		if (colRule == null)
			colRule = this.rules[".ntb-column"+u+"_"+(i)] = addRule(ss, ".ntb-column"+u+"_"+(i));
		colRule.style.width = col.getAttribute("Width")+"px";

 		var colDataRule = this.rules[".ntb-column-data"+u+"_"+(i)];
 		if (colDataRule == null)
			this.rules[".ntb-column-data"+u+"_"+(i)] = addRule(ss, ".ntb-column-data"+u+"_"+(i), "text-align:"+col.getAttribute("Align")+";");
	}
}

/**
 * This is used to clear the data from the component as well as other visual artifacts such as the selection boxes. This is primarily for use by component developers.
 */
nitobi.grid.Grid.prototype.clearSurfaces= function() {
	// Clearing the surface is called from insert, delete, sort, refresh.
	this.selection.clearBoxes();
	this.Scroller.clearSurfaces();

	// Added this to ensure that the Scroller blank surface is the correct size.
	this.updateCellRanges();

	// When the surface is cleared we need to also clear any cached cells 
	this.cachedCells = {};
}

/**
 * Renders the Grid with no columns or data. Before the frame can be rendered the Grid must be attached to an 
 * HtmlElement through either the declaration or using the attachToParentDomElement() method. 
 * The frame must be rendered before any columns or data can be rendered.
 * @private
 */
nitobi.grid.Grid.prototype.renderFrame= function()
{
	var browser = "IE";
	if (nitobi.browser.MOZ)
		browser = "MOZ";
	else if (nitobi.browser.SAFARI||nitobi.browser.CHROME)
		browser = "SAFARI";

	this.frameXslProc.addParameter("browser", browser, "");

	this.UiContainer.innerHTML = nitobi.xml.transformToString(this.model, this.frameXslProc);

	// Attach dom events like keydown, contextmenu, and selectstart
	this.attachDomEvents();

	//	this.showLoading();
	this.frameRendered = true;
	this.fire("AfterFrameRender");
}

/**
 * Clears the cacheMap and requestCache of the middle left and middle center Viewports of the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.renderMiddle= function()
{
	//	The cacheMaps should be flushed here to be ready for rendering
	this.Scroller.view.midleft.flushCache();
	this.Scroller.view.midcenter.flushCache();
}

/**
 * Refreshes the data in the Grid. Any unsaved changes to data in the Grid can be 
 * lost by refreshing the data. The OnBeforeRefreshEvent and 
 * OnAfterRefreshEvent are both fired. Clears all the data that is stored 
 * by the Grid, and gets the current page of data from the server. Any 
 * changes made by the user will be deleted. Call save first if you don't 
 * want these changes to be lost.
 */
nitobi.grid.Grid.prototype.refresh= function()
{
	var eventArgs = null;//new nitobi.grid.EventArgs(this);
	if (!this.fire('BeforeRefresh', eventArgs)) return;

	ntbAssert(this.datatable != null,'The Grid must be conntected to a DataTable to call refresh.','',EBA_THROW);

	// TODO: Not sure why clear is commented out and the other code is here?
	//this.clear();
	this.selectedRows = [];
	this.clearSurfaces();
	if(this.getDataMode()!="local")
		this.datatable.clearData();

	this.syncWithData();

	this.subscribeOnce("HtmlReady", this.handleAfterRefresh, this);
}

/**
 * Event handler that is fired after a refresh of the data in the Grid is 
 * complete. Fires the <code>AfterRefresh</code> event
 * @private
 */
nitobi.grid.Grid.prototype.handleAfterRefresh = function()
{
	var eventArgs = null;//new nitobi.grid.EventArgs(this);
	this.fire("AfterRefresh", eventArgs);
}

/**
 * Clears all data and the surfaces.
 * @private
 */
nitobi.grid.Grid.prototype.clear = function()
{
	this.selectedRows = [];
	this.clearData();
	this.clearSurfaces();
}

/**
 * Event handler for the context menu event.
 * @param {Event} evt The Event object.
 * @param {HTMLElement} obj The HTML element that the context menu event 
 * occured on.
 * @private
 */
nitobi.grid.Grid.prototype.handleContextMenu= function(evt, obj)
{
	var contextMenuFunc = this.getOnContextMenuEvent();
	if (contextMenuFunc == null) {
		return true;
	} else {
		if (this.fire("ContextMenu")) {
			return true;
		} else {
			evt.cancelBubble = true;
			evt.returnValue = false;
			return false;
		}
	}
}

/**
 * Event handler for the key press event.
 * @para {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleKeyPress = function(evt) {
	if (this.activeCell == null)
		return;

	// TODO: should be able to use activeCellObject.
	var col = this.activeColumnObject;

	this.fire("KeyPress", new nitobi.base.EventArgs(this, evt));
	nitobi.event.evaluate(col.getOnKeyPressEvent(), evt);

	nitobi.html.cancelEvent(evt);
	return false;
} 

/**
 * Event handler for the key up event.
 * @para {Event} evt The Event object.
 * @private
 */
nitobi.grid.Grid.prototype.handleKeyUp = function(evt) {
	if (this.activeCell == null)
		return;

	// TODO: should be able to use activeCellObject.
	var col = this.activeColumnObject;

	this.fire("KeyUp", new nitobi.base.EventArgs(this, evt));
	nitobi.event.evaluate(col.getOnKeyUpEvent(), evt);
}

/**
 * Event handler for the key down event.
 * @param {Event} evt The Event object.
 * @param {HTMLElement} obj The HTML element that the context menu event 
 * occured on.
 * @private
 */
nitobi.grid.Grid.prototype.handleKey = function(evt, obj)
{
	if (this.activeCell != null) {
		var col = this.activeColumnObject;
		var evtArgs = new nitobi.base.EventArgs(this, evt);
		if (!this.fire("KeyDown", evtArgs) || !nitobi.event.evaluate(col.getOnKeyDownEvent(), evtArgs)) return;
	}

	var k = evt.keyCode;
	//	TODO: errors can occur if we press keys while selecting ...

	// evt.metaKey tests if the apple key is selected
	k = k + (evt.shiftKey?256:0)+(evt.ctrlKey?512:0)+(evt.metaKey?1024:0);

	switch (k) {
		//just crtl pressed
		case 529:
			break;
		//end
		case 35:
			break;
		//home
		case 36:
			break;

		//ctrl+end
		case 547:
			break;
		//ctrl+home
		case 548:
			break;


		//	page down
		case 34:
			this.page(1);
			break;
		//	page up
		case 33:
			this.page(-1);
			break;

		//insert
		case 45:
			this.insertAfterCurrentRow();
			break;
		//delete
		case 46:
			if (this.getSelectedRows().length > 1) this.deleteSelectedRows();
			else this.deleteCurrentRow();
			break;

		//	select home
		case 292:
			this.selectHome();
			break;

		//	select page down
		case 290:
			this.pageSelect(1);
			break;
		//	select page up
		case 289:
			this.pageSelect(-1);
			break;


		//	select down 
		case 296: 
			this.reselect(0,1);
			break;
		//	select up
		case 294:
			this.reselect(0,-1);
			break;
		//	select left
		case 293:
			this.reselect(-1,0);
			break;
		// select right
		case 295:
			this.reselect(1,0);
			break;
		//select all
		case 577:
			break;

		//copy
		case 579:
		case 557:
			this.copy(evt);
			return true;
		// copy for mac
		case 1091:
			this.copy(evt);
			return true;
		//cut
		case 600:
		case 302:
			break;
		//paste
		case 598:
		case 301:
			this.paste(evt);
			return true;
			break;
		// paste for mac
		case 1110:
			this.paste(evt);
			return true;
		// **** FROM BLOCK NAV **** //
		//end
		case 35:
			break;
		//home
		case 36:
			break;

		//ctrl+end
		case 547:
			break;
		//ctrl+home
		case 548:
			break;

		//down 
		case 13: 
			var et = this.getEnterTab().toLowerCase();
			var horiz = 0;
			var vert = 1;
			if (et == "left")
			{
				horiz = -1;
				vert = 0;
			}
			else if (et == "right")
			{
				horiz = 1;
				vert = 0;
			}
			else if (et == "down")
			{
				horiz = 0;
				vert = 1;
			}
			else if (et == "up")
			{
				horiz = 0;
				vert = -1;
			}
			this.move(horiz, vert);
			break;
		case 40: 
			this.move(0,1);
			break;
		//up
		case 269:
		case 38:
			this.move(0,-1);
			break;
		//left
		case 265:
		case 37: 
			this.move(-1,0);
			break;
		//right
		case 9:
		case 39:
			this.move(1,0);
			break;
		//select all
		case 577:
			break;
		// save
		case 595:
			this.save();
			break;
		// refresh
		case 594:
			this.refresh();
			break;
		// new row
		case 590:
			this.insertAfterCurrentRow();
			break;
		default:
			this.edit(evt);
	}
}

/**
 * Re-sizes the selection box by the relative values in the x and y arguments. This method is generally used for shift+down type of behaviour.
 * @param {Number} x Relative x offset to increase the selection box size by.
 * @param {Number} y Relative y offset to increase the selection box size by.
 * @private
 */
nitobi.grid.Grid.prototype.reselect= function(x,y)
{
	var S = this.selection;
	var row = nitobi.grid.Cell.getRowNumber(S.endCell) + y;
	var column = nitobi.grid.Cell.getColumnNumber(S.endCell) + x
	if (column >= 0 && column < this.columnCount() && row >= 0)
	{
		var newEndCell = this.getCellElement(row, column);
		if (!newEndCell) return;
		S.changeEndCellWithDomNode(newEndCell);
		S.alignBoxes();
		this.ensureCellInView(newEndCell);
	}
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.pageSelect= function(dir)
{
	// TODO: This is only for live scrolling grid ... refactor pls. it is called from handlekey
}

/**
 * Selects from the current active cell up to the first row.
 */
nitobi.grid.Grid.prototype.selectHome= function()
{
	var S = this.selection;
	var row = nitobi.grid.Cell.getRowNumber(S.endCell);
	this.reselect(0, -row);
}

/**
 * Causes the currently activated cell to go into edit mode. OnBeforeCellEditEvent is fired.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code>
 * &#102;unction editCell(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.setPosition(row, col);
 * 	grid.edit();
 * }
 * </code></pre>
 * </div>
 * @param {Event} [evt] The Event object when the edit is caused by a user gesture.
 * @see Event
 * @see #OnBeforeCellEditEvent
 * @see #setPosition
 */
nitobi.grid.Grid.prototype.edit= function(evt)
{
	if (this.activeCell == null)
		return;

	// TODO: should be able to use activeCellObject.
	var cell = this.activeCellObject;
	var col = this.activeColumnObject;

	var beforeEditEventArgs = new nitobi.grid.OnBeforeCellEditEventArgs(this, cell);
	if (!this.fire("BeforeCellEdit", beforeEditEventArgs) || !nitobi.event.evaluate(col.getOnBeforeCellEditEvent(), beforeEditEventArgs)) return;

	var keyVal = null;
	var shift = null;
	var ctrl = null;
	if (evt) {
		keyVal = evt.keyCode || null;
		shift = evt.shiftKey || null;
		ctrl = evt.ctrlKey || null;
	}

	var initialChar = "";
	var keyCodeOffset = null;

	// TODO: Generalize this so people can easily hook into keycodes...  
	//[A - Z] shift or [0-9] no shift
	if ((shift && (keyVal > 64) && (keyVal < 91)) || (!shift && ((keyVal > 47) && (keyVal < 58))))
		keyCodeOffset = 0;

	if (!shift) {
		// [A-Z] no shift
		if ((keyVal > 64) && (keyVal < 91) )
			keyCodeOffset = 32;
		else if (keyVal > 95 && keyVal < 106)
			keyCodeOffset = -48;
		else if ((keyVal == 189) || (keyVal == 109))
			initialChar = "-";
		else if ((keyVal > 186) && (keyVal < 188))
			keyCodeOffset = -126;
	}
	else {// TODO: currently we dont support any special characters ... 
	}

	if (keyCodeOffset != null)
		initialChar = String.fromCharCode(keyVal + keyCodeOffset);

	if( (!ctrl) && 
		/*what does it matter if there is an initialChar? */
		("" != initialChar) || 
		(keyVal == 113)|| // F2
		(keyVal == 0)|| // double click (IE)
		(keyVal == null) || // double click (Moz) - this should really be 0, but something funny's hapening with Moz
		(keyVal == 32)// space
		)
	{
		if (col.isEditable()) {
			this.cellEditor = nitobi.form.ControlFactory.instance.getEditor(this, col);
			if (this.cellEditor == null) return;
			this.cellEditor.setEditCompleteHandler(this.editComplete);
			this.cellEditor.attachToParent(this.getToolsContainer());
			this.cellEditor.bind(this, cell, initialChar);
			this.cellEditor.mimic();
			this.setEditMode(true);
			// This is to prevent double characters from showing up in IE
			nitobi.html.cancelEvent(evt);
			return false;
		}
	} else {
		// do not set active cell for other keys such as tab
		return;	
	}
}

/**
 * Fires after the user has completed editing a cell by pressing enter or ESC. Before the data is updated OnCellValidateEvent is fired which can cause
 * the edit to be discarded if the handler returns false.
 * @private
 * @param {nitobi.components.grid.EditCompleteEventArgs} editCompleteEventArgs
 * @see #OnCellValidateEvent
 */
nitobi.grid.Grid.prototype.editComplete= function(editCompleteEventArgs) {
	//	update the value in the grid
	//	update the value in the datasource 
	var cell=editCompleteEventArgs.cell;
	var column = cell.getColumnObject();
	var newValue = editCompleteEventArgs.databaseValue;
	var newDisplay = editCompleteEventArgs.displayValue;

	var validateEventArgs = new nitobi.grid.OnCellValidateEventArgs(this, cell, newValue, cell.getValue());

	// CellValidate can be on a column and a grid level ...
	if (!this.fire("CellValidate", validateEventArgs) || !nitobi.event.evaluate(column.getOnCellValidateEvent(), validateEventArgs))
	//!cell.getColumnObject().fire("CellValidate", validateEventArgs))
		return false;

	cell.setValue(newValue, newDisplay);

//	cell.DomNode.style.backgroundColor='#FFFF00';
//	this.subscribe('AfterSave', function() {nitobi.effects.blueFade(cell.DomNode, 0)});

	//TODO: we need to define some converters such that metadata properties can be
	//changed based on conditions ... such as if val < 0 bgcolor = red
	//similarly if val.substr(0,1) == "=" make it a formula editor for next time or the other way around
	editCompleteEventArgs.editor.hide();
	this.setEditMode(false);

	// TODO: This will not be fired if the validate does not return true - is this correct???
	var afterEditEventArgs = new nitobi.grid.OnAfterCellEditEventArgs(this, cell);
	this.fire("AfterCellEdit", afterEditEventArgs);
	nitobi.event.evaluate(column.getOnAfterCellEditEvent(), afterEditEventArgs);

	// TODO: Remove this and fix editing tab key press stuff
	try {
		this.focus();
	} 
	catch (e) {
	}
}
/**
 * This is a macro function for anywhere that autosave is used. Insert, delete and edit all should use this.
 * @private
 */
nitobi.grid.Grid.prototype.autoSave = function()
{
	if (this.isAutoSaveEnabled())
	{
		return this.save();
	}
	return false;
}

/**
 * Activates the cell at the supplied row / column coordinates.
 * @example
 * &#102;unction editCell(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.selectCellByCoords(row, col);
 * 	grid.edit();
 * }
 * @param {Number} row The row number of the cell to activate.
 * @param {Number} column The column number of the cell to activate.
 */
nitobi.grid.Grid.prototype.selectCellByCoords= function(row,column) {
	this.setPosition(row,column);
}

/**
 * Activates the cell at the row / column coordinates. This method is used 
 * by {@link #selectCellByCoords}.
 * @param {Number} row The row number of the cell to activate.
 * @param {Number} column The column number of the cell to activate.
 */
nitobi.grid.Grid.prototype.setPosition= function(row,column)
{
	if (row >= 0 && column >= 0)
	{
		var cellElement = this.getCellElement(row, column);
		this.setActiveCell(cellElement);
	}
}

/**
 * Sends a save request to the server with any data from the Grid that 
 * has been changed.  If there are no changes to the local data there 
 * will be no data sent to the server.  The <code>OnBeforeSaveEvent</code> 
 * is fired prior to the data being sent to the server and the 
 * <code>OnAfterSaveEvent</code> is fired after the save has completed.
 * <p>
 * Calling this method is the same as clicking the save button in the
 * Grid's toolbar.
 * </p>
 * @example
 * &#102;unction customSave(param1, value1)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var datatable = grid.getDataSource();
 * 	datatable.setSaveHandlerParameter(param1, value1);
 * 	grid.save();
 * }
 * @see nitobi.data.DataTable#setSaveHandlerParameter
 * @see #getDataSource
 */
nitobi.grid.Grid.prototype.save = function()
{
	// Debated on whether to put his in the table.save. Decided that save 
	// really must mean SAVE, and that this save will only save if required. JG
	if (this.datatable.log.selectNodes("//"+nitobi.xml.nsPrefix+"data/*").length == 0)
		return;

	// the updategram is retained but save operation is postponed.
	// This will means the client and server are now split brain

	// TODO: It is best if a get from the server is done to ensure the
	// client grid is up to date
	if(!this.fire("BeforeSave"))
		return;

// TODO: reimplement showloading.
//	this.showLoading();

	this.datatable.save(nitobi.lang.close(this, this.saveCompleteHandler), this.getOnBeforeSaveEvent());
}

/**
 * Called when the save request to the server is completed.
 * The <code>OnAfterSaveEvent</code> is fired here.
 * @param {nitobi.data.OnSaveCompleteEventArgs} eventArgs
 * @private
 */
nitobi.grid.Grid.prototype.saveCompleteHandler= function(eventArgs)
{
	if (this.getDataSource().getHandlerError())
	{
		this.fire("HandlerError", eventArgs);
	}
	this.fire("AfterSave", eventArgs);
}

/**
 * Sets the focus of the web page to the component. OnFocusEvent is fired.
 */
nitobi.grid.Grid.prototype.focus= function()
{
	//	This refocuses the grid after an edit takes place
	try {
		//nitobi.html.getFirstChild(this.UiContainer).focus();
		// TODO: need to handle focus and bluring better so that grid.onfocus does not get fired so often
		this.keyNav.focus();
		this.fire('Focus', new nitobi.base.EventArgs(this));
		// Not sure why but this borks Safari
		if (!nitobi.browser.SAFARI&&!nitobi.browser.CHROME)
		{
			nitobi.html.cancelEvent(nitobi.html.Event);
			return false;
		}
	} catch (e)
	{
		// Only wrapping this in a try-catch because of the firefox bug for focus()
		// https://bugzilla.mozilla.org/show_bug.cgi?id=236791
		// (Wrapping it seems to do nothing)
	}
}

/**
 * Blurs the Grid removing any selection or row highlights.
 */
nitobi.grid.Grid.prototype.blur=function()
{
	//	This clears the grid selection and row highlights

	// TODO: call something like blurActiveRow as well so that the row blur events are called 
	// and that should also clear the active rows

	// Clear the row highlights
	this.clearActiveRows();
	// Clear the selection
	this.selection.clear();
	// Blur the active cell
	this.blurActiveCell(null);
	// Set the activeCell to null
	this.activateCell(null);

	this.fire('Blur', new nitobi.base.EventArgs(this));
}

/**
 * @deprecated
 * @private
 */
nitobi.grid.Grid.prototype.getRendererForColumn= function(col) {
	var columnCount = this.getColumnCount();
	if (col >= columnCount)
		col = columnCount - 1;
	var frozeneft = this.getFrozenLeftColumnCount();
	if (col < frozenLeft)
		return this.MidLeftRenderer;
	else
		return this.MidCenterRenderer;
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.getColumnOuterTemplate= function(col) {
	return this.getRendererForColumn(col).xmlTemplate.selectSingleNode("//*[@match='ntb:e']/div/div["+col+"]");
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.getColumnInnerTemplate= function(col) {
	return this.getColumnOuterXslTemplate(col).selectSingleNode("*[2]");
}

/**
 * Pre-generates the XSL templates for rendering data in the Grid. This is required when changes to the data structure in the 
 * DataTable are made and is called from the bind() method if required.
 * @private
 */
nitobi.grid.Grid.prototype.makeXSL= function() {

	//	makeXSL impacts the number of columns that are generated for the rowXsl ...

	var fL = this.getFrozenLeftColumnCount();
	var cs = this.getColumnCount();
	var rh = this.isRowHighlightEnabled();

	var dataTableId = '_default';
	if (this.datatable!=null)
	{
		dataTableId = this.datatable.id;
	}

	// TODO: tighten this up.

	// Top Left Corner
	var startColumn = 0;
	var columns = fL;

	// Take anything that is in the column definitions and encode the & character and double encode any
	// not sure what those # signs are for but probably something in nitobi.xml.parseHtml
//	var sXml = nitobi.xml.serialize(this.model.selectSingleNode('state/nitobi.grid.Columns')).replace(/\#\&lt\;\#/g,"#<#").replace(/\#\&gt\;\#/g,"#>#").replace(/\#\&eq\;\#/g,"#=#").replace(/\#\&quot\;\#/g,"#\"#").replace(/\&/g,"&amp;").replace(/\#<\#/g,"&lt;").replace(/\#>\#/g,"&gt;").replace(/\#=\#/g,"&eq;").replace(/\#\"\#/g,"&quot;");

	// Need to make sure that we don't accidentally have double escaped XSLT statemtents ...
//	sXml = sXml.replace(/(\&amp;lt;xsl\:)(.*?)(\/&amp;gt;)/g, function() {return "&lt;xsl:"+arguments[2].replace(/\&amp;/g, "&")+"/&gt;";});

//	if (this.oldColDefs != sXml)
//	{
//		this.oldColDefs = sXml;

		var colDefs = this.model.selectSingleNode('state/nitobi.grid.Columns');
		this.TopLeftRenderer.generateXslTemplate(colDefs, null, startColumn, columns, this.isColumnIndicatorsEnabled(), this.isRowIndicatorsEnabled(),rh, this.isToolTipsEnabled());
		this.TopLeftRenderer.dataTableId = dataTableId;

		// Top Center
		startColumn = fL;
		columns = cs-fL;
		this.TopCenterRenderer.generateXslTemplate(colDefs, null, startColumn,columns, this.isColumnIndicatorsEnabled(),this.isRowIndicatorsEnabled(),rh,this.isToolTipsEnabled());
		this.TopCenterRenderer.dataTableId = dataTableId;

		// Left
		this.MidLeftRenderer.generateXslTemplate(colDefs, null, 0, fL, 0, this.isRowIndicatorsEnabled(),rh,this.isToolTipsEnabled(), "left");
		this.MidLeftRenderer.dataTableId = dataTableId;

		// Center
		this.MidCenterRenderer.generateXslTemplate(colDefs, null, fL, cs-fL,0,0,rh,this.isToolTipsEnabled());
		this.MidCenterRenderer.dataTableId = dataTableId;
//	}

	this.fire("AfterMakeXsl");
}

/**
 * Renders the data in the Grid. This differs from <code>refresh()</code> 
 * in that refresh will re-retrieve the data from the server as well as 
 * re-render the data.
 */
nitobi.grid.Grid.prototype.render = function()
{
	// This will clear the surfaces and remove any selections ... this might have to be done
	this.generateCss();
	this.updateCellRanges();
}

/**
 * @ignore
 */
nitobi.grid.Grid.prototype.refilter = nitobi.grid.Grid.prototype.render; 

/**
 * Returns an XmlElementList containing the definitions of the columns in the Grid. The column definitions are the XML serialization of the nitobi.components.grid.Column objects.
 * @private
 * @type XMLNodeList
 */
nitobi.grid.Grid.prototype.getColumnDefinitions= function()
{
	return this.model.selectNodes("state/nitobi.grid.Columns/*");
}

/**
 * Returns an XmlElementList containing the definitions of the columns in the Grid that are visible. The column definitions are the XML serialization of the nitobi.components.grid.Column objects.
 * @private
 * @type XMLNodeList
 */
nitobi.grid.Grid.prototype.getVisibleColumnDefinitions= function()
{
	return this.model.selectNodes("state/nitobi.grid.Columns/*[@Visible='1']");
}

/**
 * Initializes the Model from the values in the API XML.
 * @private
 */
nitobi.grid.Grid.prototype.initializeModelFromDeclaration = function()
{
	// Iterate over the attributes on the declaration and call each attributes setter
	var attributes = this.Declaration.grid.documentElement.attributes;
	var len = attributes.length;
	for (var i=0; i<len; i++) {
		var attribute = attributes[i];
		var property = this.properties[attribute.nodeName];
		if (property != null)
			this["set"+property.n](attribute.nodeValue);
	}

	// TODO: these are being re-set cause they are overwritten from the delcaration to model copy ...
	this.model.documentElement.setAttribute("ID",this.uid);
	this.model.documentElement.setAttribute("uniqueID",this.uid);
}

/**
 * Sets the default values for a column declaration in the model.
 * @private
 */
nitobi.grid.Grid.prototype.setModelValues = function(xModelNode, xDeclarationNode)
{
	// For the declaration node iterate over the attributes and try to find corresponding 
	// attributes in the xColumnProps hash for the column, the specific column type, and the editor.
	var columnDataType = xModelNode.getAttribute("DataType");
	var columnEditorType = xModelNode.getAttribute("type").toLowerCase();
	
	// First do the column and specific column type
	var columnProperties = xDeclarationNode.attributes;
	for (var j=0; j < columnProperties.length; j++)
	{
		var property = columnProperties[j];
		var propertyName = property.nodeName.toLowerCase();
		// Match the declaration attribute name on the JS hash of lowercase attribute names to property metadata.
		var propertyMeta = this.xColumnProperties[columnDataType+"column"][propertyName] || this.xColumnProperties["column"][propertyName];
		var value = property.nodeValue;
		if (propertyMeta.t == "b")
			value = nitobi.lang.boolToStr(nitobi.lang.toBool(value));
		xModelNode.setAttribute(propertyMeta.n, value);
	}

	// Now do the editor
	var editorNode = xDeclarationNode.selectSingleNode("./ntb:"+columnEditorType+"editor");
	if (editorNode == null)
		return;
	var editorProperties = editorNode.attributes;
	for (var j=0; j < editorProperties.length; j++)
	{
		var property = editorProperties[j];
		var propertyName = property.nodeName.toLowerCase();
		// Match the declaration attribute name on the JS hash of lowercase attribute names to property metadata.
		var propertyMeta = this.xColumnProperties[columnEditorType+"editor"][propertyName];
		var value = property.nodeValue;
		if (propertyMeta.t == "b")
			value = nitobi.lang.boolToStr(nitobi.lang.toBool(value));
		xModelNode.setAttribute(propertyMeta.n, value);
	}

}

/**
 * Creates a new Key for a record in the Grid. This is the default Key generation.
 * @private
 * @type String
 */
nitobi.grid.Grid.prototype.getNewRecordKey= function()
{
	var today;
	var key;
	var xNode;
	// Keep trying to select a key until one is unique.
	do
	{
		today = new Date();
		key = (today.getTime() + "." + Math.round(Math.random()*99));
		//TODO: This should be fixed ...
		xNode = this.datatable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@xk = \''+key+'\']');
	} while (xNode != null);
	return key;
}

/**
 * Inserts a blank row into the Grid after the row to which the active cell belongs.
 */
nitobi.grid.Grid.prototype.insertAfterCurrentRow= function()
{
	if (this.activeCell)
	{
		var rowNumber = nitobi.grid.Cell.getRowNumber(this.activeCell);
		this.insertRow(rowNumber+1);
	}
	else
	{
		this.insertRow();
	}
}

/**
 * Adds a new row of data to the grid.
 * <P>Rows can also be inserted by the user by pressing the 
 * Insert key or by clicking on the toolbar icon.
 * </P>
 * <P>When rows are 
 * added to the grid, a new XML row node is added to the XML datasource.
 * In addition, a new node is added to the XML updategram which 
 * will be transmitted back to the server when the data is saved.
 * </P>
 * @param {Number} rowIndex A row will be inserted after the row at this index
 */
nitobi.grid.Grid.prototype.insertRow= function(rowIndex) 
{
	var rows = parseInt(this.getDisplayedRowCount());
	var xi = 0;
	if (rowIndex != null)
	{
		xi = parseInt((rowIndex==null ? rows : parseInt(rowIndex)));
		xi--;
	}

	var eventArgs = new nitobi.grid.OnBeforeRowInsertEventArgs(this,this.getRowObject(xi));
	if(!this.isRowInsertEnabled() || !this.fire("BeforeRowInsert", eventArgs))
	{
		return;
	}
	// TODO: wrap this call to the model.
	// Add initial values to the default row before sending it to the datasource.
	var defaultRow = this.datatable.getTemplateNode();

	for (var i = 0; i < this.columnCount(); i++)
	{
		var columnObject = this.getColumnObject(i);
		var initialValue = columnObject.getInitial();
		if (initialValue == null || initialValue == "")
		{
			var dataType = columnObject.getDataType();
			// TODO: This is a temp fix for moz. DataType isn;t set correctly for some reason.
			if (dataType == null || dataType == "")
			{
				dataType = "text";
			}
			switch (dataType)
			{
				case "text":
				{
					initialValue="";
					break;
				}
				case "number":
				{
					initialValue=0;
					break;
				}
				case "date":
				{
					initialValue="1900-01-01";
					break;
				}
			}
		}
		var att = columnObject.getxdatafld().substr(1);
		if (att != null && att != "")
		{
			defaultRow.setAttribute(att, initialValue);
		}
	}
	this.clearSurfaces();

	this.datatable.createRecord(defaultRow,xi);

	// TODO: should this be setRowCount instead?
//	rows++;
//	this.setDisplayedRowCount(rows);

	//QUESTION: When a row is added what happens if the grid is sorted??? the item should be inserted at the cursor and that is it.
	//TODO: refilter should not be called ... we need to do this ajax styles

	this.subscribeOnce("HtmlReady", this.handleAfterRowInsert, this, [xi]);
}

/**
 * Event handler that is fired when after a row is inserted into the Grid and (if autosave is enabled) the data is saved to the server. 
 * Fires the <code>AfterRowInsert</code> event
 * @param {Number} xi The index of the inserted row.
 * @private
 */
nitobi.grid.Grid.prototype.handleAfterRowInsert = function(xi)
{
	this.setActiveCell(this.getCellElement(xi, 0));
	this.fire("AfterRowInsert", new nitobi.grid.OnAfterRowInsertEventArgs(this, this.getRowObject(xi)));
}
/**
 * Deletes the row to which the currently active cell belongs.
 * @see #deleteRow
 */
nitobi.grid.Grid.prototype.deleteCurrentRow= function()
{
	if (this.activeCell)
	{
		this.deleteRow(nitobi.grid.Cell.getRowNumber(this.activeCell));
	}
	else
	{
		alert("First select a record to delete.");
	}
}
/**
 * Deletes the currently selected rows
 * @see nitobi.grid.Grid#deleteRow
 */
nitobi.grid.Grid.prototype.deleteSelectedRows= function()
{
	var eventArgs = new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getSelectedRows());
	if (!this.isRowDeleteEnabled() || !this.fire("BeforeRowDelete",eventArgs)) 
	{
		return;
	}

    var selectedRows = this.getSelectedRows();
	
	var xiList = [];
	for (row in selectedRows) {
		xiList.push(parseInt(selectedRows[row].getAttribute('xi')));
	}
	xiList.sort(function(a,b){return a-b});
	
	this.clearSurfaces();

	var rows = this.getDisplayedRowCount();

	// deleteRecord can throw an exception, which stops grid being repopulated (after this.clearSurfaces())
	// now exception is caught, and grid display is restored
	try { 
		this.datatable.deleteRecordsArray(xiList);

		// TODO: should this be set here since it will be updated by the RowCountChanged event from the DataTable.
		// Should we be calling setRowCount???
		// rows--;
		if (rows <= 0)
			this.activeCell = null;

		this.subscribeOnce("HtmlReady", this.handleAfterRowDelete, this, xiList);
	} catch (err) {
		this.dataBind();
	}

}
/**
 * Deletes the row containing the cell referenced by the activeCell property.
 * <P>When rows are deleted from the grid, the corresponding XML record 
 * node is also deleted from the bound DataTable.</P><P>An XML updategram is 
 * created by the DataTable when a row is deleted. This updategram is sent to the 
 * server when the save() method is called to instruct the server to delete the 
 * corresponding record from the database.</P><P>Rows may also be deleted by pressing 
 * the Delete key or by clicking on the toolbar Delete icon.</P>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.deleteRow(3);	// deletes the 4th row
 * @param {Number} index Index of the row to delete, indexed from 0.
 * @see #deleteAfterCurrentRow
 * @see #OnBeforeDeleteEvent
 * @see #OnAfterDeleteEvent
 */
nitobi.grid.Grid.prototype.deleteRow= function(index)
{
	// do something for when onbeforedelete is not defined
	//HACK fix this somehow
	ntbAssert(index>=0,"Must specify a row to delete.");

	var eventArgs = new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getRowObject(index));
	
	if (!this.isRowDeleteEnabled() || !this.fire("BeforeRowDelete",eventArgs)) 
	{
		return;
	}

	this.clearSurfaces();

	var rows = this.getDisplayedRowCount();
	
	// deleteRecord can throw an exception, which stops grid being repopulated (after this.clearSurfaces())
	// now exception is caught, and grid display is restored
	try { 
		this.datatable.deleteRecord(index);
		
		// TODO: should this be set here since it will be updated by the RowCountChanged event from the DataTable.
		// Should we be calling setRowCount???
		rows--;
		if (rows <= 0)
			this.activeCell = null;
	//	this.setDisplayedRowCount(rows);

		this.subscribeOnce("HtmlReady", this.handleAfterRowDelete, this, [index]);
	} catch (err) {
		this.dataBind();
	}
}

/**
 * Event handler that is fired when after a row is deleted from the Grid and (if autosave is enabled) the data is deleted on the server.
 * Fires the <code>AfterRowDelete</code> event
 * @param {Number} xi The index of the deleted row.
 * @private
 */
nitobi.grid.Grid.prototype.handleAfterRowDelete = function(xi)
{
	this.setActiveCell(this.getCellElement(xi, 0));
	this.fire("AfterRowDelete", new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getRowObject(xi)));
}

/**
 * @private
 */
nitobi.grid.Grid.prototype.page= function(dir)
{
}

/**
 * Moves the active cell by the relative amounts specified by the 
 * horizontal and vertical arguments.
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.setPosition(0,0);
 * grid.move(1,3);  // Now the cell at row 1 and column 3 is selected
 * @param {Number} h The number of cells to move the active cell by in the horizontal direction.
 * @param {Number} v The number of cells to move the active cell by in the vertical direction.
 */
nitobi.grid.Grid.prototype.move = function(h,v)
{
	if (this.activeCell != null) {
		// Get reference to cellObject
		// Going Right or Down .... (Easy)
		var hs=1;
		var vs=1;

		h=(h*hs);
		v=(v*vs);

		// Get the activeCell object
		// add the h and v to the coords.
		// select the new cell.
		var cell = nitobi.grid.Cell
		var colNumber = cell.getColumnNumber(this.activeCell);
		var rowNumber = cell.getRowNumber(this.activeCell);
		// Select the new activeCell
		this.selectCellByCoords(rowNumber + v, colNumber + h);

		// Check if we have hit the start or end of the row.
		var evtArgs = new nitobi.grid.CellEventArgs(this, this.activeCell);
		if (colNumber + 1 == this.getVisibleColumnDefinitions().length && h == 1) {
			this.fire("HitRowEnd", evtArgs);
		} else if (colNumber == 0 && h == -1) {
			this.fire("HitRowStart", evtArgs);
		}
	}
}

/**
 * @private
 * Called from the selection mouseup event handler. This gets fired when the user clicks on a grid cell and
 * the selection is moved under the mouse before the mouseup event fires - which occurs on the selection.
 */
nitobi.grid.Grid.prototype.handleSelectionMouseUp = function(evt)
{
	// If the mouseup was fired during a grid cell click event then ensure the cell is in view
	if (this.isCellClicked())
		this.ensureCellInView(this.activeCell);
	this.setCellClicked(false);

	// If we are in single click mode
	if (this.isSingleClickEditEnabled())
		this.edit(evt);
	else if (!nitobi.browser.IE) // Safari needs this focus otherwise the selection gets the focus (and even then not really)
		this.focus();
}

/**
 * Loads the next page of data.  Only available if the Grid is in standard
 * paging mode.
 */
nitobi.grid.Grid.prototype.loadNextDataPage= function()
{
	// TODO: refactor this into the proper grid class
	//	TODO: scroll back to the top of the grid if we are in standard paging mode
	this.loadDataPage(this.getCurrentPageIndex()+1);
}

/**
 * Loads the previous page of data.  Only available if the Grid is in standard
 * paging mode.
 */
nitobi.grid.Grid.prototype.loadPreviousDataPage= function()
{
	this.loadDataPage(this.getCurrentPageIndex()-1);
}

/**
 * @deprecated
 * @private
 */
nitobi.grid.Grid.prototype.GetPage= function(functionReplacedByLowercasegetPage)
{
	ebaErrorReport("GetPage is deprecated please use loadDataPage instead","",EBA_DEBUG);
	this.loadDataPage(functionReplacedByLowercasegetPage);
}

/**
 * Loads the specified page of data from the server and displays it. 
 * Since the server request is asynchronous, this call will return 
 * immediately.  Additionally, if the page already exists in the cache, 
 * no server request will occur. To determine when the page has loaded see 
 * setOnAfterPagingEvent. 
 * <p><b>N.B.</b>:  This function is only used in the standard paging mode.</p>
 * @example
 * &#102;unction fivePagesForward()
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.loadDataPage(grid.getCurrentPageIndex() + 5);
 * }
 * @param {Number} pageNumber The index of the data page to load.  (Zero indexed)
 */
nitobi.grid.Grid.prototype.loadDataPage= function(newPageNumber) {}

/**
 * Returns the index of the currently selected row or the row to which the active cell currently belongs.
 * @param {Boolean} rel Specifies whether to compensate for frozen columns.
 * @type Number
 */
nitobi.grid.Grid.prototype.getSelectedRow= function(rel) {
	try {
		var nRow=-1;
		var AC = this.activeCell;
		if (AC != null) {
			nRow = nitobi.grid.Cell.getRowNumber(AC);

			if (rel) {
				nRow -= this.getfreezetop();
			}
		}
		return nRow;
	} catch (err) 
	{
		_ntbAssert(false,err.message);
	}
}


/**
 * Fires the <code>HandlerError</code> event
 * @private
 */
nitobi.grid.Grid.prototype.handleHandlerError = function()
{
	var error = this.getDataSource().getHandlerError();
	if (error)
	{
		this.fire("HandlerError");
	}
}

/**
 * Returns a row object from one of the panes given its Id number.
 * @example
 * &#102;unction getCellViaRow(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var rowObj = grid.getRow(row);
 * 	return rowObj.getCell(col);
 * }
 * @param {Number} rowIdNum The row index.
 * @param {Number} paneNumber
 * @type nitobi.grid.Row
 */
nitobi.grid.Grid.prototype.getRowObject= function(paneNumber, rowIdNum)
{
	var rowIndex = rowIdNum;
	if (rowIdNum == null && paneNumber != null)
	{
		rowIndex = paneNumber;
	}
	return new nitobi.grid.Row(this, rowIndex);
}

/**
 * Returns the column index of the Column to which the active cell belongs.
 * <P>Columns are numbered from left to right starting at 0. If the first n columns are frozen (locked so that they remain visible when 
 * the user scrolls left and right), the rel parameter can be set to true to obtain the absolute column index. Otherwise the getColumn method returns the column 
 * index for column within the set of unfrozen columns.</P>
 * @param {Boolean} rel Specifies whether to compensate for frozen columns.
 * @type Number
 */
nitobi.grid.Grid.prototype.getSelectedColumn= function(rel) {
	try {
		var nCol=-1;
		var AC = this.activeCell;
		if (AC != null) {
			nCol = parseInt(AC.getAttribute('col'));

			if (rel) {
				nCol -= this.getFrozenLeftColumnCount();
			}
		}
		return nCol;
	} catch (err) 
	{
		_ntbAssert(false,err.message);
	}
}

/**
 * Returns the Column name as defined in fieldMap
 * @type {String}
 */
nitobi.grid.Grid.prototype.getSelectedColumnName = function() {
    var field = this.getSelectedColumnObject();
    return field.getColumnName();
}


/**
 * Returns the Column object for the column that contains the currently selected cell.
 * @type nitobi.grid.Column
 */
nitobi.grid.Grid.prototype.getSelectedColumnObject= function() {
	return this.getColumnObject(this.getSelectedColumn());
}

/**
 * Returns the number of columns in the Grid.
 * @type Number
 */
nitobi.grid.Grid.prototype.columnCount= function() 
{
	try {
		var dataItems = this.getColumnDefinitions();
		return dataItems.length;
	} catch (err) 
	{
		_ntbAssert(false,err.message);
	}
}

/**
 * Gets the cell object at the specified coordinates.
 * @example
 * &#102;unction setCellValue(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var cellObj = grid.getCellObject(row, col);
 * 	cellObj.setValue("This Year's Model");
 * }
 * @param {Number} row The index of the Row to which the Cell belongs.
 * @param {Number|String} col The Column to which the Cell belongs. This value can be either the column index or the column name.
 * @type nitobi.grid.Cell
 * @see nitobi.grid.Cell#setValue
 */
nitobi.grid.Grid.prototype.getCellObject= function(row,col) 
{
	// col could be either string or number so we need to keep both the string and number versions in the cache ...
	var origCol = col;
	var cell = this.cachedCells[row+"_"+col];
	if (cell == null)
	{
		if (typeof(col) == "string")
		{
			var node = this.model.selectSingleNode("state/nitobi.grid.Columns/nitobi.grid.Column[@xdatafld_orig='"+col+"']");
			if (node != null)
				col = parseInt(node.getAttribute('xi'));
		}
		if (typeof(col) == "number")
			cell = new nitobi.grid.Cell(this,row,col);
		else
			cell = null;
		this.cachedCells[row+"_"+col] = this.cachedCells[row+"_"+origCol] = cell || "";
	} else if (cell == "") {
		cell = null;
	}
	return cell
}

/**
 * Provides a shortcut to getting the <i>displayed</i> value of a Cell at the 
 * specified coordinates. Generally the cell content can also be obtained 
 * from the XML document bound to the grid, but the values may vary. 
 * For example, if a grid uses a Listbox editor for a particular cell, 
 * the XML will contain the key value where getCellText will return the 
 * actual text value displayed in the cell. One can also access the value 
 * of a Cell through the Cell object itself.
 * <p>
 * <b>Example</b>:  The difference between getCellText and {@link #getCellValue}
 * </p>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * var datatable = grid.getDataSource();
 * // Get the xml node that represents the first row (xi is row index)
 * var node = datatable.getDataXmlDoc().selectSingleNode("//ntb:e[&#64;xi=0]");
 * // Set the value of the first column
 * node.setAttribute("a", "New value");
 * if (grid.getCellText(0,0) != grid.getCellValue(0,0))
 * {
 * 	alert('They are not equal.  getCellValue gets the value from the xml while getCellText gets it from the rendered cell');
 * }
 * @param {Number} row The index of the Row to which the Cell belongs.
 * @param {Number} col The index of the Column to which the Cell belongs.
 * @type String
 * @see #getCellObject
 */
nitobi.grid.Grid.prototype.getCellText = function(row,col)
{
	return this.getCellObject(row, col).getHtml();
}
/**
 * Provides a shortcut to geting the value of a Cell at the specified 
 * coordinates.
 * <p>
 * <b>Example</b>:  The difference between getCellValue and {@link #getCellText}
 * </p>
 * @example
 * var grid = nitobi.getComponent('grid1');
 * var datatable = grid.getDataSource();
 * // Get the xml node that represents the first row (xi is row index)
 * var node = datatable.getDataXmlDoc().selectSingleNode("//ntb:e[&#64;xi=0]");
 * // Set the value of the first column
 * node.setAttribute("a", "New value");
 * if (grid.getCellText(0,0) != grid.getCellValue(0,0))
 * {
 * 	alert('They are not equal.  getCellValue gets the value from the xml while getCellText gets it from the rendered cell');
 * }
 * @param {Number} row The index of the Row to which the Cell belongs.
 * @param {Number} col The index of the Column to which the Cell belongs.
 * @see #getCellObject
 */
nitobi.grid.Grid.prototype.getCellValue = function(row,col)
{
	return this.getCellObject(row, col).getValue();
}

/**
 * <P>Returns the HTMLElement of the cell in the Grid at the specified 
 * coordinates. The cell is represented in HTML as a &lt;DIV&gt; 
 * with xi, col, colAttr, and value attributes containing the cell row 
 * number, the cell column number, the column XML attribute name, and 
 * the raw cell value. The innerHTML property of the cell element will 
 * contain the displayed value for the cell.</P>
 * @example
 * &#102;unction scrollToCell(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var cellElement = grid.getCellElement(row, col);
 * 	grid.ensureCellInView(cellElement);
 * }
 * @param {Number} row The Row coordinate of the cell.
 * @param {Number} column The Column coordinate of the cell.
 * @type HTMLElement
 * @see #ensureCellInView
 */
nitobi.grid.Grid.prototype.getCellElement= function(row, column)
{
	return nitobi.grid.Cell.getCellElement(this, row, column);
}

/**
 * Returns the Row object of the currently selected row or the row to which the active cell currently belongs.
 * @param {Number} xi The index of the Row to retrieve.
 * @type nitobi.grid.Row
 */
nitobi.grid.Grid.prototype.getSelectedRowObject= function(xi) 
{
	var obj = null;
	var r = nitobi.grid.Cell.getRowNumber(this.activeCell);
	obj = new nitobi.grid.Row(this, r);
	return obj;
}

/**
 * Gets the Column object for the column at the index specified. The type of Column object return could be a DateColumn, TextColumn, or NumberColumn
 * depending on the column type.
 * @example
 * &#102;unction sortColumnAsc(index)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var colObj = grid.getColumnObject(index);
 * 	if (colObj.isSortEnabled())
 * 	{
 * 		grid.sort(index, "Asc");
 * 	}
 * }
 * @param {Number} index The zero based index of the Column to return the object of.
 * @type nitobi.grid.Column
 */
nitobi.grid.Grid.prototype.getColumnObject= function(index) 
{
	ntbAssert(index >= 0,"Invalid column accessed.");

	var column = null;
	if (index >= 0 && index < this.getColumnDefinitions().length)
	{
		column = this.columns[index];
		if (column == null)
		{
			var dataType = this.getColumnDefinitions()[index].getAttribute('DataType');
			switch (dataType)
			{
				case "number": 
					column = new nitobi.grid.NumberColumn(this, index);
					break;
				case "date":
					column = new nitobi.grid.DateColumn(this, index);
					break;
				default:
					column = new nitobi.grid.TextColumn(this, index);
					break;
			}
//			column = new nitobi.grid.Column(this,index);
			this.columns[index] = column;
		}
	}
	if (column == null || column.getModel() == null)
	{
		return null;
	}
	else
	{
		return column;
	}
}
/**
 * Gets the Cell object that represents the currently selected cell in the Grid.
 * @example
 * var grid = nitobi.getComponent('grid1');
 * grid.setPosition(0,3);
 * var cellObj1 = grid.getSelectedCellObject();
 * var cellObj2 = grid.getCellObject(0,3);
 * if (cellObj1.getDomNode() === cellObj2.getDomNode())
 * {
 * 	alert('They are the same!');
 * }
 * @type nitobi.grid.Cell
 */
nitobi.grid.Grid.prototype.getSelectedCellObject= function() {
	var obj = this.activeCellObject;
	if (obj == null)
	{
		// Failover to use the activeCell - this can likely be removed
		obj = this.activeCell; //this.Scroller.activeView.activeCell;
		if (obj != null)		
		{
			var Cell = nitobi.grid.Cell;
			var r = Cell.getRowNumber(obj)
			var c = Cell.getColumnNumber(obj)
			obj = this.getCellObject(r,c);
		}
	}	
	return obj;
}

/**
 * @private
 * Automatically adds a new row to the end of the Grid if the autoAdd is true, the current cell isn't empty.
 * This method is similar to the insertRow method.
 */
nitobi.grid.Grid.prototype.autoAddRow= function()
{
	if (this.activeCell.innerText.replace(/\s/g,"") != "" && this.autoAdd ) {
		this.deactivateCell();
		if (this.active == "Y") 
			this.freezeCell();
		eval(this.getOnRowBlurEvent());
		this.insertRow();
		this.go("HOME");

		// TODO: There is no edit cell...
		this.editCell();
	}
}

/**
 * Sets the number of rows displayed in the Grid.
 * @param {Number} newVal The number of rows currently displayed in the Grid.
 * @private
 */
nitobi.grid.Grid.prototype.setDisplayedRowCount= function(newVal) 
{
	ntbAssert(!isNaN(newVal),"displayed row was set to nan");
	if (this.Scroller)
	{
		this.Scroller.view.midcenter.rows = newVal;
		this.Scroller.view.midleft.rows	= newVal;
	}
	this.displayedRowCount = newVal;
}

/**
 * Returns the number of currently rows displayed in the Grid.
 * @type Number
 */
nitobi.grid.Grid.prototype.getDisplayedRowCount = function()
{
	ntbAssert(!isNaN(this.displayedRowCount),"displayed row count return nan");
	return this.displayedRowCount;
}

nitobi.grid.Grid.prototype.getToolsContainer = function() 
{
	this.toolsContainer = this.toolsContainer || document.getElementById("ntb-grid-toolscontainer"+this.uid);
	return this.toolsContainer;
}

nitobi.grid.Grid.prototype.getHeaderContainer = function()
{
	return document.getElementById("ntb-grid-header"+this.uid)
}

nitobi.grid.Grid.prototype.getDataContainer = function()
{
	return document.getElementById("ntb-grid-data"+this.uid)
}

nitobi.grid.Grid.prototype.getScrollerContainer = function()
{
	return document.getElementById("ntb-grid-scroller"+this.uid)
}

nitobi.grid.Grid.prototype.getGridContainer = function()
{
	return nitobi.html.getFirstChild(this.UiContainer);
}

/**
 * Copies the currently selected block of cells in the Grid. Copied data will be located in the native operating system clipboard and
 * formatted as an HTML table. This data can be pasted into many common desktop applications such as Microsoft Excel or into other Grid components.
 * OnBeforeCopyEvent and OnAfterCopyEvent are fired.
 * @example
 * &#102;unction copyBlock(startRow, startColumn, endRow, endColumn)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.getSelection().selectWithCoords(startRow, startColumn, endRow, endColumn);
 * 	grid.copy();
 * }
 * @see #paste
 * @see #OnBeforeCopyEvent
 * @see #OnAfterCopyEvent
 */
nitobi.grid.Grid.prototype.copy = function()
{
	var coords = this.selection.getCoords();
	var data = this.getTableForSelection(coords);

	var copyEventArgs = new nitobi.grid.OnCopyEventArgs(this, data, coords);
	if(!this.isCopyEnabled() || !this.fire("BeforeCopy", copyEventArgs)) return;

	// Removed the conditional for using the windows clipboard in IE so we
	// always just go through the same path.

	// Place the HTML table formatted data into the invisible textarea
	if(!nitobi.browser.IE)
	{
		// create text area

		var copyClipBoard = this.getClipboard();
		// TODO: see if this causes a memory leak.If so then make sure the references are cleaned up
		copyClipBoard.onkeyup		= nitobi.lang.close(this, this.focus);
		copyClipBoard.value 			= data;
		// Create a selection range on the innerText of the invisible textarea
		copyClipBoard.focus();
		copyClipBoard.setSelectionRange(0,copyClipBoard.value.length);
	} else {
		window.clipboardData.setData("Text",data);
	}

	this.fire("AfterCopy", copyEventArgs);
}

/**
 * Returns the data from the Grid as an HTML table.
 * @param {Map} coords The coordinates of the data to retrieve. Eg. {"top":{"y":5},"bottom":{"y":10}} will select all the data from rows 5 to 10.
 * @type String
 */
nitobi.grid.Grid.prototype.getTableForSelection = function(coords)
{
	var columns = this.getColumnMap(coords.top.x,coords.bottom.x);
	var result = nitobi.data.FormatConverter.convertEbaXmlToTsv(this.getDataSource().getDataXmlDoc(),columns,
																	coords.top.y,
																	coords.bottom.y);
	return 	result;
}

/**
 * Returns an array containing the attribute names used by column definitions in the grid.
 * @private
 * @type Array
 */
nitobi.grid.Grid.prototype.getColumnMap = function(firstColumn,lastColumn)
{
	var columns = this.getColumnDefinitions();
	firstColumn = (firstColumn == null)?0:firstColumn;
	lastColumn = (lastColumn == null)?columns.length-1:lastColumn;
	var map = new Array();
	for (var i=firstColumn; i<=lastColumn && (null != columns[i]); i++) {
		map.push(columns[i].getAttribute("xdatafld").substr(1));
	}
	return map;
}

/**
 * Attempts to paste the data that is currently in the native operating 
 * systems "clipboard" into the Grid. The data must be in tab seperated 
 * format to properly be pasted into the Grid. OnBeforePasteEvent and 
 * OnAfterPasteEvent are fired.
 * @example
 * &#102;unction copyBlockTo(startRow, startColumn, endRow, endColumn, destRow)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	grid.getSelection().selectWithCoords(startRow, startColumn, endRow, endColumn);
 * 	grid.copy();
 * 	grid.setPosition(destRow, 0);
 * 	grid.paste();
 * }
 */
nitobi.grid.Grid.prototype.paste = function()
{
	// Preconditions: Paste data is on the clipboard and in TSV or HTML TABLE format
	if(!this.isPasteEnabled()) return;
	// create text area
	var pasteClipBoard = this.getClipboard();
	// Create a selection range on the innerText of the invisible textarea
	pasteClipBoard.onkeyup = nitobi.lang.close(this, this.pasteDataReady, [pasteClipBoard]);
	pasteClipBoard.focus();

	return pasteClipBoard;
}

/**
 * Handles the onkeyup event in the "clipboard" and attempts to merge the pasted data into the DataTable to which the Grid is connected. 
 * If the pasted crosses over rows that are not in the DataTable then the DataTable needs to retrieve that data from the server before it can be
 * merged. The retrieval of the data is asynchronous and once complete the pasteComplete() method is called.
 * @param {Object} pasteClipBoard  The paste clibboard is actually an HTML textarea element.
 * @private
 */
nitobi.grid.Grid.prototype.pasteDataReady = function(pasteClipBoard)
{
	pasteClipBoard.onkeyup = null;

	var selection = this.selection;

	// get RowIndex for the TargetTopLeftCell
	var coords = selection.getCoords();
	var startColumn = coords.top.x;
	var endColumn = startColumn + nitobi.data.FormatConverter.getDataColumns(pasteClipBoard.value)-1;

	var editable = true;
	for (var i = startColumn; i <= endColumn; i++)
	{
		var columnObject = this.getColumnObject(i);
		if (columnObject)
		{
			if (!columnObject.isEditable())
			{
				editable = false;
				break;
			}
		}
	}

	if (!editable)
	{
		// TODO: what is the approach to these sorts of alerts???
		// TODO: put a default class on read only columns ntb-grid-columnreadonly
		this.fire("PasteFailed", new nitobi.base.EventArgs(this));
		this.handleAfterPaste();
		return;
	}
	else
	{
		//	get the list of mapped columns for the given columns
		var columnList = this.getColumnMap(startColumn, endColumn);

		//	get the pasting row coordinates
		var startRow = coords.top.y;
		var endRow = Math.max(startRow + nitobi.data.FormatConverter.getDataRows(pasteClipBoard.value)-1, 0);

		this.getSelection().selectWithCoords(startRow,startColumn,endRow,startColumn+columnList.length-1);

		var pasteEventArgs = new nitobi.grid.OnPasteEventArgs(this, pasteClipBoard.value, coords);
		if (!this.fire("BeforePaste", pasteEventArgs)) return;

		var clipboardValue = pasteClipBoard.value;
		var preMergedEbaXml = null;
		

		if(this.mode == nitobi.grid.PAGINGMODE_STANDARD)
		{
			var lastVisibleRow = this.datatable.getRowNodes().length -1;
			//console.log('End row: ' + endRow + ' Last visible row: ' + lastVisibleRow);
			
			// create records 
			if(endRow > lastVisibleRow)
			{
				var numRowsToInsert = endRow - lastVisibleRow;
				for(var j=0;j<numRowsToInsert;j++)
				{
					var defaultRow = this.datatable.getTemplateNode();
		
					for (var i = 0; i < this.columnCount(); i++)
					{
						var columnObject = this.getColumnObject(i);
						var initialValue = columnObject.getInitial();
						if (initialValue == null || initialValue == "")
						{
							var dataType = columnObject.getDataType();
							// TODO: This is a temp fix for moz. DataType isn;t set correctly for some reason.
							if (dataType == null || dataType == "")
							{
								dataType = "text";
							}
							switch (dataType)
							{
								case "text":
								{
									initialValue="";
									break;
								}
								case "number":
								{
									initialValue=0;
									break;
								}
								case "date":
								{
									initialValue="1900-01-01";
									break;
								}
							}
						}
						var att = columnObject.getxdatafld().substr(1);
						if (att != null && att != "")
						{
							defaultRow.setAttribute(att, initialValue);
						}
					}
					this.datatable.createRecord(defaultRow,lastVisibleRow + j + 1);
				}
			}
			
		}
		
		if (clipboardValue.substr(0,1)=="<") {
			// Reasoning: if < is the first character then this is likely an HTML table
			preMergedEbaXml = nitobi.data.FormatConverter.convertHtmlTableToEbaXml(clipboardValue, columnList, startRow);
		} else {
			// otherwise its a tab-separated value list
			preMergedEbaXml = nitobi.data.FormatConverter.convertTsvToEbaXml(clipboardValue, columnList, startRow);
		}

		if (preMergedEbaXml.documentElement != null) {
			this.datatable.mergeFromXml(preMergedEbaXml, nitobi.lang.close(this, this.pasteComplete, [preMergedEbaXml, startRow, endRow, pasteEventArgs]));
		}
	}
}

/**
 * Completes the paste operation after the asynchronous get on the grid data.
 * @private
 */
nitobi.grid.Grid.prototype.pasteComplete = function(preMergedEbaXml,startRow,endRow, pasteEventArgs)
{
	// Call Viewport.render() (or notify with event)
	this.Scroller.reRender(startRow, endRow);

	this.subscribeOnce("HtmlReady", this.handleAfterPaste, this, [pasteEventArgs]);
}

/**
 * Event handler that fires after data has been pasted into the Grid. 
 * Fires the <code>AfterPaste</code> event
 * @param {nitobi.grid.OnPasteEventArgs} eventArgs The paste operation event 
 * arguments.
 * @private
 */
nitobi.grid.Grid.prototype.handleAfterPaste = function(eventArgs)
{
	this.fire("AfterPaste", eventArgs);
}

/**
 * Creates a hidden textarea if it does not already exist. This hidden textarea is used as our "clipboard" by capturing keypress events and then 
 * assigning focus to the clipboard before the actual keydown event fires causing the clipboard information to be either pasted or copied.
 * @private
 * @type Clipboard 
 */
nitobi.grid.Grid.prototype.getClipboard = function()
{
	var clipboard = document.getElementById("ntb-clipboard"+this.uid);
	clipboard.onkeyup = null;
	clipboard.value = '';
	return clipboard;
}

/**
 * Returns the Selection that represents the currently cells of the Grid
 * @type nitobi.grid.Selection
 */
nitobi.grid.Grid.prototype.getSelection = function()
{
	return this.selection;
}

/**
 * Fires the <code>HtmlReady</code> event.
 * @private
 */
nitobi.grid.Grid.prototype.handleHtmlReady = function(evtArgs)
{
	this.fire("HtmlReady", new nitobi.base.EventArgs(this));
}

// TODO: Remove the subscribe and fire methods to IObservable which the grid implements.
/**
 * Manually fires the particular event.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="">
 * var grid = nitobi.getComponent('grid1');
 * grid.fire("CellClick"); // Note we supply "CellClick" for the OnCellClickEvent
 * </code></pre>
 * </div>
 * @param {String} evt The identifier for the evnt such as "HtmlReady".
 * @param {Object} args Any arguments to pass to the event handlers.
 * @private
 */
nitobi.grid.Grid.prototype.fire=function(evt,args){
	return nitobi.event.notify(evt+this.uid,args);
}

/**
 * Subscribes a function to a Grid event.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="">
 * var grid = nitobi.getComponent('grid1');
 * grid.subscribe("DataReady", myFunction);
 * </code></pre>
 * </div>
 * <p>
 * Notice that the event we are subscribing to does not specify the "On" 
 * or "Event" parts of the name.
 * </p>
 * @param {String} evt A event string identifier or key for the given 
 * event. This value is the event name without the "On" and "Event" parts 
 * of the name, for example, the key for the OnDataReadyEvent is becomes 
 * "DataReady".
 * @param {Function} func A reference to the Function object that should 
 * be called when the event is fired.
 * @param {Object} context A reference to the Object that the Function 
 * should be called in the context of. When writing object oriented 
 * JavaScript the reference to the Function must also have some context 
 * in which it is to be executed.
 * @see nitobi.grid.Grid#subscribeOnce
 * @see nitobi.grid.Grid#unsubscribe
 * @private
 */
nitobi.grid.Grid.prototype.subscribe=function(evt,func,context){
	if (this.subscribedEvents == null)
		this.subscribedEvents = {};
	if (typeof(context)=="undefined") context=this;
	var guid = nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
	this.subscribedEvents[guid] = evt+this.uid;
	return guid;
}

/**
 * Subscribe to an event only once.  That is, the handler is only fired 
 * once and then automatically unregistered.
 * <p>
 * <b>Example</b>:  Load the grid and subscribe to the OnHtmlReadyEvent
 * </p>
 * <div class="code">
 * <pre><code class="">
 * &#102;unction loadGrid()
 * {
 * 	var grid = nitobi.loadComponent('grid1');
 * 	grid.subscribeOnce("HtmlReady", handleHtmlEvent, null, new Array(grid));
 * }
 * 
 * &#102;unction handleHtmlEvent(gridObj)
 * {
 * 	gridObj.selectCellByCoords(0,0);
 * 	gridObj.edit();
 * }
 * </code></pre>
 * </div>
 * @param {String} evt A event string identifier or key for the given event. This value is the event name without the "On" and "Event" parts of the name, for example, the key for the OnDataReadyEvent is becomes "DataReady".
 * @param {Function} func A reference to the Function object that should be called when the event is fired.
 * @param {Object} context A reference to the Object that the Function should be called in the context of. When writing object oriented JavaScript the reference to the Function must also have some context in which it is to be executed.
 * @param {Array} params Any parameters that should be passed to the handler function.
 * @see #subscribe
 * @private
 */
nitobi.grid.Grid.prototype.subscribeOnce = function(evt, func, context, params)
{
	var guid = null;
	var _this = this;
	var func1 = function()
	{
		func.apply(context || this, params || arguments);
		_this.unsubscribe(evt, guid);
	}
	guid = this.subscribe(evt,func1);
}

/**
 * Unsubscribes an event from Grid.
 * @param {String} evt The event name without the "On" prefix and "Event" suffix.
 * @param {Number} guid The unique ID of the event as returned by the subscribe method. 
 * If the event is defined through the declaration the unique ID can be accessed through the grid API such as grid.OnHtmlReadyEvent.
 */
nitobi.grid.Grid.prototype.unsubscribe=function(evt,guid)
{
	return nitobi.event.unsubscribe(evt+this.uid, guid);
}

/**
 * Fired when the page is unloaded. The Grid is repsonsible for disposing of all its child objects such that 
 * there is no memory leak in Internet Explorer from circular DOM / JS references.
 * @private
 */
nitobi.grid.Grid.prototype.dispose = function()
{
	try {
		//	Remove the DOM node to JS object circular reference.
		this.element.jsObject = null;

		//	global xml documents
		editorXslProc = null;

		// Detach the DOM events
		 var H = nitobi.html;
		H.detachEvents(this.getGridContainer(), this.events);
		H.detachEvents(this.getHeaderContainer(), this.headerEvents);
		H.detachEvents(this.getDataContainer(), this.cellEvents);
		H.detachEvents(this.getScrollerContainer(), this.scrollerEvents);
		H.detachEvents(this.keyNav, this.keyEvents);

		for (var item in this.subscribedEvents) {
			var evtName = this.subscribedEvents[item];
			this.unsubscribe(evtName.substring(0,evtName.length-this.uid.length), item);
		}

		this.UiContainer.parentNode.removeChild(this.UiContainer);

		for (var item in this)
		{
			if (this[item] != null)
			{
				if (this[item].dispose instanceof Function)
				{
					this[item].dispose();
				}
				this[item] = null;
			}
		}

		//	Dispose of all the editors that were possibly created
		//	Use the global nitobi.form.ControlFactory.instance class
		nitobi.form.ControlFactory.instance.dispose();
	} catch(e) {

	}
}

// backwards compatibility.
/**
 * @private
 */
nitobi.Grid = nitobi.grid.Grid;

/**#@-*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a new Cell object
 * @class The Cell object represents a single row/column combination in the Grid. 
 * It can be used to get or set values of cells in the Grid, or to manipulate
 * the look of a particular cell.
 * <p>
 * A cell is represented in two ways:  as a rendered html element and as
 * an xml node.  The Cell object provides a means to affect either
 * representation
 * </p>
 * @constructor
 * @param {nitobi.grid.Grid} grid
 * @param {Number|HTMLElement} row This argument can either be a row index or a HtmlElement. 
 * If the row index is used the third argument is also required.
 * @param {Number} [column] Index of the column of the Cell. It is 
 * required if the row argument is specified as a row index and not a Cell HTML element.
 * @see nitobi.grid.Grid#getCellObject
 */
nitobi.grid.Cell = function(grid, row, column)
{
	// Row should not be null
	if (row == null || grid == null)
		return null;

	/**
	 * @private
	 */
	this.grid=grid;

	/**
	 * @private
	 */
	var DomNode = null;
	if (typeof(row) == "object")
	{
		var cell = row;
		row = Number(cell.getAttribute('xi'));
		column = cell.getAttribute('col');
		DomNode = cell;
	}
	else
	{
		DomNode = this.grid.getCellElement(row, column);
	}

	/**
	 * @private
	 */
	 this.DomNode = DomNode;


	// For backwards compatibility have the lower case but they should be upper for getRow etc...
	/**
	 * @private
	 */
	this.row=Number(row);
	/**
	 * @private
	 */
	this.Row=this.row;

	/**
	 * @private
	 */
	this.column=Number(column);
	/**
	 * @private
	 */
	this.Column=this.column;

	/**
	 * @private
	 */
	this.dataIndex = this.Row;
}

/**
 * Returns the XML node from the DataTable that contains the Cell data.
 * @type XMLNode
 * @see #getValue
 */
nitobi.grid.Cell.prototype.getData = function() {
	// TODO: We should not need the column object to get the attribute mapping
	// TODO: We may have problems after sorting for example
	if (this.DataNode == null)
		this.DataNode = this.grid.datatable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@xi='+this.dataIndex+']/'+this.grid.datatable.fieldMap[this.getColumnObject().getColumnName()]);
	return this.DataNode;
}

/**
 * Returns the XML node that represents the Cell state.
 * @type XMLNode
 */
nitobi.grid.Cell.prototype.getModel = function() {
	if (this.ModelNode == null)
		this.ModelNode = this.grid.model.selectSingleNode("//nitobi.grid.Columns/nitobi.grid.Column[@xi='"+this.column+"']");
	return this.ModelNode;
}

/**
 * @private
 */
nitobi.grid.Cell.prototype.setRow = function() {
	this.jSET("Row",arguments);
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.getRow = function() {
	return this.Row;
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.setColumn = function() {
	this.jSET("Column",arguments);
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.getColumn = function() {
	return this.Column;
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.setDomNode = function() {	
	this.jSET("DomNode",arguments);	
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.getDomNode = function() {
	return this.DomNode;
};

/**
 * @private
 */
nitobi.grid.Cell.prototype.setDataNode = function() {
	this.jSET("DataNode",arguments);	
};

/**
 * This sets the value of a cell which results in the value being set in 
 * the datasource (its xml node) and the view of the data being updated
 * (the html rendered for the cell).  If the cell 
 * belongs to a number or date column, for example, the value will have 
 * the appropriate mask applied to it.
 * @example
 * &#102;unction setCellValue(row, col, value)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var cell = grid.getCellObject(row, col);
 * 	cell.setValue(value);
 * }
 * @param {String} value The value which will be put in the database.
 * @param {String} [display] The value which will be displayed in the Grid.
 */
nitobi.grid.Cell.prototype.setValue = function(value, display) 
{
	if (value == this.getValue())
		return;

	//	First thing to do is validate the input for the given column type.

	var colObj = this.getColumnObject();

	//	Second thing to do is to actually format the data for presentation in the HTML

	var domValue = '';
	switch (colObj.getType())
	{
		case 'PASSWORD':
			for (var i=0; i<value.length; i++)
			{
				domValue += '*';
			}
			break;
		case 'NUMBER':
			if (this.numberXsl == null)
				this.numberXsl = nitobi.form.numberXslProc;

			if (value == "")
				value = colObj.getEditor().defaultValue || 0;

			if (this.DomNode != null)
			{
				if (value < 0)
					nitobi.html.Css.addClass(this.DomNode, "ntb-cell-negativenumber");
				else
					nitobi.html.Css.removeClass(this.DomNode, "ntb-cell-negativenumber");
			}

			var mask = colObj.getMask();
			var nmask = colObj.getNegativeMask();
			var maskedValue = value;
			if (value < 0 && nmask != "")
			{
				mask = nmask;
				// if there is a negative mask let it handle the negative sign.
				maskedValue = (value+"").replace("-","");
			}

			this.numberXsl.addParameter("number", maskedValue, "");
			this.numberXsl.addParameter("mask", mask, "");
			this.numberXsl.addParameter("group", colObj.getGroupingSeparator(), "");
			this.numberXsl.addParameter("decimal", colObj.getDecimalSeparator(), "");

			// Now reformat the number according to the mask and add the mask signs again.
			domValue = nitobi.xml.transformToString(nitobi.xml.Empty, this.numberXsl);

			// Check if the mask was applied

			if("" == domValue && value != "")
			{
				domValue = nitobi.html.getFirstChild(this.DomNode).innerHTML;
				value = this.getValue();
				// ebaErrorReport("[" + this.control.value + "] is not a valid date. Only a valid date such as '2006-12-05' can be entered in this cell.","",EBA_ERROR);
			}

			break;
		case 'DATE':
			if (this.dateXsl == null)
				this.dateXsl = nitobi.form.dateXslProc.stylesheet;

			var d = new Date();
			var xmlDoc = nitobi.xml.createXmlDoc('<root><date>'+value+'</date><year>'+(d.getFullYear())+'</year><mask>'+this.columnObject.getMask()+'</mask></root>');

			domValue = nitobi.xml.transformToString(xmlDoc, this.dateXsl);

			// Check if the mask was applied
			if("" == domValue)
			{
				domValue = nitobi.html.getFirstChild(this.DomNode).innerHTML;
				value = this.getValue();
				// ebaErrorReport("[" + this.control.value + "] is not a valid date. Only a valid date such as '2006-12-05' can be entered in this cell.","",EBA_ERROR);
			}
			/* TODO: this was merged from Schenker but is messing things up now...
			else
            {
                value = domValue;
            }
            */

			break;
		case 'TEXTAREA':
			domValue = nitobi.html.encode(value);
			break;
		case 'LOOKUP':
			var colObjModel = colObj.getModel();
			// TODO: these getAttribute calls need to be converted to proper API methods once we separate Editors and Columns
			var sDatasourceId = colObjModel.getAttribute('DatasourceId');
			var dataTable = this.grid.data.getTable(sDatasourceId);
			var displayFields = colObjModel.getAttribute('DisplayFields');
			var valueField = colObjModel.getAttribute('ValueField');
			var xmlNode = dataTable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@'+valueField+'=\''+value+'\']/@'+displayFields);
			if (xmlNode != null)
				domValue = xmlNode.nodeValue;
			else
				domValue = value;
			break;
		case 'CHECKBOX':
			var colObjModel = colObj.getModel();
			var sDatasourceId = colObjModel.getAttribute('DatasourceId');
			var dataTable = this.grid.data.getTable(sDatasourceId);
			var displayFields = colObjModel.getAttribute('DisplayFields');
			var valueField = colObjModel.getAttribute('ValueField');
			var checkedValue = colObjModel.getAttribute('CheckedValue');
			if (checkedValue == '' || checkedValue == null)
				checkedValue = 0;

			var displayValue = dataTable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@'+valueField+'=\''+value+'\']/@'+displayFields).nodeValue;

			var checkstate = (value == checkedValue)?"checked":"unchecked";
			domValue = '<div style="overflow:hidden;"><div class="ntb-checkbox ntb-checkbox-'+checkstate+'" checked="'+value+'">&nbsp;</div><div class="ntb-checkbox-text">'+nitobi.html.encode(displayValue)+'</div></div>';

			break;
		case 'LISTBOX':
			var colObjModel = colObj.getModel();
			var sDatasourceId = colObjModel.getAttribute('DatasourceId');
			var dataTable = this.grid.data.getTable(sDatasourceId);
			var displayFields = colObjModel.getAttribute('DisplayFields');
			var valueField = colObjModel.getAttribute('ValueField');
			domValue = dataTable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@'+valueField+'=\''+value+'\']/@'+displayFields).nodeValue;
			break;
		case 'IMAGE':
			domValue = nitobi.html.getFirstChild(this.DomNode).innerHTML;
			if (nitobi.lang.typeOf(value) == nitobi.lang.type.HTMLNODE)
				domValue = '<img border="0" src="'+value.getAttribute('src')+'" />';
			else if (typeof(value) == "string")
				domValue = '<img border="0" src="'+value+'" />';
//			else
//				throw "Invalid value for an Image cell. Expected either an <img> element or image src location.";
			break;
		default:
			domValue = value;
	}
	
	domValue = domValue || "&nbsp;";

	if (this.DomNode != null)
	{
		var elem = nitobi.html.getFirstChild(this.DomNode);
		elem.innerHTML = domValue || "&nbsp;"; 
		elem.setAttribute("title", value);
		this.DomNode.setAttribute("value", value);
	}

	this.grid.datatable.updateRecord(this.dataIndex, colObj.getColumnName(), value);
}

/**
 * Gets the value of the cell from its xml node.
 * @type String
 */
nitobi.grid.Cell.prototype.getValue = function()
{
	// TODO: Need to return the correct JS type
	var colObj = this.getColumnObject();
	var val = this.GETDATA();
	switch (colObj.getType())
	{
		case 'NUMBER':
			val = parseFloat(val);
			break;
//		case 'DATE':
//			break;
		default:
	}

	return val;
}

/**
 * Gets the value of the cell <i>displayed</i> in the Grid.
 * That is, this method obtains the cell value from the rendered
 * html representation of the cell.
 * @type String
 * @see #getValue
 */
nitobi.grid.Cell.prototype.getHtml = function()
{
	return nitobi.html.getFirstChild(this.DomNode).innerHTML;
}

/**
 * Puts the cell into edit mode.
 * @example
 * &#102;unction editCell(row, col)
 * {
 * 	var grid = nitobi.getComponent('grid1');
 * 	var cell = grid.getCellObject(row, col);
 * 	cell.edit();
 * }
 */
nitobi.grid.Cell.prototype.edit = function()
{
	this.grid.setActiveCell(this.DomNode);
	this.grid.edit();
}

/**
 * @private
 */
nitobi.grid.Cell.prototype.GETDATA = function()
{
	var node = this.getData();
	if (node!=null) {
		return node.value;
	}
}

/**
 * @private
 */
nitobi.grid.Cell.prototype.xGETMETA = function()
{
	if (this.MetaNode == null) return null;  
	var node = this.MetaNode;
	node = node.selectSingleNode("@"+arguments[0]);
	if (node!=null) {
		return node.value;
	}
}

/**
 * @private
 */
nitobi.grid.Cell.prototype.xSETMETA = function()
{
	var node = this.MetaNode;
	if (node!=null) {
		node.setAttribute(arguments[0],arguments[1][0]);

		// Log changes
		// TODO: This all needs to be changed since we either dont use logMeta or dont even save this type of information.
	} else {
		alert("Cannot set property: "+arguments[0])
	}
}

/**
 * xSETCSS sets a value in the Grid CSS.
 * @private
 */
nitobi.grid.Cell.prototype.xSETCSS = function()
{
	var node = this.DomNode;
	if (node!=null) {
		node.style.setAttribute(arguments[0],arguments[1][0]);
	} else {
		alert("Cannot set property: "+arguments[0])
	}
}

/**
 * xGET gets a value from the Grid model XML document.
 * @private
 */
nitobi.grid.Cell.prototype.xGET = function()
{
	var node = this.getModel();
	node = node.selectSingleNode(arguments[0]);
	if (node!=null) {
		return node.value;
	}
}

/**
 * xSET sets a value in the Grid model XML document.
 * @private
 */
nitobi.grid.Cell.prototype.xSET = function()
{
	var node = this.getModel();
	node = node.selectSingleNode(arguments[0]);
	if (node!=null) {
		node.nodeValue=arguments[1][0];
	}
}

/**
 * Returns the native web browser Style object for the given cell.
 * @example
 * var grid = nitobi.getComponent("myGrid");
 * var cell = grid.getCellObject(0,0);
 * var style = cell.getStyle();
 * style.backgroundColor = "blue";
 * @type Object
 */
nitobi.grid.Cell.prototype.getStyle = function()
{
	return this.DomNode.style;
}

/**
 * Returns the Column object to which the given cell belongs.
 * @type nitobi.grid.Column
 */
nitobi.grid.Cell.prototype.getColumnObject = function()
{
	if (typeof(this.columnObject) == "undefined")
	{
		this.columnObject = this.grid.getColumnObject(this.getColumn());
	}
	return this.columnObject;
}

/**
 * Returns the cell HTML element for the given Grid, row and column indices.
 * @param {nitobi.grid.Grid} grid The Grid to which the cell belongs.
 * @param {Number} row The row index of the Cell.
 * @param {Number} column The column index of the Cell.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Cell.getCellElement = function(grid, row, column)
{
	return $ntb("cell_"+row+"_"+column+"_"+grid.uid);
}

/**
 * Returns the row number of a cell based on the DOM representation of 
 * that cell.
 * @param {HtmlElement} element The cell's html element.
 * @type Number
 */
nitobi.grid.Cell.getRowNumber = function(element)
{
	return parseInt(element.getAttribute("xi"));
}


/**
 * Returns the column number of a cell (zero indexed) based on the DOM representation of 
 * that cell.
 * @param {HtmlElement} element
 * @type Number
 */
nitobi.grid.Cell.getColumnNumber = function(element)
{
	return parseInt(element.getAttribute("col"));
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Creates a new CellEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with cells (e.g oncellclickevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" oncellclickevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of CellEventArgs to be passed to our handler.
 * 	var cell = event.getCell();
 * 	cell.getStyle().backgroundColor = "red";
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that received focus.
 */
nitobi.grid.CellEventArgs = function(source, cell)
{
	nitobi.grid.CellEventArgs.baseConstructor.call(this, source);
	/**
	 * @private
	 */
	this.cell = cell;
}

nitobi.lang.extend(nitobi.grid.CellEventArgs, nitobi.base.EventArgs);

/**
 * Gets the Cell on which the event was fired.
 * @type nitobi.grid.Cell
 */
nitobi.grid.CellEventArgs.prototype.getCell = function()
{
	return this.cell;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a RowEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with rows (e.g onrowfocusevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onrowfocusevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of CellEventArgs to be passed to our handler.
 * 	var row = event.getRow();
 * 	var cell = row.getCell(0);
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} row The Row object of the cell that received focus.
 */
nitobi.grid.RowEventArgs = function(source, row)
{
	/**
	 * @private
	 */
	this.grid = source;
	/**
	 * @private
	 */
	this.row = row;
	/**
	 * @private
	 */
	this.event = nitobi.html.Event;
}

/**
 * Gets the Grid that fired the event.
 * @type nitobi.grid.Grid
 */
nitobi.grid.RowEventArgs.prototype.getSource = function()
{
	return this.grid;
}
/**
 * Gets the Row on which the event was fired.
 * @type nitobi.grid.Cell
 */
nitobi.grid.RowEventArgs.prototype.getRow = function()
{
	return this.row;
}
/**
 * Gets the native browser Event object that is associated with the event. This may be null in some case.
 * @private
 */
nitobi.grid.RowEventArgs.prototype.getEvent = function()
{
	return this.event;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a SelectionEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with selections (e.g onbeforecopyevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onbeforecopyevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of SelectionEventArgs to be passed to our handler.
 * 	var grid = event.getSource();
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {String} data The data that was copied in HTML table format.
 * @param {Object} [coords] The top left and bottom right coords, which are nitobi.drawing.Point objects. {"top":POINT,"bottom":POINT}.
 */
nitobi.grid.SelectionEventArgs = function(source, data, coords)
{
	/**
	 * @private
	 */
	this.source = source;
	/**
	 * @private
	 */
	this.coords = coords
	/**
	 * @private
	 */
	this.data = data;
}

/**
 * Gets the Grid that fired the event.
 * @type nitobi.grid.Grid
 */
nitobi.grid.SelectionEventArgs.prototype.getSource = function()
{
	return this.source;
}

/**
 * Returns the coordinates associated with the Selection event.
 * @type Object
 */
nitobi.grid.SelectionEventArgs.prototype.getCoords = function()
{
	return this.coords;
}

/**
 * Returns the data associated with the Selection event.
 * @type String
 */
nitobi.grid.SelectionEventArgs.prototype.getData = function()
{
	return this.data;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a new Column object.
 * @class The Column class abstracts a single column in a Nitobi Grid.  It provides the base functionality
 * for all the different column types.
 * <pre class="code">
 * var grid = nitobi.getComponent("myGridId");
 * var col = grid.getColumnObject(2);
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} grid The grid object this column belongs to
 * @param {Number} column The index of the column (zero based)
 */
nitobi.grid.Column = function(grid,column)
{
	/**
	 * @private
	 */
	this.grid=grid;
	/**
	 * @private
	 */
	this.column=column;
	/**
	 * @private
	 */
	this.uid=nitobi.base.getUid();

	/**
	 * @private
	 * This is a hash of named attributes to XML DOM nodes (attributes or elements) in the Grid model.
	 */
	this.modelNodes = {};
}

nitobi.grid.Column.prototype = {

	/**
	 * Sets the alignment of the column.
	 * @param {String} align The alignment to set.
	 */
	setAlign:function(){this.xSET("Align",arguments);},
	/**
	 * Returns the alignment of the column.
	 * @type String
	 */
	getAlign:function(){return this.xGET("Align",arguments);},
	/**
	 * Sets the css class to apply to the column.
	 * @param {String} css The classname to apply.
	 */
	setClassName:function(){this.xSET("ClassName",arguments);},
	/**
	 * Returns the css class to apply to the column.
	 * @type String
	 */
	getClassName:function(){return this.xGET("ClassName",arguments);},
	/**
	 * Sets the inline style to apply to the column.
	 * @param {String} style The style to apply.
	 */
	setCssStyle:function(){this.xSET("CssStyle",arguments);},
	/**
	 * Returns the inline style for the column.
	 * @type String
	 */
	getCssStyle:function(){return this.xGET("CssStyle",arguments);},
	setColumnName:function(){this.xSET("ColumnName",arguments);},
	getColumnName:function(){return this.xGET("ColumnName",arguments);},
	setType:function(){this.xSET("type",arguments);},
	getType:function(){return this.xGET("type",arguments);},
	setDataType:function(){this.xSET("DataType",arguments);},
	getDataType:function(){return this.xGET("DataType",arguments);},
	/**
	 * Sets whether or not to have the column be editable.
	 * @param {Boolean} edit True to enable editing.
	 */
	setEditable:function(){this.xSET("Editable",arguments);},
	/**
	 * Returns true if the column is editable.
	 * @type Boolean
	 */
	isEditable:function(){return nitobi.lang.toBool(this.xGET("Editable",arguments), true);},
	/**
	 * Sets the initial value for the cells of the column.
	 * @param {String} init The initial value to use.
	 */
	setInitial:function(){this.xSET("Initial",arguments);},
	/**
	 * Returns the initial value for the cells of the column.
	 * @type String
	 */
	getInitial:function(){return this.xGET("Initial",arguments);},
	/**
	 * Sets the label to render for the column.
	 * @param {String} label The label to use.
	 */
	setLabel:function(){this.xSET("Label",arguments);},
	/**
	 * Returns the label text of the column.
	 * @type String
	 */
	getLabel:function(){return this.xGET("Label",arguments);},
	setGetHandler:function(){this.xSET("GetHandler",arguments);},
	getGetHandler:function(){return this.xGET("GetHandler",arguments);},
	setDatasourceId:function(){this.xSET("DatasourceId",arguments);},
	getDatasourceId:function(){return this.xGET("DatasourceId",arguments);},
	setTemplate:function(){this.xSET("Template",arguments);},
	getTemplate:function(){return this.xGET("Template",arguments);},
	setTemplateUrl:function(){this.xSET("TemplateUrl",arguments);},
	getTemplateUrl:function(){return this.xGET("TemplateUrl",arguments);},
	/**
	 * Sets the maximum number of characters for the cell.
	 * @param {Number} max The max number of characters.
	 */
	setMaxLength:function(){this.xSET("maxlength",arguments);},
	/**
	 * Returns the maximum number of characters for the cell.
	 * @type String
	 */
	getMaxLength:function(){return Number(this.xGET("maxlength",arguments));},
	setSortDirection:function(){this.xSET("SortDirection",arguments);},
	getSortDirection:function(){return this.xGET("SortDirection",arguments);},
	/**
	 * Sets whether to enable sorting on the column.
	 * @param {Boolean} sort True to enable sorting.
	 */
	setSortEnabled:function(){this.xSET("SortEnabled",arguments);},
	/**
	 * Returns true if sorting is enabled on the column.
	 * @type Boolean
	 */
	isSortEnabled:function(){return nitobi.lang.toBool(this.xGET("SortEnabled",arguments), true);},
	/**
	 * Sets the width of the column.
	 * @param {Number} width The width to apply to the column.
	 */
	setWidth:function(){this.xSET("Width",arguments);},
	/**
	 * Returns the width of the column.
	 * @type Number
	 */
	getWidth:function(){return Number(this.xGET("Width",arguments));},
	setSize:function(){this.xSET("Size",arguments);},
	getSize:function(){return Number(this.xGET("Size",arguments));},
	/**
	 * Sets whether or not the column should be visible.
	 * @param {Boolean} visible True to have the column be visible.
	 */
	setVisible:function(){this.xSET("Visible",arguments);},
	/**
	 * Returns true if the column is visible.
	 * @type Boolean
	 */
	isVisible:function(){return nitobi.lang.toBool(this.xGET("Visible",arguments), true);},
	setxdatafld:function(){this.xSET("xdatafld",arguments);},
	getxdatafld:function(){return this.xGET("xdatafld",arguments);},
	setValue:function(){this.xSET("Value",arguments);},
	getValue:function(){return this.xGET("Value",arguments);},
	setxi:function(){this.xSET("xi",arguments);},
	getxi:function(){return Number(this.xGET("xi",arguments));},
	setEditor:function(){this.xSET("Editor",arguments);},
	getEditor:function(){return this.xGET("Editor",arguments);},
	setDisplayFields:function(){this.xSET("DisplayFields",arguments);},
	getDisplayFields:function(){return this.xGET("DisplayFields",arguments);},
	setValueField:function(){this.xSET("ValueField",arguments);},
	getValueField:function(){return this.xGET("ValueField",arguments);},
	setDelay:function(){this.xSET("Delay",arguments);},
	getDelay:function(){return Number(this.xGET("Delay",arguments));},
	setReferenceColumn:function(){this.xSET("ReferenceColumn",arguments);},
	getReferenceColumn:function(){return this.xGET("ReferenceColumn",arguments);},
	setOnCellClickEvent:function(){this.xSET("OnCellClickEvent",arguments);},
	getOnCellClickEvent:function(){return this.xGET("OnCellClickEvent",arguments);},
	setOnBeforeCellClickEvent:function(){this.xSET("OnBeforeCellClickEvent",arguments);},
	getOnBeforeCellClickEvent:function(){return this.xGET("OnBeforeCellClickEvent",arguments);},
	setOnCellDblClickEvent:function(){this.xSET("OnCellDblClickEvent",arguments);},
	getOnCellDblClickEvent:function(){return this.xGET("OnCellDblClickEvent",arguments);},
	setOnHeaderDoubleClickEvent:function(){this.xSET("OnHeaderDoubleClickEvent",arguments);},
	getOnHeaderDoubleClickEvent:function(){return this.xGET("OnHeaderDoubleClickEvent",arguments);},
	setOnHeaderClickEvent:function(){this.xSET("OnHeaderClickEvent",arguments);},
	getOnHeaderClickEvent:function(){return this.xGET("OnHeaderClickEvent",arguments);},
	setOnBeforeResizeEvent:function(){this.xSET("OnBeforeResizeEvent",arguments);},
	getOnBeforeResizeEvent:function(){return this.xGET("OnBeforeResizeEvent",arguments);},
	setOnAfterResizeEvent:function(){this.xSET("OnAfterResizeEvent",arguments);},
	getOnAfterResizeEvent:function(){return this.xGET("OnAfterResizeEvent",arguments);},
	setOnCellValidateEvent:function(){this.xSET("OnCellValidateEvent",arguments);},
	getOnCellValidateEvent:function(){return this.xGET("OnCellValidateEvent",arguments);},
	setOnBeforeCellEditEvent:function(){this.xSET("OnBeforeCellEditEvent",arguments);},
	getOnBeforeCellEditEvent:function(){return this.xGET("OnBeforeCellEditEvent",arguments);},
	setOnAfterCellEditEvent:function(){this.xSET("OnAfterCellEditEvent",arguments);},
	getOnAfterCellEditEvent:function(){return this.xGET("OnAfterCellEditEvent",arguments);},
	setOnCellBlurEvent:function(){this.xSET("OnCellBlurEvent",arguments);},
	getOnCellBlurEvent:function(){return this.xGET("OnCellBlurEvent",arguments);},
	setOnCellFocusEvent:function(){this.xSET("OnCellFocusEvent",arguments);},
	getOnCellFocusEvent:function(){return this.xGET("OnCellFocusEvent",arguments);},
	setOnBeforeSortEvent:function(){this.xSET("OnBeforeSortEvent",arguments);},
	getOnBeforeSortEvent:function(){return this.xGET("OnBeforeSortEvent",arguments);},
	setOnAfterSortEvent:function(){this.xSET("OnAfterSortEvent",arguments);},
	getOnAfterSortEvent:function(){return this.xGET("OnAfterSortEvent",arguments);},
	setOnCellUpdateEvent:function(){this.xSET("OnCellUpdateEvent",arguments);},
	getOnCellUpdateEvent:function(){return this.xGET("OnCellUpdateEvent",arguments);},
	setOnKeyDownEvent:function(){this.xSET("OnKeyDownEvent",arguments);},
	getOnKeyDownEvent:function(){return this.xGET("OnKeyDownEvent",arguments);},
	setOnKeyUpEvent:function(){this.xSET("OnKeyUpEvent",arguments);},
	getOnKeyUpEvent:function(){return this.xGET("OnKeyUpEvent",arguments);},
	setOnKeyPressEvent:function(){this.xSET("OnKeyPressEvent",arguments);},
	getOnKeyPressEvent:function(){return this.xGET("OnKeyPressEvent",arguments);},
	setOnChangeEvent:function(){this.xSET("OnChangeEvent",arguments);},
	getOnChangeEvent:function(){return this.xGET("OnChangeEvent",arguments);},
	setGetOnEnter:function(){this.xbSET("GetOnEnter",arguments);},
	isGetOnEnter:function(){return nitobi.lang.toBool(this.xGET("GetOnEnter",arguments), true);},		
	setAutoComplete:function(){this.xbSET("AutoComplete",arguments);},
	isAutoComplete:function(){return nitobi.lang.toBool(this.xGET("AutoComplete",arguments), true);},		
	setAutoClear:function(){this.xbSET("AutoClear",arguments);},
	isAutoClear:function(){return nitobi.lang.toBool(this.xGET("AutoClear",arguments), true);}
}

/**
 * Returns the XML node that represents the Column state.
 * @type XMLElement
 */
nitobi.grid.Column.prototype.getModel = function() {
	if (this.ModelNode == null) {
		// TODO: CHECK ON THIS WHEN MERGING 
		var index = this.column;
//		if (nitobi.browser.MOZ)
//			index++;
		this.ModelNode=this.grid.model.selectNodes("//state/nitobi.grid.Columns/nitobi.grid.Column")[index];
	}
	return this.ModelNode;
}

/**
 * Returns the HTML element of the column header.
 * @type HTMLElement
 */
nitobi.grid.Column.prototype.getHeaderElement = function()
{
	return nitobi.grid.Column.getColumnHeaderElement(this.grid, this.column);
}

/**
 * @private
 */
nitobi.grid.Column.prototype.getEditor = function()
{
	
}
/**
 * Returns a native browser style object that can be used to get and set styles for the entire Column including
 * both the header and the data cells.
 * @type Object
 */
nitobi.grid.Column.prototype.getStyle = function()
{
	var className = this.getClassName();
	return nitobi.html.getClass(className);
}
/**
 * Returns a native browser style object that can be used to get and set styles for the Column header.
 * @type Object
 */
nitobi.grid.Column.prototype.getHeaderStyle = function()
{
	var className = "acolumnheader"+this.grid.uid+"_"+this.column;
	return nitobi.html.getClass(className);
}
/**
 * Returns a native browser style object that can be used to get and set styles for the Column data cells.
 * @type Object
 */
nitobi.grid.Column.prototype.getDataStyle = function()
{
	var className = "ntb-column-data"+this.grid.uid+"_"+this.column;
	return nitobi.html.getClass(className);
}

/**
 * Returns a reference to the editor object for the Column.
 * @type nitobi.form.Control
 */
nitobi.grid.Column.prototype.getEditor = function()
{
	return nitobi.form.ControlFactory.instance.getEditor(this.grid, this);
}

/**
 * @private
 */
nitobi.grid.Column.prototype.xGET = function()
{
	var node = null, xpath = "@"+arguments[0], val = "";
	var cachedNode = this.modelNodes[xpath];
	if (cachedNode!=null)
		node = cachedNode;
	else
		node = this.modelNodes[xpath] = this.getModel().selectSingleNode(xpath);

	if (node!=null)
		val = node.nodeValue;
	return val;
}
// TODO: Make the column getters / setters more like the grid getters/setters
/**
 * @private
 */
nitobi.grid.Column.prototype.xSET = function()
{
	var node = this.getModel();
	if (node!=null) {
		node.setAttribute(arguments[0],arguments[1][0]);
	}
}
/**
 * @private
 */
nitobi.grid.Column.prototype.xbSETMODEL = function()
{
	var node = this.getModel();
	if (node!=null) {
		node.setAttribute(arguments[0],nitobi.lang.boolToStr(arguments[1][0]));
	}
}
/**
 * @private
 */
nitobi.grid.Column.prototype.eSET = function(name, arguments)
{
	var oFunction = arguments[0];
	var funcRef = oFunction;

	var subName = name.substr(2);
	subName = subName.substr(0,subName.length-5);

	// TODO: this should look like eSET in Grid.
	if (typeof(oFunction) == 'string')
	{
		funcRef = function(eventArgs) {return eval(oFunction)};
	}

	if (typeof(this[name]) != 'undefined')
	{
		alert('unsubscribe');
		this.unsubscribe(subName, this[name]);
	}

	// name should be OnCellClickEvent but we just expect CellClick for firing
	var guid = this.subscribe(subName,funcRef);
	this.jSET(name, [guid]);
}
/**
 * @private
 */
nitobi.grid.Column.prototype.jSET = function(name, val)
{
	this[name] = val[0];
}

/**
 * @private
 */
nitobi.grid.Column.prototype.fire = function(evt,args)
{
	return nitobi.event.notify(evt+this.uid,args);
}

/**
 * @private
 */
nitobi.grid.Column.prototype.subscribe = function(evt,func,context)
{
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid, nitobi.lang.close(context, func));
}

/**
 * @private
 */
nitobi.grid.Column.prototype.unsubscribe = function(evt,func)
{
	return nitobi.event.unsubscribe(evt+this.uid, func);
}

/**
 * Returns the column header element for a given Grid and column index.
 * @private
 * @param {nitobi.grid.Grid} grid
 * @param {Number} column
 * @type HtmlElement
 */
nitobi.grid.Column.getColumnHeaderElement = function(grid, column)
{
	return $ntb('columnheader_'+column+'_'+grid.uid);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a ColumnEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with columns (e.g onheaderclickevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onheaderclickevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of CellEventArgs to be passed to our handler.
 * 	var column = event.getColumn();
 * 	column.getDomNode().style.backgroundColor = "red";
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that received focus.
 */
nitobi.grid.ColumnEventArgs = function(source, column)
{
	/**
	 * @private
	 */
	this.grid = source;
	/**
	 * @private
	 */
	this.column = column;
	/**
	 * @private
	 */
	this.event = nitobi.html.Event;
}

/**
 * Gets the Grid that fired the event.
 * @type nitobi.grid.Grid
 */
nitobi.grid.ColumnEventArgs.prototype.getSource = function()
{
	return this.grid;
}
/**
 * Gets the Cell on which the event was fired.
 * @type nitobi.grid.Cell
 */
nitobi.grid.ColumnEventArgs.prototype.getColumn = function()
{
	return this.column;
}
/**
 * Gets the native browser Event object that is associated with the event. 
 * This may be null in some cases.
 * @type nitobi.html.Event
 */
nitobi.grid.ColumnEventArgs.prototype.getEvent = function()
{
	return this.event;
}
/**
 * Returns the direction that the column has been sorted in ("Asc" or "Desc").  
 * Is only available for onbeforesortevent and onaftersortevent.
 * @type String
 */
nitobi.grid.ColumnEventArgs.prototype.getDirection = function()
{
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// TODO: This needs to be merged with gridresizer to create a resize baseclass.

/**
 * @class
 * @private
 */
nitobi.grid.ColumnResizer = function(grid)
{
	this.grid = grid;

	/**
	 * The CSS class for the horizontal scrollbar range.
	 */
	this.hScrollClass = null;

	/**
	 * The line is the vertical resize line that the user sees.
	 * @private
	 * @type object
	 */

	this.grid_id = this.grid.UiContainer.parentid

	this.line = document.getElementById("ntb-column-resizeline" + this.grid.uid);
	
	this.lineStyle = this.line.style;
	if (nitobi.browser.IE)
	{
		/**
		 * The surface here is slipped underneath the 
		 * resize line to provide a smooth drag surface. Otherwise
		 * IE hooks on other tags. A little trick. The opacity is set to 1
		 * because if the bg is set to transparent, IE treats the element like 
		 * its not there.
		 * @private
		 * @type object
		 */
		this.surface = document.getElementById("ebagridresizesurface_");
		if (this.surface == null)
		{
			this.surface = document.createElement("div");
			this.surface.id = "ebagridresizesurface_";
			this.surface.className = "ntb-column-resize-surface";
			this.grid.UiContainer.appendChild(this.surface);		
		}
	}

	/**
	 * The index of the column that is being resized.
	 * @type Integer
	 */
	this.column;

	/**
	 * @private
	 * Event that fires after the resize of the column is complete.
	 */
	this.onAfterResize = new nitobi.base.Event();
}

nitobi.grid.ColumnResizer.prototype.startResize = function(grid, column, columnHeaderElement, evt)
{
	// TODO: This should be in the ctor but not avail from some objects.
	this.grid = grid;
	this.column = column;

	var x = nitobi.html.getEventCoords(evt).x;

	//	TODO: encapsulate this sort of mouse position calculation stuff in a cross browser lib
	// Calculate the current mouse position.
	if (nitobi.browser.IE) 
	{
		this.surface.style.display="block";
		nitobi.drawing.align(this.surface,this.grid.element,nitobi.drawing.align.SAMEHEIGHT | nitobi.drawing.align.SAMEWIDTH | nitobi.drawing.align.ALIGNTOP | nitobi.drawing.align.ALIGNLEFT);
//		this.surface.style.width = this.grid.getWidth() + "px";
//		this.surface.style.height = this.grid.getHeight() + "px";
  	}

  	this.x = x;

	// First make the resize line visible
	this.lineStyle.display = "block";

	// The div containing the resize line is a child of the grid's html, not the body
	// so we need to offset the position of the resize line by the Grid's x coord.
	var gridLeft = nitobi.html.getBoundingClientRect(this.grid.UiContainer).left;
	this.lineStyle.left = x - gridLeft + "px";

 	// Fit the line in the viewable area. 26 for the scrollbar
	this.lineStyle.height = this.grid.Scroller.scrollSurface.offsetHeight + "px";	

  	// Align the resize line to the column header element.
  	nitobi.drawing.align(this.line,columnHeaderElement,nitobi.drawing.align.ALIGNTOP,0,0,nitobi.html.getHeight(columnHeaderElement) + 1);

	nitobi.ui.startDragOperation(this.line, evt, false, true, this, this.endResize);
}

nitobi.grid.ColumnResizer.prototype.endResize = function(dragStopEventArgs)
{
	var x = dragStopEventArgs.x;
	var Y = dragStopEventArgs.y;

	if (nitobi.browser.IE)
	{
		this.surface.style.display="none";
	}

	var ls = this.lineStyle;
	ls.display="none";
	ls.top="-3000px";
	ls.left="-3000px";

	// dx is the difference between the start and end x coordinates
	this.dx = x - this.x;

	this.onAfterResize.notify(this);
}

nitobi.grid.ColumnResizer.prototype.dispose = function()
{
	this.grid = null;
	this.line = null;
	this.lineStyle = null;
	this.surface = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Responsible for doing grid resize animation.
 * @private
 */
nitobi.grid.GridResizer = function(grid)
{
	this.grid = grid;

	this.widthFixed = false;
	this.heightFixed = false;

	this.minHeight = 0;
	this.minWidth = 0;

	this.box = document.getElementById("ntb-grid-resizebox" + grid.uid);

	/**
	 * @private
	 * Event that fires after the resize of the object is complete.
	 */
	this.onAfterResize = new nitobi.base.Event();
}

/**
 * @private
 */
nitobi.grid.GridResizer.prototype.startResize = function(grid, event)
{
	this.grid = grid;

	var beforeGridResizeEventArgs = null; //new nitobi.grid.OnBeforeGridResizeEventArgs(this.grid);

// TODO: before grid resize event ...
//	if (!nitobi.event.evaluate(column.getOnBeforeGridResizeEvent(), beforeGridResizeEventArgs))
//	{
//		return;
//	}

	var x,y;

	var coords = nitobi.html.getEventCoords(event);
	x = coords.x;
	y = coords.y;

  	this.x = x;
  	this.y = y;

	var w = grid.getWidth();
	var h = grid.getHeight();
	
	var L = grid.element.offsetLeft;
	var T = grid.element.offsetTop;

	this.resizeW=!this.widthFixed;
	this.resizeH=!this.heightFixed;
	
	if (this.resizeW || this.resizeH) {
		this.box.style.cursor=(this.resizeW && this.resizeH)?"nw-resize":(this.resizeW)?"w-resize":"n-resize"
		this.box.style.display = "block";
//		this.box.style.width=(x-L) + "px";
//		this.box.style.height=(y-T) + "px";
		var alignment = nitobi.drawing.align.SAMEWIDTH | nitobi.drawing.align.SAMEHEIGHT | nitobi.drawing.align.ALIGNTOP | nitobi.drawing.align.ALIGNLEFT;
		nitobi.drawing.align(this.box,this.grid.element,alignment,0,0,0,0,false);
		
		this.dd = new nitobi.ui.DragDrop(this.box, false, false);
		this.dd.onDragStop.subscribe(this.endResize, this);
		this.dd.onMouseMove.subscribe(this.resize, this);
		this.dd.startDrag(event);
	}
}

/**
 * @private
 */
nitobi.grid.GridResizer.prototype.resize = function()
{
	var x = this.dd.x;
	var y = this.dd.y;

	var rect = nitobi.html.getBoundingClientRect(this.grid.UiContainer);
	var L = rect.left;
	var T = rect.top;

	this.box.style.display = "block";
	if ((x-L) > this.minWidth) this.box.style.width=(x-L) + "px";
	if ((y-T) > this.minHeight) this.box.style.height=(y-T) + "px";
}

/**
 * @private
 */
nitobi.grid.GridResizer.prototype.endResize = function()
{
	var x = this.dd.x;
	var y = this.dd.y;

	this.box.style.display = "none";
	var prevWidth = this.grid.getWidth();
	var prevHeight = this.grid.getHeight();
	this.newWidth = Math.max(parseInt(prevWidth) + (x - this.x), this.minWidth);
	this.newHeight = Math.max(parseInt(prevHeight) + (y - this.y), this.minHeight);
	if (isNaN(this.newWidth) || isNaN(this.newHeight))
		return;

	this.onAfterResize.notify(this)
}

/**
 * @private
 */
nitobi.grid.GridResizer.prototype.dispose = function()
{
	this.grid = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class This class is responsible for converting data formats used in nitobi.data.FormatConverterr
 */
nitobi.data.FormatConverter = {};

/**
 * Builds a well formed UTF-8 eba XML document based on the input parameters.  Extra column data will be truncated.
 * @param {String} htmlTable - A set of data that is formated in TABLE, TR, TD HTML elements.
 * @param {Array} columns - a set of contigious columns that describe the table data
 * @startRow {int} the first zero-based row to add to the table results.  
 * @return {xmlDoc}correctly formated well formed eba xml based on paramters.  Extra column data will be truncated.   
 *
 * For now merged table data are out of scope. The eba xml created will only have attributes for columns that are in column param and has a column in the table.  The eba xml created will not have an datasourcestructure tag
 */
nitobi.data.FormatConverter.convertHtmlTableToEbaXml = function(htmlTable, columns, startRow)
{
	var s='<xsl:stylesheet version="1.0" xmlns:ntb="http://www.nitobi.com" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output encoding="UTF-8" method="xml" omit-xml-declaration="no" />';
	s+='<xsl:template match="//TABLE"><ntb:data id="_default">';
    s+='<xsl:apply-templates /></ntb:data> </xsl:template>';
   	s+='<xsl:template match = "//TR">  <xsl:element name="ntb:e"> <xsl:attribute name="xi"><xsl:value-of select="position()-1+' + parseInt(startRow) + '"/></xsl:attribute>';	
	for (var index=0; index < columns.length; index++) 
	{
		s+='<xsl:attribute name="'+ columns[index] + '\" ><xsl:value-of select="TD['+parseInt(index+1)+']"/></xsl:attribute>';
	}
	s+='</xsl:element></xsl:template>';
	s+='</xsl:stylesheet>';

	var tableDataXmlDoc = nitobi.xml.createXmlDoc(htmlTable);
	var xsltProcessor 	= nitobi.xml.createXslProcessor(s);
	var result = nitobi.xml.transformToXml(tableDataXmlDoc, xsltProcessor);
	return result;
}

/**
 * Builds a valid well formed UTF-8 XML document based on the input parameters.  Extra column data will be truncated.
 * @note For now lookup fields are out of scope
 * @param tsv {String}- tab seperated list of data to be converted to EBA xml
 * @param columns {Array} - a set of contigious columns that describe the table data
 * @startRow {int} the first zero-based row to add to the table results.  
 * @return {xmlDoc}correctly formated well formed eba xml based on paramters.  Extra column data will be truncated.   
 */
nitobi.data.FormatConverter.convertTsvToEbaXml = function(tsv, columns, startRow)
{
	if (!nitobi.browser.IE && tsv[tsv.length-1]!="\n") {
		tsv =tsv+'\n';
	}
	var htmlTableFormattedData = "<TABLE><TBODY>"
	+tsv.replace(/[\&\r]/g,"")
   .replace(/([^\t\n]*)[\t]/g,"<TD>$1</TD>")
   .replace(/([^\n]*?)\n/g,"<TR>$1</TR>")
   .replace(/\>([^\<]*)\<\/TR/g,"><TD>$1</TD></TR")+"</TBODY></TABLE>";

	// This will handle single-cell paste.
	if (htmlTableFormattedData.indexOf("<TBODY><TR>") == -1)
	{
		htmlTableFormattedData = htmlTableFormattedData.replace(/TBODY\>(.*)\<\/TBODY/,"TBODY><TR><TD>$1</TD></TR></TBODY");
	}

	return nitobi.data.FormatConverter.convertHtmlTableToEbaXml(htmlTableFormattedData, columns, startRow);
}


/**
 * Builds 2*2 JavaScript array from the tab separated data. Extra column data will be truncated.
 * @param tsv {String}- tab seperated list of data to be converted to EBA xml
 * @param columns {Array} - a set of contigious columns that describe the table data
 * @startRow {int} the first zero-based row to add to the table results.  
 * @return {xmlDoc}correctly formated well formed eba xml based on paramters.  Extra column data will be truncated.   
 */
nitobi.data.FormatConverter.convertTsvToJs = function(tsv)
{
	var jsFormattedData = "["
	+tsv.replace(/[\&\r]/g,"")
	.replace(/([^\t\n]*)[\t]/g,"$1\",\"")
	.replace(/([^\n]*?)\n/g,"[\"$1\"],") + "]";

	return jsFormattedData;
}


/**
 * Builds a data set that is formatted using HTML Elements TABLE, TR, TD based on the parameters. 
 * A best effort will be made to add the correct data.  
 * For now lookup fields are out of scope
 *
 * @param ebaXmlDocument {xmlDoc} the set of data from the grid (do we need a grid id?)
 * @param columns {Array} a array of columns to be added to the table
 * @param startRow {int}  the first zero-based row to be added to the table results.  
 * @param endRow {int}    the last zero-based row to be added to the table results.  
 * @return {String} well formed HTML table with UTF-8 encocding
 */
nitobi.data.FormatConverter.convertEbaXmlToHtmlTable = function(ebaXmlDocument, columns, startRow, endRow)
{
	var s='<xsl:stylesheet version="1.0" xmlns:ntb="http://www.nitobi.com" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output encoding="UTF-8" method="html" omit-xml-declaration="yes" /><xsl:template match = "*"><xsl:apply-templates /></xsl:template><xsl:template match = "/">';
	s+='<TABLE><TBODY><xsl:for-each select="//ntb:e[@xi>' + parseInt(startRow - 1) + ' and @xi &lt; ' + parseInt(endRow + 1) + ']" ><TR>';
	for (var index=0; index < columns.length; index++) 
	{
		s+='<TD><xsl:value-of select=\"@' + columns[index] + '\" /></TD>';
	}
	s+='</TR></xsl:for-each></TBODY></TABLE></xsl:template></xsl:stylesheet>'

	var xsltProcessor = nitobi.xml.createXslProcessor(s);
    return nitobi.xml.transformToXml(ebaXmlDocument, xsltProcessor).xml.replace(/xmlns:ntb="http:\/\/www.nitobi.com"/,"");
}

nitobi.data.FormatConverter.convertEbaXmlToTsv = function(ebaXmlDocument, columns, startRow, endRow)
{
	var s='<xsl:stylesheet version="1.0" xmlns:ntb="http://www.nitobi.com" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output encoding="UTF-8" method="text" omit-xml-declaration="yes" /><xsl:template match = "*"><xsl:apply-templates /></xsl:template><xsl:template match = "/">';
	s+='<xsl:for-each select="//ntb:e[@xi>' + parseInt(startRow - 1) + ' and @xi &lt; ' + parseInt(endRow + 1) + ']" >\n';
	for (var index=0; index < columns.length; index++) 
	{
		s+='<xsl:value-of select=\"@' + columns[index] + '\" />';
		if (index < columns.length-1)
		{
			s+='<xsl:text>&#x09;</xsl:text>';
		}
	}
	s+='<xsl:text>&#xa;</xsl:text></xsl:for-each></xsl:template></xsl:stylesheet>'

	var xsltProcessor = nitobi.xml.createXslProcessor(s);
    return nitobi.xml.transformToString(ebaXmlDocument, xsltProcessor).replace(/xmlns:ntb="http:\/\/www.nitobi.com"/,"");
}

/*
 * Returns the number of columns in some TSV or TABLE based data.
 */
nitobi.data.FormatConverter.getDataColumns = function(data)
{
	var retVal = 0;
	if (data != null && data != '')
	{
		if (data.substr(0,1) == '<')
		{
			retVal = data.toLowerCase().substr(0, data.toLowerCase().indexOf('</tr>')).split('</td>').length-1;
		}
		else
		{
			retVal = data.substr(0, data.indexOf('\n')).split('\t').length;
		}
	}
	else
	{
		retVal = 0;
	}
	return retVal;
}

/*
 * Returns the number of rows in some TSV or TABLE based data.
 */
nitobi.data.FormatConverter.getDataRows = function(data)
{
	var retVal = 0;
	if (data != null && data != '')
	{
		if (data.substr(0,1) == '<')
		{
			retVal = data.toLowerCase().split('</tr>').length-1;
		}
		else
		{
			retValArray = data.split('\n');
			retVal = retValArray.length;
			if (retValArray[retValArray.length-1] == "")
			{
				retVal--;
			}
		}
	}
	else
	{
		retVal = 0;
	}
	return retVal;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a DateColumn.
 * @class A column type used by the Nitobi Grid component to handle date input.
 * @constructor
 * @extends nitobi.grid.Column
 * @param {nitobi.grid.Grid} grid The grid that this column belongs to
 * @param {Number} column The index of the column (zero based)
 */
nitobi.grid.DateColumn = function(grid, column)
{
	//	Call the base constructor
	nitobi.grid.DateColumn.baseConstructor.call(this, grid, column);
}

nitobi.lang.extend(nitobi.grid.DateColumn, nitobi.grid.Column);

var ntb_datep = nitobi.grid.DateColumn.prototype;
/**
 * Sets the mask for the date column.
 * @param {String} value The value to use as the mask
 */
nitobi.grid.DateColumn.prototype.setMask=function(){this.xSET("Mask",arguments);}
/**
 * Returns the mask currently being used by the date column.
 * @type String
 */
nitobi.grid.DateColumn.prototype.getMask=function(){return this.xGET("Mask",arguments);}
/**
 * Sets whether or not to show a calendar when editing a cell in the date column.
 * @param {Boolean} value True to enable the calendar, false otherwise.
 */
nitobi.grid.DateColumn.prototype.setCalendarEnabled=function(){this.xSET("CalendarEnabled",arguments);}
/**
 * Returns true if the calendar is enabled, false otherwise.
 * @type Boolean
 */
nitobi.grid.DateColumn.prototype.isCalendarEnabled=function(){return nitobi.lang.toBool(this.xGET("CalendarEnabled",arguments), false);}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.grid.Declaration");

nitobi.grid.Declaration.parse = function(element)
{
	// We require that the object expando property on the DOM node refers to the JS object.
//	element.jsObject=this;
	
//	this.element = element;

	var Declaration = {};

	Declaration.grid = nitobi.xml.parseHtml(element);

	ntbAssert(!nitobi.xml.hasParseError(Declaration.grid),'The framework was not able to parse the declaration.\n' + '\n\nThe parse error was: ' + nitobi.xml.getParseErrorReason(Declaration.grid) + 'The declaration contents where:\n' + nitobi.html.getOuterHtml(element),'',EBA_THROW);

	var oNode = element.firstChild;

	while (oNode != null)
	{
		if (typeof(oNode.tagName) != 'undefined')
		{
			var tag = oNode.tagName.replace(/ntb\:/gi,'').toLowerCase();
			if (tag == "inlinehtml")
			{
				Declaration[tag] = oNode;
			}
			else
			{
				var ebans="http://www.nitobi.com"; // This string shouldn't be hard-coded
				if (tag == "columndefinition")
				{
					//ntbAssert(false, 'Using EBA Grid V2.8 declaration', '', EBA_DEBUG);

					var sXml;
					if (nitobi.browser.IE) {
						sXml = ('<'+nitobi.xml.nsPrefix+'grid xmlns:ntb="'+ebans+'"><'+nitobi.xml.nsPrefix+'columns>'+oNode.parentNode.innerHTML.substring(31).replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")+'</'+nitobi.xml.nsPrefix+'columns></'+nitobi.xml.nsPrefix+'grid>');
					}
					else
					{
						//	TODO: Need to check that we don't have nested tags here due to Mozilla not liking unclosed tags
						sXml = '<'+nitobi.xml.nsPrefix+'grid xmlns:ntb="'+ebans+'"><'+nitobi.xml.nsPrefix+'columns>'+oNode.parentNode.innerHTML.replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")+'</'+nitobi.xml.nsPrefix+'columns></'+nitobi.xml.nsPrefix+'grid>';
					}

					sXml = sXml.replace(/\&nbsp\;/gi,' ');

					Declaration['columndefinitions'] = nitobi.xml.createXmlDoc();
					Declaration['columndefinitions'].validateOnParse=false;
					Declaration['columndefinitions'] = nitobi.xml.loadXml(Declaration['columndefinitions'], sXml);
					break;
				} 
				else
				{
					Declaration[tag] = nitobi.xml.parseHtml(oNode);
/*
					if (nitobi.browser.IE) {
						Declaration[tag] = nitobi.xml.createXmlDoc();
						Declaration[tag].validateOnParse=false;
						var sXml = oNode.outerHTML.replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")
						sXml = sXml.substring(sXml.indexOf('/>')+2).replace(/\>/,' xmlns:ntb="'+ebans+'" >');
						Declaration[tag] = nitobi.xml.loadXml(Declaration[tag], sXml);
					} else {
						//	Added on .replace(/\n/g,'') to get rid of any new line characters which are of course nodes in Firefox xml
						//oNode.innerHTML.replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")
						Declaration[tag] = nitobi.xml.createXmlDoc(('<'+nitobi.xml.nsPrefix+tag+' xmlns:ntb="'+ebans+'">'+oNode.innerHTML.replace(/\n/g,'')+'</'+nitobi.xml.nsPrefix+tag+'>').replace(/\>\s*\</gi,'><'))
					}
*/
				}
			}
		}

		oNode = oNode.nextSibling;
	}

	return Declaration;
}


nitobi.grid.Declaration.loadDataSources = function(xDeclaration, grid)
{
	var declarationDatasources = new Array();
	if (xDeclaration["datasources"])
	{
		declarationDatasources = xDeclaration.datasources.selectNodes("//"+nitobi.xml.nsPrefix+"datasources/*");
	}
	if (declarationDatasources.length > 0)
	{
		for (var i = 0; i < declarationDatasources.length; i++)
		{
			var id = declarationDatasources[i].getAttribute('id');
			if (id != "_default")
			{
				var sData = declarationDatasources[i].xml.replace(/fieldnames=/g,"FieldNames=").replace(/keys=/g,"Keys=");
	
				sData = '<ntb:grid xmlns:ntb="http://www.nitobi.com"><ntb:datasources>'+sData+'</ntb:datasources></ntb:grid>'
				var newDataTable = new nitobi.data.DataTable('local',grid.getPagingMode() != nitobi.grid.PAGINGMODE_NONE,{GridId:grid.getID()},{GridId:grid.getID()},grid.isAutoKeyEnabled());
				newDataTable.initialize(id, sData);
				newDataTable.initializeXml(sData);
				grid.data.add(newDataTable);
				
				// The datasource we have loaded could be that of the Grid as well ...
				var columns = grid.model.selectNodes("//nitobi.grid.Column[@DatasourceId='"+id+"']");
				for (var j = 0; j < columns.length; j++)
				{
					//	Now that we have created the datasource we need to set the ValueField and DisplayFields etc
					grid.editorDataReady(columns[j]);
				}
			}
		}
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.grid");

/**
 * Constructs a EditCompleteEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * EditCompleteEventArgs is the single parameter passed to the 
 * EditComplete handler of the Editor.
 * @constructor
 * @private 
 */
nitobi.grid.EditCompleteEventArgs = function(obj, display, store, cell)
{
	this.editor = obj;
	this.cell = cell;
	this.databaseValue = store;
	this.displayValue = display;
}

nitobi.grid.EditCompleteEventArgs.prototype.dispose = function()
{
	this.editor = null;
	this.cell = null;
	this.metadata = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.data.GetCompleteEventArgs = function(firstRow, lastRow, startXi, pageSize, ajaxCallback, dataTable, obj, callback, numRowsReturned)
	{
		//	This is the first row to be rendered by the RowRenderer
		this.firstRow = firstRow;
		//	This is the last row to be rendered by the RowRenderer
		this.lastRow = lastRow;
		//	This is the callback to be called once the data is all ready
		this.callback = callback;
		//	This is the datatable on which the get was requested
		this.dataSource = dataTable;
		//	This is the context (ie the object) of the callback method
		this.context = obj;
		//	This is the nitobi.ajax.HttpRequest object handling the request
		this.ajaxCallback = ajaxCallback;
		//	This is the xi of the first record that is returned such that we can integrate returned data that has no xi values
		this.startXi = startXi;
		this.pageSize = pageSize;
		/**
		 * True if the request page was the last page.
		 */
		this.lastPage=false;
		/**
		 * The number of rows returned by the get request.
		 */
		this.numRowsReturned = numRowsReturned;
		/**
		 * The lastRowReturned is updated by the DataTable when the data is returned if it is not the expected lastRow.
		 */
		 this.lastRowReturned = lastRow;
	}


nitobi.data.GetCompleteEventArgs.prototype.dispose = function()
{
	this.callback = null;
	this.context = null;
	this.dataSource = null;
  	this.ajaxCallback.clear();
	this.ajaxCallback == null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.grid");

/**
 * @ignore
 */
nitobi.grid.MODE_STANDARDPAGING = 'standard';
/**
 * @ignore
 */
nitobi.grid.MODE_LOCALSTANDARDPAGING = 'localstandard';
/**
 * @ignore
 */
nitobi.grid.MODE_LIVESCROLLING = 'livescrolling';
/**
 * @ignore
 */
nitobi.grid.MODE_LOCALLIVESCROLLING = 'locallivescrolling';
/**
 * @ignore
 */
nitobi.grid.MODE_NONPAGING = 'nonpaging';
/**
 * @ignore
 */
nitobi.grid.MODE_LOCALNONPAGING = 'localnonpaging';
/**
 * @ignore
 */
nitobi.grid.MODE_PAGEDLIVESCROLLING = 'pagedlivescrolling';
/**
 * @ignore
 */
nitobi.grid.RENDERMODE_ONDEMAND = 'ondemand';



nitobi.lang.defineNs("nitobi.GridFactory")

/**
 * @ignore
 * @private
 */
nitobi.GridFactory.createGrid = function(sMode,dContainer,element)
{
	var sPagingMode = '';
	var sDataMode = '';
	var sRenderMode = '';

	element = nitobi.html.getElement(element);
	// First check if w have either an element or a declaration to instantiate from.
	if (element != null)
	{
		xDeclaration = nitobi.grid.Declaration.parse(element);
		sMode = xDeclaration.grid.documentElement.getAttribute('mode').toLowerCase();

		var bGetHandler = nitobi.GridFactory.isGetHandler(xDeclaration);
		var bDatasourceId = nitobi.GridFactory.isDatasourceId(xDeclaration);
		var bHitOnce = false;

		if (sMode == nitobi.grid.MODE_LOCALLIVESCROLLING)
		{
			ntbAssert(bDatasourceId || bGetHandler,'To use local LiveScrolling mode a DatasourceId must also be specified.','',EBA_THROW);

			sPagingMode = nitobi.grid.PAGINGMODE_LIVESCROLLING;
			sDataMode = nitobi.data.DATAMODE_LOCAL;
		}
		else if (sMode == nitobi.grid.MODE_LIVESCROLLING)
		{			
			ntbAssert(bGetHandler,'To use LiveScrolling mode a GetHandler must also be specified.','',EBA_THROW);

			sPagingMode = nitobi.grid.PAGINGMODE_LIVESCROLLING;
			sDataMode = nitobi.data.DATAMODE_CACHING;
		}
		else if (sMode == nitobi.grid.MODE_NONPAGING)
		{
			ntbAssert(bGetHandler,'To use NonPaging mode a GetHandler must also be specified.','',EBA_THROW);

			bHitOnce = true;

			sPagingMode = nitobi.grid.PAGINGMODE_NONE;
			// Although we are using remote non-paging we set the datamode to be local.
			// TODO: This mode needs to be looked at - we have an off-by-one problem with the last row.
			sDataMode = nitobi.data.DATAMODE_LOCAL;
		}
		else if (sMode == nitobi.grid.MODE_LOCALNONPAGING)
		{
			ntbAssert(bDatasourceId,'To use local LiveScrolling mode a DatasourceId must also be specified.','',EBA_THROW);

			sPagingMode = nitobi.grid.PAGINGMODE_NONE;
			sDataMode = nitobi.data.DATAMODE_LOCAL;
		}
		else if (sMode == nitobi.grid.MODE_LOCALSTANDARDPAGING)
		{
			sPagingMode = nitobi.grid.PAGINGMODE_STANDARD;
			sDataMode = nitobi.data.DATAMODE_LOCAL;
		}
		else if (sMode == nitobi.grid.MODE_STANDARDPAGING)
		{
			sPagingMode = nitobi.grid.PAGINGMODE_STANDARD;
			sDataMode = nitobi.data.DATAMODE_PAGING;
		}
		else if (sMode == nitobi.grid.MODE_PAGEDLIVESCROLLING)
		{
			sPagingMode = nitobi.grid.PAGINGMODE_STANDARD;
			sDataMode = nitobi.data.DATAMODE_PAGING;
			sRenderMode = nitobi.grid.RENDERMODE_ONDEMAND;
		}
		else
		{
			//ntbAssert(false,'No mode found for your Grid.','',EBA_WARN);
		}
	}

	var id = element.getAttribute("id");

	sMode = (sMode || nitobi.grid.MODE_STANDARDPAGING).toLowerCase();
	var grid = null;
	if (sMode == nitobi.grid.MODE_LOCALSTANDARDPAGING) {
		grid = new nitobi.grid.GridLocalPage(id);
	}
	else if (sMode == nitobi.grid.MODE_LIVESCROLLING) {
		grid = new nitobi.grid.GridLiveScrolling(id);
	}
	else if (sMode == nitobi.grid.MODE_LOCALLIVESCROLLING) {
		grid = new nitobi.grid.GridLiveScrolling(id);
	}
	else if (sMode == nitobi.grid.MODE_NONPAGING || sMode == nitobi.grid.MODE_LOCALNONPAGING) {
		grid = new nitobi.grid.GridNonpaging(id);
	}
	else if (sMode == nitobi.grid.MODE_STANDARDPAGING || sMode == nitobi.grid.MODE_PAGEDLIVESCROLLING) {
		grid = new nitobi.grid.GridStandard(id);
	}

//nitobi.debug.PerfMon.registerAll(grid);

	grid.setPagingMode(sPagingMode);
	grid.setDataMode(sDataMode);
	grid.setRenderMode(sRenderMode);
	nitobi.GridFactory.processDeclaration(grid, element, xDeclaration);

	element.jsObject = grid;
	return grid;
}

/**
 * @ignore
 * @private
 */
nitobi.GridFactory.processDeclaration = function(grid, element, xDeclaration)
{	
	if (xDeclaration != null)
	{
		grid.setDeclaration(xDeclaration);		
		if (typeof(xDeclaration.inlinehtml) == "undefined")
		{
			var inlinehtmlElement = document.createElement("ntb:inlinehtml");
			// TODO: Convert to this.getUniqueId();
			inlinehtmlElement.setAttribute("parentid", "grid"+grid.uid);
			nitobi.html.insertAdjacentElement(element,"beforeEnd", inlinehtmlElement);
			grid.Declaration.inlinehtml = inlinehtmlElement;
		}

		// First thing is to create a new dataset for the grid
		// iff there is not one already defined with tables.
		if (this.data == null || this.data.tables == null || this.data.tables.length == 0)
		{
			var oDataSet = new nitobi.data.DataSet();
			oDataSet.initialize();
			grid.connectToDataSet(oDataSet);
		}

		grid.initializeModelFromDeclaration();
		
		// Get the column definitions from an old or new declaration.
		var columnDefinitions = grid.Declaration.columndefinitions || grid.Declaration.columns;
	
		// Define the grid columns based on the declaration - if there are columns in the declaration
		// This will set all default values in the model and moved values from the declaration to the model.
		// Don't use this if the columns tag is empty.
		if (typeof(columnDefinitions) != "undefined" && columnDefinitions!=null && columnDefinitions.childNodes.length !=0 && columnDefinitions.childNodes[0].childNodes.length != 0)
		{
			
			grid.defineColumns(columnDefinitions.documentElement);
		}

		// Attaches the grid to the inlinehtml element inside the grid element.
		// This causes the initalize method to be fired.
		//grid.attachToParentDomElement(grid.Declaration.inlinehtml);
	
		nitobi.grid.Declaration.loadDataSources(xDeclaration, grid);

		grid.attachToParentDomElement(grid.Declaration.inlinehtml);

		var sDataMode = grid.getDataMode();
		var sDatasourceId = grid.getDatasourceId();
		var sGetHandler = grid.getGetHandler();

		// is this done in ensureConnected???
		if (sDatasourceId != null && sDatasourceId != '')
		{
			// This means we have a local grid ... 
			// A local grid could be paging, caching or nonpaging ...
			// This way, we can initialize the data in the grid to our local data
			// We take advantage of the caching stuff rather than doing anything wacky.		
			grid.connectToTable(grid.data.getTable(sDatasourceId));
			
		}
		else
		{
			grid.ensureConnected();
			
			// If this is livescrolling, and we have rows in the decl, put them in the datasource.
			if (grid.mode.toLowerCase() == nitobi.grid.MODE_LIVESCROLLING && xDeclaration != null && xDeclaration.datasources != null)
			{
				var numRows = xDeclaration.datasources.selectNodes("//ntb:datasource[@id='_default']/ntb:data/ntb:e").length;
				if (numRows > 0)
				{
					var table = grid.data.getTable("_default");
					table.initializeXmlData(xDeclaration.grid.xml);
					table.initializeXml(xDeclaration.grid.xml);
					// TODO: This is a little hack to make this work. Needs to factored into the datatable.
					table.descriptor.leap(0,numRows*2);
					table.syncRowCount();
				}
			}
		}

		window.setTimeout(function(){grid.bind()},50);
	}
}

/**
 * @ignore
 * @private
 */
nitobi.GridFactory.isLocal = function (xDeclaration)
{
	var sDatasourceId = xDeclaration.grid.documentElement.getAttribute('datasourceid');
	var sGetHandler = xDeclaration.grid.documentElement.getAttribute('gethandler');

	if (sGetHandler != null && sGetHandler != '')
	{
		return false;
	}
	else if (sDatasourceId != null && sDatasourceId != '')
	{
		return true;
	}
	else
	{
		throw('Non-paging grid requires either a gethandler or a local datasourceid to be specified.');
	}
}

/**
 * @ignore
 * @private
 */
nitobi.GridFactory.isGetHandler = function(xDeclaration)
{
	var sGetHandler = xDeclaration.grid.documentElement.getAttribute('gethandler');
	if (sGetHandler != null && sGetHandler != '')
		return true;
	return false;
}

/**
 * @ignore
 * @private
 */
nitobi.GridFactory.isDatasourceId = function(xDeclaration)
{
	var sDatasourceId = xDeclaration.grid.documentElement.getAttribute('datasourceid');
	if (sDatasourceId != null && sDatasourceId != '')
		return true;
	return false;
}

/**
 * @ignore
 * @private
 */
nitobi.grid.hover = function(domNode,hover,rowHover)
{
	if (!rowHover) 
	{
		return;
	}
	//	TODO: this should be using the global methods in nitobi.grid.Cell to determing row, column and uid from a cell domNode
	// Determine panel
	var id = domNode.getAttribute("id");
	var tmpid = id.replace(/__/g,"||");
	var coord = tmpid.split("_");
	var row = coord[3];
	var uid = coord[5].replace(/\|\|/g,"__");

	// Cheezy way of doing this ... but should be fast...
	var leftCell = document.getElementById("cell_"+row+"_0_"+uid);
	var leftRowNode = leftCell.parentNode;
	var cellz = leftRowNode.childNodes[leftRowNode.childNodes.length-1];

	var id = cellz.getAttribute("id");
	var coord = id.split("_");
	var midCell = document.getElementById("cell_"+row+"_"+(Number(coord[4])+1)+"_"+uid);
	var midRowNode = null;
	if (midCell != null) {
		midRowNode = midCell.parentNode;
	}
	if (hover) {
		var rowHoverColor = nitobi.grid.RowHoverColor || 'white'
		leftRowNode.style.backgroundColor = rowHoverColor;
		if (midRowNode) {
			midRowNode.style.backgroundColor = rowHoverColor;
		}
	} else {
		leftRowNode.style.backgroundColor = '';
		if (midRowNode) {
			midRowNode.style.backgroundColor = '';
		}
	}
	if (hover) {
		nitobi.html.addClass(domNode,'ntb-cell-hover');//.style.backgroundColor = nitobi.grid.CellHoverColor || 'white';
	} else {
		nitobi.html.removeClass(domNode,'ntb-cell-hover');//.style.backgroundColor = '';
	}
}
/**
 * Reserved for backwards compat.
 * @private
 * @ignore
 */
initEBAGrids = function()
{
	nitobi.initComponents();
}

/**
 * Initializes all Nitobi grids on the page. This should only be called after the page
 * has loaded fully, e.g., in body.onload. Returns an array of the initialized Grid objects.
 * @type {Array}
 */
nitobi.initGrids = function()
{
	var gridObjects = [];
	var grids = document.getElementsByTagName(!nitobi.browser.IE?"ntb:grid":"grid");
	for (var i=0; i<grids.length;i++)
	{
		if (grids[i].jsObject == null) {
			nitobi.initGrid(grids[i].id);
			gridObjects.push(grids[i].jsObject);
		}
	}
	return gridObjects;
}

/**
 * Initializes the Nitobi Grid on the page with the specified HTML element ID. This should only be called after the page
 * has loaded fully, e.g., in body.onload.
 * @param {String} id The ID of the DOM node that is the Grid declaration. It should look like &lt;ntb:grid id="myGrid" ... &gt;
 */
nitobi.initGrid = function(id)
{
	var grid = nitobi.html.getElement(id);
	if (grid != null)
	{
		grid.jsObject = nitobi.GridFactory.createGrid(null,null,grid);
	}
	return grid.jsObject;
}

/**
 * Initializes all Nitobi components on the page.  This should only be called after the page
 * has loaded fully, e.g., in body.onload.
 * @ignore
 */
nitobi.initComponents = function()
{
	nitobi.initGrids();
}


/**
 * Returns the JavaScript object for a Nitobi Grid component. For example, if you have a Grid declared on the page
 * with id=grid1, then calling nitobi.getGrid("grid1") would return the nitobi.grid.Grid object for that
 * grid HTML declaration.
 * @param {String} componentId The id of the component as declared in its tag.
 * @return Object Returns the object of the same type as the component declaration.
 */
nitobi.getGrid = function(sGridId)
{
	return document.getElementById(sGridId).jsObject;
}

nitobi.base.Registry.getInstance().register(
//		new nitobi.base.Profile("nitobi.Grid",null,false,"ntb:grid")
		new nitobi.base.Profile("nitobi.initGrid",null,false,"ntb:grid")
);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a livescrolling Grid.
 * @class A subclass of nitobi.grid.Grid that adds livescrolling fucntionality.  Just-in-time paging as the user scrolls through data. 
 * <p>
 * <b>Fixed Size</b><br/>
 * 	Height of grid specified explicitly<br/>
 * 	Vertical scrollbar allows user to scroll through rendered rows<br/>
 * 	If there are not enough rows to fill the grid, a blank area will be present, the grid will not shrink.
 * </p> 
 * <p>
 * <b>On-Demand Data</b><br/>
 * 	Data in the client-side datasource is a subset of server-side datasource records.<br/>
 * 	The grid renders visible rows present in the client-side datasource that match the specified 
 *  filter criteria.<br/>
 * 	Sorting is performed server-side - client-side data is purged.<br/>
 * 	Grid rows are rendered in multiple render operations (as the user scrolls).<br/>
 * 	Data is loaded on-demand as it is needed. 
 * </p>
 * <p>
 * <b>Virtual Paging</b> (Paging is hidden from user)<br/> 
 * 	Paging operations request data from server if it is not present in the client-side datasource.<br/> 
 * 	Client-side data is kept across paging requests.<br/>
 * 	Rendered rows are kept across paging requests.<br/>
 * </p>
 * @constructor
 * @param {String} uid The unique ID of the Grid.
 * @extends nitobi.grid.Grid
 */
nitobi.grid.GridLiveScrolling = function(uid) {
	nitobi.grid.GridLiveScrolling.baseConstructor.call(this, uid);
	this.mode="livescrolling";
//	this.PagingMode="livescrolling";	//0 - None | 1 - Paging | 2 - LiveScrolling
	this.setPagingMode(nitobi.grid.PAGINGMODE_LIVESCROLLING);
//	this.DataMode="caching";		//0 - Local | 1 - Remote | 2 - Caching
// TODO: ensure that properties with setters are using the setters
	this.setDataMode(nitobi.data.DATAMODE_CACHING);		//0 - Local | 1 - Remote | 2 - Caching
}
nitobi.lang.extend(nitobi.grid.GridLiveScrolling, nitobi.grid.Grid);

/**
 * @private
 */
nitobi.grid.GridLiveScrolling.prototype.createChildren=function() {
	var args = arguments;

	nitobi.grid.GridLiveScrolling.base.createChildren.call(this,args);

	nitobi.grid.GridLiveScrolling.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD);	
}

/**
 * @private
 */
nitobi.grid.GridLiveScrolling.prototype.bind=function() 
{
	nitobi.grid.GridStandard.base.bind.call(this);

	if (this.getGetHandler()!='') {
		this.ensureConnected();
		var rows = this.getRowsPerPage();
		if (this.datatable.mode == 'local')
			rows = null
		this.datatable.get(0, rows, this, this.getComplete);
	} else {
		// TODO: if we have created the datasource and loaded it with data BEFORE connecting to it
		// the rowcount changed events etc will not have propagated to the Grid and so we will
		// have an incorrect row count.
		this.finalizeRowCount(this.datatable.getRemoteRowCount());
		this.bindComplete();
	}
}

//PageUp-PageDown Keys

/**
 * @private
 */
nitobi.grid.GridLiveScrolling.prototype.getComplete=function(evtArgs)
{
	nitobi.grid.GridLiveScrolling.base.getComplete.call(this, evtArgs);

	// No need to set the row count here since dataTable events take care of it.

	// TODO: This is not needed since the connected datatable will fire all the
	// right events on the Grid when it gets the data back.
	if (!this.columnsDefined)
	{
		this.defineColumnsFinalize();
	}

	this.bindComplete();
}

/**
 * @private
 */
nitobi.grid.GridLiveScrolling.prototype.pageSelect= function(dir)
{
	var rowRange = this.Scroller.getUnrenderedBlocks();
	var rows = rowRange.last - rowRange.first;
	this.reselect(0, rows * dir);
}
/**
 * Moves to a particular page of data.  If the data isn't loaded yet, the Grid will automatically
 * fetch the missing data.
 * @param {Number} dir 1 to move up, -1 to move down.
 */
nitobi.grid.GridLiveScrolling.prototype.page= function(dir)
{
	//	page needs to retrieve and render the next page of data 
	//	and then set the active cell and the selection box to the 
	//	corresponding cell in the next page of data.
	var rowRange = this.Scroller.getUnrenderedBlocks();
	var rows = rowRange.last - rowRange.first;
	this.move(0, rows * dir);
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @private
 */
nitobi.grid.LoadingScreen = function(grid)
 {
 	this.loadingScreen = null;
 	this.grid = grid;
	this.loadingImg = null;
 
 }
nitobi.grid.LoadingScreen.prototype.initialize = function()
{
	this.loadingScreen = document.createElement("div");
	var cssUrl = this.findCssUrl();
	var msg="";
	if (cssUrl == null)
	{
		msg = "Loading...";	
	}
	else
	{
		msg = "<img src='"+cssUrl+"loading.gif'  class='ntb-loading-Icon' valign='absmiddle'></img>"; 
	}
	this.loadingScreen.innerHTML = "<table style='padding:0px;margin:0px;' border='0' width='100%' height='100%'><tr style='padding:0px;margin:0px;'><td style='padding:0px;margin:0px;text-align:center;font:verdana;font-size:10pt;'>"+msg+"</td></tr></table>";
	this.loadingScreen.className = 'ntb-loading';
	var lss = this.loadingScreen.style;
	lss.verticalAlign="middle";
	lss.visibility = 'hidden';
	lss.position = "absolute";
	lss.top = "0px";
	lss.left = "0px";
}

nitobi.grid.LoadingScreen.prototype.attachToElement = function(element)
{
	element.appendChild(this.loadingScreen);
}

nitobi.grid.LoadingScreen.prototype.findCssUrl = function()
{
	var sheet = nitobi.html.findParentStylesheet("." + this.grid.getTheme() + " .ntb-loading-Icon");
	if (sheet==null)
	{
		return null;
	}
	var retVal = nitobi.html.normalizeUrl(sheet.href);
	if (nitobi.browser.IE)
	{
		while (sheet.parentStyleSheet)
		{
			sheet = sheet.parentStyleSheet;
			retVal = nitobi.html.normalizeUrl(sheet.href) + retVal;
		}
	}
	return retVal;
}
 
nitobi.grid.LoadingScreen.prototype.show = function()
{
	try
	{
		this.resize();

		this.loadingScreen.style.visibility="visible";
		this.loadingScreen.style.display="block";
	}
	catch(e)
	{
		
	}
}

nitobi.grid.LoadingScreen.prototype.resize = function()
{
	this.loadingScreen.style.width = this.grid.getWidth() + "px";
	this.loadingScreen.style.height = this.grid.getHeight() + "px";
}

nitobi.grid.LoadingScreen.prototype.hide = function()
{
	this.loadingScreen.style.display="none";
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a local paging Grid.
 * @class A subclass of nitobi.grid.Grid that uses local data and adds standard paging functionality. 
 * Fixed-height grid that does not scroll that pages through client-side data.
 * <p>
 * This paging mode would be used when you want to load all data at once from the server but you 
 * don't want to show all rows at once and you do not want to go back to the server for paging 
 * operations. 
 * </p>
 * <p>
 * <b>Stretch</b><br/>
 * 	Miniumum height of grid specified explicitly.<br/>
 * 	Maximum height of grid specified explicitly.<br/> 
 * 	Grid height stretches and shrinks to accomodate rows rendered.  
 * 	If there are not enough rows to fill the grid (based on min height), a blank area will be present 
 * 	Vertical scrollbar appears once max height has been exceeded.<br/>
 * </p>
 * <p>
 * <b>Client-side Data</b><br/>
 * 	Data in the client-side datasource constitutes all the available records.  
 * 	The grid renders a single page of data present in the client-side datasource that match the 
 *  specified filter criteria.<br/>
 * 	Sorting is performed client-side.<br/>
 * 	Grid rows are rendered in multiple render operations (with each paging operation).<br/>
 * 	Data is loaded once.<br/> 
 * 	Allows for static client-side XML and loadXML() 
 * </p>
 * <p>
 * <b>Client-side Paging</b><br/>
 * 	Paging operations DO NOT request data from server.<br/>
 * 	Client-side data is kept across paging requests.<br/> 
 * 	Rendered rows are purged before each paging request.<br/> 
 * </p>
 * @constructor
 * @param {String} uid The unique ID of the Grid.
 * @extends nitobi.grid.Grid
 */
nitobi.grid.GridLocalPage = function(uid) {
	nitobi.grid.GridLocalPage.baseConstructor.call(this, uid);
	this.mode="localpaging";
//	this.PagingMode="standard";	//0 - None | 1 - Standard | 2 - LiveScrolling
	this.setPagingMode(nitobi.grid.PAGINGMODE_STANDARD);
//	this.DataMode="local";		//0 - Local | 1 - Remote | 2 - Caching
// TODO: ensure that properties with setters are using the setters
	this.setDataMode('local');		//0 - Local | 1 - Remote | 2 - Caching
}
nitobi.lang.extend(nitobi.grid.GridLocalPage, nitobi.grid.Grid);

/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.createChildren=function() {
	var args = arguments;

	nitobi.grid.GridLocalPage.base.createChildren.call(this,args);

	// Enable paging toolbar
	
	// This should be done only if there is a toolbar
	nitobi.grid.GridLiveScrolling.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD | nitobi.ui.Toolbars.VisibleToolbars.PAGING);
	// Attach events
	this.toolbars.subscribe("NextPage",nitobi.lang.close(this,this.pageNext));
	this.toolbars.subscribe("PreviousPage",nitobi.lang.close(this,this.pagePrevious));
	this.subscribe("EndOfData",function(pct){this.toolbars.pagingToolbar.getUiElements()["nextPage"+this.toolbars.uid].disable();}); 
	this.subscribe("TopOfData",function(pct){this.toolbars.pagingToolbar.getUiElements()["previousPage"+this.toolbars.uid].disable();}); 
	this.subscribe("NotTopOfData",function(pct){this.toolbars.pagingToolbar.getUiElements()["previousPage"+this.toolbars.uid].enable();}); 
	this.subscribe("NotEndOfData",function(pct){this.toolbars.pagingToolbar.getUiElements()["nextPage"+this.toolbars.uid].enable();}); 
}

/**
 * Go to the previous page
 */
nitobi.grid.GridLocalPage.prototype.pagePrevious=function() {
	this.fire("BeforeLoadPreviousPage");
	this.loadDataPage(Math.max(this.getCurrentPageIndex()-1,0));
	this.fire("AfterLoadPreviousPage");
}

/**
 * Go to the next page.
 */
nitobi.grid.GridLocalPage.prototype.pageNext=function() {
	this.fire("BeforeLoadNextPage");
	this.loadDataPage(this.getCurrentPageIndex()+1);
	this.fire("AfterLoadNextPage");
}

/**
 * Load a particular page.
 * @param {Number} newPageNumber The page number to load.
 */
nitobi.grid.GridLocalPage.prototype.loadDataPage = function(newPageNumber) 
{
	// Clear the selection if there is one.
	this.fire('BeforeLoadDataPage');

	//	Check if the newPageNumber is greater than -1
	if (newPageNumber > -1) 
	{
		this.setCurrentPageIndex(newPageNumber);
		this.setDisplayedRowCount(this.getRowsPerPage());

		var	startRow = this.getCurrentPageIndex()*this.getRowsPerPage(); //freezeTop not supported in standard paging (cuz how would that work? what rows would be frozen?)
		var rows = this.getRowsPerPage()-this.getfreezetop();
		this.setDisplayedRowCount(rows);
//		The -1 part causes EndOfData not to fire when we have pagesize = 20 and exactly 40 rows
//		var endRow = startRow+rows-1;
		var endRow = startRow+rows;
		if(endRow>=this.getRowCount()) {
			this.fire("EndOfData");
		} else {
			this.fire("NotEndOfData");
		}
		if(startRow==0) {
			this.fire("TopOfData");
		} else {
			this.fire("NotTopOfData");
		}
		this.clearSurfaces();
		this.updateCellRanges();
		this.scrollVertical(0);

//		this.Scroller.view.midcenter.renderGap(startRow, endRow, false);
		
	}

	// Resize the grid if necessary, show/hide scrollbars
	// Set focus to topleft cell
	this.fire('AfterLoadDataPage');
}

// PAGING MEMBERS
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.setRowsPerPage=function(rows) {
	// 
	this.setDisplayedRowCount(this.getRowsPerPage());
	this.data.table.pageSize = this.getRowsPerPage();
}
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.pageStartIndexChanges=function() {
	// Clear surfaces
	// Get page of xml (based on current sort and filter criteria)
	// Re-render data
}	
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.hitFirstPage=function() {
	this.fire("FirstPage");
}
/**
 * @private
 */	
nitobi.grid.GridLocalPage.prototype.hitLastPage=function() {
	this.fire("LastPage");
}
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.bind=function() 
{
	nitobi.grid.GridLocalPage.base.bind.call(this);

	// TODO: if we have created the datasource and loaded it with data BEFORE connecting to it
	// the rowcount changed events etc will not have propagated to the Grid and so we will
	// have an incorrect row count.
	this.finalizeRowCount(this.datatable.getRemoteRowCount());
	this.bindComplete();
}

//PageUp-PageDown Keys
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.pageUpKey=function() {
	this.pagePrevious();
}
/**
 * @private
 */
nitobi.grid.GridLocalPage.prototype.pageDownKey=function() {
	this.pageNext();
}


    nitobi.grid.GridLocalPage.prototype.renderMiddle= function()
    {
		nitobi.grid.GridLocalPage.base.renderMiddle.call(this,arguments);
		var startRow = this.getfreezetop();
		endRow = this.getRowsPerPage()-1;
		this.Scroller.view.midcenter.renderGap(startRow, endRow, false);
    }
  
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a non paging Grid.
 * @class A subclass of nitobi.grid.Grid that renders all the data at once, without any paging mechanism.
 * Fixed-height scrollable grid without paging 
 * <p>
 * <b>Fixed Size</b><br/> 
 * 	Height of grid specified explicitly.<br/> 
 * 	Vertical scrollbar allows user to scroll through rendered rows.  
 * 	If there are not enough rows to fill the grid, a blank area will be present, 
 *  the grid will not shrink.
 * </p>
 * <p> 
 * <b>Client-side Data</b><br/> 
 * 	Data in the client-side datasource constitutes all the available records.  
 * 	The grid renders all records present in the client-side datasource that match the specified filter 
 *  criteria.
 * 	Sorting is performed client-side.<br/>
 * 	All grid rows are rendered in a single render operation.<br/>
 * 	Data is loaded once.<br/> 
 * 	Allows for static client-side XML and loadXML().<br/>
 * </p>
 * <p>
 * <b>No Paging</b><br/> 
 * 	Paging operations have no effect 
 * </p>
 * @constructor
 * @param {String} uid The unique ID of the Grid.
 * @extends nitobi.grid.Grid
 */
nitobi.grid.GridNonpaging = function(uid) {
	nitobi.grid.GridNonpaging.baseConstructor.call(this);
	this.mode="nonpaging";
//	this.PagingMode="none";	//0 - None | 1 - Paging | 2 - LiveScrolling
	this.setPagingMode(nitobi.grid.PAGINGMODE_NONE);
//	this.DataMode="local";		//0 - Local | 1 - Remote | 2 - Caching
// TODO: ensure that properties with setters are using the setters
	this.setDataMode(nitobi.data.DATAMODE_LOCAL);		//0 - Unbound | 1 - Static | 2 - Paging | 3 - Caching
}
nitobi.lang.extend(nitobi.grid.GridNonpaging, nitobi.grid.Grid);

/**
 * @private
 */
nitobi.grid.GridNonpaging.prototype.createChildren=function() {
	var args = arguments;
	nitobi.grid.GridNonpaging.base.createChildren.call(this,args);
	nitobi.grid.GridNonpaging.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD);	
}

//get all data if getHandler specified (no paging stuff)
/**
 * @private
 */
nitobi.grid.GridNonpaging.prototype.bind=function() 
{
	nitobi.grid.GridStandard.base.bind.call(this);
	
	if (this.getGetHandler()!='') 
	{
		this.ensureConnected();
		this.datatable.get(0, null, this, this.getComplete);
	} else 
	{
		// TODO: if we have created the datasource and loaded it with data BEFORE connecting to it
		// the rowcount changed events etc will not have propagated to the Grid and so we will
		// have an incorrect row count.
		this.finalizeRowCount(this.datatable.getRemoteRowCount());
		this.bindComplete();
	}
}
/**
 * @private
 */
nitobi.grid.GridNonpaging.prototype.getComplete=function(evtArgs)
{
  	nitobi.grid.GridNonpaging.base.getComplete.call(this, evtArgs);

	// TODO: This is not needed since the connected datatable will fire all the
	// right events on the Grid when it gets the data back.
	this.finalizeRowCount(evtArgs.numRowsReturned);

	// TODO: This is not needed since the connected datatable will fire all the
	// right events on the Grid when it gets the data back.
	this.defineColumnsFinalize();

  	this.bindComplete();
}

/**
 * @private
 */
nitobi.grid.GridNonpaging.prototype.renderMiddle= function()
{
	nitobi.grid.GridNonpaging.base.renderMiddle.call(this,arguments);
	var startRow = this.getfreezetop();
	endRow = this.getRowCount();
	this.Scroller.view.midcenter.renderGap(startRow, endRow, false);
}

/*
nitobi.grid.GridNonpaging.prototype.handleKey = function()
{
}
*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class A subclass of nitobi.grid.Grid that adds standard paging functionality.  
 * Fixed-height grid with remote paging that does not scroll
 * <p>
 * <b>Stretch</b><br/> 
 * 	Miniumum height of grid specified explicitly.<br/>
 * 	Maximum height of grid specified explicitly.<br/> 
 * 	Grid height stretches and shrinks to accomodate rows rendered.   
 * 	If there are not enough rows to fill the grid (based on min height), a blank area will be present.<br/> 
 * 	Vertical scrollbar appears once max height has been exceeded.
 * </p>
 * <p>
 * <b>Server-side and Client-Side Data</b><br/> 
 * 	Data in the client-side datasource is a subset of server-side datasource records.   
 * 	The grid renders all records present in the client-side datasource that match the 
 *  specified filter criteria.<br/>
 * 	Sorting is performed server-side - client-side data is purged 
 * </p>
 * <p>
 * <b>Server-side Paging</b><br/> 
 * 	Paging operations request data from the server.<br/>
 * 	Single page of rows is rendered for each paging request.<br/> 
 * 	Client-side data is purged before each paging request.<br/> 
 * 	Rendered rows are purged before each paging request. 
 * </p>
 * @constructor
 * @param {String} uid The unique ID of the Grid.
 * @extends nitobi.grid.Grid
 */
nitobi.grid.GridStandard = function(uid) {
	nitobi.grid.GridStandard.baseConstructor.call(this, uid);
	this.mode="standard";
//	this.PagingMode="standard";	//0 - None | 1 - Standard | 2 - LiveScrolling
	this.setPagingMode(nitobi.grid.PAGINGMODE_STANDARD);
//	this.DataMode="paging";		//0 - Unbound | 1 - Static | 2 - Paging | 3 - Caching
// TODO: ensure that properties with setters are using the setters
	this.setDataMode(nitobi.data.DATAMODE_PAGING);		//0 - Unbound | 1 - Static | 2 - Paging | 3 - Caching
}
nitobi.lang.extend(nitobi.grid.GridStandard, nitobi.grid.Grid);

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.createChildren=function() {
	var args = arguments;

	nitobi.grid.GridStandard.base.createChildren.call(this,args);

	nitobi.grid.GridStandard.base.createToolbars.call(this, nitobi.ui.Toolbars.VisibleToolbars.STANDARD | nitobi.ui.Toolbars.VisibleToolbars.PAGING);

	// Attach events
	this.toolbars.subscribe("FirstPage",nitobi.lang.close(this,this.pageFirst));
	this.toolbars.subscribe("LastPage",nitobi.lang.close(this,this.pageLast));
	this.toolbars.subscribe("NextPage",nitobi.lang.close(this,this.pageNext));
	this.toolbars.subscribe("PreviousPage",nitobi.lang.close(this,this.pagePrevious));
	this.toolbars.subscribe("InputTextPage",nitobi.lang.close(this,this.pageTextInput));
	this.subscribe("EndOfData",this.disableNextPage); 
	this.subscribe("TopOfData",this.disablePreviousPage);
	this.subscribe("NotTopOfData",this.enablePreviousPage); 
	this.subscribe("NotEndOfData",this.enableNextPage);
	this.subscribe("TableConnected", nitobi.lang.close(this, this.subscribeToRowCountReady));
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.connectToTable = function(table)
{
	if (nitobi.grid.GridStandard.base.connectToTable.call(this, table) != false)
	{
		this.datatable.subscribe("RowInserted",nitobi.lang.close(this,this.incrementDisplayedRowCount));
		this.datatable.subscribe("RowDeleted",nitobi.lang.close(this,this.decrementDisplayedRowCount));	
	}
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.incrementDisplayedRowCount = function(quantity)
{
	this.setDisplayedRowCount(this.getDisplayedRowCount()+(quantity||1));
	this.updateCellRanges();
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.decrementDisplayedRowCount = function(quantity)
{
	// TODO: Are these still used or not?
	this.setDisplayedRowCount(this.getDisplayedRowCount()-(quantity||1));
	this.updateCellRanges();
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.subscribeToRowCountReady = function()
{
	//this.datatable.subscribe("RowCountReady",nitobi.lang.close(this,this.updateDisplayedRowCount));
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.updateDisplayedRowCount = function(eventArgs)
{
	this.setDisplayedRowCount(eventArgs.numRowsReturned);
}

/**
 * Disables the page next button in the Grid toolbar.
 */
nitobi.grid.GridStandard.prototype.disableNextPage = function()
{
	this.disableButton("nextPage");
}

/**
 * Disables the page previous button in the Grid toolbar.
 */
nitobi.grid.GridStandard.prototype.disablePreviousPage = function()
{
	this.disableButton("previousPage");
}
/**
 * @private
 */
nitobi.grid.GridStandard.prototype.disableButton = function(button)
{
	var t = this.getToolbars().pagingToolbar;
	if (t != null)
		t.getUiElements()[button+this.toolbars.uid].disable();
}
/**
 * Enables the page next button in the Grid toolbar.
 */
nitobi.grid.GridStandard.prototype.enableNextPage = function()
{
	this.enableButton("nextPage");
}
/**
 * Enables the page previous button in the Grid toolbar.
 */
nitobi.grid.GridStandard.prototype.enablePreviousPage = function()
{
	this.enableButton("previousPage");
}
/**
 * @private
 */
nitobi.grid.GridStandard.prototype.enableButton = function(button)
{
	var t = this.getToolbars().pagingToolbar;
	if (t != null)
		t.getUiElements()[button+this.toolbars.uid].enable();
}

/**
 * Go to the first page
 */
nitobi.grid.GridStandard.prototype.pageFirst=function() {
	this.fire("BeforeLoadPreviousPage");
	this.loadDataPage(0);
	this.fire("AfterLoadPreviousPage");
}

/**
 * Load the previous page of data.
 */
nitobi.grid.GridStandard.prototype.pagePrevious=function() {
	this.fire("BeforeLoadPreviousPage");
	this.loadDataPage(Math.max(this.getCurrentPageIndex()-1,0));
	this.fire("AfterLoadPreviousPage");
}

/**
 * Load the next page of data.
 */
nitobi.grid.GridStandard.prototype.pageNext=function() {
	this.fire("BeforeLoadNextPage");
	this.loadDataPage(this.getCurrentPageIndex()+1);
	this.fire("AfterLoadNextPage");
}

/**
 * Go to the last page
 */
nitobi.grid.GridStandard.prototype.pageLast=function() {
	this.fire("BeforeLoadNextPage");
	var totalPages = Math.ceil(this.datatable.totalRowCount/this.getRowsPerPage());
	this.loadDataPage(totalPages-1);
	this.fire("AfterLoadNextPage");
}

/**
 * Jump to the page based on the input text
 */
nitobi.grid.GridStandard.prototype.pageTextInput=function() {
	this.fire("BeforeLoadNextPage");
	var input = $ntb('startPage' + this.toolbars.uid);
	if(input)
	{
		var val = parseInt(input.value);
		this.loadDataPage(val-1);
	}
	this.fire("AfterLoadNextPage");
}
/**
 * Load a specific page of data.
 * @param {Number} newPageNumber The page to load.
 */
nitobi.grid.GridStandard.prototype.loadDataPage = function(newPageNumber) 
{
	// Clear the selection if there is one.
	this.fire('BeforeLoadDataPage');

	//	Check if the nePageNumber is greater than -1
	if (newPageNumber > -1) 
	{
		if (this.sortColumn)
		{
			if (this.datatable.sortColumn)
			{
				for (var i = 0; i < this.getColumnCount(); i++)
				{
					var colObj = this.getColumnObject(i);
					if (colObj.getColumnName() == this.datatable.sortColumn)
					{
						this.setSortStyle(i,this.datatable.sortDir);
						break;
					}
				}
			}
			else
			{
				this.setSortStyle(this.sortColumn.column, "", true);
			}
		}
		this.setCurrentPageIndex(newPageNumber);
		var	startRow = this.getCurrentPageIndex()*this.getRowsPerPage(); //freezeTop not supported in standard paging (cuz how would that work? what rows would be frozen?)
		var rows = this.getRowsPerPage()-this.getfreezetop();
//		var endRow = startRow+rows-1;
//		this.datatable.get(startRow, endRow, this, this.afterLoadDataPage);
		this.datatable.flush();
		this.datatable.get(startRow, rows, this, this.afterLoadDataPage);
	}
	// Resize the grid if necessary, show/hide scrollbars
	// Set focus to topleft cell
	this.fire('AfterLoadDataPage');
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.afterLoadDataPage=function(eventArgs) 
{
	this.setDisplayedRowCount(eventArgs.numRowsReturned);
	this.setRowCount(eventArgs.numRowsReturned)
	
	if (eventArgs.numRowsReturned != this.getRowsPerPage()) {
		this.fire("EndOfData");
	}else if ((eventArgs.lastRow + 1) == this.datatable.getTotalRowCount()) {
			this.fire("EndOfData");
	}
	else{
		this.fire("NotEndOfData");
	}
	if(this.getCurrentPageIndex() == 0) {
		this.fire("TopOfData");
	} else {
		this.fire("NotTopOfData");
	}
	this.clearSurfaces();
	this.updateCellRanges();
	this.scrollVertical(0);

//	this.Scroller.render();

// There is no need to explicitly call render here as the render is taken care of by the scroller...
//	this.Scroller.view.midleft.renderGap(startRow, endRow, false);
//	this.Scroller.view.midcenter.renderGap(startRow, endRow, false);
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.bind=function() 
{
	nitobi.grid.GridStandard.base.bind.call(this);	

	// TODO: What is all this pre-bind stuff? Is there any other pre-bind stuff.
	this.setCurrentPageIndex(0);
	this.disablePreviousPage();
	this.enableNextPage();
	this.ensureConnected();

	this.datatable.get(0, this.getRowsPerPage(), this, this.getComplete);
	
}

/**
 * @private
 */
nitobi.grid.GridStandard.prototype.getComplete=function(evtArgs)
{
//	this.setDisplayedRowCount(evtArgs.numRowsReturned);
//	if(evtArgs.numRowsReturned != this.getRowsPerPage()) {
//		this.fire("EndOfData");
//	} else {
//		this.fire("NotEndOfData");
//	}
//	if(evtArgs.startXi == 0) {
//		this.fire("TopOfData");
//	} else {
//		this.fire("NotTopOfData");
//	}
//	this.updateCellRanges();



	this.afterLoadDataPage(evtArgs);
	nitobi.grid.GridStandard.base.getComplete.call(this, evtArgs);

	// TODO: This is not needed since the connected datatable will fire all the
	// right events on the Grid when it gets the data back.
	this.defineColumnsFinalize();
	
  	this.bindComplete();
}

//PageUp-PageDown Keys
/**
 * @private
 */
nitobi.grid.GridStandard.prototype.renderMiddle= function()
{
	nitobi.grid.GridStandard.base.renderMiddle.call(this,arguments);
	var startRow = this.getfreezetop();
	endRow = this.getRowsPerPage()-1;
	this.Scroller.view.midcenter.renderGap(startRow, endRow, false);
}
  
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @constructor
 * @extends nitobi.grid.Column
 */
nitobi.grid.NumberColumn = function(grid, column)
{
	nitobi.grid.NumberColumn.baseConstructor.call(this, grid, column);
}

nitobi.lang.extend(nitobi.grid.NumberColumn, nitobi.grid.Column);

var ntb_numberp = nitobi.grid.NumberColumn.prototype;
/**
 * Sets the alignment of the values in the cells of the number column.
 * @param {String} align The alignment to set.
 */
nitobi.grid.NumberColumn.prototype.setAlign=function(){this.xSET("Align",arguments);}
/**
 * Returns the alignment of the values in the cells of the number column.
 * @type String
 */
nitobi.grid.NumberColumn.prototype.getAlign=function(){return this.xGET("Align",arguments);}
/**
 * Sets the mask for the number column.
 * @param {String} mask The mask to apply.
 */
nitobi.grid.NumberColumn.prototype.setMask=function(){this.xSET("Mask",arguments);}
/**
 * Returns the mask used for the number column.
 * @type String
 */
nitobi.grid.NumberColumn.prototype.getMask=function(){return this.xGET("Mask",arguments);}
/**
 * Sets the mask used when the value of a cell in the number column is negative.
 * @param {String} mask The mask to apply.
 */
nitobi.grid.NumberColumn.prototype.setNegativeMask=function(){this.xSET("NegativeMask",arguments);}
/**
 * Returns the mask used when the value of a cell in the number column is negative.
 * @type String
 */
nitobi.grid.NumberColumn.prototype.getNegativeMask=function(){return this.xGET("NegativeMask",arguments);}
/**
 * Sets the character used to group numbers together for cells in the number column.
 * @param {String} sep The separator to use
 */
nitobi.grid.NumberColumn.prototype.setGroupingSeparator=function(){this.xSET("GroupingSeparator",arguments);}
/**
 * Returns the character used to group numbers together for cells in the number column.
 * @type String
 */
nitobi.grid.NumberColumn.prototype.getGroupingSeparator=function(){return this.xGET("GroupingSeparator",arguments);}
/**
 * Sets the character to use when separting decimal values from whole values.
 * @param {String} dec The separator to use.
 */
nitobi.grid.NumberColumn.prototype.setDecimalSeparator=function(){this.xSET("DecimalSeparator",arguments);}
/**
 * Returns the character to use when separting decimal values from whole values.
 * @type String
 */
nitobi.grid.NumberColumn.prototype.getDecimalSeparator=function(){return this.xGET("DecimalSeparator",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.setOnKeyDownEvent=function(){this.xSET("OnKeyDownEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.getOnKeyDownEvent=function(){return this.xGET("OnKeyDownEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.setOnKeyUpEvent=function(){this.xSET("OnKeyUpEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.getOnKeyUpEvent=function(){return this.xGET("OnKeyUpEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.setOnKeyPressEvent=function(){this.xSET("OnKeyPressEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.getOnKeyPressEvent=function(){return this.xGET("OnKeyPressEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.setOnChangeEvent=function(){this.xSET("OnChangeEvent",arguments);}
/**
 * @private
 */
nitobi.grid.NumberColumn.prototype.getOnChangeEvent=function(){return this.xGET("OnChangeEvent",arguments);}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCopyEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {String} data The data that was copied in HTML table format.
 * @param {Object} coords The top left and bottom right coords, which are nitobi.drawing.Point objects. {"top":POINT,"bottom":POINT}.
 * @extends nitobi.grid.SelectionEventArgs
 * @private
 */
nitobi.grid.OnCopyEventArgs = function(source, data, coords)
{
	nitobi.grid.OnCopyEventArgs.baseConstructor.apply(this, arguments);
}

nitobi.lang.extend(nitobi.grid.OnCopyEventArgs, nitobi.grid.SelectionEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments for when data is pasted into the Grid.
 * @constructor
 * @param {nitobi.grid.Grid} source The Grid which is firing the event.
 * @param {String} data The data that is being copied in either tab separated or HTML table format.
 * @param {Object} coords The top left and bottom right coords, which are nitobi.drawing.Point objects. {"top":POINT,"bottom":POINT}.
 * @extends nitobi.grid.SelectionEventArgs
 * @private
 */
nitobi.grid.OnPasteEventArgs = function(source, data, coords)
{
	nitobi.grid.OnPasteEventArgs.baseConstructor.apply(this, arguments);
}

nitobi.lang.extend(nitobi.grid.OnPasteEventArgs, nitobi.grid.SelectionEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnAfterCellEditEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onaftercelleditevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </code></pre>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	cell.getDomNode().style.backgroundColor = "red";
 * }
 * </code></pre>
 * </div>
 * @constructor
 * @param {nitobi.grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that was clicked.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnAfterCellEditEventArgs = function(source, cell)
{
	nitobi.grid.OnAfterCellEditEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnAfterCellEditEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a new OnAfterColumnResizeEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with sorting (e.g onaftersortevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onaftersortevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of CellEventArgs to be passed to our handler.
 * 	var column = event.getColumn();
 * 	column.getDomNode().style.backgroundColor = "red";
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Column} column The Column object of the Column that was resized.
 * @extends nitobi.grid.ColumnEventArgs
 * @private
 */
nitobi.grid.OnAfterColumnResizeEventArgs = function(source, column)
{
	nitobi.grid.OnAfterColumnResizeEventArgs.baseConstructor.call(this, source, column);
}

nitobi.lang.extend(nitobi.grid.OnAfterColumnResizeEventArgs, nitobi.grid.ColumnEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers after a Row is deleted.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} cell The Row object of the cell that was clicked.
 * @extends nitobi.grid.RowEventArgs
 * @private
 */
nitobi.grid.OnAfterRowDeleteEventArgs = function(source, row)
{
	nitobi.grid.OnAfterRowDeleteEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnAfterRowDeleteEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers after a Row is inserted.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} cell The Row object of the cell that was clicked.
 * @extends nitobi.grid.RowEventArgs
 * @private
 */
nitobi.grid.OnAfterRowInsertEventArgs = function(source, row)
{
	nitobi.grid.OnAfterRowInsertEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnAfterRowInsertEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnAfterSortEventArgs object.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with sorting (e.g onaftersortevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onaftersortevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of OnAfterSortEvent to be passed to our handler.
 * 	var direction = event.getDirection();
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Column} cell The Column object of the Column that was sorted.
 * @param {String} direction The direction of the sort. This is either "Asc" or "Desc".
 * @extends nitobi.grid.ColumnEventArgs
 */
nitobi.grid.OnAfterSortEventArgs = function(source, column, direction)
{
	nitobi.grid.OnAfterSortEventArgs.baseConstructor.call(this, source, column);
	/**
	 * @private
	 */
	this.direction = direction;
}

nitobi.lang.extend(nitobi.grid.OnAfterSortEventArgs, nitobi.grid.ColumnEventArgs);

/**
 * Returns the direction of the sort.  Either "Asc" or "Desc".
 * @type String
 */
nitobi.grid.OnAfterSortEventArgs.prototype.getDirection = function()
{
	return this.direction;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnBeforeCellEditEventArgs object.  
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onbeforecelleditevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </code></pre>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	if (cell.getValue() == "No Edit")
 * 	{
 * 		return false;
 * 	}
 * }
 * </code></pre>
 * </div>
 * <p>
 * <b>N.B.</b>:  Note that by returning false from clickHandler, we can
 * cancel out of the edit.
 * </p>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that was clicked.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnBeforeCellEditEventArgs = function(source, cell)
{
	nitobi.grid.OnBeforeCellEditEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnBeforeCellEditEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments for when the a Column is resized.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Column} column The Column object of the Column that was resized.
 * @extends nitobi.grid.ColumnEventArgs
 * @private
 */
nitobi.grid.OnBeforeColumnResizeEventArgs = function(source, column)
{
	nitobi.grid.OnBeforeColumnResizeEventArgs.baseConstructor.call(this, source, column);
}

nitobi.lang.extend(nitobi.grid.OnBeforeColumnResizeEventArgs, nitobi.grid.ColumnEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers before a a Row is deleted.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} cell The Row object of the cell that was clicked.
 * @extends nitobi.grid.RowEventArgs
 * @private
 */
nitobi.grid.OnBeforeRowDeleteEventArgs = function(source, row)
{
	nitobi.grid.OnBeforeRowDeleteEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnBeforeRowDeleteEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers before a Row is inserted.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} cell The Row object of the cell that was clicked.
 * @extends nitobi.grid.RowEventArgs
 * @private
 */
nitobi.grid.OnBeforeRowInsertEventArgs = function(source, row)
{
	nitobi.grid.OnBeforeRowInsertEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnBeforeRowInsertEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/*not used yet*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments for when the a Column is sorted.
 * @class Encapsulates event arguments that are passed to event handlers subscribed to
 * Grid events that deal with sorting (e.g onbeforesortevent).
 * <br/>
 * <pre class="code">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onbeforesortevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre>
 * <p>
 * The handler function might look like this:
 * </p>
 * <pre class="code">
 * &#102;unction clickHandler(event)
 * {
 * 	// Note in the sample declaration above, we use the keyword 'eventArgs' to tell the Grid we'd like
 * 	// an instance of OnBeforeSortEvent to be passed to our handler.
 * 	var direction = event.getDirection();
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Column} cell The Column object of the Column that was sorted.
 * @param {String} direction The direction of the sort. This is either "Asc" or "Desc".
 * @extends nitobi.grid.ColumnEventArgs
 */
nitobi.grid.OnBeforeSortEventArgs = function(source, column, direction)
{
	nitobi.grid.OnBeforeSortEventArgs.baseConstructor.call(this, source, column);
	this.direction = direction;
}

nitobi.lang.extend(nitobi.grid.OnBeforeSortEventArgs, nitobi.grid.ColumnEventArgs);

/**
 * Returns the direction of the sort.
 * @return String
 */
nitobi.grid.OnBeforeSortEventArgs.prototype.getDirection = function()
{
	return this.direction;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnBeforeCellClickEventArgs object.  
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" onbeforecellclickevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </code></pre>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	if (cell.getValue() == "No Click")
 * 	{
 * 		return false;
 * 	}
 * }
 * </code></pre>
 * </div>
 * <p>
 * <b>N.B.</b>:  Note that by returning false from clickHandler, we can
 * cancel out of the click.
 * </p>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that was clicked.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnBeforeCellClickEventArgs = function(source, cell)
{
	nitobi.grid.OnBeforeCellClickEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnBeforeCellClickEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCellBlurEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * Cell blur is fired when a Cell loses focus by another Cell gaining focus.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" oncellblurevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre></code>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	cell.getDomNode().style.backgroundColor = "red";
 * }
 * </code></pre>
 * </div>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that received focus.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnCellBlurEventArgs = function(source, cell)
{
	nitobi.grid.OnCellBlurEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnCellBlurEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCellClickEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * Cell click is fired when a Cell is clicked on using the mouse.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" oncellclickevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </code></pre>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	cell.getDomNode().style.backgroundColor = "red";
 * }
 * </code></pre>
 * </div>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that was clicked.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnCellClickEventArgs = function(source, cell)
{
	nitobi.grid.OnCellClickEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnCellClickEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCellDblClickEventArgs object.
 * @class When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * Is fired when a Cell is double clicked.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" oncelldblclickevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </code></pre>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	cell.getDomNode().style.backgroundColor = "red";
 * }
 * </code></pre>
 * </div>
 * @constructor
 * @param {nitobi.grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that was clicked.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnCellDblClickEventArgs = function(source, cell)
{
	nitobi.grid.OnCellDblClickEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnCellDblClickEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCellFocusEventArgs object.
 * @class Cell focus is fired when a Cell is either clicked on using the mouse or 
 * navigated to with the keyboard.
 * <p>When you subscribe to Grid events through the declaration, you
 * can optionally pass information about the event to the function
 * registered to handle it.  You do this by using the eventArgs keyword.
 * </p>
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="html">
 * &lt;ntb:grid id="grid1" mode="livescrolling" oncellfocusevent="clickHandler(eventArgs)"&gt;&lt;/ntb:grid&gt;
 * </pre></code>
 * </div>
 * <p>
 * The handler function might look like this:
 * </p>
 * <div class="code">
 * <pre><code class="javascript">
 * &#102;unction clickHandler(event)
 * {
 * 	var cell = event.getCell();
 * 	cell.getDomNode().style.backgroundColor = "red";
 * }
 * </code></pre>
 * </div>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that received focus.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnCellFocusEventArgs = function(source, cell)
{
	nitobi.grid.OnCellFocusEventArgs.baseConstructor.call(this, source, cell);
}

nitobi.lang.extend(nitobi.grid.OnCellFocusEventArgs, nitobi.grid.CellEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Constructs a OnCellValidateEventArgs object.
 * @class This object may also be returned from the OnCellValidateEvent 
 * handler with new values for the newValue, displayValue and status 
 * properties. To invalidate the value you can return false from the function
 * set to handle the event.
 * <pre class="code">
 * &#102;unction validate(event)
 * {
 * 	if (event.getNewValue() &lt; event.getOldValue())
 * 	{
 * 		// By returning false, we revert the value of the cell back to the old value
 * 		return false;
 * 	}
 * }
 * </pre>
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Cell} cell The Cell object of the cell that received focus. 
 * @param {String} newValue The value that the user has entered into the cell.
 * @param {String} oldValue The previous value that the was entered into the cell.
 * @extends nitobi.grid.CellEventArgs
 */
nitobi.grid.OnCellValidateEventArgs = function(source, cell, newValue, oldValue)
{
	nitobi.grid.OnCellValidateEventArgs.baseConstructor.call(this, source, cell);
	/**
	 * The previous value that the was entered into the cell.
	 * @private
	 */
	this.oldValue = oldValue;
	/**
	 * The value that the user has entered into the cell.
	 * @private
	 */
	this.newValue = newValue;
}

nitobi.lang.extend(nitobi.grid.OnCellValidateEventArgs, nitobi.grid.CellEventArgs);


/**
 * Returns the previous value that the was entered into the cell.
 * Is only available for oncellvalidateevent.
 * @example
 * &#102;unction validate(event)
 * {
 * 	if (event.getNewValue() &lt; event.getOldValue())
 * 	{
 * 		// By returning false, we revert the value of the cell back to the old value
 * 		return false;
 * 	}
 * }
 * @type String
 */
nitobi.grid.OnCellValidateEventArgs.prototype.getOldValue = function()
{
	return this.oldValue;
}

/**
 * Returns the value that the user has entered into the cell.
 * Is only available for oncellvalidateevent.
 * @example
 * &#102;unction validate(event)
 * {
 * 	if (event.getNewValue() &lt; event.getOldValue())
 * 	{
 * 		// By returning false, we revert the value of the cell back to the old value
 * 		return false;
 * 	}
 * }
 * @type String
 */
nitobi.grid.OnCellValidateEventArgs.prototype.getNewValue = function()
{
	return this.newValue;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @constructor
 * @private
 */
nitobi.grid.OnContextMenuEventArgs = function()
{
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments for when the user clicks on a column header.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Column} column The Column object of the Column to which the header belongs.
 * @extends nitobi.grid.ColumnEventArgs
 * @private
 */
nitobi.grid.OnHeaderClickEventArgs = function(source, column)
{
	nitobi.grid.OnHeaderClickEventArgs.baseConstructor.call(this, source, column);
}

nitobi.lang.extend(nitobi.grid.OnHeaderClickEventArgs, nitobi.grid.ColumnEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers for the Cell blur event. Cell blur is fired when a Cell
 * is loses focus by another Cell gaining the focus.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} row The Row object of the cell that received focus.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnRowBlurEventArgs = function(source, row)
{
	nitobi.grid.OnRowBlurEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnRowBlurEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.grid');

/**
 * Event arguments passed to handlers for the Cell focus event. Cell focus is fired when a Cell
 * is either clicked on using the mouse or navigated to with the keyboard.
 * @constructor
 * @param {nitobi.grid.Grid} source The object which is firing the event.
 * @param {nitobi.grid.Row} row The Row object of the cell that received focus.
 * @extends nitobi.grid.CellEventArgs
 * @private
 */
nitobi.grid.OnRowFocusEventArgs = function(source, row)
{
	nitobi.grid.OnRowFocusEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnRowFocusEventArgs, nitobi.grid.RowEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a row object that encapsulates a row of data in the Nitobi Grid component.
 * @class The Row class represents a row of data in a Grid.  You can use a Row object
 * to manipulate the cells of that row or even the entire row itself.
 * @constructor
 * @param {nitobi.grid.Grid} grid The grid that the row belongs to.
 * @param {Number} row The row index (starting from 0).
 */
nitobi.grid.Row = function(grid,row)
{
	/**
	 * @private
	 */
	this.grid=grid;
	/**
	 * @private
	 */
	this.row=row;
	/**
	 * @private
	 */
	this.Row = row;

	/**
	 * @private
	 */
	this.DomNode = nitobi.grid.Row.getRowElement(grid, row);
}
/**
 * Returns the XML node from the DataTable that contains the Cell data.
 * @type XMLNode
 */
nitobi.grid.Row.prototype.getData = function() {
	if (this.DataNode == null)
		this.DataNode = this.grid.datatable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e[@xi='+this.Row+']');
	return this.DataNode;
}
/**
 * Returns the native web browser Style object for the given cell.
 * @type Object
 */
nitobi.grid.Row.prototype.getStyle = function()
{
	return this.DomNode.style;
}
/**
 * Gets a Cell in the Row either by index or name.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Row.prototype.getCell = function(index)
{
	return this.grid.getCellObject(this.row, index);
}
/**
 * Gets key value for the Row.
 * @private
 */
nitobi.grid.Row.prototype.getKey = function(index)
{
	return this.grid.getCellObject(this.row, index);
}
/**
 * Returns the row HTML element for the given Grid and row indices.
 * @param {nitobi.grid} grid The Grid to which the row belongs.
 * @param {Number} row The row index.
 * @type HTMLElement
 */
nitobi.grid.Row.getRowElement = function(grid, row)
{
	return nitobi.grid.Row.getRowElements(grid,row).mid;
};
/**
 * @private
 */
nitobi.grid.Row.getRowElements = function(grid, row)
{
	// TODO: refactor this offset stuff into a method in grid.
	var midCol = grid.getFrozenLeftColumnCount();
	if (!midCol)
		return {left: null, mid: $ntb("row_"+row+"_"+grid.uid)};

	var C = nitobi.grid.Cell;
	var rows = {};
	try
	{
		var leftCell = C.getCellElement(grid, row, 0);
		// Check that leftCell exists - handles the case where the last row in the Grid gets deleted or the Grid is empty.
		if (leftCell)
		{
			rows.left = C.getCellElement(grid, row, 0).parentNode;
			var cell = C.getCellElement(grid, row, midCol)
			rows.mid = cell ? cell.parentNode : null;
			return rows;
		} else {
			return {left: null, mid: $ntb("row_"+row+"_"+grid.uid)};
		}
	}
	catch(e)
	{
		//TODO: Log error? An exception can occur here when using frozen left columns in firefox.
	}
}

/**
 * Returns the row number of a row based on the HTML element of that row.
 * @param {HtmlElement} element The html element corresponding to a Grid row.
 * @type Number
 */
nitobi.grid.Row.getRowNumber = function(element)
{
	return parseInt(element.getAttribute("xi"));
}
/**
 * @private
 */
nitobi.grid.Row.prototype.xGETMETA = function()
{
	var node = this.MetaNode;
	node = node.selectSingleNode("@"+arguments[0]);
	if (node!=null) {
		return node.value;
	}
}
/**
 * @private
 */
nitobi.grid.Row.prototype.xSETMETA = function()
{
	var node = this.MetaNode;
	if (null==node)
	{
		var meta = this.grid.data.selectSingleNode("//root/gridmeta");
		var newNode = this.MetaNode=this.grid.data.createNode(1,"r","");
		newNode.setAttribute("xi",this.row);
		meta.appendChild(newNode);
		node=this.MetaNode=newNode;
	}
	if (node!=null) {
		node.setAttribute(arguments[0],arguments[1][0]);
		// Log changes
		// TODO: This all needs to be changed since we either dont use logMeta or dont even save this type of information.
	} else {
		alert("Cannot set property: "+arguments[0])
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @private
 */
nitobi.grid.RowRenderer = function(xmlDataSource,xslTemplate,rowHeight,firstColumn,columns,uniqueId)
{
	this.rowHeight = rowHeight;
	this.xmlDataSource = xmlDataSource;
	this.dataTableId = '';
//	this.xslTemplate = xslTemplate;

	this.firstColumn = firstColumn;
	this.columns = columns;
	this.firstColumn = firstColumn;
	this.uniqueId = uniqueId;

	this.mergeDoc = nitobi.xml.createXmlDoc("<ntb:root xmlns:ntb=\"http://www.nitobi.com\"><ntb:columns><ntb:stub/></ntb:columns><ntb:data><ntb:stub/></ntb:data></ntb:root>");
	this.mergeDocCols = this.mergeDoc.selectSingleNode("//ntb:columns");
	this.mergeDocData = this.mergeDoc.selectSingleNode("//ntb:data");
}

/**
 * @private
 */
nitobi.grid.RowRenderer.prototype.render = function(firstRow,rows, activeColumn, activeRow, sortColumn, sortDir)
{
//	if (this.xslTemplate == null)
//		return "";

	var firstRow = Number(firstRow) || 0;
	var rows = Number(rows) || 0;

	var xt = nitobi.grid.rowXslProc;
	xt.addParameter("start", firstRow, "");
	xt.addParameter("end", firstRow + rows, "");
	xt.addParameter('sortColumn', sortColumn, '');
	xt.addParameter('sortDirection', sortDir, '');
	xt.addParameter('dataTableId', this.dataTableId, '');

	// Do +0 to cast the bool to an int for Safari
	xt.addParameter("showHeaders", this.showHeaders+0, "");
	xt.addParameter("firstColumn", this.firstColumn, "");
	xt.addParameter("lastColumn", this.lastColumn, "");
	xt.addParameter("uniqueId", this.uniqueId, "");
	xt.addParameter("rowHover", this.rowHover, "");
	xt.addParameter("frozenColumnId", this.frozenColumnId, "");
	xt.addParameter("toolTipsEnabled", this.toolTipsEnabled, "")

	var data = this.xmlDataSource.xmlDoc();
	// TODO: This may not be applicable in all cases ... just the first render. THIS MAY BREAK STUFF!
	if (data.documentElement.firstChild == null)
		return "";

	var root = this.mergeDoc;
	this.mergeDocCols.replaceChild((!nitobi.browser.IE?root.importNode(this.definitions, true):this.definitions.cloneNode(true)), this.mergeDocCols.firstChild);
	this.mergeDocData.replaceChild((!nitobi.browser.IE?root.importNode(data.documentElement, true):data.documentElement.cloneNode(true)), this.mergeDocData.firstChild);

	s2 = nitobi.xml.transformToString(root, xt, "xml");

	s2 = s2.replace(/ATOKENTOREPLACE/g,"&nbsp;");
	s2 = s2.replace(/>\n</g,"><").replace(/\#\&lt\;\#/g,"<").replace(/\#\&gt\;\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#EQ\#/g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&").replace(/\n/g,"<br>");

	return s2;
}

/**
 * @private
 */
nitobi.grid.RowRenderer.prototype.generateXslTemplate = function(definitions,generator,firstColumn,columns,showHeaders,showRowIndicators,rowHover,tooltips, id)
{
	this.definitions = definitions;

	this.showIndicators = showRowIndicators;
	this.showHeaders = showHeaders;
	this.firstColumn = firstColumn;
	this.lastColumn = firstColumn+columns;
	this.rowHover = rowHover;
	this.frozenColumnId = (id?id:"");
	this.toolTipsEnabled = tooltips;

	return;

	// TODO: Need to put this into the new code ... 
	try {
		var path = (typeof(gApplicationPath) == "undefined"?window.location.href.substr(0,window.location.href.lastIndexOf('/')+1):gApplicationPath);
		var imp = this.xmlTemplate.selectNodes("//xsl:import");
		for (var i=0;i<imp.length;i++)
		{
			imp[i].setAttribute("href", path + "xsl/" + imp[i].getAttribute("href"));
		}
	} catch(e) {}
}

/**
 * @private
 */
nitobi.grid.RowRenderer.prototype.dispose = function()
{
	this.xslTemplate = null;
//	this.xmlDataSource.dispose();
	this.xmlDataSource = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
EBAScroller_RENDERTIMEOUT=100;
EBAScroller_VIEWPANES = new Array("topleft","topcenter","midleft","midcenter");

/**
 * @class nitobi.grid.Scroller3x3
 * @constructor
 * @private
 */
nitobi.grid.Scroller3x3 = function(owner,height,rows,columns,freezetop,freezeleft) {
	this.disposal = [];
	this.height = height;
	this.rows = rows;
	this.columns = columns;
	this.freezetop = freezetop;
	this.freezeleft = freezeleft;
	this.lastScrollTop = -1;

	this.uid = nitobi.base.getUid();

	this.onRenderComplete = new nitobi.base.Event();
	this.onRangeUpdate = new nitobi.base.Event();
	this.onHtmlReady = new nitobi.base.Event();

	this.owner = owner;

	var VP = nitobi.grid.Viewport;
	this.view = { topleft:		new VP(this.owner,0),
				  topcenter:	new VP(this.owner,1),
				  midleft:		new VP(this.owner,3),
				  midcenter:	new VP(this.owner,4)}

	this.view.midleft.onHtmlReady.subscribe(this.handleHtmlReady, this);

	this.setCellRanges();

	//	This is a DOM node that represents the main scrolling surface
	//	It is set in MapToHTML ...
	this.scrollSurface = null;
	
	//	startRow is the first row of the live scrolling section.
	this.startRow = freezetop;

	this.headerHeight = 23;
	this.rowHeight = 23;

	this.lastTimeoutId = 0;
	this.scrollTopPercent = 0;

	this.dataTable = null;

	this.cacheMap = new nitobi.collections.CacheMap(-1,-1);
	// Attach to Viewport events

}
/**
 * Reponds to changes in the recordset size by resizing the grid surface
 */
nitobi.grid.Scroller3x3.prototype.updateCellRanges= function(cols,rows,frzL,frzT) {
	this.columns = cols;
	this.rows = rows;
	this.freezetop = frzT;
	this.freezeleft = frzL;
	this.setCellRanges();
}
nitobi.grid.Scroller3x3.prototype.setCellRanges= function() {
	var pageSize = null;
	if (this.implementsStandardPaging())
	{
		// TODO: Schenker grid uses getRowsPerPage() here ...
		// pageSize = this.getRowsPerPage();
		pageSize = this.getDisplayedRowCount();
	}
	this.view.topleft.setCellRanges(0,this.freezetop,0,this.freezeleft);
	this.view.topcenter.setCellRanges(0,this.freezetop,this.freezeleft,this.columns-this.freezeleft);

	this.view.midleft.setCellRanges(this.freezetop, (pageSize?pageSize:this.rows)-this.freezetop, 0, this.freezeleft);
	this.view.midcenter.setCellRanges(this.freezetop, (pageSize?pageSize:this.rows)-this.freezetop, this.freezeleft, this.columns-this.freezeleft);
}
nitobi.grid.Scroller3x3.prototype.resize=function(height) {
	this.height = height;
}
nitobi.grid.Scroller3x3.prototype.setScrollLeftRelative=function(offset) {
	this.setScrollLeft(this.scrollLeft+offset);
}
nitobi.grid.Scroller3x3.prototype.setScrollLeftPercent=function(scrollPercent) {
	this.setScrollLeft(Math.round((this.view.midcenter.element.scrollWidth-this.view.midcenter.element.clientWidth) * scrollPercent));
}
nitobi.grid.Scroller3x3.prototype.setScrollLeft=function(scrollLeft) {
	this.view.midcenter.element.scrollLeft = scrollLeft;
	this.view.topcenter.element.scrollLeft = scrollLeft;
}
nitobi.grid.Scroller3x3.prototype.getScrollLeft=function() {
	return this.scrollSurface.scrollLeft;
}
nitobi.grid.Scroller3x3.prototype.setScrollTopRelative=function(offset) {
	this.setScrollTop(this.getScrollTop()+offset);
}
nitobi.grid.Scroller3x3.prototype.setScrollTopPercent=function(scrollPercent) {
	ntbAssert(!isNaN(scrollPercent),"scrollPercent isNaN");
	this.setScrollTop(Math.round((this.view.midcenter.element.scrollHeight-this.view.midcenter.element.clientHeight) * scrollPercent));
}
nitobi.grid.Scroller3x3.prototype.getScrollTopPercent = function(){
	return this.scrollSurface.scrollTop / (this.view.midcenter.element.scrollHeight-this.view.midcenter.element.clientHeight);
}
nitobi.grid.Scroller3x3.prototype.setScrollTop=function(scrollTop) {
	this.view.midcenter.element.scrollTop = scrollTop;
	this.view.midleft.element.scrollTop = scrollTop;
	this.render();
}
nitobi.grid.Scroller3x3.prototype.getScrollTop=function() {
	return this.scrollSurface.scrollTop;
}

nitobi.grid.Scroller3x3.prototype.clearSurfaces=function(ClearAll,ClearTop,ClearMiddle,ClearBottom) {
	this.flushCache();
	ClearMiddle=true; // always clear middle for now
	if(ClearAll) {
		ClearTop=true;
		ClearMiddle=true;
		ClearBottom=true;
	}
	if (ClearTop) {
		this.view.topleft.clear(true);
		this.view.topcenter.clear(true);
	}
	
	// TODO: figure this clearing of viewports out properly ...
	if (ClearMiddle) {
		// TODO: This is changed from Schenker grid
		// this.view.midleft.clear(false, true, false, false);
		this.view.midleft.clear(true, true, false, false);
		this.view.midcenter.clear(false,false,true);
	}
	if (ClearBottom) {
	}
}

// NOTE: Removed a bunch of stuff here ... 

nitobi.grid.Scroller3x3.prototype.mapToHtml=function(oNode)
{
	var uid = this.owner.uid;
	for (var i=0;i<4;i++) {
		var node=$ntb("gridvp_"+i+"_"+uid);
		this.view[EBAScroller_VIEWPANES[i]].mapToHtml(node,nitobi.html.getFirstChild(node),null);  
	}
	this.scrollSurface = $ntb("gridvp_3_"+uid);
}

/**
 * Returns a row range of what should currently be rendered in the grid. When paging is not being used,
 * it simply returns the total number of rows in the Grid. For LiveScrolling it calculates the rows 
 * to show based on the scroll position. Finally, for Standard paging it returns the rowsPerPage offset
 * by the index of the current page. 
 * @return {Pair} A struct range with first and last values which are the start and end of the row range.
 */
nitobi.grid.Scroller3x3.prototype.getUnrenderedBlocks = function()
{
	var pair = {first : this.freezetop, last: this.rows-1-this.freezetop};
	if (!this.implementsShowAll()) {
		var scrollTop = this.getScrollTop()+ this.getTop() - this.headerHeight;

		var MC = this.view.midcenter;
		var b0=MC.findBlockAtCoord(scrollTop);
		var b1=MC.findBlockAtCoord(scrollTop+this.height);
		var firstVisibleRow=null;
		var lastVisibleRow=null;
		if (b0 == null) {
			return;
		}
		firstVisibleRow = b0.top+Math.floor((scrollTop-b0.offsetTop)/this.rowHeight);
		if (b1) {
			lastVisibleRow = b1.top+Math.floor((scrollTop+this.height-b1.offsetTop)/this.rowHeight);
		} else {
			lastVisibleRow=firstVisibleRow+Math.floor(this.height/this.rowHeight);
		}
		// TODO: this used to be this.rows-1 since lastVisibleRow is zero based.
		lastVisibleRow=Math.min(lastVisibleRow,this.rows);

		// We check if standard paging is being used, and if so apply an offset 
		// of the page size * the current page to the first visible row.
		if (this.implementsStandardPaging()) 
		{
			var topOffset = 0;
			//topOffset = this.getRowsPerPage() * this.getCurrentPageIndex();

			if (this.owner.getRenderMode() == nitobi.grid.RENDERMODE_ONDEMAND)
			{
				// ** Live Scrolling + Standard Paging ...
				// TODO: this will make standard paging look like livescrolling on the page level
				// however, it causes the value in the editor to be "undefined" when you edit a cell.
				var first = firstVisibleRow + topOffset;
				// We use getDisplayedRowCount to take into account changes to do with insertion and deletion.
				var last = Math.min(lastVisibleRow+topOffset, topOffset+this.getDisplayedRowCount()-1); 
				pair = {first : first, last: last};
			}
			else
			{
				//Purely standard paging
				// TODO: although this should be correct it is causing double gets at startup if we include it.

				var first = topOffset;
				//var first = this.getRowsPerPage() * this.getCurrentPageIndex();
				// We use getDisplayedRowCount to take into account changes to do with insertion and deletion.
				var last = first + this.getDisplayedRowCount() - 1;
				pair = {first : first, last: last};
			}
		}
		else
		{
			pair = {first : firstVisibleRow, last: lastVisibleRow};
		}

		this.onRangeUpdate.notify(pair);
	}
	return pair;
}
/**
 * Initiatiate the render operation. Because the data may not yet be available, the actual render doesn't occur until renderReady()
 */
nitobi.grid.Scroller3x3.prototype.render=function(force)
{
	// Check if the grid is bound to the datasource yet and if the scroll has changed
	if (this.owner.isBound() && (this.getScrollTop() != this.lastScrollTop || force || this.scrollTopPercent>.9))
	{
		// Wait a little bit before rendering, just in case the user has scrolled past this position.
		// This enables quickly scrolling through large data sets without rendering every record.
		var funcRef = nitobi.lang.close(this, this.performRender, []);
		window.clearTimeout(this.lastTimeoutId);
		this.lastTimeoutId = window.setTimeout(funcRef, EBAScroller_RENDERTIMEOUT);
	}
}
/*
 * The actual render operation
 */
nitobi.grid.Scroller3x3.prototype.performRender=function()
{
  	var visibleRows = this.getUnrenderedBlocks();

	if (visibleRows==null) {return; }

  	var scrollTop = this.getScrollTop();

	var mc = this.view.midcenter;
	var ml = this.view.midleft;
	// Logic for increasing gap size moved into scroller
	var datatable = this.getDataTable();
	var first = visibleRows.first;
	var last = visibleRows.last;
	if (last>=datatable.remoteRowCount-1 && !datatable.rowCountKnown) {
		last+=2;
	}
	var gaps = this.cacheMap.gaps(first,last);

	// Behaviour is different on an empty grid when in livescrolling vs. other
	var noRows = (this.owner.mode.toLowerCase()==nitobi.grid.MODE_LIVESCROLLING?(first+last<=0):(first+last<=-1));

	if (noRows) {
		// If there are no rows to render then HTML is ready
		this.onHtmlReady.notify();
	} else if (gaps[0] != null) {
		var low = gaps[0].low;
		var high = gaps[0].high;

		var rows = high - low + 1;

		// If not all data is in cache we must issue a get
		if (!datatable.inCache(low, rows)) {
			if (low==null || rows==null) {
				alert("low or rows =null")
			}
			if (this.implementsStandardPaging())
			{
				var firstRow = this.getCurrentPageIndex() * this.getRowsPerPage();
				var lastRow = firstRow + this.getRowsPerPage();
				datatable.get(firstRow, lastRow);
			}
			else
			{
				datatable.get(low, rows);
			}
			// We may already have at least some of the data ... so render what we got
			var cached = datatable.cachedRanges(low,high);
			for (var i=0;i<cached.length;i++) {
				var subGaps = this.cacheMap.gaps(cached[i].low,cached[i].high);
				for (var j=0;j<subGaps.length;j++) {
					visibleRows.first = subGaps[j].low;
					visibleRows.last = subGaps[j].high;

					this.renderGap(subGaps[j].low,subGaps[j].high);
				}
			}
			return false;
		} else {
			//this.cacheMap.insert(low, high);
			this.renderGap(low, high);
		}
	}

	this.onRenderComplete.notify();
}
// TODO: This is instead of renderReady - most of the stuff from viewport is in here now
/*
 * The actual render operation
 */
nitobi.grid.Scroller3x3.prototype.renderGap = function(low,high)
{
	var gaps = this.cacheMap.gaps(low,high);
	var mc = this.view.midcenter;
	var ml = this.view.midleft;

	if (gaps[0] != null)
	{
		var low = gaps[0].low;
		var high = gaps[0].high;

		var rows = high - low + 1;
		this.cacheMap.insert(low, high);

		mc.renderGap(low,high);
		ml.renderGap(low,high);
	}
}

nitobi.grid.Scroller3x3.prototype.renderSpecified = function (low,high) 
{
	var rows = high - low + 1;
	var visibleRows = this.getUnrenderedBlocks();
	var datatable = this.getDataTable();

	// If not all data is in cache we must issue a get
	if (!datatable.inCache(low, rows)) {
		if (low==null || rows==null) {
			alert("low or rows =null")
		}
		if (this.implementsStandardPaging())
		{
			var firstRow = this.getCurrentPageIndex() * this.getRowsPerPage();
			var lastRow = firstRow + this.getRowsPerPage();
			datatable.get(firstRow, lastRow);
		}
		else
		{
			datatable.get(low, rows);
		}
		// We may already have at least some of the data ... so render what we got
		var cached = datatable.cachedRanges(low,high);
		for (var i=0;i<cached.length;i++) {
			var subGaps = this.cacheMap.gaps(cached[i].low,cached[i].high);
			for (var j=0;j<subGaps.length;j++) {
				visibleRows.first = subGaps[j].low;
				visibleRows.last = subGaps[j].high;

				this.renderGap(subGaps[j].low,subGaps[j].high);
			}
		}
		return false;
	} else {
		//this.cacheMap.insert(low, high);
		this.renderGap(low, high);
	}
	
}

// TODO: This is different from flushCache that used to call flushCache in viewport
nitobi.grid.Scroller3x3.prototype.flushCache = function()
{
	if (Boolean(this.cacheMap)) this.cacheMap.flush();
}
nitobi.grid.Scroller3x3.prototype.reRender= function(startRow, endRow)
{
	var range = this.view.midleft.clearBlocks(startRow, endRow);
	this.view.midcenter.clearBlocks(startRow, endRow);

	this.cacheMap.remove(range.top, range.bottom);

	this.render();
}
nitobi.grid.Scroller3x3.prototype.getViewportByCoords=function(row, column) 
{
	var topOffset = 0;
	// Top Left
	if (row>=topOffset && row<this.owner.getfreezetop() && column>=0 && column<this.owner.frozenLeftColumnCount())
		return this.view.topleft;
	// Top Center
	if (row>=topOffset && row<this.owner.getfreezetop() && column>=this.owner.getFrozenLeftColumnCount() && column<this.owner.getColumnCount())
		return this.view.topcenter;
	// Mid Left
	if (row>=this.owner.getfreezetop()+topOffset && row<this.owner.getDisplayedRowCount()+topOffset && column>=0 && column<this.owner.getFrozenLeftColumnCount())
		return this.view.midleft;
	// Mid Center
	if (row>=this.owner.getfreezetop()+topOffset && row<this.owner.getDisplayedRowCount()+topOffset && column>=this.owner.getFrozenLeftColumnCount() && column<this.owner.getColumnCount())
		return this.view.midcenter;
}
nitobi.grid.Scroller3x3.prototype.getRowsPerPage=function() {
	return this.owner.getRowsPerPage();
}
nitobi.grid.Scroller3x3.prototype.getDisplayedRowCount=function() {
	return this.owner.getDisplayedRowCount();
}
nitobi.grid.Scroller3x3.prototype.getCurrentPageIndex=function() {
	return this.owner.getCurrentPageIndex();
}
nitobi.grid.Scroller3x3.prototype.implementsStandardPaging = function() {
	return Boolean(this.owner.getPagingMode().toLowerCase() == "standard");
}
// This is written this way because I didn't want to get into trouble for rogue programming by fixing it properly
nitobi.grid.Scroller3x3.prototype.implementsShowAll = function() {
	return Boolean(this.owner.getPagingMode().toLowerCase() == nitobi.grid.PAGINGMODE_NONE);
}
nitobi.grid.Scroller3x3.prototype.setDataTable = function(oDataTable) {
	this.dataTable = oDataTable;
}
nitobi.grid.Scroller3x3.prototype.getDataTable = function() {
	return this.dataTable;
}

nitobi.grid.Scroller3x3.prototype.handleHtmlReady = function()
{
	this.onHtmlReady.notify();
}

nitobi.grid.Scroller3x3.prototype.getTop = function() {
	return this.freezetop * this.rowHeight + this.headerHeight;
}

nitobi.grid.Scroller3x3.prototype.setSort = function(col, dir)
{
	this.view.topleft.setSort(col, dir);
	this.view.topcenter.setSort(col, dir);
	this.view.midleft.setSort(col, dir);
	this.view.midcenter.setSort(col, dir);
}

nitobi.grid.Scroller3x3.prototype.setRowHeight = function(rowHeight)
{
	this.rowHeight = rowHeight;
	this.setViewportProperty("RowHeight", rowHeight);
}
nitobi.grid.Scroller3x3.prototype.setHeaderHeight = function(headerHeight)
{
	this.headerHeight = headerHeight;
	this.setViewportProperty("HeaderHeight", headerHeight);
}
nitobi.grid.Scroller3x3.prototype.setViewportProperty = function(property, value)
{
	var sv = this.view;
	for (var i=0; i<EBAScroller_VIEWPANES.length; i++)
	{
		sv[EBAScroller_VIEWPANES[i]]["set"+property](value);
	}
}
nitobi.grid.Scroller3x3.prototype.fire= function(evt,args){
	return nitobi.event.notify(evt+this.uid,args);
}
nitobi.grid.Scroller3x3.prototype.subscribe= function(evt,func,context)  {
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
}

nitobi.grid.Scroller3x3.prototype.dispose = function()
{
	try
	{
		(this.cacheMap!= null?this.cacheMap.flush():'');
		this.cacheMap = null;

		var disposalLength = this.disposal.length;
		for (var i=0; i<disposalLength; i++)
		{
			if (typeof(this.disposal[i]) == "function")
			{
				this.disposal[i].call(this);
			}
			this.disposal[i] = null;
		}

		for (var v in this.view)
		{
			this.view[v].dispose();
		}

		for (var item in this)
		{
			if (this[item] != null && this[item].dispose instanceof Function)
			{
				this[item].dispose();
			}
		}
	}
	catch(e)
	{
//		ntbAssert();
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Constructs a Selection object.
 * @class A Selection represents the cells of a Grid that are currently
 * selected.  This class can be used to programatically select a region of
 * cells.
 * @example
 * var grid = nitobi.getComponent("myGrid");
 * grid.getSelection();
 * @constructor
 * @param {nitobi.grid.Grid} owner The Grid that this selection belongs to.
 * @param {Boolean} [dragFillEnabled] Whether or not to enable the drag fill feature.
 */
nitobi.grid.Selection = function(owner, dragFillEnabled)
{
	nitobi.grid.Selection.baseConstructor.call(this,owner);
	
	/**
	 * @private
	 */
	this.owner = owner;
    var t = new Date();
    /**
     * Specifies whether the selection is in the active selecting state or not.
     * @private
     */
	this.selecting = false;
	/**
	 * Specifies whether the selection is being expanded or not. During expansion 
	 * the expanding and selection flags will be true.
	 * @private
	 */
	this.expanding = false;
	/**
	 * @private
	 */
	this.resizingRow = false;
	/**
	 * @private
	 */
	this.created=false;
	/**
	 * @private
	 */
	this.freezeTop = this.owner.getfreezetop();
	/**
	 * @private
	 */
	this.freezeLeft = this.owner.getFrozenLeftColumnCount();
	/**
	 * @private
	 */
	this.rowHeight = 23;

	/**
	 * Event that fires when an existing selection has been expanded using the mouse.
	 * Functions that subscribe to this event will be passed the Selection object that fired the event.
	 * @type nitobi.base.Event
	 */
	this.onAfterExpand = new nitobi.base.Event();

	/**
	 * Event that fires when a selection expansion starts.
	 * Functions that subscribe to this event will be passed the Selection object that fired the event.
	 * @type nitobi.base.Event
	 */
	this.onBeforeExpand = new nitobi.base.Event();

	/**
	 * Event that fires when a mouseup event fires on the selection.
	 * Functions that subscribe to this event will be passed the Selection object that fired the event.
	 * @nitobi.base.Event
	 */
	this.onMouseUp = new nitobi.base.Event();

	/**
	 * The bottom right cell of the selection when an expansion is started.
	 * @private
	 */
	this.expandEndCell = null;

	/**
	 * The top left cell of the selection when an expansion is started.
	 * @private
	 */
	this.expandStartCell = null;
	
	/**
	 * @private
	 */
	this.dragFillEnabled = dragFillEnabled || false;
	
	this.firstCellClick = false;
	
	this.multiSelect = false;
	
};

nitobi.lang.extend(nitobi.grid.Selection, nitobi.collections.CellSet);

/**
 * Sets the endpoints of the set of cells on the grid to which the selection refers.
 * @param {Number} startRow The row index of the start cell of the set.
 * @param {Number} startColumn The column index of the start column of the set.
 * @param {Number} endRow The row index of the end cell of the set.
 * @param {Number} endColumn The column index of the end cell of the set.
 */
nitobi.grid.Selection.prototype.setRange = function(startRow, startColumn, endRow, endColumn)
{
	nitobi.grid.Selection.base.setRange.call(this, startRow, startColumn, endRow, endColumn);
	this.startCell = this.owner.getCellElement(startRow, startColumn);
	this.endCell = this.owner.getCellElement(endRow, endColumn);
};

/**
 * Sets the endpoints of the selection based on the endpoints' DOM nodes. 
 * @private
 * @param startCell {DOMElement} The DOM node representing the start cell of the selection
 * @param endCell {DOMElement} The DOM node representing the end cell of the selection
 */
nitobi.grid.Selection.prototype.setRangeWithDomNodes = function(startCell, endCell)
{
	this.setRange(nitobi.grid.Cell.getRowNumber(startCell), nitobi.grid.Cell.getColumnNumber(startCell), nitobi.grid.Cell.getRowNumber(endCell), nitobi.grid.Cell.getColumnNumber(endCell));
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.createBoxes = function ()
{
	if (!this.created) {

		var uid = this.owner.uid;
		var H = nitobi.html;

		// The expander grabby is the small handle in the bottom right of the selection used to drag fill
		var boxexpanderGrabby = H.createElement("div", {"class":"ntb-grid-selection-grabby"})
		this.expanderGrabbyEvents = [
			{type:'mousedown', handler:this.handleGrabbyMouseDown},
			{type:'mouseup', handler:this.handleGrabbyMouseUp},
			{type:'click', handler:this.handleGrabbyClick}];
		H.attachEvents(boxexpanderGrabby, this.expanderGrabbyEvents, this);
		this.boxexpanderGrabby = boxexpanderGrabby;

		this.box = this.createBox("selectbox"+uid);
		this.boxl = this.createBox("selectboxl"+uid);

		this.events = [
			{type:'mousemove', handler:this.shrink},
			{type:'mouseup', handler:this.handleSelectionMouseUp},
			{type:'mousedown', handler:this.handleSelectionMouseDown},
			{type:'click', handler:this.handleSelectionClick},
			{type:'dblclick', handler:this.handleDblClick}];

		H.attachEvents(this.box, this.events, this);
		H.attachEvents(this.boxl, this.events, this);

		var sv = this.owner.Scroller.view;
		sv.midcenter.surface.appendChild(this.box);
		sv.midleft.surface.appendChild(this.boxl);

		this.clear();

		this.created=true;
	}
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.createBox = function (id)
{
	// boxBorder is the outer container for the selections
	var boxBorder;
	var cell;
	// In IE quirksmode and IE6 use a div for the selection rather than a table ...
	if (nitobi.browser.IE) {
		cell = boxBorder = document.createElement("div");
	} else {
		boxBorder = nitobi.html.createTable({"cellpadding":0,"cellspacing":0,"border":0}, {"backgroundColor":"transparent"});
		cell = boxBorder.rows[0].cells[0];
	}
	boxBorder.className = "ntb-grid-selection ntb-grid-selection-border";
	boxBorder.setAttribute("id", "ntb-grid-selection-"+id);
	var boxBackground = nitobi.html.createElement("div", {"id":id, "class":"ntb-grid-selection-background"});
	cell.appendChild(boxBackground);
	return boxBorder;
}

/**
 * Clears the selected boxes from the document.
 * This will detach any events and remove the boxes from the DOM whenever actions
 * such as insert, delete, refresh, sort, or paging are performed.
 */
nitobi.grid.Selection.prototype.clearBoxes = function()
{
	if (this.box != null)
		this.clearBox(this.box);
	if (this.boxl != null)
		this.clearBox(this.boxl);
	this.created = false;
	
	delete this.box;
	delete this.boxl;
	this.box = null;
	this.boxl = null;
}

/**
 * Clears the specified selection box by detaching events and then removing the selection box
 * from the DOM.
 * @param {HTMLElement} box The box to clear from the DOM.
 */
nitobi.grid.Selection.prototype.clearBox = function(box)
{
	nitobi.html.detachEvents(box, this.events);
	
	if (box.parentNode != null)
	{
		box.parentNode.removeChild(box);
	}
	box = null;
}

/**
 * Handles the mousedown event on the expand selection grabby.
 * @private
 */
nitobi.grid.Selection.prototype.handleGrabbyMouseDown = function(evt)
{
	this.selecting = true;
	this.setExpanding(true, "vert");

	var topLeft = this.getTopLeftCell();
	var btmRight = this.getBottomRightCell();

	this.expandStartCell = topLeft;
	this.expandEndCell = btmRight;

	var scrollSurface = this.owner.getScrollSurface();
	// TODO: this will be more complicated with multiple selections available
	this.expandStartCoords = nitobi.html.getBoundingClientRect(this.box,scrollSurface.scrollTop+document.body.scrollTop,scrollSurface.scrollLeft+document.body.scrollLeft);

	this.expandStartHeight = Math.abs(topLeft.getRow() - btmRight.getRow()) + 1;
	this.expandStartWidth = Math.abs(topLeft.getColumn() - btmRight.getColumn()) + 1;
	this.expandStartTopRow = topLeft.getRow();
	this.expandStartBottomRow = btmRight.getRow();
	this.expandStartLeftColumn = topLeft.getColumn();
	this.expandStartRightColumn = btmRight.getColumn();

	var Cell = nitobi.grid.Cell;
	// When we start expanding the top left needs to be made into the start cell
	if (Cell.getRowNumber(this.startCell) > Cell.getRowNumber(this.endCell))
	{
		var tmpCell = this.startCell;
		this.startCell = this.endCell;
		this.endCell = tmpCell;
	}

	this.onBeforeExpand.notify(this);

// This is commented out for Safari
//	nitobi.html.cancelEvent(evt);
//	return false;
}

/**
 * Handles the mouseup event on the expand selection grabby.
 * @private
 */
nitobi.grid.Selection.prototype.handleGrabbyMouseUp = function(evt)
{
	if (this.expanding)
	{
		// This event will bubble up to the selection mouseUp event where it will stop the selecting
		this.selecting = false;
		
		// We need to properly set the Horizontal/Vertical lines here.
		(this._startRow == this._endRow)? this.setExpanding(false, "horiz") : this.setExpanding(false);

		this.onAfterExpand.notify(this);

	}

}

/**
 * Handles the click event on the selection expansion grabby.
 * @private
 */
nitobi.grid.Selection.prototype.handleGrabbyClick = function(evt)
{
	// This is commented out for Safari
	//nitobi.html.cancelEvent(evt);
}

/**
 * Expands the area of the selection to the location of the mouse. This could be limited to either vertical or horizontal expansion like Excel.
 * @private 
 */
nitobi.grid.Selection.prototype.expand = function(cell, dir) {
	this.setExpanding(true, dir);

	var Cell = nitobi.grid.Cell;
	var endCell;

	// Theses are the variables that keep track of the original coords of the selection when expansion started
	var expandStartTopRow = this.expandStartTopRow, expandStartLeftColumn = this.expandStartLeftColumn;
	var expandStartBottomRow = this.expandStartBottomRow, expandStartRightColumn = this.expandStartRightColumn;

	// Get the end column and row numbers
	var endRow = Cell.getRowNumber(this.endCell), endColumn = Cell.getColumnNumber(this.endCell);
	// Get the start column and row numbers
	var startRow = Cell.getRowNumber(this.startCell), startColumn = Cell.getColumnNumber(this.startCell);

	// Get the new end column
	var newEndColumn = Cell.getColumnNumber(cell);
	// Get the new end row
	var newEndRow = Cell.getRowNumber(cell);

	var newStartColumn = startColumn, newStartRow = startRow;
	var o = this.owner;

	if (dir == "horiz") {
		// We are expanding horizontal
		if (startColumn < endColumn & newEndColumn < startColumn) {
			// We are expanding to the left back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(expandStartBottomRow, newEndColumn));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartRightColumn));
		} else if (startColumn > endColumn && newEndColumn > startColumn) {
			// We are expanding to the right back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(expandStartBottomRow, newEndColumn));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartLeftColumn));
		} else {
			// We are expanding away from the start cell so choose the row furthest from the start row
			this.changeEndCellWithDomNode(o.getCellElement((startRow==expandStartBottomRow?expandStartTopRow:expandStartBottomRow), newEndColumn));
		}
	} else {
		// We are expanding vertical
		if (startRow < endRow & newEndRow < startRow) {
			// We are expanding to the top back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, expandStartRightColumn));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartBottomRow, expandStartLeftColumn));
		} else if (startRow > endRow && newEndRow > startRow) {
			// We are expanding to the bottom back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, expandStartRightColumn));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartLeftColumn));
		} else {
			// We are expanding away from the start cell so choose the column furthest from the start column
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, (startColumn==expandStartRightColumn?expandStartLeftColumn:expandStartRightColumn)));
		}
	}

	this.alignBoxes();
}

/**
 * Shrinks the area of the selection down to the location of the mouse.
 * @private
 */
nitobi.grid.Selection.prototype.shrink = function(evt)
{
	// This is for Firefox where the selection expand border is a bit bigger than the selection so it can cause 
	// shrink to be called instead of expand because the expand border is 1px over the next cell where expand should be fired
	if (nitobi.html.Css.hasClass(evt.srcElement, "ntb-grid-selection-border") || nitobi.html.Css.hasClass(evt.srcElement, "ntb-grid-selection-grabby")) return;

	//	First make sure that the start and end cell are not the same - ie we have a selection
	//	Also check that we are in "selecting" mode
	if(this.endCell != this.startCell && this.selecting)
	{
		var scrollSurface = this.owner.getScrollSurface();

		var Cell = nitobi.grid.Cell;
		//	Get the end column and row numbers
		var endRow = Cell.getRowNumber(this.endCell), endColumn = Cell.getColumnNumber(this.endCell);
		//	Get the start column and row numbers
		var startRow = Cell.getRowNumber(this.startCell), startColumn = Cell.getColumnNumber(this.startCell);

		//	Get the event coords that cause this function to be called
		var eventCoords = nitobi.html.getEventCoords(evt);
		var evtY = eventCoords.y, evtX = eventCoords.x;
		if (nitobi.browser.IE || document.compatMode == "BackCompat") {
			// TODO: How did this get past us for so long? I guess we never really scrolled in IE?
			evtY = evt.clientY, evtX = evt.clientX;
		}

		// Get the bounding rect of the endCell in our selection
		var endCellRect = nitobi.html.getBoundingClientRect(this.endCell,scrollSurface.scrollTop+document.body.scrollTop, scrollSurface.scrollLeft+document.body.scrollLeft);
		var endCellRectTop = endCellRect.top, endCellRectLeft = endCellRect.left;

		//	Check if we are shrinking from the bottom up
		if (endRow > startRow && evtY < endCellRectTop)
			// The 4 here is a hack for the selection expansion when we are expanding up.
			endRow = endRow - Math.floor(((endCellRectTop-4) - evtY)/this.rowHeight)-1;
		//	of if we are shrinking from the top down
		else if (evtY > endCellRect.bottom)
			endRow = endRow + Math.floor((evtY - endCellRectTop)/this.rowHeight);

		//	Check if we are shrinking from right to left
		if (endColumn > startColumn && evtX < endCellRectLeft)
			endColumn --;
		//	or if we are shrinking from left to right
		else if (evtX > endCellRect.right)
			endColumn ++;

		// At this point we have got the new end and start cells from the normal selection process.

		if (this.expanding) {
			// If the coords of the event are inside the original selection just forget about it...

			// This is the top left row and column of the expansion selection
			var expandStartCellRow = this.expandStartCell.getRow(), expandStartCellColumn = this.expandStartCell.getColumn();
			// This is the bottom right row and column of the expansion selection
			var expandEndCellRow = this.expandEndCell.getRow(), expandEndCellColumn = this.expandEndCell.getColumn(); 

			if (endColumn >= this.expandStartLeftColumn && endColumn <= this.expandStartRightColumn) {
				// The endColumn is inside of the original selection so we need to limit the selection to at least that width

				if (endColumn >= startColumn && endColumn < expandEndCellColumn) {
					// When we have selected from left to right (ie startColum < endColumn) and then contract back into the 
					// selection, force the selection width to the original selection
					endColumn = expandEndCellColumn;
				} else if (endColumn <= startColumn && endColumn > expandStartCellColumn) {
					// When we have selected from right to left (ie endColumn < startColum) and then contract back into the 
					// selection, force the selection width to the original selection
					endColumn = expandStartCellColumn;
				}

				// When the end column is moving back past the start of the original selection we can change the end Column
				
				if (endColumn >= startColumn && endColumn <= this.expandStartRightColumn) {
					// The we are shrinking from the left to right
					endColumn = this.expandStartRightColumn;
				}
			}

			if (endRow >= this.expandStartTopRow && endRow <= this.expandStartBottomRow) {
				// The endRow is inside of the original selection so we need to limit the selection to at least that height

				// TODO: There are some edge cases here with the <= >= cases ... 
				if (startRow < endRow && endRow <= expandEndCellRow) {
					// When we have selected from top to bottom (ie startRow < endRow) and then contract back into the 
					// selection, force the selection height to the original selection
					endRow = expandEndCellRow;
				} else if (startRow > endRow && endRow >= expandStartCellRow) {
					// When we have selected from bottom to top (ie endRow < startRow) and then contract back into the 
					// selection, force the selection height to the original selection
					endRow = expandStartCellRow;
				} else if (startRow == endRow) {
					// We have to either set the endRow to the original top or bottom row
					endRow = (startRow == expandStartCellRow?expandEndCellRow:expandStartCellRow)					 
				}
			}
		}

		var newEndCell = this.owner.getCellElement(endRow, endColumn);
		var newStartCell = this.owner.getCellElement(startRow, startColumn);

		if (newEndCell != null &&newEndCell != this.endCell || newStartCell != null && newStartCell != this.startCell)
		{
			this.changeEndCellWithDomNode(newEndCell);
			this.changeStartCellWithDomNode(newStartCell);
			//	Align the selection boxes to the new selection start and end points
			this.alignBoxes();
			//	TODO: need to take into account the reduction in size of the selection
			//	and scroll the grid over the left so that we can keep scrolling over
			this.owner.ensureCellInView(newEndCell);
		}
	}
};
/**
 * Returns the pixel height of the selection.
 * @private
 */
nitobi.grid.Selection.prototype.getHeight = function()
{
	// TODO: this is only if the mid-center viewport box is showing ... 
	var rect = nitobi.html.getBoundingClientRect(this.box);
	return rect.top - rect.bottom;
}

/**
 * Collapses the selection down to one cell 
 * @param {HtmlDomNode} [cell] The HTML DOM node of the cell to collapse to.  If omitted, the initial start cell of the selection is used.
 */
nitobi.grid.Selection.prototype.collapse = function(cell)
{
 	if (!cell)
 	{
 		cell = this.startCell;
 	}
 	if (!cell)
 	{
 		return;
 	}

	this.setRangeWithDomNodes(cell, cell);

	// TODO: this needs to be cleaned up ...
	if ((this.box==null) || (this.box.parentNode==null) || (this.boxl==null) || (this.boxl.parentNode==null))
	{
		this.created=false;
		this.createBoxes();
	}

	this.alignBoxes();

	this.selecting = false;
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.startSelecting = function (startCell, endCell)
{
 	this.selecting = true;
 	this.setRangeWithDomNodes(startCell,endCell);
 	this.shrink();
	
// 	document.body.attachEvent('onselectstart',function() {return false;});
};

/**
 * Collapses the current selection onto the specified cell 
 * (DEPRECATED - use Selection.collapse(cell))
 * @private
 */
nitobi.grid.Selection.prototype.clearSelection = function(cell)
{
	this.collapse(cell);
};

/**
 * Resize the current selection to the new specified end cell.
 * @param {nitobi.grid.Cell} cell The cell to be the new end cell.
 */
nitobi.grid.Selection.prototype.resizeSelection = function(cell)
{
 	this.endCell = cell;
 	this.shrink();
};

/**
 * Moves the current selection onto the specified cell 
 * (DEPRECATED - use Selection.collapse(cell))
 * @private
 */
nitobi.grid.Selection.prototype.moveSelection = function(cell)
{
 	this.collapse(cell);
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.alignBoxes = function()
{
 	var endCell = this.endCell || this.startCell;
 	var sc = this.getCoords();
 	var topRow = sc.top.y;
 	var topCol = sc.top.x;
  	var bottomRow = sc.bottom.y;
 	var bottomCol = sc.bottom.x;
	var standards = nitobi.lang.isStandards();
	// This is take into account the border width in Standards mode
	// Mozilla is nice cause the tables just align perfectly since they are magic but the tables in IE cause other problems...
 	// TODO: check on different style grids since it used to say IE && standards on the line below ...
 	var ox = oy = (nitobi.browser.IE?-1:0);
 	var ow = oh = (nitobi.browser.IE && standards?-1:1);
	// TODO: these numbers depend on the border etc of the selection i think ...
 	if (nitobi.browser.SAFARI||nitobi.browser.CHROME) {
		oy = ox = -1;
		if (standards)
			oh = ow = -1;
	}
 	// IE6
 		// Standards
 			// ow = -1;
 			// oh = -1;
 	// IE6
 		// Quirks
 			// perfect
 	// IE7
 		// Standards
 			// perfect
 	// IE7
 		// quirks
 			// perfect
 	// FF
 		// Standards
 			// perfect - though the edit box is a bit weird
 	// FF
 		// Quirks
 			// perfect

	if (bottomCol >= this.freezeLeft && bottomRow >= this.freezeTop) {
		var e = this.box;
		e.style.display="block";
		this.align(e,this.startCell,endCell,0x11101000,oh,ow,oy,ox);
		// Show the selection expander grabby in the mid center viewport
		if (this.dragFillEnabled) (e.rows != null?e.rows[0].cells[0]:e).appendChild(this.boxexpanderGrabby);
	} else {
		this.box.style.display="none";
	}
	if (bottomCol < this.freezeLeft || topCol < this.freezeLeft) {
		var e = this.boxl;
		e.style.display="block";
		this.align(e,this.startCell,endCell,0x11101000,oh,ow,oy,ox);
		if (this.box.style.display == "none") {
			// There is only left cells selected so show the selection expander grabby in the mid left viewport
			if (this.dragFillEnabled) (e.rows != null?e.rows[0].cells[0]:e).appendChild(this.boxexpanderGrabby);
		}
	} else {
		this.boxl.style.display="none";
	}
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.redraw = function(cell)
{
	if (!this.selecting)
		this.setRangeWithDomNodes(cell,cell);
	else
		this.changeEndCellWithDomNode(cell);

	this.alignBoxes();
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.changeStartCellWithDomNode = function(cell)
{
	this.startCell = cell;
	var Cell = nitobi.grid.Cell;
	this.changeStartCell(Cell.getRowNumber(cell), Cell.getColumnNumber(cell)); 
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.changeEndCellWithDomNode = function(cell)
{
	this.endCell = cell;
	var Cell = nitobi.grid.Cell;
	this.changeEndCell(Cell.getRowNumber(cell), Cell.getColumnNumber(cell));
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.init = function(cell)
{
	this.createBoxes();
    var t = new Date();
	this.selecting = true;

	this.setRangeWithDomNodes(cell, cell);
//	this.alignBoxes();
};

/**
 * Clears the current selection.
 */
nitobi.grid.Selection.prototype.clear = function()
{
	// Clear Block
	if (!this.box) 
	{
		return;
	}

	var bs = this.box.style;
	bs.display="none";
	bs.top="-1000px";
	bs.left="-1000px";
	bs.width='1px';
	bs.height='1px';
	var bls = this.boxl.style;
	bls.display="none";
	bls.top="-1000px";
	bls.left="-1000px";
	bls.width='1px';
	bls.height='1px';

	this.selecting = false;
};

/**
 * Handles single click mouse events on the selection.
 * @param {Event} evt The browser event object.
 */
/**
 * @private
 */
nitobi.grid.Selection.prototype.handleSelectionClick = function(evt)
{
	if (!this.selected())
	{
		if (NTB_SINGLECLICK == null && !(this.firstCellClick))
		{
			if (nitobi.browser.IE)
				evt = nitobi.lang.copy(evt);
			NTB_SINGLECLICK = window.setTimeout(nitobi.lang.close(this, this.edit, [evt]), 400);
		}
	} else {
		// Otherwise collapse and go into selection mode ...
		// Get the coords of the click and relate that to an underlying cell ...
		this.collapse();
		this.owner.focus();
		this.firstCellClick = false;
	}
};

/**
 * Handles double click mouse events on the selection.
 * @param {Event} evt The browser event object.
 * @private
 */
nitobi.grid.Selection.prototype.handleDblClick = function(evt) {
	if (!this.selected())
	{
		window.clearTimeout(NTB_SINGLECLICK);
		NTB_SINGLECLICK = null;
		if (this.owner.handleDblClick(evt))
			this.edit(evt);
	}
	else
		this.collapse();
}

/**
 * Clears the single click flag and calls edit on the Grid.
 * @param {Event} [evt] The browser event object.
 */
nitobi.grid.Selection.prototype.edit = function(evt)
{
	NTB_SINGLECLICK = null;
	this.owner.edit(evt);
}

/**
 * Sets the endpoints of the set of cells in the grid's selection based on the params and displays the selection
 * @param {nitobi.grid.Cell} startCell The start cell of the set
 * @param {nitobi.grid.Cell} endCell The end cell of the set
 */
nitobi.grid.Selection.prototype.select = function(startCell,endCell)
{
	this.selectWithCoords(startCell.getRowNumber(), startCell.getColumnNumber(), endCell.getRowNumber(), endCell.getColumnNumber());
};

/**
 * Sets the endpoints of the set of cells in the grid's selection and displays the selection
 * @param {Number} startRow The row index of the start cell of the set.
 * @param {Number} startColumn The column index of the start column of the set.
 * @param {Number} endRow The row index of the end cell of the set.
 * @param {Number} endColumn The column index of the end cell of the set.
 */
nitobi.grid.Selection.prototype.selectWithCoords	 = function(startRow, startColumn, endRow, endColumn)
{
	this.setRange(startRow, startColumn, endRow, endColumn);
	this.createBoxes();	
	this.alignBoxes();	
};

/**
 * called by mouseup event to stop the selection
 * @private
 */
nitobi.grid.Selection.prototype.handleSelectionMouseUp = function(evt)
{
	// This event will fire either directly or as the mouseup event bubbles up from the selection expansion grabby
	// When it is direct we may need to also cause the selection expansion to stop expanding
	if (this.expanding) {
		this.handleGrabbyMouseUp(evt);
	}
		
	this.stopSelecting(evt);
	
	this.onMouseUp.notify(this);
};


// TODO: this should start it into selection mode ...
nitobi.grid.Selection.prototype.handleSelectionMouseDown = function(evt) {
	// TODO: we cancel here to prevent from bubbling to the grid - this may be bad but was causing a weird data movement problem
	// This is commented out for Safari
	//nitobi.html.cancelEvent(evt);
	//this.selecting = true;
	this.firstCellClick = true;
}

nitobi.grid.Selection.prototype.stopSelecting = function(evt)
{
	this.owner.waitt=false;
	if (!this.selected())
  	{
		var cell = this.owner.findActiveCell(evt.srcElement) || this.startCell;
		
		var theCell = nitobi.grid.Cell;
		if (this.owner.activeCell != cell) {
			this.owner.setActiveCell(cell, evt.ctrlKey || evt.metaKey);
		}
    	this.collapse(cell);
  	}
  	this.selecting = false;
}

/**
 * Returns the Cell on which the selection started - this may not be equal to the top left cell of the selection in 
 * the case that the selection was created from bottom right to top left.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Selection.prototype.getStartCell = function()
{
	return this.startCell;
}

/**
 * Returns the Cell on which the selection ended - this may not be equal to the bottom right 
 * cell of the selection in the case that the selection was created from top left to bottom right.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Selection.prototype.getEndCell = function()
{
	return this.endCell;
}

/**
 * Returns the top left Cell of the selection.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Selection.prototype.getTopLeftCell = function()
{
	var coords = this.getCoords();
	return new nitobi.grid.Cell(this.owner, coords.top.y, coords.top.x);
}

/**
 * Returns the bottom right Cell of the selection.
 * @type nitobi.grid.Cell
 */
nitobi.grid.Selection.prototype.getBottomRightCell = function()
{
	var coords = this.getCoords();
	return new nitobi.grid.Cell(this.owner, coords.bottom.y, coords.bottom.x);
}

/**
 * Returns the number of rows high that the selection is.
 * @type Number
 */
nitobi.grid.Selection.prototype.getHeight = function()
{
	var coords = this.getCoords();
	return coords.bottom.y - coords.top.y + 1;
}

/**
 * Returns the number of columns wide that the selection is.
 * @type Number
 */
nitobi.grid.Selection.prototype.getWidth = function()
{
	var coords = this.getCoords();
	return coords.bottom.x - coords.top.x + 1;
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.getRowByCoords = function(oCell) 
{
	return(oCell.parentNode.offsetTop/oCell.parentNode.offsetHeight);
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.getColumnByCoords = function (oCell) 
{
	var nOffset=(this.indicator?-2:0);
	if(oCell.parentNode.parentNode.getAttribute('id').substr(0,6)!="freeze") {
		nOffset+=2-(this.freezeColumn*3);
	} else {
		nOffset+=2;
	}
	return Math.floor((oCell.sourceIndex-oCell.parentNode.sourceIndex-nOffset)/3);
};

/**
 * @private
 */
nitobi.grid.Selection.prototype.selected = function()
{
	return (this.endCell == this.startCell)?false:true;
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.setRowHeight = function(rowHeight)
{
	this.rowHeight = rowHeight;
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.getRowHeight = function()
{
	return this.rowHeight;
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.setExpanding = function(val, dir)
{
	if (val && this.expanding) return;

	this.expanding = val;
	this.expandingVertical = (dir == "horiz"?false:true);

	var C = nitobi.html.Css;
	var regular = "ntb-grid-selection-border";
	var active = regular + "-active";
	if (val) {
		C.swapClass(this.box, regular, active);
		C.swapClass(this.boxl, regular, active);
	} else {
		C.swapClass(this.box, active, regular);
		C.swapClass(this.boxl, active, regular);
	}
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.dispose = function()
{
}

/**
 * @private
 */
nitobi.grid.Selection.prototype.align = function(source,target1,target2,AlignBit_HWTBLRCM,oh,ow,oy,ox,show) {
//try {
	oh=oh || 0;
	ow=ow || 0;
	oy=oy || 0;
	ox=ox || 0;
	var a=AlignBit_HWTBLRCM;
	var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;

	if(!target1 || (nitobi.lang.typeOf(target1) != nitobi.lang.type.HTMLNODE))
	{
		return;
	}
	
	ntbAssert(Boolean(target1.parentNode) && Boolean(target2.parentNode) && Boolean(source.parentNode),"Couldn't align selection. The parentnode has vanished. Most likely this is due to refilter.");
	ad=nitobi.html.getBoundingClientRect(target1);
	bd=nitobi.html.getBoundingClientRect(target2);
	sd=nitobi.html.getBoundingClientRect(source);
	at=ad.top;
	ab=ad.bottom;
	al=ad.left;
	ar=ad.right;
//	ah=Math.abs(ab-at);
//	aw=Math.abs(ar-al);
	bt=bd.top;
	bb=bd.bottom;
	bl=bd.left;
	br=bd.right;
//	bh=Math.abs(bb-bt);
//	bw=Math.abs(br-bl);

	tt=ad.top;
	tb=bd.bottom;
	tl=ad.left;
	tr=bd.right;
	th=Math.abs(tb-tt);
	tw=Math.abs(tr-tl);
	
	st=sd.top;
	sb=sd.bottom;
	sl=sd.left;
	sr=sd.right;
	sh=Math.abs(sb-st);
	sw=Math.abs(sr-sl);

	var H = nitobi.html;

	if (a&0x10000000) source.style.height = (Math.max(bb-at,ab-bt)+oh)+'px'; // make same height
	if (a&0x01000000) source.style.width = (Math.max(br-al,ar-bl)+ow)+'px'; // make same width
	if (a&0x00100000) source.style.top = (H.getStyleTop(source)+Math.min(tt,bt)-st+oy) + 'px'; // align top
	if (a&0x00010000) source.style.top = (H.getStyleTop(source)+tt-st+th-sh+oy) + 'px'; // align bottom
	if (a&0x00001000) source.style.left = (H.getStyleLeft(source)-sl+Math.min(tl,bl)+ox) + 'px'; // align left
	if (a&0x00000100) source.style.left = (H.getStyleLeft(source)-sl+tl+tw-sw+ox) + 'px'; // align right
	if (a&0x00000010) source.style.top = (H.getStyleTop(source)+tt-st+oy+Math.floor((th-sh)/2)) + 'px'; // align middle vertically
	if (a&0x00000001) source.style.left = (H.getStyleLeft(source)-sl+tl+ox+Math.floor((tw-sw)/2)) + 'px'; // align middle horizontally

//} catch (err) {
//}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @private
 */
nitobi.grid.Surface = function(height,width,element)
{
	this.height=width;
	this.width=height;
	this.element=element;
}

/**
 * @private
 */
nitobi.grid.Surface.prototype.dispose = function()
{
	this.element = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates a TextColumn.
 * @constructor
 * @class A column type used by Grid to handle text columns.
 * @param {nitobi.grid.Grid} grid The Grid that this column belongs to.
 * @param {Number} column The index of the column (zero based).
 * @extends nitobi.grid.Column
 */
nitobi.grid.TextColumn = function(grid, column)
{
	nitobi.grid.TextColumn.baseConstructor.call(this, grid, column);
}

nitobi.lang.extend(nitobi.grid.TextColumn, nitobi.grid.Column);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ui");

/**
* @param {nitobi.ui.Toolbars.VisibleToolbars} visibleToolbars A bitmask representing which toolbars are being shown.
*/
nitobi.ui.Toolbars= function(parentGrid, visibleToolbars) 
{
	this.grid = parentGrid;
	this.uid = "nitobiToolbar_" + nitobi.base.getUid();
	this.toolbars = {};
	this.visibleToolbars = visibleToolbars;	
}

nitobi.ui.Toolbars.VisibleToolbars = {};
nitobi.ui.Toolbars.VisibleToolbars.STANDARD 	= 1;
nitobi.ui.Toolbars.VisibleToolbars.PAGING 		= 1 << 1;


nitobi.ui.Toolbars.prototype.initialize= function() 
{
	this.enabled=true;
	
	this.toolbarXml = nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.toolbarDoc));
	this.toolbarPagingXml = nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.pagingToolbarDoc));
}


nitobi.ui.Toolbars.prototype.attachToParent= function(container)
{
	this.initialize();
	
	this.container = container;
	// If there are no toolbars visible then dont render.
	if (this.standardToolbar == null && this.visibleToolbars)
	{
		this.makeToolbar();
		this.render();
	}
}

nitobi.ui.Toolbars.prototype.setWidth= function(width)
{
	this.width=width;
}

nitobi.ui.Toolbars.prototype.getWidth= function()
{
	return this.width;
}

nitobi.ui.Toolbars.prototype.setHeight= function(height)
{
	this.height=height;
}

nitobi.ui.Toolbars.prototype.getHeight= function()
{
	return this.height;
}

nitobi.ui.Toolbars.prototype.setRowInsertEnabled= function(enable)
{
	this.rowInsertEnabled = enable;
}
nitobi.ui.Toolbars.prototype.isRowInsertEnabled= function()
{
	return this.rowInsertEnabled;
}

nitobi.ui.Toolbars.prototype.setRowDeleteEnabled= function(enable)
{
	this.rowDeleteEnabled = enable;
}
nitobi.ui.Toolbars.prototype.isRowDeleteEnabled= function()
{
	return this.rowDeleteEnabled;
}

nitobi.ui.Toolbars.prototype.makeToolbar= function()
{
	var imgDir = this.findCssUrl();
	this.toolbarXml.documentElement.setAttribute("id","toolbar"+this.uid);	
	
	this.toolbarXml.documentElement.setAttribute("image_directory",imgDir);

	//TODO: This is begging for a cleaner solution.
	var nodes = this.toolbarXml.selectNodes('/toolbar/items/*');
	for (var i = 0; i < nodes.length; i++)
	{
		if (nodes[i].nodeType != 8)
		{
			nodes[i].setAttribute('id',nodes[i].getAttribute('id')+this.uid);
		}
	}

	this.standardToolbar = new nitobi.ui.Toolbar(this.toolbarXml,"toolbar"+this.uid);
	this.toolbarPagingXml.documentElement.setAttribute("id","toolbarpaging"+this.uid);	
	this.toolbarPagingXml.documentElement.setAttribute("image_directory",imgDir);
	
	nodes = (this.toolbarPagingXml.selectNodes('/toolbar/items/*'));
	for (var i = 0; i < nodes.length; i++)
	{
		if (nodes[i].nodeType != 8)
		{
			nodes[i].setAttribute('id',nodes[i].getAttribute('id')+this.uid);
		}
	}
	
	this.pagingToolbar = new nitobi.ui.Toolbar(this.toolbarPagingXml,"toolbarpaging"+this.uid);

}

nitobi.ui.Toolbars.prototype.getToolbar = function(id)
{
	// Good enough for now until this becomes a real collection.
	return eval("this." + id);
}

/**
 * Find the URL of the stylesheet that contains the toolbar classes.
 * @private
 * @return String The URL of the toolbar stylesheet.
 */
nitobi.ui.Toolbars.prototype.findCssUrl = function()
{
	var sheet = nitobi.html.Css.findParentStylesheet(".ntb-toolbar");
	if (sheet==null)
	{
		sheet = nitobi.html.Css.findParentStylesheet(".ntb-grid");
		if (sheet==null)
		{	
			nitobi.lang.throwError("The CSS for the toolbar could not be found.  Try moving the nitobi.grid.css file to a location accessible to the browser's javascript or moving it to the top of the stylesheet list. findParentStylesheet returned " + sheet);
		}
	}
	return nitobi.html.Css.getPath(sheet);
}



nitobi.ui.Toolbars.prototype.isToolbarEnabled= function() {
	return this.enabled;
}

nitobi.ui.Toolbars.prototype.render= function() 
{
	var toolbarDiv = this.container;
	toolbarDiv.style.visibility="hidden";

	var xsl = nitobi.ui.ToolbarXsl;
	if (xsl.indexOf("xsl:stylesheet") == -1)
	{
		xsl = "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"xml\" version=\"4.0\" />" + xsl
		+ "</xsl:stylesheet>";
	}
	var xslDoc = nitobi.xml.createXslDoc(xsl);

	xsl=nitobi.ui.pagingToolbarXsl;
	if(xsl.indexOf("xsl:stylesheet")==-1)
	{
		xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"xml\" version=\"4.0\" />"+xsl+"</xsl:stylesheet>";
	}
	var pagingXslDoc = nitobi.xml.createXslDoc(xsl);

	var toolbarHtml = nitobi.xml.transformToString(this.standardToolbar.getXml(), xslDoc,"xml");
	
	toolbarDiv.innerHTML = toolbarHtml;
	toolbarDiv.style.zIndex="1000";

	var toolbarPagingHtml = nitobi.xml.transformToString(this.pagingToolbar.getXml(), pagingXslDoc,"xml");
	toolbarDiv.innerHTML += toolbarPagingHtml;

	xslDoc = null;
	xmlDoc = null;

	this.standardToolbar.attachToTag();
	this.pagingToolbar.attachToTag();

	this.resize();

	var _this = this;
	var buttons = this.standardToolbar.getUiElements()
	
	// using a foreach loop and a switch statement allows users to create toolbars without some buttons
	// was previously causing an error with custom toolbars
	for (eachbutton in buttons) {
		// Check for 'empty' buttons and skip over.
		if (buttons[eachbutton].m_HtmlElementHandle == null) { continue; }
		buttons[eachbutton].toolbar = this;
		buttons[eachbutton].grid = this.grid;

		if(nitobi.browser.IE && buttons[eachbutton].m_HtmlElementHandle.onbuttonload != null)
		{
			var x = function(item, grid, tbar, iDom) {eval(buttons[eachbutton].m_HtmlElementHandle.onbuttonload);}
			x(buttons[eachbutton], this.grid, this,buttons[eachbutton].m_HtmlElementHandle);
		}
		else if(!nitobi.browser.IE && buttons[eachbutton].m_HtmlElementHandle.hasAttribute('onbuttonload'))
		{
			/**
			 * @public
			 */
			var x = function(item, grid, tbar, iDom) {eval(buttons[eachbutton].m_HtmlElementHandle.getAttribute('onbuttonload'));}
			x(buttons[eachbutton], this.grid, this,buttons[eachbutton].m_HtmlElementHandle);
		}

		switch (eachbutton) {
			case "save"+this.uid:
				buttons[eachbutton].onClick = 
					function()
					{
						_this.fire("Save");
					};
			break;
			case "newRecord"+this.uid:
				buttons[eachbutton].onClick = 
					function()
					{
						_this.fire("InsertRow");
					};
				// disable button i	 row insert is not allowed
				if(!this.isRowInsertEnabled())
				{
					buttons[eachbutton].disable();
				}
			break;
			case "deleteRecord"+this.uid:
				buttons[eachbutton].onClick = 
					function()
					{
						_this.fire("DeleteRow");
					};
				// disable button if row delete is not allowed
				if(!this.isRowDeleteEnabled())
				{
					buttons[eachbutton].disable();
				}
			break;
			case "refresh"+this.uid:
				buttons[eachbutton].onClick = 
					function()
					{
						var refreshOk=confirm("Refreshing will discard any changes you have made. Is it OK to refresh?");
						if (refreshOk)
						{
							_this.fire("Refresh");			
						}
					};
			break;
			default:
		}
	}
	
	// likewise for paging buttons
	var buttonsPaging = this.pagingToolbar.getUiElements();
	var _this = this;

	for (eachPbutton in buttonsPaging) {
		// Check for empty buttons and skip over if necessary.
		if (buttonsPaging[eachPbutton].m_HtmlElementHandle == null) { continue; }
		buttonsPaging[eachPbutton].toolbar = this;
		buttonsPaging[eachPbutton].grid = this.grid;

		if(nitobi.browser.IE && buttonsPaging[eachPbutton].m_HtmlElementHandle.onbuttonload != null)
		{
			/**
			 * @public
			 */
			var x = function(item, grid, tbar, iDom) {eval(buttonsPaging[eachPbutton].m_HtmlElementHandle.onbuttonload);}
			x(buttonsPaging[eachPbutton], this.grid, this,buttonsPaging[eachPbutton].m_HtmlElementHandle);
		}
		else if(!nitobi.browser.IE && buttonsPaging[eachPbutton].m_HtmlElementHandle.hasAttribute('onbuttonload'))
		{
			/**
			 * @public
			 */
			var x = function(item, grid, tbar, iDom) {eval(buttonsPaging[eachPbutton].m_HtmlElementHandle.getAttribute('onbuttonload'));}
			x(buttonsPaging[eachPbutton], this.grid, this,buttonsPaging[eachPbutton].m_HtmlElementHandle);
		}

		switch (eachPbutton) {
			case "previousPage"+this.uid:
				buttonsPaging[eachPbutton].onClick = 
					function()
					{
						_this.fire("PreviousPage");			
					};
				buttonsPaging[eachPbutton].disable();
			break;
			case "nextPage"+this.uid:
				buttonsPaging[eachPbutton].onClick = 
					function()
					{
						_this.fire("NextPage");
					};
			break;
			default:
		}
	}

	if (this.visibleToolbars & nitobi.ui.Toolbars.VisibleToolbars.STANDARD)
	{
		this.standardToolbar.show();
	}
	else
	{
		this.standardToolbar.hide();
	}
	if (this.visibleToolbars & nitobi.ui.Toolbars.VisibleToolbars.PAGING)
	{
		this.pagingToolbar.show();
	}
	else
	{
		this.pagingToolbar.hide();
	}
	toolbarDiv.style.visibility="visible";		
}

nitobi.ui.Toolbars.prototype.resize = function()
{
	var standardWidth = this.getWidth();
	if (this.visibleToolbars & nitobi.ui.Toolbars.VisibleToolbars.PAGING) {
		this.standardToolbar.setHeight(this.getHeight());
	}
	if (this.visibleToolbars & nitobi.ui.Toolbars.VisibleToolbars.STANDARD) {
		this.standardToolbar.setHeight(this.getHeight());
	}
}

nitobi.ui.Toolbars.prototype.fire= function(evt,args) 
{
	return nitobi.event.notify(evt+this.uid,args);
}

nitobi.ui.Toolbars.prototype.subscribe= function(evt,func,context)  
{
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
}

nitobi.ui.Toolbars.prototype.dispose= function()  
{
	this.toolbarXml = null;
	this.toolbarPagingXml = null;
	//	Manually dispose of important objects belonging to Grid
	if(this.toolbar && this.toolbar.dispose)
	{
	 	this.toolbar.dispose();
		this.toolbar = null;
	}

	if(this.toolbarPaging && this.toolbarPaging.dispose)
	{
	 	this.toolbarPaging.dispose();
		this.toolbarPaging = null;
	}
}  
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
//	This is to help with selection by scrolling a bit more than needed
//	so that the user can mouseover the next cell easily enough
//	TODO: this should vary as we scroll over otherwise it goes _really_ fast.
var EBA_SELECTION_BUFFER = 15;
var NTB_SINGLECLICK = null;

/**
 * @class
 * @private
 */
nitobi.grid.Viewport = function(grid,region)
{
  	//	This array is used to hold closures that remove any memory leaks
	this.disposal = [];
	this.surface=null;
	this.element=null;

	// TODO: THIS NEEDS TO BE USED AGAIN!!!
	this.rowHeight = 23;
	this.headerHeight = 23;

	this.sortColumn = 0;
	this.sortDir = 1;
	this.uid = nitobi.base.getUid();

	// TODO: THIS IS NEVER USED
	//this.surfaceAdjustmentMultiplier=2;
	this.region=region;
	this.scrollIncrement=0;
	this.grid = grid;

	this.startRow = 0;
	this.rows = 0;
	this.startColumn = 0;
	this.columns = 0;

	//	nitobi.grid.RowRenderer is responsible for rendering the rows ...
	this.rowRenderer = null;
	
	this.onHtmlReady = new nitobi.base.Event();
}

/**
 * 
 */
nitobi.grid.Viewport.prototype.mapToHtml = function(element,surface,placeholder) {
	// TODO: CHANGED FOR GROUPING GRID
	this.surface=surface;
	this.element=element;
	this.container=nitobi.html.getFirstChild(surface);
	this.makeLastBlock(0,this.grid.getRowsPerPage() * 5);
}
/**
 *
 */
nitobi.grid.Viewport.prototype.makeLastBlock = function(low,high) {
	if (this.lastEmptyBlock == null && this.grid && this.region>2 && this.region<5 && this.container) {
		if (this.container.lastChild) {
//			alert(low+":"+high)
			low=Math.max(low,this.container.lastChild.bottom);
		}
		this.lastEmptyBlock=this.renderEmptyBlock(low,high);
	}
}

/**
 * 
 */
nitobi.grid.Viewport.prototype.setCellRanges = function(startRow,rows,startColumn,columns)
{
	this.startRow=startRow;
	this.rows=rows;
	this.startColumn=startColumn;
	this.columns=columns;

	// TODO: THIS CAME FROM GROUPING GRID
	this.makeLastBlock(this.startRow,this.startRow+rows-1);
	if (this.lastEmptyBlock!=null  && this.region>2 && this.region<5 && this.rows>0) {
		var bottom=this.startRow+this.rows-1;
		if (this.lastEmptyBlock.top>bottom) {
			this.container.removeChild(this.lastEmptyBlock);
			this.lastEmptyBlock=null;
		} else {
			this.lastEmptyBlock.bottom=bottom;
			this.lastEmptyBlock.style.height = (this.rowHeight*(this.lastEmptyBlock.bottom-this.lastEmptyBlock.top+1))+"px";
			if (this.lastEmptyBlock.bottom<this.lastEmptyBlock.top)
				throw "blocks are miss aligned.";
		}
	}
	// TODO: END - THIS CAME FROM GROUPING GRID
}

/**
 *
 */
nitobi.grid.Viewport.prototype.clear = function(Surface,Placeholder,Center,Viewport)
{
	var uid = this.grid.uid;
	if (this.surface && Surface)
		this.surface.innerHTML = '<div id="gridvpcontainer_'+this.region+'_'+uid+'"></div>';
	if (this.element && Viewport)
		this.element.innerHTML = '<div id="gridvpsurface_'+this.region+'_'+uid+'"><div id="gridvpcontainer_'+this.region+'_'+uid+'"></div></div>';
	if (this.surface && Center)
		this.surface.innerHTML = '<div id="gridvpcontainer_'+this.region+'_'+uid+'"></div>';
	this.surface = nitobi.html.getFirstChild(this.element);
	this.container = nitobi.html.getFirstChild(this.surface);
	if (this.grid && this.region>2 && this.region<5) { //This is a jinky way of detecting when to use empty blocks
		this.lastEmptyBlock = null;
	}
	
	// After we clear, we need to ensure there is an empty block
	// otherwise the Grid won't be able to determine whether to
	// get more data from the server.
	this.makeLastBlock(0, this.grid.getRowsPerPage() * 5);
}

/**
 * This will try to render data from rows "top" to "bottom".
 * The data should already be in the datasource.
 */
nitobi.grid.Viewport.prototype.setSort = function(column,direction)
{
	this.sortColumn = column;
	this.sortDir = direction;
}
nitobi.grid.Viewport.prototype.renderGap = function(top, bottom)
{
	//	This gets the currently active row and column for possible style changes during rendering
	var activeColumn = activeRow = null;
	/*
	var activeCell = this.grid.activeCell;
	var activeColumn = 0, activeRow = 0;
	if (activeCell != null)
	{
		activeColumn = nitobi.grid.Cell.getColumnNumber(activeCell);
		activeRow = nitobi.grid.Cell.getRowNumber(activeCell);
	}
	*/

	// Find insertion point (which empty block to replace)
	var Empty = this.findBlock(top);
	// Render inside empty block
	var o = this.renderInsideEmptyBlock(top,bottom,Empty);
	if (o == null) { 
		return;
	}

	o.setAttribute('rendered','true');
	var rows = bottom-top+1;
	o.innerHTML = this.rowRenderer.render(top, rows, activeColumn, activeRow, this.sortColumn, this.sortDir);

	this.onHtmlReady.notify(this);
}

/**
 *
 */
 // OPTIMIMIZE THIS!!!!
nitobi.grid.Viewport.prototype.findBlock=function(row) {
	var blk=this.container.childNodes;
	for (var i=0;i<blk.length;i++) {
		if (row>=blk[i].top && row<=blk[i].bottom) {
			return blk[i];
		}
	}
}

/**
 *
 */
nitobi.grid.Viewport.prototype.findBlockAtCoord=function(top) {
	var blk=this.container.childNodes;
	for (var i=0;i<blk.length;i++) {
		var rt = blk[i].offsetTop;
		var rb = rt+blk[i].offsetHeight;
		if (top>=rt && top<=rb) {
			return blk[i];
		}
	}
}

/**
 *
 */
nitobi.grid.Viewport.prototype.getBlocks = function(startRow, endRow)
{
	var blocks = [];
	var startBlock = this.findBlock(startRow);
	var endBlock = startBlock;
	blocks.push(startBlock);
	while (endRow > endBlock.bottom)
	{
		var nextSibling = endBlock.nextSibling;
		if (nextSibling != null)
			endBlock = nextSibling;
		else
			break;
		blocks.push(endBlock);
	}
	return blocks;
}

/**
 *
 */
nitobi.grid.Viewport.prototype.clearBlocks = function(startRow, endRow)
{
	// TODO: should split up the first and last block rather than destroy it entirely.
	var blocks = this.getBlocks(startRow, endRow);
	var len = blocks.length;
	var top = blocks[0].top;
	var bottom = blocks[len-1].bottom;
	var nextSibling = blocks[len-1].nextSibling;
	for (var i=0; i<len; i++)
	{
		blocks[i].parentNode.removeChild(blocks[i]);
	}
	this.renderEmptyBlock(top, bottom, nextSibling);
	return {"top":top,"bottom":bottom};
}

/**
 *
 */
nitobi.grid.Viewport.prototype.renderInsideEmptyBlock=function(top, bottom, Empty) {
	if (Empty==null) {
		return this.renderBlock(top,bottom);
	}
	
	// Case - Completely Replace
	if (top==Empty.top && bottom>=Empty.bottom) {
		var newBlock = this.renderBlock(top,bottom,Empty)
		this.container.replaceChild(newBlock,Empty);
		if (Empty.bottom<Empty.top)
			throw "Render error";
		return newBlock;
	}

	// Case - Insert at Beginning - (Move top and insert before)
	if (top==Empty.top && bottom<Empty.bottom) {
		Empty.top = bottom+1;
		Empty.style.height = (this.rowHeight*(Empty.bottom-Empty.top+1))+"px";
		Empty.rows = Empty.bottom-Empty.top+1
		if (Empty.bottom<Empty.top)
			throw "Render error";
		return this.renderBlock(top,bottom,Empty);
	}

	// Case - Insert at End - (Move bottom and insert after)
	if (top>Empty.top && bottom>=Empty.bottom) {
		Empty.bottom = top-1;
		Empty.style.height = (this.rowHeight*(Empty.bottom-Empty.top+1))+"px";
		if (Empty.bottom<Empty.top)
			throw "Render error";
		return this.renderBlock(top,bottom,Empty.nextSibling);
	}

	// Case - Insert in the Middle (Move end insert after followed by a new empty block)
	if (top>Empty.top && bottom<Empty.bottom) {
		// Original emptyblock becomes the end emptyblock and a new start emptyblock is created
		var startBlock=this.renderEmptyBlock(Empty.top,top-1,Empty);
		Empty.top = bottom+1;
		Empty.style.height = (this.rowHeight*(Empty.bottom-Empty.top+1))+"px";
		if (Empty.bottom<Empty.top)
			throw "Render error";
		return this.renderBlock(top,bottom,Empty);
	}

	throw "Could not insert "+top+"-"+bottom+Empty.outerHTML;
}

/**
 *
 */
nitobi.grid.Viewport.prototype.renderEmptyBlock=function(top, bottom,nextSibling) {
	var o = this.renderBlock(top,bottom,nextSibling)
	o.setAttribute('id','eba_grid_emptyblock_'+this.region+'_'+top+'_'+bottom+'_'+this.grid.uid);
	if(top==0 && bottom ==99) {
		crash
	}
	o.setAttribute('rendered','false');
	o.style.height = Math.max(((bottom - top + 1)*this.rowHeight),0)+"px";
	return o;
}

/**
 *
 */
nitobi.grid.Viewport.prototype.renderBlock=function(top, bottom,nextSibling) {
//	if (bottom<top) return null;
	var o = document.createElement("div");
	// This will be reset by the calling function if called from renderEmptyBlock
	o.setAttribute('id','eba_grid_block_'+this.region+'_'+top+'_'+bottom+'_'+this.grid.uid);
	o.top=top;
	o.bottom=bottom;
	o.left = this.startColumn;
	o.right = this.startColumn + this.columns;
	o.rows=bottom-top+1;
	o.columns = this.columns;
	if (nextSibling) {
		this.container.insertBefore(o,nextSibling);
	} else {
		this.container.insertBefore(o,null);
	}
//	if (o.bottom<o.top) {
//	crash
//	}
	return o;
}

nitobi.grid.Viewport.prototype.setHeaderHeight = function(headerHeight)
{
	this.headerHeight = headerHeight;
}

nitobi.grid.Viewport.prototype.setRowHeight = function(rowHeight)
{
	this.rowHeight = rowHeight;
}

nitobi.grid.Viewport.prototype.dispose = function()
{
	this.element = null;
	this.container = null;

	nitobi.lang.dispose(this, this.disposal);
	return;
}

nitobi.grid.Viewport.prototype.fire= function(evt,args)  {
	return nitobi.event.notify(evt+this.uid,args);
  }
nitobi.grid.Viewport.prototype.subscribe= function(evt,func,context)  {
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
}
nitobi.grid.Viewport.prototype.attach= function(evt,func,element)  {
	return nitobi.html.attachEvent(element,evt,nitobi.lang.close(this,func));
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.data');

if (false)
{
	/**
	 * @namspace The namespace that contains classes to manage sets of data.
	 * @constructor
	 */
	nitobi.data = function(){};
}

nitobi.data.DATAMODE_UNBOUND="unbound";
nitobi.data.DATAMODE_LOCAL="local";
nitobi.data.DATAMODE_REMOTE="remote";
nitobi.data.DATAMODE_CACHING="caching";
nitobi.data.DATAMODE_STATIC="static";
nitobi.data.DATAMODE_PAGING="paging";

nitobi.data.DataSet=function()
{
	var ebans="http://www.nitobi.com"; // This string shouldn't be hard-coded
	this.doc = nitobi.xml.createXmlDoc('<'+nitobi.xml.nsPrefix+'datasources xmlns:ntb="'+ebans+'"></'+nitobi.xml.nsPrefix+'datasources>');
}
nitobi.data.DataSet.prototype.initialize= function()
	{
		this.tables = new Array();
	}
nitobi.data.DataSet.prototype.add= function(tableDataSource)
	{
		ntbAssert(!this.tables[tableDataSource.id], "This table data source has already been added.", '', EBA_THROW);
		this.tables[tableDataSource.id] = tableDataSource;
	}
nitobi.data.DataSet.prototype.getTable= function(tableId)
	{
		return this.tables[tableId];
	}
nitobi.data.DataSet.prototype.xmlDoc= function()
	{
		var root = this.doc.documentElement;
		while (root.hasChildNodes())
			root.removeChild(root.firstChild);
		for (var i in this.tables)
		{
			if (this.tables[i].xmlDoc && this.tables[i].xmlDoc.documentElement)
			{
				var cloned = this.tables[i].xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource').cloneNode(true);
				this.doc.selectSingleNode('/'+nitobi.xml.nsPrefix+'datasources').appendChild(nitobi.xml.importNode(this.doc, cloned, true));
			}
		}
		return this.doc;
	}
nitobi.data.DataSet.prototype.dispose= function()
	{
		for (var table in this.tables)
		{
			this.tables[table].dispose();
		}
	}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.data');

/**
 * The DataTable represents a client side XML based datasource.
 * @param {Boolean} estimateRowCount If true, the datatable will actively try and find the last row of data.
 * @param {AssociativeArray} saveHandlerArgs Extra arguments that are attached to the saveHandler.
 * @param {AssociativeArray} getHandlerArgs Extra arguments that are attached to the getHandler.
 * @param {Boolean} autoKeyEnabled True if the datatable expects to parse the response and adjust keys 
 * assigned by the db server.
 */
nitobi.data.DataTable = function(mode, estimateRowCount, saveHandlerArgs, getHandlerArgs, autoKeyEnabled)
{
	if (estimateRowCount == null)
	{
		ntbAssert(false,"Table needs estimateRowCount param");
	}
	this.estimateRowCount = estimateRowCount;
	this.version = 3.0;
	this.uid = nitobi.base.getUid();
	/**
	 * 
	 */
	this.mode = mode || "caching"; // Options: unbound | static | paging | caching
	
	this.setAutoKeyEnabled(autoKeyEnabled);

	this.columns = new Array();
	this.keys = new Array();
	this.types = new Array();
	this.defaults = new Array();

	this.columnsConfigured = false;
	this.pagingConfigured = false;
	
	this.id = '_default';
	this.fieldMap = {};
	if (saveHandlerArgs)
	{
		this.saveHandlerArgs = saveHandlerArgs;
	}
	else
	{
		this.saveHandlerArgs = {};
	}
	if (getHandlerArgs)
	{
		this.getHandlerArgs = getHandlerArgs;
	}
	else
	{
		this.getHandlerArgs = {};
	}
	
	this.setGetHandlerParameter("RequestType","GET");
	this.setSaveHandlerParameter("RequestType","SAVE");

	// We can do a batch insert by calling the beginBatchInsert() method. To finish the insert
	// the commitBatchInsert() method is called.
	this.batchInsert = false;
	this.batchInsertRowCount = 0;
}

nitobi.data.DataTable.DEFAULT_LOG = '<'+nitobi.xml.nsPrefix+'grid '+nitobi.xml.nsDecl+'><'+nitobi.xml.nsPrefix+'datasources id=\'id\'><'+nitobi.xml.nsPrefix+'datasource id="{id}"><'+nitobi.xml.nsPrefix+'datasourcestructure /><'+nitobi.xml.nsPrefix+'data id="_default"></'+nitobi.xml.nsPrefix+'data></'+nitobi.xml.nsPrefix+'datasource></'+nitobi.xml.nsPrefix+'datasources></'+nitobi.xml.nsPrefix+'grid>';

nitobi.data.DataTable.DEFAULT_DATA = '<'+nitobi.xml.nsPrefix+'datasource '+nitobi.xml.nsDecl+' id="{id}"><'+nitobi.xml.nsPrefix+'datasourcestructure FieldNames="{fields}" Keys="{keys}" types="{types}" defaults="{defaults}"></'+nitobi.xml.nsPrefix+'datasourcestructure><'+nitobi.xml.nsPrefix+'data id="{id}"></'+nitobi.xml.nsPrefix+'data></'+nitobi.xml.nsPrefix+'datasource>';

//
// CORE METHODS
//

/**
 * This method initializes the DataTable and gets it ready for use.
 * @param {string} tableId
 * @param {object} getHandler The getHandler argument can be either a String 
 * that is the URL of a server based datasource or an XML DOM Document.
 * @param {string} postHandler The postHandler argument is the URL of a server
 * resource that can be used to save changes to data in the client side DataTable
 * on the server.
 * @param {int} start The index of the first record in the DataTable.
 * @param {int} pageSize The pageSize argument specifies the default number of records
 * to return from any given request for data using the get method.
 * @param {string} sort The sort argument specifies the default field to sort by.
 * @param {string} sortDir The sortDir argument specifies the default direction of 
 * the data sorting.
 * @param {Function} onGenerateKey The onGenerateKey arguments is a reference
 * @param {string} filter The filter criteria for the data
 * to a function that is used to create record keys when new records are created in the DataTable.
 */
nitobi.data.DataTable.prototype.initialize = function(tableId, getHandler, postHandler, start, pageSize, sort, sortDir, onGenerateKey, filter) 
    {
//	When sort is called on this thing we need to clear the cachemap and start getting data a new
//	To return data from this what do we need to do???
//	For the grid we just return the data based on xi values which are the record numbers ...
//	We also need to consider the case where we dont page and just return it all!!!
//	that is the case for the lookup data sources
//	We need to grab the lookup data sources and merge those into the XSLT for displaying the data
		this.setGetHandlerParameter("TableId",tableId);
		this.setSaveHandlerParameter("TableId",tableId);
		this.id = tableId;

		this.datastructure = null;
		this.descriptor = new nitobi.data.DataTableDescriptor(this, nitobi.lang.close(this, this.syncRowCount),this.estimateRowCount);
		
		// Mode = unbound
		// Mode = static
		// Mode = paging
		this.pageFirstRow = 0; // Note: applies only to mode=paging
		this.pageRowCount = 0; // Note: applies only to mode=paging
		this.pageSize = pageSize;
		this.minPageSize = 10;

		// Mode = caching
		this.requestCache = new nitobi.collections.CacheMap(-1,-1);

		// Mode = paging or caching
		this.dataCache = new nitobi.collections.CacheMap(-1,-1); //Note: applies only to mode=caching

		this.flush();

		this.sortColumn = sort;
		this.sortDir = sortDir || 'Asc';

		this.filter = new Array();
		
		this.onGenerateKey = onGenerateKey;

		this.remoteRowCount = 0; //Note: applies to paging and caching modes
		this.setRowCountKnown(false); //Note: if row count is not known then external pageNext should increment startRow until less than pageSize rows are returned


		//	Check if start and or pageSize are null ...
		if (start == null)
			start = 0;

		if (this.mode != "unbound") {
			ntbAssert(getHandler!=null&&typeof(getHandler)!="undefined","getHandler is not specified for the nitobi.data.DataTable",'',EBA_THROW);
	
			if (getHandler != null)
			{
				this.ajaxCallbackPool = new nitobi.ajax.HttpRequestPool(nitobi.ajax.HttpRequestPool_MAXCONNECTIONS);
				this.ajaxCallbackPool.context = this;
				this.setGetHandler(getHandler);
				this.setSaveHandler(postHandler);
			}
			this.ajaxCallback = new nitobi.ajax.HttpRequest();
			this.ajaxCallback.responseType = "xml";
		} else {
			if (getHandler != null && typeof(getHandler) != "string")
			{
				// TODO: this is deprecated - call initializeColumns from outside and pass in the data ... 
				this.initializeXml(getHandler);
//				this.xmlDoc = getHandler;
//				ntbAssert(typeof(this.xmlDoc.xml)!="undefined","Valid XML required for new tabledatasource.",'',EBA_THROW);
				//	parse out the various things like the fields etc ...
//				this.datastructure = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\'' + this.id + '\']/'+nitobi.xml.nsPrefix+'datasourcestructure');
//				this.makeFieldMap();
			}
		}

		// TODO: Figure out how to remove paramters from XSLT's in IE then we can get rid of this...
		this.sortXslProc = nitobi.xml.createXslProcessor(nitobi.data.sortXslProc.stylesheet);

		this.requestQueue = new Array();
		
		/**
		 * Specifies if the requests to the server are synchronous or asynchronous by default.
		 */
		this.async = true;
}

/**
 * Set the onGenerateKey event handler.
 * @param {String} Javascript code that is evaluated to retrieve the new key.
 */
nitobi.data.DataTable.prototype.setOnGenerateKey = function(onGenerateKey)
{
	this.onGenerateKey = onGenerateKey;
}

/**
 * Returns the onGenerateKey event handler.
 * @return String Javascript code that is evaluated to retrieve the new key.
 */
nitobi.data.DataTable.prototype.getOnGenerateKey = function()
{
	return this.onGenerateKey;
}


/**
 * @private
 */
nitobi.data.DataTable.prototype.setAutoKeyEnabled = function(val)
{
	this.autoKeyEnabled = val;
}

/**
 * @private
 */
nitobi.data.DataTable.prototype.isAutoKeyEnabled = function()
{
	return this.autoKeyEnabled;
}


/**
 * Initializes a DataTable based on the fields, keys, defaults and types arrays.
 * @param {object} xml XML data from which the DataTable can be initialized.
 */
nitobi.data.DataTable.prototype.initializeXml = function(oXml)
{
	this.replaceData(oXml);
	
	// in the case that the xml also has actual data in it (not just schema)
	// then we need to setup the data
	var rows = this.xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'e').length;
	if (rows>0)
	{
		// TODO: Fix this to string then loading the xml crap
		var s = this.xmlDoc.xml;
//		if (this.mode != "paging")
//		{
			s = nitobi.xml.transformToString(this.xmlDoc, this.sortXslProc, "xml");
//		}
		this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, s);

		this.dataCache.insert(0, rows-1);
		if (this.mode == 'local')
		{
			this.setRowCountKnown(true);
		}
	}

	// TODO: this should be integrated back into the descriptor
	this.setRemoteRowCount(rows);

	this.fire("DataInitalized");

	// Set total row count from the xml field
	var totalRowCount = this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("totalrowcount");
	totalRowCount = parseInt(totalRowCount);
			
	if (!isNaN(totalRowCount))
	{
		this.totalRowCount = totalRowCount;
	}
	
	// TODO: Should fire an event here to notify all interested parties that we have
	// all the rows
	this.fire("TotalRowCountReady", this.totalRowCount);	
	
}

/**
 * Loads valid XML data from either a string or an XML document in the Nitobi Grid format. The data must have 
 * &lt;ntb:grid&gt; and &lt;ntb:datasources&gt; tags.
 * @param {String | XmlDocument} oXml Either a string or XML document of valid XML.
 * @private
 */
nitobi.data.DataTable.prototype.initializeXmlData = function(oXml)
{
	var sXml = oXml;
	// accept either an xml doc or a string of xml
	if (typeof(oXml) == "object")
	{
		sXml = oXml.xml;
	}

	// load up the xml
	sXml = sXml.replace(/fieldnames=/g,"FieldNames=").replace(/keys=/g,"Keys=")//.replace(/defaults=/g,"Defaults=").replace(/types=/g,"Types=");
	this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, sXml);

	this.datastructure = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\'' + this.id + '\']/'+nitobi.xml.nsPrefix+'datasourcestructure');
}

nitobi.data.DataTable.prototype.replaceData = function(oXml)
{
	this.initializeXmlData(oXml);

	// get the datasroucestructure information to initialize the column 
	// array definitions
	var fields = this.datastructure.getAttribute("FieldNames");
	var keys = this.datastructure.getAttribute("Keys");
	var defaults = this.datastructure.getAttribute("Defaults");
	var types = this.datastructure.getAttribute("Types");

	// initialize the columns with that data specified in the xml schema.
	this.initializeColumns(fields,keys,types,defaults);
}

/**
 * Initializes the DataTable xmlDoc from the default structure with the 
 * defined fields from the this.columns property. Columns and keys are generally
 * first defined by calling initializeColumns.
 */
nitobi.data.DataTable.prototype.initializeSchema = function()
{
	var fields = this.columns.join("|");
	var keys = this.keys.join("|");
	var defaults = this.defaults.join("|");
	var types = this.types.join("|");

	this.dataCache.flush();
	this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, nitobi.data.DataTable.DEFAULT_DATA.replace(/\{id\}/g,this.id).replace(/\{fields\}/g,fields).replace(/\{keys\}/g,keys).replace(/\{defaults\}/g,defaults).replace(/\{types\}/g,types));

	this.datastructure = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\'' + this.id + '\']/'+nitobi.xml.nsPrefix+'datasourcestructure');
}

/**
 * Defines the columns structure for the table including keys, datatypes and initial default values when rows are inserted.
 * @param {string} fields A pipe ("|") separated list of fields that are in the Datasource
 * @param {string} keys A pipe ("|") separated list of the key fields in the Datasource
 * @param {string} types A pipe ("|") separated list of the field types in the Datasource
 * @param {string} default A pipe ("|") separated list of the default values for each of the fields in the Datasource
 */
nitobi.data.DataTable.prototype.initializeColumns = function(fields,keys,types,defaults)
{
	if (null != fields) 
	{
		// check if we are actually changing the columns
		// if not then just return as there is no need
		var sColumns = this.columns.join('|');
		if (sColumns == fields)
			return;
		this.columns = fields.split("|");
	}
	if (null != keys)
	{
		this.keys = keys.split("|");
	}
	if (null != types)
	{
		this.types = types.split("|");
	}
	if (null != defaults)
	{
		this.defaults = defaults.split("|");
	}
	// if the xmldoc is null then we have not been called from inisitalizeXml ...
	// this seems a bit weird
	if (this.xmlDoc.documentElement == null) {
		// initializeSchema will use the internal columns etc arrays as defined just above.
		this.initializeSchema();
	}
	// not really any need to set the datastructure pointer as it should alreay be set.
	this.datastructure = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\'' + this.id + '\']/'+nitobi.xml.nsPrefix+'datasourcestructure');
	var ds = this.datastructure;
	if (fields) ds.setAttribute("FieldNames",fields);
	if (keys) ds.setAttribute("Keys",keys);
	if (defaults) ds.setAttribute("Defaults",defaults);
	if (types) ds.setAttribute("Types",types);

//	this.flush();
//	this.initializeXml(xml);
	this.makeFieldMap();
	this.fire("ColumnsInitialized");
}
/**
 * Creates a prototype xml node for use in insert operations
 * @param {array} values An array of values used as the new node. Optional.  If this is
 * not specified, the defaults are used instead.
 * @returns {XMLNode} Returns the XMLNode that can be used to insert data into the DataTable.
 */
nitobi.data.DataTable.prototype.getTemplateNode = function(values)
{
	var templateNode = null;
	if (values == null)
	{
		values=this.defaults;
	}

	templateNode = nitobi.xml.createElement(this.xmlDoc, "e");
	for (var i=0;i<this.columns.length;i++) {
		var keyAttribute = (i>25?String.fromCharCode(Math.floor(i/26)+97):"")+(String.fromCharCode(i%26+97));
		if (this.defaults[i] == null)
		{
		    templateNode.setAttribute(keyAttribute,"");
		}
		else
		{
		    templateNode.setAttribute(keyAttribute,this.defaults[i]);
		}
	}
	return templateNode;
}


/**
 * Clear the data and data log.
 * @public
*/
nitobi.data.DataTable.prototype.flush = function()
{
	// TODO: This should be here but causes some unknowns 
	// regarding the refresh function.
	//this.descriptor.reset();
	this.flushCache();
	this.flushLog();
	this.xmlDoc = nitobi.xml.createXmlDoc();
}

/**
 * Clears the cache, flushes the log and clears the data.  Differs
 * from {@link #flush} in that it will not reset the data to a blank
 * XML document, but simply clear the data from the existing XML document.
 * @private
 */
nitobi.data.DataTable.prototype.clearData = function()
{
	this.flushCache();
	this.flushLog();
	if (this.xmlDoc)
   	{
   		var parentDataNode = this.xmlDoc.selectSingleNode("//ntb:data");
   		nitobi.xml.removeChildren(parentDataNode);
   	}
}

/**
 * Clears out the data and request caches.
 * @private
 */
nitobi.data.DataTable.prototype.flushCache = function()
{
	if (this.mode=="caching" || this.mode=="paging")
		this.dataCache.flush();
	if (this.mode!="unbound")
		this.requestCache.flush();
}

/**
 * join
 * @private
 */
nitobi.data.DataTable.prototype.join = function(start, pageSize, otherDataSource, field)
	{
	}
/**
 * merge - see mergeFromXml
 * @private
 */
nitobi.data.DataTable.prototype.merge = function(xd)
	{
	}

/**
 * Returns the data residing in the specified row at the specified column.
 * @param {Number} index The row index.
 * @param {String} columnName The name of the column.
 */	
nitobi.data.DataTable.prototype.getField = function(index, columnName)
{
	var r = this.getRecord(index);
	var a = this.fieldMap[columnName];
	if (a && r)
	{
		return r.getAttribute(a.substring(1));
	}
	else
	{
		return null;
	}
};
 
/**
 * Returns the requested record from the DataTable.
 * @param {Number} index The index of the requested record in the DataTable.
 * @returns {XmlElement} Returns the XML element from the DataTable.
 */
nitobi.data.DataTable.prototype.getRecord = function(index)
{
	var data = this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xi='" + index + "']");
	if (data.length == 0)
	{
		return null;
	}
	return data[0];
}

/**
 * Starts a batch insert. After calling beginBatchInsert no events will be fired due to insert 
 * events until commitBatchInsert is called.
 */
nitobi.data.DataTable.prototype.beginBatchInsert = function()
{
	this.batchInsert = true;
	this.batchInsertRowCount = 0;
}
/**
 * Ends a batch insert. The RowInserted event will be fired if there were any rows inserted after 
 * beginBatchInsert was called and before commitBatchInsert is called.
 */
nitobi.data.DataTable.prototype.commitBatchInsert = function()
{
	// TODO: this should change so that the createRecord method will not actually
	// do the insert in batch mode but instead create a list of all the records to 
	// create and then use some xsl.
	this.batchInsert = false;
	var insertedRowCount = this.batchInsertRowCount;
	this.batchInsertRowCount = 0;

	this.setRemoteRowCount(this.remoteRowCount+insertedRowCount);

	if (insertedRowCount > 0)
	{
		this.fire("RowInserted", insertedRowCount);
	}
}

/**
 * Creates a new row record in the table
 * @param {XMLNode} templateNode A prototype of the row record that contains the structure and defaults for the new row.
 * @param {int} rowIndex Index of the row to insert after.
 * @returns {XMLNode} Returns the newly inserted XMLNode.
 */
nitobi.data.DataTable.prototype.createRecord = function(templateNode, rowIndex)
{
  	var xi = rowIndex;
	this.adjustXi(parseInt(xi), 1);

	var data = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	var rowDataTemplate = templateNode || this.getTemplateNode();
	
	var lastXid = nitobi.component.getUniqueId()
	var xNode = rowDataTemplate.cloneNode(true);
	xNode.setAttribute("xi", xi);
	xNode.setAttribute("xid", lastXid);
	xNode.setAttribute("xac", "i");

	// If a key generation function is specified, add keys to the key fields in 
	// the grid and in the updategram
	if (this.onGenerateKey)
	{
		var keyCols = this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("Keys").split("|");
		var xml = null;
		for (var j=0; j < keyCols.length; j++)
		{
			var keyField = this.fieldMap[keyCols[j]].substring(1);
			var keyValue = xNode.getAttribute(keyField);
			/*
			* I added undefined here, since this is the value that is passed
			* when the xk column isn't set.
			*/
			if (!keyValue || keyValue == "")
			{
				if (!xml)
				{
					xml = eval(this.onGenerateKey);
				}
				if (typeof(xml) == 'string' || typeof(xml) == 'number')
				{
					xNode.setAttribute(keyField, xml);
				}
				else
				{
					try 
					{
						var ck1 = j%26;
						var ck2 = Math.floor(j/26);
						var keyAttribute = (ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
						xNode.setAttribute(keyField, xml.selectSingleNode("//"+nitobi.xml.nsPrefix+"e").getAttribute(keyAttribute));
					}
					catch (e)
					{
						ntbAssert(false,"Key generation failed.",'',EBA_THROW);
					}
				}
			}
		}
	}

	data.appendChild(nitobi.xml.importNode(data.ownerDocument, xNode, true));
	
	if (this.log !=null)
	{
		var xLogNode = xNode.cloneNode(true);
		xLogNode.setAttribute("xac", "i");
		xLogNode.setAttribute("xid", lastXid);

		this.logData.appendChild(nitobi.xml.importNode(this.logData.ownerDocument,xLogNode, true));
	}

	this.dataCache.insertIntoRange(rowIndex);	

	this.batchInsertRowCount ++;

	if (!this.batchInsert)
	{
		// If we are not doing a batch insert then just call commitBatchInsert 
		// which will increment the row count and fire the rowinserted event
		this.commitBatchInsert();
	}

	return xNode;
}
/**
 * Updates a single column value for a single record in the table. If AutoSave is true then updates will automatically be sent to the server.
 * @param {int} xi The index of the row to update.
 * @param {string} field Name of the column to be updated.
 * @param {string} value New value for the field.
 */
nitobi.data.DataTable.prototype.updateRecord = function(xi, field, value)
{
	// todo refactor this into a new method or object
	var editedNode = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@xi=\'' + xi + '\']');

    ntbAssert((null != editedNode),'Could not find the specified node in the data source.\nTableDataSource: '+this.id+'\nRow: '+xi,'',EBA_THROW);
    var xid = editedNode.getAttribute("xid") || "error - unknown xid";
    ntbAssert(("error - unknown xid" != xid),'Could not find the specified node in the update log.\nTableDataSource: '+this.id+'\nRow: '+xi,'',EBA_THROW);

	// TODO: this delta only checks for if the delta exists based on the field 
	// argument being an ebaxml attribute name not a friendly name.
	var deltaExists 	= (editedNode.getAttribute(field) != value);

	if(!deltaExists)
	{
		//no changes made
		return;
	}

	// we found the row node that contains the updated cell	
	// What happens if the row is deleted?

	var oldValue = "";
	var mappedField = field;
	//	Check if the field name provided actually exists on the node
	if (editedNode.getAttribute(field) == null && this.fieldMap[field] != null)
		mappedField = this.fieldMap[field].substring(1)

	oldValue = editedNode.getAttribute(mappedField);
	editedNode.setAttribute(mappedField, value);

	// if null create the new row and set xac to i
	var rowXacAttr = "u"; // for updategram
	var columnXacAttr = "u"; // for updategram

	/**
		we want the updategram to be created and assigned to this.log
		The following format will be used:
		<root> <data id="_default">

				<e a="Cat and dogs" xi="0" xac="u" />
		</data>
		<gridmeta id="_defaultDataModel?" numcols="1" numrows="1">
		</gridmeta>
		</root>
	*/
	// if null then we need to assign this.log to a new xml doc 

	if(null == this.log)
		this.flushLog();

	var updatedNode = editedNode.cloneNode(true);

	updatedNode.setAttribute("xac","u");

	// TODO: consider if we need to check for a delete before setting the xac attribute to update

	this.logData = this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');

	// This will get the node in the DataTable log with the given xi - if it exists
	var logNode = this.logData.selectSingleNode('./'+nitobi.xml.nsPrefix+'e[@xid=\''+xid+'\']');

	updatedNode = nitobi.xml.importNode(this.logData.ownerDocument, updatedNode, true);

	if(null == logNode)
	{
		// If there is not already a node in the log for this xi then append the cloned data node
		updatedNode = nitobi.xml.importNode(this.logData.ownerDocument, updatedNode, true);
		this.logData.appendChild(updatedNode);
		updatedNode.setAttribute("xid",xid);
	}
	else
	{
		// keep the old xac value  This makes sure that "d" and "i" are not replaced by "u"
		updatedNode.setAttribute("xac", logNode.getAttribute("xac"));
		this.logData.replaceChild(updatedNode, logNode);
	}

	//now update the value
	if((true == this.AutoSave)) // also need to check for metadata deltas && deltaExists)	
	{
		this.save();
	}

	this.fire("RowUpdated", {"field":field,"newValue":value,"oldValue":oldValue,"record":updatedNode});
}
/**
 * Deletes a single row from the table.
 * @param index The index of the row to be deleted.
 */
nitobi.data.DataTable.prototype.deleteRecord = function(index)
{
	var data = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	this.logData = this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	// Delete the XML Data node.
	var xNode = data.selectSingleNode("*[@xi = '"+index+"']");

	this.removeRecordFromXml(index, xNode, data);

	this.setRemoteRowCount(this.remoteRowCount-1);

	this.fire("RowDeleted");
}

/**
 * 
 * @param indices - sorted array of indices of records to delete
 */
nitobi.data.DataTable.prototype.deleteRecordsArray = function(indices)
{
	var data = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	this.logData = this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	// Delete the XML Data node.
	var xNode = null;
	var index = null;
	
	for (var i=0; i<indices.length; i++) {
		var data = this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
		index = indices[i] - i;
		xNode = data.selectSingleNode("*[@xi = '"+index+"']");
		this.removeRecordFromXml(index, xNode, data);
	}

	this.setRemoteRowCount(this.remoteRowCount-indices.length);

	this.fire("RowDeleted");	
}

/**
 * Private - Refactored out to delete individual records, so it can be used for array
 */
nitobi.data.DataTable.prototype.removeRecordFromXml = function(index, xNode, data)
{
	if (xNode == null)
	{
		throw "Index out of bounds in delete.";
	}
	
	// Check the updategram log to see if this cell is already in there.
	// If it was an inserted record, delete the Insert log entry, otherwise make a note
	// in the log that this record was deleted.
	var xid = xNode.getAttribute("xid");
	var xDel = this.logData.selectSingleNode("*[@xid='" + xid + "']");
	var sTag="";
	// refactor replaceChild could make this code cleaner
	if (xDel != null) {
		sTag = xDel.getAttribute("xac");
		this.logData.removeChild(xDel);
	}
	if (sTag != "i") {
		var xDelNode = xNode.cloneNode(true);
		xDelNode.setAttribute("xac", "d");
		this.logData.appendChild(xDelNode);
	}
	
	data.removeChild(xNode);

	this.adjustXi(parseInt(index)+1, -1);

	this.dataCache.removeFromRange(index);	
}

/**
 * Adjusts the XI's of all records after the specified record by some adjustment value.
 * @param {Number} iStart The start index to increment / decrement XI values from.
 * @param {Number} iAdjust The number by which to increment / decrement the XI values.
 */
nitobi.data.DataTable.prototype.adjustXi = function(iStart, iAdjust)
{
	nitobi.data.adjustXiXslProc.addParameter("startingIndex",iStart,"");
	nitobi.data.adjustXiXslProc.addParameter("adjustment",iAdjust,"");
	this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, nitobi.xml.transformToString(this.xmlDoc, nitobi.data.adjustXiXslProc, "xml"));
	if (this.log != null)
	{
		this.log = nitobi.xml.loadXml(this.log, nitobi.xml.transformToString(this.log, nitobi.data.adjustXiXslProc, "xml"));
		this.logData = this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
	}
}

/**
 * The URL to which get requests will be sent.
  @param {string} val The URL.
 */
nitobi.data.DataTable.prototype.setGetHandler = function(val)
{
	this.getHandler = val;
	for(var name in this.getHandlerArgs)
	{
		this.setGetHandlerParameter(name,this.getHandlerArgs[name]);
	}
}

/**
 * The URL to which get requests will be sent.
  @return string The URL.
 */
nitobi.data.DataTable.prototype.getGetHandler = function()
{
	return this.getHandler;
}


/**
 * The URL to which save requests will be sent.
  @param {string} val The URL.
 */
nitobi.data.DataTable.prototype.setSaveHandler = function(val)
{
	this.postHandler = val;
	for(var name in this.saveHandlerArgs)
	{
		this.setSaveHandlerParameter(name,this.saveHandlerArgs[name]);
	}
}

/**
 * The URL to which save requests will be sent.
  @return string The URL.
 */
nitobi.data.DataTable.prototype.getSaveHandler = function()
{
	return this.postHandler;
}


/**
 * Commits the changes in the log back to the remote save handler. This method will generate 
 * keys for inserted rows, convert the data format to match the old backend, send the data
 * to the server asynchronously.
 * @param {Function} callback The function to be called when data has been saved to the server.
 * @param {string} beforeSaveEvent JavaScript code to be evaluated before proceeding with the save.
 */
nitobi.data.DataTable.prototype.save = function(callback, beforeSaveEvent)
	{

		//	Send the updates to the server now...

   		//
  		// the updategram is retained but save operation is postponed.
  		// This will means the client and server are now split brain
		// 
  		//
  		// It is best if a get from the server is done to ensure the
  		// client grid is consistent
  		
  		//	TODO: Maybe this should be elsewehre???

/*
		this.subscribe("BeforeSave",beforeSaveEvent); // this is wierd... passing in the function to call as a parameter
		if (!this.fire("BeforeSave")) {
			return;
		}
*/

		ntbAssert(this.postHandler!=null && this.postHandler != "",'A postHandler must be defined on the DataTable for saving to work.','',EBA_THROW);

		if (!eval(beforeSaveEvent || "true"))
		{
			return;
		}

		try
		{

			//	Check which version of the backend we are using ...
			if (this.version == 2.8)
			{
				//	That means we are using the old backend ...
				var fields = this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("FieldNames").split("|");
				var insertNodes = this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac = 'i']");
				for (var i = 0; i < insertNodes.length; i++)
				{
					for (var j = 0; j < fields.length; j++)
					{
						var currentValue = insertNodes[i].getAttribute(this.fieldMap[fields[j]].substring(1));
						if (!currentValue)
						{
							insertNodes[i].setAttribute(this.fieldMap[fields[j]].substring(1),"");
						}
					}
					insertNodes[i].setAttribute("xf", this.parentValue);

				}
				var updateNodes = this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac = 'u']");
				for (var i = 0; i < updateNodes.length; i++)
				{
					for (var j = 0; j < fields.length; j++)
					{
						var currentValue = updateNodes[i].getAttribute(this.fieldMap[fields[j]].substring(1));
						if (!currentValue)
						{
							updateNodes[i].setAttribute(this.fieldMap[fields[j]].substring(1),"");
						}
					}
				}

				nitobi.data.updategramTranslatorXslProc.addParameter('xkField', this.fieldMap['_xk'].substring(1), '');
				nitobi.data.updategramTranslatorXslProc.addParameter('fields', fields.join("|").replace(/\|_xk/,""));
				nitobi.data.updategramTranslatorXslProc.addParameter("datasourceId", this.id, "");
				this.log = nitobi.xml.transformToXml(this.log, nitobi.data.updategramTranslatorXslProc);
			}
			// After this point, this.log can be in the old format or the new format, be careful.

			var postHandler = this.getSaveHandler();
			//	TODO: this should be a handlerResolver object or something ...
			(postHandler.indexOf('?') == -1) ? postHandler += '?' :  postHandler += '&';
			// TODO: Need this id.
			//postHandler += 'GridId=' + '&';
			postHandler += 'TableId=' + this.id;
			postHandler += '&uid=' + (new Date().getTime());

  			this.ajaxCallback = this.ajaxCallbackPool.reserve();


			ntbAssert(Boolean(this.ajaxCallback),"The datasource is serving too many connections. Please try again later. # current connections: " + this.ajaxCallbackPool.inUse.length );
			this.ajaxCallback.handler = postHandler;
			this.ajaxCallback.responseType = "xml";
			this.ajaxCallback.context = this;
			this.ajaxCallback.completeCallback = nitobi.lang.close(this,this.saveComplete);
			//this.ajaxCallback.onPostComplete.subscribeOnce(this.saveComplete, this);
			this.ajaxCallback.params = new nitobi.data.SaveCompleteEventArgs(callback);

			if (this.version > 2.8 && this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac='i']").length > 0 && this.isAutoKeyEnabled())
			{
				this.ajaxCallback.async = false;
			}
			
			if (this.log.documentElement.nodeName == "root")
			{
				this.log = nitobi.xml.loadXml(this.log, this.log.xml.replace(/xmlns:ntb=\"http:\/\/www.nitobi.com\"/g,""));
				
				var fields = this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("FieldNames").split('|');
				fields.splice(fields.length-1,1);
				fields = fields.join('|');
				this.log.documentElement.setAttribute("fields",fields);
				this.log.documentElement.setAttribute("keys",fields);
			}

			if (this.isAutoKeyEnabled() && this.version < 3)
			{
				//console.log("AutoKey is not supported in this schema version. You must upgrade to Nitobi Grid Xml Schema version 3 or greater.");
			}
			
			this.ajaxCallback.post(this.log);
			this.flushLog();
		}
		catch(err)
		{
			throw err;
  			//_ntbAssert(false,"save : " + err.message);
		}

	}
/**
 * Clears the log.
 */
nitobi.data.DataTable.prototype.flushLog = function()
{
	//	TODO: integrate the response back into our client model
	//	For now we can leave it at assuming all operations succesful ...
	//	so clear the log and the response should just be the new grid xml
	this.log = nitobi.xml.createXmlDoc(nitobi.data.DataTable.DEFAULT_LOG.replace(/\{id\}/g,this.id).replace(/\{fields\}/g,this.columns).replace(/\{keys\}/g,this.keys).replace(/\{defaults\}/g,this.defaults).replace(/\{types\}/g,this.types));
	this.logData = this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data');
}

/**
 * @private
 * Takes all the inserts from a server insert and 
 * sets the keys for autokey
 * @param {XmlDocument} xmlDoc The xml document from the server.
 */
nitobi.data.DataTable.prototype.updateAutoKeys = function(xmlDoc)
{

	try
	{
		var inserts = xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e[@xac=\'i\']');
		if (typeof(inserts) == "undefined" || inserts == null)
		{
			nitobi.lang.throwError("When updating keys from the server for AutoKey support, the inserts could not be parsed.");
		}
		var keys = xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+"datasourcestructure")[0].getAttribute("keys").split("|");
		if (typeof(keys) == "undefined" || keys == null || keys.length == 0)
		{
			nitobi.lang.throwError("When updating keys from the server for AutoKey support, no keys could be found. Ensure that the keys are sent in the request response.");
		}
		for (var i = 0; i < inserts.length; i++)
		{
			var record = this.getRecord(inserts[i].getAttribute("xi"));
			for (var j = 0; j < keys.length; j++)
			{
				var att = this.fieldMap[keys[j]].substring(1);
				record.setAttribute(att, inserts[i].getAttribute(att));
			}
		}
	}	
	catch(err)
	{
		nitobi.lang.throwError("When updating keys from the server for AutoKey support, the inserts could not be parsed.", err);
	}
}

/**
 * Handles the response from the save handler.
 * @param {XMLDocument} xd An XMLDocument containing the response from the save handler
 * @param {nitobi.data.SaveCompleteEventArgs} evtArgs Event arguments
 * @private
 */
nitobi.data.DataTable.prototype.saveComplete = function(evtArgs)
	{
		var xd = evtArgs.response;
		var evtArgs = evtArgs.params;
		// TODO: Empty try catch.

		try
		{
			if (this.isAutoKeyEnabled() && this.version > 2.8)
			{
				this.updateAutoKeys(xd);
			}
			if (this.version == 2.8 && !this.onGenerateKey)
			{
				var rows = xd.selectNodes("//insert");
				for (var i=0; i < rows.length; i++)
				{
					var xk = rows[i].getAttribute("xk");
					if (xk != null)
					{
						var record = this.findWithoutMap("xid", rows[i].getAttribute("xid"))[0];
						var key = this.fieldMap["_xk"].substring(1);
						record.setAttribute(key, xk);
						if (this.primaryField != null && this.primaryField.length > 0)
						{
							var primarykey = this.fieldMap[this.primaryField].substring(1);
							record.setAttribute(primarykey, xk);
						}
					}
				}
			}
			if(null != evtArgs.result)
			{
				ntbAssert((null == errorMessage), "Data Save Error:" + errorMessage, EBA_EM_ATTRIBUTE_ERROR, EBA_ERROR);
			}
			
			var node = xd.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource') || xd.selectSingleNode('/root');
			var e = null;
			if (node)
			{
				e = node.getAttribute('error');
			}
			if (e)
			{
				this.setHandlerError(e);
			}
			else
			{
				this.setHandlerError(null);
			}
			this.ajaxCallbackPool.release(this.ajaxCallback);
			var afterSaveArgs = new nitobi.data.OnAfterSaveEventArgs(this, xd); 
			evtArgs.callback.call(this, afterSaveArgs);
			//	TODO: need to restore state - ie set focus on the appropriate cell ...		
		}
		catch(err)
		{
			this.ajaxCallbackPool.release(this.ajaxCallback);
			ebaErrorReport(err,"",EBA_ERROR);
		}
	}
/**
 * Makes a hash for relating column names to XML nodes in the data.
 */
nitobi.data.DataTable.prototype.makeFieldMap = function()
	{
		var oXMLs=this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource');
		var cf = 0;
		var ck = 0;
		this.fieldMap = new Array();

		//	This needs to be changed to transform some XML into JavaScript that is then eval'ed ...

		var cF = this.columns.length;

		for (var i=0; i<cF; i++) 
		{
			var fname = this.columns[i];
			this.fieldMap[fname] = this.getFieldName(ck);
			ck++;
		}
	}

/**
 * Returns the XPath for the column data at the given column index.
 */
nitobi.data.DataTable.prototype.getFieldName = function(columnIndex) 
{
	var ck1 = columnIndex%26;
	var ck2 = Math.floor(columnIndex/26);
	return "@"+(ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
}
/**
 * Returns the set of records with the given value at the given field.
 * @param {String} fieldName the field to search at
 * @param {String} value the value to search for
 * @type Array
 */
nitobi.data.DataTable.prototype.find = function(fieldName, value)
{
	var field = this.fieldMap[fieldName];
	if (field)
	{
		return this.findWithoutMap(field,value);
	}
	else
	{
		return new Array();
	}
};
/**
 * @private
 */
nitobi.data.DataTable.prototype.findWithoutMap = function(field, value)
{
	if (field.charAt(0) != "@")
		field = "@"+field;
	return this.xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'e['+field+'="'+value+'"]');
};

/**
 * Performs a local sort of the data
 * Note: This way of sorting is only useful when we have all the data residing in the XML, otherwise data should be sorted remotely
 * @param {String} column the identifier of the column to sort by
 * @param {String} dir the direction to sort 'Desc'|'Asc'
 * @param {String} type the type of sort to perform 'number'|'text'
 * @param {Boolean} local whether the sort is local or remote - if remote, the column 
 * and direction will be set for the next server request
 * @public
 */
nitobi.data.DataTable.prototype.sort = function(column,dir,type,local)
{
	if (local)
	{
		//this.filter = null;
		column = this.fieldMap[column];
		column = column.substring(1);
		dir = (dir=="Desc")?"descending":"ascending";
		type = (type=="number")?"number":"text";
		this.sortXslProc.addParameter("column",column,"");
		this.sortXslProc.addParameter("dir",dir,"");
		this.sortXslProc.addParameter("type",type,"");
		this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, nitobi.xml.transformToString(this.xmlDoc, this.sortXslProc, "xml"));
		this.fire("DataSorted");
	}
	else
	{
		this.sortColumn = column;
		this.sortDir = dir || 'Asc';
	}
}

/**
 * Sets the number of rows that are in the remote datasource 
 * Note: We consider adding rows locally to increase the remote datasource size even if they haven't been saved yet. Same true for deletes
 * @private
 */
nitobi.data.DataTable.prototype.syncRowCount = function()
{
	this.setRemoteRowCount(this.descriptor.estimatedRowCount);
}
/**
 * Sets the number of rows that are in the remote datasource 
 * Note: We consider adding rows locally to increase the remote datasource size even if they haven't been saved yet. Same true for deletes
 * @private
 */
nitobi.data.DataTable.prototype.setRemoteRowCount = function(rows)
{
	var previousCount = this.remoteRowCount;
	this.remoteRowCount = rows;
  	if (this.remoteRowCount != previousCount) {
		this.fire("RowCountChanged",rows);
  	}
}
/**
 * Gets the number of rows that are in the remote datasource 
 * Note: We consider adding rows locally to increase the remote datasource size even if they haven't been saved yet. Same true for deletes
 * @public
 * @returns {int}
 */
nitobi.data.DataTable.prototype.getRemoteRowCount = function()
{
	return this.remoteRowCount;
}
/**
 * Returns the number of rows that are actually in the local recordset. This number is not used in caching mode.
 * @returns {int}
 */
nitobi.data.DataTable.prototype.getRows = function()
{
	return this.xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e').length;
}

nitobi.data.DataTable.prototype.getXmlDoc = function()
{
	return this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']');
}
	
/**
 * @private
 */
nitobi.data.DataTable.prototype.getRowNodes = function()
{
	return this.xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e');
}
/**
 * Returns the number of columns in the DataTable.
 * @returns {int}
 */
nitobi.data.DataTable.prototype.getColumns = function()
	{
		return this.fieldMap.length;
	}


		
	
/**
 * Appends the given parameter to the GetHandler value when requests for data are made to the server.
 * @param {string} name The name of the parameter to be appended to the querystring.
 * @param {string} value The value of the parameter to be appended to the querystring.
 */
nitobi.data.DataTable.prototype.setGetHandlerParameter = function(name, value)
{
	if (this.getHandler != null && this.getHandler != "")
	{
		this.getHandler = nitobi.html.setUrlParameter(this.getHandler,name,value);
	}
	this.getHandlerArgs[name] = value;
}

/**
 * Appends the given parameter to the SaveHandler value when requests for data are made to the server.
 * @param {string} name The name of the parameter to be appended to the querystring.
 * @param {string} value The value of the parameter to be appended to the querystring.
 */
nitobi.data.DataTable.prototype.setSaveHandlerParameter = function(name, value)
{
	if (this.postHandler != null && this.postHandler != "")
	{
		this.postHandler = nitobi.html.setUrlParameter(this.getSaveHandler(),name,value);
	}
	this.saveHandlerArgs[name] = value;
}

/**
 * Returns the number of entries in the change log.
 * @returns {int}
 */
nitobi.data.DataTable.prototype.getChangeLogSize = function()
{
	if (null == this.log)
	{
		return 0;
	}
	return this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e").length;
}

/**
 * Returns the change log XML document.
 * @returns {XMLDocument}
 */
nitobi.data.DataTable.prototype.getChangeLogXmlDoc = function()
{
	return this.log;	
}

/**
 * Returns the data in the DataTable as an XML document.
 * @returns {XMLDocument}
 */
nitobi.data.DataTable.prototype.getDataXmlDoc = function()
{
	return this.xmlDoc;
}

/**
 * @ignore
 */
nitobi.data.DataTable.prototype.dispose = function()
{
	this.flush();
	this.ajaxCallbackPool.context = null;

	for (var item in this)
	{
		if (this[item] != null && this[item].dispose instanceof Function)
			this[item].dispose();
		this[item] = null;
	}
}


//
// BOUND
//
/**
 * Makes a request to the server with no start or pagesize parameters.
 * @param {object} context
 * @param {function} callback
 * @param {function} errorCallback
 * @public
 */
nitobi.data.DataTable.prototype.getTable = function(context, callback, errorCallback)
{
	this.errorCallback = errorCallback;

	var ajaxCallback = this.ajaxCallbackPool.reserve();

	ntbAssert(Boolean(ajaxCallback),"The datasource is serving too many connections. Please try again later. # current connections: " + this.ajaxCallbackPool.inUse.length );

	// This is an editor's gethandler
	var getHandler = this.getGetHandler();
	ajaxCallback.handler = getHandler;
	ajaxCallback.responseType = "xml";
	ajaxCallback.context = this;
	ajaxCallback.completeCallback = nitobi.lang.close(this,this.getComplete);
//	ajaxCallback.onGetComplete.subscribeOnce(this.getComplete, this);
	// TODO: Is this right, 4th null. What is the pagesize here?
	ajaxCallback.async = this.async;
	// StartXi is supposed to 0 in a getTable request ... when are these even used?
	ajaxCallback.params = new nitobi.data.GetCompleteEventArgs(null, null, 0, null,ajaxCallback, this, context, callback);

	if (typeof(callback) != 'function' || this.async == false)
	{
		ajaxCallback.async = false;
		return this.getComplete({"response":ajaxCallback.get(), "params":ajaxCallback.params});
	}
	else
	{
		ajaxCallback.get();
	}
			
}

/**
 * This function is executed as the callback function when data has returned from the paging request.
 * This method will check the response for validity, check the data format for backwards compatibility, 
 * create a new XML doc if necessary, adjust the row #'s (xi's), remove the range from the request cache,
 * update the cachemap.
 * @param {XmlElement} xd The xml document payload returned by the paging request
 * @param {nitobi.data.GetCompleteEventArgs} getCompleteEvtArgs The event arguments such as startXi returned along with the response payload
 */
nitobi.data.DataTable.prototype.getComplete = function(evtArgs)
{
	var xd = evtArgs.response;
	var getCompleteEvtArgs = evtArgs.params;
	
		// Used only by mode != unbound
		if (this.mode!="caching") //(this.id != "_default")
		{
			// Clear existing data if mode is non-caching
			this.xmlDoc=nitobi.xml.createXmlDoc();
		}
		if (null == xd || null == xd.xml || '' == xd.xml)
		{
			var error = "No parse error.";
			if (nitobi.xml.hasParseError(xd))
			{
			    if (xd == null)
			    {
			        error = "Blank Response was Given";
			    }
			    else
			    {
				    error = nitobi.xml.getParseErrorReason(xd);
				}				   
			}
			ntbAssert(null!=this.errorCallback,"The server returned either an error or invalid XML but there is no error handler in the DataTable.\nThe parse error content was:\n"+error);
			if (this.errorCallback)	
			{
				this.errorCallback.call(this.context);
			}
			this.fire("DataReady",getCompleteEvtArgs);
			return getCompleteEvtArgs;
		}
		else
		{
			if (typeof(this.successCallback) == 'function')
			{
				this.successCallback.call(this.context);
			}
		}
		// If this is our firstf encounter with the data then autoconfigure the datatable parameters (paging stuff, columns, #rows, etc)
		if (!this.configured) {
			this.configureFromData(xd);
		}
		xd = this.parseResponse(xd, getCompleteEvtArgs);
		
		xd = this.assignRowIds(xd);

		var rowNodes = null;
		rowNodes = xd.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='" + this.id + "']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e");

		// This gets set to the index of the last row that was returned.
		var lastRowReturned;
		// This gets set to the number of rows returned.
		var numRowsReturned = rowNodes.length;

		// If the pagesize is null, we got whatever the server would give us.
		// Update the evt args according to what was delievered by the server.
		if (getCompleteEvtArgs.pageSize == null)
		{
			getCompleteEvtArgs.pageSize = numRowsReturned;
			getCompleteEvtArgs.lastRow = getCompleteEvtArgs.startXi + getCompleteEvtArgs.pageSize - 1;
			getCompleteEvtArgs.firstRow = getCompleteEvtArgs.startXi;
		}


		if (0 != numRowsReturned)
		{
			ntbAssert(rowNodes[0].getAttribute("xi") == (getCompleteEvtArgs.startXi),"The gethandler returned a different first row than requested.");

//			lastRowReturned = getCompleteEvtArgs.lastRow;
			//	Here we check if the zero bas
			//	is equal to the requested pageSize plus the starting xi minus 1...
	//			if (rowNodes[rowNodes.length-1].getAttribute("xi") != (getCompleteEvtArgs.pageSize+getCompleteEvtArgs.startXi-1))
	//			{
				lastRowReturned = parseInt(rowNodes[rowNodes.length-1].getAttribute("xi"));

				// lastRowReturned is used in descriptor to determine if we 
				// did not receive all the expected rows and are thus on the last page.
	//				getCompleteEvtArgs.lastRowReturned = lastRowReturned;
	
				// This is the last page.
//				getCompleteEvtArgs.lastPage=true;
//	  			this.fire("RowCountKnown",actualLastRow);
//			}

			//	Add the range to the cache map.
			if (this.mode == "paging")
			{
				this.dataCache.insert(0, getCompleteEvtArgs.pageSize-1);				
			}
			else
			{
				this.dataCache.insert(getCompleteEvtArgs.firstRow, lastRowReturned);
			}
		}
		else
		{
			lastRowReturned = -1;
			getCompleteEvtArgs.pageSize=0;
			if (this.totalRowCount == null)
			{
				var pct = this.descriptor.lastKnownRow/this.descriptor.estimatedRowCount || 0;
				this.fire("PastEndOfData",pct);
			}
		}

		getCompleteEvtArgs.numRowsReturned = numRowsReturned;
		getCompleteEvtArgs.lastRowReturned = lastRowReturned;
		
		// Remove the received request from the cache.
		var startXi = getCompleteEvtArgs.startXi;
		var pageSize = getCompleteEvtArgs.pageSize;
		if (!isNaN(startXi) && !isNaN(pageSize) && startXi != 0)
		{
			this.requestCache.remove(startXi,startXi + pageSize - 1);
		}
		
		if (this.mode!="caching") 
		{
			// in both static and paging modes we just take the data from the server 
			// and put it into our local xml document.

			// Use replaceData which will _only_ replace the data and no events will be fired
			// or row counts being set ... this happens later by the descriptor.
			this.replaceData(xd);

		} else {
			//	Otherwise we need to merge the data from the request with that in our datasource
			this.mergeData(xd);

/*
			// Added by james 
			var previousCount = this.remoteRowCount;
			var previousKnown = this.rowCountKnown;
		  	this.descriptor.update(getCompleteEvtArgs);
		  	
		  	this.remoteRowCount = this.descriptor.estimatedRowCount;
		  	this.rowCountKnown = this.descriptor.isAtEndOfTable;
		  	if (this.remoteRowCount != previousCount) {
		  			this.fire("RowCountChanged",this.remoteRowCount);
		  	}
		  	if (this.rowCountKnown != previousKnown) {
		  			this.fire("RowCountKnown",this.remoteRowCount);
		  	}
	*/
		}


		// want to check totalRowCount on every count, since data could change
			var totalRowCount = this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("totalrowcount");
			totalRowCount = parseInt(totalRowCount);
			
			if (!isNaN(totalRowCount))
			{
				this.totalRowCount = totalRowCount;
			}
			// TODO: Should fire an event here to notify all interested parties that we have
			// all the rows
			this.fire("TotalRowCountReady", this.totalRowCount);
	
		var parentField = this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("parentfield");
		var primaryField = this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("primaryfield");
		var parentValue = this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("parentvalue");
		this.parentField = parentField || "";
		this.parentValue = parentValue || "";
		this.primaryField = primaryField || "";
		
		this.updateFromDescriptor(getCompleteEvtArgs)
		
		this.fire("RowCountReady",getCompleteEvtArgs);
		if (null != getCompleteEvtArgs.ajaxCallback)
		{
			//	We need to check that the ajaxCallback is not null before relaesing it
			//	It could be the case the ajaxCallback object was not needed because the
			//	data was already present in the DataSource
			this.ajaxCallbackPool.release(getCompleteEvtArgs.ajaxCallback);
		}

		this.executeRequests();
		
		var node = xd.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource');
		var e = null;
		if (node)
		{
			e = node.getAttribute('error');
		}
		if (e)
		{
			this.setHandlerError(e);
		}
		else
		{
			this.setHandlerError(null);
		}
		
		this.fire("DataReady",getCompleteEvtArgs);

		if (null != getCompleteEvtArgs.callback && null != getCompleteEvtArgs.context)
		{
			getCompleteEvtArgs.callback.call(getCompleteEvtArgs.context, getCompleteEvtArgs);
			getCompleteEvtArgs.dispose();
			getCompleteEvtArgs = null;
		}
		else
		{
			// return the getCompleteEvtArgs to the caller ... 
			return getCompleteEvtArgs;
		}

	}

/**
 * @private
 */
nitobi.data.DataTable.prototype.executeRequests = function() 
{
	// Execute all the functions on the request queue, then reset the queue.
	var oldRequests = this.requestQueue;
	this.requestQueue = new Array();
	for (var i=0; i < oldRequests.length; i++)
	{
		oldRequests[i].call();
	}
}
/**
 * @private
 * Updates information related to paging such as whether the number of records on the server is known and what the currently estimated rowcount is.
 */
nitobi.data.DataTable.prototype.updateFromDescriptor = function(getCompleteEvtArgs) 
{
	if (this.totalRowCount == null)
  		this.descriptor.update(getCompleteEvtArgs);
  	if (this.mode == "paging")
  	{
  		this.setRemoteRowCount(getCompleteEvtArgs.numRowsReturned);
  	}
  	else
  	{
  		if (this.totalRowCount != null)
  			this.setRemoteRowCount(this.getTotalRowCount());
  		else
  			this.setRemoteRowCount(this.descriptor.estimatedRowCount);
  	}
  	this.setRowCountKnown(this.descriptor.isAtEndOfTable);
}

nitobi.data.DataTable.prototype.setRowCountKnown = function(known)
{
	// TODO: this has to be merged with the fireProjectionUpdatedEvent stuff in descriptor
	var previousKnown = this.rowCountKnown;
	this.rowCountKnown = known
  	if (known && this.rowCountKnown != previousKnown) 
  	{
		this.fire("RowCountKnown",this.remoteRowCount);
  	}
}
nitobi.data.DataTable.prototype.getRowCountKnown = function()
{
	return this.rowCountKnown;
}
/**
 * @private
 */
nitobi.data.DataTable.prototype.configureFromData = function(xd)
{
	this.version=this.inferDataVersion(xd);

	// Get columns out of data
	// Get total records on server
	
	if (this.mode=="unbound") {
	}
	if (this.mode=="static") {
	}
	if (this.mode=="paging") {
	}
	if (this.mode=="caching") {
	}
			//firstResponseRowXi
			//lastResponseRowXi
			//rowsInResponse
			//rowsRequested
			//firstRequestRowXi
			//laststRequestRowXi
			//firstPageRow
			//lastPageRow
			//ActualTotalRows
			//PredictedTotalRows
			//lastPage
}

/**
 * Merges the data from an XML document into the DataTable XML. DEPRECATED???
 * @private
 * @param {XMLNode} xd
 */
nitobi.data.DataTable.prototype.mergeData = function(xd)
{
	if (this.xmlDoc.xml == "")
	{
		this.initializeXml(xd);
		return;
	}
	var p = nitobi.xml.nsPrefix;
	var xpath = "//"+p+"datasource[@id = '"+this.id+"']/"+p+"data";

	//	We need to merge the new data into our dataset because we are in caching mode ...
	//	Need to be able to generate some XSL based on the returned data ...
	var newData = xd.selectNodes(xpath+"//"+p+"e");

	//	this shoudl be abstracted into something like this.getDataSourceNode so that we can override it easily...
	//	or it should use an object like a data source connector/resolver to do that!!!
	var oldData = this.xmlDoc.selectSingleNode(xpath);

	//	TODO: somehow, despite having our request cache, we are getting duplicate xi values...
	//	To fix this i moved the request cache into the viewport itself ...

	var len = newData.length;
	for (var i=0; i<len; i++)
	{
		//	importNode???? namespaces????
		if (this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.id+'\']/'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e[@xi=\''+newData[i].getAttribute('xi')+'\']'))
		{
			continue;
		}
		oldData.appendChild(nitobi.xml.importNode(oldData.ownerDocument, newData[i], true));
	}
}

/**
 * @private
 */
nitobi.data.DataTable.prototype.assignRowIds = function(xd)
{
	nitobi.data.addXidXslProc.addParameter('guid', nitobi.component.getUniqueId(), '');
	var doc = nitobi.xml.loadXml(xd, nitobi.xml.transformToString(xd, nitobi.data.addXidXslProc, "xml"));
	return doc;
}

/**
 * @private
 */
nitobi.data.DataTable.prototype.inferDataVersion = function(xd)
{
	if (xd.selectSingleNode("/root")) return 2.8;
	return 3.0;
}

/**
 * @private
 */
nitobi.data.DataTable.prototype.parseResponse = function(xd, getCompleteEvtArgs)
{
	//	First check the version that we are working with
	if (this.version==2.8)
	{
		return this.parseLegacyResponse(xd, getCompleteEvtArgs);
	}
	else
	{
		return this.parseStructuredResponse(xd, getCompleteEvtArgs);
	}
}
/**
 * Parses a response from an Grid V2.8 server handler.
 * @private
 */
nitobi.data.DataTable.prototype.parseLegacyResponse = function(xd, getCompleteEvtArgs)
{
	var startXi = this.mode == "paging" ? 0 : getCompleteEvtArgs.startXi;
	nitobi.data.dataTranslatorXslProc.addParameter('start', startXi, '');
	nitobi.data.dataTranslatorXslProc.addParameter('id', this.id, '');
	var fieldsNode = xd.selectSingleNode("/root").getAttribute("fields");
	var fields = fieldsNode.split("|");
	var i = fields.length;
	var xkField = (i>25 ? String.fromCharCode(Math.floor(i/26)+96):"")+(String.fromCharCode(i%26+97));
	nitobi.data.dataTranslatorXslProc.addParameter('xkField',xkField, ''); // last column of table is the key field
	xd = nitobi.xml.transformToXml(xd, nitobi.data.dataTranslatorXslProc);	
	return xd;	
}

/**
 * @private
 */
nitobi.data.DataTable.prototype.parseStructuredResponse = function(xd, getCompleteEvtArgs)
{
	// Drop all other datasources.
	xd = nitobi.xml.loadXml(xd, '<ntb:grid xmlns:ntb="http://www.nitobi.com"><ntb:datasources>'+xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='" + this.id + "']").xml+'</ntb:datasources></ntb:grid>');
	var firstRow = xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='" + this.id + "']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e");
	// So far, there is a dependency on xi from the server.
	var startXi = this.mode == "paging" ? 0 : getCompleteEvtArgs.startXi;
	if (firstRow)
	{
		ntbAssert(Boolean(firstRow.getAttribute("xi")),"No xi was returned in the data from the server. Server must return xi's in the new format.", "", EBA_THROW);
		ntbAssert(startXi >= 0,"startXI is incorrect.");

		// TODO: Refactor into a method.
		if (firstRow.getAttribute("xi") != startXi)
		{
			nitobi.data.adjustXiXslProc.addParameter("startingIndex","0","");
			nitobi.data.adjustXiXslProc.addParameter("adjustment",startXi,"");
			xd = nitobi.xml.loadXml(xd, nitobi.xml.transformToString(xd, nitobi.data.adjustXiXslProc, "xml"));
			
		}
	}
	return xd;	

}

//
// PAGING
//
/**
 * LARGE NOTE: I don't think get should ignore the call if it thinks it already has it. This gets the rows
 * regardless of cache. This allows us to check for the return error before we flush our data.
 * There should be a better way to force the get function to get the page you want. TODO: Eliminate forceGet
 * @private
 */
nitobi.data.DataTable.prototype.forceGet = function(start, pageSize, context, callback, errorCallback, successCallback)
	{
		this.errorCallback = errorCallback;
		this.successCallback = successCallback;
		this.context = context;
		var getHandler = this.getGetHandler();
		//	TODO: this should be a handlerResolver object or something ...
		(getHandler.indexOf('?') == -1) ? getHandler += '?' :  getHandler += '&';
		getHandler += 'StartRecordIndex=0&start=0&PageSize=' + pageSize + '&SortColumn=' + (this.sortColumn || '') + '&SortDirection=' + this.sortDir + '&TableId=' + this.id + '&uid=' + (new Date().getTime());
		var ajaxCallback = this.ajaxCallbackPool.reserve();
	
		ntbAssert(Boolean(ajaxCallback),"The datasource is serving too many connections. Please try again later. # current connections: " + this.ajaxCallbackPool.inUse.length );
		ajaxCallback.handler = getHandler;
		ajaxCallback.responseType = "xml";
		ajaxCallback.context = this;
		ajaxCallback.completeCallback = nitobi.lang.close(this,this.getComplete);
		//ajaxCallback.onGetComplete.subscribeOnce(this.getComplete, this);
		ajaxCallback.params = new nitobi.data.GetCompleteEventArgs(0, pageSize-1, 0, pageSize, ajaxCallback, this, context, callback);
		ajaxCallback.get();	
		return;
	}

nitobi.data.DataTable.prototype.getPage = function(start, pageSize, context, callback, errorCallback, successCallback)
{
	ntbAssert(this.getHandler.indexOf("GridId")!=-1,"The gethandler has not gridId specified on it.");
//	this.forceGet(start, pageSize, context, callback, errorCallback, successCallback)
	var lastRow = start + pageSize - 1;

	var cacheGaps = this.dataCache.gaps(0, pageSize-1);
	var numCacheGaps = cacheGaps.length;

	if (numCacheGaps)
	{
		var requestGaps = this.requestCache.gaps(start,lastRow);

		//	There is a request outstanding for this data already ...
		if (requestGaps.length == 0)
		{
			var funcref = nitobi.lang.close(this, this.get, arguments);
			this.requestQueue.push(funcref);
			return;
		}
		
		this.getFromServer(start, lastRow, start, lastRow, context, callback, errorCallback);
	}
	else
	{
		this.getFromCache(start, pageSize, context, callback, errorCallback);
	}
	
}

/**
 * General request for data.
 * @param {int} start
 * @param {int} pageSize
 * @param {object} context
 * @param {function} callback
 * @param {function} errorCallback
 * @public
 */
nitobi.data.DataTable.prototype.get = function(start, pageSize, context, callback, errorCallback)
{
		this.errorCallback = errorCallback;

		//	TODO: Why is this section only for the default datasource?
		//  This is temporary. we needed to simplify the gethandlers for other data sources.
		//  Didn't want the startrecordindex, pagesize etc. getting in there. 
/*
		if (this.id == "_default")
		{
			return this.getCached(start, pageSize, context, callback, errorCallback)
//			this.getPage(start, pageSize, context, callback, errorCallback, successCallback)
//			this.getSync(start, pageSize)
		} else {
			return this.getTable(context, callback, errorCallback)
		}
*/
		var result = null;

		if (this.mode=="caching") {
			result = this.getCached(start, pageSize, context, callback, errorCallback)
		}
//		if (this.mode=="static") {
		// TODO: get the modes all sorted.
		if (this.mode=="local" || this.mode=="static") {
			result = this.getTable(context, callback, errorCallback)
		}
		if (this.mode=="paging") {
			result = this.getPage(start, pageSize, context, callback, errorCallback);
		}

		return result;
	}


//
// CACHING
//
/**
 * Determines if the range specified exists in the data on the client.
 * @param {int} start Start index of range.
 * @param {int} pageSize Number of records in range.
 * @public
 */
nitobi.data.DataTable.prototype.inCache = function(start,pageSize)
{
	// TODO: this should not be here since local data should be inCache always...
	if (this.mode == 'local')
	{
		return true;
	}

	var firstRow = start, lastRow = start + pageSize - 1;

	// If we know the last row and are checking the cache past the end of
	// the data there is no way the data will be in cache so reduce the lastRow
	// to the lastKnownRow value instead.
	var lastKnownRow = this.getRemoteRowCount()-1;

	if (this.getRowCountKnown() && lastKnownRow < lastRow)
	{
		lastRow = lastKnownRow;
	}

	var cacheGaps = this.dataCache.gaps(firstRow, lastRow);
	var numCacheGaps = cacheGaps.length;
	return !(numCacheGaps > 0);
}
	
/**
 * Returns the blocks of data that are already cached on the client.
 * @param {int} start Start index of range.
 * @param {int} pageSize Number of records in range.
 * @public
 */
nitobi.data.DataTable.prototype.cachedRanges = function(firstRow,lastRow)
{
	return this.dataCache.ranges(firstRow, lastRow);
}
	
/**
 * Request for page of data into a cached data table
 * @param {int} start
 * @param {int} pageSize
 * @param {int} context
 * @param {int} callback
 * @param {int} errorCallback
 * @param {int} successCallback
 * @public
 */
nitobi.data.DataTable.prototype.getCached = function(start, pageSize, context, callback, errorCallback, successCallback)
{
		if (pageSize == null)
		{
			return this.getFromServer(firstRow, null, start, null, context, callback, errorCallback);
		}
		
		//	first this is to check what part of the data we don't already have ...
		var firstRow = start, lastRow = start + pageSize - 1;
		var cacheGaps = this.dataCache.gaps(firstRow, lastRow);
		var numCacheGaps = cacheGaps.length;
		ntbAssert(numCacheGaps==cacheGaps.length, "numCacheGaps != gaps.length despite setting it so. Concurrency problem has arisen.");

		if (this.mode!="unbound" && numCacheGaps > 0)
		{
			// There are certain situations - like when user scrolls to the bottom - that we 
			// do get multiple cacheGaps. In those cases LiveScrolling stops working if we loop through each.
//			for (var i=0; i<numCacheGaps; i++)
//			{
				var low = cacheGaps[numCacheGaps-1].low;
				var high = cacheGaps[numCacheGaps-1].high;

				var requestGaps = this.requestCache.gaps(low,high);

				//	There is a request outstanding for this data already ...
				if (requestGaps.length == 0)
				{
					var funcref = nitobi.lang.close(this, this.get, arguments);
					//window.setTimeout(funcref, 100);
					this.requestQueue.push(funcref);
					return;
				}
//				else
//				{
//					this.requestCache.insert(low,high);
//				}

/*
				var getHandler = this.getHandler;
				//	TODO: this should be a handlerResolver object or something ...
				(getHandler.indexOf('?') == -1) ? getHandler += '?' :  getHandler += '&';
				getHandler += 'StartRecordIndex=' + low + '&start=' + low + '&PageSize=' + (high - low + 1) + '&SortColumn=' + (this.sortColumn || '') + '&SortDirection=' + this.sortDir + '&TableId=' + this.id + '&uid=' + (new Date().getTime());
*/
				// Return the result from the getRequest as it may be synchronous if no callback is specified.
				return this.getFromServer(firstRow, lastRow, low, high, context, callback, errorCallback);
//			}
		}
		else
		{
			this.getFromCache(start, pageSize, context, callback, errorCallback);
		}
	}


/**
 * Gets data from the server-side data via Eba.Calback.
 */
nitobi.data.DataTable.prototype.getFromServer = function(firstRow, lastRow, low, high, context, callback, errorCallback)
{
	ntbAssert(this.getHandler!=null&&typeof(this.getHandler)!="undefined","getHandler not defined in table eba.datasource",EBA_THROW);

	this.requestCache.insert(low,high);

	var pageSize = (lastRow == null ? null : (high - low + 1));
	var strPageSize = (pageSize == null ? "" : pageSize);
	var getHandler = this.getGetHandler();
	//	TODO: this should be a handlerResolver object or something ...
	(getHandler.indexOf('?') == -1) ? getHandler += '?' :  getHandler += '&';
	getHandler += 'StartRecordIndex=' + low + '&start=' + low + '&PageSize=' + (strPageSize) + '&SortColumn=' + (this.sortColumn || '') + '&SortDirection=' + this.sortDir + '&uid=' + (new Date().getTime());
	var ajaxCallback = this.ajaxCallbackPool.reserve();
	
	ntbAssert(Boolean(ajaxCallback),"The datasource is serving too many connections. Please try again later. # current connections: " + this.ajaxCallbackPool.inUse.length );
	ajaxCallback.handler = getHandler;
	ajaxCallback.responseType = "xml";
	ajaxCallback.context = this;
	ajaxCallback.completeCallback = nitobi.lang.close(this,this.getComplete);
	//ajaxCallback.onGetComplete.subscribeOnce(this.getComplete, this);
	ajaxCallback.async = this.async;
	ajaxCallback.params = new nitobi.data.GetCompleteEventArgs(firstRow, lastRow, low, pageSize, ajaxCallback, this, context, callback);
	
	return ajaxCallback.get();
}
	/**
	 * Gets data from the cached (client-side) data
	 */
nitobi.data.DataTable.prototype.getFromCache = function(start, pageSize, context, callback, errorCallback)
{

	//	The only reason that we would be here is if the data is already in the DataSource - that is a good thing!
		//	first this is to check what part of the data we don't already have ...
	var firstRow = start, lastRow = start + pageSize - 1;
	if (firstRow>0 || lastRow>0) 
	{
		// If this was an asynchronous request then call the callback
		if (typeof(callback) == 'function')
		{
			var evtArgs = new nitobi.data.GetCompleteEventArgs(firstRow, lastRow, firstRow, lastRow-firstRow+1,null, this, context, callback);
			evtArgs.callback.call(evtArgs.context, evtArgs);
		}
	}
}
	/*
	 * Merges a properly formatted XMLDocument into the datasource.
	 * @param {XMLDocument} xmlDoc The XMLDocument to merge with the datasource.  The document will include row indexes for each element.
	 */
nitobi.data.DataTable.prototype.mergeFromXml = function(xmlDoc, callback)
	{
		var startRowIndex = Number(xmlDoc.documentElement.firstChild.getAttribute("xi")); 
		var endRowIndex = Number(xmlDoc.documentElement.lastChild.getAttribute("xi"));

		var cacheGaps = this.dataCache.gaps(startRowIndex, endRowIndex);

		// If we are working in local mode there is no going back to the server so just
		// insert the range into the dataCache
		if (this.mode == "local" && cacheGaps.length == 1)
		{
//			this.beginBatchInsert();
//			for (var rowIndex=cacheGaps[0].low; rowIndex<=cacheGaps[0].high; rowIndex ++)
//			{
//				this.createRecord(null, rowIndex);
//			}
			this.dataCache.insert(cacheGaps[0].low, cacheGaps[0].high);
			this.mergeFromXmlGetComplete(xmlDoc, callback, startRowIndex, endRowIndex);
			this.batchInsertRowCount = (cacheGaps[0].high - cacheGaps[0].low + 1);
			this.commitBatchInsert();
			return;
		}

		if (cacheGaps.length == 0)
			// There are no gaps in the data do just merge it
			this.mergeFromXmlGetComplete(xmlDoc, callback, startRowIndex, endRowIndex);
		else if (cacheGaps.length == 1)
			// There is a gap
			this.get(cacheGaps[0].low, cacheGaps[0].high-cacheGaps[0].low+1, this, nitobi.lang.close(this, this.mergeFromXmlGetComplete, [xmlDoc, callback, startRowIndex, endRowIndex]));
		else
			// There is no data in the paste range
			this.forceGet(startRowIndex, endRowIndex, this, nitobi.lang.close(this, this.mergeFromXmlGetComplete, [xmlDoc, callback, startRowIndex, endRowIndex]));
	}
	/**
	 * @private
	 */
nitobi.data.DataTable.prototype.mergeFromXmlGetComplete = function(xmlDoc, callback, startRowIndex, endRowIndex)
	{
		var newDataNode = nitobi.xml.createElement(this.xmlDoc, "newdata");
		newDataNode.appendChild(xmlDoc.documentElement.cloneNode(true));

		this.xmlDoc.documentElement.appendChild(nitobi.xml.importNode(this.xmlDoc, newDataNode, true));

		//	set the parameters for doing the merge of the data
		nitobi.data.mergeEbaXmlXslProc.addParameter('startRowIndex',startRowIndex,'');
		nitobi.data.mergeEbaXmlXslProc.addParameter('endRowIndex',endRowIndex,'');
		nitobi.data.mergeEbaXmlXslProc.addParameter('guid',nitobi.component.getUniqueId(),'');
		this.xmlDoc = nitobi.xml.loadXml(this.xmlDoc, nitobi.xml.transformToString(this.xmlDoc, nitobi.data.mergeEbaXmlXslProc,"xml"));
		newDataNode = nitobi.xml.createElement(this.log, "newdata");
		var changedNodes = xmlDoc.selectNodes('//'+nitobi.xml.nsPrefix+'e');
		var changedIndex = 0;
		for (var i = 0; i < changedNodes.length; i++) {
			changedIndex = changedNodes[i].attributes.getNamedItem('xi').value;
			newDataNode.appendChild(this.xmlDoc.selectSingleNode('/'+nitobi.xml.nsPrefix+'grid/'+nitobi.xml.nsPrefix+'datasources/'+nitobi.xml.nsPrefix+'datasource/'+nitobi.xml.nsPrefix+'data/'+nitobi.xml.nsPrefix+'e[@xi='+changedIndex+']').cloneNode(true))
		}
		//newDataNode.appendChild(xmlDoc.documentElement.cloneNode(true));
		this.log.documentElement.appendChild(nitobi.xml.importNode(this.log, newDataNode, true));
		
		nitobi.data.mergeEbaXmlToLogXslProc.addParameter('defaultAction','u','');
		this.log = nitobi.xml.loadXml(this.log, nitobi.xml.transformToString(this.log, nitobi.data.mergeEbaXmlToLogXslProc,"xml"));

		this.xmlDoc.documentElement.removeChild(this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'newdata'));
		this.log.documentElement.removeChild(this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'newdata'));

		callback.call();
	}
	
nitobi.data.DataTable.prototype.fillColumn = function(columnName, value)
	{
		
		nitobi.data.fillColumnXslProc.addParameter('column', this.fieldMap[columnName].substring(1));
		nitobi.data.fillColumnXslProc.addParameter('value', value);
		this.xmlDoc.loadXML(nitobi.xml.transformToString(this.xmlDoc, nitobi.data.fillColumnXslProc, "xml"));
		
		var startTime = parseFloat((new Date()).getTime());
		var newDataNode = nitobi.xml.createElement(this.log, "newdata");

		this.log.documentElement.appendChild(nitobi.xml.importNode(this.log, newDataNode, true));
		
		newDataNode.appendChild(this.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'data').cloneNode(true));

		nitobi.data.mergeEbaXmlToLogXslProc.addParameter('defaultAction','u');
		this.log.loadXML(nitobi.xml.transformToString(this.log, nitobi.data.mergeEbaXmlToLogXslProc,"xml"));
		nitobi.data.mergeEbaXmlToLogXslProc.addParameter('defaultAction','');

		this.log.documentElement.removeChild(this.log.selectSingleNode('//'+nitobi.xml.nsPrefix+'newdata'));
	}
	
/**
 * Returns the total number of rows in the remote datasource that this DataTable corresponds to.
 * @type Number
 */
nitobi.data.DataTable.prototype.getTotalRowCount = function()
{
	return this.totalRowCount;
}

nitobi.data.DataTable.prototype.setHandlerError = function(error)
	{
		this.handlerError = error;
	}
nitobi.data.DataTable.prototype.getHandlerError = function()
	{
		return this.handlerError;
	}
	
nitobi.data.DataTable.prototype.dispose= function()  {

		this.sortXslProc = null;

		this.requestQueue = null;
		this.fieldMap = null;
}

/**
 * @private
 */	
nitobi.data.DataTable.prototype.fire= function(evt,args)  {
	return nitobi.event.notify(evt+this.uid,args);
}
/**
 * @private
 */	
nitobi.data.DataTable.prototype.subscribe= function(evt,func,context)  {
	if (typeof(context)=="undefined") context=this;
	return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.data");
/**
 * This class provides information about the size and nature of the 
 * datasource. It does not provide any data.  It's single purpose is
 * to perform reflection on the table datasource.
 * @param {Boolean} estimateRowCount If true, the descriptor will try to leap ahead to find the end of the table.
 */
nitobi.data.DataTableDescriptor = function(table, tableProjectionUpdatedEvent, estimateRowCount)
{
	/**
	 * Items that are destroyed when this object is destroyed.
	 * @private
	 */
	this.disposal = [];
	
	/**
	 * The number of rows thought to be in the database. 
	 * This is equal to, or larger than, the last known row.
	 * @private
	 */
	this.estimatedRowCount=0;
	/**
	 * The amount by which the projected database size is adjusted.
	 * @private
	 */
	this.leapMultiplier=2;
	/**
	 * If true, the descriptor will try to leap ahead to find the end of the table.
	 */
	this.estimateRowCount = (estimateRowCount == null ? true : estimateRowCount);
	/**
	 * The index of the greatest last known row in the db.
	 * @private
	 */
	this.lastKnownRow=0;
	/**
	 * Indicates whether or not the end of table is known.
	 * @private
	 */
	this.isAtEndOfTable = false;
	
	/**
	 * The table that this descriptor describes.
	 * @private
	 */
	this.table = table;
	
	/**
	 * The Edge of (un)known space. This will be set if you do a leap and no results are returned
	 * then the lowestEmptyRow becomes the lowest index of that get request.
	 * @private
	 */
	this.lowestEmptyRow = 0;
	
	/**
	 * Fires when the descriptor finds new information
	 * about the datasource and updates its knowledge.
	 */ /* How does closelater and context work here?*/
	this.tableProjectionUpdatedEvent = tableProjectionUpdatedEvent;
	this.disposal.push(this.tableProjectionUpdatedEvent);
}


/*************************************************************/
/*				           PEEK MODE     					 */
/*************************************************************/

/**
 * Starts the peek process whereby the descriptor asks for a single
 * record farther into the table in an attempt to find the end of the
 * table.
 * Peek actually uses DataTable.get to do its thing and so update
 * on the Descriptor is called from DataTable which will stop the peek
 * action (see update logic).
 */
nitobi.data.DataTableDescriptor.prototype.startPeek = function()
{
	this.enablePeek = true;
	this.peek();
}

nitobi.data.DataTableDescriptor.prototype.peek = function()
{
	var indexToPeekAt;
	if (this.lowestEmptyRow > 0)
	{
		var blankRows = this.lowestEmptyRow - this.lastKnownRow;
		// Peek at the halfway point between the lastKnownRow and the last row we peeked at unsuccessfully
		indexToPeekAt = this.lastKnownRow + Math.round(blankRows/2);
	}
	else
	{
		// If this is the first time we are peeking (ie lowestEmptyRow is 0)
		// then increase the peek position to some estimated amount
		indexToPeekAt = (this.estimatedRowCount * this.leapMultiplier);
	}
	// Do a get through the datatable at the peek index for a single row
	this.table.get(Math.round(indexToPeekAt), 1, this, this.peekComplete);
	//alert(this.startPeek);

	// IF we got any response then increase the last known good row to the xi we looked for
/*	if (evtArgs.startXi == this.lastKnownRow)
	{
		this.isAtEndOfTable = true;
		this.fireProjectionUpdatedEvent();
		return;
	}
	if (evtArgs.pageSize == 1)
	{
		// +1 to get the number of rows from the final row index
		this.estimatedRowCount = Math.max(evtArgs.startXi+1,this.estimatedRowCount);
		// -1 to get the row index from the length
		this.lastKnownRow = this.estimatedRowCount-1;
		this.fireProjectionUpdatedEvent();
	}
	else 
	{
		this.leapMultiplier = 1 + ((this.leapMultiplier - 1 )/2);
	}*/
	
}

nitobi.data.DataTableDescriptor.prototype.peekComplete = function(evtArgs)
{
	if (this.enablePeek)
	{
		window.setTimeout(nitobi.lang.close(this,this.peek),1000);
	}
}
/**
 * Stops the peek process.
 */
nitobi.data.DataTableDescriptor.prototype.stopPeek = function()
{
	this.enablePeek = false;
}

/*************************************************************/
/*				           LEAP MODE	 		     		 */
/*************************************************************/

/**
 * Recomputes the estimated row count based on a multiplier and an offset.
 * @param {Number} multiplier A number by which to multiply the estimated row count.
 * @param {Number} adjustment A number by which to increase the estimated row count.
 */
nitobi.data.DataTableDescriptor.prototype.leap = function(multiplier,adjustment)
{
	if (this.lowestEmptyRow > 0)
	{
		var blankRows = this.lowestEmptyRow - this.lastKnownRow;
		this.estimatedRowCount = this.lastKnownRow + Math.round(blankRows/2);
	}
	else if (multiplier == null || adjustment == null)
	{
		this.estimatedRowCount = 0;
	}
	else if (this.estimateRowCount)
	{
		this.estimatedRowCount = (this.estimatedRowCount * multiplier) + adjustment;
	}

//	window.status+="["+this.estimatedRowCount+"]";
//	alert("LEAP ERC: " + this.estimatedRowCount);
	this.fireProjectionUpdatedEvent();	
}

/**
 * Updates the descriptor's knowledge about the table.
 * @param {nitobi.components.grid.OnGetCompleteEventArgs} evtArgs A hash consisting of a lastPage boolean, pageSize, firstRow, lastRow, and startXi.
 * @param {Boolean} needLeap A boolean that can be used to force the estimated row count to be adjusted.
 */

nitobi.data.DataTableDescriptor.prototype.update = function(evtArgs, needLeap)
{
	// There a few cases we can have here.
	// We need to check the eventArgs for the lastPage parameter and the numRowsReturned

//alert("update"+this.estimatedRowCount+" : "+evtArgs.pageSize)
	if (null == needLeap)
	{
		needLeap = false;
	}
	if (this.isAtEndOfTable && !needLeap)
	{
		return false;
	}

	// Check if the database is empty.
	var emptyDb = (evtArgs!=null && evtArgs.numRowsReturned == 0 && evtArgs.startXi == 0);

	// Check if the data returned doesnt match what we wanted - ie we got to the end of the data.
	// What about the case where the lastRow is == lastRowReturned and this IS the last row of data ... 
	var lastPage = (evtArgs!=null && evtArgs.lastRow != evtArgs.lastRowReturned); // || !this.estimateRowCount;

	if (null == evtArgs)
	{
		evtArgs = {lastPage:false,pageSize:1,firstRow:0, lastRow:0,startXi:0};
	}

	var foundLastPage = (emptyDb) || (lastPage) || (this.isAtEndOfTable) || ((this.lastKnownRow == this.estimatedRowCount -1) && (this.estimatedRowCount == this.lowestEmptyRow));

//	alert(this.lastKnownRow+":"+this.lowestEmptyRow+" - "+evtArgs.pageSize+" - "+foundLastPage+"PgSize:"+evtArgs.pageSize)
  	if (evtArgs.pageSize == 0 && !foundLastPage)
  	{
  		// We've let the user page into a completely empty area and 
  		// we don't know the last page.
		// Set the highest row we will ever try to get
		this.lowestEmptyRow = this.lowestEmptyRow > 0 ? Math.min(evtArgs.startXi, this.lowestEmptyRow) : evtArgs.startXi;
//		alert("LOWEST EMPTY ROW: " + this.lowestEmptyRow);

		this.leap();

/*		// Step back a small amount to see the page just loaded.
		this.leap(1,-1*blankRows/2);
		// From now on, we'll need to start leaping smaller so that
		// we don't expand the whitespace.
  		this.leapMultiplier = 1 + ((this.leapMultiplier - 1 )/2);*/
  		return true;
  	}

	// Does this codeneed to be moved here?
	/*if (!scrollAtTop && evtArgs.pageSize == 0 && this.owner.getPagingMode().toLowerCase() != "standard")
	{
		return
	}*/
//	this.lastKnownRow = Math.max(evtArgs.lastRow,this.lastKnownRow);
	this.lastKnownRow = Math.max(evtArgs.lastRowReturned, this.lastKnownRow);
//  	alert(("UPDATE is setting the last known row to: "+this.lastKnownRow))

  	if (foundLastPage && !needLeap)
	{
		if (evtArgs.lastRowReturned>=0) // ie we know the exact last row (we are not in no-mans-land)
		{
			this.estimatedRowCount = evtArgs.lastRowReturned+1;//evtArgs.startXi + evtArgs.pageSize;

			 // This is the first time that we've hit the end of the table.
			this.isAtEndOfTable = true;
		}
		else // ie we have either got no data or we way past the end of our data
		{
			if (emptyDb) // this.lastKnownRow < 0- ie we have never had nor will get any data
			{
				this.estimatedRowCount = 0;

				 // This is the first time that we've hit the end of the table.
				this.isAtEndOfTable = true;
			}
			else // ie we are in no-mans-land so back off a bit
			{
				this.estimatedRowCount = this.lastKnownRow + Math.ceil((evtArgs.lastRow-this.lastKnownRow)/2);
			}
		}

		// TODO: this needs to be merged with the setRowCountKnown stuff in DataTable.
		this.fireProjectionUpdatedEvent();
		this.stopPeek();
		return true;
	}

	if (!this.estimateRowCount)
	{
		this.estimatedRowCount = this.lastKnownRow+1;
	}
	if (this.estimatedRowCount==0)
	{
		// First page we've ever seen.
		// Estimate the remote row count to be the lastRow we received 
		// (plus 1 cause rows are zero based and rowCounts are 1 based) and double it.
		this.estimatedRowCount = (evtArgs.lastRow+1) * (this.estimateRowCount ? 2 : 1);
	}

	// Uses evtArgs.last+1 since it is a row index compared to a rowCount
  	if ((this.estimatedRowCount > (evtArgs.lastRow+1) && !needLeap) || !this.estimateRowCount)
  	{
  		// We got a page for which there is space.

  		return false;
  	}
	if (!this.isAtEndOfTable)
	{
		this.leap(this.leapMultiplier,0);
		return true;
	}
	return false;
}

/*************************************************************/
/*				           ALL MODES     					 */
/*************************************************************/

/**
 * Resets the descriptor back to its initial state. In this state,
 * the descriptor knows nothing about the table.
 */
nitobi.data.DataTableDescriptor.prototype.reset = function()
{
	this.estimatedRowCount=0;
	this.leapMultiplier=2;
	this.lastKnownRow=0;
	this.isAtEndOfTable = false;
	this.lowestEmptyRow = 0;
	this.fireProjectionUpdatedEvent();
}

nitobi.data.DataTableDescriptor.prototype.fireProjectionUpdatedEvent = function(evtArgs)
{
	if (this.tableProjectionUpdatedEvent != null)
	{
		this.tableProjectionUpdatedEvent(evtArgs);
	} 
}

/**
 * Javascript destructor
 * 
 * @private
 */
nitobi.data.DataTableDescriptor.prototype.dispose = function()
{
	nitobi.lang.dispose(this, this.disposal);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.data');
if (false)
{
	/**
	 * @class
	 * @constructor
	 */
	nitobi.data = function(){};
}

/**
 * Base event arguments for events that occur on the data source events.
 * @class
 * @constructor
 * @param {nitobi.data.DataTable} source The object which is firing the event.
 */
nitobi.data.DataTableEventArgs = function(source)
{
	/**
	 * @private
	 */
	this.source = source;
	/**
	 * @private
	 */
	this.event = nitobi.html.Event;
}

/**
 * Gets the Grid that fired the event.
 * @return nitobi.grid.Grid
 */
nitobi.data.DataTableEventArgs.prototype.getSource = function()
{
	return this.source;
}
/**
 * Gets the native browser Event object that is associated with the event. This may be null in some case.
 */
nitobi.data.DataTableEventArgs.prototype.getEvent = function()
{
	return this.event;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @constructor
 */
nitobi.data.GetCompleteEventArgs = function(firstRow, lastRow, startXi, pageSize, ajaxCallback, dataSource, obj, callback)
{
	//	This is the first row to be rendered by the RowRenderer
	this.firstRow = firstRow;
	//	This is the last row to be rendered by the RowRenderer
	this.lastRow = lastRow;
	//	This is the callback to be called once the data is all ready
	this.callback = callback;
	//	This is the datasource on which the get was requested
	this.dataSource = dataSource;
	//	This is the context (ie the object) of the callback method
	this.context = obj;
	//	This is the nitobi.ajax.HttpRequest object handling the request
	this.ajaxCallback = ajaxCallback;
	//	This is the xi of the first record that is returned such that we can integrate returned data that has no xi values
	this.startXi = startXi;
	this.pageSize = pageSize;
	/**
	 * True if the request page was the last page.
	 */
	this.lastPage=false;
	this.status = "success";
}

/**
 * @ignore
 */
nitobi.data.GetCompleteEventArgs.prototype.dispose = function()
{
	this.callback = null;
	this.context = null;
	this.dataSource = null;
  	this.ajaxCallback.clear();
	this.ajaxCallback == null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.data.SaveCompleteEventArgs = function(callback)
{
	this.callback = callback;
}

nitobi.data.SaveCompleteEventArgs.prototype.initialize = function()
{
	
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Event arguments for after a save event.
 * @param {nitobi.data.DataTable} source
 * @param {XMLDocument} responseData
 * @param {Boolean} success
 */
nitobi.data.OnAfterSaveEventArgs = function(source, responseData, success)
{
	nitobi.data.OnAfterSaveEventArgs.baseConstructor.call(this,source);
	this.success = success;
	this.responseData = responseData;
};

nitobi.lang.extend(nitobi.data.OnAfterSaveEventArgs, nitobi.data.DataTableEventArgs);

/**
 * Returns the XML Document that was returned by the save handler.
 * @type XMLDocument
 */
nitobi.data.OnAfterSaveEventArgs.prototype.getResponseData = function()
{
	return this.responseData;
};

/**
 * Returns a boolean signifying whether or not the save was successful.
 * @type Boolean 
 */
nitobi.data.OnAfterSaveEventArgs.prototype.getSuccess = function()
{
	return this.success;
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.form");

if (false)
{
	/**
	 * @namespace This namespace contains the various types of form controls used by {@link nitobi.grid.Grid}
	 * @constructor
	 */
	nitobi.form = function(){};
}

/**
 * Creates a form Control.
 * @class Base provides the basic interface expected for a Nitobi editor such as binding, hiding and handling key presses.
 * @constructor
 */
nitobi.form.Control = function()
{
	/**
	 * @private
	 */
	this.owner = null;

	/** 
	 * @private
	 * @type HTMLElement
	 * The HTML element that is the root of the editor.
	 */
	this.placeholder = null;

	var div = nitobi.html.createElement("div");
	div.innerHTML = 
			"<table border='0' cellpadding='0' cellspacing='0' class='ntb-input-border'><tr><td></td></tr></table>";
	var ph = this.placeholder = div.firstChild;

	/**
	 * @private
	 */
	this.cell = null;
	
	/**
	 * @private
	 */
	this.ignoreBlur = false;

	/**
	 * @private
	 */
	this.editCompleteHandler = function() {};

	// TODO: These need to be documented, tested
	this.onKeyUp = new nitobi.base.Event();

	this.onKeyDown = new nitobi.base.Event();

	this.onKeyPress = new nitobi.base.Event();

	this.onChange = new nitobi.base.Event();

	this.onCancel = new nitobi.base.Event();

	this.onTab = new nitobi.base.Event();

	this.onEnter = new nitobi.base.Event();
}

/**
 * This is called each time the editor is ready to be used.
 */
nitobi.form.Control.prototype.initialize = function()
{
}

/**
 * Mimic is responsible for placing and sizing the editor control
 * to the desired position on the screen.
 */
nitobi.form.Control.prototype.mimic = function() {};

/**
 * @private
 */
nitobi.form.Control.prototype.deactivate = function(evt)
{
	// check if we hav already blurred ... ther are two entry points for this from
	// the key down event and from the blur event - but of course only use one of them
	// TODO: add this to all editors.
	if (this.ignoreBlur)
		return false;
	this.ignoreBlur = true;
};

/**
 * 
 */
nitobi.form.Control.prototype.bind = function(owner, cell)
{
	this.owner = owner;
	this.cell = cell;
	this.ignoreBlur = false;
};

/**
 * Hides the form control.
 */
nitobi.form.Control.prototype.hide = function()
{
	this.placeholder.style.left="-2000px";
};

/**
 * Attaches the Control to a different parent DOM element. This is useful for
 * position of the control.
 * @private
 */
nitobi.form.Control.prototype.attachToParent = function(element)
{
  element.appendChild(this.placeholder);
}

/**
 * Reveals the control.
 */
nitobi.form.Control.prototype.show = function()
{
	this.placeholder.style.display='block';
};

/**
 * Places focus on the control.
 */
nitobi.form.Control.prototype.focus = function()
{
	this.control.focus();
	this.ignoreBlur = false;
}

/**
 * @private
 */
nitobi.form.Control.prototype.align = function()
{
	var oY = 1, oX = 1, oH = 1, oW = 1;

	if (nitobi.browser.MOZ && !nitobi.browser.FF3) 
	{
		var scollSurface = this.owner.getScrollSurface();
		var activeRegion = this.owner.getActiveView().region;
		if (activeRegion == 3 || activeRegion == 4)
		{
			oY = scollSurface.scrollTop - nitobi.form.EDITOR_OFFSETY;
		}
		if (activeRegion == 1 || activeRegion == 4)
		{
			oX = scollSurface.scrollLeft - nitobi.form.EDITOR_OFFSETX;
		}
	}

	nitobi.drawing.align(this.placeholder, this.cell.getDomNode(), 0x11101000, oH, oW, -oY, -oX);	
}

/**
 * @private
 */
nitobi.form.Control.prototype.selectText = function() {

	this.focus();

	if(this.control && this.control.createTextRange) {
		var textRange = this.control.createTextRange();
		textRange.collapse(false);
		textRange.select();	
	}
}

/**
 * @private
 */
nitobi.form.Control.prototype.checkValidity = function(evt)
{
	// Dont think we need this.
	//nitobi.html.detachEvent(this.control, "blur", this.deactivate);
	var validationResult = this.deactivate(evt);

	// if it doesn't validate, clean up and return false
	if (validationResult == false){
		nitobi.html.cancelBubble(evt);
		return false;
	}
	return true;
}

/**
 * @private
 */
nitobi.form.Control.prototype.handleKey = function(evt)
{
	var k = evt.keyCode;

  if (this.onKeyDown.notify(evt) == false) return;

	var K = nitobi.form.Keys;

	var y=0;
	var x=0;
	if (k==K.UP){//up
		y=-1;
	}else if(k==K.DOWN){//down
		y=1;
	}else if(k==K.TAB){//tab
		x=1;
		if (evt.shiftKey) x=-1;

		// tab is a special case and the keyCode needs to be clear for nitobi.browser.IE.
		// in nitobi.browser.MOZ this causes the following error:
		//Error ``setting a property that has only a getter'' 
		if(nitobi.browser.IE)
			evt.keyCode="";
	}else if(k==K.ENTER){//enter
		y=1;
	}else{
		if (k==K.ESC){//esc
			// TODO: Figure this out once and for all!
			// nitobi.html.detachEvent(this.control, "blur", this.deactivate);
			this.ignoreBlur = true;
			this.hide();
			this.owner.focus();
			this.onCancel.notify(this);
		}
		return;
	}

	if (!this.checkValidity(evt)) return;

	this.owner.move(x,y);
	nitobi.html.cancelBubble(evt);

	//this.onEnter.notify(this);
	//this.onKeyPress.notify();
};

/**
 * @private
 */
nitobi.form.Control.prototype.handleKeyUp = function(evt)
{
	this.onKeyUp.notify(evt);
};

/**
 * @private
 */
nitobi.form.Control.prototype.handleKeyPress = function(evt)
{
	this.onKeyPress.notify(evt);
};

/**
 * @private
 */
nitobi.form.Control.prototype.handleChange = function(evt)
{
	this.onChange.notify(evt);
};

/**
 * @private
 */
nitobi.form.Control.prototype.setEditCompleteHandler = function(method)
{
	this.editCompleteHandler = method;
};

/**
 * @private
 * This is only for declaration use. Any subscription through this should have a name like "OnSomethingEvent".
 * Then this.Something becomes the GUID of the event for unsubscribing if need by.
 */
nitobi.form.Control.prototype.eSET=function(name, args)
{
	var oFunction = args[0];
	var funcRef = oFunction;

	var subName = name.substr(2);
	subName = subName.substr(0,subName.length-5);

	if (typeof(oFunction) == 'string')
	{
		funcRef = function() {return nitobi.event.evaluate(oFunction,arguments[0])};
	}
	
	// Get rid of the subscribed function if it is already there ... this is only for declarations
	if (this[subName] != null)
	{
		this[name].unSubscribe(this[subName]);
	}

	// name should be OnCellClickEvent but we just expect CellClick for firing
	var guid = this[name].subscribe(funcRef);
	this.jSET(subName, [guid]);
	return guid;
}

/**
 * @private
 */
nitobi.form.Control.prototype.afterDeactivate = function(text, value) {
	// Accept either one or two params, if one param then text and value are assumed the same.
	value = value || text;
	if (this.editCompleteHandler != null) {
		var eventArgs = new nitobi.grid.EditCompleteEventArgs(this, text, value, this.cell);
		var result =  this.editCompleteHandler.call(this.owner, eventArgs);
		if(!result){
			this.ignoreBlur = false;
		}
		return result;
	}
}

/**
 * @private
 */
nitobi.form.Control.prototype.jSET= function(name, val)
{
	this[name] = val[0];
}

/**
 * @ignore
 */
nitobi.form.Control.prototype.dispose = function()
{
	for (var item in this)
	{
	}
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// TODO: We could also take an approach that instead takes the root element of the composite control 
// and attaches a blur and mousedown event and tracks based on just those ... that would depend on events
// being allowed to bubble etc...

/**
 * @class
 * @constructor
 */
nitobi.form.IBlurable = function(elems, blurFunc) {
	// in the onmousedown handler we set a boolean that says we are bluring 
	// some sub component in favour of another sub component - so dont blur the entire component
	/**
	 * This is for tracking if the blur is a result of the user bluring the field by
	 * clicking on some other element or by clicking on another element that is part of the control.
	 * @type Boolean
	 * @private
	 */
	this.selfBlur = false;

	/**
	 * Contains the list of elements that make up the composite control.
	 * @private
	 */
	this.elements = elems;

	// for each element add an onmousedown handler, blur, focus, and mouseup handler
	var H = nitobi.html;
	for (var i=0; i<this.elements.length; i++) {
		var e = this.elements[i];
		H.attachEvent(e, "mousedown", this.handleMouseDown, this);
		H.attachEvent(e, "blur", this.handleBlur, this);
		H.attachEvent(e, "focus", this.handleFocus, this);
		H.attachEvent(e, "mouseup", this.handleMouseUp, this);
	}

	/**
	 * A pointer to the method that is be executed when the composite control is completely blurred.
	 * @private
	 */ 
	this.blurFunc = blurFunc;

	/**
	 * Track the last element that had focus so that we can handle the case when 
	 * the user clicks on the already focused element properly in handleMouseDown
	 * @private
	 */
	this.lastFocus = null;
}

/**
 * Removes the blurable interface from a control
 * TODO: should this just be dispose?
 * @private
 */
nitobi.form.IBlurable.prototype.removeBlurable = function() {
	for (var i=0; i<elems.length; i++) {
		nitobi.html.detachEvent(elems[i], "mousedown", this.handleMouseDown, this);
	}
}

/**
 * Fired when any element that is part of the composite control fires the mousedown event.
 * @private
 */
nitobi.form.IBlurable.prototype.handleMouseDown = function(evt) {
	// Compare the last focused event to the newly focused event.
	// TODO: there is still some bug here ...
	if (this.lastFocus != evt.srcElement) {
		this.selfBlur = true;
	} else {
		this.selfBlur = false;
	}
	this.lastFocus = evt.srcElement;
}

/**
 * Fired when any element that is part of the composite control fires the blur event.
 * @private
 */
nitobi.form.IBlurable.prototype.handleBlur = function(evt) {
	// check if we are able to blur and if so then call the blurFunc
	if (!this.selfBlur)
		this.blurFunc(evt);
	this.selfBlur = false;
}

/**
 * Fired when any element that is part of the composite control fires the focus event.
 * @private
 */
nitobi.form.IBlurable.prototype.handleFocus = function() {
	this.selfBlur = false;
}

/**
 * Fired when any element that is part of the composite control fires the mouseup event.
 * @private
 */
nitobi.form.IBlurable.prototype.handleMouseUp = function() {
	this.selfBlur = false;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Text is a text editor class that is implemented using an HTML input tag
 * @class
 * @constructor
 */
nitobi.form.Text = function()
{
	nitobi.form.Text.baseConstructor.call(this);

	var ph = this.placeholder;
	ph.setAttribute("id","text_span");
	// TODO: this is required for proper aligment of the editor
	ph.style.top="0px";
	ph.style.left="-5000px";

	// width is required to be able to fit the textbox to its parent width the first time
	var tc = this.control = nitobi.html.createElement('input', {"id":"ntb-textbox"}, {"style":"width: 100px;"});
	//align
	//maxlength
	tc.setAttribute("maxlength", 255);

	this.events = [{type:"keydown", handler:this.handleKey},
					{type:"keyup", handler:this.handleKeyUp},
					{type:"keypress", handler:this.handleKeyPress},
					{type:"change", handler:this.handleChange},
					{type:"blur", handler:this.deactivate}];
}

nitobi.lang.extend(nitobi.form.Text, nitobi.form.Control);

/**
 * @private
 */
nitobi.form.Text.prototype.initialize = function()
{
	// The text control needs to be attached here such that the password editor can change the input field type in the constructor
	var container = this.placeholder.rows[0].cells[0];
	container.appendChild(this.control);
	nitobi.html.attachEvents(this.control, this.events, this);
}

//cell, xModel, xData, initialKeyChar
/**
 * @private
 */
nitobi.form.Text.prototype.bind = function(owner, cell, initialKeyChar)
{	
	nitobi.form.Text.base.bind.apply(this, arguments);

	// All these events are complicated in the different browsers ... understand this better when we have time.
	if(initialKeyChar != null && initialKeyChar != '') {
		this.control.value = initialKeyChar;
	} else {
		this.control.value = cell.getValue();
	}

	var columnModel = this.cell.getColumnObject().getModel();

	this.eSET("onKeyPress", [columnModel.getAttribute('OnKeyPressEvent')]);
	this.eSET("onKeyDown", [columnModel.getAttribute('OnKeyDownEvent')]);
	this.eSET("onKeyUp", [columnModel.getAttribute('OnKeyUpEvent')]);
	this.eSET("onChange", [columnModel.getAttribute('OnChangeEvent')]);

	this.control.setAttribute("maxlength", columnModel.getAttribute('MaxLength'));

  // Add the column specific styles to the editor
	// Remember to remove it when we deactivate
	nitobi.html.Css.addClass(this.control, "ntb-column-data"+this.owner.uid+"_"+(this.cell.getColumn()+1));
}

/**
 * Mimic is responsible for placing and sizing the editor control
 * to the desired position on the screen.
 */
nitobi.form.Text.prototype.mimic = function()
{
  /*
   * In FF and Safari, the Text Area has does not acknowledge the 
   * proper cell.  We need to grab the width from the cell, then just
   * resize the text area
   */

  if (nitobi.browser.MOZ || nitobi.browser.SAFARI)
  {
    // This is very dirty, but this needs to be done off-screen
    var cellDom = this.cell.getDomNode();
    this.control.style.width = cellDom.clientWidth + "px";
  }

  this.align();

  // Now we need to adjust the editor width for padding / borders etc
	nitobi.html.fitWidth(this.placeholder, this.control);
	
  this.selectText();
}

/**
 * Sets the focus to the editor.
 */
nitobi.form.Text.prototype.focus = function() {
	this.control.focus();
}

/**
 * @private
 */
nitobi.form.Text.prototype.deactivate = function(evt)
{
	if (nitobi.form.Text.base.deactivate.apply(this, arguments) == false) return;

	nitobi.html.Css.removeClass(this.control, "ntb-column-data"+this.owner.uid+"_"+(this.cell.getColumn()+1));

	return this.afterDeactivate(this.control.value);
}

//	setEditCompleteHandler is implemented in the super class ....
/**
 * @private
 */
nitobi.form.Text.prototype.dispose = function()
{
	nitobi.html.detachEvents(this.control, this.events);
	var parent = this.placeholder.parentNode;
	parent.removeChild(this.placeholder);
	this.control = null;
	this.owner = null;
	this.cell = null;
}




/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @constructor
 */
nitobi.form.Checkbox = function()
{
}

/**
 * @extends nitobi.form.Control
 */
nitobi.lang.extend(nitobi.form.Checkbox, nitobi.form.Control);

/**
 * @ignore
 */
nitobi.form.Checkbox.prototype.mimic = function()
{
  	if(false == eval(this.owner.getOnCellValidateEvent())) return;
	this.toggle();
	this.deactivate();
}

//	align is implemented in the super
/**
 * @ignore
 */
nitobi.form.Checkbox.prototype.deactivate = function()
{
	this.afterDeactivate(this.value);
}

/**
 * 
 */
nitobi.form.Checkbox.prototype.attachToParent = function() 
{
	// This needs to override the base class method cause nothing should happen
}

/**
 * @ignore
 */
nitobi.form.Checkbox.prototype.toggle = function()
{
	var oColumn = this.cell.getColumnObject();
	var columnModelNode = oColumn.getModel();

	var checkedValue = columnModelNode.getAttribute('CheckedValue');
	if (checkedValue == '' || checkedValue == null)
		checkedValue = 1;

	var unCheckedValue = columnModelNode.getAttribute('UnCheckedValue');
	if (unCheckedValue == '' || unCheckedValue == null)
		unCheckedValue = 0;

	// get the value that is selected ...
	this.value = (this.cell.getData().value == checkedValue)?unCheckedValue:checkedValue;
}

/**
 * @ignore
 */
nitobi.form.Checkbox.prototype.hide = function()
{
	// NOTE: This is required since hide should do nothing.
}

/**
 * @ignore
 */
nitobi.form.Checkbox.prototype.dispose = function()
{
	this.metadata = null;
	this.owner = null;
	this.context = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class Number is a number editor class that is implemented using an HTML input.
 * @constructor
 * @extends nitobi.form.Text
 */
nitobi.form.Date = function()
{
	nitobi.form.Date.baseConstructor.call(this);
}

nitobi.lang.extend(nitobi.form.Date, nitobi.form.Text);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.form");

// initialize the editor offset for Firefox alignment problem
// these will be changed once in initialize of the EditorFactor 
// by looking at the grid border widths
nitobi.form.EDITOR_OFFSETX = 0;
nitobi.form.EDITOR_OFFSETY = 0;


/*
The editor 

how can we enable people to override masking say with custom functionality etc ...
*/
/**
 * @class
 * @constructor
 */
nitobi.form.ControlFactory = function()
{
	this.editors = {};	
}

/**
 * @ignore
 */
nitobi.form.ControlFactory.prototype.getEditor = function(caller, column, callerEvent)
{
	var editor = null;

	if(null == column)
	{
		ebaErrorReport("getEditor: column parameter is null","",EBA_DEBUG);
		return editor;
	}

	//	Check if the column metadata node could not be found for some reason
	//	If it can be found then check if it is editable.
	/*
	if((typeof(xEditorMetaNode) == "undefined") ||
	   (false == nitobi.lang.toBool(xEditorMetaNode.getAttribute("Editable"), true)) || (false == nitobi.lang.toBool(xEditorMetaNode.getAttribute("editable"), true)))
	{
		return editor;
	}
	*/

	// Not using meta model
	// var editorType = (xEditorMetaNode != null)?xEditorMetaNode.nodeName:"";
	// var dataType = (xEditorMetaNode != null)?xEditorMetaNode.getAttribute("dt"):"";
	var editorType = column.getType();
	var dataType = column.getType();

	var editorHash = "nitobi.Grid"+editorType+dataType+"Editor";
	//	First check if there is already an Editor of the appropriate type
	//	Could it also be the case that some other control is using the editor?
	//	It should not be possible since blurs should fire when clicks are made on other controls ...
	editor = this.editors[editorHash];
	if (editor == null || editor.control == null) // TODO: when we dont check the control we need to do some editor destruction along with the grid cause grid destruction removes all the editor HTML but not the hash
	{
		//	can maybe move away from the switch statment by eval'ing the type string ... 
		//	that would be less code, maybe a bit slower and easier to create new editors BUT harder to customize any editors ...
		switch (editorType)
		{
			case "LINK":
			case "HYPERLINK":
				editor = new nitobi.form.Link;
				break;
			case "IMAGE":
				return null;
			case "BUTTON":
				return null;
			case "LOOKUP": 
				editor = new nitobi.form.Lookup();
				break;
			case "LISTBOX":
				editor = new nitobi.form.ListBox();
				break;
			case "PASSWORD":
				editor = new nitobi.form.Password();
				break;
			case "TEXTAREA":
				editor = new nitobi.form.TextArea();
				break;
			case "CHECKBOX":
				editor = new nitobi.form.Checkbox();
				break;
			default:
				//	Here we need to check the datatype so that we can create the proper editor ...
				if (dataType == "DATE")
				{
					if (column.isCalendarEnabled()) 
						editor = new nitobi.form.Calendar();
					else
						editor = new nitobi.form.Date();
				}
				else if (dataType == "NUMBER")
					editor = new nitobi.form.Number();
				else
					editor = new nitobi.form.Text();
			break;
		}
		// Initialize the editor 
		editor.initialize();
	}

	this.editors[editorHash] = editor;

	return editor;
}

/**
 * @ignore
 */
nitobi.form.ControlFactory.prototype.dispose = function()
{
	for (var editor in this.editors)
	{
		this.editors[editor].dispose();
	}
}
//	this is the nitobi.form.ControlFactory.instance but it should likely be in a variable of type EBAGlobal (i have called it eba)
/**
 * @ignore
 */
nitobi.form.ControlFactory.instance = new nitobi.form.ControlFactory();
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class A link editor class.
 * @extends nitobi.form.Control
 */
nitobi.form.Link = function()
{
}

/**
 * @extends nitobi.form.Control
 */
nitobi.lang.extend(nitobi.form.Link, nitobi.form.Control);

nitobi.form.Link.prototype.initialize = function()
{
	/**
	 * @private
	 */
	this.url = "";
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.bind = function(owner, cell)
{
	nitobi.form.Link.base.bind.apply(this, arguments);
	this.url = this.cell.getValue(); 
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.mimic = function()
{
  	if(false == eval(this.owner.getOnCellValidateEvent())) return;
	this.click();
	this.deactivate();
}

//	align is implemented in the super
/**
 * @ignore
 */
nitobi.form.Link.prototype.deactivate = function()
{
	this.afterDeactivate(this.value);
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.click = function()
{
	this.control = window.open(this.url);
	this.value = this.url;
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.hide = function()
{
	// NOTE: This is required since hide should do nothing.
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.attachToParent = function()
{
	// NOTE: This is required since attachToParent should do nothing (Because the
	// link editor is currently non-editable.
}

/**
 * @ignore
 */
nitobi.form.Link.prototype.dispose = function()
{
	this.metadata = null;
	this.owner = null;
	this.context = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @constructor
 * @extends nitobi.form.Control
 */
nitobi.form.ListBox = function()
{
	nitobi.form.ListBox.baseConstructor.call(this);

	var ph = this.placeholder;
	ph.setAttribute("id", "listbox_span");
	// TODO: we need this top and left style for alignment
	ph.style.top="0px";
	ph.style.left="-5000px";

	this.metadata = null;

	this.keypress = false;
	
	/**
	 * track entered string for doing multiple character search
	 * @type String
	 * @private
	 */	
	this.typedString = null;

	this.events = [{type:"change", handler:this.deactivate},
					{type:"keydown", handler:this.handleKey},
					{type:"keyup",handler:this.handleKeyUp}, 
					{type:"keypress",handler:this.handleKeyPress},
					{type:"blur", handler:this.deactivate}];
}

nitobi.lang.extend(nitobi.form.ListBox, nitobi.form.Control);

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.initialize = function()
{
}

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.bind = function(owner, cell)
{
	nitobi.form.ListBox.base.bind.apply(this, arguments);

	var columnModel = cell.getColumnObject().getModel();
	// TODO: This is all crazy here.
	var sDatasourceId = columnModel.getAttribute('DatasourceId');
	this.dataTable = this.owner.data.getTable(sDatasourceId);

	this.eSET("onKeyPress", [columnModel.getAttribute('OnKeyPressEvent')]);
	this.eSET("onKeyDown", [columnModel.getAttribute('OnKeyDownEvent')]);
	this.eSET("onKeyUp", [columnModel.getAttribute('OnKeyUpEvent')]);
	this.eSET("onChange", [columnModel.getAttribute('OnChangeEvent')]);

	this.bindComplete(cell.getValue());
}

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.bindComplete = function(initialChar)
{
	//	TODO: This is ridiculous to re-render the HTML select box each time!!!
	//	We need only render it once since it never changes
	//	If we want dynamic loading of data then use the combo box!!!
	//	What does need to be done is the selectedIndex needs to be set based on the value - this happens in the xsl ...

	var datasourceXmlDoc = this.dataTable.xmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'datasource[@id=\''+this.dataTable.id+'\']');
	var oColumn = this.cell.getColumnObject();

	var colModel = oColumn.getModel();
	var displayFields = colModel.getAttribute('DisplayFields');
	var valueField = colModel.getAttribute('ValueField');

	var xsl = nitobi.form.listboxXslProc;
	xsl.addParameter('DisplayFields', displayFields, '');
	xsl.addParameter('ValueField', valueField, '');
	// TODO: this is not quite working yet.
	xsl.addParameter('val', initialChar, '');

	//Workaround for not being able to set the innerHTML of a select element in IE ...
	//http://support.microsoft.com/default.aspx?scid=kb;en-us;276228
	this.listXml = nitobi.xml.transformToXml(nitobi.xml.createXmlDoc(datasourceXmlDoc.xml), xsl);

	this.placeholder.rows[0].cells[0].innerHTML = nitobi.xml.serialize(this.listXml);

	var tc = this.control = nitobi.html.getFirstChild(this.placeholder.rows[0].cells[0]);
	tc.style.width = "100%";
	tc.style.height = (this.cell.DomNode.offsetHeight-2) + "px";

	nitobi.html.attachEvents(tc, this.events, this);
	nitobi.html.Css.addClass(tc.className, this.cell.getDomNode().className);

	this.align();

	this.focus();
	
	// If character is not blank then do search in list
    if( typeof(initialChar) != 'undefined' && initialChar != null && initialChar != '')
    {
        return this.searchComplete(initialChar);
    }	
}

//	render is in the super class
//	mimic is in the super class
//	align is in the super class

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.deactivate = function(ok)
{
	//	Need to check the blur value since deactivate can be called twice by
	//	the onblur handler on the textbox or by hitting enter which then causes the blur to occur ...
	if (this.keypress)
	{
		this.keypress = false;
		return;
	}
	
	if (nitobi.form.ListBox.base.deactivate.apply(this, arguments) == false) return;

	if (this.onChange.notify(this) == false) return;

	var c = this.control;

	var text = "", value = "";
	if (ok || ok == null) {
		//	get the tet and the value that is selected ...
		text = c.options[c.selectedIndex].text;
		value = c.options[c.selectedIndex].value;
	} else {
		value = this.cell.getValue();
		var len = c.options.length;
		for (var i=0; i<len; i++)
		{
			if (c.options[i].value == value)
				text = c.options[i].text;
		}
	}

	this.typedString = null;

	return this.afterDeactivate(nitobi.html.encode(text), value);
}

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.handleKey = function(evt)
{
	var k = evt.keyCode;

	this.keypress = false;

	var K = nitobi.form.Keys;

	switch (k) {
		case K.DOWN:
			// If we are at the end of the list the keypress down will not fire onchange
			if (this.control.selectedIndex < this.control.options.length - 1)
				this.keypress = true;
			break;
		case K.UP:
			// If we are at the start of the list the keypress going up will not fire onchange
			if (this.control.selectedIndex > 0)
				this.keypress = true;
			break;
		case K.ENTER:
		case K.TAB:
		case K.ESC:
			return nitobi.form.ListBox.base.handleKey.call(this, evt);
		default:
			// Prevent the editor from bluring in IE in particular
			nitobi.html.cancelEvent(evt);
			// in general let them enter the value and have the list select it.
	        return this.searchComplete(String.fromCharCode(k));
	}
}

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.searchComplete = function(keyVal, matchString)
{
    //var keyVal = String.fromCharCode(keyCode); // Convert ASCII Code to a string

    if( typeof(matchString) != 'undefined' && matchString != '' )
    {
        this.typedString = matchString;
        this.maxLinearSearch = 500;
    }
    else
    {
        this.typedString = this.typedString + keyVal; // Add to previously typed characters
    }

    var c = this.control;
    var elementCnt  = c.options.length;    // Calculate length of array -1

    if ( elementCnt > this.maxLinearSearch ) //make sure it's worthwhile doing a binary search
    {
        var result = this.searchBinary(this.typedString, 0, (elementCnt -1));
        if ( result )
        {
            //once match found, search backawards to first match in list
            for ( i = result; i > 0; i-- )
            {
                if (c.options[i].text.toLowerCase().substr(0,this.typedString.length) != this.typedString.toLowerCase())
                {
                    c.selectedIndex = i+1; // Make the relevant OPTION selected
                    break; //and STOP!
                }
            }
        }
    }
    else //it's not worthwhile doing a binary search because the number of items is too small, so search linearly
    {
        for (i = 1; i < elementCnt; i++)
        {
            if (c.options[i].text.toLowerCase().substr(0,this.typedString.length) == this.typedString.toLowerCase())
            {
                c.selectedIndex = i;
                break;
    }
        }
    }

    clearTimeout(this.timerid); // Clear the timeout

    var _this = this;
    this.timerid = setTimeout(function(){_this.typedString = "";},1000); // Set a new timeout to reset the key press string

    return false; // to prevent IE from doing its own highlight switching
}

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.searchBinary = function(matchString, low, high)
{
    /* Termination check */
    if (low > high)
    {
        return null;
    }

    var c = this.control;

    var mid = Math.floor((high+low)/2);
    var selectText = c.options[mid].text.toLowerCase().substr(0,matchString.length);
    var matchText = matchString.toLowerCase();

    if ( matchText == selectText )
    {
        return mid;
    }
    else if ( matchText < selectText )
    {
        return this.searchBinary(matchString, low, (mid -1));
    }
    else if ( matchText > selectText )
    {
        return this.searchBinary(matchString, (mid + 1), high);
    }
    else
    {
        return null;
    }

}

//	setEditCompleteHandler is implemented in the super class ....

/**
 * @ignore
 */
nitobi.form.ListBox.prototype.dispose = function()
{
	nitobi.html.detachEvents(this.control, this.events);
	this.placeholder = null;
	this.control = null;
	this.listXml = null;
	this.element = null;
	this.metadata = null;
	this.owner = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @constructor
 */
nitobi.form.Lookup = function()
{
	nitobi.form.Lookup.baseConstructor.call(this);
	this.selectClicked = false;
	this.bVisible = false;

	var div = nitobi.html.createElement('div');
	div.innerHTML = 
			"<table class='ntb-input-border' border='0' cellpadding='0' cellspacing='0'><tr><td class=\"ntb-lookup-text\"></td></tr><tr><td style=\"position:relative;\"><div style=\"position:relative;top:0px;left:0px;\"></div></td></tr></table>";
	var ph=this.placeholder=div.firstChild;
	ph.setAttribute("id", "lookup_span");
	// TODO: these are needed for alignment 
	ph.style.top="-0px";
	ph.style.left="-5000px";

	// width is required to be able to fit the textbox to its parent width the first time
	var tc=this.control=nitobi.html.createElement('input', {autocomplete:"off"}, {zIndex:"2000", width:"100px"});
	tc.setAttribute("id","ntb-lookup-text");

	this.textEvents = [{type:"keydown",handler:this.handleKey}, 
					{type:"keyup",handler:this.filter}, 
					{type:"keypress",handler:this.handleKeyPress},
					{type:"change",handler:this.handleChange},
					{type:"blur",handler:function(){/*console.log('blur');*/}},
					{type:"focus",handler:function(){/*console.log('focus');*/}}];

	ph.rows[0].cells[0].appendChild(tc);

	// We don't create the <select> element here since select.innerHTML doesnt work :(
	this.selectPlaceholder = ph.rows[1].cells[0].firstChild;

	this.selectEvents = [{"type":"click","handler":this.handleSelectClicked}];

	/**
	 * This is a hack for preventing the keyup event on the control from sending back a
	 * server request on the first time that the keyup event is fired. This is because the bind
	 * is first called which will do a get and then the keyup will also do a get ...
	 * @type Boolean
	 * @private
	 */
	this.firstKeyup = false;
	/**
	 * This is a flag indicating if the contents of the textbox has been autocompleted
	 * @type Boolean
	 * @private
	 */
	this.autocompleted = false;

	/**
	 * Get data from another column and pass it to the get handler
	 * @type String
	 * @private
	 */
    this.referenceColumn = null;
	/**
	 * enable autocomplete (in my case I want to turn it off)
	 * @type Boolean
	 * @private
	 */	
    this.autoComplete = null;
	/**
	 * enable autoclear of cell if value is not selected from list
	 * @type Boolean
	 * @private
	 */	
    this.autoClear = null;
	/**
	 * enable ondemand calling of gethandler 
	 * @type Boolean
	 * @private
	 */	
	this.getOnEnter = null;

	this.listXml = null;
	this.listXmlLower = null;

	this.editCompleteHandler = null;

	this.delay = 0;
	this.timeoutId = null;

	var xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">";
	xsl+="<xsl:output method=\"text\" version=\"4.0\"/><xsl:param name='searchValue'/>";
	xsl+="<xsl:template match=\"/\"><xsl:apply-templates select='//option[starts-with(.,$searchValue)][1]' /></xsl:template>";
	xsl+="<xsl:template match=\"option\"><xsl:value-of select='@rn' /></xsl:template></xsl:stylesheet>";

	var searchXslDoc = nitobi.xml.createXslDoc(xsl);
	this.searchXslProc = nitobi.xml.createXslProcessor(searchXslDoc);
	searchXslDoc = null;
}

nitobi.lang.extend(nitobi.form.Lookup, nitobi.form.Control);
nitobi.lang.implement(nitobi.form.Lookup, nitobi.ui.IDataBoundList);
nitobi.lang.implement(nitobi.form.Lookup, nitobi.form.IBlurable);

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.initialize = function()
{
	this.firstKeyup = false;
	nitobi.html.attachEvents(this.control, this.textEvents, this);
	nitobi.html.attachEvents(this.selectPlaceholder, this.selectEvents, this);
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.hideSelect = function()
{
	this.selectControl.style.display = "none";
	this.bVisible = false;
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.bind = function(owner, cell, searchString)
{
	nitobi.form.Lookup.base.bind.apply(this, arguments);

	var col = this.column = this.cell.getColumnObject();
	var columnModel = this.column.getModel();

	// TODO: This is all crazy here.
	this.datasourceId = col.getDatasourceId();
	this.getHandler = col.getGetHandler();
	this.delay = col.getDelay();

	this.size = col.getSize();
	
	this.referenceColumn = col.getReferenceColumn();
	this.autoComplete = col.isAutoComplete();
	this.autoClear = col.isAutoClear();
	this.getOnEnter = col.isGetOnEnter();
	
	this.displayFields = col.getDisplayFields();
	this.valueField = col.getValueField();

	this.eSET("onKeyPress", [col.getOnKeyPressEvent()]);
	this.eSET("onKeyDown", [col.getOnKeyDownEvent()]);
	this.eSET("onKeyUp", [col.getOnKeyUpEvent()]);
	this.eSET("onChange", [col.getOnChangeEvent()]);

	// By now the DisplayFields parameter contains the mapped field names.
	var listboxXsl = nitobi.form.listboxXslProc;
	listboxXsl.addParameter('DisplayFields', this.displayFields, '');
	listboxXsl.addParameter('ValueField', this.valueField, '');

	this.dataTable = this.owner.data.getTable(this.datasourceId);
	this.dataTable.setGetHandler(this.getHandler);
	this.dataTable.async = false;

	if (searchString.length <= 0) searchString = this.cell.getValue();

	this.get(searchString, true);
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.getComplete = function(searchString)
{
 	var datasourceXmlDoc = this.dataTable.getXmlDoc(); 

	// By now the DisplayFields parameter contains the mapped field names.
	var listboxXsl = nitobi.form.listboxXslProc;
	listboxXsl.addParameter('DisplayFields', this.displayFields, '');
	listboxXsl.addParameter('ValueField', this.valueField, '');
	listboxXsl.addParameter('val', nitobi.xml.constructValidXpathQuery(this.cell.getValue(),false), '');

	// IE 6 standards mode layout problem - need to specify the size of the select to make it have any height
	if (nitobi.browser.IE && document.compatMode == "CSS1Compat")
		listboxXsl.addParameter('size', 6, '');

	//Workaround for not being able to set the innerHTML of a select element in nitobi.browser.IE ...
	//http://support.microsoft.com/default.aspx?scid=kb;en-us;276228

	//	TODO: this should not be creating an XML doc from the xml string!!!
	this.listXml = nitobi.xml.transformToXml(nitobi.xml.createXmlDoc(datasourceXmlDoc.xml), nitobi.form.listboxXslProc);
	this.listXmlLower = nitobi.xml.createXmlDoc(this.listXml.xml.toLowerCase());

	// Clear the size attribute so that it doesnt affect the Listbox control
	if (nitobi.browser.IE && document.compatMode == "CSS1Compat")
		listboxXsl.addParameter('size', '', '');

	this.selectPlaceholder.innerHTML = nitobi.xml.serialize(this.listXml);

	var tc = this.control;
	// Setup the select control for the lookup
	var sc = this.selectControl = nitobi.html.getFirstChild(this.selectPlaceholder);
	sc.setAttribute("id","ntb-lookup-options");
	sc.setAttribute("size", this.size);
	sc.style.display = "none";
	// Bug in IE6 improperly renders the select.
	if (nitobi.browser.IE6 && document.compatMode != "CSS1Compat")
		sc.style.height = "100%";

	// TODO: this is a pain since we re-call the blurable interface and so destroy any state like lastFocus in IBlurable
	// Setup the blurable interface to capture blur events on multiple different elements
	nitobi.form.IBlurable.call(this, [tc, sc], this.deactivate);

	this.selectClicked = false;
	this.bVisible = false;

	this.align();

	// Now we need to adjust the editor width for padding / borders etc
	nitobi.html.fitWidth(this.placeholder, this.control);

	if( this.autoComplete )
	{
		var rn = this.search(searchString);

		if (rn > 0)
		{
			sc.selectedIndex = rn-1;
			tc.value = sc[sc.selectedIndex].text;
			nitobi.html.highlight(tc, tc.value.length - (tc.value.length - searchString.length));
			this.autocompleted = true;
		}
		// Check to see if there is a selection from the possible rows.
		else
		{
			var row = datasourceXmlDoc.selectSingleNode('//'+nitobi.xml.nsPrefix+'e[@' + this.valueField + '=\'' + searchString + '\']');
			if (row != null)
			{
				//	TODO: displayFields can possibly be | separated values.
				tc.value = row.getAttribute(this.displayFields);
				var rn = this.search(tc.value);
				sc.selectedIndex = parseInt(rn)-1;
			}
			else
			{
				// If this is a custom value, just use the custom value.
				tc.value = searchString;
				sc.selectedIndex=-1;
			}
		}
	}
    else
    {
        // If this is a custom value, just use the custom value.
        tc.value = searchString;
        sc.selectedIndex=-1;
    }	

	tc.parentNode.style.height = nitobi.html.getHeight(this.cell.getDomNode()) + "px";

	sc.style.display = 'inline';
	
	tc.focus();
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.handleSelectClicked = function (evt)
{
	this.control.value = this.selectControl.selectedIndex != -1 ? this.selectControl.options[this.selectControl.selectedIndex].text : "";
	this.deactivate(evt);
	//TODO: this was causing problems in IE, so i removed it, but its still not complete
	//this.focus();

	// TODO: maybe we need this ...
	// if (evt.srcElement.tagName == "OPTION")
	// this.deactivate;
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.focus = function (evt)
{
	this.control.focus();
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.deactivate = function(evt)
{
	if (nitobi.form.Lookup.base.deactivate.apply(this, arguments) == false) return;

	var sc = this.selectControl;
	var tc = this.control;

	var text = "", value = "";

	// If there was a match in the list, then select the match, otherwise 
	// the value is a custom value.
	if (evt != null && evt != false) 
	{
		// If an item from the list is selected, pick that one, otherwise pick the custom text.
		if (sc.selectedIndex >= 0)
		{
			value = sc.options[sc.selectedIndex].value;
			text = sc.options[sc.selectedIndex].text;
		}
		else
		{
			// ForceValidOption determines whether to restrict the cell's value to only items
			// retrieved from the server
			if (this.column.getModel().getAttribute("ForceValidOption") != "true")
			{
				value = tc.value;
				text = value;
			}
			else if (this.autoClear)
			{
				value = "";
				text = "";
			}
			else
			{
				value = this.cell.getValue();
				var len = sc.options.length;
				for (var i=0; i<len; i++)
				{
					if (sc.options[i].value == value)
						text = sc.options[i].text;
				}
			}
		}
	} else {
		value = this.cell.getValue();
		var len = sc.options.length;
        var found = false;
        for (var i=0; i<len; i++)
        {
            if (sc.options[i].value == value)
            {
                text = sc.options[i].text;
                found = true;
                break;
            }
        }

        if( !found && this.autoClear)
        {
            value = '';
            text = '';
        }
	}

	nitobi.html.detachEvents(sc, this.textEvents);

	// Clear any pending timeout to send a request to the server
	window.clearTimeout(this.timeoutId);

	return this.afterDeactivate(nitobi.html.encode(text), value);
}

/**
 * HandleKey deals with keys that we want to mask out. For example, esc and enter are masked to 
 * cause the lookup to deactivate.
 * @param {nitobi.html.Event} evt The event object.
 * @param {HtmlElement} element The HTML element that the event handler was registered on.
 */
nitobi.form.Lookup.prototype.handleKey = function(evt, element)
{
	
	var k = evt.keyCode;
	// If the user pressed up or down, don't blur the select
	if (k != 40 && k != 38)
		nitobi.form.Lookup.base.handleKey.call(this, evt);
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.search = function(searchValue)
{
	searchValue = nitobi.xml.constructValidXpathQuery(searchValue,false);

	this.searchXslProc.addParameter('searchValue', searchValue.toLowerCase(), '');

	var lineno = nitobi.xml.transformToString(this.listXmlLower, this.searchXslProc);

	if ("" == lineno)
		lineno=0;
	else
		lineno=parseInt(lineno);

	return lineno;
}

//	Filter runs on keypress - so the key has actually gone 
//	through handleKey and is now in the textbox ready to 
//	filter the listbox below.
/**
 * @ignore
 */
nitobi.form.Lookup.prototype.filter = function(evt, o)
{
	var k=evt.keyCode;
	
	if (this.onKeyUp.notify(evt) == false) return;

	if (!this.firstKeyup  && k != 38 && k != 40)
	{
		this.firstKeyup = true;
		return;
	}
	
	var tc = this.control;
	var sc = this.selectControl;

	switch (k) {
		case 38:
			if (sc.selectedIndex == -1) sc.selectedIndex=0;
			if (sc.selectedIndex > 0) sc.selectedIndex--;

			tc.value = sc.options[sc.selectedIndex].text;
			nitobi.html.highlight(tc, tc.value.length);
			tc.select();
			break;
		case 40:
			if (sc.selectedIndex < (sc.length -1)) {
				sc.selectedIndex++;
			}
			tc.value = sc.options[sc.selectedIndex].text;
			nitobi.html.highlight(tc, tc.value.length);
			tc.select();
			break;

		default:
			if ((!this.getOnEnter && ((k<193 && k>46) || k==8 || k==32)) // All keys, backspace, del
				|| (this.getOnEnter && k== 13))						  	 // enter
			{
				var searchValue = tc.value;
				this.get(searchValue);
			}
/*
			//search
			lineno = this.search(searchValue);

			//8 = backspace 46 = delete
			// Don't highlight anything if delete or backspace was pressed.
			if (lineno > 0 && k != 8 && k!=46 && (k<188 && k>46))
			{
				sc.selectedIndex = lineno-1;
				tc.value = sc[sc.selectedIndex].text;
				nitobi.html.highlight(tc, tc.value.length - (tc.value.length - searchValue.length));
			}
			else 
			{
				sc.selectedIndex=-1;
			}
*/
		}
}
/**
 * Gets the data from the server using a SYNCHRONOUS get request.
 * @ignore
 */
nitobi.form.Lookup.prototype.get = function(searchString, force)
{
	if (this.getHandler != null && this.getHandler != ''/*&& !oColumn.fire("BeforeLookup")*/)
	{		
		if (force || !this.delay)
		{
			this.doGet(searchString);
		}
		else
		{
			if (this.timeoutId)
			{
				// cancel the pending request.
				window.clearTimeout(this.timeoutId);
				this.timeoutId = null;
			}
			this.timeoutId = window.setTimeout(nitobi.lang.close(this, this.doGet, [searchString]), this.delay);
		}
	}else{
		this.getComplete(searchString);
	}
}

/**
 * @ignore
 */
nitobi.form.Lookup.prototype.doGet = function(searchString)
{
	// We are using a remote datasource
	if (searchString)
	{
		this.dataTable.setGetHandlerParameter("SearchString",searchString);
	}
	if(this.referenceColumn != null && this.referenceColumn != '')
	{
		//get value
		var referenceValue = this.owner.getCellValue(this.cell.row,this.referenceColumn);
		this.dataTable.setGetHandlerParameter("ReferenceColumn",referenceValue);
	}
	//, nitobi.lang.close(this, this.getComplete, [searchString])
	this.dataTable.get(null, this.pageSize, this);

	this.timeoutId = null;

	this.getComplete(searchString);
}

//	setEditCompleteHandler is implemented in the super class ....
/**
 * @ignore
 */
nitobi.form.Lookup.prototype.dispose = function()
{
	this.placeholder = null;
	nitobi.html.detachEvents(this.textEvents, this);
	this.selectControl = null;
	this.control = null;
    this.dataTable = null;	
	this.owner = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Number is a number editor class that is implemented using an HTML <input> tag.
 * @class
 * @constructor
 */
nitobi.form.Number = function()
{
	nitobi.form.Number.baseConstructor.call(this);
	this.defaultValue = 0;
}

nitobi.lang.extend(nitobi.form.Number, nitobi.form.Text);

nitobi.form.Number.prototype.handleKey = function(evt)
{
	nitobi.form.Number.base.handleKey.call(this, evt);

	var k = evt.keyCode;
	if (!this.isValidKey(k))
	{
		nitobi.html.cancelEvent(evt);
		return false;
	}
}


nitobi.form.Number.prototype.isValidKey = function (k)
{
	
	if ((k < 48 || k > 57) && (k < 37 || k > 40) && (k < 96 || k > 105) && k != 190 && k != 110 && k != 189 && k != 109 && k != 9 && k != 45 && k != 46 && k != 8)
	{
		return false;
	}
	return true;
}

nitobi.form.Number.prototype.bind = function(owner, cell, initialKeyChar)
{
	var charCode = initialKeyChar.charCodeAt(0);
	if (charCode >= 97) charCode = charCode - 32;
	var k = this.isValidKey(charCode) ? initialKeyChar : "";
	nitobi.form.Number.base.bind.call(this, owner, cell, k);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.form.Password = function()
{
	nitobi.form.Password.baseConstructor.call(this, true);

	this.control.type = 'password';
}

nitobi.lang.extend(nitobi.form.Password, nitobi.form.Text);

//	everything else is in the base class
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class
 * @constructor
 * @extends nitobi.form.Text
 */
nitobi.form.TextArea = function()
{
	nitobi.form.TextArea.baseConstructor.call(this);

	var div = nitobi.html.createElement('div');
	div.innerHTML = 
			"<table border='0' cellpadding='0' cellspacing='0' class='ntb-input-border'><tr><td></td></table>";

	var ph = this.placeholder = div.firstChild;
	ph.style.top="-3000px";
	ph.style.left="-3000px";

	// We need this initial width so that we can fit the textarea to it's parent node width
	this.control = nitobi.html.createElement('textarea', {}, {width:"100px"});
}

nitobi.lang.extend(nitobi.form.TextArea, nitobi.form.Text);

/**
 * @private
 */
nitobi.form.TextArea.prototype.initialize = function()
{
	this.placeholder.rows[0].cells[0].appendChild(this.control);
	document.body.appendChild(this.placeholder);

	nitobi.html.attachEvents(this.control, this.events, this);
}

/**
 * @private
 */
nitobi.form.TextArea.prototype.mimic = function()
{
	nitobi.form.TextArea.base.mimic.call(this);
	// TODO: this needs to be parameterized...
	var phs = this.placeholder.style;
}

/**
 * @private
 */
nitobi.form.TextArea.prototype.handleKey = function(evt)
{
	var k = evt.keyCode;

	// Textarea needs to support arrow keys to navigate through the text
	if (k==40 || k==38 || k==37 || k==39 || (k==13 && evt.shiftKey)) {
		//not sure why we were doing this, but it causes the event to get fired twice
		/*
		if (k==13 && evt.shiftKey) {
			if (nitobi.browser.MOZ) // We are using Mozilla and the keyCode is read-only
				nitobi.html.createEvent("KeyEvents", "keypress", evt, {'keyCode':13, 'charCode':0});
			if(this.control.createTextRange)
			{
				// Make sure the object has the focus, otherwise you select the whole page.
				this.control.focus();
				var textarea = document.selection.createRange(); //.duplicate();
				textarea.text = "\n";
				textarea.collapse(false);
				textarea.select();
			}
		}
		*/
	}
	else { // If it was not a special textarea key then just call the parent handleKey method
		nitobi.form.TextArea.base.handleKey.call(this, evt);
	}
};


//	setEditCompleteHandler is implemented in the super class ....
//	dispose is in the base class
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Text is a text editor class that is implemented using an HTML input tag
 * @class
 * @constructor
 * @extends nitobi.form.Control
 */
nitobi.form.Calendar = function()
{
	nitobi.form.Calendar.baseConstructor.call(this);

	var div = nitobi.html.createElement('div');
	div.innerHTML = 
			"<table border='0' cellpadding='0' cellspacing='0' style='table-layout:fixed;' class='ntb-input-border'><tr><td>" +
			"<input id='ntb-datepicker-input' type='text' maxlength='255' style='width:100%;' />" +
			"</td><td class='ntb-datepicker-button'><a id='ntb-datepicker-button' href='#' onclick='return false;'></a></td></tr><tr><td colspan='2' style='width:1px;height:1px;position:relative;'><!-- --></td></tr><colgroup><col></col><col style='width:20px;'></col></colgroup></table>";

	this.control = div.getElementsByTagName('input')[0];

	var ph = this.placeholder = div.firstChild;
	ph.setAttribute("id","calendar_span");
	// TODO: these are needed for when we call align
	ph.style.top="-3000px";
	ph.style.left="-3000px";
	var pd = this.pickerDiv = nitobi.html.createElement('div',{},{position:"absolute"});
	this.isPickerVisible = false;
	nitobi.html.Css.addClass(pd, NTB_CSS_HIDE);
	ph.rows[1].cells[0].appendChild(pd);
}

nitobi.lang.extend(nitobi.form.Calendar, nitobi.form.Control);

/**
 * This is called each time the editor is ready to be used.
 */
nitobi.form.Calendar.prototype.initialize = function()
{
	var dp = this.datePicker = new nitobi.calendar.DatePicker(nitobi.component.getUniqueId());
	dp.setAttribute("theme", "flex");
	dp.setObject(new nitobi.calendar.Calendar());
	dp.onDateSelected.subscribe(this.handlePick,this);
	dp.setContainer(this.pickerDiv);

	var tc = this.control;
	var H = nitobi.html;
	H.attachEvent(tc, 'keydown', this.handleKey, this, false);
	H.attachEvent(tc, 'blur', this.deactivate, this, false);

	H.attachEvent(this.pickerDiv, 'mousedown', this.handleCalendarMouseDown, this);
	H.attachEvent(this.pickerDiv, 'mouseup', this.handleCalendarMouseUp, this);

	var a = this.placeholder.getElementsByTagName('a')[0];
	H.attachEvent(a, 'mousedown', this.handleClick, this);
	H.attachEvent(a, 'mouseup', this.handleMouseUp, this);
}

//cell, xModel, xData, initialKeyChar
/**
 * @private
 */
nitobi.form.Calendar.prototype.bind = function(owner, cell, initialKeyChar)
{	
	this.isPickerVisible = false;
	nitobi.html.Css.addClass(this.pickerDiv, NTB_CSS_HIDE);

	nitobi.form.Calendar.base.bind.apply(this, arguments);

	if(initialKeyChar != null && initialKeyChar != '')
		this.control.value = initialKeyChar;
	else
		this.control.value = cell.getValue();

	this.column = this.cell.getColumnObject();
	this.control.maxlength = this.column.getModel().getAttribute('MaxLength');
}

/**
 * Mimic is responsible for placing and sizing the editor control
 * to the desired position on the screen.
 */
nitobi.form.Calendar.prototype.mimic = function()
{
	this.align();

	// Now we need to adjust the editor width for padding/borders etc
	//nitobi.html.fitWidth(this.placeholder, this.control);

	// Hack-y fix.
	var tableWidth = this.placeholder.offsetWidth;
	var iconWidth = this.placeholder.rows[0].cells[1].offsetWidth;
	this.control.style.width = tableWidth - iconWidth - (document.compatMode == "BackCompat"?0:8) + "px";
	
	this.selectText();
}

/**
 * @private
 */
nitobi.form.Calendar.prototype.deactivate = function()
{
	if (nitobi.form.Calendar.base.deactivate.apply(this, arguments) == false) return;

	this.afterDeactivate(this.control.value);
}

/**
 * @private
 */
nitobi.form.Calendar.prototype.handleClick = function(evt)
{
	if (!this.isPickerVisible)
	{
		var dp = this.datePicker;
		dp.setSelectedDate(nitobi.base.DateMath.parseIso8601(this.control.value));
		dp.render();
		dp.getCalendar().getHtmlNode().style.overflow = "visible";
		dp.getCalendar().getHtmlNode().style.width = "182px";
		nitobi.html.Css.setStyle(dp.getCalendar().getHtmlNode(), "position", "fixed");
	}

	this.ignoreBlur = true;
	//node.innerHTML = !this.isPickerVisible ? "&#9650;" : "&#9660;";
	nitobi.ui.Effects.setVisible(this.pickerDiv, !this.isPickerVisible, "none", this.setVisibleComplete, this);
};

/**
 * @private
 * Handles the <code>mouseup</code> event on the calendar button.
 */
nitobi.form.Calendar.prototype.handleMouseUp = function(evt) 
{
	this.control.focus()
	this.ignoreBlur = false;
}

/**
 * @private
 * Handles the <code>mousedown</code> event on the calendar.
 */
nitobi.form.Calendar.prototype.handleCalendarMouseDown = function(evt)
{
	this.ignoreBlur = true;
}

/**
 * @private
 * Handles the <code>mouseup</code> event on the calendar.
 */
nitobi.form.Calendar.prototype.handleCalendarMouseUp = function(evt)
{
	this.handleMouseUp(evt);
}

/**
  @ignore
 */
nitobi.form.Calendar.prototype.setVisibleComplete = function()
{
	this.isPickerVisible = !this.isPickerVisible;
};

nitobi.form.Calendar.prototype.handlePick = function()
{
	var date = this.datePicker.getSelectedDate();
	var fDate = nitobi.base.DateMath.toIso8601(date);
	this.control.value = fDate;
	this.datePicker.hide();
};

//	setEditCompleteHandler is implemented in the super class ....
/**
 * @private
 */
nitobi.form.Calendar.prototype.dispose = function()
{
	//this.control.onkeydown = null;
	nitobi.html.detachEvent(this.control, 'keydown', this.handleKey);
	//this.control.onblur = null;
	nitobi.html.detachEvent(this.control, 'blur', this.deactivate);
	var parent = this.placeholder.parentNode;
	parent.removeChild(this.placeholder);
	this.control = null;
	this.placeholder = null;
	this.owner = null;
	this.cell = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.form");

/**
 * The Keys class contains constants for various keycodes.
 */
nitobi.form.Keys = {
	UP: 38,
	DOWN: 40,
	ENTER: 13,
	TAB: 9,
	ESC: 27,
  RIGHT: 39,
  LEFT: 37
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * A abstract class the represents a UI element on the screen.
 * @param xml {string} XML that defines the element.
 * @param xsl {string} XSL that enables rendering of the object.
 * @param id {string} The id of the object.
 * @private
 */
nitobi.ui.UiElement = function (xml,xsl,id)
{
	if (arguments.length > 0)
	{
		this.initialize(xml,xsl,id);	
	}
}

/**
 * Initializes the object.
 * @private
 */
nitobi.ui.UiElement.prototype.initialize = function (xml,xsl,id)
{
	this.m_Xml = xml;
	this.m_Xsl = xsl;
	this.m_Id = id;
	this.m_HtmlElementHandle=null;
}

/**
 * The height of the element.
 * @return {string} The height of the object including the type of unit used, e.g., 10px.
 */
nitobi.ui.UiElement.prototype.getHeight = function ()
{
	return this.getHtmlElementHandle().style.height;
}

/**
 * Sets the height of the element.
 * @param height {string} The height of the element including its units, e.g., 10px.
 */
nitobi.ui.UiElement.prototype.setHeight = function (height)
{
	this.getHtmlElementHandle().style.height = height + "px";
}


/**
 * The Id of the element.
 * @return {string} The id of the element. 
 */
nitobi.ui.UiElement.prototype.getId = function ()
{
	return this.m_Id;
}

/**
 * The Id of the element.
 * @param id {string} The Id. It must be unique on the page.
 */
nitobi.ui.UiElement.prototype.setId = function (id)
{
	this.m_Id = id;
}


/**
 * The width of the element.
 * @return {string} The width of the element including its units, e.g., 10px.  
 */
nitobi.ui.UiElement.prototype.getWidth = function ()
{
	return this.getHtmlElementHandle().style.width;
}


/**
 * The width of the element.
 * @param width {string} The width of the element including its units, e.g., 10px.
 */
nitobi.ui.UiElement.prototype.setWidth = function (width)
{
	if(width > 0)
		this.getHtmlElementHandle().style.width = width + "px";
}


/**
 * The XML that defines the element.  The XML is used together with the XSL to render.
 * @return {string} The XML.
 */
nitobi.ui.UiElement.prototype.getXml = function ()
{
	return this.m_Xml;
}

/**
 * The XML that defines the element. The XML is used together with the XSL to render.
 * @param xml {string} XML.
 */
nitobi.ui.UiElement.prototype.setXml = function (xml)
{
	this.m_Xml = xml;
}

/**
 * The XSL that defines the element.  The XSL is used together with the XML to render.
 * @return {string} The XSL.
 */
nitobi.ui.UiElement.prototype.getXsl = function ()
{
	return this.m_Xsl;
}

/**
 * The XSL that defines the element. The XSL is used together with the XML to render.
 * @param xsl {string} XSL.
 */
nitobi.ui.UiElement.prototype.setXsl = function (xsl)
{
	this.m_Xsl = xsl;
}

/**
 * A handle to the html element that represents this UI object.
 * @return {object} An HTML element reference.
 */
nitobi.ui.UiElement.prototype.getHtmlElementHandle = function ()
{
	if (!this.m_HtmlElementHandle)
	{
		this.m_HtmlElementHandle = document.getElementById(this.m_Id);
	}
	return this.m_HtmlElementHandle;
}


/**
 * @private
 */
nitobi.ui.UiElement.prototype.setHtmlElementHandle = function (htmlElementHandle)
{
	this.m_HtmlElementHandle = htmlElementHandle;
}


/**
 * Hides the element.
 */
nitobi.ui.UiElement.prototype.hide = function ()
{
	var tag = this.getHtmlElementHandle();
	tag.style.visibility="hidden";
	tag.style.position="absolute";
}

/**
 * Shows the element.
 */
nitobi.ui.UiElement.prototype.show = function ()
{
	var tag = this.getHtmlElementHandle();
	tag.style.visibility="visible";
}


/**
 * Returns true if the element is visible and false otherwise.
 */
nitobi.ui.UiElement.prototype.isVisible = function ()
{
	var tag = this.getHtmlElementHandle();
	return tag.style.visibility=="visible";
}


/**
 * Makes the element float in absolute position mode.
 */
nitobi.ui.UiElement.prototype.beginFloatMode = function ()
{
	var tag = this.getHtmlElementHandle();
	tag.style.position="absolute";
}

/**
 * Returns true if the element is floating or not.
 */
nitobi.ui.UiElement.prototype.isFloating = function ()
{
	var tag = this.getHtmlElementHandle();
	return	tag.style.position=="absolute";
}

/**
 * If the element is floating, sets the x position.
 * @param x {string} The x position including its units.
 */
nitobi.ui.UiElement.prototype.setX = function (x)
{
	var tag = this.getHtmlElementHandle();
	tag.style.left=x + "px";
}


/**
 * If the element is floating, gets the x position.
 * @return {string} The x position including its units.
 */
nitobi.ui.UiElement.prototype.getX = function ()
{
	var tag = this.getHtmlElementHandle();
	return tag.style.left;
}

/**
 * If the element is floating, sets the y position.
 * @param y {string} The y position including its units.
 */
nitobi.ui.UiElement.prototype.setY = function (y)
{
	var tag = this.getHtmlElementHandle();
	tag.style.top=y + "px";
}

/**
 * If the element is floating, gets the y position.
 * @return {string} The y position including its units.
 */
nitobi.ui.UiElement.prototype.getY = function ()
{
	var tag = this.getHtmlElementHandle();
	return tag.style.top;
}

/**
 * Renders the Element using the XSL, XML and possibly the htmlElement.
 * @param htmlElement {object} A handle to the HTML element on the page inside
 * which the UiElement is rendered. If htmlElement is null, the UiElement is appended
 * to the end of the body.
 * @param xslDoc {object} The XSL Document that is used to render. If this is null, then the XSL
 * string defined in the object elsewhere is used. 
 * @param xmlDoc {object} The XML Document that is used to render. If this is null, then the XML
 * string defined in the object elsewhere is used. 
 * @see nitobi.ui.UiElement#setXsl 
 * @see nitobi.ui.UiElement#setXml
 */
nitobi.ui.UiElement.prototype.render = function (htmlElement,xslDoc,xmlDoc)
{
	var xsl = this.m_Xsl;
	if (xsl != null && xsl.indexOf("xsl:stylesheet") == -1)
	{
		xsl = "<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"html\" version=\"4.0\" />" + xsl
		+ "</xsl:stylesheet>";
	}
	
	if (null==xslDoc)
	{
		xslDoc = nitobi.xml.createXslDoc(xsl);
	}

	if (null==xmlDoc)
	{
		xmlDoc = nitobi.xml.createXmlDoc(this.m_Xml);
	}
	Eba.Error.assert(nitobi.xml.isValidXml(xmlDoc),"Tried to render invalid XML according to Mozilla. The XML is " + xmlDoc.xml);
	var html = nitobi.xml.transform(xmlDoc, xslDoc);
	if (html.xml) html = html.xml;

	if (null == htmlElement)
	{
		nitobi.html.insertAdjacentHTML(document.body,"beforeEnd",html);
	}
	else
	{
		htmlElement.innerHTML = html;
	}
	
	this.attachToTag();
}


/**
 * Attaches the javascript object to the HTML tag. Once this is called after render,
 * you can access the object by using the javascriptObject property on the HTML tag.
 */
nitobi.ui.UiElement.prototype.attachToTag = function ()
{

	var domNode = this.getHtmlElementHandle()
	if (domNode != null)
	{
		// Here for legacy, but we should not use this name.
		domNode.object=this;
		domNode.jsobject=this;
		
		// Use this instead.
		domNode.javascriptObject=this;
	}
};

// *****************************************************************************
// * Dispose
// *****************************************************************************
/// <function name="Dispose" access="public">
/// <summary></summary>
/// </function>
nitobi.ui.UiElement.prototype.dispose = function ()
{
	var domNode = this.getHtmlElementHandle()
	if (domNode != null)
	{
		domNode.object=null;
	}

	this.m_Xml = null;
	this.m_Xsl = null;
	this.m_HtmlElementHandle = null;
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
* An interactive ui element is defined by the fact it responds to user activity as
* opposed to being a static element. The HTML object that represents EBAInteractiveUIElement.
* @constructor
* @extends nitobi.ui.UiElement
* @param htmlObject {object} 
* @private
*/
nitobi.ui.InteractiveUiElement  = function(htmlObject)
{
	this.enable();
}

nitobi.lang.extend(nitobi.ui.InteractiveUiElement,nitobi.ui.UiElement);

/**
 * Puts the ui element in the enabled state.
 */
nitobi.ui.InteractiveUiElement.prototype.enable = function()
{
	this.m_Enabled=true;
}

/**
 * Puts the ui element in the disabled state.
 */
nitobi.ui.InteractiveUiElement.prototype.disable = function ()
{
	this.m_Enabled=false;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.ui.ButtonXsl=
   "<xsl:template match=\"button\">"+
      // "<a href=\"#\" class=\"ntb-button\">"+ // Temp removed due to css conflict with other apps.
         "<div class=\"ntb-button\" onmousemove=\"return false;\" onmousedown=\"if (this.object.m_Enabled) this.className='ntb-button-down';\" onmouseup=\"this.className='ntb-button';\" onmouseover=\"if (this.object.m_Enabled) this.className='ntb-button-highlight';\" onmouseout=\"this.className='ntb-button';\" align=\"center\">"+
			"<xsl:attribute name=\"image_disabled\">"+
			"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory and not(starts-with(@image_disabled,'/'))\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image_disabled)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							    "<xsl:value-of select=\"@image_disabled\" />"+
						"</xsl:otherwise>"+
			"</xsl:choose>"+
        
	         "</xsl:attribute>"+
	         
	         "<xsl:attribute name=\"image_enabled\">"+
					"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory and not(starts-with(@image,'/'))\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"@image\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>"+
		         "</xsl:attribute>"+
	         "<xsl:attribute name=\"title\">"+
	            "<xsl:value-of select=\"@tooltip_text\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"onclick\">"+
				// The following line is var e='@onclick_event';eval(this.OnClickHandler(e)); generated by EbaConstructValidXpathQuery
				// e.g. writeLog(EbaConstructValidXpathQuery("var e='X';eval(this.object.OnClickHandler(e));")); and then replace X with @onclick_event
	            "<xsl:value-of select='concat(&quot;v&quot;,&quot;a&quot;,&quot;r&quot;,&quot; &quot;,&quot;e&quot;,&quot;=&quot;,&quot;&apos;&quot;,@onclick_event,&quot;&apos;&quot;,&quot;;&quot;,&quot;e&quot;,&quot;v&quot;,&quot;a&quot;,&quot;l&quot;,&quot;(&quot;,&quot;t&quot;,&quot;h&quot;,&quot;i&quot;,&quot;s&quot;,&quot;.&quot;,&quot;o&quot;,&quot;b&quot;,&quot;j&quot;,&quot;e&quot;,&quot;c&quot;,&quot;t&quot;,&quot;.&quot;,&quot;o&quot;,&quot;n&quot;,&quot;C&quot;,&quot;l&quot;,&quot;i&quot;,&quot;c&quot;,&quot;k&quot;,&quot;H&quot;,&quot;a&quot;,&quot;n&quot;,&quot;d&quot;,&quot;l&quot;,&quot;e&quot;,&quot;r&quot;,&quot;(&quot;,&quot;e&quot;,&quot;)&quot;,&quot;)&quot;,&quot;;&quot;,&apos;&apos;)' />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"id\">"+
	            "<xsl:value-of select=\"@id\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"style\">"+
				"<xsl:choose>"+
					"<xsl:when test=\"../../@height\">"+
						"<xsl:value-of select=\"concat('float:left;width:',../../@height,'px;height:',../../@height - 1,'px')\" />"+
					"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"concat('float:left;width:',@width,'px;height:',@height,'px')\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>" + 
	         "</xsl:attribute>"+
         	 
            "<img border=\"0\">"+
	            "<xsl:attribute name=\"src\">"+
					"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory and not(starts-with(@image,'/'))\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"@image\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>"+
		         "</xsl:attribute>"+
		         "<xsl:attribute name=\"style\">"+
		        
					"<xsl:variable name=\"top_offset\">"+
						"<xsl:choose>"+
							"<xsl:when test=\"@top_offset\">"+
									"<xsl:value-of select=\"@top_offset\" />"+
							"</xsl:when>"+
							"<xsl:otherwise>"+
									"0"+
							"</xsl:otherwise>"+
						"</xsl:choose>" + 
					"</xsl:variable>"+

					"<xsl:choose>"+
						"<xsl:when test=\"../../@height\">"+
							"<xsl:value-of select=\"concat('MARGIN-TOP:',((../../@height - @height) div 2) - 1 + number($top_offset),'px;MARGIN-BOTTOM:0px')\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"concat('MARGIN-TOP:',(@height - @image_height) div 2,'px;MARGIN-BOTTOM:0','px')\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>" + 
				 "</xsl:attribute>"+
			// Note: this CDATA contains a space, which is required for IE.
            "</img><![CDATA[ ]]>"+
         "</div>"+
      //"</a>"+
   "</xsl:template>";


/**
 * A button.
 * @constructor
 * @extends nitobi.ui.InteractiveUiElement
 * @param xml {string} XML that defines the button.
 * @param id {string} The id of the button.
 * @private
 */
nitobi.ui.Button = function (xml, id)
{
	this.initialize(xml,nitobi.ui.ButtonXsl,id);
	this.enable();
}


nitobi.lang.extend(nitobi.ui.Button, nitobi.ui.InteractiveUiElement);
/**
 * Fired when the button is clicked.
 * @private
 */
nitobi.ui.Button.prototype.onClickHandler = function (callbackCode)
{
	if (this.m_Enabled)
	{
		eval(callbackCode);
	}
}

/**
 * Disables the button so that it cannot be clicked.
 */
nitobi.ui.Button.prototype.disable = function ()
{
	nitobi.ui.Button.base.disable.call(this);
	var button = this.getHtmlElementHandle();
	button.childNodes[0].src = button.getAttribute("image_disabled");
}

/**
 * Enables the button for use.
 */
nitobi.ui.Button.prototype.enable = function()
{
	nitobi.ui.Button.base.enable.call(this);
	var button = this.getHtmlElementHandle();
	button.childNodes[0].src=button.getAttribute("image_enabled");
}

nitobi.ui.Button.prototype.dispose = function()
{
	nitobi.ui.Button.base.dispose.call(this);
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.ui.BinaryStateButtonXsl=
   "<xsl:template match=\"binarystatebutton\">"+
      // "<a href=\"#\" class=\"ntb-button\">"+ // Temp removed due to css conflict with other apps.
         "<div class=\"ntb-binarybutton\" onmousemove=\"return false;\" onmousedown=\"if (this.object.m_Enabled) this.className='ntb-button-down';\" onmouseup=\"(this.object.isChecked()?this.object.check():this.object.uncheck())\" onmouseover=\"if (this.object.m_Enabled) this.className='ntb-button-highlight';\" onmouseout=\"(this.object.isChecked()?this.object.check():this.object.uncheck())\" align=\"center\">"+
			"<xsl:attribute name=\"image_disabled\">"+
			"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image_disabled)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							    "<xsl:value-of select=\"@image_disabled\" />"+
						"</xsl:otherwise>"+
			"</xsl:choose>"+
        
	         "</xsl:attribute>"+
	         
	         "<xsl:attribute name=\"image_enabled\">"+
					"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"@image\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>"+
		         "</xsl:attribute>"+
	         "<xsl:attribute name=\"title\">"+
	            "<xsl:value-of select=\"@tooltip_text\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"onclick\">"+
				// The following line is var e='@onclick_event';eval(this.OnClickHandler(e)); generated by EbaConstructValidXpathQuery
				// e.g. writeLog(EbaConstructValidXpathQuery("var e='X';eval(this.object.OnClickHandler(e));")); and then replace X with @onclick_event
	            "<xsl:value-of select='concat(\"this.object.toggle();\",&quot;v&quot;,&quot;a&quot;,&quot;r&quot;,&quot; &quot;,&quot;e&quot;,&quot;=&quot;,&quot;&apos;&quot;,@onclick_event,&quot;&apos;&quot;,&quot;;&quot;,&quot;e&quot;,&quot;v&quot;,&quot;a&quot;,&quot;l&quot;,&quot;(&quot;,&quot;t&quot;,&quot;h&quot;,&quot;i&quot;,&quot;s&quot;,&quot;.&quot;,&quot;o&quot;,&quot;b&quot;,&quot;j&quot;,&quot;e&quot;,&quot;c&quot;,&quot;t&quot;,&quot;.&quot;,&quot;o&quot;,&quot;n&quot;,&quot;C&quot;,&quot;l&quot;,&quot;i&quot;,&quot;c&quot;,&quot;k&quot;,&quot;H&quot;,&quot;a&quot;,&quot;n&quot;,&quot;d&quot;,&quot;l&quot;,&quot;e&quot;,&quot;r&quot;,&quot;(&quot;,&quot;e&quot;,&quot;)&quot;,&quot;)&quot;,&quot;;&quot;,&apos;&apos;)' />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"id\">"+
	            "<xsl:value-of select=\"@id\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"style\">"+
				"<xsl:choose>"+
					"<xsl:when test=\"../../@height\">"+
						"<xsl:value-of select=\"concat('float:left;width:',../../@height,'px;height:',../../@height - 1,'px')\" />"+
					"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"concat('float:left;width:',@width,'px;height:',@height,'px')\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>" + 
	         "</xsl:attribute>"+
         	 
            "<img border=\"0\">"+
	            "<xsl:attribute name=\"src\">"+
					"<xsl:choose>"+
						"<xsl:when test=\"../../@image_directory\">"+
							"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"@image\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>"+
		         "</xsl:attribute>"+
		         "<xsl:attribute name=\"style\">"+
		        
					"<xsl:variable name=\"top_offset\">"+
						"<xsl:choose>"+
							"<xsl:when test=\"@top_offset\">"+
									"<xsl:value-of select=\"@top_offset\" />"+
							"</xsl:when>"+
							"<xsl:otherwise>"+
									"0"+
							"</xsl:otherwise>"+
						"</xsl:choose>" + 
					"</xsl:variable>"+

					"<xsl:choose>"+
						"<xsl:when test=\"../../@height\">"+
							"<xsl:value-of select=\"concat('MARGIN-TOP:',((../../@height - @height) div 2) - 1 + number($top_offset),'px;MARGIN-BOTTOM:0px')\" />"+
						"</xsl:when>"+
						"<xsl:otherwise>"+
							"<xsl:value-of select=\"concat('MARGIN-TOP:',(@height - @image_height) div 2,'px;MARGIN-BOTTOM:0','px')\" />"+
						"</xsl:otherwise>"+
					"</xsl:choose>" + 
				 "</xsl:attribute>"+
			// Note: this CDATA contains a space, which is required for IE.
            "</img><![CDATA[ ]]>"+
         "</div>"+
      //"</a>"+
   "</xsl:template>";

/**
 * A button that has a binary state. It is other switched on or off.
 * @constructor
 * @extends nitobi.ui.Button
 * @param xml {string} XML that defines the button.
 * @param id {string} The id of the button.
 * @private
 */
nitobi.ui.BinaryStateButton = function (xml, id)
{
	this.initialize(xml,nitobi.ui.BinaryStateButtonXsl,id);
	/**
	 * @ignore
	 */
	this.m_Checked=false;
}

nitobi.lang.extend(nitobi.ui.BinaryStateButton, nitobi.ui.Button);

/**
 * Checks to see if the button is checked or not.
 * @return {bool} true if the button is checked and false otherwise.
 */
nitobi.ui.BinaryStateButton.prototype.isChecked = function()
{
	return this.m_Checked;
}

/**
 * Puts the button in the checked state.
 */
nitobi.ui.BinaryStateButton.prototype.check = function()
{
	var button = this.getHtmlElementHandle();
	button.className = "ntb-button-checked";
	this.m_Checked=true;
}

/**
 * Puts the button in the unchecked state.
 */
nitobi.ui.BinaryStateButton.prototype.uncheck = function()
{
	var button = this.getHtmlElementHandle();
	button.className = "ntb-button";
	this.m_Checked=false;
}

/**
 * Toggles the state of the button.
 */
nitobi.ui.BinaryStateButton.prototype.toggle = function()
{
	var button = this.getHtmlElementHandle();
	if (button.className == "ntb-button-checked")
	{
		this.uncheck();
	}
	else
	{
		this.check();
	};
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */

// *****************************************************************************
// *****************************************************************************
// * nitobi.ui.Toolbar
// *****************************************************************************
/// <class name='nitobi.ui.Toolbar'>
/// <summary>


/// </summary>

nitobi.ui.ToolbarDivItemXsl ="<xsl:template match=\"div\"><xsl:copy-of select=\".\"/></xsl:template>";

nitobi.ui.ToolbarXsl = 

   "<xsl:template match=\"//toolbar\">"+
      "<div style=\"z-index:800\">"+
         "<xsl:attribute name=\"id\">"+
            "<xsl:value-of select=\"@id\" />"+
         "</xsl:attribute>"+
         "<xsl:attribute name=\"style\">float:left;position:relative;"+
	            "<xsl:value-of select=\"concat('height:',@height,'px')\" />"+
	      "</xsl:attribute>"+
         "<xsl:apply-templates />"+
      "</div>"+
   "</xsl:template>"+
   nitobi.ui.ToolbarDivItemXsl +
   nitobi.ui.ButtonXsl +
   nitobi.ui.BinaryStateButtonXsl + 
   
      "<xsl:template match=\"separator\">"+
         "<div align='center'>"+
	         "<xsl:attribute name=\"style\">"+
	            "<xsl:value-of select=\"concat('float:left;width:',@width,';height:',@height)\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"id\">"+
				"<xsl:value-of select=\"@id\" />"+
			"</xsl:attribute>"+
         	 
            "<img border='0'>"+
	            "<xsl:attribute name=\"src\">"+
		            "<xsl:value-of select=\"concat(//@image_directory,@image)\" />"+
		         "</xsl:attribute>"+
		         "<xsl:attribute name=\"style\">"+
						"<xsl:value-of select=\"concat('MARGIN-TOP:3','px;MARGIN-BOTTOM:0','px')\" />"+
				 "</xsl:attribute>"+
            "</img>"+
         "</div>"+
   "</xsl:template>";
   
nitobi.ui.pagingToolbarXsl = 

   "<xsl:template match=\"//toolbar\">"+
      "<div style=\"z-index:800\">"+
         "<xsl:attribute name=\"id\">"+
            "<xsl:value-of select=\"@id\" />"+
         "</xsl:attribute>"+
         "<xsl:attribute name=\"style\">float:right;position:relative;"+
	            "<xsl:value-of select=\"concat('height:',@height,'px')\" />"+
	      "</xsl:attribute>"+
         "<xsl:apply-templates />"+
      "</div>"+
   "</xsl:template>"+
   nitobi.ui.ToolbarDivItemXsl +
   nitobi.ui.ButtonXsl +
   nitobi.ui.BinaryStateButtonXsl + 
   
      "<xsl:template match=\"separator\">"+
         "<div align='center'>"+
	         "<xsl:attribute name=\"style\">"+
	            "<xsl:value-of select=\"concat('float:right;width:',@width,';height:',@height)\" />"+
	         "</xsl:attribute>"+
	         "<xsl:attribute name=\"id\">"+
				"<xsl:value-of select=\"@id\" />"+
			"</xsl:attribute>"+
         	 
            "<img border='0'>"+
	            "<xsl:attribute name=\"src\">"+
		            "<xsl:value-of select=\"concat(//@image_directory,@image)\" />"+
		         "</xsl:attribute>"+
		         "<xsl:attribute name=\"style\">"+
						"<xsl:value-of select=\"concat('MARGIN-TOP:3','px;MARGIN-BOTTOM:0','px')\" />"+
				 "</xsl:attribute>"+
            "</img>"+
         "</div>"+
   "</xsl:template>";
   

/**
 * Constructor for nitobi.ui.Toolbar
 * @class The toolbar class manages the toolbar portion of the Nitobi Grid component.  You do not need to 
 * instantiate this class, rather you should use {@link nitobi.grid.Grid#getToolbars}
 * @param {XmlDocument} [xml] The xml document that defines the toolbar
 * @param {String} [id] An id uniquely identifying the toolbar
 * @private
 */
nitobi.ui.Toolbar = function (xml,id)
{
	nitobi.ui.Toolbar.baseConstructor.call(this);
	this.initialize(xml,nitobi.ui.ToolbarXsl,id);
}

nitobi.lang.extend(nitobi.ui.Toolbar, nitobi.ui.InteractiveUiElement);

/**
 * Returns a list of all the UiElements that the toolbar is displaying. You can access 
 * the elements by name.
 * @return {array} A list of UiElements.
 * @private
 */
nitobi.ui.Toolbar.prototype.getUiElements = function ()
{
	return this.m_UiElements;
}

/**
 * @private
 */
nitobi.ui.Toolbar.prototype.setUiElements = function (uiElements)
{
	this.m_UiElements = uiElements;
}

/**
 * Attaches all the elements that to toolbar has to the HTML elements
 * and the toolbar object.
 * @private
 */
nitobi.ui.Toolbar.prototype.attachButtonObjects = function ()
{
	if (!this.m_UiElements)
	{
		this.m_UiElements = new Array();
		var tag = this.getHtmlElementHandle();
		var children = tag.childNodes;

		for (var i = 0; i < children.length; i++)
		{
			var child = children[i];
			// Don't process white space nodes.
			if (child.nodeType!=3)
			{
				var newElement;
				switch(child.className)
				{
					case("ntb-button"):
					{
						newElement = new nitobi.ui.Button(null,child.id);	
					
						break;
					}
					case("ntb-binarybutton"):
					{
						newElement = new nitobi.ui.BinaryStateButton(null,child.id);	
						break;
					}
					default:
					{
						newElement = new nitobi.ui.UiElement(null,null,child.id);	
						break;
					}
				}
				newElement.attachToTag();
				this.m_UiElements[child.id]=newElement;
			}
		}
	}
}

/**
 * Renders the toolbar inside of the specified container. If the container is
 * null, then it renders at the end of the page.
 * @param htmlElement {object} The html element inside which the toolbar is rendered.
 */
nitobi.ui.Toolbar.prototype.render = function (htmlElement)
{
	nitobi.ui.Toolbar.base.base.render.call(this, htmlElement);
	this.attachButtonObjects();
}

/**
 * Disables each element in the toolbar.
 */
nitobi.ui.Toolbar.prototype.disableAllElements = function ()
{
	for (var i in this.m_UiElements) 
	{
		if (this.m_UiElements[i].disable)
		{
			this.m_UiElements[i].disable();
		}
	}
}

/**
 * Enables all elements in the toolbar.
 */
nitobi.ui.Toolbar.prototype.enableAllElements = function()
{
	for (var i in this.m_UiElements) 
	{
		if (this.m_UiElements[i].enable)
		{
			this.m_UiElements[i].enable();
		}
	}
}


/**
 * Attaches the toolbar object to the toolbar. You can then access the object using
 * the elements javascriptObject property.
 */
nitobi.ui.Toolbar.prototype.attachToTag = function ()
{
	nitobi.ui.Toolbar.base.base.attachToTag.call(this);
	this.attachButtonObjects();
}

nitobi.ui.Toolbar.prototype.dispose = function ()
{
	if (typeof(this.m_UiElements) != "undefined")
	{
		for (var button in this.m_UiElements)
		{
			this.m_UiElements[button].dispose();
		}
		this.m_UiElements = null;
	}
	nitobi.ui.Toolbar.base.dispose.call(this);
}

/// </class>
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
/*NITOBI_VERSION*/
/*NITOBI_BUILD_NUMBER*/
/*NITOBI_LICENSE*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// This makes the trial expiry after thirty days. 
// Be very careful around here. RefreshTrialDate expects
// the comment markers as they are, and searches for the number
// 1146951598375 and 1146692398375.



nitobi.prepare = function()
{
/*TRIAL*//*

ebagdl=1146951598375;
ebagd1=1146692398375;
s = "\u0076ar d \u003D n\u0065w \u0044a\u0074e\u0028)\u002E\u0067\u0065\u0074\u0054\u0069me\u0028);\u0069f (\u0028\u0064<" + ebagdl + ") || (d>"+ebagd1+"\u0029\u0029\u0020{\u0061\u006Ce\u0072\u0074('E\u0076\u0061\u006Cu\u0061\u0074\u0069on\u0020\u0070er\u0069\u006F\u0064 \u0068a\u0073 ex\u0070\u0069\u0072\u0065\u0064.\\n\\nPl\u0065\u0061\u0073e\u0020not\u0069\u0066y\u0020\u0079o\u0075r\u0020s\u0079\u0073\u0074em\u0020a\u0064\u006Dini\u0073trat\u006F\u0072\u002E\\n\\n\u0050u\u0072\u0063\u0068\u0061se\u0020\u0049n\u0066\u006Fr\u006Da\u0074ion:\\n\u0020 \u0020 \u0020\u0020 \u004EI\u0054O\u0042\u0049 SO\u0046\u0054W\u0041\u0052E\\n\\n \u0020 \u0020 \u0020\u0020\u0077ww\u002Enito\u0062\u0069\u002Ec\u006Fm\\n \u0020    \u0020\u0073\u0061\u006C\u0065\u0073@nit\u006Fb\u0069.\u0063om \u0020   \u0020\u0020 \u0020\\n \u0020\u0020\u0020\u0020\u0020 \u0054\u0065le\u0070\u0068one: (6\u00304\u0029\u0020\u0036\u00385\u002D928\u0037\\n  \u0020\u0020 \u0020\u0020Fa\u0078:\u0020(\u00360\u0034\u0029\u002064\u0038\u002D9\u00309\u0030\\n\u0020\u0020\u0020 \u0020  T\u006Fl\u006C-F\u0072\u0065\u0065: 1\u002D86\u0036-6\u0045\u0042\u002DAP\u0050S\\n\u0020 \u0020  \u0020 \u0020\u0020\u0020\u0020  \u0020 \u0020 \u0020  \u0020\u0020\u00281\u002D\u0038\u00366-63\u0032\u002D\u00327\u0037\u0037)\u0027\u0029\u003B}";
eval(s);

*//*TRIAL*/

/*STRIPONLINECHECK
// This is used to fix this file to our website. Only used for the online version.
// Note, you have to use throw; return gives an error.
var cs;
cs="\x69\u0066 \u0028d\x6F\u0063\u0075\u006D";
cs+="\x65nt\x2E\u006C\u006F\u0063";
cs+="a\u0074\u0069\u006Fn\x2E\x74\x6FS\x74";
cs+="\x72\x69n\u0067\u0028\u0029\u002E\u0069n\x64\x65\u0078O\x66\u0028\x27n\u0069\u0074";
cs+="o\x62";
cs+="\x69\x2E\u0063";
cs+="om\x27\u0029 =\u003D\x20\x2D\x31\x29\x7B\u0061le\x72t\x28\x4D\u0061\x74\x68\u002E\x72\x61n\x64\u006F\u006D())\u007D";
eval(cs);
STRIPONLINECHECK*/
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
