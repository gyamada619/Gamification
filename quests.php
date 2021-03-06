<?php
    $m = new MongoClient();
    $db = $m->selectDB("gamification_db");
    $collection = new MongoCollection( $db, "users-courses");
    $collection2 = new MongoCollection( $db, "quests");
    $collection3 = new MongoCollection( $db, "courses");
    include_once "config.php";
    if (!loggedIn()){
        header("Location: /index.php");
    }
    else{
      if($_GET["course"]!=""){
        $course_under=$_GET["course"];
        $course = str_replace("_"," ",$course_under);
        $search=array('c_number' => $course);
        $courseCursor = $collection3->find($search);
        if($courseCursor->count()==0){
          header("Location: 404.php");
        }
      }
      else{
        header("Location: 404.php");
        exit;
      }
    }

    $results = array('course_id' => $course, 'user_id'=> $_SESSION["login"]);
    $cursor = $collection->find($results);
    $cursor->fields(array('user_role' => true,'_id' => false));
    //$cursor=$cursor->sort(array("title"=>1));
    $role="";
    foreach ($cursor as $doc) {
      foreach ($doc as $k => $v) {
        $role=$v;
      }
    }
    if($role!="admin"){
      $new = str_replace(" ","_",$course);
      header("Location: /courseQuests.php?course=".$new);
      exit;
    }
?>


