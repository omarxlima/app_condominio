<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Warning;
use Illuminate\Http\Request;

class WarningController extends Controller
{
    public function index(Request $request)
    {
        $array = ['error' => ''];
        $property = $request->input('property');
        if ($property) {
            $user = auth()->user();

            $unit = Unit::where('id', $property)
                ->where('id_owner', $user['id'])
                ->count();

            if ($unit > 0) {
                $warnings = Warning::where('id_unit', $property)
                    ->orderBy('datecreated', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();

                    foreach ($warnings as $key => $warning) {
                        $warnings[$key]['datecreated'] = date('d/m/Y', strtotime($warning['datecreated']));
                        $photoList = [];
                        $photos = explode(',', $warning['photos']);
                        foreach ($photos as  $photo) {
                            if(!empty($photo)){
                                $photoList[] = asset('storage/'. $photo);
                        }
                        }
                        $warnings[$key]['photos'] = $photoList;
                    }
                $array['list'] = $warnings;
            } else {
                $array['error'] = 'Esta propriedade não é sua';
            }
        }else {
            $array['error'] = 'A propriedade é necessária.';
        }
        return $array;
    }
}
