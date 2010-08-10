/*
 * Nitobi Complete UI 1.0
 * Copyright(c) 2008, Nitobi
 * support@nitobi.com
 * 
 * http://www.nitobi.com/license
 */
var adjustXixslt='<?xml version="1.0" encoding="utf-8"?> <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:eba="http://www.ebusinessapplications.ca/ebagrid#"> <xsl:output method="xml" omit-xml-declaration="yes" /> <x:p-x:n-startingIndex"x:s-5"> </x:p-> <x:p-x:n-adjustment"x:s--1"> </x:p-> <x:t- match="*|@*"> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:t-> <x:t- match="//eba:data[@id=\'_default\']/eba:e|@*"> <x:c-> <x:wh- test="number(@xi) &gt;= number($startingIndex)"> <xsl:copy> <x:at-x:s-@*|node()" /> <x:ct-x:n-increment-xi" /> </xsl:copy> </x:wh-> <x:o-> <xsl:copy> <x:at-x:s-@*|node()" /> </xsl:copy> </x:o-> </x:c-> </x:t-> <x:t-x:n-increment-xi"> <xsl:attributex:n-xi"> <x:v-x:s-number(@xi) + number($adjustment)" /> </xsl:attribute> </x:t-> </xsl:stylesheet> ';
adjustXixslt=adjustXixslt.replace(/x:c-/g, 'xsl:choose').replace(/x\:wh\-/g, 'xsl:when').replace(/x\:o\-/g, 'xsl:otherwise').replace(/x\:n\-/g, ' name="').replace(/x\:s\-/g, ' select="').replace(/x\:va\-/g, 'xsl:variable').replace(/x\:v\-/g, 'xsl:value-of').replace(/x\:ct\-/g, 'xsl:call-template').replace(/x\:w\-/g, 'xsl:with-param').replace(/x\:p\-/g, 'xsl:param').replace(/x\:t\-/g, 'xsl:template').replace(/x\:at\-/g, 'xsl:apply-templates')