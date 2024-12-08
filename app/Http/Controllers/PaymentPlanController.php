<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Додано імпорт фасаду Auth

class PaymentPlanController extends Controller
{
    // Конструктор для застосування middleware аутентифікації
    public function __construct()
    {
        $this->middleware('auth'); // Захищає всі методи контролера (тільки авторизовані користувачі можуть отримати доступ)
    }

    // Відображення форми для додавання нового транспортного засобу
    public function showAddVehicleForm()
    {
        return view('vehicles.add'); // Повертає вигляд для додавання транспортного засобу
    }

    // Обробка розрахунку плану погашення кредиту
    public function calculate(Request $request)
    {
        // Перевірка, чи користувач аутентифікований
        if (!Auth::check()) {
            abort(403, 'Користувач не аутентифікований'); // Якщо не аутентифікований, відправляється помилка 403
        }

        // Валідація вхідних даних
        $data = $request->validate([
            'make' => 'required|string', // Марка автомобіля обов'язкова і має бути рядком
            'model' => 'required|string', // Модель автомобіля обов'язкова і має бути рядком
            'price' => 'required|numeric|min:0', // Ціна має бути числом та не менше 0
            'repayment-duration' => 'required|integer|min:1', // Тривалість погашення має бути цілим числом і не менше 1
            'interest-rate' => 'required|numeric|min:0', // Процентна ставка має бути числом та не менше 0
            'image' => 'required|string', // Зображення обов'язкове і має бути рядком (шлях до файлу)
        ]);

        // Витягування даних з валідації
        $price = $data['price'];
        $repaymentDuration = $data['repayment-duration'];
        $interestRate = $data['interest-rate'];

        // Розрахунок щомісячного платежу, загальної суми та загальних відсотків
        $monthlyPayment = $this->calculateMonthlyPayment($price, $repaymentDuration, $interestRate);
        $totalPayment = $this->calculateTotalPayment($price, $repaymentDuration, $interestRate);
        $totalInterest = $this->calculateTotalInterest($price, $repaymentDuration, $interestRate);

        // Збереження запису в базі даних без зображення
        $loan = \App\Models\Loan::create([
            'user_id' => Auth::id(), // Зберігається ID користувача, який створює запис
            'make' => $data['make'], // Марка автомобіля
            'model' => $data['model'], // Модель автомобіля
            'price' => $price, // Ціна
            'repayment_duration' => $repaymentDuration, // Тривалість
            'interest_rate' => $interestRate, // Процентна ставка
            'total_payment' => $totalPayment, // Загальна сума
            'total_interest' => $totalInterest, // Загальний відсоток
            'monthly_payment' => $monthlyPayment, // Щомісячний платіж
        ]);

        // Повернення вигляду з результатами розрахунку
        return view('payment-plan.result', [
            'loan' => (object) [
                'make' => $data['make'],
                'model' => $data['model'],
                'price' => $price,
                'repayment_duration' => $repaymentDuration,
                'interest_rate' => $interestRate,
                'total_payment' => $totalPayment,
                'total_interest' => $totalInterest,
                'monthly_payment' => $monthlyPayment,
                'image' => $data['image'], // Зображення передається лише для відображення
            ],
        ]);
    }

    // Перегляд результату кредиту по його ID
    public function showPaymentPlan($loanId)
    {
        // Отримання запису позики з бази даних
        $loan = \App\Models\Loan::findOrFail($loanId); // Якщо запис не знайдений, повертається помилка 404

        // Повернення вигляду для відображення плану
        return view('payment-plan.result', compact('loan'));
    }

    // Функція для розрахунку щомісячного платежу
    private function calculateMonthlyPayment($price, $repaymentDuration, $interestRate)
    {
        // Перетворення процентної ставки на місячну ставку
        $monthlyRate = $interestRate / 12 / 100; // Річна ставка переведена на місячну
        // Формула для розрахунку щомісячного платежу
        return $monthlyRate > 0
            ? ($price * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$repaymentDuration))
            : $price / $repaymentDuration; // Якщо ставка 0%, то розрахунок лінійний
    }

    // Функція для розрахунку загальної суми до сплати
    private function calculateTotalPayment($price, $repaymentDuration, $interestRate)
    {
        // Загальний платіж (щомісячний платіж * тривалість)
        return $this->calculateMonthlyPayment($price, $repaymentDuration, $interestRate) * $repaymentDuration;
    }

    // Функція для розрахунку загальних відсотків
    private function calculateTotalInterest($price, $repaymentDuration, $interestRate)
    {
        // Загальний відсоток (загальна сума - початкова сума)
        return $this->calculateTotalPayment($price, $repaymentDuration, $interestRate) - $price;
    }
}
