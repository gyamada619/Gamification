<?php

$response = "";

*if(isset($_GET['action'])){
	$action = mysql_real_escape_string($_GET["action"]);
	if($action=="changeGrade"){
		$user = mysql_real_escape_string($_GET["user"]);
		$response+="_"+$user;
		$quest = mysql_real_escape_string($_GET["qid"]);
		$response+="_"+$quest;
		$grade = mysql_real_escape_string($_GET["grade"]);
		$response+="_"+$grade;
		print($response);
		//changeGrade($user,$quest,$grade);
	}
/*
function changeGrade($user,$questId,$grade){
	$m = new MongoClient();
    $db = $m->selectDB("gamification_db");
    $user_quests = new MongoCollection( $db, "users-quests");
    $cursor = $user_quests->findOne(array('_id' => new MongoId($newProgram)));
	    if($programCursor){
	     	$user=$userCollection->findOne(array('user_id' => $user, 'quest_id' => $quest_id));
	     		//array('$set'=>array(
	     	$update=array('$set'=>array('grade' => $grade, 'status' => 'graded'));
    		$userCollection->update(array('user_id' => $user, 'quest_id' => $quest_id),$update);
    		//header("Location: profile.php");
	    }
}
*/

return true;
?>