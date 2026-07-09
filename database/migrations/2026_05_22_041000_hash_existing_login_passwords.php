<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('logins')) {
            return;
        }

        DB::table('logins')
            ->select('id', 'password')
            ->orderBy('id')
            ->each(function (object $login): void {
                if (password_get_info($login->password)['algo'] !== PASSWORD_BCRYPT) {
                    DB::table('logins')
                        ->where('id', $login->id)
                        ->update(['password' => Hash::make($login->password)]);
                }
            });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Password hashes cannot be safely converted back to their original values.
    }
};
