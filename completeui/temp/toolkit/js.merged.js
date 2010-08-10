/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
if (typeof(nitobi) == "undefined")
{
	/**
	 * @namespace The nitobi namespace is the root namespace for all Nitobi components and libraries.
	 * It should not be instantiated and is meant only to function as a namespace.
	 * @constructor 
	 * @private
	 */
	nitobi = function(){};
}

if (false)
{
	/**
	 * @namespace This namespace hosts methods that could be considered language extensions.  
	 * Most importantly one can find the {@link nitobi.lang#extend} and {@link nitobi.lang#implement}
	 * methods in this namespace.
	 * @constructor
	 */
	nitobi.lang = function(){};
}

if (typeof(nitobi.lang) == "undefined")
{
	/**
	 * @ignore
	 */
	nitobi.lang = {};
}

/**
 * If the given namespace does not exist, create an empty object with that name.
 * @param {String} namespace the namespace to define
 */
nitobi.lang.defineNs = function(namespace)
{
	var names = namespace.split(".");
	var currentNamespace ="";
	var dot="";
	for (var i=0; i < names.length; i++)
	{
		currentNamespace += dot + names[i];
		dot=".";
		if (eval("typeof("+currentNamespace+")") == "undefined")
		{
			eval(currentNamespace + "={}");
		}
	}
}

/**
 * Extends the <code>subClass</code> with the functionality included in the <code>baseClass</code>. 
 * This function should be called immediately after the subClass constructor is defined.
 * <pre class="code">
 * example.Cat = &#102;unction() {}
 * example.Cat.prototype.run = function() {}
 * 
 * example.Lion = &#102;unction() {
 *   example.Lion.baseConstructor.call(this);
 * }
 * 
 * nitobi.lang.extend(example.Lion, example.Cat);
 * </pre>
 * @param subClass {Object} The class that will inherit from the base.
 * @param baseClass {Object} The class that will be inherited from.
 */
nitobi.lang.extend = function(subClass, baseClass) {
   function inheritance() {};
   inheritance.prototype = baseClass.prototype;

   subClass.prototype = new inheritance();
   subClass.prototype.constructor = subClass;
   subClass.baseConstructor = baseClass;
   if (baseClass.base)
   {
	   baseClass.prototype.base = baseClass.base;
   }
   subClass.base = baseClass.prototype;
}

/**
 * Copies all functions from the interface to the class - commonly referred to as a mixin. 
 * This is very similar to <code>extend</code>. 
 * @example
 * example.Cat = &#102;unction() {}
 * example.Cat.prototype.run = function() {}
 * 
 * example.Lion = &#102;unction() {
 *   example.Lion.baseConstructor.call(this);
 * }
 * 
 * nitobi.lang.implement(example.Lion, example.Cat);
 * @param {Function} class_ the class to copy functions onto
 * @param {Function} interface_ the interface to copy from
 * @see #extend
 */
nitobi.lang.implement = function(class_, interface_)
{
	for (var member in interface_.prototype)
	{
		if (typeof(class_.prototype[member]) == "undefined" || class_.prototype[member] == null)
		{
			class_.prototype[member] = interface_.prototype[member];
		}
	}
}

// TODO: support dates and numbers
/**
 * Takes a prototype and creates getters/setters for the provided array of JS properties defined
 * as {n:"PropName",t:"s"} where n is the property name and t is the property type which can be "(s)tring", 
 * "(b)oolean" or "(i)nteger".
 * @private
 */
nitobi.lang.setJsProps = function(p, props) {
	for (var i=0; i<props.length; i++) {
		var prop = props[i];
		// create the getter/setter
		p["set"+prop.n] = this.jSET;
		p["get"+prop.n] = this.jGET;
		// set the default value
		p[prop.n] = prop.d;
	}
}

// TODO: support dates and numbers
/**
 * Takes a prototype and creates getters/setters for the provided array of XML properties defined
 * as {n:"PropName",t:"s"} where n is the property name and t is the property type which can be "(s)tring", 
 * "(b)oolean" or "(i)nteger".
 * @private
 */
nitobi.lang.setXmlProps = function(p, props) {
	for (var i=0; i<props.length; i++) {
		var prop = props[i];
		// create the getter/setter
		var s,g;
		switch (prop.t) {
			case "i": // integer types
				s=this.xSET; // no need to do any custom convert from int to string
				g=this.xiGET;
				break;
			case "b": // boolean
				s=this.xbSET;
				g=this.xbGET;
				break;
			default:
				s=this.xSET;
				g=this.xGET;
		}
		p["set"+prop.n] = s;
		p["get"+prop.n] = g;
		// set the default value
		p["sModel"] += prop.n+"\""+prop.d+"\" ";
	}
}

/**
 * Takes a prototype and creates getters/setters for the provided array of event names defined
 * as "OnBeforeSaveEvent". Both the getter/setter for the event and an event object are created.
 * @private
 */
nitobi.lang.setEvents = function(p, events) {
	for (var i=0; i<events.length; i++) {
		var n = events[i];
		// this is all for backwards compat.
		p["set"+n] = this.eSET;
		p["get"+n] = this.eGET;
		var nn = n.substring(0,n.length-5);
		p["set"+nn] = this.eSET;
		p["get"+nn] = this.eGET;
		// TODO: could do this here or in the actual constructor ...
		p["o"+n.substring(1)] = new nitobi.base.Event();
	}
}


/**
 * Returns true if the member is defined and false otherwise. 
 * Use this only on members, eg, isDefined(this.foo) or 
 * isDefined(obj.foo) but never isDefined(foo).
 * @param {Object} a Any member.
 * @type Boolean
 */
nitobi.lang.isDefined = function(a)
{
	return (typeof(a) != "undefined");
}

/**
 * Casts a string value to a boolean.  Returns <code>true</code> if the input string is "true".
 * Otherwise, returns false.
 * @param {String} a the string-encoded boolean
 * @type Boolean
 */
nitobi.lang.getBool = function(a)
{	if (null == a) return null;
	if (typeof(a) == "boolean") return a;
	return a.toLowerCase() == "true";
}

/**
 * An enumeration of the different types that can be returned from {@link #typeOf}.
 * <code>nitobi.lang.type.XMLNODE</code>, <code>nitobi.lang.type.HTMLNODE</code>, 
 * <code>nitobi.lang.type.ARRAY</code>, and <code>nitobi.lang.type.XMLDOC</code> are the 
 * possible values.
 * @type Map
 */
nitobi.lang.type = {XMLNODE:0, HTMLNODE:1, ARRAY:2, XMLDOC:3};

/**
 * Returns the type of the input object as a member of the {@link nitobi.lang#type} enumeration.
 * @param {Object} obj the object to inspect
 * @type Number
 */
nitobi.lang.typeOf = function(obj) 
{
	var t=typeof(obj);
	if (t=="object")
	{	
		if (obj.blur && obj.innerHTML)
		{
			return nitobi.lang.type.HTMLNODE;
		}			
		if (obj.nodeName && obj.nodeName.toLowerCase() === "#document")
		{
			return nitobi.lang.type.XMLDOC;	
		}
		if (obj.nodeName){
			return nitobi.lang.type.XMLNODE;
		}
		if (obj instanceof Array)
		{
			return nitobi.lang.type.ARRAY;
		}
			
	}
	return t;
}

/**
 * @private
 */
nitobi.lang.toBool = function(boolStr,defaultval) 
{
	if (typeof(defaultval)!="undefined")
		if ((typeof(boolStr)=="undefined") || (boolStr=="") || (boolStr==null)) boolStr=defaultval;

	boolStr=boolStr.toString() || "";
	boolStr=boolStr.toUpperCase();

	if ( (boolStr=="Y") || (boolStr=="1") || (boolStr=="TRUE") ) return true;
	else return false;
}
/**
 * @private
 * @type String
 */
nitobi.lang.boolToStr = function (bool) 
{
	if ((typeof(bool) == "boolean" && bool) || (typeof(bool) == "string" && (bool.toLowerCase() == "true" || bool == "1"))) return "1"; else return "0";
	return bool;
}

/**
 * Formats the given number with the given mask.
 * @param {String} number The number to format as a string
 * @param {String} mask The mask to apply
 * @param {String} groupingSymbol The symbol used to group numbers, e.g "," as in "100,000"
 * @param {String} decimalSymbol The symbol used to separate the decimal, e.g "." as in "10.02"
 * @type String
 */
nitobi.lang.formatNumber = function(number, mask, groupingSymbol, decimalSymbol) {
	var n = nitobi.form.numberXslProc; 
	n.addParameter("number", number, "");
	n.addParameter("mask", mask, "");
	n.addParameter("group", groupingSymbol, "");
	n.addParameter("decimal", decimalSymbol, "");
	// TODO: put the number xsl into lang
    return nitobi.xml.transformToString(nitobi.xml.Empty, nitobi.form.numberXslProc);
}

/**
 * Creates a closure for a function and a context. Also supports the passing of arguments. As an alternative to 
 * defining inline anonymous functions that alias the <code>this</code> keyword one can use a closure. The conventional
 * approach to creating a closure is shown below:
 * <pre class="code">
 * example.Account.prototype.getBalance = &#102;unction() {
 *   var xhr = new nitobi.ajax.HttpRequest();
 *   var _this = this;
 *   xhr.onGetComplete.subscribe(&#102;unction(evtArgs) {
 *     _this.balance = evtArgs.response;
 *   });
 *   xhr.get("balance.do");
 * }
 * </pre>
 * An example of the same code using closures is shown below. This code is slightly more verbose yet easier to document and understand as well as 
 * being less prone to Internet Explorer memory leak patterns.
 * <pre class="code">
 * example.Account.prototype.getBalance = &#102;unction() {
 *   var xhr = new nitobi.ajax.HttpRequest();
 *   xhr.onGetComplete.subscribe(nitobi.lang.close(this, this.getBalanceComplete));
 *   xhr.get("balance.do");
 * }
 * example.Account.prototype.getBalanceComplete = &#102;unction(evtArgs) {
 *   this.balance = evtArgs.response;
 * }
 * </pre>
 * @param {Object} context The context for the function to be executed in.
 * @param {Function} func The function to be executed.
 * @param {Array} params An array of arugments that can be passed to the function.
 */
nitobi.lang.close = function(context, func, params)
{
	if (null == params)
	{
		return function()
		{
			return func.apply(context, arguments);
		}
	}
	else
	{
		return function()
		{
			return func.apply(context, params);
		}
	}
}

/**
 * Attachs a function to be called immediately after another method.
 * @param {Object} object1 The object that is the context of the method we are attaching the other method to.
 * @param {String} method1 The name of the method we are attaching the other method to.
 * @param {Object} object2 The object that is the context of the attached method.
 * @param {String} method2 The name of the method we are attaching.
 */
nitobi.lang.after = function(object1, method1, object2, method2)
{
	var srcMethod = object1[method1];
	var attachMethod = object2[method2];
	if(method2 instanceof Function)
		attachMethod = method2;
	object1[method1] = function()
	{
		srcMethod.apply(object1, arguments);
		attachMethod.apply(object2, arguments);
	}
	object1[method1].orig = srcMethod;
}

/**
 * Attachs a function to be called immediately before another method.
 * @param {Object} object1 The object that is the context of the method we are attaching the other method to.
 * @param {String} method1 The name of the method we are attaching the other method to.
 * @param {Object} object2 The object that is the context of the attached method.
 * @param {String|Function} method2 The name of the method we are attaching.
 */
nitobi.lang.before = function(object1, method1, object2, method2)
{
	var srcMethod = object1[method1];
	var attachMethod = function() {};
	if (object2 != null)
		// Set the "before" method to the method that is passed in
		attachMethod = object2[method2];
	if(method2 instanceof Function)
		attachMethod = method2;
	object1[method1] = function()
	{
		attachMethod.apply(object2, arguments);
		srcMethod.apply(object1, arguments);
	}
	object1[method1].orig = srcMethod;
}

/**
 * For each item in the provided array calls the provided function with the array item and the index
 * as the two arguments to the function.
 * @param {Array} arr The array of objects.
 * @param {Function} func The function to be called for each item in the array.
 */
nitobi.lang.forEach = function(arr, func)
{
	var len = arr.length;
	for (var i=0; i<len; i++)
	{
		func.call(this, arr[i], i);
	}
	func = null;
}

/**
 * Throw an error with an optional Javascript exception.
 * @param {String} description a human-readable description of the error
 * @param {Exception|String} [excep] the exception that has caused this error
 */
nitobi.lang.throwError = function(description, excep)
{
	var msg = description;
	if (excep != null)
	{
		msg += "\n - because " + nitobi.lang.getErrorDescription(excep);
	} 
	throw msg;
}
/**
 * @ignore
 */
nitobi.lang.getErrorDescription = function(excep)
{
	var result =
        (typeof(excep.description) == 'undefined') ?
        excep :
        excep.description;
	return result;
}

/**
 * Returns a new obejct 
 * @param {int} ignoreNLeft Ignore the first n arguments.
 * @private
 */
nitobi.lang.newObject = function(className,args,ignoreNLeft)
{
	var a = args;
	if (null == ignoreNLeft) ignoreNLeft = 0;
	var e = "new "+className+"(";
	var comma="";
	for (var i=ignoreNLeft;i<a.length;i++)
	{
		e+=comma + "a[" + i + "]";
		comma=",";
	}
	e+=")";
	return eval(e);
}


/**
 * Get the last n args starting from start
 * @private
 */
nitobi.lang.getLastFunctionArgs = function(args,start)
{
	var a = new Array(args.length-start);
	for (var i=start;i<args.length;i++)
	{
		a[i-start] = args[i];
	}
	return a;
}

/**
 * Return the first available key from a hash.
 * @param {Hash} hash The hash.
 * @type String
 * @private
 */
nitobi.lang.getFirstHashKey = function(hash)
{
	for (var x in hash)
	{
		return x;
	}
}

/**
 * Returns a struct containing the "name" of the first function in
 * obj and the "value" that is the function itself.
 * @param {Object} obj The obj whose function you want.
 * @type Object
 * @private
 */
nitobi.lang.getFirstFunction = function(obj)
{
	for (var x in obj)
	{
		if (obj[x] != null && typeof(obj[x]) == "function" && typeof(obj[x].prototype) != "undefined")
		{
			return {name:x, value: obj[x]};
		}
	}
	return null;
}

/**
 * Returns a shallow copy of an object - this is useful for the event object in IE.
 * @param {Object} obj The object to copy.
 * @type Object
 */
nitobi.lang.copy = function(obj)
{
	var newObj = {};
	for (var item in obj)
		newObj[item] = obj[item];
	return newObj;
}

/**
 * Used by our javascript destructors.
 * @private
 */
nitobi.lang.dispose = function(context, disposal)
{
	try
	{
		if (disposal != null) {
			var disposalLength = disposal.length;
			for (var i=0; i<disposalLength; i++)
			{
				// ?
				if (typeof(disposal[i].dispose) == "function")
					disposal[i].dispose();	
				if (typeof(disposal[i]) == "function")
					disposal[i].call(context);
				disposal[i] = null;
			}
		}

		// Loop through every item in the object.
		for (var item in context)
		{
			if (context[item] != null && context[item].dispose instanceof Function)
				context[item].dispose();
			context[item] = null;
		}
	}
	catch(e)
	{
	}
}

/**
 * Returns a number from a value, and never returns NaN.  Returns 0 if the number
 * can't be parsed.
 * @param {String} val A value that may or may not be a number.
 * @type Number
 */
nitobi.lang.parseNumber = function(val)
{
	var num = parseInt(val);
	return (isNaN(num) ? 0 : num);
}

/**
 * Returns the base-26 style character string for the given number.  This will be valid up from 'a' to 'zz' or (26^2-1)
 * @param {Number} num the number to use in the conversion
 * @type String
 * @private
 */
nitobi.lang.numToAlpha = function(num)
{
	if (typeof(nitobi.lang.numAlphaCache[num]) === 'string')
	{
		return nitobi.lang.numAlphaCache[num];
	}
	var ck1 = num % 26;
	var ck2 = Math.floor(num / 26);
	var alpha = (ck2>0?String.fromCharCode(96+ck2):"")+String.fromCharCode(97+ck1);
	nitobi.lang.alphaNumCache[alpha] = num;
	nitobi.lang.numAlphaCache[num] = alpha;
	return alpha;
};

/**
 * Returns the numeric value (base-10) for the given base-26 style character string.
 * @param {String} alpha the base-26 character string ('a'-'zz')
 * @type Number
 * @private
 */
nitobi.lang.alphaToNum = function(alpha)
{
	if (typeof(nitobi.lang.alphaNumCache[alpha]) === 'number')
	{
		return nitobi.lang.alphaNumCache[alpha];
	}
	var j = 0;
	var num = 0;
	for (var i = alpha.length-1; i >= 0; i--)
	{
		num += (alpha.charCodeAt(i)-96) * Math.pow(26,j++);
	}
	num = num-1;
	nitobi.lang.alphaNumCache[alpha] = num;
	nitobi.lang.numAlphaCache[num] = alpha;
	return num;
};

/**
 * @ignore
 * @private
 */
nitobi.lang.alphaNumCache = {};
/**
 * @ignore
 * @private
 */
nitobi.lang.numAlphaCache = {};

/**
 * Makes the input obj an array.  This will work for many objects that are 'close' to the 
 * standard javascript array, like the <CODE>arguments</CODE> variable. Your original object 
 * will be lost.
 * @param {Obect} obj an Array-like object.
 * @param {Number} ignoreFirst when this is set to <code>n</code>, the returned array will 
 * not contain the first <code>n</code> elements in <code>obj</code>.
 * @type Array 
 */
nitobi.lang.toArray = function(obj, ignoreFirst)
{
	return Array.prototype.splice.call(obj,ignoreFirst || 0);
};

/**
 * Merges two or more <CODE>Map</CODE>s.  Any arguments after <code>obj2</code> will be treated as
 * additional Maps to merge.
 * @param {Map} obj1 the base object
 * @param {Map} obj2 the second object, if <code>obj2</code> has a field in common with 
 * <code>obj1</code>, the value in <code>obj2</code> will be used.
 * @type Map
 */	
nitobi.lang.merge = function(obj1,obj2)
{
	var r = {};
	for (var i = 0; i < arguments.length; i++)
	{
		var a = arguments[i];
		for (var x in arguments[i])
		{
			r[x] = a[x];
		}
	}
	return r;
};

/**
 * Performs a logical XOR on its arguments.  XOR returns true if and only if
 * exactly one argument is true.
 * @type Boolean
 * @private
 */

nitobi.lang.xor = function()
{
    var b = false;
    for( var j = 0; j <arguments.length; j++ )
    {
        if( arguments[ j ] && !b ) b = true;
        else if( arguments[ j ] && b ) return false;
    }
    return b;
};

/**
 * @ignore
 * @private
 */
nitobi.lang.zeros = "00000000000000000000000000000000000000000000000000000000000000000000";
/**
 * adds padding zeroes
 * @private
 */
nitobi.lang.padZeros = function(num, places)
{
	places = places || 2;
	num = num + "";
	return nitobi.lang.zeros.substr(0,Math.max(places - num.length,0)) + num;
}; 

/**
 * An empty function.  This function will do nothing if called.  It can be used as a callback
 * when no callback is desired.
 * @private
 */
nitobi.lang.noop = function(){};

