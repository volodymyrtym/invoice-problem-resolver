<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\GetList;

use App\AuthenticationContract\CurentUserProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webmozart\Assert\Assert;

class SiteGetListController extends AbstractController
{
    private const int MAX_ITEMS_ON_PAGE = 50;

    public function __construct(
        private GetListHandler $handler,
        private CurentUserProviderInterface $userProvider,
    ) {}

    #[Route(path: '/daily-activities', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $filters = $request->query->all();
        $page = (int)($filters['page'] ?? 1);
        Assert::greaterThanEq($page, 1);

        $result = $this->handler->handle(
            new GetListQuery(
                page: $page,
                limit: self::MAX_ITEMS_ON_PAGE,
                userId: $this->userProvider->provideId(),
            ),
        );

        return $this->render('daily-activities/daily-activities.twig', ['data' => $result]);
    }

    #[Route(path: '/daily-activities/content', methods: ['GET'])]
    public function content(Request $request): JsonResponse
    {
        $filters = $request->query->all();
        $page = (int)($filters['page'] ?? 1);
        Assert::greaterThanEq($page, 1);

        $result = $this->handler->handle(
            new GetListQuery(
                page: $page,
                limit: self::MAX_ITEMS_ON_PAGE,
                userId: $this->userProvider->provideId(),
            ),
        );

        $statistics = $this->renderView(
            'daily-activities/index/daily-activities-statistics.twig',
            ['data' => $result],
        );
        $list = $this->renderView('daily-activities/index/daily-activities-list.twig', ['data' => $result]);

        return new JsonResponse([
            'statistics' => $statistics,
            'list' => $list,
        ]);
    }
}
