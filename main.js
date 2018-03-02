const setupEvents = require('./windows-installer/setup-events');
if (setupEvents.handleSquirrelEvent()) {
  return;
}

const electron = require('electron');
const child = require('child_process').exec;
const {
  app,BrowserWindow
} = electron;

let mainWindow;
let cmd = "C:\\POS\\php\\php -S localhost:9000 -t C:\\POS-old\\pharmacy-pos C:\\POS-old\\pharmacy-pos\\router.php";
// let cmd = "php -S localhost:9000 -t . router.php";

child(cmd, function (err, data) {
  if(err) console.log(err);
  if(data) console.log(data);
});

function createWindow () {
  mainWindow = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#ffffff'
  });

  mainWindow.loadURL('http://localhost:9000');

  mainWindow.on('closed', function () {
    mainWindow = null
  });
}

app.on('ready', createWindow);

app.on('window-all-closed', function () {
  if (process.platform !== 'darwin') {
    app.quit()
  }
});

app.on('activate', function () {
  if (mainWindow === null) {
    createWindow()
  }
});
