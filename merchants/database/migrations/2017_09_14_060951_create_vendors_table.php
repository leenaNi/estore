<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_name')->nullable();
            $table->string('email')->nullable();
            $table->string('fname_contact')->nullable();
            $table->string('lname_contact')->nullable();
            $table->string('currency')->nullable();
            $table->string('account_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->string('toll_free')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
