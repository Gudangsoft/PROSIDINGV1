<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->foreignId('participant_type_id')
                ->nullable()
                ->after('show_register_button')
                ->constrained('participant_types')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropForeign(['participant_type_id']);
            $table->dropColumn('participant_type_id');
        });
    }
};
