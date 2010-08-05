
	function tooltip(a){
	var aa = new Array()
	for(i=0;i<a.options.length;i++){
	aa[i] = a.options[i].text;
	}
	a.title = aa[a.selectedIndex];
	}

	function onmover(id){
	document.getElementById(id).className="vfocus";
	}
	function onmout(id,classtr){
	document.getElementById(id).className=classtr;
	}

   function getListDBWhere(casestr,strchar,idinput,idlayer,ctrlid,onchangefunction,line,wherestr){

	ocf = 0;
	if(onchangefunction == "1")
	ocf = 1;

	var arr_fld=new Array("action","strchar","idinput","idlayer","ctrlid","ocf","line","wherestr");//name for POST
	var arr_val=new Array(casestr,strchar,idinput,idlayer,ctrlid,ocf,line,wherestr);//value for POST

	getRequest(arr_fld,arr_val);

	}

	function getListDB(casestr,strchar,idinput,idlayer,ctrlid,onchangefunction,line){

	ocf = 0;
	if(onchangefunction == "1")
	ocf = 1;

	var arr_fld=new Array("action","strchar","idinput","idlayer","ctrlid","ocf","line");//name for POST
	var arr_val=new Array(casestr,strchar,idinput,idlayer,ctrlid,ocf,line);//value for POST
	
	getRequest(arr_fld,arr_val);
	
	}

	function showSearchLayer(idinput,idlayer){
	
	var inputLayer = document.getElementById(idinput).style.display;

	if(inputLayer=="none"){
	document.getElementById(idinput).style.display = "";
	document.getElementById(idlayer).style.display = "";
	document.getElementById(idinput).focus();
	}else{
	document.getElementById(idinput).style.display = "none";
	document.getElementById(idlayer).style.display = "none";
	//document.getElementById(idinput).value = "";
	}
	}

	function selectList(bpartner_id,idinput,idlayer,ctrlid,onchangefunction){
	//bpartner_idLayer
	//document.getElementById(idinput).value = "";
	document.getElementById(idinput).style.display = "none";
	document.getElementById(idlayer).style.display = "none";

	document.getElementById(ctrlid).value = bpartner_id;


	if(onchangefunction != "")
	eval(onchangefunction+";");
	
	}

	function wopen(url, name, w, h){
	
	w += 32;
	h += 96;
	wleft = (screen.width - w) / 2;
	wtop = (screen.height - h) / 2;
	
	if (wleft < 0) {
	w = screen.width;
	wleft = 0;
	}
	if (wtop < 0) {
	h = screen.height;
	wtop = 0;
	}
	var win = window.open(url,
	name,
	'width=' + w + ', height=' + h + ', ' +
	'left=' + wleft + ', top=' + wtop + ', ' +
	'location=no, menubar=no, ' +
	'status=no, toolbar=no, scrollbars=no, resizable=no');
	
	win.resizeTo(w, h);
	
	win.moveTo(wleft, wtop);
	win.focus();
	}

	function openViewWindow(windows_name,ctrlname,val){
	
	if(val>0)
	window.open(windows_name+'?action=edit&'+ctrlname+'='+val);
	}
