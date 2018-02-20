const setupEvents = require('./windows-installer/setup-events');
if (setupEvents.handleSquirrelEvent()) {
  return;
}

const electron = require('electron');
const {
  app,
  BrowserWindow
} = electron;

let mainWindow;

function createWindow () {
  mainWindow = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#237a1b'
  });

  mainWindow.loadURL('http://192.168.8.102:9000');

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