<?php
function loadDatabase()
{

  $dbHost = "localhost";
  $dbPort = "3306";
  $dbUser = "besseym";
  $dbPassword = "password.";

     $dbName = "teamActivity";

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

$statement = $db->query("SELECT book, chapter, verse, content FROM Scriptures");
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Scripture Resources</h2>";

    foreach ($results as $scripture)
    {
        echo "<p><b>" . $scripture['book'] . " " . $scripture['chapter'] . ":" . $scripture['verse'] . " - </b>" . "\"" . $scripture['content'] . "\" </p>";   
    }
}

catch(PDOException $ex){
    echo "ERROR:$ex";
}


?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>php activity</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <div></div>
    </body>
</html>
