<html>
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="bar.css">
   <head>
	<title>Admin Page</title>
    <?php
	$username = "z1782665";
	$password = "1996Oct06";
	$username2 = "student";
	$password2 = "student";

	//try connecting to the databases
	try{
        	$dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        	$pdo2 = new PDO($dsn2, $username2, $password2);
        	$dsn = "mysql:host=courses;dbname=test";
        	$pdo = new PDO($dsn, $username, $password);
	}
	//error msg
	catch(PDOexception $e){
        	echo "Connection to the database failed: " . $e->getMessagee();
	}

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	//preparing statment to get all data from shipping table from test database
	$prepared = $pdo->prepare("SELECT * FROM shipping");
	$prepared->execute();

	//preparing statment to get all data from admin table from test database
	$prepared2 = $pdo->prepare("SELECT * FROM admin");
	$prepared2->execute();

    ?>
   </head>
   <style>
label{
  display: inline-block;
  float: left;
  width : 7%;    
}
div {
  background-color: AliceBlue;
}
body {
  background-color: WhiteSmoke;
}
h1 {

  text-align: center;
  text-transform: uppercase;
  color: #000000;
  
}
input[type=text] {
  padding:10px;
 
  border:1px solid #ccc;
  box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
margin: 0 auto; 
width:150px;
text-align: center;

}

input[type=button] {
  background-color: #1E90FF;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=button]:hover {
  background-color: #00BFFF;
}
   </style>
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
	<center><h1>Current Orders</h1></center>
		<table id="example" class="display" width="100%"></table>
	<div id="shipping"></div>
	<div id="adjustForm">
	    <form id="adjust" action="#" method="POST"
			<label><b>Adjust shipping table</b></label><br>
			<label>Row:</label>
			<input type="text" id="adjustRow"><br>
			<label>New Min:</label>
			<input type="text" id="min"><br>
			<label>New Max:</label>
			<input type="text" id="max"><br>
			<label>New Price:</label>
			<input type="text" id="price"><br><br>
			<input type="button" value="Submit" id="minMaxButton" onclick="adjustTable()">
	    </form>
	</div>

   </body>

   <script src="bar.js"></script>
   <script type="text/javascript">
   //creating arrays to hold data
   	var temp = [];
   	var dataSet = [];

	//statment to store data from admin table into dataSet array
   	<?php while($row2 = $prepared2->fetch() ): ?>

		dataSet.push(["<?php echo ($row2['name']); ?>", "<?php echo ($row2['weight']); ?>", "<?php echo ($row2['shipDate']); ?>",
		"<?php echo ($row2['status']); ?>", "$<?php echo ($row2['price']); ?>" ]);

   	<?php endwhile; ?>

	//statment to store data from shipping table into temp array
   	<?php while($row = $prepared->fetch() ): ?>

		temp.push([<?php echo ($row['placment']); ?>, <?php echo ($row['first']); ?>,
		<?php echo ($row['second']); ?>, <?php echo ($row['price']); ?> ]);

   	<?php endwhile; ?>

	//calling functions to build the 2 tables
   	createTable();
   	buildTable();

	//uses dataSet to display all of the orders that are in the warehouse or have been shipped
	function createTable(){

        $(document).ready(function() {
            $('#example').DataTable(  {
                data: dataSet,
                columns: [
                    { title: "Name" },
                    { title: "Weight" },
                    { title: "Date Shipped" },
                    { title: "Status" },
                    { title: "Price" }
                ]

            } );
        } );
   	}


	//function used to adjust the shipping table by changing the table aswell as using jQuery to change the values on the page dynamically
   	function adjustTable(){

		//pulling data from the html for to gather data for row adjustments
		var adjustRow = document.getElementById("adjustRow").value;
		var min = document.getElementById("min").value;
		var max = document.getElementById("max").value;
		var price = document.getElementById("price").value;

		//converting to real numbers not strings
		min = parseInt(min, 10);
        max = parseInt(max, 10);
		price = parseFloat(price);

		temp[adjustRow - 1][3] = price;

		temp[adjustRow - 1][1] = min;
		temp[adjustRow - 1][2] = max;

		if(adjustRow == 1){
		   temp[adjustRow][1] = max + 1;
		}
		if(adjustRow == 2){
		   temp[adjustRow - 2][2] = min - 1;
		   temp[adjustRow][1] = max + 1;
		}
		if(adjustRow == 3){
		   temp[adjustRow - 2][2] = min - 1;
		   temp[adjustRow][1] = max + 1;
		}
		if(adjustRow == 4){
		   temp[adjustRow - 2][2] = min -1;
		}

		$("#shippingTable").remove();

	//using ajax to send to send a request to the sendToMe.php page to post the data needed to updatee the shipping table
	var request = $.ajax({
	   type: "POST",
	   url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
	   data:
	   {
			shippingPlacment0: temp[0][0],
			shippingFirst0: temp[0][1],
			shippingSecond0: temp[0][2],
			shippingPrice0: temp[0][3],
			shippingPlacment1: temp[1][0],
            shippingFirst1: temp[1][1],
            shippingSecond1: temp[1][2],
            shippingPrice1: temp[1][3],
			shippingPlacment2: temp[2][0],
            shippingFirst2: temp[2][1],
            shippingSecond2: temp[2][2],
            shippingPrice2: temp[2][3],
			shippingPlacment3: temp[3][0],
            shippingFirst3: temp[3][1],
            shippingSecond3: temp[3][2],
            shippingPrice3: temp[3][3]
	   },
	   dataType: "html"
	});

	//rebuild the shipping table using the new values
	buildTable();
	}
	//this function will build the shipping table and use jQuery to dynamically create a div that will then become the html table
   	function buildTable(){

   		$("#shipping").append('<div id = "shippingTable"></div>');

   		var content = "<table>";
   		content += '<tr><th>' + 'Weight lb' + '</th><th>' + 'Price' + '</th></tr>';

   		for(var i = 0; i < temp.length; i++){
	   		if( i + 1 === temp.length){
			content += '<tr><td>' + temp[i][1] + ' - ' + temp[i][2] + '</td><td>' + '$' + temp[i][3] + '</td></tr>';
			content+= "</table>"
			$("#shippingTable").append(content);
	   	}
	   	else{
			content += '<tr><td>' + temp[i][1] + ' - ' + temp[i][2] + '</td><td>' + '$' + temp[i][3] + '</td></tr>';
	   	}
   }
}
   </script>

</html>
