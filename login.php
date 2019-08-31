<?php
function login()
{
    ?>
    <form method="post" action="<?= htmlentities(
                                    $_SERVER['PHP_SELF'],
                                    ENT_QUOTES
                                ) ?>">
        <?php
        require_once("name-pwd-fieldset.html");
        ?>
        <input type="submit" value="login" />
    </form>
<?php
}

?>