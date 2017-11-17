const path = require('path');

module.exports = {
  make_targets: {
    win32: ['squirrel', 'zip']
  },
  electronPackagerConfig: {
    /* all: true, */
    appCategoryType: 'public.app-category.medical-software',
    appCopyright: 'Copyright (c) 2017 Magnum Foundation',
    icon: 'assets/images/favicon',
    name: 'PharmacyPOS',
    osxSign: true,
    overwrite: true,
    versionString: {
      CompanyName: 'Magnum Digital Limited Kenya',
      FileDescription: 'Pharmacy POS Desktop',
      ProductName: 'PharmacyPOS',
      InternalName: 'PharmacyPOS'
    }
  },
  // electronInstallerDMG: {
  //   background: 'assets/icons/bg-img-patients.png',
  //   debug: true,
  //   icon: 'assets/icons/favicon.icns',
  //   iconsize: 100,
  //   overwrite: true,
  //   title: 'HospitalRun',
  //   window: {
  //     size: {
  //       width: 400,
  //       height: 400
  //     }
  //   }
  // },
  electronWinstallerConfig: {
    authors: 'Magnum Digital Kenya Limited',
    exe: 'PharmacyPOS.exe',
    icon: 'assets/images/favicon',
    name: 'PharmacyPOS',
    noMSI: true,
    setupIcon: path.join(__dirname, 'assets/images/favicon.ico'),
    setupExe: 'HospitalRun.exe',
    title: 'HospitalRun'
  }
};