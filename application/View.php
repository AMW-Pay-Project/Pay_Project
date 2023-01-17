<?php

	class View {
		
		var $tagList = array();
		var $htmlBody;

		function load($fileName) {
			$file = './view/'.$fileName.'.html';
		
			$openedFile = fopen($file, "r");
		
			$this->htmlBody = fread($openedFile, filesize($file));
		
			fclose($openedFile);
		}

		function parse() {
			
			foreach($this->tagList as $tag => $value) {
				$this->htmlBody = str_replace($tag, $value, $this->htmlBody);
			}
			
			return $this->htmlBody;
		}

		function add($tag, $value) {
			$tag = "{" . $tag . "}";
			
			$this->tagList[$tag] = $value;
		}

		function out() {
			$this->parse();
			
			echo $this->htmlBody;
		}
		
	}
	
?>