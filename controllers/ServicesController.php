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

class ServicesController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ServicesList[/{ServiceID}]", [PermissionMiddleware::class], "list.Services")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServicesList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ServicesAdd[/{ServiceID}]", [PermissionMiddleware::class], "add.Services")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServicesAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ServicesView[/{ServiceID}]", [PermissionMiddleware::class], "view.Services")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServicesView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ServicesEdit[/{ServiceID}]", [PermissionMiddleware::class], "edit.Services")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServicesEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ServicesDelete[/{ServiceID}]", [PermissionMiddleware::class], "delete.Services")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServicesDelete");
    }
}
