<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Importando model
use App\Models\Pessoa;


class PessoaTest extends TestCase
{
    use RefreshDatabase; // Isso serve para limpar o banco após o teste

    /** @test */
    public function pessoa_method_index()
    {
        $this->withoutExceptionHandling();

        $pessoas = Pessoa::factory(2)->create();

        $response = $this->getJson('api/pessoas');

        $response->assertStatus(200)->assertOk();

        $pessoas = Pessoa::all();

        $response->assertJson([
            [
                "id" => $pessoas->first()->id,
                "nome" => $pessoas->first()->nome,
                "email" => $pessoas->first()->email,
                "cpf" => $pessoas->first()->cpf,
                "data_nasc" => $pessoas->first()->data_nasc,
                "nacionalidade" => $pessoas->first()->nacionalidade,
                "created_at" => $pessoas->first()->created_at,
                "updated_at" => $pessoas->first()->updated_at
            ],
            [
                "id" => $pessoas->last()->id,
                "nome" => $pessoas->last()->nome,
                "email" => $pessoas->last()->email,
                "cpf" => $pessoas->last()->cpf,
                "data_nasc" => $pessoas->last()->data_nasc,
                "nacionalidade" => $pessoas->last()->nacionalidade,
                "created_at" => $pessoas->last()->created_at,
                "updated_at" => $pessoas->last()->updated_at
            ]
        ]);
    }

    /** @test */
    public function pessoa_method_show()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $response = $this->getJson("api/pessoas/{$pessoa->id}");

        $response->assertOk();

        $this->assertCount(1, Pessoa::all());

        $response->assertJson(
            [
                "id" => $pessoa->id,
                "nome" => $pessoa->nome,
                "email" => $pessoa->email,
                "cpf" => $pessoa->cpf,
                "data_nasc" => $pessoa->data_nasc,
                "nacionalidade" => $pessoa->nacionalidade,
                "created_at" => $pessoa->created_at,
                "updated_at" => $pessoa->updated_at
            ]
        );
    }

    /** @test */
    public function pessoa_method_store()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('api/pessoas',[
            'nome' => 'Tyger Woods',
            'email' => 'tyger@email.com',
            'cpf' => '13097181725',
            'data_nasc' => '1972-04-25',
            'nacionalidade' => 'Estadunidense'
        ])->assertStatus(200);

        $pessoa = Pessoa::first();

        $this->assertCount(1, Pessoa::all());

        $this->assertEquals('Tyger Woods', $pessoa->nome);
        $this->assertEquals('tyger@email.com', $pessoa->email);
        $this->assertEquals('13097181725', $pessoa->cpf);
        $this->assertEquals('1972-04-25', $pessoa->data_nasc);
        $this->assertEquals('Estadunidense', $pessoa->nacionalidade);

        $response->assertJson(
            [
                "id" => $pessoa->id,
                "nome" => $pessoa->nome,
                "email" => $pessoa->email,
                "cpf" => $pessoa->cpf,
                "data_nasc" => $pessoa->data_nasc,
                "nacionalidade" => $pessoa->nacionalidade
            ]
        );
    }

    /** @test */
    public function pessoa_method_update()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $response = $this->putJson("api/pessoas/{$pessoa->id}",[
            'nome' => 'Hayley Willims',
            'email' => 'hayley@email.com',
            'cpf' => '00002471701',
            'data_nasc' => '1990-11-17',
            'nacionalidade' => 'Estadunidense'
        ])->assertStatus(200);

        $this->assertCount(1, Pessoa::all());

        $pessoa = $pessoa->fresh();

        $this->assertEquals('Hayley Willims', $pessoa->nome);
        $this->assertEquals('hayley@email.com', $pessoa->email);
        $this->assertEquals('00002471701', $pessoa->cpf);
        $this->assertEquals('1990-11-17', $pessoa->data_nasc);
        $this->assertEquals('Estadunidense', $pessoa->nacionalidade);
 
        $this->assertTrue($response['updated']);
    }

    /** @test */
    public function pessoa_method_destroy()
    {
        $this->withoutExceptionHandling();

        $pessoa = Pessoa::factory()->create();

        $response = $this->deleteJson("api/pessoas/{$pessoa->id}")->assertStatus(200);

        $this->assertCount(0, Pessoa::all());
    }
}
