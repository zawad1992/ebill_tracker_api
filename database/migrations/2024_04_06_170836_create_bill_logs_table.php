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
        Schema::create('bill_logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('type')->nullable()->comment('1: Electricity, 2: Gas, 3: Water, 4: Internet, 5: Phone, 6: Others');
            $table->double('amount')->nullable();
            $table->date('logdate')->nullable();
            $table->time('logtime')->nullable();
            $table->text('remarks')->charset('utf8mb4')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('bill_logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_logs');
    }
};
