<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTujuanPerjalanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tujuan_perjalanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fk_id_perjalanan')->constrained('perjalanans')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('fk_id_tujuan')->constrained('tujuans')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tujuan_perjalanans');
    }
}
