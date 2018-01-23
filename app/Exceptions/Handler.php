<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use InvalidArgumentException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Illuminate\Database\QueryException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $default_handler = false;
        //excepciones que no debe ser manejadas
        $excepted_exceptions = ['AuthenticationException','ValidationException'];

        //si no está habilitado modo debug ni es entorno local
        //renderiza la excepcion nativa de laravel
        if (config("app.debug") && config("app.env") == "local") {
            $default_handler = true;
        } else {
            //en entorno de produccion, maneja una excepcion en una vista custom
            $e = $exception;
            $handy_exception = FlattenException::create($e);

            $class_full_name = get_class($e);
            $class_base_name = basename(str_replace('\\', '/', $class_full_name));
            $class_acronym = preg_replace('~[^A-Z]~', '', $class_base_name);

            if (in_array($class_base_name, $excepted_exceptions)) {
                $default_handler = true;
            } else {
                $status_code = $handy_exception->getStatusCode($handy_exception);
                $message = $status_code == 404 ? "Página no encontrada" : "Ha ocurrido algo inusual";

                $route_name = $request->path();
                $request_parameters = $request->all();

                $view_parameters = [
                    'message'=>$message,
                    'status_code'=>$status_code,
                    'class_acronym'=>$class_acronym,
                    'class_full_name'=>$class_full_name,
                    'class_base_name'=>$class_base_name,
                    'route_name'=>$route_name,
                    'request_parameters'=>$request_parameters,
                    'handy_exception'=>$handy_exception,
                ];

                return response()->view('errors.any', $view_parameters, $status_code);
            }
        }

        if ($default_handler) {
            return parent::render($request, $exception);
        }
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
