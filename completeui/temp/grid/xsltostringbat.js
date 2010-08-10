
		stringify("../src/client/grid/xsl/addXid.xslt", "../temp/grid/nitobi.data.addXidXslProc.js", "addXidXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/adjustXi.xslt", "../temp/grid/nitobi.data.adjustXiXslProc.js", "adjustXiXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/dataTranslatorXsl.xslt", "../temp/grid/nitobi.data.dataTranslatorXslProc.js", "dataTranslatorXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/dateFormatTemplates.xslt", "../temp/grid/nitobi.grid.dateFormatTemplatesXslProc.js", "dateFormatTemplatesXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/dateEditor.xslt", "../temp/grid/nitobi.form.dateXslProc.js", "dateXslProc", "nitobi.form");
	
		stringify("../src/client/grid/xsl/declarationConverter.xslt", "../temp/grid/nitobi.grid.declarationConverterXslProc.js", "declarationConverterXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/frameCssXsl.xslt", "../temp/grid/nitobi.grid.frameCssXslProc.js", "frameCssXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/frameXsl.xslt", "../temp/grid/nitobi.grid.frameXslProc.js", "frameXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/listboxXsl.xslt", "../temp/grid/nitobi.form.listboxXslProc.js", "listboxXslProc", "nitobi.form");
	
		stringify("../src/client/grid/xsl/mergeEbaXmlToLog.xslt", "../temp/grid/nitobi.data.mergeEbaXmlToLogXslProc.js", "mergeEbaXmlToLogXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/mergeEbaXml.xslt", "../temp/grid/nitobi.data.mergeEbaXmlXslProc.js", "mergeEbaXmlXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/numberFormatTemplates.xslt", "../temp/grid/nitobi.grid.numberFormatTemplatesXslProc.js", "numberFormatTemplatesXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/numberEditor.xslt", "../temp/grid/nitobi.form.numberXslProc.js", "numberXslProc", "nitobi.form");
	
		stringify("../src/client/grid/xsl/rowXsl.xslt", "../temp/grid/nitobi.grid.rowXslProc.js", "rowXslProc", "nitobi.grid");
	
		stringify("../src/client/grid/xsl/sort.xslt", "../temp/grid/nitobi.data.sortXslProc.js", "sortXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/fillColumn.xslt", "../temp/grid/nitobi.data.fillColumnXslProc.js", "fillColumnXslProc", "nitobi.data");
	
		stringify("../src/client/grid/xsl/updategramTranslatorXsl.xslt", "../temp/grid/nitobi.data.updategramTranslatorXslProc.js", "updategramTranslatorXslProc", "nitobi.data");
	
		stringify("../src/client/grid/../calendar/xsl/nitobi/calendar/render.xsl", "../temp/grid/nitobi.calendar.datePickerTemplate.js", "datePickerTemplate", "nitobi.calendar");
	
function stringify(inFilename, outFilename, name, namespace)
{
	// Need to replace / with \ for windows builds...
	//inFilename = inFilename.replace(/\//g, "\\");
	/*if (outFilename == null || outFilename == "..\\")
	{
		outFilename = path+"\\..\\"+ name + ".js";
	}
	else
	{
		outFilename = outFilename.replace(/\//g, "\\");
	}*/
	var path = inFilename.substr(0, inFilename.lastIndexOf("\\"));
	name = name || inFilename.substr(inFilename.lastIndexOf("\\")+1).replace(/\./,"");
	namespace = namespace || "";
	
	var tempName = "temp_ntb_"+name;
	var s = 'var '+tempName+'=\'';

	// Read in the source XSLT and single line it and encode the single quotes
	var contents = readFile(inFilename);
	contents = contents.replace(/'/g,"\\\\\\'") //some crazy stuff goin on there ...
		.replace(/\/\*/g,"/\'+\'*")
		.replace(/\*\//g,"*\'+\'/")
		.replace(/\t/g,' ')
		.replace(/\r\n/g,'')
		.replace(/\n/g,'')
		.replace(/\s+/g,' ');

	eval(namespace.replace(/\./g, "_") + "_" + name + " = '" + contents + "';");
	contents = importXslt(eval(namespace.replace(/\./g, "_") + "_" + name)); 

	s += contents
		.replace(/xsl\:attribute/gi, 'x:a-')
		.replace(/xsl\:template/gi, 'x:t-')
		.replace(/xsl\:apply-templates/gi, 'x:at-')
		.replace(/xsl\:choose/gi, 'x:c-')
		.replace(/xsl\:when/gi, 'x:wh-')
		.replace(/xsl\:otherwise/gi, 'x:o-')
		.replace(/\sname\=\"/gi, 'x:n-')
		.replace(/\sselect\=\"/gi, 'x:s-')
		.replace(/xsl\:variable/gi, 'x:va-')
		.replace(/xsl\:value-of/gi, 'x:v-')
		.replace(/xsl\:call-template/gi, 'x:ct-')
		.replace(/xsl\:with-param/gi, 'x:w-')
		.replace(/xsl\:param/gi, 'x:p-');
	
	s+='\';\n';

	s+= 'nitobi.lang.defineNs("'+namespace+'");\n';
	s+= namespace+'.'+name+' = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(' + tempName + '));\n';

	var output = new java.io.BufferedWriter(new java.io.FileWriter(new java.io.File(outFilename)));
	output.write(s);
	output.close();
}

function escapeXslt(sXslt)
{
	return sXslt.replace(/\&lt\;/g, '&amp;lt;').replace(/\&gt\;/g, '&amp;gt;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

function importXslt(xsl1)
{
	// Do a replace on <!--nitobi.grid.xslProcessorName--> and merge the contents
	// The second block does this for escaped XSL
	var re = new RegExp('\<\!--(.*?)--\>', 'gi');
	var exprMatches = xsl1.match(re);

	xsl2 = "";
	if (exprMatches != null)
	{
		for (var i=0; i<exprMatches.length; i++)
		{
			var incl = exprMatches[i].replace("<!--","").replace("-->","").replace(/\./g,"_");
			// Get the imported stylesheet and remove the outer stylesheet element
			try {
				xsl2 = eval(incl);
			} catch(e) {
				continue;
			}

			if (xsl2 == null || typeof(xsl2) != "string")
				continue;

			xsl2 = xsl2.replace(/\<xsl:stylesheet.*?\>/g,'');
			xsl2 = xsl2.replace(/\<\/xsl:stylesheet\>/g,'');

			xsl1 = xsl1.replace('<!--'+incl.replace(/\_/g,'.')+'-->', xsl2);
		}
	}

	var re = new RegExp('\&lt;\!--(.*?)--\&gt;', 'gi');
	var exprMatches = xsl1.match(re);
	
	if (exprMatches != null)
	{
		for (var i=0; i<exprMatches.length; i++)
		{
			var incl = exprMatches[i].replace("&lt;!--","").replace("--&gt;","").replace(/\./g,"_");

			// Get the imported stylesheet and remove the outer stylesheet element
			try {
				xsl2 = eval(incl);
			} catch(e) {
				continue;
			}

			if (xsl2 == null || typeof(xsl2) != "string")
				continue;

			xsl2 = xsl2.replace(/\<xsl:stylesheet.*?\>/g,'');
			xsl2 = xsl2.replace(/\<\/xsl:stylesheet\>/g,'');
			xsl2 = escapeXslt(xsl2);
			xsl1 = xsl1.replace('&lt;!--'+incl.replace(/\_/g,'.')+'--&gt;', xsl2);
		}
	}
	return xsl1;
}
