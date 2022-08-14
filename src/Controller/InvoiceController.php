<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function new(Request $request, InvoiceRepository $invoiceRepository, ProductRepository $productRepository)
    {
        $requestBody = $request->toArray();

        $product = $productRepository->findByIds([1, 2, 3]);
        $invoice = new Invoice();
        foreach ($products as $product) {
            $invoice->addProduct($product);
        }
    }
}