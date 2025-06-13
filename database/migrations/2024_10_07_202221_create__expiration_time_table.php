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
        Schema::create('_expiration_time', function (Blueprint $table) {
            $table->Increments('id',);
            $table->integer('value')->nullable();
            $table->string('name',100)->nullable();
            $table->string('description',255)->nullable();

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
        Schema::dropIfExists('_expiration_time');
    }
};
