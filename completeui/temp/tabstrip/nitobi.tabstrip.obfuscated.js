if(typeof (nitobi)=="undefined"||typeof (nitobi.lang)=="undefined"){
alert("The Nitobi framework source could not be found. Is it included before any other Nitobi components?");
}
nitobi.lang.defineNs("nitobi.tabstrip");
if(false){
nitobi.tabstrip=function(){
};
}
nitobi.tabstrip.TabStrip=function(id){
nitobi.tabstrip.TabStrip.baseConstructor.call(this,id);
this.renderer.setTemplate(nitobi.tabstrip.tabstripProc);
this.onClick=new nitobi.base.Event("click");
this.eventMap["click"]=this.onClick;
this.onMouseOut=new nitobi.base.Event("mouseout");
this.eventMap["mouseout"]=this.onMouseOut;
this.onMouseOver=new nitobi.base.Event("mouseover");
this.eventMap["mouseover"]=this.onMouseOver;
this.subscribeDeclarationEvents();
this.renderTimes=0;
this.version="0.8";
this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
};
nitobi.lang.extend(nitobi.tabstrip.TabStrip,nitobi.ui.Element);
nitobi.tabstrip.TabStrip.profile=new nitobi.base.Profile("nitobi.tabstrip.TabStrip",null,false,"ntb:tabstrip");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.TabStrip.profile);
nitobi.tabstrip.TabStrip.prototype.getTabs=function(){
return this.getObject(nitobi.tabstrip.Tabs.profile);
};
nitobi.tabstrip.TabStrip.prototype.setTabs=function(_2){
return this.setObject(_2);
};
nitobi.tabstrip.TabStrip.prototype.fitContainers=function(){
try{
var _3=this.getHtmlNode();
if(_3){
var _4=this.getHtmlNode("secondarycontainer");
if(_4){
var _5=nitobi.html.getBox(_3);
_4.style.height=_5.height+"px";
_4.style.width=_5.width+"px";
}
}
}
catch(err){
}
};
nitobi.tabstrip.TabStrip.prototype.render=function(){
this.onBeforeRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
if(this.renderTimes==0){
nitobi.tabstrip.TabStrip.base.render.call(this);
var _6=this.getTabs();
this.onRender.subscribe(_6.handleRender,_6);
_6.loadTabs();
var _7=this.getHtmlNode();
if(nitobi.browser.IE){
nitobi.html.attachEvent(_7,"resize",this.fitContainers,this);
nitobi.html.attachEvent(_7,"resize",_6.handleResize,_6);
}else{
nitobi.html.attachEvent(window,"resize",this.fitContainers,this);
nitobi.html.attachEvent(window,"resize",_6.handleResize,_6);
}
}else{
var _6=this.getTabs();
_6.render();
}
this.renderTimes++;
this.onRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
this.fitContainers();
if(_7){
_7.jsObject=this;
}
};
nitobi.tabstrip.TabStrip.prototype.getWidth=function(){
return this.getAttribute("width");
};
nitobi.tabstrip.TabStrip.prototype.setWidth=function(_8){
this.setAttribute("width",_8);
this.setStyle("width",_8);
};
nitobi.tabstrip.TabStrip.prototype.getHeight=function(){
return this.getAttribute("height");
};
nitobi.tabstrip.TabStrip.prototype.setHeight=function(_9){
this.setAttribute("height",_9);
this.setStyle("height",_9);
};
nitobi.tabstrip.TabStrip.prototype.getCssClass=function(){
return this.getAttribute("cssclass");
};
nitobi.tabstrip.TabStrip.prototype.getTheme=function(){
return this.getAttribute("theme");
};
nitobi.tabstrip.TabStrip.prototype.setCssClass=function(_a){
this.setAttribute("cssclass",_a);
var _b=this.getHtmlNode();
if(_b){
_b.className=_a;
}
};
nitobi.tabstrip.TabStrip.prototype.setTheme=function(_c){
this.setAttribute("theme",_c);
var _d=this.getHtmlNode();
if(_d){
_d.className=_c;
}
};
nitobi.tabstrip.TabStrip.prototype.getCssStyle=function(){
return this.getAttribute("cssstyle");
};
nitobi.tabstrip.TabStrip.prototype.setCssStyle=function(_e){
this.setAttribute("cssstyle",_e);
};
nitobi.tabstrip.TabStrip.prototype.getTabIndex=function(){
return this.getAttribute("tabindex");
};
nitobi.tabstrip.TabStrip.handleEvent=function(id,_10,_11,_12){
try{
var _13=$ntb(id);
if(_13==null){
nitobi.lang.throwError("The tabstrip event could not find the component object.  The element with the specified id could not be found on the page.");
}
_13=_13.jsObject;
_13.notify(_10,_11,null,_12);
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected,err);
}
};
nitobi.tabstrip.TabStrip.precacheImages=function(url){
var url=url||"tabstrip.css";
var _15=nitobi.html.Css.getStyleSheetsByName(url);
for(var i=0;i<_15.length;i++){
nitobi.html.Css.precacheImages(_15[i]);
}
};
nitobi.TabStrip=nitobi.tabstrip.TabStrip;
nitobi.lang.defineNs("nitobi.tabstrip");
nitobi.tabstrip.Tab=function(_17){
nitobi.tabstrip.Tab.baseConstructor.call(this,_17);
this.onEventNotify.subscribe(this.handleEventNotify,this);
this.onClick=new nitobi.base.Event("click");
this.eventMap["click"]=this.onClick;
this.onMouseOut=new nitobi.base.Event("mouseout");
this.eventMap["mouseout"]=this.onMouseOut;
this.onMouseOver=new nitobi.base.Event("mouseover");
this.eventMap["mouseover"]=this.onMouseOver;
this.onFocus=new nitobi.base.Event("focus");
this.eventMap["focus"]=this.onFocus;
this.onBlur=new nitobi.base.Event("blur");
this.eventMap["blur"]=this.onBlur;
this.onActivate=new nitobi.base.Event("activate");
this.eventMap["activate"]=this.onActivate;
this.onDeactivate=new nitobi.base.Event("deactivate");
this.eventMap["deactivate"]=this.onDeactivate;
this.onLoad=new nitobi.base.Event("load");
this.eventMap["load"]=this.onLoad;
this.callback=null;
this.contentLoaded=false;
this.subscribeDeclarationEvents();
this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
};
nitobi.lang.extend(nitobi.tabstrip.Tab,nitobi.ui.Element);
nitobi.tabstrip.Tab.profile=new nitobi.base.Profile("nitobi.tabstrip.Tab",null,false,"ntb:tab");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.Tab.profile);
nitobi.tabstrip.Tab.prototype.show=function(_18){
var el=this.getBodyHtmlNode();
if(_18){
nitobi.html.Css.setOpacity(el,0);
}
el.style.height="100%";
el.style.width="100%";
el.style.position="";
el.style.display="";
el.className="ntb-tab-active";
var el=this.getHtmlNode("activetabclassdiv");
el.className="ntb-tab-active";
if(_18){
}else{
this.onActivate.notify(new nitobi.ui.ElementEventArgs(this));
}
};
nitobi.tabstrip.Tab.prototype.hide=function(_1a){
try{
if(_1a){
var el=this.getHtmlNode("activetabclassdiv");
el.className="ntb-tab-inactive";
nitobi.ui.Effects.fade(this.getBodyHtmlNode(),0,400,nitobi.lang.close(this,this.handleHide));
}else{
this.handleHide();
}
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected+" The tab could not be hidden.",err);
}
};
nitobi.tabstrip.Tab.prototype.pulse=function(){
this.pulseEnabled=true;
for(var i=0;i<this.nodelist.length;i++){
this.nodelist[i].style.visibility="visible";
}
this.pulseNext(this.nodelist);
};
nitobi.tabstrip.Tab.prototype.pulseNext=function(_1d){
var _1e=nitobi.html.Css.getOpacity(_1d[0]);
if(this.pulseEnabled||_1e>1){
nitobi.ui.Effects.fade(_1d,(_1e==0?100:0),1400,nitobi.lang.close(this,this.pulseNext,[_1d]),nitobi.ui.Effects.cube);
}else{
if(this.pulseEnabled==false){
for(var i=0;i<this.nodelist.length;i++){
this.nodelist[i].style.visibility="hidden";
}
}
}
};
nitobi.tabstrip.Tab.prototype.stopPulse=function(){
this.pulseEnabled=false;
};
nitobi.tabstrip.Tab.prototype.handleHide=function(){
var el=this.getHtmlNode("activetabclassdiv");
el.className="ntb-tab-inactive";
el=this.getBodyHtmlNode();
el.className="ntb-tab-inactive";
el.style.width="1px";
el.style.height="1px";
el.style.position="absolute";
el.style.top="-5000px";
el.style.left="-5000px";
try{
this.onDeactivate.notify(new nitobi.ui.ElementEventArgs(this));
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected+" onDeactivate notification contains an error.",err);
}
};
nitobi.tabstrip.Tab.prototype.handleEventNotify=function(_21){
var _22=_21.htmlEvent;
var _23=nitobi.ui.Element.parseId(_21.targetId);
var _24=true;
switch(_22.type){
case ("load"):
this.handleOnLoad();
break;
case ("click"):
_24=this.isEnabled();
break;
}
return _24;
};
nitobi.tabstrip.Tab.prototype.load=function(_25){
this.nodelist=new Array();
this.nodelist[0]=this.getHtmlNode("leftpulse");
nitobi.html.setOpacity(this.nodelist[0],0);
this.nodelist[1]=this.getHtmlNode("bodypulse");
this.nodelist[2]=this.getHtmlNode("rightpulse");
var box=nitobi.html.getBox(this.getHtmlNode("labeltable"));
this.nodelist[1].style.width=box.width+"px";
if(_25==null){
_25=this.getSource();
}
if(_25==null){
return;
}
this.setActivityIndicatorVisible(true);
var _27=this.getIframeHtmlNode();
var el=$ntb(_25);
if(_27!=null){
try{
_27.src=_25;
}
catch(err){
nitobi.lang.throwError("Could not load iframe with src "+_25);
}
}else{
if(el!=null){
var _29=this.getNodeFrameHtmlNode();
_29.appendChild(el);
nitobi.component.loadComponentsFromNode(_29);
nitobi.html.Css.removeClass(el,"ntb-tab-domnode");
this.handleOnLoad();
}else{
try{
var _2a=this.getNodeFrameHtmlNode();
this.setActivityIndicatorVisible(true);
var _2b=nitobi.ajax.HttpRequestPool.getInstance();
this.callback=_2b.reserve();
this.callback.handler=_25;
this.callback.context=this;
this.callback.params=this.callback;
this.callback.onGetComplete.subscribe(this.handleOnLoad,this);
this.callback.responseType="text";
this.callback.get();
}
catch(err){
nitobi.lang.throwError("The HTTP request for tab could not be performed. Is the website accessible by client script? Cross domain scriping is not permitted. Use IFrame for this purpose.",err);
}
}
}
};
nitobi.tabstrip.Tab.prototype.handleOnLoad=function(_2c){
try{
if(_2c!=null&&_2c.params!=null){
var _2d=this.getNodeFrameHtmlNode();
if(nitobi.ajax.HttpRequest.isError(_2c.status)){
_2d.innerHTML="<div style=\"margin-left:20px;margin-right:20px\"><h1 style=\"font-family:arial;font-size:14pt;\">Error</h1><p style=\"font-family:tahoma;font-size:10pt;\">The tab could not be opened because the location of the tab content could not be found.</p><ul style=\"font-family:tahoma;font-size:10pt;\"><li>The server may be busy or not responding</li><li>The address of the tab content may be incorrect.</li><li>The address may be that of an HTML Element that was not on the page</li></ul><p style=\"font-family:tahoma;font-size:10pt;\">Try again later. If the problem persists, contact your local administrator.</p><p style=\"font-family:tahoma;font-size:10pt;\">The faulty source was "+this.getSource()+". The server return code was <b>"+_2c.status+" ("+_2c.statusText+").</b> The server response follows:</p><hr/><p>"+_2c.response+"</p></div>";
nitobi.error.onError.notify(new nitobi.error.ErrorEventArgs(this,nitobi.error.HttpRequestError+"\n\n OR \n\n "+nitobi.error.NoHtmlNode,nitobi.tabstrip.Tab.profile.className));
}else{
_2d.innerHTML=_2c.response;
if(this.isScriptEvaluationEnabled()){
nitobi.html.evalScriptBlocks(_2d);
}
nitobi.component.loadComponentsFromNode(_2d);
}
var _2e=nitobi.ajax.HttpRequestPool.getInstance();
_2e.release(_2c.params);
}
this.setContentLoaded(true);
this.setActivityIndicatorVisible(false);
this.onLoad.notify(new nitobi.ui.ElementEventArgs(this));
}
catch(err){
nitobi.error.onError.notify(new nitobi.error.ErrorEventArgs(this,"The tab encountered an error while trying to parse the response from load. There may be an error in the onLoad event.",nitobi.tabstrip.Tab.profile.className));
}
};
nitobi.tabstrip.Tab.prototype.isActivityIndicatorVisible=function(){
return (this.getActivityIndicatorHtmlNode().style.display!="none");
};
nitobi.tabstrip.Tab.prototype.setActivityIndicatorVisible=function(_2f){
if(_2f==null||typeof (_2f)!="boolean"){
nitobi.lang.throwError(nitobi.error.BadArgType);
}
this.getActivityIndicatorHtmlNode().style.display=(_2f?"":"none");
};
nitobi.tabstrip.Tab.prototype.autoSetActivityIndicator=function(){
if(this.getContainerType()=="iframe"){
var _30=this.getIframeHtmlNode();
if(_30!=null){
if(nitobi.browser.IE){
this.setActivityIndicatorVisible(_30.readyState!="complete");
}else{
if(this.contentLoaded==true){
this.setActivityIndicatorVisible(false);
}else{
if(this.getLoadOnDemandEnabled()==true){
this.setActivityIndicatorVisible(false);
}
}
}
}else{
if(this.callback!=null){
this.setActivityIndicatorVisible(this.callback.readyState!=4);
}
}
}
};
nitobi.tabstrip.Tab.prototype.getActivityIndicatorHtmlNode=function(){
return this.getHtmlNode("activityindicator");
};
nitobi.tabstrip.Tab.prototype.getIframeHtmlNode=function(){
return this.getHtmlNode("tabiframe");
};
nitobi.tabstrip.Tab.prototype.getNodeFrameHtmlNode=function(){
return this.getHtmlNode("tabnodeframe");
};
nitobi.tabstrip.Tab.prototype.isBodyHtmlNodeAvail=function(){
return (this.getHtmlNode("tabbody")!=null);
};
nitobi.tabstrip.Tab.prototype.getBodyHtmlNode=function(){
var _31=this.getHtmlNode("tabbody");
if(_31==null){
nitobi.lang.throwError(nitobi.error.NoHtmlNode+" The body of the tab could not be found. Is a body defined for this tab?");
}
return _31;
};
nitobi.tabstrip.Tab.prototype.destroyHtml=function(){
if(this.isBodyHtmlNodeAvail()){
var _32=this.getBodyHtmlNode();
_32.parentNode.removeChild(_32);
}
var _32=this.getHtmlNode();
if(_32!=null){
_32.parentNode.removeChild(_32);
}
};
nitobi.tabstrip.Tab.prototype.setEnabled=function(_33){
if(_33==null||typeof (_33)!="boolean"){
nitobi.lang.throwError(nitobi.error.BadArgType);
}
nitobi.tabstrip.Tab.base.setEnabled.call(this,_33);
this.setBoolAttribute("enabled",_33);
var el=this.getHtmlNode("activetabclassdiv");
if(el){
if(el.className!="ntb-tab-disabled"&&!_33){
el.className="ntb-tab-disabled";
}
}
};
nitobi.tabstrip.Tab.prototype.isEnabled=function(){
return this.getBoolAttribute("enabled");
};
nitobi.tabstrip.Tab.prototype.getWidth=function(){
return this.getAttribute("width");
};
nitobi.tabstrip.Tab.prototype.setWidth=function(_35){
this.setAttribute("width",_35);
this.setStyle("width",_35);
};
nitobi.tabstrip.Tab.prototype.getTooltip=function(){
return this.getAttribute("tooltip");
};
nitobi.tabstrip.Tab.prototype.setTooltip=function(_36){
this.setAttribute("tooltip",_36);
var el=this.getHtmlNode();
if(el){
el.title=_36;
}
};
nitobi.tabstrip.Tab.prototype.getIcon=function(){
return this.getAttribute("icon");
};
nitobi.tabstrip.Tab.prototype.setIcon=function(_38){
this.setAttribute("icon",_38);
var _39=this.getHtmlNode("icon");
if(_38==null||_38==""){
if(_39){
nitobi.html.Css.setStyle(_39,"display","none");
}
}else{
if(_39){
nitobi.html.Css.setStyle(_39,"display","inline");
}
}
if(_39){
_39.src=_38;
}
};
nitobi.tabstrip.Tab.prototype.getSource=function(){
return this.getAttribute("source");
};
nitobi.tabstrip.Tab.prototype.setSource=function(_3a){
this.setAttribute("source",_3a);
};
nitobi.tabstrip.Tab.prototype.isScriptEvaluationEnabled=function(){
var val=this.getAttribute("scriptevaluationenabled");
if(null==val){
return true;
}else{
return this.getBoolAttribute("scriptevaluationenabled");
}
};
nitobi.tabstrip.Tab.prototype.setScriptEvaluationEnabled=function(_3c){
this.setBoolAttribute("scriptevaluationenabled",_3c);
};
nitobi.tabstrip.Tab.prototype.getLabel=function(){
return this.getAttribute("label");
};
nitobi.tabstrip.Tab.prototype.setLabel=function(_3d){
this.setAttribute("label",_3d);
var _3e=this.getHtmlNode("label");
if(_3e){
_3e.innerHTML=_3d;
}
};
nitobi.tabstrip.Tab.prototype.getContainerType=function(){
return this.getAttribute("containertype");
};
nitobi.tabstrip.Tab.prototype.setContainerType=function(_3f){
if(_3f!=""&&_3f!="iframe"){
nitobi.lang.throwError(nitobi.error.BadArg+" Valid values are 'iframe' or ''");
}
this.setAttribute("containertype",_3f);
};
nitobi.tabstrip.Tab.prototype.getCssClass=function(){
return this.getAttribute("cssclass");
};
nitobi.tabstrip.Tab.prototype.setCssClass=function(_40){
this.setAttribute("cssclass",_40);
var _41=this.getHtmlNode("customcss");
if(_41){
this.className=_40;
}
};
nitobi.tabstrip.Tab.prototype.getLoadOnDemandEnabled=function(){
if(this.getBoolAttribute("loadondemandenabled")!=null){
return this.getBoolAttribute("loadondemandenabled");
}else{
return false;
}
};
nitobi.tabstrip.Tab.prototype.setLoadOnDemandEnabled=function(_42){
this.setBoolAttribute("loadondemandenabled",_42);
};
nitobi.tabstrip.Tab.prototype.getContentLoaded=function(){
return this.contentLoaded;
};
nitobi.tabstrip.Tab.prototype.setContentLoaded=function(_43){
this.contentLoaded=_43;
};
nitobi.tabstrip.Tab.prototype.getHideOverflowEnabled=function(){
if(this.getBoolAttribute("hideoverflowenabled")!=null){
return this.getBoolAttribute("hideoverflowenabled");
}else{
return false;
}
};
nitobi.tabstrip.Tab.prototype.setHideOverflowEnabled=function(_44){
this.setBoolAttribute("hideoverflowenabled",_44);
var _45=this.getHtmlNode("tabbody");
if(_44==true){
_45.style.overflow="hidden";
}else{
_45.style.overflow="auto";
}
};
nitobi.lang.defineNs("nitobi.tabstrip");
nitobi.tabstrip.Tabs=function(_46){
nitobi.tabstrip.Tabs.baseConstructor.call(this,_46);
nitobi.ui.IScrollable.call(this);
this.onClick=new nitobi.base.Event("click");
this.eventMap["click"]=this.onClick;
this.onMouseOut=new nitobi.base.Event("mouseout");
this.eventMap["mouseout"]=this.onMouseOut;
this.onMouseOver=new nitobi.base.Event("mouseover");
this.eventMap["mouseover"]=this.onMouseOver;
this.onEventNotify.subscribe(this.handleEventNotify,this);
this.onBeforeEventNotify.subscribe(this.handleBeforeEventNotify,this);
this.onBeforeTabChange=new nitobi.base.Event("beforetabchange");
this.eventMap["beforetabchange"]=this.onBeforeTabChange;
this.onTabChange=new nitobi.base.Event("tabchange");
this.eventMap["tabchange"]=this.onTabChange;
this.subscribeDeclarationEvents();
this.renderer.setTemplate(nitobi.tabstrip.tabstripProc);
this.onCreated.notify(new nitobi.ui.ElementEventArgs(this));
};
nitobi.lang.extend(nitobi.tabstrip.Tabs,nitobi.ui.Container);
nitobi.lang.implement(nitobi.tabstrip.Tabs,nitobi.ui.IScrollable);
nitobi.tabstrip.Tabs.profile=new nitobi.base.Profile("nitobi.tabstrip.Tabs",null,false,"ntb:tabs");
nitobi.base.Registry.getInstance().register(nitobi.tabstrip.Tabs.profile);
nitobi.tabstrip.Tabs.prototype.loadTabs=function(){
var tab=this.get(this.getActiveTabIndex());
if(tab==null){
return;
}else{
tab.load();
}
var _48=this.getXmlNode().selectNodes("ntb:tab[@loadondemandenabled!='true' or not(@loadondemandenabled) and not(@id='"+tab.getId()+"')]");
for(var i=0;i<_48.length;i++){
var _4a=nitobi.xml.indexOfChildNode(this.getXmlNode(),_48[i]);
var tab=this.get(_4a);
tab.load();
}
};
nitobi.tabstrip.Tabs.prototype.handleRender=function(){
this.handleResize();
};
nitobi.tabstrip.Tabs.prototype.handleResize=function(){
this.setScrollableElement(this.getHtmlNode("container"));
this.setScrollButtonsVisible(this.isOverflowed());
};
nitobi.tabstrip.Tabs.prototype.handleTabClick=function(tab){
if(typeof (tab)=="object"){
index=this.indexOf(tab);
}else{
index=tab;
tab=this.get(index);
}
tab.onClick.notify(new nitobi.ui.ElementEventArgs(this));
this.setActiveTab(tab);
};
nitobi.tabstrip.Tabs.prototype.setScrollButtonsVisible=function(_4c){
if(_4c!=null&&typeof (_4c)!="boolean"){
nitobi.lang.throwError(nitobi.error.BadArgType);
}
var el=this.getHtmlNode("scrollerbuttoncontainer");
nitobi.html.Css.setStyle(el,"display",(_4c?"":"none"));
};
nitobi.tabstrip.Tabs.prototype.getActiveTabIndex=function(){
return this.getIntAttribute("activetabindex");
};
nitobi.tabstrip.Tabs.prototype.setActiveTabIndex=function(_4e){
this.setIntAttribute("activetabindex",_4e);
};
nitobi.tabstrip.Tabs.prototype.render=function(){
this.onBeforeRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
this.setContainer(this.getHtmlNode().parentNode);
this.renderer.setParameters({"apply-template":"tabs"});
nitobi.tabstrip.Tabs.base.render.call(this,null,this.getXmlNode().ownerDocument);
var _4f=null;
var len=this.getLength();
for(var i=0;i<len;i++){
var tab=this.get(i);
var box=nitobi.html.getBox(tab.getHtmlNode("labeltable"));
tab.getHtmlNode("bodypulse").style.width=box.width+"px";
if(!tab.isBodyHtmlNodeAvail()){
this.renderer.setParameters({"apply-template":"body"});
this.renderer.setParameters({"apply-id":(i+1)});
if(_4f==null){
this.renderer.renderIn(this.getBodiesContainerHtmlNode(),this.getState().ownerDocument);
}else{
this.renderer.renderAfter(_4f,this.getState().ownerDocument);
}
tab.load();
}else{
tab.autoSetActivityIndicator();
_4f=tab.getBodyHtmlNode();
}
}
if(len>0){
this.getActiveTab().show();
}
this.onRender.notify(new nitobi.ui.ElementEventArgs(this,null,this.getId()));
};
nitobi.tabstrip.Tabs.prototype.getBodiesContainerHtmlNode=function(){
if(this.bodiesContainerHtmlNode){
return this.bodiesContainerHtmlNode;
}else{
var _54=this.getParentObject().getHtmlNode("tabbodiescontainer");
if(_54==null){
nitobi.lang.throwError(nitobi.error.NoHtmlNode+" The bodiesContainer html element could not be found.");
}
this.bodiesContainerHtmlNode=_54;
return _54;
}
};
nitobi.tabstrip.Tabs.prototype.getActiveTab=function(){
return this.get(this.getActiveTabIndex());
};
nitobi.tabstrip.Tabs.prototype.setActiveTab=function(tab){
if(null==tab){
nitobi.lang.throwError(nitobi.error.BadArgType);
}
try{
var _56;
var _57=this.getActiveTab();
if(typeof (tab)=="object"){
_56=this.indexOf(tab);
}else{
_56=tab;
tab=this.get(_56);
}
if(_56==this.getActiveTabIndex()){
return;
}
var _58=new nitobi.tabstrip.TabChangeEventArgs(this,null,this.getId(),_57,tab);
if(this.onBeforeTabChange.notify(_58)){
if(this.getActivateEffect()=="fade"){
nitobi.tabstrip.Tabs.transition(this,_57,tab);
}else{
_57.hide();
if(tab.getContentLoaded()==false){
tab.load();
}
tab.show();
}
this.setActiveTabIndex(_56);
this.onTabChange.notify(_58);
}
}
catch(err){
nitobi.lang.throwError(nitobi.error.Unexpected+" The active tab could not be set.",err);
}
};
nitobi.tabstrip.Tabs.transition=function(_59,_5a,_5b){
var _5c=_5a.getBodyHtmlNode();
var _5d=_5b.getBodyHtmlNode();
var _5e=nitobi.html.indexOfChildNode(_5c.parentNode,_5c);
var _5f=nitobi.html.indexOfChildNode(_5d.parentNode,_5d);
var _60,_61;
if(_5f>_5e){
_60=_5d;
_61=_5c;
}else{
_60=_5c;
_61=_5d;
}
nitobi.html.Css.setOpacity(_5c,100);
var _62=nitobi.html.indexOfChildNode(_5c.parentNode,_5c);
var box=nitobi.html.getBox(_5c);
if(_5e<_5f){
_5b.show("effect");
}
var _64=_59.getParentObject().getHtmlNode("tabbodiesdivcontainer");
_64.style.height=nitobi.html.getBox(_64).height+"px";
var top=-1*nitobi.html.getBox(_5c).height;
var _66=_60.style.display;
_60.style.display="none";
_60.style.top=top+"px";
_60.style.left="0px";
_60.style.left="0px";
_60.style.position="relative";
_60.style.height=box.height+"px";
_61.style.height=box.height+"px";
_64.style.height="100%";
_60.style.display=_66;
_5a.hide("effect");
if(_5e>_5f){
_5b.show("effect");
}
nitobi.ui.Effects.fade(_5d,100,400,nitobi.lang.close(_5b,_5b.show));
};
nitobi.tabstrip.Tabs.prototype.getAlign=function(){
return this.getAttribute("align");
};
nitobi.tabstrip.Tabs.prototype.setAlign=function(_67){
if(_67!="left"&&_67!="right"&&_67!="center"){
nitobi.lang.throwError(nitobi.error.BadArg);
}
this.setAttribute("align",_67);
};
nitobi.tabstrip.Tabs.prototype.getActivateEffect=function(){
return this.getAttribute("activateeffect");
};
nitobi.tabstrip.Tabs.prototype.setActivateEffect=function(_68){
if(_68!=""&&_68!="fade"){
nitobi.lang.throwError(nitobi.error.BadArg);
}
this.setAttribute("activateeffect",_68);
};
nitobi.tabstrip.Tabs.prototype.getHeight=function(){
return this.getAttribute("height");
};
nitobi.tabstrip.Tabs.prototype.setHeight=function(_69){
this.setAttribute("height",_69);
};
nitobi.tabstrip.Tabs.prototype.getOverlap=function(){
return this.getIntAttribute("overlap");
};
nitobi.tabstrip.Tabs.prototype.setOverlap=function(_6a){
this.setIntAttribute("overlap",_6a);
};
nitobi.tabstrip.Tabs.prototype.remove=function(_6b){
if(_6b==null){
nitobi.lang.throwError(nitobi.error.BadArg);
}
var i;
if(typeof (_6b)!="number"){
i=this.indexOf(_6b);
}else{
i=_6b;
}
if(i==-1){
nitobi.lang.throwError(nitobi.error.BadArg+" The tab could not be found.");
}
var tab=this.get(i);
var _6e=this.getActiveTabIndex();
if(this.getLength()==1){
_6e=-1;
}else{
if(_6e>i){
_6e--;
}else{
if(_6e==i){
if(!(_6e==0&&i==0)){
_6e--;
}
}
}
}
this.setActiveTabIndex(_6e);
tab.destroyHtml();
nitobi.tabstrip.Tabs.base.remove.call(this,_6b);
};
nitobi.tabstrip.Tabs.prototype.handleBeforeEventNotify=function(_6f){
var _70=_6f.htmlEvent;
var _71=nitobi.ui.Element.parseId(_6f.targetId);
if(_70.type=="click"){
var tab=this.getById(_71.id);
if(null==tab){
return false;
}else{
return tab.isEnabled();
}
}
};
nitobi.tabstrip.Tabs.prototype.handleEventNotify=function(_73){
var _74=_73.htmlEvent;
var _75=nitobi.ui.Element.parseId(_73.targetId);
switch(_74.type){
case "click":
try{
if(_75.localName!="scrollleft"&&_75.localName!="scrollright"){
var tab=this.getById(_75.id);
this.setActiveTab(tab);
}
}
catch(err){
nitobi.lang.throwError("The Tabs object encountered an error handling the click event.",err);
}
break;
case "mousedown":
var _77;
switch(_75.localName){
case "scrollleft":
this.scrollLeft();
_77=nitobi.lang.close(this,this.scrollLeft,[]);
break;
case "scrollright":
this.scrollRight();
_77=nitobi.lang.close(this,this.scrollRight,[]);
break;
}
this.stopScrolling();
this.scrollerEventId=window.setInterval(_77,100);
nitobi.html.attachEvent(document.body,"mouseup",this.stopScrolling,this);
break;
case "mouseup":
this.stopScrolling();
break;
}
};
nitobi.tabstrip.Tabs.prototype.stopScrolling=function(){
window.clearInterval(this.scrollerEventId);
};
nitobi.lang.defineNs("nitobi.ui");
nitobi.tabstrip.TabChangeEventArgs=function(_78,_79,_7a,_7b,tab){
nitobi.tabstrip.TabChangeEventArgs.baseConstructor.apply(this,arguments);
this.activeTab=_7b||null;
this.tab=tab||null;
};
nitobi.lang.extend(nitobi.tabstrip.TabChangeEventArgs,nitobi.ui.ElementEventArgs);
nitobi.lang.defineNs("nitobi.tabstrip.error");
nitobi.tabstrip.error.TabActiveTabErr="The active tab could not be set.";

