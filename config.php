<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pamer_plerr";

$koneksi = mysqli_connect($hostname,$username,$password,$database);

if ($koneksi){
    // echo "database terhubung";
}
else {
    echo "database gagal terhubung";
}

function ambil_data($koneksi, $query) {
    $product = mysqli_query($koneksi, $query) or die('query failed');
    $hasil = array();
    while($fetchData = $product->fetch_assoc()){
      $hasil[] = $fetchData;
    }
    return $fetchData;
}
?>