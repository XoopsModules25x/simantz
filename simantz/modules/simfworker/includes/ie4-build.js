function menu(size, orientation, x, y, offsetX, offsetY, bgOut, bgOver, fontFace, fontSize, 
	fontStyleOut, fontStyleOver, textColorOut, textColorOver, borderSize, borderColor, margin, showChar, 
	showOnClick, sepItems, isMainMenu, hasAnimations, animationType, hasShadow, sOffX, sOffY, shadowColor)
{
	for (var i=0; i<arguments.length; i++)
		if (typeof(arguments[i]) == "string")
			arguments[i] = arguments[i].toLowerCase();

	this.size = size;
	this.orientation = orientation;
	this.offsetX = offsetX;
	this.offsetY = offsetY;
	this.bgOut = bgOut;
	this.bgOver = bgOver;
	this.fontFace = fontFace;
	this.fontSize = fontSize;
	this.fontStyleOut = fontStyleOut;
	this.fontStyleOver = fontStyleOver;
	this.textColorOut = textColorOut;
	this.textColorOver = textColorOver;
	this.borderSize = borderSize;
	this.margin = margin;
	this.showChar = showChar;
	this.showOnClick = showOnClick;
	this.sepItems = sepItems;
	this.isMainMenu = isMainMenu;
	this.hasShadow = hasShadow;
	this.sOffX = sOffX;
	this.sOffY = sOffY;
	this.shadowColor = shadowColor;
	this.position = borderSize;
	this.addSeparator = separator;
	this.addItem = item;
	this.debug = debug;
	this.floatMenu = floatMenu;
	this.items = new Array();
	this.activeItems = new Array();

	document.body.insertAdjacentHTML("BeforeEnd", '<div id="menus' + menus.length + '" style=""></div>');
	this.main = document.all["menus" + menus.length];
	this.main.style.backgroundColor = borderColor;
	this.main.style.position = "absolute";
	this.main.style.left = x;
	this.main.style.top = y;
	this.main.style.zIndex = 1001 + menus.length;

	if (orientation == "horizontal")
	{
		this.main.style.height = size;
		if (sepItems)
			this.main.style.width = borderSize;
		else
			this.main.style.width = borderSize*2;
	}
	else
	{
		if (sepItems)
			this.main.style.height = borderSize;
		else
			this.main.style.height = borderSize*2;
		this.main.style.width = size;
	}
	if (isMainMenu)
		this.main.style.visibility = "visible";
	else
		this.main.style.visibility = "hidden";

	this.main.onmouseover = new Function("keepOpen();");
	this.main.onmouseout = new Function("hide();");

	if (this.hasShadow)
	{
		document.body.insertAdjacentHTML("BeforeEnd", '<div id="menus' + menus.length + 'shadow" style=""></div>');
		this.shadow = document.all["menus" + menus.length + "shadow"];
		this.shadow.style.backgroundColor = shadowColor;
		this.shadow.style.position = "absolute";
		this.shadow.style.left = x + sOffX;
		this.shadow.style.top = y + sOffY;
		this.shadow.style.zIndex = 1000 + menus.length;
		this.shadow.style.height = this.main.style.height;
		this.shadow.style.width = this.main.style.width;
		if (isMainMenu)
			this.shadow.style.visibility = "visible";
		else
			this.shadow.style.visibility = "hidden";
		this.siframe = createIFrame(this, true);
	}

	this.iframe = createIFrame(this, false);
}

