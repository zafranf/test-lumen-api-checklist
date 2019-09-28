<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChecklistItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checklist_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->timestamp('due')->nullable();
            $table->integer('due_interval')->nullable();
            $table->string('due_unit')->nullable();
            $table->boolean('urgency')->nullable();
            $table->bigInteger('checklist_id');
            $table->boolean('is_completed')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('checklist_items');
    }
}
