<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
       
            Schema::create('steps', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->integer('project_id');
                $table->date('date_end');
                $table->text('description');
                $table->integer('assigned_id');

                $table->engine = 'InnoDB';

                $table->foreign('project_id')->references('id')->on('projects')->onUpdate('CASCADE')->onDelete('CASCADE');
                $table->foreign('assigned_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');

                $table->index('date_end');
        });
           
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
            DB::beginTransaction();
        Schema::dropIfExists('steps');
    }

}
