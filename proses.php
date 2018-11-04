<html>
<head>
	<title>Stemming Porter Bahasa Indonesia</title>
	<style>
		.col:hover{background-color:#FF0;cursor:pointer;}
	</style>
</head>
<body>
<?php
include "stemming.php";
include "koneksi.php";
$user = "root";
$pass = "";
$db = "nlp";
$host = "localhost";
$konek = mysqli_connect($host, $user, $pass,$db); 
$kata = 1;
$result = $konek->query("SELECT id_term FROM term ORDER BY id_term DESC LIMIT 0,1 ");
$maks_array = $result->fetch_assoc();
$maks = $maks_array ['id_term'];
 
	 while ($kata<=$maks){
		 $hasil = $konek->query("SELECT term FROM term WHERE id_term='$kata'");
		 $hasil_array = $hasil->fetch_assoc();
		 $hasil = $hasil_array ['term'];	
		 $awal = microtime(true);
		 $katadasar = hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($hasil)))));
		 $sql = "INSERT INTO hasil_stemming (id_term_fk,	id_algoritma_fk,hasil_stemming,time,status) VALUES ('$kata', '1' , '$katadasar' , '0', 'stemming berhasil') ";
		 if(mysqli_query($konek, $sql)){
			echo "Records added successfully. <br>";
		 } else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($konek);
		 }

		 $akhir = microtime(true);
		 $lama = $akhir-$awal;
		 $sql2 = "UPDATE hasil_stemming SET time='$lama' WHERE id_term_fk = $kata";
		 if(mysqli_query($konek, $sql2)){
			echo "TIME added successfully. <br>";
			} else{
			echo "TIME: Could not able to execute $sql2. " . mysqli_error($konek);
		 }
	$kata++;
	}
?>
<br />
</body>
</html>