#!/usr/bin/env bash
$3 -e sftp -oBatchMode=no -b - $2@$1 << !
   cd incoming
   put your-log-file.log
   bye
!