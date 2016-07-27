window.onresize = new Function("location.reload();");
var docType = false;

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
	this.fontStyleOver = fontStyleOver;
	this.fontStyleOut = fontStyleOut;
	this.textColorOut = textColorOut;
	this.textColorOver = textColorOver;
	this.borderSize = borderSize;
	this.borderColor = borderColor;
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

	if (orientation == "horizontal")
	{
		if (sepItems)
			this.main = new Layer(borderSize, window);
		else
			this.main = new Layer(borderSize*2, window);
	}
	else
		this.main = new Layer(size, window);
	
	this.main.bgColor = borderColor;
	if (orientation == "horizontal")
		this.main.clip.height = size;
	else
	{
		if (sepItems)
			this.main.clip.height = borderSize;
		else
			this.main.clip.height = borderSize*2;
	}
	this.main.pageX = x;
	this.main.pageY = y;
	this.main.zIndex = 1001 + menus.length;

	this.main.onmouseover = new Function("keepOpen();");
	this.main.onmouseout = new Function("hide();");

	if (isMainMenu)
		this.main.hidden = false;

	if (this.hasShadow)
	{
		this.shadow = new Layer(this.main.clip.width, window);
		this.shadow.bgColor = shadowColor;
		this.shadow.pageX = x + sOffX;
		this.shadow.pageY = y + sOffY;
		this.shadow.zIndex = 1000 + menus.length;
		this.shadow.clip.height = this.main.clip.height;
		if (isMainMenu)
			this.shadow.hidden = false;
	}
}

function separator(sSize, sColor)
{
	if (!this.sepItems)
	{
		if (this.orientation == "horizontal")
			var temp = new Layer(sSize, this.main);
		else
			var temp = new Layer(this.size - this.borderSize*2, this.main);
		temp.bgColor = sColor;

		if (this.orientation == "horizontal")
		{
			temp.height = this.size - this.borderSize*2;
			temp.width = sSize;
			temp.left = this.position;
			temp.top = this.borderSize;
			temp.document.open();
			temp.document.write('<img src="' + blank.src + '" height="' + temp.height + '" width="' + sSize + 
				'">');
			temp.document.close();
		}
		else
		{
			temp.height = sSize;
			temp.width = this.size - this.borderSize*2;
			temp.left = this.borderSize;
			temp.top = this.position;
			temp.document.open();
			temp.document.write('<img src="' + blank.src + '" height="' + sSize + '" width="' + temp.width + 
				'">');
			temp.document.close();
		}

		temp.hidden = false;
		temp.visibility = "inherit";

		if (this.orientation == "horizontal")
			this.main.clip.width += sSize;
		else
			this.main.clip.height += sSize;
		this.position += sSize;

		if (this.hasShadow)
		{
			this.shadow.clip.height = this.main.clip.height;
			this.shadow.clip.width = this.main.clip.width;
		}
	}
}
 
