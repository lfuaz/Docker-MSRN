<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/message')]
class MessageController extends AbstractController
{

    private MessageRepository $messageRepository;

    public function __construct(MessageRepository $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    #[Route('/', name: 'app_message_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'data' => $this->messageRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_message_new', methods: ['POST'])]
    public function new(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $message = new Message();
        
        $message->setBody($body['body']);
        $message->setFromuid($body['fromuid']);
        $this->messageRepository->add($message,true);

        return $this->json([
            'created' => 204,
        ],204);
    }

    #[Route('/{id}', name: 'app_message_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        try { 
            $message = $this->messageRepository->find($id);
        } catch (\Throwable $th) {
            $message = "Error params not matching";
        }
       

        return $this->json([
            'message' => $message,
        ]);
    }

    #[Route('/{id}', name: 'app_message_edit', methods: ['PUT','PATCH'])]
    public function edit(Request $request, int $id): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $message = $this->messageRepository->find($id);

        $message->setBody($body['body']);
        $message->setFromuid($body['fromuid']);

        $this->messageRepository->add($message,true);

        return $this->json(["message" => "edited"]);
    }

    #[Route('/{id}', name: 'app_message_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->messageRepository->remove($this->messageRepository->find($id), true);
        return $this->json(["Deleted" => 200]);
    }

    #[Route('/query/[{filter}]={str}', name: 'app_message_filter', methods: ['GET'])]
    public function filter(string $filter,string $str): JsonResponse
    {
        $finded = $this->messageRepository->findBy([$filter => $str]);

        return $this->json(["data" => $finded]);
    }
}
