<?php
include "core/init.php";
include "lib/protected.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists("title", $_POST) && array_key_exists("body", $_POST)) {
        $db = db();
        $q = $db->prepare("INSERT INTO posts (author_id, title, body) VALUES (?,?,?)");
        $q->bind_param("iss", $_SESSION["user_id"], $_POST["title"], $_POST["body"]);
        $q->execute();

        redirect("/post.php?id=".$q->insert_id);
    }
}

?>
<?php include "templates/includes/head.php" ?>

<link rel="stylesheet" href="/static/css/new.css">
<div class="content">
    <form method="post">
        <label for="title">Title</label>
        <input type="text" name="title" required>
        <label for="body">Body</label>
        <textarea name="body" rows=5 required></textarea>
        <div class="buttons">
            <a href="/index.php">Cancel</a>
            <input type="submit" value="Create post">
        </div>
    </form>
</div>

<?php include "templates/includes/footer.php" ?>