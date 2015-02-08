<?php
session_start();

 if(!isset($_SESSION['movies']))
 {
    $count = 0;
    $movies = array(6);
    
    if (isset($_REQUEST["movie1"]))
    {
        $movies[$count] = $_REQUEST["movie1"];
        $count++;
    }
    
    if (isset($_REQUEST["movie2"]))
    {
        $movies[$count] = $_REQUEST["movie2"];
        $count++;
    }
    
    if (isset($_REQUEST["movie3"]))
    {
        $movies[$count] = $_REQUEST["movie3"];
        $count++;
    }
    
    if (isset($_REQUEST["movie4"]))
    {
        $movies[$count] = $_REQUEST["movie4"];
        $count++;
    }
    
    if (isset($_REQUEST["movie5"]))
    {
        $movies[$count] = $_REQUEST["movie5"];
        $count++;
    }
    
    if (isset($_REQUEST["movie6"]))
    {
        $movies[$count] = $_REQUEST["movie6"];
        $count++;
    }
    $_SESSION['movies'] = $movies;
 }
 
 else {
     $movies = $_SESSION['movies'];
 }
    $sqlRequest = " WHERE m.name LIKE ";
    for ($i = 0; $i < $count; $i++)
    {
        if ($i == 0)
        {
            $sqlRequest = $sqlRequest . "\"" . $movies[$i] . "\"";
        }
        
        else
        {
            $sqlRequest = $sqlRequest . " OR  m.name LIKE" . "\"" . $movies[$i] . "\"";
        }
    }
    
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Suggested Movies</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
    </head>
    <body>
        <h1>Suggested Movies</h1>
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

              $dbHost = "http://php-besseym.rhcloud.com";
              $dbPort = "3306";
              $dbUser = "besseym";
              $dbPassword = "password";

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
            if (!isset($_SESSION['suggestions']))
            {
                $db = loadDatabase();

                $statement = $db->query("SELECT * FROM movie as m JOIN movieToSuggest as mts ON m.movieId = mts.movie1Id JOIN movie as m2 ON mts.movie2Id = m2.movieId" . $sqlRequest);
                $results = $statement->fetchAll(PDO::FETCH_ASSOC);

                $_SESSION['suggestions'] = $results;
            }
            
            else
            {
                $results = $_SESSION['suggestions'];
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
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }


            ?>
        </div>
    </body>
</html>
