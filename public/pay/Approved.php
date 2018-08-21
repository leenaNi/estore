<html>
	<body>
		<h2>Approved Order Details</h2>
		<form action="http://buyersclub.infinisystem.com/pay/">
			<table border=0 cellspacing=2 cellpadding=2>
				<?php
					include 'Functions.php';
					if (@$_REQUEST['xmlmsg']!=""){

						$xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
						$json = json_encode($xmlResponse);
						$array = json_decode($json,TRUE);
												
						//Update existing Order XML by Approved Status
						$xmlData=new DOMDocument('1.0', 'utf-8');
						$xmlData->formatOutput = true;
						$xmlData->preserveWhiteSpace = false;
						$xmlData->load('Order.xml');
						
						//Get item element
						$element=$xmlData->getElementsByTagName('Order')->item(0);

						//Load child element
						$OrderID_Data=$element->getElementsByTagName('OrderID')->item(0);
						
						if(@$array[OrderID]==$OrderID_Data->nodeValue){
							$SessionID_Data=$element->getElementsByTagName('SessionID')->item(0);
							$Status_Data=$element->getElementsByTagName('Status')->item(0);
							$ApprovalCode_Data=$element->getElementsByTagName('ApprovalCode')->item(0);
							$PAN_Data=$element->getElementsByTagName('PAN')->item(0);
																					
							// Call GetOrderInformation Operation for getting Order details
							$data='<?xml version="1.0" encoding="UTF-8"?>';
							$data.="<TKKPG>";
							$data.="<Request>";
							$data.="<Operation>GetOrderInformation</Operation>";
							$data.="<Language>EN</Language>";
							$data.="<Order>";
							$data.="<Merchant>11122333</Merchant>";
							$data.="<OrderID>".$OrderID_Data->nodeValue."</OrderID>";
							$data.="</Order>";
							$data.="<SessionID>".$SessionID_Data->nodeValue."</SessionID>";
							$data.="<ShowParams>true</ShowParams>";
							$data.="<ShowOperations>false</ShowOperations>";
							$data.="<ClassicView>true</ClassicView>";
							$data.="</Request></TKKPG>";

							$xml=PostQW($data);

							//print_r($xml);

							$Orderstatus = $xml->Response->Order->row->Orderstatus;
							
							//Extract additional parameters for verification
							foreach($xml->Response->Order->row->OrderParams->row as $item)
							{
								if($item->PARAMNAME == "PAN")
									$PAN = $item->VAL;
							}	
							
							//Replace old element with new
							$element->replaceChild($Status_Data, $Status_Data);
							$element->replaceChild($ApprovalCode_Data, $ApprovalCode_Data);
							$element->replaceChild($PAN_Data, $PAN_Data);

							//Assign element with new value
							$Status_Data->nodeValue = $Orderstatus;
							$ApprovalCode_Data->nodeValue = @$array[ApprovalCode];
							$PAN_Data->nodeValue = @$array[PAN];
							$xmlData->save('Order.xml');							
						}
				?>
				<tr>
					<?php
					echo "<td align=left>Order ID</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[OrderID] . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>Transaction Type</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[TransactionType] . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>Currency</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[Currency] . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>Purchase Amount</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[PurchaseAmount] / 100 . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>Response Code</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[ResponseCode] . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>Response Description</td>";
					echo "<td align=left>=</td>";
					echo "<td align=right>" . @$array[ResponseDescription] . "</td>";
					?>
				</tr>	
				<tr>
					<?php
					echo "<td align=left>Order Status</td>";
					echo "<td align=left>=</td>";     
					echo "<td align=right>" . $Orderstatus . "</td>";
					?>
				</tr>	
				<tr>
					<?php
					echo "<td align=left>Approval Code</td>";
					echo "<td align=left>=</td>";     
					echo "<td align=right>" . @$array[ApprovalCode] . "</td>";
					?>
				</tr>
				<tr>
					<?php
					echo "<td align=left>PAN</td>";
					echo "<td align=left>=</td>";     
					echo "<td align=right>" . $PAN . "</td>";
					}
					?>
				</tr>			
			</table>			
			<br/>
			<input type="submit" value="Back to Create Order"/>
		</form>
		<hr/>
	</body>
</html>