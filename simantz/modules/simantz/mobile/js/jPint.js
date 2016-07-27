/* Copyright (c) 2008 Journyx, Inc.

   Permission is hereby granted, free of charge, to any person obtaining
   a copy of this software and associated documentation files (the
   "Software"), to deal in the Software without restriction, including
   without limitation the rights to use, copy, modify, merge, publish,
   distribute, sublicense, and/or sell copies of the Software, and to
   permit persons to whom the Software is furnished to do so, subject to
   the following conditions:
  
   The above copyright notice and this permission notice shall be
   included in all copies or substantial portions of the Software.
  
   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
   EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
   MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
   NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
   LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
   OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
   WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
  
   The software may not be used to develop, enable or integrate with 
   time, expense, or mileage tracking software of any kind,  except when
   such software is provided by Journyx or its designated licensees.
*/

/* PUBLIC Element METHODS */

// This will track everyone who has registered to be notified of DOM changes.
Element.DOM_CHANGE_LISTENERS = $A([]);

Element.addMethods(
{

	// Call this with a callback method.  Any time we do something that would change
	// the DOM, we will call it with the element that was deleted, moved, or added.
	addDOMChangeListener: function( onChange, contextObject )
	{	Element.DOM_CHANGE_LISTENERS[ Element.DOM_CHANGE_LISTENERS.length] = onChange;
	},
	callDOMChangeListeners: function( theElement )
	{	Element.DOM_CHANGE_LISTENERS.each( function( onChange ) { onChange( theElement ); } );
	},

	// These are like the core methods, but call the DOMChangeListeners.
	DOMremove: function( theElement )
	{	if ( theElement.parentNode ) theElement.remove();
		theElement.callDOMChangeListeners();
		return theElement;
	},
	DOMappendChild: function( parentElement, childElement )
	{	parentElement.appendChild( childElement );
		parentElement.callDOMChangeListeners();
		return childElement;
	},
	DOMinsertBefore: function( parentElement, childElement, beforeElement )
	{	parentElement.insertBefore( childElement, beforeElement );
		parentElement.callDOMChangeListeners();
		return childElement;
	},

	// If the element has a previous sibling, put it before that sibling.
	// If it does not, put it at the end of the parent.
    movePrevious: function( theElement )
    {
        var parentNode = theElement.up();
        var previousDiv = theElement.previous();

        parentNode.removeChild( theElement );
        if ( previousDiv ) { parentNode.DOMinsertBefore( theElement, previousDiv ); }
        else { parentNode.DOMappendChild( theElement ); }
		return theElement;
    },
   
    moveNext: function( theElement )
    {
        var parentNode = theElement.up();
        var nextDiv = theElement.next();

		// Don't call the DOMremove version, because we have more alterations to perform.
        parentNode.removeChild( theElement );
        if ( nextDiv )
        {   
			var nextNextDiv = nextDiv.next();
            if ( nextNextDiv ) { parentNode.DOMinsertBefore( theElement, nextNextDiv ); }
            else { parentNode.DOMappendChild( theElement ); }
        }
        else
        {   parentNode.DOMinsertBefore( theElement, parentNode.getElementsByClassName( 'Character' ).first() );
        }
		return theElement;
    },

	// Ensure that an element is the only one of its siblings with a given class name.
	ownClassName: function( theElement, className )
	{	theElement.siblings().without( theElement ).invoke( 'removeClassName', className );
		return theElement.addClassName( className );
	},

	// Add/remove a class from the element.
	toggleClassName: function( theElement, className )
	{	if ( theElement.hasClassName( className ) ) return theElement.removeClassName( className );
		return theElement.addClassName( className );
	},

	getPhonePage: function( theNode ) 
	{	if ( theNode.hasClassName( 'jPintPage' ) ) return theNode;
		return theNode.up( '.jPintPage' ); 
	},

	disableAllLinks: function( theNode )
	{	theNode.getElementsBySelector( 'a' ).each( function( a )
		{	if (! a.disabled )
			{	a.disabled = true; 
				if ( a.onclick ) a.oldclick = a.onclick; 
				a.onclick = function() { return false; }; 
			}
		} );
	},
	enableAllLinks: function( theNode )
	{	theNode.getElementsBySelector( 'a' ).each( function( a )
		{	if ( a.disabled )
			{	a.disabled = false; 
				a.onclick = a.oldclick; 
			}
		} );
	}

} );

