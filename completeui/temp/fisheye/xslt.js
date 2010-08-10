var temp_ntb_renderer='<?xml version=\'1.0\'?><xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:ntb="http://www.nitobi.com"> <xsl:output method="xml" /> <x:t- match="//ntb:fisheye"> <div> <x:a-x:n-id"> <x:v-x:s-@id" /> </x:a-> <x:a-x:n-class"> ntb-fisheye-reset <x:c-> <x:wh- test="./@theme"> <x:v-x:s-./@theme"/> </x:wh-> <x:o-> nitobi </x:o-> </x:c-> </x:a-> &#160; </div></x:t-></xsl:stylesheet>';
nitobi.lang.defineNs("nitobi.fisheye");
nitobi.fisheye.renderer = nitobi.xml.createXslProcessor(nitobiXmlDecodeXslt(temp_ntb_renderer));
