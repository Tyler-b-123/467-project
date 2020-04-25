<html>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="customerpage.css">
	<link rel="stylesheet" href="bar.css">
	<head><title>Customer Page 5A</title></head>
	<?php
		$username = "student";
		$password = "student";

		try{
			$dsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
			$pdo = new PDO($dsn, $username, $password);
		}
		catch(PDOexception $e){
			echo "Connection to the database failed: " . $e->getMessage();
		}

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

		$prepared = $pdo->prepare("SELECT * FROM parts");
		$prepared->execute();

	?>

	<body>
	<svg id="bar">
	   <rect id="barRect" />
	</svg>
	   <div class="customerPic">
		<img src="customer.jpg" />
	   </div>
	   <div class="adminPic">
		<img src="Admin.jpg" />
	   </div>
	   <div class="frontdeskPic">
		<img src="frontdesk.jpg" />
	   </div>
	   <div class="warehousePic">
		<img src="warehouse.jpg" />
	   </div>
	<center><h1>Customer Page</h1></center>

	<table id="example" class="display" width="100%"></table>
	<div class="cartIconPic">
           <img src="CartIcon.png" />
        </div>
	<form name="partForm" action="#" method="POST">
	   <label id="partLabel">Part Number:</label><br>
	   <input type="text" id="partNum" name="partNum"><br>
	   <input type="button" value="Add to Cart" onclick="addItem()" id="partButton">
	</form>
	<div id="cartTableDiv">
	<table id="cartTable" class="display" width="60%"></table>
	</div>
	<div id ="totals">
	</div>
	<div id="creditCard">
	   <img src="CreditCardPic.png" />
	   <form name="creditCardForm" action="customerPage.php" method="POST">
		<label>Vendor:</label>
		<input type="text" name="vendor"><br>
		<label>Transaction Number:</label>
		<input type="text" name="trans"><br>
		<label>Credit Card Number:</label>
		<input type="text" name="cc"><br>
		<label>Name:</label>
		<input type="text" name="name"><br>
		<label>Experation Date:</label>
		<input type="text" name="exp"><br>
		<label>Total Due:</label>
		<input type="text" name="amount"><br>
		<input type="submit" value="Pay" name="ccButton" onclick="pay()" id="paymentButton">
	   </form>
	</div>
	</body>
	<script src="bar.js"></script>
	<script type="text/javascript">

	var dataSet = [];
	var cartDataSet = [];
	var totals = 0;
	var totalsOutput = 0.00;
	   <?php while($row = $prepared->fetch() ): ?>
		var image = "<?php echo ($row['pictureURL']); ?>"
			//maybe will work
		dataSet.push(["<img src='<?php echo ($row['pictureURL']); ?>' />", "<?php echo ($row['number']); ?>", "<?php echo ($row['description']); ?>",
		"<?php echo ($row['weight']); ?>", "$<?php echo ($row['price']); ?>" ]);
	   <?php endwhile; ?>
	   createTable();

	   function createTable(){

		$(document).ready(function() {
		   $('#example').DataTable(  {
			data: dataSet,
			columns: [
			   { title: "Picture" },
			   { title: "Part Number" },
			   { title: "Description" },
			   { title: "Weight" },
			   { title: "Price" }
			]

		   } );
	  	} );
	   }

	   function addItem(){
		console.log("hi");
		var partNum = document.getElementById("partNum").value;
		console.log(partNum);
		var i = 0;

		while (i < dataSet.length){
		   if (dataSet[i][1] == partNum){
			cartDataSet.push([dataSet[i][0], dataSet[i][2], dataSet[i][4]]);
			console.log(cartDataSet[0]);

			var c = 0;
			var temp = 0.00;
			var placeholder = dataSet[i][4];
			placeholder = placeholder.substring(1);
			var value = parseFloat(placeholder);
			totals = totals + value;
			var totalsTemp = totals.toFixed(2);
			totalsOutput = totalsTemp;
			console.log(totalsOutput);
			createCartTable();
		   }
		   i++;
		}

	   }

	   function createCartTable(){
		$(document).ready(function() {
		   $('#cartTable').DataTable( {
			data: cartDataSet,
			sort: false,
			destroy: true,
			columns: [
			   { title: "Picture" },
			   { title: "Description" },
			   { title: "Price"}
			]
		   } );
		} );
		var x = document.getElementById("totals");
		x.innerHTML ="Total:     " + "$" + totalsOutput.toString();

		document.getElementsByName('amount')[0].value = totalsOutput.toString();

	   }
	function pay(){
	   <?php
		$vendor = NULL;
		$trans = NULL;
		$cc = NULL;
		$name = NULL;
		$exp = NULL;
		$amount = NULL;

		if (isset($_POST['amount'])){
		   $amount = $_POST['amount'];
		}
		if (isset($_POST['vendor'])){
		   $vendor = $_POST['vendor'];
		}
		if (isset($_POST['trans'])){
		   $trans = $_POST['trans'];
		}
		if (isset($_POST['cc'])){
		   $cc = $_POST['cc'];
		}
		if (isset($_POST['name'])){
		   $name = $_POST['name'];
		}
		if (isset($_POST['exp'])){
		   $exp = $_POST['exp'];
		

		$url = 'http://blitz.cs.niu.edu/CreditCard/';
		$data = array(
		   'vendor' => $vendor,
		   'trans' => $trans,
		   'cc' => $cc,
		   'name' => $name,
		   'exp' => $exp,
		   'amount' => $amount);
		$options = array(
		   'http' => array(
			'header' => array('Content-type:application/json','Accept: application/json'),
			'method' => 'POST',
			'content' => json_encode($data)
		   )
		);

		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
//		echo($result);

		$vendor = NULL;
                $trans = NULL;
                $cc = NULL;
                $name = NULL;
                $exp = NULL;
		$amount = NULL;
		}
	   ?>
	alert("Transaction Successful Reloading Page");
}
</script>

</html>
