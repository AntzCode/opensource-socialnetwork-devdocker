<!--
  ###################################################################################
  ##    Open Source Social Network - AntzCode DevDocker Automated Installer        ##
  ##                                                                               ##
  ##    @package   AntzCode                                                        ##
  ##    @author    AntzCode Ltd                                                    ##
  ##    @copyright (C) AntzCode Ltd                                                ##
  ##    @license   GPLv3 https://raw.githubusercontent.com/AntzCode/               ##
  ##                         opensource-socialnetwork-devdocker/main/LICENSE       ##
  ##    @link      https://github.com/AntzCode/opensource-socialnetwork-devdocker  ##
  ##                                                                               ##
  ###################################################################################
-->
# opensource-socialnetwork-devdocker
A docker-compose recipe for a LAMP server environment that downloads and runs the 
[AntzCode fork](https://github.com/antzcode/opensource-socialnetwork) 
of the [Open Source Social Network](https://github.com/opensource-socialnetwork/opensource-socialnetwork) 
from Github.

## How to Install and Run

It's quite easy to install and run this recipe for [docker-compose](https://docs.docker.com/compose/install/). 

All you have to do is GIT clone, run the installation script, and chown the files. 

After that you can run OSSN with ```./start.sh``` and stop it with ```./stop.sh```.  

* **Don't forget to check the settings in the ```.env``` file!**

## TL;DR instructions (for Ubuntu/Linux)

### Optional prerequisite: 

Instead of http://localhost you can set it up as http://osn.loc

Only execute this line once because you don't want to keep appending the same routes to your hosts file:
```
sudo echo "127.0.0.1 ossn.loc www.ossn.loc" >> /etc/hosts
```
You can view your hosts file by typing ```more /etc/hosts```

### Installing the Servers:

It is easy to install OSSN Dev Docker like this:
```
git clone https://github.com/antzcode/opensource-socialnetwork-devdocker.git ossn.loc
cd ossn.loc
./install.sh
sudo chown -R 33:docker www ossn_data
```
To start the servers:
```
./start.sh
```

To stop the servers:

```
./stop.sh
```

## Detailed Instructions (Linux/Windows/Mac)

**1. Create an entry in your hosts file for the local domain.** 

This enables your browser to find the web server at http://ossn.loc 
even though it isn't a registered domain name.

#### (Linux/Mac)
```
sudo echo "127.0.0.1 ossn.loc www.ossn.loc" >> /etc/hosts
# or
sudo nano /etc/hosts
```

* make sure the following line is in /etc/hosts
```
127.0.0.1 ossn.loc www.ossn.loc
```

#### (Windows)

Right-click and "Edit as Administrator" on the hosts file: 
*C:/Windows/System32/drivers/etc/hosts* 
and add the following line to it:
```
127.0.0.1 ossn.loc www.ossn.loc
```

**2. Download the project**

This will clone the devdocker project from Github into a folder named ```ossn.loc```. 
You then need to clear any existing data in the database and checkout the 
[AntzCode/opensource-socialcommerce](https://github.com/AntzCode/opensource-socialnetwork) project 
to the www folder:

```
git clone https://github.com/antzcode/opensource-socialnetwork-devdocker.git ossn.loc
cd ossn.loc
rm -rf www database/data/*
git clone https://github.com/antzcode/opensource-socialnetwork.git www
```

**3. Chown the files**

This enables a Linux user to work with the files that the webserver has made. 
Windows and Mac users might be able to skip this step.

* note: your user must be a member of the docker group, which it probably already is 
  if you have configured Docker correctly.

```
sudo chown -R 33:docker ossn_data www
```

**4. (optional): Edit the .env file and put in your own values**

The ```.env``` file contains default settings for a rapid deployment of the stack.
You will need to create the ```.env``` file by copy and rename of the ```.env.sample``` file.
```
# eg:
ADMIN_USERNAME=          (your username)
ADMIN_PASSWORD=          (your password)
MARIADB_PASSWORD=        (your password)
MARIADB_ROOT_PASSWORD=   (your password)
```

**5. Run the installation script**

#### (For Linux)
```
./install.sh
```

**6. To start the servers**

#### Bash script (Linux/Mac)
```
./start.sh
```

#### Manually (Windows/Linux/Mac)

```
docker-compose --env-file=.env up -d
```

**7. To stop the servers**

#### Bash script (Linux/Mac)
```
./stop.sh
```

#### Manually (Windows/Linux/Mac)

```
docker-compose down
```

**8. Install OSSN through your browser at http://ossn.loc/installation**

### Notes:

* To run the servers: ```./run.sh```
* To stop the servers: ```./stop.sh```
* Default Administrator credentials:
  * admin
  * password
  * admin@ossn.loc
* ```./install.sh``` automatically disables itself after installation to prevent data loss. 
  To Re-enable install.sh, make line 16 a comment by placing a # (the pound symbol) at the start of the line.

## Known Problems

### Linux File Permissions

Linux has strict handling of file ownership and permissions of all webserver files. 
When the user is logged in to an account on the host computer, that is a different user than 
the user that is running the server in the Docker container. 

This means that all files in www and ossn_data directories should be owned by www-data or 33 (that is the username/id of
the web server user on the Docker container) and the files should have at least 755 permissions. 

If you add any files to the /www directory, you should chown them: 

```
chown -R 33:docker _the_path_you_added_
```

### PHP does not copy Directories across Volumes

See Issue #1. Since the ossn_data and www directories are in separate directories, 
they are seen by PHP as being on different volumes. 

There is a known [bug in PHP](https://bugs.php.net/bug.php?id=54097) that means 
the ```rename``` function doesn't copy directories from one volume to another. 
OSSN is presently relying on PHP's ```rename``` function to copy uploaded themes and components 
from the ```ossn_data/tmp``` directory to the ```www/components``` directory.

This results in failed uploads of components and themes. For this reason, the ossn_data directory
is configured as a subdirectory of www, which is ok for a development server but 
**this configuration should not be used on a production server**.
