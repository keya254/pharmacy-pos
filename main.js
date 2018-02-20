const setupEvents = require('./windows-installer/setup-events');
if (setupEvents.handleSquirrelEvent()) {
  return;
}

const electron = require('electron');
const exec = require('child_process').exec;
const {
  app,
  BrowserWindow
} = electron;

let mainWindow;
exec('php -S localhost:9000 -t . router.php');

function createWindow () {
  mainWindow = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#237a1b'
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