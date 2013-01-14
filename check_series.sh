#!/bin/bash -x
# SCRIPT:  config_check.sh
#
# PURPOSE:  Configuraton checking script.
#
# Author: Chris Blake

APP_HOME="$( cd "$( dirname "$0" )" && pwd )"

# Source the applications configs
. $APP_HOME/tvmonkey.config



if [[ -f $FLEXCONF ]] ; then
	echo "Checking Series infomation..."
	echo
	sleep 1
	flexget -c $FLEXCONF --series | sed '$d'
fi
