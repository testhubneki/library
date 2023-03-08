<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Http\Requests\SearchRequest;

class BookAutorController extends Controller
{
    /**
     * Inner join table using query builder where data is active
     * @paramOut() array of joined table
     */
    public function index()
    {
        $data = \DB::table('books')->select('books.title', 'books.description', 'authors.surname','authors.name','authors.images')
        ->join('authors','authors.id','=','books.author_id')
        ->where('books.active', 1)
        ->where('authors.active',1)
        ->paginate(10);

        return response()->json(['message'=>$data], 200);
    }

    /**
     * @paramIN() $request
     * create join query using query builder for join tables and checking request data
     * @paramOut() array of joined table by searched data
     */

    public function search(Request $request)
    {
      
        $name = $request->name;
        $surname = $request->surname;
        $title = $request->title;
       

        $query = \DB::table('books')->select('books.title', 'books.description', 'authors.surname','authors.name','authors.images')
        ->join('authors','authors.id','=','books.author_id')
        ->where('books.active', 1)
        ->where('authors.active',1);

        $query->when($request->name, function($f, $name){
            return $f->where('authors.name', 'LIKE', "%{$name}%");
        });
        $query->when($request->surname, function($f, $surname){
            return $f->where('authors.surname', 'LIKE', "%{$surname}%");
        });
        $query->when($request->title, function($f,$title){
            return $f->where('books.title', 'LIKE', "%{$title}%");
        });
        
        $data = $query->paginate(10);
     
        return response()->json(['message'=>$data], 200);
    }

    
}
