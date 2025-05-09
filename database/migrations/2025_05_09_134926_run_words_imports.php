<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Console\Commands\ImportWordsCommand;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call(ImportWordsCommand::class);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
