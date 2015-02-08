<?php
session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>All Movies</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
    </head>
    <body>
        <h1>All Movies</h1>
        <div id="navInfo">
             <nav>
                <a href="moviePHP.php">Like Movies</a>
                <a href="allMovies.php">All Movies</a>
                <a href="likedMovies.php">Your Liked Movies</a>
                <a href="suggestedMovies.php">Your Suggested Movies</a>
            </nav>
        </div>
        <div id="databaseInfo">
            <?php
            function loadDatabase()
            {

              $dbHost = "localhost";
              $dbPort = "3306";
              $dbUser = "besseym";
              $dbPassword = "password.";

              $dbName = "PHP_Movie_Project";

                 /*$openShiftVar = getenv('OPENSHIFT_MYSQL_DB_HOST');

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
                 } */
                 //echo "host:$dbHost:$dbPort dbName:$dbName user:$dbUser password:$dbPassword<br >\n";

                 $db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);

                 return $db;

            }

            try{

            $db = loadDatabase();

            $statement = $db->query("SELECT * FROM movie");
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

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
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }

            ?>
        </div>
    </body>
</html>
