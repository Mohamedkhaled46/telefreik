<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_cards', function (Blueprint $table) {
            $table->id();
            $table->string('creditCardNumber')->nullable();
            $table->dateTime('creditCardExpirationDate')->nullable();
            $table->string('creditCardType')->nullable();
            $table->string('state')->nullable();
            $table->foreignId('customer_id')->constrained();
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
        Schema::table('credit_cards', function (Blueprint $table) {
            Schema::dropIfExists('credit_cards');
            // $table->dropForeign('lists_user_id_foreign');
            // $table->dropIndex('lists_user_id_index');
            // $table->dropColumn('user_id')
        });
    }
}
