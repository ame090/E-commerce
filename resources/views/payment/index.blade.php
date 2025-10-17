@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold mb-4">Payment</h1>
            <p class="text-gray-600">Complete your payment for Order #{{ $order->order_number }}</p>
        </div>

        <div class="bg-gray-50 p-8 rounded-lg mb-8">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg font-semibold">Total Amount</span>
                <span class="text-3xl font-bold text-teal-600">RM {{ number_format($order->total, 2) }}</span>
            </div>

            <div class="border-t pt-4 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>RM {{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span>RM {{ number_format($order->shipping, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax</span>
                    <span>RM {{ number_format($order->tax, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 p-6 rounded-lg mb-8">
            <h2 class="font-semibold text-blue-900 mb-2">Payment Method: ToyyibPay</h2>
            <p class="text-sm text-blue-800">You will be redirected to ToyyibPay to complete your payment securely.</p>
        </div>

        <form action="{{ route('payment.create', $order) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-emerald-600 text-white px-6 py-4 rounded-lg hover:bg-emerald-700 font-semibold text-lg">
                Proceed to Payment
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('orders.show', $order) }}" class="text-teal-600 hover:underline">← Back to Order</a>
        </div>
    </div>
</div>
@endsection

