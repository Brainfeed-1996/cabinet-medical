# Variables
$ftpHost = "ftpupload.net"
$ftpPort = 21
$username = "if0_38687649"
$password = "Zinkrobin1"
$remoteDir = "/htdocs"
$winscpPath = "C:\Program Files (x86)\WinSCP\WinSCP.com"

# Script WinSCP
$script = @"
open ftp://$username:$password@$ftpHost:$ftpPort
cd $remoteDir

# Permissions sur les dossiers (755 récursif)
chmod -r 755 *

# Permissions sur les fichiers (644)
# Attention : certains serveurs FTP n'autorisent pas le chmod via script

exit
"@

# Sauvegarde temporaire
$scriptPath = "$env:TEMP\winscp_script.txt"
$script | Set-Content -Encoding ASCII -Path $scriptPath

# Exécuter le script
& "$winscpPath" /script="$scriptPath"
