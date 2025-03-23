<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/orders', name: 'api_orders_')]
class OrderController extends AbstractController
{  private $orderRepository;
    
    public function __construct(OrderRepository $orderRepository) 
    {
        $this->orderRepository = $orderRepository;
    }
    
    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();
        return $this->json($orders);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);
        if (!$order) {
            return $this->json(['error' => 'Order not found'], 404);
        }

        return $this->json($order);
    }
}
