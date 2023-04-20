<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Warning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function storeFile(Request $request) {
        $array = ['error' => ''];

       $validator =  Validator::make($request->all(), [
                'photos' => 'required|file|mimes:png,jpg',
        ]);

        if(!$validator->fails()) { //n deu falha
               $file =   $request->file('photos')->store('public');
               $array['photos'] = asset(Storage::url($file));
        }else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    public function store(Request $request) {
        $array = ['error' => ''];
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'property' => 'required'
        ]);
        if(!$validator->fails()){
            $title = $request->input('title');
            $property = $request->input('property');
            $list = $request->input('list');

            $newWarn = new Warning();
            $newWarn->id_unit = $property;
            $newWarn->title = $title;
            $newWarn->status = 'IN_REVIEW';
            $newWarn->datecreated = date('Y-m-d');
            if ($list && is_array($list)) {
                $photos = [];
                foreach ($list as $listItem) {
                    $url = explode('/', $listItem);
                    $photos[] = end($url);
                }
                $newWarn->photos = implode(',',$photos);
            }else{
                $newWarn->photos = '';
            }

            $newWarn->save();
        }else{
           $array['error'] = $validator->errors()->first();
           return $array;
        }
        return $array;
    }
}
