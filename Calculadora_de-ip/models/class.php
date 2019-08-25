<?php


function calcularIp(){

	$infos = [];

	if(validateIp($_POST['ip']) == false or validateMask($_POST['mascara']) == false){
	?>
		<script>
			alert('Ip ou máscara inválidos ');
		</script>

	<?php

	}else{

		$x = validateMask($_POST['mascara']);
		if ($x['typeMasck']==1){

			$masckDeci = cauntone($x); //contém o valor da mascara em decimal

		}else{

			$mascParts = explode( '/' , $_POST['mascara']);
			$masckDeci = $mascParts[1];
	
		}


		$infos['ip'] = verificaIp($_POST['ip']);
		$infos['ipFixo'] = tresPrimOctetos();
		$infos['subNets'] = calcSubNets($masckDeci);


		return $infos;
					
	}
}

	function tresPrimOctetos(){
		$ip = validateIp($_POST['ip']);
		$tresOctetos = $ip[0].".".$ip[1].".".$ip[2];

		return $tresOctetos;
	}
	
	function verificaIp($ip){

		$ipFrag = validateIp($ip);

		if($ipFrag[0] == 10 or $ipFrag[0] == 127){
			return 'Privado';

		}elseif($ipFrag[0] == 192 and $ipFrag[1] == 168){
			return 'Privado';

		}elseif($ipFrag[0] == 169 and $ipFrag[1] == 254){
			return 'Privado';
		
		}elseif($ipFrag[0] == 172){

			if ($ipFrag[1] >= 16 and $ipFrag[1] <= 31 ){
				return 'Privado';
			
			}else{
				return 'Público';
			
			}
		}else{

			return 'Público';
		}


	}



	function calcSubNets($mascara){

		if($mascara == 32 or $mascara == 31){
		
			if($mascara == 32){

				$subNets['mascDeci'] = 32;
				$subNets['ipsPorSubNet'] = 1;
				$subNets['ipsValidOfSubNet'] = 'null';
				$subNets['numOfSubNets'] = 256;
	
			}elseif($mascara == 31){
	
				$subNets['mascDeci'] = 31;
				$subNets['ipsPorSubNet'] = 2;
				$subNets['ipsValidOfSubNet'] = 'null';
				$subNets['numOfSubNets'] = 128;
	
			}
				return $subNets;
	

		}else{

		




		$subNets['mascDeci'] = 24;
		$subNets['ipsPorSubNet'] = 256;
		
		while($subNets['mascDeci'] < $mascara ){

			$subNets['mascDeci'] = $subNets['mascDeci'] + 1;
			$subNets['ipsPorSubNet'] = $subNets['ipsPorSubNet'] / 2;

		}

		$subNets['ipsValidOfSubNet'] = $subNets['ipsPorSubNet'] - 2;
		$subNets['numOfSubNets'] = 256 / $subNets['ipsPorSubNet'];

		$subNet = [];
		$cont = 0;
		$redeBroadcasts = [];

		$ipFrag = validateIp($_POST['ip']) ; 
		

		while ( $cont < 256) {

			$subNet['rede'] = $cont;
			$subNet['broadcast'] = ($cont + $subNets['ipsPorSubNet']) - 1 ;
			$subNet['primeiroHost'] = $cont + 1;
			$subNet['ultimoHost'] = $subNet['broadcast'] - 1;

			$cont = $cont + $subNets['ipsPorSubNet']; 


			

				if ($ipFrag[3] > $subNet['rede'] and $ipFrag[3] < $subNet['broadcast']) {
				$subNet['ipParametroContido'] = true;

			}elseif($ipFrag[3] == $subNet['rede']){
				$subNet['ipParametroContido'] = 'ipRede';

			}elseif($ipFrag[3] == $subNet['broadcast']){
				$subNet['ipParametroContido'] = 'ipBroad';

			}else{
				$subNet['ipParametroContido'] = false;
			}
		
			
			$redeBroadcasts[] = $subNet;
			
		}

		$subNets['redesBroad'] = $redeBroadcasts;

		return $subNets;

	}
}
	




	function validateIp($ip){
		$false = 0;

		$ipFragmented = explode('.',$ip);
		if(sizeof($ipFragmented) == 4){

			foreach ($ipFragmented as $key => $value) {
				if ($value > 255) {

					$false = 1;
				}
			}

			if($false == 1 ){
			return false;

			}else{

				return $ipFragmented;
			}

		}else{
			return false;
		}
	}

	function validateMask($mask){
			
			$false = 0;


		if ($mask[0] == '/' and strlen($mask) == 3){

			$maskFragmented[] = $mask;
			$maskFragmented['typeMasck'] = 2;

			return $maskFragmented;

		}else{

		$maskFragmented = explode('.',$mask);
		if(sizeof($maskFragmented) == 4){

			foreach ($maskFragmented as $key => $value) {
				
				if (!$value >= 128) {
					$false = 1;
				}
			}

			if($false == 1){
			return false;

			}else{
				$maskFragmented['typeMasck'] = 1;
				return $maskFragmented;
			}

		}else{
			return false;
		}
}
	}


	function cauntone($dec){
		$con = 0 ;

		for ($i=0; $i < 4; $i++) { 

			$y = $dec[$i];
			$bin[] = decbin($y);

		}


		foreach ($bin as $key => $value) {
			
			for ($i=0; $i <8 ; $i++) { 
				
				if($value[$i]== 1 ){
					$con ++;

			}

			}
		}

		return $con;
	}	

	function ipContido($infos){

	$subRedes = $infos['subNets']['redesBroad'];

		foreach ($subRedes as $key => $v) {

			if($v['ipParametroContido'] == true){
				
				switch ($v['ipParametroContido']) {

					case 'ipRede':

						return 'Rede';
						break;

					case 'ipBroad':
						return 'Broadcast';
					break;

					case true:

						return 0;
					break;
				}
	}
}
}


	
// 'isset' se a variavel tiver sido 'setada' e 'function_exists' se a funcao existir
// 'call_user-func' executa a funcao que for passada
	
 if (isset($_GET['acao']) and function_exists($_GET['acao']) ){

       $infos =  call_user_func($_GET['acao'],[$_POST['ip'],$_POST['mascara']]);
	}


