<?php
session_start();
$cluster = Cassandra::cluster()->withContactPoints("127.0.0.1")->withDefaultConsistency(Cassandra::CONSISTENCY_LOCAL_ONE)->withPort(9042)->build();
$session   = $cluster->connect("cassandra");
$statement  = $session->prepare("SELECT * from final1");
$options = array('page_size' => 1);
$result    = $session->execute($statement,$options);
$_SESSION['pg']= $result->pagingStateToken();
//var_dump($_SESSION['pg']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>TAGGER TOOL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type = "text/javascript">
	function retrieve(){
		console.log('succ121212');
		$.getJSON({
			type:"GET",
			url:"RETRIEVE.php",
			success: function (response){
				console.log('succ3323231');
				console.log(response);
				//$("#main2").remove();
				console.log(response['cmnt']);
				console.log(response['id1']);
				console.log(response['id2']);
				console.log(response['id3']);
				console.log(response['id4']);
				var cmt = response['cmnt'];
				var id = response['id1'];
				var pa = response['id2'];
				var cid = response['id3'];
				var sid = response['id4'];
				$('#first_text_id1').text(cmt);
				$('#id_field1').text(id);	
				$('#id_field').val(id);
				$('#id_field2').val(pa);
				$('#id_field3').val(cid);
				$('#id_field4').val(sid);
			},
			error: function(response){
				console.log('error1');
				console.log(response);
			}
		});	
		console.log('end121212');
	}


	function submit1(cmt, id, pa, cid, sid){
		$.ajax({
			type:"GET",
			url:"SERVER.php",
			data: {  
				'comment' : cmt,
				'id1': id,
				'id2': pa,
				'id3': cid,
				'id4': sid
			},
			//async: false,
			success: function (html){
				console.log('succ1111');
				console.log(html);
				retrieve();									
			},
			error: function(html){
				console.log('error');
				console.log(html);
			}
        });	
	}


	$(document).ready( function(){
		$("#btn_id").click(function(e){
			e.preventDefault();
			if($('#first_text_id').val()){
				var cmt = $('#first_text_id').val();	
				var id = $('#id_field').val();
				var pa = $('#id_field2').val();
				var cid = $('#id_field3').val();
				var sid = $('#id_field4').val();
				console.log(cmt, id, pa, cid, sid);
				submit1(cmt, id, pa, cid, sid);
				alert('Comment Inserted');
	        }	
	        else{
				alert('Comment Skipped');
	        	retrieve();
	        		}
		});		
	});
</script>
</head>

<body>
<p><center>
<img src="IIT_Guwahati_Logo.jpg.png" alt="IIT_Guwahati_Logo" width="150" height="150">
</p>

  <div class="main">
    <div class="header">TAGGER TOOL</div>
    <form id="frmBox" action="#">
		
		<?php
			foreach($result as $value){
				$ID = $value['video_id'];
				$pa = $value['published_at'];
				$c_id = $value['comment_id'];
				$s_id = $value['sentence_id'];
				$cmnt = $value['comment'];
				//echo '<div id="main2">';
				echo '<span id="id_field1">'.$ID.'</span>: <span id="first_text_id1">'.$cmnt.'</span>';				
				echo '<input id="first_text_id" type="text" class="inp" placeholder="Translation" required>';
				echo '<input id="id_field" type="text" value="'.$ID.'" hidden>';
				echo '<input id="id_field2" type="text" value="'.$pa.'" hidden>';
				echo '<input id="id_field3" type="text" value="'.$c_id.'" hidden>';
				echo '<input id="id_field4" type="text" value="'.$s_id.'" hidden>';
				//echo '</div>';
				echo '<input type="submit" value="Submit" class="sub-btn" id="btn_id">';
			}
			?>
      	
      <h3 id="success"></h3>
	  <?php
	  ?>
    </form>
  </div>
</body>
</html>