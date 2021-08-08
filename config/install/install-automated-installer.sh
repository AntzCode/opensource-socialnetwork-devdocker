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

# a function to search for tokens in a string and replace them with values
replaceMyVar(){
	ENVVAR_VAL=$(grep ${i} ../../.env | xargs)
	IFS='=' read -ra ENVVAR_VAL <<< "$ENVVAR_VAL"
	SEARCH_VAL=":|$1|:"
	REPLACEMENT_VAL="${ENVVAR_VAL[1]}"
	if [ `echo "${REPLACEMENT_VAL}" | grep '/'` ]; then
		# use @ for delimeter if value contains /
		RESULT=$(echo "$2" | sed "s@$SEARCH_VAL@$REPLACEMENT_VAL@g")
		echo "$RESULT"
	else
		# default delimiter is /
		RESULT=$(echo "$2" | sed "s/$SEARCH_VAL/$REPLACEMENT_VAL/g")
		echo "$RESULT"
	fi
}

# let us declare an array of all the tokens that are available in the .env file
VARS=(MARIADB_DATABASE MARIADB_PASSWORD MARIADB_USER MARIADB_HOST WEBSITE_NAME CONTACT_EMAIL OSSN_DATA_DIRECTORY
ADMIN_FIRSTNAME ADMIN_LASTNAME ADMIN_EMAIL ADMIN_USERNAME ADMIN_PASSWORD ADMIN_BIRTH_DAY ADMIN_BIRTH_MONTH ADMIN_BIRTH_YEAR ADMIN_GENDER)

log v "Compiling settings from .env into the Automated Installation Template files..."
SETTINGS_FILE_CONTENTS=$(cat ./install-automated-installer/settings.php)
ACCOUNT_FILE_CONTENTS=$(cat ./install-automated-installer/account.php)
INSTALLED_FILE_CONTENTS=$(cat ./install-automated-installer/installed.php)

for i in "${VARS[@]}"
do
    SETTINGS_FILE_CONTENTS=$(replaceMyVar "${i}" "$SETTINGS_FILE_CONTENTS")
    ACCOUNT_FILE_CONTENTS=$(replaceMyVar "${i}" "$ACCOUNT_FILE_CONTENTS")
    INSTALLED_FILE_CONTENTS=$(replaceMyVar "${i}" "$INSTALLED_FILE_CONTENTS")
done

# write the compiled files
echo "$SETTINGS_FILE_CONTENTS" > ./install-automated-installer/settings-compiled.php
echo "$ACCOUNT_FILE_CONTENTS" > ./install-automated-installer/account-compiled.php
echo "$INSTALLED_FILE_CONTENTS" > ./install-automated-installer/installed-compiled.php

# create backup of original OSSN files before we replace them
log v "Creating backups of the default OSSN installation template files..."
mv ../../www/installation/pages/settings.php ../../www/installation/pages/settings.orig.php
mv ../../www/installation/pages/account.php ../../www/installation/pages/account.orig.php
mv ../../www/installation/pages/installed.php ../../www/installation/pages/installed.orig.php

# replace the original install pages with the auto-submitting forms
log v "Replacing the OSSN installation templates with the compiled Automated Installer templates..."
cp ./install-automated-installer/settings-compiled.php ../../www/installation/pages/settings.php
cp ./install-automated-installer/account-compiled.php ../../www/installation/pages/account.php
cp ./install-automated-installer/installed-compiled.php ../../www/installation/pages/installed.php
cp ./install-automated-installer/cleanup.php ../../www/installation/pages/cleanup.php

# copy the logo files to OSSN installer directory
cp ./install-automated-installer/logo.svg ../../www/installation/styles/antzcode-logo.svg
cp ./install-automated-installer/background.svg ../../www/installation/styles/antzcode-background.svg

# cleanup temp files
log v "Removing temporary files..."
rm ./install-automated-installer/settings-compiled.php
rm ./install-automated-installer/account-compiled.php
rm ./install-automated-installer/installed-compiled.php

