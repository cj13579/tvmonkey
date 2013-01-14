#!/bin/bash
# SCRIPT:  tvmonkey_misc_functions.sh
#
# PURPOSE: Functions for the operation of the TVMonkey
#          
#

function show_version ()
{
   echo ""
   echo "+-------------------------------------------------+"
   echo "| You are currently using TVMonkey version: 0.4.0 |"
   echo "+-------------------------------------------------+"
   echo ""
}


function show_help ()
{
	echo ""
	echo "Usage: $0 [OPTION] ."
	echo "-c or --cron : Use this option when running TVMonkey in batch mode. This supresses much of the program logging. "
	echo "-i or --interactive : Use this option to run the programs and have messages shown to the StdOut."
	echo "--info -h or --help to show this information."
	echo ""
}

function mail_cron ()
{
	
	#Create the email
	if [ -f message.txt ] ; then
	cat $APP_HOME/mail message.txt > message
	#Send an email to notify that some shows have been downloaded and updated
		mail=$(/usr/sbin/ssmtp $EMAIL < message)
	fi
}

function housekeeping_cron ()
{
	# Tidy up all the temp files that we have made
	# Needs re-working so that it only deletes files that have actually been created 
	# based on which functions have been called and how far they got.
		
	if [ -f maildo ] ; then
		a=$(rm maildo)
	fi
	if [ -f message.txt ] ; then
		a=$(rm message.txt)
	fi
	if [ -f message ] ; then
		a=$(rm message)
	fi
	if [ -f downloads.tmp ] ; then
		a=$(rm downloads.tmp)
	fi
	if [ -f xbmcHttp?command=Exec* ] ; then
		a=$(rm xbmcHttp?command=Exec*)
    fi
}

function mail ()
{
	
	#Create the email
	cat $APP_HOME/mail message.txt > message
	#Send an email to notify that some shows have been downloaded and updated
	if [[ -f maildo ]]; then
		echo "We have downloaded some new shows. Do you want me to email you? [y | yes]"
		read ans
		
		case $ans in
		'y' | 'yes')
                echo "Sending mail..."
                mail=$(/usr/sbin/ssmtp $EMAIL < message)
                echo "...done."
		;;
		*)
		echo "Not sending any mails."
		sleep 2
		;;
		esac
         fi
}

function mail_web ()
{
	
	#Create the email
	cat $APP_HOME/mail message.txt > message
	#Send an email to notify that some shows have been downloaded and updated
		echo "We have downloaded some new shows. I'll email you the details..."
		echo "Sending mail..." 
		mail=$(/usr/sbin/ssmtp $EMAIL < message) 
		echo "...done."
	
}

function mail_web_test ()
{
	
	#Create the email
	cat $APP_HOME/mail message.txt > message
	#Send an email to notify that some shows have been downloaded and updated
	echo "Would have downloaded and done stuff with some new shows. I would now email you the details..."
	
}

function housekeeping ()
{
	# Tidy up all the temp files that we have made
	# Needs re-working so that it only deletes files that have actually been created 
	# based on which functions have been called and how far they got.
	echo "Just a little housekeeping..."
	sleep 2
	
	if [ -f maildo ] ; then
		a=$(rm maildo)
	fi
	if [ -f message.txt ] ; then
		a=$(rm message.txt)
	fi
	if [ -f message ] ; then
		a=$(rm message)
	fi
	if [ -f downloads.tmp ] ; then
		a=$(rm downloads.tmp)
	fi
	if [ -f xbmcHttp?command=Exec* ] ; then
		a=$(rm xbmcHttp?command=Exec*)
    fi
}
