<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conference_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('type', ['link', 'file'])->default('link');
            $table->string('url', 1000);          // direct URL for links, Storage path for files
            $table->string('description')->nullable();
            $table->boolean('is_global')->default(false); // if true: available for all conferences
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_assets');
    }
};
