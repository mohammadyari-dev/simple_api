<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
