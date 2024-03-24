<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Store;
use App\Models\LicenceKey;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\Category;
use App\Http\Controllers\Controller;

class LicenceKeyController extends Controller
{
    public function index()
    {
        $data = Store::where('id', '1')->first();
        $licenceKeys = LicenceKey::where('status', 'active')
            ->where('product_status', 'available')
            ->with('medias')
            ->get();
            $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
            $totalProducts = GamingAccount::where('status', 'active')->count();
            $totalCategories = Category::count();
        $gamesCount = GamingAccount::where('status', 'active')->where('product_status', 'available')->count();
        $keysCount = LicenceKey::where('status', 'active')->where('product_status', 'available')->count();
        $totalProductsCount = $gamesCount + $keysCount;
        return view('frontendNew.licence', compact('data', 'licenceKeys', 'totalProductsCount', 'keysCount', 'gamesCount','categoriesHeader'));
    }

    public function find($slug)
    {
        $data = Store::where('id', '1')->first();
        $product = LicenceKey::where('title', $slug)
            ->where('status', 'active')
            ->where('product_status', 'available')
            ->with('medias')
            ->first();
        return view('frontend.keys.keyFind', compact('data', 'product'));
    }

    public function details($slug)
    {
        $data = Store::where('id', '1')->first();
        $product = LicenceKey::where('title', $slug)
            ->with(['medias', 'keyChannels' => function ($query) {
                $query->whereIn('id', function ($subquery) {
                    $subquery->selectRaw('MIN(id)')
                        ->from('key_channels')
                        ->where('status', 'available')
                        ->groupBy('days');
                });
            }])
            ->first();
        $maxInput = count($product->keyChannels);

        return view('frontend.keys.keyDetails', compact('data', 'product', 'maxInput'));
    }
}
