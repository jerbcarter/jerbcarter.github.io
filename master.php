<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
	require('/Library/WebServer/Documents/WebProject/GetID3/getID3-1.9.12/getid3/getid3.php');
	$getID3 = new getID3;
	function stringReplace($string) {
		$newString = str_replace("á","&#225;",$string);
		$newString = str_replace("ö","&#246;",$newString);
		$newString = str_replace("ü","&#252;",$newString);
		$newString = str_replace("é","&#233;",$newString);
		$newString = str_replace("ÿ","&#255;",$newString);
		$newString = str_replace("ñ","&#241;",$newString);
		$newString = str_replace("ó","&#243;",$newString);
		$newString = str_replace("&#13;","<br>",$newString);
		return $newString;
	}
	function stringReplaceHTML($string) {
		$newString = str_replace("á","%C3%A1",$string);
		$newString = str_replace("é","%C3%A9",$newString);
		$newString = str_replace("í","%C3%AD",$newString);
		$newString = str_replace("ö","%C3%B6",$newString);
		$newString = str_replace("ü","%C3%BC",$newString);
		$newString = str_replace("ÿ","%C3%BF",$newString);
		$newString = str_replace("ñ","%C3%B1",$newString);
		$newString = str_replace("ó","%C3%B3",$newString);
		return $newString;
	}
