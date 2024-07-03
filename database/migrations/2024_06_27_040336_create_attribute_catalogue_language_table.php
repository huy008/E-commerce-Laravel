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
             Schema::create('attribute_catalogue_language', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_catalogue_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('attribute_catalogue_id')->references('id')->on('attribute_catalogues')->omDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->omDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('canonical')->unique();
            $table->longText('content');
            $table->string('meta_title');
            $table->string('meta_keyword');
            $table->text('meta_description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_catalogue_language');
    }
};
