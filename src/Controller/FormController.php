<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\ProductType;
use App\Form\CategoryType;
use Symfony\Component\Routing\Attribute\Route;



class FormController extends AbstractController
{
    #[Route('/api/form/product', name: 'api_form_product')]
    public function productForm()
    {
        $form = $this->createForm(ProductType::class);
        return $this->json(['form' => $this->getFormFields($form)]);
    }

    private function getFormFields($form)
    {
        $fields = [];
        foreach ($form as $field) {
            $fields[] = [
                'type' => get_class($field->getConfig()->getType()->getInnerType()),
                'name' => $field->getName(),
                'options' => $field->getConfig()->getOptions(),
            ];      
        }
        return $fields;
    }
}

