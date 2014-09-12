<?php
// src/Kells/LicenseeBundle/Form/Type/RegistrationType.php
namespace Kells\LicenseeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cuit', 'text');
        $builder->add('password', 'password');
        $builder->add('Login', 'submit', array ('attr' => array('class' => 'btn btn-succes'),));
    }

    public function getName()
    {
        return 'login';
    }
}