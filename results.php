<?php

    if (isset($_REQUEST["major"]) && isset($_REQUEST["year"]) &&  isset($_REQUEST["status"]) && isset($_REQUEST["work"]))
        {
        $major = $_REQUEST["major"];
        $year = $_REQUEST["year"];
        $status = $_REQUEST["status"];
        $work = $_REQUEST["work"];
        }
       
       $results = array("Computer Science\n" => 0,
           "Computer Engineering\n" => 0,
           "Computer Information Technology\n" => 0, 
           "Web Design and Development\n" => 0,
           "Other\n" => 0,
           "Freshmen\n" => 0,
           "Sophomore\n" => 0,
           "Junior\n" => 0,
           "Senior\n" => 0,
           "Super Senior\n" => 0,
           "Married\n" => 0,
           "Single\n" => 0, 
           "Dating\n" => 0, 
           "It is Complicated\n" => 0, 
           "Yes\n" => 0, 
           "No\n" => 0);
        $file = fopen("results.txt", "a+") or die("Unable to open file!");
        $txt = $major . "\n" . $year . "\n" . $status . "\n" . $work . "\n";
        fwrite($file, $txt);
        fclose($file);
        
        $file = fopen("results.txt", "a+") or die("Unable to open file!");
        $total = 0;
        while ($line = fgets($file))
        { 
            $total++;
            $results[$line]++;
        }
        $total = $total / 4;
        
        $hasSubmitted = "HasSubmitted";
        setcookie($hasSubmitted, rand(), time() + 10 * 60);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Form Results</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpsurvey.css">
    </head>
    <body>
        <h1> Results of the Survey:</h1>
        <div id='formResults'>
            <?php
                echo "<h2>Total Surveys Counted: " . $total . "</h2>";  
                echo "<h3>Majors:</h3>";     
                echo "<div><span class='percent'>" . (int)(($results["Computer Science\n"] / $total) * 100) . "%</span>  Computer Science: <span class='numbers'>" . $results["Computer Science\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Computer Engineering\n"] / $total) * 100) . "%</span>  Computer Engineering: <span class='numbers'>" . $results["Computer Engineering\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Computer Information Technology\n"] / $total) * 100) . "%</span>  Computer Information Technology: <span class='numbers'>" . $results["Computer Information Technology\n"] . "</span></div>"; 
                echo "<div><span class='percent'>" . (int)(($results["Web Design and Development\n"] / $total) * 100) . "%</span>  Web Design and Development: <span class='numbers'>" . $results["Web Design and Development\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Other Majors\n"] / $total) * 100) . "%</span>  Other Majors: <span class='numbers'>" . $results["Other\n"] . "</div>";

                echo "<h3>Year in School:</h3>"; 
                echo "<div><span class='percent'>" . (int)(($results["Freshmen\n"] / $total) * 100) . "%</span>  Freshmen: <span class='numbers'>" . $results["Freshmen\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Sophomore\n"] / $total) * 100) . "%</span>  Sophomore: <span class='numbers'>" . $results["Sophomore\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Junior\n"] / $total) * 100) . "%</span>  Junior: <span class='numbers'>" . $results["Junior\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Senior\n"] / $total) * 100) . "%</span>  Senior: <span class='numbers'>" . $results["Senior\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Super Senior\n"] / $total) * 100) . "%</span>  Super Senior: <span class='numbers'>" . $results["Super Senior\n"] . "</span></div>";

                echo "<h3>Relationship Status:</h3>"; 
                echo "<div><span class='percent'>" . (int)(($results["Married\n"] / $total) * 100) . "%</span>  Married: <span class='numbers'>" .$results["Married\n"] . "</span></div>";
                echo "<div><span class='percent'>" . (int)(($results["Single\n"] / $total) * 100) . "%</span>  Single: <span class='numbers'>" . $results["Single\n"] . "</span></div>"; 
                echo "<div><span class='percent'>" . (int)(($results["Dating\n"] / $total) * 100) . "%</span>  Dating: <span class='numbers'>" . $results["Dating\n"] . "</span></div>"; 
                echo "<div><span class='percent'>" . (int)(($results["It is Complicated\n"] / $total) * 100) . "%</span>  It is Complicated: <span class='numbers'>" . $results["It is Complicated\n"] . "</span></div>";

                echo "<h3>Working while going to school:</h3>"; 
                echo "<div><span class='percent'>" . (int)(($results["Yes\n"] / $total) * 100) . "%</span>  Yes: <span class='numbers'>" . $results["Yes\n"] . "</span></div>"; 
                echo "<div><span class='percent'>" . (int)(($results["No\n"] / $total) * 100) . "%</span>  No: <span class='numbers'>" . $results["No\n"] . "</span></div>";  
            ?>
        </div>
    </body>
</html>
