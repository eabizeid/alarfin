<?php
namespace Kells\Bundle\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="configuration") 
 */
class AlarfinConfiguration {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $anio0km;
    
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $email1;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $email2;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $email3;
    
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmtasa;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmtea;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5tasa;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5tea;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10tasa; 
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10tea;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15tasa;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15tea;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas2; 
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas4;
	/**
     * @ORM\Column(type="string", length=60)
     */
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas6;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas8;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas10;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas12;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas14;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas16;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas18;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas20;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas22;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas24;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas26;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas28;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas30;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas32;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas34;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas36;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas38;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas40;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas42;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas44;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas46;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $cerokmCuotas48;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas2;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas4;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas6;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas8;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas10;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas12;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas14;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas16;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas18;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas20;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas22;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas24;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas26;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas28;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas30;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas32;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas34;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas36;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas38;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas40;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas42;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas44;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas46;
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $unoA5Cuotas48;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas2;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas4;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas6;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas8;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas10;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas12;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas14;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas16;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas18;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas20;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas22;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas24;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas26;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas28;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas30;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas32;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas34;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $seisA10Cuotas36;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas2;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas4;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas6;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas8;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas10;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas12;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas14;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas16;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas18;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas20;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas22;
	/**
     * @ORM\Column(type="string", length=60)
     */
    protected $onceA15Cuotas24;
    
    /**
     * @ORM\Column(type="string", length=60)
     */
    protected $impuestos;
    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email1
     *
     * @param string $email1
     * @return Configuration
     */
    public function setEmail1($email1)
    {
        $this->email1 = $email1;

        return $this;
    }

    /**
     * Get email1
     *
     * @return string 
     */
    public function getEmail1()
    {
        return $this->email1;
    }

    /**
     * Set email2
     *
     * @param string $email2
     * @return Configuration
     */
    public function setEmail2($email2)
    {
        $this->email2 = $email2;

        return $this;
    }

    /**
     * Get email2
     *
     * @return string 
     */
    public function getEmail2()
    {
        return $this->email2;
    }

    /**
     * Set email3
     *
     * @param string $email3
     * @return Configuration
     */
    public function setEmail3($email3)
    {
        $this->email3 = $email3;

        return $this;
    }

    /**
     * Get email3
     *
     * @return string 
     */
    public function getEmail3()
    {
        return $this->email3;
    }

    /**
     * Set cerokmtasa
     *
     * @param string $cerokmtasa
     * @return Configuration
     */
    public function setCerokmtasa($cerokmtasa)
    {
        $this->cerokmtasa = $cerokmtasa;

        return $this;
    }

    /**
     * Get cerokmtasa
     *
     * @return string 
     */
    public function getCerokmtasa()
    {
        return $this->cerokmtasa;
    }

    /**
     * Set cerokmtea
     *
     * @param string $cerokmtea
     * @return Configuration
     */
    public function setCerokmtea($cerokmtea)
    {
        $this->cerokmtea = $cerokmtea;

        return $this;
    }

    /**
     * Get cerokmtea
     *
     * @return string 
     */
    public function getCerokmtea()
    {
        return $this->cerokmtea;
    }

    /**
     * Set unoA5tasa
     *
     * @param string $unoA5tasa
     * @return Configuration
     */
    public function setUnoA5tasa($unoA5tasa)
    {
        $this->unoA5tasa = $unoA5tasa;

        return $this;
    }

    /**
     * Get unoA5tasa
     *
     * @return string 
     */
    public function getUnoA5tasa()
    {
        return $this->unoA5tasa;
    }

    /**
     * Set unoA5tea
     *
     * @param string $unoA5tea
     * @return Configuration
     */
    public function setUnoA5tea($unoA5tea)
    {
        $this->unoA5tea = $unoA5tea;

        return $this;
    }

    /**
     * Get unoA5tea
     *
     * @return string 
     */
    public function getUnoA5tea()
    {
        return $this->unoA5tea;
    }

    /**
     * Set seisA10tasa
     *
     * @param string $seisA10tasa
     * @return Configuration
     */
    public function setSeisA10tasa($seisA10tasa)
    {
        $this->seisA10tasa = $seisA10tasa;

        return $this;
    }

    /**
     * Get seisA10tasa
     *
     * @return string 
     */
    public function getSeisA10tasa()
    {
        return $this->seisA10tasa;
    }

    /**
     * Set seisA10tea
     *
     * @param string $seisA10tea
     * @return Configuration
     */
    public function setSeisA10tea($seisA10tea)
    {
        $this->seisA10tea = $seisA10tea;

        return $this;
    }

    /**
     * Get seisA10tea
     *
     * @return string 
     */
    public function getSeisA10tea()
    {
        return $this->seisA10tea;
    }

    /**
     * Set onceA15tasa
     *
     * @param string $onceA15tasa
     * @return Configuration
     */
    public function setOnceA15tasa($onceA15tasa)
    {
        $this->onceA15tasa = $onceA15tasa;

        return $this;
    }

