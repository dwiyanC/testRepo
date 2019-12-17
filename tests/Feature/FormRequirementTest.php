<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Auth;
use App\Inventory2;
use App\Comment2;

class FormRequirementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_item_name_required(){
        $this->actingAs(factory('App\User')->create(['role'=>'admin']));
        $item = factory('App\Inventory2')->make(['unit_name'=>null]);
        $this->post('/addItems/create', $item->toArray())->assertSessionHasErrors('unit_name');
    }
    public function test_item_type_required(){
        $this->actingAs(factory('App\User')->create(['role'=>'admin']));
        $item = factory('App\Inventory2')->make(['unit_type'=>null]);
        $this->post('/addItems/create', $item->toArray())->assertSessionHasErrors('unit_type');
    }
    public function test_item_number_required(){
        $this->actingAs(factory('App\User')->create(['role'=>'admin']));
        $item = factory('App\Inventory2')->make(['unit_no'=>null]);
        $this->post('/addItems/create', $item->toArray())->assertSessionHasErrors('UNIT_NUMBER');
    }

    public function test_login(){
        $user = factory('App\User')->create(['role'=>'user']);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => bcrypt('123456'),
        ]);
        $response->assertRedirect('/');
    }

    public function test_logout(){
        $user = factory('App\User')->create(['role'=>'user']);
        $response=$this->actingAs($user)
                       ->withSession(['id'=>$user->id])
                       ->get('/');
        $this->assertAuthenticatedAs($user);

        $response=$this->get('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('login');

    }
}
