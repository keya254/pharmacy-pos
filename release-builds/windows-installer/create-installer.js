const createWindowsInstaller = require('electron-winstaller').createWindowsInstaller;
const path = require('path');

getInstallerConfig()
  .then(createWindowsInstaller)
  .catch((error) => {
    console.error(error.message || error)
    process.exit(1)
  })

function getInstallerConfig () {
  console.log('creating windows installer...')
  const rootPath = path.join('./')
  const outPath = path.join(rootPath, 'release-builds')

  return Promise.resolve({
    appDirectory: path.join(outPath, 'pharmacy-pos-win32-ia32/'),
    authors: 'Joe Nyugoh',
    noMsi: true,
    outputDirectory: path.join(outPath, 'windows-installer'),
    exe: 'pharmacy-pos.exe',
    setupExe: 'PharmacyPOSInstaller.exe',
    setupIcon: '/var/www/html/pos/assets/images/favicon.ico'
  })
}