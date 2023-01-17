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
	
		function minify($text) {
			$text = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $text);
			$text = str_replace(': ', ':', $text);
			$text = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $text);
			
			return $text;
		}
		
		function randomString($long) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$string = '';
			for ($i = 0; $i < $long; $i++) {
				$string .= $characters[rand(0, strlen($characters))];
			}
			return $string;
		}
	
	}
	
?>