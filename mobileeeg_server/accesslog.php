<?php

  exec('tail -30 ../wwwlog/access.log', $error_logs);

  foreach($error_logs as $error_log) {

       echo "<br />".$error_log;
  }

 ?>
