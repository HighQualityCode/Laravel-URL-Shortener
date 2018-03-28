<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Redirect;
use App\Link;
use Auth;

class ShortenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //define the Form validation rule(s)
        $rules = array(
            'link' => 'required|url'
        );

        //run the form validation
        $validation = Validator::make(Input::all(),$rules);

        if($validation->fails()) {
            return Redirect::to('/')
                ->withInput()
                ->withErrors($validation);
        } else {
            $link = Link::where('url','=',Input::get('link'))->first();

            if($link) {
                return Redirect::to('/')
                    ->withInput()
                    ->with('link',$link->hash);
            } else {
                do {
                    $newHash = Str::random(6);
                } while(Link::where('hash','=',$newHash)->count() > 0);

                $user = Auth::user();
                Link::create(array('username' => $user->name, 'url' => Input::get('link'), 'hash' => $newHash));

                return Redirect::to('/home');
            }
        }
    }

    public function link($hash) {
        $link = Link::where('hash','=',$hash)->first();
        $link->count += 1;
        $link->save();
        if($link) {
            return Redirect::to($link->url);
        } else {
            return Redirect::to('/')
                ->with('message','Invalid Link');
        }
    }
}
