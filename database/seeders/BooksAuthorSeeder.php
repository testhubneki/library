<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BooksAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try 
        {
            \DB::beginTransaction();
            
            $author = Author::create([
                'name' =>'Ivo ',
                'surname' => 'Andric',
             
            ]);
            $id = $author->id;

            $books = ['Na drini cuprija', 'Prokleta Avlija','Razgovor sa Gojo', 'Gospodja'];
            for($i=0; $i<count($books); $i++){
                Book::create([
                    'title' => $books[$i],
                    'number'=> uniqid(),
                    'author_id' =>$id
                ]);
            }
          

              
            $author = Author::create([
                'name' =>'Den ',
                'surname' => 'Braun',
             
            ]);
            $id = $author->id;

            $books = ['Tacka prevare', 'Digitalna Tvrdjava','Inferno', 'Da Vincijev kod', 'Andjeli i demoni'];
            for($i=0; $i<count($books); $i++){
                Book::create([
                    'title' => $books[$i],
                    'number'=> uniqid(),
                    'author_id' =>$id
                ]);
            }
            $author = Author::create([
                'name' =>'Dzon Ronald Rejel ',
                'surname' => 'Tolkin',
             
            ]);
            $id = $author->id;

            $books = ['Hobit', 'Gospodar Prstenova','Hobit'];
            for($i=0; $i<count($books); $i++){
                Book::create([
                    'title' => $books[$i],
                    'number'=> uniqid(),
                    'author_id' =>$id
                ]);
            }

            \DB::commit();
        } catch (\Exception $e){
            \DB::rollBack();
            \Log::info($e->getMessage());
        }
    }
}
