<?php

if(isset($_POST['txtStartingAmount'])){
	$startingAmount = $_POST['txtStartingAmount'];
	$dbhost = 'localhost';
	$dbuser = 'b18_14786106';
	$dbpass = 'cq0dwkx2';
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);

	if(!$conn){
		die('Could not connect: ' . mysql_error());
	}
	$sql = 'INSERT INTO transactions ' .
		'(description, amount, balance) ' .
		'VALUES ("Starting Amount",' . $startingAmount . ',' . $startingAmount . ')';
}
?>

<html>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	Checking<br />
	<form action="Checking.php" method="POST" id="frmStartingAmount">
		<div id="startingAmtError" style="display: none">The starting amount must be a number.</div>
		Enter Starting Amount: <input type="text" id="txtStartingAmount" name="txtStartingAmount" />
		<input type="button" id="btnStart" value="Start" onclick="StartingAmount();" />
	</form>
	
	<br/><br/>
	New Transaction Amount: <input type="text" id="txtNewAmount" /><br/>
	New Transaction Description: <input type="text" id="txtNewDescription" /><br/>
	<input type="button" id="btnNewTransaction" value="New Transaction" onclick="StartingAmount();" /><br />
	<hr>
</html>
<script>
	function StartingAmount(){
		$('#startingAmtError').hide();
		var transactionAmt = $('#txtStartingAmount').val();
		if($.trim(transactionAmt) == "" || !isNumber($.trim(transactionAmt))){
			$('#startingAmtError').show();
			$('#txtStartingAmount').val('');
		}
		else {
			//write the number to the db
			$('#frmStartingAmount').submit();
		}
	}

	function isNumber(n) {
	  	return !isNaN(parseFloat(n)) && isFinite(n);
	}
</script>
