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
        Schema::create('parser_request_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('method', [
                'GET',
                'HEAD',
                'POST',
                'PUT',
                'DELETE',
                'CONNECT',
                'OPTIONS',
                'TRACE',
                'PATCH'
            ]);
            $table->string('url');
            $table->unsignedInteger('response_code')->nullable();
            $table->longText('response_body')->nullable();
            $table->unsignedInteger('execution_time');
            $table->dateTime('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parser_request_logs');
    }
};