    /**
     * Get onceA15tasa
     *
     * @return string 
     */
    public function getOnceA15tasa()
    {
        return $this->onceA15tasa;
    }

    /**
     * Set onceA15tea
     *
     * @param string $onceA15tea
     * @return Configuration
     */
    public function setOnceA15tea($onceA15tea)
    {
        $this->onceA15tea = $onceA15tea;

        return $this;
    }

    /**
     * Get onceA15tea
     *
     * @return string 
     */
    public function getOnceA15tea()
    {
        return $this->onceA15tea;
    }

    /**
     * Set cerokmCuotas2
     *
     * @param string $cerokmCuotas2
     * @return Configuration
     */
    public function setCerokmCuotas2($cerokmCuotas2)
    {
        $this->cerokmCuotas2 = $cerokmCuotas2;

        return $this;
    }

    /**
     * Get cerokmCuotas2
     *
     * @return string 
     */
    public function getCerokmCuotas2()
    {
        return $this->cerokmCuotas2;
    }

    /**
     * Set cerokmCuotas4
     *
     * @param string $cerokmCuotas4
     * @return Configuration
     */
    public function setCerokmCuotas4($cerokmCuotas4)
    {
        $this->cerokmCuotas4 = $cerokmCuotas4;

        return $this;
    }

    /**
     * Get cerokmCuotas4
     *
     * @return string 
     */
    public function getCerokmCuotas4()
    {
        return $this->cerokmCuotas4;
    }

    /**
     * Set cerokmCuotas6
     *
     * @param string $cerokmCuotas6
     * @return Configuration
     */
    public function setCerokmCuotas6($cerokmCuotas6)
    {
        $this->cerokmCuotas6 = $cerokmCuotas6;

        return $this;
    }

    /**
     * Get cerokmCuotas6
     *
     * @return string 
     */
    public function getCerokmCuotas6()
    {
        return $this->cerokmCuotas6;
    }

    /**
     * Set cerokmCuotas8
     *
     * @param string $cerokmCuotas8
     * @return Configuration
     */
    public function setCerokmCuotas8($cerokmCuotas8)
    {
        $this->cerokmCuotas8 = $cerokmCuotas8;

        return $this;
    }

    /**
     * Get cerokmCuotas8
     *
     * @return string 
     */
    public function getCerokmCuotas8()
    {
        return $this->cerokmCuotas8;
    }

    /**
     * Set cerokmCuotas10
     *
     * @param string $cerokmCuotas10
     * @return Configuration
     */
    public function setCerokmCuotas10($cerokmCuotas10)
    {
        $this->cerokmCuotas10 = $cerokmCuotas10;

        return $this;
    }

    /**
     * Get cerokmCuotas10
     *
     * @return string 
     */
    public function getCerokmCuotas10()
    {
        return $this->cerokmCuotas10;
    }

    /**
     * Set cerokmCuotas12
     *
     * @param string $cerokmCuotas12
     * @return Configuration
     */
    public function setCerokmCuotas12($cerokmCuotas12)
    {
        $this->cerokmCuotas12 = $cerokmCuotas12;

        return $this;
    }

    /**
     * Get cerokmCuotas12
     *
     * @return string 
     */
    public function getCerokmCuotas12()
    {
        return $this->cerokmCuotas12;
    }

    /**
     * Set cerokmCuotas14
     *
     * @param string $cerokmCuotas14
     * @return Configuration
     */
    public function setCerokmCuotas14($cerokmCuotas14)
    {
        $this->cerokmCuotas14 = $cerokmCuotas14;

        return $this;
    }

    /**
     * Get cerokmCuotas14
     *
     * @return string 
     */
    public function getCerokmCuotas14()
    {
        return $this->cerokmCuotas14;
    }

    /**
     * Set cerokmCuotas16
     *
     * @param string $cerokmCuotas16
     * @return Configuration
     */
    public function setCerokmCuotas16($cerokmCuotas16)
    {
        $this->cerokmCuotas16 = $cerokmCuotas16;

        return $this;
    }

    /**
     * Get cerokmCuotas16
     *
     * @return string 
     */
    public function getCerokmCuotas16()
    {
        return $this->cerokmCuotas16;
    }

    /**
     * Set cerokmCuotas18
     *
     * @param string $cerokmCuotas18
     * @return Configuration
     */
    public function setCerokmCuotas18($cerokmCuotas18)
    {
        $this->cerokmCuotas18 = $cerokmCuotas18;

        return $this;
    }

    /**
     * Get cerokmCuotas18
     *
     * @return string 
     */
    public function getCerokmCuotas18()
    {
        return $this->cerokmCuotas18;
    }

    /**
     * Set cerokmCuotas20
     *
     * @param string $cerokmCuotas20
     * @return Configuration
     */
    public function setCerokmCuotas20($cerokmCuotas20)
    {
        $this->cerokmCuotas20 = $cerokmCuotas20;

        return $this;
    }

    /**
     * Get cerokmCuotas20
     *
     * @return string 
     */
    public function getCerokmCuotas20()
    {
        return $this->cerokmCuotas20;
    }

