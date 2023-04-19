<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index(){
        $array = ['error' => ''];
        $docs = Doc::all();
        foreach ($docs as $key => $doc) {
            $docs[$key]['file_url'] = asset('storage/'. $doc['file_url']);
        }
        $array['list'] = $docs;
        return $array;
    }
}
