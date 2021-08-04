#!/bin/bash

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

# Comment-out the following line to enable the script
echo "this script is automatically disabled after installation to prevent accidental data loss" && exit

# TL;DR
# INSTRUCTIONS: Read the following code block and then copy/paste it into your bash terminal.
# You will be prompted to enter your password up front in order to execute the two elevated commands:

# sudo echo
# sudo echo "127.0.0.1 ossn.loc www.ossn.loc" >> /etc/hosts
# git clone https://github.com/antzcode/opensource-socialnetwork-devdocker.git ossn.loc
# cd ossn.loc
# rm -rf www database/data/* ossn_data/*
# git clone https://github.com/antzcode/opensource-socialnetwork.git www
# sudo chown -R 33:docker www ossn_data
# ./install.sh
# ./start.sh

if [ ! -f .env ]; then
    # we will copy the sample .env file for them
    cp .env.sample .env
fi

GIT_PROJECT_URL=https://github.com/antzcode/opensource-socialnetwork.git

if [ ! -f ./www/installation ]; then
    # let us download the project from Github just in case this is one who has not read the instructions at all
    rm -rf www
    git clone "${GIT_PROJECT_URL}" www

    # attempting to chown the files
    chown -R 33:docker www ossn_data
    echo ""
    echo "###################################################"
    echo "###################################################"
    echo "####                                           ####"
    echo " ##      !!!!!  Important Message  !!!!!        ##"
    echo " ##                                             ##"
    echo " ##      You may need elevated privileges       ##"
    echo " ##        to chown the webserver files         ##"
    echo " ##                                             ##"
    echo " ##        Execute the following command        ##"
    echo " ##         Before you start the server:        ##"
    echo " ##                                             ##"
    echo " ##    sudo chown -R 33:docker www ossn_data    ##"
    echo " ##                                             ##"
    echo "###################################################"
    echo "###################################################"
    echo "###################################################"
    echo ""
fi

# run the pre-install scripts
cd config/install
./run.1.auto-install.sh

# finished running install scripts
cd ../..

sed -i '16s/.*/echo "this script is automatically disabled after installation to prevent accidental data loss" \&\& exit/' ./install.sh
