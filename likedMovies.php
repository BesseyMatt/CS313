<?php
session_start();

 if(isset($_SESSION['movies']))
 {
    $movies = $_SESSION['movies'];
 
    $sqlRequest = " WHERE name LIKE ";
    for ($i = 0; $i < sizeof($movies); $i++)
    {
        if ($i == 0)
        {
            $sqlRequest = $sqlRequest . "\"" . $movies[$i] . "\"";
        }
        
        else
        {
            $sqlRequest = $sqlRequest . " OR  name LIKE" . "\"" . $movies[$i] . "\"";
        }
    }
 }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Liked Movies</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
    </head>
    <body>
        <h1>Liked Movies</h1>
        <div id="navInfo">
            <nav>
                <a href="moviePHP.php">Like Movies</a>
                <a href="likedMovies.php">Your Liked Movies</a>
                <a href="suggestedMovies.php">Your Suggested Movies</a>
                <?php
                    echo "<span> Login: " . $_SESSION['login'] . "</span>";
                    echo "<span><a href='logout.php'>Logout</a></span>"
                ?>
            </nav>
        </div>
        <div id="databaseInfo">
            <?php
            function loadDatabase()
            {
              $dbHost = "http://php-besseym.rhcloud.com";//"localhost";
              $dbPort = "3306";
              $dbUser = "besseym";
              $dbPassword = "password.";

              $dbName = "PHP_Movie_Project";

                 $openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

                 if ($openShiftVar === null || $openShiftVar == "")
                 {
                      // Not in the openshift environment
                      //echo "Using local credentials: "; 
                      //require("setLocalDatabaseCredentials.php");
                 }
                 else 
                 { 
                      // In the openshift environment
                      //echo "Using openshift credentials: ";

                      $dbHost = getenv('OPENSHIFT_MYSQL_DB_HOST');
                      $dbPort = getenv('OPENSHIFT_MYSQL_DB_PORT'); 
                      $dbUser = getenv('OPENSHIFT_MYSQL_DB_USERNAME');
                      $dbPassword = getenv('OPENSHIFT_MYSQL_DB_PASSWORD');
                 } 
                 //echo "host:$dbHost:$dbPort dbName:$dbName user:$dbUser password:$dbPassword<br >\n";

                 $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

                 return $db;
            }

            try{
            if(isset($_SESSION['movies']))
            {
                $db = loadDatabase();

                $login = $_SESSION['login'];
                
                $statement1 = $db->query("SELECT userId FROM user WHERE username=\"" . $login . "\"");
                $loginId = $statement1->fetchAll(PDO::FETCH_ASSOC);
                //$statement = $db->query("SELECT * FROM movie " . $sqlRequest);
                foreach ($loginId as $lId)
                {
                    $statement = $db->query("SELECT DISTINCT * FROM movie as m JOIN likedMovie as lm on m.movieId = lm.movieId WHERE lm.userId =" . $lId['userId']);
                    $results = $statement->fetchAll(PDO::FETCH_ASSOC);
                }

                echo "<table>";

                foreach ($results as $movie)
                {
                    echo "<tr><td><img class=poster src=\"moviePosters/" . $movie['movieId'] . ".jpg" . "\" alt=\"works\"> </td>";
                    echo "<td class=tableTxt><div class=movieDetails>" .
                            "<div><b>" . $movie['name'] . "</b></div>" .
                            "<div> <b>Genre: </b>" . $movie['genre'] . "</div>" .
                            "<div> <b>Rating: </b>" . $movie['rating'] . "</div> " .
                            "<div> <b><div>Summary: </div></b>" . $movie['summary'] . "</div> </div> </td><tr>";   
                }

                echo "</table>";
            }
            else 
            {
                echo "<p>No liked movies have been selected</p>";
            }
        }
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }


            ?>
        </div>
    </body>
</html>
