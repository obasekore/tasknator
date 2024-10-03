<?php

namespace PHPMaker2024\taskinator_project_file;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Slim\Exception\HttpUnauthorizedException;
use PHPMaker2024\taskinator_project_file\Attributes\Delete;
use PHPMaker2024\taskinator_project_file\Attributes\Get;
use PHPMaker2024\taskinator_project_file\Attributes\Map;
use PHPMaker2024\taskinator_project_file\Attributes\Options;
use PHPMaker2024\taskinator_project_file\Attributes\Patch;
use PHPMaker2024\taskinator_project_file\Attributes\Post;
use PHPMaker2024\taskinator_project_file\Attributes\Put;

/**
 * Class others controller
 */
class OthersController extends ControllerBase
{
    // personaldata
    #[Map(["GET","POST","OPTIONS"], "/personaldata", [PermissionMiddleware::class], "personaldata")]
    public function personaldata(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "PersonalData");
    }

    // login
    #[Map(["GET","POST","OPTIONS"], "/login[/{provider}]", [PermissionMiddleware::class], "login")]
    public function login(Request $request, Response $response, array $args): Response
    {
        global $Error;
        $Error = $this->container->get("app.flash")->getFirstMessage("error");
        return $this->runPage($request, $response, $args, "Login");
    }

    // resetpassword
    #[Map(["GET","POST","OPTIONS"], "/resetpassword", [PermissionMiddleware::class], "resetpassword")]
    public function resetpassword(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ResetPassword");
    }

    // changepassword
    #[Map(["GET","POST","OPTIONS"], "/changepassword", [PermissionMiddleware::class], "changepassword")]
    public function changepassword(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "ChangePassword");
    }

    // register
    #[Map(["GET","POST","OPTIONS"], "/register", [PermissionMiddleware::class], "register")]
    public function register(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Register");
    }

    // userpriv
    #[Map(["GET","POST","OPTIONS"], "/userpriv", [PermissionMiddleware::class], "userpriv")]
    public function userpriv(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Userpriv");
    }

    // logout
    #[Map(["GET","POST","OPTIONS"], "/logout", [PermissionMiddleware::class], "logout")]
    public function logout(Request $request, Response $response, array $args): Response
    {
        return $this->runPage($request, $response, $args, "Logout");
    }

    // Swagger
    #[Get("/swagger/swagger", [], "swagger")]
    public function swagger(Request $request, Response $response, array $args): Response
    {
        $basePath = GetBasePath($request);
        $lang = $this->container->get("app.language");
        $title = $lang->phrase("ApiTitle");
        if (!$title || $title == "ApiTitle") {
            $title = "REST API"; // Default
        }
        $data = [
            "title" => $title,
            "version" => Config("API_VERSION"),
            "basePath" => $basePath
        ];
        $view = $this->container->get("app.view");
        return $view->render($response, "swagger.php", $data);
    }

    // Index
    #[Get("/[index]", [PermissionMiddleware::class], "index")]
    public function index(Request $request, Response $response, array $args): Response
    {
        $url = "splash";
        $fn = PROJECT_NAMESPACE . $url;
        if (is_callable($fn)) {
            $url = $fn();
        }
        if ($url == "") {
            throw new HttpUnauthorizedException($request, DeniedMessage());
        }
        return $response->withHeader("Location", $url)->withStatus(302);
    }
}
