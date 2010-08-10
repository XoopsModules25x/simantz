<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:ntb="http://www.nitobi.com" xmlns:user="http://mycompany.com/mynamespace" xmlns:msxsl="urn:schemas-microsoft-com:xslt" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" omit-xml-declaration="yes"/>
<xsl:param name="IE" select="'false'"/>
<xsl:param name="useBorders" select="'false'"/>
<xsl:variable name="g" select="//ntb:treegrid"></xsl:variable>
<xsl:variable name="u" select="//state/@uniqueID"></xsl:variable>
<xsl:key name="style" match="//s" use="@k" />

<xsl:template match = "/">
	<xsl:variable name="t" select="$g/@Theme"></xsl:variable>
	<xsl:variable name="showvscroll"><xsl:choose><xsl:when test="($g/@VScrollbarEnabled='true' or $g/@VScrollbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>
	<xsl:variable name="showhscroll"><xsl:choose><xsl:when test="($g/@HScrollbarEnabled='true' or $g/@HScrollbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>
	<xsl:variable name="showtoolbar"><xsl:choose><xsl:when test="($g/@ToolbarEnabled='true' or $g/@ToolbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>		

	<xsl:variable name="scrollerHeight" select="number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)" />
	<xsl:variable name="scrollerWidth" select="number($g/@Width)-(number($g/@scrollbarWidth)*number($g/@VScrollbarEnabled))" />

	<xsl:variable name="midHeight" select="number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)-number($g/@top)"/>

	<xsl:variable name="rowHeight"><xsl:choose><xsl:when test="$useBorders='true'"><xsl:value-of select="number($g/@RowHeight) - number($g/@CellBorderY)"/></xsl:when><xsl:otherwise><xsl:value-of select="$g/@RowHeight"/></xsl:otherwise></xsl:choose></xsl:variable>
	#grid<xsl:value-of select="$u" />  {
		height:<xsl:value-of select="$g/@Height" />px;
		width:<xsl:value-of select="$g/@Width" />px;
		overflow:hidden;text-align:left;
	<xsl:if test="$IE='true'">
		position:relative;
	</xsl:if>
	}
	
	.vScrollbarRange<xsl:value-of select="$u" /> {}

	.ntb-grid-datablock, .ntb-grid-headerblock {
		table-layout:fixed;
	<xsl:if test="$IE='true'">
		width:0px;
	</xsl:if>
	}

	.<xsl:value-of select="$t"/> .ntb-cell {overflow:hidden;white-space:nowrap;}
	.<xsl:value-of select="$t"/> .ntb-cell, x:-moz-any-link, x:default {display: -moz-box;}
	.<xsl:value-of select="$t"/> .ntb-column-indicator, x:-moz-any-link, x:default {display: -moz-box;}
	.<xsl:value-of select="$t"/> .ntb-cell-border {overflow:hidden;white-space:nowrap;<xsl:if test="$IE='true'">height:auto;</xsl:if>}

	.ntb-grid-headershow<xsl:value-of select="$u" /> {padding:0px;<xsl:if test="not($g/@ColumnIndicatorsEnabled=1)">display:none;</xsl:if>}
	.ntb-grid-vscrollshow<xsl:value-of select="$u" /> {padding:0px;<xsl:if test="not($g/@VScrollbarEnabled=1)">display:none;</xsl:if>}
	#ntb-grid-hscrollshow<xsl:value-of select="$u" /> {padding:0px;<xsl:if test="not($g/@HScrollbarEnabled=1)">display:none;</xsl:if>}
	.ntb-grid-toolbarshow<xsl:value-of select="$u" /> {<xsl:if test="not($g/@ToolbarEnabled=1) and not($g/@ToolbarEnabled='true')">display:none;</xsl:if>}

	.ntb-grid-height<xsl:value-of select="$u" /> {height:<xsl:value-of select="$g/@Height" />px;overflow:hidden;}
	.ntb-grid-width<xsl:value-of select="$u" /> {width:<xsl:value-of select="$g/@Width" />px;overflow:hidden;}
	.ntb-grid-overlay<xsl:value-of select="$u" /> {position:relative;z-index:1000;top:0px;left:0px;}

	.ntb-grid-scroller<xsl:value-of select="$u" /> {
		overflow:hidden;
		text-align:left;
		-moz-user-select: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		user-select: none;
	}
	.ntb-grid-scrollerwidth<xsl:value-of select="$u" /> {width:<xsl:value-of select="$scrollerWidth"/>px;}
	.ntb-grid-topheight<xsl:value-of select="$u" /> {overflow:hidden;<xsl:if test="$g/@top=0">display:none;</xsl:if>}
	.ntb-grid-leftwidth<xsl:value-of select="$u" /> {width:<xsl:value-of select="$g/@left" />px;overflow:hidden;text-align:left;}
	.ntb-grid-centerwidth<xsl:value-of select="$u" />-0 {width:<xsl:value-of select="number($g/@Width)-number($g/@left)-(number($g/@scrollbarWidth)*$showvscroll)" />px;}
	.ntb-grid-scrollbarheight<xsl:value-of select="$u" /> {height:<xsl:value-of select="$g/@scrollbarHeight" />px;}
	.ntb-grid-scrollbarwidth<xsl:value-of select="$u" /> {width:<xsl:value-of select="$g/@scrollbarWidth" />px;}
	.ntb-grid-toolbarheight<xsl:value-of select="$u" /> {height:<xsl:value-of select="$g/@ToolbarHeight" />px;}
	
	.ntb-grid-surfaceheight<xsl:value-of select="$u" /> {height:100px;}

	.ntb-grid {padding:0px;margin:0px;border:1px solid #cccccc}
	.ntb-scroller {padding:0px;}
	.ntb-scrollcorner {padding:0px;}

	
	.ntb-input-border {
		table-layout:fixed;
		overflow:hidden;
		position:absolute;
		z-index:2000;
		top:-2000px;
		left:-2000px;
	}

	.ntb-column-resize-surface {
		filter:alpha(opacity=1);
		background-color:white;
		position:absolute;
		display:none;
		top:-1000px;
		left:-5000px;
		width:100px;
		height:100px;
		z-index:800;
	}

	.<xsl:value-of select="$t"/> .ntb-column-indicator {
		overflow:hidden;
		white-space: nowrap;    
	}

	.ntb-row<xsl:value-of select="$u" /> {height:<xsl:value-of select="$rowHeight" />px;line-height:<xsl:value-of select="$rowHeight" />px;margin:0px;}
	.ntb-header-row<xsl:value-of select="$u" /> {height:<xsl:value-of select="$g/@HeaderHeight" />px;}

	<xsl:apply-templates select="//ntb:columns" />

</xsl:template>

<xsl:template name="get-pane-width">
	<xsl:param name="column-id"/>
	<xsl:param name="start-column"/>
	<xsl:param name="end-column"/>
	<xsl:param name="current-width"/>
	<xsl:choose>
		<xsl:when test="$start-column &lt;= $end-column">
			<xsl:call-template name="get-pane-width">
				<xsl:with-param name="start-column" select="$start-column+1"/>
				<xsl:with-param name="end-column" select="$end-column"/>
				<xsl:with-param name="current-width" select="number($current-width) + number(//ntb:columns[@id=$column-id]/ntb:column[$start-column]/@Width)"/>
				<xsl:with-param name="column-id" select="$column-id"/>
			</xsl:call-template>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="$current-width"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template name="get-depth">
	<xsl:param name="root-column-id"/>
	<xsl:param name="current-column-id"/>
	<xsl:param name="current-depth"/>
	<xsl:choose>
		<xsl:when test="$root-column-id != $current-column-id">
			<xsl:call-template name="get-depth">
				<xsl:with-param name="current-column-id" select="//ntb:columns/ntb:column[@ChildColumnSet=$current-column-id and @type='EXPAND']/../@id"/>
				<xsl:with-param name="root-column-id" select="$root-column-id"/>
				<xsl:with-param name="current-depth" select="number($current-depth) + 1"/>
			</xsl:call-template>
		</xsl:when>
		<xsl:otherwise>
			<xsl:value-of select="$current-depth"/>
		</xsl:otherwise>
	</xsl:choose>
</xsl:template>

<xsl:template match="ntb:columns">
	<xsl:variable name="showvscroll"><xsl:choose><xsl:when test="($g/@VScrollbarEnabled='true' or $g/@VScrollbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>
	<xsl:variable name="showhscroll"><xsl:choose><xsl:when test="($g/@HScrollbarEnabled='true' or $g/@HScrollbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>
	<xsl:variable name="showtoolbar"><xsl:choose><xsl:when test="($g/@ToolbarEnabled='true' or $g/@ToolbarEnabled=1)">1</xsl:when><xsl:otherwise>0</xsl:otherwise></xsl:choose></xsl:variable>		

	<xsl:variable name="scrollerHeight" select="number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)" />
	<xsl:variable name="scrollerWidth" select="number($g/@Width)-(number($g/@scrollbarWidth)*number($g/@VScrollbarEnabled))" />

	<xsl:variable name="midHeight" select="number($g/@Height)-(number($g/@scrollbarHeight)*$showhscroll)-(number($g/@ToolbarHeight)*$showtoolbar)-number($g/@top)"/>

	<xsl:variable name="frozen-columns-width">
		<xsl:call-template name="get-pane-width">
			<xsl:with-param name="start-column" select="number(1)"/>
			<xsl:with-param name="end-column" select="number($g/@FrozenLeftColumnCount)"/>
			<xsl:with-param name="current-width" select="number(0)"/>
			<xsl:with-param name="column-id" select="@id"/>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="unfrozen-columns-width">
		<xsl:call-template name="get-pane-width">
			<xsl:with-param name="start-column" select="number($g/@FrozenLeftColumnCount)+1"/>
			<xsl:with-param name="end-column" select="count(*)"/>
			<xsl:with-param name="current-width" select="number(0)"/>
			<xsl:with-param name="column-id" select="@id"/>
		</xsl:call-template>
	</xsl:variable>
	
	<xsl:variable name="depth">
		<xsl:call-template name="get-depth">
			<xsl:with-param name="root-column-id" select="$g/@RootColumns"/>
			<xsl:with-param name="current-column-id" select="@id"/>
			<xsl:with-param name="current-depth" select="number(0)"/>
		</xsl:call-template>
	</xsl:variable>
	<xsl:variable name="total-columns-width">
		<xsl:value-of select="number($frozen-columns-width) + number($unfrozen-columns-width)"/>
	</xsl:variable>
	<xsl:variable name="id"><xsl:value-of select="@id"/></xsl:variable>
	
	.ntb-grid-midheight<xsl:value-of select="$u" />-0 {overflow:hidden;height:<xsl:choose><xsl:when test="($total-columns-width &gt; $g/@Width)"><xsl:value-of select="$midHeight"/></xsl:when><xsl:otherwise><xsl:value-of select="number($midHeight) + number($g/@scrollbarHeight)"/></xsl:otherwise></xsl:choose>px;}
	<xsl:if test="$id = $g/@RootColumns">
		.ntb-grid-scrollerheight<xsl:value-of select="$u" /> {height: <xsl:choose><xsl:when test="($total-columns-width &gt; $g/@Width)"><xsl:value-of select="$scrollerHeight"/></xsl:when><xsl:otherwise><xsl:value-of select="number($scrollerHeight) + number($g/@scrollbarHeight)"/></xsl:otherwise></xsl:choose>px;}
	</xsl:if>
	.hScrollbarRange<xsl:value-of select="$u" /> {
		width:<xsl:value-of select="$total-columns-width"/>px;
	}

	<xsl:choose>
		<xsl:when test="$id = $g/@RootColumns">
			.ntb-grid-surfacewidth<xsl:value-of select="$u" />-<xsl:value-of select="@id"/> {width:<xsl:value-of select="number($g/@ViewableWidth)"/>px;}
		</xsl:when>
		<xsl:otherwise>
			.ntb-grid-surfacewidth<xsl:value-of select="$u" />-<xsl:value-of select="@id"/> {width:<xsl:value-of select="number($g/@ViewableWidth)-(number($depth) * number($g/@GroupOffset)) - (number($depth) + 1)"/>px;}
		</xsl:otherwise>
	</xsl:choose>
	<xsl:for-each select="*">
		<xsl:variable name="p"><xsl:value-of select="position()"/></xsl:variable>
		<xsl:variable name="w"><xsl:value-of select="@Width"/></xsl:variable>
		#grid<xsl:value-of select="$u" /> .ntb-column<xsl:value-of select="$u" /><xsl:if test="$id!=&quot;&quot;">_<xsl:value-of select="$id"/></xsl:if>_<xsl:number value="$p" /> {width:<xsl:value-of select="number($w)-number($g/@CellBorder)" />px;}
		#grid<xsl:value-of select="$u" /> .ntb-column-data<xsl:value-of select="$u" />_<xsl:number value="$p" /> {text-align:<xsl:value-of select="@Align"/>;}
	</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
