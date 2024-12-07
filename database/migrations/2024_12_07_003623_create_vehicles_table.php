<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id(); // Унікальний ідентифікатор
            $table->string('make'); // Виробник
            $table->string('model'); // Модель
            $table->integer('year'); // Рік випуску
            $table->integer('mileage'); // Пробіг
            $table->decimal('price', 10, 2); // Ціна
            $table->string('image'); // Шлях до зображення
            $table->timestamps(); // Час створення та оновлення
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles'); // Видалення таблиці
    }
};

