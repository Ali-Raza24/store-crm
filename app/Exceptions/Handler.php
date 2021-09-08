<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof AccessDeniedException) {
            return response()->json(['status' => false, 'message' => 'Access Denied']);
        }

        if ($e instanceof NotFoundHttpException || $e instanceof MethodNotAllowedHttpException){
            if ($request->ajax() || $request->isJson()){
                return response()->json(['status' => false, 'message' => 'Not found']);
            }else{
                return response()->make(view('errors.404'));
            }
        }
        if ($e instanceof UnauthorizedException){
            if ($request->ajax() || $request->isJson()){
                return response()->json(['status' => false, 'message' => 'Unauthorized']);
            }else{
                $exception = $e;
                return response()->make(view('errors.403', compact('e', 'exception')));
            }
        }
        if ($e instanceof TokenMismatchException) {
            return redirect()->route('login');
        }

        return parent::render($request, $e);
    }
}
