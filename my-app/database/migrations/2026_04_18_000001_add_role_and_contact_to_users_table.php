<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('viber')->nullable()->after('phone');
            $table->string('whatsapp')->nullable()->after('viber');
            $table->integer('onboarding_step')->nullable()->default(0)->after('whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'viber', 'whatsapp', 'onboarding_step']);
        });
    }
};