function item(link, target, iSize, alignment, content, menuToShow)
{
	alignment = alignment.toLowerCase();
	var temp;
	if (this.orientation == "horizontal")
	{
		temp = new Layer(iSize, this.main);
		temp.clip.height = this.size - this.borderSize*2;
	}
	else
	{
		temp = new Layer(this.size - this.borderSize*2, this.main);
		temp.clip.height = iSize;
	}
	
	if (this.bgOut.indexOf("img:") == -1)
		temp.bgColor = this.bgOut;
	if (this.orientation == "horizontal")
	{
		temp.x = this.position;
		temp.y = this.borderSize;
	}
	else
	{
		temp.x = this.borderSize;
		temp.y = this.position;
	}

	var fontStyleBeg = "", fontStyleEnd = "";
	if (this.fontStyleOut.indexOf("bold") != -1)
	{
		fontStyleBeg += "<b>";
		fontStyleEnd += "</b>";
	}
	if (this.fontStyleOut.indexOf("italic") != -1)
	{
		fontStyleBeg += "<i>";
		fontStyleEnd = "</i>" + fontStyleEnd;
	}
	if (this.fontStyleOut.indexOf("underline") != -1)
	{
		fontStyleBeg += "<u>";
		fontStyleEnd = "</u>" + fontStyleEnd;
	}

	var fontStyleOverBeg = "", fontStyleOverEnd = "";
	if (this.fontStyleOver.indexOf("bold") != -1)
	{
		fontStyleOverBeg += "<b>";
		fontStyleOverEnd += "</b>";
	}
	if (this.fontStyleOver.indexOf("italic") != -1)
	{
		fontStyleOverBeg += "<i>";
		fontStyleOverEnd = "</i>" + fontStyleEnd;
	}
	if (this.fontStyleOver.indexOf("underline") != -1)
	{
		fontStyleOverBeg += "<u>";
		fontStyleOverEnd = "</u>" + fontStyleEnd;
	}

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

	var tWidth = "";
	if (this.showChar == "" || this.showChar == 0)
		tWidth = "100%";
	else
	{
		tWidth = "80%";
		if (!isNaN(this.showChar))
			this.showChar = String.fromCharCode(this.showChar);
	}

	var showCharOver = "", showCharOut = "";
	if (menuToShow != 0)
	{
		if (typeof(this.showChar) != "number" && this.showChar.indexOf("rollover:") != -1)
		{
			var showCharArray = this.showChar.split(":");
			showCharOver = '<img src="' + showCharArray[2] + '" border="0">';
			showCharOut = '<img src="' + showCharArray[1] + '" border="0">';
		}
		else
		{
			showCharOver = this.showChar;
			showCharOut = this.showChar;
		}
	}

	var contentFunctionOver = "", contentFunctionOut = "";
	content = content.replace(/[']/g, "\\'");
	var outContent = '', overContent = '', imgContent = '';
	var bodyBeg = '<body marginheight="0" marginwidth="0">', bodyEnd = '</body>';

	if (this.bgOut.indexOf("img:") != -1)
	{
		var bgLayer = new Layer(temp.clip.width, temp);
		bgLayer.height = temp.clip.height;
		bgLayer.left = 0;
		bgLayer.top = 0;
		bgLayer.visibility = "inherit";
		bgLayer.zIndex = this.main.zIndex + 1;
		var bgContent = '<img src="' + this.bgOut.substr(4) + '">';
		bgLayer.document.open();
		bgLayer.document.write(bodyBeg + bgContent + bodyEnd);
		bgLayer.document.close();
		bgLayer.hidden = false;
	}

	var layer1 = new Layer(temp.clip.width, temp);
	layer1.height = temp.clip.height;
	layer1.left = 0;
	layer1.top = 0;
	layer1.visibility = "inherit";
	layer1.zIndex = this.main.zIndex + 2;
	outContent += '<table border="0" cellpadding="' + this.margin + '" cellspacing="0" width="' + 
		temp.clip.width + '">';
	if (contentFunctionOver == "")
	{
		outContent += '<tr><td align="' + alignment + '" width="' + tWidth + '"><font face="' + this.fontFace + 
			'" point-size="' + this.fontSize + '" color="' + this.textColorOut + '">' + fontStyleBeg + content 
			+ fontStyleEnd + '</font></td>';
		if (tWidth == "80%")
			outContent += '<td align="right" width="20%"><font face="' + this.fontFace + '" point-size="' + 
				this.fontSize + '" color="' + this.textColorOut + '">' + fontStyleBeg + showCharOut + fontStyleEnd 
				+ '</font></td></tr>';
	}
	else
		outContent += '<tr><td align="' + alignment + '">' + content + '</td></tr>';
	outContent += '</table>';
	layer1.document.open();
	layer1.document.write(bodyBeg + outContent + bodyEnd);
	layer1.document.close();

	var layer2 = new Layer(temp.clip.width, temp);
	layer2.height = temp.clip.height;
	layer2.left = 0;
	layer2.top = 0;
	layer2.zIndex = this.main.zIndex + 2;
	overContent += '<table border="0" cellpadding="' + this.margin + '" cellspacing="0" width="' + 
		temp.clip.width + '">';
	if (contentFunctionOver == "")
	{
		overContent += '<tr><td align="' + alignment + '" width="' + tWidth + '"><font face="' + this.fontFace + 
			'" point-size="' + this.fontSize + '" color="' + this.textColorOver + '">' + fontStyleOverBeg + 
			content + fontStyleOverEnd + '</font></td>';
		if (tWidth == "80%")
			overContent += '<td align="right" width="20%"><font face="' + this.fontFace + '" point-size="' + 
				this.fontSize + '" color="' + this.textColorOver + '">' + fontStyleOverBeg + showCharOver + 
				fontStyleOverEnd + '</font></td></tr>';
	}
	else
		overContent += '<tr><td align="' + alignment + '">' + content + '</td></tr>';
	overContent += '</table>';
	layer2.document.open();
	layer2.document.write(bodyBeg + overContent + bodyEnd);
	layer2.document.close();

	var imgLayer = new Layer(temp.clip.width, temp);
	imgLayer.height = temp.clip.height;
	imgLayer.left = 0;
	imgLayer.top = 0;
	imgLayer.visibility = "inherit";
	imgLayer.zIndex = this.main.zIndex + 3;
	if (link != "" && link != "#" && !this.showOnClick)
			imgContent += '<a href="' + link + '" target="' + target + '">';
	if (this.showOnClick && menuToShow != 0)
			imgContent += '<a href="javascript:void(0)" onclick="' + showMenuFunction + '">';
	imgContent += '<img src="' + buildDir + 'blank.gif" height="' + temp.clip.height + '" width="' + 
		temp.clip.width + '" border="0">';
	if ((link != "" && link != "#") || (this.showOnClick && menuToShow != 0))
		imgContent += '</a>';
	imgLayer.document.open();
	imgLayer.document.write(bodyBeg + imgContent + bodyEnd);
	imgLayer.document.close();

	if (content.indexOf("rollover:") != -1)
	{
		var imgs = content.split(":");

		outContent = '<a href="' + link + '" target="' + target + '">';
		outContent += '<img src="' + imgs[1] + '" border="0">';
		outContent += '</a>';
		layer1.document.open();
		layer1.document.write(bodyBeg + outContent + bodyEnd);
		layer1.document.close();

		overContent = '<a href="' + link + '" target="' + target + '">';
		overContent += '<img src="' + imgs[2] + '" border="0">';
		overContent += '</a>';
		layer2.document.open();
		layer2.document.write(bodyBeg + overContent + bodyEnd);
		layer2.document.close();
	}

	layer1.hidden = false;
	imgLayer.hidden = false;

	contentFunctionOver = "changeLayer(this, 1)";
	contentFunctionOut = "changeLayer(this, 0)";

	if (this.showOnClick && menuToShow != 0)
		temp.onmouseover = new Function("reset(" + (menus.length - 1) + ", " + menuToShow + ");" + 
			"changeBg(this, '" + this.bgOver + "');" + contentFunctionOver);
	else
		temp.onmouseover = new Function(showMenuFunction + "changeBg(this, '" + this.bgOver + "');" + 
			contentFunctionOver);

	if (menuToShow != 0)
		this.activeItems[this.activeItems.length] = this.items.length;
	else
		temp.onmouseout = new Function("changeBg(this, '" + this.bgOut + "');" + contentFunctionOut);

	temp.visibility = "inherit";
	
	if (this.sepItems)
	{
		if (this.orientation == "horizontal")
			this.main.clip.width += iSize + this.borderSize;
		else
			this.main.clip.height += iSize + this.borderSize;
		this.position += iSize + this.borderSize;
	}
	else
	{
		if (this.orientation == "horizontal")
			this.main.clip.width += iSize;
		else
			this.main.clip.height += iSize;
		this.position += iSize;
	}

	if (this.hasShadow)
	{
		this.shadow.clip.height = this.main.clip.height;
		this.shadow.clip.width = this.main.clip.width;
	}

	this.items[this.items.length] = temp;
}

function changeBg(element, change)
{
	if (change.indexOf("img:") != -1)
		element.layers[0].document.images[0].src = change.substr(4);
	else
		element.bgColor = change;
}

function changeLayer(lyr, num)
{
	if (lyr.layers.length > 3)
		numToHide = (num == 0) ? 2 : 1;
	else
		numToHide = (num == 0) ? 1 : 0;
	numToShow = num;

	lyr.layers[numToHide].hidden = true;
	lyr.layers[numToShow].hidden = false;
}

function reset(num, sNum)
{
	var i;
	for (i=0; i<menus[num].activeItems.length; i++)
	{
		changeBg(menus[num].items[parseInt(menus[num].activeItems[i])], menus[num].bgOut);
		changeLayer(menus[num].items[parseInt(menus[num].activeItems[i])], 0);
	}
	for (i=num+1; i<menus.length; i++)
	{
		if (i != sNum)
		{
			if (menus[i].hasShadow) menus[i].shadow.hidden = true;
			menus[i].main.hidden = true;
		}
	}
}

function showMenu(num, pNum, iNum, offsetX, offsetY)
{
	if (menus[num].main.hidden)
	{
		hideAfter(pNum);

		var showX = menus[pNum].main.pageX, showY = menus[pNum].main.pageY;
		if (menus[pNum].orientation == "horizontal")
		{
			if (menus[pNum].items.length > iNum)
			{
				showY += menus[pNum].main.clip.height;
				showX += menus[pNum].items[iNum].x;
			}
		}
		else
		{
			if (menus[pNum].items.length > iNum)
			{
				showX += menus[pNum].main.clip.width;
				showY += menus[pNum].items[iNum].y;
			}
		}
	
		if (showX + menus[num].main.clip.width > window.innerWidth + window.pageXOffset)
		{
			showX -= (showX + menus[num].main.clip.width) - (window.innerWidth + window.pageXOffset);
			if (menus[num].hasShadow)
				showX -= menus[num].sOffX;
		}
		if (showY + menus[num].main.clip.height > window.innerHeight + window.pageYOffset)
		{
			showY -= (showY + menus[num].main.clip.height) - (window.innerHeight + window.pageYOffset);
			if (menus[num].hasShadow)
				showY -= menus[num].sOffY;
		}

		showX += offsetX;
		showY += offsetY;

		if (menus[num].hasShadow)
		{
			menus[num].shadow.pageX = showX + menus[num].sOffX;
			menus[num].shadow.pageY = showY + menus[num].sOffY;
		}
	
		menus[num].main.pageX = showX;
		menus[num].main.pageY = showY;
		menus[num].main.hidden = false;
		if (menus[num].hasShadow) menus[num].shadow.hidden = false;
	}
}

function hideAfter(num)
{
	var i;
	for (i=num+1; i<menus.length; i++)
	{
		if (!menus[i].isMainMenu)
		{
			if (menus[i].hasShadow) menus[i].shadow.hidden = true;
			menus[i].main.hidden = true;
		}
	}

	for (i=num; i<menus.length; i++)
	{
		for (j=0; j<menus[i].activeItems.length; j++)
		{
			changeBg(menus[i].items[parseInt(menus[i].activeItems[j])], menus[i].bgOut);
			changeLayer(menus[i].items[parseInt(menus[i].activeItems[j])], 0);
		}
	}
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
	for (i=0; i<menus.length; i++)
	{
		if (!menus[i].isMainMenu)
		{
			if (menus[i].hasShadow) menus[i].shadow.hidden = true;
			menus[i].main.hidden = true;
		}
	}

	for (i=0; i<menus.length; i++)
	{
		for (j=0; j<menus[i].activeItems.length; j++)
		{
			changeBg(menus[i].items[parseInt(menus[i].activeItems[j])], menus[i].bgOut);
			changeLayer(menus[i].items[parseInt(menus[i].activeItems[j])], 0);
		}
	}
}

function debug()
{
	var win = window.open();
	win.document.open();
	win.document.write('<textarea cols=50 rows=25 wrap=virtual>Debug information isn\'t available in Netscape 4.</textarea>');
	win.document.close();
	win.focus();
}

function floatMenu(scrWidth, scrHeight, mrgLeft, adjustNum)
{
	if (this.isMainMenu)
	{
		if (adjustNum == 0 || adjustNum == 2)
		{
			this.main.left = Math.ceil(this.main.pageX + (screen.width - scrWidth)/2);
			this.main.left = Math.ceil(this.main.pageX - (screen.width - window.innerWidth)/2);
		}
		if (adjustNum == 1 || adjustNum == 2)
			this.main.top = this.main.pageY + (screen.height - scrHeight)/2;

		if (this.hasShadow)
		{
			this.shadow.left = this.main.pageX + this.sOffX;
			this.shadow.top = this.main.pageY + this.sOffY;
		}
	}
}

var menus = new Array();