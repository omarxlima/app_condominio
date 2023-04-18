<?php

namespace App\Http\Controllers;

use App\Models\Wall;
use App\Models\WallLike;
use Illuminate\Http\Request;

class WallController extends Controller
{
    public function index() {
        $array = ['error' => '', 'list' => []];

        $user = auth()->user();

        $walls = Wall::all();

        foreach ($walls as $key => $wall) {
            $walls[$key]['likes'] = 0;
            $walls[$key]['liked'] = false;

            $likes = WallLike::where('id_wall', $wall['id'])->count();
            $walls[$key]['likes'] = $likes;

            $melikes = WallLike::where('id_wall', $wall['id'])
            ->where('id_user', $user['id'])
            ->count();
            if ($melikes > 0) {
                $walls[$key]['liked'] = true;
            }
        }

        $array['list'] = $walls;

        return $array;
    }

    public function like($id){
        $array = ['error' => ''];

        $user = auth()->user();

        $melikes = WallLike::where('id_wall', $id)
        ->where('id_user', $user['id'])
        ->count();

        if($melikes > 0) {
            //remover o like
            WallLike::where('id_wall', $id)
            ->where('id_user', $user['id'])
            ->delete();
            $array['liked'] = false;
        }else {
            //adiciona o like
            $newLike = new WallLike;
            $newLike->id_wall = $id;
            $newLike->id_user = $user['id'];
            $newLike->save();
            $array['liked'] = true;
        }

        $array['likes'] = WallLike::where('id_wall', $id)->count(); //quantos registros de likes na postagem

        return $array;
    }
}
