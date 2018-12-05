
<!DOCTYPE html>
<html>
<head>
	<title>Display</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<script src="js/jquery-3.2.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<?php
	include "stopword.php";
	include "stemming.php";
	include "tokenisasi.php";
	if(!empty($_POST['text'])){
		$kata = strtolower($_POST['text']); 
		$kata1 = $_POST['text'];
		$jumlah_kata = jumlah_kata($kata);
		$token = tokenisasi($kata);
		$stopword1 = stopword($kata);
		$splitparagraf = splitparagraf($kata);
		$countparagraf = count($splitparagraf);
		// echo json_encode($splitparagraf);


	// }else if(!empty($_POST['corpus'])){
	// 	$line = $_POST['corpus'];
	// 	$start = 0;
	// 	$filename = $_POST['corpus'];
	// 	$handle = fopen($filename, "r"); 
	// 	while (!feof($handle)) { 
	// 		$line = fgets($handle); //baca per baris 

	// 			$line = preg_replace('/^\s*/', '', $line); 
	// 			$line = preg_replace('/\s*$/', '', $line);

	// 		$line = strtolower($line); 
	// 		if ($line=="<text>") { // awal
	// 			$start=1; 
	// 		}elseif ($line=="</text>") { 
	// 			$start=0; 
	// 		}
	// 		if ($start==1 && $line!="<text>"){ 
	// 			$kata = strtolower($line); 
	// 			$token = tokenisasi($kata);
	// 			$stopword = stopword($kata);
	// 			$jumlah_kata = jumlah_kata($kata);
	// 		}
	// 	}
	}else{
		header('Location: http://localhost/nlp/nlpindex.php?message=failed');
	}



	function katatype($kata){
		$arr_stem[] = array();
		$arr_val[] = array();
		unset($arr_stem);
		unset($arr_val);
		$kata_type = stopword($kata);
		foreach($kata_type as $z=>$z_value) {
			$stem= hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($z)))));   
			if(!empty($z)){
				$arr_stem[] = $stem;	                                                                                                    
            }
            // $arr_com =array_combine($arr_stem,$arr_val);
				
		}
		return $arr_stem;
	}

	function kalimat($splitkalimat){
		$stopwordproc = array();
		unset($stopwordproc);
		foreach($splitkalimat as $kalimat){
			$stopwordproc[] = stopwordresult($kalimat);
		}

		return $stopwordproc;
	}
	
	
	function stopwordresult($kata){
		$tokenisasinocount = tokenisasinocount($kata);
		$stopword = array();
		unset($stopword);
		foreach($tokenisasinocount as $stop) { 
			$stopwordtemp = caristopword($stop);
			if($stopwordtemp != 0){
				unset($stop);
			}else{
				$stopword[] = hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($stop)))));
				// $stopword[] = $stop;
			}			
		}
		
		return array_count_values($stopword);
	}

	// function 

	$arr_combination = array();
	$countfile = 0;

	function summary_proc($splitparagraf){
		foreach($splitparagraf as $splitparagraf){
	
			$splitkalimat = splitkalimat($splitparagraf);
			$jumlah_kata_paragraf = jumlah_kata($splitparagraf);
			$dokumen = kalimat($splitkalimat);
			$term = katatype($splitparagraf);
			$countterm = count($term);
			$dokumencount = count(kalimat($splitkalimat));
			
			$termresult = array();
			$result = array();
	
			// tf perkalimat
			for($i=0;$i<$dokumencount-1;$i++){
					// $k = 0;
				for($j=0;$j<$countterm;$j++){
					foreach($dokumen[$i] as $item => $item_value){
						// $df[$j][$k] = 0;
						if($term[$j] == $item){
							$df = $item_value;
							$termresult = $term[$j];
							$result = $df;
							break;
						}else{
							$termresult = $term[$j];
							$result = 0;
						}
					}
				}
			}
	
			$arr_comdf = array();
			$arr_term = array();
			$arr_doccount = array();
			unset($arr_term);
			unset($arr_doccount);
			unset($arr_comdf);
			
			//banyak dokumen yang mengandung kata
			for($i=0;$i<$countterm;$i++){
				$k = 0;
				for($j=0;$j<$dokumencount-1;$j++){
					if(array_key_exists($term[$i], $dokumen[$j])){
						// $docterm = $term[$i];
						$k++;
					}
				}
				$arr_term [] = $term[$i];
				$arr_doccount [] = $k;
				
			}
	
			$arr_comdf = array_combine($arr_term,$arr_doccount);

	
			$arr_tf = array();
			$tf = array();
			$tftemp = array();
			$arr_comtfidf = array();
			$tfidf = array();
			$com_tfidf = array();
			$com_tf = array();
			unset($arr_comtfidf);
			
			for($i=0;$i<$dokumencount-1;$i++){
				$countdoc = count($dokumen[$i]);
				for($j=0;$j<$countdoc;$j++){
					unset($tf);
					unset($tfidf);
					foreach($dokumen[$i] as $item => $item_value){
						foreach($arr_comdf as $df=>$df_valued){
							if($item == $df){
								$tftemp = $item;
								$tfidftemp = number_format(($item_value*log((($dokumencount-1)/$df_valued),10)),2);
								break;
							}
						}
						$tf [] = $tftemp;
						$tfidf [] =$tfidftemp;
					}
					
				}
				$com_tf []= $tf;
				$com_tfidf [] = $tfidf;

			}
			$counttf = count($com_tf);	
			$value_all = array();
			for($i=0;$i<$counttf;$i++){
				// unset($value_all);
				$value =0;
				foreach($com_tfidf[$i] as $tfidf_value){
					$value = number_format($value + $tfidf_value,2);
				}
				$value_all [] = $value;
			}
			$com_value [] = $value_all;
		}
		return $com_value;
	}
	
	$summary_proc = summary_proc($splitparagraf);
	// echo "<hr>";
	// echo "bobot per-kalimat <br>";
	// echo json_encode($summary_proc);
	// echo "<hr>";
	// echo "bobot terbesar <br>";
	// index bobot terbesar
	for($paragraf = 0; $paragraf<$countparagraf;$paragraf++){
		$max_bot = max($summary_proc[$paragraf]);
		foreach($summary_proc[$paragraf] as $bobot => $bobot_value){
			if($max_bot == $bobot_value){
				$indexbobot = $bobot;
				$bobot = $bobot_value;
				break;
			}
		}
		$arr_indexbobot []= $indexbobot;
		$arr_bobot [] = $bobot;
	}
	$arr_combobot = array_combine($arr_indexbobot,$arr_bobot);
	$countarrbot = count($arr_combobot);

	$splitparagraf1 = splitparagraf($kata1);
	// echo json_encode($arr_combobot);
	// echo json_encode($arr_indexbobot);
			
