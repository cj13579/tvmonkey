#!/bin/bash
# SCRIPT:  tvmonkey_main_functions.sh
#
# PURPOSE: Functions for the operation of main bit of TVMonkey 
#          
#

function main ()
{
	# Change directory to the location of the downloaded shows
	cd $MOV_DIR
	
	#Run flexget to see if there is anything new for us to download
	#flexget
	
	# Call the torrents function passing the TR_CMD and MOV_DIR variables as values.
	torrents

        #Get a list of all the files that are in the transmission completed downloads folder
        echo "Getting list of files from watch directory..."
        sleep 1
        ls > downloads.tmp

	# Call the function that scans the MOV_DIR location comparing the files in there 
	# against those listed in the TVSHOWS config file. The Matching shows are moved to the
	# locations defined in the TVSHOWS config file.
	show_mover
	
	if [ -f message.txt ] ; then
		echo ""
		else 
			echo "We didn't do anything as there were no downloads that matched our criteria."
			rm downloads.tmp
			echo "Exiting..."
			exit 0
	fi

	# This function is used to invoke XBMC into rescanning its library so that the new shows
	# are picked up and can be watched.
	#xbmc_updater

	# Send an email to let us know that there are new TV Shows available (if applicable)
	mail

	# Tidy up all the mess that we have made
	housekeeping
	
	echo "All done. Exiting..."
	sleep 1
	exit 0
}

function main_cron ()
{
	# Change directory to the location of the downloaded shows
	cd $MOV_DIR
	
	#Run flexget to see if there is anything new for us to download
	#flexget_cron
	
	# Call the torrents function passing the TR_CMD and MOV_DIR variables as values.
	torrents_cron

        #Get a list of all the files that are in the transmission completed downloads folder
        ls > downloads.tmp

	# Call the function that scans the MOV_DIR location comparing the files in there 
	# against those listed in the TVSHOWS config file. The Matching shows are moved to the
	# locations defined in the TVSHOWS config file.
	show_mover_cron

	# This function is used to invoke XBMC into rescanning its library so that the new shows
	# are picked up and can be watched.
	#xbmc_updater_cron

	# Send an email to let us know that there are new TV Shows available (if applicable)
	mail_cron

	# Tidy up all the mess that we have made
	housekeeping_cron
}

function main_web ()
{
	# Change directory to the location of the downloaded shows
	cd $MOV_DIR
	
	#Run flexget to see if there is anything new for us to download
	#flexget_web
	
	# Call the torrents function passing the TR_CMD and MOV_DIR variables as values.
	torrents

        #Get a list of all the files that are in the transmission completed downloads folder
        echo "Getting list of files from watch directory..."
        sleep 1
        ls > downloads.tmp

	# Call the function that scans the MOV_DIR location comparing the files in there 
	# against those listed in the TVSHOWS config file. The Matching shows are moved to the
	# locations defined in the TVSHOWS config file.
	show_mover
	
	if [ -f message.txt ] ; then
		echo ""
		else 
			echo "We didn't do anything as there were no downloads that matched our criteria."
			echo "Exit."
                        rm downloads.tmp	
			exit 0
	fi

	# This function is used to invoke XBMC into rescanning its library so that the new shows
	# are picked up and can be watched.
	#xbmc_updater_web

	# Send an email to let us know that there are new TV Shows available (if applicable)
	mail_web

	# Tidy up all the mess that we have made
	housekeeping
	
	echo "All done. Exit."
	sleep 1
	exit 0
}

function test_web ()
{
	# Change directory to the location of the downloaded shows
	cd $MOV_DIR
	
	#Run flexget to see if there is anything new for us to download
	#flexget_web_test
	
	# Call the torrents function passing the TR_CMD and MOV_DIR variables as values.
	torrents_web_test

        #Get a list of all the files that are in the transmission completed downloads folder
        echo "Getting list of files from watch directory..."
        sleep 1
        ls > downloads.tmp

	# Call the function that scans the MOV_DIR location comparing the files in there 
	# against those listed in the TVSHOWS config file. The Matching shows are moved to the
	# locations defined in the TVSHOWS config file.
	show_mover_web_test
	
	if [ -f message.txt ] ; then
		echo ""
		else 
			echo "We didn't do anything as there were no downloads that matched our criteria."
			echo "Exit."
                        rm downloads.tmp	
			exit 0
	fi

	# This function is used to invoke XBMC into rescanning its library so that the new shows
	# are picked up and can be watched.
	#xbmc_updater_web_test

	# Send an email to let us know that there are new TV Shows available (if applicable)
	mail_web_test

	# Tidy up all the mess that we have made
	housekeeping
	
	echo "All done. Exit."
	sleep 1
	exit 0
}


