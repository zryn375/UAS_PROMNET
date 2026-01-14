<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->text('summary')->nullable();
            $table->string('category'); // Pendidikan, Teknologi, Ilmu Pengetahuan
            $table->string('cover_image')->nullable();
            $table->string('reading_time'); // Estimasi waktu baca
            $table->integer('view_count')->default(0);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
};