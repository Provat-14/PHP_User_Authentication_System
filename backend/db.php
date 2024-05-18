<?php 
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'arprovat_github';

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$con){
	echo "Database connection fail->";
}else{
    // echo "seccess";
}

?>