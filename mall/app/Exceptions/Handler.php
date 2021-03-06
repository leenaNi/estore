<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e) {
        return parent::report($e);
    }

    /** fgdfgdfgd
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        return parent::render($request, $e);
    }

//
//    public function render($request, Exception $e) {
//        // dd($request);
////         $status = $e->getStatusCode();
////         echo $status;
//        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
//            return response()->view('index');
//        }
//        // print_r($e);
//        // dd($request);
//        return parent::render($request, $e);
//    }

    protected function unauthenticated($request, Exception $e) {
        //dd($request);
        print_r($e->getMessage());
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

       // print_r("Unauthorised User"); die;
return redirect()->guest('login-user');
    }

}
