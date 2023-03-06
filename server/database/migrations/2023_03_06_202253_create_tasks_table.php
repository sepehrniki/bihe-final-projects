<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained('projects')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('created_by')
                ->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->longText('description');
            $table->enum('status', ['ToDo', 'Blocked', 'InProgress', 'InQA', 'Done', 'Deployed'])
                ->index()->default('ToDo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
