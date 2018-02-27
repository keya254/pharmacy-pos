const setupEvents = require('./windows-installer/setup-events');
if (setupEvents.handleSquirrelEvent()) {
  return;
}

const electron = require('electron');
const path = require('path');
const child = require('child_process').exec;
const {
  app,
  BrowserWindow
} = electron;

let mainWindow;
let cmd = "C:\\POS\\php\\php -S localhost:9000 -t . C:\\POS\\pharmacy-pos-win32-x64\\router.php";

let proc = child(cmd, function (err, data) {
  if(err){
    console.log(err);
  }
  if(data){
    console.log(data);
  }

});

let PID = proc.PID;
let killCmd = ' /pid ' + PID + ' /F';

function createWindow () {
  mainWindow = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#237a1b'
  });

  mainWindow.loadURL('http://localhost:9000');

  mainWindow.on('closed', function () {
    child('taskkill', killCmd);
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
