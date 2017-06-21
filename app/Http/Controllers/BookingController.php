<?php


namespace App\Http\Controllers;
use App\Labs;
use App\Booking;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;
use Image;
use DB;
use App;
use Route;
use Input;
use Validator;
use URL;
use Auth;
use Response;
class BookingController extends Controller {

    public function show() {
        //$bookings = Booking::all();
       
        $bookings = DB::table('booking')
            ->join('users', 'booking.created_by', '=', 'users.id')
            ->join('labs', 'booking.lab_id', '=', 'labs.id')
            ->select('users.username', 'booking.*',"labs.name_". App::getLocale())
            ->paginate(15);
        //$bookings = Booking::paginate(15);
        return view('booking.all', compact('bookings'));
       // return redirect('/repositorio');
        
    }
    
     public function create() {
        $labs = Labs::all();
        return view('booking.create', compact('labs'));
    }

    public function store() {
        $cb = Auth::user()->id;               
        $input = Request::all();
        $t=time();
        $dataAtual = date("Y-m-d");
        $horaAtual = date("H:i");
        $dataHoraTimestamp = strtotime($dataAtual.$horaAtual);
       
        $rules = [
            'lab_id' => 'required',
            'date' => 'required',
            'time' => 'required',
            'duration' => 'required' 
        ];
        $validator = Validator::make($input, $rules);
        
        
        
        if ($validator->fails()) {  
            $messages = $validator->messages();

        } 
        else {
            //Verificação de variaveis
            if($input['duration'] <= 0 || $input['duration'] > 120  ){
                return Response::json(['erro' => 1]);
            }
            if($input['date'] < $dataAtual){
                return Response::json(['erro' => 2]);
            }
            if($input['date'] == $dataAtual && $input['time'] < $horaAtual){
                return Response::json(['erro' => 3]);
            } 
            
            //Verificando no Banco se já existe um agendamento
            $timeleft = strtotime($input['date'].$input['time']) + $input['duration']*60;
            $timeenter = strtotime($input['date'].$input['time']);
            $labIdinput = $input['lab_id'];
        
            $sql = DB::select( DB::raw("SELECT * FROM `booking` WHERE `lab_id`=". $labIdinput ." AND (". $timeenter ." BETWEEN `timestamp_enter` AND `timestamp_left` OR  " . $timeleft ." BETWEEN `timestamp_enter` AND `timestamp_left`)"));
                if(sizeof($sql) != 0 )
                    return sizeof($sql);
                
            //Continuação do processo
            $new['lab_id'] = $input['lab_id'];
            $new['date'] = $input['date'];
            $new['time'] = $input['time'];
            $new['duration'] = $input['duration'];
            $new['token'] = hexdec( substr(sha1($t), 0, 5) );
            $new['created_by'] = $cb;

            $new['timestamp_enter'] =  strtotime($input['date'].$input['time']) ;
            $new['timestamp_left'] = strtotime($input['date'].$input['time']) + $input['duration']*60;
            
            $ret = Booking::create($new);
            return $ret;
        }
        

    }
        public function delete() {
            if(teacher()){
                $input = Request::all();
                Booking::destroy($input['id']); // ORM eloquent way
                 //DB::table('booking')->where('id', '=', $input['id'])->delete(); // laravel way

                return $input;
            }
    }  
        
}


    
