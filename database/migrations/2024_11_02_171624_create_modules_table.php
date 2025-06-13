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
        Schema::create('modules', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('id_parent')->nullable();
            $table->integer('id_language')->nullable();
            $table->integer('id_modules_type')->nullable()->default(0);
            $table->integer('id_design_type')->nullable()->default(0);
            $table->string('title',100)->nullable();
            $table->string('slug',100)->nullable();
            $table->string('description',500)->nullable();
            $table->string('link',200)->nullable();

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
        Schema::dropIfExists('modules');
    }
};
