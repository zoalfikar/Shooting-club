<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePointsBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_points_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_point');
            $table->unsignedBigInteger('sale_point_acountant');
            $table->string('acountant_name');
            $table->json('order');
            $table->double('total')->default(0);
            $table->unsignedBigInteger('inventory')->nullable();
            $table->foreign('sale_point')->references('id')->on('sale_points')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sale_point_acountant')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('inventory')->references('id')->on('inventories')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('sale_points_bills');
    }
}
