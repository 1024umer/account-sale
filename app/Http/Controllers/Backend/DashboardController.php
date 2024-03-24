<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\LicenceKey;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $can = false;
        if ($user->role_id != 1 && $user->role_id != 2) {
            $can = true;
        }
        if ($can) {
            return view('backend.dashboard_seller');
        }
        $totalUsers = User::count();
        $usersToday = User::where('role_id', '!=','2')->whereDate('created_at', Carbon::today())->count();
        $activeUsersCount = User::where('role_id', '!=','2')->where('status', 'active')->count();
        $inactiveUsersCount = User::where('role_id', '!=','2')->where('status', 'inactive')->count();
        $lastMonthUsers = User::where('role_id', '!=','2')
            ->whereDate('created_at', '>=', now()->subMonth())
            ->count();
        if ($totalUsers > 0) {
            $percentageLastMonthUsers = ($lastMonthUsers / $totalUsers) * 100;
        } else {
            $percentageLastMonthUsers = 0;
        }

        $totalOrders = Order::count();
        $totalGamingAccounts = GamingAccount::count();
        $totalLicenceKeys = LicenceKey::count();
        $totalTickets = Ticket::count();
        $ticketsPending = Ticket::where('status', 'open')->count();
        $ticketsToday = Ticket::whereDate('created_at', Carbon::today())->count();

        $productsTotal = $totalGamingAccounts + $totalLicenceKeys;
        $revenueTotal = Order::sum('amount');
        $revenueToday = Order::whereDate('created_at', Carbon::today())->sum('amount');
        $revenueThisMonth = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
        $revenueLastMonth = Order::whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('amount');

        $ordersToday = Order::whereDate('created_at', Carbon::today())->count();
        $ordersTotal = Order::count();

        return view(
            'backend.dashboard',
            compact(
                'totalUsers',
                'totalOrders',
                'totalGamingAccounts',
                'totalLicenceKeys',
                'totalTickets',
                'ticketsPending',
                'usersToday',
                'activeUsersCount',
                'inactiveUsersCount',
                'lastMonthUsers',
                'percentageLastMonthUsers',
                'productsTotal',
                'revenueTotal',
                'revenueToday',
                'revenueThisMonth',
                'revenueLastMonth',
                'ordersToday',
                'ordersTotal',
                'ticketsToday'
            )
        );
    }
}
