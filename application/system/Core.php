<?php

	class Core {
	
		function clearText($text) {		
			$text = trim($text);
			$text = htmlspecialchars($text);
			$text = htmlentities($text);
			$text = strip_tags($text);
		
			return $text;
		}
		
		function sendMail($to, $subject, $message) {
			$header = "From:noreply@".$_SERVER['SERVER_NAME']." \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			
			mail($to, $subject, $message, $header);
		}
		
		function randomString($long) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$string = '';
			for ($i = 0; $i < $long; $i++) {
				$string .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $string;
		}
		
		function getExchangeRatesFromNbp(string $currencyCode) : float {
			$query = file_get_contents("https://api.nbp.pl/api/exchangerates/rates/A/".$currencyCode."/?format=json");
			$fetch = json_decode($query, true);
			
			return $fetch['rates'][0]['mid'];
		}
	
	}
	
?>