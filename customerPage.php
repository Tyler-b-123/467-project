<html>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="customerPage.css">
	<head><title>Customer Page 5A</title></head>
	<?php
		$dom = new DOMDocument('1.0', 'iso-8859-1');
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
	<h1>I am connected to the database</h1>

	<table id="example" class="display" width="100%"></table>

	<form name="partForm" action="#" method="POST">
	   <label id="partLabel">Part Number:</label><br>
	   <input type="text" id="partNum" name="partNum"><br>
	   <input type="button" value="Submit" onclick="addItem()" id="partButton">
	</form>

	<table id="cartTable" class="display" width="60%"></table>
	<div id ="totals">
	</div>
	</body>

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
	   }

	</script>
</html>
