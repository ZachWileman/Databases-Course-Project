<?php
session_start();
include '../connect.php';

$search = $_POST['search'];
$search_tags = explode(" ", $search);
$num_tags = count($search_tags);

$sql = "SELECT PID FROM ITEMS";
$result = mysqli_query($conn, $sql);
#$i=0;
while ($row = mysqli_fetch_assoc($result)) {
	#$final_results = array(
	#	array($row['PID'], 0)
	#);
	$final_results[$row['PID']] = 0;
}

for ($i=0; $i<$num_tags; $i++) {
	echo $search_tags[$i]."<br>";

	$sql = "
	SELECT PID, COUNT(PID) AS NUM_MATCHES
	FROM ITEM_TAGS
	WHERE TAGS='".$search_tags[$i]."'
	GROUP BY PID 
	";
	$result = mysqli_query($conn, $sql);

	while ($row = mysqli_fetch_assoc($result)) {

		$final_results[$row['PID']] += 1;
	}
}

$num_items = count($final_results);
$results_found = false;
for ($i=1; $i<$num_items+1; $i++) {

	if ($final_results[$i] > 0) {
		$results_found = true;
	}
}

if ($results_found) {

	$_SESSION['search'] = $final_results;
	header("Location: ../search.php?results_found");

} else {

	header("Location: ../index.php?no_results");
}

?>