const path = require('path');

module.exports = {
  make_targets: {
    win32: [ 'zip']
  },
  electronPackagerConfig: {
    appCategoryType: 'public.app-category.medical-software',
    appCopyright: 'Copyright (c) 2017 Magnum Foundation',
    icon: 'assets/images/favicon',
    name: 'pharmacy_pos',
    osxSign: true,
    overwrite: true,
    versionString: {
      CompanyName: 'Magnum Digital Limited Kenya',
      FileDescription: 'Pharmacy POS Desktop',
      ProductName: 'PharmacyPOS',
      InternalName: 'PharmacyPOS'
    }
  },
  electronWinstallerConfig: {
    authors: 'Magnum Digital Kenya Limited',
    exe: 'pharmacy_pos.exe',
    icon: 'assets/images/favicon',
    name: 'pharmacy_pos',
    noMSI: true,
    setupIcon: path.join(__dirname, 'assets/images/favicon.ico'),
    setupExe: 'pharmacy_pos.exe',
    title: 'PharmacyPOS'
  }
};