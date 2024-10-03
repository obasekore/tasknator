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

class TaskerServiceController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/TaskerServiceList[/{TaskerServiceID}]", [PermissionMiddleware::class], "list.TaskerService")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerServiceList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/TaskerServiceAdd[/{TaskerServiceID}]", [PermissionMiddleware::class], "add.TaskerService")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerServiceAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/TaskerServiceView[/{TaskerServiceID}]", [PermissionMiddleware::class], "view.TaskerService")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerServiceView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/TaskerServiceEdit[/{TaskerServiceID}]", [PermissionMiddleware::class], "edit.TaskerService")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerServiceEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/TaskerServiceDelete[/{TaskerServiceID}]", [PermissionMiddleware::class], "delete.TaskerService")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "TaskerServiceDelete");
    }
}
