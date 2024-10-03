<?php

namespace PHPMaker2024\taskinator_project_file;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use PHPMaker2024\taskinator_project_file\Attributes\Delete;
use PHPMaker2024\taskinator_project_file\Attributes\Get;
use PHPMaker2024\taskinator_project_file\Attributes\Map;
use PHPMaker2024\taskinator_project_file\Attributes\Options;
use PHPMaker2024\taskinator_project_file\Attributes\Patch;
use PHPMaker2024\taskinator_project_file\Attributes\Post;
use PHPMaker2024\taskinator_project_file\Attributes\Put;

class ReviewsAndRatingsController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ReviewsAndRatingsList[/{ReviewRatingID}]", [PermissionMiddleware::class], "list.ReviewsAndRatings")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ReviewsAndRatingsList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ReviewsAndRatingsAdd[/{ReviewRatingID}]", [PermissionMiddleware::class], "add.ReviewsAndRatings")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ReviewsAndRatingsAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ReviewsAndRatingsView[/{ReviewRatingID}]", [PermissionMiddleware::class], "view.ReviewsAndRatings")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ReviewsAndRatingsView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ReviewsAndRatingsEdit[/{ReviewRatingID}]", [PermissionMiddleware::class], "edit.ReviewsAndRatings")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ReviewsAndRatingsEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ReviewsAndRatingsDelete[/{ReviewRatingID}]", [PermissionMiddleware::class], "delete.ReviewsAndRatings")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ReviewsAndRatingsDelete");
    }
}
