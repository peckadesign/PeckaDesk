<?php declare(strict_types = 1);

namespace PeckaDesk\Dashboard;

final class Translator implements \Nette\Localization\ITranslator
{

	/**
	 * @var array<string, string>
	 */
	private array $langs;


	/**
	 * @param array<string, string> $langs
	 */
	public function __construct(array $langs)
	{
		$this->langs = $langs;
	}


	/**
	 * @param string $message
	 * @param mixed ...$parameters
	 */
	public function translate($message, ...$parameters): string
	{
		return $this->langs[$message] ?? $message;
	}

}
