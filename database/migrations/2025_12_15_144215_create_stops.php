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
        Schema::create('stops', function (Blueprint $table) {
            $table->id();
            $table->integer('order');
            $table->timestamp('departure_time')->useCurrent();// default timestamp requis par mysql
            $table->timestamp('arrival_time')->useCurrent();
            $table->string('address');
            // Sans unique, les seeders pourraient mettre des proposals diff pour un meme trip
            $table->foreignIdFor(\App\Models\Trip::class)->unique()
                ->constrained('trips', 'id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stops');
    }
};
