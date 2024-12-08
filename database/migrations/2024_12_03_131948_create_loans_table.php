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
        Schema::create('loans', function (Blueprint $table) {
            // Створення автоматичного первинного ключа для таблиці (ідентифікатор позики)
            $table->id();

            // Створення зовнішнього ключа на таблицю 'users' для вказівки на користувача, який взяв позику
            $table->unsignedBigInteger('user_id');

            // Створення стовпців для даних позики
            $table->string('make');                // Марка транспортного засобу
            $table->string('model');               // Модель транспортного засобу
            $table->decimal('price', 10, 2);       // Ціна позики (до 10 цифр, 2 знаки після коми)
            $table->integer('repayment_duration'); // Тривалість погашення позики (в місяцях)
            $table->decimal('interest_rate', 5, 2); // Процентна ставка позики (до 5 цифр, 2 знаки після коми)
            $table->decimal('total_payment', 10, 2); // Загальна сума до сплати (основна сума + відсотки)
            $table->decimal('total_interest', 10, 2); // Загальний відсоток (відсотки по позиці)
            $table->decimal('monthly_payment', 10, 2); // Щомісячний платіж (відповідно до розрахунків)
            
            // Створення автоматичних стовпців для збереження часу створення та оновлення запису
            $table->timestamps();

            // Додавання зовнішнього ключа для стовпця 'user_id', що вказує на таблицю 'users'
            // Якщо користувач буде видалений, то й усі пов'язані позики будуть видалені (onDelete('cascade'))
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Якщо таблиця 'loans' існує, її можна видалити
        Schema::dropIfExists('loans');
    }
};

