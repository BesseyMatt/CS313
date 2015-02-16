<?php
        $major = $_POST["major"];
        $year = $_POST["year"];
        $status = $_POST["status"];
        $work = $_POST["work"];
        
        $hasSubmitted = "HasSubmitted";
        $count = 2;
        setcookie($hasSubmitted, $count, time() + 10 * 60);
       // header( 'Location: http://localhost/results.php' );
?>
