<?php

include 'config/autoload.php';
include 'config/db.php';
include 'combat.php';

?>
<!DOCTYPE html>
<html>
  <head>
    <title>TP : Mini jeu de combat</title>
    
    <meta charset="utf-8" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body>
    <p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
if (isset($message)) // On a un message à afficher ?
{
  echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
}

if (isset($perso)) // Si on utilise un personnage (nouveau ou pas).
{
?>

 <div class="container">  
   <div class="row justify-content-center align-items-center">
     <div class="col-4">

      
    
    <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
    
      <div class="card-header"><h3><?= htmlspecialchars($perso->nom()) ?> <br> <?= ucfirst($perso->type()) ?></div></h3>
        <div class="card-body">
         <p class="card-text"> Dégâts : <?= $perso->degats() ?>
            - Level : <?= $perso->levels() ?><br/>
            Experience : <?= $perso->experience() ?>
            - Force : <?= $perso->strength() ?></p>
      </div>
      <button type="button" class="btn btn-light"><a href="?deconnexion=1">Déconnexion</button></a>
  </div>
</div>
  
    
    <fieldset>
      <legend>Qui frapper ?</legend>
      <p>
<?php
$persos = $manager->getList($perso->nom());

if (empty($persos))
{
  echo 'Personne à frapper !';
}

else
{
echo'<div class="col">';
  foreach ($persos as $unPerso)
  {


    if($unPerso->type() === "magicien"){

      $backgroundColor = "bg-magicien";
      $images = "src='images/magicien.jpg'";
  }
  else if($unPerso->type() === "guerrier")
  { $backgroundColor = "bg-guerrier";
    $images = "src='images/guerrier.jpg'";

  }
  else if($unPerso->type() === "archer")
  {
    $backgroundColor = "bg-archer";
    $images = "src='images/archer.jpg'"
   ;
  }

  echo '<div class="card text-white '.$backgroundColor.' mb-3" style="max-width: 18rem;">
  <div class="card-header"><img class="" '.$images.' alt="Photo de magicien" /></div>
  <div class="card-body">
  <button type="button" class="btn btn-dark mb-2"><a href="?frapper=', $unPerso->id(), '">', htmlspecialchars($unPerso->nom()).'</a></button>
  <h5 class="type_card card-subtitle mb-2 text-muted">', ucfirst($unPerso->type()).'</h5>
  <p class="card-text">experience : ', $unPerso->experience(),' - niveau : ', $unPerso->levels(),'<br> 
  force : ', $unPerso->strength(), '<br>
  dégats : ', $unPerso->degats(), '</p>
  </div>
  </div>
 ';
}
}

?>


      </p>
    </fieldset>
<?php
}
else
{
?>
    <form action="" method="post">
      <p>
        Nom : <input type="text" name="nom" maxlength="50" />

        Type :

        <select name="type">
          <option value="magicien">Magicien</option>
          <option value="guerrier">Guerrier</option>
          <option value="archer">Archer</option>

        </select>

        <input type="submit" value="Créer ce personnage" name="creer" />
        <input type="submit" value="Utiliser ce personnage" name="utiliser" />
      </p>
    </form>
<?php
}
?>
  </body>
</html>
<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
{
  $_SESSION['perso'] = $perso;
}