function separator(sSize, sColor)
{
	if (!this.sepItems)
	{
		this.main.insertAdjacentHTML("BeforeEnd", '<div id="menuSeparator" style=""></div>');
		var temp = document.all["menuSeparator"];
		temp.id = "";
	
		temp.style.backgroundColor = sColor;
		temp.style.padding = 0;
		temp.style.position = "absolute";
	
		if (this.orientation == "horizontal")
		{
			temp.style.height = this.size - this.borderSize*2;
			temp.style.width = sSize;
			temp.style.left = this.position;
			temp.style.top = this.borderSize;
		}
		else
		{
			temp.style.height = sSize;
			temp.style.width = this.size - this.borderSize*2;
			temp.style.left = this.borderSize;
			temp.style.top = this.position;
		}
	
		var imgTag = '<img src="' + blank.src + '" height="' + sSize + '" width="' + parseInt(temp.style.width) + '">';
		temp.insertAdjacentHTML("BeforeEnd", imgTag);
		temp.style.visibility = "inherit";
	
		if (this.orientation == "horizontal")
			this.main.style.width = this.main.offsetWidth + sSize;
		else
			this.main.style.height = this.main.offsetHeight + sSize;
		this.position += sSize;

		this.iframe.style.height = this.main.style.height;
		this.iframe.style.width = this.main.style.width;
		
		if (this.hasShadow)
		{
			this.shadow.style.height = this.main.style.height;
			this.shadow.style.width = this.main.style.width;
			this.siframe.style.height = this.main.style.height;
			this.siframe.style.width = this.main.style.width;
		}
	}
}
 
