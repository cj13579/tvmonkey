#!/bin/bash -x
# SCRIPT:  tvmonkey_functions.sh
#
# PURPOSE: Functions for the operation of the TVMonkey problems
#          
#

function torrents_cron ()
{
TORRENTLIST=$($TR_CMD --list | sed '1d; $d; s/^ *//' | cut --only-delimited --delimiter=' ' --fields=1)

# For each torrent in the list
for TORRENTID in $TORRENTLIST
do
  # check if torrent download is completed
  DL_COMPLETED=$($TR_CMD --torrent $TORRENTID --info | grep "Percent Done: 100%")
  # If download has completed, stop, move and remove it.
  if [ "$DL_COMPLETED" != "" ] ; then
    STATE_STOPPED=$($TR_CMD --torrent $TORRENTID -s) 
    TORR_MOV=$($TR_CMD --torrent $TORRENTID --move $MOV_DIR)
    TORR_REM=$($TR_CMD --torrent $TORRENTID --remove)
  fi
done
}

function torrents ()
{
echo "Connecting to Transmission and checking downloads for completion..."
sleep 1
TORRENTLIST=$($TR_CMD --list | sed '1d; $d; s/^ *//' | cut --only-delimited --delimiter=' ' --fields=1)

# For each torrent in the list
for TORRENTID in $TORRENTLIST
do
  # check if torrent download is completed
  DL_COMPLETED=$($TR_CMD --torrent $TORRENTID --info | grep "Percent Done: 100%")
  # If download has completed, stop, move and remove it.
  if [ "$DL_COMPLETED" != "" ] ; then
	WHAT=$($TR_CMD --torrent $TORRENTID --list | sed '1d; $d; s/^ *//' | cut --only-delimited --delimiter=' ' --fields=34-99)
    STATE_STOPPED=$($TR_CMD --torrent $TORRENTID -s) 
    echo "Found a finished Torrent. Removing $WHAT from transmission and moving it to $MOV_DIR..."
	sleep 2
    TORR_MOV=$($TR_CMD --torrent $TORRENTID --move $MOV_DIR)
    TORR_REM=$($TR_CMD --torrent $TORRENTID --remove)
  fi
done
}

function torrents_web_test ()
{
	echo "Connecting to Transmission and checking downloads for completion..."
	sleep 1
	TORRENTLIST=$($TR_CMD --list | sed '1d; $d; s/^ *//' | cut --only-delimited --delimiter=' ' --fields=1)

	# For each torrent in the list
	for TORRENTID in $TORRENTLIST
	do
 		# check if torrent download is completed
 		DL_COMPLETED=$($TR_CMD --torrent $TORRENTID --info | grep "Percent Done: 100%")
  		# If download has completed, stop, move and remove it.
  		if [ "$DL_COMPLETED" != "" ] ; then
			WHAT=$($TR_CMD --torrent $TORRENTID --list | sed '1d; $d; s/^ *//' | cut --only-delimited --delimiter=' ' --fields=34-99)
    			STATE_STOPPED=$($TR_CMD --torrent $TORRENTID -s) 
    			echo "Found a finished Torrent. Would remove $WHAT from transmission and move it to $MOV_DIR..."
			sleep 2
  		fi
done
}

