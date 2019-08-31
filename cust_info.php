<?php

function cust_info()
{

    if ( (! array_key_exists("menu_choice", $_POST)) or
         ($_POST["menu_choice"] == "") or
         (! isset($_POST["menu_choice"])) )
    {
        destroy_session();
    }
    
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    
    $conn = hsu_conn_sess($username, $password);

    $menu_choice = htmlspecialchars(strip_tags($_POST["menu_choice"]));
?>
        <div>
            <h3> Enter your first and last name here:
            </h3>

            <label for="new_fname"> First name: </label>
            <input type="text" name="new_fname" id="new_fname"
                   required="required" />

            <label for="new_lname"> Last name: </label>
            <input type="text" name="new_lname" id="new_lname"
                   required="required" />

        <div class="submit">
            <input type="submit" value="Submit Order" />
        </div>
<?php

    $cust_str = 'begin new_orders(new_id, :new_fname, 
                                         :new_lname, menu_choice); end;';

    $cust_stmt = oci_parse($conn, $cust_str);

        $desired_new_fname = strip_tags($_POST['new_fname']);
        $desired_new_lname = strip_tags($_POST['new_lname']);

        oci_bind_by_name($cust_stmt, ":new_fname", 
                         $desired_new_fname);
        oci_bind_by_name($cust_stmt, ":new_lname",
                         $desired_new_lname);

    oci_execute($dept_loc_stmt);
    <?php
}
?>