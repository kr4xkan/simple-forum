<?php
include($_SERVER["DOCUMENT_ROOT"]."/core/init.php");

$db = db();

if (array_key_exists("username", $_POST) && array_key_exists("password", $_POST)) {
    $q = $db->prepare("SELECT * FROM users WHERE login=?");
    $q->bind_param("s", $_POST["username"]);
    $q->execute();
    $user = $q->get_result();

    if ($user->num_rows == 1) {
        $obj = $user->fetch_assoc();
        if ($obj["password"] == md5($_POST["password"])) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user_id"] = $obj["id"];
            redirect("/index.php");
        } else {
            redirect("/login.php");
        }
    } else {
        redirect("/login.php");
    }
}
