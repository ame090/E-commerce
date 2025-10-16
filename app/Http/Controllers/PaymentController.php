<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $toyyibpayUrl = 'https://dev.toyyibpay.com/';
    private $categoryCode;
    private $secretKey;

    public function __construct()
    {
        $this->categoryCode = env('TOYYIBPAY_CATEGORY_CODE');
        $this->secretKey = env('TOYYIBPAY_SECRET_KEY');
    }

    public function index(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payment.index', compact('order'));
    }

    public function create(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        try {
            $transactionId = 'TXN-' . strtoupper(uniqid());

            // Create payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'amount' => $order->total,
                'payment_method' => 'toyyibpay',
                'status' => 'pending',
            ]);

            // Create ToyyibPay bill
            $billData = [
                'userSecretKey' => $this->secretKey,
                'categoryCode' => $this->categoryCode,
                'billName' => 'Order ' . $order->order_number,
                'billDescription' => 'Payment for Order #' . $order->order_number,
                'billPriceSetting' => 1,
                'billPayorInfo' => 1,
                'billAmount' => number_format($order->total, 2, '.', '') * 100, // Convert to cents
                'billReturnUrl' => route('payment.callback'),
                'billCallbackUrl' => route('payment.callback'),
                'billExternalReferenceNo' => $transactionId,
                'billTo' => auth()->user()->name,
                'billEmail' => auth()->user()->email,
                'billPhone' => auth()->user()->phone ?? '0123456789',
            ];

            $response = Http::asForm()->post($this->toyyibpayUrl . 'index.php/api/createBill', $billData);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData[0]['BillCode'])) {
                    $billCode = $responseData[0]['BillCode'];
                    
                    $payment->billcode = $billCode;
                    $payment->save();

                    $paymentUrl = $this->toyyibpayUrl . $billCode;
                    
                    return redirect($paymentUrl);
                }
            }

            throw new \Exception('Failed to create ToyyibPay bill');

        } catch (\Exception $e) {
            return back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function callback(Request $request)
    {
        $billCode = $request->billcode;
        $statusId = $request->status_id;
        $transactionId = $request->transaction_id;

        $payment = Payment::where('billcode', $billCode)->first();

        if (!$payment) {
            return redirect()->route('home')->with('error', 'Payment not found');
        }

        $order = $payment->order;

        if ($statusId == 1) {
            // Payment successful
            $payment->status = 'successful';
            $payment->paid_at = now();
            $payment->response_data = json_encode($request->all());
            $payment->save();

            $order->payment_status = 'paid';
            $order->status = 'processing';
            $order->save();

            return redirect()->route('orders.show', $order)->with('success', 'Payment successful!');
        } elseif ($statusId == 2) {
            // Payment pending
            return redirect()->route('orders.show', $order)->with('info', 'Payment is pending');
        } else {
            // Payment failed
            $payment->status = 'failed';
            $payment->response_data = json_encode($request->all());
            $payment->save();

            return redirect()->route('orders.show', $order)->with('error', 'Payment failed');
        }
    }

    public function success()
    {
        return view('payment.success');
    }

    public function failed()
    {
        return view('payment.failed');
    }
}
