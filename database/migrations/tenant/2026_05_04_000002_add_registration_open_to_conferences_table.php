<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->boolean('registration_open')->default(true)->after('show_register_button');
            $table->string('registration_closed_message')->nullable()->after('registration_open');
        });
    }

    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn(['registration_open', 'registration_closed_message']);
        });
    }
};
