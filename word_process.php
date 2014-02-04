<?php
/*
Rudimentary text processor 
• Count words (overall(DONE) and selected text(DONE)) 
• Count paragraphs DONE
• Count lines 
• Count characters DONE
• Spell check DONE


*/

error_reporting(E_ALL);//These two lines are just telling the server to show all the errors
ini_set('display_errors', '1');
ini_set('memory_limit', '128M');//This is telling the server to increase the memory size available to 128M

if (isset($_POST['submit'])) {
	$filename = "US.txt";
	$array = explode("\n", file_get_contents($filename));
		//var_dump($_POST);//you can use the var_dump method to see the contents of any variable or object. It can be super helpful when debugging
		$output = str_replace(array("\r\n", "\n", "\r"), " ", $_POST['inputText']);
		$output = $pg_url = preg_replace("/[^a-zA-Z 0-9]+/", " ", $output);
		$output = strtolower($output);
		$string = explode(" ", $output);
		$newArray = array();
		
		foreach($array as $array){
			$newArray[trim($array)]= trim($array);
		}
		
		$wrongSpell = array();
		
		foreach ($string as $string){
			if (trim($string)=='i'){
			}
			else {
				if (array_key_exists(trim($string), $newArray)) {
				}
				else {
					array_push($wrongSpell, $string);
				}
			}
			
		}
}
?>

<html>
	<head>
		<style>
			.padding_helper {
				padding: 5px;
			}
			#text {
				width: 500px;
				height: 500px;
			}
		</style>
	</head>
	<body>
		<h2>Enter Your text below</h2>
		<form name="wordForm" action="word_process.php" method="post">
			<textarea id="text" onkeyup="textFunctions()" name="inputText" onmouseup="getText()"><?php
			if (isset($_POST['inputText'])){
				/*foreach ($wrongSpell as $wrongSpell){
					//$output = str_ireplace($wrongSpell, '<span style="color:red">'.$wrongSpell.'</span>', $_POST['inputText']);
					
				}*/
				echo stripslashes($_POST['inputText']);
			}?></textarea>
	<input type="submit" name="submit" value="SpellCheck"/>
		</form>
		<div class="padding_helper">Words: <span id="words"></span></div>
		<div class="padding_helper">Paragraphs: <span id="par"></span></div>
		<div class="padding_helper">Characters: <span id="char"></span></div>
		
		<div id="filearea">
			<?php 
			if (isset($wrongSpell)){
				echo "Words spelled incorrectly: ";
				for($i=0;$i<count($wrongSpell);$i++){
					echo $wrongSpell[$i].", ";
					$x = $i+1;
					if ($x==count($wrongSpell)){
						echo stripslashes($wrongSpell[$i]);
					}
				}
			}
			?>
			
		</div>
	<script>
	textFunctions();
	
	/**
	* This function counts all the words given
	* Input: (string of text)
	* Return: number of words in text
	*/
	function countWordsf(text){
		if (text != ""){
			var words = text.replace(/\r|\n/g, ' ').split(" ");
			var arrayCheck = new Array();
			for(var i=0;i<words.length;i++){
				if (words[i]!=""){
					arrayCheck.push(i);
				}
			}
			var countWords = arrayCheck.length;
			return countWords;
		}
	}
	
	/**
	* This function counts all the characters, words, and paragraphs
	* 
	*/
	function textFunctions(){
		var myText = document.getElementsByName("inputText")[0].value;
		if (myText != "" || myText != undefined){
			var charLength = myText.replace(/\s+/g, ' ');
			
			var test = myText.split(/\r\n|\r|\n/g);
			
			var arrayCheckPar = new Array();
			for(var i=0;i<test.length;i++){
				if (test[i]!=""){
					arrayCheckPar.push(i);
				}
			}
			var countPar = arrayCheckPar.length;
			
			var countWords = countWordsf(myText);
			document.getElementById('words').innerText = countWords;
			document.getElementById('par').innerText = countPar;
			document.getElementById('char').innerText = charLength.length;
			console.log(words);
			console.log(countWords);
			console.log(myText);
			var selectedText;
		}
	}
				
	/**
	* This function gets the highlighted text and outputs how many words are selected
	* 
	*/
	function getText(){
		var text = document.getElementById("text");
		if (text != "" || text != undefined){
			var t = text.value.substr(text.selectionStart,text.selectionEnd-text.selectionStart);
			document.getElementById('words').innerText = countWordsf(t);
			console.log(countWordsf(t));
		}
		else if(text == undefined){
			textFunctions()
		}
	}
	</script>
	</body>
	
</html>