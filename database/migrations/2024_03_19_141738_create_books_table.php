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
            $table->ulid('id')->primary();
            $table->foreignUlid('user_id')->constrained()->cascadeOnDelete();
            $table->string('filename');
            $table->string('title')->nullable();
            $table->string('publisher')->nullable();
            $table->date('issue_date')->nullable();
            $table->integer('price')->nullable();
            $table->integer('size');
            $table->integer('width');
            $table->integer('height');
            $table->integer('XResolution')->nullable();
            $table->integer('YResolution')->nullable();
            $table->integer('ResolutionUnit')->nullable();
            $table->dateTime('lastModified');
            $table->string('filepath');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
