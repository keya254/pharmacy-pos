const setupEvents = require('./windows-installer/setup-events');
const electron = require('electron');
const server = require('./server');

if (setupEvents.handleSquirrelEvent()) {
  // squirrel event handled and app will exit in 1000ms, so don't do anything else
  return;
}
const {
  app,
  BrowserWindow
} = electron;

app.on('ready', ()=>{
  let win = new BrowserWindow({
    width:1200,
    height: 800,
    backgroundColor: '#237a1b'
  });
  win.once('ready-to-show', () => {
    win.show();
  });
  win.loadURL('http://localhost:3000');
});
