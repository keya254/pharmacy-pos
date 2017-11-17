const express = require('express');
var proxy = require('http-proxy-middleware');
let port = 3000;
let server = express();

// Settings
server.set('port', process.env.PORT || port);

// Log all api requests
server.get('/api/*', (req, res, next)=>{
  console.log('Api request:: %s', req.url);
  next();
})
// Middlewares
server.use('/assets', express.static(require('path').join(__dirname, 'assets')));
server.use('/docs', express.static(require('path').join(__dirname, 'docs')));
server.use('/content', express.static(require('path').join(__dirname, 'admin/content')));
server.use('/admin/assets', express.static(require('path').join(__dirname, 'admin/assets')));
server.use('/api', proxy({target: 'http://192.168.0.137', changeOrigin: true}));
server.use('/socket.io', proxy({target: 'http://192.168.0.137', changeOrigin: true}));

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
