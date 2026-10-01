<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    public function web(Request $request){
        return view('website');
    }

    public function website2(Request $request){
        $incoming_id = Session::get('unique_id');
        if(!empty($incoming_id) && isset($incoming_id))
        {
            $app_id = $request->query('app_id');
            $package_name = $request->query('package_name');
            $device_model = $request->query('device_model');
            $language = $request->query('language');
            $country_code = $request->query('country_code');
            $app_version = $request->query('app_version');
            $os_version = $request->query('os_version');
            $theme_mode = $request->query('theme_mode');
            $details_id = 1;


            $website =  User::where('unique_id',$incoming_id)->first();
            $website->app_id = $app_id;
            $website->package_name = $package_name;
            $website->device_model = $device_model;
            $website->language = $language;
            $website->country_code = $country_code;
            $website->app_version = $app_version;
            $website->os_version = $os_version;
            $website->theme_mode = $theme_mode;
            $website->details_id = 435678;
            $website->full_url = $request->url() ?? url()->current();
            $website->save();
            return view('website2');
        }
        return view('website2');
    }

    // public function signup1(Request $request)
    // {
    //     $hostname = "localhost";
    //     $username = "olybible_chat_user";
    //     $password = "gNL?iDl].bZh";
    //     $dbname = "olybible_chat_db";
        
    //     $conn = mysqli_connect($hostname, $username, $password, $dbname);
    //     if(!$conn){
    //         echo "Database connection error".mysqli_connect_error();
    //     }
        
    //     $fname = mysqli_real_escape_string($conn, $request['name']);
    //     $email = mysqli_real_escape_string($conn, $request['email']);
    //     if(!empty($fname) && !empty($email)){
    //         if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    //             $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    //             if(mysqli_num_rows($sql) > 0){
    //                 $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    //                 if(mysqli_num_rows($sql) > 0){
    //                     $row = mysqli_fetch_assoc($sql);
    //                 }
    //                 $status = "Active now";
    //                 $message = "How Can I Help You?....";
    //                 $outgoing_id = 1171991996;

    //                 $incoming_id = $row['unique_id'];

    //                 date_default_timezone_set('Asia/Kolkata');
    //                 $currentDateTime = date('Y-m-d H:i:s');
        
    //                 $messages_imsert = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg ,date_time)
    //                 VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$currentDateTime}')") or die();
                    
    //                 $last_id = $conn->insert_id;
                    
    //                 $sql2 = mysqli_query($conn, "UPDATE users SET message_id = '{$last_id}', status = '{$status}' WHERE unique_id = {$row['unique_id']}");
    //                 if($sql2){
    //                     $uniqueId = $request->session()->put('unique_id', $row['unique_id']);
    //                     $data = $uniqueId;
    //                     return response()->json($data);
    //                 }
    //                 else{
    //                     echo "Something went wrong. Please try again!";
    //                 }
    //             }else{
    //                 $ran_id = rand(time(), 100000000);
    //                 $status = "Active now";
    //                 $password = 123456789;
    //                 $new_img_name = "16831092541676468639881_DTHfsCKR4R8FNAUOoS6ZCVqhkMmQLbwW5wmLSIu7t0MgkUhQfYRY3z8PrxkZ14.png";
    //                 $encrypt_pass = md5($password);
    //                 $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, name, email, password, img, status)
    //                 VALUES ({$ran_id}, '{$fname}','{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
    //                 $message = "How Can I Help You?....";
    //                 $outgoing_id = 1171991996;
    //                 $incoming_id = $ran_id;

    //                 date_default_timezone_set('Asia/Kolkata');
    //                 $currentDateTime = date('Y-m-d H:i:s');
                    
    //                 $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg ,date_time)
    //                 VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$currentDateTime}')") or die();

    //                 $last_id = $conn->insert_id;
                    
    //                 $message_id = mysqli_query($conn, "UPDATE users SET message_id = '{$last_id}' WHERE unique_id={$incoming_id}");

    //                 if($insert_query){
    //                     $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
    //                     if(mysqli_num_rows($select_sql2) > 0){
    //                         $result = mysqli_fetch_assoc($select_sql2);
    //                         $uniqueId = $request->session()->put('unique_id', $result['unique_id']);
    //                         $data = $uniqueId;
    //                         return response()->json($data);
    //                     }else{
    //                         echo "This email address not Exist!";
    //                     }
    //                 }else{
    //                     echo "Something went wrong. Please try again!";
    //                 }
    //             }
    //         }else{
    //             echo "$email is not a valid email!";
    //         }
    //     }else{
    //         echo "All input fields are required!";
    //     }
    // }
    
    public function signup1(Request $request)
    {
        $hostname = "localhost";
        $username = "olybible_chat_user";
        $password = "gNL?iDl].bZh";
        $dbname = "olybible_chat_db";
        
        $conn = mysqli_connect($hostname, $username, $password, $dbname);
        if(!$conn){
            echo "Database connection error".mysqli_connect_error();
        }
    
        // User fields
        $fname = mysqli_real_escape_string($conn, $request->input('name'));
        $email = mysqli_real_escape_string($conn, $request->input('email'));
    
        // Extra fields
        $app_id       = mysqli_real_escape_string($conn, $request->input('app_id'));
        $package_name = mysqli_real_escape_string($conn, $request->input('package_name'));
        $device_model = mysqli_real_escape_string($conn, $request->input('device_model'));
        $language     = mysqli_real_escape_string($conn, $request->input('language'));
        $country_code = mysqli_real_escape_string($conn, $request->input('country_code'));
        $app_version  = mysqli_real_escape_string($conn, $request->input('app_version'));
        $os_version   = mysqli_real_escape_string($conn, $request->input('os_version'));
        $theme_mode   = mysqli_real_escape_string($conn, $request->input('theme_mode'));
    
        if(!empty($fname) && !empty($email)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                if(mysqli_num_rows($sql) > 0){
                    // Existing user section

                    $row = mysqli_fetch_assoc($sql);
                    
                    $status = "Active now";
                    $message = "How Can I Help You?....";
                    $outgoing_id = 1171991996;
                    $incoming_id = $row['unique_id'];
                    
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');
                    
                    mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg ,date_time)
                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$currentDateTime}')") or die();
                    
                    $last_id = $conn->insert_id;
                    
                    // Build update query dynamically
                    $updateFields = [
                        "message_id = '{$last_id}'",
                        "status = '{$status}'"
                    ];
                    
                    if (!empty($app_id))       $updateFields[] = "app_id = '{$app_id}'";
                    if (!empty($package_name)) $updateFields[] = "package_name = '{$package_name}'";
                    if (!empty($device_model)) $updateFields[] = "device_model = '{$device_model}'";
                    if (!empty($language))     $updateFields[] = "language = '{$language}'";
                    if (!empty($country_code)) $updateFields[] = "country_code = '{$country_code}'";
                    if (!empty($app_version))  $updateFields[] = "app_version = '{$app_version}'";
                    if (!empty($os_version))   $updateFields[] = "os_version = '{$os_version}'";
                    if (!empty($theme_mode))   $updateFields[] = "theme_mode = '{$theme_mode}'";
                    
                    $prevoius = url()->previous();
                    
                    if (!empty($request->url()))   $updateFields[] = "full_url = '{$prevoius}'";
                    
                    // Final SQL update string
                    $updateSql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE unique_id = {$row['unique_id']}";
                    
                    $sql2 = mysqli_query($conn, $updateSql);
                    
                    if($sql2){
                        $request->session()->put('unique_id', $row['unique_id']);
                        return response()->json($row['unique_id']);
                    } else {
                        echo "Something went wrong. Please try again!";
                    }
                } else {
                    // New user
                    $ran_id = rand(time(), 100000000);
                    $status = "Active now";
                    $password = 123456789;
                    $new_img_name = "16831092541676468639881_DTHfsCKR4R8FNAUOoS6ZCVqhkMmQLbwW5wmLSIu7t0MgkUhQfYRY3z8PrxkZ14.png";
                    $encrypt_pass = md5($password);
                    
                    $prevoius = url()->previous();
    
                    $insert_query = mysqli_query($conn, "INSERT INTO users 
                        (unique_id, name, email, password, img, status,
                         app_id, package_name, device_model, language, country_code, app_version, os_version, theme_mode, full_url)
                        VALUES ({$ran_id}, '{$fname}','{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}',
                                '{$app_id}', '{$package_name}', '{$device_model}', '{$language}', '{$country_code}', '{$app_version}', '{$os_version}', '{$theme_mode}', '{$prevoius}')");
    
                    $message = "How Can I Help You?....";
                    $outgoing_id = 1171991996;
                    $incoming_id = $ran_id;
    
                    date_default_timezone_set('Asia/Kolkata');
                    $currentDateTime = date('Y-m-d H:i:s');
    
                    mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg ,date_time)
                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}', '{$currentDateTime}')") or die();
    
                    $last_id = $conn->insert_id;
    
                    mysqli_query($conn, "UPDATE users SET message_id = '{$last_id}' WHERE unique_id={$incoming_id}");
    
                    if($insert_query){
                        $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                        if(mysqli_num_rows($select_sql2) > 0){
                            $result = mysqli_fetch_assoc($select_sql2);
                            $request->session()->put('unique_id', $result['unique_id']);
                            return response()->json($result['unique_id']);
                        } else {
                            echo "This email address not Exist!";
                        }
                    } else {
                        echo "Something went wrong. Please try again!";
                    }
                }
            } else {
                echo "$email is not a valid email!";
            }
        } else {
            echo "All input fields are required!";
        }
    }


    public function get_chats(Request $request){
        $outgoing_id = $request->session()->get('unique_id');
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
            $output .= '<div class="text" style="color:red;">No messages are available. Once you send message they will appear here.<br>Please provide a valid Name and Email</div>';
            echo $output;
        }
    }

    public function insert_chats(Request $request){
        $outgoing_id = $request->session()->get('unique_id');
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

}
