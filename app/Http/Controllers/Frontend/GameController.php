<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\EmailChannel;
use App\Models\OutOfStock;
use App\Models\Store;
use App\Models\SubCategory;
use App\Models\SubSubcategory;
use App\Models\UserTicket;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index()
    {
        $data = Store::where('id', '1')->first();

        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        return view('frontendNew.account', compact('data', 'categoriesHeader', 'totalProducts', 'totalCategories'));
    }

    public function category($slug)
    {
        $data = Store::where('id', '1')->first();
        $subCategory = SubCategory::where('name', $slug)->first();
        $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
            $query->where('status', 'active')
                ->orderBy('category_id', 'ASC');
        }])
            ->where('sub_category_id', $subCategory->id)
            ->get();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        return view('frontend.games.category', compact('data', 'subSubCategories', 'slug', 'subCategory', 'categoriesHeader'));
    }

    public function sorts($slug, $sortin)
    {
        $data = Store::where('id', '1')->first();
        $subCategory = SubCategory::where('name', $slug)->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        if ($sortin == 'atoz') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('title', 'ASC');
            }])
                ->where('sub_category_id', $subCategory->id)
                ->get();
        } else if ($sortin == 'ztoa') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('title', 'DESC');
            }])
                ->where('sub_category_id', $subCategory->id)
                ->get();
        } else if ($sortin == 'cheaper') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('price', 'ASC');
            }])
                ->where('sub_category_id', $subCategory->id)
                ->get();
        } else if ($sortin == 'expensive') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('price', 'DESC');
            }])
                ->where('sub_category_id', $subCategory->id)
                ->get();
        } else {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('category_id', 'ASC');
            }])
                ->where('sub_category_id', $subCategory->id)
                ->get();
        }

        return view('frontend.games.category', compact('data', 'subSubCategories', 'slug', 'subCategory', 'categoriesHeader'));
    }

    public function subcategory($slug)
    {
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();

        $subSubCategory = SubSubCategory::where('name', $slug)->first();

        $subCategory = SubCategory::where('id', $subSubCategory->sub_category_id)->first();

        $gamingAccounts = GamingAccount::where('status', 'active')
            ->where('sub_subcategory_id', $subSubCategory->id)
            ->get();

        return view('frontend.games.subcategory', compact('data', 'gamingAccounts', 'slug', 'subCategory', 'categoriesHeader'));
    }

    public function subsorts($slug, $sortin)
    {
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        $subSubCategory = SubSubCategory::where('name', $slug)->first();
        $subCategory = SubCategory::where('id', $subSubCategory->sub_category_id)->first();
        if ($sortin == 'atoz') {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_category_id', $subSubCategory->id)
                ->orderBy('title', 'ASC')
                ->get();
        } else if ($sortin == 'ztoa') {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_category_id', $subSubCategory->id)
                ->orderBy('title', 'DESC')
                ->get();
        } else if ($sortin == 'cheaper') {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_category_id', $subSubCategory->id)
                ->orderBy('price', 'ASC')
                ->get();
        } else if ($sortin == 'expensive') {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_category_id', $subSubCategory->id)
                ->orderBy('price', 'DESC')
                ->get();
        } else {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_category_id', $subSubCategory->id)
                ->get();
        }

        return view('frontend.games.subcategory', compact('data', 'gamingAccounts', 'slug', 'subCategory', 'categoriesHeader'));
    }

    public function filter($category, $subcategori = null, $subsubcategory = null)
    {
        $data = Store::where('id', '1')->first();
        if ($subcategori == null) {
            $subCategory = SubCategory::where('category_id', $category)->get();

            $categoriesHeader = Category::with('subCategories.subSubCategory')
                ->get();
                $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                    $query->where('status', 'active')->orderBy('category_id', 'ASC');
                }])
                    ->orderBy('name', 'ASC')
                    ->get();
            $slug = Category::where('id', $category)->first()->name;
            return view('frontendNew.filter', compact('data', 'subCategory', 'subSubCategories','categoriesHeader', 'slug'));
        } else if ($subsubcategory == null) {
            $subCategory = SubCategory::where('id', $subcategori)->get();

            $categoriesHeader = Category::with('subCategories.subSubCategory')
                ->get();
                
            $slug = SubCategory::where('id', $subcategori)->first()->name;
            return view('frontendNew.filter', compact('data', 'subCategory', 'subSubCategories','categoriesHeader', 'slug'));
        } else {
            $gamingAccounts = GamingAccount::where('status', 'active')
                ->where('sub_subcategory_id', $subsubcategory)
                ->get();
            $categoriesHeader = Category::with('subCategories.subSubCategory')
                ->get();
            $subCategory = SubCategory::where('id', $subcategori)->first();
            $subsubcategory = SubSubCategory::where('id', $subsubcategory)->first();
            $slug = $subsubcategory->name;
            return view('frontendNew.subcategory', compact('data', 'gamingAccounts', 'slug', 'subCategory', 'categoriesHeader'));
        }
    }



    public function pricefilter(Request $request, $minPrice, $maxPrice)
    {

        $data = Store::where('id', '1')->first();
        if ($maxPrice > 0) {
            $totalProducts = GamingAccount::where('status', 'active')
                ->whereBetween('price', [$minPrice, $maxPrice])
                ->get();
            $categoriesHeader = Category::with('subCategories.subSubCategory')
                ->get();
            $totalCategories = Category::count();
            $subSubCategories = SubSubCategory::get()->all();
            return view('frontendNew.index', compact('data', 'categoriesHeader', 'subSubCategories', 'totalProducts', 'totalCategories'));
        } else {
            return redirect()->back();
        }
    }
    public function details($slug)
    {
        $data = Store::where('id', '1')->first();
        $user = Auth::user();
        $product = GamingAccount::where('title', $slug)
            ->with(['medias', 'emailChannels' => function ($query) {
                $query->where('status', 'available');
            }])
            ->first();
        $available_channels_count = $product->emailChannels()->where([
            ['gaming_account_id', '=', $product->id],
            ['status', '=', 'available']
        ])->count();

        $username = null;

        if ($product && $product->emailChannels->isNotEmpty()) {
            $line1 = $product->emailChannels->first()->format;
            $line2 = $product->emailChannels->first()->value1;
            $delimiter = $product->emailChannels->first()->delimiter;

            $headers = explode($delimiter, $line1);

            $lineValues = explode($delimiter, $line2);

            if (count($headers) !== count($lineValues)) {
                echo "Error: Count of headers and lines should be equal.\n";
            } else {
                $result = array_combine(array_map('strtolower', $headers), $lineValues);

                $username = $result['username'] ?? null;

                $finalResult = json_encode($result);
            }
        }
        $maxInput = count($product->emailChannels);
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        return view('frontendNew.gamedetail', compact('data', 'product', 'maxInput', 'user', 'categoriesHeader', 'username', 'available_channels_count'));
    }




    public function showsubcategory($id)
    {
        $categories = SubCategory::where('category_id', $id)->get();
        $options = '<option value="">Select Sub Category</option>';
        foreach ($categories as $category) {
            $options .= '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
        return response()->json(array('options' => $options), 200);
    }

    public function showsub_subcategory($id)
    {
        $categories = SubSubcategory::where('sub_category_id', $id)->get();
        $options = '<option value="">Select Sub Sub Category</option>';
        foreach ($categories as $category) {
            $options .= '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
        return response()->json(array('options' => $options), 200);
    }

    public function outOfStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'notify_email' => 'required',
        ]);

        $out_of_stock = new OutOfStock();
        $out_of_stock->product_id = $request->product_id;
        $out_of_stock->name = ' ';
        $out_of_stock->email = $request->notify_email;
        $out_of_stock->save();
        $notifyCheck = "stock";
        return redirect()->back()->with(['success' => 'Message submited our team will contact you as soon as possible', 'notifyCheck' => $notifyCheck]);
    }

    public function userTicket(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'email' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $userTicket = new UserTicket();
        $userTicket->order_id = $request->order_id;
        $userTicket->email = $request->email;
        $userTicket->name = $request->name;
        $userTicket->subject = $request->subject;
        $userTicket->message = $request->message;
        $userTicket->status = 'open';
        $userTicket->save();
        return redirect()->back()->with('success', 'Message submited our team will contact you as soon as possible');
    }

    public function cart_checkout()
    {

        $product = session('cart');
        $data = Store::where('id', '1')->first();
        $user = Auth::user();
        $maxInput = count(session('cart'));

        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        $total = 0;
        foreach (session('cart') as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }
        // $data['total']=$total;
        return view('frontendNew.checkout', compact('data', 'product', 'maxInput', 'total', 'user', 'categoriesHeader'));
    }



    public function cartcheckout_details($slug)
    {
        $data = Store::where('id', '1')->first();
        $user = Auth::user();
        $product = GamingAccount::where('title', $slug)
            ->with(['medias', 'emailChannels' => function ($query) {
                $query->where('status', 'available');
            }])
            ->first();
        $maxInput = count($product->emailChannels);
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        return view('frontend.games.gameDetails', compact('data', 'product', 'maxInput', 'user', 'categoriesHeader'));
    }
}
