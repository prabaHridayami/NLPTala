<?php
// include "stopword.php";
// include "stemming.php";
// function fix_token($kata){
//     $token = tokenisasi($kata);
//     arsort($token);
    
//     $arr_stem = array();
//     $arr_val = array();
//     $arr_token2 = array();
//     $counttoken2 = count($token);
//     for($i=0; $i<$counttoken2;$i++){
//         $token2 = tokenisasi4($token[$i]);
//         $countsplit2 = count($token2);
//         for($j=0; $j<$countsplit2;$j++){
//             $stopword = stopword1($token2[$j]);
//             $token3 = tokenisasi2($stopword);
//             unset($arr_stem);
//             unset($arr_val);
//             unset($arr_com);
//             foreach($token3 as $b => $b_value){
//                 $stem	= talakamus($b);
//                 $arr_stem[] = $stem;
//                 $arr_val[] =$b_value;	                                                                                                    
//             }
//                 $arr_com =array_combine($arr_stem,$arr_val);
//                 $arr_phrase[$i][$j] = $arr_com;
//         }  
//     }

//     return $arr_phrase;
// }

function jumlah_kata($kata){
	$text_token 	= preg_replace("/[^A-Za-z0-9- ]/","", $kata);
	$trim_token 	= trim($text_token);
	$kata_token   	= explode(" ",$text_token);
	$data_token   	= count($kata_token);

	return $data_token;
}

function tokenisasi($kata){
	$text_token 	= preg_replace("/[^A-Za-z0-9- ]/","", $kata);
	$trim_token 	= trim($text_token);
	$kata_token   	= explode(" ",$text_token);
	$data_token   	= array_count_values($kata_token);

	return $data_token;
}

function tokenisasinocount($kata){
	$text_token 	= preg_replace('/[^A-Za-z0-9- ]/','', $kata);
	$trim_token 	= trim($text_token);
	$data_token   	= explode(" ",$text_token);
	// $data_token   	= array_count_values($kata_token);

	return $data_token;
}

function splitkalimat($kata){
	$text_token 	= preg_replace("/[^A-Za-z0-9-. ]/","", $kata);
	// $trim_token 	= trim($text_token);
	$kata_token   	= explode(".",$text_token);
	$data_token   	= $kata_token;

	return $data_token;
}

function splitkalimat1($kata){
	// $text_token 	= preg_replace("/[^A-Za-z0-9-. ]/","", $kata);
	// $trim_token 	= trim($text_token);
	$kata_token   	= explode(".",$text_token);
	$data_token   	= $kata_token;

	return $data_token;
}

function splitparagraf($kata){
	$trim_token 	= trim($kata);
	$kata_token   	= explode("\r\n", $trim_token);
	$data_token   	= $kata_token;

	return $data_token;
}
?>