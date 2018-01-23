**Pharmacy Plus POS Deployment Guide**
==============================

## **1. Pre-requisites**

* [Docker](https://www.docker.com/)
* [Git](https://git-scm.com/)


# **2. Deploying Pharmacy Plus POS to a Production Environment**

**Assumptions:** You should have `git`, `docker` and `docker-compose` running on your machine before the steps above can work. The instructions also assume you will be running this on a Linux machine, preferably Ubuntu LTS >=14.04

## **Step-by-Step Guide**

Follow these steps to get Pharmacy Plus POS up and running

1. Clone the repository  `git clone git@github.com:nyugoh/pharmacy-pos.git`.

2. Run `cd pharmacy-pos`. This should take you into the `pharmacy-pos` root folder. Switch to docker branch by typing `git checkout feature/docker-instance`. *Remove this when changes are merged into master branch.*

3. From this location, edit the `docker-compose.yml` file. Within the mariadb service, edit the `MARIADB_ROOT_PASSWORD` argument and replace `root` with a strong password. *Use a strong password.*

4. Save the file and run `docker-compose up --build -d`. You should wait for some few minutes or less for your environment to be up and running.If you are on linux refer to the Issues section at the bottom.

5. Go to [http://localhost/installer](http://localhost/installer) in a browser. Follow the instructions to the end. If you changed the `MARIADB_ROOT_PASSWORD` in `docker-compose.yml`, replace the default password there with what you set as the password, otherwise click next. You will finally be promoted to set the admin password.


# **Docker Containers on Pharmacy POS**

**List of Containers:**

1. Pharmacy-pos-apache - WebServer

2. Mariadb - Database Server



**Pharmacy-pos-apache**

This container contains configuration files for handling requests to the app. It listens for requests on ports 80 and 443. It's connected to the mariadb container where the database server is.

* * *


**Mariadb**

This container runs a Maria DB server and listens for requests on port 3306. On initial startup, it creates a database, and sets the root user password. All the data is persisted inside `mariadb/data` folder

* * *

**Issues**

1. If you are on Linux you have to set permissions by `chown www-data:www-data -R .`.

2. The `npm install` inside apache service Dockerfile isn't working as expected.
