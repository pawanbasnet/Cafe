<?php
    function hsu_conn_sess($usr, $pwd)
    {
        $db_conn_str = 
            "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

        $connctn = oci_connect($usr, $pwd, $db_conn_str);
        if (! $connctn)
        {
        ?>
            <p> Could not log into Oracle, sorry. </p>
            <p> <a 
                href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
                Try again </a> 
            </p>
            <?php
            session_destroy();
            exit;        
        }
        return $connctn;
    }
?>