<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller; 
use App\User;
use App\WebCrawler\SearchVehicle; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Http\Request; 
use Validator;



class UserController extends Controller 
{
    public $successStatus = 200;
    private $vehicle;

    public function __construct(SearchVehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request) 
    { 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'confirm_password' => 'required|same:password', 
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
        $user = User::create($input); 
        $success['token'] =  $user->createToken('MyApp')-> accessToken; 
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus); 
    }
    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function accountDetails() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }
    public function searchVehicle($vehicle){
 
        
        $result = $this->vehicle->searchVehicle($vehicle);
        if (!$result) {
            throw new NotFoundHttpException();
        }
        return $result;
        

        //return $response->getStatusCode(); # 200
    }
    public function vehicleDetails() 
    { 
        return 'teste detalhes';
    }
}