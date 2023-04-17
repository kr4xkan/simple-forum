<?php include "core/init.php"; ?>
<?php include "lib/protected.php" ?>
<?php include "templates/includes/head.php" ?>

<?php
$db = db();
$q = $db->query("SELECT * FROM users WHERE id=".$_SESSION["user_id"]);
$user = $q->fetch_assoc();
?>

<link rel="stylesheet" href="/static/css/chat.css">
<div class="chat">
    <div class="feed">
        <div class="scroll" id="message-container">
        </div>
    </div>
    <form id="form">
        <input type="text" name="message" id="form-message" placeholder="Send a message on the live chat" required>
        <input type="submit" value="Send">
    </form>
</div>

<script type="application/javascript">
    let form = document.getElementById("form");
    let formMessage = document.getElementById("form-message");
    let messageContainer = document.getElementById("message-container");
    let ws = new WebSocket("ws://localhost:9069");

    ws.addEventListener("open", (e) => {
        console.log("connected");
        form.onsubmit = (ev) => {
            ev.preventDefault();
            console.log("send message");
            ws.send(JSON.stringify({
                author: "<?php echo $user["login"]; ?>",
                content: formMessage.value
            }));
            formMessage.value = "";
        }
    });

    ws.addEventListener("message", async (e) => {
        let data = JSON.parse(await e.data.text());
        messageContainer.insertAdjacentHTML("beforeend", `
<div class="message">
    <p class="author">${data.author}</p>
    <p class="content">${data.content}</p>
</div>
        `);
    });
</script>

<?php include "templates/includes/footer.php" ?>