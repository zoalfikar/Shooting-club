<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->string('hall-table')->virtualAs('concat(concat(tableNumber,"--"),hallNumber)')->unique();
            $table->unsignedInteger('tableNumber');
            $table->unsignedInteger('hallNumber')->default(1);
            $table->tinyInteger('active')->default(1);
            $table->unsignedInteger('maxCapacity')->default(10);
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
        Schema::dropIfExists('tables');
    }
}
