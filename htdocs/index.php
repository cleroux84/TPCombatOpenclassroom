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
   
    <button type="button" class="btn btn-dark"><a href="?deconnexion=1">Déconnexion</button></a>
    
    <fieldset>
      <legend>Mes informations</legend>
      <p>
        Nom : <?= htmlspecialchars($perso->nom()) ?><br />
        Type : <?= ucfirst($perso->type()) ?><br />
        Dégâts : <?= $perso->degats() ?>
        - Level : <?= $perso->levels() ?><br/>
        Experience : <?= $perso->experience() ?>
        - Force : <?= $perso->strength() ?>
      </p>
    </fieldset>
    
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

  foreach ($persos as $unPerso)
  {
    echo '<div class="card" style="width: 15rem;">
  <div class="card-body">
    <h5 class="card-title"><a href="?frapper=', $unPerso->id(), '">', htmlspecialchars($unPerso->nom()).'</a></h5>
    <h6 class="card-subtitle mb-2 text-muted">', $unPerso->type().'</h6>
    <p class="card-text">experience : ', $unPerso->experience(), '</p>
    <p class="card-text">niveau : ', $unPerso->levels(), '</p>
    <p class="card-text">dégats : ', $unPerso->degats(), '</p>
  </div>
</div>';
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