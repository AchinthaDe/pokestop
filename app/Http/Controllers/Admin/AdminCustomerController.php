<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')->withCount('orders');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by banned status
        if ($request->filled('banned')) {
            $query->where('banned', $request->banned === 'yes');
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function($query) {
            $query->with('items.product')->orderBy('created_at', 'desc');
        }]);

        $stats = [
            'total_orders' => $user->orders->count(),
            'total_spent' => $user->orders->where('status', 'paid')->sum('total'),
            'average_order' => $user->orders->where('status', 'paid')->avg('total'),
        ];

        return view('admin.customers.show', compact('user', 'stats'));
    }

    public function ban(Request $request, User $user)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $user->update([
            'banned' => true,
            'banned_at' => now(),
            'ban_reason' => $request->reason
        ]);

        return back()->with('success', 'User has been banned successfully');
    }

    public function unban(User $user)
    {
        $user->update([
            'banned' => false,
            'banned_at' => null,
            'ban_reason' => null
        ]);

        return back()->with('success', 'User has been unbanned successfully');
    }
}
