<?php include "includes/head.php" ?>

<?php
$posts = get_posts();

$db = db();
$connected_users = $db->query("
SELECT u.login
FROM online_sessions
JOIN users u on u.id = online_sessions.user_id
WHERE last_seen > NOW() - INTERVAL 15 MINUTE
")->fetch_all();
$number_of_users = count($connected_users);
?>

    <link rel="stylesheet" href="/static/css/home.css">
    <div class="content">
        <h1 class="page-title"><span>WELCOME TO</span> <?php echo site_title() ?></h1>

        <div class="side">
            <div class="post-list">
                <div class="header">
                    <h2>Latest posts</h2>
                    <a href="/new.php">Create a new post</a>
                </div>
                <?php foreach ($posts as $p) : ?>
                <a href="/post.php?id=<?php echo $p["id"]; ?>" class="post" id="post-<?php echo $p["id"]; ?>">
                    <div class="title"><?php echo $p["title"]; ?></div>
                    <div class="preview"><?php echo truncate_body($p["body"]); ?></div>
                    <div class="date"><?php echo date("g.i a - j M 'y", strtotime($p["created_at"])); ?></div>
                    <div class="author"><?php echo $p["login"]; ?></div>
                </a>
                <?php endforeach; ?>
            </div>
            <div class="sidebar">
                <h2>Currently connected</h2>
                <p><?php echo $number_of_users; ?> user(s)</p>
                <div class="user-list">
                    <?php foreach ($connected_users as $u):
                        echo "<p>".$u[0]."</p>";
                        endforeach;?>
                </div>
            </div>
        </div>
    </div>

<?php include "includes/footer.php" ?>