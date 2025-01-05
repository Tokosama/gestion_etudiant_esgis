<?php

namespace Tests\Unit;

use App\Models\EC;
use App\Models\Etudiant;
use App\Models\Note;
use App\Models\UE;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function testAjoutNoteValide()
{
    $etudiant = Etudiant::factory()->create();
    $ec = EC::factory()->create();
    
    $response = $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 20,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
     // Redirection après enregistrement
    $response->assertStatus(302);
    $response->assertSessionHas('success', 'Note de session normale ajoutée avec succès.');
}

public function testNoteLimite()
{
    $etudiant = Etudiant::factory()->create();
    $ec = EC::factory()->create();
    
    // Teste avec une note valide (entre 0 et 20)
    $response = $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 15, 
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    // Verification de si nous navons aucune erreur 
    $response->assertSessionDoesntHaveErrors('note');

    // Teste avec une note invalide
    $response = $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 25,  
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    // Verification de si nous navons une erreur pour la note
    
    $response->assertSessionHasErrors('note');
}


    
    
    


public function testCalculMoyenneUE()
{
    // Création de l'étudiant
    $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);

    // Création de l'UE
    $ue = UE::factory()->create(['id' => 1 ,'semestre' => 1]);
    
    // Création de deux ECs rattachés à l'UE
    $ec1 = EC::factory()->create(['ue_id' => $ue->id, 'coefficient' => 2]);
    $ec2 = EC::factory()->create(['ue_id' => $ue->id, 'coefficient' => 3]);
    
    // Ajout de notes pour chaque EC
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,  
        'ec_id' => $ec1->id,
        'note' => 12,  
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec1->id,
        'note' => 14,
        'session' => 'rattrapage',
        'date_evaluation' => '2025-02-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec2->id,
        'note' => 10,  
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec2->id,
        'note' => 10,
        'session' => 'rattrapage',
        'date_evaluation' => '2025-02-01',
    ]);
    
    // Recuperation des valeurs dans le controleur qui interagit avec cette vue
    $resultats = $this->get("/resultats/etudiant/{$etudiant->id}/semestre/1");   
    $resultats->assertStatus(200);
// Recuperation des données passées à la vue (resultatsParSemestre)
$resultatsParSemestre = $resultats->viewData('resultatsParSemestre');

// Recuperation de la moyenne de l'UE et la comparer avec la moyenne attendue
$moyenneCalculée = $resultatsParSemestre[1][1]['moyenne']; 
// Comparaison avec la moyenne attendue
$this->assertEquals(11.6, $moyenneCalculée);}



public function testGestionSessions()
{
    $etudiant = Etudiant::factory()->create();
    $ec = EC::factory()->create();
    
    // Ajout une note de session normale
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 10,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 12,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    
    // Ajout une note de session de rattrapage
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        'note' => 14,
        'session' => 'rattrapage',
        'date_evaluation' => '2025-02-01',
    ]);
    //Recupation de la liste de notes
    $response = $this->get('/notes');

    $response->assertViewHas('notes', function ($notes) {
        return $notes->contains('session', 'normale' );
    });
    $response->assertViewHas('notes', function ($notes) {
        return $notes->contains('note', 10 );
    });
    $response->assertViewHas('notes', function ($notes) {
        return $notes->contains('session', 'rattrapage' );
    });

    $response->assertViewHas('notes', function ($notes) {
        return $notes->contains('note', 14 );
    });

}



public function testValidationNotesManquantes()
{
    $etudiant = Etudiant::factory()->create();
    $ec = EC::factory()->create();
    
    //Ajout sans champ note
    $response = $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec->id,
        
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    
    $response->assertSessionHasErrors('note');
}

    
}
