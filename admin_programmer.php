<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($koneksi, $_POST['name']);
   $jurusan = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
   $prodi = mysqli_real_escape_string($koneksi, $_POST['prodi']);
   $kelas = mysqli_real_escape_string($koneksi, $_POST['kelas']);
   $keahlian = mysqli_real_escape_string($koneksi, $_POST['keahlian']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_programmer_name = mysqli_query($koneksi, "SELECT name FROM `programmer` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_programmer_name) > 0){
      $message[] = 'programmer name already added';
   }else{
      $add_programmer_query = mysqli_query($koneksi, "INSERT INTO `programmer`(name, jurusan, prodi, kelas, keahlian, image) VALUES('$name', '$jurusan', '$prodi', '$kelas', '$keahlian', '$image')") or die('query failed');

      if($add_programmer_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($koneksi, "SELECT image FROM `programmer` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($koneksi, "DELETE FROM `programmer` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_programmer.php');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_jurusan = $_POST['update_jurusan'];
   $update_prodi = $_POST['update_prodi'];
   $update_kelas = $_POST['update_kelas'];
   $update_keahlian = $_POST['update_keahlian'];


   mysqli_query($koneksi, "UPDATE `programmer` SET name = '$update_name', jurusan = '$update_jurusan', prodi = '$update_prodi', kelas = '$update_kelas', keahlian = '$update_keahlian' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($koneksi, "UPDATE `programmer` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

   header('location:admin_programmer.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->

<section class="add-products">

   <h1 class="title">Daftar Programmer</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add programmer</h3>
      <input type="text" name="name" class="box" placeholder="masukan name" required>
      <input type="text" name="jurusan" class="box" placeholder="masukkan jurusan" required>
      <input type="text" name="prodi" class="box" placeholder="masukkan prodi" required>
      <input type="text" name="kelas" class="box" placeholder="masukkan kelas" required>
      <input type="text" name="keahlian" class="box" placeholder="masukkan keahlian" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add programmer" name="add_product" class="btn">
   </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

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
         <a href="admin_programmer.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="admin_programmer.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($koneksi, "SELECT * FROM `programmer` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="input" required placeholder="masukkan nama">
      <input type="text" name="update_jurusan" value="<?php echo $fetch_update['jurusan']; ?>" class="input" required placeholder="masukkan jurusan">
      <input type="text" name="update_prodi" value="<?php echo $fetch_update['prodi']; ?>" class="input" required placeholder="masukkan prodi">
      <input type="text" name="update_kelas" value="<?php echo $fetch_update['kelas']; ?>" class="input" required placeholder="masukkan kelas">
      <input type="text" name="update_keahlian" value="<?php echo $fetch_update['keahlian']; ?>" class="input" required placeholder="masukkan keahlian">
      <input type="file" class="input" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close-update" class="option-btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>



<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>