<?php include "core/init.php"; ?>
<?php include "lib/protected.php"; ?>
<?php include "templates/includes/head.php" ?>

<?php
$valid_views = ["account", "users", "posts", "comments", "site"];
$view = "account";
if (array_key_exists("view", $_REQUEST)) {
    if (in_array($_REQUEST["view"], $valid_views)) {
        $view = $_REQUEST["view"];
    }
}

function active_view($t) {
    global $view;
    if ($t == $view) {
        echo "class=\"active\"";
    }
}
?>

<link rel="stylesheet" href="/static/css/settings.css">
<div class="content">
    <h2>Settings</h2>
    <div class="split">
        <div class="sidebar">
            <a href="?view=account" <?php active_view("account"); ?>>My account</a>
            <?php if (hasRole("moderator")): ?>
            <a href="?view=posts" <?php active_view("posts"); ?>>All posts</a>
            <a href="?view=comments" <?php active_view("comments"); ?>>All comments</a>
            <?php endif; ?>
            <?php if (hasRole("admin")): ?>
            <a href="?view=users" <?php active_view("users"); ?>>All users</a>
            <a href="?view=site" <?php active_view("site"); ?>>Site settings</a>
            <?php endif; ?>
        </div>
        <div class="main">
            <?php include("templates/settings_".$view.".php"); ?>
        </div>
    </div>
</div>

<?php include "templates/includes/footer.php" ?>