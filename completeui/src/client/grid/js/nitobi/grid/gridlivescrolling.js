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

