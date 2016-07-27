var docType = (document.compatMode && document.compatMode == "CSS1Compat");
var bodyRef;

function menu(size, orientation, x, y, offsetX, offsetY, bgOut, bgOver, 
fontFace, fontSize, 
	fontStyleOut, fontStyleOver, textColorOut, textColorOver, borderSize, 
borderColor, margin, showChar, 
	showOnClick, sepItems, isMainMenu, hasAnimations, animationType, 
hasShadow, sOffX, sOffY, shadowColor)
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
	bodyRef = docType ? document.documentElement : document.body;

	this.main = document.createElement("div");
	bodyRef.appendChild(this.main);
	this.main.style.backgroundColor = borderColor;
	this.main.style.position = "absolute";
	this.main.style.left = x + "px";
	this.main.style.top = y + "px";
	this.main.style.zIndex = 1001 + menus.length;
	if (orientation == "horizontal")
	{
		this.main.style.height = size + "px";
		if (sepItems)
			this.main.style.width = borderSize + "px";
		else
			this.main.style.width = (borderSize*2) + "px";
	}
	else
	{
		if (sepItems)
			this.main.style.height = borderSize + "px";
		else
			this.main.style.height = (borderSize*2) + "px";
		this.main.style.width = size + "px";
	}
	if (isMainMenu)
		this.main.style.visibility = "visible";
	else
		this.main.style.visibility = "hidden";

	this.main.onmouseover = new Function("keepOpen();");
	this.main.onmouseout = new Function("hide();");
	
	if (this.hasShadow)
	{
		this.shadow = document.createElement("div");
		this.shadow.style.backgroundColor = shadowColor;
		this.shadow.style.position = "absolute";
		this.shadow.style.left = (x + sOffX) + "px";
		this.shadow.style.top = (y + sOffY) + "px";
		this.shadow.style.zIndex = 1000 + menus.length;
		this.shadow.style.height = this.main.style.height;
		this.shadow.style.width = this.main.style.width;
		if (isMainMenu)
			this.shadow.style.visibility = "visible";
		else
			this.shadow.style.visibility = "hidden";
		bodyRef.appendChild(this.shadow);
	}
}

function separator(sSize, sColor)
{
	if (!this.sepItems)
	{
		var temp = document.createElement("div");
		temp.style.backgroundColor = sColor;
		temp.style.paddingLeft = "0px";
		temp.style.paddingTop = "0px";
		temp.style.paddingRight = "0px";
		temp.style.paddingBottom = "0px";

		temp.style.position = "absolute";
		if (this.orientation == "horizontal")
		{
			temp.style.height = (this.size - this.borderSize*2) + "px";
			temp.style.width = sSize + "px";
			temp.style.left = this.position + "px";
			temp.style.top = this.borderSize + "px";
		}
		else
		{
			temp.style.height = sSize + "px";
			temp.style.width = (this.size - this.borderSize*2) + "px";
			temp.style.left = this.borderSize + "px";
			temp.style.top = this.position + "px";
		}

		var filler = document.createElement("img");
		filler.src = blank.src;
		filler.height = parseInt(temp.style.height);
		filler.width = parseInt(temp.style.width);
		temp.appendChild(filler);
		this.main.appendChild(temp);
		temp.style.visibility = "inherit";

		if (this.orientation == "horizontal")
			this.main.style.width = (parseInt(this.main.style.width) + sSize) + "px";
		else
			this.main.style.height = (parseInt(this.main.style.height) + sSize) + "px";
		this.position += sSize;

		if (this.hasShadow)
		{
			this.shadow.style.height = this.main.style.height;
			this.shadow.style.width = this.main.style.width;
		}
	}
}
 
