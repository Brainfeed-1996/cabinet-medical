<?php
require 'config.php';
$backupFile = __DIR__.'/backup_'.date('Y-m-d').'.sql';
system("mysqldump -h ".DB_HOST." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME." > ".$backupFile);
echo "Backup créé : ".$backupFile;