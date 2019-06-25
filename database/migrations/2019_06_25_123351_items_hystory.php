<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemsHystory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_hystory', function (Blueprint $table) {
            $table->bigIncrements('id_hystory');
            $table->integer('last_user_hystory')->comment('Предыдущий пользователь')->default(1);
            $table->integer('current_user_hystory')->comment('Текущий пользователь')->default(1);
            $table->integer('item_status_hystory')->comment('Статус предмета')->default(1);
            $table->integer('id_item_hystory')->comment('Код предмета')->default(1);
            $table->text('reason_hystory')->comment('Причина перемещения')->nullable($value = true);
            $table->timestamp('date_hystory')->comment('Дата добавления истории')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items_history');
    }
}
