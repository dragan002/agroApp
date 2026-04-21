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
        Schema::table('products', function (Blueprint $table) {
            $table->timestamp('fresh_until')->nullable()->after('price_unit');
            $table->dropIndex(['fresh_today']);
            $table->dropColumn('fresh_today');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('fresh_today')->default(false);
            $table->index('fresh_today');
            $table->dropColumn('fresh_until');
        });
    }
};
