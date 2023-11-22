<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppTopCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('appTopCategory', function (Blueprint $table) {
            $table->id('id_appTopCategory');
            $table->unsignedBigInteger('id_application');
            $table->unsignedBigInteger('id_app');
            $table->timestamp('date');
            $table->text('context');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appTopCategory');
    }
}
