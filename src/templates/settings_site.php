<?php
$db = db();

if (array_key_exists("title", $_POST)) {
    $q = $db->prepare("UPDATE site_settings SET value=? WHERE name='title'");
    $q->bind_param("s", $_POST["title"]);
    $q->execute();
}

?>

<div class="view">
    <h2>Manage the website</h2>
    <div class="setting">
        <p class="label">Site title</p>
        <form method="post">
            <input type="text" name="title" value="<?php echo site_title() ?>" required>
            <input type="submit" value="Change">
        </form>
    </div>
</div>