    /**
     * Set cerokmCuotas22
     *
     * @param string $cerokmCuotas22
     * @return Configuration
     */
    public function setCerokmCuotas22($cerokmCuotas22)
    {
        $this->cerokmCuotas22 = $cerokmCuotas22;

        return $this;
    }

    /**
     * Get cerokmCuotas22
     *
     * @return string 
     */
    public function getCerokmCuotas22()
    {
        return $this->cerokmCuotas22;
    }

    /**
     * Set cerokmCuotas24
     *
     * @param string $cerokmCuotas24
     * @return Configuration
     */
    public function setCerokmCuotas24($cerokmCuotas24)
    {
        $this->cerokmCuotas24 = $cerokmCuotas24;

        return $this;
    }

    /**
     * Get cerokmCuotas24
     *
     * @return string 
     */
    public function getCerokmCuotas24()
    {
        return $this->cerokmCuotas24;
    }

    /**
     * Set cerokmCuotas26
     *
     * @param string $cerokmCuotas26
     * @return Configuration
     */
    public function setCerokmCuotas26($cerokmCuotas26)
    {
        $this->cerokmCuotas26 = $cerokmCuotas26;

        return $this;
    }

    /**
     * Get cerokmCuotas26
     *
     * @return string 
     */
    public function getCerokmCuotas26()
    {
        return $this->cerokmCuotas26;
    }

    /**
     * Set cerokmCuotas28
     *
     * @param string $cerokmCuotas28
     * @return Configuration
     */
    public function setCerokmCuotas28($cerokmCuotas28)
    {
        $this->cerokmCuotas28 = $cerokmCuotas28;

        return $this;
    }

    /**
     * Get cerokmCuotas28
     *
     * @return string 
     */
    public function getCerokmCuotas28()
    {
        return $this->cerokmCuotas28;
    }

    /**
     * Set cerokmCuotas30
     *
     * @param string $cerokmCuotas30
     * @return Configuration
     */
    public function setCerokmCuotas30($cerokmCuotas30)
    {
        $this->cerokmCuotas30 = $cerokmCuotas30;

        return $this;
    }

    /**
     * Get cerokmCuotas30
     *
     * @return string 
     */
    public function getCerokmCuotas30()
    {
        return $this->cerokmCuotas30;
    }

    /**
     * Set cerokmCuotas32
     *
     * @param string $cerokmCuotas32
     * @return Configuration
     */
    public function setCerokmCuotas32($cerokmCuotas32)
    {
        $this->cerokmCuotas32 = $cerokmCuotas32;

        return $this;
    }

    /**
     * Get cerokmCuotas32
     *
     * @return string 
     */
    public function getCerokmCuotas32()
    {
        return $this->cerokmCuotas32;
    }

    /**
     * Set cerokmCuotas34
     *
     * @param string $cerokmCuotas34
     * @return Configuration
     */
    public function setCerokmCuotas34($cerokmCuotas34)
    {
        $this->cerokmCuotas34 = $cerokmCuotas34;

        return $this;
    }

    /**
     * Get cerokmCuotas34
     *
     * @return string 
     */
    public function getCerokmCuotas34()
    {
        return $this->cerokmCuotas34;
    }

    /**
     * Set cerokmCuotas36
     *
     * @param string $cerokmCuotas36
     * @return Configuration
     */
    public function setCerokmCuotas36($cerokmCuotas36)
    {
        $this->cerokmCuotas36 = $cerokmCuotas36;

        return $this;
    }
public function setCerokmCuotas38($cerokmCuotas38)
    {
        $this->cerokmCuotas38 = $cerokmCuotas38;

        return $this;
    }
public function setCerokmCuotas40($cerokmCuotas40)
    {
        $this->cerokmCuotas40 = $cerokmCuotas40;

        return $this;
    }
public function setCerokmCuotas42($cerokmCuotas42)
    {
        $this->cerokmCuotas42 = $cerokmCuotas42;

        return $this;
    }
public function setCerokmCuotas44($cerokmCuotas44)
    {
        $this->cerokmCuotas44 = $cerokmCuotas44;

        return $this;
    }
public function setCerokmCuotas48($cerokmCuotas48)
    {
        $this->cerokmCuotas48 = $cerokmCuotas48;

        return $this;
    }

    /**
     * Get cerokmCuotas36
     *
     * @return string 
     */
    public function getCerokmCuotas36()
    {
        return $this->cerokmCuotas36;
    }
    
 	public function getCerokmCuotas38()
    {
        return $this->cerokmCuotas38;
    }
 	public function getCerokmCuotas40()
    {
        return $this->cerokmCuotas40;
    }
 public function getCerokmCuotas42()
    {
        return $this->cerokmCuotas42;
    }
 public function getCerokmCuotas44()
    {
        return $this->cerokmCuotas44;
    }
 public function getCerokmCuotas46()
    {
        return $this->cerokmCuotas46;
    }
 public function getCerokmCuotas48()
    {
        return $this->cerokmCuotas48;
    }
    

