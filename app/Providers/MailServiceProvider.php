<?php

namespace App\Providers;

use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
    public static function formatMailAddressesAsArray($mailAddresses, string $delimiter = ','): array
    {
        if(is_array($mailAddresses)) {
            return $mailAddresses;
        }

        $mailAddresses = explode($delimiter, $mailAddresses);
        $mailAddresses = array_map('trim', $mailAddresses);
        return $mailAddresses;
    }

    public static function formatMailAddressesAsString($mailAddresses, string $delimiter = ','): string
    {
        if(is_string($mailAddresses)) {
            return $mailAddresses;
        }

        $mailAddresses = implode($delimiter, $mailAddresses);
        return $mailAddresses;
    }

    public static function publishMailTemplate(Model $mailTemplate): bool
    {
        /*
         * @todo: Implement the logic to publish the mail template as blade view
         */
        try {
            if ($mailTemplate instanceof Template) {
                $mailTemplate->is_published = true;
                $mailTemplate->save();
                return true;
            }
        } catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }

    public static function unpublishMailTemplate(Model $mailTemplate): bool
    {
        /*
         * @todo: Implement the logic to unpublish the mail template as blade view
         */
        try {
            if ($mailTemplate instanceof Template) {
                $mailTemplate->is_published = false;
                $mailTemplate->save();
                return true;
            }
        }
        catch (\Exception $e) {
            error_log($e);
        }
        return false;
    }
}
