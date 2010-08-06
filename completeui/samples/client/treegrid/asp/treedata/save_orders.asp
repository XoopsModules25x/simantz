<%@ Language=VBScript%>
<!--#include file="nitobi.xml.inc"-->

<%
dim objConn
dim accessdb

dim strconn

accessdb=server.mappath(".") & "\nitobitestdb.mdb"	
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

		MyQuery = "INSERT INTO tblMDOrders (CustomerID, OrderDate, ShippedDate, ProductName) VALUES ("
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnForeignKeyValue(CurrentRecord) & "',"
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"OrderDate") & "', "
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ShippedDate") & "', "
		MyQuery = MyQuery & "'" & EBASaveHandler_ReturnInsertField(CurrentRecord,"ProductName") & "'"
		
		MyQuery = MyQuery & ");"

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

		MyQuery = "UPDATE tblMDOrders SET "
		
		MyQuery = MyQuery & "OrderDate = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"OrderDate") & "', "
		MyQuery = MyQuery & "ShippedDate = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ShippedDate") & "', "
		MyQuery = MyQuery & "ProductName = '" & EBASaveHandler_ReturnUpdateField(CurrentRecord,"ProductName") & "' "
		
		MyQuery = MyQuery & " WHERE OrderID = " & EBASaveHandler_ReturnUpdateField(CurrentRecord,"PK") & ";"
		' PK is always our Primary Key for the row

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

		MyQuery = "DELETE FROM tblMDOrders WHERE OrderID = " & EBASaveHandler_ReturnDeleteField(CurrentRecord) & ";"

		' Now we execute this query
		objConn.execute(MyQuery)

	next
end if

EBASaveHandler_CompleteSave
Function Break(n)     
	Response.Write("<pre>" & n & "</pre>")
	Response.Flush()
	Response.End()
End Function
%>
