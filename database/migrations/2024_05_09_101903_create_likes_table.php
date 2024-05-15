<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id'); // Utilise bigIncrements pour id
            $table->unsignedBigInteger('user_id'); // Définit explicitement le type de données
            $table->unsignedBigInteger('post_message_id'); // Définit explicitement le type de données
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_message_id')->references('id')->on('post_message')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
