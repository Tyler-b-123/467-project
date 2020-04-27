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

	try{
        	$dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
        	$pdo2 = new PDO($dsn2, $username2, $password2);
        	$dsn = "mysql:host=courses;dbname=test";
        	$pdo = new PDO($dsn, $username, $password);
	}
	catch(PDOexception $e){
        	echo "Connection to the database failed: " . $e->getMessagee();
	}

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$prepared = $pdo->prepare("SELECT * FROM shipping");
	$prepared->execute();

	$prepared2 = $pdo->prepare("SELECT * FROM admin");
	$prepared2->execute();

    ?>
   </head>
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
		<label>Adjust shipping table</label><br>
		<label>Row:</label>
		<input type="text" id="adjustRow"><br>
		<label>New Min:</label>
		<input type="text" id="min">
		<label>New Max:</label>
		<input type="text" id="max"><br>
		<label>New Price:</label>
		<input type="text" id="price"><br>
		<input type="button" value="Submit" id="minMaxButton" onclick="adjustTable()">
	   </form>
	</div>

   </body>

   <script src="bar.js"></script>
   <script type="text/javascript">

   var temp = [];
   var dataSet = [];

   <?php while($row2 = $prepared2->fetch() ): ?>

	dataSet.push(["<?php echo ($row2['name']); ?>", "<?php echo ($row2['weight']); ?>", "<?php echo ($row2['shipDate']); ?>",
		"<?php echo ($row2['status']); ?>", "$<?php echo ($row2['price']); ?>" ]);

   <?php endwhile; ?>

   <?php while($row = $prepared->fetch() ): ?>

	temp.push([<?php echo ($row['placment']); ?>, <?php echo ($row['first']); ?>,
		<?php echo ($row['second']); ?>, <?php echo ($row['price']); ?> ]);

   <?php endwhile; ?>

   console.log(temp);
   createTable();
   buildTable();

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



   function adjustTable(){

	var adjustRow = document.getElementById("adjustRow").value;
	var min = document.getElementById("min").value;
	var max = document.getElementById("max").value;
	var price = document.getElementById("price").value;

	min = parseInt(min, 10);
        max = parseInt(max, 10);
	price = parseFloat(price);

	temp[adjustRow - 1][3] = price;

	temp[adjustRow - 1][1] = min;
	temp[adjustRow - 1][2] = max;

	console.log(min,max);

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

	buildTable();
   }

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
