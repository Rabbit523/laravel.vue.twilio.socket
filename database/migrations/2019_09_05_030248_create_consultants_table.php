<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id')->nullable();
            $table->string('industry_expertise')->nullable();
            $table->integer('phone_contact')->nullable();
            $table->integer('chat_contact')->nullable();
            $table->integer('video_contact')->nullable();
            $table->string('company_name')->nullable();
            $table->string('invoice_mail')->nullable();
            $table->string('invoice_first_name')->nullable();
            $table->string('invoice_last_name')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('invoice_zip_code')->nullable();
            $table->string('invoice_zip_place')->nullable();
            $table->string('password')->nullable();
            $table->string('prof_image')->nullable();
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
        Schema::dropIfExists('consultants');
    }
}
