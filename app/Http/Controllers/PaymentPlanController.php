<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Додано імпорт фасаду Auth

class PaymentPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Захищає всі методи контролера
    }

    public function showAddVehicleForm()
    {
        return view('vehicles.add'); // Повернення вигляду для додавання транспортного засобу
    }

    public function calculate(Request $request)
    {
        // Перевірка, чи користувач аутентифікований
        if (!Auth::check()) {
            abort(403, 'Користувач не аутентифікований');
        }
    
        // Валідація даних
        $data = $request->validate([
            'make' => 'required|string',
            'model' => 'required|string',
            'price' => 'required|numeric|min:0',
            'repayment-duration' => 'required|integer|min:1',
            'interest-rate' => 'required|numeric|min:0',
            'image' => 'required|string',
        ]);
    
        // Розрахунок платежів
        $price = $data['price'];
        $repaymentDuration = $data['repayment-duration'];
        $interestRate = $data['interest-rate'];
    
        $monthlyPayment = $this->calculateMonthlyPayment($price, $repaymentDuration, $interestRate);
        $totalPayment = $this->calculateTotalPayment($price, $repaymentDuration, $interestRate);
        $totalInterest = $this->calculateTotalInterest($price, $repaymentDuration, $interestRate);
    
        // Збереження запису в базі даних без зображення
        $loan = \App\Models\Loan::create([
            'user_id' => Auth::id(),
            'make' => $data['make'],
            'model' => $data['model'],
            'price' => $price,
            'repayment_duration' => $repaymentDuration,
            'interest_rate' => $interestRate,
            'total_payment' => $totalPayment,
            'total_interest' => $totalInterest,
            'monthly_payment' => $monthlyPayment,
        ]);
    
        // Передача даних у вигляд для відображення
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
                'image' => $data['image'], // Передаємо зображення тільки у вигляд
            ],
        ]);
    

        // Перенаправлення до сторінки результату
        return redirect()->route('payment.plan.result', ['loanId' => $loan->id]);
    }

    public function showPaymentPlan($loanId)
    {
        // Отримання запису позики
        $loan = \App\Models\Loan::findOrFail($loanId);

        // Повернення вигляду для відображення плану
        return view('payment-plan.result', compact('loan'));
    }

    private function calculateMonthlyPayment($price, $repaymentDuration, $interestRate)
    {
        // Додайте логіку розрахунку щомісячного платежу
        $monthlyRate = $interestRate / 12 / 100; // Перетворення відсотків на десяткове число
        return $monthlyRate > 0
            ? ($price * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$repaymentDuration))
            : $price / $repaymentDuration;
    }

    private function calculateTotalPayment($price, $repaymentDuration, $interestRate)
    {
        // Загальний платіж (щомісячний платіж × тривалість)
        return $this->calculateMonthlyPayment($price, $repaymentDuration, $interestRate) * $repaymentDuration;
    }

    private function calculateTotalInterest($price, $repaymentDuration, $interestRate)
    {
        // Загальний відсоток (загальний платіж - початкова сума)
        return $this->calculateTotalPayment($price, $repaymentDuration, $interestRate) - $price;
    }
}
