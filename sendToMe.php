<?php

$username = "z1782665";
$password = "1996Oct06";

try{
	$dsn = "mysql:host=courses;dbname=test";
	$pdo = new PDO($dsn, $username, $password);
}
catch(PDOexception $e){
	echo "Connection to the database failed: " . $e->getMessagee();
}

$insert = "INSERT INTO warehouse (name, email, number, qty, address) VALUES (?,?,?,?,?)";
$stmt = $pdo->prepare($insert);

//this will update the quantity table when a purchase is made subtracts total bought
if (isset($_POST['removeNumber'])){

   $removeNumber = $_POST['removeNumber'];
   $removeQty = $_POST['removeQty'];

   $temp = $pdo->prepare("SELECT qty FROM quantity WHERE number=?");
   $temp->execute([$removeNumber]);

   $newQtyO = $temp->fetch();
   $newQty = $newQtyO['qty'];

   $newQty = $newQty - $removeQty;

   $updateQty = $pdo->prepare("UPDATE quantity SET qty=? WHERE number=?");
   $updateQty->execute([$newQty, $removeNumber]);
}

//this will delete an order from the warehousee and admin if the order cannot be fufilled
if (isset($_POST['deleteName'])){
   $deleteName = $_POST['deleteName'];

   $deleteRow = $pdo->prepare("DELETE FROM warehouse WHERE name=?");
   $deleteRow->execute([$deleteName]);

   $deleteRowAdmin = $pdo->prepare("DELETE FROM admin WHERE name=?");
   $deleteRowAdmin->execute([$deleteName]);

   echo "deleted";

}

//this will update the admin table with a status of shipped and delete the order from the warehouse table
if (isset($_POST['acceptName'])){
   $acceptName = $_POST['acceptName'];
   $acceptDate = $_POST['acceptDate'];
   $insertRow1 = $pdo->prepare("UPDATE admin SET status=?, shipDate=? WHERE name=?");
   $insertRow1->execute(["Shipped", $acceptDate, $acceptName]);

   $deleteRow1 = $pdo->prepare("DELETE FROM warehouse WHERE name=?");
   $deleteRow1->execute([$acceptName]);
}

//this will update the shipping table based on what an admin changes
if (isset($_POST['shippingPlacment0'])){

   $shippingStatment = "UPDATE shipping SET first=?, second=?, price=? WHERE placment=?";
   $shippingUpdate = $pdo->prepare($shippingStatment);

   $shippingPlacment0 = $_POST['shippingPlacment0'];
   $shippingFirst0 = $_POST['shippingFirst0'];
   $shippingSecond0 = $_POST['shippingSecond0'];
   $shippingPrice0 = $_POST['shippingPrice0'];

   $shippingUpdate->execute([$shippingFirst0, $shippingSecond0, $shippingPrice0, $shippingPlacment0]);

   $shippingPlacment1 = $_POST['shippingPlacment1'];
   $shippingFirst1 = $_POST['shippingFirst1'];
   $shippingSecond1 = $_POST['shippingSecond1'];
   $shippingPrice1 = $_POST['shippingPrice1'];

   $shippingUpdate->execute([$shippingFirst1, $shippingSecond1, $shippingPrice1, $shippingPlacment1]);

   $shippingPlacment2 = $_POST['shippingPlacment2'];
   $shippingFirst2 = $_POST['shippingFirst2'];
   $shippingSecond2 = $_POST['shippingSecond2'];
   $shippingPrice2 = $_POST['shippingPrice2'];

   $shippingUpdate->execute([$shippingFirst2, $shippingSecond2, $shippingPrice2, $shippingPlacment2]);

   $shippingPlacment3 = $_POST['shippingPlacment3'];
   $shippingFirst3 = $_POST['shippingFirst3'];
   $shippingSecond3 = $_POST['shippingSecond3'];
   $shippingPrice3 = $_POST['shippingPrice3'];

   $shippingUpdate->execute([$shippingFirst3, $shippingSecond3, $shippingPrice3, $shippingPlacment3]);

}

//adds order to the warehouse
if (isset($_POST['name'])){
   $name = $_POST['name'];
}
if (isset($_POST['number'])){
   $number = $_POST['number'];
}
if (isset($_POST['qty'])){
   $qty = $_POST['qty'];
   $email = $_POST['email'];
   $address = $_POST['address'];

   echo "hi";

   $stmt->execute([$name, $email, $number, $qty, $address]);
}

//sends payment through credit card server
if (isset($_POST['amount'])){
   $amount = $_POST['amount'];
}
if (isset($_POST['vendor'])){
   $vendor = $_POST['vendor'];
}
if (isset($_POST['trans'])){
   $trans = $_POST['trans'];
}
if (isset($_POST['cc'])){
   $cc = $_POST['cc'];
}
if (isset($_POST['name'])){
   $name = $_POST['name'];
}
if (isset($_POST['exp'])){
   $exp = $_POST['exp'];
   $email = $_POST['email'];


   $url = 'http://blitz.cs.niu.edu/CreditCard/';
   $data = array(
   'vendor' => $vendor,
   'trans' => $trans,
   'cc' => $cc,
   'name' => $name,
   'exp' => $exp,
   'amount' => $amount);
   $options = array(
   'http' => array(
   'header' => array('Content-type:application/json','Accept: application/json'),
   'method' => 'POST',
   'content' => json_encode($data)
    )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

   echo($result);

}

//adds an order to the admin table when the payment is ran
if (isset($_POST['customerName'])){
   $customerName = $_POST['customerName'];
   $customerWeight = $_POST['customerWeight'];
   $customerAmount = $_POST['amount'];

   $insertIntoAdmin = $pdo->prepare("INSERT INTO admin (name, weight, shipDate, status, price) VALUES (?,?,?,?,?)");
   $insertIntoAdmin->execute([$customerName, $customerWeight, "N/A", "IN WAREHOUSE", $customerAmount]);

}

//allows the front desk to update the quantity of the quantity table
if (isset($_POST['updateNumber'])){
   $updateNumber = $_POST['updateNumber'];
}
if (isset($_POST['updateQty'])){

   $updateQty = $_POST['updateQty'];

   $oldQty = $pdo->prepare("SELECT * FROM quantity where number = :number");
   $oldQty->bindParam(':number', $updateNumber);
   $oldQty->execute();

   $newQtyRow = $oldQty->fetch();
   $newQty = $newQtyRow['qty'];

   $newQty += $updateQty;

   $updateDB = $pdo->prepare("UPDATE quantity SET qty =? WHERE  number =?");
   $updateDB->execute([$newQty, $updateNumber]);

   echo "New quantity: ";
   echo $newQty;
   echo " for part: ";
   echo $updateNumber;

}

?>
