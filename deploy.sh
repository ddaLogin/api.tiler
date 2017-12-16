#!/usr/bin/env bash
lftp sftp://$2:$3@$1 -e "cd ../var/www/test; put package.json; bye"