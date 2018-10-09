<?php

    //archivo para procesar el request
    // si existe un request
    if(isset($_POST['req'])){ 

        $req=$_POST['req'];

        require_once('scheduler.php');

        $scheduler = new Scheduler($req);

    }

?>