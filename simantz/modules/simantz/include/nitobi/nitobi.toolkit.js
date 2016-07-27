/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
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
var _bb=xml.replace(/\n/g,"&#xa;").replace(/\&#xa;</g,"<");
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
if(_1a4.getBoundingClientRect){
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
}else{
if(document.getBoxObjectFor){
td=document.getBoxObjectFor(_1a4);
sd=document.getBoxObjectFor(_1a3);
tt=td.y;
tl=td.x;
tw=td.width;
th=td.height;
st=sd.y;
sl=sd.x;
sw=sd.width;
sh=sd.height;
}else{
td=nitobi.html.getCoords(_1a4);
sd=nitobi.html.getCoords(_1a3);
tt=td.y;
tl=td.x;
tw=td.width;
th=td.height;
st=sd.y;
sl=sd.x;
sw=sd.width;
sh=sd.height;
}
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
if(nitobi.browser.moz){
td=document.getBoxObjectFor(_1bb);
sd=document.getBoxObjectFor(_1ba);
var _1c2=parseInt(document.defaultView.getComputedStyle(_1bb,"").getPropertyValue("border-left-width"));
var _1c3=parseInt(document.defaultView.getComputedStyle(_1bb,"").getPropertyValue("border-top-width"));
var _1c4=parseInt(document.defaultView.getComputedStyle(_1ba,"").getPropertyValue("border-top-width"));
var _1c5=parseInt(document.defaultView.getComputedStyle(_1ba,"").getPropertyValue("border-bottom-width"));
var _1c6=parseInt(document.defaultView.getComputedStyle(_1ba,"").getPropertyValue("border-left-width"));
var _1c7=parseInt(document.defaultView.getComputedStyle(_1ba,"").getPropertyValue("border-right-width"));
oy=oy+_1c4-_1c3;
ox=ox+_1c6-_1c2;
}
nitobi.drawing.align(_1ba,_1bb,_1bc,oh,ow,oy,ox,show);
};
nitobi.lang.defineNs("nitobi.html");
if(false){
nitobi.html=function(){
};
}
nitobi.html.createElement=function(_1c8,_1c9,_1ca){
var elem=document.createElement(_1c8);
for(var attr in _1c9){
if(attr.toLowerCase().substring(0,5)=="class"){
elem.className=_1c9[attr];
}else{
elem.setAttribute(attr,_1c9[attr]);
}
}
for(var _1cd in _1ca){
elem.style[_1cd]=_1ca[_1cd];
}
return elem;
};
nitobi.html.createTable=function(_1ce,_1cf){
var _1d0=nitobi.html.createElement("table",_1ce,_1cf);
var _1d1=document.createElement("tbody");
var _1d2=document.createElement("tr");
var _1d3=document.createElement("td");
_1d0.appendChild(_1d1);
_1d1.appendChild(_1d2);
_1d2.appendChild(_1d3);
return _1d0;
};
nitobi.html.setBgImage=function(elem,src){
var s=nitobi.html.Css.getStyle(elem,"background-image");
if(s!=""&&nitobi.browser.IE){
s=s.replace(/(^url\(")(.*?)("\))/,"$2");
}
};
nitobi.html.fitWidth=function(_1d7,_1d8){
var w;
var C=nitobi.html.Css;
if(nitobi.browser.IE&&!nitobi.lang.isStandards()){
var _1db=(parseInt(C.getStyle(_1d7,"width"))-parseInt(C.getStyle(_1d7,"paddingLeft"))-parseInt(C.getStyle(_1d7,"paddingRight"))-parseInt(C.getStyle(_1d7,"borderLeftWidth"))-parseInt(C.getStyle(_1d7,"borderRightWidth")));
if(_1db<0){
_1db=0;
}
w=_1db+"px";
}else{
if(nitobi.lang.isStandards()){
if(nitobi.browser.IE){
var _1db=(parseInt(_1d7.clientWidth))-(_1d8.offsetWidth-_1d8.clientWidth);
}else{
var _1db=(parseInt(_1d7.style.width)-(_1d8.offsetWidth-parseInt(_1d7.style.width)));
}
if(_1db<0){
_1db=0;
}
w=_1db+"px";
}else{
w=parseInt(_1d7.style.width)+"px";
}
}
_1d8.style.width=w;
};
nitobi.html.getDomNodeByPath=function(Node,Path){
if(nitobi.browser.IE){
}
var _1de=Node;
var _1df=Path.split("/");
var len=_1df.length;
for(var i=0;i<len;i++){
if(_1de.childNodes[Number(_1df[i])]!=null){
_1de=_1de.childNodes[Number(_1df[i])];
}else{
alert("Path expression failed."+Path);
}
var s="";
}
return _1de;
};
nitobi.html.indexOfChildNode=function(_1e3,_1e4){
var _1e5=_1e3.childNodes;
for(var i=0;i<_1e5.length;i++){
if(_1e5[i]==_1e4){
return i;
}
}
return -1;
};
nitobi.html.evalScriptBlocks=function(node){
for(var i=0;i<node.childNodes.length;i++){
var _1e9=node.childNodes[i];
if(_1e9.nodeName.toLowerCase()=="script"){
eval(_1e9.text);
}else{
nitobi.html.evalScriptBlocks(_1e9);
}
}
};
nitobi.html.position=function(node){
var pos=nitobi.html.getStyle($ntb(node),"position");
if(pos=="static"){
node.style.position="relative";
}
};
nitobi.html.setOpacity=function(_1ec,_1ed){
var _1ee=_1ec.style;
_1ee.opacity=(_1ed/100);
_1ee.MozOpacity=(_1ed/100);
_1ee.KhtmlOpacity=(_1ed/100);
_1ee.filter="alpha(opacity="+_1ed+")";
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
nitobi.html.getElement=function(_1f9){
if(typeof (_1f9)=="string"){
return document.getElementById(_1f9);
}
return _1f9;
};
if(typeof ($)=="undefined"){
$=nitobi.html.getElement;
}
if(typeof ($ntb)=="undefined"){
$ntb=nitobi.html.getElement;
}
if(typeof ($F)=="undefined"){
$F=function(id){
var _1fb=$ntb(id);
if(_1fb!=null){
return _1fb.value;
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
var _204=nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-top-width"));
var _205=nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-left-width"));
var _206=nitobi.lang.parseNumber(document.body.scrollTop)-(_204==0?2:_204);
var _207=nitobi.lang.parseNumber(document.body.scrollLeft)-(_205==0?2:_205);
var rect=nitobi.html.getBoundingClientRect(elem);
return {top:rect.top+_206,left:rect.left+_207,bottom:rect.bottom,right:rect.right,height:rect.bottom-rect.top,width:rect.right-rect.left};
};
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
nitobi.html.getBox=function(elem){
var _20a=nitobi.html.getCoords(elem);
return {top:_20a.y,left:_20a.x,bottom:_20a.y+_20a.height,right:_20a.x+_20a.width,height:_20a.height,width:_20a.width};
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
nitobi.html.getChildNodeById=function(elem,_20e,_20f){
return nitobi.html.getChildNodeByAttribute(elem,"id",_20e,_20f);
};
nitobi.html.getChildNodeByAttribute=function(elem,_211,_212,_213){
for(var i=0;i<elem.childNodes.length;i++){
if(elem.nodeType!=3&&Boolean(elem.childNodes[i].getAttribute)){
if(elem.childNodes[i].getAttribute(_211)==_212){
return elem.childNodes[i];
}
}
}
if(_213){
for(var i=0;i<elem.childNodes.length;i++){
var _215=nitobi.html.getChildNodeByAttribute(elem.childNodes[i],_211,_212,_213);
if(_215!=null){
return _215;
}
}
}
return null;
};
nitobi.html.getParentNodeById=function(elem,_217){
return nitobi.html.getParentNodeByAtt(elem,"id",_217);
};
nitobi.html.getParentNodeByAtt=function(elem,att,_21a){
while(elem.parentNode!=null){
if(elem.parentNode.getAttribute(att)==_21a){
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
var _21e,_21f=0;
if((nitobi.browser.OPERA==false)&&(document.documentElement.scrollTop>0)){
_21e=document.documentElement.scrollTop;
_21f=document.documentElement.scrollLeft;
}else{
_21e=document.body.scrollTop;
_21f=document.body.scrollLeft;
}
if(((_21e==0)&&(document.documentElement.scrollTop>0))||((_21f==0)&&(document.documentElement.scrollLeft>0))){
_21e=document.documentElement.scrollTop;
_21f=document.documentElement.scrollLeft;
}
return {"left":_21f,"top":_21e};
};
nitobi.html.getCoords=function(_220){
var ew,eh;
try{
var _223=_220;
ew=_220.offsetWidth;
eh=_220.offsetHeight;
for(var lx=0,ly=0;_220!=null;lx+=_220.offsetLeft,ly+=_220.offsetTop,_220=_220.offsetParent){
}
for(;_223!=document.body;lx-=_223.scrollLeft,ly-=_223.scrollTop,_223=_223.parentNode){
}
}
catch(e){
}
return {"x":lx,"y":ly,"height":eh,"width":ew};
};
nitobi.html.scrollBarWidth=0;
nitobi.html.getScrollBarWidth=function(_226){
if(nitobi.html.scrollBarWidth){
return nitobi.html.scrollBarWidth;
}
try{
if(null==_226){
var _227="ntb-scrollbar-width";
var d=document.getElementById(_227);
if(null==d){
d=nitobi.html.createElement("div",{"id":_227},{width:"100px",height:"100px",overflow:"auto",position:"absolute",top:"-200px",left:"-5000px"});
d.innerHTML="<div style='height:200px;'></div>";
document.body.appendChild(d);
}
_226=d;
}
if(nitobi.browser.IE||nitobi.browser.MOZ){
nitobi.html.scrollBarWidth=Math.abs(_226.offsetWidth-_226.clientWidth-(_226.clientLeft?_226.clientLeft*2:0));
}else{
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
var b=nitobi.html.getBox(_226);
nitobi.html.scrollBarWidth=Math.abs((b.width-_226.clientWidth));
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
var _22a,_22b,_22c,_22d;
var x,y;
var _230=false;
if(nitobi.lang.isStandards()){
_230=true;
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
_22c=x;
_22d=y;
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
_22a=x;
_22b=y;
var _233=db.scrollHeight;
var _234=db.offsetHeight;
if(_233>_234){
x=db.scrollWidth;
y=db.scrollHeight;
}else{
x=db.offsetWidth;
y=db.offsetHeight;
}
nitobi.html.permHeight=y;
nitobi.html.permWidth=x;
if(nitobi.html.permHeight<_22d){
nitobi.html.permHeight=_22d;
if(nitobi.browser.IE&&_230){
_22c+=20;
}
}
if(_22c<nitobi.html.permWidth){
_22c=nitobi.html.permWidth;
}
if(nitobi.html.permHeight>_22d){
_22c+=20;
}
var _235,_236;
_235=de.scrollHeight;
_236=de.scrollWidth;
return {scrollWidth:_236,scrollHeight:_235,scrollLeft:_22a,scrollTop:_22b,clientWidth:_22c,clientHeight:_22d,bodyWidth:nitobi.html.permWidth,bodyHeight:nitobi.html.PermHeight};
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
var _23a=node.attributes[a].nodeValue;
}
}
html+=">";
html+=_23a;
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
nitobi.html.insertAdjacentText=function(_23b,pos,s){
if(nitobi.browser.IE){
return _23b.insertAdjacentText(pos,s);
}
var node=document.createTextNode(s);
nitobi.html.insertAdjacentElement(_23b,pos,node);
};
nitobi.html.insertAdjacentHTML=function(_23f,_240,_241,_242){
if(nitobi.browser.IE){
return _23f.insertAdjacentHTML(_240,_241,_242);
}
var df;
var r=_23f.ownerDocument.createRange();
switch(String(_240).toLowerCase()){
case "beforebegin":
r.setStartBefore(_23f);
df=r.createContextualFragment(_241);
_23f.parentNode.insertBefore(df,_23f);
break;
case "afterbegin":
r.selectNodeContents(_23f);
r.collapse(true);
df=r.createContextualFragment(_241);
_23f.insertBefore(df,_23f.firstChild);
break;
case "beforeend":
if(_242==true){
_23f.innerHTML=_23f.innerHTML+_241;
}else{
r.selectNodeContents(_23f);
r.collapse(false);
df=r.createContextualFragment(_241);
_23f.appendChild(df);
}
break;
case "afterend":
r.setStartAfter(_23f);
df=r.createContextualFragment(_241);
_23f.parentNode.insertBefore(df,_23f.nextSibling);
break;
}
};
nitobi.html.insertAdjacentElement=function(_245,pos,node){
if(nitobi.browser.IE){
return _245.insertAdjacentElement(pos,node);
}
switch(pos){
case "beforeBegin":
_245.parentNode.insertBefore(node,_245);
break;
case "afterBegin":
_245.insertBefore(node,_245.firstChild);
break;
case "beforeEnd":
_245.appendChild(node);
break;
case "afterEnd":
if(_245.nextSibling){
_245.parentNode.insertBefore(node,_245.nextSibling);
}else{
_245.parentNode.appendChild(node);
}
break;
}
};
nitobi.html.getClientRects=function(node,_249,_24a){
if(nitobi.browser.IE||nitobi.browser.MOZ){
return node.getClientRects();
}
_249=_249||0;
_24a=_24a||0;
var td;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
td=nitobi.html.getCoords(node);
_249=0;
_24a=0;
}else{
var td=document.getBoxObjectFor(node);
}
return new Array({top:(td.y-_249),left:(td.x-_24a),bottom:(td.y+td.height-_249),right:(td.x+td.width-_24a)});
};
nitobi.html.getBoundingClientRect=function(node,_24d,_24e){
if(node.getBoundingClientRect){
return node.getBoundingClientRect();
}
_24d=_24d||0;
_24e=_24e||0;
var td;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
td=nitobi.html.getCoords(node);
_24d=0;
_24e=0;
}else{
td=document.getBoxObjectFor(node);
}
var top=td.y-_24d;
var left=td.x-_24e;
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
nitobi.html.attachEvents=function(_252,_253,_254){
var _255=[];
for(var i=0;i<_253.length;i++){
var e=_253[i];
_255.push(nitobi.html.attachEvent(_252,e.type,e.handler,_254,e.capture||false));
}
return _255;
};
nitobi.html.attachEvent=function(_258,type,_25a,_25b,_25c,_25d){
if(type=="anyclick"){
if(nitobi.browser.IE){
nitobi.html.attachEvent(_258,"dblclick",_25a,_25b,_25c,_25d);
}
type="click";
}
if(!(_25a instanceof Function)){
nitobi.lang.throwError("Event handler needs to be a Function");
}
_258=$ntb(_258);
if(type.toLowerCase()=="unload"&&_25d!=true){
var _25e=_25a;
if(_25b!=null){
_25e=function(){
_25a.call(_25b);
};
}
return this.addUnload(_25e);
}
var _25f=this.handlerId++;
var _260=this.elementId++;
if(typeof (_25a.ebaguid)!="undefined"){
_25f=_25a.ebaguid;
}else{
_25a.ebaguid=_25f;
}
if(typeof (_258.ebaguid)=="undefined"){
_258.ebaguid=_260;
nitobi.html.elements[_260]=_258;
}
if(typeof (_258.eba_events)=="undefined"){
_258.eba_events={};
}
if(_258.eba_events[type]==null){
_258.eba_events[type]={};
if(_258.attachEvent){
_258["eba_event_"+type]=function(){
nitobi.html.notify.call(_258,window.event);
};
_258.attachEvent("on"+type,_258["eba_event_"+type]);
if(_25c&&_258.setCapture!=null){
_258.setCapture(true);
}
}else{
if(_258.addEventListener){
_258["eba_event_"+type]=function(){
nitobi.html.notify.call(_258,arguments[0]);
};
_258.addEventListener(type,_258["eba_event_"+type],_25c);
}
}
}
_258.eba_events[type][_25f]={handler:_25a,context:_25b};
return _25f;
};
nitobi.html.notify=function(e){
if(!nitobi.browser.IE){
e.srcElement=e.target;
e.fromElement=e.relatedTarget;
e.toElement=e.relatedTarget;
}
var _262=this;
e.eventSrc=_262;
nitobi.html.Event=e;
for(var _263 in _262.eba_events[e.type]){
var _264=_262.eba_events[e.type][_263];
if(typeof (_264.context)=="object"){
_264.handler.call(_264.context,e,_262);
}else{
_264.handler.call(_262,e,_262);
}
}
};
nitobi.html.detachEvents=function(_265,_266){
for(var i=0;i<_266.length;i++){
var e=_266[i];
nitobi.html.detachEvent(_265,e.type,e.handler);
}
};
nitobi.html.detachEvent=function(_269,type,_26b){
_269=$ntb(_269);
var _26c=_26b;
if(_26b instanceof Function){
_26c=_26b.ebaguid;
}
if(type=="unload"){
this.unload.splice(ebaguid,1);
}
if(_269!=null&&_269.eba_events!=null&&_269.eba_events[type]!=null&&_269.eba_events[type][_26c]!=null){
var _26d=_269.eba_events[type];
_26d[_26c]=null;
delete _26d[_26c];
if(nitobi.collections.isHashEmpty(_26d)){
this.m_detach(_269,type,_269["eba_event_"+type]);
_269["eba_event_"+type]=null;
_269.eba_events[type]=null;
_26d=null;
if(_269.nodeType==1){
_269.removeAttribute("eba_event_"+type);
}
}
}
return true;
};
nitobi.html.m_detach=function(_26e,type,_270){
if(_270!=null&&_270 instanceof Function){
if(_26e.detachEvent){
_26e.detachEvent("on"+type,_270);
}else{
if(_26e.removeEventListener){
_26e.removeEventListener(type,_270,false);
}
}
_26e["on"+type]=null;
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
for(var _274 in nitobi.html.elements[i].eba_events){
nitobi.html.m_detach(nitobi.html.elements[i],_274,nitobi.html.elements[i]["eba_event_"+_274]);
if(typeof (nitobi.html.elements[i])!="undefined"&&nitobi.html.elements[i].eba_events[_274]!=null){
for(var _275 in nitobi.html.elements[i].eba_events[_274]){
nitobi.html.elements[i].eba_events[_274][_275]=null;
}
}
nitobi.html.elements[i]["eba_event_"+_274]=null;
}
}
}
nitobi.html.elements=null;
};
nitobi.html.addUnload=function(_276){
this.unload.push(_276);
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
var _27c={"x":evt.clientX,"y":evt.clientY};
if(nitobi.browser.IE){
_27c.x+=document.documentElement.scrollLeft+document.body.scrollLeft;
_27c.y+=document.documentElement.scrollTop+document.body.scrollTop;
}else{
_27c.x+=window.scrollX;
_27c.y+=window.scrollY;
}
return _27c;
};
nitobi.html.getEvent=function(_27d){
if(nitobi.browser.IE){
return window.event;
}else{
_27d.srcElement=_27d.target;
_27d.fromElement=_27d.relatedTarget;
_27d.toElement=_27d.relatedTarget;
return _27d;
}
};
nitobi.html.createEvent=function(_27e,_27f,_280,_281){
if(nitobi.browser.IE){
_280.target.fireEvent("on"+_27f);
}else{
var _282=document.createEvent(_27e);
_282.initKeyEvent(_27f,true,true,document.defaultView,_280.ctrlKey,_280.altKey,_280.shiftKey,_280.metaKey,_281.keyCode,_281.charCode);
_280.target.dispatchEvent(_282);
}
};
nitobi.html.unloadEventId=nitobi.html.attachEvent(window,"unload",nitobi.html.detachAllEvents,nitobi.html,false,true);
nitobi.lang.defineNs("nitobi.event");
nitobi.event=function(){
};
nitobi.event.keys={};
nitobi.event.guid=0;
nitobi.event.subscribe=function(key,_284){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
nitobi.event.publish(key);
var guid=this.guid++;
this.keys[key].add(_284,guid);
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
nitobi.event.evaluate=function(func,_289){
var _28a=true;
if(typeof func=="string"){
func=func.replace(/eventArgs/gi,"arguments[1]");
var _28b=eval(func);
_28a=(typeof (_28b)=="undefined"?true:_28b);
}
return _28a;
};
nitobi.event.publish=function(key){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
if(this.keys[key]==null){
this.keys[key]=new nitobi.event.Key();
}
};
nitobi.event.notify=function(key,_28e){
ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was "+key);
if(this.keys[key]!=null){
return this.keys[key].notify(_28e);
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
nitobi.event.Key.prototype.add=function(_290,guid){
ntbAssert(_290 instanceof Function,"EventKey.add requires a JavaScript function pointer as a parameter.","",EBA_THROW);
this.handlers[guid]=_290;
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
nitobi.event.Key.prototype.notify=function(_295){
var fail=false;
for(var item in this.handlers){
var _298=this.handlers[item];
if(_298 instanceof Function){
var rv=(_298.apply(this,arguments)==false);
fail=fail||rv;
}else{
}
}
return !fail;
};
nitobi.event.Key.prototype.dispose=function(){
for(var _29a in this.handlers){
this.handlers[_29a]=null;
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
nitobi.collections.IEnumerable.prototype.insert=function(_29d,obj){
this.list.splice(_29d,0,obj);
this.length++;
};
nitobi.collections.IEnumerable.createNewArray=function(obj,_2a0){
var _2a1;
_2a0=_2a0||0;
if(obj.count){
_2a1=obj.count;
}
if(obj.length){
_2a1=obj.length;
}
var x=new Array(_2a1-_2a0);
for(var i=_2a0;i<_2a1;i++){
x[i-_2a0]=obj[i];
}
return x;
};
nitobi.collections.IEnumerable.prototype.get=function(_2a4){
if(_2a4<0||_2a4>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
return this.list[_2a4];
};
nitobi.collections.IEnumerable.prototype.set=function(_2a5,_2a6){
if(_2a5<0||_2a5>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
this.list[_2a5]=_2a6;
};
nitobi.collections.IEnumerable.prototype.indexOf=function(obj){
for(var i=0;i<this.getLength();i++){
if(this.list[i]===obj){
return i;
}
}
return -1;
};
nitobi.collections.IEnumerable.prototype.remove=function(_2a9){
var i;
if(typeof (_2a9)!="number"){
i=this.indexOf(_2a9);
}else{
i=_2a9;
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
nitobi.base.ISerializable=function(_2af,id,xml,_2b2){
nitobi.Object.call(this);
if(typeof (this.ISerializableInitialized)=="undefined"){
this.ISerializableInitialized=true;
}else{
return;
}
this.xmlNode=null;
this.setXmlNode(_2af);
if(_2af!=null){
this.profile=nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:_2af.nodeName});
}else{
this.profile=nitobi.base.Registry.getInstance().getProfileByInstance(this);
}
this.onDeserialize=new nitobi.base.Event();
this.onSetParentObject=new nitobi.base.Event();
this.factory=nitobi.base.Factory.getInstance();
this.objectHash={};
this.onCreateObject=new nitobi.base.Event();
if(_2af!=null){
this.deserializeFromXmlNode(this.getXmlNode());
}else{
if(this.factory!=null&&this.profile.tagName!=null){
this.createByProfile(this.profile,this.getXmlNode());
}else{
if(xml!=null&&_2af!=null){
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
nitobi.base.ISerializable.prototype.createByProfile=function(_2b3,_2b4){
if(_2b4==null){
var xml="<"+_2b3.tagName+" xmlns:"+nitobi.base.XmlNamespace.prefix+"=\""+nitobi.base.XmlNamespace.uri+"\" />";
var _2b6=nitobi.xml.createXmlDoc(xml);
this.setXmlNode(_2b6.firstChild);
this.deserializeFromXmlNode(this.xmlNode);
}else{
this.deserializeFromXmlNode(_2b4);
this.setXmlNode(_2b4);
}
};
nitobi.base.ISerializable.prototype.createByXml=function(xml){
this.deserializeFromXml(xml);
};
nitobi.base.ISerializable.prototype.getParentObject=function(){
return this.parentObj;
};
nitobi.base.ISerializable.prototype.setParentObject=function(_2b8){
this.parentObj=_2b8;
this.onSetParentObject.notify();
};
nitobi.base.ISerializable.prototype.addChildObject=function(_2b9){
this.addToCache(_2b9);
_2b9.setParentObject(this);
var _2ba=_2b9.getXmlNode();
if(!this.areGuidsGenerated(_2ba)){
_2ba=this.generateGuids(_2ba);
_2b9.setXmlNode(_2ba);
}
_2b9.setXmlNode(this.xmlNode.appendChild(nitobi.xml.importNode(this.xmlNode.ownerDocument,_2ba,true)));
};
nitobi.base.ISerializable.prototype.insertBeforeChildObject=function(obj,_2bc){
_2bc=_2bc?_2bc.getXmlNode():null;
this.addToCache(obj);
obj.setParentObject(this);
var _2bd=obj.getXmlNode();
if(!this.areGuidsGenerated(_2bd)){
_2bd=this.generateGuids(_2bd);
obj.setXmlNode(_2bd);
}
_2bd=nitobi.xml.importNode(this.xmlNode.ownerDocument,_2bd,true);
this.xmlNode.insertBefore(_2bd,_2bc);
};
nitobi.base.ISerializable.prototype.createElement=function(name){
var _2bf;
if(this.xmlNode==null||this.xmlNode.ownerDocument==null){
_2bf=nitobi.xml.createXmlDoc();
}else{
_2bf=this.xmlNode.ownerDocument;
}
if(nitobi.browser.IE){
return _2bf.createNode(1,name,nitobi.base.XmlNamespace.uri);
}else{
if(_2bf.createElementNS){
return _2bf.createElementNS(nitobi.base.XmlNamespace.uri,name);
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
nitobi.base.ISerializable.prototype.areGuidsGenerated=function(_2c5){
if(_2c5==null||_2c5.ownerDocument==null){
return false;
}
if(nitobi.browser.IE){
var node=_2c5.ownerDocument.documentElement;
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
return (_2c5.ownerDocument.generatedGuids==true);
}
};
nitobi.base.ISerializable.prototype.setGuidsGenerated=function(_2c8,_2c9){
if(_2c8==null||_2c8.ownerDocument==null){
return;
}
if(nitobi.browser.IE){
var node=_2c8.ownerDocument.documentElement;
if(node!=null){
var id=node.getAttribute("id");
if(id!=null&&id!=""){
nitobi.base.ISerializable.guidMap[id]=true;
}
}
}else{
_2c8.ownerDocument.generatedGuids=true;
}
};
nitobi.base.ISerializable.prototype.generateGuids=function(_2cc){
nitobi.base.uniqueIdGeneratorProc.addParameter("guid",nitobi.component.getUniqueId(),"");
var doc=nitobi.xml.transformToXml(_2cc,nitobi.base.uniqueIdGeneratorProc);
this.saveDocument=doc;
this.setGuidsGenerated(doc.documentElement,true);
return doc.documentElement;
};
nitobi.base.ISerializable.prototype.deserializeFromXmlNode=function(_2ce){
if(!this.areGuidsGenerated(_2ce)){
_2ce=this.generateGuids(_2ce);
}
this.setXmlNode(_2ce);
this.flushCache();
if(this.profile==null){
this.profile=nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:_2ce.nodeName});
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
var _2d4=this.getElement(id);
if(_2d4==null){
return null;
}else{
obj=this.factory.createByNode(_2d4);
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
nitobi.base.ISerializable.prototype.setFactory=function(_2d8){
this.factory=factory;
};
nitobi.base.ISerializable.prototype.getXmlNode=function(){
return this.xmlNode;
};
nitobi.base.ISerializable.prototype.setXmlNode=function(_2d9){
if(nitobi.lang.typeOf(_2d9)==nitobi.lang.type.XMLDOC&&_2d9!=null){
this.ownerDocument=_2d9;
_2d9=nitobi.html.getFirstChild(_2d9);
}else{
if(_2d9!=null){
this.ownerDocument=_2d9.ownerDocument;
}
}
if(_2d9!=null&&nitobi.browser.MOZ&&_2d9.ownerDocument==null){
nitobi.lang.throwError(nitobi.error.OrphanXmlNode+" ISerializable.setXmlNode");
}
this.xmlNode=_2d9;
};
nitobi.base.ISerializable.prototype.serializeToXml=function(){
return nitobi.xml.serialize(this.xmlNode);
};
nitobi.base.ISerializable.prototype.getAttribute=function(name,_2db){
if(this[name]!=null){
return this[name];
}
var _2dc=this.xmlNode.getAttribute(name);
return _2dc===null?_2db:_2dc;
};
nitobi.base.ISerializable.prototype.setAttribute=function(name,_2de){
this[name]=_2de;
this.xmlNode.setAttribute(name.toLowerCase(),_2de!=null?_2de.toString():"");
};
nitobi.base.ISerializable.prototype.setIntAttribute=function(name,_2e0){
var n=parseInt(_2e0);
if(_2e0!=null&&(typeof (n)!="number"||isNaN(n))){
nitobi.lang.throwError(name+" is not an integer and therefore cannot be set. It's value was "+_2e0);
}
this.setAttribute(name,_2e0);
};
nitobi.base.ISerializable.prototype.getIntAttribute=function(name,_2e3){
var x=this.getAttribute(name,_2e3);
if(x==null||x==""){
return 0;
}
var tx=parseInt(x);
if(isNaN(tx)){
nitobi.lang.throwError("ISerializable attempting to get "+name+" which was supposed to be an int but was actually NaN");
}
return tx;
};
nitobi.base.ISerializable.prototype.setBoolAttribute=function(name,_2e7){
_2e7=nitobi.lang.getBool(_2e7);
if(_2e7!=null&&typeof (_2e7)!="boolean"){
nitobi.lang.throwError(name+" is not an boolean and therefore cannot be set. It's value was "+_2e7);
}
this.setAttribute(name,(_2e7?"true":"false"));
};
nitobi.base.ISerializable.prototype.getBoolAttribute=function(name,_2e9){
var x=this.getAttribute(name,_2e9);
if(typeof (x)=="string"&&x==""){
return null;
}
var tx=nitobi.lang.getBool(x);
if(tx==null){
nitobi.lang.throwError("ISerializable attempting to get "+name+" which was supposed to be a bool but was actually "+x);
}
return tx;
};
nitobi.base.ISerializable.prototype.setDateAttribute=function(name,_2ed){
this.setAttribute(name,_2ed);
};
nitobi.base.ISerializable.prototype.getDateAttribute=function(name,_2ef){
if(this[name]){
return this[name];
}
var _2f0=this.getAttribute(name,_2ef);
return _2f0?new Date(_2f0):null;
};
nitobi.base.ISerializable.prototype.getId=function(){
return this.getAttribute("id");
};
nitobi.base.ISerializable.prototype.getChildObjectId=function(_2f1,_2f2){
var _2f3=(typeof (_2f1.className)=="string"?_2f1.tagName:_2f1.getXmlNode().nodeName);
var _2f4=_2f3;
if(_2f2){
_2f4+="[@instancename='"+_2f2+"']";
}
var node=this.getXmlNode().selectSingleNode(_2f4);
if(null==node){
return null;
}else{
return node.getAttribute("id");
}
};
nitobi.base.ISerializable.prototype.setObject=function(_2f6,_2f7){
if(_2f6.ISerializableImplemented!=true){
nitobi.lang.throwError(nitobi.error.ExpectedInterfaceNotFound+" ISerializable");
}
var id=this.getChildObjectId(_2f6,_2f7);
if(null!=id){
this.deleteChildObject(id);
}
if(_2f7){
_2f6.setAttribute("instancename",_2f7);
}
this.addChildObject(_2f6);
};
nitobi.base.ISerializable.prototype.getObject=function(_2f9,_2fa){
var id=this.getChildObjectId(_2f9,_2fa);
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
var _2ff=node.selectSingleNode("//*[@id='"+id+"']");
return (_2ff!=null);
};
nitobi.base.ISerializable.prototype.getPathToLeaf=function(id){
var node=this.getXmlNode();
var _302=node.selectSingleNode("//*[@id='"+id+"']");
if(nitobi.browser.IE){
_302.ownerDocument.setProperty("SelectionLanguage","XPath");
}
var _303=_302.selectNodes("./ancestor-or-self::*");
var _304=this.getId();
var _305=0;
for(var i=0;i<_303.length;i++){
if(_303[i].getAttribute("id")==_304){
_305=i+1;
break;
}
}
var arr=nitobi.collections.IEnumerable.createNewArray(_303,_305);
return arr.reverse();
};
nitobi.base.ISerializable.prototype.isDescendantInstantiated=function(id){
var node=this.getXmlNode();
var _30a=node.selectSingleNode("//*[@id='"+id+"']");
if(nitobi.browser.IE){
_30a.ownerDocument.setProperty("SelectionLanguage","XPath");
}
var _30b=_30a.selectNodes("ancestor::*");
var _30c=false;
var obj=this;
for(var i=0;i<_30b.length;i++){
if(_30c){
var _30f=_30b[i].getAttribute("id");
instantiated=obj.inCache(_30f);
if(!instantiated){
return false;
}
obj=this.getObjectById(_30f);
}
if(_30b[i].getAttribute("id")==this.getId()){
_30c=true;
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
nitobi.base.Registry.prototype.getProfileByClass=function(_310){
return this.classMap[_310];
};
nitobi.base.Registry.prototype.getProfileByInstance=function(_311){
var _312=nitobi.lang.getFirstFunction(_311);
var p=_312.value.prototype;
var _314=null;
var _315=0;
for(var _316 in this.classMap){
var _317=this.classMap[_316].classObject;
var _318=0;
while(_317&&_311 instanceof _317){
_317=_317.baseConstructor;
_318++;
}
if(_318>_315){
_315=_318;
_314=_316;
}
}
if(_314){
return this.getProfileByClass(_314);
}else{
return null;
}
};
nitobi.base.Registry.prototype.getProfileByTag=function(_319){
return this.tagMap[_319];
};
nitobi.base.Registry.prototype.getCompleteProfile=function(_31a){
if(nitobi.lang.isDefined(_31a.className)&&_31a.className!=null){
return this.classMap[_31a.className];
}
if(nitobi.lang.isDefined(_31a.tagName)&&_31a.tagName!=null){
return this.tagMap[_31a.tagName];
}
nitobi.lang.throwError("A complete class profile could not be found. Insufficient information was provided.");
};
nitobi.base.Registry.prototype.register=function(_31b){
if(!nitobi.lang.isDefined(_31b.tagName)||null==_31b.tagName){
nitobi.lang.throwError("Illegal to register a class without a tagName.");
}
if(!nitobi.lang.isDefined(_31b.className)||null==_31b.className){
nitobi.lang.throwError("Illegal to register a class without a className.");
}
this.tagMap[_31b.tagName]=_31b;
this.classMap[_31b.className]=_31b;
};
}
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Factory=function(){
this.registry=nitobi.base.Registry.getInstance();
};
nitobi.lang.extend(nitobi.base.Factory,nitobi.Object);
nitobi.base.Factory.instance=null;
nitobi.base.Factory.prototype.createByClass=function(_31c){
try{
return nitobi.lang.newObject(_31c,arguments,1);
}
catch(err){
nitobi.lang.throwError("The Factory (createByClass) could not create the class "+_31c+".",err);
}
};
nitobi.base.Factory.prototype.createByNode=function(_31d){
try{
if(null==_31d){
nitobi.lang.throwError(nitobi.error.ArgExpected);
}
if(nitobi.lang.typeOf(_31d)==nitobi.lang.type.XMLDOC){
_31d=nitobi.xml.getChildNodes(_31d)[0];
}
var _31e=this.registry.getProfileByTag(_31d.nodeName).className;
var _31f=_31d.ownerDocument;
var _320=Array.prototype.slice.call(arguments,0);
var obj=nitobi.lang.newObject(_31e,_320,0);
return obj;
}
catch(err){
nitobi.lang.throwError("The Factory (createByNode) could not create the class "+_31e+".",err);
}
};
nitobi.base.Factory.prototype.createByProfile=function(_322){
try{
return nitobi.lang.newObject(_322.className,arguments,1);
}
catch(err){
nitobi.lang.throwError("The Factory (createByProfile) could not create the class "+_322.className+".",err);
}
};
nitobi.base.Factory.prototype.createByTag=function(_323){
var _324=this.registry.getProfileByTag(_323).className;
var _325=Array.prototype.slice.call(arguments,0);
return nitobi.lang.newObject(_324,_325,1);
};
nitobi.base.Factory.getInstance=function(){
if(nitobi.base.Factory.instance==null){
nitobi.base.Factory.instance=new nitobi.base.Factory();
}
return nitobi.base.Factory.instance;
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Profile=function(_326,_327,_328,_329,_32a){
this.className=_326;
this.classObject=eval(_326);
this.schema=_327;
this.singleton=_328;
this.tagName=_329;
this.idField=_32a||"id";
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.Declaration=function(){
nitobi.base.Declaration.baseConstructor.call(this);
this.xmlDoc=null;
};
nitobi.lang.extend(nitobi.base.Declaration,nitobi.Object);
nitobi.base.Declaration.prototype.loadHtml=function(_32b){
try{
_32b=$ntb(_32b);
this.xmlDoc=nitobi.xml.parseHtml(_32b);
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
nitobi.base.DateMath._add=function(date,unit,_32e){
if(unit==this.DAY){
date.setDate(date.getDate()+_32e);
}else{
if(unit==this.WEEK){
date.setDate(date.getDate()+7*_32e);
}else{
if(unit==this.MONTH){
date.setMonth(date.getMonth()+_32e);
}else{
if(unit==this.YEAR){
date.setFullYear(date.getFullYear()+_32e);
}
}
}
}
return date;
};
nitobi.base.DateMath.add=function(date,unit,_331){
return this._add(date,unit,_331);
};
nitobi.base.DateMath.subtract=function(date,unit,_334){
return this._add(date,unit,-1*_334);
};
nitobi.base.DateMath.after=function(date,_336){
return (date-_336)>0;
};
nitobi.base.DateMath.between=function(date,_338,end){
return (date-_338)>=0&&(end-date)>=0;
};
nitobi.base.DateMath.before=function(date,_33b){
return (date-_33b)<0;
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
var _347=this.resetTime(new Date());
var end=this.add(this.clone(_347),this.DAY,1);
return this.between(date,_347,end);
};
nitobi.base.DateMath.isSameDay=function(date,_34a){
date=this.resetTime(this.clone(date));
_34a=this.resetTime(this.clone(_34a));
return date.valueOf()==_34a.valueOf();
};
nitobi.base.DateMath.parse=function(str){
};
nitobi.base.DateMath.getWeekNumber=function(date){
var _34d=this.getJanuary1st(date);
return Math.ceil(this.getNumberOfDays(_34d,date)/7);
};
nitobi.base.DateMath.getNumberOfDays=function(_34e,end){
var _350=this.resetTime(this.clone(end)).getTime()-this.resetTime(this.clone(_34e)).getTime();
return Math.round(_350/this.ONE_DAY_MS)+1;
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
return date.getFullYear()+"-"+pz(date.getMonth()+1)+"-"+pz(date.getDate());
};
nitobi.base.DateMath.invalid=function(date){
return (!date)||(date.toString()=="Invalid Date");
};
nitobi.lang.defineNs("nitobi.base");
nitobi.base.EventArgs=function(_357,_358){
this.source=_357;
this.event=_358||nitobi.html.Event;
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
nitobi.collections.IList.prototype.insert=function(_35a,obj){
var _35c=this.get(_35a);
nitobi.collections.IEnumerable.prototype.insert.call(this,_35a,obj);
if(obj.ISerializableImplemented==true&&obj.profile!=null){
this.insertBeforeChildObject(obj,_35c);
}
};
nitobi.collections.IList.prototype.addToCache=function(obj,_35e){
nitobi.base.ISerializable.prototype.addToCache.call(this,obj);
this.list[_35e]=obj;
};
nitobi.collections.IList.prototype.removeFromCache=function(_35f){
nitobi.base.ISerializable.prototype.removeFromCache.call(this,this.list[_35f].getId());
};
nitobi.collections.IList.prototype.flushCache=function(){
nitobi.base.ISerializable.prototype.flushCache.call(this);
this.list=new Array();
};
nitobi.collections.IList.prototype.get=function(_360){
if(typeof (_360)=="object"){
return _360;
}
if(_360<0||_360>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
var obj=null;
if(this.list[_360]!=null){
obj=this.list[_360];
}
if(obj==null){
var _362=nitobi.xml.getChildNodes(this.xmlNode)[_360];
if(_362==null){
return null;
}else{
obj=this.factory.createByNode(_362);
this.onCreateObject.notify(obj);
nitobi.collections.IList.prototype.addToCache.call(this,obj,_360);
}
obj.setParentObject(this);
}
return obj;
};
nitobi.collections.IList.prototype.getById=function(id){
var node=this.xmlNode.selectSingleNode("*[@id='"+id+"']");
var _365=nitobi.xml.indexOfChildNode(node.parentNode,node);
return this.get(_365);
};
nitobi.collections.IList.prototype.set=function(_366,_367){
if(_366<0||_366>=this.getLength()){
nitobi.lang.throwError(nitobi.error.OutOfBounds);
}
try{
if(_367.ISerializableImplemented==true){
var obj=this.get(_366);
if(obj.getXmlNode()!=_367.getXmlNode()){
var _369=this.xmlNode.insertBefore(_367.getXmlNode(),obj.getXmlNode());
this.xmlNode.removeChild(obj.getXmlNode());
obj.setXmlNode(_369);
}
}
_367.setParentObject(this);
nitobi.collections.IList.prototype.addToCache.call(this,_367,_366);
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected,err);
}
};
nitobi.collections.IList.prototype.remove=function(_36a){
var i;
if(typeof (_36a)!="number"){
i=this.indexOf(_36a);
}else{
i=_36a;
}
var obj=this.get(i);
nitobi.collections.IEnumerable.prototype.remove.call(this,_36a);
this.xmlNode.removeChild(obj.getXmlNode());
};
nitobi.collections.IList.prototype.getLength=function(){
return nitobi.xml.getChildNodes(this.xmlNode).length;
};
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.List=function(_36d){
nitobi.collections.List.baseConstructor.call(this);
nitobi.collections.IList.call(this);
};
nitobi.lang.extend(nitobi.collections.List,nitobi.Object);
nitobi.lang.implement(nitobi.collections.List,nitobi.collections.IList);
nitobi.base.Registry.getInstance().register(new nitobi.base.Profile("nitobi.collections.List",null,false,"ntb:list"));
nitobi.lang.defineNs("nitobi.collections");
nitobi.collections.isHashEmpty=function(hash){
var _36f=true;
for(var item in hash){
if(hash[item]!=null&&hash[item]!=""){
_36f=false;
break;
}
}
return _36f;
};
nitobi.collections.hashLength=function(hash){
var _372=0;
for(var item in hash){
_372++;
}
return _372;
};
nitobi.collections.serialize=function(hash){
var s="";
for(var item in hash){
var _377=hash[item];
var type=typeof (_377);
if(type=="string"||type=="number"){
s+="'"+item+"':'"+_377+"',";
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
nitobi.ui.setWaitScreen=function(_379){
if(_379){
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
nitobi.ui.IStyleable=function(_37c){
this.htmlNode=_37c||null;
this.onBeforeSetStyle=new nitobi.base.Event();
this.onSetStyle=new nitobi.base.Event();
};
nitobi.ui.IStyleable.prototype.getHtmlNode=function(){
return this.htmlNode;
};
nitobi.ui.IStyleable.prototype.setHtmlNode=function(node){
this.htmlNode=node;
};
nitobi.ui.IStyleable.prototype.setStyle=function(name,_37f){
if(this.onBeforeSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onBeforeSetStyle,name,_37f))&&this.getHtmlNode()!=null){
nitobi.html.Css.setStyle(this.getHtmlNode(),name,_37f);
this.onSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onSetStyle,name,_37f));
}
};
nitobi.ui.IStyleable.prototype.getStyle=function(name){
return nitobi.html.Css.getStyle(this.getHtmlNode(),name);
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.StyleEventArgs=function(_381,_382,_383,_384){
nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
this.property=_383||null;
this.value=_384||null;
};
nitobi.lang.extend(nitobi.ui.StyleEventArgs,nitobi.base.EventArgs);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.IScrollable=function(_385){
this.scrollableElement=_385;
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
nitobi.ui.IScrollable.prototype.scrollLeft=function(_388){
_388=_388||25;
this.scrollableElement.scrollLeft-=_388;
};
nitobi.ui.IScrollable.prototype.scrollRight=function(_389){
_389=_389||25;
this.scrollableElement.scrollLeft+=_389;
};
nitobi.ui.IScrollable.prototype.isOverflowed=function(_38a){
_38a=_38a||this.scrollableElement.childNodes[0];
return !(parseInt(nitobi.html.getBox(this.scrollableElement).width)>=parseInt(nitobi.html.getBox(_38a).width));
};
nitobi.lang.defineNs("nitobi.ui");
if(false){
nitobi.ui=function(){
};
}
nitobi.ui.startDragOperation=function(_38b,_38c,_38d,_38e,_38f,_390){
var ddo=new nitobi.ui.DragDrop(_38b,_38d,_38e);
ddo.onDragStop.subscribe(_390,_38f);
ddo.startDrag(_38c);
};
nitobi.ui.DragDrop=function(_392,_393,_394){
this.allowVertDrag=(_393!=null?_393:true);
this.allowHorizDrag=(_394!=null?_394:true);
if(nitobi.browser.IE){
this.surface=document.getElementById("ebadragdropsurface_");
if(this.surface==null){
this.surface=nitobi.html.createElement("div",{"id":"ebadragdropsurface_"},{"filter":"alpha(opacity=1)","backgroundColor":"white","position":"absolute","display":"none","top":"0px","left":"0px","width":"100px","height":"100px","zIndex":"899"});
document.body.appendChild(this.surface);
}
}
if(_392.nodeType==3){
alert("Text node not supported. Use parent element");
}
this.element=_392;
this.zIndex=this.element.style.zIndex;
this.element.style.zIndex=900;
this.onMouseMove=new nitobi.base.Event();
this.onDragStart=new nitobi.base.Event();
this.onDragStop=new nitobi.base.Event();
this.events=[{"type":"mouseup","handler":this.handleMouseUp,"capture":true},{"type":"mousemove","handler":this.handleMouseMove,"capture":true}];
};
nitobi.ui.DragDrop.prototype.startDrag=function(_395){
this.elementOriginTop=parseInt(this.element.style.top,10);
this.elementOriginLeft=parseInt(this.element.style.left,10);
if(isNaN(this.elementOriginLeft)){
this.elementOriginLeft=0;
}
if(isNaN(this.elementOriginTop)){
this.elementOriginTop=0;
}
var _396=nitobi.html.getEventCoords(_395);
x=_396.x;
y=_396.y;
this.originX=x;
this.originY=y;
nitobi.html.attachEvents(document,this.events,this);
nitobi.html.cancelEvent(_395);
this.onDragStart.notify();
};
nitobi.ui.DragDrop.prototype.handleMouseMove=function(_397){
var x,y;
var _39a=nitobi.html.getEventCoords(_397);
x=_39a.x;
y=_39a.y;
if(nitobi.browser.IE){
this.surface.style.display="block";
if(document.compat=="CSS1Compat"){
var _39b=nitobi.html.getBodyArea();
var _39c=0;
if(document.compatMode=="CSS1Compat"){
_39c=25;
}
this.surface.style.width=(_39b.clientWidth-_39c)+"px";
this.surface.style.height=(_39b.clientHeight)+"px";
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
nitobi.html.cancelEvent(_397);
};
nitobi.ui.DragDrop.prototype.handleMouseUp=function(_39d){
this.onDragStop.notify({"event":_39d,"x":this.x,"y":this.y});
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
var _39e=null;
try{
_39e=new ActiveXObject("Msxml2.XMLHTTP");
}
catch(e){
try{
_39e=new ActiveXObject("Microsoft.XMLHTTP");
}
catch(ee){
}
}
return _39e;
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
var _39f=null;
var _3a0=null;
if((this.httpObj.responseXML!=null&&this.httpObj.responseXML.documentElement!=null)&&this.responseType!="text"){
_39f=this.httpObj.responseXML;
}else{
if(this.responseType=="xml"){
_39f=nitobi.xml.createXmlDoc(this.httpObj.responseText);
}else{
_39f=this.httpObj.responseText;
}
}
if(this.httpObj.status!=200){
this.onError.notify({"source":this,"status":this.httpObj.status,"message":"An error occured retrieving the data from the server. "+"Expected response type was '"+this.responseType+"'."});
}
return _39f;
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
var _3a4={"response":this.handleResponse(),"params":this.params};
this.responseXml=this.responseText=_3a4.response;
this.onPostComplete.notify(_3a4);
this.onRequestComplete.notify(_3a4);
if(this.completeCallback){
this.completeCallback.call(this,_3a4);
}
}
};
nitobi.ajax.HttpRequest.prototype.postXml=function(_3a5){
this.setTimeout();
if(("undefined"==typeof (_3a5.documentElement))||(null==_3a5.documentElement)||("undefined"==typeof (_3a5.documentElement.childNodes))||(1>_3a5.documentElement.childNodes.length)){
ebaErrorReport("updategram is empty. No request sent. xmlData["+_3a5+"]\nxmlData.xml["+_3a5.xml+"]");
return;
}
if(null==_3a5.xml){
var _3a6=new XMLSerializer();
_3a5.xml=_3a6.serializeToString(_3a5);
}
return this.post(_3a5.xml);
};
nitobi.ajax.HttpRequest.prototype._send=function(_3a7,url,data,_3aa){
this.handler=url||this.handler;
this.setTimeout();
this.status="pending";
this.httpObj.open(_3a7,(this.preventCache?this.cacheBust(this.handler):this.handler),this.async,this.username,this.password);
if(this.async){
this.httpObj.onreadystatechange=nitobi.lang.close(this,_3aa);
}
for(var item in this.requestHeaders){
this.httpObj.setRequestHeader(item,this.requestHeaders[item]);
}
if(this.responseType=="xml"){
this.httpObj.setRequestHeader("Content-Type","text/xml");
}else{
if(_3a7.toLowerCase()=="post"){
this.httpObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
}
}
this.httpObj.send(data);
if(!this.async){
return this.handleResponse();
}
return this.httpObj;
};
nitobi.ajax.HttpRequest.prototype.open=function(_3ac,url,_3ae,_3af,_3b0){
this.requestMethod=_3ac;
this.async=_3ae;
this.username=_3af;
this.password=_3b0;
this.handler=url;
};
nitobi.ajax.HttpRequest.prototype.send=function(data){
var _3b2=null;
switch(this.requestMethod.toUpperCase()){
case "POST":
_3b2=this.post(data);
break;
default:
_3b2=this.get();
break;
}
this.responseXml=this.responseText=_3b2;
};
nitobi.ajax.HttpRequest.prototype.setTimeout=function(){
if(this.timeout>0){
this.timeoutId=window.setTimeout(nitobi.lang.close(this,this.abort),this.timeout);
}
};
nitobi.ajax.HttpRequest.prototype.getComplete=function(){
if(this.httpObj.readyState==4){
this.status="complete";
var _3b3={"response":this.handleResponse(),"params":this.params,"status":this.httpObj.status,"statusText":this.httpObj.statusText};
this.responseXml=this.responseText=_3b3.response;
this.onGetComplete.notify(_3b3);
this.onRequestComplete.notify(_3b3);
if(this.completeCallback){
this.completeCallback.call(this,_3b3);
}
}
};
nitobi.ajax.HttpRequest.prototype.setRequestHeader=function(_3b4,val){
this.requestHeaders[_3b4]=val;
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
var _3b8=url.split("?");
var _3b9="nitobi_cachebust="+(new Date().getTime());
if(_3b8.length==1){
url+="?"+_3b9;
}else{
url+="&"+_3b9;
}
return url;
};
nitobi.ajax.HttpRequestPool=function(_3ba){
this.inUse=new Array();
this.free=new Array();
this.max=_3ba||nitobi.ajax.HttpRequestPool_MAXCONNECTIONS;
this.locked=false;
this.context=null;
};
nitobi.ajax.HttpRequestPool.prototype.reserve=function(){
this.locked=true;
var _3bb;
if(this.free.length){
_3bb=this.free.pop();
_3bb.clear();
this.inUse.push(_3bb);
}else{
if(this.inUse.length<this.max){
try{
_3bb=new nitobi.ajax.HttpRequest();
}
catch(e){
_3bb=null;
}
this.inUse.push(_3bb);
}else{
throw "No request objects available";
}
}
this.locked=false;
return _3bb;
};
nitobi.ajax.HttpRequestPool.prototype.release=function(_3bc){
var _3bd=false;
this.locked=true;
if(null!=_3bc){
for(var i=0;i<this.inUse.length;i++){
if(_3bc==this.inUse[i]){
this.free.push(this.inUse[i]);
this.inUse.splice(i,1);
_3bd=true;
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
nitobi.data.UrlConnector=function(url,_3c2){
this.url=url||null;
this.transformer=_3c2||null;
this.async=true;
};
nitobi.data.UrlConnector.prototype.get=function(_3c3,_3c4){
this.request=nitobi.data.UrlConnector.requestPool.reserve();
var _3c5=this.url;
for(var p in _3c3){
_3c5=nitobi.html.Url.setParameter(_3c5,p,_3c3[p]);
}
this.request.handler=_3c5;
this.request.async=this.async;
this.request.responseType="xml";
this.request.params={dataReadyCallback:_3c4};
this.request.completeCallback=nitobi.lang.close(this,this.getComplete);
this.request.get();
};
nitobi.data.UrlConnector.prototype.getComplete=function(_3c7){
if(_3c7.params.dataReadyCallback){
var _3c8=_3c7.response;
var _3c9=_3c7.params.dataReadyCallback;
var _3ca=_3c8;
if(this.transformer){
if(typeof (this.transformer)==="function"){
_3ca=this.transformer.call(null,_3c8);
}else{
_3ca=nitobi.xml.transform(_3c8,this.transformer,"xml");
}
}
if(_3c9){
_3c9.call(null,{result:_3ca,response:_3c7.response});
}
}
nitobi.data.UrlConnector.requestPool.release(this.request);
};
nitobi.data.UrlConnector.requestPool=new nitobi.ajax.HttpRequestPool();
function ntbAssert(_3cb,_3cc,_3cd,_3ce){
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
var _3d1=(eval($ntb("nitobi.consoleEntry").value));
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
function _ntbAssert(_3d5,_3d6){
ntbAssert(_3d5,_3d6,"",DEBUG);
}
function ebaSetOnErrorEvent(_3d7){
nitobi.debug.setOnErrorEvent.apply(this,arguments);
}
nitobi.debug.setOnErrorEvent=function(_3d8){
NTB_ON_ERROR=_3d8;
};
function ebaReportError(_3d9,_3da,_3db){
nitobi.debug.errorReport("dude stop calling this method it is now called nitobi.debug.errorReport","");
nitobi.debug.errorReport(_3d9,_3da,_3db);
}
function ebaErrorReport(_3dc,_3dd,_3de){
nitobi.debug.errorReport.apply(this,arguments);
}
nitobi.debug.errorReport=function(_3df,_3e0,_3e1){
_3e1=(_3e1)?_3e1:NTB_DEBUG;
if(NTB_DEBUG==_3e1&&!NTB_DEBUG_MODE){
return;
}
var _3e2=_3df+"\nerror code    ["+_3e0+"]\nerror Severity["+_3e1+"]";
LastError=_3e2;
if(eval(NTB_ON_ERROR||"true")){
switch(_3e0){
case NTB_EM_ATTRIBUTE_ERROR:
confirm(_3df);
break;
case NTB_XHR_RESPONSE_ERROR:
confirm(_3df);
break;
default:
window.status=_3df;
break;
}
}
if(NTB_THROW==_3e1){
throw (_3e2);
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
nitobi.error.ErrorEventArgs=function(_3e3,_3e4,type){
nitobi.error.ErrorEventArgs.baseConstructor.call(this,_3e3);
this.description=_3e4;
this.type=type;
};
nitobi.lang.extend(nitobi.error.ErrorEventArgs,nitobi.base.EventArgs);
nitobi.error.isError=function(err,_3e7){
return (err.indexOf(_3e7)>-1);
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
nitobi.html.IRenderer=function(_3e8){
this.setTemplate(_3e8);
this.parameters={};
};
nitobi.html.IRenderer.prototype.renderAfter=function(_3e9,data){
_3e9=$ntb(_3e9);
var _3eb=_3e9.parentNode;
_3e9=_3e9.nextSibling;
return this._renderBefore(_3eb,_3e9,data);
};
nitobi.html.IRenderer.prototype.renderBefore=function(_3ec,data){
_3ec=$ntb(_3ec);
return this._renderBefore(_3ec.parentNode,_3ec,data);
};
nitobi.html.IRenderer.prototype._renderBefore=function(_3ee,_3ef,data){
var s=this.renderToString(data);
var _3f2=document.createElement("div");
_3f2.innerHTML=s;
var _3f3=new Array();
if(_3f2.childNodes){
var i=0;
while(_3f2.childNodes.length){
_3f3[i++]=_3f2.firstChild;
_3ee.insertBefore(_3f2.firstChild,_3ef);
}
}else{
}
return _3f3;
};
nitobi.html.IRenderer.prototype.renderIn=function(_3f5,data){
_3f5=$ntb(_3f5);
var s=this.renderToString(data);
_3f5.innerHTML=s;
return _3f5.childNodes;
};
nitobi.html.IRenderer.prototype.renderToString=function(data){
};
nitobi.html.IRenderer.prototype.setTemplate=function(_3f9){
this.template=_3f9;
};
nitobi.html.IRenderer.prototype.getTemplate=function(){
return this.template;
};
nitobi.html.IRenderer.prototype.setParameters=function(_3fa){
for(var p in _3fa){
this.parameters[p]=_3fa[p];
}
};
nitobi.html.IRenderer.prototype.getParameters=function(){
return this.parameters;
};
nitobi.lang.defineNs("nitobi.html");
nitobi.html.XslRenderer=function(_3fc){
nitobi.html.IRenderer.call(this,_3fc);
};
nitobi.lang.implement(nitobi.html.XslRenderer,nitobi.html.IRenderer);
nitobi.html.XslRenderer.prototype.setTemplate=function(_3fd){
if(typeof (_3fd)==="string"){
_3fd=nitobi.xml.createXslProcessor(_3fd);
}
this.template=_3fd;
};
nitobi.html.XslRenderer.prototype.renderToString=function(data){
if(typeof (data)==="string"){
data=nitobi.xml.createXmlDoc(data);
}
if(nitobi.lang.typeOf(data)===nitobi.lang.type.XMLNODE){
data=nitobi.xml.createXmlDoc(nitobi.xml.serialize(data));
}
var _3ff=this.getTemplate();
var _400=this.getParameters();
for(var p in _400){
_3ff.addParameter(p,_400[p],"");
}
var s=nitobi.xml.transformToString(data,_3ff,"xml");
for(var p in _400){
_3ff.addParameter(p,"","");
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
var _405=decl.loadHtml($ntb(id));
var _406=$ntb(id);
var _407=_406.parentNode;
var _408=_407.ownerDocument.createElement("ntb:component");
_407.insertBefore(_408,_406);
_407.removeChild(_406);
this.setContainer(_408);
nitobi.base.ISerializable.call(this,_405);
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
nitobi.ui.Element.prototype.setHtmlNode=function(_409){
var node=$ntb(_409);
this.htmlNode=node;
};
nitobi.ui.Element.prototype.getRootId=function(){
var _40b=this.getParentObject();
if(_40b==null){
return this.getId();
}else{
return _40b.getRootId();
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
nitobi.ui.Element.prototype.notify=function(_40f,id,_411,_412){
try{
_40f=nitobi.html.getEvent(_40f);
if(_412!==false){
nitobi.html.cancelEvent(_40f);
}
var _413=nitobi.ui.Element.parseId(id).id;
if(!this.isDescendantExists(_413)){
return false;
}
var _414=!(_413==this.getId());
var _415=new nitobi.ui.ElementEventArgs(this,null,id);
var _416=new nitobi.ui.EventNotificationEventArgs(this,null,id,_40f);
_414=_414&&this.onBeforePropagate.notify(_416);
var _417=true;
if(_414){
if(_411==null){
_411=this.getPathToLeaf(_413);
}
var _418=this.onBeforeEventNotify.notify(_416);
var _419=(_418?this.onEventNotify.notify(_416):true);
var _41a=_411.pop().getAttribute("id");
var _41b=this.getObjectById(_41a);
var _417=this.onBeforePropagateToChild.notify(_416);
if(_41b.notify&&_417&&_419){
_417=_41b.notify(_40f,id,_411,_412);
}
}else{
_417=this.onEventNotify.notify(_416);
}
var _41c=this.eventMap[_40f.type];
if(_41c!=null&&_417){
_41c.notify(this.getEventArgs(_40f,id));
}
return _417;
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected+" Element.notify encountered a problem.",err);
}
};
nitobi.ui.Element.prototype.getEventArgs=function(_41d,_41e){
var _41f=new nitobi.ui.ElementEventArgs(this,null,_41e);
return _41f;
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
nitobi.ui.Element.prototype.hide=function(_425,_426,_427){
this.setVisible(false,_425,_426,_427);
};
nitobi.ui.Element.prototype.show=function(_428,_429,_42a){
this.setVisible(true,_428,_429,_42a);
};
nitobi.ui.Element.prototype.isVisible=function(){
var node=this.getHtmlNode();
return node&&!nitobi.html.Css.hasClass(node,NTB_CSS_HIDE);
};
nitobi.ui.Element.prototype.setVisible=function(_42c,_42d,_42e,_42f){
var _430=this.getHtmlNode();
if(_430&&this.isVisible()!=_42c&&this.onBeforeSetVisible.notify({source:this,event:this.onBeforeSetVisible,args:arguments})!==false){
if(this.effect){
this.effect.end();
}
if(_42c){
if(_42d){
var _431=new _42d(_430,_42f);
_431.callback=nitobi.lang.close(this,this.handleSetVisible,[_42e]);
this.effect=_431;
_431.onFinish.subscribeOnce(nitobi.lang.close(this,function(){
this.effect=null;
}));
_431.start();
}else{
nitobi.html.Css.removeClass(_430,NTB_CSS_HIDE);
this.handleSetVisible(_42e);
}
}else{
if(_42d){
var _431=new _42d(_430,_42f);
_431.callback=nitobi.lang.close(this,this.handleSetVisible,[_42e]);
this.effect=_431;
_431.onFinish.subscribeOnce(nitobi.lang.close(this,function(){
this.effect=null;
}));
_431.start();
}else{
nitobi.html.Css.addClass(this.getHtmlNode(),NTB_CSS_HIDE);
this.handleSetVisible(_42e);
}
}
}
};
nitobi.ui.Element.prototype.handleSetVisible=function(_432){
if(_432){
_432();
}
this.onSetVisible.notify(new nitobi.ui.ElementEventArgs(this,this.onSetVisible));
};
nitobi.ui.Element.prototype.setEnabled=function(_433){
this.enabled=_433;
};
nitobi.ui.Element.prototype.isEnabled=function(){
return this.enabled;
};
nitobi.ui.Element.prototype.render=function(_434,_435){
this.flushHtmlNodeCache();
_435=_435||this.getState();
_434=$ntb(_434)||this.getContainer();
if(_434==null){
var _434=document.createElement("span");
document.body.appendChild(_434);
this.setContainer(_434);
}
this.htmlNode=this.renderer.renderIn(_434,_435)[0];
this.htmlNode.jsObject=this;
};
nitobi.ui.Element.prototype.getContainer=function(){
return this.container;
};
nitobi.ui.Element.prototype.setContainer=function(_436){
this.container=$ntb(_436);
};
nitobi.ui.Element.prototype.getState=function(){
return this.getXmlNode();
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.ElementEventArgs=function(_437,_438,_439){
nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
this.targetId=_439||null;
};
nitobi.lang.extend(nitobi.ui.ElementEventArgs,nitobi.base.EventArgs);
nitobi.lang.defineNs("nitobi.ui");
nitobi.ui.EventNotificationEventArgs=function(_43a,_43b,_43c,_43d){
nitobi.ui.EventNotificationEventArgs.baseConstructor.apply(this,arguments);
this.htmlEvent=_43d||null;
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
nitobi.ui.Effects.setVisible=function(_43f,_440,_441,_442,_443){
_442=(_443?nitobi.lang.close(_443,_442):_442)||nitobi.lang.noop;
_43f=$ntb(_43f);
if(typeof _441=="string"){
_441=nitobi.effects.families[_441];
}
if(!_441){
_441=nitobi.effects.families["none"];
}
if(_440){
var _444=_441.show;
}else{
var _444=_441.hide;
}
if(_444){
var _445=new _444(_43f);
_445.callback=_442;
_445.start();
}else{
if(_440){
nitobi.html.Css.removeClass(_43f,NTB_CSS_HIDE);
}else{
nitobi.html.Css.addClass(_43f,NTB_CSS_HIDE);
}
_442();
}
};
nitobi.ui.Effects.shrink=function(_446,_447,_448,_449){
var rect=nitobi.html.getClientRects(_447)[0];
_446.deltaHeight_Doctype=0-parseInt("0"+nitobi.html.getStyle(_447,"border-top-width"))-parseInt("0"+nitobi.html.getStyle(_447,"border-bottom-width"))-parseInt("0"+nitobi.html.getStyle(_447,"padding-top"))-parseInt("0"+nitobi.html.getStyle(_447,"padding-bottom"));
_446.deltaWidth_Doctype=0-parseInt("0"+nitobi.html.getStyle(_447,"border-left-width"))-parseInt("0"+nitobi.html.getStyle(_447,"border-right-width"))-parseInt("0"+nitobi.html.getStyle(_447,"padding-left"))-parseInt("0"+nitobi.html.getStyle(_447,"padding-right"));
_446.oldHeight=Math.abs(rect.top-rect.bottom)+_446.deltaHeight_Doctype;
_446.oldWidth=Math.abs(rect.right-rect.left)+_446.deltaWidth_Doctype;
if(!(typeof (_446.width)=="undefined")){
_446.deltaWidth=Math.floor(Math.ceil(_446.width-_446.oldWidth)/(_448/nitobi.ui.Effects.ANIMATION_INTERVAL));
}else{
_446.width=_446.oldWidth;
_446.deltaWidth=0;
}
if(!(typeof (_446.height)=="undefined")){
_446.deltaHeight=Math.floor(Math.ceil(_446.height-_446.oldHeight)/(_448/nitobi.ui.Effects.ANIMATION_INTERVAL));
}else{
_446.height=_446.oldHeight;
_446.deltaHeight=0;
}
nitobi.ui.Effects.resize(_446,_447,_448,_449);
};
nitobi.ui.Effects.resize=function(_44b,_44c,_44d,_44e){
var rect=nitobi.html.getClientRects(_44c)[0];
var _450=Math.abs(rect.top-rect.bottom);
var _451=Math.max(_450+_44b.deltaHeight+_44b.deltaHeight_Doctype,0);
if(Math.abs(_450-_44b.height)<Math.abs(_44b.deltaHeight)){
_451=_44b.height;
_44b.deltaHeight=0;
}
var _452=Math.abs(rect.right-rect.left);
var _453=Math.max(_452+_44b.deltaWidth+_44b.deltaWidth_Doctype,0);
_453=(_453>=0)?_453:0;
if(Math.abs(_452-_44b.width)<Math.abs(_44b.deltaWidth)){
_453=_44b.width;
_44b.deltaWidth=0;
}
_44d-=nitobi.ui.Effects.ANIMATION_INTERVAL;
if(_44d>0){
window.setTimeout(nitobi.lang.closeLater(this,nitobi.ui.Effects.resize,[_44b,_44c,_44d,_44e]),nitobi.ui.Effects.ANIMATION_INTERVAL);
}
var _454=function(){
_44c.height=_451+"px";
_44c.style.height=_451+"px";
_44c.width=_453+"px";
_44c.style.width=_453+"px";
if(_44d<=0){
if(_44e){
window.setTimeout(_44e,0);
}
}
};
nitobi.ui.Effects.executeNextPulse.push(_454);
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
nitobi.ui.Effects.cube=function(_456){
return _456*_456*_456;
};
nitobi.ui.Effects.cubeRoot=function(_457){
var T=0;
var N=parseFloat(_457);
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
nitobi.ui.Effects.linear=function(_45c){
return _45c;
};
nitobi.ui.Effects.fade=function(_45d,_45e,time,_460,_461){
_461=_461||nitobi.ui.Effects.linear;
var _462=(new Date()).getTime()+time;
var id=nitobi.component.getUniqueId();
var _464=(new Date()).getTime();
var el=_45d;
if(_45d.length){
el=_45d[0];
}
var _466=nitobi.html.Css.getOpacity(el);
var _467=(_45e-_466<0?-1:0);
nitobi.ui.Effects.fadeIntervalId[id]=window.setInterval(function(){
nitobi.ui.Effects.stepFade(_45d,_45e,_464,_462,id,_460,_461,_467);
},nitobi.ui.Effects.fadeIntervalTime);
};
nitobi.ui.Effects.stepFade=function(_468,_469,_46a,_46b,id,_46d,_46e,_46f){
var ct=(new Date()).getTime();
var _471=_46b-_46a;
var nct=((ct-_46a)/(_46b-_46a));
if(nct<=0||nct>=1){
nitobi.html.Css.setOpacities(_468,_469);
window.clearInterval(nitobi.ui.Effects.fadeIntervalId[id]);
_46d();
return;
}else{
nct=Math.abs(nct+_46f);
}
var no=_46e(nct);
nitobi.html.Css.setOpacities(_468,no*100);
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
var _476;
var _477=nitobi.html.getTagName(el);
if(_477=="ntb:grid"){
_476=nitobi.initGrid(el.id);
}else{
if(_477==="ntb:combo"){
_476=nitobi.initCombo(el.id);
}else{
if(_477=="ntb:treegrid"){
_476=nitobi.initTreeGrid(el.id);
}else{
if(el.jsObject==null){
_476=nitobi.base.Factory.getInstance().createByTag(_477,el.id,nitobi.component.renderComponent);
if(_476.render&&!_476.onLoadCallback){
_476.render();
}
}else{
_476=el.jsObject;
}
}
}
}
return _476;
};
nitobi.component.renderComponent=function(_478){
_478.source.render();
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
nitobi.getComponents=function(_47b,_47c){
if(_47c==null){
_47c=[];
}
if(nitobi.component.isNitobiElement(_47b)){
_47c.push(_47b);
return;
}
var _47d=_47b.childNodes;
for(var i=0;i<_47d.length;i++){
nitobi.getComponents(_47d[i],_47c);
}
return _47c;
};
nitobi.component.isNitobiElement=function(_47f){
var _480=nitobi.html.getTagName(_47f);
if(_480.substr(0,3)=="ntb"){
return true;
}else{
return false;
}
};
nitobi.component.loadComponentsFromNode=function(_481){
var _482=new Array();
nitobi.getComponents(_481,_482);
for(var i=0;i<_482.length;i++){
nitobi.loadComponent(_482[i].getAttribute("id"));
}
};
nitobi.lang.defineNs("nitobi.effects");
if(false){
nitobi.effects=function(){
};
}
nitobi.effects.Effect=function(_484,_485){
this.element=$ntb(_484);
this.transition=_485.transition||nitobi.effects.Transition.sinoidal;
this.duration=_485.duration||1;
this.fps=_485.fps||50;
this.from=typeof (_485.from)==="number"?_485.from:0;
this.to=typeof (_485.from)==="number"?_485.to:1;
this.delay=_485.delay||0;
this.callback=typeof (_485.callback)==="function"?_485.callback:nitobi.lang.noop;
this.queue=_485.queue||nitobi.effects.EffectQueue.globalQueue;
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
var _48a=Math.floor(pos*this.totalFrames);
if(this.frame<_48a){
this.render(pos);
this.frame=_48a;
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
nitobi.effects.factory=function(_48c,_48d,etc){
var args=nitobi.lang.toArray(arguments,2);
return function(_490){
var f=function(){
_48c.apply(this,[_490,_48d].concat(args));
};
nitobi.lang.extend(f,_48c);
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
nitobi.effects.Scale=function(_495,_496,_497){
nitobi.effects.Scale.baseConstructor.call(this,_495,_496);
this.scaleX=typeof (_496.scaleX)=="boolean"?_496.scaleX:true;
this.scaleY=typeof (_496.scaleY)=="boolean"?_496.scaleY:true;
this.scaleFrom=typeof (_496.scaleFrom)=="number"?_496.scaleFrom:100;
this.scaleTo=_497;
};
nitobi.lang.extend(nitobi.effects.Scale,nitobi.effects.Effect);
nitobi.effects.Scale.prototype.setup=function(){
var _498=this.element.style;
var Css=nitobi.html.Css;
this.originalStyle={"top":_498.top,"left":_498.left,"width":_498.width,"height":_498.height,"overflow":Css.getStyle(this.element,"overflow")};
this.factor=(this.scaleTo-this.scaleFrom)/100;
this.dims=[this.element.scrollWidth,this.element.scrollHeight];
_498.width=this.dims[0]+"px";
_498.height=this.dims[1]+"px";
Css.setStyle(this.element,"overflow","hidden");
};
nitobi.effects.Scale.prototype.finish=function(){
for(var s in this.originalStyle){
this.element.style[s]=this.originalStyle[s];
}
};
nitobi.effects.Scale.prototype.update=function(pos){
var _49c=(this.scaleFrom/100)+(this.factor*pos);
this.setDimensions(Math.floor(_49c*this.dims[0])||1,Math.floor(_49c*this.dims[1])||1);
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
nitobi.effects.EffectQueue.prototype.add=function(_49f){
nitobi.collections.IEnumerable.prototype.add.call(this,_49f);
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
nitobi.effects.BlindUp=function(_4a2,_4a3){
_4a3=nitobi.lang.merge({scaleX:false,duration:Math.min(0.2*(_4a2.scrollHeight/100),0.5)},_4a3||{});
nitobi.effects.BlindUp.baseConstructor.call(this,_4a2,_4a3,0);
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
nitobi.effects.BlindDown=function(_4a4,_4a5){
nitobi.html.Css.swapClass(_4a4,NTB_CSS_HIDE,NTB_CSS_SMALL);
_4a5=nitobi.lang.merge({scaleX:false,scaleFrom:0,duration:Math.min(0.2*(_4a4.scrollHeight/100),0.5)},_4a5||{});
nitobi.effects.BlindDown.baseConstructor.call(this,_4a4,_4a5,100);
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
nitobi.effects.ShadeUp=function(_4a6,_4a7){
_4a7=nitobi.lang.merge({scaleX:false,duration:Math.min(0.2*(_4a6.scrollHeight/100),0.3)},_4a7||{});
nitobi.effects.ShadeUp.baseConstructor.call(this,_4a6,_4a7,0);
};
nitobi.lang.extend(nitobi.effects.ShadeUp,nitobi.effects.Scale);
nitobi.effects.ShadeUp.prototype.setup=function(){
nitobi.effects.ShadeUp.base.setup.call(this);
var _4a8=nitobi.html.getFirstChild(this.element);
this.originalStyle.position=this.element.style.position;
nitobi.html.position(this.element);
if(_4a8){
var _4a9=_4a8.style;
this.fnodeStyle={position:_4a9.position,bottom:_4a9.bottom,left:_4a9.left};
this.fnode=_4a8;
_4a9.position="absolute";
_4a9.bottom="0px";
_4a9.left="0px";
_4a9.top="";
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
nitobi.effects.ShadeDown=function(_4ab,_4ac){
nitobi.html.Css.swapClass(_4ab,NTB_CSS_HIDE,NTB_CSS_SMALL);
_4ac=nitobi.lang.merge({scaleX:false,scaleFrom:0,duration:Math.min(0.2*(_4ab.scrollHeight/100),0.3)},_4ac||{});
nitobi.effects.ShadeDown.baseConstructor.call(this,_4ab,_4ac,100);
};
nitobi.lang.extend(nitobi.effects.ShadeDown,nitobi.effects.Scale);
nitobi.effects.ShadeDown.prototype.setup=function(){
nitobi.effects.ShadeDown.base.setup.call(this);
this.element.style.height="1px";
nitobi.html.Css.removeClass(this.element,NTB_CSS_SMALL);
var _4ad=nitobi.html.getFirstChild(this.element);
this.originalStyle.position=this.element.style.position;
nitobi.html.position(this.element);
if(_4ad){
var _4ae=_4ad.style;
this.fnodeStyle={position:_4ae.position,bottom:_4ae.bottom,left:_4ae.left,right:_4ae.right,top:_4ae.top};
this.fnode=_4ad;
_4ae.position="absolute";
_4ae.top="";
_4ae.right="";
_4ae.bottom="0px";
_4ae.left="0px";
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
nitobi.lang.StringBuilder=function(_4b0){
if(_4b0){
if(typeof (_4b0)==="string"){
this.strings=[_4b0];
}else{
this.strings=_4b0;
}
}else{
this.strings=new Array();
}
};
nitobi.lang.StringBuilder.prototype.append=function(_4b1){
if(_4b1){
this.strings.push(_4b1);
}
return this;
};
nitobi.lang.StringBuilder.prototype.clear=function(){
this.strings.length=0;
};
nitobi.lang.StringBuilder.prototype.toString=function(){
return this.strings.join("");
};

var temp_ntb_uniqueIdGeneratorProc='<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" /> <x:p-x:n-guid"x:s-0"/><x:t- match="/"> <x:at-/></x:t-><x:t- match="node()|@*"> <xsl:copy> <xsl:if test="not(@id)"> <x:a-x:n-id" ><x:v-x:s-generate-id(.)"/><x:v-x:s-position()"/><x:v-x:s-$guid"/></x:a-> </xsl:if> <x:at-x:s-./* | text() | @*"> </x:at-> </xsl:copy></x:t-> <x:t- match="text()"> <x:v-x:s-."/></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.base");
nitobi.base.uniqueIdGeneratorProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_uniqueIdGeneratorProc));
