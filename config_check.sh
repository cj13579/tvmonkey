#!/bin/bash
# SCRIPT:  config_check.sh
#
# PURPOSE:  Configuraton checking script.
#
# Author: Chris Blake

APP_HOME="$( cd "$( dirname "$0" )" && pwd )"

# Source the applications configs
. $APP_HOME/tvmonkey.config

function main ()
{

echo "Checking watch locataion..."
sleep 1

if [[ -d $MOV_DIR ]] ; then
	echo "$MOV_DIR exists.";
fi
echo ""

echo "Checking transmission command..."
sleep 1

if [[ -n "$TR_CMD" ]] ; then
	x=$($TR_CMD --list)
	if [[ $? == "0" ]] ; then
		echo "Transmission connection command is fine."
	else
		echo "Error in Transmission connection command."
	fi
fi
echo ""

echo "Checking connections to XBMC libraries..."
sleep 1

if [[ -n "$LIBRARY" ]] ; then
	i=0
	for x in $LIBRARY
	do
		let i++;
	done
	echo "There are $i XBMC libraries defined. Checking that we can see them..."
	sleep 1
	
	for LIB in $LIBRARY
	do
		x=$(ping -c 1 $LIB)
		y=$(echo $x | cut --only-delimited --delimiter=' ' --fields=24-25)
		if [[ $y = '1 received,' ]] ; then
			echo "$LIB seems to be up. I can ping it..."
		else
			echo "$LIB is unreachable. Check it is up..."
		fi
	done
fi
echo ""

echo "Checking FlexGet config file..."
sleep 1

if [[ -f $FLEXCONF ]] ; then
	if [[ -w $FLEXCONF ]] ; then
		echo "We can read and write to the file."	
		echo "Checking that FlexGet likes the file..."
		echo
		sleep 1
		x=$(flexget --check -c $FLEXCONF 2>&1 | tee -a flexresult)
		cat flexresult | while read series
		do
			x=$(echo $series | cut --only-delimited --delimiter=' ' --fields=3)
			if [[ "$x" = "INFO" ]] ; then
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and is fine..."
			elif [[ "$x" = "WARN" ]] ; then
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and has warnings..."
			else
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and has errors in it..."
			fi
		done
		if [[ -f flexresult ]] ; then
		x=$(rm flexresult)
		fi	
	elif [[ -r $FLEXCONF ]] ; then
		echo "Seems like we can only read this file."
		echo "You won't be able to edit this via the Web Interface.."
		echo ""
		echo "Checking the FlexGet likes the file..."
		sleep 1
		x=$(flexget --check -c $FLEXCONF 2>&1 | tee -a flexresult)
		cat flexresult | while read series
		do
			x=$(echo $series | cut --only-delimited --delimiter=' ' --fields=3)
			if [[ "$x" = "INFO" ]] ; then
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and is fine..."
			elif [[ "$x" = "WARN" ]] ; then
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and has warnings..."
			else
				show=$(echo $series | cut --only-delimited --delimiter=' ' --fields=6-99)
				echo "$show and has errors in it..."
			fi
		done
		if [[ -f flexresult ]] ; then
		x=$(rm flexresult)
		fi
	else
		echo "Unable to find or read this file."
	fi

fi
}

function show_help ()
{
	echo ""
    echo ""
    echo "+--------------------------------------------------------------+"
    echo "| You are currently using TVMonkey config checker version: 0.1 |"
    echo "+--------------------------------------------------------------+"
    echo ""
	echo "Usage: $0 [OPTION] ."
	echo "-i or --interactive : Use this option to run the program	and have messages shown to the screen."
	echo "use -h or --info to show this information."
	echo ""
}

if [ "$#" -eq "1" ] ; then
   for arg in "$@" 
   do  
      case "$arg" in
	  -h | --info )
	     show_help
	     exit 0
	     ;;
      -i | --interactive)
		 sleep 2
	     main
	     ;;
	  *)
	     echo "Usage: $0 [OPTION]. Use $0 -h or --info for more information"
	     ;;
      esac
   done
else
   echo "Usage: $0 [OPTION]. Use $0 -h or --info for more information."
fi
