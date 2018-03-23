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
// let cmd = "C:\\POS\\php\\php -S localhost:9000 -t C:\\POS\\pharmacy-pos C:\\POS\\pharmacy-pos\\router.php";// let cmd = "php -S localhost:9000 -t . router.php"; // Linux or mac
let cmd = "php -S localhost:9000 -t . router.php"; // Linux or mac

child(cmd, function (err, data) {
  if(err){
      const fs = require('fs');
      fs.open('C:\\POS\\logs.txt', 'a+', (error, fd) => {
          if (error) console.log(error);
          fs.writeFile(fd, err, (err) =>{
              if (err) console.log(err);
          });
      });
  }
  if(data){
      const fs = require('fs');
      fs.open('C:\\POS\\logs.txt', 'a+', (err, fd) => {
          if (err) console.log(err);
          fs.writeFile(fd, data, (err) =>{
              if (err) console.log(err);
          });
      });
  }
});

function createWindow () {
  mainWindow = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#ffffff',
    webPreferences: {
      nativeWindowOpen: true
    }
  });

  mainWindow.loadURL('http://localhost:9000');

  mainWindow.on('closed', function () {
    mainWindow = null
  });

  mainWindow.webContents.on('new-window', (event, url, frameName, disposition, options, additionalFeatures) => {
    if (frameName === 'modal') {
      // open window as modal
      event.preventDefault();
      Object.assign(options, {
        modal: true,
        parent: mainWindow
      });
      event.newGuest = new BrowserWindow(options)
    }
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
