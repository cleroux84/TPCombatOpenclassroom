<?php
class PersonnagesManager
{
  private $_db; // Instance de PDO
  
  public function __construct($db)
  {
    $this->setDb($db);
  }
  
  public function add($perso)
  {
    $q = $this->_db->prepare('INSERT INTO personnages(nom, type) VALUES(:nom, :type)');
    $q->bindValue(':nom', $perso->nom());
    $q->bindValue(':type', $perso->type());
    $q->execute();
    
    $perso->hydrate([
      'id' => $this->_db->lastInsertId(),
      'degats' => 0,
      'levels'=> 0,
      'experience'=> 0,
      'strength'=> 0,
            
    ]);
  }
  
  public function count()
  {
    return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
  }
  
  public function delete(Personnage $perso)
  {
    $this->_db->exec('DELETE FROM personnages WHERE id = '.$perso->id());
  }
  
  public function exists($info)
  {
    if (is_int($info)) // On veut voir si tel personnage ayant pour id $info existe.
    {
      return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = '.$info)->fetchColumn();
    }
    
    // Sinon, c'est qu'on veut vérifier que le nom existe ou pas.
    
    $q = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
    $q->execute([':nom' => $info]);
    
    return (bool) $q->fetchColumn();
  }
  
  public function get($info)
  {
    if (is_int($info))
    {
      $q = $this->_db->query('SELECT * FROM personnages WHERE id = '.$info);
      $perso = $q->fetch(PDO::FETCH_ASSOC);
      
      
    }
    else
    {
      $q = $this->_db->prepare('SELECT * FROM personnages WHERE nom = :nom');
      $q->execute([':nom' => $info]);
    
      $perso = $q->fetch(PDO::FETCH_ASSOC);
    }
    switch ($perso['type'])

    {

      case 'guerrier': return new Guerrier($perso);
      case 'magicien': return new Magicien($perso);
      case 'archer': return new Archer($perso);


      default: return null;

    }

  }
  public function getList($nom)
  {
    $persos = [];
    
    $q = $this->_db->prepare('SELECT * FROM personnages WHERE nom <> :nom ORDER BY nom');
    $q->execute([':nom' => $nom]);
    
    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {

      switch ($donnees['type'])

      {

        case 'guerrier': $persos[] = new Guerrier($donnees); break;
        case 'magicien': $persos[] = new Magicien($donnees); break;
        case 'archer': $persos[] = new Archer($donnees); break;

      }

    }
    
    return $persos;
  }

  
  public function update(Personnage $perso, $strength = 0)
  {
    if($perso->experience() >= 100)
    {
      $perso->setExperience(0);
      $perso->setLevels(1);
      $perso->setStrength($perso->levels());
    }
    $q = $this->_db->prepare('UPDATE personnages SET degats = :degats, experience= :experience, levels = :levels, 
                            strength = :strength WHERE id = :id');
    
    $q->bindValue(':degats', $perso->degats() + $strength, PDO::PARAM_INT); // j'ajoute la force aux dégats
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);
    $q->bindValue(':levels', $perso->levels(), PDO::PARAM_INT);
    $q->bindValue(':strength', $perso->strength(), PDO::PARAM_INT);
    $q->bindValue(':experience', $perso->experience(), PDO::PARAM_INT);

    
    $q->execute();
  }
  
  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}