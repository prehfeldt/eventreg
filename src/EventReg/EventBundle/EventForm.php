<?php

namespace EventReg\EventBundle;

use EventReg\EventBundle\Entity\Event;
use Symfony\Component\Form\FormFactory;
use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class EventForm {

    protected $formFactory;

    protected $translator;

    public function __construct(FormFactory $formFactory, Translator $translator) {
        $this->formFactory = $formFactory;
        $this->translator = $translator;
    }

    public function getEventForm(Event $event) {
        $formBuilder = $this->formFactory->createBuilder('form', $event);

        $formBuilder->add('name', 'text', array(
            'label' => $this->translator->trans('event.add.name', array(), 'event'),
            'max_length' => 1024
        ));

        $formBuilder->add('dateTime', 'datetime', array(
            'label' => $this->translator->trans('event.add.dateTime', array(), 'event'),
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
        ));

        $formBuilder->add('description', 'textarea', array(
            'label' => $this->translator->trans('event.add.description', array(), 'event')
        ));

        return $formBuilder->getForm();
    }
}
