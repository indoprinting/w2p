<?php
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "fancy_test";

// Create connection
$conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

$id_product = $_GET['id_product'];

$sql = "SELECT * FROM design WHERE id_product='$id_product'";
$result = $conn->query($sql);
$design = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        array_push($design, json_decode($row['data_json'], true));
    }
    echo json_encode($design);
} else {
    echo $sql . " ||| ID " . $id_product . " " . $conn->error;
}

$conn->close();
