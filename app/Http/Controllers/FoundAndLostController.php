<?php

namespace App\Http\Controllers;

use App\Models\FoundAndLost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoundAndLostController extends Controller
{
    public function index() {
        $array = ['error' => ''];
        $lost = FoundAndLost::where('status', 'LOST')
        ->orderBy('datecreated', 'DESC')
        ->orderBy('id', 'DESC')
        ->get();

        $lost = FoundAndLost::where('status', 'LOST')
        ->orderBy('datecreated', 'DESC')
        ->orderBy('id', 'DESC')
        ->get();

        $recovered = FoundAndLost::where('status', 'RECOVERED')
        ->orderBy('datecreated', 'DESC')
        ->orderBy('id', 'DESC')
        ->get();



        foreach ($lost as $lostKey => $lostValue) {
            $lost[$lostKey]['datecreated'] = date('d/m/Y', strtotime($lostValue['datecreated']));
            $lost[$lostKey]['photo'] = asset('storage/'. $lostValue['photo']);
        }

        foreach ($recovered as $recoveredKey => $recoveredValue) {
            $recovered[$recoveredKey]['datecreated'] = date('d/m/Y', strtotime($recoveredValue['datecreated']));
            $recovered[$recoveredKey]['photo'] = asset('storage/'. $recoveredValue['photo']);
        }


        $array['lost'] = $lost;
        $array['recovered'] = $recovered;

        return $array;
    }

    public function store(Request $request){
        $array = ['error' => ''];
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'where' => 'required',
            'photo' => 'required|file|mimes:png,jpg',
        ]);

        if(!$validator->fails()) {
            $description = $request->input('description');
            $where = $request->input('where');
            $file = $request->file('photo')->store('public');
            $file = explode('public', $file); //pegar o nome da foto
            $photo = $file[1];

            $newFound = new FoundAndLost();
            $newFound->status = 'LOST';
            $newFound->description = $description;
            $newFound->where = $where;
            $newFound->photo = $photo;
            $newFound->datecreated = date('Y-m-d');
            $newFound->save();
        }else {
            $array['error'] = $validator->errors()->first();
        }

        return $array;
    }

    public function update($id, Request $request) {
        $array = ['error' => ''];
        $status = $request->input('status');
        if ($status && in_array($status, ['lost', 'recovery'])) {
            $item = FoundAndLost::find($id);
            if($item){
                $item->status = $status;
                $item->save();
            }else {
                return $array['error'] = 'Produto inexistente!';
            }
        } else {
            return $array['error'] = 'status não existe';
        }

        return $array;

    }
}
