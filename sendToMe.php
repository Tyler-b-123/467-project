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

$insert = "INSERT INTO warehouse (name, email, number, qty) VALUES (?,?,?,?)";
$stmt = $pdo->prepare($insert);


if (isset($_POST['name'])){
   $name = $_POST['name'];
}
if (isset($_POST['number'])){
   $number = $_POST['number'];
}
if (isset($_POST['qty'])){
   $qty = $_POST['qty'];
   $email = $_POST['email'];

   echo "hi";

   $stmt->execute([$name, $email, $number, $qty]);
}


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
