<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use DateTime;
use Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $outgoing_id = Auth::user()->unique_id;
        $sql = User::orderBy('message_id','Desc')->where('unique_id',$outgoing_id)->latest()->take(200)->get();
        return view('home', compact('sql'));
    }

    public function logout(Request $request) 
    {
        LogActivity::addToLog();
        Auth::guard('admin')->logout();
        $request->session()->forget('last_fetched_category_id');
        return redirect()->route('admin.login');
    }
    
    // public function users(Request $request){
    //      $outgoing_id = Auth::user()->unique_id; // Get the outgoing user's unique_id

    //     // Fetch last 50 users that are not the logged-in user, ordered by message_id
    //     $users = User::where('unique_id', '!=', $outgoing_id)
    //                  ->orderByDesc('message_id')
    //                  ->limit(300)
    //                  ->get();

    //     if ($users->isEmpty()) {
    //         return response()->json(['message' => 'No users are available to chat']);
    //     }

    //     // Prepare the output for the users list
    //     $output = [];

    //     foreach ($users as $user) {
    //         // Get the latest message between the logged-in user and this user
    //         $latestMessage = Message::where(function ($query) use ($user, $outgoing_id) {
    //                                 $query->where('incoming_msg_id', $user->unique_id)
    //                                       ->where('outgoing_msg_id', $outgoing_id);
    //                             })
    //                             ->orWhere(function ($query) use ($user, $outgoing_id) {
    //                                 $query->where('outgoing_msg_id', $user->unique_id)
    //                                       ->where('incoming_msg_id', $outgoing_id);
    //                             })
    //                             ->orderBy('date_time','desc')
    //                             ->first();

    //         // Determine the message content (or default message if none found)
    //         $message = $latestMessage ? $latestMessage->msg : 'No message available';
    //         $message = mb_convert_encoding($message, 'UTF-8', 'UTF-8');
    //         $msg = strlen($message) > 15 ? substr($message, 0, 15) . '...' : $message;

    //         // If the logged-in user sent the last message, add "You: " in front of the message
    //         $you = $latestMessage && $latestMessage->outgoing_msg_id == $outgoing_id ? 'You: ' : '';

    //         // Check if the user is offline or online
    //         $offline = $user->status == 'Offline now' ? 'offline' : '';

    //         // Hide the current user from the list
    //         $hid_me = $outgoing_id == $user->unique_id ? 'hide' : '';

    //         // Add user data to the output array
    //         $output[] = [
    //             'user_id' => $user->unique_id,
    //             'name' => $user->name . ' ' . $user->lname,
    //             'img' => asset('php/images/' . $user->img),
    //             'msg' => $you . mb_convert_encoding($msg, 'UTF-8', 'UTF-8'),
    //             'status' => $offline,
    //             'hide_class' => $hid_me,
    //         ];
    //     }
    //     return response()
    //             ->json($output)
    //             ->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);

    // }

    // public function search(Request $request){
    //     $searchTerm = $request->searchTerm;
    //     $outgoing_id = Auth::user()->unique_id; // Logged-in user's unique ID

    //     // Fetch users matching the search term, excluding the logged-in user
    //     $users = User::where('name', 'like', '%'.$searchTerm.'%')
    //         ->where('unique_id', '!=', $outgoing_id)
    //         ->orderBy('message_id', 'desc')
    //         ->limit(50)
    //         ->get();

    //     $output = "";

    //     if ($users->isEmpty()) {
    //         // If no users are found, show a message
    //         $output .= "<center><h5 style='color:red;'>No users are available to chat</h5></center>";
    //     } else {
    //         foreach ($users as $user) {
    //             // Fetch the latest message for each user
    //             $latestMessage = Message::where(function ($query) use ($user, $outgoing_id) {
    //                                     $query->where('incoming_msg_id', $user->unique_id)
    //                                           ->where('outgoing_msg_id', $outgoing_id);
    //                                 })
    //                                 ->orWhere(function ($query) use ($user, $outgoing_id) {
    //                                     $query->where('outgoing_msg_id', $user->unique_id)
    //                                           ->where('incoming_msg_id', $outgoing_id);
    //                                 })
    //                                 ->orderBy('date_time','desc')
    //                                 ->first();

    //             // Default message if no message exists
    //             $message = $latestMessage ? $latestMessage->msg : 'No message available';
    //             // Shorten the message if it's longer than 28 characters
    //             $msg = strlen(strip_tags($message)) > 28 ? substr($message, 0, 28) . '...' : $message;
                
    //             // If the logged-in user is the sender, prepend "You: "
    //             $you = $latestMessage && $latestMessage->outgoing_msg_id == $outgoing_id ? 'You: ' : '';

    //             // Determine if the user is online or offline
    //             $statusClass = $user->status == 'Offline now' ? 'offline' : '';

    //             // Hide the current user from the list (the logged-in user)
    //             $hideClass = $outgoing_id == $user->unique_id ? 'hide' : '';

    //             // Construct the output for each user
    //             $output .= '<a class="cdd_'. $user->unique_id .'" id="'. $user->unique_id .'" href="chats?user_id='. $user->unique_id .'">
    //                         <div class="content">
    //                             <img src="'. asset('php/images/'.$user->img) .'" alt="">
    //                             <div class="details cdsd_'. $user->unique_id .'">
    //                                 <span>'. $user->name .' '. $user->lname .'</span>
    //                                 <p>'. $you . $msg .'</p>
    //                             </div>
    //                         </div>
    //                         <div class="status-dot '. $statusClass .'"><i class="fas fa-circle"></i></div>
    //                     </a>';
    //         }
    //     }

    //     // Return the output to the frontend
    //     echo $output;
    // }


    public function users(Request $request)
    {
        $outgoing_id = Auth::user()->unique_id;

        // Cache latest users list for 5 seconds to reduce DB hits
        $users = Cache::remember("users_list_$outgoing_id", 5, function () use ($outgoing_id) {
            return User::where('unique_id', '!=', $outgoing_id)
                        ->orderByDesc('message_id')
                        ->limit(300)
                        ->get();
        });

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users are available to chat']);
        }

        $output = [];

        foreach ($users as $user) {
            // Latest message query
            $latestMessage = Message::where(function ($query) use ($user, $outgoing_id) {
                                        $query->where('incoming_msg_id', $user->unique_id)
                                              ->where('outgoing_msg_id', $outgoing_id);
                                    })
                                    ->orWhere(function ($query) use ($user, $outgoing_id) {
                                        $query->where('outgoing_msg_id', $user->unique_id)
                                              ->where('incoming_msg_id', $outgoing_id);
                                    })
                                    ->latest('date_time')
                                    ->limit(1)
                                    ->first();

            $message = $latestMessage ? $latestMessage->msg : 'No message available';
            $msg = mb_strimwidth($message, 0, 15, "...", "UTF-8");

            $you = $latestMessage && $latestMessage->outgoing_msg_id == $outgoing_id ? 'You: ' : '';
            $offline = $user->status === 'Offline now' ? 'offline' : '';
            $hid_me = $outgoing_id == $user->unique_id ? 'hide' : '';

            $output[] = [
                'user_id' => $user->unique_id,
                'name' => $user->name . ' ' . $user->lname,
                'img' => asset('php/images/' . $user->img),
                'msg' => $you . $msg,
                'status' => $offline,
                'hide_class' => $hid_me,
            ];
        }

        return response()
                ->json($output, 200, [], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    }

    /**
     * Search Users
     */
    public function search(Request $request)
    {
        $searchTerm = trim($request->searchTerm);
        $outgoing_id = Auth::user()->unique_id;

        if (empty($searchTerm)) {
            return "<center><h5 style='color:red;'>Please enter a search term</h5></center>";
        }

        $users = User::where('unique_id', '!=', $outgoing_id)
                     ->where(function ($query) use ($searchTerm) {
                         $query->where('name', 'like', '%' . $searchTerm . '%')
                               ->orWhere('lname', 'like', '%' . $searchTerm . '%');
                     })
                     ->orderByDesc('message_id')
                     ->limit(50)
                     ->get();

        if ($users->isEmpty()) {
            return "<center><h5 style='color:red;'>No users are available to chat</h5></center>";
        }

        $output = "";

        foreach ($users as $user) {
            $latestMessage = Message::where(function ($query) use ($user, $outgoing_id) {
                                        $query->where('incoming_msg_id', $user->unique_id)
                                              ->where('outgoing_msg_id', $outgoing_id);
                                    })
                                    ->orWhere(function ($query) use ($user, $outgoing_id) {
                                        $query->where('outgoing_msg_id', $user->unique_id)
                                              ->where('incoming_msg_id', $outgoing_id);
                                    })
                                    ->latest('date_time')
                                    ->limit(1)
                                    ->first();

            $message = $latestMessage ? $latestMessage->msg : 'No message available';
            $msg = mb_strimwidth(strip_tags($message), 0, 28, "...", "UTF-8");

            $you = $latestMessage && $latestMessage->outgoing_msg_id == $outgoing_id ? 'You: ' : '';
            $statusClass = $user->status === 'Offline now' ? 'offline' : '';
            $hideClass = $outgoing_id == $user->unique_id ? 'hide' : '';

            $output .= '
                <a class="cdd_' . $user->unique_id . ' ' . $hideClass . '" 
                   id="' . $user->unique_id . '" 
                   href="chats?user_id=' . $user->unique_id . '">
                    <div class="content">
                        <img src="' . asset('php/images/' . $user->img) . '" alt="">
                        <div class="details cdsd_' . $user->unique_id . '">
                            <span>' . e($user->name . ' ' . $user->lname) . '</span>
                            <p>' . e($you . $msg) . '</p>
                        </div>
                    </div>
                    <div class="status-dot ' . $statusClass . '">
                        <i class="fas fa-circle"></i>
                    </div>
                </a>';
        }

        return $output;
    }


    public function chats(Request $request){
        $hostname = "localhost";
        $username = "olybible_chat_user";
        $password = "gNL?iDl].bZh";
        $dbname = "olybible_chat_db";
    
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(!$conn){
            echo "Database connection error".mysqli_connect_error();
        }

        $user_id = mysqli_real_escape_string($conn, $request['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        if(mysqli_num_rows($sql) > 0){
          $row = mysqli_fetch_assoc($sql);
        }else{
          header("location: users.php");
        }
        if($row['status'] == "Offline now" || $row['status'] == "Active now")
        {
            $sql_1 = mysqli_query($conn, "SELECT * FROM messages  WHERE `outgoing_msg_id` = {$user_id} OR `incoming_msg_id`={$user_id} ORDER BY msg_id DESC LIMIT 1");
            if(mysqli_num_rows($sql_1) > 0){ 
                $row_1 = mysqli_fetch_assoc($sql_1);
                date_default_timezone_set('Asia/Kolkata');
                $currentDateTime = date('Y-m-d H:i:s');
                $date2 =  $row_1['date_time'];
                $img =  $row['img'];
                $name = $row['name'];
                $datetime1 = new DateTime($currentDateTime);
                $datetime2 = new DateTime($date2);
                $createdAt = $date2;
                $carbonCreatedAt = \Carbon\Carbon::parse($createdAt);
                $days = $carbonCreatedAt->diffForHumans();
                $app_id = $row['app_id'];
                $package_name = $row['package_name'];
                $device_model = $row['device_model'];
                $language = $row['language'];
                $country_code = $row['country_code'];
                $app_version = $row['app_version'];
                $os_version = $row['os_version'];
                $theme_mode = $row['theme_mode'];
            }
            else{
                $img =  $row['img'];
                $name = $row['name'];
                $days = $row['status'];
                $package_name = $row['package_name'];
                $device_model = $row['device_model'];
                $app_version = $row['app_version'];
                $os_version = $row['os_version'];
            }
        }
        else{
            $img =  $row['img'];
            $name = $row['name'];
            $days = $row['status'];
            $package_name = $row['package_name'];
            $device_model = $row['device_model'];
            $app_version = $row['app_version'];
            $os_version = $row['os_version'];
        }

        $outgoing_id = Auth::user()->unique_id;
        $sql = User::orderBy('message_id','Desc')->where('unique_id',$outgoing_id)->get();
        return view('home', compact('os_version','sql','img','name','days','user_id','package_name','device_model','app_version'));
    }

    public function get_chats(Request $request){
        $outgoing_id = Auth::user()->unique_id;
        if(isset($outgoing_id) && !empty($request['incoming_id'])){
            
            $hostname = "localhost";
            $username = "olybible_chat_user";
            $password = "gNL?iDl].bZh";
            $dbname = "olybible_chat_db";
    
            $conn = mysqli_connect($hostname, $username, $password, $dbname);
            if(!$conn){
                echo "Database connection error".mysqli_connect_error();
            }
            $outgoing_id = $outgoing_id;
            $incoming_id = mysqli_real_escape_string($conn, $request['incoming_id']);
            $output = "";
            $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                    WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                    OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
            $query = mysqli_query($conn, $sql);
            if(mysqli_num_rows($query) > 0){
                while($row = mysqli_fetch_assoc($query)){
                    $storedTime = $row['date_time'];
                    
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');

                    $datetime1 = new DateTime($row['date_time']);
                    $datetime2 = new DateTime($currentDateTime);
                    $interval = $datetime1->diff($datetime2);
                    if ($datetime2->format('d-M-Y') > $datetime1->format('d-M-Y')) {
                        $elapsed = $datetime1->format('d-M-Y H:i:s');
                    }
                    else if($interval->format('%H') != "00")
                    {
                        $elapsed = $interval->format('%h hours %i mins ago');
                    }
                    else if($interval->format('%I mins ago') == "00 mins ago")
                    {   
                        $elapsed = "Just Now";
                    }
                    else
                    {
                        $elapsed = $interval->format('%I mins ago');
                    }
                    
                    if($row['outgoing_msg_id'] == $outgoing_id){
                        $output .= '<div class="chat outgoing">
                                        <div class="details">
                                            <p>'. $row['msg'] .'<br><span class="text-muted" align="right" style="font-size:11px;text-align: right;font-weight: 600;">'.$elapsed.'
                                            </span></p>
                                            </div><i class="fas fa-check text-muted" style="padding-top:10px;padding-left:5px;"></i>
                                        <br>
                                    </div>';
                    }else{
                        $output .= '<div class="chat incoming">
                                        <img src="php/images/'.$row['img'].'" alt="">
                                        <div class="details">
                                            <p>'. $row['msg'] .'<br>'.'<span align="right" style="font-size:11px;text-align: right;font-weight: 600;">'.$elapsed.'</span></p>
                                        </div>
                                    </div>';
                    }
                }
            }else{
                $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
            }
            echo $output;
        }else
        {
            $output = "";
            $output .= '<div class="text">No messages are available. Once you send message they will appear here.</div>';
            echo $output;
        }
    }

    public function insert_chats(Request $request){

        $outgoing_id = Auth::user()->unique_id;
        if(isset($outgoing_id)){

            $hostname = "localhost";
            $username = "olybible_chat_user";
            $password = "gNL?iDl].bZh";
            $dbname = "olybible_chat_db";
    
            $conn = mysqli_connect($hostname, $username, $password, $dbname);
            if(!$conn){
                echo "Database connection error".mysqli_connect_error();
            }

            $outgoing_id = $outgoing_id;
            $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
            $message = mysqli_real_escape_string($conn, $_POST['message']);
            if(!empty($message)){
                date_default_timezone_set('Asia/Kolkata');
                $currentDateTime = date('Y-m-d H:i:s');

                $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, date_time)
                                            VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$currentDateTime}')") or die();

                $last_id = $conn->insert_id;
                if($outgoing_id == 1171991996)
                {
                    $message_id = mysqli_query($conn, "UPDATE users SET message_id = '{$last_id}' WHERE unique_id={$incoming_id}");
                }else{
                    $message_id = mysqli_query($conn, "UPDATE users SET message_id = '{$last_id}' WHERE unique_id={$outgoing_id}");
                }
            }
        }
    }


    //Web Site function in HomeController
    public function web(Request $request){
        $outgoing_id = Auth::user()->unique_id;
        return view('website',compact('outgoing_id'));
    }
}
