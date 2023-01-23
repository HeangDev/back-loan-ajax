<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Withdraw;

class NotificationController extends Controller
{
    // Notification Loan
    public function reload_Notifications() {
        $loans = Loan::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->where('amount', '>', '0')
        ->orderBy('id', 'DESC')->latest()->get();
        $withdraws = Withdraw::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->orderBy('id', 'DESC')->latest()->get();
        return view('notification/reload-notification', [
            'loans' => $loans,
            'withdraws' => $withdraws
        ]);
    }

    public function reload_Badge_Notifications() {

        $loans = Loan::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->where('amount', '>', '0')
        ->orderBy('id', 'DESC')->latest()->get();
        
        $withdraws = Withdraw::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->orderBy('id', 'DESC')->latest()->get();

        return view('notification/reload-badge-icon-notification', [
            'loans' => $loans,
            'withdraws' => $withdraws
        ]);
    }
    public function reload_Badge_Sidebar_Notifications() {

        $loans = Loan::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->where('amount', '>', '0')
        ->orderBy('id', 'DESC')->latest()->get();

        $withdraws = Withdraw::whereDate('created_at', Carbon::today())
        ->where('confirm','0')
        ->orderBy('id', 'DESC')->latest()->get();

        return view('notification/reload-badge-icon-notification-sidebar', [
            'loans' => $loans,
            'withdraws' => $withdraws
        ]);
    }

    public function readed_Notifications_loan(Request $request, $id)
    {
        $loan = Loan::find($id)
        ->update([
            'confirm' => '1'
        ]);

        return $loan;
    }
    public function readed_Notifications_withdraw(Request $request, $id)
    {
 
        $withdraw = Withdraw::find($id)
        ->update([
            'confirm' => '1'
        ]);

        return $withdraw ;
    }

}
