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

class TaskerController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TaskerList[/{id}]", [PermissionMiddleware::class], "list.tasker")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TaskerAdd[/{id}]", [PermissionMiddleware::class], "add.tasker")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TaskerView[/{id}]", [PermissionMiddleware::class], "view.tasker")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TaskerEdit[/{id}]", [PermissionMiddleware::class], "edit.tasker")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TaskerDelete[/{id}]", [PermissionMiddleware::class], "delete.tasker")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerDelete");
    }
}
