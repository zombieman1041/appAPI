<?php
    // require the config file to get to the $path variable
    require_once(__DIR__ . "/../model/config.php");
    require_once(__DIR__ . "/../controller/login-verify.php");

    if (!authenticateUser()) {
        header("Location: " . $path . "index.php");
        die();
    }
?>

<h1>Create Blog Post</h1>

<!-- form takes in information and send it to the table -->
<form method="post" action="<?php echo $path . "controller/create-post.php"; ?>">
    <div>
        <!-- label display in front of the text box -->
        <label for="title">Title: </label>
        <!-- input box occupied only on one line -->
        <input type="text" name="title" />
    </div>
    
    <div>
        <!-- another box label post -->
        <label for="post">Post: </label>
        
        <!-- text area allows to type a lot a text and span many lines   -->
        <!-- text area can show on multiple lines and can be expanded -->
        <textarea name="post"></textarea>
    </div>
        
    <div>
        <!-- create a button called submit -->
        <button type="submit">Submit</button>
    </div>
</form>