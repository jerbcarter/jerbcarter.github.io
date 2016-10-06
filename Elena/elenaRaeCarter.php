<html>
	<style type="text/css">
   		body {
			background-image:url(/Volumes/MediaServer/Elena_Webpage/hummingbird.jpg);
    			background-position:center;
    			background-repeat:repeat;
			background-size: 50px 60px;
			margin: 0px;
			padding: 0px;
		}
		#header {
    			background-position: 0% 0%;
			background-image:url(/Volumes/MediaServer/Elena_Webpage/rainbow-flame-ribbon-banner.jpg);
    			background-repeat:no-repeat;
		}
		#bgTopCover {
			background-color: black;
    			background-position: top left;
    			background-repeat:no-repeat;
			background-size: 300px 600px;
		}
		#bgTopVideo {
    			background-position: top right;
    			background-repeat:no-repeat;
			max-height:100%;
			max-width:100%;
		}
		audio.player {
 			width: 250px;
			text-align: center;
		}
		div.video {
			background-color: black;
			float: left;
			margin: 10px;
   			padding: 10px;
   			width: 63.25%;
   			max-height: 46%;
   			border: 1px solid black;
		}
		div.cover {
			float: left;
			margin: 10px;
   			padding: 10px;
			width: 320px;
			height: 500px;
   			border: 1px solid black;
		}
		div.wrapper {
			background-color: black;
			float: left;
			margin: 10px;
   			padding: 10px;
   			border: 1px solid black;
			width: 46%;
		}
		div.artwork {
			text-align: center;
			background-color: black;
			float: left;
			margin: 5px;
   			padding: 0px;
   			border: 1px solid black;
			max-height: 32%;
			width: 40%;
		}
		div.lyrics {
			background-color: black;
			float: left;
			margin: 5px;
   			padding: 5px;
   			border: 1px solid black;
			max-height: 32%;
			width: 55%;
			overflow-y: scroll;
		}

	</style>
		<div id="header">
			<center>
			<h1>
				<font color="#DEF4F5">Elena Rae Carter</font>
			</h1>
			<h2>
				<font color="#DEF4F5">She is delightfully chaotic... a beautiful mess. Loving her is a splendid adventure.</font>
			</h2>
		</div>
		<div id="bgTopCover" class="cover">
			<img src="/Volumes/MediaServer/Elena_Webpage/Elena_Cover.jpg" alt="Elena Cover" height=100% width=100%>
		</div>
		<div id="bgTopVideo" class="video">
			<video id="myVideo" width=100% controls autoplay preload="metadata">
				<source src="file:///Volumes/MediaServer/Elena_Webpage/Elena%20Rae%20Carter.m4v" type="video/mp4">
			</video>	
		</div>
		<?php
			$argument1 = $argv[1];
			$argument2 = $argv[2];
			echo "$argument1";
			echo "$argument2";
			require('/Volumes/MediaServer/GetID3/getID3-1.9.12/getid3/getid3.php');
			$getID3 = new getID3;
			$myDir = "/Users/jerbcarter/Music/iTunes/iTunes Media/Music/$argument1/$argument2";

			$di = new RecursiveDirectoryIterator($myDir);
			foreach (new RecursiveIteratorIterator($di) as $filename => $file) {
				if ((substr($file, -3) == 'mp4') || (substr($file, -3) == 'm4a') || (substr($file, -3) == 'm4p')) {
					$ThisFileInfo = $getID3->analyze("$file");
					getid3_lib::CopyTagsToComments($ThisFileInfo); 
					$picture = @$ThisFileInfo['id3v2']['APIC'][0]['data']; // binary image data
					if(isset($ThisFileInfo['comments']['picture'][0])){
						$Image='data:'.$ThisFileInfo['comments']['picture'][0]['image_mime'].';charset=utf-8;base64,'.base64_encode($ThisFileInfo['comments']['picture'][0]['data']);
					}
					$lyrics = @$ThisFileInfo['comments_html']['lyrics'][0];
					$title = @$ThisFileInfo['comments_html']['title'][0];
					$correctLyrics = str_replace("&#13;","<br>",$lyrics);
    					echo "		<div class=\"wrapper\">\n";
    					echo "			<div class=\"artwork\">\n";
					echo "				<h3 style=\"color:red;\">$title</h3>\n";
					echo "				<p style=\"text-align:center\">\n";
					echo "					<img id=\"FileImage\" align=\"center\" width=\"250px\" src=\"$Image\" height=\"250\">\n";
    					echo "				<audio class=\"player\" controls>\n";
					echo "					<source src=\"$file\" type=\"audio/mpeg\">\n";
    					echo "				</audio>\n";
					echo "				</p>\n";

    					echo "			</div>\n";
    					echo "			<div class=\"lyrics\">\n";
    					echo "				<p align=\"center\" style=\"color:#FF0000\";>$correctLyrics</p>\n";
    					echo "			</div>\n";
    					echo "		</div>\n";
				}
			}
		?>

	<!--
					$lyrics[] = @$ThisFileInfo['id3v2']['USLT'][0]['data'];
        				$data[] = $Result;
					$result = print_r(array_values($lyrics));
					$Lyrics = array("lyrics"=> $Result);
					$result = print_r(array_values($Lyrics));
					$Result = array("data"=> @$ThisFileInfo['id3v2']['USLT'][0]);
					$result = print_r(array_values($Result));
	-->
	<body>
		<script>
			var vid = document.getElementById("myVideo"); 

			function playVid() { 
				vid.play(); 
			} 
		
			function pauseVid() { 
				vid.pause(); 
			}
		</script>
		<script>
			function myFunction() {
				<a href="/Volumes/MediaServer/Movies">Go to Movies</a>
			}
		</script>
	</body>
</html>	






