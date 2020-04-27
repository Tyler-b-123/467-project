<html>
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="bar.css">
   <head>
	<title>Warehouse Page</title>

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

                $prepared = $pdo->prepare("SELECT * FROM warehouse ORDER BY name DESC");

		$prepared2 = $pdo->prepare("SELECT * FROM quantity");

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

	<center><h1>Warehouse Page</h1><center> <table id="example" class="display" width="40%"></table>
	<div id="parent"></div>
	<br>
	<div id="permissionForm">
	   <form id="permission" action="#" method="POST"> </body>
	   <label id="customerNameLabel">Customer Name:</lable>
	   <input type="text" id="customerName" name="Customer Name"><br>
	   <label id="dateLabel">Date: (DD/MM/YYYY)</label>
	   <input type="text" id="date" name="Date"><br>
	   <input type="button" value="Accept Order" onclick="acceptOrder()">
	   <input type="button" value="Deny Order" onclick="deleteOrder()">
	   </form>
	</div>

	<style>
	   #parent table, #parent th, #parent tr{
		border: 1px solid black;
		border-collapse: collapse;
	   }
	   #parent th, #parent td{
		padding: 5px;
	   }
	</style>

   <script src="bar.js"></script>
   <script type="text/javascript">

	var dataSet = [];
	<?php $prepared2->execute(); ?>
	<?php while($row = $prepared2->fetch() ): ?>

	   dataSet.push([<?php echo ($row['number']); ?>, <?php echo ($row['qty']); ?>]);

        <?php endwhile; ?>
	console.log(dataSet);
	createTable();


	function createTable(){

                $(document).ready(function() {
                   $('#example').DataTable(  {
                        data: dataSet,
                        columns: [
                           { title: "Number" },
                           { title: "Qty" }
                        ]

                   } );
                } );
           }



	var temp = [];
	<?php $prepared->execute(); ?>
	<?php while($row2 = $prepared->fetch() ): ?>
	   var name = "<?php echo ($row2['name']); ?>";
	   var email = "<?php echo ($row2['email']); ?>";
	   var number = <?php echo ($row2['number']); ?>;
	   var qty = <?php echo ($row2['qty']); ?>;
	   var address = "<?php echo ($row2['address']); ?>";

	   temp.push([name, email, number, qty, address]);

	<?php endwhile; ?>
	   console.log(temp);

	var arrayLength = temp.length;
	console.log(arrayLength);

	var nameDisplay;
	var curentDiv;
	var temp2 = [];
	var content;

	for(var i = 0; i < arrayLength; i++){
	   if (i === 0){

		$('<p>' + temp[i][0] + '</p>').appendTo('#parent');

		content = "<table>";

		content += '<tr><th>' + 'Number' + '</th><th>' + 'QTY' + '</th></tr>';

		for(var c = 0; c < 1; c++){
		   content += '<tr><td>' + temp[i][2] + '</td><td>' + temp[i][3] + '</td></tr>';
		}

		if (i !== arrayLength - 1){
                   if (temp[i][0] !== temp[i+1][0]){
                        content += "</table>";
                        $("#parent").append(content);
                   }
                }
                if (i === arrayLength - 1){
                   content += "</table>";
                   $("#parent").append(content);
                }

	   }
	   if (i !== 0 && temp[i][0] === temp[i-1][0]){
		for(var c = 0; c < 1; c++){
                   content += '<tr><td>' + temp[i][2] + '</td><td>' + temp[i][3] + '</td></tr>';
                }
		if (i !== arrayLength - 1){
		   if (temp[i][0] !== temp[i+1][0]){
			content += "</table>";
                   	$("#parent").append(content);
		   }
		}
                if (i === arrayLength - 1){
                   content += "</table>";
                   $("#parent").append(content);
                }
	   }
	   else{

		if (i === 0){
		}
		else{

		$('<p>' + temp[i][0] + '</p>').appendTo('#parent');

		content = "<table>";
		content += '<tr><th>' + 'Number' + '</th><th>' + 'QTY' + '</th></tr>';

                for(var c = 0; c < 1; c++){
                   content += '<tr><td>' + temp[i][2] + '</td><td>' + temp[i][3] + '</td></tr>';
                }
		if (i !== arrayLength - 1){
                   if (temp[i][0] !== temp[i+1][0]){
                        content += "</table>";
                        $("#parent").append(content);
                   }
                }
                if (i === arrayLength - 1){
                   content += "</table>";
                   $("#parent").append(content);
                }
	   }
	   }

	}
	function acceptOrder(){
	   var acceptName = document.getElementById("customerName").value;
	   var acceptDate = document.getElementById("date").value;

	   console.log(acceptName);
	   console.log(acceptDate);

	   var request = $.ajax({
		type: "POST",
		url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
		data:
		{
		   acceptName: acceptName,
		   acceptDate: acceptDate
		},
		dataType: "html"
	   });
	   request.done(function(msg){
		alert(msg);
	   });

	   var acceptAddress;

	   for(var it = 0; it < temp.length; it++){
		if(acceptName === temp[it][0]){
		   acceptAddress = temp[it][4];

		   var request1 = $.ajax({
        	        type: "POST",
                	url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
                	data:
                	{
				removeNumber: temp[it][2],
				removeQty: temp[it][3]
                	},
               		dataType: "html"
	           	});


	        }
	   }

	   var message = "Shipping label\nName: ";
	   message += acceptName + '\nAddress:';
	   message += acceptAddress + '\nDate Shipped:';
	   message += acceptDate;

	   var fileName = acceptName + 'Label' + '.txt';

	   download(fileName, message);
	   setTimeout(function() {
		document.location.reload(true);
	   }, 1000);
	}

	function deleteOrder(){
	   var deleteName = document.getElementById("customerName").value;

	   var request = $.ajax({
		type: "POST",
		url: "http://students.cs.niu.edu/~z1782665/467group/sendToMe.php",
		data:
		{
		   deleteName: deleteName
		},
		dataType: "html"
	   });
	   request.done(function(msg){
		console.log(msg);
	   });

	   setTimeout(function() {
                document.location.reload(true);
           }, 1000);

	}


	function download(filename, text){
	   var element = document.createElement('a');
    	   element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    	   element.setAttribute('download', filename);

    	   element.style.display = 'none';
    	   document.body.appendChild(element);

    	   element.click();

    	   document.body.removeChild(element);
	}

   </script>


</html>
