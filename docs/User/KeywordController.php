<?php

namespace App\Http\Controllers\User;

use App\Keyword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keywords = Keyword::where('user_id', '=', auth()->id() )->latest()->get();
        $counter   = 0;

        return view( 'user.keywords.index', compact( 'keywords', 'counter' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'user.keywords.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'keyword'      => 'required|unique:keywords,keyword,NULL,id,user_id,' . auth()->id(),
            'keyword_type' => 'required',
        ];

        if ( $request->keyword_autoresponse == 'yes' ) {
            $rules[ 'keyword_text' ]         = 'required';
        }

        // Validating inputs
        $this->validate( $request, $rules );

        // store
        $keyword = new Keyword();

        $keyword->user_id               = auth()->id();
        $keyword->keyword               = $request->keyword;
        $keyword->keyword_type          = $request->keyword_type;
        $keyword->keyword_autoresponse  = $request->keyword_autoresponse;
        $keyword->keyword_text          = ( $request->keyword_autoresponse == 'yes' ) ? $request->keyword_text : '' ;

        $keyword->save();

        // success

        $request->session()->flash( 'alert-success', 'Keyword has been added successfully!' );

        // redirect
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Keyword $keyword
     * @return \Illuminate\Http\Response
     */
    public function edit( Keyword $keyword)
    {
        if ( auth()->id() != $keyword->user_id ) {
            return redirect()->back();
        }
        
        return view( 'user.keywords.edit', compact( 'keyword' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
 
        $rules = [
            'keyword'      => 'required',
            'keyword_type' => 'required',
        ];

        if ( $request->keyword_autoresponse == 'yes' ) {
            $rules[ 'keyword_text' ]         = 'required';
        }

        // Validating inputs
        $this->validate( $request, $rules );
        
        // store
        $keyword                        = Keyword::find( $id );
        $keyword->user_id               = auth()->id();
        $keyword->keyword               = $request->keyword;
        $keyword->keyword_type          = $request->keyword_type;
        $keyword->keyword_autoresponse  = $request->keyword_autoresponse;
        $keyword->keyword_text          = ( $request->keyword_autoresponse == 'yes' ) ? $request->keyword_text : '' ;

        $keyword->save();

        // success
        $request->session()->flash( 'alert-success', 'Keyword has been updated successfully!' );

        // redirect
        return redirect()->route( 'user.keywords.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keyword = Keyword::where( 'id', '=', $id )->where( 'user_id', '=', auth()->id() )->first();

        $keyword->delete();

        // success
        \Request::session()->flash( 'alert-success', 'Keyword has been deleted successfully!' );

        // redirect
        return redirect()->route( 'user.keywords.index' );
    }

}
