<?php
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Register</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
    </head>
    <body>
        <h1>Register</h1>
      
        <div id="databaseInfo">
            <form action="finishRegister.php" action="POST">
                Name: <input type="text" name="name">  <br/>
                Username: <input type="text" name="login">  <br/>
                Password: <input type="password" name="password"> <br/>
                Retype Password: <input type="password" name="rePassword">
                <input type="submit">
            </form>
        </div>
    </body>
</html>
