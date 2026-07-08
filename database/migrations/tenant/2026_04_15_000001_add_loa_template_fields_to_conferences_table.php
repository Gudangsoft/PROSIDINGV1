<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            // LOA Template Header
            $table->string('loa_header_logo', 500)->nullable()->after('certificate_generation_mode');
            $table->string('loa_header_title', 500)->nullable()->after('loa_header_logo');
            $table->text('loa_header_subtitle')->nullable()->after('loa_header_title');
            $table->string('loa_header_address', 500)->nullable()->after('loa_header_subtitle');
            $table->string('loa_header_phone', 255)->nullable()->after('loa_header_address');
            $table->string('loa_header_fax', 255)->nullable()->after('loa_header_phone');
            $table->string('loa_header_email', 255)->nullable()->after('loa_header_fax');

            // LOA Body Content
            $table->text('loa_body_intro')->nullable()->after('loa_header_email');
            $table->text('loa_body_acceptance')->nullable()->after('loa_body_intro');
            $table->json('loa_important_dates')->nullable()->after('loa_body_acceptance');
            $table->text('loa_body_submission_info')->nullable()->after('loa_important_dates');
            $table->text('loa_payment_info')->nullable()->after('loa_body_submission_info');
            $table->text('loa_contact_info')->nullable()->after('loa_payment_info');
            $table->text('loa_closing_text')->nullable()->after('loa_contact_info');

            // LOA Signature
            $table->string('loa_signatory_name', 255)->nullable()->after('loa_closing_text');
            $table->string('loa_signatory_title', 255)->nullable()->after('loa_signatory_name');
            $table->string('loa_signature_image', 500)->nullable()->after('loa_signatory_title');

            // LOA Footer
            $table->string('loa_footer_text', 500)->nullable()->after('loa_signature_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conferences', function (Blueprint $table) {
            $table->dropColumn([
                'loa_header_logo',
                'loa_header_title',
                'loa_header_subtitle',
                'loa_header_address',
                'loa_header_phone',
                'loa_header_fax',
                'loa_header_email',
                'loa_body_intro',
                'loa_body_acceptance',
                'loa_important_dates',
                'loa_body_submission_info',
                'loa_payment_info',
                'loa_contact_info',
                'loa_closing_text',
                'loa_signatory_name',
                'loa_signatory_title',
                'loa_signature_image',
                'loa_footer_text',
            ]);
        });
    }
};
