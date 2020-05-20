<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('bills', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('vendor_id');
        //     $table->string('bill');
        //     $table->string('currency');
        //     $table->string('po_so');
        //     $table->string('note');
        //     $table->string('note');
        //     $table->date('date');
        //     $table->date('due_date');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
