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

class TasksController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TasksList[/{TaskID}]", [PermissionMiddleware::class], "list.Tasks")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasksList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TasksAdd[/{TaskID}]", [PermissionMiddleware::class], "add.Tasks")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasksAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TasksView[/{TaskID}]", [PermissionMiddleware::class], "view.Tasks")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasksView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TasksEdit[/{TaskID}]", [PermissionMiddleware::class], "edit.Tasks")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasksEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TasksDelete[/{TaskID}]", [PermissionMiddleware::class], "delete.Tasks")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TasksDelete");
    }
}
