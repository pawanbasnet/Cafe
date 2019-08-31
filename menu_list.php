
<?php
function menu_list()
{

    if ( (! array_key_exists("username", $_POST)) or
         (! array_key_exists("password", $_POST)) or
         ($_POST["username"] == "") or
         ($_POST["password"] == "") or
         (! isset($_POST["username"])) or
         (! isset($_POST["password"])) )
    {
        session_destroy();
    }

    $username = strip_tags($_POST["username"]);

    
    $password = $_POST["password"];

    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;


    $conn = hsu_conn_sess($username, $password);

    $order_query_str = 'select Item_id, Item_name, Item_price
                           from Item';
    $order_query_stmt = oci_parse($conn, $order_query_str);

    oci_execute($order_query_stmt);
    ?>
    <form class="content" method="post"
          action="<?= htmlentities($_SERVER['PHP_SELF'], 
                                   ENT_QUOTES) ?>">      
        <div class= item>
            <h2> What would you like to order? </h2>
            <!--<select name="menu_choice"> -->
            <?php
            while (oci_fetch($order_query_stmt))
            {
                $item_id = oci_result($order_query_stmt, 'ITEM_ID');
                $item_name = oci_result($order_query_stmt, 'ITEM_NAME');
                $item_price = oci_result($order_query_stmt, 'ITEM_PRICE');


                ?>               
                <div class="flavor">
                <tr>
                    <td> <?= $item_name ?> </td>
                    <td> $<?= $item_price ?> </td>
                    <td> <input type="number" id="amount"> </a> </td>
                </tr>
            </div>
                <?php
            }
            ?>
        </div>
        <input type="submit" value="Confirm Order" />        
    </form>

    <?php
    oci_free_statement($order_query_stmt);
    oci_close($conn);
}
?>