<?php

/**
 * We don't care for unhandled exceptions in tests.
 * It is the nature of a test to throw an exception.
 * Without this suppression we had 100+ Linter warning in this file which
 * don't help anything.
 *
 * @noinspection PhpDocMissingThrowsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

namespace Tests\Feature_v2\Statistics;

use LycheeVerify\Http\Middleware\VerifySupporterStatus;
use Tests\Feature_v2\Base\BaseApiV2Test;

class TotalAlbumSpaceTest extends BaseApiV2Test
{
	public function testTotalAlbumSpaceTestUnauthorized(): void
	{
		$response = $this->getJson('Statistics::totalAlbumSpace');
		$this->assertSupporterRequired($response);

		$response = $this->withoutMiddleware(VerifySupporterStatus::class)->getJson('Statistics::totalAlbumSpace');
		$this->assertUnauthorized($response);
	}

	public function testTotalAlbumSpaceTestAuthorized(): void
	{
		$response = $this->withoutMiddleware(VerifySupporterStatus::class)->actingAs($this->userMayUpload1)->getJson('Statistics::totalAlbumSpace');
		$this->assertOk($response);
		$this->assertCount(2, $response->json());
		$this->assertEquals($this->album1->title, $response->json()[0]['title']);
		$this->assertEquals($this->subAlbum1->title, $response->json()[1]['title']);

		$response = $this->withoutMiddleware(VerifySupporterStatus::class)->actingAs($this->userMayUpload1)->getJson('Statistics::totalAlbumSpace?album_id=' . $this->album1->id);
		$this->assertOk($response);
		$this->assertCount(1, $response->json());
		$this->assertEquals($this->album1->title, $response->json()[0]['title']);

		$response = $this->withoutMiddleware(VerifySupporterStatus::class)->actingAs($this->admin)->getJson('Statistics::totalAlbumSpace');
		$this->assertOk($response);
		$this->assertCount(7, $response->json());
	}
}