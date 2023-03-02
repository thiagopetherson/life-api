<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Pessoa;
use App\Models\Contato;

class ContatoTest extends TestCase
{
    use RefreshDatabase; // Isso serve para limpar o banco após o teste

    /** @test */
    public function contato_method_index()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory(2)->create();

        $contatos = Contato::factory(2)->create();

        $response = $this->getJson('api/contatos');

        $response->assertOk();

        $contatos = Contato::all();

        $response->assertJson([
            [
                "id" => $contatos->first()->id,
                "pessoa_id" => $contatos->first()->pessoa_id,
                "telefone" => $contatos->first()->telefone,                
                "created_at" => $contatos->first()->created_at,
                "updated_at" => $contatos->first()->updated_at
            ],
            [
                "id" => $contatos->last()->id,
                "pessoa_id" => $contatos->last()->pessoa_id,
                "telefone" => $contatos->last()->telefone,               
                "created_at" => $contatos->last()->created_at,
                "updated_at" => $contatos->last()->updated_at
            ]
        ]);
    }

    /** @test */
    public function contato_method_show()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $contato = Contato::factory()->create();

        $response = $this->getJson("api/contatos/{$contato->id}");

        $response->assertOk();

        $this->assertCount(1, Contato::all());

        $response->assertJson(
            [
                "id" => $contato->id,
                "pessoa_id" => $contato->pessoa_id,
                "telefone" => $contato->telefone,                
                "created_at" => $contato->created_at,
                "updated_at" => $contato->updated_at
            ]
        );
    }

    /** @test */
    public function contato_method_store()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $response = $this->postJson('api/contatos',[
            'pessoa_id' => $pessoa->id,
            'telefone' => '12978543782'           
        ])->assertStatus(200);

        $contato = Contato::first();

        $this->assertCount(1, Contato::all());

        $this->assertEquals($pessoa->id, $contato->pessoa_id);
        $this->assertEquals('12978543782', $contato->telefone);        

        $response->assertJson(
            [
                "id" => $contato->id,
                "pessoa_id" => $contato->pessoa_id,
                "telefone" => $contato->telefone,                
                "created_at" => $contato->created_at,
                "updated_at" => $contato->updated_at
            ]
        );
    }

    /** @test */
    public function contato_method_update()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $contato = Contato::factory()->create();

        $response = $this->putJson("api/contatos/{$contato->id}",[
            "pessoa_id" => $pessoa->id,
            "telefone" => '21965194652'           
        ])->assertStatus(200);

        $this->assertCount(1, Contato::all());

        $contato = $contato->fresh();

        $this->assertEquals($pessoa->id, $contato->pessoa_id);
        $this->assertEquals('21965194652', $contato->telefone);

        $response->assertJson(
            [
                "id" => $contato->id,
                "pessoa_id" => $contato->pessoa_id,
                "telefone" => $contato->telefone,               
                "created_at" => $contato->created_at,
                "updated_at" => $contato->updated_at
            ]
        );
    }

    /** @test */
    public function contato_method_destroy()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $contato = Contato::factory()->create();

        $response = $this->deleteJson("api/contatos/{$contato->id}")->assertStatus(200);

        $this->assertEmpty(Contato::all());
    }

}
