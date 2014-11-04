<?php
// src/Kells/LicenseeBundle/Form/Type/RegistrationType.php
namespace Kells\Bundle\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', new UserType());
        $builder->add(
            'terms',
            'checkbox',
            array('property_path' => 'termsAccepted')
        );
        $builder->add('register', 'submit', array ('attr' => array('class' => 'btn btn-form btn-lg', 'name'=>'btn_enviar'),));
    }

    public function getName()
    {
        return 'userRegistration';
    }
}