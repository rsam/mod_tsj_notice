<?php
// no direct access
defined('_JEXEC') or die;
?>
  
<div id="tsjnotice">
<ul class="mod_tsj_notice">
	<?php
	$today  = mktime(0, 0, 0, date("m") , date("d"), date("Y"));
	$dnotice = array('third','second','first');
	
	//Проверки для счетчиков горячей воды
	for($i = 1; $i <= $waterdata->wcounts; $i++){
		$date_elements  = explode(".",$waterdata->{'date_in_hot_pp'.$i});
		$date_in_pp = mktime(0,0,0,$date_elements[0],$date_elements[1],$date_elements[2]);
		$delta_pp = ($date_in_pp - $today) / (60*60*24);

		//echo 'i='.$i.'pp='.$date_in_pp.'t='.$today.' d='.$delta_pp.'<br>';
		for($j = 0; $j <= 3; $j++)
		{
			if($parametors[('water_notice_'.$dnotice[$j])] > 0){
				if($delta_pp > 0){
					if($delta_pp <= $parametors[('water_notice_'.$dnotice[$j])]){
						//echo '<li><span class="notice_'. $dnotice[$j] .'">Окончание срока действия поверки водосчетчика ГВС SN='. $waterdata->{'ser_num_hot_pp'.$i} .' дней: '. $delta_pp .'</span></li>';
						echo '<li class="level'. $j .'">Окончание срока действия поверки водосчетчика ГВС SN='. $waterdata->{'ser_num_hot_pp'.$i} .' дней: '. $delta_pp .'</li>';
						break;
					}
				}
				else{
					echo '<li class="level0">Cрок действия поверки водосчетчика ГВС SN='. $waterdata->{'ser_num_hot_pp'.$i} .' истек</li>';
					break;
				}
			}
		}
	}

	// Проверки для счетчиков холодной воды
	for($i = 1; $i <= $waterdata->wcounts; $i++){
		$date_elements  = explode(".",$waterdata->{'date_in_cold_pp'.$i});
		$date_in_pp = mktime(0,0,0,$date_elements[0],$date_elements[1],$date_elements[2]);
		$delta_pp = ($date_in_pp - $today) / (60*60*24);

		//echo 'i='.$i.'pp='.$date_in_pp.'t='.$today.' d='.$delta_pp.'<br>';
		for($j = 0; $j <= 3; $j++)
		{
			if($parametors[('water_notice_'.$dnotice[$j])] > 0){
				if($delta_pp > 0){
					if($delta_pp <= $parametors[('water_notice_'.$dnotice[$j])]){
						echo '<li class="level'. $j .'">Окончание срока действия поверки водосчетчика XВС SN='. $waterdata->{'ser_num_cold_pp'.$i} .' дней: '. $delta_pp .'</li>';
						break;
					}
				}
				else{
					echo '<li class="level0">Cрок действия поверки водосчетчика XВС SN='. $waterdata->{'ser_num_cold_pp'.$i} .' истек</li>';
					break;
				}
			}
		}
	}
	
	//Проверки для счетчиков газа
	for($i = 1; $i <= $gazdata->wcounts; $i++){
		$date_elements  = explode(".",$gazdata->{'date_in_pp'.$i});
		$date_in_pp = mktime(0,0,0,$date_elements[0],$date_elements[1],$date_elements[2]);
		$delta_pp = ($date_in_pp - $today) / (60*60*24);

		//echo 'i='.$i.'pp='.$date_in_pp.'t='.$today.' d='.$delta_pp.'<br>';
		for($j = 0; $j <= 3; $j++)
		{
			if($parametors[('gaz_notice_'.$dnotice[$j])] > 0){
				if($delta_pp > 0){
					if($delta_pp <= $parametors[('gaz_notice_'.$dnotice[$j])]){
						echo '<li class="level'. $j .'">Окончание срока действия поверки счетчика газа SN='. $gazdata->{'ser_num_pp'.$i} .' дней: '. $delta_pp .'</li>';
						break;
					}
				}
				else{
					echo '<li class="level0">Cрок действия поверки счетчика газа SN='. $gazdata->{'ser_num_pp'.$i} .' истек</li>';
					break;
				}
			}
		}
	}
	
	//Проверки для счетчиков электроэнергии
	for($i = 1; $i <= $electrodata->wcounts; $i++){
		$date_elements  = explode(".",$electrodata->{'date_in_pp'.$i});
		$date_in_pp = mktime(0,0,0,$date_elements[0],$date_elements[1],$date_elements[2]);
		$delta_pp = ($date_in_pp - $today) / (60*60*24);

		//echo 'i='.$i.'pp='.$date_in_pp.'t='.$today.' d='.$delta_pp.'<br>';
		for($j = 0; $j <= 3; $j++)
		{
			if($parametors[('electro_notice_'.$dnotice[$j])] > 0){
				if($delta_pp > 0){
					if($delta_pp <= $parametors[('electro_notice_'.$dnotice[$j])]){
						echo '<li class="level'. $j .'">Окончание срока действия поверки счетчика электроэнергии SN='. $electrodata->{'ser_num_pp'.$i} .' дней: '. $delta_pp .'</li>';
						break;
					}
				}
				else{
					echo '<li class="level0">Cрок действия поверки счетчика электроэнергии SN='. $electrodata->{'ser_num_pp'.$i} .' истек</li>';
					break;
				}
			}
		}
	}
	
	?>


</ul>
</div>
