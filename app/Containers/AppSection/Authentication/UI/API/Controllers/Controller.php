<?php

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLogoutAction;
use App\Containers\AppSection\Authentication\Actions\ProxyLoginForWebClientAction;
use App\Containers\AppSection\Authentication\Actions\ProxyLoginForTenantWebClientAction;
use App\Containers\AppSection\Authentication\Actions\ProxyRefreshForWebClientAction;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Exceptions\UserNotConfirmedException;
use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyLoginPasswordGrantRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\ProxyRefreshRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginProxyPasswordGrantRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

class Controller extends ApiController
{

    public function tenantUserLogin(LoginProxyPasswordGrantRequest $request): JsonResponse
    {
        $result = app(ProxyLoginForTenantWebClientAction::class)->run($request);
        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }

    public function tenantUserlogout(LogoutRequest $request): JsonResponse
    {
        app(ApiLogoutAction::class)->run($request);
        return $this->accepted([
            'message' => 'Token revoked successfully.',
        ])->withCookie(Cookie::forget('refreshToken'));


    }
}
