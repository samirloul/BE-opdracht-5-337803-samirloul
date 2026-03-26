<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabase extends Command
{
    protected $signature = 'db:import';
    protected $description = 'Import database from opdracht5.sql';

    public function handle()
    {
        $sqlFile = file_get_contents(database_path('opdracht5.sql'));
        
        // Remove comments and normalize whitespace
        $sqlFile = preg_replace('/--.*$/m', '', $sqlFile);
        $sqlFile = preg_replace('/\/\*.*?\*\//s', '', $sqlFile);
        
        // Replace DELIMITER statements
        $sqlFile = str_replace(['DELIMITER $$', 'DELIMITER ;'], ['', ''], $sqlFile);
        
        // Split by statements - for procedures, they're separated by $$
        // For regular statements, they're separated by ;
        
        // First handle regular statements
        $parts = preg_split('/;(?=\s*(?:SELECT|INSERT|UPDATE|DELETE|ALTER|CREATE|DROP))/i', $sqlFile);
        
        foreach ($parts as $statement) {
            $statement = trim($statement);
            if (empty($statement)) {
                continue;
            }
            
            // Handle stored procedure blocks (separated by $$)
            if (preg_match('/CREATE\s+PROCEDURE/i', $statement)) {
                $procedures = array_filter(array_map('trim', explode('$$', $statement)));
                foreach ($procedures as $proc) {
                    if (!empty($proc)) {
                        try {
                            DB::unprepared($proc);
                            $this->info('Created procedure: ' . substr($proc, 0, 50) . '...');
                        } catch (\Exception $e) {
                            $this->error('Error creating procedure: ' . $e->getMessage());
                        }
                    }
                }
            } else {
                try {
                    DB::unprepared($statement . ';');
                } catch (\Exception $e) {
                    $this->error('Error executing statement: ' . $e->getMessage());
                }
            }
        }

        $this->info('Database import completed!');
    }
}
