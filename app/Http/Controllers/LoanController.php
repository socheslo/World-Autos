<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    // Конструктор для застосування middleware аутентифікації
    public function __construct()
    {
        $this->middleware('auth'); // Захистити цей контролер аутентифікацією (якщо потрібно)
    }

    // Обробка запиту для розрахунку плану погашення
    public function calculatePaymentPlan(Request $request)
    {
        // Валідація вхідних даних
        $validated = $request->validate([
            'make' => 'required|string', // Вимога на марку автомобіля
            'model' => 'required|string', // Вимога на модель автомобіля
            'price' => 'required|numeric|min:0', // Вимога на ціну автомобіля
            'repayment_duration' => 'required|integer|min:1', // Вимога на тривалість кредиту (в місяцях)
            'interest_rate' => 'required|numeric|min:0', // Вимога на процентну ставку
        ]);

        // Виклик функції для розрахунку щомісячного платежу
        $monthlyPayment = $this->calculateMonthlyPayment($validated['price'], $validated['repayment_duration'], $validated['interest_rate']);
        
        // Розрахунок загальної суми, яку потрібно сплатити
        $totalPayment = $monthlyPayment * $validated['repayment_duration'];
        
        // Розрахунок загальної суми відсотків
        $totalInterest = $totalPayment - $validated['price'];

        // Форматування ціни у вигляді доларів з двома знаками після коми
        $priceInDollars = number_format($validated['price'], 2);

        // Збереження даних про кредит в базі даних
        Loan::create([
            'make' => $validated['make'],
            'model' => $validated['model'],
            'price' => $validated['price'],
            'repayment_duration' => $validated['repayment_duration'],
            'interest_rate' => $validated['interest_rate'],
            'monthly_payment' => $monthlyPayment,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest,
        ]);

        // Повернення результатів розрахунку на вигляд для відображення користувачу
        return view('payment-plan', compact('validated', 'monthlyPayment', 'totalPayment', 'totalInterest', 'priceInDollars'));
    }

    // Функція для розрахунку щомісячного платежу за формулою ануїтету
    private function calculateMonthlyPayment($principal, $numMonths, $rate)
    {
        // Перетворення річної процентної ставки в місячну
        $r = $rate / 100 / 12;
        $onePlusRN = pow((1 + $r), $numMonths);

        // Формула для розрахунку щомісячного платежу за ануїтетною схемою
        return $principal * $r * $onePlusRN / ($onePlusRN - 1);
    }

    // Відображення форми для введення даних користувачем
    public function showForm()
    {
        return view('calculate-payment');
    }
}

