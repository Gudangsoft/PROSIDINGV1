<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wa_blasts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('recipient_type')->default('all'); // all, role, custom
            $table->string('recipient_role')->nullable();     // author, reviewer, participant, etc.
            $table->json('phone_numbers')->nullable();        // list of phone numbers sent to
            $table->text('message');
            $table->string('status')->default('draft');      // draft, sending, completed, failed
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);
            $table->text('error_log')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wa_blasts');
    }
};
