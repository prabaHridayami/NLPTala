<!DOCTYPE html>
<html>
<head>
	<title>Frekuensi</title>
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<script src="js/jquery-3.2.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body style="background-image: url(bg.jpg); background-size: 100%">
	<div class="content">
	<?php 
		if (isset($_GET['message'])) {    
		   echo '<div style="width: 67%; padding: 20px;  margin: auto; margin-top: 10%; margin-bottom: 1%; text-align: center;" class="alert alert-danger" role="alert">
				  Please input text or corpus
				</div>';
		}
	?>
		<div class="container" style="padding-top: 20px" >
			<form id="form" method="post" action="display.php" style="width: 80%; height: 700%; padding: 20px;  margin-left: auto; margin-right: auto; border: 1px solid #DDD; box-shadow: 10px 10px 10px #DDD; background-color: white; border-radius: 10px;">
				<h1 style="margin-bottom: 30px">NLP Bahasa Indonesia - Tala</h1>
				<div class="form-group row"> 
					<label for="inputEmail3" class="col-sm-4 col-form-label"><input type="radio" name="first" value="text" id="disable" checked>    Input Text</label>
					<div  class="col-sm-8">
						<textarea rows = "8" id="input1" name="text" type="string" class="form-control" id="inputEmail3" ></textarea>
					</div>
				</div>

				<div class="form-group row">
					<label for="inputEmail3" class="col-sm-4 col-form-label"><input type="radio" name="first" value="corpus" id="disable">    Input File</label>
					<div class="col-sm-8">
						<input class="corpus" id="input2" name="corpus" type="file" />
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-10">
				   		<button id="btn_save" type="submit" class="btn btn-primary">SUBMIT</button>
					</div>
				</div>			
			</form>
		</div>
	</div>				
</body>
<script type="text/javascript">
	$(document).ready(function() {
		$(".corpus").prop("disabled", true);
		$("form input:radio").change(function() {
		if ($(this).val() == "text") {
			$("#input2").attr('disabled', true);
			$("#input1").attr('disabled', false);
		}
		// Else Enable radio buttons.
		else {
			$("#input2").attr('disabled', false);
			$("#input1").attr('disabled', true);
		}
		});
});
</script>
</html>

