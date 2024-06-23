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
        Schema::create('post_catalogue_language', function (Blueprint $table) {
            $table->unsignedBigInteger('post_catalogue_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('post_catalogue_id')->references('id')->on('post_catalogues')->omDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->omDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->longText('content');
            $table->string('meta-title');
            $table->string('meta-keyword');
            $table->text('meta-description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogue_language');
    }
};
