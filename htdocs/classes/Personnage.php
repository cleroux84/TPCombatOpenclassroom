<?php
abstract class Personnage
{
  protected $_degats,
          $_id,
          $_nom,
          $_levels,
          $_experience,
          $_strength,
          $type;
  
  const CEST_MOI = 1; // Constante renvoyée par la méthode `frapper` si on se frappe soi-même.
  const PERSONNAGE_TUE = 2; // Constante renvoyée par la méthode `frapper` si on a tué le personnage en le frappant.
  const PERSONNAGE_FRAPPE = 3; // Constante renvoyée par la méthode `frapper` si on a bien frappé le personnage.
  
 
  
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
    $this->type = strtolower(static::class);
  }
  
  public function frapper(Personnage $perso)
  {
    if ($perso->id() == $this->_id)
    {
      return self::CEST_MOI;
    }
    // On indique au personnage qu'il doit recevoir des dégâts.
    // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE
    else 
      {
/*       $force = $this->strength();  
 */      $this->_experience += 25;  
         return $perso->recevoirDegats($this->type());  
        
    }
  }
  
  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }

  public function nomValide()
  {
    return !empty($this->_nom);
  }
  
  public function recevoirDegats($persoQuiFrappeType)
  {
    $this->_degats += 5;
    
    // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
    if ($this->_degats >= 100)
    {
      return self::PERSONNAGE_TUE;
    }
    
    // Sinon, on se contente de dire que le personnage a bien été frappé.
    return self::PERSONNAGE_FRAPPE;
   
  }

 
  
  
  // GETTERS //

  public function type()
  {
    return $this->type;
  }

  public function experience()
  {
    return $this->_experience;
  }

  public function strength()
  {
    return $this->_strength;
  }
  
  public function levels()
  {
    return $this->_levels;
  }

  public function degats()
  {
    return $this->_degats;
  }
  
  public function id()
  {
    return $this->_id;
  }
  
  public function nom()
  {
    return $this->_nom;
  }

  public function setStrength($strength)
  {
      
      $this->_strength = $strength;
  
  }

  public function setExperience($experience)
  {

    
      $this->_experience = $experience;
    
  }

  public function setLevels($levels)
  {
    
      $this->_levels += $levels;
    
  }
  
  public function setDegats($degats)
  {
    $degats = (int) $degats;
    
    if ($degats >= 0 && $degats <= 100)
    {
      $this->_degats = $degats;
    }
  }
  
  public function setId($id)
  {
    $id = (int) $id;
    
    if ($id > 0)
    {
      $this->_id = $id;
    }
  }
  
  public function setNom($nom)
  {
    if (is_string($nom))
    {
      $this->_nom = $nom;
    }
  }
}
