<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Захистити цей контролер аутентифікацією (якщо потрібно)
    }

    public function calculatePaymentPlan(Request $request)
    {
        // Валідація запиту
        $validated = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'price' => 'required|numeric|min:0',
            'repayment_duration' => 'required|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
        ]);

        // Розрахунок щомісячного платежу
        $monthlyPayment = $this->calculateMonthlyPayment($validated['price'], $validated['repayment_duration'], $validated['interest_rate']);
        
        // Розрахунок загальної суми
        $totalPayment = $monthlyPayment * $validated['repayment_duration'];
        
        // Розрахунок загальних відсотків
        $totalInterest = $totalPayment - $validated['price'];

        // Форматуємо ціну в доларах
        $priceInDollars = number_format($validated['price'], 2);

        // Зберігаємо дані в базі даних
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

        // Повернення результатів на вигляд
        return view('payment-plan', compact('validated', 'monthlyPayment', 'totalPayment', 'totalInterest', 'priceInDollars'));
    }

    // Функція для розрахунку щомісячного платежу
    private function calculateMonthlyPayment($principal, $numMonths, $rate)
    {
        // Перетворення процентної ставки в місячний коефіцієнт
        $r = $rate / 100 / 12;
        $onePlusRN = pow((1 + $r), $numMonths);

        // Формула для розрахунку щомісячного платежу
        return $principal * $r * $onePlusRN / ($onePlusRN - 1);
    }

    // Функція для відображення форми
    public function showForm()
    {
        return view('calculate-payment');
    }
}
