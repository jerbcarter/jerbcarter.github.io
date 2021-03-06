#!/bin/tcsh -f
set startPath = `pwd`
set savePath = $startPath/Media/Music
set artistList = ()
set temp = ""
cd /Users/jerbcarter/Music/iTunes/iTunes\ Media/Music/
foreach dir (*/)
	set temp = `echo $dir`
	set artistList = ($artistList:q "$temp")
end
foreach x ($artistList:q) 
	set artist = `echo $x | awk '{gsub(/\//,""); print}'`
	if (! -d "$savePath/$x") then
		mkdir "$savePath/$x"
	endif
	cd "/Users/jerbcarter/Music/iTunes/iTunes Media/Music/$x"
	set temp2 = `ls -l | grep -v "^d" | wc -l | awk '{gsub(/\//,""); print}'`
	if ($temp2 >= 1) then
		foreach dir (*/)
			cd "/Users/jerbcarter/Music/iTunes/iTunes Media/Music/$x/$dir"
			set album = `echo $dir | awk '{gsub(/\//,""); print}'`
			echo $album
			if (! -d "$savePath/$x/$dir") then
				mkdir "$savePath/$x/$dir"
			endif
			cd "$savePath/$artist/$album"
			php $startPath/artistAlbum.php "$artist" "$album" > album.html
		end
	endif
end
cd $startPath 
php ./master.php > ./index.html