<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <title>EduQuest | Quests</title>
      <?php include_once "headStyle.php"; ?>
  </head>
  <body class="skin-blue">

      <!-- Header Navbar and left User Sidebar
      --------------------------------------------- -->
      <?php include_once "navTemplate.php";?>
      
          <!-- Right side column. Contains the navbar and content of the page -->
          <aside class="right-side">
              <!-- Content Header (Page header) -->
              <section class="content-header">
                  <h1>
                      <?php print $course." Quests";//(Course Name) Quests ?>
                      <small>Choose wisely.</small>
                  </h1>
              </section>

              <?php 
                include_once "courseNav.php";
              ?>
                <!-- Main content -->
                <section class="content">
                	<div class="row">
                	    <div class="col-md-4" >
                	   <!-- Create New Quest, Button trigger modal -->
                	    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#createnewquest"> Create New Quest </button>

                                <!-- PHP Database Interaction -->

                                <!-- End PHP Database Interaction -->

                	       </div>
                	   </div> <!-- /row -->
                     <!-- /Create New Quest Trigger -->
                  <br>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Available Quests</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Quest</th>
                                            <th>XP</th>
                                            <th>Due Date</th>
                                            <th>Details</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>

                                        <!-- PHP to pull quest data and put in table -->
                                            <?php

                                            	$results = array('course_id' => $course);
                                            	$cursor = $collection2->find($results);
                                            	$cursor->fields(array("title" => true, 'due_date' => true, 'xp' => true, 'desc' => true, '_id' => false));
                                                $cursor=$cursor->sort(array("title"=>1));
                        												$title="";
                        												$due_date="";
                        												$xp="";
                        												$desc='';
                        												$dbid="";
                                            	foreach ($cursor as $doc) {
                                                print "<tr>";
                                            	  foreach ($doc as $k => $v) {
                        													if ($k != "desc"){
                        														if($k=="title"){
                        															$title=$v;
                        														}
                        														if($k=="due_date"){
                        															$due_date=$v;
                        														}
                        														if($k=="xp"){
                        															$xp=$v;
                        														}
                        														print "<td>$v</td>";
                        													}
                        													else{
                        														$desc=$v;
                        													}
                        													}
                                                  $title = str_replace(" ","_",$title);
                                                  $desc = str_replace(" ","_",$desc);
                                                  //print "<td>$desc</td>";

                                                print "<td><a href=\"#\"><button class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#seedetails\" data-id=$title data-due=$due_date data-xp=$xp data-desc=$desc>See Details</button></a></td>
                                                <td><a href=\"#\"><button class=\"btn btn-default btn-sm\" data-toggle=\"modal\" data-target=\"#editquest\" data-id=$title data-due=$due_date data-xp=$xp data-desc=$desc>Edit</button></a></td>
                                                <td><a href=\"#\"><button class=\"btn btn-danger btn-sm\" data-toggle=\"modal\" data-target=\"#deletequest\" data-id=$title>Delete</button></a></td>";
                                                print "</tr>";

                                            	  }


                                             ?>

                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- Delete Quest Modal -->
            <div class="modal fade" id="deletequest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteLabel">Delete Quest</h4>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete this quest forever?</p>
                  </div>
                  <div class="modal-footer">
                    <form action="deletequest.php" method="POST">
					<input type="text" id="deleteTitle" name="deleteTitle" hidden="true"></input>
          <input type="hidden" class="form-control" placeholder="course" name="course" <?php print "value='$course'";?>>
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<button type="button submit" class="btn btn-danger">Delete Quest Forever</button>
					</form>
                  </div>
                </div>
              </div>
            </div>
         <!-- /Delete Quest Modal -->

         <!-- View Details Modal -->
             <div class="modal fade" id="seedetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="detailsLabel">Quest Details</h4>
                   </div>
                   <div class="modal-body">
                     <h6>Title</h6>
                     <p id="detailsTitle">Quest Title</p>
                     <h6>XP</h6>
                     <p id="detailsXp">XXX</p>
					           <h6>Due Date</h6>
                     <p id="detailsDue"></p>
                     <h6>Description</h6>
                     <p id="detailsDesc">Details about the quest such as what it entails.</p>
                   </div>
                   <div class="modal-footer">
                   </div>
                 </div>
               </div>
             </div>
          <!-- /View Details Modal -->

         <!-- Edit Quest Modal -->
             <div class="modal fade" id="editquest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                 <div class="modal-content">
                   <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     <h4 class="modal-title" id="editLabel">Edit Quest</h4>
                   </div>

                   <div class="modal-body">
                     <!-- Create Quest Form -->
                     <form action="editquest.php" method="POST">
                      <input type="hidden" class="form-control" placeholder="course" name="course" <?php print "value='$course'";?>>
                        <div class="form-group">
                         <input type="hidden" class="form-control" placeholder="Quest Title" id="oldTitle" name="oldTitle">
                       </div>
                       <div class="form-group">
                         <label>Title</label>
                         <input type="text" class="form-control" placeholder="Quest Title" id="editTitle" name="title">
                       </div>
                       <div class="form-group">
                         <label>XP</label>
                         <input type="number" class="form-control" placeholder="100" id="editXp" name="xp">
                       </div>
                      <div class="form-group">
                         <label>Due Date</label>
                         <!-- date time picker -->
                           <input type="text" id="date-picker" class="form-control datePicker" name="due_date"></input>
                         <!-- /date time picker -->
                      </div>
                       <div class="form-group">
                         <label>Description</label>
                         <textarea class="form-control" rows="3" id="editDesc" name="desc"></textarea>
                       </div>
                     <!--</form>-->
                     <!-- /Create Quest Form -->
                   </div>
                   <div class="modal-footer">
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                     <button type="button submit" class="btn btn-primary">Save Changes</button>
                   </div>
				   </form>
                 </div>
               </div>
             </div>
          <!-- /Edit Quest Modal -->

          <!-- Create Quest Modal -->
              <div class="modal fade" id="createnewquest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel">New Quest</h4>
                    </div>
                    <div class="modal-body">
                      <!-- Create Quest Form -->
                      <form action="createquest.php" method="POST">
                        <input type="hidden" class="form-control" placeholder="course" name="course" <?php print "value='$course'";?>>
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" class="form-control" placeholder="Quest Title" name="title">
                        </div>
                        <div class="form-group">
                          <label>XP</label>
                          <input type="number" class="form-control" placeholder="100" name="xp">
                        </div>
                        <div class="form-group">
                           <label>Due Date</label>
                           <!-- date time picker -->
                             <input type="text" id="date-picker2" class="form-control" name="due_date"></input>
                           <!-- /date time picker -->
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" name="desc"></textarea>
                        </div>

                      <!-- /Create Quest Form -->
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="button submit" class="btn btn-primary">Create</button>
                    </div>

                    </form>
                  </div>
                </div>
              </div>
           <!-- /Create Quest Form Modal -->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="../js/AdminLTE/app.js" type="text/javascript"></script>
        <!-- AdminLTE for demo purposes -->
        <!-- Date-time picker -->
        <script src="../js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
          $('#date-picker').datepicker({
          });
        </script>
        <script type="text/javascript">
          $('#date-picker2').datepicker({
          });
        </script>
		<script type="text/javascript">
			$('#seedetails').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var questId = button.data('id') // Extract info from data-* attributes
			  var questDue = button.data('due')
			  var questXp = button.data('xp')
			  var questDesc = button.data('desc')
              while (questId.search("_")!=-1){
                questId=questId.replace("_"," ")
              }
              while (questDesc.search("_")!=-1){
                questDesc=questDesc.replace("_"," ")
              }
              while (questDesc.search("~")!=-1){
                    //console.log(questDesc.search("~"))
                    questDesc=questDesc.replace("~","<br/>")
                    //console.log("in loop")
                }
			  //console.log(questDesc)
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
			  var modal = $(this)
			  modal.find('#detailsLabel').text(questId)
			  modal.find('#detailsTitle').text(questId)
			  modal.find('#detailsXp').text(questXp)
			  modal.find('#detailsDesc').html(questDesc)
			  modal.find('#detailsDue').text(questDue)
			  //<!--modal.find('.modal-body input').val(recipient)-->
			});
			$('#deletequest').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var questId = button.data('id') // Extract info from data-* attributes
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              while (questId.search("_")!=-1){
                questId=questId.replace("_"," ")
                }
			  var modal = $(this)
			  modal.find('#deleteLabel').text("Delete Quest: "+questId)
			  modal.find('#deleteTitle').val(questId)
			  <!--modal.find('.modal-body input').val(recipient)-->
			});
			$('#editquest').on('show.bs.modal', function (event) {
			  var button = $(event.relatedTarget) // Button that triggered the modal
			  var questId = button.data('id') // Extract info from data-* attributes
			  var questDue = button.data('due')
			  var questXp = button.data('xp')
			  var questDesc = button.data('desc')
			  var questDbId = button.data('dbid')
              while (questId.search("_")!=-1){
                questId=questId.replace("_"," ")
              }
              while (questDesc.search("_")!=-1){
                questDesc=questDesc.replace("_"," ")
              }
              while (questDesc.search("~")!=-1){
                    //console.log(questDesc.search("~"))
                    questDesc=questDesc.replace("~","\r\n")
                    //console.log("in loop")
                }
			  var modal = $(this)
			  modal.find('#editLabel').text("Edit Quest: "+questId)
			  modal.find('#oldTitle').val(questId)
			  modal.find('#editTitle').val(questId)
			  modal.find('#editXp').val(questXp)
			  modal.find('#editDesc').val(questDesc)
			  modal.find('.datePicker').val(questDue)
			});
		</script>
    </body>
</html>