function item(link, target, iSize, alignment, content, menuToShow)
{
	alignment = alignment.toLowerCase();
	this.main.insertAdjacentHTML("BeforeEnd", '<div id="menus' + (menus.length-1) + 'item' + 
		this.items.length + '" style=""></div>');
	var temp = document.all["menus" + (menus.length-1) + "item" + this.items.length];

	if (this.orientation == "horizontal")
	{
		temp.style.height = this.size - this.borderSize*2;
		temp.style.width = iSize;
	}
	else
	{
		temp.style.height = iSize;
		temp.style.width = this.size - this.borderSize*2;
	}
	
	if (this.bgOut.indexOf("img:") != -1)
		temp.style.background = "url(" + this.bgOut.substr(4) + ")";
	else
		temp.style.backgroundColor = this.bgOut;
	temp.style.padding = this.margin;
	temp.style.position = "absolute";
	if (this.orientation == "horizontal")
	{
		temp.style.left = this.position;
		temp.style.top = this.borderSize;
	}
	else
	{
		temp.style.left = this.borderSize;
		temp.style.top = this.position;
	}

	var fontTag = '<font id="menu' + (menus.length-1) + 'font' + this.items.length + '" face="' + 
		this.fontFace + '" color="' + this.textColorOut + '" style="font-size:'	+ this.fontSize + 'pt;';
	if (this.fontStyleOut.indexOf("bold") != -1)
		fontTag += " font-weight:bold;";
	if (this.fontStyleOut.indexOf("italic") != -1)
		fontTag += " font-style:italic;";
	if (this.fontStyleOut.indexOf("underline") != -1)
		fontTag += " text-decoration:underline;";
	fontTag += '">';

	var showMenuFunction;
	if (menuToShow != 0)
		showMenuFunction = "showMenu(" + menuToShow + ", " + (menus.length-1) + ", " + (this.items.length) 
			+ ", " + this.offsetX + ", " + this.offsetY + ");";
	else
		showMenuFunction = "hideAfter(" + (menus.length-1) + ");";

	var tempSize = this.size - this.borderSize*2;
	if (this.orientation == "horizontal")
		tempSize = iSize;
	else
		tempSize = this.size - this.borderSize*2;

	var isFullSize = false;
	if (this.showChar == 0 || this.showChar == "")
		isFullSize = true;

	if (!isNaN(this.showChar))
		this.showChar = String.fromCharCode(this.showChar);

	var showCharOut = "";
	var showCharOverParam = "none", showCharOutParam = "none";

	if (menuToShow > 0)
	{
		if (this.showChar.indexOf("rollover:") != -1)
		{
			var showCharArray = this.showChar.split(":");
			showCharOut = '<img id="menus' + (menus.length-1) + 'char' + this.items.length + '" src="' + 
				showCharArray[1] + '" border="0">';
			showCharOverParam = showCharArray[2];
			showCharOutParam = showCharArray[1];
		}
		else
		{
			showCharOut = '<font id="menu' + (menus.length-1) + 'char' + this.items.length + '" face="' + 
				this.fontFace + '" color="' + this.textColorOut + '" style="font-size:'	+ this.fontSize + 'pt;';
			if (this.fontStyleOut.indexOf("bold") != -1)
				showCharOut += " font-weight:bold;";
			if (this.fontStyleOut.indexOf("italic") != -1)
				showCharOut += " font-style:italic;";
			if (this.fontStyleOut.indexOf("underline") != -1)
				showCharOut += " text-decoration:underline;";
			showCharOut += '">' + this.showChar + '</font>';
		}
	}

	var contentFunctionOver = "", contentFunctionOut = "";
	var contentArray;
	var rollover = "", rollout = "";

	if (content.indexOf("rollover:") != -1)
	{
		contentArray = content.split(":");
		content = '<img name="menu' + (menus.length-1) + 'img' + this.items.length + '" src="' + 
			contentArray[1] + '" border="0">';
		this.margin = 0;
		temp.style.padding = 0;
		rollout = contentArray[1];
		rollover = contentArray[2];
	}

	var table = '<table border="0" cellpadding="0" cellspacing="0" width="' + (tempSize-this.margin*2) + 
		'">';
	table += '<tr>';
	if (rollover != "")
		table += '<td align="' + alignment + '">' + content + '</td>';
	else
	{
		if (isFullSize)
			table += '<td align="' + alignment + '" width="100%">' + fontTag + content + '</font></td>';
		else
		{
			table += '<td align="' + alignment + '" width="80%">' + fontTag + content + '</font></td>';
			table += '<td align="right" width="20%">' + showCharOut + '</td>';
		}
	}
	table += '</tr>';
	table += '</table>';
	temp.insertAdjacentHTML("BeforeEnd", table);

	link = link.replace(/[']/g, "\\'");
	link = link.replace(/\"/g, "\\'");

	if (rollover.length == 0)
	{	
		contentFunctionOver = "html([" + (menus.length-1) + ", " + this.items.length + "], '" + 
			this.bgOver + "', '" + this.textColorOver + "', '" + this.fontStyleOver + "', '" + 
			showCharOverParam + "');";
		contentFunctionOut = "html([" + (menus.length-1) + ", " + this.items.length + "], '" + 
			this.bgOut + "', '" + this.textColorOut + "', '" + this.fontStyleOut + "', '" + 
			showCharOutParam + "');";

		if (link != "" && link != "#")
		{
			contentFunctionOver += "status='" + link + "';";
			contentFunctionOut += "status='';";
		}
	}
	else
	{
		contentFunctionOver = "roll([" + (menus.length-1) + ", " + this.items.length + "], '" + 
			rollover + "');";
		contentFunctionOut = "roll([" + (menus.length-1) + ", " + this.items.length + "], '" + 
			rollout + "');";
	}

	if (this.showOnClick && menuToShow > 0)
		temp.onmouseover = new Function("reset(" + (menus.length-1) + ", " + menuToShow + ");" + 
			contentFunctionOver);
	else
		temp.onmouseover = new Function(showMenuFunction + contentFunctionOver);
	
	if (menuToShow > 0)
		this.activeItems[this.activeItems.length] = contentFunctionOut;
	else
		temp.onmouseout = new Function(contentFunctionOut);
		
	if (link != "" && link != "#")
	{
		if (target != "")
			temp.onmouseup = new Function("window.open('" + link + "', '" + target + "');");
		else
			temp.onmouseup = new Function("location.href = '" + link + "';");
	}

	if (this.showOnClick && menuToShow != 0)
		temp.onmouseup = new Function(showMenuFunction + contentFunctionOver);

	temp.style.visibility = "inherit";
	
	if (this.sepItems)
	{
		if (this.orientation == "horizontal")
			this.main.style.width = this.main.offsetWidth + iSize + this.borderSize;
		else
			this.main.style.height = this.main.offsetHeight + iSize + this.borderSize;
		this.position += iSize + this.borderSize;
	}
	else
	{
		if (this.orientation == "horizontal")
			this.main.style.width = this.main.offsetWidth + iSize;
		else
			this.main.style.height = this.main.offsetHeight + iSize;
		this.position += iSize;
	}

	this.iframe.style.height = this.main.style.height;
	this.iframe.style.width = this.main.style.width;

	if (this.hasShadow)
	{
		this.shadow.style.height = this.main.style.height;
		this.shadow.style.width = this.main.style.width;
		this.siframe.style.height = this.main.style.height;
		this.siframe.style.width = this.main.style.width;
	}

	this.items[this.items.length] = temp;
}

function html(itemArray, bgChange, textColor, fontStyle, showCharParam)
{
	var element = menus[itemArray[0]].items[itemArray[1]];
	var font = element.all[0].all[0].all[0].all[0].all[0];
	var char = element.all[0].all[0].all[0].all[2];

	if (bgChange.indexOf("img:") != -1)
		element.style.background = "url(" + bgChange.substr(4) + ")";
	else
		element.style.backgroundColor = bgChange;
	if (element.onmouseup)
		element.style.cursor = "hand";
	else
		element.style.cursor = "default";

	var isBold = false, isItalic = false, isUnderline = false;
	if (fontStyle.indexOf("bold") != -1)
		isBold = true;
	if (fontStyle.indexOf("italic") != -1)
		isItalic = true;
	if (fontStyle.indexOf("underline") != -1)
		isUnderline = true;

	font.color = textColor;
	if (isBold)
		font.style.fontWeight = "bold";
	else
		font.style.fontWeight = "normal";
	if (isItalic)
		font.style.fontStyle = "italic";
	else
		font.style.fontStyle = "normal";
	if (isUnderline)
		font.style.textDecoration = "underline";
	else
		font.style.textDecoration = "none";

	if (char && char.all[0])
	{
		char = char.all[0];
		if (showCharParam != "none")
			char.src = showCharParam;
		else
		{
			char.color = textColor;
			if (isBold)
				char.style.fontWeight = "bold";
			else
				char.style.fontWeight = "normal";
			if (isItalic)
				char.style.fontStyle = "italic";
			else
				char.style.fontStyle = "normal";
			if (isUnderline)
				char.style.textDecoration = "underline";
			else
				char.style.textDecoration = "none";
		}
	}
}

function reset(num, sNum)
{
	var i;
	for (i=0; i<menus[num].activeItems.length; i++)
		eval(menus[num].activeItems[i]);
	for (i=num+1; i<menus.length; i++)
	{
		if (i != sNum)
		{
			if (menus[i].hasShadow)
			{
				menus[i].shadow.style.visibility = "hidden";
				menus[i].siframe.style.visibility = "hidden";
			}
			menus[i].main.style.visibility = "hidden";
			menus[i].iframe.style.visibility = "hidden";
		}
	}
}

function roll(itemArray, source)
{
	var element = menus[itemArray[0]].items[itemArray[1]];
	if (element.onmouseup)
		element.style.cursor = "pointer";
	else
		element.style.cursor = "default";
	var img = element.all[0].all[0].all[0].all[0].all[1];
	img.src = source;
}

function showMenu(num, pNum, iNum, offsetX, offsetY)
{
	if (menus[num].main.style.visibility != "visible")
	{
		hideAfter(pNum);

		var showX = menus[pNum].main.offsetLeft, showY = menus[pNum].main.offsetTop;
		if (menus[pNum].orientation == "horizontal")
		{
			if (menus[pNum].items.length > iNum)
			{
				showY += menus[pNum].main.offsetHeight;
				showX += menus[pNum].items[iNum].offsetLeft;
			}
		}
		else
		{
			if (menus[pNum].items.length > iNum)
			{
				showX += menus[pNum].main.offsetWidth;
				showY += menus[pNum].items[iNum].offsetTop;
			}
		}
	
		if (showX + menus[num].main.offsetWidth > document.body.clientWidth + document.body.scrollLeft)
			showX -= (showX + menus[num].main.offsetWidth) - (document.body.clientWidth + 
				document.body.scrollLeft);
		if (showY + menus[num].main.offsetHeight > document.body.clientHeight + document.body.scrollTop)
			showY -= (showY + menus[num].main.offsetHeight) - (document.body.clientHeight + 
				document.body.scrollTop);

		showX += offsetX;
		showY += offsetY;

		if (menus[num].hasShadow)
		{
			menus[num].shadow.style.left = showX + menus[num].sOffX;
			menus[num].shadow.style.top = showY + menus[num].sOffY;
			menus[num].siframe.style.left = menus[num].shadow.style.left;
			menus[num].siframe.style.top = menus[num].shadow.style.top;
		}
	
		menus[num].main.style.left = showX;
		menus[num].main.style.top = showY;
		menus[num].iframe.style.left = showX;
		menus[num].iframe.style.top = showY;
		menus[num].main.style.visibility = "visible";
		menus[num].iframe.style.visibility = "visible";
		if (menus[num].hasShadow)
		{
			menus[num].shadow.style.visibility = "visible";
			menus[num].siframe.style.visibility = "visible";
		}
	}
}

function hideAfter(num)
{
	var i;
	for (i=num+1; i<menus.length; i++)
	{
		if (!menus[i].isMainMenu)
		{
			if (menus[i].hasShadow)
			{
				menus[i].shadow.style.visibility = "hidden";
				menus[i].siframe.style.visibility = "hidden";
			}
			menus[i].main.style.visibility = "hidden";
			menus[i].iframe.style.visibility = "hidden";
		}
	}
	
	for (i=num; i<menus.length; i++)
		for (j=0; j<menus[i].activeItems.length; j++)
			eval(menus[i].activeItems[j]);
}

var wait = 500;
var hideTimer;

function keepOpen()
{
	if (hideTimer != null)
		clearTimeout(hideTimer);
}

function hide()
{
	hideTimer = setTimeout("hideAll()", wait);
}

function hideAll()
{
	var i;
	for (i=1; i<menus.length; i++)
	{
		if (!menus[i].isMainMenu)
		{
			if (menus[i].hasShadow)
			{
				menus[i].shadow.style.visibility = "hidden";
				menus[i].siframe.style.visibility = "hidden";
			}
			menus[i].main.style.visibility = "hidden";
			menus[i].iframe.style.visibility = "hidden";
		}
	}
	
	for (i=0; i<menus.length; i++)
		for (j=0; j<menus[i].activeItems.length; j++)
			eval(menus[i].activeItems[j]);
}

function debug()
{
	var win = window.open();
	win.document.open();
	win.document.write('<textarea cols=50 rows=25 wrap=virtual>' + this.main.innerHTML + '</textarea>');
	win.document.close();
	win.focus();
}

function createIFrame(menu, forShadow)
{
	// Thanks to Edson for this form element fix.
	// The based article is at (http://support.microsoft.com/default.aspx?scid=kb;en-us;177378).

	var div;
	if (forShadow)
		div = menu.shadow;
	else
		div = menu.main;
	document.body.insertAdjacentHTML("BeforeEnd", '<iframe id="TempFrame" style=""></iframe>');
	var iframe = document.all["TempFrame"];
	iframe.id = "";	

	iframe.style.backgroundColor = div.style.backgroundColor;
	iframe.style.position = div.style.position;
	iframe.style.left = div.offsetLeft;
	iframe.style.top = div.offsetTop;
	iframe.style.zIndex = div.style.zIndex - 100;  
	iframe.style.height = div.offsetHeight;
	iframe.style.width = div.offsetWidth;
		
	iframe.frameBorder = 0;
	iframe.border = 0;
	iframe.src = "";
	iframe.style.scrolling = "no";
	iframe.style.visibility = div.style.visibility;
	return iframe;
}

function floatMenu(scrWidth, scrHeight, mrgLeft, adjustNum)
{
	if (this.isMainMenu)
	{
		var mrg = 10;
		var bodyWidth = document.body.scrollWidth;
		if (adjustNum == 0 || adjustNum == 2)
		{
			var menuLeft = Math.ceil(this.main.offsetLeft + (screen.width - scrWidth)/2);
			this.main.style.left = Math.ceil(menuLeft - (screen.width - bodyWidth)/2 + mrg);
			this.iframe.style.left = this.main.offsetLeft;
		}
		if (adjustNum == 1 || adjustNum == 2)
		{
			this.main.style.top = this.main.offsetTop + (screen.height - scrHeight)/2;
			this.iframe.style.top = this.main.offsetTop;
		}

		if (this.hasShadow)
		{
			this.shadow.style.left = this.main.offsetLeft + this.sOffX;
			this.shadow.style.top = this.main.offsetTop + this.sOffY;
			this.siframe.style.left = this.shadow.offsetLeft;
			this.siframe.style.top = this.shadow.offsetTop;
		}

		window.onresize = new Function("location.reload();");
	}
}

var menus = new Array();