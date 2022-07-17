<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;

class FormError
{
    public function getErrorMessages(FormInterface $form): array
    {
        $errors = [];

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }
}