?>
	<style type="text/css">
		body {
			background-image:url("./Media/music.jpeg");
			background-repeat:repeat;
    			float:left;
			background-size: 40px 40px;
			margin: 1.4%;
			padding: 0.5%;
		}
		.rounded {
			border-radius: 10px;
		}
		div.albums {
			text-align: center;
			width: 99%;
			max-width: 605px;
			max-height: 850px;
			border: 1px solid black;
			display: none;
			background-color: rgba(0,0,0,0.8);
			border-radius: 10px;
			overflow-y: scroll;
		}
		div.newboxes:hover {
			display: block;
		}
		div.icons:hover + div.newboxes {
    			display: block;
			padding: 0.5% 0.5%;
			margin: 0.2% 0.2%;
			float: left;
			border-radius: 10px;
			margin: -210px 200px;
		}
		div.album {
			display: inline-block;
			margin: 0.5% 0.5%;
			padding: 0.2% 0.2%;
			width: 187px;
			height: 187px;
			border-radius: 5px;
		}
		div.album:hover {
			margin: 0;
			padding: 0.5% 0.5%;
			margin: 0.2% 0.2%;
			background-color: red;	
		}
		div.select {
			display: inline-block;
			text-align: center;
			width: 100;
			max-width: 630px;
			overflow-y: scroll;
		}
		select.artistList {
			float: right;
			border-radius: 5px;
			height: 10%;
			width: 71%;
			overflow-y: scroll;
			background-color: rgba(100,100,100,0.8);
			color: white;
			font-size: 20px;
			margin: 0;
		}
		select.alphabeticList {
			float: left;
			border-radius: 5px;
			height: 10%;
			width: 28%;
			overflow-y: scroll;
			background-color: rgba(100,100,100,0.8);
			color: white;
			font-size: 20px;
			margin: 0;
		}
		.large {
			float: left;
			width: 500px;
			height: 700px;
		}
	</style>
		<div class="select">
			<select class="alphabeticList" id="testAlphabet" onchange="filterArtists(this);">
				<option id="myLetterIndex_0" value="0">Filter</option>
				<?php 
					$i = 1;
  					echo "				<option id=\"myLetterIndex_$i\" value=\"$i\">0-9</option>\n";
					foreach(range('A','Z') as $letter) { 
						$i = $i +1;
  						echo "				<option id=\"myLetterIndex_$i\" value=\"$i\">$letter</option>\n";
					} 
				?>
			</select>
			<select class="artistList" id="test" onchange="displayAlbums(this);">
				<option>Select Artist</option>
				<?php 
					$myDir = '/Users/jerbcarter/Music/iTunes/iTunes Media/Music/';
					$di = new DirectoryIterator($myDir);
					$myFiles = scandir($myDir);
					$i = 0;
					foreach (new IteratorIterator($di) as $filename => $artistDir) {
						if ((substr($artistDir, -1) != '.') && (substr($artistDir, -6) != '_Store')) {
							$tempArtistDir = stringReplace($artistDir); 
  							echo "				<option id=\"myIndex_$i\" value=\"$i\">$tempArtistDir</option>\n";
							$i = $i +1;
						}
					}       
				?>              
			</select>
		</div>
	<body>
		<div>
				<?php 
					$myDir = "/Users/jerbcarter/Music/iTunes/iTunes Media/Music/";
					$di = new DirectoryIterator($myDir);
					$myFiles = scandir($myDir);
					$i = 0;
					foreach (new IteratorIterator($di) as $filename => $artistDir) {
						if ((substr($artistDir, -1) != '.') && (substr($artistDir, -6) != '_Store')) {
        						echo "		 <div class=\"albums\" id=\"newboxes$i\">\n";
							$i = $i +1;
							$albumDirs = new DirectoryIterator("$myDir/$artistDir");
							foreach (new IteratorIterator($albumDirs) as $filename => $albumDir) {
								if ((substr($albumDir, -1) != '.') && (substr($albumDir, -6) != '_Store')) {
								$artistDir = stringReplaceHtml($artistDir); 
								$albumDir = stringReplaceHtml($albumDir); 
									echo "			 <div class=\"album\">\n";
									echo "				<a href=\"./Media/Music/$artistDir/$albumDir/album.html\">\n";
									echo "					<img class=\"rounded\" src=\"./Media/Music/$artistDir/$albumDir/albumCover.png\" width=\"187\" height=\"187\">\n";
									echo "				</a>\n";
									echo "			</div>\n";
								}
							}
							echo "		</div>\n";
						}
					}
				?>
		</div>
	</body>
	<script>
		function displayAlbums(nameSelect) {
			for (index = 0; index < 500; index++) {
				if(nameSelect){
    					var str0 = "myIndex_";
					var str00 = index;
    					var res0 = str0.concat(str00);
        				artistSelected = document.getElementById(res0).value;
					var x = document.getElementsByTagName("OPTION");
					var str1 = "newboxes";
    					var str2 = artistSelected;
    					var res = str1.concat(str2);
        				if(artistSelected == nameSelect.value){
            					document.getElementById(res).style.display = "block";
        				}
        				else{
            					document.getElementById(res).style.display = "none";
        				}
				}
    				else{
        				document.getElementById(res).style.display = "none";
    				}
			}
		}
		function filterArtists(letterSelect) {
			var alphaValue = document.getElementById("testAlphabet").options[letterSelect.value].text;
			var myArtistLetter = alphaValue.substring(0,1);
			var i = 0; 
			for (index = 0; index < 500; index++) {
				if(letterSelect){
					var letter = document.getElementById("test").options[index].text; 
					var myLetter = letter.substring(0,1);
					var theException = letter.substring(4,5);
					if ((letter.substring(0,3) == "The") && (myArtistLetter == theException)) {
						i = i + 1;
						document.getElementById("test").options[index].style.display = "block";
						document.getElementById("test").options[index].disabled = false;
					}
					else if((myArtistLetter == myLetter) && (alphaValue.substring(0,4) != "0-9")) {
						i = i + 1;
						document.getElementById("test").options[index].style.display = "block";
						document.getElementById("test").options[index].disabled = false;
        				}
					else if ((alphaValue == "0-9") && ((myLetter < "A") || (myLetter > "Z"))) {
						i = i + 1;
						document.getElementById("test").options[index].style.display = "block";
						document.getElementById("test").options[index].disabled = false;
					}
					else {
						document.getElementById("test").options[index].style.display = "none";
						document.getElementById("test").options[index].disabled = false;
					}
				}
				if (alphaValue == "Filter") {
					document.getElementById("test").options[index].style.display = "block";
					document.getElementById("test").options[index].disabled = false;
				}
				else if (i == 1) {
					document.getElementById("test").options[index].selected = 'selected';
				}
			}
		}
	</script>
</html>	
