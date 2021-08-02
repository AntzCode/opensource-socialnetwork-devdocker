#!/bin/bash

# Comment-out the following line to enable the script
# echo "this script is automatically disabled after installation to prevent accidental data loss" && exit


GIT_PROJECT_URL=https://github.com/antzcode/opensource-socialnetwork.git

rm -rf www
git clone $GIT_PROJECT_URL www
chmod -R 777 ./www ./ossn_data

sed -i '4s/.*/echo "this script is automatically disabled after installation to prevent accidental data loss" \&\& exit/' ./install.sh
