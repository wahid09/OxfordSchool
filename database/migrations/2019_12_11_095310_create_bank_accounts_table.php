<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('financialorganization_id')->unsigned()->index();
            $table->foreign('financialorganization_id')->references('id')
                  ->on('financial_organizations')->onDelete('cascade');
            $table->bigInteger('store_id')->nullable();
            $table->string('account_name');
            $table->string('account_no');
            $table->string('branch');
            $table->tinyInteger('account_type')->default(1);
            $table->string('swift_code');
            $table->string('route_no');
            $table->softDeletes();
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
        Schema::dropIfExists('bank_accounts');
    }
}
