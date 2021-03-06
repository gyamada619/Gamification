<?php
    include_once "config.php"; //Connecting to database and handling auth.
    $passMiss=false;
    if (loggedIn()){
        header("Location: dashboard.php");
    }
    else{
        if(isset($_POST["submit"])){
          if(!($row = checkPass($_POST["userid"], $_POST["password"]))){
            $passMiss=true;
          }
          else{
              cleanMemberSession($_POST["userid"]);
              header("Location: dashboard.php");
          }
      }
    }
?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>DETXP | Log in</title>
        <?php include_once "headStyle.php"; ?>

    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">

            <div class="header">DET<sup>XP</sup> Sign-In</div>
            <form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">

                <div class="body bg-gray">
                    <?php
                        if($passMiss){
                            print "<div class='alert alert-danger' align='center'><b>Incorrect Information. Please Try Again.</b></div>";
                        }
                    ?>
                    <div class="form-group">
                        <input type="text" name="userid" class="form-control" placeholder="ACU Username"
                        value="<?php print isset($_POST["userid"]) ? $_POST["userid"] : "" ; ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer" align="center">
                    <button type="submit" name="submit" class="btn btn-primary btn-block" style="width:46%; display:inline-block;">Sign In</button>
                    <div style="width:5%; display:inline-block;"></div>
                    <button type="button" class="btn btn-primary" onClick="location.href='/signUp.php';"
                        style="width:46%; display:inline-block;">Create Account</button><br/>
                    <!-- <button type="submit" name="submit" class="btn bg-primary btn-block" style="width:45%;">Sign me in</button> -->
                    <a href="/forgotPassword.php">Forgot Password?</a>
                </div>
            </form>

        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>
