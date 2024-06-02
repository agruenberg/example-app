<?php

namespace App\Actions;
use App\Notifications\MailNotifications;
use App\Providers\MailServiceProvider;
use Filament\Tables\Actions\Action;

class UnpublishMailAction extends Action
{
	public static function getDefaultName(): ?string {
		return 'unpublishEmail';
	}

	protected function setUp(): void {
		parent::setUp();

		$this->label(fn ($record) => 'Unpublish template ID: '.$record->id);
		$this->action(function ($record) {
			if (MailServiceProvider::unpublishMailTemplate($record)) {
				MailNotifications::mailTemplateunpublishedSuccess()->send();
			} else {
				MailNotifications::mailTemplateUnpublishedFailed()->send();
			}
		});
	}
}
