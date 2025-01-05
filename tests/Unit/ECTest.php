<?php

namespace Tests\Unit;

use App\Models\Ec;
use App\Models\UE;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ECTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_creation_ec_avec_coefficient()
{
   

    // creation de l'EC
    $ec = EC::factory()->make([
        'coefficient' => 3,      
    ]);

    //Ajout  de L'EC a travers le Controleur
    $response = $this->post(route('ecs.store'), [
        'code' => $ec->code,     
        'nom' => $ec->nom,        
        'coefficient' => $ec->coefficient, 
        'ue_id' => $ec->ue_id,    
    ]);

    // Vérification de la redirection après la création de l'EC
    $response->assertRedirect(route('ecs.index'));

    // Vérifier si  l'EC a été ajouté dans la base de données
    $this->assertDatabaseHas('ecs', [
        'code' => $ec->code,
    ]);
}




    /** @test */
    public function test_rattachement_ec_a_une_ue()
{
    //creation ue 
    $ue = UE::create(['code' => 'UE01', 'nom' => 'Mathématiques', 'credits_ects' => 6, 'semestre' => 1]); // Créer une UE pour le test
    // Ajout Ec avec ue precedent
    $response = $this->post(route('ecs.store'), [
        'code' => 'EC02',
        'nom' => 'Chimie',
        'coefficient' => 3,
        'ue_id' => $ue->id, 
    ]);

    $response->assertRedirect(route('ecs.index'));
        // Vérifie que l'EC a bien été rattaché à l'UE

    $this->assertDatabaseHas('ecs', [
        'code' => 'EC02',
        'nom' => 'Chimie',
        'ue_id' => $ue->id,
    ]);
}


    /** @test */
    public function test_de_modification_dun_ec()
    {
        $ec = EC::factory()->create([
            'nom' => 'Algorithmes',
        ]);

        $ec->update([
            'nom' => 'Structures de Données',
        ]);

        $this->assertDatabaseHas('ecs', [
            'nom' => 'Structures de Données',
        ]);
        $this->assertDatabaseMissing('ecs', [
            'nom' => 'Algorithmes',
        ]);
    }

    /** @test */
    public function test_validation_coefficient()
{


    $ec = EC::factory()->make([ 
        'coefficient' => 3,      
    ]);

    // Test  coefficient invalide
    $response = $this->post(route('ecs.store'), [
        'code' => 'EC04',
        'nom' => 'Informatique',
        'coefficient' => 6, 
        'ue_id' => $ec->ue_id,
    ]);

    $response->assertSessionHasErrors('coefficient');

    // Test coefficient valide
    $response = $this->post(route('ecs.store'), [
        'code' => 'EC05',
        'nom' => 'Anglais',
        'coefficient' => 4,  
        'ue_id' => $ec->ue_id,
    ]);

    $response->assertRedirect(route('ecs.index'));
    $this->assertDatabaseHas('ecs', [
        'code' => 'EC05',
        'coefficient' => 4,
    ]);
}


    /** @test */
    public function test_de_suppression_dun_ec()
    {
        $ec = EC::factory()->create();

        $ec->delete();

        $this->assertDatabaseMissing('ecs', [
            'id' => $ec->id,
        ]);
    }
}
