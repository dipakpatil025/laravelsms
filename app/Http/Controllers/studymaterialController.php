<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\resource;

class studymaterialController extends Controller
{
    public function index()
    {
        $data = resource::with('coursename')->get();
        return view('studymaterial', ['data' => $data]);
    }

    public function uploadstudymaterial(Request $req)
    {
        if ($check = resource::where('url', $req->link)->first()) {
            return back()->with('successalready', ['resource already exist', $check->id]);
        }
        $result = resource::create([
            'course_id' => $req->course,
            'short_description' => $req->shortdesc,
            'detailed_description' => $req->detaileddesc,
            'url' => $req->link
        ]);
        if ($result) {
            return back()->with('success', ['resource added successfully']);
        } else {
            return back()->with('error', ['something went wrong, please try again !']);
        }
    }

    public function view_studymaterial($id)
    {
        $data = resource::where('id', $id)->with('coursename')->first();
        return view('view-resource', ['data' => $data]);
    }
    public function editstudymaterial(Request $req)
    {
        $result = resource::find($req->id)->update([
            'course_id' => $req->course,
            'short_description' => $req->shortdesc,
            'detailed_description' => $req->detaileddesc,
            'url' => $req->link
        ]);
        if ($result) {
            return back()->with('success', 'changes have been saved !');
        } else {
            return back()->with('error', 'something went wrong, please try again !');
        }
    }
}
