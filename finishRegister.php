<?php
session_start();

if (isset($_REQUEST["name"]) && isset($_REQUEST["login"]) 
        && isset($_REQUEST["password"]) && isset($_REQUEST["rePassword"])
        && ($_REQUEST["password"] == $_REQUEST["rePassword"]))
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
                
                $name = $_REQUEST["name"];
                $_SESSION['name'] = $name;
                
               $statement = $db->query("insert user (name, username, password) values (\"" . $name . "\" , \"" . $login . "\" , \"" . $password . "\")");
               
                //invalid login 
                echo "<script type='text/javascript'>alert('Registration Complete');</script>"; 
                echo '<script>window.location = "'. "login.php" .'";</script>';
               
            }
            
            catch(PDOException $ex){
                echo "ERROR:$ex";
            }
}

 else 
{
     //invalid login 
     echo "<script type='text/javascript'>alert('Invalid Registration');</script>";
     echo '<script>window.location = "'. "register.php" .'";</script>';
 }
?>
