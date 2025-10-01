<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CraeteTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->string('provider_id');
            $table->string('transaction_id')->nullable();
            $table->string('from')->nullable();
            $table->float('amount');
            $table->float('balance')->nullable();;
            $table->string('sim_number')->nullable();
            $table->string('username')->nullable();
            $table->text('name')->nullable();
            $table->text('response')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->unique('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
