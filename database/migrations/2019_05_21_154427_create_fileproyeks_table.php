<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileproyeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileproyeks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('namafile');
            $table->string('lokasifile');
            $table->integer('status')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('proyek_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('kategori_id')->references('id')->on('kategoris');
            $table->foreign('proyek_id')->references('id')->on('proyeks');
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
        Schema::dropIfExists('fileproyeks');
    }
}
