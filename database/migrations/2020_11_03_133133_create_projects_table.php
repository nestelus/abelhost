<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       
            Schema::create('projects', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->string('title');
                $table->date('date_start');
                $table->date('date_end')->nullable();
                $table->text('description')->nullable();
                $table->integer('creator_id');
                $table->integer('assigned_id')->nullable();

                $table->engine = 'InnoDB';
                $table->foreign('creator_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
                $table->foreign('assigned_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
                $table->index('date_start');
            });
           
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        
            DB::beginTransaction();
            Schema::dropIfExists('projecrs');
    }

}
