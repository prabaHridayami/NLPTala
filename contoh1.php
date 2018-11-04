<?php
		include "koneksi.php";
		$user = "root";
		$pass = "";
		$db = "nlp";
		$host = "localhost";
		$konek = mysqli_connect($host, $user, $pass,$db); 
		// mengecek koneksi
		// if (!$konek) {
		//     die("Koneksi gagal: " . mysqli_connect_error());
		// }
		// echo "Koneksi berhasil";
		// mysqli_close($konek);


		if(!empty($_POST['text'])){

			$text = strtolower($_POST['text']); 

			// $filter = array('.',',','!','?','(',')',':','','"'); //bisa ditambahkan
			// $text_clean = preg_replace('/[^A-Za-z0-9\-]/', '', $text);
			// $text_clean = str_replace($filter,"", $text); //bersihkan tanda baca
			$stopwords = 'ada|adalah|adanya|adapun|aduh|agar|ah|akan|aku|alih-alih|anda|andai|antar|antara|apa|apakah|apalagi|asalkan|atas|atau|ataupun|bagai|bagaikan|bagaimana|bagaimanakah|bagaimanapun|bagi|bahkan|bahwa|balik|banyak|barangkali|bawah|beberapa|begini|begitu|belakang|belum|berapa|berbagai|bersama|beserta|betapa|biar|biasanya|bila|bilamana|buat|bukan|dalam|dan|dapat|dari|daripada|dekat|demi|demikian|dengan|depan|di|dia|dikatakan|dilakukan|dkk|dll|dsb|engkau|hal|hampir|hanya|harus|hingga|ia|ialah|ini|itu|iya|jadi|jangan|jarang|jauh|jika|jikalau|juga|jumlah|justru|kadang|kadang-kadang|kalau|kalian|kami|kamu|karena|kata|katanya|kau|ke|kebanyakan|kecuali|kemanakah|kemudian|kenapa|kenapakah|kepada|ketika|ketimbang|kini|kita|lagi|lain|lain-lain|lainnya|lalu|lebih|lepas|lewat|maka|makin|manakala|masih|masing-masing|masing-masingnya|maupun|melainkan|melakukan|melalui|memang|mengatakan|mengenai|menjadi|menjelang|menuju|menunjukkan|menurut|mereka|merupakan|meski|meskipun|misalnya|mungkin|namun|nanti|nyaris|oleh|pada|padahal|para|pasti|pelbagai|per|peri|perihal|pinggir|pula|pun|saat|saja|sambil|sampai|samping|sang|sangat|sangatlah|saya|seakan|seakan-akan|seantero|sebab|sebabnya|sebagai|sebagaimana|sebagainya|sebelum|sebelumnya|sebuah|secara|sedang|sedangkan|sedikit|segera|sehabis|sehingga|sehubungan|sejak|sejumlah|sekarang|sekeliling|seketika|sekitar|sekonyong-konyong|selagi|selain|selalu|selama|selanjutnya|selesai|seluruh|seluruhnya|semakin|semenjak|sementara|semua|semuanya|seorang|sepanjang|seperti|sepertinya|seputar|seraya|sering|seringkali|serta|sesuai|sesuatu|sesudah|sesudahnya|sesungguhnya|setelah|seterusnya|setiap|seusai|sewaktu|si|siapa|siapakah|siapapun|suatu|sudah|supaya|tak|tanpa|tapi|tatkala|telah|tengah|tentang|tentu|tentunya|tergolong|terhadap|terjadi|terkadang|terlalu|terlebih|termasuk|ternyata|tersebut|tertentu|tetap|tetapi|tiap|tiba-tiba|tidak|ujar|ujarnya|umumnya|untuk|walau|walaupun|yang|yaitu|yakni|ya|mau';
			$text_bersih = preg_replace("/$stopwords/i","", $text);
			$text_clean = preg_replace("/[^A-Za-z0-9- ]/","", $text_bersih);
			$text_token = preg_replace("/[^A-Za-z0-9- ]/","", $text);

			$trim_text = trim($text_clean);
			$kata   = explode(" ",$text_clean);
			$hasil  = count($kata);
			$data   = array_count_values($kata);
			$jumlah = count($data)-1;

			$trim_token = trim($text_token);
			$kata_token   = explode(" ",$text_token);
			$hasil_token  = count($kata_token);
			$data_token   = array_count_values($kata_token);

			 
			echo "<b>Teks</b> <br> $text";
			echo "<hr>";
			echo "<b>Teks bersih</b> <br> $text_bersih";
			echo "<hr>";
			echo "<b>Teks clean</b> <br> $text_clean";
			echo "<hr>";
			echo "<b>Teks trim</b> <br> $trim_text";
			echo "<hr>";
			echo "Jumlah Kata: $hasil buah kata <br>";
			echo "<hr>";
			echo "Jumlah kata type: $jumlah buah kata";
			echo "<hr>";
			 
			foreach($data as $x => $x_value) {
			    
			    if(!empty($x)){
				    echo $x." : ".$x_value;
				    echo "<br>";
				}	
					
			}
			echo "<hr>";
		}else if(!empty($_POST['corpus'])){
			$start = 0;
			$filename = $_POST['corpus'];
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

					$stopwords = 'ada|adalah|adanya|adapun|aduh|agar|ah|akan|aku|alih-alih|anda|andai|antar|antara|apa|apakah|apalagi|asalkan|atas|atau|ataupun|bagai|bagaikan|bagaimana|bagaimanakah|bagaimanapun|bagi|bahkan|bahwa|balik|banyak|barangkali|bawah|beberapa|begini|begitu|belakang|belum|berapa|berbagai|bersama|beserta|betapa|biar|biasanya |bila|bilamana|buat|bukan|dalam|dan|dapat|dari|daripada|dekat|demi|demikian|dengan|depan|di|dia|dikatakan|dilakukan|dkk|dll|dsb|engkau|hal|hampir|hanya|harus|hingga|ia|ialah|ini|itu|iya|jadi|jangan|jarang|jauh|jika|jikalau|juga|jumlah|justru|kadang|kadang-kadang|kalau|kalian|kami|kamu|karena|kata|katanya|kau|ke|kebanyakan|kecuali|kemanakah|kemudian|kenapa|kenapakah|kepada|ketika|ketimbang|kini|kita|lagi|lain|lain-lain|lainnya|lalu|lebih|lepas|lewat|maka|makin|manakala|masih|masing-masing|masing-masingnya|maupun|melainkan|melakukan|melalui|memang|mengatakan|mengenai|menjadi|menjelang|menuju|menunjukkan|menurut|mereka|merupakan|meski|meskipun|misalnya|mungkin|namun|nanti|nyaris|oleh|pada|padahal|para|pasti|pelbagai|per |peri|perihal|pinggir|pula|pun|saat|saja|sambil|sampai|samping|sang|sangat|sangatlah|saya|seakan|seakan-akan|seantero|sebab|sebabnya|sebagai|sebagaimana|sebagainya|sebelum|sebelumnya|sebuah|secara|sedang|sedangkan|sedikit|segera|sehabis|sehingga|sehubungan|sejak|sejumlah|sekarang|sekeliling|seketika|sekitar|sekonyong-konyong|selagi|selain|selalu|selama|selanjutnya|selesai|seluruh|seluruhnya|semakin|semenjak|sementara|semua|semuanya|seorang|sepanjang|seperti|sepertinya|seputar|seraya|sering|seringkali|serta|sesuai|sesuatu|sesudah|sesudahnya|sesungguhnya|setelah|seterusnya|setiap|seusai|sewaktu|si|siapa|siapakah|siapapun|suatu|sudah|supaya|tak|tanpa|tapi|tatkala|telah|tengah|tentang|tentu|tentunya|tergolong|terhadap|terjadi|terkadang|terlalu|terlebih|termasuk|ternyata|tersebut|tertentu|tetap|tetapi|tiap|tiba-tiba|tidak|ujar|ujarnya|umumnya|untuk|walau|walaupun|ya|yaitu |yakni|yang|mau';
					$text_bersih = preg_replace("/$stopwords/i","", $line);
					$text_clean = preg_replace("/[^A-Za-z0-9- ]/","", $text_bersih);
					$trim_text = trim($text_clean);

					$kata   = explode(" ", $trim_text);
					$hasil  = count($text_clean);
					$data   = array_count_values($text_clean);
					$jumlah = count($data)-1;

					echo "<b>Teks</b> <br> $line";
					echo "<hr>";
					echo "<b>Teks clean</b> <br> $trim_text";
					echo "<hr>";
					echo "Jumlah Kata: $hasil buah kata<br>";
					echo "Jumlah kata type: $jumlah buah kata";
					echo "<hr>";
					

					arsort($data);
					foreach($data as $x => $x_value) {
						if(!empty($x)){
						    echo $x." : ".$x_value;
						    echo "<br>";
						}	
					}
					echo "<hr>";
				}
			}	
			fclose($handle);
		}else{
			echo "please enter text!";
		}
	?>