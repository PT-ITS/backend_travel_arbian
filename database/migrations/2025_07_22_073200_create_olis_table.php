<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOlisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olis', function (Blueprint $table) {
            $table->id();
            $table->string('merk');
            $table->string('kilometer_mobil');
            $table->date('tanggal_ganti_oli');
            $table->integer('harga');
            $table->string('nota');
            $table->foreignId('fk_id_mobil')->constrained('mobils')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('olis');
    }
}
