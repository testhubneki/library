<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Http\Requests\AuthorRequest;
use App\Http\Controllers\ImageController;

class AuthorController extends Controller
{
   
    private $image;

    public function __construct(ImageController $image)
    {
        $this->image = $image;
    }

    /**
     * Display a listing of the resource.
     * select data and use pagination
     */
    public function index()
    {
        
        $author = Author::select('name','surname')->where('active',1)->paginate(15);
        return response()->json(['name'=>$author], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @paramIn($request data) type array, checking validation input
     * Store a created resource in storage.
     */
    public function store(AuthorRequest $request)
    {
       
        $request->validated();
        $image = $this->image->imageSave($request);
        Author::create([
            'name'=>$request->name,
            'surname'=>$request->surname,
            'images' =>$image
        ]);
        
        return response()->json(['message'=>'Success insert'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $picture = ($author->picture == null) ? $this->picture : $author->picture;
       
        $data = Author::where('active', 1)->where('id', $author->id)->get();
        return response()->json(['author'=>$data], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *  @paramIn($request data) type array, checking validation input and update
     */
    public function update(AuthorRequest $request, Author $author)
    {
        
        $request->validated();
        
        $image = $this->image->imageSave($request);
        $data = Author::where('active', 1)
        ->where('id', $author->id)
        ->first()
        ->update([
            'name' => $request->name,
            'surname' =>$request->surname,
            'images'=>$image
        ]);
        
        return response()->json(['message'=>'Suceess update'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * update active to 0
     */
    public function destroy(Author $author)
    {
        Author::where('active', 1)
        ->where('id', $author->id)
        ->first()
        ->update([
            'active' => 0,
        ]);
    }
}
