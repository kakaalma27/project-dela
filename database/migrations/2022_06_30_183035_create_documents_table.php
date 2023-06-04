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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evidence_id')->nullable()->constrained('evidences')->onDelete('cascade');
            $table->string('user_id');
            $table->boolean('status')->default(false);
            $table->boolean('pending')->default(false);
            $table->boolean('invalid')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['evidence_id']);
        });
        Schema::dropIfExists('documents');    }
};
