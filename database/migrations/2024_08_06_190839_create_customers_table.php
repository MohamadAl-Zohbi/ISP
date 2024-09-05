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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('number')->nullable();
            $table->text('location')->nullable();
            $table->text('description')->nullable();
            $table->date('expiry');
            $table->enum('nationality', ['lebanon', 'syria', 'pelastine', 'other'])->nullable();
            $table->string('user');
            $table->string('pass');
            $table->boolean('is_frozen')->default('0');

            // $table->unsignedBigInteger('service_id');
            // $table->foreign('service_id')
            //     ->references('id')
            //     ->on('services')
            //     ->onDelete('cascade');

            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
