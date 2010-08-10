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
 */
nitobi.grid.OnBeforeRowInsertEventArgs = function(source, row)
{
	nitobi.grid.OnBeforeRowInsertEventArgs.baseConstructor.call(this, source, row);
}

nitobi.lang.extend(nitobi.grid.OnBeforeRowInsertEventArgs, nitobi.grid.RowEventArgs);