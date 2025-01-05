<?php

namespace Tests\Unit;

use App\Models\EC;
use App\Models\Etudiant;
use App\Models\Note;
use App\Models\UE;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ValidationTest extends TestCase
{ use RefreshDatabase;
    /**
     * A basic unit test example.
     */
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
    $resultats->assertStatus(200); //verification  si la methode get  s'est bien deroulee

// On récupère les données du controleur passées à la vue (resultatsParSemestre)
$resultatsParSemestre = $resultats->viewData('resultatsParSemestre');

// Récupérer le statue de validation de l'UE
$validation = $resultatsParSemestre[1][1]['valide']; 

// verification avec le statue de validation attendu
$this->assertTrue($validation);
}
public function testCalculECTS()
{
    // Création de l'étudiant
    $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);

    // Création de trois UE pour le semestre 1
    $ue1 = UE::factory()->create(['credits_ects' => 3 ,'semestre' => 1]);
    $ue2 = UE::factory()->create(['credits_ects' => 3 , 'semestre' => 1]);
    $ue3 = UE::factory()->create(['credits_ects' => 3 , 'semestre' => 1]);

    // Création de deux EC pour chaque UE
    $ec1 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
    $ec2 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 3]);

    $ec3 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 2]);
    $ec4 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

    $ec5 = EC::factory()->create(['ue_id' => $ue3->id, 'coefficient' => 2]);
    $ec6 = EC::factory()->create(['ue_id' => $ue3->id, 'coefficient' => 3]);

    // Ajout des notes pour chaque EC
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec1->id,
        'note' => 12,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec2->id,
        'note' => 14,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec3->id,
        'note' => 15,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec4->id,
        'note' => 8,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec5->id,
        'note' => 15,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec6->id,
        'note' => 13,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    // Recuperation des valeurs dans le controleur qui interagit avec cette vue

    $resultats = $this->get("/etudiant/{$etudiant->id}/resultats"); 
    $resultats->assertStatus(200);


// Recuperation du nombre de creditAcquis


    $resultatAnnee = $resultats->viewData('creditsAcquis');


//Comparaison avec le nombre de credit acquis attendu
$this->assertEquals(9, $resultatAnnee);

}

public function testValidationSemestre()
    
{ 
    // Création de l'étudiant
    $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);

    // Création de l'UE
    $ue1 = UE::factory()->create(['id' => 1 ,'semestre' => 1]);
    $ue2 = UE::factory()->create(['id' => 2 ,'semestre' => 1]);
    
    // Création de deux ECs rattachés à chaque UE
    $ec1 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]); 
    $ec2 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 3]); 
    $ec3 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 2]); 
    $ec4 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]); 
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
    //UE 2

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,  
        'ec_id' => $ec3->id,
        'note' => 12,  
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id, 
        'ec_id' => $ec4->id,
        'note' => 12,  
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);


    // Recuperation des valeurs dans le controleur qui interagit avec cette vue
    
    $resultats = $this->get("/resultats/etudiant/{$etudiant->id}/semestre/1");   
    $resultats->assertStatus(200);
// On récupère les données du controleur passées à la vue 
$validationSemestre = $resultats->viewData('validationSemestre');

// Récupération du Status du semestre
$validation = $validationSemestre[1]['valide'];

// Comparer avec le Statue obtenue
$this->assertTrue($validation);
}

public function testPassageAnneeSuivante()
{
    // Création de l'étudiant
    $etudiant = Etudiant::factory()->create(['niveau' => 'L1']);

    // Création de trois UE pour le semestre 1
    $ue1 = UE::factory()->create(['credits_ects' => 3 , 'semestre' => 1]);
    $ue2 = UE::factory()->create(['credits_ects' => 3 , 'semestre' => 1]);
    $ue3 = UE::factory()->create(['credits_ects' => 3 , 'semestre' => 1]);

    // Création de deux EC pour chaque UE
    $ec1 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 2]);
    $ec2 = EC::factory()->create(['ue_id' => $ue1->id, 'coefficient' => 3]);

    $ec3 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 2]);
    $ec4 = EC::factory()->create(['ue_id' => $ue2->id, 'coefficient' => 3]);

    $ec5 = EC::factory()->create(['ue_id' => $ue3->id, 'coefficient' => 2]);
    $ec6 = EC::factory()->create(['ue_id' => $ue3->id, 'coefficient' => 3]);

    // Ajout des notes pour chaque EC
    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec1->id,
        'note' => 12,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec2->id,
        'note' => 14,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec3->id,
        'note' => 15,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec4->id,
        'note' => 8,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec5->id,
        'note' => 15,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    $this->post('/notes', [
        'etudiant_id' => $etudiant->id,
        'ec_id' => $ec6->id,
        'note' => 13,
        'session' => 'normale',
        'date_evaluation' => '2025-01-01',
    ]);

    // Récupération des résultats
    $resultats = $this->get("/etudiant/{$etudiant->id}/resultats");
    $resultats->assertStatus(200);

    $resultatAnnee = $resultats->viewData('passeDansAnneeSuivante');

// Verification du passage a lannee superieur 
    $this->assertTrue($resultatAnnee); 

    
    

}



}
