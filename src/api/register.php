<?php
include($_SERVER["DOCUMENT_ROOT"]."/core/init.php");

$db = db();

if (
    array_key_exists("username", $_POST) &&
    array_key_exists("password", $_POST) &&
    array_key_exists("password2", $_POST)
) {
    if ($_POST["password"] != $_POST["password2"]) {
        redirect("/register.php");
    }

    if (loginExists($_POST["username"])) {
        redirect("/register.php");
    } else {
        $hashed = md5($_POST["password"]);
        $q = $db->prepare("INSERT INTO users (login, password) VALUES (?,?)");
        $q->bind_param("ss", $_POST["username"], $hashed);
        $q->execute();

        $_SESSION["logged_in"] = true;
        $_SESSION["user_id"] = $q->insert_id;
        redirect("/index.php");
    }
}
