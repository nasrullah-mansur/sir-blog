<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_upcomings', function (Blueprint $table) {
            $table->id();
            $table->integer('blog_id');
            $table->integer('p_id');
            $table->text('name')->nullable();
            $table->text('email')->nullable();
            $table->text('status');
            $table->longText('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_upcomings');
    }
};
