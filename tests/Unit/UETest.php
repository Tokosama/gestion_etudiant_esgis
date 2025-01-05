<?php

namespace Tests\Unit;

use App\Models\UE;
use App\Models\EC;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UETest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_creation_ue_valide()
    {
        $response = $this->post(route('ues.store'), [
            'code' => 'UE01',
            'nom' => 'Informatique',
            'credits_ects' => 6,
            'semestre' => 6,
        ]);

        $response->assertRedirect(route('ues.index'));
        $this->assertDatabaseHas('ues', [
            'code' => 'UE01',
            
        ]);
    }

    /** @test */
    public function test_credits_ects_valide()
{
    // Test avec des crédits ECTS valides
    $response = $this->post(route('ues.store'), [
        'code' => 'UE02',
        'nom' => 'Mathématiques',
        'credits_ects' => 20,  // Valide
        'semestre' => 4,
    ]);

    // Verifie qu'il n'y est pas d'erreur
    $response->assertSessionDoesntHaveErrors('credits_ects');

    
}

    /** @test */
    public function test_verifier_lassociation_des_ecs_a_une_ue()
    {
        $ue = UE::factory()->create();
    
        $ec = EC::factory()->create([
            'ue_id' => $ue->id, 
            
        ]);
    
        $this->assertTrue($ue->ecs->contains($ec));
    }

    /** @test */
    public function test_code_ue_valide()
{
    // Test avec un code valide au format "UExx"
    $response = $this->post(route('ues.store'), [
        'code' => 'UE01',  
        'nom' => 'Chimie',
        'credits_ects' => 5,
        'semestre' => 1,
    ]);

    // Vérifiez que l'on n'a pas d'erreur si l'UE est valide
    $response->assertSessionDoesntHaveErrors('code');

    
}


   
public function test_semestre_valide()
{
    // Test avec un semestre valide 
    $response = $this->post(route('ues.store'), [
        'code' => 'UE04',
        'nom' => 'Biologie',
        'credits_ects' => 6,
        'semestre' => 1,  // Valide
    ]);

    // Vérifiez que l'on n'a pas d'erreur pour le semestre
    $response->assertSessionDoesntHaveErrors('semestre');

    
}

}
