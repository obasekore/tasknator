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

class UserController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/UserList[/{id}]", [PermissionMiddleware::class], "list.user")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/UserAdd[/{id}]", [PermissionMiddleware::class], "add.user")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/UserView[/{id}]", [PermissionMiddleware::class], "view.user")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/UserEdit[/{id}]", [PermissionMiddleware::class], "edit.user")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/UserDelete[/{id}]", [PermissionMiddleware::class], "delete.user")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "UserDelete");
    }
}
