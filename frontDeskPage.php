<html>
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="bar.css">
   <head>
	<title>Front Desk Page</title>

	<?php
                $username = "z1782665";
                $password = "1996Oct06";

                try{
                        $dsn = "mysql:host=courses;dbname=test";
                        $pdo = new PDO($dsn, $username, $password);
                }
                catch(PDOexception $e){
                        echo "Connection to the database failed: " . $e->getMessage();
                }

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

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

	<center><h1>Front Desk Page</h1><center>
	<div="updateFormDiv">
	   <p>Update items qty based on whats available</p>
	   <form id="updateForm" action="#" method="POST">
		<label id="numberLabel">Part Number:</label>
		<input type="text" id="updateNumber"><br>
		<label id="qtyLabel">Amount recieved:</label>
		<input type="text" id="updateQty"><br>
		<input type="button" value="Update Database" onclick="updateDatabase()">
	   </form>
	</div>
   </body>
   <script src="bar.js"></script>

   <script type="text/javascript">

	function updateDatabase(){
	   var updateNumber = document.getElementById("updateNumber").value;
	   var updateQty = document.getElementById("updateQty").value;

	   var request = $.ajax({
		type: "POST",
		url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
		data:
		{
		   updateNumber: updateNumber,
		   updateQty: updateQty
		},
		dataType: "html"
	   });
	   request.done(function(msg) {
		alert(msg);
	   });

	}

   </script>

</html>
