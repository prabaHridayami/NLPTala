
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	// if(!empty($_POST['text'])){
		$start = 0;
		$filename = "korpus.txt";
		$handle = fopen($filename, "r"); 
			while (!feof($handle)) { 
				$line = fgets($handle); //baca per baris 

					$line = preg_replace('/^\s*/', '', $line); 
					$line = preg_replace('/\s*$/', '', $line);

				$line = strtolower($line); 
				if ($line=="<text>") { // awal
					$start=1; 
				}elseif ($line=="</text>") { 
					$start=0; 
				}
				if ($start==1 && $line!="<text>"){ 
					// $tok=preg_replace('/[?!.,()*]|\"/','',$line); 
					// $tok=preg_replace('/^\'/','',$line);
					// $kata = preg_split("/[\s,.:]+/", $line);

					// $filter = array('.',',','!','?','(',')',':','"',''); //bisa ditambahkan
					// $tok 	= str_replace($filter,"", $line); //bersihkan tanda baca

					$text_clean = preg_replace("/[^A-Za-z0-9- ]/","", $line);
					$trim_text = trim($text_clean);

					$kata   = explode(" ", $trim_text);
					$hasil  = count($kata);
					$data   = array_count_values($kata);
					$jumlah = count($data);

					echo "<b>Teks</b> <br> $line";
					echo "<hr>";
					echo "<b>Teks clean</b> <br> $trim_text";
					echo "<hr>";
					echo "Jumlah Kata: $hasil buah kata<br>";
					echo "Jumlah kata type: $jumlah buah kata";
					echo "<hr>";
					

					arsort($data);
					foreach($data as $x => $x_value) {
						// if(!empty($x)){
						    echo $x." : ".$x_value;
						    echo "<br>";
						// }	
					}
					echo "<hr>";
				}
			}	
		fclose($handle);
	
?>
</body>
</html>

