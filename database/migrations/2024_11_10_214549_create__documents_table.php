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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user_logged');
            $table->integer('id_module');
            $table->integer('id_record');
            $table->string('name',255)->nullable();
            $table->string('file',255)->nullable();
            $table->string('type',10);
            $table->string('path',255);
            $table->string('size')->nullable();
            $table->string('comment')->nullable();

            $table->boolean('active')->default(true);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_documents');
    }
};
