<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

class BookHelperController extends Controller
{
    /**
     * @paramIN($request) get data 
     * @paramOut() array if data exist by id
     */
    public function checkAuthor($id) 
    {
       $id = Author::select('id')->where('id', $id)->get();
       return $id;
    }

    /**
     * @paramIn(request, id)
     * checking if exist number if esist ansame as current id then current number 
     */
    public function checkNumber($request, $id)
    {

            $book = Book::where('id', $id)->get();

            $check_number = Book::where('number', $request->number)->where('active',1)->get();
           
            if($book[0]->number === $request->number && $book[0]->id === $id){
                $number = $request->number;
            }
            if($book[0]->number !== $request->number && $book[0]->id === $id){
                $number = $request->number;
            }
            if($book[0]->number === $request->number && $book[0]->id !== $id){
                $number = $request->number;
            }
            if($book[0]->number !== $request->number && $book[0]->id !== $id){
                $number = $request->number;
            }
            if($book[0]->number !== $request->number && $book[0]->id !== $id){
                $number = uniqid();
            }

            return $number;
    }
}
