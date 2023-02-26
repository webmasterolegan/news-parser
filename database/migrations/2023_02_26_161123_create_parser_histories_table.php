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
        Schema::create('parser_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('request_method', [
                'get',
                'head',
                'post',
                'put',
                'delete',
                'connect',
                'options',
                'trace',
                'patch'
            ]);
            $table->string('request_url');
            $table->unsignedInteger('response_http_code')->nullable();
            $table->string('response_body')->nullable();
            $table->unsignedInteger('request_execution_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parser_histories');
    }
};
