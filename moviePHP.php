<?php
session_start();

if (isset($_SESSION['movies']))
{
    header("Location: suggestedMovies.php");
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>PHP Movie Project</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
       
    </head>
    <body>
        <h1>PHP Movie Project</h1>
        <div id="navInfo">
            <nav>
                <a href="moviePHP.php">Like Movies</a>
                <a href="allMovies.php">All Movies</a>
                <a href="likedMovies.php">Your Liked Movies</a>
                <a href="suggestedMovies.php">Your Suggested Movies</a>
            </nav>
        </div>
        
        <form action="suggestedMovies.php" action="POST">
            <h3>Which Movies do you Like? (Select to received suggestions of other films you might like): </h3>
            
            <input type="checkbox" name='movie1' id='movie1' value='Star Wars: A New Hope'> Star Wars: A New Hope</br>
            <input type="checkbox" name='movie2' id='movie2' value='Indiana Jones and the Raiders of the Lost Ark'> Indiana Jones and the Raiders of the Lost Ark</br>
            <input type="checkbox" name='movie3' id='movie3' value='Iron Man'> Iron Man</br>
            <input type="checkbox" name='movie4' id='movie4' value='Thor'> Thor</br>
            <input type="checkbox" name='movie5' id='movie5' value='Captain America: the First Avenger'> Captain America: the First Avenger</br>
            <input type="checkbox" name='movie6' id='movie6' value='Back To the Future'> Back To the Future</br>
            
            <input type="submit">
        </form>
    </body>
</html>
