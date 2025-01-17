<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransactionDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->string('disburse_id');
            $table->string('amount');
            $table->timestamp('timestamp')->nullable();
            $table->string('account_number');
            $table->string('beneficiary_name');
            $table->string('remark')->nullable();
            $table->text('receipt')->nullable();
            $table->timestamp('time_served')->nullable(); 
            $table->string('fee',15);
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
        Schema::dropIfExists('transaction_detail');
    }
}
