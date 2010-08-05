OVERVIEW
--------

jPint is a set of libraries designed by Journyx to allow developers to build web-based
applications that look and feel as much like native iPhone apps as possible, while
retaining the ability for those apps to be used by people who, for whatever reason,
don't actually have an iPhone handy. The real point of this is to allow developers
to have as large an audience (customer base) as possible.

ROADMAP
-------

The 0.7 version of the jPint libraries is the first public release.  The version 1.0
libraries will be released later in 2008, concurrent with the release of mobile
time tracking functionality by Journyx.  We have left room for two interim 
releases (0.8 and 0.9), one of which will include Internet Explorer support. 
The other should be considered a "wildcard" release which may or may not occur,
depending on whether there are significant contributions or unexpected developments.

None of this should be taken as committal.  We like you, but we're not sure we're ready.

FEATURE REQUESTS
----------------

- Compressed versions of the JS and css files for transmission speed.
- JS workaround for position:fixed on iPhone
- CSS wrappers for different views based on iPhone orientation
- More animation types (slide up over IconMenu, for instance)
- The toggleDeleteMode() and toggleSortMode() stuff is bit clumsy, perhaps.
- More iPhone page types:
	- doc at bottom of IconMenu ala the iPhone main screen.
	- graphics at left of EdgedList li ala "Photos - Albums" and "iPod - Albums"
	- grid of pictures like the view of a specific album under Photos.
	- picture display like when you are viewing a photo in Photos
	- on/off widget like the one on the Alarms page (and the taller gray edgedlist styling?).
	- alphabetical browser along the right edge like in Contact, Artists, etc...
	- content above RoundedList, like the Contact Details page with the photo up top
	- list items with two links, like the Favorites page with a main link and one at the right

KNOWN ISSUES
------------

jPint is a work in progress, and though we've managed to solve a number of key issues
in developing an iPhone-flavored web app, there are a few things hanging.  If you manage
to work out a solution to one or more of these problems before we do, drop jpint@journyx.com
a line. We'd love to hear from you.

- Never tested in IE.  Will shatter over the floor and make your feet bleed.
- Scrollbars don't act quite right in a Google Gadget.
- The page jumps around (due to scrollTo) as a Google Gadget.
- Buttons in the Notes demo app should be brown.  Some of them, anyway.
- The use of addListener in jPint.js could be replaced with prototype observation.

COPYRIGHT
---------

Copyright (c) 2008 Journyx, Inc.

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
