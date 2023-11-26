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
        Schema::create('received_messages', function (Blueprint $table) {
            $table->id('msg_id');
            $table->integer('pkt_id')->default('0');
            $table->integer('client_no');
            $table->integer('topic_id');
            $table->string('message');
            $table->integer('qos')->default('0');
            $table->integer('retain')->default('0');
            $table->integer('confirmation_type');
            $table->integer('send_or_recv');
            $table->integer('status');
            $table->bigInteger('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_messages');
    }
};
