# Pharmacy Plus POS
## An intuitive &amp; modern web based POS system
![logo](https://raw.githubusercontent.com/nyugoh/pharmacy-pos/develop/assets/images/pos-screenshot.png)

For more information visit our [website](http://magnumdigitalke.com/our-digital-services/pharmacypos/)

***

## Installation on Windows

  Requirement  
- Xampp for windows
- Node.js
- Pharmacy POS App folder

### NOTE:
1. The guide is to be used on any edition of Windows 7 or higher 32 & 64 bits.
2. When installing Node on the machine ensure that you have added the executable to the [System Environment Variables.](https://www.tutorialspoint.com/nodejs/nodejs_environment_setup.htm)

### 1. Installing XAMPP
  1. Remove any other server that might be installed on the machine like WAMP, Nginx or other windows servers, and ensure no application is using port 80, 3306 or 8080. To do that run the CMD as admin and type the following command **netstat -tpan** If the ports are free they shouldn’t appear on the output of the command.
  2. Click on the xampp executable and follow thought till the end. If everything installed successfully,  you should be presented with a simple control panel. Start apache and mysql server and go to your browser and open http://localhost and you should be servered with the default page. Click on phpmyadmin to confirm if mysql was installed.
  3. Set apache and mysql to autostart when xampp starts. Click config on the control panel and check the two services( Apache and Mysql) under the autostart of modules.
![Enable autostart for Apache and MySql](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356631242_Screenshot_20170925_191314.png)
  4. Adding xampp to startup folder. Click **Windows + R** to  open run shell then type **shell:startup** and click enter. Create a shortcut to the xampp control panel and drag it to that startup folder, if you don’t have one yet go to the startmenu and left-click on the xampp control panel and select send-to Desktop, that will add a shortcut to the desktop. Now when you restart your machine it will start Xampp and an icon will appear on the system tray.
### 2. Installing Node.js
  1. Run the nodejs installer and follow all the steps.
  2. Test if node is added to the System Environment Variable, open the terminal and run the following commands. **node -v** , this should show you the node version and **npm -v** to show the npm version.
### 3. Installing the POS
1. Getting the application
  Copy the application folder, or go to github and download the zip code of the [app](https://github.com/nyugoh/pharmacy-pos). Extract the content to the **htdocs** folder found at **C:\xampp\htdocs** . Rename the folder to **pos**. 
![The htdocs content](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356338160_Screenshot_20170925_191403.png)
![pos folder content](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356364973_Screenshot_20170925_191443.png)

2. Install dependencies. To do that, open your terminal, cmd or GIT bash should be okay, navigate to the **pos** folder and run the following command, **npm install socket.io**  
3. Enable apache modules and adjust the root folder. Now open httpd.conf and search for the following lines:
    To open httpd.conf click **config** button that’s highlighted below.
![](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356567616_Screenshot_20170925_191236.png)
  
    `proxy_wstunnel` and uncomment the line by removing the # symbol at the start of the line.
![enabling the proxy module](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356300661_Screenshot_20170925_191627.png)

    `DOCUMENTROOT` and adjust it as shown in the image below, to point to the pos folder.
![setting the document root](https://d2mxuefqeaa7sj.cloudfront.net/s_A1859D6598480832CC3A69D343D349069DED4660B00B2771E2605A3493AA4DAD_1506356280127_Screenshot_20170925_191656.png)

  Restart apache server to apply the changes, clicking the stop button and then clicking the start button again. Now go to your browser to set-up the application for the first time.


- Navigate to [localhost](http://localhost/installer) and follow the steps. Under requirements for the application, if you followed carefully, should have all of them checked except https active , which we only need if we have to go live and Application folder shouldn’t be writable, which doesn’t apply in windows environment. To proceed that way check the last item on the list and the next button will activate, then click it.
- Open another tab and navigate to [PHPMYADMIN](http://localhost/phpmyadmin) and create an new database to be used by the pos.The name of the database will be required during the installation. Now go back to the installer and fill in your mysql database credentials on the form, the database name will be the name you gave to your database. If you have not changed any settings for MySql, your host - **127.0.0.1** , **port** **3306** , **username** - **root** , **password** - (nothing -leave it blank) which are the default login credentials.
- Set any other required information till the end. Login and go to admin and Settings and set them to your liking.

***

## Installation on a Linux environment
### Server Prerequisites

Pharmacy Plus POS requires:

1. A Lamp server with PHP version>=5.4, PHP cURL & GD extensions and Apache version>=2.4.7 with modules rewrite, proxy_http and proxy_wstunnel.

    - You can enable the modules by typing the following in your terminal

    ```
        sudo a2enmod proxy_http proxy_wstunnel rewrite
        sudo apt-get install php5-curl php5-gd
        sudo service apache2 restart
    ```

    - The following virtual host snippet in your apache config, replace %*% with your values and modify to your needs.


    ```
        <VirtualHost *:443>
             DocumentRoot %/your_install_dir%
             ServerName %your.server.fqdn%

             ErrorLog ${APACHE_LOG_DIR}/error.log
             CustomLog ${APACHE_LOG_DIR}/access.log combined

             SSLEngine on
                 SSLCipherSuite !ADH:!DSS:!RC4:HIGH:+3DES:+RC4
                 SSLProtocol all -SSLv2 -SSLv3
                 SSLCertificateFile %certificate_location%
                 SSLCertificateKeyFile %key_location%
                 SSLCertificateChainFile %cert_chain_location%

             <Directory %/your_install_dir%>
                AllowOverride all
             </Directory>

             # WSPROXY CONF
             ProxyRequests Off
             ProxyPreserveHost On
             <Proxy *>
                     Order deny,allow
                     Allow from all
             </Proxy>
             RewriteEngine On
             RewriteCond %{HTTP:Connection} Upgrade [NC]
             RewriteRule /(.*) ws://localhost:8080/$1 [P,L]
             ProxyPass        /socket.io http://localhost:8080/socket.io/
             ProxyPassReverse /socket.io http://localhost:8080/socket.io/
             <Location /socket.io>
                     Order allow,deny
                     Allow from all
             </Location>
        </VirtualHost>
    ```

    Note: Using plain http is not recommended.

2. Node.js installed along with the socket.io library

    For a Debian distro:

    ```
        sudo apt-get update
        sudo apt-get install nodejs && apt-get install npm
        cd %/your_install_dir%/api
        sudo npm install socket.io
    ```

### Installation & Startup

1. Clone the latest Pharmacy Plus POS release to %your_install_dir% if you haven't done so already.
   The installation dir must be your Apache document root directory!
   
2. Run `composer install` in your install directory to update PHP dependencies (you may need to install composer first).

3. Visit /installer in your browser & follow the installation wizard.


*** 

### Deploying using docker

If you have good infrastucture, this is the preferred and easy way of running `pharmacy-pos`.

To deploy Pharmacy-Plus POS on docker follow the guide [here](https://github.com/nyugoh/pharmacy-pos/blob/feature/docker-instance/DEPLOYMENT_GUIDE.md).
