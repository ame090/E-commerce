@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center">
            <svg class="mx-auto h-24 w-24 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h1 class="text-3xl font-bold mt-6 mb-4">Seller Account Pending Approval</h1>
            <p class="text-gray-600 mb-8">Your seller account is currently under review. An administrator will review your application shortly.</p>
            
            <div class="bg-gray-50 p-6 rounded-lg max-w-md mx-auto text-left">
                <h2 class="font-semibold mb-2">Shop Information:</h2>
                <p class="text-sm text-gray-600">Shop Name: <span class="font-medium text-gray-900">{{ auth()->user()->seller->shop_name }}</span></p>
                <p class="text-sm text-gray-600">Status: <span class="font-medium text-yellow-600">{{ ucfirst(auth()->user()->seller->status) }}</span></p>
            </div>

            <a href="{{ route('home') }}" class="inline-block mt-8 bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700">Return to Home</a>
        </div>
    </div>
</div>
@endsection

