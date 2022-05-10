<?php

$dataBaseName="ruet";
$host='localhost';
$usr='root';
$pw='' ; 
$con = mysqli_connect($host,$usr,$pw, $dataBaseName);

if (!$con) {

    ?>
    <script>
        alert("Connection failed with Database");
    </script>
    
    <?php
	exit();
}

?>