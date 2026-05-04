<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->string('institute_chairman_name')->nullable()->after('secretary_signature');
            $table->string('institute_chairman_title')->nullable()->after('institute_chairman_name');
            $table->string('institute_chairman_signature')->nullable()->after('institute_chairman_title');
            $table->boolean('show_chairman')->default(true)->after('institute_chairman_signature');
            $table->boolean('show_secretary')->default(true)->after('show_chairman');
            $table->boolean('show_institute_chairman')->default(false)->after('show_secretary');
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn([
                'institute_chairman_name', 'institute_chairman_title', 'institute_chairman_signature',
                'show_chairman', 'show_secretary', 'show_institute_chairman',
            ]);
        });
    }
};
