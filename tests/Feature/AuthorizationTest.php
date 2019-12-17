<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Inventory2;
use App\Comment2;
use App\ItemImage;
use Auth;
use App\Category;
use Faker;
use Storage;
use Illuminate\Support\Str;


class AuthorizationTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_no_login_credentials_cannot_view_index()
    {
        $response = $this->get('/addItems');

        $response->assertRedirect('/login');
    }

    public function test_no_login_credentials_cannot_add_item()
    {
        $response = $this->get('/addItems');

        $response->assertRedirect('/login');
        
    }

    public function test_no_login_credentials_cannot_view_edit_item()
    {
        $response = $this->get('/edit/*');

        $response->assertRedirect('/login');

    }

    public function test_no_login_credentials_cannot_delete_item()
    {
        $response = $this->get('/delete/*');

        $response->assertRedirect('/login');

    }

    public function test_logged_can_view_index(){
        $user = factory('App\User')->create(['role'=>'user']);
        $response=$this->actingAs($user)
                       ->withSession(['id'=>$user->id])
                       ->get('/');
        // $response->assertSee('Inventory List');
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(200);
    }

    public function test_logged_can_view_details(){
        $user = factory('App\User')->create(['role'=>'user']);
        $response=$this->actingAs($user)
                       ->withSession(['id'=>$user->id])
                       ->get('/details/*');
        $response->assertSee('Item Details');
        $this->assertAuthenticatedAs($user);

    }

    //clear
    public function test_admin_can_delete(){
        $item = factory('App\Inventory2')->create();
        $user = factory('App\User')->create(['role'=>'admin']);
        $response=$this->actingAs($user)
                       ->withSession(['id'=>$user->id])
                       ->get('delete/'.$item->id);
        $this->delete('delete/'.$item->id);
        $this->assertDatabaseMissing('inventories',['id'=>$item->id]);
        $response->assertRedirect('/');

    }
    //clear
    public function test_user_cannot_delete(){
        $item = factory('App\Inventory2')->create();
        $user = factory('App\User')->create(['role'=>'user']);
        $response=$this->actingAs($user)
                       ->withSession(['id'=>$user->id])
                       ->get('delete/'.$item->id);
        $this->delete('delete/'.$item->id);
        $this->assertDatabaseHas('inventories',['id'=>$item->id]);
        $response->assertStatus(302)->assertRedirect('/');

    }
    //clear
    public function test_admin_can_view_add_item(){
        //create user from factory
        // $this-> actingAs (log in) -> withSession -> get/post/put

        $user = factory('App\User')->create(['role'=>'admin']);
        $itemCategories = Category::all();
        $response= $this->actingAs($user)
                        ->withSession(['id'=>$user->id])
                        ->get('/addItems');
        $this->assertAuthenticatedAs($user);

        $response->assertStatus(200);
    }
    public function test_user_cannot_view_add_item(){
        //create user from factory
        // $this-> actingAs (log in) -> withSession -> get/post/put

        $user = factory('App\User')->create(['role'=>'user']);
        $itemCategories = Category::all();
        $response= $this->actingAs($user)
                        ->withSession(['id'=>$user->id])
                        ->get('/addItems');
        $this->assertAuthenticatedAs($user);

        $response->assertStatus(403);
        $response->assertSee('unauthorized');
    }

    //clear
    public function test_user_cannot_edit_item(){
        // $response = $this->get('/edit/{id}');
        $this->actingAs(factory('App\User')->create(['role'=>'user']));
        $item = factory('App\Inventory2')->create();
        $item->unit_name = 'new name';
        $response = $this->put('updateItem/'.$item->id, $item->toArray());
        $response->assertStatus(405);
    }
    //clear
    public function test_admin_can_edit_item(){
        $this->withoutMiddleware();
        $user = factory('App\User')->create(['role'=>'admin']);
        $item = factory('App\Inventory2')->create();
        $item->unit_name = 'new name';
        $response= $this->actingAs($user)
                        ->withSession(['id'=>$user->id])
                        ->post('updateItem/'.$item->id, $item->toArray());
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302);
        $response->assertRedirect('/');
    }
    //clear
    public function test_logged_can_add_comment(){        
        $user = factory('App\User')->create(['role'=>'admin']);
        $item = factory('App\Inventory2')->create();
        $data = [
            'inventory2_id'=>$item->id, //this is incorrect -> should follow controlleres rule
            'comment'=>'tessssssss',
        ];

        $response= $this->actingAs($user)
                        ->withSession(['id'=>$user->id])
                        ->post('addComment/'.$item->id, [
                            'itemID'=>$item->id,
                            'comment'=>'tessssssss'
                        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302)

        ->assertRedirect('details/'.$item->id);
        $this->assertEquals(1,Comment2::where('inventory2_id',$item->id)->count());

    }
    //clear
    public function test_no_credential_cannot_add_comment(){
        $item = factory('App\Inventory2')->create();
        // $commentCountPrev = Comment2::all()->count();
        $comment = factory('App\Comment2')->make();
        // $response = $this->post('addComment/'.$item->id, $comment->toArray());
        // $this->assertEquals($commentCountPrev+1,Comment2::all()->count());

        $response = $this->post('addComment/'.$item->id,[
            'comment'=>$comment,
            'inventory2_id'=>$item->id,
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('/login');

    }

    // public function test_show_main_image($item){
    //     $item = $item;
    //     $response=$this->get('details/'.$item->id);
    //     $response->assertSee('item_'.$item->id.'MainImage.jpg');

    //     return 
    // }

    //clear
    public function test_add_main_image(){
        //assertdatabasehas
        $user = factory('App\User')->create(['role'=>'admin']);
        $item = factory('App\Inventory2')->create();
        // $image = $faker->image('public/image',640,480, null, false);
        $imageData = [
            'id'=>$item->id,
            'unit_image' => new \Illuminate\Http\UploadedFile('public/storage/testimage/508784b4d9e1d9c93b90855329cb52cb.jpg','testImage.jpg', null, null, null, true),
        ];

        $response= $this->actingAs($user)->withSession(['id'=>$user->id])->post('addImage/'.$item->id, $imageData);
        
        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302);
        $this->assertDatabaseHas('item_images',['inventory2_id'=>$item->id]);
        
        // $result = test_show_main_image($item);
    }  

    // public function test_show_main_image($item){
    //     $item = $item;
    //     $response=$this->get('details/'.$item->id);
    //     $response->assertSee('item_'.$item->id.'MainImage.jpg');
    // }
/*
    public function test_add_carousel_images(){

    }

    public function test_show_carousel(){

    }
    */
    


}
