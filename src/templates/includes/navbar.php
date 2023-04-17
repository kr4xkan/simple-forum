<?php
function active($t) {
    $activeUrl = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    if ($t == $activeUrl) {
        echo "class=\"active\"";
    }
}
?>
<nav>
    <div class="left">
        <div class="title"><?php echo site_title() ?></div>
        <a href="/index.php" <?php active("index.php") ?>>HOME</a>
        <a href="/about.php" <?php active("about.php") ?>>ABOUT</a>
        <?php if (isLoggedIn()) : ?>
        <a href="/chat.php" <?php active("chat.php") ?>>CHAT</a>
        <a href="/settings.php" <?php active("settings.php") ?>>SETTINGS</a>
        <?php endif; ?>
    </div>
    <?php if (isLoggedIn()) :
        $user = db()->query("SELECT login FROM users WHERE id = ".$_SESSION["user_id"])->fetch_assoc();
    ?>

    <div class="profile">
        Connected as <b><?php echo $user["login"] ?></b>
        <a href="/api/logout.php">LOGOUT</a>
    </div>
    <?php else : ?>
    <div class="login">
        <a href="/login.php" <?php active("login.php") ?>>Login</a>
        <a href="/register.php" <?php active("register.php") ?>>Register</a>
    </div>
    <?php endif; ?>
</nav>