<html>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="customerPage.css">
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
	</div>
	<div id="getName">
	   <form id="nameForm" action="#" method="POST">
		<label id="nameLabel">Company Name:</label>
		<input type="text" id="companyName" name="companyName"><br>
		<input type="button" value="Submit" onclick="getName()">
	   </form>
	</div>
	<table id="example" class="display" width="100%"></table>
	<div class="cartIconPic">
           <img src="CartIcon.png" />
        </div>
	<div id="partFormCss">
	<form id="partForm" action="#" method="POST">
	   <label id="partLabel">Part Number:</label>
	   <input type="text" id="partNum" name="partNum"><br>
	   <label id="partLabel2">QTY:</label>
	   <input type="text" id="partQty" name="partQty"><br>
	   <input type="button" value="Add to Cart" onclick="addToCart()">
	</form>
	</div>
	<div id="cartTableDiv">
	<table id="cartTable" class="display" width="60%"></table>
	</div>
	<div id ="totals">
	</div>
	<div id="creditCard">
	   <img src="CreditCardPic.png" />
	   <form id="creditCardForm" action="#" method="POST">
		<label>Vendor:</label>
		<input type="text" name="vendor" id="vendor"><br>
		<label>Transaction Number:</label>
		<input type="text" name="trans" id="trans"><br>
		<label>Credit Card Number:</label>
		<input type="text" name="cc" id="cc"><br>
		<label>Name:</label>
		<input type="text" name="name" id="name"><br>
		<label>Experation Date:</label>
		<input type="text" name="exp" id="exp"><br>
		<input type="button" value="Pay" onclick="pay()">
	   </form>
	</div>
	</body>
	<script src="bar.js"></script>
	<script type="text/javascript">

	var name;
	function getName(){
	   name = document.getElementById("companyName").value;
	   alert("Thank you for letting us know who you are you may now proceed.");
	}



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

	   function addToCart(){
		   console.log("hi");
                var partNum = document.getElementById("partNum").value;
                var partQty = document.getElementById("partQty").value;
                console.log(partNum);
                console.log(partQty);



                var i = 0;

                while (i < dataSet.length){
                   if (dataSet[i][1] == partNum){

                        cartDataSet.push([dataSet[i][0], dataSet[i][2], partQty, dataSet[i][4]]);
                        console.log(cartDataSet[0]);

                        var c = 0;
                        var temp = 0.00;
                        var placeholder = dataSet[i][4];
                        placeholder = placeholder.substring(1);
                        var value = parseFloat(placeholder);
                        totals = totals + (value * partQty);
                        var totalsTemp = totals.toFixed(2);
                        totalsOutput = totalsTemp;
                        console.log(totalsOutput);


			var request = $.ajax({
			   type: "POST",
			   url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
			   data:
			   {
				name: name,
				number: partNum,
				qty: partQty
			   },
			   dataType: "html"
		   	});
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
			   { title: "QTY" },
			   { title: "Price"}
			]
		   } );
		} );
		var x = document.getElementById("totals");
		x.innerHTML ="Total:     " + "$" + totalsOutput.toString();

	   }

	function pay(){
	   var vendor = document.getElementById("vendor").value;
	   var trans = document.getElementById("trans").value;
	   var cc = document.getElementById("cc").value;
	   var name = document.getElementById("name").value;
	   var exp = document.getElementById("exp").value;
	   var amount = totalsOutput;

	   var request = $.ajax({
		type: "POST",
		url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
		data:
		{
		   vendor: vendor,
		   trans: trans,
		   cc: cc,
		   name: name,
		   exp: exp,
		   amount: amount
		},
		dataType: "html"
	});
	request.done(function(msg) {
	   alert("order was succesfull emailing you conformation.");
	});
	request.fail(function(jqXHR, textStatus) {
	   alert("Request failed: " + textStatus);
	});
	}
</script>

</html>
