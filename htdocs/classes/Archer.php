<?php
class Archer extends Personnage
{
  public function recevoirDegats($persoQuiFrappeType)
  {

    if($persoQuiFrappeType === "magicien"){
    $this->_degats += 10;
    }
    else{
    $this->_degats += 5;

    }
    // Si on a 100 de dégâts ou plus, on dit que le personnage a été tué.
    if ($this->_degats >= 100)
    {
      return self::PERSONNAGE_TUE;
    }
    
    // Sinon, on se contente de dire que le personnage a bien été frappé.
    return self::PERSONNAGE_FRAPPE;
   
  }

  }


