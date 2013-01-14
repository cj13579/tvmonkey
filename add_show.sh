#!/bin/bash -x
#
# PURPOSE:  adds shows to tvmonkey and flexget.
#
# Author: Chris Blake

APP_HOME="$( cd "$( dirname "$0" )" && pwd )"

# Source the applications configs
. $APP_HOME/tvmonkey.config

show=$1
loc=$2
feed=$3

y="'$loc/$show*'"
b="$loc/$show*"
z=$loc/$show

if [[ $# = 3 ]] ; then
	sleep 1
	
	#backup stuff incase it goes wrong
	cp -p $FLEXCONF $FLEXCONF.wrk
	cp -p $APP_HOME/tvshows.config $APP_HOME/tvshows.config.wrk
	
	
	echo "Checking to see if $show is already configured..."
	echo
	sleep 1
	
	m=0
	#check to see whether or not we have added the show before
	x=$(grep -wn "      - '" $FLEXCONF | cut --fields=2-99 --delimiter=- 2>&1 | tee -a list)
	cat list | while read i
	do
		if [[ $i =~ $y ]] ; then
			m=$((m+1))
			x=$(echo $m > exist )
		fi
	done

	m=$(cat exist)
	
	if [[ "$m" -ge 1 ]] ; then 
		echo "$show is already in TVMonkey. No need to do anything."
		x=$(rm $APP_HOME/tvshows.config.wrk $FLEXCONF.wrk exist)
		x=$(rm list list2)
		sleep 1
		exit 0	
	fi
	
	x=$(cat $APP_HOME/tvshows.config | cut --fields=2-99 --delimiter=: 2>&1 | tee -a list2)
	loc1=$(echo $loc | sed 's/\//\\\//g')
	cat list2 | while read a
	do
		a=$(echo $a | sed "s/$loc1\///g")
		if [[ $a =~ $show ]] ; then
			m=$((m+1))
			x=$(echo $m > exist )
		fi
	done	
	
	m=$(cat exist)
	
	if [[ "$m" -ge 1 ]] ; then 
		echo "$show is already in TVMonkey. No need to do anything."
		x=$(rm $APP_HOME/tvshows.config.wrk $FLEXCONF.wrk exist)
		x=$(rm list list2)
		sleep 1
		exit 0	
	fi
	
	#housekeeping
	x=$(rm list list2)
	
	echo "$show not configured. Adding show..."
	echo 
	sleep 1	
		echo -e "modifying series information...\c"
		sleep 1
		#add the show to the series plugin
		x=$(grep -wn "series:" $FLEXCONF | cut --fields=1 --delimiter=:)
		x=$((x+1))
		sed -i "$x i\      - $show" $FLEXCONF
		echo -e " [done]"
		echo 
		
		#add the show to the exists_series plugin
		echo -e "updating information to check for existing files...\c"
		sleep 1
		x=$(grep -wn "exists_series:" $FLEXCONF | cut --fields=1 --delimiter=:)
		x=$((x+1))
		sed -i "$x i\      - '$z'" $FLEXCONF
		echo -e " [done]"
		echo 
		
		#add the show feed to feeds plugin
		echo -e "modifying rss feed information...\c"
		sleep 1
		x=$(grep -wn "feeds:" $FLEXCONF | cut --fields=1 --delimiter=:)
		x=$((x+1))
		y=$(wc -l $FLEXCONF | cut --fields=1 --delimiter=' ')
		if [[ $x -ge $y ]] ; then
			sed -i '$ a\ ' $FLEXCONF
		fi
		sed -i "$x i\  TVMonkey $show:" $FLEXCONF
		x=$((x+1))
		sed -i "$x i\    rss: $feed" $FLEXCONF
		x=$((x+1))
		sed -i "$x i\    preset:" $FLEXCONF
		x=$((x+1))
		sed -i "$x i\      - transmissionrpc" $FLEXCONF
		x=$((x+1))
		sed -i "$x i\      - tv" $FLEXCONF
		x=$((x+1))
		sed -i "$x i\ " $FLEXCONF
		echo -ne "		[done]"
		echo 
		
		#make the directory to keep flexget happy if it doesnt exist
		echo -e "creating directory if it doesnt exist...\c"
		sleep 1
		if [[ ! -d $z ]] ; then
			x=$(mkdir -p "$z")
		fi
		echo -e " [done]"
		echo
		
		x=$(flexget --check -c $FLEXCONF)
		if [[ $? != 0 ]] ; then
			echo "Something has gone wrong with Flexget.. backtracking."
			cp -p $FLEXCONF.wrk $FLEXCONF
			cp -p $APP_HOME/tvshows.config.wrk $APP_HOME/tvshows.config
			x=$(flexget --check -c $FLEXCONF)
			if [[ $? = 0 ]] ; then
				x=$(rm $APP_HOME/tvshows.config.wrk $FLEXCONF.wrk exist)
				echo "Phew... all fixed."
				exit 1
			fi
		fi
		
		echo -e "updating TVMonkey shows file...\c"
		sleep 1
		sm=$(echo "$show" | sed 's/ /./g')
		x=$(wc -l $APP_HOME/tvshows.config | cut --fields=1 --delimiter=' ')
		if [[ $x -eq 0 ]] ; then
			echo "$sm:$loc/$show" >> $APP_HOME/tvshows.config
		else
		sed -i "$ a\
		$sm:$loc/$show" $APP_HOME/tvshows.config
		fi
		if [[ $? != 0 ]] ; then
			echo "Something has gone wrong with tvshows.config... backtracking."
			cp -p $APP_HOME/tvshows.config.wrk $APP_HOME/tvshows.config
			cp -p $FLEXCONF.wrk $FLEXCONF
			if [[ $? = 0 ]] ; then
				x=$(rm $APP_HOME/tvshows.config.wrk $FLEXCONF.wrk exist)
				echo "Phew... all fixed."
				exit 1
			fi
		fi
		echo -e " [done]"
		echo
		
		echo "successfully added $show to TVMonkey"
		echo 
		echo "Exit."
		x=$(rm $APP_HOME/tvshows.config.wrk $FLEXCONF.wrk exist)	
	
fi
