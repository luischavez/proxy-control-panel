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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('path', 128);
            $table->enum('type', ['proxy', 'redirect']);
            $table->enum('subtype', ['http', 'ws'])->nullable();
            $table->text('target');
            $table->integer('connect_timeout')->default(60);
            $table->integer('send_timeout')->default(60);
            $table->integer('read_timeout')->default(60);
            $table->boolean('enable_x_headers')->default(true);
            $table->foreignId('subdomain_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('restrict');
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
        Schema::dropIfExists('locations');
    }
};
