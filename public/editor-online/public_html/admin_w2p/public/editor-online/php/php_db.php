<?php
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "fancy_test";

// Create connection
$conn = new mysqli($serverName, $dBUsername, $dBPassword, $dBName);

$id_product = $_POST['id_product'];
$json  = $_POST['json'];

$sql = "INSERT INTO design (id,id_product, data_json)
VALUES ('',$id_product,'$json')";

if ($conn->query($sql) === TRUE) {
    echo "Berhasil disimpan";
} else {
    echo "gagal ngesave " . $sql . " " . $conn->error;
}

$conn->close();
