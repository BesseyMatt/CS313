<?php
$visitsKey = "visits";
// get the previous count (if it exists, or set it to 0)
$count = 0;
if (isset($_COOKIE[$visitsKey]))
{
	$count = $_COOKIE[$visitsKey];
}
// increment the count
$count++;
// save the new count
setcookie($visitsKey, $count, time() + 10 * 60);
$name = "userId";
$value = "sburton";
//setcookie($name, $value, time() + 10 * 60);
//setcookie("password", "cs313", time() + 10 * 60);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cookie testing</title>
</head>

<body>
	<div>
		This is a page with cookies

<?php
if (isset($_COOKIE["userId"]))
{
	echo "Welcome: " . $_COOKIE["userId"];
}
?>

	</div>

	<div>
		You have visited this page <?php echo $count ?> time(s).
	</div>

</body>
</html>