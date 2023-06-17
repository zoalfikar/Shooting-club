<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('section');
            $table->string('description')->nullable();
            $table->tinyInteger('active');
            $table->decimal('price' ,9,2,true);
            $table->string('unit');
            $table->tinyInteger('fragmentable');
            $table->float('pace')->default(1);
            $table->timestamps();
            $table->foreign("section")->references("id")->on("menu_sections")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
