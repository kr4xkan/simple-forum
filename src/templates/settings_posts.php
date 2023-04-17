<?php
$db = db();

$q = $db->query("
SELECT p.id, p.title, p.created_at, u.login AS author
FROM posts p
JOIN users u ON u.id = p.author_id
ORDER BY p.created_at DESC");
$posts = $q->fetch_all(MYSQLI_ASSOC);
?>

<div class="view">
    <h2>Manage posts</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created at</th>
            <th>Author</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $p): ?>
        <tr>
            <td><?php echo $p["id"] ?></td>
            <td><a class="truncate" href="/post.php?id=<?php echo $p["id"] ?>"><?php echo $p["title"] ?></a></td>
            <td><?php echo date("g.i a - j M 'y", strtotime($p["created_at"])); ?></td>
            <td><?php echo $p["author"] ?></td>
            <td><a class="action" href="/api/remove.php?model=posts&id=<?php echo $p["id"]; ?>">REMOVE</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>