var temp_ntb_tabstripProc='<?xml version=\'1.0\'?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" /> <x:p-x:n-apply-id"x:s-\'\'"></x:p-> <x:p-x:n-apply-template"x:s-\'\'"></x:p-><x:t- match="/"> <x:c-> <x:wh- test="$apply-template = \'tabs\'"> <x:at-x:s-//ntb:tabs"/> </x:wh-> <x:wh- test="$apply-template = \'body\'"> <x:ct-x:n-body"><x:w-x:n-tab-position"><x:v-x:s-$apply-id"/></x:w-></x:ct-> </x:wh-> <x:o-> <x:at-x:s-//ntb:tabstrips/ntb:tabstrip|//ntb:tabstrip"/> </x:o-> </x:c-></x:t-><x:t-x:n-write-id"> <x:p-x:n-local-name"/> <x:p-x:n-id"/> <x:va-x:n-_id"> <x:c-> <x:wh- test="$id"> <x:v-x:s-$id"/> </x:wh-> <x:o-> <x:v-x:s-@id"/> </x:o-> </x:c-> </x:va-> <x:a-x:n-id"><x:v-x:s-$_id"/><xsl:if test="$local-name!=\'\'">.<x:v-x:s-$local-name"/></xsl:if></x:a-></x:t-><x:t-x:n-notify"> <x:p-x:n-id"/> <x:p-x:n-cancel-bubble"x:s-\'true\'" /> <x:p-x:n-local-name"/> <x:va-x:n-_id"> <x:c-> <x:wh- test="$id"> <x:v-x:s-$id"/> </x:wh-> <x:o-> <x:v-x:s-@id"/> </x:o-> </x:c-> </x:va-> <x:va-x:n-_local-name"> <x:c-> <x:wh- test="$local-name"> <x:v-x:s-concat(\'.\',$local-name)"/> </x:wh-> <x:o-></x:o-> </x:c-> </x:va-> try { nitobi.TabStrip.handleEvent(\'<x:v-x:s-//ntb:tabstrip/@id"/>\',event, \'<x:v-x:s-concat($_id,$_local-name)"/>\', <x:v-x:s-$cancel-bubble" />); } catch(err) { nitobi.error.onError.notify(new nitobi.error.ErrorEventArgs(this,err + \'[\' +<x:v-x:s-//ntb:tabstrip/@id"/> + \']\' ,nitobi.tabstrip.TabStrip.profile.className)); } </x:t-><x:t- match="ntb:tabstrip"> <div> <x:a-x:n-class"> ntb-tabstrip-reset <x:c-> <x:wh- test="./@cssclass"> <x:v-x:s-./@cssclass"/> </x:wh-> <x:wh- test="./@theme"> <x:v-x:s-./@theme"/> </x:wh-> <x:o-> nitobi </x:o-> </x:c-> </x:a-> <x:a-x:n-id"><x:v-x:s-./@id"/></x:a-> <x:a-x:n-style"> overflow:hidden; width:<x:v-x:s-@width"/>; height:<x:v-x:s-@height"/>; <x:v-x:s-./@cssstyle"/> </x:a-> <x:a-x:n-onclick"> <x:ct-x:n-notify"> <x:w-x:n-cancel-bubble"x:s-\'false\'" /> </x:ct-> </x:a-> <x:a-x:n-onmouseover"> <x:ct-x:n-notify"> <x:w-x:n-cancel-bubble"x:s-\'false\'" /> </x:ct-> </x:a-> <x:a-x:n-onmouseout"> <x:ct-x:n-notify"> <x:w-x:n-cancel-bubble"x:s-\'false\'" /> </x:ct-> </x:a-> <table border="0" cellpadding="0" cellspacing="0"> <x:a-x:n-class"> ntb-tab-strip </x:a-> <x:ct-x:n-write-id"> <x:w-x:n-local-name">secondarycontainer</x:w-> </x:ct-> <tr class="ntb-tab-strip-max"><td class="ntb-tab-strip-max"> <table border="0" cellspacing="0" cellpadding="0" style="border-collapse: separate;" class="ntb-tab-mintable ntb-tab-strip-max"> <tr class="ntb-tab-mintable ntb-tab-tabs-row"> <td class="ntb-tab-mintable"> <x:a-x:n-class"> ntb-tab-container </x:a-> <x:a-x:n-style"> width:100%; <xsl:if test="ntb:tabs/@align=\'center\'"> text-align: center; </xsl:if> </x:a-> <x:at-x:s-ntb:tabs"/> </td> </tr> <tr class="ntb-tab-bodies-row ntb-tab-mintable"> <td> <x:a-x:n-class"> ntb-tab-strip-body-container </x:a-> <x:ct-x:n-write-id"> <x:w-x:n-local-name">tabbodiescontainer</x:w-> </x:ct-> <div style="height:100%;overflow:hidden;"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">tabbodiesdivcontainer</x:w-> </x:ct-> <xsl:for-eachx:s-./ntb:tabs/ntb:tab"> <x:c-> <x:wh- test="child::body"> <x:at-x:s-./body"/> </x:wh-> <x:o-> <x:ct-x:n-body"> <x:w-x:n-tab-position"><x:v-x:s-position()"/></x:w-> </x:ct-> </x:o-> </x:c-> </xsl:for-each> </div> </td> </tr></table> </td></tr></table> </div></x:t-> <x:t- match="ntb:tabs"> <x:va-x:n-percent-exists"> <xsl:for-eachx:s-./child::ntb:tab"> <xsl:if test="contains(./@width,\'%\')"> true </xsl:if> </xsl:for-each> </x:va-> <table> <x:a-x:n-onclick"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onmouseover"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onmouseout"> <x:ct-x:n-notify"/> </x:a-> <x:ct-x:n-write-id"/> <x:a-x:n-style"> table-layout:fixed;border-collapse:collapse;padding:0px;margin:0px;width:100%; <xsl:if test="@align=\'center\'"> margin-left: auto;margin-right: auto;text-align: left; </xsl:if> <x:c-> <x:wh- test="@align=\'center\'"> </x:wh-> <x:wh- test="@align=\'left\' or @align=\'right\'"> float:<x:v-x:s-@align"/> </x:wh-> </x:c->; </x:a-> <tr><td style="margin:0px;padding:0px;"> <div style="overflow:hidden;width:100%;position:relative;"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">container</x:w-> </x:ct-> <table> <x:a-x:n-class"> ntb-tab-tabs </x:a-> <x:a-x:n-style"> border:white-space:nowrap;table-layout:fixed;border-collapse:collapse;padding:0px;margin:0px; <x:c-> <x:wh- test="$percent-exists!=\'\'"> width:<x:v-x:s-../@width"/>; </x:wh-> <x:o-> width:100%; </x:o-> </x:c-> <xsl:if test="@align=\'center\'"> margin-left: auto;margin-right: auto;text-align: left; </xsl:if> <x:c-> <x:wh- test="@align=\'center\'"> </x:wh-> <x:wh- test="@align=\'left\' or @align=\'right\'"> float:<x:v-x:s-@align"/> </x:wh-> </x:c->; </x:a-> <tr valign="bottom" style="padding:0px;margin:0px;"> <xsl:if test="@align=\'center\' or @align=\'right\' or not(@align)"> <td class="ntb-tab-before-tabs"></td> </xsl:if> <x:at-x:s-ntb:tab"/> <xsl:if test="@align=\'center\' or @align=\'left\' or not(@align)"> <td class="ntb-tab-after-tabs"></td> </xsl:if> </tr> </table> </div> </td> <td class="ntb-tab-scrollerbuttoncontainer"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">scrollerbuttoncontainer</x:w-> </x:ct-> <div style="position: relative; height: 28px;"> <input class="ntb-tab-scrollerbutton ntb-tab-scrollerbutton-right" type="button"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">scrollright</x:w-> </x:ct-> <x:a-x:n-onmousedown"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollright</x:w-> </x:ct-> </x:a-> <x:a-x:n-onmouseup"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollright</x:w-> </x:ct-> </x:a-> <x:a-x:n-onclick"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollright</x:w-> </x:ct-> </x:a-> </input> <input class="ntb-tab-scrollerbutton ntb-tab-scrollerbutton-left" type="button" > <x:ct-x:n-write-id"> <x:w-x:n-local-name">scrollleft</x:w-> </x:ct-> <x:a-x:n-onmousedown"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollleft</x:w-> </x:ct-> </x:a-> <x:a-x:n-onmouseup"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollleft</x:w-> </x:ct-> </x:a-> <x:a-x:n-onclick"> <x:ct-x:n-notify"> <x:w-x:n-local-name">scrollleft</x:w-> </x:ct-> </x:a-> </input> </div> </td> </tr></table></x:t-><x:t- match="ntb:tab"> <x:va-x:n-active-tab-index"> <x:c-> <x:wh- test="../@activetabindex"> <x:v-x:s-../@activetabindex"/> </x:wh-> <x:o-> <x:v-x:s-0"/> </x:o-> </x:c-> </x:va-> <td> <x:a-x:n-onclick"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onmouseover"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onmouseout"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onfocus"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onblur"> <x:ct-x:n-notify"/> </x:a-> <x:ct-x:n-write-id"/> <x:a-x:n-label-index"> <x:v-x:s-position()"/> </x:a-> <x:a-x:n-title"> <x:v-x:s-tooltip|@tooltip"/> </x:a-> <x:a-x:n-style">padding:0px;margin:0px; <x:c-> <x:wh- test="@width"> width:<x:v-x:s-@width"/> </x:wh-> <x:o-> </x:o-> </x:c->; <x:c-> <x:wh- test="../@height"> height:<x:v-x:s-../@height"/> </x:wh-> <x:o-> </x:o-> </x:c->; </x:a-> <div> <xsl:if test="@cssclass"> <x:a-x:n-class"> <x:v-x:s-./@cssclass"/> </x:a-> </xsl:if> <x:ct-x:n-write-id"> <x:w-x:n-local-name">customcss</x:w-> </x:ct-> <div> <x:a-x:n-class"> <x:c-> <x:wh- test="position()-1 = $active-tab-index and @enabled!=\'false\'">ntb-tab-active</x:wh-> <x:wh- test="@enabled=\'false\'">ntb-tab-disabled</x:wh-> <x:wh- test="position()-1 = $active-tab-index">ntb-tab-active</x:wh-> <x:o->ntb-tab-inactive</x:o-> </x:c-> </x:a-> <x:ct-x:n-write-id"> <x:w-x:n-local-name">activetabclassdiv</x:w-> </x:ct-> <div> <x:a-x:n-onmouseover"> this.prevClassName = this.className; this.className = this.className+\' ntb-tab-mouseover\'; </x:a-> <x:a-x:n-onmouseout"> this.className = this.prevClassName; </x:a-> <table> <x:a-x:n-class"> ntb-tab-table </x:a-> <x:va-x:n-overlap"> <x:c- > <x:wh- test="ancestor::ntb:tabs[1]/@overlap"> <x:v-x:s-number(ancestor::ntb:tabs[1]/@overlap)"/> </x:wh-> <x:o-> <x:v-x:s-number(1)"/> </x:o-> </x:c-> </x:va-> <x:a-x:n-style"> ;left:<x:v-x:s-(position()-1) * (-1 * number($overlap))"/>px; </x:a-> <tr style="white-space:nowrap;overflow:visible;padding:0px;margin:0px;"> <td> <x:a-x:n-class"> ntb-tab ntb-tab-left </x:a-> <div class="ntb-pulse"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">leftpulse</x:w-> </x:ct-> </div> </td> <td> <x:a-x:n-class"> ntb-tab ntb-tab-body </x:a-> <div class="ntb-pulse" style="position:absolute;width:100%;height:30px;"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">bodypulse</x:w-> </x:ct-><xsl:comment>not sure why this is here - empty xsl:comment seems to break safari</xsl:comment> </div> <table> <x:a-x:n-class"> ntb-tab ntb-tab-label </x:a-> <x:ct-x:n-write-id"> <x:w-x:n-local-name">labeltable</x:w-> </x:ct-> <tr> <td class="ntb-tab-icon-active"> <xsl:if test="not(@icon)"> <x:a-x:n-style"> width: 1px; </x:a-> </xsl:if> <img> <x:ct-x:n-write-id"> <x:w-x:n-local-name">icon</x:w-> </x:ct-> <x:c-> <x:wh- test="@icon"> <x:a-x:n-src"><x:v-x:s-@icon"/></x:a-> </x:wh-> <x:o-> <x:a-x:n-style">display:none</x:a-> </x:o-> </x:c-> </img> </td> <td style="white-space:nowrap;width:*"> <a href="javascript:void(0)"> <x:a-x:n-onfocus"> <x:ct-x:n-notify"/> </x:a-> <x:a-x:n-onblur"> <x:ct-x:n-notify"/> </x:a-> <xsl:if test="//ntb:tabstrip/@tabindex"> <x:va-x:n-tindex"x:s-//ntb:tabstrip/@tabindex"/> <x:a-x:n-tabindex"> <x:v-x:s-number($tindex) + position() - 1"/> </x:a-> </xsl:if><x:ct-x:n-write-id"><x:w-x:n-local-name">label</x:w-></x:ct-> <x:v-x:s-@label"/><x:at-x:s-label|@label"/></a> </td> <td> <x:a-x:n-style"> <xsl:if test="not(@containertype=\'iframe\')"> display:none; </xsl:if> </x:a-> <x:ct-x:n-write-id"> <x:w-x:n-local-name">activityindicator</x:w-> </x:ct-> <x:a-x:n-class"> ntb-tab-activityindicator </x:a-> </td></tr> </table> </td> <td> <x:a-x:n-class"> ntb-tab ntb-tab-right </x:a-> <div class="ntb-pulse"> <x:ct-x:n-write-id"> <x:w-x:n-local-name">rightpulse</x:w-> </x:ct-> </div> </td> </tr> </table> </div> </div> </div> </td></x:t-><x:t- match="label|@label"> <span type="tabspan"> <x:ct-x:n-write-id"/> <x:at-x:s-@* | node()"/> </span></x:t-> <x:t-x:n-body"> <x:p-x:n-tab-position"/> <x:va-x:n-dot"x:s-//ntb:tabs/ntb:tab[number($tab-position)]"/> <x:va-x:n-active-tab-index"> <x:c-> <x:wh- test="$dot/../@activetabindex"> <x:v-x:s-$dot/../@activetabindex"/> </x:wh-> <x:o-> <x:v-x:s-0"/> </x:o-> </x:c-> </x:va-> <div> <x:ct-x:n-write-id"> <x:w-x:n-id"><x:v-x:s-$dot/@id"/></x:w-> <x:w-x:n-local-name">tabbody</x:w-> </x:ct-> <x:a-x:n-style"> overflow:auto; <x:c-> <x:wh- test="number($tab-position) -1 != $active-tab-index"> width:0px;height:0px;position:relative;top:-1000px;left:-1000px; </x:wh-> <x:o-> width:100%;height:100%; </x:o-> </x:c-> <xsl:if test="$dot/@hideoverflowenabled=\'true\'"> overflow:hidden; </xsl:if> </x:a-> <x:a-x:n-class"> <x:c-> <x:wh- test="number($tab-position) -1 = $active-tab-index"> ntb-tab-active </x:wh-> <x:o-> ntb-tab-inactive </x:o-> </x:c-> </x:a-> <div style="height:100%;"> <x:ct-x:n-write-id"> <x:w-x:n-id"><x:v-x:s-$dot/@id"/></x:w-> <x:w-x:n-local-name">bodycontainer</x:w-> </x:ct-> <x:c-> <x:wh- test="$dot/@source and $dot/@containertype=\'iframe\'"> <iframe class="ntb-tab-iframecontainer" frameborder="0"> <x:a-x:n-name">ntb-tab-<x:v-x:s-//ntb:tabstrip/@id" />-<x:v-x:s-$tab-position" /></x:a-> <x:ct-x:n-write-id"> <x:w-x:n-id"><x:v-x:s-$dot/@id"/></x:w-> <x:w-x:n-local-name">tabiframe</x:w-> </x:ct-> <x:a-x:n-onload"> <x:ct-x:n-notify"> <x:w-x:n-id"><x:v-x:s-$dot/@id"/></x:w-> </x:ct-> </x:a-> <x:a-x:n-src"> </x:a->&#160; </iframe> </x:wh-> <x:o-> <div class="ntb-tab-bodycontainer"> <x:ct-x:n-write-id"> <x:w-x:n-id"><x:v-x:s-$dot/@id"/></x:w-> <x:w-x:n-local-name">tabnodeframe</x:w-> </x:ct-> <x:at-x:s-$dot/@* | $dot/node()"/> </div> </x:o-> </x:c-> </div> </div> </x:t-><x:t- match="body"> <x:ct-x:n-body"/></x:t-> <x:t- match="node()|@*"> <x:p-x:n-this"/> <xsl:if test="name(.)!=\'id\'"> <xsl:copy> <x:at-x:s-./* | text() | @*"> <x:w-x:n-this"x:s-$this"/> </x:at-> </xsl:copy> </xsl:if></x:t-> <x:t- match="text()"> <x:v-x:s-."/></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.tabstrip");
nitobi.tabstrip.tabstripProc = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_tabstripProc));
