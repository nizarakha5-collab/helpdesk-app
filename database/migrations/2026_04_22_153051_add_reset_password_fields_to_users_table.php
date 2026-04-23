<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('reset_password_code', 10)->nullable()->after('code_expires_at');
            $table->dateTime('reset_password_expires_at')->nullable()->after('reset_password_code');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reset_password_code',
                'reset_password_expires_at',
            ]);
        });
    }
};