function item(link, target, iSize, alignment, content, menuToShow)
{
	alignment = alignment.toLowerCase();
	var temp = document.createElement("div");
	this.main.appendChild(temp);
	if (this.orientation == "horizontal")
	{
		temp.style.height = (this.size - this.borderSize*2) + "px";
		temp.style.width = iSize + "px";
	}
	else
	{
		temp.style.height = iSize + "px";
		temp.style.width = (this.size - this.borderSize*2) + "px";
	}

	if (this.bgOut.indexOf("img:") != -1)
		temp.style.background = "url(" + this.bgOut.substr(4) + ")";
	else
		temp.style.backgroundColor = this.bgOut;
	temp.style.position = "absolute";
	if (this.orientation == "horizontal")
	{
		temp.style.left = this.position + "px";
		temp.style.top = this.borderSize + "px";
	}
	else
	{
		temp.style.left = this.borderSize + "px";
		temp.style.top = this.position + "px";
	}

	var fontTag = document.createElement("font");
	fontTag.face = this.fontFace;
	fontTag.style.color = this.textColorOut;
	fontTag.style.fontSize = this.fontSize + "pt";
	if (this.fontStyleOut.indexOf("bold") != -1)
		fontTag.style.fontWeight = "bold";
	else if (this.fontStyleOut.indexOf("italic") != -1)
		fontTag.style.fontStyle = "italic";
	else if (this.fontStyleOut.indexOf("underline") != -1)
		fontTag.style.textDecoration = "underline";

	var showMenuFunction;
	if (menuToShow != 0)
		showMenuFunction = "showMenu(" + menuToShow + ", " + (menus.length - 1) + ", " + (this.items.length) 
			+ ", " + this.offsetX + ", " + this.offsetY + ");";
	else
		showMenuFunction = "hideAfter(" + (menus.length-1) + ");";

	var tempSize = this.size - this.borderSize*2;
	if (this.orientation == "horizontal")
		tempSize = iSize;
	else
		tempSize = this.size - this.borderSize*2;

	if (!isNaN(this.showChar) && this.showChar != "" && this.showChar != 0)
		this.showChar = String.fromCharCode(this.showChar);
	else if (this.showChar == 0)
		this.showChar = "";

	var showCharOver, showCharOut;
	var showCharOverParam = "none", showCharOutParam = "none";
	if (this.showChar.indexOf("rollover:") != -1)
	{
		var showCharArray = this.showChar.split(":");
		showCharOut = document.createElement("img");
		showCharOut.src = showCharArray[1];
		showCharOut.border = 0;
		showCharOverParam = showCharArray[2];
		showCharOutParam = showCharArray[1];
	}
	else
		showCharOut = document.createTextNode(this.showChar);
	var charFontTag = fontTag.cloneNode(true);
	if (menuToShow != 0)
		charFontTag.appendChild(showCharOut);
	else
	{
		showCharOverParam = "none";
		showCharOutParam = "none";
		charFontTag.innerHTML = "&nbsp;";
	}

	var contentFunctionOver = "", contentFunctionOut = "";
	var contentArray;
	var rollover;
	if (content.indexOf("rollover:") != -1)
	{
		contentArray = content.split(":");
		content = document.createElement("img");
		content.src = contentArray[1];
		content.border = 0;
		this.margin = 0;
		temp.style.padding = "0px";
		rollout = contentArray[1];
		rollover = contentArray[2];
	}

	var table = document.createElement("table");
	var tbody = document.createElement("tbody");
	var row = document.createElement("tr");
	var cell1 = document.createElement("td");
	var cell2 = document.createElement("td");

	table.border = 0;
	table.cellPadding = this.margin;
	table.cellSpacing = 0;
	table.width = tempSize;
	table.height = parseInt(temp.style.height);
	temp.appendChild(table);

	table.appendChild(tbody);
	tbody.appendChild(row);

	if (content.src)
		fontTag.appendChild(content);
	else
		fontTag.innerHTML = content;
	if (content.src || this.showChar == "" || this.showChar == 0)
		cell1.width = "100%";
	else
		cell1.width = "80%";
	row.appendChild(cell1);
	cell1.appendChild(fontTag);
	
	var cellWidth = table.width;
	if (!(content.src || this.showChar == "" || this.showChar == 0))
	{
		cell2.align = "right";
		//cell2.vAlign = "top";
		cell2.width = "20%";
		row.appendChild(cell2);
		cell2.appendChild(charFontTag);
		cellWidth = Math.round(table.width * .8);
	}

	var alignNum = 0;
	if (alignment == "center")
	{
		alignNum = Math.round((cellWidth - fontTag.offsetWidth) / 2);
		fontTag.style.paddingLeft = alignNum + "px";
	}
	else if (alignment == "right")
	{
		alignNum = cellWidth - fontTag.offsetWidth - 5;
		fontTag.style.paddingLeft = alignNum + "px";
	}

	link = link.replace(/[']/g, "\\'");
	link = link.replace(/\"/g, "\\'");

	if (!content.src)
	{	
		contentFunctionOver = "html(this, '" + this.bgOver + "', '" + this.textColorOver + "', '" + 
			this.fontStyleOver + "', '" + showCharOverParam + "');";
		contentFunctionOut = "html(this, '" + this.bgOut + "', '" + this.textColorOut + "', '" + 
			this.fontStyleOut + "', '" + showCharOutParam + "');";
		if (link != "" && link != "#")
		{
			contentFunctionOver += "window.status='" + link + "';";
			contentFunctionOut += "window.status='';";
		}
	}
	else
	{
		contentFunctionOver = "roll(this, '" + rollover + "');";
		contentFunctionOut = "roll(this, '" + rollout + "');";
	}

	if (this.showOnClick && menuToShow != 0)
		temp.onmouseover = new Function("reset(" + (menus.length - 1) + ", " + menuToShow + ");" + 
			contentFunctionOver);
	else
		temp.onmouseover = new Function(showMenuFunction + contentFunctionOver);

	if (menuToShow != 0)
	{
		if (!content.src)
			this.activeItems[this.activeItems.length] = "html(menus[" + (menus.length-1) + "].items[" + 
				this.items.length + "], '" + this.bgOut + "', '" + this.textColorOut + "', '" + 
				this.fontStyleOut + "', '" + showCharOutParam + "');";
		else
			this.activeItems[this.activeItems.length] = "roll(menus[" + (menus.length-1) + "].items[" + 
				this.items.length + "], '" + rollout + "');";

		if (link != "" && link != "#")
			this.activeItems[this.activeItems.length-1] += "status='';";
	}
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
	
	if (this.sepItems)
	{
		if (this.orientation == "horizontal")
			this.main.style.width = (parseInt(this.main.style.width) + iSize + this.borderSize) + "px";
		else
			this.main.style.height = (parseInt(this.main.style.height) + iSize + this.borderSize) + "px";
		this.position += iSize + this.borderSize;
	}
	else
	{
		if (this.orientation == "horizontal")
			this.main.style.width = (parseInt(this.main.style.width) + iSize) + "px";
		else
			this.main.style.height = (parseInt(this.main.style.height) + iSize) + "px";
		this.position += iSize;
	}

	if (this.hasShadow)
	{
		this.shadow.style.height = this.main.style.height;
		this.shadow.style.width = this.main.style.width;
	}

	temp.style.visibility = "inherit";
	this.items[this.items.length] = temp;
}

function html(element, bgChange, textColor, fontStyle, showCharParam)
{
	if (bgChange.indexOf("img:") != -1)
		element.style.background = "url(" + bgChange.substr(4) + ")";
	else
		element.style.backgroundColor = bgChange;
	if (element.onmouseup)
		element.style.cursor = "pointer";
	else
		element.style.cursor = "default";

	var isBold = false, isItalic = false, isUnderline = false;
	if (fontStyle.indexOf("bold") != -1)
		isBold = true;
	if (fontStyle.indexOf("italic") != -1)
		isItalic = true;
	if (fontStyle.indexOf("underline") != -1)
		isUnderline = true;

	if (element.firstChild.tagName == "TABLE")
	{
		var mainElement = element.firstChild.firstChild.firstChild.firstChild.firstChild;
		mainElement.style.color = textColor;
		if (isBold)
			mainElement.style.fontWeight = "bold";
		else
			mainElement.style.fontWeight = "normal";
		if (isItalic)
			mainElement.style.fontStyle = "italic";
		else
			mainElement.style.fontStyle = "normal";
		if (isUnderline)
			mainElement.style.textDecoration = "underline";
		else
			mainElement.style.textDecoration = "none";

		var showChar = element.firstChild.firstChild.firstChild.lastChild.firstChild;
		if (showCharParam != "none")
			showChar.firstChild.src = showCharParam;
		else
		{
			showChar.style.color = textColor;
			if (isBold)
				showChar.style.fontWeight = "bold";
			else
				showChar.style.fontWeight = "normal";
			if (isItalic)
				showChar.style.fontStyle = "italic";
			else
				showChar.style.fontStyle = "normal";
			if (isUnderline)
				showChar.style.textDecoration = "underline";
			else
				showChar.style.textDecoration = "none";
		}
	}
	else
	{
		element.firstChild.color = textColor;
		if (isBold)
			element.firstChild.style.fontWeight = "bold";
		else
			element.firstChild.style.fontWeight = "normal";
		if (isItalic)
			element.firstChild.style.fontStyle = "italic";
		else
			element.firstChild.style.fontStyle = "normal";
		if (isUnderline)
			element.firstChild.style.textDecoration = "underline";
		else
			element.firstChild.style.textDecoration = "none";
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
			if (menus[i].hasShadow) menus[i].shadow.style.visibility = "hidden";
			menus[i].main.style.visibility = "hidden";
		}
	}
}

function roll(element, source)
{
	if (element.onmouseup)
		element.style.cursor = "pointer";
	else
		element.style.cursor = "default";
	element.firstChild.firstChild.firstChild.firstChild.firstChild.firstChild.src = source;
}

function showMenu(num, pNum, iNum, offsetX, offsetY)
{
	if (menus[num].main.style.visibility != "visible")
	{
		hideAfter(pNum);

		var showX = parseInt(menus[pNum].main.style.left), showY = parseInt(menus[pNum].main.style.top);
		if (menus[pNum].orientation == "horizontal")
		{
			if (menus[pNum].items.length > iNum)
			{
				showY += parseInt(menus[pNum].main.style.height);
				showX += parseInt(menus[pNum].items[iNum].style.left);
			}
		}
		else
		{
			if (menus[pNum].items.length > iNum)
			{
				showX += parseInt(menus[pNum].main.style.width);
				showY += parseInt(menus[pNum].items[iNum].style.top);
			}
		}
	
		var bodyHeight = document.body.clientHeight;
		var bodyWidth = document.body.clientWidth;
		var scrollX = document.body.scrollLeft;
		var scrollY = document.body.scrollTop;
	
		if (showX + menus[num].main.offsetWidth > bodyWidth + scrollX)
		{
			showX -= (showX + menus[num].main.offsetWidth) - (bodyWidth + scrollX);
			if (menus[num].hasShadow)
				showX -= menus[num].sOffX;
		}
		if (showY + menus[num].main.offsetHeight > bodyHeight + scrollY)
		{
			showY -= (showY + menus[num].main.offsetHeight) - (bodyHeight + scrollY);
			if (menus[num].hasShadow)
				showY -= menus[num].sOffY;
		}

		showX += offsetX;
		showY += offsetY;

		if (menus[num].hasShadow)
		{
			menus[num].shadow.style.left = (showX + menus[num].sOffX) + "px";
			menus[num].shadow.style.top = (showY + menus[num].sOffY) + "px";
		}
	
		menus[num].main.style.left = showX + "px";
		menus[num].main.style.top = showY + "px";
		menus[num].main.style.visibility = "visible";
		if (menus[num].hasShadow) menus[num].shadow.style.visibility = "visible";
	}
}

function hideAfter(num)
{
	var i;
	for (i=num+1; i<menus.length; i++)
	{
		if (!menus[i].isMainMenu)
		{
			if (menus[i].hasShadow) menus[i].shadow.style.visibility = "hidden";
			menus[i].main.style.visibility = "hidden";
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
			if (menus[i].hasShadow) menus[i].shadow.style.visibility = "hidden";
			menus[i].main.style.visibility = "hidden";
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

function floatMenu(scrWidth, scrHeight, mrgLeft, adjustNum)
{
	if (this.isMainMenu)
	{
		var bodyWidth = 0, mrg = 0;
		if (docType)
		{
			mrg = mrgLeft + 10;
			bodyWidth = document.getElementsByTagName("BODY")[0].offsetWidth;
		}
		else
		{
			mrg = 10;
			bodyWidth = document.body.scrollWidth;
		}

		if (adjustNum == 0 || adjustNum == 2)
		{
			this.main.style.left = Math.ceil(this.main.offsetLeft + (screen.width - scrWidth)/2) + "px";
			this.main.style.left = Math.ceil(this.main.offsetLeft - (screen.width - bodyWidth)/2 + mrg) + "px";
			this.iframe.style.left = this.main.offsetLeft;
		}
		if (adjustNum == 1 || adjustNum == 2)
		{
			this.main.style.top = (this.main.offsetTop + (screen.height - scrHeight)/2) + "px";
			this.iframe.style.top = this.main.offsetTop + "px";
		}

		if (this.hasShadow)
		{
			this.shadow.style.left = (this.main.offsetLeft + this.sOffX) + "px";
			this.shadow.style.top = (this.main.offsetTop + this.sOffY) + "px";
			this.siframe.style.left = (this.shadow.offsetLeft) + "px";
			this.siframe.style.top = (this.shadow.offsetTop) + "px";
		}

		window.onresize = new Function("location.reload();");
	}
}

var menus = new Array();

