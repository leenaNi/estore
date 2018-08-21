<?php
include 'Functions.php';


// Create Xml order to describe the order parameters:
$data='<?xml version="1.0" encoding="UTF-8"?>';
$data.="<TKKPG>";
$data.="<Request>";
$data.="<Operation>CreateOrder</Operation>";
$data.="<Language>EN</Language>";
$data.="<Order>";
$data.="<OrderType>Purchase</OrderType>";
$data.="<Merchant>".$_POST['Merchant']."</Merchant>";
$data.="<Amount>". $_POST['Amount'] * 100 ."</Amount>";
$data.="<Currency>".$_POST['Currency']."</Currency>";
$data.="<Description>".$_POST['Description']."</Description>";
$data.="<ApproveURL>".htmlentities($_POST['ApproveURL'])."</ApproveURL>";
$data.="<CancelURL>".htmlentities($_POST['CancelURL'])."</CancelURL>";
$data.="<DeclineURL>".htmlentities($_POST['DeclineURL'])."</DeclineURL>";
$data.="</Order></Request></TKKPG>";
// Information on the result of the order creation in the Response object
// Examples of obtaining required fields:
$xml=PostQW($data);




$OrderID=$xml->Response->Order->OrderID;
$SessionID=$xml->Response->Order->SessionID;
$URL=$xml->Response->Order->URL;

$data='<?xml version="1.0" encoding="UTF-8"?>';
$data.="<TKKPG>";
$data.="<Request>";
$data.="<Operation>GetOrderStatus</Operation>";
$data.="<Order>";
$data.="<Merchant>".$_POST['Merchant']."</Merchant>";
$data.="<OrderID>".$OrderID."</OrderID>";
$data.="</Order>";
$data.="<SessionID>".$SessionID."</SessionID>";
$data.="</Request></TKKPG>";
$xml=PostQW($data);
$OrderStatus=$xml->Response->Order->OrderStatus;

// Request for payment page
if ($OrderID!="" and $SessionID!=""){
	//Update existing Order XML by Create Order Status
	$xml=new DOMDocument('1.0', 'utf-8');
	$xml->formatOutput = true;
	$xml->preserveWhiteSpace = false;
	$xml->load('Order.xml');

	//Get item element
	$element=$xml->getElementsByTagName('Order')->item(0);

	//Load child elements
	$oID=$element->getElementsByTagName('OrderID')->item(0);
	$sID=$element->getElementsByTagName('SessionID')->item(0);
	$PurchaseAmount=$element->getElementsByTagName('PurchaseAmount')->item(0);
	$Currency=$element->getElementsByTagName('Currency')->item(0);
	$Description=$element->getElementsByTagName('Description')->item(0);
	$PAN=$element->getElementsByTagName('PAN')->item(0);
	$oStatus=$element->getElementsByTagName('Status')->item(0);

	//Replace old elements with new
	$element->replaceChild($oID, $oID);
	$element->replaceChild($sID, $sID);
	$element->replaceChild($PurchaseAmount, $PurchaseAmount);
	$element->replaceChild($Currency, $Currency);
	$element->replaceChild($Description, $Description);
	$element->replaceChild($PAN, $PAN);
	$element->replaceChild($oStatus, $oStatus);

	//Assign elements with new value
	$oID->nodeValue = $OrderID;
	$sID->nodeValue = $SessionID;
	$PurchaseAmount->nodeValue = $_POST['Amount'] * 100;
	$Currency->nodeValue = $_POST['Currency'];
	$Description->nodeValue = $_POST['Description'];
	$PAN->nodeValue = '';
	$oStatus->nodeValue = $OrderStatus;
	$xml->save('Order.xml');

	// Add codes for saving the Order ID and Session ID in Merchant DB for future uses.
	header("Location: " . $URL . "?ORDERID=" . $OrderID. "&SESSIONID=" . $SessionID . "");
	exit();
}
?>