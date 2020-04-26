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

                $prepared = $pdo->prepare("SELECT * FROM warehouse");

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

	<center><h1>Warehouse Page</h1><center>
	<table id="example" class="display" width="40%"></table>
	<div id ="parent"></div>
   </body>

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

	   temp.push([name, email, number, qty]);

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

   </script>


</html>
