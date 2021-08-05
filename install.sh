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
# echo "this script is automatically disabled after installation to prevent accidental data loss" && exit


############################################################
# TL;DR -- how to use this file:
############################################################
#
#   Read the help section for details:
#     ./install.sh -h
#
#   The easiest way is to run it with the -a flag. This creates an entry in
#    the hosts file, downloads the project and chowns the files:
#      ./install.sh -a
#
#   Start the servers like this:
#      ./start.sh
#
#   Stop the servers like this:
#      ./stop.sh
#
############################################################


############################################################
# Print the help
############################################################

Help()
{
	# Display Help
	echo " ## "
	echo " ##  Installs Open Source Social Network on the AntzCode DevDocker."
	echo " ## "
	echo " ##       Syntax: ./install.sh [-h|v|V|a|c|m|u]"
	echo " ## "
	echo " ##       Example:     ./install.sh -av    "
	echo " ## "
	echo " ##       Options:"
	echo " ## "
	echo " ##   h   Print this Help.    "
  echo " ##   v   Verbose mode.    "
  echo " ##   V   Print software version.    "
	echo " ##   a   Automatic installation. * (requires elevated privileges)"
	echo " ##        - Adds entries to the hosts file if not already exists"
	echo " ##          and chowns the files."
	echo " ##        - Is not the inverse of -m    "
	echo " ##   c   Chown the files.        * (requires elevated privileges)    "
	echo " ##   m   Manual setup.    "
	echo " ##        - Does not install the Automated Installer but instead"
  echo " ##          keeps OSSN's default two-step setup forms.    "
	echo " ##   u   URL to the repository."
	echo " ##        - Default: $GIT_PROJECT_URL"
	echo " ##        - Some options might not work with other repositories.    "
	echo " ## "
}


############################################################
# Print Verbose output
############################################################
log()
{
	if [ "$1" == "v" ]; then
		if [ "$doVerbose" == "true" ]; then
			echo "$2"
		fi
	fi
}


############################################################
############################################################
###                                                      ###
###               Main program begins                    ###
###                                                      ###
############################################################
############################################################

# The file that will be extracted into /www
GIT_PROJECT_URL=https://github.com/antzcode/opensource-socialnetwork.git

# The hosts file on the host OS
HOSTS_FILE=/etc/hosts

# The local domains where the installation will run
HOSTS_DOMAIN="ossn.loc www.ossn.loc"

# IP of localhost for routing in the hosts file
HOSTS_IP="127.0.0.1"


############################################################
# Process the input options
############################################################

# Initialize switch conditions
doAuto=false
doHosts=false
doChown=false
doManual=false
doVerbose=false
hasSudo=false
requiresElevatedPrivileges=false

# Get the options
while getopts ":vhVacmu:" option; do
   case $option in
      v) # verbose output
         doVerbose=true
         ;;
      h) # display Help
         Help
         exit;;
      V) # display software version
         echo "AntzCode OSSN Dev Docker Installer v1.0 - 2021"
         exit;;
      a) # automatic
         doAuto=true
         doHosts=true
         doChown=true
         requiresElevatedPrivileges=true
         echo -n "You have chosen the automatic installation. "
         ;;
      c) # do the chown
         if [ "$doAuto" == "false" ]; then
	         doChown=true
		 requiresElevatedPrivileges=true
		 echo -n "You have chosen to chown the files. "
         fi
         ;;
      m) # manual setup process
         doManual=true
         log v "Manual setup process (using the default OSSN configuration forms)"
         ;;
      u) # enable a custom GIT url
         GIT_PROJECT_URL=$OPTARG
         ;;
      \?) # Invalid option
         echo "Error: Invalid option"
         exit;;
   esac
done


############################################################
# Obtain elevated privileges
############################################################

if [ "$requiresElevatedPrivileges" == "true" ]; then
	# need to check if they have elevated privileges
	echo "Elevated privileges are required."
	if sudo true; then
		# has already logged in with sudo
		hasSudo=true
	else
		echo 'Will not proceed while having insufficient privileges. Try to remove the flags :)'
		exit 1
	fi
fi


############################################################
# Add entry to hosts file
############################################################

if [ "$doHosts" == "true" ]; then
	if ! grep --quiet "$HOSTS_DOMAIN" "$HOSTS_FILE"; then
		log v "adding entry to $HOSTS_FILE"
		echo "## AntzCode/opensource-socialnetwork-devdocker begin " | sudo tee -a "$HOSTS_FILE" > /dev/null
		echo "$HOSTS_IP	$HOSTS_DOMAIN" | sudo tee -a "$HOSTS_FILE" > /dev/null
		echo "## AntzCode/opensource-socialnetwork-devdocker end " | sudo tee -a "$HOSTS_FILE" > /dev/null
	else
		log v "There is already an entry for $HOSTS_DOMAIN in $HOSTS_FILE, so no changes were made to it."
	fi 
fi


############################################################
# Create default .env file
############################################################

if [ -f .env ]; then
	log v "An .env file exists already, we will use that."
else
	# we will copy the sample .env file for them
	log v "Creating .env from .env.sample..."
	cp .env.sample .env
fi


############################################################
# Install the project files
############################################################

if [ ! -f ./www/installation ]; then
	# let us download the project from Github just in case this is one who has not read the instructions at all

	log v "www/installation directory does not exist, therefore the project will be downloaded."
	log v "deleting the www directory..."

	if [ "$hasSudo" == "true" ]; then 
		sudo rm -rf www
	else
		rm -rf www
	fi

	git clone "${GIT_PROJECT_URL}" www

	if [ "$doChown" == "true" ]; then
		# attempting to chown the files
		log v "Chowning the files..."
		sudo chown -R 33:docker www ossn_data
	else
		# tell them that they need to chown the files
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
fi


############################################################
# Configure Automated Installer
############################################################

if [ "$doManual" == "false" ]; then
	
	log v "Configuring AntzCode automated installer..."

	# install the AntzCode automated installer scripts
	cd config/install
	source ./install-automated-installer.sh

	# finished running install scripts
	cd ../..

fi


############################################################
# Finish
############################################################

log v "Installation finished, now disabling the install script..."

sed -i '16s/.*/echo "this script is automatically disabled after installation to prevent accidental data loss" \&\& exit/' ./install.sh

echo "All done."
log v "You can start the server like this: ./start.sh"
log v "You can stop the server like this: ./stop.sh"
log v "You can even create a custom launcher to do this with a mouse click!"
echo "To run this installer again, you will need to re-enable it by changing line 16 into a comment."

