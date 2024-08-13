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
        Schema::create('exterior_interior', function (Blueprint $table) {
            $table->id();
            $table->enum('basiskleur', [
                'beige', 'blauw', 'bruin', 'creme', 'groen', 'geel', 'goud',
                'grijs', 'oranje', 'paars', 'rood', 'roze', 'wit', 'zilver',
                'zwart', 'overig'
            ]);
            $table->enum('laksoort', ['basis', 'metallic', 'mica', 'parelmoer']);
            $table->text('interieurkleur');
            $table->text('bekleding');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('exterior_interior');
    }
};
