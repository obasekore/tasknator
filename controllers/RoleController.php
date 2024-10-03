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

class RoleController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/RoleList[/{id}]", [PermissionMiddleware::class], "list.role")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RoleList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/RoleAdd[/{id}]", [PermissionMiddleware::class], "add.role")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RoleAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/RoleView[/{id}]", [PermissionMiddleware::class], "view.role")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RoleView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/RoleEdit[/{id}]", [PermissionMiddleware::class], "edit.role")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RoleEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/RoleDelete[/{id}]", [PermissionMiddleware::class], "delete.role")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "RoleDelete");
    }
}
