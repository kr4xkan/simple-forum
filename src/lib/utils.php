<?php

function site_title() {
    static $title;
    if ($title == NULL) {
        $db = db();
        $title = $db->query("SELECT value FROM site_settings WHERE name='title'")->fetch_row()[0];
    }
    return $title;
}

function loginExists($login) {
    $q = db()->prepare("SELECT * FROM users WHERE login=?");
    $q->bind_param("s", $login);
    $q->execute();
    return $q->get_result()->num_rows == 1;
}

function hasRole($requested) {
    $q = db()->prepare("SELECT role FROM users WHERE id=?");
    $q->bind_param("i", $_SESSION["user_id"]);
    $q->execute();
    $role = $q->get_result()->fetch_row()[0];
    if ($requested == "moderator" && ($role == "moderator" || $role == "admin")) {
        return true;
    } else if ($requested == "admin" && $role == "admin") {
        return true;
    }
    return false;
}

function isLoggedIn() {
    return array_key_exists("logged_in", $_SESSION) && $_SESSION["logged_in"] == true;
}

function redirect($url) {
    header('Location: ' . $url, true, 302);
    exit();
}

function truncate_body($text) {
    if (strlen($text) > 100) {
        return substr($text, 0, 100) . "...";
    }
    return $text;
}

function update_last_seen_session() {
    $session = session_id();
    $db = db();
    $q = $db->prepare("SELECT * FROM online_sessions WHERE session_id=?");
    $q->bind_param("s", $session);
    $q->execute();
    $r = $q->get_result();

    $user_id = null;
    if (array_key_exists("user_id", $_SESSION)) {
        $user_id = $_SESSION["user_id"];
    }

    if ($r->num_rows > 0) {
        $obj = $r->fetch_assoc();
        if ($obj["user_id"] != $user_id) {
            $q = $db->prepare("UPDATE online_sessions SET user_id=?, last_seen=now() WHERE id=?");
            $q->bind_param("ii", $user_id, $obj["id"]);
        } else {
            $q = $db->prepare("UPDATE online_sessions SET last_seen=now() WHERE id=?");
            $q->bind_param("i", $obj["id"]);
        }
    } else {
        $q = $db->prepare("INSERT INTO online_sessions (session_id, last_seen, user_id) VALUES (?, now(), ?)");
        $q->bind_param("si", $session, $user_id);
    }
    $q->execute();
}

function get_posts() {
    $db = db();
    $res = $db->query("
SELECT p.id, p.title, p.body, p.created_at, u.login
FROM posts p
    JOIN users u ON p.author_id=u.id
ORDER BY p.created_at DESC
");
    return $res->fetch_all(MYSQLI_ASSOC);
}