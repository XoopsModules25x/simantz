/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 *
 * http://www.nitobi.com/license
 */
if(typeof (nitobi)=="undefined"||typeof (nitobi.lang)=="undefined"){
alert("The Nitobi framework source could not be found. Is it included before any other Nitobi components?");
}
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.Scrollbar=function(){
this.uid="scroll"+nitobi.base.getUid();
};
nitobi.ui.Scrollbar.prototype.render=function(){
};
nitobi.ui.Scrollbar.prototype.attachToParent=function(_1,_2,_3){
this.UiContainer=_1;
this.element=_2||nitobi.html.getFirstChild(this.UiContainer);
if(this.element==null){
this.render();
}
this.surface=_3||nitobi.html.getFirstChild(this.element);
this.element.onclick="";
this.element.onmouseover="";
this.element.onmouseout="";
this.element.onscroll="";
nitobi.html.attachEvent(this.element,"scroll",this.scrollByUser,this);
};
nitobi.ui.Scrollbar.prototype.align=function(){
var vs=document.getElementById("vscroll"+this.uid);
var dx=-1;
if(nitobi.browser.MOZ){
dx=-3;
}
nitobi.drawing.align(vs,this.UiContainer.childNodes[0],269484288,-42,0,24,dx,false);
};
nitobi.ui.Scrollbar.prototype.scrollByUser=function(){
this.fire("ScrollByUser",this.getScrollPercent());
};
nitobi.ui.Scrollbar.prototype.setScroll=function(_6){
};
nitobi.ui.Scrollbar.prototype.getScrollPercent=function(){
};
nitobi.ui.Scrollbar.prototype.setRange=function(_7){
};
nitobi.ui.Scrollbar.prototype.getWidth=function(){
return nitobi.html.getScrollBarWidth();
};
nitobi.ui.Scrollbar.prototype.getHeight=function(){
return nitobi.html.getScrollBarWidth();
};
nitobi.ui.Scrollbar.prototype.fire=function(_8,_9){
return nitobi.event.notify(_8+this.uid,_9);
};
nitobi.ui.Scrollbar.prototype.subscribe=function(_a,_b,_c){
if(typeof (_c)=="undefined"){
_c=this;
}
return nitobi.event.subscribe(_a+this.uid,nitobi.lang.close(_c,_b));
};
nitobi.ui.VerticalScrollbar=function(){
this.uid="vscroll"+nitobi.base.getUid();
};
nitobi.lang.extend(nitobi.ui.VerticalScrollbar,nitobi.ui.Scrollbar);
nitobi.ui.VerticalScrollbar.prototype.setScrollPercent=function(_d){
this.element.scrollTop=(this.surface.offsetHeight-this.element.offsetHeight)*_d;
return false;
};
nitobi.ui.VerticalScrollbar.prototype.getScrollPercent=function(){
return (this.element.scrollTop/(this.surface.offsetHeight-this.element.offsetHeight));
};
nitobi.ui.VerticalScrollbar.prototype.setRange=function(_e){
var st=this.element.scrollTop;
this.surface.style.height=Math.floor(this.element.offsetHeight/_e)+"px";
this.element.scrollTop=st;
this.element.scrollTop=this.element.scrollTop;
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.HorizontalScrollbar=function(){
this.uid="hscroll"+nitobi.base.getUid();
};
nitobi.lang.extend(nitobi.ui.HorizontalScrollbar,nitobi.ui.Scrollbar);
nitobi.ui.HorizontalScrollbar.prototype.getScrollPercent=function(){
return (this.element.scrollLeft/(this.surface.clientWidth-this.element.clientWidth));
};
nitobi.ui.HorizontalScrollbar.prototype.setScrollPercent=function(_10){
this.element.scrollLeft=(this.surface.clientWidth-this.element.clientWidth)*_10;
return false;
};
nitobi.ui.HorizontalScrollbar.prototype.setRange=function(_11){
this.surface.style.width=Math.floor(this.element.offsetWidth/_11)+"px";
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.IDataBoundList=function(){
};
nitobi.ui.IDataBoundList.prototype.getGetHandler=function(){
return this.getHandler;
};
nitobi.ui.IDataBoundList.prototype.setGetHandler=function(_12){
this.column.getModel().setAttribute("GetHandler",_12);
this.getHandler=_12;
};
nitobi.ui.IDataBoundList.prototype.getDataSourceId=function(){
return this.datasourceId;
};
nitobi.ui.IDataBoundList.prototype.setDataSourceId=function(_13){
this.column.getModel().setAttribute("DatasourceId",_13);
this.datasourceId=_13;
};
nitobi.ui.IDataBoundList.prototype.getDisplayFields=function(){
return this.displayFields;
};
nitobi.ui.IDataBoundList.prototype.setDisplayFields=function(_14){
this.column.getModel().setAttribute("DisplayFields",_14);
this.displayFields=_14;
};
nitobi.ui.IDataBoundList.prototype.getValueField=function(){
return this.valueField;
};
nitobi.ui.IDataBoundList.prototype.setValueField=function(_15){
this.column.getModel().setAttribute("ValueField",_15);
this.valueField=_15;
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.CacheMap=function(){
this.tail=null;
this.debug=new Array();
};
nitobi.collections.CacheMap.prototype.insert=function(low,_17){
low=Number(low);
_17=Number(_17);
this.debug.push("insert("+low+","+_17+")");
var _18=new nitobi.collections.CacheNode(low,_17);
if(this.head==null){
this.debug.push("empty cache, adding first node");
this.head=_18;
this.tail=_18;
}else{
var n=this.head;
while(n!=null&&low>n.high+1){
n=n.next;
}
if(n==null){
this.debug.push("appending node to end");
this.tail.next=_18;
_18.prev=this.tail;
this.tail=_18;
}else{
this.debug.push("inserting new node before "+n.toString());
if(n.prev!=null){
_18.prev=n.prev;
n.prev.next=_18;
}
_18.next=n;
n.prev=_18;
while(_18.mergeNext()){
}
if(_18.prev==null){
this.head=_18;
}
if(_18.next==null){
this.tail=_18;
}
}
}
};
nitobi.collections.CacheMap.prototype.remove=function(low,_1b){
low=Number(low);
_1b=Number(_1b);
this.debug.push("insert("+low+","+_1b+")");
if(this.head==null){
}else{
if(_1b<this.head.low||low>this.tail.high){
return;
}
var _1c=this.head;
while(_1c!=null&&low>_1c.high){
_1c=_1c.next;
}
if(_1c==null){
this.debug.push("the range was not found");
}else{
var end=_1c;
var _1e=null;
while(end!=null&&_1b>end.high){
if((end.next!=null&&_1b<end.next.low)||end.next==null){
break;
}
_1e=end.next;
if(end!=_1c){
this.removeNode(end);
}
end=_1e;
}
if(_1c!=end){
if(_1b>=end.high){
this.removeNode(end);
}
if(low<=_1c.low){
this.removeNode(_1c);
}
}else{
if(_1c.low>=low&&_1c.high<=_1b){
this.removeNode(_1c);
return;
}else{
if(low>_1c.low&&_1b<_1c.high){
var _1f=_1c.low;
var _20=_1c.high;
this.removeNode(_1c);
this.insert(_1f,low-1);
this.insert(_1b+1,_20);
return;
}
}
}
if(end!=null&&_1b<end.high){
end.low=_1b+1;
}
if(_1c!=null&&low>_1c.low){
_1c.high=low-1;
}
}
}
};
nitobi.collections.CacheMap.prototype.gaps=function(low,_22){
var g=new Array();
var n=this.head;
if(n==null||n.low>_22||this.tail.high<low){
g.push(new nitobi.collections.Range(low,_22));
return g;
}
var _25=0;
while(n!=null&&n.high<low){
_25=n.high+1;
n=n.next;
}
if(n!=null){
do{
if(g.length==0){
if(low<n.low){
g.push(new nitobi.collections.Range(Math.max(low,_25),Math.min(n.low-1,_22)));
}
}
if(_22>n.high){
if(n.next==null||n.next.low>_22){
g.push(new nitobi.collections.Range(n.high+1,_22));
}else{
g.push(new nitobi.collections.Range(n.high+1,n.next.low-1));
}
}
n=n.next;
}while(n!=null&&n.high<_22);
}else{
g.push(new nitobi.collections.Range(this.tail.high+1,_22));
}
return g;
};
nitobi.collections.CacheMap.prototype.ranges=function(low,_27){
var g=new Array();
var n=this.head;
if(n==null||n.low>_27||this.tail.high<low){
return g;
}
while(n!=null&&n.high<low){
minLow=n.high+1;
n=n.next;
}
if(n!=null){
do{
g.push(new nitobi.collections.Range(n.low,n.high));
n=n.next;
}while(n!=null&&n.high<_27);
}
return g;
};
nitobi.collections.CacheMap.prototype.gapsString=function(low,_2b){
var gs=this.gaps(low,_2b);
var a=new Array();
for(var i=0;i<gs.length;i++){
a.push(gs[i].toString());
}
return a.join(",");
};
nitobi.collections.CacheMap.prototype.removeNode=function(_2f){
if(_2f.prev!=null){
_2f.prev.next=_2f.next;
}else{
this.head=_2f.next;
}
if(_2f.next!=null){
_2f.next.prev=_2f.prev;
}else{
this.tail=_2f.prev;
}
_2f=null;
};
nitobi.collections.CacheMap.prototype.toString=function(){
var n=this.head;
var s=new Array();
while(n!=null){
s.push(n.toString());
n=n.next;
}
return s.join(",");
};
nitobi.collections.CacheMap.prototype.flush=function(){
var _32=this.head;
while(Boolean(_32)){
var _33=_32.next;
delete (_32);
_32=_33;
}
this.head=null;
this.tail=null;
};
nitobi.collections.CacheMap.prototype.insertIntoRange=function(_34){
var n=this.head;
var inc=0;
while(n!=null){
if(_34>=n.low&&_34<=n.high){
inc=1;
n.high+=inc;
}else{
n.low+=inc;
n.high+=inc;
}
n=n.next;
}
if(inc==0){
this.insert(_34,_34);
}
};
nitobi.collections.CacheMap.prototype.removeFromRange=function(_37){
var n=this.head;
var inc=0;
while(n!=null){
if(_37>=n.low&&_37<=n.high){
inc=-1;
if(n.low==n.high){
this.remove(_37,_37);
}else{
n.high+=inc;
}
}else{
n.low+=inc;
n.high+=inc;
}
n=n.next;
}
ntbAssert(inc!=0,"Tried to remove something from a range where the range does not exist");
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.BlockMap=function(){
this.head=null;
this.tail=null;
this.debug=new Array();
};
nitobi.lang.extend(nitobi.collections.BlockMap,nitobi.collections.CacheMap);
nitobi.collections.BlockMap.prototype.insert=function(low,_3b){
low=Number(low);
_3b=Number(_3b);
this.debug.push("insert("+low+","+_3b+")");
if(this.head==null){
var _3c=new nitobi.collections.CacheNode(low,_3b);
this.debug.push("empty cache, adding first node");
this.head=_3c;
this.tail=_3c;
}else{
var n=this.head;
while(n!=null&&low>n.high){
n=n.next;
}
if(n==null){
var _3c=new nitobi.collections.CacheNode(low,_3b);
this.debug.push("appending node to end");
this.tail.next=_3c;
_3c.prev=this.tail;
this.tail=_3c;
}else{
this.debug.push("inserting new node into or before "+n.toString());
if(low<n.low||_3b>n.high){
if(low<n.low){
var _3c=new nitobi.collections.CacheNode(low,_3b);
_3c.prev=n.prev;
_3c.next=n;
if(n.prev!=null){
n.prev.next=_3c;
}
n.prev=_3c;
_3c.high=Math.min(_3c.high,n.low-1);
}else{
var _3c=new nitobi.collections.CacheNode(n.high+1,_3b);
_3c.prev=n;
_3c.next=n.next;
if(n.next!=null){
n.next.prev=_3c;
_3c.high=Math.min(_3b,_3c.next.low-1);
}
n.next=_3c;
}
if(_3c.prev==null){
this.head=_3c;
}
if(_3c.next==null){
this.tail=_3c;
}
}
}
}
};
nitobi.collections.BlockMap.prototype.blocks=function(low,_3f){
var g=new Array();
var n=this.head;
if(n==null||n.low>_3f||this.tail.high<low){
g.push(new nitobi.collections.Range(low,_3f));
return g;
}
var _42=0;
while(n!=null&&n.high<low){
_42=n.high+1;
n=n.next;
}
if(n!=null){
do{
if(g.length==0){
if(low<n.low){
g.push(new nitobi.collections.Range(Math.max(low,_42),Math.min(n.low-1,_3f)));
}
}
if(_3f>n.high){
if(n.next==null||n.next.low>_3f){
g.push(new nitobi.collections.Range(n.high+1,_3f));
}else{
g.push(new nitobi.collections.Range(n.high+1,n.next.low-1));
}
}
n=n.next;
}while(n!=null&&n.high<_3f);
}else{
g.push(new nitobi.collections.Range(this.tail.high+1,_3f));
}
return g;
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.CellSet=function(_43,_44,_45,_46,_47){
this.owner=_43;
if(_44!=null&&_45!=null&&_46!=null&&_47!=null){
this.setRange(_44,_45,_46,_47);
}else{
this.setRange(0,0,0,0);
}
};
nitobi.collections.CellSet.prototype.toString=function(){
var str="";
for(var i=this._topRow;i<=this._bottomRow;i++){
str+="[";
for(var j=this._leftColumn;j<=this._rightColumn;j++){
str+="("+i+","+j+")";
}
str+="]";
}
return str;
};
nitobi.collections.CellSet.prototype.setRange=function(_4b,_4c,_4d,_4e){
ntbAssert(_4b!=null&&_4c!=null&&_4d!=null&&_4e!=null,"nitobi.collections.CellSet.setRange requires startRow, startColumn, endRow, endColumn as integers",null,EBA_THROW);
this._startRow=_4b;
this._startColumn=_4c;
this._endRow=_4d;
this._endColumn=_4e;
this._leftColumn=Math.min(_4c,_4e);
this._rightColumn=Math.max(_4c,_4e);
this._topRow=Math.min(_4b,_4d);
this._bottomRow=Math.max(_4b,_4d);
};
nitobi.collections.CellSet.prototype.changeStartCell=function(_4f,_50){
this._startRow=_4f;
this._startColumn=_50;
this._leftColumn=Math.min(_50,this._endColumn);
this._rightColumn=Math.max(_50,this._endColumn);
this._topRow=Math.min(_4f,this._endRow);
this._bottomRow=Math.max(_4f,this._endRow);
};
nitobi.collections.CellSet.prototype.changeEndCell=function(_51,_52){
this._endRow=_51;
this._endColumn=_52;
this._leftColumn=Math.min(_52,this._startColumn);
this._rightColumn=Math.max(_52,this._startColumn);
this._topRow=Math.min(_51,this._startRow);
this._bottomRow=Math.max(_51,this._startRow);
};
nitobi.collections.CellSet.prototype.getRowCount=function(){
return this._bottomRow-this._topRow+1;
};
nitobi.collections.CellSet.prototype.getColumnCount=function(){
return this._rightColumn-this._leftColumn+1;
};
nitobi.collections.CellSet.prototype.getCoords=function(){
return {"top":new nitobi.drawing.Point(this._leftColumn,this._topRow),"bottom":new nitobi.drawing.Point(this._rightColumn,this._bottomRow)};
};
nitobi.collections.CellSet.prototype.getCellObjectByOffset=function(_53,_54){
return this.owner.getCellObject(this._topRow+_53,this._leftColumn+_54);
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.CacheNode=function(low,_56){
this.low=low;
this.high=_56;
this.next=null;
this.prev=null;
};
nitobi.collections.CacheNode.prototype.isIn=function(val){
return ((val>=this.low)&&(val<=this.high));
};
nitobi.collections.CacheNode.prototype.mergeNext=function(){
var _58=this.next;
if(_58!=null&&_58.low<=this.high+1){
this.high=Math.max(this.high,_58.high);
this.low=Math.min(this.low,_58.low);
var _59=_58.next;
this.next=_59;
if(_59!=null){
_59.prev=this;
}
_58.clear();
return true;
}else{
return false;
}
};
nitobi.collections.CacheNode.prototype.clear=function(){
this.next=null;
this.prev=null;
};
nitobi.collections.CacheNode.prototype.toString=function(){
return "["+this.low+","+this.high+"]";
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.Range=function(low,_5b){
this.low=low;
this.high=_5b;
};
nitobi.collections.Range.prototype.isIn=function(val){
return ((val>=this.low)&&(val<=this.high));
};
nitobi.collections.Range.prototype.toString=function(){
return "["+this.low+","+this.high+"]";
};
nitobi.lang.defineNs("nitobi.grid");
if(false){
nitobi.grid=function(){
};
}
nitobi.grid.PAGINGMODE_NONE="none";
nitobi.grid.PAGINGMODE_STANDARD="standard";
nitobi.grid.PAGINGMODE_LIVESCROLLING="livescrolling";
nitobi.grid.Grid=function(uid){
nitobi.prepare();
EBAAutoRender=false;
this.disposal=[];
this.uid=uid||nitobi.base.getUid();
this.modelNodes={};
this.cachedCells={};
this.configureDefaults();
if(nitobi.browser.IE6){
nitobi.html.addUnload(nitobi.lang.close(this,this.dispose));
}
this.subscribe("AttachToParent",this.initialize);
this.subscribe("DataReady",this.layout);
this.subscribe("AfterCellEdit",this.autoSave);
this.subscribe("AfterRowInsert",this.autoSave);
this.subscribe("AfterRowDelete",this.autoSave);
this.subscribe("AfterPaste",this.autoSave);
this.subscribe("AfterPaste",this.focus);
this.subscribeOnce("HtmlReady",this.adjustHorizontalScrollBars);
this.subscribe("AfterGridResize",this.adjustHorizontalScrollBars);
this.events=[];
this.scrollerEvents=[];
this.cellEvents=[];
this.headerEvents=[];
this.keyEvents=[];
};
nitobi.lang.implement(nitobi.grid.Grid,nitobi.Object);
var ntb_gridp=nitobi.grid.Grid.prototype;
nitobi.grid.Grid.prototype.properties={id:{n:"ID",t:"",d:"",p:"j"},selection:{n:"Selection",t:"",d:null,p:"j"},bound:{n:"Bound",t:"",d:false,p:"j"},registeredto:{n:"RegisteredTo",t:"",d:true,p:"j"},licensekey:{n:"LicenseKey",t:"",d:true,p:"j"},columns:{n:"Columns",t:"",d:true,p:"j"},columnsdefined:{n:"ColumnsDefined",t:"",d:false,p:"j"},declaration:{n:"Declaration",t:"",d:"",p:"j"},datasource:{n:"Datasource",t:"",d:true,p:"j"},keygenerator:{n:"KeyGenerator",t:"",d:"",p:"j"},version:{n:"Version",t:"",d:3.01,p:"j"},cellclicked:{n:"CellClicked",t:"",d:false,p:"j"},uid:{n:"uid",t:"s",d:"",p:"x"},datasourceid:{n:"DatasourceId",t:"s",d:"",p:"x"},currentpageindex:{n:"CurrentPageIndex",t:"i",d:0,p:"x"},columnindicatorsenabled:{n:"ColumnIndicatorsEnabled",t:"b",d:true,p:"x"},rowindicatorsenabled:{n:"RowIndicatorsEnabled",t:"b",d:false,p:"x"},toolbarenabled:{n:"ToolbarEnabled",t:"b",d:true,p:"x"},toolbarheight:{n:"ToolbarHeight",t:"i",d:25,p:"x"},rowhighlightenabled:{n:"RowHighlightEnabled",t:"b",d:false,p:"x"},rowselectenabled:{n:"RowSelectEnabled",t:"b",d:false,p:"x"},gridresizeenabled:{n:"GridResizeEnabled",t:"b",d:false,p:"x"},widthfixed:{n:"WidthFixed",t:"b",d:false,p:"x"},heightfixed:{n:"HeightFixed",t:"b",d:false,p:"x"},minwidth:{n:"MinWidth",t:"i",d:20,p:"x"},minheight:{n:"MinHeight",t:"i",d:0,p:"x"},singleclickeditenabled:{n:"SingleClickEditEnabled",t:"b",d:false,p:"x"},autokeyenabled:{n:"AutoKeyEnabled",t:"b",d:false,p:"x"},tooltipsenabled:{n:"ToolTipsEnabled",t:"b",d:false,p:"x"},entertab:{n:"EnterTab",t:"s",d:"down",p:"x"},hscrollbarenabled:{n:"HScrollbarEnabled",t:"b",d:true,p:"x"},vscrollbarenabled:{n:"VScrollbarEnabled",t:"b",d:true,p:"x"},rowheight:{n:"RowHeight",t:"i",d:23,p:"x"},headerheight:{n:"HeaderHeight",t:"i",d:23,p:"x"},top:{n:"top",t:"i",d:0,p:"x"},left:{n:"left",t:"i",d:0,p:"x"},scrollbarwidth:{n:"scrollbarWidth",t:"i",d:22,p:"x"},scrollbarheight:{n:"scrollbarHeight",t:"i",d:22,p:"x"},freezetop:{n:"freezetop",t:"i",d:0,p:"x"},frozenleftcolumncount:{n:"FrozenLeftColumnCount",t:"i",d:0,p:"x"},rowinsertenabled:{n:"RowInsertEnabled",t:"b",d:true,p:"x"},rowdeleteenabled:{n:"RowDeleteEnabled",t:"b",d:true,p:"x"},asynchronous:{n:"Asynchronous",t:"b",d:true,p:"x"},autosaveenabled:{n:"AutoSaveEnabled",t:"b",d:false,p:"x"},columncount:{n:"ColumnCount",t:"i",d:0,p:"x"},rowsperpage:{n:"RowsPerPage",t:"i",d:20,p:"x"},forcevalidate:{n:"ForceValidate",t:"b",d:false,p:"x"},height:{n:"Height",t:"i",d:100,p:"x"},lasterror:{n:"LastError",t:"s",d:"",p:"x"},multirowselectenabled:{n:"MultiRowSelectEnabled",t:"b",d:false,p:"x"},multirowselectfield:{n:"MultiRowSelectField",t:"s",d:"",p:"x"},multirowselectattr:{n:"MultiRowSelectAttr",t:"s",d:"",p:"x"},gethandler:{n:"GetHandler",t:"s",d:"",p:"x"},savehandler:{n:"SaveHandler",t:"s",d:"",p:"x"},width:{n:"Width",t:"i",d:"",p:"x"},pagingmode:{n:"PagingMode",t:"s",d:"LiveScrolling",p:"x"},datamode:{n:"DataMode",t:"s",d:"Caching",p:"x"},rendermode:{n:"RenderMode",t:"s",d:"",p:"x"},copyenabled:{n:"CopyEnabled",t:"b",d:true,p:"x"},pasteenabled:{n:"PasteEnabled",t:"b",d:true,p:"x"},sortenabled:{n:"SortEnabled",t:"b",d:true,p:"x"},sortmode:{n:"SortMode",t:"s",d:"default",p:"x"},editmode:{n:"EditMode",t:"b",d:false,p:"x"},expanding:{n:"Expanding",t:"b",d:false,p:"x"},theme:{n:"Theme",t:"s",d:"nitobi",p:"x"},cellborder:{n:"CellBorder",t:"i",d:0,p:"x"},cellborderheight:{n:"CellBorderHeight",t:"i",d:0,p:"x"},innercellborder:{n:"InnerCellBorder",t:"i",d:0,p:"x"},dragfillenabled:{n:"DragFillEnabled",t:"b",d:true,p:"x"},oncellclickevent:{n:"OnCellClickEvent",t:"",p:"e"},onbeforecellclickevent:{n:"OnBeforeCellClickEvent",t:"",p:"e"},oncelldblclickevent:{n:"OnCellDblClickEvent",t:"",p:"e"},ondatareadyevent:{n:"OnDataReadyEvent",t:"",p:"e"},onhtmlreadyevent:{n:"OnHtmlReadyEvent",t:"",p:"e"},ondatarenderedevent:{n:"OnDataRenderedEvent",t:"",p:"e"},oncelldoubleclickevent:{n:"OnCellDoubleClickEvent",t:"",p:"e"},onafterloaddatapageevent:{n:"OnAfterLoadDataPageEvent",t:"",p:"e"},onbeforeloaddatapageevent:{n:"OnBeforeLoadDataPageEvent",t:"",p:"e"},onafterloadpreviouspageevent:{n:"OnAfterLoadPreviousPageEvent",t:"",p:"e"},onbeforeloadpreviouspageevent:{n:"OnBeforeLoadPreviousPageEvent",t:"",p:"e"},onafterloadnextpageevent:{n:"OnAfterLoadNextPageEvent",t:"",p:"e"},onbeforeloadnextpageevent:{n:"OnBeforeLoadNextPageEvent",t:"",p:"e"},onbeforecelleditevent:{n:"OnBeforeCellEditEvent",t:"",p:"e"},onaftercelleditevent:{n:"OnAfterCellEditEvent",t:"",p:"e"},onbeforerowinsertevent:{n:"OnBeforeRowInsertEvent",t:"",p:"e"},onafterrowinsertevent:{n:"OnAfterRowInsertEvent",t:"",p:"e"},onbeforesortevent:{n:"OnBeforeSortEvent",t:"",p:"e"},onaftersortevent:{n:"OnAfterSortEvent",t:"",p:"e"},onbeforerefreshevent:{n:"OnBeforeRefreshEvent",t:"",p:"e"},onafterrefreshevent:{n:"OnAfterRefreshEvent",t:"",p:"e"},onbeforesaveevent:{n:"OnBeforeSaveEvent",t:"",p:"e"},onaftersaveevent:{n:"OnAfterSaveEvent",t:"",p:"e"},onhandlererrorevent:{n:"OnHandlerErrorEvent",t:"",p:"e"},onrowblurevent:{n:"OnRowBlurEvent",t:"",p:"e"},oncellfocusevent:{n:"OnCellFocusEvent",t:"",p:"e"},onfocusevent:{n:"OnFocusEvent",t:"",p:"e"},oncellblurevent:{n:"OnCellBlurEvent",t:"",p:"e"},onafterrowdeleteevent:{n:"OnAfterRowDeleteEvent",t:"",p:"e"},onbeforerowdeleteevent:{n:"OnBeforeRowDeleteEvent",t:"",p:"e"},oncellupdateevent:{n:"OnCellUpdateEvent",t:"",p:"e"},onrowfocusevent:{n:"OnRowFocusEvent",t:"",p:"e"},onbeforecopyevent:{n:"OnBeforeCopyEvent",t:"",p:"e"},onaftercopyevent:{n:"OnAfterCopyEvent",t:"",p:"e"},onbeforepasteevent:{n:"OnBeforePasteEvent",t:"",p:"e"},onafterpasteevent:{n:"OnAfterPasteEvent",t:"",p:"e"},onerrorevent:{n:"OnErrorEvent",t:"",p:"e"},oncontextmenuevent:{n:"OnContextMenuEvent",t:"",p:"e"},oncellvalidateevent:{n:"OnCellValidateEvent",t:"",p:"e"},onkeydownevent:{n:"OnKeyDownEvent",t:"",p:"e"},onkeyupevent:{n:"OnKeyUpEvent",t:"",p:"e"},onkeypressevent:{n:"OnKeyPressEvent",t:"",p:"e"},onmouseoverevent:{n:"OnMouseOverEvent",t:"",p:"e"},onmouseoutevent:{n:"OnMouseOutEvent",t:"",p:"e"},onmousemoveevent:{n:"OnMouseMoveEvent",t:"",p:"e"},onhitrowendevent:{n:"OnHitRowEndEvent",t:"",p:"e"},onhitrowstartevent:{n:"OnHitRowStartEvent",t:"",p:"e"},onafterdragfillevent:{n:"OnAfterDragFillEvent",t:"",p:"e"},onbeforedragfillevent:{n:"OnBeforeDragFillEvent",t:"",p:"e"},onafterresizeevent:{n:"OnAfterResizeEvent",t:"",p:"e"},onbeforeresizeevent:{n:"OnBeforeResizeEvent",t:"",p:"e"}};
nitobi.grid.Grid.prototype.xColumnProperties={column:{align:{n:"Align",t:"s",d:"left"},classname:{n:"ClassName",t:"s",d:""},cssstyle:{n:"CssStyle",t:"s",d:""},columnname:{n:"ColumnName",t:"s",d:""},type:{n:"Type",t:"s",d:"text"},datatype:{n:"DataType",t:"s",d:"text"},editable:{n:"Editable",t:"b",d:true},initial:{n:"Initial",t:"s",d:""},label:{n:"Label",t:"s",d:""},gethandler:{n:"GetHandler",t:"s",d:""},datasource:{n:"DataSource",t:"s",d:""},template:{n:"Template",t:"s",d:""},templateurl:{n:"TemplateUrl",t:"s",d:""},maxlength:{n:"MaxLength",t:"i",d:255},sortdirection:{n:"SortDirection",t:"s",d:"Desc"},sortenabled:{n:"SortEnabled",t:"b",d:true},width:{n:"Width",t:"i",d:100},visible:{n:"Visible",t:"b",d:true},xdatafld:{n:"xdatafld",t:"s",d:""},value:{n:"Value",t:"s",d:""},xi:{n:"xi",t:"i",d:100},oncellclickevent:{n:"OnCellClickEvent"},onbeforecellclickevent:{n:"OnBeforeCellClickEvent"},oncelldblclickevent:{n:"OnCellDblClickEvent"},onheaderdoubleclickevent:{n:"OnHeaderDoubleClickEvent"},onheaderclickevent:{n:"OnHeaderClickEvent"},onbeforeresizeevent:{n:"OnBeforeResizeEvent"},onafterresizeevent:{n:"OnAfterResizeEvent"},oncellvalidateevent:{n:"OnCellValidateEvent"},onbeforecelleditevent:{n:"OnBeforeCellEditEvent"},onaftercelleditevent:{n:"OnAfterCellEditEvent"},oncellblurevent:{n:"OnCellBlurEvent"},oncellfocusevent:{n:"OnCellFocusEvent"},onbeforesortevent:{n:"OnBeforeSortEvent"},onaftersortevent:{n:"OnAfterSortEvent"},oncellupdateevent:{n:"OnCellUpdateEvent"},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},textcolumn:{},numbercolumn:{align:{n:"Align",t:"s",d:"right"},mask:{n:"Mask",t:"s",d:"#,###.00"},negativemask:{n:"NegativeMask",t:"s",d:""},groupingseparator:{n:"GroupingSeparator",t:"s",d:","},decimalseparator:{n:"DecimalSeparator",t:"s",d:"."},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},datecolumn:{mask:{n:"Mask",t:"s",d:"M/d/yyyy"},calendarenabled:{n:"CalendarEnabled",t:"b",d:true}},listboxeditor:{datasourceid:{n:"DatasourceId",t:"s",d:""},datasource:{n:"Datasource",t:"s",d:""},gethandler:{n:"GetHandler",t:"s",d:""},displayfields:{n:"DisplayFields",t:"s",d:""},valuefield:{n:"ValueField",t:"s",d:""},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},lookupeditor:{datasourceid:{n:"DatasourceId",t:"s",d:""},datasource:{n:"Datasource",t:"s",d:""},gethandler:{n:"GetHandler",t:"s",d:""},displayfields:{n:"DisplayFields",t:"s",d:""},valuefield:{n:"ValueField",t:"s",d:""},delay:{n:"Delay",t:"s",d:""},size:{n:"Size",t:"s",d:6},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"},forcevalidoption:{n:"ForceValidOption",t:"b",d:false},autocomplete:{n:"AutoComplete",t:"b",d:true},autoclear:{n:"AutoClear",t:"b",d:false},getonenter:{n:"GetOnEnter",t:"b",d:false},referencecolumn:{n:"ReferenceColumn",t:"s",d:""}},checkboxeditor:{datasourceid:{n:"DatasourceId",t:"s",d:""},datasource:{n:"Datasource",t:"s",d:""},gethandler:{n:"GetHandler",t:"s",d:""},displayfields:{n:"DisplayFields",t:"s",d:""},valuefield:{n:"ValueField",t:"s",d:""},checkedvalue:{n:"CheckedValue",t:"s",d:""},uncheckedvalue:{n:"UnCheckedValue",t:"s",d:""}},linkeditor:{openwindow:{n:"OpenWindow",t:"b",d:true}},texteditor:{maxlength:{n:"MaxLength",t:"i",d:255},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},numbereditor:{onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},textareaeditor:{maxlength:{n:"MaxLength",t:"i",d:255},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},dateeditor:{mask:{n:"Mask",t:"s",d:"M/d/yyyy"},calendarenabled:{n:"CalendarEnabled",t:"b",d:true},onkeydownevent:{n:"OnKeyDownEvent"},onkeyupevent:{n:"OnKeyUpEvent"},onkeypressevent:{n:"OnKeyPressEvent"},onchangeevent:{n:"OnChangeEvent"}},imageeditor:{imageurl:{n:"ImageUrl",t:"s",d:""}},passwordeditor:{}};
nitobi.grid.Grid.prototype.typeAccessorCreators={s:function(){
},b:function(){
},i:function(){
},n:function(){
}};
nitobi.grid.Grid.prototype.createAccessors=function(_5e){
var _5f=nitobi.grid.Grid.prototype.properties[_5e];
nitobi.grid.Grid.prototype["set"+_5f.n]=function(){
this[_5f.p+_5f.t+"SET"](_5f.n,arguments);
};
nitobi.grid.Grid.prototype["get"+_5f.n]=function(){
return this[_5f.p+_5f.t+"GET"](_5f.n,arguments);
};
nitobi.grid.Grid.prototype["is"+_5f.n]=function(){
return this[_5f.p+_5f.t+"GET"](_5f.n,arguments);
};
nitobi.grid.Grid.prototype[_5f.n]=_5f.d;
};
for(var name in nitobi.grid.Grid.prototype.properties){
nitobi.grid.Grid.prototype.createAccessors(name);
}
nitobi.grid.Grid.prototype.initialize=function(){
this.fire("Preinitialize");
this.initializeFromCss();
this.createChildren();
this.fire("AfterInitialize");
this.fire("CreationComplete");
};
nitobi.grid.Grid.prototype.initializeFromCss=function(){
this.CellHoverColor=this.getThemedStyle("ntb-cell-hover","backgroundColor")||"#C0C0FF";
this.RowHoverColor=this.getThemedStyle("ntb-row-hover","backgroundColor")||"#FFFFC0";
this.CellActiveColor=this.getThemedStyle("ntb-cell-active","backgroundColor")||"#F0C0FF";
this.RowActiveColor=this.getThemedStyle("ntb-row-active","backgroundColor")||"#FFC0FF";
var _60=this.getThemedStyle("ntb-row","height");
if(_60!=null&&_60!=""){
this.setRowHeight(parseInt(_60));
}
var _61=this.getThemedStyle("ntb-grid-header","height");
if(_61!=null&&_61!=""){
this.setHeaderHeight(parseInt(_61));
}
if(nitobi.browser.IE&&nitobi.lang.isStandards()){
var _62=this.getThemedClass("ntb-cell-border");
if(_62!=null){
this.setCellBorder(parseInt(_62.borderLeftWidth+0)+parseInt(_62.borderRightWidth+0)+parseInt(_62.paddingLeft+0)+parseInt(_62.paddingRight+0));
}
}
var _62=this.getThemedClass("ntb-cell-border");
if(_62!=null){
this.setCellBorder(parseInt(_62.borderTopWidth+0)+parseInt(_62.borderBottomWidth+0)+parseInt(_62.paddingTop+0)+parseInt(_62.paddingBottom+0));
}
if(nitobi.browser.MOZ){
var _62=this.getThemedClass("ntb-cell");
if(_62!=null){
this.setInnerCellBorder(parseInt(_62.borderLeftWidth+0)+parseInt(_62.borderRightWidth+0)+parseInt(_62.paddingLeft+0)+parseInt(_62.paddingRight+0));
}
}
};
nitobi.grid.Grid.prototype.getThemedClass=function(_63){
var C=nitobi.html.Css;
var r=C.getRule("."+this.getTheme()+" ."+_63)||C.getRule("."+_63);
var ret=null;
if(r!=null&&r.style!=null){
ret=r.style;
}
return ret;
};
nitobi.grid.Grid.prototype.getThemedStyle=function(_67,_68){
return nitobi.html.Css.getClassStyle("."+this.getTheme()+" ."+_67,_68);
};
nitobi.grid.Grid.prototype.connectRenderersToDataSet=function(_69){
this.TopLeftRenderer.xmlDataSource=_69;
this.TopCenterRenderer.xmlDataSource=_69;
this.MidLeftRenderer.xmlDataSource=_69;
this.MidCenterRenderer.xmlDataSource=_69;
};
nitobi.grid.Grid.prototype.connectToDataSet=function(_6a,_6b){
this.data=_6a;
if(this.TopLeftRenderer){
this.connectRenderersToDataSet(_6a);
}
this.connectToTable(_6b);
};
nitobi.grid.Grid.prototype.connectToTable=function(_6c){
if(typeof (_6c)=="string"){
this.datatable=this.data.getTable(_6c);
}else{
if(typeof (_6c)=="object"){
this.datatable=_6c;
}else{
if(this.data.getTable("_default")+""!="undefined"){
this.datatable=this.data.getTable("_default");
}else{
return false;
}
}
}
this.connected=true;
this.updateStructure();
var dt=this.datatable;
var L=nitobi.lang;
dt.subscribe("DataReady",L.close(this,this.handleHandlerError));
dt.subscribe("DataReady",L.close(this,this.syncWithData));
dt.subscribe("DataSorted",L.close(this,this.syncWithData));
dt.subscribe("RowInserted",L.close(this,this.syncWithData));
dt.subscribe("RowDeleted",L.close(this,this.syncWithData));
dt.subscribe("RowCountChanged",L.close(this,this.setRowCount));
dt.subscribe("PastEndOfData",L.close(this,this.adjustRowCount));
dt.subscribe("RowCountKnown",L.close(this,this.finalizeRowCount));
dt.subscribe("StructureChanged",L.close(this,this.updateStructure));
dt.subscribe("ColumnsInitialized",L.close(this,this.updateStructure));
this.dataTableId=this.datatable.id;
this.datatable.setOnGenerateKey(this.getKeyGenerator());
this.fire("TableConnected",this.datatable);
return true;
};
nitobi.grid.Grid.prototype.ensureConnected=function(){
if(this.data==null){
this.data=new nitobi.data.DataSet();
this.data.initialize();
this.datatable=new nitobi.data.DataTable(this.getDataMode(),this.getPagingMode()==nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()},this.isAutoKeyEnabled());
this.datatable.initialize("_default",this.getGetHandler(),this.getSaveHandler());
this.data.add(this.datatable);
this.connectToDataSet(this.data);
}
if(this.datatable==null){
this.datatable=this.data.getTable("_default");
if(this.datatable==null){
this.datatable=new nitobi.data.DataTable(this.getDataMode(),this.getPagingMode()==nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()},this.isAutoKeyEnabled());
this.datatable.initialize("_default",this.getGetHandler(),this.getSaveHandler());
this.data.add(this.datatable);
}
this.connectToDataSet(this.data);
}
this.connected=true;
};
nitobi.grid.Grid.prototype.updateStructure=function(){
if(this.inferredColumns){
this.defineColumns(this.datatable);
}
this.mapColumns();
if(this.TopLeftRenderer){
this.defineColumnBindings();
this.defineColumnsFinalize();
}
};
nitobi.grid.Grid.prototype.mapColumns=function(){
this.fieldMap=this.datatable.fieldMap;
};
nitobi.grid.Grid.prototype.configureDefaults=function(){
this.initializeModel();
this.displayedFirstRow=0;
this.displayedRowCount=0;
this.localFilter=null;
this.columns=[];
this.fieldMap={};
this.frameRendered=false;
this.connected=false;
this.inferredColumns=true;
this.selectedRows=[];
this.minHeight=20;
this.minWidth=20;
this.setRowCount(0);
this.layoutValid=false;
this.oldVersion=false;
this.frameCssXslProc=nitobi.grid.frameCssXslProc;
this.frameXslProc=nitobi.grid.frameXslProc;
};
nitobi.grid.Grid.prototype.attachDomEvents=function(){
ntbAssert(this.UiContainer!=null&&nitobi.html.getFirstChild(this.UiContainer)!=null,"The Grid has not been attached to the DOM yet using attachToDom method. Therefore, attachDomEvents cannot proceed.",null,EBA_THROW);
var _6f=this.getGridContainer();
var he=this.headerEvents;
he.push({type:"mousedown",handler:this.handleHeaderMouseDown});
he.push({type:"mouseup",handler:this.handleHeaderMouseUp});
he.push({type:"mousemove",handler:this.handleHeaderMouseMove});
nitobi.html.attachEvents(this.getHeaderContainer(),he,this);
var ce=this.cellEvents;
ce.push({type:"mousedown",handler:this.handleCellMouseDown});
ce.push({type:"mousemove",handler:this.handleCellMouseMove});
nitobi.html.attachEvents(this.getDataContainer(),ce,this);
var ge=this.events;
ge.push({type:"contextmenu",handler:this.handleContextMenu});
ge.push({type:"mousedown",handler:this.handleMouseDown});
ge.push({type:"mouseup",handler:this.handleMouseUp});
ge.push({type:"mousemove",handler:this.handleMouseMove});
ge.push({type:"mouseout",handler:this.handleMouseOut});
ge.push({type:"mouseover",handler:this.handleMouseOver});
if(!nitobi.browser.MOZ){
ge.push({type:"mousewheel",handler:this.handleMouseWheel});
}else{
nitobi.html.attachEvent($ntb("vscrollclip"+this.uid),"mousedown",this.focus,this);
nitobi.html.attachEvent($ntb("hscrollclip"+this.uid),"mousedown",this.focus,this);
ge.push({type:"DOMMouseScroll",handler:this.handleMouseWheel});
}
nitobi.html.attachEvents(_6f,ge,this,false);
if(nitobi.browser.IE){
_6f.onselectstart=function(){
var id=window.event.srcElement.id;
if(id.indexOf("selectbox")==0||id.indexOf("cell")==0){
return false;
}
};
}
if(nitobi.browser.IE){
this.keyNav=this.getScrollerContainer();
}else{
this.keyNav=$ntb("ntb-grid-keynav"+this.uid);
}
this.keyEvents=[{type:"keydown",handler:this.handleKey},{type:"keyup",handler:this.handleKeyUp},{type:"keypress",handler:this.handleKeyPress}];
nitobi.html.attachEvents(this.keyNav,this.keyEvents,this);
var _74=$ntb("ntb-grid-resizeright"+this.uid);
var _75=$ntb("ntb-grid-resizebottom"+this.uid);
if(_74!=null){
nitobi.html.attachEvent(_74,"mousedown",this.beforeResize,this);
nitobi.html.attachEvent(_75,"mousedown",this.beforeResize,this);
}
};
nitobi.grid.Grid.prototype.hoverCell=function(_76){
var h=this.hovered;
if(h){
var hs=h.style;
if(hs.backgroundColor==this.CellHoverColor){
hs.backgroundColor=this.hoveredbg;
}
}
if(_76==null||_76==this.activeCell){
return;
}
var cs=_76.style;
this.hoveredbg=cs.backgroundColor;
this.hovered=_76;
cs.backgroundColor=this.CellHoverColor;
};
nitobi.grid.Grid.prototype.hoverRow=function(row){
if(!this.isRowHighlightEnabled()){
return;
}
var C=nitobi.html.Css;
if(this.leftrowhovered&&this.leftrowhovered!=this.leftActiveRow){
this.leftrowhovered.style.backgroundColor=this.leftrowhoveredbg;
}
if(this.midrowhovered&&this.midrowhovered!=this.midActiveRow){
this.midrowhovered.style.backgroundColor=this.midrowhoveredbg;
}
if(row==this.activeRow||row==null){
return;
}
var _7c=-1;
var _7d=nitobi.html.getFirstChild(row);
var _7e=nitobi.grid.Row.getRowNumber(row);
var _7f=nitobi.grid.Row.getRowElements(this,_7e);
if(_7f.left!=null&&_7f.left!=this.leftActiveRow){
this.leftrowhoveredbg=_7f.left.style.backgroundColor;
this.leftrowhovered=_7f.left;
_7f.left.style.backgroundColor=this.RowHoverColor;
}
if(_7f.mid!=null&&_7f.mid!=this.midActiveRow){
this.midrowhoveredbg=_7f.mid.style.backgroundColor;
this.midrowhovered=_7f.mid;
_7f.mid.style.backgroundColor=this.RowHoverColor;
}
};
nitobi.grid.Grid.prototype.clearHover=function(){
this.hoverCell();
this.hoverRow();
};
nitobi.grid.Grid.prototype.handleMouseOver=function(evt){
this.fire("MouseOver",evt);
};
nitobi.grid.Grid.prototype.handleMouseOut=function(evt){
this.clearHover();
this.fire("MouseOut",evt);
};
nitobi.grid.Grid.prototype.handleMouseDown=function(evt){
};
nitobi.grid.Grid.prototype.handleHeaderMouseDown=function(evt){
var _84=this.findActiveCell(evt.srcElement);
if(_84==null){
return;
}
var _85=nitobi.grid.Cell.getColumnNumber(_84);
if(this.headerResizeHover(evt,_84)){
var col=this.getColumnObject(_85);
var _87=new nitobi.grid.OnBeforeColumnResizeEventArgs(this,col);
if(!nitobi.event.evaluate(col.getOnBeforeResizeEvent(),_87)){
return;
}
this.columnResizer.startResize(this,_85,_84,evt);
return false;
}else{
this.headerClicked(_85);
this.fire("HeaderDown",_85);
}
};
nitobi.grid.Grid.prototype.handleCellMouseDown=function(evt){
var _89=this.findActiveCell(evt.srcElement)||this.activeCell;
if(_89==null){
return;
}
if(!evt.shiftKey){
var _8a=this.getSelectedColumnObject();
var _8b=new nitobi.grid.OnCellClickEventArgs(this,this.getSelectedCellObject());
if(!this.fire("BeforeCellClick",_8b)||(!!_8a&&!nitobi.event.evaluate(_8a.getOnBeforeCellClickEvent(),_8b))){
return;
}
if(nitobi.browser.IE){
this.waitt=true;
}
this.setCellClicked(true);
this.setActiveCell(_89,evt.ctrlKey||evt.metaKey);
if(this.waitt==true){
this.selection.selecting=true;
}
var _8a=this.getSelectedColumnObject();
var _8b=new nitobi.grid.OnCellClickEventArgs(this,this.getSelectedCellObject());
this.fire("CellClick",_8b);
if(!!_8a){
nitobi.event.evaluate(_8a.getOnCellClickEvent(),_8b);
}
}
};
nitobi.grid.Grid.prototype.handleMouseUp=function(_8c){
if(this.selection.selected()){
this.getSelection().handleSelectionMouseUp(_8c);
}
};
nitobi.grid.Grid.prototype.handleHeaderMouseUp=function(evt){
var _8e=this.findActiveCell(evt.srcElement);
if(!_8e){
this.focus();
return;
}
var _8f=parseInt(_8e.getAttribute("xi"));
this.fire("HeaderUp",_8f);
};
nitobi.grid.Grid.prototype.handleMouseMove=function(evt){
this.fire("MouseMove",evt);
};
nitobi.grid.Grid.prototype.handleHeaderMouseMove=function(evt){
var _92=this.findActiveCell(evt.srcElement);
if(_92==null){
return;
}
if(this.headerResizeHover(evt,_92)){
_92.style.cursor="w-resize";
}else{
(nitobi.browser.IE?_92.style.cursor="hand":_92.style.cursor="pointer");
}
};
nitobi.grid.Grid.prototype.headerResizeHover=function(evt,_94){
var x=evt.clientX;
var _96=nitobi.html.getBoundingClientRect(_94,0,(nitobi.grid.Cell.getColumnNumber(_94)>this.getFrozenLeftColumnCount()?this.scroller.getScrollLeft():0));
return (x<_96.right&&x>_96.right-10);
};
nitobi.grid.Grid.prototype.handleHeaderMouseOver=function(e){
e.className=e.className.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(){
return arguments[1]+arguments[2]+"hover ";
});
};
nitobi.grid.Grid.prototype.handleHeaderMouseOut=function(e){
e.className=e.className.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(){
return arguments[0].replace("hover","");
});
};
nitobi.grid.Grid.prototype.handleCellMouseMove=function(evt){
this.setCellClicked(false);
var _9a=this.findActiveCell(evt.srcElement);
if(_9a==null){
return;
}
var sel=this.selection;
if(sel.selecting){
var _9c=evt.button;
var _9d=nitobi.html.getEventCoords(evt);
var x=_9d.x,y=_9d.y;
if(nitobi.browser.IE){
x=evt.clientX,y=evt.clientY;
}
if(_9c==1||(_9c==0&&!nitobi.browser.IE)){
if(!sel.expanding){
sel.redraw(_9a);
}else{
var _a0=sel.expandStartCoords;
var _a1=0;
if(x>_a0.right){
_a1=Math.abs(x-_a0.right);
}else{
if(x<_a0.left){
_a1=Math.abs(x-_a0.left);
}
}
var _a2=0;
if(y>_a0.bottom){
_a2=Math.abs(y-_a0.bottom);
}else{
if(y<_a0.top){
_a2=Math.abs(y-_a0.top);
}
}
if(_a2>_a1){
expandDir="vert";
}else{
expandDir="horiz";
}
sel.expand(_9a,expandDir);
}
this.ensureCellInView(_9a);
}else{
this.selection.selecting=false;
}
}else{
this.hoverCell(_9a);
this.hoverRow(_9a.parentNode);
}
};
nitobi.grid.Grid.prototype.handleMouseWheel=function(_a3){
this.focus();
var _a4=0;
if(_a3.wheelDelta){
_a4=_a3.wheelDelta/120;
}else{
if(_a3.detail){
_a4=-_a3.detail/3;
}
}
this.scrollVerticalRelative(-20*_a4);
nitobi.html.cancelEvent(_a3);
};
nitobi.grid.Grid.prototype.setActiveCell=function(_a5,_a6){
if(!_a5){
return;
}
this.blurActiveCell(this.activeCell);
this.focus();
this.activateCell(_a5);
var _a7=this.activeColumnObject;
this.selection.collapse(this.activeCell);
if(!this.isCellClicked()){
this.ensureCellInView(this.activeCell);
this.setCellClicked(false);
}
var row=_a5.parentNode;
this.setActiveRow(row,_a6);
var _a9=new nitobi.grid.OnCellFocusEventArgs(this,this.getSelectedCellObject());
this.fire("CellFocus",_a9);
if(!!_a7){
nitobi.event.evaluate(_a7.getOnCellFocusEvent(),_a9);
}
};
nitobi.grid.Grid.prototype.activateCell=function(_aa){
this.activeCell=_aa;
this.activeCellObject=new nitobi.grid.Cell(this,_aa);
this.activeColumnObject=this.getSelectedColumnObject();
};
nitobi.grid.Grid.prototype.blurActiveCell=function(_ab){
this.oldCell=_ab;
var _ac=this.activeColumnObject;
var _ad=new nitobi.grid.OnCellBlurEventArgs(this,this.getSelectedCellObject());
if(!!_ac){
if(!this.fire("CellBlur",_ad)||!nitobi.event.evaluate(_ac.getOnCellBlurEvent(),_ad)){
return;
}
}
};
nitobi.grid.Grid.prototype.getRowNodes=function(row){
return nitobi.grid.Row.getRowElements(this,nitobi.grid.Row.getRowNumber(row));
};
nitobi.grid.Grid.prototype.setActiveRow=function(row,_b0){
var Row=nitobi.grid.Row;
var _b2=Row.getRowNumber(row);
var _b3=-1;
if(this.oldCell!=null){
_b3=Row.getRowNumber(this.oldCell);
}
if(this.selectedRows[0]!=null){
_b3=Row.getRowNumber(this.selectedRows[0]);
}
if(!_b0||!this.isMultiRowSelectEnabled()){
if(_b2!=_b3&&_b3!=-1){
var _b4=new nitobi.grid.OnRowBlurEventArgs(this,this.getRowObject(_b3));
if(!this.fire("RowBlur",_b4)||!nitobi.event.evaluate(this.getOnRowBlurEvent(),_b4)){
return;
}
}
this.clearActiveRows();
}
if(this.isRowSelectEnabled()){
var _b5=Row.getRowElements(this,_b2);
this.midActiveRow=_b5.mid;
this.leftActiveRow=_b5.left;
if(row.getAttribute("select")=="1"){
this.clearActiveRow(row);
for(var i=0;i<this.selectedRows.length;i++){
if(this.selectedRows[i]==row){
this.selectedRows.splice(i,1);
break;
}
}
}else{
this.selectedRows.push(row);
if(this.leftActiveRow!=null){
this.leftActiveRow.setAttribute("select","1");
this.applyRowStyle(this.leftActiveRow);
}
if(this.midActiveRow!=null){
this.midActiveRow.setAttribute("select","1");
this.applyRowStyle(this.midActiveRow);
}
}
}
if(_b2!=_b3){
var _b7=new nitobi.grid.OnRowFocusEventArgs(this,this.getRowObject(_b2));
this.fire("RowFocus",_b7);
nitobi.event.evaluate(this.getOnRowFocusEvent(),_b7);
}
};
nitobi.grid.Grid.prototype.getSelectedRows=function(){
return this.selectedRows;
};
nitobi.grid.Grid.prototype.clearActiveRows=function(){
for(var i=0;i<this.selectedRows.length;i++){
var row=this.selectedRows[i];
this.clearActiveRow(row);
}
this.selectedRows=[];
};
nitobi.grid.Grid.prototype.selectAllRows=function(){
this.clearActiveRows();
for(var i=0;i<this.getDisplayedRowCount();i++){
var _bb=this.getCellElement(i,0);
if(_bb!=null){
var row=_bb.parentNode;
this.setActiveRow(row,true);
}
}
return this.selectedRows;
};
nitobi.grid.Grid.prototype.clearActiveRow=function(row){
var _be=nitobi.grid.Row.getRowNumber(row);
var _bf=nitobi.grid.Row.getRowElements(this,_be);
if(_bf.left!=null){
_bf.left.removeAttribute("select");
this.removeRowStyle(_bf.left);
}
if(_bf.mid!=null){
_bf.mid.removeAttribute("select");
this.removeRowStyle(_bf.mid);
}
};
nitobi.grid.Grid.prototype.applyCellStyle=function(_c0){
if(_c0==null){
return;
}
_c0.style.background=this.CellActiveColor;
};
nitobi.grid.Grid.prototype.removeCellStyle=function(_c1){
if(_c1==null){
return;
}
_c1.style.background="";
};
nitobi.grid.Grid.prototype.applyRowStyle=function(row){
if(row==null){
return;
}
row.style.background=this.RowActiveColor;
};
nitobi.grid.Grid.prototype.removeRowStyle=function(row){
if(row==null){
return;
}
row.style.background="";
};
nitobi.grid.Grid.prototype.findActiveCell=function(_c4){
var _c5=5;
_c4==null;
for(var i=0;i<_c5&&_c4.getAttribute;i++){
var t=_c4.getAttribute("ebatype");
if(t=="cell"||t=="columnheader"){
return _c4;
}
_c4=_c4.parentNode;
}
return null;
};
nitobi.grid.Grid.prototype.attachToParentDomElement=function(_c8){
this.UiContainer=_c8;
this.fire("AttachToParent");
};
nitobi.grid.Grid.prototype.getToolbars=function(){
return this.toolbars;
};
nitobi.grid.Grid.prototype.adjustHorizontalScrollBars=function(){
var _c9=this.calculateWidth();
var _ca=$ntb("ntb-grid-hscrollshow"+this.uid);
var C=nitobi.html.Css;
var _cc=parseInt(C.getStyle(this.getScrollSurface(),"width"));
if((_c9<=_cc)){
_ca.style.display="none";
}else{
_ca.style.display="block";
this.resizeScroller();
var _cd=_cc/_c9;
this.hScrollbar.setRange(_cd);
}
};
nitobi.grid.Grid.prototype.createChildren=function(){
var L=nitobi.lang;
ntbAssert((this.UiContainer!=null),"Grid must have a UI Container");
if(this.UiContainer!=null&&this.getGridContainer()==null){
this.renderFrame();
}
this.generateFrameCss();
var ls=this.loadingScreen=new nitobi.grid.LoadingScreen(this);
this.subscribe("Preinitialize",L.close(ls,ls.show));
this.subscribe("HtmlReady",L.close(ls,ls.hide));
this.subscribe("AfterGridResize",L.close(ls,ls.resize));
ls.initialize();
if(nitobi.browser.IE7&&nitobi.lang.isStandards()){
ls.attachToElement($ntb("grid"+this.uid));
}else{
ls.attachToElement($ntb("ntb-grid-overlay"+this.uid));
}
ls.show();
var cr=new nitobi.grid.ColumnResizer(this);
cr.onAfterResize.subscribe(L.close(this,this.afterColumnResize));
this.columnResizer=cr;
var gr=new nitobi.grid.GridResizer(this);
gr.widthFixed=this.isWidthFixed();
gr.heightFixed=this.isHeightFixed();
gr.minWidth=this.getMinWidth();
gr.minHeight=Math.max(this.getMinHeight(),(this.getHeaderHeight()+this.getscrollbarHeight()));
gr.onAfterResize.subscribe(L.close(this,this.afterResize));
this.gridResizer=gr;
var sc=this.Scroller=this.scroller=new nitobi.grid.Scroller3x3(this,this.getHeight(),this.getDisplayedRowCount(),this.getColumnCount(),this.getfreezetop(),this.getFrozenLeftColumnCount());
sc.setRowHeight(this.getRowHeight());
sc.setHeaderHeight(this.getHeaderHeight());
sc.onHtmlReady.subscribe(this.handleHtmlReady,this);
this.subscribe("TableConnected",L.close(sc,sc.setDataTable));
sc.setDataTable(this.datatable);
this.initializeSelection();
this.createRenderers();
var sv=this.Scroller.view;
sv.midleft.rowRenderer=this.MidLeftRenderer;
sv.midcenter.rowRenderer=this.MidCenterRenderer;
sv.topleft.rowRenderer=this.TopLeftRenderer;
sv.topcenter.rowRenderer=this.TopCenterRenderer;
this.mapToHtml();
var vs=this.vScrollbar=new nitobi.ui.VerticalScrollbar();
vs.attachToParent(this.element,$ntb("vscroll"+this.uid));
vs.subscribe("ScrollByUser",L.close(this,this.scrollVertical));
this.subscribe("PercentHeightChanged",L.close(vs,vs.setRange));
this.subscribe("ScrollVertical",L.close(vs,vs.setScrollPercent));
this.setscrollbarWidth(vs.getWidth());
var hs=this.hScrollbar=new nitobi.ui.HorizontalScrollbar();
hs.attachToParent(this.element,$ntb("hscroll"+this.uid));
hs.subscribe("ScrollByUser",L.close(this,this.scrollHorizontal));
this.subscribe("PercentWidthChanged",L.close(hs,hs.setRange));
this.subscribe("ScrollHorizontal",L.close(hs,hs.setScrollPercent));
this.setscrollbarHeight(hs.getHeight());
};
nitobi.grid.Grid.prototype.createToolbars=function(_d6){
var tb=this.toolbars=new nitobi.ui.Toolbars(this,(this.isToolbarEnabled()?_d6:0));
var _d8=document.getElementById("toolbarContainer"+this.uid);
tb.setWidth(this.getWidth());
tb.setHeight(this.getToolbarHeight());
tb.setRowInsertEnabled(this.isRowInsertEnabled());
tb.setRowDeleteEnabled(this.isRowDeleteEnabled());
tb.attachToParent(_d8);
var L=nitobi.lang;
tb.subscribe("InsertRow",L.close(this,this.insertAfterCurrentRow));
tb.subscribe("DeleteRow",L.close(this,this.deleteCurrentRow));
tb.subscribe("Save",L.close(this,this.save));
tb.subscribe("Refresh",L.close(this,this.refresh));
this.subscribe("AfterGridResize",L.close(this,this.resizeToolbars));
};
nitobi.grid.Grid.prototype.resizeToolbars=function(){
this.toolbars.setWidth(this.getWidth());
this.toolbars.resize();
};
nitobi.grid.Grid.prototype.scrollVerticalRelative=function(_da){
var st=this.scroller.getScrollTop()+_da;
var mc=this.Scroller.view.midcenter;
percent=st/(mc.container.offsetHeight-mc.element.offsetHeight);
this.scrollVertical(percent);
};
nitobi.grid.Grid.prototype.scrollVertical=function(_dd){
this.focus();
this.clearHover();
var _de=this.scroller.getScrollTopPercent();
this.scroller.setScrollTopPercent(_dd);
this.fire("ScrollVertical",_dd);
if(_dd>0.99&&_de<0.99){
this.fire("ScrollHitBottom",_dd);
}
if(_dd<0.01){
this.fire("ScrollHitTop",_dd);
}
};
nitobi.grid.Grid.prototype.scrollHorizontalRelative=function(_df){
var sl=this.scroller.getScrollLeft()+_df;
var mc=this.scroller.view.midcenter;
percent=sl/(mc.container.offsetWidth-mc.element.offsetWidth);
this.scrollHorizontal(percent);
};
nitobi.grid.Grid.prototype.scrollHorizontal=function(_e2){
this.focus();
this.clearHover();
this.scroller.setScrollLeftPercent(_e2);
this.fire("ScrollHorizontal",_e2);
if(_e2>0.99){
this.fire("ScrollHitRight",_e2);
}
if(_e2<0.01){
this.fire("ScrollHitLeft",_e2);
}
};
nitobi.grid.Grid.prototype.getScrollSurface=function(){
if(this.Scroller!=null){
return this.Scroller.view.midcenter.element;
}
};
nitobi.grid.Grid.prototype.getActiveView=function(){
var C=nitobi.grid.Cell;
return this.Scroller.getViewportByCoords(C.getRowNumber(this.activeCell),C.getColumnNumber(this.activeCell));
};
nitobi.grid.Grid.prototype.ensureCellInView=function(_e4){
var SS=this.getScrollSurface();
var AC=_e4||this.activeCell;
if(AC==null){
return;
}
var sct=0;
var scl=0;
var R1=nitobi.html.getBoundingClientRect(AC);
var R2=nitobi.html.getBoundingClientRect(SS);
var B=EBA_SELECTION_BUFFER||0;
var up=R1.top-R2.top-B-sct;
var _ed=R1.bottom-R2.bottom+B-sct;
var _ee=R1.left-R2.left-B-scl;
var _ef=R1.right-R2.right+B-scl;
if(up<0){
this.scrollVerticalRelative(up);
}
if(_ed>0){
this.scrollVerticalRelative(_ed);
}
if(nitobi.grid.Cell.getColumnNumber(AC)>this.getFrozenLeftColumnCount()-1){
if(_ee<0){
this.scrollHorizontalRelative(_ee);
}
if(_ef>0){
this.scrollHorizontalRelative(_ef);
}
}
this.fire("CellCoordsChanged",R1);
};
nitobi.grid.Grid.prototype.updateCellRanges=function(){
if(this.frameRendered){
var _f0=this.getRowCount();
this.Scroller.updateCellRanges(this.getColumnCount(),_f0,this.getFrozenLeftColumnCount(),this.getfreezetop());
this.measure();
this.resizeScroller();
var _f1=this.isToolbarEnabled()?this.getHeight()-this.getToolbarHeight():this.getHeight();
var _f2=$ntb("ntb-grid-hscrollshow"+this.uid);
_f1=_f1-_f2.clientHeight;
this.fire("PercentHeightChanged",(_f1)/this.calculateHeight());
this.fire("PercentWidthChanged",this.getWidth()/this.calculateWidth());
}
};
nitobi.grid.Grid.prototype.measure=function(){
this.measureViews();
this.sizeValid=true;
};
nitobi.grid.Grid.prototype.measureViews=function(){
this.measureRows();
this.measureColumns();
};
nitobi.grid.Grid.prototype.measureColumns=function(){
var fL=this.getFrozenLeftColumnCount();
var wL=0;
var wT=0;
var _f6=this.getColumnDefinitions();
var _f7=_f6.length;
for(var i=0;i<_f7;i++){
if(_f6[i].getAttribute("Visible")=="1"||_f6[i].getAttribute("visible")=="1"){
var w=Number(_f6[i].getAttribute("Width"));
wT+=w;
if(i<fL){
wL+=w;
}
}
}
this.setleft(wL);
};
nitobi.grid.Grid.prototype.measureRows=function(){
var _fa=this.isColumnIndicatorsEnabled()?this.getHeaderHeight():0;
this.settop(this.calculateHeight(0,this.getfreezetop()-1)+_fa);
};
nitobi.grid.Grid.prototype.resizeScroller=function(){
var C=nitobi.html.Css;
var _fc=parseInt(C.getStyle(this.getScrollSurface(),"height"));
var _fd=(this.getToolbars()!=null&&this.isToolbarEnabled()?this.getToolbarHeight():0);
var _fe=this.isColumnIndicatorsEnabled()?this.getHeaderHeight():0;
var _ff=$ntb("ntb-grid-hscrollshow"+this.uid);
var _100=_ff.clientHeight;
var _101=this.getHeight()-_fd-_fe-_100;
this.Scroller.resize(_101);
};
nitobi.grid.Grid.prototype.resize=function(_102,_103){
this.setWidth(_102);
this.setHeight(_103);
this.generateCss();
this.fire("AfterGridResize",{source:this,width:_102,height:_103});
};
nitobi.grid.Grid.prototype.beforeResize=function(evt){
var _105=new nitobi.base.EventArgs(this);
if(!nitobi.event.evaluate(this.getOnBeforeResizeEvent(),_105)){
return;
}
this.gridResizer.startResize(this,evt);
};
nitobi.grid.Grid.prototype.afterResize=function(){
this.resize(this.gridResizer.newWidth,this.gridResizer.newHeight);
this.syncWithData();
};
nitobi.grid.Grid.prototype.afterColumnResize=function(_106){
var col=this.getColumnObject(_106.column);
var _108=col.getWidth();
this.columnResize(col,_108+_106.dx);
};
nitobi.grid.Grid.prototype.columnResize=function(_109,_10a){
if(isNaN(_10a)){
return;
}
_109=(typeof _109=="object"?_109:this.getColumnObject(_109));
var _10b=_109.getWidth();
_109.setWidth(_10a);
this.updateCellRanges();
if(nitobi.browser.IE7||nitobi.browser.FF3){
this.generateCss();
}else{
var _10c=_109.column;
var dx=_10a-_10b;
var C=nitobi.html.Css;
if(_10c<this.getFrozenLeftColumnCount()){
var _10f=C.getClass(".ntb-grid-leftwidth"+this.uid);
_10f.width=(parseInt(_10f.width)+dx)+"px";
var _110=C.getClass(".ntb-grid-centerwidth"+this.uid);
_110.width=(parseInt(_110.width)-dx)+"px";
}else{
var _111=C.getClass(".ntb-grid-surfacewidth"+this.uid);
_111.width=(parseInt(_111.width)+dx)+"px";
}
var _112=C.getClass(".ntb-column"+this.uid+"_"+(_10c+1));
_112.width=(parseInt(_112.width)+dx)+"px";
this.adjustHorizontalScrollBars();
}
this.Selection.collapse(this.activeCell);
var _113=new nitobi.grid.OnAfterColumnResizeEventArgs(this,_109);
nitobi.event.evaluate(_109.getOnAfterResizeEvent(),_113);
};
nitobi.grid.Grid.prototype.initializeModel=function(){
this.model=nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.modelDoc));
this.modelNode=this.model.documentElement.selectSingleNode("//nitobi.grid.Grid");
var _114=nitobi.html.getScrollBarWidth();
if(_114){
this.setscrollbarWidth(_114);
this.setscrollbarHeight(_114);
}
var xDec=this.model.selectSingleNode("state/nitobi.grid.Columns");
if(xDec==null){
var xDec=this.model.createElement("nitobi.grid.Columns");
this.model.documentElement.appendChild(nitobi.xml.importNode(this.model,xDec,true));
}
var cols=this.getColumnCount();
if(cols>0){
this.defineColumns(cols);
}else{
this.columnsDefined=false;
this.inferredColumns=true;
}
this.model.documentElement.setAttribute("ID",this.uid);
this.model.documentElement.setAttribute("uniqueID",this.uid);
};
nitobi.grid.Grid.prototype.clearDefaultData=function(rows){
for(var i=0;i<rows;i++){
var e=this.model.createElement("e");
e.setAttribute("xi",i+1);
xDec.appendChild(e);
}
};
nitobi.grid.Grid.prototype.createRenderers=function(){
var _11a=this.uid;
var _11b=this.getRowHeight();
var _11c=["TopLeftRenderer","TopCenterRenderer","MidLeftRenderer","MidCenterRenderer"];
for(var i=0;i<4;i++){
this[_11c[i]]=new nitobi.grid.RowRenderer(this.data,null,_11b,null,null,_11a);
}
};
nitobi.grid.Grid.prototype.bind=function(){
if(this.isBound()){
this.clear();
this.datatable.descriptor.reset();
}
};
nitobi.grid.Grid.prototype.dataBind=function(){
this.bind();
};
nitobi.grid.Grid.prototype.getDataSource=function(_11e){
var _11f=this.dataTableId||"_default";
if(_11e){
_11f=_11e;
}
return this.data.getTable(_11f);
};
nitobi.grid.Grid.prototype.getChangeLogXmlDoc=function(_120){
return this.getDataSource(_120).getChangeLogXmlDoc();
};
nitobi.grid.Grid.prototype.getComplete=function(_121){
if(null==_121.dataSource.xmlDoc){
ebaErrorReport("evtArgs.dataSource.xmlDoc is null or not defined. Likely the gethandler failed use fiddler to check the response","",EBA_ERROR);
this.fire("LoadingError");
return;
}
var _122=_121.dataSource.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+_121.dataSource.id+"']");
ntbAssert((null!=_122),"Datasource is not avialable in bindComplete handler.\n");
};
nitobi.grid.Grid.prototype.bindComplete=function(){
if(this.inferredColumns&&!this.columnsDefined){
this.defineColumns(this.datatable);
}
this.setRowCount(this.datatable.getRemoteRowCount());
this.setBound(true);
this.syncWithData();
};
nitobi.grid.Grid.prototype.syncWithData=function(_123){
if(this.isBound()){
this.Scroller.render(true);
this.fire("DataReady",{"source":this});
}
};
nitobi.grid.Grid.prototype.finalizeRowCount=function(rows){
this.rowCountKnown=true;
this.setRowCount(rows);
};
nitobi.grid.Grid.prototype.adjustRowCount=function(pct){
this.scrollVertical(pct);
};
nitobi.grid.Grid.prototype.setRowCount=function(rows){
this.xSET("RowCount",arguments);
if(this.getPagingMode()==nitobi.grid.PAGINGMODE_STANDARD){
if(this.getDataMode()==nitobi.data.DATAMODE_LOCAL){
this.setDisplayedRowCount(this.getRowsPerPage());
}
}else{
this.setDisplayedRowCount(rows);
}
this.rowCount=rows;
this.updateCellRanges();
};
nitobi.grid.Grid.prototype.getRowCount=function(){
return this.rowCount;
};
nitobi.grid.Grid.prototype.layout=function(_127){
if(this.prevHeight!=this.getHeight()||this.prevWidth!=this.getWidth()){
this.prevHeight=this.getHeight();
this.prevWidth=this.getWidth();
this.layoutValid=false;
}
if(!this.layoutValid&&this.frameRendered){
this.layoutFrame();
this.generateFrameCss();
this.layoutValid=true;
}
};
nitobi.grid.Grid.prototype.layoutFrame=function(_128){
if(!this.frameRendered){
return;
}
if(!this.Scroller){
return;
}
this.minHeight=this.getMinHeight();
this.minWidth=this.getMinWidth();
var _129=false;
var _12a=false;
var tbH=this.getToolbarHeight();
var rowH=this.getRowHeight();
var colW=20;
var sbH=this.getscrollbarHeight();
var sbW=this.getscrollbarWidth();
var hdrH=this.getHeaderHeight();
tbH=this.isToolbarEnabled()?tbH:0;
hdrH=this.isColumnIndicatorsEnabled?hdrH:0;
var minH=Math.max(this.minHeight,tbH+rowH+sbH+hdrH);
var maxH=this.Height;
var minW=Math.max(this.minWidth,colW+sbW);
var maxW=this.Width;
if(_129){
var _135=this.Scroller.minSurfaceWidth;
var _136=this.Scroller.maxSurfaceWidth;
}else{
var _135=this.Scroller.SurfaceWidth;
var _136=_135;
}
if(_12a){
var _137=this.Scroller.minSurfaceHeight;
var _138=this.Scroller.maxSurfaceHeight;
}else{
var _137=this.Scroller.SurfaceHeight;
var _138=_137;
}
var _139=_137+(tbH)+(hdrH);
var _13a=_135;
var _13b=(_139>maxH);
var _13c=(_13a>maxW);
var _13b=(_13c&&((_139+20)>maxH))||_13b;
var _13c=(_13b&&((_13a+20)>maxW))||_13c;
sbH=_13c?sbH:0;
sbV=_13b?sbV:0;
var vpH=_139-hdrH-tbH-sbH;
var vpW=_13a-sbW;
this.resize();
};
nitobi.grid.Grid.prototype.defineColumns=function(_13f){
this.fire("BeforeColumnsDefined");
this.resetColumns();
var _140=null;
var _141=nitobi.lang.typeOf(_13f);
this.inferredColumns=false;
switch(_141){
case "string":
_140=this.defineColumnsFromString(_13f);
break;
case nitobi.lang.type.XMLNODE:
case nitobi.lang.type.XMLDOC:
case nitobi.lang.type.HTMLNODE:
_140=this.defineColumnsFromXml(_13f);
break;
case nitobi.lang.type.ARRAY:
_140=this.defineColumnsFromArray(_13f);
break;
case "object":
this.inferredColumns=true;
_140=this.defineColumnsFromData(_13f);
break;
case "number":
_140=this.defineColumnsCollection(_13f);
break;
default:
}
this.fire("AfterColumnsDefined");
this.defineColumnsFinalize();
return _140;
};
nitobi.grid.Grid.prototype.defineColumnsFromXml=function(_142){
if(_142==null||_142.childNodes.length==0){
return this.defineColumnsCollection(0);
}
if(_142.childNodes[0].nodeName==nitobi.xml.nsPrefix+"columndefinition"){
var _143=nitobi.grid.declarationConverterXslProc;
_142=nitobi.xml.transformToXml(_142,_143);
}
var wL=0,wT=0,wR=0;
var _147=this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column");
var _148=this.getColumnDefinitions().length;
var cols=_142.childNodes.length;
var xDec=this.model.selectSingleNode("state/nitobi.grid.Columns");
ntbAssert((_142&&_142.xml!=""),"There are either no column definitions defined in the HTML declaration or they could not be parsed as valid XML.","",EBA_DEBUG);
var _14b=_142.childNodes;
var fL=this.getFrozenLeftColumnCount();
if(_148==0){
var cols=_14b.length;
for(var i=0;i<cols;i++){
var col=_14b[i];
var _14f="";
var _150=col.nodeName;
var _151=col.selectSingleNode("ntb:texteditor|ntb:numbereditor|ntb:textareaeditor|ntb:imageeditor|ntb:linkeditor|ntb:dateeditor|ntb:lookupeditor|ntb:listboxeditor|ntb:checkboxeditor|ntb:passwordeditor");
var _152="TEXT";
var _153={"ntb:textcolumn":"EBATextColumn","ntb:numbercolumn":"EBANumberColumn","ntb:datecolumn":"EBADateColumn"};
var _14f=_153[_150].replace("EBA","").replace("Column","").toLowerCase();
var _154={"ntb:numbereditor":"EBANumberEditor","ntb:textareaeditor":"EBATextareaEditor","ntb:imageeditor":"EBAImageEditor","ntb:linkeditor":"EBALinkEditor","ntb:dateeditor":"EBADateEditor","ntb:lookupeditor":"EBALookupEditor","ntb:listboxeditor":"EBAListboxEditor","ntb:passwordeditor":"EBAPasswordEditor","ntb:checkboxeditor":"EBACheckboxEditor"};
if(_151!=null){
_152=_154[_151.nodeName]||_152;
}else{
_152=_153[_150]||_152;
}
_152=_152.replace("EBA","").replace("Editor","").replace("Column","").toUpperCase();
var e=this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column[@DataType='"+(_14f)+"' and @type='"+_152+"' and @editor='"+_152+"']").cloneNode(true);
this.setModelValues(e,col);
var _156=_153[col.nodeName]||"EBATextColumn";
this.defineColumnDatasource(e);
this.defineColumnBinding(e);
xDec.appendChild(e);
var _157=e.getAttribute("GetHandler");
if(_157){
var _158=e.getAttribute("DatasourceId");
if(!_158||_158==""){
_158="columnDatasource_"+i+"_"+this.uid;
e.setAttribute("DatasourceId",_158);
}
var dt=new nitobi.data.DataTable("local",this.getPagingMode()==nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()},this.isAutoKeyEnabled());
dt.initialize(_158,_157,null);
dt.async=false;
this.data.add(dt);
var _15a=[];
_15a[0]=e;
var _15b=e.getAttribute("editor");
var _15c=null;
var _15d=null;
if(e.getAttribute("editor")=="LOOKUP"){
_15c=0;
_15d=1;
dt.async=true;
}
dt.get(_15c,_15d,this,nitobi.lang.close(this,this.editorDataReady,[e]),function(){
ntbAssert(false,"Datasource for "+e.getAttribute("ColumnName"),"",EBA_WARN);
});
}
}
this.measureColumns();
this.setColumnCount(cols);
}
var _15e;
_15e=_142.selectSingleNode("/"+nitobi.xml.nsPrefix+"grid/"+nitobi.xml.nsPrefix+"datasources");
if(_15e){
this.Declaration.datasources=nitobi.xml.createXmlDoc(_15e.xml);
}
return xDec;
};
nitobi.grid.Grid.prototype.defineColumnsFinalize=function(){
this.setColumnsDefined(true);
if(this.connected){
if(this.frameRendered){
this.makeXSL();
this.generateColumnCss();
this.renderHeaders();
}
}
};
nitobi.grid.Grid.prototype.defineColumnDatasource=function(_15f){
var val=_15f.getAttribute("Datasource");
if(val!=null){
var ds=new Array();
try{
ds=eval(val);
}
catch(e){
var _162=val.split(",");
if(_162.length>0){
for(var i=0;i<_162.length;i++){
var item=_162[i];
ds[i]={text:item.split(":")[0],display:item.split(":")[1]};
}
}
return;
}
if(typeof (ds)=="object"&&ds.length>0){
var _165=new nitobi.data.DataTable("unbound",this.getPagingMode()==nitobi.grid.PAGINGMODE_LIVESCROLLING,{GridId:this.getID()},{GridId:this.getID()},this.isAutoKeyEnabled());
var _166="columnDatasource"+new Date().getTime();
_165.initialize(_166);
_15f.setAttribute("DatasourceId",_166);
var _167="";
for(var item in ds[0]){
_167+=item+"|";
}
_167=_167.substring(0,_167.length-1);
_165.initializeColumns(_167);
for(var i=0;i<ds.length;i++){
_165.createRecord(null,i);
for(var item in ds[i]){
_165.updateRecord(i,item,ds[i][item]);
}
}
this.data.add(_165);
this.editorDataReady(_15f);
}
}
};
nitobi.grid.Grid.prototype.defineColumnsFromData=function(_168){
if(_168==null){
_168=this.datatable;
}
var _169=_168.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure");
if(_169==null){
return this.defineColumnsCollection(0);
}
var _16a=_169.getAttribute("FieldNames");
if(_16a.length==0){
return this.defineColumnsCollection(0);
}
var _16b=_169.getAttribute("defaults");
var _16c=this.defineColumnsFromString(_16a);
for(var i=0;i<_16c.length;i++){
if(_16b&&i<_16b.length){
_16c[i].setAttribute("initial",_16b[i]||"");
}
_16c[i].setAttribute("width",100);
}
this.inferredColumns=true;
return _16c;
};
nitobi.grid.Grid.prototype.defineColumnsFromString=function(_16e){
return this.defineColumnsFromArray(_16e.split("|"));
};
nitobi.grid.Grid.prototype.defineColumnsFromArray=function(_16f){
var cols=_16f.length;
var _171=this.defineColumnsCollection(cols);
for(var i=0;i<cols;i++){
var col=_171[i];
if(typeof (_16f[i])=="string"){
col.setAttribute("ColumnName",_16f[i]);
col.setAttribute("xdatafld_orig",_16f[i]);
col.setAttribute("DataField_orig",_16f[i]);
col.setAttribute("Label",_16f[i]);
if(typeof (this.fieldMap[_16f[i]])!="undefined"){
col.setAttribute("xdatafld",this.fieldMap[_16f[i]]);
col.setAttribute("DataField",this.fieldMap[_16f[i]]);
}else{
col.setAttribute("xdatafld","unbound");
col.setAttribute("DataField","unbound");
}
}else{
if(_16f[i].name!="_xk"){
col.setAttribute("ColumnName",col.name);
col.setAttribute("xdatafld_orig",col.name);
col.setAttribute("DataField_orig",col.name);
col.setAttribute("xdatafld",this.fieldMap[_16f[i].name]);
col.setAttribute("DataField",this.fieldMap[_16f[i].name]);
col.setAttribute("Width",col.width);
col.setAttribute("Label",col.label);
col.setAttribute("Initial",col.initial);
col.setAttribute("Mask",col.mask);
}
}
}
this.setColumnCount(cols);
return _171;
};
nitobi.grid.Grid.prototype.defineColumnBindings=function(){
var xslt=nitobi.grid.rowXslProc.stylesheet;
var cols=this.getColumnDefinitions();
for(var i=0;i<cols.length;i++){
var e=cols[i];
this.defineColumnBinding(e,xslt);
e.setAttribute("xi",i);
}
nitobi.grid.rowXslProc=nitobi.xml.createXslProcessor(xslt);
};
nitobi.grid.Grid.prototype.defineColumnBinding=function(_178,xslt){
if(this.fieldMap==null){
return;
}
var _17a=_178.getAttribute("xdatafld");
var _17b=_178.getAttribute("xdatafld_orig");
if(_17b==null||_17b==""){
_178.setAttribute("xdatafld_orig",_17a);
_178.setAttribute("DataField_orig",_17a);
}else{
_17a=_178.getAttribute("xdatafld_orig");
}
_178.setAttribute("ColumnName",_17a);
var _17c=this.fieldMap[_17a];
if(typeof (_17c)!="undefined"){
_178.setAttribute("xdatafld",_17c);
_178.setAttribute("DataField",_17c);
}
this.formatBinding(_178,"CssStyle",xslt);
this.formatBinding(_178,"ClassName",xslt);
this.formatBinding(_178,"Value",xslt);
};
nitobi.grid.Grid.prototype.formatBinding=function(_17d,_17e,xslt){
var _180=_17d.getAttribute(_17e);
var _181=_17d.getAttribute(_17e+"_orig");
if(_180==null||_180==""){
return;
}
if(_181==null||_181==""){
_17d.setAttribute(_17e+"_orig",_180);
}
_180=_17d.getAttribute(_17e+"_orig");
var re=new RegExp("\\{.[^}]*}","gi");
var _183=_180.match(re);
if(_183==null){
return;
}
for(var i=0;i<_183.length;i++){
var _185=_183[i];
var _186=_185;
var _187=new RegExp("\\$.*?[^0-9a-zA-Z_]","gi");
var _188=_186.match(_187);
for(var j=0;j<_188.length;j++){
var _18a=_188[j];
var _18b=_18a.substring(0,_18a.length-1);
var _18c=_18b.substring(1);
var _18d=this.fieldMap[_18c]+"";
_186=_186.replace(_18b,_18d.substring(1)||"");
}
_186=_186.substring(1,_186.length-1);
_180=_180.replace(_185,_186).replace(/\{\}/g,"");
}
_17d.setAttribute(_17e,_180);
};
nitobi.grid.Grid.prototype.defineColumnsCollection=function(cols){
var xDec=this.model.selectSingleNode("state/nitobi.grid.Columns");
var _190=xDec.childNodes;
var _191=this.model.selectSingleNode("/state/Defaults/nitobi.grid.Column");
for(var i=0;i<cols;i++){
var e=_191.cloneNode(true);
xDec.appendChild(e);
e.setAttribute("xi",i);
e.setAttribute("title",(i>25?String.fromCharCode(Math.floor(i/26)+65):"")+(String.fromCharCode(i%26+65)));
}
this.setColumnCount(cols);
var _190=xDec.selectNodes("*");
return _190;
};
nitobi.grid.Grid.prototype.resetColumns=function(){
this.fire("BeforeClearColumns");
this.inferredColumns=true;
this.columnsDefined=false;
var _194=this.model.selectSingleNode("state/nitobi.grid.Columns");
var xDec=this.model.createElement("nitobi.grid.Columns");
if(_194==null){
this.model.documentElement.appendChild(xDec);
}else{
this.model.documentElement.replaceChild(xDec,_194);
}
this.setColumnCount(0);
this.fire("AfterClearColumns");
};
nitobi.grid.Grid.prototype.renderHeaders=function(){
if(this.getColumnDefinitions().length>0){
this.Scroller.clearSurfaces(false,true);
var _196=0;
endRow=this.getfreezetop()-1;
var tl=this.Scroller.view.topleft;
tl.top=this.getHeaderHeight();
tl.left=0;
tl.renderGap(_196,endRow,false,"*");
var tc=this.Scroller.view.topcenter;
tc.top=this.getHeaderHeight();
tc.left=0;
tc.renderGap(_196,endRow,false);
}
};
nitobi.grid.Grid.prototype.initializeSelection=function(){
var sel=new nitobi.grid.Selection(this,this.isDragFillEnabled());
sel.setRowHeight(this.getRowHeight());
sel.onAfterExpand.subscribe(this.afterExpandSelection,this);
sel.onBeforeExpand.subscribe(this.beforeExpandSelection,this);
sel.onMouseUp.subscribe(this.handleSelectionMouseUp,this);
this.selection=this.Selection=sel;
};
nitobi.grid.Grid.prototype.beforeExpandSelection=function(evt){
this.setExpanding(true);
this.fire("BeforeDragFill",new nitobi.base.EventArgs(this,evt));
};
nitobi.grid.Grid.prototype.afterExpandSelection=function(evt){
var sel=this.selection;
var _19d=sel.getCoords();
var _19e=_19d.top.y;
var _19f=_19d.bottom.y;
var _1a0=_19d.top.x;
var _1a1=_19d.bottom.x;
var _1a2=this.getTableForSelection({top:{x:sel.expandStartLeftColumn,y:sel.expandStartTopRow},bottom:{x:sel.expandStartRightColumn,y:sel.expandStartBottomRow}});
var data="",_1a4=this.getClipboard();
if(sel.expandingVertical){
if(sel.expandStartBottomRow>_19f&&_19e>=sel.expandStartTopRow){
for(var i=sel.expandStartLeftColumn;i<=sel.expandStartRightColumn;i++){
for(var j=_19f+1;j<sel.expandStartBottomRow+1;j++){
this.getCellObject(j,i).setValue("");
}
}
}else{
var _1a7=(sel.expandStartBottomRow<_19f);
var _1a8=(sel.expandStartTopRow>_19e);
var _1a9=(_1a7||_1a8);
if(_1a9){
if(_1a2.lastIndexOf("\n")==_1a2.length-1){
_1a2=_1a2.substring(0,_1a2.length-1);
}
var rep=(Math.floor((sel.getHeight()-!_1a9)/sel.expandStartHeight));
for(var i=0;i<rep;i++){
data+=_1a2+(!nitobi.browser.IE?"\n":"");
}
_1ab=_1a2.split("\n");
var mod=(sel.getHeight()-!_1a9)%sel.expandStartHeight;
var val="";
if(_1a7){
_1ab.splice(mod,_1ab.length-mod);
val=data+_1ab.join("\n")+(_1ab.length>0?"\n":"");
}else{
_1ab.splice(0,_1ab.length-mod);
val=_1ab.join("\n")+(_1ab.length>0?"\n":"")+data;
}
_1a4.value=val;
this.pasteDataReady(_1a4);
}
}
}else{
if(sel.expandStartRightColumn>_1a1&&_1a0>=sel.expandStartLeftColumn){
for(var i=_1a0+1;i<=sel.expandStartRightColumn+1;i++){
for(var j=sel.expandStartTopRow;j<sel.expandStartBottomRow;j++){
this.getCellObject(j,i).setValue("");
}
}
}else{
var _1ae=sel.expandStartRightColumn<_1a1;
var _1af=sel.expandStartLeftColumn>_1a0;
var _1a9=(_1ae||_1af);
if(_1a9){
var mod=(sel.getWidth()-!_1a9)%sel.expandStartWidth;
var _1b0=(!nitobi.browser.IE?"\n":"\r\n");
if(_1a2.lastIndexOf(_1b0)==_1a2.length-_1b0.length){
_1a2=_1a2.substring(0,_1a2.length-_1b0.length);
}
var _1ab=_1a2.replace(/\r/g,"").split("\n");
var data=new Array(_1ab.length);
var rep=(Math.floor((sel.getWidth()-!_1a9)/sel.expandStartWidth));
for(var i=0;i<_1ab.length;i++){
var _1b1=_1ab[i].split("\t");
for(var j=0;j<rep;j++){
data[i]=(data[i]==null?[]:data[i]).concat(_1b1);
}
if(mod!=0){
if(_1ae){
data[i]=data[i].concat(_1b1.splice(0,mod));
}else{
data[i]=_1b1.splice(mod,_1b1.length-mod).concat(data[i]);
}
}
data[i]=data[i].join("\t");
}
_1a4.value=data.join("\n")+"\n";
this.pasteDataReady(_1a4);
}
}
}
this.setExpanding(false);
this.fire("AfterDragFill",new nitobi.base.EventArgs(this,evt));
};
nitobi.grid.Grid.prototype.calculateHeight=function(_1b2,end){
_1b2=(_1b2!=null)?_1b2:0;
var _1b4=this.getDisplayedRowCount();
end=(end!=null)?end:_1b4-1;
return (end-_1b2+1)*this.getRowHeight();
};
nitobi.grid.Grid.prototype.calculateWidth=function(_1b5,end){
var _1b7=this.getColumnDefinitions();
var cols=_1b7.length;
_1b5=_1b5||0;
end=(end!=null)?Math.min(end,cols):cols;
var wT=0;
for(var i=_1b5;i<end;i++){
if(_1b7[i].getAttribute("Visible")=="1"||_1b7[i].getAttribute("visible")=="1"){
wT+=Number(_1b7[i].getAttribute("Width"));
}
}
return (wT);
};
nitobi.grid.Grid.prototype.maximize=function(){
var x,y;
var _1bd=this.element.offsetParent;
x=_1bd.clientWidth;
y=_1bd.clientHeight;
this.resize(x,y);
};
nitobi.grid.Grid.prototype.editorDataReady=function(_1be){
var _1bf=_1be.getAttribute("DisplayFields").split("|");
var _1c0=_1be.getAttribute("ValueField");
var _1c1=this.data.getTable(_1be.getAttribute("DatasourceId"));
var _1c2=_1be.getAttribute("Initial");
if(_1c2==""){
var _1c3=_1be.getAttribute("type").toLowerCase();
switch(_1c3){
case "checkbox":
case "listbox":
var _1c4=_1c1.fieldMap[_1c0].substring(1);
var data=_1c1.getDataXmlDoc();
if(data!=null){
var val=data.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@"+_1c4+"='"+_1c2+"']");
if(val==null){
var _1c7=data.selectSingleNode("//"+nitobi.xml.nsPrefix+"e");
if(_1c7!=null){
_1c2=_1c7.getAttribute(_1c4);
}
}
}
break;
}
_1be.setAttribute("Initial",_1c2);
}
if((_1bf.length==1&&_1bf[0]=="")&&(_1c0==null||_1c0=="")){
for(var item in _1c1.fieldMap){
_1bf[0]=_1c1.fieldMap[item].substring(1);
break;
}
}else{
for(var i=0;i<_1bf.length;i++){
_1bf[i]=_1c1.fieldMap[_1bf[i]].substring(1);
}
}
var _1ca=_1bf.join("|");
if(_1c0==null||_1c0==""){
_1c0=_1bf[0];
}else{
_1c0=_1c1.fieldMap[_1c0].substring(1);
}
_1be.setAttribute("DisplayFields",_1ca);
_1be.setAttribute("ValueField",_1c0);
};
nitobi.grid.Grid.prototype.headerClicked=function(_1cb){
var _1cc=this.getColumnObject(_1cb);
var _1cd=new nitobi.grid.OnHeaderClickEventArgs(this,_1cc);
if(!this.fire("HeaderClick",_1cd)||!nitobi.event.evaluate(_1cc.getOnHeaderClickEvent(),_1cd)){
return;
}
this.sort(_1cb);
};
nitobi.grid.Grid.prototype.addFilter=function(){
this.dataTable.addFilter(arguments);
};
nitobi.grid.Grid.prototype.clearFilter=function(){
this.dataTable.clearFilter();
};
nitobi.grid.Grid.prototype.setSortStyle=function(_1ce,_1cf,_1d0){
var _1d1=this.getColumnObject(_1ce);
if(_1d0){
this.sortColumn=null;
this.sortColumnCell=null;
this.Scroller.setSort(_1ce,"");
this.setColumnSortOrder(_1ce,"");
}else{
_1d1.setSortDirection(_1cf);
this.setColumnSortOrder(_1ce,_1cf);
this.sortColumn=_1d1;
this.sortColumnCell=_1d1.getHeaderElement();
this.Scroller.setSort(_1ce,_1cf);
}
};
nitobi.grid.Grid.prototype.sort=function(_1d2,_1d3){
ntbAssert(typeof (_1d2)!="undefined","No column to sort.");
var _1d4=this.getColumnObject(_1d2);
if(_1d4==null||!_1d4.isSortEnabled()||(!this.isSortEnabled())){
return;
}
var _1d5=new nitobi.grid.OnBeforeSortEventArgs(this,_1d4);
if(!this.fire("BeforeSort",_1d5)||!nitobi.event.evaluate(_1d4.getOnBeforeSortEvent(),_1d5)){
return;
}
if(_1d3==null||typeof (_1d3)=="undefined"){
_1d3=(_1d4.getSortDirection()=="Asc")?"Desc":"Asc";
}
this.setSortStyle(_1d2,_1d3);
var _1d6=_1d4.getColumnName();
var _1d7=_1d4.getDataType();
var _1d8=this.getSortMode()=="local"||(this.getDataMode()=="local"&&this.getSortMode()!="remote");
this.datatable.sort(_1d6,_1d3,_1d7,_1d8);
if(!_1d8){
this.datatable.flush();
}
this.clearSurfaces();
this.scrollVertical(0);
if(!_1d8){
this.loadDataPage(0);
}
this.subscribeOnce("HtmlReady",this.handleAfterSort,this,[_1d4]);
};
nitobi.grid.Grid.prototype.handleAfterSort=function(_1d9){
var _1da=new nitobi.grid.OnAfterSortEventArgs(this,_1d9);
this.fire("AfterSort",_1da);
nitobi.event.evaluate(_1d9.getOnAfterSortEvent(),_1da);
};
nitobi.grid.Grid.prototype.handleDblClick=function(evt){
var cell=this.activeCellObject;
var col=this.activeColumnObject;
var _1de=new nitobi.grid.OnCellDblClickEventArgs(this,cell);
return this.fire("CellDblClick",_1de)&&nitobi.event.evaluate(col.getOnCellDblClickEvent(),_1de);
};
nitobi.grid.Grid.prototype.clearData=function(){
if(this.getDataMode()!="local"){
this.datatable.flush();
}
};
nitobi.grid.Grid.prototype.clearColumnHeaderSortOrder=function(){
if(this.sortColumn){
var _1df=this.sortColumn;
var _1e0=_1df.getHeaderElement();
var css=_1e0.className;
css=css.replace(/ascending/gi,"").replace(/descending/gi,"");
_1e0.className=css;
this.sortColumn=null;
}
};
nitobi.grid.Grid.prototype.setColumnSortOrder=function(_1e2,_1e3){
this.clearColumnHeaderSortOrder();
var _1e4=this.getColumnObject(_1e2);
var _1e5=_1e4.getHeaderElement();
var C=nitobi.html.Css;
var css=_1e5.className;
if(_1e3==""){
_1e5.className=css.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,"")+" ntb-column-indicator-border";
_1e3="Desc";
}else{
_1e5.className=css.replace(/(ntb-column-indicator-border)(.*?)(\s|$)/g,function(m){
var repl=(_1e3=="Desc"?"descending":"ascending");
return (m.indexOf("hover")>0?m.replace("hover",repl+"hover"):m+repl);
});
}
_1e4.setSortDirection(_1e3);
this.sortColumn=_1e4;
this.sortColumnCell=_1e5;
};
nitobi.grid.Grid.prototype.initializeState=function(){
};
nitobi.grid.Grid.prototype.mapToHtml=function(_1ea){
if(_1ea==null){
_1ea=this.UiContainer;
}
this.Scroller.mapToHtml(_1ea);
this.element=document.getElementById("grid"+this.uid);
this.element.jsObject=this;
};
nitobi.grid.Grid.prototype.generateCss=function(){
this.generateFrameCss();
};
nitobi.grid.Grid.prototype.generateColumnCss=function(){
this.generateCss();
};
nitobi.grid.Grid.prototype.generateFrameCss=function(){
var _1eb=nitobi.xml.serialize(this.model);
if(this.oldModel==_1eb){
return;
}
this.oldModel=nitobi.xml.serialize(this.model);
if(nitobi.browser.IE&&document.compatMode=="CSS1Compat"){
this.frameCssXslProc.addParameter("IE","true","");
}
var _1ec=nitobi.xml.transformToString(this.model,this.frameCssXslProc);
if(!nitobi.browser.SAFARI&&!nitobi.browser.CHROME&&this.stylesheet==null){
this.stylesheet=nitobi.html.Css.createStyleSheet();
}
var ss=this.getScrollSurface();
var _1ee=0;
var _1ef=0;
if(ss!=null){
_1ee=ss.scrollTop;
_1ef=ss.scrollLeft;
}
if(this.oldFrameCss!=_1ec){
this.oldFrameCss=_1ec;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
this.generateFrameCssSafari();
}else{
try{
this.stylesheet.cssText=_1ec;
}
catch(e){
}
if(ss!=null){
if(nitobi.browser.MOZ){
this.scrollVerticalRelative(_1ee);
this.scrollHorizontalRelative(_1ef);
}
ss.style.top="0px";
ss.style.left="0px";
}
}
}
};
nitobi.grid.Grid.prototype.generateFrameCssSafari=function(){
var ss=document.styleSheets[0];
var u=this.uid;
var t=this.getTheme();
var _1f3=this.getWidth();
var _1f4=this.getHeight();
var _1f5=(this.isVScrollbarEnabled()?1:0);
var _1f6=(this.isHScrollbarEnabled()?1:0);
var _1f7=(this.isToolbarEnabled()?1:0);
var _1f8=this.calculateWidth(0,this.getFrozenLeftColumnCount());
var _1f9=this.calculateWidth(this.getFrozenLeftColumnCount(),this.getColumnCount());
var _1fa=_1f8+_1f9;
var _1fb=_1f4-this.getscrollbarHeight()*_1f6-this.getToolbarHeight()*_1f7;
var _1fc=_1f3-this.getscrollbarWidth()*_1f5;
var _1fd=_1fb-this.gettop();
var _1fe=nitobi.html.Css.addRule;
var p="ntb-grid-";
if(this.rules==null){
this.rules={};
this.rules[".ntb-grid-datablock"]=_1fe(ss,".ntb-grid-datablock","table-layout:fixed;width:100%;");
this.rules[".ntb-grid-headerblock"]=_1fe(ss,".ntb-grid-headerblock","table-layout:fixed;width:100%;");
_1fe(ss,"."+p+"overlay"+u,"position:relative;z-index:1000;top:0px;left:0px;");
_1fe(ss,"."+p+"scroller"+u,"overflow:hidden;text-align:left;");
_1fe(ss,".ntb-grid","padding:0px;margin:0px;border:1px solid #cccccc;");
_1fe(ss,".ntb-scroller","padding:0px;");
_1fe(ss,".ntb-scrollcorner","padding:0px;");
_1fe(ss,".ntb-input-border","table-layout:fixed;overflow:hidden;position:absolute;z-index:2000;top:-2000px;left:-2000px;;");
_1fe(ss,".ntb-column-resize-surface","filter:alpha(opacity=1);background-color:white;position:absolute;visibility:hidden;top:0;left:0;width:100;height:100;z-index:800;");
_1fe(ss,".ntb-column-indicator","overflow:hidden;white-space: nowrap;");
}
this.rules["#grid"+u]=_1fe(ss,"#grid"+u,"overflow:hidden;text-align:left;-moz-user-select: none;-khtml-user-select: none;user-select: none;"+(nitobi.browser.IE?"position:relative;":""));
this.rules["#grid"+u].style.height=_1f4+"px";
this.rules["#grid"+u].style.width=_1f3+"px";
_1fe(ss,".hScrollbarRange"+u,"width:"+_1fa+"px;");
_1fe(ss,".vScrollbarRange"+u,"");
_1fe(ss,"."+t+" .ntb-cell","overflow:hidden;white-space:nowrap;");
_1fe(ss,"."+t+" .ntb-cell-border","overflow:hidden;white-space:nowrap;"+(nitobi.browser.IE?"height:auto;":"")+";");
_1fe(ss,".ntb-grid-headershow"+u,"padding:0px;"+(this.isColumnIndicatorsEnabled()?"display:none;":"")+"");
_1fe(ss,".ntb-grid-vscrollshow"+u,"padding:0px;"+(_1f5?"":"display:none;")+"");
_1fe(ss,"#ntb-grid-hscrollshow"+u,"padding:0px;"+(_1f6?"":"display:none;")+"");
_1fe(ss,".ntb-grid-toolbarshow"+u,""+(_1f7?"":"display:none;")+"");
_1fe(ss,".ntb-grid-height"+u,"height:"+_1f4+"px;overflow:hidden;");
_1fe(ss,".ntb-grid-width"+u,"width:"+_1f3+"px;overflow:hidden;");
_1fe(ss,".ntb-grid-overlay"+u,"position:relative;z-index:1000;top:0px;left:0px;");
_1fe(ss,".ntb-grid-scroller"+u,"overflow:hidden;text-align:left;");
_1fe(ss,".ntb-grid-scrollerheight"+u,"height:"+(_1fa>_1f3?_1fb:_1fb+this.getscrollbarHeight())+"px;");
_1fe(ss,".ntb-grid-scrollerwidth"+u,"width:"+_1fc+"px;");
_1fe(ss,".ntb-grid-topheight"+u,"height:"+this.gettop()+"px;overflow:hidden;"+(this.gettop()==0?"display:none;":"")+"");
_1fe(ss,".ntb-grid-midheight"+u,"overflow:hidden;height:"+(_1fa>_1f3?_1fd:_1fd+this.getscrollbarHeight())+"px;");
_1fe(ss,".ntb-grid-leftwidth"+u,"width:"+this.getleft()+"px;overflow:hidden;text-align:left;");
_1fe(ss,".ntb-grid-centerwidth"+u,"width:"+(_1f3-this.getleft()-this.getscrollbarWidth()*_1f5)+"px;");
_1fe(ss,".ntb-grid-scrollbarheight"+u,"height:"+this.getscrollbarHeight()+"px;");
_1fe(ss,".ntb-grid-scrollbarwidth"+u,"width:"+this.getscrollbarWidth()+"px;");
_1fe(ss,".ntb-grid-toolbarheight"+u,"height:"+this.getToolbarHeight()+"px;");
_1fe(ss,".ntb-grid-surfacewidth"+u,"width:"+_1f9+"px;");
_1fe(ss,".ntb-grid-surfaceheight"+u,"height:100px;");
_1fe(ss,".ntb-hscrollbar"+u,(_1fa>_1f3?"display:block;":"display:none;"));
_1fe(ss,".ntb-row"+u,"height:"+this.getRowHeight()+"px;margin:0px;line-height:"+this.getRowHeight()+"px;");
_1fe(ss,".ntb-header-row"+u,"height:"+this.getHeaderHeight()+"px;");
var cols=this.getColumnDefinitions();
for(var i=1;i<=cols.length;i++){
var col=cols[i-1];
var _203=this.rules[".ntb-column"+u+"_"+(i)];
if(_203==null){
_203=this.rules[".ntb-column"+u+"_"+(i)]=_1fe(ss,".ntb-column"+u+"_"+(i));
}
_203.style.width=col.getAttribute("Width")+"px";
var _204=this.rules[".ntb-column-data"+u+"_"+(i)];
if(_204==null){
this.rules[".ntb-column-data"+u+"_"+(i)]=_1fe(ss,".ntb-column-data"+u+"_"+(i),"text-align:"+col.getAttribute("Align")+";");
}
}
};
nitobi.grid.Grid.prototype.clearSurfaces=function(){
this.selection.clearBoxes();
this.Scroller.clearSurfaces();
this.updateCellRanges();
this.cachedCells={};
};
nitobi.grid.Grid.prototype.renderFrame=function(){
var _205="IE";
if(nitobi.browser.MOZ){
_205="MOZ";
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
_205="SAFARI";
}
}
this.frameXslProc.addParameter("browser",_205,"");
this.UiContainer.innerHTML=nitobi.xml.transformToString(this.model,this.frameXslProc);
this.attachDomEvents();
this.frameRendered=true;
this.fire("AfterFrameRender");
};
nitobi.grid.Grid.prototype.renderMiddle=function(){
this.Scroller.view.midleft.flushCache();
this.Scroller.view.midcenter.flushCache();
};
nitobi.grid.Grid.prototype.refresh=function(){
var _206=null;
if(!this.fire("BeforeRefresh",_206)){
return;
}
ntbAssert(this.datatable!=null,"The Grid must be conntected to a DataTable to call refresh.","",EBA_THROW);
this.selectedRows=[];
this.clearSurfaces();
if(this.getDataMode()!="local"){
this.datatable.clearData();
}
this.syncWithData();
this.subscribeOnce("HtmlReady",this.handleAfterRefresh,this);
};
nitobi.grid.Grid.prototype.handleAfterRefresh=function(){
var _207=null;
this.fire("AfterRefresh",_207);
};
nitobi.grid.Grid.prototype.clear=function(){
this.selectedRows=[];
this.clearData();
this.clearSurfaces();
};
nitobi.grid.Grid.prototype.handleContextMenu=function(evt,obj){
var _20a=this.getOnContextMenuEvent();
if(_20a==null){
return true;
}else{
if(this.fire("ContextMenu")){
return true;
}else{
evt.cancelBubble=true;
evt.returnValue=false;
return false;
}
}
};
nitobi.grid.Grid.prototype.handleKeyPress=function(evt){
if(this.activeCell==null){
return;
}
var col=this.activeColumnObject;
this.fire("KeyPress",new nitobi.base.EventArgs(this,evt));
nitobi.event.evaluate(col.getOnKeyPressEvent(),evt);
nitobi.html.cancelEvent(evt);
return false;
};
nitobi.grid.Grid.prototype.handleKeyUp=function(evt){
if(this.activeCell==null){
return;
}
var col=this.activeColumnObject;
this.fire("KeyUp",new nitobi.base.EventArgs(this,evt));
nitobi.event.evaluate(col.getOnKeyUpEvent(),evt);
};
nitobi.grid.Grid.prototype.handleKey=function(evt,obj){
if(this.activeCell!=null){
var col=this.activeColumnObject;
var _212=new nitobi.base.EventArgs(this,evt);
if(!this.fire("KeyDown",_212)||!nitobi.event.evaluate(col.getOnKeyDownEvent(),_212)){
return;
}
}
var k=evt.keyCode;
k=k+(evt.shiftKey?256:0)+(evt.ctrlKey?512:0)+(evt.metaKey?1024:0);
switch(k){
case 529:
break;
case 35:
break;
case 36:
break;
case 547:
break;
case 548:
break;
case 34:
this.page(1);
break;
case 33:
this.page(-1);
break;
case 45:
this.insertAfterCurrentRow();
break;
case 46:
if(this.getSelectedRows().length>1){
this.deleteSelectedRows();
}else{
this.deleteCurrentRow();
}
break;
case 292:
this.selectHome();
break;
case 290:
this.pageSelect(1);
break;
case 289:
this.pageSelect(-1);
break;
case 296:
this.reselect(0,1);
break;
case 294:
this.reselect(0,-1);
break;
case 293:
this.reselect(-1,0);
break;
case 295:
this.reselect(1,0);
break;
case 577:
break;
case 579:
case 557:
this.copy(evt);
return true;
case 1091:
this.copy(evt);
return true;
case 600:
case 302:
break;
case 598:
case 301:
this.paste(evt);
return true;
break;
case 1110:
this.paste(evt);
return true;
case 35:
break;
case 36:
break;
case 547:
break;
case 548:
break;
case 13:
var et=this.getEnterTab().toLowerCase();
var _215=0;
var vert=1;
if(et=="left"){
_215=-1;
vert=0;
}else{
if(et=="right"){
_215=1;
vert=0;
}else{
if(et=="down"){
_215=0;
vert=1;
}else{
if(et=="up"){
_215=0;
vert=-1;
}
}
}
}
this.move(_215,vert);
break;
case 40:
this.move(0,1);
break;
case 269:
case 38:
this.move(0,-1);
break;
case 265:
case 37:
this.move(-1,0);
break;
case 9:
case 39:
this.move(1,0);
break;
case 577:
break;
case 595:
this.save();
break;
case 594:
this.refresh();
break;
case 590:
this.insertAfterCurrentRow();
break;
default:
this.edit(evt);
}
};
nitobi.grid.Grid.prototype.reselect=function(x,y){
var S=this.selection;
var row=nitobi.grid.Cell.getRowNumber(S.endCell)+y;
var _21b=nitobi.grid.Cell.getColumnNumber(S.endCell)+x;
if(_21b>=0&&_21b<this.columnCount()&&row>=0){
var _21c=this.getCellElement(row,_21b);
if(!_21c){
return;
}
S.changeEndCellWithDomNode(_21c);
S.alignBoxes();
this.ensureCellInView(_21c);
}
};
nitobi.grid.Grid.prototype.pageSelect=function(dir){
};
nitobi.grid.Grid.prototype.selectHome=function(){
var S=this.selection;
var row=nitobi.grid.Cell.getRowNumber(S.endCell);
this.reselect(0,-row);
};
nitobi.grid.Grid.prototype.edit=function(evt){
if(this.activeCell==null){
return;
}
var cell=this.activeCellObject;
var col=this.activeColumnObject;
var _223=new nitobi.grid.OnBeforeCellEditEventArgs(this,cell);
if(!this.fire("BeforeCellEdit",_223)||!nitobi.event.evaluate(col.getOnBeforeCellEditEvent(),_223)){
return;
}
var _224=null;
var _225=null;
var ctrl=null;
if(evt){
_224=evt.keyCode||null;
_225=evt.shiftKey||null;
ctrl=evt.ctrlKey||null;
}
var _227="";
var _228=null;
if((_225&&(_224>64)&&(_224<91))||(!_225&&((_224>47)&&(_224<58)))){
_228=0;
}
if(!_225){
if((_224>64)&&(_224<91)){
_228=32;
}else{
if(_224>95&&_224<106){
_228=-48;
}else{
if((_224==189)||(_224==109)){
_227="-";
}else{
if((_224>186)&&(_224<188)){
_228=-126;
}
}
}
}
}else{
}
if(_228!=null){
_227=String.fromCharCode(_224+_228);
}
if((!ctrl)&&(""!=_227)||(_224==113)||(_224==0)||(_224==null)||(_224==32)){
if(col.isEditable()){
this.cellEditor=nitobi.form.ControlFactory.instance.getEditor(this,col);
if(this.cellEditor==null){
return;
}
this.cellEditor.setEditCompleteHandler(this.editComplete);
this.cellEditor.attachToParent(this.getToolsContainer());
this.cellEditor.bind(this,cell,_227);
this.cellEditor.mimic();
this.setEditMode(true);
nitobi.html.cancelEvent(evt);
return false;
}
}else{
return;
}
};
nitobi.grid.Grid.prototype.editComplete=function(_229){
var cell=_229.cell;
var _22b=cell.getColumnObject();
var _22c=_229.databaseValue;
var _22d=_229.displayValue;
var _22e=new nitobi.grid.OnCellValidateEventArgs(this,cell,_22c,cell.getValue());
if(!this.fire("CellValidate",_22e)||!nitobi.event.evaluate(_22b.getOnCellValidateEvent(),_22e)){
return false;
}
cell.setValue(_22c,_22d);
_229.editor.hide();
this.setEditMode(false);
var _22f=new nitobi.grid.OnAfterCellEditEventArgs(this,cell);
this.fire("AfterCellEdit",_22f);
nitobi.event.evaluate(_22b.getOnAfterCellEditEvent(),_22f);
try{
this.focus();
}
catch(e){
}
};
nitobi.grid.Grid.prototype.autoSave=function(){
if(this.isAutoSaveEnabled()){
return this.save();
}
return false;
};
nitobi.grid.Grid.prototype.selectCellByCoords=function(row,_231){
this.setPosition(row,_231);
};
nitobi.grid.Grid.prototype.setPosition=function(row,_233){
if(row>=0&&_233>=0){
var _234=this.getCellElement(row,_233);
this.setActiveCell(_234);
}
};
nitobi.grid.Grid.prototype.save=function(){
if(this.datatable.log.selectNodes("//"+nitobi.xml.nsPrefix+"data/*").length==0){
return;
}
if(!this.fire("BeforeSave")){
return;
}
this.datatable.save(nitobi.lang.close(this,this.saveCompleteHandler),this.getOnBeforeSaveEvent());
};
nitobi.grid.Grid.prototype.saveCompleteHandler=function(_235){
if(this.getDataSource().getHandlerError()){
this.fire("HandlerError",_235);
}
this.fire("AfterSave",_235);
};
nitobi.grid.Grid.prototype.focus=function(){
try{
this.keyNav.focus();
this.fire("Focus",new nitobi.base.EventArgs(this));
if(!nitobi.browser.SAFARI&&!nitobi.browser.CHROME){
nitobi.html.cancelEvent(nitobi.html.Event);
return false;
}
}
catch(e){
}
};
nitobi.grid.Grid.prototype.blur=function(){
this.clearActiveRows();
this.selection.clear();
this.blurActiveCell(null);
this.activateCell(null);
this.fire("Blur",new nitobi.base.EventArgs(this));
};
nitobi.grid.Grid.prototype.getRendererForColumn=function(col){
var _237=this.getColumnCount();
if(col>=_237){
col=_237-1;
}
var _238=this.getFrozenLeftColumnCount();
if(col<frozenLeft){
return this.MidLeftRenderer;
}else{
return this.MidCenterRenderer;
}
};
nitobi.grid.Grid.prototype.getColumnOuterTemplate=function(col){
return this.getRendererForColumn(col).xmlTemplate.selectSingleNode("//*[@match='ntb:e']/div/div["+col+"]");
};
nitobi.grid.Grid.prototype.getColumnInnerTemplate=function(col){
return this.getColumnOuterXslTemplate(col).selectSingleNode("*[2]");
};
nitobi.grid.Grid.prototype.makeXSL=function(){
var fL=this.getFrozenLeftColumnCount();
var cs=this.getColumnCount();
var rh=this.isRowHighlightEnabled();
var _23e="_default";
if(this.datatable!=null){
_23e=this.datatable.id;
}
var _23f=0;
var _240=fL;
var _241=this.model.selectSingleNode("state/nitobi.grid.Columns");
this.TopLeftRenderer.generateXslTemplate(_241,null,_23f,_240,this.isColumnIndicatorsEnabled(),this.isRowIndicatorsEnabled(),rh,this.isToolTipsEnabled());
this.TopLeftRenderer.dataTableId=_23e;
_23f=fL;
_240=cs-fL;
this.TopCenterRenderer.generateXslTemplate(_241,null,_23f,_240,this.isColumnIndicatorsEnabled(),this.isRowIndicatorsEnabled(),rh,this.isToolTipsEnabled());
this.TopCenterRenderer.dataTableId=_23e;
this.MidLeftRenderer.generateXslTemplate(_241,null,0,fL,0,this.isRowIndicatorsEnabled(),rh,this.isToolTipsEnabled(),"left");
this.MidLeftRenderer.dataTableId=_23e;
this.MidCenterRenderer.generateXslTemplate(_241,null,fL,cs-fL,0,0,rh,this.isToolTipsEnabled());
this.MidCenterRenderer.dataTableId=_23e;
this.fire("AfterMakeXsl");
};
nitobi.grid.Grid.prototype.render=function(){
this.generateCss();
this.updateCellRanges();
};
nitobi.grid.Grid.prototype.refilter=nitobi.grid.Grid.prototype.render;
nitobi.grid.Grid.prototype.getColumnDefinitions=function(){
return this.model.selectNodes("state/nitobi.grid.Columns/*");
};
nitobi.grid.Grid.prototype.getVisibleColumnDefinitions=function(){
return this.model.selectNodes("state/nitobi.grid.Columns/*[@Visible='1']");
};
nitobi.grid.Grid.prototype.initializeModelFromDeclaration=function(){
var _242=this.Declaration.grid.documentElement.attributes;
var len=_242.length;
for(var i=0;i<len;i++){
var _245=_242[i];
var _246=this.properties[_245.nodeName];
if(_246!=null){
this["set"+_246.n](_245.nodeValue);
}
}
this.model.documentElement.setAttribute("ID",this.uid);
this.model.documentElement.setAttribute("uniqueID",this.uid);
};
nitobi.grid.Grid.prototype.setModelValues=function(_247,_248){
var _249=_247.getAttribute("DataType");
var _24a=_247.getAttribute("type").toLowerCase();
var _24b=_248.attributes;
for(var j=0;j<_24b.length;j++){
var _24d=_24b[j];
var _24e=_24d.nodeName.toLowerCase();
var _24f=this.xColumnProperties[_249+"column"][_24e]||this.xColumnProperties["column"][_24e];
var _250=_24d.nodeValue;
if(_24f.t=="b"){
_250=nitobi.lang.boolToStr(nitobi.lang.toBool(_250));
}
_247.setAttribute(_24f.n,_250);
}
var _251=_248.selectSingleNode("./ntb:"+_24a+"editor");
if(_251==null){
return;
}
var _252=_251.attributes;
for(var j=0;j<_252.length;j++){
var _24d=_252[j];
var _24e=_24d.nodeName.toLowerCase();
var _24f=this.xColumnProperties[_24a+"editor"][_24e];
var _250=_24d.nodeValue;
if(_24f.t=="b"){
_250=nitobi.lang.boolToStr(nitobi.lang.toBool(_250));
}
_247.setAttribute(_24f.n,_250);
}
};
nitobi.grid.Grid.prototype.getNewRecordKey=function(){
var _253;
var key;
var _255;
do{
_253=new Date();
key=(_253.getTime()+"."+Math.round(Math.random()*99));
_255=this.datatable.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@xk = '"+key+"']");
}while(_255!=null);
return key;
};
nitobi.grid.Grid.prototype.insertAfterCurrentRow=function(){
if(this.activeCell){
var _256=nitobi.grid.Cell.getRowNumber(this.activeCell);
this.insertRow(_256+1);
}else{
this.insertRow();
}
};
nitobi.grid.Grid.prototype.insertRow=function(_257){
var rows=parseInt(this.getDisplayedRowCount());
var xi=0;
if(_257!=null){
xi=parseInt((_257==null?rows:parseInt(_257)));
xi--;
}
var _25a=new nitobi.grid.OnBeforeRowInsertEventArgs(this,this.getRowObject(xi));
if(!this.isRowInsertEnabled()||!this.fire("BeforeRowInsert",_25a)){
return;
}
var _25b=this.datatable.getTemplateNode();
for(var i=0;i<this.columnCount();i++){
var _25d=this.getColumnObject(i);
var _25e=_25d.getInitial();
if(_25e==null||_25e==""){
var _25f=_25d.getDataType();
if(_25f==null||_25f==""){
_25f="text";
}
switch(_25f){
case "text":
_25e="";
break;
case "number":
_25e=0;
break;
case "date":
_25e="1900-01-01";
break;
}
}
var att=_25d.getxdatafld().substr(1);
if(att!=null&&att!=""){
_25b.setAttribute(att,_25e);
}
}
this.clearSurfaces();
this.datatable.createRecord(_25b,xi);
this.subscribeOnce("HtmlReady",this.handleAfterRowInsert,this,[xi]);
};
nitobi.grid.Grid.prototype.handleAfterRowInsert=function(xi){
this.setActiveCell(this.getCellElement(xi,0));
this.fire("AfterRowInsert",new nitobi.grid.OnAfterRowInsertEventArgs(this,this.getRowObject(xi)));
};
nitobi.grid.Grid.prototype.deleteCurrentRow=function(){
if(this.activeCell){
this.deleteRow(nitobi.grid.Cell.getRowNumber(this.activeCell));
}else{
alert("First select a record to delete.");
}
};
nitobi.grid.Grid.prototype.deleteSelectedRows=function(){
var _262=new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getSelectedRows());
if(!this.isRowDeleteEnabled()||!this.fire("BeforeRowDelete",_262)){
return;
}
var _263=this.getSelectedRows();
var _264=[];
for(row in _263){
_264.push(parseInt(_263[row].getAttribute("xi")));
}
_264.sort(function(a,b){
return a-b;
});
this.clearSurfaces();
var rows=this.getDisplayedRowCount();
try{
this.datatable.deleteRecordsArray(_264);
if(rows<=0){
this.activeCell=null;
}
this.subscribeOnce("HtmlReady",this.handleAfterRowDelete,this,_264);
}
catch(err){
this.dataBind();
}
};
nitobi.grid.Grid.prototype.deleteRow=function(_268){
ntbAssert(_268>=0,"Must specify a row to delete.");
var _269=new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getRowObject(_268));
if(!this.isRowDeleteEnabled()||!this.fire("BeforeRowDelete",_269)){
return;
}
this.clearSurfaces();
var rows=this.getDisplayedRowCount();
try{
this.datatable.deleteRecord(_268);
rows--;
if(rows<=0){
this.activeCell=null;
}
this.subscribeOnce("HtmlReady",this.handleAfterRowDelete,this,[_268]);
}
catch(err){
this.dataBind();
}
};
nitobi.grid.Grid.prototype.handleAfterRowDelete=function(xi){
this.setActiveCell(this.getCellElement(xi,0));
this.fire("AfterRowDelete",new nitobi.grid.OnBeforeRowDeleteEventArgs(this,this.getRowObject(xi)));
};
nitobi.grid.Grid.prototype.page=function(dir){
};
nitobi.grid.Grid.prototype.move=function(h,v){
if(this.activeCell!=null){
var hs=1;
var vs=1;
h=(h*hs);
v=(v*vs);
var cell=nitobi.grid.Cell;
var _272=cell.getColumnNumber(this.activeCell);
var _273=cell.getRowNumber(this.activeCell);
this.selectCellByCoords(_273+v,_272+h);
var _274=new nitobi.grid.CellEventArgs(this,this.activeCell);
if(_272+1==this.getVisibleColumnDefinitions().length&&h==1){
this.fire("HitRowEnd",_274);
}else{
if(_272==0&&h==-1){
this.fire("HitRowStart",_274);
}
}
}
};
nitobi.grid.Grid.prototype.handleSelectionMouseUp=function(evt){
if(this.isCellClicked()){
this.ensureCellInView(this.activeCell);
}
this.setCellClicked(false);
if(this.isSingleClickEditEnabled()){
this.edit(evt);
}else{
if(!nitobi.browser.IE){
this.focus();
}
}
};
nitobi.grid.Grid.prototype.loadNextDataPage=function(){
this.loadDataPage(this.getCurrentPageIndex()+1);
};
nitobi.grid.Grid.prototype.loadPreviousDataPage=function(){
this.loadDataPage(this.getCurrentPageIndex()-1);
};
nitobi.grid.Grid.prototype.GetPage=function(_276){
ebaErrorReport("GetPage is deprecated please use loadDataPage instead","",EBA_DEBUG);
this.loadDataPage(_276);
};
nitobi.grid.Grid.prototype.loadDataPage=function(_277){
};
nitobi.grid.Grid.prototype.getSelectedRow=function(rel){
try{
var nRow=-1;
var AC=this.activeCell;
if(AC!=null){
nRow=nitobi.grid.Cell.getRowNumber(AC);
if(rel){
nRow-=this.getfreezetop();
}
}
return nRow;
}
catch(err){
_ntbAssert(false,err.message);
}
};
nitobi.grid.Grid.prototype.handleHandlerError=function(){
var _27b=this.getDataSource().getHandlerError();
if(_27b){
this.fire("HandlerError");
}
};
nitobi.grid.Grid.prototype.getRowObject=function(_27c,_27d){
var _27e=_27d;
if(_27d==null&&_27c!=null){
_27e=_27c;
}
return new nitobi.grid.Row(this,_27e);
};
nitobi.grid.Grid.prototype.getSelectedColumn=function(rel){
try{
var nCol=-1;
var AC=this.activeCell;
if(AC!=null){
nCol=parseInt(AC.getAttribute("col"));
if(rel){
nCol-=this.getFrozenLeftColumnCount();
}
}
return nCol;
}
catch(err){
_ntbAssert(false,err.message);
}
};
nitobi.grid.Grid.prototype.getSelectedColumnName=function(){
var _282=this.getSelectedColumnObject();
return _282.getColumnName();
};
nitobi.grid.Grid.prototype.getSelectedColumnObject=function(){
return this.getColumnObject(this.getSelectedColumn());
};
nitobi.grid.Grid.prototype.columnCount=function(){
try{
var _283=this.getColumnDefinitions();
return _283.length;
}
catch(err){
_ntbAssert(false,err.message);
}
};
nitobi.grid.Grid.prototype.getCellObject=function(row,col){
var _286=col;
var cell=this.cachedCells[row+"_"+col];
if(cell==null){
if(typeof (col)=="string"){
var node=this.model.selectSingleNode("state/nitobi.grid.Columns/nitobi.grid.Column[@xdatafld_orig='"+col+"']");
if(node!=null){
col=parseInt(node.getAttribute("xi"));
}
}
if(typeof (col)=="number"){
cell=new nitobi.grid.Cell(this,row,col);
}else{
cell=null;
}
this.cachedCells[row+"_"+col]=this.cachedCells[row+"_"+_286]=cell||"";
}else{
if(cell==""){
cell=null;
}
}
return cell;
};
nitobi.grid.Grid.prototype.getCellText=function(row,col){
return this.getCellObject(row,col).getHtml();
};
nitobi.grid.Grid.prototype.getCellValue=function(row,col){
return this.getCellObject(row,col).getValue();
};
nitobi.grid.Grid.prototype.getCellElement=function(row,_28e){
return nitobi.grid.Cell.getCellElement(this,row,_28e);
};
nitobi.grid.Grid.prototype.getSelectedRowObject=function(xi){
var obj=null;
var r=nitobi.grid.Cell.getRowNumber(this.activeCell);
obj=new nitobi.grid.Row(this,r);
return obj;
};
nitobi.grid.Grid.prototype.getColumnObject=function(_292){
ntbAssert(_292>=0,"Invalid column accessed.");
var _293=null;
if(_292>=0&&_292<this.getColumnDefinitions().length){
_293=this.columns[_292];
if(_293==null){
var _294=this.getColumnDefinitions()[_292].getAttribute("DataType");
switch(_294){
case "number":
_293=new nitobi.grid.NumberColumn(this,_292);
break;
case "date":
_293=new nitobi.grid.DateColumn(this,_292);
break;
default:
_293=new nitobi.grid.TextColumn(this,_292);
break;
}
this.columns[_292]=_293;
}
}
if(_293==null||_293.getModel()==null){
return null;
}else{
return _293;
}
};
nitobi.grid.Grid.prototype.getSelectedCellObject=function(){
var obj=this.activeCellObject;
if(obj==null){
obj=this.activeCell;
if(obj!=null){
var Cell=nitobi.grid.Cell;
var r=Cell.getRowNumber(obj);
var c=Cell.getColumnNumber(obj);
obj=this.getCellObject(r,c);
}
}
return obj;
};
nitobi.grid.Grid.prototype.autoAddRow=function(){
if(this.activeCell.innerText.replace(/\s/g,"")!=""&&this.autoAdd){
this.deactivateCell();
if(this.active=="Y"){
this.freezeCell();
}
eval(this.getOnRowBlurEvent());
this.insertRow();
this.go("HOME");
this.editCell();
}
};
nitobi.grid.Grid.prototype.setDisplayedRowCount=function(_299){
ntbAssert(!isNaN(_299),"displayed row was set to nan");
if(this.Scroller){
this.Scroller.view.midcenter.rows=_299;
this.Scroller.view.midleft.rows=_299;
}
this.displayedRowCount=_299;
};
nitobi.grid.Grid.prototype.getDisplayedRowCount=function(){
ntbAssert(!isNaN(this.displayedRowCount),"displayed row count return nan");
return this.displayedRowCount;
};
nitobi.grid.Grid.prototype.getToolsContainer=function(){
this.toolsContainer=this.toolsContainer||document.getElementById("ntb-grid-toolscontainer"+this.uid);
return this.toolsContainer;
};
nitobi.grid.Grid.prototype.getHeaderContainer=function(){
return document.getElementById("ntb-grid-header"+this.uid);
};
nitobi.grid.Grid.prototype.getDataContainer=function(){
return document.getElementById("ntb-grid-data"+this.uid);
};
nitobi.grid.Grid.prototype.getScrollerContainer=function(){
return document.getElementById("ntb-grid-scroller"+this.uid);
};
nitobi.grid.Grid.prototype.getGridContainer=function(){
return nitobi.html.getFirstChild(this.UiContainer);
};
nitobi.grid.Grid.prototype.copy=function(){
var _29a=this.selection.getCoords();
var data=this.getTableForSelection(_29a);
var _29c=new nitobi.grid.OnCopyEventArgs(this,data,_29a);
if(!this.isCopyEnabled()||!this.fire("BeforeCopy",_29c)){
return;
}
if(!nitobi.browser.IE){
var _29d=this.getClipboard();
_29d.onkeyup=nitobi.lang.close(this,this.focus);
_29d.value=data;
_29d.focus();
_29d.setSelectionRange(0,_29d.value.length);
}else{
window.clipboardData.setData("Text",data);
}
this.fire("AfterCopy",_29c);
};
nitobi.grid.Grid.prototype.getTableForSelection=function(_29e){
var _29f=this.getColumnMap(_29e.top.x,_29e.bottom.x);
var _2a0=nitobi.data.FormatConverter.convertEbaXmlToTsv(this.getDataSource().getDataXmlDoc(),_29f,_29e.top.y,_29e.bottom.y);
return _2a0;
};
nitobi.grid.Grid.prototype.getColumnMap=function(_2a1,_2a2){
var _2a3=this.getColumnDefinitions();
_2a1=(_2a1==null)?0:_2a1;
_2a2=(_2a2==null)?_2a3.length-1:_2a2;
var map=new Array();
for(var i=_2a1;i<=_2a2&&(null!=_2a3[i]);i++){
map.push(_2a3[i].getAttribute("xdatafld").substr(1));
}
return map;
};
nitobi.grid.Grid.prototype.paste=function(){
if(!this.isPasteEnabled()){
return;
}
var _2a6=this.getClipboard();
_2a6.onkeyup=nitobi.lang.close(this,this.pasteDataReady,[_2a6]);
_2a6.focus();
return _2a6;
};
nitobi.grid.Grid.prototype.pasteDataReady=function(_2a7){
_2a7.onkeyup=null;
var _2a8=this.selection;
var _2a9=_2a8.getCoords();
var _2aa=_2a9.top.x;
var _2ab=_2aa+nitobi.data.FormatConverter.getDataColumns(_2a7.value)-1;
var _2ac=true;
for(var i=_2aa;i<=_2ab;i++){
var _2ae=this.getColumnObject(i);
if(_2ae){
if(!_2ae.isEditable()){
_2ac=false;
break;
}
}
}
if(!_2ac){
this.fire("PasteFailed",new nitobi.base.EventArgs(this));
this.handleAfterPaste();
return;
}else{
var _2af=this.getColumnMap(_2aa,_2ab);
var _2b0=_2a9.top.y;
var _2b1=Math.max(_2b0+nitobi.data.FormatConverter.getDataRows(_2a7.value)-1,0);
this.getSelection().selectWithCoords(_2b0,_2aa,_2b1,_2aa+_2af.length-1);
var _2b2=new nitobi.grid.OnPasteEventArgs(this,_2a7.value,_2a9);
if(!this.fire("BeforePaste",_2b2)){
return;
}
var _2b3=_2a7.value;
var _2b4=null;
if(this.mode==nitobi.grid.PAGINGMODE_STANDARD){
var _2b5=this.datatable.getRowNodes().length-1;
if(_2b1>_2b5){
var _2b6=_2b1-_2b5;
for(var j=0;j<_2b6;j++){
var _2b8=this.datatable.getTemplateNode();
for(var i=0;i<this.columnCount();i++){
var _2ae=this.getColumnObject(i);
var _2b9=_2ae.getInitial();
if(_2b9==null||_2b9==""){
var _2ba=_2ae.getDataType();
if(_2ba==null||_2ba==""){
_2ba="text";
}
switch(_2ba){
case "text":
_2b9="";
break;
case "number":
_2b9=0;
break;
case "date":
_2b9="1900-01-01";
break;
}
}
var att=_2ae.getxdatafld().substr(1);
if(att!=null&&att!=""){
_2b8.setAttribute(att,_2b9);
}
}
this.datatable.createRecord(_2b8,_2b5+j+1);
}
}
}
if(_2b3.substr(0,1)=="<"){
_2b4=nitobi.data.FormatConverter.convertHtmlTableToEbaXml(_2b3,_2af,_2b0);
}else{
_2b4=nitobi.data.FormatConverter.convertTsvToEbaXml(_2b3,_2af,_2b0);
}
if(_2b4.documentElement!=null){
this.datatable.mergeFromXml(_2b4,nitobi.lang.close(this,this.pasteComplete,[_2b4,_2b0,_2b1,_2b2]));
}
}
};
nitobi.grid.Grid.prototype.pasteComplete=function(_2bc,_2bd,_2be,_2bf){
this.Scroller.reRender(_2bd,_2be);
this.subscribeOnce("HtmlReady",this.handleAfterPaste,this,[_2bf]);
};
nitobi.grid.Grid.prototype.handleAfterPaste=function(_2c0){
this.fire("AfterPaste",_2c0);
};
nitobi.grid.Grid.prototype.getClipboard=function(){
var _2c1=document.getElementById("ntb-clipboard"+this.uid);
_2c1.onkeyup=null;
_2c1.value="";
return _2c1;
};
nitobi.grid.Grid.prototype.getSelection=function(){
return this.selection;
};
nitobi.grid.Grid.prototype.handleHtmlReady=function(_2c2){
this.fire("HtmlReady",new nitobi.base.EventArgs(this));
};
nitobi.grid.Grid.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.grid.Grid.prototype.subscribe=function(evt,func,_2c7){
if(this.subscribedEvents==null){
this.subscribedEvents={};
}
if(typeof (_2c7)=="undefined"){
_2c7=this;
}
var guid=nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_2c7,func));
this.subscribedEvents[guid]=evt+this.uid;
return guid;
};
nitobi.grid.Grid.prototype.subscribeOnce=function(evt,func,_2cb,_2cc){
var guid=null;
var _2ce=this;
var _2cf=function(){
func.apply(_2cb||this,_2cc||arguments);
_2ce.unsubscribe(evt,guid);
};
guid=this.subscribe(evt,_2cf);
};
nitobi.grid.Grid.prototype.unsubscribe=function(evt,guid){
return nitobi.event.unsubscribe(evt+this.uid,guid);
};
nitobi.grid.Grid.prototype.dispose=function(){
try{
this.element.jsObject=null;
editorXslProc=null;
var H=nitobi.html;
H.detachEvents(this.getGridContainer(),this.events);
H.detachEvents(this.getHeaderContainer(),this.headerEvents);
H.detachEvents(this.getDataContainer(),this.cellEvents);
H.detachEvents(this.getScrollerContainer(),this.scrollerEvents);
H.detachEvents(this.keyNav,this.keyEvents);
for(var item in this.subscribedEvents){
var _2d4=this.subscribedEvents[item];
this.unsubscribe(_2d4.substring(0,_2d4.length-this.uid.length),item);
}
this.UiContainer.parentNode.removeChild(this.UiContainer);
for(var item in this){
if(this[item]!=null){
if(this[item].dispose instanceof Function){
this[item].dispose();
}
this[item]=null;
}
}
nitobi.form.ControlFactory.instance.dispose();
}
catch(e){
}
};
nitobi.Grid=nitobi.grid.Grid;
nitobi.grid.Cell=function(grid,row,_2d7){
if(row==null||grid==null){
return null;
}
this.grid=grid;
var _2d8=null;
if(typeof (row)=="object"){
var cell=row;
row=Number(cell.getAttribute("xi"));
_2d7=cell.getAttribute("col");
_2d8=cell;
}else{
_2d8=this.grid.getCellElement(row,_2d7);
}
this.DomNode=_2d8;
this.row=Number(row);
this.Row=this.row;
this.column=Number(_2d7);
this.Column=this.column;
this.dataIndex=this.Row;
};
nitobi.grid.Cell.prototype.getData=function(){
if(this.DataNode==null){
this.DataNode=this.grid.datatable.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@xi="+this.dataIndex+"]/"+this.grid.datatable.fieldMap[this.getColumnObject().getColumnName()]);
}
return this.DataNode;
};
nitobi.grid.Cell.prototype.getModel=function(){
if(this.ModelNode==null){
this.ModelNode=this.grid.model.selectSingleNode("//nitobi.grid.Columns/nitobi.grid.Column[@xi='"+this.column+"']");
}
return this.ModelNode;
};
nitobi.grid.Cell.prototype.setRow=function(){
this.jSET("Row",arguments);
};
nitobi.grid.Cell.prototype.getRow=function(){
return this.Row;
};
nitobi.grid.Cell.prototype.setColumn=function(){
this.jSET("Column",arguments);
};
nitobi.grid.Cell.prototype.getColumn=function(){
return this.Column;
};
nitobi.grid.Cell.prototype.setDomNode=function(){
this.jSET("DomNode",arguments);
};
nitobi.grid.Cell.prototype.getDomNode=function(){
return this.DomNode;
};
nitobi.grid.Cell.prototype.setDataNode=function(){
this.jSET("DataNode",arguments);
};
nitobi.grid.Cell.prototype.setValue=function(_2da,_2db){
if(_2da==this.getValue()){
return;
}
var _2dc=this.getColumnObject();
var _2dd="";
switch(_2dc.getType()){
case "PASSWORD":
for(var i=0;i<_2da.length;i++){
_2dd+="*";
}
break;
case "NUMBER":
if(this.numberXsl==null){
this.numberXsl=nitobi.form.numberXslProc;
}
if(_2da==""){
_2da=_2dc.getEditor().defaultValue||0;
}
if(this.DomNode!=null){
if(_2da<0){
nitobi.html.Css.addClass(this.DomNode,"ntb-cell-negativenumber");
}else{
nitobi.html.Css.removeClass(this.DomNode,"ntb-cell-negativenumber");
}
}
var mask=_2dc.getMask();
var _2e0=_2dc.getNegativeMask();
var _2e1=_2da;
if(_2da<0&&_2e0!=""){
mask=_2e0;
_2e1=(_2da+"").replace("-","");
}
this.numberXsl.addParameter("number",_2e1,"");
this.numberXsl.addParameter("mask",mask,"");
this.numberXsl.addParameter("group",_2dc.getGroupingSeparator(),"");
this.numberXsl.addParameter("decimal",_2dc.getDecimalSeparator(),"");
_2dd=nitobi.xml.transformToString(nitobi.xml.Empty,this.numberXsl);
if(""==_2dd&&_2da!=""){
_2dd=nitobi.html.getFirstChild(this.DomNode).innerHTML;
_2da=this.getValue();
}
break;
case "DATE":
if(this.dateXsl==null){
this.dateXsl=nitobi.form.dateXslProc.stylesheet;
}
var d=new Date();
var _2e3=nitobi.xml.createXmlDoc("<root><date>"+_2da+"</date><year>"+(d.getFullYear())+"</year><mask>"+this.columnObject.getMask()+"</mask></root>");
_2dd=nitobi.xml.transformToString(_2e3,this.dateXsl);
if(""==_2dd){
_2dd=nitobi.html.getFirstChild(this.DomNode).innerHTML;
_2da=this.getValue();
}
break;
case "TEXTAREA":
_2dd=nitobi.html.encode(_2da);
break;
case "LOOKUP":
var _2e4=_2dc.getModel();
var _2e5=_2e4.getAttribute("DatasourceId");
var _2e6=this.grid.data.getTable(_2e5);
var _2e7=_2e4.getAttribute("DisplayFields");
var _2e8=_2e4.getAttribute("ValueField");
var _2e9=_2e6.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@"+_2e8+"='"+_2da+"']/@"+_2e7);
if(_2e9!=null){
_2dd=_2e9.nodeValue;
}else{
_2dd=_2da;
}
break;
case "CHECKBOX":
var _2e4=_2dc.getModel();
var _2e5=_2e4.getAttribute("DatasourceId");
var _2e6=this.grid.data.getTable(_2e5);
var _2e7=_2e4.getAttribute("DisplayFields");
var _2e8=_2e4.getAttribute("ValueField");
var _2ea=_2e4.getAttribute("CheckedValue");
if(_2ea==""||_2ea==null){
_2ea=0;
}
var _2eb=_2e6.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@"+_2e8+"='"+_2da+"']/@"+_2e7).nodeValue;
var _2ec=(_2da==_2ea)?"checked":"unchecked";
_2dd="<div style=\"overflow:hidden;\"><div class=\"ntb-checkbox ntb-checkbox-"+_2ec+"\" checked=\""+_2da+"\">&nbsp;</div><div class=\"ntb-checkbox-text\">"+nitobi.html.encode(_2eb)+"</div></div>";
break;
case "LISTBOX":
var _2e4=_2dc.getModel();
var _2e5=_2e4.getAttribute("DatasourceId");
var _2e6=this.grid.data.getTable(_2e5);
var _2e7=_2e4.getAttribute("DisplayFields");
var _2e8=_2e4.getAttribute("ValueField");
_2dd=_2e6.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@"+_2e8+"='"+_2da+"']/@"+_2e7).nodeValue;
break;
case "IMAGE":
_2dd=nitobi.html.getFirstChild(this.DomNode).innerHTML;
if(nitobi.lang.typeOf(_2da)==nitobi.lang.type.HTMLNODE){
_2dd="<img border=\"0\" src=\""+_2da.getAttribute("src")+"\" />";
}else{
if(typeof (_2da)=="string"){
_2dd="<img border=\"0\" src=\""+_2da+"\" />";
}
}
break;
default:
_2dd=_2da;
}
_2dd=_2dd||"&nbsp;";
if(this.DomNode!=null){
var elem=nitobi.html.getFirstChild(this.DomNode);
elem.innerHTML=_2dd||"&nbsp;";
elem.setAttribute("title",_2da);
this.DomNode.setAttribute("value",_2da);
}
this.grid.datatable.updateRecord(this.dataIndex,_2dc.getColumnName(),_2da);
};
nitobi.grid.Cell.prototype.getValue=function(){
var _2ee=this.getColumnObject();
var val=this.GETDATA();
switch(_2ee.getType()){
case "NUMBER":
val=parseFloat(val);
break;
default:
}
return val;
};
nitobi.grid.Cell.prototype.getHtml=function(){
return nitobi.html.getFirstChild(this.DomNode).innerHTML;
};
nitobi.grid.Cell.prototype.edit=function(){
this.grid.setActiveCell(this.DomNode);
this.grid.edit();
};
nitobi.grid.Cell.prototype.GETDATA=function(){
var node=this.getData();
if(node!=null){
return node.value;
}
};
nitobi.grid.Cell.prototype.xGETMETA=function(){
if(this.MetaNode==null){
return null;
}
var node=this.MetaNode;
node=node.selectSingleNode("@"+arguments[0]);
if(node!=null){
return node.value;
}
};
nitobi.grid.Cell.prototype.xSETMETA=function(){
var node=this.MetaNode;
if(node!=null){
node.setAttribute(arguments[0],arguments[1][0]);
}else{
alert("Cannot set property: "+arguments[0]);
}
};
nitobi.grid.Cell.prototype.xSETCSS=function(){
var node=this.DomNode;
if(node!=null){
node.style.setAttribute(arguments[0],arguments[1][0]);
}else{
alert("Cannot set property: "+arguments[0]);
}
};
nitobi.grid.Cell.prototype.xGET=function(){
var node=this.getModel();
node=node.selectSingleNode(arguments[0]);
if(node!=null){
return node.value;
}
};
nitobi.grid.Cell.prototype.xSET=function(){
var node=this.getModel();
node=node.selectSingleNode(arguments[0]);
if(node!=null){
node.nodeValue=arguments[1][0];
}
};
nitobi.grid.Cell.prototype.getStyle=function(){
return this.DomNode.style;
};
nitobi.grid.Cell.prototype.getColumnObject=function(){
if(typeof (this.columnObject)=="undefined"){
this.columnObject=this.grid.getColumnObject(this.getColumn());
}
return this.columnObject;
};
nitobi.grid.Cell.getCellElement=function(grid,row,_2f8){
return $ntb("cell_"+row+"_"+_2f8+"_"+grid.uid);
};
nitobi.grid.Cell.getRowNumber=function(_2f9){
return parseInt(_2f9.getAttribute("xi"));
};
nitobi.grid.Cell.getColumnNumber=function(_2fa){
return parseInt(_2fa.getAttribute("col"));
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.CellEventArgs=function(_2fb,cell){
nitobi.grid.CellEventArgs.baseConstructor.call(this,_2fb);
this.cell=cell;
};
nitobi.lang.extend(nitobi.grid.CellEventArgs,nitobi.base.EventArgs);
nitobi.grid.CellEventArgs.prototype.getCell=function(){
return this.cell;
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.RowEventArgs=function(_2fd,row){
this.grid=_2fd;
this.row=row;
this.event=nitobi.html.Event;
};
nitobi.grid.RowEventArgs.prototype.getSource=function(){
return this.grid;
};
nitobi.grid.RowEventArgs.prototype.getRow=function(){
return this.row;
};
nitobi.grid.RowEventArgs.prototype.getEvent=function(){
return this.event;
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.SelectionEventArgs=function(_2ff,data,_301){
this.source=_2ff;
this.coords=_301;
this.data=data;
};
nitobi.grid.SelectionEventArgs.prototype.getSource=function(){
return this.source;
};
nitobi.grid.SelectionEventArgs.prototype.getCoords=function(){
return this.coords;
};
nitobi.grid.SelectionEventArgs.prototype.getData=function(){
return this.data;
};
nitobi.grid.Column=function(grid,_303){
this.grid=grid;
this.column=_303;
this.uid=nitobi.base.getUid();
this.modelNodes={};
};
nitobi.grid.Column.prototype={setAlign:function(){
this.xSET("Align",arguments);
},getAlign:function(){
return this.xGET("Align",arguments);
},setClassName:function(){
this.xSET("ClassName",arguments);
},getClassName:function(){
return this.xGET("ClassName",arguments);
},setCssStyle:function(){
this.xSET("CssStyle",arguments);
},getCssStyle:function(){
return this.xGET("CssStyle",arguments);
},setColumnName:function(){
this.xSET("ColumnName",arguments);
},getColumnName:function(){
return this.xGET("ColumnName",arguments);
},setType:function(){
this.xSET("type",arguments);
},getType:function(){
return this.xGET("type",arguments);
},setDataType:function(){
this.xSET("DataType",arguments);
},getDataType:function(){
return this.xGET("DataType",arguments);
},setEditable:function(){
this.xSET("Editable",arguments);
},isEditable:function(){
return nitobi.lang.toBool(this.xGET("Editable",arguments),true);
},setInitial:function(){
this.xSET("Initial",arguments);
},getInitial:function(){
return this.xGET("Initial",arguments);
},setLabel:function(){
this.xSET("Label",arguments);
},getLabel:function(){
return this.xGET("Label",arguments);
},setGetHandler:function(){
this.xSET("GetHandler",arguments);
},getGetHandler:function(){
return this.xGET("GetHandler",arguments);
},setDatasourceId:function(){
this.xSET("DatasourceId",arguments);
},getDatasourceId:function(){
return this.xGET("DatasourceId",arguments);
},setTemplate:function(){
this.xSET("Template",arguments);
},getTemplate:function(){
return this.xGET("Template",arguments);
},setTemplateUrl:function(){
this.xSET("TemplateUrl",arguments);
},getTemplateUrl:function(){
return this.xGET("TemplateUrl",arguments);
},setMaxLength:function(){
this.xSET("maxlength",arguments);
},getMaxLength:function(){
return Number(this.xGET("maxlength",arguments));
},setSortDirection:function(){
this.xSET("SortDirection",arguments);
},getSortDirection:function(){
return this.xGET("SortDirection",arguments);
},setSortEnabled:function(){
this.xSET("SortEnabled",arguments);
},isSortEnabled:function(){
return nitobi.lang.toBool(this.xGET("SortEnabled",arguments),true);
},setWidth:function(){
this.xSET("Width",arguments);
},getWidth:function(){
return Number(this.xGET("Width",arguments));
},setSize:function(){
this.xSET("Size",arguments);
},getSize:function(){
return Number(this.xGET("Size",arguments));
},setVisible:function(){
this.xSET("Visible",arguments);
},isVisible:function(){
return nitobi.lang.toBool(this.xGET("Visible",arguments),true);
},setxdatafld:function(){
this.xSET("xdatafld",arguments);
},getxdatafld:function(){
return this.xGET("xdatafld",arguments);
},setValue:function(){
this.xSET("Value",arguments);
},getValue:function(){
return this.xGET("Value",arguments);
},setxi:function(){
this.xSET("xi",arguments);
},getxi:function(){
return Number(this.xGET("xi",arguments));
},setEditor:function(){
this.xSET("Editor",arguments);
},getEditor:function(){
return this.xGET("Editor",arguments);
},setDisplayFields:function(){
this.xSET("DisplayFields",arguments);
},getDisplayFields:function(){
return this.xGET("DisplayFields",arguments);
},setValueField:function(){
this.xSET("ValueField",arguments);
},getValueField:function(){
return this.xGET("ValueField",arguments);
},setDelay:function(){
this.xSET("Delay",arguments);
},getDelay:function(){
return Number(this.xGET("Delay",arguments));
},setReferenceColumn:function(){
this.xSET("ReferenceColumn",arguments);
},getReferenceColumn:function(){
return this.xGET("ReferenceColumn",arguments);
},setOnCellClickEvent:function(){
this.xSET("OnCellClickEvent",arguments);
},getOnCellClickEvent:function(){
return this.xGET("OnCellClickEvent",arguments);
},setOnBeforeCellClickEvent:function(){
this.xSET("OnBeforeCellClickEvent",arguments);
},getOnBeforeCellClickEvent:function(){
return this.xGET("OnBeforeCellClickEvent",arguments);
},setOnCellDblClickEvent:function(){
this.xSET("OnCellDblClickEvent",arguments);
},getOnCellDblClickEvent:function(){
return this.xGET("OnCellDblClickEvent",arguments);
},setOnHeaderDoubleClickEvent:function(){
this.xSET("OnHeaderDoubleClickEvent",arguments);
},getOnHeaderDoubleClickEvent:function(){
return this.xGET("OnHeaderDoubleClickEvent",arguments);
},setOnHeaderClickEvent:function(){
this.xSET("OnHeaderClickEvent",arguments);
},getOnHeaderClickEvent:function(){
return this.xGET("OnHeaderClickEvent",arguments);
},setOnBeforeResizeEvent:function(){
this.xSET("OnBeforeResizeEvent",arguments);
},getOnBeforeResizeEvent:function(){
return this.xGET("OnBeforeResizeEvent",arguments);
},setOnAfterResizeEvent:function(){
this.xSET("OnAfterResizeEvent",arguments);
},getOnAfterResizeEvent:function(){
return this.xGET("OnAfterResizeEvent",arguments);
},setOnCellValidateEvent:function(){
this.xSET("OnCellValidateEvent",arguments);
},getOnCellValidateEvent:function(){
return this.xGET("OnCellValidateEvent",arguments);
},setOnBeforeCellEditEvent:function(){
this.xSET("OnBeforeCellEditEvent",arguments);
},getOnBeforeCellEditEvent:function(){
return this.xGET("OnBeforeCellEditEvent",arguments);
},setOnAfterCellEditEvent:function(){
this.xSET("OnAfterCellEditEvent",arguments);
},getOnAfterCellEditEvent:function(){
return this.xGET("OnAfterCellEditEvent",arguments);
},setOnCellBlurEvent:function(){
this.xSET("OnCellBlurEvent",arguments);
},getOnCellBlurEvent:function(){
return this.xGET("OnCellBlurEvent",arguments);
},setOnCellFocusEvent:function(){
this.xSET("OnCellFocusEvent",arguments);
},getOnCellFocusEvent:function(){
return this.xGET("OnCellFocusEvent",arguments);
},setOnBeforeSortEvent:function(){
this.xSET("OnBeforeSortEvent",arguments);
},getOnBeforeSortEvent:function(){
return this.xGET("OnBeforeSortEvent",arguments);
},setOnAfterSortEvent:function(){
this.xSET("OnAfterSortEvent",arguments);
},getOnAfterSortEvent:function(){
return this.xGET("OnAfterSortEvent",arguments);
},setOnCellUpdateEvent:function(){
this.xSET("OnCellUpdateEvent",arguments);
},getOnCellUpdateEvent:function(){
return this.xGET("OnCellUpdateEvent",arguments);
},setOnKeyDownEvent:function(){
this.xSET("OnKeyDownEvent",arguments);
},getOnKeyDownEvent:function(){
return this.xGET("OnKeyDownEvent",arguments);
},setOnKeyUpEvent:function(){
this.xSET("OnKeyUpEvent",arguments);
},getOnKeyUpEvent:function(){
return this.xGET("OnKeyUpEvent",arguments);
},setOnKeyPressEvent:function(){
this.xSET("OnKeyPressEvent",arguments);
},getOnKeyPressEvent:function(){
return this.xGET("OnKeyPressEvent",arguments);
},setOnChangeEvent:function(){
this.xSET("OnChangeEvent",arguments);
},getOnChangeEvent:function(){
return this.xGET("OnChangeEvent",arguments);
},setGetOnEnter:function(){
this.xbSET("GetOnEnter",arguments);
},isGetOnEnter:function(){
return nitobi.lang.toBool(this.xGET("GetOnEnter",arguments),true);
},setAutoComplete:function(){
this.xbSET("AutoComplete",arguments);
},isAutoComplete:function(){
return nitobi.lang.toBool(this.xGET("AutoComplete",arguments),true);
},setAutoClear:function(){
this.xbSET("AutoClear",arguments);
},isAutoClear:function(){
return nitobi.lang.toBool(this.xGET("AutoClear",arguments),true);
}};
nitobi.grid.Column.prototype.getModel=function(){
if(this.ModelNode==null){
var _304=this.column;
this.ModelNode=this.grid.model.selectNodes("//state/nitobi.grid.Columns/nitobi.grid.Column")[_304];
}
return this.ModelNode;
};
nitobi.grid.Column.prototype.getHeaderElement=function(){
return nitobi.grid.Column.getColumnHeaderElement(this.grid,this.column);
};
nitobi.grid.Column.prototype.getEditor=function(){
};
nitobi.grid.Column.prototype.getStyle=function(){
var _305=this.getClassName();
return nitobi.html.getClass(_305);
};
nitobi.grid.Column.prototype.getHeaderStyle=function(){
var _306="acolumnheader"+this.grid.uid+"_"+this.column;
return nitobi.html.getClass(_306);
};
nitobi.grid.Column.prototype.getDataStyle=function(){
var _307="ntb-column-data"+this.grid.uid+"_"+this.column;
return nitobi.html.getClass(_307);
};
nitobi.grid.Column.prototype.getEditor=function(){
return nitobi.form.ControlFactory.instance.getEditor(this.grid,this);
};
nitobi.grid.Column.prototype.xGET=function(){
var node=null,_309="@"+arguments[0],val="";
var _30b=this.modelNodes[_309];
if(_30b!=null){
node=_30b;
}else{
node=this.modelNodes[_309]=this.getModel().selectSingleNode(_309);
}
if(node!=null){
val=node.nodeValue;
}
return val;
};
nitobi.grid.Column.prototype.xSET=function(){
var node=this.getModel();
if(node!=null){
node.setAttribute(arguments[0],arguments[1][0]);
}
};
nitobi.grid.Column.prototype.xbSETMODEL=function(){
var node=this.getModel();
if(node!=null){
node.setAttribute(arguments[0],nitobi.lang.boolToStr(arguments[1][0]));
}
};
nitobi.grid.Column.prototype.eSET=function(name,_30f){
var _310=_30f[0];
var _311=_310;
var _312=name.substr(2);
_312=_312.substr(0,_312.length-5);
if(typeof (_310)=="string"){
_311=function(_313){
return eval(_310);
};
}
if(typeof (this[name])!="undefined"){
alert("unsubscribe");
this.unsubscribe(_312,this[name]);
}
var guid=this.subscribe(_312,_311);
this.jSET(name,[guid]);
};
nitobi.grid.Column.prototype.jSET=function(name,val){
this[name]=val[0];
};
nitobi.grid.Column.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.grid.Column.prototype.subscribe=function(evt,func,_31b){
if(typeof (_31b)=="undefined"){
_31b=this;
}
return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_31b,func));
};
nitobi.grid.Column.prototype.unsubscribe=function(evt,func){
return nitobi.event.unsubscribe(evt+this.uid,func);
};
nitobi.grid.Column.getColumnHeaderElement=function(grid,_31f){
return $ntb("columnheader_"+_31f+"_"+grid.uid);
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.ColumnEventArgs=function(_320,_321){
this.grid=_320;
this.column=_321;
this.event=nitobi.html.Event;
};
nitobi.grid.ColumnEventArgs.prototype.getSource=function(){
return this.grid;
};
nitobi.grid.ColumnEventArgs.prototype.getColumn=function(){
return this.column;
};
nitobi.grid.ColumnEventArgs.prototype.getEvent=function(){
return this.event;
};
nitobi.grid.ColumnEventArgs.prototype.getDirection=function(){
};
nitobi.grid.ColumnResizer=function(grid){
this.grid=grid;
this.hScrollClass=null;
this.grid_id=this.grid.UiContainer.parentid;
this.line=document.getElementById("ntb-column-resizeline"+this.grid.uid);
this.lineStyle=this.line.style;
if(nitobi.browser.IE){
this.surface=document.getElementById("ebagridresizesurface_");
if(this.surface==null){
this.surface=document.createElement("div");
this.surface.id="ebagridresizesurface_";
this.surface.className="ntb-column-resize-surface";
this.grid.UiContainer.appendChild(this.surface);
}
}
this.column;
this.onAfterResize=new nitobi.base.Event();
};
nitobi.grid.ColumnResizer.prototype.startResize=function(grid,_324,_325,evt){
this.grid=grid;
this.column=_324;
var x=nitobi.html.getEventCoords(evt).x;
if(nitobi.browser.IE){
this.surface.style.display="block";
nitobi.drawing.align(this.surface,this.grid.element,nitobi.drawing.align.SAMEHEIGHT|nitobi.drawing.align.SAMEWIDTH|nitobi.drawing.align.ALIGNTOP|nitobi.drawing.align.ALIGNLEFT);
}
this.x=x;
this.lineStyle.display="block";
var _328=nitobi.html.getBoundingClientRect(this.grid.UiContainer).left;
this.lineStyle.left=x-_328+"px";
this.lineStyle.height=this.grid.Scroller.scrollSurface.offsetHeight+"px";
nitobi.drawing.align(this.line,_325,nitobi.drawing.align.ALIGNTOP,0,0,nitobi.html.getHeight(_325)+1);
nitobi.ui.startDragOperation(this.line,evt,false,true,this,this.endResize);
};
nitobi.grid.ColumnResizer.prototype.endResize=function(_329){
var x=_329.x;
var Y=_329.y;
if(nitobi.browser.IE){
this.surface.style.display="none";
}
var ls=this.lineStyle;
ls.display="none";
ls.top="-3000px";
ls.left="-3000px";
this.dx=x-this.x;
this.onAfterResize.notify(this);
};
nitobi.grid.ColumnResizer.prototype.dispose=function(){
this.grid=null;
this.line=null;
this.lineStyle=null;
this.surface=null;
};
nitobi.grid.GridResizer=function(grid){
this.grid=grid;
this.widthFixed=false;
this.heightFixed=false;
this.minHeight=0;
this.minWidth=0;
this.box=document.getElementById("ntb-grid-resizebox"+grid.uid);
this.onAfterResize=new nitobi.base.Event();
};
nitobi.grid.GridResizer.prototype.startResize=function(grid,_32f){
this.grid=grid;
var _330=null;
var x,y;
var _333=nitobi.html.getEventCoords(_32f);
x=_333.x;
y=_333.y;
this.x=x;
this.y=y;
var w=grid.getWidth();
var h=grid.getHeight();
var L=grid.element.offsetLeft;
var T=grid.element.offsetTop;
this.resizeW=!this.widthFixed;
this.resizeH=!this.heightFixed;
if(this.resizeW||this.resizeH){
this.box.style.cursor=(this.resizeW&&this.resizeH)?"nw-resize":(this.resizeW)?"w-resize":"n-resize";
this.box.style.display="block";
var _338=nitobi.drawing.align.SAMEWIDTH|nitobi.drawing.align.SAMEHEIGHT|nitobi.drawing.align.ALIGNTOP|nitobi.drawing.align.ALIGNLEFT;
nitobi.drawing.align(this.box,this.grid.element,_338,0,0,0,0,false);
this.dd=new nitobi.ui.DragDrop(this.box,false,false);
this.dd.onDragStop.subscribe(this.endResize,this);
this.dd.onMouseMove.subscribe(this.resize,this);
this.dd.startDrag(_32f);
}
};
nitobi.grid.GridResizer.prototype.resize=function(){
var x=this.dd.x;
var y=this.dd.y;
var rect=nitobi.html.getBoundingClientRect(this.grid.UiContainer);
var L=rect.left;
var T=rect.top;
this.box.style.display="block";
if((x-L)>this.minWidth){
this.box.style.width=(x-L)+"px";
}
if((y-T)>this.minHeight){
this.box.style.height=(y-T)+"px";
}
};
nitobi.grid.GridResizer.prototype.endResize=function(){
var x=this.dd.x;
var y=this.dd.y;
this.box.style.display="none";
var _340=this.grid.getWidth();
var _341=this.grid.getHeight();
this.newWidth=Math.max(parseInt(_340)+(x-this.x),this.minWidth);
this.newHeight=Math.max(parseInt(_341)+(y-this.y),this.minHeight);
if(isNaN(this.newWidth)||isNaN(this.newHeight)){
return;
}
this.onAfterResize.notify(this);
};
nitobi.grid.GridResizer.prototype.dispose=function(){
this.grid=null;
};
nitobi.data.FormatConverter={};
nitobi.data.FormatConverter.convertHtmlTableToEbaXml=function(_342,_343,_344){
var s="<xsl:stylesheet version=\"1.0\" xmlns:ntb=\"http://www.nitobi.com\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output encoding=\"UTF-8\" method=\"xml\" omit-xml-declaration=\"no\" />";
s+="<xsl:template match=\"//TABLE\"><ntb:data id=\"_default\">";
s+="<xsl:apply-templates /></ntb:data> </xsl:template>";
s+="<xsl:template match = \"//TR\">  <xsl:element name=\"ntb:e\"> <xsl:attribute name=\"xi\"><xsl:value-of select=\"position()-1+"+parseInt(_344)+"\"/></xsl:attribute>";
for(var _346=0;_346<_343.length;_346++){
s+="<xsl:attribute name=\""+_343[_346]+"\" ><xsl:value-of select=\"TD["+parseInt(_346+1)+"]\"/></xsl:attribute>";
}
s+="</xsl:element></xsl:template>";
s+="</xsl:stylesheet>";
var _347=nitobi.xml.createXmlDoc(_342);
var _348=nitobi.xml.createXslProcessor(s);
var _349=nitobi.xml.transformToXml(_347,_348);
return _349;
};
nitobi.data.FormatConverter.convertTsvToEbaXml=function(tsv,_34b,_34c){
if(!nitobi.browser.IE&&tsv[tsv.length-1]!="\n"){
tsv=tsv+"\n";
}
var _34d="<TABLE><TBODY>"+tsv.replace(/[\&\r]/g,"").replace(/([^\t\n]*)[\t]/g,"<TD>$1</TD>").replace(/([^\n]*?)\n/g,"<TR>$1</TR>").replace(/\>([^\<]*)\<\/TR/g,"><TD>$1</TD></TR")+"</TBODY></TABLE>";
if(_34d.indexOf("<TBODY><TR>")==-1){
_34d=_34d.replace(/TBODY\>(.*)\<\/TBODY/,"TBODY><TR><TD>$1</TD></TR></TBODY");
}
return nitobi.data.FormatConverter.convertHtmlTableToEbaXml(_34d,_34b,_34c);
};
nitobi.data.FormatConverter.convertTsvToJs=function(tsv){
var _34f="["+tsv.replace(/[\&\r]/g,"").replace(/([^\t\n]*)[\t]/g,"$1\",\"").replace(/([^\n]*?)\n/g,"[\"$1\"],")+"]";
return _34f;
};
nitobi.data.FormatConverter.convertEbaXmlToHtmlTable=function(_350,_351,_352,_353){
var s="<xsl:stylesheet version=\"1.0\" xmlns:ntb=\"http://www.nitobi.com\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output encoding=\"UTF-8\" method=\"html\" omit-xml-declaration=\"yes\" /><xsl:template match = \"*\"><xsl:apply-templates /></xsl:template><xsl:template match = \"/\">";
s+="<TABLE><TBODY><xsl:for-each select=\"//ntb:e[@xi>"+parseInt(_352-1)+" and @xi &lt; "+parseInt(_353+1)+"]\" ><TR>";
for(var _355=0;_355<_351.length;_355++){
s+="<TD><xsl:value-of select=\"@"+_351[_355]+"\" /></TD>";
}
s+="</TR></xsl:for-each></TBODY></TABLE></xsl:template></xsl:stylesheet>";
var _356=nitobi.xml.createXslProcessor(s);
return nitobi.xml.transformToXml(_350,_356).xml.replace(/xmlns:ntb="http:\/\/www.nitobi.com"/,"");
};
nitobi.data.FormatConverter.convertEbaXmlToTsv=function(_357,_358,_359,_35a){
var s="<xsl:stylesheet version=\"1.0\" xmlns:ntb=\"http://www.nitobi.com\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output encoding=\"UTF-8\" method=\"text\" omit-xml-declaration=\"yes\" /><xsl:template match = \"*\"><xsl:apply-templates /></xsl:template><xsl:template match = \"/\">";
s+="<xsl:for-each select=\"//ntb:e[@xi>"+parseInt(_359-1)+" and @xi &lt; "+parseInt(_35a+1)+"]\" >\n";
for(var _35c=0;_35c<_358.length;_35c++){
s+="<xsl:value-of select=\"@"+_358[_35c]+"\" />";
if(_35c<_358.length-1){
s+="<xsl:text>&#x09;</xsl:text>";
}
}
s+="<xsl:text>&#xa;</xsl:text></xsl:for-each></xsl:template></xsl:stylesheet>";
var _35d=nitobi.xml.createXslProcessor(s);
return nitobi.xml.transformToString(_357,_35d).replace(/xmlns:ntb="http:\/\/www.nitobi.com"/,"");
};
nitobi.data.FormatConverter.getDataColumns=function(data){
var _35f=0;
if(data!=null&&data!=""){
if(data.substr(0,1)=="<"){
_35f=data.toLowerCase().substr(0,data.toLowerCase().indexOf("</tr>")).split("</td>").length-1;
}else{
_35f=data.substr(0,data.indexOf("\n")).split("\t").length;
}
}else{
_35f=0;
}
return _35f;
};
nitobi.data.FormatConverter.getDataRows=function(data){
var _361=0;
if(data!=null&&data!=""){
if(data.substr(0,1)=="<"){
_361=data.toLowerCase().split("</tr>").length-1;
}else{
retValArray=data.split("\n");
_361=retValArray.length;
if(retValArray[retValArray.length-1]==""){
_361--;
}
}
}else{
_361=0;
}
return _361;
};
nitobi.grid.DateColumn=function(grid,_363){
nitobi.grid.DateColumn.baseConstructor.call(this,grid,_363);
};
nitobi.lang.extend(nitobi.grid.DateColumn,nitobi.grid.Column);
var ntb_datep=nitobi.grid.DateColumn.prototype;
nitobi.grid.DateColumn.prototype.setMask=function(){
this.xSET("Mask",arguments);
};
nitobi.grid.DateColumn.prototype.getMask=function(){
return this.xGET("Mask",arguments);
};
nitobi.grid.DateColumn.prototype.setCalendarEnabled=function(){
this.xSET("CalendarEnabled",arguments);
};
nitobi.grid.DateColumn.prototype.isCalendarEnabled=function(){
return nitobi.lang.toBool(this.xGET("CalendarEnabled",arguments),false);
};
nitobi.lang.defineNs("nitobi.grid.Declaration");
nitobi.grid.Declaration.parse=function(_364){
var _365={};
_365.grid=nitobi.xml.parseHtml(_364);
ntbAssert(!nitobi.xml.hasParseError(_365.grid),"The framework was not able to parse the declaration.\n"+"\n\nThe parse error was: "+nitobi.xml.getParseErrorReason(_365.grid)+"The declaration contents where:\n"+nitobi.html.getOuterHtml(_364),"",EBA_THROW);
var _366=_364.firstChild;
while(_366!=null){
if(typeof (_366.tagName)!="undefined"){
var tag=_366.tagName.replace(/ntb\:/gi,"").toLowerCase();
if(tag=="inlinehtml"){
_365[tag]=_366;
}else{
var _368="http://www.nitobi.com";
if(tag=="columndefinition"){
var sXml;
if(nitobi.browser.IE){
sXml=("<"+nitobi.xml.nsPrefix+"grid xmlns:ntb=\""+_368+"\"><"+nitobi.xml.nsPrefix+"columns>"+_366.parentNode.innerHTML.substring(31).replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")+"</"+nitobi.xml.nsPrefix+"columns></"+nitobi.xml.nsPrefix+"grid>");
}else{
sXml="<"+nitobi.xml.nsPrefix+"grid xmlns:ntb=\""+_368+"\"><"+nitobi.xml.nsPrefix+"columns>"+_366.parentNode.innerHTML.replace(/\=\s*([^\"^\s^\>]+)/g,"=\"$1\" ")+"</"+nitobi.xml.nsPrefix+"columns></"+nitobi.xml.nsPrefix+"grid>";
}
sXml=sXml.replace(/\&nbsp\;/gi," ");
_365["columndefinitions"]=nitobi.xml.createXmlDoc();
_365["columndefinitions"].validateOnParse=false;
_365["columndefinitions"]=nitobi.xml.loadXml(_365["columndefinitions"],sXml);
break;
}else{
_365[tag]=nitobi.xml.parseHtml(_366);
}
}
}
_366=_366.nextSibling;
}
return _365;
};
nitobi.grid.Declaration.loadDataSources=function(_36a,grid){
var _36c=new Array();
if(_36a["datasources"]){
_36c=_36a.datasources.selectNodes("//"+nitobi.xml.nsPrefix+"datasources/*");
}
if(_36c.length>0){
for(var i=0;i<_36c.length;i++){
var id=_36c[i].getAttribute("id");
if(id!="_default"){
var _36f=_36c[i].xml.replace(/fieldnames=/g,"FieldNames=").replace(/keys=/g,"Keys=");
_36f="<ntb:grid xmlns:ntb=\"http://www.nitobi.com\"><ntb:datasources>"+_36f+"</ntb:datasources></ntb:grid>";
var _370=new nitobi.data.DataTable("local",grid.getPagingMode()!=nitobi.grid.PAGINGMODE_NONE,{GridId:grid.getID()},{GridId:grid.getID()},grid.isAutoKeyEnabled());
_370.initialize(id,_36f);
_370.initializeXml(_36f);
grid.data.add(_370);
var _371=grid.model.selectNodes("//nitobi.grid.Column[@DatasourceId='"+id+"']");
for(var j=0;j<_371.length;j++){
grid.editorDataReady(_371[j]);
}
}
}
}
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.EditCompleteEventArgs=function(obj,_374,_375,cell){
this.editor=obj;
this.cell=cell;
this.databaseValue=_375;
this.displayValue=_374;
};
nitobi.grid.EditCompleteEventArgs.prototype.dispose=function(){
this.editor=null;
this.cell=null;
this.metadata=null;
};
nitobi.data.GetCompleteEventArgs=function(_377,_378,_379,_37a,_37b,_37c,obj,_37e,_37f){
this.firstRow=_377;
this.lastRow=_378;
this.callback=_37e;
this.dataSource=_37c;
this.context=obj;
this.ajaxCallback=_37b;
this.startXi=_379;
this.pageSize=_37a;
this.lastPage=false;
this.numRowsReturned=_37f;
this.lastRowReturned=_378;
};
nitobi.data.GetCompleteEventArgs.prototype.dispose=function(){
this.callback=null;
this.context=null;
this.dataSource=null;
this.ajaxCallback.clear();
this.ajaxCallback==null;
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.MODE_STANDARDPAGING="standard";
nitobi.grid.MODE_LOCALSTANDARDPAGING="localstandard";
nitobi.grid.MODE_LIVESCROLLING="livescrolling";
nitobi.grid.MODE_LOCALLIVESCROLLING="locallivescrolling";
nitobi.grid.MODE_NONPAGING="nonpaging";
nitobi.grid.MODE_LOCALNONPAGING="localnonpaging";
nitobi.grid.MODE_PAGEDLIVESCROLLING="pagedlivescrolling";
nitobi.grid.RENDERMODE_ONDEMAND="ondemand";
nitobi.lang.defineNs("nitobi.GridFactory");
nitobi.GridFactory.createGrid=function(_380,_381,_382){
var _383="";
var _384="";
var _385="";
_382=nitobi.html.getElement(_382);
if(_382!=null){
xDeclaration=nitobi.grid.Declaration.parse(_382);
_380=xDeclaration.grid.documentElement.getAttribute("mode").toLowerCase();
var _386=nitobi.GridFactory.isGetHandler(xDeclaration);
var _387=nitobi.GridFactory.isDatasourceId(xDeclaration);
var _388=false;
if(_380==nitobi.grid.MODE_LOCALLIVESCROLLING){
ntbAssert(_387||_386,"To use local LiveScrolling mode a DatasourceId must also be specified.","",EBA_THROW);
_383=nitobi.grid.PAGINGMODE_LIVESCROLLING;
_384=nitobi.data.DATAMODE_LOCAL;
}else{
if(_380==nitobi.grid.MODE_LIVESCROLLING){
ntbAssert(_386,"To use LiveScrolling mode a GetHandler must also be specified.","",EBA_THROW);
_383=nitobi.grid.PAGINGMODE_LIVESCROLLING;
_384=nitobi.data.DATAMODE_CACHING;
}else{
if(_380==nitobi.grid.MODE_NONPAGING){
ntbAssert(_386,"To use NonPaging mode a GetHandler must also be specified.","",EBA_THROW);
_388=true;
_383=nitobi.grid.PAGINGMODE_NONE;
_384=nitobi.data.DATAMODE_LOCAL;
}else{
if(_380==nitobi.grid.MODE_LOCALNONPAGING){
ntbAssert(_387,"To use local LiveScrolling mode a DatasourceId must also be specified.","",EBA_THROW);
_383=nitobi.grid.PAGINGMODE_NONE;
_384=nitobi.data.DATAMODE_LOCAL;
}else{
if(_380==nitobi.grid.MODE_LOCALSTANDARDPAGING){
_383=nitobi.grid.PAGINGMODE_STANDARD;
_384=nitobi.data.DATAMODE_LOCAL;
}else{
if(_380==nitobi.grid.MODE_STANDARDPAGING){
_383=nitobi.grid.PAGINGMODE_STANDARD;
_384=nitobi.data.DATAMODE_PAGING;
}else{
if(_380==nitobi.grid.MODE_PAGEDLIVESCROLLING){
_383=nitobi.grid.PAGINGMODE_STANDARD;
_384=nitobi.data.DATAMODE_PAGING;
_385=nitobi.grid.RENDERMODE_ONDEMAND;
}else{
}
}
}
}
}
}
}
}
var id=_382.getAttribute("id");
_380=(_380||nitobi.grid.MODE_STANDARDPAGING).toLowerCase();
var grid=null;
if(_380==nitobi.grid.MODE_LOCALSTANDARDPAGING){
grid=new nitobi.grid.GridLocalPage(id);
}else{
if(_380==nitobi.grid.MODE_LIVESCROLLING){
grid=new nitobi.grid.GridLiveScrolling(id);
}else{
if(_380==nitobi.grid.MODE_LOCALLIVESCROLLING){
grid=new nitobi.grid.GridLiveScrolling(id);
}else{
if(_380==nitobi.grid.MODE_NONPAGING||_380==nitobi.grid.MODE_LOCALNONPAGING){
grid=new nitobi.grid.GridNonpaging(id);
}else{
if(_380==nitobi.grid.MODE_STANDARDPAGING||_380==nitobi.grid.MODE_PAGEDLIVESCROLLING){
grid=new nitobi.grid.GridStandard(id);
}
}
}
}
}
grid.setPagingMode(_383);
grid.setDataMode(_384);
grid.setRenderMode(_385);
nitobi.GridFactory.processDeclaration(grid,_382,xDeclaration);
_382.jsObject=grid;
return grid;
};
nitobi.GridFactory.processDeclaration=function(grid,_38c,_38d){
if(_38d!=null){
grid.setDeclaration(_38d);
if(typeof (_38d.inlinehtml)=="undefined"){
var _38e=document.createElement("ntb:inlinehtml");
_38e.setAttribute("parentid","grid"+grid.uid);
nitobi.html.insertAdjacentElement(_38c,"beforeEnd",_38e);
grid.Declaration.inlinehtml=_38e;
}
if(this.data==null||this.data.tables==null||this.data.tables.length==0){
var _38f=new nitobi.data.DataSet();
_38f.initialize();
grid.connectToDataSet(_38f);
}
grid.initializeModelFromDeclaration();
var _390=grid.Declaration.columndefinitions||grid.Declaration.columns;
if(typeof (_390)!="undefined"&&_390!=null&&_390.childNodes.length!=0&&_390.childNodes[0].childNodes.length!=0){
grid.defineColumns(_390.documentElement);
}
nitobi.grid.Declaration.loadDataSources(_38d,grid);
grid.attachToParentDomElement(grid.Declaration.inlinehtml);
var _391=grid.getDataMode();
var _392=grid.getDatasourceId();
var _393=grid.getGetHandler();
if(_392!=null&&_392!=""){
grid.connectToTable(grid.data.getTable(_392));
}else{
grid.ensureConnected();
if(grid.mode.toLowerCase()==nitobi.grid.MODE_LIVESCROLLING&&_38d!=null&&_38d.datasources!=null){
var _394=_38d.datasources.selectNodes("//ntb:datasource[@id='_default']/ntb:data/ntb:e").length;
if(_394>0){
var _395=grid.data.getTable("_default");
_395.initializeXmlData(_38d.grid.xml);
_395.initializeXml(_38d.grid.xml);
_395.descriptor.leap(0,_394*2);
_395.syncRowCount();
}
}
}
window.setTimeout(function(){
grid.bind();
},50);
}
};
nitobi.GridFactory.isLocal=function(_396){
var _397=_396.grid.documentElement.getAttribute("datasourceid");
var _398=_396.grid.documentElement.getAttribute("gethandler");
if(_398!=null&&_398!=""){
return false;
}else{
if(_397!=null&&_397!=""){
return true;
}else{
throw ("Non-paging grid requires either a gethandler or a local datasourceid to be specified.");
}
}
};
nitobi.GridFactory.isGetHandler=function(_399){
var _39a=_399.grid.documentElement.getAttribute("gethandler");
if(_39a!=null&&_39a!=""){
return true;
}
return false;
};
nitobi.GridFactory.isDatasourceId=function(_39b){
var _39c=_39b.grid.documentElement.getAttribute("datasourceid");
if(_39c!=null&&_39c!=""){
return true;
}
return false;
};
nitobi.grid.hover=function(_39d,_39e,_39f){
if(!_39f){
return;
}
var id=_39d.getAttribute("id");
var _3a1=id.replace(/__/g,"||");
var _3a2=_3a1.split("_");
var row=_3a2[3];
var uid=_3a2[5].replace(/\|\|/g,"__");
var _3a5=document.getElementById("cell_"+row+"_0_"+uid);
var _3a6=_3a5.parentNode;
var _3a7=_3a6.childNodes[_3a6.childNodes.length-1];
var id=_3a7.getAttribute("id");
var _3a2=id.split("_");
var _3a8=document.getElementById("cell_"+row+"_"+(Number(_3a2[4])+1)+"_"+uid);
var _3a9=null;
if(_3a8!=null){
_3a9=_3a8.parentNode;
}
if(_39e){
var _3aa=nitobi.grid.RowHoverColor||"white";
_3a6.style.backgroundColor=_3aa;
if(_3a9){
_3a9.style.backgroundColor=_3aa;
}
}else{
_3a6.style.backgroundColor="";
if(_3a9){
_3a9.style.backgroundColor="";
}
}
if(_39e){
nitobi.html.addClass(_39d,"ntb-cell-hover");
}else{
nitobi.html.removeClass(_39d,"ntb-cell-hover");
}
};
initEBAGrids=function(){
nitobi.initComponents();
};
nitobi.initGrids=function(){
var _3ab=[];
var _3ac=document.getElementsByTagName(!nitobi.browser.IE?"ntb:grid":"grid");
for(var i=0;i<_3ac.length;i++){
if(_3ac[i].jsObject==null){
nitobi.initGrid(_3ac[i].id);
_3ab.push(_3ac[i].jsObject);
}
}
return _3ab;
};
nitobi.initGrid=function(id){
var grid=nitobi.html.getElement(id);
if(grid!=null){
grid.jsObject=nitobi.GridFactory.createGrid(null,null,grid);
}
return grid.jsObject;
};
nitobi.initComponents=function(){
nitobi.initGrids();
};
nitobi.getGrid=function(_3b0){
return document.getElementById(_3b0).jsObject;
};
nitobi.base.Registry.getInstance().register(new nitobi.base.Profile("nitobi.initGrid",null,false,"ntb:grid"));
nitobi.grid.GridLiveScrolling=function(uid){
nitobi.grid.GridLiveScrolling.baseConstructor.call(this,uid);
this.mode="livescrolling";
this.setPagingMode(nitobi.grid.PAGINGMODE_LIVESCROLLING);
this.setDataMode(nitobi.data.DATAMODE_CACHING);
};
nitobi.lang.extend(nitobi.grid.GridLiveScrolling,nitobi.grid.Grid);
nitobi.grid.GridLiveScrolling.prototype.createChildren=function(){
var args=arguments;
nitobi.grid.GridLiveScrolling.base.createChildren.call(this,args);
nitobi.grid.GridLiveScrolling.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD);
};
nitobi.grid.GridLiveScrolling.prototype.bind=function(){
nitobi.grid.GridStandard.base.bind.call(this);
if(this.getGetHandler()!=""){
this.ensureConnected();
var rows=this.getRowsPerPage();
if(this.datatable.mode=="local"){
rows=null;
}
this.datatable.get(0,rows,this,this.getComplete);
}else{
this.finalizeRowCount(this.datatable.getRemoteRowCount());
this.bindComplete();
}
};
nitobi.grid.GridLiveScrolling.prototype.getComplete=function(_3b4){
nitobi.grid.GridLiveScrolling.base.getComplete.call(this,_3b4);
if(!this.columnsDefined){
this.defineColumnsFinalize();
}
this.bindComplete();
};
nitobi.grid.GridLiveScrolling.prototype.pageSelect=function(dir){
var _3b6=this.Scroller.getUnrenderedBlocks();
var rows=_3b6.last-_3b6.first;
this.reselect(0,rows*dir);
};
nitobi.grid.GridLiveScrolling.prototype.page=function(dir){
var _3b9=this.Scroller.getUnrenderedBlocks();
var rows=_3b9.last-_3b9.first;
this.move(0,rows*dir);
};
nitobi.grid.LoadingScreen=function(grid){
this.loadingScreen=null;
this.grid=grid;
this.loadingImg=null;
};
nitobi.grid.LoadingScreen.prototype.initialize=function(){
this.loadingScreen=document.createElement("div");
var _3bc=this.findCssUrl();
var msg="";
if(_3bc==null){
msg="Loading...";
}else{
msg="<img src='"+_3bc+"loading.gif'  class='ntb-loading-Icon' valign='absmiddle'></img>";
}
this.loadingScreen.innerHTML="<table style='padding:0px;margin:0px;' border='0' width='100%' height='100%'><tr style='padding:0px;margin:0px;'><td style='padding:0px;margin:0px;text-align:center;font:verdana;font-size:10pt;'>"+msg+"</td></tr></table>";
this.loadingScreen.className="ntb-loading";
var lss=this.loadingScreen.style;
lss.verticalAlign="middle";
lss.visibility="hidden";
lss.position="absolute";
lss.top="0px";
lss.left="0px";
};
nitobi.grid.LoadingScreen.prototype.attachToElement=function(_3bf){
_3bf.appendChild(this.loadingScreen);
};
nitobi.grid.LoadingScreen.prototype.findCssUrl=function(){
var _3c0=nitobi.html.findParentStylesheet("."+this.grid.getTheme()+" .ntb-loading-Icon");
if(_3c0==null){
return null;
}
var _3c1=nitobi.html.normalizeUrl(_3c0.href);
if(nitobi.browser.IE){
while(_3c0.parentStyleSheet){
_3c0=_3c0.parentStyleSheet;
_3c1=nitobi.html.normalizeUrl(_3c0.href)+_3c1;
}
}
return _3c1;
};
nitobi.grid.LoadingScreen.prototype.show=function(){
try{
this.resize();
this.loadingScreen.style.visibility="visible";
this.loadingScreen.style.display="block";
}
catch(e){
}
};
nitobi.grid.LoadingScreen.prototype.resize=function(){
this.loadingScreen.style.width=this.grid.getWidth()+"px";
this.loadingScreen.style.height=this.grid.getHeight()+"px";
};
nitobi.grid.LoadingScreen.prototype.hide=function(){
this.loadingScreen.style.display="none";
};
nitobi.grid.GridLocalPage=function(uid){
nitobi.grid.GridLocalPage.baseConstructor.call(this,uid);
this.mode="localpaging";
this.setPagingMode(nitobi.grid.PAGINGMODE_STANDARD);
this.setDataMode("local");
};
nitobi.lang.extend(nitobi.grid.GridLocalPage,nitobi.grid.Grid);
nitobi.grid.GridLocalPage.prototype.createChildren=function(){
var args=arguments;
nitobi.grid.GridLocalPage.base.createChildren.call(this,args);
nitobi.grid.GridLiveScrolling.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD|nitobi.ui.Toolbars.VisibleToolbars.PAGING);
this.toolbars.subscribe("NextPage",nitobi.lang.close(this,this.pageNext));
this.toolbars.subscribe("PreviousPage",nitobi.lang.close(this,this.pagePrevious));
this.subscribe("EndOfData",function(pct){
this.toolbars.pagingToolbar.getUiElements()["nextPage"+this.toolbars.uid].disable();
});
this.subscribe("TopOfData",function(pct){
this.toolbars.pagingToolbar.getUiElements()["previousPage"+this.toolbars.uid].disable();
});
this.subscribe("NotTopOfData",function(pct){
this.toolbars.pagingToolbar.getUiElements()["previousPage"+this.toolbars.uid].enable();
});
this.subscribe("NotEndOfData",function(pct){
this.toolbars.pagingToolbar.getUiElements()["nextPage"+this.toolbars.uid].enable();
});
};
nitobi.grid.GridLocalPage.prototype.pagePrevious=function(){
this.fire("BeforeLoadPreviousPage");
this.loadDataPage(Math.max(this.getCurrentPageIndex()-1,0));
this.fire("AfterLoadPreviousPage");
};
nitobi.grid.GridLocalPage.prototype.pageNext=function(){
this.fire("BeforeLoadNextPage");
this.loadDataPage(this.getCurrentPageIndex()+1);
this.fire("AfterLoadNextPage");
};
nitobi.grid.GridLocalPage.prototype.loadDataPage=function(_3c8){
this.fire("BeforeLoadDataPage");
if(_3c8>-1){
this.setCurrentPageIndex(_3c8);
this.setDisplayedRowCount(this.getRowsPerPage());
var _3c9=this.getCurrentPageIndex()*this.getRowsPerPage();
var rows=this.getRowsPerPage()-this.getfreezetop();
this.setDisplayedRowCount(rows);
var _3cb=_3c9+rows;
if(_3cb>=this.getRowCount()){
this.fire("EndOfData");
}else{
this.fire("NotEndOfData");
}
if(_3c9==0){
this.fire("TopOfData");
}else{
this.fire("NotTopOfData");
}
this.clearSurfaces();
this.updateCellRanges();
this.scrollVertical(0);
}
this.fire("AfterLoadDataPage");
};
nitobi.grid.GridLocalPage.prototype.setRowsPerPage=function(rows){
this.setDisplayedRowCount(this.getRowsPerPage());
this.data.table.pageSize=this.getRowsPerPage();
};
nitobi.grid.GridLocalPage.prototype.pageStartIndexChanges=function(){
};
nitobi.grid.GridLocalPage.prototype.hitFirstPage=function(){
this.fire("FirstPage");
};
nitobi.grid.GridLocalPage.prototype.hitLastPage=function(){
this.fire("LastPage");
};
nitobi.grid.GridLocalPage.prototype.bind=function(){
nitobi.grid.GridLocalPage.base.bind.call(this);
this.finalizeRowCount(this.datatable.getRemoteRowCount());
this.bindComplete();
};
nitobi.grid.GridLocalPage.prototype.pageUpKey=function(){
this.pagePrevious();
};
nitobi.grid.GridLocalPage.prototype.pageDownKey=function(){
this.pageNext();
};
nitobi.grid.GridLocalPage.prototype.renderMiddle=function(){
nitobi.grid.GridLocalPage.base.renderMiddle.call(this,arguments);
var _3cd=this.getfreezetop();
endRow=this.getRowsPerPage()-1;
this.Scroller.view.midcenter.renderGap(_3cd,endRow,false);
};
nitobi.grid.GridNonpaging=function(uid){
nitobi.grid.GridNonpaging.baseConstructor.call(this);
this.mode="nonpaging";
this.setPagingMode(nitobi.grid.PAGINGMODE_NONE);
this.setDataMode(nitobi.data.DATAMODE_LOCAL);
};
nitobi.lang.extend(nitobi.grid.GridNonpaging,nitobi.grid.Grid);
nitobi.grid.GridNonpaging.prototype.createChildren=function(){
var args=arguments;
nitobi.grid.GridNonpaging.base.createChildren.call(this,args);
nitobi.grid.GridNonpaging.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD);
};
nitobi.grid.GridNonpaging.prototype.bind=function(){
nitobi.grid.GridStandard.base.bind.call(this);
if(this.getGetHandler()!=""){
this.ensureConnected();
this.datatable.get(0,null,this,this.getComplete);
}else{
this.finalizeRowCount(this.datatable.getRemoteRowCount());
this.bindComplete();
}
};
nitobi.grid.GridNonpaging.prototype.getComplete=function(_3d0){
nitobi.grid.GridNonpaging.base.getComplete.call(this,_3d0);
this.finalizeRowCount(_3d0.numRowsReturned);
this.defineColumnsFinalize();
this.bindComplete();
};
nitobi.grid.GridNonpaging.prototype.renderMiddle=function(){
nitobi.grid.GridNonpaging.base.renderMiddle.call(this,arguments);
var _3d1=this.getfreezetop();
endRow=this.getRowCount();
this.Scroller.view.midcenter.renderGap(_3d1,endRow,false);
};
nitobi.grid.GridStandard=function(uid){
nitobi.grid.GridStandard.baseConstructor.call(this,uid);
this.mode="standard";
this.setPagingMode(nitobi.grid.PAGINGMODE_STANDARD);
this.setDataMode(nitobi.data.DATAMODE_PAGING);
};
nitobi.lang.extend(nitobi.grid.GridStandard,nitobi.grid.Grid);
nitobi.grid.GridStandard.prototype.createChildren=function(){
var args=arguments;
nitobi.grid.GridStandard.base.createChildren.call(this,args);
nitobi.grid.GridStandard.base.createToolbars.call(this,nitobi.ui.Toolbars.VisibleToolbars.STANDARD|nitobi.ui.Toolbars.VisibleToolbars.PAGING);
this.toolbars.subscribe("FirstPage",nitobi.lang.close(this,this.pageFirst));
this.toolbars.subscribe("LastPage",nitobi.lang.close(this,this.pageLast));
this.toolbars.subscribe("NextPage",nitobi.lang.close(this,this.pageNext));
this.toolbars.subscribe("PreviousPage",nitobi.lang.close(this,this.pagePrevious));
this.toolbars.subscribe("InputTextPage",nitobi.lang.close(this,this.pageTextInput));
this.subscribe("EndOfData",this.disableNextPage);
this.subscribe("TopOfData",this.disablePreviousPage);
this.subscribe("NotTopOfData",this.enablePreviousPage);
this.subscribe("NotEndOfData",this.enableNextPage);
this.subscribe("TableConnected",nitobi.lang.close(this,this.subscribeToRowCountReady));
};
nitobi.grid.GridStandard.prototype.connectToTable=function(_3d4){
if(nitobi.grid.GridStandard.base.connectToTable.call(this,_3d4)!=false){
this.datatable.subscribe("RowInserted",nitobi.lang.close(this,this.incrementDisplayedRowCount));
this.datatable.subscribe("RowDeleted",nitobi.lang.close(this,this.decrementDisplayedRowCount));
}
};
nitobi.grid.GridStandard.prototype.incrementDisplayedRowCount=function(_3d5){
this.setDisplayedRowCount(this.getDisplayedRowCount()+(_3d5||1));
this.updateCellRanges();
};
nitobi.grid.GridStandard.prototype.decrementDisplayedRowCount=function(_3d6){
this.setDisplayedRowCount(this.getDisplayedRowCount()-(_3d6||1));
this.updateCellRanges();
};
nitobi.grid.GridStandard.prototype.subscribeToRowCountReady=function(){
};
nitobi.grid.GridStandard.prototype.updateDisplayedRowCount=function(_3d7){
this.setDisplayedRowCount(_3d7.numRowsReturned);
};
nitobi.grid.GridStandard.prototype.disableNextPage=function(){
this.disableButton("nextPage");
};
nitobi.grid.GridStandard.prototype.disablePreviousPage=function(){
this.disableButton("previousPage");
};
nitobi.grid.GridStandard.prototype.disableButton=function(_3d8){
var t=this.getToolbars().pagingToolbar;
if(t!=null){
t.getUiElements()[_3d8+this.toolbars.uid].disable();
}
};
nitobi.grid.GridStandard.prototype.enableNextPage=function(){
this.enableButton("nextPage");
};
nitobi.grid.GridStandard.prototype.enablePreviousPage=function(){
this.enableButton("previousPage");
};
nitobi.grid.GridStandard.prototype.enableButton=function(_3da){
var t=this.getToolbars().pagingToolbar;
if(t!=null){
t.getUiElements()[_3da+this.toolbars.uid].enable();
}
};
nitobi.grid.GridStandard.prototype.pageFirst=function(){
this.fire("BeforeLoadPreviousPage");
this.loadDataPage(0);
this.fire("AfterLoadPreviousPage");
};
nitobi.grid.GridStandard.prototype.pagePrevious=function(){
this.fire("BeforeLoadPreviousPage");
this.loadDataPage(Math.max(this.getCurrentPageIndex()-1,0));
this.fire("AfterLoadPreviousPage");
};
nitobi.grid.GridStandard.prototype.pageNext=function(){
this.fire("BeforeLoadNextPage");
this.loadDataPage(this.getCurrentPageIndex()+1);
this.fire("AfterLoadNextPage");
};
nitobi.grid.GridStandard.prototype.pageLast=function(){
this.fire("BeforeLoadNextPage");
var _3dc=Math.ceil(this.datatable.totalRowCount/this.getRowsPerPage());
this.loadDataPage(_3dc-1);
this.fire("AfterLoadNextPage");
};
nitobi.grid.GridStandard.prototype.pageTextInput=function(){
this.fire("BeforeLoadNextPage");
var _3dd=$ntb("startPage"+this.toolbars.uid);
if(_3dd){
var val=parseInt(_3dd.value);
this.loadDataPage(val-1);
}
this.fire("AfterLoadNextPage");
};
nitobi.grid.GridStandard.prototype.loadDataPage=function(_3df){
this.fire("BeforeLoadDataPage");
if(_3df>-1){
if(this.sortColumn){
if(this.datatable.sortColumn){
for(var i=0;i<this.getColumnCount();i++){
var _3e1=this.getColumnObject(i);
if(_3e1.getColumnName()==this.datatable.sortColumn){
this.setSortStyle(i,this.datatable.sortDir);
break;
}
}
}else{
this.setSortStyle(this.sortColumn.column,"",true);
}
}
this.setCurrentPageIndex(_3df);
var _3e2=this.getCurrentPageIndex()*this.getRowsPerPage();
var rows=this.getRowsPerPage()-this.getfreezetop();
this.datatable.flush();
this.datatable.get(_3e2,rows,this,this.afterLoadDataPage);
}
this.fire("AfterLoadDataPage");
};
nitobi.grid.GridStandard.prototype.afterLoadDataPage=function(_3e4){
this.setDisplayedRowCount(_3e4.numRowsReturned);
this.setRowCount(_3e4.numRowsReturned);
if(_3e4.numRowsReturned!=this.getRowsPerPage()){
this.fire("EndOfData");
}else{
if((_3e4.lastRow+1)==this.datatable.getTotalRowCount()){
this.fire("EndOfData");
}else{
this.fire("NotEndOfData");
}
}
if(this.getCurrentPageIndex()==0){
this.fire("TopOfData");
}else{
this.fire("NotTopOfData");
}
this.clearSurfaces();
this.updateCellRanges();
this.scrollVertical(0);
};
nitobi.grid.GridStandard.prototype.bind=function(){
nitobi.grid.GridStandard.base.bind.call(this);
this.setCurrentPageIndex(0);
this.disablePreviousPage();
this.enableNextPage();
this.ensureConnected();
this.datatable.get(0,this.getRowsPerPage(),this,this.getComplete);
};
nitobi.grid.GridStandard.prototype.getComplete=function(_3e5){
this.afterLoadDataPage(_3e5);
nitobi.grid.GridStandard.base.getComplete.call(this,_3e5);
this.defineColumnsFinalize();
this.bindComplete();
};
nitobi.grid.GridStandard.prototype.renderMiddle=function(){
nitobi.grid.GridStandard.base.renderMiddle.call(this,arguments);
var _3e6=this.getfreezetop();
endRow=this.getRowsPerPage()-1;
this.Scroller.view.midcenter.renderGap(_3e6,endRow,false);
};
nitobi.grid.NumberColumn=function(grid,_3e8){
nitobi.grid.NumberColumn.baseConstructor.call(this,grid,_3e8);
};
nitobi.lang.extend(nitobi.grid.NumberColumn,nitobi.grid.Column);
var ntb_numberp=nitobi.grid.NumberColumn.prototype;
nitobi.grid.NumberColumn.prototype.setAlign=function(){
this.xSET("Align",arguments);
};
nitobi.grid.NumberColumn.prototype.getAlign=function(){
return this.xGET("Align",arguments);
};
nitobi.grid.NumberColumn.prototype.setMask=function(){
this.xSET("Mask",arguments);
};
nitobi.grid.NumberColumn.prototype.getMask=function(){
return this.xGET("Mask",arguments);
};
nitobi.grid.NumberColumn.prototype.setNegativeMask=function(){
this.xSET("NegativeMask",arguments);
};
nitobi.grid.NumberColumn.prototype.getNegativeMask=function(){
return this.xGET("NegativeMask",arguments);
};
nitobi.grid.NumberColumn.prototype.setGroupingSeparator=function(){
this.xSET("GroupingSeparator",arguments);
};
nitobi.grid.NumberColumn.prototype.getGroupingSeparator=function(){
return this.xGET("GroupingSeparator",arguments);
};
nitobi.grid.NumberColumn.prototype.setDecimalSeparator=function(){
this.xSET("DecimalSeparator",arguments);
};
nitobi.grid.NumberColumn.prototype.getDecimalSeparator=function(){
return this.xGET("DecimalSeparator",arguments);
};
nitobi.grid.NumberColumn.prototype.setOnKeyDownEvent=function(){
this.xSET("OnKeyDownEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.getOnKeyDownEvent=function(){
return this.xGET("OnKeyDownEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.setOnKeyUpEvent=function(){
this.xSET("OnKeyUpEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.getOnKeyUpEvent=function(){
return this.xGET("OnKeyUpEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.setOnKeyPressEvent=function(){
this.xSET("OnKeyPressEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.getOnKeyPressEvent=function(){
return this.xGET("OnKeyPressEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.setOnChangeEvent=function(){
this.xSET("OnChangeEvent",arguments);
};
nitobi.grid.NumberColumn.prototype.getOnChangeEvent=function(){
return this.xGET("OnChangeEvent",arguments);
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCopyEventArgs=function(_3e9,data,_3eb){
nitobi.grid.OnCopyEventArgs.baseConstructor.apply(this,arguments);
};
nitobi.lang.extend(nitobi.grid.OnCopyEventArgs,nitobi.grid.SelectionEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnPasteEventArgs=function(_3ec,data,_3ee){
nitobi.grid.OnPasteEventArgs.baseConstructor.apply(this,arguments);
};
nitobi.lang.extend(nitobi.grid.OnPasteEventArgs,nitobi.grid.SelectionEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnAfterCellEditEventArgs=function(_3ef,cell){
nitobi.grid.OnAfterCellEditEventArgs.baseConstructor.call(this,_3ef,cell);
};
nitobi.lang.extend(nitobi.grid.OnAfterCellEditEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnAfterColumnResizeEventArgs=function(_3f1,_3f2){
nitobi.grid.OnAfterColumnResizeEventArgs.baseConstructor.call(this,_3f1,_3f2);
};
nitobi.lang.extend(nitobi.grid.OnAfterColumnResizeEventArgs,nitobi.grid.ColumnEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnAfterRowDeleteEventArgs=function(_3f3,row){
nitobi.grid.OnAfterRowDeleteEventArgs.baseConstructor.call(this,_3f3,row);
};
nitobi.lang.extend(nitobi.grid.OnAfterRowDeleteEventArgs,nitobi.grid.RowEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnAfterRowInsertEventArgs=function(_3f5,row){
nitobi.grid.OnAfterRowInsertEventArgs.baseConstructor.call(this,_3f5,row);
};
nitobi.lang.extend(nitobi.grid.OnAfterRowInsertEventArgs,nitobi.grid.RowEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnAfterSortEventArgs=function(_3f7,_3f8,_3f9){
nitobi.grid.OnAfterSortEventArgs.baseConstructor.call(this,_3f7,_3f8);
this.direction=_3f9;
};
nitobi.lang.extend(nitobi.grid.OnAfterSortEventArgs,nitobi.grid.ColumnEventArgs);
nitobi.grid.OnAfterSortEventArgs.prototype.getDirection=function(){
return this.direction;
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeCellEditEventArgs=function(_3fa,cell){
nitobi.grid.OnBeforeCellEditEventArgs.baseConstructor.call(this,_3fa,cell);
};
nitobi.lang.extend(nitobi.grid.OnBeforeCellEditEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeColumnResizeEventArgs=function(_3fc,_3fd){
nitobi.grid.OnBeforeColumnResizeEventArgs.baseConstructor.call(this,_3fc,_3fd);
};
nitobi.lang.extend(nitobi.grid.OnBeforeColumnResizeEventArgs,nitobi.grid.ColumnEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeRowDeleteEventArgs=function(_3fe,row){
nitobi.grid.OnBeforeRowDeleteEventArgs.baseConstructor.call(this,_3fe,row);
};
nitobi.lang.extend(nitobi.grid.OnBeforeRowDeleteEventArgs,nitobi.grid.RowEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeRowInsertEventArgs=function(_400,row){
nitobi.grid.OnBeforeRowInsertEventArgs.baseConstructor.call(this,_400,row);
};
nitobi.lang.extend(nitobi.grid.OnBeforeRowInsertEventArgs,nitobi.grid.RowEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeSortEventArgs=function(_402,_403,_404){
nitobi.grid.OnBeforeSortEventArgs.baseConstructor.call(this,_402,_403);
this.direction=_404;
};
nitobi.lang.extend(nitobi.grid.OnBeforeSortEventArgs,nitobi.grid.ColumnEventArgs);
nitobi.grid.OnBeforeSortEventArgs.prototype.getDirection=function(){
return this.direction;
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnBeforeCellClickEventArgs=function(_405,cell){
nitobi.grid.OnBeforeCellClickEventArgs.baseConstructor.call(this,_405,cell);
};
nitobi.lang.extend(nitobi.grid.OnBeforeCellClickEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCellBlurEventArgs=function(_407,cell){
nitobi.grid.OnCellBlurEventArgs.baseConstructor.call(this,_407,cell);
};
nitobi.lang.extend(nitobi.grid.OnCellBlurEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCellClickEventArgs=function(_409,cell){
nitobi.grid.OnCellClickEventArgs.baseConstructor.call(this,_409,cell);
};
nitobi.lang.extend(nitobi.grid.OnCellClickEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCellDblClickEventArgs=function(_40b,cell){
nitobi.grid.OnCellDblClickEventArgs.baseConstructor.call(this,_40b,cell);
};
nitobi.lang.extend(nitobi.grid.OnCellDblClickEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCellFocusEventArgs=function(_40d,cell){
nitobi.grid.OnCellFocusEventArgs.baseConstructor.call(this,_40d,cell);
};
nitobi.lang.extend(nitobi.grid.OnCellFocusEventArgs,nitobi.grid.CellEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnCellValidateEventArgs=function(_40f,cell,_411,_412){
nitobi.grid.OnCellValidateEventArgs.baseConstructor.call(this,_40f,cell);
this.oldValue=_412;
this.newValue=_411;
};
nitobi.lang.extend(nitobi.grid.OnCellValidateEventArgs,nitobi.grid.CellEventArgs);
nitobi.grid.OnCellValidateEventArgs.prototype.getOldValue=function(){
return this.oldValue;
};
nitobi.grid.OnCellValidateEventArgs.prototype.getNewValue=function(){
return this.newValue;
};
nitobi.grid.OnContextMenuEventArgs=function(){
};
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnHeaderClickEventArgs=function(_413,_414){
nitobi.grid.OnHeaderClickEventArgs.baseConstructor.call(this,_413,_414);
};
nitobi.lang.extend(nitobi.grid.OnHeaderClickEventArgs,nitobi.grid.ColumnEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnRowBlurEventArgs=function(_415,row){
nitobi.grid.OnRowBlurEventArgs.baseConstructor.call(this,_415,row);
};
nitobi.lang.extend(nitobi.grid.OnRowBlurEventArgs,nitobi.grid.RowEventArgs);
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.OnRowFocusEventArgs=function(_417,row){
nitobi.grid.OnRowFocusEventArgs.baseConstructor.call(this,_417,row);
};
nitobi.lang.extend(nitobi.grid.OnRowFocusEventArgs,nitobi.grid.RowEventArgs);
nitobi.grid.Row=function(grid,row){
this.grid=grid;
this.row=row;
this.Row=row;
this.DomNode=nitobi.grid.Row.getRowElement(grid,row);
};
nitobi.grid.Row.prototype.getData=function(){
if(this.DataNode==null){
this.DataNode=this.grid.datatable.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xi="+this.Row+"]");
}
return this.DataNode;
};
nitobi.grid.Row.prototype.getStyle=function(){
return this.DomNode.style;
};
nitobi.grid.Row.prototype.getCell=function(_41b){
return this.grid.getCellObject(this.row,_41b);
};
nitobi.grid.Row.prototype.getKey=function(_41c){
return this.grid.getCellObject(this.row,_41c);
};
nitobi.grid.Row.getRowElement=function(grid,row){
return nitobi.grid.Row.getRowElements(grid,row).mid;
};
nitobi.grid.Row.getRowElements=function(grid,row){
var _421=grid.getFrozenLeftColumnCount();
if(!_421){
return {left:null,mid:$ntb("row_"+row+"_"+grid.uid)};
}
var C=nitobi.grid.Cell;
var rows={};
try{
var _424=C.getCellElement(grid,row,0);
if(_424){
rows.left=C.getCellElement(grid,row,0).parentNode;
var cell=C.getCellElement(grid,row,_421);
rows.mid=cell?cell.parentNode:null;
return rows;
}else{
return {left:null,mid:$ntb("row_"+row+"_"+grid.uid)};
}
}
catch(e){
}
};
nitobi.grid.Row.getRowNumber=function(_426){
return parseInt(_426.getAttribute("xi"));
};
nitobi.grid.Row.prototype.xGETMETA=function(){
var node=this.MetaNode;
node=node.selectSingleNode("@"+arguments[0]);
if(node!=null){
return node.value;
}
};
nitobi.grid.Row.prototype.xSETMETA=function(){
var node=this.MetaNode;
if(null==node){
var meta=this.grid.data.selectSingleNode("//root/gridmeta");
var _42a=this.MetaNode=this.grid.data.createNode(1,"r","");
_42a.setAttribute("xi",this.row);
meta.appendChild(_42a);
node=this.MetaNode=_42a;
}
if(node!=null){
node.setAttribute(arguments[0],arguments[1][0]);
}else{
alert("Cannot set property: "+arguments[0]);
}
};
nitobi.grid.RowRenderer=function(_42b,_42c,_42d,_42e,_42f,_430){
this.rowHeight=_42d;
this.xmlDataSource=_42b;
this.dataTableId="";
this.firstColumn=_42e;
this.columns=_42f;
this.firstColumn=_42e;
this.uniqueId=_430;
this.mergeDoc=nitobi.xml.createXmlDoc("<ntb:root xmlns:ntb=\"http://www.nitobi.com\"><ntb:columns><ntb:stub/></ntb:columns><ntb:data><ntb:stub/></ntb:data></ntb:root>");
this.mergeDocCols=this.mergeDoc.selectSingleNode("//ntb:columns");
this.mergeDocData=this.mergeDoc.selectSingleNode("//ntb:data");
};
nitobi.grid.RowRenderer.prototype.render=function(_431,rows,_433,_434,_435,_436){
var _431=Number(_431)||0;
var rows=Number(rows)||0;
var xt=nitobi.grid.rowXslProc;
xt.addParameter("start",_431,"");
xt.addParameter("end",_431+rows,"");
xt.addParameter("sortColumn",_435,"");
xt.addParameter("sortDirection",_436,"");
xt.addParameter("dataTableId",this.dataTableId,"");
xt.addParameter("showHeaders",this.showHeaders+0,"");
xt.addParameter("firstColumn",this.firstColumn,"");
xt.addParameter("lastColumn",this.lastColumn,"");
xt.addParameter("uniqueId",this.uniqueId,"");
xt.addParameter("rowHover",this.rowHover,"");
xt.addParameter("frozenColumnId",this.frozenColumnId,"");
xt.addParameter("toolTipsEnabled",this.toolTipsEnabled,"");
var data=this.xmlDataSource.xmlDoc();
if(data.documentElement.firstChild==null){
return "";
}
var root=this.mergeDoc;
this.mergeDocCols.replaceChild((!nitobi.browser.IE?root.importNode(this.definitions,true):this.definitions.cloneNode(true)),this.mergeDocCols.firstChild);
this.mergeDocData.replaceChild((!nitobi.browser.IE?root.importNode(data.documentElement,true):data.documentElement.cloneNode(true)),this.mergeDocData.firstChild);
s2=nitobi.xml.transformToString(root,xt,"xml");
s2=s2.replace(/ATOKENTOREPLACE/g,"&nbsp;");
s2=s2.replace(/>\n</g,"><").replace(/\#\&lt\;\#/g,"<").replace(/\#\&gt\;\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#EQ\#/g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&").replace(/\n/g,"<br>");
return s2;
};
nitobi.grid.RowRenderer.prototype.generateXslTemplate=function(_43a,_43b,_43c,_43d,_43e,_43f,_440,_441,id){
this.definitions=_43a;
this.showIndicators=_43f;
this.showHeaders=_43e;
this.firstColumn=_43c;
this.lastColumn=_43c+_43d;
this.rowHover=_440;
this.frozenColumnId=(id?id:"");
this.toolTipsEnabled=_441;
return;
try{
var path=(typeof (gApplicationPath)=="undefined"?window.location.href.substr(0,window.location.href.lastIndexOf("/")+1):gApplicationPath);
var imp=this.xmlTemplate.selectNodes("//xsl:import");
for(var i=0;i<imp.length;i++){
imp[i].setAttribute("href",path+"xsl/"+imp[i].getAttribute("href"));
}
}
catch(e){
}
};
nitobi.grid.RowRenderer.prototype.dispose=function(){
this.xslTemplate=null;
this.xmlDataSource=null;
};
EBAScroller_RENDERTIMEOUT=100;
EBAScroller_VIEWPANES=new Array("topleft","topcenter","midleft","midcenter");
nitobi.grid.Scroller3x3=function(_446,_447,rows,_449,_44a,_44b){
this.disposal=[];
this.height=_447;
this.rows=rows;
this.columns=_449;
this.freezetop=_44a;
this.freezeleft=_44b;
this.lastScrollTop=-1;
this.uid=nitobi.base.getUid();
this.onRenderComplete=new nitobi.base.Event();
this.onRangeUpdate=new nitobi.base.Event();
this.onHtmlReady=new nitobi.base.Event();
this.owner=_446;
var VP=nitobi.grid.Viewport;
this.view={topleft:new VP(this.owner,0),topcenter:new VP(this.owner,1),midleft:new VP(this.owner,3),midcenter:new VP(this.owner,4)};
this.view.midleft.onHtmlReady.subscribe(this.handleHtmlReady,this);
this.setCellRanges();
this.scrollSurface=null;
this.startRow=_44a;
this.headerHeight=23;
this.rowHeight=23;
this.lastTimeoutId=0;
this.scrollTopPercent=0;
this.dataTable=null;
this.cacheMap=new nitobi.collections.CacheMap(-1,-1);
};
nitobi.grid.Scroller3x3.prototype.updateCellRanges=function(cols,rows,frzL,frzT){
this.columns=cols;
this.rows=rows;
this.freezetop=frzT;
this.freezeleft=frzL;
this.setCellRanges();
};
nitobi.grid.Scroller3x3.prototype.setCellRanges=function(){
var _451=null;
if(this.implementsStandardPaging()){
_451=this.getDisplayedRowCount();
}
this.view.topleft.setCellRanges(0,this.freezetop,0,this.freezeleft);
this.view.topcenter.setCellRanges(0,this.freezetop,this.freezeleft,this.columns-this.freezeleft);
this.view.midleft.setCellRanges(this.freezetop,(_451?_451:this.rows)-this.freezetop,0,this.freezeleft);
this.view.midcenter.setCellRanges(this.freezetop,(_451?_451:this.rows)-this.freezetop,this.freezeleft,this.columns-this.freezeleft);
};
nitobi.grid.Scroller3x3.prototype.resize=function(_452){
this.height=_452;
};
nitobi.grid.Scroller3x3.prototype.setScrollLeftRelative=function(_453){
this.setScrollLeft(this.scrollLeft+_453);
};
nitobi.grid.Scroller3x3.prototype.setScrollLeftPercent=function(_454){
this.setScrollLeft(Math.round((this.view.midcenter.element.scrollWidth-this.view.midcenter.element.clientWidth)*_454));
};
nitobi.grid.Scroller3x3.prototype.setScrollLeft=function(_455){
this.view.midcenter.element.scrollLeft=_455;
this.view.topcenter.element.scrollLeft=_455;
};
nitobi.grid.Scroller3x3.prototype.getScrollLeft=function(){
return this.scrollSurface.scrollLeft;
};
nitobi.grid.Scroller3x3.prototype.setScrollTopRelative=function(_456){
this.setScrollTop(this.getScrollTop()+_456);
};
nitobi.grid.Scroller3x3.prototype.setScrollTopPercent=function(_457){
ntbAssert(!isNaN(_457),"scrollPercent isNaN");
this.setScrollTop(Math.round((this.view.midcenter.element.scrollHeight-this.view.midcenter.element.clientHeight)*_457));
};
nitobi.grid.Scroller3x3.prototype.getScrollTopPercent=function(){
return this.scrollSurface.scrollTop/(this.view.midcenter.element.scrollHeight-this.view.midcenter.element.clientHeight);
};
nitobi.grid.Scroller3x3.prototype.setScrollTop=function(_458){
this.view.midcenter.element.scrollTop=_458;
this.view.midleft.element.scrollTop=_458;
this.render();
};
nitobi.grid.Scroller3x3.prototype.getScrollTop=function(){
return this.scrollSurface.scrollTop;
};
nitobi.grid.Scroller3x3.prototype.clearSurfaces=function(_459,_45a,_45b,_45c){
this.flushCache();
_45b=true;
if(_459){
_45a=true;
_45b=true;
_45c=true;
}
if(_45a){
this.view.topleft.clear(true);
this.view.topcenter.clear(true);
}
if(_45b){
this.view.midleft.clear(true,true,false,false);
this.view.midcenter.clear(false,false,true);
}
if(_45c){
}
};
nitobi.grid.Scroller3x3.prototype.mapToHtml=function(_45d){
var uid=this.owner.uid;
for(var i=0;i<4;i++){
var node=$ntb("gridvp_"+i+"_"+uid);
this.view[EBAScroller_VIEWPANES[i]].mapToHtml(node,nitobi.html.getFirstChild(node),null);
}
this.scrollSurface=$ntb("gridvp_3_"+uid);
};
nitobi.grid.Scroller3x3.prototype.getUnrenderedBlocks=function(){
var pair={first:this.freezetop,last:this.rows-1-this.freezetop};
if(!this.implementsShowAll()){
var _462=this.getScrollTop()+this.getTop()-this.headerHeight;
var MC=this.view.midcenter;
var b0=MC.findBlockAtCoord(_462);
var b1=MC.findBlockAtCoord(_462+this.height);
var _466=null;
var _467=null;
if(b0==null){
return;
}
_466=b0.top+Math.floor((_462-b0.offsetTop)/this.rowHeight);
if(b1){
_467=b1.top+Math.floor((_462+this.height-b1.offsetTop)/this.rowHeight);
}else{
_467=_466+Math.floor(this.height/this.rowHeight);
}
_467=Math.min(_467,this.rows);
if(this.implementsStandardPaging()){
var _468=0;
if(this.owner.getRenderMode()==nitobi.grid.RENDERMODE_ONDEMAND){
var _469=_466+_468;
var last=Math.min(_467+_468,_468+this.getDisplayedRowCount()-1);
pair={first:_469,last:last};
}else{
var _469=_468;
var last=_469+this.getDisplayedRowCount()-1;
pair={first:_469,last:last};
}
}else{
pair={first:_466,last:_467};
}
this.onRangeUpdate.notify(pair);
}
return pair;
};
nitobi.grid.Scroller3x3.prototype.render=function(_46b){
if(this.owner.isBound()&&(this.getScrollTop()!=this.lastScrollTop||_46b||this.scrollTopPercent>0.9)){
var _46c=nitobi.lang.close(this,this.performRender,[]);
window.clearTimeout(this.lastTimeoutId);
this.lastTimeoutId=window.setTimeout(_46c,EBAScroller_RENDERTIMEOUT);
}
};
nitobi.grid.Scroller3x3.prototype.performRender=function(){
var _46d=this.getUnrenderedBlocks();
if(_46d==null){
return;
}
var _46e=this.getScrollTop();
var mc=this.view.midcenter;
var ml=this.view.midleft;
var _471=this.getDataTable();
var _472=_46d.first;
var last=_46d.last;
if(last>=_471.remoteRowCount-1&&!_471.rowCountKnown){
last+=2;
}
var gaps=this.cacheMap.gaps(_472,last);
var _475=(this.owner.mode.toLowerCase()==nitobi.grid.MODE_LIVESCROLLING?(_472+last<=0):(_472+last<=-1));
if(_475){
this.onHtmlReady.notify();
}else{
if(gaps[0]!=null){
var low=gaps[0].low;
var high=gaps[0].high;
var rows=high-low+1;
if(!_471.inCache(low,rows)){
if(low==null||rows==null){
alert("low or rows =null");
}
if(this.implementsStandardPaging()){
var _479=this.getCurrentPageIndex()*this.getRowsPerPage();
var _47a=_479+this.getRowsPerPage();
_471.get(_479,_47a);
}else{
_471.get(low,rows);
}
var _47b=_471.cachedRanges(low,high);
for(var i=0;i<_47b.length;i++){
var _47d=this.cacheMap.gaps(_47b[i].low,_47b[i].high);
for(var j=0;j<_47d.length;j++){
_46d.first=_47d[j].low;
_46d.last=_47d[j].high;
this.renderGap(_47d[j].low,_47d[j].high);
}
}
return false;
}else{
this.renderGap(low,high);
}
}
}
this.onRenderComplete.notify();
};
nitobi.grid.Scroller3x3.prototype.renderGap=function(low,high){
var gaps=this.cacheMap.gaps(low,high);
var mc=this.view.midcenter;
var ml=this.view.midleft;
if(gaps[0]!=null){
var low=gaps[0].low;
var high=gaps[0].high;
var rows=high-low+1;
this.cacheMap.insert(low,high);
mc.renderGap(low,high);
ml.renderGap(low,high);
}
};
nitobi.grid.Scroller3x3.prototype.renderSpecified=function(low,high){
var rows=high-low+1;
var _488=this.getUnrenderedBlocks();
var _489=this.getDataTable();
if(!_489.inCache(low,rows)){
if(low==null||rows==null){
alert("low or rows =null");
}
if(this.implementsStandardPaging()){
var _48a=this.getCurrentPageIndex()*this.getRowsPerPage();
var _48b=_48a+this.getRowsPerPage();
_489.get(_48a,_48b);
}else{
_489.get(low,rows);
}
var _48c=_489.cachedRanges(low,high);
for(var i=0;i<_48c.length;i++){
var _48e=this.cacheMap.gaps(_48c[i].low,_48c[i].high);
for(var j=0;j<_48e.length;j++){
_488.first=_48e[j].low;
_488.last=_48e[j].high;
this.renderGap(_48e[j].low,_48e[j].high);
}
}
return false;
}else{
this.renderGap(low,high);
}
};
nitobi.grid.Scroller3x3.prototype.flushCache=function(){
if(Boolean(this.cacheMap)){
this.cacheMap.flush();
}
};
nitobi.grid.Scroller3x3.prototype.reRender=function(_490,_491){
var _492=this.view.midleft.clearBlocks(_490,_491);
this.view.midcenter.clearBlocks(_490,_491);
this.cacheMap.remove(_492.top,_492.bottom);
this.render();
};
nitobi.grid.Scroller3x3.prototype.getViewportByCoords=function(row,_494){
var _495=0;
if(row>=_495&&row<this.owner.getfreezetop()&&_494>=0&&_494<this.owner.frozenLeftColumnCount()){
return this.view.topleft;
}
if(row>=_495&&row<this.owner.getfreezetop()&&_494>=this.owner.getFrozenLeftColumnCount()&&_494<this.owner.getColumnCount()){
return this.view.topcenter;
}
if(row>=this.owner.getfreezetop()+_495&&row<this.owner.getDisplayedRowCount()+_495&&_494>=0&&_494<this.owner.getFrozenLeftColumnCount()){
return this.view.midleft;
}
if(row>=this.owner.getfreezetop()+_495&&row<this.owner.getDisplayedRowCount()+_495&&_494>=this.owner.getFrozenLeftColumnCount()&&_494<this.owner.getColumnCount()){
return this.view.midcenter;
}
};
nitobi.grid.Scroller3x3.prototype.getRowsPerPage=function(){
return this.owner.getRowsPerPage();
};
nitobi.grid.Scroller3x3.prototype.getDisplayedRowCount=function(){
return this.owner.getDisplayedRowCount();
};
nitobi.grid.Scroller3x3.prototype.getCurrentPageIndex=function(){
return this.owner.getCurrentPageIndex();
};
nitobi.grid.Scroller3x3.prototype.implementsStandardPaging=function(){
return Boolean(this.owner.getPagingMode().toLowerCase()=="standard");
};
nitobi.grid.Scroller3x3.prototype.implementsShowAll=function(){
return Boolean(this.owner.getPagingMode().toLowerCase()==nitobi.grid.PAGINGMODE_NONE);
};
nitobi.grid.Scroller3x3.prototype.setDataTable=function(_496){
this.dataTable=_496;
};
nitobi.grid.Scroller3x3.prototype.getDataTable=function(){
return this.dataTable;
};
nitobi.grid.Scroller3x3.prototype.handleHtmlReady=function(){
this.onHtmlReady.notify();
};
nitobi.grid.Scroller3x3.prototype.getTop=function(){
return this.freezetop*this.rowHeight+this.headerHeight;
};
nitobi.grid.Scroller3x3.prototype.setSort=function(col,dir){
this.view.topleft.setSort(col,dir);
this.view.topcenter.setSort(col,dir);
this.view.midleft.setSort(col,dir);
this.view.midcenter.setSort(col,dir);
};
nitobi.grid.Scroller3x3.prototype.setRowHeight=function(_499){
this.rowHeight=_499;
this.setViewportProperty("RowHeight",_499);
};
nitobi.grid.Scroller3x3.prototype.setHeaderHeight=function(_49a){
this.headerHeight=_49a;
this.setViewportProperty("HeaderHeight",_49a);
};
nitobi.grid.Scroller3x3.prototype.setViewportProperty=function(_49b,_49c){
var sv=this.view;
for(var i=0;i<EBAScroller_VIEWPANES.length;i++){
sv[EBAScroller_VIEWPANES[i]]["set"+_49b](_49c);
}
};
nitobi.grid.Scroller3x3.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.grid.Scroller3x3.prototype.subscribe=function(evt,func,_4a3){
if(typeof (_4a3)=="undefined"){
_4a3=this;
}
return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_4a3,func));
};
nitobi.grid.Scroller3x3.prototype.dispose=function(){
try{
(this.cacheMap!=null?this.cacheMap.flush():"");
this.cacheMap=null;
var _4a4=this.disposal.length;
for(var i=0;i<_4a4;i++){
if(typeof (this.disposal[i])=="function"){
this.disposal[i].call(this);
}
this.disposal[i]=null;
}
for(var v in this.view){
this.view[v].dispose();
}
for(var item in this){
if(this[item]!=null&&this[item].dispose instanceof Function){
this[item].dispose();
}
}
}
catch(e){
}
};
nitobi.grid.Selection=function(_4a8,_4a9){
nitobi.grid.Selection.baseConstructor.call(this,_4a8);
this.owner=_4a8;
var t=new Date();
this.selecting=false;
this.expanding=false;
this.resizingRow=false;
this.created=false;
this.freezeTop=this.owner.getfreezetop();
this.freezeLeft=this.owner.getFrozenLeftColumnCount();
this.rowHeight=23;
this.onAfterExpand=new nitobi.base.Event();
this.onBeforeExpand=new nitobi.base.Event();
this.onMouseUp=new nitobi.base.Event();
this.expandEndCell=null;
this.expandStartCell=null;
this.dragFillEnabled=_4a9||false;
this.firstCellClick=false;
this.multiSelect=false;
};
nitobi.lang.extend(nitobi.grid.Selection,nitobi.collections.CellSet);
nitobi.grid.Selection.prototype.setRange=function(_4ab,_4ac,_4ad,_4ae){
nitobi.grid.Selection.base.setRange.call(this,_4ab,_4ac,_4ad,_4ae);
this.startCell=this.owner.getCellElement(_4ab,_4ac);
this.endCell=this.owner.getCellElement(_4ad,_4ae);
};
nitobi.grid.Selection.prototype.setRangeWithDomNodes=function(_4af,_4b0){
this.setRange(nitobi.grid.Cell.getRowNumber(_4af),nitobi.grid.Cell.getColumnNumber(_4af),nitobi.grid.Cell.getRowNumber(_4b0),nitobi.grid.Cell.getColumnNumber(_4b0));
};
nitobi.grid.Selection.prototype.createBoxes=function(){
if(!this.created){
var uid=this.owner.uid;
var H=nitobi.html;
var _4b3=H.createElement("div",{"class":"ntb-grid-selection-grabby"});
this.expanderGrabbyEvents=[{type:"mousedown",handler:this.handleGrabbyMouseDown},{type:"mouseup",handler:this.handleGrabbyMouseUp},{type:"click",handler:this.handleGrabbyClick}];
H.attachEvents(_4b3,this.expanderGrabbyEvents,this);
this.boxexpanderGrabby=_4b3;
this.box=this.createBox("selectbox"+uid);
this.boxl=this.createBox("selectboxl"+uid);
this.events=[{type:"mousemove",handler:this.shrink},{type:"mouseup",handler:this.handleSelectionMouseUp},{type:"mousedown",handler:this.handleSelectionMouseDown},{type:"click",handler:this.handleSelectionClick},{type:"dblclick",handler:this.handleDblClick}];
H.attachEvents(this.box,this.events,this);
H.attachEvents(this.boxl,this.events,this);
var sv=this.owner.Scroller.view;
sv.midcenter.surface.appendChild(this.box);
sv.midleft.surface.appendChild(this.boxl);
this.clear();
this.created=true;
}
};
nitobi.grid.Selection.prototype.createBox=function(id){
var _4b6;
var cell;
if(nitobi.browser.IE){
cell=_4b6=document.createElement("div");
}else{
_4b6=nitobi.html.createTable({"cellpadding":0,"cellspacing":0,"border":0},{"backgroundColor":"transparent"});
cell=_4b6.rows[0].cells[0];
}
_4b6.className="ntb-grid-selection ntb-grid-selection-border";
_4b6.setAttribute("id","ntb-grid-selection-"+id);
var _4b8=nitobi.html.createElement("div",{"id":id,"class":"ntb-grid-selection-background"});
cell.appendChild(_4b8);
return _4b6;
};
nitobi.grid.Selection.prototype.clearBoxes=function(){
if(this.box!=null){
this.clearBox(this.box);
}
if(this.boxl!=null){
this.clearBox(this.boxl);
}
this.created=false;
delete this.box;
delete this.boxl;
this.box=null;
this.boxl=null;
};
nitobi.grid.Selection.prototype.clearBox=function(box){
nitobi.html.detachEvents(box,this.events);
if(box.parentNode!=null){
box.parentNode.removeChild(box);
}
box=null;
};
nitobi.grid.Selection.prototype.handleGrabbyMouseDown=function(evt){
this.selecting=true;
this.setExpanding(true,"vert");
var _4bb=this.getTopLeftCell();
var _4bc=this.getBottomRightCell();
this.expandStartCell=_4bb;
this.expandEndCell=_4bc;
var _4bd=this.owner.getScrollSurface();
this.expandStartCoords=nitobi.html.getBoundingClientRect(this.box,_4bd.scrollTop+document.body.scrollTop,_4bd.scrollLeft+document.body.scrollLeft);
this.expandStartHeight=Math.abs(_4bb.getRow()-_4bc.getRow())+1;
this.expandStartWidth=Math.abs(_4bb.getColumn()-_4bc.getColumn())+1;
this.expandStartTopRow=_4bb.getRow();
this.expandStartBottomRow=_4bc.getRow();
this.expandStartLeftColumn=_4bb.getColumn();
this.expandStartRightColumn=_4bc.getColumn();
var Cell=nitobi.grid.Cell;
if(Cell.getRowNumber(this.startCell)>Cell.getRowNumber(this.endCell)){
var _4bf=this.startCell;
this.startCell=this.endCell;
this.endCell=_4bf;
}
this.onBeforeExpand.notify(this);
};
nitobi.grid.Selection.prototype.handleGrabbyMouseUp=function(evt){
if(this.expanding){
this.selecting=false;
(this._startRow==this._endRow)?this.setExpanding(false,"horiz"):this.setExpanding(false);
this.onAfterExpand.notify(this);
}
};
nitobi.grid.Selection.prototype.handleGrabbyClick=function(evt){
};
nitobi.grid.Selection.prototype.expand=function(cell,dir){
this.setExpanding(true,dir);
var Cell=nitobi.grid.Cell;
var _4c5;
var _4c6=this.expandStartTopRow,_4c7=this.expandStartLeftColumn;
var _4c8=this.expandStartBottomRow,_4c9=this.expandStartRightColumn;
var _4ca=Cell.getRowNumber(this.endCell),_4cb=Cell.getColumnNumber(this.endCell);
var _4cc=Cell.getRowNumber(this.startCell),_4cd=Cell.getColumnNumber(this.startCell);
var _4ce=Cell.getColumnNumber(cell);
var _4cf=Cell.getRowNumber(cell);
var _4d0=_4cd,_4d1=_4cc;
var o=this.owner;
if(dir=="horiz"){
if(_4cd<_4cb&_4ce<_4cd){
this.changeEndCellWithDomNode(o.getCellElement(_4c8,_4ce));
this.changeStartCellWithDomNode(o.getCellElement(_4c6,_4c9));
}else{
if(_4cd>_4cb&&_4ce>_4cd){
this.changeEndCellWithDomNode(o.getCellElement(_4c8,_4ce));
this.changeStartCellWithDomNode(o.getCellElement(_4c6,_4c7));
}else{
this.changeEndCellWithDomNode(o.getCellElement((_4cc==_4c8?_4c6:_4c8),_4ce));
}
}
}else{
if(_4cc<_4ca&_4cf<_4cc){
this.changeEndCellWithDomNode(o.getCellElement(_4cf,_4c9));
this.changeStartCellWithDomNode(o.getCellElement(_4c8,_4c7));
}else{
if(_4cc>_4ca&&_4cf>_4cc){
this.changeEndCellWithDomNode(o.getCellElement(_4cf,_4c9));
this.changeStartCellWithDomNode(o.getCellElement(_4c6,_4c7));
}else{
this.changeEndCellWithDomNode(o.getCellElement(_4cf,(_4cd==_4c9?_4c7:_4c9)));
}
}
}
this.alignBoxes();
};
nitobi.grid.Selection.prototype.shrink=function(evt){
if(nitobi.html.Css.hasClass(evt.srcElement,"ntb-grid-selection-border")||nitobi.html.Css.hasClass(evt.srcElement,"ntb-grid-selection-grabby")){
return;
}
if(this.endCell!=this.startCell&&this.selecting){
var _4d4=this.owner.getScrollSurface();
var Cell=nitobi.grid.Cell;
var _4d6=Cell.getRowNumber(this.endCell),_4d7=Cell.getColumnNumber(this.endCell);
var _4d8=Cell.getRowNumber(this.startCell),_4d9=Cell.getColumnNumber(this.startCell);
var _4da=nitobi.html.getEventCoords(evt);
var evtY=_4da.y,evtX=_4da.x;
if(nitobi.browser.IE||document.compatMode=="BackCompat"){
evtY=evt.clientY,evtX=evt.clientX;
}
var _4dd=nitobi.html.getBoundingClientRect(this.endCell,_4d4.scrollTop+document.body.scrollTop,_4d4.scrollLeft+document.body.scrollLeft);
var _4de=_4dd.top,_4df=_4dd.left;
if(_4d6>_4d8&&evtY<_4de){
_4d6=_4d6-Math.floor(((_4de-4)-evtY)/this.rowHeight)-1;
}else{
if(evtY>_4dd.bottom){
_4d6=_4d6+Math.floor((evtY-_4de)/this.rowHeight);
}
}
if(_4d7>_4d9&&evtX<_4df){
_4d7--;
}else{
if(evtX>_4dd.right){
_4d7++;
}
}
if(this.expanding){
var _4e0=this.expandStartCell.getRow(),_4e1=this.expandStartCell.getColumn();
var _4e2=this.expandEndCell.getRow(),_4e3=this.expandEndCell.getColumn();
if(_4d7>=this.expandStartLeftColumn&&_4d7<=this.expandStartRightColumn){
if(_4d7>=_4d9&&_4d7<_4e3){
_4d7=_4e3;
}else{
if(_4d7<=_4d9&&_4d7>_4e1){
_4d7=_4e1;
}
}
if(_4d7>=_4d9&&_4d7<=this.expandStartRightColumn){
_4d7=this.expandStartRightColumn;
}
}
if(_4d6>=this.expandStartTopRow&&_4d6<=this.expandStartBottomRow){
if(_4d8<_4d6&&_4d6<=_4e2){
_4d6=_4e2;
}else{
if(_4d8>_4d6&&_4d6>=_4e0){
_4d6=_4e0;
}else{
if(_4d8==_4d6){
_4d6=(_4d8==_4e0?_4e2:_4e0);
}
}
}
}
}
var _4e4=this.owner.getCellElement(_4d6,_4d7);
var _4e5=this.owner.getCellElement(_4d8,_4d9);
if(_4e4!=null&&_4e4!=this.endCell||_4e5!=null&&_4e5!=this.startCell){
this.changeEndCellWithDomNode(_4e4);
this.changeStartCellWithDomNode(_4e5);
this.alignBoxes();
this.owner.ensureCellInView(_4e4);
}
}
};
nitobi.grid.Selection.prototype.getHeight=function(){
var rect=nitobi.html.getBoundingClientRect(this.box);
return rect.top-rect.bottom;
};
nitobi.grid.Selection.prototype.collapse=function(cell){
if(!cell){
cell=this.startCell;
}
if(!cell){
return;
}
this.setRangeWithDomNodes(cell,cell);
if((this.box==null)||(this.box.parentNode==null)||(this.boxl==null)||(this.boxl.parentNode==null)){
this.created=false;
this.createBoxes();
}
this.alignBoxes();
this.selecting=false;
};
nitobi.grid.Selection.prototype.startSelecting=function(_4e8,_4e9){
this.selecting=true;
this.setRangeWithDomNodes(_4e8,_4e9);
this.shrink();
};
nitobi.grid.Selection.prototype.clearSelection=function(cell){
this.collapse(cell);
};
nitobi.grid.Selection.prototype.resizeSelection=function(cell){
this.endCell=cell;
this.shrink();
};
nitobi.grid.Selection.prototype.moveSelection=function(cell){
this.collapse(cell);
};
nitobi.grid.Selection.prototype.alignBoxes=function(){
var _4ed=this.endCell||this.startCell;
var sc=this.getCoords();
var _4ef=sc.top.y;
var _4f0=sc.top.x;
var _4f1=sc.bottom.y;
var _4f2=sc.bottom.x;
var _4f3=nitobi.lang.isStandards();
var ox=oy=(nitobi.browser.IE?-1:0);
var ow=oh=(nitobi.browser.IE&&_4f3?-1:1);
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
oy=ox=-1;
if(_4f3){
oh=ow=-1;
}
}
if(_4f2>=this.freezeLeft&&_4f1>=this.freezeTop){
var e=this.box;
e.style.display="block";
this.align(e,this.startCell,_4ed,286265344,oh,ow,oy,ox);
if(this.dragFillEnabled){
(e.rows!=null?e.rows[0].cells[0]:e).appendChild(this.boxexpanderGrabby);
}
}else{
this.box.style.display="none";
}
if(_4f2<this.freezeLeft||_4f0<this.freezeLeft){
var e=this.boxl;
e.style.display="block";
this.align(e,this.startCell,_4ed,286265344,oh,ow,oy,ox);
if(this.box.style.display=="none"){
if(this.dragFillEnabled){
(e.rows!=null?e.rows[0].cells[0]:e).appendChild(this.boxexpanderGrabby);
}
}
}else{
this.boxl.style.display="none";
}
};
nitobi.grid.Selection.prototype.redraw=function(cell){
if(!this.selecting){
this.setRangeWithDomNodes(cell,cell);
}else{
this.changeEndCellWithDomNode(cell);
}
this.alignBoxes();
};
nitobi.grid.Selection.prototype.changeStartCellWithDomNode=function(cell){
this.startCell=cell;
var Cell=nitobi.grid.Cell;
this.changeStartCell(Cell.getRowNumber(cell),Cell.getColumnNumber(cell));
};
nitobi.grid.Selection.prototype.changeEndCellWithDomNode=function(cell){
this.endCell=cell;
var Cell=nitobi.grid.Cell;
this.changeEndCell(Cell.getRowNumber(cell),Cell.getColumnNumber(cell));
};
nitobi.grid.Selection.prototype.init=function(cell){
this.createBoxes();
var t=new Date();
this.selecting=true;
this.setRangeWithDomNodes(cell,cell);
};
nitobi.grid.Selection.prototype.clear=function(){
if(!this.box){
return;
}
var bs=this.box.style;
bs.display="none";
bs.top="-1000px";
bs.left="-1000px";
bs.width="1px";
bs.height="1px";
var bls=this.boxl.style;
bls.display="none";
bls.top="-1000px";
bls.left="-1000px";
bls.width="1px";
bls.height="1px";
this.selecting=false;
};
nitobi.grid.Selection.prototype.handleSelectionClick=function(evt){
if(!this.selected()){
if(NTB_SINGLECLICK==null&&!(this.firstCellClick)){
if(nitobi.browser.IE){
evt=nitobi.lang.copy(evt);
}
NTB_SINGLECLICK=window.setTimeout(nitobi.lang.close(this,this.edit,[evt]),400);
}
}else{
this.collapse();
this.owner.focus();
this.firstCellClick=false;
}
};
nitobi.grid.Selection.prototype.handleDblClick=function(evt){
if(!this.selected()){
window.clearTimeout(NTB_SINGLECLICK);
NTB_SINGLECLICK=null;
if(this.owner.handleDblClick(evt)){
this.edit(evt);
}
}else{
this.collapse();
}
};
nitobi.grid.Selection.prototype.edit=function(evt){
NTB_SINGLECLICK=null;
this.owner.edit(evt);
};
nitobi.grid.Selection.prototype.select=function(_503,_504){
this.selectWithCoords(_503.getRowNumber(),_503.getColumnNumber(),_504.getRowNumber(),_504.getColumnNumber());
};
nitobi.grid.Selection.prototype.selectWithCoords=function(_505,_506,_507,_508){
this.setRange(_505,_506,_507,_508);
this.createBoxes();
this.alignBoxes();
};
nitobi.grid.Selection.prototype.handleSelectionMouseUp=function(evt){
if(this.expanding){
this.handleGrabbyMouseUp(evt);
}
this.stopSelecting(evt);
this.onMouseUp.notify(this);
};
nitobi.grid.Selection.prototype.handleSelectionMouseDown=function(evt){
this.firstCellClick=true;
};
nitobi.grid.Selection.prototype.stopSelecting=function(evt){
this.owner.waitt=false;
if(!this.selected()){
var cell=this.owner.findActiveCell(evt.srcElement)||this.startCell;
var _50d=nitobi.grid.Cell;
if(this.owner.activeCell!=cell){
this.owner.setActiveCell(cell,evt.ctrlKey||evt.metaKey);
}
this.collapse(cell);
}
this.selecting=false;
};
nitobi.grid.Selection.prototype.getStartCell=function(){
return this.startCell;
};
nitobi.grid.Selection.prototype.getEndCell=function(){
return this.endCell;
};
nitobi.grid.Selection.prototype.getTopLeftCell=function(){
var _50e=this.getCoords();
return new nitobi.grid.Cell(this.owner,_50e.top.y,_50e.top.x);
};
nitobi.grid.Selection.prototype.getBottomRightCell=function(){
var _50f=this.getCoords();
return new nitobi.grid.Cell(this.owner,_50f.bottom.y,_50f.bottom.x);
};
nitobi.grid.Selection.prototype.getHeight=function(){
var _510=this.getCoords();
return _510.bottom.y-_510.top.y+1;
};
nitobi.grid.Selection.prototype.getWidth=function(){
var _511=this.getCoords();
return _511.bottom.x-_511.top.x+1;
};
nitobi.grid.Selection.prototype.getRowByCoords=function(_512){
return (_512.parentNode.offsetTop/_512.parentNode.offsetHeight);
};
nitobi.grid.Selection.prototype.getColumnByCoords=function(_513){
var _514=(this.indicator?-2:0);
if(_513.parentNode.parentNode.getAttribute("id").substr(0,6)!="freeze"){
_514+=2-(this.freezeColumn*3);
}else{
_514+=2;
}
return Math.floor((_513.sourceIndex-_513.parentNode.sourceIndex-_514)/3);
};
nitobi.grid.Selection.prototype.selected=function(){
return (this.endCell==this.startCell)?false:true;
};
nitobi.grid.Selection.prototype.setRowHeight=function(_515){
this.rowHeight=_515;
};
nitobi.grid.Selection.prototype.getRowHeight=function(){
return this.rowHeight;
};
nitobi.grid.Selection.prototype.setExpanding=function(val,dir){
if(val&&this.expanding){
return;
}
this.expanding=val;
this.expandingVertical=(dir=="horiz"?false:true);
var C=nitobi.html.Css;
var _519="ntb-grid-selection-border";
var _51a=_519+"-active";
if(val){
C.swapClass(this.box,_519,_51a);
C.swapClass(this.boxl,_519,_51a);
}else{
C.swapClass(this.box,_51a,_519);
C.swapClass(this.boxl,_51a,_519);
}
};
nitobi.grid.Selection.prototype.dispose=function(){
};
nitobi.grid.Selection.prototype.align=function(_51b,_51c,_51d,_51e,oh,ow,oy,ox,show){
oh=oh||0;
ow=ow||0;
oy=oy||0;
ox=ox||0;
var a=_51e;
var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;
if(!_51c||(nitobi.lang.typeOf(_51c)!=nitobi.lang.type.HTMLNODE)){
return;
}
ntbAssert(Boolean(_51c.parentNode)&&Boolean(_51d.parentNode)&&Boolean(_51b.parentNode),"Couldn't align selection. The parentnode has vanished. Most likely this is due to refilter.");
ad=nitobi.html.getBoundingClientRect(_51c);
bd=nitobi.html.getBoundingClientRect(_51d);
sd=nitobi.html.getBoundingClientRect(_51b);
at=ad.top;
ab=ad.bottom;
al=ad.left;
ar=ad.right;
bt=bd.top;
bb=bd.bottom;
bl=bd.left;
br=bd.right;
tt=ad.top;
tb=bd.bottom;
tl=ad.left;
tr=bd.right;
th=Math.abs(tb-tt);
tw=Math.abs(tr-tl);
st=sd.top;
sb=sd.bottom;
sl=sd.left;
sr=sd.right;
sh=Math.abs(sb-st);
sw=Math.abs(sr-sl);
var H=nitobi.html;
if(a&268435456){
_51b.style.height=(Math.max(bb-at,ab-bt)+oh)+"px";
}
if(a&16777216){
_51b.style.width=(Math.max(br-al,ar-bl)+ow)+"px";
}
if(a&1048576){
_51b.style.top=(H.getStyleTop(_51b)+Math.min(tt,bt)-st+oy)+"px";
}
if(a&65536){
_51b.style.top=(H.getStyleTop(_51b)+tt-st+th-sh+oy)+"px";
}
if(a&4096){
_51b.style.left=(H.getStyleLeft(_51b)-sl+Math.min(tl,bl)+ox)+"px";
}
if(a&256){
_51b.style.left=(H.getStyleLeft(_51b)-sl+tl+tw-sw+ox)+"px";
}
if(a&16){
_51b.style.top=(H.getStyleTop(_51b)+tt-st+oy+Math.floor((th-sh)/2))+"px";
}
if(a&1){
_51b.style.left=(H.getStyleLeft(_51b)-sl+tl+ox+Math.floor((tw-sw)/2))+"px";
}
};
nitobi.grid.Surface=function(_534,_535,_536){
this.height=_535;
this.width=_534;
this.element=_536;
};
nitobi.grid.Surface.prototype.dispose=function(){
this.element=null;
};
nitobi.grid.TextColumn=function(grid,_538){
nitobi.grid.TextColumn.baseConstructor.call(this,grid,_538);
};
nitobi.lang.extend(nitobi.grid.TextColumn,nitobi.grid.Column);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.Toolbars=function(_539,_53a){
this.grid=_539;
this.uid="nitobiToolbar_"+nitobi.base.getUid();
this.toolbars={};
this.visibleToolbars=_53a;
};
nitobi.ui.Toolbars.VisibleToolbars={};
nitobi.ui.Toolbars.VisibleToolbars.STANDARD=1;
nitobi.ui.Toolbars.VisibleToolbars.PAGING=1<<1;
nitobi.ui.Toolbars.prototype.initialize=function(){
this.enabled=true;
this.toolbarXml=nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.toolbarDoc));
this.toolbarPagingXml=nitobi.xml.createXmlDoc(nitobi.xml.serialize(nitobi.grid.pagingToolbarDoc));
};
nitobi.ui.Toolbars.prototype.attachToParent=function(_53b){
this.initialize();
this.container=_53b;
if(this.standardToolbar==null&&this.visibleToolbars){
this.makeToolbar();
this.render();
}
};
nitobi.ui.Toolbars.prototype.setWidth=function(_53c){
this.width=_53c;
};
nitobi.ui.Toolbars.prototype.getWidth=function(){
return this.width;
};
nitobi.ui.Toolbars.prototype.setHeight=function(_53d){
this.height=_53d;
};
nitobi.ui.Toolbars.prototype.getHeight=function(){
return this.height;
};
nitobi.ui.Toolbars.prototype.setRowInsertEnabled=function(_53e){
this.rowInsertEnabled=_53e;
};
nitobi.ui.Toolbars.prototype.isRowInsertEnabled=function(){
return this.rowInsertEnabled;
};
nitobi.ui.Toolbars.prototype.setRowDeleteEnabled=function(_53f){
this.rowDeleteEnabled=_53f;
};
nitobi.ui.Toolbars.prototype.isRowDeleteEnabled=function(){
return this.rowDeleteEnabled;
};
nitobi.ui.Toolbars.prototype.makeToolbar=function(){
var _540=this.findCssUrl();
this.toolbarXml.documentElement.setAttribute("id","toolbar"+this.uid);
this.toolbarXml.documentElement.setAttribute("image_directory",_540);
var _541=this.toolbarXml.selectNodes("/toolbar/items/*");
for(var i=0;i<_541.length;i++){
if(_541[i].nodeType!=8){
_541[i].setAttribute("id",_541[i].getAttribute("id")+this.uid);
}
}
this.standardToolbar=new nitobi.ui.Toolbar(this.toolbarXml,"toolbar"+this.uid);
this.toolbarPagingXml.documentElement.setAttribute("id","toolbarpaging"+this.uid);
this.toolbarPagingXml.documentElement.setAttribute("image_directory",_540);
_541=(this.toolbarPagingXml.selectNodes("/toolbar/items/*"));
for(var i=0;i<_541.length;i++){
if(_541[i].nodeType!=8){
_541[i].setAttribute("id",_541[i].getAttribute("id")+this.uid);
}
}
this.pagingToolbar=new nitobi.ui.Toolbar(this.toolbarPagingXml,"toolbarpaging"+this.uid);
};
nitobi.ui.Toolbars.prototype.getToolbar=function(id){
return eval("this."+id);
};
nitobi.ui.Toolbars.prototype.findCssUrl=function(){
var _544=nitobi.html.Css.findParentStylesheet(".ntb-toolbar");
if(_544==null){
_544=nitobi.html.Css.findParentStylesheet(".ntb-grid");
if(_544==null){
nitobi.lang.throwError("The CSS for the toolbar could not be found.  Try moving the nitobi.grid.css file to a location accessible to the browser's javascript or moving it to the top of the stylesheet list. findParentStylesheet returned "+_544);
}
}
return nitobi.html.Css.getPath(_544);
};
nitobi.ui.Toolbars.prototype.isToolbarEnabled=function(){
return this.enabled;
};
nitobi.ui.Toolbars.prototype.render=function(){
var _545=this.container;
_545.style.visibility="hidden";
var xsl=nitobi.ui.ToolbarXsl;
if(xsl.indexOf("xsl:stylesheet")==-1){
xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"xml\" version=\"4.0\" />"+xsl+"</xsl:stylesheet>";
}
var _547=nitobi.xml.createXslDoc(xsl);
xsl=nitobi.ui.pagingToolbarXsl;
if(xsl.indexOf("xsl:stylesheet")==-1){
xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"xml\" version=\"4.0\" />"+xsl+"</xsl:stylesheet>";
}
var _548=nitobi.xml.createXslDoc(xsl);
var _549=nitobi.xml.transformToString(this.standardToolbar.getXml(),_547,"xml");
_545.innerHTML=_549;
_545.style.zIndex="1000";
var _54a=nitobi.xml.transformToString(this.pagingToolbar.getXml(),_548,"xml");
_545.innerHTML+=_54a;
_547=null;
xmlDoc=null;
this.standardToolbar.attachToTag();
this.pagingToolbar.attachToTag();
this.resize();
var _54b=this;
var _54c=this.standardToolbar.getUiElements();
for(eachbutton in _54c){
if(_54c[eachbutton].m_HtmlElementHandle==null){
continue;
}
_54c[eachbutton].toolbar=this;
_54c[eachbutton].grid=this.grid;
if(nitobi.browser.IE&&_54c[eachbutton].m_HtmlElementHandle.onbuttonload!=null){
var x=function(item,grid,tbar,iDom){
eval(_54c[eachbutton].m_HtmlElementHandle.onbuttonload);
};
x(_54c[eachbutton],this.grid,this,_54c[eachbutton].m_HtmlElementHandle);
}else{
if(!nitobi.browser.IE&&_54c[eachbutton].m_HtmlElementHandle.hasAttribute("onbuttonload")){
var x=function(item,grid,tbar,iDom){
eval(_54c[eachbutton].m_HtmlElementHandle.getAttribute("onbuttonload"));
};
x(_54c[eachbutton],this.grid,this,_54c[eachbutton].m_HtmlElementHandle);
}
}
switch(eachbutton){
case "save"+this.uid:
_54c[eachbutton].onClick=function(){
_54b.fire("Save");
};
break;
case "newRecord"+this.uid:
_54c[eachbutton].onClick=function(){
_54b.fire("InsertRow");
};
if(!this.isRowInsertEnabled()){
_54c[eachbutton].disable();
}
break;
case "deleteRecord"+this.uid:
_54c[eachbutton].onClick=function(){
_54b.fire("DeleteRow");
};
if(!this.isRowDeleteEnabled()){
_54c[eachbutton].disable();
}
break;
case "refresh"+this.uid:
_54c[eachbutton].onClick=function(){
var _556=confirm("Refreshing will discard any changes you have made. Is it OK to refresh?");
if(_556){
_54b.fire("Refresh");
}
};
break;
default:
}
}
var _557=this.pagingToolbar.getUiElements();
var _54b=this;
for(eachPbutton in _557){
if(_557[eachPbutton].m_HtmlElementHandle==null){
continue;
}
_557[eachPbutton].toolbar=this;
_557[eachPbutton].grid=this.grid;
if(nitobi.browser.IE&&_557[eachPbutton].m_HtmlElementHandle.onbuttonload!=null){
var x=function(item,grid,tbar,iDom){
eval(_557[eachPbutton].m_HtmlElementHandle.onbuttonload);
};
x(_557[eachPbutton],this.grid,this,_557[eachPbutton].m_HtmlElementHandle);
}else{
if(!nitobi.browser.IE&&_557[eachPbutton].m_HtmlElementHandle.hasAttribute("onbuttonload")){
var x=function(item,grid,tbar,iDom){
eval(_557[eachPbutton].m_HtmlElementHandle.getAttribute("onbuttonload"));
};
x(_557[eachPbutton],this.grid,this,_557[eachPbutton].m_HtmlElementHandle);
}
}
switch(eachPbutton){
case "previousPage"+this.uid:
_557[eachPbutton].onClick=function(){
_54b.fire("PreviousPage");
};
_557[eachPbutton].disable();
break;
case "nextPage"+this.uid:
_557[eachPbutton].onClick=function(){
_54b.fire("NextPage");
};
break;
default:
}
}
if(this.visibleToolbars&nitobi.ui.Toolbars.VisibleToolbars.STANDARD){
this.standardToolbar.show();
}else{
this.standardToolbar.hide();
}
if(this.visibleToolbars&nitobi.ui.Toolbars.VisibleToolbars.PAGING){
this.pagingToolbar.show();
}else{
this.pagingToolbar.hide();
}
_545.style.visibility="visible";
};
nitobi.ui.Toolbars.prototype.resize=function(){
var _560=this.getWidth();
if(this.visibleToolbars&nitobi.ui.Toolbars.VisibleToolbars.PAGING){
this.standardToolbar.setHeight(this.getHeight());
}
if(this.visibleToolbars&nitobi.ui.Toolbars.VisibleToolbars.STANDARD){
this.standardToolbar.setHeight(this.getHeight());
}
};
nitobi.ui.Toolbars.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.ui.Toolbars.prototype.subscribe=function(evt,func,_565){
if(typeof (_565)=="undefined"){
_565=this;
}
return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_565,func));
};
nitobi.ui.Toolbars.prototype.dispose=function(){
this.toolbarXml=null;
this.toolbarPagingXml=null;
if(this.toolbar&&this.toolbar.dispose){
this.toolbar.dispose();
this.toolbar=null;
}
if(this.toolbarPaging&&this.toolbarPaging.dispose){
this.toolbarPaging.dispose();
this.toolbarPaging=null;
}
};
var EBA_SELECTION_BUFFER=15;
var NTB_SINGLECLICK=null;
nitobi.grid.Viewport=function(grid,_567){
this.disposal=[];
this.surface=null;
this.element=null;
this.rowHeight=23;
this.headerHeight=23;
this.sortColumn=0;
this.sortDir=1;
this.uid=nitobi.base.getUid();
this.region=_567;
this.scrollIncrement=0;
this.grid=grid;
this.startRow=0;
this.rows=0;
this.startColumn=0;
this.columns=0;
this.rowRenderer=null;
this.onHtmlReady=new nitobi.base.Event();
};
nitobi.grid.Viewport.prototype.mapToHtml=function(_568,_569,_56a){
this.surface=_569;
this.element=_568;
this.container=nitobi.html.getFirstChild(_569);
this.makeLastBlock(0,this.grid.getRowsPerPage()*5);
};
nitobi.grid.Viewport.prototype.makeLastBlock=function(low,high){
if(this.lastEmptyBlock==null&&this.grid&&this.region>2&&this.region<5&&this.container){
if(this.container.lastChild){
low=Math.max(low,this.container.lastChild.bottom);
}
this.lastEmptyBlock=this.renderEmptyBlock(low,high);
}
};
nitobi.grid.Viewport.prototype.setCellRanges=function(_56d,rows,_56f,_570){
this.startRow=_56d;
this.rows=rows;
this.startColumn=_56f;
this.columns=_570;
this.makeLastBlock(this.startRow,this.startRow+rows-1);
if(this.lastEmptyBlock!=null&&this.region>2&&this.region<5&&this.rows>0){
var _571=this.startRow+this.rows-1;
if(this.lastEmptyBlock.top>_571){
this.container.removeChild(this.lastEmptyBlock);
this.lastEmptyBlock=null;
}else{
this.lastEmptyBlock.bottom=_571;
this.lastEmptyBlock.style.height=(this.rowHeight*(this.lastEmptyBlock.bottom-this.lastEmptyBlock.top+1))+"px";
if(this.lastEmptyBlock.bottom<this.lastEmptyBlock.top){
throw "blocks are miss aligned.";
}
}
}
};
nitobi.grid.Viewport.prototype.clear=function(_572,_573,_574,_575){
var uid=this.grid.uid;
if(this.surface&&_572){
this.surface.innerHTML="<div id=\"gridvpcontainer_"+this.region+"_"+uid+"\"></div>";
}
if(this.element&&_575){
this.element.innerHTML="<div id=\"gridvpsurface_"+this.region+"_"+uid+"\"><div id=\"gridvpcontainer_"+this.region+"_"+uid+"\"></div></div>";
}
if(this.surface&&_574){
this.surface.innerHTML="<div id=\"gridvpcontainer_"+this.region+"_"+uid+"\"></div>";
}
this.surface=nitobi.html.getFirstChild(this.element);
this.container=nitobi.html.getFirstChild(this.surface);
if(this.grid&&this.region>2&&this.region<5){
this.lastEmptyBlock=null;
}
this.makeLastBlock(0,this.grid.getRowsPerPage()*5);
};
nitobi.grid.Viewport.prototype.setSort=function(_577,_578){
this.sortColumn=_577;
this.sortDir=_578;
};
nitobi.grid.Viewport.prototype.renderGap=function(top,_57a){
var _57b=activeRow=null;
var _57c=this.findBlock(top);
var o=this.renderInsideEmptyBlock(top,_57a,_57c);
if(o==null){
return;
}
o.setAttribute("rendered","true");
var rows=_57a-top+1;
o.innerHTML=this.rowRenderer.render(top,rows,_57b,activeRow,this.sortColumn,this.sortDir);
this.onHtmlReady.notify(this);
};
nitobi.grid.Viewport.prototype.findBlock=function(row){
var blk=this.container.childNodes;
for(var i=0;i<blk.length;i++){
if(row>=blk[i].top&&row<=blk[i].bottom){
return blk[i];
}
}
};
nitobi.grid.Viewport.prototype.findBlockAtCoord=function(top){
var blk=this.container.childNodes;
for(var i=0;i<blk.length;i++){
var rt=blk[i].offsetTop;
var rb=rt+blk[i].offsetHeight;
if(top>=rt&&top<=rb){
return blk[i];
}
}
};
nitobi.grid.Viewport.prototype.getBlocks=function(_587,_588){
var _589=[];
var _58a=this.findBlock(_587);
var _58b=_58a;
_589.push(_58a);
while(_588>_58b.bottom){
var _58c=_58b.nextSibling;
if(_58c!=null){
_58b=_58c;
}else{
break;
}
_589.push(_58b);
}
return _589;
};
nitobi.grid.Viewport.prototype.clearBlocks=function(_58d,_58e){
var _58f=this.getBlocks(_58d,_58e);
var len=_58f.length;
var top=_58f[0].top;
var _592=_58f[len-1].bottom;
var _593=_58f[len-1].nextSibling;
for(var i=0;i<len;i++){
_58f[i].parentNode.removeChild(_58f[i]);
}
this.renderEmptyBlock(top,_592,_593);
return {"top":top,"bottom":_592};
};
nitobi.grid.Viewport.prototype.renderInsideEmptyBlock=function(top,_596,_597){
if(_597==null){
return this.renderBlock(top,_596);
}
if(top==_597.top&&_596>=_597.bottom){
var _598=this.renderBlock(top,_596,_597);
this.container.replaceChild(_598,_597);
if(_597.bottom<_597.top){
throw "Render error";
}
return _598;
}
if(top==_597.top&&_596<_597.bottom){
_597.top=_596+1;
_597.style.height=(this.rowHeight*(_597.bottom-_597.top+1))+"px";
_597.rows=_597.bottom-_597.top+1;
if(_597.bottom<_597.top){
throw "Render error";
}
return this.renderBlock(top,_596,_597);
}
if(top>_597.top&&_596>=_597.bottom){
_597.bottom=top-1;
_597.style.height=(this.rowHeight*(_597.bottom-_597.top+1))+"px";
if(_597.bottom<_597.top){
throw "Render error";
}
return this.renderBlock(top,_596,_597.nextSibling);
}
if(top>_597.top&&_596<_597.bottom){
var _599=this.renderEmptyBlock(_597.top,top-1,_597);
_597.top=_596+1;
_597.style.height=(this.rowHeight*(_597.bottom-_597.top+1))+"px";
if(_597.bottom<_597.top){
throw "Render error";
}
return this.renderBlock(top,_596,_597);
}
throw "Could not insert "+top+"-"+_596+_597.outerHTML;
};
nitobi.grid.Viewport.prototype.renderEmptyBlock=function(top,_59b,_59c){
var o=this.renderBlock(top,_59b,_59c);
o.setAttribute("id","eba_grid_emptyblock_"+this.region+"_"+top+"_"+_59b+"_"+this.grid.uid);
if(top==0&&_59b==99){
crash;
}
o.setAttribute("rendered","false");
o.style.height=Math.max(((_59b-top+1)*this.rowHeight),0)+"px";
return o;
};
nitobi.grid.Viewport.prototype.renderBlock=function(top,_59f,_5a0){
var o=document.createElement("div");
o.setAttribute("id","eba_grid_block_"+this.region+"_"+top+"_"+_59f+"_"+this.grid.uid);
o.top=top;
o.bottom=_59f;
o.left=this.startColumn;
o.right=this.startColumn+this.columns;
o.rows=_59f-top+1;
o.columns=this.columns;
if(_5a0){
this.container.insertBefore(o,_5a0);
}else{
this.container.insertBefore(o,null);
}
return o;
};
nitobi.grid.Viewport.prototype.setHeaderHeight=function(_5a2){
this.headerHeight=_5a2;
};
nitobi.grid.Viewport.prototype.setRowHeight=function(_5a3){
this.rowHeight=_5a3;
};
nitobi.grid.Viewport.prototype.dispose=function(){
this.element=null;
this.container=null;
nitobi.lang.dispose(this,this.disposal);
return;
};
nitobi.grid.Viewport.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.grid.Viewport.prototype.subscribe=function(evt,func,_5a8){
if(typeof (_5a8)=="undefined"){
_5a8=this;
}
return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_5a8,func));
};
nitobi.grid.Viewport.prototype.attach=function(evt,func,_5ab){
return nitobi.html.attachEvent(_5ab,evt,nitobi.lang.close(this,func));
};
nitobi.lang.defineNs("nitobi.data");
if(false){
nitobi.data=function(){
};
}
nitobi.data.DATAMODE_UNBOUND="unbound";
nitobi.data.DATAMODE_LOCAL="local";
nitobi.data.DATAMODE_REMOTE="remote";
nitobi.data.DATAMODE_CACHING="caching";
nitobi.data.DATAMODE_STATIC="static";
nitobi.data.DATAMODE_PAGING="paging";
nitobi.data.DataSet=function(){
var _5ac="http://www.nitobi.com";
this.doc=nitobi.xml.createXmlDoc("<"+nitobi.xml.nsPrefix+"datasources xmlns:ntb=\""+_5ac+"\"></"+nitobi.xml.nsPrefix+"datasources>");
};
nitobi.data.DataSet.prototype.initialize=function(){
this.tables=new Array();
};
nitobi.data.DataSet.prototype.add=function(_5ad){
ntbAssert(!this.tables[_5ad.id],"This table data source has already been added.","",EBA_THROW);
this.tables[_5ad.id]=_5ad;
};
nitobi.data.DataSet.prototype.getTable=function(_5ae){
return this.tables[_5ae];
};
nitobi.data.DataSet.prototype.xmlDoc=function(){
var root=this.doc.documentElement;
while(root.hasChildNodes()){
root.removeChild(root.firstChild);
}
for(var i in this.tables){
if(this.tables[i].xmlDoc&&this.tables[i].xmlDoc.documentElement){
var _5b1=this.tables[i].xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource").cloneNode(true);
this.doc.selectSingleNode("/"+nitobi.xml.nsPrefix+"datasources").appendChild(nitobi.xml.importNode(this.doc,_5b1,true));
}
}
return this.doc;
};
nitobi.data.DataSet.prototype.dispose=function(){
for(var _5b2 in this.tables){
this.tables[_5b2].dispose();
}
};
nitobi.lang.defineNs("nitobi.data");
nitobi.data.DataTable=function(mode,_5b4,_5b5,_5b6,_5b7){
if(_5b4==null){
ntbAssert(false,"Table needs estimateRowCount param");
}
this.estimateRowCount=_5b4;
this.version=3;
this.uid=nitobi.base.getUid();
this.mode=mode||"caching";
this.setAutoKeyEnabled(_5b7);
this.columns=new Array();
this.keys=new Array();
this.types=new Array();
this.defaults=new Array();
this.columnsConfigured=false;
this.pagingConfigured=false;
this.id="_default";
this.fieldMap={};
if(_5b5){
this.saveHandlerArgs=_5b5;
}else{
this.saveHandlerArgs={};
}
if(_5b6){
this.getHandlerArgs=_5b6;
}else{
this.getHandlerArgs={};
}
this.setGetHandlerParameter("RequestType","GET");
this.setSaveHandlerParameter("RequestType","SAVE");
this.batchInsert=false;
this.batchInsertRowCount=0;
};
nitobi.data.DataTable.DEFAULT_LOG="<"+nitobi.xml.nsPrefix+"grid "+nitobi.xml.nsDecl+"><"+nitobi.xml.nsPrefix+"datasources id='id'><"+nitobi.xml.nsPrefix+"datasource id=\"{id}\"><"+nitobi.xml.nsPrefix+"datasourcestructure /><"+nitobi.xml.nsPrefix+"data id=\"_default\"></"+nitobi.xml.nsPrefix+"data></"+nitobi.xml.nsPrefix+"datasource></"+nitobi.xml.nsPrefix+"datasources></"+nitobi.xml.nsPrefix+"grid>";
nitobi.data.DataTable.DEFAULT_DATA="<"+nitobi.xml.nsPrefix+"datasource "+nitobi.xml.nsDecl+" id=\"{id}\"><"+nitobi.xml.nsPrefix+"datasourcestructure FieldNames=\"{fields}\" Keys=\"{keys}\" types=\"{types}\" defaults=\"{defaults}\"></"+nitobi.xml.nsPrefix+"datasourcestructure><"+nitobi.xml.nsPrefix+"data id=\"{id}\"></"+nitobi.xml.nsPrefix+"data></"+nitobi.xml.nsPrefix+"datasource>";
nitobi.data.DataTable.prototype.initialize=function(_5b8,_5b9,_5ba,_5bb,_5bc,sort,_5be,_5bf,_5c0){
this.setGetHandlerParameter("TableId",_5b8);
this.setSaveHandlerParameter("TableId",_5b8);
this.id=_5b8;
this.datastructure=null;
this.descriptor=new nitobi.data.DataTableDescriptor(this,nitobi.lang.close(this,this.syncRowCount),this.estimateRowCount);
this.pageFirstRow=0;
this.pageRowCount=0;
this.pageSize=_5bc;
this.minPageSize=10;
this.requestCache=new nitobi.collections.CacheMap(-1,-1);
this.dataCache=new nitobi.collections.CacheMap(-1,-1);
this.flush();
this.sortColumn=sort;
this.sortDir=_5be||"Asc";
this.filter=new Array();
this.onGenerateKey=_5bf;
this.remoteRowCount=0;
this.setRowCountKnown(false);
if(_5bb==null){
_5bb=0;
}
if(this.mode!="unbound"){
ntbAssert(_5b9!=null&&typeof (_5b9)!="undefined","getHandler is not specified for the nitobi.data.DataTable","",EBA_THROW);
if(_5b9!=null){
this.ajaxCallbackPool=new nitobi.ajax.HttpRequestPool(nitobi.ajax.HttpRequestPool_MAXCONNECTIONS);
this.ajaxCallbackPool.context=this;
this.setGetHandler(_5b9);
this.setSaveHandler(_5ba);
}
this.ajaxCallback=new nitobi.ajax.HttpRequest();
this.ajaxCallback.responseType="xml";
}else{
if(_5b9!=null&&typeof (_5b9)!="string"){
this.initializeXml(_5b9);
}
}
this.sortXslProc=nitobi.xml.createXslProcessor(nitobi.data.sortXslProc.stylesheet);
this.requestQueue=new Array();
this.async=true;
};
nitobi.data.DataTable.prototype.setOnGenerateKey=function(_5c1){
this.onGenerateKey=_5c1;
};
nitobi.data.DataTable.prototype.getOnGenerateKey=function(){
return this.onGenerateKey;
};
nitobi.data.DataTable.prototype.setAutoKeyEnabled=function(val){
this.autoKeyEnabled=val;
};
nitobi.data.DataTable.prototype.isAutoKeyEnabled=function(){
return this.autoKeyEnabled;
};
nitobi.data.DataTable.prototype.initializeXml=function(oXml){
this.replaceData(oXml);
var rows=this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"e").length;
if(rows>0){
var s=this.xmlDoc.xml;
s=nitobi.xml.transformToString(this.xmlDoc,this.sortXslProc,"xml");
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,s);
this.dataCache.insert(0,rows-1);
if(this.mode=="local"){
this.setRowCountKnown(true);
}
}
this.setRemoteRowCount(rows);
this.fire("DataInitalized");
var _5c6=this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("totalrowcount");
_5c6=parseInt(_5c6);
if(!isNaN(_5c6)){
this.totalRowCount=_5c6;
}
this.fire("TotalRowCountReady",this.totalRowCount);
};
nitobi.data.DataTable.prototype.initializeXmlData=function(oXml){
var sXml=oXml;
if(typeof (oXml)=="object"){
sXml=oXml.xml;
}
sXml=sXml.replace(/fieldnames=/g,"FieldNames=").replace(/keys=/g,"Keys=");
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,sXml);
this.datastructure=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"datasourcestructure");
};
nitobi.data.DataTable.prototype.replaceData=function(oXml){
this.initializeXmlData(oXml);
var _5ca=this.datastructure.getAttribute("FieldNames");
var keys=this.datastructure.getAttribute("Keys");
var _5cc=this.datastructure.getAttribute("Defaults");
var _5cd=this.datastructure.getAttribute("Types");
this.initializeColumns(_5ca,keys,_5cd,_5cc);
};
nitobi.data.DataTable.prototype.initializeSchema=function(){
var _5ce=this.columns.join("|");
var keys=this.keys.join("|");
var _5d0=this.defaults.join("|");
var _5d1=this.types.join("|");
this.dataCache.flush();
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,nitobi.data.DataTable.DEFAULT_DATA.replace(/\{id\}/g,this.id).replace(/\{fields\}/g,_5ce).replace(/\{keys\}/g,keys).replace(/\{defaults\}/g,_5d0).replace(/\{types\}/g,_5d1));
this.datastructure=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"datasourcestructure");
};
nitobi.data.DataTable.prototype.initializeColumns=function(_5d2,keys,_5d4,_5d5){
if(null!=_5d2){
var _5d6=this.columns.join("|");
if(_5d6==_5d2){
return;
}
this.columns=_5d2.split("|");
}
if(null!=keys){
this.keys=keys.split("|");
}
if(null!=_5d4){
this.types=_5d4.split("|");
}
if(null!=_5d5){
this.defaults=_5d5.split("|");
}
if(this.xmlDoc.documentElement==null){
this.initializeSchema();
}
this.datastructure=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"datasourcestructure");
var ds=this.datastructure;
if(_5d2){
ds.setAttribute("FieldNames",_5d2);
}
if(keys){
ds.setAttribute("Keys",keys);
}
if(_5d5){
ds.setAttribute("Defaults",_5d5);
}
if(_5d4){
ds.setAttribute("Types",_5d4);
}
this.makeFieldMap();
this.fire("ColumnsInitialized");
};
nitobi.data.DataTable.prototype.getTemplateNode=function(_5d8){
var _5d9=null;
if(_5d8==null){
_5d8=this.defaults;
}
_5d9=nitobi.xml.createElement(this.xmlDoc,"e");
for(var i=0;i<this.columns.length;i++){
var _5db=(i>25?String.fromCharCode(Math.floor(i/26)+97):"")+(String.fromCharCode(i%26+97));
if(this.defaults[i]==null){
_5d9.setAttribute(_5db,"");
}else{
_5d9.setAttribute(_5db,this.defaults[i]);
}
}
return _5d9;
};
nitobi.data.DataTable.prototype.flush=function(){
this.flushCache();
this.flushLog();
this.xmlDoc=nitobi.xml.createXmlDoc();
};
nitobi.data.DataTable.prototype.clearData=function(){
this.flushCache();
this.flushLog();
if(this.xmlDoc){
var _5dc=this.xmlDoc.selectSingleNode("//ntb:data");
nitobi.xml.removeChildren(_5dc);
}
};
nitobi.data.DataTable.prototype.flushCache=function(){
if(this.mode=="caching"||this.mode=="paging"){
this.dataCache.flush();
}
if(this.mode!="unbound"){
this.requestCache.flush();
}
};
nitobi.data.DataTable.prototype.join=function(_5dd,_5de,_5df,_5e0){
};
nitobi.data.DataTable.prototype.merge=function(xd){
};
nitobi.data.DataTable.prototype.getField=function(_5e2,_5e3){
var r=this.getRecord(_5e2);
var a=this.fieldMap[_5e3];
if(a&&r){
return r.getAttribute(a.substring(1));
}else{
return null;
}
};
nitobi.data.DataTable.prototype.getRecord=function(_5e6){
var data=this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xi='"+_5e6+"']");
if(data.length==0){
return null;
}
return data[0];
};
nitobi.data.DataTable.prototype.beginBatchInsert=function(){
this.batchInsert=true;
this.batchInsertRowCount=0;
};
nitobi.data.DataTable.prototype.commitBatchInsert=function(){
this.batchInsert=false;
var _5e8=this.batchInsertRowCount;
this.batchInsertRowCount=0;
this.setRemoteRowCount(this.remoteRowCount+_5e8);
if(_5e8>0){
this.fire("RowInserted",_5e8);
}
};
nitobi.data.DataTable.prototype.createRecord=function(_5e9,_5ea){
var xi=_5ea;
this.adjustXi(parseInt(xi),1);
var data=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
var _5ed=_5e9||this.getTemplateNode();
var _5ee=nitobi.component.getUniqueId();
var _5ef=_5ed.cloneNode(true);
_5ef.setAttribute("xi",xi);
_5ef.setAttribute("xid",_5ee);
_5ef.setAttribute("xac","i");
if(this.onGenerateKey){
var _5f0=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("Keys").split("|");
var xml=null;
for(var j=0;j<_5f0.length;j++){
var _5f3=this.fieldMap[_5f0[j]].substring(1);
var _5f4=_5ef.getAttribute(_5f3);
if(!_5f4||_5f4==""){
if(!xml){
xml=eval(this.onGenerateKey);
}
if(typeof (xml)=="string"||typeof (xml)=="number"){
_5ef.setAttribute(_5f3,xml);
}else{
try{
var ck1=j%26;
var ck2=Math.floor(j/26);
var _5f7=(ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
_5ef.setAttribute(_5f3,xml.selectSingleNode("//"+nitobi.xml.nsPrefix+"e").getAttribute(_5f7));
}
catch(e){
ntbAssert(false,"Key generation failed.","",EBA_THROW);
}
}
}
}
}
data.appendChild(nitobi.xml.importNode(data.ownerDocument,_5ef,true));
if(this.log!=null){
var _5f8=_5ef.cloneNode(true);
_5f8.setAttribute("xac","i");
_5f8.setAttribute("xid",_5ee);
this.logData.appendChild(nitobi.xml.importNode(this.logData.ownerDocument,_5f8,true));
}
this.dataCache.insertIntoRange(_5ea);
this.batchInsertRowCount++;
if(!this.batchInsert){
this.commitBatchInsert();
}
return _5ef;
};
nitobi.data.DataTable.prototype.updateRecord=function(xi,_5fa,_5fb){
var _5fc=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@xi='"+xi+"']");
ntbAssert((null!=_5fc),"Could not find the specified node in the data source.\nTableDataSource: "+this.id+"\nRow: "+xi,"",EBA_THROW);
var xid=_5fc.getAttribute("xid")||"error - unknown xid";
ntbAssert(("error - unknown xid"!=xid),"Could not find the specified node in the update log.\nTableDataSource: "+this.id+"\nRow: "+xi,"",EBA_THROW);
var _5fe=(_5fc.getAttribute(_5fa)!=_5fb);
if(!_5fe){
return;
}
var _5ff="";
var _600=_5fa;
if(_5fc.getAttribute(_5fa)==null&&this.fieldMap[_5fa]!=null){
_600=this.fieldMap[_5fa].substring(1);
}
_5ff=_5fc.getAttribute(_600);
_5fc.setAttribute(_600,_5fb);
var _601="u";
var _602="u";
if(null==this.log){
this.flushLog();
}
var _603=_5fc.cloneNode(true);
_603.setAttribute("xac","u");
this.logData=this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
var _604=this.logData.selectSingleNode("./"+nitobi.xml.nsPrefix+"e[@xid='"+xid+"']");
_603=nitobi.xml.importNode(this.logData.ownerDocument,_603,true);
if(null==_604){
_603=nitobi.xml.importNode(this.logData.ownerDocument,_603,true);
this.logData.appendChild(_603);
_603.setAttribute("xid",xid);
}else{
_603.setAttribute("xac",_604.getAttribute("xac"));
this.logData.replaceChild(_603,_604);
}
if((true==this.AutoSave)){
this.save();
}
this.fire("RowUpdated",{"field":_5fa,"newValue":_5fb,"oldValue":_5ff,"record":_603});
};
nitobi.data.DataTable.prototype.deleteRecord=function(_605){
var data=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
this.logData=this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
var _607=data.selectSingleNode("*[@xi = '"+_605+"']");
this.removeRecordFromXml(_605,_607,data);
this.setRemoteRowCount(this.remoteRowCount-1);
this.fire("RowDeleted");
};
nitobi.data.DataTable.prototype.deleteRecordsArray=function(_608){
var data=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
this.logData=this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
var _60a=null;
var _60b=null;
for(var i=0;i<_608.length;i++){
var data=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
_60b=_608[i]-i;
_60a=data.selectSingleNode("*[@xi = '"+_60b+"']");
this.removeRecordFromXml(_60b,_60a,data);
}
this.setRemoteRowCount(this.remoteRowCount-_608.length);
this.fire("RowDeleted");
};
nitobi.data.DataTable.prototype.removeRecordFromXml=function(_60d,_60e,data){
if(_60e==null){
throw "Index out of bounds in delete.";
}
var xid=_60e.getAttribute("xid");
var xDel=this.logData.selectSingleNode("*[@xid='"+xid+"']");
var sTag="";
if(xDel!=null){
sTag=xDel.getAttribute("xac");
this.logData.removeChild(xDel);
}
if(sTag!="i"){
var _613=_60e.cloneNode(true);
_613.setAttribute("xac","d");
this.logData.appendChild(_613);
}
data.removeChild(_60e);
this.adjustXi(parseInt(_60d)+1,-1);
this.dataCache.removeFromRange(_60d);
};
nitobi.data.DataTable.prototype.adjustXi=function(_614,_615){
nitobi.data.adjustXiXslProc.addParameter("startingIndex",_614,"");
nitobi.data.adjustXiXslProc.addParameter("adjustment",_615,"");
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,nitobi.xml.transformToString(this.xmlDoc,nitobi.data.adjustXiXslProc,"xml"));
if(this.log!=null){
this.log=nitobi.xml.loadXml(this.log,nitobi.xml.transformToString(this.log,nitobi.data.adjustXiXslProc,"xml"));
this.logData=this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
}
};
nitobi.data.DataTable.prototype.setGetHandler=function(val){
this.getHandler=val;
for(var name in this.getHandlerArgs){
this.setGetHandlerParameter(name,this.getHandlerArgs[name]);
}
};
nitobi.data.DataTable.prototype.getGetHandler=function(){
return this.getHandler;
};
nitobi.data.DataTable.prototype.setSaveHandler=function(val){
this.postHandler=val;
for(var name in this.saveHandlerArgs){
this.setSaveHandlerParameter(name,this.saveHandlerArgs[name]);
}
};
nitobi.data.DataTable.prototype.getSaveHandler=function(){
return this.postHandler;
};
nitobi.data.DataTable.prototype.save=function(_61a,_61b){
ntbAssert(this.postHandler!=null&&this.postHandler!="","A postHandler must be defined on the DataTable for saving to work.","",EBA_THROW);
if(!eval(_61b||"true")){
return;
}
try{
if(this.version==2.8){
var _61c=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("FieldNames").split("|");
var _61d=this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac = 'i']");
for(var i=0;i<_61d.length;i++){
for(var j=0;j<_61c.length;j++){
var _620=_61d[i].getAttribute(this.fieldMap[_61c[j]].substring(1));
if(!_620){
_61d[i].setAttribute(this.fieldMap[_61c[j]].substring(1),"");
}
}
_61d[i].setAttribute("xf",this.parentValue);
}
var _621=this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac = 'u']");
for(var i=0;i<_621.length;i++){
for(var j=0;j<_61c.length;j++){
var _620=_621[i].getAttribute(this.fieldMap[_61c[j]].substring(1));
if(!_620){
_621[i].setAttribute(this.fieldMap[_61c[j]].substring(1),"");
}
}
}
nitobi.data.updategramTranslatorXslProc.addParameter("xkField",this.fieldMap["_xk"].substring(1),"");
nitobi.data.updategramTranslatorXslProc.addParameter("fields",_61c.join("|").replace(/\|_xk/,""));
nitobi.data.updategramTranslatorXslProc.addParameter("datasourceId",this.id,"");
this.log=nitobi.xml.transformToXml(this.log,nitobi.data.updategramTranslatorXslProc);
}
var _622=this.getSaveHandler();
(_622.indexOf("?")==-1)?_622+="?":_622+="&";
_622+="TableId="+this.id;
_622+="&uid="+(new Date().getTime());
this.ajaxCallback=this.ajaxCallbackPool.reserve();
ntbAssert(Boolean(this.ajaxCallback),"The datasource is serving too many connections. Please try again later. # current connections: "+this.ajaxCallbackPool.inUse.length);
this.ajaxCallback.handler=_622;
this.ajaxCallback.responseType="xml";
this.ajaxCallback.context=this;
this.ajaxCallback.completeCallback=nitobi.lang.close(this,this.saveComplete);
this.ajaxCallback.params=new nitobi.data.SaveCompleteEventArgs(_61a);
if(this.version>2.8&&this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e[@xac='i']").length>0&&this.isAutoKeyEnabled()){
this.ajaxCallback.async=false;
}
if(this.log.documentElement.nodeName=="root"){
this.log=nitobi.xml.loadXml(this.log,this.log.xml.replace(/xmlns:ntb=\"http:\/\/www.nitobi.com\"/g,""));
var _61c=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasourcestructure").getAttribute("FieldNames").split("|");
_61c.splice(_61c.length-1,1);
_61c=_61c.join("|");
this.log.documentElement.setAttribute("fields",_61c);
this.log.documentElement.setAttribute("keys",_61c);
}
if(this.isAutoKeyEnabled()&&this.version<3){
}
this.ajaxCallback.post(this.log);
this.flushLog();
}
catch(err){
throw err;
}
};
nitobi.data.DataTable.prototype.flushLog=function(){
this.log=nitobi.xml.createXmlDoc(nitobi.data.DataTable.DEFAULT_LOG.replace(/\{id\}/g,this.id).replace(/\{fields\}/g,this.columns).replace(/\{keys\}/g,this.keys).replace(/\{defaults\}/g,this.defaults).replace(/\{types\}/g,this.types));
this.logData=this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data");
};
nitobi.data.DataTable.prototype.updateAutoKeys=function(_623){
try{
var _624=_623.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xac='i']");
if(typeof (_624)=="undefined"||_624==null){
nitobi.lang.throwError("When updating keys from the server for AutoKey support, the inserts could not be parsed.");
}
var keys=_623.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"datasourcestructure")[0].getAttribute("keys").split("|");
if(typeof (keys)=="undefined"||keys==null||keys.length==0){
nitobi.lang.throwError("When updating keys from the server for AutoKey support, no keys could be found. Ensure that the keys are sent in the request response.");
}
for(var i=0;i<_624.length;i++){
var _627=this.getRecord(_624[i].getAttribute("xi"));
for(var j=0;j<keys.length;j++){
var att=this.fieldMap[keys[j]].substring(1);
_627.setAttribute(att,_624[i].getAttribute(att));
}
}
}
catch(err){
nitobi.lang.throwError("When updating keys from the server for AutoKey support, the inserts could not be parsed.",err);
}
};
nitobi.data.DataTable.prototype.saveComplete=function(_62a){
var xd=_62a.response;
var _62a=_62a.params;
try{
if(this.isAutoKeyEnabled()&&this.version>2.8){
this.updateAutoKeys(xd);
}
if(this.version==2.8&&!this.onGenerateKey){
var rows=xd.selectNodes("//insert");
for(var i=0;i<rows.length;i++){
var xk=rows[i].getAttribute("xk");
if(xk!=null){
var _62f=this.findWithoutMap("xid",rows[i].getAttribute("xid"))[0];
var key=this.fieldMap["_xk"].substring(1);
_62f.setAttribute(key,xk);
if(this.primaryField!=null&&this.primaryField.length>0){
var _631=this.fieldMap[this.primaryField].substring(1);
_62f.setAttribute(_631,xk);
}
}
}
}
if(null!=_62a.result){
ntbAssert((null==errorMessage),"Data Save Error:"+errorMessage,EBA_EM_ATTRIBUTE_ERROR,EBA_ERROR);
}
var node=xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource")||xd.selectSingleNode("/root");
var e=null;
if(node){
e=node.getAttribute("error");
}
if(e){
this.setHandlerError(e);
}else{
this.setHandlerError(null);
}
this.ajaxCallbackPool.release(this.ajaxCallback);
var _634=new nitobi.data.OnAfterSaveEventArgs(this,xd);
_62a.callback.call(this,_634);
}
catch(err){
this.ajaxCallbackPool.release(this.ajaxCallback);
ebaErrorReport(err,"",EBA_ERROR);
}
};
nitobi.data.DataTable.prototype.makeFieldMap=function(){
var _635=this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource");
var cf=0;
var ck=0;
this.fieldMap=new Array();
var cF=this.columns.length;
for(var i=0;i<cF;i++){
var _63a=this.columns[i];
this.fieldMap[_63a]=this.getFieldName(ck);
ck++;
}
};
nitobi.data.DataTable.prototype.getFieldName=function(_63b){
var ck1=_63b%26;
var ck2=Math.floor(_63b/26);
return "@"+(ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
};
nitobi.data.DataTable.prototype.find=function(_63e,_63f){
var _640=this.fieldMap[_63e];
if(_640){
return this.findWithoutMap(_640,_63f);
}else{
return new Array();
}
};
nitobi.data.DataTable.prototype.findWithoutMap=function(_641,_642){
if(_641.charAt(0)!="@"){
_641="@"+_641;
}
return this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"e["+_641+"=\""+_642+"\"]");
};
nitobi.data.DataTable.prototype.sort=function(_643,dir,type,_646){
if(_646){
_643=this.fieldMap[_643];
_643=_643.substring(1);
dir=(dir=="Desc")?"descending":"ascending";
type=(type=="number")?"number":"text";
this.sortXslProc.addParameter("column",_643,"");
this.sortXslProc.addParameter("dir",dir,"");
this.sortXslProc.addParameter("type",type,"");
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,nitobi.xml.transformToString(this.xmlDoc,this.sortXslProc,"xml"));
this.fire("DataSorted");
}else{
this.sortColumn=_643;
this.sortDir=dir||"Asc";
}
};
nitobi.data.DataTable.prototype.syncRowCount=function(){
this.setRemoteRowCount(this.descriptor.estimatedRowCount);
};
nitobi.data.DataTable.prototype.setRemoteRowCount=function(rows){
var _648=this.remoteRowCount;
this.remoteRowCount=rows;
if(this.remoteRowCount!=_648){
this.fire("RowCountChanged",rows);
}
};
nitobi.data.DataTable.prototype.getRemoteRowCount=function(){
return this.remoteRowCount;
};
nitobi.data.DataTable.prototype.getRows=function(){
return this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e").length;
};
nitobi.data.DataTable.prototype.getXmlDoc=function(){
return this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']");
};
nitobi.data.DataTable.prototype.getRowNodes=function(){
return this.xmlDoc.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e");
};
nitobi.data.DataTable.prototype.getColumns=function(){
return this.fieldMap.length;
};
nitobi.data.DataTable.prototype.setGetHandlerParameter=function(name,_64a){
if(this.getHandler!=null&&this.getHandler!=""){
this.getHandler=nitobi.html.setUrlParameter(this.getHandler,name,_64a);
}
this.getHandlerArgs[name]=_64a;
};
nitobi.data.DataTable.prototype.setSaveHandlerParameter=function(name,_64c){
if(this.postHandler!=null&&this.postHandler!=""){
this.postHandler=nitobi.html.setUrlParameter(this.getSaveHandler(),name,_64c);
}
this.saveHandlerArgs[name]=_64c;
};
nitobi.data.DataTable.prototype.getChangeLogSize=function(){
if(null==this.log){
return 0;
}
return this.log.selectNodes("//"+nitobi.xml.nsPrefix+"e").length;
};
nitobi.data.DataTable.prototype.getChangeLogXmlDoc=function(){
return this.log;
};
nitobi.data.DataTable.prototype.getDataXmlDoc=function(){
return this.xmlDoc;
};
nitobi.data.DataTable.prototype.dispose=function(){
this.flush();
this.ajaxCallbackPool.context=null;
for(var item in this){
if(this[item]!=null&&this[item].dispose instanceof Function){
this[item].dispose();
}
this[item]=null;
}
};
nitobi.data.DataTable.prototype.getTable=function(_64e,_64f,_650){
this.errorCallback=_650;
var _651=this.ajaxCallbackPool.reserve();
ntbAssert(Boolean(_651),"The datasource is serving too many connections. Please try again later. # current connections: "+this.ajaxCallbackPool.inUse.length);
var _652=this.getGetHandler();
_651.handler=_652;
_651.responseType="xml";
_651.context=this;
_651.completeCallback=nitobi.lang.close(this,this.getComplete);
_651.async=this.async;
_651.params=new nitobi.data.GetCompleteEventArgs(null,null,0,null,_651,this,_64e,_64f);
if(typeof (_64f)!="function"||this.async==false){
_651.async=false;
return this.getComplete({"response":_651.get(),"params":_651.params});
}else{
_651.get();
}
};
nitobi.data.DataTable.prototype.getComplete=function(_653){
var xd=_653.response;
var _655=_653.params;
if(this.mode!="caching"){
this.xmlDoc=nitobi.xml.createXmlDoc();
}
if(null==xd||null==xd.xml||""==xd.xml){
var _656="No parse error.";
if(nitobi.xml.hasParseError(xd)){
if(xd==null){
_656="Blank Response was Given";
}else{
_656=nitobi.xml.getParseErrorReason(xd);
}
}
ntbAssert(null!=this.errorCallback,"The server returned either an error or invalid XML but there is no error handler in the DataTable.\nThe parse error content was:\n"+_656);
if(this.errorCallback){
this.errorCallback.call(this.context);
}
this.fire("DataReady",_655);
return _655;
}else{
if(typeof (this.successCallback)=="function"){
this.successCallback.call(this.context);
}
}
if(!this.configured){
this.configureFromData(xd);
}
xd=this.parseResponse(xd,_655);
xd=this.assignRowIds(xd);
var _657=null;
_657=xd.selectNodes("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e");
var _658;
var _659=_657.length;
if(_655.pageSize==null){
_655.pageSize=_659;
_655.lastRow=_655.startXi+_655.pageSize-1;
_655.firstRow=_655.startXi;
}
if(0!=_659){
ntbAssert(_657[0].getAttribute("xi")==(_655.startXi),"The gethandler returned a different first row than requested.");
_658=parseInt(_657[_657.length-1].getAttribute("xi"));
if(this.mode=="paging"){
this.dataCache.insert(0,_655.pageSize-1);
}else{
this.dataCache.insert(_655.firstRow,_658);
}
}else{
_658=-1;
_655.pageSize=0;
if(this.totalRowCount==null){
var pct=this.descriptor.lastKnownRow/this.descriptor.estimatedRowCount||0;
this.fire("PastEndOfData",pct);
}
}
_655.numRowsReturned=_659;
_655.lastRowReturned=_658;
var _65b=_655.startXi;
var _65c=_655.pageSize;
if(!isNaN(_65b)&&!isNaN(_65c)&&_65b!=0){
this.requestCache.remove(_65b,_65b+_65c-1);
}
if(this.mode!="caching"){
this.replaceData(xd);
}else{
this.mergeData(xd);
}
var _65d=this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("totalrowcount");
_65d=parseInt(_65d);
if(!isNaN(_65d)){
this.totalRowCount=_65d;
}
this.fire("TotalRowCountReady",this.totalRowCount);
var _65e=this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("parentfield");
var _65f=this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("primaryfield");
var _660=this.xmlDoc.selectSingleNode("//ntb:datasource").getAttribute("parentvalue");
this.parentField=_65e||"";
this.parentValue=_660||"";
this.primaryField=_65f||"";
this.updateFromDescriptor(_655);
this.fire("RowCountReady",_655);
if(null!=_655.ajaxCallback){
this.ajaxCallbackPool.release(_655.ajaxCallback);
}
this.executeRequests();
var node=xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource");
var e=null;
if(node){
e=node.getAttribute("error");
}
if(e){
this.setHandlerError(e);
}else{
this.setHandlerError(null);
}
this.fire("DataReady",_655);
if(null!=_655.callback&&null!=_655.context){
_655.callback.call(_655.context,_655);
_655.dispose();
_655=null;
}else{
return _655;
}
};
nitobi.data.DataTable.prototype.executeRequests=function(){
var _663=this.requestQueue;
this.requestQueue=new Array();
for(var i=0;i<_663.length;i++){
_663[i].call();
}
};
nitobi.data.DataTable.prototype.updateFromDescriptor=function(_665){
if(this.totalRowCount==null){
this.descriptor.update(_665);
}
if(this.mode=="paging"){
this.setRemoteRowCount(_665.numRowsReturned);
}else{
if(this.totalRowCount!=null){
this.setRemoteRowCount(this.getTotalRowCount());
}else{
this.setRemoteRowCount(this.descriptor.estimatedRowCount);
}
}
this.setRowCountKnown(this.descriptor.isAtEndOfTable);
};
nitobi.data.DataTable.prototype.setRowCountKnown=function(_666){
var _667=this.rowCountKnown;
this.rowCountKnown=_666;
if(_666&&this.rowCountKnown!=_667){
this.fire("RowCountKnown",this.remoteRowCount);
}
};
nitobi.data.DataTable.prototype.getRowCountKnown=function(){
return this.rowCountKnown;
};
nitobi.data.DataTable.prototype.configureFromData=function(xd){
this.version=this.inferDataVersion(xd);
if(this.mode=="unbound"){
}
if(this.mode=="static"){
}
if(this.mode=="paging"){
}
if(this.mode=="caching"){
}
};
nitobi.data.DataTable.prototype.mergeData=function(xd){
if(this.xmlDoc.xml==""){
this.initializeXml(xd);
return;
}
var p=nitobi.xml.nsPrefix;
var _66b="//"+p+"datasource[@id = '"+this.id+"']/"+p+"data";
var _66c=xd.selectNodes(_66b+"//"+p+"e");
var _66d=this.xmlDoc.selectSingleNode(_66b);
var len=_66c.length;
for(var i=0;i<len;i++){
if(this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xi='"+_66c[i].getAttribute("xi")+"']")){
continue;
}
_66d.appendChild(nitobi.xml.importNode(_66d.ownerDocument,_66c[i],true));
}
};
nitobi.data.DataTable.prototype.assignRowIds=function(xd){
nitobi.data.addXidXslProc.addParameter("guid",nitobi.component.getUniqueId(),"");
var doc=nitobi.xml.loadXml(xd,nitobi.xml.transformToString(xd,nitobi.data.addXidXslProc,"xml"));
return doc;
};
nitobi.data.DataTable.prototype.inferDataVersion=function(xd){
if(xd.selectSingleNode("/root")){
return 2.8;
}
return 3;
};
nitobi.data.DataTable.prototype.parseResponse=function(xd,_674){
if(this.version==2.8){
return this.parseLegacyResponse(xd,_674);
}else{
return this.parseStructuredResponse(xd,_674);
}
};
nitobi.data.DataTable.prototype.parseLegacyResponse=function(xd,_676){
var _677=this.mode=="paging"?0:_676.startXi;
nitobi.data.dataTranslatorXslProc.addParameter("start",_677,"");
nitobi.data.dataTranslatorXslProc.addParameter("id",this.id,"");
var _678=xd.selectSingleNode("/root").getAttribute("fields");
var _679=_678.split("|");
var i=_679.length;
var _67b=(i>25?String.fromCharCode(Math.floor(i/26)+96):"")+(String.fromCharCode(i%26+97));
nitobi.data.dataTranslatorXslProc.addParameter("xkField",_67b,"");
xd=nitobi.xml.transformToXml(xd,nitobi.data.dataTranslatorXslProc);
return xd;
};
nitobi.data.DataTable.prototype.parseStructuredResponse=function(xd,_67d){
xd=nitobi.xml.loadXml(xd,"<ntb:grid xmlns:ntb=\"http://www.nitobi.com\"><ntb:datasources>"+xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']").xml+"</ntb:datasources></ntb:grid>");
var _67e=xd.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.id+"']/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e");
var _67f=this.mode=="paging"?0:_67d.startXi;
if(_67e){
ntbAssert(Boolean(_67e.getAttribute("xi")),"No xi was returned in the data from the server. Server must return xi's in the new format.","",EBA_THROW);
ntbAssert(_67f>=0,"startXI is incorrect.");
if(_67e.getAttribute("xi")!=_67f){
nitobi.data.adjustXiXslProc.addParameter("startingIndex","0","");
nitobi.data.adjustXiXslProc.addParameter("adjustment",_67f,"");
xd=nitobi.xml.loadXml(xd,nitobi.xml.transformToString(xd,nitobi.data.adjustXiXslProc,"xml"));
}
}
return xd;
};
nitobi.data.DataTable.prototype.forceGet=function(_680,_681,_682,_683,_684,_685){
this.errorCallback=_684;
this.successCallback=_685;
this.context=_682;
var _686=this.getGetHandler();
(_686.indexOf("?")==-1)?_686+="?":_686+="&";
_686+="StartRecordIndex=0&start=0&PageSize="+_681+"&SortColumn="+(this.sortColumn||"")+"&SortDirection="+this.sortDir+"&TableId="+this.id+"&uid="+(new Date().getTime());
var _687=this.ajaxCallbackPool.reserve();
ntbAssert(Boolean(_687),"The datasource is serving too many connections. Please try again later. # current connections: "+this.ajaxCallbackPool.inUse.length);
_687.handler=_686;
_687.responseType="xml";
_687.context=this;
_687.completeCallback=nitobi.lang.close(this,this.getComplete);
_687.params=new nitobi.data.GetCompleteEventArgs(0,_681-1,0,_681,_687,this,_682,_683);
_687.get();
return;
};
nitobi.data.DataTable.prototype.getPage=function(_688,_689,_68a,_68b,_68c,_68d){
ntbAssert(this.getHandler.indexOf("GridId")!=-1,"The gethandler has not gridId specified on it.");
var _68e=_688+_689-1;
var _68f=this.dataCache.gaps(0,_689-1);
var _690=_68f.length;
if(_690){
var _691=this.requestCache.gaps(_688,_68e);
if(_691.length==0){
var _692=nitobi.lang.close(this,this.get,arguments);
this.requestQueue.push(_692);
return;
}
this.getFromServer(_688,_68e,_688,_68e,_68a,_68b,_68c);
}else{
this.getFromCache(_688,_689,_68a,_68b,_68c);
}
};
nitobi.data.DataTable.prototype.get=function(_693,_694,_695,_696,_697){
this.errorCallback=_697;
var _698=null;
if(this.mode=="caching"){
_698=this.getCached(_693,_694,_695,_696,_697);
}
if(this.mode=="local"||this.mode=="static"){
_698=this.getTable(_695,_696,_697);
}
if(this.mode=="paging"){
_698=this.getPage(_693,_694,_695,_696,_697);
}
return _698;
};
nitobi.data.DataTable.prototype.inCache=function(_699,_69a){
if(this.mode=="local"){
return true;
}
var _69b=_699,_69c=_699+_69a-1;
var _69d=this.getRemoteRowCount()-1;
if(this.getRowCountKnown()&&_69d<_69c){
_69c=_69d;
}
var _69e=this.dataCache.gaps(_69b,_69c);
var _69f=_69e.length;
return !(_69f>0);
};
nitobi.data.DataTable.prototype.cachedRanges=function(_6a0,_6a1){
return this.dataCache.ranges(_6a0,_6a1);
};
nitobi.data.DataTable.prototype.getCached=function(_6a2,_6a3,_6a4,_6a5,_6a6,_6a7){
if(_6a3==null){
return this.getFromServer(_6a8,null,_6a2,null,_6a4,_6a5,_6a6);
}
var _6a8=_6a2,_6a9=_6a2+_6a3-1;
var _6aa=this.dataCache.gaps(_6a8,_6a9);
var _6ab=_6aa.length;
ntbAssert(_6ab==_6aa.length,"numCacheGaps != gaps.length despite setting it so. Concurrency problem has arisen.");
if(this.mode!="unbound"&&_6ab>0){
var low=_6aa[_6ab-1].low;
var high=_6aa[_6ab-1].high;
var _6ae=this.requestCache.gaps(low,high);
if(_6ae.length==0){
var _6af=nitobi.lang.close(this,this.get,arguments);
this.requestQueue.push(_6af);
return;
}
return this.getFromServer(_6a8,_6a9,low,high,_6a4,_6a5,_6a6);
}else{
this.getFromCache(_6a2,_6a3,_6a4,_6a5,_6a6);
}
};
nitobi.data.DataTable.prototype.getFromServer=function(_6b0,_6b1,low,high,_6b4,_6b5,_6b6){
ntbAssert(this.getHandler!=null&&typeof (this.getHandler)!="undefined","getHandler not defined in table eba.datasource",EBA_THROW);
this.requestCache.insert(low,high);
var _6b7=(_6b1==null?null:(high-low+1));
var _6b8=(_6b7==null?"":_6b7);
var _6b9=this.getGetHandler();
(_6b9.indexOf("?")==-1)?_6b9+="?":_6b9+="&";
_6b9+="StartRecordIndex="+low+"&start="+low+"&PageSize="+(_6b8)+"&SortColumn="+(this.sortColumn||"")+"&SortDirection="+this.sortDir+"&uid="+(new Date().getTime());
var _6ba=this.ajaxCallbackPool.reserve();
ntbAssert(Boolean(_6ba),"The datasource is serving too many connections. Please try again later. # current connections: "+this.ajaxCallbackPool.inUse.length);
_6ba.handler=_6b9;
_6ba.responseType="xml";
_6ba.context=this;
_6ba.completeCallback=nitobi.lang.close(this,this.getComplete);
_6ba.async=this.async;
_6ba.params=new nitobi.data.GetCompleteEventArgs(_6b0,_6b1,low,_6b7,_6ba,this,_6b4,_6b5);
return _6ba.get();
};
nitobi.data.DataTable.prototype.getFromCache=function(_6bb,_6bc,_6bd,_6be,_6bf){
var _6c0=_6bb,_6c1=_6bb+_6bc-1;
if(_6c0>0||_6c1>0){
if(typeof (_6be)=="function"){
var _6c2=new nitobi.data.GetCompleteEventArgs(_6c0,_6c1,_6c0,_6c1-_6c0+1,null,this,_6bd,_6be);
_6c2.callback.call(_6c2.context,_6c2);
}
}
};
nitobi.data.DataTable.prototype.mergeFromXml=function(_6c3,_6c4){
var _6c5=Number(_6c3.documentElement.firstChild.getAttribute("xi"));
var _6c6=Number(_6c3.documentElement.lastChild.getAttribute("xi"));
var _6c7=this.dataCache.gaps(_6c5,_6c6);
if(this.mode=="local"&&_6c7.length==1){
this.dataCache.insert(_6c7[0].low,_6c7[0].high);
this.mergeFromXmlGetComplete(_6c3,_6c4,_6c5,_6c6);
this.batchInsertRowCount=(_6c7[0].high-_6c7[0].low+1);
this.commitBatchInsert();
return;
}
if(_6c7.length==0){
this.mergeFromXmlGetComplete(_6c3,_6c4,_6c5,_6c6);
}else{
if(_6c7.length==1){
this.get(_6c7[0].low,_6c7[0].high-_6c7[0].low+1,this,nitobi.lang.close(this,this.mergeFromXmlGetComplete,[_6c3,_6c4,_6c5,_6c6]));
}else{
this.forceGet(_6c5,_6c6,this,nitobi.lang.close(this,this.mergeFromXmlGetComplete,[_6c3,_6c4,_6c5,_6c6]));
}
}
};
nitobi.data.DataTable.prototype.mergeFromXmlGetComplete=function(_6c8,_6c9,_6ca,_6cb){
var _6cc=nitobi.xml.createElement(this.xmlDoc,"newdata");
_6cc.appendChild(_6c8.documentElement.cloneNode(true));
this.xmlDoc.documentElement.appendChild(nitobi.xml.importNode(this.xmlDoc,_6cc,true));
nitobi.data.mergeEbaXmlXslProc.addParameter("startRowIndex",_6ca,"");
nitobi.data.mergeEbaXmlXslProc.addParameter("endRowIndex",_6cb,"");
nitobi.data.mergeEbaXmlXslProc.addParameter("guid",nitobi.component.getUniqueId(),"");
this.xmlDoc=nitobi.xml.loadXml(this.xmlDoc,nitobi.xml.transformToString(this.xmlDoc,nitobi.data.mergeEbaXmlXslProc,"xml"));
_6cc=nitobi.xml.createElement(this.log,"newdata");
var _6cd=_6c8.selectNodes("//"+nitobi.xml.nsPrefix+"e");
var _6ce=0;
for(var i=0;i<_6cd.length;i++){
_6ce=_6cd[i].attributes.getNamedItem("xi").value;
_6cc.appendChild(this.xmlDoc.selectSingleNode("/"+nitobi.xml.nsPrefix+"grid/"+nitobi.xml.nsPrefix+"datasources/"+nitobi.xml.nsPrefix+"datasource/"+nitobi.xml.nsPrefix+"data/"+nitobi.xml.nsPrefix+"e[@xi="+_6ce+"]").cloneNode(true));
}
this.log.documentElement.appendChild(nitobi.xml.importNode(this.log,_6cc,true));
nitobi.data.mergeEbaXmlToLogXslProc.addParameter("defaultAction","u","");
this.log=nitobi.xml.loadXml(this.log,nitobi.xml.transformToString(this.log,nitobi.data.mergeEbaXmlToLogXslProc,"xml"));
this.xmlDoc.documentElement.removeChild(this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"newdata"));
this.log.documentElement.removeChild(this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"newdata"));
_6c9.call();
};
nitobi.data.DataTable.prototype.fillColumn=function(_6d0,_6d1){
nitobi.data.fillColumnXslProc.addParameter("column",this.fieldMap[_6d0].substring(1));
nitobi.data.fillColumnXslProc.addParameter("value",_6d1);
this.xmlDoc.loadXML(nitobi.xml.transformToString(this.xmlDoc,nitobi.data.fillColumnXslProc,"xml"));
var _6d2=parseFloat((new Date()).getTime());
var _6d3=nitobi.xml.createElement(this.log,"newdata");
this.log.documentElement.appendChild(nitobi.xml.importNode(this.log,_6d3,true));
_6d3.appendChild(this.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"data").cloneNode(true));
nitobi.data.mergeEbaXmlToLogXslProc.addParameter("defaultAction","u");
this.log.loadXML(nitobi.xml.transformToString(this.log,nitobi.data.mergeEbaXmlToLogXslProc,"xml"));
nitobi.data.mergeEbaXmlToLogXslProc.addParameter("defaultAction","");
this.log.documentElement.removeChild(this.log.selectSingleNode("//"+nitobi.xml.nsPrefix+"newdata"));
};
nitobi.data.DataTable.prototype.getTotalRowCount=function(){
return this.totalRowCount;
};
nitobi.data.DataTable.prototype.setHandlerError=function(_6d4){
this.handlerError=_6d4;
};
nitobi.data.DataTable.prototype.getHandlerError=function(){
return this.handlerError;
};
nitobi.data.DataTable.prototype.dispose=function(){
this.sortXslProc=null;
this.requestQueue=null;
this.fieldMap=null;
};
nitobi.data.DataTable.prototype.fire=function(evt,args){
return nitobi.event.notify(evt+this.uid,args);
};
nitobi.data.DataTable.prototype.subscribe=function(evt,func,_6d9){
if(typeof (_6d9)=="undefined"){
_6d9=this;
}
return nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_6d9,func));
};
nitobi.lang.defineNs("nitobi.data");
nitobi.data.DataTableDescriptor=function(_6da,_6db,_6dc){
this.disposal=[];
this.estimatedRowCount=0;
this.leapMultiplier=2;
this.estimateRowCount=(_6dc==null?true:_6dc);
this.lastKnownRow=0;
this.isAtEndOfTable=false;
this.table=_6da;
this.lowestEmptyRow=0;
this.tableProjectionUpdatedEvent=_6db;
this.disposal.push(this.tableProjectionUpdatedEvent);
};
nitobi.data.DataTableDescriptor.prototype.startPeek=function(){
this.enablePeek=true;
this.peek();
};
nitobi.data.DataTableDescriptor.prototype.peek=function(){
var _6dd;
if(this.lowestEmptyRow>0){
var _6de=this.lowestEmptyRow-this.lastKnownRow;
_6dd=this.lastKnownRow+Math.round(_6de/2);
}else{
_6dd=(this.estimatedRowCount*this.leapMultiplier);
}
this.table.get(Math.round(_6dd),1,this,this.peekComplete);
};
nitobi.data.DataTableDescriptor.prototype.peekComplete=function(_6df){
if(this.enablePeek){
window.setTimeout(nitobi.lang.close(this,this.peek),1000);
}
};
nitobi.data.DataTableDescriptor.prototype.stopPeek=function(){
this.enablePeek=false;
};
nitobi.data.DataTableDescriptor.prototype.leap=function(_6e0,_6e1){
if(this.lowestEmptyRow>0){
var _6e2=this.lowestEmptyRow-this.lastKnownRow;
this.estimatedRowCount=this.lastKnownRow+Math.round(_6e2/2);
}else{
if(_6e0==null||_6e1==null){
this.estimatedRowCount=0;
}else{
if(this.estimateRowCount){
this.estimatedRowCount=(this.estimatedRowCount*_6e0)+_6e1;
}
}
}
this.fireProjectionUpdatedEvent();
};
nitobi.data.DataTableDescriptor.prototype.update=function(_6e3,_6e4){
if(null==_6e4){
_6e4=false;
}
if(this.isAtEndOfTable&&!_6e4){
return false;
}
var _6e5=(_6e3!=null&&_6e3.numRowsReturned==0&&_6e3.startXi==0);
var _6e6=(_6e3!=null&&_6e3.lastRow!=_6e3.lastRowReturned);
if(null==_6e3){
_6e3={lastPage:false,pageSize:1,firstRow:0,lastRow:0,startXi:0};
}
var _6e7=(_6e5)||(_6e6)||(this.isAtEndOfTable)||((this.lastKnownRow==this.estimatedRowCount-1)&&(this.estimatedRowCount==this.lowestEmptyRow));
if(_6e3.pageSize==0&&!_6e7){
this.lowestEmptyRow=this.lowestEmptyRow>0?Math.min(_6e3.startXi,this.lowestEmptyRow):_6e3.startXi;
this.leap();
return true;
}
this.lastKnownRow=Math.max(_6e3.lastRowReturned,this.lastKnownRow);
if(_6e7&&!_6e4){
if(_6e3.lastRowReturned>=0){
this.estimatedRowCount=_6e3.lastRowReturned+1;
this.isAtEndOfTable=true;
}else{
if(_6e5){
this.estimatedRowCount=0;
this.isAtEndOfTable=true;
}else{
this.estimatedRowCount=this.lastKnownRow+Math.ceil((_6e3.lastRow-this.lastKnownRow)/2);
}
}
this.fireProjectionUpdatedEvent();
this.stopPeek();
return true;
}
if(!this.estimateRowCount){
this.estimatedRowCount=this.lastKnownRow+1;
}
if(this.estimatedRowCount==0){
this.estimatedRowCount=(_6e3.lastRow+1)*(this.estimateRowCount?2:1);
}
if((this.estimatedRowCount>(_6e3.lastRow+1)&&!_6e4)||!this.estimateRowCount){
return false;
}
if(!this.isAtEndOfTable){
this.leap(this.leapMultiplier,0);
return true;
}
return false;
};
nitobi.data.DataTableDescriptor.prototype.reset=function(){
this.estimatedRowCount=0;
this.leapMultiplier=2;
this.lastKnownRow=0;
this.isAtEndOfTable=false;
this.lowestEmptyRow=0;
this.fireProjectionUpdatedEvent();
};
nitobi.data.DataTableDescriptor.prototype.fireProjectionUpdatedEvent=function(_6e8){
if(this.tableProjectionUpdatedEvent!=null){
this.tableProjectionUpdatedEvent(_6e8);
}
};
nitobi.data.DataTableDescriptor.prototype.dispose=function(){
nitobi.lang.dispose(this,this.disposal);
};
nitobi.lang.defineNs("nitobi.data");
if(false){
nitobi.data=function(){
};
}
nitobi.data.DataTableEventArgs=function(_6e9){
this.source=_6e9;
this.event=nitobi.html.Event;
};
nitobi.data.DataTableEventArgs.prototype.getSource=function(){
return this.source;
};
nitobi.data.DataTableEventArgs.prototype.getEvent=function(){
return this.event;
};
nitobi.data.GetCompleteEventArgs=function(_6ea,_6eb,_6ec,_6ed,_6ee,_6ef,obj,_6f1){
this.firstRow=_6ea;
this.lastRow=_6eb;
this.callback=_6f1;
this.dataSource=_6ef;
this.context=obj;
this.ajaxCallback=_6ee;
this.startXi=_6ec;
this.pageSize=_6ed;
this.lastPage=false;
this.status="success";
};
nitobi.data.GetCompleteEventArgs.prototype.dispose=function(){
this.callback=null;
this.context=null;
this.dataSource=null;
this.ajaxCallback.clear();
this.ajaxCallback==null;
};
nitobi.data.SaveCompleteEventArgs=function(_6f2){
this.callback=_6f2;
};
nitobi.data.SaveCompleteEventArgs.prototype.initialize=function(){
};
nitobi.data.OnAfterSaveEventArgs=function(_6f3,_6f4,_6f5){
nitobi.data.OnAfterSaveEventArgs.baseConstructor.call(this,_6f3);
this.success=_6f5;
this.responseData=_6f4;
};
nitobi.lang.extend(nitobi.data.OnAfterSaveEventArgs,nitobi.data.DataTableEventArgs);
nitobi.data.OnAfterSaveEventArgs.prototype.getResponseData=function(){
return this.responseData;
};
nitobi.data.OnAfterSaveEventArgs.prototype.getSuccess=function(){
return this.success;
};
nitobi.lang.defineNs("nitobi.form");
if(false){
nitobi.form=function(){
};
}
nitobi.form.Control=function(){
this.owner=null;
this.placeholder=null;
var div=nitobi.html.createElement("div");
div.innerHTML="<table border='0' cellpadding='0' cellspacing='0' class='ntb-input-border'><tr><td></td></tr></table>";
var ph=this.placeholder=div.firstChild;
this.cell=null;
this.ignoreBlur=false;
this.editCompleteHandler=function(){
};
this.onKeyUp=new nitobi.base.Event();
this.onKeyDown=new nitobi.base.Event();
this.onKeyPress=new nitobi.base.Event();
this.onChange=new nitobi.base.Event();
this.onCancel=new nitobi.base.Event();
this.onTab=new nitobi.base.Event();
this.onEnter=new nitobi.base.Event();
};
nitobi.form.Control.prototype.initialize=function(){
};
nitobi.form.Control.prototype.mimic=function(){
};
nitobi.form.Control.prototype.deactivate=function(evt){
if(this.ignoreBlur){
return false;
}
this.ignoreBlur=true;
};
nitobi.form.Control.prototype.bind=function(_6f9,cell){
this.owner=_6f9;
this.cell=cell;
this.ignoreBlur=false;
};
nitobi.form.Control.prototype.hide=function(){
this.placeholder.style.left="-2000px";
};
nitobi.form.Control.prototype.attachToParent=function(_6fb){
_6fb.appendChild(this.placeholder);
};
nitobi.form.Control.prototype.show=function(){
this.placeholder.style.display="block";
};
nitobi.form.Control.prototype.focus=function(){
this.control.focus();
this.ignoreBlur=false;
};
nitobi.form.Control.prototype.align=function(){
var oY=1,oX=1,oH=1,oW=1;
if(nitobi.browser.MOZ&&!nitobi.browser.FF3){
var _700=this.owner.getScrollSurface();
var _701=this.owner.getActiveView().region;
if(_701==3||_701==4){
oY=_700.scrollTop-nitobi.form.EDITOR_OFFSETY;
}
if(_701==1||_701==4){
oX=_700.scrollLeft-nitobi.form.EDITOR_OFFSETX;
}
}
nitobi.drawing.align(this.placeholder,this.cell.getDomNode(),286265344,oH,oW,-oY,-oX);
};
nitobi.form.Control.prototype.selectText=function(){
this.focus();
if(this.control&&this.control.createTextRange){
var _702=this.control.createTextRange();
_702.collapse(false);
_702.select();
}
};
nitobi.form.Control.prototype.checkValidity=function(evt){
var _704=this.deactivate(evt);
if(_704==false){
nitobi.html.cancelBubble(evt);
return false;
}
return true;
};
nitobi.form.Control.prototype.handleKey=function(evt){
var k=evt.keyCode;
if(this.onKeyDown.notify(evt)==false){
return;
}
var K=nitobi.form.Keys;
var y=0;
var x=0;
if(k==K.UP){
y=-1;
}else{
if(k==K.DOWN){
y=1;
}else{
if(k==K.TAB){
x=1;
if(evt.shiftKey){
x=-1;
}
if(nitobi.browser.IE){
evt.keyCode="";
}
}else{
if(k==K.ENTER){
y=1;
}else{
if(k==K.ESC){
this.ignoreBlur=true;
this.hide();
this.owner.focus();
this.onCancel.notify(this);
}
return;
}
}
}
}
if(!this.checkValidity(evt)){
return;
}
this.owner.move(x,y);
nitobi.html.cancelBubble(evt);
};
nitobi.form.Control.prototype.handleKeyUp=function(evt){
this.onKeyUp.notify(evt);
};
nitobi.form.Control.prototype.handleKeyPress=function(evt){
this.onKeyPress.notify(evt);
};
nitobi.form.Control.prototype.handleChange=function(evt){
this.onChange.notify(evt);
};
nitobi.form.Control.prototype.setEditCompleteHandler=function(_70d){
this.editCompleteHandler=_70d;
};
nitobi.form.Control.prototype.eSET=function(name,args){
var _710=args[0];
var _711=_710;
var _712=name.substr(2);
_712=_712.substr(0,_712.length-5);
if(typeof (_710)=="string"){
_711=function(){
return nitobi.event.evaluate(_710,arguments[0]);
};
}
if(this[_712]!=null){
this[name].unSubscribe(this[_712]);
}
var guid=this[name].subscribe(_711);
this.jSET(_712,[guid]);
return guid;
};
nitobi.form.Control.prototype.afterDeactivate=function(text,_715){
_715=_715||text;
if(this.editCompleteHandler!=null){
var _716=new nitobi.grid.EditCompleteEventArgs(this,text,_715,this.cell);
var _717=this.editCompleteHandler.call(this.owner,_716);
if(!_717){
this.ignoreBlur=false;
}
return _717;
}
};
nitobi.form.Control.prototype.jSET=function(name,val){
this[name]=val[0];
};
nitobi.form.Control.prototype.dispose=function(){
for(var item in this){
}
};
nitobi.form.IBlurable=function(_71b,_71c){
this.selfBlur=false;
this.elements=_71b;
var H=nitobi.html;
for(var i=0;i<this.elements.length;i++){
var e=this.elements[i];
H.attachEvent(e,"mousedown",this.handleMouseDown,this);
H.attachEvent(e,"blur",this.handleBlur,this);
H.attachEvent(e,"focus",this.handleFocus,this);
H.attachEvent(e,"mouseup",this.handleMouseUp,this);
}
this.blurFunc=_71c;
this.lastFocus=null;
};
nitobi.form.IBlurable.prototype.removeBlurable=function(){
for(var i=0;i<elems.length;i++){
nitobi.html.detachEvent(elems[i],"mousedown",this.handleMouseDown,this);
}
};
nitobi.form.IBlurable.prototype.handleMouseDown=function(evt){
if(this.lastFocus!=evt.srcElement){
this.selfBlur=true;
}else{
this.selfBlur=false;
}
this.lastFocus=evt.srcElement;
};
nitobi.form.IBlurable.prototype.handleBlur=function(evt){
if(!this.selfBlur){
this.blurFunc(evt);
}
this.selfBlur=false;
};
nitobi.form.IBlurable.prototype.handleFocus=function(){
this.selfBlur=false;
};
nitobi.form.IBlurable.prototype.handleMouseUp=function(){
this.selfBlur=false;
};
nitobi.form.Text=function(){
nitobi.form.Text.baseConstructor.call(this);
var ph=this.placeholder;
ph.setAttribute("id","text_span");
ph.style.top="0px";
ph.style.left="-5000px";
var tc=this.control=nitobi.html.createElement("input",{"id":"ntb-textbox"},{"style":"width: 100px;"});
tc.setAttribute("maxlength",255);
this.events=[{type:"keydown",handler:this.handleKey},{type:"keyup",handler:this.handleKeyUp},{type:"keypress",handler:this.handleKeyPress},{type:"change",handler:this.handleChange},{type:"blur",handler:this.deactivate}];
};
nitobi.lang.extend(nitobi.form.Text,nitobi.form.Control);
nitobi.form.Text.prototype.initialize=function(){
var _725=this.placeholder.rows[0].cells[0];
_725.appendChild(this.control);
nitobi.html.attachEvents(this.control,this.events,this);
};
nitobi.form.Text.prototype.bind=function(_726,cell,_728){
nitobi.form.Text.base.bind.apply(this,arguments);
if(_728!=null&&_728!=""){
this.control.value=_728;
}else{
this.control.value=cell.getValue();
}
var _729=this.cell.getColumnObject().getModel();
this.eSET("onKeyPress",[_729.getAttribute("OnKeyPressEvent")]);
this.eSET("onKeyDown",[_729.getAttribute("OnKeyDownEvent")]);
this.eSET("onKeyUp",[_729.getAttribute("OnKeyUpEvent")]);
this.eSET("onChange",[_729.getAttribute("OnChangeEvent")]);
this.control.setAttribute("maxlength",_729.getAttribute("MaxLength"));
nitobi.html.Css.addClass(this.control,"ntb-column-data"+this.owner.uid+"_"+(this.cell.getColumn()+1));
};
nitobi.form.Text.prototype.mimic=function(){
if(nitobi.browser.MOZ||nitobi.browser.SAFARI){
var _72a=this.cell.getDomNode();
this.control.style.width=_72a.clientWidth+"px";
}
this.align();
nitobi.html.fitWidth(this.placeholder,this.control);
this.selectText();
};
nitobi.form.Text.prototype.focus=function(){
this.control.focus();
};
nitobi.form.Text.prototype.deactivate=function(evt){
if(nitobi.form.Text.base.deactivate.apply(this,arguments)==false){
return;
}
nitobi.html.Css.removeClass(this.control,"ntb-column-data"+this.owner.uid+"_"+(this.cell.getColumn()+1));
return this.afterDeactivate(this.control.value);
};
nitobi.form.Text.prototype.dispose=function(){
nitobi.html.detachEvents(this.control,this.events);
var _72c=this.placeholder.parentNode;
_72c.removeChild(this.placeholder);
this.control=null;
this.owner=null;
this.cell=null;
};
nitobi.form.Checkbox=function(){
};
nitobi.lang.extend(nitobi.form.Checkbox,nitobi.form.Control);
nitobi.form.Checkbox.prototype.mimic=function(){
if(false==eval(this.owner.getOnCellValidateEvent())){
return;
}
this.toggle();
this.deactivate();
};
nitobi.form.Checkbox.prototype.deactivate=function(){
this.afterDeactivate(this.value);
};
nitobi.form.Checkbox.prototype.attachToParent=function(){
};
nitobi.form.Checkbox.prototype.toggle=function(){
var _72d=this.cell.getColumnObject();
var _72e=_72d.getModel();
var _72f=_72e.getAttribute("CheckedValue");
if(_72f==""||_72f==null){
_72f=1;
}
var _730=_72e.getAttribute("UnCheckedValue");
if(_730==""||_730==null){
_730=0;
}
this.value=(this.cell.getData().value==_72f)?_730:_72f;
};
nitobi.form.Checkbox.prototype.hide=function(){
};
nitobi.form.Checkbox.prototype.dispose=function(){
this.metadata=null;
this.owner=null;
this.context=null;
};
nitobi.form.Date=function(){
nitobi.form.Date.baseConstructor.call(this);
};
nitobi.lang.extend(nitobi.form.Date,nitobi.form.Text);
nitobi.lang.defineNs("nitobi.form");
nitobi.form.EDITOR_OFFSETX=0;
nitobi.form.EDITOR_OFFSETY=0;
nitobi.form.ControlFactory=function(){
this.editors={};
};
nitobi.form.ControlFactory.prototype.getEditor=function(_731,_732,_733){
var _734=null;
if(null==_732){
ebaErrorReport("getEditor: column parameter is null","",EBA_DEBUG);
return _734;
}
var _735=_732.getType();
var _736=_732.getType();
var _737="nitobi.Grid"+_735+_736+"Editor";
_734=this.editors[_737];
if(_734==null||_734.control==null){
switch(_735){
case "LINK":
case "HYPERLINK":
_734=new nitobi.form.Link;
break;
case "IMAGE":
return null;
case "BUTTON":
return null;
case "LOOKUP":
_734=new nitobi.form.Lookup();
break;
case "LISTBOX":
_734=new nitobi.form.ListBox();
break;
case "PASSWORD":
_734=new nitobi.form.Password();
break;
case "TEXTAREA":
_734=new nitobi.form.TextArea();
break;
case "CHECKBOX":
_734=new nitobi.form.Checkbox();
break;
default:
if(_736=="DATE"){
if(_732.isCalendarEnabled()){
_734=new nitobi.form.Calendar();
}else{
_734=new nitobi.form.Date();
}
}else{
if(_736=="NUMBER"){
_734=new nitobi.form.Number();
}else{
_734=new nitobi.form.Text();
}
}
break;
}
_734.initialize();
}
this.editors[_737]=_734;
return _734;
};
nitobi.form.ControlFactory.prototype.dispose=function(){
for(var _738 in this.editors){
this.editors[_738].dispose();
}
};
nitobi.form.ControlFactory.instance=new nitobi.form.ControlFactory();
nitobi.form.Link=function(){
};
nitobi.lang.extend(nitobi.form.Link,nitobi.form.Control);
nitobi.form.Link.prototype.initialize=function(){
this.url="";
};
nitobi.form.Link.prototype.bind=function(_739,cell){
nitobi.form.Link.base.bind.apply(this,arguments);
this.url=this.cell.getValue();
};
nitobi.form.Link.prototype.mimic=function(){
if(false==eval(this.owner.getOnCellValidateEvent())){
return;
}
this.click();
this.deactivate();
};
nitobi.form.Link.prototype.deactivate=function(){
this.afterDeactivate(this.value);
};
nitobi.form.Link.prototype.click=function(){
this.control=window.open(this.url);
this.value=this.url;
};
nitobi.form.Link.prototype.hide=function(){
};
nitobi.form.Link.prototype.attachToParent=function(){
};
nitobi.form.Link.prototype.dispose=function(){
this.metadata=null;
this.owner=null;
this.context=null;
};
nitobi.form.ListBox=function(){
nitobi.form.ListBox.baseConstructor.call(this);
var ph=this.placeholder;
ph.setAttribute("id","listbox_span");
ph.style.top="0px";
ph.style.left="-5000px";
this.metadata=null;
this.keypress=false;
this.typedString=null;
this.events=[{type:"change",handler:this.deactivate},{type:"keydown",handler:this.handleKey},{type:"keyup",handler:this.handleKeyUp},{type:"keypress",handler:this.handleKeyPress},{type:"blur",handler:this.deactivate}];
};
nitobi.lang.extend(nitobi.form.ListBox,nitobi.form.Control);
nitobi.form.ListBox.prototype.initialize=function(){
};
nitobi.form.ListBox.prototype.bind=function(_73c,cell){
nitobi.form.ListBox.base.bind.apply(this,arguments);
var _73e=cell.getColumnObject().getModel();
var _73f=_73e.getAttribute("DatasourceId");
this.dataTable=this.owner.data.getTable(_73f);
this.eSET("onKeyPress",[_73e.getAttribute("OnKeyPressEvent")]);
this.eSET("onKeyDown",[_73e.getAttribute("OnKeyDownEvent")]);
this.eSET("onKeyUp",[_73e.getAttribute("OnKeyUpEvent")]);
this.eSET("onChange",[_73e.getAttribute("OnChangeEvent")]);
this.bindComplete(cell.getValue());
};
nitobi.form.ListBox.prototype.bindComplete=function(_740){
var _741=this.dataTable.xmlDoc.selectSingleNode("//"+nitobi.xml.nsPrefix+"datasource[@id='"+this.dataTable.id+"']");
var _742=this.cell.getColumnObject();
var _743=_742.getModel();
var _744=_743.getAttribute("DisplayFields");
var _745=_743.getAttribute("ValueField");
var xsl=nitobi.form.listboxXslProc;
xsl.addParameter("DisplayFields",_744,"");
xsl.addParameter("ValueField",_745,"");
xsl.addParameter("val",_740,"");
this.listXml=nitobi.xml.transformToXml(nitobi.xml.createXmlDoc(_741.xml),xsl);
this.placeholder.rows[0].cells[0].innerHTML=nitobi.xml.serialize(this.listXml);
var tc=this.control=nitobi.html.getFirstChild(this.placeholder.rows[0].cells[0]);
tc.style.width="100%";
tc.style.height=(this.cell.DomNode.offsetHeight-2)+"px";
nitobi.html.attachEvents(tc,this.events,this);
nitobi.html.Css.addClass(tc.className,this.cell.getDomNode().className);
this.align();
this.focus();
if(typeof (_740)!="undefined"&&_740!=null&&_740!=""){
return this.searchComplete(_740);
}
};
nitobi.form.ListBox.prototype.deactivate=function(ok){
if(this.keypress){
this.keypress=false;
return;
}
if(nitobi.form.ListBox.base.deactivate.apply(this,arguments)==false){
return;
}
if(this.onChange.notify(this)==false){
return;
}
var c=this.control;
var text="",_74b="";
if(ok||ok==null){
text=c.options[c.selectedIndex].text;
_74b=c.options[c.selectedIndex].value;
}else{
_74b=this.cell.getValue();
var len=c.options.length;
for(var i=0;i<len;i++){
if(c.options[i].value==_74b){
text=c.options[i].text;
}
}
}
this.typedString=null;
return this.afterDeactivate(nitobi.html.encode(text),_74b);
};
nitobi.form.ListBox.prototype.handleKey=function(evt){
var k=evt.keyCode;
this.keypress=false;
var K=nitobi.form.Keys;
switch(k){
case K.DOWN:
if(this.control.selectedIndex<this.control.options.length-1){
this.keypress=true;
}
break;
case K.UP:
if(this.control.selectedIndex>0){
this.keypress=true;
}
break;
case K.ENTER:
case K.TAB:
case K.ESC:
return nitobi.form.ListBox.base.handleKey.call(this,evt);
default:
nitobi.html.cancelEvent(evt);
return this.searchComplete(String.fromCharCode(k));
}
};
nitobi.form.ListBox.prototype.searchComplete=function(_751,_752){
if(typeof (_752)!="undefined"&&_752!=""){
this.typedString=_752;
this.maxLinearSearch=500;
}else{
this.typedString=this.typedString+_751;
}
var c=this.control;
var _754=c.options.length;
if(_754>this.maxLinearSearch){
var _755=this.searchBinary(this.typedString,0,(_754-1));
if(_755){
for(i=_755;i>0;i--){
if(c.options[i].text.toLowerCase().substr(0,this.typedString.length)!=this.typedString.toLowerCase()){
c.selectedIndex=i+1;
break;
}
}
}
}else{
for(i=1;i<_754;i++){
if(c.options[i].text.toLowerCase().substr(0,this.typedString.length)==this.typedString.toLowerCase()){
c.selectedIndex=i;
break;
}
}
}
clearTimeout(this.timerid);
var _756=this;
this.timerid=setTimeout(function(){
_756.typedString="";
},1000);
return false;
};
nitobi.form.ListBox.prototype.searchBinary=function(_757,low,high){
if(low>high){
return null;
}
var c=this.control;
var mid=Math.floor((high+low)/2);
var _75c=c.options[mid].text.toLowerCase().substr(0,_757.length);
var _75d=_757.toLowerCase();
if(_75d==_75c){
return mid;
}else{
if(_75d<_75c){
return this.searchBinary(_757,low,(mid-1));
}else{
if(_75d>_75c){
return this.searchBinary(_757,(mid+1),high);
}else{
return null;
}
}
}
};
nitobi.form.ListBox.prototype.dispose=function(){
nitobi.html.detachEvents(this.control,this.events);
this.placeholder=null;
this.control=null;
this.listXml=null;
this.element=null;
this.metadata=null;
this.owner=null;
};
nitobi.form.Lookup=function(){
nitobi.form.Lookup.baseConstructor.call(this);
this.selectClicked=false;
this.bVisible=false;
var div=nitobi.html.createElement("div");
div.innerHTML="<table class='ntb-input-border' border='0' cellpadding='0' cellspacing='0'><tr><td class=\"ntb-lookup-text\"></td></tr><tr><td style=\"position:relative;\"><div style=\"position:relative;top:0px;left:0px;\"></div></td></tr></table>";
var ph=this.placeholder=div.firstChild;
ph.setAttribute("id","lookup_span");
ph.style.top="-0px";
ph.style.left="-5000px";
var tc=this.control=nitobi.html.createElement("input",{autocomplete:"off"},{zIndex:"2000",width:"100px"});
tc.setAttribute("id","ntb-lookup-text");
this.textEvents=[{type:"keydown",handler:this.handleKey},{type:"keyup",handler:this.filter},{type:"keypress",handler:this.handleKeyPress},{type:"change",handler:this.handleChange},{type:"blur",handler:function(){
}},{type:"focus",handler:function(){
}}];
ph.rows[0].cells[0].appendChild(tc);
this.selectPlaceholder=ph.rows[1].cells[0].firstChild;
this.selectEvents=[{"type":"click","handler":this.handleSelectClicked}];
this.firstKeyup=false;
this.autocompleted=false;
this.referenceColumn=null;
this.autoComplete=null;
this.autoClear=null;
this.getOnEnter=null;
this.listXml=null;
this.listXmlLower=null;
this.editCompleteHandler=null;
this.delay=0;
this.timeoutId=null;
var xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">";
xsl+="<xsl:output method=\"text\" version=\"4.0\"/><xsl:param name='searchValue'/>";
xsl+="<xsl:template match=\"/\"><xsl:apply-templates select='//option[starts-with(.,$searchValue)][1]' /></xsl:template>";
xsl+="<xsl:template match=\"option\"><xsl:value-of select='@rn' /></xsl:template></xsl:stylesheet>";
var _762=nitobi.xml.createXslDoc(xsl);
this.searchXslProc=nitobi.xml.createXslProcessor(_762);
_762=null;
};
nitobi.lang.extend(nitobi.form.Lookup,nitobi.form.Control);
nitobi.lang.implement(nitobi.form.Lookup,nitobi.ui.IDataBoundList);
nitobi.lang.implement(nitobi.form.Lookup,nitobi.form.IBlurable);
nitobi.form.Lookup.prototype.initialize=function(){
this.firstKeyup=false;
nitobi.html.attachEvents(this.control,this.textEvents,this);
nitobi.html.attachEvents(this.selectPlaceholder,this.selectEvents,this);
};
nitobi.form.Lookup.prototype.hideSelect=function(){
this.selectControl.style.display="none";
this.bVisible=false;
};
nitobi.form.Lookup.prototype.bind=function(_763,cell,_765){
nitobi.form.Lookup.base.bind.apply(this,arguments);
var col=this.column=this.cell.getColumnObject();
var _767=this.column.getModel();
this.datasourceId=col.getDatasourceId();
this.getHandler=col.getGetHandler();
this.delay=col.getDelay();
this.size=col.getSize();
this.referenceColumn=col.getReferenceColumn();
this.autoComplete=col.isAutoComplete();
this.autoClear=col.isAutoClear();
this.getOnEnter=col.isGetOnEnter();
this.displayFields=col.getDisplayFields();
this.valueField=col.getValueField();
this.eSET("onKeyPress",[col.getOnKeyPressEvent()]);
this.eSET("onKeyDown",[col.getOnKeyDownEvent()]);
this.eSET("onKeyUp",[col.getOnKeyUpEvent()]);
this.eSET("onChange",[col.getOnChangeEvent()]);
var _768=nitobi.form.listboxXslProc;
_768.addParameter("DisplayFields",this.displayFields,"");
_768.addParameter("ValueField",this.valueField,"");
this.dataTable=this.owner.data.getTable(this.datasourceId);
this.dataTable.setGetHandler(this.getHandler);
this.dataTable.async=false;
if(_765.length<=0){
_765=this.cell.getValue();
}
this.get(_765,true);
};
nitobi.form.Lookup.prototype.getComplete=function(_769){
var _76a=this.dataTable.getXmlDoc();
var _76b=nitobi.form.listboxXslProc;
_76b.addParameter("DisplayFields",this.displayFields,"");
_76b.addParameter("ValueField",this.valueField,"");
_76b.addParameter("val",nitobi.xml.constructValidXpathQuery(this.cell.getValue(),false),"");
if(nitobi.browser.IE&&document.compatMode=="CSS1Compat"){
_76b.addParameter("size",6,"");
}
this.listXml=nitobi.xml.transformToXml(nitobi.xml.createXmlDoc(_76a.xml),nitobi.form.listboxXslProc);
this.listXmlLower=nitobi.xml.createXmlDoc(this.listXml.xml.toLowerCase());
if(nitobi.browser.IE&&document.compatMode=="CSS1Compat"){
_76b.addParameter("size","","");
}
this.selectPlaceholder.innerHTML=nitobi.xml.serialize(this.listXml);
var tc=this.control;
var sc=this.selectControl=nitobi.html.getFirstChild(this.selectPlaceholder);
sc.setAttribute("id","ntb-lookup-options");
sc.setAttribute("size",this.size);
sc.style.display="none";
if(nitobi.browser.IE6&&document.compatMode!="CSS1Compat"){
sc.style.height="100%";
}
nitobi.form.IBlurable.call(this,[tc,sc],this.deactivate);
this.selectClicked=false;
this.bVisible=false;
this.align();
nitobi.html.fitWidth(this.placeholder,this.control);
if(this.autoComplete){
var rn=this.search(_769);
if(rn>0){
sc.selectedIndex=rn-1;
tc.value=sc[sc.selectedIndex].text;
nitobi.html.highlight(tc,tc.value.length-(tc.value.length-_769.length));
this.autocompleted=true;
}else{
var row=_76a.selectSingleNode("//"+nitobi.xml.nsPrefix+"e[@"+this.valueField+"='"+_769+"']");
if(row!=null){
tc.value=row.getAttribute(this.displayFields);
var rn=this.search(tc.value);
sc.selectedIndex=parseInt(rn)-1;
}else{
tc.value=_769;
sc.selectedIndex=-1;
}
}
}else{
tc.value=_769;
sc.selectedIndex=-1;
}
tc.parentNode.style.height=nitobi.html.getHeight(this.cell.getDomNode())+"px";
sc.style.display="inline";
tc.focus();
};
nitobi.form.Lookup.prototype.handleSelectClicked=function(evt){
this.control.value=this.selectControl.selectedIndex!=-1?this.selectControl.options[this.selectControl.selectedIndex].text:"";
this.deactivate(evt);
};
nitobi.form.Lookup.prototype.focus=function(evt){
this.control.focus();
};
nitobi.form.Lookup.prototype.deactivate=function(evt){
if(nitobi.form.Lookup.base.deactivate.apply(this,arguments)==false){
return;
}
var sc=this.selectControl;
var tc=this.control;
var text="",_776="";
if(evt!=null&&evt!=false){
if(sc.selectedIndex>=0){
_776=sc.options[sc.selectedIndex].value;
text=sc.options[sc.selectedIndex].text;
}else{
if(this.column.getModel().getAttribute("ForceValidOption")!="true"){
_776=tc.value;
text=_776;
}else{
if(this.autoClear){
_776="";
text="";
}else{
_776=this.cell.getValue();
var len=sc.options.length;
for(var i=0;i<len;i++){
if(sc.options[i].value==_776){
text=sc.options[i].text;
}
}
}
}
}
}else{
_776=this.cell.getValue();
var len=sc.options.length;
var _779=false;
for(var i=0;i<len;i++){
if(sc.options[i].value==_776){
text=sc.options[i].text;
_779=true;
break;
}
}
if(!_779&&this.autoClear){
_776="";
text="";
}
}
nitobi.html.detachEvents(sc,this.textEvents);
window.clearTimeout(this.timeoutId);
return this.afterDeactivate(nitobi.html.encode(text),_776);
};
nitobi.form.Lookup.prototype.handleKey=function(evt,_77b){
var k=evt.keyCode;
if(k!=40&&k!=38){
nitobi.form.Lookup.base.handleKey.call(this,evt);
}
};
nitobi.form.Lookup.prototype.search=function(_77d){
_77d=nitobi.xml.constructValidXpathQuery(_77d,false);
this.searchXslProc.addParameter("searchValue",_77d.toLowerCase(),"");
var _77e=nitobi.xml.transformToString(this.listXmlLower,this.searchXslProc);
if(""==_77e){
_77e=0;
}else{
_77e=parseInt(_77e);
}
return _77e;
};
nitobi.form.Lookup.prototype.filter=function(evt,o){
var k=evt.keyCode;
if(this.onKeyUp.notify(evt)==false){
return;
}
if(!this.firstKeyup&&k!=38&&k!=40){
this.firstKeyup=true;
return;
}
var tc=this.control;
var sc=this.selectControl;
switch(k){
case 38:
if(sc.selectedIndex==-1){
sc.selectedIndex=0;
}
if(sc.selectedIndex>0){
sc.selectedIndex--;
}
tc.value=sc.options[sc.selectedIndex].text;
nitobi.html.highlight(tc,tc.value.length);
tc.select();
break;
case 40:
if(sc.selectedIndex<(sc.length-1)){
sc.selectedIndex++;
}
tc.value=sc.options[sc.selectedIndex].text;
nitobi.html.highlight(tc,tc.value.length);
tc.select();
break;
default:
if((!this.getOnEnter&&((k<193&&k>46)||k==8||k==32))||(this.getOnEnter&&k==13)){
var _784=tc.value;
this.get(_784);
}
}
};
nitobi.form.Lookup.prototype.get=function(_785,_786){
if(this.getHandler!=null&&this.getHandler!=""){
if(_786||!this.delay){
this.doGet(_785);
}else{
if(this.timeoutId){
window.clearTimeout(this.timeoutId);
this.timeoutId=null;
}
this.timeoutId=window.setTimeout(nitobi.lang.close(this,this.doGet,[_785]),this.delay);
}
}else{
this.getComplete(_785);
}
};
nitobi.form.Lookup.prototype.doGet=function(_787){
if(_787){
this.dataTable.setGetHandlerParameter("SearchString",_787);
}
if(this.referenceColumn!=null&&this.referenceColumn!=""){
var _788=this.owner.getCellValue(this.cell.row,this.referenceColumn);
this.dataTable.setGetHandlerParameter("ReferenceColumn",_788);
}
this.dataTable.get(null,this.pageSize,this);
this.timeoutId=null;
this.getComplete(_787);
};
nitobi.form.Lookup.prototype.dispose=function(){
this.placeholder=null;
nitobi.html.detachEvents(this.textEvents,this);
this.selectControl=null;
this.control=null;
this.dataTable=null;
this.owner=null;
};
nitobi.form.Number=function(){
nitobi.form.Number.baseConstructor.call(this);
this.defaultValue=0;
};
nitobi.lang.extend(nitobi.form.Number,nitobi.form.Text);
nitobi.form.Number.prototype.handleKey=function(evt){
nitobi.form.Number.base.handleKey.call(this,evt);
var k=evt.keyCode;
if(!this.isValidKey(k)){
nitobi.html.cancelEvent(evt);
return false;
}
};
nitobi.form.Number.prototype.isValidKey=function(k){
if((k<48||k>57)&&(k<37||k>40)&&(k<96||k>105)&&k!=190&&k!=110&&k!=189&&k!=109&&k!=9&&k!=45&&k!=46&&k!=8){
return false;
}
return true;
};
nitobi.form.Number.prototype.bind=function(_78c,cell,_78e){
var _78f=_78e.charCodeAt(0);
if(_78f>=97){
_78f=_78f-32;
}
var k=this.isValidKey(_78f)?_78e:"";
nitobi.form.Number.base.bind.call(this,_78c,cell,k);
};
nitobi.form.Password=function(){
nitobi.form.Password.baseConstructor.call(this,true);
this.control.type="password";
};
nitobi.lang.extend(nitobi.form.Password,nitobi.form.Text);
nitobi.form.TextArea=function(){
nitobi.form.TextArea.baseConstructor.call(this);
var div=nitobi.html.createElement("div");
div.innerHTML="<table border='0' cellpadding='0' cellspacing='0' class='ntb-input-border'><tr><td></td></table>";
var ph=this.placeholder=div.firstChild;
ph.style.top="-3000px";
ph.style.left="-3000px";
this.control=nitobi.html.createElement("textarea",{},{width:"100px"});
};
nitobi.lang.extend(nitobi.form.TextArea,nitobi.form.Text);
nitobi.form.TextArea.prototype.initialize=function(){
this.placeholder.rows[0].cells[0].appendChild(this.control);
document.body.appendChild(this.placeholder);
nitobi.html.attachEvents(this.control,this.events,this);
};
nitobi.form.TextArea.prototype.mimic=function(){
nitobi.form.TextArea.base.mimic.call(this);
var phs=this.placeholder.style;
};
nitobi.form.TextArea.prototype.handleKey=function(evt){
var k=evt.keyCode;
if(k==40||k==38||k==37||k==39||(k==13&&evt.shiftKey)){
}else{
nitobi.form.TextArea.base.handleKey.call(this,evt);
}
};
nitobi.form.Calendar=function(){
nitobi.form.Calendar.baseConstructor.call(this);
var div=nitobi.html.createElement("div");
div.innerHTML="<table border='0' cellpadding='0' cellspacing='0' style='table-layout:fixed;' class='ntb-input-border'><tr><td>"+"<input id='ntb-datepicker-input' type='text' maxlength='255' style='width:100%;' />"+"</td><td class='ntb-datepicker-button'><a id='ntb-datepicker-button' href='#' onclick='return false;'></a></td></tr><tr><td colspan='2' style='width:1px;height:1px;position:relative;'><!-- --></td></tr><colgroup><col></col><col style='width:20px;'></col></colgroup></table>";
this.control=div.getElementsByTagName("input")[0];
var ph=this.placeholder=div.firstChild;
ph.setAttribute("id","calendar_span");
ph.style.top="-3000px";
ph.style.left="-3000px";
var pd=this.pickerDiv=nitobi.html.createElement("div",{},{position:"absolute"});
this.isPickerVisible=false;
nitobi.html.Css.addClass(pd,NTB_CSS_HIDE);
ph.rows[1].cells[0].appendChild(pd);
};
nitobi.lang.extend(nitobi.form.Calendar,nitobi.form.Control);
nitobi.form.Calendar.prototype.initialize=function(){
var dp=this.datePicker=new nitobi.calendar.DatePicker(nitobi.component.getUniqueId());
dp.setAttribute("theme","flex");
dp.setObject(new nitobi.calendar.Calendar());
dp.onDateSelected.subscribe(this.handlePick,this);
dp.setContainer(this.pickerDiv);
var tc=this.control;
var H=nitobi.html;
H.attachEvent(tc,"keydown",this.handleKey,this,false);
H.attachEvent(tc,"blur",this.deactivate,this,false);
H.attachEvent(this.pickerDiv,"mousedown",this.handleCalendarMouseDown,this);
H.attachEvent(this.pickerDiv,"mouseup",this.handleCalendarMouseUp,this);
var a=this.placeholder.getElementsByTagName("a")[0];
H.attachEvent(a,"mousedown",this.handleClick,this);
H.attachEvent(a,"mouseup",this.handleMouseUp,this);
};
nitobi.form.Calendar.prototype.bind=function(_79d,cell,_79f){
this.isPickerVisible=false;
nitobi.html.Css.addClass(this.pickerDiv,NTB_CSS_HIDE);
nitobi.form.Calendar.base.bind.apply(this,arguments);
if(_79f!=null&&_79f!=""){
this.control.value=_79f;
}else{
this.control.value=cell.getValue();
}
this.column=this.cell.getColumnObject();
this.control.maxlength=this.column.getModel().getAttribute("MaxLength");
};
nitobi.form.Calendar.prototype.mimic=function(){
this.align();
var _7a0=this.placeholder.offsetWidth;
var _7a1=this.placeholder.rows[0].cells[1].offsetWidth;
this.control.style.width=_7a0-_7a1-(document.compatMode=="BackCompat"?0:8)+"px";
this.selectText();
};
nitobi.form.Calendar.prototype.deactivate=function(){
if(nitobi.form.Calendar.base.deactivate.apply(this,arguments)==false){
return;
}
this.afterDeactivate(this.control.value);
};
nitobi.form.Calendar.prototype.handleClick=function(evt){
if(!this.isPickerVisible){
var dp=this.datePicker;
dp.setSelectedDate(nitobi.base.DateMath.parseIso8601(this.control.value));
dp.render();
dp.getCalendar().getHtmlNode().style.overflow="visible";
dp.getCalendar().getHtmlNode().style.width="182px";
nitobi.html.Css.setStyle(dp.getCalendar().getHtmlNode(),"position","fixed");
}
this.ignoreBlur=true;
nitobi.ui.Effects.setVisible(this.pickerDiv,!this.isPickerVisible,"none",this.setVisibleComplete,this);
};
nitobi.form.Calendar.prototype.handleMouseUp=function(evt){
this.control.focus();
this.ignoreBlur=false;
};
nitobi.form.Calendar.prototype.handleCalendarMouseDown=function(evt){
this.ignoreBlur=true;
};
nitobi.form.Calendar.prototype.handleCalendarMouseUp=function(evt){
this.ignoreBlur=false;
};
nitobi.form.Calendar.prototype.setVisibleComplete=function(){
this.isPickerVisible=!this.isPickerVisible;
};
nitobi.form.Calendar.prototype.handlePick=function(){
this.control.focus();
var date=this.datePicker.getSelectedDate();
var _7a8=nitobi.base.DateMath.toIso8601(date);
this.control.value=_7a8;
this.datePicker.hide();
};
nitobi.form.Calendar.prototype.dispose=function(){
nitobi.html.detachEvent(this.control,"keydown",this.handleKey);
nitobi.html.detachEvent(this.control,"blur",this.deactivate);
var _7a9=this.placeholder.parentNode;
_7a9.removeChild(this.placeholder);
this.control=null;
this.placeholder=null;
this.owner=null;
this.cell=null;
};
nitobi.lang.defineNs("nitobi.form");
nitobi.form.Keys={UP:38,DOWN:40,ENTER:13,TAB:9,ESC:27,RIGHT:39,LEFT:37};
nitobi.ui.UiElement=function(xml,xsl,id){
if(arguments.length>0){
this.initialize(xml,xsl,id);
}
};
nitobi.ui.UiElement.prototype.initialize=function(xml,xsl,id){
this.m_Xml=xml;
this.m_Xsl=xsl;
this.m_Id=id;
this.m_HtmlElementHandle=null;
};
nitobi.ui.UiElement.prototype.getHeight=function(){
return this.getHtmlElementHandle().style.height;
};
nitobi.ui.UiElement.prototype.setHeight=function(_7b0){
this.getHtmlElementHandle().style.height=_7b0+"px";
};
nitobi.ui.UiElement.prototype.getId=function(){
return this.m_Id;
};
nitobi.ui.UiElement.prototype.setId=function(id){
this.m_Id=id;
};
nitobi.ui.UiElement.prototype.getWidth=function(){
return this.getHtmlElementHandle().style.width;
};
nitobi.ui.UiElement.prototype.setWidth=function(_7b2){
if(_7b2>0){
this.getHtmlElementHandle().style.width=_7b2+"px";
}
};
nitobi.ui.UiElement.prototype.getXml=function(){
return this.m_Xml;
};
nitobi.ui.UiElement.prototype.setXml=function(xml){
this.m_Xml=xml;
};
nitobi.ui.UiElement.prototype.getXsl=function(){
return this.m_Xsl;
};
nitobi.ui.UiElement.prototype.setXsl=function(xsl){
this.m_Xsl=xsl;
};
nitobi.ui.UiElement.prototype.getHtmlElementHandle=function(){
if(!this.m_HtmlElementHandle){
this.m_HtmlElementHandle=document.getElementById(this.m_Id);
}
return this.m_HtmlElementHandle;
};
nitobi.ui.UiElement.prototype.setHtmlElementHandle=function(_7b5){
this.m_HtmlElementHandle=_7b5;
};
nitobi.ui.UiElement.prototype.hide=function(){
var tag=this.getHtmlElementHandle();
tag.style.visibility="hidden";
tag.style.position="absolute";
};
nitobi.ui.UiElement.prototype.show=function(){
var tag=this.getHtmlElementHandle();
tag.style.visibility="visible";
};
nitobi.ui.UiElement.prototype.isVisible=function(){
var tag=this.getHtmlElementHandle();
return tag.style.visibility=="visible";
};
nitobi.ui.UiElement.prototype.beginFloatMode=function(){
var tag=this.getHtmlElementHandle();
tag.style.position="absolute";
};
nitobi.ui.UiElement.prototype.isFloating=function(){
var tag=this.getHtmlElementHandle();
return tag.style.position=="absolute";
};
nitobi.ui.UiElement.prototype.setX=function(x){
var tag=this.getHtmlElementHandle();
tag.style.left=x+"px";
};
nitobi.ui.UiElement.prototype.getX=function(){
var tag=this.getHtmlElementHandle();
return tag.style.left;
};
nitobi.ui.UiElement.prototype.setY=function(y){
var tag=this.getHtmlElementHandle();
tag.style.top=y+"px";
};
nitobi.ui.UiElement.prototype.getY=function(){
var tag=this.getHtmlElementHandle();
return tag.style.top;
};
nitobi.ui.UiElement.prototype.render=function(_7c1,_7c2,_7c3){
var xsl=this.m_Xsl;
if(xsl!=null&&xsl.indexOf("xsl:stylesheet")==-1){
xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:output method=\"html\" version=\"4.0\" />"+xsl+"</xsl:stylesheet>";
}
if(null==_7c2){
_7c2=nitobi.xml.createXslDoc(xsl);
}
if(null==_7c3){
_7c3=nitobi.xml.createXmlDoc(this.m_Xml);
}
Eba.Error.assert(nitobi.xml.isValidXml(_7c3),"Tried to render invalid XML according to Mozilla. The XML is "+_7c3.xml);
var html=nitobi.xml.transform(_7c3,_7c2);
if(html.xml){
html=html.xml;
}
if(null==_7c1){
nitobi.html.insertAdjacentHTML(document.body,"beforeEnd",html);
}else{
_7c1.innerHTML=html;
}
this.attachToTag();
};
nitobi.ui.UiElement.prototype.attachToTag=function(){
var _7c6=this.getHtmlElementHandle();
if(_7c6!=null){
_7c6.object=this;
_7c6.jsobject=this;
_7c6.javascriptObject=this;
}
};
nitobi.ui.UiElement.prototype.dispose=function(){
var _7c7=this.getHtmlElementHandle();
if(_7c7!=null){
_7c7.object=null;
}
this.m_Xml=null;
this.m_Xsl=null;
this.m_HtmlElementHandle=null;
};
nitobi.ui.InteractiveUiElement=function(_7c8){
this.enable();
};
nitobi.lang.extend(nitobi.ui.InteractiveUiElement,nitobi.ui.UiElement);
nitobi.ui.InteractiveUiElement.prototype.enable=function(){
this.m_Enabled=true;
};
nitobi.ui.InteractiveUiElement.prototype.disable=function(){
this.m_Enabled=false;
};
nitobi.ui.ButtonXsl="<xsl:template match=\"button\">"+"<div class=\"ntb-button\" onmousemove=\"return false;\" onmousedown=\"if (this.object.m_Enabled) this.className='ntb-button-down';\" onmouseup=\"this.className='ntb-button';\" onmouseover=\"if (this.object.m_Enabled) this.className='ntb-button-highlight';\" onmouseout=\"this.className='ntb-button';\" align=\"center\">"+"<xsl:attribute name=\"image_disabled\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory and not(starts-with(@image_disabled,'/'))\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image_disabled)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image_disabled\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"image_enabled\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory and not(starts-with(@image,'/'))\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"title\">"+"<xsl:value-of select=\"@tooltip_text\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"onclick\">"+"<xsl:value-of select='concat(&quot;v&quot;,&quot;a&quot;,&quot;r&quot;,&quot; &quot;,&quot;e&quot;,&quot;=&quot;,&quot;&apos;&quot;,@onclick_event,&quot;&apos;&quot;,&quot;;&quot;,&quot;e&quot;,&quot;v&quot;,&quot;a&quot;,&quot;l&quot;,&quot;(&quot;,&quot;t&quot;,&quot;h&quot;,&quot;i&quot;,&quot;s&quot;,&quot;.&quot;,&quot;o&quot;,&quot;b&quot;,&quot;j&quot;,&quot;e&quot;,&quot;c&quot;,&quot;t&quot;,&quot;.&quot;,&quot;o&quot;,&quot;n&quot;,&quot;C&quot;,&quot;l&quot;,&quot;i&quot;,&quot;c&quot;,&quot;k&quot;,&quot;H&quot;,&quot;a&quot;,&quot;n&quot;,&quot;d&quot;,&quot;l&quot;,&quot;e&quot;,&quot;r&quot;,&quot;(&quot;,&quot;e&quot;,&quot;)&quot;,&quot;)&quot;,&quot;;&quot;,&apos;&apos;)' />"+"</xsl:attribute>"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:choose>"+"<xsl:when test=\"../../@height\">"+"<xsl:value-of select=\"concat('float:left;width:',../../@height,'px;height:',../../@height - 1,'px')\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"concat('float:left;width:',@width,'px;height:',@height,'px')\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<img border=\"0\">"+"<xsl:attribute name=\"src\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory and not(starts-with(@image,'/'))\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:variable name=\"top_offset\">"+"<xsl:choose>"+"<xsl:when test=\"@top_offset\">"+"<xsl:value-of select=\"@top_offset\" />"+"</xsl:when>"+"<xsl:otherwise>"+"0"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:variable>"+"<xsl:choose>"+"<xsl:when test=\"../../@height\">"+"<xsl:value-of select=\"concat('MARGIN-TOP:',((../../@height - @height) div 2) - 1 + number($top_offset),'px;MARGIN-BOTTOM:0px')\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"concat('MARGIN-TOP:',(@height - @image_height) div 2,'px;MARGIN-BOTTOM:0','px')\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"</img><![CDATA[ ]]>"+"</div>"+"</xsl:template>";
nitobi.ui.Button=function(xml,id){
this.initialize(xml,nitobi.ui.ButtonXsl,id);
this.enable();
};
nitobi.lang.extend(nitobi.ui.Button,nitobi.ui.InteractiveUiElement);
nitobi.ui.Button.prototype.onClickHandler=function(_7cb){
if(this.m_Enabled){
eval(_7cb);
}
};
nitobi.ui.Button.prototype.disable=function(){
nitobi.ui.Button.base.disable.call(this);
var _7cc=this.getHtmlElementHandle();
_7cc.childNodes[0].src=_7cc.getAttribute("image_disabled");
};
nitobi.ui.Button.prototype.enable=function(){
nitobi.ui.Button.base.enable.call(this);
var _7cd=this.getHtmlElementHandle();
_7cd.childNodes[0].src=_7cd.getAttribute("image_enabled");
};
nitobi.ui.Button.prototype.dispose=function(){
nitobi.ui.Button.base.dispose.call(this);
};
nitobi.ui.BinaryStateButtonXsl="<xsl:template match=\"binarystatebutton\">"+"<div class=\"ntb-binarybutton\" onmousemove=\"return false;\" onmousedown=\"if (this.object.m_Enabled) this.className='ntb-button-down';\" onmouseup=\"(this.object.isChecked()?this.object.check():this.object.uncheck())\" onmouseover=\"if (this.object.m_Enabled) this.className='ntb-button-highlight';\" onmouseout=\"(this.object.isChecked()?this.object.check():this.object.uncheck())\" align=\"center\">"+"<xsl:attribute name=\"image_disabled\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image_disabled)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image_disabled\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"image_enabled\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"title\">"+"<xsl:value-of select=\"@tooltip_text\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"onclick\">"+"<xsl:value-of select='concat(\"this.object.toggle();\",&quot;v&quot;,&quot;a&quot;,&quot;r&quot;,&quot; &quot;,&quot;e&quot;,&quot;=&quot;,&quot;&apos;&quot;,@onclick_event,&quot;&apos;&quot;,&quot;;&quot;,&quot;e&quot;,&quot;v&quot;,&quot;a&quot;,&quot;l&quot;,&quot;(&quot;,&quot;t&quot;,&quot;h&quot;,&quot;i&quot;,&quot;s&quot;,&quot;.&quot;,&quot;o&quot;,&quot;b&quot;,&quot;j&quot;,&quot;e&quot;,&quot;c&quot;,&quot;t&quot;,&quot;.&quot;,&quot;o&quot;,&quot;n&quot;,&quot;C&quot;,&quot;l&quot;,&quot;i&quot;,&quot;c&quot;,&quot;k&quot;,&quot;H&quot;,&quot;a&quot;,&quot;n&quot;,&quot;d&quot;,&quot;l&quot;,&quot;e&quot;,&quot;r&quot;,&quot;(&quot;,&quot;e&quot;,&quot;)&quot;,&quot;)&quot;,&quot;;&quot;,&apos;&apos;)' />"+"</xsl:attribute>"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:choose>"+"<xsl:when test=\"../../@height\">"+"<xsl:value-of select=\"concat('float:left;width:',../../@height,'px;height:',../../@height - 1,'px')\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"concat('float:left;width:',@width,'px;height:',@height,'px')\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<img border=\"0\">"+"<xsl:attribute name=\"src\">"+"<xsl:choose>"+"<xsl:when test=\"../../@image_directory\">"+"<xsl:value-of select=\"concat(../../@image_directory,@image)\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"@image\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:variable name=\"top_offset\">"+"<xsl:choose>"+"<xsl:when test=\"@top_offset\">"+"<xsl:value-of select=\"@top_offset\" />"+"</xsl:when>"+"<xsl:otherwise>"+"0"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:variable>"+"<xsl:choose>"+"<xsl:when test=\"../../@height\">"+"<xsl:value-of select=\"concat('MARGIN-TOP:',((../../@height - @height) div 2) - 1 + number($top_offset),'px;MARGIN-BOTTOM:0px')\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"concat('MARGIN-TOP:',(@height - @image_height) div 2,'px;MARGIN-BOTTOM:0','px')\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:attribute>"+"</img><![CDATA[ ]]>"+"</div>"+"</xsl:template>";
nitobi.ui.BinaryStateButton=function(xml,id){
this.initialize(xml,nitobi.ui.BinaryStateButtonXsl,id);
this.m_Checked=false;
};
nitobi.lang.extend(nitobi.ui.BinaryStateButton,nitobi.ui.Button);
nitobi.ui.BinaryStateButton.prototype.isChecked=function(){
return this.m_Checked;
};
nitobi.ui.BinaryStateButton.prototype.check=function(){
var _7d0=this.getHtmlElementHandle();
_7d0.className="ntb-button-checked";
this.m_Checked=true;
};
nitobi.ui.BinaryStateButton.prototype.uncheck=function(){
var _7d1=this.getHtmlElementHandle();
_7d1.className="ntb-button";
this.m_Checked=false;
};
nitobi.ui.BinaryStateButton.prototype.toggle=function(){
var _7d2=this.getHtmlElementHandle();
if(_7d2.className=="ntb-button-checked"){
this.uncheck();
}else{
this.check();
}
};
nitobi.ui.ToolbarDivItemXsl="<xsl:template match=\"div\"><xsl:copy-of select=\".\"/></xsl:template>";
nitobi.ui.ToolbarXsl="<xsl:template match=\"//toolbar\">"+"<div style=\"z-index:800\">"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">float:left;position:relative;"+"<xsl:value-of select=\"concat('height:',@height,'px')\" />"+"</xsl:attribute>"+"<xsl:apply-templates />"+"</div>"+"</xsl:template>"+nitobi.ui.ToolbarDivItemXsl+nitobi.ui.ButtonXsl+nitobi.ui.BinaryStateButtonXsl+"<xsl:template match=\"separator\">"+"<div align='center'>"+"<xsl:attribute name=\"style\">"+"<xsl:value-of select=\"concat('float:left;width:',@width,';height:',@height)\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<img border='0'>"+"<xsl:attribute name=\"src\">"+"<xsl:value-of select=\"concat(//@image_directory,@image)\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:value-of select=\"concat('MARGIN-TOP:3','px;MARGIN-BOTTOM:0','px')\" />"+"</xsl:attribute>"+"</img>"+"</div>"+"</xsl:template>";
nitobi.ui.pagingToolbarXsl="<xsl:template match=\"//toolbar\">"+"<div style=\"z-index:800\">"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">float:right;position:relative;"+"<xsl:value-of select=\"concat('height:',@height,'px')\" />"+"</xsl:attribute>"+"<xsl:apply-templates />"+"</div>"+"</xsl:template>"+nitobi.ui.ToolbarDivItemXsl+nitobi.ui.ButtonXsl+nitobi.ui.BinaryStateButtonXsl+"<xsl:template match=\"separator\">"+"<div align='center'>"+"<xsl:attribute name=\"style\">"+"<xsl:value-of select=\"concat('float:right;width:',@width,';height:',@height)\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"id\">"+"<xsl:value-of select=\"@id\" />"+"</xsl:attribute>"+"<img border='0'>"+"<xsl:attribute name=\"src\">"+"<xsl:value-of select=\"concat(//@image_directory,@image)\" />"+"</xsl:attribute>"+"<xsl:attribute name=\"style\">"+"<xsl:value-of select=\"concat('MARGIN-TOP:3','px;MARGIN-BOTTOM:0','px')\" />"+"</xsl:attribute>"+"</img>"+"</div>"+"</xsl:template>";
nitobi.ui.Toolbar=function(xml,id){
nitobi.ui.Toolbar.baseConstructor.call(this);
this.initialize(xml,nitobi.ui.ToolbarXsl,id);
};
nitobi.lang.extend(nitobi.ui.Toolbar,nitobi.ui.InteractiveUiElement);
nitobi.ui.Toolbar.prototype.getUiElements=function(){
return this.m_UiElements;
};
nitobi.ui.Toolbar.prototype.setUiElements=function(_7d5){
this.m_UiElements=_7d5;
};
nitobi.ui.Toolbar.prototype.attachButtonObjects=function(){
if(!this.m_UiElements){
this.m_UiElements=new Array();
var tag=this.getHtmlElementHandle();
var _7d7=tag.childNodes;
for(var i=0;i<_7d7.length;i++){
var _7d9=_7d7[i];
if(_7d9.nodeType!=3){
var _7da;
switch(_7d9.className){
case ("ntb-button"):
_7da=new nitobi.ui.Button(null,_7d9.id);
break;
case ("ntb-binarybutton"):
_7da=new nitobi.ui.BinaryStateButton(null,_7d9.id);
break;
default:
_7da=new nitobi.ui.UiElement(null,null,_7d9.id);
break;
}
_7da.attachToTag();
this.m_UiElements[_7d9.id]=_7da;
}
}
}
};
nitobi.ui.Toolbar.prototype.render=function(_7db){
nitobi.ui.Toolbar.base.base.render.call(this,_7db);
this.attachButtonObjects();
};
nitobi.ui.Toolbar.prototype.disableAllElements=function(){
for(var i in this.m_UiElements){
if(this.m_UiElements[i].disable){
this.m_UiElements[i].disable();
}
}
};
nitobi.ui.Toolbar.prototype.enableAllElements=function(){
for(var i in this.m_UiElements){
if(this.m_UiElements[i].enable){
this.m_UiElements[i].enable();
}
}
};
nitobi.ui.Toolbar.prototype.attachToTag=function(){
nitobi.ui.Toolbar.base.base.attachToTag.call(this);
this.attachButtonObjects();
};
nitobi.ui.Toolbar.prototype.dispose=function(){
if(typeof (this.m_UiElements)!="undefined"){
for(var _7de in this.m_UiElements){
this.m_UiElements[_7de].dispose();
}
this.m_UiElements=null;
}
nitobi.ui.Toolbar.base.dispose.call(this);
};
if(typeof (nitobi)=="undefined"||typeof (nitobi.lang)=="undefined"){
alert("The Nitobi framework source could not be found. Is it included before any other Nitobi components?");
}
nitobi.prepare=function(){
};
nitobi.lang.defineNs("nitobi.calendar");
nitobi.calendar.Calendar=function(_7df){
nitobi.calendar.Calendar.baseConstructor.call(this,_7df);
this.selectedDate;
this.renderer=new nitobi.calendar.CalRenderer();
this.onHide=new nitobi.base.Event();
this.eventMap["hide"]=this.onHide;
this.onShow=new nitobi.base.Event();
this.eventMap["show"]=this.onShow;
this.onDateClicked=new nitobi.base.Event();
this.eventMap["dateclicked"]=this.onDateClicked;
this.onMonthChanged=new nitobi.base.Event();
this.eventMap["monthchanged"]=this.onMonthChanged;
this.onYearChanged=new nitobi.base.Event();
this.eventMap["yearchanged"]=this.onYearChanged;
this.onRenderComplete=new nitobi.base.Event();
this.onSetVisible.subscribe(this.handleToggle,this);
this.showEffect=(this.isEffectEnabled()?nitobi.effects.families["shade"].show:null);
this.hideEffect=(this.isEffectEnabled()?nitobi.effects.families["shade"].hide:null);
this.htmlEvents={"body":[],"nav":[],"navconfirm":[],"navcancel":[],"navpanel":[],"nextmonth":[],"prevmonth":[]};
this.subscribeDeclarationEvents();
};
nitobi.lang.extend(nitobi.calendar.Calendar,nitobi.ui.Element);
nitobi.calendar.Calendar.profile=new nitobi.base.Profile("nitobi.calendar.Calendar",null,false,"ntb:calendar");
nitobi.base.Registry.getInstance().register(nitobi.calendar.Calendar.profile);
nitobi.calendar.Calendar.prototype.render=function(){
this.detachEvents();
this.setContainer(this.getHtmlNode());
nitobi.calendar.Calendar.base.render.call(this);
this.selectedDate=this.getParentObject().getSelectedDate();
var he=this.htmlEvents;
var H=nitobi.html;
var _7e2=this.getHtmlNode("body");
H.attachEvent(_7e2,"click",this.handleBodyClick,this);
H.attachEvent(_7e2,"mousedown",this.handleMouseDown,this);
he.body.push({type:"click",handler:this.handleBodyClick});
he.body.push({type:"mousedown",handle:this.handleMouseDown});
var nav=this.getHtmlNode("nav");
var _7e4=this.getHtmlNode("navconfirm");
var _7e5=this.getHtmlNode("navcancel");
H.attachEvent(nav,"click",this.showNav,this);
H.attachEvent(_7e5,"click",this.handleNavCancel,this);
H.attachEvent(_7e4,"click",this.handleNavConfirm,this);
H.attachEvent(this.getHtmlNode("navpanel"),"keypress",this.handleNavKey,this);
he.nav.push({type:"click",handler:this.showNav});
he.navcancel.push({type:"click",handler:this.handleNavCancel});
he.navconfirm.push({type:"click",handler:this.handleNavConfirm});
he.navpanel.push({type:"keypress",handler:this.handleNavKey});
H.attachEvent(this.getHtmlNode("nextmonth"),"click",this.nextMonth,this);
H.attachEvent(this.getHtmlNode("prevmonth"),"click",this.prevMonth,this);
he.nextmonth.push({type:"click",handler:this.nextMonth});
he.prevmonth.push({type:"click",handler:this.prevMonth});
var _7e6=this.getHtmlNode();
var shim=this.getHtmlNode("shim");
var Css=nitobi.html.Css;
if(shim){
var _7e9=Css.hasClass(_7e6,"nitobi-hide");
if(_7e9){
Css.removeClass(_7e6,"nitobi-hide");
_7e6.style.top="-1000px";
}
var _7ea=_7e6.offsetWidth;
var _7eb=_7e6.offsetHeight;
shim.style.height=_7eb+"px";
shim.style.width=_7ea-1+"px";
if(_7e9){
Css.addClass(_7e6,"nitobi-hide");
_7e6.style.top="";
}
}
this.onRenderComplete.notify(new nitobi.ui.ElementEventArgs(this,this.onRenderComplete));
};
nitobi.calendar.Calendar.prototype.detachEvents=function(){
var he=this.htmlEvents;
for(var name in he){
var _7ee=he[name];
var node=this.getHtmlNode(name);
nitobi.html.detachEvents(node,_7ee);
}
};
nitobi.calendar.Calendar.prototype.handleMouseDown=function(_7f0){
var _7f1=this.getParentObject();
var _7f2=this.findActiveDate(_7f0.srcElement);
if(_7f2&&nitobi.html.Css.hasClass(_7f2,"ntb-calendar-thismonth")){
_7f1.blurInput=false;
}else{
_7f1.blurInput=true;
}
};
nitobi.calendar.Calendar.prototype.handleBodyClick=function(_7f3){
var _7f4=this.findActiveDate(_7f3.srcElement);
if(!_7f4||nitobi.html.Css.hasClass(_7f4,"ntb-calendar-lastmonth")||nitobi.html.Css.hasClass(_7f4,"ntb-calendar-nextmonth")){
return;
}
var _7f5=this.getParentObject();
var day=_7f4.getAttribute("ebadate");
var _7f7=_7f4.getAttribute("ebamonth");
var year=_7f4.getAttribute("ebayear");
var date=new Date(year,_7f7,day);
var _7fa=_7f5.getEventsManager();
if(_7fa.isDisabled(date)){
return;
}
_7f5._setSelectedDate(date);
this.onDateClicked.notify(new nitobi.ui.ElementEventArgs(this,this.onDateClicked));
this.toggle();
};
nitobi.calendar.Calendar.prototype.handleNavKey=function(e){
var code=e.keyCode;
if(code==27){
this.handleNavCancel();
}
if(code==13){
this.handleNavConfirm();
}
};
nitobi.calendar.Calendar.prototype.handleToggleClick=function(e){
this.toggle();
};
nitobi.calendar.Calendar.prototype.clearHighlight=function(){
if(this.selectedDate){
var _7fe=this.findDateElement(this.selectedDate);
if(_7fe){
nitobi.html.Css.removeClass(_7fe,"ntb-calendar-currentday");
}
this.selectedDate=null;
}
};
nitobi.calendar.Calendar.prototype.highlight=function(date){
this.selectedDate=date;
var _800=this.findDateElement(date);
if(_800){
nitobi.html.Css.addClass(_800,"ntb-calendar-currentday");
}
};
nitobi.calendar.Calendar.prototype.findDateElement=function(date){
var _802=this.getHtmlNode(date.getMonth()+"."+date.getFullYear());
var dm=nitobi.base.DateMath;
if(_802){
var _804=dm.getMonthStart(dm.clone(date));
_804=dm.subtract(_804,"d",_804.getDay());
var days=dm.getNumberOfDays(_804,date)-1;
if(days>=0&&days<42){
var row=1+Math.floor(days/7);
var col=days%7;
var _808=nitobi.html.getFirstChild(_802.rows[row].cells[col]);
return _808;
}
}
return null;
};
nitobi.calendar.Calendar.prototype.showNav=function(){
var _809=this.getParentObject();
var _80a=_809.getStartDate();
var _80b=this.getHtmlNode("months");
_80b.selectedIndex=_80a.getMonth();
this.getHtmlNode("year").value=_80a.getFullYear();
this.getHtmlNode("warning").style.display="none";
var _80c=this.getHtmlNode("overlay");
var _80d=this.getHtmlNode("navpanel");
var _80e=new nitobi.effects.BlindDown(_80d,{duration:0.3});
var _80f=this.getHtmlNode("nav");
this.fitOverlay();
_80c.style.display="block";
var D=nitobi.drawing;
D.align(_80d,_80f,D.align.ALIGNMIDDLEHORIZ);
D.align(_80d,this.getHtmlNode("body"),D.align.ALIGNTOP);
D.align(_80c,this.getHtmlNode("body"),D.align.ALIGNTOP|D.align.ALIGNLEFT);
_80e.callback=function(){
};
_80e.start();
};
nitobi.calendar.Calendar.prototype.hideNav=function(_811){
var _812=this.getHtmlNode("navpanel");
var _813=new nitobi.effects.BlindUp(_812,{duration:0.2});
_813.callback=_811||nitobi.lang.noop();
_813.start();
};
nitobi.calendar.Calendar.prototype.hideOverlay=function(){
var _814=this.getHtmlNode("overlay");
_814.style.display="none";
};
nitobi.calendar.Calendar.prototype.fitOverlay=function(){
var _815=this.getHtmlNode("body");
var _816=this.getHtmlNode("overlay");
var _817=_815.offsetWidth;
var _818=_815.offsetHeight;
_816.style.height=_818+"px";
_816.style.width=_817+"px";
};
nitobi.calendar.Calendar.prototype.handleNavConfirm=function(_819){
var _81a=this.getParentObject();
var _81b=this.getHtmlNode("months");
var _81c=_81b.options[_81b.selectedIndex].value;
var year=this.getHtmlNode("year").value;
if(isNaN(year)){
var _81e=this.getHtmlNode("warning");
_81e.style.display="block";
_81e.innerHTML=_81a.getNavInvalidYearText();
return;
}
year=parseInt(year);
var _81f=new Date(year,_81c,1);
if(_81a.isOutOfRange(_81f)){
var _81e=this.getHtmlNode("warning");
_81e.style.display="block";
_81e.innerHTML=_81a.getNavOutOfRangeText();
return;
}
var _820=_81a.getStartDate();
var _821=false;
var _822=false;
if(year!=_820.getFullYear()){
_822=true;
}
if(parseInt(_81c)!=_820.getMonth()){
_821=true;
}
_81a.setStartDate(_81f);
var _823=nitobi.lang.close(this,this.render);
this.onRenderComplete.subscribeOnce(nitobi.lang.close(this,function(){
if(_821){
this.onMonthChanged.notify(new nitobi.ui.ElementEventArgs(this,this.onMonthChanged));
}
if(_822){
this.onYearChanged.notify(new nitobi.ui.ElementEventArgs(this,this.onYearChanged));
}
}));
this.hideNav(_823);
};
nitobi.calendar.Calendar.prototype.handleNavCancel=function(_824){
var _825=nitobi.lang.close(this,this.hideOverlay);
this.hideNav(_825);
};
nitobi.calendar.Calendar.prototype.findActiveDate=function(_826){
var _827=5;
for(var i=0;i<_827&&_826.getAttribute;i++){
var t=_826.getAttribute("ebatype");
if(t=="date"){
return _826;
}
_826=_826.parentNode;
}
return null;
};
nitobi.calendar.Calendar.prototype.getState=function(){
return this;
};
nitobi.calendar.Calendar.prototype.nextMonth=function(){
var _82a=this.getParentObject();
if(!_82a.disNext){
var _82b=this.getMonthColumns()*this.getMonthRows();
this.changeMonth(_82b);
}
};
nitobi.calendar.Calendar.prototype.prevMonth=function(){
if(!this.getParentObject().disPrev){
var _82c=this.getMonthColumns()*this.getMonthRows();
this.changeMonth(0-_82c);
}
};
nitobi.calendar.Calendar.prototype.changeMonth=function(unit){
var _82e=this.getParentObject();
var date=_82e.getStartDate();
var dm=nitobi.base.DateMath;
date=dm._add(dm.clone(date),"m",unit);
var _831=_82e.getStartDate();
var _832=false;
if(_831.getFullYear()!=date.getFullYear()){
_832=true;
}
_82e.setStartDate(date);
this.render();
this.onMonthChanged.notify(new nitobi.ui.ElementEventArgs(this,this.onMonthChanged));
if(_832){
this.onYearChanged.notify(new nitobi.ui.ElementEventArgs(this,this.onYearChanged));
}
};
nitobi.calendar.Calendar.prototype.toggle=function(_833){
var _834=this.getParentObject();
if(_834.getInput()){
this.setVisible(!this.isVisible(),(this.isVisible()?this.hideEffect:this.showEffect),_833,{duration:0.3});
}
};
nitobi.calendar.Calendar.prototype.show=function(_835){
var _836=this.getParentObject();
if(_836.getInput()){
this.setVisible(true,this.showEffect,_835,{duration:0.3});
}
};
nitobi.calendar.Calendar.prototype.hide=function(_837){
var _838=this.getParentObject();
if(_838.getInput()){
this.setVisible(false,this.hideEffect,_837,{duration:0.3});
}
};
nitobi.calendar.Calendar.prototype.handleToggle=function(){
if(this.isVisible()){
this.onShow.notify(new nitobi.ui.ElementEventArgs(this,this.onShow));
}else{
this.onHide.notify(new nitobi.ui.ElementEventArgs(this,this.onHide));
}
};
nitobi.calendar.Calendar.prototype.getMonthColumns=function(){
return this.getIntAttribute("monthcolumns",1);
};
nitobi.calendar.Calendar.prototype.setMonthColumns=function(_839){
this.setAttribute("monthcolumns",_839);
};
nitobi.calendar.Calendar.prototype.getMonthRows=function(){
return this.getIntAttribute("monthrows",1);
};
nitobi.calendar.Calendar.prototype.setMonthRows=function(rows){
this.setAttribute("monthrows",rows);
};
nitobi.calendar.Calendar.prototype.isEffectEnabled=function(){
return this.getBoolAttribute("effectenabled",true);
};
nitobi.calendar.Calendar.prototype.setEffectEnabled=function(_83b){
this.setAttribute("effectenabled",isEffectEnabled);
};
nitobi.lang.defineNs("nitobi.calendar");
if(false){
nitobi.calendar={};
}
nitobi.calendar.DatePicker=function(id){
nitobi.calendar.DatePicker.baseConstructor.call(this,id);
this.renderer.setTemplate(nitobi.calendar.datePickerTemplate);
this.blurInput=true;
this.onDateSelected=new nitobi.base.Event();
this.eventMap["dateselected"]=this.onDateSelected;
this.onSetInvalidDate=new nitobi.base.Event();
this.eventMap["setinvaliddate"]=this.onSetInvalidDate;
this.onSetDisabledDate=new nitobi.base.Event();
this.eventMap["setdisableddate"]=this.onSetDisabledDate;
this.onSetOutOfRangeDate=new nitobi.base.Event();
this.eventMap["setoutofrangedate"]=this.onSetOutOfRangeDate;
this.onEventDateSelected=new nitobi.base.Event();
this.eventMap["eventdateselected"]=this.onEventDateSelected;
this.eventsManager=new nitobi.calendar.EventsManager(this.getEventsUrl());
this.eventsManager.onDataReady.subscribe(this.renderChildren,this);
var _83d=this.getSelectedDate();
if(_83d&&!this.isOutOfRange(_83d)&&!nitobi.base.DateMath.invalid(_83d)){
this.setStartDate(nitobi.base.DateMath.getMonthStart(_83d));
}else{
this.setDateAttribute("selecteddate",null);
var _83e=this.getMinDate();
var _83f;
if(_83e){
_83f=_83e;
}else{
_83f=new Date();
}
this.setStartDate(nitobi.base.DateMath.getMonthStart(_83f));
}
this.subscribeDeclarationEvents();
};
nitobi.lang.extend(nitobi.calendar.DatePicker,nitobi.ui.Element);
nitobi.base.Registry.getInstance().register(new nitobi.base.Profile("nitobi.calendar.DatePicker",null,false,"ntb:datepicker"));
nitobi.calendar.DatePicker.prototype.render=function(){
var _840=this.getInput();
if(_840){
_840.detachEvents();
}
nitobi.calendar.DatePicker.base.render.call(this);
if(_840){
_840.attachEvents();
}
if(nitobi.browser.IE&&_840){
var _841=_840.getHtmlNode("input");
var _842=nitobi.html.Css.getStyle(_841,"height");
nitobi.html.Css.setStyle(_841,"height",parseInt(_842)-2+"px");
}
if(this.eventsManager){
this.eventsManager.getFromServer();
}else{
this.renderChildren();
}
};
nitobi.calendar.DatePicker.prototype.renderChildren=function(){
var cal=this.getCalendar();
var _844=this.getInput();
if(cal){
cal.render();
if(!_844){
var C=nitobi.html.Css;
var _846=cal.getHtmlNode();
var body=cal.getHtmlNode("body");
C.swapClass(_846,"nitobi-hide",NTB_CSS_SMALL);
cal.getHtmlNode().style.width=body.offsetWidth+"px";
C.removeClass(_846,NTB_CSS_SMALL);
}
}
if(this.getSelectedDate()&&_844){
_844.setValue(this.formatDate(this.getSelectedDate(),_844.getDisplayMask()));
}
if(this.getSelectedDate()){
var _848=this.getHtmlNode("value");
if(_848){
_848.value=this.formatDate(this.getSelectedDate(),this.getSubmitMask());
}
}
this.enableButton();
};
nitobi.calendar.DatePicker.prototype.getCalendar=function(){
return this.getObject(nitobi.calendar.Calendar.profile);
};
nitobi.calendar.DatePicker.prototype.getInput=function(){
return this.getObject(nitobi.calendar.DateInput.profile);
};
nitobi.calendar.DatePicker.prototype.getSelectedDate=function(){
return this.getDateAttr("selecteddate");
};
nitobi.calendar.DatePicker.prototype.getDateAttr=function(attr){
var _84a=this.getAttribute(attr,null);
if(_84a){
if(typeof (_84a)=="string"){
return this.parseLanguage(_84a);
}else{
return new Date(_84a);
}
}
return null;
};
nitobi.calendar.DatePicker.prototype.setSelectedDate=function(date){
if(typeof (date)!="object"){
date=new Date(date);
}
if(this.validate(date)){
this._setSelectedDate(date);
}
};
nitobi.calendar.DatePicker.prototype._setSelectedDate=function(date,_84d){
this.setDateAttribute("selecteddate",date);
var _84e=this.getHtmlNode("value");
if(_84e){
_84e.value=this.formatDate(date,this.getSubmitMask());
}
var _84f=this.getInput();
if(_84f){
var _850=_84f.getDisplayMask();
var _851=this.formatDate(date,_850);
_84f.setValue(_851);
_84f.setInvalidStyle(false);
}
var _852=this.getCalendar();
if(_852){
_852.clearHighlight(date);
var dm=nitobi.base.DateMath;
var _854=dm.getMonthStart(this.getStartDate());
var _855=_852.getMonthColumns()*_852.getMonthRows()-1;
var _856=dm.getMonthEnd(dm.add(dm.clone(_854),"m",_855));
if(dm.between(date,_854,_856)){
_852.highlight(date);
}
if(_84d){
this.setStartDate(dm.getMonthStart(dm.clone(date)));
_852.render();
}
}
var _857=this.getEventsManager();
if(_857.isEvent(date)){
var _854=_857.eventsCache[date.valueOf()];
var _858=this.eventsManager.getEventInfo(_854);
this.onEventDateSelected.notify({events:_858});
}
this.onDateSelected.notify(new nitobi.ui.ElementEventArgs(this,this.onDateSelected));
};
nitobi.calendar.DatePicker.prototype.validate=function(_859){
var E=nitobi.ui.ElementEventArgs;
if(nitobi.base.DateMath.invalid(_859)){
this.onSetInvalidDate.notify(new E(this,this.onSetInvalidDate));
return false;
}
if(this.isOutOfRange(_859)){
this.onSetOutOfRangeDate.notify(new E(this,this.onSetOutOfRangeDate));
return false;
}
if(this.isDisabled(_859)){
this.onSetDisabledDate.notify(new E(this,this.onSetDisabledDate));
return false;
}
return true;
};
nitobi.calendar.DatePicker.prototype.isDisabled=function(date){
return this.getEventsManager().isDisabled(date);
};
nitobi.calendar.DatePicker.prototype.disableButton=function(){
var _85c=this.getHtmlNode("button");
var cal=this.getCalendar();
if(_85c){
nitobi.html.Css.swapClass(_85c,"ntb-calendar-button","ntb-calendar-button-disabled");
nitobi.html.detachEvent(_85c,"click",cal.handleToggleClick,cal);
}
};
nitobi.calendar.DatePicker.prototype.enableButton=function(){
var _85e=this.getHtmlNode("button");
var cal=this.getCalendar();
if(_85e){
nitobi.html.Css.swapClass(_85e,"ntb-calendar-button-disabled","ntb-calendar-button");
nitobi.html.attachEvent(_85e,"click",cal.handleToggleClick,cal);
}
};
nitobi.calendar.DatePicker.prototype.isOutOfRange=function(date){
var dm=nitobi.base.DateMath;
var _862=this.getMinDate();
var _863=this.getMaxDate();
var _864=false;
if(_862&&_863){
_864=!dm.between(date,_862,_863);
}else{
if(_862&&_863==null){
_864=dm.before(date,_862);
}else{
if(_862==null&&_863){
_864=dm.after(date,_863);
}
}
}
return _864;
};
nitobi.calendar.DatePicker.prototype.clear=function(){
var _865=this.getHtmlNode("value");
if(_865){
_865.value="";
}
this.setDateAttribute("selecteddate",null);
};
nitobi.calendar.DatePicker.prototype.getTheme=function(){
return this.getAttribute("theme","");
};
nitobi.calendar.DatePicker.prototype.getSubmitMask=function(){
return this.getAttribute("submitmask","yyyy-MM-dd");
};
nitobi.calendar.DatePicker.prototype.setSubmitMask=function(mask){
this.setAttribute("submitmask",mask);
};
nitobi.calendar.DatePicker.prototype.getStartDate=function(){
return this.getDateAttribute("startdate");
};
nitobi.calendar.DatePicker.prototype.setStartDate=function(date){
this.setDateAttribute("startdate",date);
};
nitobi.calendar.DatePicker.prototype.getEventsUrl=function(){
return this.getAttribute("eventsurl","");
};
nitobi.calendar.DatePicker.prototype.setEventsUrl=function(url){
this.setAttribute("eventsurl",url);
};
nitobi.calendar.DatePicker.prototype.getEventsManager=function(){
return this.eventsManager;
};
nitobi.calendar.DatePicker.prototype.isShimEnabled=function(){
return this.getBoolAttribute("shimenabled",false);
};
nitobi.calendar.DatePicker.prototype.getMinDate=function(){
return this.getDateAttr("mindate");
};
nitobi.calendar.DatePicker.prototype.setMinDate=function(_869){
this.setAttribute("mindate",_869);
};
nitobi.calendar.DatePicker.prototype.getMaxDate=function(){
return this.getDateAttr("maxdate");
};
nitobi.calendar.DatePicker.prototype.setMaxDate=function(_86a){
this.setAttribute("maxdate",_86a);
};
nitobi.calendar.DatePicker.prototype.parseLanguage=function(date){
var dm=nitobi.base.DateMath;
var _86d=Date.parse(date);
if(_86d&&typeof (_86d)=="object"&&!isNaN(_86d)&&!dm.invalid(_86d)){
return _86d;
}
if(date==""||date==null){
return null;
}
date=date.toLowerCase();
var _86e=dm.resetTime(new Date());
switch(date){
case "today":
date=_86e;
break;
case "tomorrow":
date=dm.add(_86e,"d",1);
break;
case "yesterday":
date=dm.subtract(_86e,"d",1);
break;
case "last week":
date=dm.subtract(_86e,"d",7);
break;
case "next week":
date=dm.add(_86e,"d",7);
break;
case "last year":
date=dm.subtract(_86e,"y",1);
break;
case "last month":
date=dm.subtract(_86e,"m",1);
break;
case "next month":
date=dm.add(_86e,"m",1);
break;
case "next year":
date=dm.add(_86e,"y",1);
break;
default:
date=dm.resetTime(new Date(date));
break;
}
if(dm.invalid(date)){
return null;
}else{
return date;
}
};
nitobi.calendar.DatePicker.longDayNames=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
nitobi.calendar.DatePicker.shortDayNames=["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
nitobi.calendar.DatePicker.minDayNames=["S","M","T","W","T","F","S"];
nitobi.calendar.DatePicker.longMonthNames=["January","February","March","April","May","June","July","August","September","October","November","December"];
nitobi.calendar.DatePicker.shortMonthNames=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
nitobi.calendar.DatePicker.navConfirmText="OK";
nitobi.calendar.DatePicker.navCancelText="Cancel";
nitobi.calendar.DatePicker.navOutOfRangeText="That date is out of range.";
nitobi.calendar.DatePicker.navInvalidYearText="You must enter a valid year.";
nitobi.calendar.DatePicker.quickNavTooltip="Click to change month and/or year";
nitobi.calendar.DatePicker.navSelectMonthText="Choose Month";
nitobi.calendar.DatePicker.navSelectYearText="Enter Year";
nitobi.calendar.DatePicker.prototype.getQuickNavTooltip=function(){
return this.initLocaleAttr("quickNavTooltip");
};
nitobi.calendar.DatePicker.prototype.getMinDayNames=function(){
return this.initJsAttr("minDayNames");
};
nitobi.calendar.DatePicker.prototype.getLongDayNames=function(){
return this.initJsAttr("longDayNames");
};
nitobi.calendar.DatePicker.prototype.getShortDayNames=function(){
return this.initJsAttr("shortDayNames");
};
nitobi.calendar.DatePicker.prototype.getLongMonthNames=function(){
return this.initJsAttr("longMonthNames");
};
nitobi.calendar.DatePicker.prototype.getShortMonthNames=function(){
return this.initJsAttr("shortMonthNames");
};
nitobi.calendar.DatePicker.prototype.getNavConfirmText=function(){
return this.initLocaleAttr("navConfirmText");
};
nitobi.calendar.DatePicker.prototype.getNavCancelText=function(){
return this.initLocaleAttr("navCancelText");
};
nitobi.calendar.DatePicker.prototype.getNavOutOfRangeText=function(){
return this.initLocaleAttr("navOutOfRangeText");
};
nitobi.calendar.DatePicker.prototype.getNavInvalidYearText=function(){
return this.initLocaleAttr("navInvalidYearText");
};
nitobi.calendar.DatePicker.prototype.getNavSelectMonthText=function(){
return this.initLocaleAttr("navSelectMonthText");
};
nitobi.calendar.DatePicker.prototype.getNavSelectYearText=function(){
return this.initLocaleAttr("navSelectYearText");
};
nitobi.calendar.DatePicker.prototype.initJsAttr=function(_86f){
if(this[_86f]){
return this[_86f];
}
var attr=this.getAttribute(_86f.toLowerCase(),"");
if(attr!=""){
attr=eval("("+attr+")");
return this[_86f]=attr;
}
return this[_86f]=nitobi.calendar.DatePicker[_86f];
};
nitobi.calendar.DatePicker.prototype.initLocaleAttr=function(_871){
if(this[_871]){
return this[_871];
}
var text=this.getAttribute(_871.toLowerCase(),"");
if(text!=""){
return this[_871]=text;
}else{
return this[_871]=nitobi.calendar.DatePicker[_871];
}
};
nitobi.calendar.DatePicker.prototype.parseDate=function(date,mask){
var _875={};
while(mask.length>0){
var c=mask.charAt(0);
var _877=new RegExp(c+"+");
var _878=_877.exec(mask)[0];
if(c!="d"&&c!="y"&&c!="M"&&c!="N"&&c!="E"){
mask=mask.substring(_878.length);
date=date.substring(_878.length);
}else{
var _879=mask.charAt(_878.length);
var _87a=(_879==""?date:date.substring(0,date.indexOf(_879)));
var _87b=this.validateFormat(_87a,_878);
if(_87b.valid){
_875[_87b.unit]=_87b.value;
}else{
return null;
}
mask=mask.substring(_878.length);
date=date.substring(_87a.length);
}
}
var date=new Date(_875.y,_875.m,_875.d);
return date;
};
nitobi.calendar.DatePicker.prototype.validateFormat=function(_87c,_87d){
var _87e={valid:false,unit:"",value:""};
switch(_87d){
case "d":
case "dd":
var _87f=parseInt(_87c);
var _880;
if(_87d=="d"){
_880=!isNaN(_87c)&&_87c.charAt(0)!="0"&&_87c.length<=2;
}else{
_880=!isNaN(_87c)&&_87c.length==2;
}
if(_880){
_87e.valid=true;
_87e.unit="d";
_87e.value=_87c;
}else{
_87e.valid=false;
}
break;
case "y":
case "yyyy":
if(isNaN(_87c)){
_87e.valid=false;
}else{
_87e.valid=true;
_87e.unit="y";
_87e.value=_87c;
}
break;
case "M":
case "MM":
var _87f=parseInt(_87c,10);
var _880;
if(_87d=="M"){
_880=!isNaN(_87c)&&_87c.charAt(0)!="0"&&_87c.length<=2&&_87f>=1&&_87f<=12;
}else{
_880=!isNaN(_87c)&_87c.length==2&&_87f>=1&&_87f<=12;
}
if(_880){
_87e.valid=true;
_87e.unit="m";
_87e.value=_87f-1;
}else{
_87e.valid=false;
}
break;
case "MMM":
case "NNN":
case "E":
case "EE":
var _881;
if(_87d=="MMM"){
_881=this.getLongMonthNames();
}else{
if(_87d=="NNN"){
_881=this.getShortMonthNames();
}else{
if(_87d=="E"){
_881=this.getShortDayNames();
}else{
_881=this.getLongDayNames();
}
}
}
var i;
for(i=0;i<_881.length;i++){
var _883=_881[i];
if(_87c.toLowerCase()==_883.toLowerCase()){
break;
}
}
if(i<_881.length){
_87e.valid=true;
if(_87d=="MMM"||_87d=="NNN"){
_87e.unit="m";
}else{
_87e.unit="dl";
}
_87e.value=i;
}else{
_87e.valid=false;
}
break;
}
return _87e;
};
nitobi.calendar.DatePicker.prototype.formatDate=function(date,mask){
var _886={};
var year=date.getFullYear()+"";
var _888=date.getMonth()+1+"";
var _889=date.getDate()+"";
var day=date.getDay();
_886["y"]=_886["yyyy"]=year;
_886["yy"]=year.substring(2,4);
_886["M"]=_888+"";
_886["MM"]=nitobi.lang.padZeros(_888,2);
_886["MMM"]=this.getLongMonthNames()[_888-1];
_886["NNN"]=this.getShortMonthNames()[_888-1];
_886["d"]=_889;
_886["dd"]=nitobi.lang.padZeros(_889,2);
_886["EE"]=this.getLongDayNames()[day];
_886["E"]=this.getShortDayNames()[day];
var _88b="";
while(mask.length>0){
var c=mask.charAt(0);
var _88d=new RegExp(c+"+");
var _88e=_88d.exec(mask)[0];
_88b+=_886[_88e]||_88e;
mask=mask.substring(_88e.length);
}
return _88b;
};
nitobi.lang.defineNs("nitobi.calendar");
nitobi.calendar.DateInput=function(_88f){
nitobi.calendar.DateInput.baseConstructor.call(this,_88f);
this.onBlur=new nitobi.base.Event();
this.eventMap["blur"]=this.onBlur;
this.onFocus=new nitobi.base.Event();
this.eventMap["focus"]=this.onFocus;
this.htmlEvents=[];
this.subscribeDeclarationEvents();
};
nitobi.lang.extend(nitobi.calendar.DateInput,nitobi.ui.Element);
nitobi.calendar.DateInput.profile=new nitobi.base.Profile("nitobi.calendar.DateInput",null,false,"ntb:dateinput");
nitobi.base.Registry.getInstance().register(nitobi.calendar.DateInput.profile);
nitobi.calendar.DateInput.prototype.attachEvents=function(){
var he=this.htmlEvents;
he.push({type:"focus",handler:this.handleOnFocus});
he.push({type:"blur",handler:this.handleOnBlur});
he.push({type:"keydown",handler:this.handleOnKeyDown});
nitobi.html.attachEvents(this.getHtmlNode("input"),he,this);
};
nitobi.calendar.DateInput.prototype.detachEvents=function(){
nitobi.html.detachEvents(this.getHtmlNode("input"),this.htmlEvents);
};
nitobi.calendar.DateInput.prototype.setValue=function(_891){
var _892=this.getHtmlNode("input");
_892.value=_891;
};
nitobi.calendar.DateInput.prototype.getValue=function(){
var _893=this.getHtmlNode("input");
return _893.value;
};
nitobi.calendar.DateInput.prototype.handleOnFocus=function(){
var _894=this.getEditMask();
var _895=this.getParentObject();
var _896=_895.getSelectedDate();
if(_896){
var _897=_895.formatDate(_896,_894);
this.setValue(_897);
var _895=this.getParentObject();
_895.blurInput=true;
}
this.onFocus.notify(new nitobi.ui.ElementEventArgs(this,this.onFocus));
};
nitobi.calendar.DateInput.prototype.handleOnBlur=function(){
var _898=this.getParentObject();
var _899=_898.getCalendar();
if(_898.blurInput){
var _89a=this.getEditMask();
var _89b=this.getValue();
_89b=_898.parseDate(_89b,_89a);
if(_898.validate(_89b)){
_898._setSelectedDate(_89b,true);
if(_899){
_899.hide();
}
}else{
if(_899){
_899.clearHighlight();
}
_898.clear();
this.setInvalidStyle(true);
}
}
this.onBlur.notify(new nitobi.ui.ElementEventArgs(this,this.onBlur));
};
nitobi.calendar.DateInput.prototype.handleOnKeyDown=function(_89c){
var key=_89c.keyCode;
if(key==13){
this.getHtmlNode("input").blur();
}
};
nitobi.calendar.DateInput.prototype.setInvalidStyle=function(_89e){
var Css=nitobi.html.Css;
var _8a0=this.getHtmlNode("container");
if(_89e){
Css.swapClass(_8a0,"ntb-inputcontainer","ntb-invalid");
}else{
Css.swapClass(this.getHtmlNode("container"),"ntb-invalid","ntb-inputcontainer");
}
var _8a1=Css.getStyle(_8a0,"backgroundColor");
var _8a2=this.getHtmlNode("input");
Css.setStyle(_8a2,"backgroundColor",_8a1);
};
nitobi.calendar.DateInput.prototype.getEditMask=function(){
return this.getAttribute("editmask",this.getDisplayMask());
};
nitobi.calendar.DateInput.prototype.setEditMask=function(mask){
this.setAttribute("editmask",mask);
};
nitobi.calendar.DateInput.prototype.getDisplayMask=function(){
return this.getAttribute("displaymask","MMM dd yyyy");
};
nitobi.calendar.DateInput.prototype.setDisplayMask=function(mask){
this.setAttribute("displaymask",mask);
};
nitobi.calendar.DateInput.prototype.isEditable=function(){
this.getBoolAttribute("editable",true);
};
nitobi.calendar.DateInput.prototype.setEditable=function(dis){
this.setBoolAttribute("editable",dis);
this.getHtmlNode("input").disabled=dis;
};
nitobi.calendar.DateInput.prototype.getWidth=function(){
this.getIntAttribute("width");
};
nitobi.calendar.DateInput.prototype.setWidth=function(_8a6){
this.setAttribute("width",_8a6);
};
nitobi.lang.defineNs("nitobi.calendar");
nitobi.calendar.CalRenderer=function(){
nitobi.html.IRenderer.call(this);
};
nitobi.lang.implement(nitobi.calendar.CalRenderer,nitobi.html.IRenderer);
nitobi.calendar.CalRenderer.prototype.renderToString=function(_8a7){
var _8a8=_8a7.getParentObject();
var _8a9=_8a8.getEventsManager();
var dm=nitobi.base.DateMath;
var sb=new nitobi.lang.StringBuilder();
var id=_8a7.getId();
var _8ad=_8a7.getMonthColumns();
var _8ae=_8a7.getMonthRows();
var _8af=_8ad>1||_8ae>1;
var _8b0=dm.resetTime(dm.clone(_8a8.getStartDate()));
var _8b1=_8a8.getSelectedDate();
if(_8b1!=null){
_8b1=dm.resetTime(_8a8.getSelectedDate());
}
var _8b2=dm.resetTime(new Date());
var _8b3=_8a8.getMinDate();
var _8b4=_8a8.getMaxDate();
var _8b5=dm.subtract(dm.clone(_8b0),"d",1);
var _8b6=dm.add(dm.clone(_8b0),"m",_8ad*_8ae);
_8a8.disPrev=(_8b3&&dm.before(_8b5,_8b3)?true:false);
_8a8.disNext=(_8b4&&dm.after(_8b6,_8b4)?true:false);
var _8b7=_8a8.getLongMonthNames();
var _8b8=_8a8.getLongDayNames();
var _8b9=_8a8.getMinDayNames();
var _8ba=_8a8.getQuickNavTooltip();
var _8bb=(((nitobi.browser.MOZ&&!document.getElementsByClassName&&navigator.platform.indexOf("Mac")>=0)||nitobi.browser.IE6)&&_8a8.isShimEnabled())?true:false;
if(_8bb){
sb.append("<iframe id=\""+id+".shim\" style='position:absolute;top:0px;z-index:19999;'><!-- dummy --></iframe>");
}
sb.append("<div id=\""+id+".calendar\" style=\""+(_8bb?"position:relative;z-index:20000;":"")+"\">");
sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
if(_8af){
sb.append("<tr id=\""+id+".header\"><td>");
var _8bc=_8b7[_8b0.getMonth()];
var _8bd=_8b0.getFullYear();
var _8be=dm.add(dm.clone(_8b0),"m",(_8ad*_8ae)-1);
var _8bf=_8b7[_8be.getMonth()];
var _8c0=_8be.getFullYear();
sb.append("<div class=\"ntb-calendar-header\">");
sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"height:100%;width:100%;\"><tbody>");
sb.append("<tr><td><a id=\""+id+".prevmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-prev"+(_8a8.disPrev?" ntb-calendar-prevdis":"")+"\"></a</td>");
sb.append("<td style=\"width:70%;\"><span class=\"ntb-calendar-title\" title=\""+_8ba+"\" id=\""+id+".nav\">"+_8bc+" "+_8bd+" - "+_8bf+" "+_8c0+"</span></td>");
sb.append("<td><a id=\""+id+".nextmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-next"+(_8a8.disNext?" ntb-calendar-nextdis":"")+"\"></a></td></tr>");
sb.append("</tbody></table></div></td></tr>");
}
sb.append("<tr id=\""+id+".body\"><td>");
sb.append("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
for(var i=0;i<_8ae;i++){
sb.append("<tr>");
for(var j=0;j<_8ad;j++){
var _8c3=dm.subtract(dm.clone(_8b0),"d",_8b0.getDay());
var _8c4=_8b0.getMonth();
var _8c5=_8b0.getFullYear();
sb.append("<td>");
sb.append("<div class=\"ntb-calendar\">");
sb.append("<div><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:100%;\"><tbody>");
sb.append("<tr class=\"ntb-calendar-monthheader\">");
if(!_8af){
sb.append("<td><a id=\""+id+".prevmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-prev"+(_8a8.disPrev?" ntb-calendar-prevdis":"")+"\"></a></td>");
}
sb.append("<td style=\"width:70%;\"><span title=\""+_8ba+"\" "+(!_8af?"id=\""+id+".nav\"":"")+"><a onclick=\"return false;\" href=\"#\" style=\""+(_8af?"cursor:default;":"")+"\" class=\"ntb-calendar-month\">"+_8b7[_8c4]+"</a>");
sb.append("<a onclick=\"return false;\" href=\"#\" style=\""+(_8af?"cursor:default;":"")+"\" class=\"ntb-calendar-year\">"+" "+_8c5+"</a></span></td>");
if(!_8af){
sb.append("<td><a id=\""+id+".nextmonth\" onclick=\"return false;\" href=\"#\" class=\"ntb-calendar-next"+(_8a8.disNext?" ntb-calendar-nextdis":"")+"\"></a></td>");
}
sb.append("</tbody></table></div>");
sb.append("<div><table id=\""+id+"."+_8c4+"."+_8c5+"\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width: 100%;\"><tbody>");
sb.append("<tr>");
for(var k=0;k<7;k++){
sb.append("<th class=\"ntb-calendar-dayheader\">"+_8b9[k]+"</th>");
}
sb.append("</tr>");
for(var m=0;m<6;m++){
sb.append("<tr>");
for(var n=0;n<7;n++){
sb.append("<td>");
var _8c9=_8b8[_8c3.getDay()]+", "+_8b7[_8c3.getMonth()]+" "+_8c3.getDate()+", "+_8c3.getFullYear();
var _8ca=null;
var _8cb="";
if(_8a9&&_8c3.getMonth()==_8b0.getMonth()){
var _8ca=_8a9.dates.events[_8c3.valueOf()];
if(_8ca!=null){
var nt="";
for(var p=0;p<_8ca.length;p++){
if(_8ca[p].tooltip!=null){
nt+=_8ca[p].tooltip+"\n";
}else{
if(_8ca[p].location!=null){
nt+=_8ca[p].location+"\n";
if(_8ca[p].description!=null){
nt+=_8ca[p].description;
}
}
}
if(_8ca[p].cssStyle!=null){
_8cb+=_8ca[p].cssStyle;
}
}
if(nt.length!=0){
_8c9=nt;
}
}
}
sb.append("<a ebatype=\"date\" ebamonth=\""+_8c3.getMonth()+"\" ebadate=\""+_8c3.getDate()+"\" ebayear=\""+_8c3.getFullYear()+"\" title=\""+_8c9+"\" href=\"#\" onclick=\"return false;\" style=\"display:block;text-decoration:none;"+_8cb+"\" class=\"");
if(_8b1&&_8c3.valueOf()==_8b1.valueOf()&&_8c3.getMonth()==_8b0.getMonth()){
sb.append("ntb-calendar-currentday ");
}
if(_8c3.getMonth()<_8b0.getMonth()||(_8b3&&_8c3.valueOf()<_8b3.valueOf())){
sb.append("ntb-calendar-lastmonth ");
}else{
if(_8c3.getMonth()>_8b0.getMonth()||(_8b4&&_8c3.valueOf()>_8b4.valueOf())){
sb.append("ntb-calendar-nextmonth ");
}else{
if(_8c3.getMonth()==_8b0.getMonth()){
sb.append("ntb-calendar-thismonth ");
}
}
}
if(_8a9&&_8a9.isDisabled(_8c3)&&_8c3.getMonth()==_8b0.getMonth()){
sb.append("ntb-calendar-disabled ");
}else{
if(_8a9&&_8a9.isEvent(_8c3)&&_8c3.getMonth()==_8b0.getMonth()){
sb.append("ntb-calendar-event ");
}
}
if(_8b2.valueOf()==_8c3.valueOf()){
sb.append("ntb-calendar-today");
}
sb.append(" ntb-calendar-day");
if(_8ca!=null){
for(var p=0;p<_8ca.length;p++){
if(_8ca[p].cssClass!=null){
sb.append(" "+_8ca[p].cssClass+" ");
}
}
}
sb.append("\">"+_8c3.getDate()+"</a></td>");
_8c3=dm.add(_8c3,"d",1);
}
sb.append("</tr>");
}
sb.append("</tbody></table></div></div></td>");
_8b0=dm.resetTime(dm.add(_8b0,"m",1));
}
sb.append("</tr>");
}
sb.append("</tbody></table></td></tr></tbody></table></div></div>");
sb.append("</tbody><colgroup span=\"7\" style=\"width:17%\"></colgroup></table></div>");
sb.append("<div id=\""+id+".overlay\" class=\"ntb-calendar-overlay\" style=\""+(_8bb?"z-index:20001;":"")+"top:0px;left:0px;display:none;position:absolute;background-color:gray;filter:alpha(opacity=40);-moz-opacity:.50;opacity:.50;\"></div>");
sb.append(this.renderNavPanel(_8a7));
sb.append("</div></div>");
return sb.toString();
};
nitobi.calendar.CalRenderer.prototype.renderNavPanel=function(_8ce){
var sb=new nitobi.lang.StringBuilder();
var _8d0=_8ce.getParentObject();
var _8d1=_8d0.getLongMonthNames();
var id=_8ce.getId();
var _8d3=(nitobi.browser.MOZ&&!nitobi.browser.MOZ3)||(nitobi.browser.IE6&&!nitobi.browser.IE7)?true:false;
sb.append("<div id=\""+id+".navpanel\" style=\""+(_8d3?"z-index:20002;":"")+"position:absolute;top:0px;left:0px;overflow:hidden;\" class=\"ntb-calendar-navcontainer nitobi-hide\">");
sb.append("<div class=\"ntb-calendar-monthcontainer\">");
sb.append("<label style=\"display:block;\" for=\""+id+".months\">"+_8d0.getNavSelectMonthText()+"</label>");
sb.append("<select id=\""+id+".months\" class=\"ntb-calendar-navms\" style=\"\" tabindex=\"1\">");
for(var i=0;i<_8d1.length;i++){
sb.append("<option value=\""+i+"\">"+_8d1[i]+"</option>");
}
sb.append("</select>");
sb.append("</div>");
sb.append("<div class=\"ntb-calendar-yearcontainer\">");
sb.append("<label style=\"display:block;\" for=\""+id+".year\">"+_8d0.getNavSelectYearText()+"</label>");
sb.append("<input size=\"4\" maxlength=\"4\" id=\""+id+".year\" class=\"ntb-calendar-navinput\" style=\"-moz-user-select: normal;\" tabindex=\"2\"/>");
sb.append("</div>");
sb.append("<div class=\"ntb-calendar-controls\">");
sb.append("<button id=\""+id+".navconfirm\" type=\"button\">"+_8d0.getNavConfirmText()+"</button>");
sb.append("<button id=\""+id+".navcancel\" type=\"button\">"+_8d0.getNavCancelText()+"</button>");
sb.append("</div>");
sb.append("<div id=\""+id+".warning\" style=\"display:none;\" class=\"ntb-calendar-navwarning\">You must enter a valid year.</div>");
sb.append("</div>");
return sb.toString();
};
nitobi.lang.defineNs("nitobi.calendar");
nitobi.calendar.EventsManager=function(url){
this.connector=new nitobi.data.UrlConnector(url);
this.onDataReady=new nitobi.base.Event();
this.dates={events:{},disabled:{}};
this.eventsCache={};
this.disabledCache={};
};
nitobi.calendar.EventsManager.prototype.isEvent=function(date){
return (this.eventsCache[date.valueOf()]?true:false);
};
nitobi.calendar.EventsManager.prototype.isDisabled=function(date){
return (this.disabledCache[date.valueOf()]?true:false);
};
nitobi.calendar.EventsManager.prototype.getFromServer=function(){
if(this.connector.url!=null){
this.connector.get({},nitobi.lang.close(this,this.getComplete));
}else{
this.onDataReady.notify();
}
};
nitobi.calendar.EventsManager.prototype.getComplete=function(_8d8){
var data=_8d8.result;
var dm=nitobi.base.DateMath;
var root=data.documentElement;
var _8dc=nitobi.xml.getChildNodes(root);
for(var i=0;i<_8dc.length;i++){
var _8de=_8dc[i];
var type=_8de.getAttribute("e");
var _8e0={};
if(type=="event"){
var _8e1=_8de.getAttribute("a");
_8e1=dm.parseIso8601(_8e1);
_8e0.startDate=_8e1;
var _8e2=_8de.getAttribute("b");
if(_8e2){
_8e2=dm.parseIso8601(_8e2);
}else{
_8e2=null;
}
_8e0.endDate=_8e2;
_8e0.location=_8de.getAttribute("c");
_8e0.description=_8de.getAttribute("d");
_8e0.tooltip=_8de.getAttribute("f");
_8e0.cssClass=_8de.getAttribute("g");
_8e0.cssStyle=_8de.getAttribute("h");
var _8e3=this.dates.events[dm.resetTime(dm.clone(_8e1)).valueOf()];
if(_8e3){
_8e3.push(_8e0);
}else{
_8e3=[_8e0];
this.dates.events[dm.resetTime(dm.clone(_8e1)).valueOf()]=_8e3;
}
this.addEventDate(_8e1,_8e2);
}else{
var _8e1=dm.parseIso8601(_8de.getAttribute("a"));
_8e0.date=_8e1;
this.addDisabledDate(dm.clone(_8e1));
}
}
this.onDataReady.notify();
};
nitobi.calendar.EventsManager.prototype.addEventDate=function(_8e4,end){
var dm=nitobi.base.DateMath;
var _8e7=dm.clone(_8e4);
_8e7=dm.resetTime(_8e7);
if(!end){
return this.eventsCache[_8e7.valueOf()]=_8e4;
}
end=dm.clone(end);
end=dm.resetTime(end);
while(_8e7.valueOf()<=end.valueOf()){
this.eventsCache[_8e7.valueOf()]=_8e4;
_8e7=dm.add(_8e7,"d",1);
}
};
nitobi.calendar.EventsManager.prototype.addDisabledDate=function(date){
date=nitobi.base.DateMath.resetTime(date);
return this.disabledCache[date.valueOf()]=true;
};
nitobi.calendar.EventsManager.prototype.getEventInfo=function(date){
var dm=nitobi.base.DateMath;
var _8eb=this.dates.events;
date=dm.resetTime(date);
return _8eb[date.valueOf()];
};

var temp_ntb_modelDoc='<state	 xmlns:ntb="http://www.nitobi.com"	ID="mySheet"	Version="3.01" 	element="grid" 		uniqueID="_hkj342">    <nitobi.grid.Grid    	Theme="nitobi"    	CellBorder="0"		CellBorderHeight="1" 		Height="300"		Width="700"		skin="default"		RowHeight="23"					indicatorHeight="23"		HeaderHeight="23"		scrollbarWidth="26"		scrollbarHeight="26"		ToolbarHeight="25"				top="23"    left="100"    bottom="23"		minHeight="60"		minWidth="250"		PrimaryDatasourceSize="0" 		containerHeight=""		containerWidth=""		columnsdefined="0"		renderframe="0"		renderindicators="0"		renderheader="0"		renderfooter="0"		renderleft="0"		renderright="0"		rendercenter="0"		selected="1"		activeView=""		highlightCell=""		scrolling="0"		EditMode="0"		prevCell=""		prevText=""		prevData=""		FrozenLeftColumnCount="0"		DatasourceSizeEstimate="0"    	DatasourceId=""  		freezeright="0"		freezetop="0"		ToolbarEnabled="1"    	Expanding="0"			GridResizeEnabled="0"		RowHighlightEnabled="0"		RowSelectEnabled="0"		MultiRowSelectEnabled="0"		AutoKeyEnabled="0"			ToolbarContainerEmpty="false"			ToolTipsEnabled="1"		RowIndicatorsEnabled="0"		ColumnIndicatorsEnabled="1"		HScrollbarEnabled="1"		VScrollbarEnabled="1"		rowselect="0"		AutoSaveEnabled="0"		autoAdd="0"		remoteSort="0"		ForceValidate="1"		showErrors="0"		columnGraying="0"		keymode=""			keyboardPaging="0"		RowInsertEnabled="1"		RowDeleteEnabled="1"		allowEdit="1"		allowFormula="1"		PasteEnabled="1"		CopyEnabled="1"				expandRowsOnPaste="1"		expandColumnsOnPast="1"		datalog="myXMLLog"		xselect="//root"		xorder="@a"		asynchronous="1"		fieldMap=""    	GetHandler="" 		getHandler=""		SaveHandler=""		lastSaveHandlerResponse=""		sortColumn="0"		curSortColumn="0"		descending="0"		curSortColumnDesc="0"		RowCount="0"		ColumnCount="0"		nextXK="32"		CurrentPageIndex="0"		PagingMode="standard"		DataMode="caching"		RenderMode=""    	LiveScrollingMode="Leap"		RowsPerPage="20"		pageStart="0"		normalColor="#FFFFFF"		normalColor2="#FFFFFF"		activeColor="#FFFFFF"		selectionColor="#FFFFFF"		highlightColor="#FFFFFF"		columnGrayingColor="#FFFFFF"		SingleClickEditEnabled="0"		LastError=""		SortEnabled="1"    	SortMode="default"    	EnterTab="down"    	    	WidthFixed="0"     	HeightFixed="0"    	MinWidth="20"     	MinHeight="0"    	DragFillEnabled="1"		RightClickCopyEnabled="0"	>    </nitobi.grid.Grid>    <nitobi.grid.Columns>    </nitobi.grid.Columns>    <Defaults>    	<nitobi.grid.Grid></nitobi.grid.Grid>		<nitobi.grid.Column 			Width="100"			type="TEXT"			Visible="1"			SortEnabled="1"			/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." type="TEXT" editor="TEXT"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." type="NUMBER" editor="NUMBER"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." type="TEXTAREA" editor="TEXTAREA"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." ImageUrl="" type="IMAGE" editor="IMAGE"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." OpenWindow="1" type="LINK" editor="LINK"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" NegativeMask="" GroupingSeparator="," DecimalSeparator="." CalendarEnabled="1" type="DATE" editor="DATE"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." DatasourceId="" Datasource="" DisplayFields="" ValueField="" Delay="" Size="6" ForceValidOption="0" AutoComplete="1" AutoClear="0" GetOnEnter="0" ReferenceColumn="" type="LOOKUP" editor="LOOKUP"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." DatasourceId="" Datasource="" DisplayFields="" ValueField="" type="LISTBOX" editor="LISTBOX"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." type="PASSWORD" editor="PASSWORD"/>    	<nitobi.grid.Column Align="right" ClassName="" CssStyle="" ColumnName="" DataType="number" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="#,###.00" NegativeMask="" GroupingSeparator="," DecimalSeparator="." DatasourceId="" Datasource="" DisplayFields="" ValueField="" CheckedValue="" UnCheckedValue="" type="CHECKBOX" editor="CHECKBOX"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="TEXT" editor="TEXT"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="NUMBER" editor="NUMBER"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="TEXTAREA" editor="TEXTAREA"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" ImageUrl="" type="IMAGE" editor="IMAGE"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" OpenWindow="1" type="LINK" editor="LINK"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="DATE" editor="DATE"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" DatasourceId="" Datasource="" DisplayFields="" ValueField="" Delay="" Size="6" ForceValidOption="0" AutoComplete="1" AutoClear="0" GetOnEnter="0" ReferenceColumn="" type="LOOKUP" editor="LOOKUP"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" DatasourceId="" Datasource="" DisplayFields="" ValueField="" type="LISTBOX" editor="LISTBOX"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="PASSWORD" editor="PASSWORD"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="date" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" DatasourceId="" Datasource="" DisplayFields="" ValueField="" CheckedValue="" UnCheckedValue="" type="CHECKBOX" editor="CHECKBOX"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" type="TEXT" editor="TEXT"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" type="NUMBER" editor="NUMBER"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" type="TEXTAREA" editor="TEXTAREA"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" ImageUrl="" type="IMAGE" editor="IMAGE"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" OpenWindow="1" type="LINK" editor="LINK"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" Mask="M/d/yyyy" CalendarEnabled="1" type="DATE" editor="DATE"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" DatasourceId="" Datasource="" DisplayFields="" ValueField="" Delay="" Size="6" ForceValidOption="0" AutoComplete="1" AutoClear="0" GetOnEnter="0" ReferenceColumn="" type="LOOKUP" editor="LOOKUP"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" DatasourceId="" Datasource="" DisplayFields="" ValueField="" type="LISTBOX" editor="LISTBOX"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" type="PASSWORD" editor="PASSWORD"/>    	<nitobi.grid.Column Align="left" ClassName="" CssStyle="" ColumnName="" DataType="text" Editable="1" Initial="" Label="" GetHandler="" DataSource="" Template="" TemplateUrl="" MaxLength="255" SortDirection="Desc" SortEnabled="1" Width="100" Visible="1" xdatafld="" Value="" xi="100" DatasourceId="" Datasource="" DisplayFields="" ValueField="" CheckedValue="" UnCheckedValue="" type="CHECKBOX" editor="CHECKBOX"/>		<nitobi.grid.Row></nitobi.grid.Row>		<nitobi.grid.Cell></nitobi.grid.Cell>		<ntb:e />    </Defaults>    	<declaration>	</declaration>	<columnDefinitions>	</columnDefinitions></state>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.modelDoc = nitobi.xml.createXmlDoc(temp_ntb_modelDoc);
var temp_ntb_toolbarDoc='<?xml version="1.0" encoding="utf-8"?><toolbar id="toolbarthis.uid" title="Grid" height="25" width="110" image_directory="http://localhost/vss/EBALib/v13/Common/Toolbar/Styles/default">	<items>		<button id="save" onclick_event="this.onClick()" height="14" width="14" image="save.gif"			image_disabled="save_disabled.gif" tooltip_text="Save Changes" />		<!-- <button id="discardChanges" onclick_event="testclick(this);" height="17" width="16" top_offset="-2"			image="cancelsave.gif" image_disabled="cancelsave_disabled.gif" tooltip_text="Discard Changes" /> -->		<separator id="toolbar1_separator1" height="20" width="5" image="separator.jpg" />		<button id="newRecord" onclick_event="this.onClick()" height="11" width="14" image="newrecord.gif"			image_disabled="newrecord_disabled.gif" tooltip_text="New Record" />		<button id="deleteRecord" onclick_event="this.onClick()" height="11" width="14" image="deleterecord.gif"			image_disabled="deleterecord_disabled.gif" tooltip_text="Delete Record" />		<separator id="toolbar1_separator2" height="20" width="5" image="separator.jpg" />		<button id="refresh" onclick_event="this.onClick()" height="14" width="16" image="refresh.gif"			image_disabled="refresh_disabled.gif" tooltip_text="Refresh" />		<!--<separator id="toolbar1_separator3" height="20" width="5" image="separator.jpg" />		<button id="toolbar1_button4" onclick_event="testclick(this);" height="11" width="10" image="left.gif"			image_disabled="left_disabled.gif" tooltip_text="Previous Page" />		<button id="toolbar1_button5" onclick_event="testclick(this);" height="11" width="10" image="right.gif"			image_disabled="right_disabled.gif" tooltip_text="Next Page" />		-->	</items></toolbar>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.toolbarDoc = nitobi.xml.createXmlDoc(temp_ntb_toolbarDoc);
var temp_ntb_pagingToolbarDoc='<?xml version="1.0" encoding="utf-8"?><toolbar id="toolbarpagingthis.uid" title="Paging" height="25" width="60" image_directory="http://localhost/vss/EBALib/v13/Common/Toolbar/Styles/default">	<items>		<button id="previousPage" onclick_event="this.onClick()" height="14" width="14" image="left.gif"			image_disabled="left_disabled.gif" tooltip_text="Previous Page" />		<button id="nextPage" onclick_event="this.onClick()" height="14" width="16" image="right.gif"			image_disabled="right_disabled.gif" tooltip_text="Next Page" />	</items></toolbar>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.pagingToolbarDoc = nitobi.xml.createXmlDoc(temp_ntb_pagingToolbarDoc);
var temp_ntb_addXidXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <x:p-x:n-guid"x:s-0"/><x:t- match="/"> <x:at-/></x:t-><x:t- match="node()|@*"> <xsl:copy> <xsl:if test="not(@xid)"> <x:a-x:n-xid" ><x:v-x:s-generate-id(.)"/><x:v-x:s-position()"/><x:v-x:s-$guid"/></x:a-> </xsl:if> <x:at-x:s-./* | text() | @*"> </x:at-> </xsl:copy></x:t-> <x:t- match="text()"> <x:v-x:s-."/></x:t-></xsl:stylesheet> ';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.addXidXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_addXidXslProc));
var temp_ntb_adjustXiXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes" /> <x:p-x:n-startingIndex"x:s-5"></x:p-> <x:p-x:n-startingGroup"x:s-5"></x:p-> <x:p-x:n-adjustment"x:s--1"></x:p-> <x:t- match="*|@*"> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <!--[@id=\'_default\']--> <x:t- match="//ntb:data/ntb:e|@*"> <x:c-> <x:wh- test="number(@xi) &gt;= number($startingIndex)"> <xsl:copy> <x:at-x:s-@*|node()" /> <x:ct-x:n-increment-xi" /> </xsl:copy> </x:wh-> <x:o-> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:o-> </x:c-> </x:t-> <x:t-x:n-increment-xi"> <x:a-x:n-xi"> <x:v-x:s-number(@xi) + number($adjustment)" /> </x:a-> </x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.adjustXiXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_adjustXiXslProc));
var temp_ntb_dataTranslatorXslProc='<?xml version="1.0"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes" /> <x:p-x:n-start"x:s-0"></x:p-> <x:p-x:n-id"x:s-\'_default\'"></x:p-> <x:p-x:n-xkField"x:s-\'a\'"></x:p-> <x:p-x:n-totalRowCount"x:s-//root/@totalrowcount"/> <x:t- match="//root"> <ntb:grid xmlns:ntb="http://www.nitobi.com"> <ntb:datasources> <ntb:datasource id="{$id}" totalrowcount="{$totalRowCount}"> <xsl:if test="@error"> <x:a-x:n-error"><x:v-x:s-@error" /></x:a-> </xsl:if> <ntb:datasourcestructure id="{$id}"> <x:a-x:n-FieldNames"><x:v-x:s-@fields" />|_xk</x:a-> <x:a-x:n-Keys">_xk</x:a-> </ntb:datasourcestructure> <ntb:data id="{$id}"> <xsl:for-eachx:s-//e"> <x:at-x:s-."> <x:w-x:n-xi"x:s-position()-1"></x:w-> </x:at-> </xsl:for-each> </ntb:data> </ntb:datasource> </ntb:datasources> </ntb:grid> </x:t-> <x:t- match="e"> <x:p-x:n-xi"x:s-0"></x:p-> <ntb:e> <xsl:copy-ofx:s-@*[not(name() = \'xk\')]"></xsl:copy-of> <xsl:if test="not(@xi)"><x:a-x:n-xi"><x:v-x:s-$start + $xi" /></x:a-></xsl:if> <x:a-x:n-{$xkField}"><x:v-x:s-@xk" /></x:a-> </ntb:e> </x:t-> <x:t- match="lookups"></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.dataTranslatorXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_dataTranslatorXslProc));
var temp_ntb_dateFormatTemplatesXslProc='<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" xmlns:d="http://exslt.org/dates-and-times" xmlns:n="http://www.nitobi.com/exslt/numbers" extension-element-prefixes="d n"> <!-- http://java.sun.com/j2se/1.3/docs/api/java/text/SimpleDateFormat.html --><d:ms> <d:m i="1" l="31" a="Jan">January</d:m> <d:m i="2" l="28" a="Feb">February</d:m> <d:m i="3" l="31" a="Mar">March</d:m> <d:m i="4" l="30" a="Apr">April</d:m> <d:m i="5" l="31" a="May">May</d:m> <d:m i="6" l="30" a="Jun">June</d:m> <d:m i="7" l="31" a="Jul">July</d:m> <d:m i="8" l="31" a="Aug">August</d:m> <d:m i="9" l="30" a="Sep">September</d:m> <d:m i="10" l="31" a="Oct">October</d:m> <d:m i="11" l="30" a="Nov">November</d:m> <d:m i="12" l="31" a="Dec">December</d:m></d:ms><d:ds> <d:d a="Sun">Sunday</d:d> <d:d a="Mon">Monday</d:d> <d:d a="Tue">Tuesday</d:d> <d:d a="Wed">Wednesday</d:d> <d:d a="Thu">Thursday</d:d> <d:d a="Fri">Friday</d:d> <d:d a="Sat">Saturday</d:d></d:ds><x:t-x:n-d:format-date"> <x:p-x:n-date-time" /> <x:p-x:n-mask"x:s-\'MMM d, yy\'"/> <x:p-x:n-date-year" /> <x:va-x:n-formatted"> <x:va-x:n-date-time-length"x:s-string-length($date-time)" /> <x:va-x:n-timezone"x:s-\'\'" /> <x:va-x:n-dt"x:s-substring($date-time, 1, $date-time-length - string-length($timezone))" /> <x:va-x:n-dt-length"x:s-string-length($dt)" /> <x:c-> <x:wh- test="substring($dt, 3, 1) = \':\' and substring($dt, 6, 1) = \':\'"> <!--that means we just have a time--> <x:va-x:n-hour"x:s-substring($dt, 1, 2)" /> <x:va-x:n-min"x:s-substring($dt, 4, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 7)" /> <xsl:if test="$hour &lt;= 23 and $min &lt;= 59 and $sec &lt;= 60"> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-\'NaN\'" /> <x:w-x:n-month"x:s-\'NaN\'" /> <x:w-x:n-day"x:s-\'NaN\'" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </xsl:if> </x:wh-> <x:wh- test="substring($dt, 2, 1) = \'-\' or substring($dt, 3, 1) = \'-\'"> <x:c-> <x:wh- test="$dt-length = 5 or $dt-length = 6"> <!--D-MMM,DD-MMM--> <x:va-x:n-year"x:s-$date-year" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-after($dt,\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="$dt-length = 8 or $dt-length = 9"> <!--D-MMM-YY,DD-MMM-YY--> <x:va-x:n-year"x:s-concat(\'20\',substring-after(substring-after($dt,\'-\'),\'-\'))" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:o-> <!--D-MMM-YYYY,DD-MMM-YYYY--> <x:va-x:n-year"x:s-substring-after(substring-after($dt,\'-\'),\'-\')" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:o-> </x:c-> </x:wh-> <x:o-> <!--($neg * -2)--> <x:va-x:n-year"x:s-substring($dt, 1, 4) * (0 + 1)" /> <x:va-x:n-month"x:s-substring($dt, 6, 2)" /> <x:va-x:n-day"x:s-substring($dt, 9, 2)" /> <x:c-> <x:wh- test="$dt-length = 10"> <!--that means we just have a date--> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="substring($dt, 14, 1) = \':\' and substring($dt, 17, 1) = \':\'"> <!--that means we have a date + time--> <x:va-x:n-hour"x:s-substring($dt, 12, 2)" /> <x:va-x:n-min"x:s-substring($dt, 15, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 18)" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> </x:c-> </x:o-> </x:c-> </x:va-> <x:v-x:s-$formatted" /> </x:t-><x:t-x:n-d:_format-date"> <x:p-x:n-year" /> <x:p-x:n-month"x:s-1" /> <x:p-x:n-day"x:s-1" /> <x:p-x:n-hour"x:s-0" /> <x:p-x:n-minute"x:s-0" /> <x:p-x:n-second"x:s-0" /> <x:p-x:n-timezone"x:s-\'Z\'" /> <x:p-x:n-mask"x:s-\'\'" /> <x:va-x:n-char"x:s-substring($mask, 1, 1)" /> <x:c-> <x:wh- test="not($mask)" /> <!--replaced escaping with \' here/--> <x:wh- test="not(contains(\'GyMdhHmsSEDFwWakKz\', $char))"> <x:v-x:s-$char" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, 2)" /> </x:ct-> </x:wh-> <x:o-> <x:va-x:n-next-different-char"x:s-substring(translate($mask, $char, \'\'), 1, 1)" /> <x:va-x:n-mask-length"> <x:c-> <x:wh- test="$next-different-char"> <x:v-x:s-string-length(substring-before($mask, $next-different-char))" /> </x:wh-> <x:o-> <x:v-x:s-string-length($mask)" /> </x:o-> </x:c-> </x:va-> <x:c-> <!--took our the era designator--> <x:wh- test="$char = \'M\'"> <x:c-> <x:wh- test="$mask-length >= 3"> <x:va-x:n-month-node"x:s-document(\'\')/*/d:ms/d:m[number($month)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$month-node" /> </x:wh-> <x:o-> <x:v-x:s-$month-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$mask-length = 2"> <x:v-x:s-format-number($month, \'00\')" /> </x:wh-> <x:o-> <x:v-x:s-$month" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'E\'"> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:va-x:n-y-1"x:s-$year - 1" /> <x:va-x:n-dow"x:s-(($y-1 + floor($y-1 div 4) - floor($y-1 div 100) + floor($y-1 div 400) + $days) mod 7) + 1" /> <x:va-x:n-day-node"x:s-document(\'\')/*/d:ds/d:d[number($dow)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$day-node" /> </x:wh-> <x:o-> <x:v-x:s-$day-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'a\'"> <x:c-> <x:wh- test="$hour >= 12">PM</x:wh-> <x:o->AM</x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'z\'"> <x:c-> <x:wh- test="$timezone = \'Z\'">UTC</x:wh-> <x:o->UTC<x:v-x:s-$timezone" /></x:o-> </x:c-> </x:wh-> <x:o-> <x:va-x:n-padding"x:s-\'00\'" /> <!--removed padding--> <x:c-> <x:wh- test="$char = \'y\'"> <x:c-> <x:wh- test="$mask-length &gt; 2"><x:v-x:s-format-number($year, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(substring($year, string-length($year) - 1), $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'d\'"> <x:v-x:s-format-number($day, $padding)" /> </x:wh-> <x:wh- test="$char = \'h\'"> <x:va-x:n-h"x:s-$hour mod 12" /> <x:c-> <x:wh- test="$h"><x:v-x:s-format-number($h, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(12, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'H\'"> <x:v-x:s-format-number($hour, $padding)" /> </x:wh-> <x:wh- test="$char = \'k\'"> <x:c-> <x:wh- test="$hour"><x:v-x:s-format-number($hour, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(24, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'K\'"> <x:v-x:s-format-number($hour mod 12, $padding)" /> </x:wh-> <x:wh- test="$char = \'m\'"> <x:v-x:s-format-number($minute, $padding)" /> </x:wh-> <x:wh- test="$char = \'s\'"> <x:v-x:s-format-number($second, $padding)" /> </x:wh-> <x:wh- test="$char = \'S\'"> <x:v-x:s-format-number(substring-after($second, \'.\'), $padding)" /> </x:wh-> <x:wh- test="$char = \'F\'"> <x:v-x:s-floor($day div 7) + 1" /> </x:wh-> <x:o-> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:v-x:s-format-number($days, $padding)" /> <!--removed week in year--> <!--removed week in month--> </x:o-> </x:c-> </x:o-> </x:c-> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, $mask-length + 1)" /> </x:ct-> </x:o-> </x:c-></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.dateFormatTemplatesXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_dateFormatTemplatesXslProc));
var temp_ntb_dateXslProc='<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" xmlns:d="http://exslt.org/dates-and-times" extension-element-prefixes="d"> <xsl:output method="text" version="4.0" omit-xml-declaration="yes" /> <!-- http://java.sun.com/j2se/1.3/docs/api/java/text/SimpleDateFormat.html --><d:ms> <d:m i="1" l="31" a="Jan">January</d:m> <d:m i="2" l="28" a="Feb">February</d:m> <d:m i="3" l="31" a="Mar">March</d:m> <d:m i="4" l="30" a="Apr">April</d:m> <d:m i="5" l="31" a="May">May</d:m> <d:m i="6" l="30" a="Jun">June</d:m> <d:m i="7" l="31" a="Jul">July</d:m> <d:m i="8" l="31" a="Aug">August</d:m> <d:m i="9" l="30" a="Sep">September</d:m> <d:m i="10" l="31" a="Oct">October</d:m> <d:m i="11" l="30" a="Nov">November</d:m> <d:m i="12" l="31" a="Dec">December</d:m></d:ms><d:ds> <d:d a="Sun">Sunday</d:d> <d:d a="Mon">Monday</d:d> <d:d a="Tue">Tuesday</d:d> <d:d a="Wed">Wednesday</d:d> <d:d a="Thu">Thursday</d:d> <d:d a="Fri">Friday</d:d> <d:d a="Sat">Saturday</d:d></d:ds><x:t-x:n-d:format-date"> <x:p-x:n-date-time" /> <x:p-x:n-mask"x:s-\'MMM d, yy\'"/> <x:p-x:n-date-year" /> <x:va-x:n-formatted"> <x:va-x:n-date-time-length"x:s-string-length($date-time)" /> <x:va-x:n-timezone"x:s-\'\'" /> <x:va-x:n-dt"x:s-substring($date-time, 1, $date-time-length - string-length($timezone))" /> <x:va-x:n-dt-length"x:s-string-length($dt)" /> <x:c-> <x:wh- test="substring($dt, 3, 1) = \':\' and substring($dt, 6, 1) = \':\'"> <!--that means we just have a time--> <x:va-x:n-hour"x:s-substring($dt, 1, 2)" /> <x:va-x:n-min"x:s-substring($dt, 4, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 7)" /> <xsl:if test="$hour &lt;= 23 and $min &lt;= 59 and $sec &lt;= 60"> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-\'NaN\'" /> <x:w-x:n-month"x:s-\'NaN\'" /> <x:w-x:n-day"x:s-\'NaN\'" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </xsl:if> </x:wh-> <x:wh- test="substring($dt, 2, 1) = \'-\' or substring($dt, 3, 1) = \'-\'"> <x:c-> <x:wh- test="$dt-length = 5 or $dt-length = 6"> <!--D-MMM,DD-MMM--> <x:va-x:n-year"x:s-$date-year" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-after($dt,\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="$dt-length = 8 or $dt-length = 9"> <!--D-MMM-YY,DD-MMM-YY--> <x:va-x:n-year"x:s-concat(\'20\',substring-after(substring-after($dt,\'-\'),\'-\'))" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:o-> <!--D-MMM-YYYY,DD-MMM-YYYY--> <x:va-x:n-year"x:s-substring-after(substring-after($dt,\'-\'),\'-\')" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:o-> </x:c-> </x:wh-> <x:o-> <!--($neg * -2)--> <x:va-x:n-year"x:s-substring($dt, 1, 4) * (0 + 1)" /> <x:va-x:n-month"x:s-substring($dt, 6, 2)" /> <x:va-x:n-day"x:s-substring($dt, 9, 2)" /> <x:c-> <x:wh- test="$dt-length = 10"> <!--that means we just have a date--> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="substring($dt, 14, 1) = \':\' and substring($dt, 17, 1) = \':\'"> <!--that means we have a date + time--> <x:va-x:n-hour"x:s-substring($dt, 12, 2)" /> <x:va-x:n-min"x:s-substring($dt, 15, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 18)" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> </x:c-> </x:o-> </x:c-> </x:va-> <x:v-x:s-$formatted" /> </x:t-><x:t-x:n-d:_format-date"> <x:p-x:n-year" /> <x:p-x:n-month"x:s-1" /> <x:p-x:n-day"x:s-1" /> <x:p-x:n-hour"x:s-0" /> <x:p-x:n-minute"x:s-0" /> <x:p-x:n-second"x:s-0" /> <x:p-x:n-timezone"x:s-\'Z\'" /> <x:p-x:n-mask"x:s-\'\'" /> <x:va-x:n-char"x:s-substring($mask, 1, 1)" /> <x:c-> <x:wh- test="not($mask)" /> <!--replaced escaping with \' here/--> <x:wh- test="not(contains(\'GyMdhHmsSEDFwWakKz\', $char))"> <x:v-x:s-$char" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, 2)" /> </x:ct-> </x:wh-> <x:o-> <x:va-x:n-next-different-char"x:s-substring(translate($mask, $char, \'\'), 1, 1)" /> <x:va-x:n-mask-length"> <x:c-> <x:wh- test="$next-different-char"> <x:v-x:s-string-length(substring-before($mask, $next-different-char))" /> </x:wh-> <x:o-> <x:v-x:s-string-length($mask)" /> </x:o-> </x:c-> </x:va-> <x:c-> <!--took our the era designator--> <x:wh- test="$char = \'M\'"> <x:c-> <x:wh- test="$mask-length >= 3"> <x:va-x:n-month-node"x:s-document(\'\')/*/d:ms/d:m[number($month)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$month-node" /> </x:wh-> <x:o-> <x:v-x:s-$month-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$mask-length = 2"> <x:v-x:s-format-number($month, \'00\')" /> </x:wh-> <x:o-> <x:v-x:s-$month" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'E\'"> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:va-x:n-y-1"x:s-$year - 1" /> <x:va-x:n-dow"x:s-(($y-1 + floor($y-1 div 4) - floor($y-1 div 100) + floor($y-1 div 400) + $days) mod 7) + 1" /> <x:va-x:n-day-node"x:s-document(\'\')/*/d:ds/d:d[number($dow)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$day-node" /> </x:wh-> <x:o-> <x:v-x:s-$day-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'a\'"> <x:c-> <x:wh- test="$hour >= 12">PM</x:wh-> <x:o->AM</x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'z\'"> <x:c-> <x:wh- test="$timezone = \'Z\'">UTC</x:wh-> <x:o->UTC<x:v-x:s-$timezone" /></x:o-> </x:c-> </x:wh-> <x:o-> <x:va-x:n-padding"x:s-\'00\'" /> <!--removed padding--> <x:c-> <x:wh- test="$char = \'y\'"> <x:c-> <x:wh- test="$mask-length &gt; 2"><x:v-x:s-format-number($year, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(substring($year, string-length($year) - 1), $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'d\'"> <x:v-x:s-format-number($day, $padding)" /> </x:wh-> <x:wh- test="$char = \'h\'"> <x:va-x:n-h"x:s-$hour mod 12" /> <x:c-> <x:wh- test="$h"><x:v-x:s-format-number($h, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(12, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'H\'"> <x:v-x:s-format-number($hour, $padding)" /> </x:wh-> <x:wh- test="$char = \'k\'"> <x:c-> <x:wh- test="$hour"><x:v-x:s-format-number($hour, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(24, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'K\'"> <x:v-x:s-format-number($hour mod 12, $padding)" /> </x:wh-> <x:wh- test="$char = \'m\'"> <x:v-x:s-format-number($minute, $padding)" /> </x:wh-> <x:wh- test="$char = \'s\'"> <x:v-x:s-format-number($second, $padding)" /> </x:wh-> <x:wh- test="$char = \'S\'"> <x:v-x:s-format-number(substring-after($second, \'.\'), $padding)" /> </x:wh-> <x:wh- test="$char = \'F\'"> <x:v-x:s-floor($day div 7) + 1" /> </x:wh-> <x:o-> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:v-x:s-format-number($days, $padding)" /> <!--removed week in year--> <!--removed week in month--> </x:o-> </x:c-> </x:o-> </x:c-> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, $mask-length + 1)" /> </x:ct-> </x:o-> </x:c-></x:t-> <x:t- match="/"> <x:ct-x:n-d:format-date"> <x:w-x:n-date-time"x:s-//date" /> <x:w-x:n-date-year"x:s-//year" /> <x:w-x:n-mask"x:s-//mask" /> </x:ct-></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.form");
nitobi.form.dateXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_dateXslProc));
var temp_ntb_declarationConverterXslProc='<?xml version="1.0" encoding="utf-8" ?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes" /> <x:t- match="/"> <ntb:grid xmlns:ntb="http://www.nitobi.com"> <ntb:columns> <x:at-x:s-//ntb:columndefinition" mode="columndef" /> </ntb:columns> <ntb:datasources> <x:at-x:s-//ntb:columndefinition" mode="datasources" /> </ntb:datasources> </ntb:grid> </x:t-> <x:t- match="ntb:columndefinition" mode="columndef"> <x:c-> <x:wh- test="@type=\'TEXT\' or @type=\'TEXTAREA\' or @type=\'LISTBOX\' or @type=\'LOOKUP\' or @type=\'CHECKBOX\' or @type=\'LINK\' or @type=\'IMAGE\' or @type=\'\' or not(@type)"> <ntb:textcolumn> <xsl:copy-ofx:s-@*" /> <x:c-> <x:wh- test="@type=\'TEXT\'"> <ntb:texteditor><xsl:copy-ofx:s-@*" /></ntb:texteditor> </x:wh-> <x:wh- test="@type=\'TEXTAREA\'"> <ntb:textareaeditor><xsl:copy-ofx:s-@*" /></ntb:textareaeditor> </x:wh-> <x:wh- test="@type=\'LISTBOX\'"> <ntb:listboxeditor> <xsl:copy-ofx:s-@*" /> <x:a-x:n-DatasourceId">id_<x:v-x:s-position()"/></x:a-> <x:a-x:n-DisplayFields"> <x:c-> <x:wh- test="@show=\'value\'">b</x:wh-> <x:wh- test="@show=\'key\'">a</x:wh-> <x:o-></x:o-> </x:c-> </x:a-> <x:a-x:n-ValueField"> <x:c-> <x:wh- test="@show">a</x:wh-> <x:o-></x:o-> </x:c-> </x:a-> </ntb:listboxeditor> </x:wh-> <x:wh- test="@type=\'CHECKBOX\'"> <ntb:checkboxeditor> <xsl:copy-ofx:s-@*" /> <x:a-x:n-DatasourceId">id_<x:v-x:s-position()"/></x:a-> <x:a-x:n-DisplayFields"> <x:c-> <x:wh- test="@show=\'value\'">b</x:wh-> <x:wh- test="@show=\'key\'">a</x:wh-> <x:o-></x:o-> </x:c-></x:a-> <x:a-x:n-ValueField">a</x:a-> </ntb:checkboxeditor> </x:wh-> <x:wh- test="@type=\'LOOKUP\'"> <ntb:lookupeditor> <xsl:copy-ofx:s-@*" /> <x:a-x:n-DatasourceId">id_<x:v-x:s-position()"/></x:a-> <x:a-x:n-DisplayFields"> <x:c-> <x:wh- test="@show=\'key\'">a</x:wh-> <x:wh- test="@show=\'value\'">b</x:wh-> <x:o-></x:o-> </x:c-></x:a-> <x:a-x:n-ValueField"> <x:c-> <x:wh- test="@show">a</x:wh-> <x:o-></x:o-> </x:c-> </x:a-> </ntb:lookupeditor> </x:wh-> <x:wh- test="@type=\'LINK\'"> <ntb:linkeditor><xsl:copy-ofx:s-@*" /></ntb:linkeditor> </x:wh-> <x:wh- test="@type=\'IMAGE\'"> <ntb:imageeditor><xsl:copy-ofx:s-@*" /></ntb:imageeditor> </x:wh-> </x:c-> </ntb:textcolumn> </x:wh-> <x:wh- test="@type=\'NUMBER\'"> <ntb:numbercolumn><xsl:copy-ofx:s-@*" /></ntb:numbercolumn> </x:wh-> <x:wh- test="@type=\'DATE\' or @type=\'CALENDAR\'"> <ntb:datecolumn> <xsl:copy-ofx:s-@*" /> <x:c-> <x:wh- test="@type=\'DATE\'"> <ntb:dateeditor><xsl:copy-ofx:s-@*" /></ntb:dateeditor> </x:wh-> <x:wh- test="@type=\'CALENDAR\'"> <ntb:calendareditor><xsl:copy-ofx:s-@*" /></ntb:calendareditor> </x:wh-> </x:c-> </ntb:datecolumn> </x:wh-> </x:c-> </x:t-> <x:t- match="ntb:columndefinition" mode="datasources"> <xsl:if test="@values and @values!=\'\'"> <ntb:datasource> <x:a-x:n-id">id_<x:v-x:s-position()" /></x:a-> <ntb:datasourcestructure> <x:a-x:n-id">id_<x:v-x:s-position()" /></x:a-> <x:a-x:n-FieldNames">a|b</x:a-> <x:a-x:n-Keys">a</x:a-> </ntb:datasourcestructure> <ntb:data> <x:a-x:n-id">id_<x:v-x:s-position()" /></x:a-> <x:ct-x:n-values"> <x:w-x:n-valuestring"x:s-@values" /> </x:ct-> </ntb:data> </ntb:datasource> </xsl:if> </x:t-> <x:t-x:n-values"> <x:p-x:n-valuestring" /> <x:va-x:n-bstring"> <x:c-> <x:wh- test="contains($valuestring,\',\')"><x:v-x:s-substring-after(substring-before($valuestring,\',\'),\':\')" /></x:wh-> <x:o-><x:v-x:s-substring-after($valuestring,\':\')" /></x:o-> </x:c-> </x:va-> <ntb:e> <x:a-x:n-a"><x:v-x:s-substring-before($valuestring,\':\')" /></x:a-> <x:a-x:n-b"><x:v-x:s-$bstring" /></x:a-> </ntb:e> <xsl:if test="contains($valuestring,\',\')"> <x:ct-x:n-values"> <x:w-x:n-valuestring"x:s-substring-after($valuestring,\',\')" /> </x:ct-> </xsl:if> </x:t-> </xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.declarationConverterXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_declarationConverterXslProc));
var temp_ntb_frameCssXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:user="http://mycompany.com/mynamespace" xmlns:msxsl="urn:schemas-microsoft-com:xslt" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output method="text" omit-xml-declaration="yes"/><x:p-x:n-IE"x:s-\'false\'"/><x:va-x:n-g"x:s-//state/nitobi.grid.Grid"></x:va-><x:va-x:n-u"x:s-//state/@uniqueID"></x:va-><xsl:keyx:n-style" match="//s" use="@k" /><x:t- match = "/"> <x:va-x:n-t"x:s-$g/@Theme"></x:va-> <x:va-x:n-showvscroll"><x:c-><x:wh- test="($g/@VScrollbarEnabled=\'true\' or $g/@VScrollbarEnabled=1)">1</x:wh-><x:o->0</x:o-></x:c-></x:va-> <x:va-x:n-showhscroll"><x:c-><x:wh- test="($g/@HScrollbarEnabled=\'true\' or $g/@HScrollbarEnabled=1)">1</x:wh-><x:o->0</x:o-></x:c-></x:va-> <x:va-x:n-showtoolbar"><x:c-><x:wh- test="($g/@ToolbarEnabled=\'true\' or $g/@ToolbarEnabled=1)">1</x:wh-><x:o->0</x:o-></x:c-></x:va-> <x:va-x:n-frozen-columns-width"> <x:ct-x:n-get-pane-width"> <x:w-x:n-start-column"x:s-number(1)"/> <x:w-x:n-end-column"x:s-number($g/@FrozenLeftColumnCount)"/> <x:w-x:n-current-width"x:s-number(0)"/> </x:ct-> </x:va-> <x:va-x:n-unfrozen-columns-width"> <x:ct-x:n-get-pane-width"> <x:w-x:n-start-column"x:s-number($g/@FrozenLeftColumnCount)+1"/> <x:w-x:n-end-column"x:s-number($g/@ColumnCount)"/> <x:w-x:n-current-width"x:s-number(0)"/> </x:ct-> </x:va-> <x:va-x:n-total-columns-width"> <x:v-x:s-number($frozen-columns-width) + number($unfrozen-columns-width)"/> </x:va-> <x:va-x:n-scrollerHeight"x:s-number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)" /> <x:va-x:n-scrollerWidth"x:s-number($g/@Width)-(number($g/@scrollbarWidth)*number($g/@VScrollbarEnabled))" /> <x:va-x:n-midHeight"x:s-number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)-number($g/@top)"/> #grid<x:v-x:s-$u" /> { height:<x:v-x:s-$g/@Height" />px; width:<x:v-x:s-$g/@Width" />px; overflow:hidden;text-align:left; <xsl:if test="$IE=\'true\'"> position:relative; </xsl:if> } .hScrollbarRange<x:v-x:s-$u" /> { width:<x:v-x:s-$total-columns-width"/>px; } .vScrollbarRange<x:v-x:s-$u" /> {} .ntb-grid-datablock, .ntb-grid-headerblock { table-layout:fixed; <xsl:if test="$IE=\'true\'"> width:0px; </xsl:if> } .<x:v-x:s-$t"/> .ntb-cell {overflow:hidden;white-space:nowrap;} .<x:v-x:s-$t"/> .ntb-cell, x:-moz-any-link, x:default {display: -moz-box;} .<x:v-x:s-$t"/> .ntb-column-indicator, x:-moz-any-link, x:default {display: -moz-box;} .<x:v-x:s-$t"/> .ntb-cell-border {overflow:hidden;white-space:nowrap;<xsl:if test="$IE=\'true\'">height:auto;</xsl:if>} .ntb-grid-headershow<x:v-x:s-$u" /> {padding:0px;<xsl:if test="not($g/@ColumnIndicatorsEnabled=1)">display:none;</xsl:if>} .ntb-grid-vscrollshow<x:v-x:s-$u" /> {padding:0px;<xsl:if test="not($g/@VScrollbarEnabled=1)">display:none;</xsl:if>} #ntb-grid-hscrollshow<x:v-x:s-$u" /> {padding:0px;<xsl:if test="not($g/@HScrollbarEnabled=1)">display:none;</xsl:if>} .ntb-grid-toolbarshow<x:v-x:s-$u" /> {<xsl:if test="not($g/@ToolbarEnabled=1) and not($g/@ToolbarEnabled=\'true\')">display:none;</xsl:if>} .ntb-grid-height<x:v-x:s-$u" /> {height:<x:v-x:s-$g/@Height" />px;overflow:hidden;} .ntb-grid-width<x:v-x:s-$u" /> {width:<x:v-x:s-$g/@Width" />px;overflow:hidden;} .ntb-grid-overlay<x:v-x:s-$u" /> {position:relative;z-index:1000;top:0px;left:0px;} .ntb-grid-scroller<x:v-x:s-$u" /> { overflow:hidden; text-align:left; -moz-user-select: none; -webkit-user-select: none; -khtml-user-select: none; user-select: none; } .ntb-grid-scrollerheight<x:v-x:s-$u" /> {height: <x:c-><x:wh- test="($total-columns-width &gt; $g/@Width)"><x:v-x:s-$scrollerHeight"/></x:wh-><x:o-><x:v-x:s-number($scrollerHeight) + number($g/@scrollbarHeight)"/></x:o-></x:c->px;} .ntb-grid-scrollerwidth<x:v-x:s-$u" /> {width:<x:v-x:s-$scrollerWidth"/>px;} .ntb-grid-topheight<x:v-x:s-$u" /> {height:<x:v-x:s-$g/@top" />px;overflow:hidden;<xsl:if test="$g/@top=0">display:none;</xsl:if>} .ntb-grid-midheight<x:v-x:s-$u" /> {overflow:hidden;height:<x:c-><x:wh- test="($total-columns-width &gt; $g/@Width)"><x:v-x:s-$midHeight"/></x:wh-><x:o-><x:v-x:s-number($midHeight) + number($g/@scrollbarHeight)"/></x:o-></x:c->px;} .ntb-grid-leftwidth<x:v-x:s-$u" /> {width:<x:v-x:s-$g/@left" />px;overflow:hidden;text-align:left;} .ntb-grid-centerwidth<x:v-x:s-$u" /> {width:<x:v-x:s-number($g/@Width)-number($g/@left)-(number($g/@scrollbarWidth)*$showvscroll)" />px;} .ntb-grid-scrollbarheight<x:v-x:s-$u" /> {height:<x:v-x:s-$g/@scrollbarHeight" />px;} .ntb-grid-scrollbarwidth<x:v-x:s-$u" /> {width:<x:v-x:s-$g/@scrollbarWidth" />px;} .ntb-grid-toolbarheight<x:v-x:s-$u" /> {height:<x:v-x:s-$g/@ToolbarHeight" />px;} .ntb-grid-surfacewidth<x:v-x:s-$u" /> {width:<x:v-x:s-number($unfrozen-columns-width)"/>px;} .ntb-grid-surfaceheight<x:v-x:s-$u" /> {height:100px;} .ntb-grid {padding:0px;margin:0px;border:1px solid #cccccc} .ntb-scroller {padding:0px;} .ntb-scrollcorner {padding:0px;} .ntb-hscrollbar<x:v-x:s-$u" /> {<x:c-><x:wh- test="($total-columns-width &gt; $scrollerWidth)">display:block;</x:wh-><x:o->display:none;</x:o-></x:c->} .ntb-input-border { table-layout:fixed; overflow:hidden; position:absolute; z-index:2000; top:-2000px; left:-2000px; } .ntb-column-resize-surface { filter:alpha(opacity=1); background-color:white; position:absolute; display:none; top:-1000px; left:-5000px; width:100px; height:100px; z-index:800; } .<x:v-x:s-$t"/> .ntb-column-indicator { overflow:hidden; white-space: nowrap; } .ntb-row<x:v-x:s-$u" /> {height:<x:v-x:s-number($g/@RowHeight)-number($g/@CellBorderHeight)" />px;line-height:<x:v-x:s-number($g/@RowHeight)-number($g/@InnerCellBorder)" />px;margin:0px;} .ntb-header-row<x:v-x:s-$u" /> {height:<x:v-x:s-$g/@HeaderHeight" />px;} <x:at-x:s-state/nitobi.grid.Columns" /></x:t-><x:t-x:n-get-pane-width"> <x:p-x:n-start-column"/> <x:p-x:n-end-column"/> <x:p-x:n-current-width"/> <x:c-> <x:wh- test="$start-column &lt;= $end-column"> <x:ct-x:n-get-pane-width"> <x:w-x:n-start-column"x:s-$start-column+1"/> <x:w-x:n-end-column"x:s-$end-column"/> <x:w-x:n-current-width"x:s-number($current-width) + number(//state/nitobi.grid.Columns/nitobi.grid.Column[$start-column]/@Width)"/> </x:ct-> </x:wh-> <x:o-> <x:v-x:s-$current-width"/> </x:o-> </x:c-> </x:t-><x:t- match="nitobi.grid.Columns"> <xsl:for-eachx:s-*"> <x:va-x:n-p"><x:v-x:s-position()"/></x:va-> <x:va-x:n-w"><x:v-x:s-@Width"/></x:va-> <x:va-x:n-colw"><x:v-x:s-number($w)-number($g/@CellBorder)"/></x:va-> <x:va-x:n-coldataw"><x:v-x:s-number($w)-number($g/@InnerCellBorder)"/></x:va-> #grid<x:v-x:s-$u" /> .ntb-column<x:v-x:s-$u" />_<xsl:number value="$p" /> {width:<x:v-x:s-$colw" />px;} #grid<x:v-x:s-$u" /> .ntb-column-data<x:v-x:s-$u" />_<xsl:number value="$p" /> {width:<x:v-x:s-$coldataw" />px;text-align:<x:v-x:s-@Align"/>;} </xsl:for-each></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.frameCssXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_frameCssXslProc));
var temp_ntb_frameXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:ntb="http://www.nitobi.com" xmlns:msxsl="urn:schemas-microsoft-com:xslt" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"><xsl:output method="text" omit-xml-declaration="yes"/><x:p-x:n-browser"x:s-\'IE\'"/><x:p-x:n-scrollbarWidth"x:s-17" /><x:t- match = "/"><x:va-x:n-u"x:s-state/@uniqueID" /><x:va-x:n-Id"x:s-state/@ID" /><x:va-x:n-resizeEnabled"x:s-state/nitobi.grid.Grid/@GridResizeEnabled" /><x:va-x:n-frozenLeft"x:s-state/nitobi.grid.Grid/@FrozenLeftColumnCount" /><x:va-x:n-offset"> <x:c-> <x:wh- test="$browser=\'IE\'">1</x:wh-> <x:o->0</x:o-> </x:c-></x:va-> &lt;div id="grid<x:v-x:s-$u" />" class="ntb-grid ntb-grid-reset <x:v-x:s-state/nitobi.grid.Grid/@Theme" />" style="overflow:visible;"&gt; &lt;div style="height:0px;width:0px;position:relative;"&gt; &lt;div id="ntb-grid-overlay<x:v-x:s-$u" />" class="ntb-grid-overlay<x:v-x:s-$u" />"&gt;&lt;/div&gt; <!-- Firefox or IE just uses a hidden div for keynav since on Mac at least it doesn\'t capture the paste event on an input --> <xsl:if test="not($browser=\'SAFARI\')">&lt;div id="ntb-grid-keynav<x:v-x:s-$u" />" tabindex="1" style="position:absolute;left:-3000px;width:1px;height:1px;border:0px;background-color:transparent;"&gt;&lt;/div&gt;</xsl:if> <!-- Safari can\'t capture key events on divs so need to use an input --> <xsl:if test="$browser=\'SAFARI\'">&lt;input type="text" id="ntb-grid-keynav<x:v-x:s-$u" />" tabindex="1" style="position:absolute;left:-3000px;width:1px;height:1px;border:0px;background-color:transparent;"&gt;&lt;/input&gt;</xsl:if> &lt;/div&gt; &lt;table cellpadding="0" cellspacing="0" border="0"&gt; &lt;tr&gt; &lt;td id="ntb-grid-scroller<x:v-x:s-$u" />" class="ntb-grid-scrollerheight<x:v-x:s-$u" /> ntb-grid-scrollerwidth<x:v-x:s-$u" />" &gt; &lt;div id="ntb-grid-scrollerarea<x:v-x:s-$u" />" class="ntb-grid-scrollerheight<x:v-x:s-$u" />" style="overflow:hidden;" &gt; &lt;div tabindex="2" class="ntb-grid-scroller<x:v-x:s-$u" /> ntb-grid-scrollerheight<x:v-x:s-$u" />" &gt; &lt;table class="ntb-grid-scroller" cellpadding="0" cellspacing="0" border="0" &gt; &lt;tr id="ntb-grid-header<x:v-x:s-$u" />" class="ntb-grid-topheight<x:v-x:s-$u" /> " &gt; &lt;td class="ntb-scroller ntb-grid-topheight<x:v-x:s-$u" /> ntb-grid-leftwidth<x:v-x:s-$u" />" &gt; &lt;div id="gridvp_0_<x:v-x:s-$u" />" class="ntb-grid-topheight<x:v-x:s-$u" /> ntb-grid-leftwidth<x:v-x:s-$u" /> ntb-grid-header"&gt; &lt;div id="gridvpsurface_0_<x:v-x:s-$u" />" &gt; &lt;div id="gridvpcontainer_0_<x:v-x:s-$u" />" &gt;&lt;/div&gt; &lt;/div&gt; &lt;/div&gt; &lt;/td&gt; &lt;td class="ntb-scroller" &gt; &lt;div id="gridvp_1_<x:v-x:s-$u" />" class="ntb-grid-topheight<x:v-x:s-$u" /> ntb-grid-centerwidth<x:v-x:s-$u" /> ntb-grid-header"&gt; &lt;div id="gridvpsurface_1_<x:v-x:s-$u" />" class="ntb-grid-surfacewidth<x:v-x:s-$u" />" &gt; &lt;div id="gridvpcontainer_1_<x:v-x:s-$u" />" &gt;&lt;/div&gt; &lt;/div&gt; &lt;/div&gt; &lt;/td&gt; &lt;/tr&gt; &lt;tr id="ntb-grid-data<x:v-x:s-$u" />"class="ntb-grid-scroller" &gt; &lt;td class="ntb-scroller ntb-grid-leftwidth<x:v-x:s-$u" />" &gt; &lt;div style="position:relative;"&gt; <xsl:if test="not($browser=\'IE\') and not($frozenLeft=\'0\')"> &lt;div style="z-index:100;position:absolute;height:100%;top:0px;overflow:hidden;" id="ntb-frozenshadow<x:v-x:s-$u" />" class="ntb-frozenshadow"&gt;&lt;/div&gt; </xsl:if> &lt;div id="gridvp_2_<x:v-x:s-$u" />" class="ntb-grid-midheight<x:v-x:s-$u" /> ntb-grid-leftwidth<x:v-x:s-$u" />" style="position:relative;"&gt; &lt;div id="gridvpsurface_2_<x:v-x:s-$u" />" &gt; &lt;div id="gridvpcontainer_2_<x:v-x:s-$u" />" &gt;&lt;/div&gt; &lt;/div&gt; &lt;/div&gt; &lt;/div&gt; &lt;/td&gt; &lt;td class="ntb-scroller" &gt; &lt;div id="gridvp_3_<x:v-x:s-$u" />" class="ntb-grid-midheight<x:v-x:s-$u"/> ntb-grid-centerwidth<x:v-x:s-$u" />" style="position:relative;"&gt; &lt;div id="gridvpsurface_3_<x:v-x:s-$u" />" class="ntb-grid-surfacewidth<x:v-x:s-$u" />" &gt; &lt;div id="gridvpcontainer_3_<x:v-x:s-$u" />" &gt;&lt;/div&gt; &lt;/div&gt; &lt;/div&gt; &lt;/td&gt; &lt;/tr&gt; &lt;/table&gt; &lt;/div&gt; &lt;/div&gt; &lt;/td&gt; &lt;td id="ntb-grid-vscrollshow<x:v-x:s-$u" />" class="ntb-grid-scrollerheight<x:v-x:s-$u" />"&gt;&lt;div id="vscrollclip<x:v-x:s-$u" />" class="ntb-grid-scrollerheight<x:v-x:s-$u" /> ntb-grid-scrollbarwidth<x:v-x:s-$u"/> ntb-scrollbar" style="overflow:hidden;" &gt;&lt;div id="vscroll<x:v-x:s-$u" />" class="ntb-scrollbar" style="height:100%;width:<x:v-x:s-number($offset)+number(state/nitobi.grid.Grid/@scrollbarWidth)"/>px;position:relative;top:0px;left:-<x:v-x:s-$offset"/>px;overflow-x:hidden;overflow-y:scroll;" &gt;&lt;div class="vScrollbarRange<x:v-x:s-$u" />" style="WIDTH:1px;overflow:hidden;"&gt;&lt;/div&gt;&lt;/div&gt;&lt;/div&gt;&lt;/td&gt; &lt;/tr&gt; &lt;tr id="ntb-grid-hscrollshow<x:v-x:s-$u" />" &gt; &lt;td &gt;&lt;div id="hscrollclip<x:v-x:s-$u" />" class="ntb-grid-scrollbarheight<x:v-x:s-$u" /> ntb-grid-scrollerwidth<x:v-x:s-$u" /> ntb-hscrollbar<x:v-x:s-$u" />" style="overflow:hidden;" &gt; &lt;div id="hscroll<x:v-x:s-$u" />" class="ntb-grid-scrollbarheight<x:v-x:s-$u" /> ntb-grid-scrollerwidth<x:v-x:s-$u" /> ntb-scrollbar" style="overflow-x:scroll;overflow-y:hidden;height:<x:v-x:s-number($offset)+number(state/nitobi.grid.Grid/@scrollbarHeight)"/>px;position:relative;top:-<x:v-x:s-$offset"/>px;left:0px;" &gt; &lt;div class="hScrollbarRange<x:v-x:s-$u" />" style="HEIGHT:1px;overflow:hidden;"&gt; &lt;/div&gt; &lt;/td&gt; &lt;td class="ntb-grid-vscrollshow<x:v-x:s-$u" /> ntb-scrollcorner" &gt;&lt;/td&gt; &lt;/tr&gt; &lt;/table&gt; &lt;div id="toolbarContainer<x:v-x:s-$u" />" style="overflow:hidden;" class="ntb-grid-toolbarshow<x:v-x:s-$u" /> ntb-grid-toolbarheight<x:v-x:s-$u" /> ntb-grid-width<x:v-x:s-$u" /> ntb-toolbar<x:v-x:s-$u" /> ntb-toolbar"&gt;&lt;/div&gt; &lt;div id="ntb-grid-toolscontainer<x:v-x:s-$u"/>" style="height:0px;position:relative;"&gt; <!-- In IE quirks the textarea has a forced height so need it to have a relative positioned container --> &lt;div style="position:relative;overflow:hidden;height:0px;"&gt; &lt;textarea id="ntb-clipboard<x:v-x:s-$u"/>" class="ntb-clipboard" &gt;&lt;/textarea&gt; &lt;/div&gt; &lt;div style="position:relative;"&gt; &lt;div id="ntb-column-resizeline<x:v-x:s-$u" />" class="ntb-column-resizeline"&gt;&lt;/div&gt; &lt;div id="ntb-grid-resizebox<x:v-x:s-$u" />" class="ntb-grid-resizebox"&gt;&lt;/div&gt; &lt;/div&gt; &lt;/div&gt; <xsl:if test="$resizeEnabled = 1"> &lt;div id="ntb-grid-resizecontainer<x:v-x:s-$u"/>" style="height:0px;position:relative;"&gt; &lt;div id="ntb-grid-resizeright<x:v-x:s-$u" />" class="ntb-resize-indicator-right"&gt;&lt;/div&gt; &lt;div id="ntb-grid-resizebottom<x:v-x:s-$u" />" class="ntb-resize-indicator-bottom"&gt;&lt;/div&gt; &lt;/div&gt; </xsl:if> &lt;/div&gt;</x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.frameXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_frameXslProc));
var temp_ntb_listboxXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes"/> <x:p-x:n-size"></x:p-> <x:p-x:n-DisplayFields"x:s-\'\'"></x:p-> <x:p-x:n-ValueField"x:s-\'\'"></x:p-> <x:p-x:n-val"x:s-\'\'"></x:p-> <x:t- match="/"> <!--<x:va-x:n-cell"x:s-/root/metadata/r[@xi=$row]/*[@xi=$col]"></x:va->--> <select id="ntb-listbox" class="ntb-input ntb-lookup-options"> <xsl:if test="$size"> <x:a-x:n-size">6</x:a-> </xsl:if> <!--<x:c-> <x:wh- test="$DatasourceId">--> <xsl:for-eachx:s-/ntb:datasource/ntb:data/*"> <xsl:sortx:s-@*[name(.)=substring-before($DisplayFields,\'|\')]" data-type="text" order="ascending" /> <option> <x:a-x:n-value"> <x:v-x:s-@*[name(.)=$ValueField]"></x:v-> </x:a-> <x:a-x:n-rn"> <x:v-x:s-position()"></x:v-> </x:a-> <xsl:if test="@*[name(.)=$ValueField and .=$val]"> <x:a-x:n-selected">true</x:a-> </xsl:if> <x:ct-x:n-print-displayfields"> <x:w-x:n-field"x:s-$DisplayFields" /> </x:ct-> </option> </xsl:for-each> <!--</x:wh-> <x:o-> </x:o-> </x:c->--> </select> </x:t-> <x:t-x:n-print-displayfields"> <x:p-x:n-field" /> <x:c-> <x:wh- test="contains($field,\'|\')" > <!-- Here we hardcode a spacer \', \' - this should probably be moved elsewhere. --> <x:v-x:s-concat(@*[name(.)=substring-before($field,\'|\')],\', \')"></x:v-> <x:ct-x:n-print-displayfields"> <x:w-x:n-field"x:s-substring-after($field,\'|\')" /> </x:ct-> </x:wh-> <x:o-> <x:v-x:s-@*[name(.)=$field]"></x:v-> </x:o-> </x:c-> </x:t-> </xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.form");
nitobi.form.listboxXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_listboxXslProc));
var temp_ntb_mergeEbaXmlToLogXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes"/> <x:p-x:n-defaultAction"></x:p-> <x:p-x:n-startXid"x:s-100" ></x:p-> <xsl:keyx:n-newData" match="/ntb:grid/ntb:newdata/ntb:e" use="@xid" /> <xsl:keyx:n-oldData" match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data/ntb:e" use="@xid" /> <x:t- match="@* | node()" > <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <x:t- match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data/ntb:e"> <xsl:if test="not(key(\'newData\',@xid))"> <xsl:copy> <xsl:copy-ofx:s-@*" /> </xsl:copy> </xsl:if> </x:t-> <x:t- match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data"> <xsl:copy> <x:at-x:s-@*|node()" /> <xsl:for-eachx:s-/ntb:grid/ntb:newdata/ntb:e"> <xsl:copy> <xsl:copy-ofx:s-@*" /> <xsl:if test="$defaultAction"> <x:va-x:n-oldNode"x:s-key(\'oldData\',@xid)" /> <x:c-> <x:wh- test="$oldNode"> <x:va- name=\'xid\'x:s-@xid" /> <x:a-x:n-xac"><x:v-x:s-$oldNode/@xac" /></x:a-> </x:wh-> <x:o-> <x:a-x:n-xac"><x:v-x:s-$defaultAction" /></x:a-> </x:o-> </x:c-> </xsl:if> </xsl:copy> </xsl:for-each> </xsl:copy> </x:t-></xsl:stylesheet> ';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.mergeEbaXmlToLogXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_mergeEbaXmlToLogXslProc));
var temp_ntb_mergeEbaXmlXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="no" /> <x:p-x:n-startRowIndex"x:s-100" ></x:p-> <x:p-x:n-endRowIndex"x:s-200" ></x:p-> <x:p-x:n-guid"x:s-1"></x:p-> <xsl:keyx:n-newData" match="/ntb:grid/ntb:newdata/ntb:data/ntb:e" use="@xi" /> <xsl:keyx:n-oldData" match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data/ntb:e" use="@xi" /> <x:t- match="@* | node()" > <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <x:t- match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data/ntb:e"> <x:c-> <x:wh- test="(number(@xi) &gt;= $startRowIndex) and (number(@xi) &lt;= $endRowIndex)"> <xsl:copy> <xsl:copy-ofx:s-@*" /> <xsl:copy-ofx:s-key(\'newData\',@xi)/@*" /> </xsl:copy> </x:wh-> <x:o-> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:o-> </x:c-> </x:t-> <x:t- match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data"> <xsl:copy> <x:at-x:s-@*|node()" /> <xsl:for-eachx:s-/ntb:grid/ntb:newdata/ntb:data/ntb:e"> <xsl:if test="not(key(\'oldData\',@xi))"> <xsl:elementx:n-ntb:e" namespace="http://www.nitobi.com"> <xsl:copy-ofx:s-@*" /> <x:a-x:n-xid"><x:v-x:s-generate-id(.)"/><x:v-x:s-position()"/><x:v-x:s-$guid"/></x:a-> </xsl:element> </xsl:if> </xsl:for-each> </xsl:copy> </x:t-> <x:t- match="/ntb:grid/ntb:newdata/ntb:data/ntb:e"> <xsl:copy> <xsl:copy-ofx:s-@*" /> <x:va-x:n-oldData"x:s-key(\'oldData\',@xi)"/> <x:c-> <x:wh- test="$oldData"> <xsl:copy-ofx:s-$oldData/@*" /> <xsl:copy-ofx:s-@*" /> <x:a-x:n-xac">u</x:a-> <xsl:if test="$oldData/@xac=\'i\'"> <x:a-x:n-xac">i</x:a-> </xsl:if> </x:wh-> <x:o-> <x:a-x:n-xid"><x:v-x:s-generate-id(.)"/><x:v-x:s-position()"/><x:v-x:s-$guid"/></x:a-> <x:a-x:n-xac">i</x:a-> </x:o-> </x:c-> </xsl:copy> </x:t-> </xsl:stylesheet> ';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.mergeEbaXmlXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_mergeEbaXmlXslProc));
var temp_ntb_numberFormatTemplatesXslProc='<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" xmlns:d="http://exslt.org/dates-and-times" xmlns:n="http://www.nitobi.com/exslt/numbers" extension-element-prefixes="d n"> <!--http://www.w3schools.com/xsl/func_formatnumber.asp--><!-- <xsl:decimal-formatx:n-name" decimal-separator="char" grouping-separator="char" infinity="string" minus-sign="char" NaN="string" percent="char" per-mille="char" zero-digit="char" digit="char" pattern-separator="char"/> --><xsl:decimal-formatx:n-NA" decimal-separator="." grouping-separator="," /><xsl:decimal-formatx:n-EU" decimal-separator="," grouping-separator="." /><x:t-x:n-n:format"> <x:p-x:n-number"x:s-0" /> <x:p-x:n-mask"x:s-\'#.00\'" /> <x:p-x:n-group"x:s-\',\'" /> <x:p-x:n-decimal"x:s-\'.\'" /> <x:va-x:n-formattedNumber"> <x:c-> <x:wh- test="$group=\'.\' and $decimal=\',\'"> <x:v-x:s-format-number($number, $mask, \'EU\')" /> </x:wh-> <x:o-> <x:v-x:s-format-number($number, $mask, \'NA\')" /> </x:o-> </x:c-> </x:va-> <xsl:if test="not(string($formattedNumber) = \'NaN\')"> <x:v-x:s-$formattedNumber" /> </xsl:if></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.numberFormatTemplatesXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_numberFormatTemplatesXslProc));
var temp_ntb_numberXslProc='<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" xmlns:d="http://exslt.org/dates-and-times" xmlns:n="http://www.nitobi.com/exslt/numbers" extension-element-prefixes="d n"><xsl:output method="text" version="4.0" omit-xml-declaration="yes" /><x:p-x:n-number"x:s-0" /><x:p-x:n-mask"x:s-\'#.00\'" /><x:p-x:n-group"x:s-\',\'" /><x:p-x:n-decimal"x:s-\'.\'" /> <!--http://www.w3schools.com/xsl/func_formatnumber.asp--><!-- <xsl:decimal-formatx:n-name" decimal-separator="char" grouping-separator="char" infinity="string" minus-sign="char" NaN="string" percent="char" per-mille="char" zero-digit="char" digit="char" pattern-separator="char"/> --><xsl:decimal-formatx:n-NA" decimal-separator="." grouping-separator="," /><xsl:decimal-formatx:n-EU" decimal-separator="," grouping-separator="." /><x:t-x:n-n:format"> <x:p-x:n-number"x:s-0" /> <x:p-x:n-mask"x:s-\'#.00\'" /> <x:p-x:n-group"x:s-\',\'" /> <x:p-x:n-decimal"x:s-\'.\'" /> <x:va-x:n-formattedNumber"> <x:c-> <x:wh- test="$group=\'.\' and $decimal=\',\'"> <x:v-x:s-format-number($number, $mask, \'EU\')" /> </x:wh-> <x:o-> <x:v-x:s-format-number($number, $mask, \'NA\')" /> </x:o-> </x:c-> </x:va-> <xsl:if test="not(string($formattedNumber) = \'NaN\')"> <x:v-x:s-$formattedNumber" /> </xsl:if></x:t-><x:t- match="/"> <x:ct-x:n-n:format"> <x:w-x:n-number"x:s-$number" /> <x:w-x:n-mask"x:s-$mask" /> <x:w-x:n-group"x:s-$group" /> <x:w-x:n-decimal"x:s-$decimal" /> </x:ct-></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.form");
nitobi.form.numberXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_numberXslProc));
var temp_ntb_rowXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" xmlns:d="http://exslt.org/dates-and-times" xmlns:n="http://www.nitobi.com/exslt/numbers" extension-element-prefixes="d n"><xsl:output method="xml" omit-xml-declaration="yes"/> <x:p-x:n-showHeaders"x:s-\'0\'" /><x:p-x:n-firstColumn"x:s-\'0\'" /><x:p-x:n-lastColumn"x:s-\'0\'" /><x:p-x:n-uniqueId"x:s-\'0\'" /><x:p-x:n-rowHover"x:s-\'0\'" /><x:p-x:n-frozenColumnId"x:s-\'\'" /><x:p-x:n-start" /><x:p-x:n-end" /><x:p-x:n-activeColumn"x:s-\'0\'" /><x:p-x:n-activeRow"x:s-\'0\'" /><x:p-x:n-sortColumn"x:s-\'0\'" /><x:p-x:n-toolTipsEnabled"x:s-\'0\'" /><x:p-x:n-sortDirection"x:s-\'Asc\'" /><x:p-x:n-dataTableId"x:s-\'_default\'" /><x:p-x:n-columns"x:s-/ntb:root/ntb:columns/*/*" /><xsl:keyx:n-data-source" match="//ntb:datasources/ntb:datasource" use="@id" /><xsl:keyx:n-group" match="ntb:e" use="@a" /><!-- <xsl:for-eachx:s-ntb:e[count(. | key(\'group\', @a)[1]) = 1]"> <xsl:sortx:s-@a" /> <x:v-x:s-@a" />,<br /> <xsl:for-eachx:s-key(\'group\', @a)"> <xsl:sortx:s-@b" /> <x:v-x:s-@b" /> (<x:v-x:s-@c" />)<br /> </xsl:for-each> </xsl:for-each>--><!--This is an incude for the date fromatting XSLT that gets replaced at compile time--> <!-- http://java.sun.com/j2se/1.3/docs/api/java/text/SimpleDateFormat.html --><d:ms> <d:m i="1" l="31" a="Jan">January</d:m> <d:m i="2" l="28" a="Feb">February</d:m> <d:m i="3" l="31" a="Mar">March</d:m> <d:m i="4" l="30" a="Apr">April</d:m> <d:m i="5" l="31" a="May">May</d:m> <d:m i="6" l="30" a="Jun">June</d:m> <d:m i="7" l="31" a="Jul">July</d:m> <d:m i="8" l="31" a="Aug">August</d:m> <d:m i="9" l="30" a="Sep">September</d:m> <d:m i="10" l="31" a="Oct">October</d:m> <d:m i="11" l="30" a="Nov">November</d:m> <d:m i="12" l="31" a="Dec">December</d:m></d:ms><d:ds> <d:d a="Sun">Sunday</d:d> <d:d a="Mon">Monday</d:d> <d:d a="Tue">Tuesday</d:d> <d:d a="Wed">Wednesday</d:d> <d:d a="Thu">Thursday</d:d> <d:d a="Fri">Friday</d:d> <d:d a="Sat">Saturday</d:d></d:ds><x:t-x:n-d:format-date"> <x:p-x:n-date-time" /> <x:p-x:n-mask"x:s-\'MMM d, yy\'"/> <x:p-x:n-date-year" /> <x:va-x:n-formatted"> <x:va-x:n-date-time-length"x:s-string-length($date-time)" /> <x:va-x:n-timezone"x:s-\'\'" /> <x:va-x:n-dt"x:s-substring($date-time, 1, $date-time-length - string-length($timezone))" /> <x:va-x:n-dt-length"x:s-string-length($dt)" /> <x:c-> <x:wh- test="substring($dt, 3, 1) = \':\' and substring($dt, 6, 1) = \':\'"> <!--that means we just have a time--> <x:va-x:n-hour"x:s-substring($dt, 1, 2)" /> <x:va-x:n-min"x:s-substring($dt, 4, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 7)" /> <xsl:if test="$hour &lt;= 23 and $min &lt;= 59 and $sec &lt;= 60"> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-\'NaN\'" /> <x:w-x:n-month"x:s-\'NaN\'" /> <x:w-x:n-day"x:s-\'NaN\'" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </xsl:if> </x:wh-> <x:wh- test="substring($dt, 2, 1) = \'-\' or substring($dt, 3, 1) = \'-\'"> <x:c-> <x:wh- test="$dt-length = 5 or $dt-length = 6"> <!--D-MMM,DD-MMM--> <x:va-x:n-year"x:s-$date-year" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-after($dt,\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="$dt-length = 8 or $dt-length = 9"> <!--D-MMM-YY,DD-MMM-YY--> <x:va-x:n-year"x:s-concat(\'20\',substring-after(substring-after($dt,\'-\'),\'-\'))" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:o-> <!--D-MMM-YYYY,DD-MMM-YYYY--> <x:va-x:n-year"x:s-substring-after(substring-after($dt,\'-\'),\'-\')" /> <x:va-x:n-month"x:s-document(\'\')/*/d:ms/d:m[@a = substring-before(substring-after($dt,\'-\'),\'-\')]/@i" /> <x:va-x:n-day"x:s-substring-before($dt,\'-\')" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:o-> </x:c-> </x:wh-> <x:o-> <!--($neg * -2)--> <x:va-x:n-year"x:s-substring($dt, 1, 4) * (0 + 1)" /> <x:va-x:n-month"x:s-substring($dt, 6, 2)" /> <x:va-x:n-day"x:s-substring($dt, 9, 2)" /> <x:c-> <x:wh- test="$dt-length = 10"> <!--that means we just have a date--> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> <x:wh- test="substring($dt, 14, 1) = \':\' and substring($dt, 17, 1) = \':\'"> <!--that means we have a date + time--> <x:va-x:n-hour"x:s-substring($dt, 12, 2)" /> <x:va-x:n-min"x:s-substring($dt, 15, 2)" /> <x:va-x:n-sec"x:s-substring($dt, 18)" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$min" /> <x:w-x:n-second"x:s-$sec" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-$mask" /> </x:ct-> </x:wh-> </x:c-> </x:o-> </x:c-> </x:va-> <x:v-x:s-$formatted" /> </x:t-><x:t-x:n-d:_format-date"> <x:p-x:n-year" /> <x:p-x:n-month"x:s-1" /> <x:p-x:n-day"x:s-1" /> <x:p-x:n-hour"x:s-0" /> <x:p-x:n-minute"x:s-0" /> <x:p-x:n-second"x:s-0" /> <x:p-x:n-timezone"x:s-\'Z\'" /> <x:p-x:n-mask"x:s-\'\'" /> <x:va-x:n-char"x:s-substring($mask, 1, 1)" /> <x:c-> <x:wh- test="not($mask)" /> <!--replaced escaping with \' here/--> <x:wh- test="not(contains(\'GyMdhHmsSEDFwWakKz\', $char))"> <x:v-x:s-$char" /> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, 2)" /> </x:ct-> </x:wh-> <x:o-> <x:va-x:n-next-different-char"x:s-substring(translate($mask, $char, \'\'), 1, 1)" /> <x:va-x:n-mask-length"> <x:c-> <x:wh- test="$next-different-char"> <x:v-x:s-string-length(substring-before($mask, $next-different-char))" /> </x:wh-> <x:o-> <x:v-x:s-string-length($mask)" /> </x:o-> </x:c-> </x:va-> <x:c-> <!--took our the era designator--> <x:wh- test="$char = \'M\'"> <x:c-> <x:wh- test="$mask-length >= 3"> <x:va-x:n-month-node"x:s-document(\'\')/*/d:ms/d:m[number($month)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$month-node" /> </x:wh-> <x:o-> <x:v-x:s-$month-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$mask-length = 2"> <x:v-x:s-format-number($month, \'00\')" /> </x:wh-> <x:o-> <x:v-x:s-$month" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'E\'"> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:va-x:n-y-1"x:s-$year - 1" /> <x:va-x:n-dow"x:s-(($y-1 + floor($y-1 div 4) - floor($y-1 div 100) + floor($y-1 div 400) + $days) mod 7) + 1" /> <x:va-x:n-day-node"x:s-document(\'\')/*/d:ds/d:d[number($dow)]" /> <x:c-> <x:wh- test="$mask-length >= 4"> <x:v-x:s-$day-node" /> </x:wh-> <x:o-> <x:v-x:s-$day-node/@a" /> </x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'a\'"> <x:c-> <x:wh- test="$hour >= 12">PM</x:wh-> <x:o->AM</x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'z\'"> <x:c-> <x:wh- test="$timezone = \'Z\'">UTC</x:wh-> <x:o->UTC<x:v-x:s-$timezone" /></x:o-> </x:c-> </x:wh-> <x:o-> <x:va-x:n-padding"x:s-\'00\'" /> <!--removed padding--> <x:c-> <x:wh- test="$char = \'y\'"> <x:c-> <x:wh- test="$mask-length &gt; 2"><x:v-x:s-format-number($year, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(substring($year, string-length($year) - 1), $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'d\'"> <x:v-x:s-format-number($day, $padding)" /> </x:wh-> <x:wh- test="$char = \'h\'"> <x:va-x:n-h"x:s-$hour mod 12" /> <x:c-> <x:wh- test="$h"><x:v-x:s-format-number($h, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(12, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'H\'"> <x:v-x:s-format-number($hour, $padding)" /> </x:wh-> <x:wh- test="$char = \'k\'"> <x:c-> <x:wh- test="$hour"><x:v-x:s-format-number($hour, $padding)" /></x:wh-> <x:o-><x:v-x:s-format-number(24, $padding)" /></x:o-> </x:c-> </x:wh-> <x:wh- test="$char = \'K\'"> <x:v-x:s-format-number($hour mod 12, $padding)" /> </x:wh-> <x:wh- test="$char = \'m\'"> <x:v-x:s-format-number($minute, $padding)" /> </x:wh-> <x:wh- test="$char = \'s\'"> <x:v-x:s-format-number($second, $padding)" /> </x:wh-> <x:wh- test="$char = \'S\'"> <x:v-x:s-format-number(substring-after($second, \'.\'), $padding)" /> </x:wh-> <x:wh- test="$char = \'F\'"> <x:v-x:s-floor($day div 7) + 1" /> </x:wh-> <x:o-> <x:va-x:n-month-days"x:s-sum(document(\'\')/*/d:ms/d:m[position() &lt; $month]/@l)" /> <x:va-x:n-days"x:s-$month-days + $day + boolean(((not($year mod 4) and $year mod 100) or not($year mod 400)) and $month &gt; 2)" /> <x:v-x:s-format-number($days, $padding)" /> <!--removed week in year--> <!--removed week in month--> </x:o-> </x:c-> </x:o-> </x:c-> <x:ct-x:n-d:_format-date"> <x:w-x:n-year"x:s-$year" /> <x:w-x:n-month"x:s-$month" /> <x:w-x:n-day"x:s-$day" /> <x:w-x:n-hour"x:s-$hour" /> <x:w-x:n-minute"x:s-$minute" /> <x:w-x:n-second"x:s-$second" /> <x:w-x:n-timezone"x:s-$timezone" /> <x:w-x:n-mask"x:s-substring($mask, $mask-length + 1)" /> </x:ct-> </x:o-> </x:c-></x:t-><!--This is an incude for the number fromatting XSLT that gets replaced at compile time--> <!--http://www.w3schools.com/xsl/func_formatnumber.asp--><!-- <xsl:decimal-formatx:n-name" decimal-separator="char" grouping-separator="char" infinity="string" minus-sign="char" NaN="string" percent="char" per-mille="char" zero-digit="char" digit="char" pattern-separator="char"/> --><xsl:decimal-formatx:n-NA" decimal-separator="." grouping-separator="," /><xsl:decimal-formatx:n-EU" decimal-separator="," grouping-separator="." /><x:t-x:n-n:format"> <x:p-x:n-number"x:s-0" /> <x:p-x:n-mask"x:s-\'#.00\'" /> <x:p-x:n-group"x:s-\',\'" /> <x:p-x:n-decimal"x:s-\'.\'" /> <x:va-x:n-formattedNumber"> <x:c-> <x:wh- test="$group=\'.\' and $decimal=\',\'"> <x:v-x:s-format-number($number, $mask, \'EU\')" /> </x:wh-> <x:o-> <x:v-x:s-format-number($number, $mask, \'NA\')" /> </x:o-> </x:c-> </x:va-> <xsl:if test="not(string($formattedNumber) = \'NaN\')"> <x:v-x:s-$formattedNumber" /> </xsl:if></x:t-><x:t- match = "/"> <div> <xsl:if test="$showHeaders = 1"> <table cellpadding="0" cellspacing="0" border="0" class="ntb-grid-headerblock"> <tr> <x:a-x:n-class">ntb-header-row<x:v-x:s-$uniqueId" /></x:a-> <xsl:for-eachx:s-$columns"> <xsl:if test="@Visible = \'1\' and (position() &gt; $firstColumn and position() &lt;= $lastColumn)"> <td ebatype="columnheader" xi="{position()-1}" col="{position()-1}"> <x:a-x:n-id">columnheader_<x:v-x:s-position()-1"/>_<x:v-x:s-$uniqueId" /></x:a-> <x:a-x:n-onmouseover">$ntb(\'grid<x:v-x:s-$uniqueId" />\').jsObject.handleHeaderMouseOver(this);</x:a-> <x:a-x:n-onmouseout">$ntb(\'grid<x:v-x:s-$uniqueId" />\').jsObject.handleHeaderMouseOut(this);</x:a-> <!-- note that the ntb-columnUID_POSITION class is for a safari bug --> <x:a-x:n-class">ntb-column-indicator-border<x:c-><x:wh- test="$sortColumn=position()-1 and $sortDirection=\'Asc\'">ascending</x:wh-><x:wh- test="$sortColumn=position()-1 and $sortDirection=\'Desc\'">descending</x:wh-><x:o-></x:o-></x:c-><xsl:text> </xsl:text>ntb-column<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /></x:a-> <div class="ntb-column-indicator"> <x:c-> <x:wh- test="@Label and not(@Label = \'\') and not(@Label = \' \')"><x:v-x:s-@Label" /></x:wh-> <x:wh- test="ntb:label and not(ntb:label = \'\') and not(ntb:label = \' \')"><x:v-x:s-ntb:label" /></x:wh-> <x:o->ATOKENTOREPLACE</x:o-> </x:c-> </div> </td> </xsl:if> </xsl:for-each> </tr> <x:ct-x:n-colgroup" /> </table> </xsl:if> <table cellpadding="0" cellspacing="0" border="0" class="ntb-grid-datablock"> <x:at-x:s-key(\'data-source\', $dataTableId)/ntb:data/ntb:e[@xi &gt;= $start and @xi &lt; $end]" > <xsl:sortx:s-@xi" data-type="number" /> </x:at-> <x:ct-x:n-colgroup" /> </table> </div></x:t-><x:t-x:n-colgroup"> <colgroup> <xsl:for-eachx:s-$columns"> <xsl:if test="@Visible = \'1\' and (position() &gt; $firstColumn and position() &lt;= $lastColumn)"> <col> <x:a-x:n-class">ntb-column<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /><xsl:text> </xsl:text><xsl:if test="not(@Editable=\'1\')">ntb-column-readonly</xsl:if></x:a-> </col> </xsl:if> </xsl:for-each> </colgroup></x:t-><x:t- match="ntb:e"> <x:va-x:n-rowClass"> <xsl:if test="@xi mod 2 = 0">ntb-row-alternate</xsl:if> <!-- <xsl:if test="<x:v-x:s-@rowselectattr=1"/>">ebarowselected</xsl:if> --> </x:va-> <x:va-x:n-xi"x:s-@xi" /> <x:va-x:n-row"x:s-." /> <tr class="ntb-row {$rowClass} ntb-row{$uniqueId}" xi="{$xi}"> <x:a-x:n-id">row_<x:v-x:s-$xi" /><x:v-x:s-$frozenColumnId"/>_<x:v-x:s-$uniqueId" /></x:a-> <xsl:for-eachx:s-$columns"> <xsl:if test="@Visible = \'1\' and (position() &gt; $firstColumn and position() &lt;= $lastColumn)"> <x:ct-x:n-render-cell"> <x:w-x:n-row"x:s-$row"/> <x:w-x:n-xi"x:s-$xi"/> </x:ct-> </xsl:if> </xsl:for-each> </tr></x:t-> <x:t-x:n-render-cell"> <x:p-x:n-row" /> <x:p-x:n-xi" /> <x:va-x:n-xdatafld"x:s-substring-after(@xdatafld,\'@\')"/> <x:va-x:n-pos"x:s-position()-1"/> <x:va-x:n-value"><x:c-><x:wh- test="not(@xdatafld = \'\')"><x:v-x:s-$row/@*[name()=$xdatafld]" /></x:wh-><!-- @Value will actuall have some escaped XSLT in it like any other bound property --><x:o-><x:v-x:s-@Value" /></x:o-></x:c-></x:va-> <td ebatype="cell" style="vertical-align:middle;" id="cell_{$xi}_{$pos}_{$uniqueId}" xi="{$xi}" col="{$pos}"> <x:a-x:n-style"><x:ct-x:n-CssStyle"><x:w-x:n-row"x:s-$row"/></x:ct-></x:a-> <!-- note the use of the ntb-column<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /> class ... that is for a safari bug --> <x:a-x:n-class">ntb-cell-border<xsl:text> </xsl:text>ntb-column-data<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /><xsl:text> </xsl:text>ntb-column-<x:c-><x:wh- test="$sortColumn=$pos and $sortDirection=\'Asc\'">ascending</x:wh-><x:wh- test="$sortColumn=$pos and $sortDirection=\'Desc\'">descending</x:wh-><x:o-></x:o-></x:c-><xsl:text> </xsl:text>ntb-column-<x:v-x:s-@DataType"/><xsl:text> </xsl:text><x:ct-x:n-ClassName"><x:w-x:n-row"x:s-$row"/></x:ct-><xsl:text> </xsl:text><xsl:if test="@type = \'NUMBER\' and $value &lt; 0">ntb-cell-negativenumber</xsl:if><xsl:text> </xsl:text>ntb-column<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /></x:a-> <div style="overflow:hidden;white-space:nowrap;"> <x:a-x:n-class">ntb-row<x:v-x:s-$uniqueId"/><xsl:text> </xsl:text>ntb-column-data<x:v-x:s-$uniqueId"/>_<x:v-x:s-position()" /><xsl:text> </xsl:text>ntb-cell</x:a-> <xsl:if test="$toolTipsEnabled=\'1\'"> <x:a-x:n-title"> <x:v-x:s-$value" /> </x:a-> </xsl:if> <x:at-x:s-."> <x:w-x:n-value"x:s-$value"/> </x:at-> </div> </td> </x:t-> <x:t- match="*[@type=\'TEXT\' or @type=\'\']"> <x:p-x:n-value" /> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </x:t-> <x:t- match="*[@type=\'NUMBER\']"> <x:p-x:n-value" /> <x:va-x:n-number-mask"> <x:c-> <x:wh- test="@Mask"><x:v-x:s-@Mask" /></x:wh-> <x:o->#,###.00</x:o-> </x:c-> </x:va-> <x:va-x:n-negative-number-mask"> <x:c-> <x:wh- test="@NegativeMask and not(@NegativeMask=\'\')"><x:v-x:s-@NegativeMask" /></x:wh-> <x:o-><x:v-x:s-@NegativeMask" /></x:o-> </x:c-> </x:va-> <x:va-x:n-number"> <x:c-> <x:wh- test="$value &lt; 0"> <x:ct-x:n-n:format"> <x:w-x:n-number"x:s-translate($value,\'-\',\'\')" /> <x:w-x:n-mask"x:s-$negative-number-mask" /> <x:w-x:n-group"x:s-@GroupingSeparator" /> <x:w-x:n-decimal"x:s-@DecimalSeparator" /> </x:ct-> </x:wh-> <x:o-> <x:ct-x:n-n:format"> <x:w-x:n-number"x:s-$value" /> <x:w-x:n-mask"x:s-$number-mask" /> <x:w-x:n-group"x:s-@GroupingSeparator" /> <x:w-x:n-decimal"x:s-@DecimalSeparator" /> </x:ct-> </x:o-> </x:c-> </x:va-> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$number" /> </x:ct-> </x:t-> <x:t- match="*[@type=\'LOOKUP\']"> <x:p-x:n-value" /> <x:va-x:n-valueField"x:s-@ValueField" /> <x:va-x:n-displayFields"x:s-@DisplayFields" /> <x:c-> <x:wh- test="$valueField = $displayFields"> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </x:wh-> <x:o-> <x:ct-x:n-replaceblank"> <x:w-x:n-value"> <x:c-> <x:wh- test="@DatasourceId"> <x:va-x:n-preset-value" > <xsl:for-eachx:s-key(\'data-source\',@DatasourceId)//*"> <xsl:if test="@*[name(.)=$valueField and .=$value]"> <x:ct-x:n-print-displayfields"> <x:w-x:n-field"x:s-$displayFields" /> </x:ct-> </xsl:if> </xsl:for-each> </x:va-> <x:c-> <x:wh- test="$preset-value=\'\'"> <x:v-x:s-$value"/> </x:wh-> <x:o-> <x:v-x:s-$preset-value"/> </x:o-> </x:c-> </x:wh-> <x:o-> <x:v-x:s-$value"/> </x:o-> </x:c-> </x:w-> </x:ct-> </x:o-> </x:c-> </x:t-> <x:t- match="*[@type=\'LISTBOX\']"> <x:p-x:n-value" /> <x:va-x:n-valueField"x:s-@ValueField" /> <x:va-x:n-displayFields"x:s-@DisplayFields" /> <x:c-> <x:wh- test="@DatasourceId"> <x:va-x:n-temp-value"> <xsl:for-eachx:s-key(\'data-source\',@DatasourceId)//*"> <xsl:if test="@*[name(.)=$valueField and .=$value]"> <x:ct-x:n-replaceblank"> <x:w-x:n-value"> <x:ct-x:n-print-displayfields"> <x:w-x:n-field"x:s-$displayFields" /> </x:ct-> </x:w-> </x:ct-> </xsl:if> </xsl:for-each> </x:va-> <x:c-> <x:wh- test="not($temp-value = \'\')"> <x:v-x:s-$temp-value"/> </x:wh-> <x:o-> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </x:o-> </x:c-> </x:wh-> <x:o-> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </x:o-> </x:c-> </x:t-> <x:t- match="*[@type=\'CHECKBOX\']"> <x:p-x:n-value" /> <x:va-x:n-valueField"x:s-@ValueField" /> <x:va-x:n-displayFields"x:s-@DisplayFields" /> <x:va-x:n-checkedValue"x:s-@CheckedValue" /> <xsl:for-eachx:s-key(\'data-source\',@DatasourceId)//*"> <xsl:if test="@*[name(.)=$valueField and .=$value]"> <x:va-x:n-checkString"> <x:c-> <x:wh- test="$value=$checkedValue">checked</x:wh-> <x:o->unchecked</x:o-> </x:c-> </x:va-> <div style="overflow:hidden;"> <div class="ntb-checkbox ntb-checkbox-{$checkString}" checked="{$value}" width="10" >ATOKENTOREPLACE</div> <div class="ntb-checkbox-text"><x:v-x:s-@*[name(.)=$displayFields]" /></div> </div> </xsl:if> </xsl:for-each> </x:t-> <x:t- match="*[@type=\'IMAGE\']"> <x:p-x:n-value" /> <x:va-x:n-url"> <x:c-> <x:wh- test="@ImageUrl and not(@ImageUrl=\'\')"><x:v-x:s-@ImageUrl" /></x:wh-> <x:o-><x:v-x:s-$value" /></x:o-> </x:c-> </x:va-> <!-- image editor --> <div style="background-image:url(\'{$url}\');background-repeat:no-repeat;" class="ntb-image"> <img border="0" src="{$url}" align="middle" style="visibility:hidden;" /> </div> </x:t-> <x:t- match="*[@type=\'DATE\']"> <x:p-x:n-value" /> <x:va-x:n-date-mask"> <x:c-> <x:wh- test="@Mask"><x:v-x:s-@Mask" /></x:wh-> <x:o->MMM d, yy</x:o-> </x:c-> </x:va-> <x:va-x:n-date"> <x:ct-x:n-d:format-date"> <x:w-x:n-date-time"x:s-$value" /> <x:w-x:n-mask"x:s-$date-mask" /> </x:ct-> </x:va-> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$date" /> </x:ct-> </x:t-> <x:t- match="*[@type=\'TEXTAREA\']"> <x:p-x:n-value" /> <x:ct-x:n-replace-break"> <x:w-x:n-text"> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </x:w-> </x:ct-> </x:t-> <x:t- match="*[@type=\'PASSWORD\']">********</x:t-> <x:t- match="*[@type=\'LINK\']"> <x:p-x:n-value" /> <span class="ntb-hyperlink-editor"> <x:ct-x:n-replaceblank"> <x:w-x:n-value"x:s-$value" /> </x:ct-> </span> </x:t-> <x:t-x:n-placeholder"/><x:t-x:n-replaceblank"> <x:p-x:n-value" /> <x:c-> <x:wh- test="not($value) or $value = \'\' or $value = \' \'">ATOKENTOREPLACE</x:wh-> <x:o-><x:v-x:s-$value" /></x:o-> </x:c-></x:t-><x:t-x:n-replace"> <x:p-x:n-text"/> <x:p-x:n-search"/> <x:p-x:n-replacement"/> <x:c-> <x:wh- test="contains($text, $search)"> <x:v-x:s-substring-before($text, $search)"/> <x:v-x:s-$replacement"/> <x:ct-x:n-replace"> <x:w-x:n-text"x:s-substring-after($text,$search)"/> <x:w-x:n-search"x:s-$search"/> <x:w-x:n-replacement"x:s-$replacement"/> </x:ct-> </x:wh-> <x:o-> <x:v-x:s-$text"/> </x:o-> </x:c-></x:t-><x:t-x:n-print-displayfields"> <x:p-x:n-field" /> <x:c-> <x:wh- test="contains($field,\'|\')" > <!-- Here we hardcode a spacer \', \' - this should probably be moved elsewhere. --> <x:v-x:s-concat(@*[name(.)=substring-before($field,\'|\')],\', \')" /> <x:ct-x:n-print-displayfields"> <x:w-x:n-field"x:s-substring-after($field,\'|\')" /> </x:ct-> </x:wh-> <x:o-> <x:v-x:s-@*[name(.)=$field]" /> </x:o-> </x:c-></x:t-><x:t-x:n-replace-break"> <x:p-x:n-text"/> <x:ct-x:n-replace"> <x:w-x:n-text"x:s-$text"/> <x:w-x:n-search"x:s-\'&amp;amp;#xa;\'"/> <x:w-x:n-replacement"x:s-\'&amp;lt;br/&amp;gt;\'"/> </x:ct-></x:t-><x:t-x:n-ClassName"> <x:p-x:n-row"/> <x:va-x:n-class"x:s-@ClassName"/> <x:va-x:n-value"x:s-$row/@*[name()=$class]"/> <x:c-> <x:wh- test="$value"><x:v-x:s-$value"/></x:wh-> <x:o-><x:v-x:s-$class"/></x:o-> </x:c-></x:t-><x:t-x:n-CssStyle"> <x:p-x:n-row"/> <x:va-x:n-style"x:s-@CssStyle"/> <x:va-x:n-value"x:s-$row/@*[name()=$style]"/> <x:c-> <x:wh- test="$value"><x:v-x:s-$value"/></x:wh-> <x:o-><x:v-x:s-$style"/></x:o-> </x:c-></x:t-><!--This can be used as an insertion point for column templates--> <!--COLUMN-TYPE-TEMPLATES--></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.grid");
nitobi.grid.rowXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_rowXslProc));
var temp_ntb_sortXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes" /> <x:p-x:n-column"x:s-@xi"> </x:p-> <x:p-x:n-dir"x:s-\'ascending\'"> </x:p-> <x:p-x:n-type"x:s-\'text\'"> </x:p-> <x:t- match="*|@*"> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <x:t- match="ntb:data"> <xsl:copy> <x:at-x:s-@*"/> <xsl:for-eachx:s-ntb:e"> <xsl:sortx:s-@*[name() =$column]" order="{$dir}" data-type="{$type}"/> <xsl:copy> <x:a-x:n-xi"> <x:v-x:s-position()-1" /> </x:a-> <x:at-x:s-@*" /> </xsl:copy> </xsl:for-each> </xsl:copy> </x:t-><x:t- match="@xi" /></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.sortXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_sortXslProc));
var temp_ntb_fillColumnXslProc='<?xml version="1.0" encoding="utf-8"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="no" /> <x:p-x:n-startRowIndex"x:s-0" ></x:p-> <x:p-x:n-endRowIndex"x:s-10000" ></x:p-> <x:p-x:n-value"x:s-test"></x:p-> <x:p-x:n-column"x:s-a"></x:p-> <x:t- match="@* | node()" > <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <x:t- match="/ntb:grid/ntb:datasources/ntb:datasource/ntb:data/ntb:e"> <x:c-> <x:wh- test="(number(@xi) &gt;= $startRowIndex) and (number(@xi) &lt;= $endRowIndex)"> <xsl:copy> <xsl:copy-ofx:s-@*" /> <x:a-x:n-{$column}"><x:v-x:s-$value" /></x:a-> </xsl:copy> </x:wh-> <x:o-> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:o-> </x:c-> </x:t-></xsl:stylesheet> ';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.fillColumnXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_fillColumnXslProc));
var temp_ntb_updategramTranslatorXslProc='<?xml version="1.0"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" encoding="utf-8" omit-xml-declaration="yes"/> <x:p-x:n-datasource-id"x:s-\'_default\'"></x:p-> <x:p-x:n-xkField" ></x:p-> <x:t- match="/"> <root> <x:at-x:s-//ntb:datasource[@id=$datasource-id]/ntb:data/ntb:e" /> </root> </x:t-> <x:t- match="ntb:e"> <x:c-> <x:wh- test="@xac=\'d\'"> <delete xi="{@xi}" xk="{@*[name() = $xkField]}"></delete> </x:wh-> <x:wh- test="@xac=\'i\'"> <insert><xsl:copy-ofx:s-@*[not(name() = $xkField) and not(name() = \'xac\')]" /><x:a-x:n-xk"><x:v-x:s-@*[name() = $xkField]" /></x:a-></insert> </x:wh-> <x:wh- test="@xac=\'u\'"> <update><xsl:copy-ofx:s-@*[not(name() = $xkField) and not(name() = \'xac\')]" /><x:a-x:n-xk"><x:v-x:s-@*[name() = $xkField]" /></x:a-></update> </x:wh-> </x:c-> </x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.data");
nitobi.data.updategramTranslatorXslProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_updategramTranslatorXslProc));
var temp_ntb_datePickerTemplate='<?xml version="1.0"?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" omit-xml-declaration="yes" /> <xsl:strip-space elements="*"/> <x:t- match="ntb:datepicker"> <div id="{@id}"> <x:a-x:n-class"> ntb-calendar-reset <x:v-x:s-@theme"/> </x:a-> <x:at-x:s-ntb:dateinput"/> <xsl:if test="ntb:calendar and ntb:dateinput"> <div id="{@id}.button" style="float:left;" class="ntb-calendar-button"> <x:ct-x:n-dummy"></x:ct-> </div> </xsl:if> <div style="display:block;clear:both;float:none;height:0px;width:auto;overflow:hidden;"><xsl:comment>dummy</xsl:comment></div> <x:at-x:s-ntb:calendar"/> <input id="{@id}.value" type="hidden" value=""x:n-{@id}"/> </div> </x:t-> <x:t- match="ntb:dateinput"> <x:va-x:n-width"> <x:c-> <x:wh- test="contains(@width, \'px\')"> <x:v-x:s-substring-before(@width, \'px\')"/> </x:wh-> <x:o-> <x:v-x:s-@width" /> </x:o-> </x:c-> </x:va-> <div id="{@id}" style="float:left;"> <div id="{@id}.container" class="ntb-inputcontainer"> <x:a-x:n-style"> <xsl:if test="@width">width:<x:v-x:s-$width"/>px;</xsl:if> </x:a-> <input id="{@id}.input" type="text" class="ntb-dateinput"> <x:a-x:n-style"> font-size:100%;<xsl:if test="@cssstyle"><x:v-x:s-@cssstyle"/></xsl:if>; <xsl:if test="@width">width: <x:v-x:s-number($width) - 10"/>px;</xsl:if> </x:a-> <xsl:if test="@editable = \'false\'"> <x:a-x:n-disabled">true</x:a-> </xsl:if> </input> </div> </div> </x:t-> <x:t- match="ntb:calendar"> <div id="{@id}" onselectstart="return false;"> <x:a-x:n-style"> <xsl:if test="../ntb:dateinput">position:absolute;z-index:1000;</xsl:if>overflow:hidden; </x:a-> <x:a-x:n-class"> ntb-calendar-container nitobi-hide </x:a-> <x:ct-x:n-dummy"/> </div> </x:t-> <x:t-x:n-dummy"> <xsl:comment>dummy</xsl:comment> </x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.calendar");
nitobi.calendar.datePickerTemplate = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_datePickerTemplate));