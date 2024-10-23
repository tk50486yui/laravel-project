<?php
$dbHost = 'localhost';
$dbPort = '5466';
$dbName = 'vocabulary';
$dbUser = '';
$dbPass = '';

$backupDir = __DIR__ . '/backups/';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}
$backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';

$pgDump = "pg_dump -h $dbHost -p $dbPort -U $dbUser -d $dbName -F p -f $backupFile";

putenv("PGPASSWORD=$dbPass");

exec($pgDump, $output, $return_var);

if ($return_var === 0) {
    echo "資料庫備份成功：$backupFile\n";
} else {
    echo "資料庫備份失敗！\n";
}

echo "5秒後自動關閉...\n";
sleep(5);