<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiResponsesTable extends Migration
{
    public function up()
    {
        Schema::create('api_responses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('country_id');
            $table->date('date_from');
            $table->date('date_to');
            $table->json('response');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_responses');
    }
}
