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
        Schema::create('ship_campaign_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->integer('age');
            $table->text('question1_answer');
            $table->text('question2_answer');
            $table->text('question3_answer');
            $table->text('question4_answer');
            $table->text('question5_answer');
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
        Schema::dropIfExists('ship_campaign_surveys');
    }
};
