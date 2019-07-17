<?php
session_start();
$cluster = Cassandra::cluster()->withContactPoints("127.0.0.1")->withDefaultConsistency(Cassandra::CONSISTENCY_LOCAL_ONE)->withPort(9042)->build();
$session   = $cluster->connect("cassandra");
$statement  = $session->prepare("SELECT * from final1");
$final_array = array();  

if(isset($_SESSION['pg'])){
	//$pg = $_SESSION['pg'];
    $options = array(
        'page_size' => 1,
        'paging_state_token'=> $_SESSION['pg']
    );
    $result = $session->execute($statement,$options);   
    foreach ($result as $row) {
        $c = $row['comment'];
		$final_array['cmnt'] = $row['comment'];
        $final_array['id1'] = $row['video_id'];
		$final_array['id2'] = $row['published_at'];
		$final_array['id3'] = $row['comment_id'];
		$final_array['id4'] = $row['sentence_id'];
    }
	
	$_SESSION['pg']= $result->pagingStateToken();     //update the session variable

    echo json_encode($final_array);
	
	//echo json_encode($c);
}
else{
	
	echo json_encode('pagingStateToken is not set');
}

//echo json_encode('retrieve141414');

?>