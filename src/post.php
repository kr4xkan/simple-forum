<?php
include "core/init.php";
include "lib/protected.php";

if (!array_key_exists("id", $_REQUEST)) {
    redirect("/");
    return;
}

$db = db();

$q = $db->prepare("
SELECT
    p.title, p.body, p.created_at, u.login AS author, u.role
FROM posts p 
    JOIN users u on u.id = p.author_id 
WHERE p.id = ?
");
$q->bind_param("i", $_REQUEST["id"]);
$q->execute();
$res = $q->get_result();
if ($res->num_rows != 1) {
    redirect("/");
    return;
}

$post = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == "POST" && array_key_exists("comment", $_POST)) {
    if (strlen($_POST["comment"]) > 1) {
        $sanitized_comment = htmlspecialchars($_POST["comment"], ENT_QUOTES);
        $q = $db->prepare("INSERT INTO comments (post_id, author_id, body) VALUES (?, ?, ?)");
        $q->bind_param("iis", $_REQUEST["id"], $_SESSION["user_id"], $sanitized_comment);
        $q->execute();

    }
}

$q = $db->prepare("
SELECT
    c.body, c.created_at, u.login AS author, u.role
FROM comments c 
    JOIN users u on u.id = c.author_id 
WHERE c.post_id = ?
ORDER BY c.created_at
");
$q->bind_param("i", $_REQUEST["id"]);
$q->execute();
$comments = $q->get_result()->fetch_all(MYSQLI_ASSOC);

?>
<?php include "templates/includes/head.php" ?>
    <link rel="stylesheet" href="/static/css/post.css">

    <div class="content">
        <h1 class="page-title"><?php echo $post["title"] ?></h1>

        <div class="thread">
            <div class="comment original">
                <div class="author">
                    <?php echo $post["author"] ?>
                    <?php if ($post["role"] != "user") echo "<br><span>".$post["role"]."</span>" ?>
                </div>
                <div class="body">
                    <p><?php echo $post["body"] ?></p>
                    <p class="created_at"><?php echo date("g.i a - j M 'y", strtotime($post["created_at"])); ?></p>
                </div>
            </div>
            <?php foreach ($comments as $c): ?>
            <div class="comment">
                <div class="author">
                    <?php echo $c["author"] ?>
                    <?php if ($c["role"] != "user") echo "<br><span>".$c["role"]."</span>" ?>
                </div>
                <div class="body">
                    <p><?php echo $c["body"] ?></p>
                    <p class="created_at"><?php echo date("g.i a - j M 'y", strtotime($c["created_at"])); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <form method="post">
            <h3>Post a comment</h3>
            <textarea name="comment" placeholder="Write your comment here..."></textarea>
            <input type="submit" value="Send">
        </form>
    </div>

<?php include "templates/includes/footer.php" ?>