    /**
     * Set unoA5Cuotas2
     *
     * @param string $unoA5Cuotas2
     * @return Configuration
     */
    public function setUnoA5Cuotas2($unoA5Cuotas2)
    {
        $this->unoA5Cuotas2 = $unoA5Cuotas2;

        return $this;
    }

    /**
     * Get unoA5Cuotas2
     *
     * @return string 
     */
    public function getUnoA5Cuotas2()
    {
        return $this->unoA5Cuotas2;
    }

    /**
     * Set unoA5Cuotas4
     *
     * @param string $unoA5Cuotas4
     * @return Configuration
     */
    public function setUnoA5Cuotas4($unoA5Cuotas4)
    {
        $this->unoA5Cuotas4 = $unoA5Cuotas4;

        return $this;
    }

    /**
     * Get unoA5Cuotas4
     *
     * @return string 
     */
    public function getUnoA5Cuotas4()
    {
        return $this->unoA5Cuotas4;
    }

    /**
     * Set unoA5Cuotas6
     *
     * @param string $unoA5Cuotas6
     * @return Configuration
     */
    public function setUnoA5Cuotas6($unoA5Cuotas6)
    {
        $this->unoA5Cuotas6 = $unoA5Cuotas6;

        return $this;
    }

    /**
     * Get unoA5Cuotas6
     *
     * @return string 
     */
    public function getUnoA5Cuotas6()
    {
        return $this->unoA5Cuotas6;
    }

    /**
     * Set unoA5Cuotas8
     *
     * @param string $unoA5Cuotas8
     * @return Configuration
     */
    public function setUnoA5Cuotas8($unoA5Cuotas8)
    {
        $this->unoA5Cuotas8 = $unoA5Cuotas8;

        return $this;
    }

    /**
     * Get unoA5Cuotas8
     *
     * @return string 
     */
    public function getUnoA5Cuotas8()
    {
        return $this->unoA5Cuotas8;
    }

    /**
     * Set unoA5Cuotas10
     *
     * @param string $unoA5Cuotas10
     * @return Configuration
     */
    public function setUnoA5Cuotas10($unoA5Cuotas10)
    {
        $this->unoA5Cuotas10 = $unoA5Cuotas10;

        return $this;
    }

    /**
     * Get unoA5Cuotas10
     *
     * @return string 
     */
    public function getUnoA5Cuotas10()
    {
        return $this->unoA5Cuotas10;
    }

    /**
     * Set unoA5Cuotas12
     *
     * @param string $unoA5Cuotas12
     * @return Configuration
     */
    public function setUnoA5Cuotas12($unoA5Cuotas12)
    {
        $this->unoA5Cuotas12 = $unoA5Cuotas12;

        return $this;
    }

    /**
     * Get unoA5Cuotas12
     *
     * @return string 
     */
    public function getUnoA5Cuotas12()
    {
        return $this->unoA5Cuotas12;
    }

    /**
     * Set unoA5Cuotas14
     *
     * @param string $unoA5Cuotas14
     * @return Configuration
     */
    public function setUnoA5Cuotas14($unoA5Cuotas14)
    {
        $this->unoA5Cuotas14 = $unoA5Cuotas14;

        return $this;
    }

    /**
     * Get unoA5Cuotas14
     *
     * @return string 
     */
    public function getUnoA5Cuotas14()
    {
        return $this->unoA5Cuotas14;
    }

    /**
     * Set unoA5Cuotas16
     *
     * @param string $unoA5Cuotas16
     * @return Configuration
     */
    public function setUnoA5Cuotas16($unoA5Cuotas16)
    {
        $this->unoA5Cuotas16 = $unoA5Cuotas16;

        return $this;
    }

    /**
     * Get unoA5Cuotas16
     *
     * @return string 
     */
    public function getUnoA5Cuotas16()
    {
        return $this->unoA5Cuotas16;
    }

    /**
     * Set unoA5Cuotas18
     *
     * @param string $unoA5Cuotas18
     * @return Configuration
     */
    public function setUnoA5Cuotas18($unoA5Cuotas18)
    {
        $this->unoA5Cuotas18 = $unoA5Cuotas18;

        return $this;
    }

    /**
     * Get unoA5Cuotas18
     *
     * @return string 
     */
    public function getUnoA5Cuotas18()
    {
        return $this->unoA5Cuotas18;
    }

    /**
     * Set unoA5Cuotas20
     *
     * @param string $unoA5Cuotas20
     * @return Configuration
     */
    public function setUnoA5Cuotas20($unoA5Cuotas20)
    {
        $this->unoA5Cuotas20 = $unoA5Cuotas20;

        return $this;
    }

    /**
     * Get unoA5Cuotas20
     *
     * @return string 
     */
    public function getUnoA5Cuotas20()
    {
        return $this->unoA5Cuotas20;
    }

