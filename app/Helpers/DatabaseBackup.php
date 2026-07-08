<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 * Generates a plain-SQL dump of the current database. Shared by the admin
 * "download backup" export and the pre-import safety snapshot in
 * App\Livewire\Admin\DatabaseManager.
 */
class DatabaseBackup
{
    public static function filename(): string
    {
        return DB::getDatabaseName() . '_backup_' . now()->format('Ymd_His') . '.sql';
    }

    public static function dump(): string
    {
        $pdo = DB::getPdo();
        $dbName = DB::getDatabaseName();
        $output = [];

        $output[] = '-- ============================================================';
        $output[] = '-- Database Backup: ' . $dbName;
        $output[] = '-- Generated: ' . now()->toDateTimeString();
        $output[] = '-- Host: ' . config('database.connections.mysql.host', 'localhost');
        $output[] = '-- Laravel Version: ' . app()->version();
        $output[] = '-- ============================================================';
        $output[] = '';
        $output[] = 'SET NAMES utf8mb4;';
        $output[] = 'SET FOREIGN_KEY_CHECKS=0;';
        $output[] = 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";';
        $output[] = 'SET time_zone="+00:00";';
        $output[] = '';

        // Get all tables
        $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            $output[] = '-- ──────────────────────────────────';
            $output[] = '-- Table: `' . $table . '`';
            $output[] = '-- ──────────────────────────────────';
            $output[] = '';

            // Drop + Create
            $output[] = 'DROP TABLE IF EXISTS `' . $table . '`;';

            $create = $pdo->query('SHOW CREATE TABLE `' . $table . '`')->fetch(\PDO::FETCH_NUM);
            $output[] = $create[1] . ';';
            $output[] = '';

            // Rows
            $rows = $pdo->query('SELECT * FROM `' . $table . '`')->fetchAll(\PDO::FETCH_ASSOC);

            if (!empty($rows)) {
                $columns = '`' . implode('`, `', array_keys($rows[0])) . '`';
                $chunks = array_chunk($rows, 100);

                foreach ($chunks as $chunk) {
                    $values = array_map(function (array $row) use ($pdo): string {
                        $escaped = array_map(function ($val) use ($pdo): string {
                            if ($val === null) {
                                return 'NULL';
                            }

                            return $pdo->quote((string) $val);
                        }, $row);

                        return '(' . implode(', ', $escaped) . ')';
                    }, $chunk);

                    $output[] = 'INSERT INTO `' . $table . '` (' . $columns . ') VALUES';
                    $output[] = implode(",\n", $values) . ';';
                    $output[] = '';
                }
            }
        }

        $output[] = '';
        $output[] = 'SET FOREIGN_KEY_CHECKS=1;';
        $output[] = '';
        $output[] = '-- End of backup --';

        return implode("\n", $output);
    }
}
