
CREATE TABLE IF NOT EXISTS `auth` (
  `id` INTEGER NOT NULL,
  `username` varchar(256) NOT NULL,
  `name` varchar(66) NOT NULL DEFAULT '',
  `password` varchar(256) NOT NULL,
  `token` varchar(64) NOT NULL DEFAULT '',
  `uuid` char(16) NOT NULL,
  `admin` int(1) NOT NULL,
  `disabled` int(1) NOT NULL DEFAULT 0,
  `permissions` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
);


INSERT INTO `auth` (`id`, `username`, `name`, `password`, `token`, `uuid`, `admin`, `disabled`, `permissions`) VALUES
  (1, 'admin', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', '', '', 1, 0, ''),
  (2, 'staff', 'staff', '1562206543da764123c21bd524674f0a8aaf49c8a89744c97352fe677f7e4006', '', '5346788d0a8ae', 0, 0, '{"sections":{"access":"yes","dashboard":"realtime","reports":0,"graph":0,"sales":1,"invoices":1,"items":1,"stock":1,"suppliers":1,"customers":1},"apicalls":["adminconfig\/get","stats\/general","graph\/general","stock\/get","stock\/history","suppliers\/get","invoices\/get"]}');


CREATE TABLE IF NOT EXISTS `config` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `data` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ;



INSERT INTO `config` (`id`, `name`, `data`) VALUES
  (1, 'general', '{"version":"1.4.0","dateformat":"d\\/m\\/y","currencyformat":" Kshs~2~.~,~0","accntype":"cash","bizname":"Magnum Digital Limited","biznumber":"9999 999 999","bizemail":"info@magnumdigitalke.com","bizaddress":"1 Some St","bizsuburb":"Someville","bizstate":"NSW","bizpostcode":"2000","bizcountry":"Kenya","bizlogo":"\\/assets\\/images\\/receipt-logo.png","bizicon":"\\/icon.ico","gcontact":0,"gcontacttoken":"","altlabels":{"cash":"Cash","credit":"Credit","eftpos":"Eftpos","mpesa":"Mpesa","deposit":"Deposit","tendered":"Tendered","change":"Change","transaction-ref":"Transaction Ref","sale-time":"Sale Time","subtotal":"Subtotal","total":"Total","item":"Item","items":"Items","refund":"Refund","void-transaction":"Void Transaction"}}'),
  (2, 'pos', '{"rectemplate":"receipt","recline2":"Your business simplified","recline3":"an application by Magnum Softwares","reclogo":"\\/assets\\/images\\/receipt-logo-mono.png","recprintlogo":true,"reccurrency":"","reccurrency_codepage":"0","recemaillogo":"\\/assets\\/images\\/receipt-logo.png","recfooter":"Thanks for shopping with us!","recqrcode":"https:\\/\\/wallaceit.com.au","salerange":"week","saledevice":"location","priceedit":"blank","cashrounding":"5", "negative_items":false}'),
  (3, 'invoice', '{"defaulttemplate":"invoice","defaultduedt":"+2 weeks","payinst":"Please contact us for payment instructions","emailmsg":""}'),
  (4, 'accounting', '{"xeroenabled":0,"xerotoken":"","xeroaccnmap":""}'),
  (5, 'templates', '{"invoice":{"name":"Default Invoice","type":"invoice","filename":"invoice.mustache"},"invoice_mixed":{"name":"Mixed Language","type":"invoice","filename":"invoice_mixed.mustache"},"invoice_alt":{"name":"Alternate Language","type":"invoice","filename":"invoice_alt.mustache"},"receipt":{"name":"Default Receipt","type":"receipt","filename":"receipt.mustache"},"receipt_mixed":{"name":"Mixed Language","type":"receipt","filename":"receipt_mixed.mustache"},"receipt_alt":{"name":"Alternate Language","type":"receipt","filename":"receipt_alt.mustache"}}');


CREATE TABLE IF NOT EXISTS `customers` (
  `id` INTEGER NOT NULL ,
  `email` varchar(128) NOT NULL,
  `name` varchar(66) NOT NULL,
  `phone` varchar(66) NOT NULL,
  `mobile` varchar(66) NOT NULL,
  `address` varchar(192) NOT NULL,
  `suburb` varchar(66) NOT NULL,
  `postcode` varchar(12) NOT NULL,
  `state` varchar(66) NOT NULL,
  `country` varchar(66) NOT NULL,
  `notes` varchar(2048) NOT NULL DEFAULT '',
  `googleid` varchar(1024) NOT NULL,
  `pass` varchar(512) NOT NULL DEFAULT '',
  `token` varchar(256) NOT NULL DEFAULT '',
  `activated` int(1) NOT NULL DEFAULT 0,
  `disabled` int(1) NOT NULL DEFAULT 0,
  `lastlogin` datetime NULL DEFAULT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `customer_contacts` (
  `id` INTEGER NOT NULL ,
  `customerid` INTEGER NOT NULL,
  `name` varchar(128) NOT NULL,
  `position` varchar(128) NOT NULL,
  `phone` varchar(66) NOT NULL,
  `mobile` varchar(66) NOT NULL,
  `email` varchar(128) NOT NULL,
  `receivesinv` int(1) NOT NULL,
  PRIMARY KEY (`id`)
);



CREATE TABLE IF NOT EXISTS `devices` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `locationid` INTEGER NOT NULL,
  `data` varchar(2048) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `device_map` (
  `id` INTEGER NOT NULL ,
  `deviceid` INTEGER NOT NULL,
  `uuid` varchar(64) NOT NULL,
  `ip` varchar(66) NOT NULL,
  `useragent` varchar(256) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `locations` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `disabled` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `sales` (
  `id` INTEGER NOT NULL ,
  `ref` varchar(128) NOT NULL,
  `type` varchar(12) NOT NULL,
  `channel` varchar(12) NOT NULL,
  `data` varchar(16384) NOT NULL,
  `userid` INTEGER NOT NULL,
  `deviceid` INTEGER NOT NULL,
  `locationid` INTEGER NOT NULL,
  `custid` INTEGER NOT NULL,
  `discount` decimal(4,0) NOT NULL,
  `rounding` decimal(10,2) NOT NULL DEFAULT 0,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL,
  `processdt` bigint(20) NOT NULL,
  `duedt` bigint(20) NOT NULL DEFAULT 0,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `sale_history` (
  `id` INTEGER NOT NULL ,
  `saleid` INTEGER NOT NULL,
  `userid` INTEGER NOT NULL,
  `type` varchar(66) NOT NULL,
  `description` varchar(256) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `sale_items` (
  `id` INTEGER NOT NULL ,
  `saleid` INTEGER NOT NULL,
  `storeditemid` INTEGER NOT NULL,
  `saleitemid` varchar(12) NOT NULL,
  `qty` INTEGER NOT NULL,
  `name` varchar(66) NOT NULL,
  `description` varchar(128) NOT NULL,
  `taxid` varchar(11) NOT NULL,
  `tax` varchar(2048) NOT NULL,
  `tax_incl` int(1) NOT NULL DEFAULT 1,
  `tax_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit_original` decimal(12,2) NOT NULL DEFAULT 0.00,
  `unit` decimal(12,2) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `refundqty` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `sale_payments` (
  `id` INTEGER NOT NULL ,
  `saleid` INTEGER NOT NULL,
  `method` varchar(32) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `processdt` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `sale_voids` (
  `id` INTEGER NOT NULL ,
  `saleid` INTEGER NOT NULL,
  `userid` INTEGER NOT NULL,
  `deviceid` INTEGER NOT NULL,
  `locationid` INTEGER NOT NULL,
  `reason` varchar(1024) NOT NULL,
  `method` varchar(32) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `items` varchar(2048) NOT NULL,
  `void` int(1) NOT NULL,
  `processdt` bigint(128) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `stock_history` (
  `id` INTEGER NOT NULL ,
  `stockitemid` INTEGER NOT NULL,
  `locationid` INTEGER NOT NULL,
  `auxid` INTEGER NOT NULL,
  `auxdir` int(1) NOT NULL,
  `type` varchar(66) NOT NULL,
  `amount` INTEGER NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `stock_items` (
  `id` INTEGER NOT NULL ,
  `stockinventoryid` INTEGER NOT NULL,
  `stocklevel` INTEGER NOT NULL,
  `expiryDate` VARCHAR(30) NOT NULL,
  `cost` VARCHAR(30) NOT NULL,
  `price` VARCHAR(30) NOT NULL,
  `code` VARCHAR(30) NOT NULL,
  `inventoryNo` VARCHAR(30) NOT NULL,
  `data` VARCHAR(2048) NOT NULL,
  `locationid` INTEGER NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `stock_inventory` (
  `id` INTEGER NOT NULL ,
  `storeditemid` INTEGER NOT NULL,
  `supplierid` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
);


CREATE TABLE IF NOT EXISTS `stored_items` (
  `id` INTEGER NOT NULL ,
  `data` varchar(2048) NOT NULL,
  `categoryid` INTEGER NOT NULL,
  `name` varchar(66) NOT NULL,
  `description` varchar(66) NOT NULL,
  `reorderPoint` INTEGER NOT NULL,
  `stockType` INTEGER  NOT NULL,
  `taxid` INTEGER NOT NULL,
  PRIMARY KEY (`id`)
) ;


CREATE TABLE IF NOT EXISTS `stored_suppliers` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `stored_suppliers` (`id`, `name`) VALUES(1, 'GENERAL');


CREATE TABLE IF NOT EXISTS `stored_categories` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `dt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

INSERT INTO `stored_categories` (`id`, `name`) VALUES(1, 'GENERAL');

CREATE TABLE IF NOT EXISTS `tax_items` (
  `id` INTEGER NOT NULL ,
  `name` varchar(66) NOT NULL,
  `altname` varchar(66) NOT NULL,
  `type` varchar(12) NOT NULL,
  `value` varchar(8) NOT NULL,
  `multiplier` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ;

INSERT INTO `tax_items` (`id`, `name`, `altname`, `type`, `value`, `multiplier`) VALUES
  (1, 'VAT', 'VAT',  'standard', '16', '0.16');

CREATE TABLE IF NOT EXISTS `tax_rules` (
  `id` INTEGER NOT NULL ,
  `data` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `tax_rules` (`id`, `data`) VALUES
  (1, '{"name":"No Tax", "inclusive":true, "mode":"single", "base":[], "locations":{}, "id":"1"}'),
  (2, '{"name":"VAT", "inclusive":true, "mode":"single", "base":[1], "locations":{}, "id":"2"}');