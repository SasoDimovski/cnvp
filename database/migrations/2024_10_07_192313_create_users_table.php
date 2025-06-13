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
        Schema::create('users', function (Blueprint $table) {
            $table->Increments('id');

            $table->integer('id_user_logged')->nullable();
            $table->string('name',100)->nullable();
            $table->string('surname',100)->nullable();

            $table->integer('id_country')->nullable();
            $table->string('address',100)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('picture',255)->nullable();
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username',100)->unique();
            $table->string('password',255)->nullable();

            $table->string('password_reset_hash',50)->nullable();
            $table->string('password_reset_type',50)->nullable();
            $table->timestamp('password_reset_hash_date')->nullable();
            $table->string('verification_code',50)->nullable();
            $table->timestamp('verification_code_expire')->nullable();
            $table->integer('id_expiration_time')->nullable();
            $table->integer('user_type')->nullable();

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
        Schema::dropIfExists('users');
    }
};
/**
$table->bigIncrements('id'); 	Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
$table->bigInteger('votes'); 	BIGINT equivalent column.
$table->binary('data'); 	BLOB equivalent column.
 * $table->boolean('confirmed'); 	BOOLEAN equivalent column.
$table->char('name', 100); 	CHAR equivalent column with an optional length.
$table->date('created_at'); 	DATE equivalent column.
$table->dateTime('created_at'); 	DATETIME equivalent column.
$table->dateTimeTz('created_at'); 	DATETIME (with timezone) equivalent column.
$table->decimal('amount', 8, 2); 	DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
$table->double('amount', 8, 2); 	DOUBLE equivalent column with a precision (total digits) and scale (decimal digits).
$table->enum('level', ['easy', 'hard']); 	ENUM equivalent column.
$table->float('amount', 8, 2); 	FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
$table->geometry('positions'); 	GEOMETRY equivalent column.
$table->geometryCollection('positions'); 	GEOMETRYCOLLECTION equivalent column.
 * $table->increments('id', 5); 	Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
 * $table->integer('votes',5); 	INTEGER equivalent column. (max  4294967295)
$table->ipAddress('visitor'); 	IP address equivalent column.
$table->json('options'); 	JSON equivalent column.
$table->jsonb('options'); 	JSONB equivalent column.
$table->lineString('positions'); 	LINESTRING equivalent column.
 * $table->longText('description'); 	LONGTEXT equivalent column. (max 4294967295 )
$table->macAddress('device'); 	MAC address equivalent column.
$table->mediumIncrements('id'); 	Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent column.
$table->mediumInteger('votes'); 	MEDIUMINT equivalent column.
 * $table->mediumText('description'); 	MEDIUMTEXT equivalent column. (max 16777215 )
$table->morphs('taggable'); 	Adds taggable_id UNSIGNED BIGINT and taggable_type VARCHAR equivalent columns.
$table->multiLineString('positions'); 	MULTILINESTRING equivalent column.
$table->multiPoint('positions'); 	MULTIPOINT equivalent column.
$table->multiPolygon('positions'); 	MULTIPOLYGON equivalent column.
$table->nullableMorphs('taggable'); 	Adds nullable versions of morphs() columns.
$table->nullableTimestamps(); 	Alias of timestamps() method.
$table->point('position'); 	POINT equivalent column.
$table->polygon('positions'); 	POLYGON equivalent column.
 * $table->rememberToken(); 	Adds a nullable remember_token VARCHAR(100) equivalent column.
$table->smallIncrements('id'); 	Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.
$table->smallInteger('votes'); 	SMALLINT equivalent column.
$table->softDeletes(); 	Adds a nullable deleted_at TIMESTAMP equivalent column for soft deletes.
$table->softDeletesTz(); 	Adds a nullable deleted_at TIMESTAMP (with timezone) equivalent column for soft deletes.
 * $table->string('name', 100); 	VARCHAR equivalent column with a optional length. (max 255)
 * $table->text('description'); 	TEXT equivalent column.(max 65535 )
$table->time('sunrise'); 	TIME equivalent column.
$table->timeTz('sunrise'); 	TIME (with timezone) equivalent column.
 * $table->timestamp('added_on'); 	TIMESTAMP equivalent column.
$table->timestampTz('added_on'); 	TIMESTAMP (with timezone) equivalent column.
 * $table->timestamps(); 	Adds nullable created_at and updated_at TIMESTAMP equivalent columns.
$table->timestampsTz(); 	Adds nullable created_at and updated_at TIMESTAMP (with timezone) equivalent columns.
$table->tinyIncrements('id'); 	Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.
$table->tinyInteger('votes'); 	TINYINT equivalent column.
$table->unsignedBigInteger('votes'); 	UNSIGNED BIGINT equivalent column.
$table->unsignedDecimal('amount', 8, 2); 	UNSIGNED DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
$table->unsignedInteger('votes'); 	UNSIGNED INTEGER equivalent column.
$table->unsignedMediumInteger('votes'); 	UNSIGNED MEDIUMINT equivalent column.
$table->unsignedSmallInteger('votes'); 	UNSIGNED SMALLINT equivalent column.
$table->unsignedTinyInteger('votes'); 	UNSIGNED TINYINT equivalent column.
$table->uuid('id'); 	UUID equivalent column.
$table->year('birth_year'); 	YEAR equivalent column.
 */
