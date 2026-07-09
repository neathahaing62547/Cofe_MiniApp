<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('login') && ! Schema::hasTable('logins')) {
            Schema::rename('login', 'logins');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('logins') && ! Schema::hasTable('login')) {
            Schema::rename('logins', 'login');
        }
    }
};
