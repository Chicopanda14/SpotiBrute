<?php
/*
* Created By @DrWean
* Modified by @mr.z3ro
* Last Update: 6/03/2019
*/

function getstr2($string,$start,$end){
    $str = explode($start,$string);
    $str = explode($end,$str[1]);
    return $str[0];
}
class spotify

{
	public function check($username, $password){
		$ch = curl_init('https://accounts.spotify.com/');
		$headers = array();
		$headers[] = "Accept-Encoding: gzip, deflate, sdch, br";
		$headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
		$headers[] = "Upgrade-Insecure-Requests: 1";
		$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
		$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
		$headers[] = "Cache-Control: max-age=0";
		$headers[] = "Connection: keep-alive";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		$result = curl_exec($ch);
		preg_match('/^Set-Cookie:\s*(csrf[^;]*)/mi', $result, $m);
		parse_str($m[1], $cookies);
		$token = $cookies['csrf_token'];
		
		$bon_cookie = base64_encode("0|0|0|0|1|1|1|1");
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://accounts.spotify.com/api/login");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "remember=false&username=$username&password=$password&csrf_token=$token");
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		
		$headers = array();
		$headers[] = "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) FxiOS/1.0 Mobile/12F69 Safari/600.1.4";
		$headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = "Accept: application/json, text/plain";
		$headers[] = "Cookie: sp_t=; sp_new=1; __bon=$bon_cookie; _gat=1; __tdev=VV4fjDj7; __tvis=BGWgw2Xk; spot=; csrf_token=$token; remember=$username";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
		$cookies = array();
		foreach($matches[1] as $item) {
		parse_str($item, $cookie);
		$cookies = array_merge($cookies, $cookie);
		}
		$output['body'] = $body;
		$output['cookies'] = $cookies;
		$auth = $output;
		$json_response = $auth['body'];
		$array_response = json_decode($json_response, true);
		error_reporting(0);
		$error = $array_response['error'];
		$display_name = $array_response['displayName'];
		if ($error != null){
		$output_check['status'] = false;
		$output_check['error'] = $error;
		$cruderesultfail = array();
		$cruderesultfail['status'] = $output_check['status'];
		$cruderesultfail['error'] = $error;
		
		$finaljsonfail = json_encode($cruderesultfail);
		return $finaljsonfail;
		
		} else if ($display_name != null){
		$output_check['status'] = true;
		$output_check['error'] = "null";
		$cookies = $auth['cookies'];
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "https://www.spotify.com/us/account/overview/");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
		$cookie = $cookies['sp_dc'];
		$headers = array();
		$headers[] = "Accept-Encoding: gzip, deflate, sdch, br";
		$headers[] = "Accept-Language: it-IT,it;q=0.8,en-US;q=0.6,en;q=0.4";
		$headers[] = "Upgrade-Insecure-Requests: 1";
		$headers[] = "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36";
		$headers[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
		$headers[] = "Cookie: sp_ftv=1; sp_landing=www.spotify.com^%^2F; sp_landing_15d=www.spotify.com^%^2F; sp_landing_30d=www.spotify.com^%^2F; sp_new=1; sp_ab=; pxt=; justRegistered=null; _gat=1; sp_dc=$cookie";
		$headers[] = "Connection: keep-alive";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		//echo "country ". getstr2($result, '"label":"Country","value":"', '"');
		if (strpos($result, "Get Premium") !== false) {
	    	$output_check['subscription'] = "FREE";
		}	
		elseif(strpos($result, "Premium Family") !== false) {
		    $output_check['subscription'] = "Family";
		}
		else {
	     	$output_check['subscription'] = "PREMIUM";
		}
		}
        if(strpos($result, 'Country')){
          //$output_check['Country'] = getstr2($result, '<p class="form-control-static" id="card-profile-country">','</p');
          $output_check['Country'] = getstr2($result, '"label":"Country","value":"', '"');
        }
       else {
         $output_check["Country"] = "Unknown";
       }
      if(strpos($result, 'Validuntil')){
       $output_check['Validuntil'] = getstr2($result, '<p class="form-control-static" id="Validuntil">','</p>');
      }
       else {
        $output_check["Validuntil"] = "Unknown";
      }


		$output_json = json_encode($output_check);
                return $output_json;
		}
  	  }
?>