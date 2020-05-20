<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EntrustSetupTables extends Migration {

    public function up() {
   


        // Create table for storing roles
        Schema::create('vswipe_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('vswipe_role_user', function (Blueprint $table) {
            $table->bigInteger('vswipe_user_id')->unsigned();
            $table->bigInteger('vswipe_role_id')->unsigned();

            $table->foreign('vswipe_user_id')->references('id')->on('vswipe_users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vswipe_role_id')->references('id')->on('vswipe_roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['vswipe_user_id', 'vswipe_role_id']);
        });

        // Create table for storing permissions
        Schema::create('vswipe_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('vswipe_permission_role', function (Blueprint $table) {
            $table->bigInteger('vswipe_permission_id')->unsigned();
            $table->bigInteger('vswipe_role_id')->unsigned();

            $table->foreign('vswipe_permission_id')->references('id')->on('vswipe_permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vswipe_role_id')->references('id')->on('vswipe_roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['vswipe_permission_id', 'vswipe_role_id']);
        });
        
        
             // Create table for storing roles
        Schema::create('bank_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating roles to users (Many-to-Many)
        Schema::create('bank_role_user', function (Blueprint $table) {
            $table->bigInteger('bank_user_id')->unsigned();
            $table->bigInteger('bank_role_id')->unsigned();

            $table->foreign('bank_user_id')->references('id')->on('bank_users')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('bank_role_id')->references('id')->on('bank_roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['bank_user_id', 'bank_role_id']);
        });

        // Create table for storing permissions
        Schema::create('bank_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Create table for associating permissions to roles (Many-to-Many)
        Schema::create('bank_permission_role', function (Blueprint $table) {
            $table->bigInteger('bank_permission_id')->unsigned();
            $table->bigInteger('bank_role_id')->unsigned();

            $table->foreign('bank_permission_id')->references('id')->on('bank_permissions')
                    ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('bank_role_id')->references('id')->on('bank_roles')
                    ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['bank_permission_id', 'bank_role_id']);
        });
    }

  
    public function down() {
        Schema::drop('bank_permission_role');
        Schema::drop('bank_permissions');
        Schema::drop('bank_role_user');
        Schema::drop('bank_roles');

        Schema::drop('vswipe_permission_role');
        Schema::drop('vswipe_permissions');
        Schema::drop('vswipe_role_user');
        Schema::drop('vswipe_roles');
    }

}
