<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('excel_data', function (Blueprint $table) {
            $table->id();
            $table->integer('post_id');
            $table->string('author_name');
            $table->string('title');
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('excel_data');
    }
};
