<?php
namespace Album\Form;

use Zend\Form\Form;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AlbumForm extends Form implements ObjectManagerAwareInterface
{
	protected $objectManager;
    public function __construct(ObjectManager $objectManager, $name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album');
        $this->setAttribute('method', 'post');

		$this->objectManager = $objectManager;
		//$hydrator = new DoctrineHydrator($entityManager, '\Album\Entity\Artist');
		//$this->setHydrator($hydrator);


        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'artist',
            'options' => [
                'object_manager' => $this->getObjectManager(),
                'target_class'   => 'Album\Entity\Artist',
                'property'       => 'label',
            ],
        ]);
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager()
    {
        return $this->objectManager;
    }
}
