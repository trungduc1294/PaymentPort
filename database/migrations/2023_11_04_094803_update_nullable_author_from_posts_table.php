<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateNullableAuthorFromPostsTable extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->bigInteger('author_id')->nullable()->change();
            $table->string('author_name')->nullable()->change();
        });
    }
}
