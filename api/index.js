import express from "express";
import helmet from "helmet";

const app = express();
app.use(helmet());
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Check
app.get(`/check`, (req, res, next) => {
  res.send("Server is running");
});
// Set
app.post(`/`, async (req, res) => {
  if (req.body.replit_db_url && req.body.method && req.body.db_key) {
    if (
      req.body.replit_db_url.trim() != "" &&
      req.body.method.trim() != "" &&
      req.body.db_key.trim() != ""
    ) {
      switch (req.body.method) {
        case "get":
          res.send(
            await fetch(`${req.body.replit_db_url}/${req.body.db_key}`).then(
              (res) => res.text(),
            ),
          );
          break;
        case "set":
          if (req.body.db_value) {
            res.send(
              await fetch(req.body.replit_db_url, {
                method: "POST",
                headers: {
                  "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `${encodeURIComponent(req.body.db_key)}=${encodeURIComponent(req.body.db_value)}`,
              }).then((res) => res.text()),
            );
          } else {
            res.status(400);
            res.send(
              JSON.stringify({
                code: 400,
                message: "missing db_value",
              }),
            );
          }
          break;
        case "delete":
          res.send(
            await fetch(`${req.body.replit_db_url}/${req.body.db_key}`, {
              method: "DELETE",
            }).then((res) => res.text()),
          );
          break;
        case "list":
          let prefix = "";
          if (req.body.db_value) {
            prefix = req.body.db_value;
          }
          res.send(
            await fetch(
              `${req.body.replit_db_url}?encode=true&prefix=${encodeURIComponent(prefix)}`,
            ).then((res) => res.text()),
          );
          break;
        default:
          res.status(400);
          res.send(
            JSON.stringify({
              code: 400,
              message: "invalid method. Only get, set, delete and list allowed",
            }),
          );
      }
    } else {
      res.status(400);
      res.send(
        JSON.stringify({
          code: 400,
          message: "missing replit_db_url, method or db_key",
        }),
      );
    }
  } else {
    res.status(400);
    res.send(
      JSON.stringify({
        code: 400,
        message: "missing replit_db_url, method or db_key",
      }),
    );
  }
});
app.use("/", (req, res, next) => {
  res.status(404); // Unknown route
  res.send("Unknown route");
});

app.listen(1337);
console.log("Server listening on port 1337");

export default app;