/*	This object knows about the pages in the document and how to move between them,
	including observing the page address for # links.
*/
var jPintNav = 
{
	// Config variables.  Edit at will.
	animateX: -20,
	animateInterval: 24,

	// State variables.  Leave them alone.
	currentHash: null,
	hashPrefix: "#",
	currentPage: 0,
	pageHistory: [],

	// Display the first jPintPage in the document, and set up URL hash observation
	// if other pages are included.
	initNav: function()
	{
		// Cause page 1 to appear and set up URL monitoring if there multiple pages
		var jPintPages = jPintNav.getPages();
		jPintNav.checkPage();
		if ( jPintPages.length > 1 ) setInterval( jPintNav.checkPage, 300);

		jPintNav.hideURLBar();

		// Convert all CancelButton links into history nav items
		$$( '.BackButton' ).each( function( cancelButton ) { cancelButton.href = 'javascript:jPintNav.back();'; } );
	},

	back: function()
	{	
		//alert( location.pathname + '#' + jPintNav.pageHistory.last() );
		document.location = location.pathname + '#' + jPintNav.pageHistory[jPintNav.pageHistory.length - 2];
	},

	checkPage: function()
	{
		if ( location.hash == '' || location.hash == '#' )
		{	document.location = location + '#' + jPintNav.getPages()[0].id;
		}
	    if (location.hash != jPintNav.currentHash)
	    {
	        jPintNav.currentHash = location.hash;
	
			// Is there a page by that id?  If not, use page 1 and its id.
	        var pageId = jPintNav.currentHash.substr(jPintNav.hashPrefix.length) || jPintNav.getPages()[0].id;
	        var page = $(pageId) || jPintNav.getPages()[0];
			var pageId = page.id;

			jPintNav.showPage( page );
	    }
	},
	// Get a list of all the divs with class jPintPage.  These act as pages.
	getPages: function() { return document.getElementsByClassName( 'jPintPage' ); },

	// Display a certain jPintPage, animating our way to it if necessary.
	showPage: function( pageDiv )
	{	
		// Figure out the from->to pages, and store off the new page.
		var toPage = $( pageDiv );

		var fromPage = jPintNav.currentPage;
		jPintNav.currentPage = toPage;

		// Make the "to" page the only visible one, and animate to it if there's a "from" page.
		if ( fromPage ) 
		{
			jPintNav.fromPage = fromPage;
			jPintNav.toPage = toPage;
			setTimeout( jPintNav.swipePage, 0 );
		}
		else
		{
			toPage.ownClassName( 'jPintPageActive' );
			toPage.style.left = '0%';
		}
	},

	swipePage: function()
	{        
		var fromPage = jPintNav.fromPage;
		var toPage = jPintNav.toPage;

		// Figure out backwards by seeing if the div we're headed to has a
		// link into this one.
		var backwards = 
			toPage.getElementsBySelector( 'a' ).findAll( function( a ) 
			{	//alert( a.href.split( '#' ).last() );
				return ( a.href.split( '#' ).last() == fromPage.id );
			} ).length;

		// We can update our page history now that we know which way we're going.
		if ( backwards ) 
		{
			var index = jPintNav.pageHistory.indexOf( toPage.id );
			jPintNav.pageHistory.splice(index, jPintNav.pageHistory.length);
		}
		jPintNav.pageHistory.push( toPage.id );

		toPage.style.position = fromPage.style.position = 'absolute';

    	toPage.style.left = ( backwards ? "-100%" : "100%");
		fromPage.up().up().scrollTop = 1;

		fromPage.style.display = 'block';
		toPage.style.display = 'block';
    	
    	var percent = 100;
    	var timer = setInterval(function()
    	{
        	percent += jPintNav.animateX;
        	if (percent <= 0)
        	{
            	percent = 0;
            	clearInterval(timer);
				jPintNav.hideURLBar();
				fromPage.style.display = 'none';
				toPage.style.position = fromPage.style.position = 'relative';
        	}
	
        	fromPage.style.left = (backwards ? (100-percent) : (percent-100)) + "%"; 
        	toPage.style.left = (backwards ? -percent : percent) + "%"; 
    	}, jPintNav.animateInterval );
	},

	// Hide the URL bar if we're on iPhone.
	hideURLBar: function() 
	{
		if (navigator.userAgent.indexOf('iPhone') != -1) 
		{	setTimeout( function() { window.scrollTo( 0, 1 ); }, 0); 
		}
	}

};

