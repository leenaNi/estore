<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_history', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->nullable()->index();
            $table->string('pay_amount')->nullable();
            $table->bigInteger('added_by');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymnet_history', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->nullable()->index();
            $table->string('pay_amount')->nullable();
            $table->bigInteger('added_by');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable()->useCurrent();
        });
    }
}
