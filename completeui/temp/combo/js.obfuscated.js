if(typeof (nitobi)=="undefined"||typeof (nitobi.lang)=="undefined"){
alert("The Nitobi framework source could not be found. Is it included before any other Nitobi components?");
}
nitobi.Browser=function(){
};
nitobi.Browser.GetScrollBarWidth=nitobi.html.getScrollBarWidth;
nitobi.Browser.GetBrowserType=function(){
return (navigator.appName=="Microsoft Internet Explorer"?this.nitobi.Browser.IE:this.nitobi.Browser.UNKNOWN);
};
nitobi.Browser.GetBrowserDetails=function(){
return (this.GetBrowserType()==this.nitobi.Browser.IE?window.clientInformation:null);
};
nitobi.Browser.IsObjectInView=function(_1,_2,_3,_4){
var _5=nitobi.html.getBoundingClientRect(_1);
var _6=nitobi.html.getBoundingClientRect(_2);
if(nitobi.browser.MOZ){
_6.top+=_2.scrollTop;
_6.bottom+=_2.scrollTop;
_6.left+=_2.scrollLeft;
_6.right+=_2.scrollLeft;
}
var _7=((true==_3?(_5.top==_6.top):(_5.top>=_6.top)&&(_5.bottom<=_6.bottom))&&(_4?true:(_5.right<=_6.right)&&(_5.left>=_6.left)));
return _7;
};
nitobi.Browser.VAdjust=function(_8,_9){
var v=(_8.offsetParent?_8.offsetParent.offsetTop:0);
var id=_8.id;
var _c=id.substring(0,1+id.lastIndexOf("_"))+"0";
var _d=_9.ownerDocument;
if(null==_d){
_d=_9.document;
}
var oF=_d.getElementById(_c);
return v-(oF.offsetParent?oF.offsetParent.offsetTop:0);
};
nitobi.Browser.WheelUntil=function(_f,inc,_11,idx,_13,_14){
var min=(inc?-1:0);
var max=(inc?_13:_13+1);
while(idx>min&&idx<max){
if(inc){
idx++;
}else{
idx--;
}
var r=_11.GetRow(idx);
var _18=this.IsObjectInView(r,_14,false,true);
if(_18==_f){
return idx;
}
}
return idx;
};
nitobi.Browser.WheelUp=function(_19){
var top=_19.GetRow(0);
var _1b=_19.GetXmlDataSource().GetNumberRows()-1;
var _1c=_19.GetRow(_1b);
var _1d=_19.GetSectionHTMLTagObject(EBAComboBoxListBody);
var i=parseInt(_1d.scrollTop/top.offsetHeight);
var r=(i>_1b?_1c:_19.GetRow(i));
var _20=r.offsetTop-_1d.scrollTop+nitobi.Browser.VAdjust(r,_1d);
if(this.IsObjectInView(r,_1d,false,true)){
i=this.WheelUntil(false,false,_19,i,_1b,_1d);
}else{
if(_20<0){
i=this.WheelUntil(true,true,_19,i,_1b,_1d);
i--;
}else{
i=this.WheelUntil(true,false,_19,i,_1b,_1d);
i=this.WheelUntil(false,false,_19,i,_1b,_1d);
}
}
this.ScrollIntoView(_19.GetRow(i),_1d,true,false);
};
nitobi.Browser.WheelDown=function(_21){
var top=_21.GetRow(0);
var _23=_21.GetXmlDataSource().GetNumberRows()-1;
var _24=_21.GetRow(_23);
var _25=_21.GetSectionHTMLTagObject(EBAComboBoxListBody);
var i=parseInt(_25.scrollTop/top.offsetHeight);
var r=(i>_23?_24:_21.GetRow(i));
var _28=r.offsetTop-_25.scrollTop+nitobi.Browser.VAdjust(r,_25);
if(this.IsObjectInView(r,_25,false,true)){
i=1+this.WheelUntil(false,false,_21,i,_23,_25);
}else{
if(_28<0){
i=this.WheelUntil(true,true,_21,i,_23,_25);
}else{
i=this.WheelUntil(true,false,_21,i,_23,_25);
i=1+this.WheelUntil(false,false,_21,i,_23,_25);
}
}
r=_21.GetRow(i);
_28=r.offsetTop-_25.scrollTop+nitobi.Browser.VAdjust(r,_25);
if(0==_28&&i!=_23){
r=_21.GetRow(1+i);
}
this.ScrollIntoView(r,_25,true,false);
};
nitobi.Browser.ScrollIntoView=function(_29,_2a,Top,_2c){
var _2d=nitobi.html.getBoundingClientRect(_29);
var _2e=nitobi.html.getBoundingClientRect(_2a);
var _2f=_29.offsetTop-_2a.scrollTop;
var v=nitobi.Browser.VAdjust(_29,_2a);
_2f+=v;
var _31=_29.offsetLeft-_2a.scrollLeft;
var _32=_31+_29.offsetWidth-_2a.offsetWidth;
var _33=_2f+_29.offsetHeight-_2a.offsetHeight;
var _34=0;
var _35=0;
var _36=this.GetScrollBarWidth(_2a);
if(this.GetVerticalScrollBarStatus(_2a)==true){
_34=_36;
}
if(_31<0){
_2a.scrollLeft+=_31;
}else{
if(_32>0){
if(_2d.left-_32>_2e.left){
_2a.scrollLeft+=_32+_34;
}else{
_2a.scrollLeft+=_31;
}
}
}
if((_2f<0||true==Top)&&true!=_2c){
_2a.scrollTop+=_2f;
}else{
if(_33>0||true==_2c){
if(_2d.top-_33>_2e.top||true==_2c){
_2a.scrollTop+=_33+_35;
}else{
_2a.scrollTop+=_2f;
}
}
}
};
nitobi.Browser.GetVerticalScrollBarStatus=function(_37){
return this.GetScrollBarWidth(_37)>0;
};
nitobi.Browser.GetHorizontalScrollBarStatus=function(_38){
return (_38.scrollWidth>_38.offsetWidth-this.GetScrollBarWidth(_38));
};
nitobi.Browser.HTMLUnencode=function(_39){
var _3a=_39;
var _3b=new Array(/&amp;/g,/&lt;/g,/&quot;/g,/&gt;/g,/&nbsp;/g);
var _3c=new Array("&","<","\"",">"," ");
for(var i=0;i<_3b.length;i++){
_3a=_3a.replace(_3b[i],_3c[i]);
}
return (_3a);
};
nitobi.Browser.EncodeAngleBracketsInTagAttributes=function(str){
str=str.replace(/'"'/g,"\"&quot;\"");
var _3f=str.match(/".*?"/g);
if(_3f){
for(var i=0;i<_3f.length;i++){
val=_3f[i];
val=val.replace(/</g,"&lt;");
val=val.replace(/>/g,"&gt;");
str=str.replace(_3f[i],val);
}
}
return str;
};
nitobi.Browser.LoadPageFromUrl=function(Url,_42){
if(_42==null){
_42="GET";
}
var _43=new nitobi.ajax.HttpRequest();
_43.responseType="text";
_43.abort();
_43.open(_42,Url,false,"","");
_43.send("EBA Combo Box Get Page Request");
return (_43.responseText);
};
nitobi.Browser.GetMeasurementUnitType=function(_44){
if(_44==null||_44==""){
return "";
}
var _45=_44.search(/\D/g);
var _46=_44.substring(_45);
return (_46);
};
nitobi.Browser.GetMeasurementUnitValue=function(_47){
var _48=_47.search(/\D/g);
var _49=_47.substring(0,_48);
return Number(_49);
};
nitobi.Browser.GetElementWidth=function(_4a){
if(_4a==null){
throw ("Element in GetElementWidth is null");
}
var _4b=_4a.style;
var top=_4b.top;
var _4d=_4b.display;
var _4e=_4b.position;
var _4f=_4b.visibility;
var _50=nitobi.html.Css.getStyle(_4a,"visibility");
var _51=nitobi.html.Css.getStyle(_4a,"display");
var _52=0;
if(_51=="none"||_50=="hidden"){
_4b.position="absolute";
_4b.top=-1000;
_4b.display="inline";
_4b.visibility="visible";
}
var _53=nitobi.html.getWidth(_4a);
if(_4b.display=="inline"){
_4b.position=_4e;
_4b.top=top;
_4b.display=_4d;
_4b.visibility=_4f;
}
return parseInt(_53);
};
nitobi.Browser.GetElementHeight=function(_54){
if(_54==null){
throw ("Element in GetElementHeight is null");
}
var _55=_54.style;
var top=_55.top;
var _57=_55.display;
var _58=_55.position;
var _59=_55.visibility;
if(_55.display=="none"||_55.visibility!="visible"){
_55.position="absolute";
_55.top="-1000px";
_55.display="inline";
_55.visibility="visible";
}
var _5a=nitobi.html.getHeight(_54);
if(_55.display=="inline"){
_55.position=_58;
_55.top=top;
_55.display=_57;
_55.visibility=_59;
}
return parseInt(_5a);
};
nitobi.Browser.GetParentElementByTagName=function(_5b,_5c){
_5c=_5c.toLowerCase();
var _5d;
do{
_5b=_5b.parentElement;
if(_5b!=null){
_5d=_5b.tagName.toLowerCase();
}
}while((_5d!=_5c)&&(_5b!=null));
return _5b;
};
nitobi.lang.defineNs("nitobi.drawing");
nitobi.drawing.rgb=function(r,g,b){
return "#"+((r*65536)+(g*256)+b).toString(16);
};
nitobi.drawing.align=function(_61,_62,_63,oh,ow,oy,ox,_68){
oh=oh||0;
ow=ow||0;
oy=oy||0;
ox=ox||0;
var a=_63;
var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;
if(true){
td=_62.getBoundingClientRect();
sd=_61.getBoundingClientRect();
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
if(a&268435456){
_61.style.height=th+oh;
}
if(a&16777216){
_61.style.width=tw+ow;
}
if(a&1048576){
_61.style.top=nitobi.html.getStyleTop(_61)+tt-st+oy;
}
if(a&65536){
_61.style.top=nitobi.html.getStyleTop(_61)+tt-st+th-sh+oy;
}
if(a&4096){
_61.style.left=nitobi.html.getStyleLeft(_61)-sl+tl+ox;
}
if(a&256){
_61.style.left=nitobi.html.getStyleLeft(_61)-sl+tl+tw-sw+ox;
}
if(a&16){
_61.style.top=nitobi.html.getStyleTop(_61)+tt-st+oy+Math.floor((th-sh)/2);
}
if(a&1){
_61.style.left=nitobi.html.getStyleLeft(_61)-sl+tl+ox+Math.floor((tw-sw)/2);
}
if(_68){
src.style.top=st-2;
src.style.left=sl-2;
src.style.height=sh;
src.style.width=sw;
tgt.style.top=tt-2;
tgt.style.left=tl-2;
tgt.style.height=th;
tgt.style.width=tw;
if(document.getBoundingClientRect){
sd=_61.getBoundingClientRect();
st=sd.top;
sb=sd.bottom;
sl=sd.left;
sr=sd.right;
sh=Math.abs(sb-st);
sw=Math.abs(sr-sl);
}
if(document.getBoxObjectFor){
sd=document.getBoxObjectFor(_61);
st=sd.screenY;
sl=sd.screenX;
sw=sd.width;
sh=sd.height;
}
src2.style.top=st-2;
src2.style.left=sl-2;
src2.style.height=sh;
src2.style.width=sw;
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
nitobi.drawing.alignOuterBox=function(_78,_79,_7a,oh,ow,oy,ox,_7f){
oh=oh||0;
ow=ow||0;
oy=oy||0;
ox=ox||0;
nitobi.drawing.align(_78,_79,_7a,oh,ow,oy,ox,_7f);
};
nitobi.lang.defineNs("nitobi.combo");
nitobi.combo.Button=function(_80,_81){
try{
var _82="ntb-combobox-button";
var _83="ntb-combobox-button-pressed";
var _84="";
var _85="";
this.SetCombo(_81);
var _86=(_80?_80.getAttribute("Width"):null);
((null==_86)||(_86==""))?this.SetWidth(_84):this.SetWidth(_86);
var _87=(_80?_80.getAttribute("Height"):null);
((null==_87)||(_87==""))?this.SetHeight(_85):this.SetHeight(_87);
var _88=(_80?_80.getAttribute("DefaultCSSClassName"):null);
((null==_88)||(_88==""))?this.SetDefaultCSSClassName(_82):this.SetDefaultCSSClassName(_88);
var _89=(_80?_80.getAttribute("PressedCSSClassName"):null);
((null==_89)||(_89==""))?this.SetPressedCSSClassName(_83):this.SetPressedCSSClassName(_89);
this.SetCSSClassName(this.GetDefaultCSSClassName());
this.m_userTag=_80;
this.m_prevImgClass="ntb-combobox-button-img";
}
catch(err){
}
};
nitobi.combo.Button.prototype.Unload=function(){
};
nitobi.combo.Button.prototype.GetDefaultCSSClassName=function(){
return this.m_DefaultCSSClassName;
};
nitobi.combo.Button.prototype.SetDefaultCSSClassName=function(_8a){
this.m_DefaultCSSClassName=_8a;
};
nitobi.combo.Button.prototype.GetPressedCSSClassName=function(){
return this.m_PressedCSSClassName;
};
nitobi.combo.Button.prototype.SetPressedCSSClassName=function(_8b){
this.m_PressedCSSClassName=_8b;
};
nitobi.combo.Button.prototype.GetHeight=function(){
return (null==this.m_HTMLTagObject?this.m_Height:this.m_HTMLTagObject.style.height);
};
nitobi.combo.Button.prototype.SetHeight=function(_8c){
if(null==this.m_HTMLTagObject){
this.m_Height=_8c;
}else{
this.m_HTMLTagObject.style.height=_8c;
}
};
nitobi.combo.Button.prototype.GetWidth=function(){
if(null==this.m_HTMLTagObject){
return this.m_Width;
}else{
return this.m_HTMLTagObject.style.width;
}
};
nitobi.combo.Button.prototype.SetWidth=function(_8d){
if(null==this.m_HTMLTagObject){
this.m_Width=_8d;
}else{
this.m_HTMLTagObject.style.width=_8d;
}
};
nitobi.combo.Button.prototype.GetHTMLTagObject=function(){
return this.m_HTMLTagObject;
};
nitobi.combo.Button.prototype.SetHTMLTagObject=function(_8e){
this.m_HTMLTagObject=_8e;
};
nitobi.combo.Button.prototype.GetCombo=function(){
return this.m_Combo;
};
nitobi.combo.Button.prototype.SetCombo=function(_8f){
this.m_Combo=_8f;
};
nitobi.combo.Button.prototype.GetCSSClassName=function(){
return (null==this.m_HTMLTagObject?this.m_CSSClassName:this.m_HTMLTagObject.className);
};
nitobi.combo.Button.prototype.SetCSSClassName=function(_90){
if(null==this.m_HTMLTagObject){
this.m_CSSClassName=_90;
}else{
this.m_HTMLTagObject.className=_90;
}
};
nitobi.combo.Button.prototype.OnMouseOver=function(_91,_92){
if(this.GetCombo().GetEnabled()){
if(null==_91){
_91=this.m_Img;
}
this.m_prevImgClass="ntb-combobox-button-img-over";
_91.className=this.m_prevImgClass;
if(_92){
this.GetCombo().GetTextBox().OnMouseOver(false);
}
}
};
nitobi.combo.Button.prototype.OnMouseOut=function(_93,_94){
if(null==_93){
_93=this.m_Img;
}
this.m_prevImgClass="ntb-combobox-button-img";
_93.className=this.m_prevImgClass;
if(_94){
this.GetCombo().GetTextBox().OnMouseOut(false);
}
};
nitobi.combo.Button.prototype.OnMouseDown=function(_95){
if(this.GetCombo().GetEnabled()){
if(null!=_95){
_95.className="ntb-combobox-button-img-pressed";
}
this.OnClick();
}
};
nitobi.combo.Button.prototype.OnMouseUp=function(_96){
if(this.GetCombo().GetEnabled()){
if(null!=_96){
_96.className=this.m_prevImgClass;
}
}
};
nitobi.combo.Button.prototype.OnClick=function(){
var _97=this.GetCombo();
var _98=document.getElementsByTagName((!nitobi.browser.IE)?"ntb:Combo":"combo");
for(var i=0;i<_98.length;i++){
var _9a=_98[i].object;
try{
if(_97.GetId()!=_9a.GetId()){
_9a.GetList().Hide();
}
}
catch(err){
}
}
var l=_97.GetList();
l.Toggle();
var t=_97.GetTextBox();
var tb=t.GetHTMLTagObject();
if(t.focused){
t.m_skipFocusOnce=true;
}
tb.focus();
};
nitobi.combo.Button.prototype.GetHTMLRenderString=function(){
var _9e=this.GetCombo().GetId();
var uid=this.GetCombo().GetUniqueId();
var w=this.GetWidth();
var h=this.GetHeight();
if((!nitobi.browser.IE)){
var _a2="<span id='EBAComboBoxButton"+uid+"' "+"class='"+this.GetDefaultCSSClassName()+"' "+"style='"+(null!=w&&""!=w?"width:"+w+";":"")+(null!=h&&""!=h?"height:"+h+";":"")+"'>"+"<img src='javascript:void(0);' class='ntb-combobox-button-img' id='EBAComboBoxButtonImg"+uid+"' "+"onmouseover='$ntb(\""+_9e+"\").object.GetButton().OnMouseOver(this, true)' "+"onmouseout='$ntb(\""+_9e+"\").object.GetButton().OnMouseOut(this, true)' "+"onmousedown='$ntb(\""+_9e+"\").object.GetButton().OnMouseDown(this);return false;' "+"onmouseup='$ntb(\""+_9e+"\").object.GetButton().OnMouseUp(this)' "+"onmousemove='return false;' "+"></img></span>";
}else{
var _a2="<span id='EBAComboBoxButton"+uid+"' "+"class='"+this.GetDefaultCSSClassName()+"' "+"style='"+(null!=w&&""!=w?"width:"+w+";":"")+(null!=h&&""!=h?"height:"+h+";":"")+"'>"+"<img class='ntb-combobox-button-img' id='EBAComboBoxButtonImg"+uid+"' "+"onmouseover='$ntb(\""+_9e+"\").object.GetButton().OnMouseOver(this, true)' "+"onmouseout='$ntb(\""+_9e+"\").object.GetButton().OnMouseOut(this, true)' "+"onmousedown='$ntb(\""+_9e+"\").object.GetButton().OnMouseDown(this);return false;' "+"onmouseup='$ntb(\""+_9e+"\").object.GetButton().OnMouseUp(this)' "+"onmousemove='return false;' "+"></img></span>";
}
return _a2;
};
nitobi.combo.Button.prototype.Initialize=function(){
var _a3=this.GetCombo();
var uid=_a3.GetUniqueId();
this.SetHTMLTagObject($ntb("EBAComboBoxButton"+uid));
var img=$ntb("EBAComboBoxButtonImg"+uid);
var _a6=nitobi.html.Css.getStyle(img,"background-image");
_a6=_a6.replace(/button\.gif/g,"blank.gif");
if(nitobi.browser.IE||nitobi.browser.MOZ){
_a6=_a6.substr(5,_a6.length-7);
}else{
_a6=_a6.substr(4,_a6.length-5);
_a6=_a6.replace(/\\\(/g,"(");
_a6=_a6.replace(/\\\)/g,")");
}
img.src=_a6;
this.m_Img=img;
this._onmouseover=img.onmouseover;
this._onmouseout=img.onmouseout;
this._onclick=img.onclick;
this._onmousedown=img.onmousedown;
this._onmouseup=img.onmouseup;
if(!this.GetCombo().GetEnabled()){
this.Disable();
}
this.m_userTag=null;
};
nitobi.combo.Button.prototype.Disable=function(){
var img=this.m_Img;
img.onmouseover=null;
img.onmouseout=null;
img.onclick=null;
img.onmousedown=null;
img.onmouseup=null;
img.className="ntb-combobox-button-img-disabled";
};
nitobi.combo.Button.prototype.Enable=function(){
var img=this.m_Img;
img.onmouseover=this._onmouseover;
img.onmouseout=this._onmouseout;
img.onclick=this._onclick;
img.onmousedown=this._onmousedown;
img.onmouseup=this._onmouseup;
img.className="ntb-combobox-button-img";
};
nitobi.lang.defineNs("nitobi.combo");
if(nitobi.combo==null){
nitobi.combo=function(){
};
}
nitobi.combo.numCombosToLoad=0;
nitobi.combo.numCombosToLoadInitially=4;
nitobi.combo.loadDelayMultiplier=10;
nitobi.getCombo=function(id){
return $ntb(id).jsObject;
};
nitobi.combo.initBase=function(){
if(nitobi.combo.initBase.done==false){
var _aa=[];
var _ab=document.getElementsByTagName((!nitobi.browser.IE)?"eba:ComboPanel":"combopanel");
var _ac=((!nitobi.browser.IE)?document.getElementsByTagName("ntb:ComboPanel"):[]);
for(var i=0;i<_ac.length;i++){
_aa.push(_ac[i]);
}
for(var i=0;i<_ab.length;i++){
_aa.push(_ab[i]);
}
for(var i=0;i<_aa.length;i++){
_aa[i].style.display="none";
}
nitobi.combo.createLanguagePack();
if(nitobi.browser.IE){
nitobi.combo.iframeBacker=document.createElement("IFRAME");
nitobi.combo.iframeBacker.style.position="absolute";
nitobi.combo.iframeBacker.style.zindex="1000";
nitobi.combo.iframeBacker.style.visibility="hidden";
nitobi.combo.iframeBacker.name="nitobi.combo.iframeBacker_Id";
nitobi.combo.iframeBacker.id="nitobi.combo.iframeBacker_Id";
nitobi.combo.iframeBacker.frameBorder=0;
nitobi.combo.iframeBacker.src="javascript:true";
nitobi.html.insertAdjacentElement(document.body,"afterBegin",nitobi.combo.iframeBacker);
}
nitobi.combo.initBase.done=true;
}
};
nitobi.combo.initBase.done=false;
nitobi.initCombo=function(el){
nitobi.combo.initBase();
var tag;
if(typeof (el)=="string"){
tag=$ntb(el);
}else{
tag=el;
}
tag.object=new nitobi.combo.Combo(tag);
tag.object.Initialize();
tag.object.GetList().Render();
return tag.object;
};
nitobi.initCombos=function(){
nitobi.combo.initBase();
var _b0=[];
var _b1=document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
var _b2=((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
for(var i=0;i<_b2.length;i++){
_b0.push(_b2[i]);
}
for(var i=0;i<_b1.length;i++){
_b0.push(_b1[i]);
}
if(0==document.styleSheets.length){
alert("You are missing a link to the Web ComboBoxes' style sheet.");
}else{
nitobi.combo.numCombosToLoad=_b0.length;
for(var i=0;i<_b0.length;i++){
try{
if(i>=nitobi.combo.numCombosToLoadInitially){
var _b4=i*nitobi.combo.loadDelayMultiplier;
window.setTimeout("try{$ntb('"+_b0[i].id+"').object = new nitobi.combo.Combo($ntb('"+_b0[i].id+"'));$ntb('"+_b0[i].id+"').object.Initialize();}catch(err){alert(err.message);}",_b4);
}else{
nitobi.initCombo(_b0[i]);
}
}
catch(err){
alert(err.message);
}
}
}
};
function InitializeEbaCombos(){
nitobi.initCombos();
}
nitobi.combo.finishInit=function(){
nitobi.combo.resize();
nitobi.html.attachEvent(window,"resize",nitobi.combo.resize);
if(window.addEventListener){
window.addEventListener("unload",nitobi.combo.unloadAll,false);
}else{
if(document.addEventListener){
document.addEventListener("unload",nitobi.combo.unloadAll,false);
}else{
if(window.attachEvent){
window.attachEvent("onunload",nitobi.combo.unloadAll);
}else{
if(window.onunload){
window.XTRonunload=window.onunload;
}
window.onunload=nitobi.combo.unloadAll;
}
}
}
try{
eval("try{OnAfterIntializeEbaCombos()} catch(err){}");
}
catch(err){
}
};
nitobi.combo.unloadAll=function(){
var _b5=[];
var _b6=document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
var _b7=((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
for(var i=0;i<_b7.length;i++){
_b5.push(_b7[i]);
}
for(var i=0;i<_b6.length;i++){
_b5.push(_b6[i]);
}
if(_b5){
for(var i=0;i<_b5.length;i++){
if((_b5[i])&&(_b5[i].object)){
_b5[i].object.Unload();
_b5[i].object=null;
}
}
_b5=null;
}
if(nitobi.browser.IE){
if(nitobi.combo.iframeBacker){
delete nitobi.combo.iframeBacker;
nitobi.combo.iframeBacker=null;
}
}
};
nitobi.combo.resize=function(){
var _b9=[];
var _ba=document.getElementsByTagName((!nitobi.browser.IE)?"eba:Combo":"combo");
var _bb=((!nitobi.browser.IE)?document.getElementsByTagName("ntb:Combo"):[]);
for(var i=0;i<_bb.length;i++){
_b9.push(_bb[i]);
}
for(var i=0;i<_ba.length;i++){
_b9.push(_ba[i]);
}
for(var i=0;i<_b9.length;i++){
var _bd=_b9[i].object;
if("smartlist"!=_bd.mode){
if(_bd.GetWidth()!=null){
var _be=_bd.GetUniqueId();
var _bf=_bd.GetTextBox();
var _c0=_bd.GetList();
var _c1=$ntb(_bd.GetId());
var _c2=parseInt(_bd.GetWidth());
if((!nitobi.browser.IE)&&nitobi.Browser.GetMeasurementUnitType(_bd.GetWidth())=="px"){
_c2=parseInt(_bd.GetWidth());
}
var _c3=$ntb("EBAComboBoxButtonImg"+_be);
var _c4;
if(null!=_c3){
_c4=nitobi.html.getWidth(_c3);
}else{
_c4=0;
}
_bf.SetWidth((_c2-_c4)+"px");
_c0.OnWindowResized();
}
}
}
};
nitobi.combo.Combo=function(_c5){
var _c6="";
var _c7="GET";
var _c8="You must specify an Id for the combo box";
var _c9="ntb:Combo could not correctly transform XML data. Do you have the MS XML libraries installed? These are typically installed with your browser and are freely available from Microsoft.";
this.Version="3.5";
((null==_c5.id)||(""==_c5.id))?alert(_c8):this.SetId(_c5.id);
var _ca=null;
var _cb=null;
var _cc=null;
var _cd=null;
_c5.object=this;
_c5.jsObject=this;
this.m_userTag=_c5;
var _ce=null;
this.BuildWarningList();
var _cf=this.m_userTag.getAttribute("DisabledWarningMessages");
if(!((null==_cf)||(""==_cf))){
this.SetDisabledWarningMessages(_cf);
}
var _d0=this.m_userTag.getAttribute("ErrorLevel");
((null==_d0)||(""==_d0))?this.SetErrorLevel(""):this.SetErrorLevel(_d0);
_c5.innerHTML=_c5.innerHTML.replace(/>\s+</g,"><").replace(/^\s+</,"<").replace(/>\s+$/,">");
var dtf=_c5.getAttribute("DataTextField");
var dvf=_c5.getAttribute("DataValueField");
if((null==dtf)||(""==dtf)){
dtf=dvf;
_c5.setAttribute("DataTextField",dtf);
}
this.SetDataTextField(dtf);
this.SetDataValueField(dvf);
if((null!=dtf)&&(""!=dtf)){
if((null==dvf)||(""==dvf)){
dvf=dtf;
}
this.SetDataValueField(dvf);
}
for(var i=0;i<_c5.childNodes.length;i++){
var _d4=_c5.childNodes[i];
var n=_d4.tagName;
if(n){
n=n.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"");
switch(n){
case "combobutton":
_cc=_d4;
break;
case "combotextbox":
_cd=_d4;
break;
case "combolist":
_cb=_d4;
break;
case "xmldatasource":
_ca=_d4;
break;
case "combovalues":
_ce=_d4;
}
}
}
var _d6="default";
var _d7=this.m_userTag.getAttribute("Mode");
if(null!=_d7){
_d7=_d7.toLowerCase();
}
switch(_d7){
case "smartsearch":
case "smartlist":
case "compact":
case "filter":
case "unbound":
this.mode=_d7;
break;
default:
this.mode=_d6;
}
var _d8=(_cb==null?null:_cb.getAttribute("DatasourceUrl"));
if((_ce==null&&_d8==null)&&this.mode!="compact"){
this.mode=_d6;
}
var _d9=25;
if(null!=_cb){
var ps=_cb.getAttribute("PageSize");
if(ps!=null&&ps!=""){
_d9=ps;
}
}
var _db=_c5.getAttribute("InitialSearch");
this.m_InitialSearch="";
if((null==_db)||(""==_db)){
this.m_InitialSearch=_c6;
}else{
this.m_InitialSearch=_db;
}
var rt=_c5.getAttribute("HttpRequestMethod");
((null==rt)||(""==rt))?this.SetHttpRequestMethod(_c7):this.SetHttpRequestMethod(rt);
this.m_NoDataIsland=_ce==null&&_d8!=null&&_ca==null;
if(this.m_NoDataIsland){
var id=_c5.id+"XmlDataSource";
_cb.setAttribute("XmlId",id);
_ca=_cb;
_d8+=(_d8.indexOf("?")==-1?"?":"&");
_d8+="PageSize="+_d9;
_d8+="&StartingRecordIndex=0"+"&ComboId="+encodeURI(this.GetId())+"&LastString=";
if(this.m_InitialSearch!=null&&this.m_InitialSearch!=""){
_d8+="&SearchSubstring="+encodeURI(this.m_InitialSearch);
}
var _de=nitobi.Browser.LoadPageFromUrl(_d8,this.GetHttpRequestMethod());
var _df=_de.indexOf("<?xml");
if(_df!=-1){
_de=(_de.substr(_df));
}
var d=nitobi.xml.createXmlDoc(_de);
d.async=false;
var d2=nitobi.xml.createXmlDoc(d.xml.replace(/>\s+</g,"><"));
d2=xbClipXml(d2,"root","e",_d9);
document[id]=d2;
}
var _e2=(this.mode==_d6||this.mode=="unbound");
if(_e2){
this.SetButton(new nitobi.combo.Button(_cc,this));
}
this.SetList(new nitobi.combo.List(_cb,_ca,_ce,this));
this.SetTextBox(new nitobi.combo.TextBox(_cd,this,_e2));
this.m_Over=false;
};
nitobi.combo.Combo.prototype.BuildWarningList=function(){
this.m_WarningMessagesEnabled=new Array();
this.m_DisableAllWarnings=false;
this.m_WarningMessages=new Array();
this.m_WarningMessages["cw001"]="The combo tried to search the server datasource for data.  "+"The server returned data, but no match was found within this data by the combo. The most "+"likely cause for this warning is that the combo mode does not match the gethandler SQL query type: "+"the sql query is not matching in the same way the combo is. Consult the documentation to see what "+"matches to use given the combo's mode.";
this.m_WarningMessages["cw002"]="The combo tried to load XML data from the page. However, it encountered a tag attribute of the form <tag att='___'/> instead"+" of the form <tag att=\"___\"/>. A possible reason for this is encoding ' as &apos;. To fix this error correct the tag to use "+"<tag att=\"__'___\"/>. If you are manually encoding data, eg. for an unbound combo, do not encode ' as &apos; and do not use ' as your string literal. If you believe, "+"this warning was generated in error, you can disable it.";
this.m_WarningMessages["cw003"]="The combo failed to load and parse the XML sent by the gethandler. Check your gethandler to ensure that it is delivering valid XML.";
};
nitobi.combo.Combo.prototype.SetDisabledWarningMessages=function(_e3){
if(_e3=="*"){
this.m_DisableAllWarnings=true;
}else{
this.m_DisableAllWarnings=false;
_e3=_e3.toLowerCase();
_e3=_e3.split(",");
for(var i=0;i<_e3.length;i++){
this.m_WarningMessagesEnabled[_e3[i]]=false;
}
}
};
nitobi.combo.Combo.prototype.IsWarningEnabled=function(_e5){
if(this.m_ErrorLevel==""){
return;
}else{
if(this.m_WarningMessagesEnabled[_e5]==null){
this.m_WarningMessagesEnabled[_e5]=true;
}
return this.m_WarningMessagesEnabled[_e5]&&this.m_DisableAllWarnings==false;
}
};
nitobi.combo.Combo.prototype.SetErrorLevel=function(_e6){
this.m_ErrorLevel=_e6.toLowerCase();
};
nitobi.combo.Combo.prototype.GetWidth=function(){
return this.m_Width;
};
nitobi.combo.Combo.prototype.SetWidth=function(_e7){
this.m_Width=_e7;
};
nitobi.combo.Combo.prototype.GetHeight=function(){
return this.m_Height;
};
nitobi.combo.Combo.prototype.SetHeight=function(_e8){
this.m_Height=_e8;
};
function _EBAMemScrub(_e9){
for(var _ea in _e9){
if((_ea.indexOf("m_")==0)||(_ea.indexOf("$")==0)){
_e9[_ea]=null;
}
}
}
nitobi.combo.Combo.prototype.Unload=function(){
if(this.m_Callback){
delete this.m_Callback;
this.m_Callback=null;
}
if(this.m_TextBox){
this.m_TextBox.Unload();
delete this.m_TextBox;
this.m_TextBox=null;
}
if(this.m_List){
this.m_List.Unload();
delete this.m_List;
this.m_List=null;
}
if(this.m_Button){
this.m_Button.Unload();
delete m_Button;
}
var _eb=this.GetHTMLTagObject();
_EBAMemScrub(this);
_EBAMemScrub(_eb);
};
nitobi.combo.Combo.prototype.GetHttpRequestMethod=function(){
return this.m_HttpRequestMethod;
};
nitobi.combo.Combo.prototype.SetHttpRequestMethod=function(_ec){
if(null==this.m_HTMLTagObject){
this.m_HttpRequestMethod=_ec;
}else{
this.m_HTMLTagObject.className=_ec;
}
};
nitobi.combo.Combo.prototype.GetCSSClassName=function(){
return (null==this.m_HTMLTagObject?this.m_CSSClassName:this.m_HTMLTagObject.className);
};
nitobi.combo.Combo.prototype.SetCSSClassName=function(_ed){
if(null==this.m_HTMLTagObject){
this.m_CSSClassName=_ed;
}else{
this.m_HTMLTagObject.className=_ed;
}
};
nitobi.combo.Combo.prototype.GetInitialSearch=function(){
return this.m_InitialSearch;
};
nitobi.combo.Combo.prototype.SetInitialSearch=function(_ee){
this.m_InitialSearch=_ee;
};
nitobi.combo.Combo.prototype.GetListZIndex=function(){
return this.m_ListZIndex;
};
nitobi.combo.Combo.prototype.SetListZIndex=function(_ef){
this.m_ListZIndex=_ef;
};
nitobi.combo.Combo.prototype.GetMode=function(){
return this.mode;
};
nitobi.combo.Combo.prototype.GetOnBlurEvent=function(){
return this.m_OnBlurEvent;
};
nitobi.combo.Combo.prototype.SetOnBlurEvent=function(_f0){
this.m_OnBlurEvent=_f0;
};
nitobi.combo.Combo.prototype.OnBlurEvent=function(){
};
nitobi.combo.Combo.prototype.SetFocus=function(){
this.GetTextBox().m_HTMLTagObject.focus();
};
nitobi.combo.Combo.prototype.GetOnFocusEvent=function(){
return this.m_OnFocusEvent;
};
nitobi.combo.Combo.prototype.SetOnFocusEvent=function(_f1){
this.m_OnFocusEvent=_f1;
};
nitobi.combo.Combo.prototype.GetOnLoadEvent=function(){
if("void"==this.m_OnLoadEvent){
return "";
}
return this.m_OnLoadEvent;
};
nitobi.combo.Combo.prototype.SetOnLoadEvent=function(_f2){
this.m_OnLoadEvent=_f2;
};
nitobi.combo.Combo.prototype.GetOnSelectEvent=function(){
if("void"==this.m_OnSelectEvent){
return "";
}
return this.m_OnSelectEvent;
};
nitobi.combo.Combo.prototype.SetOnSelectEvent=function(_f3){
this.m_OnSelectEvent=_f3;
};
nitobi.combo.Combo.prototype.GetOnBeforeSelectEvent=function(){
if("void"==this.m_OnBeforeSelectEvent){
return "";
}
return this.m_OnBeforeSelectEvent;
};
nitobi.combo.Combo.prototype.SetOnBeforeSelectEvent=function(_f4){
this.m_OnBeforeSelectEvent=_f4;
};
nitobi.combo.Combo.prototype.GetHTMLTagObject=function(){
return this.m_HTMLTagObject;
};
nitobi.combo.Combo.prototype.SetHTMLTagObject=function(_f5){
this.m_HTMLTagObject=_f5;
};
nitobi.combo.Combo.prototype.GetUniqueId=function(){
return this.m_UniqueId;
};
nitobi.combo.Combo.prototype.SetUniqueId=function(_f6){
this.m_UniqueId=_f6;
};
nitobi.combo.Combo.prototype.GetId=function(){
return this.m_Id;
};
nitobi.combo.Combo.prototype.SetId=function(Id){
this.m_Id=Id;
};
nitobi.combo.Combo.prototype.GetButton=function(){
return this.m_Button;
};
nitobi.combo.Combo.prototype.SetButton=function(_f8){
this.m_Button=_f8;
};
nitobi.combo.Combo.prototype.GetList=function(){
return this.m_List;
};
nitobi.combo.Combo.prototype.SetList=function(_f9){
this.m_List=_f9;
};
nitobi.combo.Combo.prototype.GetTextBox=function(){
return this.m_TextBox;
};
nitobi.combo.Combo.prototype.SetTextBox=function(_fa){
this.m_TextBox=_fa;
};
nitobi.combo.Combo.prototype.GetTextValue=function(){
return this.GetTextBox().GetValue();
};
nitobi.combo.Combo.prototype.SetTextValue=function(_fb){
this.GetTextBox().SetValue(_fb);
};
nitobi.combo.Combo.prototype.GetSelectedRowValues=function(){
return this.GetList().GetSelectedRowValues();
};
nitobi.combo.Combo.prototype.SetSelectedRowValues=function(_fc){
this.GetList().SetSelectedRowValues(_fc);
};
nitobi.combo.Combo.prototype.GetSelectedRowIndex=function(){
return this.GetList().GetSelectedRowIndex();
};
nitobi.combo.Combo.prototype.SetSelectedRowIndex=function(_fd){
this.GetList().SetSelectedRowIndex(_fd);
};
nitobi.combo.Combo.prototype.GetDataTextField=function(){
return this.m_DataTextField;
};
nitobi.combo.Combo.prototype.SetDataTextField=function(_fe){
this.m_DataTextField=_fe;
var _ff=$ntb(this.GetId()+"DataTextFieldIndex");
if(null!=_ff){
var _100=this.GetList().GetXmlDataSource().GetColumnIndex(_fe);
_ff.value=_100;
}
};
nitobi.combo.Combo.prototype.GetDataValueField=function(){
return this.m_DataValueField;
};
nitobi.combo.Combo.prototype.SetDataValueField=function(_101){
this.m_DataValueField=_101;
var _102=$ntb(this.GetId()+"DataValueFieldIndex");
if(null!=_102){
var _103=this.GetList().GetXmlDataSource().GetColumnIndex(_101);
_102.value=_103;
}
};
nitobi.combo.Combo.prototype.GetSelectedItem=function(){
var _104=new Object;
_104.Value=null;
_104.Text=null;
var _105=this.GetList().GetSelectedRowIndex();
if(-1!=_105){
var _106=this.GetList().GetXmlDataSource();
var row=_106.GetRow(_105);
var _108=_106.GetColumnIndex(this.GetDataValueField());
if(-1!=_108){
_104.Value=row[_108];
}
_108=_106.GetColumnIndex(this.GetDataTextField());
if(-1!=_108){
_104.Text=row[_108];
}
}
return _104;
};
nitobi.combo.Combo.prototype.GetOnHideEvent=function(){
return this.GetList().GetOnHideEvent();
};
nitobi.combo.Combo.prototype.SetOnHideEvent=function(_109){
this.GetList().SetOnHideEvent(_109);
};
nitobi.combo.Combo.prototype.GetOnTabEvent=function(){
return this.m_OnTabEvent;
};
nitobi.combo.Combo.prototype.SetOnTabEvent=function(_10a){
this.m_OnTabEvent=_10a;
};
nitobi.combo.Combo.prototype.GetEventObject=function(){
return this.m_EventObject;
};
nitobi.combo.Combo.prototype.SetEventObject=function(_10b){
this.m_EventObject=_10b;
};
nitobi.combo.Combo.prototype.GetSmartListSeparator=function(){
return this.SmartListSeparator;
};
nitobi.combo.Combo.prototype.SetSmartListSeparator=function(_10c){
this.SmartListSeparator=_10c;
};
nitobi.combo.Combo.prototype.GetTabIndex=function(){
return this.m_TabIndex;
};
nitobi.combo.Combo.prototype.SetTabIndex=function(_10d){
this.m_TabIndex=_10d;
};
nitobi.combo.Combo.prototype.GetEnabled=function(){
return this.m_Enabled;
};
nitobi.combo.Combo.prototype.SetEnabled=function(_10e){
this.m_Enabled=_10e;
var t=this.GetTextBox();
if(null!=t.GetHTMLTagObject()){
if(_10e){
t.Enable();
}else{
t.Disable();
}
}
var b=this.GetButton();
if(null!=b&&null!=b.m_Img){
if(_10e){
b.Enable();
}else{
b.Disable();
}
}
};
nitobi.combo.Combo.prototype.Initialize=function(){
var _111="ComboBox";
var _112="outlook";
var _113="";
var _114="";
var _115="";
var _116="";
var _117="";
var _118="";
var _119="0";
var _11a=true;
var _11b="default";
var _11c=1000;
var _11d=",";
var _11e="";
var _11f="";
var _120=this.m_userTag.getAttribute("ListZIndex");
((null==_120)||(""==_120))?this.SetListZIndex(_11c):this.SetListZIndex(_120);
this.SetWidth(this.m_userTag.getAttribute("Width"));
this.SetHeight(this.m_userTag.getAttribute("Height"));
this.theme=this.m_userTag.getAttribute("theme");
if((this.theme==null)||(""==this.theme)){
this.theme=_112;
}
var sls=this.m_userTag.getAttribute("SmartListSeparator");
((null==sls)||(""==sls))?this.SetSmartListSeparator(_11d):this.SetSmartListSeparator(sls);
var _122=this.m_userTag.getAttribute("Enabled");
((null==_122)||(""==_122))?this.SetEnabled(_11a):this.SetEnabled("true"==_122.toLowerCase());
var _123=this.m_userTag.getAttribute("TabIndex");
((null==_123)||(""==_123))?this.SetTabIndex(_119):this.SetTabIndex(_123);
var _124=this.m_userTag.getAttribute("OnTabEvent");
((null==_124)||(""==_124))?this.SetOnTabEvent(_118):this.SetOnTabEvent(_124);
this.SetEventObject(null);
var _125=this.m_userTag.getAttribute("OnFocusEvent");
((null==_125)||(""==_125))?this.SetOnFocusEvent(_117):this.SetOnFocusEvent(_125);
var _126=this.m_userTag.getAttribute("OnBlurEvent");
((null==_126)||(""==_126))?this.SetOnBlurEvent(_116):this.SetOnBlurEvent(_126);
var ose=this.m_userTag.getAttribute("OnSelectEvent");
((null==ose)||(""==ose))?this.SetOnSelectEvent(_113):this.SetOnSelectEvent(ose);
var ole=this.m_userTag.getAttribute("OnLoadEvent");
((null==ole)||(""==ole))?this.SetOnLoadEvent(_114):this.SetOnLoadEvent(ole);
var obse=this.m_userTag.getAttribute("OnBeforeSelectEvent");
((null==obse)||(""==obse))?this.SetOnBeforeSelectEvent(_115):this.SetOnBeforeSelectEvent(obse);
var css=this.m_userTag.getAttribute("CSSClassName");
((null==css)||(""==css))?this.SetCSSClassName(_111):this.SetCSSClassName(css);
var _12b=this.m_userTag.uniqueID;
this.SetUniqueId(_12b);
if(this.GetWidth()!=null){
if("smartlist"==this.mode){
this.m_TextBox.SetWidth(this.GetWidth());
this.m_TextBox.SetHeight(this.GetHeight());
}
if(nitobi.Browser.GetMeasurementUnitType(this.GetWidth())=="%"){
this.m_userTag.style.display="block";
}else{
this.m_userTag.style.display="inline";
}
if("smartlist"==this.mode){
this.m_userTag.style.height=this.GetHeight();
}else{
this.m_userTag.style.overflow="hidden";
}
}
var html="<span id='EBAComboBox"+_12b+"' class='ntb-combo-reset "+this.GetCSSClassName()+"' "+"onMouseOver='$ntb(\""+this.GetId()+"\").object.m_Over=true' "+"onMouseOut='$ntb(\""+this.GetId()+"\").object.m_Over=false'>"+"<span id='EBAComboBoxTextAndButton"+_12b+"' class='ComboBoxTextAndButton'><nobr>";
var id="";
var _12e=this.GetId();
for(var i=0,n=this.GetList().GetXmlDataSource().GetNumberColumns();i<n;i++){
id=_12e+"SelectedValue"+i;
html+="<input type='HIDDEN' id='"+id+"' name='"+id+"'></input>";
}
id=_12e+"SelectedRowIndex";
html+="<input type='HIDDEN' id='"+id+"' name='"+id+"' value='"+this.GetSelectedRowIndex()+"'></input>";
var _131=this.GetDataTextField();
id=_12e+"DataTextFieldIndex";
var _132=this.GetList().m_XmlDataSource.GetColumnIndex(_131);
html+="<input type='HIDDEN' id='"+id+"' name='"+id+"' value='"+_132+"'></input>";
id=_12e+"DataValueFieldIndex";
var _133=this.GetDataValueField();
_132=this.GetList().m_XmlDataSource.GetColumnIndex(_133);
html+="<input type='HIDDEN' id='"+id+"' name='"+id+"' value='"+_132+"'></input>";
html+="<div class=\" ntb-combo-reset "+this.theme+"\">";
html+=this.GetTextBox().GetHTMLRenderString();
var _134=(this.mode=="default"||this.mode=="unbound");
if(_134){
html+=this.GetButton().GetHTMLRenderString();
}
html+="<div style=\"overflow: hidden; display: block; clear: both; float: none; height: 0px; width: auto;\"><!-- --></div>";
html+="</div>";
html+="</nobr></span></span>";
nitobi.html.insertAdjacentHTML(this.m_userTag,"beforeEnd",html);
this.SetHTMLTagObject($ntb("EBAComboBox"+_12b));
this.GetTextBox().Initialize();
if(_134){
this.GetButton().Initialize();
}
var is=this.m_InitialSearch;
if(null!=is&&""!=is){
this.InitialSearch(is);
}
eval(this.GetOnLoadEvent());
this.m_userTag=null;
nitobi.combo.numCombosToLoad--;
if(nitobi.combo.numCombosToLoad==0){
nitobi.combo.finishInit();
}
};
nitobi.combo.Combo.prototype.InitialSearch=function(_136){
var list=this.GetList();
var tb=this.GetTextBox();
var dfi=tb.GetDataFieldIndex();
list.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_EXPIRED);
list.InitialSearchOnce=true;
this.m_Callback=_EbaComboCallback;
list.Search(_136,dfi,this.m_Callback,this.m_NoDataIsland);
};
function _EbaComboCallback(_13a,list){
if(_13a>=0){
var tb=list.GetCombo().GetTextBox();
var row=list.GetRow(_13a);
list.SetActiveRow(row);
list.SetSelectedRow(_13a);
tb.SetValue(list.GetSelectedRowValues()[tb.GetDataFieldIndex()]);
list.scrollOnce=true;
list.InitialSearchOnce=false;
}else{
var _13e=list.GetCombo();
_13e.SetTextValue(_13e.GetInitialSearch());
}
}
nitobi.combo.Combo.prototype.GetFieldFromActiveRow=function(_13f){
var l=this.GetList();
if(null!=l){
var r=l.GetActiveRow();
if(null!=r){
var y=l.GetRowIndex(r);
var d=l.GetXmlDataSource();
var x=d.GetColumnIndex(_13f);
return d.GetRowCol(y,x);
}
}
return null;
};
function Iframe(_145,h,w,_148){
if(!_145){
var msg="Iframe constructor: attachee is null!";
alert(msg);
throw msg;
}
var d=document;
var oIF=d.createElement("IFRAME");
var s=oIF.style;
this.oIFStyle=s;
this.attachee=_145;
this.attach();
s.position="absolute";
w=w||_145.offsetWidth;
s.width=w;
s.height=h||0;
s.display="none";
s.overflow="hidden";
var name="IFRAME"+oIF.uniqueID;
oIF.name=name;
oIF.id=name;
oIF.frameBorder=0;
oIF.src="javascript:true";
var _14e=Browser_GetParentElementByTagName(_148,"form");
if(null==_14e){
_14e=d.body;
}
_14e.appendChild(oIF);
var oF=window.frames[name];
var oD=oF.document;
oD.open();
oD.write("<html><head></head><body style=\"margin:0;background-color:white;\"><span id=\"bodySpan\" class=\"ntb-combobox-list-outer-border\" style=\"overflow:hidden;float:left;border-width:1px;border-style:solid;width:"+(w-(nitobi.browser.MOZ?2:0))+";height:"+(h-(nitobi.browser.MOZ?2:0))+";\"></span></body></html>");
oD.close();
var dss=d.styleSheets;
var ss=oD.createElement("LINK");
for(var i=0,n=dss.length;i<n;i++){
var ss2=ss.cloneNode(true);
ss2.rel=(nitobi.browser.IE?dss[i].owningElement.rel:dss[i].ownerNode.rel);
ss2.type="text/css";
ss2.href=dss[i].href;
ss2.title=dss[i].title;
oD.body.appendChild(ss2);
}
var head=oD.getElementsByTagName("head")[0];
var ds=(d.scripts?d.scripts:d.getElementsByTagName("script"));
var st=oD.createElement("SCRIPT");
var src=null;
for(var i=0,n=ds.length;i<n;i++){
src=ds[i].src;
if(""!=src){
var st2=st.cloneNode(true);
st2.language=ds[i].language;
st2.src=src;
head.appendChild(st2);
}
}
this.oIF=oIF;
this.oF=oF;
this.d=oD;
this.bodySpan=oD.getElementById("bodySpan");
this.bodySpanStyle=this.bodySpan.style;
if(window.addEventListener){
window.addEventListener("resize",this,false);
}else{
if(window.attachEvent){
if(!window.g_Iframe_oIFs){
window.g_Iframe_oIFs=new Array;
window.g_Iframe_onresize=window.onresize;
Iframe_oResize();
window.onresize=window.oResize.check1;
}
window.g_Iframe_oIFs[name]=this;
}
}
}
Iframe.prototype.Unload=Iframe_Unload;
function Iframe_Unload(){
if(this.oIF){
delete this.oIF;
}
}
var g_Iframe_oIFs=null;
var g_Iframe_onresize=null;
function Iframe_onafterresize(){
for(var f in window.g_Iframe_oIFs){
var oIF=window.g_Iframe_oIFs[f];
oIF.attach();
}
if(window.g_Iframe_onresize){
window.g_Iframe_onresize();
}
}
function Iframe_dfxWinXY(w){
var b,d,x,y;
x=y=0;
var d=window.document;
if(d.body){
b=d.documentElement.clientWidth?d.documentElement:d.body;
x=b.clientWidth||0;
y=b.clientHeight||0;
}
return {x:x,y:y};
}
function Iframe_oResize(){
window.oResize={CHECKTIME:500,oldXY:Iframe_dfxWinXY(window),timerId:0,check1:function(){
window.oResize.check2();
},check2:function(){
if(this.timerId){
window.clearTimeout(this.timerId);
}
this.timerId=setTimeout("window.oResize.check3()",this.CHECKTIME);
},check3:function(){
var _162=Iframe_dfxWinXY(window);
this.timerId=0;
if((_162.x!=this.oldXY.x)||(_162.y!=this.oldXY.y)){
this.oldXY=_162;
Iframe_onafterresize();
}
}};
}
Iframe.prototype.handleEvent=Iframe_handleEvent;
function Iframe_handleEvent(evt){
switch(evt.type){
case "resize":
if(this.isVisible()){
this.attach();
}
break;
}
}
Iframe.prototype.offset=Iframe_offset;
function Iframe_offset(o,attr,a){
var x=(a?o[attr]:0);
var _o=o;
while(o){
x+=(a?0:o[attr]);
if(nitobi.browser.IE&&"TABLE"==o.tagName&&"0"!=o.border&&""!=o.border){
x++;
}
o=o.offsetParent;
}
return x;
}
Iframe.prototype.setHeight=Iframe_setHeight;
function Iframe_setHeight(h,_16a){
h=parseInt(h);
this.oIFStyle.height=h;
if(_16a!=true){
this.bodySpanStyle.height=(h-(nitobi.browser.MOZ?parseInt(this.bodySpanStyle.borderTopWidth)+parseInt(this.bodySpanStyle.borderBottomWidth):0));
}
}
Iframe.prototype.setWidth=Iframe_setWidth;
function Iframe_setWidth(w){
w=parseInt(w);
this.oIFStyle.width=w;
this.bodySpanStyle.width=(w-(nitobi.browser.MOZ?parseInt(this.bodySpanStyle.borderLeftWidth)+parseInt(this.bodySpanStyle.borderRightWidth):0));
}
Iframe.prototype.show=Iframe_show;
function Iframe_show(){
this.attach();
this.oIFStyle.display="inline";
}
Iframe.prototype.hide=Iframe_hide;
function Iframe_hide(){
this.oIFStyle.display="none";
}
Iframe.prototype.toggle=Iframe_toggle;
function Iframe_toggle(){
if(this.isVisible()){
this.hide();
}else{
this.show();
}
}
Iframe.prototype.isVisible=Iframe_isVisible;
function Iframe_isVisible(){
return "inline"==this.oIFStyle.display;
}
Iframe.prototype.attach=Iframe_attach;
function Iframe_attach(){
var _16c=this.attachee;
var a=(_16c.offsetParent&&"absolute"==_16c.offsetParent.style.position);
this.oIFStyle.top=this.offset(_16c,"offsetTop",a)+_16c.offsetHeight-1+(a?parseInt(_16c.offsetParent.style.top):0);
this.oIFStyle.left=this.offset(_16c,"offsetLeft",a)+(a?parseInt(_16c.offsetParent.style.left):0);
}
var EbaComboUiServerError=0;
var EbaComboUiNoRecords=1;
var EbaComboUiEndOfRecords=2;
var EbaComboUiNumRecords=3;
var EbaComboUiPleaseWait=4;
nitobi.combo.createLanguagePack=function(){
try{
if(typeof (EbaComboUi)=="undefined"){
EbaComboUi=new Array();
EbaComboUi[EbaComboUiServerError]="The ComboBox tried to retrieve information from the server, but an error occured. Please try again later.";
EbaComboUi[EbaComboUiNoRecords]="No new records.";
EbaComboUi[EbaComboUiEndOfRecords]="End of records.";
EbaComboUi[EbaComboUiNumRecords]=" records.";
EbaComboUi[EbaComboUiPleaseWait]="Please Wait...";
}
}
catch(err){
alert("The default language pack could not be loaded.  "+err.message);
}
};
nitobi.lang.defineNs("nitobi.combo");
EBAComboBoxListHeader=0;
EBAComboBoxListBody=1;
EBAComboBoxListFooter=2;
EBAComboBoxListBodyTable=3;
EBAComboBoxListNumSections=4;
EBAComboBoxList=5;
EBADatabaseSearchTimeoutStatus_WAIT=0;
EBADatabaseSearchTimeoutStatus_EXPIRED=1;
EBADatabaseSearchTimeoutStatus_NONE=2;
EBADatabaseSearchTimeoutWait=200;
EBAMoveAction_UP=0;
EBAMoveAction_DOWN=1;
EBAScrollToNone=0;
EBAScrollToTop=1;
EBAScrollToBottom=2;
EBAScrollToNewTop=3;
EBAScrollToTypeAhead=4;
EBAScrollToNewBottom=5;
EBAComboSearchNoRecords=0;
EBAComboSearchNewRecords=1;
EBADefaultScrollbarSize=18;
nitobi.combo.List=function(_16e,_16f,_170,_171){
this.m_Rendered=false;
var _172="ntb-combobox-button";
var _173="150px";
var _174=new Array("50px","100px","50px");
var _175=new Array("ntb-combobox-list-header","ntb-combobox-list-body","ntb-combobox-list-footer","ntb-combobox-list-body-table");
var _176="ntb-combobox-list-body-table-row-highlighted";
var _177="highlight";
var _178="highlighttext";
var _179="";
var _17a=-1;
var _17b=_171.mode=="default";
var _17c="hidden";
var _17d=false;
var _17e=_171.mode!="default";
var _17f;
if(_171.mode!="classic"){
_17f=10;
}else{
_17f=25;
}
var _180="";
var _181="";
var _182="";
var _183="";
var _184=0;
var _185=0;
var _186="EBA:Combo could not correctly transform XML data. Do you have the MS XML libraries installed? These are typically installed with your browser and are freely available from Microsoft.";
var _187="<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\" xmlns:eba=\"http://developer.ebusiness-apps.com\" xmlns:ntb=\"http://www.nitobi.com\" exclude-result-prefixes=\"eba ntb\">"+"<xsl:output method=\"xml\" version=\"4.0\" omit-xml-declaration=\"yes\" />"+"<xsl:template match=\"/\">"+"<xsl:apply-templates select=\"eba:ComboValues|ntb:ComboValues\"/>"+"</xsl:template>"+"<xsl:template match=\"/eba:ComboValues|ntb:ComboValues\">"+"<root>"+"<xsl:attribute name=\"fields\"><xsl:value-of select=\"@fields\" /></xsl:attribute>"+"\t<xsl:apply-templates/>"+"</root>"+"</xsl:template>"+"<xsl:template match=\"eba:ComboValue|eba:combovalue|ntb:ComboValue|ntb:combovalue\">"+"\t<e><xsl:for-each select=\"@*\"><xsl:attribute name=\"{name()}\"><xsl:value-of select=\".\"/></xsl:attribute></xsl:for-each></e>"+"</xsl:template>"+"</xsl:stylesheet>";
this.SetCombo(_171);
var ps=(_16e?_16e.getAttribute("PageSize"):null);
((null==ps)||(""==ps))?this.SetPageSize(_17f):this.SetPageSize(parseInt(ps));
this.clip=(_171.mode=="smartsearch"||_171.mode=="smartlist"||_171.mode=="filter");
var _189=(_16e?_16e.getAttribute("ClipLength"):null);
((null==_189)||(""==_189))?this.SetClipLength(this.GetPageSize()):this.SetClipLength(_189);
var ds=new nitobi.combo.XmlDataSource();
if(_16f!=null){
ds.combo=_171;
var x=(_16f?_16f.getAttribute("XmlId"):"");
ds.SetXmlId(x);
var _18c=document.getElementById(x);
if(!nitobi.browser.IE||null==_18c){
nitobi.Browser.ConvertXmlDataIsland(x,_171.GetHttpRequestMethod());
ds.SetXmlObject(document[x],this.clip,this.clipLength);
}else{
ds.SetXmlObject(_18c);
}
ds.SetLastPageSize(ds.GetNumberRows());
ds.m_Dirty=false;
}
this.SetXmlDataSource(ds);
this.m_httpRequest=new nitobi.ajax.HttpRequest();
this.m_httpRequest.responseType="text";
this.m_httpRequest.onRequestComplete.subscribe(this.onGetComplete,this);
this.unboundMode=false;
if(!_16f){
this.unboundMode=true;
var _18d=null;
var _18e="<eba:ComboValues fields='"+_170.getAttribute("fields")+"' xmlns:eba='http://developer.ebusiness-apps.com' xmlns:ntb='http://www.nitobi.com'>";
if(nitobi.browser.IE){
var _18f=_170.innerHTML.match(/<\?xml:namespace.*?\/>(.*)/);
_18e+=_18f[1]+"</eba:ComboValues>";
}else{
_18e+=_170.innerHTML+"</eba:ComboValues>";
}
_18e=nitobi.Browser.EncodeAngleBracketsInTagAttributes(_18e,_171).replace(/&nbsp;/g,"&#160;").replace(/>\s+</g,"><");
try{
var oXSL=nitobi.xml.createXmlDoc(_187);
tmp=nitobi.xml.createXmlDoc(_18e);
xmlObject=nitobi.xml.transformToXml(tmp,oXSL);
this.GetXmlDataSource().SetXmlObject(xmlObject);
this.GetXmlDataSource().m_Dirty=false;
}
catch(err){
alert(_186);
}
}
this.m_SectionHTMLTagObjects=new Array;
this.m_SectionCSSClassNames=new Array;
this.m_SectionHeights=new Array;
this.m_ListColumnDefinitions=new Array;
var _191=null;
var _192=0;
var _193=null;
var _194=this.GetCombo().GetDataTextField();
var _195=false;
var _196=true;
while(_196){
if(_194!=null||_195==true){
var _197=new Object;
_197.DataFieldIndex=this.GetXmlDataSource().GetColumnIndex(_194);
_197.DataValueIndex=this.GetXmlDataSource().GetColumnIndex(_171.GetDataValueField());
_197.HeaderLabel="";
_197.Width="100%";
this.m_ListColumnDefinitions[0]=new nitobi.combo.ListColumnDefinition(_197);
_196=false;
}else{
var _198=_16e;
if((null==_16e)||(0==_16e.childNodes.length)){
_198=_171.m_userTag;
}
var _199=null;
for(var i=0;i<_198.childNodes.length;i++){
_191=_198.childNodes[i];
_199=_191.tagName;
if(_199){
_199=_199.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"");
if(_199=="combocolumndefinition"){
this.m_ListColumnDefinitions[_192]=new nitobi.combo.ListColumnDefinition(_191);
_192++;
_196=false;
}
}
}
_195=true;
}
}
var _19b=(_16e?_16e.getAttribute("Width"):null);
((null==_19b)||(""==_19b))?this.SetWidth(_173):this.SetWidth(_19b);
var _19c=(_16e?_16e.getAttribute("Overflow-y"):null);
this.m_overflowy=((null==_19c)||(""==_19c))?_17c:_19c;
var chh=(_16e?_16e.getAttribute("CustomHTMLHeader"):null);
((null==chh)||(""==chh))?this.SetCustomHTMLHeader(""):this.SetCustomHTMLHeader(chh);
for(var i=0;i<EBAComboBoxListNumSections;i++){
this.SetSectionCSSClassName(i,_175[i]);
}
for(var i=0;i<=EBAComboBoxListFooter;i++){
this.SetSectionHeight(i,_174[i]);
}
var _19e=(_16e?_16e.getAttribute("Height"):null);
((null==_19e)||(""==_19e))?null:this.SetHeight(parseInt(_19e));
var hccn=(_16e?_16e.getAttribute("HighlightCSSClassName"):null);
if((null==hccn)||(""==hccn)){
this.SetHighlightCSSClassName(_176);
this.m_UseHighlightClass=false;
}else{
this.SetHighlightCSSClassName(hccn);
this.m_UseHighlightClass=true;
}
var bhc=(_16e?_16e.getAttribute("BackgroundHighlightColor"):null);
((null==bhc)||(""==bhc))?this.SetBackgroundHighlightColor(_177):this.SetBackgroundHighlightColor(bhc);
var ohe=(_16e?_16e.getAttribute("OnHideEvent"):null);
((null==ohe)||(""==ohe))?this.SetOnHideEvent(_180):this.SetOnHideEvent(ohe);
var ose=(_16e?_16e.getAttribute("OnShowEvent"):null);
((null==ose)||(""==ose))?this.SetOnShowEvent(_181):this.SetOnShowEvent(ose);
var onbs=(_16e?_16e.getAttribute("OnBeforeSearchEvent"):null);
((null==onbs)||(""==onbs))?this.SetOnBeforeSearchEvent(_182):this.SetOnBeforeSearchEvent(onbs);
var onas=(_16e?_16e.getAttribute("OnAfterSearchEvent"):null);
((null==onas)||(""==onas))?this.SetOnAfterSearchEvent(_183):this.SetOnAfterSearchEvent(onas);
var fhc=(_16e?_16e.getAttribute("ForegroundHighlightColor"):null);
((null==fhc)||(""==fhc))?this.SetForegroundHighlightColor(_178):this.SetForegroundHighlightColor(fhc);
var offx=(_16e?_16e.getAttribute("OffsetX"):null);
((null==offx)||(""==offx))?this.SetOffsetX(_184):this.SetOffsetX(offx);
var offy=(_16e?_16e.getAttribute("OffsetY"):null);
((null==offy)||(""==offy))?this.SetOffsetY(_185):this.SetOffsetY(offy);
var sri=(_16e?_16e.parentNode.getAttribute("SelectedRowIndex"):null);
((null==sri)||(""==sri))?this.SetSelectedRowIndex(_17a):this.SetSelectedRowIndex(parseInt(sri));
var chd=(_16e?_16e.getAttribute("CustomHTMLDefinition"):null);
((null==chd)||(""==chd))?this.SetCustomHTMLDefinition(_179):this.SetCustomHTMLDefinition(chd);
var ap=(_16e?_16e.getAttribute("AllowPaging"):null);
((null==ap)||(""==ap))?this.SetAllowPaging(_17b):this.SetAllowPaging(ap.toLowerCase()=="true");
var fz=(_16e?_16e.getAttribute("FuzzySearchEnabled"):null);
((null==fz)||(""==fz))?this.SetFuzzySearchEnabled(_17d):this.SetFuzzySearchEnabled(fz.toLowerCase()=="true");
var eds=(_16e?_16e.getAttribute("EnableDatabaseSearch"):null);
((null==eds)||(""==eds))?this.SetEnableDatabaseSearch(this.unboundMode==false&&_17e):this.SetEnableDatabaseSearch(this.unboundMode==false&&eds.toLowerCase()=="true");
if(_171.mode=="default"&&this.GetAllowPaging()==true){
this.SetClipLength(this.GetPageSize());
this.clip=true;
}
this.widestColumn=new Array(this.m_ListColumnDefinitions.length);
for(var i=0;i<this.widestColumn.length;i++){
this.widestColumn[i]=0;
}
this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_NONE);
var durl=(_16e?_16e.getAttribute("DatasourceUrl"):null);
if((null==durl)||(""==durl)||this.unboundMode==true){
this.SetDatasourceUrl(document.location.toString());
this.SetEnableDatabaseSearch(false);
this.unboundMode=true;
}else{
this.SetDatasourceUrl(durl);
this.SetEnableDatabaseSearch(true);
}
this.m_httpRequestReady=true;
this.SetNumPagesLoaded(0);
this.m_userTag=_16e;
};
nitobi.combo.List.prototype.Unload=function(){
if(this.IF){
this.IF.Unload();
delete this.IF;
}
_EBAMemScrub(this);
};
nitobi.combo.List.prototype.SetClipLength=function(_1ae){
this.clipLength=_1ae;
};
nitobi.combo.List.prototype.GetHTMLTagObject=function(){
this.Render();
return this.m_HTMLTagObject;
};
nitobi.combo.List.prototype.SetHTMLTagObject=function(_1af){
this.m_HTMLTagObject=_1af;
};
nitobi.combo.List.prototype.GetHighlightCSSClassName=function(){
return this.m_HighlightCSSClassName;
};
nitobi.combo.List.prototype.SetHighlightCSSClassName=function(_1b0){
this.m_HighlightCSSClassName=_1b0;
};
nitobi.combo.List.prototype.GetListColumnDefinitions=function(){
return this.m_ListColumnDefinitions;
};
nitobi.combo.List.prototype.SetListColumnDefinitions=function(_1b1){
this.m_ListColumnDefinitions=_1b1;
};
nitobi.combo.List.prototype.GetCustomHTMLDefinition=function(){
return this.m_CustomHTMLDefinition;
};
nitobi.combo.List.prototype.SetCustomHTMLDefinition=function(_1b2){
this.m_CustomHTMLDefinition=_1b2;
};
nitobi.combo.List.prototype.GetCustomHTMLHeader=function(){
return this.m_CustomHTMLHeader;
};
nitobi.combo.List.prototype.SetCustomHTMLHeader=function(_1b3){
this.m_CustomHTMLHeader=_1b3;
};
nitobi.combo.List.prototype.GetCombo=function(){
return this.m_Combo;
};
nitobi.combo.List.prototype.SetCombo=function(_1b4){
this.m_Combo=_1b4;
};
nitobi.combo.List.prototype.GetXmlDataSource=function(){
return this.m_XmlDataSource;
};
nitobi.combo.List.prototype.SetXmlDataSource=function(_1b5){
this.m_XmlDataSource=_1b5;
};
nitobi.combo.List.prototype.GetWidth=function(){
return this.m_Width;
};
nitobi.combo.List.prototype.SetWidth=function(_1b6){
this.m_Width=_1b6;
if(this.m_Rendered){
this.GetHTMLTagObject().style.width=this.GetDesiredPixelWidth();
for(var i=0;i<=EBAComboBoxListFooter;i++){
if(i!=EBAComboBoxListBodyTable){
var _1b8=this.GetSectionHTMLTagObject(i);
if(_1b8!=null){
_1b8.style.width=this.GetDesiredPixelWidth();
}
}
}
this.GenerateCss();
}
};
nitobi.combo.List.prototype.GetDesiredPixelWidth=function(){
var _1b9=this.GetCombo();
var _1ba=document.getElementById(_1b9.GetId());
var _1bb=nitobi.html.getWidth(_1ba);
var _1bc=this.GetWidth();
if(nitobi.Browser.GetMeasurementUnitType(_1bc)=="%"){
var w=(_1b9.GetWidth()==null?_1b9.GetTextBox().GetWidth():_1b9.GetWidth());
var _1be=1/(parseInt(w)/100);
var _1bc=parseInt(_1bc)/100;
return (Math.floor(_1bb*_1be*_1bc-2)+"px");
}else{
return _1bc;
}
};
nitobi.combo.List.prototype.GetActualPixelWidth=function(){
var tag=this.GetHTMLTagObject();
if(null==tag){
return this.GetDesiredPixelWidth();
}else{
return nitobi.Browser.GetElementWidth(tag);
}
};
nitobi.combo.List.prototype.GetCSSClassName=function(){
return (null==this.m_HTMLTagObject?this.m_CSSClassName:this.GetHTMLTagObject().className);
};
nitobi.combo.List.prototype.SetCSSClassName=function(_1c0){
if(null==this.m_HTMLTagObject){
this.m_CSSClassName=_1c0;
}else{
this.GetHTMLTagObject().className=_1c0;
}
};
nitobi.combo.List.prototype.GetSectionHTMLTagObject=function(_1c1){
this.Render();
return this.m_SectionHTMLTagObjects[_1c1];
};
nitobi.combo.List.prototype.SetSectionHTMLTagObject=List_SetSectionHTMLTagObject;
function List_SetSectionHTMLTagObject(_1c2,_1c3){
this.m_SectionHTMLTagObjects[_1c2]=_1c3;
}
nitobi.combo.List.prototype.GetSectionCSSClassName=function(_1c4){
return (null==this.m_HTMLTagObject?this.m_SectionCSSClassNames[_1c4]:this.GetSectionHTMLTagObject(_1c4).className);
};
nitobi.combo.List.prototype.SetSectionCSSClassName=function(_1c5,_1c6){
if(null==this.m_HTMLTagObject){
this.m_SectionCSSClassNames[_1c5]=_1c6;
}else{
this.GetSectionHTMLTagObject(_1c5).className=_1c6;
}
};
nitobi.combo.List.prototype.GetSectionHeight=function(_1c7){
if(this.m_HTMLTagObject==null){
return parseInt(this.m_SectionHeights[_1c7]);
}else{
var _1c8=this.m_HTMLTagObject.style;
var top=_1c8.top;
var _1ca=_1c8.display;
var _1cb=_1c8.position;
var _1cc=_1c8.visibility;
if(_1c8.display=="none"||_1c8.visibility!="visible"){
_1c8.position="absolute";
_1c8.top="-1000px";
_1c8.display="inline";
}
var _1cd=null;
if(this.m_SectionHTMLTagObjects[_1c7]!=null){
_1cd=nitobi.html.getHeight(this.m_SectionHTMLTagObjects[_1c7]);
}
if(_1c8.display=="inline"){
_1c8.position=_1cb;
_1c8.display=_1ca;
_1c8.top=top;
}
return _1cd;
}
};
nitobi.combo.List.prototype.SetSectionHeight=function(_1ce,_1cf){
if(null==this.m_HTMLTagObject){
this.m_SectionHeights[_1ce]=_1cf;
}else{
this.GetSectionHTMLTagObject(_1ce).style.height=_1cf;
}
};
nitobi.combo.List.prototype.GetSelectedRowIndex=function(){
if(null==this.m_HTMLTagObject){
return parseInt(this.m_SelectedRowIndex);
}else{
return parseInt(document.getElementById(this.GetCombo().GetId()+"SelectedRowIndex").value);
}
};
nitobi.combo.List.prototype.SetSelectedRowIndex=function(_1d0){
if(null==this.m_HTMLTagObject){
this.m_SelectedRowIndex=_1d0;
}else{
document.getElementById(this.GetCombo().GetId()+"SelectedRowIndex").value=_1d0;
}
};
nitobi.combo.List.prototype.GetAllowPaging=function(){
return this.m_AllowPaging;
};
nitobi.combo.List.prototype.SetAllowPaging=function(_1d1){
if(this.m_HTMLTagObject!=null){
if(_1d1){
this.ShowFooter();
}else{
this.HideFooter();
}
}
this.m_AllowPaging=_1d1;
};
nitobi.combo.List.prototype.IsFuzzySearchEnabled=function(){
return this.m_FuzzySearchEnabled;
};
nitobi.combo.List.prototype.SetFuzzySearchEnabled=function(_1d2){
this.m_FuzzySearchEnabled=_1d2;
};
nitobi.combo.List.prototype.GetPageSize=function(){
return this.m_PageSize;
};
nitobi.combo.List.prototype.SetPageSize=function(_1d3){
this.m_PageSize=_1d3;
};
nitobi.combo.List.prototype.GetNumPagesLoaded=function(){
return this.m_NumPagesLoaded;
};
nitobi.combo.List.prototype.SetNumPagesLoaded=function(_1d4){
this.m_NumPagesLoaded=_1d4;
};
nitobi.combo.List.prototype.GetActiveRow=function(){
return this.m_ActiveRow;
};
nitobi.combo.List.prototype.SetActiveRow=function(_1d5){
var _1d6;
if(null!=this.m_ActiveRow){
_1d6=document.getElementById("ContainingTableFor"+this.m_ActiveRow.id);
if(this.m_UseHighlightClass){
_1d6.className=this.m_OriginalRowClass;
}else{
_1d6.style.backgroundColor=this.m_OriginalBackgroundHighlightColor;
_1d6.style.color=this.m_OriginalForegroundHighlightColor;
}
var _1d7=this.GetListColumnDefinitions();
for(var i=0,n=_1d7.length;i<n;i++){
var _1da=document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id+"_"+i);
if(_1da!=null){
_1da.style.color=_1da.savedColor;
_1da.style.backgroundColor=_1da.savedBackgroundColor;
}
}
}
this.m_ActiveRow=_1d5;
if(null!=_1d5){
if("compact"==this.GetCombo().mode&&_1d5!=null){
var _1db=this.GetRowIndex(_1d5);
this.SetSelectedRow(_1db);
}
_1d6=document.getElementById("ContainingTableFor"+_1d5.id);
_1da=document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id);
if(this.m_UseHighlightClass){
this.m_OriginalRowClass=_1d6.className;
_1d6.className=this.GetHighlightCSSClassName();
}else{
this.m_OriginalBackgroundHighlightColor=_1d6.style.backgroundColor;
this.m_OriginalForegroundHighlightColor=_1d6.style.color;
_1d6.style.backgroundColor=this.m_BackgroundHighlightColor;
_1d6.style.color=this.m_ForegroundHighlightColor;
}
var _1d7=this.GetListColumnDefinitions();
for(var i=0,n=_1d7.length;i<n;i++){
var _1da=document.getElementById("ContainingSpanFor"+this.m_ActiveRow.id+"_"+i);
if(_1da!=null){
_1da.savedColor=_1da.style.color;
_1da.savedBackgroundColor=_1da.style.backgroundColor;
_1da.style.color=_1d6.style.color;
_1da.style.backgroundColor=_1d6.style.backgroundColor;
}
}
}
};
nitobi.combo.List.prototype.GetSelectedRowValues=function(){
var _1dc=new Array;
for(var i=0;i<this.GetXmlDataSource().GetNumberColumns();i++){
_1dc[i]=document.getElementById(this.GetCombo().GetId()+"SelectedValue"+i).value;
}
return _1dc;
};
nitobi.combo.List.prototype.SetSelectedRowValues=function(_1de,Row){
this.m_SelectedRowValues=_1de;
var _1e0=this.GetCombo().GetId();
var _1e1=this.GetXmlDataSource().GetNumberColumns();
if((null==_1de)&&(null==Row)){
for(var i=0;i<_1e1;i++){
document.getElementById(_1e0+"SelectedValue"+i).value="";
}
}else{
if(null==Row){
for(var i=0;i<_1e1;i++){
document.getElementById(_1e0+"SelectedValue"+i).value=_1de[i];
}
}else{
var _1e3=this.GetCombo().GetUniqueId();
var _1e4=this.GetRowIndex(Row);
var _1e5=this.GetXmlDataSource().GetRow(_1e4);
this.SetSelectedRowValues(_1e5,null);
}
}
};
nitobi.combo.List.prototype.GetEnableDatabaseSearch=function(){
return this.m_EnableDatabaseSearch;
};
nitobi.combo.List.prototype.SetEnableDatabaseSearch=function(_1e6){
this.m_EnableDatabaseSearch=_1e6;
};
nitobi.combo.List.prototype.GetFooterText=function(){
if(null==this.m_HTMLTagObject){
return this.m_FooterText;
}else{
var _1e7=document.getElementById("EBAComboBoxListFooterPageNextButton"+this.GetCombo().GetUniqueId());
return (null!=_1e7?_1e7.innerHTML:"");
}
};
nitobi.combo.List.prototype.SetFooterText=function(_1e8){
if(null==this.m_HTMLTagObject){
this.m_FooterText=_1e8;
}else{
var _1e9=this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
if(null!=_1e9){
_1e9=document.getElementById("EBAComboBoxListFooterPageNextButton"+this.GetCombo().GetUniqueId());
if(null!=_1e9){
_1e9.innerHTML=_1e8;
}
}
}
};
nitobi.combo.List.prototype.GetDatabaseSearchTimeoutStatus=function(){
return this.m_DatabaseSearchTimeoutStatus;
};
nitobi.combo.List.prototype.SetDatabaseSearchTimeoutStatus=function(_1ea){
this.m_DatabaseSearchTimeoutStatus=_1ea;
};
nitobi.combo.List.prototype.GetDatabaseSearchTimeoutId=function(){
return this.m_DatabaseSearchTimeoutId;
};
nitobi.combo.List.prototype.SetDatabaseSearchTimeoutId=function(_1eb){
this.m_DatabaseSearchTimeoutId=_1eb;
};
nitobi.combo.List.prototype.GetHeight=function(){
return this.GetSectionHeight(EBAComboBoxListBody);
};
nitobi.combo.List.prototype.SetHeight=function(_1ec){
this.SetSectionHeight(EBAComboBoxListBody,parseInt(_1ec));
};
nitobi.combo.List.prototype.GetActualHeight=function(){
var uid=this.GetCombo().GetUniqueId();
var tag=this.GetHTMLTagObject();
var _1ef=nitobi.Browser.GetElementHeight(tag);
return _1ef;
};
nitobi.combo.List.prototype.GetActualPixelHeight=nitobi.combo.List.prototype.GetActualHeight;
nitobi.combo.List.prototype.GetBackgroundHighlightColor=function(){
return this.m_BackgroundHighlightColor;
};
nitobi.combo.List.prototype.SetBackgroundHighlightColor=function(_1f0){
this.m_BackgroundHighlightColor=_1f0;
};
nitobi.combo.List.prototype.GetForegroundHighlightColor=function(){
return this.m_ForegroundHighlightColor;
};
nitobi.combo.List.prototype.SetForegroundHighlightColor=function(_1f1){
this.m_ForegroundHighlightColor=_1f1;
};
nitobi.combo.List.prototype.GetDatasourceUrl=function(){
return this.m_DatasourceUrl;
};
nitobi.combo.List.prototype.SetDatasourceUrl=function(_1f2){
this.m_DatasourceUrl=_1f2;
};
nitobi.combo.List.prototype.GetOnHideEvent=function(){
return this.m_OnHideEvent;
};
nitobi.combo.List.prototype.SetOnHideEvent=function(_1f3){
this.m_OnHideEvent=_1f3;
};
nitobi.combo.List.prototype.GetOnShowEvent=function(){
return this.m_OnShowEvent;
};
nitobi.combo.List.prototype.SetOnShowEvent=function(_1f4){
this.m_OnShowEvent=_1f4;
};
nitobi.combo.List.prototype.GetOnBeforeSearchEvent=function(){
return this.m_OnBeforeSearchEvent;
};
nitobi.combo.List.prototype.SetOnBeforeSearchEvent=function(_1f5){
this.m_OnBeforeSearchEvent=_1f5;
};
nitobi.combo.List.prototype.GetOnAfterSearchEvent=function(){
return this.m_OnAfterSearchEvent;
};
nitobi.combo.List.prototype.SetOnAfterSearchEvent=function(_1f6){
this.m_OnAfterSearchEvent=_1f6;
};
nitobi.combo.List.prototype.GetOffsetX=function(){
return this.m_OffsetX;
};
nitobi.combo.List.prototype.SetOffsetX=function(_1f7){
this.m_OffsetX=parseInt(_1f7);
};
nitobi.combo.List.prototype.GetOffsetY=function(){
return this.m_OffsetY;
};
nitobi.combo.List.prototype.SetOffsetY=function(_1f8){
this.m_OffsetY=parseInt(_1f8);
};
nitobi.combo.List.prototype.AdjustSize=function(){
var list=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
var tag=this.GetHTMLTagObject();
var _1fb=tag.style;
var _1fc="";
if(true==nitobi.Browser.GetVerticalScrollBarStatus(list)){
if(nitobi.Browser.GetMeasurementUnitType(this.GetWidth())!="%"){
_1fc=parseInt(this.GetWidth())+nitobi.html.getScrollBarWidth(list)-(nitobi.browser.MOZ?EBADefaultScrollbarSize:0);
_1fc=this.GetDesiredPixelWidth();
}else{
_1fc=this.GetDesiredPixelWidth();
}
list.style.width=_1fc;
var _1fd=this.GetSectionHTMLTagObject(EBAComboBoxListHeader);
var _1fe=this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
if(_1fd!=null){
_1fd.style.width=_1fc;
}
if(_1fe!=null){
_1fe.style.width=_1fc;
}
_1fb.width=(_1fc);
if(nitobi.browser.IE){
var _1ff=nitobi.combo.iframeBacker.style;
_1ff.width=_1fb.width;
}
}
if(nitobi.browser.IE){
var _1ff=nitobi.combo.iframeBacker.style;
_1ff.height=_1fb.height;
}
};
nitobi.combo.List.prototype.IsVisible=function(){
if(!this.m_Rendered){
return false;
}
var tag=this.GetHTMLTagObject();
var _201=tag.style;
return (_201.visibility=="visible");
};
nitobi.combo.List.prototype.Show=function(){
var _202=this.GetCombo();
var mode=_202.mode;
this.Render();
if(!this.m_HTMLTagObject||this.IsVisible()||mode=="compact"||this.GetXmlDataSource().GetNumberRows()==0||((mode!="default"&&mode!="unbound")&&_202.GetTextBox().m_HTMLTagObject.value=="")){
return;
}
var tag=this.GetHTMLTagObject();
var _205=_202.GetTextBox().GetHTMLContainerObject();
var _206=tag.style;
var _207=nitobi.html.getHeight(_205);
var top=nitobi.html.getCoords(_205).y+_207;
var left=nitobi.html.getCoords(_205).x;
var _20a=parseInt(this.GetActualPixelHeight());
var _20b=parseInt(this.GetActualPixelWidth());
_206.top=top+"px";
_206.left=left+"px";
_206.zIndex=_202.m_ListZIndex;
var _20c=nitobi.html.getBodyArea().clientWidth;
var _20d=nitobi.html.getBodyArea().clientHeight;
var _20e=(document.body.scrollTop==""||parseInt(document.documentElement.scrollTop==0)?0:parseInt(document.body.scrollTop));
var _20f=(document.body.scrollLeft==""||parseInt(document.documentElement.scrollLeft==0)?0:parseInt(document.body.scrollLeft));
if(parseInt(top)-_20e+_20a>_20d){
var _210=parseInt(_206.top)-_20a-_207;
if(_210>=0){
_206.top=_210+"px";
}
}
if(parseInt(left)-parseInt(_20f)+_20b>_20c){
var _211=document.getElementById(_202.GetId());
var _212=nitobi.html.getWidth(_211);
if(_20b>_212){
var _213=_20b-_212;
var _214=left-_213;
if(_214>=0){
_206.left=_214+"px";
}
}
}
_206.position="absolute";
_206.display="inline";
this.AdjustSize();
this.GenerateCss();
_206.visibility="visible";
this.SetIFrameDimensions();
this.ShowIFrame();
eval(this.GetOnShowEvent());
};
nitobi.combo.List.prototype.SetX=function(x){
var tag=this.GetHTMLTagObject();
tag.style.left=x;
};
nitobi.combo.List.prototype.GetX=function(){
var _217=this.GetCombo();
var _218=nitobi.html.getCoords(_217.GetHTMLTagObject());
return _218.x;
};
nitobi.combo.List.prototype.SetY=function(y){
var tag=this.GetHTMLTagObject();
tag.style.top=y;
};
nitobi.combo.List.prototype.GetY=function(){
var _21b=this.GetCombo().GetTextBox().GetHTMLContainerObject();
var _21c=nitobi.html.getHeight(_21b);
var y=nitobi.html.getCoords(_21b).y+_21c;
return y;
};
nitobi.combo.List.prototype.SetFrameX=function(x){
if(nitobi.browser.IE){
nitobi.combo.iframeBacker.style.left=x;
}
};
nitobi.combo.List.prototype.SetFrameY=function(y){
if(nitobi.browser.IE){
nitobi.combo.iframeBacker.style.top=y;
}
};
nitobi.combo.List.prototype.GetFrame=function(){
if(nitobi.browser.IE){
return nitobi.combo.iframeBacker;
}else{
return null;
}
};
nitobi.combo.List.prototype.ShowIFrame=function(){
if(nitobi.browser.IE){
var _220=nitobi.combo.iframeBacker.style;
_220.visibility="visible";
}
};
nitobi.combo.List.prototype.SetIFrameDimensions=function(){
if(nitobi.browser.IE){
var tag=this.GetHTMLTagObject();
var _222=nitobi.combo.iframeBacker.style;
var _223=tag.style;
_222.top=_223.top;
_222.left=_223.left;
_222.width=nitobi.Browser.GetElementWidth(tag);
_222.height=nitobi.Browser.GetElementHeight(tag);
_222.zIndex=(isNaN(parseInt(_223.zIndex))?0:parseInt(_223.zIndex)-1);
}
};
nitobi.combo.List.prototype.Hide=function(){
if(!this.m_Rendered){
return false;
}
var tag=this.GetHTMLTagObject();
var _225=tag.style;
_225.visibility="hidden";
if((!nitobi.browser.IE)){
_225.display="none";
}
if(nitobi.browser.IE){
var _226=nitobi.combo.iframeBacker.style;
_226.visibility="hidden";
}
eval(this.GetOnHideEvent());
};
nitobi.combo.List.prototype.Toggle=function(){
if(this.IsVisible()){
this.Hide();
this.GetCombo().GetTextBox().ToggleHidden();
}else{
this.Show();
this.GetCombo().GetTextBox().ToggleShow();
}
};
nitobi.combo.List.prototype.SetActiveRowAsSelected=function(){
var _227=this.GetCombo();
var t=_227.GetTextBox();
var row=null;
row=this.GetActiveRow();
if(null!=row){
eval(_227.GetOnBeforeSelectEvent());
}
if(row!=null){
this.SetSelectedRow(this.GetRowIndex(row));
if(_227.mode!="smartlist"){
t.SetValue(this.GetSelectedRowValues()[t.GetDataFieldIndex()]);
}
}
};
nitobi.combo.List.prototype.SetSelectedRow=function(_22a){
this.SetSelectedRowIndex(_22a);
var _22b=this.GetXmlDataSource().GetRow(_22a);
this.SetSelectedRowValues(_22b,null);
};
nitobi.combo.List.prototype.OnClick=function(Row){
eval(this.GetCombo().GetOnBeforeSelectEvent());
var _22d=this.GetRowIndex(Row);
this.SetSelectedRowIndex(_22d);
var _22e=this.GetXmlDataSource().GetRow(_22d);
this.SetSelectedRowValues(_22e,null);
var _22f=this.GetCombo();
var tb=_22f.GetTextBox();
var _231=tb.GetDataFieldIndex();
if(_22e.length<=_231){
alert("You have bound the textbox to a column that does not exist.\nThe textboxDataFieldIndex is "+_231+".\nThe number of values in the selected row is "+_22e.length+".");
}else{
tb.SetValue(_22e[_231],_22f.mode=="smartlist");
}
this.Hide();
eval(_22f.GetOnSelectEvent());
};
nitobi.combo.List.prototype.OnMouseWheel=function(evt){
if(nitobi.browser.IE){
var b=nitobi.Browser;
var lb=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
var top=this.GetRow(0);
var bot=this.GetRow(this.GetXmlDataSource().GetNumberRows()-1);
if(null!=top){
if(evt.wheelDelta>=120){
b.WheelUp(this);
}else{
if(evt.wheelDelta<=-120){
b.WheelDown(this);
}
}
evt.cancelBubble=true;
evt.returnValue=false;
}
}
};
nitobi.combo.List.prototype.Render=function(){
if(!this.m_Rendered){
this.m_Rendered=true;
var _237=this.GetCombo();
var _238=document.body;
var x=nitobi.html.insertAdjacentHTML(_238,"afterBegin",this.GetHTMLRenderString());
this.Initialize(document.getElementById("EBAComboBoxText"+_237.GetId()));
this.OnWindowResized();
this.GenerateCss();
}
};
nitobi.combo.List.prototype.GetHTMLRenderString=function(){
var _23a=this.GetCombo();
var _23b="outlook";
var _23c=_23a.GetUniqueId();
var _23d=_23a.GetId();
var _23e=parseInt(this.GetDesiredPixelWidth());
var _23f=false;
var _240="";
if(this.m_XmlDataSource.GetXmlObject()){
var xml=null;
if(_23a.mode=="default"||_23a.mode=="unbound"){
xml=this.m_XmlDataSource.GetXmlObject().xml;
}else{
xml="<root></root>";
}
_240=this.GetRowHTML(xml);
}
var _242=this.GetListColumnDefinitions();
var s="";
s="<span class=\"ntb-combo-reset "+_23a.theme+"\"><span id=\"EBAComboBoxList"+_23c+"\" class=\"ntb-combobox-list"+"\" style=\"width: "+_23e+"px;\" "+"onMouseOver=\"document.getElementById('"+this.GetCombo().GetId()+"').object.m_Over=true\" "+"onMouseOut=\"document.getElementById('"+this.GetCombo().GetId()+"').object.m_Over=false\" "+"onClick=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnFocus()\">\n";
var tag=this.m_userTag;
var _245=tag.childNodes;
var _246="<span class='ntb-combobox-combo-menus ComboListWidth"+_23c+"'>";
var _247=false;
for(var i=0;i<_245.length;i++){
if(_245[i].nodeName.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"")=="combopanel"){
s+=_245[i].innerHTML;
}
if(_245[i].nodeName.toLowerCase().replace(/^eba:/,"").replace(/^ntb:/,"")=="combomenu"){
_247=true;
var icon=_245[i].getAttribute("icon");
_246+="<div style='"+(nitobi.browser.MOZ&&i==0?"":"")+";' class='ntb-combobox-combo-menu ComboListWidth"+_23c+"' onMouseOver=\"this.className='ntb-combobox-combo-menu-highlight ComboListWidth"+_23c+"'\" onmouseout=\"this.className='ntb-combobox-combo-menu ComboListWidth"+_23c+"'\" onclick=\""+_245[i].getAttribute("OnClickEvent")+"\">";
if(icon!=""){
_246+="<img class='ntb-combobox-combo-menu-icon' align='absmiddle' src='"+icon+"'>";
}
_246+=_245[i].getAttribute("text")+"</div>";
}
}
_246+="</span>";
if(_23a.mode=="default"||_23a.mode=="filter"||_23a.mode=="unbound"){
for(var i=0;i<_242.length;i++){
if(_242[i].GetHeaderLabel()!=""){
_23f=true;
}
}
var _24a=this.GetCustomHTMLHeader();
if((_23f==true)||(_24a!="")){
s+="<span id='EBAComboBoxListHeader"+_23c+"' class='ntb-combobox-list-header' style='padding:0px; margin:0px; width: "+_23e+"px;' >\n";
if(_24a!=""){
s+=_24a;
}else{
s+="<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;' class='ComboHeader"+_23c+"'>\n";
s+="<tr style='width:100%' id='EBAComboBoxColumnLabels"+_23c+"' class='ntb-combobox-column-labels'>\n";
var _24b="";
var _24c=false;
for(var i=0;i<_242.length;i++){
var _24d=_242[i].GetWidth();
_24b="";
if(_242[i].GetColumnType().toLowerCase()=="hidden"){
_24b+="style='display: none;'";
_242[i].SetWidth("0%");
}
var _24e="comboColumn_"+i+"_"+_23c;
var _24f=(i>0?"style='padding-left:0px'":"");
s+="<td "+_24f+" align='"+_242[i].GetAlign()+"' class='ntb-combobox-column-label "+_24e+"' "+_24b+">";
s+="<div class='"+_24e+" ntb-combobox-column-label-text'>"+_242[i].GetHeaderLabel()+"</div>";
s+="</td>\n";
}
s+="</tr>\n";
s+="</table>\n";
}
s+="</span><br>\n";
}
}
if(_247){
s+=_246;
}
s+="<span id='EBAComboBoxListBody"+_23c+"' class='ntb-combobox-list-body"+"' style='width:"+_23e+"px;"+(_23a.mode=="default"||_23a.mode=="unbound"||(_23a.mode=="smartsearch"&&this.GetAllowPaging())?"height: "+this.GetSectionHeight(EBAComboBoxListBody)+"px"+(this.m_overflowy=="auto"?";_overflow-y:;_overflow:auto":""):"overflow:visible")+";' onscroll=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetTextBox().GetHTMLTagObject().focus()\" "+"onmousewheel=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnMouseWheel(event)\" "+"onfocus=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnFocus()\">\n";
s+=_240+"</table>"+"</span>\n";
s+="<br><span id='EBAComboBoxListFooter"+_23c+"' style='width:"+_23e+"px; display:"+(this.GetAllowPaging()?"inline":"none")+"' class='ntb-combobox-list-footer'>\n";
s+="<span id=\"EBAComboBoxListFooterPageNextButton"+_23c+"\" style=\"width:100%\""+" class=\"ntb-combobox-list-footer-page-next-button\" "+"onMouseOver='this.className=\"ntb-combobox-list-footer-page-next-button-highlight\"' "+"onMouseOut='this.className=\"ntb-combobox-list-footer-page-next-button\"' "+"onClick=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnGetNextPage(null, true);\"></span>\n";
s+="</span>\n"+"</span>\n";
s+="</span>\n";
s=s.replace(/\#<\#/g,"<").replace(/\#\>\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#EQ\#/g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&");
return s;
};
nitobi.combo.List.prototype.Initialize=function(_250){
this.attachee=_250;
var c=this.GetCombo();
var d=document;
var _253=c.GetUniqueId();
this.SetHTMLTagObject(d.getElementById("EBAComboBoxList"+_253));
this.SetSectionHTMLTagObject(EBAComboBoxListHeader,d.getElementById("EBAComboBoxListHeader"+_253));
this.SetSectionHTMLTagObject(EBAComboBoxListBody,d.getElementById("EBAComboBoxListBody"+_253));
this.SetSectionHTMLTagObject(EBAComboBoxListFooter,d.getElementById("EBAComboBoxListFooter"+_253));
this.SetSectionHTMLTagObject(EBAComboBoxListBodyTable,d.getElementById("EBAComboBoxListBodyTable"+_253));
this.SetSectionHTMLTagObject(EBAComboBoxList,d.getElementById("EBAComboBoxList"+_253));
if(c.mode=="default"&&true==this.GetAllowPaging()){
this.SetFooterText(this.GetXmlDataSource().GetNumberRows()+EbaComboUi[EbaComboUiNumRecords]);
}
this.Hide();
};
nitobi.combo.List.prototype.OnMouseOver=function(Row){
this.SetActiveRow(Row);
};
nitobi.combo.List.prototype.OnMouseOut=function(Row){
this.SetActiveRow(null);
};
nitobi.combo.List.prototype.OnFocus=function(){
var t=this.GetCombo().GetTextBox();
t.m_skipFocusOnce=true;
t.m_HTMLTagObject.focus();
};
nitobi.combo.List.prototype.OnGetNextPage=function(_257,_258){
if(this.m_httpRequestReady){
var _259=this.GetXmlDataSource();
var last=null;
if(_258==true){
var n=_259.GetNumberRows();
if(n>0){
last=_259.GetRowCol(n-1,this.GetCombo().GetTextBox().GetDataFieldIndex());
}
}
this.GetPage(_259.GetNumberRows(),this.GetPageSize(),this.GetCombo().GetTextBox().GetIndexSearchTerm(),_257,last);
this.GetCombo().GetTextBox().GetHTMLTagObject().focus();
}
};
nitobi.combo.List.prototype.OnWindowResized=function(){
if(!this.m_Rendered){
return;
}
if(nitobi.Browser.GetMeasurementUnitType(this.GetWidth())=="%"){
this.SetWidth(this.GetWidth());
}
};
nitobi.combo.List.prototype.GenerateCss=function(){
var _25c=this.GetListColumnDefinitions();
var uid=this.GetCombo().GetUniqueId();
var _25e="";
var _25f=-1;
var list=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
var sb=nitobi.html.getScrollBarWidth(list);
var _262=(nitobi.browser.MOZ?6:0);
var _263=0;
for(var i=0;i<this.widestColumn.length;i++){
_263+=this.widestColumn[i];
}
if(_263<parseInt(this.GetDesiredPixelWidth())){
_263=parseInt(this.GetDesiredPixelWidth());
}
var _265=_263-sb-_262;
var _266=_263-sb-_262;
var _267=nitobi.html.Css.addRule;
if(this.stylesheet==null){
this.stylesheet=nitobi.html.Css.createStyleSheet();
}
var ss=this.stylesheet.sheet;
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
_267(ss,".ComboRow"+uid,"width:"+(_263-sb)+"px;}");
_267(ss,".ComboHeader"+uid,"width:"+(_263-sb+3)+"px;}");
_267(ss,".ComboListWidth"+uid,"width:"+(_263)+"px;");
}else{
_25e+=".ComboRow"+uid+"{width:"+(_263-sb)+"px;}";
_25e+=".ComboHeader"+uid+"{width:"+(_263-sb+3)+"px;}";
_25e+=".ComboListWidth"+uid+"{width:"+(_263)+"px;}";
}
for(var i=0;i<_25c.length;i++){
var _269=_25c[i].GetWidth();
if(nitobi.Browser.GetMeasurementUnitType(_269)=="%"&&_269!="*"){
_269=Math.floor((parseInt(_269)/100)*_266);
}else{
if(_269!="*"){
_269=parseInt(_269);
}
}
if(_269=="*"||(i==_25c.length-1&&_25f==-1)){
_25f=i;
}else{
if(_269<this.widestColumn[i]){
_269=this.widestColumn[i];
}
_265-=parseInt(_269);
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
_267(ss,".comboColumn_"+i+"_"+uid,"width:"+(_269)+"px;");
}else{
_25e+=".comboColumn_"+i+"_"+uid+"{ width: "+(_269)+"px;}";
}
}
}
if(_25f!=-1){
if(nitobi.browser.SAFARI||nitobi.browser.CHROME){
_267(ss,".comboColumn_"+_25f+"_"+uid,"width:"+_265+"px;");
}else{
_25e+=".comboColumn_"+_25f+"_"+uid+"{ width: "+_265+"px;}";
}
}
nitobi.html.Css.setStyleSheetValue(this.stylesheet,_25e);
};
nitobi.combo.List.prototype.ClearCss=function(){
if(this.stylesheet==null){
this.stylesheet=document.createStyleSheet();
}
this.stylesheet.cssText="";
};
nitobi.combo.List.prototype.GetRowHTML=function(XML,_26b){
var _26c=this.GetCombo();
var _26d=_26c.GetId();
var _26e=_26c.GetUniqueId();
var _26f=this.GetListColumnDefinitions();
var _270=parseInt(this.GetWidth());
var xsl="<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\"  >";
xsl+="<xsl:output method=\"xml\" version=\"4.0\" omit-xml-declaration=\"yes\" />\n"+"<xsl:template match=\"/\">"+"<table cellspacing=\"0\" cellpadding=\"0\" id=\"EBAComboBoxListBodyTable"+_26e+"_"+this.GetNumPagesLoaded()+"\" class=\"ntb-combobox-list-body-table ComboRow"+_26e+"\">\n"+"<xsl:apply-templates />"+"</table>"+"</xsl:template>";
xsl+="<xsl:template match=\"e\">";
xsl+="<tr onclick=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnClick(this)\" "+"onmouseover=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnMouseOver(this)\" "+"onmouseout=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnMouseOut(this)\">";
xsl+="<xsl:attribute name=\"id\">";
var _272="position()+"+(this.GetXmlDataSource().GetNumberRows()-this.GetXmlDataSource().GetLastPageSize())+"-1";
var _273="EBAComboBoxRow"+_26e+"_<xsl:value-of select=\""+_272+"\"/>";
xsl+=_273+"</xsl:attribute>"+"<td class='ComboRowContainerParent'><table cellspacing='0' cellpadding='0' class='ntb-combobox-list-body-table-row "+"ComboRow"+_26e+"' style=\"width:"+(nitobi.browser.SAFARI||nitobi.browser.CHROME?this.GetWidth():"100%")+";table-layout:fixed;\"><tbody>"+"<xsl:attribute name=\"id\">"+"ContainingTableFor"+_273+"</xsl:attribute>"+"<tr class='ComboRowContainer'>";
var _274=this.GetCustomHTMLDefinition();
var _275;
var _276="";
if(""==_274){
for(var i=0;i<_26f.length;i++){
var _278="";
var _279=_26f[i].GetColumnType().toLowerCase();
if(_279=="hidden"){
_278+="style='display: none;'";
}
var _27a="comboColumn_"+i+"_"+_26e;
_276+="<col class=\""+_27a+"\" style=\"width:"+_26f[i].GetWidth()+"\" />";
xsl+="<td align='"+_26f[i].GetAlign()+"' class='"+_27a+" "+_26f[i].GetCSSClassName()+"' "+_278+" style=\"width:"+_26f[i].GetWidth()+"\">";
xsl+="<div class=\""+(nitobi.browser.IE||nitobi.browser.SAFARI||nitobi.browser.CHROME?_27a+" ":"")+_26f[i].GetCSSClassName()+"Cell\" style=\"color:"+_26f[i].GetTextColor()+";overflow:hidden;\" onfocus=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnFocus()\""+" onmouseover=\"document.getElementById('"+this.GetCombo().GetId()+"').object.GetList().OnFocus()\">";
xsl+="<xsl:attribute name=\"id\">"+"ContainingSpanFor"+_273+"_"+i+"</xsl:attribute>"+"<xsl:text disable-output-escaping=\"yes\">"+"<![CDATA["+_26f[i].GetHTMLPrefix()+""+"]]>"+"</xsl:text>";
_275=_26f[i].GetDataFieldIndex();
if(null==_275){
_275=i;
}
_275=parseInt(_275);
var _27b="";
if(_279=="image"){
_27b=_26f[i].GetImageHandlerURL();
_27b.indexOf("?")==-1?_27b+="?":_27b+="&";
_27b+="image=";
xsl+="<img> <xsl:attribute name=\"align\"><xsl:value-of  select=\"absmiddle\"/></xsl:attribute>"+"<xsl:attribute name=\"src\"><xsl:value-of select=\"concat('"+(_26f[i].ImageUrlFromData?"":_27b)+"',"+"@"+String.fromCharCode(97+_275)+")\"/></xsl:attribute>"+"</img>";
}
if((_26b!=null)&&(_279!="image")){
xsl+="<xsl:call-template name=\"bold\"><xsl:with-param name=\"string\">";
}
if(_279!="image"){
xsl+="<xsl:value-of select=\"@"+String.fromCharCode(97+_275)+"\"></xsl:value-of>";
}
if((_26b!=null)&&(_279!="image")){
xsl+="</xsl:with-param><xsl:with-param name=\"pattern\" select=\""+nitobi.xml.constructValidXpathQuery(_26b,true)+"\"></xsl:with-param></xsl:call-template>";
}
xsl+="<xsl:text disable-output-escaping=\"yes\">"+"<![CDATA["+_26f[i].GetHTMLSuffix()+""+"]]>"+"</xsl:text>";
xsl+="</div>";
xsl+="</td>";
}
}else{
xsl+="<td width='100%'>";
var done=false;
var _27d=0;
var _27e=0;
var _27f=0;
var _280;
while(!done){
_27d=_274.indexOf("${",_27e);
if(_27d!=-1){
_27e=_274.indexOf("}",_27d);
_280=_274.substr(_27d+2,_27e-_27d-2);
xsl+="<xsl:text disable-output-escaping=\"yes\">"+"<![CDATA["+_274.substr(_27f,_27d-_27f)+"]]>"+"</xsl:text>";
xsl+="<xsl:value-of select=\"@"+String.fromCharCode(parseInt(_280)+97)+"\"></xsl:value-of>";
_27f=_27e+1;
}else{
xsl+="<xsl:text disable-output-escaping=\"yes\">"+"<![CDATA["+_274.substr(_27f)+"]]>"+"</xsl:text>";
done=true;
}
}
xsl+="</td>";
}
xsl+="</tr></tbody><colgroup>"+_276+"</colgroup></table></td></tr>\n"+"</xsl:template>";
if(_26b!=null){
xsl+="<xsl:template name=\"bold\">"+"<xsl:param name=\"string\" select=\"''\" /><xsl:param name=\"pattern\" select=\"''\" /><xsl:param name=\"carryover\" select=\"''\" />";
xsl+="<xsl:variable name=\"lcstring\" select=\"translate($string,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')\"/>"+"<xsl:variable name=\"lcpattern\" select=\"translate($pattern,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz')\"/>";
xsl+="<xsl:choose>"+"<xsl:when test=\"$pattern != '' and $string != '' and contains($lcstring,$lcpattern)\">"+"<xsl:variable name=\"newpattern\" select=\"substring($string,string-length(substring-before($lcstring,$lcpattern)) + 1, string-length($pattern))\"/>"+"<xsl:variable name=\"before\" select=\"substring-before($string, $newpattern)\" />"+"<xsl:variable name=\"len\" select=\"string-length($before)\" />"+"<xsl:variable name=\"newcarryover\" select=\"boolean($len&gt;0 and contains(substring($before,$len,1),'%'))\" />"+"<xsl:value-of select=\"$before\" />"+"<xsl:choose>"+"<xsl:when test=\"($len=0 and $carryover) or $newcarryover or ($len&gt;1 and contains(substring($before,$len - 1,1),'%'))\">"+"<xsl:copy-of select=\"$newpattern\" />"+"</xsl:when>"+"<xsl:otherwise>"+"<b><xsl:copy-of select=\"$newpattern\" /></b>"+"</xsl:otherwise></xsl:choose>"+"<xsl:call-template name=\"bold\">"+"<xsl:with-param name=\"string\" select=\"substring-after($string, $newpattern)\" />"+"<xsl:with-param name=\"pattern\" select=\"$pattern\" />"+"<xsl:with-param name=\"carryover\" select=\"$newcarryover\" />"+"</xsl:call-template>"+"</xsl:when>"+"<xsl:otherwise>"+"<xsl:value-of select=\"$string\" />"+"</xsl:otherwise>"+"</xsl:choose>"+"</xsl:template>";
}
xsl+="</xsl:stylesheet>";
oXSL=nitobi.xml.createXmlDoc(xsl);
tmp=nitobi.xml.createXmlDoc(XML.replace(/>\s+</g,"><"));
var html=nitobi.xml.serialize(nitobi.xml.transformToXml(tmp,oXSL));
html=html.replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\#\&eq\;\#/g,"=").replace(/\#\&quot\;\#/g,"\"").replace(/\#\&amp\;\#/g,"&");
return html;
};
nitobi.combo.List.prototype.ScrollIntoView=function(Row,Top,_284){
if(Row&&this.GetCombo().mode!="compact"){
var _285=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
if(nitobi.Browser.IsObjectInView(Row,_285,Top,_284)==false){
nitobi.Browser.ScrollIntoView(Row,_285,Top);
}
}
};
nitobi.combo.List.prototype.GetRowIndex=function(Row){
var vals=Row.id.split("_");
var _288=vals[vals.length-1];
return _288;
};
EBAComboListDatasourceAccessStatus_BUSY=0;
EBAComboListDatasourceAccessStatus_READY=1;
nitobi.combo.List.prototype.GetDatasourceAccessStatus=function(){
if(this.m_httpRequestReady){
return EBAComboListDatasourceAccessStatus_READY;
}else{
return EBAComboListDatasourceAccessStatus_BUSY;
}
};
nitobi.combo.List.prototype.Eval=function(_289){
eval(_289);
};
nitobi.combo.List.prototype.GetPage=function(_28a,_28b,_28c,_28d,_28e,_28f,_290,_291){
var _292=new Date().getTime();
this.SetFooterText(EbaComboUi[EbaComboUiPleaseWait]);
if(_28e==null){
_28e="";
}
this.m_httpRequest=new nitobi.ajax.HttpRequest();
this.m_httpRequest.responseType="text";
this.m_httpRequest.onRequestComplete.subscribe(this.onGetComplete,this);
this.lastHttpRequestTime=_292;
if(null==_28d){
_28d=EBAScrollToNone;
}
this.m_OriginalSearchSubstring=_28c;
var _293=this.GetDatasourceUrl();
_293.indexOf("?")==-1?_293+="?":_293+="&";
_293+="StartingRecordIndex="+_28a+"&PageSize="+_28b+"&SearchSubstring="+encodeURIComponent(_28c)+"&ComboId="+encodeURI(this.GetCombo().GetId())+"&LastString="+encodeURIComponent(_28e);
this.m_httpRequest.open(this.GetCombo().GetHttpRequestMethod(),_293,true,"","");
this.m_httpRequestReady=false;
this.m_httpRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
this.m_httpRequest.params={StartingRecordIndex:_28a,SearchSubstring:_28c,ScrollTo:_28d,GetPageCallback:_28f,SearchColumnIndex:_290,SearchCallback:_291,RequestTime:_292};
var vs=document.getElementsByName("__VIEWSTATE");
if((vs!=null)&&(vs["__VIEWSTATE"]!=null)){
var _295="__VIEWSTATE="+encodeURI(vs["__VIEWSTATE"].value).replace(/\+/g,"%2B");
var _296="__EVENTTARGET="+encodeURI(this.GetCombo().GetId());
var args="__EVENTARGUMENT=GetPage";
var _298=_296+"&"+args+"&"+_295;
this.m_httpRequest.send(_298);
}else{
this.m_httpRequest.send("EBA Combo Box Get Page Request");
}
return true;
};
nitobi.combo.List.prototype.onGetComplete=function(_299){
var _29a=_299.params;
if(this.lastHttpRequestTime!=_29a.RequestTime){
return;
}
var co=this.GetCombo();
var t=co.GetTextBox();
var list=co.GetList();
if(list==null){
alert(EbaComboUi[EbaComboUiServerError]);
}
var _29e=_299.response;
var _29f=_29e.indexOf("<?xml");
if(_29f!=-1){
_29e=_29e.substr(_29f);
}
var _2a0=list.GetXmlDataSource();
var _2a1=_2a0.GetNumberRows();
var tmp=nitobi.xml.createXmlDoc(_29e);
if(true==list.clip){
tmp=xbClipXml(tmp,"root","e",list.clipLength);
_29e=tmp.xml;
}
var _2a3=tmp.selectNodes("//e").length;
var _2a4=co.mode!="default"&&!(co.mode=="smartsearch"&&list.GetAllowPaging());
if((_2a3>0)&&(_29a.StartingRecordIndex==0)||_2a4){
list.Clear();
_2a0.Clear();
}
if(_2a3==0&&_2a4){
list.Hide();
}
if(_2a3>0){
_2a0.AddPage(_29e);
var ss=null;
if(co.mode=="smartsearch"||co.mode=="smartlist"){
ss=list.searchSubstring;
}
list.AddPage(_29e,ss);
if((_29a.StartingRecordIndex==0)&&(list.GetCombo().GetTextBox().GetSearchTerm()!="")){
list.SetActiveRow(list.GetRow(0));
}
var _2a6=false;
try{
if(!list.IsFuzzySearchEnabled()){
var _2a7=_2a0.Search(list.m_OriginalSearchSubstring,t.GetDataFieldIndex(),co.mode=="smartsearch"||co.mode=="smartlist");
_2a6=(_2a7==-1);
}
}
catch(err){
}
var _2a8=list.IsVisible();
if(EBAScrollToBottom==_29a.ScrollTo){
var r=list.GetRow(_2a1-1);
list.SetActiveRow(r);
list.ScrollIntoView(r,false);
}else{
if(EBAScrollToNewTop==_29a.ScrollTo||EBAScrollToNewBottom==_29a.ScrollTo){
var r=list.GetRow(_2a1);
list.SetActiveRow(r);
list.ScrollIntoView(r,EBAScrollToNewTop==_29a.ScrollTo);
var tb=t.m_HTMLTagObject;
tb.value=list.GetXmlDataSource().GetRowCol(_2a1,t.GetDataFieldIndex());
nitobi.html.setCursor(tb,tb.value.length);
t.Paging=false;
}else{
if(_2a8){
list.ScrollIntoView(list.GetActiveRow(),true);
}
}
}
try{
if(!_2a6&&_29a.GetPageCallback){
_29a.GetPageCallback(EBAComboSearchNewRecords,list,_29a.SearchSubstring,_29a.SearchColumnIndex,_29a.SearchCallback);
}
}
catch(err){
}
}else{
try{
if(_29a.GetPageCallback){
_29a.GetPageCallback(EBAComboSearchNoRecords,list,_29a.SearchSubstring,_29a.SearchColumnIndex,_29a.SearchCallback);
}
}
catch(err){
}
list.SetFooterText(EbaComboUi[EbaComboUiNoRecords]);
list.SetActiveRow(null);
}
if(list.InitialSearchOnce==true&&_2a3>0){
list.InitialSearchOnce=false;
var row=list.GetRow(0);
list.SetActiveRow(row);
list.SetSelectedRowValues(null,row);
list.SetSelectedRowIndex(0);
var tb=co.GetTextBox();
tb.SetValue(list.GetSelectedRowValues()[tb.GetDataFieldIndex()]);
}
list.m_httpRequestReady=true;
t.Paging=false;
};
nitobi.combo.List.prototype.Search=function(_2ac,_2ad,_2ae,_2af){
var _2b0=this.GetCombo();
var _2b1=this.GetXmlDataSource();
if(_2b0.mode!="default"&&_2ac==""){
this.Hide();
return;
}
if(null==_2af){
_2af=false;
}
eval(this.GetOnBeforeSearchEvent());
var _2b2=-1;
if(!this.GetEnableDatabaseSearch()||!_2b1.m_Dirty||_2b0.mode=="unbound"){
_2b2=_2b1.Search(_2ac,_2ad,_2b0.mode=="smartsearch"||_2b0.mode=="smartlist");
if(_2b2>-1&&this.InitialSearchOnce!=true){
this.Show();
}
if(-1!=_2b2){
if(_2ae){
try{
_2ae(_2b2,this);
}
catch(err){
}
}
eval(this.GetOnAfterSearchEvent());
}
if(-1==_2b2&&(false==this.GetEnableDatabaseSearch()||_2af)){
if(_2ae){
try{
_2ae(_2b2,this);
}
catch(err){
}
}
eval(this.GetOnAfterSearchEvent());
}
}
this.searchSubstring=_2ac;
if((-1==_2b2)&&(this.GetEnableDatabaseSearch()==true&&(_2af==false))){
var _2b3=this.GetDatabaseSearchTimeoutStatus();
var _2b4="var list = document.getElementById('"+_2b0.GetId()+"').object.GetList(); "+"list.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_EXPIRED);"+"var textbox = document.getElementById('"+_2b0.GetId()+"').object.GetTextBox();"+"list.Search(textbox.GetSearchTerm(),textbox.GetDataFieldIndex(),textbox.m_Callback);";
var _2b5=this.GetDatabaseSearchTimeoutId();
_2b0.GetTextBox().SetIndexSearchTerm(_2ac);
switch(_2b3){
case (EBADatabaseSearchTimeoutStatus_EXPIRED):
if(_2b5!=null){
window.clearTimeout(_2b5);
}
this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_NONE);
var _2b6=_ListGetPageCallback;
this.GetPage(0,this.GetPageSize(),_2ac,EBAScrollToTypeAhead,null,_2b6,_2ad,_2ae);
break;
case (EBADatabaseSearchTimeoutStatus_WAIT):
if(_2b5!=null){
window.clearTimeout(_2b5);
}
var _2b5=window.setTimeout(_2b4,EBADatabaseSearchTimeoutWait);
this.SetDatabaseSearchTimeoutId(_2b5);
case (EBADatabaseSearchTimeoutStatus_NONE):
this.SetDatabaseSearchTimeoutStatus(EBADatabaseSearchTimeoutStatus_WAIT);
var _2b5=window.setTimeout(_2b4,EBADatabaseSearchTimeoutWait);
this.SetDatabaseSearchTimeoutId(_2b5);
}
}
};
function _ListGetPageCallback(_2b7,list,_2b9,_2ba,_2bb){
if((list==null)){
alert(EbaComboUi[EbaComboUiServerError]);
}
if(_2b7==EBAComboSearchNewRecords){
if(!list.IsFuzzySearchEnabled()){
list.Search(_2b9,_2ba,_2bb);
}else{
list.Show();
}
}else{
_2bb(-1,list);
list.Eval(list.GetOnAfterSearchEvent());
}
}
nitobi.combo.List.prototype.Clear=function(){
var _2bc=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
_2bc.innerHTML="";
this.SetSelectedRowIndex(-1);
this.SetSelectedRowValues(null);
};
nitobi.combo.List.prototype.FitContent=function(){
var _2bd=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
var _2be=_2bd.childNodes[_2bd.childNodes.length-1];
var row=_2be;
while(row.childNodes[0]!=null&&row.childNodes[0].className.indexOf("ComboBoxListColumnDefinition")==-1){
row=row.childNodes[0];
}
for(var i=0;i<row.childNodes.length;i++){
var _2c1=nitobi.html.getWidth(row.childNodes[0]);
if(this.widestColumn[i]<_2c1){
this.widestColumn[i]=_2c1;
}
}
};
nitobi.combo.List.prototype.AddPage=function(_2c2,_2c3){
var _2c4=this.GetXmlDataSource();
var tmp=nitobi.xml.createXmlDoc(_2c2);
var _2c6=tmp.selectNodes("//e").length;
if(_2c6>0){
var html=this.GetRowHTML(_2c2,_2c3);
var _2c8=this.GetSectionHTMLTagObject(EBAComboBoxListBody);
nitobi.html.insertAdjacentHTML(_2c8,"beforeEnd",html,true);
this.GenerateCss();
}
var _2c9=_2c4.GetLastPageSize();
if(0==_2c6){
this.SetFooterText(EbaComboUi[EbaComboUiEndOfRecords]);
}else{
this.SetFooterText(_2c4.GetNumberRows()+EbaComboUi[EbaComboUiNumRecords]);
}
this.AdjustSize();
this.SetIFrameDimensions();
};
nitobi.combo.List.prototype.HideFooter=function(){
var _2ca=this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
var _2cb=_2ca.style;
_2cb.display="none";
};
nitobi.combo.List.prototype.ShowFooter=function(){
var _2cc=this.GetSectionHTMLTagObject(EBAComboBoxListFooter);
var _2cd=_2cc.style;
_2cd.display="inline";
};
nitobi.combo.List.prototype.AddRow=function(_2ce){
var xml="<root><e ";
for(var i=0;i<_2ce.length;i++){
xml+=String.fromCharCode(i+97)+"='"+nitobi.xml.encode(_2ce[i])+"' ";
}
xml+="/></root>";
this.GetXmlDataSource().AddPage(xml);
this.AddPage(xml);
};
nitobi.combo.List.prototype.Move=function(_2d1){
var _2d2=this.GetCombo();
var mode=_2d2.mode;
if(mode=="compact"||this.GetXmlDataSource().GetNumberRows()==0||(mode!="default"&&mode!="unbound"&&_2d2.GetTextBox().m_HTMLTagObject.value=="")){
return false;
}
var _2d4=this.GetActiveRow();
this.Show();
if(null==_2d4){
_2d4=this.GetRow(0,null);
}else{
var _2d5=this.GetRowIndex(this.GetActiveRow());
switch(_2d1){
case (EBAMoveAction_UP):
_2d5--;
break;
case (EBAMoveAction_DOWN):
_2d5++;
break;
default:
}
if((_2d5>=0)&&(_2d5<this.GetXmlDataSource().GetNumberRows())){
_2d4=this.GetRow(_2d5,null);
}
}
this.SetActiveRow(_2d4);
this.ScrollIntoView(_2d4,false,true);
return true;
};
nitobi.combo.List.prototype.GetRow=function(_2d6,Id){
if(null!=_2d6){
return document.getElementById("EBAComboBoxRow"+this.GetCombo().GetUniqueId()+"_"+_2d6);
}
if(null!=Id){
return document.getElementById(Id);
}
};
nitobi.lang.defineNs("nitobi.combo");
nitobi.combo.ListColumnDefinition=function(_2d8){
if(!_2d8.getAttribute){
_2d8.getAttribute=function(a){
return this[a];
};
}
var _2da="50px";
var _2db="ntb-combobox-list-column-definition";
var _2dc="text";
var _2dd="";
var _2de="left";
var _2df="#000";
var _2e0=(_2d8?_2d8.getAttribute("TextColor"):null);
((null==_2e0)||(""==_2e0))?this.SetTextColor(_2df):this.SetTextColor(_2e0);
var _2e1=(_2d8?_2d8.getAttribute("Align"):null);
((null==_2e1)||(""==_2e1))?this.SetAlign(_2de):this.SetAlign(_2e1);
var _2e2=(_2d8?_2d8.getAttribute("Width"):null);
((null==_2e2)||(""==_2e2))?this.SetWidth(_2da):this.SetWidth(_2e2);
var ihu=(_2d8?_2d8.getAttribute("ImageHandlerURL"):null);
((null==ihu)||(""==ihu))?this.SetImageHandlerURL(_2dd):this.SetImageHandlerURL(ihu);
var ct=(_2d8?_2d8.getAttribute("ColumnType"):null);
((null==ct)||(""==ct))?this.SetColumnType(_2dc):this.SetColumnType(ct.toLowerCase());
this.ImageUrlFromData=((this.GetColumnType()=="image")&&((null==ihu)||(""==ihu)));
var ccn=(_2d8?_2d8.getAttribute("CSSClassName"):null);
((null==ccn)||(""==ccn))?this.SetCSSClassName(_2db):this.SetCSSClassName(ccn);
var hp=(_2d8?_2d8.getAttribute("HTMLPrefix"):null);
((null==hp)||(""==hp))?this.SetHTMLPrefix(""):this.SetHTMLPrefix(hp);
var hs=(_2d8?_2d8.getAttribute("HTMLSuffix"):null);
((null==hs)||(""==hs))?this.SetHTMLSuffix(""):this.SetHTMLSuffix(hs);
var hl=(_2d8?_2d8.getAttribute("HeaderLabel"):null);
((null==hl)||(""==hl))?this.SetHeaderLabel(""):this.SetHeaderLabel(hl);
var dfi=(_2d8?_2d8.getAttribute("DataFieldIndex"):null);
((null==dfi)||(""==dfi))?this.SetDataFieldIndex(0):this.SetDataFieldIndex(dfi);
};
nitobi.combo.ListColumnDefinition.prototype.GetAlign=function(){
return this.m_Align;
};
nitobi.combo.ListColumnDefinition.prototype.SetAlign=function(_2ea){
_2ea=_2ea.toLowerCase();
if("right"!=_2ea&&"left"!=_2ea&&"center"!=_2ea){
_2ea="left";
}
this.m_Align=_2ea;
};
nitobi.combo.ListColumnDefinition.prototype.GetTextColor=function(){
return this.m_TextColor;
};
nitobi.combo.ListColumnDefinition.prototype.SetTextColor=function(_2eb){
this.m_TextColor=_2eb;
};
nitobi.combo.ListColumnDefinition.prototype.GetHTMLSuffix=function(){
return this.m_HTMLSuffix;
};
nitobi.combo.ListColumnDefinition.prototype.SetHTMLSuffix=function(_2ec){
this.m_HTMLSuffix=_2ec;
};
nitobi.combo.ListColumnDefinition.prototype.GetHTMLPrefix=function(){
return this.m_HTMLPrefix;
};
nitobi.combo.ListColumnDefinition.prototype.SetHTMLPrefix=function(_2ed){
this.m_HTMLPrefix=_2ed;
};
nitobi.combo.ListColumnDefinition.prototype.GetCSSClassName=function(){
return this.m_CSSClassName;
};
nitobi.combo.ListColumnDefinition.prototype.SetCSSClassName=function(_2ee){
this.m_CSSClassName=_2ee;
};
nitobi.combo.ListColumnDefinition.prototype.GetColumnType=function(){
return this.m_ColumnType;
};
nitobi.combo.ListColumnDefinition.prototype.SetColumnType=function(_2ef){
this.m_ColumnType=_2ef;
};
nitobi.combo.ListColumnDefinition.prototype.GetHeaderLabel=function(){
return this.m_HeaderLabel;
};
nitobi.combo.ListColumnDefinition.prototype.SetHeaderLabel=function(_2f0){
this.m_HeaderLabel=_2f0;
};
nitobi.combo.ListColumnDefinition.prototype.GetWidth=function(){
return this.m_Width;
};
nitobi.combo.ListColumnDefinition.prototype.SetWidth=function(_2f1){
this.m_Width=_2f1;
};
nitobi.combo.ListColumnDefinition.prototype.GetDataFieldIndex=function(){
return this.m_DataFieldIndex;
};
nitobi.combo.ListColumnDefinition.prototype.SetDataFieldIndex=function(_2f2){
this.m_DataFieldIndex=_2f2;
};
nitobi.combo.ListColumnDefinition.prototype.GetImageHandlerURL=function(){
return this.m_ImageHandlerURL;
};
nitobi.combo.ListColumnDefinition.prototype.SetImageHandlerURL=function(_2f3){
this.m_ImageHandlerURL=_2f3;
};
nitobi.lang.defineNs("nitobi.combo");
nitobi.combo.TextBox=function(_2f4,_2f5,_2f6){
var _2f7="";
if(nitobi.browser.IE){
_2f7="ntb-combobox-text-ie";
}else{
_2f7="ntb-combobox-text-moz";
}
var _2f8="100px";
var _2f9="";
var _2fa=true;
var _2fb="";
var _2fc=0;
var _2fd="";
var _2fe="";
this.SetCombo(_2f5);
var oeku=(_2f4?_2f4.getAttribute("OnEditKeyUpEvent"):null);
((null==oeku)||(""==oeku))?this.SetOnEditKeyUpEvent(_2fe):this.SetOnEditKeyUpEvent(oeku);
var _300=(_2f4?_2f4.getAttribute("Width"):null);
((null==_300)||(""==_300))?this.SetWidth(_2f8):this.SetWidth(_300);
var _301=(_2f4?_2f4.getAttribute("Height"):null);
((null==_301)||(""==_301))?this.SetHeight(_2f9):this.SetHeight(_301);
var ccn=(_2f4?_2f4.getAttribute("CSSClassName"):null);
((null==ccn)||(""==ccn))?this.SetCSSClassName(_2f7):this.SetCSSClassName(ccn);
var _303=(_2f4?_2f4.getAttribute("Editable"):null);
((null==_303)||(""==_303))?this.SetEditable(_2fa):this.SetEditable(_303);
var _304=(_2f4?_2f4.getAttribute("Value"):null);
((null==_304)||(""==_304))?this.SetValue(_2fb):this.SetValue(_304);
var _305=_2f5.GetDataTextField();
if(_305!=null){
this.SetDataFieldIndex(_2f5.GetList().GetXmlDataSource().GetColumnIndex(_305));
}else{
var dfi=(_2f4?_2f4.getAttribute("DataFieldIndex"):null);
((null==dfi)||(""==dfi))?this.SetDataFieldIndex(_2fc):this.SetDataFieldIndex(dfi);
}
var st=(_2f4?_2f4.getAttribute("SearchTerm"):null);
if((null==st)||(""==st)){
this.SetSearchTerm(_2fd);
this.SetIndexSearchTerm(_2fd);
}else{
this.SetSearchTerm(st);
this.SetIndexSearchTerm(st);
}
this.hasButton=_2f6;
this.m_userTag=_2f4;
};
nitobi.combo.TextBox.prototype.Unload=function(){
if(this.m_List){
delete this.m_List;
this.m_List=null;
}
if(this.m_Callback){
delete this.m_Callback;
this.m_Callback=null;
}
_EBAMemScrub(this);
};
nitobi.combo.TextBox.prototype.GetCSSClassName=function(){
return (null==this.m_HTMLTagObject?this.m_CSSClassName:this.m_HTMLTagObject.className);
};
nitobi.combo.TextBox.prototype.SetCSSClassName=function(_308){
if(null==this.m_HTMLTagObject){
this.m_CSSClassName=_308;
}else{
this.m_HTMLTagObject.className=_308;
}
};
nitobi.combo.TextBox.prototype.GetHeight=function(){
return (null==this.m_HTMLTagObject?this.m_Height:nitobi.html.Css.getStyle(this.m_HTMLTagObject,"height"));
};
nitobi.combo.TextBox.prototype.SetHeight=function(_309){
if(null==this.m_HTMLTagObject){
this.m_Height=_309;
}else{
this.m_HTMLTagObject.style.height=_309;
}
};
nitobi.combo.TextBox.prototype.GetWidth=function(){
if(null==this.m_HTMLTagObject){
return this.m_Width;
}else{
return nitobi.html.Css.getStyle(this.GetHTMLContainerObject(),"width");
}
};
nitobi.combo.TextBox.prototype.SetWidth=function(_30a){
this.m_Width=_30a;
if(null!=this.m_HTMLTagObject){
this.m_HTMLTagObject.style.width=_30a;
}
};
nitobi.combo.TextBox.prototype.GetHTMLTagObject=function(){
return this.m_HTMLTagObject;
};
nitobi.combo.TextBox.prototype.SetHTMLTagObject=function(_30b){
this.m_HTMLTagObject=_30b;
};
nitobi.combo.TextBox.prototype.GetHTMLContainerObject=function(){
return document.getElementById("EBAComboBoxTextContainer"+this.GetCombo().GetUniqueId());
};
nitobi.combo.TextBox.prototype.GetEditable=function(){
if(null==this.m_HTMLTagObject){
return this.m_Editable;
}else{
return this.m_HTMLTagObject.getAttribute("readonly");
}
};
nitobi.combo.TextBox.prototype.SetEditable=function(_30c){
if(null==this.m_HTMLTagObject){
this.m_Editable=_30c;
}else{
if(_30c==true){
this.m_HTMLTagObject.removeAttribute("readonly");
}else{
this.m_HTMLTagObject.setAttribute("readonly","true");
}
}
};
nitobi.combo.TextBox.prototype.GetValue=function(){
if(null==this.m_HTMLTagObject){
return this.m_Value;
}else{
return this.m_HTMLTagObject.value;
}
};
nitobi.combo.TextBox.prototype.SetValue=function(_30d,_30e){
if(null==this.m_HTMLTagObject){
this.m_Value=_30d;
}else{
if(this.GetCombo().mode=="smartlist"){
this.SmartSetValue(_30d,_30e);
}else{
this.m_HTMLTagObject.value=_30d;
this.m_TextValueTag.value=_30d;
}
}
};
nitobi.combo.TextBox.prototype.SmartSetValue=function(_30f,_310){
var t=this.m_HTMLTagObject;
var _312=this.GetCombo();
var lio=t.value.lastIndexOf(_312.SmartListSeparator);
if(lio>-1){
_30f=t.value.substring(0,lio)+_312.SmartListSeparator+" "+_30f;
}
if(_310){
_30f+=_312.SmartListSeparator+" ";
}
t.value=_30f;
this.m_TextValueTag.value=_30f;
};
nitobi.combo.TextBox.prototype.GetDataFieldIndex=function(){
return this.m_DataFieldIndex;
};
nitobi.combo.TextBox.prototype.SetDataFieldIndex=function(_314){
this.m_DataFieldIndex=parseInt(_314);
};
nitobi.combo.TextBox.prototype.GetCombo=function(){
return this.m_Combo;
};
nitobi.combo.TextBox.prototype.SetCombo=function(_315){
this.m_Combo=_315;
};
nitobi.combo.TextBox.prototype.GetSearchTerm=function(){
return this.m_SearchTerm;
};
nitobi.combo.TextBox.prototype.SetSearchTerm=function(_316){
this.m_SearchTerm=_316;
};
nitobi.combo.TextBox.prototype.GetIndexSearchTerm=function(){
return this.m_IndexSearchTerm;
};
nitobi.combo.TextBox.prototype.SetIndexSearchTerm=function(_317){
this.m_IndexSearchTerm=_317;
};
nitobi.combo.TextBox.prototype.OnChanged=function(e){
this.m_skipBlur=true;
var _319=this.GetCombo();
var list=_319.GetList();
list.SetActiveRow(null);
var _31b=this.GetValue();
this.m_TextValueTag.value=_31b;
var _31c=this.GetSearchTerm();
if(_319.mode=="smartsearch"||_319.mode=="smartlist"||_319.mode=="filter"||_319.mode=="compact"){
list.GetXmlDataSource().m_Dirty=true;
}
if(_319.mode=="smartlist"){
var lio=_31b.lastIndexOf(_319.SmartListSeparator);
if(lio>-1){
_31b=_31b.substring(lio+_319.SmartListSeparator.length).replace(/^\s+/,"");
}
}
if((_31c.indexOf(_31b)==0&&_31c!=_31b)){
list.GetXmlDataSource().m_Dirty=true;
}
this.SetSearchTerm(_31b);
if(e!=null){
this.prevKeyCode=e.keyCode;
}
var dfi=this.GetDataFieldIndex();
var This=this;
var _320=(e!=null?e.keyCode:0);
this.m_CurrentKeyCode=_320;
this.m_List=list;
this.m_Event=e;
this.m_Callback=_TextboxCallback;
this.m_skipBlur=false;
this.m_List.Search(_31b,dfi,this.m_Callback);
};
function _TextboxCallback(_321,list){
var _323=list.GetCombo();
var tb=_323.GetTextBox();
var e=tb.m_Event;
var _326=tb.m_CurrentKeyCode;
list.SetSelectedRowValues(null);
list.SetSelectedRowIndex(-1);
var _327=tb.GetSearchTerm();
var tb=list.GetCombo().GetTextBox();
var row=null;
if(_321>-1){
var _329="EBAComboBoxRow"+_323.GetUniqueId()+"_"+_321;
row=document.getElementById(_329);
if(""!=tb.searchValue&&(null==e||(_326!=46&&_326!=8))&&(null!=e||(tb.prevKeyCode!=46&&tb.prevKeyCode!=8))&&_323.mode!="smartlist"&&_323.mode!="smartsearch"){
tb.TypeAhead(list.GetXmlDataSource().GetRowCol(_321,tb.GetDataFieldIndex()),tb.GetSearchTerm().length,tb.GetSearchTerm());
list.SetSelectedRow(_321);
}
list.SetActiveRow(row);
}
if(e!=null&&_321>-1&&list.InitialSearchOnce!=true){
list.Show();
list.ScrollIntoView(row,true);
}
tb.m_skipBlur=false;
}
nitobi.combo.TextBox.prototype.TypeAhead=function(txt){
var t=this.m_HTMLTagObject;
var x=nitobi.html.getCursor(t);
if(txt.toLowerCase().indexOf(t.value.toLowerCase())!=0){
return;
}
this.SetValue(txt);
nitobi.html.highlight(t,x);
};
nitobi.combo.TextBox.prototype.OnMouseOver=function(_32d){
if(this.GetCombo().GetEnabled()){
if(this.GetHeight()!="100%"){
nitobi.html.Css.swapClass(this.GetHTMLContainerObject(),"ntb-combobox-text-dynamic","ntb-combobox-text-dynamic-over");
nitobi.html.Css.addClass(this.m_HTMLTagObject,"ntb-combobox-input-dynamic");
}
if(_32d){
var b=this.GetCombo().GetButton();
if(null!=b){
b.OnMouseOver(null,false);
}
}
}
};
nitobi.combo.TextBox.prototype.OnMouseOut=function(_32f){
if(this.GetCombo().GetEnabled()){
if(this.GetHeight()!="100%"){
nitobi.html.Css.swapClass(this.GetHTMLContainerObject(),"ntb-combobox-text-dynamic-over","ntb-combobox-text-dynamic");
nitobi.html.Css.removeClass(this.m_HTMLTagObject,"ntb-combobox-input-dynamic");
}
if(_32f){
var b=this.GetCombo().GetButton();
if(null!=b){
b.OnMouseOut(null,false);
}
}
}
};
nitobi.combo.TextBox.prototype.ToggleHidden=function(){
this.m_ToggleHidden=true;
};
nitobi.combo.TextBox.prototype.ToggleShow=function(){
this.m_ToggleShow=true;
};
nitobi.combo.TextBox.prototype.GetHTMLRenderString=function(){
var c=this.GetCombo();
var _332=c.GetId();
var _333=this.GetValue().replace(/\'/g,"&#39;").replace(/\"/g,"&quot;");
var w=this.GetWidth();
var h=this.GetHeight();
var _336=c.mode=="smartlist";
var html="";
var _338;
_338=(null!=w&&""!=w?"width:"+w+";":"")+(null!=h&&""!=h?"height:"+h+";":"");
html+="<div id=\"EBAComboBoxTextContainer"+this.GetCombo().GetUniqueId()+"\" class=\"ntb-combobox-text-container ntb-combobox-text-dynamic\" style=\""+(this.hasButton?"border-right:0px solid white;":"")+(_336&&nitobi.browser.IE?"width:"+w+";":"")+"\">";
if(_336&&nitobi.browser.IE){
html+="<span style='"+_338+"'>";
_338="width:100%;height:"+h+";overflow-y:auto;";
}
html+="<"+(_336==true?"textarea":"input")+" id=\"EBAComboBoxText"+_332+"\" name=\"EBAComboBoxText"+_332+"\" type=\"TEXT\" class='"+this.GetCSSClassName()+"' "+(this.GetEditable().toString().toLowerCase()=="true"?"":"readonly='true'")+" AUTOCOMPLETE='OFF' value='"+_333+"'  "+"style=\""+_338+"\" "+"onblur='var combo=document.getElementById(\""+_332+"\").object; if(!(combo.m_Over || combo.GetList().m_skipBlur)) document.getElementById(\""+_332+"\").object.GetTextBox().OnBlur(event)' "+"onkeyup='document.getElementById(\""+_332+"\").object.GetTextBox().OnKeyOperation(event,0)' "+"onkeypress='document.getElementById(\""+_332+"\").object.GetTextBox().OnKeyOperation(event,1)' "+"onkeydown='document.getElementById(\""+_332+"\").object.GetTextBox().OnKeyOperation(event,2)' "+"onmouseover='document.getElementById(\""+_332+"\").object.GetTextBox().OnMouseOver(true)' "+"onmouseout='document.getElementById(\""+_332+"\").object.GetTextBox().OnMouseOut(true)' "+"onpaste='window.setTimeout(\"document.getElementById(\\\""+_332+"\\\").object.GetTextBox().OnChanged()\",0)' "+"oninput='window.setTimeout(\"document.getElementById(\\\""+_332+"\\\").object.GetTextBox().OnChanged()\",0)' "+"onfocus='document.getElementById(\""+_332+"\").object.GetTextBox().OnFocus()' "+"tabindex='"+c.GetTabIndex()+"'>"+(_336==true?_333:"")+(_336==true?"</textarea>":"")+"<input id=\"EBAComboBoxTextValue"+_332+"\" name=\""+_332+"\" type=\"HIDDEN\" value=\""+_333+"\">";
html+="</div>";
if(_336&&nitobi.browser.IE){
html+="</span>";
}
return html;
};
nitobi.combo.TextBox.prototype.Initialize=function(){
this.m_ToggleHidden=false;
this.m_ToggleShow=false;
this.focused=false;
this.m_skipBlur=false;
this.m_skipFocusOnce=false;
this.prevKeyCode=-1;
this.skipKeyUp=false;
this.SetHTMLTagObject(document.getElementById("EBAComboBoxText"+this.GetCombo().GetId()));
this.m_TextValueTag=document.getElementById("EBAComboBoxTextValue"+this.GetCombo().GetId());
if(!this.GetCombo().GetEnabled()){
this.Disable();
}
this.m_userTag=null;
};
nitobi.combo.TextBox.prototype.Disable=function(){
nitobi.html.Css.swapClass(this.GetHTMLContainerObject(),"ntb-combobox-text-container","ntb-combobox-text-container-disabled");
nitobi.html.Css.addClass(this.m_HTMLTagObject,"ntb-combobox-input-disabled");
this.m_HTMLTagObject.disabled=true;
};
nitobi.combo.TextBox.prototype.Enable=function(){
nitobi.html.Css.swapClass(this.GetHTMLContainerObject(),"ntb-combobox-text-container-disabled","ntb-combobox-text-container");
nitobi.html.Css.removeClass(this.m_HTMLTagObject,"ntb-combobox-input-disabled");
this.m_HTMLTagObject.disabled=false;
};
nitobi.combo.TextBox.prototype.OnBlur=function(e){
var _33a=this.GetCombo();
var list=_33a.GetList();
if(this.m_skipBlur||_33a.m_Over){
return;
}
this.focused=false;
list.Hide();
eval(_33a.GetOnBlurEvent());
};
nitobi.combo.TextBox.prototype.OnFocus=function(){
if(this.m_skipBlur||this.m_skipFocusOnce){
this.m_skipFocusOnce=false;
return;
}
this.focused=true;
var _33c;
_33c=this.GetCombo().GetList().IsVisible();
if(!_33c||this.m_ToggleShow){
this.m_ToggleShow=false;
if(this.m_ToggleHidden){
this.m_ToggleHidden=false;
}else{
eval(this.GetCombo().GetOnFocusEvent());
}
}
};
nitobi.combo.TextBox.prototype.SetOnEditKeyUpEvent=function(_33d){
this.m_OnEditKeyUpEvent=_33d;
};
nitobi.combo.TextBox.prototype.GetOnEditKeyUpEvent=function(){
return this.m_OnEditKeyUpEvent;
};
nitobi.combo.TextBox.prototype.OnKeyOperation=function(e,_33f){
if(this.GetEditable()=="false"){
return;
}
e=e?e:window.event;
var _340=0;
var _341=1;
var _342=2;
var _343=13;
var _344=27;
var _345=9;
var _346=65;
var _347=90;
var _348=48;
var _349=57;
var _34a=40;
var _34b=38;
var _34c=46;
var _34d=8;
var _34e=32;
var _34f=96;
var _350=105;
var _351=36;
var _352=35;
var _353=37;
var _354=39;
var _355=112;
var _356=123;
var _357=16;
var _358=17;
var _359=18;
var _35a=33;
var _35b=34;
var t=this.m_HTMLTagObject;
var _35d=this.GetCombo();
var list=_35d.GetList();
var _35f=e.keyCode;
_35d.SetEventObject(e);
var dfi=this.GetDataFieldIndex();
switch(_33f){
case (_340):
if(_343!=_35f&&_344!=_35f&&_345!=_35f&&(_35f<_35a||_35f>_34a)&&(_35f<_355||_35f>_356)&&(_35f<_357||_35f>_359)){
if(_35d.mode=="smartsearch"||_35d.mode=="smartlist"||_35d.mode=="filter"||_35d.mode=="compact"){
list.GetXmlDataSource().m_Dirty=true;
}
this.OnChanged(e);
eval(this.GetOnEditKeyUpEvent());
}
if(_35f==_34b||_35f==_34a||_35f==_35a||_35f==_35b||_35f==_343){
if(this.smartlistWA==true){
this.smartlistWA=false;
}else{
if(nitobi.browser.IE){
t.value=t.value;
}else{
nitobi.html.setCursor(t,t.value.length);
}
}
}
if(_35d.mode=="smartlist"&&_35f==_343&&list.GetActiveRow()!=null){
this.SetValue(list.GetSelectedRowValues()[this.GetDataFieldIndex()],true);
list.SetActiveRow(null);
}
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(this.lio!=lio){
list.Hide();
}
this.lio=lio;
}
break;
case (_342):
switch(_35f){
case (_343):
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(lio!=this.lio){
list.Hide();
break;
}
}
this.m_skipBlur=true;
list.SetActiveRowAsSelected();
list.Hide();
t.focus();
eval(_35d.GetOnSelectEvent());
nitobi.html.cancelEvent(e);
this.m_skipBlur=false;
break;
case (_345):
list.Hide();
eval(_35d.GetOnTabEvent());
if(this.m_skipBlur||_35d.m_Over){
this.m_skipBlur=false;
_35d.m_Over=false;
}
list.SetActiveRowAsSelected();
eval(_35d.GetOnSelectEvent());
break;
case (_344):
list.Hide();
break;
case (_34b):
if(this.Paging==true){
break;
}
var _362;
_362=list.IsVisible();
if(_35d.mode=="smartlist"&&!_362){
this.smartlistWA=true;
break;
}
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(lio!=this.lio){
list.Hide();
break;
}
}
this.m_skipBlur=true;
this.cursor=nitobi.html.getCursor(t);
if(true==list.Move(EBAMoveAction_UP)){
t.focus();
this.SetValue(list.GetXmlDataSource().GetRowCol(list.GetRowIndex(list.GetActiveRow()),dfi));
}
this.m_skipBlur=false;
break;
case (_34a):
if(this.Paging==true){
break;
}
var _362;
_362=list.IsVisible();
if(_35d.mode=="smartlist"&&!_362){
this.smartlistWA=true;
break;
}
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(lio!=this.lio){
list.Hide();
break;
}
}
this.m_skipBlur=true;
this.cursor=nitobi.html.getCursor(t);
var r=list.GetActiveRow();
if(null!=r&&list.GetRowIndex(r)==list.GetXmlDataSource().GetNumberRows()-1&&true==list.GetAllowPaging()&&_35d.mode=="default"){
list.SetActiveRow(null);
this.Paging=true;
list.OnGetNextPage(EBAScrollToNewBottom,true);
}else{
if(true==list.Move(EBAMoveAction_DOWN)){
t.focus();
this.SetValue(list.GetXmlDataSource().GetRowCol(list.GetRowIndex(list.GetActiveRow()),dfi));
}
}
this.m_skipBlur=false;
break;
case (_35a):
if(this.Paging==true){
break;
}
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(lio!=this.lio){
list.Hide();
break;
}
}
this.m_skipBlur=true;
var b=nitobi.Browser;
var lb=list.GetSectionHTMLTagObject(EBAComboBoxListBody);
var _362;
_362=list.IsVisible();
if(_362){
var r=list.GetActiveRow()||list.GetRow(0);
if(null!=r){
var idx=list.GetRowIndex(r);
while(0!=idx){
r=list.GetRow(--idx);
if(!b.IsObjectInView(r,lb)){
break;
}
}
b.ScrollIntoView(r,lb,false,true);
list.SetActiveRow(r);
this.SetValue(list.GetXmlDataSource().GetRowCol(idx,dfi));
}
}
this.m_skipBlur=false;
break;
case (_35b):
if(this.Paging==true){
break;
}
if(_35d.mode=="smartlist"){
var lio=t.value.lastIndexOf(_35d.SmartListSeparator);
if(lio!=this.lio){
list.Hide();
break;
}
}
var _362;
_362=list.IsVisible();
if(!_362){
if(_35d.mode!="smartlist"){
list.Show();
}
}else{
this.m_skipBlur=true;
var b=nitobi.Browser;
var lb=list.GetSectionHTMLTagObject(EBAComboBoxListBody);
var r=list.GetActiveRow()||list.GetRow(0);
var idx=list.GetRowIndex(r);
var end=list.GetXmlDataSource().GetNumberRows()-1;
while(idx!=end){
r=list.GetRow(++idx);
if(!b.IsObjectInView(r,lb)){
break;
}
}
if(idx==end&&true==list.GetAllowPaging()&&_35d.mode=="default"){
list.SetActiveRow(null);
this.Paging=true;
list.OnGetNextPage(EBAScrollToNewTop,true);
}else{
b.ScrollIntoView(r,lb,true,false);
list.SetActiveRow(r);
this.SetValue(list.GetXmlDataSource().GetRowCol(idx,dfi));
}
this.m_skipBlur=false;
}
break;
default:
}
break;
case (_341):
if(_35f==_343){
nitobi.html.cancelEvent(e);
}
break;
default:
}
_35d.SetEventObject(null);
};
nitobi.lang.defineNs("nitobi.browser");
if(!nitobi.browser.IE){
Document.prototype.readyState=0;
Document.prototype.__load__=Document.prototype.load;
Document.prototype.load=_Document_load;
Document.prototype.onreadystatechange=null;
Node.prototype._uniqueID=null;
Node.prototype.__defineGetter__("uniqueID",_Node_getUniqueID);
}
function _Document_load(_368){
changeReadyState(this,1);
try{
this.__load__(_368);
}
catch(e){
changeReadyState(this,4);
}
}
function changeReadyState(oDOM,_36a){
oDOM.readyState=_36a;
if(oDOM.onreadystatechange!=null&&(typeof oDOM.onreadystatechange)=="function"){
oDOM.onreadystatechange();
}
}
_Node_getUniqueID.i=1;
function _Node_getUniqueID(){
if(null==this._uniqueID){
this._uniqueID="mz__id"+_Node_getUniqueID.i++;
}
return this._uniqueID;
}
function XmlDataIslands(){
}
function xbClipXml(oXml,_36c,_36d,_36e){
var xsl="<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"><xsl:template match=\""+_36c+"\"><xsl:copy><xsl:copy-of select=\"@*\"></xsl:copy-of><xsl:apply-templates select=\""+_36d+"\"></xsl:apply-templates></xsl:copy></xsl:template><xsl:template match=\""+_36d+"\"><xsl:choose><xsl:when test=\"position()&lt;="+_36e+"\"><xsl:copy-of select=\".\"></xsl:copy-of></xsl:when></xsl:choose></xsl:template></xsl:stylesheet>";
var x=nitobi.xml.createXmlDoc(xsl);
return nitobi.xml.transformToXml(oXml,x);
}
nitobi.Browser.ConvertXmlDataIsland=function(_371,_372){
if(null!=_371&&""!=_371){
var xmls=document.getElementById(_371);
if(null!=xmls){
var id=xmls.getAttribute("id");
var src=xmls.getAttribute("src");
var d;
if(null==src){
d=nitobi.xml.createXmlDoc(this.EncodeAngleBracketsInTagAttributes(xmls.innerHTML.replace(/>\s+</g,"><")));
}else{
var _377=nitobi.Browser.LoadPageFromUrl(src,_372);
var _378=_377.indexOf("<?xml");
if(_378!=-1){
_377=(_377.substr(_378));
}
d=nitobi.xml.createXmlDoc(_377);
var d2=nitobi.xml.createXmlDoc(this.EncodeAngleBracketsInTagAttributes(d.xml.replace(/>\s+</g,"><")));
d=d2;
}
document[id]=d;
var p=(xmls.parentNode?xmls.parentNode:xmls.parentElement);
p.removeChild(xmls);
}
}
};
nitobi.lang.defineNs("nitobi.combo");
nitobi.combo.XmlDataSource=function(){
this.combo=null;
this.m_Dirty=true;
this.SetLastPageSize(0);
this.SetNumberColumns(0);
};
nitobi.combo.XmlDataSource.prototype.GetXmlId=function(){
return this.m_XmlId;
};
nitobi.combo.XmlDataSource.prototype.SetXmlId=function(_37b){
this.m_XmlId=_37b;
};
nitobi.combo.XmlDataSource.prototype.GetXmlObject=function(){
return this.m_XmlObject;
};
nitobi.combo.XmlDataSource.prototype.SetXmlObject=function(_37c,clip,_37e){
if(null==_37c.documentElement){
return;
}
if(clip==true){
_37c=xbClipXml(_37c,"root","e",_37e);
}
this.m_XmlObject=_37c;
this.SetLastPageSize(this.GetNumberRows());
var _37f=_37c.documentElement.getAttribute("fields");
if(null==_37f){
}else{
var _380=_37f.split("|");
this.SetColumnNames(_380);
this.SetNumberColumns(_380.length);
}
};
nitobi.combo.XmlDataSource.prototype.GetNumberRows=function(){
return this.GetXmlObject().selectNodes("//e").length;
};
nitobi.combo.XmlDataSource.prototype.GetLastPageSize=function(){
return this.m_LastPageSize;
};
nitobi.combo.XmlDataSource.prototype.SetLastPageSize=function(_381){
this.m_LastPageSize=_381;
};
nitobi.combo.XmlDataSource.prototype.GetNumberColumns=function(){
return this.m_NumberColumns;
};
nitobi.combo.XmlDataSource.prototype.SetNumberColumns=function(_382){
this.m_NumberColumns=parseInt(_382);
};
nitobi.combo.XmlDataSource.prototype.GetColumnNames=function(){
return this.m_ColumnNames;
};
nitobi.combo.XmlDataSource.prototype.SetColumnNames=function(_383){
this.m_ColumnNames=_383;
};
nitobi.combo.XmlDataSource.prototype.Search=function(_384,_385,_386){
_384=_384.toLowerCase();
_384=nitobi.xml.constructValidXpathQuery(_384,true);
var xsl="<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\" version=\"1.0\">";
xsl+="<xsl:output method=\"text\" />";
xsl+="<xsl:template match=\"/\"><xsl:apply-templates select=\"//e["+(_386==true?"contains":"starts-with")+"(@"+String.fromCharCode(97+parseInt(_385))+","+_384+")][1]\"/></xsl:template>";
xsl+="<xsl:template match=\"e\">";
xsl+="<xsl:value-of select=\"count(preceding-sibling::e)\" />";
xsl+="</xsl:template>";
xsl+="</xsl:stylesheet>";
var oXSL=nitobi.xml.createXslProcessor(xsl);
var _389=nitobi.xml.createXmlDoc(this.GetXmlObject().xml.replace(/>\s+</g,"><").toLowerCase());
var _38a=nitobi.xml.transformToString(_389,oXSL);
if(""==_38a){
_38a=-1;
}
return parseInt(_38a);
};
nitobi.combo.XmlDataSource.prototype.AddPage=function(XML){
var tmp=nitobi.xml.createXmlDoc(XML);
var _38d=tmp.selectNodes("//e");
var root=this.GetXmlObject().documentElement;
this.SetLastPageSize(tmp.selectNodes("//e").length);
for(var i=0;i<_38d.length;i++){
root.appendChild(_38d[i].cloneNode(true));
}
this.m_Dirty=false;
};
nitobi.combo.XmlDataSource.prototype.Clear=function(){
nitobi.xml.loadXml(this.GetXmlObject(),"<root/>",true);
};
nitobi.combo.XmlDataSource.prototype.GetRow=function(_390){
_390=parseInt(_390);
var row=this.GetXmlObject().documentElement.childNodes.item(_390);
var _392=new Array;
for(var i=0;i<this.GetNumberColumns();i++){
_392[i]=row.getAttribute(String.fromCharCode(97+i));
}
return _392;
};
nitobi.combo.XmlDataSource.prototype.GetRowCol=function(Row,Col){
var row=this.GetXmlObject().documentElement.childNodes.item(parseInt(Row));
var val=row.getAttribute(String.fromCharCode(97+parseInt(Col)));
return val;
};
nitobi.combo.XmlDataSource.prototype.GetColumnIndex=function(Name){
if(Name==null){
return 0;
}
Name=Name.toLowerCase();
var _399=this.GetColumnNames();
if(_399!=null){
for(var i=0;i<_399.length;i++){
if(Name==_399[i].toLowerCase()){
return parseInt(i);
}
}
}
return -1;
};

