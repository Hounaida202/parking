<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table){
            $table->id();
            $table->string('numeré');

            $table->string('secteur');

            $table->enum('status', ['vide', 'plein']);

      
            $table->foreignId('parkings_id')->constrained('parkings')->onDelete('cascade');  
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
        //
    }
};
