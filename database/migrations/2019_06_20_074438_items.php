<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Items extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id_item')->comment('ID предмета');
            $table->text('caption_item')->comment('Наименование предмета');
            $table->text('reg_num_item')->comment('Регистрационный номер');
            $table->text('ser_num_item')->comment('Серийный номер');
            $table->text('num_agrement_item')->comment('Номер договора')->nullable($value = true);
            $table->date('date_agrement_item')->comment('Дата договора')->nullable($value = true);
            $table->text('notation_item')->comment('Пояснение')->nullable($value = true);
            $table->integer('accounting_item')->comment('Метод учета');
            $table->timestamp('add_date_item')->comment('Дата добавления предмета')->useCurrent();
            $table->date('buy_date_item')->comment('Дата приобретения');
            $table->date('guarantee_date_item')->comment('Дата завершения гарантии');
            $table->text('comment_item')->comment('Примечание')->nullable($value = true);
            $table->integer('current_user_item')->comment('Текущий пользователь');
            $table->integer('status_item')->comment('Статус предмета');
            $table->integer('depreciation_item')->comment('Флаг списания')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('items');
    }
}
