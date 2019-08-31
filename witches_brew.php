<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title> Main page! </title>
    <meta charset="utf-8" />

    <link href="http://users.humboldt.edu/smtuttle/styles/normalize.css" type="text/css" rel="stylesheet" />
</head>

<body>

    <h1> Welcome to Witches Brew! </h1>
    <h2> Please Logh in! </h2>

    <?php

    if (!array_key_exists("username", $_POST)) {
        ?>

        <form method="post" action="<?= htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES) ?>">
            <fieldset>
                <legend> Please enter Oracle username/password: </legend>

                <label for="username"> Username: </label>
                <input type="text" name="username" id="username" />

                <label for="password"> Password: </label>
                <input type="password" name="password" id="password" />

                <div class="submit">
                    <input type="submit" value="Log in" />
                </div>
            </fieldset>
        </form>
    <?php
} else {

    $username = strip_tags($_POST['username']);

    $password = $_POST['password'];

    // set up connection string

    $db_conn_str =
        "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)
                                       (HOST = cedar.humboldt.edu)
                                       (PORT = 1521))
                            (CONNECT_DATA = (SID = STUDENT)))";

    $conn = oci_connect($username, $password, $db_conn_str);


    if (!$conn) {
        ?>
            <p> Could not log into Oracle, sorry </p>
        </body>

        </html>
        <?php
        exit;
    }

    $password = NULL;

    $order_query_str = 'select Item_name, order_amt, Item_price
                           from Item';
    $order_query_stmt = oci_parse($conn, $order_query_str);

    oci_execute($order_query_stmt, OCI_DEFAULT);
    ?>

    <div class="table">
        <table>
            <caption> In the Cart </caption>
            <div class="row_title">
                <tr>
                    <th scope="col"> Item </th>
                    <th scope="col"> Price </th>
                    <!--<th scope="col"> Amount </th>-->
                </tr>
            </div>

            <?php
            while (oci_fetch($order_query_stmt)) {
                $item_name = oci_result($order_query_stmt, 'ITEM_NAME');
                $order_amt = oci_result($order_query_stmt, 'ORDER_AMT');
                $item_price = oci_result($order_query_stmt, 'ITEM_PRICE');


                ?>
                <div class="rows">
                    <tr>
                        <td> <?= $item_name ?> </td>
                        <!-- <td> <?= $order_amt ?> </td>-->
                        <td> $<?= $item_price ?> </td>
                        <td> <input type="number" id="amount"> </a> </td>
                    </tr>
                </div>
            <?php
        }
        ?>
        </table>
    </div>

    <?php

    oci_free_statement($order_query_stmt);
    oci_close($conn);
}


?>

</body>

</html>