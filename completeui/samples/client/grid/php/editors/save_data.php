<?php
header('Content-type: text/xml');
require("../../../../server/php/base_gethandler.php");
include "setting.php";

/*   This file is used as a Save Handler for the Grid control. When the user clicks
	 the save button in default.php a datagram is sent to this script.
	 The script in turn looks at each update in the datagram and processes them accordingly.

	 We have provided all the necessary functionality to extract any of the update instructions.

     This block of code is ADO connection code used only for demonstration purposes
     objConn is an ADO object we use here for demonstration purposes.
 */

$saveHandler = new EBASaveHandler();
$saveHandler->ProcessRecords();

// Make a MySQL Connection

$link = mysql_connect($server, $uid, $password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());

// ********************************************************** '
// Begin by processing our inserts
// ********************************************************** '
$insertCount = $saveHandler->ReturnInsertCount();
if ($insertCount > 0)
{
	// Yes there are INSERTs to perform...
	for ($currentRecord = 0; $currentRecord < $insertCount; $currentRecord++)
	{
		$myQuery  = "INSERT INTO tblproducts (ProductName, ProductSku, ProductPrice, ProductQuantityPerUnit, ProductCategoryName) VALUES (" .
					"'" . $saveHandler->ReturnInsertField($currentRecord, "ProductName")  . "', " .
					"'" . $saveHandler->ReturnInsertField($currentRecord,"ProductSKU") . "', " .
					"'" . $saveHandler->ReturnInsertField($currentRecord,"ProductPrice") . "', " .
					"'" . $saveHandler->ReturnInsertField($currentRecord,"ProductQuantityPerUnit") . "', " .
					"'" . $saveHandler->ReturnInsertField($currentRecord,"ProductCategoryName") . "' " .
					"); ";

					
		// Now we execute this query
		mysql_query($myQuery);


	}
}

// ********************************************************** '
// Continue by processing our updates
// ********************************************************** '
$updateCount = $saveHandler->ReturnUpdateCount();
if ($updateCount > 0)
{
	// Yes there are UPDATEs to perform...
	for ($currentRecord = 0; $currentRecord < $updateCount; $currentRecord++)
	{
		$myQuery = "UPDATE tblproducts SET ".
			"ProductName 			= '" . $saveHandler->ReturnUpdateField($currentRecord,"ProductName")	. "', ".
			"ProductCategoryName 	= '" . $saveHandler->ReturnUpdateField($currentRecord,"ProductCategoryName")	. "', ".
			"ProductSKU 			= '" . $saveHandler->ReturnUpdateField($currentRecord,"ProductSKU") 		. "', ".
			"ProductPrice 			= '" . $saveHandler->ReturnUpdateField($currentRecord,"ProductPrice") 	. "', ".
			"ProductQuantityPerUnit = '" . $saveHandler->ReturnUpdateField($currentRecord,"ProductQuantityPerUnit") 	. "' ".
			"WHERE ProductID 		= '" . $saveHandler->ReturnUpdateField($currentRecord,"") . "';";

			
	
		// Now we execute this query
		 mysql_query($myQuery);
	}
}

// ********************************************************** '
// Finish by processing our deletes
// ********************************************************** '

$deleteCount = $saveHandler->ReturnDeleteCount();
if ($deleteCount > 0)
{
	// Yes there are DELETES to perform...
	for ($currentRecord = 0; $currentRecord < $deleteCount; $currentRecord++)
	{
		$myQuery = "DELETE FROM tblproducts WHERE ProductID = '" . $saveHandler->ReturnDeleteField($currentRecord) . "'";

		// Now we execute this query
		 mysql_query($myQuery);
	}
}

$saveHandler->CompleteSave();
mysql_close();

?>
