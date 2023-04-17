const { WebSocketServer } = require("ws");

const wss = new WebSocketServer({ host: "0.0.0.0", port: 9069 });

wss.on("connection", (ws) => {
    ws.on("error", console.error);

    ws.on("message", function message(data) {
        let obj = JSON.parse(data);
        console.log(`${obj.author} => ${obj.content}`);
        wss.clients.forEach(w => {
            w.send(data);
        });
    });
});

wss.on("listening", () => {
    console.log("Listening");
});