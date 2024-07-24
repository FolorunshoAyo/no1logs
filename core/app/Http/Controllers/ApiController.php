<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Language;
use App\Constants\Status;
use App\Models\OrderItem;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\WalletHistory;
use App\Models\AdminNotification;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function index(){
        $result = [
          'success' =>  'Welcome to no1logs API!!'
        ];

        return response()->json($result, 200);
    } 

    public function products(Request $request){
        $request->validate([
            'search'=>'nullable|regex:/^[\w-]*$/'
        ]);

        $categories = Category::active()
        ->whereHas('products', function($products){
            return $products->active()->searchable(['name', 'description', 'category:name']);
        })
        ->with(['products'=>function($products){
            return $products->active()->orderBy('id', 'DESC');
        }, 'products.productDetails']);

        $categories = $categories->orderBy('name')->get()
        ->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $category->products->map(
                    function ($product) {
                        return [
                            'id' => $product->id,
                            'name' => $product->name,
                            'image' => $product->image,
                            'description' => $product->description,
                            'in_stock' => $product->in_stock,
                            'price' => $product->price
                        ];
                    }
                )
            ];
        });


        return response()->json($categories, 200);
    }

    public function categoryProducts($category = null, $id = 0){

        $category = Category::active()->find($id);

        if($category){
            $products = Product::active()
            ->where('category_id', $category->id)
            ->searchable(['name', 'description'])
            ->with('productDetails')
            ->orderBy('id', 'DESC')->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'description' => $product->description,
                    'in_stock' => $product->in_stock,
                    'price' => $product->price
                ];
            });

            $result = [
                "id" => $category->id,
                "category_name" => $category->name,
                "products" => $products
            ];

            return response()->json($result, 200);
        }else{
            return response()->json(['error' => 'No product category was found'], 422);
        }
    }

    public function productDetails($id){
        $result = [];

        $product = Product::active()->whereHas('category', function($category){
            return $category->active();
        })->find($id);

        if($product){
            $accounts = ProductDetail::where('product_id', $product->id)
            ->where('is_sold', 0)
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($account){
                return [
                    'id' => $account->id,
                    'url' => $account->url
                ];
            });
        }else{
            return response()->json(['error' => 'This product does not exist'], 422); 
        }

        $relatedProducts = Product::active()->whereHas('category', function($category){
            return $category->active();
        })
        ->where('category_id',$product->category_id)->orderBy('id','desc')
        ->where('id','!=',$product->id)
        ->limit(5)
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'image' => $product->image,
                'description' => $product->description,
                'in_stock' => $product->in_stock,
                'price' => $product->price
            ];
        });

        $result['product'] = [
            'id' => $product->id,
            'product_name' => $product->name
        ];
        $result['accounts'] = $accounts ?? "";
        $result['related_product'] =  $relatedProducts;

        return response()->json($result, 200);
    }

    public function balance(Request $request){
        $user = $request->attributes->get('authenticatedUser');
        $balance = $user->wallet->balance;

        return response()->json(['status' => 'success', 'balance' => $balance], 200);
    }

    public function getSingleProduct($id){
        $product = Product::find($id);

        if($product){
            $result = [
                "id" => $product->id,
                "name" => $product->name,
                "image" => $product->image,
                "description" => $product->description,
                "price" => $product->price
            ];
        }else{
            return response()->json(['error' => 'This product does not exist'], 422);
        }

        return response()->json($result, 200);
    }

    public function getSingleAccount($id){
        $account = ProductDetail::find($id);

        if($account){
            $result = [
                "id" => $account->id,
                "url" => $account->url,
            ];
        }else{
            return response()->json(['error' => 'This account does not exist'], 422);
        }

        return response()->json($result, 200);
    }

    public function checkAccounts(Request $request){
        //     $accounts = ($request->query('accounts');

        //     foreach($accounts as $account){
        //         $account = ProductDetail::where('id', $account)->where('is_sold', 0)->get();

        //         if(!$account){
        //             return response()->json(['error' => "One or more of the selected products has been sold."], 422);
        //         }
        //     }

        //     return response()->json(['success' => "All products are in stock"], 200);
    }

    public function newOrder(Request $request)
    {   
        $request->validate([
            'product_details_ids' => 'required',
        ]);
 
        $product_details_ids = explode(",", $request->product_details_ids);
        $first_product_details = ProductDetail::find($product_details_ids[0]);
        if($first_product_details){
            $product = Product::find($first_product_details->product_id);
            if($product){
                $product_price = $product->price;
                $amount = $product_price * count($product_details_ids);
                $isWallet = null;
                $single_price = $amount / count($product_details_ids);
            }else{
                return response()->json(['error' => 'This product does not exist'], 422);
            }
        }else{
            return response()->json(['error' => 'One or more of the selected products does not exist'], 422);
        }

        foreach($product_details_ids as $product_detail_id){
            $product_detail = ProductDetail::find($product_detail_id)->where("is_sold", 1);

            if(!$product_detail){
                return response()->json(['error' => "One or more of the selected account has been sold."], 422);
            }
        }

        $user = $request->attributes->get('authenticatedUser');

        if($isWallet){
            if($user->wallet->balance < $amount){
                return response()->json(['error' => 'Insufficient Balance'], 200);
            }
        }

        $final_amo = $amount;

        $order = new Order();
        $order->user_id = $user->id;
        if($isWallet) $order->status = '1';
        $order->total_amount = $amount;
        $order->save();

        $data = new WalletHistory();
        $data->wallet_id = $user->wallet->id;
        $data->order_id = $order->id;
        $data->transaction_type = '2';
        $data->final_amo = $final_amo;
        $data->amount = $amount;
        $data->status = '1';
        $data->method_code = '';
        $data->method_currency = 'NGN';
        $data->from_api = "1";
        $data->save();
        

        foreach($product_details_ids as $product_detail_id){
            $item = new OrderItem();
            $item->order_id = $order->id;
            $item->product_id = $request->id;
            $item->product_detail_id = $product_detail_id;
            $item->price = $single_price;
            $item->save();
        }
        
        $order->status = Status::ORDER_PAID;
        $order->save();

        $items = @$order->orderItems->pluck('product_detail_id')->toArray() ?? [];
        ProductDetail::whereIn('id', $items)->update(['is_sold'=>Status::YES]);

        $wallet = $user->wallet;
        // Credit wallet here
        $wallet->balance -= $amount;
        $wallet->save(); 

        // Send back order details
        $order = Order::find($order->id);

        $initials = [];
        $orderItems = OrderItem::whereIn('id', $order->orderItems->pluck('id') ?? [])
        ->with('product', 'productDetail')
        ->get()
        ->map(function ($orderItem, $index) use (&$initials){
            if($index == 0){
                $initials['category_name'] = $orderItem->product->category->name;
                $initials['product_name'] = $orderItem->product->name;
            }
            return [
                "id" => $orderItem->productDetail->id,
                "details" => $orderItem->productDetail->details,
                "url" => $orderItem->productDetail->url
            ];
        });

        $result = [
            "status" => "success",
            "order" => [
                "id" => $order->id,
                "category_name" => $initials['category_name'],
                "product_name" => $initials['product_name'],
                "order_items" => $orderItems
            ]
        ];

        return response()->json($result, 200);   
    }

    public function orderDetails(Request $request, $id){
        $user = $request->attributes->get('authenticatedUser');

        // $order = Order::where('user_id', $user->id)->where('status', Status::ORDER_PAID)->find($id);
        $order = Order::find($id);

        if($order){
            $initials = [];
            $orderItems = OrderItem::whereIn('id', $order->orderItems->pluck('id') ?? [])
            ->with('product', 'productDetail')
            ->get()
            ->map(function ($orderItem, $index) use (&$initials){
                if($index == 0){
                    $initials['category_name'] = $orderItem->product->category->name;
                    $initials['product_name'] = $orderItem->product->name;
                }
                return [
                    "id" => $orderItem->productDetail->id,
                    "details" => $orderItem->productDetail->details,
                    "url" => $orderItem->productDetail->url
                ];
            });

            $result = [
                "id" => $order->id,
                "category_name" => $initials['category_name'],
                "product_name" => $initials['product_name'],
                "order_items" => $orderItems,
            ];

            return response()->json($result, 200);
        }else{
            return response()->json(['error' => "Order not found"], 422);
        }
    }
}

?>