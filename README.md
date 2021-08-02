# opensource-socialnetwork-devdocker
A docker-compose recipe for a LAMP server environment that downloads and runs the 
[AntzCode fork](https://github.com/antzcode/opensource-socialnetwork) of the [Open Source Social Network](https://github.com/opensource-socialnetwork/opensource-socialnetwork) from Github.

## How to Install and Run (Linux/Bash)

1. Download the project

```
git clone https://github.com/antzcode/opensource-socialnetwork-devdocker.git
```

2. Run the install script

```
./install.sh
```

3. Edit the .env file and put in your own strong passwords for the database

```
MARIADB_ROOT_PASSWORD=(OssnRootPassword)
MARIADB_PASSWORD=(OssnUserPassword)
```

4. Create an entry in your hosts file for the local domain

```
sudo echo "127.0.0.1 ossn.loc www.ossn.loc" >> /etc/hosts
```

5. Bring up the servers

```
./run.sh
```

6. Install OSSN through your browser at http://ossn.loc with the database credentials from the .env file:

```
host: db
db name: ossn
user: ossn
password: OssnUserPassword
```

7. Create your default OSSN administrator account and then log in

* Every time you want to run the servers, use ./run.sh
* Every time you want to stop the servers, use ./stop.sh
* ./install.sh automatically disables itself after installation to prevent data loss. 
  To Re-enable install.sh, make line 4 a comment by placing the pound symbol ("#") at the start of the line.


## How to Install and Run (Windows)

Same as on Linux, except that steps 2, 4 and 5 you need to do manually:

2. Empty the ```ossn_data``` directory, delete the ```www``` directory then download the project files into a new ```www``` directory:

```
git clone https://github.com/antzcode/opensource-socialnetwork.git www
```

4. Create an entry in your hosts file for the local domain. Add the following line to the file at *C:/Windows/System32/drivers/etc/hosts*

```
127.0.0.1 ossn.loc www.ossn.loc
```

5. Bring up the servers

```
docker-compose --env-file=.env up -d
```

* To stop the servers: ```docker-compose down```

## Known Problems

* The permissions of all webserver files (www and ossn_data directories) are publicly accessible (777)
