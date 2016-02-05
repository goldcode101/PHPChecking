<?php

/*
 * DATABASE CREDENTIALS
 * --------------------
 */

$dbhost = 'localhost';
$dbuser = 'dev';
$dbpass = 'doublemap';
$dbname = 'checking';

/*
 * HANDLE HTTP REQUESTS
 * --------------------
 */

// Handle POST request to set starting amount
if(isset($_POST['txtStartingAmount'])){
	$startingAmount = $_POST['txtStartingAmount'];
    $conn = connectDatabase();
    addTransaction("Starting Amount", $startingAmount, $startingAmount);
    mysql_close($conn);
}


/*
 * HELPER FUNCTIONS
 * ----------------
 */
function connectDatabase($host, $user, $pass) {
    global $dbhost, $dbuser, $dbpass, $dbname;
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);
	if(!$conn) die('Could not connect: ' . mysql_error());
    $res = mysql_query(sprintf("USE %s", $dbname));
    return $conn;
}

function addTransaction($desc, $amt, $bal) {
    $sql = sprintf(
        "INSERT INTO transactions (description, amount, balance) VALUES
        ('%s', %d, %d)", mysql_real_escape_string($desc), $amt, $bal);
    $res = mysql_query($sql);
    if(!$res)
        die("Error saving transaction: " . mysql_error());
    else return true;
}

function fetchTransactions($startDate, $endDate) {
    $query = sprintf(
        "SELECT id, created, description, amount, balance
         FROM transactions WHERE created BETWEEN %s AND %s",
        $startDate, $endDate);
    $res = mysql_query($query);
    $rows = array();
    while($row = mysql_fetch_assoc($res))
        $rows[] = $row;
    return $rows;
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
