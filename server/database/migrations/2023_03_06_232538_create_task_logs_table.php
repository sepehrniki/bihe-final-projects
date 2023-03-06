<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')
                ->constrained('tasks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('changed_by')
                ->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('old_status', ['ToDo', 'Blocked', 'InProgress', 'InQA', 'Done', 'Deployed'])->index();
            $table->enum('new_status', ['ToDo', 'Blocked', 'InProgress', 'InQA', 'Done', 'Deployed'])->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_logs');
    }
};
