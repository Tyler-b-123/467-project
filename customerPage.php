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
		$username2 = "z1782665";
		$password2= "1996Oct06";

		try{
			$dsn2 = "mysql:host=courses;dbname=test";
			$pdo2 = new PDO($dsn2, $username2, $password2);
			$dsn = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
			$pdo = new PDO($dsn, $username, $password);
		}
		catch(PDOexception $e){
			echo "Connection to the database failed: " . $e->getMessage();
		}

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

		$prepared = $pdo->prepare("SELECT * FROM parts");
		$prepared->execute();

		$prepared2 = $pdo2->prepare("SELECT * FROM shipping");
		$prepared2->execute();


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
		<label id="emailLabel">Email Address:</lable>
		<input type="text" id="companyEmail" name="companyEmail"><br>
		<label id="streetLabel">Street Address:</label>
		<input type="text" id="streetName" name="streetName"><br>
		<label id="cityLabel">City:</label>
		<input type="text" id="cityName" name="cityName"><br>
		<label id="stateLabel">State:</label>
		<input type="text" id="stateName" name="stateName"><br>
		<label id="zipLabel">Zip code:</label>
		<input type="text" id="zipName" name="zipName"><br>
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

	var name = "f";
	var email;
 	var street;
	var state;
	var zip;
	var address;
	var city;
	function getName(){
	   name = document.getElementById("companyName").value;
	   email = document.getElementById("companyEmail").value;
	   street = document.getElementById("streetName").value;
	   state = document.getElementById("stateName").value;
	   zip = document.getElementById("zipName").value;
	   city = document.getElementById("cityName").value;

	   address = street + " " + city + " "  + state + " " + zip;
	   console.log(address);

	   alert("Thank you for letting us know who you are you may now proceed.");
	}



	var dataSet = [];
	var tempShipping = [];
	var cartDataSet = [];
	var totals = 0;
	var totalsOutput = 0.00;
	var totalWeight = 0.00;
	var shippingFee = 0.00;
	   <?php while($row = $prepared->fetch() ): ?>
		var image = "<?php echo ($row['pictureURL']); ?>"
			//maybe will work
		dataSet.push(["<img src='<?php echo ($row['pictureURL']); ?>' />", "<?php echo ($row['number']); ?>", "<?php echo ($row['description']); ?>",
		"<?php echo ($row['weight']); ?>", "$<?php echo ($row['price']); ?>" ]);
	   <?php endwhile; ?>

	   <?php while($row = $prepared2->fetch() ): ?>

        	tempShipping.push([<?php echo ($row['placment']); ?>, <?php echo ($row['first']); ?>,
                	<?php echo ($row['second']); ?>, <?php echo ($row['price']); ?> ]);

   	   <?php endwhile; ?>

	console.log(tempShipping);



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

		if (name === "f"){
		   alert("Please enter your company first");
		}
		else{
                var partNum = document.getElementById("partNum").value;
                var partQty = document.getElementById("partQty").value;

                console.log(partNum);
                console.log(partQty);



                var i = 0;

                while (i < dataSet.length){
                   if (dataSet[i][1] == partNum){

                        cartDataSet.push([dataSet[i][0], dataSet[i][2], partQty, dataSet[i][4]]);
                        console.log(cartDataSet[0]);

		 	totalWeight += parseFloat(dataSet[i][3]);
			console.log(totalWeight);

			if(totalWeight < tempShipping[0][2]){
			   shippingFee = parseFloat(tempShipping[0][3]);
		  	}
			if(totalWeight < tempShipping[1][2] && totalWeight > tempShipping[1][1] + 1){
			   shippingFee = parseFloat(tempShipping[1][3]);
			}
			if(totalWeight < tempShipping[2][2] && totalWeight > tempShipping[2][1] + 1){
			   shippingFee = parseFloat(tempShipping[2][3]);
			}
			if(totalWeight < tempShipping[3][2] && totalWeight > tempShipping[3][1] + 1){
			   shippingFee = parseFloat(tempShipping[3][3]);
			}

                        var c = 0;
                        var temp = 0.00;
                        var placeholder = dataSet[i][4];
                        placeholder = placeholder.substring(1);
                        var value = parseFloat(placeholder);
                        totals = totals + (value * partQty);
                        var totalsTemp = totals.toFixed(2);
			totalsTemp = parseFloat(totalsTemp);
			totalsTemp = totalsTemp + shippingFee;
                        totalsOutput = totalsTemp.toFixed(2);
                        console.log(totalsOutput);

			var request = $.ajax({
			   type: "POST",
			   url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
			   data:
			   {
				name: name,
				number: partNum,
				qty: partQty,
				email: email,
				address: address
			   },
			   dataType: "html"
		   	});
                        createCartTable();
			request.done(function(msg) {
           		   alert(msg);
        		});

                   }
                   i++;
                }

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
	   var ccname = document.getElementById("name").value;
	   var exp = document.getElementById("exp").value;
	   var amount = totalsOutput;
	   var sent = "yes";

	   var request = $.ajax({
		type: "POST",
		url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
		data:
		{
		   vendor: vendor,
		   trans: trans,
		   cc: cc,
		   name: ccname,
		   exp: exp,
		   amount: amount,
		   sent: sent,
		   email: email,
		   customerName: name,
		   customerWeight: totalWeight
		},
		dataType: "html"
	});
	request.done(function(msg) {
	   alert(msg);
	});
	request.fail(function(jqXHR, textStatus) {
	   alert("Request failed: " + textStatus);
	});
	}
</script>

</html>
