<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="creditos") 
 */
class Credito {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $nombreSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $apellidoSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $dniSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $nacimientoSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $estadoCivilSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $domicilioSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $provinciaSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $ciudadSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $celularSolicitante;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $fijoSolicitante;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $mailSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $actividadLaboralSolicitante;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $telLaboralSolicitante;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaServicioSolicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaServicioSolicitante;

	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaDniSolicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaDniSolicitante;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaReciboSolicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaReciboSolicitante;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaIngresosSolicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaIngresosSolicitante;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaOtra1Solicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaOtra1Solicitante;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaOtra2Solicitante_id", referencedColumnName="id")
     **/
	protected $fotocopiaOtra2Solicitante;
	
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $nombreConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $apellidoConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $dniConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $estadoCivilConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $domicilioConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $provinciaConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $ciudadConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $celularConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $fijoConyuge;
	
	
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $actividadLaboralConyuge;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $telLaboralConyuge;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaDniConyuge_id", referencedColumnName="id")
     **/
	protected $fotocopiaDniConyuge;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaOtra1Conyuge_id", referencedColumnName="id")
     **/
	protected $fotocopiaOtra1Conyuge;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaOtra2Conyuge_id", referencedColumnName="id")
     **/
	protected $fotocopiaOtra2Conyuge;
	
	/**
     * @ORM\OneToOne(targetEntity="Fotocopias", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="fotocopiaOtra3Conyuge_id", referencedColumnName="id")
     **/
	protected $fotocopiaOtra3Conyuge;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $marca;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $modelo;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $year;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $valor;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $type;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $domain;
	/**
     * @ORM\Column(type="string", length=150)
     */
	protected $combustible;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $montoCredito;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $cantidadCuotas;
	/**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
	protected $comentarios;
	
	/**
     * @ORM\Column(type="string", length=150)
     */
	protected $valorCuota;

	/**
	 * @ORM\Column(type="date")
     */
	protected $date;
	
	/**
     * @ORM\Column(type="string", length=150)
     */
	protected $user;
	
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fotocopiasSolicitante = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fotocopiasConyuge = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set nombreSolicitante
     *
     * @param string $nombreSolicitante
     * @return Credito
     */
    public function setNombreSolicitante($nombreSolicitante)
    {
        $this->nombreSolicitante = $nombreSolicitante;

        return $this;
    }

    /**
     * Get nombreSolicitante
     *
     * @return string 
     */
    public function getNombreSolicitante()
    {
        return $this->nombreSolicitante;
    }

    /**
     * Set apellidoSolicitante
     *
     * @param string $apellidoSolicitante
     * @return Credito
     */
    public function setApellidoSolicitante($apellidoSolicitante)
    {
        $this->apellidoSolicitante = $apellidoSolicitante;

        return $this;
    }

    /**
     * Get apellidoSolicitante
     *
     * @return string 
     */
    public function getApellidoSolicitante()
    {
        return $this->apellidoSolicitante;
    }

    /**
     * Set dniSolicitante
     *
     * @param string $dniSolicitante
     * @return Credito
     */
    public function setDniSolicitante($dniSolicitante)
    {
        $this->dniSolicitante = $dniSolicitante;

        return $this;
    }

    /**
     * Get dniSolicitante
     *
     * @return string 
     */
    public function getDniSolicitante()
    {
        return $this->dniSolicitante;
    }

    /**
     * Set nacimientoSolicitante
     *
     * @param string $nacimientoSolicitante
     * @return Credito
     */
    public function setNacimientoSolicitante($nacimientoSolicitante)
    {
        $this->nacimientoSolicitante = $nacimientoSolicitante;

        return $this;
    }

    /**
     * Get nacimientoSolicitante
     *
     * @return string 
     */
    public function getNacimientoSolicitante()
    {
        return $this->nacimientoSolicitante;
    }

    /**
     * Set estadoCivilSolicitante
     *
     * @param string $estadoCivilSolicitante
     * @return Credito
     */
    public function setEstadoCivilSolicitante($estadoCivilSolicitante)
    {
        $this->estadoCivilSolicitante = $estadoCivilSolicitante;

        return $this;
    }

