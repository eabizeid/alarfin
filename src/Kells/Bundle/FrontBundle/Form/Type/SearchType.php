<?php
// src/Kells/LicenseeBundle/Form/Type/RegistrationType.php
namespace Kells\Bundle\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pattern', 'text');
        $builder->add('Buscar', 'submit', array ('attr' => array('class' => 'btn btn-form btn-lg'),));
    }

    public function getName()
    {
        return 'BUSCAR';
    }
}