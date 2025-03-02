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
        Schema::create('account_subs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('kode', 50)->unique();
            $table->string('name', 100);
            $table->text('keterangan')->nullable();
            
            $table->string('status', 30)->default('__ON__');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('user_id_update')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_subs');
    }
};
