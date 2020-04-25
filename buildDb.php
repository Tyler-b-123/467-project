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

$prepared = $pdo2->prepare("SELECT * FROM parts");
$prepared->execute();

$insert = "INSERT INTO quantity (number, qty) VALUES (?,?)";
$stmt = $pdo->prepare($insert);

while($row = $prepared->fetch()){
$stmt->execute([$row['number'], mt_rand(1,20)]);
}

echo "populated database";





?>