nitobi.lang.isStandards = function() {
	var s = (document.compatMode == "CSS1Compat")
	if (nitobi.browser.SAFARI||nitobi.browser.CHROME)
	{
        var elem = document.createElement('div');
        elem.style.cssText = "width:0px;width:1";
        s = (parseInt(elem.style.width) != 1); 
	}
	return s;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */

nitobi.lang.defineNs("nitobi.lang");

/**
 * @constructor
 * @class
 * @private
 */
nitobi.lang.Math = function() {};

/**
 * @private
 */
nitobi.lang.Math.sinTable = Array();

/**
 * @private
 */
nitobi.lang.Math.cosTable = Array();

/**
 * Rotates some coordinates centered around 0,0 in euler space
 * provide x,y coords and a rotation in degrees (will convert to rad)
 * @private
 */
nitobi.lang.Math.rotateCoords = function(oldx,oldy,rotation)
{
	
	//(3.1415927/180) = 0.01745329277777778
	var RotationRads = rotation*0.01745329277777778;
	if (nitobi.lang.Math.sinTable[RotationRads] == null ) {
		nitobi.lang.Math.sinTable[RotationRads] = Math.sin(RotationRads);
		nitobi.lang.Math.cosTable[RotationRads] = Math.cos(RotationRads);
	}
	var cR = nitobi.lang.Math.cosTable[RotationRads];
	var sR = nitobi.lang.Math.sinTable[RotationRads];
	var x = oldx*cR - oldy*sR;
	var y = oldy*cR + oldx*sR;	
	return {x : x, y : y};
}

/**
 * Returns a calculated angle between two vertices
 * Value is in degrees
 * @private
 */
nitobi.lang.Math.returnAngle = function(oldx,oldy,newx,newy)
{
	// (3.1415927/180) = 0.01745329277777778
	return Math.atan2(newy-oldy,newx-oldx)/0.01745329277777778;
}

/**
 * Returns a calculated distance between two vertices
 * Value is in pixels
 * @private
 */
nitobi.lang.Math.returnDistance = function(x1,y1,x2,y2)
{
	return Math.sqrt(((x2-x1)*(x2-x1))+((y2-y1)*(y2-y1)));
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/*NITOBI_VERSION*/
/*NITOBI_BUILD_NUMBER*/
/*NITOBI_LICENSE*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**************************************************************************/
/*					nitobi.Object	     	      
/**************************************************************************/
nitobi.lang.defineNs("nitobi");

/**
 * Creates a <code>nitobi.Object</code>.
 * @class The class from which all other nitobi classes derive.
 * @constructor
 */
nitobi.Object = function() 
{
	/**
	 * A collection of objects that are destroyed when the object is unloaded.
	 * @private
	 * @type Array
	 */
	this.disposal= new Array();

	/**
	 * A hash of cached XML nodes in the object model representation.
	 * @private
	 */
	this.modelNodes = {};
}

/**
 * Sets the internal values of the object based on a configuration object.
 * The values are set with the following precedence:
 *  - if there is a property with the same name it will be set.
 *  - if there is a method with the same name it will be called with the value from the configuration object as the single argument.
 *  - if there is a setter (setPropertyName) it will be called with the value from the configuration object as the single argument.
 *  - otherwise it will just set the property.
 * @private
 * @param {Object} values An object containing the values to be set.
 */
nitobi.Object.prototype.setValues = function(values)
{
	// Sets values on the object using a struct
	for (var item in values)
	{
		if (this[item] != null)
		{
			if (this[item].subscribe != null)
			{
			}
			else
			{
				this[item] = values[item];
			}
		}
		else if (this[item] instanceof Function)
			this[item](values[item]);
		else if (this['set'+item] instanceof Function)
			this['set'+item](values[item]);
		else
			this[item] = values[item];
	}
}

/**
 * @private
 */
nitobi.Object.prototype.xGET= function(){
	var node = null, xpath = "@"+arguments[0], val = "";
	var cachedNode = this.modelNodes[xpath];
	if (cachedNode != null)
		node = cachedNode;
	else
		node = this.modelNodes[xpath] = this.modelNode.selectSingleNode(xpath);

	if (node!=null)
		val = node.nodeValue;

	return val;
}

/**
 * @private
 */
nitobi.Object.prototype.xSET= function(){
	var node = null, xpath = "@"+arguments[0];
	var cachedNode = this.modelNodes[xpath];
	if (cachedNode != null)
		node = cachedNode;
	else 
		node = this.modelNodes[xpath] = this.modelNode.selectSingleNode(xpath);
	if (node == null) 	// Create the attribute
		this.modelNode.setAttribute(arguments[0], "");
	if (arguments[1][0] != null && node != null)
	{
		// TODO: REMOVE THIS CAUSE IT IS DONE IN XBSET
		if (typeof(arguments[1][0]) == "boolean")
			node.nodeValue=nitobi.lang.boolToStr(arguments[1][0]);
		else
			node.nodeValue=arguments[1][0];
	}
}

/**
 * @private
 */
nitobi.Object.prototype.eSET=function(name, args)
{
	var oFunction = args[0];
	var funcRef = oFunction;

	var subName = name.substr(2);
	subName = subName.substr(0,subName.length-5);

	if (typeof(oFunction) == 'string')
	{
		funcRef = function() {return nitobi.event.evaluate(oFunction,arguments[0])};
	}
	if (this[name] != null)
	{
		this.unsubscribe(subName, this[name]);
	}

	// name should be OnCellClickEvent but we just expect CellClick for firing
	var guid = this.subscribe(subName,funcRef);
	this.jSET(name, [guid]);
	return guid;
}

/**
 * @private
 */
nitobi.Object.prototype.eGET=function()
{
	// TODO: implement something here... will be useful once we have objects for events
}

/**
 * @private
 */
nitobi.Object.prototype.jSET= function(name, val)
{
	this[name] = val[0];
}

/**
 * @private
 */
nitobi.Object.prototype.jGET= function(name)
{
	return this[name];
}

/**
 * @private
 */
nitobi.Object.prototype.xsGET=nitobi.Object.prototype.xGET;

/**
 * @private
 */
nitobi.Object.prototype.xsSET=nitobi.Object.prototype.xSET;

/**
 * @private
 */
nitobi.Object.prototype.xbGET=function(){
	return nitobi.lang.toBool(this.xGET.apply(this, arguments), false);
}

/**
 * @private
 */
nitobi.Object.prototype.xiGET=function(){
	return parseInt(this.xGET.apply(this, arguments));
}

/**
 * @private
 */
nitobi.Object.prototype.xiSET=nitobi.Object.prototype.xSET;

/**
 * @private
 */
nitobi.Object.prototype.xdGET=function(){
}

/**
 * @private
 */
nitobi.Object.prototype.xnGET=function(){
	return parseFloat(this.xGET.apply(this, arguments));
}

/**
 * @private
 */
nitobi.Object.prototype.xbSET= function(){
	this.xSET.call(this, arguments[0], [nitobi.lang.boolToStr(arguments[1][0])]);
}

// TODO: Remove the subscribe and fire methods to IObservable which the grid implements.
/**
 * Manually fires the particular event.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="">
 * var grid = nitobi.getComponent('grid1');
 * grid.fire("CellClick"); // Note we supply "CellClick" for the OnCellClickEvent
 * </code></pre>
 * </div>
 * @param {String} evt The identifier for the evnt such as "HtmlReady".
 * @param {Object} args Any arguments to pass to the event handlers.
 * @private
 */
nitobi.Object.prototype.fire=function(evt,args){
	return nitobi.event.notify(evt+this.uid,args);
}

/**
 * Subscribes a function to a Grid event.
 * <p>
 * <b>Example</b>
 * </p>
 * <div class="code">
 * <pre><code class="">
 * var grid = nitobi.getComponent('grid1');
 * grid.subscribe("DataReady", myFunction);
 * </code></pre>
 * </div>
 * <p>
 * Notice that the event we are subscribing to does not specify the "On" 
 * or "Event" parts of the name.
 * </p>
 * @param {String} evt A event string identifier or key for the given 
 * event. This value is the event name without the "On" and "Event" parts 
 * of the name, for example, the key for the OnDataReadyEvent is becomes 
 * "DataReady".
 * @param {Function} func A reference to the Function object that should 
 * be called when the event is fired.
 * @param {Object} context A reference to the Object that the Function 
 * should be called in the context of. When writing object oriented 
 * JavaScript the reference to the Function must also have some context 
 * in which it is to be executed.
 * @see nitobi.grid.Grid#subscribeOnce
 * @see nitobi.grid.Grid#unsubscribe
 * @private
 */
nitobi.Object.prototype.subscribe=function(evt,func,context){
	if (this.subscribedEvents == null)
		this.subscribedEvents = {};
	if (typeof(context)=="undefined") context=this;
	var guid = nitobi.event.subscribe(evt+this.uid,nitobi.lang.close(context, func));
	this.subscribedEvents[guid] = evt+this.uid;
	return guid;
}

/**
 * Subscribe to an event only once.  That is, the handler is only fired 
 * once and then automatically unregistered.
 * <p>
 * <b>Example</b>:  Load the grid and subscribe to the OnHtmlReadyEvent
 * </p>
 * <div class="code">
 * <pre><code class="">
 * &#102;unction loadGrid()
 * {
 * 	var grid = nitobi.loadComponent('grid1');
 * 	grid.subscribeOnce("HtmlReady", handleHtmlEvent, null, new Array(grid));
 * }
 * 
 * &#102;unction handleHtmlEvent(gridObj)
 * {
 * 	gridObj.selectCellByCoords(0,0);
 * 	gridObj.edit();
 * }
 * </code></pre>
 * </div>
 * @param {String} evt A event string identifier or key for the given event. This value is the event name without the "On" and "Event" parts of the name, for example, the key for the OnDataReadyEvent is becomes "DataReady".
 * @param {Function} func A reference to the Function object that should be called when the event is fired.
 * @param {Object} context A reference to the Object that the Function should be called in the context of. When writing object oriented JavaScript the reference to the Function must also have some context in which it is to be executed.
 * @param {Array} params Any parameters that should be passed to the handler function.
 * @see #subscribe
 * @private
 */
nitobi.Object.prototype.subscribeOnce = function(evt, func, context, params)
{
	var _this = this;
	var func1 = function()
	{
		func.apply(context || this, params || arguments);
		_this.unsubscribe(evt, guid);
	}
	var guid = this.subscribe(evt,func1);
	return guid;
}

/**
 * Unsubscribes an event from Grid.
 * @param {String} evt The event name without the "On" prefix and "Event" suffix.
 * @param {Number} guid The unique ID of the event as returned by the subscribe method. 
 * If the event is defined through the declaration the unique ID can be accessed through the grid API such as grid.OnHtmlReadyEvent.
 * @private
 */
nitobi.Object.prototype.unsubscribe=function(evt,guid)
{
	return nitobi.event.unsubscribe(evt+this.uid, guid);
}

/**
 * Destroys all objects added to the disposal array.
 */
nitobi.Object.prototype.dispose = function()
{
	if (this.disposing)
		return;

	this.disposing = true;

	// Loop through the disposal array first. 
	var disposalLength = this.disposal.length;
	for (var i=0; i<disposalLength; i++)
	{
		if (disposal[i] instanceof Function)
		{
			disposal[i].call(context);
		}
		disposal[i] = null;
	}

	// Loop through every item in the object.
	for (var item in this)
	{
		if (this[item].dispose instanceof Function)
		{
			this[item].dispose.call(this[item]);
		}
		this[item] = null;
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
if (false)
{
	/**
	 * @namespace The namespace for the basic building blocks of Nitobi components.
	 * @constructor
	 */
	 nitobi.base = function(){};
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// THIS IS JUST FOR GRID / COMBO COMPAT.
nitobi.lang.defineNs("nitobi.base");

/**
 * The unique id counter.
 * @private
 */
nitobi.base.uid = 1;

/**
 * Returns a unique id.
 * @private
 */
nitobi.base.getUid = function()
{
	return "ntb__"+(nitobi.base.uid++);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.browser");
if (false)
{
	/**
	 * @namespace The nitobi.browser namespace contains several static fields specifying what the current browser is.
	 * @constructor
	 */
	nitobi.browser = function(){};
}

/**
 * When <code>true</code>, there is no information available pointing to what type of browser is being
 * employed.
 * @type Boolean
 */
nitobi.browser.UNKNOWN = true;
/**
 * When <code>true</code>, the browser in use is some version of Internet Explorer.
 * @type Boolean
 */
nitobi.browser.IE = false;
/**
 * When <code>true</code>, the browser in use is Internet Explorer version 6.x.
 * @type Boolean
 */
nitobi.browser.IE6 = false;
/**
 * When <code>true</code>, the browser in use is Internet Explorer version 7.x.
 * @type Boolean
 */
nitobi.browser.IE7 = false;
/**
 * When <code> true, the browser in use is Internet Explorer version 8.x.
 * @type Boolean
 */
nitobi.browser.IE8 = false;
/**
 * When <code> true, the browser in use is some Gecko-based browser (Firefox/Mozilla/Netscape).
 * @type Boolean
 */
nitobi.browser.MOZ = false;
/**
 * When <code> true, the browser in use is Firefox 3 (Firefox/Mozilla/Netscape).
 * @type Boolean
 */
nitobi.browser.FF3 = false;
/**
 * When <code> true, the browser in use is some version Safari.
 * @type Boolean
 */
nitobi.browser.SAFARI = false;
/**
 * When <code>true</code>, the browser in use is some version of Opera.
 * @type Boolean
 */
nitobi.browser.OPERA = false;
/**
 * When <code>true</code>, the browser in use is some version of Adobe AIR.
 * @type Boolean
 */
nitobi.browser.AIR = false;
/**
 * When <code>true</code>, the browser in use is some version of Chrome.
 * @type Boolean
 */
nitobi.browser.CHROME = false;
/**
 * When <code>true</code>, the browser in use is Ajax-capable (it has an XMLHttpRequest object).
 * @type Boolean
 */
nitobi.browser.XHR_ENABLED
/**
 * Detects which browser is being used.
 * This function sets up the booleans found above.  It is called automatically when this class is 
 * included in your page.
 */
nitobi.browser.detect = function ()
{
	var data = [
		{
			string: navigator.vendor,
			subString: "Adobe",
			identity: "AIR"
		},
		{
			string: navigator.vendor,
			subString: "Google",
			identity: "Chrome"
		},
		{
			string: navigator.vendor,
			subString: "Apple",
			identity: "Safari"
		},
		{
			prop: window.opera,
			identity: "Opera"
		},
		{
			string: navigator.vendor,
			subString: "iCab",
			identity: "iCab"
		},
		{
			string: navigator.vendor,
			subString: "KDE",
			identity: "Konqueror"
		},
		{
			string: navigator.userAgent,
			subString: "Firefox",
			identity: "Firefox"
		},
		{	// for newer Netscapes (6+)
			string: navigator.userAgent,
			subString: "Netscape",
			identity: "Netscape"
		},
		{
			string: navigator.userAgent,
			subString: "MSIE",
			identity: "Explorer",
			versionSearch: "MSIE"
		},
		{
			string: navigator.userAgent,
			subString: "Gecko",
			identity: "Mozilla",
			versionSearch: "rv"
		},
		{ 	// for older Netscapes (4-)
			string: navigator.userAgent,
			subString: "Mozilla",
			identity: "Netscape",
			versionSearch: "Mozilla"
		},
		{	
			string: navigator.vendor,
			subString: "Camino",
			identity: "Camino"
		}
	];

	var browser = "Unknown";
	for (var i=0;i<data.length;i++)	{
		var dataString = data[i].string;
		var dataProp = data[i].prop;
		if (dataString) {
			if (dataString.indexOf(data[i].subString) != -1)
			{
				browser = data[i].identity;
				break;
			}
		}
		else if (dataProp)
		{
			browser = data[i].identity;
			break;
		}
	}
	nitobi.browser.IE = (browser == "Explorer");
	nitobi.browser.IE6 = (nitobi.browser.IE && !window.XMLHttpRequest);
	nitobi.browser.IE7 = (nitobi.browser.IE && window.XMLHttpRequest);

	nitobi.browser.MOZ = (browser == "Netscape" || browser == "Firefox" || browser == "Camino");
	nitobi.browser.FF3 = (browser == "Firefox" && parseInt(navigator.userAgent.substr(navigator.userAgent.indexOf("Firefox/")+8, 3)) == 3);
	nitobi.browser.SAFARI = (browser == "Safari");
	nitobi.browser.OPERA = (browser == "Opera");
	nitobi.browser.AIR = (browser == "AIR");
	nitobi.browser.CHROME = (browser == "Chrome");

	if (nitobi.browser.SAFARI)
		nitobi.browser.OPERA = true;
	if (nitobi.browser.AIR)
		nitobi.browser.SAFARI = true;

	nitobi.browser.XHR_ENABLED = nitobi.browser.OPERA || nitobi.browser.SAFARI || nitobi.browser.MOZ || nitobi.browser.IE || nitobi.browser.CHROME;

	// This is a pretty liberal usage of the word unknown - we just don't care about other browsers.
	nitobi.browser.UNKNOWN = !(nitobi.browser.IE || nitobi.browser.MOZ || nitobi.browser.SAFARI || nitobi.browser.CHROME);
};

nitobi.browser.detect();
if (nitobi.browser.IE6)
{
	try {
		document.execCommand("BackgroundImageCache", false, true);
	} catch (e)
	{
		/* works in SP1 and after */
	}	
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.browser");
// Is this stuff tested?
/**
 * @private
 */
nitobi.browser.Cookies = function()
{
};

nitobi.lang.extend(nitobi.browser.Cookies, nitobi.Object);

/**
 * Returns a cookie with the given ID.
 * @param {String} id The ID of the cookie to retrieve.
 * @returns {Cookie}
 */
nitobi.browser.Cookies.get = function(id)
{
	var begin, end;
	if (document.cookie.length > 0)
	{
		begin = document.cookie.indexOf(id+"=");
		if (begin != -1)
		{
			begin += id.length+1;
			end = document.cookie.indexOf(";", begin);
			if (end == -1) end = document.cookie.length;
			return unescape(document.cookie.substring(begin, end)); 
		}
	}
	return null;
};

/**
 * Sets the
 * @param {String} id The ID of the cookie.
 * @param {String} value The value to be stored in the cookie.
 * @param {String} expireDays The number of days before the cookie should expire.
 */
nitobi.browser.Cookies.set = function(id, value, expireDays)
{
	var expiry = new Date ();
	expiry.setTime(expiry.getTime() + (expireDays * 24 * 3600 * 1000));

	document.cookie = id + "=" + escape(value) +
	((expireDays == null) ? "" : "; expires=" + expiry.toGMTString());
};

/**
 * Destroys cookie.
 * @param {String} id The ID of the cookie to destroy.
 */
nitobi.browser.Cookies.remove = function(id)
{
	if (nitobi.browser.Cookies.get(id)) 
	{
		document.cookie = id + "=" + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
	}
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.browser");

/**
 * Creates a History object with which you can maintain back button support in your ajax application.
 * @class History is used to fix the back button in the web browser.
 * Current support is only for IE and MOZ browsers.
 * @constructor
 */
nitobi.browser.History = function()
{
	/**
	 * @private
	 */
	this.lastPage = "";
	/**
	 * @private
	 */
	this.currentPage = "";
	/**
	 * Fired when the back or forward button is pressed by the user.
	 * @type nitobi.base.Event
	 */
	this.onChange = new nitobi.base.Event();
	/**
	 * @private
	 */
	this.iframeObject = nitobi.html.createElement("iframe", {"name":"ntb_history","id":"ntb_history"}, {"display":"none"});

	document.body.appendChild(nitobi.xml.importNode(document, this.iframeObject, true));
	/**
	 * @private
	 */
	this.iframe = frames['ntb_history'];
	this.monitor();
}
/**
 * Adds a new URL to the back button history.
 * @param {String} path A URL with a "#" character that separates the web page from the fragment.
 * Either part (page name or fragment) can be used to retrieve the state.
 */
nitobi.browser.History.prototype.add = function(path)
{
	this.lastPage = this.currentPage = path.substr(path.indexOf("#")+1);
	this.iframe.location.href = path;
}
/**
 * Monitors the hidden IFRAME watching for changes to the location. When the location changes due to the
 * user pressing the back or forward buttons the OnChange event is fired.
 * @private
 */
nitobi.browser.History.prototype.monitor = function()
{
	var alocation = this.iframe.location.href.split("#");
	this.currentPage = alocation[1];
	if (this.currentPage != this.lastPage)
	{
		this.onChange.notify(alocation[0].substring(alocation[0].lastIndexOf("/")+1), this.currentPage);
		this.lastPage = this.currentPage;
	}
	window.setTimeout(nitobi.lang.close(this, this.monitor), 1500);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.xml");

/**
 * @namespace The nitobi.xml namespace contains static functions for dealing with XML data and performing XSLT transformations.
 * @constructor
 */
nitobi.xml = function(){}

/**
 * The namespace prefix for Nitobi XML.  Is <i>ntb:</i> by default.
 * @type String
 */
nitobi.xml.nsPrefix = "ntb:";
/**
 * The XML namespace URI for Nitobi XML.  Is <i>xmlns:ntb="http://www.nitobi.com"</i> by default.
 * @type String
 */
nitobi.xml.nsDecl = 'xmlns:ntb="http://www.nitobi.com"';

if (nitobi.browser.IE)
{
	//	TODO: this should be pooled.
	//Define a global XSLTemplate Object so that we dont have to create it at runtime
	//This is used when creating an XSLT Processor 
	var inUse = false;
	/**
	 * @private
	 */
	nitobi.xml.XslTemplate = new ActiveXObject("MSXML2.XSLTemplate.3.0");
}

if (typeof XMLSerializer != "undefined" && typeof DOMParser != "undefined")
{
	//	TODO: this should be pooled.
	//Define a global serializer so that we don't have to create it at runtime
	/**
	 * @private
	 */
	nitobi.xml.Serializer = new XMLSerializer();
	nitobi.xml.DOMParser = new DOMParser();
}

/**
 * Returns the child nodes of a given XML node, ignoring text nodes.
 * @param {XMLNode} xmlNode The parent node.
 * @type XMLNode
 */
nitobi.xml.getChildNodes = function(xmlNode)
{
	if (nitobi.browser.IE)
	{
		return xmlNode.childNodes;
	}
	else
	{
		return xmlNode.selectNodes('./*');
	}
};

/**
 * Returns the index of the child node in the parent collection. -1 if not found.
 * @param {XMLNode} parent The parent to search through.
 * @param {XMLNode} child The child whose index you want to find.
 * @type Number
 */
nitobi.xml.indexOfChildNode = function(parent,child)
{
	var childNodes = nitobi.xml.getChildNodes(parent);
	for (var i=0; i < childNodes.length;i++)
	{
		if (childNodes[i] == child)
		{
			return i;
		}
	}
	return -1;
}

/**
 * Creates an XML document from a string of XML.
 * @param {String | XMLDocument} xml XML string to load into the XmlDocument object.
 * @type XMLDocument
 */
nitobi.xml.createXmlDoc = function(xml)
{
	// checks for anything added to the beginning of the response, i.e. by a debugger
	if (xml != null)
		xml = xml.substring(xml.indexOf("<?xml"));
	
	if (xml != null && xml.documentElement != null)
		return xml;

	var doc = null;
	if (nitobi.browser.IE)
	{
		// TODO: Do a better job of using whatever DOMDocument is available.
		//var AX=["Msxml4.DOMDocument","Msxml3.DOMDocument","Msxml2.DOMDocument","Msxml.DOMDocument","Microsoft.XmlDom"];
		doc = new ActiveXObject("Msxml2.DOMDocument.3.0");
		doc.setProperty('SelectionNamespaces', 'xmlns:ntb=\'http://www.nitobi.com\'');
	}
	else if (document.implementation && document.implementation.createDocument)
	{
		doc = document.implementation.createDocument("", "", null);
	}

	if(xml!=null && typeof xml == "string")
	{
		doc = nitobi.xml.loadXml(doc, xml);
	}
	return doc;
}

/**
 * Loads a string of XML data into the given XML document object.  <code>loadXml</code> also
 * returns the XML document object to allow for chaining operations.
 * @param {XMLDocument} doc An xml document to receive the XML from the xml string.
 * @param {String} str XML string to load into the XmlDocument object (doc).
 * @param {Boolean} clearDoc Flag indicating if the expensive operation of clearing the XMLDocument should be performed. 
 * This is only required if the XMLDocument already has contents to be overwritten. Optional.
 * @type XMLDocument
 */
nitobi.xml.loadXml = function(doc, xml, clearDoc)
{
	doc.async = false;
	if (nitobi.browser.IE)
		doc.loadXML(xml);
	else
	{
		// customize by kstan@simit.com.my 11-07-2010
		var p=new DOMParser();
		var myxml=xml.replace(/\n/g,"&#xa;").replace(/>&#xa;</g,">\n<");
		var tempDoc=p.parseFromString(myxml!=null?myxml:"","text/xml");

		// added the terse if for Chrome ... not sure what the deal is there...
//		var tempDoc = nitobi.xml.DOMParser.parseFromString(( xml.xml != null ? xml.xml : xml ), "text/xml");
		//end customize by kstan@simit.com.my 11-07-2010
		if (clearDoc)
		{
			while (doc.hasChildNodes())
				doc.removeChild(doc.firstChild);
			for (var i=0; i < tempDoc.childNodes.length; i++) {
				doc.appendChild(doc.importNode(tempDoc.childNodes[i], true));
			}
		}
		else
			doc = tempDoc;

		tempDoc = null;
	}
	return doc;
}

/**
 * Determines whether or not an XML document has a parse error. If an error
 * exists it returns true and false otherwise.
 * @param {XMLDocument} xmlDoc The xml doc that had the error.
 * @type Boolean
 */
nitobi.xml.hasParseError = function(xmlDoc)
{
	if (nitobi.browser.IE)
	{
		return (xmlDoc.parseError != 0);
	}
	else
	{
		if (xmlDoc == null || xmlDoc.documentElement == null) return true;
		var roottag = xmlDoc.documentElement;
		if ((roottag.tagName == "parserError") || (roottag.namespaceURI == "http://www.mozilla.org/newlayout/xml/parsererror.xml"))
		{
			return true;
		}
		return false;
	}
}

/**
 * Returns the parse error in an XML document.
 * @param {XMLDocument} xmlDoc The xml doc that had the error.
 * @type String
 */
nitobi.xml.getParseErrorReason = function(xmlDoc)
{
	if (!nitobi.xml.hasParseError(xmlDoc))
	{
		return "";
	}
	if (nitobi.browser.IE)
	{
		return (xmlDoc.parseError.reason);
	}
	else
	{
		return (new XMLSerializer().serializeToString(xmlDoc));
	}
}

/**
 * Creates and returns an XSL document. This differs from an XML document in that in Internet Explorer we use the MSXML2.FreeThreadedDOMDocument.3.0 ActiveX object such that it can be used with an XSLProcessor.
 * @param {String} xsl XML string to load into the XmlDocument object.
 * @type XMLDocument
*/
nitobi.xml.createXslDoc = function(xsl)
{
	var doc = null;

	if (nitobi.browser.IE)
		doc = new ActiveXObject("MSXML2.FreeThreadedDOMDocument.3.0"); 
	else
		doc = nitobi.xml.createXmlDoc();

	doc = nitobi.xml.loadXml(doc, xsl || '<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com" />');
	return doc;
}


/**
 * Creates an XSL processor object that will cache compiled XSLT stylesheets.
 * @param {String|XMLDocument} xsl An XML document that conforms to the XSL dtd.
 * @type XSLProcessor
 */
nitobi.xml.createXslProcessor = function(xsl)
{
	// TODO: we use createXslDoc a lot but then re-load the XML here ... this needs to be tightened up.
	var xslDoc = null;
	var xt = null;

	if (typeof(xsl) != "string")
	{
		xsl = nitobi.xml.serialize(xsl);
	}

	if (nitobi.browser.IE)
	{
		xslDoc = new ActiveXObject("MSXML2.FreeThreadedDOMDocument.3.0");
		xt = new ActiveXObject("MSXML2.XSLTemplate.3.0");
		xslDoc.async = false;
		xslDoc.loadXML(xsl);
		xt.stylesheet = xslDoc;
		return xt.createProcessor();
	}
	else if (XSLTProcessor)
	{
		xslDoc = nitobi.xml.createXmlDoc(xsl);
		xt = new XSLTProcessor();
		xt.importStylesheet(xslDoc);
		xt.stylesheet = xslDoc;
		return xt;
	}
}

/**
 * Parses an HTML fragment and returns a valid XML document.
 * @param {HTMLElement} element An HTML element which corresponds to the documentElement
 * of the resulting XML document or a string of HTML.
 * @type XMLDocument
 */
nitobi.xml.parseHtml = function(element)
{
	if (typeof(element) == "string")
		element = document.getElementById(element);

	var html = nitobi.html.getOuterHtml(element);

	// In IE < etc come in unencoded no matter how many times you encode - ie &amp;lt; == <
	// But in FF this is not the case.
	var fixedHtml = "";
	if (nitobi.browser.IE)
	{
		// First things first, IE will mess with attribute values containing &quot;
		// eg attname="&quot;Value&quot;" => attname='"Value"' note the outer single quotes!!! 
		var regexpQuot = new RegExp("(\\\s+.[^=]*)='(.*?)'","g");
		html = html.replace(regexpQuot, function(m,_1,_2){return _1+"=\""+_2.replace(/"/g,"&quot;")+"\"";});

		fixedHtml = (html.substring(html.indexOf('/>')+2).replace(/(\s+.[^\=]*)\=\s*([^\"^\s^\>]+)/g,"$1=\"$2\" ")).replace(/\n/gi,'').replace(/(.*?:.*?\s)/i,"$1  ");

		var regexpLt = new RegExp('\="([^"]*)(\<)(.*?)"', 'gi');
		var regexpGt = new RegExp('\="([^"]*)(\>)(.*?)"', 'gi');

		// Encode any < or > characters in attribute values.
		// Loop through until the match is false - cause we need to get
		// every < with an attribute =".." ...
		while (true)
		{
			fixedHtml = fixedHtml.replace(regexpLt, "=\"$1&lt;$3\" ")
			fixedHtml = fixedHtml.replace(regexpGt, "=\"$1&gt;$3\" ");
			// TODO: Two tests here since IE (and maybe MOZ??) is being weird.
			var x = (regexpLt.test(fixedHtml));
			if (!regexpLt.test(fixedHtml))
				break;
		}
	}
	else
	{	
		// The html is going to have everything escaped in firfox - ie <br> == &lt;br&gt;.
		// but the & character is a problem.
		fixedHtml = html;//.replace(/(\s+.[^\=]*)\=\s*([^\"^\s^\>]+)/g,"$1=\"$2\" ")
		fixedHtml = fixedHtml.replace(/\n/gi,'').replace(/\>\s*\</gi,'><').replace(/(.*?:.*?\s)/i,"$1  ");		
		fixedHtml = fixedHtml.replace(/\&/g,'&amp;');
		fixedHtml = fixedHtml.replace(/\&amp;gt;/g,'&gt;').replace(/\&amp;lt;/g,'&lt;').replace(/\&amp;apos;/g,'&apos;').replace(/\&amp;quot;/g,'&quot;').replace(/\&amp;amp;/g,'&amp;').replace(/\&amp;eq;/g,'&eq;');
	}

	if (fixedHtml.indexOf('xmlns:ntb="http://www.nitobi.com"') < 1)
	{
		// indert our namespace into this XML
		fixedHtml = fixedHtml.replace(/\<(.*?)(\s|\>|\\)/, '<$1 xmlns:ntb="http://www.nitobi.com"$2');
	}

	fixedHtml = fixedHtml.replace(/\&nbsp\;/gi,' ');

	return nitobi.xml.createXmlDoc(fixedHtml);
}


/**
 * Transforms the provided XML document using the provided XSL processor.
 * @param {XMLDocument} xml the XML document to input
 * @param {Object} xsl Either an XmlDocument or an XslProcessor
 * @type String
 * @private
 */
nitobi.xml.transform = function(xml,xsl,type)
{
	// Check to see if the XSL is an XML doc or not...
	if (xsl.documentElement)
	{
		xsl = nitobi.xml.createXslProcessor(xsl);
	}
	if (nitobi.browser.IE)
	{
		/*
		if (typeof(xsl.xml) == "string" || type == "xml")
		{
			// We dont have an XSL processor - just regular XSL
			// OR we want XML output in which case we can't use the XSLProcessor.
			if (type == "text")
			{
				return xml.transformNode(xsl);
			}
			else
			{
				var output = nitobi.xml.createXmlDoc();
				if (typeof(xsl.xml) != "string")
				{
					xsl = xsl.ownerTemplate.stylesheet;
				}
				xml.transformNodeToObject(xsl, output);
				return output;
			}
		}
		else
		{
		*/
			xsl.input=xml;
			xsl.transform();
			return xsl.output;
		//}
	}
	else if (XSLTProcessor)
	{	var tmpxml;
		var doc;
		if(nitobi.browser.MOZ){
			doc = xsl.transformToDocument(xml);
		}
		else{
			var p=new DOMParser();
			if(xml.xml.indexOf("\n")>0){
			tmpxml=xml.xml.replace(/\n/g,"{nl}").replace(/>{nl}</g,">\n<");
			xml=p.parseFromString(tmpxml!=null?tmpxml:"","text/xml");
			}
			doc=xsl.transformToDocument(xml);
			var tmpdoc=doc.xml.replace(/{nl}/g,"&#xa;");
			doc=p.parseFromString(tmpdoc!=null?tmpdoc:"","text/xml");

		}
		var firstNode = doc.documentlement;
		if (firstNode && firstNode.nodeName.indexOf('ntb:') == 0)
		{
			firstNode.setAttributeNS('http://www.w3.org/2000/xmlns/','xmlns:ntb','http://www.nitobi.com');
		}
		return doc;
	}
}

/**
 * Transforms the provided XML document using the provided XSL processor.
 * @param {XMLDocument} xml the XML document to use as input
 * @param {Object} xsl Either an XmlDocument or an XslProcessor
 * @type String
 */
nitobi.xml.transformToString = function(xml,xsl,type)
{
	var result = nitobi.xml.transform(xml,xsl,"text");
	if (nitobi.browser.MOZ)
	{
		//The type attribute does nothing in the IE version of this function
		if (type == "xml")
		{
			//	This is to be used when the output type is xml ...
			result = nitobi.xml.Serializer.serializeToString(result);
		}
		else
		{
			//	This is to be used when the output type is text ...

			if (result.documentElement.childNodes[0] == null)
			{
				nitobi.lang.throwError("The transformToString fn could not find any valid output");
			}
			if (result.documentElement.childNodes[0].data != null)
			{
				result = result.documentElement.childNodes[0].data;
			}
			else if (result.documentElement.childNodes[0].textContent != null)
			{
				result = result.documentElement.childNodes[0].textContent;
			}
			else
			{
				nitobi.lang.throwError("The transformToString fn could not find any valid output");
			}				
		}
	}
	else if (nitobi.browser.SAFARI||nitobi.browser.CHROME)
	{
		//The type attribute does nothing in the IE version of this function
		if (type == "xml")
		{
			//	This is to be used when the output type is xml ...
			result = nitobi.xml.Serializer.serializeToString(result);
		}
		else
		{
			var dataNode = result.documentElement;
			if (dataNode.nodeName != 'transformiix:result')
			{
				// WebKit stores its "text" transformation in a pre tag.
				dataNode = dataNode.getElementsByTagName('pre')[0];
			}
			try {
				result = dataNode.childNodes[0].data;
			} catch(e) {
				// This is the case for Safari when the transformation result is ""
				result = (dataNode.data)
			}
		}
	}
	return result;
}

/**
 * Transforms the provided XML document using the provided XSL processor and returns an XML document.
 * @param {XMLDocument} xml the XML document to use as input
 * @param {XMLDocument|XSLProcessor} xsl Either an XmlDocument or an XslProcessor
 * @type XMLDocument
 */
nitobi.xml.transformToXml = function(xml,xsl)
{
	var result = nitobi.xml.transform(xml,xsl,"xml");
	if (typeof result == "string")
	{
		result = nitobi.xml.createXmlDoc(result);
	}
	else
	{
		if (result.documentElement.nodeName == "transformiix:result")
		{
			result = nitobi.xml.createXmlDoc(result.documentElement.firstChild.data);
//				result = result.documentElement.firstChild;
		}
	}
	return result;
}

/**
 * Converts the contents of an XMLDocument to a string.
 * @param {XMLDocument} xml the XML document to be serialized
 * @type String
 */
nitobi.xml.serialize = function(xml)
{
	if (nitobi.browser.IE)
		return xml.xml;
	else
		return (new XMLSerializer()).serializeToString(xml);
}

/**
 * Creates and returns an XMLHttpRequest object.
 * @type XMLHttpRequest
 * @private
 */
nitobi.xml.createXmlHttp = function()
{
	if (nitobi.browser.IE)
	{
		//	TODO: try all the XML HTTP objects starting from 5...
		var reservedObj = null;
		try
		{
			reservedObj = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				reservedObj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(ee)
			{
			}
		}
		return reservedObj;
	}
	else
	{
		return new XMLHttpRequest();
	}
}

/**
 * Creates a namespaced XML element. 
 * @param {XMLDocument} xmlDoc The document to create the element in.
 * @param {String} elementName The name of the element to create.
 * @param {String} [ns] The namespace.  The default namespace is "http://www.nitobi.com".
 */
nitobi.xml.createElement = function(xmlDoc, elementName, ns)
{
	ns = ns || "http://www.nitobi.com";
	var newDataNode = null;
	if (nitobi.browser.IE)
		newDataNode = xmlDoc.createNode(1, nitobi.xml.nsPrefix+elementName, ns);
	else if (xmlDoc.createElementNS)
		newDataNode = xmlDoc.createElementNS(ns, nitobi.xml.nsPrefix+elementName);
	return newDataNode;
}

/**
 * just a little helper ...
 * @private
 */
function nitobiXmlDecodeXslt(xsl)
{
	return xsl.replace(/x:c-/g, 'xsl:choose')
		.replace(/x\:wh\-/g, 'xsl:when')
		.replace(/x\:o\-/g, 'xsl:otherwise')
		.replace(/x\:n\-/g, ' name="')
		.replace(/x\:s\-/g, ' select="')
		.replace(/x\:va\-/g, 'xsl:variable')
		.replace(/x\:v\-/g, 'xsl:value-of')
		.replace(/x\:ct\-/g, 'xsl:call-template')
		.replace(/x\:w\-/g, 'xsl:with-param')
		.replace(/x\:p\-/g, 'xsl:param')
		.replace(/x\:t\-/g, 'xsl:template')
		.replace(/x\:at\-/g, 'xsl:apply-templates')
		.replace(/x\:a\-/g, 'xsl:attribute')
}

//This is all the special stuff to emulate IE stuff in nitobi.browser.MOZ ...
if (!nitobi.browser.IE)
{
	/**
	 * Mimic IE's loadXML()
	 * @private
	 * @ignore
	 * @deprecated Use nitobi.xml.loadXml instead.
	 */
	Document.prototype.loadXML=function(strXML) {
		changeReadyState(this,1);
		var p=new DOMParser();
		var d=p.parseFromString(strXML,"text/xml");
		while(this.hasChildNodes())
			this.removeChild(this.lastChild);
		for(var i=0; i<d.childNodes.length; i++)
			this.appendChild(this.importNode(d.childNodes[i],true));
		changeReadyState(this,4);
	};

	/**
	 * Make the .xml property available on XML Document and XML Node objects.
	 * @private
	 * @ignore
	 */
	Document.prototype.__defineGetter__("xml", function () {return (new XMLSerializer()).serializeToString(this);});
	/**
	 * Make the .xml property available on XML Document and XML Node objects.
	 * @private
	 * @ignore
	 */
	Node.prototype.__defineGetter__("xml", function () {return (new XMLSerializer()).serializeToString(this);});

	/**
	 * @private
	 * @ignore
	 */
	XPathResult.prototype.__defineGetter__("length", function() {return this.snapshotLength;});

	//These are important and are currently used
	//Simple emulation of IE addParameter method on the XSLT processor object
	/**
	 * Emulate the setParameter method for Firefox.
	 * @ignore
	 */
	if (XSLTProcessor) {
		XSLTProcessor.prototype.addParameter = function (baseName, parameter, namespaceURI)
		{
			if (parameter == null)
			{
				this.removeParameter(namespaceURI,baseName);
			}
			else
			{
				this.setParameter(namespaceURI, baseName, parameter);
			}
		};
    }

	/**
	 * Emulates the selectNodes method that is available on XML documents Internet Explorer such that it can be used in Firefox.
	 * @param {string} sExpr XPath expression that is evaluated to get the XMLNodeList.
	 * @param {Element} contextNode XML element from which the XPath should be executed. Optional
	 * @type {XMLNodeList}
	 * @private
	 * @ignore
     */
	XMLDocument.prototype.selectNodes = function(sExpr, contextNode)
	{
		try {
			//	TODO: we need to get some assert stuff in here ... 
			if (this.nsResolver == null)
				this.nsResolver = this.createNSResolver(this.documentElement);
	
			var oResult = this.evaluate(sExpr, (contextNode?contextNode:this), new MyNSResolver(), XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
			var nodeList = new Array(oResult.snapshotLength);
			nodeList.expr = sExpr;
			var j = 0;
			for (i=0;i<oResult.snapshotLength;i++)
			{
				var item = oResult.snapshotItem(i);
				//	Ignore whitespace nodes.
				if (item.nodeType != 3)
				{
					nodeList[j++] = item;
				}
			}
			return nodeList;
		}catch(e){
			//console.log('problem in selectnodes. probably in creating NSResolver');
		}
	};

	Document.prototype.selectNodes = XMLDocument.prototype.selectNodes;

    function MyNSResolver() {}
	MyNSResolver.prototype.lookupNamespaceURI = function(prefix) {
		switch (prefix) {
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
	}

	/**
	 * Emulates the selectSingleNode method that is available on XML documents Internet Explorer such that it can be used in Firefox.
	 * @param {string} sExpr XPath expression that is evaluated to get the XML element.
	 * @param {Element} contextNode XML element from which the XPath should be executed. Optional
	 * @type {Element}
	 * @private
	 * @ignore
	 */
	XMLDocument.prototype.selectSingleNode = function(sExpr, contextNode)
	{
		var indexExpression = sExpr.match(/\[\d+\]/ig);
		if (indexExpression != null)
		{
			var x = indexExpression[indexExpression.length-1];
			if (sExpr.lastIndexOf(x) + x.length != sExpr.length)
			{     
				sExpr += "[1]";
			}
		}

		var nodeList = this.selectNodes(sExpr, contextNode || null);
		return ((nodeList != null && nodeList.length > 0)?nodeList[0]:null);
	};

	Document.prototype.selectSingleNode = XMLDocument.prototype.selectSingleNode;

	/**
	 * @private
	 * @ignore
	 */
	Element.prototype.selectNodes = function(sExpr)
	{
		var doc = this.ownerDocument;
		return doc.selectNodes(sExpr, this);
	};

	/**
	 * @private
	 * @ignore
	 */
	Element.prototype.selectSingleNode = function(sExpr)
	{
		var doc = this.ownerDocument;
		return doc.selectSingleNode(sExpr, this);
	};
}

/**
 * Returns the remainder of a string after the first appearance of a colon (':').  When
 * an XML node name is used as input this will be the local name of the node.
 * @param {String} nodeName the input string
 * @type String
 */
nitobi.xml.getLocalName = function(nodeName)
{
	var colon = nodeName.indexOf(":");
	if (colon == -1)
	{
		return nodeName;
	}
	else
	{
		return nodeName.substr(colon+1);
	}
}

nitobi.xml.importNode = function(doc, node, childClone)
{
	if (childClone == null)
		childClone = true;
	return (doc.importNode?doc.importNode(node, childClone):node);
	//return node;
}


/**
 * @private
 */
nitobi.xml.encode = function(str)
{
	str += "";
	str = str.replace(/&/g,"&amp;");
	str = str.replace(/'/g,"&apos;");
	str = str.replace(/\"/g,"&quot;");
	str = str.replace(/</g,"&lt;");
	str = str.replace(/>/g,"&gt;");
	str = str.replace(/\n/g,"&#xa;");
	return str;
}

/**
 * @private
 * Makes a valid XPATH query from a value.
 * This addresses a deficiency in XSL.A literal string can be written with either kind of quote. 
 * XPaths usually appear in attributes, and of course these have to be quoted too. 
 * You can use the usual XML entities &quot; and &apos; for quotes in your XPaths, but remember 
 * that these are expanded by the XML parser, before the XPath string is parsed. There is no way to
 * escape characters at the XPath level, so you can't have a literal XPath string 
 * containing both kinds of quote.However, you can create a concat function that tricks the processor into accepting
 * both kinds of quotes, which is what this function does.
 * @param {String} Value The value.
 * @param {Boolean} QuoteValue If true, when no concat workaround is needed, surrounds the value with quotes.
 * @type {String} A XPATH concat function.
 */
nitobi.xml.constructValidXpathQuery = function(Value, QuoteValue)
{
	var matches=Value.match(/(\"|\')/g);
	if (matches!=null)
	{
		var xpath="concat(";
		var comma="";
		var quote;
		for (var i=0;i<Value.length;i++)
		{
			if (Value.substr(i,1)=="\"")
			{
				quote="&apos;";
			}
			else
			{
				quote="&quot;";
			}
			xpath+=comma+quote+nitobi.xml.encode(Value.substr(i,1))+quote;
			comma=",";
		}
		xpath+=comma+"&apos;&apos;";
		xpath+=")";
		Value=xpath;
	}
	else
	{
		var quot=(QuoteValue?"'":"");
		Value=quot+nitobi.xml.encode(Value)+quot;
	}
	return Value;
}

/**
 * Removes all the child nodes of some given xml node.
 * @param {Node} parentNode The node whose children to remove.
 */
nitobi.xml.removeChildren = function(parentNode)
{
	while(parentNode.firstChild)
		parentNode.removeChild( parentNode.firstChild );
}

/**
 * @private
 * This is an empty XML doc for use whenever you want.
 */
nitobi.xml.Empty = nitobi.xml.createXmlDoc('<root></root>');
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.html");

/**
 * <I>This class has no constructor.</I>
 * @class Utilities for manipulating URLs.
 * @constructor
 */
nitobi.html.Url = function(){};

/**
 * Sets the parameter key to value in the given url, and returns the new url.
 * @param {String} url the URL to modify, can be relative or absolute
 * @param {String} key the parameter name
 * @param {String} value the new parameter value 
 * @type String
 */
nitobi.html.Url.setParameter = function(url, key, value)
{
	var reg = new RegExp('(\\?|&)('+encodeURIComponent(key)+')=(.*?)(&|$)');
	if (url.match(reg))
	{
		return url.replace(reg, '$1$2='+encodeURIComponent(value)+'$4');		
	}
	if (url.match(/\?/))
	{
		url = url + '&';
	}
	else
	{
		url = url + '?';
	}
	return url + encodeURIComponent(key) + '=' + encodeURIComponent(value);
};

/**
 * Removes the parameter key from url's parameter list and returns the new URL.
 * @param {String} url the URL to modify
 * @param {String} key the parameter to remove
 * @type String
 */
nitobi.html.Url.removeParameter = function(url, key)
{
	var reg = new RegExp('(\\?|&)('+encodeURIComponent(key)+')=(.*?)(&|$)');
	return url.replace(reg, 
		function(str,p1,p2,p3,p4,offset,s)
		{
			if (((p1) == '?') && (p4 != '&'))
			{
				return "";
			}
			else
			{
				return p1;
			} 
		}
	);
};

/**
 * Returns the path of a URL.  The path will have a slash on the end, or will be the empty string.  
 * In that way,
 * <CODE><PRE> 
 * var url = 'http://nitobi.com/index.html'
 * normalize(url) === normalize(normalize(url)) === 'http://nitobi.com/';
 * </PRE></CODE>.
 * @private
 * @param {String} url The URL to normalize.
 * @param {String} file An optional file URL to append to the normalized url.  If the file URL
 * is absolute, the function returns just the file URL.
 * @returns {String} The normalized url.
 */
nitobi.html.Url.normalize = function(url, file)
{
	if (file) {
		if (file.indexOf('http://') == 0 || file.indexOf('https://') == 0 || file.indexOf('/') == 0) {
			return file;
		}
	}
	var href = (url.match(/.*\//) || "") + "";
	if (file)
	{
		return href + file;
	}
	return href;
}

/**
 * Returns the url with a random parameter added.  This is useful for preventing 
 * a URL from being saved in browser cache.
 * @param url the URL to modify
 * @type String
 */
nitobi.html.Url.randomize = function(url)
{
	return nitobi.html.Url.setParameter(url, 'ntb-random',(new Date).getTime());
};
	
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

/**
 * Creates an event object.
 * @class Based on the MVC pattern, the Event class is used for attaching 
 * event handlers to JavaScript objects.
 * <pre class="code">
 * &#102;unction handleEvent(eventArgs) {
 * 	// Do something with the event arguments...
 * }
 *
 * var onItemSelected = new nitobi.base.Event();
 * onItemSelected.subscribe(handleEvent);
 * 
 * // When the item is selected, fire the event.
 * onItemSelected.notify(eventArgs = {arg1: 'val1', arg2: 'val2'});
 * </pre>
 * @constructor
 * @param {String} [type] The type of event, e.g., "click", "mouseover" etc.  Does not affect the behaviour of the 
 * event object.
 */
nitobi.base.Event = function(type)
{
	/**
	 * The type of event this is.
	 * @private
	 * @type String
	 */
	this.type = type;
	/**
	 * @ignore
	 */
	this.handlers = {};
	/**
	 * @ignore
	 */
	this.guid = 0;
	this.setEnabled(true);
}

/**
 * Subscribes a method with a given context to the event.
 * @example
 * var onClick = new nitobi.base.Event();
 * onClick.subscribe(myClickHandlerFunction);
 * @param {Function} method The event handler to be executed when the event is fired.
 * @param {Object} [context] The JavaScript object in the context of which the event handler is to be executed.
 * @param {String} [guid] A custom GUID. Must be unique.
 * @return The unique ID of the subscription - it can be used for unsubscription.
 * @type Number
 */
nitobi.base.Event.prototype.subscribe = function(method, context, guid)
{
	if (method == null)
		return;

	var func = method;
	if (typeof(method) == "string")
	{
		var s = method;
		//Because javascript can have characters in it that are not going to get through XSL properly,
		//this next set of replaces has been added to allow specially embedded characters to get through.
		s = s.replace(/\#\&lt\;\#/g,"<").replace(/\#\&gt\;\#/g,">").replace(/\#\&amp;lt\;\#/g,"<").replace(/\#\&amp;gt\;\#/g,">").replace(/\/\*EQ\*\//g,"=").replace(/\#\Q\#/g,"\"").replace(/\#\&amp\;\#/g,"&");
		s = s.replace(/eventArgs/g,'arguments[0]');
		method = nitobi.lang.close(context, function(){eval(s)});
	}
	if (typeof context == "object" && method instanceof Function)
	{
		func = nitobi.lang.close(context, method);
	}
	guid = guid || func.observer_guid || method.observer_guid || this.guid++;
	func.observer_guid = guid;
	method.observer_guid = guid;
	this.handlers[guid] = func;
	return guid;
}

/**
 * Subscribes a method to the event so that it will fire only once.  When method 
 * is executed (on an event notification) it is immediately unsubscribed.
 * @param {Function} method The event handler to be executed when the event is fired. 
 * @param {Object} context The JavaScript object in the context of which the event handler is to be executed. Optional.
 * @return The unique ID of the subscription - it can be used for unsubscription.
 * @type Number 
 */
nitobi.base.Event.prototype.subscribeOnce = function(method, context)
{
	var guid = null;
	var _this = this;
	var func1 = function()
	{
		method.apply(context || null, arguments);
		_this.unSubscribe(guid);
	}
	guid = this.subscribe(func1);
	return guid;
}

/**
 * Unsubscribes a method from an event.
 * @param {Number|Function} guid The ID of the subscription to remove or the function to unsubscribe.
 */
nitobi.base.Event.prototype.unSubscribe = function(guid)
{
	if (guid instanceof Function)
		guid = guid.observer_guid;
	this.handlers[guid] = null;
	delete this.handlers[guid];
}
/**
 * Executes all the event handlers that have been subscribed to this event.
 * Event handlers should return boolean values.
 * @param {Object} evtArgs Arbitrary event arguments that are passed to the event handler functions.
 * @type Boolean
 */
nitobi.base.Event.prototype.notify = function(evtArgs)
{
	if (this.enabled)
	{
		if (arguments.length == 0)
		{
			arguments = new Array();
			arguments[0] = new nitobi.base.EventArgs(null,this);
			arguments[0].event = this;
			arguments[0].source = null;
		} else if (typeof(arguments[0].event) != "undefined" && arguments[0].event == null)
		{
			arguments[0].event = this;
		}
		var fail = false;
		for (var item in this.handlers)
		{
			var handler = this.handlers[item];
			if (handler instanceof Function)
			{
				var rv = (handler.apply(this, arguments)==false);
				fail = fail || rv;
			}
		}
		return !fail;
	}
	return true;
}

/**
 * Cleans up any dangling closures.
 */
nitobi.base.Event.prototype.dispose = function()
{
	for (var handler in this.handlers)
	{
		this.handlers[handler] = null;
	}
	this.handlers = {};
}

/**
 * Enable or disable this event. After calling this method with <CODE>enabled === false</CODE>, calls to 
 * <CODE>notify</CODE> will be ignored.
 * @param {Boolean} enabled the new enabled value
 */
nitobi.base.Event.prototype.setEnabled = function(enabled)
{
	this.enabled = enabled;	
};

/**
 * Returns <code>true</code> if the event is enabled, <code>false</code> if not.
 * @type Boolean
 */
nitobi.base.Event.prototype.isEnabled = function()
{
	return this.enabled;
};
 
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.html");

/**
 * @namespace Utilities for manipulating the and inspecting the CSS properties of HTML Documents and
 * Elements.
 * @constructor
 */
nitobi.html.Css = function(){
	
	};
	
nitobi.html.Css.onPrecached = new nitobi.base.Event();
/**
 * Replace one CSS class with another in an <CODE>Element</CODE>'s class list.
 * @param {HTMLElement} domElement the HTML DOM element whose class attribute will be changed
 * @param {String} class1 the name of the class to replace with <CODE>class2</CODE>
 * @param {String} class2 the name of the class that will replace <CODE>class1</CODE> 
 */
nitobi.html.Css.swapClass = function(domElement, class1, class2)
{
	if (domElement.className)
	{
		var reg = new RegExp('(\\s|^)'+class1+'(\\s|$)');
		domElement.className = domElement.className.replace(reg,"$1"+class2+"$2");
	}
};

/**
 * Replace one CSS class with another in an <CODE>Element</CODE>'s class list.  If class1 
 * is not present, then append class2 to the class list.
 * @param {HTMLElement} domElement the HTML DOM element whose class attribute will be changed
 * @param {String} class1 the name of the class to replace with <CODE>class2</CODE>
 * @param {String} class2 the name of the class that will replace <CODE>class1</CODE> 
 */
nitobi.html.Css.replaceOrAppend = function(domElement, class1, class2)
{
	if (nitobi.html.Css.hasClass(domElement,class1))
	{
		nitobi.html.Css.swapClass(domElement,class1,class2);
	}
	else
	{
		nitobi.html.Css.addClass(domElement,class2);
	}
};
/**
 * Returns <CODE>true</CODE> if <CODE>clazz</CODE> is in <CODE>domElement</CODE>'s CSS class list.
 * @param {HTMLElement} domElement the HTML DOM element whose class attribue will be inspected
 * @param {String} clazz the name of the class to look for
 * @type Boolean 
 */
nitobi.html.Css.hasClass = function(domElement, clazz)
{
	if (!clazz || clazz === '') return false;
	return (new RegExp('(\\s|^)'+clazz+'(\\s|$)')).test(domElement.className);
};

/**
 * Adds a CSS class to the end of an HTML DOM element's class list.
 * @param {HTMLElement} domElement the HTML DOM element to alter
 * @param {String} clazz the CSS class to append to <CODE>domElement</CODE>'s class list
 * @param {Boolean} [ignoreCheck] Indicates whether or not to first check if the element already has the class that we are adding. Default is <code>false</code>.
 */
nitobi.html.Css.addClass = function(domElement, clazz, ignoreCheck)
{
	if (ignoreCheck==true || !nitobi.html.Css.hasClass(domElement, clazz))
	{
		domElement.className = domElement.className ? domElement.className + ' ' + clazz : clazz;
	}
};

/**
 * Removes a CSS class from an HTML DOM element's class list.
 * @param {HTMLElement} domElement The HTML DOM element to alter
 * @param {String | Array} clazz The CSS class to remove from <CODE>domElement</CODE>'s class list. It can also be an array of classes that will be removed.
 * @param {Boolean} [ignoreCheck] Indicates whether or not to first check if the element has the class that we are removing. Default is <code>false</code>.
 */
nitobi.html.Css.removeClass = function(domElement, clazz, ignoreCheck)
{
	if (typeof clazz == "array")
		for (var i=0; i<clazz.length; i++)
			this.removeClass(domElement, clazz[i], ignoreCheck);

	if (ignoreCheck==true || nitobi.html.Css.hasClass(domElement,clazz))
	{
		var reg = new RegExp('(\\s|^)'+clazz+'(\\s|$)');
		domElement.className = domElement.className.replace(reg,'$2');
	}
};

/**
 * Adds a CSS rule to the specified stylesheet object.
 * @example
 * var stylesheet = nitobi.html.Css.createStyleSheet();
 * nitobi.html.Css.addRule(stylesheet, ".header", "background-color: blue")
 * @param {StyleSheet} styleSheet The stylesheet object to add the rule to.
 * @param {String} selector The CSS rule selector string such as <code>.myClass</code>.
 * @param {String} style The CSS rule style string such as <code>color:red;border:1px solid black;</code>.
 */
nitobi.html.Css.addRule = function(styleSheet, selector, style)
{
	if (styleSheet.cssRules) {
		var index = styleSheet.insertRule(selector+"{"+(style||"")+"}", styleSheet.cssRules.length);
		return styleSheet.cssRules[index];
	} else {
		// sets style nitobi:placeholder since IE doesnt like the empty steez
		styleSheet.addRule(selector, style||"nitobi:placeholder;");
		return styleSheet.rules[styleSheet.rules.length-1];
	}
}

/**
 * Returns an <CODE>Array</CODE> of CSS rules in the specified stylesheet.
 * @param {StyleSheet|Number} styleSheetIndex The index of the stylesheet for which you want the rules, or a StyleSheet object itself.
 * @type Array
 */
nitobi.html.Css.getRules = function(styleSheetIndex)
{
	var sheet = null;
	if (typeof(styleSheetIndex) == 'number')
	{
		sheet = document.styleSheets[styleSheetIndex];
	}
	else // styleSheetIndex is an actual stylesheet object.
	{
		sheet = styleSheetIndex;
	}
	if (sheet == null) return null;
	// Watch out here - you can't get cross domain CSS in Firefox
	try
	{
		if (sheet.cssRules)
		{
			return sheet.cssRules;
		}
		if (sheet.rules)
		{
			return sheet.rules;
		}
	} catch (e) {/*error is due to cross domain CSS*/}
	return null;
};

/**
 * Returns an Array of CSS style sheets with the given file name.
 * @param {String} sheetName the file name (with no path) of the stylesheet
 * @type Array
 */
nitobi.html.Css.getStyleSheetsByName = function(sheetName)
{
	var arr = new Array();
	var ss = document.styleSheets;
	var regex = new RegExp(sheetName.replace(".","\.")+"($|\\?)");
	
	for (var i = 0; i < ss.length; i++)
	{
		arr = nitobi.html.Css._getStyleSheetsByName(regex, ss[i],arr);
	}
	return arr;
};
/**
 * @ignore
 */
nitobi.html.Css._getStyleSheetsByName = function(regex, sheet, arr)
{
	if (regex.test(sheet.href))
	{
		arr = arr.concat([sheet]);
	}
	var rules = nitobi.html.Css.getRules(sheet);
	// IE6 imports bug - its actually a problem with using imports on dynamic stylesheets
	if (sheet.href != "" && sheet.imports)
	{
		for (var i = 0; i < sheet.imports.length; i++)
		{
			arr = nitobi.html.Css._getStyleSheetsByName(regex,sheet.imports[i],arr);
		}
	}
	else
	{
		for (var i = 0; i < rules.length; i++)
		{
			var s = rules[i].styleSheet;
			if (s)
			{
				arr = nitobi.html.Css._getStyleSheetsByName(regex,s,arr);
			}
		}
	}
	return arr;
};

/**
 * @ignore
 */
nitobi.html.Css.imageCache = {};

/**
 * @ignore
 */
nitobi.html.Css.imageCacheDidNotify = false;

/**
 * @ignore
 */
nitobi.html.Css.trackPrecache = function(imgName)
{
	nitobi.html.Css.precacheArray[imgName] = true;
	var precacheComplete = false;
	for (var i in nitobi.html.Css.precacheArray) { 
		if (!nitobi.html.Css.precacheArray[i])	
			precacheComplete = true;
	}

	if ((!nitobi.html.Css.imageCacheDidNotify) && (!precacheComplete)) {
		nitobi.html.Css.imageCacheDidNotify = true;
		nitobi.html.Css.isPrecaching = false;
		nitobi.html.Css.onPrecached.notify();	
	}

}

/**
 * @ignore
 */
nitobi.html.Css.precacheArray = {};

/**
 * @ignore
 */
nitobi.html.Css.isPrecaching = false;


/**
 * Loads images from a stylesheet.  If no stylesheet is specified, loads every image from every
 * stylesheet in the page.  After an image is pre-cached, the browser will not need to load the 
 * image from the server.
 * @param {StyleSheet} sheet the stylesheet to parse for image names
 */

nitobi.html.Css.precacheImages = function(sheet)
{
	nitobi.html.Css.isPrecaching = true;
	if (!sheet)
	{
		var ss = document.styleSheets;
		for (var i = 0; i < ss.length; i++)
		{
			nitobi.html.Css.precacheImages(ss[i]);
		}
		//this.onPrecached.notify();
		//this.onPrecached.subscribe();
		return;
	}

	var regex = /.*?url\((.*?)\).*?/;
	var rules = nitobi.html.Css.getRules(sheet);
	var url = nitobi.html.Css.getPath(sheet);
	for (var i = 0; i < rules.length; i++)
	{
		var rule = rules[i];
		if (rule.styleSheet)
		{
			nitobi.html.Css.precacheImages(rule.styleSheet);
		}
		else
		{
			var s = rule.style;
			var bgImage = s ? s.backgroundImage : null;
			if (bgImage)
			{

				bgImage = bgImage.replace(regex,'$1');
				bgImage = nitobi.html.Url.normalize(url, bgImage);

				if (!nitobi.html.Css.imageCache[bgImage])
				{
					var image = new Image();
					image.src = bgImage;
					//console.log(bgImage);

					nitobi.html.Css.precacheArray[bgImage] = false;

					// Create a memory leak safe closure that calls the global function
					var closure = nitobi.lang.close({}, nitobi.html.Css.trackPrecache, [bgImage]);	
					image.onload = closure;
					image.onerror = closure;
					image.onabort = closure;

					nitobi.html.Css.imageCache[bgImage] = image;
					try {
					if (image.width > 0) 
						nitobi.html.Css.precacheArray[bgImage] = true;					
					} catch(e) {}
				
				}
			}
		}
	}
	// IE6 imports bug - its actually a problem with using imports on dynamic stylesheets
	if (sheet.href != "" && sheet.imports)
	{
		for (var i = 0; i < sheet.imports.length; i++)
		{
			nitobi.html.Css.precacheImages(sheet.imports[i]);
		}
	}
	
};

/**
 * Returns the normalized path for a given style sheet.
 * @param {StyleSheet} sheet the stylesheet whose URL is sought
 * @type String
 */
nitobi.html.Css.getPath = function(sheet)
{
	var href = sheet.href;
	href = nitobi.html.Url.normalize(href);
	if (sheet.parentStyleSheet && href.indexOf('/') != 0 && href.indexOf('http://') != 0 && href.indexOf('https://') != 0)
	{
		href = nitobi.html.Css.getPath(sheet.parentStyleSheet)+href;
	}
	return href;
};

/**
 * @ignore
 */
nitobi.html.Css.getSheetUrl = nitobi.html.Css.getPath;

/**
 * Returns the <CODE>StyleSheet</CODE> object to which the specified cssClass belongs.
 * @param {String} cssClass The name of the cssClass whose parent sheet you want to find.
 * @type StyleSheet
 */
nitobi.html.Css.findParentStylesheet = function(cssClass)
{
	var rule = nitobi.html.Css.getRule(cssClass);
	if (rule)
	{
		return rule.parentStyleSheet;
	}
	return null;
};

/**
 * @ignore
 */
nitobi.html.Css.findInSheet = function(cssClass, sheet, level)
{
	// IE 6 BUG - http://cs.nerdbank.net/blogs/jmpinline/archive/2006/02/09/151.aspx
	if (nitobi.browser.IE6 && typeof level == "undefined")
		level = 0;
	else if (level > 4)
		return null;
	level++;

	var rules = nitobi.html.Css.getRules(sheet);
	for (var rule = 0; rule < rules.length; rule++) {
		var ruleItem = rules[rule];
		var ss = ruleItem.styleSheet
		var selectorText = ruleItem.selectorText;
		if (ss)
		{
			// Non-IE
			var inImport = nitobi.html.Css.findInSheet(cssClass, ss, level);
			if (inImport)
				return inImport;
		}
		else if (selectorText != null) {
			// Split the selector text and iterative over it, in case the CSS declaration has multi-class declarations.
			var selectorTextArray = selectorText.split(',');
			for (var currentClass = 0; currentClass < selectorTextArray.length; currentClass++) {
				if (selectorTextArray[currentClass].toLowerCase().replace(/^\s+|\s+$/g, "").substring(0, cssClass.length) == cssClass) {
					if (nitobi.browser.IE) {
						// We create a dummy rule object that includes the parentStyleSheet field.
						// For whatever reason, IE doesn't support this property.
						ruleItem = {
							selectorText: selectorText,
							style: ruleItem.style,
							readOnly: ruleItem.readOnly,
							parentStyleSheet: sheet
						}
					}
					return ruleItem;
				}
			}
		}
	}
	// IE6 imports bug - its actually a problem with using imports on dynamic stylesheets
	var imports = sheet.imports;
	if (sheet.href != "" && imports)
	{
		// IE only
		var importLen = imports.length;
		for (var i = 0; i < importLen; i++)
		{
			var inImport = nitobi.html.Css.findInSheet(cssClass, imports[i], level);
			if (inImport) return inImport;
		}		
	}
	return null;
};

/**
 * Returns the <CODE>Style</CODE> object that has the cssClass as the only selector.  
 * Styles are cached for performance.
 * @param {String} cssClass The name of the class for which the style should be returned.
 * @param {Boolean} ignoreCache Ignore the performance cache and re-obtain the style object.
 * @type Map
 */
nitobi.html.Css.getClass = function(cssClass, ignoreCache){
	// TODO: We need to cache this stuff here ... 
	cssClass = cssClass.toLowerCase();
	if (cssClass.indexOf(".") !== 0)
	{
		cssClass = "."+cssClass;
	}
	if (ignoreCache)
	{
		var rule = nitobi.html.Css.getRule(cssClass);
		if (rule != null)
			return rule.style;
	}
	else 
	{
		if (nitobi.html.Css.classCache[cssClass] == null)
		{
			var rule = nitobi.html.Css.getRule(cssClass);
			if (rule != null)
				nitobi.html.Css.classCache[cssClass] = rule.style;
			else 
				return null;
		}
		return nitobi.html.Css.classCache[cssClass];
	}
};

/**
 * This hash is used to keep track of already found classes in CSS
 * @private
 */
nitobi.html.Css.classCache = {};

/**
 * @ignore
 * @private
 */
nitobi.html.Css.getStyleBySelector = function(sSelector)
{
	var rule = nitobi.html.Css.getRule(sSelector);
	if (rule != null)
		return rule.style;
	return null;
}

/**
 * Returns the <CODE>Rule</CODE> object that has the cssClass as the only selector.
 * @param {String} cssClass The name of the class for which the style should be returned.
 * @type CSSStyleRule
 */
nitobi.html.Css.getRule = function(cssClass)
{
	cssClass = cssClass.toLowerCase();
	if (cssClass.indexOf(".") !== 0)
		cssClass = "."+cssClass;
	var stylesheets = document.styleSheets;
	for (var ss = 0; ss < stylesheets.length; ss++) {
		try
		{
			var inSheet = nitobi.html.Css.findInSheet(cssClass,stylesheets[ss]);
			if (inSheet) return inSheet;
		}
		catch(err)
		{
			// Fall through. Might just be permissions error.
		}
	}
	return null;
}

/**
 * Returns the value for the specified style of the CSS class selector where the selector is the specified class name.
 * The following would return the value of "red":
 * @example
 * &lt;style&gt;.myClass {color:red;}&lt;/style&gt;
 * &lt;script&gt;nitobi.html.Css.getClassStyle("myClass","color");&lt;/script&gt;
 * @param {String} cssClassName The name of the class used in the CSS selector.
 * @param {String} style The name of the style property to return.
 * @type String
 */
nitobi.html.Css.getClassStyle = function(cssClassName, style)
{
	var cssClass = nitobi.html.Css.getClass(cssClassName);
	if (cssClass != null)
		return cssClass[style];
	else
		return null;
}

/**
 * Sets the value of a particular style property. The style rule
 * is written in the CSS syntax, e.g., background-color instead of
 * backgroundColor.
 * @param {HTMLElement} el The element on which to set the style.
 * @param {String} rule The css rule to change.
 * @param {String} value The value to change the style to.
 */ 
nitobi.html.Css.setStyle = function (el, rule, value)
{
	rule = rule.replace(/\-(\w)/g, function (strMatch, p1){
            return p1.toUpperCase();
        });
	el.style[rule] = value;
}

/**
 * Gets the value of the specified element and style property.
 * @param {HTMLElement} oElem The HTML element one wants the style value for.
 * @param {String} sCssRule The style property one wants the value for.
 * @type String
 *
 */
nitobi.html.Css.getStyle = function (oElm, sCssRule){
    var strValue = "";
    if(document.defaultView && document.defaultView.getComputedStyle)
    {
    	// This is for MOZ.
    	// Put the dashes in if there are capital letters.
    	sCssRule = sCssRule.replace(/([A-Z])/g, function ($1){
            return "-" + $1.toLowerCase();
        });
        strStyle = document.defaultView.getComputedStyle(oElm, null);
        strValue = strStyle.getPropertyValue(sCssRule);
    }
    else if(oElm.currentStyle){
        sCssRule = sCssRule.replace(/\-(\w)/g, function (strMatch, p1){
            return p1.toUpperCase();
        });
        strValue = oElm.currentStyle[sCssRule];
    }
    return strValue;
};

/*

nitobi.dom.getStyle = function (oElm, strCssRule)
{
    var strValue = "";
	if (oElm.style[strCssRule])
	{
		// inline style property
		return oElm.style[strCssRule];
	}
	else if (oElm.currentStyle)
	{
		// external stylesheet for Explorer
        strCssRule = strCssRule.replace(/([A-Z])/g, "-$1");
        strValue = oElm.currentStyle[strCssRule];
	}
	else if(document.defaultView && document.defaultView.getComputedStyle)
    {
		strValue = document.defaultView.getComputedStyle(oElm, "").getPropertyValue(strCssRule);
    }
    if (strValue == 'auto' && console != null)

    return strValue;
}
 */

/**
 * Sets the opacity of an Array of elements using {@link nitobi.html.Css#setOpacity}
 * @param {Array} elements the HTML elements to change the opacity of
 * @param {Number} opacity the new opacity for these elements (0-100) 
 */

nitobi.html.Css.setOpacities = function(elements,opacity)
{
	if (elements.length)
	{
		for (var i=0;i<elements.length;i++)
		{
			nitobi.html.Css.setOpacity(elements[i],opacity);
		}
	}
	else
	{
		nitobi.html.Css.setOpacity(elements,opacity);
	}
}

/**
 * Sets the opacity of an element.
 * @param {HTMLElement} element The element on which to set the opacity.
 * @param {Number} opacity The opacity, 0 - 100;
 */
nitobi.html.Css.setOpacity = function(element, opacity)
{
    var s = element.style;
    if (opacity > 100)
    {
    	opacity = 100;
    }
    if (opacity < 0)
    {
    	opacity = 0;
    }
    if (s.filter != null)
    {
    	var match = s.filter.match(/alpha\(opacity=[\d\.]*?\)/ig);
    	if (match != null && match.length > 0)
    	{
			s.filter = s.filter.replace(/alpha\(opacity=[\d\.]*?\)/ig,"alpha(opacity=" + opacity + ")");
    	}
    	else
    	{
    		s.filter += "alpha(opacity=" + opacity + ")";
    	}
    }
    else
    {
		s.opacity = (opacity / 100);
    }
}

/**
 * Gets the opacity (0-100) of an element. This depends on the element having both a 
 * Mozilla and IE6 opacity set.
 * @param {HTMLElement} element the element to inspect
 * @type Number
 */
nitobi.html.Css.getOpacity = function(element)
{
	if (element == null)
	{
		nitobi.lang.throwError(nitobi.error.ArgExpected + " for nitobi.html.Css.getOpacity");
	}
	if (nitobi.browser.IE)
	{
		if (element.style.filter=="") return 100;
		var s = element.style.filter;
		s.match(/opacity=([\d\.]*?)\)/ig);
		if (RegExp.$1 == "") return 100;
		return parseInt(RegExp.$1);
	}
	else
	{
		return Math.abs(element.style.opacity ? element.style.opacity * 100 : 100);
	}
}

/**
 * @ignore
 * @private
 */
nitobi.html.Css.getCustomStyle = function(className, style)
{
	if (nitobi.browser.IE)
	{
		return nitobi.html.getClassStyle(className, style);
	}
	else
	{
		// Do a replace on <!--nitobi.grid.xslProcessorName--> and merge the contents
		// The second block does this for escaped XSL
		var rule = nitobi.html.Css.getRule(className);
		var re = new RegExp('(.*?)(\{)(.*?\)(\})', 'gi');
		var matches = rule.cssText.match(re);
	
		re = new RegExp('('+style+')(\:)(.*?\)(\;)', 'gi');
		matches = re.exec(RegExp.$3);
	
	/*
		nitobi.temp.xsl2 = "";
		if (exprMatches != null)
		{
			for (var i=0; i&lt;exprMatches.length; i++)
			{
				var incl = exprMatches[i].replace("&lt;!--","").replace("--&gt;","");
				// Get the imported stylesheet and remove the outer stylesheet element
				try {
					nitobi.temp.xsl2 = eval(incl).stylesheet.xml;
				} catch(e) {
					continue;
				}
				nitobi.temp.xsl2 = nitobi.temp.xsl2.replace(/\&lt;xsl:stylesheet.*?\&gt;/g,'');
				nitobi.temp.xsl2 = nitobi.temp.xsl2.replace(/\&lt;\/xsl:stylesheet\&gt;/g,'');
	
				nitobi.temp.xsl1 = nitobi.temp.xsl1.replace('&lt;!--'+incl+'--&gt;', nitobi.temp.xsl2);
			}
		}
		*/
	}
}

nitobi.html.Css.createStyleSheet = function(cssText)
{
	var ss;
	if (nitobi.browser.IE)
	{
		ss = document.createStyleSheet();
	}
	else
	{
		ss = document.createElement('style');
		ss.setAttribute("type", "text/css");
		document.body.appendChild(ss);
		ss.appendChild(document.createTextNode(""));
	}
	if (cssText != null)
		nitobi.html.Css.setStyleSheetValue(ss, cssText);
	return ss;
}

nitobi.html.Css.setStyleSheetValue = function(ss, cssText)
{
	if (nitobi.browser.IE)
		ss.cssText = cssText;
	else		
		ss.replaceChild(document.createTextNode(cssText), ss.firstChild);
	return ss;
}

if (nitobi.browser.MOZ)
{
	/**
	 * @private
	 * @ignore
	 */	
	HTMLStyleElement.prototype.__defineSetter__("cssText", function (param) {this.innerHTML = param;});

	/**
	 * @private
	 * @ignore
	 */
	HTMLStyleElement.prototype.__defineGetter__("cssText", function () {return this.innerHTML;});
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.drawing");

if (false)
{
	/**
	 * @namespace The namespace for drawing functions/classes.
	 * @constructor
	 */
	nitobi.drawing = function() {};
}

/**
 * Creates a point that manages x,y coordinates.
 * @class A class that represents a two-dimensional coordinate.
 * @constructor
 * Contains (x,y) pairs accessable via their respective properties: samplePoint.x and samplePoint.y
 * @param {Number} x The x coordinate.
 * @param {Number} y The y coordinate.
 */
nitobi.drawing.Point = function(x,y)
{
	this.x = x;
	this.y = y;
};

/**
 * Converts the point to a string, e.g. "(4,2)"
 * @type String
 */
nitobi.drawing.Point.prototype.toString = function()
{
	return "("+this.x+","+this.y+")";
};

/**
 * Returns the hex representation of a colour defined in rgb.
 * @param {Number} r The red value.
 * @param {Number} g The green value.
 * @param {Number} b The blue value.
 * @type String
 */
nitobi.drawing.rgb = function(r,g,b) 
{
  	return "#"+((r*65536)+(g*256)+b).toString(16);
}

/**
 * Aligns two DOM nodes on in the web browser.
 * @example
 * var header = $ntb("header");
 * var title = $ntb("title");
 * nitobi.drawing.align(header, title, nitobi.drawing.align.ALIGNRIGHT);
 * @param {HtmlElement} source The element to align.
 * @param {HtmlElement} target The reference element to align against.
 * @param {BitMask} align A value defining how to align the two elements.  Can be of the
 * following values:
 * <ul>
 * 	<li>nitobi.drawing.align.SAMEHEIGHT</li>
 * 	<li>nitobi.drawing.align.SAMEWIDTH</li>
 * 	<li>nitobi.drawing.align.ALIGNTOP</li>
 * <li>nitobi.drawing.align.ALIGNBOTTOM</li>
 * <li>nitobi.drawing.align.ALIGNLEFT</li>
 * <li>nitobi.drawing.align.ALIGNRIGHT</li>
 * <li>nitobi.drawing.align.ALIGNMIDDLEVERT</li>
 * <li>nitobi.drawing.align.ALIGNMIDDLEHORIZ</li>
 * </ul>
 * @param {Number} oh The height offset for the target HtmlElement.
 * @param {Number} ow The width offset for the target HtmlElement.
 * @param {Number} oy The left offset for the target HtmlElement.
 * @param {Number} ox The top offset for the target HtmlElement.
 */
nitobi.drawing.align = function(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox)
{
	oh=oh || 0;
	ow=ow || 0;
	oy=oy || 0;
	ox=ox || 0;
	var a=AlignBit_HWTBLRCM;
	var td,sd,tt,tb,tl,tr,th,tw,st,sb,sl,sr,sh,sw;

	if (true)
	{

		//	this is for IE
		td=target.getBoundingClientRect();
		sd=source.getBoundingClientRect();
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
//	else if (document.getBoxObjectFor)
//	{
//		//	this is for Mozilla
//		td = document.getBoxObjectFor(target);
//		sd = document.getBoxObjectFor(source);
//
//		tt = td.y;
//		tl = td.x;
//		tw = td.width;
//		th = td.height;
//
//		st = sd.y;
//		sl = sd.x;
//		sw = sd.width;
//		sh = sd.height;
//	}
//	else
//	{
//    //Safari
//    td = nitobi.html.getCoords(target);
//		sd = nitobi.html.getCoords(source);
//
//		tt = td.y;
//		tl = td.x;
//		tw = td.width;
//		th = td.height;
//
//		st = sd.y;
//		sl = sd.x;
//		sw = sd.width;
//		sh = sd.height;
//	}
	var s = source.style;

	if (a&0x10000000) s.height = (th+oh)+'px'; // make same height
	if (a&0x01000000) s.width = (tw+ow)+'px'; // make same width
	if (a&0x00100000) s.top = (nitobi.html.getStyleTop(source)+tt-st+oy)+'px'; // align top
	if (a&0x00010000) s.top = (nitobi.html.getStyleTop(source)+tt-st+th-sh+oy)+'px'; // align bottom
	if (a&0x00001000) s.left = (nitobi.html.getStyleLeft(source)-sl+tl+ox)+'px'; // align left
	if (a&0x00000100) s.left = (nitobi.html.getStyleLeft(source)-sl+tl+tw-sw+ox)+'px'; // align right
	if (a&0x00000010) s.top = (nitobi.html.getStyleTop(source)+tt-st+oy+Math.floor((th-sh)/2))+'px'; // align middle vertically
	if (a&0x00000001) s.left = (nitobi.html.getStyleLeft(source)-sl+tl+ox+Math.floor((tw-sw)/2))+'px'; // align middle horizontally
}

/**
 * Bit mask for aligning two HtmlElements with the same height.
 */
nitobi.drawing.align.SAMEHEIGHT				=0x10000000;
/**
 * Bit mask for aligning two HtmlElements with the same width.
 */
nitobi.drawing.align.SAMEWIDTH				=0x01000000;
/**
 * Bit mask for aligning two HtmlElements to the same top edge.
 */
nitobi.drawing.align.ALIGNTOP				=0x00100000;
/**
 * Bit mask for aligning two HtmlElements to the same bottom edge.
 */
nitobi.drawing.align.ALIGNBOTTOM			=0x00010000;
/**
 * Bit mask for aligning two HtmlElements to the same left edge.
 */
nitobi.drawing.align.ALIGNLEFT				=0x00001000;
/**
 * Bit mask for aligning two HtmlElements to the same right edge.
 */
nitobi.drawing.align.ALIGNRIGHT				=0x00000100;
/**
 * Bit mask for aligning two HtmlElements to the same height.
 */
nitobi.drawing.align.ALIGNMIDDLEVERT		=0x00000010;
nitobi.drawing.align.ALIGNMIDDLEHORIZ		=0x00000001;

/**
 * I don't think is used anywhere...
 * @private
 */
nitobi.drawing.alignOuterBox = function(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox,show)
{
	oh=oh || 0;
	ow=ow || 0;
	oy=oy || 0;
	ox=ox || 0;

        /*
	if (nitobi.browser.moz)
	{
		//	this is for Mozilla
		td = document.getBoxObjectFor(target);
		sd = document.getBoxObjectFor(source);

		var borderLeftTarget = parseInt(document.defaultView.getComputedStyle(target, '').getPropertyValue('border-left-width'));
		var borderTopTarget = parseInt(document.defaultView.getComputedStyle(target, '').getPropertyValue('border-top-width'));

		var borderTop = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-top-width'));
		var borderBottom = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-bottom-width'));

		var borderLeft = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-left-width'));
		var borderRight = parseInt(document.defaultView.getComputedStyle(source, '').getPropertyValue('border-right-width'));

		oy = oy + borderTop - borderTopTarget;
		ox = ox + borderLeft - borderLeftTarget;
	}
        */

	nitobi.drawing.align(source,target,AlignBit_HWTBLRCM,oh,ow,oy,ox,show);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.html");

// This is required for namespace docs.
if (false)
{
	/**
	 * @namespace This namespace contains methods and classes having to do with HTML DOM modification and
	 * inspection.
	 * @constructor
	 */
	nitobi.html = function(){};
}

/**
 * Creates a new HTML element with the specified tag name, attributes and styles.
 * @param {String} tagName The name of the element to create such as "div" or "span".
 * @param {Map} attrs A hash of name/value pairs of attributes to set such as {"id":"myDiv","class":"myClass"}.
 * @param {Map} styles A hash of name/value pair of styles to set such as {"color":"red"}.
 * @type HTMLElement
 */
nitobi.html.createElement = function(tagName, attrs, styles)
{
	var elem = document.createElement(tagName);
	for (var attr in attrs)
	{
		if (attr.toLowerCase().substring(0,5) == "class")
			elem.className = attrs[attr];
		else
			elem.setAttribute(attr, attrs[attr]);
	}
	for (var style in styles)
	{
		elem.style[style] = styles[style];
	}
	return elem;
}

/**
 * Returns an HTML table element with a single cell.
 * @param {Map} attrs A hash of name/value pairs of attributes to set such as {"id":"myDiv","class":"myClass"}.
 * @param {Map} styles A hash of name/value pair of styles to set such as {"color":"red"}.
 * @type HTMLElement
 */
nitobi.html.createTable = function(attrs, styles)
{
	// TODO: could also pass in the number of cols / rows and use the proper table DOM methods to add rows / cols
	var table = nitobi.html.createElement("table", attrs, styles);
	var tablebody = document.createElement("tbody");
	var tabletr = document.createElement("tr");
	var tabletd = document.createElement("td");
	table.appendChild(tablebody);
	tablebody.appendChild(tabletr);
	tabletr.appendChild(tabletd);
	return table;	
}



/**
 * Sets the background image of a DIV when the image is a transparent PNG.
 * @param {HTMLElement} elem The HTML element to set the background on.
 * @param {String} src The path to the image.
 */
nitobi.html.setBgImage = function(elem, src) {
	var s = nitobi.html.Css.getStyle(elem, "background-image");
	if (s != "" && nitobi.browser.IE) {
		s = s.replace(/(^url\(")(.*?)("\))/,"$2");
//		elem.style.backgroundImage = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+src+"', sizingMethod='crop');";
	}
}

/**
 * Adjusts the <code>child</code> element to have the same width as the <code>parent</code> element
 * taking into account the browser doctype as well as any borders or padding.
 * @param {HTMLElement} parent The element that the <code>child</code> element width should fill.
 * @param {HTMLElement} child The element that should have the width changed on to fit inside the <code>parent</code> element.
 */
nitobi.html.fitWidth = function(parent, child){
	var w;
	var C = nitobi.html.Css;
	if (nitobi.browser.IE && !nitobi.lang.isStandards()) {
		var theWidth = (parseInt(C.getStyle(parent, "width")) - parseInt(C.getStyle(parent, "paddingLeft")) - parseInt(C.getStyle(parent, "paddingRight")) - parseInt(C.getStyle(parent, "borderLeftWidth")) - parseInt(C.getStyle(parent, "borderRightWidth")));
		if (theWidth < 0) 
			theWidth = 0;
		w = theWidth + "px";
	}
	else {
		if (nitobi.lang.isStandards()) {
			if (nitobi.browser.IE) {
				//TO-DO: Fix this so it uses nitobi.html.Css
				var theWidth = (parseInt(parent.clientWidth)) - (child.offsetWidth - child.clientWidth);
			}
			else {
				var theWidth = (parseInt(parent.style.width) - (child.offsetWidth - parseInt(parent.style.width)));
			}
			
			if (theWidth < 0) 
				theWidth = 0;
			w = theWidth + "px";
		}
		else {
			w = parseInt(parent.style.width) + "px";
		}
	}
	child.style.width = w;
}

/**
 * @private
 */
nitobi.html.getDomNodeByPath = function (Node,Path)
{
	// This function traverses the DOM tree based on a Path comprised of ordinal indexes delimited by slash ( / ) characters
	// Example : Path = "0/1/0/5" - This would return the sixth child (5+1  because its zero based) or the first child or the second child of the first child of the parent node. 
	if (nitobi.browser.IE) {
//		Path="/"+Path;
	}
	var curNode = Node;
//	Path=Path.substr(Path.indexOf("/")+1);
	var subPaths=Path.split("/");
	var len = subPaths.length;
	for (var i=0; i<len; i++) {
//	if (nitobi.browser.IE) {
		if (curNode.childNodes[Number(subPaths[i])]!=null) {
			curNode = curNode.childNodes[Number(subPaths[i])];
		} else {
			alert("Path expression failed." + Path);
		}
		var s="";
	}
	return curNode;
}

/**
 * Returns the index of the child node in the parent collection. -1 if not found.
 * @type Number
 * @param {HTMLElement} parent The parent to search through.
 * @param {HTMLElement} child The child whose index you want to find.
 */
nitobi.html.indexOfChildNode = function(parent,child)
{
	var childNodes = parent.childNodes;
	for (var i=0; i < childNodes.length;i++)
	{
		if (childNodes[i] == child)
		{
			return i;
		}
	}
	return -1;
}

/**
 * Recursively evaluates all script blocks in the node.  All script blocks in the node
 * and the nodes children are evaluated.
 * @param {HTMLElement} node The node containing script blocks.
 */
nitobi.html.evalScriptBlocks = function(node)
{
	for (var i =0; i < node.childNodes.length; i++)
	{
		var childNode = node.childNodes[i];
		if (childNode.nodeName.toLowerCase() == "script")	
		{
			eval(childNode.text);
		}
		else
		{
			nitobi.html.evalScriptBlocks(childNode);			
		}
	}
}

/**
 * Positions this node relatively if it has no set position.
 * @param {HTMLElement} node 
 */
nitobi.html.position = function(node)
{
	var pos = nitobi.html.getStyle($ntb(node), 'position');
	if ( pos == 'static' ) node.style.position = 'relative';
};

/**
 * Sets the opacity of an element. 
 * @deprecated Use nitobi.html.Css.setOpacity instead.
 * @param {Element} element The element on which to set the opacity.
 * @param {int} opacity The opacity, 0 - 100;
 */
nitobi.html.setOpacity = function(element,opacity)
{
    var objectStyle = element.style;
    objectStyle.opacity = (opacity / 100);
    objectStyle.MozOpacity = (opacity / 100);
    objectStyle.KhtmlOpacity = (opacity / 100);
    objectStyle.filter = "alpha(opacity=" + opacity + ")";	
}

/**
 * @private
 */
nitobi.html.highlight = function(o,x,end)
{
	end = end || o.value.length;
	if(o.createTextRange)
	{
		// Make sure the object has the focus, otherwise you select the whole page.
		o.focus();
		// Create the text range based off the original object so as to avoid weird IE browser window shift bugs.
		var r=o.createTextRange();
		r.move("character",0-end);
		r.move("character",x);
		r.moveEnd("textedit",1);
		r.select();
	}else if(o.setSelectionRange){
		o.focus();
		o.setSelectionRange(x,end);
	}
}

/**
 * @private
 */
nitobi.html.setCursor = function(o,x)
{
	if(o.createTextRange)
	{
		// Make sure the object has the focus, otherwise you select the whole page.
		o.focus();
		// Create the text range based off the original object so as to avoid weird IE browser window shift bugs.
		var r=o.createTextRange();
		r.move("character",0-o.value.length);
		r.move("character",x);
		r.select();
	}else if(o.setSelectionRange){
		o.setSelectionRange(x,x);
	}
}

/**
 * @ignore
 */
nitobi.html.getCursor = function(o)
{
	if(o.createTextRange)
	{
		// Make sure the object has the focus, otherwise you select the whole page.
		o.focus();
		var r=document.selection.createRange().duplicate();
//		r.moveStart("textedit",-1);
//		return r.text.length;
// above doesn't work when user types too quickly; never
// figured why though... anyway, below works

// 2005.04.26
// first one doesn't work well in textareas; second one
// seems to work well w/ textboxes and textareas
//		r.moveEnd("textedit",1);
//		r.move("textedit",1);
// 2005.04.26b
// ARGG! only moveEnd works so that the typeahead bug doesn't
// come up -- TODO: investigate!
		r.moveEnd("textedit",1);

		return o.value.length - r.text.length;
	}else if(o.setSelectionRange){
		return o.selectionStart;
	}
	return -1;
}

/**
 * @private
 */
nitobi.html.encode = function(str)
{
	str += "";
	str = str.replace(/&/g,"&amp;");
	str = str.replace(/\"/g,"&quot;");
	str = str.replace(/'/g,"&apos;");
	str = str.replace(/</g,"&lt;");
	str = str.replace(/>/g,"&gt;");
	str = str.replace(/\n/g,"<br>");
	return str;
}

/**
 * Returns a DOM element from either a DOM element or an element ID.
 * @para {Object} element The element can be either a DOM element or an element ID.
 * @type HTMLElement
 */
nitobi.html.getElement = function(element)
{
	if (typeof(element) == "string")
		return document.getElementById(element);
	return element;
};

if (typeof($) == "undefined")
{
	/**
	 * Returns a DOM element from either a DOM element or an element ID.  A shorthand for this function
	 * is the dollar sign ($).  IE: <code>nitobi.html.getElement('myId') == $ntb('myId')
	 * @param {Object} element The element can be either a DOM element or an element ID.
	 * @type HTMLElement
	 */
	$ = nitobi.html.getElement;
}

/*
 * We have the $ntb command that allows us to get around jQuery and how it
 * overrides the $ command.  This will allow us to insulate ourselves a bit
 */

if (typeof($ntb) == "undefined")
{
  $ntb = nitobi.html.getElement;
}


if (typeof($F) == "undefined")
{
	/**
	 * Returns the value of a form field.
	 * @param {String} id The ID of the DOM form element for which the value is wanted.
	 * @type {String}
	 */
	$F = function(id)
	{
		var field = $ntb(id);
		if (field != null)
			return field.value;
		return "";
	}
}

/**
 * Return the tagname with the namespace prefix, if it has one.
 * @param {HTMLElement} elem The HTML element.
 * @type String
 */
nitobi.html.getTagName = function(elem)
{
	if (nitobi.browser.IE && elem.scopeName != "")
	{
		return (elem.scopeName + ":" + elem.nodeName).toLowerCase();
	}
	else
	{
		return elem.nodeName.toLowerCase();
	}
}

/**
 * Returns the style top of an element as a number. 	 is the top
 * specified on the style.  If none has been specified, zero is returned.
 * @param {HTMLElement} elem the element to inspect
 * @type Number
 */
nitobi.html.getStyleTop = function(elem)
{
	var top = elem.style.top; 
	if (top == "")
		top = nitobi.html.Css.getStyle(elem, "top");
	return nitobi.lang.parseNumber(top);
}

/**
 * Returns the style left of an element as a number. This is the left
 * specified on the style.  If none has been specified, zero is returned.
 * @param {HTMLElement} elem the element to inspect
 * @type Number
 */
nitobi.html.getStyleLeft = function(elem)
{
	var left = elem.style.left; 
	if (left == "")
		left = nitobi.html.Css.getStyle(elem, "left");
	return nitobi.lang.parseNumber(left);
}

/**
 * Returns the offsetHeight of an element in pixels.
 * @param {HTMLElement} elem the element to inspect
 * @type Number
 */
nitobi.html.getHeight = function(elem)
{
	// used to use getBoundingClientRect but that is slow
	return elem.offsetHeight;
}

/**
 * Returns the offsetWidth of an element in pixels.
 * @param {HTMLElement} elem the element to inspect
 * @type Number
 */
nitobi.html.getWidth = function(elem)
{
	// used to use getBoundingClientRect but that is slow
	return elem.offsetWidth;
}

if (nitobi.browser.IE||nitobi.browser.MOZ)
{
	/**
	 * Returns an associative array containing position and dimensions of the box for the specified element. 
	 * Returns the box struct that includes the top, left, bottom, right, height and width properties as numbers.
	 * Note: in mozilla, this only work if the box-model is set to border.
	 * @param {HTMLElement} elem The element for which you want a box.
	 * @type {Object}
	 */
	nitobi.html.getBox = function(elem)
	{
		var borderTop = nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-top-width"));
		var borderLeft = nitobi.lang.parseNumber(nitobi.html.getStyle(document.body,"border-left-width"));
		var fixTop = nitobi.lang.parseNumber(document.body.scrollTop) - (borderTop == 0 ? 2 : borderTop);
		var fixLeft = nitobi.lang.parseNumber(document.body.scrollLeft) - (borderLeft == 0 ? 2 : borderLeft);
		var rect = nitobi.html.getBoundingClientRect(elem);
		return {top: rect.top + fixTop , 
				left: rect.left + fixLeft , 
				bottom: rect.bottom, 
				right: rect.right,
				height: rect.bottom - rect.top,
				width: rect.right - rect.left};	
	}
}/*
else if	(nitobi.browser.MOZ)
{

	nitobi.html.getBox = function(elem)
	{
		var fixTop = 0;
		var fixLeft = 0;
		var parent = elem.parentNode;
		while (parent.nodeType == 1  && parent != document.body)
		{
			//if (nitobi.html.getBox.cache[parent] == null || true)
			//{
				fixTop += nitobi.lang.parseNumber(parent.scrollTop) 
							- (nitobi.html.getStyle(parent,"overflow") == "auto" ? nitobi.lang.parseNumber(nitobi.html.getStyle(parent,"border-top-width")) :0);
				fixLeft += nitobi.lang.parseNumber(parent.scrollLeft) 
							 - (nitobi.html.getStyle(parent,"overflow") == "auto" ? nitobi.lang.parseNumber(nitobi.html.getStyle(parent,"border-left-width")) :0);
				
			// This caching needs work.
			/*	nitobi.html.getBox.cache[parent] = {};
				nitobi.html.getBox.cache[parent].left = fixLeft;
				nitobi.html.getBox.cache[parent].top = fixTop;
			}
			else
			{
				// Cache hit
				fixTop += nitobi.html.getBox.cache[parent].top;
				fixLeft += nitobi.html.getBox.cache[parent].left;
				break;
			}*//*
			parent = parent.parentNode;
		}
		
		var mozBox = elem.ownerDocument.getBoxObjectFor(elem);
		var borderLeft = nitobi.lang.parseNumber(nitobi.html.getStyle(elem,"border-left-width"))
		var borderRight = nitobi.lang.parseNumber(nitobi.html.getStyle(elem,"border-right-width"))
		var borderTop = nitobi.lang.parseNumber(nitobi.html.getStyle(elem,"border-top-width"))
		var top = nitobi.lang.parseNumber(mozBox.y)  - fixTop - borderTop;
		var left = nitobi.lang.parseNumber(mozBox.x) - fixLeft - borderLeft;
		var right = left + nitobi.lang.parseNumber(mozBox.width); 
		var bottom = top + mozBox.height;
		var height = nitobi.lang.parseNumber(mozBox.height);
		var width = nitobi.lang.parseNumber(mozBox.width);

		return {top: top, 
				left: left, 
				bottom: bottom, 
				right: right,
				height: height,
				width: width};	
	}
	nitobi.html.getBox.cache = {};
}*/
else if (nitobi.browser.SAFARI || nitobi.browser.CHROME)
{
	/**
	 * @ignore
	 */
	nitobi.html.getBox = function(elem)
	{
		var coords = nitobi.html.getCoords(elem);
		return {top: coords.y, 
				left: coords.x, 
				bottom: coords.y+coords.height, 
				right: coords.x+coords.width,
				height: coords.height,
				width: coords.width};
	}
}


// Used for combo box.
nitobi.html.getBox2 = nitobi.html.getBox;

/**
 * Gets the element unique ID and creates one if it does not already exist.
 * @param {HTMLElement} elem The element from which we want the unique ID.
 * @type Number
 */
nitobi.html.getUniqueId = function(elem)
{
	if (elem.uniqueID)
	{
		return elem.uniqueID;
	}
	else
	{
		var t = (new Date()).getTime();
		// The element should remember the unique id since it is assigned once and based on time.
		elem.uniqueID = t;
		return t;
	}
}

/**
 * Gets a child element of the current element with the specified ID.
 * @param {HTMLElement} elem The element from which to start searching.
 * @param {String} childId The ID of the child element being searched for.
 * @param {Boolean} deepSearch Searches more than one level of depth.
 * @type HTMLElement
 */
nitobi.html.getChildNodeById = function(elem, childId, deepSearch)
{
	return nitobi.html.getChildNodeByAttribute(elem,"id",childId,deepSearch);
}

/**
 * Gets a child element of the current element with the specified attribute name and value.
 * @param {HTMLElement} elem The element from which to start searching.
 * @param {String} attName The name of the child element attribute searched for.
 * @param {String} attValue The value of the child element attribute searched for.
 * @param {Boolean} deepSearch Searches more than one level of depth.
 * @type HTMLElement
 */
nitobi.html.getChildNodeByAttribute = function(elem,attName,attValue,deepSearch)
{
	for (var i=0;i<elem.childNodes.length;i++)
	{
		if (elem.nodeType != 3 && Boolean(elem.childNodes[i].getAttribute))
		{
			 if (elem.childNodes[i].getAttribute(attName) == attValue)
			 {
				return elem.childNodes[i];
			 }
		}
	}
	
	if (deepSearch)
	{
		for (var i=0;i<elem.childNodes.length;i++)
		{
			var child = nitobi.html.getChildNodeByAttribute(elem.childNodes[i],attName,attValue,deepSearch);
			if (child != null) return child;
		}
	}
	return null;
}

/**
 * Gets the parent element of specified element where the element ID is equal to that specified.
 * @param {HTMLElement} elem The element from which the parent element should be searched for.
 * @param {String} parentId The ID of the parent element that is being searched for.
 * @type HTMLElement
 */
nitobi.html.getParentNodeById = function(elem,parentId)
{
	return nitobi.html.getParentNodeByAtt(elem,"id",parentId);
}

/**
 * Gets the parent element of specified element where the element ID is equal to that specified.
 * @param {HTMLElement} elem The element from which the parent element should be searched for.
 * @param {String} att The name of the attribute.
 * @param {String} value The value of the attribute of the parent element that is being searched for.
 * @type HTMLElement
 */
nitobi.html.getParentNodeByAtt = function(elem,att,value)
{
	while(elem.parentNode != null)
	{
		if (elem.parentNode.getAttribute(att) == value)
		{
			return elem.parentNode;
		}
		elem = elem.parentNode;
	}	
	return null;
}

if (nitobi.browser.IE)
{
	/**
	 * Gets the first child element that is of type HTMLElement since Firefox also considers whitespace and other nodes in the native firstChild property.
	 * @param {HTMLElement} node The element for which the first child is requested.
	 * @type HTMLElement
	 */
	nitobi.html.getFirstChild = function(node)
	{
		return node.firstChild;
	}
}
else
{
	/**
	 * @ignore
	 */
	nitobi.html.getFirstChild = function(node)
	{
		var i = 0;
		while (i < node.childNodes.length && node.childNodes[i].nodeType == 3)
			i++;
		return node.childNodes[i];
	}
}

/**
 * Gets the scroll positions of the current document and returns a struct like {"left":0,"top":0}.
 * @type Map
 */
nitobi.html.getScroll = function()
{
	var ResultScrollTop, ResultScrollLeft = 0;
	//console.log(document.documentElement.clientHeight);
	if ((nitobi.browser.OPERA == false) && (document.documentElement.scrollTop > 0)) {
		ResultScrollTop = document.documentElement.scrollTop;
		ResultScrollLeft = document.documentElement.scrollLeft;	
	} else {
		ResultScrollTop = document.body.scrollTop;
		ResultScrollLeft = document.body.scrollLeft;
	}

	if (((ResultScrollTop == 0) && (document.documentElement.scrollTop > 0)) ||  ((ResultScrollLeft == 0) && (document.documentElement.scrollLeft > 0))){
		ResultScrollTop = document.documentElement.scrollTop;
		ResultScrollLeft = document.documentElement.scrollLeft;
	}

	return {"left":ResultScrollLeft,"top":ResultScrollTop}
}

/**
 * Returns an associative array containing position and dimensions of the box for the specified element.
 * The return value is a struct with the following structure {x:0,y:0,height:0,width:0}. 
 * @param {HTMLElement} elem The element for which you want a box.
 * @type Map
 */
nitobi.html.getCoords = function(element)
{
   var ew, eh;
   try {
       var originalElement = element;
       ew = element.offsetWidth;
       eh = element.offsetHeight;
       for (var lx=0,ly=0;element!=null;
           lx+=element.offsetLeft,ly+=element.offsetTop,element=element.offsetParent);
       for (;originalElement!=document.body;
           lx-=originalElement.scrollLeft,ly-=originalElement.scrollTop,originalElement=originalElement.parentNode);
   } catch(e) {}
   return {"x":lx,"y":ly,"height":eh,"width":ew}
};

/**
 * The cached scroll bar width.
 * @type Number
 * @private
 */
nitobi.html.scrollBarWidth = 0;
/**
 * Returns the width of a vertical scroll bar on the client's screen.  This measurement is 
 * variable depending on the platform, browser, and window theme.  This value will only be calculated once.
 * Thereafter, the cached version will be returned.
 * @param {HTMLElement} container a container to use for the temporary DOM structure (optional)
 * @type Number
 */
nitobi.html.getScrollBarWidth = function(container)
{
	if (nitobi.html.scrollBarWidth) return nitobi.html.scrollBarWidth;
	try{
		if (null==container)
		{
			var divId = "ntb-scrollbar-width";
			var d = document.getElementById(divId);

			if (null == d)
			{
				d = nitobi.html.createElement("div",{"id":divId},{width:"100px",height:"100px",overflow:"auto",position:"absolute",top:"-200px",left:"-5000px"});
				d.innerHTML = "<div style='height:200px;'></div>";
				document.body.appendChild(d);
			}
			container = d;
//			return(Math.abs(this.GetScrollBarWidth(d)));
		}
		if (nitobi.browser.IE||nitobi.browser.MOZ)
		{
			nitobi.html.scrollBarWidth = Math.abs(container.offsetWidth - container.clientWidth - (container.clientLeft ? container.clientLeft * 2 : 0));
		}/*
		else if (nitobi.browser.MOZ)
		{
			var b = document.getBoxObjectFor(container);
			nitobi.html.scrollBarWidth = Math.abs((b.width - container.clientWidth));
		}*/
		else if (nitobi.browser.SAFARI || nitobi.browser.CHROME)
		{
			var b = nitobi.html.getBox(container);
			nitobi.html.scrollBarWidth = Math.abs((b.width - container.clientWidth));
		}
	}catch(err){
		//TODO: Error reporting here.	
	}
	return nitobi.html.scrollBarWidth;
};
/**
 * @ignore
 * @private
 */
nitobi.html.align = nitobi.drawing.align;

/**
 * @ignore
 * @private
 */
nitobi.html.emptyElements = {
	HR: true, BR: true, IMG: true, INPUT: true
};

/**
 * @ignore
 * @private
 */
nitobi.html.specialElements = {
	TEXTAREA: true
};

/**
 * @ignore
 * @private
 */
nitobi.html.permHeight = 0;
/**
 * @ignore
 * @private
 */
nitobi.html.permWidth = 0;	

/**
 * Returns a collection containing scrollbar and client dimension details.
 * @type Map
 */
nitobi.html.getBodyArea = function()
{
	var scrollLeft,scrollTop,clientWidth,clientHeight;
	var x,y;
	var strict = false;

	if (nitobi.lang.isStandards()) {strict = true;}
	
	var de = document.documentElement;
	var db = document.body;
	if (self.innerHeight) // all except Explorer 
	{
		x = self.innerWidth;
		y = self.innerHeight;
	}
	else if (de && de.clientHeight)
		// Explorer 6 Strict Mode
	{
		x = de.clientWidth;
		y = de.clientHeight;
	}
	else if (db) // other Explorers
	{
		x = db.clientWidth;
		y = db.clientHeight;
	}
	clientWidth = x; clientHeight = y;

	if (self.pageYOffset) // all except Explorer
	{
		x = self.pageXOffset;
		y = self.pageYOffset;
	}
	else if (de && de.scrollTop)
		// Explorer 6 Strict
	{
		x = de.scrollLeft;
		y = de.scrollTop;
	}
	else if (db) // all other Explorers
	{
		x = db.scrollLeft;
		y = db.scrollTop;
	}	
	scrollLeft = x; scrollTop = y;

	var test1 = db.scrollHeight;
	var test2 = db.offsetHeight
	if (test1 > test2) // all but Explorer Mac
	{
		x = db.scrollWidth;
		y = db.scrollHeight;
	}
	else // Explorer Mac;
	     //would also work in Explorer 6 Strict, Mozilla and Safari
	{
		x = db.offsetWidth;
		y = db.offsetHeight;
	}	
	nitobi.html.permHeight = y; nitobi.html.permWidth = x;
	
	if (nitobi.html.permHeight < clientHeight) {
		nitobi.html.permHeight = clientHeight;
		if (nitobi.browser.IE && strict) {
			clientWidth += 20;
		}
	}
	
	if (clientWidth < nitobi.html.permWidth) {
		clientWidth = nitobi.html.permWidth;
	}
	
	if (nitobi.html.permHeight > clientHeight) {
		
		clientWidth += 20;
	}
	
	var scrollHeight, scrollWidth;
	scrollHeight = de.scrollHeight;
	scrollWidth = de.scrollWidth;
	

	return {scrollWidth:scrollWidth, scrollHeight:scrollHeight, scrollLeft:scrollLeft, scrollTop:scrollTop, clientWidth:clientWidth, clientHeight:clientHeight, bodyWidth:nitobi.html.permWidth, bodyHeight:nitobi.html.PermHeight}
}

/**
 * Gets the outer HTML for the node as per Internet Explorers outerHTML element property.
 * Note: Comment nodes are ignored.
 * @param {HTMLElement} node The element what one wants the outer HTML of.
 * @type String
 */
nitobi.html.getOuterHtml = function (node) 
{
	if (nitobi.browser.IE)
		return node.outerHTML;
	else
	{
		var html = '';
		  switch (node.nodeType) {
		case Node.ELEMENT_NODE:
		html += '<';
		html += node.nodeName.toLowerCase();
		if (!nitobi.html.specialElements[node.nodeName]) {
	      for (var a = 0; a < node.attributes.length; a++)
	        {
	        	if (node.attributes[a].nodeName.toLowerCase() != "_moz-userdefined")
	        	{
		          html += ' ' + node.attributes[a].nodeName.toLowerCase() +
		                  '="' + node.attributes[a].nodeValue + '"';
	            }
         	}
	        html += '>'; 
	        if (!nitobi.html.emptyElements[node.nodeName]) {
	          html += node.innerHTML;
	          html += '<\/' + node.nodeName.toLowerCase() + '>';
	        }
	      }
	      else switch (node.nodeName) {
	        case 'TEXTAREA':
	          for (var a = 0; a < node.attributes.length; a++)
	            if (node.attributes[a].nodeName.toLowerCase() != 'value')
	              html += ' ' + node.attributes[a].nodeName.toUpperCase() +
	                      '="' + node.attributes[a].nodeValue + '"';
	            else 
	              var content = node.attributes[a].nodeValue;
	          html += '>'; 
	          html += content;
	          html += '<\/' + node.nodeName + '>';
	          break; 
	      }
	      break;
	    case Node.TEXT_NODE:
	      html += node.nodeValue;
	      break;
	    case Node.COMMENT_NODE:
	      html += '<!' + '--' + node.nodeValue + '--' + '>';
	      break;
	  }
	  return html;
	}
}

/**
 * @private
 * @ignore
 */
nitobi.html.insertAdjacentText = function(sibling, pos, s)
{
	if (nitobi.browser.IE)
		return sibling.insertAdjacentText(pos,s);

	var node = document.createTextNode(s)
	nitobi.html.insertAdjacentElement(sibling,pos,node)
}

/**
 * @private
 * @ignore
 */
nitobi.html.insertAdjacentHTML = function(oNode, sWhere, sHTML, workaround)
{
	if (nitobi.browser.IE)
		return oNode.insertAdjacentHTML(sWhere, sHTML, workaround);

	var df;
	var r=oNode.ownerDocument.createRange();
	switch(String(sWhere).toLowerCase()) {
		case "beforebegin":
			r.setStartBefore(oNode);
			df = r.createContextualFragment(sHTML);
			oNode.parentNode.insertBefore(df, oNode);
			break;
		case "afterbegin":
			r.selectNodeContents(oNode);
			r.collapse(true);
			df = r.createContextualFragment(sHTML);
			oNode.insertBefore(df, oNode.firstChild);
			break;
		case "beforeend":
			// workaround==true:
			// we lose parsing feature of createContextualFragment but this seems
			// to fix the visual bug that occurs when the original code is used
			if(workaround==true){
				oNode.innerHTML = oNode.innerHTML + sHTML;
			} else {
				r.selectNodeContents(oNode);
				r.collapse(false);
				df = r.createContextualFragment(sHTML);
				oNode.appendChild(df);
			}
			break;
		case "afterend":
			r.setStartAfter(oNode);
			df = r.createContextualFragment(sHTML);
			oNode.parentNode.insertBefore(df, oNode.nextSibling);
			break;
	}
}

/**
 * @ignore
 * @private
 */
nitobi.html.insertAdjacentElement = function(sibling,pos,node)
{
	if (nitobi.browser.IE)
		return sibling.insertAdjacentElement(pos,node);

	switch (pos)
	{
		case "beforeBegin":
			sibling.parentNode.insertBefore(node,sibling)
			break;
		case "afterBegin":
			sibling.insertBefore(node,sibling.firstChild);
			break;
		case "beforeEnd":
			sibling.appendChild(node);
			break;
		case "afterEnd":
			if (sibling.nextSibling)
				sibling.parentNode.insertBefore(node,sibling.nextSibling);
			else
				sibling.parentNode.appendChild(node);
			break;
	}
}

//TODO: Do we need to take into account scrolling here?
/**
 * @private
 * @ignore
 */
nitobi.html.getClientRects = function(node, scrollTop, scrollLeft) 
{
	if (nitobi.browser.IE||nitobi.browser.MOZ)
		return node.getClientRects();
	
	scrollTop = scrollTop || 0;
	scrollLeft = scrollLeft || 0;
	var td;
	if (nitobi.browser.SAFARI||nitobi.browser.CHROME) {
		td = nitobi.html.getCoords(node);
		scrollTop = 0;
		scrollLeft = 0;
	}
	else
	{
		var td = document.getBoxObjectFor(node);
		//td = node.ownerDocument.getBoxObjectFor(node)
	}
	return new Array({top: (td.y - scrollTop), left: (td.x - scrollLeft), bottom: (td.y + td.height - scrollTop), right: (td.x + td.width - scrollLeft)});
}

/**
 * @private
 * @ignore
 */
nitobi.html.getBoundingClientRect = function(node,scrollTop, scrollLeft) 
{
	if (node.getBoundingClientRect)
		return node.getBoundingClientRect();

	scrollTop = scrollTop || 0;
	scrollLeft = scrollLeft || 0;
	var td;
	if (nitobi.browser.SAFARI||nitobi.browser.CHROME) {
		td = nitobi.html.getCoords(node);
		scrollTop = 0;
		scrollLeft = 0;
	}
	else
	{
		td = document.getBoxObjectFor(node);
	}
	var top = td.y-scrollTop;
	var left = td.x-scrollLeft;
	return {top: top, left: left, bottom: (top + td.height), right: (left + td.width)};
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * Creates an Event object that encapsulates an html event.  Is supplied as an argument to functions handling events issued
 * through the EventManager
 * @class nitobi.html.Event is a cross-browser, globally accessible event object which is set when DOM events are fired 
 * through the EventManager.
 * @constructor
 */
nitobi.html.Event = function(){
	/**
	 * The DOM element on which the event was fired. This is equivalent to the <code>target</code> property in 
	 * the Firefox and Safari browsers.
	 * @type String
	 */
	this.srcElement = null;
	/**
	 * The DOM element from which activation or the mouse pointer is exiting during the event. 
	 * This is useful for mouseout type events.
	 * @type String
	 */
	this.fromElement = null;
	/**
	 * The DOM element from which activation or the mouse pointer is entering during the event. 
	 * This is useful for mouseout type events.
	 * @type String
	 */
	this.toElement = null;
	/**
	 * The DOM element to which the event handler was attached.
	 * @type String
	 */
	this.eventSrc = null;
};

/**
 * @private
 */
nitobi.html.handlerId = 0;
/**
 * @private
 */
nitobi.html.elementId = 0;
/**
 * @private
 */
nitobi.html.elements = [];
/**
 * @private
 */
nitobi.html.unload = [];
/**
 * @private
 */
nitobi.html.unloadCalled = false;

/**
 * Attaches multiple events to a single element
 * @param {HtmlElement} element The HTML element to which the events should be attached.
 * @param {Struct} events Structs of the events with type and handler properties.
 * @param {Object} context The context in which the handlers should be executed.
 * @type {Array}
 * @return Returns an array of GUIDs that can be used to detach the event handlers.
 */
nitobi.html.attachEvents = function(element, events, context)
{
	var guids = [];
	for (var i=0; i<events.length; i++)
	{
		var e = events[i];
		guids.push(nitobi.html.attachEvent(element, e.type, e.handler, context, e.capture || false));
	}
	return guids;
}

// TODO: implement an attachEventOnce method that is like subscribeOnce - that would be sweet

/**
 * Attaches the specified handler to the DOM element for the specified event type.
 * Returns the guid of the attached event handler, which can be used to detach events.
 * @param {HtmlElement} element Element on which the event is to be registered.
 * @param {String} type Event type such as 'click', 'mouseover' etc. Note that the 'on' prefix is dropped.
 * @param {Object} [context] Object that the callback function will be called on.
 * @param {Function} handler Function pointer to the function that will handle the event.
 * @param {Boolean} [capture] Specifies if event capturing should be used.
 * @param {Object} [override]
 * @type {String}
 */
nitobi.html.attachEvent = function(element, type, handler, context, capture, override)
{
	if (type == "anyclick")
	{
		if (nitobi.browser.IE)
		{
			nitobi.html.attachEvent(element, "dblclick", handler, context, capture, override);
		}
		type = "click";
	} 
	if (!(handler instanceof Function))
	{
		nitobi.lang.throwError("Event handler needs to be a Function");
	}

	//	Allow people to pass in a node id or an actual DOM node.
	element = $ntb(element);

	// Divert unload attachments to custom unload registration
	if (type.toLowerCase() == 'unload' && override != true)
	{
		var funcRef = handler;
		if (context != null)
		{
			funcRef = function() {handler.call(context)};
		}
		return this.addUnload(funcRef);
	}

	//	Increment our unique id to keep it unique
	var handlerGuid = this.handlerId++;
	var elementGuid = this.elementId++;

	//	Check if the handler already has a guid or not
	//	The guid is used again when we detach the handler for an event
	if (typeof(handler.ebaguid) != "undefined")
	{
		handlerGuid = handler.ebaguid;
	}
	else
	{
		handler.ebaguid = handlerGuid;
	}

	//	Check the custom ebaguid property on the DOM Element object
	//	The ebaguid on the element is used to keep track of all elements that have had events attached
	if (typeof(element.ebaguid) == "undefined")
	{
		element.ebaguid = elementGuid;
		//	add a reference to the element in the elements hash - this could also just use array.push()
		nitobi.html.elements[elementGuid] = element;
	}

	//	The custom eba_events property on the DOM Element object contains
	//	all the events that have been registered on this element.
	if (typeof(element.eba_events) == "undefined")
	{
		element.eba_events = {};
	}

	//	The 'eba_events' property on the DOM node is a hash of the event type
	//	ie store all the handlers defined for event type 'mouseover' in another hash
	if (element.eba_events[type] == null)
	{
		element.eba_events[type] = {};

		//	Browser checking for IE / nitobi.browser.MOZ
		if (element.attachEvent)
		{
			// This maintains a reference to the closure we use as the event handler so we can clean it up later.
			element['eba_event_'+type] = function () {nitobi.html.notify.call(element, window.event)};
			//	Detach will need to be called to get rid of this closure...
			element.attachEvent('on'+type, element['eba_event_'+type]);

			if (capture && element.setCapture != null) element.setCapture(true);
		}
		else if (element.addEventListener)
		{
			// No need for this code really - only used for detachment purposes later.
			// If there are no more handlers attached for a certain event we clean things up by deleting this function reference.
			element['eba_event_'+type] = function () {nitobi.html.notify.call(element, arguments[0])};
			element.addEventListener(type, element['eba_event_'+type], capture);
		}
	}

	//	Once we get here the event has been hooked up 
	//	or it is already hooked up - either way we need to
	//	add the handler to the list of handlers to fire
	element.eba_events[type][handlerGuid] = {handler: handler, context: context};

	return handlerGuid;
}

/**
 * @private
 * The method that is used to handle all the DOM events and dispatch them accordingly.
 */
nitobi.html.notify = function(e)
{
	if (!nitobi.browser.IE)
	{
		e.srcElement = e.target;
		e.fromElement = e.relatedTarget;
		e.toElement = e.relatedTarget;
	}
	var element = this;
	e.eventSrc = element
	nitobi.html.Event = e;

	for (var handlerGuid in element.eba_events[e.type])
	{
		var event_ = element.eba_events[e.type][handlerGuid];
		if (typeof(event_.context) == "object")
		{
			//	Call the handler in the context of the object located in context.
			event_.handler.call(event_.context, e, element);
		}
		else
		{
			event_.handler.call(element, e, element);
		}
	}
}

/**
 * Detaches multiple events to a single element
 * 
 * @param {HTMLElement} element The HTML element to which the events should be detached from.
 * @param {Object} events Structs of the events with type and handler properties.
 */
nitobi.html.detachEvents = function(element, events)
{
	for (var i=0; i<events.length; i++)
	{
		var e = events[i];
		nitobi.html.detachEvent(element, e.type, e.handler);
	}
}

/**
 * Removes an event handler from an HTML element.
 * @param {HTMLElement} element The HTML element to remove the handler from.
 * @param {String} type The event type string such as "mouseover".
 * @param {Function | String} handler The event handler function reference or the GUID of the handler returned from the attachEvent function.
 * @see nitobi.html#attachEvent
 */
nitobi.html.detachEvent = function(element, type, handler)
{
	//	Allow either a node id or an actual DOM node.
	element = $ntb(element);

	// Allow either a Function with a guid or just the guid
	var handlerGuid = handler; 
	if (handler instanceof Function)
		handlerGuid = handler.ebaguid;

	// If it is for an unload event it is special.
	if (type == "unload")
	{
		this.unload.splice(ebaguid,1);
	}

	//	Check if the event type and handler combination are defined
	if (element != null && element.eba_events != null && element.eba_events[type] != null && element.eba_events[type][handlerGuid] != null)
	{

		var handlers = element.eba_events[type];
		// Remove it from the list of handlers
		handlers[handlerGuid] = null;
		delete handlers[handlerGuid];

		//	What actually needs to be done here is ..
		//	if this is the last handler for a certain event type on an element to be removed
		//	then we need to detach it...
		// element['eba_event_'+type]

		if (nitobi.collections.isHashEmpty(handlers))
		{
			this.m_detach(element, type, element['eba_event_'+type]);
     		element['eba_event_'+type] = null;
     		element.eba_events[type] = null;
     		handlers = null;
     		if (element.nodeType == 1)
         		element.removeAttribute('eba_event_'+type);
		}
	}
	return true;
}

/**
 * @private
 * Does the event detachment leg work for both detachAllEvents and detachEvent.
 */
nitobi.html.m_detach = function(element, type, handler)
{
	if (handler != null && handler instanceof Function)
	{
		//	Detach in IE
		if (element.detachEvent)
		{
			element.detachEvent('on' + type, handler)
		}
		//	Remove in Firefox
		else if (element.removeEventListener)
		{
			element.removeEventListener(type, handler, false);
		}
		element['on' + type] = null;
	
		if (type == "unload")
		{
			//	Here we are doing unload so call all the things that are manually registered for unload
			for (var i=0; i<this.unload.length; i++)
			{
				this.unload[i].call(this);
				this.unload[i] = null;
			}
		}
	}
}

/**
 * Detaches all the events that have been attached using the <CODE>nitobi.html.attachEvent</CODE> method.
 */
nitobi.html.detachAllEvents = function(evt)
{
	//	TODO: this needs to be fixed not to use the looping through the array and use the hash instead
	for (var i=0; i<nitobi.html.elements.length; i++)
	{
		if (typeof(nitobi.html.elements[i]) != "undefined")
		{
			for (var eventType in nitobi.html.elements[i].eba_events)
			{
				//	Need to detach the nitobi.html.event.notify method from the element.
				nitobi.html.m_detach(nitobi.html.elements[i], eventType, nitobi.html.elements[i]['eba_event_'+eventType]);

				if (typeof(nitobi.html.elements[i]) != "undefined" && nitobi.html.elements[i].eba_events[eventType] != null)
				{
					for (var handlerGuid in nitobi.html.elements[i].eba_events[eventType])
					{
						nitobi.html.elements[i].eba_events[eventType][handlerGuid] = null;
					}
				}
				nitobi.html.elements[i]['eba_event_'+eventType] = null;
			}
		}
	}
	nitobi.html.elements = null;
}

/**
 * Used to register unload events since using the standard attachEvent can be problematic for unload events.
 */
nitobi.html.addUnload = function(funcRef)
{
	this.unload.push(funcRef);
	return this.unload.length-1;
}

/**
 * Cancels the event provided as the single argument.
 * @param {nitobi.html.Event} evt The event that should be cancelled.
 */
nitobi.html.cancelEvent = function(evt)
{
	nitobi.html.stopPropagation(evt);
	nitobi.html.preventDefault(evt);
}

/**
 * Stops the event bubbling.
 * @param {nitobi.html.Event} The event that should be stopped.
 */
nitobi.html.stopPropagation = function(evt)
{
	if (evt == null)
		return;

	if (nitobi.browser.IE)
		evt.cancelBubble = true;
	else
		evt.stopPropagation();
}

/**
 * Prevents the event default behaviour from occuring.
 * @param {nitobi.html.Event} The event whose default behaviour should be prevented.
 */
nitobi.html.preventDefault = function(evt, v)
{
	if (evt == null)
		return;

	if (nitobi.browser.IE)
		evt.returnValue = false;
	else
		evt.preventDefault();
	
	if (v!=null)
		e.keyCode = v;
}

// TODO: create separate cancelBubble and preventDefault functions 

/**
 * The coordinates of the event in the format of <CODE>{"x":0,"y":0}</CODE>.
 * @param {nitobi.html.Event} That event object of the event for which the coordinates are required.
 * @type Object
 */
nitobi.html.getEventCoords = function(evt)
{
    var coords = {'x':evt.clientX,'y':evt.clientY};
    if (nitobi.browser.IE) 
    {
    	// TODO: document.body if not standards mode.
        coords.x += document.documentElement.scrollLeft + document.body.scrollLeft;
        coords.y += document.documentElement.scrollTop + document.body.scrollTop;
    }
    else
    {
        coords.x += window.scrollX;
        coords.y += window.scrollY;
    }

    return coords;
}

/**
 * Depending on the browser, return the event object for the event handler
 * in scope.
 * @param {Object} event The firefox event object.
 * @type Object
 */
nitobi.html.getEvent = function(event)
{
	if (nitobi.browser.IE)
	{
		return window.event;
	}
	else
	{
		// TODO: add in support for adding the proper event coords.
		event.srcElement = event.target;
		event.fromElement = event.relatedTarget;
		event.toElement = event.relatedTarget;
		return event;	
	}
}

/**
 *	createEvent is used to manually create and fire an event.
 * @private
 */
nitobi.html.createEvent = function(evtType, evtName, evtObj, params)
{
	if (nitobi.browser.IE)
	{
		//	need to re-factor this one ... 
		evtObj.target.fireEvent('on'+evtName);
	}
	else
	{
		// check out http://developer.mozilla.org/en/docs/DOM:document.createEvent#Notes
		// create and init a new event
		var newEvent = document.createEvent(evtType);
		newEvent.initKeyEvent(evtName, true, true, document.defaultView, evtObj.ctrlKey, evtObj.altKey, evtObj.shiftKey, evtObj.metaKey, params.keyCode, params.charCode);

		/*
		switch (evtType)
		{
			case "IUEvent":
				newEvent.initUIEvent(evtName, true, true, document.defaultView, 1);
				break;
			case "MouseEvents":
				newEvent.initMouseEvent(evtName, true, true, document.defaultView, 1, params.screenX, params.screenY, params.clientX, params.clientY, evtObj.ctrlKey, evtObj.altKey, evtObj.shiftKey, evtObj.metaKey, params.button, params.relatedTarget);
				break;
			case "TextEvent":
				newEvent.initTextEvent();
				break;
			case "MutationEvent":
				newEvent.initMutationEvent();
				break;
			case "KeyboardEvent":
			case "KeyEvents":
				newEvent.initKeyEvent(evtName, true, true, document.defaultView, evtObj.ctrlKey, evtObj.altKey, evtObj.shiftKey, evtObj.metaKey, params.keyCode, params.charCode);
				break;
			default:
				newEvent.initEvent(evtName, true, true);
				break;
		}
		*/

		// dispatch new event in old event's place
		evtObj.target.dispatchEvent(newEvent);
	}
}

//This ensures that all events registered through the event manager will be set free!
nitobi.html.unloadEventId = nitobi.html.attachEvent(window, "unload", nitobi.html.detachAllEvents, nitobi.html, false, true);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.event");

/**
 * @namespace nitobi.event is a cross-browser DOM and JavaScript event registration system. 
 * It is a global object and so the contstructor does not need to be called.
 * @constructor
 * @private
 */
nitobi.event = function(){};

/**
 * @private
 */
nitobi.event.keys = {};

/**
 * @private
 */
nitobi.event.guid = 0;

/**
 * @private
 */
nitobi.event.subscribe = function(key, method)
{
	ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was " + key);
	nitobi.event.publish(key);
	var guid = this.guid++;
	this.keys[key].add(method, guid);
	return guid;
}

/**
 * @private
 */
nitobi.event.unsubscribe = function(key, guid)
{
	ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was " + key);
	if (this.keys[key] == null) return true;
	if (this.keys[key].remove(guid)) {
		this.keys[key] = null;
		delete this.keys[key];
	}
}

/**
 * @private
 */
nitobi.event.evaluate = function(func, eventArgs)
{
	var retVal = true;
	if (typeof func == "string")
	{
		func = func.replace(/eventArgs/gi,"arguments[1]");
		var result = eval(func);
		retVal = (typeof(result)=="undefined"?true:result);
	}
	return retVal;
}

/**
 * @private
 */
nitobi.event.publish = function(key)
{
	ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was " + key);
	if (this.keys[key] == null) this.keys[key] = new nitobi.event.Key();
}

/**
 * @private
 */
nitobi.event.notify = function(key, evtArgs)
{
	ntbAssert(key.indexOf("undefined")==-1,"Something used nitobi.event with an invalid key. The key was " + key);
	if (this.keys[key] != null)
	{
		return this.keys[key].notify(evtArgs);
	}
	else
	{
		// TODO: Throw a warning message ... 
		return true;
	}
}

/**
 * @private
 */
nitobi.event.dispose = function()
{
	for (var key in this.keys)
	{
		if (typeof(this.keys[key]) == "function")
		{
			this.keys[key].dispose();
		}
	}
	this.keys = null;
}



/**
 * It contains an array of hanlders that require notification when the key is called to be notified
 * @class EventKey represents a key for publishing or subscribing to an event.
 * @constructor
 * @ignore
 * @private
 */
nitobi.event.Key = function()
{
	/**
	 * @private
	 */
	this.handlers = {};
}
/**
 * @private
 * @ignore
 */
nitobi.event.Key.prototype.add = function(method, guid)
{
	ntbAssert(method instanceof Function,'EventKey.add requires a JavaScript function pointer as a parameter.','',EBA_THROW);
	this.handlers[guid] = method;
}
/**
 * @private
 * @ignore
 */
nitobi.event.Key.prototype.remove = function(guid)
{
	this.handlers[guid] = null;
	delete this.handlers[guid];
	// return true if there are no more handlers
	var i=true;
	for (var item in this.handlers) {
		i=false;
		break;
	}
	return i;
}
/**
 * @private
 * @ignore
 */
nitobi.event.Key.prototype.notify = function(evtArgs)
{
	var fail = false;
	for (var item in this.handlers)
	{
		var handler = this.handlers[item];
		if (handler instanceof Function)
		{
			var rv = (handler.apply(this, arguments)==false);
			fail = fail || rv;
		}
		else
		{
			// ntbAssert(false,'There is no function','',EBA_THROW);
		}
	}
	return !fail;
}

/**
 * @private
 * @ignore
 */
nitobi.event.Key.prototype.dispose = function()
{
	for (var handler in this.handlers)
	{
		this.handlers[handler] = null;
	}
}


/**
 * @private
 * @ignore
 */
nitobi.event.Args = function(src)
{
	this.source = src;
}
/**
 * @private
 * @ignore
 */
nitobi.event.Args.prototype.callback = function()
{
}

/**
 * Cancels 
 * @private
 */
nitobi.html.cancelBubble = nitobi.html.cancelEvent;
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @ignore
 */
nitobi.html.getCssRules = nitobi.html.Css.getRules;
/**
 * @ignore
 */
nitobi.html.findParentStylesheet = nitobi.html.Css.findParentStylesheet;
/**
 * @ignore
 */
nitobi.html.getClass = nitobi.html.Css.getClass;
/**
 * @ignore
 */
nitobi.html.getStyle = nitobi.html.Css.getStyle;
/**
 * @ignore
 */
nitobi.html.addClass = nitobi.html.Css.addClass;
/**
 * @ignore
 */
nitobi.html.removeClass = nitobi.html.Css.removeClass;
/**
 * @ignore
 */
nitobi.html.getClassStyle = nitobi.html.Css.getClassStyle;
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.html.normalizeUrl = nitobi.html.Url.normalize;

nitobi.html.setUrlParameter = nitobi.html.Url.setParameter;
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base.XmlNamespace");

nitobi.base.XmlNamespace.prefix = "ntb";
nitobi.base.XmlNamespace.uri = "http://www.nitobi.com";
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.collections");
if (false)
{
	/**
	 * @namespace The collections namespace contains classes that help manage different types of collection objects.
	 * @constructor
	 */
	nitobi.collections = function(){};
}

/**
 * Supports adding more complex list functions to a class. 
 * @class An interface that provides for advanced array/list functions.
 * @constructor
 */
nitobi.collections.IEnumerable = function() 
{
	/**
		@ignore
	*/
	this.list = new Array();
	
	/**
		@ignore
	*/
	this.length=0;
}

/**
 * Adds a item to the end of the list.
 * @param {Object} obj An object or primitive to add to the list.
 */
nitobi.collections.IEnumerable.prototype.add = function(obj)
{
	this.list[this.getLength()] = obj;
	this.length++
}

/**
 * Inserts an item at the specified index.  The object at that index and subsequent objects
 * will be moved one place to the right (one index higher).
 * @param {Number} index the index of the object once it is inserted
 * @param {Object} obj an object or primitive to insert in the list
 */
nitobi.collections.IEnumerable.prototype.insert = function(index, obj)
{
	this.list.splice(index, 0, obj);
	this.length++;
};

/**
 * Converts something that looks like a javascript Array into a javascript Array.
 * @type Array
 * @param {Object} obj An objects that supports [].
 * @param {Number} start Where to start the copy.
 */
nitobi.collections.IEnumerable.createNewArray = function(obj, start)
{
	var length;
	start = start || 0;
	if (obj.count)
	{
		length = obj.count;
	}
	if (obj.length)
	{
		length = obj.length;
	}
	var x = new Array(length-start);
	for (var i = start; i < length; i++)
	{
		x[i - start] = obj[i];
	}
	return x;
}

/**
 * Returns an item from the list.
 * @param {Number} index The index of the item you want. Indexed from zero, and throws an error if the index is out of bounds.
 * @type Object
 */
nitobi.collections.IEnumerable.prototype.get = function(index)
{
	if (index < 0 || index >= this.getLength())
	{
		nitobi.lang.throwError(nitobi.error.OutOfBounds);
	}
	return this.list[index];
}

/**
 * Sets an item in the list.
 * @param {Number} index The index for where you want to add the item. Throws an error if out of bounds.
 * @param {Object} value The object you want to store.
 */
nitobi.collections.IEnumerable.prototype.set = function(index,value)
{
	if (index < 0 || index >= this.getLength())
	{
		nitobi.lang.throwError(nitobi.error.OutOfBounds);
	}
	this.list[index] = value;
}

/**
 * Finds the index of an item in the list.  The first match is returned if 
 * duplicates exist.
 * @param {Object} obj The item whose index you want to find.
 * @type Number
*/
nitobi.collections.IEnumerable.prototype.indexOf = function(obj)
{
	for (var i = 0; i < this.getLength(); i++)
	{
		if (this.list[i] === obj)
		{
			return i;
		}
	}
	return -1;
}

/**
 * Removes an item from the list. An error is thrown if the item does not exists
 * or the index is out of bounds.
 * @param {Number/Object} value An index or object you want removed from the list.
*/
nitobi.collections.IEnumerable.prototype.remove = function(value)
{
	var i;
	if (typeof(value) != "number")
	{
		i = this.indexOf(value);
	}
	else
	{
		i = value;
	}
	if (-1 == i || i < 0 || i >= this.getLength())
	{
		nitobi.lang.throwError(nitobi.error.OutOfBounds);
	}
	this.list[i] = null;
	this.list.splice(i,1);
	this.length--;
}

/**
 * Returns the number of items in the list.
 * @type Number
*/
nitobi.collections.IEnumerable.prototype.getLength = function()
{
	return this.length;
}

/**
 * Applies the function <CODE>func</CODE> to each element in the collection, in order.
 * @param {Function} func A function that will be evaluated on each element in the collection.
 */
nitobi.collections.IEnumerable.prototype.each = function(func)
{
	var l = this.length;
	var list = this.list;
	for (var i = 0; i < l; i++)
	{
		func(list[i]);
	}
};
 
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

/**
 * When calling ISerializable, the class must identify itself
 * using a partial profile and it must be registered.  If the object is created by a node using the factory, then
 * the profile is deduced from the nodename.
 * @example
 * nitobi.ui.Button.baseConstructor.call(this,{className:"nitobi.ui.Button"},xmlNode);
 * @class A generalized form of a wrapper around an XML node that allows for serialization to xml.
 * This class allows for the creation of a javascript object from an XML node. 
 * This means that any Xml node can quickly be transformed into its corresponding javascript object and treated accordingly. 
 * The node is used for data storage.  This interface is used to correctly serialize and deserialize javascript objects.
 * @constructor
 * @extends nitobi.Object
 * @param {Object} [xmlNode] The node that specifies the object's data. Optional. If this is null, a new node is created.
 * @param {String} [id] The Id of this object.
 * @param {String} [xml]  The XML string that defines the object and its children. Used to deserialize.
 * @param {nitobi.base.ISerializable} parent The object that is the parent or container of this object.
 */
nitobi.base.ISerializable = function(xmlNode, id, xml, parent) 
{
	nitobi.Object.call(this);
	if (typeof(this.ISerializableInitialized) == "undefined")
	{
		/**
		 * When <code>true</code>, this object has been initialized from an xml node or 
		 * in-page XML declaration.
		 * @type Boolean
		 */
		this.ISerializableInitialized = true;
	}
	else
	{
		return;
	}
	
	/**
	 * The XML Node to which this object is attached.
	 * @type Node
	 * @private
	 */
	this.xmlNode = null;
	this.setXmlNode(xmlNode);
	
	// Fill out as much info as we can about this instance.
	if (xmlNode != null)
	{
		/**
		 * Describes this object.
		 * @type {nitobi.base.Profile}
		 * @private
		 */
		this.profile = nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:xmlNode.nodeName});
	}
	else
	{
		this.profile = nitobi.base.Registry.getInstance().getProfileByInstance(this);
	}
		
	/**
	 * Fires after deserialization.
	 * @type nitobi.base.Event
	 */
	this.onDeserialize = new nitobi.base.Event();
	
	/**
	 * Fires after the node knows it's parent.
	 * @private
	 * @type nitobi.base.Event;
	 */
	this.onSetParentObject = new nitobi.base.Event();
	
	/**
	 * The factory used to create this object and its children.
	 * @type Factory
	 * @private
	 */
	this.factory = nitobi.base.Factory.getInstance();
	/**
	 * A cache of objects already created from nodes.
	 * @type HashMap
	 * @private
	 */
	this.objectHash = {};
	
	
	/**
	 * Fired when an object is newly created.
	 * @type nitobi.base.Event
	 */
	this.onCreateObject = new nitobi.base.Event();

	if (xmlNode != null)
	{
		this.deserializeFromXmlNode(this.getXmlNode());
	}
	else if (this.factory!=null && this.profile.tagName != null)
	{
		this.createByProfile(this.profile, this.getXmlNode());
	}
	else
	{
		if (xml != null && xmlNode != null)
		{
			this.createByXml(xml);
		}
	}

	this.disposal.push(this.xmlNode);
}

nitobi.lang.extend(nitobi.base.ISerializable, nitobi.Object);
/**
 * @private
 */
nitobi.base.ISerializable.guidMap = {};

/**
 Indicates that the class implements this interface. This is copied onto the class itself
 when it s implemented. Useful to determine if all ISerializable functions are available.
 @type Boolean
 */
nitobi.base.ISerializable.prototype.ISerializableImplemented = true;

/**
 * Returns the profile that describes this object.
 * @type nitobi.base.Profile
 */ 
nitobi.base.ISerializable.prototype.getProfile = function()
{
	return this.profile;
}


/**
 * Used by the constructor to create the object. 
 * @param {nitobi.base.Profile} The profile that describes enough about the object to create it.
 * @param {XMLNode} xmlNode Optional. If supplied, uses this node for storage.
 * @private
 */
nitobi.base.ISerializable.prototype.createByProfile = function(profile, xmlNode)
{
	if (xmlNode == null)
	{		
		var xml="<" + profile.tagName + " xmlns:" + nitobi.base.XmlNamespace.prefix + "=\"" + nitobi.base.XmlNamespace.uri + "\" />"
		var xmlDoc = nitobi.xml.createXmlDoc(xml);
		this.setXmlNode(xmlDoc.firstChild);
		this.deserializeFromXmlNode(this.xmlNode);		
	}
	else
	{
		this.deserializeFromXmlNode(xmlNode);		
		this.setXmlNode(xmlNode);
	}
}

/**
 * Used by the constructor to create the object by deserializing it. 
 * @param {string} xml Xml used in deserialization.
 * @private
 */
nitobi.base.ISerializable.prototype.createByXml = function(xml)
{
	this.deserializeFromXml(xml);
}

/**
 * Returns the object that created this object. If the value is null
 * then this object does not have an ISerializable parent.
 * @type nitobi.base.ISerializable
 */
nitobi.base.ISerializable.prototype.getParentObject = function()
{
	return this.parentObj;
}

/**
 * @ignore
 */
nitobi.base.ISerializable.prototype.setParentObject = function(value)
{
	this.parentObj = value;
	this.onSetParentObject.notify();
}

/**
 * Add a serializable object to this one. 
 * @param {nitobi.base.ISerializable} child The child to add.
 * @private
 */
nitobi.base.ISerializable.prototype.addChildObject = function(child)
{
	this.addToCache(child);
	child.setParentObject(this);
	var xmlNode = child.getXmlNode();
	if (!this.areGuidsGenerated(xmlNode))
	{
		xmlNode = this.generateGuids(xmlNode);
		child.setXmlNode(xmlNode);
	}

	// Append the child xmlNode to the parent and update the pointer to the childs xmlNode to the node in the parents document ... 
	// In particular this is a DOM problem in Safari 3 / Firefox 3
	child.setXmlNode(this.xmlNode.appendChild(nitobi.xml.importNode(this.xmlNode.ownerDocument, xmlNode, true)));
	
}

/**
 * Insert a serializable object at an index specified. 
 * @param {nitobi.base.ISerializable} obj The object to insert.
 * @param {nitobi.base.ISerializable} sibling The siblign to insert before
 * @private
 */
nitobi.base.ISerializable.prototype.insertBeforeChildObject = function(obj, sibling)
{
	sibling = sibling ? sibling.getXmlNode() : null;
	this.addToCache(obj);
	obj.setParentObject(this);
	var xmlNode = obj.getXmlNode();
	if (!this.areGuidsGenerated(xmlNode))
	{
		xmlNode = this.generateGuids(xmlNode);
		obj.setXmlNode(xmlNode);
	}
	xmlNode = nitobi.xml.importNode(this.xmlNode.ownerDocument, xmlNode, true);
	this.xmlNode.insertBefore(xmlNode, sibling);
}


/**
 * Create a new node using our namespace.
 * @return A new Xml node/element.
 * @type XMLNode
 * @param name {String} name The name of the node including the ns prefix.
 * @private
 */
nitobi.base.ISerializable.prototype.createElement = function(name)
{
	var xmlDoc;
	if (this.xmlNode == null || this.xmlNode.ownerDocument == null)
	{
		xmlDoc = nitobi.xml.createXmlDoc();	
	}
	else
	{
		xmlDoc = this.xmlNode.ownerDocument;
	}
	
	
	if (nitobi.browser.IE)
	{
		return xmlDoc.createNode(1, name, nitobi.base.XmlNamespace.uri);
	}
	else if (xmlDoc.createElementNS)
	{
		return xmlDoc.createElementNS(nitobi.base.XmlNamespace.uri, name);
	} else
	{
		nitobi.lang.throwError("Unable to create a new xml node on this browser.");
	}
}

/**
 * Deletes a child from the cache including its corresponding node in the xml document.
 * @param {nitobi.base.ISerializable} child The child to delete.
 * @private
 */
nitobi.base.ISerializable.prototype.deleteChildObject = function(id)
{
	this.removeFromCache(id);
	var e = this.getElement(id);
	if (e!=null)
	{
		e.parentNode.removeChild(e);
	}
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.addToCache = function(obj)
{
	this.objectHash[obj.getId()] = obj;
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.removeFromCache = function(id)
{
	this.objectHash[id] = null;
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.inCache = function(id)
{
	return (this.objectHash[id] != null);
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.flushCache = function()
{
	this.objectHash = {};
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.areGuidsGenerated = function(xmlNode)
{
	if (xmlNode == null || xmlNode.ownerDocument == null) return false;
	if (nitobi.browser.IE)
	{
		var node = xmlNode.ownerDocument.documentElement;
		if (node == null)
		{
			return false;
		}
		else
		{
			var id = node.getAttribute("id");
			if (id == null || id == "")
			{
				return false;
			} 
			else
			{
				return (nitobi.base.ISerializable.guidMap[id] != null);
			}
		}
	}
	else
	{
		return (xmlNode.ownerDocument.generatedGuids == true);
	}
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.setGuidsGenerated = function(xmlNode,value)
{
	if (xmlNode == null || xmlNode.ownerDocument == null) return;
	if (nitobi.browser.IE)
	{
		var node = xmlNode.ownerDocument.documentElement;
		if (node != null)
		{
			var id = node.getAttribute("id");
			if (id != null && id != "")
			{
				nitobi.base.ISerializable.guidMap[id] = true;
			} 
		}
	}
	else
	{
		xmlNode.ownerDocument.generatedGuids = true;
	}
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.generateGuids = function(xmlNode)
{
	/*var doc = nitobi.xml.createXmlDoc(nitobi.xml.serialize(xmlNode));
	var node = nitobi.xml.transformToString(doc,nitobi.base.uniqueIdGeneratorProc,'xml');
	node = nitobi.xml.createXmlDoc(node).documentElement; 
	
	// We don't want moz to accidentally destoy the owner document, hence the jumble here.
	// Ideally, loss of namespace information would be fixed in the xml libs. Pending though.
	var parent = xmlNode.parentNode;
	parent.replaceChild(node,xmlNode);*/
	nitobi.base.uniqueIdGeneratorProc.addParameter('guid', nitobi.component.getUniqueId(), '');
	var doc = nitobi.xml.transformToXml(xmlNode,nitobi.base.uniqueIdGeneratorProc);
	this.saveDocument = doc;
	this.setGuidsGenerated(doc.documentElement,true);
	return doc.documentElement;
}

/**
 * Deserializes the object from an XML node. All references to the properties of the 
 * object are destroyed or invalidated.  The cache is also emptied.  The XML Node
 * should be of the same type as the object, that is, don't deserialize a node such as 
 * &lt;foo&gt; if the class is not Foo.
 * @param {XMLNode} xmlNode The XML Node from which this object will be deserialized.
 */
nitobi.base.ISerializable.prototype.deserializeFromXmlNode = function(xmlNode)
{
	if (!this.areGuidsGenerated(xmlNode))
	{
		xmlNode = this.generateGuids(xmlNode);
	}
	this.setXmlNode(xmlNode);
	this.flushCache();
		
	if (this.profile == null)
	{
		this.profile = nitobi.base.Registry.getInstance().getCompleteProfile({idField:null,tagName:xmlNode.nodeName});
	}

	this.onDeserialize.notify();
}

/**
 * Deserializes the object from an XML string. All references to the properties of the 
 * object are destroyed or invalidated.  The cache is also emptied.  The XML 
 * should be of the same type as the object, that is, don't deserialize a node such as 
 * &lt;foo&gt; if the class is not Foo.
 * @param {String} xml Valid Xml.
 */
nitobi.base.ISerializable.prototype.deserializeFromXml = function(xml)
{
	var doc = nitobi.xml.createXmlDoc(xml);
	var node = this.generateGuids(doc.firstChild);
	this.setXmlNode(node);
	this.onDeserialize.notify();
}


/**
 * Returns a child of this object given its profile and its id. 
 * @param Id {string} id Optional. The id of the object. Only needed if there are two or more objects of the same
 * type stored by this object.
 * @returns {nitobi.base.ISerializable} The requested object.
 * @private
 */
nitobi.base.ISerializable.prototype.getChildObject = function(id)
{
	var obj = null; 
	obj = this.objectHash[id]; 
	if (obj == null)
	{
		var xmlNode = this.getElement(id);
	
		if (xmlNode==null)
		{
			return null;
		}
		else
		{
			obj = this.factory.createByNode(xmlNode);
			this.onCreateObject.notify(obj);
			this.addToCache(obj);
		}
		obj.setParentObject(this);
	}
	return obj;
}

/**
 * Returns a child of this object given its id. 
 * @param Id {string} id The id of the object.
 * @returns {nitobi.base.ISerializable} The requested object.
 * @private
 */
nitobi.base.ISerializable.prototype.getChildObjectById = function(id)
{
	return this.getChildObject(id);
}

/**
 * Returns the xmlnode that corresponds to the object specified by its profile.
 * @param Id {string} id Optional. The id of the object. Only needed if there are two or more objects of the same
 * type stored by this object.
 * @returns {object} The node that is attached to the specified object.
 * @private
 */
nitobi.base.ISerializable.prototype.getElement = function(id)
{
	try
	{
		var node = this.xmlNode.selectSingleNode("*[@id='"+id+"']");
		return node;
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected,err);
	}
}

/**
 * The Factory used to create this object and its children.
 * @type nitobi.base.Factory
 * @private
 */
nitobi.base.ISerializable.prototype.getFactory = function()
{
	return this.factory;
}

/**
 * The Factory used to create this object and its children. 
 * @param value {nitobi.base.Factory} value
 * @private
 */
nitobi.base.ISerializable.prototype.setFactory = function(value)
{
	this.factory = factory;
}

/**
 * The node that stores the object in the XML DOM.
 * Be careful modifying this node programmatically; items stored in this
 * node are also cached.
 * @type XMLNode
 * 
 */
nitobi.base.ISerializable.prototype.getXmlNode = function()
{
	return this.xmlNode;
}

/**
 * Returns the node that stores the object in the XML DOM.
 * Be careful modifying this node programmatically; items stored in this
 * node are also cached. If you set this, you should also clear the cache.
 * @param {XMLNode} value The XMLNode to use.
 * @private
 */
nitobi.base.ISerializable.prototype.setXmlNode = function(value)
{
	if (nitobi.lang.typeOf(value) == nitobi.lang.type.XMLDOC && value != null)
	{
		this.ownerDocument = value;
		value = nitobi.html.getFirstChild(value);
	}
	else if (value!=null)
	{
		this.ownerDocument = value.ownerDocument;
	}
	// TODO: Awaiting fix.
	if (value != null && nitobi.browser.MOZ && value.ownerDocument == null)
	{
		nitobi.lang.throwError(nitobi.error.OrphanXmlNode + " ISerializable.setXmlNode");
	}
	this.xmlNode = value;
}


/**
 * Serializes the object into XML.
 * @type String
 */
nitobi.base.ISerializable.prototype.serializeToXml = function()
{
	return nitobi.xml.serialize(this.xmlNode);
}

/**
 * Returns an attribute from the object as a string. The attribute 
 * must be a simple type (i.e., string, integer, etc); use getObject
 * to return a complex type.
 * @param {String} name The name of the attribute.
 * @param {String} [defaultValue] The defualt value for this attribute.
 */
nitobi.base.ISerializable.prototype.getAttribute = function(name, defaultValue)
{
	if (this[name] != null) 
	{
		return this[name];
	}
	var retVal = this.xmlNode.getAttribute(name);
	return retVal === null ? defaultValue : retVal;
}

/**
 * Sets any kind of value as an attribute on the object.  If the value
 * is a complex object it's string representation is used (i.e., it may be stored as
 * name="[object]". Use setObject to set a complex object.
 * @param {String} name The name of the attribute. This must be a valid XML attribute name.
 * @param {String} value The value of the attribute.
 */
nitobi.base.ISerializable.prototype.setAttribute = function(name, value)
{
	this[name] = value;
	this.xmlNode.setAttribute(name.toLowerCase(),value != null ? value.toString() : "");
}

/**
 * Sets an integer value as an attribute on the object.  The value must be a valid
 * number otherwise an error is thrown.
 * @param {String} name The name of the attribute. This must be a valid XML attribute name.
 * @param {Number} value The value of the attribute.
 */
nitobi.base.ISerializable.prototype.setIntAttribute = function(name,value)
{
	var n = parseInt(value);
	if (value != null && (typeof(n) != "number" || isNaN(n))) 
	{
		nitobi.lang.throwError(name + " is not an integer and therefore cannot be set. It's value was " + value);
	}
	this.setAttribute(name,value);
}

/**
 * Returns a integer attribute from the object. The attribute 
 * must be an integer; if it is "" then zero is returned, otherwise, if the
 * value is not a valid number, an error is thrown.
 * @param {String} name The name of the attribute.
 * @param {Number} [defaultValue] The default value for this attribute.
 * @type Number
 */
nitobi.base.ISerializable.prototype.getIntAttribute = function(name, defaultValue)
{
	var x = this.getAttribute(name, defaultValue);
	if (x==null || x=="")
	{
		return 0;
	}
	var tx = parseInt(x);
	if (isNaN(tx))
	{
		nitobi.lang.throwError("ISerializable attempting to get " + name + " which was supposed to be an int but was actually NaN");
	}
	return tx;
}

/**
 * Sets a boolean value as an attribute on the object.  The value must be a valid
 * boolean otherwise an error is thrown.
 * @param {String} name The name of the attribute. This must be a valid XML attribute name.
 * @param {Boolean} value The value of the attribute.
 */
nitobi.base.ISerializable.prototype.setBoolAttribute = function(name,value)
{
	value = nitobi.lang.getBool(value);
	if (value != null && typeof(value) != "boolean") 
	{
		nitobi.lang.throwError(name + " is not an boolean and therefore cannot be set. It's value was " + value);
	}
	this.setAttribute(name,(value ? "true" : "false"));
}

/**
 * Returns a boolean attribute from the object. The attribute 
 * must be a boolean; if it is "" then null is returned, otherwise, if the
 * value is not a valid boolean, an error is thrown.
 * @param {String} name The name of the attribute.
 * @param {Boolean} defaultValue The default value for this attribute. (Optional)
 * @type Boolean
 */
nitobi.base.ISerializable.prototype.getBoolAttribute = function(name, defaultValue)
{
	var x = this.getAttribute(name, defaultValue);
	if (typeof(x) == "string" && x=="")
	{
		return null;
	}
	var tx = nitobi.lang.getBool(x);
	if (tx == null)
	{
		nitobi.lang.throwError("ISerializable attempting to get " + name + " which was supposed to be a bool but was actually " + x);
	}
	return tx;
}

/**
 * Sets a Date value as an attribute on the object.  The value must be a valid
 * Date otherwise an error is thrown.
 * @param {String} name The name of the attribute. This must be a valid XML attribute name.
 * @param {Date} value The value of the attribute.
 */
nitobi.base.ISerializable.prototype.setDateAttribute = function(name,value)
{	
	this.setAttribute(name,value);
}

/**
 * Returns a Date attribute from the object. The attribute 
 * must be a boolean; if it is "" then null is returned, otherwise, if the
 * value is not a valid Date, an error is thrown.
 * @param {String} name The name of the attribute. This must be a valid XML attribute name.
 * @param {Boolean} value The value of the attribute.
 */
nitobi.base.ISerializable.prototype.getDateAttribute = function(name, defaultValue)
{	
	if (this[name])
	{
		return this[name];
	}
	var dateStr = this.getAttribute(name, defaultValue);
	return dateStr ? new Date(dateStr) : null;
}

/**
 * Returns the id of the object. This id is assumed to be globally unique.
 * @type String
 */
nitobi.base.ISerializable.prototype.getId = function()
{
	return this.getAttribute("id");
}


/**
 * Returns the id of a child object. Note: this is the id of the child object currently being
 * stored in this object. 
 * @param {nitobi.base.Profile/nitobi.base.ISerializable} locator Either the profile of the object, or the object itself. 
 * If the locator is an ISerializable object, it may or may not be the same object that is currently being stored.
 * @param {String} If there is more than one type of this object being stored, then you must include the instance name. 
 * If only one type of this object is stored, the name is not required.
 * @type String
 * @private
 */
nitobi.base.ISerializable.prototype.getChildObjectId = function(locator, instanceName) 
{
	var tagname = (typeof(locator.className) == "string" ? locator.tagName : locator.getXmlNode().nodeName);
	var xpath = tagname;
	if (instanceName)
	{
		xpath += "[@instancename='"+instanceName+"']";
	}
	
	var node = this.getXmlNode().selectSingleNode(xpath);
	if (null == node)
	{
		return null;
	}
	else
	{
		return node.getAttribute("id");
	}
}

/**
 * Sets an object value as a sub element of the object.  The object must implement 
 * ISerializable otherwise an error is thrown.  In order to uniquely identify child objects of the same type,
 * an id is used. If getId() is not defined on the object, it is added and the name
 * is used as an id.
 * @param {String} instanceName The name of the object. This must be a valid XML attribute name.  If no name is specified
 * it is assumed that there is only one type of this object.
 * @param {Object} value The value. Must implement ISerializable.
 */
nitobi.base.ISerializable.prototype.setObject = function(value, instanceName) 
{
	if (value.ISerializableImplemented != true)
	{
		nitobi.lang.throwError(nitobi.error.ExpectedInterfaceNotFound + " ISerializable");
	}
	
	var id = this.getChildObjectId(value,instanceName);
	if (null != id)
	{
		this.deleteChildObject(id);
	}
	if (instanceName)
	{
		value.setAttribute("instancename",instanceName);
	}
	this.addChildObject(value);
}

/**
 * Returns a child object of the current object. The class must be 
 * registered with the factory this object is using.  If the current object contains
 * more that one type of the child, the name of the child is used as an id.
 * @param {String} instanceName The name of the child. Optional. If this is not supplied, then
 * the first child that matches the classname is retrieved.
 * @param {nitobi.base.Profile} profile The profile of the child you want to retrieve.
 * @type Object
 */
nitobi.base.ISerializable.prototype.getObject = function(profile, instanceName) 
{
	var id = this.getChildObjectId(profile,instanceName);
	if (null == id)
	{
		return id;
	}
	return this.getChildObject(id);
}

/**
 * Returns the object given its id.
 * @param {String} id The id of the object.
 */
nitobi.base.ISerializable.prototype.getObjectById = function(id) 
{
	return this.getChildObject(id);
	
}

/**
 * @private
 */
nitobi.base.ISerializable.prototype.isDescendantExists = function(id)
{
	var node = this.getXmlNode();
	var child = node.selectSingleNode("//*[@id='" + id + "']");
	return (child!=null);
}

/**
 * Returns an array of xmlNodes that describes the path from this node
 * to a descendant node.
 * @param {String} id The id of the descendant.
 * @type Array
 * @private
 */
nitobi.base.ISerializable.prototype.getPathToLeaf = function(id)
{
	var node = this.getXmlNode();
	var child = node.selectSingleNode("//*[@id='" + id + "']");
	if (nitobi.browser.IE)
	{
		child.ownerDocument.setProperty("SelectionLanguage","XPath");
	}
	var pathNodes = child.selectNodes("./ancestor-or-self::*");
	var thisId = this.getId();
	var start=0;
	for (var i=0;i<pathNodes.length;i++)
	{
		if (pathNodes[i].getAttribute("id") == thisId)
		{
			start = i+1;
			break;
		}
	}
	var arr = nitobi.collections.IEnumerable.createNewArray(pathNodes,start);
	return arr.reverse();
}


/**
 * @private
 */
nitobi.base.ISerializable.prototype.isDescendantInstantiated = function(id)
{
	var node = this.getXmlNode();
	var child = node.selectSingleNode("//*[@id='" + id + "']");
	if (nitobi.browser.IE)
	{
		child.ownerDocument.setProperty("SelectionLanguage","XPath");
	}
	var pathNodes = child.selectNodes("ancestor::*");
	var startPushing = false;
	var obj = this;
	for (var i=0;i<pathNodes.length;i++)
	{
		if (startPushing)
		{
			var pathId = pathNodes[i].getAttribute("id");
			instantiated = obj.inCache(pathId);
			if (!instantiated)
			{
				return false;
			}
			obj = this.getObjectById(pathId)
		}
		if (pathNodes[i].getAttribute("id") == this.getId())
		{
			startPushing = true;
		}
	}
	return obj.inCache(id);
}
	
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**************************************************************************/
/*					nitobi.base.Registry	     	      
/**************************************************************************/


nitobi.lang.defineNs("nitobi.base");

// This is unnecessary in most cases, but we do this to avoid problems if toolkit
// is included twice on a page which will be the case if .NET customers try to use
// the new components.
if (!nitobi.base.Registry)
{
/**
 * Stores information about classes.  This is a singleton. Do not create directly, but rather use the getInstance method.
 * @class The registry manages class information.  Registering a {@link nitobi.base.Profile} in the registry allows for
 * object creation via {@link nitobi.base.Factory}
 * @constructor
 */
nitobi.base.Registry = function() 
{
	/**
	 * Profiles keyed by class.
	 * @private
	 */
	this.classMap = {};
	/**
	 * Profiles keyed by tagname.
	 * @private
	 */
	this.tagMap = {};
}

if (!nitobi.base.Registry.instance)
{
	/**
	 * The singleton instance.
	 * @private
	 */
	nitobi.base.Registry.instance = null;
}


/**
 * Returns the single instance of this class.
 * @type nitobi.base.Registry
 */
nitobi.base.Registry.getInstance = function()
{
	if (nitobi.base.Registry.instance == null)
	{
		nitobi.base.Registry.instance = new nitobi.base.Registry();
	}
	return nitobi.base.Registry.instance;
}

/**
 * Returns a class's profile given its fully qualified name.
 * @param {String} className The classname of the profile we're looking for.
 * @type nitobi.base.Profile
 */
nitobi.base.Registry.prototype.getProfileByClass = function(className)
{
	return this.classMap[className];
}


/**
 * Given an instance of a class, return the class's profile.
 * @param {Object} instance The object instance who's profile we're interested in.
 * @type nitobi.base.Profile
 */
nitobi.base.Registry.prototype.getProfileByInstance = function(instance)
{
	// Get info about the first function in the instance.
	var fnInfo = nitobi.lang.getFirstFunction(instance);
	// Get the functions prototype.
	var p = fnInfo.value.prototype;
	
	var instanceClassName = null;
	var highScore = 0;
	for (var className in this.classMap)
	{
		// Get the class object.
		
		// DANGER: this will only work if the class you are looking for is registered.
		// Otherwise we will return the most similar class.
		var classObj = this.classMap[className].classObject;
		var score = 0;
		while (classObj && instance instanceof classObj)
		{
			classObj = classObj.baseConstructor;
			score++;
		}
		
		if (score > highScore)
		{
			highScore = score;
			instanceClassName = className;
		}
		// -------------------------------------------------------------------
		// LEAVING THE OLD CODE HERE IN CASE THE DANGER CASE BECOMES A PROBLEM
		// -------------------------------------------------------------------
		// The problem with this code below is that any expando's of type 'function' 
		// on an instance that are not found in that instance's class will muck things up.
		// -------------------------------------------------------------------
		// Get the prototype of the function of the same name  and compare
		// the two.
//		var o = classObj.prototype[fnInfo.name];
//		if (o != null)
//		{	
//			var cp = o.prototype;
//			if (cp == p)
//			{
//				// For added security, check the other fns.
//				var check=true;
//				for (fn in instance)
//				{
//					if (instance[fn] != null && typeof(instance[fn]) == "function")
//					{
//						if (classObj.prototype[fn] == null)
//						{
//							check=false;
//						}
//					}
//					
//				}
//				if (check == true)
//				{
//					return this.getProfileByClass(className);
//				}
//			}
//		}
	}
	if (instanceClassName)
	{
		return this.getProfileByClass(instanceClassName);
	}
	else
	{
		return null;
	}
}


/**
 * Returns a class's profile given its tagname.
 * @param {String} tagName  The tagname of the profile we're interested in.
 * @type nitobi.base.Profile
 */
nitobi.base.Registry.prototype.getProfileByTag = function(tagName)
{
	return this.tagMap[tagName];
}

/**
 * Returns a class's profile given a partially completed profile.
 * @param {nitobi.base.Profile} incompleteProfile A profile with one or more fields completed. 
 * @type nitobi.base.Profile
 */
nitobi.base.Registry.prototype.getCompleteProfile = function(incompleteProfile)
{
	if (nitobi.lang.isDefined(incompleteProfile.className) && incompleteProfile.className != null)
	{
		return this.classMap[incompleteProfile.className];
	}
	if (nitobi.lang.isDefined(incompleteProfile.tagName) && incompleteProfile.tagName != null)
	{
		return this.tagMap[incompleteProfile.tagName];
	}	
	nitobi.lang.throwError("A complete class profile could not be found. Insufficient information was provided.");
}

/**
 * Register a class with the registry.  <b>Registering a class enables it's creation by factory</b>.
 * @param {nitobi.base.Profile} profile A complete profile.
 */
nitobi.base.Registry.prototype.register = function(profile)
{
	//if (!nitobi.lang.isDefined(profile.schema) || null==profile.schema) nitobi.lang.throwError("Illegal to register a class without a schema.");
	if (!nitobi.lang.isDefined(profile.tagName) || null==profile.tagName) nitobi.lang.throwError("Illegal to register a class without a tagName.");
	if (!nitobi.lang.isDefined(profile.className) || null==profile.className) nitobi.lang.throwError("Illegal to register a class without a className.");
	this.tagMap[profile.tagName] = profile;
	this.classMap[profile.className] = profile;
}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

/**
 * This is a singleton and the static getInstance method can be used to retrieve a handle to the object.
 * @class <code>nitobi.base.Factory</code> has methods that aid in creating objects by different sets
 * of attributes.  Is used internally by Toolkit to instantiate components from their declarations.
 * @constructor
 * @extends	nitobi.Object
 */
nitobi.base.Factory = function() 
{
	/**
	 * The Registry containing various component profiles defined by {@link nitobi.base.Profile}
	 * @type nitobi.base.Registry
	 */
	this.registry = nitobi.base.Registry.getInstance();
}

nitobi.lang.extend(nitobi.base.Factory,nitobi.Object);

/**
 * The singleton instance.
 * @private
 */
nitobi.base.Factory.instance = null;

/**
 * Instanstiate a class based on its class name.
 * @param {String} className The className.
 * @param {XmlNode} xmlNode XmlNode. 
 */
nitobi.base.Factory.prototype.createByClass = function(className)
{
	try
	{
		return nitobi.lang.newObject(className,arguments,1);
	} 
	catch(err)
	{
		nitobi.lang.throwError("The Factory (createByClass) could not create the class " + className + ".",err);
	}
}

/**
 * Instanstiate a class based on its serialized form that is stored in an xml node.
 * @param {Object} xmlNode 
 */
nitobi.base.Factory.prototype.createByNode = function(xmlNode)
{
	try
	{
		if (null == xmlNode)
		{
			nitobi.lang.throwError(nitobi.error.ArgExpected);
		}
		if (nitobi.lang.typeOf(xmlNode) == nitobi.lang.type.XMLDOC)
		{
			xmlNode = nitobi.xml.getChildNodes(xmlNode)[0];
		}
		var className = this.registry.getProfileByTag(xmlNode.nodeName).className;
	
		// Don't let this be garbage collected. KEEP THIS CALL!!!!
		var ownerDoc = xmlNode.ownerDocument;
		var methodArgs = Array.prototype.slice.call(arguments, 0);
		var obj = nitobi.lang.newObject(className,methodArgs,0);
		return obj;
	} 
	catch(err)
	{
		nitobi.lang.throwError("The Factory (createByNode) could not create the class " + className + ".",err);
	}
}

/**
 * Instanstiate a class based on its profile.
 * @param {nitobi.base.Profile} profile
 * @type Object
 * 
 */
nitobi.base.Factory.prototype.createByProfile = function(profile)
{
	try
	{
		return nitobi.lang.newObject(profile.className,arguments,1);
	} 
	catch(err)
	{
		nitobi.lang.throwError("The Factory (createByProfile) could not create the class " + profile.className + ".",err);
	}
}

/**
 * Instanstiate a class based on its tag name.
 * @param {String} tagName The tagname corresponding to a component.  e.g. "ntb:calendar"
 */
nitobi.base.Factory.prototype.createByTag = function(tagName)
{

		var className = this.registry.getProfileByTag(tagName).className;
		var methodArgs = Array.prototype.slice.call(arguments, 0);
		return nitobi.lang.newObject(className,methodArgs,1);
}

/**
 * Return an instance of this singleton.
 * @type nitobi.base.Factory
 */
nitobi.base.Factory.getInstance = function()
{
	if (nitobi.base.Factory.instance == null)
	{
		nitobi.base.Factory.instance = new nitobi.base.Factory();
	}
	return nitobi.base.Factory.instance;
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

 /**
 * A Profile stores information about a particular entity. It contains basic 
 * descriptions of how the entity is named as a Class, an XmlTag, and so on.
 * @constructor
 * @param {String} [className] The name of the class associated with this profile.
 * @param {Object} [schema] The schema that helps build the entity if it is complex or has properties.
 * @param {Boolean} [singleton] Whether or not the class associated with this profile is a singleton
 * @param {String} [tagName] The name of the tag associated with this profile.
 * @param {String} [idField] The name of the id field if an id is used.
 */
nitobi.base.Profile = function(className,schema,singleton,tagName,idField) 
{
	/**
	 * The name of the entity when it is represented as a class.
	 * @type String
	 */
	this.className = className;
	
	/**
	 * The class object itself.
	 * @type Object
	 */
	this.classObject = eval(className);
	
	
	/**
	 * The schema that helps build the entity if it is complex or has properties.
	 * @type Schema
	 */
	this.schema = schema;
	
	/**
	 * True if there is only one instance of this entity as an object.
	 * @type Boolean
	 */
	this.singleton = singleton;
	
	/**
	 * The name of the entity when it is represented as an xml tag.
	 * @type String
	 */
	this.tagName = tagName;
	
	/**
	 * The name of the Id field if an Id is used.
	 * @type String
	 */
	this.idField = idField || "id";
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

 /**
 * Creates a Declaration object.
 * @class This class is used to retrieve and set the defaults from a Nitobi component declaration.
 * @ignore
 * @constructor
 * @extends	nitobi.Object
 */
nitobi.base.Declaration = function() 
{
	nitobi.base.Declaration.baseConstructor.call(this);
	/**
	 * @private
	 */
	this.xmlDoc=null;
}

nitobi.lang.extend(nitobi.base.Declaration, nitobi.Object);

/**
 * Given an HTML element, loads the HTML and creates an XML document from it.
 * If the HTML cannot be loaded into a XML document an error is thrown. Consult the
 * error string for information on what caused the parse error.
 * @param element {HTMLElement/String} The id of an element, or the element itself. 
 * @returns {void}
 */
nitobi.base.Declaration.prototype.loadHtml = function(element)
{
	try
	{
		element = $ntb(element);
		this.xmlDoc = nitobi.xml.parseHtml(element);
		return this.xmlDoc;
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.DeclarationParseError,err);
	}
}

/**
 * Returns the XML Document.
 * @type XMLDocument
 */
nitobi.base.Declaration.prototype.getXmlDoc = function()
{
	return this.xmlDoc;
}

/**
 * Returns XML.
 * @type String
 */
nitobi.base.Declaration.prototype.serializeToXml = function()
{
	return nitobi.xml.serialize(this.xmlDoc);	
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.base");

/**
 * DateMath provides static methods to deal with Date objects
 * @namespace
 * @constructor
 */
nitobi.base.DateMath = {
	DAY:'d',
	WEEK:'w',
	MONTH:'m',
	YEAR:'y',
	ONE_DAY_MS:86400000
}

/**
 * Common function for add and subtract
 * @param {Date} date The javascript date object
 * @param {String} unit The unit 
 * @param {Number} amount The amount of unit
 * @return the result
 * @type Date
 * @private
 */
nitobi.base.DateMath._add = function(date,unit,amount){	
	if(unit == this.DAY)	date.setDate(date.getDate()+amount);
	else if(unit==this.WEEK) date.setDate(date.getDate()+7*amount);		
	else if(unit==this.MONTH) date.setMonth(date.getMonth()+amount);
	else if(unit==this.YEAR) date.setFullYear(date.getFullYear()+amount);
	return date;
}
/**
 * Increments a date by some given amount.
 * @example
 * var today = new Date();
 * nitobi.base.DateMath.add(today, "d", 5);
 * @param {Date} date The date to add.
 * @param {String} unit The unit of time to add.  Can either be "d", "m", "w" or "y"
 * @param {Number} amount How many units of time to add.
 * @type Date
 * @static
 */
nitobi.base.DateMath.add = function(date,unit,amount){
	return this._add(date,unit,amount);
}
/**
 * Decrement a date by an amount
 * @param {Date} date The date to subtract.
 * @param {String} unit The unit of time to add.  Can either be "d", "m", "w" or "y"
 * @param {Number} amount How many units of time to add.
 * @type Date
 * @static
 */
nitobi.base.DateMath.subtract = function(date,unit,amount){
	return this._add(date,unit,-1*amount);
}
/**
 * Determines whether a date is exclusively after another date
 * @param {Date} date The date to check
 * @param {Date} compareTo The date to compare against
 * @type Boolean
 * @static
 */
nitobi.base.DateMath.after = function(date,compareTo){
	return (date-compareTo)>0;
}
/**
 * Determines whether a date is inclusively between two dates
 * @param {Date} date The date to check
 * @param {Date} start The start date of the comparison
 * @param {Date} end The end date of the comparison
 * @type Boolean
 * @static
 */
nitobi.base.DateMath.between = function(date,start,end){
	return (date-start)>=0 && (end-date)>=0;
}
/**
 * Determines whether a date is exclusively before another date
 * @param {Date} date The javascript date object to check
 * @param {Date} compareTo The date to compare
 * @type Boolean
 * @static
 */
nitobi.base.DateMath.before = function(date,compareTo){
	return (date-compareTo)<0;
}

/**
 * Creates a copy of a date object
 * @param {Date} date The date to clone.
 * @type Date
 * @static
 */
nitobi.base.DateMath.clone = function(date){
	var n = new Date(date.toString());
	return n;
}
/**
 * Determines whether the year in the Date object is a leap year.
 * @param {Date} date The date to check.
 * @type Boolean
 * @static
 */
nitobi.base.DateMath.isLeapYear = function(date){
	var y = date.getFullYear();
	var	_1 = String(y/4).indexOf('.') == -1; 
	var _2 = String(y/100).indexOf('.') == -1;
	var _3 = String(y/400).indexOf('.') == -1;
	return (_3)?true:(_1 && !_2)?true:false;
}	
/**
 * Get the number of days in a month for a given date.
 * @param {Date} date The date to check.
 * @type Number
 * @static
 */
nitobi.base.DateMath.getMonthDays = function(date){
	return [31,(this.isLeapYear(date))?29:28,31,30,31,30,31,31,30,31,30,31][date.getMonth()];		
}
/**
 * Get the date that corresponds to the end of the month.
 * @param {Date} date The date to check.
 * @type Date
 * @static
 */
nitobi.base.DateMath.getMonthEnd = function(date){
	return new Date(date.getFullYear(),date.getMonth(),this.getMonthDays(date));
}
/**
 * Get the date that corresponds to the start of the month.
 * @param {Date} date The date to check.
 * @type Date
 * @static
 */
nitobi.base.DateMath.getMonthStart = function(date){
	return new Date(date.getFullYear(),date.getMonth(),1);
}
/**
 * Checks if the date is today
 * @param {Date} date The date to check.
 * @type Boolean
 * @static
 */
nitobi.base.DateMath.isToday = function(date){
	var start = this.resetTime(new Date());
	var end = this.add(this.clone(start),this.DAY,1);
	return this.between(date,start,end);
}	

/**
 * Returns true if the two dates have the same day, month, and year (irrespective of time).
 * @param {Date} date The first date in the comparison.
 * @param {Date} compare The second date in the comparison.
 */
nitobi.base.DateMath.isSameDay = function(date, compare)
{
	date = this.resetTime(this.clone(date));
	compare = this.resetTime(this.clone(compare));
	return date.valueOf() == compare.valueOf();
}

/**
 * Parses a string as a date
 * @param {String} str The string to be parsed
 * @return Object
 * @type Date
 * @static
 * @private
 */
nitobi.base.DateMath.parse = function(str){

}	

/**
 * Calculates the week number of the given date in that year.
 * Week numbering starts from 0
 * @param {Date} date The date to check.
 * @type Number
 * @static
 */
nitobi.base.DateMath.getWeekNumber = function(date){
	var january = this.getJanuary1st(date);
	return Math.ceil(this.getNumberOfDays(january,date) / 7);
}

/**
 * Calculates the number of days from start date to end date.
 * Both start and end date are inclusive.
 * @param {Date} start The start date of the range.
 * @param {Date} end The end date of the range.
 * @type Number
 * @static
 */
nitobi.base.DateMath.getNumberOfDays = function(start,end){
	var duration = this.resetTime(this.clone(end)).getTime() - this.resetTime(this.clone(start)).getTime();
//	alert(duration/this.ONE_DAY_MS+1);
	return Math.round(duration/this.ONE_DAY_MS)+1;
}	

/**
 * Returns the date corresponding to the first day of the year.
 * @param {Date} date The date with which to base the start of year.
 * @type Date
 * @static
 */
nitobi.base.DateMath.getJanuary1st = function(date){
	return new Date(date.getFullYear(),0,1);
}

/**
 * Resets the time to 00:00:00
 * @param {Date} date The date to reset.
 * @type Date
 * @static
 */
nitobi.base.DateMath.resetTime = function(date){
	if (nitobi.base.DateMath.invalid(date))
		return date;
	date.setHours(0);
	date.setMinutes(0);
	date.setSeconds(0);		
	date.setMilliseconds(0);		
	return date;
}

/**
 * Returns date from a given ISO 8601 date string.
 * @param {String} date an ISO 8601 date string eg. 1980-12-21 08:30:12
 * @type Date
 */
nitobi.base.DateMath.parseIso8601 = function(date) {
	return new Date(date.replace(/^(....).(..).(..)(.*)$/, "$1/$2/$3$4"));
};

/**
 * Returns an ISO 8601 formatted date string from a javascript Date object.
 * @param {Date} date The date to format.
 * @type String
 */
nitobi.base.DateMath.toIso8601 = function(date) {
	if (nitobi.base.DateMath.invalid(date)) return "";
	var pz = nitobi.lang.padZeros;	
	return date.getFullYear()+"-"+pz(date.getMonth()+1)+"-"+pz(date.getDate())+" "+pz(date.getHours())+":"+pz(date.getMinutes())+":"+pz(date.getSeconds());	
};

/**
 * Returns true if the given date is invalid or null.
 * @param {Date} date a Javascript date object
 * @type Boolean
 */
nitobi.base.DateMath.invalid = function(date) {
	return (!date) || (date.toString() == 'Invalid Date'); 
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.base');

/**
 * @constructor
 * @class General arguments class that is passed to JavaScript event handlers.
 * @param {Object} source The object that fired the event.
 * @param {Event} event An optional parameter that indicates which event was fired. If this is
 * not supplied, then the global nitobi.html.Event is used.
 */
nitobi.base.EventArgs = function(source,event)
{
	/**
	 * The object that fired the event.
	 * @type Object
	 */
	this.source = source;
	
	/**
	 * The event that was fired.
	 * @type nitobi.base.Event
	 */
	this.event = event || nitobi.html.Event;
}

/**
 * Returns the source object for the event.
 * @type Object
 */
nitobi.base.EventArgs.prototype.getSource = function()
{
	return this.source;
}

/**
 * Returns the native browser Event object for the event.
 * @type nitobi.base.Event
 */
nitobi.base.EventArgs.prototype.getEvent = function()
{
	return this.event;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.collections");

/**
 *	Creates an IList.
 *	@class A more feature rich IList than a javascript array. If all the items in the IList
 * 	implement ISerializable, then the entire IList will be serializable.
 * 	@constructor
 * 	@extends nitobi.Object
 * 	@implements nitobi.base.ISerializable
 *	@implements nitobi.collections.IEnumerable	
 */
nitobi.collections.IList = function() 
{
	nitobi.base.ISerializable.call(this);
	nitobi.collections.IEnumerable.call(this);
}

nitobi.lang.implement(nitobi.collections.IList,nitobi.base.ISerializable);
nitobi.lang.implement(nitobi.collections.IList,nitobi.collections.IEnumerable);

/**
 * Indicates that the class implements this interface. This is copied onto the class itself
 * when it is implemented. Useful to determine if all IList functions are available.
 * @type Boolean
 */
nitobi.collections.IList.prototype.IListImplemented = true;


/**
	Adds a item to the end of the IList.
	@param {Object} obj An object or primitive to add to the IList.
 */
nitobi.collections.IList.prototype.add = function(obj)
{
	nitobi.collections.IEnumerable.prototype.add.call(this,obj);
	if (obj.ISerializableImplemented == true && obj.profile != null)
	{
		this.addChildObject(obj);		
	}

}

/**
 * Inserts an item at the specified index.  The object at that index and subsequent objects
 * will be moved one place to the right (one index higher).
 * @param {Number} index the index of the object once it is inserted
 * @param {Object} obj an object or primitive to insert in the list
 */
nitobi.collections.IList.prototype.insert = function(index, obj)
{
	var oldObj = this.get(index);
	nitobi.collections.IEnumerable.prototype.insert.call(this,index, obj);
	if (obj.ISerializableImplemented == true && obj.profile != null)
	{
		this.insertBeforeChildObject(obj,oldObj);		
	}
};

/**
 * @private
 */
nitobi.collections.IList.prototype.addToCache = function(obj, index)
{
	nitobi.base.ISerializable.prototype.addToCache.call(this,obj);
	this.list[index] = obj;
}

/**
 * @private
 */
nitobi.collections.IList.prototype.removeFromCache = function(index)
{
	nitobi.base.ISerializable.prototype.removeFromCache.call(this,this.list[index].getId());
}

/**
 * @private
 */
nitobi.collections.IList.prototype.flushCache = function()
{
	nitobi.base.ISerializable.prototype.flushCache.call(this);
	this.list = new Array();
}

/**
 * Returns an item from the IList.
 * @param {Number} index The index of the item you want. Indexed from zero, and throws an error if the index is out of bounds. 
 * If index is an object, the same
 * object is returned.
 * @type Object
 */
nitobi.collections.IList.prototype.get = function(index)
{
	if (typeof(index) == "object")
	{
		return index;
	}
	if (index < 0 || index >= this.getLength())
	{
		nitobi.lang.throwError(nitobi.error.OutOfBounds);
	}
	var obj = null;
	if (this.list[index] != null)
	{
		obj = this.list[index];
	} 
	if (obj == null)
	{
		var xmlNode = nitobi.xml.getChildNodes(this.xmlNode)[index]; 
	
		if (xmlNode==null)
		{
			return null;
		}
		else
		{
			obj = this.factory.createByNode(xmlNode);
			this.onCreateObject.notify(obj);
			nitobi.collections.IList.prototype.addToCache.call(this,obj,index);
		}
		obj.setParentObject(this);
	}
	
	return obj;
}

/**
 * @private
 */
nitobi.collections.IList.prototype.getById = function(id)
{
	var node = this.xmlNode.selectSingleNode("*[@id='"+id+"']");
	var index = nitobi.xml.indexOfChildNode(node.parentNode,node);
	return this.get(index);
}

/**
	Sets an item in the IList.
	@param {Number} index The index for where you want to add the item. Throws an error if out of bounds.
	@param {Object} value The object you want to store.
 */
nitobi.collections.IList.prototype.set = function(index,value)
{
	if (index < 0 || index >= this.getLength())
	{
		nitobi.lang.throwError(nitobi.error.OutOfBounds);
	}
	try
	{
		if (value.ISerializableImplemented == true)
		{
			var obj = this.get(index);
			
			// No need to reset the object if the same object is already in the IList.
			if (obj.getXmlNode() != value.getXmlNode())
			{
				var newNode = this.xmlNode.insertBefore(value.getXmlNode(),obj.getXmlNode());
				this.xmlNode.removeChild(obj.getXmlNode());
				obj.setXmlNode(newNode);	
			}
		}
		value.setParentObject(this);
		// Always update cache last.
		nitobi.collections.IList.prototype.addToCache.call(this,value,index);
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected,err);
	}
}

/**	
 * Removes an item from the IList. An error is thrown if the item does not exists
 * or the index is out of bounds.
 * @param {Number/Object} value An index or object you want removed from the IList.
*/
nitobi.collections.IList.prototype.remove = function(value)
{
	var i;
	if (typeof(value) != "number")
	{
		i = this.indexOf(value);
	}
	else
	{
		i = value;
	}

	var obj = this.get(i);

	nitobi.collections.IEnumerable.prototype.remove.call(this,value);
	
	this.xmlNode.removeChild(obj.getXmlNode());
}

/**
 * Returns the number of items in the IList.
 * @type Number
*/
nitobi.collections.IList.prototype.getLength = function()
{
	return nitobi.xml.getChildNodes(this.xmlNode).length;
}

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.collections");

/**
 * Creates a list.
 * @class A more feature rich list than a javascript array. If all the items in the list
 * implement ISerializable, then the entire list will be serializable.
 * @constructor
 * @param {nitobi.base.Profile} [profile] By default, the list serializes to XML using the tagname ntb:list;
 * if you do not wish to use this name, inherit from this class and supply a different profile.
 * @extends nitobi.Object
 * @implements nitobi.base.ISerializable
 * @implements nitobi.collections.IEnumerable
 * @private
 */
nitobi.collections.List = function(profile) 
{
	nitobi.collections.List.baseConstructor.call(this);
	nitobi.collections.IList.call(this);
}

nitobi.lang.extend(nitobi.collections.List,nitobi.Object);
nitobi.lang.implement(nitobi.collections.List,nitobi.collections.IList);

nitobi.base.Registry.getInstance().register(
		new nitobi.base.Profile("nitobi.collections.List",null,false,"ntb:list")
);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.collections');

//	Helper function for check if a hash is empty or not.
/**
 * @private
 */
nitobi.collections.isHashEmpty = function(hash) //collections
{
	var empty = true;
	for (var item in hash)
	{
		if (hash[item] != null && hash[item] != '')
		{
			empty = false;
			break;
		}
	}
	return empty;
}

nitobi.collections.hashLength = function(hash)
{
	var count = 0;
	for (var item in hash)
	{
		count++;
	}
	return count;
}

nitobi.collections.serialize = function(hash)
{
	var s = "";
	for (var item in hash)
	{
		var value = hash[item];
		var type = typeof(value);
		if (type == "string" || type == "number")
			s += "'"+item+"':'"+value+"',";
	}
	s = s.substring(0, s.length-1);
	return "{"+s+"}";
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ui");
if (false)
{
	/**
	 * @namespace The nitobi.ui namespace contains classes for building Ajax components.
	 * @constructor
	 */
	nitobi.ui = function(){};
}

/**
 * @private
 */
nitobi.ui.setWaitScreen = function(onOff) {
	
	if (onOff) {
	var sc = nitobi.html.getBodyArea();
	var me = nitobi.html.createElement('div', {"id":"NTB_waitDiv"}, {"verticalAlign":"middle","color":"#000000","font":"12px Trebuchet MS, Georgia, Verdana","textAlign":"center","background":"#ffffff","border":"1px solid #000000","padding":"0px","position":"absolute", "top":(sc.clientHeight/2)+sc.scrollTop-30+"px", "left":(sc.clientWidth/2)+sc.scrollLeft-100+"px", "width":"200px", "height":"60px"});
	me.innerHTML = "<table height=60 width=200><tr><td valign=center height=60 align=center>Please wait..</td></tr></table>";
	document.getElementsByTagName('body').item(0).appendChild(me);
	} else {
		
		var me = $ntb('NTB_waitDiv');
		try {
		document.getElementsByTagName('body').item(0).removeChild(me);	
		} catch(e) {}
		
	}
	
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ui");

/**
 * Initializes the IStyleable interface.
 * @class Allows for easy manipulation of styles on an HTML node.
 * @constructor
 * @param {HTMLElement} htmlNode The HTML element that will have styles applied to it.
 */
nitobi.ui.IStyleable = function(htmlNode) 
{
	/** 
	 * @private 
	 */
	this.htmlNode = htmlNode || null;
	/**
	 * Fires before a style is updated and passes the style name and value.
	 * @type nitobi.base.Event 
	 */
	this.onBeforeSetStyle = new nitobi.base.Event();
//	this.eventMap['beforesetstyle'] = this.onBeforeSetStyle;
	
	/**
	 * Fires when the style is updated and passes the style name and value to the handler.
	 * @see nitobi.ui.StyleEventArgs
	 */
	this.onSetStyle = new nitobi.base.Event();
//	this.eventMap['setstyle'] = this.onSetStyle;
}

/**
 * Returns the HTML node that this interface manipluates.
 */
nitobi.ui.IStyleable.prototype.getHtmlNode = function()
{
	return this.htmlNode;
}

/**
 * Sets the HTML node that this interface manipluates.
 * @param {HTMLElement} node The element to which styles will be applied.
 */
nitobi.ui.IStyleable.prototype.setHtmlNode = function(node)
{
	this.htmlNode = node;
}

/**
 * Sets a style on the element.  
 * @param {String} name The name of the style. This can be either all lowercase using dashes, or camel-case
 * e.g., either background-color or backgroundColor.
 * @param {String} value The value to which you want the style set.
 */
nitobi.ui.IStyleable.prototype.setStyle = function(name, value)
{
	if (this.onBeforeSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onBeforeSetStyle,name,value)) && this.getHtmlNode() != null)
	{
		nitobi.html.Css.setStyle(this.getHtmlNode(), name, value);
		this.onSetStyle.notify(new nitobi.ui.StyleEventArgs(this,this.onSetStyle,name,value));
	}
}

/**
 * Gets the computer style of the element with the specified name.
 * @param {String} name The name of the style whose value you want.
 * @type String
 */
nitobi.ui.IStyleable.prototype.getStyle = function(name)
{
	return nitobi.html.Css.getStyle(this.getHtmlNode(), name);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * @constructor
 * @class An arguments class that is passed to function subscribed to style change events (i.e. {@link nitobi.ui.IStyleable}).
 * @extends nitobi.base.EventArgs
 * @param {Object} source The object that fired the event.
 * @param {nitobi.base.Event} event The event that is being fired.
 * @param {String} property The style property that was changed (color, borderLeft, etc).
 * @param {String} value The value that the property was set to.
 */
nitobi.ui.StyleEventArgs = function(source, event, property, value)
{
	nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
	
	/**
	 * The style property that was set.
	 * @type String
	 */
	this.property = property || null;
	/**
	 * The new value of the property.
	 * @type String
	 */
	this.value = value || null;
}

nitobi.lang.extend(nitobi.ui.StyleEventArgs,nitobi.base.EventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * An interface that provides scrolling functionality.
 * @class An interface that provides scrolling functionality.
 * @constructor
 * @param {HTMLElement} element The element that can be scrolled.
 */
nitobi.ui.IScrollable = function(element)
{
	this.scrollableElement = element;
};

/**
 * Sets the element that can be scrolled.
 * @param {HTMLElement} el The element that can be scrolled.
 */
nitobi.ui.IScrollable.prototype.setScrollableElement = function(el)
{
	this.scrollableElement = el;
}

/**
 * Returns the element that is to be scolled.
 * @type HTMLElement
 */
nitobi.ui.IScrollable.prototype.getScrollableElement = function()
{
	return this.scrollableElement;
}

/**
 * Returns scrollLeft.
 * @type Number
 */
nitobi.ui.IScrollable.prototype.getScrollLeft = function()
{
	return this.scrollableElement.scrollLeft;
};

/**
 * Sets ScrollLeft
 * @param {Number} left The position.
 */
nitobi.ui.IScrollable.prototype.setScrollLeft = function(left)
{
	this.scrollableElement.scrollLeft = left; 
};

/**
 * Scrolls left by a specified amount or by 25.
 * @param {Number} scrollValue The amount by which to scroll. Default is 25.
 */
nitobi.ui.IScrollable.prototype.scrollLeft = function(scrollValue)
{
	scrollValue = scrollValue || 25
	this.scrollableElement.scrollLeft -= scrollValue; 
};

/**
 * Scrolls right by a specified amount or by 25.
 * @param {Number} scrollValue The amount by which to scroll. Default is 25.
 */
nitobi.ui.IScrollable.prototype.scrollRight = function(scrollValue)
{
	scrollValue = scrollValue || 25
	this.scrollableElement.scrollLeft += scrollValue; 
};

/**
 * Indicates whether the element has overflowed, ie, whether or not it is worth calling scroll functions.
 * @param {HTMLElement} reference The child element to test the container against. By default it is the scrollable
 * elements first child.
 */
nitobi.ui.IScrollable.prototype.isOverflowed = function(reference)
{
	reference = reference || this.scrollableElement.childNodes[0];
	return !(parseInt(nitobi.html.getBox(this.scrollableElement).width) >= parseInt(nitobi.html.getBox(reference).width));
};

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**************************************************************************/
/*					nitobi.ui.DragDrop	     	      
/**************************************************************************/
nitobi.lang.defineNs("nitobi.ui");
if (false)
{
	/**
	 * @namespace
	 * @constructor
	 */
	nitobi.ui = function(){};
}

/**
 * Start a drag/drop event.
 * @example
 * onmousedown="nitobi.ui.startDragOperation(this.parentNode,event)"
 * @param element {Object} The element to drag.
 * @param event {Object} Mozilla event object.
 * @param allowVertDrag {Boolean} True to allow vertical dragging.
 * @param allowHorizDrag {Boolean} True to allow horizontal dragging.
 * @param context {Object} The context to invoke the onMouseUpEvent handler.
 * @param onMouseUpEvent {Function} The method to invoke onmouseup
 */
nitobi.ui.startDragOperation = function(element, event, allowVertDrag, allowHorizDrag,context,onMouseUpEvent)
{
	var ddo = new nitobi.ui.DragDrop(element, allowVertDrag, allowHorizDrag);
	ddo.onDragStop.subscribe(onMouseUpEvent, context);
	ddo.startDrag(event);
}

/**
 * Create a DragDrop object to help manage drag/drop interactions.
 * @class A Drag and Drop library that allows the user to drag an element around the page.
 * @constructor
 * @example 
 * function mouseDownHandler(event)
 * {
 * 	var dd = new nitobi.ui.DragDrop(someDraggleElement, false, false);
 * 	dd.startDrag(event);
 * }
 * @param element {Object} The element to drag.
 * @param event {Object} Mozilla event object.
 * @param allowHorizDrag {Boolean} True to allow horizontal dragging.
 */
nitobi.ui.DragDrop = function(element, allowVertDrag, allowHorizDrag)
{
	this.allowVertDrag = (allowVertDrag!=null ? allowVertDrag : true)
	this.allowHorizDrag = (allowHorizDrag!=null ? allowHorizDrag : true)

	if (nitobi.browser.IE)
	{
		/**
		 * @private
		 */
		this.surface = document.getElementById("ebadragdropsurface_");
		if (this.surface == null)
		{
			this.surface = nitobi.html.createElement("div", {"id":"ebadragdropsurface_"}, {
				"filter":"alpha(opacity=1)",
				"backgroundColor":"white",
				"position":"absolute",
				"display":"none",
				"top":"0px",
				"left":"0px",
				"width":"100px",
				"height":"100px",
				"zIndex":"899"
			});
			document.body.appendChild(this.surface);		

		}
	}
	
	// What if the node is a text node.
	if (element.nodeType == 3) alert("Text node not supported. Use parent element");
	
	/**
	 * @ignore
	 */
	this.element = element;

	/**
	 * @ignore
	 */
	this.zIndex=this.element.style.zIndex;
  	this.element.style.zIndex=900;

	this.onMouseMove = new nitobi.base.Event();
	this.onDragStart = new nitobi.base.Event();
	this.onDragStop = new nitobi.base.Event();

    /**
     * These are the events for the drag and drop that are attached / detached all the time
     */
    this.events = [{"type":"mouseup","handler":this.handleMouseUp,"capture":true}, {"type":"mousemove","handler":this.handleMouseMove,"capture":true}];
}

/**
 * Starts the dragging operation.
 * @param {Object} event The dom event that triggered the drag operation.
 */
nitobi.ui.DragDrop.prototype.startDrag = function (event) {
	/**
	 * @ignore
	 */
  	this.elementOriginTop  = parseInt(this.element.style.top,  10);
  	/**
	 * @ignore
	 */
  	this.elementOriginLeft = parseInt(this.element.style.left, 10);
  	

  	if (isNaN(this.elementOriginLeft)) this.elementOriginLeft = 0;
  	if (isNaN(this.elementOriginTop )) this.elementOriginTop = 0;

	var coords = nitobi.html.getEventCoords(event);
	x = coords.x;
	y = coords.y;

  	/**
  	 * The x coordinate from where the object was dragged.
  	 * @type int 
  	 */	
	this.originX = x;
	 /**
  	 * The y coordinate from where the object was dragged.
  	 * @type int 
  	 */	
  	this.originY = y;

    nitobi.html.attachEvents(document, this.events, this);

  	nitobi.html.cancelEvent(event);

	this.onDragStart.notify();
}

/**
 * @private
 */
nitobi.ui.DragDrop.prototype.handleMouseMove = function (event) 
{
	var x, y;

	var coords = nitobi.html.getEventCoords(event);
	x = coords.x;
	y = coords.y;

	if (nitobi.browser.IE) 
	{
		// TODO: this should all be in getBodyArea and it should work...
		this.surface.style.display="block";
		if (document.compat == "CSS1Compat") {
			var bodyCoords = nitobi.html.getBodyArea();
			var offset = 0;
			// TODO: Fix this hack for IE standards
			// IE standards coords are off by a bit
			if (document.compatMode == "CSS1Compat")
				offset = 25;
			this.surface.style.width = (bodyCoords.clientWidth-offset) + "px";
			this.surface.style.height = (bodyCoords.clientHeight) + "px";
		} else {
			this.surface.style.width = document.body.clientWidth;
			this.surface.style.height = document.body.clientHeight;
		}
/*		if (document.compat == "CSS1Compat") {
			this.surface.style.width = document.documentElement.clientWidth + "px";
			this.surface.style.height = document.documentElement.clientHeight + "px";
		} else {
			this.surface.style.width = document.body.clientWidth;
			this.surface.style.height = document.body.clientHeight;
		}*/
	}

	if (this.allowHorizDrag) this.element.style.left = (this.elementOriginLeft + x - this.originX) + "px";
	if (this.allowVertDrag)  this.element.style.top  = (this.elementOriginTop  + y - this.originY) + "px";

	this.x=x;
	this.y=y;

	this.onMouseMove.notify(this);

	nitobi.html.cancelEvent(event);
}

/**
 * @private
 */
nitobi.ui.DragDrop.prototype.handleMouseUp = function(event)
{
	this.onDragStop.notify({"event":event,"x":this.x,"y":this.y});

    nitobi.html.detachEvents(document, this.events);

	if (nitobi.browser.IE)
		this.surface.style.display="none";

  this.element.style.zIndex = this.zIndex;
  this.element.object = null; 
  this.element = null;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
if (typeof(nitobi.ajax) == "undefined")
{
	/**
	 * @namespace The namespace for classes that make up 
	 * the Nitobi cross-browser HttpRequest.
	 * @constructor
	 */
	nitobi.ajax = function() {}
}

/**
 * Creates an XMLHttpRequest object.
 * @type XMLHttpRequest
 * @private
 */
nitobi.ajax.createXmlHttp = function()
{
	if (nitobi.browser.IE)
	{
		//	TODO: try all the XML HTTP objects starting from 5...
		var reservedObj = null;
		try
		{
			reservedObj = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				reservedObj = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(ee)
			{
			}
		}
		return reservedObj;
	}
	else if (nitobi.browser.XHR_ENABLED)
	{
		return new XMLHttpRequest();
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ajax");


/**
 * Creates an HttpRequest object.  After calling the constructor you can set up the object by setting
 * particular fields to the values you desire. 
 * @class Makes a cross browser XMLHttpRequest object and processes responses from the server.
 * @example
 * var xhr = new nitobi.ajax.HttpRequest();
 * xhr.handler = path + "data.xml";
 * xhr.async = true; // async is true by default
 * xhr.responseType = "xml"; // by default the appropriate responseType will be used - ie XML if the data is valid XML otherwise "text".
 * xhr.onGetComplete.subscribeOnce(function(evtArgs) {alert("In onGetComplete:\n" + nitobi.xml.serialize(evtArgs.response))});
 * xhr.completeCallback = function(evtArgs) {alert("In completeCallback:\n" + nitobi.xml.serialize(evtArgs.response))};
 * xhr.get();
 * @constructor
 * @extends nitobi.Object
 */
nitobi.ajax.HttpRequest = function()
{
	/**
	 * This is the URL of the server resource that data is being posted to or
	 * retrieved from.
	 * @type String
	 */
  	this.handler 		= '';
  	/**
  	 * This specifies if the requests should be made in an asynchronous or synchronous manner.
  	 * @type Boolean
  	 */
	this.async 	= true;
	/**
	 * This specifies if XML data or general text data is being retrieved from the server. 
	 * Valid values are "xml", "text" or "". Using "text" can be used for returning JSON data or any other
	 * data format including XML. The data passed to the callback method will be an XMLDocument if "xml" is
	 * specified as the responseType, it will be a String if "text" is specified.
	 * @type String
	 */
	this.responseType	= null;
	/**
	 * This is the underlying XMLHttpRequest object.
	 * @type XMLHttpRequest
	 * @private
	 */
	this.httpObj      	= nitobi.ajax.createXmlHttp();
	/**
	 * This is the Event that is fired when a POST request returns from the server.
	 * @type nitobi.base.Event
	 */
	this.onPostComplete	= new nitobi.base.Event();
	/**
	 * This is the Event that is fired when a GET request returns from the server.
	 * @type nitobi.base.Event
	 */
	this.onGetComplete	= new nitobi.base.Event();
	/**
	 * This is the Event that is fired when any request returns from the server.
	 * @type nitobi.base.Event
	 */
	this.onRequestComplete	= new nitobi.base.Event();
	/**
	 * This is a function reference to a function that is executed if there is an error during or after the request.
	 * @type nitobi.base.Event
	 */	
	this.onError		= new nitobi.base.Event();
	/**
	 * The length of time that can pass before the request is cancelled. A value of 0 indicates there is no timeout.
	 * @type Number
	 */
	this.timeout = 0;
	/**
	 * The ID of the window.setTimeout registration.
	 * @type Number
	 */
	this.timeoutId = null;
	/**
	 * This is a parameter object that can contain any information needed to be passed
	 * to the postComplete or getComplete functions after an asynchronous request has returned.
	 * This can be used to maintain state across an asynchronous request.
	 * @type Object
	 */
	this.params			= null;
	/**
	 * A copy of the data that is sent to the server in a post
	 * @type String
	 */
	this.data		= "";
	/**
	 * A function to execute when the request completes.
	 * @type Function
	 */
	this.completeCallback = null;
	/**
	 * The status. Either 'pending' or 'complete'.
	 * @type String
	 */
	this.status = "complete";
	/**
	 * Specifies if a unique querystring value should be sent with GET requests to prevent page caching.
	 * Default value is true.
	 */
	this.preventCache = true;

	/**
	 * The username to be sent to the server with the HTTP request.
	 */
	this.username = "";

	/**
	 * The password to be sent to the server with the HTTP request.
	 */
	this.password = "";

	/**
	 * This is used for keeping track of the method used when the HttpRequest open and send methods are used.
	 * @private
	 */
	this.requestMethod = "get";

	/**
	 * @private
	 */
	this.requestHeaders = {};
}

nitobi.lang.extend(nitobi.ajax.HttpRequest, nitobi.Object);

/**
 * Maximum number of concurrent connections. The default is 64.
 * @type Number
 */
nitobi.ajax.HttpRequestPool_MAXCONNECTIONS=64;

/**
 * This method takes the response from the server and checks the HTTP status 
 * to ensure that the server did not have any errors and returned valid XML.
 * @type {String | XMLDocument}
 * @private
 */
nitobi.ajax.HttpRequest.prototype.handleResponse = function()
{
  	var result = null;
  	var error = null;

   
	if ((this.httpObj.responseXML != null && this.httpObj.responseXML.documentElement != null) && this.responseType != "text")
	{
		result = this.httpObj.responseXML;
	}
	else if(this.responseType == "xml")
    {
    	result = nitobi.xml.createXmlDoc(this.httpObj.responseText);
    } 
    else
    {
        result = this.httpObj.responseText;
    }
    
	if (this.httpObj.status != 200)
	{
		this.onError.notify({"source":this,"status":this.httpObj.status,"message":"An error occured retrieving the data from the server. " +
				"Expected response type was '"+this.responseType+"'."});
	}

	return result;
}

/**
 * This method posts some data to the given url using the XMLHttpRequest object.
 * Various parameters such as asynchronous and handler should have already been set.
 * @param {String} data The only argument passed to this method is some data to post
 * to the server. It can be in any format such as XML or JSON.
 * @param {String} [url] The URL where the data is to be posted to. This is optional and can also be 
 * specified using the handler property.
 * @return If the request is synchronous, the content of the server response is 
 * returned as either XML data or plain text, depending on the response type
 * @type XMLDocument|String
 */
nitobi.ajax.HttpRequest.prototype.post = function(data, url)
{
	this.data = data;
	return this._send("POST", url, data, this.postComplete);
}

/**
 * This is used to retrieve data from the server.
 * It will retrieve data from the URL specified by the handler property of the Callback object.
 * @return If the request is synchronous, the content of the server response is 
 * returned as either XML data or plain text, depending on the response type
 * @param {String} url The URL to request the data from. This is an alternative to setting the handler parameter.
 * @type String|XMLDocument
 */
nitobi.ajax.HttpRequest.prototype.get = function(url)
{
	return this._send("GET", url, null, this.getComplete)
}

/**
 * @ignore
 */
nitobi.ajax.HttpRequest.prototype.postComplete = function()
{
    if(this.httpObj.readyState==4)
    {
    	this.status = "complete";
    	var callbackParams = {'response':this.handleResponse(),'params':this.params};
    	this.responseXml = this.responseText = callbackParams.response;
    	this.onPostComplete.notify(callbackParams);
    	this.onRequestComplete.notify(callbackParams);
    	if (this.completeCallback)
    	{
    		this.completeCallback.call(this, callbackParams);
    	}
	}
}

/**
 * This does various assertions on XMLData then calls postData.
 * If xmlData is has no valid child nodes the just return
 * @param {XmlNode} xmlData The single argument passed to this method is a valid XML DOM object.
 * @return If the request is synchronous, the content of the server response is 
 * returned as either XML data or plain text, depending on the response type
 * @type XMLDocument|String
 */
nitobi.ajax.HttpRequest.prototype.postXml = function(xmlData)
{
	this.setTimeout();

    // validate the XML data parameter
    if(("undefined" == typeof(xmlData.documentElement)) || 
       (null == xmlData.documentElement) || 
       ("undefined" == typeof(xmlData.documentElement.childNodes)) ||
       (1 > xmlData.documentElement.childNodes.length))
    {
        ebaErrorReport("updategram is empty. No request sent. xmlData[" + xmlData + "]\nxmlData.xml[" + xmlData.xml + "]");
        // not sure that return is best here.
        return; 
    }

    //  get data from xml (null == xmlData.xml)
    if(null == xmlData.xml)
	{
            // looks like we are not running nitobi.browser.IE
            // lets try to get xml data            
            var xmlSerializer = new XMLSerializer();
            xmlData.xml     = xmlSerializer.serializeToString(xmlData);
	}
	return this.post(xmlData.xml);
}

/**
 * @private
 * Actually makes the Ajax request whether it is called through 
 * <code>post</code>, <code>get</code>, or <code>send</code>.
 */
nitobi.ajax.HttpRequest.prototype._send = function(method, url, data, completeHandler)
{
	this.handler = url || this.handler;
	this.setTimeout();

	this.status = "pending";

	this.httpObj.open(method, (this.preventCache?this.cacheBust(this.handler):this.handler), this.async, this.username, this.password);

    if (this.async)
	    this.httpObj.onreadystatechange = nitobi.lang.close(this, completeHandler);

	for (var item in this.requestHeaders) {
		this.httpObj.setRequestHeader(item, this.requestHeaders[item]);
	}

	if (this.responseType == "xml")
	    this.httpObj.setRequestHeader("Content-Type","text/xml");
	else if (method.toLowerCase() == "post")
		this.httpObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

	// TODO: check if the data is a form. if so then serialize it
	/*
	if (data.tagName == "form") {
		var s = "";
		for (var i=0; i<data.elements; i++) {
			var e = data.elements[i];
			s += e.name + "=" + e.value + "&";
		}
		data = s;
	}
	 */

    this.httpObj.send(data);

	if (!this.async)
		return this.handleResponse();
	return this.httpObj;
}

/**
 * Compatibility with the native XMLHttpRequest object. Opens the connection to the server.
 * After calling open headers can be set and the request can be sent using the <code>send</code> method.
 * @param {String} method The method for fetching data, either "get" or "post"
 * @param {String} url The url of the connection to open.
 * @param {Boolean} async Whether or not make the connection asynchronous.
 * @param {String} [username] The username for the connection.
 * @param {String} [password] The password for the connection.
 */
nitobi.ajax.HttpRequest.prototype.open = function(method, url, async, username, password) {
	this.requestMethod = method;
	this.async = async;
	this.username = username;
	this.password = password;
	this.handler = url;
}

/**
 * Compatible with the native XMLHttpRequest object. Sends the request to the server.
 * @param {String} data The data to send to the server, if the request method is "post".
 */
nitobi.ajax.HttpRequest.prototype.send = function(data) {
	// TODO: Do we want to ensure that the url is specified?
	var response = null;
	switch (this.requestMethod.toUpperCase())
	{
		case "POST":
			response = this.post(data);
			break;
		default:
			response = this.get();
			break
	}
	this.responseXml = this.responseText = response;
}

/**
 * @private
 */
nitobi.ajax.HttpRequest.prototype.setTimeout = function()
{
	if (this.timeout > 0)
	{
		this.timeoutId = window.setTimeout(nitobi.lang.close(this, this.abort), this.timeout);
	}
}

/**
 * The onReadyStateChange event is used internally for monitoring the 
 * readyState of the XMLHttpRequest when data is being retrieved from the server.
 * When the readyState is 4 then it will call the function pointer onGetComplete.
 * @private
 */
nitobi.ajax.HttpRequest.prototype.getComplete = function()
{
    if(this.httpObj.readyState==4)
    {
    	this.status = "complete";

    	var callbackParams = {'response':this.handleResponse(),'params':this.params,'status':this.httpObj.status,'statusText':this.httpObj.statusText};
    	this.responseXml = this.responseText = callbackParams.response;
    	this.onGetComplete.notify(callbackParams);
    	this.onRequestComplete.notify(callbackParams);
    	if (this.completeCallback)
    	{
    		this.completeCallback.call(this, callbackParams);
    	}
	}
}

/**
 * Sets a request header on the XMLHttpRequest. The header name-value pair is added to the <code>requestHeaders</code> hash.
 * @param {String} header The header name.
 * @param {String} val The header value.
 */
nitobi.ajax.HttpRequest.prototype.setRequestHeader = function(header, val)
{
	this.requestHeaders[header] = val;
}

/**
 * Indicates whether or not the specified status code indicates an error.
 * @param {Number} code The status code.
 * @type Boolean
 */
nitobi.ajax.HttpRequest.prototype.isError = function(code)
{
	return (code >= 400 && code < 600);
}

/**
 * Cancels the server request.
 */
nitobi.ajax.HttpRequest.prototype.abort = function()
{
	this.httpObj.onreadystatechange = function () {};
	this.httpObj.abort();
}

/**
 * This method clears the state of the Callback object to its initial state.
 * @private
 */
nitobi.ajax.HttpRequest.prototype.clear = function()
{
  	this.handler 		= '';
	this.async 	= true;
	this.onPostComplete.dispose();
	this.onGetComplete.dispose();
	this.params = null;
}

/**
 * Adds a cache-busting querystring parameter to the request.
 * @private
 */
nitobi.ajax.HttpRequest.prototype.cacheBust = function(url)
{
	var urlArray = url.split('?');
	var param = 'nitobi_cachebust=' + (new Date().getTime());
	if (urlArray.length == 1)
		url += '?' + param;
	else
		url += '&' + param;
	return url;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @class A class to manage {@link nitobi.ajax.HttpRequest} objects.
 * @constructor This class is a singleton.  Do not instantiate it; use {@link #getInstance} instead.
 * @param {Number} maxObjects The maximum number of HttpRequest objects in the pool.  Defaults to the value 
 * defined in nitobi.ajax.HttpRequestPool_MAXCONNECTIONS
 */
nitobi.ajax.HttpRequestPool = function(maxObjects)
{
	/**
	 * @private
	 */
	this.inUse = new Array();
	/**
	 * @private
	 */
	this.free = new Array();
	/**
	 * @private
	 */
	this.max = maxObjects || nitobi.ajax.HttpRequestPool_MAXCONNECTIONS;
	/**
	 * @private
	 */
	this.locked = false;
	/**
	 * @private
	 */
	this.context = null;
}

/**
 * Retrieves an HttpRequest object from the pool. If there are no available objects it will create a new one until the
 * maximum number of objects are created.
 * @type nitobi.ajax.HttpRequest
 */
nitobi.ajax.HttpRequestPool.prototype.reserve = function()
{
	// A blocking lock for thread safety
	//	TODO: This should be changed into a callback to prevent user interface locking ...
//		while (this.locked) {}

	this.locked = true;

	var reservedObj;

	if (this.free.length)
	{
		reservedObj = this.free.pop();
		reservedObj.clear();
		this.inUse.push(reservedObj);
	}
	else if(this.inUse.length < this.max)
	{
		try
		{
			reservedObj = new nitobi.ajax.HttpRequest();
		}
		catch(e)
		{
			reservedObj=null;
		}

		this.inUse.push(reservedObj);
	}
	else
	{
		throw "No request objects available";
	}

	this.locked = false;
	return reservedObj;
}

/**
 * Returns an HttpRequest object back to the pool.
 * @param {nitobi.ajax.HttpRequest} resource The resource to return to the pool.
 */
nitobi.ajax.HttpRequestPool.prototype.release = function(resource)
{
	var found = false;
	// A blocking lock for thread safety - necessary in javascript?
	//while (this.locked) {}
	this.locked = true;
	if (null != resource)
	{
		for (var i=0; i < this.inUse.length; i++)
		{
			if (resource == this.inUse[i])
			{
				this.free.push(this.inUse[i]);
				this.inUse.splice(i,1);
				found = true;
				break;
			}
		}
	}
	this.locked = false;

	return null;
}

/**
 * @ignore
 */
nitobi.ajax.HttpRequestPool.prototype.dispose = function()
{
	for (var i=0; i<this.inUse.length; i++)
	{
		this.inUse[i].dispose();
	}
	this.inUse = null;
	for (var j=0; j<this.free.length; j++)
	{
		this.free[i].dispose();
	}
	this.free = null;
}

/**
 * @private
 */
nitobi.ajax.HttpRequestPool.instance = null;
/**
 * Returns the globally used HttpRequestPool instance.
 * @type nitobi.ajax.HttpRequestPool
 */
nitobi.ajax.HttpRequestPool.getInstance = function()
{
	if (nitobi.ajax.HttpRequestPool.instance == null)
	{
		nitobi.ajax.HttpRequestPool.instance = new nitobi.ajax.HttpRequestPool();
	}
	return nitobi.ajax.HttpRequestPool.instance;
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.data');

nitobi.data.UrlConnector = function(url, transformer)
{
	/**
	 * The URL that is used as the data provider.
	 * @type String 
	 */
	this.url = url || null;
	/**
	 * The XSL processor that is used to transform the data returned from the provider. Can also be a function
	 * whose input and outputs are XML Documents. Can also be a XSLTProcessor.
	 * @type Function 
	 */
	this.transformer = transformer || null;
	/**
	 * Whether the request to the server will be a blocking or asynchronous request
	 * @type Boolean
	 */
	this.async = true;
};

/**
 * Returns the XML document from the connector's url, transformed by the connector's <CODE>transformer</CODE>. 
 * @type XMLDocument
 */
nitobi.data.UrlConnector.prototype.get = function(params, dataReadyCallback)
{
	this.request = nitobi.data.UrlConnector.requestPool.reserve();
	var handler = this.url;
	for (var p in params)
	{
		handler = nitobi.html.Url.setParameter(handler,p,params[p]);
	}
	this.request.handler = handler;
	this.request.async = this.async;
	this.request.responseType = "xml";
	this.request.params = {dataReadyCallback: dataReadyCallback};
	this.request.completeCallback = nitobi.lang.close(this,this.getComplete);
	this.request.get();
};

/**
 * @ignore
 */
nitobi.data.UrlConnector.prototype.getComplete = function(eventArgs)
{
	if (eventArgs.params.dataReadyCallback)
	{
		var response = eventArgs.response;
		var dataReadyCallback = eventArgs.params.dataReadyCallback;
		// response should be an xml doc.
		var result = response;
		if (this.transformer)
		{
			if (typeof(this.transformer) === 'function')
			{
				result = this.transformer.call(null, response);
			}
			else
			{
				result = nitobi.xml.transform(response,this.transformer,'xml');
			}
		}
		
		if (dataReadyCallback)
		{
			dataReadyCallback.call(null, {result: result, response: eventArgs.response});
		}
	}
	
	nitobi.data.UrlConnector.requestPool.release(this.request);
	
};

/**
 * @ignore
 */
nitobi.data.UrlConnector.requestPool = new nitobi.ajax.HttpRequestPool();


/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
/**
 * @private
 * @deprecated nitobi.lang.throwError should be used
 */
function ntbAssert(predicate ,errorMessage, errorCode, errorSeverity) 
{
}


nitobi.lang.defineNs("console");
nitobi.lang.defineNs("nitobi.debug");

if (typeof(console.log) == "undefined")
{
	/**
	 * Write to the console.
	 * @param {String} s The string to write.
	 */
	console.log = function(s)
	{
		nitobi.debug.addDebugTools();
		var t = $ntb('nitobi.log');
		t.value = s + "\n" + t.value 
	}
	
	console.evalCode = function()
	{
		var result = (eval($ntb("nitobi.consoleEntry").value));

	}
}

/**
 * This function will create a textarea in which debug information can be written to.
 */
nitobi.debug.addDebugTools = function()
{
	var sId = 'nitobi_debug_panel';
	var div = document.getElementById(sId);
	var html = "<table width=100%><tr><td width=50%><textarea style='width:100%' cols=125 rows=25 id='nitobi.log'></textarea></td><td width=50%><textarea style='width:100%' cols=125 rows=25 id='nitobi.consoleEntry'></textarea><br/><button onclick='console.evalCode()'>Eval</button></td></tr></table>";
	if (div == null)
	{
		var div = document.createElement("div");
		div.setAttribute('id', sId);
		div.innerHTML = html;
		document.body.appendChild(div);
	}
	else if (div.innerHTML == "")
		div.innerHTML = html;
}

/**
 * @private
 * @deprecated Use nitobi.lang.throwError instead.
 */
 nitobi.debug.assert = function()
 {
 		
 }
 
 
/**
 * This should all be deleted.
 */

/**
 * @ignore
 * @private
 */
EBA_EM_ATTRIBUTE_ERROR 		  	= 1;  
/**
 * @ignore
 * @private
 */
EBA_XHR_RESPONSE_ERROR			= 2;
/**
 * @ignore
 * @private
 */
EBA_DEBUG = "debug";
/**
 * @ignore
 * @private
 */
EBA_WARN  = "warn";
/**
 * @ignore
 * @private
 */
EBA_ERROR = "error";
/**
 * @ignore
 * @private
 */
EBA_THROW = "throw";
/**
 * @ignore
 * @private
 */
EBA_DEBUG_MODE = false;
/**
 * @ignore
 * @private
 */
EBA_ON_ERROR        = "";
/**
 * @ignore
 * @private
 */
EBA_LAST_ERROR      = "";
/**
 * @ignore
 * @private
 */
_ebaDebug = false;

/**
 * @ignore
 * @private
 */
NTB_EM_ATTRIBUTE_ERROR 		  	= 1;  
/**
 * @ignore
 * @private
 */
NTB_XHR_RESPONSE_ERROR			= 2;
/**
 * @ignore
 * @private
 */
NTB_DEBUG = "debug";
/**
 * @ignore
 * @private
 */
NTB_WARN  = "warn";
/**
 * @ignore
 * @private
 */
NTB_ERROR = "error";
/**
 * @ignore
 * @private
 */
NTB_THROW = "throw";
/**
 * @ignore
 * @private
 */
NTB_DEBUG_MODE = false;
/**
 * @ignore
 * @private
 */
NTB_ON_ERROR        = "";
/**
 * @ignore
 * @private
 */
NTB_LAST_ERROR      = "";
/**
 * @ignore
 * @private
 */
_ebaDebug = false;
/**
 * @ignore
 * @private
 */
function _ntbAssert(condition, description)
{
	ntbAssert(condition,description,"",DEBUG);
}

/**
 * @ignore
 * @private
 */
function ebaSetOnErrorEvent(handler)
{
	nitobi.debug.setOnErrorEvent.apply(this, arguments);
}

/**
 * @ignore
 * @private
 */
nitobi.debug.setOnErrorEvent = function(handler)
{
	NTB_ON_ERROR = handler;
};

/**
 * @ignore
 * @private
 */
function ebaReportError(errorMessage, errorCode, errorSeverity){
	nitobi.debug.errorReport("dude stop calling this method it is now called nitobi.debug.errorReport","");
	nitobi.debug.errorReport(errorMessage, errorCode, errorSeverity);
}

/**
 * @ignore
 * @private
 */
function ebaErrorReport(errorMessage, errorCode, errorSeverity) 
{
	nitobi.debug.errorReport.apply(this, arguments);
}

/**
 * @ignore
 * @private
 */
nitobi.debug.errorReport = function(errorMessage, errorCode, errorSeverity) 
{
	// if empty set to debug
	errorSeverity = (errorSeverity)?errorSeverity:NTB_DEBUG;

	if(NTB_DEBUG == errorSeverity && !NTB_DEBUG_MODE)
	{
		// maybe set a lastdebug anyway
		return;
	}	

	 var errorString  =   errorMessage          +
	                      "\nerror code    ["  +
	                      errorCode             +
	                      "]\nerror Severity["  +
	                      errorSeverity         +
	                      "]";

	LastError = errorString;
	
	
	//this should be made into an object with each spreadsheet creating an instance of error reporter
	if(eval(NTB_ON_ERROR || "true"))
	{	
		switch(errorCode)
		{		
			case NTB_EM_ATTRIBUTE_ERROR:
				confirm(errorMessage);
			break;
			case NTB_XHR_RESPONSE_ERROR:
				confirm(errorMessage);
			break;
			default:
				window.status = errorMessage;	
			break;
		}		
	}
	if(NTB_THROW == errorSeverity)
	{
		throw(errorString);
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
if (false)
{
	/**
	 * @namespace This namespace contains specific error messages, the global {@link nitobi.error#onError}
	 * event, and the {@link nitobi.error.ErrorEventArgs} class.
	 * @private
	 * @constructor
	 */
	nitobi.error = function(){};
}

nitobi.lang.defineNs('nitobi.error');

/**
 * Any errors that are thrown by the browser and can not be passed along to the caller script
 * are notified here. {@link nitobi.error.ErrorEventArgs} is passed as an argument.
 * @type nitobi.base.Event
 */
nitobi.error.onError = new nitobi.base.Event();
if (nitobi)
{
	if (nitobi.testframework)
	{
		if (nitobi.testframework.initEventError)
		{
			nitobi.testframework.initEventError();			
		}
	}
}

/**
 * Creates an event arguments object based on the given parameters.
 * @class Arguments that are passed when nitobi.error.onError fires.
 * @constructor
 * @param {Object} source The object that fired the event.
 * @param {String} description A human-readable description of the error.
 * @param {String} type The type of object that threw the error.
 * @private
 * @extends nitobi.base.EventArgs
 */
nitobi.error.ErrorEventArgs = function(source, description, type)
{
	nitobi.error.ErrorEventArgs.baseConstructor.call(this,source);	

	/**
	 * The error description.
	 * @type String
	 */
	this.description = description;
	/**
	 * The type of object that threw the error.
	 * @type String
	 */
	this.type = type;
}

nitobi.lang.extend(nitobi.error.ErrorEventArgs,nitobi.base.EventArgs);

/**
 * Returns true if the error is the specified error.
 * @param {String} err The error you have.
 * @param {String} checkError The error you want to check against.
 * @type Boolean
 */
nitobi.error.isError = function(err, checkError)
{
	return (err.indexOf(checkError) > -1);	
}

/**
 * Array index out of bounds.
 * @type String
 */
nitobi.error.OutOfBounds = "Array index out of bounds.";
/**
 * An unexpected error occurred.
 * @type String
 */
nitobi.error.Unexpected = "An unexpected error occurred.";
/**
 * The argument is null and not optional.
 * @type String
 */
nitobi.error.ArgExpected = "The argument is null and not optional.";
/**
 * The argument is not of the correct type.
 * @type String
 */
nitobi.error.BadArgType = "The argument is not of the correct type.";
/**
 * The argument is not a valid value.
 * @type String
 */
nitobi.error.BadArg = "The argument is not a valid value.";
/**
 * The XML did not parse correctly.
 * @type String
 */
nitobi.error.XmlParseError = "The XML did not parse correctly.";
/**
 * The HTML declaration could not be parsed.
 * @type String
 */
nitobi.error.DeclarationParseError = "The HTML declaration could not be parsed.";
/**
 * The object does not support the properties or methods of the expected interface. Its class must implement the required interface.
 * @type String
 */
nitobi.error.ExpectedInterfaceNotFound = "The object does not support the properties or methods of the expected interface. Its class must implement the required interface.";
/**
 * No HTML node found with id.
 * @type String
 */
nitobi.error.NoHtmlNode = "No HTML node found with id.";
/**
 * The XML node has no owner document.
 * @type String
 */
nitobi.error.OrphanXmlNode = "The XML node has no owner document.";
/**
 * The HTML page could not be loaded.
 * @type String
 */
nitobi.error.HttpRequestError = "The HTML page could not be loaded.";
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.html');

/**
 * Instantiates a Renderer object with a given template.
 * @class The interface for an HTML renderer.  A renderer contains a template and can transform
 * data into a string that is written to an HTML document.  Classes implementing IRenderer must provide 
 * their own <CODE>renderToString</CODE> method.
 * @constructor 
 * @param {Object} template The template used by this renderer.
 */
nitobi.html.IRenderer = function(template)
{
	this.setTemplate(template);
	/**
	 * A key-value map of parameters to pass to the template on render.
	 * @type Map
	 */
	this.parameters = {};
};

/**
 * Render the data <I>after</I> a given HTML DOM node.  That is, the first node created by the renderer 
 * will be <CODE>element.nextSibling</CODE>.
 * @param {HTMLElement} element render after this element
 * @param {Object} data the data to render 
 * @return an array containing the <CODE>HTMLElement</CODE>s rendered
 * @type Array
 */
nitobi.html.IRenderer.prototype.renderAfter = function(element, data)
{
	element = $ntb(element);
	var _parent = element.parentNode;
	element = element.nextSibling;	
	return this._renderBefore(_parent,element,data);
};

/**
 * Render the data <I>before</I> a given HTML DOM node.  That is, the last node created by the renderer 
 * will be <CODE>element.previousSibling</CODE>.
 * @param {HTMLElement} element render before this element
 * @param {Object} data the data to render 
 * @returns an array containing the <CODE>HTMLElement</CODE>s rendered
 * @type Array
 */

nitobi.html.IRenderer.prototype.renderBefore = function(element, data)
{
	element = $ntb(element);
	return this._renderBefore(element.parentNode, element, data);
};

/**
 * Render the data <I>before</I> a given HTML DOM node.  That is, the last node created by the renderer 
 * will be <CODE>element.previousSibling</CODE>.
 * @param {HTMLElement} _parent <CODE>element</CODE> must be a child of this node
 * @param {HTMLElement} element render before this element
 * @param {Object} data the data to render 
 * @returns {Array} an array containing the <CODE>HTMLElement</CODE>s rendered
 * @type Array
 * @private
 */
nitobi.html.IRenderer.prototype._renderBefore = function(_parent, element, data)
{
	var s = this.renderToString(data);
	var tempNode = document.createElement('div');
	tempNode.innerHTML = s;

	var nodeSet = new Array();
	if (tempNode.childNodes)
	{
		var i = 0;
		while (tempNode.childNodes.length)
		{
			nodeSet[i++] = tempNode.firstChild;
			_parent.insertBefore(tempNode.firstChild,element);
		}
	}
	else
	{
		// TODO: Throw an error.
	}	
	return nodeSet;	
};

/**
 * Render the data <I>in</I> a given HTML DOM node.  The renderer will overwrite the contents of 
 * <CODE>element</CODE> with the result.
 * @param {HTMLElement} element render in this element
 * @param {Object} data the data to render 
 * @returns An array containing the <CODE>HTMLElement</CODE>s rendered
 * @type Array
 */
nitobi.html.IRenderer.prototype.renderIn = function(element, data)
{
	element = $ntb(element);
	var s = this.renderToString(data);
	element.innerHTML = s;
	return element.childNodes;
};

/**
 * Render the data to a string.  This method must exist in every class that implements <CODE>IRenderer</CODE>.
 * @param {Object} data the data to render
 * @returns The data transformed by the renderer's template
 * @type String
 */
nitobi.html.IRenderer.prototype.renderToString = function(data)
{
	
};

/**
 * Sets the renderer's template.
 * @param {Object} template
 */
nitobi.html.IRenderer.prototype.setTemplate = function(template)
{
	this.template = template;
};

/**
 * Returns the renderer's template. 
 * @type Object
 */
nitobi.html.IRenderer.prototype.getTemplate = function()
{
	return this.template;
};

/**
 * Set parameters for the template.
 * @param {Map} parameters the parameters to set on the template.
 */
nitobi.html.IRenderer.prototype.setParameters = function(parameters)
{
	for (var p in parameters)
	{
		this.parameters[p] = parameters[p];
	}
};

/**
 * Returns the <CODE>Map</CODE> of parameters that are applied to the template when rendering.
 * @type Map
 */ 
nitobi.html.IRenderer.prototype.getParameters = function()
{
	return this.parameters;
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.html');

/**
 * Creates an XslRenderer with an optional template.
 * @class XslRenderer
 * Renders before, after, or to the contents of a given dom node.  The renderer maintains an 
 * XSLProcessor for a template and is provided with an XMLDocument when rendering.
 * @constructor 
 * @param {XSLProcessor|XMLDocument|String} template an XSL Processor to use as the template 
 */
nitobi.html.XslRenderer = function(template)
{
	nitobi.html.IRenderer.call(this, template);
};

nitobi.lang.implement(nitobi.html.XslRenderer, nitobi.html.IRenderer);


/**
 * Sets the renderer's template.
 * @param {XSLProcessor|XMLDocument|String} template an XSL Processor to use as the template 
 */
nitobi.html.XslRenderer.prototype.setTemplate = function(template)
{
	if (typeof(template) === 'string')
	{
		template = nitobi.xml.createXslProcessor(template);
	}
	this.template = template;
};

/**
 * Transform the given data with the template.
 * @param {XMLDocument|String} data the data to transform.
 * @return The result of the transformation as a string.
 * @type String
 */
nitobi.html.XslRenderer.prototype.renderToString = function(data)
{
	if (typeof(data) === 'string')
	{
		data = nitobi.xml.createXmlDoc(data);
	}
	if (nitobi.lang.typeOf(data) === nitobi.lang.type.XMLNODE)
	{
		data = nitobi.xml.createXmlDoc(nitobi.xml.serialize(data));
	}
	var template = this.getTemplate();
	var params = this.getParameters();
	for (var p in params)
	{
		template.addParameter(p, params[p], '');
	}
	var s = nitobi.xml.transformToString(data,template,'xml');
	for (var p in params)
	{
		template.addParameter(p, '', '');
	}
	return s;
		
};

/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * @private
 */
NTB_CSS_HIDE = 'nitobi-hide';

/**
 * Creates an Element.
 * @class An abstract class that represents an element.  It abstracts the relationship between custom tags in the Nitobi
 * library and their html representation in the browser.  Many Nitobi components extend this class.  
 * @constructor
 * @param {String|XMLNode|HTMLElement} id The id of an element, or the node representing an element, or an HTML declaration for the element.
 * @extends nitobi.Object
 * @implements nitobi.base.ISerializable
 * @implements nitobi.ui.IStyleable
 */
nitobi.ui.Element = function(id)
{
	nitobi.ui.Element.baseConstructor.call(this);
	// ISerializable is initialized below so that we don't have to re-initialize it with another node.
	nitobi.ui.IStyleable.call(this);
	
	if (id != null)
	{
		if (nitobi.lang.typeOf(id) == nitobi.lang.type.XMLNODE)
		{
			// Assume that id is an XmlNode.
			nitobi.base.ISerializable.call(this,id);
		}
		else if ($ntb(id) != null)
		{
			// Assume a decl.
			var decl = new nitobi.base.Declaration();
			var xmlNode = decl.loadHtml($ntb(id));

			var oldContainer = $ntb(id);
			var parentNode = oldContainer.parentNode;
			var wrapper = parentNode.ownerDocument.createElement('ntb:component');
			parentNode.insertBefore(wrapper, oldContainer);
			parentNode.removeChild(oldContainer);
			this.setContainer(wrapper);

			nitobi.base.ISerializable.call(this,xmlNode);
						
		} else
		{
			nitobi.base.ISerializable.call(this);
			// Assume string.
			this.setId(id);
		}
	}
	else
	{
		nitobi.base.ISerializable.call(this);
	}
	
	/**
	 * @ignore
	 */
	this.eventMap = {};
	
	/**
	 * Fired when the object is created. {@link nitobi.ui.ElementEventArgs} are passed to the listener.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onCreated = new nitobi.base.Event("created");
	this.eventMap["created"] = this.onCreated;
	
	
	// API Events
	/**
	 * Fired on before render. {@link nitobi.ui.ElementEventArgs} are passed to the listener.
	 * @type nitobi.base.Event
	 */
	this.onBeforeRender = new nitobi.base.Event("beforerender");
	this.eventMap["beforerender"] = this.onBeforeRender;
	
	/**
	 * Fired on render. {@link nitobi.ui.ElementEventArgs} are passed to the listener.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onRender = new nitobi.base.Event("render");
	this.eventMap["render"] = this.onRender;
	
	/**
	 * Fired on before set visible. {@link nitobi.ui.ElementEventArgs} are passed to the listener.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onBeforeSetVisible = new nitobi.base.Event("beforesetvisible");
	this.eventMap["beforesetvisible"] = this.onBeforeSetVisible;
	/**
	 * Fired on set visible. {@link nitobi.ui.ElementEventArgs} are passed to the listener.
	 * @see nitobi.ui.ElementEventArgs
	 * @type nitobi.base.Event
	 */
	this.onSetVisible = new nitobi.base.Event("setvisible");
	this.eventMap["setvisible"] = this.onSetVisible;
	
	/**
	 * Fires before the element propagates an event 
	 * down the tree. If false is returned, then the propagation does
	 * not occur. If true is returned, then the default
	 * propagation occurs. EventNotificationEventArgs are passed to the event handler.
	 * @see nitobi.ui.EventNotificationEventArgs
	 * @private
	 * @type nitobi.base.Event;
	 */
	this.onBeforePropagate = new nitobi.base.Event("beforepropagate");
	
	/**
	 * Fired when the event needs handling by this object. EventNotificationEventArgs are passed to the event handler.
	 * @see nitobi.ui.EventNotificationEventArgs
	 * @private
	 * @type nitobi.base.Event;
	 */
	this.onEventNotify = new nitobi.base.Event("eventnotify");
	
	/**
	 * Fired before the object is notified. If this event returns false, then this.onEventNotify is not called. EventNotificationEventArgs are passed to the event handler.
	 * @see nitobi.ui.EventNotificationEventArgs
	 * @type nitobi.base.Event;
	 * @private
	 */
	this.onBeforeEventNotify = new nitobi.base.Event("beforeeventnotify");
		
	/**
	 * Fires before the element propagates an event 
	 * down the tree. If false is returned, then the propagation does
	 * not occur. If true is returned, then the default
	 * propagation occurs. This differs from onBeforeProgagate because
	 * at this point the childId is available. EventNotificationEventArgs are passed to the event handler.
	 * @see nitobi.ui.EventNotificationEventArgs
	 * @private
	 * @type nitobi.base.Event;
	 */
	this.onBeforePropagateToChild = new nitobi.base.Event("beforepropogatetochild");

	
	this.subscribeDeclarationEvents();
	
	this.setEnabled(true);
	
	/**
	 * The xsl document responsible for rendering the component.
	 * @type nitobi.html.XslRenderer
	 */
	this.renderer = new nitobi.html.XslRenderer();
	
};

nitobi.lang.extend(nitobi.ui.Element, nitobi.Object);
nitobi.lang.implement(nitobi.ui.Element,nitobi.base.ISerializable);
nitobi.lang.implement(nitobi.ui.Element,nitobi.ui.IStyleable);

/**
 * A cache of html nodes.
 * @ignore
 */
nitobi.ui.Element.htmlNodeCache = {};

/**
 * @private
 */
nitobi.ui.Element.prototype.setHtmlNode = function(htmlNode)
{
	var node = $ntb(htmlNode);
	this.htmlNode = node;
};

/**
 * Return the root's id.
 * @private
 */
nitobi.ui.Element.prototype.getRootId = function()
{
	var _parent = this.getParentObject();
	if (_parent == null)
	{
		return this.getId();
	}	
	else
	{
		return _parent.getRootId();
	}
}

/**
 * Returns the id of this object.
 * @type String
 */
nitobi.ui.Element.prototype.getId = function()
{
	return this.getAttribute("id");
}

/**
 * Each element has an id; sub elements have a name that is appended
 * to the id; this function retrieves both the "id" and the "localName" 
 * in a map.
 * @param {String} id The full id of the sub element.
 * @type Map
 */
nitobi.ui.Element.parseId = function(id)
{
	var ids = id.split(".");
	if (ids.length <= 2)
		return {localName:ids[1],id:ids[0]};
	return {localName:ids.pop(),id:ids.join('.')};
}

/**
 * Sets the id of the object.
 * @param {String} id The id to set.
 */
nitobi.ui.Element.prototype.setId = function (id)
{
	this.setAttribute("id",id);
}

/**
 * A catch all event notifier. If the child class does not override this function,
 * then element will just fire the event, whatever it is.
 * @private
 */
nitobi.ui.Element.prototype.notify = function(event, id, propagationList, cancelBubble)
{
	try
	{
		event = nitobi.html.getEvent(event);
		if (cancelBubble !== false)
		{
			nitobi.html.cancelEvent(event);
		}
		var targetId = nitobi.ui.Element.parseId(id).id;
		
		// If notify is called on this element, and the target doesn't exist here
		// then just return;
		if (!this.isDescendantExists(targetId))
		{
			return false;
		}
		var propagate = !(targetId == this.getId());
		var eventArgs = new nitobi.ui.ElementEventArgs(this,null,id);
		var eventNotificationArgs = new nitobi.ui.EventNotificationEventArgs(this,null,id,event);
		propagate = propagate && this.onBeforePropagate.notify(eventNotificationArgs);
		var result=true;
		if (propagate)
		{
			if (propagationList == null)
			{
				propagationList = this.getPathToLeaf(targetId);								
			}
			var fireNotify = this.onBeforeEventNotify.notify(eventNotificationArgs);
			var eventResult = (fireNotify ? this.onEventNotify.notify(eventNotificationArgs) : true);
			var nextId = propagationList.pop().getAttribute("id");
			var nextObject = this.getObjectById(nextId);
			var result = this.onBeforePropagateToChild.notify(eventNotificationArgs);
			if (nextObject.notify && result && eventResult)
			{
				result = nextObject.notify(event,id,propagationList,cancelBubble);
			}
		}
		else
		{
			result = this.onEventNotify.notify(eventNotificationArgs);
		}
		
		// Notify the nitobi event object for this event, if one exists.
		// e.g. if the event is onclick, then lookup to see if an Event object exists (e.g. this.onClick = new nitobi.base.Event())
		// and if it does, fire it.
		var objEvent = this.eventMap[event.type];
		if (objEvent != null && result)
		{
			objEvent.notify(this.getEventArgs(event, id));
		}
		
		return result;
	}
	catch(err)
	{
		nitobi.lang.throwError(nitobi.error.Unexpected + " Element.notify encountered a problem.",err);
	}
}

/**
 * Returns the event arguments, given the parameters of the event.
 * @param {Event} event the HTML event that is firing
 * @param {String} targetId the id of the node on which the event is firing  
 * @private
 */
nitobi.ui.Element.prototype.getEventArgs = function(event, targetId)
{
	var eventArgs = new nitobi.ui.ElementEventArgs(this,null,targetId)
	return eventArgs;
};

/**
 * Subscribes any events found in the decl to the corresponding event object.
 * @private
 */
nitobi.ui.Element.prototype.subscribeDeclarationEvents = function()
{
	for (var name in this.eventMap)
	{
		var ev = this.getAttribute("on" + name);
		if (ev != null && ev != "")
		{
			this.eventMap[name].subscribe(ev,this,name);
		}
	}
}

/**
 * Returns the HTML node associated with this element. If name is specified,
 * the HTML node searched for is assumed to be a sub-element of this object's node.
 * @example
 * var datepicker = nitobi.getComponent("myDatePicker");
 * var buttonElement = datepicker.getHtmlNode("button");
 * buttonElement.style.width = "300px";
 * @param {String} [name] The name of the sub element.
 * @type HTMLElement
 */
nitobi.ui.Element.prototype.getHtmlNode = function(name)
{
	var id = this.getId();
	id = (name != null ? id + "." + name : id); 
	var node = nitobi.ui.Element.htmlNodeCache[name];
	if (node==null)
	{
		node = $ntb(id);
		nitobi.ui.Element.htmlNodeCache[id] = node;		
	}
	return node;
};

/**
 * @private
 */
nitobi.ui.Element.prototype.flushHtmlNodeCache = function()
{
	nitobi.ui.Element.htmlNodeCache = {};
}

/**
 * Hide the component using the given effect. <code>effectClass</code> is the class of effect to 
 * use - <code>hide()</code> will instantiate a new effect object of this class.
 * @param {Class} [effectClass] The class of effect to use (if any) to hide the element
 * @param {Function} [callback] A function to evaluate after the element is shown
 * @param {Object} [params] The parameters to use with the hide effect.
 */
nitobi.ui.Element.prototype.hide = function(effectClass, callback, params)
{
	this.setVisible(false, effectClass, callback, params);
};

/**
 * Show the component using the given effect.  <code>effectClass</code> is the class of effect to 
 * use - <code>show()</code> will instantiate a new effect object of this class. 
 * @param {Class} [effectClass] The class of effect to use (if any) to show the element.
 * @param {Function} [callback] A function to evaluate after the element is shown.
 * @param {Object} params The parameters to use with the show effect.
 */
nitobi.ui.Element.prototype.show = function(effectClass, callback, params)
{
	this.setVisible(true, effectClass, callback, params);
};

/**
 * Returns <code>true</code> if the component has not been hidden. This value does not take into 
 * account the visibility of any parent objects.
 * @type Boolean
 */
nitobi.ui.Element.prototype.isVisible = function()
{
	var node = this.getHtmlNode();
	return node && !nitobi.html.Css.hasClass(node, NTB_CSS_HIDE);
};
/**
 * Show or hide the component using the given effect.  <code>effectClass</code> is the class 
 * of effect to use - <code>setVisible()</code> will instantiate a new effect object of this class. 
 * @param {Boolean} visible if <code>true</code>, show the component, otherwise hide
 * @param {Class} [effectClass] The class of effect to use (if any) to show the element
 * @param {Function} [callback] A function to evaluate after the element is shown
 * @param {Object} [params] The parameters to use with the effect.
 */
nitobi.ui.Element.prototype.setVisible = function(visible, effectClass, callback, params)
{

	var element = this.getHtmlNode();
	if (element && this.isVisible() != visible && this.onBeforeSetVisible.notify({source: this, event: this.onBeforeSetVisible, args: arguments}) !== false)
	{
		if (this.effect)
		{
			this.effect.end();
		}
		if (visible)
		{
			if (effectClass)
			{
				var effect = new effectClass(element, params);
				effect.callback = nitobi.lang.close(this, this.handleSetVisible, [callback]);
				this.effect = effect;
				effect.onFinish.subscribeOnce(nitobi.lang.close(this, function(){this.effect = null}));
				effect.start();
			}
			else
			{
				nitobi.html.Css.removeClass(element, NTB_CSS_HIDE);
				this.handleSetVisible(callback);
			}
		}
		else
		{
			if (effectClass)
			{
				var effect = new effectClass(element, params);
				effect.callback = nitobi.lang.close(this, this.handleSetVisible, [callback]);
				this.effect = effect;
				effect.onFinish.subscribeOnce(nitobi.lang.close(this, function(){this.effect = null}));
				effect.start();
			}
			else
			{
				nitobi.html.Css.addClass(this.getHtmlNode(), NTB_CSS_HIDE);
				this.handleSetVisible(callback);
			}
		}
	}
};

/**
 * @ignore
 */
nitobi.ui.Element.prototype.handleSetVisible = function(callback)
{
	if (callback) callback();
	this.onSetVisible.notify(new nitobi.ui.ElementEventArgs(this, this.onSetVisible));
};

/**
 * Enable or disable the component.
 * @param {Boolean} enabled
 */
nitobi.ui.Element.prototype.setEnabled = function(enabled)
{
	this.enabled = enabled;
};

/**
 * Check if the component is enabled.
 * @type Boolean
 */
nitobi.ui.Element.prototype.isEnabled = function()
{
	return this.enabled;
};

/**
 * Render the element.  Without arguments this will render the component in place of the in-page
 * XML declaration.
 * @param {HTMLElement} container a container whose inner HTML will be replaced 
 * by the rendered component (Optional)
 * @param {XMLDocument} state an XML document representing the state of the component (Optional)
 */
nitobi.ui.Element.prototype.render = function(container, state)
{
	this.flushHtmlNodeCache();
	state = state || this.getState();
	container = $ntb(container) || this.getContainer();
	
	if (container == null)
	{
		var container = document.createElement("span");
		document.body.appendChild(container);
		this.setContainer(container);
	}
	this.htmlNode = this.renderer.renderIn(container,state)[0];
	this.htmlNode.jsObject = this;
};

/**
 * Returns the HTML element into which the component is rendered.
 * @type HTMLElement
 */
nitobi.ui.Element.prototype.getContainer = function()
{
	return this.container;
};

/**
 * The container in which the element will be rendered.
 * @param {String|HTMLElement} container The id of the container or the container itself.
 */
nitobi.ui.Element.prototype.setContainer = function(container)
{
	this.container = $ntb(container);
};

/**
 * @private
 */
nitobi.ui.Element.prototype.getState = function()
{	
	return this.getXmlNode();
};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * @constructor
 * @class General arguments class that is passed to JavaScript event handlers.
 * @extends nitobi.base.EventArgs
 * @param {Object} source The object that fired the event.
 * @param {nitobi.base.Event} event The event that is being fired.
 * @param {String} targetId The id of the event target.
 */
nitobi.ui.ElementEventArgs = function(source, event, targetId)
{
	nitobi.ui.ElementEventArgs.baseConstructor.apply(this,arguments);
	
	/**
	 * The id of the event target.
	 * @type String
	 */
	this.targetId = targetId || null;
}

nitobi.lang.extend(nitobi.ui.ElementEventArgs,nitobi.base.EventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');

/**
 * @constructor
 * @class Used to supply arguments when custom event processing is required in element.
 * @extends nitobi.ui.ElementEventArgs
 * @param {Object} source The object that fired the event.
 * @param {nitobi.base.Event} event The event that is being fired.
 * @param {String} targetId The id of the event target.
 * @param {HTMLEvent} htmlEvent
 */
nitobi.ui.EventNotificationEventArgs = function(source, event, targetId, htmlEvent)
{
	nitobi.ui.EventNotificationEventArgs.baseConstructor.apply(this,arguments);
	
	/**
	 * The browser-native event object.
	 * @type HTMLEvent
	 */
	this.htmlEvent = htmlEvent|| null;
}

nitobi.lang.extend(nitobi.ui.EventNotificationEventArgs,nitobi.ui.ElementEventArgs);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.ui');
/**
 * Creates a Container.
 * @class A UI container.  A container will typically hold items of type {@link nitobi.ui.Element}.  This is useful for building
 * custom components that are collections of items.  For example, the Nitobi Fisheye component extends this class to manage
 * its menu items.
 * @constructor
 * @param {XmlNode/String} [id] If you want to create a container and deserialize it from the node. Can also be a string for the id.
 * @extends nitobi.ui.Element
 * @implements nitobi.collections.IList
 */
nitobi.ui.Container = function(id)
{
	nitobi.ui.Container.baseConstructor.call(this,id);
	nitobi.collections.IList.call(this);
};

nitobi.lang.extend(nitobi.ui.Container, nitobi.ui.Element);
nitobi.lang.implement(nitobi.ui.Container,nitobi.collections.IList);

nitobi.base.Registry.getInstance().register(
		new nitobi.base.Profile("nitobi.ui.Container",null,false,"ntb:container")
);
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs("nitobi.ui");

/**
 * @ignore
 */
NTB_CSS_SMALL = 'ntb-effects-small';
/**
 * @ignore
 */
NTB_CSS_HIDE = 'nitobi-hide';

if (false)
{
	/**
	 * @class
	 * @constructor
	 */
	nitobi.ui.Effects = function(){};
}

/**
 * @ignore
 */
nitobi.ui.Effects = {};


nitobi.ui.Effects.setVisible = function(element, visible, effectFamily, callback, context)
{
	callback = (context ? nitobi.lang.close(context,callback) : callback) || nitobi.lang.noop;
	element = $ntb(element);
	if (typeof effectFamily == 'string')
		effectFamily = nitobi.effects.families[effectFamily];
	if (!effectFamily)
		effectFamily = nitobi.effects.families['none'];
	if (visible)
		var effectClass = effectFamily.show;
	else
		var effectClass = effectFamily.hide;
	if (effectClass)
	{
		var effect = new effectClass(element);
		effect.callback = callback;
		effect.start();
	}
	else
	{
		if (visible)
			nitobi.html.Css.removeClass(element,NTB_CSS_HIDE);
		else
			nitobi.html.Css.addClass(element,NTB_CSS_HIDE);
		callback();		
	}
};

/**
 * Shrinks the given HTML DOM element to the size specified by 
 * <CODE>options</CODE> in <CODE>duration</CODE> milliseconds.
 * @param {Object} options The dimensions after shrinking <CODE>{width: <int> x, height: <int> y}</CODE>.
 * @param {Element} domElement The unique ID of this Pane.
 * @param {int} duration How long the effect will take.
 * @param {function} callback A function to call after shrink completes
 * @ignore
 */
nitobi.ui.Effects.shrink = function(options, domElement, duration, callback)
{
	var rect = nitobi.html.getClientRects(domElement)[0];

	options.deltaHeight_Doctype = 0 - parseInt("0"+nitobi.html.getStyle(domElement, "border-top-width")) - parseInt("0"+nitobi.html.getStyle(domElement, "border-bottom-width")) - 
									parseInt("0"+nitobi.html.getStyle(domElement, "padding-top")) - parseInt("0"+nitobi.html.getStyle(domElement, "padding-bottom")); 
	options.deltaWidth_Doctype = 0 - parseInt("0"+nitobi.html.getStyle(domElement, "border-left-width")) - parseInt("0"+nitobi.html.getStyle(domElement, "border-right-width")) - 
									parseInt("0"+nitobi.html.getStyle(domElement, "padding-left")) - parseInt("0"+nitobi.html.getStyle(domElement, "padding-right"));
	
	options.oldHeight = Math.abs(rect.top - rect.bottom) + options.deltaHeight_Doctype;
	options.oldWidth = Math.abs(rect.right - rect.left) + options.deltaWidth_Doctype;
	
	
//	options.oldHeight = nitobi.html.getStyle(domElement, "height");
//	options.oldHeight = nitobi.html.getStyle(domElement, "width");
	
	if (!(typeof(options.width) == "undefined"))
	{
		options.deltaWidth = Math.floor(Math.ceil(options.width - options.oldWidth) / (duration / nitobi.ui.Effects.ANIMATION_INTERVAL));
	}
	else
	{
		options.width = options.oldWidth;
		options.deltaWidth = 0;
	}
	
	if (!(typeof(options.height) == "undefined"))
	{
		options.deltaHeight = Math.floor(Math.ceil(options.height - options.oldHeight) / (duration / nitobi.ui.Effects.ANIMATION_INTERVAL));
	}
	else
	{
		options.height = options.oldHeight;
		options.deltaHeight = 0;
	}
	
	//domElement.style.overflow = "hidden";
	nitobi.ui.Effects.resize(options, domElement, duration, callback)
};

/**
 * A helper function that resizes <CODE>domElement</CODE> over a given duration by deltas given by 
 * <CODE>options.deltaWidth</CODE> and <CODE>options.deltaHeight</CODE> every 
 * <CODE>nitobi.ui.Effects.ANIMATION_INTERVAL</CODE> milliseconds.  Once complete, the function reference 
 * <CODE>callback</CODE> is called. 
 * @param {Object} options
 * @param {Element} domElement
 * @param {int} duration
 * @param {Function} callback
 * @private
 */
nitobi.ui.Effects.resize = function(options, domElement, duration, callback)
{
	var rect = nitobi.html.getClientRects(domElement)[0];

	var currentHeight = Math.abs(rect.top - rect.bottom);

//	var currentHeight = nitobi.html.getStyle(domElement, "height");
	
	var newHeight = Math.max(currentHeight + options.deltaHeight + options.deltaHeight_Doctype, 0);
	if (Math.abs(currentHeight - options.height) < Math.abs(options.deltaHeight))
	{
		newHeight = options.height;
		options.deltaHeight = 0;
	}

// 	var currentWidth = nitobi.html.getStyle(domElement, "width");
	var currentWidth = Math.abs(rect.right - rect.left);
	
	var newWidth = Math.max(currentWidth + options.deltaWidth + options.deltaWidth_Doctype, 0);
	newWidth = (newWidth >= 0) ? newWidth : 0;
	if (Math.abs(currentWidth - options.width) < Math.abs(options.deltaWidth))
	{
		newWidth = options.width;
		options.deltaWidth = 0;
	}

	duration -= nitobi.ui.Effects.ANIMATION_INTERVAL;
	if (duration > 0)
	{
		window.setTimeout(nitobi.lang.closeLater(this, nitobi.ui.Effects.resize, [options, domElement, duration, callback]), nitobi.ui.Effects.ANIMATION_INTERVAL);
	}

	var resizeFunc = function () {
		domElement.height = newHeight + "px";
		domElement.style.height = newHeight + "px";

		domElement.width = newWidth + "px"; 
		domElement.style.width = newWidth + "px"; 
			
		if (duration <= 0)
		{
			if (callback)
			{
				window.setTimeout(callback,0);
			}
		}
	}

	nitobi.ui.Effects.executeNextPulse.push(resizeFunc);

};

/**
 * A stack of function references that will be called every animation pulse.
 * @private
 */
nitobi.ui.Effects.executeNextPulse = new Array();

/**
 * Executes every function reference in {@link nitobi.ui.Effects#executeNextPulse} and clears its contents.
 */
nitobi.ui.Effects.pulse = function()
{
	var p;
	while (p = nitobi.ui.Effects.executeNextPulse.pop())
	{
		p.call()
	}
}

/**
 * The number of milliseconds between executions of {@link nitobi.ui.Effects#pulse}.
 * @private
 * @final
 */
nitobi.ui.Effects.PULSE_INTERVAL = 20;

/**
 * The number of milliseconds between calculating new animation frames.
 * @private
 * @final
 */
nitobi.ui.Effects.ANIMATION_INTERVAL = 40;

window.setInterval(nitobi.ui.Effects.pulse, nitobi.ui.Effects.PULSE_INTERVAL);window.setTimeout(nitobi.ui.Effects.pulse, nitobi.ui.Effects.PULSE_INTERVAL);

/**
 * @private
 */
nitobi.ui.Effects.fadeIntervalId = {};
/**
 * @private
 */
nitobi.ui.Effects.fadeIntervalTime = 10;

/**
 * @private
 */
nitobi.ui.Effects.cube = function(number)
{
	return number * number * number;
}

/**
 * @private
 */
nitobi.ui.Effects.cubeRoot = function(number)
{
	var T=0;
	var N = parseFloat (number);
	if (N < 0) {N=-N; T=1;};
	var M = Math.sqrt (N);
	var ctr = 1
	while (ctr < 101) {
	var M = M*N;
	var M = Math.sqrt (Math.sqrt(M));
	ctr++;
	}
	return M;
}

/**
 * @private
 */
nitobi.ui.Effects.linear = function(number)
{
	return number;
}

/**
 * @private
 */
nitobi.ui.Effects.fade = function(element,target,time,endFunc, stepFunc)
{
	stepFunc = stepFunc || nitobi.ui.Effects.linear;
	var endTime = (new Date()).getTime() + time;
	var id = nitobi.component.getUniqueId();
	var startTime = (new Date()).getTime()
	var el = element;
	if (element.length)
	{
		el = element[0]
	}
	var current = nitobi.html.Css.getOpacity(el);
	var direction = (target - current < 0 ? -1 : 0);
	nitobi.ui.Effects.fadeIntervalId[id] = window.setInterval(function(){nitobi.ui.Effects.stepFade(element,target,startTime, endTime,id,endFunc, stepFunc, direction)},nitobi.ui.Effects.fadeIntervalTime);
}

/**
 * @private
 */
nitobi.ui.Effects.stepFade = function(element,target,startTime,endTime,id, endFunc, stepFunc, direction)
{
	var ct = (new Date()).getTime();
	var range = endTime - startTime;
	var nct = ((ct - startTime)/(endTime - startTime));
	
	if (nct <= 0 || nct >= 1)
	{
		nitobi.html.Css.setOpacities(element, target);
		window.clearInterval(nitobi.ui.Effects.fadeIntervalId[id]);
		endFunc();
		return;
	}
	else
	{
		nct = Math.abs(nct + direction);
	}
	var no = stepFunc(nct);
	nitobi.html.Css.setOpacities(element, no * 100);
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
// For x-component stuff
nitobi.lang.defineNs("nitobi.component");

if (false)
{
	/**
	 * @namespace The namespace for component helper functions.
	 * @constructor
	 */
	nitobi.component = function(){};
}

/**
 * Loads and renders a component from a declaration. It returns the javascript object.
 * @param {HTMLElement/String} el Either the id of the declaration or the HTMLElement itself.
 * @type Object
 */
nitobi.loadComponent = function(el)
{
	var id = el;
	el = $ntb(el);
	if (el == null)
	{
		nitobi.lang.throwError("nitobi.loadComponent could not load the component because it could not be found on the page. The component may not have a declaration, node, or it may have a duplicated id. Id: " + id);
	}
	if (el.jsObject != null) {
		return el.jsObject;
	}
	var component;
	var tagName = nitobi.html.getTagName(el);
	
	// If the component is grid or combo then use their special init procedures.
	if (tagName == "ntb:grid") 
	{
		component = nitobi.initGrid(el.id);
	} 
	else if (tagName === "ntb:combo")
	{
		component = nitobi.initCombo(el.id);
	}
	else if (tagName == "ntb:treegrid")
	{
		component = nitobi.initTreeGrid(el.id);
	}
	else 
	{
		// The component is a new-style component that doesn't require any special init process.
		if (el.jsObject == null)
		{
			component = nitobi.base.Factory.getInstance().createByTag(tagName,el.id,nitobi.component.renderComponent);
			if (component.render && !component.onLoadCallback)
			{
				component.render();
			}
		}
		else
		{
			component=el.jsObject;	
		}
	}			
	return component;
}

/**
 * @private
 */
nitobi.component.renderComponent = function(eventArgs)
{
	eventArgs.source.render();
}

/**
 * Returns the javascript object for a component with a particular id. The 
 * component must have been already rendered.
 * @param {String} id The id of the component.
 * @type Object
 */
nitobi.getComponent = function(id)
{
	var el = $ntb(id);
	if (el == null) return null;
	return el.jsObject;
}

/**
 * @private
 */
nitobi.component.uniqueId = 0;

/**
 * Returns an id that is unique to other Nitobi components on the page.
 * @type String
 */
nitobi.component.getUniqueId = function()
{
	return "ntbcmp_" + (nitobi.component.uniqueId++);
}

/**
 * Finds all the child nodes of the supplied node that are Nitobi components
 * @param {HTMLNode} rootNode The node to start the search on
 * @param {Array} foundNodes An array to store the nodes
 * @private
 */
nitobi.getComponents = function(rootNode, foundNodes)
{
	if (foundNodes == null)
		foundNodes = [];

	if (nitobi.component.isNitobiElement(rootNode)) {
		foundNodes.push(rootNode);
		return;
	}
	
	var nodes = rootNode.childNodes;
	for (var i = 0; i < nodes.length; i++) {
		nitobi.getComponents(nodes[i], foundNodes);
	}
	
	return foundNodes;
}

/**
 * @private
 */
nitobi.component.isNitobiElement = function(rootNode)
{
	var rootNodeName = nitobi.html.getTagName(rootNode);
	if (rootNodeName.substr(0, 3) == "ntb") {
		return true;
	} else {
		return false;
	}
}

/**
 * @private
 */
nitobi.component.loadComponentsFromNode = function(rootNode)
{
	var ntbElements = new Array();
	nitobi.getComponents(rootNode, ntbElements);
	for (var i = 0; i < ntbElements.length; i++) {
		nitobi.loadComponent(ntbElements[i].getAttribute('id'));
	}
}
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

if (false)
{
	/**
	 * @namespace The <code>nitobi.effects</code> namespace hosts classes that can be used for animated
	 * manipulation of HTML elements.  {@link nitobi.effects.Effect} is an abstract class that is 
	 * at the root of the Nitobi effects system, all effects extend this class.
	 * @constructor
	 */
	nitobi.effects = function(){}; 
}

/**
 * Creates a new effect that will act on <code>element</code> with the given parameters.  
 * @class An abstract class that needs to be extended by subclasses that will provide functionality
 * that actually modifies the appearance of an HTML element.
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @constructor 
 */
nitobi.effects.Effect = function( element, params )
{
	/**
	 * The HTML element this effect will act on.
	 * @type HTMLElement
	 */
	this.element = $ntb(element);
	/**
	 * The transition (any function that takes any value between 0.0 and 1.0 and returns a value
	 * between 0.0 and 1.0) for this effect. Default: {@link nitobi.effects.Transition#sinoidal}
	 * @type Function
	 */
	this.transition = params.transition || nitobi.effects.Transition.sinoidal;
	/**
	 * The duration (in seconds) of the effect. Default: <code>1.0</code>
	 * @type Number
	 */
	this.duration = params.duration || 1.0;
	/**
	 * The frame rate (number of frames per second) for this effect.
	 * @type Number
	 */
	this.fps = params.fps || 50;
	/**
	 * The starting point for the transition. One might want to start a sin wave at 0.5. 
	 * Default: <code>0.0</code>
	 * @type Number 
	 */
	this.from = typeof(params.from) === 'number' ? params.from : 0.0;
	/**
	 * The ending point for the transition. 
	 * Default: <code>1.0</code>
	 * @type Number 
	 */
	this.to = typeof(params.from) === 'number' ? params.to : 1.0;
	/**
	 * A delay (in seconds) from when <code>start()</code> is called to when the effect actually begins.
	 * Default: <code>0.0</code>
	 * @type Number
	 */
	this.delay = params.delay || 0.0;
	/**
	 * A function to call when the effect finishes.
	 * @type Function
	 */
	this.callback = typeof(params.callback) === 'function' ? params.callback : nitobi.lang.noop;
	/**
	 * @private
	 */
	this.queue = params.queue || nitobi.effects.EffectQueue.globalQueue;
	/**
	 * The event that fires just before the last render call and removal of the effect from the 
	 * global effect queue. {@link nitobi.base.EventArgs} are passed to any subscribed handlers.
	 * @type nitobi.base.Event
	 */
	this.onBeforeFinish = new nitobi.base.Event();
	/**
	 * The event that fires after the last render call and removal of the effect from the 
	 * global effect queue. {@link nitobi.base.EventArgs} are passed to any subscribed handlers.
	 * @type nitobi.base.Event
	 */
	this.onFinish = new nitobi.base.Event();
	/**
	 * The event that fires just before the first render call {@link nitobi.base.EventArgs} 
	 * are passed to any subscribed handlers.
	 * @type nitobi.base.Event
	 */
	this.onBeforeStart = new nitobi.base.Event();
};

/**
 * Start the effect.  Call <code>start()</code> when the effect's parameters have been set 
 * as you desire.  
 */
nitobi.effects.Effect.prototype.start = function ()
{
	var now = new Date().getTime();
	/**
	 * @ignore
	 */
	this.startOn = now + this.delay*1000;
	/**
	 * @ignore
	 */
	this.finishOn = this.startOn + this.duration*1000;
	/**
	 * @ignore
	 */
	this.deltaTime = this.duration*1000;
	/**
	 * @ignore
	 */
	this.totalFrames = this.duration * this.fps;
	/**
	 * @ignore
	 */
	this.frame = 0;
	/**
	 * @ignore
	 */
	this.delta = this.from-this.to;
	this.queue.add(this);
};

/**
 * @private
 */
nitobi.effects.Effect.prototype.render = function( pos )
{
	if (!this.running)
	{
		this.onBeforeStart.notify(new nitobi.base.EventArgs(this, this.onBeforeStart));
		this.setup();
		/**
		 * @ignore
		 */
		this.running = true;
	}
	this.update(this.transition(pos*this.delta+this.from));	
};

/**
 * @private
 */
nitobi.effects.Effect.prototype.step = function( now )
{
	if (this.startOn <= now)
	{
		if (now >= this.finishOn)
		{
			this.end()
			return;
		}
		var pos = (now - this.startOn) / (this.deltaTime);
		var frame = Math.floor(pos*this.totalFrames);
		if (this.frame < frame)
		{
			this.render(pos);
			this.frame = frame
		}
	}
};

/**
 * This method is executed directly before the first update is made to the element.  Extending 
 * classes use this method as an initialization step.
 */
nitobi.effects.Effect.prototype.setup = function(){};

/**
 * This method is executed on every frame with the position (adjusted by the <code>transition</code>)
 * used as input.  Extending classes use this method to update the element's style.
 * @param {Number} pos the position (between 0.0 and 1.0) of the animation
 */
nitobi.effects.Effect.prototype.update = function(pos){};

/**
 * This method is executed directly after the last update has been made to the element.  Extending
 * classes use this method to clean up settings on the elment that are no longer needed.
 */
nitobi.effects.Effect.prototype.finish = function(){};

/**
 * Ends the effect.  This method can be called at any point and will update the element to
 * how it should look at the end of the effect.  It also cancels the effect by calling 
 * {@link nitobi.effects.Effect#cancel}.
 */
nitobi.effects.Effect.prototype.end = function()
{
	this.onBeforeFinish.notify(new nitobi.base.EventArgs(this, this.onBeforeFinish));
	this.cancel();
	this.render(1.0);
	this.running = false;	
	this.finish();
	this.callback();
	this.onFinish.notify(new nitobi.base.EventArgs(this, this.onAfterFinish));	
};

/**
 * Cancels the effect, preventing further updates to the element.  This does not return the element
 * to its original state, it simply prevents further modification.
 */
nitobi.effects.Effect.prototype.cancel = function()
{
	this.queue.remove(this);
};

/**
 * Creates a constructor for the given effect class that will take only the HTML element as
 * an argument.  For the given effect class,  we will return a constructor that takes 
 * only an element argument.  It will use this element with the <code>params</code> and any further
 * arguments to this method as inputs to the constructor for <code>effectClass</code>.
 * <BR>For example:
 * @example
 *  var effect = nitobi.effects.factory(nitobi.effects.Effect.Scale, 
 *                                      {fps:25,scaleFrom:50.0},
 *                                      75.0);
 *  var e1 = new effect($ntb('myDiv'));
 *  var e2 = new effect($ntb('anotherDiv'));
 *  myEffects.FiftyToSeventyFiveWithFps25 = effect;  
 * @param {Function} effectClass the class to use as the basis for the returned effect
 * @param {Map} params the params Map to use in the <code>effectClass</code> constructor
 * @param {Object} etc the first of as many other arguments as the constructor for 
 * <code>effectClass</code> takes. 
 * @type Function
 */
nitobi.effects.factory = function(effectClass, params, etc)
{
	var args = nitobi.lang.toArray(arguments, 2);
	return function(element)
	{
		var f = function () {effectClass.apply(this,[element,params].concat(args))};
		nitobi.lang.extend(f,effectClass); 
		return new f();
	}
};

/**
 * A Map of of effect family names to their respective <code>show</code> and <code>hide</code> effects.  ie: 
 * @example
 * nitobi.effects.families.blind == {show: nitobi.effects.BlindDown, hide: nitobi.effects.BlindUp}
 * nitobi.effects.families.shade == {show: nitobi.effects.ShadeDown, hide: nitobi.effects.ShadeUp}
 * nitobi.effects.families.none == {show: null, hide: null}
 * @type Map
 */
nitobi.effects.families = {
	none: {show: null, hide: null}
};
	
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

if (false)
{
	/**
	 * <I>This class has no constructor.</I>
	 * @class This class hosts static functions that take values between zero and one and return
	 * values between zero and one.  They can be used as the transition property in subclasses of 
	 * {@link nitobi.effects.Effect} to make animation look smoother.
	 * @constructor
	 */
	nitobi.effects.Transition = function(){}; 
}
nitobi.effects.Transition = {};

/**
 * A sinoidal curve with its valley at 0.0 and peak at 1.0.
 * @param {Number} x a number between 0.0 and 1.0
 */
nitobi.effects.Transition.sinoidal = function(x)
{
	return (-Math.cos(x*Math.PI)/2)+0.5;
};

/**
 * This function just returns <code>x</code>.
 * @param {Number} x a number between 0.0 and 1.0
 */
nitobi.effects.Transition.linear = function(x)
{
	return x;
};

/**
 * Returns <code>1-x</code>.
 * @param {Number} x a number between 0.0 and 1.0
 */
nitobi.effects.Transition.reverse = function(x)
{
	return 1-x;
};


/*
 	  pulse: function(x, pulses) {
 	    pulses = pulses || 5;
 	    return (
 	      Math.round((x % (1/pulses)) * pulses) == 0 ?
 	            ((x * pulses * 2) - Math.floor(x * pulses * 2)) :
 	        1 - ((x * pulses * 2) - Math.floor(x * pulses * 2))
 	      );
 	  },
*/
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

/**
 * Creates a scaling effect.  After the effect is created it can be started by calling 
 * <code>start()</code>.
 * @class A class that facilitates animated scaling.  Each instance is a different 
 * scaling effect on a different element with its own set of parameters.
 * @constructor
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @param {Number} percent the percentage (0-100) of size to which the effect should scale <code>element</code>
 * @extends nitobi.effects.Effect
 */
nitobi.effects.Scale = function(element, params, percent)
{
	nitobi.effects.Scale.baseConstructor.call(this,element,params);
	/**
	 * Whether or not to scale the width of the element. Default: <code>true</code>
	 * @type Boolean
	 */
	this.scaleX = typeof(params.scaleX) == 'boolean' ? params.scaleX : true;
	/**
	 * Whether or not to scale the height of the element. Default: <code>true</code>
	 * @type Boolean
	 */
	this.scaleY = typeof(params.scaleY) == 'boolean' ? params.scaleY : true;
	/**
	 * The percentage (0-100) size to start the animation at. Default: <code>100.0</code>
	 * @type Number
	 */
	this.scaleFrom = typeof(params.scaleFrom) == 'number' ? params.scaleFrom : 100.0;
	/**
	 * @ignore
	 */
	this.scaleTo = percent;
};

nitobi.lang.extend(nitobi.effects.Scale, nitobi.effects.Effect);

/**
 * @private
 */
nitobi.effects.Scale.prototype.setup = function()
{
	var style = this.element.style;
	var Css = nitobi.html.Css;
	this.originalStyle = {
		'top': style.top,
		'left': style.left,
		'width': style.width,
		'height': style.height,
		'overflow': Css.getStyle(this.element, "overflow")
	};
	this.factor = (this.scaleTo - this.scaleFrom) / 100.0;
	this.dims = [this.element.scrollWidth, this.element.scrollHeight];
	style.width = this.dims[0]+"px";
	style.height = this.dims[1]+"px";
	Css.setStyle(this.element, "overflow", "hidden");
};

/**
 * @private
 */
nitobi.effects.Scale.prototype.finish = function()
{
	for (var s in this.originalStyle)
		this.element.style[s] = this.originalStyle[s]; 
};

/**
 * @private
 */
nitobi.effects.Scale.prototype.update = function( pos )
{
	var currentScale = (this.scaleFrom / 100.0) + (this.factor * pos);
	this.setDimensions(Math.floor(currentScale * this.dims[0]) || 1, Math.floor(currentScale * this.dims[1]) || 1);
};	

/**
 * @private
 */
nitobi.effects.Scale.prototype.setDimensions = function( x, y )
{
	if (this.scaleX) this.element.style.width = x + 'px';
	if (this.scaleY) this.element.style.height = y + 'px';
};
	
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

/**
 * @private
 * @ignore
 */
nitobi.effects.EffectQueue = function() 
{
	nitobi.effects.EffectQueue.baseConstructor.call(this);
	nitobi.collections.IEnumerable.call(this);
	this.intervalId = 0;
}

nitobi.lang.extend(nitobi.effects.EffectQueue,nitobi.Object);
nitobi.lang.implement(nitobi.effects.EffectQueue,nitobi.collections.IEnumerable);
/**
 * @private
 * @ignore
 */
nitobi.effects.EffectQueue.prototype.add = function(effect)
{
	nitobi.collections.IEnumerable.prototype.add.call(this,effect);
	if (!this.intervalId)
	{
		this.intervalId = window.setInterval(nitobi.lang.close(this,this.step),15);
	}
};
/**
 * @private
 * @ignore
 */
nitobi.effects.EffectQueue.prototype.step = function()
{
	var now = new Date().getTime();
	this.each(function(e) { e.step(now) });
};
/**
 * @private
 * @ignore
 */
nitobi.effects.EffectQueue.globalQueue = new nitobi.effects.EffectQueue();
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

/**
 * Creates a blind effect.  After the effect is created it can be started by calling 
 * <code>start()</code>.
 * @class This effect shrinks an HTML Element in the Y-direction, preserving the width of the element.  After
 * After shrinking, the element is hidden.
 * @constructor
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @extends nitobi.effects.Scale
 */
nitobi.effects.BlindUp = function( element, params )
{
	params = nitobi.lang.merge(
		{
			scaleX:false,
			duration:Math.min(0.2 * (element.scrollHeight / 100) , 0.50)
		}, 
		params || {}
	);
	nitobi.effects.BlindUp.baseConstructor.call(this,element,params,0.0);
};

nitobi.lang.extend(nitobi.effects.BlindUp, nitobi.effects.Scale );

/**
 * @private
 */
nitobi.effects.BlindUp.prototype.setup = function()
{
	nitobi.effects.BlindUp.base.setup.call(this);
};
/**
 * @private
 */
nitobi.effects.BlindUp.prototype.finish = function()
{
	nitobi.html.Css.addClass(this.element, NTB_CSS_HIDE);
	nitobi.effects.BlindUp.base.finish.call(this);
	this.element.style.height = '';
};

/*************************************************************/

/**
 * Creates a blind effect.  After the effect is created it can be started by calling 
 * <code>start()</code>.
 * @class This effect grows an HTML Element to 100% of its size in the Y-direction, preserving the width 
 * of the element. The element should start off hidden.
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @constructor
 * @extends nitobi.effects.Scale
 */
nitobi.effects.BlindDown = function( element, params )
{
	nitobi.html.Css.swapClass(element, NTB_CSS_HIDE, NTB_CSS_SMALL);
	params = nitobi.lang.merge(
		{
			scaleX:false,
			scaleFrom:0.0,
			duration:Math.min(0.2 * (element.scrollHeight / 100) , 0.50) 
		}, 
		params || {}
	);
	nitobi.effects.BlindDown.baseConstructor.call(this,element,params,100.0);
};

nitobi.lang.extend(nitobi.effects.BlindDown, nitobi.effects.Scale );

/**
 * @private
 */
nitobi.effects.BlindDown.prototype.setup = function()
{
//	this.element.style.height = '1px';
//	nitobi.html.Css.removeClass(this.element,NTB_CSS_HIDE);
	nitobi.effects.BlindDown.base.setup.call(this);
	this.element.style.height = '1px';
	nitobi.html.Css.removeClass(this.element,NTB_CSS_SMALL);
};
/**
 * @private
 */
nitobi.effects.BlindDown.prototype.finish = function()
{
	nitobi.effects.BlindDown.base.finish.call(this);
	this.element.style.height = '';
};

nitobi.effects.families.blind = {show: nitobi.effects.BlindDown, hide: nitobi.effects.BlindUp};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.effects');

/**
 * Creates a shade effect.  After the effect is created it can be started by calling 
 * <code>start()</code>.
 * @class This effect shrinks an HTML Element in the Y-direction, preserving the width of the element.
 * After shrinking, the element is hidden. The effect pins the first child node of the element to its 
 * bottom.  Visually, the element will appear as if it is sliding up, like a window shade.
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @constructor
 * @extends nitobi.effects.Scale
 */
nitobi.effects.ShadeUp = function( element, params )
{
	params = nitobi.lang.merge(
		{
			scaleX: false,
			duration: Math.min(0.2 * (element.scrollHeight / 100) , 0.30) 
		}, 
		params || {}
	);
	nitobi.effects.ShadeUp.baseConstructor.call(this,element,params,0.0);
};

nitobi.lang.extend(nitobi.effects.ShadeUp, nitobi.effects.Scale );

/**
 * @private
 */
nitobi.effects.ShadeUp.prototype.setup = function()
{
	nitobi.effects.ShadeUp.base.setup.call(this);
	var fnode = nitobi.html.getFirstChild(this.element);
	this.originalStyle.position = this.element.style.position;
	nitobi.html.position(this.element);
	
	if (fnode)
	{
		var style = fnode.style;
		this.fnodeStyle = {
			position: style.position,
			bottom: style.bottom,
			left: style.left
		}
		this.fnode = fnode;
		style.position = 'absolute';
		style.bottom = '0px';
		style.left = '0px';
		style.top = '';
	}
};

/**
 * @private
 */
nitobi.effects.ShadeUp.prototype.finish = function()
{
	nitobi.effects.ShadeUp.base.finish.call(this);
	nitobi.html.Css.addClass(this.element,NTB_CSS_HIDE);
	this.element.style.height = '';
	this.element.style.position = this.originalStyle.position;
	this.element.style.overflow = this.originalStyle.overflow;
	for (var x in this.fnodeStyle)
	{
		this.fnode.style[x] = this.fnodeStyle[x];
	}
};

/*************************************************************/

/**
 * Creates a shade effect.  After the effect is created it can be started by calling 
 * <code>start()</code>.
 * @class This effect grows an HTML Element in the Y-direction, preserving the width of the element.
 * The effect pins the first child node of the element to its 
 * bottom.  Visually, the element will appear as if it is sliding down, like a window shade.
 * @param {HTMLElement} element the HTML element that will be affected by this effect
 * @param {Map} params initial values for the effect's fields - ie 
 * <code>{@link nitobi.effects.Effect#duration} = params.duration</code> 
 * @constructor
 * @extends nitobi.effects.Scale
 */
nitobi.effects.ShadeDown = function( element, params )
{
	nitobi.html.Css.swapClass(element, NTB_CSS_HIDE, NTB_CSS_SMALL);
	params = nitobi.lang.merge(
		{
			scaleX:false,
			scaleFrom:0.0,
			duration:Math.min(0.2 * (element.scrollHeight / 100) , 0.30)
		}, 
		params || {}
	);
	nitobi.effects.ShadeDown.baseConstructor.call(this,element,params,100.0);
};

nitobi.lang.extend(nitobi.effects.ShadeDown, nitobi.effects.Scale );

/**
 * @private
 */
nitobi.effects.ShadeDown.prototype.setup = function()
{
	nitobi.effects.ShadeDown.base.setup.call(this);
	this.element.style.height = '1px';
	nitobi.html.Css.removeClass(this.element,NTB_CSS_SMALL);
	
	var fnode = nitobi.html.getFirstChild(this.element);
	this.originalStyle.position = this.element.style.position;
	nitobi.html.position(this.element);
	
	if (fnode)
	{
		var style = fnode.style;
		this.fnodeStyle = {
			position: style.position,
			bottom: style.bottom,
			left: style.left,
			right: style.right,
			top: style.top
		}
		this.fnode = fnode;
		style.position = 'absolute';
		style.top = '';
		style.right = '';
		style.bottom = '0px';
		style.left = '0px';
	}
	
};

/**
 * @private
 */
nitobi.effects.ShadeDown.prototype.finish = function()
{
	nitobi.effects.ShadeDown.base.finish.call(this);
	this.element.style.height = '';
	this.element.style.position = this.originalStyle.position;
	this.element.style.overflow = this.originalStyle.overflow;
	for (var x in this.fnodeStyle)
	{
		this.fnode.style[x] = this.fnodeStyle[x];
	}

	this.fnode.style.top = '0px';
	this.fnode.style.left = '0px';
	this.fnode.style.bottom = '';
	this.fnode.style.right = '';
return

	this.fnode.style['position'] = ''; //this.fnodeStyle['position'];
//	this.fnode.style['top'] = this.fnodeStyle['top'];
//	this.fnode.style['right'] = this.fnodeStyle['right'];
//	this.fnode.style['bottom'] = this.fnodeStyle['bottom'];
//	this.fnode.style['left'] = this.fnodeStyle['left'];
//	//this.fnode.style['position'] = 'relative';
//	
//	this.element.style['top'] = this.originalStyle['top'];
//	this.element.style['left'] = this.originalStyle['left'];
//
//	
//	this.element.style['width'] = this.originalStyle['width'];
//	this.element.style['height'] = this.originalStyle['height'];
//	
//	this.element.style['overflow'] = this.originalStyle['overflow'];
	
//	this.element.style['position'] = this.originalStyle['position'];
	
//	for (var x in this.fnodeStyle)
//	{
//		console.log(this.fnode.style[x]+" inner ["+x+"]: "+this.fnodeStyle[x]); 
//		if (this.fnode.style[x] != this.fnodeStyle[x]) this.fnode.style[x] = this.fnodeStyle[x];
//		
//	}
//	nitobi.effects.ShadeDown.base.finish.call(this);
//	this.element.style.height = '';
//	this.element.style.position = this.originalStyle.position;
//	this.element.style.overflow = this.originalStyle.overflow;
};

nitobi.effects.families.shade = {show: nitobi.effects.ShadeDown, hide: nitobi.effects.ShadeUp};
/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
nitobi.lang.defineNs('nitobi.lang');
	
/**
 * Initializes a new instance of the StringBuilder class
 * @class An optimized string concatenation class.
 * @constructor
 * @param {String|Array} [value] an initial value, or set of inital values.
 */
nitobi.lang.StringBuilder = function (value)
{
	if (value)
	{
		if (typeof(value) === 'string')
		{
			this.strings = [value];
		}
		else
		{
			this.strings = value;
		}
	}
	else
	{
		this.strings = new Array();
	}
};

/**
 * Appends the given string to the end of the string buffer.  <code>append()</code>
 * returns the <code>StringBuilder</code> object so that chaining calls to append is possible.
 * @example
 * var helloWorld = new nitobi.lang.StringBuilder();
 * helloWorld.append('Hello').append(', ').append('World!');
 * alert(helloWorld); // Calls helloWorld.toString();
 * @param {String} value the string to append
 * @type nitobi.lang.StringBuilder
 */
nitobi.lang.StringBuilder.prototype.append = function (value)
{
	if (value)
	{
		this.strings.push(value);
	}
	return this;
};

/**
 * Clears the string buffer.
 */
nitobi.lang.StringBuilder.prototype.clear = function ()
{
	this.strings.length = 0;
};

/**
 * Returns the current state of the buffer as a single string.
 * @type String
 */
nitobi.lang.StringBuilder.prototype.toString = function ()
{
	return this.strings.join("");
};
