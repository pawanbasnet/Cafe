<?php

function order()
{
    if ( (! array_key_exists("dept_choice", $_POST)) or
         ($_POST["dept_choice"] == "") or
         (! isset($_POST["dept_choice"])) )
    {
        session_destroy();
    }
    
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    
    $conn = hsu_conn_sess($username, $password);

    $dept_choice = htmlspecialchars(strip_tags($_POST["dept_choice"]));


    $dept_loc_str = "select dept_name, dept_loc
                     from dept
                     where dept_num = :dept_choice";

    $dept_loc_stmt = oci_parse($conn, $dept_loc_str);

    oci_bind_by_name($dept_loc_stmt, ":dept_choice", $dept_choice);
    oci_execute($dept_loc_stmt);

    oci_fetch($dept_loc_stmt);
    $chosen_name = oci_result($dept_loc_stmt, "DEPT_NAME");
    $chosen_loc = oci_result($dept_loc_stmt, "DEPT_LOC");
    oci_free_statement($dept_loc_stmt);

    $dept_empls_str = "select count(*), max(salary)
                       from dept d join empl e 
                           on d.dept_num = e.dept_num
                       where d.dept_num = :dept_choice";

    $dept_empls_stmt = oci_parse($conn, $dept_empls_str);

    oci_bind_by_name($dept_empls_stmt, ":dept_choice", $dept_choice);

    oci_execute($dept_empls_stmt);
    oci_fetch($dept_empls_stmt);

    $num_empls = oci_result($dept_empls_stmt, "COUNT(*)");
    $max_salary = oci_result($dept_empls_stmt, "MAX(SALARY)");

    oci_free_statement($dept_empls_stmt);
    oci_close($conn);

    if ($max_salary == "")
    {
        $num_empls = 0;
        $max_salary = "not applicable";
    }
    else
    {
        $max_salary = "$" . $max_salary;
    }
 
    ?>
    <h2> Information for department: <?= $chosen_name ?> </h2>
    <ul>
        <li> Location: <?= $chosen_loc ?> </li>
        <li> Number of employees: <?= $num_empls ?> </li>
        <li> Maximum salary: <?= $max_salary ?> </li>
    </ul>

    <p> <a href="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
        Start Over </a> </p>
    <?php
}
?>