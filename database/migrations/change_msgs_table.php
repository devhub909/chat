<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Musonza\Chat\ConfigurationManager;

class UpdChatTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(ConfigurationManager::MESSAGES_TABLE, function (Blueprint $table) {
//            $table->dropUnique('linkedin_readableid');
            $table->bigInteger('delivered_ts_int')->unsigned()->nullable();
            $table->timestamp('delivered_ts')->nullable();
            $table->int('is_outgoing')->default(0);
            $table->int('is_need_send')->default(0);
            $table->int('is_send_success')->default(0);

        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
