#!/bin/bash
# SCRIPT:  tvmonkey_xbmc_functions.sh
#
# PURPOSE: Functions for the operation of the TVMonkey XMBC utilites
#          
#

function xbmc_updater_cron ()
{
#Update XBMC library if any new content found
if [[ -f maildo ]]; then
	for LIB in $LIBRARY
	do
		wget --user=xbmc --password=0000 -t1 -T3 'http://$LIB:8080/xbmcCmds/xbmcHttp?command=ExecBuiltIn&parameter=XBMC.updatelibrary(video)' &> /dev/null
		sleep 30
	done
fi
}

function xbmc_updater ()
{
#Update XBMC library if any new content found


if [[ -f maildo ]]; then
	echo "We have downloaded some new shows. Do you want me to update your XBMC libraries? [y | yes]"
	read ans
	case $ans in
		yes | y)
		for LIB in $LIBRARY
		do
			echo "Updating XBMC Library on $LIB..."
    		wget --user=xbmc --password=0000 -t1 -T3 'http://$LIB:8080/xbmcCmds/xbmcHttp?command=ExecBuiltIn&parameter=XBMC.updatelibrary(video)' &> /dev/null
    		sleep 30
    	done
		;;
		*)
		echo "Not updating any libraries."
		;;
	esac
fi
}

function xbmc_updater_web ()
{
#Update XBMC library if any new content found

if [[ -f maildo ]]; then
	echo "We have downloaded some new shows...."
		for LIB in $LIBRARY
		do
			echo "Updating XBMC Library on $LIB..."
    		wget --user=xbmc --password=0000 -t1 -T3 'http://$LIB:8080/xbmcCmds/xbmcHttp?command=ExecBuiltIn&parameter=XBMC.updatelibrary(video)' &> /dev/null
    		sleep 10
    	done
fi
}

function xbmc_updater_web_test ()
{
#Update XBMC library if any new content found

if [[ -f maildo ]]; then
	echo "We have downloaded some new shows...."
	for LIB in $LIBRARY
	do
		echo "Would update XBMC Library on $LIB..."
    		sleep 2
    	done
fi
}