    /**
     * Set unoA5Cuotas22
     *
     * @param string $unoA5Cuotas22
     * @return Configuration
     */
    public function setUnoA5Cuotas22($unoA5Cuotas22)
    {
        $this->unoA5Cuotas22 = $unoA5Cuotas22;

        return $this;
    }

    /**
     * Get unoA5Cuotas22
     *
     * @return string 
     */
    public function getUnoA5Cuotas22()
    {
        return $this->unoA5Cuotas22;
    }

    /**
     * Set unoA5Cuotas24
     *
     * @param string $unoA5Cuotas24
     * @return Configuration
     */
    public function setUnoA5Cuotas24($unoA5Cuotas24)
    {
        $this->unoA5Cuotas24 = $unoA5Cuotas24;

        return $this;
    }

    /**
     * Get unoA5Cuotas24
     *
     * @return string 
     */
    public function getUnoA5Cuotas24()
    {
        return $this->unoA5Cuotas24;
    }

    /**
     * Set unoA5Cuotas26
     *
     * @param string $unoA5Cuotas26
     * @return Configuration
     */
    public function setUnoA5Cuotas26($unoA5Cuotas26)
    {
        $this->unoA5Cuotas26 = $unoA5Cuotas26;

        return $this;
    }

    /**
     * Get unoA5Cuotas26
     *
     * @return string 
     */
    public function getUnoA5Cuotas26()
    {
        return $this->unoA5Cuotas26;
    }

    /**
     * Set unoA5Cuotas28
     *
     * @param string $unoA5Cuotas28
     * @return Configuration
     */
    public function setUnoA5Cuotas28($unoA5Cuotas28)
    {
        $this->unoA5Cuotas28 = $unoA5Cuotas28;

        return $this;
    }

    /**
     * Get unoA5Cuotas28
     *
     * @return string 
     */
    public function getUnoA5Cuotas28()
    {
        return $this->unoA5Cuotas28;
    }

    /**
     * Set unoA5Cuotas30
     *
     * @param string $unoA5Cuotas30
     * @return Configuration
     */
    public function setUnoA5Cuotas30($unoA5Cuotas30)
    {
        $this->unoA5Cuotas30 = $unoA5Cuotas30;

        return $this;
    }

    /**
     * Get unoA5Cuotas30
     *
     * @return string 
     */
    public function getUnoA5Cuotas30()
    {
        return $this->unoA5Cuotas30;
    }

    /**
     * Set unoA5Cuotas32
     *
     * @param string $unoA5Cuotas32
     * @return Configuration
     */
    public function setUnoA5Cuotas32($unoA5Cuotas32)
    {
        $this->unoA5Cuotas32 = $unoA5Cuotas32;

        return $this;
    }

    /**
     * Get unoA5Cuotas32
     *
     * @return string 
     */
    public function getUnoA5Cuotas32()
    {
        return $this->unoA5Cuotas32;
    }

    /**
     * Set unoA5Cuotas34
     *
     * @param string $unoA5Cuotas34
     * @return Configuration
     */
    public function setUnoA5Cuotas34($unoA5Cuotas34)
    {
        $this->unoA5Cuotas34 = $unoA5Cuotas34;

        return $this;
    }

    /**
     * Get unoA5Cuotas34
     *
     * @return string 
     */
    public function getUnoA5Cuotas34()
    {
        return $this->unoA5Cuotas34;
    }

    /**
     * Set unoA5Cuotas36
     *
     * @param string $unoA5Cuotas36
     * @return Configuration
     */
    public function setUnoA5Cuotas36($unoA5Cuotas36)
    {
        $this->unoA5Cuotas36 = $unoA5Cuotas36;

        return $this;
    }
    
  public function setUnoA5Cuotas38($unoA5Cuotas38)
    {
        $this->unoA5Cuotas38 = $unoA5Cuotas38;

        return $this;
    }
  public function setUnoA5Cuotas40($unoA5Cuotas40)
    {
        $this->unoA5Cuotas40 = $unoA5Cuotas40;

        return $this;
    }
  public function setUnoA5Cuotas42($unoA5Cuotas42)
    {
        $this->unoA5Cuotas42 = $unoA5Cuotas42;

        return $this;
    }
  public function setUnoA5Cuotas44($unoA5Cuotas44)
    {
        $this->unoA5Cuotas44 = $unoA5Cuotas44;

        return $this;
    }
  public function setUnoA5Cuotas48($unoA5Cuotas48)
    {
        $this->unoA5Cuotas48 = $unoA5Cuotas48;

        return $this;
    }

    /**
     * Get unoA5Cuotas36
     *
     * @return string 
     */
    public function getUnoA5Cuotas36()
    {
        return $this->unoA5Cuotas36;
    }
 public function getUnoA5Cuotas38()
    {
        return $this->unoA5Cuotas38;
    }
 public function getUnoA5Cuotas40()
    {
        return $this->unoA5Cuotas40;
    }
 public function getUnoA5Cuotas42()
    {
        return $this->unoA5Cuotas42;
    }
 public function getUnoA5Cuotas44()
    {
        return $this->unoA5Cuotas44;
    }
 public function getUnoA5Cuotas46()
    {
        return $this->unoA5Cuotas46;
    }
 public function getUnoA5Cuotas48()
    {
        return $this->unoA5Cuotas48;
    }

