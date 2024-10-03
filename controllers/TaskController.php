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

class TaskController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TaskList[/{id}]", [PermissionMiddleware::class], "list.task")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TaskAdd[/{id}]", [PermissionMiddleware::class], "add.task")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TaskView[/{id}]", [PermissionMiddleware::class], "view.task")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TaskEdit[/{id}]", [PermissionMiddleware::class], "edit.task")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TaskDelete[/{id}]", [PermissionMiddleware::class], "delete.task")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskDelete");
    }
}
