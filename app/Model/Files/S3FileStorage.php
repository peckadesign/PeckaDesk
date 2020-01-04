<?php declare(strict_types = 1);

namespace PeckaDesk\Model\Files;

final class S3FileStorage implements FileStorageInterface
{

	private \Aws\S3\S3ClientInterface $s3Client;


	public function __construct(\Aws\S3\S3ClientInterface $s3Client)
	{
		$this->s3Client = $s3Client;
	}


	public function save(File $file, \Nette\Http\FileUpload $fileUpload): void
	{
		$result = $this->s3Client->upload('peckadesk', (string) $file->getId(), $fileUpload->getContents());
	}


	public function get(File $file): ?string
	{
		/** @var \Aws\Result $result */
		$result = $this->s3Client->getObject(['Bucket' => 'peckadesk', 'Key' => $file->getId()]);

		return (string) $result->get('Body');
	}

}