    /**
     * Set seisA10Cuotas2
     *
     * @param string $seisA10Cuotas2
     * @return Configuration
     */
    public function setSeisA10Cuotas2($seisA10Cuotas2)
    {
        $this->seisA10Cuotas2 = $seisA10Cuotas2;

        return $this;
    }

    /**
     * Get seisA10Cuotas2
     *
     * @return string 
     */
    public function getSeisA10Cuotas2()
    {
        return $this->seisA10Cuotas2;
    }

    /**
     * Set seisA10Cuotas4
     *
     * @param string $seisA10Cuotas4
     * @return Configuration
     */
    public function setSeisA10Cuotas4($seisA10Cuotas4)
    {
        $this->seisA10Cuotas4 = $seisA10Cuotas4;

        return $this;
    }

    /**
     * Get seisA10Cuotas4
     *
     * @return string 
     */
    public function getSeisA10Cuotas4()
    {
        return $this->seisA10Cuotas4;
    }

    /**
     * Set seisA10Cuotas6
     *
     * @param string $seisA10Cuotas6
     * @return Configuration
     */
    public function setSeisA10Cuotas6($seisA10Cuotas6)
    {
        $this->seisA10Cuotas6 = $seisA10Cuotas6;

        return $this;
    }

    /**
     * Get seisA10Cuotas6
     *
     * @return string 
     */
    public function getSeisA10Cuotas6()
    {
        return $this->seisA10Cuotas6;
    }

    /**
     * Set seisA10Cuotas8
     *
     * @param string $seisA10Cuotas8
     * @return Configuration
     */
    public function setSeisA10Cuotas8($seisA10Cuotas8)
    {
        $this->seisA10Cuotas8 = $seisA10Cuotas8;

        return $this;
    }

    /**
     * Get seisA10Cuotas8
     *
     * @return string 
     */
    public function getSeisA10Cuotas8()
    {
        return $this->seisA10Cuotas8;
    }

    /**
     * Set seisA10Cuotas10
     *
     * @param string $seisA10Cuotas10
     * @return Configuration
     */
    public function setSeisA10Cuotas10($seisA10Cuotas10)
    {
        $this->seisA10Cuotas10 = $seisA10Cuotas10;

        return $this;
    }

    /**
     * Get seisA10Cuotas10
     *
     * @return string 
     */
    public function getSeisA10Cuotas10()
    {
        return $this->seisA10Cuotas10;
    }

    /**
     * Set seisA10Cuotas12
     *
     * @param string $seisA10Cuotas12
     * @return Configuration
     */
    public function setSeisA10Cuotas12($seisA10Cuotas12)
    {
        $this->seisA10Cuotas12 = $seisA10Cuotas12;

        return $this;
    }

    /**
     * Get seisA10Cuotas12
     *
     * @return string 
     */
    public function getSeisA10Cuotas12()
    {
        return $this->seisA10Cuotas12;
    }

    /**
     * Set seisA10Cuotas14
     *
     * @param string $seisA10Cuotas14
     * @return Configuration
     */
    public function setSeisA10Cuotas14($seisA10Cuotas14)
    {
        $this->seisA10Cuotas14 = $seisA10Cuotas14;

        return $this;
    }

    /**
     * Get seisA10Cuotas14
     *
     * @return string 
     */
    public function getSeisA10Cuotas14()
    {
        return $this->seisA10Cuotas14;
    }

    /**
     * Set seisA10Cuotas16
     *
     * @param string $seisA10Cuotas16
     * @return Configuration
     */
    public function setSeisA10Cuotas16($seisA10Cuotas16)
    {
        $this->seisA10Cuotas16 = $seisA10Cuotas16;

        return $this;
    }

    /**
     * Get seisA10Cuotas16
     *
     * @return string 
     */
    public function getSeisA10Cuotas16()
    {
        return $this->seisA10Cuotas16;
    }

    /**
     * Set seisA10Cuotas18
     *
     * @param string $seisA10Cuotas18
     * @return Configuration
     */
    public function setSeisA10Cuotas18($seisA10Cuotas18)
    {
        $this->seisA10Cuotas18 = $seisA10Cuotas18;

        return $this;
    }

    /**
     * Get seisA10Cuotas18
     *
     * @return string 
     */
    public function getSeisA10Cuotas18()
    {
        return $this->seisA10Cuotas18;
    }

    /**
     * Set seisA10Cuotas20
     *
     * @param string $seisA10Cuotas20
     * @return Configuration
     */
    public function setSeisA10Cuotas20($seisA10Cuotas20)
    {
        $this->seisA10Cuotas20 = $seisA10Cuotas20;

        return $this;
    }

    /**
     * Get seisA10Cuotas20
     *
     * @return string 
     */
    public function getSeisA10Cuotas20()
    {
        return $this->seisA10Cuotas20;
    }

