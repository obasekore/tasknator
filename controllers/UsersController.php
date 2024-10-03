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

class UsersController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UsersList[/{ID}]", [PermissionMiddleware::class], "list.Users")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UsersAdd[/{ID}]", [PermissionMiddleware::class], "add.Users")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UsersView[/{ID}]", [PermissionMiddleware::class], "view.Users")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UsersEdit[/{ID}]", [PermissionMiddleware::class], "edit.Users")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UsersDelete[/{ID}]", [PermissionMiddleware::class], "delete.Users")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UsersDelete");
    }
}
