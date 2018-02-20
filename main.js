const setupEvents = require('./windows-installer/setup-events');
const electron = require('electron');
if (setupEvents.handleSquirrelEvent()) {
  return;
}
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