    /**
     * Set seisA10Cuotas22
     *
     * @param string $seisA10Cuotas22
     * @return Configuration
     */
    public function setSeisA10Cuotas22($seisA10Cuotas22)
    {
        $this->seisA10Cuotas22 = $seisA10Cuotas22;

        return $this;
    }

    /**
     * Get seisA10Cuotas22
     *
     * @return string 
     */
    public function getSeisA10Cuotas22()
    {
        return $this->seisA10Cuotas22;
    }

    /**
     * Set seisA10Cuotas24
     *
     * @param string $seisA10Cuotas24
     * @return Configuration
     */
    public function setSeisA10Cuotas24($seisA10Cuotas24)
    {
        $this->seisA10Cuotas24 = $seisA10Cuotas24;

        return $this;
    }

    /**
     * Get seisA10Cuotas24
     *
     * @return string 
     */
    public function getSeisA10Cuotas24()
    {
        return $this->seisA10Cuotas24;
    }

    /**
     * Set seisA10Cuotas26
     *
     * @param string $seisA10Cuotas26
     * @return Configuration
     */
    public function setSeisA10Cuotas26($seisA10Cuotas26)
    {
        $this->seisA10Cuotas26 = $seisA10Cuotas26;

        return $this;
    }

    /**
     * Get seisA10Cuotas26
     *
     * @return string 
     */
    public function getSeisA10Cuotas26()
    {
        return $this->seisA10Cuotas26;
    }

    /**
     * Set seisA10Cuotas28
     *
     * @param string $seisA10Cuotas28
     * @return Configuration
     */
    public function setSeisA10Cuotas28($seisA10Cuotas28)
    {
        $this->seisA10Cuotas28 = $seisA10Cuotas28;

        return $this;
    }

    /**
     * Get seisA10Cuotas28
     *
     * @return string 
     */
    public function getSeisA10Cuotas28()
    {
        return $this->seisA10Cuotas28;
    }

    /**
     * Set seisA10Cuotas30
     *
     * @param string $seisA10Cuotas30
     * @return Configuration
     */
    public function setSeisA10Cuotas30($seisA10Cuotas30)
    {
        $this->seisA10Cuotas30 = $seisA10Cuotas30;

        return $this;
    }

    /**
     * Get seisA10Cuotas30
     *
     * @return string 
     */
    public function getSeisA10Cuotas30()
    {
        return $this->seisA10Cuotas30;
    }

    /**
     * Set seisA10Cuotas32
     *
     * @param string $seisA10Cuotas32
     * @return Configuration
     */
    public function setSeisA10Cuotas32($seisA10Cuotas32)
    {
        $this->seisA10Cuotas32 = $seisA10Cuotas32;

        return $this;
    }

    /**
     * Get seisA10Cuotas32
     *
     * @return string 
     */
    public function getSeisA10Cuotas32()
    {
        return $this->seisA10Cuotas32;
    }

    /**
     * Set seisA10Cuotas34
     *
     * @param string $seisA10Cuotas34
     * @return Configuration
     */
    public function setSeisA10Cuotas34($seisA10Cuotas34)
    {
        $this->seisA10Cuotas34 = $seisA10Cuotas34;

        return $this;
    }

    /**
     * Get seisA10Cuotas34
     *
     * @return string 
     */
    public function getSeisA10Cuotas34()
    {
        return $this->seisA10Cuotas34;
    }

    /**
     * Set seisA10Cuotas36
     *
     * @param string $seisA10Cuotas36
     * @return Configuration
     */
    public function setSeisA10Cuotas36($seisA10Cuotas36)
    {
        $this->seisA10Cuotas36 = $seisA10Cuotas36;

        return $this;
    }

    /**
     * Get seisA10Cuotas36
     *
     * @return string 
     */
    public function getSeisA10Cuotas36()
    {
        return $this->seisA10Cuotas36;
    }

    /**
     * Set onceA15Cuotas2
     *
     * @param string $onceA15Cuotas2
     * @return Configuration
     */
    public function setOnceA15Cuotas2($onceA15Cuotas2)
    {
        $this->onceA15Cuotas2 = $onceA15Cuotas2;

        return $this;
    }

    /**
     * Get onceA15Cuotas2
     *
     * @return string 
     */
    public function getOnceA15Cuotas2()
    {
        return $this->onceA15Cuotas2;
    }

    /**
     * Set onceA15Cuotas4
     *
     * @param string $onceA15Cuotas4
     * @return Configuration
     */
    public function setOnceA15Cuotas4($onceA15Cuotas4)
    {
        $this->onceA15Cuotas4 = $onceA15Cuotas4;

        return $this;
    }

    /**
     * Get onceA15Cuotas4
     *
     * @return string 
     */
    public function getOnceA15Cuotas4()
    {
        return $this->onceA15Cuotas4;
    }

    /**
     * Set onceA15Cuotas6
     *
     * @param string $onceA15Cuotas6
     * @return Configuration
     */
    public function setOnceA15Cuotas6($onceA15Cuotas6)
    {
        $this->onceA15Cuotas6 = $onceA15Cuotas6;

        return $this;
    }

