
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
	include "koneksi.php";
	if(!empty($_POST['text'])){
		$line = $_POST['text'];
		$kata = strtolower($_POST['text']); 
		$token = tokenisasi($kata);
		$stopword = stopword($kata);
		$jumlah_kata = jumlah_kata($kata);

	}else if(!empty($_POST['corpus'])){
		$line = $_POST['corpus'];
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
				$kata = strtolower($line); 
				$token = tokenisasi($kata);
				$stopword = stopword($kata);
				$jumlah_kata = jumlah_kata($kata);
			}
		}
	}else{
		header('Location: http://localhost/nlp/nlpindex.php?message=failed');
	}
	
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
							if(!empty($_POST['text'])){
								echo $_POST['text'];
							}else{
								$filename = $_POST['corpus'];
								$handle = fopen($filename, "r"); 
								while (!feof($handle)) { 
									$line = fgets($handle);
									$line = preg_replace('/^\s*/', '', $line); 
									$line = preg_replace('/\s*$/', '', $line);

									$line = strtolower($line); 
									if ($line=="<text>") { // awal
										$start=1; 
									}elseif ($line=="</text>") { 
										$start=0; 
									}
									if ($start==1 && $line!="<text>"){
										echo $line;
									}
								}
							}

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
						<p>: <?php 
							$token1 = 	0;
							arsort($stopword);
							foreach($stopword as $a => $a_value){   
								$stem= hapusakhiran(hapusawalan2(hapusawalan1(hapuspp(hapuspartikel($a)))));
							    if(!empty($a)){
							    	$token1 = ($token1+1);
								}	
									
							}
						echo $token1;?> </p>
					</div>
				</div>

				<table width="900px">
					<tr>
				        <td><button id="btn_stopword" name ="btn-stopword" type="button" class="btn btn-primary" onclick="stopwordFunction()">STOPWORD</button></td>
				        <td><button id="btn-stemming" name ="btn-stemming" type="button" class="btn btn-info" onclick="stemmingFunction()">STEMMING</button></td>
				        <td><button id="btn_token" name ="btn-token" type="button" class="btn btn-success" onclick="tokenFunction()"">TOKEN</button></td>
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
								arsort($stopword);
								foreach($stopword as $y => $y_value) {   
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
								arsort($stopword);
								foreach($stopword as $z => $z_value) {
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

