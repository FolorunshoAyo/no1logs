<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Constants\Status;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\ProductDetail;
use App\Models\WalletHistory;

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
                            'image' => asset("assets/images/product/" . $product->image),
                            'description' => $product->description,
                            'in_stock' => $product->in_stock,
                            'price' => $product->price
                        ];
                    }
                )
            ];
        });

        $response = [
            "status" => "success",
            "categories" => $categories
        ];

        return response()->json($response, 200);
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
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        $user = $request->attributes->get('authenticatedUser');

        $product = Product::active()->whereHas('category', function($category){
            return $category->active();
        })->findOrFail($request->id);

        if($user->wallet->balance < ($product->price * $request->amount)){
            return response()->json(['error' => 'Insufficient Balance'], 200);
        }

        if($product->api_provider_id !== 0){
            if($product->apiProvider->type === "CMSNT"){
                $data = curl_get($apiProvider->domain."/api/BResource.php?username=".$apiProvider->username."&password=".$apiProvider->password."&id=".$request->id.'&amount='.$request->amount);
                $data = json_decode($data, true);

                if($data['status'] == 'error'){
                    $notify[] = ['error', $data['msg']];
                    return back()->withNotify($notify);
                }

                $api_trx_id = $data['data']['trans_id'];
                $accounts = $data['data']['lists'];

                // Add new order
                $order = new Order();
                $order->user_id = $user->id;
                $order->status = '1';
                $order->total_amount = $amount;
                $order->save();

                // Add new wallet debit history
                $data = new WalletHistory();
                $data->wallet_id = $user->wallet->id;
                $data->trx = getTrx();
                $data->api_trx_id = $api_trx_id;
                $data->api_provider_id = $apiProvider->id;
                $data->order_id = $order->id;
                $data->transaction_type = '2';
                $data->final_amo = $final_amo;
                $data->amount = $amount;
                $data->status = '1';
                $data->method_code = '';
                $data->method_currency = 'NGN';
                $data->save();

                foreach($accounts as $account){
                    $product_detail = new ProductDetail();
                    $product_detail->product_id = $product->id;
                    $product_detail->is_sold = 1;
                    $product_detail->details = $account['account'];
                    $product_detail->save();

                    $item = new OrderItem();
                    $item->order_id = $order->id;
                    $item->product_id = $product->id;
                    $item->product_detail_id = $product_detail->id;
                    $item->price = $product->price;
                    $item->save();
                }

                // Send back order details
                $order = Order::find($order->id);

                $wallet = $user->wallet;
                // Credit wallet here
                $wallet->balance -= $amount;
                $wallet->save(); 

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
                    ];
                });
            }else{
                $data = curl_get($apiProvider->domain."/api/v1/order/new?api_token=".$apiProvider->token."&id=".$product->api_id.'&amount='.$qty);
                $data = json_decode($data, true);

                if(isset($data['error'])){
                    $notify[] = ['error', $data['error']];
                    return back()->withNotify($notify);
                }

                $api_trx_id = $data['order']['trans_id'];
                $accounts = $data['order']['order_items'];

                // Add new order
                $order = new Order();
                $order->user_id = $user->id;
                $order->status = '1';
                $order->total_amount = $amount;
                $order->save();

                // Add new wallet debit history
                $data = new WalletHistory();
                $data->wallet_id = $user->wallet->id;
                $data->trx = getTrx();
                $data->api_trx_id = $api_trx_id;
                $data->api_provider_id = $apiProvider->id;
                $data->order_id = $order->id;
                $data->transaction_type = '2';
                $data->final_amo = $final_amo;
                $data->amount = $amount;
                $data->status = '1';
                $data->method_code = '';
                $data->method_currency = 'NGN';
                $data->save();

                foreach($accounts as $account){
                    $product_detail = new ProductDetail();
                    $product_detail->product_id = $product->id;
                    $product_detail->is_sold = 1;
                    $product_detail->details = $account['details'];
                    $product_detail->save();

                    $item = new OrderItem();
                    $item->order_id = $order->id;
                    $item->product_id = $product->id;
                    $item->product_detail_id = $product_detail->id;
                    $item->price = $product->price;
                    $item->save();
                }

                // Send back order details
                $order = Order::find($order->id);

                $wallet = $user->wallet;
                // Credit wallet here
                $wallet->balance -= $amount;
                $wallet->save(); 

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
                    ];
                });
            }
        }else{
            if($product->in_stock < $request->amount){
                return response()->json(['error' => 'Not enough stock available. Only '.$product->in_stock.' quantity left'], 200);
                return back()->withNotify($notify);
            }

            $amount = ($product->price * $request->amount);
            $final_amo = $amount;

            $order = new Order();
            $order->user_id = $user->id;
            $order->status = '1';
            $order->total_amount = $amount;
            $order->save();

            $data = new WalletHistory();
            $data->wallet_id = $user->wallet->id;
            $data->trx = getTrx();
            $data->order_id = $order->id;
            $data->transaction_type = '2';
            $data->final_amo = $final_amo;
            $data->amount = $amount;
            $data->status = '1';
            $data->method_code = '';
            $data->method_currency = 'NGN';
            $data->save();

            $unsoldProductDetails = $product->unsoldProductDetails;

            for($i = 0; $i < $request->amount; $i++){
                if(@!$unsoldProductDetails[$i]){
                    continue;
                }
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $product->id;
                $item->product_detail_id = $unsoldProductDetails[$i]->id;
                $item->price = $product->price;
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
                ];
            });
        }

        $result = [
            "status" => "success",
            "order" => [
                "trans_id" => $data->trx,    
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