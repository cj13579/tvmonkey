#!/bin/bash -x
# SCRIPT:  tvmover.sh
#
# PURPOSE:  Main program script.
#           Sources all the function scripts and configuration files required
#			by the application. 
#			Read the arguments to script and act appropriately.

APP_HOME="$( cd "$( dirname "$0" )" && pwd )"

# Source the applications configs
. $APP_HOME/tvmonkey.config

# Source the applications functions

. $APP_HOME/functions/tvmonkey_main_functions.sh
. $APP_HOME/functions/tvmonkey_torrent_functions.sh
. $APP_HOME/functions/tvmonkey_xbmc_functions.sh
. $APP_HOME/functions/tvmonkey_misc_functions.sh
. $APP_HOME/functions/tvmonkey_flexget_functions.sh

# Read the arguments to the script and then do the right thing 

if [ "$#" -eq "1" ] ; then
   for arg in "$@" 
   do  
      case "$arg" in
	  --version)
	     show_version
	     exit 0
	     ;;
	  -h | --help )
	     show_help
	     exit 0
	     ;;
	  --info )
	     show_help
	     exit 0
	     ;;
      -c | --cron)
		 main_cron
         ;;
      -i | --interactive)
         echo "Interactive mode chosen...."
		 sleep 2
	     main
	     ;;
		-w | --web )
		main_web
		;;
	--testweb )
	   test_web
	;;
	  *)
	     echo "Usage: $0 [OPTION]. Use $0 -h, --info or --help for more information"
	     ;;
      esac
   done
else
   echo "Usage: $0 [OPTION]. Use $0 -h, --info or --help] for more information."
fi




