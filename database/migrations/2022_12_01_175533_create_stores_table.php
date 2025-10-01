<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->string('store_key')->unique()->nullable();
            $table->string('integration');
            $table->text('key');
            $table->string('name');
            $table->string('username');
            $table->string('username_chaild')->nullable();
            $table->string('password_chaild')->nullable();
            $table->text('domain');
            $table->string('logo')->default('default.png');
            $table->double('currency', 10, 2)->default(1);
            $table->text('mobile_wallet')->nullable();
            $table->text('whatsapp')->nullable();
            $table->string('ratesync')->default(0);
            $table->boolean('synctype')->default(0);
            $table->boolean('sim1')->default(1);
            $table->boolean('sim2')->default(1);
            $table->string('yourcurrency')->nullable();
            $table->string('storecurrency')->nullable();
            $table->boolean('actions')->default(1);
            $table->boolean('status')->default(0);
            $table->timestamp('expiry')->nullable();
            $table->boolean('afc')->default(0)->nullable();
            $table->boolean('bonus')->default(0)->nullable();
            $table->float('bonus_amount')->nullable();
            $table->float('bonus_from')->nullable();
            $table->boolean('device')->default(0)->nullable();
            $table->unsignedBigInteger('next_month_invoice_id')->nullable();
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
        Schema::dropIfExists('stores');
    }
}
