<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePajaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pajaks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_pajak');
            $table->enum('jenis_pajak', [
                '0', // tahunan
                '1', // 5 tahun
            ]);
            $table->string('lokasi_samsat');
            $table->integer('biaya');
            $table->string('nota');
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
        Schema::dropIfExists('pajaks');
    }
}
