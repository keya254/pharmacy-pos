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
    appDirectory: path.join(__dirname, '../release-builds/pharmacy-pos-win32-ia32'),
    authors: 'Joe Nyugoh',
    noMsi: false,
    outputDirectory: path.join(__dirname, '../release-builds/windows-installer'),
    exe: 'pharmacy-pos.exe',
    setupExe: 'PharmacyPOSInstaller.exe',
    setupIcon: path.join(__dirname, '../assets/images/favicon.ico')
  });
}