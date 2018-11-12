<?php
	include 'Stemming.php';
	$plain_text = "Sebanyak 1000 sopir angkutan kota di Kota Medan dan Kabupaten Deli Serdang mendukung Joko Widodo untuk kembali maju dalam pertarungan memperebutkan kursi Presiden Republik Indonesia. Aksi dukungan tersebut disampaikan dengan menggelar konvoi dengan mengendarai  armada mereka dimulai dari titik nol Kota Medan di Lapangan Merdeka Medan menuju Lapangan Garuda Tanjung Morawa, Deliserdang, Sumatera Utara, Selasa 18 September 2018. Dengan rute konvoi sejauh 20 kilometer.
	Dukungan tersebut dideklarasikan Ketua Kesatuan Pemilik dan Sopir Angkutan (Kesper) Sumut, Israel Situmeang; Ketua Organisasi Angkutan Darat (Organda) Sumut, Haposan Sialagan, serta tokoh masyarakat Sumut lainnya seperti Gelmok Samosir.Selain itu, dukung disampaikan juga oleh tiga mantan pemain tim sepakbola PSMS Medan, Jampi Hutauruk, Parlin Siagian, dan Amrus Sibadarida. Aksi deklarasi dukungan kepada Jokowi mengusung Konvoi Kerakyatan yang melibatkan serta keluarga para sopir dan pengusaha angkutan itu, dilakukan sebagai bentuk dukungan masyarakat transportasi di Sumatera Utara terhadap Jokowi.
	\"Hari ini kami semua, sopir, pengusaha angkot dan keluarga kami, serta para penumpang kami, menyatakan dukungan kami kepada bapak Joko Widodo untuk kembali maju sebagai Presiden. Ini bentuk kecintaan kami kepada Pak Jokowi. Kami untuk Jokowi 2 Periode,\" kata Israel Situmeang dalam orasi deklarasinya disambut dengan tepukan tangan. Israel menilai Jokowi layak didukung kembali dengan melihat kinerjanya dalam pembangunan infrastruktur untuk rakyat, seperti dibangunnya jalan tol Binjai-Tebingtinggi di Sumatera Utara, yang telah memangkas jarak tempuh dan efisiensi transportasi yang begitu besar di Sumut.";

	$textproc = new Stemming();

	$plain_text = explode(PHP_EOL, $plain_text);
	$jml_paragraf = count($plain_text);

	$paragraf = array();
	$kalimat = array();
	$plain_kalimat = array();

	// untuk mendapatkan array tf per kalimat
	foreach ($plain_text as $key => $value) {
		$paragraf[$key] = $value;
		$paragraf[$key] = explode(".", $paragraf[$key]);
		$paragraf[$key] = array_slice($paragraf[$key], 0, sizeof($paragraf[$key])-1);
		$jml_kalimat[$key] = count($paragraf[$key]);
		foreach ($paragraf[$key] as $key2 => $value2) {
			$kalimat[$key][$key2] = $value2;
			$plain_kalimat[$key][$key2] = $value2;
			$kalimat[$key][$key2] = $textproc->stem($kalimat[$key][$key2]);
			$kalimat[$key][$key2] = array_count_values($kalimat[$key][$key2]);	
		}
	}

	// tf perkalimat itu digabung jadi per paragraf
	for ($i=0; $i < $jml_paragraf; $i++) { 
		$j = 0;
		foreach ($kalimat[$i] as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$term_paragraf[$i][$j] = $key2;
				$j++;
			}
		}
		$term_paragraf[$i] = array_count_values($term_paragraf[$i]);
	}

	// ini untuk menyocokkan term pada tiap kalimat
	for ($h=0; $h < $jml_paragraf; $h++) {
		for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
			$j = 0;
			foreach ($term_paragraf[$h] as $key => $value) {
				$tf[$h][$i][$j] = 0;

				foreach ($kalimat[$h][$i] as $key2 => $value2) {
					if($key == $key2){
						$tf[$h][$i][$j] = $value2;
						break;
					}
				}
				$j++;
			}
		}
	}

	// menampilkan token tiap kalimat per paragraf
	for ($h=0; $h < $jml_paragraf; $h++) {
		for ($i=0; $i < $jml_kalimat[$h]; $i++) {
			echo "Token Kalimat ".$i.": ";
			foreach ($kalimat[$h][$i] as $key=>$value) {
				echo $key." ";
			}
			echo "<br />";
		}
		echo "<br />";
		echo "<br />";
	}

	// token perkalimat digabung per paragraf
	for ($h=0; $h < $jml_paragraf; $h++) {
		echo "<br />Token pada paragraf ".$h.": <br />";
		foreach ($term_paragraf[$h] as $key=>$value) {
			echo $key." ";
		}
		echo "<br />";
	}
	echo "<br /><br />";

	// menampilkan matriks
	for ($h=0; $h < $jml_paragraf; $h++) {
		for ($i=0; $i < $jml_kalimat[$h]; $i++) {
			foreach ($tf[$h][$i] as $key) {
				echo $key." ";
			}
			echo "<br />";
		}
		echo "<br /><br />";
	}

	// hitung jumlah kalimat yg mengandung term
	for ($h=0; $h < $jml_paragraf; $h++) {
		$j = 0;
		foreach ($tf[$h][$j] as $key) {
			$cek[$h][$j]=0;
			for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
				if($tf[$h][$i][$j]!=0){
					$cek[$h][$j]=$cek[$h][$j]+1;
				}
			}
			$j++;
		}
	}

	// nampilin jumlah kalimat yg mengandung term
	$h = 0;
	foreach ($cek as $key) {
		echo "Paragraf ".$h.": <br />";
		foreach ($key as $key2) {
			echo $key2." ";
		}
		echo "<br /><br />";
		$h++;
	}

	echo "Hasil TF IDF<br />";
	for ($h=0; $h < $jml_paragraf; $h++) {
		echo "Paragraf ".$h."<br />";
		for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
			for ($j=0; $j < count($cek[$h]) ; $j++) { 
				$tfidf[$h][$i][$j] = $tf[$h][$i][$j]*log($jml_kalimat[$h]/$cek[$h][$i]);
				echo $tfidf[$h][$i][$j]." | ";
			}
			echo "<br />";
		}
		echo "<br /><br />";
	}

	echo "Menghitung Bobot Kalimat<br />";
	for ($h=0; $h < $jml_paragraf; $h++) {
		for ($i=0; $i < $jml_kalimat[$h]; $i++) { 
			$tfidfkalimat[$h][$i] = 0;
			for ($j=0; $j < count($cek[$h]) ; $j++) {
				$tfidfkalimat[$h][$i] = $tfidfkalimat[$h][$i]+$tfidf[$h][$i][$j];
			}
		}
	}

	for ($h=0; $h < $jml_paragraf; $h++) {
		echo "Paragraf ".$h.": <br />";
		$i = 1;
		foreach ($tfidfkalimat[$h] as $key) {
			echo "Bobot kalimat ".$i.": ".$key."<br />";
			$i++;
		}
		echo "<br /><br />";
	}
	
	echo "<br />Hasil ringkasan:<br />";
	for ($h=0; $h < $jml_paragraf; $h++) {
		for ($i=0; $i < $jml_kalimat[$h]; $i++) {
			if (max($tfidfkalimat[$h])==$tfidfkalimat[$h][$i]) {
				echo $plain_kalimat[$h][$i].". ";
			}
		}
	}
	



	

	// s
	// for ($h=0; $h < $jml_paragraf; $h++) {
	// 	for ($i=0; $i < $jml_kalimat[$h]; $i++) {
	// 		foreach ($tf[$h][$i] as $key) {
	// 			echo $key." ";
	// 		}
	// 		echo "<br />";
	// 	}
	// }
	


	


?>