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
             Schema::create('product_catalogue_language', function (Blueprint $table) {
            $table->unsignedBigInteger('product_catalogue_id');
            $table->unsignedBigInteger('language_id');
            $table->foreign('product_catalogue_id')->references('id')->on('product_catalogues')->omDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->omDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->string('canonical')->unique();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_catalogue_language');
    }
};
