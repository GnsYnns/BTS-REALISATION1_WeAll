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
        Schema::create('post_message', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_users');
            $table->foreign('id_users')->references('id')->on('users');
            
            $table->longText('text');

            $table->integer('nb_comment')->default(0);
            $table->integer('nb_like')->default(0);

            $table->unsignedBigInteger('id_referencecomment')->nullable();
            $table->foreign('id_referencecomment')->references('id')->on('post_message');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_message');
        Schema::table('post_message', function (Blueprint $table) {
            $table->unsignedBigInteger('id_referencecomment')->change();
        });
    }
};
