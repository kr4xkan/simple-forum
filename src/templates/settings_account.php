<?php
$db = db();

if (array_key_exists("username", $_POST)) {
    if (!loginExists($_POST["username"])) {
        $q = $db->prepare("UPDATE users SET login=? WHERE id=?");
        $q->bind_param("si", $_POST["username"], $_SESSION["user_id"]);
        $q->execute();
    }
}

if (array_key_exists("password", $_POST)) {
    $q = $db->prepare("UPDATE users SET password=? WHERE id=?");
    $q->bind_param("si", $_POST["password"], $_SESSION["user_id"]);
    $q->execute();
}

$q = $db->query("SELECT * FROM users WHERE id=".$_SESSION["user_id"]);
$user = $q->fetch_assoc();
?>

<div class="view">
    <h2>My account</h2>
    <div class="setting">
        <p class="label">Username</p>
        <form method="post">
            <input type="text" name="username" value="<?php echo $user["login"]; ?>" required>
            <input type="submit" value="Change">
        </form>
    </div>
    <div class="setting">
        <p class="label">Password</p>
        <form method="post">
            <input type="password" name="password" placeholder="●●●●●●●●" required>
            <input type="submit" value="Change">
        </form>
    </div>
</div>