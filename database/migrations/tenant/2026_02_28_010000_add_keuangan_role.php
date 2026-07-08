<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter users.role enum to add 'keuangan'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('author','reviewer','editor','admin','participant','keuangan') DEFAULT 'author'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('author','reviewer','editor','admin','participant') DEFAULT 'author'");
    }
};
