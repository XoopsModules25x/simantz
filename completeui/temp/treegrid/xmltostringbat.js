
        stringify("../src/client/treegrid/xml/model.xml", "../temp/treegrid/nitobi.grid.modelDoc.js", "modelDoc", "nitobi.grid");
    
        stringify("../src/client/treegrid/xml/toolbar.xml", "../temp/treegrid/nitobi.grid.toolbarDoc.js", "toolbarDoc", "nitobi.grid");
    
        stringify("../src/client/treegrid/xml/toolbarpaging.xml", "../temp/treegrid/nitobi.grid.pagingToolbarDoc.js", "pagingToolbarDoc", "nitobi.grid");
    
function stringify(inFilename, outFilename, name, namespace)
{
	//inFilename = inFilename.replace(/\//g, "\\");
	var path = inFilename.substr(0, inFilename.lastIndexOf("\\"));
	name = name || inFilename.substr(inFilename.lastIndexOf("\\")+1).replace(/\./,"");
	/*if (outFilename == null || outFilename == "..\\")
	{
		outFilename = path+"\\..\\"+ name + ".js";
	}
	else
	{
		outFilename = outFilename.replace(/\//g, "\\");
	}*/
	namespace = namespace || "";

	var contents = readFile(inFilename);
//	var numberXslt = fs.OpenTextFile(path + '\\numberFormatTemplates.xslt').ReadAll();
//	var dateXslt = fs.OpenTextFile(path + '\\dateFormatTemplates.xslt').ReadAll();

	var tempName = "temp_ntb_"+name;
	var s = 'var '+tempName+'=\'';

	s+=contents.replace(/\r\n/g,'').replace(/'/g,"\\'");
	
	s+='\';\n';

	s+= 'nitobi.lang.defineNs("'+namespace+'");\n';
	s+= namespace+'.'+name+' = nitobi.xml.createXmlDoc(' + tempName + ');\n';

	var output = new java.io.BufferedWriter(new java.io.FileWriter(new java.io.File(outFilename)));
	output.write(s);
	output.close();
}

function escapeXslt(sXslt)
{
	return sXslt.replace(/\&lt\;/g, '&amp;lt;').replace(/\&gt\;/g, '&amp;gt;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}