    /**
     * Get estadoCivilSolicitante
     *
     * @return string 
     */
    public function getEstadoCivilSolicitante()
    {
        return $this->estadoCivilSolicitante;
    }

    /**
     * Set domicilioSolicitante
     *
     * @param string $domicilioSolicitante
     * @return Credito
     */
    public function setDomicilioSolicitante($domicilioSolicitante)
    {
        $this->domicilioSolicitante = $domicilioSolicitante;

        return $this;
    }

    /**
     * Get domicilioSolicitante
     *
     * @return string 
     */
    public function getDomicilioSolicitante()
    {
        return $this->domicilioSolicitante;
    }

    /**
     * Set provinciaSolicitante
     *
     * @param string $provinciaSolicitante
     * @return Credito
     */
    public function setProvinciaSolicitante($provinciaSolicitante)
    {
        $this->provinciaSolicitante = $provinciaSolicitante;

        return $this;
    }

    /**
     * Get provinciaSolicitante
     *
     * @return string 
     */
    public function getProvinciaSolicitante()
    {
        return $this->provinciaSolicitante;
    }

    /**
     * Set ciudadSolicitante
     *
     * @param string $ciudadSolicitante
     * @return Credito
     */
    public function setCiudadSolicitante($ciudadSolicitante)
    {
        $this->ciudadSolicitante = $ciudadSolicitante;

        return $this;
    }

    /**
     * Get ciudadSolicitante
     *
     * @return string 
     */
    public function getCiudadSolicitante()
    {
        return $this->ciudadSolicitante;
    }

    /**
     * Set celularSolicitante
     *
     * @param string $celularSolicitante
     * @return Credito
     */
    public function setCelularSolicitante($celularSolicitante)
    {
        $this->celularSolicitante = $celularSolicitante;

        return $this;
    }

    /**
     * Get celularSolicitante
     *
     * @return string 
     */
    public function getCelularSolicitante()
    {
        return $this->celularSolicitante;
    }

    /**
     * Set fijoSolicitante
     *
     * @param string $fijoSolicitante
     * @return Credito
     */
    public function setFijoSolicitante($fijoSolicitante)
    {
        $this->fijoSolicitante = $fijoSolicitante;

        return $this;
    }

    /**
     * Get fijoSolicitante
     *
     * @return string 
     */
    public function getFijoSolicitante()
    {
        return $this->fijoSolicitante;
    }

    /**
     * Set mailSolicitante
     *
     * @param string $mailSolicitante
     * @return Credito
     */
    public function setMailSolicitante($mailSolicitante)
    {
        $this->mailSolicitante = $mailSolicitante;

        return $this;
    }

    /**
     * Get mailSolicitante
     *
     * @return string 
     */
    public function getMailSolicitante()
    {
        return $this->mailSolicitante;
    }

    /**
     * Set actividadLaboralSolicitante
     *
     * @param string $actividadLaboralSolicitante
     * @return Credito
     */
    public function setActividadLaboralSolicitante($actividadLaboralSolicitante)
    {
        $this->actividadLaboralSolicitante = $actividadLaboralSolicitante;

        return $this;
    }

    /**
     * Get actividadLaboralSolicitante
     *
     * @return string 
     */
    public function getActividadLaboralSolicitante()
    {
        return $this->actividadLaboralSolicitante;
    }

    /**
     * Set telLaboralSolicitante
     *
     * @param string $telLaboralSolicitante
     * @return Credito
     */
    public function setTelLaboralSolicitante($telLaboralSolicitante)
    {
        $this->telLaboralSolicitante = $telLaboralSolicitante;

        return $this;
    }

    /**
     * Get telLaboralSolicitante
     *
     * @return string 
     */
    public function getTelLaboralSolicitante()
    {
        return $this->telLaboralSolicitante;
    }

    /**
     * Set nombreConyuge
     *
     * @param string $nombreConyuge
     * @return Credito
     */
    public function setNombreConyuge($nombreConyuge)
    {
        $this->nombreConyuge = $nombreConyuge;

        return $this;
    }

    /**
     * Get nombreConyuge
     *
     * @return string 
     */
    public function getNombreConyuge()
    {
        return $this->nombreConyuge;
    }

