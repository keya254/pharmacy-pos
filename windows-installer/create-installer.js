const createWindowsInstaller = require('electron-winstaller').createWindowsInstaller;
const path = require('path');

getInstallerConfig()
  .then(createWindowsInstaller)
  .catch((error) => {
    console.error(error.message || error);
    process.exit(1);
  });

function getInstallerConfig () {
  console.log('Creating windows installer...');
  return Promise.resolve({
    appDirectory: path.join(__dirname, '../release-builds/pharmacy-pos-win32-x64'),
    authors: 'Magnum Digital Limited Kenya',
    noMsi: true,
    outputDirectory: path.join(__dirname, '../release-builds/windows-installer'),
    exe: 'Pharmacy-pos.exe',
    setupExe: 'Pharmacy Plus Pos x64.exe',
    setupIcon: path.join(__dirname, '../assets/images/favicon.ico'),
    loadingGif: path.join(__dirname, '../assets/images/gif/pacman.gif')
  });
}
