<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->boolean('show_register_button')->default(true)->after('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('show_register_button');
        });
    }
};
