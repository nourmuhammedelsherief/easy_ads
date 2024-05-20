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
        Schema::create('easy_ads_seller_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('seller_name')->nullable();
            $table->enum('permanent' , ['true' , 'false'])->default('false');
            $table->enum('active' , ['true' , 'false'])->default('false');
            $table->double('percentage')->default(0);
            $table->double('code_percentage')->default(0);
            $table->double('commission')->default(0);
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('easy_ads_seller_codes');
    }
};
