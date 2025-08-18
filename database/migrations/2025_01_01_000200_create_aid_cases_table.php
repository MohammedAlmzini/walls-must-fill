<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('aid_cases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('qr_image_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->decimal('goal_amount', 12, 2)->nullable();
            $table->decimal('collected_amount', 12, 2)->default(0);
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('aid_cases');
    }
};