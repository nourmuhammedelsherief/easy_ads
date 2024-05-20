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
        Schema::create('easy_ads_settings', function (Blueprint $table) {
            $table->id();
            $table->enum('subscription_type' , ['free' , 'paid'])->default('free');
            $table->double('subscription_amount')->default(0);
            $table->double('tax')->default(0);
            $table->enum('bank_transfer' , ['true' , 'false'])->default('true');
            $table->enum('online_payment' , ['myFatoourah' , 'paylink' , 'none'])->default('myFatoourah');
            $table->enum('online_payment_type' , ['test' , 'online'])->default('test');
            $table->string('myFatoourah_token')->nullable();
            $table->string('pay_link_app_id')->nullable();
            $table->string('pay_link_secret_key')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('easy_ads_settings');
    }
};
