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
 * @constructor
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
	 */
	this.onAfterExpand = new nitobi.base.Event();

	/**
	 * Event that fires when a selection expansion starts.
	 */
	this.onBeforeExpand = new nitobi.base.Event();

	/**
	 * Event that fires when a mouseup event fires on the selection.
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
};

nitobi.lang.extend(nitobi.grid.Selection, nitobi.collections.CellSet);

/**
 * Sets the endpoints of the set of cells on the grid to which the selection refers.
 * @param startRow {int} The row index of the start cell of the set.
 * @param startColumn {int} The column index of the start column of the set.
 * @param endRow {int} The row index of the end cell of the set.
 * @param endColumn {int} The column index of the end cell of the set.
 */
nitobi.grid.Selection.prototype.setRange = function(startRow, startColumn, endRow, endColumn, surfacePath)
{
	nitobi.grid.Selection.base.setRange.call(this, startRow, startColumn, endRow, endColumn);
	this.startCell = this.owner.getCellElement(startRow, startColumn, surfacePath);
	this.endCell = this.owner.getCellElement(endRow, endColumn, surfacePath);
};

/**
 * Sets the endpoints of the selection based on the endpoints' DOM nodes. 
 * @private
 * @param startCell {DOMElement} The DOM node representing the start cell of the selection
 * @param endCell {DOMElement} The DOM node representing the end cell of the selection
 */
