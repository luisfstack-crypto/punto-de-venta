<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserApprovalController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.users.pending', compact('pendingUsers'));
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Usuario validado y activado correctamente.');
    }

    public function reject(User $user)
    {
        if ($user->payment_receipt) {
            Storage::disk('public')->delete($user->payment_receipt);
        }

        $user->update([
            'status' => 'rejected',
            'payment_receipt' => null
        ]);

        return redirect()->back()->with('success', 'Usuario rechazado y su comprobante fue eliminado.');
    }
}
