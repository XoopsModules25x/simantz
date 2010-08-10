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
nitobi.grid.Viewport = function(grid, region, surface)
{
  	//	This array is used to hold closures that remove any memory leaks
	this.disposal = [];
	this.surface = surface;
	this.element = null;

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
nitobi.grid.Viewport.prototype.mapToHtml = function(element,surface) {
	// TODO: CHANGED FOR GROUPING GRID
	this.surface=surface;
	this.element=element;
	this.container=nitobi.html.getFirstChild(surface);
	//this.makeLastBlock(0,this.grid.getRowsPerPage() * 5);
}
/**
 * Creates an empty block if this viewport is in the middle region (i.e. if this.region is
 * between 2 and 5 exclusively).
 * @param {Number} low The bottom range of the block
 * @param {Number} high The high range of the block
 * @private
 */
nitobi.grid.Viewport.prototype.makeLastBlock = function(low,high) {
	if (this.lastEmptyBlock == null && this.grid && this.region>2 && this.region<5 && this.container) {
		if (this.container.lastChild) {
//			alert(low+":"+high)
			low = Math.max(low,this.container.lastChild.bottom);
		}
		this.lastEmptyBlock = this.renderEmptyBlock(low,high);
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

	// Setup the initial empty block.
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
nitobi.grid.Viewport.prototype.clear = function(Surface,Placeholder,Center,Viewport, rows)
{
	var uid = this.grid.uid;
	if (this.surface && Surface)
		this.surface.innerHTML = '<div id="gridvpcontainer_'+this.region+'_'+uid+'"></div>';
	if (this.element && Viewport)
		this.element.innerHTML = '<div id="gridvpsurface_'+this.region+'_'+uid+'"><div id="gridvpcontainer_'+this.region+'_'+uid+'"></div></div>';
	if (this.surface && Center)
		//this.surface.innerHTML = '<div id="gridvpcontainer_'+this.region+'_'+uid+'"></div>';
		nitobi.html.getFirstChild(this.surface).innerHTML = '';
	this.surface = nitobi.html.getFirstChild(this.element);
	this.container = nitobi.html.getFirstChild(this.surface);
	if (this.grid && this.region>2 && this.region<5) { //This is a jinky way of detecting when to use empty blocks
		this.lastEmptyBlock = null;
	}
	
	// After we clear, we need to ensure there is an empty block
	// otherwise the Grid won't be able to determine whether to
	// get more data from the server.
	this.makeLastBlock(0, (rows != null?rows - 1:0));
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
	var blk = this.container.childNodes;
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
 * Splits the block in two at the given row number.
 * Returns the two new blocks in an array
 * @param {String|Number} row The row index to split the block at.
 * @type Array
 * @private
 */
nitobi.grid.Viewport.prototype.splitBlock = function(row)
{
	row = parseInt(row);
	var block = this.getBlocks(row, row)[0];

	var top = block.top, bottom = block.bottom;

	// re-render the rows for the new half block.
	// delete the rows from the original block.

	var origTable = nitobi.html.getFirstChild(nitobi.html.getFirstChild(block));
	// We need to get the group (if there is one) because it will have to go into
	// the bottom block
	var group;
	// TODO: Need a reliable way to get a block's group
	var i = block.childNodes.length - 1;
	while (i > 0 && block.childNodes[i].nodeType == 3 && block.childNodes[i].tagName.toLowerCase() != "table")
	{
		i--;
	}
	if (i > 0)
	{
		group = block.childNodes[i];
	}
	var rowOffset = row - top;

	// Remove the bottom rows from the top table
	var topTable = origTable.cloneNode(true);
	for (var i=origTable.rows.length-1; i>rowOffset; i--)
		topTable.deleteRow(i);

	// Update the details on the block node
	this.updateBlock(block, top, row);
	
	// Clone the original table as the bottom table now and remove the top rows from that table
	var bottomTable = origTable.cloneNode(true);
	for (var i=0; i<rowOffset+1; i++)
		bottomTable.deleteRow(0);

	var newBlock = this.renderBlock(parseInt(row) + 1, bottom, block.nextSibling);
	var contents = document.createElement("div");
	contents.appendChild(bottomTable);
	newBlock.appendChild(contents);

	// Replace the current block with this new smaller one.
	origTable.parentNode.replaceChild(topTable, origTable);

	// Insert the new bottom part of the table after the split
	nitobi.html.insertAdjacentElement(block,"afterEnd",newBlock);
	
	// Now move the group to the bottom block if need be.
	if (group)
	{
		newBlock.appendChild(group);
	}
	// Now we have split the block up in two... can we do this any better???
	return {top:block, bottom:newBlock};
}

/**
 * Renders a range of rows inside an empty block.  
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

	throw "Could not insert " + top + "-" + bottom+Empty.outerHTML;
}

/**
 *
 */
nitobi.grid.Viewport.prototype.renderEmptyBlock = function(top, bottom, nextSibling) 
{
	var o = this.renderBlock(top,bottom,nextSibling);

	o.setAttribute('id','eba_grid_emptyblock_'+this.region+'_'+top+'_'+bottom+'_'+this.uid);
	// Why are we making this check?
	/*if(top == 0 && bottom == 99) 
	{
		crash
	}*/
	o.setAttribute('rendered','false');
	o.style.height = ((bottom - top + 1) * this.rowHeight)  + "px";
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

/**
 * Updates the properties on an existing block like the id and top, bottom, etc expandos
 */
nitobi.grid.Viewport.prototype.updateBlock = function(block, top, bottom) 
{
	block.setAttribute('id','eba_grid_block_'+this.region+'_'+top+'_'+bottom+'_'+this.uid);
	block.top=top;
	block.bottom=bottom;
	block.rows=bottom-top+1;
	// These ones should only be set once i think ... 
	block.left = this.startColumn;
	block.right = this.startColumn + this.columns;
	block.columns = this.columns;
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