    /**
     * Get onceA15Cuotas6
     *
     * @return string 
     */
    public function getOnceA15Cuotas6()
    {
        return $this->onceA15Cuotas6;
    }

    /**
     * Set onceA15Cuotas8
     *
     * @param string $onceA15Cuotas8
     * @return Configuration
     */
    public function setOnceA15Cuotas8($onceA15Cuotas8)
    {
        $this->onceA15Cuotas8 = $onceA15Cuotas8;

        return $this;
    }

    /**
     * Get onceA15Cuotas8
     *
     * @return string 
     */
    public function getOnceA15Cuotas8()
    {
        return $this->onceA15Cuotas8;
    }

    /**
     * Set onceA15Cuotas10
     *
     * @param string $onceA15Cuotas10
     * @return Configuration
     */
    public function setOnceA15Cuotas10($onceA15Cuotas10)
    {
        $this->onceA15Cuotas10 = $onceA15Cuotas10;

        return $this;
    }

    /**
     * Get onceA15Cuotas10
     *
     * @return string 
     */
    public function getOnceA15Cuotas10()
    {
        return $this->onceA15Cuotas10;
    }

    /**
     * Set onceA15Cuotas12
     *
     * @param string $onceA15Cuotas12
     * @return Configuration
     */
    public function setOnceA15Cuotas12($onceA15Cuotas12)
    {
        $this->onceA15Cuotas12 = $onceA15Cuotas12;

        return $this;
    }

    /**
     * Get onceA15Cuotas12
     *
     * @return string 
     */
    public function getOnceA15Cuotas12()
    {
        return $this->onceA15Cuotas12;
    }

    /**
     * Set onceA15Cuotas14
     *
     * @param string $onceA15Cuotas14
     * @return Configuration
     */
    public function setOnceA15Cuotas14($onceA15Cuotas14)
    {
        $this->onceA15Cuotas14 = $onceA15Cuotas14;

        return $this;
    }

    /**
     * Get onceA15Cuotas14
     *
     * @return string 
     */
    public function getOnceA15Cuotas14()
    {
        return $this->onceA15Cuotas14;
    }

    /**
     * Set onceA15Cuotas16
     *
     * @param string $onceA15Cuotas16
     * @return Configuration
     */
    public function setOnceA15Cuotas16($onceA15Cuotas16)
    {
        $this->onceA15Cuotas16 = $onceA15Cuotas16;

        return $this;
    }

    /**
     * Get onceA15Cuotas16
     *
     * @return string 
     */
    public function getOnceA15Cuotas16()
    {
        return $this->onceA15Cuotas16;
    }

    /**
     * Set onceA15Cuotas18
     *
     * @param string $onceA15Cuotas18
     * @return Configuration
     */
    public function setOnceA15Cuotas18($onceA15Cuotas18)
    {
        $this->onceA15Cuotas18 = $onceA15Cuotas18;

        return $this;
    }

    /**
     * Get onceA15Cuotas18
     *
     * @return string 
     */
    public function getOnceA15Cuotas18()
    {
        return $this->onceA15Cuotas18;
    }

    /**
     * Set onceA15Cuotas20
     *
     * @param string $onceA15Cuotas20
     * @return Configuration
     */
    public function setOnceA15Cuotas20($onceA15Cuotas20)
    {
        $this->onceA15Cuotas20 = $onceA15Cuotas20;

        return $this;
    }

    /**
     * Get onceA15Cuotas20
     *
     * @return string 
     */
    public function getOnceA15Cuotas20()
    {
        return $this->onceA15Cuotas20;
    }

    /**
     * Set onceA15Cuotas22
     *
     * @param string $onceA15Cuotas22
     * @return Configuration
     */
    public function setOnceA15Cuotas22($onceA15Cuotas22)
    {
        $this->onceA15Cuotas22 = $onceA15Cuotas22;

        return $this;
    }

    /**
     * Get onceA15Cuotas22
     *
     * @return string 
     */
    public function getOnceA15Cuotas22()
    {
        return $this->onceA15Cuotas22;
    }

    /**
     * Set onceA15Cuotas24
     *
     * @param string $onceA15Cuotas24
     * @return Configuration
     */
    public function setOnceA15Cuotas24($onceA15Cuotas24)
    {
        $this->onceA15Cuotas24 = $onceA15Cuotas24;

        return $this;
    }

    /**
     * Get onceA15Cuotas24
     *
     * @return string 
     */
    public function getOnceA15Cuotas24()
    {
        return $this->onceA15Cuotas24;
    }
    
 	public function setImpuestos($impuestos)
    {
        $this->impuestos = $impuestos;

        return $this;
    }
    
    public function getImpuestos()
    {
        return $this->impuestos;
    }
    
    public function setAnio0km($anio0km)
    {
        $this->anio0km = $anio0km;

        return $this;
    }
    
    public function getAnio0km()
    {
        return $this->anio0km;
    }
}
