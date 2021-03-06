<?php
	require_once('../config.php');
	$result = file_get_contents(API_URL.GET_ALL_WORDS);    
	$result = json_decode($result);


	echo "<html>
			<head>
				<title>Perfect Pronunciation</title>
				<link href=\"./../main.css\" type=\"text/css\" rel=\"stylesheet\">
			</head>

			<body>
                    <div class=\"navBar\">
                	    | <a href=\"./../home.html\">Home</a>
                	    | <a href=\"./../quiz/quiz_mult_ad.php\">Differences in Accents & Dialect</a>
                	    | <a href=\"./../quiz/quiz_text_sa.php\">Syllable Ambiguity in Words</a>
                        | <a href=\"./../quiz/quiz_mult_sw.php\">Comparing Spoken & Written Words</a>
                        | <a href=\"./../dictionary/dictionary2.php\">Dictionary</a> |
                    </div>

				<h1>Dictionary</h1>";
	echo "<table id='dictionary' border='1' class='dictionary'>";
	echo "<tr><th> ID </th><th onclick=\"sortTable(1)\"> Word <img src=\"arrow1.png\"></th><th> Pronunciation 1 </th><th> Pronunciation 2 </th><th> Sentence </th><th onclick=\"sortTable(5)\"> Attribute <img src=\"arrow1.png\"></th></tr>";
	for($idx=0;$idx < count($result);$idx++) {
		$row = $result[$idx];
		
		if ($row->{'question_type'} == "accents_dialects") {
			$qt = "Accents & Dialect";
		} else if ($row->{'question_type'} == "syllable_ambiguity") {
			$qt = "Syllable Ambiguity"; 
		} else if ($row->{'question_type'} == "speech_vs_writing") {
			$qt = "Speech vs Writing"; 
		}
		
		if ($row -> {'correct2'} != "-") {
			echo "<tr><td>" . $row->{"id"} . "</td><td>" . $row->{"word"} . "</td><td> 
													<audio id=" . $row->{"word"} . ">
													<source src=./../audio/" . $row->{"correct1"} . ".mp3 type=\"audio/mpeg\">
														Your browser does not support the audio element.
													</audio>
													<div> 
														<button onclick=\"document.getElementById('" . $row->{"word"} . "').play()\">Play Sound</button>
													</div> </td><td> 
												
													<audio id=" . $row->{"word"} . "1>
													<source src=./../audio/" . $row->{"correct2"} . ".mp3 type=\"audio/mpeg\">
														Your browser does not support the audio element.
													</audio>
													<div> 
														<button onclick=\"document.getElementById('" . $row->{"word"} . "1').play()\">Play Sound</button>
													</div>
				</td><td>" .$row->{"sentence"} . "</td><td>" . $qt . "</td></tr>";
		} else {
			echo "<tr><td>" . $row->{"id"} . "</td><td>" . $row->{"word"} . "</td><td> 
													<audio id=" . $row->{"word"} . ">
													<source src=./../audio/" . $row->{"correct1"} . ".mp3 type=\"audio/mpeg\">
														Your browser does not support the audio element.
													</audio>
													<div> 
														<button onclick=\"document.getElementById('" . $row->{"word"}  . "').play()\">Play Sound</button>
													</div> </td><td>" . $row->{"correct2"} . "</td>
													<td>" . $row->{"sentence"}  . "</td><td>" . $qt  . "</td></tr>";
		}
	}
	echo "</table>";
echo "<script>
function sortTable(n) {
var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
table = document.getElementById(\"dictionary\");
switching = true;
// Set the sorting direction to ascending:
dir = \"asc\";
/* Make a loop that will continue until
no switching has been done: */
while (switching) {
	// Start by saying: no switching is done:
	switching = false;
	rows = table.rows;
	/* Loop through all table rows (except the
	first, which contains table headers): */
	for (i = 1; i < (rows.length - 1); i++) {
		// Start by saying there should be no switching:
		shouldSwitch = false;
		/* Get the two elements you want to compare,
		one from current row and one from the next: */
		x = rows[i].getElementsByTagName(\"td\")[n];
		y = rows[i + 1].getElementsByTagName(\"td\")[n];
		/* Check if the two rows should switch place,
		based on the direction, asc or desc: */
		if (dir == \"asc\") {
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
				// If so, mark as a switch and break the loop:
				shouldSwitch = true;
				break;
			}
		} else if (dir == \"desc\") {
			if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
				// If so, mark as a switch and break the loop:
				shouldSwitch = true;
				break;
			}
		}
	}
	if (shouldSwitch) {
			/* If a switch has been marked, make the switch
			and mark that a switch has been done: */
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
			// Each time a switch is done, increase this count by 1:
			switchcount ++;
		} else {
			/* If no switching has been done AND the direction is \"asc\",
			set the direction to \"desc\" and run the while loop again. */
			if (switchcount == 0 && dir == \"asc\") {
				dir = \"desc\";
				switching = true;
			}
		}
	}
}
</script>
			</body>
			</html>";
?>