    /**
     * Set apellidoConyuge
     *
     * @param string $apellidoConyuge
     * @return Credito
     */
    public function setApellidoConyuge($apellidoConyuge)
    {
        $this->apellidoConyuge = $apellidoConyuge;

        return $this;
    }

    /**
     * Get apellidoConyuge
     *
     * @return string 
     */
    public function getApellidoConyuge()
    {
        return $this->apellidoConyuge;
    }

    /**
     * Set dniConyuge
     *
     * @param string $dniConyuge
     * @return Credito
     */
    public function setDniConyuge($dniConyuge)
    {
        $this->dniConyuge = $dniConyuge;

        return $this;
    }

    /**
     * Get dniConyuge
     *
     * @return string 
     */
    public function getDniConyuge()
    {
        return $this->dniConyuge;
    }

    /**
     * Set estadoCivilConyuge
     *
     * @param string $estadoCivilConyuge
     * @return Credito
     */
    public function setEstadoCivilConyuge($estadoCivilConyuge)
    {
        $this->estadoCivilConyuge = $estadoCivilConyuge;

        return $this;
    }

    /**
     * Get estadoCivilConyuge
     *
     * @return string 
     */
    public function getEstadoCivilConyuge()
    {
        return $this->estadoCivilConyuge;
    }

    /**
     * Set domicilioConyuge
     *
     * @param string $domicilioConyuge
     * @return Credito
     */
    public function setDomicilioConyuge($domicilioConyuge)
    {
        $this->domicilioConyuge = $domicilioConyuge;

        return $this;
    }

    /**
     * Get domicilioConyuge
     *
     * @return string 
     */
    public function getDomicilioConyuge()
    {
        return $this->domicilioConyuge;
    }

    /**
     * Set provinciaConyuge
     *
     * @param string $provinciaConyuge
     * @return Credito
     */
    public function setProvinciaConyuge($provinciaConyuge)
    {
        $this->provinciaConyuge = $provinciaConyuge;

        return $this;
    }

    /**
     * Get provinciaConyuge
     *
     * @return string 
     */
    public function getProvinciaConyuge()
    {
        return $this->provinciaConyuge;
    }

    /**
     * Set ciudadConyuge
     *
     * @param string $ciudadConyuge
     * @return Credito
     */
    public function setCiudadConyuge($ciudadConyuge)
    {
        $this->ciudadConyuge = $ciudadConyuge;

        return $this;
    }

    /**
     * Get ciudadConyuge
     *
     * @return string 
     */
    public function getCiudadConyuge()
    {
        return $this->ciudadConyuge;
    }

    /**
     * Set celularConyuge
     *
     * @param string $celularConyuge
     * @return Credito
     */
    public function setCelularConyuge($celularConyuge)
    {
        $this->celularConyuge = $celularConyuge;

        return $this;
    }

    /**
     * Get celularConyuge
     *
     * @return string 
     */
    public function getCelularConyuge()
    {
        return $this->celularConyuge;
    }

    /**
     * Set fijoConyuge
     *
     * @param string $fijoConyuge
     * @return Credito
     */
    public function setFijoConyuge($fijoConyuge)
    {
        $this->fijoConyuge = $fijoConyuge;

        return $this;
    }

    /**
     * Get fijoConyuge
     *
     * @return string 
     */
    public function getFijoConyuge()
    {
        return $this->fijoConyuge;
    }

    /**
     * Set mailConyuge
     *
     * @param string $mailConyuge
     * @return Credito
     */
    public function setMailConyuge($mailConyuge)
    {
        $this->mailConyuge = $mailConyuge;

        return $this;
    }

    /**
     * Get mailConyuge
     *
     * @return string 
     */
    public function getMailConyuge()
    {
        return $this->mailConyuge;
    }

    /**
     * Set actividadLaboralConyuge
     *
     * @param string $actividadLaboralConyuge
     * @return Credito
     */
    public function setActividadLaboralConyuge($actividadLaboralConyuge)
    {
        $this->actividadLaboralConyuge = $actividadLaboralConyuge;

        return $this;
    }

    /**
     * Get actividadLaboralConyuge
     *
     * @return string 
     */
    public function getActividadLaboralConyuge()
    {
        return $this->actividadLaboralConyuge;
    }