?>

<body style="background-image: url(bg.jpg); background-size: 100%">
	<div class="content">
		<div class="container">
			<form id="form" method="post" action="nlpfield.php" style="width: 80%; height: 700%; padding: 20px;  margin: auto; margin-top: 10%; border: 1px solid #DDD; box-shadow: 10px 10px 10px #DDD; background-color: white; border-radius: 5px;">
				<h1 style="margin-bottom: 30px">NLP Bahasa Indonesia - Tala</h1>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label">Text Awal :</label>
					<div class="col-sm-8">
						<p>: <?php 
								echo $_POST['text'];
						?> </p>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label">Jumlah Token</label>
					<div class="col-sm-8">
						<p>: <?php echo $jumlah_kata; ?> </p>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label">Jumlah Kata Type</label>
					<div class="col-sm-8">
						<p>: 
						<?php 
							$token1 = 	0;
							$kata_type = stopword($kata);
							arsort($kata_type);
							foreach($kata_type as $a => $a_value){   
								$stem= hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($a)))));
							    if(!empty($a)){
							    	$token1 = ($token1+1);
								}	
									
							}
						echo $token1;
						?> 
						</p>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label">Ringkasan</label>
					<div class="col-sm-8">
						<p>: 
						<?php  
							if($arr_indexbobot[0]!=0){
								$splitkalimat1 = splitkalimat1($splitparagraf1[0]);
								echo $splitkalimat1[0].". ";
							}
							for($hitparagraf = 0; $hitparagraf<$countparagraf; $hitparagraf++){
								$splitkalimat1 = splitkalimat1($splitparagraf1[$hitparagraf]);
								echo $splitkalimat1[$arr_indexbobot[$hitparagraf]].". ";
							}

							$splitkalimat1 = splitkalimat1($splitparagraf1[$countparagraf-1]);
							$lastsplit = count($splitkalimat1)-2;
							$lastindex = count($arr_indexbobot)-1;
							if(($arr_indexbobot[$lastindex]) !=  $lastsplit){
								echo $splitkalimat1[$lastsplit].". ";
							}
						?> 
						</p>
					</div>
				</div>

				<div class="col-sm-12" >
					<table class="table">
						<?php 
							
							for($hitparagraf = 0; $hitparagraf<$countparagraf; $hitparagraf++){
								echo "<tr>";
								echo "<th width='800px' style='text-align:center'> Kalimat pada Paragraf ". ($hitparagraf+1)."<th>";
								echo "<th width='200px' style='text-align:center'> Bobot </th>";
								echo "</tr>";
								$splitkalimat1 = splitkalimat1($splitparagraf1[$hitparagraf]);
								$dokumencount1 = count(kalimat($splitkalimat1));
								
								for ($doc=0;$doc<$dokumencount1-1;$doc++){
								echo "<tr>";
								echo "<td>".$splitkalimat1[$doc]."<td>";
								echo "<td style='text-align:center'>".$summary_proc[$hitparagraf][$doc]."<td>";
								echo "</tr>";
	
								}							
							}
						?>
					</table>
						
				</div>

				<table width="900px">
					<tr>
				        <td><button id="btn_stopword" name ="btn-stopword" type="button" class="btn btn-primary" onclick="stopwordFunction()">STOPWORD</button></td>
				        <td><button id="btn-stemming" name ="btn-stemming" type="button" class="btn btn-info" onclick="stemmingFunction()">STEMMING</button></td>
				        <td><button id="btn_token" name ="btn-token" type="button" class="btn btn-success" onclick="tokenFunction()">TOKEN</button></td>
				    </tr>
				</table>
				<br>
				
					<div class="row">
				    	<div class="col-sm-4">
					      	<table class="table" border="1" id="stopword" style="display: none;">
								<tr>
									<th width="200px">WORD</th>
									<th width="200px">VALUE</th>
								</tr>
								<?php 
								$stopwordresult = stopword($kata);	
								arsort($stopwordresult);
								foreach($stopwordresult as $y =>$y_value){
									if(!empty($y)){
								    	echo "<tr>";
									    echo "<td>".$y."</td>";
									    echo "<td>".$y_value."</td>";
									    echo "</tr>";
									}	
								}
								?>
							</table>
				    	</div>
					    <div class="col-sm-4">
					      	<table class="table" border="1" id="stemming" style="display: none;">
								<tr>
									<th width="200px">WORD</th>
									<th width="200px">VALUE</th>
								</tr>
								<?php 
								$stopwordresult = stopword($kata);
								arsort($stopwordresult);
								foreach($stopwordresult as $z=>$z_value) {
									$stem= hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($z)))));   
								    if(!empty($z)){
								    	echo "<tr>";
									    echo "<td>".$stem."</td>";
									    echo "<td>".$z_value."</td>";
									    echo "</tr>";
									}		
								}	
								?>
							</table>
					    </div>
					    <div class="col-sm-4">
					      	<table class="table" border="1" id="token" style="display: none;">
								<tr>
									<th width="200px">WORD</th>
									<th width="200px">VALUE</th>
								</tr>
								<?php 
								arsort($token);
								foreach($token as $x => $x_value) {   
								    if(!empty($x)){
								    	echo "<tr>";
									    echo "<td>".$x."</td>";
									    echo "<td>".$x_value."</td>";
									    echo "</tr>";
									}
								}
								?>
							</table>
					    </div>
				</div>	
			</form>
		</div>
	</div>			
</body>


<script type="text/javascript">
	function stopwordFunction() {
	    var x = document.getElementById("stopword");
	    if (x.style.display === "none") {
	        x.style.display = "block";
	    } 
	}

	function stemmingFunction() {
	    var x = document.getElementById("stemming");
	    if (x.style.display === "none") {
	        x.style.display = "block";
	    }
	}

	function tokenFunction() {
	    var x = document.getElementById("token");
	    if (x.style.display === "none") {
	        x.style.display = "block";
	    }
	}
</script>
</html>

