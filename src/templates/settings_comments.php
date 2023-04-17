<?php
$db = db();

$q = $db->query("
SELECT c.id, c.body, c.post_id, u.login AS author
FROM comments c
JOIN users u ON u.id = c.author_id
ORDER BY c.created_at DESC
");
$comments = $q->fetch_all(MYSQLI_ASSOC);
?>

<div class="view">
    <h2>Manage posts</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Author</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($comments as $c): ?>
        <tr>
            <td><?php echo $c["id"] ?></td>
            <td><a class="truncate" href="/post.php?id=<?php echo $c["post_id"] ?>"><?php echo $c["body"] ?></a></td>
            <td><?php echo $c["author"]; ?></td>
            <td><a class="action" href="/api/remove.php?model=comments&id=<?php echo $c["id"]; ?>">REMOVE</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>