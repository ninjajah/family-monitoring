<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_type_id')->constrained('event_types')->onDelete('cascade');
            $table->foreignId('family_type_id')->constrained('family_types')->onDelete('cascade');
            $table->unsignedInteger('children_affected');
            $table->unsignedInteger('biological_children')->default(0);
            $table->unsignedInteger('foster_children')->default(0);
            $table->unsignedInteger('disabled_children')->default(0);
            $table->unsignedInteger('disabled_adults')->default(0);
            $table->unsignedInteger('children_in_family')->default(0);
            $table->unsignedInteger('children_in_institution')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
