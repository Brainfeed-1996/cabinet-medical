<?php
// temp_backup.php - À SUPPRIMER APRÈS USAGE
require 'config.php';

$backupFile = __DIR__.'/backup_'.date('Y-m-d_His').'.sql.gz';
$command = "mysqldump -h ".DB_HOST." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME." | gzip > ".$backupFile;

system($command);

if (file_exists($backupFile)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($backupFile).'"');
    readfile($backupFile);
    unlink($backupFile); // Supprime après téléchargement
    exit;
} else {
    die("Échec de la sauvegarde. Vérifiez les logs.");
}