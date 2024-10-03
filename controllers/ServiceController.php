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

class ServiceController extends ControllerBase
{
    // list
    #[Map(["GET","POST","OPTIONS"], "/ServiceList[/{id}]", [PermissionMiddleware::class], "list.service")]
    public function list(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServiceList");
    }

    // add
    #[Map(["GET","POST","OPTIONS"], "/ServiceAdd[/{id}]", [PermissionMiddleware::class], "add.service")]
    public function add(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServiceAdd");
    }

    // view
    #[Map(["GET","POST","OPTIONS"], "/ServiceView[/{id}]", [PermissionMiddleware::class], "view.service")]
    public function view(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServiceView");
    }

    // edit
    #[Map(["GET","POST","OPTIONS"], "/ServiceEdit[/{id}]", [PermissionMiddleware::class], "edit.service")]
    public function edit(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServiceEdit");
    }

    // delete
    #[Map(["GET","POST","OPTIONS"], "/ServiceDelete[/{id}]", [PermissionMiddleware::class], "delete.service")]
    public function delete(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ServiceDelete");
    }
}
