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

class AdminController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/AdminList[/{id}]", [PermissionMiddleware::class], "list.admin")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AdminList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/AdminAdd[/{id}]", [PermissionMiddleware::class], "add.admin")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AdminAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/AdminView[/{id}]", [PermissionMiddleware::class], "view.admin")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AdminView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/AdminEdit[/{id}]", [PermissionMiddleware::class], "edit.admin")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AdminEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/AdminDelete[/{id}]", [PermissionMiddleware::class], "delete.admin")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "AdminDelete");
    }
}
