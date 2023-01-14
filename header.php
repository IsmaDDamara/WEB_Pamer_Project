<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-2">
      <div class="flex">
         <img src="images/Pp logo web.png" class="logo2">
         <a href="home.php" class="logo" style="font-family: 'Teko', sans-serif;" >Pamer P'Lerrr</a>

         <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="allproject.php">All Project</a>
            <a href="programmer.php">Programmer</a>
            <a href="contact.php">Contact</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
         </div>

         <div class="user-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
            <div>new <a href="login.php">login</a> | <a href="register.php">register</a></div>
         </div>
      </div>
   </div>

</header>