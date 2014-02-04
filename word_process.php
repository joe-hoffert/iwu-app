<?php
/*
Rudimentary text processor 
• Count words (overall(DONE) and selected text(DONE)) 
• Count paragraphs DONE
• Count lines 
• Count characters DONE
• Spell check DONE


*/

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('memory_limit', '128M');
if (isset($_POST['submit'])) {
	$filename = "US.txt";
	$array = explode("\n", file_get_contents($filename));
	//if(isset($_POST['inputText']){
		
		$output = str_replace(array("\r\n", "\n", "\r"), " ", $_POST['inputText']);
		$output = $pg_url = preg_replace("/[^a-zA-Z 0-9]+/", " ", $output);
		$output = strtolower($output);
		$string = explode(" ", $output);
		$newArray = array();
		
		foreach($array as $array){
			$newArray[trim($array)]= trim($array);
		}
		//var_dump($newArray);
		//
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
	</head>
	<body>
		<h2>Enter Your text below</h2>
		<form name="wordForm" action="word_process.php" method="post">
			<textarea id="text" onkeyup="textFunctions()" name="inputText" style="width:500px;height:500px;" onmouseup="getText()"><?php
			if (isset($_POST['inputText'])){
				/*foreach ($wrongSpell as $wrongSpell){
					//$output = str_ireplace($wrongSpell, '<span style="color:red">'.$wrongSpell.'</span>', $_POST['inputText']);
					
				}*/
				echo stripslashes($_POST['inputText']);
			}?></textarea>
	<input type="submit" name="submit" value="SpellCheck"/>
		</form>
		<div style="padding:5px">Words: <span id="words"></span></div>
		<div style="padding:5px">Paragraphs: <span id="par"></span></div>
		<div style="padding:5px">Characters: <span id="char"></span></div>
		
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
	window.setInterval(function(){
  /// call your function here
  	//textFunctions();
}, 10000);

	function countWordsf(text){
		if (text != ""){
		
			//for(i=0
			var words = text.replace(/\r|\n/g, ' ').split(" ");
			//var newWord = words.replace(/^\s+|\s+$/g,'');
			console.log(words);
			var countWords = words.length;
			return countWords;
		}
	}
	function textFunctions(){
		var myText = document.getElementsByName("inputText")[0].value;
		if (myText != "" || myText != undefined){
				//console.log(myText);
			var charLength = myText.replace(/\s+/g, ' ');
			
			var test = myText.split(/\r\n|\r|\n/g);
			var countPar = test.length;
			
			var words = myText.replace(/\r|\n/g, ' ').split(" ");
			var countWords = words.length;
			document.getElementById('words').innerText = countWords;
			document.getElementById('par').innerText = countPar;
			document.getElementById('char').innerText = charLength.length;
			console.log(words);
			console.log(countWords);
			console.log(myText);
			var selectedText;
		}
		
		
				}
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