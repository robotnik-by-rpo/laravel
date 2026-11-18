<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained()->cascadeOnDelete();
            $table->foreignId('album_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->unsignedSmallInteger('year')->nullable();
            $table->unsignedInteger('duration')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['artist_id', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};