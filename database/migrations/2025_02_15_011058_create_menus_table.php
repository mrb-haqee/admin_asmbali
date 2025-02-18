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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('group', 255); //* pilih antara 'masterdata', 'administrasi', 'web_asm','web_tpq',
            $table->string('name', 255);
            $table->enum('option', ['__YES__', '__NO__'])->default('__NO__');
            $table->unsignedInteger('index_sort');

            $table->string('status', 30)->default('__ON__');
            $table->unsignedBigInteger('user_id')->default(1);
            $table->unsignedBigInteger('user_id_update')->default(1);
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('user_id_update')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
