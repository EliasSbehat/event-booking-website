<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Http;
use DataTables;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use Stripe\PaymentIntent;
use Carbon\Carbon;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('home');
    }

    public function lists()
    {
        return view('lists');
    }
    public function details()
    {
        return view('details');
    }
	public function bookings()
    {
        return view('bookings');
    }
    public function events()
    {
        return view('events');
    }
    public function settings()
    {
        return view('settings');
    }
    public function confirmation()
    {
        return view('confirmation');
    }
    public function buy($event_id)
    {
        return view('buy', ['event_id' => $event_id]);
    }
    public function bookingmngGetBK()
    {
        $data = DB::table('bookings')
            ->select('bookings.*', 'events.start_date_time')
            ->leftJoin('events', 'bookings.event_id', '=', 'events.id')
            ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<button type="button" class="btn btn-secondary delete-btn" id="'.$row->id.'"><i class="fas fa-trash-can"></i></button><button type="button" class="btn btn-primary edit-btn" id="'.$row->id.'"><i class="fas fa-pen-to-square"></i></button>';
                return $actionBtn;
            })
			 ->addColumn('eventDatab', function($row){
                $eventData = json_decode($row->eventData);
                return $eventData;
            })
            ->rawColumns(['action','eventDatab'])
            ->make(true);
    }
    public function eventGetMS()
    {
        $data = DB::table('events')
            ->select('*')
            ->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<button type="button" class="btn btn-secondary delete-btn" id="'.$row->id.'"><i class="fas fa-trash-can"></i></button><button type="button" class="btn btn-primary edit-btn" id="'.$row->id.'"><i class="fas fa-pen-to-square"></i></button>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function eventGetData()
    {
        $data = DB::table('events')
            ->select(DB::raw('title, description, location, image, start_date_time, events.id, sum(`ticket`) as total_ticket'))
            ->leftJoin('price', 'events.id', '=', 'price.event_id')
            ->where('start_date_time', '>=', now()->toDateString())
            ->groupBy('event_id', 'title', 'description', 'location', 'image', 'start_date_time', 'events.id')
            ->orderBy('start_date_time', 'asc')
            ->get();
        print_r(json_encode($data));
        exit();
    }
    public function getEvents(Request $request)
    {
        $id = $request->input('event_id');

        $eventData = DB::table('events')
            ->select('*')
            ->where('id', $id)
            ->get();
        $priceData = DB::table('price')
            ->select('*')
            ->where('event_id', $id)
            ->get();
        print_r(json_encode([$eventData, $priceData]));
        exit();
    }
    public function settingAdd(Request $request)
    {
        $id = $request->input('id');
        $file = $request->file('image');
        $image = "";
        if ($file) {
            //Move Uploaded File
            $destinationPath = './uploads/website';
            $file->move($destinationPath, time() . $file->getClientOriginalName());
            $image = time() . $file->getClientOriginalName();
            //
        }
        $website_title = $request->input('website_title');
        $website_email = $request->input('website_email');
        $stripe_pub_key = $request->input('stripe_pub_key');
        $stripe_secret_key = $request->input('stripe_secret_key');
        if ($id) {
            if ($file) {
                DB::table('settings')->where('id', $id)->update([
                    'website_title' => $website_title,
                    'website_email' => $website_email,
                    'stripe_public_key' => $stripe_pub_key,
                    'stripe_secret_key' => $stripe_secret_key,
                    'website_image' => $image
                ]);
            } else {
                DB::table('settings')->where('id', $id)->update([
                    'website_title' => $website_title,
                    'website_email' => $website_email,
                    'stripe_public_key' => $stripe_pub_key,
                    'stripe_secret_key' => $stripe_secret_key
                ]);
            }
        } else {
            DB::table('settings')->insert([
                'website_title' => $website_title,
                'website_email' => $website_email,
                'stripe_public_key' => $stripe_pub_key,
                'stripe_secret_key' => $stripe_secret_key,
                'website_image' => $image
            ]);
        }
        exit('success');
    }
    public function settingGet()
    {
        $data = DB::table('settings')
            ->select('*')
            ->first();
        print_r(json_encode($data));
        exit();
    }
    public function eventAdd(Request $request)
    {
        $file = $request->file('image');
        $id = $request->input('id');
        $image = "";
        if ($file) {
            //Move Uploaded File
            $destinationPath = './uploads';
            $file->move($destinationPath, time() . $file->getClientOriginalName());
            $image = time() . $file->getClientOriginalName();
            //
        }
        $start_date_time = $request->input('start_date_time');
        $description = $request->input('description');
        $title = $request->input('title');
        $location = $request->input('location');
        $webhook = $request->input('webhook');
        $price_data = json_decode($request->input('price_data'));
        

        if ($id) {
            if ($file) {
                DB::table('events')->where('id', $id)->update([
                    'title' => $title,
                    'description' => $description,
                    'location' => $location,
                    'webhook' => $webhook,
                    'start_date_time' => $start_date_time,
                    'image' => $image
                ]);
            } else {
                DB::table('events')->where('id', $id)->update([
                    'title' => $title,
                    'description' => $description,
                    'location' => $location,
                    'webhook' => $webhook,
                    'start_date_time' => $start_date_time
                ]);
            }
            DB::table('price')->where('event_id', '=', $id)->delete();

            for ($i=0; $i<count($price_data); $i++) {
                DB::table('price')->insert([
                    'type' => $price_data[$i]->type,
                    'price' => $price_data[$i]->price,
                    'ticket' => $price_data[$i]->ticket,
                    'event_id' => $id
                ]);
            }
        } else {
            $newId = DB::table('events')->insertGetId([
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'webhook' => $webhook,
                'start_date_time' => $start_date_time,
                'image' => $image
            ]);
            for ($i=0; $i<count($price_data); $i++) {
                DB::table('price')->insert([
                    'type' => $price_data[$i]->type,
                    'price' => $price_data[$i]->price,
                    'ticket' => $price_data[$i]->ticket,
                    'event_id' => $newId
                ]);
            }
        }
        echo "success"; exit();
    }
    public function deleteEvent(Request $request)
    {
        $requestData = $request->all();
        $id = $requestData['id'];
        $data = DB::table('events')
            ->select('*')
            ->where('id', $id)
            ->first();
        $img = $data->image;
        if (file_exists('./uploads/' . $img)) {
            unlink('./uploads/' . $img);
        }
        DB::table('events')->where('id', '=', $id)->delete();
        DB::table('price')->where('event_id', '=', $id)->delete();
        exit();
    }

    public function saveConfirmation(Request $request)
    {
        DB::table('confirmation')->truncate();
        DB::table('confirmation')->insert([
            'subject' => $request->input('subject'),
            'content' => $request->input('content')
        ]);
        echo "success"; exit();
    }
    public function webhookSave(Request $request)
    {
        DB::table('webhook')->truncate();
        DB::table('webhook')->insert([
            'webhook_url' => $request->input('webhook_url'),
        ]);
        echo "success"; exit();
    }
    public function webhookGet(Request $request)
    {
        $data = DB::table('webhook')
            ->select('*')
            ->first();
        print_r(json_encode($data));
        exit();
    }
    
    public function getConfirmation(Request $request)
    {
        $data = DB::table('confirmation')
            ->select('*')
            ->first();
        print_r(json_encode($data));
        exit();
    }
    public function pwdset(Request $request)
    {
        DB::table('pwd')->truncate();
        DB::table('pwd')->insert([
            'password' => $request->input('password'),
        ]);
        echo "success"; exit();
    }
    public function getpwd(Request $request)
    {
        $data = DB::table('pwd')
            ->select('*')
            ->first();
        if ($data->password==$request->input('password')) {
            echo "success"; 
        } else {
            echo "wrong"; 
        }
        exit();
    }
    

}
