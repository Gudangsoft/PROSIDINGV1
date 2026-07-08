<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('chairman_name')->nullable()->after('organizer');
            $table->string('chairman_title')->nullable()->after('chairman_name');
            $table->string('secretary_name')->nullable()->after('chairman_title');
            $table->string('secretary_title')->nullable()->after('secretary_name');
            $table->string('chairman_signature')->nullable()->after('secretary_title');
            $table->string('secretary_signature')->nullable()->after('chairman_signature');
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn([
                'chairman_name', 'chairman_title',
                'secretary_name', 'secretary_title',
                'chairman_signature', 'secretary_signature',
            ]);
        });
    }
};
