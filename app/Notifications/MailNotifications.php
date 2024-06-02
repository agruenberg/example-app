<?php

namespace App\Notifications;

use \Filament\Notifications\Notification;

class MailNotifications
{
	public static function mailTemplatePublishedSuccess(): Notification
	{
		return Notification::make('published')
			->title('Successfully published the mail template.')
			->success();
	}

	public static function mailTemplatePublishedFailed(): Notification
	{
		return Notification::make('published')
			->title('Failed to publish the mail template.')
			->danger();
	}

	public static function mailTemplateUnpublishedSuccess(): Notification
	{
		return Notification::make('unpublished')
			->title('Successfully unpublished the mail template.')
			->success();
	}

	public static function mailTemplateUnpublishedFailed(): Notification
	{
		return Notification::make('unpublished')
			->title('Failed to unpublish the mail template.')
			->danger();
	}
}
