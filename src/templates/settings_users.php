<?php
$db = db();

$q = $db->query("SELECT id, login, role FROM users");
$users = $q->fetch_all(MYSQLI_ASSOC);
?>

<div class="view">
    <h2>Manage users</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Login</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?php echo $u["id"] ?></td>
            <td><?php echo $u["login"] ?></td>
            <td><?php echo $u["role"] ?></td>
            <td class="actions">
                <?php if ($u["role"] != "admin"): ?>
                <a class="action" href="/api/mod.php?id=<?php echo $u["id"]; ?>">
                    <?php if ($u["role"] == "moderator") echo "UNMOD"; else echo "MOD" ?>
                </a>
                <a class="action" href="/api/remove.php?model=users&id=<?php echo $u["id"]; ?>">REMOVE</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>