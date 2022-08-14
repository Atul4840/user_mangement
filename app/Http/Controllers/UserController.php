<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function Insert(Request $request)
    {

        $validator = validator::make($request->all(),
            [

                // 'old_image'=>'required_if:image,=,null',
                //  'image'=>'required_if:old_image,=,null'


                'name' => 'required|regex:/^[a-zA-ZÑñ\s]+$/',
                'email' => 'required|email',
                'dateofjoin' => 'required',
                'dateofleaving' => 'required_if:still_work,=,null',
                'still_work'=>'required_if:dateofleaving,=,null',
                'file' => 'required|image|mimes:jpeg,png',
            ], [
                'dateofjoin.required' => 'date of joining field is required',
                'dateofleaving.required' => 'date of leaving field is required',
                'name.regex' => 'only alphabets are allowed',
            ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {

            if ($request->still_work!= null) {
                $files = $request->file('file');
                $name = $files->getClientOriginalName();
                $path = $files->move(public_path('image'), $name);

                // $startdate = date_create($request->dateofjoin);
                // $enddate = date_create($request->dateofleaving);

                // $diff = (date_diff($startdate, $enddate));

                // $experience = $diff->format("%y year %m month");

                //    return $experience;

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->date_of_join = $request->date_of_join;
                $user->experience = $request->still_work;
                $user->image = $name;
                $user->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'User has been submitted',
                ]);
            }else{
                $files = $request->file('file');
                $name = $files->getClientOriginalName();
                $path = $files->move(public_path('image'), $name);

                $startdate = date_create($request->dateofjoin);
                $enddate = date_create($request->dateofleaving);

                $diff = (date_diff($startdate, $enddate));

                $experience = $diff->format("%y year %m month");

                //    return $experience;

                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->experience = $experience;
                $user->image = $name;
                $user->save();

                return response()->json([
                    'status' => 200,
                    'message' => 'User has been submitted',
                ]);


            }


        }

    }

    public function UserFetch()
    {
        // $date = User::get()->pluck('date_of_join');
        // $datel = User::get()->pluck('date_of_leaving');

        // $d = json_decode($date, true);
        // $r = [];
        // foreach ($d as $t) {
        //     $r[] = $t;
        // }

        // $p = json_decode($datel, true);
        // $m = [];
        // foreach ($p as $t) {
        //     $m[] = $t;
        // }

        // foreach ($r as $l) {
        //     $date1 = date_create($l);
        //     foreach ($m as $d) {
        //         $date2 = date_create($d);
        //         $diff = (date_diff($date1,$date2));
        //         $ex=$diff;
        //     }

        //     $e = [];
        //     foreach ($ex as $t) {
        //         $e[] = $t;
        //     }
        //     $o=json_encode($e,true);

        //     print_r($o);

        // }

        $users = User::all();
        return response()->json([
            'users' => $users,
        ]);
    }

    public function destroy($id)
    {
        $delete = User::find($id)->delete();
        return response()->json([
            'status' => ' 200',
            'message' => 'Student deleted ',
        ]);
    }
}
