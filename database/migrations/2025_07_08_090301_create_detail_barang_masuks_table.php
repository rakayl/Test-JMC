<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_masuk_id');
            $table->string('kode');    
            $table->string('nama_barang', 200);    
            $table->integer('harga');    
            $table->integer('jumlah_barang');    
            $table->string('satuan');    
            $table->date('expired_date')->nullable();    
            $table->boolean('status')->default(0);    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_barang_masuks');
    }
};
