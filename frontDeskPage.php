<html>
   <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
   <link rel="stylesheet" href="bar.css">
   <head>
	<title>Front Desk Page</title>

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
   </body>

   <script src="bar.js"></script>

</html>
