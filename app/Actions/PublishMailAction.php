<?php

namespace App\Actions;

use App\Notifications\MailNotifications;
use App\Providers\MailServiceProvider;
use Filament\Tables\Actions\Action;

class PublishMailAction extends Action
{
	public static function getDefaultName(): ?string
	{
		return 'publishEmail';
	}

	protected function setUp(): void
	{
		parent::setUp();
		$this->label(fn ($record) => 'Publish template ID: '.$record->id);
		$this->action(static function ($record) {
			if (MailServiceProvider::publishMailTemplate($record)) {
				MailNotifications::mailTemplatePublishedSuccess()->send();
			} else {
				MailNotifications::mailTemplatePublishedFailed()->send();
			}
		});
	}
}
