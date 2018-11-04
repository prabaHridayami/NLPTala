<?php
	include "stopword.php";
	include "stemming.php";
	include "koneksi.php";
	// $user = "root";
	// $pass = "";
	// $db = "nlp";
	// $host = "localhost";
	// $konek = mysqli_connect($host, $user, $pass,$db); 

	if(!empty($_POST['text'])){

		$kata = strtolower($_POST['text']); 
		$token = tokenisasi($kata);
		$stopword = stopword($kata);

		echo "<table border='1'>
		<tr>
		<th>kata</th>
		<th>count</th>
		</tr>";
		arsort($token);
		foreach($token as $x => $x_value) {   
		    if(!empty($x)){
		    	echo "<tr>";
			    echo "<td>".$x."</td>";
			    echo "<td>".$x_value."</td>";
			    echo "</tr>";
			}	
				
		}

		echo "</table>";

		echo "<hr>";

		echo "<table border='1'>
		<tr>
		<th>kata</th>
		<th>count</th>
		</tr>";
		arsort($stopword);
		foreach($stopword as $y => $y_value) {   
		    if(!empty($x)){
		    	echo "<tr>";
			    echo "<td>".$y."</td>";
			    echo "<td>".$y_value."</td>";
			    echo "</tr>";
			}	
				
		}

		echo "</table>";
		echo "<hr>";

		echo "<table border='1'>
		<tr>
		<th>kata</th>
		<th>count</th>
		</tr>";
		arsort($stopword);
		foreach($stopword as $z => $z_value) {   
			$stem= hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($z)))));
		    if(!empty($x)){
		    	echo "<tr>";
			    echo "<td>".$stem."</td>";
			    echo "<td>".$z_value."</td>";
			    echo "</tr>";
			}	
				
		}

		echo "</table>";

	}else if(!empty($_POST['corpus'])){
		$kata = $_POST['corpus'];
	}else{
		echo "please enter text!";
	}
?>