#!/bin/bash
set -e

if [ -f /docker-entrypoint-initdb.d/database.dump ]; then
    echo "導入初始資料"
    mariadb -u root -p"$MYSQL_ROOT_PASSWORD" "$MYSQL_DATABASE" < /docker-entrypoint-initdb.d/database.dump
else
    echo "無初始檔案"
    exit 1
fi