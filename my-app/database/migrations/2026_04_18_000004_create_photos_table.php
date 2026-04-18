<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photoable_id');
            $table->string('photoable_type');
            $table->string('path');
            $table->integer('position')->default(0);
            $table->timestamps();

            $table->index(['photoable_type', 'photoable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
