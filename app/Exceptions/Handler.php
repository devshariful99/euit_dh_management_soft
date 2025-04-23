<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Support\Facades\Mail;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function report(Throwable $exception)
    {
        parent::report($exception);

        if ($this->shouldReport($exception)) {
            $this->sendExceptionEmail($exception);
        }
    }
    protected function sendExceptionEmail(Throwable $exception)
    {
        try {
            $subject = 'Laravel App Exception: ' . get_class($exception);
            $message = "Message: " . $exception->getMessage() . "\n";
            $message .= "File: " . $exception->getFile() . "\n";
            $message .= "Line: " . $exception->getLine() . "\n";
            $message .= "Trace:\n" . $exception->getTraceAsString();

            Mail::raw($message, function ($mail) use ($subject) {
                $mail->to(['shariful.euitsols@gmail.com', 'sohag.euitsols@gmail.com'])
                    ->subject($subject);
            });
        } catch (Throwable $mailException) {
            // prevent infinite loop if mail fails
            Log::error('Failed to send exception email: ' . $mailException->getMessage());
        }
    }
}
