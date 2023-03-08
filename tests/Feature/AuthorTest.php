<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use WithFaker; 

    /**
     * function for login and creating token
     * @paramIN(email, password) array
     * @paramOUT token
     * add in header accept for json, x-api-key and passport
     * add status and structure
     */
    public function testSuccessLogin()
    {

        $loginData = ['email' => 'admin@mail.com', 'password' => '1234567'];
        $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json', 'x-api-key'=>'ad2040H0d09Rb69d232d127e6817c99a38fe4c99a4757d71550ba1d420069'])
            ->assertStatus(200)
            ->assertJsonStructure([
                   'name',
                   'token',
            ]);

        $this->assertAuthenticated();
        return $accessToken = auth()->user()->createToken('Te3&kdY23%b!f$')->accessToken;
    }
    

     /**
     * function get specific author
     * empty array
     * add in header accept for json, x-api-key and passport
     * add status and structure
     */
    public function testGetAuthorById()
    {
        $token = $this->testSuccessLogin();
        $this->json('GET', 'api/author/1',[],  ['Accept' => 'application/json', 'x-api-key'=>'ad2040H0d09Rb69d232d127e6817c99a38fe4c99a4757d71550ba1d420069', 'Authorization' => 'Bearer '. $token])
        ->assertStatus(200)
        ->assertJsonStructure([
            'author'
            =>[
                '*'=> [
                    'id',
                    'name',
                    'surname',
                    'images',
                    'active',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
     
    }


     /**
     * function insert author
     * @paramIN(name, password) array createt by faker
     * add in header accept for json, x-api-key and passport
     * add status and structure
     */

 
    public function testInsertAuthor()
    {
        $token = $this->testSuccessLogin();
        $data =[
            'name'=>$this->faker->firstname,
            'surname'=>$this->faker->lastName
        ];
        $this->json('POST', 'api/author/',$data,  ['Accept' => 'application/json', 'x-api-key'=>'ad2040H0d09Rb69d232d127e6817c99a38fe4c99a4757d71550ba1d420069', 'Authorization' => 'Bearer '. $token])
        ->assertStatus(201)
        ->assertJsonStructure([
            'message'
        ]);
     
    }

    /**
     * function update author
     * @paramIN(name, pasusersword) array created by faker
     * add id
     * add in header accept for json, x-api-key and passport
     * add status and structure
     */
    public function testUpdateAuthor()
    {
        $token = $this->testSuccessLogin();
        $data =[
            'name'=>$this->faker->firstname,
            'surname'=>$this->faker->lastName
        ];
      
        $this->json('PUT', 'api/author/3',$data,  ['Accept' => 'application/json', 'x-api-key'=>'ad2040H0d09Rb69d232d127e6817c99a38fe4c99a4757d71550ba1d420069', 'Authorization' => 'Bearer '. $token])
        ->assertStatus(200)
        ->assertJsonStructure([
            'message'
        ]);
     
    }
   
}