    /**
     * Set telLaboralConyuge
     *
     * @param string $telLaboralConyuge
     * @return Credito
     */
    public function setTelLaboralConyuge($telLaboralConyuge)
    {
        $this->telLaboralConyuge = $telLaboralConyuge;

        return $this;
    }

    /**
     * Get telLaboralConyuge
     *
     * @return string 
     */
    public function getTelLaboralConyuge()
    {
        return $this->telLaboralConyuge;
    }

    /**
     * Set marca
     *
     * @param string $marca
     * @return Credito
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string 
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Credito
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string 
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set year
     *
     * @param string $year
     * @return Credito
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return Credito
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Credito
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Credito
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Set combustible
     *
     * @param string $combustible
     * @return Credito
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;

        return $this;
    }

    /**
     * Get combustible
     *
     * @return string 
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * Set montoCredito
     *
     * @param string $montoCredito
     * @return Credito
     */
    public function setMontoCredito($montoCredito)
    {
        $this->montoCredito = $montoCredito;

        return $this;
    }

    /**
     * Get montoCredito
     *
     * @return string 
     */
    public function getMontoCredito()
    {
        return $this->montoCredito;
    }

    /**
     * Set cantidadCuotas
     *
     * @param string $cantidadCuotas
     * @return Credito
     */
    public function setCantidadCuotas($cantidadCuotas)
    {
        $this->cantidadCuotas = $cantidadCuotas;

        return $this;
    }

    /**
     * Get cantidadCuotas
     *
     * @return string 
     */
    public function getCantidadCuotas()
    {
        return $this->cantidadCuotas;
    }

    /**
     * Set comentarios
     *
     * @param string $comentarios
     * @return Credito
     */
    public function setComentarios($comentarios)
    {
        $this->comentarios = $comentarios;

        return $this;
    }

