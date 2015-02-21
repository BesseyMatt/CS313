<?php
session_start();
if (isset($_REQUEST["login"]) && isset($_REQUEST["password"]))
{
    function loadDatabase()
            {

              $dbHost = "http://php-besseym.rhcloud.com";
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
          
                $db = loadDatabase();
                    
                $login = $_REQUEST["login"];
                $_SESSION['login'] = $login;
                
                $password = $_REQUEST["password"];
                $_SESSION['password'] = $password;
                
               $statement = $db->query("SELECT userId FROM user WHERE username=\"" . $login . "\" AND password=\"" . $password . "\"");
               $validLogin = $statement->fetchAll(PDO::FETCH_ASSOC);
               
                if($validLogin == NULL)
                {
                    //invalid login 
                    echo "<script type='text/javascript'>alert('Invalid Login');</script>";
                    //header("Location: login.php"); 
                    echo '<script>window.location = "'. "login.php" .'";</script>';
                }
            }
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }
}

else if (isset($_SESSION["login"]) && isset($_SESSION["password"]))
{
    //do nothing
}

 else 
{
     //invalid login 
     echo "<script type='text/javascript'>alert('Invalid Login');</script>";
     echo '<script>window.location = "'. "login.php" .'";</script>';
 }

?>

<!DOCTYPE html>

<html>
    <head>
        <title>PHP Movie Project</title>
        <link href='http://fonts.googleapis.com/css?family=Lora|Indie+Flower|Titillium+Web' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="phpProject.css">
        <script type="text/javascript">
            function likeMovie(id) {
               window.location = 'likeMovie.';
            }        
        </script>
       
    </head>
    <body>
        <h1>PHP Movie Project</h1>
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
        
        <form action="suggestedMovies.php" action="POST">
            <h3>Which Movies do you Like? (Select to received suggestions of other films you might like): </h3>
           
            <input type="checkbox" name='movie1' id='movie1' value='Star Wars: A New Hope'> 
            <input type="checkbox" name='movie2' id='movie2' value='Indiana Jones and the Raiders of the Lost Ark'>
            <input type="checkbox" name='movie3' id='movie3' value='Iron Man'> </br>
  
            <input type="checkbox" name='movie4' id='movie4' value='Thor'>
            <input type="checkbox" name='movie5' id='movie5' value='Captain America: the First Avenger'> 
            <input type="checkbox" name='movie6' id='movie6' value='Back To the Future'> </br>
            
            <input type="checkbox" name='movie7' id='movie7' value='Groundhog Day'> 
            <input type="checkbox" name='movie8' id='movie8' value='The Hunger Games'> 
            <input type="checkbox" name='movie9' id='movie9' value='Batman Begins'> </br>
            
            <input type="checkbox" name='movie10' id='movie10' value='Inception'> 
            <input type="checkbox" name='movie11' id='movie11' value=' The Lord of the Rings: The Fellowship of the Ring'> 
            <input type="checkbox" name='movie12' id='movie12' value=' The Hobbit: An Unexpected Journey'> </br>
            
            <input type="checkbox" name='movie13' id='movie13' value='Ocean’s Eleven'> Ocean’s Eleven</br>
            
            <input type="submit">
        </form>
    </body>
</html>
