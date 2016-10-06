<!DOCTYPE html>
<html>
	<style type="text/css">
<?php
	require('/Library/WebServer/Documents/WebProject/GetID3/getID3-1.9.12/getid3/getid3.php');
	$getID3 = new getID3;
	function stringReplace($string) {
		$newString = str_replace("á","&#225;",$string);
		$newString = str_replace("é","&#233;",$newString);
		$newString = str_replace("ö","&#246;",$newString);
		$newString = str_replace("ü","&#252;",$newString);
		$newString = str_replace("ÿ","&#255;",$newString);
		$newString = str_replace("ñ","&#241;",$newString);
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
	$argument1 = $argv[1];
	$argument2 = $argv[2];
	$myArtistHtmlName = stringReplaceHTML($argument1);
	$myAlbumHtmlName = stringReplaceHTML($argument2);
	$myArtistName = stringReplace($argument1);
	$myAlbumName = stringReplace($argument2);
	$myDir = "/Users/jerbcarter/Music/iTunes/iTunes Media/Music/$argument1/$argument2";
	$di = new RecursiveDirectoryIterator($myDir);
	$myFiles = scandir($myDir);
	foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
		if ((substr($file, -3) == 'mp4') || (substr($file, -3) == 'm4a') || (substr($file, -3) == 'm4p') || (substr($file, -3) == 'm4p')) {
			$ThisFileInfo = $getID3->analyze("$file");
			getid3_lib::CopyTagsToComments($ThisFileInfo); 
			if(isset($ThisFileInfo['comments']['picture'][0])){
				$Image = $ThisFileInfo['comments']['picture'][0]['data'];
				file_put_contents("/Library/WebServer/Documents/WebProject/jerbcarter.github.io/Media/Music/$argument1/$argument2/albumCover.png",$Image);
			}
   				echo "		body {\n";
				echo "			background-image:url(\"https://jerbcarter.github.io/Media/Music/$myArtistHtmlName/$myAlbumHtmlName/albumCover.png\");\n";
    				echo "			background-position:center;\n";
    				echo "			background-repeat:repeat;\n";
				echo "			background-size: 90px;\n";
				echo "			margin: 0px;\n";
				echo "			padding: 0px;\n";
				echo "		}\n";
				break;
		}
	}
?>
		#header {
			background-color: rgba(10,10,10,0.8);
   			border: 5px solid black;
    			background-repeat:no-repeat;
			margin: 0.5% 0.5%;
   			padding: 0.5% 0.5%;
			-moz-border-radius: 15px;
			-webkit-border-radius: 15px;
    			border-radius: 15px;
			max-width: 940px;
			width: 100%;
			font-family: "Arial Black", Gadget, sans-serif;
			font-style: oblique;
			text-align: center;
		}
		div.wrapper {
			text-align: center;
			background-color: rgba(0,0,0,0.8);
			float: left;
			margin: 0.5% 0.5%;
   			padding: 0.5% 0.5%;
			width: 98%;
			max-width: 950px;
			min-height: 478px;
    			border-radius: 15px;
			font-family: "Arial Black", Gadget, sans-serif;
		}
		div.music {
   			padding: 1% 0 0 0;
			float: top;
			margin: 0 auto;
			width: 99%;
		}
		div.songTitle {
			padding: auto;
			text-align: middle;
			height: 80px;	
		}
		div.artwork {
			margin: 0 0 0 0;
			display: inline-block;
			width: 35%;
			min-width: 310px;
			height: 99%;
			font-family: "Arial Black", Gadget, sans-serif;
		}
		.round {
			border-radius: 12px;
			height: 300px;
			width: 300px;
		}
		div.player {
			padding: -2% 0 0 0;
			float: top;
			margin: -20px 0 0 0;
   			padding: 0.5% 0.5%;
			width: 99%;
		}
		.myAudio {
			display: inline-block;
			border-radius: 5px;
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			width: 100%;
			height: 95px;
		}
		div.lyrics {
			display: inline-block;
			margin: 0 0 -5% 0;
			min-width: 350px;
			width: 63%;
			height: 55%;
			max-height: 428px;
			overflow-y: scroll;
			font-family: "Arial Black", Gadget, sans-serif;
			font-size: 100%;
		}
	</style>
	<body>
	<div id="header">
		<center>
		<h1><font color="white"><?php echo "$myArtistName"?></font></h1>
		<h2><font color="white"><?php echo "$myAlbumName"?></font></h2>
	</div>
	<?php
		$i = 1;
		foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
			if ((substr($file, -3) == 'mp4') || (substr($file, -3) == 'm4a') || (substr($file, -3) == 'm4p')) {
				$ThisFileInfo = $getID3->analyze("$file");
				getid3_lib::CopyTagsToComments($ThisFileInfo); 
				/* 
				$picture = @$ThisFileInfo['id3v2']['APIC'][0]['data']; // binary image data
				if(isset($ThisFileInfo['comments']['picture'][0])){
					$Image='data:'.$ThisFileInfo['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($ThisFileInfo['comments']['picture'][0]['data']);
				*/
				$lyrics = @$ThisFileInfo['comments_html']['lyrics'][0];
				$title = @$ThisFileInfo['comments_html']['title'][0];
				$newTitle = basename("$file",".m4p");
				$newTitle = str_replace(substr($newTitle,0,3),"",$newTitle);
				if (is_numeric(substr($newTitle,0,1))) {
					$newTitle = str_replace(substr($newTitle,0,2),"",$newTitle);
				}
				if ($title == "") {
					$title = $newTitle;
				}
				$title = stringReplace($title);
				$lyrics = stringReplace($lyrics);
				$baseFile = basename("$file");
				$destination = "https://jerbcarter.github.io/Media/Music/$myArtistName/$myAlbumName";
				$linkTarget = "/Library/WebServer/Documents/WebProject/jerbcarter.github.io/Media/Music/$argument1/$argument2/$baseFile";
				if (! file_exists($linkTarget)) {
					symlink("$file", "$linkTarget");
				}
				$baseFile = stringReplace($file);
    				echo "		<div class=\"wrapper\">\n";
    				echo "			<div class=\"music\">\n";
    				echo "				<div class=\"artwork\">\n";
				echo "					<div class =\"songTitle\">\n";
				echo "						<h2 style=\"color:white;\">$title</h2>\n";
				echo "					</div>\n";
				echo "					<p align=\"center\">\n";
				echo "						<img class=\"round\" id=\"FileImage\" src=\"$destination/albumCover.png\" width=\"400\" height=\"400\">\n";
				echo "					</p>\n";
    				echo "				</div>\n";
    				echo "				<div class=\"lyrics\">\n";
    				echo "					<p align=\"center\" style=\"color:white\";>$lyrics</p>\n";
    				echo "				</div>\n";
    				echo "			</div>\n";
    				echo "			<div class=\"player\">\n";
    				echo "				<audio class=\"myAudio\" controls>\n";
				echo "					<source src=\"$destination/$baseFile\" type=\"audio/mpeg\">\n";
    				echo "				</audio>\n";
    				echo "			</div>\n";
    				echo "		</div>\n";
				$i = $i + 1;
			}
		}
	?>
	</body>
</html>	






