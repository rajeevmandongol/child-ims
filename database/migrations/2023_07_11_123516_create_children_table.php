<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('children', function (Blueprint $table) {
            $table->id();
            $table->string('child_first_name');
            $table->string('child_middle_name');
            $table->string('child_last_name');
            $table->integer('child_age');
            $table->string('child_gender');
            $table->boolean('child_different_address')->default(false);
            $table->string('child_address')->nullable();
            $table->string('child_city')->nullable();
            $table->string('child_state')->nullable();
            $table->string('child_country')->nullable();
            $table->string('child_zip_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('children');
    }
};
