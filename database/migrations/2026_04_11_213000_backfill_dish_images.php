<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('dishes')
            ->whereNull('image')
            ->orWhere('image', '')
            ->update(['image' => '/images/dishes/default.svg']);
    }

    public function down(): void
    {
        DB::table('dishes')
            ->where('image', '/images/dishes/default.svg')
            ->update(['image' => null]);
    }
};
