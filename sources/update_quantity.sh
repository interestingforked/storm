#!/bin/sh

HOST='ftp.users.qwest.net'
USER='yourid'
PASSWD='yourpw'

DAY=`/bin/date +%y%m%d`

DIRECTORY='directory/to/txt/files'
FILE1="STOCK_R1_"$DAY".txt"
FILE2="STOCK_L2_"$DAY".txt"

FTPLOG=/tmp/ftplogfile

ftp -inv $HOST <<END_SCRIPT > $FTPLOG
quote USER $USER
quote PASS $PASSWD
ascii
prompt off
cd $DIRECTORY
get $FILE1
get $FILE2
close
quit
END_SCRIPT

FTP_SUCCESS_MSG="226 Transfer complete"
if fgrep -sq "$FTP_SUCCESS_MSG" $FTPLOG ;then
    cd /path/to/stormlondon.ru/yii-protected/directory/
	./yiic task updatequantity
	cd /path/to/stormlondon.lv/yii-protected/directory/
	./yiic task updatequantity
else
    echo 'FTP file download FAILED!!!'
fi 
