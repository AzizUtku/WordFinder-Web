<?php
error_reporting(0);
$harfkutusu = trim(@$_POST["harfkutusu"]);
$harfbasi = trim(@$_POST["harfbasi"]);
$harfsonu = trim(@$_POST["harfsonu"]);
$harfort = trim(@$_POST["harfort"]);
$jokersayisi = 0;
$jokersayisi = substr_count($harfkutusu,"☆");
if($jokersayisi > 2){
	$jokersayisi = 2;
}
$harfkutusu = str_replace("☆","",$harfkutusu);
$harfkutusu = $harfkutusu.$harfbasi.$harfort.$harfsonu;

$baglanti = mysqli_connect("host","username","password","database_name");


$kelimeler = mysqli_query($baglanti,"SELECT * FROM tdkkelimeler ORDER BY kelime ASC");

// =|?YUB5Pg2H8!0yJ=U 
$kelimesayisi = 0;
/*echo "<ul>";*/
	echo "{\"kelimeler\":[";
	while($row = mysqli_fetch_array($kelimeler)){
		$kelime = $row['kelime'];
		$uzunluk = strlen($kelime);
		$kelimeConvert = str_replace("ığüşöç","IGUSOC",$kelime);
		$harfkutusuConvert = str_replace("ığüşöç","IGUSOC",$harfkutusu);
		$harfler = str_split($kelimeConvert);
		$kac = 0;
		/*echo "$kelime&nbsp;-&nbsp;$uzunluk&nbsp;-&nbsp;$harfkutusu&nbsp;-&nbsp;$haha<br><hr>";*/
		$i = 0;
		for($i;$i<$uzunluk ; $i++){
			if(substr_count($kelimeConvert,$harfler[$i]) <= substr_count($harfkutusuConvert,$harfler[$i])){
				$kac++;
			}
		}
		
		if($kac+$jokersayisi == $uzunluk)
		{	
				$boolkelime = true;
				if(!empty($harfbasi) && substr($kelime,0,strlen($harfbasi)) != $harfbasi){
					$boolkelime = false;
				}
				
				if(!empty($harfsonu) && substr($kelime,strlen($kelime)-strlen($harfsonu)) != $harfsonu){
					$boolkelime = false;
				}
				
				if(!empty($harfort) && !preg_match('/'.$harfort.'/',$kelime)){
					$boolkelime = false;
				}
				
				if($boolkelime){
					
			
				
				
			if($kelimesayisi==0){
			echo "\"$kelime\"";
			$kelimesayisi++;}
			else if($kelimesayisi < 1000){
			echo ",\"$kelime\"";
			$kelimesayisi++;
			}
			else{
			$yenikelime = strtr($kelime,"ertyuıopğüasdfghjklşizcvbnmöç","*****************************");
					echo ",\"$yenikelime\"";
			}
			}
		}
		

		/*echo "$kelime&nbsp;-&nbsp;$uzunluk<br><hr>";*/
		
	}
	/*echo "</ul>";
	echo "$kelimesayisi";*/
	echo "]}";
	mysqli_close($baglanti);
?>