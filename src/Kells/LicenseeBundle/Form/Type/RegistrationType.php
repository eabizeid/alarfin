<?php
// src/Kells/LicenseeBundle/Form/Type/RegistrationType.php
namespace Kells\LicenseeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('licensee', new LicenseeType());
        $builder->add(
            'terms',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );
        $builder->add('Register', 'submit', array ('attr' => array('class' => 'btn btn-default'),));
    }

    public function getName()
    {
        return 'registration';
    }
}