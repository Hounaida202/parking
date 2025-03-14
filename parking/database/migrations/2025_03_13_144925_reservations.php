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
        Schema::create('reservations', function (Blueprint $table){
            $table->id();
            $table->date('date');
            $table->time('de');
            $table->time('a');
            $table->foreignId('places_id')->constrained('places')->onDelete('cascade'); 
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade');  
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
