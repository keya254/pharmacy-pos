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
// server.use('/api', proxy({target: 'http://0.0.0.0:9000/api/wpos.php', changeOrigin: true}));
// server.use('/socket.io', proxy({target: 'http://35.224.196.185/', changeOrigin: true}));

server.all('/api/:reqType', function(req, res, next){
	if (req.body) {
        let bodyData = JSON.stringify(req.body);
        // incase if content-type is application/x-www-form-urlencoded -> we need to change to application/json
        proxy.setHeader('Content-Type','application/json');
        proxy.setHeader('Content-Length', Buffer.byteLength(bodyData));
        // stream the content
        proxy.write(bodyData);
    }
	var endPoint = 'http://0.0.0.0:9000/api/wpos.php?a='+req.params.reqType;
	console.log(endPoint);
  server.use('/api', proxy({target: endPoint, changeOrigin: true}));
  	res.end();
});


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