/* Knows how to fix display discrepancies and fancy things up */
var jPintLayout =
{
	SLIDING_DOOR_BUTTON_CLASSES: [ 'LeftButton', 'RightButton', 'BackButton' ],
	SLIDING_DOOR_ADDON_CLASSES: [ 'ActiveButton' ],

	initLayout: function()
	{
		// Fix the list borders and keep 'em fixed.
		jPintLayout.fixListBorders(); 
		Element.addDOMChangeListener( jPintLayout.fixListBorders );

		// Round off the icons in our IconMenu pages.
		jPintLayout.roundIconMenus();

		// Make our calendars work.
		jPintLayout.activateCalendars();

		// Make all our button hrefs use sliding doors.
		jPintLayout.makeSlidingDoors();
	},

	makeSlidingDoors: function()
	{
		jPintLayout.SLIDING_DOOR_BUTTON_CLASSES.each( function( buttonClass ) 
		{
			var theseButtons = $$( '.' + buttonClass );
			theseButtons.each( function( thisButton ) { jPintLayout.makeSlidingDoor( buttonClass, thisButton ); } );
		} );
	},

	makeSlidingDoor: function( buttonClass, thisButton )
	{
		// Remove the button from its parent but hold onto it.
		var buttonHolder = thisButton.parentNode;
		buttonHolder.removeChild( thisButton );

		// Build elements of a wrapper hierarchy.
		var slidingBackSpan = $( document.createElement( 'span' ) ).addClassName( 'SlidingBackWrapper' );
		var slidingBackDiv = $( document.createElement( 'div' ) );

		// Attach our button class, and possibly the addon classes, to each of the divs in the hierarchy.
		[ slidingBackSpan, slidingBackDiv ].invoke( 'addClassName', buttonClass );
		jPintLayout.SLIDING_DOOR_ADDON_CLASSES.each( function( addonClass )
		{	if ( thisButton.hasClassName( addonClass ) )
				[ slidingBackSpan, slidingBackDiv ].invoke( 'addClassName', addonClass );
		} );

		slidingBackSpan.appendChild( thisButton );
		slidingBackDiv.appendChild( slidingBackSpan );
		buttonHolder.appendChild( slidingBackDiv );
	},

	activateCalendars: function()
	{
		$$( '.iPhoneCal' ).each( function( thisCalDiv )
		{
			theCalendar = new scal( thisCalDiv.id, 'showDate', { dayheadlength: 3 } );
			theCalendar.showCalendar();
		} );
	},

	// Call this if you move list elements around because Safari has a first-child bug.
	FIRST_ITEM_STYLE: { 'border-top': '0' },
	OTHER_ITEMS_STYLE: { 'border-top': '1px solid rgb( 217, 217, 217 )' },
	fixListBorders: function()
	{	[ 'RoundedList', 'EdgedList' ].each( function( listType )
		{	$$( 'ul.' + listType ).each( function( listElement )
			{	var listItems = listElement.childElements();
				var firstItem = listItems.first();
				if ( firstItem )
				{	firstItem.setStyle( jPintLayout.FIRST_ITEM_STYLE );
					listItems.without( firstItem ).invoke( 'setStyle', jPintLayout.OTHER_ITEMS_STYLE );
				}
			} );
		} );
	},

	roundIconMenus: function()
	{
		$$( '.IconMenu ul li a img' ).each( function( thisImage )
		{	
			var imageRounder = $( document.createElement( 'div' ) ).addClassName( 'ImageRounder' );
			var imageLabel = $(document.createElement( 'div' ) ).addClassName( 'IconItemText' );
			imageLabel.appendChild( document.createTextNode( thisImage.title ) );

			thisImage.parentNode.appendChild( imageRounder );
			thisImage.parentNode.appendChild( imageLabel );
		} );
	}

};