function show_mover_cron ()
{

cat downloads.tmp | while read DOWNLOAD
do

	#Read in the list of defined TV shows line by line
	cat $TVSHOWS | while read line1
	do
	
	#For each TV show (line1) create a number of variables
	#The name of the TV show
	SHOW=${line1%:*}
	SHOW_N=$(echo $SHOW | tr . " ")

	#The length of the show name - Used to find where the season number begins
	SHOW_L=${#SHOW}
	SHOW_L=$SHOW_L+2;

	#After the delimiter, the location where we want this show to be stored.
	LOC=${line1##*:}

	if [[ $DOWNLOAD == $SHOW.S* ]] ; then
	#If we find one then extract the season number
	season=${DOWNLOAD:$SHOW_L:2}	
	#Move the file to the Correct folder depending on which Season it is in.
	case $season in
	0[1-9])
		i=$(echo $season | cut -c 2)			
		if [ -d "$LOC/Season $i" ]; then
			mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
			x=$(echo $DOWNLOAD >> message.txt)
			#Set a marker to show we have done something
			maildo=$(echo '1' >> maildo)
		else 
			if [ ! -d "$LOC/Season $i" ]; then
				mkdir "$LOC/Season $i";
				mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
				x=$(echo $DOWNLOAD >> message.txt)
				#Set a marker to show we have done something
				maildo=$(echo '1' >> maildo)
			fi
		fi
		;;
	esac
    fi
	
	if [[ $DOWNLOAD =~ $SHOW.[1-9]* ]] ; then
	#If we find one then extract the season number
	SHOW_L=$SHOW_L-1;
	season=${DOWNLOAD:$SHOW_L:1}	
		
		#Move the file to the Correct folder depending on which Season it is in.
	case $season in
	[1-9])
		i=$(echo $season)			
		if [ -d "$LOC/Season $i" ]; then
			mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
			x=$(echo $DOWNLOAD >> message.txt)
			#Set a marker to show we have done something
			maildo=$(echo '1' >> maildo)
		else 
			if [ ! -d "$LOC/Season $i" ]; then
				mkdir "$LOC/Season $i";
				mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
				x=$(echo $DOWNLOAD >> message.txt)
				#Set a marker to show we have done something
				maildo=$(echo '1' >> maildo)
			fi
		fi
	;;
		esac
    fi	
    
    # Reset the show length counter back to 0 to fix a bug [0000001] which prevented multiple show moves in one run of TVMonkey.
	SHOW_N="";
    SHOW_L=0;
    
	done

done
	
}


function show_mover ()
{
	
cat downloads.tmp | while read DOWNLOAD
do

	#Read in the list of defined TV shows line by line
	cat $TVSHOWS | while read line1
	do
	
	#For each TV show (line1) create a number of variables
	#The name of the TV show
	SHOW=${line1%:*}
	SHOW_N=$(echo $SHOW | tr . " ")

	#The length of the show name - Used to find where the season number begins
	SHOW_L=${#SHOW}
	SHOW_L=$SHOW_L+2;

	#After the delimiter, the location where we want this show to be stored.
	LOC=${line1##*:}

	if [[ $DOWNLOAD == $SHOW.S* ]] ; then
	#If we find one then extract the season number
	season=${DOWNLOAD:$SHOW_L:2}	
	#Move the file to the Correct folder depending on which Season it is in.
	case $season in
	0[1-9])
		i=$(echo $season | cut -c 2)			
		if [ -d "$LOC/Season $i" ]; then
			echo "$DOWNLOAD is from $SHOW_N. Moving it to the Season $i folder..."
			mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
			x=$(echo $DOWNLOAD >> message.txt)
			#Set a marker to show we have done something
			maildo=$(echo '1' >> maildo)
		else 
			if [ ! -d "$LOC/Season $i" ]; then
				mkdir "$LOC/Season $i";
				echo "$DOWNLOAD is from $SHOW_N. Moving it to the Season $i folder..."
				mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
				x=$(echo $DOWNLOAD >> message.txt)
				#Set a marker to show we have done something
				maildo=$(echo '1' >> maildo)
			fi
		fi
		;;
	esac
    fi
	
	if [[ $DOWNLOAD =~ $SHOW.[1-9]* ]] ; then
	#If we find one then extract the season number
	SHOW_L=$SHOW_L-1;
	season=${DOWNLOAD:$SHOW_L:1}	
		
		#Move the file to the Correct folder depending on which Season it is in.
	case $season in
	[1-9])
		i=$(echo $season)			
		if [ -d "$LOC/Season $i" ]; then
			echo "$DOWNLOAD is from $SHOW_N. Moving it to the Season $i folder..."
			mv $DOWNLOAD "$LOC/Season $i" &> /dev/null;
			x=$(echo $DOWNLOAD >> message.txt)
			#Set a marker to show we have done something
			maildo=$(echo '1' >> maildo)
		else 
			if [ ! -d "$LOC/Season $i" ]; then
				echo "$DOWNLOAD is from $SHOW_N. Moving it to the Season $i folder..."
				mkdir "$LOC/Season $i";
				mv $DOWNLOAD "$LOC/Season $i" &> /dev/null ;
				x=$(echo $DOWNLOAD >> message.txt)
				#Set a marker to show we have done something
				maildo=$(echo '1' >> maildo)
			fi
		fi
	;;
		esac
    fi	
    
    # Reset the show length counter back to 0 to fix a bug [0000001] which prevented multiple show moves in one run of TVMonkey.
	SHOW_N="";
    SHOW_L=0;
    
	done

done

}
