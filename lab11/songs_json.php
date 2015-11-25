<?php
$SONGS_FILE = "songs.txt";

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

$top = "";

if (isset($_REQUEST["top"])) {
	$top = preg_replace("/[^0-9]*/", "", $_REQUEST["top"]);
}

if (!file_exists($SONGS_FILE)) {
	header("HTTP/1.1 500 Server Error");
	die("ERROR 500: Server error - Unable to read input file: $SONGS_FILE");
}

header("Content-type: application/json");

print "{\n  \"songs\": [\n";

// write a code to : 
// 1. read the "songs.txt" (or "songs_shuffled.txt" for extra mark!)
// 2. search all the songs that are under the given top rank 
	// go through each line of songs.txt file
	// use explode function to extract infomation about the song
	// if the rank information of the song is under the given value for the top parameter, 
	// 	store/generate the song and its information as a part of the search result
// 3. generate the result in JSON data format 


$lines = file($SONGS_FILE);
$order = 1; 

while ($order <= $top) {
	for ($i = 0; $i < count($lines); $i++) {
		list($title, $artist, $rank, $genre, $time) = explode("|", trim($lines[$i]));
		if ($rank < $top && $order == $rank) {
			print "\t{\"rank\":\"$rank\", \"title\":\"$title\", \"artist\":\"$artist\", \"genre\":\"$genre\", \"time\":\"$time\"},\n";
			$order++;
			break;
		}
		else if ($rank == $top && $order == $rank) {
			print "\t{\"rank\":\"$rank\", \"title\":\"$title\", \"artist\":\"$artist\", \"genre\":\"$genre\", \"time\":\"$time\"}\n";
			$order++;
			break;		
		}
	}
}

print "  ]\n}\n";

?>
