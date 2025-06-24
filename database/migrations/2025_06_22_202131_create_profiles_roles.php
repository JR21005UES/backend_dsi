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
        Schema::create('profiles_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');  // Asegúrate de que sea unsignedBigInteger
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('restrict');
            $table->unsignedBigInteger('role_id');  // Asegúrate de que sea unsignedBigInteger
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
