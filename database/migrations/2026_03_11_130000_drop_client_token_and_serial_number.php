<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'token')) {
                try {
                    $table->dropUnique(['token']);
                } catch (\Throwable $e) {
                }

                $table->dropColumn('token');
            }

            if (Schema::hasColumn('clients', 'serial_number')) {
                $table->dropColumn('serial_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'serial_number')) {
                $table->string('serial_number')->nullable()->after('id');
            }

            if (!Schema::hasColumn('clients', 'token')) {
                $table->string('token')->nullable()->unique()->after('phone');
            }
        });
    }
};

