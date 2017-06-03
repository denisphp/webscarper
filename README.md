scraper
=======
An auto-scraper for https://habrahabr.ru/ written in PHP on Yii2 Framework.

### How it Works
------------
The script works by crawling https://habrahabr.ru/ flow pages looking for publications.
It scans all publications on each flow and if it finds any it takes URL of publication and goes by it URL grab title, html and stores to PostgreSQL.
Web scarper has console application which is scan resources in background every 2 hours looking for new publications and once a day for getting publication's version if any.
Frequency of scanning can be easily changed by changing /etc/crontab.
All available publications can be viewed by API.

### Installation
## Download and Install Vagrant
## install Vagrant plugins
```
vagrant plugin install vagrant-vbguest vagrant-cachier vagrant-hostsupdater vagrant-host-shell
```
## Install Ansible
```
sudo apt-add-repository ppa:rquillo/ansible
sudo apt-get update
sudo apt-get install ansible
```
## Install Virtual Box
## Install packages required for Network File System
```
sudo apt-get install nfs-kernel-server nfs-common portmap
```
## Run vagrant
```
cd /var/www/webscarper/
vagrant up
```

### Usage
After installation you should be able to use resources
```
http://api.webscarper.local/swagger/?url=http://api.webscarper.local/swagger.json
http://db.webscarper.local
```