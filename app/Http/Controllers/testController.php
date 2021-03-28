<?php

namespace App\Http\Controllers;

use App\Detailed;
use App\Master;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function getList(){
        try {
            $data =  Detailed::all();

            $id = Detailed::latest()->first()->id;


            return response()->json(
            [
                'data' => $data,
                'id'   => $id

            ]);
        }catch (\Exception $e){
            return response()->json([
                "error" => "error in getList"
            ]);

        }

    }
    public function save(Request $request){

        try{
            foreach ($request->lists as $list) {
                Detailed::updateOrCreate([
                    "id" => $list['id']
                ],[
                    "ar" => $list['ar'],
                    "master_id" => 1,
                    "en" => $list['en']
                ]);
            }

        }catch (\Exception $e){
            return response()->json([
                "error" => "error in addList"
            ]);
        }
    }


}
