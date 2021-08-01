# opensource-socialnetwork-devdocker
Docker for running a development environment for Open Source Social Network

```
sudo echo "127.0.0.1 ossn.loc www.ossn.loc" >> /etc/hosts
```

or edit the file at /etc/hosts (C:/Windows/System32/drivers/etc/hosts on a Windows machine) and insert the following line there:

```
opensource-socialnetwork-devdocker
```

Then run docker:


```
docker-compose up -d
```

Open your browser and navigate to http://ossn.loc/installation