    /**
     * Get comentarios
     *
     * @return string 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Add fotocopiasSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiasSolicitante
     * @return Credito
     */
    public function addFotocopiasSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiasSolicitante)
    {
        $this->fotocopiasSolicitante[] = $fotocopiasSolicitante;

        return $this;
    }

    /**
     * Remove fotocopiasSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiasSolicitante
     */
    public function removeFotocopiasSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiasSolicitante)
    {
        $this->fotocopiasSolicitante->removeElement($fotocopiasSolicitante);
    }

    /**
     * Get fotocopiasSolicitante
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFotocopiasSolicitante()
    {
        return $this->fotocopiasSolicitante;
    }

    /**
     * Add fotocopiasConyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge $fotocopiasConyuge
     * @return Credito
     */
    public function addFotocopiasConyuge(\Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge $fotocopiasConyuge)
    {
        $this->fotocopiasConyuge[] = $fotocopiasConyuge;

        return $this;
    }

    /**
     * Remove fotocopiasConyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge $fotocopiasConyuge
     */
    public function removeFotocopiasConyuge(\Kells\Bundle\FrontBundle\Entity\FotocopiasConyuge $fotocopiasConyuge)
    {
        $this->fotocopiasConyuge->removeElement($fotocopiasConyuge);
    }

    /**
     * Get fotocopiasConyuge
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFotocopiasConyuge()
    {
        return $this->fotocopiasConyuge;
    }

    /**
     * Set fotocopiaServicioSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaServicioSolicitante
     * @return Credito
     */
    public function setFotocopiaServicioSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaServicioSolicitante = null)
    {
        $this->fotocopiaServicioSolicitante = $fotocopiaServicioSolicitante;

        return $this;
    }

    /**
     * Get fotocopiaServicioSolicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaServicioSolicitante()
    {
        return $this->fotocopiaServicioSolicitante;
    }

    /**
     * Set fotocopiaDniSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaDniSolicitante
     * @return Credito
     */
    public function setFotocopiaDniSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaDniSolicitante = null)
    {
        $this->fotocopiaDniSolicitante = $fotocopiaDniSolicitante;

        return $this;
    }

    /**
     * Get fotocopiaDniSolicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaDniSolicitante()
    {
        return $this->fotocopiaDniSolicitante;
    }

    /**
     * Set fotocopiaReciboSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaReciboSolicitante
     * @return Credito
     */
    public function setFotocopiaReciboSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaReciboSolicitante = null)
    {
        $this->fotocopiaReciboSolicitante = $fotocopiaReciboSolicitante;

        return $this;
    }

    /**
     * Get fotocopiaReciboSolicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaReciboSolicitante()
    {
        return $this->fotocopiaReciboSolicitante;
    }

    /**
     * Set fotocopiaIngresosSolicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaIngresosSolicitante
     * @return Credito
     */
    public function setFotocopiaIngresosSolicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaIngresosSolicitante = null)
    {
        $this->fotocopiaIngresosSolicitante = $fotocopiaIngresosSolicitante;

        return $this;
    }

    /**
     * Get fotocopiaIngresosSolicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaIngresosSolicitante()
    {
        return $this->fotocopiaIngresosSolicitante;
    }

    /**
     * Set fotocopiaOtra1Solicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra1Solicitante
     * @return Credito
     */
    public function setFotocopiaOtra1Solicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra1Solicitante = null)
    {
        $this->fotocopiaOtra1Solicitante = $fotocopiaOtra1Solicitante;

        return $this;
    }

    /**
     * Get fotocopiaOtra1Solicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaOtra1Solicitante()
    {
        return $this->fotocopiaOtra1Solicitante;
    }

    /**
     * Set fotocopiaOtra2Solicitante
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra2Solicitante
     * @return Credito
     */
    public function setFotocopiaOtra2Solicitante(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra2Solicitante = null)
    {
        $this->fotocopiaOtra2Solicitante = $fotocopiaOtra2Solicitante;

        return $this;
    }

    /**
     * Get fotocopiaOtra2Solicitante
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaOtra2Solicitante()
    {
        return $this->fotocopiaOtra2Solicitante;
    }

    /**
     * Set fotocopiaDniConyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaDniConyuge
     * @return Credito
     */
    public function setFotocopiaDniConyuge(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaDniConyuge = null)
    {
        $this->fotocopiaDniConyuge = $fotocopiaDniConyuge;

        return $this;
    }

    /**
     * Get fotocopiaDniConyuge
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaDniConyuge()
    {
        return $this->fotocopiaDniConyuge;
    }

    /**
     * Set fotocopiaOtra1Conyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra1Conyuge
     * @return Credito
     */
    public function setFotocopiaOtra1Conyuge(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra1Conyuge = null)
    {
        $this->fotocopiaOtra1Conyuge = $fotocopiaOtra1Conyuge;

        return $this;
    }

    /**
     * Get fotocopiaOtra1Conyuge
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaOtra1Conyuge()
    {
        return $this->fotocopiaOtra1Conyuge;
    }

    /**
     * Set fotocopiaOtra2Conyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra2Conyuge
     * @return Credito
     */
    public function setFotocopiaOtra2Conyuge(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra2Conyuge = null)
    {
        $this->fotocopiaOtra2Conyuge = $fotocopiaOtra2Conyuge;

        return $this;
    }

    /**
     * Get fotocopiaOtra2Conyuge
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaOtra2Conyuge()
    {
        return $this->fotocopiaOtra2Conyuge;
    }

    /**
     * Set fotocopiaOtra3Conyuge
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra3Conyuge
     * @return Credito
     */
    public function setFotocopiaOtra3Conyuge(\Kells\Bundle\FrontBundle\Entity\Fotocopias $fotocopiaOtra3Conyuge = null)
    {
        $this->fotocopiaOtra3Conyuge = $fotocopiaOtra3Conyuge;

        return $this;
    }

    /**
     * Get fotocopiaOtra3Conyuge
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Fotocopias 
     */
    public function getFotocopiaOtra3Conyuge()
    {
        return $this->fotocopiaOtra3Conyuge;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Credito
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return Credito
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }
    
 	public function setValorCuota($valorCuota)
    {
        $this->valorCuota = $valorCuota;

        return $this;
    }

    /**
     * Get valorCUota
     *
     * @return string 
     */
    public function getValorCuota()
    {
        return $this->valorCuota;
    }
}
