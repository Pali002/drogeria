<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Perfume;

class PerfumeController extends Controller {
    public function getPerfumes() {

        $perfumes = Perfume::all();

        return view( "/perfumes", [
            "perfumes" => $perfumes
        ]);
    }

    public function newPerfume() {

        return view( "/new_perfume");
    }

    public function storePerfume( Request $request ) {

        $values = $request->validate([
            "name" => "required",
            "type" => "required",
            "price" => "required"
        ], [
            "name.required" => "Töltse ki a Név mezőt!",
            "type.required" => "Töltse ki a Típus mezőt!",
            "price.required" => "Töltse ki az Ár mezőt!"
        ]);

        $perfume = new Perfume;

        $perfume->name = $request->name;
        $perfume->type = $request->type;
        $perfume->price = (int)$request->price;
        $perfume->save($values);

        return redirect( "/new-perfume" );
    }

    public function editPerfume( $id ) {

        $perfume = Perfume::find( $id );

        return view( "/edit_perfume", [
            "perfume" => $perfume
        ]);
    }

    public function updatePerfume( Request $request ) {

        $perfume = Perfume::where("id",$request->id)->first();

        $perfume->name = $request->name;
        $perfume->type = $request->type;
        $perfume->price = $request->price;
        $perfume->save();

        return redirect("/perfumes");
    }

    public function deletePerfume( $id ) {

        $perfume = Perfume::find( $id );
        $perfume->delete();

        return redirect( "/perfumes" );
    }
}