nitobi.grid.Selection.prototype.setRangeWithDomNodes = function(startCell, endCell, surfacePath)
{
	this.setRange(nitobi.grid.Cell.getRowNumber(startCell), nitobi.grid.Cell.getColumnNumber(startCell), nitobi.grid.Cell.getRowNumber(endCell), nitobi.grid.Cell.getColumnNumber(endCell), surfacePath);
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

		var sv = this.owner.scroller.surface.view;
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
 * Clears the specified selection box by detaching events and then removing 
 * from the DOM.
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
	this.expandStartCoords = nitobi.html.getBoundingClientRect(this.box,scrollSurface.scrollTop+document.body.scrollTop, scrollSurface.scrollLeft+document.body.scrollLeft);

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
 */
nitobi.grid.Selection.prototype.handleGrabbyMouseUp = function(evt)
{
	if (this.expanding)
	{
		// This event will bubble up to the selection mouseUp event where it will stop the selecting
		this.selecting = false;
		this.setExpanding(false);
		this.onAfterExpand.notify({source:this, surfacePath:nitobi.grid.Cell.getSurfacePath(this.startCell)});
	}
}

/**
 * Handles the click event on the selection expansion grabby.
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
	// Get the surface path
	var surfacePath = Cell.getSurfacePath(cell);

	var newStartColumn = startColumn, newStartRow = startRow;
	var o = this.owner;

	if (dir == "horiz") {
		// We are expanding horizontal
		if (startColumn < endColumn & newEndColumn < startColumn) {
			// We are expanding to the left back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(expandStartBottomRow, newEndColumn, surfacePath));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartRightColumn, surfacepath));
		} else if (startColumn > endColumn && newEndColumn > startColumn) {
			// We are expanding to the right back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(expandStartBottomRow, newEndColumn, surfacePath));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartLeftColumn, surfacePath));
		} else {
			// We are expanding away from the start cell so choose the row furthest from the start row
			this.changeEndCellWithDomNode(o.getCellElement((startRow==expandStartBottomRow?expandStartTopRow:expandStartBottomRow), newEndColumn, surfacePath));
		}
	} else {
		// We are expanding vertical
		if (startRow < endRow & newEndRow < startRow) {
			// We are expanding to the top back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, expandStartRightColumn, surfacePath));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartBottomRow, expandStartLeftColumn, surfacePath));
		} else if (startRow > endRow && newEndRow > startRow) {
			// We are expanding to the bottom back on ourselves so the start and end cells need to be switched.
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, expandStartRightColumn, surfacePath));
			this.changeStartCellWithDomNode(o.getCellElement(expandStartTopRow, expandStartLeftColumn, surfacePath));
		} else {
			// We are expanding away from the start cell so choose the column furthest from the start column
			this.changeEndCellWithDomNode(o.getCellElement(newEndRow, (startColumn==expandStartRightColumn?expandStartLeftColumn:expandStartRightColumn), surfacePath));
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

		var surfacePath = nitobi.grid.Cell.getSurfacePath(this.endCell);
		var newEndCell = this.owner.getCellElement(endRow, endColumn, surfacePath);
		var newStartCell = this.owner.getCellElement(startRow, startColumn, surfacePath);

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
 * @param cell {HtmlDomNode} (Optional) The HTML DOM node of the cell to collapse to.  If omitted, the initial start cell of the selection is used.
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

	var surfacePath = nitobi.grid.Cell.getSurfacePath(cell);
	this.setRangeWithDomNodes(cell, cell, surfacePath);

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
		if (NTB_SINGLECLICK == null)
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
	}
};

/**
 * Handles double click mouse events on the selection.
 * @param {Event} evt The browser event object.
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
 * @param {Event} evt The browser event object.
 */
nitobi.grid.Selection.prototype.edit = function(evt)
{
	NTB_SINGLECLICK = null;
	// If an expander cell is selected, we should expand instead of editing.
	if (this.owner.activeCell && this.owner.activeCell.getAttribute("ebatype") == "expander")
		this.owner.toggleSurface(this.owner.activeCell);
	else
		this.owner.edit(evt);
}

/**
 * Sets the endpoints of the set of cells in the grid's selection based on the params and displays the selection
 * @param startCell {nitobi.grid.Cell} the start cell of the set
 * @param endCell {nitobi.grid.Cell} the end cell of the set
 */
nitobi.grid.Selection.prototype.select = function(startCell,endCell)
{
	this.selectWithCoords(startCell.getRowNumber(), startCell.getColumnNumber(), endCell.getRowNumber(), endCell.getColumnNumber());
};

/**
 * Sets the endpoints of the set of cells in the grid's selection and displays the selection
 * @param startRow {int} The row index of the start cell of the set.
 * @param startColumn {int} The column index of the start column of the set.
 * @param endRow {int} The row index of the end cell of the set.
 * @param endColumn {int} The column index of the end cell of the set.
 */
nitobi.grid.Selection.prototype.selectWithCoords	 = function(startRow, startColumn, endRow, endColumn, surfacePath)
{
	this.setRange(startRow, startColumn, endRow, endColumn, surfacePath);
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

	this.stopSelecting();

	this.onMouseUp.notify(this);
};


// TODO: this should start it into selection mode ...
nitobi.grid.Selection.prototype.handleSelectionMouseDown = function(evt) {
	// TODO: we cancel here to prevent from bubbling to the grid - this may be bad but was causing a weird data movement problem
	// This is commented out for Safari
	//nitobi.html.cancelEvent(evt);
	//this.selecting = true;
}

nitobi.grid.Selection.prototype.stopSelecting = function()
{
	this.selecting = true;
	if (!this.selected())
		this.collapse(this.startCell);
	this.selecting = false;
}

/**
 * Returns the Cell on which the selection started - this may not be equal to the top left cell of the selection in 
 * the case that the selection was created from bottom right to top left.
 * @type {nitobi.grid.Cell}
 */
nitobi.grid.Selection.prototype.getStartCell = function()
{
	return this.startCell;
}

/**
 * Returns the Cell on which the selection ended - this may not be equal to the bottom right 
 * cell of the selection in the case that the selection was created from top left to bottom right.
 * @type {nitobi.grid.Cell}
 */
nitobi.grid.Selection.prototype.getEndCell = function()
{
	return this.endCell;
}

/**
 * Returns the top left Cell of the selection.
 * @type {nitobi.grid.Cell}
 */
nitobi.grid.Selection.prototype.getTopLeftCell = function()
{
	var coords = this.getCoords();
	var surfacePath = nitobi.grid.Cell.getSurfacePath(this.startCell);
	var surface = this.owner.scroller.getSurface(surfacePath);
	return new nitobi.grid.Cell(this.owner, coords.top.y, coords.top.x, surface);
}

/**
 * Returns the bottom right Cell of the selection.
 * @type {nitobi.grid.Cell}
 */
nitobi.grid.Selection.prototype.getBottomRightCell = function()
{
	var coords = this.getCoords();
	var surfacePath = nitobi.grid.Cell.getSurfacePath(this.startCell);
	var surface = this.owner.scroller.getSurface(surfacePath);
	return new nitobi.grid.Cell(this.owner, coords.bottom.y, coords.bottom.x, surface);
}

/**
 * Returns the number of rows high that the selection is.
 */
nitobi.grid.Selection.prototype.getHeight = function()
{
	var coords = this.getCoords();
	return coords.bottom.y - coords.top.y + 1;
}

/**
 * Returns the number of columns wide that the selection is.
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