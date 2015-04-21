<?php
include_once("config.php");
if(loggedIn()){
  header('Location: dashboard.php');
}
if(isset($_POST["submit"])){
	if(!($_POST["password"] == $_POST["password2"])){
	 print "<p>Your passwords did not match</p>";
  }
	else{
    $query = $coll->findOne(array('_id' => $_POST['login']));
  	if(empty($query)){
  	 	newUser($_POST["login"], $_POST["name"], $_POST["password"]);
  	 	cleanMemberSession($_POST["login"], $_POST["password"]);
  	 	header("Location: members.php");
    }
  	else{
  	  print '<p>Username already exists, please choose another username.</p>';
  	}
  }
}
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>Registration</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">

            <div class="header">EduQuest</div>
            <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">

                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="login" class="form-control" placeholder="ACU ID" 
                        value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"maxlength="6">
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Your name" 
                        value="<?php print isset($_POST["name"]) ? $_POST["name"] : "" ; ?>"maxlength="25">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password2" class="form-control" placeholder="Re-enter Password"/>
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn bg-primary btn-block">Sign Me Up</button>
                </div>
            </form>

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>


<!--Old html-->
<!--
<html>
<head>
  <title>Simple Authentication with MongoDB</title>
</head>
<body>
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
  <table>
  <tr>
    <td>
      Login:
    </td>
    <td>
      <input type="text" name="login" value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"maxlength="15">
    </td>
  </tr>
  <tr>
    <td>
	  Password:
    </td>
	<td>
      <input type="password" name="password" value="" maxlength="15">
    </td>
  </tr>
  <tr>
    <td>
      Confirm password:
    </td>
    <td>
      <input type="password" name="password2" value="" maxlength="15">
    </td>
  </tr>
  <tr>
    <td>
      &nbsp;
	</td>
    <td>
      <input name="submit" type="submit" value="Submit">
    </td>
  </tr>
</table>
</form>
</body>
</html>-->