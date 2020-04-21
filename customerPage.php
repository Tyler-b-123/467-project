<html>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
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
	<h1>I am connected to the databasee</h1>

	<table id="example" class="display" width="100%"></table>

	</body>

	<script type="text/javascript">

	var dataSet = [];
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
	</script>
</html>
