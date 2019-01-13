<?php

// Chnage the url and it's respective html file name before running this script

$sources = array(
"Array" => "https://www.geeksforgeeks.org/array-data-structure/",
"Matrix" => "https://www.geeksforgeeks.org/matrix/",
"LinkedList" => "https://www.geeksforgeeks.org/data-structures/linked-list/",
"String" => "https://www.geeksforgeeks.org/string-data-structure/",
"Stack" => "https://www.geeksforgeeks.org/stack-data-structure/",
"Queue" => "https://www.geeksforgeeks.org/queue-data-structure/",
"Binarytree" => "https://www.geeksforgeeks.org/binary-tree-data-structure/",
"BST" => "https://www.geeksforgeeks.org/binary-search-tree-data-structure/",
"Graph" => "https://www.geeksforgeeks.org/graph-data-structure-and-algorithms/",
"Heap" => "https://www.geeksforgeeks.org/heap-data-structure/",
"Hashing" => "https://www.geeksforgeeks.org/hashing-data-structure/",
"Sorting" => "https://www.geeksforgeeks.org/sorting-algorithms/",
"Searching" => "https://www.geeksforgeeks.org/searching-algorithms/",
"Greedy" 		=>  "https://www.geeksforgeeks.org/greedy-algorithms/",
"DevidenConq"	=>  "https://www.geeksforgeeks.org/divide-and-conquer/",
"Backtracking"	=>  "https://www.geeksforgeeks.org/backtracking-algorithms/",
"Dynamic"		=>  "https://www.geeksforgeeks.org/dynamic-programming/");

// $sources = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

$unique = array();

echo "TOPIC\tINPUT\tOUTPUT\tURL\tSTATUS\n";
$total_probs = 0;
foreach($sources as $topic => $url){
	$filename = "html/" . $topic . "Problems.html";
	$output_filename = "output/" . $topic . "Problems.json";
	$total_probs = $total_probs + getProblems($url,$filename, $output_filename , $topic);
	echo "\n\n";
}
echo "\n\n Total Problems" . $total_probs . "\t". count(array_unique($unique)) . "\n";

exit();


function getProblems($url,$filename, $output_filename , $topic){
	global $unique;
	echo $filename ."\t". $output_filename . "\t" . $url ."\t";
	// $url = "https://www.geeksforgeeks.org/hashing-data-structure/";
	// $filename = "html/HashingProblems.html";
	// $output_filename = "output/HashingProblems.json";



	if (file_exists($filename) == false) {
		$htmlContent = file_get_contents($url);
		file_put_contents($filename, $htmlContent);
		echo "\tScraped";
	}else{
		$htmlContent = file_get_contents($filename);
		echo "\tExist";
	}



	$dom = new DOMDocument();
	$html = @$dom->loadHTMLFile($filename);
	$dom->preserveWhiteSpace = false;


	$content = $dom->getElementById("content");

	$results = array();
	$links = $content->getElementsByTagName('a');

	if ($links->length == 0) {
		echo "no link found\n";
	} else {
	    foreach ($links as $link) {
	        $href = $link->getAttribute("href");
	        $value = trim($link->nodeValue);
	        $results[] = array("value" => $value, "href" => $href);
	    }
	}

	
	

	$output = "";
	$count = 1;
	foreach ($results as $key => $record) {
		if(trim($record['value']) != "" && $record['href'][0] != "#"){
			// echo $count." ". $record['value'] . " ( " . $record['href'] . " )\n";
			$x = $topic . " |@| " . $count." ". $record['value'] ." |@| " . $record['href'] . "\n";
			$unique[] = $record['href'];
			$output .=  $x;
			$count++;	
		}
	}

	echo "\t" .$count;

	file_put_contents($output_filename, $output);
	return $count;
}

// cat *.json > zcombined.json
?>