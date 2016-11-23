<?php
$servername="localhost";
$username="root";
$conn = new mysqli($servername, $username, '');
if ($conn->connect_error) {
die('con fail');
}
echo 'con suc';
for($i = 0; $i < 1000000; $i++)
{
mysqli_ping($conn);
echo $i.PHP_EOL;
}
?>
