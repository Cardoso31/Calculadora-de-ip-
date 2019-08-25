<div class="dadosIp">
	<h1>Informações do ip</h1>

</div>
<div class="paginaInfos">

	<div class="center">

		<div class = 'item1'>	
			<p class="paragrafoIp">Ip  <span class="spanIp"> <?php echo $_POST['ip'] ?> </span> </p> 
			<p class="paragrafo">Tipo de ip : <span class="span"> <?php echo $infos['ip'] ?> </span> </p> 
			<p class="paragrafo">Máscara decimal : <span class="span"> /<?php echo $infos['subNets']['mascDeci'] ?> </span> </p> 
			<p class="paragrafo">Ips por subRede : <span class="span"> <?php echo $infos['subNets']['ipsPorSubNet'] ?> </span> </p> 
			<p class="paragrafo">Hosts por subRede: <span class="span"> <?php echo $infos['subNets']['ipsValidOfSubNet'] ?> </span> </p> 
			<p class="paragrafo">Número de SubRedes : <span class="span"> <?php echo $infos['subNets']['numOfSubNets'] ?> </span> </p> 


			<?php 
				
		$ipContido = ipContido($infos);
		
				if(!$ipContido == 0){ 

			echo '<p class="paragrafoContido">O ip informado é o mesmo de <span class="span">'. $ipContido.'</span></p>';

		 } 
			 ?>

		</div>
		<div class = 'item2'>
			


<?php

	if($infos['subNets']['mascDeci'] == 31 or $infos['subNets']['mascDeci'] == 32){
	}else{

	$subRedes = $infos['subNets']['redesBroad'];

		foreach ($subRedes as $key => $v) {

			if($v['ipParametroContido'] == true){
				echo '<div class="subRedeIp">';
		
		}else{

			echo '<div class="subRede">';
		}
			echo '
				<p class="paragrafo">SubRede '.($key+1).'</p> 
				<p class="paragrafoSubRede">Rede : <span class="spanSubRede">'.$infos['ipFixo'].'.'.$v['rede'].'</span> </p> 
				<p class="paragrafoSubRede">1° Host : <span class="spanSubRede">'.$infos['ipFixo'].'.'.$v['primeiroHost'].'</span> </p> 
				<p class="paragrafoSubRede">Ùltimo Host : <span class="spanSubRede">'.$infos['ipFixo'].'.'.$v['ultimoHost'].'</span> </p> 
				<p class="paragrafoSubRede">Broadcast : <span class="spanSubRede"> '.$infos['ipFixo'].'.'.$v['broadcast'].'</span></p> 
			</div> ';
		}
	}
?>

		</div>
	

	</div>
</div>