<?php
define('APP_URL', 'http://localhost/uniblend/');
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.101.0">
    <title>UniBlend</title>


    <!-- <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/"> -->

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css
    " rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

      <style>
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .copyright {
            font-size: 14px;
        }
        .back-button {
            display: inline-block;
            background-color: #ccc;
            color: #333;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #ddd;
        }

        .green{
          background:green;
        }

      </style>
     
  </head>

<meta name="theme-color" content="#712cf9">

<nav class="navbar navbar-expand-lg bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">UniBlend</a>
    <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php
    session_start();
            // Check if user is logged in
            if (basename($_SERVER['PHP_SELF']) == 'index.php') {
              if(isset($_SESSION['username'])) {
                  echo '<form id="searchForm">
                      <input type="text" id="searchQuery" name="query" placeholder="Search ">
                      <button class="green" type="submit">Search</button>
                  </form>';
              }
          };?>
   
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php echo APP_URL; ?>index.php">Home</a>
          
        <!--</li>
        <li class="nav-item">
        <a class="nav-link " aria-current="page" href="users.php">Users </a>
        </li>
        <li class="nav-item">
        <a class="nav-link " aria-current="page" href="post.php">Post's </a>
        </li>-->
        <?php
            //session_start();
            // Check if user is logged in
            if(isset($_SESSION['username'])) {
        
              // If logged in, show username and logout link
              echo '</li>
        <li class="nav-item">
        <a class="nav-link " aria-current="page" href="' . APP_URL . 'user/users.php">Users </a>
        </li>';
        echo '</li>
        <li class="nav-item">
        <a style="color: red;" class="nav-link" aria-current="page" href="' . APP_URL . 'webrtc/create_meeting.php">MEET</a>
        </li>';


       echo' <li class="nav-item">
        <a class="nav-link " aria-current="page" href="' . APP_URL . 'post.php">Posts </a>
        </li>';
        
              echo '<li class="nav-item dropdown">';
              echo '<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
              echo $_SESSION['username']; // Display username from session
              echo '</a>';
              echo '<ul class="dropdown-menu">';
              echo '<li><a class="dropdown-item" href="' . APP_URL . 'user/logout.php">Logout</a></li>';
              echo '<li><a class="dropdown-item" href="' . APP_URL . 'user/set.php">Settings</a></li>'; 
              echo '<li><a class="dropdown-item" href="' . APP_URL . 'user/profile.php">Profiles</a></li>';  // Link to logout page
              echo '</ul>';
              echo '</li>';
          } else {
              // If not logged in, show login and register links
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="' . APP_URL . 'admin/login.php"><span style="color: green;">Admin Login</span> </a>'; // Link to login page
              echo '</li>';
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="' . APP_URL . 'login.php">Login</a>'; // Link to login page
              echo '</li>';
              echo '<li class="nav-item">';
              echo '<a class="nav-link" href="' . APP_URL . 'register.php">Register</a>'; // Link to register page
              echo '</li>';
             
          }
        ?>
       
      
      
    </div>
  </div>
</nav>

<div class="container marketing">