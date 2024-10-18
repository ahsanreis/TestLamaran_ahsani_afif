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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable(false);
            $table->text('description')->nullable();
            $table->date('publish_date')->nullable();
            $table->unsignedBigInteger('author_id')->nullable(false);
            $table->timestamps();
        });

        Schema::table('books', function (Blueprint $table) {
            $table->foreign('author_id')->on('authors')->references('id')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['author_id']);
        });

        Schema::drop('books');
    }
};
