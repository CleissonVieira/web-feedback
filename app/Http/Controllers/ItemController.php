<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Session;
use App\Item;
use App\User;
use App\Location;
use App\Category;
use App\Specification;

use Carbon\Carbon;

use App\Http\Resources\CommentResource;

class ItemController extends Controller
{
    const RESPONSE_MESSAGES = [
        '1' => 'Feedback criado com sucesso!',
        '2' => 'Serviço criado com sucesso!'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Returns the categories for a given type of item
     * @param int
     * @return
     */
    protected static function findCategoriesByItemType($itemType)
    {
        return Category::where('item_type', $itemType) -> get();
    }

        /**	
     * Display a listing of the resource.	
     *	
     * @return \Illuminate\Http\Response	
     */	
    public function index(Request $request)	
    {	
        $user = Auth::user();	

        return view('pages.item.index', [	
            'user' => $user	
        ]);	
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        $item['user'] = User::find($item->user_id)->name;
        $item['location_id'] = Location::find($item->location_id)->name;
        $item['category_id'] = Category::find($item->category_id)->name;
        $item['specification_id'] = Specification::find($item->specification_id);

        return view('pages.item', [
            'user' => Auth::user(),
            'item' => $item,
            'reactions' => $item -> reactions -> groupBy('text')
        ])->with('token',Session::get('token'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('pages.edit', [
            'user' => Auth::user(),
            'item' => $item,
            'categories' => $this->findCategoriesByItemType($item -> type),
            'locations' => Location::all()
        ])->with('token',Session::get('token'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'location_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ]);

        // TODO: checar location e category

        $item->user_id = Auth::user()->id;
        $item->location_id = $request->get('location_id');
        $item->category_id = $request->get('category_id');
        $item->specification_id = $request->get('specification_id');
        $item->status = Item::STATUS_WAITING;
        $item->title = $request->get('title');
        $item->description = $request->get('description');
        $item->github_issue_link = $request->get('github_issue_link');
        
        $item->save();
        $item->touch();

        return redirect('/home')->with('success', 'Item updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();

        return redirect('/home')->with('success', 'Item deleted!');
    }
}
