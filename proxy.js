const http = require('http');
const proxy = require('http-proxy');

const options = {};

const proxyServer = proxy.createProxyServer({options});

proxyServer.on('proxyReq', function(proxyReq, req, res, options) {
  proxyReq.setHeader('X-Special-Proxy-Header', 'foobar');
});
//
// Listen for the `error` event on `proxy`.
proxyServer.on('error', function (err, req, res) {
  res.writeHead(500, {
    'Content-Type': 'text/plain'
  });

  res.end('Something went wrong. And we are reporting a custom error message.');
});

//
// Listen for the `proxyRes` event on `proxy`.
//
proxyServer.on('proxyRes', function (proxyRes, req, res) {
  console.log('RAW Response from the target', JSON.stringify(proxyRes.headers, true, 2));
});

//
// Listen for the `open` event on `proxy`.
//
proxyServer.on('open', function (proxySocket) {
  // listen for messages coming FROM the target here
  proxySocket.on('data', hybiParseAndLogMessage);
});

//
// Listen for the `close` event on `proxy`.
//
proxyServer.on('close', function (res, socket, head) {
  // view disconnected websocket connections
  console.log('Client disconnected');
});

const server = http.createServer((req, res,) =>{
  proxyServer.web(req, res, {
    target: 'http://localhost:9000'
  });
});

console.log('Listening on port 3000');
server.listen(3000);
