<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/invoice')]
// class InvoiceController extends AbstractController implements \Serializable
class InvoiceController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function new(Request $request, InvoiceRepository $invoiceRepository, ProductRepository $productRepository)
    {
        $requestBody = $request->toArray();

        $productsIds = array_reduce($requestBody['items'], function($ax, $a) {return $ax[] = $a['product_id'];}, []);

        $product = $productRepository->findByIds([1, 2, 3]);
        $invoice = new Invoice();
        foreach ($products as $product) {
            $invoice->addProduct($product);
        }

        /* 
            using serializer to convert to json
            we use group to filter the fields we want to return
        */
        $serializer = serialize($invoice, 'json', ['groups' => ['inv', 'product']]);

        $invoiceRepository->add($invoice, true);
        // return $this->json($invoice); // error here: circular reference detected
        return $this->json($invoice, context: ['groups' => ['invoice', 'product']]);
    }


}