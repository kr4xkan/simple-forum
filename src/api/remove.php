<?php
include $_SERVER["DOCUMENT_ROOT"]."/core/init.php";
include $_SERVER["DOCUMENT_ROOT"]."/lib/protected.php";

if (!array_key_exists("model", $_REQUEST) || !array_key_exists("id", $_REQUEST)) {
    redirect("/settings.php");
}

$allowed_models = ["users", "posts", "comments"];
if (!in_array($_REQUEST["model"], $allowed_models)) {
    redirect("/settings.php");
}

if ($_REQUEST["model"] == "users" && $_REQUEST["id"] == $_SESSION["user_id"]) {
    redirect("/settings.php");
}

$db = db();
$q = $db->prepare("DELETE FROM ".$_REQUEST["model"]." WHERE id=?");
$q->bind_param("s", $_REQUEST["id"]);
$q->execute();

redirect("/settings.php?view=".$_REQUEST["model"]);