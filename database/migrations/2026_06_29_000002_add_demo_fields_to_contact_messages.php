<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('industry')->nullable()->after('company');
            $table->string('job_title')->nullable()->after('industry');
            $table->string('company_size')->nullable()->after('job_title');
            $table->json('improvements')->nullable()->after('company_size');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn(['industry', 'job_title', 'company_size', 'improvements']);
        });
    }
};
