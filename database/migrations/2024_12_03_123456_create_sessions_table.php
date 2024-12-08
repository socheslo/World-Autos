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
        Schema::create('sessions', function (Blueprint $table) {
            // Створення первинного ключа для стовпця 'id'
            $table->string('id')->primary(); 

            // Створення зовнішнього ключа на таблицю 'users', який може бути порожнім (nullable) та індексований
            $table->foreignId('user_id')->nullable()->index(); 

            // Створення стовпця для зберігання IP-адреси користувача з обмеженням довжини 45 символів
            $table->string('ip_address', 45)->nullable(); 

            // Створення стовпця для зберігання агента користувача (наприклад, браузера) як текст
            $table->text('user_agent')->nullable(); 

            // Створення стовпця для зберігання корисних даних сесії. Використовуємо 'longText', оскільки дані можуть бути великими
            $table->longText('payload'); 

            // Створення індексованого стовпця для часу останньої активності
            $table->integer('last_activity')->index(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Якщо таблиця існує, її можна видалити
        Schema::dropIfExists('sessions');
    }
};
