<%@ Language=VBScript %>
<!--#include file="../../../../server/asp/base_gethandler.inc"-->

<%
dim objConn
dim accessdb

dim strconn

accessdb=server.mappath(".") & "..\..\..\..\..\server\common\datasources\en\GeneralProducts.mdb"
strconn="PROVIDER=Microsoft.Jet.OLEDB.4.0;DATA SOURCE=" & accessDB & ";USER ID=;PASSWORD=;"
Set objConn = Server.CreateObject("ADODB.Connection")
objConn.open strconn


dim CurrentRecord
dim MyQuery

' ********************************************************** '
' Begin by processing our inserts
' ********************************************************** '

EBASaveHandler_ProcessRecords


if EBASaveHandler_ReturnInsertCount > 0 then
	' Yes there are INSERTs to perform...

	for CurrentRecord = 0 to EBASaveHandler_ReturnInsertCount-1
	
		' NOTE: Because in this example we actually perform the database INSERT in the allocaterecord.asp
		' document, we only need to do an INSERT here. We do this to keep the primary key of the record
		' in sync with the grid.

		MyQuery = "INSERT INTO tblproducts (ProductName, ProductCategoryName, ProductSKU"
		if EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductPrice") <> "" then
			MyQuery = MyQuery & ", ProductPrice"
		end if
		MyQuery = MyQuery & ", ProductQuantityPerUnit) VALUES ("

		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductName") & "', "
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductCategoryName") & "', "
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductSKU") & "', "
		if EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductPrice") <> "" then
			MyQuery = MyQuery & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductPrice") & ", "
		end if
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductQuantityPerUnit") & "')"

		' Now we execute this query
		objConn.execute(MyQuery)

	next
end if


' ********************************************************** '
' Continue by processing our updates
' ********************************************************** '

if EBASaveHandler_ReturnUpdateCount > 0 then
	' Yes there are UPDATEs to perform...

	for CurrentRecord = 0 to EBASaveHandler_ReturnUpdateCount-1

		dim price
		price = 0
		if EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductPrice") <> "" then
			price = EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductPrice")
		end if

		MyQuery = "UPDATE tblproducts SET "

		MyQuery = MyQuery & "ProductName = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductName") & "', "
		MyQuery = MyQuery & "ProductCategoryName = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductCategoryName") & "', "
		MyQuery = MyQuery & "ProductSKU = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductSKU") & "', "
		MyQuery = MyQuery & "ProductPrice = " & price & ", "
		MyQuery = MyQuery & "ProductQuantityPerUnit = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductQuantityPerUnit") & "'"

		MyQuery = MyQuery & " WHERE ProductID = " & EBASaveHandler_ReturnUpdateField(CurrentRecord,"PK") & ";"

		' Now we execute this query
		objConn.execute(MyQuery)


	next
end if




' ********************************************************** '
' Finish by processing our deletes
' ********************************************************** '

if EBASaveHandler_ReturnDeleteCount > 0 then
	' Yes there are DELETEs to perform...

	for CurrentRecord = 0 to EBASaveHandler_ReturnDeleteCount-1

		MyQuery = "DELETE FROM tblproducts WHERE ProductID = " & EBASaveHandler_ReturnDeleteField(CurrentRecord) & ";"

		' Now we execute this query
		objConn.execute(MyQuery)

	next
end if

EBASaveHandler_CompleteSave

%>
