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

docker-compose --env-file=.env up -d
