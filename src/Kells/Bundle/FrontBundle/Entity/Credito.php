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
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $fijoSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $mailSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $actividadLaboralSolicitante;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $telLaboralSolicitante;
	
	/**
     * @ORM\OneToMany(targetEntity="Fotocopias", mappedBy="credito", cascade={"persist", "remove", "merge"})
     */
	protected $fotocopiasSolicitante;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $nombreConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $apellidoConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $dniConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $estadoCivilConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $domicilioConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $provinciaConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $ciudadConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $celularConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $fijoConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $mailConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $actividadLaboralConyuge;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $telLaboralConyuge;
	
	/**
     * @ORM\OneToMany(targetEntity="FotocopiasConyuge", mappedBy="credito", cascade={"persist", "remove", "merge"})
     */
	protected $fotocopiasConyuge;
	
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
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $domain;
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
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
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $comentarios;

	
	
}
