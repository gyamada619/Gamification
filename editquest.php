<?php
    $m = new MongoClient();
    $db = $m->selectDB("gamification_db");
    $collection2 = new MongoCollection( $db, "quests");

    console.log(array("title" => $_POST["oldTitle"]));
    print($_POST["due_date"]);
    print"This is a \ntest!!!";

    $newquest=array('$set'=>array('title' => $_POST["title"], 'xp' => (int)$_POST["xp"],  'due_date' => $_POST["due_date"], 'desc' => $_POST["desc"], 'course_id'=>"DET 210"));
    $collection2->update(array("title" => $_POST["oldTitle"]),$newquest);

    //header("Location: http://gamedev.garrettyamada.com/quests.php");
?>