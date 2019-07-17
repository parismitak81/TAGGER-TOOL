<?php
		$comment = $_GET['comment'];
		$id11 = $_GET['id1'];
		$id12 = $_GET['id2'];
		$id13 = $_GET['id3'];
		$id14 = (int)$_GET['id4'];
		$cluster = Cassandra::cluster()->withContactPoints("127.0.0.1")->withDefaultConsistency(Cassandra::CONSISTENCY_LOCAL_ONE)->withPort(9042)->build();
		$session   = $cluster->connect("cassandra");


		try{
			$session->execute("UPDATE final1 SET ass_cmt = ? WHERE video_id = ? AND published_at = ? AND comment_id = ? AND sentence_id = ?",array('arguments' => array($comment, $id11, $id12, $id13, $id14)));
			//echo json_encode('succ');
			echo 'succ';
		} 
		catch (Exception $e){
			//echo json_encode('error');
			echo 'error';
		}
		
?>
