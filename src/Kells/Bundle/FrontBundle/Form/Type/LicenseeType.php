<?php
namespace  Kells\Bundle\FrontBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;


class LicenseeType extends AbstractType {
	
	protected $em;
	
  	public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }
    
	public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('cuit', 'text');
        $builder->add('socialReason', 'text');
        $builder->add('fantasyName', 'text');
        $builder->add('contactName', 'text');
        $builder->add('telephone', 'text');
        $builder->add('mail', 'email');
        $builder->add('address', 'text');
        $builder->add('web', 'text');
        $builder->add('facebook', 'text');
        $builder->add('cityId', 'choice', array(
		    'choices'  => $this->buildChoices()
		));
        $builder->add('password', 'repeated', array(
           'first_name'  => 'password',
           'second_name' => 'confirm',
           'type'        => 'password',
           'required' => true,
    	   'first_options'  => array('label' => 'Contraseña '),
    	   'second_options' => array('label' => 'Repetir contraseña '),
        ));
    }

	protected function buildChoices() {
    $choices          = [];
    $table2Repository = $this->em->getRepository('KellsFrontBundle:City');
    $table2Objects    = $table2Repository->findBy(array('province'=>1), array('description'=>'ASC'));

    foreach ($table2Objects as $table2Obj) {
        $choices[$table2Obj->getId()] = $table2Obj->getDescription() ;
    }

    return $choices;
}
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Kells\Bundle\FrontBundle\Entity\Licensee'
        ));
    }

    public function getName()
    {
        return 'Licensee';
    }
}