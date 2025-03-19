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
        Schema::create('cat_father', function (Blueprint $table) {
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('father_id');

            $table->foreign('cat_id')->references('id')->on('cats')->onDelete('cascade');
            $table->foreign('father_id')->references('id')->on('cats')->onDelete('cascade');

            $table->primary(['cat_id', 'father_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat_father');
    }
};
