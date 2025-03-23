<?php

namespace App\Controller;

use App\Entity\FleetSet;
use App\Service\FleetSetService;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;



#[Route('/api/fleets')]
class FleetController extends AbstractController
{
    public function __construct(private FleetSetService $fleetService) {}

        /**
     * Create new fleet set.
     *
     * @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref=@Model(type=FleetSet::class, groups={"fleet:write"}))
     * )
     * @OA\Response(
     *     response=201,
     *     description="Fleet created successfully",
     *     @OA\JsonContent(ref=@Model(type=FleetSet::class, groups={"fleet:read"}))
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid input"
     * )
     * @OA\Tag(name="Fleet")
     */
    #[Route('', name: 'api_fleets_create', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ): JsonResponse {
        $fleet = $serializer->deserialize(
            $request->getContent(),
            FleetSet::class,
            'json',
            [AbstractNormalizer::GROUPS => ['fleet:write']]
        );

        $errors = $validator->validate($fleet);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json($errorMessages, Response::HTTP_BAD_REQUEST);
        }

        $this->fleetService->save($fleet);

        return $this->json($fleet, Response::HTTP_CREATED, [], ['groups' => 'fleet:read']);
    }


    /**
     * Get all fleet sets.
     *
     * @OA\Get(
     *     path="/api/fleets",
     *     summary="Get all fleet sets",
     *     tags={"Fleet"},
     *     @OA\Response(
     *         response=200,
     *         description="List of fleet sets",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref=@Model(type=FleetSet::class, groups={"fleet:read"}))
     *         )
     *     )
     * )
     */
    #[Route('', name: 'api_fleets_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->fleetService->getAll(), 200, [], ['groups' => 'fleet:read']);
    }

    /**
     * Get fleet set by ID.
     *
     * @OA\Get(
     *     path="/api/fleets/{id}",
     *     summary="Get fleet set by ID",
     *     tags={"Fleet"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Fleet ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Fleet set found",
     *         @OA\JsonContent(ref=@Model(type=FleetSet::class, groups={"fleet:read"}))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Fleet set not found"
     *     )
     * )
     */


    /**
     * Get paginated fleet sets.
     *
     * @OA\Get(
     *     path="/api/fleets/list",
     *     summary="Get paginated fleet sets",
     *     tags={"Fleet"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="How many results to return",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         description="How many items to skip",
     *         @OA\Schema(type="integer", default=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated fleet set list",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref=@Model(type=FleetSet::class, groups={"fleet:read"}))
     *         )
     *     )
     * )
     */
    #[Route('/list', name: 'api_fleets_list', methods: ['GET'])]
    public function list(int $limit = 10, int $offset = 0): JsonResponse
    {
        return $this->json(
            $this->fleetService->getPaginated($limit, $offset),
            200,
            [],
            ['groups' => 'fleet:read']
        );
    }
    
    #[Route('/{id<\d+>}', name: 'api_fleets_show', methods: ['GET'])]
    public function show(int $id): JsonResponse
    {
        $fleet = $this->fleetService->getById($id);
        if (!$fleet) {
            return $this->json(['error' => 'Fleet not found'], 404);
        }
    
        return $this->json($fleet, 200, [], ['groups' => 'fleet:read']);
    }
    
}
