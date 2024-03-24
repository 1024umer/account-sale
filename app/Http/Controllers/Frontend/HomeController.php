<?php

namespace App\Http\Controllers\Frontend;

use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Post;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Ticket;
use App\Models\Visiter;
use App\Models\Category;
use App\Models\GiveAway;
use App\Models\KeyChannel;
use App\Models\LicenceKey;
use App\Exports\PostExport;
use App\Models\Transaction;
use App\Models\EmailChannel;
use Illuminate\Http\Request;
use App\Models\GamingAccount;
use App\Models\CustomRefferal;
use App\Models\FeatureProduct;
use App\Models\SubSubcategory;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;



class HomeController extends Controller
{
  public function index(Request $request)
  {
      $data = Store::find(1);
      $referralName = $request->input('ref');

      if ($referralName) {
          $referral = CustomRefferal::where('refferal_name', $referralName)->first();
          $this->storeVisitorData(request()->ip());
          if ($referral) {
              $refferalNameOnly = $referral->refferal_name;
              return view('frontend.auth.signup', ['data' => $data, 'refferalName' => $refferalNameOnly]);
          } else{
                abort(404);
             }
      }

      // Additional logic for the default view
      $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
          $query->where('status', 'active')->orderBy('category_id', 'ASC');
      }])
          ->orderBy('name', 'ASC')
          ->get();

      $categoriesHeader = Category::with('subCategories.subSubCategory')->get();

      $session_id = session('session_id');

      if ($this->isSessionExpired($session_id)) {
          $this->removeCart($session_id);
      }

     // return view('frontend.index', compact('data', 'subSubCategories', 'categoriesHeader'));
       return view('frontendNew.index', compact('data', 'subSubCategories', 'categoriesHeader'));
  }
    public static function isSessionExpired($session_id)
    {
        // Your implementation to check if the session ID has expired
        // For example, comparing with the current time and the session creation time
    }
    private function removeCart($session_id)
    {
        Cart::where('session_id', $session_id)->delete();
    }

    public function sort($slug)
    {
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
            ->get();
        if ($slug == 'atoz') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('title', 'asc');
            }])
                ->orderBy('name', 'ASC')
                ->get();
        } else if ($slug == 'ztoa') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('title', 'desc');
            }])
                ->orderBy('name', 'ASC')
                ->get();
        } else if ($slug == 'cheaper') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('price', 'asc');
            }])
                ->orderBy('name', 'ASC')
                ->get();
        } else if ($slug == 'expensive') {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('price', 'desc');
            }])
                ->orderBy('name', 'ASC')
                ->get();
        } else {
            $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
                $query->where('status', 'active')
                    ->orderBy('category_id', 'ASC');
            }])
                ->orderBy('name', 'ASC')
                ->get();
        }
        return view('FrontendNew.index', compact('data', 'subSubCategories', 'categoriesHeader'));
    }

    public function giveAway()
    {
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $giveAways = GiveAway::where('status', 'active')->get();
        return view('frontendNew.giveaway', compact('data', 'giveAways', 'categoriesHeader'));
    }

    public function contact()
    {
        $userName = '';
        $userEmail = '';
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $data = Store::where('id', '1')->first();
        return view('frontendNew.contact', compact('data', 'userName', 'userEmail','categoriesHeader'));
    }

    public function policy()
    {
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $data = Store::where('id', '1')->first();
        return view('frontendNew.policy', compact('data','categoriesHeader'));
    }

    public function terms()
    {
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $data = Store::where('id', '1')->first();
        return view('frontendNew.term', compact('data','categoriesHeader'));
    }

    public function faq()
    {
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        $data = Store::where('id', '1')->first();
        return view('frontendNew.faq', compact('data','categoriesHeader'));
    }

    public function paymentDelivery()
    {
        $data = Store::where('id', '1')->first();
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();
        return view('frontendNew.payment', compact('data','categoriesHeader'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $ticket = new Ticket();

        if ($request->hasFile('ticketfile')) {
            $uploadedFile = $request->file('ticketfile');
            $filename = $uploadedFile->getClientOriginalName();
            $publicDirectory = public_path('assets/tickets');
            $uploadedFile->move($publicDirectory, $filename);
            $filePath = 'assets/tickets/' . $filename;
            $ticket->ticketfile = $filePath;
        }
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->save();

        return redirect()->back()->with('success', 'Message submited our team will contact you as soon as possible');
    }

    public function cartList()
    {
        $data = Store::where('id', '1')->first();
        // Retrieve the cart items from the session
        $cartItems = [];
        $session_id = Session::get('session_id');
        if (!empty($session_id)) {
            $cartItems = Cart::with('services')->where('session_id', $session_id)->get();
        }



        return view('frontend.cart.cartlist', compact('data', 'cartItems'));
    }

    public function cartAdd(Request $request)
    {

        $gamingAccountId = $request->input('gaming_account_id');
        $gamingAccount = GamingAccount::find($gamingAccountId);

        $existingCartItem = Cart::where('gaming_account_id', $gamingAccountId)->first();

        if ($existingCartItem) {
            return response()->json(['status' => 'error', 'message' => 'already exist in cart']);
        }

        // $gamingAccount = GamingAccount::find($gamingAccountId);

        // if (!$gamingAccount) {
        //     // Handle the case if the gaming account does not exist
        //     return response()->json(['status' => 'error', 'message' => 'account does not exist']);
        // }
        $session_id = Session::getId();

        Session::put('session_id', $session_id);

        // You can implement the logic for adding the item to the cart
        $cart = new Cart();
        $cart->gaming_account_id = $gamingAccountId;
        $cart->session_id = $session_id;
        $cart->price = $gamingAccount->price;
        $cart->save();
        // Check if the session has expired and remove the cart if necessary


        return response()->json(['status' => 'success', 'message' => 'Item added to the cart successfully']);
    }

    public function removeFromCart(Request $request)
    {
        $sessionId = $request->input('sessionId');

        // Perform actions to remove the session ID from the cart
        $cartItem = Cart::where('session_id', $sessionId)->first();

        if ($cartItem) {
            $cartItem->delete();
            // Additional logic if needed
            return response()->json(['status' => 'success', 'message' => 'Item removed from cart successfully']);
        } else {
            return response()->json(['success' => 'Item not found in the cart'], 404);
        }
    }

    public function storeTitleInSession($title)
    {
        $userName = '';
        $userEmail = '';
        if (Auth::check()) {
            // User is logged in
            $userName = Auth::user()->name;
            $userEmail = Auth::user()->email;
        }
        session()->put('product_title', $title);
        $data = Store::where('id', '1')->first();
        return view('frontend.contact', compact('data', 'userName', 'userEmail'));
    }
    public function updateQuantity(Request $request)
    {

        $cartItemId = $request->input('productId');
        $newQuantity = $request->input('newQuantity');

        $cartItem = Cart::where('gaming_account_id', $cartItemId)->first();
        if ($cartItem) {
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
            // You can return a success response if the update was successful
            return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
        } else {
            // You can return an error response if the cart item was not found
            return response()->json(['success' => false, 'message' => 'Cart item not found']);
        }
    }



    public function cart()
    {
        $categoriesHeader = Category::with('subCategories.subSubCategory')
        ->get();
        $totalProducts = GamingAccount::where('status', 'active')->count();
        $totalCategories = Category::count();

        return view('frontendNew.cart',compact('categoriesHeader'));
    }
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }

    public function addToCart($id)

    {

        $product = GamingAccount::findOrFail($id);



        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {

            $cart[$id]['quantity']++;

        } else {

            $cart[$id] = [

                "name" => $product->title,

                "quantity" => 1,

                "price" => $product->price,


            ];



        }



        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');

    }

    public function private_product_link($random_string_for_private)
    {
        $data = Store::where('id', '1')->first();
        $subSubCategories = SubSubcategory::with(["gamingAccounts" => function ($query) {
          $query->where('status', 'active')
              ->orderBy('category_id', 'ASC');
      }])
          ->orderBy('name', 'ASC')
          ->get();
      $categoriesHeader = Category::with('subCategories.subSubCategory')
          ->get();
      $session_id = Session::get('session_id');
      if ($this->isSessionExpired($session_id)) {
          $this->removeCart($session_id);
      }
        $product = GamingAccount::where('random_string_for_private', $random_string_for_private)->firstOrFail();

        if ($product) {
          // Product found, display it or redirect to the product page
          return view('frontend.product_by_link', compact('product','data' , 'subSubCategories', 'categoriesHeader'));

        } else {
            // Product not found, you might want to handle this case (e.g., show an error page)
            return view('errors.product_not_found');
        }
    }

    public function headings(): array
    {
        return array_keys((new Post())->getAttributes());
    }
    public function export()
    {

        $data = GamingAccount::all();

    return Excel::download(new class($data) implements FromCollection {
        private $data;

        public function __construct($data)
        {
            $this->data = $data;
        }

        public function collection()
        {
            return $this->data;
        }
    }, 'posts.xlsx');
    }
    private function storeVisitorData($ipAddress)
    {
        Visiter::create([
            'ip_address' => $ipAddress,
        ]);
    }
}
