<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

            Schema::create('tasks', function (Blueprint $table) {
                $table->id();
                $table->timestamps();
                $table->integer('step_id');
                $table->integer('assigned_id');
                $table->text('description');
                $table->date('date_end');

                $table->engine = 'InnoDB';
                $table->foreign('step_id')->references('id')->on('steps')->onUpdate('CASCADE')->onDelete('CASCADE');
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
       
            Schema::dropIfExists('tasks');
            DB::commit();
      
    }

}
