<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('gift_id')->nullable();
            $table->string('code');
            $table->string('name')->nullable();
            $table->text('info')->nullable();
            $table->string('status')->default('pending');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('gift_id')
                ->references('id')
                ->on('gifts')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
