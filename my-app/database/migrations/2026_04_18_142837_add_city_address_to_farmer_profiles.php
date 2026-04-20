<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('farmer_profiles', function (Blueprint $table) {
            $table->string('city')->nullable()->after('description');
            $table->string('address')->nullable()->after('city');
        });

        // Migrate existing free-text location → city + address
        DB::table('farmer_profiles')->get()->each(function ($fp) {
            if (!$fp->location) return;

            // Format was "City" or "City - Village"
            $parts = array_map('trim', explode(' - ', $fp->location, 2));
            $address = count($parts) > 1 ? $parts[1] : null;

            DB::table('farmer_profiles')->where('id', $fp->id)->update([
                'city'    => 'prnjavor',
                'address' => $address,
            ]);
        });

        Schema::table('farmer_profiles', function (Blueprint $table) {
            $table->dropIndex(['location']);
            $table->dropColumn('location');
            $table->index('city');
        });
    }

    public function down(): void
    {
        Schema::table('farmer_profiles', function (Blueprint $table) {
            $table->dropIndex(['city']);
            $table->dropColumn(['city', 'address']);
            $table->string('location')->nullable();
            $table->index('location');
        });
    }
};
