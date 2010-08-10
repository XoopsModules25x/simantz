if(typeof (nitobi)=="undefined"){
nitobi=function(){
};
}
if(false){
nitobi.lang=function(){
};
}
if(typeof (nitobi.lang)=="undefined"){
nitobi.lang={};
}
nitobi.lang.defineNs=function(_1){
var _2=_1.split(".");
var _3="";
var _4="";
for(var i=0;i<_2.length;i++){
_3+=_4+_2[i];
_4=".";
if(eval("typeof("+_3+")")=="undefined"){
eval(_3+"={}");
}
}
};
nitobi.lang.extend=function(_6,_7){
function inheritance(){
}
inheritance.prototype=_7.prototype;
_6.prototype=new inheritance();
_6.prototype.constructor=_6;
_6.baseConstructor=_7;
if(_7.base){
_7.prototype.base=_7.base;
}
_6.base=_7.prototype;
};
nitobi.lang.implement=function(_8,_9){
for(var _a in _9.prototype){
if(typeof (_8.prototype[_a])=="undefined"||_8.prototype[_a]==null){
_8.prototype[_a]=_9.prototype[_a];
}
}
};
nitobi.lang.setJsProps=function(p,_c){
for(var i=0;i<_c.length;i++){
var _e=_c[i];
p["set"+_e.n]=this.jSET;
p["get"+_e.n]=this.jGET;
p[_e.n]=_e.d;
}
};
nitobi.lang.setXmlProps=function(p,_10){
for(var i=0;i<_10.length;i++){
var _12=_10[i];
var s,g;
switch(_12.t){
case "i":
s=this.xSET;
g=this.xiGET;
break;
case "b":
s=this.xbSET;
g=this.xbGET;
break;
default:
s=this.xSET;
g=this.xGET;
}
p["set"+_12.n]=s;
p["get"+_12.n]=g;
p["sModel"]+=_12.n+"\""+_12.d+"\" ";
}
};
nitobi.lang.setEvents=function(p,_16){
for(var i=0;i<_16.length;i++){
var n=_16[i];
p["set"+n]=this.eSET;
p["get"+n]=this.eGET;
var nn=n.substring(0,n.length-5);
p["set"+nn]=this.eSET;
p["get"+nn]=this.eGET;
p["o"+n.substring(1)]=new nitobi.base.Event();
}
};
nitobi.lang.isDefined=function(a){
return (typeof (a)!="undefined");
};
nitobi.lang.getBool=function(a){
if(null==a){
return null;
}
if(typeof (a)=="boolean"){
return a;
}
return a.toLowerCase()=="true";
};
nitobi.lang.type={XMLNODE:0,HTMLNODE:1,ARRAY:2,XMLDOC:3};
nitobi.lang.typeOf=function(obj){
var t=typeof (obj);
if(t=="object"){
if(obj.blur&&obj.innerHTML){
return nitobi.lang.type.HTMLNODE;
}
if(obj.nodeName&&obj.nodeName.toLowerCase()==="#document"){
return nitobi.lang.type.XMLDOC;
}
if(obj.nodeName){
return nitobi.lang.type.XMLNODE;
}
if(obj instanceof Array){
return nitobi.lang.type.ARRAY;
}
}
return t;
};
nitobi.lang.toBool=function(_1e,_1f){
if(typeof (_1f)!="undefined"){
if((typeof (_1e)=="undefined")||(_1e=="")||(_1e==null)){
_1e=_1f;
}
}
_1e=_1e.toString()||"";
_1e=_1e.toUpperCase();
if((_1e=="Y")||(_1e=="1")||(_1e=="TRUE")){
return true;
}else{
return false;
}
};
nitobi.lang.boolToStr=function(_20){
if((typeof (_20)=="boolean"&&_20)||(typeof (_20)=="string"&&(_20.toLowerCase()=="true"||_20=="1"))){
return "1";
}else{
return "0";
}
return _20;
};
nitobi.lang.formatNumber=function(_21,_22,_23,_24){
var n=nitobi.form.numberXslProc;
n.addParameter("number",_21,"");
n.addParameter("mask",_22,"");
n.addParameter("group",_23,"");
n.addParameter("decimal",_24,"");
return nitobi.xml.transformToString(nitobi.xml.Empty,nitobi.form.numberXslProc);
};
nitobi.lang.close=function(_26,_27,_28){
if(null==_28){
return function(){
return _27.apply(_26,arguments);
};
}else{
return function(){
return _27.apply(_26,_28);
};
}
};
nitobi.lang.after=function(_29,_2a,_2b,_2c){
var _2d=_29[_2a];
var _2e=_2b[_2c];
if(_2c instanceof Function){
_2e=_2c;
}
_29[_2a]=function(){
_2d.apply(_29,arguments);
_2e.apply(_2b,arguments);
};
_29[_2a].orig=_2d;
};
nitobi.lang.before=function(_2f,_30,_31,_32){
var _33=_2f[_30];
var _34=function(){
};
if(_31!=null){
_34=_31[_32];
}
if(_32 instanceof Function){
_34=_32;
}
_2f[_30]=function(){
_34.apply(_31,arguments);
_33.apply(_2f,arguments);
};
_2f[_30].orig=_33;
};
nitobi.lang.forEach=function(arr,_36){
var len=arr.length;
for(var i=0;i<len;i++){
_36.call(this,arr[i],i);
}
_36=null;
};
nitobi.lang.throwError=function(_39,_3a){
var msg=_39;
if(_3a!=null){
msg+="\n - because "+nitobi.lang.getErrorDescription(_3a);
}
throw msg;
};
nitobi.lang.getErrorDescription=function(_3c){
var _3d=(typeof (_3c.description)=="undefined")?_3c:_3c.description;
return _3d;
};
nitobi.lang.newObject=function(_3e,_3f,_40){
var a=_3f;
if(null==_40){
_40=0;
}
var e="new "+_3e+"(";
var _43="";
for(var i=_40;i<a.length;i++){
e+=_43+"a["+i+"]";
_43=",";
}
e+=")";
return eval(e);
};
nitobi.lang.getLastFunctionArgs=function(_45,_46){
var a=new Array(_45.length-_46);
for(var i=_46;i<_45.length;i++){
a[i-_46]=_45[i];
}
return a;
};
nitobi.lang.getFirstHashKey=function(_49){
for(var x in _49){
return x;
}
};
nitobi.lang.getFirstFunction=function(obj){
for(var x in obj){
if(obj[x]!=null&&typeof (obj[x])=="function"&&typeof (obj[x].prototype)!="undefined"){
return {name:x,value:obj[x]};
}
}
return null;
};
nitobi.lang.copy=function(obj){
var _4e={};
for(var _4f in obj){
_4e[_4f]=obj[_4f];
}
return _4e;
};
nitobi.lang.dispose=function(_50,_51){
try{
if(_51!=null){
var _52=_51.length;
for(var i=0;i<_52;i++){
if(typeof (_51[i].dispose)=="function"){
_51[i].dispose();
}
if(typeof (_51[i])=="function"){
_51[i].call(_50);
}
_51[i]=null;
}
}
for(var _54 in _50){
if(_50[_54]!=null&&_50[_54].dispose instanceof Function){
_50[_54].dispose();
}
_50[_54]=null;
}
}
catch(e){
}
};
nitobi.lang.parseNumber=function(val){
var num=parseInt(val);
return (isNaN(num)?0:num);
};
nitobi.lang.numToAlpha=function(num){
if(typeof (nitobi.lang.numAlphaCache[num])==="string"){
return nitobi.lang.numAlphaCache[num];
}
var ck1=num%26;
var ck2=Math.floor(num/26);
var _5a=(ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
nitobi.lang.alphaNumCache[_5a]=num;
nitobi.lang.numAlphaCache[num]=_5a;
return _5a;
};
nitobi.lang.alphaToNum=function(_5b){
if(typeof (nitobi.lang.alphaNumCache[_5b])==="number"){
return nitobi.lang.alphaNumCache[_5b];
}
var j=0;
var num=0;
for(var i=_5b.length-1;i>=0;i--){
num+=(_5b.charCodeAt(i)-96)*Math.pow(26,j++);
}
num=num-1;
nitobi.lang.alphaNumCache[_5b]=num;
nitobi.lang.numAlphaCache[num]=_5b;
return num;
};
nitobi.lang.alphaNumCache={};
nitobi.lang.numAlphaCache={};
nitobi.lang.toArray=function(obj,_60){
return Array.prototype.splice.call(obj,_60||0);
};
nitobi.lang.merge=function(_61,_62){
var r={};
for(var i=0;i<arguments.length;i++){
var a=arguments[i];
for(var x in arguments[i]){
r[x]=a[x];
}
}
return r;
};
nitobi.lang.xor=function(){
var b=false;
for(var j=0;j<arguments.length;j++){
if(arguments[j]&&!b){
b=true;
}else{
if(arguments[j]&&b){
return false;
}
}
}
return b;
};
nitobi.lang.zeros="00000000000000000000000000000000000000000000000000000000000000000000";
nitobi.lang.padZeros=function(num,_6a){
_6a=_6a||2;
num=num+"";
return nitobi.lang.zeros.substr(0,Math.max(_6a-num.length,0))+num;
};
nitobi.lang.noop=function(){
};
nitobi.lang.isStandards=function(){
var s=(document.compatMode=="CSS1Compat");
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
var _6c=document.createElement("div");
_6c.style.cssText="width:0px;width:1";
s=(parseInt(_6c.style.width)!=1);
}
return s;
};
nitobi.lang.defineNs("nitobi.lang");
nitobi.lang.Math=function(){
};
nitobi.lang.Math.sinTable=Array();
nitobi.lang.Math.cosTable=Array();
nitobi.lang.Math.rotateCoords=function(_6d,_6e,_6f){
var _70=_6f*0.01745329277777778;
if(nitobi.lang.Math.sinTable[_70]==null){
nitobi.lang.Math.sinTable[_70]=Math.sin(_70);
nitobi.lang.Math.cosTable[_70]=Math.cos(_70);
}
var cR=nitobi.lang.Math.cosTable[_70];
var sR=nitobi.lang.Math.sinTable[_70];
var x=_6d*cR-_6e*sR;
var y=_6e*cR+_6d*sR;
return {x:x,y:y};
};
nitobi.lang.Math.returnAngle=function(_75,_76,_77,_78){
return Math.atan2(_78-_76,_77-_75)/0.01745329277777778;
};
nitobi.lang.Math.returnDistance=function(x1,y1,x2,y2){
return Math.sqrt(((x2-x1)*(x2-x1))+((y2-y1)*(y2-y1)));
};
nitobi.lang.defineNs("nitobi");
nitobi.Object=function(){
this.disposal=new Array();
this.modelNodes={};
};
nitobi.Object.prototype.setValues=function(_7d){
for(var _7e in _7d){
if(this[_7e]!=null){
if(this[_7e].subscribe!=null){
}else{
this[_7e]=_7d[_7e];
}
}else{
if(this[_7e] instanceof Function){
this[_7e](_7d[_7e]);
}else{
if(this["set"+_7e] instanceof Function){
this["set"+_7e](_7d[_7e]);
}else{
this[_7e]=_7d[_7e];
}
}
}
}
};
nitobi.Object.prototype.xGET=function(){
var _7f=null,_80="@"+arguments[0],val="";
var _82=this.modelNodes[_80];
if(_82!=null){
_7f=_82;
}else{
_7f=this.modelNodes[_80]=this.modelNode.selectSingleNode(_80);
}
if(_7f!=null){
val=_7f.nodeValue;
}
return val;
};
nitobi.Object.prototype.xSET=function(){
var _83=null,_84="@"+arguments[0];
var _85=this.modelNodes[_84];
if(_85!=null){
_83=_85;
}else{
_83=this.modelNodes[_84]=this.modelNode.selectSingleNode(_84);
}
if(_83==null){
this.modelNode.setAttribute(arguments[0],"");
}
if(arguments[1][0]!=null&&_83!=null){
if(typeof (arguments[1][0])=="boolean"){
_83.nodeValue=nitobi.lang.boolToStr(arguments[1][0]);
}else{
_83.nodeValue=arguments[1][0];
}
}
};
nitobi.Object.prototype.eSET=function(_86,_87){
var _88=_87[0];
var _89=_88;
var _8a=_86.substr(2);
_8a=_8a.substr(0,_8a.length-5);
if(typeof (_88)=="string"){
_89=function(){
return nitobi.event.evaluate(_88,arguments[0]);
};
}
if(this[_86]!=null){
this.unsubscribe(_8a,this[_86]);
}
var _8b=this.subscribe(_8a,_89);
this.jSET(_86,[_8b]);
return _8b;
};
nitobi.Object.prototype.eGET=function(){
};
nitobi.Object.prototype.jSET=function(_8c,val){
this[_8c]=val[0];
};
nitobi.Object.prototype.jGET=function(_8e){
return this[_8e];
};
nitobi.Object.prototype.xsGET=nitobi.Object.prototype.xGET;
nitobi.Object.prototype.xsSET=nitobi.Object.prototype.xSET;
nitobi.Object.prototype.xbGET=function(){
return nitobi.lang.toBool(this.xGET.apply(this,arguments),false);
};
nitobi.Object.prototype.xiGET=function(){
return parseInt(this.xGET.apply(this,arguments));
};
nitobi.Object.prototype.xiSET=nitobi.Object.prototype.xSET;
nitobi.Object.prototype.xdGET=function(){
};
nitobi.Object.prototype.xnGET=function(){
return parseFloat(this.xGET.apply(this,arguments));
};
nitobi.Object.prototype.xbSET=function(){
this.xSET.call(this,arguments[0],[nitobi.lang.boolToStr(arguments[1][0])]);
};
nitobi.Object.prototype.fire=function(evt,_90){
return nitobi.event.notify(evt+this.uid,_90);
};
nitobi.Object.prototype.subscribe=function(evt,_92,_93){
if(this.subscribedEvents==null){
this.subscribedEvents={};
}
if(typeof (_93)=="undefined"){
_93=this;
}
var _94=nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(_93,_92));
this.subscribedEvents[_94]=evt+this.uid;
return _94;
};
nitobi.Object.prototype.subscribeOnce=function(evt,_96,_97,_98){
var _99=this;
var _9a=function(){
_96.apply(_97||this,_98||arguments);
_99.unsubscribe(evt,_9b);
};
var _9b=this.subscribe(evt,_9a);
return _9b;
};
nitobi.Object.prototype.unsubscribe=function(evt,_9d){
return nitobi.event.unsubscribe(evt+this.uid,_9d);
};
nitobi.Object.prototype.dispose=function(){
if(this.disposing){
return;
}
this.disposing=true;
var _9e=this.disposal.length;
for(var i=0;i<_9e;i++){
if(disposal[i] instanceof Function){
disposal[i].call(context);
}
disposal[i]=null;
}
for(var _a0 in this){
if(this[_a0].dispose instanceof Function){
this[_a0].dispose.call(this[_a0]);
}
this[_a0]=null;
}
};
if(false){
nitobi.base=function(){
};
}
nitobi.lang.defineNs("nitobi.base");
nitobi.base.uid=1;
nitobi.base.getUid=function(){
return "ntb__"+(nitobi.base.uid++);
};
nitobi.lang.defineNs("nitobi.browser");
if(false){
nitobi.browser=function(){
};
}
nitobi.browser.UNKNOWN=true;
nitobi.browser.IE=false;
nitobi.browser.IE6=false;
nitobi.browser.IE7=false;
nitobi.browser.IE8=false;
nitobi.browser.MOZ=false;
nitobi.browser.FF3=false;
nitobi.browser.SAFARI=false;
nitobi.browser.OPERA=false;
nitobi.browser.AIR=false;
nitobi.browser.CHROME=false;
nitobi.browser.XHR_ENABLED;
nitobi.browser.detect=function(){
var _a1=[{string:navigator.vendor,subString:"Adobe",identity:"AIR"},{string:navigator.vendor,subString:"Google",identity:"Chrome"},{string:navigator.vendor,subString:"Apple",identity:"Safari"},{prop:window.opera,identity:"Opera"},{string:navigator.vendor,subString:"iCab",identity:"iCab"},{string:navigator.vendor,subString:"KDE",identity:"Konqueror"},{string:navigator.userAgent,subString:"Firefox",identity:"Firefox"},{string:navigator.userAgent,subString:"Netscape",identity:"Netscape"},{string:navigator.userAgent,subString:"MSIE",identity:"Explorer",versionSearch:"MSIE"},{string:navigator.userAgent,subString:"Gecko",identity:"Mozilla",versionSearch:"rv"},{string:navigator.userAgent,subString:"Mozilla",identity:"Netscape",versionSearch:"Mozilla"},{string:navigator.vendor,subString:"Camino",identity:"Camino"}];
var _a2="Unknown";
for(var i=0;i<_a1.length;i++){
var _a4=_a1[i].string;
var _a5=_a1[i].prop;
if(_a4){
if(_a4.indexOf(_a1[i].subString)!=-1){
_a2=_a1[i].identity;
break;
}
}else{
if(_a5){
_a2=_a1[i].identity;
break;
}
}
}
nitobi.browser.IE=(_a2=="Explorer");
nitobi.browser.IE6=(nitobi.browser.IE&&!window.XMLHttpRequest);
nitobi.browser.IE7=(nitobi.browser.IE&&window.XMLHttpRequest);
nitobi.browser.MOZ=(_a2=="Netscape"||_a2=="Firefox"||_a2=="Camino");
nitobi.browser.FF3=(_a2=="Firefox"&&parseInt(navigator.userAgent.substr(navigator.userAgent.indexOf("Firefox/")+8,3))==3);
nitobi.browser.SAFARI=(_a2=="Safari");
nitobi.browser.OPERA=(_a2=="Opera");
nitobi.browser.AIR=(_a2=="AIR");
nitobi.browser.CHROME=(_a2=="Chrome");
if(nitobi.browser.SAFARI){
nitobi.browser.OPERA=true;
}
if(nitobi.browser.AIR){
nitobi.browser.SAFARI=true;
}
nitobi.browser.XHR_ENABLED=nitobi.browser.OPERA||nitobi.browser.SAFARI||nitobi.browser.MOZ||nitobi.browser.IE||nitobi.browser.CHROME;
nitobi.browser.UNKNOWN=!(nitobi.browser.IE||nitobi.browser.MOZ||nitobi.browser.SAFARI||nitobi.browser.CHROME);
};
nitobi.browser.detect();
if(nitobi.browser.IE6){
try{
document.execCommand("BackgroundImageCache",false,true);
}
catch(e){
}
}
nitobi.lang.defineNs("nitobi.browser");
nitobi.browser.Cookies=function(){
};
nitobi.lang.extend(nitobi.browser.Cookies,nitobi.Object);
nitobi.browser.Cookies.get=function(id){
var _a7,end;
if(document.cookie.length>0){
_a7=document.cookie.indexOf(id+"=");
if(_a7!=-1){
_a7+=id.length+1;
end=document.cookie.indexOf(";",_a7);
if(end==-1){
end=document.cookie.length;
}
return unescape(document.cookie.substring(_a7,end));
}
}
return null;
};
nitobi.browser.Cookies.set=function(id,_aa,_ab){
var _ac=new Date();
_ac.setTime(_ac.getTime()+(_ab*24*3600*1000));
document.cookie=id+"="+escape(_aa)+((_ab==null)?"":"; expires="+_ac.toGMTString());
};
nitobi.browser.Cookies.remove=function(id){
if(nitobi.browser.Cookies.get(id)){
document.cookie=id+"="+"; expires=Thu, 01-Jan-70 00:00:01 GMT";
}
};
nitobi.lang.defineNs("nitobi.browser");
nitobi.browser.History=function(){
this.lastPage="";
this.currentPage="";
this.onChange=new nitobi.base.Event();
this.iframeObject=nitobi.html.createElement("iframe",{"name":"ntb_history","id":"ntb_history"},{"display":"none"});
document.body.appendChild(nitobi.xml.importNode(document,this.iframeObject,true));
this.iframe=frames["ntb_history"];
this.monitor();
};
nitobi.browser.History.prototype.add=function(_ae){
this.lastPage=this.currentPage=_ae.substr(_ae.indexOf("#")+1);
this.iframe.location.href=_ae;
};
nitobi.browser.History.prototype.monitor=function(){
var _af=this.iframe.location.href.split("#");
this.currentPage=_af[1];
if(this.currentPage!=this.lastPage){
this.onChange.notify(_af[0].substring(_af[0].lastIndexOf("/")+1),this.currentPage);
this.lastPage=this.currentPage;
}
window.setTimeout(nitobi.lang.close(this,this.monitor),1500);
};
nitobi.lang.defineNs("nitobi.xml");
nitobi.xml=function(){
};
nitobi.xml.nsPrefix="ntb:";
nitobi.xml.nsDecl="xmlns:ntb=\"http://www.nitobi.com\"";
if(nitobi.browser.IE){
var inUse=false;
nitobi.xml.XslTemplate=new ActiveXObject("MSXML2.XSLTemplate.3.0");
}
if(typeof XMLSerializer!="undefined"&&typeof DOMParser!="undefined"){
nitobi.xml.Serializer=new XMLSerializer();
nitobi.xml.DOMParser=new DOMParser();
}
nitobi.xml.getChildNodes=function(_b0){
if(nitobi.browser.IE){
return _b0.childNodes;
}else{
return _b0.selectNodes("./*");
}
};
nitobi.xml.indexOfChildNode=function(_b1,_b2){
var _b3=nitobi.xml.getChildNodes(_b1);
for(var i=0;i<_b3.length;i++){
if(_b3[i]==_b2){
return i;
}
}
return -1;
};
nitobi.xml.createXmlDoc=function(xml){
if(xml!=null){
xml=xml.substring(xml.indexOf("<?xml"));
}
if(xml!=null&&xml.documentElement!=null){
return xml;
}
var doc=null;
if(nitobi.browser.IE){
doc=new ActiveXObject("Msxml2.DOMDocument.3.0");
doc.setProperty("SelectionNamespaces","xmlns:ntb='http://www.nitobi.com'");
}else{
if(document.implementation&&document.implementation.createDocument){
doc=document.implementation.createDocument("","",null);
}
}
if(xml!=null&&typeof xml=="string"){
doc=nitobi.xml.loadXml(doc,xml);
}
return doc;
};
nitobi.xml.loadXml=function(doc,xml,_b9){
doc.async=false;
if(nitobi.browser.IE){
doc.loadXML(xml);
}else{
var p=new DOMParser();
var _bb=xml.replace(/\n/g,"&#xa;").replace(/>&#xa;</g,">\n<");
var _bc=p.parseFromString(_bb!=null?_bb:"","text/xml");
if(_b9){
while(doc.hasChildNodes()){
doc.removeChild(doc.firstChild);
}
for(var i=0;i<_bc.childNodes.length;i++){
doc.appendChild(doc.importNode(_bc.childNodes[i],true));
}
}else{
doc=_bc;
}
_bc=null;
}
return doc;
};
nitobi.xml.hasParseError=function(_be){
if(nitobi.browser.IE){
return (_be.parseError!=0);
}else{
if(_be==null||_be.documentElement==null){
return true;
}
var _bf=_be.documentElement;
if((_bf.tagName=="parserError")||(_bf.namespaceURI=="http://www.mozilla.org/newlayout/xml/parsererror.xml")){
return true;
}
return false;
}
};
nitobi.xml.getParseErrorReason=function(_c0){
if(!nitobi.xml.hasParseError(_c0)){
return "";
}
if(nitobi.browser.IE){
return (_c0.parseError.reason);
}else{
return (new XMLSerializer().serializeToString(_c0));
}
};
nitobi.xml.createXslDoc=function(xsl){
var doc=null;
if(nitobi.browser.IE){
doc=new ActiveXObject("MSXML2.FreeThreadedDOMDocument.3.0");
}else{
doc=nitobi.xml.createXmlDoc();
}
doc=nitobi.xml.loadXml(doc,xsl||"<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" xmlns:ntb=\"http://www.nitobi.com\" />");
return doc;
};
nitobi.xml.createXslProcessor=function(xsl){
var _c4=null;
var xt=null;
if(typeof (xsl)!="string"){
xsl=nitobi.xml.serialize(xsl);
}
if(nitobi.browser.IE){
_c4=new ActiveXObject("MSXML2.FreeThreadedDOMDocument.3.0");
xt=new ActiveXObject("MSXML2.XSLTemplate.3.0");
_c4.async=false;
_c4.loadXML(xsl);
xt.stylesheet=_c4;
return xt.createProcessor();
}else{
if(XSLTProcessor){
_c4=nitobi.xml.createXmlDoc(xsl);
xt=new XSLTProcessor();
xt.importStylesheet(_c4);
xt.stylesheet=_c4;
return xt;
}
}
};
nitobi.xml.parseHtml=function(_c6){
if(typeof (_c6)=="string"){
_c6=document.getElementById(_c6);
}
var _c7=nitobi.html.getOuterHtml(_c6);
var _c8="";
if(nitobi.browser.IE){
var _c9=new RegExp("(\\s+.[^=]*)='(.*?)'","g");
_c7=_c7.replace(_c9,function(m,_1,_2){
return _1+"=\""+_2.replace(/"/g,"&quot;")+"\"";
});
_c8=(_c7.substring(_c7.indexOf("/>")+2).replace(/(\s+.[^\=]*)\=\s*([^\"^\s^\>]+)/g,"$1=\"$2\" ")).replace(/\n/gi,"").replace(/(.*?:.*?\s)/i,"$1  ");
var _cd=new RegExp("=\"([^\"]*)(<)(.*?)\"","gi");
var _ce=new RegExp("=\"([^\"]*)(>)(.*?)\"","gi");
while(true){
_c8=_c8.replace(_cd,"=\"$1&lt;$3\" ");
_c8=_c8.replace(_ce,"=\"$1&gt;$3\" ");
var x=(_cd.test(_c8));
if(!_cd.test(_c8)){
break;
}
}
}else{
_c8=_c7;
_c8=_c8.replace(/\n/gi,"").replace(/\>\s*\</gi,"><").replace(/(.*?:.*?\s)/i,"$1  ");
_c8=_c8.replace(/\&/g,"&amp;");
_c8=_c8.replace(/\&amp;gt;/g,"&gt;").replace(/\&amp;lt;/g,"&lt;").replace(/\&amp;apos;/g,"&apos;").replace(/\&amp;quot;/g,"&quot;").replace(/\&amp;amp;/g,"&amp;").replace(/\&amp;eq;/g,"&eq;");
}
if(_c8.indexOf("xmlns:ntb=\"http://www.nitobi.com\"")<1){
_c8=_c8.replace(/\<(.*?)(\s|\>|\\)/,"<$1 xmlns:ntb=\"http://www.nitobi.com\"$2");
}
_c8=_c8.replace(/\&nbsp\;/gi," ");
return nitobi.xml.createXmlDoc(_c8);
};
nitobi.xml.transform=function(xml,xsl,_d2){
if(xsl.documentElement){
xsl=nitobi.xml.createXslProcessor(xsl);
}
if(nitobi.browser.IE){
xsl.input=xml;
xsl.transform();
return xsl.output;
}else{
if(XSLTProcessor){
var _d3;
var doc;
if(nitobi.browser.MOZ){
doc=xsl.transformToDocument(xml);
}else{
var p=new DOMParser();
if(xml.xml.indexOf("\n")>0){
_d3=xml.xml.replace(/\n/g,"{nl}").replace(/>{nl}</g,">\n<");
xml=p.parseFromString(_d3!=null?_d3:"","text/xml");
}
doc=xsl.transformToDocument(xml);
var _d6=doc.xml.replace(/{nl}/g,"&#xa;");
doc=p.parseFromString(_d6!=null?_d6:"","text/xml");
}
var _d7=doc.documentlement;
if(_d7&&_d7.nodeName.indexOf("ntb:")==0){
_d7.setAttributeNS("http://www.w3.org/2000/xmlns/","xmlns:ntb","http://www.nitobi.com");
}
return doc;
}
}
};
nitobi.xml.transformToString=function(xml,xsl,_da){
var _db=nitobi.xml.transform(xml,xsl,"text");
if(nitobi.browser.MOZ){
if(_da=="xml"){
_db=nitobi.xml.Serializer.serializeToString(_db);
}else{
if(_db.documentElement.childNodes[0]==null){
nitobi.lang.throwError("The transformToString fn could not find any valid output");
}
if(_db.documentElement.childNodes[0].data!=null){
_db=_db.documentElement.childNodes[0].data;
}else{
if(_db.documentElement.childNodes[0].textContent!=null){
_db=_db.documentElement.childNodes[0].textContent;
}else{
nitobi.lang.throwError("The transformToString fn could not find any valid output");
}
}
}
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
if(_da=="xml"){
_db=nitobi.xml.Serializer.serializeToString(_db);
}else{
var _dc=_db.documentElement;
if(_dc.nodeName!="transformiix:result"){
_dc=_dc.getElementsByTagName("pre")[0];
}
try{
_db=_dc.childNodes[0].data;
}
catch(e){
_db=(_dc.data);
}
}
}
}
return _db;
};
nitobi.xml.transformToXml=function(xml,xsl){
var _df=nitobi.xml.transform(xml,xsl,"xml");
if(typeof _df=="string"){
_df=nitobi.xml.createXmlDoc(_df);
}else{
if(_df.documentElement.nodeName=="transformiix:result"){
_df=nitobi.xml.createXmlDoc(_df.documentElement.firstChild.data);
}
}
return _df;
};
nitobi.xml.serialize=function(xml){
if(nitobi.browser.IE){
return xml.xml;
}else{
return (new XMLSerializer()).serializeToString(xml);
}
};
nitobi.xml.createXmlHttp=function(){
if(nitobi.browser.IE){
var _e1=null;
try{
_e1=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e){
try{
_e1=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(ee){
}
}
return _e1;
}else{
return new XMLHttpRequest();
}
};
nitobi.xml.createElement=function(_e2,_e3,ns){
ns=ns||"http://www.nitobi.com";
var _e5=null;
if(nitobi.browser.IE){
_e5=_e2.createNode(1,nitobi.xml.nsPrefix+_e3,ns);
}else{
if(_e2.createElementNS){
_e5=_e2.createElementNS(ns,nitobi.xml.nsPrefix+_e3);
}
}
return _e5;
};
function nitobiXmlDecodeXslt(xsl){
return xsl.replace(/x:c-/g,"xsl:choose").replace(/x\:wh\-/g,"xsl:when").replace(/x\:o\-/g,"xsl:otherwise").replace(/x\:n\-/g," name=\"").replace(/x\:s\-/g," select=\"").replace(/x\:va\-/g,"xsl:variable").replace(/x\:v\-/g,"xsl:value-of").replace(/x\:ct\-/g,"xsl:call-template").replace(/x\:w\-/g,"xsl:with-param").replace(/x\:p\-/g,"xsl:param").replace(/x\:t\-/g,"xsl:template").replace(/x\:at\-/g,"xsl:apply-templates").replace(/x\:a\-/g,"xsl:attribute");
}
if(!nitobi.browser.IE){
Document.prototype.loadXML=function(_e7){
changeReadyState(this,1);
var p=new DOMParser();
var d=p.parseFromString(_e7,"text/xml");
while(this.hasChildNodes()){
this.removeChild(this.lastChild);
}
for(var i=0;i<d.childNodes.length;i++){
this.appendChild(this.importNode(d.childNodes[i],true));
}
changeReadyState(this,4);
};
Document.prototype.__defineGetter__("xml",function(){
return (new XMLSerializer()).serializeToString(this);
});
Node.prototype.__defineGetter__("xml",function(){
return (new XMLSerializer()).serializeToString(this);
});
XPathResult.prototype.__defineGetter__("length",function(){
return this.snapshotLength;
});
if(XSLTProcessor){
XSLTProcessor.prototype.addParameter=function(_eb,_ec,_ed){
if(_ec==null){
this.removeParameter(_ed,_eb);
}else{
this.setParameter(_ed,_eb,_ec);
}
};
}
XMLDocument.prototype.selectNodes=function(_ee,_ef){
try{
if(this.nsResolver==null){
this.nsResolver=this.createNSResolver(this.documentElement);
}
var _f0=this.evaluate(_ee,(_ef?_ef:this),new MyNSResolver(),XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,null);
var _f1=new Array(_f0.snapshotLength);
_f1.expr=_ee;
var j=0;
for(i=0;i<_f0.snapshotLength;i++){
var _f3=_f0.snapshotItem(i);
if(_f3.nodeType!=3){
_f1[j++]=_f3;
}
}
return _f1;
}
catch(e){
}
};
Document.prototype.selectNodes=XMLDocument.prototype.selectNodes;
function MyNSResolver(){
}
MyNSResolver.prototype.lookupNamespaceURI=function(_f4){
switch(_f4){
case "xsl":
return "http://www.w3.org/1999/XSL/Transform";
break;
case "ntb":
return "http://www.nitobi.com";
break;
case "d":
return "http://exslt.org/dates-and-times";
break;
case "n":
return "http://www.nitobi.com/exslt/numbers";
break;
default:
return null;
break;
}
};
XMLDocument.prototype.selectSingleNode=function(_f5,_f6){
var _f7=_f5.match(/\[\d+\]/ig);
if(_f7!=null){
var x=_f7[_f7.length-1];
if(_f5.lastIndexOf(x)+x.length!=_f5.length){
_f5+="[1]";
}
}
var _f9=this.selectNodes(_f5,_f6||null);
return ((_f9!=null&&_f9.length>0)?_f9[0]:null);
};
Document.prototype.selectSingleNode=XMLDocument.prototype.selectSingleNode;
Element.prototype.selectNodes=function(_fa){
var doc=this.ownerDocument;
return doc.selectNodes(_fa,this);
};
Element.prototype.selectSingleNode=function(_fc){
var doc=this.ownerDocument;
return doc.selectSingleNode(_fc,this);
};
}
nitobi.xml.getLocalName=function(_fe){
var _ff=_fe.indexOf(":");
if(_ff==-1){
return _fe;
}else{
return _fe.substr(_ff+1);
}
};
nitobi.xml.importNode=function(doc,node,_102){
if(_102==null){
_102=true;
}
return (doc.importNode?doc.importNode(node,_102):node);
};
nitobi.xml.encode=function(str){
str+="";
str=str.replace(/&/g,"&amp;");
str=str.replace(/'/g,"&apos;");
str=str.replace(/\"/g,"&quot;");
str=str.replace(/</g,"&lt;");
str=str.replace(/>/g,"&gt;");
str=str.replace(/\n/g,"&#xa;");
return str;
};
nitobi.xml.constructValidXpathQuery=function(_104,_105){
var _106=_104.match(/(\"|\')/g);
if(_106!=null){
var _107="concat(";
var _108="";
var _109;
for(var i=0;i<_104.length;i++){
if(_104.substr(i,1)=="\""){
_109="&apos;";
}else{
_109="&quot;";
}
_107+=_108+_109+nitobi.xml.encode(_104.substr(i,1))+_109;
_108=",";
}
_107+=_108+"&apos;&apos;";
_107+=")";
_104=_107;
}else{
var quot=(_105?"'":"");
_104=quot+nitobi.xml.encode(_104)+quot;
}
return _104;
};
nitobi.xml.removeChildren=function(_10c){
while(_10c.firstChild){
_10c.removeChild(_10c.firstChild);
}
};
nitobi.xml.Empty=nitobi.xml.createXmlDoc("<root></root>");
nitobi.lang.defineNs("nitobi.html");
nitobi.html.Url=function(){
};
nitobi.html.Url.setParameter=function(url,key,_10f){
var reg=new RegExp("(\\?|&)("+encodeURIComponent(key)+")=(.*?)(&|$)");
if(url.match(reg)){
return url.replace(reg,"$1$2="+encodeURIComponent(_10f)+"$4");
}
if(url.match(/\?/)){
url=url+"&";
}else{
url=url+"?";
}
return url+encodeURIComponent(key)+"="+encodeURIComponent(_10f);
};
nitobi.html.Url.removeParameter=function(url,key){
var reg=new RegExp("(\\?|&)("+encodeURIComponent(key)+")=(.*?)(&|$)");
return url.replace(reg,function(str,p1,p2,p3,p4,_119,s){
if(((p1)=="?")&&(p4!="&")){
return "";
}else{
return p1;
}
});
};
nitobi.html.Url.normalize=function(url,file){
if(file){
if(file.indexOf("http://")==0||file.indexOf("https://")==0||file.indexOf("/")==0){
return file;
}
}
var href=(url.match(/.*\//)||"")+"";
if(file){
return href+file;
}
return href;
};
nitobi.html.Url.randomize=function(url){
return nitobi.html.Url.setParameter(url,"ntb-random",(new Date).getTime());
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Event=function(type){
this.type=type;
this.handlers={};
this.guid=0;
this.setEnabled(true);
};
nitobi.base.Event.prototype.subscribe=function(_120,_121,guid){
if(_120==null){
return;
}
var func=_120;
if(typeof (_120)=="string"){
var s=_120;
s=s.replace(/\#\&lt\;\#/g,"<").replace(/\#\&gt\;\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\/\*EQ\*\//g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&");
s=s.replace(/eventArgs/g,"arguments[0]");
_120=nitobi.lang.close(_121,function(){
eval(s);
});
}
if(typeof _121=="object"&&_120 instanceof Function){
func=nitobi.lang.close(_121,_120);
}
guid=guid||func.observer_guid||_120.observer_guid||this.guid++;
func.observer_guid=guid;
_120.observer_guid=guid;
this.handlers[guid]=func;
return guid;
};
nitobi.base.Event.prototype.subscribeOnce=function(_125,_126){
var guid=null;
var _128=this;
var _129=function(){
_125.apply(_126||null,arguments);
_128.unSubscribe(guid);
};
guid=this.subscribe(_129);
return guid;
};
nitobi.base.Event.prototype.unSubscribe=function(guid){
if(guid instanceof Function){
guid=guid.observer_guid;
}
this.handlers[guid]=null;
delete this.handlers[guid];
};
nitobi.base.Event.prototype.notify=function(_12b){
if(this.enabled){
if(arguments.length==0){
arguments=new Array();
arguments[0]=new nitobi.base.EventArgs(null,this);
arguments[0].event=this;
arguments[0].source=null;
}else{
if(typeof (arguments[0].event)!="undefined"&&arguments[0].event==null){
arguments[0].event=this;
}
}
var fail=false;
for(var item in this.handlers){
var _12e=this.handlers[item];
if(_12e instanceof Function){
var rv=(_12e.apply(this,arguments)==false);
fail=fail||rv;
}
}
return !fail;
}
return true;
};
nitobi.base.Event.prototype.dispose=function(){
for(var _130 in this.handlers){
this.handlers[_130]=null;
}
this.handlers={};
};
nitobi.base.Event.prototype.setEnabled=function(_131){
this.enabled=_131;
};
nitobi.base.Event.prototype.isEnabled=function(){
return this.enabled;
};
nitobi.lang.defineNs("nitobi.html");
nitobi.html.Css=function(){
};
nitobi.html.Css.onPrecached=new nitobi.base.Event();
nitobi.html.Css.swapClass=function(_132,_133,_134){
if(_132.className){
var reg=new RegExp("(\\s|^)"+_133+"(\\s|$)");
_132.className=_132.className.replace(reg,"$1"+_134+"$2");
}
};
nitobi.html.Css.replaceOrAppend=function(_136,_137,_138){
if(nitobi.html.Css.hasClass(_136,_137)){
nitobi.html.Css.swapClass(_136,_137,_138);
}else{
nitobi.html.Css.addClass(_136,_138);
}
};
nitobi.html.Css.hasClass=function(_139,_13a){
if(!_13a||_13a===""){
return false;
}
return (new RegExp("(\\s|^)"+_13a+"(\\s|$)")).test(_139.className);
};
nitobi.html.Css.addClass=function(_13b,_13c,_13d){
if(_13d==true||!nitobi.html.Css.hasClass(_13b,_13c)){
_13b.className=_13b.className?_13b.className+" "+_13c:_13c;
}
};
nitobi.html.Css.removeClass=function(_13e,_13f,_140){
if(typeof _13f=="array"){
for(var i=0;i<_13f.length;i++){
this.removeClass(_13e,_13f[i],_140);
}
}
if(_140==true||nitobi.html.Css.hasClass(_13e,_13f)){
var reg=new RegExp("(\\s|^)"+_13f+"(\\s|$)");
_13e.className=_13e.className.replace(reg,"$2");
}
};
nitobi.html.Css.addRule=function(_143,_144,_145){
if(_143.cssRules){
var _146=_143.insertRule(_144+"{"+(_145||"")+"}",_143.cssRules.length);
return _143.cssRules[_146];
}else{
_143.addRule(_144,_145||"nitobi:placeholder;");
return _143.rules[_143.rules.length-1];
}
};
nitobi.html.Css.getRules=function(_147){
var _148=null;
if(typeof (_147)=="number"){
_148=document.styleSheets[_147];
}else{
_148=_147;
}
if(_148==null){
return null;
}
try{
if(_148.cssRules){
return _148.cssRules;
}
if(_148.rules){
return _148.rules;
}
}
catch(e){
}
return null;
};
nitobi.html.Css.getStyleSheetsByName=function(_149){
var arr=new Array();
var ss=document.styleSheets;
var _14c=new RegExp(_149.replace(".",".")+"($|\\?)");
for(var i=0;i<ss.length;i++){
arr=nitobi.html.Css._getStyleSheetsByName(_14c,ss[i],arr);
}
return arr;
};
nitobi.html.Css._getStyleSheetsByName=function(_14e,_14f,arr){
if(_14e.test(_14f.href)){
arr=arr.concat([_14f]);
}
var _151=nitobi.html.Css.getRules(_14f);
if(_14f.href!=""&&_14f.imports){
for(var i=0;i<_14f.imports.length;i++){
arr=nitobi.html.Css._getStyleSheetsByName(_14e,_14f.imports[i],arr);
}
}else{
for(var i=0;i<_151.length;i++){
var s=_151[i].styleSheet;
if(s){
arr=nitobi.html.Css._getStyleSheetsByName(_14e,s,arr);
}
}
}
return arr;
};
nitobi.html.Css.imageCache={};
nitobi.html.Css.imageCacheDidNotify=false;
nitobi.html.Css.trackPrecache=function(_154){
nitobi.html.Css.precacheArray[_154]=true;
var _155=false;
for(var i in nitobi.html.Css.precacheArray){
if(!nitobi.html.Css.precacheArray[i]){
_155=true;
}
}
if((!nitobi.html.Css.imageCacheDidNotify)&&(!_155)){
nitobi.html.Css.imageCacheDidNotify=true;
nitobi.html.Css.isPrecaching=false;
nitobi.html.Css.onPrecached.notify();
}
};
nitobi.html.Css.precacheArray={};
nitobi.html.Css.isPrecaching=false;
nitobi.html.Css.precacheImages=function(_157){
nitobi.html.Css.isPrecaching=true;
if(!_157){
var ss=document.styleSheets;
for(var i=0;i<ss.length;i++){
nitobi.html.Css.precacheImages(ss[i]);
}
return;
}
var _15a=/.*?url\((.*?)\).*?/;
var _15b=nitobi.html.Css.getRules(_157);
var url=nitobi.html.Css.getPath(_157);
for(var i=0;i<_15b.length;i++){
var rule=_15b[i];
if(rule.styleSheet){
nitobi.html.Css.precacheImages(rule.styleSheet);
}else{
var s=rule.style;
var _15f=s?s.backgroundImage:null;
if(_15f){
_15f=_15f.replace(_15a,"$1");
_15f=nitobi.html.Url.normalize(url,_15f);
if(!nitobi.html.Css.imageCache[_15f]){
var _160=new Image();
_160.src=_15f;
nitobi.html.Css.precacheArray[_15f]=false;
var _161=nitobi.lang.close({},nitobi.html.Css.trackPrecache,[_15f]);
_160.onload=_161;
_160.onerror=_161;
_160.onabort=_161;
nitobi.html.Css.imageCache[_15f]=_160;
try{
if(_160.width>0){
nitobi.html.Css.precacheArray[_15f]=true;
}
}
catch(e){
}
}
}
}
}
if(_157.href!=""&&_157.imports){
for(var i=0;i<_157.imports.length;i++){
nitobi.html.Css.precacheImages(_157.imports[i]);
}
}
};
nitobi.html.Css.getPath=function(_162){
var href=_162.href;
href=nitobi.html.Url.normalize(href);
if(_162.parentStyleSheet&&href.indexOf("/")!=0&&href.indexOf("http://")!=0&&href.indexOf("https://")!=0){
href=nitobi.html.Css.getPath(_162.parentStyleSheet)+href;
}
return href;
};
nitobi.html.Css.getSheetUrl=nitobi.html.Css.getPath;
nitobi.html.Css.findParentStylesheet=function(_164){
var rule=nitobi.html.Css.getRule(_164);
if(rule){
return rule.parentStyleSheet;
}
return null;
};
nitobi.html.Css.findInSheet=function(_166,_167,_168){
if(nitobi.browser.IE6&&typeof _168=="undefined"){
_168=0;
}else{
if(_168>4){
return null;
}
}
_168++;
var _169=nitobi.html.Css.getRules(_167);
for(var rule=0;rule<_169.length;rule++){
var _16b=_169[rule];
var ss=_16b.styleSheet;
var _16d=_16b.selectorText;
if(ss){
var _16e=nitobi.html.Css.findInSheet(_166,ss,_168);
if(_16e){
return _16e;
}
}else{
if(_16d!=null){
var _16f=_16d.split(",");
for(var _170=0;_170<_16f.length;_170++){
if(_16f[_170].toLowerCase().replace(/^\s+|\s+$/g,"").substring(0,_166.length)==_166){
if(nitobi.browser.IE){
_16b={selectorText:_16d,style:_16b.style,readOnly:_16b.readOnly,parentStyleSheet:_167};
}
return _16b;
}
}
}
}
}
var _171=_167.imports;
if(_167.href!=""&&_171){
var _172=_171.length;
for(var i=0;i<_172;i++){
var _16e=nitobi.html.Css.findInSheet(_166,_171[i],_168);
if(_16e){
return _16e;
}
}
}
return null;
};
nitobi.html.Css.getClass=function(_174,_175){
_174=_174.toLowerCase();
if(_174.indexOf(".")!==0){
_174="."+_174;
}
if(_175){
var rule=nitobi.html.Css.getRule(_174);
if(rule!=null){
return rule.style;
}
}else{
if(nitobi.html.Css.classCache[_174]==null){
var rule=nitobi.html.Css.getRule(_174);
if(rule!=null){
nitobi.html.Css.classCache[_174]=rule.style;
}else{
return null;
}
}
return nitobi.html.Css.classCache[_174];
}
};
nitobi.html.Css.classCache={};
nitobi.html.Css.getStyleBySelector=function(_177){
var rule=nitobi.html.Css.getRule(_177);
if(rule!=null){
return rule.style;
}
return null;
};
nitobi.html.Css.getRule=function(_179){
_179=_179.toLowerCase();
if(_179.indexOf(".")!==0){
_179="."+_179;
}
var _17a=document.styleSheets;
for(var ss=0;ss<_17a.length;ss++){
try{
var _17c=nitobi.html.Css.findInSheet(_179,_17a[ss]);
if(_17c){
return _17c;
}
}
catch(err){
}
}
return null;
};
nitobi.html.Css.getClassStyle=function(_17d,_17e){
var _17f=nitobi.html.Css.getClass(_17d);
if(_17f!=null){
return _17f[_17e];
}else{
return null;
}
};
nitobi.html.Css.setStyle=function(el,rule,_182){
rule=rule.replace(/\-(\w)/g,function(_183,p1){
return p1.toUpperCase();
});
el.style[rule]=_182;
};
nitobi.html.Css.getStyle=function(oElm,_186){
var _187="";
if(document.defaultView&&document.defaultView.getComputedStyle){
_186=_186.replace(/([A-Z])/g,function($1){
return "-"+$1.toLowerCase();
});
strStyle=document.defaultView.getComputedStyle(oElm,null);
_187=strStyle.getPropertyValue(_186);
}else{
if(oElm.currentStyle){
_186=_186.replace(/\-(\w)/g,function(_189,p1){
return p1.toUpperCase();
});
_187=oElm.currentStyle[_186];
}
}
return _187;
};
nitobi.html.Css.setOpacities=function(_18b,_18c){
if(_18b.length){
for(var i=0;i<_18b.length;i++){
nitobi.html.Css.setOpacity(_18b[i],_18c);
}
}else{
nitobi.html.Css.setOpacity(_18b,_18c);
}
};
nitobi.html.Css.setOpacity=function(_18e,_18f){
var s=_18e.style;
if(_18f>100){
_18f=100;
}
if(_18f<0){
_18f=0;
}
if(s.filter!=null){
var _191=s.filter.match(/alpha\(opacity=[\d\.]*?\)/ig);
if(_191!=null&&_191.length>0){
s.filter=s.filter.replace(/alpha\(opacity=[\d\.]*?\)/ig,"alpha(opacity="+_18f+")");
}else{
s.filter+="alpha(opacity="+_18f+")";
}
}else{
s.opacity=(_18f/100);
}
};
nitobi.html.Css.getOpacity=function(_192){
if(_192==null){
nitobi.lang.throwError(nitobi.error.ArgExpected+" for nitobi.html.Css.getOpacity");
}
if(nitobi.browser.IE){
if(_192.style.filter==""){
return 100;
}
var s=_192.style.filter;
s.match(/opacity=([\d\.]*?)\)/ig);
if(RegExp.$1==""){
return 100;
}
return parseInt(RegExp.$1);
}else{
return Math.abs(_192.style.opacity?_192.style.opacity*100:100);
}
};
nitobi.html.Css.getCustomStyle=function(_194,_195){
if(nitobi.browser.IE){
return nitobi.html.getClassStyle(_194,_195);
}else{
var rule=nitobi.html.Css.getRule(_194);
var re=new RegExp("(.*?)({)(.*?)(})","gi");
var _198=rule.cssText.match(re);
re=new RegExp("("+_195+")(:)(.*?)(;)","gi");
_198=re.exec(RegExp.$3);
}
};
nitobi.html.Css.createStyleSheet=function(_199){
var ss;
if(nitobi.browser.IE){
ss=document.createStyleSheet();
}else{
ss=document.createElement("style");
ss.setAttribute("type","text/css");
document.body.appendChild(ss);
ss.appendChild(document.createTextNode(""));
}
if(_199!=null){
nitobi.html.Css.setStyleSheetValue(ss,_199);
}
return ss;
};
nitobi.html.Css.setStyleSheetValue=function(ss,_19c){
if(nitobi.browser.IE){
ss.cssText=_19c;
}else{
ss.replaceChild(document.createTextNode(_19c),ss.firstChild);
}
return ss;
};
if(nitobi.browser.MOZ){
HTMLStyleElement.prototype.__defineSetter__("cssText",function(_19d){
this.innerHTML=_19d;
});
HTMLStyleElement.prototype.__defineGetter__("cssText",function(){
return this.innerHTML;
});
}
nitobi.lang.defineNs("nitobi.drawing");
if(false){
nitobi.drawing=function(){
};
}
nitobi.drawing.Point=function(x,y){
this.x=x;
this.y=y;
};
nitobi.drawing.Point.prototype.toString=function(){
return "("+this.x+","+this.y+")";
};
nitobi.drawing.rgb=function(r,g,b){
return "#"+((r*65536)+(g*256)+b).toString(16);
};
nitobi.drawing.align=function(_1a3,_1a4,_1a5,oh,ow,oy,ox){
oh=oh||0;
ow=ow||0;
oy=oy||0;
ox=ox||0;
var a=_1a5;
var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;
if(true){
td=_1a4.getBoundingClientRect();
sd=_1a3.getBoundingClientRect();
tt=td.top;
tb=td.bottom;
tl=td.left;
tr=td.right;
th=Math.abs(tb-tt);
tw=Math.abs(tr-tl);
st=sd.top;
sb=sd.bottom;
sl=sd.left;
sr=sd.right;
sh=Math.abs(sb-st);
sw=Math.abs(sr-sl);
}
var s=_1a3.style;
if(a&268435456){
s.height=(th+oh)+"px";
}
if(a&16777216){
s.width=(tw+ow)+"px";
}
if(a&1048576){
s.top=(nitobi.html.getStyleTop(_1a3)+tt-st+oy)+"px";
}
if(a&65536){
s.top=(nitobi.html.getStyleTop(_1a3)+tt-st+th-sh+oy)+"px";
}
if(a&4096){
s.left=(nitobi.html.getStyleLeft(_1a3)-sl+tl+ox)+"px";
}
if(a&256){
s.left=(nitobi.html.getStyleLeft(_1a3)-sl+tl+tw-sw+ox)+"px";
}
if(a&16){
s.top=(nitobi.html.getStyleTop(_1a3)+tt-st+oy+Math.floor((th-sh)/2))+"px";
}
if(a&1){
s.left=(nitobi.html.getStyleLeft(_1a3)-sl+tl+ox+Math.floor((tw-sw)/2))+"px";
}
};
nitobi.drawing.align.SAMEHEIGHT=268435456;
nitobi.drawing.align.SAMEWIDTH=16777216;
nitobi.drawing.align.ALIGNTOP=1048576;
nitobi.drawing.align.ALIGNBOTTOM=65536;
nitobi.drawing.align.ALIGNLEFT=4096;
nitobi.drawing.align.ALIGNRIGHT=256;
nitobi.drawing.align.ALIGNMIDDLEVERT=16;
nitobi.drawing.align.ALIGNMIDDLEHORIZ=1;
nitobi.drawing.alignOuterBox=function(_1ba,_1bb,_1bc,oh,ow,oy,ox,show){
oh=oh||0;
ow=ow||0;
oy=oy||0;
ox=ox||0;
nitobi.drawing.align(_1ba,_1bb,_1bc,oh,ow,oy,ox,show);
};
nitobi.lang.defineNs("nitobi.html");
if(false){
nitobi.html=function(){
};
}
nitobi.html.createElement=function(_1c2,_1c3,_1c4){
var elem=document.createElement(_1c2);
for(var attr in _1c3){
if(attr.toLowerCase().substring(0,5)=="class"){
elem.className=_1c3[attr];
}else{
elem.setAttribute(attr,_1c3[attr]);
}
}
for(var _1c7 in _1c4){
elem.style[_1c7]=_1c4[_1c7];
}
return elem;
};
nitobi.html.createTable=function(_1c8,_1c9){
var _1ca=nitobi.html.createElement("table",_1c8,_1c9);
var _1cb=document.createElement("tbody");
var _1cc=document.createElement("tr");
var _1cd=document.createElement("td");
_1ca.appendChild(_1cb);
_1cb.appendChild(_1cc);
_1cc.appendChild(_1cd);
return _1ca;
};
nitobi.html.setBgImage=function(elem,src){
var s=nitobi.html.Css.getStyle(elem,"background-image");
if(s!=""&&nitobi.browser.IE){
s=s.replace(/(^url\(")(.*?)("\))/,"$2");
}
};
nitobi.html.fitWidth=function(_1d1,_1d2){
var w;
var C=nitobi.html.Css;
if(nitobi.browser.IE&&!nitobi.lang.isStandards()){
var _1d5=(parseInt(C.getStyle(_1d1,"width"))-parseInt(C.getStyle(_1d1,"paddingLeft"))-parseInt(C.getStyle(_1d1,"paddingRight"))-parseInt(C.getStyle(_1d1,"borderLeftWidth"))-parseInt(C.getStyle(_1d1,"borderRightWidth")));
if(_1d5<0){
_1d5=0;
}
w=_1d5+"px";
}else{
if(nitobi.lang.isStandards()){
if(nitobi.browser.IE){
var _1d5=(parseInt(_1d1.clientWidth))-(_1d2.offsetWidth-_1d2.clientWidth);
}else{
var _1d5=(parseInt(_1d1.style.width)-(_1d2.offsetWidth-parseInt(_1d1.style.width)));
}
if(_1d5<0){
_1d5=0;
}
w=_1d5+"px";
}else{
w=parseInt(_1d1.style.width)+"px";
}
}
_1d2.style.width=w;
};
nitobi.html.getDomNodeByPath=function(Node,Path){
if(nitobi.browser.IE){
}
var _1d8=Node;
var _1d9=Path.split("/");
var len=_1d9.length;
for(var i=0;i<len;i++){
if(_1d8.childNodes[Number(_1d9[i])]!=null){
_1d8=_1d8.childNodes[Number(_1d9[i])];
}else{
alert("Path expression failed."+Path);
}
var s="";
}
return _1d8;
};
nitobi.html.indexOfChildNode=function(_1dd,_1de){
var _1df=_1dd.childNodes;
for(var i=0;i<_1df.length;i++){
if(_1df[i]==_1de){
return i;
}
}
return -1;
};
nitobi.html.evalScriptBlocks=function(node){
for(var i=0;i<node.childNodes.length;i++){
var _1e3=node.childNodes[i];
if(_1e3.nodeName.toLowerCase()=="script"){
eval(_1e3.text);
}else{
nitobi.html.evalScriptBlocks(_1e3);
}
}
};
nitobi.html.position=function(node){
var pos=nitobi.html.getStyle($ntb(node),"position");
if(pos=="static"){
node.style.position="relative";
}
};
nitobi.html.setOpacity=function(_1e6,_1e7){
var _1e8=_1e6.style;
_1e8.opacity=(_1e7/100);
_1e8.MozOpacity=(_1e7/100);
_1e8.KhtmlOpacity=(_1e7/100);
_1e8.filter="alpha(opacity="+_1e7+")";
};
nitobi.html.highlight=function(o,x,end){
end=end||o.value.length;
if(o.createTextRange){
o.focus();
var r=o.createTextRange();
r.move("character",0-end);
r.move("character",x);
r.moveEnd("textedit",1);
r.select();
}else{
if(o.setSelectionRange){
o.focus();
o.setSelectionRange(x,end);
}
}
};
nitobi.html.setCursor=function(o,x){
if(o.createTextRange){
o.focus();
var r=o.createTextRange();
r.move("character",0-o.value.length);
r.move("character",x);
r.select();
}else{
if(o.setSelectionRange){
o.setSelectionRange(x,x);
}
}
};
nitobi.html.getCursor=function(o){
if(o.createTextRange){
o.focus();
var r=document.selection.createRange().duplicate();
r.moveEnd("textedit",1);
return o.value.length-r.text.length;
}else{
if(o.setSelectionRange){
return o.selectionStart;
}
}
return -1;
};
nitobi.html.encode=function(str){
str+="";
str=str.replace(/&/g,"&amp;");
str=str.replace(/\"/g,"&quot;");
str=str.replace(/'/g,"&apos;");
str=str.replace(/</g,"&lt;");
str=str.replace(/>/g,"&gt;");
str=str.replace(/\n/g,"<br>");
return str;
};
nitobi.html.getElement=function(_1f3){
if(typeof (_1f3)=="string"){
return document.getElementById(_1f3);
}
return _1f3;
};
if(typeof ($)=="undefined"){
$=nitobi.html.getElement;
}
if(typeof ($ntb)=="undefined"){
$ntb=nitobi.html.getElement;
}
if(typeof ($F)=="undefined"){
$F=function(id){
var _1f5=$ntb(id);
if(_1f5!=null){
return _1f5.value;
}
return "";
};
}
nitobi.html.getTagName=function(elem){
if(nitobi.browser.IE&&elem.scopeName!=""){
return (elem.scopeName+":"+elem.nodeName).toLowerCase();
}else{
return elem.nodeName.toLowerCase();
}
};
nitobi.html.getStyleTop=function(elem){
var top=elem.style.top;
if(top==""){
top=nitobi.html.Css.getStyle(elem,"top");
}
return nitobi.lang.parseNumber(top);
};
nitobi.html.getStyleLeft=function(elem){
var left=elem.style.left;
if(left==""){
left=nitobi.html.Css.getStyle(elem,"left");
}
return nitobi.lang.parseNumber(left);
};
nitobi.html.getHeight=function(elem){
return elem.offsetHeight;
};
nitobi.html.getWidth=function(elem){
return elem.offsetWidth;
};
if(nitobi.browser.IE||nitobi.browser.MOZ){
nitobi.html.getBox=function(elem){
var _1fe=nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-top-width"));
var _1ff=nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-left-width"));
var _200=nitobi.lang.parseNumber(document.body.scrollTop)-(_1fe==0?2:_1fe);
var _201=nitobi.lang.parseNumber(document.body.scrollLeft)-(_1ff==0?2:_1ff);
var rect=nitobi.html.getBoundingClientRect(elem);
return {top:rect.top+_200,left:rect.left+_201,bottom:rect.bottom,right:rect.right,height:rect.bottom-rect.top,width:rect.right-rect.left};
};
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
nitobi.html.getBox=function(elem){
var _204=nitobi.html.getCoords(elem);
return {top:_204.y,left:_204.x,bottom:_204.y+_204.height,right:_204.x+_204.width,height:_204.height,width:_204.width};
};
}
}
nitobi.html.getBox2=nitobi.html.getBox;
nitobi.html.getUniqueId=function(elem){
if(elem.uniqueID){
return elem.uniqueID;
}else{
var t=(new Date()).getTime();
elem.uniqueID=t;
return t;
}
};
nitobi.html.getChildNodeById=function(elem,_208,_209){
return nitobi.html.getChildNodeByAttribute(elem,"id",_208,_209);
};
nitobi.html.getChildNodeByAttribute=function(elem,_20b,_20c,_20d){
for(var i=0;i<elem.childNodes.length;i++){
if(elem.nodeType!=3&&Boolean(elem.childNodes[i].getAttribute)){
if(elem.childNodes[i].getAttribute(_20b)==_20c){
return elem.childNodes[i];
}
}
}
if(_20d){
for(var i=0;i<elem.childNodes.length;i++){
var _20f=nitobi.html.getChildNodeByAttribute(elem.childNodes[i],_20b,_20c,_20d);
if(_20f!=null){
return _20f;
}
}
}
return null;
};
nitobi.html.getParentNodeById=function(elem,_211){
return nitobi.html.getParentNodeByAtt(elem,"id",_211);
};
nitobi.html.getParentNodeByAtt=function(elem,att,_214){
while(elem.parentNode!=null){
if(elem.parentNode.getAttribute(att)==_214){
return elem.parentNode;
}
elem=elem.parentNode;
}
return null;
};
if(nitobi.browser.IE){
nitobi.html.getFirstChild=function(node){
return node.firstChild;
};
}else{
nitobi.html.getFirstChild=function(node){
var i=0;
while(i<node.childNodes.length&&node.childNodes[i].nodeType==3){
i++;
}
return node.childNodes[i];
};
}
nitobi.html.getScroll=function(){
var _218,_219=0;
if((nitobi.browser.OPERA==false)&&(document.documentElement.scrollTop>0)){
_218=document.documentElement.scrollTop;
_219=document.documentElement.scrollLeft;
}else{
_218=document.body.scrollTop;
_219=document.body.scrollLeft;
}
if(((_218==0)&&(document.documentElement.scrollTop>0))||((_219==0)&&(document.documentElement.scrollLeft>0))){
_218=document.documentElement.scrollTop;
_219=document.documentElement.scrollLeft;
}
return {"left":_219,"top":_218};
};
nitobi.html.getCoords=function(_21a){
var ew,eh;
try{
var _21d=_21a;
ew=_21a.offsetWidth;
eh=_21a.offsetHeight;
for(var lx=0,ly=0;_21a!=null;lx+=_21a.offsetLeft,ly+=_21a.offsetTop,_21a=_21a.offsetParent){
}
for(;_21d!=document.body;lx-=_21d.scrollLeft,ly-=_21d.scrollTop,_21d=_21d.parentNode){
}
}
catch(e){
}
return {"x":lx,"y":ly,"height":eh,"width":ew};
};
nitobi.html.scrollBarWidth=0;
nitobi.html.getScrollBarWidth=function(_220){
if(nitobi.html.scrollBarWidth){
return nitobi.html.scrollBarWidth;
}
try{
if(null==_220){
var _221="ntb-scrollbar-width";
var d=document.getElementById(_221);
if(null==d){
d=nitobi.html.createElement("div",{"id":_221},{width:"100px",height:"100px",overflow:"auto",position:"absolute",top:"-200px",left:"-5000px"});
d.innerHTML="<div style='height:200px;'></div>";
document.body.appendChild(d);
}
_220=d;
}
if(nitobi.browser.IE||nitobi.browser.MOZ){
nitobi.html.scrollBarWidth=Math.abs(_220.offsetWidth-_220.clientWidth-(_220.clientLeft?_220.clientLeft*2:0));
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
var b=nitobi.html.getBox(_220);
nitobi.html.scrollBarWidth=Math.abs((b.width-_220.clientWidth));
}
}
}
catch(err){
}
return nitobi.html.scrollBarWidth;
};
nitobi.html.align=nitobi.drawing.align;
nitobi.html.emptyElements={HR:true,BR:true,IMG:true,INPUT:true};
nitobi.html.specialElements={TEXTAREA:true};
nitobi.html.permHeight=0;
nitobi.html.permWidth=0;
nitobi.html.getBodyArea=function(){
var _224,_225,_226,_227;
var x,y;
var _22a=false;
if(nitobi.lang.isStandards()){
_22a=true;
}
var de=document.documentElement;
var db=document.body;
if(self.innerHeight){
x=self.innerWidth;
y=self.innerHeight;
}else{
if(de&&de.clientHeight){
x=de.clientWidth;
y=de.clientHeight;
}else{
if(db){
x=db.clientWidth;
y=db.clientHeight;
}
}
}
_226=x;
_227=y;
if(self.pageYOffset){
x=self.pageXOffset;
y=self.pageYOffset;
}else{
if(de&&de.scrollTop){
x=de.scrollLeft;
y=de.scrollTop;
}else{
if(db){
x=db.scrollLeft;
y=db.scrollTop;
}
}
}
_224=x;
_225=y;
var _22d=db.scrollHeight;
var _22e=db.offsetHeight;
if(_22d>_22e){
x=db.scrollWidth;
y=db.scrollHeight;
}else{
x=db.offsetWidth;
y=db.offsetHeight;
}
nitobi.html.permHeight=y;
nitobi.html.permWidth=x;
if(nitobi.html.permHeight<_227){
nitobi.html.permHeight=_227;
if(nitobi.browser.IE&&_22a){
_226+=20;
}
}
if(_226<nitobi.html.permWidth){
_226=nitobi.html.permWidth;
}
if(nitobi.html.permHeight>_227){
_226+=20;
}
var _22f,_230;
_22f=de.scrollHeight;
_230=de.scrollWidth;
return {scrollWidth:_230,scrollHeight:_22f,scrollLeft:_224,scrollTop:_225,clientWidth:_226,clientHeight:_227,bodyWidth:nitobi.html.permWidth,bodyHeight:nitobi.html.PermHeight};
};
nitobi.html.getOuterHtml=function(node){
if(nitobi.browser.IE){
return node.outerHTML;
}else{
var html="";
switch(node.nodeType){
case Node.ELEMENT_NODE:
html+="<";
html+=node.nodeName.toLowerCase();
if(!nitobi.html.specialElements[node.nodeName]){
for(var a=0;a<node.attributes.length;a++){
if(node.attributes[a].nodeName.toLowerCase()!="_moz-userdefined"){
html+=" "+node.attributes[a].nodeName.toLowerCase()+"=\""+node.attributes[a].nodeValue+"\"";
}
}
html+=">";
if(!nitobi.html.emptyElements[node.nodeName]){
html+=node.innerHTML;
html+="</"+node.nodeName.toLowerCase()+">";
}
}else{
switch(node.nodeName){
case "TEXTAREA":
for(var a=0;a<node.attributes.length;a++){
if(node.attributes[a].nodeName.toLowerCase()!="value"){
html+=" "+node.attributes[a].nodeName.toUpperCase()+"=\""+node.attributes[a].nodeValue+"\"";
}else{
var _234=node.attributes[a].nodeValue;
}
}
html+=">";
html+=_234;
html+="</"+node.nodeName+">";
break;
}
}
break;
case Node.TEXT_NODE:
html+=node.nodeValue;
break;
case Node.COMMENT_NODE:
html+="<!"+"--"+node.nodeValue+"--"+">";
break;
}
return html;
}
};
nitobi.html.insertAdjacentText=function(_235,pos,s){
if(nitobi.browser.IE){
return _235.insertAdjacentText(pos,s);
}
var node=document.createTextNode(s);
nitobi.html.insertAdjacentElement(_235,pos,node);
};
nitobi.html.insertAdjacentHTML=function(_239,_23a,_23b,_23c){
if(nitobi.browser.IE){
return _239.insertAdjacentHTML(_23a,_23b,_23c);
}
var df;
var r=_239.ownerDocument.createRange();
switch(String(_23a).toLowerCase()){
case "beforebegin":
r.setStartBefore(_239);
df=r.createContextualFragment(_23b);
_239.parentNode.insertBefore(df,_239);
break;
case "afterbegin":
r.selectNodeContents(_239);
r.collapse(true);
df=r.createContextualFragment(_23b);
_239.insertBefore(df,_239.firstChild);
break;
case "beforeend":
if(_23c==true){
_239.innerHTML=_239.innerHTML+_23b;
}else{
r.selectNodeContents(_239);
r.collapse(false);
df=r.createContextualFragment(_23b);
_239.appendChild(df);
}
break;
case "afterend":
r.setStartAfter(_239);
df=r.createContextualFragment(_23b);
_239.parentNode.insertBefore(df,_239.nextSibling);
break;
}
};
nitobi.html.insertAdjacentElement=function(_23f,pos,node){
if(nitobi.browser.IE){
return _23f.insertAdjacentElement(pos,node);
}
switch(pos){
case "beforeBegin":
_23f.parentNode.insertBefore(node,_23f);
break;
case "afterBegin":
_23f.insertBefore(node,_23f.firstChild);
break;
case "beforeEnd":
_23f.appendChild(node);
break;
case "afterEnd":
if(_23f.nextSibling){
_23f.parentNode.insertBefore(node,_23f.nextSibling);
}else{
_23f.parentNode.appendChild(node);
}
break;
}
};
nitobi.html.getClientRects=function(node,_243,_244){
if(nitobi.browser.IE||nitobi.browser.MOZ){
return node.getClientRects();
}
_243=_243||0;
_244=_244||0;
var td;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
td=nitobi.html.getCoords(node);
_243=0;
_244=0;
}else{
var td=document.getBoxObjectFor(node);
}
return new Array({top:(td.y-_243),left:(td.x-_244),bottom:(td.y+td.height-_243),right:(td.x+td.width-_244)});
};
nitobi.html.getBoundingClientRect=function(node,_247,_248){
if(node.getBoundingClientRect){
return node.getBoundingClientRect();
}
_247=_247||0;
_248=_248||0;
var td;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
td=nitobi.html.getCoords(node);
_247=0;
_248=0;
}else{
td=document.getBoxObjectFor(node);
}
var top=td.y-_247;
var left=td.x-_248;
return {top:top,left:left,bottom:(top+td.height),right:(left+td.width)};
};
nitobi.html.Event=function(){
this.srcElement=null;
this.fromElement=null;
this.toElement=null;
this.eventSrc=null;
};
nitobi.html.handlerId=0;
nitobi.html.elementId=0;
nitobi.html.elements=[];
nitobi.html.unload=[];
nitobi.html.unloadCalled=false;
nitobi.html.attachEvents=function(_24c,_24d,_24e){
var _24f=[];
for(var i=0;i<_24d.length;i++){
var e=_24d[i];
_24f.push(nitobi.html.attachEvent(_24c,e.type,e.handler,_24e,e.capture||false));
}
return _24f;
};
nitobi.html.attachEvent=function(_252,type,_254,_255,_256,_257){
if(type=="anyclick"){
if(nitobi.browser.IE){
nitobi.html.attachEvent(_252,"dblclick",_254,_255,_256,_257);
}
type="click";
}
if(!(_254 instanceof Function)){
nitobi.lang.throwError("Event handler needs to be a Function");
}
_252=$ntb(_252);
if(type.toLowerCase()=="unload"&&_257!=true){
var _258=_254;
if(_255!=null){
_258=function(){
_254.call(_255);
};
}
return this.addUnload(_258);
}
var _259=this.handlerId++;
var _25a=this.elementId++;
if(typeof (_254.ebaguid)!="undefined"){
_259=_254.ebaguid;
}else{
_254.ebaguid=_259;
}
if(typeof (_252.ebaguid)=="undefined"){
_252.ebaguid=_25a;
nitobi.html.elements[_25a]=_252;
}
if(typeof (_252.eba_events)=="undefined"){
_252.eba_events={};
}
if(_252.eba_events[type]==null){
_252.eba_events[type]={};
if(_252.attachEvent){
_252["eba_event_"+type]=function(){
nitobi.html.notify.call(_252,window.event);
};
_252.attachEvent("on"+type,_252["eba_event_"+type]);
if(_256&&_252.setCapture!=null){
_252.setCapture(true);
}
}else{
if(_252.addEventListener){
_252["eba_event_"+type]=function(){
nitobi.html.notify.call(_252,arguments[0]);
};
_252.addEventListener(type,_252["eba_event_"+type],_256);
}
}
}
_252.eba_events[type][_259]={handler:_254,context:_255};
return _259;
};
nitobi.html.notify=function(e){
if(!nitobi.browser.IE){
e.srcElement=e.target;
e.fromElement=e.relatedTarget;
e.toElement=e.relatedTarget;
}
var _25c=this;
e.eventSrc=_25c;
nitobi.html.Event=e;
for(var _25d in _25c.eba_events[e.type]){
var _25e=_25c.eba_events[e.type][_25d];
if(typeof (_25e.context)=="object"){
_25e.handler.call(_25e.context,e,_25c);
}else{
_25e.handler.call(_25c,e,_25c);
}
}
};
nitobi.html.detachEvents=function(_25f,_260){
for(var i=0;i<_260.length;i++){
var e=_260[i];
nitobi.html.detachEvent(_25f,e.type,e.handler);
}
};
nitobi.html.detachEvent=function(_263,type,_265){
_263=$ntb(_263);
var _266=_265;
if(_265 instanceof Function){
_266=_265.ebaguid;
}
if(type=="unload"){
this.unload.splice(ebaguid,1);
}
if(_263!=null&&_263.eba_events!=null&&_263.eba_events[type]!=null&&_263.eba_events[type][_266]!=null){
var _267=_263.eba_events[type];
_267[_266]=null;
delete _267[_266];
if(nitobi.collections.isHashEmpty(_267)){
this.m_detach(_263,type,_263["eba_event_"+type]);
_263["eba_event_"+type]=null;
_263.eba_events[type]=null;
_267=null;
if(_263.nodeType==1){
_263.removeAttribute("eba_event_"+type);
}
}
}
return true;
};
nitobi.html.m_detach=function(_268,type,_26a){
if(_26a!=null&&_26a instanceof Function){
if(_268.detachEvent){
_268.detachEvent("on"+type,_26a);
}else{
if(_268.removeEventListener){
_268.removeEventListener(type,_26a,false);
}
}
_268["on"+type]=null;
if(type=="unload"){
for(var i=0;i<this.unload.length;i++){
this.unload[i].call(this);
this.unload[i]=null;
}
}
}
};
nitobi.html.detachAllEvents=function(evt){
for(var i=0;i<nitobi.html.elements.length;i++){
if(typeof (nitobi.html.elements[i])!="undefined"){
for(var _26e in nitobi.html.elements[i].eba_events){
nitobi.html.m_detach(nitobi.html.elements[i],_26e,nitobi.html.elements[i]["eba_event_"+_26e]);
if(typeof (nitobi.html.elements[i])!="undefined"&&nitobi.html.elements[i].eba_events[_26e]!=null){
for(var _26f in nitobi.html.elements[i].eba_events[_26e]){
nitobi.html.elements[i].eba_events[_26e][_26f]=null;
}
}
nitobi.html.elements[i]["eba_event_"+_26e]=null;
}
}
}
nitobi.html.elements=null;
};
nitobi.html.addUnload=function(_270){
this.unload.push(_270);
return this.unload.length-1;
};
nitobi.html.cancelEvent=function(evt){
nitobi.html.stopPropagation(evt);
nitobi.html.preventDefault(evt);
};
nitobi.html.stopPropagation=function(evt){
if(evt==null){
return;
}
if(nitobi.browser.IE){
evt.cancelBubble=true;
}else{
evt.stopPropagation();
}
};
nitobi.html.preventDefault=function(evt,v){
if(evt==null){
return;
}
if(nitobi.browser.IE){
evt.returnValue=false;
}else{
evt.preventDefault();
}
if(v!=null){
e.keyCode=v;
}
};
nitobi.html.getEventCoords=function(evt){
var _276={"x":evt.clientX,"y":evt.clientY};
if(nitobi.browser.IE){
_276.x+=document.documentElement.scrollLeft+document.body.scrollLeft;
_276.y+=document.documentElement.scrollTop+document.body.scrollTop;
}else{
_276.x+=window.scrollX;
_276.y+=window.scrollY;
}
return _276;
};
nitobi.html.getEvent=function(_277){
if(nitobi.browser.IE){
return window.event;
}else{
_277.srcElement=_277.target;
_277.fromElement=_277.relatedTarget;
_277.toElement=_277.relatedTarget;
return _277;
}
};
nitobi.html.createEvent=function(_278,_279,_27a,_27b){
if(nitobi.browser.IE){
_27a.target.fireEvent("on"+_279);
}else{
var _27c=document.createEvent(_278);
_27c.initKeyEvent(_279,true,true,document.defaultView,_27a.ctrlKey,_27a.altKey,_27a.shiftKey,_27a.metaKey,_27b.keyCode,_27b.charCode);
_27a.target.dispatchEvent(_27c);
}
};
nitobi.html.unloadEventId=nitobi.html.attachEvent(window,"unload",nitobi.html.detachAllEvents,nitobi.html,false,true);
nitobi.lang.defineNs("nitobi.event");
nitobi.event=function(){
};
nitobi.event.keys={};
nitobi.event.guid=0;
nitobi.event.subscribe=function(key,_27e){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
nitobi.event.publish(key);
var guid=this.guid++;
this.keys[key].add(_27e,guid);
return guid;
};
nitobi.event.unsubscribe=function(key,guid){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
if(this.keys[key]==null){
return true;
}
if(this.keys[key].remove(guid)){
this.keys[key]=null;
delete this.keys[key];
}
};
nitobi.event.evaluate=function(func,_283){
var _284=true;
if(typeof func=="string"){
func=func.replace(/eventArgs/gi,"arguments[1]");
var _285=eval(func);
_284=(typeof (_285)=="undefined"?true:_285);
}
return _284;
};
nitobi.event.publish=function(key){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
if(this.keys[key]==null){
this.keys[key]=new nitobi.event.Key();
}
};
nitobi.event.notify=function(key,_288){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
if(this.keys[key]!=null){
return this.keys[key].notify(_288);
}else{
return true;
}
};
nitobi.event.dispose=function(){
for(var key in this.keys){
if(typeof (this.keys[key])=="function"){
this.keys[key].dispose();
}
}
this.keys=null;
};
nitobi.event.Key=function(){
this.handlers={};
};
nitobi.event.Key.prototype.add=function(_28a,guid){
ntbAssert(_28a instanceof Function,"EventKey.add requires a JavaScript function pointer as a parameter.","",EBA_THROW);
this.handlers[guid]=_28a;
};
nitobi.event.Key.prototype.remove=function(guid){
this.handlers[guid]=null;
delete this.handlers[guid];
var i=true;
for(var item in this.handlers){
i=false;
break;
}
return i;
};
nitobi.event.Key.prototype.notify=function(_28f){
var fail=false;
for(var item in this.handlers){
var _292=this.handlers[item];
if(_292 instanceof Function){
var rv=(_292.apply(this,arguments)==false);
fail=fail||rv;
}else{
}
}
return !fail;
};
nitobi.event.Key.prototype.dispose=function(){
for(var _294 in this.handlers){
this.handlers[_294]=null;
}
};
nitobi.event.Args=function(src){
this.source=src;
};
nitobi.event.Args.prototype.callback=function(){
};
nitobi.html.cancelBubble=nitobi.html.cancelEvent;
nitobi.html.getCssRules=nitobi.html.Css.getRules;
nitobi.html.findParentStylesheet=nitobi.html.Css.findParentStylesheet;
nitobi.html.getClass=nitobi.html.Css.getClass;
nitobi.html.getStyle=nitobi.html.Css.getStyle;
nitobi.html.addClass=nitobi.html.Css.addClass;
nitobi.html.removeClass=nitobi.html.Css.removeClass;
nitobi.html.getClassStyle=nitobi.html.Css.getClassStyle;
nitobi.html.normalizeUrl=nitobi.html.Url.normalize;
nitobi.html.setUrlParameter=nitobi.html.Url.setParameter;
nitobi.lang.defineNs("nitobi.base.XmlNamespace");
nitobi.base.XmlNamespace.prefix="ntb";
nitobi.base.XmlNamespace.uri="http://www.nitobi.com";
nitobi.lang.defineNs("nitobi.collections");
if(false){
nitobi.collections=function(){
};
}
nitobi.collections.IEnumerable=function(){
this.list=new Array();
this.length=0;
};
nitobi.collections.IEnumerable.prototype.add=function(obj){
this.list[this.getLength()]=obj;
this.length++;
};
nitobi.collections.IEnumerable.prototype.insert=function(_297,obj){
this.list.splice(_297,0,obj);
this.length++;
};
nitobi.collections.IEnumerable.createNewArray=function(obj,_29a){
var _29b;
_29a=_29a||0;
if(obj.count){
_29b=obj.count;
}
if(obj.length){
_29b=obj.length;
}
var x=new Array(_29b-_29a);
for(var i=_29a;i<_29b;i++){
x[i-_29a]=obj[i];
}
return x;
};
nitobi.collections.IEnumerable.prototype.get=function(_29e){
if(_29e<0||_29e>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
return this.list[_29e];
};
nitobi.collections.IEnumerable.prototype.set=function(_29f,_2a0){
if(_29f<0||_29f>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
this.list[_29f]=_2a0;
};
nitobi.collections.IEnumerable.prototype.indexOf=function(obj){
for(var i=0;i<this.getLength();i++){
if(this.list[i]===obj){
return i;
}
}
return -1;
};
nitobi.collections.IEnumerable.prototype.remove=function(_2a3){
var i;
if(typeof (_2a3)!="number"){
i=this.indexOf(_2a3);
}else{
i=_2a3;
}
if(-1==i||i<0||i>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
this.list[i]=null;
this.list.splice(i,1);
this.length--;
};
nitobi.collections.IEnumerable.prototype.getLength=function(){
return this.length;
};
nitobi.collections.IEnumerable.prototype.each=function(func){
var l=this.length;
var list=this.list;
for(var i=0;i<l;i++){
func(list[i]);
}
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.ISerializable=function(_2a9,id,xml,_2ac){
nitobi.Object.call(this);
if(typeof (this.ISerializableInitialized)=="undefined"){
this.ISerializableInitialized=true;
}else{
return;
}
this.xmlNode=null;
this.setXmlNode(_2a9);
if(_2a9!=null){
this.profile=nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:_2a9.nodeName});
}else{
this.profile=nitobi.base.Registry.getInstance().getProfileByInstance(this);
}
this.onDeserialize=new nitobi.base.Event();
this.onSetParentObject=new nitobi.base.Event();
this.factory=nitobi.base.Factory.getInstance();
this.objectHash={};
this.onCreateObject=new nitobi.base.Event();
if(_2a9!=null){
this.deserializeFromXmlNode(this.getXmlNode());
}else{
if(this.factory!=null&&this.profile.tagName!=null){
this.createByProfile(this.profile,this.getXmlNode());
}else{
if(xml!=null&&_2a9!=null){
this.createByXml(xml);
}
}
}
this.disposal.push(this.xmlNode);
};
nitobi.lang.extend(nitobi.base.ISerializable,nitobi.Object);
nitobi.base.ISerializable.guidMap={};
nitobi.base.ISerializable.prototype.ISerializableImplemented=true;
nitobi.base.ISerializable.prototype.getProfile=function(){
return this.profile;
};
nitobi.base.ISerializable.prototype.createByProfile=function(_2ad,_2ae){
if(_2ae==null){
var xml="<"+_2ad.tagName+" xmlns:"+nitobi.base.XmlNamespace.prefix+"=\""+nitobi.base.XmlNamespace.uri+"\" />";
var _2b0=nitobi.xml.createXmlDoc(xml);
this.setXmlNode(_2b0.firstChild);
this.deserializeFromXmlNode(this.xmlNode);
}else{
this.deserializeFromXmlNode(_2ae);
this.setXmlNode(_2ae);
}
};
nitobi.base.ISerializable.prototype.createByXml=function(xml){
this.deserializeFromXml(xml);
};
nitobi.base.ISerializable.prototype.getParentObject=function(){
return this.parentObj;
};
nitobi.base.ISerializable.prototype.setParentObject=function(_2b2){
this.parentObj=_2b2;
this.onSetParentObject.notify();
};
nitobi.base.ISerializable.prototype.addChildObject=function(_2b3){
this.addToCache(_2b3);
_2b3.setParentObject(this);
var _2b4=_2b3.getXmlNode();
if(!this.areGuidsGenerated(_2b4)){
_2b4=this.generateGuids(_2b4);
_2b3.setXmlNode(_2b4);
}
_2b3.setXmlNode(this.xmlNode.appendChild(nitobi.xml.importNode(this.xmlNode.ownerDocument,_2b4,true)));
};
nitobi.base.ISerializable.prototype.insertBeforeChildObject=function(obj,_2b6){
_2b6=_2b6?_2b6.getXmlNode():null;
this.addToCache(obj);
obj.setParentObject(this);
var _2b7=obj.getXmlNode();
if(!this.areGuidsGenerated(_2b7)){
_2b7=this.generateGuids(_2b7);
obj.setXmlNode(_2b7);
}
_2b7=nitobi.xml.importNode(this.xmlNode.ownerDocument,_2b7,true);
this.xmlNode.insertBefore(_2b7,_2b6);
};
nitobi.base.ISerializable.prototype.createElement=function(name){
var _2b9;
if(this.xmlNode==null||this.xmlNode.ownerDocument==null){
_2b9=nitobi.xml.createXmlDoc();
}else{
_2b9=this.xmlNode.ownerDocument;
}
if(nitobi.browser.IE){
return _2b9.createNode(1,name,nitobi.base.XmlNamespace.uri);
}else{
if(_2b9.createElementNS){
return _2b9.createElementNS(nitobi.base.XmlNamespace.uri,name);
}else{
nitobi.lang.throwError("Unable to create a new xml node on this browser.");
}
}
};
nitobi.base.ISerializable.prototype.deleteChildObject=function(id){
this.removeFromCache(id);
var e=this.getElement(id);
if(e!=null){
e.parentNode.removeChild(e);
}
};
nitobi.base.ISerializable.prototype.addToCache=function(obj){
this.objectHash[obj.getId()]=obj;
};
nitobi.base.ISerializable.prototype.removeFromCache=function(id){
this.objectHash[id]=null;
};
nitobi.base.ISerializable.prototype.inCache=function(id){
return (this.objectHash[id]!=null);
};
nitobi.base.ISerializable.prototype.flushCache=function(){
this.objectHash={};
};
nitobi.base.ISerializable.prototype.areGuidsGenerated=function(_2bf){
if(_2bf==null||_2bf.ownerDocument==null){
return false;
}
if(nitobi.browser.IE){
var node=_2bf.ownerDocument.documentElement;
if(node==null){
return false;
}else{
var id=node.getAttribute("id");
if(id==null||id==""){
return false;
}else{
return (nitobi.base.ISerializable.guidMap[id]!=null);
}
}
}else{
return (_2bf.ownerDocument.generatedGuids==true);
}
};
nitobi.base.ISerializable.prototype.setGuidsGenerated=function(_2c2,_2c3){
if(_2c2==null||_2c2.ownerDocument==null){
return;
}
if(nitobi.browser.IE){
var node=_2c2.ownerDocument.documentElement;
if(node!=null){
var id=node.getAttribute("id");
if(id!=null&&id!=""){
nitobi.base.ISerializable.guidMap[id]=true;
}
}
}else{
_2c2.ownerDocument.generatedGuids=true;
}
};
nitobi.base.ISerializable.prototype.generateGuids=function(_2c6){
nitobi.base.uniqueIdGeneratorProc.addParameter("guid",nitobi.component.getUniqueId(),"");
var doc=nitobi.xml.transformToXml(_2c6,nitobi.base.uniqueIdGeneratorProc);
this.saveDocument=doc;
this.setGuidsGenerated(doc.documentElement,true);
return doc.documentElement;
};
nitobi.base.ISerializable.prototype.deserializeFromXmlNode=function(_2c8){
if(!this.areGuidsGenerated(_2c8)){
_2c8=this.generateGuids(_2c8);
}
this.setXmlNode(_2c8);
this.flushCache();
if(this.profile==null){
this.profile=nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:_2c8.nodeName});
}
this.onDeserialize.notify();
};
nitobi.base.ISerializable.prototype.deserializeFromXml=function(xml){
var doc=nitobi.xml.createXmlDoc(xml);
var node=this.generateGuids(doc.firstChild);
this.setXmlNode(node);
this.onDeserialize.notify();
};
nitobi.base.ISerializable.prototype.getChildObject=function(id){
var obj=null;
obj=this.objectHash[id];
if(obj==null){
var _2ce=this.getElement(id);
if(_2ce==null){
return null;
}else{
obj=this.factory.createByNode(_2ce);
this.onCreateObject.notify(obj);
this.addToCache(obj);
}
obj.setParentObject(this);
}
return obj;
};
nitobi.base.ISerializable.prototype.getChildObjectById=function(id){
return this.getChildObject(id);
};
nitobi.base.ISerializable.prototype.getElement=function(id){
try{
var node=this.xmlNode.selectSingleNode("*[@id='"+id+"']");
return node;
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected,err);
}
};
nitobi.base.ISerializable.prototype.getFactory=function(){
return this.factory;
};
nitobi.base.ISerializable.prototype.setFactory=function(_2d2){
this.factory=factory;
};
nitobi.base.ISerializable.prototype.getXmlNode=function(){
return this.xmlNode;
};
nitobi.base.ISerializable.prototype.setXmlNode=function(_2d3){
if(nitobi.lang.typeOf(_2d3)==nitobi.lang.type.XMLDOC&&_2d3!=null){
this.ownerDocument=_2d3;
_2d3=nitobi.html.getFirstChild(_2d3);
}else{
if(_2d3!=null){
this.ownerDocument=_2d3.ownerDocument;
}
}
if(_2d3!=null&&nitobi.browser.MOZ&&_2d3.ownerDocument==null){
nitobi.lang.throwError(nitobi.error.OrphanXmlNode+" ISerializable.setXmlNode");
}
this.xmlNode=_2d3;
};
nitobi.base.ISerializable.prototype.serializeToXml=function(){
return nitobi.xml.serialize(this.xmlNode);
};
nitobi.base.ISerializable.prototype.getAttribute=function(name,_2d5){
if(this[name]!=null){
return this[name];
}
var _2d6=this.xmlNode.getAttribute(name);
return _2d6===null?_2d5:_2d6;
};
nitobi.base.ISerializable.prototype.setAttribute=function(name,_2d8){
this[name]=_2d8;
this.xmlNode.setAttribute(name.toLowerCase(),_2d8!=null?_2d8.toString():"");
};
nitobi.base.ISerializable.prototype.setIntAttribute=function(name,_2da){
var n=parseInt(_2da);
if(_2da!=null&&(typeof (n)!="number"||isNaN(n))){
nitobi.lang.throwError(name+" is not an integer and therefore cannot be set. It's value was "+_2da);
}
this.setAttribute(name,_2da);
};
nitobi.base.ISerializable.prototype.getIntAttribute=function(name,_2dd){
var x=this.getAttribute(name,_2dd);
if(x==null||x==""){
return 0;
}
var tx=parseInt(x);
if(isNaN(tx)){
nitobi.lang.throwError("ISerializable attempting to get "+name+" which was supposed to be an int but was actually NaN");
}
return tx;
};
nitobi.base.ISerializable.prototype.setBoolAttribute=function(name,_2e1){
_2e1=nitobi.lang.getBool(_2e1);
if(_2e1!=null&&typeof (_2e1)!="boolean"){
nitobi.lang.throwError(name+" is not an boolean and therefore cannot be set. It's value was "+_2e1);
}
this.setAttribute(name,(_2e1?"true":"false"));
};
nitobi.base.ISerializable.prototype.getBoolAttribute=function(name,_2e3){
var x=this.getAttribute(name,_2e3);
if(typeof (x)=="string"&&x==""){
return null;
}
var tx=nitobi.lang.getBool(x);
if(tx==null){
nitobi.lang.throwError("ISerializable attempting to get "+name+" which was supposed to be a bool but was actually "+x);
}
return tx;
};
nitobi.base.ISerializable.prototype.setDateAttribute=function(name,_2e7){
this.setAttribute(name,_2e7);
};
nitobi.base.ISerializable.prototype.getDateAttribute=function(name,_2e9){
if(this[name]){
return this[name];
}
var _2ea=this.getAttribute(name,_2e9);
return _2ea?new Date(_2ea):null;
};
nitobi.base.ISerializable.prototype.getId=function(){
return this.getAttribute("id");
};
nitobi.base.ISerializable.prototype.getChildObjectId=function(_2eb,_2ec){
var _2ed=(typeof (_2eb.className)=="string"?_2eb.tagName:_2eb.getXmlNode().nodeName);
var _2ee=_2ed;
if(_2ec){
_2ee+="[@instancename='"+_2ec+"']";
}
var node=this.getXmlNode().selectSingleNode(_2ee);
if(null==node){
return null;
}else{
return node.getAttribute("id");
}
};
nitobi.base.ISerializable.prototype.setObject=function(_2f0,_2f1){
if(_2f0.ISerializableImplemented!=true){
nitobi.lang.throwError(nitobi.error.ExpectedInterfaceNotFound+" ISerializable");
}
var id=this.getChildObjectId(_2f0,_2f1);
if(null!=id){
this.deleteChildObject(id);
}
if(_2f1){
_2f0.setAttribute("instancename",_2f1);
}
this.addChildObject(_2f0);
};
nitobi.base.ISerializable.prototype.getObject=function(_2f3,_2f4){
var id=this.getChildObjectId(_2f3,_2f4);
if(null==id){
return id;
}
return this.getChildObject(id);
};
nitobi.base.ISerializable.prototype.getObjectById=function(id){
return this.getChildObject(id);
};
nitobi.base.ISerializable.prototype.isDescendantExists=function(id){
var node=this.getXmlNode();
var _2f9=node.selectSingleNode("//*[@id='"+id+"']");
return (_2f9!=null);
};
nitobi.base.ISerializable.prototype.getPathToLeaf=function(id){
var node=this.getXmlNode();
var _2fc=node.selectSingleNode("//*[@id='"+id+"']");
if(nitobi.browser.IE){
_2fc.ownerDocument.setProperty("SelectionLanguage","XPath");
}
var _2fd=_2fc.selectNodes("./ancestor-or-self::*");
var _2fe=this.getId();
var _2ff=0;
for(var i=0;i<_2fd.length;i++){
if(_2fd[i].getAttribute("id")==_2fe){
_2ff=i+1;
break;
}
}
var arr=nitobi.collections.IEnumerable.createNewArray(_2fd,_2ff);
return arr.reverse();
};
nitobi.base.ISerializable.prototype.isDescendantInstantiated=function(id){
var node=this.getXmlNode();
var _304=node.selectSingleNode("//*[@id='"+id+"']");
if(nitobi.browser.IE){
_304.ownerDocument.setProperty("SelectionLanguage","XPath");
}
var _305=_304.selectNodes("ancestor::*");
var _306=false;
var obj=this;
for(var i=0;i<_305.length;i++){
if(_306){
var _309=_305[i].getAttribute("id");
instantiated=obj.inCache(_309);
if(!instantiated){
return false;
}
obj=this.getObjectById(_309);
}
if(_305[i].getAttribute("id")==this.getId()){
_306=true;
}
}
return obj.inCache(id);
};
nitobi.lang.defineNs("nitobi.base");
if(!nitobi.base.Registry){
nitobi.base.Registry=function(){
this.classMap={};
this.tagMap={};
};
if(!nitobi.base.Registry.instance){
nitobi.base.Registry.instance=null;
}
nitobi.base.Registry.getInstance=function(){
if(nitobi.base.Registry.instance==null){
nitobi.base.Registry.instance=new nitobi.base.Registry();
}
return nitobi.base.Registry.instance;
};
nitobi.base.Registry.prototype.getProfileByClass=function(_30a){
return this.classMap[_30a];
};
nitobi.base.Registry.prototype.getProfileByInstance=function(_30b){
var _30c=nitobi.lang.getFirstFunction(_30b);
var p=_30c.value.prototype;
var _30e=null;
var _30f=0;
for(var _310 in this.classMap){
var _311=this.classMap[_310].classObject;
var _312=0;
while(_311&&_30b instanceof _311){
_311=_311.baseConstructor;
_312++;
}
if(_312>_30f){
_30f=_312;
_30e=_310;
}
}
if(_30e){
return this.getProfileByClass(_30e);
}else{
return null;
}
};
nitobi.base.Registry.prototype.getProfileByTag=function(_313){
return this.tagMap[_313];
};
nitobi.base.Registry.prototype.getCompleteProfile=function(_314){
if(nitobi.lang.isDefined(_314.className)&&_314.className!=null){
return this.classMap[_314.className];
}
if(nitobi.lang.isDefined(_314.tagName)&&_314.tagName!=null){
return this.tagMap[_314.tagName];
}
nitobi.lang.throwError("A complete class profile could not be found. Insufficient information was provided.");
};
nitobi.base.Registry.prototype.register=function(_315){
if(!nitobi.lang.isDefined(_315.tagName)||null==_315.tagName){
nitobi.lang.throwError("Illegal to register a class without a tagName.");
}
if(!nitobi.lang.isDefined(_315.className)||null==_315.className){
nitobi.lang.throwError("Illegal to register a class without a className.");
}
this.tagMap[_315.tagName]=_315;
this.classMap[_315.className]=_315;
};
}
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Factory=function(){
this.registry=nitobi.base.Registry.getInstance();
};
nitobi.lang.extend(nitobi.base.Factory,nitobi.Object);
nitobi.base.Factory.instance=null;
nitobi.base.Factory.prototype.createByClass=function(_316){
try{
return nitobi.lang.newObject(_316,arguments,1);
}
catch(err){
nitobi.lang.throwError("The Factory (createByClass) could not create the class "+_316+".",err);
}
};
nitobi.base.Factory.prototype.createByNode=function(_317){
try{
if(null==_317){
nitobi.lang.throwError(nitobi.error.ArgExpected);
}
if(nitobi.lang.typeOf(_317)==nitobi.lang.type.XMLDOC){
_317=nitobi.xml.getChildNodes(_317)[0];
}
var _318=this.registry.getProfileByTag(_317.nodeName).className;
var _319=_317.ownerDocument;
var _31a=Array.prototype.slice.call(arguments,0);
var obj=nitobi.lang.newObject(_318,_31a,0);
return obj;
}
catch(err){
nitobi.lang.throwError("The Factory (createByNode) could not create the class "+_318+".",err);
}
};
nitobi.base.Factory.prototype.createByProfile=function(_31c){
try{
return nitobi.lang.newObject(_31c.className,arguments,1);
}
catch(err){
nitobi.lang.throwError("The Factory (createByProfile) could not create the class "+_31c.className+".",err);
}
};
nitobi.base.Factory.prototype.createByTag=function(_31d){
var _31e=this.registry.getProfileByTag(_31d).className;
var _31f=Array.prototype.slice.call(arguments,0);
return nitobi.lang.newObject(_31e,_31f,1);
};
nitobi.base.Factory.getInstance=function(){
if(nitobi.base.Factory.instance==null){
nitobi.base.Factory.instance=new nitobi.base.Factory();
}
return nitobi.base.Factory.instance;
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Profile=function(_320,_321,_322,_323,_324){
this.className=_320;
this.classObject=eval(_320);
this.schema=_321;
this.singleton=_322;
this.tagName=_323;
this.idField=_324||"id";
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Declaration=function(){
nitobi.base.Declaration.baseConstructor.call(this);
this.xmlDoc=null;
};
nitobi.lang.extend(nitobi.base.Declaration,nitobi.Object);
nitobi.base.Declaration.prototype.loadHtml=function(_325){
try{
_325=$ntb(_325);
this.xmlDoc=nitobi.xml.parseHtml(_325);
return this.xmlDoc;
}
catch(err){
nitobi.lang.throwError(nitobi.error.DeclarationParseError,err);
}
};
nitobi.base.Declaration.prototype.getXmlDoc=function(){
return this.xmlDoc;
};
nitobi.base.Declaration.prototype.serializeToXml=function(){
return nitobi.xml.serialize(this.xmlDoc);
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.DateMath={DAY:"d",WEEK:"w",MONTH:"m",YEAR:"y",ONE_DAY_MS:86400000};
nitobi.base.DateMath._add=function(date,unit,_328){
if(unit==this.DAY){
date.setDate(date.getDate()+_328);
}else{
if(unit==this.WEEK){
date.setDate(date.getDate()+7*_328);
}else{
if(unit==this.MONTH){
date.setMonth(date.getMonth()+_328);
}else{
if(unit==this.YEAR){
date.setFullYear(date.getFullYear()+_328);
}
}
}
}
return date;
};
nitobi.base.DateMath.add=function(date,unit,_32b){
return this._add(date,unit,_32b);
};
nitobi.base.DateMath.subtract=function(date,unit,_32e){
return this._add(date,unit,-1*_32e);
};
nitobi.base.DateMath.after=function(date,_330){
return (date-_330)>0;
};
nitobi.base.DateMath.between=function(date,_332,end){
return (date-_332)>=0&&(end-date)>=0;
};
nitobi.base.DateMath.before=function(date,_335){
return (date-_335)<0;
};
nitobi.base.DateMath.clone=function(date){
var n=new Date(date.toString());
return n;
};
nitobi.base.DateMath.isLeapYear=function(date){
var y=date.getFullYear();
var _1=String(y/4).indexOf(".")==-1;
var _2=String(y/100).indexOf(".")==-1;
var _3=String(y/400).indexOf(".")==-1;
return (_3)?true:(_1&&!_2)?true:false;
};
nitobi.base.DateMath.getMonthDays=function(date){
return [31,(this.isLeapYear(date))?29:28,31,30,31,30,31,31,30,31,30,31][date.getMonth()];
};
nitobi.base.DateMath.getMonthEnd=function(date){
return new Date(date.getFullYear(),date.getMonth(),this.getMonthDays(date));
};
nitobi.base.DateMath.getMonthStart=function(date){
return new Date(date.getFullYear(),date.getMonth(),1);
};
nitobi.base.DateMath.isToday=function(date){
var _341=this.resetTime(new Date());
var end=this.add(this.clone(_341),this.DAY,1);
return this.between(date,_341,end);
};
nitobi.base.DateMath.isSameDay=function(date,_344){
date=this.resetTime(this.clone(date));
_344=this.resetTime(this.clone(_344));
return date.valueOf()==_344.valueOf();
};
nitobi.base.DateMath.parse=function(str){
};
nitobi.base.DateMath.getWeekNumber=function(date){
var _347=this.getJanuary1st(date);
return Math.ceil(this.getNumberOfDays(_347,date)/7);
};
nitobi.base.DateMath.getNumberOfDays=function(_348,end){
var _34a=this.resetTime(this.clone(end)).getTime()-this.resetTime(this.clone(_348)).getTime();
return Math.round(_34a/this.ONE_DAY_MS)+1;
};
nitobi.base.DateMath.getJanuary1st=function(date){
return new Date(date.getFullYear(),0,1);
};
nitobi.base.DateMath.resetTime=function(date){
if(nitobi.base.DateMath.invalid(date)){
return date;
}
date.setHours(0);
date.setMinutes(0);
date.setSeconds(0);
date.setMilliseconds(0);
return date;
};
nitobi.base.DateMath.parseIso8601=function(date){
return new Date(date.replace(/^(....).(..).(..)(.*)$/,"$1/$2/$3$4"));
};
nitobi.base.DateMath.toIso8601=function(date){
if(nitobi.base.DateMath.invalid(date)){
return "";
}
var pz=nitobi.lang.padZeros;
return date.getFullYear()+"-"+pz(date.getMonth()+1)+"-"+pz(date.getDate())+" "+pz(date.getHours())+":"+pz(date.getMinutes())+":"+pz(date.getSeconds());
};
nitobi.base.DateMath.invalid=function(date){
return (!date)||(date.toString()=="Invalid Date");
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.EventArgs=function(_351,_352){
this.source=_351;
this.event=_352||nitobi.html.Event;
};
nitobi.base.EventArgs.prototype.getSource=function(){
return this.source;
};
nitobi.base.EventArgs.prototype.getEvent=function(){
return this.event;
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.IList=function(){
nitobi.base.ISerializable.call(this);
nitobi.collections.IEnumerable.call(this);
};
nitobi.lang.implement(nitobi.collections.IList,nitobi.base.ISerializable);
nitobi.lang.implement(nitobi.collections.IList,nitobi.collections.IEnumerable);
nitobi.collections.IList.prototype.IListImplemented=true;
nitobi.collections.IList.prototype.add=function(obj){
nitobi.collections.IEnumerable.prototype.add.call(this,obj);
if(obj.ISerializableImplemented==true&&obj.profile!=null){
this.addChildObject(obj);
}
};
nitobi.collections.IList.prototype.insert=function(_354,obj){
var _356=this.get(_354);
nitobi.collections.IEnumerable.prototype.insert.call(this,_354,obj);
if(obj.ISerializableImplemented==true&&obj.profile!=null){
this.insertBeforeChildObject(obj,_356);
}
};
nitobi.collections.IList.prototype.addToCache=function(obj,_358){
nitobi.base.ISerializable.prototype.addToCache.call(this,obj);
this.list[_358]=obj;
};
nitobi.collections.IList.prototype.removeFromCache=function(_359){
nitobi.base.ISerializable.prototype.removeFromCache.call(this,this.list[_359].getId());
};
nitobi.collections.IList.prototype.flushCache=function(){
nitobi.base.ISerializable.prototype.flushCache.call(this);
this.list=new Array();
};
nitobi.collections.IList.prototype.get=function(_35a){
if(typeof (_35a)=="object"){
return _35a;
}
if(_35a<0||_35a>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
var obj=null;
if(this.list[_35a]!=null){
obj=this.list[_35a];
}
if(obj==null){
var _35c=nitobi.xml.getChildNodes(this.xmlNode)[_35a];
if(_35c==null){
return null;
}else{
obj=this.factory.createByNode(_35c);
this.onCreateObject.notify(obj);
nitobi.collections.IList.prototype.addToCache.call(this,obj,_35a);
}
obj.setParentObject(this);
}
return obj;
};
nitobi.collections.IList.prototype.getById=function(id){
var node=this.xmlNode.selectSingleNode("*[@id='"+id+"']");
var _35f=nitobi.xml.indexOfChildNode(node.parentNode,node);
return this.get(_35f);
};
nitobi.collections.IList.prototype.set=function(_360,_361){
if(_360<0||_360>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
try{
if(_361.ISerializableImplemented==true){
var obj=this.get(_360);
if(obj.getXmlNode()!=_361.getXmlNode()){
var _363=this.xmlNode.insertBefore(_361.getXmlNode(),obj.getXmlNode());
this.xmlNode.removeChild(obj.getXmlNode());
obj.setXmlNode(_363);
}
}
_361.setParentObject(this);
nitobi.collections.IList.prototype.addToCache.call(this,_361,_360);
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected,err);
}
};
nitobi.collections.IList.prototype.remove=function(_364){
var i;
if(typeof (_364)!="number"){
i=this.indexOf(_364);
}else{
i=_364;
}
var obj=this.get(i);
nitobi.collections.IEnumerable.prototype.remove.call(this,_364);
this.xmlNode.removeChild(obj.getXmlNode());
};
nitobi.collections.IList.prototype.getLength=function(){
return nitobi.xml.getChildNodes(this.xmlNode).length;
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.List=function(_367){
nitobi.collections.List.baseConstructor.call(this);
nitobi.collections.IList.call(this);
};
nitobi.lang.extend(nitobi.collections.List,nitobi.Object);
nitobi.lang.implement(nitobi.collections.List,nitobi.collections.IList);
nitobi.base.Registry.getInstance().register(new nitobi.base.Profile("nitobi.collections.List",null,false,"ntb:list"));
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.isHashEmpty=function(hash){
var _369=true;
for(var item in hash){
if(hash[item]!=null&&hash[item]!=""){
_369=false;
break;
}
}
return _369;
};
nitobi.collections.hashLength=function(hash){
var _36c=0;
for(var item in hash){
_36c++;
}
return _36c;
};
nitobi.collections.serialize=function(hash){
var s="";
for(var item in hash){
var _371=hash[item];
var type=typeof (_371);
if(type=="string"||type=="number"){
s+="'"+item+"':'"+_371+"',";
}
}
s=s.substring(0,s.length-1);
return "{"+s+"}";
};
nitobi.lang.defineNs("nitobi.ui");
if(false){
nitobi.ui=function(){
};
}
nitobi.ui.setWaitScreen=function(_373){
if(_373){
var sc=nitobi.html.getBodyArea();
var me=nitobi.html.createElement("div",{"id":"NTB_waitDiv"},{"verticalAlign":"middle","color":"#000000","font":"12px Trebuchet MS, Georgia, Verdana","textAlign":"center","background":"#ffffff","border":"1px solid #000000","padding":"0px","position":"absolute","top":(sc.clientHeight/2)+sc.scrollTop-30+"px","left":(sc.clientWidth/2)+sc.scrollLeft-100+"px","width":"200px","height":"60px"});
me.innerHTML="<table height=60 width=200><tr><td valign=center height=60 align=center>Please wait..</td></tr></table>";
document.getElementsByTagName("body").item(0).appendChild(me);
}else{
var me=$ntb("NTB_waitDiv");
try{
document.getElementsByTagName("body").item(0).removeChild(me);
}
catch(e){
}
}
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.IStyleable=function(_376){
this.htmlNode=_376||null;
this.onBeforeSetStyle=new nitobi.base.Event();
this.onSetStyle=new nitobi.base.Event();
};
nitobi.ui.IStyleable.prototype.getHtmlNode=function(){
return this.htmlNode;
};
nitobi.ui.IStyleable.prototype.setHtmlNode=function(node){
this.htmlNode=node;
};
nitobi.ui.IStyleable.prototype.setStyle=function(name,_379){
if(this.onBeforeSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onBeforeSetStyle,name,_379))&&this.getHtmlNode()!=null){
nitobi.html.Css.setStyle(this.getHtmlNode(),name,_379);
this.onSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onSetStyle,name,_379));
}
};
nitobi.ui.IStyleable.prototype.getStyle=function(name){
return nitobi.html.Css.getStyle(this.getHtmlNode(),name);
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.StyleEventArgs=function(_37b,_37c,_37d,_37e){
nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
this.property=_37d||null;
this.value=_37e||null;
};
nitobi.lang.extend(nitobi.ui.StyleEventArgs,nitobi.base.EventArgs);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.IScrollable=function(_37f){
this.scrollableElement=_37f;
};
nitobi.ui.IScrollable.prototype.setScrollableElement=function(el){
this.scrollableElement=el;
};
nitobi.ui.IScrollable.prototype.getScrollableElement=function(){
return this.scrollableElement;
};
nitobi.ui.IScrollable.prototype.getScrollLeft=function(){
return this.scrollableElement.scrollLeft;
};
nitobi.ui.IScrollable.prototype.setScrollLeft=function(left){
this.scrollableElement.scrollLeft=left;
};
nitobi.ui.IScrollable.prototype.scrollLeft=function(_382){
_382=_382||25;
this.scrollableElement.scrollLeft-=_382;
};
nitobi.ui.IScrollable.prototype.scrollRight=function(_383){
_383=_383||25;
this.scrollableElement.scrollLeft+=_383;
};
nitobi.ui.IScrollable.prototype.isOverflowed=function(_384){
_384=_384||this.scrollableElement.childNodes[0];
return !(parseInt(nitobi.html.getBox(this.scrollableElement).width)>=parseInt(nitobi.html.getBox(_384).width));
};
nitobi.lang.defineNs("nitobi.ui");
if(false){
nitobi.ui=function(){
};
}
nitobi.ui.startDragOperation=function(_385,_386,_387,_388,_389,_38a){
var ddo=new nitobi.ui.DragDrop(_385,_387,_388);
ddo.onDragStop.subscribe(_38a,_389);
ddo.startDrag(_386);
};
nitobi.ui.DragDrop=function(_38c,_38d,_38e){
this.allowVertDrag=(_38d!=null?_38d:true);
this.allowHorizDrag=(_38e!=null?_38e:true);
if(nitobi.browser.IE){
this.surface=document.getElementById("ebadragdropsurface_");
if(this.surface==null){
this.surface=nitobi.html.createElement("div",{"id":"ebadragdropsurface_"},{"filter":"alpha(opacity=1)","backgroundColor":"white","position":"absolute","display":"none","top":"0px","left":"0px","width":"100px","height":"100px","zIndex":"899"});
document.body.appendChild(this.surface);
}
}
if(_38c.nodeType==3){
alert("Text node not supported. Use parent element");
}
this.element=_38c;
this.zIndex=this.element.style.zIndex;
this.element.style.zIndex=900;
this.onMouseMove=new nitobi.base.Event();
this.onDragStart=new nitobi.base.Event();
this.onDragStop=new nitobi.base.Event();
this.events=[{"type":"mouseup","handler":this.handleMouseUp,"capture":true},{"type":"mousemove","handler":this.handleMouseMove,"capture":true}];
};
nitobi.ui.DragDrop.prototype.startDrag=function(_38f){
this.elementOriginTop=parseInt(this.element.style.top,10);
this.elementOriginLeft=parseInt(this.element.style.left,10);
if(isNaN(this.elementOriginLeft)){
this.elementOriginLeft=0;
}
if(isNaN(this.elementOriginTop)){
this.elementOriginTop=0;
}
var _390=nitobi.html.getEventCoords(_38f);
x=_390.x;
y=_390.y;
this.originX=x;
this.originY=y;
nitobi.html.attachEvents(document,this.events,this);
nitobi.html.cancelEvent(_38f);
this.onDragStart.notify();
};
nitobi.ui.DragDrop.prototype.handleMouseMove=function(_391){
var x,y;
var _394=nitobi.html.getEventCoords(_391);
x=_394.x;
y=_394.y;
if(nitobi.browser.IE){
this.surface.style.display="block";
if(document.compat=="CSS1Compat"){
var _395=nitobi.html.getBodyArea();
var _396=0;
if(document.compatMode=="CSS1Compat"){
_396=25;
}
this.surface.style.width=(_395.clientWidth-_396)+"px";
this.surface.style.height=(_395.clientHeight)+"px";
}else{
this.surface.style.width=document.body.clientWidth;
this.surface.style.height=document.body.clientHeight;
}
}
if(this.allowHorizDrag){
this.element.style.left=(this.elementOriginLeft+x-this.originX)+"px";
}
if(this.allowVertDrag){
this.element.style.top=(this.elementOriginTop+y-this.originY)+"px";
}
this.x=x;
this.y=y;
this.onMouseMove.notify(this);
nitobi.html.cancelEvent(_391);
};
nitobi.ui.DragDrop.prototype.handleMouseUp=function(_397){
this.onDragStop.notify({"event":_397,"x":this.x,"y":this.y});
nitobi.html.detachEvents(document,this.events);
if(nitobi.browser.IE){
this.surface.style.display="none";
}
this.element.style.zIndex=this.zIndex;
this.element.object=null;
this.element=null;
};
if(typeof (nitobi.ajax)=="undefined"){
nitobi.ajax=function(){
};
}
nitobi.ajax.createXmlHttp=function(){
if(nitobi.browser.IE){
var _398=null;
try{
_398=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e){
try{
_398=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(ee){
}
}
return _398;
}else{
if(nitobi.browser.XHR_ENABLED){
return new XMLHttpRequest();
}
}
};
nitobi.lang.defineNs("nitobi.ajax");
nitobi.ajax.HttpRequest=function(){
this.handler="";
this.async=true;
this.responseType=null;
this.httpObj=nitobi.ajax.createXmlHttp();
this.onPostComplete=new nitobi.base.Event();
this.onGetComplete=new nitobi.base.Event();
this.onRequestComplete=new nitobi.base.Event();
this.onError=new nitobi.base.Event();
this.timeout=0;
this.timeoutId=null;
this.params=null;
this.data="";
this.completeCallback=null;
this.status="complete";
this.preventCache=true;
this.username="";
this.password="";
this.requestMethod="get";
this.requestHeaders={};
};
nitobi.lang.extend(nitobi.ajax.HttpRequest,nitobi.Object);
nitobi.ajax.HttpRequestPool_MAXCONNECTIONS=64;
nitobi.ajax.HttpRequest.prototype.handleResponse=function(){
var _399=null;
var _39a=null;
if((this.httpObj.responseXML!=null&&this.httpObj.responseXML.documentElement!=null)&&this.responseType!="text"){
_399=this.httpObj.responseXML;
}else{
if(this.responseType=="xml"){
_399=nitobi.xml.createXmlDoc(this.httpObj.responseText);
}else{
_399=this.httpObj.responseText;
}
}
if(this.httpObj.status!=200){
this.onError.notify({"source":this,"status":this.httpObj.status,"message":"An error occured retrieving the data from the server. "+"Expected response type was '"+this.responseType+"'."});
}
return _399;
};
nitobi.ajax.HttpRequest.prototype.post=function(data,url){
this.data=data;
return this._send("POST",url,data,this.postComplete);
};
nitobi.ajax.HttpRequest.prototype.get=function(url){
return this._send("GET",url,null,this.getComplete);
};
nitobi.ajax.HttpRequest.prototype.postComplete=function(){
if(this.httpObj.readyState==4){
this.status="complete";
var _39e={"response":this.handleResponse(),"params":this.params};
this.responseXml=this.responseText=_39e.response;
this.onPostComplete.notify(_39e);
this.onRequestComplete.notify(_39e);
if(this.completeCallback){
this.completeCallback.call(this,_39e);
}
}
};
nitobi.ajax.HttpRequest.prototype.postXml=function(_39f){
this.setTimeout();
if(("undefined"==typeof (_39f.documentElement))||(null==_39f.documentElement)||("undefined"==typeof (_39f.documentElement.childNodes))||(1>_39f.documentElement.childNodes.length)){
ebaErrorReport("updategram is empty. No request sent. xmlData["+_39f+"]\nxmlData.xml["+_39f.xml+"]");
return;
}
if(null==_39f.xml){
var _3a0=new XMLSerializer();
_39f.xml=_3a0.serializeToString(_39f);
}
return this.post(_39f.xml);
};
nitobi.ajax.HttpRequest.prototype._send=function(_3a1,url,data,_3a4){
this.handler=url||this.handler;
this.setTimeout();
this.status="pending";
this.httpObj.open(_3a1,(this.preventCache?this.cacheBust(this.handler):this.handler),this.async,this.username,this.password);
if(this.async){
this.httpObj.onreadystatechange=nitobi.lang.close(this,_3a4);
}
for(var item in this.requestHeaders){
this.httpObj.setRequestHeader(item,this.requestHeaders[item]);
}
if(this.responseType=="xml"){
this.httpObj.setRequestHeader("Content-Type","text/xml");
}else{
if(_3a1.toLowerCase()=="post"){
this.httpObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
}
}
this.httpObj.send(data);
if(!this.async){
return this.handleResponse();
}
return this.httpObj;
};
nitobi.ajax.HttpRequest.prototype.open=function(_3a6,url,_3a8,_3a9,_3aa){
this.requestMethod=_3a6;
this.async=_3a8;
this.username=_3a9;
this.password=_3aa;
this.handler=url;
};
nitobi.ajax.HttpRequest.prototype.send=function(data){
var _3ac=null;
switch(this.requestMethod.toUpperCase()){
case "POST":
_3ac=this.post(data);
break;
default:
_3ac=this.get();
break;
}
this.responseXml=this.responseText=_3ac;
};
nitobi.ajax.HttpRequest.prototype.setTimeout=function(){
if(this.timeout>0){
this.timeoutId=window.setTimeout(nitobi.lang.close(this,this.abort),this.timeout);
}
};
nitobi.ajax.HttpRequest.prototype.getComplete=function(){
if(this.httpObj.readyState==4){
this.status="complete";
var _3ad={"response":this.handleResponse(),"params":this.params,"status":this.httpObj.status,"statusText":this.httpObj.statusText};
this.responseXml=this.responseText=_3ad.response;
this.onGetComplete.notify(_3ad);
this.onRequestComplete.notify(_3ad);
if(this.completeCallback){
this.completeCallback.call(this,_3ad);
}
}
};
nitobi.ajax.HttpRequest.prototype.setRequestHeader=function(_3ae,val){
this.requestHeaders[_3ae]=val;
};
nitobi.ajax.HttpRequest.prototype.isError=function(code){
return (code>=400&&code<600);
};
nitobi.ajax.HttpRequest.prototype.abort=function(){
this.httpObj.onreadystatechange=function(){
};
this.httpObj.abort();
};
nitobi.ajax.HttpRequest.prototype.clear=function(){
this.handler="";
this.async=true;
this.onPostComplete.dispose();
this.onGetComplete.dispose();
this.params=null;
};
nitobi.ajax.HttpRequest.prototype.cacheBust=function(url){
var _3b2=url.split("?");
var _3b3="nitobi_cachebust="+(new Date().getTime());
if(_3b2.length==1){
url+="?"+_3b3;
}else{
url+="&"+_3b3;
}
return url;
};
nitobi.ajax.HttpRequestPool=function(_3b4){
this.inUse=new Array();
this.free=new Array();
this.max=_3b4||nitobi.ajax.HttpRequestPool_MAXCONNECTIONS;
this.locked=false;
this.context=null;
};
nitobi.ajax.HttpRequestPool.prototype.reserve=function(){
this.locked=true;
var _3b5;
if(this.free.length){
_3b5=this.free.pop();
_3b5.clear();
this.inUse.push(_3b5);
}else{
if(this.inUse.length<this.max){
try{
_3b5=new nitobi.ajax.HttpRequest();
}
catch(e){
_3b5=null;
}
this.inUse.push(_3b5);
}else{
throw "No request objects available";
}
}
this.locked=false;
return _3b5;
};
nitobi.ajax.HttpRequestPool.prototype.release=function(_3b6){
var _3b7=false;
this.locked=true;
if(null!=_3b6){
for(var i=0;i<this.inUse.length;i++){
if(_3b6==this.inUse[i]){
this.free.push(this.inUse[i]);
this.inUse.splice(i,1);
_3b7=true;
break;
}
}
}
this.locked=false;
return null;
};
nitobi.ajax.HttpRequestPool.prototype.dispose=function(){
for(var i=0;i<this.inUse.length;i++){
this.inUse[i].dispose();
}
this.inUse=null;
for(var j=0;j<this.free.length;j++){
this.free[i].dispose();
}
this.free=null;
};
nitobi.ajax.HttpRequestPool.instance=null;
nitobi.ajax.HttpRequestPool.getInstance=function(){
if(nitobi.ajax.HttpRequestPool.instance==null){
nitobi.ajax.HttpRequestPool.instance=new nitobi.ajax.HttpRequestPool();
}
return nitobi.ajax.HttpRequestPool.instance;
};
nitobi.lang.defineNs("nitobi.data");
nitobi.data.UrlConnector=function(url,_3bc){
this.url=url||null;
this.transformer=_3bc||null;
this.async=true;
};
nitobi.data.UrlConnector.prototype.get=function(_3bd,_3be){
this.request=nitobi.data.UrlConnector.requestPool.reserve();
var _3bf=this.url;
for(var p in _3bd){
_3bf=nitobi.html.Url.setParameter(_3bf,p,_3bd[p]);
}
this.request.handler=_3bf;
this.request.async=this.async;
this.request.responseType="xml";
this.request.params={dataReadyCallback:_3be};
this.request.completeCallback=nitobi.lang.close(this,this.getComplete);
this.request.get();
};
nitobi.data.UrlConnector.prototype.getComplete=function(_3c1){
if(_3c1.params.dataReadyCallback){
var _3c2=_3c1.response;
var _3c3=_3c1.params.dataReadyCallback;
var _3c4=_3c2;
if(this.transformer){
if(typeof (this.transformer)==="function"){
_3c4=this.transformer.call(null,_3c2);
}else{
_3c4=nitobi.xml.transform(_3c2,this.transformer,"xml");
}
}
if(_3c3){
_3c3.call(null,{result:_3c4,response:_3c1.response});
}
}
nitobi.data.UrlConnector.requestPool.release(this.request);
};
nitobi.data.UrlConnector.requestPool=new nitobi.ajax.HttpRequestPool();
function ntbAssert(_3c5,_3c6,_3c7,_3c8){
}
nitobi.lang.defineNs("console");
nitobi.lang.defineNs("nitobi.debug");
if(typeof (console.log)=="undefined"){
console.log=function(s){
nitobi.debug.addDebugTools();
var t=$ntb("nitobi.log");
t.value=s+"\n"+t.value;
};
console.evalCode=function(){
var _3cb=(eval($ntb("nitobi.consoleEntry").value));
};
}
nitobi.debug.addDebugTools=function(){
var sId="nitobi_debug_panel";
var div=document.getElementById(sId);
var html="<table width=100%><tr><td width=50%><textarea style='width:100%' cols=125 rows=25 id='nitobi.log'></textarea></td><td width=50%><textarea style='width:100%' cols=125 rows=25 id='nitobi.consoleEntry'></textarea><br/><button onclick='console.evalCode()'>Eval</button></td></tr></table>";
if(div==null){
var div=document.createElement("div");
div.setAttribute("id",sId);
div.innerHTML=html;
document.body.appendChild(div);
}else{
if(div.innerHTML==""){
div.innerHTML=html;
}
}
};
nitobi.debug.assert=function(){
};
EBA_EM_ATTRIBUTE_ERROR=1;
EBA_XHR_RESPONSE_ERROR=2;
EBA_DEBUG="debug";
EBA_WARN="warn";
EBA_ERROR="error";
EBA_THROW="throw";
EBA_DEBUG_MODE=false;
EBA_ON_ERROR="";
EBA_LAST_ERROR="";
_ebaDebug=false;
NTB_EM_ATTRIBUTE_ERROR=1;
NTB_XHR_RESPONSE_ERROR=2;
NTB_DEBUG="debug";
NTB_WARN="warn";
NTB_ERROR="error";
NTB_THROW="throw";
NTB_DEBUG_MODE=false;
NTB_ON_ERROR="";
NTB_LAST_ERROR="";
_ebaDebug=false;
function _ntbAssert(_3cf,_3d0){
ntbAssert(_3cf,_3d0,"",DEBUG);
}
function ebaSetOnErrorEvent(_3d1){
nitobi.debug.setOnErrorEvent.apply(this,arguments);
}
nitobi.debug.setOnErrorEvent=function(_3d2){
NTB_ON_ERROR=_3d2;
};
function ebaReportError(_3d3,_3d4,_3d5){
nitobi.debug.errorReport("dude stop calling this method it is now called nitobi.debug.errorReport","");
nitobi.debug.errorReport(_3d3,_3d4,_3d5);
}
function ebaErrorReport(_3d6,_3d7,_3d8){
nitobi.debug.errorReport.apply(this,arguments);
}
nitobi.debug.errorReport=function(_3d9,_3da,_3db){
_3db=(_3db)?_3db:NTB_DEBUG;
if(NTB_DEBUG==_3db&&!NTB_DEBUG_MODE){
return;
}
var _3dc=_3d9+"\nerror code    ["+_3da+"]\nerror Severity["+_3db+"]";
LastError=_3dc;
if(eval(NTB_ON_ERROR||"true")){
switch(_3da){
case NTB_EM_ATTRIBUTE_ERROR:
confirm(_3d9);
break;
case NTB_XHR_RESPONSE_ERROR:
confirm(_3d9);
break;
default:
window.status=_3d9;
break;
}
}
if(NTB_THROW==_3db){
throw (_3dc);
}
};
if(false){
nitobi.error=function(){
};
}
nitobi.lang.defineNs("nitobi.error");
nitobi.error.onError=new nitobi.base.Event();
if(nitobi){
if(nitobi.testframework){
if(nitobi.testframework.initEventError){
nitobi.testframework.initEventError();
}
}
}
nitobi.error.ErrorEventArgs=function(_3dd,_3de,type){
nitobi.error.ErrorEventArgs.baseConstructor.call(this,_3dd);
this.description=_3de;
this.type=type;
};
nitobi.lang.extend(nitobi.error.ErrorEventArgs,nitobi.base.EventArgs);
nitobi.error.isError=function(err,_3e1){
return (err.indexOf(_3e1)>-1);
};
nitobi.error.OutOfBounds="Array index out of bounds.";
nitobi.error.Unexpected="An unexpected error occurred.";
nitobi.error.ArgExpected="The argument is null and not optional.";
nitobi.error.BadArgType="The argument is not of the correct type.";
nitobi.error.BadArg="The argument is not a valid value.";
nitobi.error.XmlParseError="The XML did not parse correctly.";
nitobi.error.DeclarationParseError="The HTML declaration could not be parsed.";
nitobi.error.ExpectedInterfaceNotFound="The object does not support the properties or methods of the expected interface. Its class must implement the required interface.";
nitobi.error.NoHtmlNode="No HTML node found with id.";
nitobi.error.OrphanXmlNode="The XML node has no owner document.";
nitobi.error.HttpRequestError="The HTML page could not be loaded.";
nitobi.lang.defineNs("nitobi.html");
nitobi.html.IRenderer=function(_3e2){
this.setTemplate(_3e2);
this.parameters={};
};
nitobi.html.IRenderer.prototype.renderAfter=function(_3e3,data){
_3e3=$ntb(_3e3);
var _3e5=_3e3.parentNode;
_3e3=_3e3.nextSibling;
return this._renderBefore(_3e5,_3e3,data);
};
nitobi.html.IRenderer.prototype.renderBefore=function(_3e6,data){
_3e6=$ntb(_3e6);
return this._renderBefore(_3e6.parentNode,_3e6,data);
};
nitobi.html.IRenderer.prototype._renderBefore=function(_3e8,_3e9,data){
var s=this.renderToString(data);
var _3ec=document.createElement("div");
_3ec.innerHTML=s;
var _3ed=new Array();
if(_3ec.childNodes){
var i=0;
while(_3ec.childNodes.length){
_3ed[i++]=_3ec.firstChild;
_3e8.insertBefore(_3ec.firstChild,_3e9);
}
}else{
}
return _3ed;
};
nitobi.html.IRenderer.prototype.renderIn=function(_3ef,data){
_3ef=$ntb(_3ef);
var s=this.renderToString(data);
_3ef.innerHTML=s;
return _3ef.childNodes;
};
nitobi.html.IRenderer.prototype.renderToString=function(data){
};
nitobi.html.IRenderer.prototype.setTemplate=function(_3f3){
this.template=_3f3;
};
nitobi.html.IRenderer.prototype.getTemplate=function(){
return this.template;
};
nitobi.html.IRenderer.prototype.setParameters=function(_3f4){
for(var p in _3f4){
this.parameters[p]=_3f4[p];
}
};
nitobi.html.IRenderer.prototype.getParameters=function(){
return this.parameters;
};
nitobi.lang.defineNs("nitobi.html");
nitobi.html.XslRenderer=function(_3f6){
nitobi.html.IRenderer.call(this,_3f6);
};
nitobi.lang.implement(nitobi.html.XslRenderer,nitobi.html.IRenderer);
nitobi.html.XslRenderer.prototype.setTemplate=function(_3f7){
if(typeof (_3f7)==="string"){
_3f7=nitobi.xml.createXslProcessor(_3f7);
}
this.template=_3f7;
};
nitobi.html.XslRenderer.prototype.renderToString=function(data){
if(typeof (data)==="string"){
data=nitobi.xml.createXmlDoc(data);
}
if(nitobi.lang.typeOf(data)===nitobi.lang.type.XMLNODE){
data=nitobi.xml.createXmlDoc(nitobi.xml.serialize(data));
}
var _3f9=this.getTemplate();
var _3fa=this.getParameters();
for(var p in _3fa){
_3f9.addParameter(p,_3fa[p],"");
}
var s=nitobi.xml.transformToString(data,_3f9,"xml");
for(var p in _3fa){
_3f9.addParameter(p,"","");
}
return s;
};
nitobi.lang.defineNs("nitobi.ui");
NTB_CSS_HIDE="nitobi-hide";
nitobi.ui.Element=function(id){
nitobi.ui.Element.baseConstructor.call(this);
nitobi.ui.IStyleable.call(this);
if(id!=null){
if(nitobi.lang.typeOf(id)==nitobi.lang.type.XMLNODE){
nitobi.base.ISerializable.call(this,id);
}else{
if($ntb(id)!=null){
var decl=new nitobi.base.Declaration();
var _3ff=decl.loadHtml($ntb(id));
var _400=$ntb(id);
var _401=_400.parentNode;
var _402=_401.ownerDocument.createElement("ntb:component");
_401.insertBefore(_402,_400);
_401.removeChild(_400);
this.setContainer(_402);
nitobi.base.ISerializable.call(this,_3ff);
}else{
nitobi.base.ISerializable.call(this);
this.setId(id);
}
}
}else{
nitobi.base.ISerializable.call(this);
}
this.eventMap={};
this.onCreated=new nitobi.base.Event("created");
this.eventMap["created"]=this.onCreated;
this.onBeforeRender=new nitobi.base.Event("beforerender");
this.eventMap["beforerender"]=this.onBeforeRender;
this.onRender=new nitobi.base.Event("render");
this.eventMap["render"]=this.onRender;
this.onBeforeSetVisible=new nitobi.base.Event("beforesetvisible");
this.eventMap["beforesetvisible"]=this.onBeforeSetVisible;
this.onSetVisible=new nitobi.base.Event("setvisible");
this.eventMap["setvisible"]=this.onSetVisible;
this.onBeforePropagate=new nitobi.base.Event("beforepropagate");
this.onEventNotify=new nitobi.base.Event("eventnotify");
this.onBeforeEventNotify=new nitobi.base.Event("beforeeventnotify");
this.onBeforePropagateToChild=new nitobi.base.Event("beforepropogatetochild");
this.subscribeDeclarationEvents();
this.setEnabled(true);
this.renderer=new nitobi.html.XslRenderer();
};
nitobi.lang.extend(nitobi.ui.Element,nitobi.Object);
nitobi.lang.implement(nitobi.ui.Element,nitobi.base.ISerializable);
nitobi.lang.implement(nitobi.ui.Element,nitobi.ui.IStyleable);
nitobi.ui.Element.htmlNodeCache={};
nitobi.ui.Element.prototype.setHtmlNode=function(_403){
var node=$ntb(_403);
this.htmlNode=node;
};
nitobi.ui.Element.prototype.getRootId=function(){
var _405=this.getParentObject();
if(_405==null){
return this.getId();
}else{
return _405.getRootId();
}
};
nitobi.ui.Element.prototype.getId=function(){
return this.getAttribute("id");
};
nitobi.ui.Element.parseId=function(id){
var ids=id.split(".");
if(ids.length<=2){
return {localName:ids[1],id:ids[0]};
}
return {localName:ids.pop(),id:ids.join(".")};
};
nitobi.ui.Element.prototype.setId=function(id){
this.setAttribute("id",id);
};
nitobi.ui.Element.prototype.notify=function(_409,id,_40b,_40c){
try{
_409=nitobi.html.getEvent(_409);
if(_40c!==false){
nitobi.html.cancelEvent(_409);
}
var _40d=nitobi.ui.Element.parseId(id).id;
if(!this.isDescendantExists(_40d)){
return false;
}
var _40e=!(_40d==this.getId());
var _40f=new nitobi.ui.ElementEventArgs(this,null,id);
var _410=new nitobi.ui.EventNotificationEventArgs(this,null,id,_409);
_40e=_40e&&this.onBeforePropagate.notify(_410);
var _411=true;
if(_40e){
if(_40b==null){
_40b=this.getPathToLeaf(_40d);
}
var _412=this.onBeforeEventNotify.notify(_410);
var _413=(_412?this.onEventNotify.notify(_410):true);
var _414=_40b.pop().getAttribute("id");
var _415=this.getObjectById(_414);
var _411=this.onBeforePropagateToChild.notify(_410);
if(_415.notify&&_411&&_413){
_411=_415.notify(_409,id,_40b,_40c);
}
}else{
_411=this.onEventNotify.notify(_410);
}
var _416=this.eventMap[_409.type];
if(_416!=null&&_411){
_416.notify(this.getEventArgs(_409,id));
}
return _411;
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected+" Element.notify encountered a problem.",err);
}
};
nitobi.ui.Element.prototype.getEventArgs=function(_417,_418){
var _419=new nitobi.ui.ElementEventArgs(this,null,_418);
return _419;
};
nitobi.ui.Element.prototype.subscribeDeclarationEvents=function(){
for(var name in this.eventMap){
var ev=this.getAttribute("on"+name);
if(ev!=null&&ev!=""){
this.eventMap[name].subscribe(ev,this,name);
}
}
};
nitobi.ui.Element.prototype.getHtmlNode=function(name){
var id=this.getId();
id=(name!=null?id+"."+name:id);
var node=nitobi.ui.Element.htmlNodeCache[name];
if(node==null){
node=$ntb(id);
nitobi.ui.Element.htmlNodeCache[id]=node;
}
return node;
};
nitobi.ui.Element.prototype.flushHtmlNodeCache=function(){
nitobi.ui.Element.htmlNodeCache={};
};
nitobi.ui.Element.prototype.hide=function(_41f,_420,_421){
this.setVisible(false,_41f,_420,_421);
};
nitobi.ui.Element.prototype.show=function(_422,_423,_424){
this.setVisible(true,_422,_423,_424);
};
nitobi.ui.Element.prototype.isVisible=function(){
var node=this.getHtmlNode();
return node&&!nitobi.html.Css.hasClass(node,NTB_CSS_HIDE);
};
nitobi.ui.Element.prototype.setVisible=function(_426,_427,_428,_429){
var _42a=this.getHtmlNode();
if(_42a&&this.isVisible()!=_426&&this.onBeforeSetVisible.notify({source:this,event:this.onBeforeSetVisible,args:arguments})!==false){
if(this.effect){
this.effect.end();
}
if(_426){
if(_427){
var _42b=new _427(_42a,_429);
_42b.callback=nitobi.lang.close(this,this.handleSetVisible,[_428]);
this.effect=_42b;
_42b.onFinish.subscribeOnce(nitobi.lang.close(this,function(){
this.effect=null;
}));
_42b.start();
}else{
nitobi.html.Css.removeClass(_42a,NTB_CSS_HIDE);
this.handleSetVisible(_428);
}
}else{
if(_427){
var _42b=new _427(_42a,_429);
_42b.callback=nitobi.lang.close(this,this.handleSetVisible,[_428]);
this.effect=_42b;
_42b.onFinish.subscribeOnce(nitobi.lang.close(this,function(){
this.effect=null;
}));
_42b.start();
}else{
nitobi.html.Css.addClass(this.getHtmlNode(),NTB_CSS_HIDE);
this.handleSetVisible(_428);
}
}
}
};
nitobi.ui.Element.prototype.handleSetVisible=function(_42c){
if(_42c){
_42c();
}
this.onSetVisible.notify(new nitobi.ui.ElementEventArgs(this,this.onSetVisible));
};
nitobi.ui.Element.prototype.setEnabled=function(_42d){
this.enabled=_42d;
};
nitobi.ui.Element.prototype.isEnabled=function(){
return this.enabled;
};
nitobi.ui.Element.prototype.render=function(_42e,_42f){
this.flushHtmlNodeCache();
_42f=_42f||this.getState();
_42e=$ntb(_42e)||this.getContainer();
if(_42e==null){
var _42e=document.createElement("span");
document.body.appendChild(_42e);
this.setContainer(_42e);
}
this.htmlNode=this.renderer.renderIn(_42e,_42f)[0];
this.htmlNode.jsObject=this;
};
nitobi.ui.Element.prototype.getContainer=function(){
return this.container;
};
nitobi.ui.Element.prototype.setContainer=function(_430){
this.container=$ntb(_430);
};
nitobi.ui.Element.prototype.getState=function(){
return this.getXmlNode();
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.ElementEventArgs=function(_431,_432,_433){
nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
this.targetId=_433||null;
};
nitobi.lang.extend(nitobi.ui.ElementEventArgs,nitobi.base.EventArgs);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.EventNotificationEventArgs=function(_434,_435,_436,_437){
nitobi.ui.EventNotificationEventArgs.baseConstructor.apply(this,arguments);
this.htmlEvent=_437||null;
};
nitobi.lang.extend(nitobi.ui.EventNotificationEventArgs,nitobi.ui.ElementEventArgs);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.Container=function(id){
nitobi.ui.Container.baseConstructor.call(this,id);
nitobi.collections.IList.call(this);
};
nitobi.lang.extend(nitobi.ui.Container,nitobi.ui.Element);
nitobi.lang.implement(nitobi.ui.Container,nitobi.collections.IList);
nitobi.base.Registry.getInstance().register(new nitobi.base.Profile("nitobi.ui.Container",null,false,"ntb:container"));
nitobi.lang.defineNs("nitobi.ui");
NTB_CSS_SMALL="ntb-effects-small";
NTB_CSS_HIDE="nitobi-hide";
if(false){
nitobi.ui.Effects=function(){
};
}
nitobi.ui.Effects={};
nitobi.ui.Effects.setVisible=function(_439,_43a,_43b,_43c,_43d){
_43c=(_43d?nitobi.lang.close(_43d,_43c):_43c)||nitobi.lang.noop;
_439=$ntb(_439);
if(typeof _43b=="string"){
_43b=nitobi.effects.families[_43b];
}
if(!_43b){
_43b=nitobi.effects.families["none"];
}
if(_43a){
var _43e=_43b.show;
}else{
var _43e=_43b.hide;
}
if(_43e){
var _43f=new _43e(_439);
_43f.callback=_43c;
_43f.start();
}else{
if(_43a){
nitobi.html.Css.removeClass(_439,NTB_CSS_HIDE);
}else{
nitobi.html.Css.addClass(_439,NTB_CSS_HIDE);
}
_43c();
}
};
nitobi.ui.Effects.shrink=function(_440,_441,_442,_443){
var rect=nitobi.html.getClientRects(_441)[0];
_440.deltaHeight_Doctype=0-parseInt("0"+nitobi.html.getStyle(_441,"border-top-width"))-parseInt("0"+nitobi.html.getStyle(_441,"border-bottom-width"))-parseInt("0"+nitobi.html.getStyle(_441,"padding-top"))-parseInt("0"+nitobi.html.getStyle(_441,"padding-bottom"));
_440.deltaWidth_Doctype=0-parseInt("0"+nitobi.html.getStyle(_441,"border-left-width"))-parseInt("0"+nitobi.html.getStyle(_441,"border-right-width"))-parseInt("0"+nitobi.html.getStyle(_441,"padding-left"))-parseInt("0"+nitobi.html.getStyle(_441,"padding-right"));
_440.oldHeight=Math.abs(rect.top-rect.bottom)+_440.deltaHeight_Doctype;
_440.oldWidth=Math.abs(rect.right-rect.left)+_440.deltaWidth_Doctype;
if(!(typeof (_440.width)=="undefined")){
_440.deltaWidth=Math.floor(Math.ceil(_440.width-_440.oldWidth)/(_442/nitobi.ui.Effects.ANIMATION_INTERVAL));
}else{
_440.width=_440.oldWidth;
_440.deltaWidth=0;
}
if(!(typeof (_440.height)=="undefined")){
_440.deltaHeight=Math.floor(Math.ceil(_440.height-_440.oldHeight)/(_442/nitobi.ui.Effects.ANIMATION_INTERVAL));
}else{
_440.height=_440.oldHeight;
_440.deltaHeight=0;
}
nitobi.ui.Effects.resize(_440,_441,_442,_443);
};
nitobi.ui.Effects.resize=function(_445,_446,_447,_448){
var rect=nitobi.html.getClientRects(_446)[0];
var _44a=Math.abs(rect.top-rect.bottom);
var _44b=Math.max(_44a+_445.deltaHeight+_445.deltaHeight_Doctype,0);
if(Math.abs(_44a-_445.height)<Math.abs(_445.deltaHeight)){
_44b=_445.height;
_445.deltaHeight=0;
}
var _44c=Math.abs(rect.right-rect.left);
var _44d=Math.max(_44c+_445.deltaWidth+_445.deltaWidth_Doctype,0);
_44d=(_44d>=0)?_44d:0;
if(Math.abs(_44c-_445.width)<Math.abs(_445.deltaWidth)){
_44d=_445.width;
_445.deltaWidth=0;
}
_447-=nitobi.ui.Effects.ANIMATION_INTERVAL;
if(_447>0){
window.setTimeout(nitobi.lang.closeLater(this,nitobi.ui.Effects.resize,[_445,_446,_447,_448]),nitobi.ui.Effects.ANIMATION_INTERVAL);
}
var _44e=function(){
_446.height=_44b+"px";
_446.style.height=_44b+"px";
_446.width=_44d+"px";
_446.style.width=_44d+"px";
if(_447<=0){
if(_448){
window.setTimeout(_448,0);
}
}
};
nitobi.ui.Effects.executeNextPulse.push(_44e);
};
nitobi.ui.Effects.executeNextPulse=new Array();
nitobi.ui.Effects.pulse=function(){
var p;
while(p=nitobi.ui.Effects.executeNextPulse.pop()){
p.call();
}
};
nitobi.ui.Effects.PULSE_INTERVAL=20;
nitobi.ui.Effects.ANIMATION_INTERVAL=40;
window.setInterval(nitobi.ui.Effects.pulse,nitobi.ui.Effects.PULSE_INTERVAL);
window.setTimeout(nitobi.ui.Effects.pulse,nitobi.ui.Effects.PULSE_INTERVAL);
nitobi.ui.Effects.fadeIntervalId={};
nitobi.ui.Effects.fadeIntervalTime=10;
nitobi.ui.Effects.cube=function(_450){
return _450*_450*_450;
};
nitobi.ui.Effects.cubeRoot=function(_451){
var T=0;
var N=parseFloat(_451);
if(N<0){
N=-N;
T=1;
}
var M=Math.sqrt(N);
var ctr=1;
while(ctr<101){
var M=M*N;
var M=Math.sqrt(Math.sqrt(M));
ctr++;
}
return M;
};
nitobi.ui.Effects.linear=function(_456){
return _456;
};
nitobi.ui.Effects.fade=function(_457,_458,time,_45a,_45b){
_45b=_45b||nitobi.ui.Effects.linear;
var _45c=(new Date()).getTime()+time;
var id=nitobi.component.getUniqueId();
var _45e=(new Date()).getTime();
var el=_457;
if(_457.length){
el=_457[0];
}
var _460=nitobi.html.Css.getOpacity(el);
var _461=(_458-_460<0?-1:0);
nitobi.ui.Effects.fadeIntervalId[id]=window.setInterval(function(){
nitobi.ui.Effects.stepFade(_457,_458,_45e,_45c,id,_45a,_45b,_461);
},nitobi.ui.Effects.fadeIntervalTime);
};
nitobi.ui.Effects.stepFade=function(_462,_463,_464,_465,id,_467,_468,_469){
var ct=(new Date()).getTime();
var _46b=_465-_464;
var nct=((ct-_464)/(_465-_464));
if(nct<=0||nct>=1){
nitobi.html.Css.setOpacities(_462,_463);
window.clearInterval(nitobi.ui.Effects.fadeIntervalId[id]);
_467();
return;
}else{
nct=Math.abs(nct+_469);
}
var no=_468(nct);
nitobi.html.Css.setOpacities(_462,no*100);
};
nitobi.lang.defineNs("nitobi.component");
if(false){
nitobi.component=function(){
};
}
nitobi.loadComponent=function(el){
var id=el;
el=$ntb(el);
if(el==null){
nitobi.lang.throwError("nitobi.loadComponent could not load the component because it could not be found on the page. The component may not have a declaration, node, or it may have a duplicated id. Id: "+id);
}
if(el.jsObject!=null){
return el.jsObject;
}
var _470;
var _471=nitobi.html.getTagName(el);
if(_471=="ntb:grid"){
_470=nitobi.initGrid(el.id);
}else{
if(_471==="ntb:combo"){
_470=nitobi.initCombo(el.id);
}else{
if(_471=="ntb:treegrid"){
_470=nitobi.initTreeGrid(el.id);
}else{
if(el.jsObject==null){
_470=nitobi.base.Factory.getInstance().createByTag(_471,el.id,nitobi.component.renderComponent);
if(_470.render&&!_470.onLoadCallback){
_470.render();
}
}else{
_470=el.jsObject;
}
}
}
}
return _470;
};
nitobi.component.renderComponent=function(_472){
_472.source.render();
};
nitobi.getComponent=function(id){
var el=$ntb(id);
if(el==null){
return null;
}
return el.jsObject;
};
nitobi.component.uniqueId=0;
nitobi.component.getUniqueId=function(){
return "ntbcmp_"+(nitobi.component.uniqueId++);
};
nitobi.getComponents=function(_475,_476){
if(_476==null){
_476=[];
}
if(nitobi.component.isNitobiElement(_475)){
_476.push(_475);
return;
}
var _477=_475.childNodes;
for(var i=0;i<_477.length;i++){
nitobi.getComponents(_477[i],_476);
}
return _476;
};
nitobi.component.isNitobiElement=function(_479){
var _47a=nitobi.html.getTagName(_479);
if(_47a.substr(0,3)=="ntb"){
return true;
}else{
return false;
}
};
nitobi.component.loadComponentsFromNode=function(_47b){
var _47c=new Array();
nitobi.getComponents(_47b,_47c);
for(var i=0;i<_47c.length;i++){
nitobi.loadComponent(_47c[i].getAttribute("id"));
}
};
nitobi.lang.defineNs("nitobi.effects");
if(false){
nitobi.effects=function(){
};
}
nitobi.effects.Effect=function(_47e,_47f){
this.element=$ntb(_47e);
this.transition=_47f.transition||nitobi.effects.Transition.sinoidal;
this.duration=_47f.duration||1;
this.fps=_47f.fps||50;
this.from=typeof (_47f.from)==="number"?_47f.from:0;
this.to=typeof (_47f.from)==="number"?_47f.to:1;
this.delay=_47f.delay||0;
this.callback=typeof (_47f.callback)==="function"?_47f.callback:nitobi.lang.noop;
this.queue=_47f.queue||nitobi.effects.EffectQueue.globalQueue;
this.onBeforeFinish=new nitobi.base.Event();
this.onFinish=new nitobi.base.Event();
this.onBeforeStart=new nitobi.base.Event();
};
nitobi.effects.Effect.prototype.start=function(){
var now=new Date().getTime();
this.startOn=now+this.delay*1000;
this.finishOn=this.startOn+this.duration*1000;
this.deltaTime=this.duration*1000;
this.totalFrames=this.duration*this.fps;
this.frame=0;
this.delta=this.from-this.to;
this.queue.add(this);
};
nitobi.effects.Effect.prototype.render=function(pos){
if(!this.running){
this.onBeforeStart.notify(new nitobi.base.EventArgs(this,this.onBeforeStart));
this.setup();
this.running=true;
}
this.update(this.transition(pos*this.delta+this.from));
};
nitobi.effects.Effect.prototype.step=function(now){
if(this.startOn<=now){
if(now>=this.finishOn){
this.end();
return;
}
var pos=(now-this.startOn)/(this.deltaTime);
var _484=Math.floor(pos*this.totalFrames);
if(this.frame<_484){
this.render(pos);
this.frame=_484;
}
}
};
nitobi.effects.Effect.prototype.setup=function(){
};
nitobi.effects.Effect.prototype.update=function(pos){
};
nitobi.effects.Effect.prototype.finish=function(){
};
nitobi.effects.Effect.prototype.end=function(){
this.onBeforeFinish.notify(new nitobi.base.EventArgs(this,this.onBeforeFinish));
this.cancel();
this.render(1);
this.running=false;
this.finish();
this.callback();
this.onFinish.notify(new nitobi.base.EventArgs(this,this.onAfterFinish));
};
nitobi.effects.Effect.prototype.cancel=function(){
this.queue.remove(this);
};
nitobi.effects.factory=function(_486,_487,etc){
var args=nitobi.lang.toArray(arguments,2);
return function(_48a){
var f=function(){
_486.apply(this,[_48a,_487].concat(args));
};
nitobi.lang.extend(f,_486);
return new f();
};
};
nitobi.effects.families={none:{show:null,hide:null}};
nitobi.lang.defineNs("nitobi.effects");
if(false){
nitobi.effects.Transition=function(){
};
}
nitobi.effects.Transition={};
nitobi.effects.Transition.sinoidal=function(x){
return (-Math.cos(x*Math.PI)/2)+0.5;
};
nitobi.effects.Transition.linear=function(x){
return x;
};
nitobi.effects.Transition.reverse=function(x){
return 1-x;
};
nitobi.lang.defineNs("nitobi.effects");
nitobi.effects.Scale=function(_48f,_490,_491){
nitobi.effects.Scale.baseConstructor.call(this,_48f,_490);
this.scaleX=typeof (_490.scaleX)=="boolean"?_490.scaleX:true;
this.scaleY=typeof (_490.scaleY)=="boolean"?_490.scaleY:true;
this.scaleFrom=typeof (_490.scaleFrom)=="number"?_490.scaleFrom:100;
this.scaleTo=_491;
};
nitobi.lang.extend(nitobi.effects.Scale,nitobi.effects.Effect);
nitobi.effects.Scale.prototype.setup=function(){
var _492=this.element.style;
var Css=nitobi.html.Css;
this.originalStyle={"top":_492.top,"left":_492.left,"width":_492.width,"height":_492.height,"overflow":Css.getStyle(this.element,"overflow")};
this.factor=(this.scaleTo-this.scaleFrom)/100;
this.dims=[this.element.scrollWidth,this.element.scrollHeight];
_492.width=this.dims[0]+"px";
_492.height=this.dims[1]+"px";
Css.setStyle(this.element,"overflow","hidden");
};
nitobi.effects.Scale.prototype.finish=function(){
for(var s in this.originalStyle){
this.element.style[s]=this.originalStyle[s];
}
};
nitobi.effects.Scale.prototype.update=function(pos){
var _496=(this.scaleFrom/100)+(this.factor*pos);
this.setDimensions(Math.floor(_496*this.dims[0])||1,Math.floor(_496*this.dims[1])||1);
};
nitobi.effects.Scale.prototype.setDimensions=function(x,y){
if(this.scaleX){
this.element.style.width=x+"px";
}
if(this.scaleY){
this.element.style.height=y+"px";
}
};
nitobi.lang.defineNs("nitobi.effects");
nitobi.effects.EffectQueue=function(){
nitobi.effects.EffectQueue.baseConstructor.call(this);
nitobi.collections.IEnumerable.call(this);
this.intervalId=0;
};
nitobi.lang.extend(nitobi.effects.EffectQueue,nitobi.Object);
nitobi.lang.implement(nitobi.effects.EffectQueue,nitobi.collections.IEnumerable);
nitobi.effects.EffectQueue.prototype.add=function(_499){
nitobi.collections.IEnumerable.prototype.add.call(this,_499);
if(!this.intervalId){
this.intervalId=window.setInterval(nitobi.lang.close(this,this.step),15);
}
};
nitobi.effects.EffectQueue.prototype.step=function(){
var now=new Date().getTime();
this.each(function(e){
e.step(now);
});
};
nitobi.effects.EffectQueue.globalQueue=new nitobi.effects.EffectQueue();
nitobi.lang.defineNs("nitobi.effects");
nitobi.effects.BlindUp=function(_49c,_49d){
_49d=nitobi.lang.merge({scaleX:false,duration:Math.min(0.2*(_49c.scrollHeight/100),0.5)},_49d||{});
nitobi.effects.BlindUp.baseConstructor.call(this,_49c,_49d,0);
};
nitobi.lang.extend(nitobi.effects.BlindUp,nitobi.effects.Scale);
nitobi.effects.BlindUp.prototype.setup=function(){
nitobi.effects.BlindUp.base.setup.call(this);
};
nitobi.effects.BlindUp.prototype.finish=function(){
nitobi.html.Css.addClass(this.element,NTB_CSS_HIDE);
nitobi.effects.BlindUp.base.finish.call(this);
this.element.style.height="";
};
nitobi.effects.BlindDown=function(_49e,_49f){
nitobi.html.Css.swapClass(_49e,NTB_CSS_HIDE,NTB_CSS_SMALL);
_49f=nitobi.lang.merge({scaleX:false,scaleFrom:0,duration:Math.min(0.2*(_49e.scrollHeight/100),0.5)},_49f||{});
nitobi.effects.BlindDown.baseConstructor.call(this,_49e,_49f,100);
};
nitobi.lang.extend(nitobi.effects.BlindDown,nitobi.effects.Scale);
nitobi.effects.BlindDown.prototype.setup=function(){
nitobi.effects.BlindDown.base.setup.call(this);
this.element.style.height="1px";
nitobi.html.Css.removeClass(this.element,NTB_CSS_SMALL);
};
nitobi.effects.BlindDown.prototype.finish=function(){
nitobi.effects.BlindDown.base.finish.call(this);
this.element.style.height="";
};
nitobi.effects.families.blind={show:nitobi.effects.BlindDown,hide:nitobi.effects.BlindUp};
nitobi.lang.defineNs("nitobi.effects");
nitobi.effects.ShadeUp=function(_4a0,_4a1){
_4a1=nitobi.lang.merge({scaleX:false,duration:Math.min(0.2*(_4a0.scrollHeight/100),0.3)},_4a1||{});
nitobi.effects.ShadeUp.baseConstructor.call(this,_4a0,_4a1,0);
};
nitobi.lang.extend(nitobi.effects.ShadeUp,nitobi.effects.Scale);
nitobi.effects.ShadeUp.prototype.setup=function(){
nitobi.effects.ShadeUp.base.setup.call(this);
var _4a2=nitobi.html.getFirstChild(this.element);
this.originalStyle.position=this.element.style.position;
nitobi.html.position(this.element);
if(_4a2){
var _4a3=_4a2.style;
this.fnodeStyle={position:_4a3.position,bottom:_4a3.bottom,left:_4a3.left};
this.fnode=_4a2;
_4a3.position="absolute";
_4a3.bottom="0px";
_4a3.left="0px";
_4a3.top="";
}
};
nitobi.effects.ShadeUp.prototype.finish=function(){
nitobi.effects.ShadeUp.base.finish.call(this);
nitobi.html.Css.addClass(this.element,NTB_CSS_HIDE);
this.element.style.height="";
this.element.style.position=this.originalStyle.position;
this.element.style.overflow=this.originalStyle.overflow;
for(var x in this.fnodeStyle){
this.fnode.style[x]=this.fnodeStyle[x];
}
};
nitobi.effects.ShadeDown=function(_4a5,_4a6){
nitobi.html.Css.swapClass(_4a5,NTB_CSS_HIDE,NTB_CSS_SMALL);
_4a6=nitobi.lang.merge({scaleX:false,scaleFrom:0,duration:Math.min(0.2*(_4a5.scrollHeight/100),0.3)},_4a6||{});
nitobi.effects.ShadeDown.baseConstructor.call(this,_4a5,_4a6,100);
};
nitobi.lang.extend(nitobi.effects.ShadeDown,nitobi.effects.Scale);
nitobi.effects.ShadeDown.prototype.setup=function(){
nitobi.effects.ShadeDown.base.setup.call(this);
this.element.style.height="1px";
nitobi.html.Css.removeClass(this.element,NTB_CSS_SMALL);
var _4a7=nitobi.html.getFirstChild(this.element);
this.originalStyle.position=this.element.style.position;
nitobi.html.position(this.element);
if(_4a7){
var _4a8=_4a7.style;
this.fnodeStyle={position:_4a8.position,bottom:_4a8.bottom,left:_4a8.left,right:_4a8.right,top:_4a8.top};
this.fnode=_4a7;
_4a8.position="absolute";
_4a8.top="";
_4a8.right="";
_4a8.bottom="0px";
_4a8.left="0px";
}
};
nitobi.effects.ShadeDown.prototype.finish=function(){
nitobi.effects.ShadeDown.base.finish.call(this);
this.element.style.height="";
this.element.style.position=this.originalStyle.position;
this.element.style.overflow=this.originalStyle.overflow;
for(var x in this.fnodeStyle){
this.fnode.style[x]=this.fnodeStyle[x];
}
this.fnode.style.top="0px";
this.fnode.style.left="0px";
this.fnode.style.bottom="";
this.fnode.style.right="";
return;
this.fnode.style["position"]="";
};
nitobi.effects.families.shade={show:nitobi.effects.ShadeDown,hide:nitobi.effects.ShadeUp};
nitobi.lang.defineNs("nitobi.lang");
nitobi.lang.StringBuilder=function(_4aa){
if(_4aa){
if(typeof (_4aa)==="string"){
this.strings=[_4aa];
}else{
this.strings=_4aa;
}
}else{
this.strings=new Array();
}
};
nitobi.lang.StringBuilder.prototype.append=function(_4ab){
if(_4ab){
this.strings.push(_4ab);
}
return this;
};
nitobi.lang.StringBuilder.prototype.clear=function(){
this.strings.length=0;
};
nitobi.lang.StringBuilder.prototype.toString=function(){
return this.strings.join("");
};

