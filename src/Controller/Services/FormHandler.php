<?php

namespace App\Controller\Services;

use Symfony\Component\Form\Form;

class FormHandler
{
    public function parseData(Form $form, array $dataArray): array
    {
        $formData = [];
        foreach ($form->all() as $name => $field) {
            if (isset($dataArray[$name])) {
                $formData[$name] = $dataArray[$name];
            }
        }
        return $formData;
    }

    public function getErrorsFromForm(Form $form)
    {
        $errores = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errores[] = $error->getMessage();
        }
        return $errores;
    }
}
