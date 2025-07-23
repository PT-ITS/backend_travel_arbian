<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTilangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tilangs', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_tilang');
            $table->string('jenis_pelanggaran');
            $table->text('keterangan');
            $table->string('lokasi');
            $table->foreignId('fk_id_mobil')->constrained('mobils')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('fk_id_pj')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tilangs');
    }
}
