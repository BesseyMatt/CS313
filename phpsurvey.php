<?php

$hasSubmitted = "HasSubmitted";

if(isset($_SESSION['user']) | isset($_COOKIE[$hasSubmitted]))
{
    header("Location: results.php");
}

session_start('user');
$_SESSION['user'] = rand();

?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>PHP Survey Assignment</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpsurvey.css">
           
        <script>
         function seeResults() {
             window.location.href = 'results.php';
         }
        </script>
            
        
    </head>
    <body>
        
        
        <h1>PHP survey</h1>
        <?php
        $count = 2;
                setcookie($hasSubmitted, $count, time() + 10 * 60);
        ?>
        
        <form action="results.php" action="POST">
            <h3>What is your Major?</h3>
            <input type="radio" name='major' id='major' value='Computer Science' required> Computer Science</br>
            <input type="radio" name='major' id='major' value='Computer Engineering' required> Computer Engineering</br>
            <input type="radio" name='major' id='major' value='Computer Information Technology' required> Computer Information Technology</br>
            <input type="radio" name='major' id='major' value='Web Design and Development' required> Web Design and Development</br> 
            <input type="radio" name='major' id='major' value='Other'> Other</br></br>
            
            <h3>What Year of School are you in?</h3>
            <input type="radio" name='year' id='year' value='Freshmen' required> Freshmen</br>
            <input type="radio" name='year' id='year' value='Sophomore' required> Sophomore</br>
            <input type="radio" name='year' id='year' value='Junior' required> Junior</br>
            <input type="radio" name='year' id='year' value='Senior' required> Senior</br>
            <input type="radio" name='year' id='year' value='Super Senior' required> Super Senior</br></br>
            
            <h3>Relationship status?</h3>
            <input type="radio" name='status' id='staus' value='Married' required> Married</br>
            <input type="radio" name='status' id='staus' value='Single' required> Single</br>
            <input type="radio" name='status' id='staus' value='Dating' required> Dating</br>
            <input type="radio" name='status' id='staus' value='It is Complicated' required> It's Complicated</br></br>
            
            <h3>Are you working while going to school?</h3>
            <input type="radio" name='work' id='work' value='Yes' required> Yes</br>
            <input type="radio" name='work' id='work' value='No' required> No</br></br>
            
            <input type="submit">
            <button onclick='seeResults()'>See Results</button>
        </form>
        
    </body>
</html>
