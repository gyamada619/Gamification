<div class="col-xs-12">
  <div class="box">
    <div class="box-body table-responsive no-padding" style="overflow:scroll;">
        <table class="table table-bordered table-hover">
        <thead>
            <tr><!--
                <th>Quest</th>
                <th>XP</th>
                <th>Due Date</th>
                <th>Details</th>
                <th>Accept</th> -->
            <th style="text-align:center; vertical-align:middle; width:75px;">Users</th>
            <?php
            foreach ($questCursor as $doc) { //Turn cursor (results) human readable
              $title;
              $exp;
              print('<th style="text-align:center; width:75px;">');
              foreach ($doc as $k => $v) {
                //print($k.": ".$v);
                //print('<br/>');
                if($k=='title'){
                  $title = $v;
                }elseif($k=='xp'){
                  $exp=$v;
                }
              }
              print($title."<br/>".$exp." xp</th>");
            }

            for ($i = 0; $i <= 5; $i++) {
                print("<th>Overflow Test</th>");
            }

            ?>


            </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
</div>