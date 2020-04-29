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

   </head>
 <style>

label {
  display: inline-block;
  text-align: right;
}​
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
  padding:7px;
  border:1px solid #ccc;
  box-shadow:0 0 15px 4px rgba(0,0,0,0.06);
margin: 0 auto; 
width:100px;
text-align: left;

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
table {
    margin-left:auto; 
    margin-right:auto;
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

	<center><h1>Warehouse Page</h1><center> 
        <table id="example" class="display" width="40%"></table>
	<div id="parent"></div><br>
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
#parent {
  font-family: "Trebuchet MS", Arial, Helvetica;
  border-collapse: collapse;
  width: 100%;
}

#parent td, #parent th {
  border: 1px solid #ddd;
  padding: 8px;
}

#parent tr:nth-child(even){background-color: #f2f2f2;}

#parent tr:hover {background-color: #ddd;}

#parent th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #000FFF;
  color: white;
}
#parent p {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  font-weight: 900;	
  color: black;
}

	</style>

   <script src="bar.js"></script>
   <script type="text/javascript">

	var dataSet = [];
	<?php $prepared2->execute(); ?>
	//stores the quantity table info in array dataSet
	<?php while($row = $prepared2->fetch() ): ?>

	   	dataSet.push([<?php echo ($row['number']); ?>, <?php echo ($row['qty']); ?>]);

    <?php endwhile; ?>

	createTable();

	//function that creates the table using jQuery library
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
	//stores info from the warehouse table into variables then pushes them into an array called temp
	<?php while($row2 = $prepared->fetch() ): ?>
		var name = "<?php echo ($row2['name']); ?>";
		var email = "<?php echo ($row2['email']); ?>";
		var number = <?php echo ($row2['number']); ?>;
		var qty = <?php echo ($row2['qty']); ?>;
		var address = "<?php echo ($row2['address']); ?>";

		temp.push([name, email, number, qty, address]);

	<?php endwhile; ?>

	var arrayLength = temp.length;
	var nameDisplay;
	var curentDiv;
	var temp2 = [];
	var content;

	//below loop is used to create the tables that will show the orders in seperate tables dynamically using jQuery .appentTo and .append
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
	//this function will be called if the worker accepts the order and will update the tables and generate a shipping label as
	//a txt file that will be downloaded upon clicking the accept order button
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

	//will be called if the worker declines the order and it will remove it from the tables
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
	//is used to have the worker download the shipping label jQuery
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
