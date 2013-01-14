#!/bin/bash
# SCRIPT:  tvmonkey_flexget_functions.sh
#
# PURPOSE: Functions for the operation of Flexget from within TVMonkey 
#          
#

FLEXGET="/usr/local/bin/flexget"

function flexget ()
{
	echo "Invoking flexget..."
	a=$($FLEXGET -c $FLEXCONF)
}

function flexget_cron ()
{
	a=$($FLEXGET --cron -c $FLEXCONF)
}

function flexget_web ()
{
	echo "Running Flexget...";
	
    a=$($FLEXGET -c $FLEXCONF 2>&1 | tee -a /tmp/flexgetresults);
	
	if [[ -f "/tmp/flexgetresults" ]] ; then
		cat '/tmp/flexgetresults' | while read LINE1
		do
			if [[ $LINE1 = *"VERBOSE  details"*"Summary"* ]] ; then
				a=$(echo $LINE1 | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$a"
				sleep 1
			fi
		done
	fi
	
	if [[ -f "/tmp/flexgetresults" ]] ; then
		a=$(rm -f /tmp/flexgetresults)
	fi
}

function flexget_web_test ()
{
	echo "Running Flexget in test mode...";
	
    a=$($FLEXGET --test -c $FLEXCONF 2>&1 | tee -a /tmp/flexgetresults);
	
	if [[ -f "/tmp/flexgetresults" ]] ; then
		cat '/tmp/flexgetresults' | while read LINE1
		do
			if [[ $LINE1 = *"VERBOSE  details"*"Summary"* ]] ; then
				a=$(echo $LINE1 | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$a"
				sleep 1
			fi
		done
	fi
	
	if [[ -f "/tmp/flexgetresults" ]] ; then
		a=$(rm -f /tmp/flexgetresults)
	fi
}
