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
        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('interested')->default(false)->after('content');
            $table->string('company')->nullable()->after('interested');
            $table->string('activity')->nullable()->after('company');
            $table->string('street')->nullable()->after('activity');
            $table->string('street_ext')->nullable()->after('street');
            $table->string('postal_code')->nullable()->after('street_ext');
            $table->string('city')->nullable()->after('postal_code');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('interested');
            $table->dropColumn('company');
            $table->dropColumn('activity');
            $table->dropColumn('street');
            $table->dropColumn('street_ext');
            $table->dropColumn('postal_code');
            $table->dropColumn('city');
        });
    }
};
