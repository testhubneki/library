<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BookHelperController;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    private $bookHelper;

    public function __construct(BookHelperController $bookHelper)
    {
        $this->bookHelper = $bookHelper;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Book::select('title', 'description','number','author_id')->where('active',1)->paginate(15);
        return response()->json(['book'=>$data], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *  @paramIn($request data) type array, checking validation input
     * check if id of author exist
     * store data
     */
    public function store(BookRequest $request)
    {
        $request->validated();
        $author_id = $request->author_id;
        $id = $this->bookHelper->checkAuthor($author_id);
        // $test = $id[0]->id;
        // return response()->json(['message'=>$id[0]->id], 200);
        if($id->isNotEmpty()){
            $description =($request->description) ? $request->description : null;
            Book::insert([
                'title'=>$request->title,
                'number'=>uniqid(),
                'description'=>$description,
                'author_id'=>$author_id
            ]);
            return response()->json(['message'=>"Success"], 201);
        }
        return response()->json(['error'=>'Author does not exist. Choose another or create author'], 200);
    }

    /**
     * Display the specified resource.
     * @paramIn($id ) type array
     * @paramOut() data by id
     */
    public function show(string $id)
    {
        $data =  Book::where('id', $id)->where('active', 1)->get();
     
        return response()->json(['data'=>$data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookRequest $request, string $id)
    {
      
        $request->validated();

        $book = Book::where('id', $id)->get();
        $id_author = $this->bookHelper->checkAuthor($id);
        $description =($request->description) ? $request->description : null;
        
        if(!empty($id_author[0]->id)) {
            
            Book::where('id', $id)->update([
                'title' => $request->title,
                'number' => $request->number,
                'description' => $description,
                'author_id'=>$request->author_id
             ]);
             return response()->json(['message'=>"Success update"], 200);
        }
        return response()->json(['message'=>"Error try again"], 200);
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Book::where('active', 1)
        ->where('id', $id)
        ->update([
            'active' => 0,
        ]);

        return response()->json(['message'=>"Success deleted"], 200);
    }
}
