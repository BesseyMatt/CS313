    <?php
        
              //$movieId  
              $dbHost = "http://php-besseym.rhcloud.com";
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
                 
            try{
           
                $db = loadDatabase();
                
                $statement = $db->query("SELECT userId FROM user WHERE " . $login . "= name" );
                $loginId = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                $db->query("INSERT into likedMovie (userId, movieId) VALUES (" . $loginId . ", " . $movieId . ")");
          
            }
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }
            
            header("Location: moviePHP.php");
?>