/* Knows how to magically make list items sortable, deletable, etc... */
var jPintEdit = 
{	

	// Call this to switch between displaying the things in .EditModeVisible and .EditModeInvisible divs.
	// Call this to make anything in a .EditModeOnly div visible or invisible.
	// If you intend to use this, be sure to add EditModeOn as an initial class on your body!
	updateEditMode: function( theNode )
	{	
		var jPintPage = theNode.getPhonePage();
		if ( jPintPage.getElementsByClassName( 'Deleting' ).length || jPintPage.getElementsByClassName( 'Sorting' ).length )
		{	jPintPage.addClassName( 'EditModeOn' );
		}
		else
		{	jPintPage.removeClassName( 'EditModeOn' );
		}
	},

	// Call this with an element on your page and a handler that takes a list item and an event as args.
	toggleSortMode: function( theNode, sortHandler )
	{	theNode.getPhonePage().toggleClassName( 'Sorting' ).getElementsBySelector( 'ul.SortableItems' ).each( 
		function( sortableList )
		{	//window.console.log( sortableList );
			sortableList.toggleClassName( 'Sorting' ).getElementsBySelector( 'li' ).each( function( li )
			{	li.sortHandler = sortHandler;

				isSorting = sortableList.hasClassName( 'Sorting' );
				if ( isSorting ) { li.disableAllLinks(); } else { li.enableAllLinks(); }

				// Next we insert an invisible href over our nifty delete background image,
				// and another one at the right that will only appear while confirming.
				if ( isSorting )
				{	
					li.doubleButton = 
						$( document.createElement( 'span' ) ).addClassName( 'DoubleButton' ).addClassName( 'SortDouble' );
					li.doubleButton.innerHTML = '<span class="ALike"></span>';
					var doubleButtonSpan = li.doubleButton.childElements().first();
					li.insertBefore( li.doubleButton, li.childElements().first() );
					jPintLayout.makeSlidingDoor( 'DoubleButton', doubleButtonSpan );
					[ [ '&dArr;', 'moveNext' ], [ '&uArr;', 'movePrevious' ] ].each( function( arrowAndMethod )
					{
						var theButton = $( document.createElement( 'span' ) ).addClassName( 'NoFont' ).addClassName( 'WidePadding' ).update( arrowAndMethod[0] );
						doubleButtonSpan.appendChild( theButton );
						theButton.observe( 'click', function( e )
						{	var listItem = Event.findElement( e, 'li' );
							listItem[ arrowAndMethod[1] ]();
							//window.console.log( listItem.sortHandler );
							if( listItem.sortHandler ) listItem.sortHandler( listItem );
							return false;
						} );
					} );
				}
				else
				{	if ( li.doubleButton && li.doubleButton.parentNode )  li.doubleButton.remove();
				}
			} );
		} );
		jPintEdit.updateEditMode( theNode );
		return jPintEdit
	},

	// Call this with an element on your page and a handler that takes a list item and an event as args.
	toggleDeleteMode: function( theNode, deleteHandler )
	{	// First we assign the "Deleting" class to all "DeletableItems" ul nodes.
		theNode.getPhonePage().toggleClassName( 'Deleting' ).getElementsBySelector( 'ul.DeletableItems' ).each( function( deletableList )
		{	//window.console.log( deletableList );
			deletableList.toggleClassName( 'Deleting' ).getElementsBySelector( 'li' ).each( function( li )
			{	li.deleteHandler = deleteHandler;

				isDeleting = deletableList.hasClassName( 'Deleting' );
				if ( isDeleting ) { li.disableAllLinks(); } else { li.enableAllLinks(); }

				// Next we insert an invisible href over our nifty delete background image,
				// and another one at the right that will only appear while confirming.
				if ( isDeleting )
				{	
					li.deleteLink = $( document.createElement( 'span' ) ).addClassName( 'DeleteButton' );
					li.insertBefore( li.deleteLink, li.childElements().first() );
					li.deleteFunction =
						function( theEvent )
						{	var listItem = Event.findElement( theEvent, 'li' );
							listItem.getPhonePage().getElementsBySelector( 'li' ).without( listItem ).invoke( 
								'removeClassName', 'DeleteConfirm' );
							listItem.toggleClassName( 'DeleteConfirm' );
							return false;
						};
					li.deleteLink.observe( 'click', li.deleteFunction );

					li.confirmLink = $( document.createElement( 'span' ) ).addClassName( 'DeleteConfirm' );
					li.confirmLink.innerHTML = '<a>Delete</a>';
					li.insertBefore( li.confirmLink, li.childElements().first() );
					var confirmLinkLink = li.confirmLink.childElements().first();
					jPintLayout.makeSlidingDoor( 'DeleteConfirm', confirmLinkLink );
					li.confirmFunction =
						function( theEvent )
						{	var listItem = Event.findElement( theEvent, 'li' );
							listItem.deleteLink.stopObserving( 'click', jPintEdit.toggleDeleteConfirm );
							listItem.confirmLink.stopObserving( 'click', jPintEdit.confirmDelete );
							listItem.deleteHandler( listItem, theEvent );
							return false;
						};
					confirmLinkLink.observe( 'click', li.confirmFunction );
				}
				else
				{	li.removeClassName( 'DeleteConfirm' );
					if ( li.deleteLink ) 
					{	li.deleteLink.stopObserving( 'click', li.deleteFunction )
						if ( li.deleteLink.parentNode ) li.deleteLink.remove();
					}
					if ( li.confirmLink ) 
					{	li.confirmLink.childElements().first().stopObserving( 'click', li.confirmFunction );
						if ( li.confirmLink.parentNode ) li.confirmLink.remove();
					}
				}
			} );
		} );
		jPintEdit.updateEditMode( theNode );
		return jPintEdit;
	}
};


/* INITIALIZATION */

// Cross-browser implementation of element.addEventListener()
addListener = function(element, type, expression )
{
	if(window.addEventListener)
	{	return element.addEventListener(type, expression, false );
	} else if(window.attachEvent)
	{	return element.attachEvent('on' + type, expression);
	} else return false;
}

addListener( window, 'load', function() 
{	jPintLayout.initLayout();
	jPintNav.initNav();
}, false);
