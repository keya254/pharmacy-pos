const express = require('express');
var proxy = require('http-proxy-middleware');
var bodyParse = require('body-parser');
var exec = require('child_process').exec;

let port = 3000;
let server = express();

// Settings
server.set('port', process.env.PORT || port);
exec('php -S localhost:9000');
// server.use(bodyParse.json());
// server.use(bodyParse.urlencoded({extended: true}));

// Log all api requests
var endPoint = '';
server.all('/api/:reqType', function(req, res, next){
  endPoint = req.params.reqType;
  console.log('Api request:: ', endPoint);
  next();
});

// Middlewares
server.use('/assets', express.static(require('path').join(__dirname, 'assets')));
server.use('/docs', express.static(require('path').join(__dirname, 'docs')));
server.use('/content', express.static(require('path').join(__dirname, 'admin/content')));
server.use('/admin/assets', express.static(require('path').join(__dirname, 'admin/assets')));
server.use('/api', proxy({
  target: 'http://localhost:9000',
  changeOrigin: true,
  pathRewite: {'/api' : '/api/wpos.php?a='+endPoint}
}));
// server.use('/socket.io', proxy({target: 'http://35.224.196.185/', changeOrigin: true}));

function onProxyReq(proxyReq, req, res) {
  if (req.body) {
    let bodyData = JSON.stringify(req.body);
    // incase if content-type is application/x-www-form-urlencoded -> we need to change to application/json
    proxyReq.setHeader('Content-Type','application/json');
    proxyReq.setHeader('Content-Length', Buffer.byteLength(bodyData));
    // stream the content
    proxyReq.write(bodyData);
  } else {
    console.log('no body..')
  }
}

function onProxyRes(proxyReq, req, res) {
  console.log('Data returned');
  console.log(res);
}

// var options = {
//   target: endPoint,
//   changeOrigin: true,
//   onProxyReq: onProxyReq,
//   onProxyRes: onProxyRes
// };

// server.use('/api', proxy(options));

// Routes
server.get('/', function(req, res, next){
  res.sendFile(__dirname + '/index.html');
});


server.get('/wpos.appcache', (req, res, next)=>{
  res.sendFile(__dirname + '/wpos.appcache');
});

server.get('/admin', (req, res, next)=>{
  res.sendFile(__dirname + '/admin/index.html');
});

// Start server
server.listen(server.get('port'), ()=>{
  console.log('Server is running...');
});