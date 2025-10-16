<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('seller')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return back()->with('success', 'User status updated');
    }

    public function sellers()
    {
        $sellers = Seller::with('user')
            ->withCount(['products', 'orders'])
            ->latest()
            ->paginate(20);
        return view('admin.sellers.index', compact('sellers'));
    }

    public function approveSeller(Seller $seller)
    {
        $seller->status = 'approved';
        $seller->save();

        return back()->with('success', 'Seller approved successfully');
    }

    public function rejectSeller(Seller $seller)
    {
        $seller->status = 'rejected';
        $seller->save();

        return back()->with('success', 'Seller rejected');
    }
}
