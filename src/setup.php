<?php
include "core/db.php";
include "lib/utils.php";

$db = db();
$q = $db->query("SELECT value FROM site_settings WHERE name='is_setup'");
$is_setup = $q->fetch_row()[0] == 1;

if ($is_setup) {
    redirect("/index.php");
}

if (
        array_key_exists("title", $_POST) &&
        array_key_exists("login", $_POST) &&
        array_key_exists("password", $_POST) &&
        array_key_exists("password2", $_POST)
) {
    if ($_POST["password"] != $_POST["password2"]) {
        redirect("/setup.php");
    }

    $hashed = md5($_POST["password"]);
    $q = $db->prepare("INSERT INTO users (login, password, role) VALUES (?,?,'admin')");
    $q->bind_param("ss", $_POST["login"], $hashed);
    $q->execute();

    $q = $db->prepare("UPDATE site_settings SET value=? WHERE name='title'");
    $q->bind_param("s", $_POST["title"]);
    $q->execute();

    $q = $db->query("UPDATE site_settings SET value='1' WHERE name='is_setup'");

    redirect('/index.php');
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/css/normalize.css">
    <link rel="stylesheet" href="/static/css/base.css">
    <link rel="stylesheet" href="/static/css/setup.css">
    <title>Setting up</title>
</head>
<body>
<div class="content">
    <h1 class="page-title">Setup your forum</h1>
    <form method="post">
        <label for="title">Forum's name</label>
        <input type="text" name="title" placeholder="Your super forum" required>

        <label for="login">Admin login</label>
        <input type="text" name="login" placeholder="root" required>

        <label for="password">Admin password</label>
        <input type="password" name="password" placeholder="A_V3RY-str0nG=p4ssW0rd!" required>

        <label for="password2">Admin password confirmation</label>
        <input type="password" name="password2" placeholder="A_V3RY-str0nG=p4ssW0rd!" required>

        <input type="submit" value="Finish setup">
    </form>
</div>
</body>
</html>