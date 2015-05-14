<?php
    // require a config.php file in the model folder
    // have access to the variables int the config.php file
    require_once(__DIR__ . "/../model/config.php");
    // require_once(__DIR__ . "/../controller/login-verify.php");

    // if (!authenticateUser()) {
    //     header("Location: " . $path . "index.php");
    //     die();
    // }
?>
<div class="center" id="top">
  <h1>My todo list 2.0!</h1>
</div>
<nav>
    <ul class="nav nav-pills center">
        <!-- create a link that point to the post file -->
         <!-- <li><a href="<?php  ?>">Blog Post Form</a></li> -->
         <li role="presentation" class="active"><a href="<?php echo $path. "login.php" ?>">Login</a></li>
         <li role="presentation" class="active"><a href="<?php echo $path. "register.php" ?>">Register</a></li>
    </ul>
</nav>