<?php
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
    </head>
    <body>
        <h1>Login</h1>
      
        <div id="databaseInfo">
            <form action="moviePHP.php" action="POST">
                Login: <input type="text" name="login">  <br/>
                Password: <input type="password">
                <input type="submit">
            </form>
        </div>
    </body>
</html>
