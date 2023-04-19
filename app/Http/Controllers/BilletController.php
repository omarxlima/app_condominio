<?php

namespace App\Http\Controllers;

use App\Models\Billet;
use App\Models\Unit;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    public function index(Request $request)
    {

        $array = ['error' => ''];
        $property = $request->input('property');
        if ($property) {

            $user = auth()->user();

            $unit = Unit::where('id', $property)->where('id_owner', $user['id'])->count();

            if($unit > 0){
                $billets = Billet::where('id_unit', $property)->get();
                foreach ($billets as $key => $billet) {
                    $billets[$key]['file_url'] = asset('storage/' . $billet['file_url']);
                    $array['list'] = $billets;
            }
            }else {
                $array['error'] = 'Esta unidade não é sua.';
            }
        } else {
            $array['error'] = 'A propriedade é necessária';
        }

        return $array;
    }
}
