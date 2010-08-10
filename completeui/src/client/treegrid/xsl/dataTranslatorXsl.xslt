<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
	xmlns:ntb="http://www.nitobi.com">
	<xsl:output method="xml" omit-xml-declaration="yes" />

	<xsl:param name="start" select="0"></xsl:param>
	<xsl:param name="id" select="'_default'"></xsl:param>
	<xsl:param name="xkField" select="'a'"></xsl:param>
	<xsl:param name="totalRowCount" select="//root/@totalrowcount"/>
	<xsl:param name="parentfield" select="//root/@parentfield"/>
	<xsl:param name="parentvalue" select="//root/@parentvalue"/>
	<xsl:param name="primaryfield" select="//root/@primaryfield"/>
	<xsl:template match="//root">
		<ntb:treegrid xmlns:ntb="http://www.nitobi.com">
			<ntb:datasources>
				<ntb:datasource id="{$id}" totalrowcount="{$totalRowCount}">
					<xsl:if test="$parentfield">
						<xsl:attribute name="parentfield"><xsl:value-of select="$parentfield"/></xsl:attribute>
					</xsl:if>
					<xsl:if test="$parentvalue">
						<xsl:attribute name="parentvalue"><xsl:value-of select="$parentvalue"/></xsl:attribute>
					</xsl:if>
					<xsl:if test="$primaryfield">
						<xsl:attribute name="primaryfield"><xsl:value-of select="$primaryfield"/></xsl:attribute>
					</xsl:if>	
					<xsl:if test="@error">
						<xsl:attribute name="error"><xsl:value-of select="@error" /></xsl:attribute>
					</xsl:if>
					<ntb:datasourcestructure id="{$id}">
						<xsl:attribute name="FieldNames"><xsl:value-of select="@fields" />|_xk</xsl:attribute>
						<xsl:attribute name="Keys">_xk</xsl:attribute>
					</ntb:datasourcestructure>
					<ntb:data id="{$id}">
						<xsl:for-each select="//e">
							<xsl:apply-templates select=".">
								<xsl:with-param name="xi" select="position()-1"></xsl:with-param>
							</xsl:apply-templates>					
						</xsl:for-each>
					</ntb:data>
				</ntb:datasource>
			</ntb:datasources>
		</ntb:treegrid>
	</xsl:template>

	<xsl:template match="e">
		<xsl:param name="xi" select="0"></xsl:param>
		<ntb:e>
			<xsl:copy-of select="@*[not(name() = 'xk')]"></xsl:copy-of>
			<xsl:if test="not(@xi)"><xsl:attribute name="xi"><xsl:value-of select="$start + $xi" /></xsl:attribute></xsl:if>
			<xsl:attribute name="{$xkField}"><xsl:value-of select="@xk" /></xsl:attribute>
		</ntb:e>
	</xsl:template>

	<xsl:template match="lookups"></xsl:template>

</xsl:stylesheet>