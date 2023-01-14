<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>Daftar Programmer</h3>
   <p> <a href="home.php">home</a> / Programmers </p>
</div>

<section class="reviews">

<div class="box-container">

<?php
   $select_products = mysqli_query($koneksi, "SELECT * FROM `programmer`") or die('query failed');
   if(mysqli_num_rows($select_products) > 0){
      while($fetch_products = mysqli_fetch_assoc($select_products)){
?>
<div class="box">
   <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
   <div class="name" name="name"><?php echo strtoupper($fetch_products['name']); ?></div>
   <div class="input" name="jurusan">Jurusan : <?php echo $fetch_products['jurusan']; ?></div> 
   <div class="input" name="prodi">Prodi  : <?php echo $fetch_products['prodi']; ?></div> 
   <div class="input" name="kelas">Kelas  : <?php echo $fetch_products['kelas']; ?></div> 
   <div class="input" name="keahlian">Keahlian : <?php echo $fetch_products['keahlian']; ?></div>
</div>
<?php
   }
}else{
   echo '<p class="empty">no products added yet!</p>';
}
?>
</div>

</section>
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>