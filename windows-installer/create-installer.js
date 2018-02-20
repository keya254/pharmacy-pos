const createWindowsInstaller = require('electron-winstaller').createWindowsInstaller;
const path = require('path');

getInstallerConfig()
  .then(createWindowsInstaller)
  .catch((error) => {
    console.error(error.message || error);
    process.exit(1);
  });


function getInstallerConfig () {
  console.log('creating windows installer...');
  const rootPath = './';
  const outPath = path.join(rootPath, 'release-builds');

  return Promise.resolve({
    appDirectory: path.join(rootPath, 'release-builds/pharmacy-pos-win32-ia32'),
    authors: 'Magnum Digital Limited Kenya',
    noMsi: true,
    outputDirectory: path.join(outPath, 'windows-installer'),
    exe: 'pharmacy-pos.exe',
    setupExe: 'PharmacyPOSInstaller.exe',
    setupIcon: path.join(rootPath, 'assets/images/favicon.ico')
  });
  //   return Promise.resolve({
  //   appDirectory: '../release-builds/pharmacy-pos-win32-ia32',
  //   authors: 'Magnum Digital Limited Kenya',
  //   noMsi: true,
  //   outputDirectory: '../windows-installer',
  //   exe: 'pharmacy-pos.exe',
  //   setupExe: 'PharmacyPOSInstaller.exe',
  //   setupIcon: '../assets/images/favicon.ico'
  // })
}


// const electronInstaller = require('electron-winstaller');
// const path = require('path');
//
// var settings = {
//     appDirectory: path.join(__dirname, '../release-builds/pharmacy-pos-win32-ia32'),
//     authors: 'Magnum Digital Limited Kenya',
//     noMsi: true,
//     outputDirectory: path.join(__dirname, '../windows-installer'),
//     exe: 'pharmacy-pos.exe',
//     setupExe: 'PharmacyPOSInstaller.exe',
//     setupIcon: path.join(__dirname, '../assets/images/favicon.ico'),
//     name: 'pharmacy_pos'
// };

// resultPromise = electronInstaller.createWindowsInstaller(settings);

// resultPromise.then(() => {
// console.log("Created");
// }, (e) => {
// console.log(e.message);
// });

// const msi = require('electron-wix-msi');
// const { MSICreator } = msi;
//
// // Step 1: Instantiate the MSICreator
// const msiCreator = new MSICreator({
//   appDirectory: path.join(__dirname, '../release-builds/pharmacy-pos-win32-ia32'),
//   description: 'Modern Web based POS',
//   exe: 'pharmacy_pos',
//   name: 'Pharmacy_Pos',
//   manufacturer: 'Magnum Digital Limited Kenya',
//   version: '1.0.2',
//  outputDirectory: path.join(__dirname, '../windows-installer')
// });

// // Step 2: Create a .wxs template file
// msiCreator.create().then( ()=> {
//   // Step 3: Compile the template to a .msi file
//    msiCreator.compile();
// });

// await;